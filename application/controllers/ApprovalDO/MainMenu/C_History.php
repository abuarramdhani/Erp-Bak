<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_History extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->library('session');
        $this->checkSession();

        $this->load->model('ApprovalDO/M_history');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }

    public function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }

    public function RequestedList()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']            = 'History';
		$data['SubMenuOne']      = 'Req. Approval DO';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['RequestedDOList'] = $this->M_history->getRequestedDOList();

        $this->session->set_userdata([
            'last_menu'    => $data['Menu'],
            'last_submenu' => $data['SubMenuOne']
        ]);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/History/V_RequestedDO', $data);
        $this->load->view('V_Footer', $data);
    }
    
    public function ApprovedList()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = 'History';
		$data['SubMenuOne']     = 'Approved DO';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['ApprovedDOList'] = $this->M_history->getApprovedDOList();

        $this->session->set_userdata([
            'last_menu'    => $data['Menu'],
            'last_submenu' => $data['SubMenuOne']
        ]);
        
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/History/V_ApprovedDO', $data);
        $this->load->view('V_Footer', $data);
    }

    public function RejectedList()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = 'History';
		$data['SubMenuOne']     = 'Rejected DO';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['RejectedDOList'] = $this->M_history->getRejectedDOList();

        $this->session->set_userdata([
            'last_menu'    => $data['Menu'],
            'last_submenu' => $data['SubMenuOne']
        ]);
        
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/History/V_RejectedDO', $data);
        $this->load->view('V_Footer', $data);
    }
    
    public function PendingList()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = 'History';
		$data['SubMenuOne']     = 'Pending DO';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['PendingDOList']  = $this->M_history->getPendingDOList();

        $this->session->set_userdata([
            'last_menu'    => $data['Menu'],
            'last_submenu' => $data['SubMenuOne']
        ]);
        
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/History/V_PendingDO', $data);
        $this->load->view('V_Footer', $data);
    }

}