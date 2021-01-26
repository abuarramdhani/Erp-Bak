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
		// exit;

		$data['organization'] = $this->M_monitoringakuntansi->get_org_list();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_akuntansi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ambilAlert()
	{
		$getStatusSatu = $this->M_monitoringakuntansi->getStatusSatu();
		// $status = $getStatusSatu[0]['SATU'];

		echo json_encode($getStatusSatu);
	}

	public function EndStatus()
	{
		$invoice_id = $this->input->post('invoice_id');
		$end_date = date('d-m-Y H:i:s');
		$endInvoice = $this->M_monitoringakuntansi->EndInvoiceBermasalah($invoice_id,$end_date);
	}

	public function getHasilKonfirmasi()
	{
		$invoice_id = $this->input->post('invoice_id');
		$getDataConfimation = $this->M_monitoringakuntansi->getHasilKonfirmasi($invoice_id);
		$data['berkas'] = $getDataConfimation;

		$this->load->view('MonitoringInvoiceAkuntansi/V_hasilCeklist', $data);
	}

	public function getDataReKonfirmasi()
	{
		$invoice_id = $this->input->post('invoice_id');
		$getAllBerkas = $this->M_monitoringakuntansi->getDokumenRekonfirmasi($invoice_id);

		$data['berkas'] = $getAllBerkas;
		$data['invoice'] = $invoice_id;

		$this->load->view('MonitoringInvoiceAkuntansi/V_tabelReConfirmationAkt', $data);
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

		$update = $this->M_monitoringakuntansi->saveReconfirmInvBermasalah($invoice_id,$action_date,$imp_status);

		foreach ($status_berkas as $key => $value) {
			$this->M_monitoringakuntansi->ReupdateTabelBerkas($waktu_berkas[$key],$doc_id[$key],$value,$invoice_id);
		}
	}


	public function SaveEdit($invoice_id)
	{
		

		$invoice_number = $this->input->post('invoice_number');//**
		$invoice_date = $this->input->post('invoice_date');//**
		$invoice_amount = $this->input->post('invoice_amount');//**
		$tax_invoice_number = $this->input->post('tax_invoice_number');//
		$vendor_number = $this->input->post('vendor_number');//**
		$cariNamaVendor = $this->M_monitoringakuntansi->getNamaVendor($vendor_number);
		$vendor_name = $cariNamaVendor[0]['VENDOR_NAME'];
		$po_number = $this->input->post('txtNoPO');//**
		$top = $this->input->post('txtToP');//**
		$last_admin_date = date('d-m-Y H:i:s');
		$action_date = date('d-m-Y H:i:s');
		$note_admin = $this->input->post('note_admin');//**
		$invoice_category = $this->input->post('invoice_category');//**
		
		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringakuntansi->checkLoginInAkuntansi($noinduk);
		if ($cek_login[0]['unit_name'] == 'AKUNTANSI') {
			$source_login = 'AKUNTANSI';
		} elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login = 'INFORMATION & COMMUNICATION TECHNOLOGY';
		}
	
		$amount1 = str_replace('.', '', $invoice_amount);
		$amount2 =  str_replace('00-', '', $amount1);//478636
		$amount3 = str_replace('Rp', '', $amount2);
		$amount = str_replace(',', '', $amount3);
	
		$add2['invoice'] = $this->M_monitoringakuntansi->UpdatePoNumber2($invoice_id,$invoice_number, $invoice_date, $amount, $tax_invoice_number,$vendor_name,$vendor_number,$last_admin_date,$note_admin,$invoice_category,$source_login,$top);
		
		$this->M_monitoringakuntansi->UpdatePoNumber($po_number,$invoice_id);
		 
		$this->M_monitoringakuntansi->UpdatePoNumber3($invoice_id,$action_date);
		redirect('AccountPayables/MonitoringInvoice/FinishInvoiceAkt');
	}

	public function newInvoiceAkt()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$invNumber = $this->input->post('slcPoNumberInv');
		$query = $this->M_monitoringakuntansi->getInvNumber($invNumber);
		
		$data['invoice'] = $query;
		$data['allVendor'] = $this->M_monitoringakuntansi->getVendorName();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_addInvoiceAkt',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cariVendorandTerm()
	{
		$nomor_po = $this->input->post('nomor_po');
		$cariData = $this->M_monitoringakuntansi->tarikDataPo($nomor_po);

		echo json_encode($cariData);

	}

	public function resetInvoice()
	{
		$invoice_id = $this->input->post('invoice_id');
		$this->M_monitoringakuntansi->resetInvoiceBermasalah($invoice_id);
	}

	public function newInvBermasalah()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$invNumber = $this->input->post('slcPoNumberInv');
		$query = $this->M_monitoringakuntansi->getInvNumber($invNumber);
		$data['invoice'] = $query;
		$data['allVendor'] = $this->M_monitoringakuntansi->getVendorName();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_addInvoiceBermasalah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function saveInvBermasalah($invoice_id)
	{
		$lainnya = $this->input->post('txtLainLain');

		$kategori = $this->input->post('slcKategori[]');
		if (in_array('LainLain', $kategori)) {
		$imp_kategori_calon = implode(', ', $kategori);
		$imp_kategori = str_replace('LainLain', $lainnya, $imp_kategori_calon);
		}else{
		$imp_kategori = implode(', ', $kategori);	
		}

		$dokumen = $this->input->post('slcKelengkapanDokumen[]');
		$lainnya_doc = $this->input->post('txtDokumenLain');
		if (in_array('DokumenLain', $dokumen)) {
		$imp_dokumen_calon = implode(', ', $dokumen);
		$imp_dokumen = str_replace('DokumenLain', $lainnya_doc, $imp_dokumen_calon);
		}else{
		$imp_dokumen = implode(', ', $dokumen);	
		}

		if (in_array('DokumenLain', $dokumen)) {
		$k = array_search('DokumenLain', $dokumen);
		$replacement = array($k => $lainnya_doc);
		$dokumen_baru = array_replace($dokumen, $replacement);
		}else{
		$dokumen_baru = $dokumen;
		}

		
		$keterangan = $this->input->post('txaKeterangan');
		$action_date = date('d-m-Y H:i:s');

		$update = $this->M_monitoringakuntansi->saveInvBermasalah($imp_kategori,$imp_dokumen,$keterangan,$invoice_id,$action_date);
		
		foreach ($dokumen_baru as $key => $value) {
			$this->M_monitoringakuntansi->saveTableDokumen($invoice_id,$value,$action_date);
		}

		redirect('AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt');

	}

	public function finishInvBermasalah()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$finish = $this->M_monitoringakuntansi->finishInvBermasalah();


		$no = 0;
		foreach ($finish as $inv => $value) {

			$invoice_id = $finish[$inv]['INVOICE_ID'];
			
			$po_amount = 0;
			$unit = $this->M_monitoringakuntansi->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$finish[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_monitoringakuntansi->po_numberr($invoice_id);
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
		$this->load->view('MonitoringInvoiceAkuntansi/V_finishInvBermasalah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function DetailInvBermasalah($invoice_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$unprocess2 = $this->M_monitoringakuntansi->invBermasalah($invoice_id);
		$no = 0;
		foreach ($unprocess2 as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$unprocess2[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$data['detail'] =$unprocess2;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_detailInvBermasalah', $data);
		$this->load->view('V_Footer',$data);
	}

	public function DetailFinishInvBermasalah($invoice_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$unprocess2 = $this->M_monitoringakuntansi->invBermasalahFinish($invoice_id);
		$no = 0;
		foreach ($unprocess2 as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$unprocess2[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$data['detail'] =$unprocess2;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_detailFinishInvBermasalah', $data);
		$this->load->view('V_Footer',$data);
	}

	public function EditInvoice($invoice_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$editInvoice = $this->M_monitoringakuntansi->editInvData($invoice_id);
		$data['allVendor'] = $this->M_monitoringakuntansi->getVendorName();

		$no = 0;
		foreach ($editInvoice as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$editInvoice[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$data['detail'] =$editInvoice;

				
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_editInvoiceAkt', $data);
		$this->load->view('V_Footer',$data);

	}

	public function invBermasalah($invoice_id)
	{

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		
		$unprocess2 = $this->M_monitoringakuntansi->invBermasalahChecking($invoice_id);

		$no = 0;
		foreach ($unprocess2 as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$unprocess2[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$data['detail'] =$unprocess2;

			if (!empty($data['detail'])) {
				
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringInvoiceAkuntansi/V_laporInvoice', $data);
			$this->load->view('V_Footer',$data);
			}else{
			redirect('AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/newInvBermasalah');
			echo "<script type='text/javascript'> alert('Maaf, invoice tidak bisa dijadikan invoice bermasalah')</script>";
			}

	}

	public function addInvBermasalah()
	{
		$invoice_number = $this->input->post('invoice_number');//
		$invoice_date = $this->input->post('invoice_date');//
		$invoice_amount = $this->input->post('invoice_amount');//
		$vendor_number = $this->input->post('vendor_number');
		$cariNamaVendor = $this->M_monitoringakuntansi->getNamaVendor($vendor_number);
		$vendor_name = $cariNamaVendor[0]['VENDOR_NAME'];
		$po_number = $this->input->post('txtNoPO');//
		$top = $this->input->post('txtToP');//
		$last_admin_date = date('d-m-Y H:i:s');
		$action_date = date('d-m-Y H:i:s');
		$note_admin = $this->input->post('note_admin');//
		$invoice_category = $this->input->post('invoice_category');
		$jenis_jasa = $this->input->post('jenis_jasa');//

		$kategori = $this->input->post('slcKategori[]');
		$lainnya = $this->input->post('txtLainLain');
		if (in_array('LainLain', $kategori)) {
		$imp_kategori_calon = implode(', ', $kategori);
		$imp_kategori = str_replace('LainLain', $lainnya, $imp_kategori_calon);
		}else{
		$imp_kategori = implode(', ', $kategori);	
		}

		$dokumen = $this->input->post('slcKelengkapanDokumen[]');
		$lainnya_doc = $this->input->post('txtDokumenLain');
		if (in_array('DokumenLain', $dokumen)) {
		$imp_dokumen_calon = implode(', ', $dokumen);
		$imp_dokumen = str_replace('DokumenLain', $lainnya_doc, $imp_dokumen_calon);
		}else{
		$imp_dokumen = implode(', ', $dokumen);	
		}

		if (in_array('DokumenLain', $dokumen)) {
		$k = array_search('DokumenLain', $dokumen);
		$replacement = array($k => $lainnya_doc);
		$dokumen_baru = array_replace($dokumen, $replacement);
		}else{
		$dokumen_baru = $dokumen;
		}

		// echo"<pre>";echo $imp_dokumen;print_r($_POST);exit();

		$keterangan = $this->input->post('txaKeterangan');
		$noinduk = $this->session->userdata['user'];
		$cek_login = $this->M_monitoringakuntansi->checkLoginInAkuntansi($noinduk);
		if ($cek_login[0]['unit_name'] == 'AKUNTANSI') {
			$source_login = 'AKUNTANSI';
		} elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login = 'INFORMATION & COMMUNICATION TECHNOLOGY';
		}
		// tentang separator
		$amount = str_replace(',', '', $invoice_amount); //478636
		$add2['invoice'] = $this->M_monitoringakuntansi->saveInvBermasalah2($invoice_number, $invoice_date, $amount,$vendor_name,$vendor_number,$last_admin_date,$invoice_category,$source_login,$jenis_jasa,$top,$imp_kategori,$imp_dokumen,$keterangan,$action_date);
		
		$this->M_monitoringakuntansi->savePoNumber($po_number,$add2['invoice'][0]['INVOICE_ID']);
		 
		$this->M_monitoringakuntansi->savePoNumber3($add2['invoice'][0]['INVOICE_ID'],$action_date);

		foreach ($dokumen_baru as $key => $value) {
			$this->M_monitoringakuntansi->saveTableDokumen($add2['invoice'][0]['INVOICE_ID'],$value,$action_date);
		}
		//----------------------------------------------- gak bikin batch----------------------------------------------------//

		redirect('AccountPayables/MonitoringInvoice/InvoiceBermasalahAkt/');
	}



	public function addPoNumberAkt()
	{
		// echo "<pre>";print_r($_POST);
		$invoice_number = $this->input->post('invoice_number');//00
		$invoice_date = $this->input->post('invoice_date');//00
		$invoice_amount = $this->input->post('invoice_amount');//00
		$tax_invoice_number = $this->input->post('tax_invoice_number');//00
		$vendor_number = $this->input->post('vendor_number');//00
		$cariNamaVendor = $this->M_monitoringakuntansi->getNamaVendor($vendor_number);//00
		$vendor_name = $cariNamaVendor[0]['VENDOR_NAME'];//00
		$po_number = $this->input->post('txtNoPO');//00
		$top = $this->input->post('txtToP');//00
		$last_admin_date = date('d-m-Y H:i:s');//00
		$action_date = date('d-m-Y H:i:s');//00
		$note_admin = $this->input->post('note_admin');//00
		$invoice_category = $this->input->post('invoice_category');//00
		$jenis_dokumen = $this->input->post('jenis_dokumen');//00
		
		// ini fungsi login, hak ases
		$noinduk = $this->session->userdata['user'];
		// echo $noinduk;exit();
		$cek_login = $this->M_monitoringakuntansi->checkLoginInAkuntansi($noinduk);
		if ($cek_login[0]['unit_name'] == 'AKUNTANSI') {
			$source_login = 'AKUNTANSI';
		} elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			$source_login = 'INFORMATION & COMMUNICATION TECHNOLOGY';
		}
		
		$amount = str_replace(',', '', $invoice_amount); //478636
		
		$add2['invoice'] = $this->M_monitoringakuntansi->savePoNumber2($invoice_number, $invoice_date, $amount, $tax_invoice_number,$vendor_name,$vendor_number,$last_admin_date,$note_admin,$invoice_category,$source_login,$top,$jenis_dokumen);
		
		// foreach ($po_number as $key => $value) {
		$this->M_monitoringakuntansi->savePoNumber($po_number,$add2['invoice'][0]['INVOICE_ID']);
		 
		// }
		$this->M_monitoringakuntansi->savePoNumber3($add2['invoice'][0]['INVOICE_ID'],$action_date);
		// -----------------------------------------------bikin batch----------------------------------------------------//
		$saveDate = date('d-m-Y H:i:s');
		$date = strtoupper(date('dMY'));
		$status_akt = 2;
		$BatchNumberNew = $this->M_monitoringakuntansi->checkBatchNumbercount('AKT'.'-'.$invoice_category.'-'.$date);
		$cek_judul_batch = $this->M_monitoringakuntansi->checkLoginInAkuntansi($noinduk);
		if ($cek_judul_batch[0]['unit_name'] == 'AKUNTANSI') {
			if ($BatchNumberNew) {
				$batch_number = 'AKT'.'-'.$invoice_category.'-'.$date.'-'.count($BatchNumberNew);
			}else{
				$batch_number = 'AKT'.'-'.$invoice_category.'-'.$date;
			}
		} elseif ($cek_judul_batch[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
			if ($BatchNumberNew) {
				$batch_number = 'ICT'.'-'.$invoice_category.'-'.$date.'-'.count($BatchNumberNew);
			}else{
				$batch_number = 'ICT'.'-'.$invoice_category.'-'.$date;
			}
		} else{
			if($this->form_validation->run() == FALSE){
			  echo '<script> alert("'.str_replace(array('\r','\n'), '\n', validation_errors()).'"); </script>';
			  redirect('AccountPayables/MonitoringInvoice/Invoice');
			}
		}

		$inv = $add2['invoice'][0]['INVOICE_ID'];
	
			$this->M_monitoringakuntansi->saveBatchNumberById($inv,$batch_number,$saveDate,$status_akt);//STATUS ISINYA 1
			$this->M_monitoringakuntansi->saveBatchNumberById2($inv,$saveDate,$status_akt);
		

		redirect('AccountPayables/MonitoringInvoice/NewInvoice');
	}

	// public function invoiceBermasalahAkt()
	// {
	// 	$this->checkSession();
	// 	$user_id = $this->session->userid;
		
	// 	$data['Menu'] = 'Dashboard';
	// 	$data['SubMenuOne'] = '';
		
	// 	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	// 	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	// 	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	// 	$data['allVendor'] = $this->M_monitoringakuntansi->getVendorName();

	// 	$this->load->view('V_Header',$data);
	// 	$this->load->view('V_Sidemenu',$data);
	// 	$this->load->view('MonitoringInvoiceAkuntansi/V_invoiceBermasalah',$data);
	// 	$this->load->view('V_Footer',$data);
	// }

	public function LaporInvoice()
	{
		$invoice_number = $this->input->post('invoice_number');
		$saveDate = date('d-m-Y H:i:s');

		$laporkanInvoice = $this->M_monitoringakuntansi->InvoiceBermasalah($invoice_number,$saveDate);


	}

	public function listInvBermasalah()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$bermasalah = $this->M_monitoringakuntansi->listInvBermasalah();
		$getStatusSatu = $this->M_monitoringakuntansi->getStatusSatu();
		
		
		$no = 0;
		foreach ($bermasalah as $inv => $value) {

			$invoice_id = $bermasalah[$inv]['INVOICE_ID'];
		
			
			$po_amount = 0;
			$unit = $this->M_monitoringakuntansi->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$bermasalah[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_monitoringakuntansi->po_numberr($invoice_id);
			
			$bermasalah[$inv]['PO_NUMBER'] = '';
			$bermasalah[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$bermasalah[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$bermasalah[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			
			
			$no++;
		}
		$data['bermasalah'] =$bermasalah;
		$data['status'] = $getStatusSatu;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_listInvBermasalah',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function finishKhususAkt()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getData = $this->M_monitoringakuntansi->finishAktNew();

		$no = 0;
		foreach ($getData as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$getData[$no]['PO_AMOUNT'] = $hasil;

			$no++;

		}

		$data['akt2'] = $getData;

		// echo "<pre>"; print_r($data['akt2']); exit();
		// echo "<pre>";print_r($_POST);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_finishKhususAkuntansi',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
	}

	public function bukaModalAkutansi($batchNumber)
	{
		$batchNumber = str_replace('%20', ' ', $batchNumber);
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$tarikDataDetail = $this->M_monitoringakuntansi->detailInvoiceAkt($batchNumber);
				$no = 0;
		foreach ($tarikDataDetail as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$tarikDataDetail[$no]['PO_AMOUNT'] = $hasil;

			$no++;

		}
		// $data['finish'] =$finish;
		$data['akt2'] = $tarikDataDetail;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_modalDetailAkt',$data);
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
		foreach ($unprocess as $inv => $value) {

			$invoice_id = $unprocess[$inv]['INVOICE_ID'];
			// $string_id = $inv['PO_DETAIL'];
			// echo "<pre>";
			// print_r($unprocess);
			// print_r($invoice_id);
			
			$po_amount = 0;
			$unit = $this->M_monitoringakuntansi->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$unprocess[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_monitoringakuntansi->po_numberr($invoice_id);
			// echo"<pre>";
			// print_r($po_numberr);
			$unprocess[$inv]['PO_NUMBER'] = '';
			$unprocess[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$unprocess[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$unprocess[$inv]['PPN'] .= $value['PPN'].'<br>';
			}

			// if ($string_id) {
			// 	$explodeId = explode('<br>', $string_id);
			// 	if (!$explodeId) {
			// 		$explodeId = $string_id;
			// 	}

			// 	// foreach ($explodeId as $exp => $value) {
			// 	// 	$cekPPN = $this->M_monitoringakuntansi->checkPPN($value);
			// 	// 	foreach ($cekPPN as $key => $value2) {
			// 	// 		foreach ($value2 as $va2 => $value3) {
			// 	// 			$ppn = $value3;
			// 	// 		}
			// 	// 	}
			// 	// }
			// }
			
			$no++;
		}
		$data['unprocess'] =$unprocess;
		$data['batch_num'] =$batch;
		// $data['ppn'] = $ppn;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_unprocessakuntansi',$data);
		$this->load->view('V_Footer',$data);
		// $this->output->cache(1);
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
		// $this->output->cache(1);
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
		// $this->output->cache(1);
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
		// $this->output->cache(1);
	}

	public function saveActionAkuntansi(){
		$alasan = $this->input->post('reason_finance');
		// $id = $this->input->post('id_reason[]');
		$prosesTerima = $this->input->post('hdnTerima');
		$prosesTolak = $this->input->post('hdnTolak');
		$saveDate = date('d-m-Y H:i:s');

		// echo "<pre>"; print_r($_POST);

		// if ($prosesTerima=='') {
		// 	$prosesTerima=array();
		// }

		// if ($prosesTolak=='') {
		// 	$prosesTolak=array();
		// }

			foreach ($prosesTerima as $p => $value) {
				$this->M_monitoringakuntansi->saveProsesTerimaAkuntansi($saveDate,$value);
				$this->M_monitoringakuntansi->insertprosesAkuntansiTerima($value,$saveDate);
			}
			foreach ($prosesTolak as $p => $value) {
				$this->M_monitoringakuntansi->saveProsesTolakAkuntansi($saveDate,$value,$alasan[$p]);
				$this->M_monitoringakuntansi->insertprosesAkuntansiTolak($value,$saveDate);
			}


		redirect('AccountPayables/MonitoringInvoice/Unprocess/');
		// exit();
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
		// }elseif ($cek_login[0]['unit_name'] == 'AKUNTANSI'){
		// 	$source_login .= "AND source = 'AKUNTANSI'";
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
		// $this->output->cache(1);
	}

	public function EditInvBermasalah($invoice_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$unprocess2 = $this->M_monitoringakuntansi->invBermasalahSuperEdit($invoice_id);
		$po_number = $unprocess2[0]['PO_NUMBER'];
		$no = 0;
		foreach ($unprocess2 as $key ) {
			$invoice = $key['INVOICE_ID'];
			
			$hasil = 0;
			$poAmount = $this->M_monitoringakuntansi->poAmount($invoice);
			foreach ($poAmount as $p) {
				$total = $p['UNIT_PRICE'] * $p['QTY_INVOICE'];
				$hasil = $hasil + $total;
			}
			$unprocess2[$no]['PO_AMOUNT'] = $hasil;

			$no++;
		}
		$data['detail'] =$unprocess2;
		$data['cari'] = $this->M_monitoringakuntansi->tarikDataPo($po_number);

		
		// $invNumber = $this->input->post('slcPoNumberInv');
		// $query = $this->M_monitoringakuntansi->getInvNumber($invNumber);
		// $data['invoice'] = $query;
		$data['allVendor'] = $this->M_monitoringakuntansi->getVendorName();
		// echo "<pre>";print_r($data['allVendor']);exit();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_editInvoiceBermasalah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function updatePONumberBermasalah()
	{
		$invoice_id = $this->input->post('invoice_id');
		$nomor_po = $this->input->post('nomor_po');
		$vendor_id = $this->input->post('vendor_id');
		$cariNama = $this->M_monitoringakuntansi->namaVendor($vendor_id);
		$vendor_name = $cariNama[0]['VENDOR_NAME'];
		$top = $this->input->post('top');
		$ppn = $this->input->post('ppn');

		$update = $this->M_monitoringakuntansi->getUpdatePONumber($invoice_id,$nomor_po,$vendor_id,$vendor_name,$top,$ppn);
	}

	public function returnedInvoice()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$bermasalah = $this->M_monitoringakuntansi->listInvReturned();
		$getStatusEnam = $this->M_monitoringakuntansi->getStatusEnam();
		
		$no = 0;
		foreach ($bermasalah as $inv => $value) {

			$invoice_id = $bermasalah[$inv]['INVOICE_ID'];
		
			
			$po_amount = 0;
			$unit = $this->M_monitoringakuntansi->poAmount($invoice_id);

			foreach ($unit as $price) {
				$total = $price['UNIT_PRICE'] * $price['QTY_INVOICE'];
				$po_amount = $po_amount + $total;
				
			} 

			$bermasalah[$no]['PO_AMOUNT'] = $po_amount;

			$po_numberr = $this->M_monitoringakuntansi->po_numberr($invoice_id);
			
			$bermasalah[$inv]['PO_NUMBER'] = '';
			$bermasalah[$inv]['PPN'] = '';
			foreach ($po_numberr as $key => $value) {
				$bermasalah[$inv]['PO_NUMBER'] .= $value['PO_NUMBER'].'<br>';
				$bermasalah[$inv]['PPN'] .= $value['PPN'].'<br>';
			}
			
			$no++;
		}
		$data['bermasalah'] =$bermasalah;
		$data['status'] = $getStatusEnam;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringInvoiceAkuntansi/V_returnedInvoice',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ambilAlertEnam()
	{
		$getStatusSatu = $this->M_monitoringakuntansi->getStatusEnam();
		// $status = $getStatusSatu[0]['ENAM'];

		echo json_encode($getStatusSatu);
	}

	public function Returning()
	{
		$invoice_id = $this->input->post('invoice_id');
		$action_date = date('d-m-Y H:i:s');
		$note = $this->input->post('note_purchasing');
		$dokumen = $this->input->post('dokumen_returned');
		$dokumen_baru = $dokumen[0];
		$imp_dokumen = implode(', ', $dokumen_baru);
		// echo "<pre>";echo $imp_dokumen;exit();

		$this->M_monitoringakuntansi->returning($invoice_id,$action_date,$note,$imp_dokumen);
	}

	public function openModalReturned()
	{
		$invoice_id = $this->input->post('invoice_id');
		$returned = $this->M_monitoringakuntansi->getReturnedData($invoice_id);
		$data['returned'] = $returned;
		$this->load->view('MonitoringInvoiceAkuntansi/V_mdlReturnedInvoice',$data);
	}

	public function Receipt()
	{
		$invoice_number = $_POST['invoice_number'];

		$getInvoice = $this->M_monitoringakuntansi->getInvoice($invoice_number);

		$invoice_id = $getInvoice[0]['INVOICE_ID'];

		$nextval = $this->M_monitoringakuntansi->receiptNexval();

		$p_group_id = $nextval[0]['NEXTVAL'];

		$this->M_monitoringakuntansi->receipt_po_invoice($invoice_id, $p_group_id);

		$this->M_monitoringakuntansi->run_fnd_receiving($p_group_id);

		echo 1;
	}
	
	public function get_report(){
		$id = $_POST['organization_id'];
		$from = $_POST['receipt_from'];
		$to = $_POST['receipt_to'];
		
		$data = $this->M_monitoringakuntansi->getdataReport($id, $from, $to);

		$this->load->library('Excel');

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
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
          )
				);
		
		// excel header
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'KHS Laporan Monitoring Receipt');
		$objPHPExcel->getActiveSheet()->mergeCells('A1:F2');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// excel body
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'No');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'Supplier');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'PO Number');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'Receipt Number');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'Receipt Date');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'Login');

		$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		$no = 1;
		$col = 4;

		foreach ($data as $key => $dt) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$col, $no);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$col, $dt['SUPPLIER']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$col, $dt['PO']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$col, $dt['RECEIPT_NUMBER']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$col, $dt['RECEIPT_DATE']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$col, $dt['LOGIN']);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$col)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$col)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$col)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$col)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$col)->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$col)->applyFromArray($style_row);

			$no++;
			$col++;
		}

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($col+2), 'Penerima :');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($col+3), 'Tgl. Diterima :');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($col+4), 'TTD :');

		for ($i=0; $i < 3; $i++) { 
			$objPHPExcel->getActiveSheet()->getStyle('E'.($col + 2 + $i))->applyFromArray($style_row);
			$objPHPExcel->getActiveSheet()->getStyle('F'.($col + 2 + $i))->applyFromArray($style_row);
		}

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('KHS Monitoring Receipt PO');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="KHS Monitoring Receipt PO.xlsx"');
		$objWriter->save("php://output");

		// echo "<pre>";
		// print_r($data);
		// die;
	}

}