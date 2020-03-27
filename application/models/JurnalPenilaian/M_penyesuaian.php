<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
* 
*/
class M_penyesuaian extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function updatePenyesuaian($nom,$tmp){
		$sql = "update pk.pk_penyesuaian set $tmp = $nom, created_date = current_date";
		$this->db->query($sql);

		$sql = "insert into pk.pk_penyesuaian_history
				select * from pk.pk_penyesuaian";
		$this->db->query($sql);
	}

	public function getPenyesuaian(){
		$sql = "select * from pk.pk_penyesuaian";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
}
?>