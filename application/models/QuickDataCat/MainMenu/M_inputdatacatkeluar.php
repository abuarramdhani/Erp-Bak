<?php
class M_inputdatacatkeluar extends CI_Model {

    public function __construct()
    {
	   parent::__construct();
        $this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
    }
	
function getKodeCatKeluar()
	{
	$sql= $this->db->query("select * from dc.dc_data_paint_in");
	return $sql->result_array();
	}
	
public function getKodeCatKeluarSelect2($id = FALSE)
    {
	if ($id===FALSE){
		$sql = "select distinct paint_code from dc.dc_data_paint_onhand";
	}
	else {
		$sql = "select distinct paint_code from dc.dc_data_paint_onhand where upper(paint_code) like '%$id%'";
	}
	$query = $this->db->query($sql);
	return $query->result();
	}
	
function getDescriptionKeluar($kode_cat)
	{
	$sql= $this->db->query("select * from dc.dc_data_paint_in where paint_code='$kode_cat'"); 
	return $sql->result_array();
	}

function getExpiredDate($kode_cat)
	{
	// $sql= $this->db->query("select expired_date FROM dc.dc_data_paint_in  WHERE paint_code='$kode_cat'");
	$sql= $this->db->query("select * from dc.dc_data_paint_onhand where paint_code='$kode_cat'");
	return $sql->result_array();
	}
function getOnHand($kode_cat)
	{
	$sql=$this->db->query("select * from dc.dc_data_paint_onhand where paint_code='$kode_cat'");
	return $sql->result_array();
	}

function getBuktiKeluar($kode_cat)
	{
	$sql= $this->db->query("select * from dc.dc_data_paint_in where paint_code='$kode_cat'");
	return $sql->result_array();
	}
	
function getPetugasKeluar($kode_cat)
	{
	$sql= $this->db->query("select * from dc.dc_data_paint_in where paint_code='$kode_cat'");
	return $sql->result_array();
	}

function TambahDataCatKeluar($data)
	{
	return $this->db->insert('dc.dc_data_paint_out', $data);
	}
	
function HapusDataCatKeluar($data,$kode_cat)
	{
	$sql= $this->db->query("delete from dc.dc_data_paint_onhand where on_hand=0");
	}
function KurangOnHAnd($kode_cat,$quant,$expired)
	{
	$sql= $this->db->query("update dc.dc_data_paint_onhand SET on_hand = on_hand -'$quant' where paint_code='$kode_cat' and expired_date='$expired' ");
	}

// function getQuantityKeluar($id)
	// {
	// $sql= $this->db->query("select * from dc.dc_data_paint_in where paint_id='$id'");
	// return $sql->result_array();
	// }	
		
}
