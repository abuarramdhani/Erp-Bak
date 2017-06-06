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

	public function show_employee_server_side(){
		$requestData= $_REQUEST;

		$columns = array(  
			0 => 'employee_id', 
			1 => 'employee_code', 
			2 => 'employee_name',
			3 => 'position_name',
			4 => 'marketing_status'
		);

		$data_table = $this->M_employee_position->show_employee_server_side();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_employee_position->show_employee_server_side_search($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_employee_position->show_employee_server_side_order_limit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_employee_position->show_employee_server_side_order_limit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}

		$data = array();
		$no = 1;
		$data_array = $data_table->result_array();
		
		$json = "{";
		$json .= '"draw":'.intval( $requestData['draw'] ).',';
		$json .= '"recordsTotal":'.intval( $totalData ).',';
		$json .= '"recordsFiltered":'.intval( $totalFiltered ).',';
		$json .= '"data":[';

		$count = count($data_array);
		$no = 1;
		foreach ($data_array as $result) {
			$count--;
			if ($result['position_name'] == "") {
				$position_name = "-";
			}
			else{
				$position_name = $result['position_name'];
			}
			if ($result['marketing_status'] == "") {
				$marketing_status = "-";
			}
			else{
				$marketing_status = $result['marketing_status'];
			}
			if ($count != 0) {
				$json .= '["'.$no.'","'.$result['employee_code'].'","'.$result['employee_name'].'","'.$position_name.'","<div width=\'100%\' style=\'text-align: center\'>'.$marketing_status.'</div>","<div width=\'100%\' style=\'text-align: center\'><a class=\'btn btn-warning\' href=\''.base_url('Outstation/employee-position/edit/'.$result['employee_id']).'\'><i class=\'fa fa-edit\'></i> Edit</a></div>"],';
			}
			else{
				$json .= '["'.$no.'","'.$result['employee_code'].'","'.$result['employee_name'].'","'.$position_name.'","<div width=\'100%\' style=\'text-align: center\'>'.$marketing_status.'</div>","<div width=\'100%\' style=\'text-align: center\'><a class=\'btn btn-warning\' href=\''.base_url('Outstation/employee-position/edit/'.$result['employee_id']).'\'><i class=\'fa fa-edit\'></i> Edit</a></div>"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;

		
	}
}
