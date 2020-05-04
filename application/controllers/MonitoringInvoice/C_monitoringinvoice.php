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
		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringinvoice->checkSourceLogin($noinduk);
		$source_login = '';
		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' OR $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN') {
			$source_login .= "AND source = 'PEMBELIAN SUPPLIER' OR source = 'PENGEMBANGAN PEMBELIAN'";
		}elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR'){
			$source_login .= "AND source = 'PEMBELIAN SUBKONTRAKTOR'";
		}elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login .= "AND source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
		}
		$invoice = $this->M_monitoringinvoice->showInvoice($source_login);
		$no = 0;
		$keputusan = array();
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['INVOICE_ID'] ;
			$po_detail = $inv['PO_DETAIL'];
			// $po_number = $inv['PO_NUMBER'];
			$keputusan[$inv['INVOICE_ID']] = "";
			$hasil_komitmen = '';
			if ($po_detail) {
				$expPoDetail = explode('<br>', $po_detail);
				if (!$expPoDetail) {
					$expPoDetail = $po_detail;
				}
					
				$n=0;
				$podetail = array();
				foreach ($expPoDetail as $ep => $value) {
					$exp_lagi = explode('-', $value);
							$po_number_explode = $exp_lagi[0];
							$lppb_number_explode = $exp_lagi[2];
							$line_number_explode = $exp_lagi[1];
							$perbandingan = $this->M_monitoringinvoice->podetails($po_number_explode,$lppb_number_explode,$line_number_explode);
							if (!$perbandingan) {
								$status = "No Status";
							}else{
								$status = $perbandingan[$n]['STATUS'];
							}
							$podetail[$ep] = $value.' - '.$status;
				}
				$keputusan[$inv['INVOICE_ID']] = $podetail;
				$n++;
			}
			
			$po_amount = 0;
			$unit = $this->M_monitoringinvoice->getUnitPrice($invoice_id);
			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
			}
			$cekPPN = $this->M_monitoringinvoice->checkPPN($po_number_explode);
			$invoice[$no]['PPN'] = $cekPPN[0]['PPN'];
			$invoice[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		$data['keputusan'] = $keputusan;
		$data['invoice'] =$invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_invoice',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
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
		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringinvoice->checkSourceLogin($noinduk);
		$source_login = '';
		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' OR $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN') {
			$source_login .= "AND source = 'PEMBELIAN SUPPLIER' OR source = 'PENGEMBANGAN PEMBELIAN'";
		}elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR'){
			$source_login .= "AND source = 'PEMBELIAN SUBKONTRAKTOR'";
		}elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login .= "AND source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
		}
		
		$listBatch = $this->M_monitoringinvoice->showListSubmitted($source_login);
		
		$no = 0;
		foreach ($listBatch as $key => $value) {
			$jmlInv = $this->M_monitoringinvoice->getJmlInvPerBatch($value['BATCH_NUMBER']);
			$listBatch[$no]['JML_INVOICE'] = $jmlInv.' invoice';
			$no++;
		}
		$data['invoice'] = $listBatch;
		// print_r($data);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_listsubmit',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
		
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
		// $this->output->cache(1);


	}
	public function batchDetail($batch){
		$batch = str_replace('%20', ' ', $batch);
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
			$invoice_id = $inv['INVOICE_ID'] ;
			$po_amount = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);
			foreach ($modal as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
			}
			$invoice[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		$data['batch_number'] = $batch;
		$data['invoice'] =$invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_batch',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}
	public function getPoNumber($no_po)
	{
		$data['invoice'] = $this->M_monitoringinvoice->getInvNumber($no_po);
		$returnView = $this->load->view('MonitoringInvoice/V_tableadd',$data,TRUE);
		
		echo ($returnView);
	} 
	// ini fungsi untuk menginput data dari addinvoice
	public function addPoNumber(){
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_amount = $this->input->post('invoice_amount');
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
		$last_admin_date = date('d-m-Y H:i:s');
		$action_date = date('d-m-Y H:i:s');
		$note_admin = $this->input->post('note_admin');
		$invoice_category = $this->input->post('invoice_category');
		$nominal_dpp = $this->input->post('nominal_dpp');
		$jenis_jasa = $this->input->post('jenis_jasa');
		$jenis_dokumen = $this->input->post('jenis_dokumen');
		
		// ini fungsi login, hak ases
		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringinvoice->checkSourceLogin($noinduk);
		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER') {
			$source_login = 'PEMBELIAN SUPPLIER';
		} elseif ($cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN') {
			$source_login = 'PENGEMBANGAN PEMBELIAN';
		} elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR'){
			$source_login = 'PEMBELIAN SUBKONTRAKTOR';
		} elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login = 'INFORMATION & COMMUNICATION TECHNOLOGY';
		}
		// tentang separator
		$amount = str_replace(',', '', $invoice_amount); //478636
		$vendor = str_replace("'", "", $vendor_name);
		$item_desc = str_replace("'", "", $item_description);
		$pajak = str_replace(",", "", $nominal_dpp);
		$add2['invoice'] = $this->M_monitoringinvoice->savePoNumber2($invoice_number, $invoice_date, $amount, $tax_invoice_number,$vendor_number,$vendor[0],$last_admin_date,$note_admin,$invoice_category,$pajak,$source_login,$jenis_jasa,$jenis_dokumen);
		
		foreach ($po_number as $key => $value) {
			$add['invoice'] = $this->M_monitoringinvoice->savePoNumber($line_number[$key],$po_number[$key],$lppb_number[$key],$shipment_number[$key],$receive_date[$key],$item_desc[$key],$item_code[$key],$qty_receipt[$key],$qty_reject[$key],$currency[$key],$unit_price[$key],$qty_invoice[$key],$add2['invoice'][0]['INVOICE_ID']);
		 
		}
		$this->M_monitoringinvoice->savePoNumber3($add2['invoice'][0]['INVOICE_ID'],$action_date);
		redirect('AccountPayables/MonitoringInvoice/Invoice/addListInv');
	}

		public function deleteInvoice(){
		$invoice_id = $this->input->post('invoice_id');

		foreach ($invoice_id as $key => $value) {
			$this->M_monitoringinvoice->deleteInvoice($value);
		}

		echo json_encode($invoice_id);
		}

		public function deleteInvoiceManual($invoice_id){

		$data['invoice'] = $this->M_monitoringinvoice->deleteInvoice2($invoice_id);
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
		$invoice = $this->M_monitoringinvoice->getInvoiceById($id);		
		$no = 0;
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['INVOICE_ID'] ;
			$nol = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);
			foreach ($modal as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $nol + $total;
			}
			$invoice[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		
		$data['invoice'] =$invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_editinvoice',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}
	public function saveEditInvoice($invoice_id){
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_amount = $this->input->post('invoice_amount');
		$tax_invoice_number = $this->input->post('tax_invoice_number');
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
		$action_date = date('d-m-Y H:i:s');
		$item_code = $this->input->post('item_code[]');
		$invoice_po_id = $this->input->post('invoice_po_id[]');
		$note_admin = $this->input->post('note_admin');
		$invoice_category = $this->input->post('invoice_category');
		$nominal_dpp = $this->input->post('nominal_dpp');
		$jenis_jasa = $this->input->post('jenis_jasa');
		// $amount = str_replace(',', '', $invoice_amount);
		$item_desc = str_replace("'", "", $item_description);
		$amount = preg_replace("/[^0-9]/" , "", $invoice_amount );
		$str_amount = substr($amount, 0, -2);
		$pajak = preg_replace("/[^0-9]/" , "", $nominal_dpp );
		$str_pajak = substr($pajak, 0, -2);
		$data['invoice2'] = $this->M_monitoringinvoice->saveEditInvoice2($invoice_id,$invoice_number,$invoice_date,$str_amount,$tax_invoice_number,$note_admin,$str_pajak,$invoice_category,$jenis_jasa);
		foreach ($po_number as $key => $value) {
			$add['invoice'] = $this->M_monitoringinvoice->saveEditInvoice1($invoice_po_id[$key],$po_number[$key],$lppb_number[$key],$shipment_number[$key],$receive_date[$key],$item_desc[$key],$item_code[$key],$qty_receipt[$key],$qty_reject[$key],$currency[$key],$unit_price[$key],$qty_invoice[$key]);
		
		}
		$this->M_monitoringinvoice->saveEditInvoice3($invoice_id,$action_date);
		redirect('AccountPayables/MonitoringInvoice/Invoice');
	}
	public function saveBatchNumber(){
		$ArrayIdInv = $this->input->post('idYangDiPilih');
		$checkList = $this->input->post('mi-check-list[]');
		$status = $this->input->post('status_purchase');
		$invoice_category = $this->input->post('invoice_category');
		$date = strtoupper(date('dMY'));
		$hasilExplode = explode(",", $ArrayIdInv);
		// $checkNumBatchExist = $this->M_monitoringinvoice->checkNumBatchExist();
		// $batch = $checkNumBatchExist[0]['BATCH_NUMBER'];
		$BatchNumberNew = $this->M_monitoringinvoice->checkBatchNumbercount('SUP'.'-'.$invoice_category.'-'.$date);
		$saveDate = date('d-m-Y H:i:s');
		$array2 = array_map("unserialize", array_unique(array_map("serialize", $checkList)));
		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringinvoice->checkSourceLogin($noinduk);
		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' || $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN' ) {
			if ($BatchNumberNew) {
				$batch_number = 'SUP'.'-'.$invoice_category.'-'.$date.'-'.count($BatchNumberNew);
			}else{
				$batch_number = 'SUP'.'-'.$invoice_category.'-'.$date;
			}
		} elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR') {
			if ($BatchNumberNew) {
				$batch_number = 'SUB'.'-'.$invoice_category.'-'.$date.'-'.count($BatchNumberNew);
			}else{
				$batch_number = 'SUB'.'-'.$invoice_category.'-'.$date;
			}
		} else{
			if($this->form_validation->run() == FALSE){
			  echo '<script> alert("'.str_replace(array('\r','\n'), '\n', validation_errors()).'"); </script>';
			  redirect('AccountPayables/MonitoringInvoice/Invoice');
			}
		}
		foreach ($array2 as $po => $value) {
			$checkList = $this->M_monitoringinvoice->getInvoiceById($value);
			foreach ($checkList as $dt => $value2) {
				$inv = $value2['INVOICE_ID'];
				$this->M_monitoringinvoice->saveBatchNumberById($inv,$batch_number,$saveDate,$status);
				$this->M_monitoringinvoice->saveBatchNumberById2($inv,$saveDate,$status);
			}
			
		}
		
		redirect('AccountPayables/MonitoringInvoice/Invoice/listSubmited');
	}
	public function showInvoiceInDetail($invoice_id,$batch){
		$batch = str_replace('%20', ' ', $batch);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$invoice = $this->M_monitoringinvoice->showInvoiceInDetail($invoice_id);
		foreach ($invoice as $key => $value) {
			$invoice[0]['DETAIL_INVOICE'] = $this->M_monitoringinvoice->showInvoiceInDetail2($invoice_id);
		}
		$data['batch_number'] = $batch;
		$data['invoice'] = $invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_batchdetail',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}
	public function GenerateInvoice(){
		$date = $this->input->post('invoice_date');
		$dt =  date('d-M-Y', strtotime($date));
		$uw = strtoupper(str_replace('-', '', $date));
		$checkdate=$this->M_monitoringinvoice->checkInvoiceDate($dt);
		$checkcount =$this->M_monitoringinvoice->checkInvoiceDatecount($dt);
		if ($checkdate) {
			$uw = strtoupper(str_replace('-', '', $dt));
			echo $uw.'-'.count($checkcount);
		}else{
			echo $uw;
		}			
	}
	public function exportExcelMonitoringInvoice(){
		$this->load->library('Excel');
		$batch_num = $this->input->post('batch_num');
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
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Date : ".$dateTarikFrom.' s/d '.$dateTarikTo);
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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Batch Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Accept by Accounting");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4', "PPN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4', "Tax Invoice Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4', "Accept by Purchasing");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4', "Finance Batch Number");
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
        $tarikData = $this->M_monitoringinvoice->exportExcelMonitoringInvoice($batch_num);
        $no = 1;
        $numrow = 5;
        foreach($tarikData as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['LPPB_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['VENDOR_NAME']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['PO_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['LINE_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['PO_AMOUNT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['CURRENCY']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['TERMS_OF_PAYMENT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['INVOICE_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['INVOICE_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['LAST_STATUS_PURCHASING_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['BATCH_NUM']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['LAST_STATUS_FINANCE_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data['PPN']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data['TAX_INVOICE_NUMBER']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $data['accept_by_purchasing']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $data['FINANCE_BATCH_NUMBER']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $data['accept_by_accounting']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $data['update_by_purchasing']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $data['update_by_accounting']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$numrow, $data['status_paid_unpaid']);
         
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
            $objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
            // $objPHPExcel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
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
		header('Content-Disposition: attachment;filename="Report_Monitoring_Invoice Batch Number '.$batch_num.'.xlsx"');
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
			$invoice_id = $inv['INVOICE_ID'] ;
			$nol = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);
			foreach ($modal as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $nol + $total;
			}
			$invoice[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		
		$data['invoice'] =$invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_addponumber',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}
	public function addPoNumber2($id){
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_amount = $this->input->post('invoice_amount');
		$tax_invoice_number = $this->input->post('tax_invoice_number');
		$vendor_name = $this->input->post('vendor_name[]');
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
		$invoice_category = $this->input->post('invoice_category');
		$nominal_dpp = $this->input->post('nominal_dpp');
		$note_admin = $this->input->post('note_admin');
		
		$amount2 = str_replace(',', '', $invoice_amount);
		$vendor = str_replace("'", "", $vendor_name);
		$item_desc = str_replace("'", "", $item_description);
		$invoice = $this->M_monitoringinvoice->getInvoiceById($id);
		$no = 0;
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['INVOICE_ID'] ;
			$nol = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);
			foreach ($modal as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $nol + $total;
			}
			$invoice[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		
		$amount = $this->M_monitoringinvoice->saveInvoiveAmount($invoice_number,$invoice_date,$amount2,$tax_invoice_number,$vendor,$invoice_category,$nominal_dpp,$note_admin,$id);
		
		foreach ($po_number as $key => $value) {
			$add['invoice'] = $this->M_monitoringinvoice->savePoNumberNew($line_number[$key],$po_number[$key],$lppb_number[$key],$shipment_number[$key],$receive_date[$key],$item_desc[$key],$item_code[$key],$qty_receipt[$key],$qty_reject[$key],$currency[$key],$unit_price[$key],$qty_invoice[$key],$id);
		
		}
		$data['invoice'] =$invoice;
		redirect('AccountPayables/MonitoringInvoice/Invoice');
	}
	public function tax_invoice_number(){
		$tax = $this->input->post('tax_input');
		$id = $this->input->post('id');
		$tax_inv = $this->M_monitoringinvoice->tax_invoice_number($id,$tax);
		echo $id;
	}
	public function viewreject()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringinvoice->checkSourceLogin($noinduk);
		$source_login = '';
		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' OR $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN') {
			$source_login .= "AND source = 'PEMBELIAN SUPPLIER' OR source = 'PENGEMBANGAN PEMBELIAN'";
		}elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR'){
			$source_login .= "AND source = 'PEMBELIAN SUBKONTRAKTOR'";
		}elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login .= "AND source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
		}
		$invoice = $this->M_monitoringinvoice->invoicereject($source_login);
		$no = 0;
		$keputusan = array();
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['INVOICE_ID'] ;
			$po_detail = $inv['PO_DETAIL'];
			// $po_number = $inv['PO_NUMBER'];
			$keputusan[$inv['INVOICE_ID']] = "";
			$hasil_komitmen = '';
			if ($po_detail) {
				$expPoDetail = explode('<br>', $po_detail);
				if (!$expPoDetail) {
					$expPoDetail = $po_detail;
				}
					
				$n=0;
				$podetail = array();
				foreach ($expPoDetail as $ep => $value) {
					$exp_lagi = explode('-', $value);
							$po_number_explode = $exp_lagi[0];
							$lppb_number_explode = $exp_lagi[2];
							$line_number_explode = $exp_lagi[1];
							$perbandingan = $this->M_monitoringinvoice->podetails($po_number_explode,$lppb_number_explode,$line_number_explode);
							if (!$perbandingan) {
								$status = "No Status";
							}else{
								$status = $perbandingan[$n]['STATUS'];
							}
							$podetail[$ep] = $value.' - '.$status;
				}
				$keputusan[$inv['INVOICE_ID']] = $podetail;
				$n++;
			}
			$po_amount = 0;
			$unit = $this->M_monitoringinvoice->getUnitPrice($invoice_id);
			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
			}
			$cekPPN = $this->M_monitoringinvoice->checkPPN($po_number_explode);
			$invoice[$no]['PPN'] = $cekPPN[0]['PPN'];
			$invoice[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		$data['keputusan'] = $keputusan;
		$data['invoice'] =$invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_rejected',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}
	public function Detail($invoice_id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$invoice = $this->M_monitoringinvoice->getInvoiceById($invoice_id);
		$data['invoice'] = $invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_rejecteddetail',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}
	public function deletePOLine(){
		$invoice_po_id = $this->input->post('invoice_po_id');
		$this->M_monitoringinvoice->deletePOLine($invoice_po_id);
	}
	public function viewEditReject($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$invoice = $this->M_monitoringinvoice->getInvoiceById($id);		
		$no = 0;
		foreach ($invoice as $inv ) {
			$invoice_id = $inv['INVOICE_ID'] ;
			$nol = 0;
			$modal = $this->M_monitoringinvoice->getUnitPrice($invoice_id);
			foreach ($modal as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $nol + $total;
			}
			$invoice[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		
		$data['invoice'] =$invoice;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_editReject',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}
	public function saveEditReject($invoice_id){
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_amount = $this->input->post('invoice_amount');
		$tax_invoice_number = $this->input->post('tax_invoice_number');
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
		$action_date = date('d-m-Y H:i:s');
		$item_code = $this->input->post('item_code[]');
		$invoice_po_id = $this->input->post('invoice_po_id[]');
		$status = $this->input->post('saveReject');
		$note_admin = $this->input->post('note_admin');
		$invoice_category = $this->input->post('invoice_category');
		$nominal_dpp = $this->input->post('nominal_dpp');
		$jenis_jasa = $this->input->post('jenis_jasa');
		// $amount = str_replace(',', '', $invoice_amount);
		$item_desc = str_replace("'", "", $item_description);
		$amount = preg_replace("/[^0-9]/" , "", $invoice_amount );
		$str_amount = substr($amount, 0, -2);
		$pajak = preg_replace("/[^0-9]/" , "", $nominal_dpp );
		$str_pajak = substr($pajak, 0, -2);
		// echo "<pre>";
		// print_r($str);
		// exit();
 
		$data['invoice2'] = $this->M_monitoringinvoice->saveReject($invoice_id,$invoice_number,$invoice_date,$str_amount,$tax_invoice_number,$status,$note_admin,$invoice_category,$str_pajak,$jenis_jasa);
		foreach ($po_number as $key => $value) {
			$add['invoice'] = $this->M_monitoringinvoice->saveEditInvoice1($invoice_po_id[$key],$po_number[$key],$lppb_number[$key],$shipment_number[$key],$receive_date[$key],$item_desc[$key],$item_code[$key],$qty_receipt[$key],$qty_reject[$key],$currency[$key],$unit_price[$key],$qty_invoice[$key]);
		
		}
		$this->M_monitoringinvoice->saveEditInvoice3($invoice_id,$action_date);
		redirect('AccountPayables/MonitoringInvoice/Invoice');
	}
	public function SusulFakturPajak()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$invoice = $this->M_monitoringinvoice->showInvoice($source_login);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoice/V_fakturPajak',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}

	public function loadMasterItem()
	
	{
		$user_id = $this->session->userid;			
/*
		 * DataTables example server-side processing script.
		 *
		 * Please note that this script is intentionally extremely simply to show how
		 * server-side processing can be implemented, and probably shouldn't be used as
		 * the basis for a large complex system. It is suitable for simple use cases as
		 * for learning.
		 *
		 * See http://datatables.net/usage/server-side for full details on the server-
		 * side processing requirements of DataTables.
		 *
		 * @license MIT - http://datatables.net/license_mit
		 */
		 
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Easy set variables
 		*/
 
		// DB table to use
		$table = 'khs_ap_monitoring_invoice';
 
		// Table's primary key
		$primaryKey = 'master_item_id';
 
		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database, while the `dt`
		// parameter represents the DataTables column identifier. In this case simple
		// indexes
		$columns = array(
					array( 'db' => 'master_item_id', 'dt' => 0 ),
					array( 'db' => 'pengelola_id', 
								'dt' => 1,
								'formatter'=> function($d, $row){
									$pengelola_id = $row['pengelola_id'];
									if ($pengelola_id !='') {
										$pengelola = $this->M_purchasesetting->getDetailPengelola($pengelola_id);

										return $pengelola[0]['pengelola'];
									}else{
										return '';
									}
								}
							),
					array( 
						'db' => 'asset_kategori_id',   
							'dt' => 2,
							'formatter' => function($d, $row){
								$kategori_id = $row['asset_kategori_id'];
								if ($kategori_id!='') {
									$kategoriAset = $this->M_purchasesetting->getDetailKategoriAsset($kategori_id);

									return $kategoriAset[0]['kategori_asset'];
								}else {
									return '';
								}
							}
						),
					array( 
						'db' => 'approval_dirut',     
							'dt' => 3,
							'formatter' => function($d, $row) {
								if($row['approval_dirut']==1)
									return 'YES';
								else
									return 'NO'; 
							} ),
						array( 
							'db' => 'editable_status',     
							'dt' => 4,
							'formatter' => function($d, $row) {
								if($row['editable_status']==1)
									return 'YES';
								else
									return 'NO';
							} ),
						array(
						'db'        => 'master_item_id',
						'dt'        => 5,
						'formatter' => function( $d, $row ) {
							$buttons='<a style="margin-right:8px;margin-left:4px;" onclick="deleteMasterItem(\''.$row['master_item_id'].'\')" href="#" name="btnDel" alt="Delete" title="Delete" data-confirm="Are you sure to delete this item?"><i class="fa fa-trash fa-2x"></i></a>
									
							<a style="margin-right:8px;" onclick="editMasterItem(\''.$row['master_item_id'].'\')" href="#" alt="Edit" title="Edit"><i class="fa fa-pencil-square-o fa-2x"></i>';
									return $buttons;
						},
					),
		);
 
		// SQL server connection information
		$sql_details = array(
  	  'user' => 'postgres',
  	  'pass' => 'password',
  	  'db'   => 'erp',
  	  'host' => 'dev.quick.com'
		);
 
 
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 		* If you just want to use the basic configuration for DataTables with PHP
 		* server-side, there is no need to edit below this line.
 		*/
 
		$conditions = '1=1'; 
		 
			$this->load->library('Ssp');
		
			$SSP = new SSP;
 
		echo json_encode(
    	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
		);
	}
}