<?php
class M_employee_position extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function show_employee_position(){
		$sql="select * from er.er_employee_all emp left join ga.ga_outstation_position pst on pst.position_id = emp.outstation_position where emp.resign = 0 OR resign is null order by emp.employee_code";
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

	public function show_employee_server_side(){
		$sql="select * from er.er_employee_all emp left join ga.ga_outstation_position pst on pst.position_id = emp.outstation_position where (emp.resign = 0 OR emp.resign is null)";
		$query = $this->db->query($sql);
		return $query;
	}

	public function show_employee_server_side_search($searchValue){
		$sql="select * from er.er_employee_all emp left join ga.ga_outstation_position pst on pst.position_id = emp.outstation_position where (emp.resign = 0 OR emp.resign is null)

			AND (
				emp.employee_code ILIKE '%$searchValue%'
				OR emp.employee_name ILIKE '%$searchValue%'
				OR pst.position_name ILIKE '%$searchValue%'
				OR pst.marketing_status ILIKE '%$searchValue%'
			)
			";
		$query = $this->db->query($sql);
		return $query;
	}

	public function show_employee_server_side_order_limit($searchValue, $order_col, $order_dir, $limit, $offset){
		if ($searchValue == NULL || $searchValue == "") {
			$condition = "";
		}
		else{
			$condition = "AND (
				emp.employee_code ILIKE '%$searchValue%'
				OR emp.employee_name ILIKE '%$searchValue%'
				OR pst.position_name ILIKE '%$searchValue%'
				OR pst.marketing_status ILIKE '%$searchValue%'
			)";
		}
		$sql="select * from er.er_employee_all emp left join ga.ga_outstation_position pst on pst.position_id = emp.outstation_position where (emp.resign = 0 OR emp.resign is null)

			$condition

			ORDER BY $order_col $order_dir LIMIT $limit OFFSET $offset
			";
		$query = $this->db->query($sql);
		return $query;
	}
}
?>