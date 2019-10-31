<?php defined('BASEPATH') or die('No direct script access allowed');
class M_componentsetup extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		// $this->db_lu = $this->load->database('lutfi', TRUE);
	}

	function saveComponent($data)
	{
		$this->db->insert('fpd.khs_fp_components',$data);
	}
	function saveComponent2($data)
	{
		// echo "<pre>";
		// print_r($data);
		// exit();
		$this->db->insert('fpd.khs_fp_components',$data);
	}

	function deleteComponent($id)
	{
		$this->db->where('component_id', $id);
		$this->db->delete('fpd.khs_fp_components');
	}

	function getDataComponent($product_id,$component_id)
	{
		$sql = "SELECT co.*  
				FROM fpd.khs_fp_components co
				WHERE co.product_id = '$product_id' 
				AND co.component_id = '$component_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function saveEditComponent($component_id,$data)
	{
		$this->db->where('component_id', $component_id);
		$this->db->update('fpd.khs_fp_components', $data);
	}

	function deleteFIleGambar($component_id,$data)
	{
		$this->db->where('component_id', $component_id);
		$this->db->update('fpd.khs_fp_components', $data);
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

	function getComponentById($component_id)
	{
		$sql ="SELECT * FROM fpd.khs_fp_components WHERE component_id = '$component_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	function addpdf($pdf)
	{
		$sql = "INSERT INTO fpd.khs_fp_pdf(file_name)
				values ('$pdf')";
		$query = $this->db->query($sql);

	}
	function save_data_gambar($data) {
		// echo "<pre>";
		// print_r ($data);
		// exit();
		$this->db->insert('fpd.khs_fp_data_gambar', $data);
		// $new_a = str_replace("'", " ", $new_nama);
		// $sql ="INSERT into fpd.khs_fp_data_gambar (product_number, product_description, status_product, end_date_active);
		// VALUES ('$no_produk', '$des_produk', '$status_produk', '$tanggal_akhir_aktif')";
		// $query = $this->db->query($sql);
	}
	function selectproduct($term){
        $sql = "SELECT * FROM fpd.khs_fp_products 
				where (UPPER(product_number) like '%$term%' ) OR (UPPER(product_description) like '%$term%' )";
		// echo"<pre>";
		// print_r($sql);
		// exit();
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function selectdrwcode($term, $productId){
		// echo"<pre>";
		// print_r($sql);
		// exit();
        $sql = "SELECT * FROM fpd.khs_component
				where UPPER(drw_code) ILIKE '%$term%' or UPPER(drw_description) ILIKE '%$term%' and product_id = '$productId'";
		$query = $this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}


	function viewproductnumb($prodid){
		$sql = "SELECT product_number from fpd.khs_fp_products where product_id='$prodid'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function viewproductdesc($prodid){
		$sql = "SELECT product_description from fpd.khs_fp_products where product_id='$prodid'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function viewBy_drwgroup($drw_group){
		// echo"<pre>";
		// print_r($drw_group);
		// exit();
		$sql = "SELECT * FROM fpd.khs_fp_data_component WHERE drw_group='".$drw_group."'";
		$query = $this->db->query($sql);
		return $query->result_array();
		// $this->db->where('product_number', $product_number);
		// $this->db->select('fpd.khs_fp_data_gambar');
		// $result = $this->db->get('$data')->row(); // Tampilkan data siswa berdasarkan NIS
		
		// return $result; 
	  }

	  public function viewBy_drwcode($drwcode, $productId){
		// echo"<pre>";
		// print_r($drwcode);
		// print_r($productId);
		// exit();
		$sql = "SELECT * FROM fpd.khs_component WHERE drw_code='$drwcode' and product_id='$productId'";
		$query = $this->db->query($sql);
		return $query->result_array();
		// return $sql;
		// $this->db->where('product_number', $product_number);
		// $this->db->select('fpd.khs_fp_data_gambar');
		// $result = $this->db->get('$data')->row(); // Tampilkan data siswa berdasarkan NIS
		
		// return $result; 
		}
		
		public function check_component($drwcode, $productId){
			// echo"<pre>";
			// print_r($drw_group);
			// exit();
			$sql = "SELECT * FROM fpd.khs_fp_components WHERE drw_code='$drwcode' and product_id='$productId'";
			$query = $this->db->query($sql);
			return $query->result_array();
			// $this->db->where('product_number', $product_number);
			// $this->db->select('fpd.khs_fp_data_gambar');
			// $result = $this->db->get('$data')->row(); // Tampilkan data siswa berdasarkan NIS
			
			// return $result; 
			}


	  public function viewByCodeProduct($product_code){
		// $sql = "SELECT product_id, product_code, product_name FROM md.md_product WHERE product_code like '%$product_code%'";
		// $query = $this->db_lu->query($sql);
		// return $query->result_array();
		// $this->db->where('product_number', $product_number);
		// $this->db->select('fpd.khs_fp_data_gambar');
		// $result = $this->db->get('$data')->row(); // Tampilkan data siswa berdasarkan NIS
		
		// return $result; 
		}
}