<?php
class M_inputfileupload extends CI_Model {

	var $oracle;
    public function __construct()
    {
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
    }

    function cekData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator)
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

	    if ($kode_item == "") {
	        $d = "component is null";
	    }else{
	        $d = "component = '$kode_item'";
	    }

	    if ($locator == "") {
	        $f = "LOCATOR is null";
	    }else{
	        $f = "LOCATOR ='$locator'";
	    }
	    
	    $sql	= "SELECT * from khs.khslokasisimpan  where ORGANIZATION_ID ='$org_id' and $a and $b and $c and $d and $f";
	    $query 	= $this->oracle->query($sql);
	    $result = $query->num_rows();
	    return $result;
	}

	function updateData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator,$alamat_simpan,$lppbmokib,$picklist,$username_save)
	{
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

	    if ($kode_item == "") {
	        $d2 = "component is null";
	    }else{
	        $d2 = "component = '$kode_item'";
	    }

	    $sql = "UPDATE khs.khslokasisimpan
	    		SET ALAMAT_SIMPAN ='$alamat_simpan',
	    			LPPB_MO_KIB ='$lppbmokib',
	    			PICKLIST ='$picklist',
	    			LAST_UPDATED_BY ='$username_save',
	    			LAST_UPDATE_DATE = sysdate
	    		WHERE ORGANIZATION_ID ='$org_id' and $a2 and $b2 and $c2 and $d2";
	    $query = $this->oracle->query($sql);
	}

	function insertData($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item,$locator,$alamat_simpan,$lppbmokib,$picklist,$username_save)
	{
		$sql = "INSERT INTO KHS.KHSLOKASISIMPAN
					(ORGANIZATION_ID,
					SUB_INV,
					ASSEMBLY,
					ASSEMBLY_TYPE,
					COMPONENT,
					LOCATOR,
					ALAMAT_SIMPAN,
					LPPB_MO_KIB,
					PICKLIST,
					CREATED_BY,
					CREATION_DATE)
				VALUES
					('$org_id',
					'$sub_inv',
					'$kode_assy',
					'$type_assy',
					'$kode_item',
					'$locator',
					'$alamat_simpan',
					'$lppbmokib',
					'$picklist',
					'$username_save',
					sysdate)";
		$query = $this->oracle->query($sql);
	}
}
