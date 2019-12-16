<?php

class C_Index extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
            
        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
        $this->checkSession();

        $user_id = $this->session->userid;

        $this->data['SubMenuOne'] = '';
        $this->data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $this->data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $this->data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    }

    function checkSession()
    {
        if (!$this->session->is_logged) {
            redirect();
        }
    }

    function index(){
        $this->data['Menu'] = 'Dashboard Pengiriman Dokumen';
        $this->load->view('V_Header', $this->data);
		$this->load->view('V_Sidemenu',$this->data);
        $this->load->view('PengirimanDokumen/V_Index', $this->data);
        $this->load->view('V_Footer', $this->data);
    }
}
