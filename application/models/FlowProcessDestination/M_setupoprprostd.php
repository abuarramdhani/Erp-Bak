<?php defined('BASEPATH') or die('No direct script access allowed');
class M_setupoprprostd extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

	function getOprProcess()
	{
		$sql = "SELECT * FROM fpd.khs_fp_operation_process_std ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function SaveNewOPS($data)
	{
		$this->db->insert('fpd.khs_fp_operation_process_std',$data);
	}

	function deleteOPS($id)
	{
		$this->db->where('operation_process_std_id',$id);
		$this->db->delete('fpd.khs_fp_operation_process_std');
	}

	function getDataOPSById($id)
	{
		$sql ="SELECT * FROM fpd.khs_fp_operation_process_std WHERE operation_process_std_id= $id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function SaveEditOPS($id,$data)
	{
		$this->db->where('operation_process_std_id',$id);
		$this->db->update('fpd.khs_fp_operation_process_std',$data);
	}
}