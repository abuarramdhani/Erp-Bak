<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_productionplan extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();    
  }

     public function getnamekomp($komp) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT msib.segment1, msib.description,msib.inventory_item_id 
              FROM mtl_system_items_b msib 
              WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'  
              AND msib.organization_id = 81
              AND msib.segment1 = '$komp'";

   $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
      public function getkomp($term) {
    $oracle = $this->load->database('oracle', true);
    $sql = "SELECT msib.segment1, msib.description,msib.inventory_item_id 
              FROM mtl_system_items_b msib 
              WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'  
              AND msib.organization_id = 81
              AND msib.segment1 like '%$term%'";

   $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }
  public function insertitem($priority,$codekomp,$namekomp,$jeniskomp) {
    $sql = "INSERT INTO pjpl.item (priority,jenis,kode_item,desc_item) values('$priority','$jeniskomp','$codekomp','$namekomp')";

    $query = $this->db->query($sql);
      // return $query->result_array();
         return $sql;
  }
   public function datainserttampil() {
    $sql = "SELECT* FROM pjpl.item";

    $query = $this->db->query($sql);
      return $query->result_array();
         // return $sql;
  }

   public function dapatkaniditem($komponen) {
    $sql = "SELECT id_item FROM pjpl.item WHERE kode_item ='$komponen'";

    $query = $this->db->query($sql);
      return $query->result_array();
         // return $sql;
  }
  public function dapatkanitem($id_item) {
    $sql = "SELECT kode_item, desc_item, jenis FROM pjpl.item WHERE id_item ='$id_item'";

    $query = $this->db->query($sql);
      return $query->result_array();
         // return $sql;
  }
    public function insertplan($bulan,$id_item,$nama,$tgl1,$tgl2,$tgl3,$tgl4,$tgl5,$tgl6,$tgl7,$tgl8,$tgl9,$tgl10,$tgl11,$tgl12,$tgl13,$tgl14,$tgl15,$tgl16,$tgl17,$tgl18,$tgl19,$tgl20,$tgl21,$tgl22,$tgl23,$tgl24,$tgl25,$tgl26,$tgl27,$tgl28,$tgl29,$tgl30,$tgl31, $versi) {
    $sql = "INSERT INTO pjpl.plan (id_item, bulan,versi,tgl_1,tgl_2,tgl_3,tgl_4,tgl_5,tgl_6,tgl_7,tgl_8,tgl_9,tgl_10,tgl_11,tgl_12,tgl_13,tgl_14,tgl_15,tgl_16,tgl_17,tgl_18,tgl_19,tgl_20,tgl_21,tgl_22,tgl_23,tgl_24,tgl_25,tgl_26,tgl_27,tgl_28,tgl_29,tgl_30,tgl_31) values('$id_item','$bulan','$versi','$tgl1','$tgl2','$tgl3','$tgl4','$tgl5','$tgl6','$tgl7','$tgl8','$tgl9','$tgl10','$tgl11','$tgl12','$tgl13','$tgl14','$tgl15','$tgl16','$tgl17','$tgl18','$tgl19','$tgl20','$tgl21','$tgl22','$tgl23','$tgl24','$tgl25','$tgl26','$tgl27','$tgl28','$tgl29','$tgl30','$tgl31')";

    $query = $this->db->query($sql);
      // return $query->result_array();
         return $sql;
  }
  public function cek($id_item, $bulan){
     $sql = "SELECT* FROM pjpl.plan where id_item='$id_item' and bulan = '$bulan' order by versi desc";

    $query = $this->db->query($sql);
      return $query->result_array();
  }
  public function dataplan($month) {
    $sql = "SELECT* FROM pjpl.plan where bulan ='$month' order by versi DESC";

    $query = $this->db->query($sql);
      return $query->result_array();
         // return $sql;
  }
  public function dataplan2() {
    $sql = "SELECT* FROM pjpl.plan";

    $query = $this->db->query($sql);
      return $query->result_array();
         // return $sql;
  }

   public function getprojection($tgl_1,$tgl_2,$tgl_3,$tgl_4,$tgl_5,$tgl_6,$tgl_7,$komponen) {
    $oracle = $this->load->database('oracle', true);
    $sql = "select distinct
bom.organization_id
,msib.segment1 ASSY_code
,msib.description assy_Desc
,msib.PRIMARY_UOM_CODE UOM_ASSY
,bom.ALTERNATE_BOM_DESIGNATOR ALT
,bic.OPERATION_SEQ_NUM
,bic.ITEM_NUM ITEM_SEQ
,msib2.segment1 COMPONENT_code
,msib2.description component_desc
,msib2.PRIMARY_UOM_CODE UOM_KOMPONEN
,msib2.SECONDARY_UOM_CODE SECONDARY_UOM_KOMPONEN
,bic.COMPONENT_QUANTITY QTY
,khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') att_khs
,hitung.qty_plan1
,hitung.qty_plan2
,hitung.qty_plan3
,hitung.qty_plan4
,hitung.qty_plan5
,hitung.qty_plan6
,hitung.qty_plan7
,hitung.avail1
,hitung.avail2
,hitung.avail3
,hitung.avail4
,hitung.avail5
,hitung.avail6
,hitung.avail7
,floor(bisa1) bisa1
,floor(bisa2) bisa2
,floor(bisa3) bisa3
,floor(bisa4) bisa4
,floor(bisa5) bisa5
,floor(bisa6) bisa6
,floor(bisa7) bisa7
from
bom_bill_of_materials bom
,bom_inventory_components bic
,mtl_system_items_b msib
,mtl_system_items_b msib2
,MTL_ITEM_LOCATIONS mil
,(select distinct
    bom.organization_id
    ,msib.segment1 ASSY_code
    ,msib.description assy_Desc
    ,msib.PRIMARY_UOM_CODE UOM_ASSY
    ,bom.ALTERNATE_BOM_DESIGNATOR ALT
    ,bic.OPERATION_SEQ_NUM
    ,bic.ITEM_NUM ITEM_SEQ
    ,msib2.INVENTORY_ITEM_ID item_id
    ,msib2.segment1 COMPONENT_code
    ,msib2.description component_desc
    ,msib2.PRIMARY_UOM_CODE UOM_KOMPONEN
    ,msib2.SECONDARY_UOM_CODE SECONDARY_UOM_KOMPONEN
    ,bic.COMPONENT_QUANTITY QTY
    ,bic.COMPONENT_QUANTITY*'$tgl_1' QTY_PLAN1
    ,bic.COMPONENT_QUANTITY*'$tgl_2' QTY_PLAN2
    ,bic.COMPONENT_QUANTITY*'$tgl_3' QTY_PLAN3
    ,bic.COMPONENT_QUANTITY*'$tgl_4' QTY_PLAN4
    ,bic.COMPONENT_QUANTITY*'$tgl_5' QTY_PLAN5
    ,bic.COMPONENT_QUANTITY*'$tgl_6' QTY_PLAN6
    ,bic.COMPONENT_QUANTITY*'$tgl_7' QTY_PLAN7
    ,khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - bic.COMPONENT_QUANTITY*'$tgl_1' avail1
    ,khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2') avail2
    ,khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3') avail3
    ,khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'+bic.COMPONENT_QUANTITY*'$tgl_4') avail4
    ,khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'+bic.COMPONENT_QUANTITY*'$tgl_4'+bic.COMPONENT_QUANTITY*'$tgl_5') avail5
    ,khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'+bic.COMPONENT_QUANTITY*'$tgl_4'+bic.COMPONENT_QUANTITY*'$tgl_5'+bic.COMPONENT_QUANTITY*'$tgl_6') avail6
    ,khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'+bic.COMPONENT_QUANTITY*'$tgl_4'+bic.COMPONENT_QUANTITY*'$tgl_5'+bic.COMPONENT_QUANTITY*'$tgl_6'+bic.COMPONENT_QUANTITY*'$tgl_7') avail7
    ,(khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - bic.COMPONENT_QUANTITY*'$tgl_1')/bic.COMPONENT_QUANTITY bisa1
    ,(khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'))/bic.COMPONENT_QUANTITY bisa2
    ,(khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'))/bic.COMPONENT_QUANTITY bisa3
    ,(khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'+bic.COMPONENT_QUANTITY*'$tgl_4'))/bic.COMPONENT_QUANTITY bisa4
    ,(khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'+bic.COMPONENT_QUANTITY*'$tgl_4'+bic.COMPONENT_QUANTITY*'$tgl_5'))/bic.COMPONENT_QUANTITY bisa5
    ,(khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'+bic.COMPONENT_QUANTITY*'$tgl_4'+bic.COMPONENT_QUANTITY*'$tgl_5'+bic.COMPONENT_QUANTITY*'$tgl_6'))/bic.COMPONENT_QUANTITY bisa6
    ,(khs_inv_qty_att(102 ,msib2.INVENTORY_ITEM_ID,'','','') - (bic.COMPONENT_QUANTITY*'$tgl_1'+bic.COMPONENT_QUANTITY*'$tgl_2'+bic.COMPONENT_QUANTITY*'$tgl_3'+bic.COMPONENT_QUANTITY*'$tgl_4'+bic.COMPONENT_QUANTITY*'$tgl_5'+bic.COMPONENT_QUANTITY*'$tgl_6'+bic.COMPONENT_QUANTITY*'$tgl_7'))/bic.COMPONENT_QUANTITY bisa7
    ,bic.bill_sequence_id
    from
    bom_bill_of_materials bom
    ,bom_inventory_components bic
    ,mtl_system_items_b msib
    ,mtl_system_items_b msib2
    ,MTL_ITEM_LOCATIONS mil
    where
    bom.bill_sequence_id = bic.bill_sequence_id
    and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
    and bom.organization_id = msib.organization_id
    and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
    and bic.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
    and bom.organization_id = 102
    and msib.SEGMENT1 in ('$komponen')
    and bom.ALTERNATE_BOM_DESIGNATOR is null
    and bic.DISABLE_DATE is null
    and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
    order by 1,2,3,4,5) hitung
where
bom.bill_sequence_id = bic.bill_sequence_id
and bom.ASSEMBLY_ITEM_ID = msib.inventory_item_id
and bom.organization_id = msib.organization_id
and bic.COMPONENT_ITEM_ID = msib2.inventory_item_id
and msib2.INVENTORY_ITEM_ID = hitung.item_id
and bic.SUPPLY_LOCATOR_ID = mil.INVENTORY_LOCATION_ID(+)
and bom.organization_id = 102
and msib.SEGMENT1 in ('$komponen')
and bom.ALTERNATE_BOM_DESIGNATOR is null
and bic.DISABLE_DATE is null
and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
and bic.bill_sequence_id = hitung.bill_sequence_id
order by 2
";

   $query = $oracle->query($sql);
    return $query->result_array();
         // return $sql;
  }



 
}