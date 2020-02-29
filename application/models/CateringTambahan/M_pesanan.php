<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pesanan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function editTotalPesanan($array_total,$ru_where)
    {
        $this->personalia->where($ru_where);
        $this->personalia->update('"Catering".tpesanan_erp',$array_total);
        return;
    }

    public function ambilPenambahan($ru_where)
    {
        $this->personalia->where($ru_where);
        return $this->personalia->get('"Catering".tpesanan_tambah_kurang')->result_array();
    }

    public function ambilPesananHariIni($ru_where)
    {
        $this->personalia->where($ru_where);
        return $this->personalia->get('"Catering".tpesanan_erp')->result_array();
    }

    public function ambilTambahanKatering($today)
    {
        $sql = "select * from \"Catering\".tpesanan_tambah_kurang where tgl_pesanan='$today'";
        return $this->personalia->query($sql)->result_array();
    }

    public function simpanTambahanKatering($array)
    {
        $this->personalia->insert('"Catering".tpesanan_tambah_kurang',$array);
        return;
    }

    public function ambilTempatMakan($p)
    {
        $sql = "select fs_tempat_makan as nama from \"Catering\".ttempat_makan where fs_tempat_makan like '%$p%'";
        return $this->personalia->query($sql)->result_array();
    }

    public function ambiltberkas()
    {
      $sql = "SELECT DISTINCT kodelamaran,nama
              FROM \"Adm_Seleksi\".tberkas
              WHERE status NOT IN ('TL','G','M') AND kodelamaran::int > '96420'
              ORDER BY kodelamaran";
      return $this->personalia->query($sql)->result_array();
    }

    public function ambilnoind()
    {
      $sql = "SELECT DISTINCT noind,nama
              FROM hrd_khs.tpribadi tp
              WHERE tp.keluar = '0' AND tp.lokasi_kerja in ('01','02','03')
              ORDER BY noind";
      return $this->personalia->query($sql)->result_array();
    }

    public function getkasie()
    {
      $sql = "SELECT concat(tp.noind,' - ', tp.nama) nama
              FROM hrd_khs.tpribadi tp
              WHERE tp.keluar = '0' AND noind = 'J1350' LIMIT 1";
      return $this->personalia->query($sql)->row()->nama;
    }

    public function insertapprove($array)
    {
      $this->personalia->insert('"Catering".tapprove_tambah_makan',$array);
      return;
    }

    public function insertapprovedatang($array1, $array2)
    {
      $this->personalia->insert('"Catering".tapprove_tambah_makan',$array1);
      $this->personalia->insert('"Catering".tapprove_tambah_makan',$array2);
      return;
    }

    public function getNama($noind)
    {
      $sql = "SELECT nama FROM hrd_khs.tpribadi WHERE noind = '$noind' AND keluar='0'";
      return $this->personalia->query($sql)->row()->nama;
    }

    public function getSieEmail($noind)
    {
      $sql = "SELECT ts.seksi FROM hrd_khs.tseksi ts
                INNER JOIN hrd_khs.tpribadi tp on tp.kodesie = ts.kodesie
              WHERE tp.noind= '$noind' AND tp.keluar = '0'";
      return $this->personalia->query($sql)->row()->seksi;
    }

    public function getInMail($user)
    {
        $sql = "SELECT trim(email_internal) as email_internal FROM hrd_khs.tpribadi where noind = 'J1350' limit 1";
        return $this->personalia->query($sql)->row()->email_internal;
    }

    //-----Model Utama untuk List data---------//
    public function DataList($noind)
    {
      $sql = "SELECT *, cast(tgl_pesanan as date) tanggal FROM \"Catering\".tapprove_tambah_makan where user_='$noind'";
      return $this->personalia->query($sql)->result_array();
    }

    public function getPemesan()
    {
      $sql = "SELECT tp.noind, tp.nama, ts.seksi
              FROM hrd_khs.tpribadi tp INNER JOIN hrd_khs.tseksi ts on ts.kodesie=tp.kodesie
              INNER JOIN \"Catering\".tapprove_tambah_makan ta on ta.user_=tp.noind
              WHERE keluar = '0'";
      return $this->personalia->query($sql)->result_array();
    }

    public function getSeksiHeader($noind)
    {
      return $this->personalia->query("SELECT ts.seksi FROM hrd_khs.tseksi ts INNER JOIN hrd_khs.tpribadi tp ON tp.kodesie = ts.kodesie WHERE tp.noind = '$noind'")->row()->seksi;
    }

    public function ambildetail1($id)
    {
      $sql = "SELECT *,
              (SELECT concat_ws(' - ',tp.noind, tp.nama)
              FROM hrd_khs.tpribadi tp WHERE tp.noind=ta.user_) nama1,
              (SELECT tp.kodesie
              FROM hrd_khs.tpribadi tp WHERE tp.noind=ta.user_) kodesie
              FROM \"Catering\".tapprove_tambah_makan ta where id = '$id'";
      return $this->personalia->query($sql)->result_array();
    }

    public function getSeksi1($kodesie)
    {
      return $this->personalia->query("SELECT seksi FROM hrd_khs.tseksi WHERE kodesie = '$kodesie'")->row()->seksi;
    }

    public function getNamaa($params, $ket)
    {
      if($params == true){
        $noind = "in('$ket')";
      }else{
        $noind = "='$ket'";
      }
      $sql = "SELECT concat_ws(' - ', noind, nama) as nama from hrd_khs.tpribadi where noind $noind";
      // print_r($sql);exit();
      return $this->personalia->query($sql)->result_array();
    }

    public function getTempatMakanTpribadi($params, $in)
    {
      $today = date('Y-m-d');
      if($params == true){
        $noind = "in($in)";
      }else{
        $noind = "='$in'";
      }
      $sql = "SELECT distinct tp.noind, tp.tempat_makan, tp.lokasi_kerja, ts.kd_shift
              FROM hrd_khs.tpribadi tp INNER JOIN \"Presensi\".tshiftpekerja ts ON ts.noind = tp.noind
              WHERE tp.noind $noind AND keluar='0' AND tanggal = '$today'
              GROUP BY tp.noind, tp.tempat_makan, tp.lokasi_kerja, ts.kd_shift
              order by tempat_makan, lokasi_kerja, kd_shift";
      $data = $this->personalia->query($sql)->result_array();

      $k = 0;
      for ($i=0; $i < count($data) ; $i++) {
        if($i-1 < 0){
          $j = 1;
        }else{
          $j = $i;
        }

        if(($data[$i]['tempat_makan'] == $data[$j-1]['tempat_makan']) && ($data[$i]['lokasi_kerja'] == $data[$j-1]['lokasi_kerja']) && ($data[$i]['kd_shift'] == $data[$j-1]['kd_shift'])){
          $newdata[$k][] = $data[$i];
        }else{
          $k++;
          $newdata[$k][] = $data[$i];
        }
      }
      return $newdata;
    }


    public function getValidasiNoind($noind,  $tmp_makan_tpribadi2)
    {
      $today = date('Y-m-d');

      $sql = "SELECT noind, tempat_makan FROM
                 (SELECT tpres.noind AS noind,
                     hrd_khs.tpribadi.tempat_makan AS tempat_makan,
                     COUNT(hrd_khs.tpribadi.tempat_makan) AS jumlah_karyawan
                 FROM hrd_khs.tpribadi
                 INNER JOIN \"Catering\".tpresensi tpres ON tpres.noind = hrd_khs.tpribadi.noind
                     AND LEFT(tpres.waktu, 5) >= '03:59:59'
                     AND LEFT(tpres.waktu, 5) <= '08:30:00'
                     AND tpres.tanggal = '$today'
               INNER JOIN \"Catering\".ttempat_makan tmkn on hrd_khs.tpribadi.tempat_makan = tmkn.fs_tempat_makan and tmkn.fs_lokasi in ('1','3')
                     WHERE tpres.noind NOT IN
                         (SELECT fs_noind
                         FROM \"Catering\".tpuasa
                         WHERE fd_tanggal = '$today'
                         AND fb_status = '1')
                     AND tpres.noind NOT IN
                         (SELECT noind
                         FROM \"Presensi\".tshiftpekerja
                         WHERE tanggal IN ('$today'::date -interval '1 day', '$today') AND kd_shift IN ('3', '12'))
                     AND LEFT(tpres.noind, 1) NOT IN ('M', 'Z')
                     GROUP BY hrd_khs.tpribadi.tempat_makan, tpres.noind
                     union select a.noind,a.tempat_makan,COUNT(a.tempat_makan) AS jumlah_karyawan
                  FROM hrd_khs.tpribadi a inner join \"Presensi\".tshiftpekerja b on a.noind=b.noind
                 INNER JOIN \"Catering\".ttempat_makan tmkn on a.tempat_makan = tmkn.fs_tempat_makan and tmkn.fs_lokasi in ('1','3')
                 left join \"Catering\".tpuasa p on b.tanggal=p.fd_tanggal and b.noind=p.fs_noind
                 where b.tanggal = '$today' and b.kd_shift in('5','8','18')
                 and (p.fb_status is null or p.fb_status<>'1') GROUP BY a.tempat_makan, a.nama,a.noind,b.jam_msk ) DERIVEDTBL
                where noind = '$noind' and tempat_makan = '$tmp_makan_tpribadi2'
                GROUP BY tempat_makan, DERIVEDTBL, noind
                ORDER BY tempat_makan, noind";
      return $this->personalia->query($sql)->result_array();
    }

    public function getValidasiNoindShift2($noind,  $tmp_makan_tpribadi2)
    {
      $today = date('Y-m-d');

      $sql = "SELECT noind, tempat_makan
              FROM
              (SELECT tpres.noind AS noind, hrd_khs.tpribadi.tempat_makan AS tempat_makan, COUNT(hrd_khs.tpribadi.tempat_makan) AS jumlah_karyawan
              FROM hrd_khs.tpribadi INNER JOIN \"Catering\".tpresensi tpres ON tpres.noind = hrd_khs.tpribadi.noind AND LEFT(tpres.waktu, 5) >= '11:00:00' AND LEFT(tpres.waktu, 5) <= '14:15:00' AND tpres.tanggal = '$today'
              INNER JOIN \"Catering\".ttempat_makan tmkn on hrd_khs.tpribadi.tempat_makan = tmkn.fs_tempat_makan and tmkn.fs_lokasi in ('1','3')
              WHERE tpres.noind NOT IN
                    (SELECT noind FROM \"Catering\".tpresensi
                      WHERE LEFT(waktu, 5) >= '03:59:59'  AND LEFT(waktu, 5) <= '08:30:00'  AND tanggal = '$today' AND noind NOT IN (
                            SELECT noind FROM (SELECT t.noind, COUNT(t.noind) AS jml
                                  FROM \"Catering\".tpresensi t, \"Presensi\".tshiftpekerja s
                                  WHERE t.tanggal in ('$today'::date -interval '1 day', '$today') AND t.waktu < '23:00:00' AND t.waktu > '20:30:00' AND s.kd_shift IN ('3', '12') AND t.noind = s.noind
                                  GROUP BY t.noind) DERIVEDTBL
                                  WHERE jml = '1' AND noind NOT IN
                                  (SELECT noind FROM \"Catering\".tpresensi
                                    WHERE waktu <= '20:30:00' AND waktu >= '11:00:00' AND tanggal = '$today')
                                  ) union select noind from \"Presensi\".tshiftpekerja where kd_shift in('5','8','18') and tanggal='$today'
                                )
                                AND LEFT(tpres.noind, 1) NOT IN ('M', 'Z')
                                GROUP BY hrd_khs.tpribadi.tempat_makan, tpres.noind) DERIVEDTBL
              WHERE noind = '$noind' and tempat_makan = '$tmp_makan_tpribadi2'
              GROUP BY tempat_makan, noind ,DERIVEDTBL
              ORDER BY tempat_makan";
      return $this->personalia->query($sql)->result_array();
    }

    public function getValidasiNoindShift3($noind,  $tmp_makan_tpribadi2)
    {
      $today = date('Y-m-d');

      $sql = "SELECT hrd_khs.tpribadi.tempat_makan AS tempat_makan, hrd_khs.tpribadi.noind as noind
              FROM \"Presensi\".tshiftPekerja, hrd_khs.tpribadi
               INNER JOIN \"Catering\".ttempat_makan tmkn on hrd_khs.tpribadi.tempat_makan = tmkn.fs_tempat_makan and tmkn.fs_lokasi in ('1','3')
               WHERE \"Presensi\".tshiftPekerja.noind = hrd_khs.tpribadi.noind
                AND tanggal = '$today'
                AND kd_shift IN ('3', '12')
                AND LEFT(hrd_khs.tPribadi.noind, 1) NOT IN ('M', 'Z')
                AND hrd_khs.tpribadi.noind ='$noind'
                AND tempat_makan = '$tmp_makan_tpribadi2'
               GROUP BY tempat_makan, hrd_khs.tpribadi.noind
              ORDER BY tempat_makan";
      return $this->personalia->query($sql)->result_array();
    }
}
