<?php defined('BASEPATH') or die('No direct script access allowed');
class M_grafik extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
		// $this->db2 = $this->load->database('lantuma',TRUE);
	}

	function getData()
	{
		$sql = "SELECT date_trunc('week', creation_date::date) AS weekly, count(*)
				FROM fpd.khs_fp_components
				GROUP BY weekly
				ORDER BY weekly;";
		$query  = $this->db->query($sql);
		return $query->result_array();
	}


	function getDaily($awal,$akhir)
	{
		$sql = "SELECT date_trunc('day', creation_date::date) AS daily, count(*)
				FROM fpd.khs_fp_components
				WHERE creation_date BETWEEN '$awal' AND '$akhir' 
				GROUP BY daily
				ORDER BY daily";
		$query  = $this->db->query($sql);
		return $query->result_array();

	}

	function getDailyCOmpo($awal,$akhir)
	{
		$sql = "SELECT comp.*, pro.product_number, pro.product_description
				FROM fpd.khs_fp_components comp
				LEFT JOIN fpd.khs_fp_products pro ON comp.product_id = pro.product_id
				WHERE comp.creation_date BETWEEN '$awal' AND '$akhir'";
		$query  = $this->db->query($sql);
		return $query->result_array();
	}
}