<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationMealAllowance extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_mealallowance');
		  
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
		$data['Title'] = 'List Meal Allowance';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Meal Allowance';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_meal_allowance'] = $this->M_mealallowance->show_mealallowance();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/MealAllowance/V_MealAllowance',$data);
		$this->load->view('V_Footer',$data);
	}

	public function new_MealAllowance()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Meal Allowance';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Meal Allowance';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['Position'] = $this->M_mealallowance->show_position();
        $data['Area'] = $this->M_mealallowance->show_area();
        $data['Time'] = $this->M_mealallowance->show_time();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/MealAllowance/V_NewMealAllowance',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_MealAllowance()
	{
		$position_id = $this->input->post('txt_position_id');
		$area_id = $this->input->post('txt_area_id');
		$time_id = $this->input->post('txt_time_id');
		$nominal_string = $this->input->post('txt_nominal');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$string = array('Rp','.');

		$nominal = str_replace($string, '', $nominal_string);

		$this->M_mealallowance->new_mealallowance($position_id,$area_id ,$time_id,$nominal,$start_date,$end_date);

		redirect('Outstation/meal-allowance');
	}

	public function edit_MealAllowance($mealallowance)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Meal Allowance';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Meal Allowance';
		$data['position_data'] = $this->M_mealallowance->show_position();
        $data['area_data'] = $this->M_mealallowance->show_area();
        $data['time_data'] = $this->M_mealallowance->show_time();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_meal_allowance'] = $this->M_mealallowance->select_edit_MealAllowance($mealallowance);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/MealAllowance/V_EditMealAllowance',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_MealAllowance()
	{
		$mealallowance= $this->input->post('txt_meal_id');
		$position_id = $this->input->post('txt_position_id');
		$area_id = $this->input->post('txt_area_id');
		$time_id = $this->input->post('txt_time_id');
		$nominal_string = $this->input->post('txt_nominal');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$string = array('Rp','.');

		$nominal = str_replace($string, '', $nominal_string);

		$this->M_mealallowance->update_mealallowance($mealallowance,$position_id,$area_id,$time_id,$nominal,
			$start_date,$end_date);

		redirect('Outstation/meal-allowance');
	}
	public function delete_permanently($mealallowance_id)
	{
	
		$this->M_mealallowance->delete_permanently($mealallowance_id);
			
		redirect('Outstation/meal-allowance');
	}	
}
