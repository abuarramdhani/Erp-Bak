<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_target extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getTarget(){
		$sql = "select * from ma.ma_target";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getKode(){
		$sql = "select max(no_urut)+1 kode
				from ma.ma_target";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertTarget($data){
		$this->db->insert('ma.ma_target',$data);
	}

	public function deleteTarget($id){
		$this->db->where('id_target',$id);
		$this->db->delete('ma.ma_target');
	}

	public function updateTarget($id,$data){
		$this->db->where('id_target',$id);
		$this->db->update('ma.ma_target',$data);
	}
}
?>