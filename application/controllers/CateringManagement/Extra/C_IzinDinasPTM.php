<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_IzinDinasPTM extends CI_Controller
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
		$this->load->model('CateringManagement/Extra/M_izindinasptm');
		$this->load->model('CateringManagement/HitungPesanan/M_hitungpesanan');
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

		$data['Title']			=	'Izin Dinas Pusat Tuksono Mlati';
		$data['Menu'] 			= 	'Extra';
		$data['SubMenuOne'] 	= 	'Izin Dinas Pusat Tuksono Mlati';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_izindinasptm->getPekerjaDinasHariIni();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/IzinDinasPTM/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		$data_awal = $this->M_izindinasptm->getPekerjaDinasHariIni();

		if (!empty($data_awal)) {
			foreach ($data_awal as $da) {
				if ($da['diproses'] == '0') {
					
					$terhitung = $this->M_hitungpesanan->getAbsenShiftSatuByTanggalLokasiTempatMakanNoind($tanggal,$lokasi,$tempat_makan,$noind);
					if (empty($terhitung)) {
						
					}

				}
			}
		}

		
		$data_akhir = $this->M_izindinasptm->getPekerjaDinasHariIni();
		echo json_encode($data_akhir);
	}

}
?>