<?php
class M_employee_position extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function show_employee_position(){
		$sql="select * from er.er_employee_all emp left join ga.ga_outstation_position pst on pst.position_id = emp.outstation_position and emp.resign = 0 order by emp.employee_code";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function select_edit_employee_position($employee_id){
		$sql="select * from er.er_employee_all emp left join ga.ga_outstation_position pst on pst.position_id = emp.outstation_position where emp.employee_id = '$employee_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_employee_position($employee_id,$position_id){
		$sql="update er.er_employee_all set outstation_position='$position_id' where employee_id='$employee_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function show_position(){
		$sql="select * from ga.ga_outstation_position where end_date > now() order by position_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>