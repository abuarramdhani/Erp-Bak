<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->model('M_index');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		$zona = $this->M_index->getZonaKHSAll();
		// if (!empty($zona)) {
		// 	foreach ($zona as $key => $value) {
		// 		if ($value['isolasi'] == "Ya") {
		// 			if (strtotime($value['tgl_awal_isolasi']) > strtotime(date('Y-m-d')) || strtotime($value['tgl_akhir_isolasi']) < strtotime(date('Y-m-d'))) {
		// 				$zona[$key]['isolasi'] = "Tidak";
		// 			}
		// 		}
		// 	}
		// }
		$data['zona'] = $zona;
		
		$this->load->view('V_Index', $data);
	}
}
