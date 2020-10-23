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
    $this->load->model('MOTerlambatTransact/M_mtt');

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
    $this->load->view('MOTerlambatTransact/V_Index');
    $this->load->view('V_Footer', $data);
  }

  public function detail()
  {
    if (!$this->input->is_ajax_request()) {
      echo "Akses terlarang!";
    } else {
      $data['line_id'] = $this->input->post('line_id');
      $data['alasan'] = $this->M_mtt->getByLineID($data['line_id']);
      $this->load->view('MOTerlambatTransact/ajax/V_Detail', $data);
    }
  }

  public function Update()
  {
    if (!$this->input->is_ajax_request()) {
      echo "Akses terlarang!";
    } else {
      $line_id = $this->input->post('line_id');
      $alasan = strtoupper($this->input->post('alasan'));

      $user_id = $this->session->user;
      $nama = $this->session->employee;
      $namanya = $user_id . ' - ' . $nama;

      $res = $this->M_mtt->Update($alasan, $namanya, $line_id);
      echo json_encode($res);
      // echo json_encode(0);
    }
  }

  public function Monitoring()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $data['get'] = $this->M_mtt->get();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MOTerlambatTransact/V_History');
    $this->load->view('V_Footer', $data);
  }

  public function Record()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $data['get'] = $this->M_mtt->getRecord();

    echo "<pre>";
    print_r($data['get']);
    exit();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MOTerlambatTransact/V_Record');
    $this->load->view('V_Footer', $data);
  }


  // ============================ CHECK AREA =====================================

  public function cekapi()
  {
    $data_a = $this->M_mtt->get();
    echo "<pre>";
    print_r($data_a);
    echo sizeof($data_a);
    die;
  }
}
