<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Pengeluaran extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('KapasitasGdSparepart/M_pengeluaran');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Pengeluaran';
		$data['Menu'] = 'Pengeluaran';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date = date('d/m/Y');
		$data['value'] = $this->M_pengeluaran->tampilhariini();
		$pengeluaran = $this->M_pengeluaran->dataPengeluaran($date);
		$data['data']= $pengeluaran;
		// for ($i=0; $i <count($pengeluaran); $i++) { 
		// 	if ($pengeluaran[$i]['WAKTU_PENGELUARAN'] != '') {
		// 		$data['selisih'][$i] = $pengeluaran[$i]['WAKTU_PENGELUARAN'];
		// 	}else{
			// $jenis = $pengeluaran[$i]['JENIS_DOKUMEN'];
			// $nospb = $pengeluaran[$i]['NO_DOKUMEN'];
			// $waktu1 = strtotime($pengeluaran[$i]['JAM_MULAI']);
			// $waktu2 = strtotime($pengeluaran[$i]['JAM_SELESAI']);
			// $selisih = ($waktu2 - $waktu1);
			// $jam = floor($selisih/(60*60));
			// $menit = $selisih - $jam * (60 * 60);
			// $htgmenit = floor($menit/60) * 60;
			// $detik = $menit - $htgmenit;
			// $data['selisih'][$i] = $jam.':'.floor($menit/60).':'.$detik;
			// $slsh = $data['selisih'][$i];
			// $query = "set waktu_pengeluaran = '$slsh'"; 
			// $saveselisih = $this->M_pengeluaran->saveWaktu($jenis, $nospb, $query);
		// 	}
		// }

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Pengeluaran');
		$this->load->view('V_Footer',$data);
	}

	public function updateMulai(){
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$pic 	= $this->input->post('pic');
		
		$cek = $this->M_pengeluaran->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PENGELUARAN'] == '') {
			$this->M_pengeluaran->SavePengeluaran($date, $jenis, $nospb, $pic);
		}
	}

	public function updateSelesai(){
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai 	= $this->input->post('wkt');
		$pic 	= $this->input->post('pic');

		$cek = $this->M_pengeluaran->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PENGELUARAN'] == '') {
			$waktu1		= strtotime($mulai);
			$waktu2		= strtotime($selesai);
			$selisih 	= ($waktu2 - $waktu1);
			$jam 		= floor($selisih/(60*60));
			$menit 		= $selisih - $jam * (60 * 60);
			$htgmenit 	= floor($menit/60) * 60;
			$detik		= $menit - $htgmenit;
			$slsh 		= $jam.':'.floor($menit/60).':'.$detik;	
		}else{
			$a 		= explode(':', $cek[0]['WAKTU_PENGELUARAN']);
			$jamA 	= $a[0] * 3600;
			$menitA = $a[1] * 60;
			$waktuA = $jamA + $menitA + $a[2];

			$waktu1 = strtotime($mulai);
			$waktu2 = strtotime($selesai);
			$waktuB = ($waktu2 - $waktu1);
			$jumlah = $waktuA + $waktuB;
			$jam 	= floor($jumlah/(60*60));
			$menit 	= $jumlah - $jam * (60*60);
			$htgmenit = floor($menit/60) * 60;
			$detik 	= $menit - $htgmenit;
			$slsh 	= $jam.':'.floor($menit/60).':'.$detik;
		}
		
		$this->M_pengeluaran->SelesaiPengeluaran($date, $jenis, $nospb, $slsh, $pic);
	}

	public function pauseSPB(){
		$jenis = $this->input->post('jenis');
		$nospb = $this->input->post('no_spb');
		$mulai = $this->input->post('mulai');
		$selesai = $this->input->post('wkt');

		$waktu1 	= strtotime($mulai);
		$waktu2 	= strtotime($selesai);
		$selisih	= ($waktu2 - $waktu1);
		$jam 		= floor($selisih/(60*60));
		$menit 		= $selisih - $jam * (60 * 60);
		$htgmenit 	= floor($menit/60)*60;
		$detik 		= $menit - $htgmenit;
		$slsh 		= $jam.':'.floor($menit/60).':'.$detik;

		$this->M_pengeluaran->waktuPengeluaran($nospb, $jenis, $slsh);
	}

}