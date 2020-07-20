<?php
Defined('BASEPATH') or exit('No direct script Access Allowed');
/**
 * 
 */
class C_JamDatangShift extends CI_COntroller
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
		$this->load->model('CateringManagement/Setup/M_jamdatangshift');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Setup Jam Datang Shift';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jam Datang Shift';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JamDatangShift1'] = $this->M_jamdatangshift->getJamDatangShift1();
		$data['JamDatangShift2'] = $this->M_jamdatangshift->getJamDatangShift2();

		// print_r($data['Catering']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/JamDatangShift/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Jam Datang Shift';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jam Datang Shift';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/JamDatangShift/V_create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			// print_r($_POST);exit();
			$kd = $this->input->post('txtShiftJamDatang');
			$hari = $this->input->post('txtHariJamDatang');
			$awal = $this->input->post('txtAwalJamDatang');
			$akhir = $this->input->post('txtAkhirJamDatang');
			$cek = $this->M_jamdatangshift->getCheckJamDatangShift($kd,$hari);
			
			if (empty($cek)) {
				if ($kd == '1') {
					$shift = "Shift1 Dan Umum";
				}else{
					$shift = "Shift2";
				}
				$arrJam = array(
					'fs_kd_shift' => $kd, 
					'fs_nama_shift' => $shift, 
					'fs_hari' => $hari, 
					'fs_jam_awal' => $awal, 
					'fs_jam_akhir' => $akhir, 
				);
				// print_r($arrJam);exit();
				$this->M_jamdatangshift->insertJamDatangShift($arrJam);
				redirect(site_url('CateringManagement/JamDatangShift'));
			}else{
				$data['alert'] = $cek;
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('CateringManagement/Setup/JamDatangShift/V_create.php',$data);
				$this->load->view('V_Footer',$data);
			}
		}
	}

	public function Edit($kd,$hr){
		$hari = str_replace(array('-','_','~'), array('+','/','='), $hr);
		$hari = $this->encrypt->decode($hari);

		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Jam Datang Shift';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Jam Datang Shift';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['JamDatangShift'] = $this->M_jamdatangshift->getCheckJamDatangShift($kd,$hari);
		$data['kd'] = $kd;
		$data['hari'] = $hr;

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/JamDatangShift/V_edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			// print_r($_POST);exit();
			
			$arrJam = array(
				'fs_hari' => $this->input->post('txtHariJamDatang'), 
				'fs_jam_awal' =>  $this->input->post('txtAwalJamDatang'), 
				'fs_jam_akhir' => $this->input->post('txtAkhirJamDatang')
			);
			// print_r($arrJam);exit();
			$this->M_jamdatangshift->updateJamDatangShift($arrJam,$kd,$hari);
			redirect(site_url('CateringManagement/JamDatangShift'));
			
		}
	}

	public function Delete($kd,$hr){
		$hari = str_replace(array('-','_','~'), array('+','/','='), $hr);
		$hari = $this->encrypt->decode($hari);

		$this->M_jamdatangshift->deleteJamDatangShift($kd,$hari);
		redirect(site_url('CateringManagement/JamDatangShift'));
	}
}
?>