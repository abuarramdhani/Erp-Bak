<?php
class M_ajax extends CI_Model {

	var $oracle;
    public function __construct()
    {
    	parent::__construct();
      $this->load->database();
    	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
    }

    function getComponentCode($term = FALSE,$org_id)
    {
      if ($term == FALSE) {
        $sql = "SELECT MSIB.SEGMENT1, MSIB.DESCRIPTION
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                AND MMT.ORGANIZATION_ID = $org_id
                AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                group by msib.SEGMENT1, msib.DESCRIPTION
                order by segment1";
      }else{
        $sql = "SELECT MSIB.SEGMENT1, MSIB.DESCRIPTION
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                AND MMT.ORGANIZATION_ID = $org_id
                AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                AND MSIB.SEGMENT1 LIKE '%$term%'
                group by msib.SEGMENT1, msib.DESCRIPTION
                order by segment1";
      }
      $query = $this->oracle->query($sql);
      return $query->result();
    }

    function getAssy($org_id=FALSE,$item=NULL)
    {
      $sql = "SELECT DISTINCT msib2.segment1, msib2.description,
              ( SELECT  mc.segment1
                FROM mtl_system_items_b msib4
                  ,mtl_item_categories mic
                  ,mtl_categories mc
                WHERE msib4.SEGMENT1 = msib2.segment1
                  AND msib4.inventory_item_id = mic.INVENTORY_ITEM_ID
                  AND mic.organization_id = msib2.organization_id
                  AND mic.category_set_id = 1100000042
                  AND mc.category_id = mic.category_id
                  AND msib4.organization_id = mic.organization_id) AS asstype
              FROM  mtl_system_items_b msib,
                    mtl_system_items_b msib2,
                    bom_inventory_components bic,
                    bom_bill_of_materials bom
              WHERE msib.segment1 = '$item'
                AND msib.INVENTORY_ITEM_ID = bic.COMPONENT_ITEM_ID
                AND msib2.organization_id = $org_id
                AND msib2.inventory_item_id = bom.ASSEMBLY_ITEM_ID
                AND msib2.inventory_item_status_code = 'Active'
                AND bom.organization_id = msib2.organization_id
                AND bom.bill_sequence_id = bic.bill_sequence_id
              ";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }
}
