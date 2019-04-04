<?php defined('BASEPATH') or die('No direct script access allowed');
class M_monitoringimprovement extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function getDataImprovement($id = null)
	{
		if ($id == null) {
			$sql = "SELECT ti.*, ao.audit_object audit_object_name
					FROM ia.ia_tbl_improvement ti 
					INNER JOIN ia.ia_tbl_audit_object ao ON ao.id = ti.audit_object";
		}else{
			$sql = "SELECT ti.*, ao.audit_object audit_object_name
					FROM ia.ia_tbl_improvement ti 
					INNER JOIN ia.ia_tbl_audit_object ao ON ao.id = ti.audit_object
					WHERE ti.id = '$id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getDetailImprovement($id)
	{
		$sql = "SELECT iml.* , ist.status status_name , su.employee_name pic_name, su2.employee_name created_by_name,
				su3.employee_name updated_by_name
				FROM ia.ia_tbl_improvement_list iml 
				INNER JOIN ia.ia_tbl_improvement_status ist ON ist.id = iml.status
				INNER JOIN sys.vi_sys_user su ON su.user_id = iml.pic
				LEFT JOIN sys.vi_sys_user su2 ON su2.user_id = iml.created_by
				LEFT JOIN sys.vi_sys_user su3 ON su3.user_id = iml.updated_by
				WHERE iml.improvement_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getDataImprovementList($id)
	{
		$sql = "SELECT * FROM ia.ia_tbl_improvement_list WHERE id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getAuditObject($id)
	{
		$sql = "SELECT distinct(audit_object_id) audit_object FROM ia.ia_tbl_audit_object_staff WHERE staff_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

		function getAuditObjectSelect($id = null)
	{
		if ($id == null) {
			$sql = "SELECT ao.*, ud.user_name, ud.employee_name
					FROM ia.ia_tbl_audit_object ao
					INNER JOIN sys.vi_sys_user_data ud ON ao.pic = ud.user_id
					 ";
		}else{
			$sql = "SELECT ao.*, ud.user_name, ud.employee_name
					FROM ia.ia_tbl_audit_object ao
					INNER JOIN sys.vi_sys_user_data ud ON ao.pic = ud.user_id
					WHERE ao.id = '$id'";			
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getDataImprovementAuditee($id)
	{
		$sql = "SELECT ti.*, ao.audit_object audit_object_name
				FROM ia.ia_tbl_improvement ti 
				INNER JOIN ia.ia_tbl_audit_object ao ON ao.id = ti.audit_object 
				WHERE ti.audit_object in ('$id')";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function DeleteImprovement($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('ia.ia_tbl_improvement');
	}

	function DeleteImprovementList($id)
	{
		$this->db->where('improvement_id',$id);
		$this->db->delete('ia.ia_tbl_improvement_list');
	}

	function DeleteImprovementListByImprovementListId($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('ia.ia_tbl_improvement_list');
	}

	function DeleteProgressByImprovementListId($id)
	{
		$sql = "SELECT pi.*
				FROM ia.ia_tbl_progress_improvement pi
					INNER JOIN ia.ia_tbl_history_progress_improvement hpi ON hpi.progress_id = pi.id
				WHERE pi.improvement_list_id = '$id'";
		$query = $this->db->query($sql);
		$res1 = $query->result_array();
		foreach ($res1 as $key => $value) {
			$id2 = $value['id'];
			$sql2 = "DELETE FROM ia.ia_tbl_history_progress_improvement WHERE progress_id= '$id2'";
			$this->db->query($sql2);
		}

		$sql3 = "DELETE FROM ia.ia_tbl_progress_improvement WHERE improvement_list_id = '$id'";
		$this->db->query($sql3);
	}

	function DeleteProgressImprovement($id)
	{
		$sql = "SELECT pi.*
				FROM ia.ia_tbl_progress_improvement pi
					INNER JOIN ia.ia_tbl_history_progress_improvement hpi ON hpi.progress_id = pi.id
				WHERE pi.improvement_id = '$id'";
		$query = $this->db->query($sql);
		$res1 = $query->result_array();
		foreach ($res1 as $key => $value) {
			$id2 = $value['id'];
			$sql2 = "DELETE FROM ia.ia_tbl_history_progress_improvement WHERE id= '$id2'";
			$this->db->query($sql2);
		}

		$sql3 = "DELETE FROM ia.ia_tbl_progress_improvement WHERE improvement_id = '$id'";
		$this->db->query($sql3);
	}

	function getProgress($id)
	{
		$sql = "
				SELECT pi.*, su.user_name created_by_noinduk , su.employee_name created_by_name
				FROM ia.ia_tbl_progress_improvement pi
				INNER JOIN sys.vi_sys_user su ON pi.created_by = su.user_id
				WHERE pi.improvement_list_id = '$id' order by id DESC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getProgressByImprovementId($id)
	{
		$sql = "
				SELECT pi.*, su.user_name created_by_noinduk , su.employee_name created_by_name
				FROM ia.ia_tbl_progress_improvement pi
				INNER JOIN sys.vi_sys_user su ON pi.created_by = su.user_id
				WHERE pi.improvement_id = '$id' order by id DESC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getProgressByImprovemenListtId($id)
	{
		$sql = "
				SELECT pi.*, su.user_name created_by_noinduk , su.employee_name created_by_name
				FROM ia.ia_tbl_progress_improvement pi
				INNER JOIN sys.vi_sys_user su ON pi.created_by = su.user_id
				WHERE pi.improvement_list_id = '$id' order by id DESC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function SaveProgress($data)
	{
		$this->db->insert('ia.ia_tbl_progress_improvement',$data);
		return $this->db->insert_id();
	}


	function UpdateProgress($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('ia.ia_tbl_progress_improvement',$data);
	}


	function SaveProgressHistory($data)
	{
		$this->db->insert('ia.ia_tbl_history_progress_improvement',$data);
		return $this->db->insert_id();
	}

	function getUpdateHistory($id)
	{
		$sql = "SELECT hpi.*, su.employee_name updated_by_name 
				FROM ia.ia_tbl_history_progress_improvement hpi
				INNER JOIN sys.vi_sys_user su ON hpi.updated_by = su.user_id 
				WHERE hpi.progress_id = '$id'
				order by id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function updateImprovementList($id, $data)
	{
		$this->db->where('id',$id);
		$this->db->update('ia.ia_tbl_improvement_list',$data);
	}

	function getSection()
	{
		$sql = "SELECT distinct(field_name) section_name FROM er.er_section";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function SaveUpdateImprovement($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('ia.ia_tbl_improvement',$data);
	}
}