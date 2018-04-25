<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetRekapMaintenance extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetrekapmaintenance');

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

		$data['Title'] = 'Rekap Maintenance Kendaraan';
		$data['Menu'] = 'Rekapitulasi';
		$data['SubMenuOne'] = 'Grafik Maintenance';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dropdownTahun'] 	= 	$this->M_fleetrekapmaintenance->dropdownTahun();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$this->load->view('GeneralAffair/FleetRekapMaintenance/V_index');

		$this->load->view('V_Footer',$data);
	}

	public function RekapMaintenance()
	{
		$tahun 	=	$this->input->post('cmbPeriode');

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Maintenance Kendaraan';
		$data['Menu'] = 'Rekapitulasi';
		$data['SubMenuOne'] = 'Grafik Maintenance';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dropdownTahun'] 	= 	$this->M_fleetrekapmaintenance->dropdownTahun();

		$data['tahun'] 			= 	$tahun;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$this->load->view('GeneralAffair/FleetRekapMaintenance/V_proses');

		$this->load->view('V_Footer',$data);
	}

	public function ambilData()
	{
		$lokasi = $this->session->kode_lokasi_kerja;
		$tahun 	= $this->input->post('tahun');

		if ($lokasi == '01') {
			$data['totalMaintenance'] 		= $this->M_fleetrekapmaintenance->rekapTotalMaintenance($tahun);
			$data['frekuensiMaintenance'] 	= $this->M_fleetrekapmaintenance->rekapFrekuensiMaintenance($tahun);
		}else{
			$data['totalMaintenance'] 		= $this->M_fleetrekapmaintenance->rekapTotalMaintenanceCabang($tahun,$lokasi);
			$data['frekuensiMaintenance'] 	= $this->M_fleetrekapmaintenance->rekapFrekuensiMaintenanceCabang($tahun,$lokasi);
		}
		

		echo json_encode($data);
	}
}