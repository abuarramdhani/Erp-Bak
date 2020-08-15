<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function getProsesOPP($id='')
    {
      return $this->db->where('id_order', $id)->get('opp.proses')->result_array();
    }

    public function getOrderIn()
    {
      $res = $this->db->get('opp.order')->result_array();
      return $res;
    }

    public function Insert($data)
    {
      $this->db->insert('opp.order', $data);
      if ($this->db->affected_rows() == 1) {
        $id_order = $this->db->select('max(id) as id')->get('opp.order')->row()->id;
        return $id_order;
      }else {
        return 0;
      }
    }

    public function InsertprosesID($data)
    {
      $this->db->insert('opp.proses', $data);
      if ($this->db->affected_rows() == 1) {
        return 1;
      }else {
        return 0;
      }
    }

    public function getSeksiBy($param)
    {
      $res = $this->personalia->select('seksi')->where('kodesie', $param)->get('hrd_khs.tseksi')->row()->seksi;
      return $res;
    }

    public function getSeksi($param)
    {
      $res = $this->personalia->distinct()
                              ->select('seksi, unit')
                              ->where('seksi !=', '-')
                              ->like('seksi', $param, 'both')
                              ->get('hrd_khs.tseksi')->result_array();
      return $res;
    }

}
