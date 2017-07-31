<?php
class M_datacatkeluar extends CI_Model {

    public function __construct()
    {
	   parent::__construct();
        $this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
    }
	
function getDataCatKeluar()
	{
	$sql= $this->db->query("select * from dc.dc_data_paint_out");
	return $sql->result_array();
	}
	
}