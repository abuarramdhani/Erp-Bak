<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutstationUSH extends CI_Controller {

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

		$this->load->model('general-afair/outstation/OutstationSetting/M_ush');
		  
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
		$data['Title'] = 'List USH';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'USH';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_ush'] = $this->M_ush->show_ush();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/USH/V_USH',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deleted_ush(){
		$deleted_ush = $this->input->post('show_data');
		if ($deleted_ush == 'Y'){
			$data_ush = $this->M_ush->show_deleted_ush();
		}
		else{
			$data_ush = $this->M_ush->show_ush();
		}
		echo '<table id="data_table2" class="table table-bordered table-striped table-hover">
				<thead>
					<tr class="bg-primary">
						<th width="10%"><center>No</center></th>
						<th><center>Position</center></th>
						<th><center>Group</center></th>
						<th><center>Nominal</center></th>
						<th width="20%"><center>Action</center></th>
					</tr>
				</thead>
				<tbody>';
		$no=1;
		foreach ($data_ush as $du) {
			$deleted = '';
			if ($du['end_date'] <= date("Y-m-d H:i:s")) {
				$deleted = 'rgba(255, 0, 0, 0.17)';
			}
			echo '
				<tr style="background-color :'.$deleted.' ">
					<td style="text-align: center">'.$no++.'</td>
					<td>'.$du['position_name'].'</td>
					<td>'.$du['group_id'].'</td>
					<td>'.$du['nominal'].'</td>
					<td style="text-align: center">
						<a class="btn btn-warning" href="'.base_url('Outstation/ush/edit/'.$du['position_id'].'/'.$du['group_id']).'"><i class="fa fa-edit"></i> Edit</a> <button class="btn btn-danger" data-toggle="modal" data-target="#delete_'.$du['position_id'].'_'.$du['group_id'].'"><i class="fa fa-times"></i> Delete</button>
						<div class="modal fade" id="delete_'.$du['position_id'].'_'.$du['group_id'].'">
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
										<button id="delete_button" type="button" data-dismiss="modal" data-toggle="modal" data-target="#delete_data" class="btn btn-danger" onClick="checkDelete(\''.base_url('Outstation/ush/delete').'\',\''.$du['position_id'].' - '.$du['group_id'].'\')">Delete</button>
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

	public function new_ush()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'New USH';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'USH';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['position_list'] = $this->M_ush->show_position();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/USH/V_NewUSH',$data);
		$this->load->view('V_Footer',$data);
	}

	public function save_ush()
	{
		$position_id = $this->input->post('txt_position_id');
		$group_id = $this->input->post('txt_group_id');
		$nominal = $this->input->post('txt_nominal');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$this->M_ush->new_ush($position_id,$group_id,$nominal,$start_date,$end_date);

		redirect('Outstation/ush');
	}

	public function edit_ush($position_id,$group_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'Edit USH';
		$data['Menu'] = 'Outstation Setting';
		$data['SubMenuOne'] = 'USH';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_ush'] = $this->M_ush->select_edit_ush($position_id,$group_id);
		$data['position_list'] = $this->M_ush->show_position();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('general-afair/outstation/OutstationSetting/USH/V_EditUSH',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update_ush()
	{
		$position_id = $this->input->post('txt_position_id');
		$position_id_old = $this->input->post('txt_position_id_old');
		$group_id = $this->input->post('txt_group_id');
		$group_id_old = $this->input->post('txt_group_id_old');
		$nominal = $this->input->post('txt_nominal');
		$start_date = $this->input->post('txt_start_date');
		$end_date = $this->input->post('txt_end_date');

		$this->M_ush->update_ush($position_id,$position_id_old,$group_id,$group_id_old,$nominal,$start_date,$end_date);

		redirect('Outstation/ush');
	}

	public function check_data_ush(){
		$id = $this->input->post('data_id');
		$ex_id = explode(' - ', $id);
		$position_id = $ex_id[0];
		$group_id = $ex_id[1];
		$checkResult = $this->M_ush->check_data_ush($position_id,$group_id);
		foreach ($checkResult as $cR) {
			$ush_on_sim = $cR['ush_on_sim_det'];
		}
		if ($ush_on_sim > 0) {
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
									<a href="'.base_url('Outstation/area/delete-temporary/'.$position_id.'/'.$group_id.'').'" class="btn btn-danger">Delete</a>
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
									<a href="'.base_url('Outstation/area/delete-permanently/'.$position_id.'/'.$group_id.'').'" class="btn btn-danger">Delete</a>
								</div>
					';
		}
	}

	public function delete_temporary($position_id,$group_id){
		$this->M_ush->delete_temporary($position_id,$group_id);
		redirect('Outstation/ush');
	}

	public function delete_permanently($position_id,$group_id){
		$this->M_ush->delete_permanently($position_id,$group_id);
		redirect('Outstation/ush');
	}
}
