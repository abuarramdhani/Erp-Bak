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
		
		$listBatch = $this->M_kasiepembelian->showListSubmittedForChecking();

		$no = 0;
		foreach($listBatch as $lb){
			$jmlInv = $this->M_kasiepembelian->getJmlInvPerBatch($lb['BATCH_NUM']);
			echo $lb['BATCH_NUM'];

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
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
	
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$batch = $this->M_kasiepembelian->showDetailPerBatch($batchNumber);
		
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
		$this->load->view('MonitoringInvKasiePembelian/V_detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function submittofinance(){
		$finance = $this->input->post('submit_finance');
		$saveDate = date('d-m-Y H:i:s', strtotime('+6 hours'));
		$invoice_id = $this->input->post('invoice_id');

		$checkFinanceNumber = $this->M_kasiepembelian->checkFinanceNumber();
		$finance_batch_number = $checkFinanceNumber[0]['FINANCE_BATCH_NUMBER'] + 1;

		$this->M_kasiepembelian->btnSubmitToFinance($invoice_id,$finance,$saveDate,$finance_batch_number);
		$this->M_kasiepembelian->insertstatusfinance($invoice_id,$saveDate,$finance);

		redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/finishBatch');
	}

	public function approvedbykasiepurchasing(){
		$approved = $this->input->post('prosesapproved');
		$saveDate = date('d-m-Y H:i:s', strtotime('+6 hours'));
		$invoice_id = $this->input->post('invoice_id');
		$nomorbatch = $this->input->post('nomor_batch');

		$this->M_kasiepembelian->approvedbykasiepurchasing($invoice_id,$approved,$saveDate);
		$this->M_kasiepembelian->inputstatuspurchasing($invoice_id,$saveDate,$approved);
		redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);
	}

	public function rejectbykasiepurchasing(){
		$rejected = $this->input->post('prosesreject');
		$saveDate = date('d-m-Y H:i:s', strtotime('+6 hours'));
		$invoice_id = $this->input->post('invoice_id');
		$nomorbatch = $this->input->post('nomor_batch');
		$alasan_reject = $this->input->post('alasan_reject');

		$this->M_kasiepembelian->rejectbykasiepurchasing($invoice_id, $rejected, $saveDate, $alasan_reject);
		$this->M_kasiepembelian->inputstatuspurchasing($invoice_id,$saveDate,$rejected);
		redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);
	}

	public function invoiceDetail($invoice_id,$nomorbatch){
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

		$listBatch = $this->M_kasiepembelian->showFinishBatch();

		$no = 0;
		foreach($listBatch as $lb){
			$jmlInv = $this->M_kasiepembelian->getJmlInvPerBatch($lb['BATCH_NUM']);
			// echo $lb['BATCH_NUM'];

			$listBatch[$no]['JML_INVOICE'] = $jmlInv.' Invoice';
			$no++;
		}
		$data['batch'] = $listBatch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_finishBatch',$data);
		$this->load->view('V_Footer',$data);
	}

	public function finishdetailinvoice($batchNumber){
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

}