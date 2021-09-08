<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class M_penjadwalan extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->personalia 	= 	$this->load->database('personalia', TRUE);
  }
  
  public function data_peserta($tipe, $tanggal)
  {
    if ($tipe == 'SMK/SMA_Reg') {
      $param = "and tb.pendidikan in ('SMK', 'SMA')";
    }elseif ($tipe == 'D3/S1') {
      $param = "and tb.pendidikan in ('D3', 'S1')";
    }else {
      $param = "and tb.pendidikan = '$tipe'";
    }

    $sql = "select * from \"Adm_Seleksi\".tberkas tb
            where tb.tglsurat = '$tanggal'
            $param
            order by nama";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }

  
  public function savePesertaPsikotest($array)
  {
    $this->personalia->INSERT('"Adm_Seleksi".tjadwal_psikotest', $array);
    return;
  }

  public function updatePesertaPsikotest($array){
    $sql = "update \"Adm_Seleksi\".tjadwal_psikotest
            set tgl_test = '".$array['tgl_test']."',
                waktu_mulai = '".$array['waktu_mulai']."',
                waktu_selesai = '".$array['waktu_selesai']."',
                zona = '".$array['zona']."'
            where kode_akses = '".$array['kode_akses']."'
            and id_test = '".$array['id_test']."'";
    return $this->personalia->query($sql);
  }

  // public function hapus_peserta($kode){
  //   $sql = "delete from \"Adm_Seleksi\".tberkas where kodelamaran = '$kode'";
  //   // echo "<pre>";print_r($sql);exit();
  //   return $this->personalia->query($sql);
  // }
  
  public function hapus_peserta2($kode){
    $sql = "delete from \"Adm_Seleksi\".tjadwal_psikotest where kode_akses = '$kode'";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql);
  }
  
  public function hapus_jadwal($kode, $tgl){
    $sql = "delete from \"Adm_Seleksi\".tjadwal_psikotest where kode_test = '$kode' and tgl_test = '$tgl'";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql);
  }
  
  public function insert_log($wkt, $menu, $ket, $noind, $jenis, $program){
    $sql = "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program, noind_baru) 
            VALUES('$wkt', '$menu', '$ket', '$noind', '$jenis', '$program', NULL);";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql);
  }
  
  public function cek_jadwal($id_tes, $kode_akses)
  {
    $sql = "select * from \"Adm_Seleksi\".tjadwal_psikotest tb
            where tb.kode_akses = '$kode_akses'
            and id_test = '$id_tes'";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function data_psikotest($kode)
  {
    $sql = "select * from \"Adm_Seleksi\".tjadwal_psikotest tb
            where tb.kode_test like '%$kode%'
            order by tgl_test desc, nama_peserta";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function data_psikotest2($kode, $tgl)
  {
    $sql = "select distinct tb.kode_test, tb.tgl_surat, tb.tgl_test, tb.waktu_mulai, tb.waktu_selesai, tb.zona,
            tb.nik, tb.nama_peserta, tb.pendidikan, tb.no_hp, tb.kode_akses
            from \"Adm_Seleksi\".tjadwal_psikotest tb
            where tb.kode_test like '%$kode%'
            and tgl_test = '$tgl'
            order by tgl_test desc, nama_peserta";
    return $this->personalia->query($sql)->result_array();
  }
  
  public function data_tes($kode, $tgl)
  {
    $sql = "select distinct id_test from \"Adm_Seleksi\".tjadwal_psikotest tb
            where tb.kode_test like '%$kode%'
            and tgl_test = '$tgl'
            order by id_test";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }

  public function get_namates($term)
  {
    $sql = "select * from \"Adm_Seleksi\".tsetuppertanyaan tb
            where tb.nama_tes like '%$term%'
            order by nama_tes";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  
  public function get_namates2($term)
  {
    $sql = "select * from \"Adm_Seleksi\".tsetuppertanyaan tb
            where tb.id_tes = $term
            order by nama_tes";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }
  


}