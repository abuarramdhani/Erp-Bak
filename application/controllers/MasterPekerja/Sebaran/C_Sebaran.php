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

		$sebaran = $this->M_sebaran->getSebaran();

		if (isset($sebaran) && !empty($sebaran)) {
			foreach ($sebaran as $sbr) {
				$warna = "#2d3436";
				$warna2 = "#636e72";
				if ($sbr['bapilsak'] > 0) {
					$warna = "#d63031";
					$warna2 = "#ff7675";
				}else{
					if ($sbr['bapil'] > 0) {
						$warna = "#0984e3";
						$warna2 = "#74b9ff";
					}else{
						if ($sbr['matira'] > 0) {
							$warna = "#b2bec3";
							$warna2 = "#dfe6e9";
						}else{
							$warna = "#2d3436";
							$warna2 = "#636e72";
						}
					}
				}
				if ($sbr['lokasi_kerja'] == "JOGJA") {
					$data['sebaran_pusat'][] = array(
						'posX' 		=> $sbr['posisix'],
						'posY' 		=> $sbr['posisiy'],
						'biru'		=> $sbr['bapil'],
						'merah' 	=> $sbr['bapilsak'],
						'abu'		=> $sbr['matira'],
						'title'		=> $sbr['unit'],
						'color'		=> $warna,
						'border'	=> $warna2,
						'jumlah'	=> $sbr['sudah_isi']
					);
				}else if ($sbr['lokasi_kerja'] == "TUKSONO") {
					$data['sebaran_tuksono'][] = array(
						'posX' 		=> $sbr['posisix'],
						'posY' 		=> $sbr['posisiy'],
						'biru'		=> $sbr['bapil'],
						'merah' 	=> $sbr['bapilsak'],
						'abu'		=> $sbr['matira'],
						'title'		=> $sbr['unit'],
						'color'		=> $warna,
						'border'	=> $warna2,
						'jumlah'	=> $sbr['sudah_isi']
					);
				}
			}
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Sebaran/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

}

?>