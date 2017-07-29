<?php
class M_city_type extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_city_type(){
		$sql="select * from ga.ga_outstation_city_type where end_date > now() order by city_type_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_deleted_city_type(){
		$sql="select * from ga.ga_outstation_city_type order by city_type_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function new_city_type($city_type_name,$start_date,$end_date){
		$sql="insert into ga.ga_outstation_city_type (city_type_name,start_date,end_date) values ('$city_type_name','$start_date','$end_date')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_city_type($city_type_id){
		$sql="select * from ga.ga_outstation_city_type where city_type_id = '$city_type_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_city_type($city_type_id,$city_type_name,$start_date,$end_date){
		$sql="update ga.ga_outstation_city_type set city_type_name='$city_type_name', start_date='$start_date', end_date='$end_date' where city_type_id='$city_type_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function check_data_city_type($city_type_id){
		$sql="	select	city_type.city_type_id,
						count(acc.city_type_id) as city_type_id_on_acc,
						count(real.city_type_id) as city_type_id_on_real,
						count(sim.city_type_id) as city_type_id_on_sim
				from	ga.ga_outstation_city_type city_type
						LEFT JOIN ga.ga_outstation_accomodation_allowance acc
							ON acc.city_type_id = city_type.city_type_id
						LEFT JOIN ga.ga_outstation_realization real
							ON real.city_type_id = city_type.city_type_id
						LEFT JOIN ga.ga_outstation_simulation sim
							ON sim.city_type_id = city_type.city_type_id
				where city_type.city_type_id='$city_type_id' group by city_type.city_type_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_temporary($city_type_id){
		$sql="update ga.ga_outstation_city_type set end_date = now() where city_type_id='$city_type_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_permanently($city_type_id){
		$sql="delete from ga.ga_outstation_city_type where city_type_id='$city_type_id'";
		$query = $this->db->query($sql);
		return;
	}
}
?>