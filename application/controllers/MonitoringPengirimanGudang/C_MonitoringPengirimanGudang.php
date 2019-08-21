<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_MonitoringPengirimanGudang extends CI_Controller{
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
		$this->load->model('MonitoringPengirimanGudang/M_MonitoringPengirimanGudang');
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

	public function dashboard_gd()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data_kirim = $this->M_MonitoringPengirimanGudang->SelectDashboard();
		$data['kirim'] = $data_kirim;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanGudang/V_dashboard_gd',$data);
		$this->load->view('V_Footer',$data);
	}

// fitur search MPM------------------------------------------------------------------------
	public function findShipment_gd()
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
		$this->load->view('MonitoringPengirimanGudang/V_findShipment_gd',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search_gd()
	{

		// print_r($_POST);exit();
		$no_ship = $this->input->post('no_ship');

		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}

		$getFind = $this->M_MonitoringPengirimanGudang->FindShipment($query);
		$data['find'] = $getFind;

		$return = $this->load->view('MonitoringPengirimanGudang/V_findTable_gd',$data);
		
	}

	public function btn_edit_gd()
	{
		$no_ship = $this->input->post('no_ship');
		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}
		$getHeader = $this->M_MonitoringPengirimanGudang->FindShipment($query);
		$getLine = $this->M_MonitoringPengirimanGudang->editMPM($no_ship);
		$getProv = $this->M_MonitoringPengirimanGudang->getProvince();
		$getFinGo = $this->M_MonitoringPengirimanGudang->getFinishGood();
		// $getCity = $this->M_MonitoringPengirimanGudang->getCity();
		$jk = $this->M_MonitoringPengirimanGudang->getJK();
		$getTipe = $this->M_MonitoringPengirimanGudang->getUom();
		$getUnit = $this->M_MonitoringPengirimanGudang->getUnit();
		$content_id = $this->M_MonitoringPengirimanGudang->getContentId();
		$time = $this->M_MonitoringPengirimanGudang->timegudang($no_ship);


		$data['time'] = $time;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;
		$data['content'] = $content_id;
		$data['fingo'] = $getFinGo;
		$data['kendaraan'] = $jk;
		$data['line'] = $getLine;
		$data['header'] = $getHeader;
		$data['prov'] = $getProv;


		$return = $this->load->view('MonitoringPengirimanGudang/V_findEdit_gd',$data);

	}

	public function saveEditMPMgd()
	{
		$no_ship = $this->input->post('no_ship');
		$actual_brkt = $this->input->post('actual_brkt');
		$actual_loading = $this->input->post('actual_loading');
		
         // update header
        $insertActual = $this->M_MonitoringPengirimanGudang->insertActualTime($no_ship,$actual_brkt,$actual_loading);

	}


	public function getRow() {
		$getTipe = $this->M_MonitoringPengirimanGudang->getUom();
		$getUnit = $this->M_MonitoringPengirimanGudang->getUnit();
		$content_id = $this->M_MonitoringPengirimanGudang->getContentId();

		$data['content_id'] = $content_id;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;

		echo json_encode($data);
	}


}
?>