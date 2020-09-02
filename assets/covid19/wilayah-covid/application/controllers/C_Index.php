<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->model('M_index');
    }


	public function index() {
		$data['data'] = $this->M_index->getLastData();
		$data['status_kondisi'] = $this->M_index->getStatusKondisi();
		$this->load->view('V_Index',$data);
	}
}
