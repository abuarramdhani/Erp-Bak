<?php defined('BASEPATH') or die('No direct script access allowed');
class M_settingaccount extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

	function getUserErp($id=null)
	{
		if ($id == null) {
			$sql = "SELECT * FROM sys.vi_sys_user su INNER JOIN er.er_employee_all ea ON ea.employee_code = su.employee_code 
					WHERE ea.resign = 0";
		}else{
			$sql = "SELECT * FROM sys.vi_sys_user su INNER JOIN er.er_employee_all ea ON ea.employee_code = su.employee_code 
					WHERE ea.resign = 0 AND su.user_id = '$id'";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function SaveAuditProject($data)
	{
		$this->db->insert('ia.ia_tbl_audit_object',$data);
		return $this->db->insert_id();
	}

	function SaveEditAuditProject($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('ia.ia_tbl_audit_object',$data);
	}

	function cek_exist($id,$staff)
	{
		$sql = "SELECT * FROM ia.ia_tbl_audit_object_staff WHERE audit_object_id = '$id' and staff_id = '$staff'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function cek_exist_auditor($id,$auditor)
	{
		$sql = "SELECT * FROM ia.ia_tbl_audit_object_auditor WHERE audit_object_id = '$id' and auditor_id = '$auditor'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function SaveStaff($data)
	{
		$this->db->insert('ia.ia_tbl_audit_object_staff',$data);
		return $this->db->insert_id();
	}

	function SaveAuditor($data)
	{
		$this->db->insert('ia.ia_tbl_audit_object_auditor',$data);
		return $this->db->insert_id();
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

	function getDetail($id)
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

	function deleteYangGakExist($id, $staff_id_exist)
	{
		$sql = "DELETE FROM ia.ia_tbl_audit_object_staff WHERE audit_object_id = '$id' and id not in ('$staff_id_exist')";
		$query = $this->db->query($sql);
	}

	function deleteAuditorYangGakExist($id, $auditor_id_exist)
	{
		$sql = "DELETE FROM ia.ia_tbl_audit_object_auditor WHERE audit_object_id = '$id' and id not in ('$auditor_id_exist')";
		$query = $this->db->query($sql);
	}

	function DeleteAudit($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('ia.ia_tbl_audit_object');

		$this->db->where('audit_object_id',$id);
		$this->db->delete('ia.ia_tbl_audit_object_staff');
	}

	function getUserAccount($id)
	{
		$sql ="SELECT * FROM ia.ia_tb_user_profile WHERE user_id = '$id' ";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function updateUserAccount($id, $data)
	{
		$this->db->where('user_id',$id);
		$this->db->update('ia.ia_tb_user_profile',$data);
	}

	function insertUserAccount($idata)
	{
		$this->db->insert('ia.ia_tb_user_profile',$idata);
	}

	function getUserData($id)
	{
		$sql = "SELECT sd.user_id, sd.user_name no_induk, sd.section_name,sd.employee_name, up.*
				FROM sys.vi_sys_user_data sd 
				LEFT JOIN ia.ia_tb_user_profile up ON sd.user_id = up.user_id
				WHERE sd.user_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}