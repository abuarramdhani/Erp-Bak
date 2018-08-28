<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Ajax extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->model('Warehouse/Ajax/M_ajax');
        $this->load->model('Warehouse/MainMenu/M_transaction');
    }
	
	public function getSPB()
	{
		$id = $this->input->post('nomerSPB');
		$SubInv = $this->M_ajax->getSubInv($id);
		if (empty($SubInv)) {
			echo "Data is Empty";
		} else {
			$data['spb'] = $this->M_ajax->getSPB($id, $SubInv[0]['FROM_SUBINVENTORY_CODE']);
			$this->load->view('Warehouse/Ajax/TransactionSPB/V_Spb',$data);
		}
	}
	
	public function PackingList()
	{
		$id = $this->input->post('nomerSPB');
		$data['nomerspb'] 	= $id;
		$SubInv 			= $this->M_ajax->getSubInv($id);
		$data['spb'] 		= $this->M_ajax->getSPB($id, $SubInv[0]['FROM_SUBINVENTORY_CODE']);
		$data['ekpedisi'] 	= $this->M_ajax->getEkpedisi($id);
		$lastPackCode 		= $this->M_ajax->getLastPackCode($id);
		if (empty($lastPackCode)) {
			$data['last_pack'] = 1;
		}else{
			$data['last_pack'] = intval($lastPackCode[0]['LASTPACKNUMBER'])+1;
		}
		if ($SubInv || $data['spb'] ) {
			$this->load->view('Warehouse/Ajax/TransactionPackingList/V_PackingList',$data);
		}else{
			echo "Data is empty";
		}
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

		$temp = array();
		foreach ($item_id as $key => $value) {
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
					'RECEIVED_QTY' 		=> NULL
				);

				$this->M_transaction->insertPacking($dt);
				array_push($temp, $dt);
			}
		}

		echo json_encode($temp);
	}
}