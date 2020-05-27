<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Cetakbom extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		

		
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CetakBOMRouting/M_cetakbom');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){
			
		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Cetak BOM Routing';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CetakBOMRouting/V_SearchDataBOM');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
	public function suggestproduk()
	{
		$term = $this->input->get('term',TRUE);
		// $term = strtoupper($term);
		$data = $this->M_cetakbom->selectproduk($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
		
	}

	public function getkomponen()
	{
		$term	= $this->input->post('segment1');
		$komponen=$this->M_cetakbom->getkomponen($term);

		echo '<option></option>';
		foreach ($komponen as $komp) {
			echo '<option value="'.$komp['SEGMENT1'].'">'.$komp['SEGMENT1'].' - '.$komp['DESCRIPTION'].'</option>';
		}
	}
		public function getseksi()
	{
		$term	= $this->input->post('segment1');
		if ($term=='ODM') {
			$seksi=$this->M_cetakbom->getseksiodm();	
			foreach ($seksi as $s) {
			echo '<option value="'.$s['ROUTING_CLASS'].'">'.$s['ROUTING_CLASS'].'</option>';
			}
		} elseif ($term=='OPM') {
			echo '<option></option>';	
		}

	
	}

	public function CetakBOM()
	{
		$kode = $this->input->post('comp');
		$seksi = $this->input->post('seksi');
		$produk = $this->input->post('prodd');
		$organization = $this->input->post('org');
		$tipe = $this->input->post('typeCetak');

		$desckomp = $this->M_cetakbom->getdesckomponen($kode);
		$descprod = $this->M_cetakbom->selectprodukdesc($produk);
		$data['kode'] = $kode;


		 $data['user'] = $this->session->user;        
		 $nama = $this->M_cetakbom->getNama($this->session->user);
		 // echo "<pre>";print_r($nama[0]['nama']);
		 // exit();

		 $name= $this->SingkatNama($nama[0]['nama'], 2);

		// echo "<pre>";print_r($kode);exit();

		if ($tipe== null) {
			$tipe = 'N';
		}

		if ($organization =='ODM') {
			$datapdf = $this->M_cetakbom->getdatapdf($kode,$seksi);
			$datapdf2 = $this->M_cetakbom->getdatapdf2($kode);

			$array_pdf = array();
			$i=0;
			foreach ($datapdf as $pdf) {

				// $array_pdf[$i]['PROSES'] = $pdf['PROSES'];
				$array_pdf[$i]['KODE_PROSES'] = $pdf['KODE_PROSES'];
				$array_pdf[$i]['RESOURCE_CODE'] = $pdf['RESOURCE_CODE'];
				$array_pdf[$i]['NO_MESIN'] = $pdf['NO_MESIN'];
				$array_pdf[$i]['USAGE_RATE_OR_AMOUNT'] = $pdf['USAGE_RATE_OR_AMOUNT'];
				$array_pdf[$i]['MACHINE_QT'] = $pdf['MACHINE_QT'];
				$array_pdf[$i]['ALTERNATE_ROUTING'] = $pdf['ALT'];
				$array_pdf[$i]['OPT_QTY'] = $pdf['OPT_QTY'];
				$array_pdf[$i]['CYCLE_TIME'] = round($pdf['CT'],2);
				$array_pdf[$i]['TARGET'] = floor($pdf['TARGET']);
				$array_pdf[$i]['OPR_NO'] = $pdf['OPR_NO'];
				$array_pdf[$i]['LAST_UPDATE_DATE'] = $pdf['LAST_UPDATE_DATE'];
				$array_pdf[$i]['P1'] = $pdf['P1'];
				$array_pdf[$i]['P2'] = $pdf['P2'];
				$array_pdf[$i]['P3'] = $pdf['P3'];
				$array_pdf[$i]['P4'] = $pdf['P4'];
				$array_pdf[$i]['P5'] = $pdf['P5'];

				$i++;
			}

			$data['datapdf'] = $array_pdf;
			$data['datapdf2'] = $datapdf2;

		// 	$kodeproses = array();
		// 	foreach ($datapdf as $pdfs) {
		// 		$kodek="";
		// 		$kodek .= $pdfs['RESOURCE_CODE'];
		// 		array_push($kodeproses, $kodek);

		// 	}

		// // echo "<pre>"; print_r($datapdf); exit();

		// 	$altkode = array();
		// 	foreach ($datapdf2 as $pdf2) {
		// 		$kodei="";
		// 		$kodei .= $pdf2['ALT'];
		// 		array_push($altkode, $kodei);

		// 	}

		// 	$kodee = array_count_values($kodeproses);
		// 	$alt = array_count_values($altkode);
		// 	$data['kodee'] = $kodee;
		// 	$data['alt'] = $alt;

		} else if ($organization == 'OPM') {

			$dataopm1 = $this->M_cetakbom->dataopm1($kode);
			$dataopm2 =  $this->M_cetakbom->dataopm2($dataopm1[0]['ROUTING_ID']);
			$dataopm3 =  $this->M_cetakbom->dataopm3($dataopm1[0]['FORMULA_ID']);

			$data['dataopm1'] = $dataopm1;
			$data['dataopm2'] = $dataopm2;
			$data['dataopm3'] = $dataopm3;

			
		}

		// echo "<pre>";print_r($dataopm2);exit();
	

	

		$data['name'] = $name;
		$data['seksi'] = $seksi;
		$data['produk'] = $produk;
		$data['organization'] = $organization;
		$data['desckomp'] = $desckomp[0]['DESCRIPTION'];
		$data['descprod'] = $descprod[0]['DESCRIPTION'];
		
		// print_r(); exit();


		// echo "<pre>";print_r($datapdf);exit();

		ob_start();
		$this->load->library('pdf');
    	$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8','f4', 0, '', 3, 3, 30, 25, 3, 3); //----- A5-L
		$tglNama = date("d/m/Y-H:i:s");
    	$filename = 'BOM_Routing_'.$tglNama.'.pdf';
		$head = $this->load->view('CetakBOMRouting/V_CetakanHead', $data, true);
		if ($tipe == 'Y') {
			$html = $this->load->view('CetakBOMRouting/V_Cetakan_Detail', $data, true);
		} elseif ($tipe == 'N'){
			if ($organization == 'ODM') {
				$html = $this->load->view('CetakBOMRouting/V_Cetakan', $data, true);
			} else {
				$html = $this->load->view('CetakBOMRouting/V_CetakanOPM', $data, true);

			}
		}
    	$foot = $this->load->view('CetakBOMRouting/V_CetakanFoot', $data, true);	

		ob_end_clean();
		$pdf->setHTMLHeader($head);	
    	$pdf->WriteHTML($html);	
  		$pdf->setHTMLFooter($foot);												//-----> Pakai Library MPDF

    	$pdf->Output($filename, 'I');
	}

	public function SingkatNama($nama, $jumlah_Kata)
	{
		$array_Nama = explode(" ",$nama);
		$nama_Jadi = '';

		// echo "<pre>";print_r($array_Nama);

		for ($i=0; $i < sizeof($array_Nama); $i++) { 
			if ($i < $jumlah_Kata) {
				if($i == 0){
					$nama_Jadi = $array_Nama[$i];    
				} else {
					$nama_Jadi = $nama_Jadi.' '.$array_Nama[$i];        
				}
				
			} else{
				if($i == $jumlah_Kata){
					$nama_Jadi = $nama_Jadi.' .'.substr($array_Nama[$i], 0,1);
				} else {
					$nama_Jadi = $nama_Jadi.'.'.substr($array_Nama[$i], 0,1);
				}
			}
		}

		return $nama_Jadi;
	}


}