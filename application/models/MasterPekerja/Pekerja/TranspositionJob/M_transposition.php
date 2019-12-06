<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class M_transposition extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->load->database();
  }

  public function getTpribadi()
  {
    $sql = "SELECT * FROM hrd_khs.tpribadi where keluar='0' ORDER BY noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getTpekerjaan($kodesie)
  {
    $sql = "SELECT * FROM hrd_khs.tpekerjaan where left(kdpekerjaan,7) = '$kodesie'";
    return $this->personalia->query($sql)->result_array();
  }

  public function getPekerjaan($noind)
  {
    $sql = "SELECT tp.kd_pkj, tpe.pekerjaan, left(tp.kodesie, 7) as kodesie FROM hrd_khs.tpribadi tp
            INNER JOIN hrd_khs.tpekerjaan tpe ON tp.kd_pkj = tpe.kdpekerjaan
            WHERE tp.noind = '$noind'";
    return $this->personalia->query($sql)->result_array();
  }

  public function saveMasterPekerja($save)
  {
    $this->db->insert('master_pekerja.t_transposisi_pekerja', $save);
    return;
  }

  public function updatetpribadi($pkj_now, $kerja, $noind)
  {
    $sql = "UPDATE hrd_khs.tpribadi set kd_pkj = '$pkj_now' where noind = '$noind' AND kd_pkj = '$kerja' AND keluar = '0'";
    return $this->personalia->query($sql);
  }

  public function inTlog($log)
  {
    $this->personalia->insert('hrd_khs.tlog', $log);
    return;
  }
}
?>
