<?php
class M_mgc extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    // $this->oracle = $this->load->database('oracle_dev', true);
    $this->oracle = $this->load->database('oracle', true);
    $this->personalia = $this->load->database('personalia', true);
  }
  public function get()
  {
    return $this->oracle->query("SELECT  msib.segment1 kode, msib.description, msib.inventory_item_id,
                                 msib.min_minmax_quantity min_stok, msib.max_minmax_quantity max_stok,
                                 floor (SUM (moqd.transaction_quantity)) stok
                              -- (SELECT SUM (mmt.transaction_quantity * -1)
                              --    FROM mtl_material_transactions mmt
                              --   WHERE msib.organization_id = mmt.organization_id
                              --     AND msib.inventory_item_id = mmt.inventory_item_id
                              --     AND TO_CHAR (mmt.transaction_date, 'Mon-YY') =
                              --                                             TO_CHAR (SYSDATE, 'Mon-YY')
                              --     AND mmt.subinventory_code = 'PNL-TKS'
                              --     AND mmt.transaction_quantity LIKE '-%') aktual_out,
                              -- (SELECT SUM (mmt.transaction_quantity)
                              --    FROM mtl_material_transactions mmt
                              --   WHERE msib.organization_id = mmt.organization_id
                              --     AND msib.inventory_item_id = mmt.inventory_item_id
                              --     AND TO_CHAR (mmt.transaction_date, 'Mon-YY') =
                              --                                             TO_CHAR (SYSDATE, 'Mon-YY')
                              --     AND mmt.subinventory_code = 'PNL-TKS'
                              --     AND mmt.transaction_quantity NOT LIKE '-%') aktual_in
                        FROM     mtl_system_items_b msib, mtl_onhand_quantities_detail moqd
                           WHERE msib.inventory_item_status_code = 'Active'
                             AND msib.organization_id = 102
                             AND msib.organization_id = moqd.organization_id
                             AND msib.inventory_item_id = moqd.inventory_item_id
                             AND moqd.subinventory_code = 'PNL-TKS'
                        GROUP BY msib.segment1,
                                 msib.description,
                                 msib.inventory_item_id,
                                 msib.min_minmax_quantity,
                                 msib.max_minmax_quantity
                                 -- and rownum <= 10")->result_array();
  }
  public function data_range(){
    return $this->oracle->query("SELECT mp.PLAN_ID, mp.COMPILE_DESIGNATOR
                          from msc_plans mp
                          where mp.ORGANIZATION_ID = 102
                          and mp.DATA_COMPLETION_DATE is not null")->result_array();
  }
  public function getpod($plan, $organization_id, $inventory_item_id)
  {
    return $this->oracle->query("SELECT floor(khs_ascp_month ($organization_id,
                    $inventory_item_id,
                    $plan,
                    TO_CHAR (SYSDATE, 'Mon-YY')
                  ))pod FROM DUAL")->row_array();
  }
  public function getout($organization_id, $inventory_item_id)
  {
    $getdata = $this->oracle->query("SELECT SUM (mmt.transaction_quantity * -1) aktual_out
                       FROM mtl_material_transactions mmt
                      WHERE mmt.organization_id = $organization_id
                        AND mmt.inventory_item_id = $inventory_item_id
                        AND TO_CHAR (mmt.transaction_date, 'Mon-YY') =
                            TO_CHAR (SYSDATE, 'Mon-YY')
                        AND mmt.subinventory_code = 'PNL-TKS'
                        AND mmt.transaction_quantity LIKE '-%'")->row_array();
    $data['AKTUAL_OUT'] = abs($getdata["AKTUAL_OUT"]);
    return $data;
  }
  public function getin($organization_id, $inventory_item_id)
  {
    return $this->oracle->query("SELECT SUM (mmt.transaction_quantity) aktual_in
                      FROM mtl_material_transactions mmt
                    WHERE mmt.organization_id = $organization_id
                      AND mmt.inventory_item_id = $inventory_item_id
                      AND TO_CHAR (mmt.transaction_date, 'Mon-YY') =
                          TO_CHAR (SYSDATE, 'Mon-YY')
                      AND mmt.subinventory_code = 'PNL-TKS'
                      AND mmt.transaction_quantity NOT LIKE '-%'")->row_array();
  }
}
