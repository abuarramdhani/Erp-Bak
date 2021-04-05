<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Approval extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PeriodicalMaintenance/M_approval');

		$this->checkSession();
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('index');
		}
	}

	public function index()
	{
        $this->checkSession();
		$user_id = $this->session->userid;
		$employee_code = $this->session->user;

		$data['Title'] = 'Approval Periodical Maintenance';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['approval_staffmtn'] = $this->M_approval->getApprovalMPA($employee_code, "1");
        $data['approval_seksi'] = $this->M_approval->getApprovalMPA($employee_code, "2");
        $data['approver2'] = $this->M_approval->getNoInduk();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('PeriodicalMaintenance/V_Approval', $data);
        $this->load->view('V_Footer', $data);
        
    }
    

    public function updateApproval1()
	{
        $this->checkSession();
		$user_id = $this->session->userid;
        $employee_code = $this->session->user;
        
        $nodoc 	= $this->input->post('nodoc');
		$req2 = $this->input->post('req2');        

		$this->M_approval->updateApproval1($nodoc, $employee_code, $req2);


    }
    
    public function updateApproval2()
	{
        $this->checkSession();
		$user_id = $this->session->userid;
        $employee_code = $this->session->user;
        
        $nodoc 	= $this->input->post('nodoc');

		$this->M_approval->updateApproval2($nodoc, $employee_code);
	}

}
