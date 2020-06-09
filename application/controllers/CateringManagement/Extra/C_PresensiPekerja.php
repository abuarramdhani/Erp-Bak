<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PresensiPekerja extends CI_Controller
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
		$this->load->model('CateringManagement/Extra/M_presensipekerja');
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
		$user = $this->session->user;

		$data['Title']			=	'Presensi Pekerja';
		$data['Menu'] 			= 	'Extra';
		$data['SubMenuOne'] 	= 	'Presensi Pekerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/PresensiPekerja/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getDepartement(){
		$key = $this->input->get('term');
		$data = $this->M_presensipekerja->getDepartementByKey($key);
		echo json_encode($data);
	}

	public function getBidang(){
		$key = $this->input->get('term');
		$kode = $this->input->get('kode');
		$data = $this->M_presensipekerja->getBidangByKeyKode($key,$kode);
		echo json_encode($data);
	}

	public function getUnit(){
		$key = $this->input->get('term');
		$kode = $this->input->get('kode');
		$data = $this->M_presensipekerja->getUnitByKeyKode($key,$kode);
		echo json_encode($data);
	}

	public function getSeksi(){
		$key = $this->input->get('term');
		$kode = $this->input->get('kode');
		$data = $this->M_presensipekerja->getSeksiByKeyKode($key,$kode);
		echo json_encode($data);
	}

	public function tampil(){
		// echo "<pre>";
		// print_r($_GET);
		// echo "</pre>";

		$kodesie = $this->input->get('kodesie');
		$tanggal_awal = $this->input->get('tanggal_awal');
		$tanggal_akhir = $this->input->get('tanggal_akhir');

		if ($kodesie == '-') {
			$kodesie = "";
		}elseif (substr($kodesie, -2) == '00') {
			$kodesie = substr($kodesie, 0, strlen($kodesie) - 2);
		}
		$tanggal = $this->M_presensipekerja->getTanggalBetweenTwoDate($tanggal_awal,$tanggal_akhir);
		$seksi = $this->M_presensipekerja->getSeksiByKodesie($kodesie);

		$shift = array(
			1 => array(
				'shift' => "satu",
				'kd_shift' => "'1','10'"
			),
			2 => array(
				'shift' => "dua",
				'kd_shift' => "'2','11'"
			),
			3 => array(
				'shift' => "tiga",
				'kd_shift' => "'3','12'"
			),
			4 => array(
				'shift' => "umum",
				'kd_shift' => "'4'"
			)
		);
		$data = array();
		if (!empty($seksi) && !empty($tanggal)) {
			$index = 0;
			foreach ($seksi as $seksi_key => $seksi_value) {
				foreach ($tanggal as $tanggal_key => $tanggal_value) {
					$data[$index] = $seksi_value;
					$data[$index]['tanggal'] = $tanggal_value['tanggal'];
					foreach ($shift as $shift_key => $shift_value) {
						
						$estimasi = $this->M_presensipekerja->getEstimasi($tanggal_value['tanggal'],$shift_value['kd_shift'],$seksi_value['kodesie']);
						if (!empty($estimasi)) {
							$estimasi_jumlah = $estimasi->jumlah;
						}else{
							$estimasi_jumlah = 0;
						}

						$realitas = $this->M_presensipekerja->getRealitas($tanggal_value['tanggal'],$shift_value['kd_shift'],$seksi_value['kodesie']);
						if (!empty($realitas)) {
							$realitas_jumlah = $realitas->jumlah;
						}else{
							$realitas_jumlah = 0;
						}

						$cuti = $this->M_presensipekerja->getCuti($tanggal_value['tanggal'],$shift_value['kd_shift'],$seksi_value['kodesie']);
						if (!empty($cuti)) {
							$cuti_jumlah = $cuti->jumlah;
						}else{
							$cuti_jumlah = 0;
						}

						$sakit = $this->M_presensipekerja->getSakit($tanggal_value['tanggal'],$shift_value['kd_shift'],$seksi_value['kodesie']);
						if (!empty($sakit)) {
							$sakit_jumlah = $sakit->jumlah;
						}else{
							$sakit_jumlah = 0;
						}

						$lain = $this->M_presensipekerja->getLain($tanggal_value['tanggal'],$shift_value['kd_shift'],$seksi_value['kodesie']);
						if (!empty($lain)) {
							$lain_jumlah = $lain->jumlah;
						}else{
							$lain_jumlah = 0;
						}

						$data[$index]['estimasi_'.$shift_value['shift']] = $estimasi_jumlah;
						$data[$index]['realitas_'.$shift_value['shift']] = $realitas_jumlah;
						$data[$index]['cuti_'.$shift_value['shift']] = $cuti_jumlah;
						$data[$index]['sakit_'.$shift_value['shift']] = $sakit_jumlah;
						$data[$index]['lain_'.$shift_value['shift']] = $lain_jumlah;
					}
					$index++;
				}
			}
		}

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		echo json_encode($data);
	}

} ?>