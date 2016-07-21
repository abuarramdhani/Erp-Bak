<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationPosition extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_position');
		  
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
		$data['Title'] = 'List Position';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Position';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_position'] = $this->M_position->show_position();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Position/V_Position',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleted_position(){
		$deleted_position = $this->input->post('show_data');
		if ($deleted_position == 'Y'){
			$data_position = $this->M_position->show_deleted_position();
		}
		else{
			$data_position = $this->M_position->show_position();
		}
		echo '<table id="data_table2" class="table table-bordered table-striped table-hover">
				<thead>
					<tr class="bg-primary">
						<th width="10%"><center>No</center></th>
						<th><center>Position Name</center></th>
						<th width="20%"><center>Action</center></th>
					</tr>
				</thead>
				<tbody>';
		$no=1;
		foreach ($data_position as $dp) {
			$deleted = '';
			if ($dp['end_date'] <= date("Y-m-d H:i:s")) {
				$deleted = 'rgba(255, 0, 0, 0.17)';
			}
			echo '
				<tr style="background-color :'.$deleted.' ">
					<td style="text-align: center">'.$no++.'</td>
					<td>'.$dp['position_name'].'</td>
					<td style="text-align: center">
						<a class="btn btn-warning" href="'.base_url('Outstation/position/edit/'.$dp['position_id']).'"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_'.$dp['position_id'].'"><i class="fa fa-times"></i> Delete</button>
						<div class="modal fade" id="delete_'.$dp['position_id'].'">
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
										<button id="delete_button" type="button" data-dismiss="modal" data-toggle="modal" data-target="#delete_data" class="btn btn-danger" onClick="checkDelete(\''.base_url('Outstation/position/delete').'\','.$dp['position_id'].')">Delete</button>
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

	public function new_position()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Position';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Position';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Position/V_NewPosition',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_position()
	{
		$position_name = $this->input->post('txt_position_name');
		$marketing_status = $this->input->post('checkbox_marketing_status');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');
		
		if ( $marketing_status == '') {
			$marketing_status = 'N';
		}
		else{
			$marketing_status = 'Y';
		}

		$this->M_position->new_position($position_name,$marketing_status,$start_date,$end_date);

		redirect('Outstation/position');
	}

	public function edit_position($position_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Position';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Position';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_position'] = $this->M_position->select_edit_position($position_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/Position/V_EditPosition',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_position()
	{
		$position_id = $this->input->post('txt_position_id');
		$position_name = $this->input->post('txt_position_name');
		$marketing_status = $this->input->post('checkbox_marketing_status');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		if ( $marketing_status == '') {
			$marketing_status = 'N';
		}
		else{
			$marketing_status = 'Y';
		}

		$this->M_position->update_position($position_id,$position_name,$marketing_status,$start_date,$end_date);

		redirect('Outstation/position');
	}

	public function check_data_position(){
		$position_id = $this->input->post('data_id');
		$checkResult = $this->M_position->check_data_position($position_id);
		foreach ($checkResult as $cR) {
			$position_id_on_acc = $cR['position_id_on_acc'];
			$position_id_on_meal = $cR['position_id_on_meal'];
			$position_id_on_ush = $cR['position_id_on_ush'];
		}

		if ($position_id_on_acc > 0 || $position_id_on_meal > 0 || $position_id_on_ush > 0) {
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
									<a href="'.base_url('Outstation/position/delete-temporary/'.$position_id).'" class="btn btn-danger">Delete</a>
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
									<a href="'.base_url('Outstation/position/delete-permanently/'.$position_id).'" class="btn btn-danger">Delete</a>
								</div>
					';
		}
	}

	public function delete_temporary($position_id){
		$this->M_position->delete_temporary($position_id);
		redirect('Outstation/position');
	}

	public function delete_permanently($position_id){
		$this->M_position->delete_permanently($position_id);
		redirect('Outstation/position');
	}
}
