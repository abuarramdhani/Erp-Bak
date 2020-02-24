<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_Rjp extends CI_Controller
{
	
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('general');
          //load the login model
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('er/RekapTIMS/M_rekapmssql');
		$this->load->model('RekapJenisPekerjaan/M_rekapjp');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
	{
		$data  = $this->general->loadHeaderandSidemenu('Rekap Jenis Pekerjaan', 'Rekap Jenis Pekerjaan', '', '', '');
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RekapJenisPekerjaan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Rekap()
	{
		$data  = $this->general->loadHeaderandSidemenu('Rekap Jenis Pekerjaan', 'Rekap Jenis Pekerjaan', 'Rekap Jenis Pekerjaan', '', '');
		$data['status'] = $this->M_rekapmssql->statusKerja();
		$data['dept'] = $this->M_rekapmssql->dept();
		$data['loker'] = $this->M_rekapmssql->loker();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('RekapJenisPekerjaan/Rekap/V_Rekap',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getRjp()
	{
		$tglRekap = $this->input->post('tglRekap');
		$stathub = $this->input->post('statushubker');
		$statAll = $this->input->post('statusAll');
		$dept = $this->input->post('cmbDepartemen');
		$bidang = $this->input->post('cmbBidang');
		$unit = $this->input->post('cmbUnit');
		$seksi = $this->input->post('cmbSeksi');
		$lokasi = $this->input->post('cmbloker');

		//nentuin kode
		if ($statAll == 1) {
			$kode = "tp.noind like '%%'";
		}else{
			$kode = implode("', '", $stathub);
			$kode = "substring(tp.noind,1,1) in ('".$kode."')";
		}

		//nentuin kodesie
		if (!empty($seksi)) {
			$kodesie = $this->cekKodesie($seksi);
		}elseif (!empty($unit)) {
			$kodesie = $this->cekKodesie($unit);
		}elseif (!empty($bidang)) {
			$kodesie = $this->cekKodesie($bidang);
		}else{
			$kodesie = '';
		}

		//lokasi
		if ($lokasi == '00') {
			$lokasi = '';
		}

		$data['getRjp'] = $this->M_rekapjp->getRJP($tglRekap, $kode, $kodesie, $lokasi);
		$data['tgl'] = date('d-M-Y', strtotime($tglRekap));
		$html = $this->load->view('RekapJenisPekerjaan/Rekap/V_Table',$data);
		echo json_encode($html);
	}

	function cekKodesie($ks)
	{
		$nks = substr($ks, strlen($ks)-2);
		if ($nks == '00') {
			$ks = substr($ks, 0, strlen($ks)-2);
		}
		return $ks;
	}
}