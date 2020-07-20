<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_KantorAsal extends CI_Controller
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
		$this->load->model('MasterPekerja/SetupMaster/M_kantorasal');

		// date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Kantor Asal';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Kantor Asal';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['MasterIndex'] = $this->M_kantorasal->getKantor();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/SetupKantorAsal/V_Index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create(){
		$user_id = $this->session->userid;
		$user = $this->session->user;
		$kodeKantor = $this->input->post('txtIdKantor');
		$masterKantor = $this->input->post('txtMasterKantor');

		$data['Header']			=	'Master Pekerja - Quick ERP';
    $data['Title']			=	'Kantor Asal';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Kantor Asal';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kode'] = $this->M_kantorasal->getMaxKantor();

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/SetupKantorAsal/V_Create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrdata = array(
				'id_' 	=> $kodeKantor,
				'kantor_asal' 	=> $masterKantor
			);

			$this->M_kantorasal->insertMasterKantor($arrdata);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Create Kantor Asal ID='.$kodeKantor;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$updatelog = $this->M_kantorasal->insertLog($user,$kodeKantor,$masterKantor);
			redirect(site_url('MasterPekerja/SetupKantorAsal'));
		}
	}

	public function Edit($kd){
		$plain_text = str_replace(array('-','_','~'), array('+','/','='), $kd);
		$plain_text = $this->encrypt->decode($plain_text);


		$user_id = $this->session->userid;
		$user = $this->session->user;
		$kodeKantor = $this->input->post('txtIdKantor');
		$kodeKantor1 = $this->input->post('txtIdKantor1');
		$masterKantor = $this->input->post('txtMasterKantor');
		$masterKantor1 = $this->input->post('txtMasterKantor1');

    $data['Title']			=	'Kantor Asal';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Kantor Asal';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['MasterKode'] = $this->M_kantorasal->getMasterKantorByKd($plain_text);
		$data['kode'] = $kd;

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/SetupKantorAsal/V_Edit.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$arrdata = array(
				'id_' 	=> $kodeKantor,
				'kantor_asal' 	=> $masterKantor
			);

			$arr = array(
				'id_' 	=> $data['MasterKode']['0']['id_'],
				'kantor_asal' 	=> $data['MasterKode']['0']['kantor_asal']
			);

			$this->M_kantorasal->updateMasterKantor($arrdata,$arr);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Update Kantor Asal ID='.$plain_text;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$updatelog = $this->M_kantorasal->insertLoga($user,$kodeKantor,$kodeKantor1,$masterKantor,$masterKantor1);
			redirect(site_url('MasterPekerja/SetupKantorAsal'));
		}
	}

}
