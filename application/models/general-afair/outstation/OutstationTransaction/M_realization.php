<?php
class M_Realization extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_realization(){
		$sql="select * from ga.ga_outstation_realization aa, ga.ga_outstation_area ar, ga.ga_outstation_city_type ct, er.er_employee_all emp, er.er_section sec where aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id and aa.employee_id=emp.employee_id and emp.section_code= sec.section_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	} 

	public function new_realization($employee_id,$area_id,$city_type_id,$depart,$return,$bon){
		$sql="insert into ga.ga_outstation_realization (employee_id,area_id,city_type_id,depart_time,return_time,bon_nominal) values ('$employee_id','$area_id','$city_type_id','$depart','$return','$bon')";
		$query = $this->db->query($sql);
		return;
	}

	public function new_realization_detail($component_id,$info,$qty,$component_nominal){
		$sql="insert into ga.ga_outstation_realization_detail (realization_id, component_id, info, qty, nominal) values ((select realization_id from ga.ga_outstation_realization order by realization_id desc limit 1),'$component_id','$info','$qty','$component_nominal')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_realization($realization_id){
		$sql="select * from ga.ga_outstation_realization aa, ga.ga_outstation_area ar, er.er_employee_all emp, er.er_section sec, ga.ga_outstation_city_type ct where aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id and aa.employee_id = emp.employee_id and emp.section_code = sec.section_code and aa.realization_id = '$realization_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function select_edit_realization_detail($realization_id){
		$sql="select * from ga.ga_outstation_realization_detail rel_det, ga.ga_outstation_realization real where rel_det.realization_id = real.realization_id and rel_det.realization_id = '$realization_id' order by rel_det.realization_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_realization($realization_id,$employee_id,$area_id,$city_type_id,$depart,$return,$bon){
		$sql="update ga.ga_outstation_realization set employee_id='$employee_id', area_id='$area_id', city_type_id='$city_type_id' where realization_id='$realization_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_before_update($realization_id){
		$sql="delete from ga.ga_outstation_realization_detail where realization_id='$realization_id'";
		$query = $this->db->query($sql);
		return;
	}
	public function update_realization_detail($realization_id,$component_id,$info,$qty,$component_nominal){
		$sql="insert into ga.ga_outstation_realization_detail (realization_id, component_id, info, qty, nominal) values ('$realization_id','$component_id','$info','$qty','$component_nominal')";
		$query = $this->db->query($sql);
		return;
	}

	public function show_meal_allowance($dest,$time_name){
		$sql="select * from ga.ga_outstation_meal_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_time ti where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.time_id=ti.time_id AND aa.area_id = '$dest' AND ti.time_name ILIKE '%$time_name%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_accomodation_allowance($dest,$type){
		$sql="select * from ga.ga_outstation_accomodation_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_city_type ct where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id AND aa.area_id = '$dest' AND aa.city_type_id = '$type'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_group_ush($return_time){
		$sql="select * from ga.ga_outstation_ush ush, ga.ga_outstation_groupush grp where ush.group_id = grp.group_id AND grp.time_1 <= '$return_time' AND grp.time_2 >= '$return_time'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_employee(){
		$sql="select * from er.er_employee_all where resign = 0 order by employee_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function show_position(){
		$sql="select * from ga.ga_outstation_position where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}


	public function show_area(){
		$sql="select * from ga.ga_outstation_area where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_city_type(){
		$sql="select * from ga.ga_outstation_city_type where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_component(){
		$sql="select * from ga.ga_outstation_component where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function delete_realization($realization_id){
		$sql="delete from ga.ga_outstation_realization where realization_id = '$realization_id'";
		$query = $this->db->query($sql);
		return;
	}	
}
?>