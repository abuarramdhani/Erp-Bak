<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationCityType extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_city_type');
		  
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
		$data['Title'] = 'List City Type';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'City Type';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_city_type'] = $this->M_city_type->show_city_type();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/CityType/V_CityType',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleted_city_type(){
		$deleted_city_type = $this->input->post('show_data');
		if ($deleted_city_type == 'Y'){
			$data_city_type = $this->M_city_type->show_deleted_city_type();
		}
		else{
			$data_city_type = $this->M_city_type->show_city_type();
		}
		echo '<table id="data_table2" class="table table-bordered table-striped table-hover">
				<thead>
					<tr class="bg-primary">
						<th width="10%"><center>No</center></th>
						<th><center>City Type</center></th>
						<th width="20%"><center>Action</center></th>
					</tr>
				</thead>
				<tbody>';
		$no=1;
		foreach ($data_city_type as $dc) {
			$deleted = '';
			if ($dc['end_date'] <= date("Y-m-d H:i:s")) {
				$deleted = 'rgba(255, 0, 0, 0.17)';
			}
			echo '
				<tr style="background-color :'.$deleted.' ">
					<td style="text-align: center">'.$no++.'</td>
					<td>'.$dc['city_type_name'].'</td>
					<td style="text-align: center">
						<a class="btn btn-warning" href="'.base_url('Outstation/city-type/edit/'.$dc['city_type_id']).'"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_'.$dc['city_type_id'].'"><i class="fa fa-times"></i> Delete</button>
						<div class="modal fade" id="delete_'.$dc['city_type_id'].'">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header bg-primary">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Delete Area?</h4>
									</div>
									<div class="modal-body">
										<p>Apakah Anda yakin akan menghapus data ini?</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button id="delete_button" type="button" data-dismiss="modal" data-toggle="modal" data-target="#delete_data" class="btn btn-danger" onClick="checkDelete(\''.base_url('Outstation/city-type/delete').'\','.$dc['city_type_id'].')">Delete</button>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>';
		}
		echo '		</tbody>
				</table>';
	}

	public function new_city_type()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New City Type';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'City Type';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/CityType/V_NewCityType',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_city_type()
	{
		$city_type_name = $this->input->post('txt_city_type_name');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$this->M_city_type->new_city_type($city_type_name,$start_date,$end_date);

		redirect('Outstation/city-type');
	}

	public function edit_city_type($city_type_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit City Type';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'City Type';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_city_type'] = $this->M_city_type->select_edit_city_type($city_type_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/CityType/V_EditCityType',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_city_type()
	{
		$city_type_id = $this->input->post('txt_city_type_id');
		$city_type_name = $this->input->post('txt_city_type_name');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$this->M_city_type->update_city_type($city_type_id,$city_type_name,$start_date,$end_date);

		redirect('Outstation/city-type');
	}

	public function check_data_city_type(){
		$city_type_id = $this->input->post('data_id');
		$checkResult = $this->M_city_type->check_data_city_type($city_type_id);
		foreach ($checkResult as $cR) {
			$city_type_id_on_acc = $cR['city_type_id_on_acc'];
			$city_type_id_on_real = $cR['city_type_id_on_real'];
			$city_type_id_on_sim = $cR['city_type_id_on_sim'];
		}

		if ($city_type_id_on_acc > 0 || $city_type_id_on_real > 0 || $city_type_id_on_sim > 0) {
			echo '	
								<div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Delete Area?</h4>
								</div>
								<div class="modal-body">
									<p>Data masih digunakan tabel lain dan tidak dapat dihapus. <strong>Apakah Anda ingin menonaktifkan data ini</strong>?</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<a href="'.base_url('Outstation/city-type/delete-temporary/'.$city_type_id).'" class="btn btn-danger">Delete</a>
								</div>
					';
		}
		else{
			echo '	
								<div class="modal-header bg-primary">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Delete Area?</h4>
								</div>
								<div class="modal-body">
									<p>Data akan dihapus secara permanen. Apakah Anda yakin?</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<a href="'.base_url('Outstation/city-type/delete-permanently/'.$city_type_id).'" class="btn btn-danger">Delete</a>
								</div>
					';
		}
	}

	public function delete_temporary($city_type_id){
		$this->M_city_type->delete_temporary($city_type_id);
		redirect('Outstation/city-type');
	}

	public function delete_permanently($city_type_id){
		$this->M_city_type->delete_permanently($city_type_id);
		redirect('Outstation/city-type');
	}
}
