<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form'); 
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SiteManagement/MainMenu/M_monitoring');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['duedatelist'] = $this->M_monitoring->duedatelist();
		$data['listkategori'] = $this->M_monitoring->getKategori();
		$data['bathroom'] = $this->M_monitoring->alertBathroom();
		$data['floorparking'] = $this->M_monitoring->alertFloorParking();
		$data['trashcan'] = $this->M_monitoring->alertTrashCan();
		$data['land'] = $this->M_monitoring->alertLand();
		$data['sajadah'] = $this->M_monitoring->alertSajadah();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Monitoring/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function prosesdata()
	{	$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Site Management';
		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$daterange = $this->input->post('sm_tglmonitoring');
		$daterange = explode('-', $daterange);
		$start = date('Y-m-d', strtotime($daterange[0]));
		$end = date('Y-m-d', strtotime($daterange[1]));
		$kategori = $this->input->post('sm_selectkategori');
		$kategori = explode('-', $kategori);
		$kat = $kategori[0];
		$kat_detail = $kategori[1];
		$periode = $this->input->post('sm_periode');
		$hari = $this->input->post('sm_hari');
		$tgl_proses = date('Y-m-d H:i:s');

		$tgl1  		= 	new DateTime($start);
	 	$tgl2 		=	new DateTime($end);
	
	 	if ($periode==4) {
			$interval	=	new DateInterval('P1M');
	 	}else{
	 		$interval	=	new DateInterval('P'.$periode.'W');
	 	}

 		$CekData = $this->M_monitoring->rekapData($start,$end,$kat,$kat_detail,$hari,$periode)->num_rows();
 		// echo $periode;
 		// // print_r($CekData);
 		// exit();
		
		if ($CekData==0) {
			$period 	=	new DatePeriod($tgl1, $interval, $tgl2);
			foreach($period as $p)
			{
				$tanggalloop 	=	$p->format('Y-m-d');
				
				$DataMonitoring = $this->M_monitoring->listMonitoring($kat,$kat_detail,$hari,$periode,$tanggalloop)->num_rows();
				if($DataMonitoring==0) {
					$this->M_monitoring->addData($start,$end,$user_id,$tgl_proses,$kat_detail,$kat,$hari,$periode,$tanggalloop);
					
				}
				
			}
		}
		// exit();
		$data['rekapData'] = $this->M_monitoring->rekapData($start,$end,$kat,$kat_detail,$hari,$periode)->result_array();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SiteManagement/Monitoring/V_DataMonitoring', $data);
		$this->load->view('V_Footer',$data);
	}

	public function InsertDataMonitoring()
	{	$id_jdwl = $this->input->post('id_jadwal');
		$pic = $this->input->post('pic');
		$ket = $this->input->post('ket');
		$status = $this->input->post('status');

		$this->M_monitoring->UpdateDataMonitoring($id_jdwl,$pic,$ket,$status);
	}

}
