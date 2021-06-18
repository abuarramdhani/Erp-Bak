<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set("memory_limit", "-1");

class C_target extends CI_Controller
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

    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['infoTarget'] = $this->M_pusat->getInfoTarget(date('m'));

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanPenjualanTraktor/Pusat/V_target', $data);
        $this->load->view('V_Footer', $data);
    }

    public function inputTarget()
    {
        $array = $this->input->post('array');

        foreach ($array as $value) {
            $this->M_pusat->insertTarget($value['CABANG'], (int)$value['TARGET']);
        }
    }

    public function viewTarget()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['data'] = $this->M_pusat->getInfoTarget(date('m'));

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanPenjualanTraktor/Pusat/V_detailTarget', $data);
        $this->load->view('V_Footer', $data);
    }

    public function editTarget()
    {
        $reportid = $this->input->post('reportId');
        $target = $this->input->post('target');

        $this->M_pusat->editTarget((int)$reportid, (int)$target);
    }
}