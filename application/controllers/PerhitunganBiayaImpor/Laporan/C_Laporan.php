<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Laporan extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->model('M_Index');		  
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('Excel');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PerhitunganBiayaImpor/Laporan/M_laporan');
        	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		 }
	}

	public function GetSortedItem()
	{
		$data = $_POST['data'];
		// echo "<pre>";
		// print_r($data);
		// die;

		$this->session->set_userdata('data_biaya', $data);
		echo 1;
	}

	public function Input()
	{
        $this->checkSession();
        
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noind = $this->session->user;
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerhitunganBiayaImpor/Laporan/V_Input',$data);		
        $this->load->view('V_Footer',$data);
	}

	public function search()
	{
		$reqid = $this->input->post('reqid');

		redirect('PerhitunganBiayaImpor/Laporan/Perhitungan/'.$reqid,'refresh');
	}

    public function Perhitungan($reqId)
    {
		$this->checkSession();
        
		$user_id = $this->session->userid;
		$noind = $this->session->user;

		$UserResponsibility = $this->M_user->getUserResponsibility($user_id, 2723);

		foreach($UserResponsibility as $UserResponsibility_item){
			$this->session->set_userdata('responsibility', $UserResponsibility_item['user_group_menu_name']);
			// if(empty($UserResponsibility_item['user_group_menu_id'])){
				// $UserResponsibility_item['user_group_menu_id'] = 0;
			// }
			$this->session->set_userdata('responsibility_id', $UserResponsibility_item['user_group_menu_id']);
			$this->session->set_userdata('module_link', $UserResponsibility_item['module_link']);
			$this->session->set_userdata('org_id', $UserResponsibility_item['org_id']);
		}

		if (count($UserResponsibility)==0) {
			// $resp = $this->session->userdata['responsibility'];
			echo '<b>ERROR :</b> User ini tidak mempunyai akses ke aplikasi Perhitungan Biaya Impor, silahkan tambahkan terlebih  dahulu agar ERP bisa diakses menggunakan akun ini!';
			exit;
		}
		
		$data['Menu'] = 'Laporan';
		$data['SubMenuOne'] = 'Perhitungan Biaya';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['id'] = $reqId;
        
		$additional = $this->M_laporan->getAdditionalCost($reqId);
		$data['header'] = $this->M_laporan->getDetailPO($reqId);
		$data['header2'] = $this->M_laporan->getDetail($reqId);
		$data['nopo'] = $this->M_laporan->getnopo($reqId);
		$data['vendor'] = $this->M_laporan->getVendor($reqId);
		$data['local_transport'] = array();
		$data['biaya_survey'] = array();
		$data['additional_cost'] = array();
		
		foreach ($additional as $key => $selection) {
			if ($selection['DESKRIPSI'] == 'Local Transport and Shipping') {
				array_push($data['local_transport'],$selection);
			}elseif ($selection['DESKRIPSI'] == 'Biaya Survey') {
				array_push($data['biaya_survey'],$selection);
			}else if ($selection['DESKRIPSI'] != 'BEA MASUK') {
				array_push($data['additional_cost'],$selection);
			}
		}
        $data['detail_line'] = $this->M_laporan->getDetailPO($reqId);
        $data['bea_masuk'] = $this->M_laporan->getBeaMasuk($reqId);

        // echo'<pre>';
        // print_r($data['local_transport']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerhitunganBiayaImpor/Laporan/V_PerhitunganBiaya2',$data);
        $this->load->view('V_Footer',$data);
    }

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function Action($reqid)
	{
		$addAdditionalInfo = '';
		$addAdditionalInfoPrice = '';
		$data_item = '';
		$data = $this->session->userdata('data_biaya');

		if($data['source'] == 'ajax'){
		    $status = 'export';
			$kodebarang = $data['kode_barang'];
			$rate = $data['rate'];
			$qtyKirim = $data['qtyKirim'];

			$data_item = $data['data_item'];
			$nomorUrutPBI = $data['nomorUrutPBI'];
			$IOPBI = $data['IOPBI'];
			$vendorPBI = $data['vendorPBI'];
			$noPackingPBI = $data['noPackingPBI'];
			$noBLPBI = $data['noBLPBI'];
			$noPOPBI = $data['noPOPBI'];
			$noInterorgPBI = $data['noInterorgPBI'];
			$noReceiptPBI = $data['noPackingPBI'];
			// $localTransportCurr = $this->input->post('localTransportCurrency');
			$currency = $data['slcCurrencyPBI'];
			$notes = $data['notesPBI'];

			if ($data['addAdditional'][0] != 'empty'){
				$addAdditionalInfo = $data['addAdditional'];
				$addAdditionalInfoPrice = $data['addAdditionalPrice'];
			}

		} else {
			// $button = $this->input->post('btnSubPBI');
			// $localTransport = $this->input->post('localTransport');
			// $biayaSurvey = $this->input->post('biayaSurvey');
			$status = 'save';
			$kodebarang = $this->input->post('kodebarang[]');
			$rate = $this->input->post('rate[]');
			$qtyKirim = $this->input->post('qtyKirim[]');

			$nomorUrutPBI = $this->input->post('nomorUrutPBI');
			$IOPBI = $this->input->post('IOPBI');
			$vendorPBI = $this->input->post('vendorPBI');
			$noPackingPBI = $this->input->post('noPackingPBI');
			$noBLPBI = $this->input->post('noBLPBI');
			$noPOPBI = $this->input->post('noPOPBI');
			$noInterorgPBI = $this->input->post('noInterorgPBI');
			$noReceiptPBI = $this->input->post('noReceiptPBI');
			// $localTransportCurr = $this->input->post('localTransportCurrency');
			$currency = $this->input->post('slcCurrencyPBI');
			$notes = $this->input->post('notesPBI');

			if ($this->input->post('additionalAdd[]')) {
				$addAdditionalInfo = $this->input->post('additionalAdd[]');
				$addAdditionalInfoPrice = $this->input->post('additionalAddPrice[]');
			}
		}

		$header = array(
			'nomorUrutPBI' => $nomorUrutPBI,
			'IOPBI' => $IOPBI,
			'vendorPBI' => $vendorPBI,
			'noPackingPBI' => $noPackingPBI,
			'noBLPBI' => $noBLPBI,
			'noPOPBI' => $noPOPBI,
			'noInterorgPBI' => $noInterorgPBI,
			'noReceiptPBI' => $noReceiptPBI,
			'notes' => $notes
		);

		// if ($button == 0) {
		if ($status == 'export') {
			$this->SaveData($reqid,$kodebarang,$rate,$qtyKirim,$header,$currency,$addAdditionalInfo,$addAdditionalInfoPrice);
			$this->Export($reqid,$rate,$header,$currency,$data_item);
		}else{
			$this->SaveData($reqid,$kodebarang,$rate,$qtyKirim,$header,$currency,$addAdditionalInfo,$addAdditionalInfoPrice);
			redirect('PerhitunganBiayaImpor/Laporan/Perhitungan/'.$reqid,'refresh');
		}

		// redirect('PerhitunganBiayaImpor/Laporan/DataHistory','refresh');
	}

	public function SaveData($reqid,$kodebarang,$rate,$qtyKirim,$header,$currency,$addAdditionalInfo,$addAdditionalInfoPrice)
	{
		if ($addAdditionalInfo && $addAdditionalInfoPrice) {

			for ($h=0; $h < count($addAdditionalInfo); $h++) { 
				$price = str_replace(',','',$addAdditionalInfoPrice[$h]);
				$price1 = str_replace('.00','',$price);
				$addInfo = array(
									'REQUEST_ID' => $reqid,
									'DESKRIPSI' => $addAdditionalInfo[$h], 
									'HARGA' => $price1, 
								);
				$this->M_laporan->tambahAdditionInfo($addInfo);
			}
		}
		
		$additional_cost = array(
									'NO_URUT_PERHITUNGAN' => $header['nomorUrutPBI'],
									'NO_PACKING_LIST' => $header['noPackingPBI'],
									'NO_BL' => $header['noBLPBI'],
									'NOTE' => $header['notes'],
								 );
		
		$this->M_laporan->updateAdditionalCost($reqid,$additional_cost);
		
		for ($i=0; $i < count($rate); $i++) {
			$qtykrm = str_replace(',','',$qtyKirim[$i]);
			$rat = str_replace(',','',$rate[$i]);
			$rat1 = str_replace('.00','',$rat);

			$ratesNQtyKirim =	array(
									'RATE' => $rat1,
									'QTY_KIRIM' => $qtykrm
								);

			$this->M_laporan->updateDataPO($reqid,$kodebarang[$i],$ratesNQtyKirim);
		}

		// redirect('PerhitunganBiayaImpor/Laporan/DataHistory','refresh');
	}
	
	public function DataHistory()
	{
		$this->checkSession();
        
		$user_id = $this->session->userid;
		$noind = $this->session->user;

		$data['Menu'] = 'Laporan';
		$data['SubMenuOne'] = 'Data History';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dataHistory'] = $this->M_laporan->getHistory();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PerhitunganBiayaImpor/Laporan/V_DataHistory',$data);
        $this->load->view('V_Footer',$data);
	}

	public function Export($reqid,$rate,$header,$currency,$data_item)
	{
		$this->session->unset_userdata('data_biaya');
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(14);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(7);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(17);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(17);

		$objPHPExcel->getActiveSheet()->getRowDimension('13')->setRowHeight(40);

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		$objDrawing->setPath('./assets/img/logo.png');
		$objDrawing->setCoordinates('A3');
		$objDrawing->setOffsetX(50);
		$objDrawing->setOffsetY(5);
	   	$objDrawing->setHeight(100);

		$objset = $objPHPExcel->setActiveSheetIndex(0);
		$objset->mergeCells('B1:D1');
		$objset->mergeCells('C3:D3');
		$objset->mergeCells('C4:D4');
		$objset->mergeCells('C5:D5');
		$objset->mergeCells('C6:D6');
		$objset->mergeCells('C7:D7');
		$objset->mergeCells('C8:D8');
		$objset->mergeCells('C9:D9');
		$objset->mergeCells('C10:D10');
		$objset->mergeCells('F3:J3');
		$objset->mergeCells('F4:J4');
		$objset->mergeCells('F5:J5');
		$objset->mergeCells('F6:J6');
		$objset->mergeCells('F7:J7');
		$objset->mergeCells('F8:J8');
		$objset->mergeCells('F9:J9');
		$objset->mergeCells('F10:J10');
		$objset->mergeCells('F11:J11');

		$objset->mergeCells('A12:A14');
		$objset->mergeCells('B12:C14');
		$objset->mergeCells('D12:D14');
		$objset->mergeCells('E12:M12');
		$objset->mergeCells('E13:F14');
		$objset->mergeCells('N12:N13');
		$objset->mergeCells('P12:P13');
		$objset->mergeCells('Q12:T12');

		$objPHPExcel->getActiveSheet()->getStyle('E3:E11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E3:E11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A12:T14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('F3:F11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('F3:F11')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A12:T14')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('H12:T13')->getAlignment()->setWrapText(true);
		
		$style = [
			'border_all' => [
				'borders' => [
							'allborders' => [ 'style' => PHPExcel_Style_Border::BORDER_THIN ] 
							]
				],
			'border_bottom' => [
					'borders' => [
						'bottom' => [ 'style' => PHPExcel_Style_Border::BORDER_THIN ] 
					]
				]
				];
		$objPHPExcel->getActiveSheet()->getStyle('A12:T14')->applyFromArray($style['border_all']);
		
		$objset->setCellValue("B1", 'Perhitungan  Tambahan Biaya :');
		$objset->setCellValue("C3", 'Nomor Urut Perhitungan');
		$objset->setCellValue("E3", ':');
		$objset->setCellValue("C4", 'IO');
		$objset->setCellValue("E4", ':');
		$objset->setCellValue("C5", 'Eksportir');
		$objset->setCellValue("E5", ':');
		$objset->setCellValue("C6", 'No. Packing List');
		$objset->setCellValue("E6", ':');
		$objset->setCellValue("C7", 'No. B/L');
		$objset->setCellValue("E7", ':');
		$objset->setCellValue("C8", 'No. PO');
		$objset->setCellValue("E8", ':');
		$objset->setCellValue("C9", 'No. Interorg');
		$objset->setCellValue("E9", ':');
		$objset->setCellValue("C10", 'No. Receipt');
		$objset->setCellValue("E10", ':');
		$objset->setCellValue("C11", 'Subinventory ; Locator Tujuan');
		$objset->setCellValue("E11", ':');

		$objset->setCellValue("A12", 'No');
		$objset->setCellValue("B12", 'Kode barang');
		$objset->setCellValue("D12", 'Deskripsi Barang');
		$objset->setCellValue("E13", 'PO');
		$objset->setCellValue("G13", 'Qty PO');
		$objset->setCellValue("H13", 'Qty krm (PCS)');
		$objset->setCellValue("I13", 'Hrg ('.$currency.')');
		$objset->setCellValue("J13", 'Total ('.$currency.')');
		$objset->setCellValue("K13", 'Rate');
		$objset->setCellValue("L13", 'Nilai Barang (RP)');
		$objset->setCellValue("M13", '%Pembagian Biaya');
		$objset->setCellValue("N12", 'Bea Masuk');
		$objset->setCellValue("O12", 'Additional Cost');
		$objset->setCellValue("P12", 'Total Biaya (RP)');
		$objset->setCellValue("Q12", 'Harga / pcs barang (Rp)');
		$objset->setCellValue("Q13", 'Hrg PO');
		$objset->setCellValue("R13", 'Tamb');
		$objset->setCellValue("S13", 'Hrg Total');
		$objset->setCellValue("T13", '%');
		$objset->setCellValue("O13", 'Nilai (RP)');
		$objset->setCellValue("G14", '(PCS)');
		$objset->setCellValue("H14", 'a');
		$objset->setCellValue("I14", 'b');
		$objset->setCellValue("J14", 'c=a*b');
		$objset->setCellValue("K14", 'd');
		$objset->setCellValue("L14", 'e=c*d');
		$objset->setCellValue("M14", 'f=e/Total e');
		$objset->setCellValue("N14", 'h=f*Total h');
		$objset->setCellValue("O14", 'i=f*z');
		$objset->setCellValue("P14", 'j=h+i');
		$objset->setCellValue("Q14", 'k=b*d');
		$objset->setCellValue("R14", 'l=j/a');
		$objset->setCellValue("S14", 'm=k+l');
		$objset->setCellValue("T14", 'n=k/l');

		$objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('0.00%;[Red]-0.00%');
		$objPHPExcel->getActiveSheet()->getStyle('T')->getNumberFormat()->setFormatCode('0.00%;[Red]-0.00%');
		
		//header
		$locator = $this->M_laporan->get_location_code($header['noPOPBI']);
		$objset->setCellValue("F3", $header['nomorUrutPBI']);		
		$objset->setCellValue("F4", $header['IOPBI']);		
		$objset->setCellValue("F5", $header['vendorPBI']);		
		$objset->setCellValue("F6", $header['noPackingPBI']);		
		$objset->setCellValue("F7", $header['noBLPBI']);		
		$objset->setCellValue("F8", $header['noPOPBI']);		
		$objset->setCellValue("F9", $header['noInterorgPBI']);		
		$objset->setCellValue("F10", $header['noReceiptPBI']);	
		$objset->setCellValue("F11", $locator[0]['LOCATION_CODE']);	
		//end
		
		// ambil data
		$add_cost = $this->M_laporan->getAdditionalCost($reqid, $data_item);
		$additional_cost = array();
		foreach ($add_cost as $key => $add) {
			if ($add['DESKRIPSI'] != 'BEA MASUK' && $add['DESKRIPSI'] != 'Local Transport and Shipping') {
				array_push($additional_cost,$add);
			}
		}
		$line = $this->M_laporan->getDetailPO($reqid);
		$bea_masuk = $this->M_laporan->getBeaMasuk($reqid);
		// end
		// echo '<pre>';
		// print_r($additional_cost);exit;
		$row = 15;
		$no = 0;

		if ($header['IOPBI'] == 'IPM'){
			$objPHPExcel->getActiveSheet()->getStyle('P8:T10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E6B8B7');
			$objPHPExcel->getActiveSheet()->getStyle('P8:T10')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('P12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E6B8B7');
			$objPHPExcel->getActiveSheet()->getStyle('P13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E6B8B7');
			$objPHPExcel->getActiveSheet()->getStyle('P14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E6B8B7');
			$objPHPExcel->getActiveSheet()->getStyle('P8:T10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$ipm_cell_val = 'Total Biaya : Nilai yang harus dimasukan saat melakukan Actual Cost Adjusment dengan type : Value Cost Adjusment';
			$objset->mergeCells('P8:T10');
			$objset->setCellValue("P8", $ipm_cell_val);	
		}

		for ($i=0; $i < count($line); $i++) { $no++;

			$objset->mergeCells("B".$row.":C".$row);
			$objset->mergeCells("E".$row.":F".$row);

			$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);

			$objPHPExcel->getActiveSheet()->getStyle("B".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C5E0B5');
			$objPHPExcel->getActiveSheet()->getStyle("D".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C5E0B5');
			$objPHPExcel->getActiveSheet()->getStyle("G".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C5E0B5');
			$objPHPExcel->getActiveSheet()->getStyle("H".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C5E0B5');
			$objPHPExcel->getActiveSheet()->getStyle("I".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('C5E0B5');
			$objPHPExcel->getActiveSheet()->getStyle("K".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FCBF02');
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':T'.$row)->applyFromArray($style['border_all']);
			// $objPHPExcel->getActiveSheet()->getStyle("D".$row)->getAlignment()->setWrapText(true);

			$objPHPExcel->getActiveSheet()->getStyle('A:T')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$objPHPExcel->getActiveSheet()->getStyle("G".$row)->getNumberFormat()->setFormatCode('#,##0');
			$objPHPExcel->getActiveSheet()->getStyle("H".$row)->getNumberFormat()->setFormatCode('#,##0');
			$objPHPExcel->getActiveSheet()->getStyle("I".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("J".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("K".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("L".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("N".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("O".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("P".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("Q".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("R".$row)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle("S".$row)->getNumberFormat()->setFormatCode('#,##0.00');

			$objset->setCellValue("A".$row, $no);
			$objset->setCellValue("B".$row, $line[$i]['KODE_BARANG']);
			$objset->setCellValue("D".$row, $line[$i]['DESKRIPSI_BARANG']);
			$objset->setCellValue("E".$row, $line[$i]['NO_PO']);
			$objset->setCellValue("G".$row, $line[$i]['QTY_PO']);
			$objset->setCellValue("H".$row, $line[$i]['QTY_KIRIM']);
			$objset->setCellValue("I".$row, $line[$i]['HARGA']);
			$objset->setCellValue("J".$row, '=H'.$row.'*I'.$row);
			$objset->setCellValue("K".$row, str_replace(',','',$rate[$i]));
			// $objset->setCellValue("K".$row, $line[$i]['RATE']);
			$objset->setCellValue("L".$row, '=J'.$row.'*K'.$row);
			$objset->setCellValue("M".$row, '=L'.$row.'/L'.(count($line)+15));
			$objset->setCellValue("N".$row, '=M'.$row.'*N'.(count($line)+15));
			$objset->setCellValue("O".$row, '=M'.$row.'*G'.(count($line)+18+count($additional_cost)+1));
			$objset->setCellValue("P".$row, '=N'.$row.'+O'.$row);
			$objset->setCellValue("Q".$row, '=I'.$row.'*K'.$row);
			$objset->setCellValue("R".$row, '=P'.$row.'/H'.$row);
			$objset->setCellValue("S".$row, '=Q'.$row.'+R'.$row);
			$objset->setCellValue("T".$row, '=R'.$row.'/Q'.$row);

			if ($header['IOPBI'] == 'IPM'){
				$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E6B8B7');
			}
				
			$row++;
		}
		// $objPHPExcel->getActiveSheet()->getStyle("J".$row)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->getStyle("J".$row)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->getStyle("L".$row)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->getStyle("N".$row)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->getStyle("O".$row)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->getStyle("P".$row)->getNumberFormat()->setFormatCode('#,##0.00');

		if ($header['IOPBI'] == 'IPM'){
			$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E6B8B7');
		}

		if ($bea_masuk) {
			$bea = $bea_masuk[0]['HARGA'];
		}else{
			$bea = '0';
		}

		$objset->setCellValue("J".$row, '=SUM(J15:J'.($row-1).')');
		$objset->setCellValue("L".$row, '=SUM(L15:L'.($row-1).')');
		$objset->setCellValue("N".$row, $bea);
		$objset->setCellValue("O".$row, '=SUM(O15:O'.($row-1).')');
		$objset->setCellValue("P".$row, '=SUM(P15:P'.($row-1).')');
		$objPHPExcel->getActiveSheet()->getStyle("N".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEF81B');

		$objPHPExcel->getActiveSheet()->getStyle('H'.$row.':P'.$row)->applyFromArray($style['border_bottom']);

		//additional cost
		$objset->mergeCells('C'.($row+2).':E'.($row+3));
		$objset->mergeCells('F'.($row+2).':F'.($row+3));
		$objset->mergeCells('G'.($row+2).':H'.($row+3));

		$objPHPExcel->getActiveSheet()->getStyle('C'.($row+2).':H'.($row+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.($row+2).':H'.($row+3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objset->setCellValue('C'.($row+2), 'ADDITIONAL COST');
		$objset->setCellValue('F'.($row+2), 'in '.$currency);
		$objset->setCellValue('G'.($row+2), 'in IDR');
		
		$rows = $row + 4;
		$nom =0;
		
		for ($j=0; $j < count($additional_cost); $j++) { $nom++;
			
				$objset->mergeCells('D'.$rows.':E'.$rows);
				$objset->mergeCells('G'.$rows.':H'.$rows);
				$objset->setCellValue("C".$rows, $nom);
				$objset->setCellValue("D".$rows, $additional_cost[$j]['DESKRIPSI']);
				$objset->setCellValue("F".$rows, $additional_cost[$j]['HARGA_USD']);
				$objPHPExcel->getActiveSheet()->getStyle("G".$rows)->getNumberFormat()->setFormatCode('#,##0.00');
				$objset->setCellValue("G".$rows, $additional_cost[$j]['HARGA']);
				$objPHPExcel->getActiveSheet()->getStyle("G".$rows)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEF81B');

			
			$rows++;
		}
		// $objPHPExcel->getActiveSheet()->getStyle("C".($row+4).':H'.($row+5))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FCBF02');
		
		$objset->mergeCells('G'.($row+4).':H'.($row+4));
		$objset->mergeCells('D'.($row+4).':E'.($row+4));
		$objset->mergeCells('G'.($row+5).':H'.($row+5));
		$objset->mergeCells('D'.($row+5).':E'.($row+5));

		$objset->mergeCells('K'.($row+5).':L'.($row+5));
		$objset->mergeCells('K'.($row+6).':L'.($row+9));
		$objset->mergeCells('K'.($row+10).':L'.($row+10));
		$objset->mergeCells('K'.($row+11).':L'.($row+11));
		$objset->mergeCells('M'.($row+5).':N'.($row+5));
		$objset->mergeCells('M'.($row+6).':N'.($row+9));
		$objset->mergeCells('M'.($row+10).':N'.($row+10));
		$objset->mergeCells('M'.($row+11).':N'.($row+11));
		$objset->mergeCells('O'.($row+5).':P'.($row+5));
		$objset->mergeCells('O'.($row+6).':P'.($row+9));
		$objset->mergeCells('O'.($row+10).':P'.($row+10));
		$objset->mergeCells('O'.($row+11).':P'.($row+11));

		$objset->setCellValue("K".($row+5),'Dibuat Oleh :');
		$objset->setCellValue("M".($row+5),'Diperiksa Oleh :');
		$objset->setCellValue("O".($row+5),'Mengetahui :');
		$objset->setCellValue("K".($row+10),'Tri Sutrisno');
		$objset->setCellValue("M".($row+10),'Inayah Nur Utami');
		$objset->setCellValue("O".($row+10),'Novita Sari');
		$objset->setCellValue("K".($row+11),'Tgl: '.date('d/m/Y'));
		$objset->setCellValue("M".($row+11),'Tgl: '.date('d/m/Y'));
		$objset->setCellValue("O".($row+11),'Tgl: ');

		$objPHPExcel->getActiveSheet()->getStyle('K'.($row+5).':P'.($row+11))->applyFromArray($style['border_all']);
		$objPHPExcel->getActiveSheet()->getStyle('K'.($row+5).':P'.($row+10))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objset->mergeCells('D'.($rows).':F'.($rows));
		$objset->mergeCells('C'.($rows+1).':J'.($rows+1));
		$objset->mergeCells('G'.($rows).':H'.($rows));
		$objset->setCellValue("C".($rows), 'Z');
		$objset->setCellValue("C".($rows+1), 'NOTE : '.$header['notes']);
		$objset->setCellValue("D".($rows), 'TOTAL');
		$objPHPExcel->getActiveSheet()->getStyle("G".$rows)->getNumberFormat()->setFormatCode('#,##0.00');
		$objset->setCellValue("G".($rows), '=SUM(G'.($row + 4).':G'.($rows-1).')');

		$objPHPExcel->getActiveSheet()->getStyle('C'.($rows+1).':J'.($rows+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FCBF02');

		$objPHPExcel->getActiveSheet()->getStyle("D".($rows))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("D".($rows))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('C'.($row+2).':H'.$rows)->applyFromArray($style['border_all']);

		//end
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->setPreCalculateFormulas(true);
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="[export]Perhitungan_Biaya_Impor_'.date('d:M:Y').'.xlsx"');
		$objWriter->save("php://output");
	}

	public function HapusAdditionalCost()
	{
		$request_id = $_POST['request_id'];
		$deskripsi = $_POST['deskripsi'];

		$this->M_laporan->HapusAdditionalCost($request_id,$deskripsi);

		echo 1;
	}

	public function HapusLine()
	{
		$kode_barang = $_POST['kode_barang'];
		$no_po = $_POST['no_po'];
		$qty_po = $_POST['qty_po'];
		$io = $_POST['io'];
		$request_id = $_POST['request_id'];

		$this->M_laporan->HapusLine($kode_barang,$no_po,$qty_po,$io,$request_id);

		echo 1;
	}

	public function EditAdditionalCost()
	{
		$request_id = $_POST['request_id'];
		$deskripsi = $_POST['deskripsi'];
		$price = $_POST['price'];

		$this->M_laporan->EditAdditionalCost($request_id, $deskripsi, $price);

		echo 1;
	}
}
