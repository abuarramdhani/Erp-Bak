<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Sebaran extends CI_Controller
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
		$this->load->model('MasterPekerja/Sebaran/M_sebaran');

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

		$data['Title']			=	'Sebaran';
		$data['Menu'] 			= 	'Lain-lain';
		$data['SubMenuOne'] 	= 	'Sebaran';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['sebaran_pusat'] = array();
		$data['sebaran_tuksono'] = array();

		// $sebaran = $this->M_sebaran->getSebaran();

		// if (isset($sebaran) && !empty($sebaran)) {
		// 	foreach ($sebaran as $sbr) {
		// 		if ($sbr['lokasi_kerja'] == "JOGJA") {
		// 			$data['sebaran_tuksono'][] = array(
		// 				'posX' 		=> ,
		// 				'posY' 		=> ,
		// 				'biru'		=> $sbr['bapil'],
		// 				'merah' 	=> $sbr['bapilsak'],
		// 				'abu'		=> $sbr['matira'],
		// 				'hitam'		=>,
		// 				'title'		=> 'tes',
		// 				'color'		=> 'red',
		// 				'jumlah'	=> $sbr['sudah_isi']
		// 			);
		// 		}else if ($sbr['lokasi_kerja'] == "TUKSONO") {
		// 			$data['sebaran_tuksono'][] = array(
		// 				'posX' 		=> rand(280,679),
		// 				'posY' 		=> rand(107,551),
		// 				'biru'		=> 0,
		// 				'merah' 	=> 2,
		// 				'abu'		=> 12,
		// 				'hitam'		=>,
		// 				'title'		=> 'tes',
		// 				'color'		=> 'red',
		// 				'jumlah'	=> 14
		// 			);
		// 		}
		// 	}
		// }
		$data['sebaran_tuksono'] = array(
			0 => array(
					'posX' 		=> rand(280,679),
					'posY' 		=> rand(107,551),
					'biru'		=> 0,
					'merah' 	=> 2,
					'abu'		=> 12,
					'title'		=> 'tes',
					'color'		=> 'red',
					'jumlah'	=> 14
				),
			1 => array(
					'posX' 		=> rand(280,679),
					'posY' 		=> rand(107,551),
					'biru'		=> 0,
					'merah' 	=> 6,
					'abu'		=> 30,
					'title'		=> 'tes2',
					'color'		=> 'grey',
					'jumlah'	=> 36
				),
			2 => array(
					'posX' 		=> rand(280,679),
					'posY' 		=> rand(107,551),
					'biru'		=> 5,
					'merah' 	=> 4,
					'abu'		=> 33,
					'title'		=> 'tes3',
					'color'		=> 'red',
					'jumlah'	=> 42
				),
			3 => array(
					'posX' 		=> rand(280,679),
					'posY' 		=> rand(107,551),
					'biru'		=> 5,
					'merah' 	=> 8,
					'abu'		=> 16,
					'title'		=> 'tes4',
					'color'		=> 'red',
					'jumlah'	=> 29
				),
			4 => array(
					'posX' 		=> rand(280,679),
					'posY' 		=> rand(107,551),
					'biru'		=> 0,
					'merah' 	=> 0,
					'abu'		=> 24,
					'title'		=> 'tes5',
					'color'		=> 'grey',
					'jumlah'	=> 24
				),
			5 => array(
					'posX' 		=> rand(280,679),
					'posY' 		=> rand(107,551),
					'biru'		=> 1,
					'merah' 	=> 2,
					'abu'		=> 12,
					'title'		=> 'tes6',
					'color'		=> 'red',
					'jumlah'	=> 15
				),
			6 => array(
					'posX' 		=> rand(280,679),
					'posY' 		=> rand(107,551),
					'biru'		=> 4,
					'merah' 	=> 0,
					'abu'		=> 23,
					'title'		=> 'tes7',
					'color'		=> 'blue',
					'jumlah'	=> 27
				),
			7 => array(
					'posX' 		=> rand(280,679),
					'posY' 		=> rand(107,551),
					'biru'		=> 7,
					'merah' 	=> 0,
					'abu'		=> 13,
					'title'		=> 'tes8',
					'color'		=> 'blue',
					'jumlah'	=> 20
				)
		);

		// echo "<pre>";print_r($data['sebaran']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Sebaran/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

}

?>