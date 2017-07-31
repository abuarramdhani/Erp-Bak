<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationRealization extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_Realization');
		  
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
		$data['Title'] = 'List Realization';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Realization';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_realization'] = $this->M_Realization->show_realization();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Realization/V_Realization',$data);
		$this->load->view('V_Footer',$data);
	}

	public function new_Realization()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Realization';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Realization';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
        $data['Area'] = $this->M_Realization->show_area();
        $data['CityType'] = $this->M_Realization->show_city_type();
        $data['Employee'] = $this->M_Realization->show_employee();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Realization/V_NewRealization',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_Realization()
	{
		$employee_id = $this->input->post('txt_employee_id');
		$destination = $this->input->post('txt_destination');
		$city_type = $this->input->post('txt_city_type');
		$depart = $this->input->post('txt_depart');
		$return = $this->input->post('txt_return');
		$total = $this->input->post('txt_total');

		$this->M_Realization->new_realization($position_id,$area_id ,$city_type);

		redirect('Outstation/realization');
	}

	public function edit_Realization($realization)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Realization';
		$data['Menu'] = 'Outstation Transaction';
		$data['SubMenuOne'] = 'Realization';
		$data['Employee'] = $this->M_Realization->show_employee();
        $data['area_data'] = $this->M_Realization->show_area();
        $data['city_type_data'] = $this->M_Realization->show_city_type();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_realization'] = $this->M_Realization->select_edit_Realization($realization);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Realization/V_EditRealization',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_Realization()
	{$employee_id = $this->input->post('txt_employee_id');
		$destination = $this->input->post('txt_destination');
		$city_type = $this->input->post('txt_city_type');
		$depart = $this->input->post('txt_depart');
		$return = $this->input->post('txt_return');
		$bon = $this->input->post('txt_bon');

		$this->M_Realization->update_realization($realization,$employee_id,$area_id,$city_type);

		redirect('Outstation/realization');
	}
}
