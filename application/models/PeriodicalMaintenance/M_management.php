<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_management extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->oracle = $this->load->database('oracle', TRUE);
  }

  function getMesin()
  {
    $oracle = $this->load->database('oracle', TRUE);
    $sql = "SELECT DISTINCT kpm.NAMA_MESIN 
        FROM khs_periodical_maintenance kpm";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }


  // public function getAll($mesin)
  // {
  //   $sql = "SELECT DISTINCT kpm.ID, kpm.NAMA_MESIN , kpm.KONDISI_MESIN, kpm.HEADER,
  //           kpm.NO_DOKUMEN, kpm.NO_REVISI, kpm.TANGGAL_REVISI, kpm.CATATAN_REVISI 
  //           FROM khs_periodical_maintenance kpm
  //           WHERE kpm.NAMA_MESIN = '$mesin'
  //           order by kpm.KONDISI_MESIN DESC, kpm.ID, kpm.HEADER";
  //   $query = $this->oracle->query($sql);
  //   return $query->result_array();
  // }

  public function getAll($mesin)
  {
    $sql = "SELECT DISTINCT kpm.ID, kpm.NAMA_MESIN , kpm.KONDISI_MESIN,
            kpm.NO_DOKUMEN, kpm.NO_REVISI, kpm.TANGGAL_REVISI, kpm.CATATAN_REVISI 
            FROM khs_periodical_maintenance kpm
            WHERE kpm.NAMA_MESIN = '$mesin'
            order by kpm.KONDISI_MESIN DESC, kpm.ID";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getTop($mesin)
  {
    $sql = "SELECT DISTINCT kpm.NAMA_MESIN ,kpm.NO_DOKUMEN, kpm.NO_REVISI, kpm.TANGGAL_REVISI, kpm.CATATAN_REVISI 
            FROM khs_periodical_maintenance kpm
            WHERE kpm.NAMA_MESIN = '$mesin'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }


  public function getGambar($mesin)
  {
    $sql = "SELECT DISTINCT * FROM KHS_GAMBAR_MPA kgm 
    WHERE kgm.NAMA_MESIN = '$mesin'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  // public function getDetail($mesin, $kondisi, $header)
  // {
  //   if (strlen($header) == 0) {
  //     $coba = "AND kpm.HEADER IS NULL";
  //   } else {
  //     $coba = "AND kpm.HEADER = '$header'";
  //   }
  //   $sql = "SELECT kpm.HEADER_MESIN,kpm.SUB_HEADER, kpm.STANDAR, kpm.PERIODE 
  //           FROM khs_periodical_maintenance kpm 
  //           WHERE kpm.NAMA_MESIN = '$mesin' 
  //           AND kpm.KONDISI_MESIN = '$kondisi' 
  //           $coba";
  //   $query = $this->oracle->query($sql);
  //   return $query->result_array();
  // }

  public function getDetail($mesin, $kondisi)
  {
    if($kondisi == null){
      $qkondisi = "AND kpm.KONDISI_MESIN IS NULL";
    } else {
      $qkondisi = "AND kpm.KONDISI_MESIN = '$kondisi'";
    }
    
    $sql = "SELECT kpm.HEADER,kpm.SUB_HEADER, kpm.STANDAR, kpm.PERIODE 
            FROM khs_periodical_maintenance kpm 
            WHERE kpm.NAMA_MESIN = '$mesin' 
            $qkondisi";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function selectDataToEdit($id)
  {
    $sql = "SELECT *
    FROM khs_periodical_maintenance kpm 
    WHERE kpm.SUB_HEADER = '$id'";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function updateTopManagement($id, $nodoc, $norev, $revdate, $noterev)
  {
    $sql = "UPDATE khs_periodical_maintenance
    SET NO_DOKUMEN = '$nodoc', NO_REVISI = '$norev', TANGGAL_REVISI = '$revdate', CATATAN_REVISI = '$noterev'
    WHERE NAMA_MESIN = '$id'";

    $query = $this->oracle->query($sql);
    return $query;
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
  }

  public function getDataHeader($mesin)
  {
    $sql = "SELECT DISTINCT kpm.NO_DOKUMEN, kpm.NO_REVISI
    , kpm.TANGGAL_REVISI, kpm.CATATAN_REVISI 
    FROM khs_periodical_maintenance kpm
    WHERE kpm.nama_mesin = '$mesin'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getDataGambar($mesin)
  {
    $sql = "SELECT * FROM khs_gambar_mpa kgm
    WHERE kgm.NAMA_MESIN = '$mesin'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  /////////////////////////////////////////////////////////////////////////////

  public function insertGambarMPA($mesin, $img)
  {
      $sql = "INSERT INTO khs_gambar_mpa (nama_mesin, file_dir_address)
      VALUES ('$mesin', '$img')";
      $query = $this->oracle->query($sql);
      return $sql;
  }

  public function deleteImageMPA($mesin)
  {
    $sql = " DELETE FROM khs_gambar_mpa kgm
    WHERE kgm.NAMA_MESIN = '$mesin'";

    $query = $this->oracle->query($sql);
    return $query;
  }
}
