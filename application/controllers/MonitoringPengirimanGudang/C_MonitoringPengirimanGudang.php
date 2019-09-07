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
		$this->load->model('MonitoringPengirimanGudang/M_monitoringpengirimangudang');
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
	
		$data_kirim = $this->M_monitoringpengirimangudang->SelectDashboard();
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

		$getFind = $this->M_monitoringpengirimangudang->FindShipment($query);
		$data['find'] = $getFind;

		$return = $this->load->view('MonitoringPengirimanGudang/V_findTable_gd',$data);
		
	}

	public function btn_edit_gd()
	{
		// echo "<pre>";print_r($_POST);exit();
		$no_ship = $this->input->post('no_ship');
		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}
		$getHeader = $this->M_monitoringpengirimangudang->FindShipment($query);
		$getLine = $this->M_monitoringpengirimangudang->editMPM($no_ship);
		$getProv = $this->M_monitoringpengirimangudang->getProvince();
		$getFinGo = $this->M_monitoringpengirimangudang->getFinishGood();
		// $getCity = $this->M_monitoringpengirimangudang->getCity();
		$jk = $this->M_monitoringpengirimangudang->getJK();
		$getTipe = $this->M_monitoringpengirimangudang->getUom();
		$getUnit = $this->M_monitoringpengirimangudang->getUnit();
		$content_id = $this->M_monitoringpengirimangudang->getContentId();
		$time = $this->M_monitoringpengirimangudang->timegudang($no_ship);
		$cabang = $this->M_monitoringpengirimangudang->getCabang();

		$data['cabang'] = $cabang;
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
		// print_r($_POST);
		$no_ship = $this->input->post('no_ship');
		$actual_loading = $this->input->post('actual_loading');
		$status = $this->input->post('statusgudang');

		// if (empty($status)) {
		// 	echo "<script> Swal.fire({
  // 									type: 'error',
  // 									title: 'Perhatian!',
 	// 								text: 'Harap lengkapi data',
		// 							}) </script>";
		// }
		
         // update header
        $insertActual = $this->M_monitoringpengirimangudang->insertActualTime($no_ship,$actual_loading, $status);

	}


	public function getRow() {
		$getTipe = $this->M_monitoringpengirimangudang->getUom();
		$getUnit = $this->M_monitoringpengirimangudang->getUnit();
		$content_id = $this->M_monitoringpengirimangudang->getContentId();

		$data['content_id'] = $content_id;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;

		echo json_encode($data);
	}


}
?>