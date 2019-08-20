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
      $sql = "SELECT tp.noind, tp.nama
              FROM hrd_khs.tpribadi tp
              WHERE tp.keluar = '0' AND tp.kodesie in ('401010200') AND kd_jabatan IN ('11') AND noind = 'J1256'";
      return $this->personalia->query($sql)->result_array();
    }

    public function insertapprove($array)
    {
      $this->personalia->insert('"Catering".tapprove_tambahan',$array);
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


}

/* End of file M_printpp.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_printpp.php */
/* Generated automatically on 2017-09-23 07:56:39 */
