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
			$jmlInv = $this->M_kasiepembelian->getJmlInvPerBatch($lb['batch_num']);
			echo $lb['batch_num'];

			$listBatch[$no]['jml_invoice'] = $jmlInv.' Invoice';
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
			$invoice_id = $bl['invoice_id'] ;

			$po_amount = 0;
			$modal = $this->M_kasiepembelian->getUnitPrice($invoice_id);

			foreach ($modal as $price) {
				$total = $price['unit_price'] * $price['qty_invoice'];
				$po_amount = $po_amount + $total;
			}
			$batch[$no]['po_amount'] = $po_amount;
			$no++;
		}
		$data['batch_number'] = $batchNumber;
		$data['batch'] =$batch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function addReason(){
		$status = $this->input->post('radioForReason[]');
		$reason = $this->input->post('inputReason[]');
		$nomorbatch = $this->input->post('nomor_batch');
		$jenisButton = $this->input->post('submitButton');
		$saveDate = date('Y-m-d H:i:s', strtotime('+5 hours'));

		if ($status != "") {
			if ($jenisButton == 1) {
			$a = 0;
			foreach ($status as $key => $value) {
				foreach ($value as $key2 => $value2) {
					 $id_invoice = $key2;
					 $checkExist = $this->M_kasiepembelian->checkExist($id_invoice);
					 if ($checkExist[0]['purchasing_status'] == 2) {
						 $status = $value2;						 
						 $this->M_kasiepembelian->btnSubmitToPurchasing($id_invoice,$jenisButton,$saveDate);
						 $this->M_kasiepembelian->submitToActionDetail($jenisButton,$saveDate,$status);
					 }
				}
			$a++;
			}
			redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);
		}
		else{
				$a = 0;
				foreach ($status as $key => $value) {
					foreach ($value as $key2 => $value2) {
						$id_invoice = $key2;

					 	$checkExist = $this->M_kasiepembelian->checkExist($id_invoice);
					 	if ($checkExist[0]['purchasing_status'] == 0) {
					 			$reason1 = $reason[$a][$key2]; 

					 		if ($value2 == 3 && $reason1 == NULL) {
					 			echo "<script>
										window.alert('Action harus di pilih');
										window.location.href = 'batchDetailPembelian/".$nomorbatch."';
						      		</script>";
					 		}
					 		else{
					 			$status = $value2;
					 	 		$reason_inv = $reason[$a][$key2];
					 	 		$this->M_kasiepembelian->inputActionAndReason($id_invoice,$status,$reason_inv);
								$this->M_kasiepembelian->inputActionAndReason2($status,$saveDate);
								redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);
					 		}
					 	}
					}
				$a++;
				}
				}	
		}else{
			echo "<script>
				window.alert('Action harus di pilih');
				window.location.href = 'batchDetailPembelian/".$nomorbatch."';
      		</script>";
			redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);
		}

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

}