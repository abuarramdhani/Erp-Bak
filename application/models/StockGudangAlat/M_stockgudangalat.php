<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_stockgudangalat extends CI_Model
{
	// var $oracle;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
      $this->load->library('encrypt');
      $this->dev = $this->load->database('dpostgre', true);
   }

   function insertData($no_po,$nama,$merk,$pilihan,$qty,$tag,$subinv)
   {
      $db = $this->load->database();
      $sql ="INSERT into msg.msg_stok_gdg_alat_tst (no_po, tag, nama, merk, qty, jenis, subinv)
		VALUES ('$no_po','$tag', '$nama', '$merk', '$qty', '$pilihan', '$subinv')";
      $query = $this->dev->query($sql);
      // echo $sql.'<br>';
      // exit();//
      // return $sql;
   }

   function insertTable()
   {
      $db = $this->load->database();
      $sql = "SELECT distinct msgab.no_po, msgab.tag, msgab.nama, msgab.merk, msgab.subinv,
      msgab.qty,
      count(nama) OVER (partition by nama) jml, msgab.jenis, msgab.id FROM
      msg.msg_stok_gdg_alat_tst msgab order by nama asc";
      $query = $this->dev->query($sql);
      return $query->result_array();
   }

   function updateData($tag,$nama,$nama2,$merk,$qty,$pilihan,$no_po)
   {
      $db = $this->load->database();
      $sql = "UPDATE msg.msg_stok_gdg_alat_tst SET tag = '$tag', nama = '$nama2',
             merk = '$merk', qty = '$qty', jenis = '$pilihan', no_po = '$no_po'
      WHERE nama = '$nama'";
      // echo $sql;exit();
      // print_r($sql);exit;
      $this->dev->query($sql);
      // $query = $this->db->query($sql);
      // return $query;
      // return $sql;
   }

   function deleteData($id)
   {
      $db = $this->load->database();
      $sql ="DELETE FROM msg.msg_stok_gdg_alat_tst
      WHERE id ='$id'";

      $this->dev->query($sql);
   }

	 // tambahan
	 public function getDataComp($id)
	 {
		$this->db->where('id', $id);
		$query = $this->db->get('msg.msg_stok_gdg_alat_tst');
		return $query->result_array();
	 }

}

?>
