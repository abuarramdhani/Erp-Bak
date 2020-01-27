<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ListSPB extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->library('session');
        $this->checkSession();

        $this->load->model('ApprovalDO/M_list');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }
    
    private function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }

    public function index()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = 'List SPB';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['SPBList']        = $this->M_list->getSPBList();

        $this->session->set_userdata('last_menu', $data['Menu']);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ListSPB', $data);
        $this->load->view('V_Footer', $data);
    }

    public function requestApproveSPB()
    {
        $spb_number   = $this->input->post('spbNumber');
        $approver     = $this->input->post('approver');
        $requested_by = $this->session->user;

        $this->M_list->createApprovalSPB($spb_number);
        $this->M_list->updateStatusSPB($spb_number, $requested_by, $approver);

        echo json_encode('Success!');
    }

}