<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Master extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->library('form_validation');
    $this->load->library('Excel');
    //load the login model
    $this->load->library('session');
    $this->load->library('ciqrcode');
    $this->load->model('M_Index');
    $this->load->library('upload');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    //local
    $this->load->model('MonitoringGudangCustomable/M_mgc');

    date_default_timezone_set('Asia/Jakarta');

    if ($this->session->userdata('logged_in') != true) {
      $this->load->helper('url');
      $this->session->set_userdata('last_page', current_url());
      $this->session->set_userdata('Responsbility', 'some_value');
    }
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
    } else {
      redirect();
    }
  }


  //------------------------show the dashboard-----------------------------
  public function index()
  {
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MonitoringGudangCustomable/V_Index');
    $this->load->view('V_Footer', $data);
  }


// --------------------------Monitoring Menu-----------------------------
  public function Monitoring()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $data['data_range'] = $this->M_mgc->data_range();

    // echo "<pre>";
    // print_r($data['data_range']);
    //  die;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MonitoringGudangCustomable/V_Monitoring');
    $this->load->view('V_Footer', $data);
  }

// --------------------------Menampilkan Table-----------------------------
  public function getmaster()
  {
    $data['plan'] = $this->input->post('planid');    
    $data['get'] = $this->M_mgc->get();

    $this->load->view('MonitoringGudangCustomable/ajax/V_ajax', $data);
  }

// --------------------------Menampilkan Isi Column POD-----------------------------
  public function getpod()
  {
    $plan = $this->input->post('plan_id');
    $organization_id = $this->input->post('organization_id');
    $inventory_item_id = $this->input->post('inventory_item_id');

    $pod = $this->M_mgc->getpod($plan, $organization_id, $inventory_item_id);
    echo json_encode($pod);
  }

// --------------------------Menampilkan Isi Column AKTUAL_OUT-----------------------------
  public function getout()
    {
    $organization_id = $this->input->post('organization_id');
    $inventory_item_id = $this->input->post('inventory_item_id');

    $out = $this->M_mgc->getout($organization_id, $inventory_item_id);
    echo json_encode($out);

    // echo "<pre>";
    // print_r($inventory_item_id);
    // die;
  }
  public function getin()
  {
    $organization_id = $this->input->post('organization_id');
    $inventory_item_id = $this->input->post('inventory_item_id');

    $in = $this->M_mgc->getin($organization_id, $inventory_item_id);
    echo json_encode($in);
  }
}
