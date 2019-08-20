<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class C_Approval extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('CateringManagement/Pesanan/M_pesanan');

    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('index');
    }
  }

  public function index()
  {
    $user = $this->session->username;
    $user_id = $this->session->userid;
    $today = date('Y-m-d');

    $data['Title'] = 'Approval Tambahan';
    $data['Menu'] = 'Approval Tambahan';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $this->M_pesanan->updateStatus($today);

    $base = base_url();
    if (empty($data['UserMenu'])) {
      header("location: $base ");
    }

    $data['today'] = date("d M Y");
		$data['tambahan'] = $this->M_pesanan->ambilTambahanKatering($today);
    $data['ambilapprove'] = $this->M_pesanan->ambilapprove($today);
    $data['dataTambahan'] = $this->M_pesanan->dataTambahan($today);
    if (empty($data['ambilapprove'])) {
      // code...
    }else {
      $explod = explode(" ",$data['ambilapprove']['0']['keterangan']);
      $data['ket'] = implode(", ", $explod);
    }
    $data['user'] = $this->session->user;
    $data['sie'] = $this->M_pesanan->getNamaSie();
    $data['hidden'] = '';
    if($data['user'] != 'J1256'){
      $data['hidden'] = 'hidden';
    }

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
    $this->load->view('CateringManagement/V_approval');
		$this->load->view('V_Footer',$data);
  }

  public function Detail()
  {
    $id = $_POST['id'];
    $data = $this->M_pesanan->ambildetail($id);
    $getSeksi = $this->M_pesanan->getSeksi($data['0']['kodesie']);
    $data['0']['seksi'] = $getSeksi;
    echo json_encode($data);
  }

  public function Approval()
  {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $setuju = $this->M_pesanan->updateapproval($id, $status);

    $today = date('Y-m-d');
    $kd_shift = $_POST['Shift_Tambahan'];
    $lokasi = $_POST['lokasi_kerja'];
    $tempat_makan = $_POST['tempat_makan'];
    $tambahan = $_POST['plus'];
    $kurang = $_POST['min'];

    $pesanan = $this->M_pesanan->ambilPesananHariIni($today);

    if (!empty($tambahan)) {
      $tambahkurang = $pesanan[0]['jml_bukan_shift']+$tambahan;
      $jmltotal = $pesanan[0]['jml_total']+$tambahan;
    }else {
      $tambahkurang = $pesanan[0]['jml_bukan_shift']-$kurang;
      $jmltotal = $pesanan[0]['jml_total']-$kurang;
    }

		$this->M_pesanan->editTotalPesanan($jmltotal, $today, $kd_shift, $tempat_makan, $tambahkurang);
  }

}

?>
