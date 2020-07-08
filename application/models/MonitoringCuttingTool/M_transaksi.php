<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_transaksi extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getdataBaru() {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT item
                        ,description 
                FROM 
                (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        ,msib.MINIMUM_ORDER_QUANTITY moq , msib.PREPROCESSING_LEAD_TIME,msib.FULL_LEAD_TIME,msib.POSTPROCESSING_LEAD_TIME 
                        ,NVL (SUM (moqd.primary_transaction_quantity), 0) qty_onhand
                FROM mtl_system_items_b msib,
                        mtl_onhand_quantities_detail moqd,
                        mtl_item_locations mil
                WHERE msib.organization_id = 102
                    AND msib.inventory_item_id = moqd.inventory_item_id
                    AND msib.organization_id = moqd.organization_id
                    AND moqd.subinventory_code = 'TR-TKS'
                    AND moqd.locator_id = mil.inventory_location_id
                    AND mil.inventory_location_id = 1131
                    AND msib.SEGMENT1 not like '%-R'
                    AND msib.SEGMENT1 not like '%-T'
                GROUP BY msib.inventory_item_id, msib.segment1, msib.description, msib.PREPROCESSING_LEAD_TIME ,msib.FULL_LEAD_TIME ,msib.POSTPROCESSING_LEAD_TIME )
                ORDER BY item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getdataResharp() {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT item
                        ,description 
                FROM 
                (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        ,msib.MINIMUM_ORDER_QUANTITY moq , msib.PREPROCESSING_LEAD_TIME,msib.FULL_LEAD_TIME,msib.POSTPROCESSING_LEAD_TIME 
                        ,NVL (SUM (moqd.primary_transaction_quantity), 0) qty_onhand
                FROM mtl_system_items_b msib,
                        mtl_onhand_quantities_detail moqd,
                        mtl_item_locations mil
                WHERE msib.organization_id = 102
                    AND msib.inventory_item_id = moqd.inventory_item_id
                    AND msib.organization_id = moqd.organization_id
                    AND moqd.subinventory_code = 'TR-TKS'
                    AND moqd.locator_id = mil.inventory_location_id
                    AND mil.inventory_location_id = 1131
                    AND msib.SEGMENT1 like '%-R'
                GROUP BY msib.inventory_item_id, msib.segment1, msib.description, msib.PREPROCESSING_LEAD_TIME ,msib.FULL_LEAD_TIME ,msib.POSTPROCESSING_LEAD_TIME )
                ORDER BY item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getdataTumpul() {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT item
                        ,description 
                FROM 
                (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        ,msib.MINIMUM_ORDER_QUANTITY moq , msib.PREPROCESSING_LEAD_TIME,msib.FULL_LEAD_TIME,msib.POSTPROCESSING_LEAD_TIME 
                        ,NVL (SUM (moqd.primary_transaction_quantity), 0) qty_onhand
                FROM mtl_system_items_b msib,
                        mtl_onhand_quantities_detail moqd,
                        mtl_item_locations mil
                WHERE msib.organization_id = 102
                    AND msib.inventory_item_id = moqd.inventory_item_id
                    AND msib.organization_id = moqd.organization_id
                    AND moqd.subinventory_code = 'TR-TKS'
                    AND moqd.locator_id = mil.inventory_location_id
                    AND mil.inventory_location_id = 1131
                    AND msib.SEGMENT1 like '%-T'
                GROUP BY msib.inventory_item_id, msib.segment1, msib.description, msib.PREPROCESSING_LEAD_TIME ,msib.FULL_LEAD_TIME ,msib.POSTPROCESSING_LEAD_TIME )
                ORDER BY item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getdetailIN($bln, $item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT msib.segment1, msib.description 
                        ,mmt.TRANSACTION_QUANTITY ,mmt.TRANSACTION_UOM ,mmt.TRANSACTION_SOURCE_NAME
                        ,to_char(mmt.CREATION_DATE, 'DD/MM/YYYY HH24:MI:SS') CREATION_DATE
                        ,to_char(mmt.LAST_UPDATE_DATE, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATE_DATE
                FROM mtl_system_items_b msib, mtl_material_transactions mmt
                WHERE msib.inventory_item_id = mmt.inventory_item_id
                    AND msib.organization_id = mmt.organization_id
                    AND mmt.TRANSACTION_QUANTITY > 0
                    AND mmt.subinventory_code = 'TR-TKS'
                    AND TO_CHAR(mmt.transaction_date, 'Mon-YYYY') = '$bln'
                    AND msib.SEGMENT1 = '$item'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getdetailOUT($bln, $item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT msib.segment1, msib.description 
                        ,mmt.TRANSACTION_QUANTITY ,mmt.TRANSACTION_UOM ,mmt.TRANSACTION_SOURCE_NAME
                        ,to_char(mmt.CREATION_DATE, 'DD/MM/YYYY HH24:MI:SS') CREATION_DATE
                        ,to_char(mmt.LAST_UPDATE_DATE, 'DD/MM/YYYY HH24:MI:SS') LAST_UPDATE_DATE
                FROM mtl_system_items_b msib, mtl_material_transactions mmt
                WHERE msib.inventory_item_id = mmt.inventory_item_id
                    AND msib.organization_id = mmt.organization_id
                    AND mmt.TRANSACTION_QUANTITY < 0
                    AND mmt.subinventory_code = 'TR-TKS'
                    AND TO_CHAR(mmt.transaction_date, 'Mon-YYYY') = '$bln'
                    AND msib.SEGMENT1 = '$item'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    
    public function cariin() {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT it.item ,it.description 
                        ,tot_in.in_total total_in
                        ,tot_in.bulan
                FROM 
                        --SUBQUERY ITEM --SESUAIKAN ITEM TAMPIL DISINI
                        (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        FROM mtl_system_items_b msib,
                                mtl_onhand_quantities_detail moqd,
                                mtl_item_locations mil
                        WHERE msib.organization_id = 102
                            AND msib.inventory_item_id = moqd.inventory_item_id
                            AND msib.organization_id = moqd.organization_id
                            AND moqd.subinventory_code = 'TR-TKS'
                            AND moqd.locator_id = mil.inventory_location_id
                            AND mil.inventory_location_id = 1131
                            --AND msib.segment1 = ''
                        --   AND msib.SEGMENT1 not like '%-T'
                        GROUP BY msib.inventory_item_id, msib.segment1, msib.description) it
                        --SUBQUERY TOTAL TRANSAKSI MASUK
                        ,(select kode, bulan, NVL(SUM(total_in),0) in_total
                            FROM
                            (SELECT msib.segment1 kode, TO_CHAR(mmt.transaction_date, 'MM-YYYY') bulan , NVL(SUM(mmt.TRANSACTION_QUANTITY),0) total_in
                        FROM mtl_system_items_b msib, mtl_material_transactions mmt
                        WHERE msib.inventory_item_id = mmt.inventory_item_id
                            AND msib.organization_id = mmt.organization_id
                            AND mmt.TRANSACTION_QUANTITY > 0
                            AND mmt.subinventory_code = 'TR-TKS'
                            AND TO_CHAR(mmt.transaction_date, 'YYYY') = to_char(sysdate, 'YYYY')
                        group by msib.SEGMENT1, mmt.TRANSACTION_DATE)
                        group by kode, bulan
                        order by kode, bulan) tot_in
                where it.item = tot_in.kode
                ORDER BY it.item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function cariout() {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT it.item ,it.description 
                        ,tot_out.out_total total_out
                        ,tot_out.bulan
                FROM 
                        --SUBQUERY ITEM --SESUAIKAN ITEM TAMPIL DISINI
                        (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        FROM mtl_system_items_b msib,
                                mtl_onhand_quantities_detail moqd,
                                mtl_item_locations mil
                        WHERE msib.organization_id = 102
                            AND msib.inventory_item_id = moqd.inventory_item_id
                            AND msib.organization_id = moqd.organization_id
                            AND moqd.subinventory_code = 'TR-TKS'
                            AND moqd.locator_id = mil.inventory_location_id
                            AND mil.inventory_location_id = 1131
                            --AND msib.segment1 = ''
                        --   AND msib.SEGMENT1 not like '%-T'
                        GROUP BY msib.inventory_item_id, msib.segment1, msib.description) it
                        --SUBQUERY TOTAL TRANSAKSI KELUAR
                        ,(select kode, bulan, NVL(SUM(total_in),0) out_total
                            FROM
                            (SELECT msib.segment1 kode, TO_CHAR(mmt.transaction_date, 'MM-YYYY') bulan , NVL(SUM(mmt.TRANSACTION_QUANTITY),0) total_in
                        FROM mtl_system_items_b msib, mtl_material_transactions mmt
                        WHERE msib.inventory_item_id = mmt.inventory_item_id
                            AND msib.organization_id = mmt.organization_id
                            AND mmt.TRANSACTION_QUANTITY < 0
                            AND mmt.subinventory_code = 'TR-TKS'
                            AND TO_CHAR(mmt.transaction_date, 'YYYY') = to_char(sysdate, 'YYYY')
                        group by msib.SEGMENT1, mmt.TRANSACTION_DATE)
                        group by kode, bulan
                        order by kode, bulan) tot_out
                where it.item = tot_out.kode
                ORDER BY it.item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

}

