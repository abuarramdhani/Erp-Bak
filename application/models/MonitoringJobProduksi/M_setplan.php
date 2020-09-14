<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_setplan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }
    
    public function getCategory(){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "select * from khs_kategori_item_monitoring";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataMonitoring($kategori){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "select * from khs_category_item_monitoring where category_name = '$kategori'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getPlan($term){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "select * from khs_plan_item_monitoring $term";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
    
    public function getPlanDate($term){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "select * from khs_plan_item_monitoring_date $term";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getitem($kategori){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "select * from khs_category_item_monitoring where category_name = '$kategori'";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getitem2($term){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id, msib.organization_id             
                FROM mtl_system_items_b msib            
                WHERE msib.inventory_item_status_code = 'Active'              
                AND msib.inventory_item_id = '$term'
                AND msib.organization_id IN (101, 102) --OPM, ODM         
                ORDER BY msib.segment1
                ";
        $query = $oracle->query($sql);
        return $query->result_array();
    }
  
    public function savePlan($id, $inv_id, $bulan){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "insert into khs_plan_item_monitoring (plan_id, inventory_item_id, month)
                values($id, $inv_id, $bulan)";
        $query = $oracle->query($sql);
        $query = $oracle->query('commit');
    // echo $sql;
    }

    public function savePlanDate($id, $date_plan, $value){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "insert into khs_plan_item_monitoring_date (plan_id, date_plan, value_plan)
                values($id, $date_plan, $value)";
        $query = $oracle->query($sql);
        $query = $oracle->query('commit');
        // echo $sql;
    }
    
    public function updatePlanDate($id, $date_plan, $value){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "update khs_plan_item_monitoring_date set value_plan = $value
                where plan_id = $id and date_plan = $date_plan";
        $query = $oracle->query($sql);
        $query = $oracle->query('commit');
        // echo $sql;
    }
    
    public function deletePlanDate($id, $date_plan){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "delete from khs_plan_item_monitoring_date
                where plan_id = $id and date_plan = $date_plan";
        $query = $oracle->query($sql);
        $query = $oracle->query('commit');
        // echo $sql;
    }




}
