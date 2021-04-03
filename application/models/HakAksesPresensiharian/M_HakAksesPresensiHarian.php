<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_HakAksesPresensiHarian extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->personalia = $this->load->database('personalia', TRUE);
  }

  // Select
  public function getNoind()
  {
    $sql = "select distinct h.noind from \"Presensi\".t_hak_akses_presensi h";
    $result =  $this->personalia->query($sql)->result_array();

    $noind = [];
    foreach ($result as $key) {
      array_push($noind, $key['noind']);
    }
    return $noind;
  }

  public function getAksesUser()
  {
    $sql = 'select distinct h.noind,p.nama,s.seksi,
        (select count(h.kodesie) from "Presensi".t_hak_akses_presensi h where h.noind = p.noind) as jumlah_akses
        from "Presensi".t_hak_akses_presensi h 
        inner join hrd_khs.tpribadi p 
              on h.noind = p.noind
        inner join hrd_khs.tseksi s
              on p.kodesie = s.kodesie order by h.noind';
    $result = $this->personalia->query($sql)->result_array();
    return $result;
  }

  public function getDataPekerja($key)
  {
    $sql = "select p.noind,p.nama,p.keluar,p.sebabklr from hrd_khs.tpribadi p where (p.nama like '$key%' or p.noind like '$key%') and p.keluar = '0'";
    return $this->personalia->query($sql)->result_array();
  }

  public function getHakAkses($noind)
  {
    $sql = "select h.kodesie,h.id,
            (select coalesce(nullif(trim(seksi), '-'), nullif(trim(unit),'-'), nullif(trim(bidang),'-'), dept) as nama
                    from hrd_khs.tseksi s 
                    where substr(kodesie,0,8) like left(h.kodesie,7) order by 1 limit 1) as seksi
                    from \"Presensi\".t_hak_akses_presensi h 
            where h.noind like '$noind'";
    return $this->personalia->query($sql)->result_array();
  }

  public function getDataSeksi($key)
  {
    $sql = "select s.kodesie as kodesie,s.seksi from hrd_khs.tseksi s  
            where (s.kodesie like '$key%' or s.seksi like '$key%') and substr(s.kodesie,8,11) = '00'";
    return $this->personalia->query($sql)->result_array();
  }

  // Insert
  public function addAksesPekerja($noind, $kodesie)
  {
    $this->personalia->delete('"Presensi".t_hak_akses_presensi', ['noind' => $noind]);
    foreach ($kodesie as $ks) {
      $sql = "insert into \"Presensi\".t_hak_akses_presensi (noind, kodesie) values('$noind','$ks')";
      $this->personalia->query($sql);
    }
  }

  public function deleteAksesPekerja($noind)
  {
    $sql = "delete from \"Presensi\".t_hak_akses_presensi where noind = '$noind'";
    $this->personalia->query($sql);
  }
}
