<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_kasiepembelian extends CI_Controller{

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
		$this->load->model('MonitoringInvKasiePembelian/M_kasiepembelian');
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
		$cek_login = $this->M_kasiepembelian->checkLoginInKasiePembelian($noinduk);
		$login_kasie_pembelian = '';

		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' OR $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN') {
			$login_kasie_pembelian .= "AND source = 'PEMBELIAN SUPPLIER' OR source = 'PENGEMBANGAN PEMBELIAN'";
		}elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR'){
			$login_kasie_pembelian .= "AND source = 'PEMBELIAN SUBKONTRAKTOR'";
		}elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$login_kasie_pembelian .= "AND source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
		}
		
		$listBatch = $this->M_kasiepembelian->showListSubmittedForChecking($login_kasie_pembelian);

		$no = 0;
		foreach($listBatch as $lb){
			$jmlInv = $this->M_kasiepembelian->getJmlInvPerBatch($lb['BATCH_NUMBER']);

			$listBatch[$no]['JML_INVOICE'] = $jmlInv.' Invoice';
			$no++;
		}
		$data['batch'] = $listBatch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_listbatch',$data);
		$this->load->view('V_Footer',$data);
	}

	public function batchDetailPembelian($batchNumber){
		$batchNumber = str_replace('%20', ' ', $batchNumber);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$batch = $this->M_kasiepembelian->showDetailPerBatch($batchNumber);
		
		$no = 0;
		foreach ($batch as $bl => $value) {
			$invoice_id = $value['INVOICE_ID'];
			$po_detail = $value['PO_DETAIL'];

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
				}

				$n++;
			}

			$po_amount = 0;
			$modal = $this->M_kasiepembelian->getUnitPrice($invoice_id);

			foreach ($modal as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
			}
			$batch[$no]['PO_AMOUNT'] = $po_amount;
			$cekPPN = $this->M_kasiepembelian->checkPPN($po_number_explode);
			$batch[$no]['PPN'] = $cekPPN[0]['PPN'];
			$no++;
		}
		$data['batch_number'] = $batchNumber;
		$data['batch'] =$batch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function submittofinance(){
		$finance = $this->input->post('submit_finance');
		$saveDate = date('d-m-Y H:i:s');
		$invoice_id = $this->input->post('invoice_id');

		$exp_invoice_id = explode(',', $invoice_id);
		foreach ($exp_invoice_id as $id => $value) {
			$inv_id = $exp_invoice_id[$id];

			$checkStatus = $this->M_kasiepembelian->checkApprove($inv_id);
			if ($checkStatus[0]['LAST_PURCHASING_INVOICE_STATUS'] == 2 and $checkStatus[0]['LAST_FINANCE_INVOICE_STATUS'] == 0) {
			// print_r($checkStatus);
				$this->M_kasiepembelian->btnSubmitToFinance($inv_id,$finance,$saveDate);
				$getStatus = $this->M_kasiepembelian->getLastStatusActionDetail($inv_id);
				$statuslama = ($getStatus) ? $getStatus[0]['PURCHASING_STATUS'] : '';
				// if ($getStatus) {
				// 	$statuslama  = $getStatus[0]['PURCHASING_STATUS'];
				// }else{
				// 	$statuslama = '';
				// }
				$this->M_kasiepembelian->insertstatusfinance($inv_id,$saveDate,$finance,$statuslama);
				
			}
		}
	}

	public function approvedbykasiepurchasing(){
		$approved = $this->input->post('prosesapprove');
		$saveDate = date('d-m-Y H:i:s');
		$invoice_id = $this->input->post('idYangDiPilih');
		$nomorbatch = $this->input->post('nomor_batch');

		$expid = explode(',', $invoice_id);

		foreach ($expid as $key => $value) {
			$this->M_kasiepembelian->approvedbykasiepurchasing($value,$approved,$saveDate);
			$this->M_kasiepembelian->inputstatuspurchasing($value,$saveDate,$approved);
		}
		
		redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);

	}

	public function rejectbykasiepurchasing(){
		$rejected = $this->input->post('prosesreject');
		$saveDate = date('d-m-Y H:i:s');
		$invoice_id = $this->input->post('invoice_id');
		$nomorbatch = $this->input->post('nomor_batch');
		$alasan_reject = $this->input->post('alasan_reject');

		$this->M_kasiepembelian->rejectbykasiepurchasing($invoice_id, $rejected, $saveDate, $alasan_reject);
		$this->M_kasiepembelian->inputstatuspurchasing($invoice_id,$saveDate,$rejected);
		redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);
	}

	public function approveInvoice(){
		$saveDate = date('d-m-Y H:i:s');
		$invoice_id = $this->input->post('invoice_id');
		$status = $this->input->post('status');
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_amount = $this->input->post('invoice_amount');
		$tax_invoice_number = $this->input->post('tax_invoice_number');
		$invoice_category = $this->input->post('invoice_category');
		$nominal_dpp = $this->input->post('nominal_dpp');
		$info = $this->input->post('info');
		$jenis_jasa = $this->input->post('jenis_jasa');
		$nomorbatch = $this->input->post('nomor_batch');

		$this->M_kasiepembelian->approveInvoice($invoice_id,$status,$saveDate);
		$this->M_kasiepembelian->editInvoiceKasiePurc($invoice_id,$invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$info,$nominal_dpp,$invoice_category,$jenis_jasa);
		$this->M_kasiepembelian->inputstatuspurchasing($invoice_id,$saveDate,$status);

	}

	public function saveInvoicebyKasiePurchasing(){
		$invoice_id = $this->input->post('invoice_id');
		$invoice_number = $this->input->post('invoice_number');
		$invoice_date = $this->input->post('invoice_date');
		$invoice_amount = $this->input->post('invoice_amount');
		$tax_invoice_number = $this->input->post('tax_invoice_number');
		$invoice_category = $this->input->post('invoice_category');
		$nominal_dpp = $this->input->post('nominal_dpp');
		$info = $this->input->post('info');
		$jenis_jasa = $this->input->post('jenis_jasa');
		$nomorbatch = $this->input->post('nomor_batch');

		$this->M_kasiepembelian->editInvoiceKasiePurc($invoice_id,$invoice_number,$invoice_date,$invoice_amount,$tax_invoice_number,$info,$nominal_dpp,$invoice_category,$jenis_jasa);
		redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);
	}

	public function invoiceDetail($invoice_id,$nomorbatch){
		$nomorbatch = str_replace('%20', ' ', $nomorbatch);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$detail = $this->M_kasiepembelian->invoiceDetail($invoice_id);

		$data['invoice_detail'] = $detail;
		$data['batch_number'] = $nomorbatch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_invoice',$data);
		$this->load->view('V_Footer',$data);
	}

	public function finishBatch(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_kasiepembelian->checkLoginInKasiePembelian($noinduk);
		$login_kasie_pembelian = '';

		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' OR $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN') {
			$login_kasie_pembelian .= "AND source = 'PEMBELIAN SUPPLIER' OR source = 'PENGEMBANGAN PEMBELIAN'";
		}elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR'){
			$login_kasie_pembelian .= "AND source = 'PEMBELIAN SUBKONTRAKTOR'";
		}elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$login_kasie_pembelian .= "AND source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
		}

		$listBatch = $this->M_kasiepembelian->showFinishBatch($login_kasie_pembelian);

		foreach($listBatch as $key => $lb){
			$detail = $this->M_kasiepembelian->detailBatch($lb['BATCH_NUMBER']);
			$listBatch[$key]['approved'] = 'Approve : '.$detail[0]['APPROVE'].' Invoice';
			$listBatch[$key]['rejected'] = 'Reject : '.$detail[0]['REJECT'].' Invoice';
			$listBatch[$key]['submited'] = 'Submit : '.$detail[0]['SUBMIT'].' Invoice';
		}
		$data['batch'] = $listBatch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_finishbatch',$data);
		$this->load->view('V_Footer',$data);
	}

	public function finishdetailinvoice($batchNumber){
		$batchNumber = str_replace('%20', ' ', $batchNumber);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$batch = $this->M_kasiepembelian->finish_detail($batchNumber);
		
		$no = 0;
		foreach ($batch as $bl) {
			$invoice_id = $bl['INVOICE_ID'] ;

			$po_amount = 0;
			$modal = $this->M_kasiepembelian->getUnitPrice($invoice_id);

			foreach ($modal as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
			}
			$batch[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		$data['batch_number'] = $batchNumber;
		$data['batch'] =$batch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_finishdetailinvoice',$data);
		$this->load->view('V_Footer',$data);
	}

	public function finishinvoice($invoice_id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$detail_invoice = $this->M_kasiepembelian->finish_detail_invoice($invoice_id);
		
		$no = 0;
		foreach ($detail_invoice as $bl) {
			$invoice_id = $bl['INVOICE_ID'] ;

			$po_amount = 0;
			$modal = $this->M_kasiepembelian->getUnitPrice($invoice_id);

			foreach ($modal as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
			}
			$detail_invoice[$no]['PO_AMOUNT'] = $po_amount;
			$no++;
		}
		$data['invoice'] =$detail_invoice;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_finishinvoice',$data);
		$this->load->view('V_Footer',$data);
	}

	public function modal_approve_reject_invoice($invoice_id){
		$detail = $this->M_kasiepembelian->invoiceDetail($invoice_id);
		$data['invoice'] = $detail;
		$return = $this->load->view('MonitoringInvKasiePembelian/V_modal_invoice',$data,TRUE);
		
		echo ($return);
	}

	public function submitUlang(){
		$invoice_id = $this->input->post('hasil');
		$date = date('d-m-Y H:i:s');

		$expid = explode(',', $invoice_id);
		foreach ($expid as $ex => $value) {
			$this->M_kasiepembelian->submitUlang($value,$date);
			$this->M_kasiepembelian->insertSubmitUlang($value,$date);
		}

	}

	public function submitUlangKasieGudang()
	{
		$batch_number = $this->input->post('batch_number');
		$date = date('d-m-Y H:i:s');

		$this->M_kasiepembelian->submitUlangKasieGudang($batch_number,$date);
		$id = $this->M_kasiepembelian->ambilId($batch_number);
		foreach ($id as $key => $value) {
			$this->M_kasiepembelian->simpanID($value['INVOICE_ID'],$date);
			
		}
	}

}