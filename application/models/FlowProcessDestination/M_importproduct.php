<?php defined('BASEPATH') or die('No direct script access allowed');
class M_importproduct extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db = $this->load->database('default', TRUE);
		}
		
    public function checkproduct($code, $name){
			// echo"<pre>";print_r($code);exit;
      $sql = "SELECT * from fpd.khs_product where product_code='$code' and product_name='$name'";
			$query = $this->db->query($sql);
			return $query->result_array();
    }
    
    public function insertproduct($code, $name, $id){
      $sql = "INSERT INTO fpd.khs_product (product_code, product_name, product_id) VALUES ('$code', '$name', '$id');";
			$query = $this->db->query($sql);
		}
		
		public function updateproduct($code, $name, $id){
			$sql="UPDATE fpd.khs_product set product_code='$code'where product_id='$id' and product_name='$name' ";
      $query= $this->db->query($sql);
		}

}