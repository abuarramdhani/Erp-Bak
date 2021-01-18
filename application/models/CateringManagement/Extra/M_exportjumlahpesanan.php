<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_exportjumlahpesanan extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->quick = $this->load->database('quick', TRUE);
    $this->personalia = $this->load->database('personalia', TRUE);
  }

  public function GetJumlahPesanan($periode1, $periode2, $lokasi, $shift)
  {
    if ($lokasi == '1') {
      $lokasi = "and lokasi = '1'";
    } elseif ($lokasi == '2') {
      $lokasi = "and lokasi = '2'";
    } else {
      $lokasi = '';
    }

    if ($shift == '1') {
      $shift = "and fs_kd_shift = '1'";
    } elseif ($shift == '2') {
      $shift = "and fs_kd_shift = '2'";
    } elseif ($shift == '3') {
      $shift = "and fs_kd_shift = '3'";
    } else {
      $shift = '';
    }

    $sql = "SELECT case when lokasi = '1' then 'Pusat + Mlati' when lokasi = '2' then 'Tuksono' end as lokasi,
    to_char(fd_tanggal, 'DD-MM-YYYY') AS fd_tanggal,
    case when fs_kd_shift = '1' then 'Shift 1 Umum Tanggung' when fs_kd_shift = '2' then 'Shift 2' when fs_kd_shift = '3' then 'Shift 3' end as shift,	
    sum(fn_jumlah_pesan) as jumlah
    from \"Catering\".tpesanan
    where fd_tanggal between '$periode1' and '$periode2'
    $shift
    $lokasi
    group by fd_tanggal,lokasi,fs_kd_shift
    order by lokasi,fd_tanggal,fs_kd_shift";

    return $this->personalia->query($sql)->result_array();
  }
}
