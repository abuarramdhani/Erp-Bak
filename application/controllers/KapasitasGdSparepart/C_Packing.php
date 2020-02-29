<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Packing extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_packing');

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

		$data['Title'] = 'Packing';
		$data['Menu'] = 'Packing';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date = date('d/m/Y');
		$data['value'] = $this->M_packing->tampilhariini();
		$packing = $this->M_packing->dataPacking($date);
		$data['data']= $packing;
		// for ($i=0; $i <count($packing); $i++) { 
		// 	if ($packing[$i]['WAKTU_PACKING']) {
		// 		$data['selisih'][$i] = $packing[$i]['WAKTU_PACKING'];
		// 	}else{
			// $jenis = $packing[$i]['JENIS_DOKUMEN'];
			// $nospb = $packing[$i]['NO_DOKUMEN'];
			// $waktu1 = strtotime('2020-02-13 06:23:06');
			// $waktu2 = strtotime('2020-02-12 10:19:10');
			// $selisih = ($waktu1 - $waktu2);
			// $jam = floor($selisih/(60*60));
			// $menit = $selisih - $jam * (60 * 60);
			// $htgmenit = floor($menit/60) * 60;
			// $detik = $menit - $htgmenit;
			// $data['selisih'] = $jam.':'.floor($menit/60).':'.$detik;
			// $slsh = $data['selisih'][$i];
			// $query = "set waktu_packing = '$slsh'"; 
			// $saveselisih = $this->M_packing->saveWaktu($jenis, $nospb, $query);
		// 	}
		// }
		// echo "<pre>"; 
		// print_r($waktu1);
		// echo "<br>"; 
		// print_r($waktu2);
		// echo "<br>"; 
		// print_r($data['selisih']);
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Packing', $data);
		$this->load->view('V_Footer',$data);
	}

	public function updateMulai(){
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$pic 	= $this->input->post('pic');
		
		$cek = $this->M_packing->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PACKING'] == '') {
			$this->M_packing->SavePacking($date, $jenis, $nospb, $pic);
		}
	}

	public function updateSelesai(){
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai = $this->input->post('wkt');
		$pic 	= $this->input->post('pic');
		$jml_colly 		= $this->input->post('jml_colly');
		$kardus_kecil 	= $this->input->post('kardus_kecil');
		$kardus_sdg 	= $this->input->post('kardus_sdg');
		$kardus_bsr 	= $this->input->post('kardus_bsr');
		$karung 		= $this->input->post('karung');
		// echo "<pre>";print_r($karung);exit();

		$cek = $this->M_packing->cekMulai($nospb, $jenis);
		if ($cek[0]['WAKTU_PACKING'] == '') {
			$waktu1 	= strtotime($mulai);
			$waktu2 	= strtotime($selesai);
			$selisih 	= ($waktu2 - $waktu1);
			$jam 		= floor($selisih/(60*60));
			$menit 		= $selisih - $jam * (60 * 60);
			$htgmenit 	= floor($menit/60) * 60;
			$detik 		= $menit - $htgmenit;
			$slsh 		= $jam.':'.floor($menit/60).':'.$detik;	
		}else {
			$a = explode(':', $cek[0]['WAKTU_PACKING']);
			$jamA 	= $a[0] * 3600;
			$menitA = $a[1] * 60;
			$waktuA = $jamA + $menitA + $a[2];

			$waktu1 = strtotime($mulai);
			$waktu2 = strtotime($selesai);
			$waktuB = $waktu2 - $waktu1;
			$jumlah = $waktuA + $waktuB;
			$jam 	= floor($jumlah/(60*60));
			$menit 	= $jumlah - $jam * (60 * 60);
			$htgmenit = floor($menit/60) * 60;
			$detik 	= $menit - $htgmenit;
			$slsh 	= $jam.':'.floor($menit/60).':'.$detik;
		}
		
		$this->M_packing->SelesaiPacking($date, $jenis, $nospb, $slsh, $pic);
		// $this->M_packing->insertColly($nospb, $jml_colly, $kardus_kecil, $kardus_sdg, $kardus_bsr, $karung);
	}

	public function pauseSPB(){
		$nospb = $this->input->post('no_spb');
		$jenis = $this->input->post('jenis');
		$mulai = $this->input->post('mulai');
		$selesai = $this->input->post('wkt');

		$waktu1		= strtotime($mulai);
		$waktu2 	= strtotime($selesai);
		$selisih 	= $waktu2 - $waktu1;
		$jam 		= floor($selesai/(60*60));
		$menit 		= $selesai - $jam * (60*60);
		$htgmenit 	= floor($menit/60) * 60;
		$detik 		= $menit - $htgmenit;
		$slsh 		= $jam.':'.floor($menit/60).':'.$detik;

		$this->M_packing->waktuPacking($nospb, $jenis, $slsh);
	}

	public function modalColly(){
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai = $this->input->post('wkt');
		$pic 	= $this->input->post('pic');
		$no 	= $this->input->post('no');

		$cek = $this->M_packing->cekPacking($nospb);
		if (empty($cek)) {
			$tbl = '<h3 style="text-align:center">Konfirmasi Packing Ke-1</h3>';
		}else {
			$jml = count($cek) + 1;
			$tbl = '<h3 style="text-align:center">Konfirmasi Packing Ke-'.$jml.'</h3>';
		}

		$tbl .= '<input type="hidden" id="date" value="'.$date.'">
		<input type="hidden" id="jenis" value="'.$jenis.'">
		<input type="hidden" id="no_spb" value="'.$nospb.'">
		<input type="hidden" id="mulai" value="'.$mulai.'">
		<input type="hidden" id="selesai" value="'.$selesai.'">
		<input type="hidden" id="pic" value="'.$pic.'">
		<input type="hidden" id="no" value="'.$no.'">';

		echo $tbl;
	}

	public function saveberatPacking(){
		$no_spb = $this->input->post('no_spb');
		$jenis = $this->input->post('jenis_kemasan');
		$berat = $this->input->post('berat');
		$save = $this->M_packing->insertBerat($no_spb, $jenis, $berat);
		// echo "<pre>";print_r($save);exit();
	}

	
}