<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set("memory_limit", "-1");

class C_analisa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        // load the login model
        $this->load->library('session');
        // $this->load->library('Database');
        $this->load->model('M_Index');
        $this->load->model('LaporanPenjualanTraktor/M_pusat');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        if ($this->session->userdata('logged_in') != TRUE) {
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

    public function index($cabang)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['data'] = $this->M_pusat->getReportCabangAndMonth($cabang, date('m'));

        $data['cabang'] = $cabang;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanPenjualanTraktor/Cabang/V_analisa', $data);
        $this->load->view('V_Footer', $data);
    }

    public function inputAnalisa()
    {
        $problem = $this->input->post('problem');
        $rootcause = $this->input->post('rootcause');
        $action = $this->input->post('action');
        $duedate = $this->input->post('duedate');
        $id = $this->input->post('id');

        $this->M_pusat->insertAnalytics($problem, $rootcause, $action, $duedate, $id);
    }
}