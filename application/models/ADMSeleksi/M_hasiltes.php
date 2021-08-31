<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class M_hasiltes extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->personalia 	= 	$this->load->database('personalia', TRUE);
  }
  
  public function get_nama_peserta($term, $kode,$tgl)
  {
    $sql = "select distinct nama_peserta from \"Adm_Seleksi\".tjadwal_psikotest tb
            where tb.nama_peserta like '%$term%'
            and kode_test like '%$kode%'
            and tgl_test = '$tgl'
            order by nama_peserta";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function data_hasil_tes($kode, $tgl, $peserta, $tes)
  {
    $sql = "select distinct a.*, b.id_tes, c.nama_tes
            from \"Adm_Seleksi\".tjadwal_psikotest a,
            \"Adm_Seleksi\".tpsikotes_jawaban b,
            \"Adm_Seleksi\".tsetuppertanyaan c
            where a.kode_akses = b.kode_akses
            and b.id_tes = c.id_tes
            and b.id_tes = a.id_test
            and a.kode_test like '%$kode%'
            $tgl $peserta $tes
            order by a.tgl_test desc, a.nama_peserta";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function data_psikotest($kode)
  {
    $sql = "select distinct a.*, b.id_tes, c.nama_tes
          from \"Adm_Seleksi\".tjadwal_psikotest a,
          \"Adm_Seleksi\".tpsikotes_jawaban b,
          \"Adm_Seleksi\".tsetuppertanyaan c
          where a.kode_akses = b.kode_akses
          and b.id_tes = c.id_tes
          and a.id_test = b.id_tes
          and a.kode_test like '%$kode%'
          order by a.tgl_test desc, a.nama_peserta";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function detail_tes($kode, $id_tes)
  {
    $sql = " select distinct a.*, b.id_tes, c.nama_tes, b.id_pertanyaan, d.pertanyaan, b.jawaban, e.jawaban, e.status_correct,
            COALESCE(e.jawaban, b.jawaban) cek
            from \"Adm_Seleksi\".tjadwal_psikotest a,       
            \"Adm_Seleksi\".tpsikotes_jawaban b 
            LEFT JOIN \"Adm_Seleksi\".tsjawaban e
                ON b.id_pertanyaan = e.id_pertanyaan       
            and b.jawaban = CAST(e.id_jawaban as VarChar),       
            \"Adm_Seleksi\".tsetuppertanyaan c,       
            \"Adm_Seleksi\".tspertanyaan d
            where a.kode_akses = b.kode_akses       
            and a.id_test = b.id_tes  
            and b.id_tes = c.id_tes       
            and b.id_tes = d.id_tes       
            and b.id_pertanyaan = d.id_pertanyaan       
            --and b.id_pertanyaan = e.id_pertanyaan       
            --and b.jawaban = CAST(e.id_jawaban as VarChar)       
            and a.kode_akses = '$kode'       
            and a.id_test = $id_tes     
            order by a.tgl_test desc, a.nama_peserta, b.id_pertanyaan";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function get_pertanyaan($id_tes)
  {
    $sql = "select d.id_pertanyaan
      from \"Adm_Seleksi\".tspertanyaan d
      where d.id_tes = $id_tes
      order by d.id_pertanyaan";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function getdata_hasil($kode)
  {
    $sql = "select distinct a.*, b.id_tes, c.nama_tes, b.id_pertanyaan,
    d.pertanyaan, b.jawaban, e.jawaban, e.status_correct, COALESCE(e.jawaban, b.jawaban) cek
      from \"Adm_Seleksi\".tjadwal_psikotest a,
      \"Adm_Seleksi\".tpsikotes_jawaban b
LEFT JOIN \"Adm_Seleksi\".tsjawaban e
    ON b.id_pertanyaan = e.id_pertanyaan       
and b.jawaban = CAST(e.id_jawaban as VarChar),
      \"Adm_Seleksi\".tsetuppertanyaan c,
      \"Adm_Seleksi\".tspertanyaan d
      --\"Adm_Seleksi\".tsjawaban e
      where a.kode_akses = b.kode_akses
      and a.id_test = b.id_tes
      and b.id_tes = c.id_tes
      and b.id_tes = d.id_tes
      and b.id_pertanyaan = d.id_pertanyaan
      --and b.id_pertanyaan = e.id_pertanyaan
      --and b.jawaban = CAST(e.id_jawaban as VarChar)
      and a.kode_akses in ($kode)
      order by a.tgl_test desc, a.nama_peserta, b.id_pertanyaan";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function delete_jawaban($kode, $id_tes){
    $sql = "delete from \"Adm_Seleksi\".tpsikotes_jawaban where kode_akses = '$kode' and id_tes = $id_tes";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql);
  }
  
  public function delete_sesi($kode, $id_tes){
    $sql = "delete from \"Adm_Seleksi\".tpsikotes_sesi where kode_akses = '$kode' and id_tes = $id_tes";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql);
  }
  
  public function delete_peserta($kode, $id_tes){
    $sql = "delete from \"Adm_Seleksi\".tpjadwal_psikotest where kode_akses = '$kode' and id_test = $id_tes";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql);
  }


}