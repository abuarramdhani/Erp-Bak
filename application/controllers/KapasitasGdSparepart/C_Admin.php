<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Admin extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_admin');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Admin Kapasitas Gudang Sparepart';
		$data['Menu'] = 'Admin';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date 		= $this->input->post('date');
		$jml_spb 	= $this->input->post('jml_spb');
		$idunix 	= $this->input->post('unix');
		$mulai 		= $this->input->post('mulai');
		$selesai 	= $this->input->post('wkt');

		$waktu1 	= strtotime($mulai);
		$waktu2 	= strtotime($selesai);
		$selisih	= ($waktu2 - $waktu1);

		$jam = floor($selisih/(60*60));
		$menit = $selisih - $jam * (60 * 60);
		$htgmenit = floor($menit/60) * 60;
		$detik = $menit - $htgmenit;
		$selisih = $jam.':'.floor($menit/60).':'.$detik;
		
		$update = $this->M_admin->updateAdmin($date, $jml_spb, $idunix, $selisih);

		$date = date('d/m/Y');
		$data['tampil'] = $this->M_admin->tampilhariini($date);
		// for ($i=0; $i <count($data['tampil']); $i++) { 
		// 	// if ($data['tampil'][$i]['WAKTU_ALLOCATE'] != '') {
		// 	// 	$data['wkt'][$i] = $data['tampil'][$i]['WAKTU_ALLOCATE'];
		// 	// }else{
		// 		$waktu1 = strtotime($data['tampil'][$i]['MULAI_ALLOCATE']);
		// 		$waktu2 = strtotime($data['tampil'][$i]['SELESAI_ALLOCATE']);
		// 		$selisih = ($waktu2 - $waktu1);

		// 		$jam = floor($selisih/(60*60));
		// 		$menit = $selisih - $jam * (60 * 60);
		// 		$htgmenit = floor($menit/60) * 60;
		// 		$detik = $menit - $htgmenit;
		// 		$data['wkt'][$i] = $jam.' jam '.floor($menit/60).' menit '.$detik.' detik';
		// 		$saveselisih = $this->M_admin->saveWaktu($data['wkt'][$i], $data['tampil'][$i]['ID']);
		// 	// }
		// }
		// echo "<pre>"; print_r($data['tampil']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Admin', $data);
		$this->load->view('V_Footer',$data);
	}

	public function saveAdmin(){
		$date 	= $this->input->post('date');
		$idunix = $this->input->post('unix');

		$this->M_admin->insertAdmin($date, $idunix);
		
		
	}

	// public function updateAdmin(){
	// 	$date 		= $this->input->post('date');
	// 	$jml_spb 	= $this->input->post('jml_spb');
	// 	$idunix 	= $this->input->post('unix');
		
	// 	$save = $this->M_admin->updateAdmin($date, $jml_spb, $idunix);
		
	// 	redirect(base_url('KapasitasGdSparepart/Admin'));
	// }

	
}