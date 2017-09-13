<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DataPlanMonthly extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Excel');
        $this->load->library('upload');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductionPlanning/MainMenu/M_dataplan');
		$this->load->model('ProductionPlanning/Settings/GroupSection/M_groupsection');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['plan']			= $this->M_dataplan->getMonthlyPlan();
		$data['no']				= 1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/DataPlan/Monthly/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create()
	{
		$this->checkSession();
		$user_id  = $this->session->userid;
		$this->form_validation->set_rules('section', 'planQTY', 'required');
		if ($this->form_validation->run() === FALSE){
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['section'] 		= $this->M_dataplan->getSection($user_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductionPlanning/MainMenu/DataPlan/Monthly/V_Create',$data);
			$this->load->view('V_Footer',$data);
		}else{

			$value = array(
				'section_id'			=> $this->input->post('section'),
				'plan_time'				=> date("Y-m-d H:i:s"),
				'monthly_plan_quantity' => $this->input->post('planQTY'),
				'created_by'			=> $user_id,
				'created_date'			=> date("Y-m-d H:i:s")
			);

			$this->M_dataplan->insertDataPlan($value, 'pp.pp_monthly_plans');
			redirect(base_url('ProductionPlanning/DataPlanMonthly'));
		}
	}
}