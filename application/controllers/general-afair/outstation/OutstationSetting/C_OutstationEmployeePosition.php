<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationEmployeePosition extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->load->model('general-afair/outstation/OutstationSetting/M_employee_position');
		  
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
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'List Employee Position';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Employee Position';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_employee_position'] = $this->M_employee_position->show_employee_position();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/EmployeePosition/V_EmployeePosition',$data);
		$this->load->view('V_Footer',$data);
	}

	public function edit_employee_position($employee_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Employee Position';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Employee Position';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_employee_position'] = $this->M_employee_position->select_edit_employee_position($employee_id);
		$data['Position'] = $this->M_employee_position->show_position();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/EmployeePosition/V_EditEmployeePosition',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_employee_position()
	{
		$employee_id = $this->input->post('txt_employee_id');
		$position_id = $this->input->post('txt_position_id');

		$this->M_employee_position->update_employee_position($employee_id,$position_id);

		redirect('Outstation/employee-position');
	}
}
