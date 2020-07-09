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
			redirect('');
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
		$html = '<option></option>';
		if ($term=='ODM') {
			$seksi=$this->M_cetakbom->getseksiodm();	
			foreach ($seksi as $s) {
			$html = $html.'<option value="'.$s['ROUTING_CLASS'].'">'.$s['ROUTING_CLASS'].'</option>';
			}
			echo $html;
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

			$array_Resource2 = array();
			for ($i=0; $i < sizeof($datapdf2); $i++) {
				if ($datapdf2[$i]['ALT'] == null) {
					$alter2[$i] = 'Primary';
				} else {
					$alter2[$i] = $datapdf2[$i]['ALT'];
				}
					$array_Resource2['ALT'][$alter2[$i]][$i] = $datapdf2[$i]['COMPONENT_NUM'];
					$array_Resource2['BILL_SEQUENCE_ID'][$datapdf2[$i]['BILL_SEQUENCE_ID']][$i] = $datapdf2[$i]['COMPONENT_NUM'];
			}

			$array_Resource = array();
			for ($i=0; $i < sizeof($datapdf); $i++) {
				if ($datapdf[$i]['ALT'] == null) {
					$alter[$i] = 'Primary';
				} else {
					$alter[$i] = $datapdf[$i]['ALT'];
				}
					$array_Resource['ALT'][$alter[$i]][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['ROUTING_SEQUENCE_ID'][$datapdf[$i]['ROUTING_SEQUENCE_ID']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['OPERATION_SEQUENCE_ID'][$datapdf[$i]['OPERATION_SEQUENCE_ID']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['OPR_NO'][$datapdf[$i]['OPR_NO']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['KODE_PROSES'][$datapdf[$i]['KODE_PROSES']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['RESOURCE_CODE'][$datapdf[$i]['RESOURCE_CODE']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['MACHINE_QT'][$datapdf[$i]['MACHINE_QT']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['OPT_QTY'][$datapdf[$i]['OPT_QTY']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['USAGE_RATE_OR_AMOUNT'][$datapdf[$i]['USAGE_RATE_OR_AMOUNT']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['CYCLE_TIME'][$datapdf[$i]['CT']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['TARGET'][$datapdf[$i]['TARGET']][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['LAST_UPDATE_DATE'][$datapdf[$i]['LAST_UPDATE_DATE']][$i] = $datapdf[$i]['NO_MESIN'];
					//P1
					if ($datapdf[$i]['P1'] != null) {
						$p1 = '<br>P1: '.$datapdf[$i]['P1'];
					} else {
						$p1 = '';
					}	
					//P2	
					if ($datapdf[$i]['P2'] != null) {
						$p2 = '<br>P2: '.$datapdf[$i]['P2'];
					} else {
						$p2 = '';
					}
					//P3
					if ($datapdf[$i]['P3'] != null) {
						$p3 = '<br>P3: '.$datapdf[$i]['P3'];
					} else {
						$p3 = '';
					}
					//P4
					if ($datapdf[$i]['P4'] != null) {
						$p4 = '<br>P4: '.$datapdf[$i]['P4'];
					} else {
						$p4 = '';
					}
					//P5
					if ($datapdf[$i]['P5'] != null) {
						$p5 = '<br>P5: '.$datapdf[$i]['P5'];
					} else {
						$p5 = '';
					}

					$detailproses[$i] = $p1.$p2.$p3.$p4.$p5;
					$array_Resource['Detail_Process'][$detailproses[$i]][$i] = $datapdf[$i]['NO_MESIN'];
					$array_Resource['DETAIL'][$datapdf[$i]['DETAIL']][$i] = $datapdf[$i]['NO_MESIN'];

			}
			// echo "<pre>";
			// print_r($array_Resource);
			// exit();

			$array_pdf = array();
			$i=0;
			foreach ($datapdf as $pdf) {

				// $array_pdf[$i]['PROSES'] = $pdf['PROSES'];
				$array_pdf[$i]['KODE_PROSES'] = $pdf['KODE_PROSES'];
				$array_pdf[$i]['RESOURCE_CODE'] = $pdf['RESOURCE_CODE'];
				$array_pdf[$i]['ROUTING_SEQUENCE_ID'] = $pdf['ROUTING_SEQUENCE_ID'];
				$array_pdf[$i]['OPERATION_SEQUENCE_ID'] = $pdf['OPERATION_SEQUENCE_ID'];
				$array_pdf[$i]['NO_MESIN'] = $pdf['NO_MESIN'];
				$array_pdf[$i]['USAGE_RATE_OR_AMOUNT'] = $pdf['USAGE_RATE_OR_AMOUNT'];
				$array_pdf[$i]['MACHINE_QT'] = $pdf['MACHINE_QT'];
				if ($pdf['ALT'] == null) {
					$array_pdf[$i]['ALTERNATE_ROUTING'] = 'Primary';
				} else {
					$array_pdf[$i]['ALTERNATE_ROUTING'] = $pdf['ALT'];
				}
				$array_pdf[$i]['OPT_QTY'] = $pdf['OPT_QTY'];
				$array_pdf[$i]['CYCLE_TIME'] = $pdf['CT'];
				$array_pdf[$i]['TARGET'] = $pdf['TARGET'];
				$array_pdf[$i]['OPR_NO'] = $pdf['OPR_NO'];
				$array_pdf[$i]['LAST_UPDATE_DATE'] = $pdf['LAST_UPDATE_DATE'];
				$array_pdf[$i]['P1'] = $pdf['P1'];
				$array_pdf[$i]['P2'] = $pdf['P2'];
				$array_pdf[$i]['P3'] = $pdf['P3'];
				$array_pdf[$i]['P4'] = $pdf['P4'];
				$array_pdf[$i]['P5'] = $pdf['P5'];
				$array_pdf[$i]['DETAIL'] = $pdf['DETAIL'];
				//P1
				if ($pdf['P1'] != null) {
					$p1 = 'P1: '.$pdf['P1'];
				} else {
					$p1 = '';
				}	
				//P2	
				if ($pdf['P2'] != null) {
					$p2 = '<br>P2: '.$pdf['P2'];
				} else {
					$p2 = '';
				}
				//P3
				if ($pdf['P3'] != null) {
					$p3 = '<br>P3: '.$pdf['P3'];
				} else {
					$p3 = '';
				}
				//P4
				if ($pdf['P4'] != null) {
					$p4 = '<br>P4: '.$pdf['P4'];
				} else {
					$p4 = '';
				}
				//P5
				if ($pdf['P5'] != null) {
					$p5 = '<br>P5: '.$pdf['P5'];
				} else {
					$p5 = '';
				}
				$array_pdf[$i]['detailproses'] = $p1.$p2.$p3.$p4.$p5;

				$i++;
			}
			$data['arrayR'] = $array_Resource;
			$data['arrayR2'] = $array_Resource2;
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
			if ($dataopm1 == null) {
				echo "<br><br> <center> <b>ROUTING / FORMULA TIDAK DITEMUKAN <br> HARAP HUBUNGI PIC TERKAIT !!</b></center>";exit();
			} else {
				// echo "<pre>";print_r($dataopm1);exit();
				$dataopm2 =  $this->M_cetakbom->dataopm2($dataopm1[0]['ROUTING_ID']);
				$dataopm3 =  $this->M_cetakbom->dataopm3($dataopm1[0]['FORMULA_ID']);
				
				for ($i=0; $i < sizeof($dataopm2); $i++) { 
					$activity[$dataopm2[$i]['ACTIVITY']][] = $i;  
				}
				foreach ($activity as $key => $value) {
					$act[] = $key;
				}
				$acti = '';
				for ($i=0; $i < sizeof($act); $i++) { 
					if ($i === (sizeof($act)-1)) {
						$acti = $acti.$act[$i];
					} else {
						$acti = $acti.$act[$i].', ';
					}
					
				}
				
				$data['act'] = $acti;
				$data['dataopm1'] = $dataopm1;
				$data['dataopm2'] = $dataopm2;
				$data['dataopm3'] = $dataopm3;
			}
			
		}

	

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