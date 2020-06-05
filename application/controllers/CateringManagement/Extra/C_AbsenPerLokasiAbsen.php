<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_AbsenPerLokasiAbsen extends CI_Controller
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
		$this->load->model('CateringManagement/Extra/M_absenperlokasiabsen');
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

		$data['Title']			=	'Absen Per Lokasi Absen';
		$data['Menu'] 			= 	'Extra';
		$data['SubMenuOne'] 	= 	'Absen Per Lokasi Absen';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/AbsenPerLokasiAbsen/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getList(){
		$tanggal = $this->input->get('tanggal');
		$device = $this->M_absenperlokasiabsen->getDeviceAbsen();
		$data = array();
		if (!empty($device)) {
			foreach ($device as $key => $value) {
				if ($value['office'] == '01') {
					$office = "Yogyakarta";
				}elseif ($value['office'] == '02') {
					$office = 'Tuksono';
				}elseif ($value['office'] == '03') {
					$office = 'Mlati';
				}else{
					$office = '-';
				}

				$jml_absen = $this->M_absenperlokasiabsen->getCountPresensiTpresensirill($tanggal,$value['inisial_lokasi']);
				$jml_katering = $this->M_absenperlokasiabsen->getCountCateringTpresensi($tanggal,$value['inisial_lokasi']);
				$last_update = $this->M_absenperlokasiabsen->getLastUpdatePresensiTpresensiriil($value['inisial_lokasi']);

				$data[$key] = array(
					'device_name' 		=> $value['device_name'],
					'inisial_lokasi'	=> $value['inisial_lokasi'],
					'office' 			=> $office,
					'jml_absen' 		=> $jml_absen,
					'jml_katering' 		=> $jml_katering,
					'last_update' 		=> $last_update
				);
			}
		}
		echo json_encode($data);
	}

	public function getDetail(){
		$tanggal = $this->input->get('tanggal');
		$inisial_lokasi = $this->input->get('inisial_lokasi');
		$absen = $this->M_absenperlokasiabsen->getDetailAbsenByTanggalUser($tanggal,$inisial_lokasi);
		$katering = $this->M_absenperlokasiabsen->getDetailKateringByTanggalUser($tanggal,$inisial_lokasi);

		$data = array(
			'katering' => $katering,
			'absen' => $absen
		);

		echo json_encode($data);
	}

}

?>