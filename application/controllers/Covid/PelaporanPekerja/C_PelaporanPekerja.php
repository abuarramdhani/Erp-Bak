<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

class C_PelaporanPekerja extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Covid/MonitoringCovid/M_monitoringcovid');
		date_default_timezone_set('Asia/Jakarta');

		$user = $this->session->user;
		if (empty($user) || $user == '') {
			$this->session->set_userdata('user', NULL);
		}
	}

	public function index()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Index',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function diri_sendiri(){
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_DiriSendiri',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function anggota_keluarga(){
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_AnggotaKeluarga',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function kedatangan_tamu()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_KedatanganTamu',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function melaksanakan_acara()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Melaksanakan',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function menghadiri_acara()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Menghadiri',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function interaksi()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Interaksi',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function satu_rumah()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Satu_Rumah',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function beda_rumah()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Beda_Rumah',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}

	public function dalam_perusahaan()
	{
		$data = '';
		$this->load->view('Covid/PelaporanPekerja/V_Header',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Dalam_Perusahaan',$data);
		$this->load->view('Covid/PelaporanPekerja/V_Footer',$data);
	}
}