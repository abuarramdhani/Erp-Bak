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
    $sql = "SELECT DISTINCT h.noind FROM \"Presensi\".t_hak_akses_presensi h";
    $result =  $this->personalia->query($sql)->result_array();

    $noind = [];
    foreach ($result as $key) {
      array_push($noind, $key['noind']);
    }
    return $noind;
  }



  public function getAksesUser()
  {
    $sql = 'SELECT DISTINCT h.noind,p.nama,s.seksi,
        (SELECT COUNT(h.kodesie) FROM "Presensi".t_hak_akses_presensi h WHERE h.noind = p.noind) AS jumlah_akses
        FROM "Presensi".t_hak_akses_presensi h 
        INNER JOIN hrd_khs.tpribadi p 
              ON h.noind = p.noind
        INNER JOIN hrd_khs.tseksi s
              ON p.kodesie = s.kodesie ORDER BY h.noind';
    $result = $this->personalia->query($sql)->result_array();
    return $result;
  }


  public function getDataPekerja($key)
  {
    $sql = "SELECT p.noind,p.nama,p.keluar,p.sebabklr FROM hrd_khs.tpribadi p WHERE (p.nama LIKE '$key%' OR p.noind LIKE '$key%') AND p.keluar = '0'";
    return $this->personalia->query($sql)->result_array();
  }

  public function getHakAkses($noind)
  {
    $sql = "SELECT h.kodesie,h.id,
            (SELECT coalesce(nullif(trim(seksi), '-'), nullif(trim(unit),'-'), nullif(trim(bidang),'-'), dept) AS nama
                    FROM hrd_khs.tseksi s 
                    WHERE substr(kodesie,0,8) LIKE LEFT(h.kodesie,7) ORDER BY 1 LIMIT 1) AS seksi
                    FROM \"Presensi\".t_hak_akses_presensi h 
            WHERE h.noind LIKE '$noind'";
    return $this->personalia->query($sql)->result_array();
  }

  public function getDataSeksi($key)
  {
    $sql = "SELECT s.kodesie AS kodesie,s.seksi FROM hrd_khs.tseksi s  
            WHERE (s.kodesie LIKE '$key%' OR s.seksi LIKE '$key%') AND SUBSTR(s.kodesie,8,11) = '00'";
    return $this->personalia->query($sql)->result_array();
  }

  // Insert
  public function addAksesPekerja($noind, $kodesie)
  {
    $this->personalia->delete('"Presensi".t_hak_akses_presensi', ['noind' => $noind]);
    foreach ($kodesie as $ks) {
      $sql = "INSERT INTO \"Presensi\".t_hak_akses_presensi (noind, kodesie) VALUES('$noind','$ks')";
      $this->personalia->query($sql);
    }
  }

  public function deleteAksesPekerja($noind)
  {
    $sql = "DELETE FROM \"Presensi\".t_hak_akses_presensi WHERE noind = '$noind'";
    $this->personalia->query($sql);
  }
}
