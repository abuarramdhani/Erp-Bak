<?php
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, OPTIONS");
// defined('BASEPATH') or exit('No direct script access allowed');

class C_Web_Reports extends CI_Controller
{


  //-----------------------------------------program----------------------------------------//
  function __construct()
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
        $this->load->model('SystemAdministration/MainMenu/M_user');
        //local
        $this->load->model('Apidobackup/M_Web_Reports');

        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }
    
//-------------------------penampil------------------//
public function checkSession()
{
    if ($this->session->is_logged) {
    } else {
        redirect();
    }
}



    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['param'] = $this->M_Web_Reports->param();
       
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Apidobackup/V_Apidobackup', $data);
        $this->load->view('V_Footer', $data);
    }


}
