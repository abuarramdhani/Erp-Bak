<?php defined('BASEPATH') or die('No direct script access allowed');
class M_grafik extends CI_Model
{

	function __construct()
	{
		$this->load->database();
		$this->design = $this->load->database('design', true);
	}

	function getData()
	{
		$sql = "SELECT date_trunc('week', created_date::date) AS weekly, count(*)
				FROM md.md_product_component
				GROUP BY weekly
				ORDER BY weekly;";
		$query  = $this->design->query($sql);
		return $query->result_array();
	}


	function getDaily($awal,$akhir)
	{
		$sql = "SELECT date_trunc('day', created_date::date) AS daily, count(*)
				FROM md.md_product_component
				WHERE created_date BETWEEN '$awal' AND '$akhir'
				GROUP BY daily
				ORDER BY daily";
		$query  = $this->design->query($sql);
		return $query->result_array();

	}

	function getDailyCOmpo($awal,$akhir)
	{
		$sql = "SELECT comp.*, pro.product_code, pro.product_name
				FROM md.md_product_component comp
				LEFT JOIN md.md_product pro ON comp.product_id = pro.product_id
				WHERE comp.created_date BETWEEN '$awal' AND '$akhir'";
		$query  = $this->design->query($sql);
		return $query->result_array();
	}
}
