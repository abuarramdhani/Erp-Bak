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

  public function getNoDocMPA()
  {

    $sql = "SELECT DISTINCT kcm.DOCUMENT_NUMBER, KCM.NAMA_MESIN 
    FROM KHS_CEK_MESIN kcm
    ORDER BY 1";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  function getMesinFromDate($tanggal)
  {
    $sql = " SELECT DISTINCT kcm.NAMA_MESIN 
    ,TO_CHAR(kcm.ACTUAL_DATE ,'dd-mm-yyyy') ACTUAL_DATE 
    FROM KHS_CEK_MESIN kcm
    WHERE TO_CHAR(kcm.ACTUAL_DATE ,'dd-mm-yyyy') =  '$tanggal'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getHeaderMon($nodoc)
  {
    $sql = " SELECT DISTINCT kcm.NAMA_MESIN, kcm.KONDISI_MESIN, kcm.HEADER_MESIN 
    FROM KHS_CEK_MESIN kcm
    WHERE kcm.DOCUMENT_NUMBER = '$nodoc'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getDetailMon($nodoc, $mesin, $kondisi, $header)
  {
    if (strlen($header) == 0) {
      $coba = "AND kcm.HEADER_MESIN IS NULL";
    } else {
      $coba = "AND kcm.HEADER_MESIN = '$header'";
    }
    $sql = "SELECT kcm.SUB_HEADER, kcm.STANDAR, kcm.PERIODE_CHECK, kcm.DURASI, kcm.KONDISI, kcm.CATATAN 
    FROM KHS_CEK_MESIN kcm 
    WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
    AND kcm.NAMA_MESIN = '$mesin' 
    AND kcm.KONDISI_MESIN = '$kondisi' 
    $coba";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  /////////////////////////////////////////////////////////////////////////////

  public function getDataMon($nodoc)
  {
    $sql = "SELECT *
      FROM KHS_CEK_MESIN kcm 
      WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
      order by kcm.KONDISI_MESIN DESC, kcm.ID_MESIN, kcm.HEADER_MESIN";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getDataSparepart($nodoc)
  {
    $sql = "SELECT DISTINCT kdsm.SPAREPART, kdsm.SPESIFIKASI, kdsm.JUMLAH, kdsm.SATUAN 
    FROM KHS_DAFTAR_SPAREPART_MPA kdsm, KHS_CEK_MESIN kcm
    WHERE kdsm.DOCUMENT_NUMBER = '$nodoc'
    AND kdsm.NAMA_MESIN = kcm.NAMA_MESIN";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getDataHeader($nodoc)
  {
    $sql = "SELECT DISTINCT kpm.NO_DOKUMEN, kpm.NO_REVISI, kpm.TANGGAL_REVISI, kpm.CATATAN_REVISI
    FROM KHS_PERIODICAL_MAINTENANCE kpm, KHS_CEK_MESIN kcm
    WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
    AND kpm.NAMA_MESIN = kcm.NAMA_MESIN ";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function getDataFooter($nodoc)
  {
    $sql = "SELECT DISTINCT kcm.APPROVED_BY, kcm.APPROVED_DATE, kcm.APPROVED_BY_2, kcm.APPROVED_DATE_2
    FROM KHS_PERIODICAL_MAINTENANCE kpm, KHS_CEK_MESIN kcm
    WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
    AND kpm.NAMA_MESIN = kcm.NAMA_MESIN";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }


  public function getSumDurasi($nodoc)
  {
    $sql = "SELECT SUM(kcm.DURASI) TOTAL_DURASI
      FROM KHS_CEK_MESIN kcm 
      WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
      order by kcm.KONDISI_MESIN DESC, kcm.ID_MESIN, kcm.HEADER_MESIN ";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function selectDataEditMon($nodoc, $id)
  {
    $sql = "SELECT *
    FROM KHS_CEK_MESIN kcm 
    WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
    and kcm.SUB_HEADER = '$id'
    order by kcm.KONDISI_MESIN DESC, kcm.ID_MESIN, kcm.HEADER_MESIN";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

  public function updateSubMonitoring($nodoc, $id, $subHeader, $standar, $periode, $durasi, $kondisi, $catatan)
  {
    $sql = "UPDATE khs_cek_mesin
            SET DURASI = '$durasi', 
            KONDISI = '$kondisi',
            CATATAN = '$catatan'
            WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
            AND SUB_HEADER = '$id'";

    $query = $this->oracle->query($sql);
    return $query;
  }

  public function deleteSubMonitoring($id, $nodoc)
  {
    $sql = "DELETE FROM khs_cek_mesin
    WHERE kcm.DOCUMENT_NUMBER = '$nodoc'
    AND SUB_HEADER = '$id'";

    $query = $this->oracle->query($sql);
    return $query;
  }

  public function getDataGambar($mesin)
  {
    $sql = "SELECT * FROM khs_gambar_mpa kgm
    WHERE kgm.NAMA_MESIN = '$mesin'";
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }


}
