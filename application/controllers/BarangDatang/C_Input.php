<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Input extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		// $this->load->library('csvimport');
		//load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('BarangDatang/M_input');
			
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}

	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
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

		$id = 1;
		generateID:
		$num = str_pad($id, 4, "0", STR_PAD_LEFT);
		$no_id = 'P'.date('ymd').$num;
		// echo"<pre>";
		// print_r($no_id);
		// exit;
		$checkID_tampung_po_sj = $this->M_input->checkID_tampung_po_sj($no_id);
		$checkID_khstampungbarangsementara = $this->M_input->checkID_khstampungbarangsementara($no_id);
		if($checkID_tampung_po_sj == 0 && $checkID_khstampungbarangsementara == 0){
			$data['no_id'] = $no_id;
			$id = 1;
		}
		else{
			$id++;
			goto generateID;
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangDatang/V_Input',$data);
		$this->load->view('V_Footer',$data);
		// echo '<pre>';
		// print_r($data);
		// exit;

	}

	public function SearchSupplier(){
		$term = $this->input->get('activity');
		// echo '<pre>';
		// print_r($term);
		// exit;
		$data = $this->M_input->getsupplier($term);
		// $callback = array(
		// 	'supplier_name' =>$data[0]['VENDOR_NAME']
		// );
		$callback = $data[0]['VENDOR_NAME'];
		echo $callback;
	}
	public function GetIdSupplier(){
		$vendor= $this->input->post('sup');
		$data=$this->M_input->GetIdSupplier($vendor);
		if( ! empty($data)){ 
			$callback = array(
			 'status' => 'success', 
			 'VENDOR_ID' =>$data[0]['VENDOR_ID']
		 );
		}else{
			$callback = array('status' => 'failed'); 
		}
		echo json_encode($callback);
	}

	public function SearchingAjax()
	{
		$activity = $this->input->get('activity');
		// $hasil = $this->M_input->getSupplier($activity);
		// echo "<pre>"; print_r($hasil['0']); exit();
		$data['Activity'] = $this->M_input->getTable($activity);
		// echo "<pre>"; 
		// print_r($data); 
		// print_r(count($data['Activity'])); 
		// exit();

		$this->load->view('BarangDatang/V_Search', $data);
	}

	public function gudangbd()
	{
		$term = $this->input->GET('term');
		// $subinv =  $this->input->GET('subinv');
		// $loc = $this->input->GET('loc');
		// echo "<pre>"; print_r($kode); exit();
		$gudang = $this->M_input->getGudang($term);
		echo json_encode($gudang);
	}
	
	public function itembd()
	{
		$kode = $this->input->GET('term');
		// $subinv =  $this->input->GET('subinv');
		// $loc = $this->input->GET('loc');
		$item = $this->M_input->item($kode);
		// echo "<pre>"; print_r($item); exit();
		echo json_encode($item);
	}

	public function saveData (){
		$line1 = $this->input->post('line1');
		// $line2 = $this->input->post('line2');
		$line3 = $this->input->post('line3');
		$line4 = $this->input->post('line4');
		$note = $this->input->post('note');
		$supplier = $this->input->post('txtSupplier');
		$tanggal = $this->input->post('dateDatang');
		$tanggaldatang['tanggal'] = $this->input->post('dateDatang');
		$tanggaldatang['waktu'] = $this->input->post('timeDatang');
		$tanggal_datang= implode(' ', $tanggaldatang);
		$nosj = $this->input->post('txtNoSJ');
		$nopo = $this->input->post('txtNoPo');
		$keterangan = $this->input->post('READY');
		$no_id = $this->input->post('txtID');
		$count = sizeOf($line1);
		// echo "<pre>";
		// print_r($line1);
		// print_r($itemline);
		// print_r($descline);
		// exit;

		
		$varItem = $this->input->post('txtitem');
		$varItemDescription = $this->input->post('txtitem_description');
		$varsubinv = $this->input->post('txtsubinv');
		$varQty = $this->input->post('txtqty');
		$varItemId = $this->input->post('txtitemid');
		$varID = $this->input->post('txtCheck');
		$row = sizeOf($varItem);
		$hasilcek= null;
		$kosong = null;
		// echo "<pre>";
		// print_r($varID);
		// print_r($line1[0]);
		if (empty($varID) && empty($line1[0])) {
			$kosong = "kosong";
		}
		if ($kosong == 'kosong') {
			// $message = "Quantity Error! Please re-check";
			// echo "<script type='text/javascript'>alert('$message');</script>";
			// exit;
			$this->session->set_flashdata('response',"No item to insert!");
			redirect('BarangDatang/C_input/index');
		}
		// exit;
		for($i=0;$i<$row;$i++){
			// echo "ulang";
			if (!(empty($varID[$i]))){
				// echo "if1";
				// $Item = $varItem[$i];
				// $ItemDescription = $varItemDescription[$i];
				// $subinv = $varsubinv[$i];
				$cekQty = $varQty[$i];
				$cekitem_id = $varItemId[$i];
				$checkqty = $this->M_input->ceksisaQuantity($nopo,$cekitem_id);
				// echo"<pre>"; print_r($checkqty);	
				if (empty($cekQty)) {
					$hasilcek = "error";
				}
				if ($cekQty > $checkqty[0]['QUANTITY']) {
					// echo "if2";
					// $message = "wrong answer";
					// echo "<script type='text/javascript'>alert('$message');</script>";
					$hasilcek = "error";
				}
			}
		}

		if ($hasilcek == 'error') {
			// $message = "Quantity Error! Please re-check";
			// echo "<script type='text/javascript'>alert('$message');</script>";
			// exit;
			$this->session->set_flashdata('response',"Quantity Error!");
			redirect('BarangDatang/C_input/index');
		}
		// exit;

		$insert = $this->M_input->insertTableKHStampungheader($nopo,$nosj,$keterangan,$note,$supplier,$no_id,$tanggal_datang);
		
		for($i=0;$i<$count;$i++){
			$ln11 = $line1[$i];
			$line11 = explode("-" , $ln11);
			$ln1 = $line11[0];
			$ln2 = $line11[1];
			// $ln2 = $line2[$i];
			$ln3 = $line3[$i];
			$ln4 = $line4[$i];
			// $ln = $this->M_input->getItemId($ln1);
			$ln5 = $line11[2];
			// $ln5 = $ln['0']['ITEM_ID'];
			// echo "<pre>"; 
			// print_r($ln1);
			// print_r($ln2);
			// print_r($ln3);
			// print_r($ln4);
			// print_r($ln5);
			// if(strlen($ln1) > 0 && strlen($ln2) > 0 && strlen($ln3) > 0){
				$insert = $this->M_input->insertTableKHStampungline_tidak_po($nosj,$ln1,$ln2,$ln3,$ln4,$no_id,$ln5);
			// 	echo "<pre>";print_r($insert);($nosj,$Item,$ItemDescription,$subinv,$Qty,$no_id,$item_id)
			// }
		}
		// exit;
		// $varItem = $this->input->post('txtitem');
		// $varItemDescription = $this->input->post('txtitem_description');
		// $varsubinv = $this->input->post('txtsubinv');
		// $varQty = $this->input->post('txtqty');
		// $varItemId = $this->input->post('txtitemid');
		// $varID = $this->input->post('txtCheck');
		// $row = sizeOf($varItem);
		for($i=0;$i<$row;$i++){
				if (!(empty($varID[$i]))){
					$Item = $varItem[$i];
					$ItemDescription = $varItemDescription[$i];
					$subinv = $varsubinv[$i];
					$Qty = $varQty[$i];
					$item_id = $varItemId[$i];
					$insert = $this->M_input->insertTableKHStampungline($nopo,$nosj,$Item,$ItemDescription,$Qty,$subinv,$no_id,$item_id);		
				}
		}
		// exit;
		$this->session->set_flashdata('return',"Saved");
		redirect ('BarangDatang/C_input/index');
	}
}