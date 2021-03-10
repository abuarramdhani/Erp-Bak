<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->oracle = $this->load->database('oracle_dev', TRUE);
  }

  function getMesinFromDate($tanggal)
  {
    $oracle = $this->load->database('oracle', TRUE);
    // $sql = " SELECT DISTINCT kcm.NAMA_MESIN 
    // ,TO_CHAR(kcm.ACTUAL_DATE ,'YYYY-MM-DD') ACTUAL_DATE 
    // FROM KHS_CEK_MESIN kcm
    // WHERE TO_CHAR(kcm.ACTUAL_DATE ,'YYYY-MM-DD') =  '$tanggal'";
    $sql = " SELECT DISTINCT kcm.NAMA_MESIN 
    ,TO_CHAR(kcm.ACTUAL_DATE ,'dd-mm-yyyy') ACTUAL_DATE 
    FROM KHS_CEK_MESIN kcm
    WHERE TO_CHAR(kcm.ACTUAL_DATE ,'dd-mm-yyyy') =  '$tanggal'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
        // echo $sql;
        // exit();

  }


  public function getHeaderMon($tanggal, $mesin)
  {
    // $oracle = $this->load->database('oracle', true);
    $sql = " SELECT DISTINCT kcm.NAMA_MESIN, kcm.KONDISI_MESIN, kcm.HEADER_MESIN 
    FROM KHS_CEK_MESIN kcm
    WHERE TO_CHAR(kcm.ACTUAL_DATE ,'DD-MM-YYYY') =  '$tanggal'
    AND kcm.NAMA_MESIN = '$mesin'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // echo $sql; exit();
  }

  public function getDetailMon($tanggal, $mesin, $kondisi, $header)
  {
    // $oracle = $this->load->database('oracle', true);
    if (strlen($header) == 0) {
      $coba = "AND kcm.HEADER_MESIN IS NULL";
    } else {
      $coba = "AND kcm.HEADER_MESIN = '$header'";
    }
    $sql = "SELECT kcm.SUB_HEADER, kcm.STANDAR, kcm.PERIODE_CHECK, kcm.DURASI, kcm.KONDISI, kcm.CATATAN 
    FROM KHS_CEK_MESIN kcm 
    WHERE TO_CHAR(kcm.ACTUAL_DATE ,'DD-MM-YYYY') =  '$tanggal'
    AND kcm.NAMA_MESIN = '$mesin' 
    AND kcm.KONDISI_MESIN = '$kondisi' 
    $coba";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // echo $sql; exit();
  }

  // public function selectDataToEdit($id)
  // {
  //   $sql = "SELECT *
  //   FROM khs_periodical_maintenance kpm 
  //   WHERE kpm.SUB_HEADER = '$id'";

  //   $query = $this->oracle->query($sql);
  //   return $query->result_array();
  // }

  // public function updateSubManagement($id, $subHeader, $standar, $periode)
  // {
  //   $sql = "UPDATE khs_periodical_maintenance
  //   SET SUB_HEADER = '$subHeader', STANDAR = '$standar', PERIODE = '$periode'
  //   WHERE SUB_HEADER = '$id'";

  //   $query = $this->oracle->query($sql);
  //   return $query;
  // }

  // public function deleteSubManagement($id)
  // {
  //   $sql = "DELETE FROM khs_periodical_maintenance WHERE SUB_HEADER = '$id'";

  //   $query = $this->oracle->query($sql);
  //   return $query;
  // }

  /////////////////////////////////////////////////////////////////////////////

  public function getDataMon($tanggal, $mesin)
  {
    $sql = "SELECT *
      FROM KHS_CEK_MESIN kcm 
      WHERE TO_CHAR(kcm.ACTUAL_DATE ,'DD-MM-YYYY') =  '$tanggal'
      AND kcm.NAMA_MESIN = '$mesin' 
      order by kcm.KONDISI_MESIN DESC, kcm.ID_MESIN, kcm.HEADER_MESIN ";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // return $sql;
  }

  public function getDataSparepart($tanggal, $mesin)
  {
    $sql = "SELECT DISTINCT kdsm.SPAREPART, kdsm.SPESIFIKASI, kdsm.JUMLAH, kdsm.SATUAN 
    FROM KHS_DAFTAR_SPAREPART_MPA kdsm, KHS_CEK_MESIN kcm
    WHERE kdsm.NAMA_MESIN = '$mesin'
    AND TO_CHAR(kdsm.ACTUAL_DATE ,'DD-MM-YYYY') =  '$tanggal'
    AND kdsm.NAMA_MESIN = kcm.NAMA_MESIN 
    AND kdsm.ACTUAL_DATE = kcm.ACTUAL_DATE ";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // return $sql;
  }


  public function getSumDurasi($tanggal, $mesin)
  {
    $sql = "SELECT SUM(kcm.DURASI) TOTAL_DURASI
      FROM KHS_CEK_MESIN kcm 
      WHERE TO_CHAR(kcm.ACTUAL_DATE ,'DD-MM-YYYY') =  '$tanggal'
      AND kcm.NAMA_MESIN = '$mesin' 
      order by kcm.KONDISI_MESIN DESC, kcm.ID_MESIN, kcm.HEADER_MESIN ";
    $query = $this->oracle->query($sql);
    return $query->result_array();
    // return $sql;
  }

  public function selectDataEditMon($tanggal, $mesin, $id)
  {
    $sql = "SELECT *
    FROM KHS_CEK_MESIN kcm 
    WHERE TO_CHAR(kcm.ACTUAL_DATE ,'DD-MM-YYYY') =  '$tanggal'
    AND kcm.NAMA_MESIN = '$mesin' 
    and kcm.SUB_HEADER = '$id'
    order by kcm.KONDISI_MESIN DESC, kcm.ID_MESIN, kcm.HEADER_MESIN";

    $query = $this->oracle->query($sql);
    return $query->result_array();
    // echo $sql; exit();

  }

  public function updateSubMonitoring($tgl, $mesin, $id, $subHeader, $standar, $periode, $durasi, $kondisi, $catatan)
  {
    $sql = "UPDATE khs_cek_mesin
            SET DURASI = '$durasi', 
            KONDISI = '$kondisi',
            CATATAN = '$catatan'
            WHERE NAMA_MESIN = '$mesin'
            AND TO_CHAR(ACTUAL_DATE ,'DD-MM-YYYY') = '$tgl'
            AND SUB_HEADER = '$id'";

    $query = $this->oracle->query($sql);
    return $query;
  }

  public function deleteSubMonitoring($id, $tanggal,$mesin)
  {
    $sql = "DELETE FROM khs_cek_mesin
    WHERE NAMA_MESIN = '$mesin'
    AND TO_CHAR(ACTUAL_DATE ,'DD-MM-YYYY') = '$tanggal'
    AND SUB_HEADER = '$id'";

    $query = $this->oracle->query($sql);
    return $query;
  }


}
