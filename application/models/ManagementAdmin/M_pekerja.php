<?php 
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 * 
 */
class M_pekerja extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getPekerja(){
		$sql = "select * from ma.ma_pekerja where status_delete = '0'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getEmployee($noind){
		$noind = strtoupper($noind);
		$sql = "select * from er.er_employee_all where resign = '0' and employee_code like '%$noind%' order by employee_code";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getEmployeeName($id){
		$sql = "select employee_name from er.er_employee_all where resign = '0' and employee_id = $id order by employee_code";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function insertTarget($data){
		$this->db->insert('ma.ma_target',$data);
	}

	public function insertPekerja($data){
		$this->db->insert('ma.ma_pekerja',$data);
	}

	public function deleteTarget($id){
		$this->db->where('id_target',$id);
		$this->db->delete('ma.ma_target');
	}

	public function deletePekerja($id){
		$this->db->query("update ma.ma_pekerja set status_delete = '1' where id_pekerja = $id");
	}

	public function updateTarget($id,$data){
		$this->db->where('id_target',$id);
		$this->db->update('ma.ma_target',$data);
	}
}
?>