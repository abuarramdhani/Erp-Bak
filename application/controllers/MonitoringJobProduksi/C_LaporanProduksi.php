<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_LaporanProduksi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringJobProduksi/M_laporan');

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

		$data['Title'] = 'Laporan Produksi';
		$data['Menu'] = 'Laporan Produksi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kategori'] = $this->M_laporan->getCategory('order by category_name');
        // echo "<pre>";print_r($getdata);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_Laporan', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getSubinv(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_laporan->getSubinv($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function search(){
		$bulan 		= $this->input->post('bulan');
		$bln		= explode("/", $bulan);
        $kategori 	= $this->input->post('kategori');
		$asal 		= $this->input->post('asal');
		$subinv_from = $this->input->post('subinv_from');
		$subinv_to 	= $this->input->post('subinv_to');
		$hari 		= $this->jumlahHari($bln);
		if ($asal == 'TRANSAKSI') {
			$subfrom = $subto ='';
			for ($s=0; $s < count($subinv_from) ; $s++) { 
				$subfrom = $s == 0 ? "'".$subinv_from[$s]."'" : $subfrom.", '".$subinv_from[$s]."'";
			}
			for ($s=0; $s < count($subinv_to) ; $s++) { 
				$subto = $s == 0 ? "'".$subinv_to[$s]."'" : $subto.", '".$subinv_to[$s]."'";
			}
			$subinv		= "and fin.SUBINV in ($subfrom) and fin.TRF_SUBINV in ($subto) 
							order by fin.description, fin.CATEGORY_NAME, fin.SUBCATEGORY_NAME, fin.TANGGAL";
			$kode		= 1;
		}else {
			$subinv		= "order by fin.CATEGORY_NAME, fin.ID_SUBCATEGORY";
			$kode		= 2;
		}
		
		if ($kategori == 15) { //kategori SPAREPART
			$getdata = $this->M_laporan->getdataLaporanSP($kategori, $bulan);
			$olah 	= $this->olah_data_sp($getdata, $asal, $hari, $bln[1].$bln[0]);
		}else {
			$getdata = $this->M_laporan->getdataLaporan($kategori, $bulan, $subinv, $kode);
			$olah 	= $this->olah_data($getdata, $asal, $hari, $kategori, $bln[1].$bln[0]);
		}
		usort($olah[0], function($y, $z) {
			return strcasecmp($y['DESKRIPSI'], $z['DESKRIPSI']);
		});
			
		$data['data'] = $olah[0];
		$data['total'] = $olah[1];
		$data['hari'] = $hari;
		$data['kategori'] = $kategori;
		$data['bulan'] = $bulan;
		// echo "<pre>";print_r($data);exit();
		$this->load->view('MonitoringJobProduksi/V_TblLaporan', $data);
	}	

	public function olah_data($getdata, $asal, $hari, $kategori, $bulan){
		$no = 0;
		$datanya = $subcategory = $itemnya = array();
		$total['REAL_PROD'] = $total['TARGET'] = 0;
		for ($h=1; $h < $hari+1 ; $h++) { 
			$h2 = sprintf("%02d", $h);
			$total['TANGGAL'.$h2.''] = 0;
		}
        foreach ($getdata as $key => $val) {
			if ((!in_array($val['DESCRIPTION'], $itemnya) && $asal == 'TRANSAKSI') || (!in_array($val['SUBCATEGORY_NAME'], $subcategory) && $asal == 'COMPLETION')) {
				if ($asal == 'TRANSAKSI') {
					array_push($itemnya, $val['DESCRIPTION']);
					$item = $val['ITEM'];
					$desc = $val['DESCRIPTION'];
				}else {
					array_push($subcategory, $val['SUBCATEGORY_NAME']);
					$item = $desc = $val['SUBCATEGORY_NAME'];
					array_push($itemnya, $val['ITEM']);
				}
				$datanya[$no] = array(
									'ITEM' 				=> $item,
									'DESKRIPSI' 		=> $desc,
									'ID_CATEGORY' 		=> $val['ID_CATEGORY'],
									'CATEGORY_NAME' 	=> $val['CATEGORY_NAME'],
									'BULAN' 			=> $val['BULAN'],
									'QTY' 				=> $val['QTY'],
									'REAL_PROD' 		=> $val['QTY'],
									'TARGET' 			=> $val['TARGET'],
				);
				$total['REAL_PROD'] += $val['QTY'];
				$total['TARGET'] += $val['TARGET'];
				for ($h=1; $h < $hari+1 ; $h++) { 
					$h2 = sprintf("%02d", $h);
					$datanya[$no]['TANGGAL'.$h2.''] = 0;
				}
				$tgl = explode('-', $val['TANGGAL']);
				$total['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$datanya[$no]['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$no++;
			}else {
				$tgl = explode('-', $val['TANGGAL']);
				$datanya[$no-1]['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$total['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$datanya[$no-1]['REAL_PROD'] += $val['QTY'];
				$total['REAL_PROD'] += $val['QTY'];
			}
		}

		if ($asal == 'TRANSAKSI' && !empty($datanya)) {
			$dataitem = $this->M_laporan->getItem2($kategori, $bulan);
			foreach ($dataitem as $key2 => $value) {
				if (!in_array($value['DESCRIPTION'], $itemnya)) {
					array_push($itemnya, $value['DESCRIPTION']);
					$datanya[$no] = array(
						'ITEM' 				=> $value['ITEM'],
						'DESKRIPSI' 		=> $value['DESCRIPTION'],
						'ID_CATEGORY' 		=> $kategori,
						'CATEGORY_NAME' 	=> '',
						'BULAN' 			=> '',
						'QTY' 				=> '',
						'REAL_PROD' 		=> '',
						'TARGET' 			=> $value['TARGET'],
					);
					$total['TARGET'] += $value['TARGET'];
					for ($h=1; $h < $hari+1 ; $h++) { 
						$h2 = sprintf("%02d", $h);
						$datanya[$no]['TANGGAL'.$h2.''] = '';
					}
					$no++;
				}
			}
		}else if($asal == 'COMPLETION' && !empty($datanya)){
			$dataitem = $this->M_laporan->getsubcategory($kategori, $bulan);
			foreach ($dataitem as $key3 => $value) {
				if (!in_array($value['SUBCATEGORY_NAME'], $subcategory)) {
					array_push($subcategory, $value['SUBCATEGORY_NAME']);
					$datanya[$no] = array(
						'ITEM' 				=> $value['SUBCATEGORY_NAME'],
						'DESKRIPSI' 		=> $value['SUBCATEGORY_NAME'],
						'ID_CATEGORY' 		=> $kategori,
						'CATEGORY_NAME' 	=> '',
						'BULAN' 			=> '',
						'QTY' 				=> '',
						'REAL_PROD' 		=> '',
						'TARGET' 			=> $value['TARGET'],
					);
					for ($h=1; $h < $hari+1 ; $h++) { 
						$h2 = sprintf("%02d", $h);
						$datanya[$no]['TANGGAL'.$h2.''] = '';
					}
					$no++;
				}
			}
			$total['TARGET'] = 0;
			foreach ($datanya as $key4 => $dat) {
				foreach ($dataitem as $key5 => $item) {
					if ($dat['ITEM'] == $item['SUBCATEGORY_NAME']) {
						$datanya[$key4]['TARGET'] = $item['TARGET'];
						$key4 == 0 ? $total['TARGET'] = $item['TARGET'] : $total['TARGET'] += $item['TARGET'];
					}
				}
			}
		}

		return array($datanya, $total);
	}

	public function olah_data_sp($getdata, $asal, $hari, $bulan){
		$no = 0;
		$datanya = $subcategory = $itemnya = array();
		$total['REAL_PROD'] = $total['TARGET'] = $total['WOS_JOB'] = $total['COMPLETION'] = 0;
		for ($h=1; $h < $hari+1 ; $h++) { 
			$h2 = sprintf("%02d", $h);
			$total['TANGGAL'.$h2.''] = 0;
		}
        foreach ($getdata as $key => $val) {
			if ((!in_array($val['DESCRIPTION'], $itemnya) && $asal == 'TRANSAKSI') || (!in_array($val['SUBCATEGORY_NAME'], $subcategory) && $asal == 'COMPLETION')) {
				if ($asal == 'TRANSAKSI') {
					array_push($itemnya, $val['DESCRIPTION']);
					$item = $val['ITEM'];
					$desc = $val['DESCRIPTION'];
				}else {
					array_push($subcategory, $val['SUBCATEGORY_NAME']);
					$item = $desc = $val['SUBCATEGORY_NAME'];
					array_push($itemnya, $val['ITEM']);
				}
				$datanya[$no] = array(
									'ITEM' 				=> $item,
									'DESKRIPSI' 		=> $desc,
									'ID_CATEGORY' 		=> $val['ID_CATEGORY'],
									'CATEGORY_NAME' 	=> $val['CATEGORY_NAME'],
									'QTY' 				=> $val['QTY'],
									'TARGET' 			=> $val['TARGET'],
									'WOS_JOB' 			=> $val['WOS_JOB'],
									'COMPLETION' 		=> $val['COMPLETION'],
									'REAL_PROD' 		=> $val['QTY'],
				);
				$total['REAL_PROD'] += $val['QTY'];
				$total['TARGET'] += $val['TARGET'];
				$total['WOS_JOB'] += $val['WOS_JOB'];
				$total['COMPLETION'] += $val['COMPLETION'];
				for ($h=1; $h < $hari+1 ; $h++) { 
					$h2 = sprintf("%02d", $h);
					$datanya[$no]['TANGGAL'.$h2.''] = 0;
				}
				$tgl = explode('-', $val['TANGGAL']);
				$total['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$datanya[$no]['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$no++;
			}else {
				$tgl = explode('-', $val['TANGGAL']);
				$datanya[$no-1]['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$datanya[$no-1]['REAL_PROD'] += $val['QTY'];
				$total['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$total['REAL_PROD'] += $val['QTY'];
				if ($asal == 'COMPLETION' && !in_array($val['ITEM'], $itemnya)) {
					array_push($itemnya, $val['ITEM']);
					$datanya[$no-1]['WOS_JOB'] += $val['WOS_JOB'];
					$datanya[$no-1]['COMPLETION'] += $val['COMPLETION'];
					$total['WOS_JOB'] += $val['WOS_JOB'];
					$total['COMPLETION'] += $val['COMPLETION'];
				}
			}
		}

		$dataitem = $this->M_laporan->getsubcategory(15, $bulan);
		foreach ($dataitem as $key => $value) {
			if (!in_array($value['SUBCATEGORY_NAME'], $subcategory)) {
				array_push($subcategory, $value['SUBCATEGORY_NAME']);
				$datanya[$no] = array(
					'ITEM' 				=> $value['SUBCATEGORY_NAME'],
					'DESKRIPSI' 		=> $value['SUBCATEGORY_NAME'],
					'ID_CATEGORY' 		=> 15,
					'CATEGORY_NAME' 	=> '',
					'BULAN' 			=> '',
					'QTY' 				=> '',
					'TARGET' 			=> $value['TARGET'],
					'WOS_JOB' 			=> '',
					'COMPLETION' 		=> '',
					'REAL_PROD' 		=> '',
				);
				$total['TARGET'] += $value['TARGET'];
				for ($h=1; $h < $hari+1 ; $h++) { 
					$h2 = sprintf("%02d", $h);
					$datanya[$no]['TANGGAL'.$h2.''] = '';
				}
				$no++;
			}
		}
		
		return array($datanya, $total);
	}
	
	public function jumlahHari($bulan){
        if ($bulan[0] == '01' || $bulan[0] == '03' || $bulan[0] == '05' || $bulan[0] == '07' || $bulan[0] == '08' || $bulan[0] == '10' || $bulan[0] == '12') {
            $hari = 31;
        }elseif ($bulan[0] == '04' || $bulan[0] == '06' || $bulan[0] == '09' || $bulan[0] == '11') {
            $hari = 30;
        }elseif ($bulan[0] == '02') {
            if ($bulan[1]%4 == 0) {
                $hari = 29;
            }else {
                $hari = 28;
            }
		}
		return $hari;
	}
	
	public function laporan_produksi_pdf2(){
		$tanggal = date('d');
		if ($tanggal <= 7) {
			$data['tanggal'] = $tanggal;
		}elseif ($tanggal > 7 && $tanggal <= 14) {
			$data['tanggal'] = $tanggal - 1;
		}elseif ($tanggal > 14 && $tanggal <= 21) {
			$data['tanggal'] = $tanggal - 2;
		}elseif ($tanggal > 21 && $tanggal <= 28) {
			$data['tanggal'] = $tanggal - 3;
		}else {
			$data['tanggal'] = $tanggal - 4;
		}
		// $bln		= explode("/", date('m/Y'));
		$bulan 		= $this->input->post('bulan');
		$bln		= explode("/", $bulan[0]);
		$hari 		= $this->jumlahHari($bln);
		$kategori	= $this->M_laporan->getCategory('order by category_name');
		// echo "<pre>";print_r($bulan);exit();

		$no = 0;
		$datanya = $subcategory = $category = $itemnya = array();
		foreach ($kategori as $key => $kat) {
			$jdw = explode(", ", $kat['MONTH']);
			if ($kat['ID_CATEGORY'] == 13 || $kat['ID_CATEGORY'] == 14) { // kategori VERZINC dan IMPLEMEN
				$getdata = in_array($bln[0], $jdw) ? $this->M_laporan->getdataLaporanCompletion($kat['ID_CATEGORY'], $bulan[0]) : array();
				$asal = 'COMPLETION';
				$olah = $this->olah_data($getdata, $asal, $hari, $kat['ID_CATEGORY'], $bln[1].$bln[0]);
			}elseif ($kat['ID_CATEGORY'] == 15) { // kategori SPAREPART
				$getdata = in_array($bln[0], $jdw) ? $this->M_laporan->getdataLaporanSP($kat['ID_CATEGORY'], $bulan[0]) : array();
				$asal = 'COMPLETION';
				$olah = $this->olah_data_sp($getdata, $asal, $hari, $bln[1].$bln[0]);
			}else {
				if ($kat['ID_CATEGORY'] == 1) { // kategori PACKAGING BODY SET
					$tujuan = "'INT-ASSY', 'INT-PAINT'";
				}elseif ($kat['ID_CATEGORY'] == 2) { // kategori PACKAGING HANDLE BAR
					$tujuan = "'INT-PAINT'";
				}else {
					$tujuan = "'INT-ASSY'";
				}
				$getdata = in_array($bln[0], $jdw) ? $this->M_laporan->getdataLaporanTransaksi($kat['ID_CATEGORY'], $bulan[0], $tujuan) : array();
				$asal = 'TRANSAKSI';
				$olah = $this->olah_data($getdata, $asal, $hari, $kat['ID_CATEGORY'], $bln[1].$bln[0]);
			}
			
			if (!empty($olah[0])) {
				usort($olah[0], function($y, $z) {
					return strcasecmp($y['DESKRIPSI'], $z['DESKRIPSI']);
				});
				$datanya[$kat['CATEGORY_NAME']] = $olah[0];
				$total[$kat['CATEGORY_NAME']] = $olah[1];
			}		
		}
		// echo "<pre>";print_r($datanya);exit();
        $data['data'] = $datanya;
        $data['total'] = $total;
		$data['hari'] = $hari;

		$this->load->library('Pdf');
		$pdf 		= $this->pdf->load();
		$pdf		= new mPDF('utf-8','f4-L', 0, '', 5, 5, 5, 5, 7, 4);
		$filename 	= 'Laporan-Produksi-'.$data['kategori'].'-'.$data['bulan'].'.pdf';
		$x = 0;
		
		$html 	= $this->load->view('MonitoringJobProduksi/V_PdfLaporanFull', $data, true);	
			
		ob_end_clean();
		$pdf->WriteHTML($html);	
		// $pdf->debug = true; 
		$pdf->Output($filename, 'I');
	}

	public function laporan_produksi_pdf(){
		$tanggal = date('d');
		if ($tanggal <= 7) {
			$data['tanggal'] = $tanggal;
		}elseif ($tanggal > 7 && $tanggal <= 14) {
			$data['tanggal'] = $tanggal - 1;
		}elseif ($tanggal > 14 && $tanggal <= 21) {
			$data['tanggal'] = $tanggal - 2;
		}elseif ($tanggal > 21 && $tanggal <= 28) {
			$data['tanggal'] = $tanggal - 3;
		}else {
			$data['tanggal'] = $tanggal - 4;
		}
		$data['data'] = $this->getdataLaporan();
		// echo "<pre>";print_r($data);exit();
		$this->load->library('Pdf');
		$pdf 		= $this->pdf->load();
		$pdf		= new mPDF('utf-8','f4-L', 0, '', 5, 5, 10, 10, 7, 4);
		$filename 	= 'Laporan-Produksi-'.$data['kategori'].'-'.$data['bulan'].'.pdf';
		$x = 0;
		
		// $head 	= $this->load->view('MonitoringJobProduksi/V_HeaderLaporan', $data, true);	
		$html 	= $this->load->view('MonitoringJobProduksi/V_PdfLaporan', $data, true);	
			
		ob_end_clean();
		// $pdf->SetHTMLHeader($head);		
		$pdf->WriteHTML($html);	
		// $pdf->debug = true; 
		$pdf->Output($filename, 'I');
	}

	
	public function DownloadExcel(){
		$data = $this->getdataLaporan();
		
		include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
					->setLastModifiedBy('Quick')
					->setTitle("Monitoring Job Produksi")
					->setSubject("CV. KHS")
					->setDescription("Monitoring Job Produksi")
					->setKeywords("MJP");
		
		$style_title = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style1 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				// 'color' => array('rgb' => 'bdeefc'),
				'color' => array('rgb' => 'E6E8E6'),
			),
			'font' => array(
				'bold' => true,
			), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style2 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true,
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style3 = array(
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		$style4 = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'E6E8E6'),
			),
			'alignment' => array(
				'vertical'	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
			
		);
		
		if ($data['hari'] == 31) {
			$akhir 	= 'AG';
			$plus1 	= 'AH';
			$plus2 	= 'AI';
			$plus3 	= 'AJ';
			$plus4 	= 'AK';
			$plus5 	= 'AL';
			$plus6 	= 'AM';
			$plus7 	= 'AN';
		}elseif ($data['hari'] == 30) {
			$akhir 	= 'AF';
			$plus1 	= 'AG';
			$plus2 	= 'AH';
			$plus3 	= 'AI';
			$plus4 	= 'AJ';
			$plus5 	= 'AK';
			$plus6 	= 'AL';
			$plus7 	= 'AM';
		}elseif ($data['hari'] == 29){
			$akhir 	= 'AE';
			$plus1 	= 'AF';
			$plus2	= 'AG';
			$plus3 	= 'AH';
			$plus4 	= 'AI';
			$plus5 	= 'AJ';
			$plus6 	= 'AK';
			$plus7 	= 'AL';
		}else {
			$akhir 	= 'AD';
			$plus1 	= 'AE';
			$plus2 	= 'AF';
			$plus3 	= 'AG';
			$plus4 	= 'AH';
			$plus5 	= 'AI';
			$plus6 	= 'AJ';
			$plus7 	= 'AK';
		}

		//TITLE
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PRODUKSI"); 
		$excel->getActiveSheet()->mergeCells("A1:".$plus3."1"); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Kategori"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B2', ": ".$data['kategori']); 
		
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "Bulan"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B3', ": ".$data['bulan']); 
		$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "PRODUK");
		$excel->setActiveSheetIndex(0)->setCellValue('C5', "PRODUKSI");
		if ($data['id_kategori'] == 15) { // khusus kategori sparepart
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus1."5", "TARGET");
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus2."5", "WOS / JOB");
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus3."5", "% JOB PPIC");
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus4."5", "COMPLETION INT ASSY + NO PACKG");
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus5."5", "% COMPLETION ASSY");
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus6."5", "IN YSP");
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus7."5", "YSP");
		}else {
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus1."5", "REAL PROD");
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus2."5", "TARGET");
			$excel->setActiveSheetIndex(0)->setCellValue("".$plus3."5", "PENCAPAIAN PRODUKSI(%)");
		}
		$excel->getActiveSheet()->mergeCells("A5:A6"); 
		$excel->getActiveSheet()->mergeCells("B5:B6"); 
		$excel->getActiveSheet()->mergeCells("C5:".$akhir."5");
		$excel->getActiveSheet()->mergeCells("".$plus1."5:".$plus1."6");
		$excel->getActiveSheet()->mergeCells("".$plus2."5:".$plus2."6");
		$excel->getActiveSheet()->mergeCells("".$plus3."5:".$plus3."6");
		if ($data['id_kategori'] == 15) { // khusus kategori sparepart
		$excel->getActiveSheet()->mergeCells("".$plus4."5:".$plus4."6");
		$excel->getActiveSheet()->mergeCells("".$plus5."5:".$plus5."6");
		$excel->getActiveSheet()->mergeCells("".$plus6."5:".$plus6."6");
		$excel->getActiveSheet()->mergeCells("".$plus7."5:".$plus7."6");
		}
		$row = 6;
		$col = 2;
		for ($i=0; $i < $data['hari'] ; $i++) { //tanggal 1 - akhir
			$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($i+1));
			$col++;
		} 

		$excel->getActiveSheet()->getStyle('A5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B5')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("C5:".$akhir."6")->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("".$plus1."5:".$plus1."6")->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("".$plus2."5:".$plus2."6")->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("".$plus3."5:".$plus3."6")->applyFromArray($style1);
		if ($data['id_kategori'] == 15) {
		$excel->getActiveSheet()->getStyle("".$plus4."5:".$plus4."6")->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("".$plus5."5:".$plus5."6")->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("".$plus6."5:".$plus6."6")->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("".$plus7."5:".$plus7."6")->applyFromArray($style1);
		}
		for ($n=2; $n < ($data['hari']+5) ; $n++) { // styling tanggal col 4 - akhir
			$a = $this->numbertoalpha($n);
			$excel->getActiveSheet()->getStyle("".$a."6")->applyFromArray($style1);
		}

		$no = 1;
		$numrow = 7;
		foreach ($data['value'] as $key => $val) {
			// echo "<pre>";print_r($val);exit();
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['desc']);
			$col = 2;
			for ($i=0; $i < $data['hari'] ; $i++) { //tanggal 1 - akhir
				$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $numrow, $val['tanggal'.($i+1).'']);
				$a = $this->numbertoalpha($col);
				$excel->getActiveSheet()->getStyle("$a$numrow")->applyFromArray($style3);
				$col++;
			} 
			if ($data['id_kategori'] == 15) {
				$excel->setActiveSheetIndex(0)->setCellValue($plus1.$numrow, $val['target']);
				$excel->setActiveSheetIndex(0)->setCellValue($plus2.$numrow, $val['wosjob']);
				$excel->setActiveSheetIndex(0)->setCellValue($plus3.$numrow, $val['wosjob2']);
				$excel->setActiveSheetIndex(0)->setCellValue($plus4.$numrow, $val['completion']);
				$excel->setActiveSheetIndex(0)->setCellValue($plus5.$numrow, $val['completion2']);
				$excel->setActiveSheetIndex(0)->setCellValue($plus6.$numrow, $val['real_prod']);
				$excel->setActiveSheetIndex(0)->setCellValue($plus7.$numrow, $val['kecapaian']);
			}else {
				$excel->setActiveSheetIndex(0)->setCellValue($plus1.$numrow, $val['real_prod']);
				$excel->setActiveSheetIndex(0)->setCellValue($plus2.$numrow, $val['target']);
				$excel->setActiveSheetIndex(0)->setCellValue($plus3.$numrow, $val['kecapaian']);
			}

			$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("B$numrow")->applyFromArray($style2);
			$excel->getActiveSheet()->getStyle("$plus1$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("$plus2$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("$plus3$numrow")->applyFromArray($style3);
			if ($data['id_kategori'] == 15) {
				$excel->getActiveSheet()->getStyle("$plus4$numrow")->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle("$plus5$numrow")->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle("$plus6$numrow")->applyFromArray($style3);
				$excel->getActiveSheet()->getStyle("$plus7$numrow")->applyFromArray($style3);
			}
			$no++;$numrow++;
		}

		//TOTAL
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, 'Total');
		$col = 2;
		for ($i=0; $i < $data['hari'] ; $i++) { //tanggal 1 - akhir
			$excel->getActiveSheet()->setCellValueByColumnAndRow($col, $numrow, $data['ttl_tgl'.($i+1).'']);
			$a = $this->numbertoalpha($col);
			$excel->getActiveSheet()->getStyle("$a$numrow")->applyFromArray($style4);
			$col++;
		} 
		if ($data['id_kategori'] == 15) {
			$excel->setActiveSheetIndex(0)->setCellValue($plus1.$numrow, $data['ttl_target']);
			$excel->setActiveSheetIndex(0)->setCellValue($plus2.$numrow, $data['ttl_wosjob']);
			$excel->setActiveSheetIndex(0)->setCellValue($plus3.$numrow, $data['ttl_wosjob2']);
			$excel->setActiveSheetIndex(0)->setCellValue($plus4.$numrow, $data['ttl_completion']);
			$excel->setActiveSheetIndex(0)->setCellValue($plus5.$numrow, $data['ttl_completion2']);
			$excel->setActiveSheetIndex(0)->setCellValue($plus6.$numrow, $data['ttl_real']);
			$excel->setActiveSheetIndex(0)->setCellValue($plus7.$numrow, $data['ttl_kecapaian']);
		}else {
			$excel->setActiveSheetIndex(0)->setCellValue($plus1.$numrow, $data['ttl_real']);
			$excel->setActiveSheetIndex(0)->setCellValue($plus2.$numrow, $data['ttl_target']);
			$excel->setActiveSheetIndex(0)->setCellValue($plus3.$numrow, $data['ttl_kecapaian']);
		}

		$excel->getActiveSheet()->mergeCells("A$numrow:B$numrow"); 
		$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style4);
		$excel->getActiveSheet()->getStyle("B$numrow")->applyFromArray($style4);
		$excel->getActiveSheet()->getStyle("$plus1$numrow")->applyFromArray($style4);
		$excel->getActiveSheet()->getStyle("$plus2$numrow")->applyFromArray($style4);
		$excel->getActiveSheet()->getStyle("$plus3$numrow")->applyFromArray($style4);
		if ($data['id_kategori'] == 15) {
			$excel->getActiveSheet()->getStyle("$plus4$numrow")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("$plus5$numrow")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("$plus6$numrow")->applyFromArray($style4);
			$excel->getActiveSheet()->getStyle("$plus7$numrow")->applyFromArray($style4);
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); 
		for($col = 'C'; $col !== $plus1; $col++) { // autowidth
			$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		$excel->getActiveSheet()->getColumnDimension($plus1)->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension($plus2)->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension($plus3)->setWidth(15); 
		if ($data['id_kategori'] == 15) {
			$excel->getActiveSheet()->getColumnDimension($plus4)->setWidth(15); 
			$excel->getActiveSheet()->getColumnDimension($plus5)->setWidth(15); 
			$excel->getActiveSheet()->getColumnDimension($plus6)->setWidth(15); 
			$excel->getActiveSheet()->getColumnDimension($plus7)->setWidth(15); 
		}
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(1)->setTitle("Laporan Produksi");
		$excel->setActiveSheetIndex();
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan-Produksi-'.$data['kategori'].'-'.$data['bulan'].'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
	
	public function getdataLaporan(){
		$data['id_kategori'] 	= $this->input->post('kategori');
		$cari_kategori 			= $this->M_laporan->getCategory("where id_category = ".$data['id_kategori']."");
		$data['kategori'] 		= $cari_kategori[0]['CATEGORY_NAME'];
		$data['bulan'] 			= $this->input->post('bulan');
		$data['hari'] 			= $this->input->post('hari');
		$item 					= $this->input->post('item');
		$desc 					= $this->input->post('desc');
		$real_prod 				= $this->input->post('real_prod');
		$target 				= $this->input->post('target');
		$wosjob 				= $this->input->post('wosjob');
		$completion 				= $this->input->post('completion');
		$wosjob2 				= $this->input->post('wosjob2');
		$completion2 				= $this->input->post('completion2');
		$kecapaian 				= $this->input->post('kecapaian');
		for ($i=0; $i < count($item)/2 ; $i++) { 
			$data['value'][$i]['item'] 		= $item[$i];
			$data['value'][$i]['desc'] 		= $desc[$i];
			$data['value'][$i]['real_prod'] = $real_prod[$i];
			$data['value'][$i]['target'] 	= $target[$i];
			$data['value'][$i]['wosjob'] 	= $wosjob[$i];
			$data['value'][$i]['completion'] 	= $completion[$i];
			$data['value'][$i]['wosjob2'] 	= $wosjob2[$i];
			$data['value'][$i]['completion2'] = $completion2[$i];
			$data['value'][$i]['kecapaian'] = $kecapaian[$i];
			for ($t=1; $t < $data['hari']+1 ; $t++) { 
				$tanggal = $this->input->post('tanggal'.$t.'');
				$data['value'][$i]['tanggal'.$t.''] = $tanggal[$i];
			}
		}
		$ttl_real = $this->input->post('ttl_real');
		$ttl_target = $this->input->post('ttl_target');
		$ttl_wosjob = $this->input->post('ttl_wosjob');
		$ttl_completion = $this->input->post('ttl_completion');
		$ttl_wosjob2 = $this->input->post('ttl_wosjob2');
		$ttl_completion2 = $this->input->post('ttl_completion2');
		$ttl_kecapaian = $this->input->post('ttl_kecapaian');
		$data['ttl_real'] = $ttl_real[0];
		$data['ttl_target'] = $ttl_target[0];
		$data['ttl_wosjob'] = $ttl_wosjob[0];
		$data['ttl_completion'] = $ttl_completion[0];
		$data['ttl_wosjob2'] = $ttl_wosjob2[0];
		$data['ttl_completion2'] = $ttl_completion2[0];
		$data['ttl_kecapaian'] = $ttl_kecapaian[0];
		for ($i=1; $i < $data['hari']+1 ; $i++) { 
			$total_tanggal = $this->input->post('ttl_tgl'.$i.'');
			$data['ttl_tgl'.$i.''] = $total_tanggal[0];
		}
		return $data;
		// echo "<pre>";print_r($data);exit();
	}
	
	public function numbertoalpha($n){
		for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
		$r = chr($n%26 + 0x41) . $r;
		return $r;
	}

    
}