<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_report extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	function getKaizenExport($start,$end)
		{
			$sql = "SELECT kaizen.*
									,section.section_name
									,section.unit_name
									,section.department_name
							FROM si.si_kaizen kaizen
								LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
								LEFT JOIN er.er_section section ON employee.section_code = section.section_code
							WHERE kaizen.created_date >= '$start' AND kaizen.created_date <= '$end' ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getKaizenByNo($no)
		{
			$sql = "SELECT kaizen.*
									,section.section_name
									,section.unit_name
									,section.department_name
							FROM si.si_kaizen kaizen
								LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
								LEFT JOIN er.er_section section ON employee.section_code = section.section_code
							WHERE kaizen.no_kaizen = '$no'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getMember($id)
		{
			$id = substr($id, 0, 7);
			$date =  date('m');
			$sql = "SELECT visu.user_name no_induk, visu.section_name SEKSI , visu.employee_name ,
						(SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND kai.status = 3) kaizen_approve_ide,
						(SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND kai.status = 9) kaizen_reported,
						(SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND (kai.status = 4 OR kai.status = 5)) kaizen_reject_revisi,
						(SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND kai.status = 2) kaizen_unchecked,
						 (SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND (kai.status = 0 OR kai.status = 1)) kaizen_created
				FROM sys.vi_sys_user_data visu 
				INNER JOIN er.er_employee_all emp ON emp.employee_code = visu.user_name
				WHERE emp.section_code like '$id%' AND emp.resign = 0";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}