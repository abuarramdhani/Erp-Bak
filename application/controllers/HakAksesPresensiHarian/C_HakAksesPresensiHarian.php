<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '-1');

class C_HakAksesPresensiHarian extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->checkSession();
    $this->load->library('General');
    $this->load->model('HakAksesPresensiHarian/M_HakAksesPresensiHarian');
  }

  public function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('');
    }
  }
  public function index()
  {
    // $user = $this->session->user;
    // $aksesPekerja = ['F2365', 'B0898'];


    // if (!in_array($user, $aksesPekerja)) {
    //   $this->session->set_flashdata('swal', "swal.fire({
    //     title: \"Warning\",
    //     text: \"Anda Tidak Berhak Mengakses Halaman Ini\",
    //     timer: 2000,
    //     type: \"warning\",
    //     showCancelButton: false,
    //     showConfirmButton: false
    //   })");
    //   redirect('');
    // }
    $data  = $this->general->loadHeaderandSidemenu('Hak Akses Presensi Harian', 'Hak Akses Presensi Harian', 'Hak Akses', '', '');

    $data['akses'] = $this->M_HakAksesPresensiHarian->getAksesUser();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('HakAksesPresensiHarian/V_HakAksesPresensiHarian', $data);
    $this->load->view('V_Footer', $data);
  }
  // Getting Data
  public function getNoind()
  {
    $data = $this->M_HakAksesPresensiHarian->getNoind();
    echo json_encode($data);
  }
  // Showing Data
  public function showAkses()
  {
    $noind = $_GET['noind'];
    $data = $this->M_HakAksesPresensiHarian->getHakAkses($noind);
    echo json_encode($data);
  }
  public function showPekerja()
  {
    $key = strtoupper($_GET['key']);
    $data = $this->M_HakAksesPresensiHarian->getDataPekerja($key);
    echo json_encode($data);
  }
  public function showSeksi()
  {
    $key = strtoupper($_GET['key']);
    $data = $this->M_HakAksesPresensiHarian->getDataSeksi($key);
    echo json_encode($data);
  }
  // Giving Data
  public function addAkses()
  {
    $noind = $_POST['noind'];
    $kodesie = json_decode($_POST['kodesie']);
    $this->M_HakAksesPresensiHarian->addAksesPekerja($noind, $kodesie);
    echo true;
  }
  // Remove Data
  public function deleteAkses()
  {
    $noind = $_POST['noind'];
    var_dump($noind);
    $this->M_HakAksesPresensiHarian->deleteAksesPekerja($noind);
  }
}
