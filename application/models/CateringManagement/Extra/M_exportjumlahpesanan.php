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
      $shift = "sum(case when fs_kd_shift = '1' then (select fn_jumlah_pesan) end) as shift_satu_umum,
                null as shift_dua,
                null as shift_tiga";
    } elseif ($shift == '2') {
      $shift = "null as shift_satu_umum,
                sum(case when fs_kd_shift = '2' then (select fn_jumlah_pesan) else null end) as shift_dua,
                null as shift_tiga";
    } elseif ($shift == '3') {
      $shift = "null as shift_satu_umum,
                null as shift_dua,
                sum(case when fs_kd_shift = '3' then (select fn_jumlah_pesan) end) as shift_tiga";
    } else {
      $shift = "sum(case when fs_kd_shift = '1' then (select fn_jumlah_pesan) end) as shift_satu_umum,
                sum(case when fs_kd_shift = '2' then (select fn_jumlah_pesan) end) as shift_dua,
                sum(case when fs_kd_shift = '3' then (select fn_jumlah_pesan) end) as shift_tiga";
    }

    $sql = "SELECT case when lokasi = '1' then 'Pusat + Mlati' when lokasi = '2' then 'Tuksono' end as lokasi,
    to_char(fd_tanggal, 'DD-MM-YYYY') AS fd_tanggal,
    $shift
    from \"Catering\".tpesanan
    where fd_tanggal between '$periode1' and '$periode2'
    $lokasi
    group by fd_tanggal,lokasi
    order by lokasi,fd_tanggal";

    return $this->personalia->query($sql)->result_array();
  }
}
