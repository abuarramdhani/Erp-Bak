<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_ShipmentMonitoringSystem extends CI_Controller{
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
		$this->load->model('ShipmentMonitoringSystem/M_shipmentmonitoringsystem');
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

	public function detailDO()
	{
		$no_ship = $this->input->post('no_ship');
		$data['no_do'] = $this->M_shipmentmonitoringsystem->ambilDO($no_ship);

		$return = $this->load->view('ShipmentMonitoringSystem/Dashboard/V_detailDO',$data);

	}

	public function dashboard()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data_kirim = $this->M_shipmentmonitoringsystem->SelectDashboard();
		$data['kirim'] = $data_kirim;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringSystem/Dashboard/V_dashboardSMS',$data);
		$this->load->view('V_Footer',$data);
	}

	public function DetailCabang()
	{
		$noncabang = $this->input->post('noncabang');

		$selectDetailCabang = $this->M_shipmentmonitoringsystem->detailCabang($noncabang);

		echo json_encode($selectDetailCabang);

	}

	public function titipBarang()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getFinGo2 = $this->M_shipmentmonitoringsystem->getFinishGood();
		$getProv2 = $this->M_shipmentmonitoringsystem->getProvince();
		$getUnit2 = $this->M_shipmentmonitoringsystem->getGood();
		$cabang2 = $this->M_shipmentmonitoringsystem->getCabang();
		$ambilDataHalilintar = $this->M_shipmentmonitoringsystem->selectValueOfMe();

		$data['good'] = $getUnit2;
		$data['fingo'] = $getFinGo2;
		$data['prov'] = $getProv2;
		$data['cabang'] = $cabang2;
		$data['atta'] = $ambilDataHalilintar;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringSystem/Titip/V_titipBarangSMS',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveTitipBarang()
	{
		$fingo_tb = $this->input->post('fingo_tb');
		$tujuan_tb = $this->input->post('tujuan_tb');
		$namabarang_tb = $this->input->post('namabarang_tb');
		$provinsi_tb = $this->input->post('provinsi_tb');
		$quantity_tb = $this->input->post('quantity_tb');
		$kota_tb = $this->input->post('kota_tb');
		$alamat_tb = strtoupper($this->input->post('alamat_tb'));

		$savingTitipBarang = $this->M_shipmentmonitoringsystem->getSavingMe($fingo_tb,$tujuan_tb,$namabarang_tb,$provinsi_tb,$quantity_tb,$kota_tb,$alamat_tb);
		// $data['tipbar'] = $savingTitipBarang;

	}

// fitur search MPM------------------------------------------------------------------------
	public function find()
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
		$this->load->view('ShipmentMonitoringSystem/Find/V_findShipmentSMS',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search_sms()
	{

		$no_ship = $this->input->post('no_ship');

		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where sh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}

		$getFind = $this->M_shipmentmonitoringsystem->FindShipment($query);
		$data['find'] = $getFind;

		$return = $this->load->view('ShipmentMonitoringSystem/Find/V_findTableSMS',$data);
		
	}

	public function btn_edit_sms()
	{	
		$no_ship = $this->input->post('no_ship');
		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where sh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}
		$getHeader = $this->M_shipmentmonitoringsystem->FindShipment($query);
		$getLine = $this->M_shipmentmonitoringsystem->editMPM($query);
		$getFinGo = $this->M_shipmentmonitoringsystem->getFinishGood();
		$getCabang = $this->M_shipmentmonitoringsystem->getCabang();
		$jk = $this->M_shipmentmonitoringsystem->getJK();
		$getPropinsi = $this->M_shipmentmonitoringsystem->getProvince();
		$getCitynew = $this->M_shipmentmonitoringsystem->getKotaSmua();
		$getGoods = $this->M_shipmentmonitoringsystem->getGoodss();
		$user = $this->session->user;

		$data['fingo'] = $getFinGo;
		$data['cabang'] = $getCabang;
		$data['kendaraan'] = $jk;
		$data['line'] = $getLine;
		$data['header'] = $getHeader;
		$data['kota'] = $getCitynew;
		$data['user'] = $user;
		$data['propinsi'] = $getPropinsi;
		$data['goods'] = $getGoods;
		
		$return = $this->load->view('ShipmentMonitoringSystem/Find/V_findEditSMS',$data);
		
	}

	public function SelectCityAgain()
	{
		$code = $this->input->post('idprovinsiagain');
		$getCity = $this->M_shipmentmonitoringsystem->getKota($code);

		echo json_encode($getCity);
	}

	public function saveEditMPMUnit()
	{
		$no_ship = $this->input->post('no_ship');
		$usrname = $this->input->post('created_header');
		$estimasi = $this->input->post('estimasi');
		$estimasi_loading = $this->input->post('estimasi_loading');
		$finish_good = $this->input->post('finish_good');
		$status = $this->input->post('status');
		$cabang = $this->input->post('cabang');
		$kendaraan = $this->input->post('jk');
		$full_persen = $this->input->post('full_persen');
		$alamat = strtoupper($this->input->post('rumah'));
		$provinsi = $this->input->post('provinsiyeah');
		$koota = $this->input->post('citi');
		$pr_numb = $this->input->post('pr_nomer');
		$pr_linee = $this->input->post('pr_lein');
		//array bellow
		$unit = $this->input->post('unitgud');
		$jumlah = $this->input->post('jumlahsms');
		$jumlahvol = $this->input->post('jumlahvol');
		$pers_vol = $this->input->post('persentasevol');
		$created_line = $this->input->post('created_line');
		$nomor_do = $this->input->post('nomor_do');

         // update header
        $updateSMS1 = $this->M_shipmentmonitoringsystem->updateheaderSMS($no_ship,$usrname,$estimasi,$estimasi_loading,$finish_good,$status,$cabang,$kendaraan,$full_persen,$alamat,$provinsi,$koota,$pr_numb,$pr_linee);
        // update line
        $deleteLine = $this->M_shipmentmonitoringsystem->deleteSMS($no_ship);
        
        foreach ($unit as $key => $value) {
		$updateMPM2 = $this->M_shipmentmonitoringsystem->UpdatebyInsertSMS($no_ship,$jumlah[$key],$value,$jumlahvol[$key],$pers_vol[$key],$created_line[$key],$nomor_do[$key]);
		}

	}

	//input data baru -------------------------------------------------------------------------------- 
	public function desain()
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
		$this->load->view('ShipmentMonitoringSystem/V_cumaliatdesain',$data);
		$this->load->view('V_Footer',$data);
	}

	public function newshp()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getFinGo = $this->M_shipmentmonitoringsystem->getFinishGood();
		$getProv = $this->M_shipmentmonitoringsystem->getProvince();
		$getTipe = $this->M_shipmentmonitoringsystem->getUom();
		$getUnit = $this->M_shipmentmonitoringsystem->getGood();
		$id = $this->M_shipmentmonitoringsystem->getId();
		$jk = $this->M_shipmentmonitoringsystem->getJK();
		$content_id = $this->M_shipmentmonitoringsystem->getContentId();
		$cabang = $this->M_shipmentmonitoringsystem->getCabang();
		$getPropinsi = $this->M_shipmentmonitoringsystem->getProvince();
		$usrname = $this->session->user;

		$data['propinsi'] = $getPropinsi;
		$data['good'] = $getUnit;
		$data['uom'] = $getTipe;
		$data['fingo'] = $getFinGo;
		$data['prov'] = $getProv;
		$data['id'] = $id;
		$data['kendaraan'] = $jk;
		$data['content'] = $content_id;
		$data['cabang'] = $cabang;
		$data['user'] = $usrname;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringSystem/New/V_newShipmentSMS',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SelectCity()
	{
		$code = $this->input->post('idprovinsi');
		$getCity = $this->M_shipmentmonitoringsystem->getKota($code);

		echo json_encode($getCity);

	}

	public function selectVolume()
	{
		$codd = $this->input->post('vehicle_id_sms');
		$getVolume = $this->M_shipmentmonitoringsystem->getVolumee($codd);

		echo json_encode($getVolume);
	}

	public function selectUnitVolume()
	{
		$coee = $this->input->post('idUnit');
		$getUnitVol = $this->M_shipmentmonitoringsystem->getUnitVol($coee);

		echo json_encode($getUnitVol);
	}

	public function getRow() {

		$getUnit2 = $this->M_shipmentmonitoringsystem->getGood2();
		
		echo json_encode($getUnit2);
	}

	public function getRowupdate() {

		$getUnit2 = $this->M_shipmentmonitoringsystem->getGood2();
		$usrname = $this->session->user;
		$data['unit'] = $getUnit2;
		$data['user'] = $usrname;

		echo json_encode($data);
	}

	public function getRow2() {
		$getTipe = $this->M_shipmentmonitoringsystem->getUom();
		$getUnit = $this->M_shipmentmonitoringsystem->getUnit();
		$content_id = $this->M_shipmentmonitoringsystem->getContentId();

		$data['content_id'] = $content_id;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;

		echo json_encode($data);
	}

	public function saveSMS(){

		$usrname = $this->session->user;
		$estimasi = $this->input->post('estimasi');
		$estimasi_loading = $this->input->post('estimasi_loading');
		$finish_good = $this->input->post('finish_good');
		$status = $this->input->post('status');
		$cabang = $this->input->post('cabang');
		$kendaraan = $this->input->post('jk');
		$kota = $this->input->post('city');
		$provinsih = $this->input->post('prov');
		$alamat = strtoupper($this->input->post('alamat'));
		$precentage = $this->input->post('percentage');
		$pr_number = $this->input->post('pr_number');
		$pr_line = $this->input->post('pr_line');
		///dibawah ini line (array)
		$unit = $this->input->post('unit');
		$jumlah = $this->input->post('jumlah');
		$percentage_line = $this->input->post('percentage_line');
		$volume_line = $this->input->post('volume_line');
		$nomor_do = $this->input->post('nomor_do');

		$saveSMS2 = $this->M_shipmentmonitoringsystem->saveInsertHeader2($estimasi,$estimasi_loading,$finish_good,$status,$cabang,$kendaraan,$usrname,$kota,$provinsih,$alamat,$pr_number,$pr_line,$precentage);
		
		$dataId = $this->M_shipmentmonitoringsystem->getShipmentHeader();
		$id = $dataId[0]['id'];

		foreach ($unit as $key => $value) {
		$saveMPM2 = $this->M_shipmentmonitoringsystem->saveInsertLines($id,$value,$jumlah[$key],$usrname,$percentage_line[$key],$volume_line[$key],$nomor_do[$key]);
		}
	
	}

	public function setupkendaraan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$setupVehicle = $this->M_shipmentmonitoringsystem->setupvehicle();

		$data['vehicle'] = $setupVehicle;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringSystem/Setup/V_setupKendaraanSMS',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveSetup()//done
	 {
	 	$gn = $this->input->post('goods_name');
	 	$vg = $this->input->post('volume_goods');

	 	$SaveUnit = $this->M_shipmentmonitoringsystem->SaveUnit($gn,$vg);
	 
	 } 

	 public function saveSetupJK()//done
	 {
	 	$volumejk = $this->input->post('vjk');
	 	$namajk = $this->input->post('jk');

	 	$SaveJK = $this->M_shipmentmonitoringsystem->SaveKendaraan($volumejk,$namajk);
	 } 

	 public function setupcabang()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$getTabelCabang = $this->M_shipmentmonitoringsystem->SetupCabang();
		$getPropinsisetup = $this->M_shipmentmonitoringsystem->getProvince();

		$data['propinsi'] = $getPropinsisetup;
		$data['cabang'] = $getTabelCabang;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringSystem/Setup/V_setupCabangSMS',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InsertCabang()//done
	{
		$cabangname = $this->input->post('nama_cabang');
		$id_prov = $this->input->post('id_prov');
		$id_kota = $this->input->post('id_kota');
		$alamatcabang = $this->input->post('alamat_cabang');

		$saveCabangName = $this->M_shipmentmonitoringsystem->InsertCabangName($cabangname,$id_prov,$id_kota,$alamatcabang);
	}

	public function deleteCabang ()//done
	{
		$id = $this->input->post('cabang_id');
		$deleteCabang = $this->M_shipmentmonitoringsystem->deleteCabang($id);
	}

	public function UpdateCabang()
	{
		$id = strtoupper($this->input->post('id'));
		$alamat = strtoupper($this->input->post('alamat'));
		$kota = strtoupper($this->input->post('kota'));
		$provinsi = strtoupper($this->input->post('provinsi'));
		$namacabang =strtoupper($this->input->post('namacabang'));

		$updateCabang = $this->M_shipmentmonitoringsystem->UpdateCabangKuy($id,$alamat,$kota,$provinsi,$namacabang);
		
	}

	public function bukaModalsms()//done
	{
		$id = $this->input->post('cabang_id');
		$searchCabang = $this->M_shipmentmonitoringsystem->caricabang($id);
		$getPropinsisetupEdit = $this->M_shipmentmonitoringsystem->getProvince();
		$getCitysetupEdit = $this->M_shipmentmonitoringsystem->getCityAll();

		$data['propinsi'] = $getPropinsisetupEdit;
		$data['data'] = $searchCabang;
		$data['citi'] = $getCitysetupEdit;

		$return = $this->load->view('ShipmentMonitoringSystem/Setup/V_setupEditSMS',$data);
	}

	public function SelectCityforCabang()
	{
		$id = $this->input->post('idProv');
		$getCityforCbg = $this->M_shipmentmonitoringsystem->getKotaCbg($id);

		echo json_encode($getCityforCbg);
	}

	public function deleteRow()//done
	{
		$id = $this->input->post('id');
		$deleteRoow = $this->M_shipmentmonitoringsystem->deleteRoow($id);
	}

	public function editCabang()

	{
		$id = $this->input->post('id');
		$alamat = strtoupper($this->input->post('alamat'));
		$namacabang = strtoupper($this->input->post('namacabang'));

		$editRow = $this->M_shipmentmonitoringsystem->editRow($id,$alamat,$namacabang);
	}

	public function deleteUnit()
	{
		$id = $this->input->post('id');

		$deleteRowUnit = $this->M_shipmentmonitoringsystem->deleteRowUnit($id);
	}

	public function deleteVehicle()//done
	{
		$id = $this->input->post('id');

		$deleteRowUnit = $this->M_shipmentmonitoringsystem->deleteVehicleSMS($id);
	}

	public function EditVehicle()//done
	{
		$id = strtoupper($this->input->post('id'));
		$name = strtoupper($this->input->post('name'));
		$volume = strtoupper($this->input->post('volume'));


		$saveEditVehicle = $this->M_shipmentmonitoringsystem->UpdateVehicle($id,$name,$volume);
	}

	public function EditGudla()//done
	{
		$id = strtoupper($this->input->post('id_goodla'));
		$name = strtoupper($this->input->post('name'));
		$vol = strtoupper($this->input->post('vol'));

		$saveEditGudla = $this->M_shipmentmonitoringsystem->saveGoods($id,$name,$vol);
	}

	public function openVehicle()
	{
		$id = $this->input->post('id_vehicle');

		$data = $this->M_shipmentmonitoringsystem->getVehicle($id);

		$data['vehicle'] = $data;
		$return = $this->load->view('ShipmentMonitoringSystem/Setup/V_vehicleEditSMS',$data);

	}

	public function openGoods()
	{
		$id = $this->input->post('id_goods');

		$data = $this->M_shipmentmonitoringsystem->getGoods($id);

		$data['goods'] = $data;
		$return = $this->load->view('ShipmentMonitoringSystem/Setup/V_unitEditSMS',$data);
	}

	public function deleteShipment()
	{
		$id = $this->input->post('id_shipment');
		$hapus = $this->M_shipmentmonitoringsystem->hapusShipment($id);
	}

	public function shipmenthistory()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$history = $this->M_shipmentmonitoringsystem->history();
		$data['find'] = $history;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringSystem/History/V_historySMS',$data);
		$this->load->view('V_Footer',$data);

	}

	public function undelivered ()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$undeliver = $this->M_shipmentmonitoringsystem->undelivered();
		$data['undeliver'] = $undeliver;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringSystem/Undeliver/V_undeliveredShipment',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function detailShpUndeliver()
	{
		$id = $this->input->post('id');
		$arrayForHeader = $this->M_shipmentmonitoringsystem->getShpById($id);
		$arrayForLine = $this->M_shipmentmonitoringsystem->getLineById($id);
		$getFinGoUndlvr = $this->M_shipmentmonitoringsystem->getFinishGood();
		$getProvUndlvr = $this->M_shipmentmonitoringsystem->getProvince();
		$getTipeUndlvr = $this->M_shipmentmonitoringsystem->getUom();
		$getUnitUndlvr = $this->M_shipmentmonitoringsystem->getGood();
		$jkUndlvr = $this->M_shipmentmonitoringsystem->getJK();
		$content_idUndlvr = $this->M_shipmentmonitoringsystem->getContentId();
		$cabangUndlvr = $this->M_shipmentmonitoringsystem->getCabang();
		$getPropinsiUndlvr = $this->M_shipmentmonitoringsystem->getProvince();
		$getCitysetupEdit2 = $this->M_shipmentmonitoringsystem->getCityAll();

		$data['kota'] = $getCitysetupEdit2;
		$data['good'] = $getUnitUndlvr;
		$data['uom'] = $getTipeUndlvr;
		$data['fingo'] = $getFinGoUndlvr;
		$data['prov'] = $getProvUndlvr;
		$data['kendaraan'] = $jkUndlvr;
		$data['content'] = $content_idUndlvr;
		$data['cabang'] = $cabangUndlvr;
		$data['header'] = $arrayForHeader;
		$data['line'] = $arrayForLine;

		return $this->load->view('ShipmentMonitoringSystem/Undeliver/V_modalShipmentUndeliver',$data);
	}

	public function setupunit()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$setupGoods = $this->M_shipmentmonitoringsystem->setupUnit();
		
		$data['goods'] = $setupGoods;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringSystem/Setup/V_setupUnitSMS',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detailPR() //done
	{
		$nopr = $this->input->post('id');
		$linepr = $this->input->post('line');
		$getDetailPR= $this->M_shipmentmonitoringsystem->getDetailPRQuery($nopr,$linepr);
		$data['iniPR'] = $getDetailPR;

		$return = $this->load->view('ShipmentMonitoringSystem/Dashboard/V_detailPR',$data);
	}

	public function export() //done
	{	
		
		$date = date('d-m-Y');
		
		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$style_col = array(
          'font' => array('bold' => true),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
          )
        );
        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
          )
        );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT SHIPMENT MONITORING SYSTEM");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "No Shipment");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Jenis Kendaraan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Estimasi Berangkat");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Estimasi Loading");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Actual Loading");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Finish Good");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Cabang Tujuan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Muatan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Status Full");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Creation Date");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        foreach(range('B','K') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }
        foreach(range('A','J') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $fetch = $this->M_shipmentmonitoringsystem->history();
        $no = 1;
        $numrow = 5;
        foreach($fetch as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['no_shipment']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['jenis_kendaraan']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['berangkat']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['loading']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['actual_loading']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['asal_gudang']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['cabang']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['muatan']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['status']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['creation_date']);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            
            $no++;
            $numrow++;
        }
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Report Shipment (SMS)');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report_Shipment_Monitoring_Tanggal '.$date.'.xlsx"');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');

}


}
?>