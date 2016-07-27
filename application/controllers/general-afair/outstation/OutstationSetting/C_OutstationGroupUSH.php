<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationGroupUSH extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_group_ush');
		  
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
		$data['Title'] = 'List Group USH';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Group USH';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_group_ush'] = $this->M_group_ush->show_group_ush();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/GroupUSH/V_GroupUSH',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleted_group_ush(){
		$deleted_group_ush = $this->input->post('show_data');
		if ($deleted_group_ush == 'Y'){
			$data_group_ush = $this->M_group_ush->show_deleted_group_ush();
		}
		else{
			$data_group_ush = $this->M_group_ush->show_group_ush();
		}
		echo '<table id="data_table2" class="table table-bordered table-striped table-hover">
				<thead>
					<tr class="bg-primary">
						<th width="10%"><center>No</center></th>
						<th><center>Group Name</center></th>
						<th width="20%"><center>Action</center></th>
					</tr>
				</thead>
				<tbody>';
		$no=1;
		foreach ($data_group_ush as $dgu) {
			$deleted = '';
			if ($dgu['end_date'] <= date("Y-m-d H:i:s")) {
				$deleted = 'rgba(255, 0, 0, 0.17)';
			}
			echo '
				<tr style="background-color :'.$deleted.' ">
					<td style="text-align: center">'.$no++.'</td>
					<td>'.$dgu['group_name'].'</td>
					<td style="text-align: center">
						<a class="btn btn-warning" href="'.base_url('Outstation/group-ush/edit/'.$dgu['group_id']).'"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_'.$dgu['group_id'].'"><i class="fa fa-times"></i> Delete</button>
						<div class="modal fade" id="delete_'.$dgu['group_id'].'">
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
										<button id="delete_button" type="button" data-dismiss="modal" data-toggle="modal" data-target="#delete_data" class="btn btn-danger" onClick="checkDelete(\''.base_url('Outstation/group-ush/delete').'\','.$dgu['group_id'].')">Delete</button>
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
	
	public function new_group_ush()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New Group USH';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Group USH';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/GroupUSH/V_NewGroupUSH',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_group_ush()
	{
		$group_name = $this->input->post('txt_group_name');
		$foreign_checkbox = $this->input->post('checkbox_foreign');
		$holiday_checkbox = $this->input->post('checkbox_holiday');
		$time_from = $this->input->post('txt_time_from');
		$time_to = $this->input->post('txt_time_to');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		if ( $holiday_checkbox == '') {
			$holiday = '0';
		}
		else{
			$holiday = '1';
		}

		if ( $foreign_checkbox == '') {
			$foreign = '0';
		}
		else{
			$foreign = '1';
		}

		$this->M_group_ush->new_group_ush($group_name,$holiday,$foreign,$time_from,$time_to,$start_date,$end_date);

		redirect('Outstation/group-ush');
	}

	public function edit_group_ush($group_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit Group USH';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'Group USH';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_group_ush'] = $this->M_group_ush->select_edit_group_ush($group_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/GroupUSH/V_EditGroupUSH',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_group_ush()
	{
		$group_id = $this->input->post('txt_group_id');
		$group_name = $this->input->post('txt_group_name');
		$foreign_checkbox = $this->input->post('checkbox_foreign');
		$holiday_checkbox = $this->input->post('checkbox_holiday');
		$time_from = $this->input->post('txt_time_from');
		$time_to = $this->input->post('txt_time_to');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		if ( $holiday_checkbox == '') {
			$holiday = '0';
		}
		else{
			$holiday = '1';
		}

		if ( $foreign_checkbox == '') {
			$foreign = '0';
		}
		else{
			$foreign = '1';
		}

		$this->M_group_ush->update_group_ush($group_id,$group_name,$holiday,$foreign,$time_from,$time_to,$start_date,$end_date);

		redirect('Outstation/group-ush');
	}

	public function check_data_group_ush(){
		$group_id = $this->input->post('data_id');
		$checkResult = $this->M_group_ush->check_data_group_ush($group_id);
		foreach ($checkResult as $cR) {
			$group_id_on_ush = $cR['group_id_on_ush'];
			$group_id_on_sim_det = $cR['group_id_on_sim_det'];
		}

		if ($group_id_on_ush > 0 || $group_id_on_sim_det > 0) {
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
									<a href="'.base_url('Outstation/group-ush/delete-temporary/'.$group_id).'" class="btn btn-danger">Delete</a>
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
									<a href="'.base_url('Outstation/group-ush/delete-permanently/'.$group_id).'" class="btn btn-danger">Delete</a>
								</div>
					';
		}
	}

	public function delete_temporary($group_id){
		$this->M_group_ush->delete_temporary($group_id);
		redirect('Outstation/group-ush');
	}

	public function delete_permanently($group_id){
		$this->M_group_ush->delete_permanently($group_id);
		redirect('Outstation/group-ush');
	}
}
