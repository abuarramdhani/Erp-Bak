<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_RekapJamKerja extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('Log_Activity');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('er/RekapTIMS/M_rekapjamkerja');

		if($this->session->userdata('logged_in')!=TRUE)
		{
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			// $this->session->set_userdata('Responsibility', 'some_value');
		}
		$this->checkSession();
		date_default_timezone_set('Asia/Jakarta');
    }

	public function checkSession()
	{
		if($this->session->is_logged)
		{
		}
		else
		{
			redirect();
		}
	}

	public function index()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Jam Kerja';
		$data['Menu'] = 'Rekap Jam Kerja';
		$data['SubMenuOne'] = 'Rekap Jam Kerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('txtTanggalRekap', 'Tanggal Rekap', 'required');
		$this->form_validation->set_rules('cmbLokasiKerja', 'Tanggal Rekap', 'required');

			$data['Header'] 	=	'Rekap Jam Kerja - Quick ERP';
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('er/RekapTIMS/RekapJamKerja/V_index',$data);
			$this->load->view('V_Footer',$data);


	}
	public function search()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Jam Kerja';
		$data['Menu'] = 'Rekap Jam Kerja';
		$data['SubMenuOne'] = 'Rekap Jam Kerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('txtTanggalRekap', 'Tanggal Rekap', 'required');
		$this->form_validation->set_rules('cmbLokasiKerja', 'Tanggal Rekap', 'required');

		$tanggalRekap 	=	$this->input->post('txtTanggalRekap', TRUE);
		$lokasiKerja 	=	$this->input->post('cmbLokasiKerja', TRUE);
		$lembur			= 	$this->input->post('slc_lembur', TRUE);

		// echo $lokasiKerja." - ".$tanggalRekap." - ".$tambahLembur;
		// exit();

		// if($tambahLembur!='1')
		// {
		// 	$tambahLembur 	= 	0;
		// }
		// else
		// {
		// 	$tambahLembur 	= 	1;
		// }
		if ($lokasiKerja == "") {
			$lokasiKerja = "all";
		}
		// exit();
		$tanggalRekap 		=	explode(' - ', $tanggalRekap);
		$tanggalAwalRekap	=	$tanggalRekap[0];
		$tanggalAkhirRekap	=	$tanggalRekap[1];

		$this->benchmark->mark('mulai_rekap');
		$data['rekapJamKerja'] 			=	$this->M_rekapjamkerja->prosesRekapJamKerja($tanggalAwalRekap, $tanggalAkhirRekap, $lokasiKerja, $lembur);

		$this->benchmark->mark('selesai_rekap');

		$data['tanggalAwalRekap'] 		=	$tanggalAwalRekap;
		$data['tanggalAkhirRekap']		=	$tanggalAkhirRekap;
		$data['waktuEksekusiRekap'] 	= 	$this->benchmark->elapsed_time('mulai_rekap', 'selesai_rekap');

		$data['Header'] 	=	'Rekap Jam Kerja - '.date('Ymd', strtotime($tanggalAwalRekap)).'-'.date('Ymd', strtotime($tanggalAkhirRekap)).' - '.$lokasiKerja.' - Quick ERP';

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/RekapJamKerja/V_index',$data);
		$this->load->view('V_Footer',$data);
	}
	public function daftarLokasiKerja()
	{
		$keyword 			=	strtoupper($this->input->get('term'));

		$resultLokasiKerja 	=	$this->M_rekapjamkerja->ambilLokasiKerja($keyword);
		echo json_encode($resultLokasiKerja);
	}

}
