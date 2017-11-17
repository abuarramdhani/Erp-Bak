<?php
class M_penilaiankinerja extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
		
// ADD MASTER PENILAIAN KINERJA
public function AddMaster($startdate, $enddate, $dept, $unit, $section)
{
	$sql="";
	$query= $this->db->query($sql);
	$insert_id = $this->db->insert_id();
	return  $insert_id;
}
	
//--------------------------------JAVASCRIPT RELATED--------------------------//	


    public function GetDepartemen($term){
		if ($term === FALSE) {
			$iftermtrue = "";
		}else{
			$iftermtrue = "WHERE (department_name ILIKE '%$term%')";}
		
		$sql = "
				select department_name
				from er.er_section $iftermtrue
				group by department_name
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    public function GetUnit($term){
		if ($term === FALSE) {
			$iftermtrue = "";
		}else{
			$iftermtrue = "WHERE (unit_name ILIKE '%$term%')";}
		
		$sql = "
				select unit_name
				from er.er_section $iftermtrue
				group by unit_name
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    public function GetSeksi($term){
		if ($term === FALSE) {
			$iftermtrue = "";
		}else{
			$iftermtrue = "WHERE (section_name ILIKE '%$term%')";}
		
		$sql = "
				select section_name 
				from er.er_section $iftermtrue
				group by section_name
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetNoInduk($term){
			if ($term === FALSE) {
				$sql = "
					SELECT * FROM er.er_employee_all WHERE resign = '0' ORDER BY employee_code ASC
				";
			}
			else{
				$sql = "
					SELECT * FROM er.er_employee_all WHERE resign = '0' AND (employee_code ILIKE '%$term%' OR employee_name ILIKE '%$term%') ORDER BY employee_code ASC
				";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}