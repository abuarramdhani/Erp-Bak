<?php
class C_Report extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('AccountPayables/Report/M_report');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->library('Excel');
			$this->checkSession();
    }

	public function checkSession()
	{
		if($this->session->is_logged){

		}else{
			redirect('index');
		}
	}

	public function reportInvoiceFaktur()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['title'] = 'Report Invoice Tanpa Faktur';
		$data['Menu'] = 'Invoice';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// print_r($data['userLoged']);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/Report/ReportInvoiceTanpaFaktur/V_report_invoice_tanpa_faktur', $data);
		$this->load->view('V_Footer',$data);
	}

	public function exportInvoiceFaktur()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$startDate = $this->input->post('tanggal_awal', true);
		$endDate = $this->input->post('tanggal_akhir', true);
		$status = $this->input->post('invoice_status', true);
		$vendor = $this->input->post('supplier', true);

		$dataInvoice = $this->M_report->getInvoiceFaktur($startDate, $endDate, $vendor, $status, $user);
		// echo "<pre>"; print_r($dataInvoice); exit;

		if($vendor == '') $vendor = 'All';
		if($status == 1){
			$attribute = 'All';
		} else if($status == 2){
			$attribute = 'Dengan';
		} else if($status == 3){
			$attribute = 'Tanpa';
		}

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("ICT")->setTitle("Invoice Tanpa Faktur");

		$objset = $objPHPExcel->setActiveSheetIndex(0);
		$objget = $objPHPExcel->getActiveSheet();
		$objget->setTitle('Invoice Tanpa Faktur');

		if ($user == 'B0541' OR $user == 'B0727') {
			$objget->getStyle("A1:L1")->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '949494')
					),
					'font' => array(
						'color' => array('rgb' => '000000'),
						'bold'  => true,
					)
				)
			);

			$cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L");
			$val = array("Vendor Name", "Invoice Type", "Batch Number", "Invoice Date", "Invoice Number", "Payment Date", "DPP", "PPN", "Total", "No. Faktur", "No. PO", 'Buyer Name');

			for ($a=0;$a<12; $a++) {
				$objset->setCellValue($cols[$a].'1', $val[$a]);
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(45);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(37);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
				$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
				$style = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				);
				$objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
			}

			$baris  = 2;
			foreach ($dataInvoice as $frow) {
				$objset->setCellValue("A".$baris, $frow['VENDOR_NAME']);
				$objset->setCellValue("B".$baris, $frow['TYPE_INVOICE']);
				$objset->setCellValue("C".$baris, $frow['BATCH_NUMBER']);
				$objset->setCellValue("D".$baris, $frow['INVOICE_DATE']);
				$objset->setCellValue("E".$baris, $frow['INVOICE_NUM']);
				$objset->setCellValue("F".$baris, $frow['PAYMENT_DATE']);
				$objset->setCellValue("G".$baris, $frow['DPP']);
				$objset->setCellValue("H".$baris, $frow['PPN']);
				$objset->setCellValue("I".$baris, $frow['TOTAL']);
				$faktur = $frow['ATTRIBUTE5'].$frow['ATTRIBUTE3'];
				$numfaktur = preg_replace("/[^0-9]/", "", $faktur );
				if ($frow['ATTRIBUTE3'] == NULL) {
					$numfaktur = '-';
				};
				$objset->setCellValue("J".$baris, $numfaktur);
				$objset->setCellValue("K".$baris, $frow['PO_NUM']);
				$objset->setCellValue("L".$baris, $frow['BUYER']);
				$baris++;
			}
		}else{
			if($status == 3){ $colStyle = 'N1'; } else { $colStyle = 'J1'; };
			$objget->getStyle("A1:$colStyle")->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '949494')
					),
					'font' => array(
						'color' => array('rgb' => '000000'),
						'bold'  => true,
					)
				)
			);

			$cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N");
			if($status == 3){
				$val = array("Vendor Name"
							,"Invoice Type"
							,"Batch Number"
							,"Invoice Date"
							,"Invoice Number"
							,"Payment Date"
							,"DPP"
							,"PPN"
							,"Total"
							,"No. Faktur"
							,"No. PO"
							,"No. Receipt"
							,"Tgl Receipt"
							,"GL Date"
							);
			} else {
				$val = array("Vendor Name"
							,"Invoice Type"
							,"Batch Number"
							,"Invoice Date"
							,"Invoice Number"
							,"Payment Date"
							,"DPP"
							,"PPN"
							,"Total"
							,"No. Faktur"
				);
			} 
			
			if($status == 3){ $colCount = '14'; } else { $colCount = '10'; };
			for ($a=0;$a<$colCount; $a++) {
				$objset->setCellValue($cols[$a].'1',$val[$a]);
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(45);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(37);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
				if($status == 3){
					$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
					$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
					$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);
					$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
				}
				$style = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				);
				$objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
			}

			$baris  = 2;
			foreach ($dataInvoice as $frow) {
				$objset->setCellValue("A".$baris, $frow['VENDOR_NAME']);
				$objset->setCellValue("B".$baris, $frow['TYPE_INVOICE']);
				$objset->setCellValue("C".$baris, $frow['BATCH_NUMBER']);
				$objset->setCellValue("D".$baris, $frow['INVOICE_DATE']);
				$objset->setCellValue("E".$baris, $frow['INVOICE_NUM']);
				$objset->setCellValue("F".$baris, $frow['PAYMENT_DATE']);
				$objset->setCellValue("G".$baris, $frow['DPP']);
				$objset->setCellValue("H".$baris, $frow['PPN']);
				$objset->setCellValue("I".$baris, $frow['TOTAL']);
				$faktur = $frow['ATTRIBUTE5'].$frow['ATTRIBUTE3'];
				$numfaktur = preg_replace("/[^0-9]/", "", $faktur );
				if ($frow['ATTRIBUTE3'] == NULL) {
					$numfaktur = '-';
				};
				$objset->setCellValue("J".$baris, $numfaktur);
				if($status == 3){
					$objset->setCellValue("K".$baris, $frow['PO_NUMBER']);
					$objset->setCellValue("L".$baris, $frow['RECEIPT_NUM']);
					$objset->setCellValue("M".$baris, $frow['RECEIPT_DATE']);
					$objset->setCellValue("N".$baris, $frow['GL_DATE']);
				}
				$baris++;
			}
		};

		$objPHPExcel->getActiveSheet()->setTitle('Invoice Tanpa Faktur');
		$objPHPExcel->setActiveSheetIndex(0);

		$filename = "Invoice_".$attribute."_Faktur_".$startDate."_".$endDate."_".$vendor.".xls";

		header("Content-Type: application/vnd.ms-excel");   
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	}

	//-------------------------------------------------------------DetailInvoice--------------------------------------
	public function detailInvoice(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['title'] = 'Report Invoice Tanpa Faktur';
		$data['Menu'] = 'Invoice';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Vendor'] = $this->M_report->getDetailInvoiceVendor();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/Report/ReportDetailInvoice/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function exportDetailInvoice(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['title'] = 'Report Invoice Tanpa Faktur';
		$data['Menu'] = 'Invoice';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$vendorName = $this->input->post('DInvoiceVdr[]', true);
		$strTgl = $this->input->post('DInvoiceStr', true);
		$endTgl = $this->input->post('DInvoiceEnd', true);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("ICT")->setTitle("Detail Invoice");

		$i = 0;
		foreach ($vendorName as $vdn) {
			$detailInvoice = $this->M_report->getDetailInvoice($vdn, $strTgl, $endTgl);
			$splNPWP = $this->M_report->getNPWP($vdn);

			$newWorkSheet = new PHPExcel_Worksheet($objPHPExcel, $vdn);
			$objPHPExcel->addSheet($newWorkSheet, $i);
			$objPHPExcel->setActiveSheetIndex($i);
			$activeSheetNow = $objPHPExcel->getActiveSheet();

			$activeSheetNow->getColumnDimension('A')->setWidth(7);
			$activeSheetNow->getColumnDimension('B')->setWidth(33);
			$activeSheetNow->getColumnDimension('C')->setWidth(23);
			$activeSheetNow->getColumnDimension('D')->setWidth(59);
			$activeSheetNow->getColumnDimension('E')->setWidth(15);
			$activeSheetNow->getColumnDimension('F')->setWidth(15);
			$activeSheetNow->getColumnDimension('G')->setWidth(15);
			$activeSheetNow->getColumnDimension('H')->setWidth(15);
			$activeSheetNow->getColumnDimension('I')->setWidth(15);

			$activeSheetNow->mergeCells('A1:B1');
			$activeSheetNow->mergeCells('A2:B2');
			$activeSheetNow->mergeCells('C1:I1');
			$activeSheetNow->mergeCells('C2:I2');
			$activeSheetNow->SetCellValue('A1', 'NAMA SUPLIER : '.$splNPWP[0]['VENDOR_NAME']);
			$activeSheetNow->SetCellValue('A2', 'NPWP : '.$splNPWP[0]['NPWP']);

			$activeSheetNow->getStyle("A4:I4")->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '949494')
					),
					'font' => array(
						'color' => array('rgb' => '000000'),
						'bold'  => true,
					)
				)
			);

			$activeSheetNow->SetCellValue('A4', 'NO');
			$activeSheetNow->SetCellValue('B4', 'NO.INVOICE');
			$activeSheetNow->SetCellValue('C4', 'TYPE');
			$activeSheetNow->SetCellValue('D4', 'DESCRIPTION');
			$activeSheetNow->SetCellValue('E4', 'TGL. PAYMENT');
			$activeSheetNow->SetCellValue('F4', 'PAYMENT METHOD');
			$activeSheetNow->SetCellValue('G4', 'QUANTITY');
			$activeSheetNow->SetCellValue('H4', 'UNIT PRICE');
			$activeSheetNow->SetCellValue('I4', 'AMOUNT');

			$baris = 5;
			$nomorBaris = 1;
			foreach ($detailInvoice as $dti) {
				$activeSheetNow->SetCellValue('A'.$baris, $nomorBaris);
				$activeSheetNow->SetCellValue('B'.$baris, $dti['INVOICE_NUM']);
				$activeSheetNow->SetCellValue('C'.$baris, $dti['LINE_TYPE']);
				$activeSheetNow->SetCellValue('D'.$baris, $dti['DESCRIPTION']);
				$activeSheetNow->SetCellValue('E'.$baris, $dti['PAYMENT_DATE']);
				$activeSheetNow->SetCellValue('F'.$baris, $dti['PAYMENT_METHOD']);
				$activeSheetNow->SetCellValue('G'.$baris, $dti['QUANTITY_INVOICED']);
				$activeSheetNow->SetCellValue('H'.$baris, $dti['UNIT_PRICE']);
				$activeSheetNow->SetCellValue('I'.$baris, $dti['AMOUNT']);



				$nomorBaris++;
				$baris++;
			};

			$i++;
		};

		$sheetIndex = $objPHPExcel->getIndex(
		    $objPHPExcel->getSheetByName('Worksheet')
		);
		$objPHPExcel->removeSheetByIndex($sheetIndex);

		$filename = "Detail Invoice (".$strTgl." s/d ".$endTgl.").xls";

		header("Content-Type: application/vnd.ms-excel");   
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	}

	// public function testChamber(){
	// 	$vendorName = "ADJI, BENGKEL";
	// 	$detailInvoice = $this->M_report->getNPWP($vendorName);
	// 	echo "<pre>";
	// 	print_r($detailInvoice);
	// 	echo "</pre>";
	// }
}
?>