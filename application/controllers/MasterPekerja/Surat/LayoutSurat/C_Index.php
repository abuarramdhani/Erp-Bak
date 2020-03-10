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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Surat/LayoutSurat/M_layoutsurat');

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

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Layout Surat';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Layout Surat';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['tabelLayoutSurat']		=	$this->M_layoutsurat->ambilLayoutSurat();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/LayoutSurat/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Layout Surat';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Layout Surat';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/LayoutSurat/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function add()
	{
		$jenisSurat 	=	$this->input->post('txtJenisSurat', TRUE);

		$ceksuratStaf 	=	$this->input->post('chk1', TRUE);
		if ($ceksuratStaf==TRUE)
		{
			$suratStaf	= '1';
		}
		else
		{
			$suratStaf	= '0';
		}

		$formatSurat 	=	$this->input->post('txaFormatSurat');

		$jenisSurat 	=	strtoupper($jenisSurat);

		$inputFormat 	=	array(
								'jenis_surat'	=>	$jenisSurat,
								'staf'			=>	$suratStaf,
								'isi_surat'		=>	$formatSurat,
							);
		$this->M_layoutsurat->inputFormatSurat($inputFormat);
		//insert to t_log
	    $aksi = 'MASTER PEKERJA';
	    $detail = 'Create Layout Surat Jenis='.$jenisSurat.' Staf='.$suratStaf;
	    $this->log_activity->activity_log($aksi, $detail);
	    //
		redirect('MasterPekerja/Surat/SuratLayout');
	}

	public function read($id_isi)
	{
		$id_isi_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id_isi);
		$id_isi_decode 	=	$this->encrypt->decode($id_isi_decode);

		$data['layoutSurat'] 	=	$this->M_layoutsurat->ambilLayoutSuratDetail($id_isi_decode);

		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Master Pekerja';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Layout Surat';
		$data['SubMenuTwo'] 	= 	'';
		$data['id']				=	$id_isi;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/LayoutSurat/V_Read',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($id_isi)
	{
		$id_isi_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id_isi);
		$id_isi_decode 	=	$this->encrypt->decode($id_isi_decode);

		$data['layoutSurat'] 	=	$this->M_layoutsurat->ambilLayoutSuratDetail($id_isi_decode);

		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Master Pekerja';
		$data['Menu'] 			= 	'Setup Master';
		$data['SubMenuOne'] 	= 	'Layout Surat';
		$data['SubMenuTwo'] 	= 	'';
		$data['id']				=	$id_isi;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Surat/LayoutSurat/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}

	public function edit($id_isi)
	{
		$id_isi_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id_isi);
		$id_isi_decode 	=	$this->encrypt->decode($id_isi_decode);
		//insert to t_log
	    $aksi = 'MASTER PEKERJA';
	    $detail = 'Update Layout Surat ID='.$id_isi_decode;
	    $this->log_activity->activity_log($aksi, $detail);
	    //

		$jenisSurat 	=	$this->input->post('txtJenisSurat', TRUE);

		$ceksuratStaf 	=	$this->input->post('chk1', TRUE);
		if ($ceksuratStaf==TRUE)
		{
			$suratStaf	= '1';
		}
		else
		{
			$suratStaf	= '0';
		}

		$formatSurat 	=	$this->input->post('txaFormatSurat');

		$updateLayoutSurat 	=	array(
									'jenis_surat'	=>	$jenisSurat,
									'staf'			=>	$suratStaf,
									'isi_surat'		=>	$formatSurat,
								);
		$this->M_layoutsurat->updateLayoutSurat($updateLayoutSurat, $id_isi_decode);
		redirect('MasterPekerja/Surat/SuratLayout');
	}

	public function delete($id_isi)
	{
		$id_isi_decode 	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id_isi);
		$id_isi_decode 	=	$this->encrypt->decode($id_isi_decode);

		$this->M_layoutsurat->deleteLayoutSurat($id_isi_decode);
		//insert to t_log
	    $aksi = 'MASTER PEKERJA';
	    $detail = 'Delete Layout Surat ID='.$id_isi_decode;
	    $this->log_activity->activity_log($aksi, $detail);
	    //
		redirect('MasterPekerja/Surat/SuratLayout');

	}
}
