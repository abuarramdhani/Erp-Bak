<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_itemlist extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        // $this->oracle_dev = $this->load->database('oracle_dev', true);
        $this->oracle = $this->load->database('oracle', true);
    }
    
    public function getCategory(){
      $sql = "select * from khs_kategori_item_monitoring order by category_name";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getSubCategory($term){
      $sql = "select * from khs_subcategory_item $term";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getdata($term){
        $sql = "select * from khs_category_item_monitoring $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getitem($term){
      $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id           
              FROM mtl_system_items_b msib            
              WHERE msib.inventory_item_status_code = 'Active'              
              AND (msib.description LIKE '%$term%' OR msib.segment1 LIKE '%$term%')              
              AND msib.organization_id IN (101, 102, 225) --OPM, ODM, YSP         
              ORDER BY msib.segment1
              ";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getitem2($term){
        $sql = "SELECT DISTINCT msib.segment1, msib.description, msib.inventory_item_id, msib.organization_id             
                FROM mtl_system_items_b msib            
                WHERE msib.inventory_item_id = '$term'
                AND msib.organization_id IN (101, 102, 225) --OPM, ODM, YSP         
                ORDER BY msib.organization_id desc
                ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function saveitem($kategori, $inv_id, $org_id, $sub){
        $sql = "insert into khs_category_item_monitoring (category_name, organization_id, inventory_item_id, id_subcategory)
                values('$kategori', $org_id, $inv_id, $sub)";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query("commit");
      // echo $sql;
  }
  
  public function deleteitem($kategori, $inv_id, $sub){
    $sql = "delete khs_category_item_monitoring where category_name = '$kategori' and inventory_item_id = $inv_id and $sub";
    // echo "<pre>";print_r($sql);exit();
    $query = $this->oracle->query($sql);
    $query = $this->oracle->query("commit");
  // echo $sql;
}

public function updateflag($inv_id, $kategori, $sub, $flag){
  $sql = "update khs_category_item_monitoring 
          set flag = '$flag'
          where category_name = '$kategori' 
          and inventory_item_id = $inv_id 
          and $sub";
  // echo "<pre>";print_r($sql);exit();
  $query = $this->oracle->query($sql);
  $query = $this->oracle->query("commit");
}

public function updateflagall($kategori, $sub, $flag){
  $sql = "update khs_category_item_monitoring 
          set flag = '$flag'
          where category_name = '$kategori' 
          and $sub";
  // echo "<pre>";print_r($sql);exit();
  $query = $this->oracle->query($sql);
  $query = $this->oracle->query("commit");
}


}
