<?php
defined("BASEPATH") or die("This script cannot access directly");

setlocale(LC_ALL, 'id_ID.utf8');
date_default_timezone_set('Asia/Jakarta');

/**
 * Ez debugging
 */
if (!function_exists('debug')) {
  function debug($arr)
  {
    echo "<pre>";
    print_r($arr);
    die;
  }
}

/**
 * @author /DK/
 * Model untuk aplikasi master pekerja->pencarian kerja
 * CI Builder Style
 */
class M_pencarianpekerja extends CI_Model
{
  protected $table_tpribadi = 'hrd_khs.tpribadi';
  protected $table_seksi = 'hrd_khs.tseksi';
  protected $table_organisasi = 'hrd_khs.torganisasi';
  /**
   * Tabel BPJS Kesehatan
   */
  protected $table_bpjskes = 'hrd_khs.tbpjskes';
  /**
   * Tabel BPJS Ketenaga Kerjaan
   */
  protected $table_bpjstk = 'hrd_khs.tbpjstk';
  /**
   * Tabel BPJS Ketenaga Kerjaan
   */
  protected $table_lokasikerja = 'hrd_khs.tlokasi_kerja';

  public function __construct()
  {
    parent::__construct();

    $this->db = $this->load->database('default');
    $this->personalia = $this->load->database('personalia', true);
  }

  /**
   * Find Worker
   * 
   * @param String $param
   * @param String $param_type { string, date, number, boolean }
   * @param String $keyword
   * @param String $out { Worker is out ? }
   * @param Integer $limit { With data limit ? }
   * @return Array of Data
   */
  public function findWorker($param, $param_type, $keyword, $out = false, $limit = false)
  {
    // validation param column
    $param = $param == 'noind' ? 'tp.noind' : $param;
    $param = $param == 'alamat' ? 'tp.alamat' : $param;
    //

    $out = in_array($out, ['t', 'f']) ? $out : false;

    $query = $this->personalia
      ->select("
        trim(tp.noind) noind,
        trim(tp.nama) nama,
        ts.seksi,
        ts.unit,
        to_char(tp.masukkerja, 'DD-MM-YYYY') masukkerja,
        to_char(tp.diangkat, 'DD-MM-YYYY') diangkat,
        to_char(tp.akhkontrak, 'DD-MM-YYYY') akhkontrak,
        to_char(tp.tglkeluar, 'DD-MM-YYYY') tglkeluar,
        trim(tp.templahir) templahir,
        to_char(tp.tgllahir, 'DD-MM-YYYY') tgllahir,
        trim(tp.alamat) alamat,
        trim(tp.desa) desa,
        trim(tp.kec) kecamatan,
        trim(tp.kab) kabupaten,
        trim(tp.prop) provinsi,
        tp.kodepos,
        tp.nohp,
        tp.telepon,
        tp.nik,
        tp.no_kk,
        jskes.no_peserta no_jskes,
        (
          case 
            when tf.namafaskes is not null then tf.namafaskes
            else jskes.bpu
          end
        ) bpu,
        trim(jskt.no_peserta) no_jskt,
        trim(tp.email) email,
        tp.sebabklr,
        lk.lokasi_kerja
      ")
      ->from($this->table_tpribadi . " tp")
      ->join($this->table_seksi . " ts", 'ts.kodesie = tp.kodesie', 'left')
      ->join($this->table_bpjskes . " jskes", 'jskes.noind = tp.noind', 'left')
      ->join($this->table_bpjstk . " jskt", 'jskt.noind = tp.noind', 'left')
      ->join($this->table_lokasikerja . " lk", 'lk.id_ = tp.lokasi_kerja', 'left')
      ->join("hrd_khs.tfaskes tf", 'tf.kd_faskes = jskes.bpu', 'left outer')
      ->order_by('noind', 'asc');

    // matching data type condition
    if ($param_type === 'string') {
      $query->like("LOWER($param)", strtolower($keyword), 'both');
    } elseif ($param_type === 'date') {
      // dd/mm/yyyy -dd/mm-yyyy
      $splitKeyword = explode('-', $keyword);

      if ($splitKeyword > 1) {
        $from = DateTime::createFromFormat('d/m/Y', trim($splitKeyword[0]))->format('Y-m-d');
        $to = DateTime::createFromFormat('d/m/Y', trim($splitKeyword[1]))->format('Y-m-d');
        if (!$from || !$to) return ['not exist'];

        $query->where("to_char($param, 'YYYY-MM-DD') >=", $from);
        $query->where("to_char($param, 'YYYY-MM-DD') <=", $to);
      } else {
        $query->like("to_char($param, 'YYYY-MM-DD')", strtolower($keyword), 'both');
      }
    }

    if ($out) {
      $query->where('keluar', $out);
    }

    if ($limit) {
      $query->limit($limit);
    }

    return $query
      ->get()
      ->result_array();
  }

  /**
   * Get worker with position(Jabatan -_)
   * 
   * @param String $active
   * @param String $keyword
   * @param Integer $limit
   */
  public function findWorkerPosition($keyword, $out = false, $limit = false)
  {
    $out = in_array($out, ['t', 'f']) ? $out : false;

    $query = $this->personalia
      ->select("
        trim(tp.noind) noind,
        trim(tp.nama) nama,
        trim(ts.seksi) seksi,
        trim(ts.unit) unit,
        trim(ts.bidang) bidang,
        trim(ts.dept) dept,
        to_char(tp.masukkerja, 'YYYY-MM-DD') masukkerja,
        trim(tor.jabatan) jabatan
      ")
      ->from($this->table_tpribadi . " tp")
      ->join($this->table_seksi . " ts", 'ts.kodesie = tp.kodesie')
      ->join($this->table_organisasi . " tor", "tor.kd_jabatan = tp.kd_jabatan")
      ->like('LOWER(tor.jabatan)', strtolower($keyword), 'both');

    if ($out) {
      $query->where('tp.keluar', $out);
    }

    if ($limit > 0) {
      $query->limit($limit);
    }

    return $query->get()->result_array();
  }
}
