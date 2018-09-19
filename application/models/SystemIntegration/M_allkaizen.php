<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_allkaizen extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	function getKaizenTeam($status = FALSE )
		{
			if ($status === FALSE) {
				$sql = "SELECT kaizen.* ,section.section_name
								,section.unit_name
								,section.department_name
						FROM si.si_kaizen kaizen
							LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
							LEFT JOIN er.er_section section ON employee.section_code = section.section_code
						WHERE kaizen.status <> 8 ";
			}else{
				$sql = "SELECT kaizen.* ,section.section_name
								,section.unit_name
								,section.department_name
						FROM si.si_kaizen kaizen
							LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
							LEFT JOIN er.er_section section ON employee.section_code = section.section_code
						WHERE kaizen.status = $status ";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getApprover($kaizen_id, $level_id=FALSE){
		if ($level_id === FALSE) {
			$sql = "SELECT siap.* , emplo.*
					FROM si.si_approval siap
					LEFT JOIN er.er_employee_all emplo ON siap.approver = emplo.employee_code
					WHERE siap.kaizen_id = $kaizen_id";
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
}