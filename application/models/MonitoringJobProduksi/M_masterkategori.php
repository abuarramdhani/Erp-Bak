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
    
    public function deletecategory($id, $kategori){
      $sql = "delete from khs_kategori_item_monitoring where id_category = $id and category_name = '$kategori'";
      $query = $this->oracle->query($sql);
      $query2 = $this->oracle->query('commit');
      // echo $sql;
    }


}
