<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetRekapTotal extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetrekaptotal');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Total';
		$data['Menu'] = 'Rekapitulasi';
		$data['SubMenuOne'] = 'Grafik Total Biaya';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dropdownTahun'] 	= 	$this->M_fleetrekaptotal->dropdownTahun();
		$data['dropdownBulan'] 	= 	$this->M_fleetrekaptotal->dropdownBulan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$this->load->view('GeneralAffair/FleetRekapTotal/V_index');

		$this->load->view('V_Footer',$data);
	}
 
	public function RekapTotal()
	{
		$tahun 	= $this->input->post('cmbTahun');
		$bulan 	= $this->input->post('cmbBulan');

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Total';
		$data['Menu'] = 'Rekapitulasi';
		$data['SubMenuOne'] = 'Grafik Total Biaya';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dropdownTahun'] 	= 	$this->M_fleetrekaptotal->dropdownTahun();
		$data['dropdownBulan'] 	= 	$this->M_fleetrekaptotal->dropdownBulan();

		$data['tahun'] 		= 	$tahun;
		$data['bulan'] 		=	$bulan;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$this->load->view('GeneralAffair/FleetRekapTotal/V_proses');

		$this->load->view('V_Footer',$data);				
	}

	public function ambilData()
	{
		$lokasi = $this->session->kode_lokasi_kerja;
		$tahun 	= $this->input->post('tahun');
		$bulan 	= $this->input->post('bulan');

		if ($lokasi == '01') {
			$data['biayaTotal'] 		= $this->M_fleetrekaptotal->rekapBiayaTotal($tahun, $bulan);
			$data['frekuensiTotal'] 	= $this->M_fleetrekaptotal->rekapFrekuensiTotal($tahun, $bulan);
		}else{
			$data['biayaTotal'] 		= $this->M_fleetrekaptotal->rekapBiayaTotalCabang($tahun, $bulan, $lokasi);
			$data['frekuensiTotal'] 	= $this->M_fleetrekaptotal->rekapFrekuensiTotalCabang($tahun, $bulan, $lokasi);
		}

		echo json_encode($data);
	}
}