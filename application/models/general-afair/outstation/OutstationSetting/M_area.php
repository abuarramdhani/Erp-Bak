<?php
class M_area extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_area(){
		$sql="select * from ga.ga_outstation_area where end_date > now() order by area_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_deleted_area(){
		$sql="select * from ga.ga_outstation_area order by area_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function new_area($area_name,$start_date,$end_date){
		$sql="insert into ga.ga_outstation_area (area_name,start_date,end_date) values ('$area_name','$start_date','$end_date')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_area($area_id){
		$sql="select * from ga.ga_outstation_area where area_id = '$area_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_area($area_id,$area_name,$start_date,$end_date){
		$sql="update ga.ga_outstation_area set area_name='$area_name', start_date='$start_date', end_date='$end_date' where area_id='$area_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function check_data_area($area_id){
		$sql="	select	area.area_id,
						count(acc.area_id) as area_id_on_acc,
						count(meal.area_id) as area_id_on_meal,
						count(sim.area_id) as area_id_on_sim,
						count(real.area_id) as area_id_on_real
				from	ga.ga_outstation_area area
						LEFT JOIN ga.ga_outstation_accomodation_allowance acc
							ON acc.area_id = area.area_id
						LEFT JOIN ga.ga_outstation_meal_allowance meal
							ON meal.area_id = area.area_id
						LEFT JOIN ga.ga_outstation_simulation sim
							ON sim.area_id = area.area_id
						LEFT JOIN ga.ga_outstation_realization real
							ON real.area_id = area.area_id
				where area.area_id='$area_id' group by area.area_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_temporary($area_id){
		$sql="update ga.ga_outstation_area set end_date = now() where area_id='$area_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_permanently($area_id){
		$sql="delete from ga.ga_outstation_area where area_id='$area_id'";
		$query = $this->db->query($sql);
		return;
	}
}
?>