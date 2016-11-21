<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_SetupKebutuhanIndv extends CI_Controller {

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

		$this->load->model('ItemManagement/Admin/SetupKebutuhan/M_setupkebutuhanindv');
		  
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
		$data['Menu'] = 'Setup Kebutuhan';
		$data['SubMenuOne'] = 'Individu';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['SetupKebutuhan'] = $this->M_setupkebutuhanindv->SetupKebutuhanList();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/SetupKebutuhan/Individu/V_Index',$data);
		$this->load->view('V_Footer',$data);
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
		$data['Menu'] = 'Setup Kebutuhan';
		$data['SubMenuOne'] = 'Individu';
		$data['SubMenuTwo'] = '';

		$kode = '1';
		get_kode_standar:
		$now = Date('Ymd');
		$kode_standar = $now.str_pad($kode, 4, "0", STR_PAD_LEFT);
		$CheckBlanko = $this->M_setupkebutuhanindv->CheckStd($kode_standar);
		if($CheckBlanko != 0){
			$kode++;
			GOTO get_kode_standar;
		}

		$data['kode_standar'] = $kode_standar;
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/SetupKebutuhan/Individu/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function insert(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$kode_standar = strtoupper($this->input->post('txt_kode_standar'));
		$kodesie = $this->input->post('txt_kodesie');
		$noind = strtoupper($this->input->post('txt_noind'));

		$kode_barang = $this->input->post('txt_kode_barang');
		$periode_mulai = $this->input->post('txt_tgl_aktif');
		$periode_selesai = $this->input->post('txt_periode');
		$jumlah = $this->input->post('txt_jumlah');

		$CheckStd = $this->M_setupkebutuhanindv->CheckStd($kode_standar);
		if ($CheckStd == 0) {
			$count = count($kode_barang);
			for ($i=0; $i < $count ; $i++) { 
				$insert = $this->M_setupkebutuhanindv->insert($kode_standar, $noind, $kode_barang[$i], $periode_mulai[$i], $periode_selesai[$i], $jumlah[$i], $kodesie);
				$result[] = $insert;
			}
			if (in_array(0, $result)) {
				$this->show_alert('Some Records Couldn\'t be inserted', 'alert-danger', base_url('ItemManagement/SetupKebutuhan/Individu'));
			}
			else{
				$this->show_alert('All Records Created Successfully', 'bg-primary', base_url('ItemManagement/SetupKebutuhan/Individu'));
			}
		}
		else{
			$this->show_alert('Standard Code Already Exist', 'alert-danger', base_url('ItemManagement/SetupKebutuhan/Individu/create'));
		}
	}

	public function edit($kode_standar,$kodesie,$noind){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Setup Kebutuhan';
		$data['SubMenuOne'] = 'Individu';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['UpdateData'] = $this->M_setupkebutuhanindv->UpdateData($kode_standar,$kodesie,$noind);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/SetupKebutuhan/Individu/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update(){
		$kode_standar = str_replace(' ', '', strtoupper($this->input->post('txt_kode_standar')));
		$kode_standar_old = str_replace(' ', '', strtoupper($this->input->post('txt_kode_standar_old')));
		$kodesie = $this->input->post('txt_kodesie');
		$kodesie_old = $this->input->post('txt_kodesie_old');
		$noind = strtoupper($this->input->post('txt_noind'));
		$noind_old = strtoupper($this->input->post('txt_noind_old'));

		$kode_barang = $this->input->post('txt_kode_barang');
		$kode_barang_old = $this->input->post('txt_kode_barang_old');
		$periode_mulai = $this->input->post('txt_tgl_aktif');
		$periode_mulai_old = $this->input->post('txt_periode_mulai_old');
		$periode_selesai = $this->input->post('txt_periode');
		$periode_selesai_old = $this->input->post('txt_periode_selesai_old');
		$jumlah = $this->input->post('txt_jumlah');
		$jumlah_old = $this->input->post('txt_jumlah_old');

		$count = count($kode_barang);
		$count_old = count($kode_barang_old);
		for ($i=0; $i < $count_old; $i++) {
			$delete = $this->M_setupkebutuhanindv->DeleteBarang($kode_standar_old,$noind_old,$kode_barang_old[$i],$kodesie_old);
		}

		if ($kode_standar == $kode_standar_old) {
			for ($i=0; $i < $count; $i++) { 
				$checkBarang = $this->M_setupkebutuhanindv->checkBarang($kode_standar,$noind,$kode_barang[$i],$kodesie);
				if ($checkBarang == 0) {
					$insert = $this->M_setupkebutuhanindv->insert($kode_standar,$noind,$kode_barang[$i],$periode_mulai[$i],$periode_selesai[$i],$jumlah[$i],$kodesie);
					$result[] = $insert;
				}
			}
		}
		else{
			$CheckStd = $this->M_setupkebutuhanindv->CheckStd($kode_standar);
			if ($CheckStd == 0) {
				for ($i=0; $i < $count; $i++) {
					$checkBarang = $this->M_setupkebutuhanindv->checkBarang($kode_standar,$noind,$kode_barang[$i],$kodesie);
					if ($checkBarang == 0) {
						$insert = $this->M_setupkebutuhanindv->insert($kode_standar,$noind,$kode_barang[$i],$periode_mulai[$i],$periode_selesai[$i],$jumlah[$i],$kodesie);
						$result[] = $insert;
					}
				}
			}
			else{
				$this->show_alert('Standard Code Already Exist', 'alert-danger', base_url('ItemManagement/SetupKebutuhan/Individu/create'));
			}
		}
		if (in_array(0, $result)) {
			$this->show_alert('Some Records Couldn\'t be updated', 'alert-danger', base_url('ItemManagement/SetupKebutuhan/Individu'));
		}
		else{
			$this->show_alert('All Records Updated Successfully', 'bg-primary', base_url('ItemManagement/SetupKebutuhan/Individu'));
		}
	}

	public function delete($kode_standar,$kodesie,$noind){
		$delete = $this->M_setupkebutuhanindv->DeleteBarang($kode_standar,$kodesie,$noind,$kode_barang = NULL);
		if ($delete == 1) {
			$this->show_alert('Item Deleted Successfully', 'bg-primary', base_url('ItemManagement/SetupKebutuhan/Individu'));
		}
		else{
			$this->show_alert('Error Ocured when deleting Item', 'alert-danger', base_url('ItemManagement/SetupKebutuhan/Individu'));
		}
	}
}
