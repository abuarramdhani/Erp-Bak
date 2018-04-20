<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Presensi_Catering extends CI_Controller 
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

		$this->load->model('Presensi/MainMenu/M_presensi_catering');

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
		$this->checkSession();
		$data 	=	$this->general->loadHeaderandSidemenu('Riwayat Transaksi Catering - Quick ERP', 'Riwayat Transaksi Catering', 'Presensi', 'Presensi Catering');
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Presensi/MainMenu/PresensiCatering/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses_rekap()
	{
		$this->checkSession();

		$tanggal_pencarian 		=	$this->input->post('txtTanggalPencarian', TRUE);

		$data 	=	$this->general->loadHeaderandSidemenu('Riwayat Transaksi Catering '.$tanggal_pencarian.' - Quick ERP', 'Riwayat Transaksi Catering', 'Presensi', 'Presensi Catering');

		$data['RiwayatPenarikan'] 	=	$this->M_presensi_catering->ambilRiwayatTarikCatering($tanggal_pencarian);
		$data['RiwayatProses']		=	$this->M_presensi_catering->ambilRiwayatProsesCatering($tanggal_pencarian);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Presensi/MainMenu/PresensiCatering/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
}
