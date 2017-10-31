<?php
class M_dataplan extends CI_Model {

	public function __construct()
	{
		$this->load->database();
    $this->oracle = $this->load->database ( 'oracle', TRUE );
	}

	public function getDataPlan($id = FALSE, $sid = FALSE)
	{
		if ($id === FALSE && $sid === FALSE){
  		$this->db->select('*');
  		$this->db->from('pp.pp_daily_plans');
  		$this->db->order_by('priority, created_date', 'ASC');
    }elseif (!$sid == FALSE){
      $this->db->select("dp.*,(case when dp.achieve_qty>=dp.need_qty then 'OK' else 'NOT OK' end) status");
      $this->db->from('pp.pp_daily_plans dp');
      $this->db->where("
        (case when dp.achieve_qty is null then 0 else dp.achieve_qty end) < dp.need_qty AND dp.due_time between
        to_timestamp((to_char(date_trunc('month', current_date), 'DD-MM-YYYY') || ' 06:00:00'), 'DD-MM-YYYY HH24:MI:SS')
        and
        (
          case when to_char(current_timestamp, 'HH24:MI:SS') >= to_char(to_timestamp('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS')
            then to_timestamp((to_char(TIMESTAMP 'tomorrow', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
            else to_timestamp((to_char(TIMESTAMP 'today', 'DD-MM-YYYY') || ' 05:59:59'), 'DD-MM-YYYY HH24:MI:SS')
          END
        ) AND dp.section_id =", $sid);
      $this->db->order_by('dp.priority, status, dp.created_date', 'ASC');
   	}elseif (!$id == FALSE) {
      $this->db->select('*');
      $this->db->from('pp.pp_daily_plans');
      $this->db->where('daily_plan_id', $id);
      $this->db->order_by('priority, created_date', 'ASC');
    }
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getSection($id = FALSE, $section_id = FALSE)
  {
  	if ($id == FALSE) {
  		$this->db->select('*');
    	$this->db->from('pp.pp_section');
    	$this->db->order_by('section_id', 'ASC');
  	}elseif ($section_id == FALSE) {
  		$this->db->select('ps.*');
    	$this->db->from('pp.pp_section ps, pp.pp_user_group pug, pp.pp_user pu');
      $this->db->where('ps.section_id = pug.section_id AND pug.pp_user_id = pu.pp_user_id');
    	$this->db->where('pu.user_id', $id);
    	$this->db->order_by('ps.section_name', 'ASC');
  	}else{
      $this->db->select('ps.*');
      $this->db->from('pp.pp_section ps, pp.pp_user_group pug, pp.pp_user pu');
      $this->db->where('ps.section_id = pug.section_id AND pug.pp_user_id = pu.pp_user_id');
      $this->db->where('pu.user_id', $id);
      $this->db->where('ps.section_id', $section_id);
      $this->db->order_by('ps.section_name', 'ASC');
    }
  	$query = $this->db->get();
    return $query->result_array();
  }

  public function insertDataPlan($dataIns,$tbName)
  {
    $this->db->insert($tbName, $dataIns);
  }

  public function update($tbName,$colname,$data,$id)
  {
    $this->db->where($colname, $id);
    $this->db->update($tbName, $data);
  }

  public function getItemTransaction($job=FALSE,$invSrc,$invDst,$itemCode,$locatorID)
  {
    if ($job==FALSE) {
      $sql = "  SELECT
                  (SUM(MMT.TRANSACTION_QUANTITY)*-1) ACHIEVE_QTY,
                  TO_CHAR(MAX(MMT.TRANSACTION_DATE), 'DD-MON-YYYY HH24:MI:SS') LAST_DELIVERY
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                  AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                  AND MMT.ORGANIZATION_ID = 102
                  AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                  AND MMT.SUBINVENTORY_CODE = '$invSrc'
                  AND MMT.TRANSFER_SUBINVENTORY = '$invDst'
                  AND MSIB.SEGMENT1 = '$itemCode'
                  AND MMT.TRANSACTION_DATE BETWEEN
                    (CASE WHEN TO_CHAR(SYSDATE, 'HH24:MI:SS') >= TO_CHAR(TO_DATE('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS') THEN
                      (trunc(sysdate - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 6/24)
                    ELSE
                      (trunc(sysdate-1 - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 5.9998/24)
                    END)
                    AND
                    (CASE WHEN TO_CHAR(SYSDATE, 'HH24:MI:SS') >= TO_CHAR(TO_DATE('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS') THEN
                      (trunc(sysdate+1 - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 5.9998/24)
                    ELSE
                      (trunc(sysdate - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 6/24)
                    END)
                group by msib.SEGMENT1
                order by MSIB.segment1";
    }else{
      $sql = "  SELECT
                  SUM(MMT.TRANSACTION_QUANTITY) ACHIEVE_QTY,
                  TO_CHAR(MAX(MMT.TRANSACTION_DATE), 'DD-MON-YYYY HH24:MI:SS') LAST_DELIVERY
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                  AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                  AND MMT.ORGANIZATION_ID = 102
                  AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                  AND MMT.SUBINVENTORY_CODE = '$invDst'
                  AND MMT.LOCATOR_ID = $locatorID
                  AND MMT.TRANSACTION_TYPE_ID = 44
                  AND MSIB.SEGMENT1 = '$itemCode'
                  AND MMT.TRANSACTION_DATE BETWEEN
                    (CASE WHEN TO_CHAR(SYSDATE, 'HH24:MI:SS') >= TO_CHAR(TO_DATE('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS') THEN
                      (trunc(sysdate - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 6/24)
                    ELSE
                      (trunc(sysdate-1 - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 5.9998/24)
                    END)
                    AND
                    (CASE WHEN TO_CHAR(SYSDATE, 'HH24:MI:SS') >= TO_CHAR(TO_DATE('05:59:59', 'HH24:MI:SS'), 'HH24:MI:SS') THEN
                      (trunc(sysdate+1 - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 5.9998/24)
                    ELSE
                      (trunc(sysdate - 7/24) + trunc(to_char(sysdate - 7/24,'HH24')/12)/2 + 6/24)
                    END)
                group by msib.SEGMENT1
                order by MSIB.segment1";
    }

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getMonthlyPlan($id=FALSE)
  {
    if ($id==FALSE) {
      $this->db->select('*');
      $this->db->from('pp.pp_monthly_plans pmp, pp.pp_section ps');
      $this->db->where('pmp.section_id = ps.section_id');
    }else{
      $this->db->select('*');
      $this->db->from('pp.pp_monthly_plans pmp, pp.pp_section ps');
      $this->db->where('pmp.section_id = ps.section_id and pmp.monthly_plan_id = ', $id);
    }
    $this->db->order_by('pmp.plan_time, ps.section_name ASC');

    $query = $this->db->get();
    return $query->result_array();
  }
}