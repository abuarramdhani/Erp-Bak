<?php defined('BASEPATH') or die('No Direct Script Allowed');

class M_tanterkesepakatan extends CI_Model {
  function __construct() {
    parent::__construct();

    $this->load->database();
    $this->prs = $this->load->database('personalia', true);
  }

  // do all things below
  // if u dont know this -> search: query builder codeigniter 3
  
  // array
  public function getPersonal($noind) {
    $this->prs->select(['a.noind', 'a.nama', 'c.seksi', 'b.lokasi_kerja']);
    $this->prs->from('hrd_khs.tpribadi a');
    $this->prs->join('hrd_khs.tlokasi_kerja b', 'a.lokasi_kerja = b.id_', 'left');
    $this->prs->join('hrd_khs.tseksi c', 'a.kodesie = c.kodesie', 'left');
    $this->prs->where('noind', $noind);
    $res = $this->prs->get();

    return $res->row();
  }

  // array
  public function getData() {
    $today = date('Y-m-d');
    $res = $this->db->query("SELECT * 
                              FROM kk.kk_cetak_kesepakatan_kerja
                              WHERE status_cetak = '0' 
                                AND status_hapus = '0' 
                                AND created_timestamp::date = '$today' 
                              ORDER BY created_timestamp DESC");
    return $res->result_array();
  }

  public function getDataExport() {
    $today = date('Y-m-d');
    $res = $this->db->query("SELECT * 
                              FROM kk.kk_cetak_kesepakatan_kerja
                              WHERE status_cetak = '0' 
                                AND status_hapus = '0' 
                                AND created_timestamp::date = '$today' 
                              ORDER BY noind ASC");
    return $res->result_array();
  }

  // array
  public function getDataRecord($tanggal = null) {
    if($tanggal) {
      $tanggal = date('Y-m-d', strtotime($tanggal));
    }

    $filtertanggal = $tanggal ? "AND created_timestamp::date = '$tanggal'" : ''; 
    $res = $this->db->query("SELECT * 
                              FROM kk.kk_cetak_kesepakatan_kerja
                              WHERE status_cetak = '0' 
                                AND status_hapus = '1' 
                                $filtertanggal
                              ORDER BY created_timestamp DESC");
    return $res->result_array();
  }


  // string
  public function getTanggalMasuk($noind) {
    $res = $this->prs->select('masukkerja')->where('noind', $noind)->get('hrd_khs.tpribadi');

    return $res->row()->masukkerja;
  }

  // void
  public function insert($data) {
    $this->db->insert('kk.kk_cetak_kesepakatan_kerja', $data);
  }

  // void
  public function updateCetak() {
    $this->db->where('status_cetak', '0');
    $this->db->set('status_cetak', '1');
    $this->db->update('kk.kk_cetak_kesepakatan_kerja');
  }

  // void
  public function deleteAll($date = null) {
    $this->db->where('status_cetak', '0');
    $this->db->set('status_hapus', '1');
    $this->db->update('kk.kk_cetak_kesepakatan_kerja');
  }

  // void
  public function deleteById($id = null) {
    $this->db->where('id', $id);
    $this->db->delete('kk.kk_cetak_kesepakatan_kerja');
  }
}