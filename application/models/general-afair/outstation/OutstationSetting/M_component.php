<?php
class M_component extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_component(){
		$sql="select * from ga.ga_outstation_component where end_date > now() order by component_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function show_deleted_component(){
		$sql="select * from ga.ga_outstation_component order by component_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function new_component($component_name,$start_date,$end_date){
		$sql="insert into ga.ga_outstation_component (component_name,start_date,end_date) values ('$component_name','$start_date','$end_date')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_component($component_id){
		$sql="select * from ga.ga_outstation_component where component_id = '$component_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_component($component_id,$component_name,$start_date,$end_date){
		$sql="update ga.ga_outstation_component set component_name='$component_name', start_date='$start_date', end_date='$end_date' where component_id='$component_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function check_data_component($component_id){
		$sql="	select	component.component_id,
						count(real_det.component_id) as component_id_on_real_det
				from	ga.ga_outstation_component component
						LEFT JOIN ga.ga_outstation_realization_detail real_det
							ON real_det.component_id = component.component_id
				where component.component_id='$component_id' group by component.component_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_temporary($component_id){
		$sql="update ga.ga_outstation_component set end_date = now() where component_id='$component_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function delete_permanently($component_id){
		$sql="delete from ga.ga_outstation_component where component_id='$component_id'";
		$query = $this->db->query($sql);
		return;
	}
}
?>