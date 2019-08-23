<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_MonitoringPengirimanUnit extends CI_Controller{
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
		$this->load->model('MonitoringPengirimanUnit/M_monitoringpengirimanunit');
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

	public function dashboard_unit()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data_kirim = $this->M_monitoringpengirimanunit->SelectDashboard();
		$data['kirim'] = $data_kirim;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanUnit/V_dashboard',$data);
		$this->load->view('V_Footer',$data);
	}

// fitur search MPM------------------------------------------------------------------------
	public function findShipment_unit()
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
		$this->load->view('MonitoringPengirimanUnit/V_findShipment',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search_unit()
	{

		$no_ship = $this->input->post('no_ship');

		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}

		$getFind = $this->M_monitoringpengirimanunit->FindShipment($query);
		$data['find'] = $getFind;

		$return = $this->load->view('MonitoringPengirimanUnit/V_findTable',$data);
		
	}

	public function btn_edit_unit()
	{
		$no_ship = $this->input->post('no_ship');
		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}
		$getHeader = $this->M_monitoringpengirimanunit->FindShipment($query);
		$getLine = $this->M_monitoringpengirimanunit->editMPM($no_ship);
		$getFinGo = $this->M_monitoringpengirimanunit->getFinishGood();
		$getCabang = $this->M_monitoringpengirimanunit->getCabang();
		$jk = $this->M_monitoringpengirimanunit->getJK();
		$getTipe = $this->M_monitoringpengirimanunit->getUom();
		$getUnit = $this->M_monitoringpengirimanunit->getUnit();
		$content_id = $this->M_monitoringpengirimanunit->getContentId();
		$getUnitEdit = $this->M_monitoringpengirimanunit->getUnitEdit();
		$content_idEdit = $this->M_monitoringpengirimanunit->getContentIdEdit();
		
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;
		$data['content'] = $content_id;
		$data['fingo'] = $getFinGo;
		$data['cabang'] = $getCabang;
		$data['kendaraan'] = $jk;
		$data['line'] = $getLine;
		$data['header'] = $getHeader;
		$data['unitedit'] = $getUnitEdit;
		$data['contentedit'] = $content_idEdit;

		$return = $this->load->view('MonitoringPengirimanUnit/V_findEdit',$data);

	}

	public function saveEditMPMUnit()
	{
		$no_ship = $this->input->post('no_ship');
		$usrname = $this->session->user;
		$estimasi = $this->input->post('estimasi');
		$estimasi_loading = $this->input->post('estimasi_loading');
		$finish_good = $this->input->post('finish_good');
		// $status = $this->input->post('status');
		$cabang = $this->input->post('cabang');
		$kendaraan = $this->input->post('jk');
		$unit = $this->input->post('unit');
		$jumlah = $this->input->post('jumlah');
		$tipe = $this->input->post('tipe');
		$content = $this->input->post('content');
		
         // update header
        $updateMPM1 = $this->M_monitoringpengirimanunit->updateMPM($estimasi,$estimasi_loading,$finish_good,$cabang,$kendaraan,$usrname,$no_ship);
        // update line
        $deleteLine = $this->M_monitoringpengirimanunit->deleteMPM($no_ship);
        
        foreach ($content as $key => $value) {
		$updateMPM2 = $this->M_monitoringpengirimanunit->UpdatebyInsertMPM($no_ship,$value,$jumlah[$key],$tipe[$key],$unit[$key],$usrname);
		}
		// redirect('MonitoringPengiriman/Dashboard');

	}

	//input data baru -------------------------------------------------------------------------------- 

	public function newShipment()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$prov_id = $this->input->post('provinsi');
		$getFinGo = $this->M_monitoringpengirimanunit->getFinishGood();
		$getProv = $this->M_monitoringpengirimanunit->getProvince();
		$getTipe = $this->M_monitoringpengirimanunit->getUom();
		$getUnit = $this->M_monitoringpengirimanunit->getUnit();
		$id = $this->M_monitoringpengirimanunit->getId();
		$jk = $this->M_monitoringpengirimanunit->getJK();
		$content_id = $this->M_monitoringpengirimanunit->getContentId();
		$cabang = $this->M_monitoringpengirimanunit->getCabang();

		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;
		$data['fingo'] = $getFinGo;
		$data['prov'] = $getProv;
		$data['id'] = $id;
		$data['kendaraan'] = $jk;
		$data['content'] = $content_id;
		$data['cabang'] = $cabang;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanUnit/V_newShipment',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SelectCity()
	{
		$code = $this->input->post('param');
		$getCity = $this->M_monitoringpengirimanunit->getCity2($code);

		$data['city2'] = $getCity;
		echo json_encode($data);

	}

	public function getRow() {
		$getTipe = $this->M_monitoringpengirimanunit->getUom();
		$getUnit = $this->M_monitoringpengirimanunit->getUnit();
		$content_id = $this->M_monitoringpengirimanunit->getContentId();

		$data['content_id'] = $content_id;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;

		echo json_encode($data);
	}

	public function saveMPM(){


		$usrname = $this->session->user;
		$estimasi = $this->input->post('estimasi');
		$estimasi_loading = $this->input->post('estimasi_loading');
		$finish_good = $this->input->post('finish_good');
		// $status = $this->input->post('status');
		$cabang = $this->input->post('cabang');
		$kendaraan = $this->input->post('jk');
		$unit = $this->input->post('unit');
		$jumlah = $this->input->post('jumlah');
		$tipe = $this->input->post('tipe');
		$content = $this->input->post('content');

		$saveMPM1 = $this->M_monitoringpengirimanunit->saveInsertMpm($estimasi,$estimasi_loading,$finish_good,$cabang,$kendaraan,$usrname);
		$dataId = $this->M_monitoringpengirimanunit->getNumberShipment();
		$id = $dataId[0]['id'];

		foreach ($content as $key => $value) {
		$saveMPM2 = $this->M_monitoringpengirimanunit->saveInsertMpm2($id,$value,$jumlah[$key],$tipe[$key],$unit[$key],$usrname);
		}
	
	    // redirect('MonitoringPengiriman/Dashboard');
	}
	public function setup()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// $getProv = $this->M_monitoringpengirimanunit->getProvince();
		// $jk = $this->M_monitoringpengirimanunit->getJK();
		// $getUnit = $this->M_monitoringpengirimanunit->getUnit();
		$setupVehicle = $this->M_monitoringpengirimanunit->setupvehicle();
		$setupUnit = $this->M_monitoringpengirimanunit->setupUnit();

		$data['unit'] = $setupUnit;
		$data['vehicle'] = $setupVehicle;
		// $data['kendaraan'] = $jk;
		// $data['prov'] = $getProv;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanUnit/V_setup',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveSetup()
	 {
	 	$set_jk = $this->input->post('set_jk');
	 	$set_unit = $this->input->post('set_unit');

	 	if ($set_jk == NULL){ 
	 	$SaveUnit = $this->M_monitoringpengirimanunit->SaveUnit($set_unit);
	 	}elseif ($set_unit == NULL) {
	 	$SaveJK = $this->M_monitoringpengirimanunit->SaveJK($set_jk);
	 	}else {
	 	$SaveUnit = $this->M_monitoringpengirimanunit->SaveUnit($set_unit);
	 	$SaveJK = $this->M_monitoringpengirimanunit->SaveJK($set_jk);
	 	}
	 } 

	 public function cabang()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$getTabelCabang = $this->M_monitoringpengirimanunit->SetupCabang();

		$data['cabang'] = $getTabelCabang;

		// echo "<pre>";print_r($data['cabang']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanUnit/V_setupCabang',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveCabang()
	{
		$cabangname = $this->input->post('cabang');
		$alamatcabang = $this->input->post('alamat');
		// echo "<pre>";print_r($_POST);exit();
		$saveCabangName = $this->M_monitoringpengirimanunit->saveCabangName($cabangname,$alamatcabang);
	}

	public function bukaModal()
	{
		$id = $this->input->post('cabang_id');
		$searchCabang = $this->M_monitoringpengirimanunit->caricabang($id);
		$data['data'] = $searchCabang;

		// echo "pre";print_r($data);exit();
		$return = $this->load->view('MonitoringPengirimanUnit/V_setupEdit',$data);
	}

	public function deleteRow()
	{
		$id = $this->input->post('id');
		$deleteRoow = $this->M_monitoringpengirimanunit->deleteRoow($id);
	}

	public function editCabang()

	{
		$id = $this->input->post('id');
		$alamat = strtoupper($this->input->post('alamat'));
		$namacabang = strtoupper($this->input->post('namacabang'));

		$editRow = $this->M_monitoringpengirimanunit->editRow($id,$alamat,$namacabang);
	}

	public function deleteUnit()
	{
		$id = $this->input->post('id');

		$deleteRowUnit = $this->M_monitoringpengirimanunit->deleteRowUnit($id);
	}

	public function deleteVehicle()
	{
		$id = $this->input->post('id');

		$deleteRowUnit = $this->M_monitoringpengirimanunit->deleteRowUnit2($id);
	}

	public function EditVehicle()
	{
		$id = strtoupper($this->input->post('id'));
		$name = strtoupper($this->input->post('name'));

		$saveEditVehicle = $this->M_monitoringpengirimanunit->saveVehicle($id,$name);


	}

	public function EditUnit()
	{
		$id = strtoupper($this->input->post('id'));
		$name = strtoupper($this->input->post('name'));

		$saveEditVehicle = $this->M_monitoringpengirimanunit->saveUnit2($id,$name);
	}

	public function openVehicle()
	{
		$id = $this->input->post('id_vehicle');

		$data = $this->M_monitoringpengirimanunit->getVehicle($id);

		$data['vehicle'] = $data;
		$return = $this->load->view('MonitoringPengirimanUnit/V_vehicleEdit',$data);

	}

	public function openUnit()
	{
		$id = $this->input->post('id_unit');

		$data = $this->M_monitoringpengirimanunit->getUnit2($id);

		$data['unit'] = $data;
		$return = $this->load->view('MonitoringPengirimanUnit/V_unitEdit',$data);
	}

}
?>