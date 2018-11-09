<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_monitoringakuntansi extends CI_Controller{

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
		$this->load->model('MonitoringInvoiceAkuntansi/M_monitoringakuntansi');
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

		$listBatch = $this->M_monitoringakuntansi->showListSubmittedForChecking();
		$no = 0;
		foreach($listBatch as $lb){
			$jmlInv = $this->M_monitoringakuntansi->getJmlInvPerBatch($lb['BATCH_NUM']);
			echo $lb['BATCH_NUM'];

			$listBatch[$no]['JML_INVOICE'] = $jmlInv.' Invoice';
			$no++;
		}
		$data['batch'] = $listBatch;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_akuntansi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function unprocess($batchNumber)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$unprocess = $this->M_monitoringakuntansi->unprocessedInvoice($batchNumber);

		if ($unprocess != null) {
			$batch = $unprocess[0]['BATCH_NUM'];
		} else {
			$batch = '';
		}
		

		$no = 0;
		foreach ($unprocess as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$unprocess[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$data['unprocess'] =$unprocess;
		$data['batch_num'] =$batch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_unprocessakuntansi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function DetailUnprocess($batch_num,$invoice_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$unprocess = $this->M_monitoringakuntansi->DetailUnprocess($batch_num,$invoice_id);
		$batch = $unprocess[0]['BATCH_NUM'];
		$no = 0;
		foreach ($unprocess as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$unprocess[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$data['detail'] =$unprocess;
		$data['batch_num'] =$batch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_detailunprocess',$data);
		$this->load->view('V_Footer',$data);
	}

	public function prosesAkuntansi($id){
		$proses = $this->input->post('proses');
		$saveDate = date('d-m-Y H:i:s', strtotime('+6 hours'));

		$this->M_monitoringakuntansi->saveProses($proses,$saveDate,$id);
		$this->M_monitoringakuntansi->saveProses2($id,$proses,$saveDate);

	}

	public function finishInvoice(){

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$finish = $this->M_monitoringakuntansi->processedInvoice();

		$no = 0;
		foreach ($finish as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$finish[$no]['PO_AMOUNT'] = $hasil;

			$no++;

		}
		$data['finish'] =$finish;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_finishinvoiceakuntansi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function DetailProcessed($invoice_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$processed = $this->M_monitoringakuntansi->DetailProcess($invoice_id);

		$no = 0;
		foreach ($processed as $key ) {
			$invoice = $key['INVOICE_ID'];
			

			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$processed[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$data['processed'] =$processed;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_processed',$data);
		$this->load->view('V_Footer',$data);
	}

}