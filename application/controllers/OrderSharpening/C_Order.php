<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Order extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
		//module from CI
		$this->load->model('M_index');
		$this->load->model('OrderSharpening/M_order');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

//--OK---> Membuat MO oracle dan menghasilkan request number
//--OK---> Selanjutnya mengambil header MO/request_number untuk di transact
//-----> Selanjutnya update status postgree
//--NOT OK---> Selanjutnya cek onhand quantity sebelum pos
//-----> Selanjutnya cek onhand quantity berdasar requestMO, transact tidak melebihi quantity MOrequest
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['regen'] = $this->regen();
		$data['item'] = $this->M_order->getItem();
		$data['reffBuilder'] = $this->reffBuilder();


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderSharpening/V_Order',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function getDeskripsi()
	{
    	$param = $this->input->post('param');
    	$data = $this->M_order->getDeskripsi($param);
    	echo json_encode($data[0]['DESCRIPTION']);
	}

	public function regen()
	{
		$back = 1;

		check:

		$tahun = date('y');
		$bulan = date('m');
		$hari = date('d');

		$no_order = $tahun.$bulan.$hari.str_pad($back, 3, "0", STR_PAD_LEFT);
		$check = $this->M_order->cekNomor($no_order);
		
		if (!empty($check)) {
			$back++;
			GOTO check;
		}

		return $no_order;
	}

	public function reffBuilder()
	{
		$back = 0;

		check:

		$tahun = date('y');
		$bulan1 = date('m');
		$bulan = (int)$bulan1;
		$hari = date('d');

		$reff_number = $bulan.$hari.$tahun.str_pad($back, 3, "1", STR_PAD_LEFT); 
		$check = $this->M_order->cekOrderNumber($reff_number);
		
		if (!empty($check)) {
			$back++;
			GOTO check;
		}

		return $reff_number;
	}

	public function Insert()
	{
	   	$no_order = $this->input->post('no_order');
		$reff_number = $this->input->post('reff_number');
		$item = $this->input->post('txtItem');
		$deskripsi = $this->input->post('txtDesc');
		$qty = $this->input->post('txtQty');
		$tgl_order = $this->input->post('dateOrder');

		//$getQuantityActual = $this->M_Order->getQuantityActual($item,$qty);
		
		$getAvailability = $this->M_order->getAvailability($no_order);

		//$data = $this->M_Order->Insert($no_order,$item,$deskripsi,$qty,$tgl_order,$reff_number);

		if ($getAvailability > 0) {
			redirect(base_url('OrderSharpening/Order/'));
		} else {
			$data = $this->M_order->Insert($no_order,$item,$deskripsi,$qty,$tgl_order,$reff_number);
		};

		//$data = $this->M_Order->Insert($no_order,$item,$deskripsi,$qty,$tgl_order,$reff_number);

		//-----------------------START CODE----------------------------------------

		$invID1 	= $this->M_order->getInventoryID($item); 	//------------ GET INVENTORY ITEM ID
		$invID = $invID1['INVENTORY_ITEM_ID'];
		$uom1 = $this->M_order->getUom($item); 					//------------ GET UOM
		$uom = $uom1['PRIMARY_UOM_CODE'];
		$ip_address =  $this->input->ip_address(); 				//------------ GET IP ADDRESS

		$locatorIDTo = ''; 										//------------ Locator  Tujuan
		$username = '';											//------------ Username
		$transTypeID = 137;										//------------ Move Order Antar Gudang Satu Area

		$i = 1;
		$data = array('NO_URUT' => $i,
					'INVENTORY_ITEM_ID' => $invID,
					'QUANTITY' => $qty,
					'UOM' => $uom,
					'IP_ADDRESS' => $ip_address,
					'ORDER_NUMBER' => $reff_number);
		// echo 	"<pre>";
		// print_r($data);
		// exit();

		//-------> Untuk MO dari ToolMaking ke ToolRoom tidak mencetak slip
		//-------> slip Menggunakan yang sebelumnya, jadi diperlukan perkondisian
		//-------> Bisa pakai if atau Value		

		//-------> Harus pakai createTemp, soalnya dipakai di API nya
		$this->M_order->createTemp($data);											//-------> create TEMP
		$i++;
		$this->M_order->createMO($username,$ip_address,$transTypeID,$reff_number);	//-------> createMo
		$this->M_order->deleteTemp($ip_address,$reff_number);						//-------> deleteMO

		//$req_number = $this->M_Order->getRequestNumber($reff_number);
		// echo "<pre>"; print_r($data); print_r($req_number); exit();

		redirect(base_url('OrderSharpening/Report/'.$no_order));
		//-----------------------END CODE----------------------------------------
	} 


	//---------->FOR ANDROID---------------->dapat no_order melalui scan
	//---------->dari nomor order mendapat nomor reff -------------->
	//---------->dari reff mendapat nomor request_number untu ditransact----->

	//----------> Update is_transact pada database postgree
	//----------> Dengan ngecek line status di mtl_material_transactions = 5

	public function getTranNumber($nomor)
	{
		//$param = $this->input->post('no_order');
		// $data = $this->M_Order->getReffNumber($nomor);
		// $dataGet = $data['reff_number'];
		$transNumber = $this->M_order->getTranNumber($nomor);
		$status = $this->M_order->getStatusTran($transNumber['REQUEST_NUMBER']);
		$updateStatus = array();

		switch ($status['LINE_STATUS']) {
		    case 3:
		        $message = "Move Order belum sepenuhnya tertransact!";
		        break;
		    case 5:
		        $message = "Move Order selesai ditransact";
		        break;
		    default:
		        $message = "Menunggu persetujuan untuk ditransact";
		}
		// echo "<pre>";
		// print_r($message);
		// exit();
		return $transNumber['REQUEST_NUMBER'];
	}
	
	public function Report($no_order)
	{
    	$data['show'] = $this->M_order->cekNomor($no_order);			//-----> get value from postgree by no_order
    	$data['show'][0]['REQUEST_NUMBER'] = $this->getTranNumber($data['show'][0]['reff_number']);

    	$tanggal = date_format(date_create(date('d-M-y')),'l, d F Y');

		
		// ------ GENERATE QRCODE ------
			$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
				if(!is_dir('./img'))
				{
					mkdir('./img', 0777, true);
					chmod('./img', 0777);
				}
			$params['data']		= ($data['show'][0]['reff_number']);
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './img/'.($data['no_order']).'.png';
			$this->ciqrcode->generate($params);

		// -----------------------------------------------------


    	$this->load->library('pdf');

    	$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(210,80), 0, '', 3, 3, 3, 3, 3, 3); //----- A5-L

		ob_end_clean() ;

    	$filename = 'OrderSharpening_'.$data['show'][0]['no_order'].'.pdf';
    	$html = $this->load->view('OrderSharpening/V_Report', $data, true);		//-----> Fungsi Cetak PDF
    	$pdf->WriteHTML($html, 2);												//-----> Pakai Library MPDF
    	$pdf->Output($filename, 'I');
	}


	//-----------------------ANDROID START CODE----------------------------------------

	public function getAllData()
	{
		$data = $this->M_order->getAllData();
		$result = array();

		//Menampilkan Array dalam Format JSON
		echo json_encode(array('result'=>$data));
	}

	public function getDetailData($no_order)
	{
		$data = $this->M_order->cekNomor($no_order);
		echo json_encode(array('result'=>$data));
	}

	public function transactMo($nomor) //-------------------> Masih Beta 
	{
		$transact = $this->M_order->getTransact($nomor);
		$data = array();
		foreach ($transact as $key) {
			$data['REQUEST_NUMBER'] = $key['REQUEST_NUMBER']; 
			$data['INVENTORY_ITEM_ID'] = $key['INVENTORY_ITEM_ID']; 
		};

		$status = $this->M_order->getStatusTran($data['REQUEST_NUMBER']);
		if ($status['LINE_STATUS'] == 5) {
			$message = "Move Order selesai ditransact";
		} else {
			$this->M_order->transactMO($data['REQUEST_NUMBER'],$data['INVENTORY_ITEM_ID']);
			$message = "Move Order selesai ditransact";
		}
		
		echo "<pre>";
		print_r($message);
		exit();
	}

	public function hapusData($no_order)
	{
		$data = $this->M_order->hapusData($no_order);
		if($data){
			echo "sukses dihapus";
		} else {
			echo "gagal dihapus";
		}
	}

	public function injectData()
	{
		$data = $this->input->post();
		if($data){
			echo "sukses ditambahlan";
		} else {
			echo "gagal ditambahkan";
		}	
	}



}
