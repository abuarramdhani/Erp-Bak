<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationAccomodationAllowance extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_AccomodationAllowance');
		  
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
		$data['Title'] = 'List Accomodation Allowance';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Accomodation Allowance';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_accomodation_allowance'] = $this->M_AccomodationAllowance->show_accomodationallowance();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/AccomodationAllowance/V_AccomodationAllowance',$data);
		$this->load->view('V_Footer',$data);
	}

	public function show_accomodation_allowance(){
		$requestData= $_REQUEST;

		$columns = array(  
			0 => 'accomodation_allowance_id', 
			1 => 'position_name', 
			2 => 'area_name',
			2 => 'city_type_name',
			3 => 'nominal',
		);

		$data_table = $this->M_AccomodationAllowance->show_accomodation_allowance_server_side();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_AccomodationAllowance->show_accomodation_allowance_server_side_search($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_AccomodationAllowance->show_accomodation_allowance_server_side_order_limit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_AccomodationAllowance->show_accomodation_allowance_server_side_order_limit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
			if ($count != 0) {
				$json .= '["'.$no.'","'.$result['position_name'].'","'.$result['area_name'].'","'.$result['city_type_name'].'","'.$result['nominal'].'","<div width=\'100%\' style=\'text-align: center\'><a class=\'btn btn-warning\' href=\''.base_url('Outstation/accomodation-allowance/edit/'.$result['accomodation_allowance_id']).'\'><i class=\'fa fa-edit\'></i> Edit</a> <button class=\'btn btn-danger\' data-toggle=\'modal\' data-target=\'#delete_'.$result['accomodation_allowance_id'].'\'><i class=\'fa fa-times\'></i> Delete</button><div class=\'modal fade\' id=\'delete_'.$result['accomodation_allowance_id'].'\'><div class=\'modal-dialog\'><div class=\'modal-content\'><div class=\'modal-header bg-primary\'><button type=\'button\' class=\'close\' data-dismiss=\'modal\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button><h4 class=\'modal-title\'>Delete Accomodation Allowance?</h4></div><div class=\'modal-body\'><p>Apakah Anda yakin akan menghapus data ini?</p></div><div class=\'modal-footer\'><button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\'>Cancel</button><a href=\''.base_url('Outstation/accomodation-allowance/delete/'.$result['accomodation_allowance_id']).'\' id=\'delete_button\'  class=\'btn btn-danger\'>Delete</a></div></div></div></div></div>"],';
			}
			else{
				$json .= '["'.$no.'","'.$result['position_name'].'","'.$result['area_name'].'","'.$result['city_type_name'].'","'.$result['nominal'].'","<div width=\'100%\' style=\'text-align: center\'><a class=\'btn btn-warning\' href=\''.base_url('Outstation/accomodation-allowance/edit/'.$result['accomodation_allowance_id']).'\'><i class=\'fa fa-edit\'></i> Edit</a> <button class=\'btn btn-danger\' data-toggle=\'modal\' data-target=\'#delete_'.$result['accomodation_allowance_id'].'\'><i class=\'fa fa-times\'></i> Delete</button><div class=\'modal fade\' id=\'delete_'.$result['accomodation_allowance_id'].'\'><div class=\'modal-dialog\'><div class=\'modal-content\'><div class=\'modal-header bg-primary\'><button type=\'button\' class=\'close\' data-dismiss=\'modal\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button><h4 class=\'modal-title\'>Delete Accomodation Allowance?</h4></div><div class=\'modal-body\'><p>Apakah Anda yakin akan menghapus data ini?</p></div><div class=\'modal-footer\'><button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\'>Cancel</button><a href=\''.base_url('Outstation/accomodation-allowance/delete/'.$result['accomodation_allowance_id']).'\' id=\'delete_button\'  class=\'btn btn-danger\'>Delete</a></div></div></div></div></div>"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;

	}

	public function new_AccomodationAllowance()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Accomodation Allowance';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Accomodation Allowance';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        $data['Position'] = $this->M_AccomodationAllowance->show_position();
        $data['Area'] = $this->M_AccomodationAllowance->show_area();
        $data['CityType'] = $this->M_AccomodationAllowance->show_city_type();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/AccomodationAllowance/V_NewAccomodationAllowance',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_AccomodationAllowance()
	{
		$position_id = $this->input->post('txt_position_id');
		$area_id = $this->input->post('txt_area_id');
		$city_type = $this->input->post('txt_city_type_id');
		$nominal_string = $this->input->post('txt_nominal');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$string = array('Rp','.');

		$nominal = str_replace($string, '', $nominal_string);

		$this->M_AccomodationAllowance->new_accomodationallowance($position_id,$area_id ,$city_type,$nominal,$start_date,$end_date);

		redirect('Outstation/accomodation-allowance');
	}

	public function edit_AccomodationAllowance($accomodationallowance)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Accomodation Allowance';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Accomodation Allowance';
		$data['position_data'] = $this->M_AccomodationAllowance->show_position();
        $data['area_data'] = $this->M_AccomodationAllowance->show_area();
        $data['city_type_data'] = $this->M_AccomodationAllowance->show_city_type();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_accomodation_allowance'] = $this->M_AccomodationAllowance->select_edit_AccomodationAllowance($accomodationallowance);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/AccomodationAllowance/V_EditAccomodationAllowance',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_AccomodationAllowance()
	{
		$accomodationallowance= $this->input->post('txt_accomodation_id');
		$position_id = $this->input->post('txt_position_id');
		$area_id = $this->input->post('txt_area_id');
		$city_type = $this->input->post('txt_city_type_id');
		$nominal_string = $this->input->post('txt_nominal');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$string = array('Rp','.');

		$nominal = str_replace($string, '', $nominal_string);

		$this->M_AccomodationAllowance->update_accomodationallowance($accomodationallowance,$position_id,$area_id,$city_type,$nominal,
			$start_date,$end_date);

		redirect('Outstation/accomodation-allowance');
	}

	public function delete_permanently($accomodationallowance_id)
	{
	
		$this->M_AccomodationAllowance->delete_permanently($accomodationallowance_id
			);

		redirect('Outstation/accomodation-allowance');
	}
}
