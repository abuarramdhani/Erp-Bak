<?php
Defined('BASEPATH') or exit("No Direct Script Access Allowed");

/**
 * 
 */
class M_datavaksinasi extends CI_Model
{
	
	function __construct()
	{
		$this->personalia = $this->load->database('personalia', true);
	}

	public function getData()
	{
		$query = "Select * from hrd_khs.tvaksinasi";
		return $this->personalia->query($query)->result_array();
	}
	
}