<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationArea extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_area');
		  
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
		$data['Title'] = 'List Area';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Area';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_area'] = $this->M_area->show_area();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Area/V_Area',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleted_area(){
		$deleted_area = $this->input->post('show_data');
		if ($deleted_area == 'Y'){
			$data_area = $this->M_area->show_deleted_area();
		}
		else{
			$data_area = $this->M_area->show_area();
		}
		echo '	<table id="data_table2" class="table table-bordered table-striped table-hover">
					<thead>
						<tr class="bg-primary">
							<th width="10%"><center>No</center></th>
							<th><center>Area Name</center></th>
							<th width="20%"><center>Action</center></th>
						</tr>
					</thead>
					<tbody>';
		$no=1;
		foreach ($data_area as $da) {
			$deleted = '';
			if ($da['end_date'] <= date("Y-m-d H:i:s")) {
				$deleted = 'rgba(255, 0, 0, 0.17)';
			}
			echo '
				<tr style="background-color :'.$deleted.' ">
					<td style="text-align: center">'.$no++.'</td>
					<td>'.$da['area_name'].'</td>
					<td style="text-align: center">
						<a class="btn btn-warning" href="'.base_url('Outstation/area/edit/'.$da['area_id']).'"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_'.$da['area_id'].'"><i class="fa fa-times"></i> Delete</button>
						<div class="modal fade" id="delete_'.$da['area_id'].'">
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
										<button id="delete_button" type="button" data-dismiss="modal" data-toggle="modal" data-target="#delete_data" class="btn btn-danger" onClick="checkDelete(\''.base_url('Outstation/area/delete').'\','.$da['area_id'].')">Delete</button>
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

	public function new_area()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Area';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Area';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Area/V_NewArea',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_area()
	{
		$area_name = $this->input->post('txt_area_name');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$this->M_area->new_area($area_name,$start_date,$end_date);

		redirect('Outstation/area');
	}

	public function edit_area($area_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Area';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Area';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_area'] = $this->M_area->select_edit_area($area_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Area/V_EditArea',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_area()
	{
		$area_id = $this->input->post('txt_area_id');
		$area_name = $this->input->post('txt_area_name');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$this->M_area->update_area($area_id,$area_name,$start_date,$end_date);

		redirect('Outstation/area');
	}

	public function check_data_area(){
		$area_id = $this->input->post('data_id');
		$checkResult = $this->M_area->check_data_area($area_id);
		foreach ($checkResult as $cR) {
			$area_id_on_acc = $cR['area_id_on_acc'];
			$area_id_on_meal = $cR['area_id_on_meal'];
			$area_id_on_sim = $cR['area_id_on_sim'];
			$area_id_on_real = $cR['area_id_on_real'];
		}

		if ($area_id_on_acc > 0 || $area_id_on_meal > 0 || $area_id_on_sim > 0 || $area_id_on_real > 0) {
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
									<a href="'.base_url('Outstation/area/delete-temporary/'.$area_id).'" class="btn btn-danger">Delete</a>
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
									<a href="'.base_url('Outstation/area/delete-permanently/'.$area_id).'" class="btn btn-danger">Delete</a>
								</div>
					';
		}
	}

	public function delete_temporary($area_id){
		$this->M_area->delete_temporary($area_id);
		redirect('Outstation/area');
	}

	public function delete_permanently($area_id){
		$this->M_area->delete_permanently($area_id);
		redirect('Outstation/area');
	}
}
