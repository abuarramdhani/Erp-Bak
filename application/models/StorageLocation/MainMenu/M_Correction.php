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
                                        kls.ORGANIZATION_ID ORGANIZATION_ID,
    									kls.assembly KODE_ASSEMBLY,
    									msib2.DESCRIPTION NAMA_ASSEMBLY,
    									kls.assembly_type TYPE_ASSEMBLY,
    									kls.sub_inv SUB_INV,
    									kls.alamat_simpan ALAMAT,
    									kls.LPPB_MO_KIB LMK,
                                        kls.picklist PICKLIST,
    									kls.khslokasisimpan_id ID
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

        $sql = "SELECT distinct kls.component ITEM,
                        msib.DESCRIPTION DESCRIPTION,
                        kls.assembly KODE_ASSEMBLY,
                        msib2.DESCRIPTION NAMA_ASSEMBLY,
                        kls.assembly_type TYPE_ASSEMBLY,
                        kls.sub_inv SUB_INV,
                        kls.alamat_simpan ALAMAT,
                        kls.LPPB_MO_KIB LMK,
                        kls.picklist PICKLIST,
                        kls.ORGANIZATION_ID ORGANIZATION_ID,
                        kls.khslokasisimpan_id ID
                FROM    mtl_system_items_b msib,
                        mtl_system_items_b msib2 RIGHT JOIN khs.khslokasisimpan kls ON msib2.segment1 = kls.assembly
                WHERE kls.COMPONENT = msib.SEGMENT1 $p $a $p1 $b $p2 $c";
    	$query= $this->oracle->query($sql);
    	return $query->result_array();
    }

    function save_alamat($user,$alamat,$ID)
    {
    	$sql =" UPDATE khs.khslokasisimpan SET alamat_simpan = '$alamat' , LAST_UPDATED_BY = '$user', LAST_UPDATE_DATE = sysdate
    			WHERE KHSLOKASISIMPAN_ID = $ID";
	   	$this->oracle->query($sql);
	}

	function save_lmk($user, $lmk, $ID)
	{
    	$sql ="UPDATE khs.khslokasisimpan SET LPPB_MO_KIB = '$lmk' , LAST_UPDATED_BY = '$user', LAST_UPDATE_DATE = sysdate 
            where KHSLOKASISIMPAN_ID = $ID";
        $query= $this->oracle->query($sql);
    }

    function save_picklist($user,$picklist,$ID)
    {	
	    $sql ="UPDATE khs.khslokasisimpan SET PICKLIST = '$picklist' , LAST_UPDATED_BY = '$user', LAST_UPDATE_DATE = sysdate
	    	        where KHSLOKASISIMPAN_ID = $ID";
        $query= $this->oracle->query($sql);
    }

    public function getSubInv()
    {
        $sql = "SELECT SECONDARY_INVENTORY_NAME, ORGANIZATION_ID FROM mtl_secondary_inventories WHERE ORGANIZATION_ID = '101' OR ORGANIZATION_ID = '102'";
    	$query= $this->oracle->query($sql);
        return $query->result_array();
    }

    public function compCodeSave($user,$ID,$compCode)
    {
        $sql    = " UPDATE khs.khslokasisimpan SET COMPONENT = '$compCode' , LAST_UPDATED_BY = '$user', LAST_UPDATE_DATE = sysdate
                    WHERE KHSLOKASISIMPAN_ID = $ID";
        $query  = $this->oracle->query($sql);
    }

    public function subInvSave($user,$ID,$sub_inv)
    {
        $sql    = " UPDATE khs.khslokasisimpan SET SUB_INV = '$sub_inv' , LAST_UPDATED_BY = '$user', LAST_UPDATE_DATE = sysdate
                    WHERE KHSLOKASISIMPAN_ID = $ID";
        $query  = $this->oracle->query($sql);
    }

    public function Delete($ID)
    {
            $this->oracle->where('KHSLOKASISIMPAN_ID',$ID);
            $this->oracle->delete('KHS.KHSLOKASISIMPAN');
    }
}
