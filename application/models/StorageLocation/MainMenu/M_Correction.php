<?php
class M_correction extends CI_Model {

	var $oracle;
    public function __construct()
    {
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
    }

    function getSearchComponent($org_id,$sub_inv,$item,$locator)
    {
    	if(($org_id == "") and  ($sub_inv == "") and ($item == "") and ($locator == "")){
    		$p = "";
    	}else{
    		$p = "and";
    	}

    	if($org_id == ""){
    		$a = "";
    	}else{
    		$a = "kls.ORGANIZATION_ID = '$org_id'";
    	}

    	if($sub_inv == ""){
    		$b = "";
    		$p1 = "";
    	}else{
    		$b = "kls.SUB_INV = '$sub_inv'";
    		if(($org_id == "")){
    			$p1 = "";
    		}else{
    			$p1 = "and";
    		}
    	}

    	if($item == ""){
    		$c = "";
    		$p2 = "";
    	}else{
    		$c = "kls.COMPONENT = '$item'";
    		if(($org_id == "") and ($sub_inv == "")){
    			$p2 = "";
    		}else{
    			$p2 = "and";
    		}
    	}

    	if($locator == ""){
    		$d = "";
    		$p3 = "";
    	}else{
    		$d = "kls.LOCATOR like upper('%$locator%')";
    		if(($org_id == "") and ($sub_inv == "") and ($item == "")){
    			$p3 = "";
    		}else{
    			$p3 = "and";
    		}
    	}

    	$sql= $this->oracle->query("SELECT distinct kls.component ITEM,
    									msib.DESCRIPTION DESCRIPTION,
    									kls.assembly KODE_ASSEMBLY,
    									msib2.DESCRIPTION NAMA_ASSEMBLY,
    									kls.assembly_type TYPE_ASSEMBLY,
    									kls.sub_inv SUB_INV,
    									kls.alamat_simpan ALAMAT,
    									kls.LPPB_MO_KIB LMK,
    									kls.picklist PICKLIST
    								FROM mtl_system_items_b msib, khs.khslokasisimpan kls, mtl_system_items_b msib2 
    								WHERE kls.COMPONENT = msib.SEGMENT1
    								AND msib2.segment1 = kls.assembly $p $a $p1 $b $p2 $c $p3 $d" );
    	return $sql->result_array();
    }

    function getSearchAssy($org_id,$sub_inv,$kode_assy)
    {
    	if(($org_id == "") and  ($sub_inv == "") and ($kode_assy == "")){
    		$p = "";
    	}else{
    		$p = "and";
    	}

    	if($org_id == ""){
    		$a = "";
    	}else{
    		$a = "kls.ORGANIZATION_ID = '$org_id'";
    	}

    	if($sub_inv == ""){
    		$b = "";
    		$p1 = "";
    	}else{
    		$b = "kls.SUB_INV = '$sub_inv'";
    		if(($org_id == "")){
    			$p1 = "";
    		}else{
    			$p1 = "and";
    		}
    	}

    	if($kode_assy == ""){
    		$c = "";
    		$p2 = "";
    	}else{
    		$c = "kls.ASSEMBLY = '$kode_assy'";
    		if(($org_id == "") and ($sub_inv == "")){
    			$p2 = "";
    		}else{
    			$p2 = "and";
    		}
    	}

    	$sql= $this->oracle->query("SELECT distinct kls.component ITEM,
    									msib.DESCRIPTION DESCRIPTION,
    									kls.assembly KODE_ASSEMBLY,
    									msib2.DESCRIPTION NAMA_ASSEMBLY,
    									kls.assembly_type TYPE_ASSEMBLY,
    									kls.sub_inv SUB_INV,
    									kls.alamat_simpan ALAMAT,
    									kls.LPPB_MO_KIB LMK,
    									kls.picklist PICKLIST
    								FROM mtl_system_items_b msib, khs.khslokasisimpan kls, mtl_system_items_b msib2 
    								WHERE kls.COMPONENT = msib.SEGMENT1
    									AND msib2.segment1 = kls.assembly $p $a $p1 $b $p2 $c");
    	return $sql->result_array();
    }

    function save_alamat($user, $alamat, $item, $kode_assy, $type_assy, $sub_inv)
    {
    	if ($item == "") {
    		$a1 = "component is null";
    	}else{
    		$a1 = "component = '$item'";
    	}

    	if ($kode_assy == "") {
    	    $c1 = "assembly is null";
    	}else{
    	    $c1 = "assembly ='$kode_assy'";
    	}

    	if ($type_assy == "") {
    	    $d1 = "assembly_type is null";
    	}else{
    	    $d1 = "assembly_type ='$type_assy'";
    	}

    	if ($sub_inv == "") {
    	    $e1 = "sub_inv is null";
    	}else{
    	    $e1 = "sub_inv ='$sub_inv'";
    	}

    	$sql =" UPDATE khs.khslokasisimpan SET alamat_simpan = '$alamat' , LAST_UPDATED_BY = '$user', LAST_UPDATE_DATE = sysdate
    			WHERE $a1 and $c1 and $d1 and $e1";
	   	$this->oracle->query($sql);
	}

	function save_lmk($user, $lmk, $item, $kode_assy, $type_assy, $sub_inv)
	{
    	if ($item == "") {
    	    $a2 = "component is null";
    	}else{
    	    $a2 = "component = '$item'";
    	}
    	if ($kode_assy == "") {
    	    $c2 = "assembly is null";
    	}else{
    	    $c2 = "assembly ='$kode_assy'";
    	}
    	if ($type_assy == "") {
    	    $d2 = "assembly_type is null";
    	}else{
    	    $d2 = "assembly_type ='$type_assy'";
    	}
    	if ($sub_inv == "") {
    	    $e2 = "sub_inv is null";
    	}else{
    	    $e2 = "sub_inv ='$sub_inv'";
    	}

    	$sql ="UPDATE khs.khslokasisimpan SET LPPB_MO_KIB = '$lmk' , LAST_UPDATED_BY = '$user', LAST_UPDATE_DATE = sysdate 
            where $a2 and $c2 and $d2 and $e2 ";
        $query= $this->oracle->query($sql);
    }

    function save_picklist($user, $picklist, $item, $kode_assy, $type_assy, $sub_inv)
    {
        if ($item == "") {
    	    $a3 = "component is null";
    	}else{
    	    $a3 = "component = '$item'";
    	}
    	if ($kode_assy == "") {
    	    $c3 = "assembly is null";
    	}else{
    	    $c3 = "assembly ='$kode_assy'";
    	}
    	if ($type_assy == "") {
    	    $d3 = "assembly_type is null";
    	}else{
    	    $d3 = "assembly_type ='$type_assy'";
    	}
    	if ($sub_inv == "") {
    	    $e3 = "sub_inv is null";
    	}else{
    	    $e3 = "sub_inv ='$sub_inv'";
    	}
	
	    $sql ="UPDATE khs.khslokasisimpan SET PICKLIST = '$picklist' , LAST_UPDATED_BY = '$user', LAST_UPDATE_DATE = sysdate
	    	        where $a3 and $c3 and $d3 and $e3 ";
    	$query= $this->oracle->query($sql);
    }
}
