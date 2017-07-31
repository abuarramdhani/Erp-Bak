<?php
class M_AccomodationAllowance extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function show_accomodationallowance(){
		$sql="select * from ga.ga_outstation_accomodation_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_city_type ct where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id order by op.position_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	} 

	public function new_accomodationallowance($position_id,$area_id ,$city_type,$nominal,$start_date,$end_date){
		$sql="insert into ga.ga_outstation_accomodation_allowance (position_id,area_id,city_type_id,nominal,start_date,end_date) values ('$position_id','$area_id','$city_type','$nominal','$start_date','$end_date')";
		$query = $this->db->query($sql);
		return;
	}

	public function select_edit_accomodationallowance($accomodationallowance){
		$sql="select * from ga.ga_outstation_accomodation_allowance where accomodation_allowance_id = '$accomodationallowance'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_accomodationallowance($accomodationallowance,$position_id,$area_id,$city_type,$nominal,
			$start_date,$end_date){
		$sql="update ga.ga_outstation_accomodation_allowance set position_id='$position_id', area_id='$area_id',city_type_id='$city_type',nominal='$nominal', start_date='$start_date', end_date='$end_date' where accomodation_allowance_id='$accomodationallowance'";
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

	public function show_city_type(){
		$sql="select * from ga.ga_outstation_city_type where end_date > now() order by city_type_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_permanently($accomodation_allowance_id){
		$sql="delete from ga.ga_outstation_accomodation_allowance where accomodation_allowance_id='$accomodation_allowance_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function show_accomodation_allowance_server_side(){
		$sql="select * from ga.ga_outstation_accomodation_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_city_type ct where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id";
		$query = $this->db->query($sql);
		return $query;
	}

	public function show_accomodation_allowance_server_side_search($searchValue){
		$sql="select * from ga.ga_outstation_accomodation_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_city_type ct where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id

			AND (
				op.position_name ILIKE '%$searchValue%'
				OR ar.area_name ILIKE '%$searchValue%'
				OR ct.city_type_name ILIKE '%$searchValue%'
			)
			";
		$query = $this->db->query($sql);
		return $query;
	}

	public function show_accomodation_allowance_server_side_order_limit($searchValue, $order_col, $order_dir, $limit, $offset){
		if ($searchValue == NULL || $searchValue == "") {
			$condition = "";
		}
		else{
			$condition = "AND (
				op.position_name ILIKE '%$searchValue%'
				OR ar.area_name ILIKE '%$searchValue%'
				OR ct.city_type_name ILIKE '%$searchValue%'
			)";
		}
		$sql="select * from ga.ga_outstation_accomodation_allowance aa, ga.ga_outstation_position op, ga.ga_outstation_area ar
		, ga.ga_outstation_city_type ct where aa.position_id=op.position_id and aa.area_id=ar.area_id and aa.city_type_id=ct.city_type_id

			$condition

			ORDER BY $order_col $order_dir LIMIT $limit OFFSET $offset
			";
		$query = $this->db->query($sql);
		return $query;
	}
}
?>