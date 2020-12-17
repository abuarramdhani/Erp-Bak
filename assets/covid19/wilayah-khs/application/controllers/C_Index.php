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
		$data['zona'] = $this->M_index->getZonaKHSAll();
		$koordinat = array();
		$tmp = array();
		foreach ($data['zona'] as $k) {
			$kasus = array();
			if (in_array($k['koordinat'], $tmp)) {
				foreach ($koordinat as $key => $value) {
					if ($value['koordinat'] == $k['koordinat']) {
						$koordinat[$key]['detail'][] = array(
							'tgl_awal_isolasi' 	=> $k['tgl_awal_isolasi'],
							'tgl_akhir_isolasi' => $k['tgl_akhir_isolasi'],
							'kasus' 			=> $k['kasus']
						);
					}
				}
			}else{
				$kasus[] = array(
					'tgl_awal_isolasi' 	=> $k['tgl_awal_isolasi'],
					'tgl_akhir_isolasi' => $k['tgl_akhir_isolasi'],
					'kasus' 			=> $k['kasus']
				);
				$koordinat[] = array(
					'koordinat' 	=> $k['koordinat'],
					'nama_seksi' 	=> $k['nama_seksi'],
					'lokasi' 		=> $k['lokasi'],
					'isolasi' 		=> $k['isolasi'],
					'detail' 		=> $kasus
				);
				$tmp[] = $k['koordinat'];
			}
		}
		$data['koordinat_zona'] = $koordinat;
		// echo "<pre>";print_r($data['koordinat_zona']);exit();
		$this->load->view('V_Index', $data);
	}
}
