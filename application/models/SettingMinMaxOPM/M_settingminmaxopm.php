<?php
class M_settingminmaxopm extends CI_Model {

  var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

  public function TampilRoutingClass()
  {
    $sql = "SELECT DISTINCT(FRH.ROUTING_CLASS) FROM fm_rout_hdr frh";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function TampilRoutingClassODM()
  {
    $sql = "SELECT DISTINCT(bd.DEPARTMENT_CLASS_CODE) ROUTING_CLASS FROM bom_departments bd
            order by bd.DEPARTMENT_CLASS_CODE asc";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function TampilDataMinMax($route)
  {
      $sql = "SELECT DISTINCT msib.segment1,
          msib.DESCRIPTION,
          msib.PRIMARY_UOM_CODE,
          msib.MIN_MINMAX_QUANTITY MIN,
          msib.MAX_MINMAX_QUANTITY MAX,
          msib.ATTRIBUTE9 ROP
        FROM mtl_system_items_b msib ,
          gmd_recipe_validity_rules grvr ,
          gmd_recipes_b grb ,
          gmd_routings_b grtb
        WHERE msib.INVENTORY_ITEM_ID  = grvr.INVENTORY_ITEM_ID
        AND msib.ORGANIZATION_ID      = grvr.ORGANIZATION_ID
        AND grvr.RECIPE_ID            = grb.RECIPE_ID
        AND grvr.VALIDITY_RULE_STATUS = 700
        AND grvr.END_DATE            IS NULL
        AND grb.RECIPE_STATUS         = 700
        AND grb.ROUTING_ID            = grtb.ROUTING_ID
        AND grtb.ROUTING_CLASS        = '$route'
        ORDER BY msib.segment1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
  }

  public function TampilDataMinMaxODM($route)
  {
      $sql = "SELECT DISTINCT msib.segment1,
          msib.DESCRIPTION,
          msib.PRIMARY_UOM_CODE,
          msib.MIN_MINMAX_QUANTITY MIN,
          msib.MAX_MINMAX_QUANTITY MAX,
          msib.ATTRIBUTE9 ROP,
          msib.ATTRIBUTE13 LIMITJOB
          from bom_operational_routings bor
          ,bom_operation_sequences bos
          ,bom_departments bd
          ,bom_bill_of_materials bom
          ,bom_inventory_components bic
          ,mtl_system_items_b msib2
          ,mtl_system_items_b msib
          where bor.ROUTING_SEQUENCE_ID = bos.ROUTING_SEQUENCE_ID
          and bos.DISABLE_DATE is null
          and bos.DEPARTMENT_ID = bd.department_id
          and bor.ORGANIZATION_ID = bd.ORGANIZATION_ID
          and bor.ALTERNATE_ROUTING_DESIGNATOR is null
          and bos.OPERATION_SEQ_NUM = (select min(bos1.OPERATION_SEQ_NUM)
          from bom_operation_sequences bos1
          where bos1.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
          and bos1.DISABLE_DATE is null)
          and bd.DEPARTMENT_CLASS_CODE = '$route'    ----> PARAMETER
          and msib.inventory_ITEM_ID = bor.ASSEMBLY_ITEM_ID
          and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
          and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
          and bom.bill_sequence_id = bic.bill_sequence_id
          and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
          and bom.organization_id = msib.organization_id
          and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
          and bom.ORGANIZATION_ID = msib2.ORGANIZATION_ID
          and bom.ALTERNATE_BOM_DESIGNATOR is null
          and bic.DISABLE_DATE is null";

      $query = $this->oracle->query($sql);
      return $query->result_array();
  }
  public function TampilDataItemMinMax($route,$itemcode)
  {
      $sql = "SELECT DISTINCT msib.segment1,
          msib.DESCRIPTION,
          msib.PRIMARY_UOM_CODE,
          msib.MIN_MINMAX_QUANTITY MIN,
          msib.MAX_MINMAX_QUANTITY MAX,
          msib.ATTRIBUTE9 ROP
          -- ,msib.ATTRIBUTE13 LIMITJOB
        FROM mtl_system_items_b msib ,
          gmd_recipe_validity_rules grvr ,
          gmd_recipes_b grb ,
          gmd_routings_b grtb
        WHERE msib.INVENTORY_ITEM_ID  = grvr.INVENTORY_ITEM_ID
        AND msib.ORGANIZATION_ID      = grvr.ORGANIZATION_ID
        AND grvr.RECIPE_ID            = grb.RECIPE_ID
        AND grvr.VALIDITY_RULE_STATUS = 700
        AND grvr.END_DATE            IS NULL
        AND grb.RECIPE_STATUS         = 700
        AND grb.ROUTING_ID            = grtb.ROUTING_ID
        AND grtb.ROUTING_CLASS        = '$route'
        AND msib.SEGMENT1             = '$itemcode'";
      $query = $this->oracle->query($sql);
      return $query->result_array();
  }

  public function TampilDataItemMinMaxODM($route,$itemcode)
  {
      $sql = "SELECT msib.segment1,
          msib.DESCRIPTION,
          msib.PRIMARY_UOM_CODE,
          msib.MIN_MINMAX_QUANTITY MIN,
          msib.MAX_MINMAX_QUANTITY MAX,
          msib.ATTRIBUTE9 ROP,
          msib.ATTRIBUTE13 LIMITJOB
          from bom_operational_routings bor
          ,bom_operation_sequences bos
          ,bom_departments bd
          ,bom_bill_of_materials bom
          ,bom_inventory_components bic
          ,mtl_system_items_b msib2
          ,mtl_system_items_b msib
          where bor.ROUTING_SEQUENCE_ID = bos.ROUTING_SEQUENCE_ID
          and bos.DISABLE_DATE is null
          and bos.DEPARTMENT_ID = bd.department_id
          and bor.ORGANIZATION_ID = bd.ORGANIZATION_ID
          and bor.ALTERNATE_ROUTING_DESIGNATOR is null
          and bos.OPERATION_SEQ_NUM = (select min(bos1.OPERATION_SEQ_NUM)
          from bom_operation_sequences bos1
          where bos1.ROUTING_SEQUENCE_ID = bor.ROUTING_SEQUENCE_ID
          and bos1.DISABLE_DATE is null)
          and bd.DEPARTMENT_CLASS_CODE = '$route'    ----> PARAMETER
          and msib.inventory_ITEM_ID = bor.ASSEMBLY_ITEM_ID
          and msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
          and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
          and bom.bill_sequence_id = bic.bill_sequence_id
          and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
          and bom.organization_id = msib.organization_id
          and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
          and bom.ORGANIZATION_ID = msib2.ORGANIZATION_ID
          and bom.ALTERNATE_BOM_DESIGNATOR is null
          and bic.DISABLE_DATE is null
        AND msib.SEGMENT1             = '$itemcode'";
      $query = $this->oracle->query($sql);
      return $query->result_array();
  }

  public function save($itemcode, $min, $max, $rop, $induk, $limit)
  {
    if ($limit == 'Y') {
      $limit = ", msib.ATTRIBUTE13 = 'Y'";
    } else {
      $limit = ", msib.ATTRIBUTE13 = ''";
    }
      $sql = "UPDATE mtl_system_items_b msib
        set msib.MIN_MINMAX_QUANTITY = '$min',
        msib.MAX_MINMAX_QUANTITY = '$max',
        msib.ATTRIBUTE9 = '$rop',
        msib.ATTRIBUTE10 = '$induk',
        msib.ATTRIBUTE11 = TO_CHAR(sysdate, 'DD-MON-YYYY HH24:MI:SS')
        $limit
        where msib.SEGMENT1 = '$itemcode'";
        // echo $sql;
        // exit();
      $query = $this->oracle->query($sql);
  }

  public function savebulk($itemcode, $limit)
  {
    if ($limit == 'Y') {
      $limit = " msib.ATTRIBUTE13 = 'Y'";
    } else {
      $limit = " msib.ATTRIBUTE13 = ''";
    }
      $sql = "UPDATE mtl_system_items_b msib
        set $limit
        where msib.SEGMENT1 = '$itemcode'";
        // echo $sql;
        // exit();
      $query = $this->oracle->query($sql);
  }


  public function saveImport($itemcode, $min, $max, $rop, $limit)
  {
    if ($limit != NULL) {
      $limit = ", msib.ATTRIBUTE13 = 'Y'";
    } else {
      $limit = ", msib.ATTRIBUTE13 = ''";
    }
      $sql = "UPDATE mtl_system_items_b msib
        set msib.MIN_MINMAX_QUANTITY = '$min',
        msib.MAX_MINMAX_QUANTITY = '$max',
        msib.ATTRIBUTE9 = '$rop',
        msib.ATTRIBUTE11 = TO_CHAR(sysdate, 'DD-MON-YYYY HH24:MI:SS')
        $limit
        where msib.SEGMENT1 = '$itemcode'";
      $query = $this->oracle->query($sql);
  }


}
