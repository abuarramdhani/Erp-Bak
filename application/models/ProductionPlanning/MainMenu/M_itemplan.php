<?php
class M_itemplan extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function getItemData($section_id=FALSE,$item_code=FALSE)
  {
    if($section_id==FALSE && $item_code==FALSE){
      $this->db->select('*');
      $this->db->from('pp.pp_item_data pid, pp.pp_section ps');
      $this->db->where('pid.section_id = ps.section_id');
      $this->db->order_by('pid.item_code, ps.section_id', 'ASC');
      $query = $this->db->get();
    }else{
      $sql = "SELECT pid.item_code,
              pid.from_inventory,
              pid.to_inventory,
              pid.completion,
              ps.section_name,
              ps.locator_id
            FROM pp.pp_item_data pid, pp.pp_section ps
            WHERE
              ps.section_id = pid.section_id
              and pid.item_code = '$item_code'
              and pid.section_id = $section_id";
      $query = $this->db->query($sql);
    }

    return $query->result_array();
  }

  public function setItemPlan($data,$delCheckPoint)
  {
    if ($delCheckPoint == 0) {
      $this->db->query('DELETE FROM pp.pp_item_data');
    }
    $this->db->insert('pp.pp_item_data', $data);
  }
}