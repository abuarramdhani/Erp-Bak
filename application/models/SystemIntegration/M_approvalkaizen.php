<?php defined('BASEPATH') OR die('No direct script access allowed');
class M_approvalkaizen extends CI_Model
{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function updateReady($level, $kaizen_id, $val){
		$sql = "UPDATE si.si_approval SET ready = '$val' 
				WHERE kaizen_id = '$kaizen_id' AND level = '$level'";
		$query = $this->db->query($sql);
	}

	function getApprover($kaizen_id, $level_id=FALSE){
		if ($level_id === FALSE) {
			$sql = "SELECT siap.* , emplo.*
					FROM si.si_approval siap
					LEFT JOIN er.er_employee_all emplo ON siap.approver = emplo.employee_code
					WHERE siap.kaizen_id = $kaizen_id
					order by level";
		}else{
			$sql = "SELECT siap.* , emplo.*
					FROM si.si_approval siap
					LEFT JOIN er.er_employee_all emplo ON siap.approver = emplo.employee_code
					WHERE siap.kaizen_id = $kaizen_id
						AND siap.level = $level_id";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getMyApproval($employee_code = FALSE , $status = FALSE){
		if ($status === FALSE) {
			$sql = "SELECT *, approval.status status_approve
					FROM si.si_kaizen kaizen 
					INNER JOIN (SELECT approval1.* 
									FROM si.si_approval approval1
									INNER JOIN (SELECT max(level) levelist ,kaizen_id from si.si_approval where approver = '$employee_code' group by kaizen_id) approval2 
											ON approval1.level = approval2.levelist and approval1.kaizen_id = approval2.kaizen_id
									WHERE approval1.approver = '$employee_code') approval ON approval.kaizen_id = kaizen.kaizen_id
					WHERE approval.ready = '1'
					AND kaizen.status <> 8";
		}else{
			$sql = "SELECT *, approval.status status_approve
					FROM si.si_kaizen kaizen 
					INNER JOIN (SELECT approval1.* 
									FROM si.si_approval approval1
									INNER JOIN (SELECT max(level) levelist ,kaizen_id from si.si_approval where approver = '$employee_code' group by kaizen_id) approval2 
											ON approval1.level = approval2.levelist and approval1.kaizen_id = approval2.kaizen_id
									WHERE approval1.approver = '$employee_code') approval ON approval.kaizen_id = kaizen.kaizen_id
					WHERE approval.ready = '1'
					AND approval.status = $status
					AND kaizen.status <> 8";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function updateStatusApprove($kaizen_id,$employee_code,$status,$reason,$level=false){
		if ($level === false) {
			$sql = "UPDATE si.si_approval SET status = '$status' , reason = '$reason'
					WHERE approver ='$employee_code' AND kaizen_id = '$kaizen_id'";
		}else{
			$sql = "UPDATE si.si_approval SET status = '$status' , reason = '$reason'
					WHERE approver ='$employee_code' AND kaizen_id = '$kaizen_id' AND level = '$level'";			
		}
		$query = $this->db->query($sql);
		$sql2 = "SELECT level FROM si.si_approval 
				WHERE approver ='$employee_code' AND kaizen_id = '$kaizen_id' AND status <> '2' ";
		$query2 = $this->db->query($sql2);
		return $query2->result_array();
	}

	function UpdateStatus($id,$status,$status_date){
		$this->db->where('kaizen_id', $id);
		$this->db->update('si.si_kaizen', array('status' => $status,'status_date' => $status_date));
	}

	function getNumb($temp)
	{
		$sql = "SELECT max(no_kaizen) no_kaizen
				FROM si.si_kaizen
				WHERE no_kaizen like '$temp%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getRequester($id)
	{
		$sql = "SELECT noinduk
				FROM si.si_kaizen
				WHERE kaizen_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getSectCode($employee_code)
	{
		$sql = "SELECT coalesce(es.sort_code , department_name) code
				FROM er.er_section es
				INNER JOIN er.er_employee_all em ON em.section_code = es.section_code 
				WHERE em.employee_code = '$employee_code' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	
	function getName($user_id){
		$sql = "SELECT employee_name
				FROM er.er_employee_all
				WHERE employee_code = '$user_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getSectAll($id)
	{
		$sql = "SELECT sec.*
				FROM sys.vi_sys_user_data visu
				INNER JOIN er.er_section sec ON sec.section_code = visu.section_code
				WHERE visu.user_name = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


}