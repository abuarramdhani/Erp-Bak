<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_importnilai extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insertNilai($data){
		$this->db->insert('pk.pk_gapok',$data);
	}

	public function getNilai($data){
		$this->db->where($data);
		$result = $this->db->get('pk.pk_gapok');
		return $result->num_rows();
	}

	public function updateNilai($data,$where){
		$this->db->where($where);
		$this->db->update('pk.pk_gapok',$data);
	}
	
}
?>