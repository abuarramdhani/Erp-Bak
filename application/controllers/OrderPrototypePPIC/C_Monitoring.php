<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
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
        $this->load->model('OrderPrototypePPIC/M_master');

        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('logged_in')!=true) {
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

        $data['Menu'] = 'Monitoring';
        $data['SubMenuOne'] = '';

        $menu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        // $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        // $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        // echo "<pre>";print_r($data['UserMenu']);die;
        if ($this->session->user === 'T0012' || $this->session->user === 'B0681') {
          unset($menu[0]);
          foreach ($menu as $key => $value) {
            $menu_baru[] = $value;
          }
          $menu = $menu_baru;
          $data['UserMenu'] = $menu;
        }else {
          redirect('OrderPrototypePPIC');
        }

        $data['get'] = $this->M_master->getMonitoring();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderPrototypePPIC/V_Monitoring');
        $this->load->view('V_Footer', $data);
    }

    // ============================ CHECK AREA =====================================

    // public function cekapi()
    // {
      // $data_a = $this->M_rtlp->getItem();
      // echo "<pre>";
      // print_r($data_a);
      // echo sizeof($data_a);
      // die;
    // }
}
