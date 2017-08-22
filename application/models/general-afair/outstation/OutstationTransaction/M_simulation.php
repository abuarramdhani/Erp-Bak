<?php
class M_Simulation extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function show_simulation(){
		$sql="select * from (select * from ga.ga_outstation_simulation aa, er.er_employee_all emp, er.er_section sec, ga.ga_outstation_city ct where aa.city_id=ct.city_id and aa.employee_id = emp.employee_id and emp.section_code = sec.section_code) simulation, (select simulation_id, sum(meal_allowance_nominal) meal_nominal, sum(acomodation_allowance_nominal) accomodation_nominal, sum(ush_nominal) ush_nominal from ga.ga_outstation_simulation_detail group by simulation_id) nominal
where simulation.simulation_id = nominal.simulation_id order by simulation.simulation_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function new_simulation($employee_id,$city_id,$area_id,$city_type_id,$depart,$return,$include_acc){
		$sql="insert into ga.ga_outstation_simulation (employee_id, city_id, area_id, city_type_id, depart_time, return_time, accomodation_option) values ('$employee_id','$city_id','$area_id','$city_type_id','$depart','$return','$include_acc')";
		$query = $this->db->query($sql);
		return;
	}

	public function new_simulation_detail($date,$time_id,$ma_nominal,$acc_nominal,$group_id,$ush_nominal){
		$sql="insert into ga.ga_outstation_simulation_detail (simulation_id, inn_date, time_id, meal_allowance_nominal, acomodation_allowance_nominal, group_id, ush_nominal) values ((select simulation_id from ga.ga_outstation_simulation order by simulation_id desc limit 1),'$date','$time_id','$ma_nominal','$acc_nominal',$group_id,'$ush_nominal')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_simulation($simulation_id){
		$sql="select * from ga.ga_outstation_simulation aa, ga.ga_outstation_area ar, er.er_employee_all emp, er.er_section sec, ga.ga_outstation_city_type ct, ga.ga_outstation_position op where aa.area_id=ar.area_id and emp.outstation_position = op.position_id and aa.city_type_id=ct.city_type_id and aa.employee_id = emp.employee_id and emp.section_code = sec.section_code and aa.simulation_id = '$simulation_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function select_simulation_detail($simulation_id){
		$sql="select * from ga.ga_outstation_simulation_detail sim_det, ga.ga_outstation_time time where sim_det.time_id = time.time_id AND sim_det.simulation_id = '$simulation_id' order by sim_det.inn_date, sim_det.time_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function sum_simulation_nominal($simulation_id){
		$sql="select sum(meal_allowance_nominal) as meal_nominal,sum(acomodation_allowance_nominal) as accomodation_nominal,sum(ush_nominal) as ush_nominal from ga.ga_outstation_simulation_detail where simulation_id = '$simulation_id' group by simulation_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_group_ush_all(){
		$sql="select * from ga.ga_outstation_groupush";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_simulation($simulation_id,$employee_id,$city_id,$area_id,$city_type_id,$depart,$return,$include_acc){
		$sql="update ga.ga_outstation_simulation set employee_id = '$employee_id', city_id='$city_id', area_id='$area_id', city_type_id='$city_type_id', depart_time='$depart', return_time='$return', accomodation_option='$include_acc' where simulation_id='$simulation_id'";
		$query = $this->db->query($sql);
		return;
	}
	public function delete_before_insert($simulation_id){
		$sql="delete from ga.ga_outstation_simulation_detail where simulation_id = '$simulation_id'";
		$query = $this->db->query($sql);
		return;
	}
	public function update_simulation_detail($simulation_id,$date,$time_id,$ma_nominal,$acc_nominal,$group_id,$ush_nominal){
		$sql="insert into ga.ga_outstation_simulation_detail (simulation_id, inn_date, time_id, meal_allowance_nominal, acomodation_allowance_nominal, group_id, ush_nominal) values ('$simulation_id','$date','$time_id','$ma_nominal','$acc_nominal',$group_id,'$ush_nominal')";
		$query = $this->db->query($sql);
		return;
	}

	public function show_employee(){
		$sql="select * from er.er_employee_all where resign = 0 OR resign is null order by employee_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_meal_allowance($position_id,$dest,$time_name){
		$sql="select * from ga.ga_outstation_meal_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_time ti where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.time_id=ti.time_id AND op.position_id = '$position_id' AND aa.area_id = '$dest' AND ti.time_name ILIKE '%$time_name%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_accomodation_allowance($position_id,$dest,$type){
		$sql="select * from ga.ga_outstation_accomodation_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar, ga.ga_outstation_city_type ct where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id AND op.position_id = '$position_id' AND aa.area_id = '$dest' AND aa.city_type_id = '$type'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_group_ush($position_id,$return_time,$have_sunday,$is_foreign){
		$sql="select * from ga.ga_outstation_ush ush, ga.ga_outstation_groupush grp, ga.ga_outstation_position op where ush.group_id = grp.group_id AND ush.position_id = op.position_id AND op.position_id = '$position_id' AND grp.time_1 <= '$return_time' AND grp.time_2 >= '$return_time' AND grp.holiday = '$have_sunday' AND grp.foreign = '$is_foreign'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function check_holiday($depart,$return){
		$sql="select * from ga.ga_outstation_holiday where tanggal between '$depart' AND '$return'";
		$query = $this->db->query($sql);
		return $query->num_rows();
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

	public function delete_simulation($simulation_id){
		$sql="delete from ga.ga_outstation_simulation where simulation_id = '$simulation_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function show_city(){
		$sql="select *from ga.ga_outstation_city where end_date > now()";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
}
?>