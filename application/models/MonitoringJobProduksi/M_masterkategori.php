<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterkategori extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle', true);
    }

    public function getdata($term){
      $sql = "select * from khs_kategori_item_monitoring $term";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }

    public function getSubKategori($term){
      $sql = "select * from khs_subcategory_item $term";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }
    
    public function getdataqty(){
      $sql = "select distinct msib.SEGMENT1, msib.DESCRIPTION, msib.INVENTORY_ITEM_ID, km.QUANTITY_PER_JOB
              from khs_master_job_items km,
              mtl_system_items_b msib
              where km.PRIMARY_ITEM_ID = msib.INVENTORY_ITEM_ID
              order by msib.segment1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }
    
    public function cek_master_qty($item){
      $sql = "select *
              from khs_master_job_items km
              where km.primary_item_id = $item";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }
    
    public function getdataitem($term){
      $sql = "select distinct msib.SEGMENT1, msib.DESCRIPTION, msib.INVENTORY_ITEM_ID
              from khs_category_item_monitoring kcim,
              mtl_system_items_b msib
              where kcim.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
              and (msib.SEGMENT1 like '%$term%' or msib.DESCRIPTION like '%$term%')
              AND msib.inventory_item_id NOT IN (SELECT kmji.primary_item_id
                                                        FROM khs_master_job_items kmji)";
      $query = $this->oracle->query($sql);
      return $query->result_array();
    }
    

    public function saveKategori($id, $kategori){
      $sql = "insert into khs_kategori_item_monitoring (id_category, category_name)
              values('$id', '$kategori')";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
      // echo $sql;
    }

    public function updateKategori($id, $kategori){
      $sql = "update khs_kategori_item_monitoring set category_name = '$kategori'
              where id_category = $id";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
    }
    
    public function updateGudang($id, $gudang){
      $sql = "update khs_kategori_item_monitoring set subinventory = '$gudang'
              where id_category = $id";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
    }
    
    public function deletecategory($id, $kategori){
      $sql = "delete from khs_kategori_item_monitoring where id_category = $id and category_name = '$kategori'";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
      // echo $sql;
    }

    public function saveSubCategory($id, $idsub, $subkategori){
      $sql = "insert into khs_subcategory_item (id_category, id_subcategory, subcategory_name)
              values('$id','$idsub', '$subkategori')";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
      // echo $sql;
    }

    public function deletesubcategory($id){
      $sql = "delete from khs_subcategory_item where id_category = $id";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
      // echo $sql;
    }
    
    public function updateBulan($id, $bulan){
      $sql = "update khs_kategori_item_monitoring set month = '$bulan'
              where id_category = $id";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
    }
    
    public function savequantityitem($item, $qty){
      $sql = "insert into khs_master_job_items (primary_item_id, quantity_per_job)
              values('$item',$qty)";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
      // echo $sql;
    }

    public function updatequantityitem($inv, $qty){
      $sql = "update khs_master_job_items set quantity_per_job = '$qty'
              where primary_item_id = $inv";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
    }
    
    public function deleteqtyitem($inv){
      $sql = "delete from khs_master_job_items where primary_item_id = $inv";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
      // echo $sql;
    }

}
