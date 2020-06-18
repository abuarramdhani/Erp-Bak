<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_transact extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();  
        $this->oracle = $this->load->database('oracle', true);
    }

    public function getData($date1, $date2, $sub, $kode_brg, $kode_awal){
        $sql = "SELECT *
                FROM (SELECT   aa.item, aa.description, aa.uom, SUM (aa.qty_in) sum_qty_in,
                            SUM (aa.qty_out) sum_qty_out, 
                            SUM(aa.qty_out_aktual) qty_out_aktual, aa.onhand, aa.subinv
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
                                        AND mmt_out.transaction_quantity LIKE '-%') qty_out_aktual,
                                    khs_inv_qty_oh (mmt.organization_id, mmt.inventory_item_id, '$sub', NULL, NULL) onhand,
                                    mmt.subinventory_code subinv, mmt.transaction_date,
                                    mmt.transaction_type_id, mtt.transaction_type_name,
                                    mmt.transaction_source_type_id,
                                    mtst.transaction_source_type_name,
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
                                AND mmt.transaction_date BETWEEN to_date('$date1','DD/MM/RR') and to_date('$date2','DD/MM/RR') 
                                AND mmt.subinventory_code = '$sub' --subinventory
                                $kode_brg $kode_awal
                            ) aa
                    GROUP BY aa.item, aa.description, aa.uom, aa.onhand, aa.subinv)";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
}