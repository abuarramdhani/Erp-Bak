<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_setupkelompok extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getKelompok(){
		$sql = "select * from pd.pnbp_kelompok";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertKelompok($kelompok){
		$sql = "insert into pd.pnbp_kelompok(kelompok)
				values('$kelompok')";
		$this->db->query($sql);
		return;
	}

	public function updateKelompok($kelompok,$id){
		$sql = "update pd.pnbp_kelompok set kelompok = '$kelompok' where id_kelompok = $id";
		$this->db->query($sql);
		return;
	}

	public function deleteKelompok($id){
		$sql = "delete from pd.pnbp_kelompok where id_kelompok = $id";
		$this->db->query($sql);
		return;
	}
}
?>