<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationComponent extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_component');
		  
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
		$data['Title'] = 'List Component';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Component';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_component'] = $this->M_component->show_component();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Component/V_Component',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleted_component(){
		$deleted_component = $this->input->post('show_data');
		if ($deleted_component == 'Y'){
			$data_component = $this->M_component->show_deleted_component();
		}
		else{
			$data_component = $this->M_component->show_component();
		}
		echo '<table id="data_table2" class="table table-bordered table-striped table-hover">
				<thead>
					<tr class="bg-primary">
						<th width="10%"><center>No</center></th>
						<th><center>Component Name</center></th>
						<th width="20%"><center>Action</center></th>
					</tr>
				</thead>
				<tbody>';
		$no=1;
		foreach ($data_component as $dc) {
			$deleted = '';
			if ($dc['end_date'] <= date("Y-m-d H:i:s")) {
				$deleted = 'rgba(255, 0, 0, 0.17)';
			}
			echo '
				<tr style="background-color :'.$deleted.' ">
					<td style="text-align: center">'.$no++.'</td>
					<td>'.$dc['component_name'].'</td>
					<td style="text-align: center">
						<a class="btn btn-warning" href="'.base_url('Outstation/component/edit/'.$dc['component_id']).'"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_'.$dc['component_id'].'"><i class="fa fa-times"></i> Delete</button>
						<div class="modal fade" id="delete_'.$dc['component_id'].'">
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
										<button id="delete_button" type="button" data-dismiss="modal" data-toggle="modal" data-target="#delete_data" class="btn btn-danger" onClick="checkDelete(\''.base_url('Outstation/component/delete').'\','.$dc['component_id'].')">Delete</button>
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

	public function new_component()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Component';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Component';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Component/V_NewComponent',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_component()
	{
		$component_name = $this->input->post('txt_component_name');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$this->M_component->new_component($component_name,$start_date,$end_date);

		redirect('Outstation/component');
	}

	public function edit_component($component_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Component';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Component';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_component'] = $this->M_component->select_edit_component($component_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Component/V_EditComponent',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_component()
	{
		$component_id = $this->input->post('txt_component_id');
		$component_name = $this->input->post('txt_component_name');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$this->M_component->update_component($component_id,$component_name,$start_date,$end_date);

		redirect('Outstation/component');
	}

	public function check_data_component(){
		$component_id = $this->input->post('data_id');
		$checkResult = $this->M_component->check_data_component($component_id);
		foreach ($checkResult as $cR) {
			$component_id_on_real_det = $cR['component_id_on_real_det'];
		}

		if ($component_id_on_real_det > 0) {
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
									<a href="'.base_url('Outstation/component/delete-temporary/'.$component_id).'" class="btn btn-danger">Delete</a>
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
									<a href="'.base_url('Outstation/component/delete-permanently/'.$component_id).'" class="btn btn-danger">Delete</a>
								</div>
					';
		}
	}

	public function delete_temporary($component_id){
		$this->M_component->delete_temporary($component_id);
		redirect('Outstation/component');
	}

	public function delete_permanently($component_id){
		$this->M_component->delete_permanently($component_id);
		redirect('Outstation/component');
	}
}
