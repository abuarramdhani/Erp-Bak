<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class M_lelayu extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->personalia = $this->load->database('personalia',TRUE);
  }

//---------------------Model Utama Untuk Tambah Data------------------------//
  public function getData()
  {
    $sql = "SELECT * FROM hr.hr_uang_duka_perusahaan";
    return $this->db->query($sql);
  }

  public function getPekerja()
  {
    $sql = "SELECT noind, nama FROM hrd_khs.tpribadi WHERE keluar = '0' AND (noind like 'A%' OR noind like 'B%')
            ORDER BY noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getCutoffBulanIni(){
    $sql = "select tanggal_awal::date from \"Presensi\".tcutoff where to_char(tanggal_akhir,'yyyy-mm') = to_char(current_date,'yyyy-mm') limit 1";
    if(isset($this->personalia->query($sql)->row()->tanggal_awal)){
      return  $this->personalia->query($sql)->row()->tanggal_awal;
    }else{
      return date('Y-m-21');      
    }
  }

  public function getSPSI($bulancutoff, $tanggalcutoff, $bulanlalu)
  {
    $selectcutoff = $this->personalia->query('SELECT tanggal_awal::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_awal;
    $cutoff_akhir = $this->personalia->query('SELECT tanggal_akhir::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_akhir;
    if ($tanggalcutoff >= 21) {
      if ($bulancutoff == $selectcutoff) {
        $trigerbulan = "'$bulancutoff'";
      }else {
        return "alert";
      }
    }elseif ($tanggalcutoff <= 20) {
      if ($bulanlalu == $selectcutoff) {
        $trigerbulan = "'$bulanlalu'";
      }else {
        return "alert";
      }
    }
    if(!isset($alert)){
      $sql1 = "SELECT count(noind) as noind FROM (
                select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
                b.dept, b.bidang, b.unit
                from hrd_khs.tpribadi a
                left join hrd_khs.tseksi b on
                  a.kodesie = b.kodesie
                left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
                left join hrd_khs.torganisasi c on
                  tref.kd_jabatan = c.kd_jabatan
                left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
                where keluar = '0'--(( and masukkerja <= cast($trigerbulan as date)))
                  and a.kode_status_kerja <> 'C'
                  and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
                -- union
                -- select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
                -- b.dept, b.bidang, b.unit
                -- from hrd_khs.tpribadi a
                -- left join hrd_khs.tseksi b on a.kodesie = b.kodesie
                -- left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
                -- left join hrd_khs.torganisasi c on tref.kd_jabatan = c.kd_jabatan
                -- left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
                -- where ((masukkerja <= cast($trigerbulan as date))
                --   and (tglkeluar >= cast($trigerbulan as date)
                --   and keluar = '1'))
                --   and (masukkerja >= '1945-01-01')
                --   and a.kode_status_kerja <> 'C'
                --   and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
                -- order by 5
              ) as tabel
              where left(noind,1) in ('A','B') and (kd_jabatan BETWEEN '01' AND '09')";
              // echo $sql1;exit();
      return $this->personalia->query($sql1)->row()->noind;
    }
  }

  public function getNominal()
  {
    $sql2 = "SELECT nominal FROM hr.hr_uang_duka_spsi WHERE jabatan BETWEEN '1' AND '9' LIMIT 1";
    return $this->db->query($sql2)->row()->nominal;
  }

  public function getSPSI1($bulancutoff, $tanggalcutoff, $bulanlalu)
  {
    $selectcutoff = $this->personalia->query('SELECT tanggal_awal::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_awal;
    $cutoff_akhir = $this->personalia->query('SELECT tanggal_akhir::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_akhir;
    if ($tanggalcutoff >= 21) {
      if ($bulancutoff == $selectcutoff) {
        $trigerbulan = "'$bulancutoff'";
      }else {
        return "alert";
      }
    }elseif ($tanggalcutoff <= 20) {
      if ($bulanlalu == $selectcutoff) {
        $trigerbulan = "'$bulanlalu'";
      }else {
        return "alert";
      }
    }
    if(!isset($alert)){
    $sql1 = "SELECT count(noind) as noind FROM (
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on
                a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on
                tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where keluar = '0'--(( and masukkerja <= cast($trigerbulan as date)))
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              -- union
              -- select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              -- b.dept, b.bidang, b.unit
              -- from hrd_khs.tpribadi a
              -- left join hrd_khs.tseksi b on a.kodesie = b.kodesie
              -- left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              -- left join hrd_khs.torganisasi c on tref.kd_jabatan = c.kd_jabatan
              -- left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              -- where ((masukkerja <= cast($trigerbulan as date))
              --   and (tglkeluar >= cast($trigerbulan as date)
              --   and keluar = '1'))
              --   and (masukkerja >= '1945-01-01')
              --   and a.kode_status_kerja <> 'C'
              --   and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              -- order by 5
            ) as tabel
            where left(noind,1) in ('A','B') and (kd_jabatan BETWEEN '10' AND '11')";
    return $this->personalia->query($sql1)->row()->noind;
    }
  }

  public function getNominal1()
  {
    $sql2 = "SELECT nominal FROM hr.hr_uang_duka_spsi WHERE jabatan BETWEEN '10' AND '11' LIMIT 1";
    return $this->db->query($sql2)->row()->nominal;
  }

  public function getSPSI2($bulancutoff, $tanggalcutoff, $bulanlalu)
  {
    $selectcutoff = $this->personalia->query('SELECT tanggal_awal::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_awal;
    $cutoff_akhir = $this->personalia->query('SELECT tanggal_akhir::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_akhir;
    if ($tanggalcutoff >= 21) {
      if ($bulancutoff == $selectcutoff) {
        $trigerbulan = "'$bulancutoff'";
      }else {
        return "alert";
      }
    }elseif ($tanggalcutoff <= 20) {
      if ($bulanlalu == $selectcutoff) {
        $trigerbulan = "'$bulanlalu'";
      }else {
        return "alert";
      }
    }
    if(!isset($alert)){
    $sql1 = "SELECT count(noind) as noind FROM (
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on
                a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on
                tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where keluar = '0'--(( and masukkerja <= cast($trigerbulan as date)))
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              -- union
              -- select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              -- b.dept, b.bidang, b.unit
              -- from hrd_khs.tpribadi a
              -- left join hrd_khs.tseksi b on a.kodesie = b.kodesie
              -- left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              -- left join hrd_khs.torganisasi c on tref.kd_jabatan = c.kd_jabatan
              -- left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              -- where ((masukkerja <= cast($trigerbulan as date))
              --   and (tglkeluar >= cast($trigerbulan as date)
              --   and keluar = '1'))
              --   and (masukkerja >= '1945-01-01')
              --   and a.kode_status_kerja <> 'C'
              --   and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              -- order by 5
            ) as tabel
            where left(noind,1) in ('A','B') and (kd_jabatan BETWEEN '12' AND '13')";
    return $this->personalia->query($sql1)->row()->noind;
    }
  }

  public function getNominal2()
  {
    $sql2 = "SELECT nominal FROM hr.hr_uang_duka_spsi WHERE jabatan BETWEEN '12' AND '13' LIMIT 1";
    return $this->db->query($sql2)->row()->nominal;
  }

  public function getSPSI3($bulancutoff, $tanggalcutoff, $bulanlalu)
  {
    $selectcutoff = $this->personalia->query('SELECT tanggal_awal::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_awal;
    $cutoff_akhir = $this->personalia->query('SELECT tanggal_akhir::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_akhir;
    if ($tanggalcutoff >= 21) {
      if ($bulancutoff == $selectcutoff) {
        $trigerbulan = "'$bulancutoff'";
      }else {
        return "alert";
      }
    }elseif ($tanggalcutoff <= 20) {
      if ($bulanlalu == $selectcutoff) {
        $trigerbulan = "'$bulanlalu'";
      }else {
        return "alert";
      }
    }
    if(!isset($alert)){
    $sql1 = "SELECT count(noind) as noind FROM (
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on
                a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on
                tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where keluar = '0'--(( and masukkerja <= cast($trigerbulan as date)))
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              -- union
              -- select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              -- b.dept, b.bidang, b.unit
              -- from hrd_khs.tpribadi a
              -- left join hrd_khs.tseksi b on a.kodesie = b.kodesie
              -- left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              -- left join hrd_khs.torganisasi c on tref.kd_jabatan = c.kd_jabatan
              -- left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              -- where ((masukkerja <= cast($trigerbulan as date))
              --   and (tglkeluar >= cast($trigerbulan as date)
              --   and keluar = '1'))
              --   and (masukkerja >= '1945-01-01')
              --   and a.kode_status_kerja <> 'C'
              --   and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              -- order by 5
            ) as tabel
            where left(noind,1) in ('A','B') and (kd_jabatan BETWEEN '14' AND '15')";
    return $this->personalia->query($sql1)->row()->noind;
    }
  }

  public function getNominal3()
  {
    $sql2 = "SELECT nominal FROM hr.hr_uang_duka_spsi WHERE jabatan BETWEEN '14' AND '15' LIMIT 1";
    return $this->db->query($sql2)->row()->nominal;
  }

  public function getNoindAll($bulancutoff, $tanggalcutoff, $bulanlalu)
  {
    $selectcutoff = $this->personalia->query('SELECT tanggal_awal::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_awal;
    $cutoff_akhir = $this->personalia->query('SELECT tanggal_akhir::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_akhir;
    if ($tanggalcutoff >= 21) {
      if ($bulancutoff == $selectcutoff) {
        $trigerbulan = "'$bulancutoff'";
      }else {
        return "alert";
      }
    }elseif ($tanggalcutoff <= 20) {
      if ($bulanlalu == $selectcutoff) {
        $trigerbulan = "'$bulanlalu'";
      }else {
        return "alert";
      }
    }
    if(!isset($alert)){
    $sql = "SELECT distinct noind
            FROM (
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on
                a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on
                tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where ((keluar = '0' and masukkerja <= cast($trigerbulan as date)))
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              union
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where ((masukkerja <= cast($trigerbulan as date))
                and (tglkeluar >= cast($trigerbulan as date)
                and keluar = '1'))
                and (masukkerja >= '1945-01-01')
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              order by 5
            ) as tabel
						where left(noind,1) in ('A','B') and (kd_jabatan BETWEEN '01' AND '09') order by noind";
    return $this->personalia->query($sql)->result_array();
    }
  }

  public function getNoindAll1($bulancutoff, $tanggalcutoff, $bulanlalu)
  {
    $selectcutoff = $this->personalia->query('SELECT tanggal_awal::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_awal;
    $cutoff_akhir = $this->personalia->query('SELECT tanggal_akhir::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_akhir;
    if ($tanggalcutoff >= 21) {
      if ($bulancutoff == $selectcutoff) {
        $trigerbulan = "'$bulancutoff'";
      }else {
        return "alert";
      }
    }elseif ($tanggalcutoff <= 20) {
      if ($bulanlalu == $selectcutoff) {
        $trigerbulan = "'$bulanlalu'";
      }else {
        return "alert";
      }
    }
    if(!isset($alert)){
    $sql = "SELECT distinct noind
            FROM (
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on
                a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on
                tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where ((keluar = '0' and masukkerja <= cast($trigerbulan as date)))
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              union
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where ((masukkerja <= cast($trigerbulan as date))
                and (tglkeluar >= cast($trigerbulan as date)
                and keluar = '1'))
                and (masukkerja >= '1945-01-01')
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              order by 5
            ) as tabel
						where left(noind,1) in ('A','B') and (kd_jabatan BETWEEN '10' AND '11') order by noind";
    return $this->personalia->query($sql)->result_array();
    }
  }

  public function getNoindAll2($bulancutoff, $tanggalcutoff, $bulanlalu)
  {
    $selectcutoff = $this->personalia->query('SELECT tanggal_awal::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_awal;
    $cutoff_akhir = $this->personalia->query('SELECT tanggal_akhir::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_akhir;
    if ($tanggalcutoff >= 21) {
      if ($bulancutoff == $selectcutoff) {
        $trigerbulan = "'$bulancutoff'";
      }else {
        return "alert";
      }
    }elseif ($tanggalcutoff <= 20) {
      if ($bulanlalu == $selectcutoff) {
        $trigerbulan = "'$bulanlalu'";
      }else {
        return "alert";
      }
    }
    if(!isset($alert)){
    $sql = "SELECT distinct noind
            FROM (
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on
                a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on
                tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where ((keluar = '0' and masukkerja <= cast($trigerbulan as date)))
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              union
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where ((masukkerja <= cast($trigerbulan as date))
                and (tglkeluar >= cast($trigerbulan as date)
                and keluar = '1'))
                and (masukkerja >= '1945-01-01')
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              order by 5
            ) as tabel
						where left(noind,1) in ('A','B') and (kd_jabatan BETWEEN '12' AND '13') order by noind";
    return $this->personalia->query($sql)->result_array();
    }
  }

  public function getNoindAll3($bulancutoff, $tanggalcutoff, $bulanlalu)
  {
    $selectcutoff = $this->personalia->query('SELECT tanggal_awal::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_awal;
    $cutoff_akhir = $this->personalia->query('SELECT tanggal_akhir::date from "Presensi".tcutoff order by id_cutoff desc limit 1')->row()->tanggal_akhir;
    if ($tanggalcutoff >= 21) {
      if ($bulancutoff == $selectcutoff) {
        $trigerbulan = "'$bulancutoff'";
      }else {
        return "alert";
      }
    }elseif ($tanggalcutoff <= 20) {
      if ($bulanlalu == $selectcutoff) {
        $trigerbulan = "'$bulanlalu'";
      }else {
        return "alert";
      }
    }
    if(!isset($alert)){
    $sql = "SELECT distinct noind
            FROM (
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on
                a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on
                tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where ((keluar = '0' and masukkerja <= cast($trigerbulan as date)))
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              union
              select a.noind, nik, a.nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar,
              b.dept, b.bidang, b.unit
              from hrd_khs.tpribadi a
              left join hrd_khs.tseksi b on a.kodesie = b.kodesie
              left join hrd_khs.trefjabatan tref on tref.noind = a.noind and tref.kodesie = a.kodesie
              left join hrd_khs.torganisasi c on tref.kd_jabatan = c.kd_jabatan
              left join \"Surat\".tsurat_pengangkatan d on a.noind = d.nomor_induk_baru
              where ((masukkerja <= cast($trigerbulan as date))
                and (tglkeluar >= cast($trigerbulan as date)
                and keluar = '1'))
                and (masukkerja >= '1945-01-01')
                and a.kode_status_kerja <> 'C'
                and left(a.noind, 1) not in('L', 'Z', 'M') and (d.tanggal_cetak::date not between '$selectcutoff' and '$cutoff_akhir' or d.tanggal_cetak::date is null)
              order by 5
            ) as tabel
						where left(noind,1) in ('A','B') and (kd_jabatan BETWEEN '14' AND '15') order by noind";
    return $this->personalia->query($sql)->result_array();
    }
  }

  public function insertAll($array)
  {
    $this->db->insert("hr.hr_lelayu",$array);
    return;
  }

  public function getID()
  {
    return $this->db->query("SELECT max(lelayu_id) new FROM hr.hr_lelayu")->row()->new;
  }

  public function insertID($array1)
  {
    $this->db->query("insert into hr.hr_pekerja_dipotong(lelayu_id,noind,nominal)
                      values(".$array1['lelayu_id'].",'".$array1['noind']."',".$array1['nominal'].")");
    return;
  }

//--------------------Model Utama Untuk List Data----------------------//
  public function getDataList()
  {
    return $this->db->query("SELECT * from hr.hr_lelayu order by tgl_lelayu desc")->result_array();
  }

  public function getDataPDF($id)
  {
    $sql = "SELECT *, (select employee_name from er.er_employee_all where employee_code = tong.noind ) as nama,
              (select sex from er.er_employee_all where employee_code = tong.noind ) as jk,
              (select section_name from er.er_section b inner join er.er_employee_all a on a.section_code = b.section_code where a.employee_code = tong.noind) as seksi, (
              select
                location_code
              from
                er.er_employee_all
              where
                employee_code = tong.noind ) as lokasi_kerja,
                (
              select
                section_code
              from
                er.er_employee_all
              where
                employee_code = tong.noind ) as kodesie,
                (
              select
                oracle_cost_code
              from
                er.er_section es
                left join er.er_employee_all eea on eea.section_code = es.section_code
              where
                eea.employee_code = tong.noind ) as cost_code
            from hr.hr_lelayu tong
            WHERE lelayu_id = '$id'";
    return $this->db->query($sql)->result_array();
  }

  public function delete($id)
  {
    $sql = "delete from hr.hr_lelayu where lelayu_id = '$id'";
    $this->db->query($sql);
  }

  public function deletePekerjaPotong($id)
  {
    $sql = "delete from hr.hr_pekerja_dipotong where lelayu_id = '$id'";
    $this->db->query($sql);
  }

  public function getDetailList($id)
  {
    $sql = "SELECT *, coalesce(kain_kafan_perusahaan,0) + coalesce(uang_duka_perusahaan,0) as perusahaan,
            coalesce(spsi_askanit_nominal,0) + coalesce(spsi_kasie_nominal,0) + coalesce(spsi_spv_nominal,0) + coalesce(spsi_nonmanajerial_nominal,0) as spsi,
              (select employee_name from er.er_employee_all where employee_code = lel.noind ) as nama FROM hr.hr_lelayu lel WHERE lelayu_id = '$id'";
    return $this->db->query($sql)->result_array();
  }

  public function getDataListExcel()
  {
    $sql = "SELECT *, coalesce(kain_kafan_perusahaan,0) + coalesce(uang_duka_perusahaan,0) as perusahaan,
            coalesce(spsi_askanit_nominal,0) + coalesce(spsi_kasie_nominal,0) + coalesce(spsi_spv_nominal,0) + coalesce(spsi_nonmanajerial_nominal,0) as spsi,
              (select employee_name from er.er_employee_all where employee_code = lel.noind ) as nama FROM hr.hr_lelayu lel";
    return $this->db->query($sql)->result_array();
  }

  public function getPekerjaTerpotong($id)
  {
    $selectNom = $this->db->query("select distinct nominal from hr.hr_pekerja_dipotong where lelayu_id = '$id'")->result_array();
    sort($selectNom);
    $newArr = array();
    foreach ($selectNom as $key) {
      $nominal = $key['nominal'];
      $pg = "SELECT *, (select employee_name from er.er_employee_all where employee_code = tong.noind ) as nama from hr.hr_pekerja_dipotong tong WHERE lelayu_id = '$id' and nominal = '$nominal'";
      $pg = $this->db->query($pg)->result_array();

      for ($i=0; $i < count($pg) ; $i++) {
        array_push($newArr, $pg[$i]);
      }
    }
    return $newArr;
  }

  public function namaUser($noind)
  {
    $sql = "SELECT employee_name from er.er_employee_all where employee_code = '$noind'";
    return $this->db->query($sql)->row()->employee_name;
  }

  public function getAtasan()
  {
    $sql = "SELECT nama, jabatan from hrd_khs.tpribadi where kodesie in ('401010000')";
    return $this->personalia->query($sql)->result_array();
  }

  public function getTertandaKasbon()
  {
    $sql = "SELECT noind, nama FROM hrd_khs.tpribadi WHERE keluar = '0' ORDER BY noind";
    return $this->personalia->query($sql)->result_array();
  }



//-------------Model Utama Untuk Setup Duka Perusahaan---------------//

  public function getDukaPerusahaan()
  {
    return $this->db->query("SELECT * FROM hr.hr_uang_duka_perusahaan")->result_array();
  }

//-------------Model Utama Untuk Setup Duka SPSI---------------//

  public function getDukaSPSI()
  {
    return $this->db->query("SELECT * FROM hr.hr_uang_duka_spsi")->result_array();
  }

  public function getCutoffBulanLalu(){
    $sql = "select tanggal_awal::date from \"Presensi\".tcutoff where to_char(tanggal_awal,'yyyy-mm') = to_char(current_date - interval '1 month','yyyy-mm') limit 1";
    return  $this->personalia->query($sql)->row()->tanggal_awal;
  }

  public function getPkjByLoc($lokasi = false, $id)
  {
    if ($lokasi == '02') {//AC
      $sqlTambahan = "ee.location_code in ('02')";
    }elseif ($lokasi == '04') {//AB
      $sqlTambahan = "(ee.location_code in ('04')
                      or ee.section_code in (
                      select
                        section_code
                      from
                        er.er_section
                      where
                        section_name like '%YOGYAKARTA%'
                        or (unit_name like '%YOGYAKARTA%'
                        and section_name = '-') ))";
    }else{//AA
      $sqlTambahan = "(ee.location_code not in ('04', '02') 
                      and ee.section_code not in (
                      select
                        section_code
                      from
                        er.er_section
                      where
                        section_name like '%YOGYAKARTA%'
                        or (unit_name like '%YOGYAKARTA%'
                        and section_name = '-') ) or ee.location_code is null)";
    }

    $sql = "select
              sum(nominal)
            from
              (
              select
                hpd.noind,
                hpd.nominal,
                ee.location_code
              from
                hr.hr_pekerja_dipotong hpd
              left join er.er_employee_all ee on
                ee.employee_code = hpd.noind
              where
                lelayu_id = $id
                and $sqlTambahan ) jumlah;";
    return  $this->db->query($sql)->row()->sum;
  }

  public function getRekapData($awal, $akhir)
  {
    $hosP = $this->personalia->hostname;
    $dbP = $this->personalia->database;
    $usrP = $this->personalia->username;
    $pasP = $this->personalia->password;
    $sql = "select
              hpd.noind,
              hrd.nama,
              hrd.jabatan,
              sum(hpd.nominal)
            from
              hr.hr_lelayu hl
            left join hr.hr_pekerja_dipotong hpd on
              hpd.lelayu_id = hl.lelayu_id
            left join er.er_employee_all eea on
              eea.employee_code = hpd.noind
            left join (
              select
                *
              from
                dblink('host=$hosP user=$usrP password=$pasP dbname=$dbP',
                'select tp.noind, tp.nama, tor.jabatan from hrd_khs.tpribadi tp
            left join hrd_khs.torganisasi tor on tor.kd_jabatan = tp.kd_jabatan') as tb2(noind text,
                nama text, jabatan text) ) hrd on
              hrd.noind = hpd.noind
            where
              tgl_lelayu between '$awal' and '$akhir'
            group by
              hpd.noind,
              hpd.nominal,
              hrd.nama,
              hrd.jabatan;
            order by hpd.noind";
              // echo $sql;exit();
    return  $this->db->query($sql)->result_array();
  }

  public function getKsYogya()
  {
    $sql = "select section_code from er.er_section where section_name like '%YOGYAKARTA%' 
            or (unit_name like '%YOGYAKARTA%' and section_name='-');";
    return  $this->db->query($sql)->result_array();
  }

}

 ?>
