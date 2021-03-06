<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_lihatstock extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getData($tglAwl, $tglAkh, $sub, $kode, $qty, $unit) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT *
        FROM (SELECT   aa.item, aa.description, aa.uom,
                       NVL (SUM (aa.qty_in), 0) sum_qty_in,
                       NVL (SUM (aa.qty_out), 0) sum_qty_out,
                       NVL (SUM (aa.qty_out1), 0) sum_qty_out1, aa.onhand, aa.att, aa.MIN,
                       aa.MAX, aa.subinv, aa.lokasi
                  FROM (SELECT msib.segment1 item, msib.description,
                               mmt.transaction_uom uom,
                               (SELECT SUM (mmt_in.transaction_quantity)
                                  FROM mtl_material_transactions mmt_in
                                 WHERE mmt_in.transaction_id = mmt.transaction_id
                                   AND mmt_in.transaction_quantity NOT LIKE '-%') qty_in,
                               (SELECT SUM (mmt_out.transaction_quantity * -1)
                                  FROM mtl_material_transactions mmt_out
                                 WHERE mmt_out.transaction_id = mmt.transaction_id
                                   AND mmt_out.transaction_quantity LIKE '-%') qty_out,
                               (SELECT SUM (mmt_out.transaction_quantity)
                                  FROM mtl_material_transactions mmt_out
                                 WHERE mmt_out.transaction_id = mmt.transaction_id
                                   AND mmt_out.transaction_quantity LIKE '-%') qty_out1,
                               khs_inv_qty_oh (mmt.organization_id, mmt.inventory_item_id, mmt.subinventory_code, NULL, NULL) onhand,
                               khs_inv_qty_att (mmt.organization_id, mmt.inventory_item_id, mmt.subinventory_code, NULL, NULL) att,
                               ksm.MIN, ksm.MAX, mmt.subinventory_code subinv,
                               mmt.transaction_date, mmt.transaction_type_id,
                               mtt.transaction_type_name,
                               mmt.transaction_source_type_id,
                               mtst.transaction_source_type_name,
                               fu.user_name transact_by,
                               (SELECT lok.lokasi
                                  FROM khsinvlokasisimpan lok
                                 WHERE mmt.inventory_item_id = lok.inventory_item_id
                                   AND mmt.subinventory_code = lok.subinv
                                   AND ROWNUM = 1) lokasi
                          FROM mtl_system_items_b msib,
                               mtl_material_transactions mmt,
                               fnd_user fu,
                               mtl_transaction_types mtt,
                               mtl_txn_source_types mtst,
                               khs_sp_minmax ksm
                         WHERE msib.inventory_item_status_code = 'Active'
                           AND msib.organization_id = mmt.organization_id
                           AND msib.inventory_item_id = mmt.inventory_item_id
                           AND mmt.last_updated_by = fu.user_id
                           AND mmt.transaction_type_id = mtt.transaction_type_id
                           AND mtst.transaction_source_type_id = mmt.transaction_source_type_id
                           AND msib.segment1 = ksm.item(+)
                           --AND khs_inv_qty_oh (mmt.organization_id, mmt.inventory_item_id, mmt.subinventory_code, NULL, NULL) <> 0
                           --
                           AND TRUNC(mmt.transaction_date) BETWEEN to_date('$tglAwl','DD/MM/RR') and to_date('$tglAkh','DD/MM/RR') 
                           AND mmt.subinventory_code = '$sub' --subinventory
                           $kode $unit
                       ) aa
              GROUP BY aa.item,
                       aa.description,
                       aa.uom,
                       aa.onhand,
                       aa.att,
                       aa.MIN,
                       aa.MAX,
                       aa.subinv,
                       aa.lokasi
              UNION
              SELECT msib.segment1 item, msib.description,
                     msib.primary_uom_code uom, NVL (NULL, 0) sum_qty_in,
                     NVL (NULL, 0) sum_qty_out,NVL (NULL, 0) sum_qty_out1,
                     khs_inv_qty_oh (msib.organization_id, msib.inventory_item_id, msi.secondary_inventory_name, NULL, NULL) onhand,
                     khs_inv_qty_att (msib.organization_id, msib.inventory_item_id, msi.secondary_inventory_name, NULL, NULL) att,
                     ksm.MIN, ksm.MAX, msi.secondary_inventory_name subinv,
                     (SELECT lok.lokasi
                        FROM khsinvlokasisimpan lok
                       WHERE msib.inventory_item_id = lok.inventory_item_id
                         AND msi.secondary_inventory_name = lok.subinv
                         AND ROWNUM = 1) lokasi
                FROM mtl_system_items_b msib,
                     mtl_secondary_inventories msi,
                     khs_sp_minmax ksm
               WHERE msib.inventory_item_status_code = 'Active'
                 AND msi.secondary_inventory_name = '$sub' --subinventory
                 $kode $unit
                 AND msib.organization_id = msi.organization_id
                 AND msib.segment1 = ksm.item(+)
                -- AND khs_inv_qty_oh (msib.organization_id, msib.inventory_item_id, msi.secondary_inventory_name, NULL, NULL) <> 0
                 AND msib.inventory_item_id NOT IN (
                        SELECT mmt.inventory_item_id
                          FROM mtl_material_transactions mmt
                         WHERE TRUNC(mmt.transaction_date) BETWEEN to_date('$tglAwl','DD/MM/RR') and to_date('$tglAkh','DD/MM/RR') 
                           AND mmt.subinventory_code = '$sub'))
                $qty";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    
    public function getKodeUnit($subinv){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct kategori 
                from khs_sp_kode_unit 
                where subinventory = '$subinv'
                order by kategori";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataKodeUnit($tglawal, $tglakhir, $subinv, $kategori) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT *
                FROM (SELECT   aa.item, aa.description, aa.uom,
                            NVL (SUM (aa.qty_in), 0) sum_qty_in,
                            NVL (SUM (aa.qty_out), 0) sum_qty_out,
                            NVL (SUM (aa.qty_out1), 0) sum_qty_out1, aa.onhand, aa.att,
                            aa.MIN, aa.MAX, aa.subinv, aa.lokasi, aa.qty_unit
                        FROM (
                        SELECT msib.segment1 item, msib.description,
                                    mmt.transaction_uom uom,
                                    (SELECT SUM (mmt_in.transaction_quantity)
                                        FROM mtl_material_transactions mmt_in
                                        WHERE mmt_in.transaction_id = mmt.transaction_id
                                        AND mmt_in.transaction_quantity NOT LIKE '-%') qty_in,
                                    (SELECT SUM (mmt_out.transaction_quantity * -1)
                                        FROM mtl_material_transactions mmt_out
                                        WHERE mmt_out.transaction_id = mmt.transaction_id
                                        AND mmt_out.transaction_quantity LIKE '-%') qty_out,
                                    (SELECT SUM (mmt_out.transaction_quantity)
                                        FROM mtl_material_transactions mmt_out
                                        WHERE mmt_out.transaction_id = mmt.transaction_id
                                        AND mmt_out.transaction_quantity LIKE '-%') qty_out1,
                                    khs_inv_qty_oh (mmt.organization_id, mmt.inventory_item_id, mmt.subinventory_code, NULL, NULL) onhand,
                                    khs_inv_qty_att (mmt.organization_id, mmt.inventory_item_id, mmt.subinventory_code, NULL, NULL) att,
                                    ksm.MIN, ksm.MAX, mmt.subinventory_code subinv,
                                    mmt.transaction_date, mmt.transaction_type_id,
                                    mtt.transaction_type_name,
                                    mmt.transaction_source_type_id,
                                    mtst.transaction_source_type_name,
                                    fu.user_name transact_by,
                                    (SELECT lok.lokasi
                                        FROM khsinvlokasisimpan lok
                                        WHERE mmt.inventory_item_id =
                                                            lok.inventory_item_id
                                        AND mmt.subinventory_code = lok.subinv
                                        AND ROWNUM = 1) lokasi,
                                    ksku.qty_unit
                                FROM mtl_system_items_b msib,
                                    mtl_material_transactions mmt,
                                    fnd_user fu,
                                    mtl_transaction_types mtt,
                                    mtl_txn_source_types mtst,
                                    khs_sp_minmax ksm,
                                    (select distinct kategori, kode_item, qty_unit from khs_sp_kode_unit) ksku
            --                         khs_sp_kode_unit ksku
                                WHERE msib.inventory_item_status_code = 'Active'
                                AND msib.organization_id = mmt.organization_id
                                AND msib.inventory_item_id = mmt.inventory_item_id
                                AND mmt.last_updated_by = fu.user_id
                                AND mmt.transaction_type_id = mtt.transaction_type_id
                                AND mtst.transaction_source_type_id =
                                                            mmt.transaction_source_type_id
                                AND msib.segment1 = ksm.item(+)
                                --AND khs_inv_qty_oh (mmt.organization_id, mmt.inventory_item_id, mmt.subinventory_code, NULL, NULL)  0
                                --
                                AND TRUNC (mmt.transaction_date)
                                        BETWEEN TO_DATE ('$tglawal', 'DD/MM/RR')
                                            AND TO_DATE ('$tglakhir', 'DD/MM/RR')
                                AND mmt.subinventory_code = '$subinv'        --subinventory
                                AND msib.segment1 = ksku.kode_item
            --                     AND mmt.subinventory_code = ksku.subinventory
                                AND ksku.kategori = '$kategori'
                                ) aa
                    GROUP BY aa.item,
                            aa.description,
                            aa.uom,
                            aa.onhand,
                            aa.att,
                            aa.MIN,
                            aa.MAX,
                            aa.subinv,
                            aa.lokasi,
                            aa.qty_unit
                    UNION
                    SELECT msib.segment1 item, msib.description,
                            msib.primary_uom_code uom, NVL (NULL, 0) sum_qty_in,
                            NVL (NULL, 0) sum_qty_out, NVL (NULL, 0) sum_qty_out1,
                            khs_inv_qty_oh (msib.organization_id, msib.inventory_item_id, msi.secondary_inventory_name, NULL, NULL) onhand,
                            khs_inv_qty_att (msib.organization_id, msib.inventory_item_id, msi.secondary_inventory_name, NULL, NULL) att,
                            ksm.MIN, ksm.MAX, msi.secondary_inventory_name subinv,
                            (SELECT lok.lokasi
                                FROM khsinvlokasisimpan lok
                            WHERE msib.inventory_item_id = lok.inventory_item_id
                                AND msi.secondary_inventory_name = lok.subinv
                                AND ROWNUM = 1) lokasi,
                            ksku.qty_unit
                        FROM mtl_system_items_b msib,
                            mtl_secondary_inventories msi,
                            khs_sp_minmax ksm,
                            (select distinct kategori, kode_item, qty_unit from khs_sp_kode_unit) ksku
                    WHERE msib.inventory_item_status_code = 'Active'
                        AND msi.secondary_inventory_name = '$subinv'           --subinventory
                        AND msib.organization_id = msi.organization_id
                        AND msib.segment1 = ksm.item(+)
                        AND msib.inventory_item_id NOT IN (
                                SELECT mmt.inventory_item_id
                                FROM mtl_material_transactions mmt
                                WHERE TRUNC (mmt.transaction_date)
                                        BETWEEN TO_DATE ('$tglawal', 'DD/MM/RR')
                                            AND TO_DATE ('$tglakhir', 'DD/MM/RR')
                                AND mmt.subinventory_code = '$subinv')
                        AND msib.segment1 = ksku.kode_item
                        AND ksku.kategori = '$kategori')";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function getKodeBarang($term, $sub) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT msib.segment1 item, msib.description,
                        msib.segment1||' - '||msib.description     product_desc,
                    khs_inv_qty_oh (msib.organization_id, msib.inventory_item_id, msi.secondary_inventory_name, NULL, NULL) onhand
                FROM mtl_system_items_b msib, mtl_secondary_inventories msi
                WHERE msib.organization_id = msi.organization_id
                AND msib.segment1||' - '||msib.description LIKE '%$term%'
                AND msi.secondary_inventory_name = '$sub'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function getNamaBarang($term) {
        $oracle = $this->load->database('oracle', true);
        $sql = "select msib.segment1, msib.description
                from mtl_system_items_b msib
                where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and msib.organization_id = 81
                AND msib.segment1 = '$term'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function getSubinv($term) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT msi.secondary_inventory_name sub_inv_code,
                        msi.description sub_inv_desc
                FROM mtl_secondary_inventories msi
                WHERE msi.secondary_inventory_name LIKE '%$term%'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }

    public function getHistory($tglAwl, $tglAkh, $sub, $kode) {
        $oracle = $this->load->database('oracle', true);
        $sql = "SELECT msib.segment1 item, msib.description, mmt.transaction_uom uom,
                        (SELECT SUM (mmt_in.transaction_quantity)
                        FROM mtl_material_transactions mmt_in
                        WHERE mmt_in.transaction_id = mmt.transaction_id
                            AND mmt_in.transaction_quantity NOT LIKE '-%') qty_in,
                        (SELECT SUM (mmt_out.transaction_quantity*-1)
                                    FROM mtl_material_transactions mmt_out
                                    WHERE mmt_out.transaction_id = mmt.transaction_id
                                    AND mmt_out.transaction_quantity LIKE '-%') qty_out_mmt,
                        (SELECT SUM (mmt_out.transaction_quantity)
                        FROM mtl_material_transactions mmt_out
                        WHERE mmt_out.transaction_id = mmt.transaction_id
                            AND mmt_out.transaction_quantity LIKE '-%') qty_out,
                        khs_inv_qty_oh (mmt.organization_id, mmt.inventory_item_id, '$sub', NULL, NULL) onhand,
                        mmt.subinventory_code subinv, mmt.transaction_date,
                        NVL
                        (mmt.transaction_source_name,
                            (CASE
                                WHEN mmt.transaction_type_id IN
                                    (64, 51, 136, 137, 138, 139, 140, 141, 142, 143, 202,
                                        286, 327)
                                THEN (SELECT mtrh.request_number
                                        FROM mtl_txn_request_headers mtrh,
                                                mtl_txn_request_lines mtrl
                                        WHERE mmt.move_order_line_id = mtrl.line_id
                                            AND mtrl.header_id = mtrh.header_id)
                                WHEN mmt.transaction_type_id IN (18)
                                THEN (SELECT segment1
                                        FROM po_headers_all pha, rcv_transactions rt
                                        WHERE pha.po_header_id = rt.po_header_id
                                            AND rt.transaction_id = mmt.rcv_transaction_id)
                                WHEN mmt.transaction_type_id IN (12)
                                THEN (SELECT rsh.receipt_num
                                        FROM rcv_transactions rt, rcv_shipment_headers rsh
                                        WHERE mmt.rcv_transaction_id = rt.transaction_id
                                            AND rt.shipment_header_id = rsh.shipment_header_id)
                                WHEN mmt.transaction_type_id IN (33, 52)
                                THEN (SELECT concatenated_segments
                                        FROM mtl_sales_orders_kfv mso
                                        WHERE mso.sales_order_id = mmt.transaction_source_id)
                --            WHEN mmt.TRANSACTION_SOURCE_NAME is not null
                --            THEN mmt.TRANSACTION_SOURCE_NAME
                            ELSE (SELECT REPLACE (wsm.transaction_source, 'BATCH', '')
                                    FROM wsm_inv_txns_wip_lots_v wsm
                                    WHERE mmt.subinventory_code = wsm.subinventory_code
                                    AND mmt.transaction_id = wsm.transaction_id)
                            END
                            )
                        ) no_bukti,
                        mmt.transaction_type_id, mtt.transaction_type_name,
                        mmt.transaction_source_type_id, mtst.transaction_source_type_name,
                        fu.user_name transact_by
                FROM mtl_system_items_b msib,
                        mtl_material_transactions mmt,
                        fnd_user fu,
                        mtl_transaction_types mtt,
                        mtl_txn_source_types mtst
                WHERE msib.inventory_item_status_code = 'Active'
                    AND msib.organization_id = mmt.organization_id
                    AND msib.inventory_item_id = mmt.inventory_item_id
                    AND mmt.last_updated_by = fu.user_id
                    AND mmt.transaction_type_id = mtt.transaction_type_id
                    AND mtst.transaction_source_type_id = mmt.transaction_source_type_id
                    --
                    AND TRUNC(mmt.transaction_date) between to_date('$tglAwl','DD/MM/RR') and to_date('$tglAkh','DD/MM/RR') --periode
                    AND mmt.subinventory_code = '$sub'                        --subinventory
                    AND msib.segment1 = '$kode'                                   --item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function kodeUnit(){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct 
                        ffvv.FLEX_VALUE unit
                    ,ffvv.DESCRIPTION
                from fnd_flex_values_vl ffvv
                    ,mtl_system_items_b msib
                where substr(msib.SEGMENT1,1,3) = ffvv.FLEX_VALUE
                and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and msib.ORGANIZATION_ID = 81
                and ffvv.FLEX_VALUE_SET_ID = 1013710
                and msib.PRIMARY_UOM_CODE = 'UNT'
                order by 1";           
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function lokasi_simpan($term,$sub){
        $oracle = $this->load->database('oracle', true);
        $sql = "select distinct subinv, lokasi
                from khsinvlokasisimpan
                where subinv = '$sub'
                and lokasi like '%$term%'
                order by 2";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getdataPeti($param){
        $mysql = $this->load->database('khs_packing', true);
        $sql = "select * from sp_monitoring_peti $param";
        $query = $mysql->query($sql);
        return $query->result_array();
    }

    public function saveJmlPeti($item, $jml){
        $mysql = $this->load->database('khs_packing', true);
        $sql = "insert into sp_monitoring_peti (kode, peti)
                values('$item', $jml)";
        $query = $mysql->query($sql);
    }
    
    public function updatePeti($item, $jml){
        $mysql = $this->load->database('khs_packing', true);
        $sql = "update sp_monitoring_peti set peti = $jml where kode = '$item'";
        $query = $mysql->query($sql);
    }
    
    public function deletePeti($item){
        $mysql = $this->load->database('khs_packing', true);
        $sql = "delete from sp_monitoring_peti where kode = '$item'";
        $query = $mysql->query($sql);
    }
    
    public function getseksi($user){
        $oracle = $this->load->database('personalia',true);
        $sql = "select ts.seksi, ts.unit, tp.nama
                from hrd_khs.tseksi ts, hrd_khs.tpribadi tp
                where tp.kodesie = ts.kodesie
                and tp.noind = '$user'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

}
