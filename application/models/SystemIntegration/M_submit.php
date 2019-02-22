<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_submit extends CI_Model
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

	function setKaizen($data)
		{
			$this->db->insert('si.si_kaizen', $data);
		}

	function getKaizen($id = FALSE, $status = FALSE)
		{
			if($id === FALSE) {
				if($status === FALSE) {
					// $query = $this->db->get_where('kaizen', array('delete_status' => 0));
					$sql = "SELECT kaizen.*
									,section.section_name
									,section.unit_name
									,section.department_name
							FROM si.si_kaizen kaizen
								LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
								LEFT JOIN er.er_section section ON employee.section_code = section.section_code
							WHERE kaizen.status <> '8'";
					$query = $this->db->query($sql);	
				} else {
					// $query = $this->db->get_where('kaizen', array('delete_status' => 0, 'status' => $status));
					$sql = "SELECT kaizen.*
									,section.section_name
									,section.unit_name
									,section.department_name
							FROM si.si_kaizen kaizen
								LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
								LEFT JOIN er.er_section section ON employee.section_code = section.section_code
							WHERE kaizen.status = $status";
					$query = $this->db->query($sql);
				}
			} else {
					// $query = $this->db->get_where('kaizen', array('id' => $id, 'delete_status' => 0));
					$sql = "SELECT kaizen.*
									,section.section_name
									,section.unit_name
									,section.department_name
							FROM si.si_kaizen kaizen
								LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
								LEFT JOIN er.er_section section ON employee.section_code = section.section_code
							WHERE kaizen.kaizen_id = $id AND kaizen.status <> '8'";
					$query = $this->db->query($sql);
			}
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

	function getAllUser(){
		$query = $this->db->get('sys.sys_user');
		return $query->result_array();
	}

	function getAtasan($noind , $jabatan){
		$data = array();
		$kodesie = $this->session->kodesie;
		$kodesie_subs = substr($kodesie, 0,4);
		$personalia = $this->load->database('personalia',true);
		$sql1 		= "SELECT kd_jabatan FROM hrd_khs.tpribadi WHERE noind = '$noind'";
		$query1 	= $personalia->query($sql1);
		$result1 	= $query1->result_array();
		$jabatan_user = $result1[0]['kd_jabatan'];

		// 
		if ($jabatan == '1') {
			$jabatan2 = str_pad($jabatan_user-1,2,"0",STR_PAD_LEFT);
			$where = " c.kd_jabatan between  '01' and '$jabatan2' ";
		}elseif ($jabatan == '2') { // 2
			$jabatan2 = str_pad($jabatan_user-2,2,"0",STR_PAD_LEFT);
			$where = " c.kd_jabatan between  '01' and '$jabatan2' ";
		}elseif ($jabatan == '3') { // 3 untuk level department
			$where = " c.kd_jabatan in  ('02','03','04')";
		}elseif ($jabatan == '4') {
			$where = "c.kd_jabatan = '01'";
		}
		
		$sql2 = "SELECT 
					a.noind employee_code
					,a.nama employee_name,
					c.* 
					,b.bidang
				FROM hrd_khs.tpribadi a 
					INNER JOIN hrd_khs.tseksi b on a.kodesie=b.kodesie
					INNER JOIN hrd_khs.torganisasi c on a.kd_jabatan=c.kd_jabatan
				WHERE $where
					and substring( a.kodesie, 1, 4 )=(
										SELECT substring( kodesie, 1, 4 )
										FROM hrd_khs.tpribadi d
										WHERE d.noind = '$noind'
											 and d.keluar = '0')
					and a.keluar ='0'

				ORDER BY a.noind,a.nama";
		$query2 = $personalia->query($sql2);
		$result2 = $query2->result_array();

		if ($jabatan == '2') {
			if (!$result2) {
				$sql3 = "SELECT su.user_name employee_code , su.employee_name FROM si.si_approver_khusus ak 
							LEFT JOIN sys.vi_sys_user su ON su.user_name =  ak.no_induk
						WHERE ak.kodesie = '$kodesie_subs' ";
				$query3 = $this->db->query($sql3);
				$result3 = $query3->result_array();
				$result2 = $result3;
			}
		}
		$allAtasan = $this->getAllUser();
			foreach ($allAtasan as $key => $value) {
				$arrayUser[] = $value['user_name'];
			}

			foreach ($result2 as $key => $value) {
				if (in_array($value['employee_code'], $arrayUser) === true) {
					$data[] = $value;
				}
			}

		return $data;

	}

	function SaveApprover($data){
		$this->db->insert('si.si_approval',$data);
	}

	function getEmail($code){
		$query = $this->db->get_where('er.er_employee_all',array('employee_code' => $code));
		return $query->result_array();
	}

	function checkExist($data){
		$query = $this->db->get_where('si.si_approval',$data);
		return $query->num_rows();
	}

	function getEmailTemplate($id){
		$query = $this->db->get_where('si.si_email_template',array('status' => $id));
		return $query->result_array();
	}

	function DeleteApprover($id){
		$this->db->where('kaizen_id', $id);
		$this->db->delete('si.si_approval');
	}

	function UpdateStatus($id,$status,$status_date){
		$this->db->where('kaizen_id', $id);
		$this->db->update('si.si_kaizen', array('status' => $status,'status_date' => $status_date));
	}

	function saveUpdate($id,$data){
		$this->db->where('kaizen_id', $id);
		$this->db->update('si.si_kaizen', $data);
	}

	function DeleteApproverByApprover($kaizen_id,$idexist){
		$sql = "DELETE FROM si.si_approval WHERE approver not in ('".$idexist."') AND kaizen_id = $kaizen_id";
		$query = $this->db->query($sql);
	}

	function ResetApprover($kaizen_id,$idexist,$pertama){
		$sql = "UPDATE si.si_approval SET status = '2' , reason = NULL WHERE approver in ('".$idexist."') AND kaizen_id = $kaizen_id";
		$query = $this->db->query($sql);
		$sql2 = "UPDATE si.si_approval SET ready = '0' WHERE level <> $pertama AND kaizen_id = $kaizen_id";
		$query2 = $this->db->query($sql2);
	}


	function getKaizenTeam($employee_code = FALSE , $status = FALSE )
	{
		if ($status === FALSE) {
			$sql = "SELECT kaizen.* ,section.section_name
							,section.unit_name
							,section.department_name
					FROM si.si_kaizen kaizen
						LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
						LEFT JOIN er.er_section section ON employee.section_code = section.section_code
					WHERE (section.section_name = 
					(SELECT sect.section_name FROM er.er_employee_all emplo 
						INNER JOIN er.er_section sect ON emplo.section_code = sect.section_code
						WHERE emplo.employee_code = '$employee_code')
					OR section.unit_name = 
					(SELECT sect2.section_name FROM er.er_employee_all emplo2 
						INNER JOIN er.er_section sect2 ON emplo2.section_code = sect2.section_code
						WHERE emplo2.employee_code = '$employee_code'))
					AND kaizen.status <> 8 ";
		}else{
			$sql = "SELECT kaizen.* ,section.section_name
							,section.unit_name
							,section.department_name
					FROM si.si_kaizen kaizen
						LEFT JOIN er.er_employee_all employee ON employee.employee_code = kaizen.noinduk
						LEFT JOIN er.er_section section ON employee.section_code = section.section_code
					WHERE (section.section_name = 
					(SELECT sect.section_name FROM er.er_employee_all emplo 
						INNER JOIN er.er_section sect ON emplo.section_code = sect.section_code
						WHERE emplo.employee_code = '$employee_code')
					OR section.unit_name = 
					(SELECT sect2.section_name FROM er.er_employee_all emplo2 
						INNER JOIN er.er_section sect2 ON emplo2.section_code = sect2.section_code
						WHERE emplo2.employee_code = '$employee_code'))
					AND kaizen.status = $status ";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function getMasterItem($term=FALSE,$id=FALSE)
	{
		$oracle = $this->load->database('oracle',TRUE);
		$oracle = $this->load->database('oracle',TRUE);
		if($id===FALSE){	
			$sql = "SELECT DISTINCT(SEGMENT1) segment1, DESCRIPTION item_name ,INVENTORY_ITEM_ID
					FROM mtl_system_items_b 
					WHERE segment1 like '%$term%' or description like '%$term%'";
		}else{
			if($term == FALSE){
				$sql = "SELECT DISTINCT(SEGMENT1) segment1, DESCRIPTION item_name ,INVENTORY_ITEM_ID
					FROM mtl_system_items_b 
					WHERE INVENTORY_ITEM_ID = '$id'";
			}
		}
		$query = $oracle->query($sql);
		return $query->result_array();
	}


	function getKodeJabatan($noinduk)
	{
		$personalia = $this->load->database('personalia',true);
		$sql1 		= "SELECT kd_jabatan FROM hrd_khs.tpribadi WHERE noind = '$noinduk'";
		$query1 	= $personalia->query($sql1);
		$result1 	= $query1->result_array();
		$jabatan_user = $result1[0]['kd_jabatan'];
		$jabatan2 = str_pad($jabatan_user,2,"0",STR_PAD_LEFT);
		return $jabatan2;
	}

}