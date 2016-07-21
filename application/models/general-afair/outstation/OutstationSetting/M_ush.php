<?php
class M_ush extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_ush(){
		$sql="	select	ush.position_id, ush.group_id, ush.nominal, ush.start_date, ush.end_date, position.position_name
				from 	ga.ga_outstation_ush ush
						LEFT JOIN ga.ga_outstation_position position
							ON position.position_id = ush.position_id
						where ush.end_date > now() order by ush.position_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_deleted_ush(){
		$sql="	select	ush.position_id, ush.group_id, ush.nominal, ush.start_date, ush.end_date, position.position_name
				from 	ga.ga_outstation_ush ush
						LEFT JOIN ga.ga_outstation_position position
							ON position.position_id = ush.position_id
						order by ush.position_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_position(){
		$sql="select * from ga.ga_outstation_position where end_date > now() order by position_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function new_ush($position_id,$group_id,$nominal,$start_date,$end_date){
		$sql="insert into ga.ga_outstation_ush (position_id,group_id,nominal,start_date,end_date) values ('$position_id','$group_id','$nominal','$start_date','$end_date')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_ush($position_id,$group_id){
		$sql="select * from ga.ga_outstation_ush where position_id = '$position_id' AND group_id = '$group_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_ush($position_id,$position_id_old,$group_id,$group_id_old,$nominal,$start_date,$end_date){
		$sql="update ga.ga_outstation_ush set position_id='$position_id', group_id='$group_id', nominal='$nominal', start_date='$start_date', end_date='$end_date' where position_id='$position_id_old' AND group_id='$group_id_old'";
		$query = $this->db->query($sql);
		return;
	}

	public function check_data_ush($position_id,$group_id){
		$sql="	select	ush.position_id, ush.group_id,
						count(sim_det.group_id) as ush_on_sim_det
				from	ga.ga_outstation_ush ush
						LEFT JOIN ga.ga_outstation_simulation_detail sim_det
							ON sim_det.group_id = ush.group_id
				where ush.position_id='$position_id' AND ush.group_id='$group_id' group by ush.position_id, ush.group_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_temporary($position_id,$group_id){
		$sql="update ga.ga_outstation_ush set end_date = now() where position_id='$position_id' AND group_id='$group_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_permanently($position_id,$group_id){
		$sql="delete from ga.ga_outstation_area where position_id='$position_id' AND group_id='$group_id'";
		$query = $this->db->query($sql);
		return;
	}
}
?>