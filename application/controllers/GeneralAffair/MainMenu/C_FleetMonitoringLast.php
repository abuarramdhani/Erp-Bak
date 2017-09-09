<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetMonitoringLast extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetmonitoringlast');

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
		$data['SubMenuOne'] = 'Monitoring Last Process';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FleetKendaraan'] = $this->M_fleetmonitoringlast->getFleetKendaraan();		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMonitoringLast/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function prosesNomorPolisi()
	{
		$filter 		= 	$this->input->post('berdasarkan');
		$nomorPolisi	= 	$this->input->post('nomorpolisi');

		$data['monitoringNomorPolisi'] 	= 	$this->M_fleetmonitoringlast->monitoringNomorPolisi($nomorPolisi);
		// $data['monitoring'] 
		echo json_encode($data);
	}

	public function prosesKategori()
	{
		$filter 		= 	$this->input->post('berdasarkan');
		$kategori 		= 	$this->input->post('kategori');

		if($kategori == 'A')
		{
			$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriPajak();
		}
		elseif($kategori == 'B')
		{
			$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriKIR();
		}
		elseif($kategori == 'C')
		{
			$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriMaintenanceKendaraan();
		}
		elseif($kategori == 'D')
		{
			$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriKecelakaan();
		}

		echo json_encode($data);
	}

}