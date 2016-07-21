<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationSimulation extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_Simulation');
		  
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
		$data['Title'] = 'List Simulation';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Simulation';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_simulation'] = $this->M_Simulation->show_simulation();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Simulation/V_Simulation',$data);
		$this->load->view('V_Footer',$data);
	}

	public function new_Simulation()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Simulation';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Simulation';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['Area'] = $this->M_Simulation->show_area();
        $data['CityType'] = $this->M_Simulation->show_city_type();
        $data['Employee'] = $this->M_Simulation->show_employee();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Simulation/V_NewSimulation',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_Simulation()
	{
		$employee_id = $this->input->post('txt_employee_id');
		$destination = $this->input->post('txt_destination');
		$city_type = $this->input->post('txt_city_type');
		$depart = $this->input->post('txt_depart');
		$return = $this->input->post('txt_return');
		$total = $this->input->post('txt_total');

		$this->M_Simulation->new_simulation($position_id,$area_id ,$city_type);

		redirect('Outstation/simulation');
	}

	public function edit_Simulation($simulation)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Simulation';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Simulation';

		$data['Employee'] = $this->M_Simulation->show_employee();
        $data['area_data'] = $this->M_Simulation->show_area();
        $data['city_type_data'] = $this->M_Simulation->show_city_type();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_simulation'] = $this->M_Simulation->select_edit_Simulation($simulation);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Simulation/V_EditSimulation',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_Simulation()
	{$employee_id = $this->input->post('txt_employee_id');
		$destination = $this->input->post('txt_destination');
		$city_type = $this->input->post('txt_city_type');
		$depart = $this->input->post('txt_depart');
		$return = $this->input->post('txt_return');
		$total = $this->input->post('txt_total');

		$this->M_Simulation->update_simulation($simulation,$employee_id,$area_id,$city_type);

		redirect('Outstation/simulation');
	}
}
