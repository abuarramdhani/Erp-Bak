<?php defined('BASEPATH') or die('No direct script access allowed');
class M_createimprovement extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function getSection()
	{
		$sql = "SELECT distinct(field_name) section_name FROM er.er_section";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getUser()
	{
		$sql = "SELECT * FROM sys.vi_sys_user su INNER JOIN er.er_employee_all ea ON ea.employee_code = su.employee_code 
				WHERE ea.resign = 0";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function saveDraftImprove1($data)
	{
		$this->db->insert('ia.ia_tbl_improvement_draft',$data);
		return $this->db->insert_id();
	}

	function check_existence($user,$date)
	{
		$sql = "SELECT * FROM ia.ia_tbl_improvement_draft draft WHERE draft.user = '$user' and draft.date = '$date'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function update_data($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('ia.ia_tbl_improvement_draft',$data);
	}

	function getAuditObject($id = null)
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

	function SaveImprovementList($data)
	{
		$this->db->insert('ia.ia_tbl_improvement_list',$data);
	}

	function getDataHeader($user_id, $date)
	{
		$sql = "SELECT * FROM ia.ia_tbl_improvement_draft id WHERE id.user = '$user_id' and id.date = '$date'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	function update_data_header($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('ia.ia_tbl_improvement',$data);
	}

	function SaveImprovementHeader($data)
	{
		$this->db->insert('ia.ia_tbl_improvement',$data);
		return $this->db->insert_id();
	}

	function deleteDraft($id_draft)
	{
		$this->db->where('id',$id_draft);
		$this->db->delete('ia.ia_tbl_improvement_draft');
	}


	function getDetailAuditee($id)
	{
		$sql = "SELECT os.*, ud2.user_name, ud2.employee_name
				FROM ia.ia_tbl_audit_object_staff os
				INNER JOIN sys.vi_sys_user_data ud2 ON ud2.user_id = os.staff_id
				where os.audit_object_id = '$id' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getDetailAuditor($id)
	{
		$sql = "SELECT oa.*, ud2.user_name, ud2.employee_name
				FROM ia.ia_tbl_audit_object_auditor oa
				INNER JOIN sys.vi_sys_user_data ud2 ON ud2.user_id = oa.auditor_id
				where oa.audit_object_id = '$id' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getStaffAuditee($term,$id)
	{
		$sql = "SELECT os.*, ud2.user_name, ud2.employee_name
				FROM ia.ia_tbl_audit_object_staff os
				INNER JOIN sys.vi_sys_user_data ud2 ON ud2.user_id = os.staff_id
				where os.audit_object_id = '$id'  ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getData($id = null)
	{
		if ($id == null) {
			$sql = "SELECT ao.*, ud.user_name, ud.employee_name
					FROM ia.ia_tbl_audit_object ao
					INNER JOIN sys.vi_sys_user_data ud ON ao.pic = ud.user_id order by id";
		}else{
			$sql = "SELECT ao.*, ud.user_name, ud.employee_name
					FROM ia.ia_tbl_audit_object ao
					INNER JOIN sys.vi_sys_user_data ud ON ao.pic = ud.user_id
					WHERE ao.id = '$id' order by id
					 ";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}