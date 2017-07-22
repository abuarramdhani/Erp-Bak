<?php
class M_monitoring extends CI_Model {

	var $oracle;
    public function __construct()
    {
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
    }

    function getSubinventori($org_id=FALSE)
    {
    	if ($org_id===FALSE){
    		$sql = "SELECT SECONDARY_INVENTORY_NAME FROM mtl_secondary_inventories";
    	}else {
    		$sql = "SELECT SECONDARY_INVENTORY_NAME FROM mtl_secondary_inventories WHERE ORGANIZATION_ID = '$org_id'";
    	}
    	$query = $this->oracle->query($sql);
    	return $query->result_array();
    }

    function locator($sub_inv)
    {
    	$sql ="SELECT mil.segment1 SEGMENT1
	                  FROM mtl_item_locations mil, mtl_secondary_inventories msi
	                  WHERE msi.SECONDARY_INVENTORY_NAME = '$sub_inv'
	                  AND msi.SECONDARY_INVENTORY_NAME = mil.SUBINVENTORY_CODE ";
	    $query=$this->oracle->query($sql);
	    return $query->result_array();
	}

    function searchByKomp($sub_inv,$locator,$kode_item,$org_id)
    {
    	if(($sub_inv == "") and  ($locator == "") and ($kode_item == "") and ($org_id == "")){
				$p = "";
				
			}else{
				$p = "and";
			}
			
			if($sub_inv == ""){
				$a = "";
			}else{
				$a = "kls.sub_inv = '$sub_inv'";
			}

			if($locator == ""){
				$b = "";
				$p1 = "";
			}else{
				$b = "kls.LOCATOR like upper('%$locator%')";
				if(($sub_inv == "")){
					$p1 = "";
				}else{
					$p1 = "and";
				}
			}

			if($kode_item == ""){
				$c = "";
				$p2 = "";
			}else{
				$c = "kls.COMPONENT like upper('%$kode_item%')";
				if(($sub_inv == "") and  ($locator == "")){
					$p2 = "";
				}else{
					$p2 = "and";
				}
			}

			if($org_id == ""){
				$d = "";
				$p3 = "";
			}else{
				$d = "kls.organization_id = '$org_id'";
				if(($sub_inv == "") and  ($locator == "") and ($kode_item == "")){
					$p3 = "";
				}else{
					$p3 = "and";
				}
			}

			$sql= $this->oracle->query("SELECT distinct kls.component ITEM , msib.DESCRIPTION DESCRIPTION
						        ,kls.assembly KODE_ASSEMBLY , msib2.DESCRIPTION NAMA_ASSEMBLY , kls.assembly_type TYPE_ASSEMBLY , kls.sub_inv SUB_INV
						                , kls.alamat_simpan ALAMAT , kls.LPPB_MO_KIB LMK, kls.picklist PICKLIST
						            from mtl_system_items_b msib ,khs.khslokasisimpan kls , mtl_system_items_b msib2 
						            where kls.COMPONENT = msib.SEGMENT1
           								 and msib2.segment1 = kls.assembly
						             	 $p $a $p1 $b $p2 $c $p3 $d ");
			return $sql->result_array();			

    }

     function searchBySA($sub_inv,$locator,$kode_assy,$org_id)
    {
    	if(($sub_inv == "") and  ($locator == "") and ($kode_assy == "") and ($org_id == "")){
				$p = "";
			}else{
				$p = "and";
			}
			
			if($sub_inv == ""){
				$a = "";
			}else{
				$a = "kls.sub_inv = '$sub_inv'";
			}

			if($locator == ""){
				$b = "";
				$p1 = "";
			}else{
				$b = "kls.LOCATOR like upper('%$locator%')";
				if(($sub_inv == "")){
					$p1 = "";
				}else{
					$p1 = "and";
				}
			}

			if($kode_assy == ""){
				$c = "";
				$p2 = "";
			}else{
				$c = "kls.assembly like upper('%$kode_assy%')";
				if(($sub_inv == "") and  ($locator == "")){
					$p2 = "";
				}else{
					$p2 = "and";
				}
			}

			if($org_id == ""){
				$d = "";
				$p3 = "";
			}else{
				$d = "kls.organization_id = '$org_id'";
				if(($sub_inv == "") and  ($locator == "") and ($kode_assy == "")){
					$p3 = "";
				}else{
					$p3 = "and";
				}
			}

			$sql = "SELECT distinct kls.component ITEM,
						msib.DESCRIPTION DESCRIPTION,
						kls.assembly KODE_ASSEMBLY,
						msib2.DESCRIPTION NAMA_ASSEMBLY,
						kls.assembly_type TYPE_ASSEMBLY,
						kls.sub_inv SUB_INV,
						kls.alamat_simpan ALAMAT,
						kls.LPPB_MO_KIB LMK,
						kls.picklist PICKLIST
					FROM mtl_system_items_b msib,
						mtl_system_items_b msib2 RIGHT JOIN khs.khslokasisimpan kls ON msib2.segment1 = kls.assembly
					WHERE kls.COMPONENT = msib.SEGMENT1 $p $a $p1 $b $p2 $c $p3 $d ";
			$query= $this->oracle->query($sql);
			return $query->result_array();			

    }
      function searchByAll($sub_inv,$locator,$alamat)
    {
    	
    	if(($sub_inv == "") and  ($locator == "") and ($alamat == "")){
				$p = "";
				
			}else{
				$p = "and";
			}
			
			if($sub_inv == ""){
				$a = "";
			}else{
				$a = "kls.sub_inv = '$sub_inv'";
			}

			if($locator == ""){
				$b = "";
				$p1 = "";
			}else{
				$b = "kls.LOCATOR like upper('%$locator%')";
				if(($sub_inv == "")){
					$p1 = "";
				}else{
					$p1 = "and";
				}
			}

			if($alamat == ""){
				$c = "";
				$p2 = "";
			}else{
				$c = "kls.ALAMAT_SIMPAN like upper('%$alamat%')";
				if(($sub_inv == "") and  ($locator == "")){
					$p2 = "";
				}else{
					$p2 = "and";
				}
			}

			$sql= "SELECT distinct kls.component ITEM , msib.DESCRIPTION DESCRIPTION
						        ,kls.assembly KODE_ASSEMBLY , msib2.DESCRIPTION NAMA_ASSEMBLY , kls.assembly_type TYPE_ASSEMBLY , kls.sub_inv SUB_INV
						                , kls.alamat_simpan ALAMAT , kls.LPPB_MO_KIB LMK, kls.picklist PICKLIST
						            from mtl_system_items_b msib ,khs.khslokasisimpan kls, mtl_system_items_b msib2 
						            where kls.COMPONENT = msib.SEGMENT1
           								 and msib2.segment1 = kls.assembly
						             	 $p $a $p1 $b $p2 $c";
			$query = $this->oracle->query($sql);
			return $query->result_array();			
    }

}
