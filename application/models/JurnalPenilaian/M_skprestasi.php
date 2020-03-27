<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
* 
*/
class M_skprestasi extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getskprestasi(){
		$sql = "select * from pk.pk_sk_pengurang_prestasi order by batas_bawah";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertSkPrestasi($bb,$bt,$p){
		$sql = "insert into pk.pk_sk_pengurang_prestasi(batas_bawah,batas_atas,pengurang,last_action_timestamp,creation_timestamp)
				values($bb,$bt,$p,current_timestamp,current_timestamp)";
		$this->db->query($sql);
	}

	public function getskprestasiByID($id){
		$sql = "select * from pk.pk_sk_pengurang_prestasi where sk_pres_id = $id";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function updateSkPrestasi($id,$p){
		$sql = "update pk.pk_sk_pengurang_prestasi set pengurang = $p, last_action_timestamp = current_timestamp where sk_pres_id = $id";
		$this->db->query($sql);
	}

	public function deleteSkPrestasi($id){
		$sql = "delete from pk.pk_sk_pengurang_prestasi where sk_pres_id = $id";
		$this->db->query($sql);
	}
}
?>