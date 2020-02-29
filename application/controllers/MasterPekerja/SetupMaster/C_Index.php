<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('Personalia');


		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/SetupMaster/M_masterlokasi');

		// date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('index');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Lokasi Kerja';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Lokasi Kerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['MasterIndex'] = $this->M_masterlokasi->getLokasi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/SetupLokasi/V_Index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create(){
		$user_id = $this->session->userid;
		$user = $this->session->user;
		$kodeLokasi = $this->input->post('txtIdLokasi');
		$masterLokasi = $this->input->post('txtMasterLokasi');

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Create Lokasi';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Lokasi Kerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kode'] = $this->M_masterlokasi->getMaxLokasi();

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/SetupLokasi/V_Create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrdata = array(
				'id_' 	=> $this->input->post('txtIdLokasi'),
				'lokasi_kerja' 	=> $this->input->post('txtMasterLokasi')
			);

			$this->M_masterlokasi->insertMasterLokasi($arrdata);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Create Lokasi Kerja '.$this->input->post('txtMasterLokasi');
			$this->log_activity->activity_log($aksi, $detail);
			//
			$updatelog = $this->M_masterlokasi->insertLog($user,$kodeLokasi,$masterLokasi);
			redirect(site_url('MasterPekerja/SetupLokasi'));
		}
	}

	public function Edit($kd){
		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$plain_text = $this->encrypt->decode($plain_text);

		$user_id = $this->session->userid;
		$user = $this->session->user;
		$kodeLokasi = $this->input->post('txtIdLokasi');
		$kodeLokasi1 = $this->input->post('txtIdLokasi1');
		$masterLokasi = $this->input->post('txtMasterLokasi');
		$masterLokasi1 = $this->input->post('txtMasterLokasi1');

		$data['Title'] = 'Edit Lokasi Kerja';
		$data['Menu'] = 'Setup Master';
		$data['SubMenuOne'] = 'Lokasi Kerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['MasterKode'] = $this->M_masterlokasi->getMasterLokasiByKd($plain_text);
		$data['kode'] = $kd;

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/SetupLokasi/V_Edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrdata = array(
				'id_' 	=> $this->input->post('txtIdLokasi'),
				'lokasi_kerja' 	=> $this->input->post('txtMasterLokasi')
			);

			$arr = array(
				'id_' 	=> $data['MasterKode']['0']['id_'],
				'lokasi_kerja' 	=> $data['MasterKode']['0']['lokasi_kerja']
			);

			$this->M_masterlokasi->updateMasterLokasi($arrdata,$arr);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Update Lokasi Kerja Baru ID='.$plain_text;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$updatelog = $this->M_masterlokasi->insertLoga($user,$kodeLokasi,$kodeLokasi1,$masterLokasi,$masterLokasi1);
			redirect(site_url('MasterPekerja/SetupLokasi'));
		}
	}

}
