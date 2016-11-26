<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_InputPekerja extends CI_Controller {

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

		$this->load->model('ItemManagement/User/M_inputpekerja');
		  
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
		$data['Menu'] = 'Input pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user_kodesie = $this->M_inputpekerja->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['kodesie'];
		}
		$data['JumlahPekerja'] = $this->M_inputpekerja->JumlahPekerja($kodesie);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/User/InputPekerja/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getKodePekerjaan(){
		$user_id = $this->session->userid;
		$term = $this->input->get('term');
		$user_kodesie = $this->M_inputpekerja->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['kodesie'];
		}

		$kodepkj = $this->M_inputpekerja->getPekerjaan($term,$kodesie);

		echo json_encode($kodepkj);
	}

	public function show_alert($message,$type,$redirect){
		$alert = '
				<div class="alert '.$type.' flyover flyover-top">
					<span style="float: right;cursor:pointer" onclick="$(this).parent().removeClass(\'in\')">
						<b style="color: #fff;">&times;</b>
					</span>
					'.$message.'
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
						setTimeout(function(){
							$(".flyover-top").addClass("in");
						}, 10);
						setTimeout(function(){
							$(".flyover-top").removeClass("in");
						}, 5000);
					});
				</script>
				';
		$this->session->set_flashdata('alert',$alert);
		redirect($redirect);
	}

	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Input Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user_kodesie = $this->M_inputpekerja->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['kodesie'];
			$seksi = $uk['seksi'];
		}

		$data['user_kodesie'] = $kodesie;
		$data['user_seksi'] = $seksi;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/User/InputPekerja/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function insert(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$periode = $this->input->post('txt_periode');
		$kodesie = $this->input->post('txt_kodesie');

		$kdpekerjaan = $this->input->post('txt_kdpekerjaan');
		$jumlah = $this->input->post('txt_jumlah');

		for ($i=0; $i < count($kdpekerjaan); $i++) { 
			$insert = $this->M_inputpekerja->insert($periode, $kodesie, $kdpekerjaan[$i], $jumlah[$i]);
			$result[] = $insert;
		}
		if (in_array(0, $result)) {
			$this->show_alert('Error Ocured when inserting Item', 'alert-danger', base_url('ItemManagement/User/InputPekerja'));
		}
		else{
			$this->show_alert('Item Created Successfully', 'bg-primary', base_url('ItemManagement/User/InputPekerja'));
		}
	}

	public function edit($id_jml_pkj){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Input Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user_kodesie = $this->M_inputpekerja->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['kodesie'];
			$seksi = $uk['seksi'];
		}

		$data['user_kodesie'] = $kodesie;
		$data['user_seksi'] = $seksi;

		$data['UpdateData'] = $this->M_inputpekerja->UpdateData($id_jml_pkj);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/User/InputPekerja/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update(){
		$id_jml_pkj = $this->input->post('txt_id_jml_pkj');
		$periode = $this->input->post('txt_periode');
		$kodesie = $this->input->post('txt_kodesie');
		$kdpekerjaan = $this->input->post('txt_kdpekerjaan');
		$jumlah = $this->input->post('txt_jumlah');

		$update = $this->M_inputpekerja->update($id_jml_pkj, $periode, $kodesie, $kdpekerjaan, $jumlah);
		$result[] = $update;

		if (in_array(0, $result)) {
			$this->show_alert('Error Ocured when inserting Item', 'alert-danger', base_url('ItemManagement/User/InputPekerja'));
		}
		else{
			$this->show_alert('Item Created Successfully', 'bg-primary', base_url('ItemManagement/User/InputPekerja'));
		}
	}

	public function delete($id_jml_pkj){
		$delete = $this->M_inputpekerja->delete($id_jml_pkj);
		if ($delete == 1) {
			$this->show_alert('Item Deleted Successfully', 'bg-primary', base_url('ItemManagement/User/InputPekerja'));
		}
		else{
			$this->show_alert('Error Ocured when deleting Item', 'alert-danger', base_url('ItemManagement/User/InputPekerja'));
		}
	}
}
