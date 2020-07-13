<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class M_indexinfo extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->personalia 	= 	$this->load->database('personalia', TRUE);
  }

  public function getDataAll()
  {
    return $this->personalia->query("SELECT * FROM \"Surat\".t_memo_cutoff where deleted_date is null ORDER BY update_date DESC")->result_array();
  }

  public function getDataPrint($id)
  {
    return $this->personalia->query("SELECT * FROM \"Surat\".t_memo_cutoff WHERE id = '$id'")->result_array();
  }

  public function getPeriode($tperiode)
  {
    $sql = "SELECT * FROM \"Presensi\".tcutoff WHERE periode = '$tperiode' ORDER BY id_cutoff DESC LIMIT 1";
    return $this->personalia->query($sql)->result_array();
  }

  public function getPerUpdate($periodeEX)
  {
    $sql = "SELECT * FROM \"Presensi\".tcutoff WHERE periode = '$periodeEX' limit 1";
    return $this->personalia->query($sql)->result_array();
  }

  public function getAlasan()
  {
    return $this->personalia->query("SELECT isi_surat FROM \"Surat\".tisi_surat Where id_isi = '26' and jenis_surat = 'A CUT OFF' AND staf =  '1' LIMIT 1")->row()->isi_surat;
  }

  public function getDetailTambahanPrev($param, $noind)
  {
    if ($param == true) {
      $noindNew = "in ($noind)";
    }else {
      $noindNew = "= '$noind'";
    }
    $sql = "SELECT tp.nama, trim(ts.dept) as dept, trim(ts.bidang) as bidang, trim(ts.unit) as unit, trim(ts.seksi) as seksi , left(tp.kodesie, 7) as kodesie, trim(tp.jenkel) as jenkel
            FROM hrd_khs.tpribadi tp
            LEFT JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie
            WHERE tp.noind $noindNew AND tp.keluar = '0'
            ORDER BY seksi";
    return $this->personalia->query($sql)->result_array();
  }
  //
  public function getkodeTambahanPrev($param, $noind)
  {
    if ($param == true) {
      $newkodesie = "in ($noind)";
    }else {
      $newkodesie = "= '$noind'";
    }
    $sql = "SELECT distinct trim(ts.seksi) as seksi, left(ts.kodesie, 7) as kodesie
            FROM hrd_khs.tseksi ts
            WHERE left(ts.kodesie, 7) $newkodesie
            ORDER BY kodesie";
    return $this->personalia->query($sql)->result_array();
  }

  public function getAtasan()
  {
    $sql = "SELECT distinct trim(tp.noind) as noind, trim(tp.nama) as nama, tr.jabatan, left(tp.kodesie, 7) as kodesie from hrd_khs.tpribadi tp
            left join hrd_khs.trefjabatan tr on tp.kd_jabatan = tr.kd_jabatan and tp.kodesie = tr.kodesie and tp.noind = tr.noind
            where tp.keluar = '0' and (tp.kd_jabatan between '01' and '13') order by jabatan";
    return $this->personalia->query($sql)->result_array();
  }

  public function getTemplateStaf()
  {
    return $this->personalia->query("SELECT isi_surat FROM \"Surat\".tisi_surat Where id_isi = '24' and jenis_surat = 'CUT OFF' AND staf = '1' LIMIT 1")->row()->isi_surat;
  }

  public function getTemplateNonStaf()
  {
    return $this->personalia->query("SELECT isi_surat FROM \"Surat\".tisi_surat Where id_isi = '23' and jenis_surat = 'CUT OFF NSTAF' AND staf = '0' LIMIT 1")->row()->isi_surat;
  }

  public function getHubker()
  {
    return $this->personalia->query("SELECT noind, nama FROM hrd_khs.tpribadi WHERE keluar = '0'  AND kodesie like '401%' AND kd_jabatan between '01' AND '13' ORDER BY noind")->result_array();
  }

  public function getPekerjaStafSP3()
  {
    $sql = "SELECT tc.*, tp.nama, tp.jenkel, tp.kodesie, ts.seksi, ts.unit, ts.bidang, ts.dept  FROM \"Presensi\".tcutoff_custom tc
            LEFT JOIN hrd_khs.tpribadi tp ON tc.noind = tp.noind
            LEFT JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie
            WHERE left(tc.noind, 1) in ('B', 'D', 'J', 'T') AND tp.keluar = '0'
            ORDER BY tc.noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getPekerjaNonStafSP3()
  {
    $sql = "SELECT tc.*, tp.nama, tp.jenkel, tp.kodesie, ts.seksi, ts.unit, ts.bidang, ts.dept  FROM \"Presensi\".tcutoff_custom tc
            LEFT JOIN hrd_khs.tpribadi tp ON tc.noind = tp.noind
            LEFT JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie
            WHERE left(tc.noind, 1) in ('A', 'H', 'E') AND tp.keluar = '0'
            ORDER BY tc.noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getSeksi($kodesie)
  {
    $sql = "SELECT seksi from hrd_khs.tseksi where kodesie like '%$kodesie%'";
    return $this->personalia->query($sql)->result_array();
  }

  public function getTertandaM($noind)
  {
    $sql = "SELECT tp.nama, tj.jabatan FROM hrd_khs.tpribadi tp LEFT JOIN hrd_khs.trefjabatan tj ON tp.kodesie = tj.kodesie AND tp.noind = tj.noind and tp.kd_jabatan = tj.kd_jabatan
            WHERE tp.noind = '$noind'";
    return $this->personalia->query($sql)->result_array();
  }

  public function saveMemoStaf($saveMemo)
  {
    $this->personalia->insert("\"Surat\".t_memo_cutoff", $saveMemo);
    return;
  }

  public function deleteMemo($id)
  {
    $logged_user = $this->session->user;
    $sql = "UPDATE \"Surat\".t_memo_cutoff set deleted_by = '$logged_user', deleted_date = now() WHERE id='$id'";
    $this->personalia->query($sql);
  }

//preview non staf
  public function getDataPekerjaPreviewNonstaf($param, $noind)
  {
    if ($param == true) {
      $noindNew = "in ($noind)";
    }else {
      $noindNew = "= '$noind'";
    }
    $sql = "SELECT tp.noind, trim(tp.nama) as nama, trim(ts.seksi) as seksi , tp.kd_jabatan, left(tp.kodesie, 7) as kodesie, (select ket from \"Presensi\".tcutoff_custom where noind = tp.noind) as ket
            FROM hrd_khs.tpribadi tp
            LEFT JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie
            WHERE tp.noind $noindNew AND tp.keluar = '0'
            ORDER BY seksi";
    return $this->personalia->query($sql)->result_array();
  }

  public function getAtasanNonStaf($param, $noind)
  {
    if ($param == true) {
      $noindNew = "in ($noind)";
    }else {
      $noindNew = "= '$noind'";
    }
    $sql = "SELECT tp.noind, ts.seksi ,tp.nama, tp.jenkel, left(tp.kodesie, 7) as kodesie, tp.kd_jabatan, tj.jabatan FROM hrd_khs.tpribadi tp
            LEFT JOIN hrd_khs.trefjabatan tj ON tp.kodesie = tj.kodesie AND tp.noind = tj.noind AND tp.kd_jabatan = tj.kd_jabatan
            LEFT JOIN hrd_khs.tseksi ts ON tp.kodesie = ts.kodesie
            WHERE tp.noind $noindNew order by kodesie";
    return $this->personalia->query($sql)->result_array();
  }

  public function newAtasan()
  {
    $sql = "SELECT
             distinct substring(tp.kodesie, 1, 7) kodesie,
             rtrim(ts.seksi) seksi,
             (
              SELECT array_agg(tpri.noind || '  -  ' || rtrim(tpri.nama)|| '  -  ' || rtrim(tj.jabatan) ORDER BY tpri.kd_jabatan, tpri.noind)
             FROM
              hrd_khs.tpribadi tpri
             LEFT JOIN hrd_khs.trefjabatan tj ON
              tpri.noind = tj.noind
              AND (substring(tpri.kodesie, 1, 7) = substring(tj.kodesie, 1, 7)
              OR substring(tpri.kodesie, 1, 5) = substring(tj.kodesie, 1, 5)
              OR substring(tpri.kodesie, 1, 3) = substring(tj.kodesie, 1, 3)
              OR substring(tpri.kodesie, 1, 1) = substring(tj.kodesie, 1, 1) )
              AND tpri.kd_jabatan = tj.kd_jabatan
             WHERE
              keluar = '0'
              AND ((tpri.kd_jabatan IN ('10',
              '11',
              '12',
              '13')
              AND substring(tj.kodesie, 1, 7) = substring(tp.kodesie, 1, 7))
              OR (tpri.kd_jabatan IN ('08',
              '09')
              AND substring(tj.kodesie, 1, 5) = substring(tp.kodesie, 1, 5))
              OR (tpri.kd_jabatan IN ('05',
              '06',
              '07')
              AND substring(tj.kodesie, 1, 3) = substring(tp.kodesie, 1, 3))
              OR (tpri.kd_jabatan IN ('02',
              '03',
              '04')
              AND substring(tj.kodesie, 1, 1) = substring(tp.kodesie, 1, 1)) )
              AND tpri.kd_jabatan <> tp.kd_jabatan) atasan_langsung
            FROM
             hrd_khs.tpribadi tp
            LEFT JOIN hrd_khs.tseksi ts ON
             substring(tp.kodesie, 1, 7) = substring(ts.kodesie, 1, 7)
            WHERE
             tp.keluar = '0'
             AND substring(tp.noind, 1, 1) IN ('A',
             'H',
             'E')
            GROUP BY
             tp.kodesie,
             ts.seksi,
             tp.kd_jabatan
            ORDER BY
             2";
    return $this->personalia->query($sql)->result_array();
  }

  public function saveTemporary($value)
  {
    $this->personalia->query("insert into \"Surat\".t_temporary_seksi(seksi)
                              values('".$value['seksi']."')");
    return;
  }

  public function saveTemporaryAtasan($value)
  {
    $this->personalia->query("insert into \"Surat\".t_temporary_atasan(noind)
                              values('".$value['noind']."')");
    return;
  }
  public function saveTemporaryJabatan($value)
  {
    $this->personalia->query("insert into \"Surat\".t_temporary_jabatan(jabatan)
                              values('".$value['jabatan']."')");
    return;
  }

  public function getAtasanPerSurat()
  {
    $sql = "SELECT ta.*, trim(tb.seksi) as seksi, trim(tp.nama) as nama, trim(tc.jabatan) as jabatan, trim(tp.jenkel) as jenkel from \"Surat\".t_temporary_atasan ta
            LEFT JOIN \"Surat\".t_temporary_seksi tb on ta.id = tb.id
            LEFT JOIN \"Surat\".t_temporary_jabatan tc on ta.id = tc.id
            LEFT JOIN hrd_khs.tpribadi tp on ta.noind = tp.noind
            LEFT JOIN hrd_khs.trefjabatan tr on tp.noind = tr.noind and tp.kodesie = tr.kodesie and tp.kd_jabatan = tr.kd_jabatan
            ORDER BY 1";
    return $this->personalia->query($sql)->result_array();
  }

  public function deleteTemporarySeksi()
  {
    $sql = "DELETE FROM  \"Surat\".t_temporary_seksi";
    $this->personalia->query($sql);
  }

  public function deleteTemporaryAtasan()
  {
    $sql = "DELETE FROM  \"Surat\".t_temporary_atasan";
    $this->personalia->query($sql);
  }

  public function deleteTemporaryJabatan()
  {
    $sql = "DELETE FROM  \"Surat\".t_temporary_jabatan";
    $this->personalia->query($sql);
  }

}

 ?>
