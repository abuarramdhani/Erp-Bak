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
 * Model untuk aplikasi master pekerja->kesepakatan kerja
 */
class M_kesepakatankerja extends CI_Model
{
  protected $table_kesepakatan = 'hrd_khs.tkesepakatan_kerja';
  protected $table_perjanjian_kerja = 'hrd_khs.tperjanjian_kerja';
  protected $table_tpribadi = 'hrd_khs.tpribadi';
  protected $table_seksi = 'hrd_khs.tseksi';
  protected $table_pekerjaan = 'hrd_khs.tpekerjaan';

  public function __construct()
  {
    parent::__construct();

    $this->db = $this->load->database('default');
    $this->personalia = $this->load->database('personalia', true);
  }

  /**
   * Get pekerja
   * 
   * @param String $noind
   * @param String $field { string of column }
   * 
   * @return Object of worker information
   */
  public function getPribadi($noind, $field = false)
  {
    return $this->personalia
      ->select($field ?: '*')
      ->from($this->table_tpribadi . " tp")
      ->join($this->table_seksi . " ts", 'ts.kodesie = tp.kodesie')
      ->where('noind', $noind)
      ->limit(1)
      ->get()
      ->row();
  }

  /**
   * Get all kesepakatan kerja on
   * @param Int $month
   * @param Int $year
   * @param String $keyword { nama / noind }
   * @return Array<Array> Array of Kesepkatan Kerja
   */
  public function getKesepakatanKerja($month, $year, $keyword = false)
  {
    $param = "$year-$month";

    $query = $this->personalia
      ->select("
        tkk.id_kk,
        tkk.noind,
        trim(tp.nama) nama,
        ts.seksi,
        ts.dept,
        to_char(tkk.tgldiangkat, 'YYYY-MM-DD') tgldiangkat,
        to_char(tkk.tglevaluasi, 'YYYY-MM-DD') tglevaluasi,
        to_char(tkk.tglpemanggilan, 'YYYY-MM-DD') tglpemanggilan,
        to_char(tkk.tgltandatangan, 'YYYY-MM-DD') tgltandatangan,
        trim(tkk.keterangan) keterangan,
        tkk.user_ user,
        tp.keluar
      ")
      ->from($this->table_kesepakatan . ' tkk')
      ->join($this->table_tpribadi . ' tp', 'tp.noind = tkk.noind')
      ->join($this->table_seksi . ' ts', 'ts.kodesie = tp.kodesie')
      ->where("to_char(tgldiangkat, 'YYYY-MM') = ", $param)
      ->order_by('tgldiangkat', 'ASC')
      ->order_by('id_kk', 'ASC');

    // if with keyword
    if ($keyword) {
      $keyword = strtoupper($keyword);
      $query
        ->group_start()
        ->like('tp.nama', $keyword, 'both')
        ->or_like('tkk.noind', $keyword, 'both')
        ->group_end();
    }

    return $query->get()->result_array();
  }

  /**
   * Update Kesepakatan kerja by noind
   * @param String $id_kk
   * @param Array $data
   */
  public function updateKesepakatanKerja($id_kk, $data)
  {
    return $this->personalia
      ->where('id_kk', $id_kk)
      ->update($this->table_kesepakatan, $data);
  }

  /**
   * Get Perjanjian
   * @param String $oker
   * @param Boolean $sub
   * @return Array List of perjanjian kerja
   */
  public function getPerjanjianKerja($loker, $sub = false)
  {
    $query = $this->personalia
      ->from($this->table_perjanjian_kerja)
      ->order_by('kd_baris', 'ASC')
      // ->where_in('lokasi', ['0', (string)$loker]),@deprecated , thus not used
      ->where('kd_baris <>', '0000');

    if ($sub) {
      $query->where('sub', '-');
    }

    return $query
      ->get()
      ->result_array();
  }

  /**
   * @param Array of template
   * @return Boolean of status
   */
  public function updateTemplatePerjanjianKerja($template)
  {
    $delete = $this->personalia->where_not_in('kd_baris', ['0000'])->delete($this->table_perjanjian_kerja);
    $insert = $this->personalia->insert_batch($this->table_perjanjian_kerja, $template);

    return $delete && $insert;
  }

  /**
   * Get upah
   * @param Void
   * @return Array { Of upah }
   */
  public function getUpah()
  {
    return $this->personalia
      ->select('isi, align')
      ->from($this->table_perjanjian_kerja)
      ->where('kd_baris', '0000')
      ->get()->result_array();
  }

  /**
   * Get list of signer (penanda tangan)
   * 
   * @param String $keyword
   * @return Array noind, nama, jabatan, kd_jabatan
   */
  public function getSigner($keyword)
  {
    $query = $this->personalia
      ->select('noind, trim(nama) nama, jabatan, kd_jabatan')
      ->from($this->table_tpribadi)
      ->where('keluar', '0')
      ->where('kd_jabatan <=', '10')
      ->where('kd_jabatan >', '01')
      ->where_not_in('kd_jabatan', ['-'])
      ->order_by('kd_jabatan', 'asc')
      ->order_by('noind', 'asc');

    if ($keyword) {
      $query
        ->group_start()
        ->like('noind', strtoupper($keyword), 'both')
        ->or_like('nama', strtoupper($keyword), 'both')
        ->group_end();
    }

    return $query
      ->get()
      ->result_array();
  }

  /**
   * set salary on diffent work place
   * 
   * @param string $work_place
   * @param string $salary
   * 
   * @return boolean
   */
  public function update_salary($work_place, $salary)
  {
    return (bool)$this->personalia
      ->where('align', $work_place)
      ->update($this->table_perjanjian_kerja, ['isi' => $salary]);
  }

  /**
   * get Job desk by kodesie/noind
   * 
   * @param string $kodesie 
   * @param string $noind
   * @return Array of job desk
   */
  public function get_job_desk($kd_pkj = false, $noind = false)
  {
    if ($noind) {
      $kd_pkj = $this->personalia
        ->select('kd_pkj')
        ->where('noind', $noind)
        ->from($this->table_tpribadi)
        ->get()
        ->row()
        ->kd_pkj;
    }

    $query = $this->personalia
      ->select('kdpekerjaan, pekerjaan')
      ->from($this->table_pekerjaan);


    if ($kd_pkj) {
      $query->like('kdpekerjaan', substr($kd_pkj, 0, 8), 'after');
    }

    return $query->get()->result_array();
  }
}
