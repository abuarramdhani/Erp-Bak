<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_KartuBarang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('CetakKartuGudang/M_kartubrg');
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
		$data['Title'] = 'Cetak Kartu Barang';
		$data['Menu'] = 'Cetak Kartu Barang';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakKartuGudang/V_KartuBarang',$data);
		$this->load->view('V_Footer',$data);
		
	}

	function Cetak(){
		require_once APPPATH.'third_party/Excel/PHPExcel.php';
    	require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';
     
		$file_data  = array();
		// load excel
		$file = $_FILES['excel_file']['tmp_name'];
		$load = PHPExcel_IOFactory::load($file);
		$sheets = $load->getActiveSheet()->toArray(null,true,true,true);

		$size = $this->input->post('size_cetak');
		
		$getdata = array();
		$i = 0;
		foreach ($sheets as $val) {
			if ($i != 0) {
				$desc = $this->M_kartubrg->getdesc($val['A']);
				$array = array(
					'kode' => $val['A'],
					'desc' => $desc[0]['DESCRIPTION'],
					'rak' => $val['B'],
					'qty' => $val['C'],
					'stp' => $val['D'],
					'size' => $size
				);
				array_push($getdata,$array);
			}
			$i++;
		}
		$data['data'] = $getdata;
		// echo "<pre>";print_r($getdata);exit();

		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','f4', 0, '', 3, 13, 0, 5, 0, 0);
		$filename 	= 'CetakKartuBarang.pdf';
		// $tglNama = date("d/m/Y");

		$this->load->library('ciqrcode');

		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}
		
		foreach ($getdata as $val) {
			$params['data']		= $val['kode'];
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './img/'.($val['kode']).'.png';
			$this->ciqrcode->generate($params);
		}

		$html = $this->load->view('CetakKartuGudang/V_pdfKartuBrg', $data, true);
		ob_end_clean();
		$pdf->WriteHTML($html);			
		$pdf->Output($filename, 'I');

	}


	}