<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_Catering extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Setup/M_catering');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Setup Catering';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Catering';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Catering'] = $this->M_catering->getCatering();

		// print_r($data['Catering']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/Catering/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Catering';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Catering';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/Catering/V_create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrdata = array(
				'fs_kd_katering' 	=> $this->input->post('txtKodeCatering'),
				'fs_nama_katering' 	=> $this->input->post('txtNamaCatering'),
				'fs_alamat' 		=> $this->input->post('txtAlamatCatering'),
				'fs_telepon' 		=> $this->input->post('txtTeleponCatering'),
				'fb_status' 		=> $this->input->post('txtStatusCatering'),
				'lokasi_kerja'		=> $this->input->post('txtLokasiCatering')
			);

			$this->M_catering->insertCatering($arrdata);
			redirect(site_url('CateringManagement/catering'));
		}
	}

	public function Edit($kd){
		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$plain_text = $this->encrypt->decode($plain_text);

		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Catering';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Catering';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Catering'] = $this->M_catering->getCateringByKd($plain_text);
		$data['kode'] = $kd;

		// print_r($data['Catering']);exit();

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/Catering/V_edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrdata = array(
				'fs_nama_katering' 	=> $this->input->post('txtNamaCatering'),
				'fs_alamat' 		=> $this->input->post('txtAlamatCatering'),
				'fs_telepon' 		=> $this->input->post('txtTeleponCatering'),
				'fb_status' 		=> $this->input->post('txtStatusCatering'),
				'lokasi_kerja'		=> $this->input->post('txtLokasiCatering')
			);

			$this->M_catering->UpdateCateringByKd($arrdata,$plain_text);
			redirect(site_url('CateringManagement/catering'));
		}
	}

	public function Delete($kd){
		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$plain_text = $this->encrypt->decode($plain_text);

		$this->M_catering->deleteCateringByKd($plain_text);

		redirect(site_url('CateringManagement/catering'));
	}
}
?>