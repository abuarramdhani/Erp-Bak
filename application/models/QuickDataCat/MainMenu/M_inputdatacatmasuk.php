<?php
class M_inputdatacatmasuk extends CI_Model {

    public function __construct()
    {
	   parent::__construct();
        $this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
    }

function getKodeCatMasuk()
	{
	$db2= $this->load->database('oracle_dev', TRUE);
	$sql= $db2->query("SELECT * FROM MTL_SYSTEM_ITEMS_B WHERE SEGMENT1 LIKE 'MAP%' AND DESCRIPTION LIKE 'CAT%' AND rownum <=50");
	return $sql->result();
	}
	
	
function getKodeCatMasukSelect2($id = FALSE)
    {
	if ($id===FALSE){
		$sql = "select DISTINCT SEGMENT1 from MTL_SYSTEM_ITEMS_B where SEGMENT1 LIKE 'MAP%' and DESCRIPTION LIKE 'CAT%'";
	}
	else {
		$sql = "select DISTINCT SEGMENT1 from MTL_SYSTEM_ITEMS_B where SEGMENT1 LIKE 'MAP%' AND DESCRIPTION LIKE 'CAT%' and SEGMENT1 like '%$id%'";
	}
	$db2= $this->load->database('oracle_dev', TRUE);
	$query = $db2->query($sql);
	return $query->result();
	}
	
function getDescriptionMasuk($kode_cat)
	{
	$db2= $this->load->database('oracle_dev', TRUE);
	$sql= $db2->query("SELECT * FROM MTL_SYSTEM_ITEMS_B WHERE SEGMENT1 LIKE 'MAP%' AND DESCRIPTION LIKE 'CAT%' and SEGMENT1='$kode_cat'");
	return $sql->result_array();
	}

function TambahDataCatMasuk($data)
	{
	return $this->db->insert('dc.dc_data_paint_in', $data);
	}

function insertOnHand($kode_cat,$expired,$quant,$cat)
	{
	$sql= $this->db->query("insert into dc.dc_data_paint_onhand(paint_code,expired_date,on_hand,paint_description) values ('$kode_cat','$expired','$quant','$cat') ");
	}
	
function updateOnHand($kode_cat,$expired,$quant)
	{
	$sql= $this->db->query("update dc.dc_data_paint_onhand SET on_hand = on_hand+'$quant' where paint_code='$kode_cat' and expired_date='$expired' ");
	
	}

function cekKodeExpCat($kode_cat,$expired)
	{
		$sql="select * from dc.dc_data_paint_onhand WHERE paint_code='$kode_cat' and expired_date='$expired'";
        $query=$this->db->query($sql);
        return $query->num_rows();
	}

}