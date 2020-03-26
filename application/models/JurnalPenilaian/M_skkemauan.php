<?php 
Defined('BASEPATH') or exit('No direct Script Access Allowed');
/**
* 
*/
class M_skkemauan extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getskkemauan(){
		$sql = "select * from pk.pk_sk_pengurang_kemauan order by bulan_batas_bawah";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertSKKemauan($bb,$ba,$p){
		$sql = "insert into pk.pk_sk_pengurang_kemauan (bulan_batas_bawah,bulan_batas_atas,pengurang,last_action_timestamp,creation_timestamp)
				values($bb,$ba,$p,current_timestamp,current_timestamp)";
		$this->db->query($sql);
	}

	public function getskkemauanByID($id){
		$sql = "select * from pk.pk_sk_pengurang_kemauan where sk_kemauan_id = $id";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function updateSKKemauan($id,$p){
		$sql = "update pk.pk_sk_pengurang_kemauan set pengurang = $p , last_action_timestamp= current_timestamp where sk_kemauan_id = $id";
		$this->db->query($sql);
	}

	public function deleteSKKemauan($id){
		$sql = "delete from pk.pk_sk_pengurang_kemauan where sk_kemauan_id = $id";
		$this->db->query($sql);
	}
}
?>