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
		$data['SubMenuOne'] = 'Monitoring All';
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
		$user = $this->session->username;

		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$filter 		= 	$this->input->post('berdasarkan');
		$nomorPolisi	= 	$this->input->post('nomorpolisi');

		if ($lokasi == '01') {
			$data['monitoringNomorPolisi'] 	= 	$this->M_fleetmonitoring->monitoringNomorPolisi($nomorPolisi);
		}else{
			$data['monitoringNomorPolisi'] 	= 	$this->M_fleetmonitoring->monitoringNomorPolisiCabang($lokasi,$nomorPolisi);
		}
		
		// $data['monitoring'] 
		echo json_encode($data);
	}

	public function prosesKategori()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$filter 		= 	$this->input->post('berdasarkan');
		$kategori 		= 	$this->input->post('kategori');
		$periode 		= 	$this->input->post('periode');
		$periode  		= 	explode(' - ', $periode);

		$periodeawal 	= 	date('Y-m-d', strtotime($periode[0]));
		$periodeakhir 	= 	date('Y-m-d', strtotime($periode[1]));

		if($kategori == 'A')
		{
			if ($lokasi == '01') {
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriPajak($periodeawal, $periodeakhir);
			}else{
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriPajakCabang($lokasi,$periodeawal, $periodeakhir);
			}
			
		}
		elseif($kategori == 'B')
		{
			if ($lokasi == '01') {
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriKIR($periodeawal, $periodeakhir);
			}else{
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriKIRCabang($lokasi,$periodeawal, $periodeakhir);
			}
			
		}
		elseif($kategori == 'C')
		{
			if ($lokasi == '01') {
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriMaintenanceKendaraan($periodeawal, $periodeakhir);
			}else{
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriMaintenanceKendaraanCabang($lokasi,$periodeawal, $periodeakhir);
			}
			
		}
		elseif($kategori == 'D')
		{
			if ($lokasi == '01') {
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriKecelakaan($periodeawal, $periodeakhir);
			}else{
				$data['monitoringKategori'] 	= 	$this->M_fleetmonitoring->monitoringKategoriKecelakaanCabang($lokasi,$periodeawal, $periodeakhir);
			}
			
		}

		echo json_encode($data);
	} 

	public function monitoringKendaraanDetail()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Monitoring All';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$periodeDetail = $this->input->post('PeriodeMonitoringDetail');
		$periodeDetail = explode(' - ', $periodeDetail);

		$periode1 = date('Y-m-d', strtotime($periodeDetail[0]));
		$periode2 = date('Y-m-d', strtotime($periodeDetail[1]));

		$data['detailMonitoring'] = $this->M_fleetmonitoring->getMonitoringKendaraanDetail($periode1,$periode2);
		$data['tgl'] = date('d-m-Y', strtotime($periode1))." / ".date('d-m-Y', strtotime($periode2));

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMonitoring/V_detail_monitoring', $data);
		$this->load->view('V_Footer',$data);
	}

	public function cetakExcelMonitoringKendaraan()
	{
		$this->load->library("Excel");

		$periodeExcel = $this->input->post('PeriodeMonitoringExport');
		$periodeExcelExplode = explode(' - ', $periodeExcel);

		$periode1 = date('Y-m-d', strtotime($periodeExcelExplode[0]));
		$periode2 = date('Y-m-d', strtotime($periodeExcelExplode[1]));

		$data['PeriodeExcel'] = $periodeExcel;
		$data['ExcelMonitoring'] = $this->M_fleetmonitoring->monitoringKategoriMaintenanceKendaraan($periode1,$periode2);

		$this->load->view('GeneralAffair/FleetMonitoring/V_export_excel_monitoring', $data, true);
	}

	public function cetakExcelMonitoringKendaraanDetail()
	{
		$this->load->library("Excel");

		$periodeExcel = $this->input->post('PeriodeMonitoringDetail');
		$periodeExcelDetail = explode(' / ', $periodeExcel);

		$periode1 = date('Y-m-d', strtotime($periodeExcelDetail[0]));
		$periode2 = date('Y-m-d', strtotime($periodeExcelDetail[1]));

		$data['PeriodeExcel'] = $periodeExcel;
		$data['ExcelMonitoringDetail'] = $this->M_fleetmonitoring->getMonitoringKendaraanDetail($periode1,$periode2);

		$this->load->view('GeneralAffair/FleetMonitoring/V_export_excel_monitoring_detail', $data, true);
	}

}