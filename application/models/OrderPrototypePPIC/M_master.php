<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        $this->personalia = $this->load->database('personalia', true);
    }


    public function getMonitoring($value='')
    {
    $res = $this->db->select('o.*')->get('opp.order o')->result_array();
      // echo  $this->db->last_query();
      if (!empty($res)) {
        foreach ($res as $key => $value) {

        $proses = $this->db->where('id_order', $value['id'])
                           ->order_by('id', 'asc')
                           ->get('opp.proses')->result_array();

         $key2 = array_search('Y', array_column($proses, 'status'));

         if (!empty($proses) && is_numeric($key2)) {
           $tampung[0] = $proses[$key2];
           $tampung[1] = !empty($proses[$key2+1]) ? $proses[$key2+1] : [];
         }else {
           $tampung = [];
         }
          $res[$key]['proses'] = $tampung;
        }

      }

      return $res;
    }

    public function getOrderOut($value='')
    {
      return $this->db->select('p.id as id_out, p.proses, p.seksi, p.status, p.penerima, oo.no_order_out, o.*')
                      ->join('opp.order o', 'o.id = oo.id_order', 'inner')
                      ->join('opp.proses p', 'p.id = oo.id_proses', 'inner')
                      ->order_by('o.id')
                      ->get('opp.order_out oo')->result_array();
    }

    public function getOrderOutAcc($value='')
    {
      return $this->db->select('p.id as id_out, p.proses, p.seksi, p.status, p.penerima, oo.no_order_out, o.*')
                      ->join('opp.order o', 'o.id = oo.id_order', 'inner')
                      ->join('opp.proses p', 'p.id = oo.id_proses', 'inner')
                      ->order_by('oo.no_order_out')
                      ->get('opp.order_out oo')->result_array();
    }

    public function getProsesOPP($id='')
    {
      return $this->db->where('id_order', $id)->get('opp.proses')->result_array();
    }

    public function getProsesMon($id='')
    {
      return $this->db->select('pro.*, out.no_order_out')
                      ->join('opp.order_out out', 'out.id_proses = pro.id', 'left')
                      ->where('pro.id_order', $id)
                      ->order_by('pro.id', 'asc')
                      ->get('opp.proses pro')->result_array();
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
        $id_order = $this->db->insert_id();
        // $id_order = $this->db->select('max(id) as id')->get('opp.order')->row()->id;
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

    public function getDept($s)
    {
      return $this->personalia->distinct()->select('unit, dept')->where('seksi', $s)->get('hrd_khs.tseksi')->row_array();
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

    public function cek($value='')
    {
      return $this->oracle->query("SELECT *
                    FROM khs_qweb_siap_assign1 kqsa
                   WHERE TRUNC (SYSDATE) BETWEEN TRUNC (kqsa.tgl_kirim - 1)
                                             AND TRUNC (kqsa.tgl_kirim + 6)
                     AND kqsa.subinventory = 'FG-TKS'
                ORDER BY kqsa.no_pr, kqsa.header_id")->result_array();
    }

}
