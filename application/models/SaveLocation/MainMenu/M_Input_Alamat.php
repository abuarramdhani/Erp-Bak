<?php
class M_Input_Alamat extends CI_Model {

    var $oraprod;
    public function __construct()
    {
      parent::__construct();
      $this->oraprod = $this->load->database('oraprod', TRUE);
      // $this->load->database('oracle');
  		$this->load->library('encrypt');
      $this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->helper('url');
    }


    function getSubinventori($org_id=FALSE)
    {
      if ($org_id===FALSE){
        $sql = "SELECT SECONDARY_INVENTORY_NAME FROM mtl_secondary_inventories";
      }else {
        $sql = "SELECT SECONDARY_INVENTORY_NAME FROM mtl_secondary_inventories WHERE ORGANIZATION_ID = '$org_id'";
      }
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getKomponenKode($org_id,$sub_inv)
    {
      if ($sub_inv === FALSE) {
        $sql = "SELECT MSIB.SEGMENT1, MSIB.DESCRIPTION
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                AND MMT.ORGANIZATION_ID = $org_id
                AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                GROUP BY MSIB.SEGMENT1, MSIB.DESCRIPTION
                ORDER BY MSIB.SEGMENT1, MSIB.DESCRIPTION/";
      }else{
        $sql = "SELECT MSIB.SEGMENT1, MSIB.DESCRIPTION
                FROM MTL_MATERIAL_TRANSACTIONS MMT, MTL_SYSTEM_ITEMS_B MSIB
                WHERE MMT.SUBINVENTORY_CODE ='$sub_inv'
                AND MMT.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND MMT.ORGANIZATION_ID = MSIB.ORGANIZATION_ID
                AND MMT.ORGANIZATION_ID = $org_id
                AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                GROUP BY MSIB.SEGMENT1, MSIB.DESCRIPTION
                ORDER BY MSIB.SEGMENT1, MSIB.DESCRIPTION";
      }
      
      
      $query = $this->oraprod->query($sql);
      return $query->result_array();
    }


   function getLocator($id=FALSE,$sub_inv=FALSE)
   {
    if ($id===FALSE){
      $sql = "SELECT mil.segment1 SEGMENT1
                  FROM mtl_item_locations mil, mtl_secondary_inventories msi
                  WHERE msi.SECONDARY_INVENTORY_NAME = '$sub_inv'
                      AND msi.SECONDARY_INVENTORY_NAME = mil.SUBINVENTORY_CODE ";
    }
    else{
      $sql ="SELECT mil.segment1 SEGMENT1
                  FROM mtl_item_locations mil, mtl_secondary_inventories msi
                  WHERE msi.SECONDARY_INVENTORY_NAME = '$sub_inv'
                      AND msi.SECONDARY_INVENTORY_NAME = mil.SUBINVENTORY_CODE
                      AND mil.segment1 like '%$id%'";
    }
    $db2= $this->load->database('oracle',TRUE);
      $query = $db2->query($sql);
      return $query->result();
   }

     function getItem($id=FALSE,$org=NULL,$assy=NULL)
    {
		if ($id == FALSE && $assy == NULL){
			$sql = " SELECT distinct msib.segment1 , msib.DESCRIPTION
                           FROM bom_inventory_components bic, mtl_system_items_b msib, KHSINVLOKASISIMPAN k
                          WHERE msib.inventory_item_id = bic.component_item_id
                        AND msib.inventory_item_id = k.inventory_item_id
                        AND MSIB.ORGANIZATION_ID = '$org'
               			";
		}
    elseif ($assy != NULL) {
      $sql = "SELECT DISTINCT msib.segment1 ,
                msib.description 
           FROM mtl_system_items_b msib,
                mtl_system_items_b msib2,
                bom_inventory_components bic,
                bom_bill_of_materials bom
          WHERE msib2.segment1 = '$assy'
            AND msib2.organization_id = '$org' 
            AND msib.inventory_item_id = bic.component_item_id
            AND bom.bill_sequence_id = bic.bill_sequence_id
            AND bom.assembly_item_id = msib2.inventory_item_id
            AND bom.organization_id = msib2.organization_id ";
    }
		else {
			$sql = "SELECT distinct msib.segment1 , msib.DESCRIPTION
           				FROM bom_inventory_components bic, mtl_system_items_b msib, KHSINVLOKASISIMPAN k
          				WHERE msib.inventory_item_id = bic.component_item_id
                        AND msib.inventory_item_id = k.inventory_item_id
                        AND MSIB.ORGANIZATION_ID = '$org'
               			AND msib.segment1 like '%$id%' ";
		}
    $db2= $this->load->database('oracle', TRUE);
    $query = $db2->query($sql);
    return $query->result();
  }

      function getAssy($id=FALSE,$org=NULL,$item=NULL)
    {
    if ($id == FALSE && $item == NULL ){
      $sql = " SELECT msib.segment1 , msib.description
                  FROM bom_bill_of_materials bbom, mtl_system_items_b msib, KHSINVLOKASISIMPAN k
                  WHERE msib.inventory_item_id = bbom.ASSEMBLY_ITEM_ID
                        AND msib.inventory_item_id = k.inventory_item_id
                        AND msib.ORGANIZATION_ID = '$org' 
                  GROUP BY msib.segment1, msib.description
              ";
    }

    elseif ($item != NULL) {
    $sql =" SELECT DISTINCT msib2.segment1 ,
                msib2.description 
           FROM mtl_system_items_b msib,
                mtl_system_items_b msib2,
                bom_inventory_components bic,
                bom_bill_of_materials bom
          WHERE msib.segment1 = '$item'
            AND msib.INVENTORY_ITEM_ID = bic.COMPONENT_ITEM_ID
            AND msib2.organization_id = '$org' 
            AND msib2.inventory_item_id = bom.ASSEMBLY_ITEM_ID
            AND bom.organization_id = msib2.organization_id
            AND bom.bill_sequence_id = bic.bill_sequence_id 
          ";
    }
    else {
      $sql = "SELECT msib.segment1 , msib.description
                  FROM bom_bill_of_materials bbom, mtl_system_items_b msib, KHSINVLOKASISIMPAN k
                  WHERE msib.inventory_item_id = bbom.ASSEMBLY_ITEM_ID
                        AND msib.inventory_item_id = k.inventory_item_id
                        AND msib.ORGANIZATION_ID = '$org'
                    AND msib.segment1 like '%$id%'
                  GROUP BY msib.segment1, msib.description";
    }
    $db2= $this->load->database('oracle', TRUE);
    $query = $db2->query($sql);
    return $query->result();
  }

  function getDescriptionItem($kode_item)
  {
    $db2= $this->load->database('oracle', TRUE);
    $sql = "SELECT DESCRIPTION FROM mtl_system_items_b 
          WHERE SEGMENT1 = '$kode_item'";
    $query=$this->db->query($sql);
    return $query->result_array();
  }   

  function getDescriptionAssy($kode_assy)
  {
    $db2= $this->load->database('oracle', TRUE);
    $sql = "SELECT DESCRIPTION FROM mtl_system_items_b 
          WHERE SEGMENT1 = '$kode_assy'";
    $query=$this->db->query($sql);
    return $query->result_array();
  }

  function getTypeAssy($kode_assy)
  {
    $db2= $this->load->database('oracle', TRUE);
    $sql = "SELECT mcb.SEGMENT2
            FROM mtl_system_items_b msib
            ,mtl_categories_b mcb
            ,mtl_item_categories mic
            WHERE msib.SEGMENT1 = '$kode_assy'
            AND msib.inventory_item_id = mic.INVENTORY_ITEM_ID
            AND mic.INVENTORY_ITEM_ID = mcb.CATEGORY_ID";
    $query=$this->db->query($sql);
    return $query->result_array();
  }

  function cekData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator)
  {
    if ($sub_inv == "") {
        $a = "sub_inv is null";
    }else{
        $a = "sub_inv ='$sub_inv'";
    }

    if ($kode_assy == "") {
        $b = "assembly is null";
    }else{
        $b = "assembly ='$kode_assy'";
    }

    if ($type_assy == "") {
        $c = "assembly_type is null";
    }else{
        $c = "assembly_type ='$type_assy'";
    }

    if ($kode_item_save == "") {
        $d = "component is null";
    }else{
        $d = "component = '$kode_item_save'";
    }


    if ($locator == "") {
        $f = "LOCATOR is null";
    }else{
        $f = "LOCATOR ='$locator'";
    }
    
    $sql="SELECT * FROM khs.khslokasisimpan  WHERE ORGANIZATION_ID ='$org_id' AND $a AND $b AND $c AND $d AND $f";
    $query = $this->db->query($sql);
    $result = $query->num_rows();
    return $result;
  } 

    function insertData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user_name){
    $sql="INSERT INTO KHS.KHSLOKASISIMPAN (ORGANIZATION_ID, SUB_INV, ASSEMBLY, ASSEMBLY_TYPE, COMPONENT, LOCATOR, ALAMAT_SIMPAN, LPPB_MO_KIB, PICKLIST, CREATED_BY, CREATION_DATE) VALUES ('$org_id', '$sub_inv', '$kode_assy', '$type_assy', '$kode_item_save', '$locator', '$alamat_simpan_save', '$lppbmokib_save', '$picklist_save', '$user_name', sysdate)";
    $query = $this->db->query($sql);
    return;
  }

  function updateData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user_name){

    if ($sub_inv == "") {
        $a2 = "sub_inv is null";
    }else{
        $a2 = "sub_inv ='$sub_inv'";
    }

    if ($kode_assy == "") {
        $b2 = "assembly is null";
    }else{
        $b2 = "assembly ='$kode_assy'";
    }

    if ($type_assy == "") {
        $c2 = "assembly_type is null";
    }else{
        $c2 = "assembly_type ='$type_assy'";
    }

    if ($kode_item_save == "") {
        $d2 = "component is null";
    }else{
        $d2 = "component = '$kode_item_save'";
    }


    $sql ="update khs.khslokasisimpan set ALAMAT_SIMPAN ='$alamat_simpan_save' , LPPB_MO_KIB ='$lppbmokib_save' ,  PICKLIST ='$picklist_save', LAST_UPDATED_BY ='$user_name' ,LAST_UPDATE_DATE = sysdate WHERE ORGANIZATION_ID ='$org_id' AND $a2 AND $b2 AND $c2 AND $d2 ";
    $query = $this->db->query($sql);
    return;
  }

  
 

}