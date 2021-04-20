<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_PasangBan extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('KapasitasGdPusat/M_pasangban');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Pasang Ban';
		$data['Menu'] = 'Pasang Ban';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdPusat/V_Pasangban');
		$this->load->view('V_Footer',$data);
	}
		
	public function getUser(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_pasangban->getUsername($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
		
	public function getUsername(){
		$term = $this->input->post('noind');
		$data = $this->M_pasangban->getUsername($term);
		// echo "<pre>";print_r($data);exit();
		echo $data[0]['nama'];
	}
		
	public function view_pasangban(){
		$ket = $this->input->post('ket');
		$data['ket'] = $ket;
		$data['onklik'] = $this->input->post('onklik');
		$data['warna'] = $this->input->post('warna');
		$data['title'] = $ket == 'siap1' || $ket == 'pasang1' ? 'Line 1' : 'Line 2';
		$data['ket2'] = $ket == 'siap1' || $ket == 'pasang1' ? 'line1' : 'line2';

		$data['getpasang'] = $this->M_pasangban->getPasang($ket);
		$data['getmulai'] = $this->M_pasangban->getJamMulai($ket);
		// echo "<pre>";print_r($data['getpasang']);exit();

		$this->load->view('KapasitasGdPusat/V_Ajax_Pasangban', $data);
	}

	public function save_mulai(){
		$noind = $this->input->post('noind');
		$nama = $this->input->post('nama');
		$ket = $this->input->post('ket');
		$date = $this->input->post('date');
		// $creation_date	= date("Y/m/d H:i:s");

		foreach ($noind as $key => $l) {
			$data = [
				'NO_INDUK' => $noind[$key],
				'NAMA' => $nama[$key],
				'KET' => $ket,
				'DATE' => $date
			];
			$this->M_pasangban->SaveMulai($data);
		}
	}

	public function save_selesai(){
		$noind = $this->input->post('noind');
		$ket = $this->input->post('ket');
		$date = $this->input->post('date');
		$selesai = $this->input->post('wkt');
		$jumlah = $this->input->post('jumlah');

		foreach ($noind as $key => $l) {
			$data = [
				'NO_INDUK' => $noind[$key],
				'KET' => $ket,
				'DATE' => $date,
				'SELESAI' => $selesai,
				'JUMLAH' => $jumlah
			];

			$cek = $this->M_pasangban->cekMulai($data);
			if ($cek[0]['WAKTU'] == '') {
				$waktu1 	= strtotime($cek[0]['JAM_MULAI']);
				$waktu2 	= strtotime($selesai);
				$selisih 	= ($waktu2 - $waktu1);
				$jam 		= floor($selisih/(60*60));
				$menit 		= $selisih - $jam * (60 * 60);
				$htgmenit 	= floor($menit/60) * 60;
				$detik 		= $menit - $htgmenit;
				$slsh 		= $jam.':'.floor($menit/60).':'.$detik;
			}else {
				$a 			= explode(':', $cek[0]['WAKTU']);
				$jamA 		= $a[0] * 3600;
				$menitA 	= $a[1] * 60;
				$waktuA 	= $jamA + $menitA + $a[2];
	
				$waktu1 	= strtotime($cek[0]['JAM_MULAI']);
				$waktu2 	= strtotime($selesai);
				$waktuB 	= ($waktu2 - $waktu1);
				$jumlah 	= $waktuA + $waktuB;
				$jam 		= floor($jumlah/(60*60));
				$menit 		= $jumlah - $jam * (60 * 60);
				$htgmenit 	= floor($menit/60) * 60;
				$detik 		= $menit - $htgmenit;
				$slsh 		= $jam.':'.floor($menit/60).':'.$detik;
			}

			$this->M_pasangban->SaveSelesai($data, $slsh);
		}
	}

	// public function save_jumlah(){
	// 	$noind = $this->input->post('noind');
	// 	$ket = $this->input->post('ket');
	// 	$jumlah = $this->input->post('jumlah');

	// 	foreach ($noind as $key => $l) {
	// 		$data = [
	// 			'NO_INDUK' => $noind[$key],
	// 			'KET' => $ket,
	// 			'JUMLAH' => $jumlah
	// 		];
	// 		$this->M_pasangban->SaveJumlah($data);
	// 	}

	// }


}