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

	public function submitKeBuyer()
	{
		$invoice_id = $this->input->post('invoice_id');
		$buyer = $this->input->post('no_induk_buyer');
		$note = $this->input->post('note');

		$submitKeBuyer = $this->M_kasiepembelian->ForwardToBuyer($invoice_id,$buyer,$note);
		// $isiNote = $this->M_kasiepembelian->isiNote($invoice_id,$note);
	}

	public function ambilAlert()
	{
		$getStatusSatu = $this->M_kasiepembelian->getStatusSatu();
		// echo $getStatusSatu; exit();

		echo json_encode($getStatusSatu);
	}

	public function ambilAlert2()
	{
		$user = $this->session->user;
		$getStatusSatu = $this->M_kasiepembelian->getStatusBuyer($user);
		$status = $getStatusSatu[0]['SATU'];

		echo json_encode($status);
	}

	public function InputFeedback()
	{
		$invoice_id = $this->input->post('invoice_id');
		$ambil_data_feedback = $this->M_kasiepembelian->getFeedback($invoice_id);

		$data['feedback'] = $ambil_data_feedback;
		$data['invoice'] = $invoice_id;

		$this->load->view('MonitoringInvKasiePembelian/V_feedback', $data);
	}

	public function InputFeedbackBuyer()
	{
		$invoice_id = $this->input->post('invoice_id');
		$ambil_data_feedback = $this->M_kasiepembelian->getFeedbackBuyer($invoice_id);

		$data['feedback'] = $ambil_data_feedback;
		$data['invoice'] = $invoice_id;

		$this->load->view('MonitoringInvKasiePembelian/V_feedbackBuyer', $data);
	}

	public function getDataDokumen()
	{
		$invoice_id = $this->input->post('invoice_id');
		$getAllBerkas = $this->M_kasiepembelian->getDokumenBermasalah($invoice_id);
		$feedback = $this->M_kasiepembelian->getFeedback($invoice_id);

		$data['berkas'] = $getAllBerkas;
		$data['invoice'] = $invoice_id;
		$data['feedback'] = $feedback;

		// echo "<pre>";print_r($data['feedback']);exit();

		$this->load->view('MonitoringInvKasiePembelian/V_TabelConfirmation', $data);
	}

	public function getDataReKonfirmasi()
	{
		$invoice_id = $this->input->post('invoice_id');
		$getAllBerkas = $this->M_kasiepembelian->getDokumenRekonfirmasi($invoice_id);

		$data['berkas'] = $getAllBerkas;
		$data['invoice'] = $invoice_id;

		$this->load->view('MonitoringInvKasiePembelian/V_TabelReConfirmation', $data);
	}

	public function KonfirmasiBuyer()
	{
		$invoice_id = $this->input->post('invoice_id');
		$getAllBerkas = $this->M_kasiepembelian->getDokumenBermasalah($invoice_id);
		// $feedback = $this->M_kasiepembelian->getFeedback($invoice_id);

		$data['berkas'] = $getAllBerkas;
		$data['invoice'] = $invoice_id;
		// $data['feedback'] = $feedback;

		$this->load->view('MonitoringInvKasiePembelian/V_TabelConfirmationBuyer', $data);
	}

	public function getDataBuyer()
	{
		$invoice_id = $this->input->post('invoice_id');
		$getDataBuyer = $this->M_kasiepembelian->getBuyer();
		$data_purchasing = $this->M_kasiepembelian->getStatusPurc($invoice_id);
		$cariPo = $this->M_kasiepembelian->getPoandBuyer($invoice_id);
		$po_number = $cariPo[0]['PO_NUMBER'];
		$cariBuyer = $this->M_kasiepembelian->cariBuyerDefault($po_number);

		$data['buyer'] = $getDataBuyer;
		$data['param'] = $data_purchasing;
		$data['default'] = $cariBuyer;

		$this->load->view('MonitoringInvKasiePembelian/V_buyer', $data);
	}

	public function FinishInvBermasalah()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$finish = $this->M_kasiepembelian->finishInvBermasalah();


		$no = 0;
		foreach ($finish as $inv => $value) {

			$invoice_id = $finish[$inv]['INVOICE_ID'];
			
			$po_amount = 0;
			$unit = $this->M_kasiepembelian->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$finish[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_kasiepembelian->po_numberr($invoice_id);
			
			$finish[$inv]['PO_NUMBER'] = '';
			$finish[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$finish[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$finish[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			$no++;
		}
		$data['finish'] =$finish;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_finishInvBermasalah',$data);
		$this->load->view('V_Footer',$data);
	
	}

	public function InvBermasalahBuyerSubkon()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user = $this->session->user;
		$bermasalah = $this->M_kasiepembelian->listInvBermasalahBuyerSubkon();
		$listBuyer = $this->M_kasiepembelian->getBuyer();
		
		$no = 0;
		foreach ($bermasalah as $inv => $value) {

			$invoice_id = $bermasalah[$inv]['INVOICE_ID'];
			
			$po_amount = 0;
			$unit = $this->M_kasiepembelian->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$bermasalah[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_kasiepembelian->po_numberr($invoice_id);
			
			$bermasalah[$inv]['PO_NUMBER'] = '';
			$bermasalah[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$bermasalah[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$bermasalah[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			$no++;
		}
		$data['bermasalah'] =$bermasalah;
		$data['buyer'] = $listBuyer;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_listInvBermasalahBuyerSubkon',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InvBermasalahBuyerSupplier()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user = $this->session->user;
		$bermasalah = $this->M_kasiepembelian->listInvBermasalahBuyerSupplier();
		$listBuyer = $this->M_kasiepembelian->getBuyer();
		
		$no = 0;
		foreach ($bermasalah as $inv => $value) {

			$invoice_id = $bermasalah[$inv]['INVOICE_ID'];
			
			$po_amount = 0;
			$unit = $this->M_kasiepembelian->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$bermasalah[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_kasiepembelian->po_numberr($invoice_id);
			
			$bermasalah[$inv]['PO_NUMBER'] = '';
			$bermasalah[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$bermasalah[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$bermasalah[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			$no++;
		}
		$data['bermasalah'] =$bermasalah;
		$data['buyer'] = $listBuyer;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_listInvBermasalahBuyerSupplier',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InvBermasalahBuyerSistem()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user = $this->session->user;
		$bermasalah = $this->M_kasiepembelian->listInvBermasalahBuyerSistem();
		$listBuyer = $this->M_kasiepembelian->getBuyer();
		
		$no = 0;
		foreach ($bermasalah as $inv => $value) {

			$invoice_id = $bermasalah[$inv]['INVOICE_ID'];
			
			$po_amount = 0;
			$unit = $this->M_kasiepembelian->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$bermasalah[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_kasiepembelian->po_numberr($invoice_id);
			
			$bermasalah[$inv]['PO_NUMBER'] = '';
			$bermasalah[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$bermasalah[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$bermasalah[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			$no++;
		}
		$data['bermasalah'] =$bermasalah;
		$data['buyer'] = $listBuyer;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_listInvBermasalahBuyerSistem',$data);
		$this->load->view('V_Footer',$data);
	}

		public function DetailInvKasie($invoice_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$unprocess2 = $this->M_kasiepembelian->invBermasalah($invoice_id);
		$no = 0;
		foreach ($unprocess2 as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_kasiepembelian->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$unprocess2[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$berkas = $unprocess2[0]['KELENGKAPAN_DOC_INV_BERMASALAH'];
		$exp_berkas = explode(',', $berkas);

		$data['berkas'] = $exp_berkas;
		$data['detail'] =$unprocess2;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_detailInvBermasalah', $data);
		$this->load->view('V_Footer',$data);
	}

	public function DetailInvBuyer($invoice_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$unprocess2 = $this->M_kasiepembelian->invBermasalahBuyer($invoice_id);
		$no = 0;
		foreach ($unprocess2 as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_kasiepembelian->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$unprocess2[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$berkas = $unprocess2[0]['KELENGKAPAN_DOC_INV_BERMASALAH'];

		$exp_berkas = explode(',', $berkas);

		$data['berkas'] = $exp_berkas;
		$data['detail'] =$unprocess2;
	

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_detailInvBermasalahBuyer', $data);
		$this->load->view('V_Footer',$data);
	}

	public function saveInvBermasalah()
	{
		$invoice_id = $this->input->post('invoice_id');
		$action_date = date('d-m-Y H:i:s');
		//array bellow
		$waktu_berkas = $this->input->post('waktu_berkas');
		$doc_id = $this->input->post('doc_id');
		$status_berkas = $this->input->post('status_berkas');
		$imp_status = implode(",", $status_berkas);

		$update = $this->M_kasiepembelian->saveInvBermasalah($invoice_id,$action_date,$imp_status);

		foreach ($status_berkas as $key => $value) {
			$this->M_kasiepembelian->updateTabelBerkas($waktu_berkas[$key],$doc_id[$key],$value,$invoice_id);
		}
	}

	public function saveReconfirmInvBermasalah()
	{
		$invoice_id = $this->input->post('invoice_id');
		$action_date = date('d-m-Y H:i:s');
		//array bellow
		$waktu_berkas = $this->input->post('waktu_berkas');
		$doc_id = $this->input->post('doc_id');
		$status_berkas = $this->input->post('status_berkas');
		$imp_status = implode(",", $status_berkas);

		$update = $this->M_kasiepembelian->saveReconfirmInvBermasalah($invoice_id,$action_date,$imp_status);

		foreach ($status_berkas as $key => $value) {
			$this->M_kasiepembelian->ReupdateTabelBerkas($waktu_berkas[$key],$doc_id[$key],$value,$invoice_id);
		}
	}


	public function saveInvBermasalahBuyer()
	{
		$invoice_id = $this->input->post('invoice_id');
		$action_date = date('d-m-Y H:i:s');
		//array bellow
		$waktu_berkas = $this->input->post('waktu_berkas');
		$doc_id = $this->input->post('doc_id');
		$status_berkas = $this->input->post('status_berkas');
		$imp_status = implode(",", $status_berkas);

		$update = $this->M_kasiepembelian->saveInvBermasalahBuyer($invoice_id,$action_date,$imp_status);

		foreach ($status_berkas as $key => $value) {
			$this->M_kasiepembelian->updateTabelBerkasBuyer($waktu_berkas[$key],$doc_id[$key],$value,$invoice_id);
		}
	}

	public function submitFeedback()
	{
		$invoice_id = $this->input->post('invoice_id');
		$feedback = $this->input->post('feedback');
		$action_date = date('d-m-Y H:i:s');

		$update = $this->M_kasiepembelian->kirimFeedback($invoice_id,$feedback,$action_date);
	}

	public function submitFeedbackBuyer()
	{
		$invoice_id = $this->input->post('invoice_id');
		$feedback = $this->input->post('feedback');
		$action_date = date('d-m-Y H:i:s');

		$update = $this->M_kasiepembelian->kirimFeedbackBuyer($invoice_id,$feedback,$action_date);
	}



	public function invBermasalahKasie()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getStatusSatu = $this->M_kasiepembelian->getStatusSatu();
		
		$bermasalah = $this->M_kasiepembelian->listInvBermasalah();
		$listBuyer = $this->M_kasiepembelian->getBuyer();
		
		$no = 0;
		foreach ($bermasalah as $inv => $value) {

			$invoice_id = $bermasalah[$inv]['INVOICE_ID'];
			
			$po_amount = 0;
			$unit = $this->M_kasiepembelian->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$bermasalah[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_kasiepembelian->po_numberr($invoice_id);
			
			$bermasalah[$inv]['PO_NUMBER'] = '';
			$bermasalah[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$bermasalah[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$bermasalah[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			
			$no++;
		}
		$data['bermasalah'] =$bermasalah;
		$data['buyer'] = $listBuyer;
		$data['status'] = $getStatusSatu;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_listInvBermasalah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function FinishInvBermasalahBuyer()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user = $this->session->user;
		$finish = $this->M_kasiepembelian->finishInvBermasalahBuyer($user);


		$no = 0;
		foreach ($finish as $inv => $value) {

			$invoice_id = $finish[$inv]['INVOICE_ID'];
			
			$po_amount = 0;
			$unit = $this->M_kasiepembelian->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$finish[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_kasiepembelian->po_numberr($invoice_id);
			
			$finish[$inv]['PO_NUMBER'] = '';
			$finish[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$finish[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$finish[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			
			$no++;
		}
		$data['finish'] =$finish;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_finishInvBermasalahBuyer',$data);
		$this->load->view('V_Footer',$data);
	}


	public function invBermasalahBuyer()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user = $this->session->user;
		$bermasalah = $this->M_kasiepembelian->listInvBermasalahBuyer($user);
		$listBuyer = $this->M_kasiepembelian->getBuyer();
		$getStatusSatu = $this->M_kasiepembelian->getStatusBuyer($user);
		
		$no = 0;
		foreach ($bermasalah as $inv => $value) {

			$invoice_id = $bermasalah[$inv]['INVOICE_ID'];
			
			$po_amount = 0;
			$unit = $this->M_kasiepembelian->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$bermasalah[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_kasiepembelian->po_numberr($invoice_id);
			
			$bermasalah[$inv]['PO_NUMBER'] = '';
			$bermasalah[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$bermasalah[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$bermasalah[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			
			
			$no++;
		}
		$data['bermasalah'] =$bermasalah;
		$data['buyer'] = $listBuyer;
		$data['status'] = $getStatusSatu;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvKasiePembelian/V_listInvBermasalahBuyer',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
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
		// $this->output->cache(1);
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
				if ($getStatus) {
					$statuslama  = $getStatus[0]['PURCHASING_STATUS'];
				}else{
					$statuslama = '';
				}
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
			$this->M_kasiepembelian->approvedbykasiepurchasing($expid[$key],$approved,$saveDate);
			$this->M_kasiepembelian->inputstatuspurchasing($expid[$key],$saveDate,$approved);
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

		$amount = preg_replace("/[^0-9]/" , "", $invoice_amount );
		$str_amount = substr($amount, 0, -2);
		$pajak = preg_replace("/[^0-9]/" , "", $nominal_dpp );
		$str_pajak = substr($pajak, 0, -2);

		$this->M_kasiepembelian->approveInvoice($invoice_id,$status,$saveDate);
		$this->M_kasiepembelian->editInvoiceKasiePurc($invoice_id,$invoice_number,$invoice_date,$str_amount,$tax_invoice_number,$info,$str_pajak,$invoice_category,$jenis_jasa);
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

		$amount = preg_replace("/[^0-9]/" , "", $invoice_amount );
		$str_amount = substr($amount, 0, -2);
		$pajak = preg_replace("/[^0-9]/" , "", $nominal_dpp );
		$str_pajak = substr($pajak, 0, -2);

		$this->M_kasiepembelian->editInvoiceKasiePurc($invoice_id,$invoice_number,$invoice_date,$str_amount,$tax_invoice_number,$info,$str_pajak,$invoice_category,$jenis_jasa);
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
		foreach ($batch as $bl => $value) {
			$invoice_id = $value['INVOICE_ID'] ;
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

	public function approveInvoiceNew(){
		$invoice_id = $this->input->post('mi-check-list[]');
		$saveDate = date('d-m-Y H:i:s');

		// echo "<pre>";
		// print_r($invoice_id);
		// exit();
	}
		// $this->M_kasiepembelian->approveInvoice($invoice_id,$status,$saveDate);
		// $this->M_kasiepembelian->inputstatuspurchasing($invoice_id,$saveDate,$status);

	public function approveInvoice2(){
		$saveDate = date('d-m-Y H:i:s');
		$invoice_id = $this->input->post('invoice_id');
		$status = $this->input->post('status');

		$this->M_kasiepembelian->approveInvoice($invoice_id,$status,$saveDate);

	}

	public function showReturnedfromAkuntansi()
	{
		$invoice_id = $this->input->post('invoice_id');
		$show = $this->M_kasiepembelian->showInv($invoice_id);
		$data['show'] = $show;
		return $this->load->view('MonitoringInvKasiePembelian/V_returnedForm', $data);
	}

		public function showModalReturnBuyer()
	{
		$invoice_id = $this->input->post('invoice_id');
		$show = $this->M_kasiepembelian->showInvBuyer($invoice_id);
		$data['show'] = $show;
		return $this->load->view('MonitoringInvKasiePembelian/V_returnedFormBuyer', $data);
	}

	public function returnToAkuntansi()
	{
		$invoice_id = $this->input->post('invoice_id');
		$note = $this->input->post('note_return_purchasing');
		$action_date = date('d-m-Y H:i:s');
		$this->M_kasiepembelian->returnToAkuntansi($invoice_id, $action_date, $note);
	}

	public function returnToAkuntansiBuyer()
	{
		$invoice_id = $this->input->post('invoice_id');
		$note = $this->input->post('note_return_buyer');
		$action_date = date('d-m-Y H:i:s');
		$this->M_kasiepembelian->returnToAkuntansiBuyer($invoice_id, $action_date, $note);
	}



}
?>