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
      $this->db->select('*');
      $this->db->from('pp.pp_daily_plans');
      $this->db->where('section_id', $sid);
      $this->db->order_by('priority, created_date', 'ASC');
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

  public function insertDataPlan($dataIns)
  {
    $this->db->insert('pp.pp_daily_plans', $dataIns);
  }

  public function update($data,$id)
  {
    $this->db->where('daily_plan_id', $id);
    $this->db->update('pp.pp_daily_plans', $data);
  }

  public function getItemTransaction($job=FALSE,$invSrc,$invDst,$itemCode,$locatorID)
  {
    if ($job==FALSE) {
      $sql = "  SELECT
                  (SUM(MMT.TRANSACTION_QUANTITY)*-1) ACHIEVE_QTY,
                  MAX(MMT.TRANSACTION_DATE) LAST_DELIVERY
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
                  MAX(MMT.TRANSACTION_DATE) LAST_DELIVERY
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                  AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                  AND MMT.ORGANIZATION_ID = 102
                  AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                  AND MMT.SUBINVENTORY_CODE = '$invDst'
                  AND MMT.LOCATOR_ID = 34
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

  // public function getPlanMonthly()
  // {
  //   $sql = "SELECT
  //             to_char(dp.created_date, 'dd') as date,
  //             to_char(dp.created_date, 'Mon') as mon,
  //             extract(year from dp.created_date) as yyyy,
  //             count(*) as plan
  //           FROM pp.pp_daily_plans dp
  //           WHERE dp.section_id = 9
  //           GROUP BY 1,2,3";
            
  //   $query = $this->db->query($sql);
  //   return $query->result_array();
  // }
}