<?php
class M_group_ush extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_group_ush(){
		$sql="select * from ga.ga_outstation_groupush where end_date > now() order by group_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_deleted_group_ush(){
		$sql="select * from ga.ga_outstation_groupush order by group_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function new_group_ush($group_name,$holiday,$foreign,$time_from,$time_to,$start_date,$end_date){
		$sql='insert into ga.ga_outstation_groupush ("group_name","holiday","foreign","time_1","time_2","start_date","end_date") values (\''.$group_name.'\',\''.$holiday.'\',\''.$foreign.'\',\''.$time_from.'\',\''.$time_to.'\',\''.$start_date.'\',\''.$end_date.'\')';
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_group_ush($group_id){
		$sql="select * from ga.ga_outstation_groupush where group_id = '$group_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_group_ush($group_id,$group_name,$holiday,$foreign,$time_from,$time_to,$start_date,$end_date){
		$sql='update ga.ga_outstation_groupush set "group_name"=\''.$group_name.'\', "holiday"=\''.$holiday.'\', "foreign"=\''.$foreign.'\', "time_1"=\''.$time_from.'\', "time_2"=\''.$time_to.'\', "start_date"=\''.$start_date.'\', "end_date"=\''.$end_date.'\' where "group_id"=\''.$group_id.'\'';
		$query = $this->db->query($sql);
		return;
	}

	public function check_data_group_ush($group_id){
		$sql="	select	grp.group_id,
						count(sim.group_id) as group_id_on_sim_det,
						count(ush.group_id) as group_id_on_ush
				from	ga.ga_outstation_groupush grp
						LEFT JOIN ga.ga_outstation_simulation_detail sim
							ON sim.group_id = grp.group_id
						LEFT JOIN ga.ga_outstation_ush ush
							ON ush.group_id = grp.group_id
				where grp.group_id='$group_id' group by grp.group_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_temporary($group_id){
		$sql="update ga.ga_outstation_groupush set end_date = now() where group_id='$group_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_permanently($group_id){
		$sql="delete from ga.ga_outstation_groupush where group_id='$group_id'";
		$query = $this->db->query($sql);
		return;
	}
}
?>