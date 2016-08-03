<?php
class M_mealallowance extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_mealallowance(){
		$sql="select * from ga.ga_outstation_meal_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_time ti where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.time_id=ti.time_id order by op.position_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	} 

	public function new_mealallowance($position_id,$area_id ,$time_id,$nominal,$start_date,$end_date){
		$sql="insert into ga.ga_outstation_meal_allowance (position_id,area_id,time_id,nominal,start_date,end_date) values ('$position_id','$area_id','$time_id','$nominal','$start_date','$end_date')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_mealallowance($mealallowance){
		$sql="select * from ga.ga_outstation_meal_allowance where meal_allowance_id = '$mealallowance'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_mealallowance($mealallowance,$position_id,$area_id,$time_id,$nominal,
			$start_date,$end_date){
		$sql="update ga.ga_outstation_meal_allowance set position_id='$position_id', area_id='$area_id',time_id='$time_id',nominal='$nominal', start_date='$start_date', end_date='$end_date' where meal_allowance_id='$mealallowance'";
		$query = $this->db->query($sql);
		return;
	}

	public function show_position(){
		$sql="select * from ga.ga_outstation_position where end_date > now() order by position_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_area(){
		$sql="select * from ga.ga_outstation_area where end_date > now() order by area_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_time(){
		$sql="select * from ga.ga_outstation_time where end_date > now() order by time_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_permanently($meal_allowance_id){
		$sql="delete from ga.ga_outstation_meal_allowance where meal_allowance_id='$meal_allowance_id'";
		$query = $this->db->query($sql);
		return;
	}

}

?>