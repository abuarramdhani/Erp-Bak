<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_jumlahpekerja extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->personalia = $this->load->database("personalia", true);
  }

  public function Getrbtck($txt, $rbtckvalue)
  {
    if ($rbtckvalue == "departemen") {
      $trim = 1;
      $kategori = 'dept';
      $sql = "SELECT DISTINCT TRIM ($kategori) $kategori, left(kodesie,$trim) kode FROM hrd_khs.tseksi WHERE TRIM($kategori) != '-' AND $kategori LIKE '$txt%'";
      return $this->personalia->query($sql)->result_array();
    } else if ($rbtckvalue == "unit") {
      $trim = 5;
      $kategori = 'unit';
      $sql = "SELECT DISTINCT TRIM ($kategori) $kategori, left(kodesie,$trim) kode FROM hrd_khs.tseksi WHERE TRIM($kategori) != '-' AND $kategori LIKE '$txt%'";
      return $this->personalia->query($sql)->result_array();
    } else if ($rbtckvalue == "seksi") {
      $trim = 7;
      $kategori = 'seksi';
      $sql = "SELECT DISTINCT TRIM ($kategori) $kategori, left(kodesie,$trim) kode FROM hrd_khs.tseksi WHERE TRIM($kategori) != '-' AND $kategori LIKE '$txt%'";
      return $this->personalia->query($sql)->result_array();
    } else if ($rbtckvalue == "lokasi") {
      $sql = "SELECT * FROM hrd_khs.tlokasi_kerja WHERE tlokasi_kerja.lokasi_kerja LIKE '$txt%' OR tlokasi_kerja.id_ like '$txt%'";
      return $this->personalia->query($sql)->result_array();
    }
  }

  public function GetJumlah($id, $opt)
  {
    $sql = "SELECT TRIM(dept)d, TRIM(unit)u, TRIM(seksi)s,

    COUNT(CASE WHEN tp.noind LIKE 'A%' THEN 1 END) AS tetap,
    COUNT(CASE WHEN tp.noind LIKE 'E%' THEN 1 END) AS train,
    COUNT(CASE WHEN tp.noind LIKE 'F%' THEN 1 END) AS pkl,
    COUNT(CASE WHEN tp.noind LIKE 'H%' OR tp.noind LIKE 'T%' THEN 1 END) AS kontrak,
    
    COUNT(CASE WHEN tp.noind LIKE 'B%' THEN 1 END) AS stetap,
    COUNT(CASE WHEN tp.noind LIKE 'D%' THEN 1 END) AS strain,
    COUNT(CASE WHEN tp.noind LIKE 'G%' THEN 1 END) AS stkpw,
    COUNT(CASE WHEN tp.noind LIKE 'Q%' THEN 1 END) AS skp,
    COUNT(CASE WHEN tp.noind LIKE 'J%' THEN 1 END) AS skontrak,

    COUNT(CASE WHEN tp.noind LIKE 'K%' or noind like 'P%' THEN 1 END) AS os,
    
    
    COUNT(case when (noind like 'B%' or noind like 'A%' or noind like 'D%' or noind like 'K%' 
    or noind like 'F%' or noind like 'Q%'or noind like 'G%' or noind like 'H%' or noind like 'J%'or noind like 'T%' or noind like 'E%' or noind like 'P%') THEN 1 END) jml
    from hrd_khs.tseksi ts, 
    hrd_khs.tpribadi tp  where $opt like '$id%' and 
    tp.kodesie=ts.kodesie and keluar = 'f' 
  
    and trim(dept) != '-'
    
    group by d,u,s order by d,u,s";

    return $this->personalia->query($sql)->result_array();
  }



  public function GetJumlahPend($id, $opt)
  {
    $sql = "SELECT  trim(pendidikan)pd, 
    COUNT(case when noind like 'B%' AND jenkel = 'L' THEN 1 END) staffl,
    COUNT(case when noind like 'B%' AND jenkel = 'P' THEN 1 END) staffp,
    COUNT(case when noind like 'A%' AND jenkel = 'L' THEN 1 END) nonstaffl,
    COUNT(case when noind like 'A%' AND jenkel = 'P' THEN 1 END) nonstaffp,
    COUNT(case when jenkel = 'L' AND (noind like 'H%' or noind like 'J%' or noind like 'T%')  THEN 1 END) kontrakl,
    COUNT(case when jenkel = 'P' AND (noind like 'H%' or noind like 'J%' or noind like 'T%') THEN 1 END) kontrakp,
    COUNT(case when (noind like 'D%' or noind like 'E%') AND jenkel = 'L' THEN 1 END) trainl,
    COUNT(case when (noind like 'D%' or noind like 'E%') AND jenkel = 'P' THEN 1 END) trainp,
    COUNT(case when (noind like 'K%'  or noind like 'P%') AND jenkel = 'L' THEN 1 END) outsorcl,
    COUNT(case when (noind like 'K%'  or noind like 'P%') AND jenkel = 'P' THEN 1 END) outsorcp,
    COUNT(case when noind like 'F%' AND jenkel = 'L' THEN 1 END) pkll,
    COUNT(case when noind like 'F%' AND jenkel = 'P' THEN 1 END) pklp,
    COUNT(case when noind like 'Q%' AND jenkel = 'L' THEN 1 END) magangl,
    COUNT(case when noind like 'Q%' AND jenkel = 'P' THEN 1 END) magangp,
    COUNT(case when noind like 'G%' AND jenkel = 'L' THEN 1 END) tkpwl,
    COUNT(case when noind like 'G%' AND jenkel = 'P' THEN 1 END) tkpwp,

    COUNT(case when jenkel = 'L' AND (noind like 'B%' or noind like 'A%' or noind like 'D%' or noind like 'K%' 
    or noind like 'F%' or noind like 'Q%'or noind like 'G%' or noind like 'H%' or noind like 'J%'or noind like 'T%' or noind like 'E%' or noind like 'P%') THEN 1 END) jmll,

    COUNT(case when jenkel = 'P' AND (noind like 'B%' or noind like 'A%' or noind like 'D%' or noind like 'K%' 
    or noind like 'F%' or noind like 'Q%'or noind like 'G%' or noind like 'H%' or noind like 'J%'or noind like 'T%' or noind like 'E%' or noind like 'P%') THEN 1 END) jmlp


    from hrd_khs.tpribadi tp
    where keluar = 'f' and $opt like '$id%'
    group by pd order by pd";


    return $this->personalia->query($sql)->result_array();
  }
}
