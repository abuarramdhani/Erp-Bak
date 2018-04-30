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
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Monitoring Proses Terakhir';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Monitoring Last Process';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if ($lokasi == '01') {
			$query_lokasi = "";
		}else{
			$query_lokasi = " and kdrn.kode_lokasi_kerja='$lokasi'";
		}
		$data['FleetKendaraan'] = $this->M_fleetmonitoringlast->getFleetKendaraan($query_lokasi);		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMonitoringLast/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function prosesNomorPolisi()
	{
		$lokasi			=	$this->session->kode_lokasi_kerja;
		$filter 		= 	$this->input->post('berdasarkan');
		$nomorPolisi	= 	$this->input->post('nomorpolisi');

		if ($lokasi == '01') {
			$data['monitoringNomorPolisi'] 	= 	$this->M_fleetmonitoringlast->monitoringNomorPolisi($nomorPolisi);
		}else{
			$data['monitoringNomorPolisi'] 	= 	$this->M_fleetmonitoringlast->monitoringNomorPolisi($nomorPolisi,$lokasi);
		}
		
		// $data['monitoring'] 
		echo json_encode($data);
	}

	public function prosesKategori()
	{
		$lokasi 		=	$this->session->kode_lokasi_kerja;
		$filter 		= 	$this->input->post('berdasarkan');
		$kategori 		= 	$this->input->post('kategori');

        $data['monitoringKategori']         =   null;

		if($kategori == 'A')
		{	
			if ($lokasi == '01') {
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriPajak();
			}else{
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriPajakCabang($lokasi);
			}
		}
		elseif($kategori == 'B')
		{	
			if ($lokasi == '01') {
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriKIR();
			}else{
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriKIRCabang($lokasi);
			}
		}
		elseif($kategori == 'C')
		{	
			if ($lokasi == '01') {
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriMaintenanceKendaraan();
			}else{
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriMaintenanceKendaraanCabang($lokasi);
			}
		}
		elseif($kategori == 'D')
		{	
			if ($lokasi == '01') {
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriKecelakaan();
			}else{
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoringlast->monitoringKategoriKecelakaanCabang($lokasi);
			}
		}

		echo json_encode($data);
	}

}