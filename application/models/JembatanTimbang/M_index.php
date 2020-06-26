<?php
class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function setHeader($data)
    {
        return $this->db->insert('pbr.jti_trial', $data);
    }

    public function updateJTI($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('pbr.jti_trial', $data);
    }

    public function getDataTiket($id)
    {
        $this->db->select('*');
        $this->db->from('pbr.jti_trial');
        $this->db->where('code', $id);

        $query = $this->db->get();
        return $query->result_array();
    }
    public function getDataTiketpdf($id)
    {
        $this->db->select('*');
        $this->db->from('pbr.jti_trial');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }
    public function getLatestNumber($id)
    {
      $sql = "SELECT max(substring(jt.nobuktitimbang, 1, 2)) last_number
              FROM pbr.jti_trial jt
              WHERE jt.id = '$id'";

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    //--------------------------------------different function



}
