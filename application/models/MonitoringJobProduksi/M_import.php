<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_import extends CI_Model
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

    public function getSubcategory($id_category){
        $sql = "select * from khs_subcategory_item where id_category = $id_category";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function cekInvItem($item){
        $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id, msib.organization_id        
                FROM mtl_system_items_b msib            
                WHERE msib.segment1 = '$item'             
                AND msib.organization_id IN (101, 102, 225) --OPM, ODM, YSP        
                ORDER BY msib.segment1, msib.organization_id desc
                ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function cekInvItem2($item){
        $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id, msib.organization_id        
                FROM mtl_system_items_b msib            
                WHERE msib.inventory_item_status_code = 'Active'              
                AND msib.segment1 = '$item'             
                AND msib.organization_id IN (101, 102, 225) --OPM, ODM, YSP        
                ORDER BY msib.segment1, msib.organization_id desc
                ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function cekItem($item, $kategori, $id_sub){
        $id_sub = $id_sub != 'null' ? "and id_subcategory = $id_sub" : "and id_subcategory is null";
        $sql = "select * 
                from khs_category_item_monitoring 
                where category_name = '$kategori'
                and inventory_item_id = $item
                $id_sub";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function saveitem($kategori, $inv_id, $org_id, $id_sub){
        $sql = "insert into khs_category_item_monitoring (category_name, organization_id, inventory_item_id, id_subcategory)
                values('$kategori', $org_id, $inv_id, $id_sub)";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query("commit");
      // echo $sql;
    }
    
    public function cekplan($term){
        $sql = "select * from khs_plan_item_monitoring $term order by 1 desc";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function savePlan($id, $inv_id, $bulan, $kategori, $subkategori){
        $sql = "insert into khs_plan_item_monitoring (plan_id, inventory_item_id, month, id_category, id_subcategory)
                values($id, $inv_id, $bulan, $kategori, $subkategori)";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    // echo $sql;
    }

    public function savePlanDate($id, $plan){
        $sql = "insert into khs_plan_item_monitoring_date (plan_id, value_plan_month)
                values($id, $plan)";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
        // echo $sql;
    }
    
    public function updatePlanDate($id, $value){
        $sql = "update khs_plan_item_monitoring_date set value_plan_date = $value
                where plan_id = $id";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
        // echo $sql;
    }



}
