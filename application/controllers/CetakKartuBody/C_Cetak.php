<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Cetak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('CetakKartuBody/M_cetak');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->library('form_validation');
		$this->load->library('csvimport');
		
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
	
	public function index()
	{
		// $this->checkSession();
		$user_id = $this->session->userid;
		$data['user'] = $this->session->user;
		$data['name'] = $this->session->employee;
		$data['Title'] = 'Cetak Kartu Body';
		$data['Menu'] = 'Cetak Kartu Body';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakKartuBody/V_Cetak',$data);
		$this->load->view('V_Footer',$data);
		
	}

	function getKomponen(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_cetak->getKomponen($term);
		echo json_encode($data);
	}

	public function getData(){
		$komponen 	= $this->input->post('komponen');
		$qty		= $this->input->post('qty');
		$size		= $this->input->post('size');
		$namakomp	= $this->input->post('namakomp');
		$data['size'] = $size;

		$cek		= $this->M_cetak->ceknomor($komponen);
		$tercetak 	= count($cek);
		if ($komponen == 'G 1000 BOXER') {
			$kode = 'B';
		}elseif ($komponen == 'CAKAR BAJA') {
			$kode = 'E';
		}else {
			$kode = 'A';
		}
		if (empty($cek)) {
			$data['tercetak'] = '';
			$cetak = 'A2000000';
		}else {
			$data['tercetak'] = $cek[0]['no_serial'];
			$cetak = $cek[0]['no_serial'];
		}
		$no 	= substr($cetak, 1);
		$awal 	= $no + 1;
		$data['no_awal'] 	= $kode.$awal;
		$akhir 	= $no + $qty;
		$data['no_akhir'] 	= $kode.$akhir;
		$data['komponen']	= $komponen;
		$data['qty']		= $qty;
		$data['ket']		= 'baru';

		// echo "<pre>"; print_r($data);exit();

		$this->load->view('CetakKartuBody/V_Result', $data);
		
	}

	public function getData2(){
		$no_awal 	= $this->input->post('no_awal');
		$size 		= $this->input->post('size');
		$komponen 	= $this->input->post('namakomp');
		$data['ket'] = 'lagi';
		$data['awal'] = $no_awal[0];
		$data['akhir'] = $no_awal[1];
		$selisih	= $no_awal[1] - $no_awal[0] + 1;
		$a = 0;
		$tampung = array();
		if ($komponen[0] == 'G 1000 BOXER') {
			$kode = 'B';
		}elseif ($komponen[0] == 'CAKAR BAJA') {
			$kode = 'E';
		}else {
			$kode = 'A';
		}
		$array = array('no_awal' => $kode.$no_awal[0],
				'no_akhir' => $kode.$no_awal[1],
				'awal' => $no_awal[0],
				'akhir' => $no_awal[1],
				'item' => $komponen[0],
				'jumlah' => $selisih,
				'size' => $size[0]);
		array_push($tampung, $array);
		$data['data'] = $tampung;
		// echo "<pre>";print_r($tampung);exit();

		$this->load->view('CetakKartuBody/V_Result', $data);
	}

	public function generate(){
		$komponen 	= $this->input->post('komponen');
		$qty		= $this->input->post('qty');
		$no_awal	= $this->input->post('no_awal');
		$no_akhir	= $this->input->post('no_akhir');
		$size		= $this->input->post('size');
		$awl 		= substr($no_awal, 1);
		$akh 		= substr($no_akhir, 1);
		$nomor 		= $awl;
		for ($i=0; $i < $qty; $i++) { 
			if ($komponen == 'G 1000 BOXER') {
				$kode = 'B';
			}elseif ($komponen == 'CAKAR BAJA') {
				$kode = 'E';
			}else {
				$kode = 'A';
			}
			// $cek	= $this->M_cetak->ceknomor($komponen);
			$no = $kode.$nomor;
			$this->M_cetak->saveSerial($no, $komponen); 
			$nomor = $nomor + 1;
		}
		redirect('http://produksi.quick.com/cetak-kartu-body/kartubody.php?serial1='.$awl.'&serial2='.$akh.'&produk='.$komponen.'&size='.$size.'');	
	}
	
	public function generateLagi(){
		$komponen 	= $this->input->post('komponen');
		$qty		= $this->input->post('qty');
		$no_awal	= $this->input->post('no_awal');
		// echo "<pre>";print_r($komponen);exit();
		$nomor = $no_awal;
		for ($i=0; $i < $qty; $i++) { 
			if ($komponen == 'G 1000 BOXER') {
				$kode = 'B';
			}elseif ($komponen == 'CAKAR BAJA') {
				$kode = 'E';
			}else {
				$kode = 'A';
			}
			$ceklagi = $this->M_cetak->cekserial($kode.$nomor, $komponen);
			if (empty($ceklagi)) {
				$this->M_cetak->saveSerial($kode.$nomor, $komponen); 
			}
			$nomor = $nomor + 1;
		}
	}


}