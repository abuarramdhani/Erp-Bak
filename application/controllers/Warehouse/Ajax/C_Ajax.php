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
    }
	
	public function getSPB()
	{
		$id = $this->input->post('nomerSPB');
		$data['spb'] = $this->M_ajax->getSPB($id);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('Warehouse/Ajax/TransactionSPB/V_Spb',$data);
	}
}
