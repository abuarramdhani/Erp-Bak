<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_exportrencanalembur extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->quick = $this->load->database('quick', TRUE);
    $this->personalia = $this->load->database('personalia', TRUE);
  }
  public function getDataLembur($tgllembur, $tmpmakan, $statmakan, $statapprov)
  {
    if ($tmpmakan == '1') {
      $tmpmakan = "and e.fs_lokasi = '1'";
    } elseif ($tmpmakan == '2') {
      $tmpmakan = "and e.fs_lokasi = '2'";
    } elseif ($tmpmakan == 'all') {
      $tmpmakan =  '';
    }

    if ($statmakan == '1') {
      $statmakan = "and a.makan = '1'";
    } elseif ($statmakan == '0') {
      $statmakan = "and a.makan = '0'";
    } elseif ($statmakan == 'all') {
      $statmakan = '';
    }

    if ($statapprov == '1') {
      $statapprov = "and a.status_approve = '1'";
    } elseif ($statapprov == '2') {
      $statapprov = "and a.status_approve = '2'";
    } elseif ($statapprov == '0') {
      $statapprov = "and a.status_approve = '0'";
    } elseif ($statapprov == 'all') {
      $statapprov = '';
    }

    $sql = "SELECT mulai,selesai,nama_lembur,a.pekerjaan,a.noind as pekerja_noind,c.nama as pekerja_nama,
	case when makan = 1 then 'Makan' when makan = 0 then 'Tidak Makan' else '?' end makan,
	a.tempat_makan,shift,atasan as atasan_noind, d.nama as atasan_nama,
	case status_approve
		when 0 then 'Belum Diproses Atasan'
		when 1 then 'Disetujui'
		when 2 then 'Tidak disetujui'
	end as status
  from \"Presensi\".t_rencana_lembur a 
  left join \"Presensi\".tjenislembur b 
  on a.jenis_lembur = b.kd_lembur
  left join hrd_khs.tpribadi c
  on a.noind = c.noind
  left join hrd_khs.tpribadi d 
  on a.atasan = d.noind
  left join \"Catering\".ttempat_makan e 
  on a.tempat_makan = e.fs_tempat_makan
  where tanggal_lembur ='$tgllembur'
  $tmpmakan
  $statapprov
  $statmakan";

    // echo ($sql);
    // exit;

    return $this->personalia->query($sql)->result_array();
  }
}
