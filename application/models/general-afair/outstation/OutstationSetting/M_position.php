<?php
class M_position extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_position(){
		$sql="select * from ga.ga_outstation_position where end_date > now() order by position_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_deleted_position(){
		$sql="select * from ga.ga_outstation_position order by position_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function new_position($position_name,$marketing_status,$start_date,$end_date){
		$sql="insert into ga.ga_outstation_position (position_name,marketing_status,start_date,end_date) values ('$position_name','$marketing_status','$start_date','$end_date')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_position($position_id){
		$sql="select * from ga.ga_outstation_position where position_id = '$position_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_position($position_id,$position_name,$marketing_status,$start_date,$end_date){
		$sql="update ga.ga_outstation_position set position_name='$position_name', marketing_status='$marketing_status', start_date='$start_date', end_date='$end_date' where position_id='$position_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function check_data_position($position_id){
		$sql="	select	position.position_id,
						count(acc.position_id) as position_id_on_acc,
						count(meal.position_id) as position_id_on_meal,
						count(ush.position_id) as position_id_on_ush
				from	ga.ga_outstation_position position
						LEFT JOIN ga.ga_outstation_accomodation_allowance acc
							ON acc.position_id = position.position_id
						LEFT JOIN ga.ga_outstation_meal_allowance meal
							ON meal.position_id = position.position_id
						LEFT JOIN ga.ga_outstation_ush ush
							ON ush.position_id = position.position_id
				where position.position_id='$position_id' group by position.position_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_temporary($position_id){
		$sql="update ga.ga_outstation_position set end_date = now() where position_id='$position_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_permanently($position_id){
		$sql="delete from ga.ga_outstation_position where position_id='$position_id'";
		$query = $this->db->query($sql);
		return;
	}
}
?>