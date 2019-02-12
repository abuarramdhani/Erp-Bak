<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Ajax extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->model('WarehouseSPB/Ajax/M_ajax');
        $this->load->model('WarehouseSPB/MainMenu/M_transaction');
    }
	
	public function getSPB()
	{
		$id = $this->input->post('nomerSPB');
		$SubInv = $this->M_ajax->getSubInv($id);
		if (empty($SubInv)) {
			echo "Data is Empty";
		} else {
			$data['spb'] = $this->M_ajax->getSPB($id, $SubInv[0]['FROM_SUBINVENTORY_CODE']);
			// echo "<pre>";
			// print_r($data);
			// exit();
			$this->load->view('WarehouseSPB/Ajax/TransactionSPB/V_Spb',$data);
		}
	}
	
	public function PackingList()
	{
		$id = $this->input->post('nomerSPB');
		$data['nomerspb'] 	= $id;
		$SubInv 			= $this->M_ajax->getSubInv($id);
		if(!empty($SubInv)){
			$data['spb'] 		= $this->M_ajax->getSPB($id, $SubInv[0]['FROM_SUBINVENTORY_CODE']);
			$data['ekpedisi'] 	= $this->M_ajax->getEkpedisi($id);
			$data['listEkspedisi'] = $this->M_ajax->getEkspedisiList();
			$lastPackCode 		= $this->M_ajax->getLastPackCode($id);
			

			if (empty($lastPackCode)) {
				$data['last_pack'] = 1;
			}else{
				$data['last_pack'] = intval($lastPackCode[0]['LASTPACKNUMBER'])+1;
			}
			if ($SubInv || $data['spb'] ) {
				$this->load->view('WarehouseSPB/Ajax/TransactionPackingList/V_Packinglist',$data);
			}else{
				echo "Data is empty";
			}	
		}

		// echo "<pre>";
		// echo $id;
		// print_r($SubInv);
		// print_r($data);
		// print_r($lastPackCode);
		// exit();
	}

	public function setPacking()
	{
		$spbNumber		= $this->input->post('spbNumber');
		$packingNumber	= $this->input->post('packingNumber');
		if (strlen($packingNumber) == 1) {
			$packingNumber = '0'.$packingNumber;
		}
		$item_id 		= $this->input->post('item_id');
		$packingqty 	= $this->input->post('packingqty');
		$kemasan		= $this->input->post('kemasanValue');
		$ekspedisi		= $this->input->post('EkspedisiValue');
		if (empty($ekspedisi)) {
			$ekspedisi = NULL;
		}
		$weight 		= $this->input->post('weight');
		$itemColy 		= $this->input->post('itemColy');

		$temp = array();
		
		// echo "<pre>";
		// print_r($item_id);
		// exit();

		foreach ($item_id as $key => $value){
			if (!empty($packingqty[$key])) {
				$dt = array(
					'MO_NUMBER'			=> $spbNumber,
					'INVENTORY_ITEM_ID' => $value,
					'PACKING_QTY'		=> $packingqty[$key],
					'PACKING_CODE'		=> $kemasan.'-'.$packingNumber,
					'EXPEDITION_CODE'	=> $ekspedisi,
					'WEIGHT' 			=> $weight,
					'LOAD_DATE' 		=> NULL,
					'LINE_ID' 			=> NULL,
					'RECEIVED_QTY' 		=> NULL,
					'ITEM_COLY'			=> $itemColy
				);

				$this->M_transaction->insertPacking($dt);
				array_push($temp, $dt);
			}
		}	
		
		// echo "<print>";
		// print_r($_POST);
		// exit();

		echo json_encode($temp);
	}

	public function checkSPB(){
		
		$ip = $this->get_client_ip();
		$data = $this->M_ajax->checkSPB($ip);
		if($data){
			echo json_encode($data[0]['NO_SPB']);	
		}else{
			echo json_encode('FALSE');
		}
	}

	public function setSPB(){
		$spbNumber  = $this->input->post('NO_SPB');
		$ip =  $this->get_client_ip();

		$data = array(
			'IP' => $ip,
			'NO_SPB' => $spbNumber 
		);

		$this->M_ajax->insertTemp($data);
		echo json_encode($spbNumber);
	}

	public function delTemp(){
		$ip =  $this->get_client_ip();

		$this->M_ajax->delTemp($ip);
		echo json_encode($spbNumber);
	}

	function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}