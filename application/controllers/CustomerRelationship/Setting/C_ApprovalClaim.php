<?php
class C_ApprovalClaim extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				$this->load->model('CustomerRelationship/Setting/M_approvalclaim');
				$this->load->model('SystemAdministration/MainMenu/M_user');
				$this->load->helper('form');
				$this->load->library('form_validation');
				$this->load->library('session');
				$this->load->helper('url');
        }
		
		public function index()
		{
			$data['title'] = 'Approval Claim';
			$user_id = $this->session->userid;
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['approval'] = $this->M_approvalclaim->getApprovalClaim();
			
			$data['Menu'] = 'Setting';
			$data['SubMenuOne'] = 'Setting Approval Claim';
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CustomerRelationship/Setting/ApprovalClaim/V_index', $data);
			$this->load->view('CustomerRelationship/Setting/ApprovalClaim/V_delete', $data);
			$this->load->view('V_Footer',$data);
		}

		public function Create()
		{
			$this->form_validation->set_rules('employee', 'branch', 'required');
			$data['title'] = 'Approval Claim';
			$user_id = $this->session->userid;
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['branch'] = $this->M_approvalclaim->getBranch();
			$data['employee'] = $this->M_approvalclaim->getEmployee();
			
			if ($this->form_validation->run() === FALSE)
			{
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Setting Approval Claim';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/ApprovalClaim/V_create', $data);
				$this->load->view('V_Footer',$data);
			}
			else
			{
				$branch 	= $this->input->post('branch');
				$employee 	= $this->input->post('employee');
				$startdate 	= $this->input->post('startDate');
				if ($startdate == '') {
					$startdate = NULL;
				}
				$enddate 	= $this->input->post('endDate');
				if ($enddate == '') {
					$enddate = NULL;
				}
				$creator 	= $this->input->post('hdnUser');
				$createdate	= $this->input->post('hdnDate');
				$this->M_approvalclaim->create($branch,$employee,$startdate,$enddate,$creator,$createdate);

				redirect('CustomerRelationship/Setting/ApprovalClaim');
			}
		}

		public function Update($id)
		{
			$data['title'] = 'Approval Claim';
			$user_id = $this->session->userid;
	
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['branch'] = $this->M_approvalclaim->getBranch();
			$data['employee'] = $this->M_approvalclaim->getEmployee();
			$data['approval'] = $this->M_approvalclaim->getApprovalClaim($id);
			
				$data['Menu'] = 'Setting';
				$data['SubMenuOne'] = 'Update Approval Claim';
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CustomerRelationship/Setting/ApprovalClaim/V_update', $data);
				$this->load->view('V_Footer',$data);
		}

		/*public function Employee()
		{
			$branch = $this->input->post('value');
			$data	= $this->M_approvalclaim->getEmployee($branch);
			echo '
				<option value=""></option>
				<option value="muach" disabled >-- Choose One --</option>
			';
			foreach ($data as $d) {
				echo '<option value="'.$d['employee_id'].'">'.$d['employee_code'].' '.$d['employee_name'].'</option>';
			}
		}*/
}