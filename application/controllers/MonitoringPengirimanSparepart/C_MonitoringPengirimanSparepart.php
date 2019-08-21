<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_MonitoringPengirimanSparepart extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('MonitoringPengirimanSparepart/M_monitoringpengirimansparepart');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		date_default_timezone_set('Asia/Jakarta');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function dashboard_sp()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data_kirim = $this->M_monitoringpengirimansparepart->SelectDashboard();
		$data['kirim'] = $data_kirim;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanSparepart/V_dashboard_sp',$data);
		$this->load->view('V_Footer',$data);
	}

// fitur search MPM------------------------------------------------------------------------
	public function findShipment_sp()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanSparepart/V_findShipment_sp',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search_sp()
	{

		// print_r($_POST);exit();
		$no_ship = $this->input->post('no_ship');

		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}

		$getFind = $this->M_monitoringpengirimansparepart->FindShipment($query);
		$data['find'] = $getFind;

		$return = $this->load->view('MonitoringPengirimanSparepart/V_findTable_sp',$data);
		
	}

	public function btn_edit_sp()
	{
		$no_ship = $this->input->post('no_ship');
		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}
		$getHeader = $this->M_monitoringpengirimansparepart->FindShipment($query);
		$getLine = $this->M_monitoringpengirimansparepart->editMPM($no_ship);
		$getCabang = $this->M_monitoringpengirimansparepart->getCabang();
		$getFinGo = $this->M_monitoringpengirimansparepart->getFinishGood();
		$jk = $this->M_monitoringpengirimansparepart->getJK();
		$getTipe = $this->M_monitoringpengirimansparepart->getUom();
		$content_id = $this->M_monitoringpengirimansparepart->getContentId();
		$getUnit = $this->M_monitoringpengirimansparepart->getUnit();

		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;
		$data['content'] = $content_id;
		$data['fingo'] = $getFinGo;
		$data['cabang'] = $getCabang;
		$data['kendaraan'] = $jk;
		$data['line'] = $getLine;
		$data['header'] = $getHeader;

		// echo "<pre>";print_r($data);exit();

		$return = $this->load->view('MonitoringPengirimanSparepart/V_findEdit_sp',$data);

	}
	public function getRowsp() {
		$getTipe = $this->M_monitoringpengirimansparepart->getUom();
		$getUnit = $this->M_monitoringpengirimansparepart->getUnitSp();
		$content_id = $this->M_monitoringpengirimansparepart->getSparepart();

		$data['content_id'] = $content_id;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;

		echo json_encode($data);
	}

	public function saveEditMPMsp()
	{
		$no_ship = $this->input->post('no_ship');
		$usrname = $this->session->user;
		$estimasi = $this->input->post('estimasi');
		$estimasi_loading = $this->input->post('estimasi_loading');
		$finish_good = $this->input->post('finish_good');
		$status = $this->input->post('status');
		$kendaraan = $this->input->post('jk');
		$unit = $this->input->post('unit'); //sparepart 
		$jumlah = $this->input->post('jumlah');
		$tipe = $this->input->post('tipe');
		$content = $this->input->post('content');
		$cabang = $this->input->post('cabang');
		
         // update header
        $updateMPM1 = $this->M_monitoringpengirimansparepart->updateMPM($estimasi,$estimasi_loading,$finish_good,$status,$cabang,$kendaraan,$usrname,$no_ship);
        // update line
        $deleteLine = $this->M_monitoringpengirimansparepart->deleteMPM($no_ship);
        
        foreach ($content as $key => $value) {
		$updateMPM2 = $this->M_monitoringpengirimansparepart->UpdatebyInsertMPM($no_ship,$value,$jumlah[$key],$tipe[$key],$unit[$key],$usrname);
		}

	}

}
?>