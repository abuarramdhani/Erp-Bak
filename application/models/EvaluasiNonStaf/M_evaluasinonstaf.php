<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class M_evaluasinonstaf extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->personalia 	= 	$this->load->database('personalia', TRUE);
  }

  public function getCreatePekerja($noind, $waktu)
  {
    if ($noind == 'P') {
      $param = "(left(ty.noind, 1) = 'P' OR left(ty.noind, 1) = 'K')";
    }else {
      $param = "left(ty.noind, 1) = '$noind'";
    }

    $sql = "SELECT ty.*, tp.nama, cast(ty.tgl_masuk as date) as tgl_masuk
            FROM hrd_khs.tpribadi tp LEFT JOIN \"Surat\".tsurat_penyerahan ty on tp.noind = ty.noind
            WHERE $param AND cast(ty.tgl_masuk as date) >= '$waktu'
            --and ty.noind not in (select te.noind from \"Adm_Seleksi\".tevaluasi_nonstaf te)
            ORDER BY ty.noind";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }

  
  public function getatasan($term)
  {
    $sql = "SELECT * from hrd_khs.tpribadi 
            where noind like '%$term%' or nama like '%$term%' 
            and kd_jabatan in ('1','2','3','4','5','6','7','8','9','10','11','12','13')
            order by noind";
    // echo "<pre>";print_r($sql);exit();
    return $this->personalia->query($sql)->result_array();
  }

  public function getAllData($noind, $param)
  {
    if ($param == true) {
      $noind = "tp.noind in ('$noind')";
    }elseif ($param == false) {
      $noind = "tp.noind = '$noind'";
    }

    $sql = "SELECT tp.*,
            ty.*,
            (SELECT pekerjaan FROM hrd_khs.tpekerjaan tk where tp.kd_pkj = tk.kdpekerjaan) as pekerjaan,
            (SELECT seksi FROM hrd_khs.tseksi ts where tp.kodesie = ts.kodesie) as seksi
            FROM hrd_khs.tpribadi tp
            LEFT JOIN \"Surat\".tsurat_penyerahan ty ON tp.noind = ty.noind
            WHERE $noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function savePekerjaCreate($array)
  {
    $this->personalia->INSERT('"Adm_Seleksi".tevaluasi_nonstaf', $array);
    return;
  }

  public function getDataMonitoringNonStaf()
  {
    return $this->personalia->query("SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi tp where te.noind = tp.noind) as nama, (SELECT tn.fs_ket FROM hrd_khs.tnoind tn WHERE te.jenis = tn.fs_noind) as status, ts.seksi FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
                                      INNER JOIN hrd_khs.tseksi ts ON ts.kodesie = te.kodesie
                                      WHERE jenis = 'H'
                                      ORDER BY te.tgl_masuk DESC, te.noind")->result_array();
  }
  
  public function getDataMonitoringStaf()
  {
    return $this->personalia->query("SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi tp where te.noind = tp.noind) as nama, (SELECT tn.fs_ket FROM hrd_khs.tnoind tn WHERE te.jenis = tn.fs_noind) as status, ts.seksi FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
                                      INNER JOIN hrd_khs.tseksi ts ON ts.kodesie = te.kodesie
                                      WHERE jenis = 'J'
                                      ORDER BY te.tgl_masuk DESC, te.noind")->result_array();
  }

  public function getDataMonitoringTKPW()
  {
    return $this->personalia->query("SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi tp where te.noind = tp.noind) as nama, (SELECT tn.fs_ket FROM hrd_khs.tnoind tn WHERE te.jenis = tn.fs_noind) as status, ts.seksi FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
                                      INNER JOIN hrd_khs.tseksi ts ON ts.kodesie = te.kodesie
                                      WHERE jenis = 'G'
                                      ORDER BY te.tgl_masuk DESC, te.noind")->result_array();
  }

  public function getDataMonitoringcabang()
  {
    return $this->personalia->query("SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi tp where te.noind = tp.noind) as nama, ts.seksi FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
                                      INNER JOIN hrd_khs.tseksi ts ON ts.kodesie = te.kodesie
                                      WHERE jenis = 'C'
                                      ORDER BY te.tgl_masuk DESC, te.noind ")->result_array();
  }

  public function getDataMonitoringospp()
  {
    return $this->personalia->query("SELECT te.*, 
                                      (SELECT nama FROM hrd_khs.tpribadi tp where te.noind = tp.noind) as nama, 
                                      ts.seksi, ty.asal_outsorcing
                                    FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
                                    INNER JOIN hrd_khs.tseksi ts ON ts.kodesie = te.kodesie
                                    LEFT JOIN \"Surat\".tsurat_penyerahan ty on te.noind = ty.noind
                                    WHERE jenis = 'P'
                                    ORDER BY te.tgl_masuk DESC, te.noind")->result_array();
  }

  public function getDataMonitoringkhusus()
  {
    return $this->personalia->query("SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi tp where te.noind = tp.noind) as nama, ts.seksi FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
                                      INNER JOIN hrd_khs.tseksi ts ON ts.kodesie = te.kodesie
                                      WHERE jenis = 'T'
                                      ORDER BY te.tgl_masuk DESC, te.noind")->result_array();
  }

  public function getDataMonitoringpkl()
  {
    return $this->personalia->query("SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi tp where te.noind = tp.noind) as nama, ts.seksi FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
                                      INNER JOIN hrd_khs.tseksi ts ON ts.kodesie = te.kodesie
                                      WHERE jenis = 'F'
                                      ORDER BY te.tgl_masuk DESC, te.noind")->result_array();
  }

  public function updateToday($jenis, $id, $today, $peringatan1, $peringatan2, $peringatan3, $param)
  {
    if ($jenis == 'H' || $jenis == 'C' || $jenis == 'T' || $jenis == 'J'|| $jenis == 'G') {
      $peringatan = "peringatan_1 = '$peringatan1', peringatan_2 = '$peringatan2'";
    }elseif ($jenis == 'P' || $jenis == 'F') {
      $peringatan = "peringatan_1 = '$peringatan3'";
    }

    if ($param == true) {
      $update = "in ('$id')";
    }else {
      $update = "= '$id'";
    }

    $sql = "UPDATE \"Adm_Seleksi\".tevaluasi_nonstaf set terkirim = '$today', $peringatan Where id $update";
    $this->personalia->query($sql);
    return;
  }

  public function updateBlangko($id, $today)
  {
    // if ($param == true) {
    //   $update = "in ('$id')";
    // }else {
    //   $update = "= '$id'";
    // }

    $sql = "UPDATE \"Adm_Seleksi\".tevaluasi_nonstaf set blangko_msk = '$today' Where id = '$id'";
    $this->personalia->query($sql);
    return;
  }
  
  public function update_hubker_seleksi($id, $today)
  {
    $sql = "UPDATE \"Adm_Seleksi\".tevaluasi_nonstaf set hubker_seleksi = '$today' Where id = '$id'";
    $this->personalia->query($sql);
    return;
  }
  
  public function update_nilai_training($id, $nilai, $atasan)
  {
    $sql = "UPDATE \"Adm_Seleksi\".tevaluasi_nonstaf set nilai_training = '$nilai', atasan_trainee = '$atasan' Where id = '$id'";
    $this->personalia->query($sql);
    return;
  }
  
  public function update_lulus_gugur($id, $alasan)
  {
    $sql = "UPDATE \"Adm_Seleksi\".tevaluasi_nonstaf  set alasan_gugur = '$alasan' Where id = '$id'";
    $this->personalia->query($sql);
    return;
  }

  public function getDataID($id, $param)
  {
    if ($param == true) {
      $update = "in ('$id')";
    }else {
      $update = "= '$id'";
    }

    $sql = "SELECT te.*, (select trim(tp.nama) FROM hrd_khs.tpribadi tp where tp.noind = te.noind AND tp.kodesie = te.kodesie) as nama,
            (select coalesce(ts.seksi, ts.unit, ts.bidang, ts.dept) from hrd_khs.tseksi ts where ts.kodesie = te.kodesie) as nama_seksi
            FROM \"Adm_Seleksi\".tevaluasi_nonstaf te WHERE te.id $update";
    return $this->personalia->query($sql)->result_array();
  }

  public function getPekerjaInLokasi($lokasi)
  {
    $today = date('Y-m-d');
    $real = '';
    if ($lokasi == '01' || $lokasi == '02') {
      $real = "AND tp.lokasi_kerja = '$lokasi'";
    }elseif ($lokasi == 'cabang') {
      $real = "AND tp.lokasi_kerja not in ('01', '02')";
    }elseif ($lokasi == 'all') {
      $real = '';
    }

    $sql = "SELECT te.*,trim(tp.nama) as nama, tp.lokasi_kerja, (SELECT am.tempat FROM \"Surat\".tsurat_penyerahan am WHERE te.noind = am.noind) as tempat FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
            INNER JOIN hrd_khs.tpribadi tp on te.noind = tp.noind
            WHERE keluar = '0' AND (te.tgl_krm_blangko <= '$today' OR te.tgl_krm_blangko >= '$today') AND te.terkirim is null AND te.blangko_msk is null $real
            and te.jenis not in ('J', 'G')
            ORDER BY jenis, noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function getPekerjaInLokasiStaf($lokasi)
  {
    $today = date('Y-m-d');
    $real = '';
    if ($lokasi == '01' || $lokasi == '02') {
      $real = "AND tp.lokasi_kerja = '$lokasi'";
    }elseif ($lokasi == 'cabang') {
      $real = "AND tp.lokasi_kerja not in ('01', '02')";
    }elseif ($lokasi == 'all') {
      $real = '';
    }

    $sql = "SELECT te.*,trim(tp.nama) as nama, tp.lokasi_kerja, (SELECT am.tempat FROM \"Surat\".tsurat_penyerahan am WHERE te.noind = am.noind) as tempat FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
            INNER JOIN hrd_khs.tpribadi tp on te.noind = tp.noind
            WHERE keluar = '0' AND (te.tgl_krm_blangko <= '$today' OR te.tgl_krm_blangko >= '$today') AND te.terkirim is null AND te.blangko_msk is null $real
            and te.jenis in ('J', 'G')
            ORDER BY jenis, noind";
    return $this->personalia->query($sql)->result_array();
  }

  public function blangko_not_send()
  {
      $today = date('Y-m-d');
      $sql = "SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi WHERE tpribadi.noind = te.noind) as nama FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
              WHERE te.terkirim is null AND te.tgl_krm_blangko <= '$today'
              and te.jenis not in ('J', 'G')
              ORDER BY te.tgl_krm_blangko, te.noind";
      return $this->personalia->query($sql)->result_array();
  }
  
  public function blangko_not_send_staf()
  {
      $today = date('Y-m-d');
      $sql = "SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi WHERE tpribadi.noind = te.noind) as nama FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
              WHERE te.terkirim is null AND te.tgl_krm_blangko <= '$today'
              and te.jenis in ('J', 'G')
              ORDER BY te.tgl_krm_blangko, te.noind";
      return $this->personalia->query($sql)->result_array();
  }

  public function AllData_notif()
  {
      $today = date('Y-m-d');
      $sql = "SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi WHERE tpribadi.noind = te.noind) as nama FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
              WHERE te.terkirim is not null and te.peringatan_1 <= '$today' AND te.peringatan_2 > '$today' and te.blangko_msk is null
              and te.jenis not in ('J', 'G')
              ORDER BY te.tgl_krm_blangko, te.noind";
      return $this->personalia->query($sql)->result_array();
  }
  
  public function AllData_notif_staf()
  {
      $today = date('Y-m-d');
      $sql = "SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi WHERE tpribadi.noind = te.noind) as nama FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
              WHERE te.terkirim is not null and te.peringatan_1 <= '$today' AND te.peringatan_2 > '$today' and te.blangko_msk is null
              and te.jenis in ('J', 'G')
              ORDER BY te.tgl_krm_blangko, te.noind";
      return $this->personalia->query($sql)->result_array();
  }

  public function AllData_flag()
  {
      $today = date('Y-m-d');
      $sql = "SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi WHERE tpribadi.noind = te.noind) as nama FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
              WHERE te.terkirim is not null and te.peringatan_2 <= '$today' AND te.blangko_msk is null
              and te.jenis not in ('J', 'G')
              ORDER BY te.tgl_krm_blangko, te.noind";
      return $this->personalia->query($sql)->result_array();
  }

  public function AllData_flag_staf()
  {
      $today = date('Y-m-d');
      $sql = "SELECT te.*, (SELECT nama FROM hrd_khs.tpribadi WHERE tpribadi.noind = te.noind) as nama FROM \"Adm_Seleksi\".tevaluasi_nonstaf te
              WHERE te.terkirim is not null and te.peringatan_2 <= '$today' AND te.blangko_msk is null
              and te.jenis in ('J', 'G')
              ORDER BY te.tgl_krm_blangko, te.noind";
      return $this->personalia->query($sql)->result_array();
  }
}


 ?>
