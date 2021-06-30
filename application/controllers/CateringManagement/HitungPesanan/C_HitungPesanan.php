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
      redirect('');
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

    $data['lokasi_kerja'] = intval($this->session->kode_lokasi_kerja);
    $data['kodesie'] = $this->session->kodesie;

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('CateringManagement/HitungPesanan/V_index.php',$data);
    $this->load->view('V_Footer',$data);
  }

  public function cekPesanan(){
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');
    $jenis = $this->input->post('jenis');
    $data = array();

    if (strtotime($tanggal) == strtotime(date('Y-m-d'))) {
      $data['statusTanggal'] = "ok";
    }else{
      $data['statusTanggal'] = "not ok";
    }

    if (isset($data['statusTanggal']) && $data['statusTanggal'] == "ok") {
      $dataPesanan = $this->M_hitungpesanan->getPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi);
      if (!empty($dataPesanan)) {
        $data['JumlahPesanan'] = count($dataPesanan);
        $data['statusPesanan'] = 'ada';
      }else{
        $data['JumlahPesanan'] = 0;
        $data['statusPesanan'] = 'tidak ada';
      }
    }

    if (isset($data['statusPesanan'])) {
      $dataKatering = $this->M_hitungpesanan->getKateringByLokasi($lokasi);
      if (!empty($dataKatering)) {
        $data['jumlahKatering'] = count($dataKatering);
        $data['statusKatering'] = 'ada';
      }else{
        $data['jumlahKatering'] = 0;
        $data['statusKatering'] = 'tidak ada';
      }
    }

    if (isset($data['statusKatering']) && $data['statusKatering'] == 'ada') {
      $dataJadwal = $this->M_hitungpesanan->getJadwalByTanggalLokasi($tanggal,$lokasi);
      if (!empty($dataJadwal)) {
        $data['jumlahJadwal'] = count($dataJadwal);
        $data['statusJadwal'] = 'ada';
      }else{
        $data['jumlahJadwal'] = 0;
        $data['statusJadwal'] = 'tidak ada';
      }
    }

    if (isset($data['statusJadwal']) && $data['statusJadwal'] == 'ada') {
      $dataBatasDatang = $this->M_hitungpesanan->getBatasDatangByTanggalShift($tanggal,$shift);
      if (!empty($dataBatasDatang) || $shift == '3') {
        $data['jumlahBatasDatang'] = count($dataBatasDatang);
        $data['statusBatasDatang'] = 'ada';
      }else{
        $data['jumlahBatasDatang'] = 0;
        $data['statusBatasDatang'] = 'tidak ada';
      }
    }

    if (isset($data['statusBatasDatang']) && $data['statusBatasDatang'] == 'ada') {
      if ($shift == '1') {
        $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasi($tanggal,$lokasi,$jenis);
      }elseif($shift == '2'){
        $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftDuaByTanggalLokasi($tanggal,$lokasi,$jenis);
      }elseif ($shift == '3') {
        $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftTigaByTanggalLokasi($tanggal,$lokasi,$jenis);
      }
      if (!empty($dataAbsenShift) || $shift == '3') {
        $data['jumlahAbsenShift'] = count($dataAbsenShift);
        $data['statusAbsenShift'] = 'ada';
      }else{
        $data['jumlahAbsenShift'] = 0;
        $data['statusAbsenShift'] = 'tidak ada';
      }
    }

    if (isset($data['statusAbsenShift']) && $data['statusAbsenShift'] == 'ada') {
      if ($shift == '1') {
        $dataUrutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftSatuByTanggalLokasi($tanggal,$lokasi);
      }elseif ($shift == '2') {
        $dataUrutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftDuaByTanggalLokasi($tanggal,$lokasi);
      }elseif ($shift == '3') {
        $dataUrutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftTigaByTanggalLokasi($tanggal,$lokasi);
      }
      if (!empty($dataUrutanJadwal)) {
        $data['jumlahUrutanJadwal'] = count($dataUrutanJadwal);
        $data['statusUrutanJadwal'] = 'ada';
      }else{
        $data['jumlahUrutanJadwal'] = 0;
        $data['statusUrutanJadwal'] = 'tidak ada';
      }
    }

    echo json_encode($data);
  }

  public function cekPesananBackDate(){
    $tanggal = $this->input->post('tanggal');
    $shift = $this->input->post('shift');
    $lokasi = $this->input->post('lokasi');
    $jenis = $this->input->post('jenis');
    $data = array();

    if (strtotime($tanggal) < strtotime(date('Y-m-d')) && strtotime($tanggal) >= strtotime(date('Y-m-d').' - 7 day')) {
      $data['statusTanggal'] = "ok";
    }else{
      $data['statusTanggal'] = "not ok";
    }

    if (isset($data['statusTanggal']) && $data['statusTanggal'] == "ok") {
      $dataPesanan = $this->M_hitungpesanan->getPesananByTanggalShiftLokasi($tanggal,$shift,$lokasi);
      if (!empty($dataPesanan)) {
        $data['JumlahPesanan'] = count($dataPesanan);
        $data['statusPesanan'] = 'ada';
      }else{
        $data['JumlahPesanan'] = 0;
        $data['statusPesanan'] = 'tidak ada';
      }
    }

    if (isset($data['statusPesanan'])) {
      $dataKatering = $this->M_hitungpesanan->getKateringByLokasi($lokasi);
      if (!empty($dataKatering)) {
        $data['jumlahKatering'] = count($dataKatering);
        $data['statusKatering'] = 'ada';
      }else{
        $data['jumlahKatering'] = 0;
        $data['statusKatering'] = 'tidak ada';
      }
    }

    if (isset($data['statusKatering']) && $data['statusKatering'] == 'ada') {
      $dataJadwal = $this->M_hitungpesanan->getJadwalByTanggalLokasi($tanggal,$lokasi);
      if (!empty($dataJadwal)) {
        $data['jumlahJadwal'] = count($dataJadwal);
        $data['statusJadwal'] = 'ada';
      }else{
        $data['jumlahJadwal'] = 0;
        $data['statusJadwal'] = 'tidak ada';
      }
    }

    if (isset($data['statusJadwal']) && $data['statusJadwal'] == 'ada') {
      $dataBatasDatang = $this->M_hitungpesanan->getBatasDatangByTanggalShift($tanggal,$shift);
      if (!empty($dataBatasDatang) || $shift == '3') {
        $data['jumlahBatasDatang'] = count($dataBatasDatang);
        $data['statusBatasDatang'] = 'ada';
      }else{
        $data['jumlahBatasDatang'] = 0;
        $data['statusBatasDatang'] = 'tidak ada';
      }
    }

    if (isset($data['statusBatasDatang']) && $data['statusBatasDatang'] == 'ada') {
      if ($shift == '1') {
        $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasi($tanggal,$lokasi,$jenis);
      }elseif($shift == '2'){
        $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftDuaByTanggalLokasi($tanggal,$lokasi,$jenis);
      }elseif ($shift == '3') {
        $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftTigaByTanggalLokasi($tanggal,$lokasi,$jenis);
      }
      if (!empty($dataAbsenShift) || $shift == '3') {
        $data['jumlahAbsenShift'] = count($dataAbsenShift);
        $data['statusAbsenShift'] = 'ada';
      }else{
        $data['jumlahAbsenShift'] = 0;
        $data['statusAbsenShift'] = 'tidak ada';
      }
    }

    if (isset($data['statusAbsenShift']) && $data['statusAbsenShift'] == 'ada') {
      if ($shift == '1') {
        $dataUrutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftSatuByTanggalLokasi($tanggal,$lokasi);
      }elseif ($shift == '2') {
        $dataUrutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftDuaByTanggalLokasi($tanggal,$lokasi);
      }elseif ($shift == '3') {
        $dataUrutanJadwal = $this->M_hitungpesanan->getUrutanJadwalShiftTigaByTanggalLokasi($tanggal,$lokasi);
      }
      if (!empty($dataUrutanJadwal)) {
        $data['jumlahUrutanJadwal'] = count($dataUrutanJadwal);
        $data['statusUrutanJadwal'] = 'ada';
      }else{
        $data['jumlahUrutanJadwal'] = 0;
        $data['statusUrutanJadwal'] = 'tidak ada';
      }
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
    $jenis = $this->input->post('jenis');
    $password = $this->input->post('password');
    $alasan = $this->input->post('alasan');
    $user = $this->session->user;

    if (strtotime($tanggal) < strtotime(date('Y-m-d'))) {
      $cekPassword = $this->M_hitungpesanan->cekPassword($user,$password);
      if (count($cekPassword) == 0) {
        echo "Password yang Anda Masukkan tidak sesuai";
        exit();
      }
    }

    $this->M_hitungpesanan->deletePesananByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    $this->M_hitungpesanan->deleteUrutanKateringByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    if($shift == '1' or $shift == '2'){
      $this->M_hitungpesanan->UpdateWaktuHitungByShift($shift,'0');
    }

    if ($shift == '1') {
      $this->hitungShift1($tanggal,$shift,$lokasi,$jenis);
    }elseif($shift == '2'){
      $this->hitungShift2($tanggal,$shift,$lokasi,$jenis);
    }elseif ($shift == '3') {
      $this->hitungShift3($tanggal,$shift,$lokasi);
    }

    if($shift == '1' or $shift == '2'){
      $this->M_hitungpesanan->UpdateWaktuHitungByShift($shift,'1');      
    }
    
    $this->simpanDetail($tanggal,$shift,$lokasi,$jenis);

    if (strtotime($tanggal) < strtotime(date('Y-m-d'))) {
      $data_log = array(
        'wkt' => date('Y-m-d H:i:s'),
        'menu' => 'HITUNG PESANAN',
        'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi.' ALASAN: '.$alasan,
        'noind' => $user,
        'jenis' => 'HITUNG DATA PESANAN BACK DATE',
        'program' => 'CATERING MANAGEMENT ERP'
      );
    }else {
      $data_log = array(
        'wkt' => date('Y-m-d H:i:s'),
        'menu' => 'HITUNG PESANAN',
        'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi,
        'noind' => $user,
        'jenis' => 'HITUNG DATA PESANAN',
        'program' => 'CATERING MANAGEMENT ERP'
      );
    }
    $this->M_hitungpesanan->insertTlog($data_log);
    echo "selesai";
  }

  public function hitungShift1($tanggal,$shift,$lokasi,$jenis){
    $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasi($tanggal,$lokasi,$jenis);
    // echo "<pre>";print_r($dataAbsenShift);exit();
    $data = array();
    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

    foreach ($dataAbsenShift as $pesanan) {
      $jumlahPesananAwal = $pesanan['jumlah'];
      $tempatMakan = $pesanan['tempat_makan'];
      $pesananStaff = $this->M_hitungpesanan->getAbsenShiftSatuStaffByTanggalLokasiTempatMakan($tanggal,$lokasi,$tempatMakan,$jenis);
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

      // Insert Pekerja Tidak Makan
      $pekerjaTidakMakan = $this->M_hitungpesanan->getPekerjaTidakMakanByTanggalTempatMakan($tanggal,$tempatMakan);
      if (!empty($pekerjaTidakMakan)) {
        foreach ($pekerjaTidakMakan as $ptm) {
          $noind = $ptm['pekerja'];
          $cekPresensi = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind,$jenis);
          if (!empty($cekPresensi)) {
            $cekPesananPenguranganTidakMakan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
            if (!empty($cekPesananPenguranganTidakMakan)) {
              $idPengurangan = $cekPesananPenguranganTidakMakan['0']['id_pengurangan'];
              $cekPesananPenguranganTidakMakanDetail = $this->M_hitungpesanan->getPesananPenguranganByIdPenguranganNoind($idPengurangan,$noind);
              if (empty($cekPesananPenguranganTidakMakanDetail)) {
                $this->M_hitungpesanan->insertPesananPenguranganDetail($idPengurangan,$noind);
              }
            }else{
              $this->M_hitungpesanan->insertPesananPenguranganTidakMakan($tanggal,$tempatMakan,$shift);
              $cekPesananPenguranganTidakMakan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
              if (!empty($cekPesananPenguranganTidakMakan)) {
                $idPengurangan = $cekPesananPenguranganTidakMakan['0']['id_pengurangan'];
                $cekPesananPenguranganTidakMakanDetail = $this->M_hitungpesanan->getPesananPenguranganByIdPenguranganNoind($idPengurangan,$noind);
                if (empty($cekPesananPenguranganTidakMakanDetail)) {
                  $this->M_hitungpesanan->insertPesananPenguranganDetail($idPengurangan,$noind);
                }
              }
            }
          }
        }
        $this->M_hitungpesanan->updatePesananPenguranganTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
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

    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

    // Rencana lembur yang belum ada absen di tempat makan
    $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftSatuNonAbsensiByTanggalLokasi($tanggal,$lokasi);
    if (!empty($rencanaLembur)) {
      foreach ($rencanaLembur as $rl) {
        $noind = $rl['noind'];
        $tempatMakan = $rl['tempat_makan'];
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
        $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
      }
    }

    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

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

  public function hitungShift2($tanggal,$shift,$lokasi,$jenis){
    $dataAbsenShift = $this->M_hitungpesanan->getAbsenShiftDuaByTanggalLokasi($tanggal,$lokasi,$jenis);
     // echo "<pre>";print_r($dataAbsenShift);exit();
    $data = array();
    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

    foreach ($dataAbsenShift as $pesanan) {
      $jumlahPesananAwal = $pesanan['jumlah'];
      $tempatMakan = $pesanan['tempat_makan'];
      $pesananStaff = $this->M_hitungpesanan->getAbsenShiftDuaStaffByTanggalLokasiTempatMakan($tanggal,$lokasi,$tempatMakan,$jenis);
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


      // Insert Pekerja Tidak Makan
      $pekerjaTidakMakan = $this->M_hitungpesanan->getPekerjaTidakMakanByTanggalTempatMakan($tanggal,$tempatMakan);
      if (!empty($pekerjaTidakMakan)) {
        foreach ($pekerjaTidakMakan as $ptm) {
          $noind = $ptm['pekerja'];
          $cekPresensi = $this->M_hitungpesanan->getAbsenShiftDuaByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind);
          if (!empty($cekPresensi)) {
            $cekPesananPenguranganTidakMakan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
            if (!empty($cekPesananPenguranganTidakMakan)) {
              $idPengurangan = $cekPesananPenguranganTidakMakan['0']['id_pengurangan'];
              $cekPesananPenguranganTidakMakanDetail = $this->M_hitungpesanan->getPesananPenguranganByIdPenguranganNoind($idPengurangan,$noind);
              if (empty($cekPesananPenguranganTidakMakanDetail)) {
                $this->M_hitungpesanan->insertPesananPenguranganDetail($idPengurangan,$noind);
              }
            }else{
              $this->M_hitungpesanan->insertPesananPenguranganTidakMakan($tanggal,$tempatMakan,$shift);
              $cekPesananPenguranganTidakMakan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
              if (!empty($cekPesananPenguranganTidakMakan)) {
                $idPengurangan = $cekPesananPenguranganTidakMakan['0']['id_pengurangan'];
                $cekPesananPenguranganTidakMakanDetail = $this->M_hitungpesanan->getPesananPenguranganByIdPenguranganNoind($idPengurangan,$noind);
                if (empty($cekPesananPenguranganTidakMakanDetail)) {
                  $this->M_hitungpesanan->insertPesananPenguranganDetail($idPengurangan,$noind);
                }
              }
            }
          }
        }
        $this->M_hitungpesanan->updatePesananPenguranganTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
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

    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

    // Rencana lembur yang belum ada absen di tempat makan
    $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftDuaNonAbsensiByTanggalLokasi($tanggal,$lokasi);
    if (!empty($rencanaLembur)) {
      foreach ($rencanaLembur as $rl) {
        $noind = $rl['noind'];
        $tempatMakan = $rl['tempat_makan'];
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
        $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
      }
    }

    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

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
    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

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

      // Insert Pekerja Tidak Makan
      $pekerjaTidakMakan = $this->M_hitungpesanan->getPekerjaTidakMakanByTanggalTempatMakan($tanggal,$tempatMakan);
      if (!empty($pekerjaTidakMakan)) {
        foreach ($pekerjaTidakMakan as $ptm) {
          $noind = $ptm['pekerja'];
          $cekPresensi = $this->M_hitungpesanan->getAbsenShiftTigaByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempatMakan,$noind);
          if (!empty($cekPresensi)) {
            $cekPesananPenguranganTidakMakan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
            if (!empty($cekPesananPenguranganTidakMakan)) {
              $idPengurangan = $cekPesananPenguranganTidakMakan['0']['id_pengurangan'];
              $cekPesananPenguranganTidakMakanDetail = $this->M_hitungpesanan->getPesananPenguranganByIdPenguranganNoind($idPengurangan,$noind);
              if (empty($cekPesananPenguranganTidakMakanDetail)) {
                $this->M_hitungpesanan->insertPesananPenguranganDetail($idPengurangan,$noind);
              }
            }else{
              $this->M_hitungpesanan->insertPesananPenguranganTidakMakan($tanggal,$tempatMakan,$shift);
              $cekPesananPenguranganTidakMakan = $this->M_hitungpesanan->getPesananPenguranganByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
              if (!empty($cekPesananPenguranganTidakMakan)) {
                $idPengurangan = $cekPesananPenguranganTidakMakan['0']['id_pengurangan'];
                $cekPesananPenguranganTidakMakanDetail = $this->M_hitungpesanan->getPesananPenguranganByIdPenguranganNoind($idPengurangan,$noind);
                if (empty($cekPesananPenguranganTidakMakanDetail)) {
                  $this->M_hitungpesanan->insertPesananPenguranganDetail($idPengurangan,$noind);
                }
              }
            }
          }
        }
        $this->M_hitungpesanan->updatePesananPenguranganTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'8');
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

    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

     // Rencana lembur yang belum ada absen di tempat makan
    $rencanaLembur = $this->M_hitungpesanan->getRencanaLemburShiftTigaNonAbsensiByTanggalLokasi($tanggal,$lokasi);
    if (!empty($rencanaLembur)) {
      foreach ($rencanaLembur as $rl) {
        $noind = $rl['noind'];
        $tempatMakan = $rl['tempat_makan'];
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
        $this->M_hitungpesanan->updatePesananTambahanTotalByTanggalShiftTempatMakanKategori($tanggal,$shift,$tempatMakan,'1');
      }
    }

    $jumlahPesananAwal = 0;
    $jumlahPesananStaff = 0;
    $jumlahPesananNonStaff = 0;
    $jumlahPesananTambahan = 0;
    $jumlahPesananPengurangan = 0;
    $jumlahPesananTotal = 0;

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

      /* dikomen dulu
      $data[$index]['tanggal']      = $tanggal;
      $data[$index]['tempat_makan'] = $tempatMakan;
      $data[$index]['staff']        = $jumlahPesananStaff;
      $data[$index]['nontsaff']     = $jumlahPesananNonStaff;
      $data[$index]['tambahan']     = $jumlahPesananTambahan;
      $data[$index]['pengurangan']  = $jumlahPesananPengurangan;
      $data[$index]['awal']         = $jumlahPesananAwal;
      $data[$index]['total']        = $jumlahPesananTotal;
      */

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

  function setTandaPesanan($tanggal,$shift,$lokasi,$detailPesananBelumDitandai,$jumlahPesanan,$jumlahKatering,$urutanJadwal){
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
             $insertUrutanKatering = array(
              'fd_tanggal' => $tanggal,
              'fs_kd_shift' => $shift,
              'fs_nama_katering' => $katering,
              'fn_urutan' => $index + 1,
              'lokasi' => $lokasi
            );
            $this->M_hitungpesanan->insertUrutanKatering($insertUrutanKatering);
          }

          $pembagian[$index]['fs_nama_katering'] = $katering;
          $pembagian[$index]['jumlah_total'] = $dp['fn_jumlah_pesan'];
          $pembagian[$index]['urutan'] = $index + 1;

          $jumlahSementara = $dp['fn_jumlah_pesan'];
          $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasiTempatMakan($pembagian[$index]['urutan'],$tanggal,$shift,$lokasi,$dp['fs_tempat_makan']);
          $index2++;
        }else{

          $pembagian[$index]['jumlah_total'] += $dp['fn_jumlah_pesan'];

          $jumlahSementara += $dp['fn_jumlah_pesan'];
          $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasiTempatMakan($pembagian[$index]['urutan'],$tanggal,$shift,$lokasi,$dp['fs_tempat_makan']);
          $index2++;
        }
      }      
    }
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

    $this->setTandaPesanan($tanggal,$shift,$lokasi,$detailPesananBelumDitandai,$jumlahPesanan,$jumlahKatering,$urutanJadwal);

    $this->M_hitungpesanan->updatePesananTandaBiggerThanByTanggalShiftLokasi($jumlahKatering,$tanggal,$shift,$lokasi);

    for ($i=0; $i < $jumlahKatering; $i++) { 
      $urutankatering = $this->M_hitungpesanan->geturutankateringByTanggalShiftLokasiUrutan($tanggal,$shift,$lokasi,($i + 1));
      if(!empty($urutankatering)){
        $katering = $urutankatering['0']['fs_nama_katering'];
      }else{
        $katering = $urutanJadwal[$i]['fs_nama_katering'];
        $insertUrutanKatering = array(
          'fd_tanggal' => $tanggal,
          'fs_kd_shift' => $shift,
          'fs_nama_katering' => $katering,
          'fn_urutan' => $i + 1,
          'lokasi' => $lokasi
        );
        $this->M_hitungpesanan->insertUrutanKatering($insertUrutanKatering);
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
    $data['tempat_makan_kemarin'] = $this->M_hitungpesanan->getTempatMakanKemarinBelumAda($tanggal,$shift,$lokasi);

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
            'fn_jumlah_pengurangan' => $value['fn_jumlah_pengurangan'],
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
            'fn_jumlah_pengurangan' => $value['fn_jumlah_pengurangan'],
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
            if ($nomor%4 == 1) {
              $isi .= "<tr>";
            }elseif ($nomor%4 == 4) {
              $isi .= "</tr>";
            }
            $isi .= "
            <td style='width: 25%;'>
              <table border='2' style='width: 100%;border: 2px solid black;'>
                <tr>
                  <td colspan='3' style='text-align: center;border-bottom: 2px solid black;font-weight: bold;font-size: 18pt;vertical-align: middle;height: 60px;'>
                    ".$data['tempat_makan']."
                  </td>
                </tr>
                <tr>
                  <td rowspan='4' style='text-align: center;font-weight: bold;font-size: 50pt;width: 220px;'>
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
      $data['daftar'] = "";
    }
      // echo "<pre>";print_r($data);exit();
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
          $sayur = "............................";
          $lauk_utama = "............................";
          $lauk_pendamping = "............................";
          $buah = "............................";
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

        if ($jenis == "0") {          
          $isi_header = "
          <table border=\"0\" style=\"width: 100%;border-collapse: collapse;border: 0px solid red;\">
            <tr>
              <td colspan=\"9\" rowspan=\"3\" style=\"width: 48%;font-size: 20pt;\">
                <b>Daftar Pesanan ".ucwords(strtolower($jenis_nama))."</b>
              </td>
              <td  style=\"width: 13%;border-left: 1px solid red;border-top: 1px solid red\">
                Snack
              </td>
              <td style=\"width: 2%;border-top: 1px solid red\">
                :
              </td>
              <td style=\"width: 37%;border-top: 1px solid red;border-right: 1px solid red\">
                ............................
              </td>
            </tr>
            <tr>
              <td style=\"border-left: 1px solid red;\">
                
              </td>
              <td>
                :
              </td>
              <td style=\"border-right: 1px solid red;\">
                ............................
              </td>
            </tr>
            <tr>
              <td style=\"border-left: 1px solid red;\">
                
              </td>
              <td>
                :
              </td>
              <td style=\"border-right: 1px solid red;\">
                ............................
              </td>
            </tr>
            <tr>
              <td style=\"width: 5%\">
                Lokasi
              </td>
              <td style=\"width: 1%\">
                :
              </td>
              <td style=\"width: 10%\">
                ".$lokasi_str."
              </td>
              <td style=\"width: 5%\">
                Tanggal
              </td>
              <td style=\"width: 1%\">
                :
              </td>
              <td style=\"width: 10%\">
                ".date('d M Y', strtotime($tanggal))."
              </td>
              <td style=\"width: 5%\">
                Shift
              </td>
              <td style=\"width: 1%\">
                :
              </td>
              <td style=\"width: 10%\">
                ".$shift_str."
              </td>
              <td style=\"border-left: 1px solid red;border-bottom: 1px solid red;\">
                
              </td>
              <td style=\"border-bottom: 1px solid red;\">
                :
              </td>
              <td style=\"border-bottom: 1px solid red;border-right: 1px solid red;\">
                ............................
              </td>
            </tr>
          </table>
          ";
        }else{
          $isi_header = "
          <table border=\"0\" style=\"width: 100%;border-collapse: collapse;border: 0px solid red;\">
            <tr>
              <td colspan=\"9\" rowspan=\"3\" style=\"width: 48%;font-size: 20pt;\">
                <b>Daftar Pesanan ".ucwords(strtolower($jenis_nama))."</b>
              </td>
              <td  style=\"width: 13%;border-left: 1px solid red;border-top: 1px solid red\">
                Sayur
              </td>
              <td style=\"width: 2%;border-top: 1px solid red\">
                :
              </td>
              <td style=\"width: 37%;border-top: 1px solid red;border-right: 1px solid red\">
                ".$sayur."
              </td>
            </tr>
            <tr>
              <td style=\"border-left: 1px solid red;\">
                Lauk Utama
              </td>
              <td>
                :
              </td>
              <td style=\"border-right: 1px solid red;\">
                ".$lauk_utama."
              </td>
            </tr>
            <tr>
              <td style=\"border-left: 1px solid red;\">
                Lauk Pendamping
              </td>
              <td>
                :
              </td>
              <td style=\"border-right: 1px solid red;\">
                ". $lauk_pendamping."
              </td>
            </tr>
            <tr>
              <td style=\"width: 5%\">
                Lokasi
              </td>
              <td style=\"width: 1%\">
                :
              </td>
              <td style=\"width: 10%\">
                ".$lokasi_str."
              </td>
              <td style=\"width: 5%\">
                Tanggal
              </td>
              <td style=\"width: 1%\">
                :
              </td>
              <td style=\"width: 10%\">
                ".date('d M Y', strtotime($tanggal))."
              </td>
              <td style=\"width: 5%\">
                Shift
              </td>
              <td style=\"width: 1%\">
                :
              </td>
              <td style=\"width: 10%\">
                ".$shift_str."
              </td>
              <td style=\"border-left: 1px solid red;border-bottom: 1px solid red;\">
                Buah
              </td>
              <td style=\"border-bottom: 1px solid red;\">
                :
              </td>
              <td style=\"border-bottom: 1px solid red;border-right: 1px solid red;\">
                ".$buah."
              </td>
            </tr>
          </table>
          ";
        }
        $isi = "";

        foreach ($pembagian as $bagi) {
          if ($isi !== "") {
            if ($jenis !== '0') {
              $isi .= "<div style=\"page-break-after: always\"></div>";
              $isi .= $isi_header;
            }
          }else{
            $isi .= $isi_header;
          }
          if ($jenis !== '0') {
            $isi .= "<table style=\"width: 100%\">
              <tr>
                <td style=\"width: 50%\">Nama Katering : ".$bagi['fs_nama_katering']."</td>
                <td style=\"width: 50%\">Nama ". ($lokasi == '2' ? "Pendamping Katering" : "Petugas GA") . " : ..................................................</td>
              </tr>
            </table>";
            $supplier = "Katering";
            if ($lokasi == "1") {
              $seksiPenerima = "Seksi GA";
            }else{
              $seksiPenerima = "Seksi Penerima";
            }
          }else{
            $isi .= "<table style=\"width: 100%\">
              <tr>
                <td style=\"width: 50%\">Nama Supplier : ..................................................</td>
                <td style=\"width: 50%\">Nama ". ($lokasi == '2' ? "Pendamping Katering" : "Petugas GA") . " : ..................................................</td>
              </tr>
            </table>";
            $supplier = "Supplier";
            $seksiPenerima = "Seksi GA";
          }
          $isi .= "<table border=\"1\" style=\"width: 100%;border-collapse: collapse;\">
          <thead>
            <tr>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 3%\">No.</th>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 20%\">Tempat Makan</th>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 5%\">Staff</th>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 5%\">Non Staff</th>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 5%\">Tambah</th>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 5%\">Kurang</th>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 5%\">Jumlah Pesanan</th>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 27%\">Keterangan</th>
              <th rowspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 5%\">Jumlah Dikirim</th>
              <th colspan=\"2\" style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 20%\">Tanda Tangan</th>
            </tr>
            <tr>
              <th style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 10%\">".$supplier."</th>
              <th style=\"text-align: center;font-weight: bold;border-right: 1px solid black;border-left: 1px solid black;border-top: 2px solid black;border-bottom: 2px solid black;width: 10%\">".$seksiPenerima."</th>
            </tr>
          </thead>";

          $nomor = 1;
          $khusus = 0;
          foreach ($bagi['data'] as $data_bagi) {
            if ($data_bagi['pengurangan'] !== "0" && $data_bagi['tambahan'] !== "0") {
              $warna = "green";
            }elseif ($data_bagi['pengurangan'] !== "0") {
              $warna = "red";
            }elseif ($data_bagi['tambahan'] !== "0") {
              $warna = "blue";
            }else{
              $warna = "black";
            }

          
            $keterangan = "";
            $sayur_arr = explode(",", $sayur);
            $lauk_utama_arr = explode(",", $lauk_utama);
            $lauk_pendamping_arr = explode(",", $lauk_pendamping);
            $buah_arr = explode(",", $buah);

            $filter_sayur = "";
            foreach ($sayur_arr as $sar) {
              if ($filter_sayur == "") {
                $filter_sayur = "'".$sar."'";
              }else{
                $filter_sayur .= ",'".$sar."'";
              }
            }
            if ($filter_sayur !== "") {
              $filter = "lower(tpmk.menu_sayur) in (".strtolower($filter_sayur).")";
            }

            $filter_lauk_utama = "";
            foreach ($lauk_utama_arr as $luar) {
              if ($filter_lauk_utama == "") {
                $filter_lauk_utama = "'".$luar."'";
              }else{
                $filter_lauk_utama .= ",'".$luar."'";
              }
            }
            if ($filter_lauk_utama !== "") {
              if ($filter == "") {
                $filter = "lower(tpmk.menu_lauk_utama) in (".strtolower($filter_lauk_utama).")";
              }else{
                $filter .= " or lower(tpmk.menu_lauk_utama) in (".strtolower($filter_lauk_utama).")";
              }
            }
            $filter_lauk_pendamping = "";
            foreach ($lauk_pendamping_arr as $lpar) {
              if ($filter_lauk_pendamping == "") {
                $filter_lauk_pendamping = "'".$lpar."'";
              }else{
                $filter_lauk_pendamping .= ",'".$lpar."'";
              }
            }
            if ($filter_lauk_pendamping !== "") {
              if ($filter == "") {
                $filter = "lower(tpmk.menu_lauk_pendamping) in (".strtolower($filter_lauk_pendamping).")";
              }else{
                $filter .= " or lower(tpmk.menu_lauk_pendamping) in (".strtolower($filter_lauk_pendamping).")";
              }
            }
            $filter_buah = "";
            foreach ($buah_arr as $bar) {
              if ($filter_buah == "") {
                $filter_buah = "'".$bar."'";
              }else{
                $filter_buah .= ",'".$bar."'";
              }
            }
            if ($filter_buah !== "") {
              if ($filter == "") {
                $filter = "lower(tpmk.menu_buah) in (".strtolower($filter_buah).")";
              }else{
                $filter .= " or lower(tpmk.menu_buah) in (".strtolower($filter_buah).")";
              }
            }
            $simpanSayur = array();
            $simpanLaukUtama = array();
            $simpanLaukPendamping = array();
            $simpanBuah = array();
            $simpanNoindNama = "";
            $menuPengganti = $this->M_hitungpesanan->getMenuPenggantiByTanggalShiftLokasiTempatMakan($tanggal,$shift,$lokasi,$data_bagi['tempat_makan']," and (".$filter.")");
            if (!empty($menuPengganti)) {
              $simpanNoind = "";
              foreach ($menuPengganti as $mp) {
                if ($simpanNoind !== $mp['noind']) {
                  if ($simpanNoindNama !== "") {
                    if (!empty($simpanSayur) || !empty($simpanLaukUtama) || !empty($simpanLaukPendamping) || !empty($simpanBuah)) {
                      if ($keterangan == "") {
                        $keterangan = "";
                      }else{
                        $keterangan .= "<br>";
                      }
                      $keterangan .= $simpanNoindNama;
                      if (!empty($simpanSayur)) {
                        $keterangan .= " <span style='color: red'>/</span>Sayur : ".implode(",", $simpanSayur);  
                      }
                      if (!empty($simpanLaukUtama)) {
                        $keterangan .= " <span style='color: red'>/</span>Lauk utama : ".implode(",", $simpanLaukUtama);
                      }
                      if (!empty($simpanLaukPendamping)) {
                        $keterangan .= " <span style='color: red'>/</span>Lauk Pendamping : ".implode(",", $simpanLaukPendamping);
                      }
                      if (!empty($simpanBuah)) {
                        $keterangan .= " <span style='color: red'>/</span>Buah : ".implode(",", $simpanBuah);
                      }
                      $keterangan .= " )";
                    }
                  }
                  $simpanSayur = array();
                  $simpanLaukUtama = array();
                  $simpanLaukPendamping = array();
                  $simpanBuah = array();
                  $simpanNoindNama = "-&nbsp;".$mp['noind']." - ".ucwords(strtolower($mp['nama']))." ( ";
                  $khusus++;
                }
                foreach ($sayur_arr as $sar) {
                  if (strtolower($sar) == strtolower($mp['menu_sayur']) && !in_array(strtolower($mp['pengganti_sayur']), $simpanSayur)) {
                    $simpanSayur[] = strtolower($mp['pengganti_sayur']);
                  }elseif (strtolower($mp['menu_sayur']) != strtolower($mp['pengganti_sayur']) && !in_array(strtolower($mp['pengganti_sayur']), $simpanSayur) && strtolower($mp['menu_sayur']) == 'semua sayur') {
                    $simpanSayur[] = strtolower($mp['pengganti_sayur']);
                  }
                }
                foreach ($lauk_utama_arr as $luar) {
                  if (strtolower($luar) == strtolower($mp['menu_lauk_utama']) && !in_array(strtolower($mp['pengganti_lauk_utama']), $simpanLaukUtama)) {
                    $simpanLaukUtama[] = strtolower($mp['pengganti_lauk_utama']);
                  }elseif (strtolower($mp['menu_lauk_utama']) != strtolower($mp['pengganti_lauk_utama']) && !in_array(strtolower($mp['pengganti_lauk_utama']), $simpanLaukUtama) && strtolower($mp['menu_lauk_utama']) == 'semua lauk utama') {
                    $simpanLaukUtama[] = strtolower($mp['pengganti_lauk_utama']);
                  }
                }
                foreach ($lauk_pendamping_arr as $lpar) {
                  if (strtolower($lpar) == strtolower($mp['menu_lauk_pendamping']) && !in_array(strtolower($mp['pengganti_lauk_pendamping']), $simpanLaukPendamping)) {
                    $simpanLaukPendamping[] = strtolower($mp['pengganti_lauk_pendamping']);
                  }elseif (strtolower($mp['menu_lauk_pendamping']) != strtolower($mp['pengganti_lauk_pendamping']) && !in_array(strtolower($mp['pengganti_lauk_pendamping']), $simpanLaukPendamping) && strtolower($mp['menu_lauk_pendamping']) == 'semua lauk pendamping') {
                    $simpanLaukPendamping[] = strtolower($mp['pengganti_lauk_pendamping']);
                  }
                }
                foreach ($buah_arr as $bar) {
                  if (strtolower($bar) == strtolower($mp['menu_buah']) && !in_array(strtolower($mp['pengganti_buah']), $simpanBuah)) {
                    $simpanBuah[] = strtolower($mp['pengganti_buah']);
                  }elseif (strtolower($mp['menu_buah']) != strtolower($mp['pengganti_buah']) && !in_array(strtolower($mp['pengganti_buah']), $simpanBuah) && strtolower($mp['menu_buah']) == 'semua buah') {
                    $simpanBuah[] = strtolower($mp['pengganti_buah']);
                  }
                }
                $simpanNoind = $mp['noind'];
              }
            }
          
            if (!empty($simpanSayur) || !empty($simpanLaukUtama) || !empty($simpanLaukPendamping) || !empty($simpanBuah)) {
              if ($keterangan == "") {
                $keterangan = "";
              }else{
                $keterangan .= "<br>";
              }
              $keterangan .= $simpanNoindNama;
              if (!empty($simpanSayur)) {
                $keterangan .= " <span style='color: red'>/</span>Sayur : ".implode(",", $simpanSayur);
              }
              if (!empty($simpanLaukUtama)) {
                $keterangan .= " <span style='color: red'>/</span>Lauk utama : ".implode(",", $simpanLaukUtama);
              }
              if (!empty($simpanLaukPendamping)) {
                $keterangan .= " <span style='color: red'>/</span>Lauk Pendamping : ".implode(",", $simpanLaukPendamping);
              }
              if (!empty($simpanBuah)) {
                $keterangan .= " <span style='color: red'>/</span>Buah : ".implode(",", $simpanBuah);
              }
              $keterangan .= " )";
            }
            $isi .= "<tr data-urutan=\"".$bagi['urutan']."\" data-katering=\"".$data_bagi['tempat_makan']."\" style=\"page-break-inside: avoid\">
              <td style=\"text-align: center;color: ".$warna."\">".$nomor."</td>
              <td style=\"text-align: left;padding-left: 5px;color: ".$warna."\">".$data_bagi['tempat_makan']."</td>
              <td style=\"text-align: right;padding-right: 5px;color: ".$warna."\">".$data_bagi['staff']."</td>
              <td style=\"text-align: right;padding-right: 5px;color: ".$warna."\">".$data_bagi['nonstaff']."</td>
              <td style=\"text-align: right;padding-right: 5px;color: ".$warna."\">".$data_bagi['tambahan']."</td>
              <td style=\"text-align: right;padding-right: 5px;color: ".$warna."\">".$data_bagi['pengurangan']."</td>
              <td style=\"text-align: right;padding-right: 5px;color: ".$warna."\">".$data_bagi['jumlah_pesan']."</td>
              <td>".$keterangan."</td>
              <td style=\"text-align: right;padding-right: 5px;color: ".$warna."\">........</td>
              <td style=\"text-align: ".($nomor%2 == 0 ? "right" : "left").";padding-right: 5px;padding-left: 5px;color: ".$warna."\"><sup style\"font-size: 5pt;\">".$nomor."</sup>.............</td>
              <td style=\"text-align: ".($nomor%2 == 0 ? "right" : "left").";padding-right: 5px;padding-left: 5px;color: ".$warna."\"><sup style\"font-size: 5pt;\">".$nomor."</sup>.............</td>
            </tr>";

            $nomor++;
          }
          $isi .= "<tr>
            <td colspan=\"6\" style=\"text-align: right;padding-right: 5px;\">Total : </td>
            <td style=\"text-align: right;padding-right: 5px;\">".$bagi['jumlah_total']."</td>
            <td style=\"text-align: right;padding-right: 5px;\">".($khusus <> 0 ? $khusus : "" )."</td>
            <td style=\"text-align: right;padding-right: 5px;\"></td>
            <td style=\"text-align: right;padding-right: 5px;\"></td>
            <td style=\"text-align: right;padding-right: 5px;\"></td>
          </tr>
          <tr>
            <td colspan=\"6\" style=\"text-align: right;padding-right: 5px;\">Sampel : </td>
            <td style=\"text-align: right;padding-right: 5px;\"></td>
            <td style=\"text-align: right;padding-right: 5px;\"></td>
            <td style=\"text-align: right;padding-right: 5px;\"></td>
            <td style=\"text-align: right;padding-right: 5px;\"></td>
            <td style=\"text-align: right;padding-right: 5px;\"></td>
          </tr>
          </table>";
          $isi_footer = "
          <table style=\"width: 100%\">
            <tr>
              <td style=\"color: blue;width: 33%;border-bottom: 1px solid blue;\">
                ■ Ada Penambahan
              </td>
              <td style=\"color: red;width: 33%;border-bottom: 1px solid red;\">
                ■ Ada Pengurangan
              </td>
              <td style=\"color: green;width: 33%;border-bottom: 1px solid green;\">
                ■ Ada Penambahan dan Pengurangan
              </td>
            </tr>
          </table>";
          $isi .= $isi_footer;
          if ($jenis !== "0") {
            if (substr($this->session->kodesie,-2) != '00') {
              $jabatan = "Admin";
            }else{
              $jabatan = "Kepala Seksi";
            }
            $isi .= "<table style=\"width: 100%\">
              <tr>
                <td style=\"width: 70%\">&nbsp;</td>
                <td style=\"text-align: center;width: 30%\">Mengetahui,</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td style=\"text-align: center\">$jabatan General Affair</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td style=\"text-align: center\">".$this->session->employee."</td>
              </tr>
            </table>";
          }

        }

        if ($jenis !== '0') {
          $data['daftar'] = $isi;
        }else{
          $data['daftar'] = $data['daftar']."<div style=\"page-break-after: always\"></div>".$isi;
        }
      }else{
        $data['daftar'] = $data['daftar'];
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

    $this->load->library('pdf');

    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8', 'A4-L', 8, '', 5, 5, 5, 15, 5, 5, 'P');
    $filename = 'PESANAN_'.$jenis_nama.'_'.$tanggal.'_'.$shift.'_'.$lokasi.'.pdf';
    // echo "<pre>";print_r($_SESSION);exit();
    // $this->load->view('CateringManagement/HitungPesanan/V_pdf', $data);
    $html = $this->load->view('CateringManagement/HitungPesanan/V_pdf', $data, true);
    $pdf->SetHTMLFooter("<table style=\"width: 100%\"><tr><td><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh ".$this->session->user." - ".$this->session->employee." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S')."</i></td><td rowspan=\"2\" style=\"vertical-align: middle; text-align: right\">Mengetahui,<br>(..........)<br>".$this->session->user." - ".$this->session->employee."</td></tr><tr><td>Halaman {PAGENO} dari {nb}</td></tr></table>");
    $pdf->WriteHTML($html, 2);
    // $pdf->Output($filename, 'D');
    $pdf->Output($filename, 'I');
  }

  public function cetakFormPesananMakan(){
    $tanggal = $this->input->get('tanggal');
    $shift = $this->input->get('shift');
    $lokasi = $this->input->get('lokasi');
    $jenis = $this->input->get('jenis');
    
    $pembagian = $this->getpesananList($tanggal,$shift,$lokasi);

    $data = array();
    
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
        $shift_str = "1 DAN UMUM";
      }elseif ($shift == "2") {
        $shift_str = "2";
      }elseif ($shift == "3") {
        $shift_str = "3";
      }else{
        $shift_str = "tidak diketahui";
      }

      
      $isi = "";

      foreach ($pembagian as $bagi) {
        $isi .= "
        <table style=\"width: 100%;\">
          <tr>
            <td colspan=\"3\" style=\"font-weight: bold;\">
              DEPARTEMEN PERSONALIA<br>CV. KARYA HIDUP SENTOSA<br>YOGYAKARTA
            </td>
            <td colspan=\"3\" style=\"font-weight: bold;\">
              DEPARTEMEN PERSONALIA<br>CV. KARYA HIDUP SENTOSA<br>YOGYAKARTA
            </td>
          </tr>
          <tr>
            <td colspan=\"3\" style=\"text-align: center;font-weight: bold;\">
              PESANAN MAKAN PEKERJA
            </td>
            <td colspan=\"3\" style=\"text-align: center;font-weight: bold;\">
              PESANAN MAKAN PEKERJA
            </td>
          </tr>
          <tr>
            <td style=\"width: 15%;\">NAMA KATERING</td>
            <td style=\"width: 2%;\">:</td>
            <td style=\"width: 33%;\">".$bagi['fs_nama_katering']."</td>
            <td style=\"width: 15%;\">NAMA KATERING</td>
            <td style=\"width: 2%;\">:</td>
            <td style=\"width: 33%;\">".$bagi['fs_nama_katering']."</td>
          </tr>
          <tr>
            <td>HARI/TANGGAL</td>
            <td>:</td>
            <td>".strftime("%A, %d %B %Y",strtotime($tanggal))."</td>
            <td>HARI/TANGGAL</td>
            <td>:</td>
            <td>".strftime("%A, %d %B %Y",strtotime($tanggal))."</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>JUMLAH PESANAN</td>
            <td>:</td>
            <td>".$bagi['jumlah_total']."</td>
            <td>JUMLAH PESANAN</td>
            <td>:</td>
            <td>".$bagi['jumlah_total']."</td>
          </tr>
          <tr>
            <td colspan=\"3\">
              PESANAN MAKAN PEKERJA SHIFT ".$shift_str."
            </td>
            <td colspan=\"3\">
              PESANAN MAKAN PEKERJA SHIFT ".$shift_str."
            </td>
          </tr>
          <tr>
            <td colspan=\"3\">
              <table style=\"width: 100%;\">
                <tr>
                  <td style=\"text-align: center;width: 50%;\">
                    PEMESAN
                  </td>
                  <td style=\"text-align: center;width: 50%;\">
                    MENGETAHUI<br>KOORDINATOR
                  </td>
                </tr>
                <tr>
                  <td style=\"text-align: center;width: 50%;\">
                   &nbsp;
                  </td>
                  <td style=\"text-align: center;width: 50%;\">
                    
                  </td>
                </tr>
                <tr>
                  <td style=\"text-align: center;width: 50%;\">
                   &nbsp;
                  </td>
                  <td style=\"text-align: center;width: 50%;\">
                    
                  </td>
                </tr>
                <tr>
                  <td style=\"text-align: center;width: 50%;\">
                    ..............
                  </td>
                  <td style=\"text-align: center;width: 50%;\">
                    ..............
                  </td>
                </tr>
              </table>
            </td>
            <td colspan=\"3\">
              <table style=\"width: 100%;\">
                <tr>
                  <td style=\"text-align: center;width: 50%;\">
                    PEMESAN
                  </td>
                  <td style=\"text-align: center;width: 50%;\">
                    MENGETAHUI<br>KOORDINATOR
                  </td>
                </tr>
                <tr>
                  <td style=\"text-align: center;width: 50%;\">
                   &nbsp;
                  </td>
                  <td style=\"text-align: center;width: 50%;\">
                    
                  </td>
                </tr>
                <tr>
                  <td style=\"text-align: center;width: 50%;\">
                   &nbsp;
                  </td>
                  <td style=\"text-align: center;width: 50%;\">
                    
                  </td>
                </tr>
                <tr>
                  <td style=\"text-align: center;width: 50%;\">
                    ..............
                  </td>
                  <td style=\"text-align: center;width: 50%;\">
                    ..............
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <hr>";
      }

      $data['daftar'] = $isi;
    }else{
      $data['daftar'] = $data['daftar'];
    }

    $data_log = array(
      'wkt' => date('Y-m-d H:i:s'),
      'menu' => 'HITUNG PESANAN',
      'ket' => 'TGL: '.$tanggal.' SHIFT: '.$shift.' LOKASI: '.$lokasi,
      'noind' => $this->session->user,
      'jenis' => 'CETAK FORM PESANAN MAKAN',
      'program' => 'CATERING MANAGEMENT ERP'
    );
    $this->M_hitungpesanan->insertTlog($data_log);
    // echo $data['daftar'];exit();

    $this->load->library('pdf');

    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 5, 15, 5, 5, 'P');
    $filename = 'FORM_PESANAN_MAKAN_'.$tanggal.'_'.$shift.'_'.$lokasi.'.pdf';
    // echo "<pre>";print_r($data['PrintppDetail']);exit();
    // $this->load->view('CateringManagement/HitungPesanan/V_pdf', $data);
    $html = $this->load->view('CateringManagement/HitungPesanan/V_pdf', $data, true);
    $pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh ".$this->session->user." - ".$this->session->employee." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". <br>Halaman {PAGENO} dari {nb}</i>");
    $pdf->WriteHTML($html, 2);
    // $pdf->Output($filename, 'D');
    $pdf->Output($filename, 'I');
  }

  public function simpanDetail($tanggal,$shift,$lokasi,$jenis){
    $this->M_hitungpesanan->deletePesananDetailByTanggalShiftLokasi($tanggal,$shift,$lokasi,$jenis);

    $tambahan = $this->M_hitungpesanan->getPesananTambahanDetailByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    if (!empty($tambahan)) {
      foreach ($tambahan as $tmb) {
        $keterangan = "";
        if ($tmb['fb_kategori'] == "1") {
          $keterangan = "LEMBUR";
        }elseif ($tmb['fb_kategori'] == "2") {
          $keterangan = "SHIFT TANGGUNG";
        }elseif ($tmb['fb_kategori'] == "3") {
          $keterangan = "TUGAS KE PUSAT";
        }elseif ($tmb['fb_kategori'] == "4") {
          $keterangan = "TUGAS KE TUKSONO";
        }elseif ($tmb['fb_kategori'] == "5") {
          $keterangan = "TUGAS KE MLATI";
        }elseif ($tmb['fb_kategori'] == "6") {
          $keterangan = "TAMU";
        }elseif ($tmb['fb_kategori'] == "7") {
          $keterangan = "CADANGAN";
        }
        $data_insert = array(
          'tanggal' => $tanggal,
          'shift' => $shift,
          'lokasi' => $lokasi,
          'tempat_makan' => $tmb['fs_tempat_makan'],
          'noind' => $tmb['fs_noind'],
          'keterangan' => 'TAMBAHAN - '.$keterangan,
          'created_by' => $this->session->user,
          'jenis' => $jenis
        );
        $this->M_hitungpesanan->insertPesananDetail($data_insert);
      }
    }

    $pengurangan = $this->M_hitungpesanan->getPesananPenguranganDetailByTanggalShiftLokasi($tanggal,$shift,$lokasi);
    if (!empty($pengurangan)) {
      foreach ($pengurangan as $png) {
        $keterangan = "";
        if ($png['fb_kategori'] == "1") {
          $keterangan = "TIDAK MAKAN ( GANTI UANG )";
        }elseif ($png['fb_kategori'] == "2") {
          $keterangan = "PINDAH MAKAN";
          $data_insert = array(
            'tanggal' => $tanggal,
            'shift' => $shift,
            'lokasi' => $png['fs_lokasipg'],
            'tempat_makan' => $png['fs_tempat_makanpg'],
            'noind' => $png['fs_noind'],
            'keterangan' => 'TAMBAHAN - '.$keterangan,
            'created_by' => $this->session->user,
            'jenis' => $jenis
          );
          $this->M_hitungpesanan->insertPesananDetail($data_insert);
        }elseif ($png['fb_kategori'] == "3") {
          $keterangan = "TUGAS KE PUSAT";
        }elseif ($png['fb_kategori'] == "4") {
          $keterangan = "TUGAS KE TUKSONO";
        }elseif ($png['fb_kategori'] == "5") {
          $keterangan = "TUGAS KE MLATI";
        }elseif ($png['fb_kategori'] == "6") {
          $keterangan = "TUGAS LUAR";
        }elseif ($png['fb_kategori'] == "7") {
          $keterangan = "DINAS PERUSAHAAN ( KUNJUNGAN KERJA / LAYAT / DLL )";
        }elseif ($png['fb_kategori'] == "8") {
          $keterangan = "TIDAK MAKAN ( TIDAK DIGANTI UANG )";
        }
        $data_insert = array(
          'tanggal' => $tanggal,
          'shift' => $shift,
          'lokasi' => $lokasi,
          'tempat_makan' => $png['fs_tempat_makan'],
          'noind' => $png['fs_noind'],
          'keterangan' => 'PENGURANGAN - '.$keterangan,
          'created_by' => $this->session->user,
          'jenis' => $jenis
        );
        $this->M_hitungpesanan->insertPesananDetail($data_insert);
      }
    }

    if ($shift == '1') {
      $absen = $this->M_hitungpesanan->getAbsenShiftSatuDetailByTanggalLokasi($tanggal,$lokasi,$jenis);
      if (!empty($absen)) {
        foreach ($absen as $abs) {
          $data_insert = array(
            'tanggal' => $tanggal,
            'shift' => $shift,
            'lokasi' => $lokasi,
            'tempat_makan' => $abs['tempat_makan'],
            'noind' => $abs['noind'],
            'keterangan' => strtoupper($abs['keterangan']),
            'created_by' => $this->session->user,
            'jenis' => $jenis
          );
          $this->M_hitungpesanan->insertPesananDetail($data_insert);
        }
      }
    }elseif($shift == '2'){
      $absen = $this->M_hitungpesanan->getAbsenShiftDuaDetailByTanggalLokasi($tanggal,$lokasi,$jenis);
      if (!empty($absen)) {
        foreach ($absen as $abs) {
          $data_insert = array(
            'tanggal' => $tanggal,
            'shift' => $shift,
            'lokasi' => $lokasi,
            'tempat_makan' => $abs['tempat_makan'],
            'noind' => $abs['noind'],
            'keterangan' => strtoupper($abs['keterangan']),
            'created_by' => $this->session->user,
            'jenis' => $jenis
          );
          $this->M_hitungpesanan->insertPesananDetail($data_insert);
        }
      }
    }elseif ($shift == '3') {
      $absen = $this->M_hitungpesanan->getAbsenShiftTigaDetailByTanggalLokasi($tanggal,$lokasi);
      if (!empty($absen)) {
        foreach ($absen as $abs) {
          $data_insert = array(
            'tanggal' => $tanggal,
            'shift' => $shift,
            'lokasi' => $lokasi,
            'tempat_makan' => $abs['tempat_makan'],
            'noind' => $abs['noind'],
            'keterangan' => strtoupper($abs['keterangan']),
            'created_by' => $this->session->user,
            'jenis' => $jenis
          );
          $this->M_hitungpesanan->insertPesananDetail($data_insert);
        }
      }
    }
  }

}

?>