<?php
class M_stock_opname_pusat extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function stock_opname_pusat_filter($io_name,$sub_inventory,$area,$locator){
		$sql="select * from stock_control_pusat.master_data where io_name = $io_name AND sub_inventory = $sub_inventory AND area = $area AND locator = $locator order by seq asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function next_seq(){
		$sql="select count(*) seq from stock_control_pusat.master_data";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function io_name_list($term = NULL){
		if ($term == NULL || $term == '') {
			$term = ' = io_name';
		}
		else{
			$term = "ilike '%".$term."%'";
		}
		$sql="select distinct on (io_name) io_name from stock_control_pusat.master_data where io_name $term order by io_name asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function area_list($term = NULL){
		if ($term == NULL || $term == '') {
			$term = ' = area';
		}
		else{
			$term = "ilike '%".$term."%'";
		}
		$sql="select distinct on (area) area from stock_control_pusat.master_data where area $term order by area asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function locator_list($term = NULL){
		if ($term == NULL || $term == '') {
			$term = ' = locator';
		}
		else{
			$term = "ilike '%".$term."%'";
		}
		$sql="select distinct on (locator) locator from stock_control_pusat.master_data where locator $term order by locator asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function sub_inventory_list($term = NULL){
		if ($term == NULL || $term == '') {
			$term = ' = sub_inventory';
		}
		else{
			$term = "ilike '%".$term."%'";
		}
		$sql="select distinct on (sub_inventory) sub_inventory from stock_control_pusat.master_data where sub_inventory $term order by sub_inventory asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function saving_place_list($term = NULL){
		if ($term == NULL || $term == '') {
			$term = ' = saving_place';
		}
		else{
			$term = "ilike '%".$term."%'";
		}
		$sql="select distinct on (saving_place) saving_place from stock_control_pusat.master_data where saving_place $term order by saving_place asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function cost_center_list($term = NULL){
		if ($term == NULL || $term == '') {
			$term = ' = cost_center';
		}
		else{
			$term = "ilike '%".$term."%'";
		}
		$sql="select distinct on (cost_center) cost_center from stock_control_pusat.master_data where cost_center $term order by cost_center asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function type_list($term = NULL){
		if ($term == NULL || $term == '') {
			$term = ' = type';
		}
		else{
			$term = "ilike '%".$term."%'";
		}
		$sql="select distinct on (type) type from stock_control_pusat.master_data where type $term order by type asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function uom_list($term = NULL){
		if ($term == NULL || $term == '') {
			$term = ' = uom';
		}
		else{
			$term = "ilike '%".$term."%'";
		}
		$sql="select distinct on (uom) uom from stock_control_pusat.master_data where uom $term order by uom asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function item_classification($io_name,$sub_inventory,$area,$locator){
		$sql = "select io_name, sub_inventory, area, locator from stock_control_pusat.master_data where io_name = $io_name AND sub_inventory = $sub_inventory AND area = $area AND locator = $locator group by io_name, sub_inventory, area, locator";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_qty($qty,$master_id){
		$sql="update stock_control_pusat.master_data set so_qty = '$qty' where master_data_id = '$master_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function new_component($io_name,$sub_inventory,$area,$locator,$saving_place,$cost_center,$seq,$component_code,$component_desc,$type,$onhand_qty,$so_qty,$uom){
		$sql="insert into stock_control_pusat.master_data (io_name, sub_inventory, area, locator, saving_place, cost_center, seq, component_code, component_desc, type, onhand_qty, so_qty, uom) values ('$io_name', '$sub_inventory', '$area', '$locator', '$saving_place', '$cost_center', '$seq', '$component_code', '$component_desc', '$type', '$onhand_qty', '$so_qty', '$uom')";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function edit_component($master_data_id){
		$sql="select * from stock_control_pusat.master_data where master_data_id = '$master_data_id' order by seq asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update_component($master_data_id,$io_name,$sub_inventory,$area,$locator,$saving_place,$cost_center,$seq,$component_code,$component_desc,$type,$onhand_qty,$so_qty,$uom){
		$sql="update stock_control_pusat.master_data set io_name = '$io_name', sub_inventory = '$sub_inventory', area = '$area', locator = '$locator', saving_place = '$saving_place', seq = '$seq', cost_center = '$cost_center', component_code = '$component_code', component_desc = '$component_desc', type = '$type', onhand_qty = '$onhand_qty', so_qty = '$so_qty', uom = '$uom' where master_data_id = '$master_data_id'";
		$query = $this->db->query($sql);
		if (!$query) {
			return 0;
		}
		else{
			return 1;
		}
	}

	public function slc_SubInventory($term){
		if ($term == 'ALL') {
			$term = 'io_name';
		}
		elseif ($term == 'X') {
			$term = "''";
		}
		else{
			$term = "'".$term."'";
		}
		$this->session->set_userdata('io_name',$term);
		$sql="select distinct on (sub_inventory) sub_inventory from stock_control_pusat.master_data where io_name = $term order by sub_inventory asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function slc_Area($term){
		if ($term == 'ALL') {
			$term = 'sub_inventory';
		}
		elseif ($term == 'X') {
			$term = "''";
		}
		else{
			$term = "'".$term."'";
		}
		$this->session->set_userdata('sub_inventory',$term);
		$io_name = $this->session->userdata('io_name');
		$sql="select distinct on (area) area from stock_control_pusat.master_data where sub_inventory = $term AND io_name = $io_name order by area asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function slc_Locator($term){
		if ($term == 'ALL') {
			$term = 'area';
		}
		elseif ($term == 'X') {
			$term = "''";
		}
		else{
			$term = "'".$term."'";
		}
		$io_name = $this->session->userdata('io_name');
		$sub_inventory = $this->session->userdata('sub_inventory');
		$sql="select distinct on (locator) locator from stock_control_pusat.master_data where area = $term AND io_name = $io_name AND sub_inventory = $sub_inventory order by locator asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}
?>