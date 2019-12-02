<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_ShipmentMonitoringGudang extends CI_Controller{
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
		$this->load->model('ShipmentMonitoringGudang/M_shipmentmonitoringgudang');
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

	public function dashboardGudang()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data_kirim = $this->M_shipmentmonitoringgudang->SelectDashboard();
		$data['kirim'] = $data_kirim;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringGudang/Dashboard/V_dashboardSMS_Gudang',$data);
		$this->load->view('V_Footer',$data);
	}

	public function DetailCabang()
	{
		$noncabang = $this->input->post('noncabang');

		$selectDetailCabang = $this->M_shipmentmonitoringgudang->detailCabang($noncabang);

		echo json_encode($selectDetailCabang);

	}

	public function detailPR() //done
	{
		$nopr = $this->input->post('id');
		$linepr = $this->input->post('line');
		$getDetailPR= $this->M_shipmentmonitoringgudang->getDetailPRQuery($nopr,$linepr);
		$data['iniPR'] = $getDetailPR;

		$return = $this->load->view('ShipmentMonitoringGudang/Dashboard/V_detailPR_Gdg',$data);
	}

	public function titipBarangGudang()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		// $getFinGo2 = $this->M_shipmentmonitoringsystem->getFinishGood();
		// $getProv2 = $this->M_shipmentmonitoringsystem->getProvince();
		// $getUnit2 = $this->M_shipmentmonitoringsystem->getGood();
		// $cabang2 = $this->M_shipmentmonitoringsystem->getCabang();
		$ambilDataHalilintar = $this->M_shipmentmonitoringgudang->selectValueOfMe();

		// $data['good'] = $getUnit2;
		// $data['fingo'] = $getFinGo2;
		// $data['prov'] = $getProv2;
		// $data['cabang'] = $cabang2;
		$data['atta'] = $ambilDataHalilintar;
	

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringGudang/Titip/V_titipBarangResGudang',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveTitipBarang()
	{
		$ent_id = $this->input->post('entrusted_id');
		$jumlah_gdg = $this->input->post('jumlah_asli');

		$updateDataRichis = $this->M_shipmentmonitoringgudang->UpdateDong($ent_id,$jumlah_gdg);
	}

	public function saveKirimBarang()
	{
		$ent_id = $this->input->post('entrusted_id');
		$jumlah_gdg = $this->input->post('jumlah_dikirim');

		$updateDataRichis = $this->M_shipmentmonitoringgudang->UpdateDong2($ent_id,$jumlah_gdg);
	}

// fitur search MPM------------------------------------------------------------------------
	public function findShipmentGudang()
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
		$this->load->view('ShipmentMonitoringGudang/Find/V_findShipmentSMS_Gudang',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search_sms_gudang()
	{

		$no_ship = $this->input->post('no_ship');

		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where sh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}

		$getFind = $this->M_shipmentmonitoringgudang->FindShipment($query);
		$data['find'] = $getFind;

		$return = $this->load->view('ShipmentMonitoringGudang/Find/V_findTableSMS_Gudang',$data);
		
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
		$getHeader = $this->M_shipmentmonitoringgudang->FindShipment($query);
		$getLine = $this->M_shipmentmonitoringgudang->editMPM($query);
		$getFinGo = $this->M_shipmentmonitoringgudang->getFinishGood();
		$getCabang = $this->M_shipmentmonitoringgudang->getCabang();
		$jk = $this->M_shipmentmonitoringgudang->getJK();
		$getPropinsi = $this->M_shipmentmonitoringgudang->getProvince();
		$getCitynew = $this->M_shipmentmonitoringgudang->getKotaSmua();
		$getGoods = $this->M_shipmentmonitoringgudang->getGoodss();
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
		
		$return = $this->load->view('ShipmentMonitoringGudang/Find/V_findEditSMS_Gudang',$data);
	
	}

	public function SelectCityAgain()
	{
		$code = $this->input->post('idprovinsiagain');
		$getCity = $this->M_shipmentmonitoringgudang->getKota($code);

		echo json_encode($getCity);
	}

	public function UpdateGudang()
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
		$actual_loading = $this->input->post('actual_loading');
		$actual_berangkat = $this->input->post('actual_berangkat');
		$nama_driver = strtoupper($this->input->post('nama_driver'));
		$plat_nomor = strtoupper($this->input->post('plat_nomor'));
		//array bellow
		$unit = $this->input->post('unitgud');
		$jumlah = $this->input->post('jumlahsms');
		$jumlahvol = $this->input->post('jumlahvol');
		$pers_vol = $this->input->post('persentasevol');
		$jml_terkirim = $this->input->post('jumlah_terkirim');
		$created_line = $this->input->post('created_line');
		$no_do = $this->input->post('no_do');

         // update header
        $updateSMS1 = $this->M_shipmentmonitoringgudang->updateheaderSMS($no_ship,$usrname,$estimasi,$estimasi_loading,$finish_good,$status,$cabang,$kendaraan,$full_persen,$alamat,$provinsi,$koota,$pr_numb,$pr_linee,$actual_loading,$actual_berangkat,$nama_driver,$plat_nomor);
        // update line
        $deleteLine = $this->M_shipmentmonitoringgudang->deleteSMS($no_ship);
        
        foreach ($unit as $key => $value) {
		$updateMPM2 = $this->M_shipmentmonitoringgudang->UpdatebyInsertSMS($no_ship,$jumlah[$key],$value,$jumlahvol[$key],$pers_vol[$key],$jml_terkirim[$key],$created_line[$key],$no_do[$key]);
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
		$this->load->view('ShipmentMonitoringGudang/V_cumaliatdesain',$data);
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

		// $idProv = $this->input->post('idProv');
		$getFinGo = $this->M_shipmentmonitoringgudang->getFinishGood();
		$getProv = $this->M_shipmentmonitoringgudang->getProvince();
		$getTipe = $this->M_shipmentmonitoringgudang->getUom();
		$getUnit = $this->M_shipmentmonitoringgudang->getGood();
		$id = $this->M_shipmentmonitoringgudang->getId();
		$jk = $this->M_shipmentmonitoringgudang->getJK();
		$content_id = $this->M_shipmentmonitoringgudang->getContentId();
		$cabang = $this->M_shipmentmonitoringgudang->getCabang();
		$getPropinsi = $this->M_shipmentmonitoringgudang->getProvince();
		$usrname = $this->session->user;
		// $getCityy = $this->M_shipmentmonitoringgudang->getKota($idProv);

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
		// $data['kota'] = $getCityy;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringGudang/New/V_newShipmentSMS',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SelectCity()
	{
		$code = $this->input->post('idprovinsi');
		$getCity = $this->M_shipmentmonitoringgudang->getKota($code);

		echo json_encode($getCity);

	}

	public function selectVolume()
	{
		$codd = $this->input->post('vehicle_id_sms');
		$getVolume = $this->M_shipmentmonitoringgudang->getVolumee($codd);

		echo json_encode($getVolume);
	}

	public function selectUnitVolume()
	{
		$coee = $this->input->post('idUnit');
		$getUnitVol = $this->M_shipmentmonitoringgudang->getUnitVol($coee);

		echo json_encode($getUnitVol);
	}

	public function getRow() {

		$getUnit2 = $this->M_shipmentmonitoringgudang->getGood2();
		
		echo json_encode($getUnit2);
	}

	public function getRowupdate() {

		$getUnit2 = $this->M_shipmentmonitoringgudang->getGood2();
		$usrname = $this->session->user;
		$data['unit'] = $getUnit2;
		$data['user'] = $usrname;

		echo json_encode($data);
	}

	public function getRow2() {
		$getTipe = $this->M_shipmentmonitoringgudang->getUom();
		$getUnit = $this->M_shipmentmonitoringgudang->getUnit();
		$content_id = $this->M_shipmentmonitoringgudang->getContentId();

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
		// $delivered_qty = $this->input->post('jumlah_terkirim');

		$saveSMS2 = $this->M_shipmentmonitoringgudang->saveInsertHeader2($estimasi,$estimasi_loading,$finish_good,$status,$cabang,$kendaraan,$usrname,$kota,$provinsih,$alamat,$pr_number,$pr_line,$precentage);
		
		$dataId = $this->M_shipmentmonitoringgudang->getShipmentHeader();
		$id = $dataId[0]['id'];

		foreach ($unit as $key => $value) {
		$saveMPM2 = $this->M_shipmentmonitoringgudang->saveInsertLines($id,$value,$jumlah[$key],$usrname,$percentage_line[$key],$volume_line[$key]
		);
		}
	
	}

	
	public function deleteShipment()
	{
		$id = $this->input->post('id_shipment');

		$hapus = $this->M_shipmentmonitoringgudang->hapusShipment($id);
	}

	public function historyGudang()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$history = $this->M_shipmentmonitoringgudang->history();
		$data['find'] = $history;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringGudang/History/V_historySMS_Gudang',$data);
		$this->load->view('V_Footer',$data);

	}

	public function undeliveredGudang ()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$undeliveredgdg = $this->M_shipmentmonitoringgudang->undelivered();
		$data['undeliver'] = $undeliveredgdg;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ShipmentMonitoringGudang/Undeliver/V_undeliveredSMS_Gudang',$data);
		$this->load->view('V_Footer',$data);
		
	}


	// public function detailPR() //done
	// {
	// 	$nopr = $this->input->post('id');
	// 	$linepr = $this->input->post('line');
	// 	$getDetailPR= $this->M_shipmentmonitoringgudang->getDetailPRQuery($nopr,$linepr);
	// 	$data['iniPR'] = $getDetailPR;

	// 	$return = $this->load->view('ShipmentMonitoringGudang/Dashboard/V_detailPR',$data);
	// }

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
        $fetch = $this->M_shipmentmonitoringgudang->history();
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