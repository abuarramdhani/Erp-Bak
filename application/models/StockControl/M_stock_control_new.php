<?php
class M_stock_control_new extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function production_list(){
		$sql="select * from stock_control_new.master_data order by sequence asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function transaction_list($master_data_id,$plan_id){
		$sql="select * from stock_control_new.transaction where master_data_id = '$master_data_id' AND plan_id = '$plan_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function qty_plan($from,$to){
		$sql="select * from stock_control_new.plan_production where plan_date BETWEEN '$from' and '$to' order by plan_date asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function production_list_filter($area,$subassy){
		$sql="select * from stock_control_new.master_data where area = $area AND subassy_desc = $subassy order by sequence asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function area_list(){
		$sql="select distinct on (area) area,* from stock_control_new.master_data order by area asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function subassy_list(){
		$sql="select distinct on (subassy_desc) subassy_desc,* from stock_control_new.master_data order by subassy_desc asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function check_transaction($master_id,$plan_id){
		$sql="select * from stock_control_new.transaction where master_data_id = '$master_id' AND plan_id = '$plan_id'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function select_master_data($id){
		$sql="select * from stock_control_new.master_data where master_data_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function select_plan_data($id){
		$sql="select * from stock_control_new.plan_production where plan_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function insert_data($qty,$master_id,$plan_id,$status){
		$date = date('Y-m-d 00:00:00');
		$sql="insert into stock_control_new.transaction (transaction_date, master_data_id, plan_id, qty, status)
			values ((select plan_date from stock_control_new.plan_production where plan_id = '$plan_id'), '$master_id', '$plan_id', '$qty', '$status')";
		$query = $this->db->query($sql);
		return;
	}

	public function update_data($qty,$master_id,$plan_id,$status){
		$sql="update stock_control_new.transaction set qty = '$qty', status = '$status' where master_data_id = '$master_id' AND plan_id = '$plan_id'";
		$query = $this->db->query($sql);
		return;
	}

}
?>