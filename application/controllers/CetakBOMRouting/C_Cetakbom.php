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
		$term = strtoupper($term);
		$data = $this->M_cetakbom->selectproduk($term);
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
		} elseif ($term=='OPM') {
			$seksi=$this->M_cetakbom->getseksiopm();		
		}

		echo '<option></option>';
		foreach ($seksi as $s) {
			echo '<option value="'.$s['ROUTING_CLASS'].'">'.$s['ROUTING_CLASS'].'</option>';
		}
	}

	public function CetakBOM()
	{
		$kode = $this->input->post('comp');
		$seksi = $this->input->post('seksi');
		$produk = $this->input->post('prodd');
		$organization = $this->input->post('org');

		$datapdf = $this->M_cetakbom->getdatapdf($kode,$seksi);
		$datapdf2 = $this->M_cetakbom->getdatapdf2($kode);
		$desckomp = $this->M_cetakbom->getdesckomponen($kode);
		$descprod = $this->M_cetakbom->selectprodukdesc($produk);

		 $data['user'] = $this->session->user;        
		 $data['name'] = $this->session->employee;


		// echo "<pre>";print_r($datapdf);exit();


		
		$data['kode'] = $kode;
		$data['seksi'] = $seksi;
		$data['produk'] = $produk;
		$data['organization'] = $organization;
		$data['desckomp'] = $desckomp[0]['DESCRIPTION'];
		$data['descprod'] = $descprod[0]['DESCRIPTION'];

		$kodeproses = array();
		foreach ($datapdf as $pdfs) {
			$kode="";
			$kode .= $pdfs['KODE_PROSES'];
			array_push($kodeproses, $kode);

		}

		// echo "<pre>"; print_r($kodeproses); exit();


		$array_pdf = array();
		$i=0;
		foreach ($datapdf as $pdf) {
			$cycletime = $pdf['USAGE_RATE_OR_AMOUNT']*3600;
			$target = 23400/$cycletime;
			$inverse = $target / 6.5;

			// $array_pdf[$i]['PROSES'] = $pdf['PROSES'];
			$array_pdf[$i]['KODE_PROSES'] = $pdf['KODE_PROSES'];
			$array_pdf[$i]['RESOURCE_CODE'] = $pdf['RESOURCE_CODE'];
			$array_pdf[$i]['NO_MESIN'] = $pdf['NO_MESIN'];
			$array_pdf[$i]['USAGE_RATE_OR_AMOUNT'] = $pdf['USAGE_RATE_OR_AMOUNT'];
			$array_pdf[$i]['MACHINE_QT'] = $pdf['MACHINE_QT'];
			$array_pdf[$i]['ALTERNATE_ROUTING'] = $pdf['ALT'];
			$array_pdf[$i]['OPT_QTY'] = $pdf['OPT_QTY'];
			$array_pdf[$i]['CYCLE_TIME'] = round($cycletime,2);
			$array_pdf[$i]['TARGET'] = floor($target);
			$array_pdf[$i]['INVERSE'] = round($inverse,3);

			$i++;
		}

		$data['datapdf'] = $array_pdf;
		$data['datapdf2'] = $datapdf2;
		$kodee = array_count_values($kodeproses);
		$data['kodee'] = $kodee;
		
		// print_r(); exit();


		// echo "<pre>";print_r($array_pdf);exit();

		ob_start();
		$this->load->library('pdf');
    	$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8','f4', 0, '', 3, 3, 27, 27, 3, 3); //----- A5-L
		$tglNama = date("d/m/Y-H:i:s");
    	$filename = 'BOM_Routing_'.$tglNama.'.pdf';
    	$head = $this->load->view('CetakBOMRouting/V_CetakanHead', $data, true);	
    	$html = $this->load->view('CetakBOMRouting/V_Cetakan', $data, true);
    	$foot = $this->load->view('CetakBOMRouting/V_CetakanFoot', $data, true);	

		ob_end_clean();
		$pdf->setHTMLHeader($head);	
    	$pdf->WriteHTML($html);	
  		$pdf->setHTMLFooter($foot);												//-----> Pakai Library MPDF

    	$pdf->Output($filename, 'I');
	}


}