<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_itemlist extends CI_Model
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

    public function getdata($term){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "select * from khs_category_item_monitoring $term";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getitem($term){
      $oracle = $this->load->database('oracle_dev',true);
      $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id, msib.organization_id             
              FROM mtl_system_items_b msib            
              WHERE msib.inventory_item_status_code = 'Active'              
              AND (msib.description LIKE '%$term%' OR msib.segment1 LIKE '%$term%')              
              AND msib.organization_id IN (101, 102) --OPM, ODM         
              ORDER BY msib.segment1
              ";
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

    public function saveitem($kategori, $inv_id, $org_id){
        $oracle = $this->load->database('oracle_dev',true);
        $sql = "insert into khs_category_item_monitoring (category_name, organization_id, inventory_item_id)
                values('$kategori', $org_id, $inv_id)";
        $query = $oracle->query($sql);
      // echo $sql;
  }
  
  public function deleteitem($kategori, $inv_id){
    $oracle = $this->load->database('oracle_dev',true);
    $sql = "delete khs_category_item_monitoring where category_name = '$kategori' and inventory_item_id = $inv_id";
    $query = $oracle->query($sql);
  // echo $sql;
}


}
