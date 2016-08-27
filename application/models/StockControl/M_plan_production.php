<?php
class M_plan_production extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function plan_list($plan_id = NULL){
		if ($plan_id == NULL) {
			$con = "";
		}
		else
		{
			$con = "where plan_id = '$plan_id'";
		}
		$sql="select * from stock_control_new.plan_production $con order by plan_id limit 20";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update($plan_id,$plan_date,$qty_plan){
		$sql="update stock_control_new.plan_production set plan_date = '$plan_date', qty_plan = '$qty_plan' where plan_id = '$plan_id'";
		$query = $this->db->query($sql);
		return;
	}

	public function check_date($new_plan_date){
		$this->db->where('plan_date', $new_plan_date);
        $query =  $this->db->get('stock_control_new.plan_production');
        return $query->num_rows();
	}

	public function insert($plan_date,$qty_plan){
		$sql="insert into stock_control_new.plan_production (plan_date, qty_plan) values ('$plan_date','$qty_plan')";
		$query = $this->db->query($sql);
		return;
	}

	public function delete($plan_id){
		$sql="delete from stock_control_new.plan_production where plan_id = '$plan_id'";
		$query = $this->db->query($sql);
		return;
	}
}
?>