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
							WHERE kaizen.status_date >= '$start' AND kaizen.created_date <= '$end' 
							and kaizen.status IN (7,9)";
							
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
							WHERE kaizen.no_kaizen = '$no' and kaizen.status <> 8";
		// print_r('<pre>'); print_r($sql); exit();
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getMember($id)
		{
			$id = substr($id, 0, 5);
			$date =  date('m');
			$date2 =  date('Y');
			$sql = "SELECT visu.user_name no_induk, visu.section_name SEKSI , visu.employee_name ,
						(SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND EXTRACT(YEAR FROM created_date) = $date2 
						 AND kai.status in ('3')) kaizen_approve_ide,
						(SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND EXTRACT(YEAR FROM created_date) = $date2 
						 AND kai.status = 9) kaizen_reported,
						(SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND EXTRACT(YEAR FROM created_date) = $date2 
						 AND (kai.status = 4 OR kai.status = 5)) kaizen_reject_revisi,
						(SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND EXTRACT(YEAR FROM created_date) = $date2 
						 AND kai.status = 2) kaizen_unchecked,
						 (SELECT COUNT(*) 
							FROM si.si_kaizen kai 
						 WHERE kai.noinduk = visu.user_name
						 AND EXTRACT(MONTH FROM created_date) = $date 
						 AND EXTRACT(YEAR FROM created_date) = $date2 
						 AND (kai.status = 0 OR kai.status = 1)) kaizen_created
				FROM sys.vi_sys_user_data visu 
				INNER JOIN er.er_employee_all emp ON emp.employee_code = visu.user_name
				WHERE emp.section_code like '$id%' AND emp.resign = 0";
		// print_r('<pre>'); print_r($sql); exit();
				
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	function getpekerja($id, $start, $end){

		$id = substr($id, 0, 5);
		$sql = "SELECT eel.employee_code,eel.employee_name, sk.kelompok, 
				(select count(*) from si.si_kaizen ssk where ssk.noinduk=eel.employee_code and extract (month from status_date) in (".substr($start, 5,2).",".substr($end, 5,2).") and extract (year from status_date)='".substr($start, 0,4)."' AND status <> '8' and status <> '9') as jml_ide,
				(select count(*) from si.si_kaizen ssk where ssk.noinduk=eel.employee_code and extract (month from status_date) in (".substr($start, 5,2).",".substr($end, 5,2).") and extract (year from status_date)='".substr($start, 0,4)."' AND status in ('1','2','3','4','5','6')) as inproses,
				(select count(*) from si.si_kaizen ssk where ssk.noinduk=eel.employee_code and extract (month from status_date) in (".substr($start, 5,2).",".substr($end, 5,2).") and extract (year from status_date)='".substr($start, 0,4)."' AND (status_date > '$start' or status_date=null) and status in ('7','9')) as done
				from er.er_employee_all eel
				left join si.si_kelompok sk on sk.noind=eel.employee_code
				where eel.section_code like '$id%' and eel.resign='0' 
				order by sk.kelompok,eel.employee_code";
				// echo $sql; exit();
		$query = $this->db->query($sql);
		return $query->result_array();

	}

	function getseksi($id , $start, $end){

		$id = substr($id, 0, 5);
		$sql = " SELECT kelompok, count(*) as target, sum(jml_ide) as jml_ide, sum(inproses) as inproses, sum(done) as done
				from (
				SELECT eel.employee_code,eel.employee_name, sk.kelompok, 
				(select count(*) from si.si_kaizen ssk where ssk.noinduk=eel.employee_code and extract (month from status_date) in (".substr($start, 5,2).",".substr($end, 5,2).") and extract (year from status_date)='".substr($start, 0,4)."' AND status <> '8' and status <> '9') as jml_ide,
				(select count(*) from si.si_kaizen ssk where ssk.noinduk=eel.employee_code and extract (month from status_date) in (".substr($start, 5,2).",".substr($end, 5,2).") and extract (year from status_date)='".substr($start, 0,4)."' AND status in ('1','2','3','4','5','6')) as inproses,
				(select count(*) from si.si_kaizen ssk where ssk.noinduk=eel.employee_code and extract (month from status_date) in (".substr($start, 5,2).",".substr($end, 5,2).") and extract (year from status_date)='".substr($start, 0,4)."' AND (status_date > '$start' or status_date=null) and status in ('7','9')) as done
				from er.er_employee_all eel
				left join si.si_kelompok sk on sk.noind=eel.employee_code
				where eel.section_code like '$id%' and eel.resign='0' 
				order by sk.kelompok,eel.employee_code ) tabel group by kelompok";
				// echo $sql; exit();
		$query = $this->db->query($sql);
		return $query->result_array();

	}
	
}