<?php 
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
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
          $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasiTempatMakan($pembagian[$index]['urutan'],$tanggal,$shift,$lokasi,$dp['fd_tanggal']);
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
          $this->M_hitungpesanan->updatePesananTandaByTanggalShiftLokasiTempatMakan($pembagian[$index]['urutan'],$tanggal,$shift,$lokasi,$dp['fd_tanggal']);
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

  
}

?>