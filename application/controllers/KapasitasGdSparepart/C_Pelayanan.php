<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Pelayanan extends CI_Controller
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
		$this->load->model('KapasitasGdSparepart/M_pelayanan');

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

		$data['Title'] = 'Pelayanan';
		$data['Menu'] = 'Pelayanan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date = date('d/m/Y');
		// $date2 = gmdate('d/m/Y H:i:s', time()+60*60*7);
		// $date2 = date('d/m/Y', strtotime('+1 days'));
		$data['value'] 	= $this->M_pelayanan->tampilhariini();
		$pelayanan 		= $this->M_pelayanan->dataPelayanan($date);
		$data['data']	= $pelayanan;
		// for ($i=0; $i <count($data['value']); $i++) { 
		// 	$getstatus = $this->M_pelayanan->getStatus($data['value'][$i]['NO_DOKUMEN']);
		// 	if (empty($getstatus)) {
		// 		$data['status'][$i] = 'Belum Allocate';
		// 	}else {
		// 		$data['status'][$i] = 'Sudah Allocate';
		// 	}
		// }
		
		// echo "<pre>"; 
		// print_r($menit);
		// echo "<br>"; 
		// print_r(count_chars($menit, 1));
		// echo "<br>"; 
		// print_r($data['selisih']);
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('KapasitasGdSparepart/V_Pelayanan', $data);
		$this->load->view('V_Footer',$data);
	}

	public function updateMulai(){
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$pic 	= $this->input->post('pic');
		
		$this->M_pelayanan->SavePelayanan($date, $jenis, $nospb, $pic);
	}

	public function updateSelesai(){
		$date 	= $this->input->post('date');
		$jenis	= $this->input->post('jenis');
		$nospb 	= $this->input->post('no_spb');
		$mulai 	= $this->input->post('mulai');
		$selesai = $this->input->post('wkt');
		$pic 	= $this->input->post('pic');

		$waktu1 	= strtotime($mulai);
		$waktu2 	= strtotime($selesai);
		$selisih 	= ($waktu2 - $waktu1);
		$jam 		= floor($selisih/(60*60));
		$menit 		= $selisih - $jam * (60 * 60);
		$htgmenit 	= floor($menit/60) * 60;
		$detik 		= $menit - $htgmenit;
		$slsh 		= $jam.':'.floor($menit/60).':'.$detik;
		// $query = "set waktu_pelayanan = '$slsh'"; 
		// $saveselisih = $this->M_pelayanan->saveWaktu($jenis, $nospb, $query);
		
		$this->M_pelayanan->SelesaiPelayanan($date, $jenis, $nospb, $slsh, $pic);
	}

}