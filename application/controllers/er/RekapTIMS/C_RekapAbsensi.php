<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_RekapAbsensi extends CI_Controller 
{
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('er/RekapTIMS/M_rekapabsensi');
		  
		if($this->session->userdata('logged_in')!=TRUE) 
		{
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			// $this->session->set_userdata('Responsibility', 'some_value');
		}
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
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Rekap Absensi Pekerja';
		$data['Menu'] = 'Rekap Absensi Pekerja';
		$data['SubMenuOne'] = 'Rekap Absensi Pekerja';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('txtTanggalRekap', 'Tanggal Rekap', 'required');
		$this->form_validation->set_rules('cmbDepartemen', 'Departemen', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('er/RekapTIMS/RekapAbsensi/V_index',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$tanggalRekap 	=	$this->input->post('txtTanggalRekap', TRUE);
			$departemen 	=	$this->input->post('cmbDepartemen', TRUE);
			$bidang 		=	$this->input->post('cmbBidang', TRUE);
			$unit 			=	$this->input->post('cmbUnit', TRUE);
			$seksi 			=	$this->input->post('cmbSeksi', TRUE);
			$lokasi 		=	$this->input->post('cmbLokasiKerja', TRUE);
			// echo $lokasi;exit();
			if ($lokasi == '00') {
				$lokasi = '';
			}

			$bidang 		=	substr($bidang, -2);
			$unit 			=	substr($unit, -2);
			$seksi 			=	substr($seksi, -2);

			if($bidang == '00')
			{
				$bidang 	=	'';
			}

			if($unit == '00')
			{
				$unit 		=	'';
			}

			if($seksi == '00')
			{
				$seksi 		=	'';
			}

			$kodesie 		=	$departemen.$bidang.$unit.$seksi;

			$tanggalRekap 		=	explode(' - ', $tanggalRekap);
			$tanggalAwalRekap	=	$tanggalRekap[0];
			$tanggalAkhirRekap	=	date('Y-m-d', strtotime($tanggalRekap[1].'+1 day'));

			$klausaWhereKodesie 	=	'';
			if($kodesie == '0000000')
			{
				$klausaWhereKodesie 	=	"substring(kodesie,1,7)=substring(kodesie,1,7)";
			}
			else
			{
				$klausaWhereKodesie 	=	"kodesie like '$kodesie%'";
			}

			$tanggalHitungRekap 	=	new DatePeriod(
											new DateTime($tanggalAwalRekap),
											new DateInterval('P1D'),
											new DateTime($tanggalAkhirRekap)
										);


			foreach ($tanggalHitungRekap as $tanggalPerhitungan) 
			{
				$tanggalHitung 	=	$tanggalPerhitungan->format('Y-m-d');
				$tanggalFormat 	=	$tanggalPerhitungan->format('Ymd');

				$data['daftarPresensi'.$tanggalFormat] 		=	$this->M_rekapabsensi->rekapPresensiHarian($tanggalHitung, $klausaWhereKodesie, $lokasi);
				$data['statistikPresensi'.$tanggalFormat]	=	$this->M_rekapabsensi->statistikPresensiHarian($tanggalHitung, $klausaWhereKodesie);

				// echo '<pre>';
				// print_r($data['daftarPresensi'.$tanggalFormat]);
				// echo '</pre>';
			}
			// exit();

			$data['tanggalAwalRekap'] 		=	$tanggalAwalRekap;
			$data['tanggalAkhirRekap']		=	$tanggalAkhirRekap;
			$data['tanggalHitungRekap']		=	$tanggalHitungRekap;

			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('er/RekapTIMS/RekapAbsensi/V_index',$data);
			$this->load->view('V_Footer',$data);
		}
		
	}

	public function daftarDepartemen()
	{
		$term				=	strtoupper($this->input->get('term'));
		$resultDepartemen 	= 	$this->M_rekapabsensi->ambilDepartemen($term);

		echo json_encode($resultDepartemen);
	}

	public function daftarBidang()
	{
		$term 			=	strtoupper($this->input->get('term'));
		$departemen 	=	$this->input->get('departemen');

		$resultBidang 	=	$this->M_rekapabsensi->ambilBidang($departemen, $term);
		echo json_encode($resultBidang);
	}

	public function daftarUnit()
	{
		$term 			=	strtoupper($this->input->get('term'));
		$bidang 		=	$this->input->get('bidang');

		$resultUnit		=	$this->M_rekapabsensi->ambilUnit($bidang, $term);
		echo json_encode($resultUnit);
	}

	public function daftarSeksi()
	{
		$term 			=	strtoupper($this->input->get('term'));
		$unit 			=	$this->input->get('unit');

		$resultSeksi	=	$this->M_rekapabsensi->ambilSeksi($unit, $term);
		echo json_encode($resultSeksi);
	}

	public function daftarLokasiKerja()
	{
		$lokasi 		=	$this->input->get('term');
		$lokasi 		=	strtoupper($lokasi);

		$resultLokasi	=	$this->M_rekapabsensi->ambilLokasi($lokasi);
		echo json_encode($resultLokasi);
	}
}
