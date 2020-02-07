<?php
defined('BASEPATH') OR exit('No direct script access allowed');

setlocale(LC_TIME, "id_ID.utf8");

class C_Resign extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Surat/Resign/M_resign');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Pengunduran Diri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pengunduran Diri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_resign->getResignMailAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Resign/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create(){
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Pengunduran Diri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pengunduran Diri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Resign/V_new',$data);
		$this->load->view('V_Footer',$data);
	}

	public function pekerjaAktif(){
		$key = $this->input->get('term');
		$data = $this->M_resign->getPekerjaAktifByParams($key);
		echo json_encode($data);
	}

	public function save(){
		$noind = $this->input->post('SuratResignPekerjaResign');
		$noind_baru = $this->M_resign->getNoindBaru($noind);
		$data = array(
			'noind' => $noind,
			'noind_baru' => $noind_baru,
			'tgl_resign' => $this->input->post('SuratResignTanggalResign'),
			'sebab' => $this->input->post('SuratResignSebabResign'),
			'tgl_diterima' => $this->input->post('SuratResignDiterimaHubker'),
			'user_' => $this->session->user
		);

		$this->M_resign->insertResignMail($data);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Create Surat Resign Noind='.$noind;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('MasterPekerja/Surat/SuratResign'));
	}

	public function edit($id){
		$decrypted_String = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
 		$decrypted_String = $this->encrypt->decode($decrypted_String);

 		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Surat Pengunduran Diri';
		$data['Menu'] 			= 	'Surat';
		$data['SubMenuOne'] 	= 	'Surat Pengunduran Diri';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$data['data'] = $this->M_resign->getResignMailByID($decrypted_String);
		$data['link_id'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/Resign/V_edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($id){
		$decrypted_String = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
 		$decrypted_String = $this->encrypt->decode($decrypted_String);

 		$user_id = $this->session->userid;
		$data = array(
			'tgl_resign' => $this->input->post('SuratResignTanggalResign'),
			'sebab' => $this->input->post('SuratResignSebabResign'),
			'tgl_diterima' => $this->input->post('SuratResignDiterimaHubker')
		);

		$this->M_resign->updateResignMailByID($data,$decrypted_String);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Surat Resign ID='.$decrypted_String;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('MasterPekerja/Surat/SuratResign'));
	}

	public function delete($id){
		$decrypted_String = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
 		$decrypted_String = $this->encrypt->decode($decrypted_String);

 		$this->M_resign->deleteResignMailByID($decrypted_String);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Delete Surat Resign ID='.$decrypted_String;
		$this->log_activity->activity_log($aksi, $detail);
		//
 		redirect(site_url('MasterPekerja/Surat/SuratResign'));
	}

}

?>
