<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_management extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->oracle = $this->load->database('oracle_dev', TRUE);
  }

  function getMesin()
  {
    $oracle = $this->load->database('oracle', TRUE);
    $sql = "SELECT DISTINCT kpm.NAMA_MESIN 
        FROM khs_periodical_maintenance kpm";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }


  public function getAll($mesin)
  {
    // $oracle = $this->load->database('oracle', true);
    $sql = "SELECT DISTINCT kpm.ID, kpm.NAMA_MESIN , kpm.KONDISI_MESIN, kpm.HEADER 
            FROM khs_periodical_maintenance kpm
            WHERE kpm.NAMA_MESIN = '$mesin'
            order by kpm.KONDISI_MESIN DESC, kpm.ID, kpm.HEADER";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // echo $sql;
  }

  public function getDetail($mesin, $kondisi, $header)
  {
    // $oracle = $this->load->database('oracle', true);
    if (strlen($header) == 0) {
      $coba = "AND kpm.HEADER IS NULL";
    } else {
      $coba = "AND kpm.HEADER = '$header'";
    }
    $sql = "SELECT kpm.SUB_HEADER, kpm.STANDAR, kpm.PERIODE 
            FROM khs_periodical_maintenance kpm 
            WHERE kpm.NAMA_MESIN = '$mesin' 
            AND kpm.KONDISI_MESIN = '$kondisi' 
            $coba";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // echo $sql; exit();
  }


  // public function getHead1()
  // {
  //   // $oracle = $this->load->database('oracle', true);
  //   $sql = "SELECT kondisi_mesin FROM khs_periodical_maintenance
  // WHERE NAMA_MESIN = 'TANUR INDUCTOTHERM 3 TON'";
  //   $query = $this->oracle->query($sql);
  //   return $query->result_array();
  //   // echo $sql; exit();
  // }

  // public function getHead2($kondisi) {
  //   // $oracle = $this->load->database('oracle', true);
  //   $sql ="SELECT DISTINCT nvl(header, '0') HEADER FROM khs_periodical_maintenance
  //           WHERE NAMA_MESIN = 'TANUR INDUCTOTHERM 3 TON'
  //           AND KONDISI_MESIN = '$kondisi'";
  //   $query = $this->oracle->query($sql);
  //   return $query->result_array();
  //   // echo $sql; exit();
  // }

  // public function getSubHead($kondisi, $header) {
  //   // $oracle = $this->load->database('oracle', true);
  //   if($header == "0"){
  //     $coba = "AND kpm.HEADER IS NULL";
  //   }else{
  //     $coba = "AND kpm.HEADER = '$header'";
  //   }
  //   $sql ="SELECT kpm.SUB_HEADER, kpm.STANDAR, kpm.PERIODE 
  //           FROM khs_periodical_maintenance kpm 
  //           WHERE kpm.NAMA_MESIN = 'TANUR INDUCTOTHERM 3 TON' 
  //           AND kpm.KONDISI_MESIN = '$kondisi' 
  //           $coba";
  //   $query = $this->oracle->query($sql);
  //   return $query->result_array();
  //   // echo $sql; exit();
  // }


  public function selectDataToEdit($id)
  {
    $sql = "SELECT *
    FROM khs_periodical_maintenance kpm 
    WHERE kpm.SUB_HEADER = '$id'";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function updateSubManagement($id, $subHeader, $standar, $periode)
  {
    $sql = "UPDATE khs_periodical_maintenance
    SET SUB_HEADER = '$subHeader', STANDAR = '$standar', PERIODE = '$periode'
    WHERE SUB_HEADER = '$id'";

    $query = $this->oracle->query($sql);
    return $query;
  }

  public function deleteSubManagement($id)
  {
    $sql = "DELETE FROM khs_periodical_maintenance WHERE SUB_HEADER = '$id'";

    $query = $this->oracle->query($sql);
    return $query;
  }

  /////////////////////////////////////////////////////////////////////////////

  public function getdatapdf($mesin)
  {
    $sql = "SELECT *
    FROM khs_periodical_maintenance kpm
    WHERE kpm.NAMA_MESIN = '$mesin'
    order by kondisi_mesin desc, id, header";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // return $sql;
  }
}
