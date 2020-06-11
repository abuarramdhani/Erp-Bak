<?php 
Defined('BASEPATH') or exit('No direct Script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_HitungPesanan extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->library('form_validation');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('CateringManagement/HitungPesanan/M_hitungpesanan');
  }

  public function checkSession()
  {
    if($this->session->is_logged){

    } else {
      redirect('index');
    }
  }

  function getFinger(){
    $user_id = $this->session->userid;
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');

    $finger = $this->M_hitungpesanan->getFinger($user_id);
    $html = "";
    foreach ($finger as $fi) {
      $html .= "<a class='btn btn-primary' href='finspot:FingerspotVer;".base64_encode(site_url('CateringManagement/HitungPesanan/fp_process?userid='.$user_id.'&finger_id='.$fi['id_finger'].'&tanggal='.$tanggal.'&shift='.$shift.'&lokasi='.$lokasi))."'>".$fi['jari']."</a>";
    }
    echo $html;
  }

  function fp_process(){
    $time_limit_ver = "10";
    $user_id = $this->input->get('userid');
    $kd_finger = $this->input->get('finger_id');
    $finger = $this->M_hitungpesanan->show_finger_user(array('user_id' => $user_id, 'kd_finger' => $kd_finger));

    $tanggal = $this->input->get('tanggal');
    $shift = $this->input->get('shift');
    $lokasi = $this->input->get('lokasi');
    echo "$user_id;".$finger->finger_data.";SecurityKey;".$time_limit_ver.";".site_url("CateringManagement/HitungPesanan/fp_verification?finger_id=".$kd_finger.'&tanggal='.$tanggal.'&shift='.$shift.'&lokasi='.$lokasi).";".site_url("CateringManagement/HitungPesanan/fp_activation").";extraParams";
    // variabel yang di tmpilkan belum bisa di ubah
  }

  function fp_activation(){
    $filter = array("Verification_Code" => $_GET['vc']);
    $data = $this->M_hitungpesanan->show_finger_activation($filter);
    echo $data->Activation_Code.$data->SN;
  }

  function fp_verification(){
    $data = explode(";",$_POST['VerPas']);
    $user_id = $data[0];
    $vStamp = $data[1];
    $time = $data[2];
    $sn = $data[3];

    $filter   = array("SN" => $sn);
    $kd_finger = $this->input->get('finger_id');
    $fingerData = $this->M_hitungpesanan->show_finger_user(array('user_id' => $user_id,'kd_finger' => $kd_finger));
    $device   = $this->M_hitungpesanan->show_finger_activation($filter);

    $salt = md5($sn.$fingerData->finger_data.$device->Verification_Code.$time.$user_id.$device->VKEY);

    if (strtoupper($vStamp) == strtoupper($salt)) {
      $tanggal = $this->input->get('tanggal');
      $shift = $this->input->get('shift');
      $lokasi = $this->input->get('lokasi');
      echo site_url("CateringManagement/HitungPesanan/fp_succes?finger_id=".$kd_finger.'&tanggal='.$tanggal.'&shift='.$shift.'&lokasi='.$lokasi);
    }else{
      echo site_url("CateringManagement/HitungPesanan/fp_fail?msg=".$vStamp."&msg2=".$salt);
    }
  }

  function fp_succes(){
    $this->checkSession();
    $nama = $this->session->employee;
    $jari = $this->input->get('finger_id');
    $this->session->spl_validasi_jari = $jari;
    $finger = $this->M_hitungpesanan->getFingerName($jari);
    if ($this->session->sex == 'L') {
      $yth = "Bpk.";
    }else{
      $yth = "Ibu";
    }
    $tanggal = $this->input->get('tanggal');
    $shift = $this->input->get('shift');
    $lokasi = $this->input->get('lokasi');

    echo "Selamat $yth $nama, anda telah terverifikasi menggunakan $finger Anda.<br>
    Silahkan kembali ke halaman sebelumnya<br>
    <script type='text/javascript'>
      localStorage.setItem('refreshCatering',1);
      localStorage.setItem('refreshCateringTanggal','$tanggal');
      localStorage.setItem('refreshCateringShift','$shift');
      localStorage.setItem('refreshCateringLokasi','$lokasi');
      window.close();
    </script>
    ";
    
  }

  function fp_fail(){
    $msg = $this->input->get('msg');
    $msg2 = $this->input->get('msg2');
    echo "User Gagal Terverifikasi<br>$msg<br>$msg2<br>
    <script type='text/javascript'>
      localStorage.setItem('refreshCatering',2);
      window.close();
    </script>";
  }

  public function index(){
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Title'] = 'Hitung Pesanan';
    $data['Menu'] = 'Hitung Pesanan';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('CateringManagement/HitungPesanan/V_index.php',$data);
    $this->load->view('V_Footer',$data);
  }

  public function cekPesanan(){
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');
    $data = array();

    $dataPesanan = $this->M_hitungpesanan->getPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    if (!empty($dataPesanan)) {
      $data['JumlahPesanan'] = count($dataPesanan);
      $data['statusPesanan'] = 'ada';
    }else{
      $data['JumlahPesanan'] = 0;
      $data['statusPesanan'] = 'tidak ada';
    }

    $dataKatering = $this->M_hitungpesanan->getKateringByLokasi($lokasi);
    if (!empty($dataKatering)) {
      $data['jumlahKatering'] = count($dataKatering);
      $data['statusKatering'] = 'ada';
    }else{
      $data['jumlahKatering'] = 0;
      $data['statusKatering'] = 'tidak ada';
    }

    $dataJadwal = $this->M_hitungpesanan->getJadwalByTanggalLokasi($tanggal,$lokasi);
    if (!empty($dataJadwal)) {
      $data['jumlahJadwal'] = count($dataJadwal);
      $data['statusJadwal'] = 'ada';
    }else{
      $data['jumlahJadwal'] = 0;
      $data['statusJadwal'] = 'tidak ada';
    }

    $dataBatasDatang = $this->M_hitungpesanan->getBatasDatangByTanggalShift($tanggal,$shift);
    if (!empty($dataBatasDatang)) {
      $data['jumlahBatasDatang'] = count($dataBatasDatang);
      $data['statusBatasDatang'] = 'ada';
    }else{
      $data['jumlahBatasDatang'] = 0;
      $data['statusBatasDatang'] = 'tidak ada';
    }

    if ($shift == '1') {
      $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasi($tanggal,$lokasi);
    }elseif($shift == '2'){
      $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftDuaByTanggalLokasi($tanggal,$lokasi);
    }elseif ($shift == '3') {
      $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftTigaByTanggalLokasi($tanggal,$lokasi);
    }
    if (!empty($dataAbsenShift)) {
      $data['jumlahAbsenShift'] = count($dataAbsenShift);
      $data['statusAbsenShift'] = 'ada';
    }else{
      $data['jumlahAbsenShift'] = 0;
      $data['statusAbsenShift'] = 'tidak ada';
    }

    echo json_encode($data);
  }

  public function prosesHitung(){
    // $tanggal = $this->input->get('tanggal');
    // $shift = $this->input->get('shift');
    // $lokasi = $this->input->get('lokasi'); 
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');

    $this->M_hitungpesanan->deletePesananByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    $this->M_hitungpesanan->deleteUrutanKateringByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    if($shift == '1' or $shift == '2'){
      $this->M_hitungpesanan->UpdateWaktuHitungByShift($shift,'0');
    }

    if ($shift == '1') {
      $this->hitungShift1($tanggal,$shift,$lokasi);
    }elseif($shift == '2'){
      $this->hitungShift2($tanggal,$shift,$lokasi);
    }elseif ($shift == '3') {
      $this->hitungShift3($tanggal,$shift,$lokasi);
    }

    if($shift == '1' or $shift == '2'){
      $this->M_hitungpesanan->UpdateWaktuHitungByShift($shift,'1');      
    }

    $data_log = array(
      'wkt' => date('Y-m-d H:i:s'),
      'menu' => 'HITUNG PESANAN',
      'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi,
      'noind' => $this->session->user,
      'jenis' => 'HITUNG DATA PESANAN',
      'program' => 'CATERING MANAGEMENT ERP'
    );
    $this->M_hitungpesanan->insertTlog($data_log);
  }

  public function hitungShift1($tanggal,$shift,$lokasi){
    $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasi($tanggal,$lokasi);
    // echo "<pre>";print_r($dataAbsenShift);exit();
    $data = array();
    foreach ($dataAbsenShift as $pesanan) {
      $jumlahPesananAwal = $pesanan['jumlah'];
      $tempatMakan = $pesanan['tempat_makan'];
      $pesananStaff = $this->M_hitungpesanan->getAbsenShiftSatuStaffByTanggalLokasiTempatMakan($tanggal,$lokasi,$tempatMakan);
      if (!empty($pesananStaff)) {
        $jumlahPesananStaff = $pesananStaff['0']['jumlah'];
        $jumlahPesananNonStaff = $jumlahPesananAwal - $jumlahPesananStaff;
      }else{
        $jumlahPesananStaff = 0;
        $jumlahPesananNonStaff = $jumlahPesananAwal;
      }

      // Insert Rencana Lembur
      $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftSatuByTanggalTempatMakan($tanggal,$tempatMakan);
      if (!empty($rencanaLembur)) {
        foreach ($rencanaLembur as $rl) {
          $noind = $rl['noind'];
          $cekPresensi = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind);
          if (empty($cekPresensi)) {
            $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
            if (!empty($cekPesananTambahanLembur)) {
              $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
              $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
              if (empty($cekPesananTambahanLemburDetail)) {
                $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
              }
            }else{
              $this->M_hitungpesanan->insertPesananTambahanRencanaLembur($tanggal,$tempatMakan,$shift);
              $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
              if (!empty($cekPesananTambahanLembur)) {
                $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
                $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
                if (empty($cekPesananTambahanLemburDetail)) {
                  $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
                }
              }
            }
          }
        }
        $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
      }

      // Pesanan Tambahan
      $pesananTambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananTambahan)) {
        $jumlahPesananTambahan = $pesananTambahan['0']['jumlah'];
      }else{
        $jumlahPesananTambahan = 0;
      }

      // Pesanan Pengurangan
      $pesananPengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananPengurangan)) {
        $jumlahPesananPengurangan = $pesananPengurangan['0']['jumlah'];
      }else{
        $jumlahPesananPengurangan = 0;
      }

      // Pesanan Total 
      $jumlahPesananTotal = ($jumlahPesananStaff + $jumlahPesananNonStaff + $jumlahPesananTambahan) - $jumlahPesananPengurangan;

      $this->M_hitungpesanan->deletePesananByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);

      $dataInsert = array(
        'fd_tanggal'          => $tanggal,
        'fs_tempat_makan'     => $tempatMakan,
        'fs_kd_shift'         => $shift,
        'fn_jumlah_staff'     => $jumlahPesananStaff,
        'fn_jumlah_nonstaff'  => $jumlahPesananNonStaff,
        'fn_jumlah'           => $jumlahPesananAwal,
        'fn_jumlah_tambahan'    => $jumlahPesananTambahan,
        'fn_jumlah_pengurangan' => $jumlahPesananPengurangan,
        'fn_jumlah_pesan'     => $jumlahPesananTotal,
        'fs_tanda'            => '0',
        'lokasi'              => $lokasi
      );
      $this->M_hitungpesanan->insertPesananCatering($dataInsert);
    }

    // Rencana lembur yang belum ada absen di tempat makan
    $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftSatuNonAbsensiByTanggalLokasi($tanggal,$lokasi);
    if (!empty($rencanaLembur)) {
      foreach ($rencanaLembur as $rl) {
        $noind = $rl['noind'];
        $cekPresensi = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind);
        if (empty($cekPresensi)) {
          $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
          if (!empty($cekPesananTambahanLembur)) {
            $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
            $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
            if (empty($cekPesananTambahanLemburDetail)) {
              $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
            }
          }else{
            $this->M_hitungpesanan->insertPesananTambahanRencanaLembur($tanggal,$tempatMakan,$shift);
            $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
            if (!empty($cekPesananTambahanLembur)) {
              $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
              $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
              if (empty($cekPesananTambahanLemburDetail)) {
                $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
              }
            }
          }
        }
      }
      $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
    }

    // Pesanan Tambahan Yang Tidak ada Absennya 
    $pesananTambahanNonAbsensi = $this->M_hitungpesanan->getPesananTambahanNonAbsensiByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    foreach ($pesananTambahanNonAbsensi as $tambahan) {
      $jumlahPesananAwal = 0;
      $tempatMakan = $tambahan['tempat_makan'];
      $jumlahPesananStaff = 0;
      $jumlahPesananTambahan = $tambahan['jumlah'];

       // Pesanan Pengurangan
      $pesananPengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananPengurangan)) {
        $jumlahPesananPengurangan = $pesananPengurangan['0']['jumlah'];
      }else{
        $jumlahPesananPengurangan = 0;
      }

      // Pesanan Total 
      $jumlahPesananTotal = ($jumlahPesananStaff + $jumlahPesananNonStaff + $jumlahPesananTambahan) - $jumlahPesananPengurangan;

      $dataInsert = array(
        'fd_tanggal'          => $tanggal,
        'fs_tempat_makan'     => $tempatMakan,
        'fs_kd_shift'         => $shift,
        'fn_jumlah_staff'     => $jumlahPesananStaff,
        'fn_jumlah_nonstaff'  => $jumlahPesananNonStaff,
        'fn_jumlah'           => $jumlahPesananAwal,
        'fn_jumlah_tambahan'    => $jumlahPesananTambahan,
        'fn_jumlah_pengurangan' => $jumlahPesananPengurangan,
        'fn_jumlah_pesan'     => $jumlahPesananTotal,
        'fs_tanda'            => '0',
        'lokasi'              => $lokasi
      );
      $this->M_hitungpesanan->insertPesananCatering($dataInsert);
    }

  }

  public function hitungShift2($tanggal,$shift,$lokasi){
    $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftDuaByTanggalLokasi($tanggal,$lokasi);
     // echo "<pre>";print_r($dataAbsenShift);exit();
    $data = array();
    foreach ($dataAbsenShift as $pesanan) {
      $jumlahPesananAwal = $pesanan['jumlah'];
      $tempatMakan = $pesanan['tempat_makan'];
      $pesananStaff = $this->M_hitungpesanan->getAbsenShiftDuaStaffByTanggalLokasiTempatMakan($tanggal,$lokasi,$tempatMakan);
      $pesananTambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      
      if (!empty($pesananStaff)) {
        $jumlahPesananStaff = $pesananStaff['0']['jumlah'];
        $jumlahPesananNonStaff = $jumlahPesananAwal - $jumlahPesananStaff;
      }else{
        $jumlahPesananStaff = 0;
        $jumlahPesananNonStaff = $jumlahPesananAwal;
      }

      // Insert Rencana Lembur
      $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftDuaByTanggalTempatMakan($tanggal,$tempatMakan);
      if (!empty($rencanaLembur)) {
        foreach ($rencanaLembur as $rl) {
          $noind = $rl['noind'];
          $cekPresensi = $this->M_hitungpesanan->getAbsenShiftDuaByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind);
          if (empty($cekPresensi)) {
            $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
            if (!empty($cekPesananTambahanLembur)) {
              $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
              $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
              if (empty($cekPesananTambahanLemburDetail)) {
                $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
              }
            }else{
              $this->M_hitungpesanan->insertPesananTambahanRencanaLembur($tanggal,$tempatMakan,$shift);
              $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
              if (!empty($cekPesananTambahanLembur)) {
                $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
                $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
                if (empty($cekPesananTambahanLemburDetail)) {
                  $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
                }
              }
            }
          }
        }
        $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
      }

      // Pesanan Tambahan
      $pesananTambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananTambahan)) {
        $jumlahPesananTambahan = $pesananTambahan['0']['jumlah'];
      }else{
        $jumlahPesananTambahan = 0;
      }

      // Pesanan Pengurangan
      $pesananPengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananPengurangan)) {
        $jumlahPesananPengurangan = $pesananPengurangan['0']['jumlah'];
      }else{
        $jumlahPesananPengurangan = 0;
      }

      // Pesanan Total 
      $jumlahPesananTotal = ($jumlahPesananStaff + $jumlahPesananNonStaff + $jumlahPesananTambahan) - $jumlahPesananPengurangan;

      $this->M_hitungpesanan->deletePesananByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);

      $dataInsert = array(
        'fd_tanggal'          => $tanggal,
        'fs_tempat_makan'     => $tempatMakan,
        'fs_kd_shift'         => $shift,
        'fn_jumlah_staff'     => $jumlahPesananStaff,
        'fn_jumlah_nonstaff'  => $jumlahPesananNonStaff,
        'fn_jumlah'           => $jumlahPesananAwal,
        'fn_jumlah_tambahan'    => $jumlahPesananTambahan,
        'fn_jumlah_pengurangan' => $jumlahPesananPengurangan,
        'fn_jumlah_pesan'     => $jumlahPesananTotal,
        'fs_tanda'            => '0',
        'lokasi'              => $lokasi
      );
      $this->M_hitungpesanan->insertPesananCatering($dataInsert);
    }


    // Rencana lembur yang belum ada absen di tempat makan
    $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftDuaNonAbsensiByTanggalLokasi($tanggal,$lokasi);
    if (!empty($rencanaLembur)) {
      foreach ($rencanaLembur as $rl) {
        $noind = $rl['noind'];
        $cekPresensi = $this->M_hitungpesanan->getAbsenShiftDuaByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind);
        if (empty($cekPresensi)) {
          $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
          if (!empty($cekPesananTambahanLembur)) {
            $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
            $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
            if (empty($cekPesananTambahanLemburDetail)) {
              $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
            }
          }else{
            $this->M_hitungpesanan->insertPesananTambahanRencanaLembur($tanggal,$tempatMakan,$shift);
            $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
            if (!empty($cekPesananTambahanLembur)) {
              $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
              $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
              if (empty($cekPesananTambahanLemburDetail)) {
                $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
              }
            }
          }
        }
      }
      $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
    }

     // Pesanan Tambahan Yang Tidak ada Absennya 
    $pesananTambahanNonAbsensi = $this->M_hitungpesanan->getPesananTambahanNonAbsensiByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    foreach ($pesananTambahanNonAbsensi as $tambahan) {
      $jumlahPesananAwal = 0;
      $tempatMakan = $tambahan['tempat_makan'];
      $jumlahPesananStaff = 0;
      $jumlahPesananTambahan = $tambahan['jumlah'];

       // Pesanan Pengurangan
      $pesananPengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananPengurangan)) {
        $jumlahPesananPengurangan = $pesananPengurangan['0']['jumlah'];
      }else{
        $jumlahPesananPengurangan = 0;
      }

      // Pesanan Total 
      $jumlahPesananTotal = ($jumlahPesananStaff + $jumlahPesananNonStaff + $jumlahPesananTambahan) - $jumlahPesananPengurangan;

      $dataInsert = array(
        'fd_tanggal'            => $tanggal,
        'fs_tempat_makan'       => $tempatMakan,
        'fs_kd_shift'           => $shift,
        'fn_jumlah_staff'       => $jumlahPesananStaff,
        'fn_jumlah_nonstaff'    => $jumlahPesananNonStaff,
        'fn_jumlah'             => $jumlahPesananAwal,
        'fn_jumlah_pesan'       => $jumlahPesananTotal,
        'fn_jumlah_tambahan'    => $jumlahPesananTambahan,
        'fn_jumlah_pengurangan' => $jumlahPesananPengurangan,
        'fs_tanda'              => '0',
        'lokasi'                => $lokasi
      );
      $this->M_hitungpesanan->insertPesananCatering($dataInsert);
    }
  }

  public function hitungShift3($tanggal,$shift,$lokasi){
    $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftTigaByTanggalLokasi($tanggal,$lokasi);
     // echo "<pre>";print_r($dataAbsenShift);exit();
    $data = array();
    foreach ($dataAbsenShift as $pesanan) {
      $jumlahPesananAwal = $pesanan['jumlah'];
      $tempatMakan = $pesanan['tempat_makan'];
      $pesananStaff = $this->M_hitungpesanan->getAbsenShiftTigaStaffByTanggalLokasiTempatMakan($tanggal,$lokasi,$tempatMakan);
      $pesananTambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      
      if (!empty($pesananStaff)) {
        $jumlahPesananStaff = $pesananStaff['0']['jumlah'];
        $jumlahPesananNonStaff = $jumlahPesananAwal - $jumlahPesananStaff;
      }else{
        $jumlahPesananStaff = 0;
        $jumlahPesananNonStaff = $jumlahPesananAwal;
      }

      // Insert Rencana Lembur
      $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftTigaByTanggalTempatMakan($tanggal,$tempatMakan);
      if (!empty($rencanaLembur)) {
        foreach ($rencanaLembur as $rl) {
          $noind = $rl['noind'];
          $cekPresensi = $this->M_hitungpesanan->getAbsenShiftTigaByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind);
          if (empty($cekPresensi)) {
            $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
            if (!empty($cekPesananTambahanLembur)) {
              $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
              $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
              if (empty($cekPesananTambahanLemburDetail)) {
                $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
              }
            }else{
              $this->M_hitungpesanan->insertPesananTambahanRencanaLembur($tanggal,$tempatMakan,$shift);
              $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
              if (!empty($cekPesananTambahanLembur)) {
                $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
                $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
                if (empty($cekPesananTambahanLemburDetail)) {
                  $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
                }
              }
            }
          }
        }
        $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
      }

      // Pesanan Tambahan
      $pesananTambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananTambahan)) {
        $jumlahPesananTambahan = $pesananTambahan['0']['jumlah'];
      }else{
        $jumlahPesananTambahan = 0;
      }

      // Pesanan Pengurangan
      $pesananPengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananPengurangan)) {
        $jumlahPesananPengurangan = $pesananPengurangan['0']['jumlah'];
      }else{
        $jumlahPesananPengurangan = 0;
      }

      // Pesanan Total 
      $jumlahPesananTotal = ($jumlahPesananStaff + $jumlahPesananNonStaff + $jumlahPesananTambahan) - $jumlahPesananPengurangan;

      $this->M_hitungpesanan->deletePesananByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);

      $dataInsert = array(
        'fd_tanggal'          => $tanggal,
        'fs_tempat_makan'     => $tempatMakan,
        'fs_kd_shift'         => $shift,
        'fn_jumlah_staff'     => $jumlahPesananStaff,
        'fn_jumlah_nonstaff'  => $jumlahPesananNonStaff,
        'fn_jumlah'           => $jumlahPesananAwal,
        'fn_jumlah_tambahan'    => $jumlahPesananTambahan,
        'fn_jumlah_pengurangan' => $jumlahPesananPengurangan,
        'fn_jumlah_pesan'     => $jumlahPesananTotal,
        'fs_tanda'            => '0',
        'lokasi'              => $lokasi
      );
      $this->M_hitungpesanan->insertPesananCatering($dataInsert);
    }

     // Rencana lembur yang belum ada absen di tempat makan
    $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftTigaNonAbsensiByTanggalLokasi($tanggal,$lokasi);
    if (!empty($rencanaLembur)) {
      foreach ($rencanaLembur as $rl) {
        $noind = $rl['noind'];
        $cekPresensi = $this->M_hitungpesanan->getAbsenShiftTigaByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind);
        if (empty($cekPresensi)) {
          $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
          if (!empty($cekPesananTambahanLembur)) {
            $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
            $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
            if (empty($cekPesananTambahanLemburDetail)) {
              $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
            }
          }else{
            $this->M_hitungpesanan->insertPesananTambahanRencanaLembur($tanggal,$tempatMakan,$shift);
            $cekPesananTambahanLembur = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
            if (!empty($cekPesananTambahanLembur)) {
              $idTambahan = $cekPesananTambahanLembur['0']['id_tambahan'];
              $cekPesananTambahanLemburDetail = $this->M_hitungpesanan->getPesananTambahanDetailByIdTambahanNoind($idTambahan,$noind);
              if (empty($cekPesananTambahanLemburDetail)) {
                $this->M_hitungpesanan->insertPesananTambahanDetail($idTambahan,$noind);
              }
            }
          }
        }
      }
      $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
    }

     // Pesanan Tambahan Yang Tidak ada Absennya 
    $pesananTambahanNonAbsensi = $this->M_hitungpesanan->getPesananTambahanNonAbsensiByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    foreach ($pesananTambahanNonAbsensi as $tambahan) {
      $jumlahPesananAwal = 0;
      $tempatMakan = $tambahan['tempat_makan'];
      $jumlahPesananStaff = 0;
      $jumlahPesananTambahan = $tambahan['jumlah'];

       // Pesanan Pengurangan
      $pesananPengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$tempatMakan);
      if (!empty($pesananPengurangan)) {
        $jumlahPesananPengurangan = $pesananPengurangan['0']['jumlah'];
      }else{
        $jumlahPesananPengurangan = 0;
      }

      // Pesanan Total 
      $jumlahPesananTotal = ($jumlahPesananStaff + $jumlahPesananNonStaff + $jumlahPesananTambahan) - $jumlahPesananPengurangan;

      $data[$index]['tanggal']      = $tanggal;
      $data[$index]['tempat_makan'] = $tempatMakan;
      $data[$index]['staff']        = $jumlahPesananStaff;
      $data[$index]['nontsaff']     = $jumlahPesananNonStaff;
      $data[$index]['tambahan']     = $jumlahPesananTambahan;
      $data[$index]['pengurangan']  = $jumlahPesananPengurangan;
      $data[$index]['awal']         = $jumlahPesananAwal;
      $data[$index]['total']        = $jumlahPesananTotal;

      $dataInsert = array(
        'fd_tanggal'          => $tanggal,
        'fs_tempat_makan'     => $tempatMakan,
        'fs_kd_shift'         => $shift,
        'fn_jumlah_staff'     => $jumlahPesananStaff,
        'fn_jumlah_nonstaff'  => $jumlahPesananNonStaff,
        'fn_jumlah'           => $jumlahPesananAwal,
        'fn_jumlah_tambahan'    => $jumlahPesananTambahan,
        'fn_jumlah_pengurangan' => $jumlahPesananPengurangan,
        'fn_jumlah_pesan'     => $jumlahPesananTotal,
        'fs_tanda'            => '0',
        'lokasi'              => $lokasi
      );
      $this->M_hitungpesanan->insertPesananCatering($dataInsert);
    }
  }

  public function cekLihat(){
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');

    if($tanggal == date("Y-m-d")){
      $waktuHitungStatus = $this->M_hitungpesanan->getWaktuHitungStatusByTanggalShift($tanggal,$shift);
      if (!empty($waktuHitungStatus)) {
        if ($waktuHitungStatus['0']['fb_status'] == 'f') {
          $this->M_hitungpesanan->updateWaktuHitungStatusByShift($shift,'1');
        }
      }
    }

    $dataViPesanan = $this->M_hitungpesanan->getViPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi);

    if (!empty($dataViPesanan)) {
      $urutanKatering = $this->M_hitungpesanan->getUrutanKateringByTanggalShiftLokasi($tanggal,$shift,$lokasi);
      if ($tanggal == date("Y-m-d")) {
        if (empty($urutanKatering)) {
          $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasi($tanggal,$shift,$lokasi);
        }
      }
    }else{
      return "Data Pesanan Belum Ada";
    }
    if ($shift == '1') {
      $jadwalKatering = $this->M_hitungpesanan->getKateringJadwalShiftSatuByTanggal($tanggal);      
    }elseif ($shift == '2') {
      $jadwalKatering = $this->M_hitungpesanan->getKateringJadwalShiftDuaByTanggal($tanggal);
    }elseif ($shift == '3') {
      $jadwalKatering = $this->M_hitungpesanan->getKateringJadwalShiftTigaByTanggal($tanggal);
    }

    if (empty($jadwalKatering)) {
      return "Jadwal Katering Belum Ada";
    }

    return "done";
  }

  function getpesananList($tanggal,$shift,$lokasi){
    $bagi = 0;
    $jumlahKatering = 0;
    $arrayJumlahPesanan = $this->M_hitungpesanan->getJumlahPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    $detailPesananBelumDitandai = $this->M_hitungpesanan->getPesananBelumDitandaiPerTempatMakanByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    $jumlahPesanan = $arrayJumlahPesanan['0']['total'];
    
    if($shift == '1'){
      $jadwalKatering = $this->M_hitungpesanan->getKateringJadwalShiftSatuByTanggal($tanggal);
      $urutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftSatuByTanggalLokasi($tanggal,$lokasi);
    }elseif ($shift == '2') {
      $jadwalKatering = $this->M_hitungpesanan->getKateringJadwalShiftDuaByTanggal($tanggal);
      $urutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftDuaByTanggalLokasi($tanggal,$lokasi);
    }elseif ($shift == '3') {
      $jadwalKatering = $this->M_hitungpesanan->getKateringJadwalShiftTigaByTanggal($tanggal);
      $urutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftTigaByTanggalLokasi($tanggal,$lokasi);
    }

    if (!empty($urutanJadwal)) {
      foreach ($urutanJadwal as $uj) {
        $libur = $this->M_hitungpesanan->cekPengajuanLiburByTanggalKateringLibur($tanggal,$uj['fs_kd_katering']);
        if (!empty($libur)) {
          if (!empty($libur['0']['fs_kd_katering_pengganti']) and $libur['0']['fs_kd_katering_pengganti'] != "-") {
            $jumlahKatering++;
          }
        }else{
          $jumlahKatering++;
        }
      }
    }

    $bagi = ceil($jumlahPesanan/$jumlahKatering);
    $pembagian = array();
    $index = 0;
    $index2 = 0;
    $jumlahSementara = 0;
    if (!empty($detailPesananBelumDitandai)) {
      foreach ($detailPesananBelumDitandai as $dp) {
        if ($jumlahSementara > $bagi or $jumlahSementara == 0) {
          if ($jumlahSementara !== 0) {
            $index++;
            $index2 = 0;
          }

          $urutankatering = $this->M_hitungpesanan->geturutankateringByTanggalShiftLokasiUrutan($tanggal,$shift,$lokasi,($index+1));
          if(!empty($urutankatering)){
            $katering = $urutankatering['0']['fs_nama_katering'];
          }else{
            $katering = $urutanJadwal[$index]['fs_nama_katering'];
          }


          $pengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$dp['fs_tempat_makan']);
          if (!empty($pengurangan)) {
            if ($pengurangan['0']['jumlah'] != $dp['fn_jumlah_pengurangan']) {
              $dp['fn_jumlah_pengurangan'] = $dp['fn_jumlah_pengurangan']." (".$pengurangan['0']['jumlah'].")";
            }
          }

          $tambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$dp['fs_tempat_makan']);
          if (!empty($tambahan)) {
            if ($tambahan['0']['jumlah'] != $dp['fn_jumlah_tambahan']) {
              $dp['fn_jumlah_tambahan'] = $dp['fn_jumlah_tambahan']." (".$tambahan['0']['jumlah'].")";
            }
          }

          $pembagian[$index]['fs_nama_katering'] = $katering;
          $pembagian[$index]['jumlah_total'] = $dp['fn_jumlah_pesan'];
          $pembagian[$index]['urutan'] = $index + 1;
          $pembagian[$index]['data'] = array();
          $pembagian[$index]['data'][] = array(
            'tanggal' => $dp['fd_tanggal'],
            'tempat_makan' => $dp['fs_tempat_makan'],
            'nonstaff' => $dp['fn_jumlah_nonstaff'],
            'staff' => $dp['fn_jumlah_staff'],
            'tambahan' => $dp['fn_jumlah_tambahan'],
            'pengurangan' => $dp['fn_jumlah_pengurangan'],
            'jumlah_pesan' => $dp['fn_jumlah_pesan']
          );

          $jumlahSementara = $dp['fn_jumlah_pesan'];
          $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasiTempatMakan($pembagian[$index]['urutan'],$tanggal,$shift,$lokasi,$dp['fs_tempat_makan']);
          $index2++;
        }else{
          $pengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$dp['fs_tempat_makan']);
          if (!empty($pengurangan)) {
            if ($pengurangan['0']['jumlah'] != $dp['fn_jumlah_pengurangan']) {
              $dp['fn_jumlah_pengurangan'] = $dp['fn_jumlah_pengurangan']." (".$pengurangan['0']['jumlah'].")";
            }
          }

          $tambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$dp['fs_tempat_makan']);
          if (!empty($tambahan)) {
            if ($tambahan['0']['jumlah'] != $dp['fn_jumlah_tambahan']) {
              $dp['fn_jumlah_tambahan'] = $dp['fn_jumlah_tambahan']." (".$tambahan['0']['jumlah'].")";
            }
          }

          $pembagian[$index]['jumlah_total'] += $dp['fn_jumlah_pesan'];
          $pembagian[$index]['data'][] = array(
            'tanggal' => $dp['fd_tanggal'],
            'tempat_makan' => $dp['fs_tempat_makan'],
            'nonstaff' => $dp['fn_jumlah_nonstaff'],
            'staff' => $dp['fn_jumlah_staff'],
            'tambahan' => $dp['fn_jumlah_tambahan'],
            'pengurangan' => $dp['fn_jumlah_pengurangan'],
            'jumlah_pesan' => $dp['fn_jumlah_pesan']
          );

          $jumlahSementara += $dp['fn_jumlah_pesan'];
          $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasiTempatMakan($pembagian[$index]['urutan'],$tanggal,$shift,$lokasi,$dp['fs_tempat_makan']);
          $index2++;
        }
      }      
    }else{
      for ($i=0; $i < $jumlahKatering; $i++) { 
        $urutankatering = $this->M_hitungpesanan->geturutankateringByTanggalShiftLokasiUrutan($tanggal,$shift,$lokasi,($i + 1));
          if(!empty($urutankatering)){
            $katering = $urutankatering['0']['fs_nama_katering'];
          }else{
            $katering = $urutanJadwal[$i]['fs_nama_katering'];
          }

          $pembagian[$i]['fs_nama_katering'] = $katering;
          $pembagian[$i]['urutan'] = $i + 1;
          $pembagian[$i]['data'] = array();
          $pembagian[$i]['jumlah_total'] = 0;

          $dataPesananSudahDitandai = $this->M_hitungpesanan->getPesananSudahDitandaiPerTempatMakanByTanggalShiftLokasiTanda($tanggal,$shift,$lokasi,($i + 1));
          if (!empty($dataPesananSudahDitandai)) {
            foreach ($dataPesananSudahDitandai as $dp) {

              $pengurangan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakan($tanggal,$shift,$dp['fs_tempat_makan']);
              if (!empty($pengurangan)) {
                if ($pengurangan['0']['jumlah'] != $dp['fn_jumlah_pengurangan']) {
                  $dp['fn_jumlah_pengurangan'] = $dp['fn_jumlah_pengurangan']." (".$pengurangan['0']['jumlah'].")";
                }
              }

              $tambahan = $this->M_hitungpesanan->getPesananTambahanByTanggalShiftTempatMakan($tanggal,$shift,$dp['fs_tempat_makan']);
              if (!empty($tambahan)) {
                if ($tambahan['0']['jumlah'] != $dp['fn_jumlah_tambahan']) {
                  $dp['fn_jumlah_tambahan'] = $dp['fn_jumlah_tambahan']." (".$tambahan['0']['jumlah'].")";
                }
              }

              $pembagian[$i]['data'][] = array(
                'tanggal' => $dp['fd_tanggal'],
                'tempat_makan' => $dp['fs_tempat_makan'],
                'nonstaff' => $dp['fn_jumlah_nonstaff'],
                'staff' => $dp['fn_jumlah_staff'],
                'tambahan' => $dp['fn_jumlah_tambahan'],
                'pengurangan' => $dp['fn_jumlah_pengurangan'],
                'jumlah_pesan' => $dp['fn_jumlah_pesan']
              );
              $pembagian[$i]['jumlah_total'] += $dp['fn_jumlah_pesan'];
            }
          }
      }
    }

    return $pembagian;
  }

  public function prosesLihat(){
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Title'] = 'Lihat Pesanan';
    $data['Menu'] = 'Lihat Pesanan';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $tanggal = $this->input->post('CateringHitungPesananTanggal');
    $shift = $this->input->post('CateringHitungPesananShift');
    $lokasi = $this->input->post('CateringHitungPesananLokasi');
    $data['tanggal'] = $tanggal;
    $data['shift'] = $shift;
    $data['lokasi'] = $lokasi;
    $data['pembagian'] = $this->getpesananList($tanggal,$shift,$lokasi);

    $data_log = array(
      'wkt' => date('Y-m-d H:i:s'),
      'menu' => 'HITUNG PESANAN',
      'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi,
      'noind' => $this->session->user,
      'jenis' => 'LIHAT DATA PESANAN',
      'program' => 'CATERING MANAGEMENT ERP'
    );

    $this->M_hitungpesanan->insertTlog($data_log);
    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('CateringManagement/HitungPesanan/V_hasil',$data);
    $this->load->view('V_Footer',$data);
  }

  public function gantiUrutan(){
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');
    $tempat_makan = $this->input->post('tempat_makan');
    $urutan = $this->input->post('urutan');

    $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasiTempatMakan($urutan,$tanggal,$shift,$lokasi,$tempat_makan);
    $data_log = array(
      'wkt' => date('Y-m-d H:i:s'),
      'menu' => 'HITUNG PESANAN',
      'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi.' TEMPAT-MAKAN: '.$tempat_makan.' URUTAN-BARU: '.$urutan,
      'noind' => $this->session->user,
      'jenis' => 'GANTI URUTAN DATA PESANAN',
      'program' => 'CATERING MANAGEMENT ERP'
    );
    $this->M_hitungpesanan->insertTlog($data_log);
    $this->getPesananListByTanggalShiftLokasi($tanggal,$shift,$lokasi);
  }

  public function getPesananListByTanggalShiftLokasi($tanggal,$shift,$lokasi){
    $pembagian = $this->getpesananList($tanggal,$shift,$lokasi);

    if (isset($pembagian) and !empty($pembagian)) { 
      $isi = " <table border=\"1\" style=\"width: 100%;border-collapse: collapse;\" id=\"CateringHitungPesananLihatTabel\">";

      foreach ($pembagian as $bagi) {
        $isi .= "<tr>
          <td colspan=\"7\">Nama Katering : ".$bagi['fs_nama_katering']."</td>
        </tr>
        <tr>
          <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">No.</td>
          <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Tempat Makan</td>
          <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Staff</td>
          <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Non Staff</td>
          <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Tambah</td>
          <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Kurang</td>
          <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Jumlah</td>
        </tr>";

        $nomor = 1;
        foreach ($bagi['data'] as $data) {

          $isi .= "<tr data-urutan=\"".$bagi['urutan']."\" data-katering=\"".$data['tempat_makan']."\">
            <td style=\"text-align: center\">".$nomor."</td>
            <td style=\"text-align: left;padding-left: 20px;\">".$data['tempat_makan']."</td>
            <td style=\"text-align: right;padding-right: 20px;\">".$data['staff']."</td>
            <td style=\"text-align: right;padding-right: 20px;\">".$data['nonstaff']."</td>
            <td style=\"text-align: right;padding-right: 20px;\">".$data['tambahan']."</td>
            <td style=\"text-align: right;padding-right: 20px;\">".$data['pengurangan']."</td>
            <td style=\"text-align: right;padding-right: 20px;\">".$data['jumlah_pesan']."</td>
          </tr>";

          $nomor++;
        }
        $isi .= "<tr>
          <td colspan=\"6\" style=\"text-align: right;padding-right: 20px;\">Total : </td>
          <td style=\"text-align: right;padding-right: 20px;\">".$bagi['jumlah_total']."</td>
        </tr>
        <tr>
          <td colspan=\"7\">&nbsp;</td>
        </tr>";

      }

      $jumlah = "";
      for ($i=1; $i <= 10; $i++) { 
        $jumlah .="<div class=\"row\">
          <div class=\"col-lg-12\">
            <label class=\"control-label\">Katering ".$i."</label>
            <div class=\"col-lg-9\" style=\"padding: 0%\">
              <input type=\"text\" class=\"form-control input-sm\" name=\"txtKateringTampilNama".$i."\" value=\"".(isset($pembagian[$i-1]['fs_nama_katering']) ? $pembagian[$i-1]['fs_nama_katering'] : '')."\" ".(isset($pembagian[$i-1]['fs_nama_katering']) ? '' : 'disabled')." >
            </div>
            <div class=\"col-lg-3\" style=\"padding: 0%\">
              <input type=\"text\" class=\"form-control input-sm\" name=\"txtKateringTampilJumlah".$i."\" value=\"".(isset($pembagian[$i-1]['fs_nama_katering']) ? $pembagian[$i-1]['jumlah_total'] : '')."\" ".(isset($pembagian[$i-1]['fs_nama_katering']) ? '' : 'disabled')." >
            </div>
          </div>
        </div>"; 
      }
      $isi .= "</table>";
      $data = array();
      $data['table'] = $isi;
      $data['katering'] = $jumlah;
      echo json_encode($data);
    }else{
      echo "Tidak Ditemukan Data";
    }
  }

  public function copyPembagian(){
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');
    $tanggal_copy = $this->input->post('tanggal_copy');

    $dataPembagian = $this->M_hitungpesanan->getPembagianByTanggalShiftLokasiTanggalCopy($tanggal,$shift,$lokasi,$tanggal_copy);
    if(!empty($dataPembagian)){
      $simpanUrutan = "0";
      foreach ($dataPembagian as $key => $value) {
        if ($value['tanda_baru'] == '0') {
          $urutan_baru = $simpanUrutan;
        }else{
          $urutan_baru = $value['tanda_baru'];
        }
        $tempat_makan = $value['fs_tempat_makan'];
        $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasiTempatMakan($urutan_baru,$tanggal,$shift,$lokasi,$tempat_makan);
      }
    }
    $data_log = array(
      'wkt' => date('Y-m-d H:i:s'),
      'menu' => 'HITUNG PESANAN',
      'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi.' TGL-COPY: '.$tanggal_copy,
      'noind' => $this->session->user,
      'jenis' => 'COPY PEMBAGIAN DATA PESANAN',
      'program' => 'CATERING MANAGEMENT ERP'
    );
    $this->M_hitungpesanan->insertTlog($data_log);
    $this->getPesananListByTanggalShiftLokasi($tanggal,$shift,$lokasi);
  }  

  public function simpanHistory(){
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');
    $jenis = $this->input->post('jenis');
    if ($jenis == '0') {
      $jenis_nama = 'SNACK';
    }else{
      $jenis_nama = 'MAKAN';
    }
    $data = $this->M_hitungpesanan->getViPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    $history = $this->M_hitungpesanan->getPesananHistoryByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    if (!empty($history)) {
      if (!empty($data)) {
        foreach ($data as $key => $value) {
          $data_insert = array(
            'fd_tanggal' => $value['fd_tanggal'],
            'fs_tempat_makan' => $value['fs_tempat_makan'],
            'fs_kd_shift' => $value['fs_kd_shift'],
            'fn_jumlah_nonstaff' => $value['fn_jumlah_nonstaff'],
            'fn_jumlah_staff' => $value['fn_jumlah_staff'],
            'fn_jumlah' => $value['fn_jumlah'],
            'fn_jumlah_tambahan' => $value['fn_jumlah_tambahan'],
            'fn_jumlah_tambahan' => $value['fn_jumlah_pengurangan'],
            'fn_jumlah_pesan' => $value['fn_jumlah_pesan'],
            'fs_tanda' => $value['fs_tanda'],
            'lokasi' => $value['fs_lokasi'],
            'jenis_pesanan' => $jenis,
          );
          $this->M_hitungpesanan->insertPesananHistory($data_insert);
        }
        $data_log = array(
          'wkt' => date('Y-m-d H:i:s'),
          'menu' => 'HITUNG PESANAN',
          'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi,
          'noind' => $this->session->user,
          'jenis' => 'SIMPAN - REPLACE DATA PESANAN '.$jenis_nama,
          'program' => 'CATERING MANAGEMENT ERP'
        );
        $this->M_hitungpesanan->insertTlog($data_log);
      }
    }else{
      if (!empty($data)) {
        foreach ($data as $key => $value) {
          $data_insert = array(
            'fd_tanggal' => $value['fd_tanggal'],
            'fs_tempat_makan' => $value['fs_tempat_makan'],
            'fs_kd_shift' => $value['fs_kd_shift'],
            'fn_jumlah_nonstaff' => $value['fn_jumlah_nonstaff'],
            'fn_jumlah_staff' => $value['fn_jumlah_staff'],
            'fn_jumlah' => $value['fn_jumlah'],
            'fn_jumlah_tambahan' => $value['fn_jumlah_tambahan'],
            'fn_jumlah_tambahan' => $value['fn_jumlah_pengurangan'],
            'fn_jumlah_pesan' => $value['fn_jumlah_pesan'],
            'fs_tanda' => $value['fs_tanda'],
            'lokasi' => $value['fs_lokasi'],
            'jenis_pesanan' => $jenis,
          );
          $this->M_hitungpesanan->insertPesananHistory($data_insert);
        }
        $data_log = array(
          'wkt' => date('Y-m-d H:i:s'),
          'menu' => 'HITUNG PESANAN',
          'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi,
          'noind' => $this->session->user,
          'jenis' => 'SIMPAN DATA PESANAN '.$jenis_nama,
          'program' => 'CATERING MANAGEMENT ERP'
        );
        $this->M_hitungpesanan->insertTlog($data_log);
      }
    }
    echo "success";
  }

  public function cetakHistory(){
    $tanggal = $this->input->get('tanggal');
    $shift = $this->input->get('shift');
    $lokasi = $this->input->get('lokasi');
    $jenis = $this->input->get('jenis');
    
    $pembagian = $this->getpesananList($tanggal,$shift,$lokasi);

    $data = array();
    
    if ($jenis == '0') {
      $jenis_nama = 'SNACK';
      $nomor = 1;
      if (isset($pembagian) and !empty($pembagian)) { 
        $isi = "<table style='width: 100%;border: 2px solid white'>";

        foreach ($pembagian as $bagi) {

          foreach ($bagi['data'] as $data) {
            if ($nomor%3 == 1) {
              $isi .= "<tr>";
            }elseif ($nomor%3 == 3) {
              $isi .= "</tr>";
            }
            $isi .= "
            <td style='width: 33%;'>
              <table border='2' style='width: 100%;border: 2px solid black;'>
                <tr>
                  <td colspan='3' style='text-align: center;border-bottom: 2px solid black;font-weight: bold;font-size: 15pt;vertical-align: middle;height: 60px;'>
                    ".$data['tempat_makan']."
                  </td>
                </tr>
                <tr>
                  <td rowspan='4' style='text-align: center;font-weight: bold;font-size: 40pt;width: 220px;'>
                    ".$data['jumlah_pesan']."
                  </td>
                  <td style='color: grey;text-align: right'>S</td>
                  <td style='color: grey;text-align: right'>
                    ".$data['staff']."
                  </td>
                </tr>
                <tr>
                  <td style='color: grey;text-align: right'>NS</td>
                  <td style='color: grey;text-align: right'>
                    ".$data['nonstaff']."
                  </td>
                </tr>
                <tr>
                  <td style='color: grey;text-align: right'>T</td>
                  <td style='color: grey;text-align: right'>
                    ".$data['tambahan']."
                  </td>
                </tr>
                <tr>
                  <td style='color: grey;text-align: right'>K</td>
                  <td style='color: grey;text-align: right'>
                    ".$data['pengurangan']."
                  </td>
                </tr>
              </table>
            </td>";
            $nomor++;
          }
        }

        $isi .= "</table>";
        $data['daftar'] = $isi;
        
      }else{
        $data['daftar'] = "";
      }
    }else{
      $jenis_nama = 'MAKAN';
       if (isset($pembagian) and !empty($pembagian)) { 
        $tgl = explode("-", $tanggal)['2'];
        $bln = explode("-", $tanggal)['1'];
        $thn = explode("-", $tanggal)['0'];
        $menu = $this->M_hitungpesanan->getMenuDetailByTanggalBulanTahunShiftLokasi($tgl,$bln,$thn,$shift,$lokasi);
        if (!empty($menu)) {
          $sayur = $menu->sayur;
          $lauk_utama = $menu->lauk_utama;
          $lauk_pendamping = $menu->lauk_pendamping;
          $buah = $menu->buah;
        }else{
          $sayur = "-";
          $lauk_utama = "-";
          $lauk_pendamping = "-";
          $buah = "-";
        }

        if ($lokasi == "1") {
          $lokasi_str = "Yogyakarta & Mlati";
        }elseif ($lokasi == "2") {
          $lokasi_str = "Tuksono";
        }else{
          $lokasi_str ="tidak diketahui";
        }

        if ($shift == "1") {
          $shift_str = "1 & Umum";
        }elseif ($shift == "2") {
          $shift_str = "2";
        }elseif ($shift == "3") {
          $shift_str = "3";
        }else{
          $shift_str = "tidak diketahui";
        }

        $isi_header = "
        <table style=\"width: 100%\">
          <tr>
            <td rowspan=\"2\" style=\"width: 75%;font-size: 20pt;\">
              <b>Daftar Pesanan Catering</b>
            </td>
            <td style=\"width: 6%\">
              Lokasi
            </td>
            <td style=\"width: 2%\">
              :
            </td>
            <td style=\"width: 17%\">
              ".$lokasi_str."
            </td>
          </tr>
          <tr>
            <td>
              Tanggal
            </td>
            <td>
              :
            </td>
            <td>
              ".date('d M Y', strtotime($tanggal))."
            </td>
          </tr>
          <tr>
            <td>
              Menu ".$sayur." - ".$lauk_utama." - ". $lauk_pendamping." - ".$buah."
            </td>
            <td>
              Shift
            </td>
            <td>
              :
            </td>
            <td>
              ".$shift_str."
            </td>
          </tr>
        </table>
        ";
        $isi = $isi_header." <table border=\"1\" style=\"width: 100%;border-collapse: collapse;\" id=\"CateringHitungPesananLihatTabel\">";

        foreach ($pembagian as $bagi) {
          $isi .= "<tr>
            <td colspan=\"7\">Nama Katering : ".$bagi['fs_nama_katering']."</td>
          </tr>
          <tr>
            <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">No.</td>
            <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Tempat Makan</td>
            <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Staff</td>
            <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Non Staff</td>
            <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Tambah</td>
            <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Kurang</td>
            <td style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black\">Jumlah</td>
          </tr>";

          $nomor = 1;
          foreach ($bagi['data'] as $data) {
            if ($data['pengurangan'] !== "0" && $data['tambahan'] !== "0") {
              $warna = "green";
            }elseif ($data['pengurangan'] !== "0") {
              $warna = "red";
            }elseif ($data['tambahan'] !== "0") {
              $warna = "blue";
            }else{
              $warna = "black";
            }
            $isi .= "<tr data-urutan=\"".$bagi['urutan']."\" data-katering=\"".$data['tempat_makan']."\">
              <td style=\"text-align: center;color: ".$warna."\">".$nomor."</td>
              <td style=\"text-align: left;padding-left: 20px;color: ".$warna."\">".$data['tempat_makan']."</td>
              <td style=\"text-align: right;padding-right: 20px;color: ".$warna."\">".$data['staff']."</td>
              <td style=\"text-align: right;padding-right: 20px;color: ".$warna."\">".$data['nonstaff']."</td>
              <td style=\"text-align: right;padding-right: 20px;color: ".$warna."\">".$data['tambahan']."</td>
              <td style=\"text-align: right;padding-right: 20px;color: ".$warna."\">".$data['pengurangan']."</td>
              <td style=\"text-align: right;padding-right: 20px;color: ".$warna."\">".$data['jumlah_pesan']."</td>
            </tr>";

            $nomor++;
          }
          $isi .= "<tr>
            <td colspan=\"6\" style=\"text-align: right;padding-right: 20px;\">Total : </td>
            <td style=\"text-align: right;padding-right: 20px;\">".$bagi['jumlah_total']."</td>
          </tr>
          <tr>
            <td colspan=\"7\">&nbsp;</td>
          </tr>";

        }

        $isi .= "</table>";
        $isi_footer = "
        <table style=\"width: 100%\">
          <tr>
            <td style=\"color: blue;width: 33%\">
              Ada Penambahan
            </td>
            <td style=\"color: red;width: 33%\">
              Ada Pengurangan
            </td>
            <td style=\"color: green;width: 33%\">
              Ada Penambahan dan Pengurangan
            </td>
          </tr>
        </table>";
        $isi .= $isi_footer;
        $data['daftar'] = $isi;
        
      }else{
        $data['daftar'] = "";
      }
    }

    $data_log = array(
      'wkt' => date('Y-m-d H:i:s'),
      'menu' => 'HITUNG PESANAN',
      'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi,
      'noind' => $this->session->user,
      'jenis' => 'CETAK DATA PESANAN '.$jenis_nama,
      'program' => 'CATERING MANAGEMENT ERP'
    );
    $this->M_hitungpesanan->insertTlog($data_log);
    // echo $data['daftar'];exit();

    $this->load->library('pdf');

    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 5, 5, 5, 5, 'P');
    $filename = 'PESANAN_'.$jenis_nama.'_'.$tanggal.'_'.$shift.'_'.$lokasi.'.pdf';
    // echo "<pre>";print_r($data['PrintppDetail']);exit();
    $html = $this->load->view('CateringManagement/HitungPesanan/V_pdf', $data, true);
    $pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh ".$this->session->user." - ".$this->session->employee." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". <br>Halaman {PAGENO} dari {nb}</i>");
    $pdf->WriteHTML($html, 2);
    // $pdf->Output($filename, 'D');
    $pdf->Output($filename, 'I');
  }

}

?>