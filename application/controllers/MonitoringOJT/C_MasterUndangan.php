<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterUndangan extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_masterundangan');

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

	public function index()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Monitoring OJT - Quick ERP';
		$data['Title']			=	'Master Undangan';
		$data['Menu'] 			= 	'Setup';
		$data['SubMenuOne'] 	= 	'Undangan';
		$data['SubMenuTwo'] 	= 	'';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['daftarFormatUndangan']		=	$this->M_masterundangan->ambilDaftarFormatUndangan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_MasterUndangan_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$this->form_validation->set_rules('txtJenisUndangan', 'Jenis Undangan', 'required');
		$this->form_validation->set_rules('txaFormatUndangan', 'Format Undangan', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$user_id = $this->session->userid;

			$data['Header']						=	'Monitoring OJT - Quick ERP';
			$data['Title']						=	'Master Undangan';
			$data['Menu'] 						= 	'Setup';
			$data['SubMenuOne'] 				= 	'Undangan';
			$data['SubMenuTwo'] 				= 	'';
			$data['complexTextAreaCKEditor']	=	TRUE;
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_MasterUndangan_Create',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 				=	$this->session->user;

			$jenisUndangan 		=	strtoupper($this->input->post('txtJenisUndangan', TRUE));
			$formatUndangan 	=	$this->input->post('txaFormatUndangan');

			$waktuEksekusi 		=	$this->general->ambilWaktuEksekusi();

			$inputUndangan 		=	array
									(
										'judul'				=>	$jenisUndangan,
										'memo'				=>	$formatUndangan,
										'create_timestamp'	=>	$waktuEksekusi,
										'create_user'		=>	$user,
									);

			$id_memo 			=	$this->M_masterundangan->inputUndangan($inputUndangan);

			$inputUndanganHistory	=	array
										(
											'id_memo'			=>	$id_memo,
											'judul'				=>	$jenisUndangan,
											'memo'				=>	$formatUndangan,
											'type'				=>	'CREATE',
											'create_timestamp'	=>	$waktuEksekusi,
											'create_user'		=>	$user,
										);
			$this->M_masterundangan->inputUndanganHistory($inputUndanganHistory);
			redirect('OnJobTraining/MasterUndangan');
		}
	}

	public function read($id_memo)
	{
		$id_memo_decode = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_memo);
		$id_memo_decode = $this->encrypt->decode($id_memo_decode);

		$user_id 							=	$this->session->userid;

		$data['Header']						=	'Monitoring OJT - Quick ERP';
		$data['Title']						=	'Master Undangan';
		$data['Menu'] 						= 	'Setup';
		$data['SubMenuOne'] 				= 	'Undangan';
		$data['SubMenuTwo'] 				= 	'';
			
		$data['UserMenu'] 					= 	$this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] 			= 	$this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] 			= 	$this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dataFormatUndangan']			=	$this->M_masterundangan->ambilDaftarFormatUndangan($id_memo_decode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_MasterUndangan_Read',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($id_memo)
	{
		$this->form_validation->set_rules('txtJenisUndangan', 'Jenis Undangan', 'required');
		$this->form_validation->set_rules('txaFormatUndangan', 'Format Undangan', 'required');

		$id_memo_decode = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_memo);
		$id_memo_decode = $this->encrypt->decode($id_memo_decode);

		if($this->form_validation->run() === FALSE)
		{
			$user_id = $this->session->userid;

			$data['Header']						=	'Monitoring OJT - Quick ERP';
			$data['Title']						=	'Master Undangan';
			$data['Menu'] 						= 	'Setup';
			$data['SubMenuOne'] 				= 	'Undangan';
			$data['SubMenuTwo'] 				= 	'';
			$data['complexTextAreaCKEditor']	=	TRUE;
			
			$data['UserMenu'] 					= 	$this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] 			= 	$this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] 			= 	$this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$data['dataFormatUndangan']			=	$this->M_masterundangan->ambilDaftarFormatUndangan($id_memo_decode);
			$data['id']							=	$id_memo;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringOJT/V_MasterUndangan_Update',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$user 				=	$this->session->user;

			$jenisUndangan 		=	strtoupper($this->input->post('txtJenisUndangan', TRUE));
			$formatUndangan 	=	$this->input->post('txaFormatUndangan');

			$waktuEksekusi 		=	$this->general->ambilWaktuEksekusi();

			$updateUndangan 		=	array
										(
											'judul'					=>	$jenisUndangan,
											'memo'					=>	$formatUndangan,
											'last_update_timestamp'	=>	$waktuEksekusi,
											'last_update_user'		=>	$user,
										);

			$this->M_masterundangan->updateUndangan($updateUndangan, $id_memo_decode);

			$updateUndanganHistory	=	array
										(
											'id_memo'				=>	$id_memo_decode,
											'judul'					=>	$jenisUndangan,
											'memo'					=>	$formatUndangan,
											'type'					=>	'UPDATE',
											'update_timestamp'		=>	$waktuEksekusi,
											'update_user'			=>	$user,
										);
			$this->M_masterundangan->updateUndanganHistory($updateUndanganHistory);
			redirect('OnJobTraining/MasterUndangan');
		}
	}

	public function delete($id_memo)
	{
		$id_memo_decode = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_memo);
		$id_memo_decode = $this->encrypt->decode($id_memo_decode);

		$user 				=	$this->session->user;
		$waktuEksekusi 		=	$this->general->ambilWaktuEksekusi();

		$dataFormatUndangan			=	$this->M_masterundangan->ambilDaftarFormatUndangan($id_memo_decode);

		$deleteUndanganHistory	=	array
									(
										'id_memo'				=>	$id_memo_decode,
										'judul'					=>	$dataFormatUndangan[0]['judul'],
										'memo'					=>	$dataFormatUndangan[0]['memo'],
										'type'					=>	'DELETE',
										'delete_timestamp'		=>	$waktuEksekusi,
										'delete_user'			=>	$user,
									);
		echo '<pre>';
		print_r($deleteUndanganHistory);
		echo '</pre>';
		$this->M_masterundangan->deleteUndanganHistory($deleteUndanganHistory);

		$this->M_masterundangan->deleteUndangan($id_memo_decode);
		redirect('OnJobTraining/MasterUndangan');
	}

}
