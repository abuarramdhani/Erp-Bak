<?php
class M_Ajax extends CI_Model {

	var $oracle;
    public function __construct()
    {
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
    }

    function getComponentCode($org_id,$sub_inv)
    {
      if ($sub_inv === FALSE) {
        $sql = "SELECT MSIB.SEGMENT1, MSIB.DESCRIPTION
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                AND MMT.ORGANIZATION_ID = $org_id
                AND MMT.TRANSACTION_DATE BETWEEN (select sysdate - 150 from dual) AND sysdate
                AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                group by msib.SEGMENT1, msib.DESCRIPTION
                order by segment1";
      }else{
        $sql = "SELECT MSIB.SEGMENT1, MSIB.DESCRIPTION
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.SUBINVENTORY_CODE ='$sub_inv'
                AND MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                AND MMT.ORGANIZATION_ID = $org_id
                AND MMT.TRANSACTION_DATE BETWEEN (select sysdate - 150 from dual) AND sysdate
                AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                group by msib.SEGMENT1, msib.DESCRIPTION
                order by SEGMENT1";
      }
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

}
