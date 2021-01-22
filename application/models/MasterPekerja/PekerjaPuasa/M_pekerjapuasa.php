<?php
Defined('BASEPATH') or exit('No direct Script access allowed');

class M_pekerjapuasa extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->personalia = $this->load->database('personalia', TRUE);
  }

  function getPekerjaAll()
  {
    $sql = "SELECT pri.kodesie, pola.noind, pri.Nama, sie.Seksi, pri.Agama, shift.shift 
    FROM hrd_khs.tpribadi pri INNER JOIN 
    hrd_khs.tseksi sie ON pri.Kodesie = sie.Kodesie INNER JOIN 
    \"Presensi\".tpolapernoind pola ON pri.Noind = pola.noind INNER JOIN 
    \"Presensi\".tshift shift ON pola.pola_kombinasi = shift.kd_shift 
    WHERE (pri.puasa='1') AND (pri.keluar = '0') AND (length(pola.kodesie) = 9) AND (length(pola.pola_kombinasi) = 1) 
    ORDER BY pola.kodesie, pola.noind";
    return $this->personalia->query($sql)->result_array();
  }

  function getPekerjaNonShift()
  {
    $sql = "SELECT pri.kodesie, pola.noind, pri.Nama, sie.Seksi, pri.Agama 
    FROM hrd_khs.tpribadi pri INNER JOIN 
    hrd_khs.tseksi sie ON pri.Kodesie = sie.Kodesie INNER JOIN 
    \"Presensi\".tpolapernoind pola ON pri.Noind = pola.noind  
    WHERE (pri.puasa='1') AND (pri.keluar = '0') AND (length(pola.kodesie) = 9) AND (length(pola.pola_kombinasi) > 1) 
    ORDER BY pola.kodesie, pola.noind ";
    return $this->personalia->query($sql)->result_array();
  }
}
