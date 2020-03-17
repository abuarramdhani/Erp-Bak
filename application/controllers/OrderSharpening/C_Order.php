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
		
		// $subinv = $this->input->post('subinv');
		// $data['locator'] = $this->M_order->getLocator();
		// $data['lppb'] = $detailio;

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


	public function getLocator()
	{
		$subinv = $this->input->post('subinv');
		$data = $this->M_order->getLocator($subinv);
		echo json_encode($data);
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

	public function makeID()
	{
		$back = 1;

		check:

		$tahun = date('y');
		$bulan = date('m');

		$idunix = $tahun.$bulan.str_pad($back, 2, "0", STR_PAD_LEFT);
		$check = $this->M_order->cekId($idunix);
		
		if (!empty($check)) {
			$back++;
			GOTO check;
		}

		return $idunix;
	}

	public function reffBuilder()
	{
		$back = 0;

		check:

		$tahun = date('y');
		$bulan1 = date('m');
		$bulan = (int)$bulan1;
		$hari = date('d');

		$reff_number = $bulan.$tahun.$hari.str_pad($back, 3, "1", STR_PAD_LEFT);
		$reff_numberx = $reff_number."1";

		$check = $this->M_order->cekOrderNumber($reff_numberx);
		
		if (!empty($check)) {
			$back++;
			GOTO check;
		}

		return $reff_number;
	}

	public function Insert() {
		$ip_address 	=  $this->input->ip_address();
	   	$no_order 		= $this->input->post('noOrder');
		$reff_number 	= $this->input->post('reffNumber');
		$subinv 		= $this->input->post('subinv');
		$locator 		= $this->input->post('locator');
		$item 			= $this->input->post('kodeBarang');
		$deskripsi 		= $this->input->post('deskBarang');
		$qty 			= $this->input->post('quantity');
		$tgl_order 		= $this->input->post('dateOrder');
		$tgl 			= date('Y-m-d', strtotime($tgl_order));
		$idunix 		= $this->makeID();

		$i = 0;
		$o = 1;
		foreach ($no_order as $noOrder) {
			$getAvailability = $this->M_order->getAvailability($noOrder);
			$this->M_order->Insert($noOrder,$item[$i],$deskripsi[$i],$qty[$i],$tgl,$reff_number[$i],$idunix,$subinv[$i],$locator[$i]);
			$invID1 	= $this->M_order->getInventoryID($item[$i]); 	//------------ GET INVENTORY ITEM ID
			$invID = $invID1['INVENTORY_ITEM_ID'];
			$uom1 = $this->M_order->getUom($item[$i]); 					//------------ GET UOM
			$uom = $uom1['PRIMARY_UOM_CODE'];	
		 				//------------ GET IP ADDRESS
			$locatorIDTo = ''; 										//------------ Locator  Tujuan
			$username = '';											//------------ Username
			$transTypeID = 137;	

			$data[] = array('NO_URUT' => $o,
					'INVENTORY_ITEM_ID' => $invID,
					'QUANTITY' => $qty[$i],
					'UOM' => $uom,
					'IP_ADDRESS' => $ip_address,
					'ORDER_NUMBER' => $reff_number[$i],
					// 'SUBINV' => $subinv[$i],
					// 'LOCATOR' => $locator[$i],
					);
			
		$this->M_order->createTemp($data[$i]);

		$i++;
		$o++;	
		}

		foreach ($data as $key => $value) {
			$locatorIDTo = ''; 										//------------ Locator  Tujuan
			$username = '';											//------------ Username
			$transTypeID = 137;
			// $sub_inv = $subinv;
			// $loc = $locator;
			$this->M_order->createMO($username,$ip_address,$transTypeID,$value['ORDER_NUMBER'],$subinv[0],$locator[0]);	//-------> createMo
		}

		foreach ($data as $key => $value) {
			$this->M_order->deleteTemp($ip_address, $value['ORDER_NUMBER']);//-------> createMo
		}

		redirect(base_url('OrderSharpening/Report/'.$idunix));
	//-----------------------END CODE----------------------------------------
	} 

	//---------->FOR ANDROID---------------->dapat no_order melalui scan
	//---------->dari nomor order mendapat nomor reff -------------->
	//---------->dari reff mendapat nomor request_number untu ditransact----->

	//----------> Update is_transact pada database postgree
	//----------> Dengan ngecek line status di mtl_material_transactions = 5

	public function getTranNumber($nomor)
	{
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

		return $transNumber['REQUEST_NUMBER'];
	}
	
	public function Report($idunix)
	{
		$no_order = $this->M_order->getNomorOrder($idunix);

		$dataArray = array();
		foreach ($no_order as $noOrder => $key) {

			$getAvailability = $this->M_order->getAvailability($key['no_order']);
			$invID1 	= $this->M_order->getInventoryID($key['kode_barang']); 	//------- GET INVENTORY ITM ID
			echo "$key[kode_barang]";
			$invID = $invID1['INVENTORY_ITEM_ID'];
			$uom1 = $this->M_order->getUom($key['kode_barang']); 					//------------ GET UOM
			$uom = $uom1['PRIMARY_UOM_CODE'];
			
		 				//------------ GET IP ADDRESS
			$locatorIDTo = ''; 										//------------ Locator  Tujuan
			$username = '';											//------------ Username
			$transTypeID = 137;	

			$dataArray[] = array(
				"no_order" => $key['no_order'],
				"kode_barang" => $key['kode_barang'],
				"deskripsi_barang" => $key['deskripsi_barang'],
				"qty" => $key['qty'],
				"reff_number" => $key['reff_number'],
				"tgl_order" => $key['tgl_order'],
				"idunix" => $key['idunix']
			);
		}

		foreach ($dataArray as $key => $vlue) {
			$x = $this->M_order->getTranNumber($vlue['reff_number']);
			$dataArray[$key]['REQUEST_NUMBER'] = $x['REQUEST_NUMBER'];
		}

		ob_start();

			$this->load->library('ciqrcode');
			// ------ create directory temporary qrcode ------
			if(!is_dir('./img'))
			{
				mkdir('./img', 0777, true);
				chmod('./img', 0777);
			}
			
			foreach ($dataArray as $show) {
				$params['data']		= ($show['reff_number']);
				$params['level']	= 'H';
				$params['size']		= 10;
				$params['black']	= array(255,255,255);
				$params['white']	= array(0,0,0);
				$params['savename'] = './img/'.($show['no_order']).'.png';
				$this->ciqrcode->generate($params);

			}
		// -----------------------------------------------------
		$data['show'] = $dataArray;

    	$this->load->library('pdf');
    	$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(210,297), 0, '', 3, 3, 3, 50, 3, 3); //----- A5-L
		$tglNama = date("d/m/Y-H:i:s");
    	$filename = 'OrderSharpening_'.$tglNama.'.pdf';
    	$html = $this->load->view('OrderSharpening/V_Report', $data, true);		//-----> Fungsi Cetak PDF
		ob_end_clean();
    	$pdf->WriteHTML($html);												//-----> Pakai Library MPDF
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
			echo "sukses ditambahkan";
		} else {
			echo "gagal ditambahkan";
		}	
	}
}
