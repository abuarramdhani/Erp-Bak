<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_report extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getPeriode(){
		$sql = "select * from pd.pnbp_periode order by periode_awal desc";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPekerjaHasHasil($text){
		$sql = "select * 
				from er.er_employee_all 
				where employee_code in	(
											select distinct noind 
											from pd.pnbp_hasil
										)";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
}
?>