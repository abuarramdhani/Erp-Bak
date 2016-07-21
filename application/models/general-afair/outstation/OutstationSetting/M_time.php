<?php
class M_time extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_time(){
		$sql="select * from ga.ga_outstation_time where end_date > now() order by time_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_deleted_time(){
		$sql="select * from ga.ga_outstation_time order by time_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function new_time($time_name,$start_date,$end_date){
		$sql="insert into ga.ga_outstation_time (time_name,start_date,end_date) values ('$time_name','$start_date','$end_date')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_time($time_id){
		$sql="select * from ga.ga_outstation_time where time_id = '$time_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_time($time_id,$time_name,$start_date,$end_date){
		$sql="update ga.ga_outstation_time set time_name='$time_name', start_date='$start_date', end_date='$end_date' where time_id='$time_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function check_data_time($time_id){
		$sql="	select	time.time_id,
						count(meal.time_id) as time_id_on_meal,
						count(sim.time_id) as time_id_on_sim_det
				from	ga.ga_outstation_time time
						LEFT JOIN ga.ga_outstation_meal_allowance meal
							ON meal.time_id = time.time_id
						LEFT JOIN ga.ga_outstation_simulation_detail sim
							ON sim.time_id = time.time_id
				where time.time_id='$time_id' group by time.time_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_temporary($time_id){
		$sql="update ga.ga_outstation_time set end_date = now() where time_id='$time_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_permanently($time_id){
		$sql="delete from ga.ga_outstation_time where time_id='$time_id'";
		$query = $this->db->query($sql);
		return;
	}
}
?>