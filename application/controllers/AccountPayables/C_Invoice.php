<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Invoice extends CI_Controller {

   function __construct() {
        parent::__construct();
		$this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->helper('html');
		$this->load->helper('download');
	    $this->load->library('form_validation');
	    //load the login model
		$this->load->library('session');
		$this->load->library('csvimport');
		//$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AccountPayables/M_Invoice');

			  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			//redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function index()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}	

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function search(){
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$tanggal_awal = $this->input->post('tanggal_awal');
		$tanggal_akhir = $this->input->post('tanggal_akhir');
		$supplier = $this->input->post('supplier');
		$inum = $this->input->post('invoice_number');
		$invoice_number = strtoupper($inum);
		$invoice_status = $this->input->post('invoice_status');
		$voucher_number = $this->input->post('voucher_number');

		$data['tanggal_awal'] = $tanggal_awal;
		$data['tanggal_akhir'] = $tanggal_akhir;
		$data['supplier'] = $supplier;
		$data['invoice_number'] = $invoice_number;
		$data['invoice_status'] = $invoice_status;
		$data['voucher_number'] = $voucher_number;

		$query = $this->M_Invoice->alldata($tanggal_awal, $tanggal_akhir, $supplier, $invoice_number, $invoice_status, $voucher_number);
		$data['data']=$query;
		
		$this->load->view('AccountPayables/V_SearchResult',$data);
	}

	public function generateQR(){
		$invid = $this->input->POST('invid');
		
		$files = glob('/../../../assets/upload/qrcodeAP/*');
		foreach($files as $file){ // iterate files
		if(is_file($file))
		unlink($file); // delete file
		}
		include "phpqrcode/qrlib.php"; 
		$PNG_TEMP_DIR = dirname(__FILE__).'/../../../assets/upload/qrcodeAP'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = base_URL('assets/upload/qrcodeAP/');
		$errorCorrectionLevel = 'H';
		$matrixPointSize = 5;
		
		$uniqpartcode = $invid;
		$filename = $PNG_TEMP_DIR.'test'.md5($uniqpartcode.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		QRcode::png($uniqpartcode, $filename, $errorCorrectionLevel, $matrixPointSize, 1);
		$urlImage = $PNG_WEB_DIR.DIRECTORY_SEPARATOR.basename($filename);
		echo $urlImage;
	}	
	
	public function getSupplier(){
		$supply = $this->input->GET('term');
		$supplier = strtoupper($supply);
		$query = $this->M_Invoice->getSupplier($supplier);
		echo json_encode($query);
		// print_r($query);
	}	

	public function getInvoiceNumber(){
		$supplier = $this->input->GET('supplier');
		$start_date = $this->input->GET('tanggal_awal');
		$end_date = $this->input->GET('tanggal_akhir');
		$invoice_num = $this->input->GET('term');
		$query = $this->M_Invoice->getInvoiceNumber($invoice_num,$start_date,$end_date,$supplier);
		echo json_encode($query);
		// print_r($query);
	}
	
	
	public function getVoucherNumber(){
		$start_date = $this->input->GET('tanggal_awal');
		$end_date = $this->input->GET('tanggal_akhir');
		$voucher_num = $this->input->GET('term');
		$query = $this->M_Invoice->getVoucherNumber($voucher_num,$start_date,$end_date);
		echo json_encode($query);
		// print_r($query);
	}

	public function getInvoiceNumber2(){
		$period = $this->input->GET('period');
		$year = $this->input->GET('year');
		$invoice_num = $this->input->GET('term');
		$query = $this->M_Invoice->getInvoiceNumber2($period,$year,$invoice_num);
		echo json_encode($query);
		// print_r($query);
	}

	public function getInvoiceNumber3(){
		$invoice_num = $this->input->POST('invoice_num');
		$query = $this->M_Invoice->getInvoiceNumber3($invoice_num);
		foreach ($query as $name){
			echo $name['NAME'];
		}
		// print_r($query);
	}
	
	//MENGAMBIL DAFTAR NAMA
	public function getInvoiceName(){
		
		$name = $this->input->GET('term');
		$query = $this->M_Invoice->getInvoiceName($name);
		echo json_encode($query);
		// print_r($query);
	}	

	public function inputTaxNumber($invoice_id){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		


		$query = $this->M_Invoice->getDetail($invoice_id);
		$query2 = $this->M_Invoice->findSingleFaktur($invoice_id);
		$data['data']=$query;
		$data['data_faktur']=$query2;
		$this->load->view('AccountPayables/V_Input',$data);
	}
	public function inputTaxManual($invoice_id){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		


		$query = $this->M_Invoice->getDetail($invoice_id);
		$query2 = $this->M_Invoice->findSingleFaktur($invoice_id);
		$data['data']=$query;
		$data['data_faktur']=$query2;
		$this->load->view('AccountPayables/V_Manual',$data);
	}

	public function saveTaxNumber(){

		$this->checkSession();
		$user_id = $this->session->userid;

		$invoice_id = $this->input->post('invoice_id');//kanan
		$faktur_type = $this->input->post('faktur_type');//hidden
		$tanggalFaktur = $this->input->post('tanggalFaktur');//kiri
		$tanggalFakturCon = $this->input->post('tanggalFakturCon');//hide
		$npwpPenjual = $this->input->post('npwpPenjual');//kiri
		$namaPenjual = $this->input->post('namaPenjual');//kiri
		$alamatPenjual = $this->input->post('alamatPenjual');//kiri
		$dpp = $this->input->post('jumlahDpp');//kiri
		$ppn = $this->input->post('jumlahPpn');//kiri
		$ppnbm = $this->input->post('ppnbm');//entah
		$comment = $this->input->post('txaCmt');//modal 2-2 nya
		$tax_number = $this->input->post('nomorFaktur');//kiri
		$tax_number_awal = substr($tax_number, 0, 3).'.'.substr($tax_number, 3, 3).'-'.substr($tax_number, 6, 2).'.';
		$tax_number_akhir = substr($tax_number, 8, strlen($tax_number)-7);
		
		$query = $this->M_Invoice->saveTaxNumber($invoice_id, $tanggalFaktur, $tanggalFakturCon, $tax_number_awal, $tax_number_akhir, $tax_number, $npwpPenjual, $namaPenjual, $alamatPenjual, $dpp, $ppn, $ppnbm, $faktur_type, $comment );

	}
	public function saveTaxNumberManual(){

		$this->checkSession();
		$user_id = $this->session->userid;

		$invoice_id = $this->input->post('invoice_id');
		$tanggalFakturCon = $this->input->post('tanggalFakturCon');
		$tax_number = $this->input->post('nomorFaktur');
		$tax_number_awal = substr($tax_number, 0, 3).'.'.substr($tax_number, 3, 3).'-'.substr($tax_number, 6, 2).'.';
		$tax_number_akhir = substr($tax_number, 8, strlen($tax_number)-7);
		$name_faktur = $this->input->post('nameFaktur');

		$query = $this->M_Invoice->saveTaxNumberManual($invoice_id, $tanggalFakturCon, $tax_number_awal, $tax_number_akhir, $tax_number, $name_faktur);
	}	

	public function deleteTaxNumber($invoice_id,$invoice_num){
		$this->checkSession();
		$user_id = $this->session->userid;
		$query = $this->M_Invoice->deleteTaxNumber($invoice_id,$invoice_num);
		if($query>0){
			echo "
				<script>
				    alert('Hapus Berhasil');
				    window.close();
				</script>
			";
		}else{
			echo "
			<script>
			    alert('Hapus Gagal');
			    window.close();
			</script>
			";
		}

	}
	
	//LOAD PAGE : HALAMAN DOWNLOAD FAKTUR MASUKAN (RFM)
	public function downloadrfm(){
		
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/V_Download_RFM',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//LOAD PAGE : HALAMAN DOWNLOAD FAKTUR MASUKAN (FM)
	public function downloadfm(){
		
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/V_Download_FM1',$data);
		$this->load->view('AccountPayables/V_Download_FM2',$data);
		$this->load->view('AccountPayables/V_Download_FM3',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//FIND FAKTUR MASUKAN USING JAVASCRIPT (FM)
	public function FindFaktur(){
		
		$month 			= $this->input->POST('month');
		$year 			= $this->input->POST('year');
		$invoice_num 	= $this->input->POST('invoice_num');
		$name 			= $this->input->POST('name');
		$tanggal_awal = $this->input->POST('tanggal_awal');
		$tanggal_akhir = $this->input->POST('tanggal_akhir');
		
		$ket1 			= $this->input->POST('ket1');
		$ket2 			= $this->input->POST('ket2');
		
		$sta1 			= $this->input->POST('sta1');
		$sta2 			= $this->input->POST('sta2');
		$sta3 			= $this->input->POST('sta3');

		$typ1 			= $this->input->POST('typ1');
		$typ2 			= $this->input->POST('typ2');

		$data['FilteredFaktur'] = $this->M_Invoice->FindFaktur($month,$year,$invoice_num,$name,$ket1,$ket2,$sta1,$sta2,$sta3,$typ1,$typ2,$tanggal_awal,$tanggal_akhir);
		$this->load->view('AccountPayables/V_Download_FM2',$data);
	}
	
	//DOWNLOAD FILTERED DATA (FM)
	public function savefile(){
		
		$month 			= $this->input->POST('TxtMasaPajak');
		$year 			= $this->input->POST('TxtTahun');
		$invoice_num 	= $this->input->POST('TxtInvoiceNumber');
		$name 			= $this->input->POST('TxtNama');
		$tanggal_awal = $this->input->post('tanggal_awal');
		$tanggal_akhir = $this->input->post('tanggal_akhir');
		
		//CHECKBOX KETERANGAN
		$keterangan1	= $this->input->POST('ket1');
		$keterangan2	= $this->input->POST('ket2');

		$ket1 	= "no";	if($keterangan1 == 'on'){$ket1="yes";}
		$ket2 	= "no";	if($keterangan2 == 'on'){$ket2="yes";}
	
		//CHECKBOX STATUS
		$status1 		= $this->input->POST('sta1');
		$status2 		= $this->input->POST('sta2');
		$status3 		= $this->input->POST('sta3');
		
		$sta1 	= "no";	if($status1 == 'on'){$sta1="yes";}
		$sta2 	= "no"; if($status2 == 'on'){$sta2="yes";}
		$sta3 	= "no"; if($status3 == 'on'){$sta3="yes";}

		//CHECKBOX TYPE
		$tipe1			= $this->input->POST('typ1');
		$tipe2			= $this->input->POST('typ2');

		$typ1 	= "no";	if($tipe1 == 'on'){$typ1="yes";}
		$typ2 	= "no";	if($tipe2 == 'on'){$typ2="yes";}
		
		$type = $this->input->POST('slcFileType');
		
		if($type=="1"){
			$row  = $this->M_Invoice->FindFakturCSV($month,$year,$invoice_num,$name,$ket1,$ket2,$sta1,$sta2,$sta3,$typ1,$typ2,$tanggal_awal,$tanggal_akhir);
			$name = 'Faktur-Selected.csv';
			force_download($name,$row);
			
		} else if ($type=="2"){
			
			$this->load->library('pdf');
			$pdf = $this->pdf->load();

			$pdf = new mPDF('utf-8', array(210,330), 0, '', 0, 0, 0, 0, 0, 0, 'L');
			$filename = 'Faktur-Selected';
			$this->checkSession();

			$data['FilteredFaktur'] = $this->M_Invoice->FindFaktur($month,$year,$invoice_num,$name,$ket1,$ket2,$sta1,$sta2,$sta3,$typ1,$typ2,$tanggal_awal,$tanggal_akhir);
			
			$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
			$html = $this->load->view('AccountPayables/V_Download_FMPDF', $data, true);

			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
			$pdf->Output($filename, 'I');
		
		} else if ($type=="3") {
			
			$data['FilteredFaktur'] = $this->M_Invoice->FindFaktur($month,$year,$invoice_num,$name,$ket1,$ket2,$sta1,$sta2,$sta3,$typ1,$typ2,$tanggal_awal,$tanggal_akhir);
			$this->load->view('AccountPayables/V_Download_FMEXCEL',$data);
		}
	}
	
	//CLICK BUTTON IMPORT THEN LOAD IMPORT INFORMATION PAGE (FM)
	function importfm() {
       
		$config['upload_path'] = 'assets/upload/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '1000';
		$this->load->library('upload', $config);
 
        if (!$this->upload->do_upload('importfmfile')) { echo $this->upload->display_errors();}
		else {	$file_data 	= $this->upload->data();
				$filename	= $file_data['file_name'];
				$file_path 	= 'assets/upload/'.$file_data['file_name'];
			
			if ($this->csvimport->get_array($file_path)) {
                $data['csvarray'] = $this->csvimport->get_array($file_path);
				$data['filename'] = $filename;
				
				$this->checkSession();
				$user_id = $this->session->userid;

				$data['Menu'] = 'Dashboard';
				$data['SubMenuOne'] = '';
				
				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
				
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('AccountPayables/V_Upload_FM',$data);
				$this->load->view('V_Footer',$data);
            } else {
                $this->load->view('csvindex', $data);
			}
        }
    }
	
	//CONFIRM INFORMATION PAGE THEN EXECUTE UPDATE QUERY (FM)
	function confirmfm(){
		
		$filename	= $this->input->POST('TxtFileName');
        $file_path 	= 'assets/upload/'.$filename;
		$csv_array 	= 	$this->csvimport->get_array($file_path);
			
		foreach ($csv_array as $row) {
			$update_data = array(
				'FAKTUR_PAJAK'=> str_replace(str_split('.-'), '', $row['FAKTUR_PAJAK']),
				'STATUS'=> strtoupper($row['STATUS']),
				'MONTH' => $row['BULAN_PAJAK'],
				'YEAR' => $row['TAHUN_PAJAK'],
			);
			$this->M_Invoice->UpdateFmDesc($update_data);
		}
		unlink($file_path);
        redirect(base_url().'AccountPayables/C_Invoice/downloadfm');
	}

	function qrcode(){
		$doc = new DOMDocument();
		$url = $_POST['url'];
		$doc->load($url);//xml file loading here
		$xml = $doc->getElementsByTagName( "resValidateFakturPm" );
		$xml1 = $doc->getElementsByTagName( "detailTransaksi" );
		$i=0;
		foreach ($xml1 as $xml1) {
			$namas = $xml1->getElementsByTagName( "nama" );
			$nama = $namas->item(0)->nodeValue;
			if($i>0){
				$data['nama'] = $data['nama']."\n".$nama;
			}else{
			  	$data['nama'] = $nama;
			}
			$i=$i+1;
		}
		foreach( $xml as $xml ){
			  $nomorFakturs = $xml->getElementsByTagName( "nomorFaktur" );
			  $nomorFaktur = $nomorFakturs->item(0)->nodeValue;
			  $data['nomorFaktur'] = $nomorFaktur;

			  $namaPenjuals = $xml->getElementsByTagName( "namaPenjual" );
			  $namaPenjual = $namaPenjuals->item(0)->nodeValue;
			  $data['namaPenjual'] = $namaPenjual;

			  $tanggalFakturs = $xml->getElementsByTagName( "tanggalFaktur" );
			  $tanggalFaktur = $tanggalFakturs->item(0)->nodeValue;
			  $data['tanggalFaktur'] = $tanggalFaktur;

			  $jumlahDpps = $xml->getElementsByTagName( "jumlahDpp" );
			  $jumlahDpp = $jumlahDpps->item(0)->nodeValue;
			  $data['jumlahDpp'] = $jumlahDpp;

			  $jumlahPpns = $xml->getElementsByTagName( "jumlahPpn" );
			  $jumlahPpn = $jumlahPpns->item(0)->nodeValue;
			  $data['jumlahPpn'] = $jumlahPpn;

			  $npwpPenjuals = $xml->getElementsByTagName( "npwpPenjual" );
			  $npwpPenjual = $npwpPenjuals->item(0)->nodeValue;
			  $data['npwpPenjual'] = $npwpPenjual;

			  $alamatPenjuals = $xml->getElementsByTagName( "alamatPenjual" );
			  $alamatPenjual = $alamatPenjuals->item(0)->nodeValue;
			  $data['alamatPenjual'] = $alamatPenjual;

			  $kdJenisTransaksis = $xml->getElementsByTagName( "kdJenisTransaksi" );
			  $kdJenisTransaksi = $kdJenisTransaksis->item(0)->nodeValue;
			  $data['kdJenisTransaksi'] = $kdJenisTransaksi;

			  $fgPenggantis = $xml->getElementsByTagName( "fgPengganti" );
			  $fgPengganti = $fgPenggantis->item(0)->nodeValue;
			  $data['fgPengganti'] = $fgPengganti;	  
		}
		echo json_encode($data);
	}

	public function faktursa(){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('AccountPayables/V_Faktursa',$data);
		

	}

	public function chkInvExist($invoice){
		if ($invoice == 'undefined') {
			$retval = 'false';
		}else{
			$checkInv = $this->M_Invoice->checkInvoice($invoice);
			if ($checkInv[0]['ATTRIBUTE3'] != NULL || $checkInv[0]['ATTRIBUTE3'] != '') {
				$retval = 'true';
			}else{
				$retval = 'false';
			};
		};
		echo $retval;
	}

	public function chkFakExist($faktur){
		$checkFak = $this->M_Invoice->checkFaktur($faktur);
		if ($checkFak) {
			$retval = 'true';
		}else{
			$retval = 'false';
		};
		echo $retval;
	}

}