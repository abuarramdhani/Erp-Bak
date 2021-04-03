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
    $this->load->model('TransaksiCuttingTool/M_tct');

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
    $this->load->view('TransaksiCuttingTool/V_Index');
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

    $data['get_transact_type'] = $this->M_tct->getTransactType();

    // echo "<pre>";
    // print_r($data['get']);
    // die;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('TransaksiCuttingTool/V_Monitoring');
    $this->load->view('V_Footer', $data);
  }

  // public function getmaster()
  // {
  //   $data['get'] = $this->M_tct->get();
  //
  //   $this->load->view('TransaksiCuttingTool/ajax/V_ajax', $data);
  // }

  public function getFilter()
  {
    $range_tanggal = $this->input->post('range_tanggal');
    $no_bppbgt = $this->input->post('no_bppbgt');
    $seksi = $this->input->post('seksi');
    $mesin = $this->input->post('mesin');
    $trans_type = $this->input->post('trans_type');

    $data['get_filter'] = $this->M_tct->getFilter($range_tanggal, $no_bppbgt, $seksi, $mesin, $trans_type);

    if (empty($range_tanggal)) {
      echo 0;
    }else {
      if (!empty($data['get_filter'])) {
        $this->load->view('TransaksiCuttingTool/ajax/V_ajax', $data);
      }else {
        echo 10;
      }
    }
  }

  public function getBppbgt()
  {
    $param = $this->input->post('term');
    $data = $this->M_tct->getBppbgt($param);
    echo json_encode($data);
  }

  public function getSm()
  {
    $bppbgt = $this->input->post('bppbgt');
    $sm = $this->M_tct->getSm($bppbgt);
    echo json_encode($sm);
  }
}
