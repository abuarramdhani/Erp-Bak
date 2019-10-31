<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_productsetup extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		// $this->oracle = $this->load->database('oracle_dev',true);
		// $this->db_lu = $this->load->database('lutfi', TRUE);
	}

	function selectprdcode($term){
		$sql = "SELECT * FROM fpd.khs_product
		where UPPER(product_code) LIKE '%$term%' or UPPER(product_name) LIKE '%$term%' order by product_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function checkproduct($product_id){
		$sql = "SELECT * from fpd.khs_fp_products where product_id='$product_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function SaveProduct($data)
	{
		$this->db->insert('fpd.khs_fp_products',$data);
	}
	
	public function updateproduct($product_id,$last_edit_date,$last_edit_by,$creation_date,$created_by,$start_date_active,$end_date_active,$product_number,$product_desc,$product_status,$gambar_unit_name){
		$sql="UPDATE fpd.khs_fp_products set product_status='$product_status' ,
								last_update_date='$last_edit_date',
								last_update_by ='$last_edit_by',
								creation_date ='$creation_date',
								created_by='$created_by',
								start_date_active ='$start_date_active',
								end_date_active='$end_date_active',
								gambar_unit ='$gambar_unit_name'
					where product_id='$product_id'  
						and product_number='$product_number' 
						and product_description='$product_desc'";
						// echo"<pre>"; print_r($product_status);exit;
		$query= $this->db->query($sql);
	}

	function selectproduct($term){
    $sql = "SELECT * FROM fpd.khs_fp_products 
		where (UPPER(product_number) like '%$term%' ) 
		OR (UPPER(product_description) like '%$term%' )";
		$query = $this->db->query($sql);
		return $query->result_array();
    }

	function getProduct($product_id=FALSE)
	{
		if ($product_id === FALSE) {
			$sql = "SELECT * FROM fpd.khs_fp_products";
		}else{
			$sql = "SELECT * FROM fpd.khs_fp_products where product_id ='$product_id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function saveEditProduct($id,$data)
	{
		$this->db->where('product_id', $id);
		$this->db->update('fpd.khs_fp_products', $data);
	}
	function product_setup($no_produk){
		$sql = "SELECT * FROM fpd.khs_fp_data_gambar WHERE product_number='".$no_produk."'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	public function viewByNoProduct($product_number){
		$sql = "SELECT * FROM fpd.khs_fp_data_gambar WHERE product_number='".$product_number."'";
		$query = $this->db->query($sql);
		return $query->result_array();
		}
		
	public function view_prd($prdid){
			$sql = "SELECT * FROM fpd.khs_product WHERE product_id='".$prdid."'";
			$query = $this->db->query($sql);
			// return $sql;
			return $query->result_array();
			}
	
}