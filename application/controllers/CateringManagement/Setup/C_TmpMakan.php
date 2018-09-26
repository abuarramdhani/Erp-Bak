<?php 
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class C_TmpMakan extends CI_Controller
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
		$this->load->model('CateringManagement/Setup/M_TmpMakan');

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

		$data['Title'] = 'Setup Tempat Makan';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['TmpMakan'] = $this->M_TmpMakan->getTmpMakan();
		

		// print_r($data['Catering']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_SideMenu',$data);
		$this->load->view('CateringManagement/Setup/TmpMakan/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Create Tempat Makan';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['letak'] = $this->M_TmpMakan->getLetakTmpMakan();

		// print_r($data['letak']);exit();

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_SideMenu',$data);
			$this->load->view('CateringManagement/Setup/TmpMakan/V_create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrData = array(
				'fs_tempat_makan' => $this->input->post('txtTmpMakan'), 
				'fs_tempat' => $this->input->post('txtLetakTmpMakan')
			);

			$this->M_TmpMakan->insertTmpmakan($arrData);
			redirect(site_url('CateringManagement/TmpMakan'));

		}
	}

	public function Edit($tmpMkn,$tmp,$ltk){
		$tempatMkn = str_replace(array('-','_','~'), array('+','/','='), $tmpMkn);
		$tempatMkn = $this->encrypt->decode($tempatMkn);
		$tempat = str_replace(array('-','_','~'), array('+','/','='), $tmp);
		$tempat = $this->encrypt->decode($tempat);
		$letak = str_replace(array('-','_','~'), array('+','/','='), $ltk);
		$letak = $this->encrypt->decode($letak);

		$user_id = $this->session->userid;

		$data['Title'] = 'Edit Tempat Makan';
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['letak'] = $this->M_TmpMakan->getLetakTmpMakan();

		$data['fs_tempat_makan'] = $tempatMkn;
		$data['fs_tempat'] = $tempat;
		$data['fs_letak'] = $letak;
		$data['encrypt'] = $tmpMkn."/".$tmp."/".$ltk;

		// print_r($data['letak']);exit();

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_SideMenu',$data);
			$this->load->view('CateringManagement/Setup/TmpMakan/V_edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrData = array(
				'fs_tempat_makan' => $this->input->post('txtTmpMakan'), 
				'fs_tempat' => $this->input->post('txtLetakTmpMakan')
			);

			$arrwhere = array(
				'fs_tempat_makan' => $tempatMkn, 
				'fs_tempat' => $tempat
			);
			// echo "<pre>";print_r($arrData);print_r($arrwhere);exit();
			$this->M_TmpMakan->updateTmpmakan($arrData,$arrwhere);
			redirect(site_url('CateringManagement/TmpMakan'));
		}
	}

	public function Delete($tmpMkn,$tmp){
		$tempatMkn = str_replace(array('-','_','~'), array('+','/','='), $tmpMkn);
		$tempatMkn = $this->encrypt->decode($tempatMkn);
		$tempat = str_replace(array('-','_','~'), array('+','/','='), $tmp);
		$tempat = $this->encrypt->decode($tempat);

		$arrwhere = array(
			'fs_tempat_makan' => $tempatMkn, 
			'fs_tempat' => $tempat
		);

		$this->M_TmpMakan->deleteTmpMakan($arrwhere);
		redirect(site_url('CateringManagement/TmpMakan'));
	}
}

?>