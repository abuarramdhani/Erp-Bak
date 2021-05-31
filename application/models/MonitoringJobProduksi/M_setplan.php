<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_setplan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        // $this->oracle_dev = $this->load->database('oracle_dev', true);
        $this->oracle = $this->load->database('oracle', true);
    }
    
    public function getCategory($term){
        $sql = "select * from khs_kategori_item_monitoring $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getSubCategory($term){
        $sql = "select * from khs_subcategory_item $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdataMonitoring($kategori){
        $sql = "select * from khs_category_item_monitoring where category_name = '$kategori'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getPlan($term){
        $sql = "select * from khs_plan_item_monitoring $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getPlanDate($term){
        $sql = "select * from khs_plan_item_monitoring_date $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getitem($kategori){
        $sql = "select * from khs_category_item_monitoring where category_name = '$kategori'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getitem2($term){
        $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id, msib.organization_id             
                FROM mtl_system_items_b msib            
                WHERE msib.inventory_item_status_code = 'Active'              
                AND msib.inventory_item_id = '$term'
                AND msib.organization_id IN (101, 102, 225) --OPM, ODM, YSP         
                ORDER BY msib.segment1
                ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
  
    public function savePlan($id, $inv_id, $bulan, $category, $subcategory){
        $sql = "insert into khs_plan_item_monitoring (plan_id, inventory_item_id, month, id_category, id_subcategory)
                values($id, $inv_id, $bulan, $category, $subcategory)";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    // echo $sql;
    }

    public function savePlanDate($id, $date_plan, $value){
        $sql = "insert into khs_plan_item_monitoring_date (plan_id, date_plan, value_plan)
                values($id, $date_plan, $value)";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
        // echo $sql;
    }
    
    public function updatePlanDate($id, $date_plan, $value){
        $sql = "update khs_plan_item_monitoring_date set value_plan = $value
                where plan_id = $id and date_plan = $date_plan";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
        // echo $sql;
    }
    
    public function deletePlanDate($id, $date_plan){
        $sql = "delete from khs_plan_item_monitoring_date
                where plan_id = $id and date_plan = $date_plan";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
        // echo $sql;
    }
    
    public function deletePlanDate2($id){
        $sql = "delete from khs_plan_item_monitoring_date
                where plan_id = $id";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
        // echo $sql;
    }

    public function deletePlan($id){
        $sql = "delete from khs_plan_item_monitoring
                where plan_id = $id";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
        // echo $sql;
    }




}
