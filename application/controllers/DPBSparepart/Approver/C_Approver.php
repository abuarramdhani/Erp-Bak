<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Approver extends  CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->model('DPBSparepart/M_dpb');
        $this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
        }
        
        $this->checkSession();
    }

    /* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

    public function WaitingList()
    {
        $user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Approver';
		$data['SubMenuOne'] = 'Waiting List Approve';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        // echo $this->session->responsibility_id; exit;
        
        $data['waiting_list'] = $this->M_dpb->getWaitingListApprove($user);

        // echo '<pre>';
        // print_r($data['waiting_list']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DPBSparepart/Approver/V_WaitingList', $data);
		$this->load->view('V_Footer',$data);
	}

	public function ApprovedList()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Approver';
		$data['SubMenuOne'] = 'Approved List';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        // echo $this->session->responsibility_id; exit;
        
        $data['approved_list'] = $this->M_dpb->getApprovedList($user);

        // echo '<pre>';
        // print_r($data['waiting_list']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DPBSparepart/Approver/V_ApprovedList', $data);
		$this->load->view('V_Footer',$data);
	}

	public function RejectedList()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Approver';
		$data['SubMenuOne'] = 'Rejected List';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        // echo $this->session->responsibility_id; exit;

        $data['rejected_list'] = $this->M_dpb->getRejectedList($user);

        // echo '<pre>';
        // print_r($data['rejected_list']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DPBSparepart/Approver/V_RejectedList', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getDetail()
	{
		$reqNumber = $_POST['reqNumber'];
		$data['detail_dpb'] = $this->M_dpb->getDetail($reqNumber);

		$return = $this->load->view('DPBSparepart/V_Table',$data, true);

		echo $return;
	}

	public function MonitoringDPB()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Approver';
		$data['SubMenuOne'] = 'Monitoring DPB';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        // echo $this->session->responsibility_id; exit;
        
        $data['monitoring_list'] = $this->M_dpb->getMonitoringList();

        // echo '<pre>';
        // print_r($data['monitoring_list']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DPBSparepart/Approver/V_MonitoringList', $data);
		$this->load->view('V_Footer',$data);
	}

	public function updateStatus()
	{
		$reqNumber = $_POST['reqNum'];
		$status = $_POST['status'];
		
		$this->M_dpb->updateStatus($reqNumber,$status);

		echo 1;
	}
}
