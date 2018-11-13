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

	public function addReasonAsli(){
		$status = $this->input->post('radioForReason[]');
		$reason = $this->input->post('inputReason[]');
		$nomorbatch = $this->input->post('nomor_batch');
		$jenisButton = $this->input->post('submitButton');
		$saveDate = date('d-m-Y H:i:s', strtotime('+6 hours'));

		if ($status) {
			if ($jenisButton == 1) {
				$a = 0;
				foreach ($status as $key => $value) {
					foreach ($value as $key2 => $value2) {
						 $id_invoice = $key2;
						 $checkExist = $this->M_kasiepembelian->checkExist($id_invoice);
						 print_r($checkExist);
						 if ($checkExist[0]['PURCHASING_STATUS'] == 0) {
						 	echo "saving<br>";
							 $stat = $value2;						 
							$s1 = $this->M_kasiepembelian->btnSubmitToPurchasing($id_invoice,$jenisButton,$saveDate);
							$s2 = $this->M_kasiepembelian->submitToActionDetail($jenisButton,$saveDate,$stat);
							print_r($s1);
							print_r($s2);
						 }
					}
					$a++;
				}
				exit;
				redirect('AccountPayables/MonitoringInvoice/InvoiceKasie/batchDetailPembelian/'.$nomorbatch);
			}else{
						$a = 0;
						foreach ($status as $key => $value) {
							foreach ($value as $key2 => $value2) {
								$id_invoice = $key2;

							 	$checkExist = $this->M_kasiepembelian->checkExist($id_invoice);
							 	if ($checkExist[0]['PURCHASING_STATUS'] == 0) {
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

	public function addReasonModifikasi(){
		$status = $this->input->post('radioForReason');
		$reason = $this->input->post('inputReason');

		$nomorbatch = $this->input->post('nomor_batch');
		$jenisButton = $this->input->post('submitButton');
		$saveDate = date('d-m-Y H:i:s', strtotime('+6 hours'));

		$checkFinanceNumber = $this->M_kasiepembelian->checkFinanceNumber();
		$finance_batch_number = $checkFinanceNumber[0]['FINANCE_BATCH_NUMBER'] + 1;


		if ($status) {
			if ($jenisButton == 2) {
				foreach ($status as $s => $value) {

					foreach ($value as $v => $value2) {
						$invoice_id = $v;
						$stat = $value2;
						$rsn = $reason[$s][$v];
							$update = $this->M_kasiepembelian->inputActionAndReason($invoice_id,$stat,$rsn);
							$insert = $this->M_kasiepembelian->inputActionAndReason2($stat,$saveDate);
					}
				}
			}else{
				foreach ($status as $s => $value) {

					foreach ($value as $v => $value2) {
						$invoice_id = $v;
						$stat = $value2;
						
						if ($stat == 2) {
							$this->M_kasiepembelian->btnSubmitToPurchasing($invoice_id,$jenisButton,$saveDate,$finance_batch_number);
							$this->M_kasiepembelian->submitToActionDetail($jenisButton,$saveDate,$stat);
						}
					}
				}
			}
		}
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

}