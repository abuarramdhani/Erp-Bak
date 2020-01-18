<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Approval extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->library('session');
        $this->checkSession();

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('ApprovalDO/M_approval');
    }
    
    public function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }

    public function index()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;
        
		$data['Menu']            = 'Approval DO';
		$data['SubMenuOne']      = '';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['RequestedDOList'] = $this->M_approval->getRequestedDOListById($this->session->user);

        $this->session->set_userdata('last_menu', $data['Menu']);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ApprovalDO', $data);
        $this->load->view('V_Footer', $data);
    }

    public function approveDO()
    {
        $do_number   = $this->input->post('doNumber');
        $approved_by = $this->session->user;

        $this->M_approval->updateStatusDOApprove($do_number, $approved_by);

        echo json_encode('Success!');
    }

    public function rejectDO()
    {
        $do_number   = $this->input->post('doNumber');
        $approved_by = $this->session->user;

        $this->M_approval->updateStatusDOReject($do_number, $approved_by);

        echo json_encode('Success!');
    }

    public function pendingDO()
    {
        $do_number   = $this->input->post('doNumber');
        $approved_by = $this->session->user;

        $this->M_approval->updateStatusDOPending($do_number, $approved_by);

        echo json_encode('Success!');
    }

}