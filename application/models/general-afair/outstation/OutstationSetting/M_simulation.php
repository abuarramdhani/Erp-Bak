<?php
class M_Simulation extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_simulation(){
		$sql="select * from ga.ga_outstation_simulation aa, ga.ga_outstation_area ar
		, ga.ga_outstation_city_type ct where aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	} 

	public function new_simulation($employee_id,$area_id ,$city_type,$depart,$return){
		$sql="insert into ga.ga_outstation_simulation (employee_id,area_id,city_type_id,depart_time,return_time) values ('$employee_id','$area_id','$city_type','$depart','$return')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_simulation($simulation){
		$sql="select * from ga.ga_outstation_simulation where simulation_id = '$simulation'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_simulation($simulation,$position_id,$area_id,$city_type,$nominal,
			$start_date,$end_date){
		$sql="update ga.ga_outstation_simulation set  area_id='$area_id',city_type_id='$city_type'where simulation_id='$simulation'";
		$query = $this->db->query($sql);
		return;
	}

	public function show_employee(){
		$sql="select * from er.er_employee_all where resign = 0 OR resign is null order by employee_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_meal_allowance($waktu){
		$sql="select * from ga.ga_outstation_meal_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_time ti where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.time_id=ti.time_id AND ti.time_name = '$waktu'";
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

	
}
?>