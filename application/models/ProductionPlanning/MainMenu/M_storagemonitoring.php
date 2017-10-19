<?php
class M_storagemonitoring extends CI_Model {

  public function __construct()
  {
    $this->load->database();
    $this->oracle = $this->load->database ('oracle', TRUE);
  }

  public function getStoragePP()
  {
    $this->db->select('*');
    $this->db->from('pp.pp_storage');
    $this->db->order_by('storage_name');
    
    $query = $this->db->get();
    return $query->result_array();
  }
}