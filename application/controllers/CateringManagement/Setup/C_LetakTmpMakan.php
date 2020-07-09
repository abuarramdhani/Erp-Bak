<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_LetakTmpMakan extends CI_Controller
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
		$this->load->model('CateringManagement/Setup/M_letaktmpmakan');

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

		$data['Title'] = 'Letak Tempat Makan';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Letak Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['LetakTmpMakan'] = $this->M_letaktmpmakan->getLetakTmpMakan();

		// print_r($data['Catering']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Setup/LetakTmpMakan/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Letak Tempat Makan';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Letak Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['kode'] = $this->M_letaktmpmakan->getMaxKodeLetak();

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/LetakTmpMakan/V_create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrdata = array(
				'fn_kd_letak' 	=> $this->input->post('txtKodeLetakTmpMakan'),
				'fs_letak' 	=> $this->input->post('txtLetakTmpMakan')
			);

			$this->M_letaktmpmakan->insertLetakTmpMakan($arrdata);
			redirect(site_url('CateringManagement/LetakTmpMakan'));
		}
	}

	public function Edit($kd){
		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$plain_text = $this->encrypt->decode($plain_text);

		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Letak Tempat Makan';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Letak Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['LetakTmpMakan'] = $this->M_letaktmpmakan->getLetakTmpMakanByKd($plain_text);
		$data['kode'] = $kd;

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('CateringManagement/Setup/LetakTmpMakan/V_edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrdata = array(
				'fn_kd_letak' 	=> $this->input->post('txtKodeLetakTmpMakan'),
				'fs_letak' 	=> $this->input->post('txtLetakTmpMakan')
			);

			$arr = array(
				'fn_kd_letak' 	=> $data['LetakTmpMakan']['0']['fn_kd_letak'],
				'fs_letak' 	=> $data['LetakTmpMakan']['0']['fs_letak']
			);

			// print_r($arr);print_r($arrdata);exit();

			$this->M_letaktmpmakan->updateLetakTmpMakan($arrdata,$arr);
			redirect(site_url('CateringManagement/LetakTmpMakan'));
		}
	}

	public function Delete($kd){
		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$plain_text = $this->encrypt->decode($plain_text);

		$data = $this->M_letaktmpmakan->getLetakTmpMakanByKd($plain_text);
		$arr = $data[0];
		
		$this->M_letaktmpmakan->deleteLetakTmpMakan($arr);
		redirect(site_url('CateringManagement/LetakTmpMakan'));
	}
}
?>