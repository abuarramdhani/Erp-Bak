<?php

class C_index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('CekReceiptEcommerce/M_index');
        $this->load->library('form_validation');

        if ($this->session->userdata('logged_in') != TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }

        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->checkSession();

        $user_id = $this->session->userid;
        $user = $this->session->userdata('user');

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['receipt'] = $this->M_index->getData();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CekReceiptEcommerce/V_index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function checkSession()
    {
        if ($this->session->is_logged) { } else {
            redirect();
        }
    }
}
