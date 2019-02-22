<?php
class M_lihatstockcat extends CI_Model {

    public function __construct()
    {
	   parent::__construct();
        $this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
    }
	
function getDataCatMasuk()
	{
	$sql= $this->db->query("select * from dc.dc_data_paint_in ");
	return $sql->result_array();
	}

function getDataCatKeluar()
	{
	$sql= $this->db->query("select * from dc.dc_data_paint_out ");
	return $sql->result_array();
	}
function getDataCatOnHand()
	{
	$sql = $this->db->query("select * from dc.dc_data_paint_onhand order by paint_code, expired_date ");
	return $sql->result_array();
	}

function getDataCatOnHand2()
	{
	$query = $this->db->query("select * from dc.dc_data_paint_onhand order by paint_code");
	return $query->result_array();
	}


 function getDataCatKeluarMasuk()
	{
	$sql= $this->db->query("select on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate from dc.dc_data_paint_in UNION ALL SELECT on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate FROM dc.dc_data_paint_out order by sysdate desc ");
	return $sql->result_array();
	} 

function getDataCat($start_date,$end_date)
	{
	$sql= $this->db->query("select on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate 
		FROM dc.dc_data_paint_in 
		WHERE sysdate BETWEEN '$start_date' AND '$end_date' 
		UNION ALL SELECT on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate 
		FROM dc.dc_data_paint_out 
		WHERE sysdate BETWEEN '$start_date' AND '$end_date'  order by sysdate desc");
	return $sql->result_array();
	}	

function getDataCat2($start_date,$end_date,$paint_code,$paint_desc)
	{
	$sql= $this->db->query("
		select on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate 
		FROM dc.dc_data_paint_in  
		WHERE (sysdate BETWEEN '$start_date' AND '$end_date') AND (paint_code='$paint_code' or paint_description='$paint_desc')
		UNION ALL SELECT on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate 
		FROM dc.dc_data_paint_out 
		WHERE (sysdate BETWEEN '$start_date' AND '$end_date') AND (paint_code='$paint_code' or paint_description='$paint_desc') order by sysdate desc ");
	return $sql->result_array(); 
	}	
function getDataCat3($paint_code,$paint_desc)
	{
	$sql= $this->db->query("
		select on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate 
		FROM dc.dc_data_paint_in  
		WHERE paint_code='$paint_code' or paint_description='$paint_desc'
		UNION ALL SELECT on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate 
		FROM dc.dc_data_paint_out 
		WHERE paint_code='$paint_code' or paint_description='$paint_desc' order by sysdate desc ");
	return $sql->result_array(); 
	}
function findDataCat($start_date,$end_date,$paint_code,$paint_desc)
	{
	if ($start_date =="" and $end_date=""){
		$period = "";
	}
	else {
		$period ="(sysdate BETWEEN '$start_date' AND '$end_date')";
	}
	if ($paint_code=="" and $paint_desc=""){
		$pcd ="";
	}
	elseif ((!empty($paint_code)) or (!empty($paint_desc))){
		$pcd="(paint_code='$paint_code' or paint_description='$paint_desc')";
	}
	if ((!empty($start_date)) and (!empty($end_date)) and ($paint_code=="" and $paint_desc="")){
		$op="yy";
	}
	elseif ((!empty($start_date)) and (!empty($end_date)) and ($paint_code==!"" or $paint_desc=!"")) {
		$op="and";
	}
	elseif (($start_date =="" and $end_date="") and ($paint_code==!"" or $paint_desc=!"")) {
		$op="";
	}
	$sql= $this->db->query("
		select on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate 
		FROM dc.dc_data_paint_in  
		WHERE $period $op $pcd
		UNION ALL 
		SELECT on_hand,paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate 
		FROM dc.dc_data_paint_out 
		WHERE $period $op $pcd
		order by sysdate desc ");
	return $sql->result_array(); 
	}
	
function getPaintIn(){
	$sql = $this->db->query("
	select * from dc.dc_data_paint_in");
	return $sql->result_array();
}

function getPaintOut(){
	$sql = $this->db->query("
	select * from dc.dc_data_paint_out");
	return $sql->result_array();
}

function ins_del_in(
		$paint_code,$paint_desc,
		$expired_date,$quantity,
		$evidence_number,$employee,
		$sysdate,$on_hand
	){
		if($on_hand == null){
			$onh = '';
			$onhand = '';
		}else{
			$onh = ",on_hand";
			$onhand = ",'$on_hand'";
		}
		$sql = $this->db->query("
			insert into dc.dc_data_paint_in_del (paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate $onh)
			values (
				'$paint_code',
				'$paint_desc',
				'$expired_date',
				'$quantity',
				'$evidence_number',
				'$employee',
				'$sysdate'
				 $onhand
			)
		");
		return;
	}
		
function ins_del_out(
		$paint_code,$paint_desc,
		$expired_date,$quantity,
		$evidence_number,$employee,
		$sysdate
	){
		$sql = $this->db->query("
			insert into dc.dc_data_paint_out_del (paint_code,paint_description,expired_date,quantity,evidence_number,employee,sysdate)
			values (
				'$paint_code',
				'$paint_desc',
				'$expired_date',
				'$quantity',
				'$evidence_number',
				'$employee',
				'$sysdate'
			)
		");
		return;
	}

function del_on_hand(){
	$sql  = "delete from dc.dc_data_paint_onhand";
	$query = $this->db->query($sql);
	return;
}

function del_im_out(){
	$sql = $this->db->query("delete from dc.dc_data_paint_out");
	return;
}

function del_im_in(){
	$sql = $this->db->query("delete from dc.dc_data_paint_in");
	return;
}
	
}