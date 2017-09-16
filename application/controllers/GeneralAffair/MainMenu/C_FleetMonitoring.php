<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetMonitoring extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetmonitoring');

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

		$data['Title'] = 'Monitoring';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FleetKendaraan'] = $this->M_fleetmonitoring->getFleetKendaraan();		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMonitoring/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function prosesNomorPolisi()
	{
		$filter 		= 	$this->input->post('berdasarkan');
		$nomorPolisi	= 	$this->input->post('nomorpolisi');

		$data['monitoringNomorPolisi'] 	= 	$this->M_fleetmonitoring->monitoringNomorPolisi($nomorPolisi);
		// $data['monitoring'] 
		echo json_encode($data);
	}

	public function prosesKategori()
	{
		$filter 		= 	$this->input->post('berdasarkan');
		$kategori 		= 	$this->input->post('kategori');
		$periode 		= 	$this->input->post('periode');
		$periode  		= 	explode(' - ', $periode);

		$periodeawal 	= 	date('Y-m-d', strtotime($periode[0]));
		$periodeakhir 	= 	date('Y-m-d', strtotime($periode[1]));

		if($kategori == 'A')
		{
			$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriPajak($periodeawal, $periodeakhir);
		}
		elseif($kategori == 'B')
		{
			$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriKIR($periodeawal, $periodeakhir);
		}
		elseif($kategori == 'C')
		{
			$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriMaintenanceKendaraan($periodeawal, $periodeakhir);
		}
		elseif($kategori == 'D')
		{
			$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriKecelakaan($periodeawal, $periodeakhir);
		}

		echo json_encode($data);
	}

}