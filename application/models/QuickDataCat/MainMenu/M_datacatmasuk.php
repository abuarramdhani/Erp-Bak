<?php
class M_datacatmasuk extends CI_Model {

    public function __construct()
    {
	   parent::__construct();
        $this->load->database();
		$this->load->library('encrypt');
		$this->load->helper('url');
    }
	
function getDataCatMasuk()
	{
	$sql= $this->db->query("select * from dc.dc_data_paint_in");
	return $sql->result_array();
	}
	
}