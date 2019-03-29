<?php defined('BASEPATH') OR exit('No direct script  access allowed');
class M_opnameresource extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function getData($no_doc)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT *
				FROM khs_resource_opname kro
				WHERE NO_DOCUMENT_RO = '$no_doc'
				ORDER BY RESOURCE_RO, COST_CENTER_RO, NO_MESIN_RO, TAG_NUMBER_RO 
				";
		$query = $oracle->query($sql);
		return $query->result_array();
	}

	function getDataSelect()
	{
		$oracle = $this->load->database('oracle',TRUE);
		$sql = "SELECT distinct(NO_DOCUMENT_RO) no_doc
				FROM khs_resource_opname kro
				";
		$query = $oracle->query($sql);
		return $query->result_array();
	}
}