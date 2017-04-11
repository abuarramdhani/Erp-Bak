<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CentralApproval extends CI_Controller {

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
		$this->load->model('CustomerRelationship/MainMenu/M_centralapproval');
		$this->load->model('CustomerRelationship/MainMenu/M_branchapproval');
		//$this->load->model('WarrantofExternalClaim/ClaimBranch/M_claimbranch');
		  
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
		$data['data'] = $this->M_centralapproval->countData();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Central/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function editNewClaim($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['search'] 	= $this->M_centralapproval->searchClaim($id);
		$data['Province'] 	= $this->M_claimbranch->province();
		$data['city'] 		= $this->M_centralapproval->cityRegency();
		$data['district'] 	= $this->M_centralapproval->district();
		$data['village'] 	= $this->M_centralapproval->village();
		$data['customer'] 	= $this->M_claimbranch->customer();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/V_edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ClaimApproved()
	{
		$data['header'] = $this->M_branchapproval->getHeaderApproved();
		$data['lines'] = $this->M_branchapproval->getLines();
		$data['cust'] = $this->M_branchapproval->getCustName();
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Central/approved/V_ClaimApproved',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Central/approved/V_closed',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Branch/V_show',$data);
	}

	public function ShowPict($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Central/showPict/V_showPict',$data);
		$this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Central/showPict/V_modal',$data);
		$this->load->view('V_Footer',$data);
	}

	public function claimToQA($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['data'] = $this->M_centralapproval->searchDataClaim($id);
		$filename= 'REPORT_WARRANT_OF_EXTERNAL_CLAIM_'.time().'.pdf';
		$data['page_title'] = 'REPORT WARRANT OF EXTERNAL CLAIM NUMBER '.$id;

		ini_set('memory_limit','300M');
		$html1 = $this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Central/print/V_Header', $data, true);
		$html2 = $this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Central/print/V_print', $data, true);
		$html3 = $this->load->view('CustomerRelationship/MainMenu/ClaimApproval/Central/print/V_Footer', $data, true);
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetFooter('REPORT WARRANT OF EXTERNAL CLAIM ---- {PAGENO} ---- CLAIM NUMBER '.$id);
		$pdf->AddPage('L','', '', '', '',10,10,10,10,6,3);
		$pdf->WriteHTML($html1.$html2.$html3);
		$pdf->Output($filename, 'D');
	}

}
