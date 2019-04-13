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

  public function TampilDataItemMinMax($route,$itemcode)
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
        AND msib.SEGMENT1             = '$itemcode'";
      $query = $this->oracle->query($sql);
      return $query->result_array();
  }

  public function save($itemcode, $min, $max, $rop)
  {
      $sql = "UPDATE mtl_system_items_b msib
        set msib.MIN_MINMAX_QUANTITY = '$min',
        msib.MAX_MINMAX_QUANTITY = '$max',
        msib.ATTRIBUTE9 = '$rop'
        where msib.SEGMENT1 = '$itemcode'";
      $query = $this->oracle->query($sql);
  }


}