<?php
class M_itemplan extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function getItemData()
  {
    $this->db->select('*');
    $this->db->from('pp.pp_item_data pid, pp.pp_section ps');
    $this->db->where('pid.section_id = ps.section_id');
    $this->db->order_by('pid.item_code, ps.section_id', 'ASC');

    $query = $this->db->get();
    return $query->result_array();
  }
}