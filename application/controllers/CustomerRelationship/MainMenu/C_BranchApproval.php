<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_BranchApproval extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CustomerRelationship/MainMenu/M_branchapproval');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
	//------------------------show the dashboard-----------------------------
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['countData'] = $this->M_branchapproval->countData();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//------------------------show the approval claim in BRANCH CV.KHS-----------------------------
	public function newClaim()
	{
		$data['header'] = $this->M_branchapproval->getHeaderNew();
		$data['lines'] = $this->M_branchapproval->getLines();
		$data['cust'] = $this->M_branchapproval->getCustName();
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/new/V_NewClaims',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/V_showAction',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/new/V_approve',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/new/V_reject',$data);
	}
	public function ClaimApproved()
	{
		$data['header'] = $this->M_branchapproval->getHeaderApproved();
		$data['lines'] = $this->M_branchapproval->getLines();
		$data['cust'] = $this->M_branchapproval->getCustName();
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/approved/V_ClaimApproved',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/V_show',$data);
	}
	public function Over24Hour()
	{
		$data['header'] = $this->M_branchapproval->getHeaderOver();
		$data['lines'] = $this->M_branchapproval->getLines();
		$data['cust'] = $this->M_branchapproval->getCustName();
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/over/V_Over24Hour',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/V_showAction',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/new/V_approve',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/new/V_reject',$data);
	}
	public function ClaimClosed()
	{
		$data['header'] = $this->M_branchapproval->getHeaderClosed();
		$data['lines'] = $this->M_branchapproval->getLines();
		$data['cust'] = $this->M_branchapproval->getCustName();
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/closed/V_ClaimClosed',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/V_show',$data);
	}

	//---------------------------UPDATE DATA----------------------------------------------
	public function action($id)
	{
		$actType = $this->input->post('actionType');
		$userUpdate = $this->input->post('userUpdate');
		$Priority = $this->input->post('Priority');
		$note = $this->input->post('note');
		$update = $this->M_branchapproval->actionClaim($actType,$userUpdate,$id,$Priority,$note);

		redirect('SalesOrder/BranchApproval');
	}
}