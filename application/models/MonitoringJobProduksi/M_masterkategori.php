<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterkategori extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getdata($term){
      $oracle = $this->load->database('oracle_dev',true);
      $sql = "select * from khs_kategori_item_monitoring $term";
      $query = $oracle->query($sql);
      return $query->result_array();
    }

    public function saveKategori($id, $kategori){
      $oracle = $this->load->database('oracle_dev',true);
      $sql = "insert into khs_kategori_item_monitoring (id_category, category_name)
              values('$id', '$kategori')";
      $query = $oracle->query($sql);
      $query2 = $oracle->query('commit');
      // echo $sql;
    }
    
    public function deletecategory($id, $kategori){
      $oracle = $this->load->database('oracle_dev',true);
      $sql = "delete from khs_kategori_item_monitoring where id_category = $id and category_name = '$kategori'";
      $query = $oracle->query($sql);
      $query2 = $oracle->query('commit');
      // echo $sql;
    }


}
