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
		$data['spb'] = $this->M_ajax->getSPB($id);
		$this->load->view('Warehouse/Ajax/TransactionSPB/V_Spb',$data);
	}
	
	public function PackingList()
	{
		$id = $this->input->post('nomerSPB');
		$data['nomerspb'] = $id;
		$data['spb'] = $this->M_ajax->getSPB($id);
		$this->load->view('Warehouse/Ajax/TransactionPackingList/V_PackingList',$data);
	}

	public function setPacking()
	{
		$spbNumber		= $this->input->post('spbNumber');
		$packingNumber	= $this->input->post('packingNumber');
		$item_id 		= $this->input->post('item_id');
		$packingqty 	= $this->input->post('packingqty');
		$kemasan		= $this->input->post('kemasan');
		$ekspedisi		= $this->input->post('ekspedisi');
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