<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DokumenCari extends CI_Controller
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
		$this->load->model('DokumenPekerja/M_dokumenpekerja');

		$this->load->library('upload');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();

		define('direktoriUpload', './assets/upload/PengembanganSistem/StandarisasiDokumen/');
	}
	
	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		// echo '<pre>';
		// print_r($this->session);
		// echo '</pre>';
		// echo strlen($this->session->user);
		// exit();

		$data['Title'] = 'Cari Dokumen';
		$data['Menu'] = 'Dokumen Cari';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DokumenPekerja/V_Struktur', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Cari()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		// echo '<pre>';
		// print_r($this->session);
		// echo '</pre>';
		// echo strlen($this->session->user);
		// exit();

		$data['Title'] = 'Cari Dokumen';
		$data['Menu'] = 'Dokumen Cari';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['direktoriUpload']	=	direktoriUpload;

		$this->form_validation->set_rules('DokumenPekerja-cmbPencarianDokumenBerdasarkan', 'Kategori Pencarian', 'required');
		$this->form_validation->set_rules('DokumenPekerja-txtKataKunciPencarianDokumen', 'Kata Kunci Pencarian', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$data['daftarDokumen']= 	$this->M_dokumenpekerja->ambilDaftarDokumen();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DokumenPekerja/V_DokumenCari', $data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$kategoriPencarian 		= 	$this->input->post('DokumenPekerja-cmbPencarianDokumenBerdasarkan');
			$katakunciPencarian 	= 	strtoupper(filter_var($this->input->post('DokumenPekerja-txtKataKunciPencarianDokumen'), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));



			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DokumenPekerja/V_DokumenCari', $data);
			$this->load->view('V_Footer',$data);

		}


	}
}