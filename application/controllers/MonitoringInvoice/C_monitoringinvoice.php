<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_monitoringinvoice extends CI_Controller{

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
		$this->load->model('MonitoringInvoice/M_monitoringinvoice');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
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

		$invoice = $this->M_monitoringinvoice->showInvoice();

		$no = 0;
		$keputusan = array();
		foreach ($invoice as $inv ) {
			//get po amount

			$invoice_id = $inv['invoice_id'] ;
			$po_detail = $inv['po_detail'];
			$po_number = $inv['po_number'];
			$batch_number = $inv['purchasing_batch_number'];

			$keputusan[$inv['invoice_id']] = "";
			$hasil_komitmen = '';

			if ($po_detail) {
				$expPoDetail = explode('<br>', $po_detail);
				$n=0;
				$podetail = array();
				foreach ($expPoDetail as $ep => $value) {
					$exp_lagi = explode(' - ', $value);

							$po_number_explode = $exp_lagi[0];
							$lppb_number_explode = $exp_lagi[1];
							$line_number_explode = $exp_lagi[2];

							$perbandingan = $this->M_monitoringinvoice->podetails($po_number_explode,$lppb_number_explode,$line_number_explode);


							if (!$perbandingan) {
								$status = "No Status";
							}else{
								$status = $perbandingan[$n]['STATUS'];
							}

							$podetail[$ep] = $value.' - '.$status;
				}

				$keputusan[$inv['invoice_id']] = $podetail;

				$n++;
			}
			
			$po_amount = 0;
			$unit = $this->M_monitoringinvoice->getUnitPrice($invoice_id);

			foreach ($unit as $price) {
				$total = $price['unit_price'] * $price['qty_invoice'];
				$po_amount = $po_amount + $total;
			}


			// //cekPPN
			$cekPPN = $this->M_monitoringinvoice->checkPPN($po_number);

			$invoice[$no]['ppn'] = $cekPPN[0]['PPN'];
			$invoice[$no]['po_amount'] = $po_amount;
			$no++;
		}

		$data['keputusan'] = $keputusan;
		$data['invoice'] =$invoice;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_invoice',$data);
		$this->load->view('V_Footer',$data);
	}

	public function listSubmited()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id); 

		$listBatch = $this->M_monitoringinvoice->showListSubmitted();
		
		$no = 0;
		foreach ($listBatch as $key => $value) {
			$jmlInv = $this->M_monitoringinvoice->getJmlInvPerBatch($value['batch_num']);
			echo $value['batch_num'];

			$listBatch[$no]['jml_invoice'] = $jmlInv.' invoice';
			$no++;
		}

		$data['invoice'] = $listBatch;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_listsubmit',$data);
		$this->load->view('V_Footer',$data);

		
	}

	public function addListInv(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$invNumber = $this->input->post('po_numberInv');
		$query = $this->M_monitoringinvoice->getInvNumber($invNumber);
		$data['invoice']=$query;
		$data['allVendor'] = $this->M_monitoringinvoice->getVendorName();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_addinvoice',$data);
		$this->load->view('V_Footer',$data);

	}

	public function batchDetail($batch){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$invoice = $this->M_monitoringinvoice->showDetailPerBatch($batch);
		$no = 0;
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['invoice_id'] ;
			$po_amount = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);

			foreach ($modal as $price) {
				$total = $price['unit_price'] * $price['qty_invoice'];
				$po_amount = $po_amount + $total;
			}

			$invoice[$no]['po_amount'] = $po_amount;
			$no++;
		}
		$data['batch_number'] = $batch;
		$data['invoice'] =$invoice;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_batch',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPoNumber($no_po)
	{
		$data['invoice'] = $this->M_monitoringinvoice->getInvNumber($no_po);

		$returnView = $this->load->view('MonitoringInvoice/V_tableadd',$data,TRUE);
		
		echo ($returnView);
	} 

	public function addPoNumber(){
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_amount = substr(preg_replace( "/[^0-9]/", "",$this->input->post('invoice_amount')),0,-2);
		$tax_invoice_number = $this->input->post('tax_invoice_number');
		$vendor_name = $this->input->post('vendor_name[]');
		$vendor_number = $this->input->post('vendor_number');
		$po_number = $this->input->post('po_number[]');
		$lppb_number = $this->input->post('lppb_number[]');
		$shipment_number = $this->input->post('shipment_number[]');
		$receive_date = $this->input->post('received_date[]');
		$item_description = $this->input->post('item_description[]');
		$item_code = $this->input->post('item_id[]');
		$qty_receipt = $this->input->post('qty_receipt[]');
		$qty_reject = $this->input->post('qty_reject[]');
		$currency = $this->input->post('currency[]');
		$unit_price = $this->input->post('unit_price[]');
		$qty_invoice = $this->input->post('qty_invoice[]');
		$line_number = $this->input->post('line_num[]');
        
		
		$add2['invoice'] = $this->M_monitoringinvoice->savePoNumber2($invoice_number, $invoice_date, $invoice_amount, $tax_invoice_number,$vendor_number,$vendor_name[0]);


		
		foreach ($po_number as $key => $value) {
			$add['invoice'] = $this->M_monitoringinvoice->savePoNumber($line_number[$key],$po_number[$key],$lppb_number[$key],$shipment_number[$key],$receive_date[$key],$item_description[$key],$item_code[$key],$qty_receipt[$key],$qty_reject[$key],$currency[$key],$unit_price[$key],$qty_invoice[$key],$add2['invoice'][0]['lastval']);
		
		}

		redirect('AccountPayables/MonitoringInvoice/Invoice/addListInv');
	}

	public function deleteInvoice($invoice_id){
		$data['invoice'] = $this->M_monitoringinvoice->deleteInvoice($invoice_id);
		$returnView = $this->load->view('MonitoringInvoice/V_invoice',$data,TRUE);
		redirect('AccountPayables/MonitoringInvoice/Invoice');
	}

	public function editListInv($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$invNumber = $this->input->post('po_numberInv');
		$data['allVendor'] = $this->M_monitoringinvoice->getVendorName();

		$invoice = $this->M_monitoringinvoice->getInvoiceById($id);
		$no = 0;
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['invoice_id'] ;
			$nol = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);

			foreach ($modal as $price) {
				$total = $price['unit_price'] * $price['qty_invoice'];
				$po_amount = $nol + $total;
			}

			$invoice[$no]['po_amount'] = $po_amount;
			$no++;
		}
		

		$data['invoice'] =$invoice;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_editinvoice',$data);
		$this->load->view('V_Footer',$data);

	}

	public function saveEditInvoice($invoice_id){
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_amount = substr(preg_replace( "/[^0-9]/", "",$this->input->post('invoice_amount')),0,-2);
		$tax_invoice_number = $this->input->post('tax_invoice_number');
		$vendor_number = $this->input->post('vendor_number');
		$po_number = $this->input->post('po_number[]');
		$lppb_number = $this->input->post('lppb_number[]');
		$shipment_number = $this->input->post('shipment_number[]');
		$receive_date = $this->input->post('received_date[]');
		$item_description = $this->input->post('item_description[]');
		$qty_receipt = $this->input->post('qty_receipt[]');
		$qty_reject = $this->input->post('qty_reject[]');
		$currency = $this->input->post('currency[]');
		$unit_price = $this->input->post('unit_price[]');
		$qty_invoice = $this->input->post('qty_invoice[]');

		
		$vendor_name = $this->M_monitoringinvoice->namavendor($vendor_number);
		$vendorname = $vendor_name[0]['VENDOR_NAME'];

		$data['invoice2'] = $this->M_monitoringinvoice->saveEditInvoice2($invoice_id,$invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$vendorname,$vendor_number);

		foreach ($po_number as $key => $value) {
			$add['invoice'] = $this->M_monitoringinvoice->saveEditInvoice1($invoice_id,$po_number[$key],$lppb_number[$key],$shipment_number[$key],$receive_date[$key],$item_description[$key],$qty_receipt[$key],$qty_reject[$key],$currency[$key],$unit_price[$key],$qty_invoice[$key]);
		
		}
		redirect('AccountPayables/MonitoringInvoice/Invoice');
	}


	public function saveBatchNumber(){
		$ArrayIdInv = $this->input->post('idYangDiPilih');
		$checkList = $this->input->post('mi-check-list[]');

		$hasilExplode = explode(",", $ArrayIdInv);
		$checkNumBatchExist = $this->M_monitoringinvoice->checkNumBatchExist();
		$BatchNumberNew = $checkNumBatchExist[0]['batch_num'] + 1;
		$saveDate = date('Y-m-d H:i:s', strtotime('+5 hours'));
		$array2 = array_map("unserialize", array_unique(array_map("serialize", $checkList)));

		foreach ($array2 as $po => $value) {
			$checkList = $this->M_monitoringinvoice->getInvoiceById($value);

			foreach ($checkList as $dt => $value2) {
				$inv = $value2['invoice_id'];
				$no_po = $value2['po_number'];
				$line_number = $value2['line_number'];
				$checkListSubmitted = $this->M_monitoringinvoice->checkStatus($no_po,$line_number);

				if ($checkListSubmitted[0]['STATUS'] == 'DELIVER') {
					$cekstatus = $checkListSubmitted[0]['STATUS'];

					$data = $this->M_monitoringinvoice->saveBatchNumberById($inv,$BatchNumberNew,$saveDate);
				}elseif ($checkListSubmitted[0]['STATUS'] == 'DELIVER' AND $checkListSubmitted[0]['STATUS'] == '') {
					$data = $this->M_monitoringinvoice->saveBatchNumberById($inv,$BatchNumberNew,$saveDate);
				}

			}
			
		}
		
		redirect('AccountPayables/MonitoringInvoice/Invoice/listSubmited');
	}

	public function showInvoiceInDetail($invoice_id,$batch){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$invoice = $this->M_monitoringinvoice->showInvoiceInDetail($invoice_id);

		foreach ($invoice as $key => $value) {
			$invoice[0]['detail_invoice'] = $this->M_monitoringinvoice->showInvoiceInDetail2($invoice_id);
		}

		$data['batch_number'] = $batch;


		$data['invoice'] = $invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_batchdetail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function GenerateInvoice(){
		$date = $this->input->post('invoice_date');

		$uw = strtoupper(str_replace('-', '', $date));

		$checkdate=$this->M_monitoringinvoice->checkInvoiceDate($date);
		$checkcount =$this->M_monitoringinvoice->checkInvoiceDatecount($date);
		
		if($checkdate){
			$checkdate = $checkdate[0]['invoice_date'];
			$checkdate = date('d-M-Y',strtotime($checkdate));
		}
		if ($checkdate == $date) {
			$uw = strtoupper(str_replace('-', '', $date));
			echo $uw.'-'.count($checkcount);
		}else {
			echo $uw;
		}				
	}

	public function exportExcelMonitoringInvoice(){
		$this->load->library('Excel');

		$dateTarikFrom = $this->input->post('dateTarikFrom');
		$dateTarikTo = $this->input->post('dateTarikTo');

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

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT MONITORING INVOICE");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Date : ".$dateTarikFrom.' s/d '.$dateTarikTo);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "LPPB Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Vendor Name");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "PO Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "PO Line");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Total Price (DPP)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "CURR");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Term Of Payment");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Invoice Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Invoice Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Accept by Purchasing");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Batch");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Accept by Accounting");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4', "PPN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4', "Tax Invoice Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4', "Accept by Purchasing");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4', "Batch");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4', "Accept by Accounting");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S4', "Update by Purchasing");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T4', "Update by Accounting");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U4', "Status Paid/Unpaid");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);

        foreach(range('B','U') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }

        foreach(range('A','I') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $tarikData = $this->M_monitoringinvoice->exportExcelMonitoringInvoice($dateTarikFrom,$dateTarikTo);

        $no = 1;
        $numrow = 5;
        foreach($tarikData as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['lppb_number']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['vendor_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['po_number']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['po_line']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['total_price']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['currency']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['term_of_payment']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['invoice_date']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['invoice_number']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['last_status_purchasing_date']);
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['purchasing_batch_number']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['last_status_finance_date']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data['ppn']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data['tax_invoice_number']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $data['accept_by_purchasing']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $data['batch']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $data['accept_by_accounting']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $data['update_by_purchasing']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $data['update_by_accounting']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $data['status_paid_unpaid']);
         
            $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            //$objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('U'.$numrow)->applyFromArray($style_row);
             
            $no++;
            $numrow++;
        }

        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Report Monitoring Invoice');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report_Monitoring_Invoice '.$dateTarikFrom.' to '.$dateTarikTo.'.xlsx"');
		$objWriter->save("php://output");

	}

	public function addListPo($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$invNumber = $this->input->post('po_numberInv');
		$query = $this->M_monitoringinvoice->getInvNumber($invNumber);
		$data['invoice']=$query;

		$invoice = $this->M_monitoringinvoice->getInvoiceById($id);

		$no = 0;
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['invoice_id'] ;
			$nol = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);

			foreach ($modal as $price) {
				$total = $price['unit_price'] * $price['qty_invoice'];
				$po_amount = $nol + $total;
			}

			$invoice[$no]['po_amount'] = $po_amount;
			$no++;
		}
		

		$data['invoice'] =$invoice;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_addponumber',$data);
		$this->load->view('V_Footer',$data);

	}

	public function addPoNumber2($id){
		// $invoice_number = $this->input->post('invoice_number');
		// $invoice_date = $this->input->post('invoice_date');
		$invoice_amount = substr(preg_replace( "/[^0-9]/", "",$this->input->post('invoice_amount')),0,-2);
		// $tax_invoice_number = $this->input->post('tax_invoice_number');
		// $vendor_name = $this->input->post('vendor_name[]');
		// $vendor_number = $this->input->post('vendor_number');
		$po_number = $this->input->post('po_number[]');
		$lppb_number = $this->input->post('lppb_number[]');
		$shipment_number = $this->input->post('shipment_number[]');
		$receive_date = $this->input->post('received_date[]');
		$item_description = $this->input->post('item_description[]');
		$item_code = $this->input->post('item_id[]');
		$qty_receipt = $this->input->post('qty_receipt[]');
		$qty_reject = $this->input->post('qty_reject[]');
		$currency = $this->input->post('currency[]');
		$unit_price = $this->input->post('unit_price[]');
		$qty_invoice = $this->input->post('qty_invoice[]');
		$line_number = $this->input->post('line_num[]');
		
		$invoice = $this->M_monitoringinvoice->getInvoiceById($id);
		$no = 0;
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['invoice_id'] ;
			$nol = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);

			foreach ($modal as $price) {
				$total = $price['unit_price'] * $price['qty_invoice'];
				$po_amount = $nol + $total;
			}

			$invoice[$no]['po_amount'] = $po_amount;
			$no++;
		}
		

		$data['invoice'] =$invoice;
		

		$amount = $this->M_monitoringinvoice->saveInvoiveAmount($invoice_amount,$id);

		
		foreach ($po_number as $key => $value) {
			$add['invoice'] = $this->M_monitoringinvoice->savePoNumberNew($line_number[$key],$po_number[$key],$lppb_number[$key],$shipment_number[$key],$receive_date[$key],$item_description[$key],$item_code[$key],$qty_receipt[$key],$qty_reject[$key],$currency[$key],$unit_price[$key],$qty_invoice[$key],$id);
		
		}

		redirect('AccountPayables/MonitoringInvoice/Invoice');
	}

	public function tax_invoice_number(){
		$tax = $this->input->post('tax_input');
		$id = $this->input->post('id');

		$tax_inv = $this->M_monitoringinvoice->tax_invoice_number($id,$tax);
		echo $id;
	}

}