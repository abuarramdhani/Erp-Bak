<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_productsearch extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		// $this->db_l = $this->load->database('lutfi', TRUE);
	}

	function searchResult($product_id=FALSE)
	{
		if ($product_id === FALSE) {
			$sql = "SELECT * FROM fpd.khs_fp_products";
		}else{
			$sql = "SELECT * FROM fpd.khs_fp_products where product_id ='$product_id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getSearch($param)
	{
		$sql = "SELECT * FROM fpd.khs_fp_products 
				where (UPPER(product_number) like '%$param%' ) OR (UPPER(product_description) like '%$param%' )";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getComponent($id)
	{
		// $sql ="SELECT co.* , (SELECT count(*) jml_opr FROM fpd.khs_fp_operations op
		// 				WHERE op.component_id = co.component_id) opr
		// 	   FROM fpd.khs_fp_components co
		// 	   WHERE co.product_id = '$id'";
		$sql ="SELECT co.* , (SELECT count(*) jml_opr FROM fpd.khs_fp_operations op
			   WHERE op.component_id = co.component_id) opr
				FROM fpd.khs_fp_components co
				WHERE co.product_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// function viewCompbyId($product_id)
	// {
	// 	// echo"<pre>";
	// 	// print_r($product_id);
	// 	// exit();
	// 	$sql ="SELECT * 
	// 		   FROM md.md_product_component
	// 		   WHERE product_id = '$product_id'";
	// 	$query = $this->db_l->query($sql);
	// 	// return $query->result_array();
	// 	$result = $query->result_array();
	// 	return $result;
	// }

	function deleteFIleGambar($product_id,$data)
	{
		$this->db->where('product_id', $product_id);
		$this->db->update('fpd.khs_fp_products', $data);
	}

	function resumeTGK($product_id)
	{
		$sql ="SELECT count(*) jml FROM fpd.khs_fp_components
			   WHERE product_id = '$product_id'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result[0]['jml'];
	}

	
}