<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_mykaizen extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	function getMyKaizen($userId, $id = FALSE, $status = FALSE)
		{
			if($id === FALSE) {
				if($status === FALSE) {
					$sql = "SELECT kaizen.*
										,section.section_name
										,section.unit_name
										,section.department_name
							FROM si.si_kaizen kaizen
								LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
								LEFT JOIN er.er_section section ON employee.section_code = section.section_code
							WHERE kaizen.status <> '8' and kaizen.user_id = $userId";
					$query = $this->db->query($sql);
					// $query = $this->db->get_where('kaizen', array('user_id' => $userId, 'delete_status' => 0));	
				} else {
					// $query = $this->db->get_where('kaizen', array('user_id' => $userId, 'delete_status' => 0, 'status' => $status));
					$sql = "SELECT kaizen.*
										,section.section_name
										,section.unit_name
										,section.department_name
							FROM si.si_kaizen kaizen
								LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
								LEFT JOIN er.er_section section ON employee.section_code = section.section_code
							WHERE kaizen.user_id = $userId  AND kaizen.status = $status";
					$query = $this->db->query($sql);
				}
			} else {
				// $query = $this->db->get_where('kaizen', array('id' => $id, 'user_id' => $userId, 'delete_status' => 0));
					$sql = "SELECT kaizen.*
										,section.section_name
										,section.unit_name
										,section.department_name
							FROM si.si_kaizen kaizen
								LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
								LEFT JOIN er.er_section section ON employee.section_code = section.section_code 
							WHERE kaizen.kaizen_id = $id kaizen.user_id = $userId";
					$query = $this->db->query($sql);
			}
			
			return $query->result_array();
		}

	function getApprover($kaizen_id, $level_id=FALSE){
		if ($level_id === FALSE) {
			$sql = "SELECT siap.* , emplo.*
					FROM si.si_approval siap
					LEFT JOIN er.er_employee_all emplo ON siap.approver = emplo.employee_code
					WHERE siap.kaizen_id = $kaizen_id order by siap.level";
		}else{
			$sql = "SELECT siap.* , emplo.*
					FROM si.si_approval siap
					LEFT JOIN er.er_employee_all emplo ON siap.approver = emplo.employee_code
					WHERE siap.kaizen_id = $kaizen_id
						AND siap.level = $level_id ";
		}
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

	function updateReady($level, $kaizen_id, $val){
		$sql = "UPDATE si.si_approval SET ready = '$val' 
				WHERE kaizen_id = '$kaizen_id' AND level = '$level'";
		$query = $this->db->query($sql);
	}
}