<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetRekapKIR extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetrekapkir');

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

		$data['Title'] = 'Rekap KIR Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dropdownTahun'] 	= 	$this->M_fleetrekapkir->dropdownTahun();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$this->load->view('GeneralAffair/FleetRekapKIR/V_index');

		$this->load->view('V_Footer',$data);
	}

	public function RekapKIR()
	{
		$tahun 	= $this->input->post('value');

		$data['totalKIR'] 		= $this->M_fleetrekapkir->rekapTotalKIR($tahun);
		$data['frekuensiKIR'] 	= $this->M_fleetrekapkir->rekapFrekuensiKIR($tahun);

		echo json_encode($data);
	}
}