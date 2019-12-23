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
			// $waktu1 = strtotime($packing[$i]['JAM_MULAI']);
			// $waktu2 = strtotime($packing[$i]['JAM_SELESAI']);
			// $selisih = ($waktu2 - $waktu1);
			// $jam = floor($selisih/(60*60));
			// $menit = $selisih - $jam * (60 * 60);
			// $htgmenit = floor($menit/60) * 60;
			// $detik = $menit - $htgmenit;
			// $data['selisih'][$i] = $jam.':'.floor($menit/60).':'.$detik;
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
		// print_r($selisih);
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
		
		$this->M_packing->SavePacking($date, $jenis, $nospb, $pic);
	}

	public function updateSelesai(){
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai = $this->input->post('wkt');

		$waktu1 = strtotime($mulai);
		$waktu2 = strtotime($selesai);
		$selisih = ($waktu2 - $waktu1);
		$jam = floor($selisih/(60*60));
		$menit = $selisih - $jam * (60 * 60);
		$htgmenit = floor($menit/60) * 60;
		$detik = $menit - $htgmenit;
		$slsh = $jam.':'.floor($menit/60).':'.$detik;
		// $query = "set waktu_packing = '$slsh'"; 
		// $saveselisih = $this->M_packing->saveWaktu($jenis, $nospb, $query);
		
		$this->M_packing->SelesaiPacking($date, $jenis, $nospb, $slsh);
	}

	
}