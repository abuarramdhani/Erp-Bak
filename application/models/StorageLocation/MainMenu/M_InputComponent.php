<?php
class M_inputcomponent extends CI_Model {

	var $oracle;
    public function __construct()
    {
    	parent::__construct();
      	$this->load->database();
      	$this->oracle = $this->load->database('oracle', TRUE);
  		$this->load->library('encrypt');
  		$this->load->helper('url');
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
	    $query = $this->oracle->query($sql);
	    $result = $query->num_rows();
	    return $result;
	}

    function insertData2($org_id,$sub_inv,$kode_assy,$type_assy,$kode_item_save,$locator,$alamat_simpan_save,$lppbmokib_save,$picklist_save,$user_name){
        $sql="INSERT INTO KHS.KHSLOKASISIMPAN (ORGANIZATION_ID, SUB_INV, ASSEMBLY, ASSEMBLY_TYPE, COMPONENT, LOCATOR, ALAMAT_SIMPAN, LPPB_MO_KIB, PICKLIST, CREATED_BY, CREATION_DATE) VALUES ('$org_id', '$sub_inv', '$kode_assy', '$type_assy', '$kode_item_save', '$locator', '$alamat_simpan_save', '$lppbmokib_save', '$picklist_save', '$user_name', sysdate)";
        $query = $this->oracle->query($sql);
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

        $sql ="UPDATE khs.khslokasisimpan set ALAMAT_SIMPAN ='$alamat_simpan_save' , LPPB_MO_KIB ='$lppbmokib_save' ,  PICKLIST ='$picklist_save', LAST_UPDATED_BY ='$user_name' ,LAST_UPDATE_DATE = sysdate WHERE ORGANIZATION_ID ='$org_id' AND $a2 AND $b2 AND $c2 AND $d2 ";
        $query = $this->oracle->query($sql);
        return;
    }
}