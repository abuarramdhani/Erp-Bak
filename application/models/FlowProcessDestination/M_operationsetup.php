<?php defined('BASEPATH') or die('No direct script access allowed');
class M_operationsetup extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
		$this->db2 = $this->load->database('lantuma',TRUE);
	}

	function getOperation($id)
	{
		$sql = " SELECT fo.*, fops.operation_process_std, fops.operation_process_std_desc FROM fpd.khs_fp_operations fo
				 LEFT JOIN fpd.khs_fp_operation_process_std fops on fops.operation_process_std_id = fo.operation_process
				 WHERE component_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	function getOperation2($component_id)
	{
		$sql = " SELECT fo.*, fops.operation_process_std, fops.operation_process_std_desc FROM fpd.khs_fp_operations fo
				 LEFT JOIN fpd.khs_fp_operation_process_std fops on fops.operation_process_std_id = fo.operation_process
				 WHERE component_id = '$component_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getTool($param)
	{
		$sql = "SELECT * from torder tto WHERE tto.fs_nm_tool like '%$param%'";
		$query = $this->db2->query($sql);
		return $query->result_array();
	}

	function getToolName($nomor)
	{
		$sql = "SELECT * from torder tto WHERE tto.fs_no_order ='$nomor'";
		$query = $this->db2->query($sql);
		$result =  $query->result_array();
		if ($result){
			return '('.$result[0]['fs_nm_tool'].')'.$result[0]['fs_kd_komp'].' '.$result[0]['fs_nm_komp'];
		}else{
			return '';
		}
	}

	function getProcess()
	{
		$sql = "SELECT * FROM fpd.khs_fp_operation_process_std";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function saveOperation($data)
	{
		$this->db->insert('fpd.khs_fp_operations',$data);
		return $this->db->insert_id();
	}
	function saveOperation1($ci,$date_now ,$user_id,$date_now,$da,$sn,$pl,$op,$pd,$mmr,$pt,$ti,$pmt,$mt,$oc,$od, $uloc,$ulod,$osn,$ort)
	{
		$sql= "INSERT INTO fpd.khs_fp_operations (component_id, creation_date, created_by, start_date_active,operation_seq_num, planning_make_buy, operation_process, operation_process_detail, machine_min_requirement, planning_tool, tool_id, planning_measurement_tool, measurement_tool_id, oracle_code, oracle_description, upper_lvl_oracle_code, upper_lvl_oracle_desc,oracle_operation_seq_num, oracle_resource_type) 
		VALUES ('$ci', '$date_now', '$user_id', '$date_now', '$sn', '$pl', '$op', '$pd', '$mmr', '$pt', '$ti', '$pmt', '$mt', '$oc', '$od', '$uloc', '$ulod', '$osn', '$ort')";
		$query = $this->db->query($sql);
		return $sql;
	}

	function updateFileOperation($id, $data)
	{
		$this->db->where('operation_id',$id);
		$this->db->update('fpd.khs_fp_operations',$data);
	}

	function deleteOperation($id)
	{
		$this->db->where('operation_id', $id);
		$this->db->delete('fpd.khs_fp_operations');
	}

	function getOperationById($id)
	{
		$sql ="SELECT * FROM fpd.khs_fp_operations WHERE operation_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getDataOperation($operation_id,$component_id)
	{
		$sql ="SELECT * FROM fpd.khs_fp_operations WHERE operation_id = '$operation_id' and component_id = '$component_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function deleteFIleGambar($operation_id,$data)
	{
		$this->db->where('operation_id', $operation_id);
		$this->db->update('fpd.khs_fp_operations', $data);
	}

	function saveEditOperation($operation_id,$data)
	{
		$this->db->where('operation_id', $operation_id);
		$this->db->update('fpd.khs_fp_operations', $data);
	}

	function getInfoTool($nomor)
	{
		$sql = "SELECT * from torder tto WHERE tto.fs_no_order ='$nomor'";
		$query = $this->db2->query($sql);
		return $query->result_array();
	}
}