<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_RecordData extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SiteManagement/MainMenu/M_recorddata');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	//Kamar Mandi

	public function CeilingFan()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Kamar Mandi';
		$data['SubMenuTwo'] = 'Ceiling Fan';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['CeilingFan'] = $this->M_recorddata->dataCeilingFan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_CeilingFan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Lantai()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Kamar Mandi';
		$data['SubMenuTwo'] = 'Lantai';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Lantai'] = $this->M_recorddata->dataLantai();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_Lantai', $data);
		$this->load->view('V_Footer',$data);
	}

	//Lantai Parkir

	public function LPMaintenance()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Lantai Parkir (Maintenance)';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Maintenance'] = $this->M_recorddata->dataLPMaintenance();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_LPMaintenance', $data);
		$this->load->view('V_Footer',$data);
	}

	//Tong Sampah

	public function TongSampah()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Tong Sampah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['TongSampah'] = $this->M_recorddata->dataTongSampah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_TongSampah', $data);
		$this->load->view('V_Footer',$data);
	}

	//Lahan

	public function LahanKarangwaru()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Lahan';
		$data['SubMenuTwo'] = 'Karangwaru';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Karangwaru'] = $this->M_recorddata->dataLahanKarangwaru();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_Karangwaru', $data);
		$this->load->view('V_Footer',$data);
	}

	public function LahanPetinggen()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Lahan';
		$data['SubMenuTwo'] = 'Petinggen';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Petinggen'] = $this->M_recorddata->dataLahanPetinggen();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_Petinggen', $data);
		$this->load->view('V_Footer',$data);
	}

	public function PembersihanSajadah()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Record Data';
		$data['SubMenuOne'] = 'Pembersihan Karpet Sajadah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Sajadah'] = $this->M_recorddata->dataKarpetSajadah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/RecordData/V_Sajadah', $data);
		$this->load->view('V_Footer',$data);
	}

	public function deleteDataSiteManagement()
	{	$menu = $this->input->get('menu');
		$id = $this->input->get('id');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_recorddata->deleteDataSiteManagement($plaintext_string);

		if ($menu=='Petinggen') {
			redirect(site_url('SiteManagement/RecordData/LahanPetinggen'));	
		}elseif ($menu=='Karangwaru') {
			redirect(site_url('SiteManagement/RecordData/LahanKarangwaru'));
		}elseif ($menu=='Sampah') {
			redirect(site_url('SiteManagement/RecordData/TongSampah'));
		}elseif ($menu=='Parkir') {
			redirect(site_url('SiteManagement/RecordData/LPMaintenance'));
		}elseif ($menu=='Lantai') {
			redirect(site_url('SiteManagement/RecordData/Lantai'));
		}elseif ($menu=='CeilingFan') {
			redirect(site_url('SiteManagement/RecordData/CeilingFan'));
		}elseif ($menu=='Sajadah') {
			redirect(site_url('SiteManagement/RecordData/PembersihanSajadah'));
		}
	}
}