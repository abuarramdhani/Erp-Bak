<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_stockGudangAlat extends CI_Model
{
	var $oracle;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
      $this->load->library('encrypt');
      // $this->oracle = $this->load->database('oracle', true);
   }

   function insertData($tag,$nama,$merk,$qty,$pilihan) 
   {
      $db = $this->load->database();
      $sql ="INSERT into msg.msg_stok_gdg_alat (tag, nama, merk, qty, jenis) 
		VALUES ('$tag', '$nama', '$merk', '$qty', '$pilihan')";
      $query = $this->db->query($sql);
      // echo $sql.'<br>';
      // exit();
      // return $sql;
   }

   function insertTable() 
   {
      $db = $this->load->database();
      $sql = "SELECT * FROM  msg.msg_stok_gdg_alat";
      $query = $this->db->query($sql);
      return $query->result_array();
   }
   
}

?>