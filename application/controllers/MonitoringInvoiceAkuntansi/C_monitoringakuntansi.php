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

		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringakuntansi->checkLoginInAkuntansi($noinduk);
		$source_login = '';

		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' OR $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN') {
			$source_login .= "AND source = 'PEMBELIAN SUPPLIER' OR source = 'PENGEMBANGAN PEMBELIAN'";
		}elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR'){
			$source_login .= "AND source = 'PEMBELIAN SUBKONTRAKTOR'";
		}elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login .= "AND source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
		}

		$listBatch = $this->M_monitoringakuntansi->showFinanceNumber($source_login);
		foreach($listBatch as $key => $value){
			$batchNumber = $value['BATCH_NUMBER'];
			$jmlInv = $this->M_monitoringakuntansi->jumlahInvoice($batchNumber);
			$listBatch[$key]['jml_invoice'] = $jmlInv[0]['JUMLAH_INVOICE'].' Invoice';
		}
		$data['batch'] = $listBatch;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_akuntansi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function unprocess($batchNumber)
	{	$batchNumber = str_replace('%20', ' ', $batchNumber);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$unprocess = $this->M_monitoringakuntansi->unprocessedInvoice($batchNumber);
		
		if ($unprocess != null) {
			$batch = $unprocess[0]['BATCH_NUMBER'];
		} else {
			$batch = '';
		}

		$no = 0;
		foreach ($unprocess as $inv ) {

			$invoice_id = $inv['INVOICE_ID'];
			$string_id = $inv['PO_DETAIL'];
			
			$po_amount = 0;
			$unit = $this->M_monitoringakuntansi->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$unprocess[$no]['PO_AMOUNT'] = $po_amount;

			if ($string_id) {
				$explodeId = explode('<br>', $string_id);
				if (!$explodeId) {
					$explodeId = $string_id;
				}

				foreach ($explodeId as $exp => $value) {
					$cekPPN = $this->M_monitoringakuntansi->checkPPN($value);
					foreach ($cekPPN as $key => $value2) {
						foreach ($value2 as $va2 => $value3) {
							$ppn = $value3;
						}
					}
				}
			}
			
			$no++;
		}

		$data['unprocess'] =$unprocess;
		$data['batch_num'] =$batch;
		$data['ppn'] = $ppn;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_unprocessakuntansi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function DetailUnprocess($batch_num,$invoice_id)
	{	$batch_num = str_replace('%20', ' ', $batch_num);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$unprocess = $this->M_monitoringakuntansi->DetailUnprocess($batch_num,$invoice_id);
		$batch = $unprocess[0]['BATCH_NUMBER'];
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
		$saveDate = date('d-m-Y H:i:s');

		$this->M_monitoringakuntansi->saveProses($proses,$saveDate,$id);
		$this->M_monitoringakuntansi->insertproses($id,$saveDate,$proses);

	}

	public function finishInvoice($batchNumber){
		$batchNumber = str_replace('%20', ' ', $batchNumber);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$finish = $this->M_monitoringakuntansi->processedInvoice($batchNumber);

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

	public function saveReasonAkuntansi(){
		$alasan = $this->input->post('reason_finance[]');
		$id = $this->input->post('id_reason[]');

		for ($i=0; $i < count($id); $i++) { 
			echo $id[$i]."<br>".$alasan[$i]."<br><br>";
			$this->M_monitoringakuntansi->reason_finance($id[$i],$alasan[$i]);
		}

		redirect('AccountPayables/MonitoringInvoice/Finish');
	}

	public function finishBatchInvoice(){

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringakuntansi->checkLoginInAkuntansi($noinduk);
		$source_login = '';

		if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' OR $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN') {
			$source_login .= "AND source = 'PEMBELIAN SUPPLIER' OR source = 'PENGEMBANGAN PEMBELIAN'";
		}elseif ($cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR'){
			$source_login .= "AND source = 'PEMBELIAN SUBKONTRAKTOR'";
		}elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login .= "AND source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
		}

		$listBatch = $this->M_monitoringakuntansi->showFinishBatch($source_login);

		foreach($listBatch as $key => $lb){
			$detail = $this->M_monitoringakuntansi->detailBatch($lb['BATCH_NUMBER']);
			$listBatch[$key]['approved'] = 'Approve : '.$detail[0]['APPROVE'].' Invoice';
		}
		$data['batch'] = $listBatch;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_finishBatchAkt',$data);
		$this->load->view('V_Footer',$data);
	}

}