<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_input extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->oracle = $this->load->database('oracle', TRUE);
  }

  public function getDataPrevious($mesin)
  {
    $sql = "SELECT * FROM khs_periodical_maintenance
            WHERE NAMA_MESIN = '$mesin'
            ORDER BY 1";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function Insert($doc_no, $rev_no, $rev_date,  $catatan_rev,$nama_mesin, $kondisi_mesin, $header, $uraian_kerja, $standar, $periode)

  {
    $sql = "INSERT INTO khs_periodical_maintenance (NAMA_MESIN, KONDISI_MESIN, HEADER, SUB_HEADER, STANDAR, PERIODE, NO_DOKUMEN, NO_REVISI, TANGGAL_REVISI, CATATAN_REVISI)
    VALUES ('$nama_mesin', '$kondisi_mesin', '$header', '$uraian_kerja', '$standar', '$periode', '$doc_no', '$rev_no', '$rev_date', '$catatan_rev')";
    $query = $this->oracle->query($sql);
  }

  public function getMachine()
  {
    $sql = "SELECT DISTINCT kmm.NAMA_MESIN FROM khs_mesin_mpa kmm
    ORDER BY 1";
    // return $sql;
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
}
