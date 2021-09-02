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
class M_deklarasisehat extends CI_Model
{
  protected $table_tpribadi = 'hrd_khs.tpribadi';
  protected $table_seksi = 'hrd_khs.tseksi';
  protected $table_organisasi = 'hrd_khs.torganisasi';

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

  public function masterdeklarasisehat($data)
  {
    $tanggal_awal = $data['tanggal_awal'];
    $tanggal_akhir = $data['tanggal_akhir'];
    $tanggal_awal	= str_replace('/', '-', $tanggal_awal);
    $tanggal_akhir	= str_replace('/', '-', $tanggal_akhir);
    $tanggal_awal= date('Y-m-d',strtotime($tanggal_awal));
    $tanggal_akhir= date('Y-m-d 23:59:00',strtotime($tanggal_akhir));

    $kodesie = $data['kodesie'];
    $noind = $data['noind'];
    $pertanyaan = $data['pertanyaan'];

    if (!empty($noind)) {
      $w_noind = "and noind = '$noind'";
    }else {
      $w_noind = "";
    }

    if (!empty($kodesie)) {
      $w_kodesie = "and noind in (select noind from hrd_khs.tpribadi where kodesie like '$kodesie%' and keluar = 'f')";
    }else {
      $w_kodesie = "";
    }

    if (!empty($pertanyaan[0])) {
      $w_pertanyaan = '';
      foreach ($pertanyaan as $key => $value) {
        $w_pertanyaan .= "and ($value is null or $value = 'f') ";
      }
    }else {
      $w_pertanyaan = '';
    }

    return $this->personalia->query("select a.*, (select distinct c.seksi
                                     from hrd_khs.tpribadi b
                                     left join hrd_khs.tseksi c on b.kodesie = c.kodesie
                                     where a.noind = b.noind
                                     and c.seksi is not null
                                     and substr(c.seksi,1,1) not in ('*','-')) seksi,
                                     (select distinct nama
                                      from hrd_khs.tpribadi b where a.noind = b.noind) nama
                                     from hrd_khs.deklarasi_sehat a
                                     where waktu_input
                                     between '$tanggal_awal' and '$tanggal_akhir'
                                     $w_noind $w_kodesie $w_pertanyaan")->result_array();
  }

  public function getPernyataanDeklarasi($value='')
  {
    return $this->personalia->order_by('aspek', 'asc')->get('hrd_khs.deklarasi_sehat_pertanyaan')->result_array();
  }

  public function getSeksi($value='')
  {
    return $this->personalia->query("select distinct b.seksi, substring(b.kodesie, 1, 7) kodesie
    from hrd_khs.tpribadi a
    left join hrd_khs.tseksi b on a.kodesie = b.kodesie
    where b.seksi is not null
    and substr(b.seksi,1,1) not in ('*','-')
    and b.seksi like '%$value%'")->result_array();
  }

  public function employee($data, $kodesie)
  {
      $sql = "select noind, nama from hrd_khs.tpribadi where kodesie like '$kodesie%' and keluar = 'f'
              and (noind like '%$data%'
              or nama like '%$data%')
            order by 1";
      $response = $this->personalia->query($sql)->result_array();
      return $response;
  }
}
