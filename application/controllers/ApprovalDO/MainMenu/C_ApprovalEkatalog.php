<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ApprovalEkatalog extends CI_Controller {

    public function __construct()
    {
       parent ::__construct();

       $this->load->library('session');
       $this->checkSession();

       $this->load->model('ApprovalDO/M_listekatalog');

       $this->load->model('SystemAdministration/MainMenu/M_user');
    }

    private function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }
    
    public function ListDO()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['Menu']           = 'List DO';
        $data['SubMenuOne']     = '';
        $data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);

        if ($this->session->user == 'B0445' || $this->session->user == 'K1778' || $this->session->user == 'H6968') {
            $data['DOList']         = $this->M_listekatalog->getDOListB0445();
        }else{
            $data['DOList']         = $this->M_listekatalog->getDOList();
        }

        $this->session->set_userdata('last_menu', $data['Menu']);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ListDO', $data);
        $this->load->view('V_Footer', $data);
    }

    public function ListSPB()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = 'List SPB';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        // echo $this->session->user;exit;
        if ($this->session->user == 'B0445' || $this->session->user == 'K1778' || $this->session->user == 'H6968') {
            $data['SPBList']        = $this->M_listekatalog->getSPBListB0445();
        }else {
            $data['SPBList']        = $this->M_listekatalog->getSPBList();
        }


        $this->session->set_userdata('last_menu', $data['Menu']);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ListSPB', $data);
        $this->load->view('V_Footer', $data);
    }
}
