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
		if ($asal == 'TRANSAKSI') {
			$subfrom = '';
			for ($s=0; $s < count($subinv_from) ; $s++) { 
				$subfrom = $s == 0 ? "'".$subinv_from[$s]."'" : $subfrom.", '".$subinv_from[$s]."'";
			}
			$subinv		= "and fin.SUBINV in ($subfrom) and fin.TRF_SUBINV = '$subinv_to'";
			$kode		= 1;
		}else {
			$subinv		= "";
			$kode		= 2;
		}
		$getdata 	= $this->M_laporan->getdataLaporan($kategori, $bulan, $subinv, $kode);
		$hari 		= $this->jumlahHari($bln);
		// echo "<pre>";print_r($getdata);exit();

		$no = 0;
		$datanya = $subcategory = $itemnya = array();
		$total['REAL_PROD'] = $total['TARGET'] = $total['KECAPAIAN_TARGET'] = 0;
		for ($h=1; $h < $hari+1 ; $h++) { 
			$h2 = sprintf("%02d", $h);
			$total['TANGGAL'.$h2.''] = 0;
		}
        foreach ($getdata as $key => $val) {
			if (!in_array($val['DESCRIPTION'], $itemnya)) {
				array_push($itemnya, $val['DESCRIPTION']);
				$datanya[$no] = array(
									'ITEM' 				=> $val['ITEM'],
									'DESKRIPSI' 		=> $val['DESCRIPTION'],
									'ID_CATEGORY' 		=> $val['ID_CATEGORY'],
									'CATEGORY_NAME' 	=> $val['CATEGORY_NAME'],
									'ID_SUBCATEGORY' 	=> $val['ID_SUBCATEGORY'],
									'SUBCATEGORY_NAME' 	=> $val['SUBCATEGORY_NAME'],
									'SUBINV' 			=> $val['SUBINV'],
									'TRF_SUBINV' 		=> $val['TRF_SUBINV'],
									'BULAN' 			=> $val['BULAN'],
									'QTY' 				=> $val['QTY'],
									'REAL_PROD' 		=> $val['REAL_PROD'],
									'TARGET' 			=> $val['TARGET'],
									'KECAPAIAN_TARGET' 	=> round($val['KECAPAIAN_TARGET'],3)
				);
				$total['REAL_PROD'] += $val['REAL_PROD'];
				$total['TARGET'] += $val['TARGET'];
				$total['KECAPAIAN_TARGET'] += round($val['KECAPAIAN_TARGET'],3);
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
				$datanya[$no-1]['REAL_PROD'] += $val['REAL_PROD'];
				$datanya[$no-1]['TARGET'] += $val['TARGET'];
				$datanya[$no-1]['KECAPAIAN_TARGET'] += round($val['KECAPAIAN_TARGET'],3);
				$datanya[$no-1]['TANGGAL'.$tgl[0].''] += $val['QTY'];
				$total['REAL_PROD'] += $val['REAL_PROD'];
				$total['TARGET'] += $val['TARGET'];
				$total['KECAPAIAN_TARGET'] += round($val['KECAPAIAN_TARGET'],3);
				$total['TANGGAL'.$tgl[0].''] += $val['QTY'];
			}
		}
		// echo "<pre>";print_r($datanya);exit();
		usort($datanya, function($y, $z) {
			return strcasecmp($y['DESKRIPSI'], $z['DESKRIPSI']);
		});

        $data['data'] = $datanya;
        $data['total'] = $total;
		$data['hari'] = $hari;
		$data['kategori'] = $kategori;
		$data['bulan'] = $bulan;
		// echo "<pre>";print_r($datanya);exit();
        $this->load->view('MonitoringJobProduksi/V_TblLaporan', $data);
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
		$bln		= explode("/", date('m/Y'));
		$hari 		= $this->jumlahHari($bln);
		$kategori	= $this->M_laporan->getCategory('order by category_name');
		// $getdata 	= $this->M_laporan->getdataLaporanCompletion();
		// $getdata 	= $this->M_laporan->getdataLaporanTransaksi();
		// echo "<pre>";print_r($getdata);exit();

		$no = 0;
		$datanya = $subcategory = $category = array();
		foreach ($kategori as $key => $kat) {
			if ($kat['CATEGORY_NAME'] == 'VERZINC' || $kat['CATEGORY_NAME'] == 'IMPLEMEN') {
				$getdata = $this->M_laporan->getdataLaporanCompletion($kat['ID_CATEGORY']);
			}else {
				$getdata = $this->M_laporan->getdataLaporanTransaksi($kat['ID_CATEGORY']);
			}
			foreach ($getdata as $key => $val) {
				if (!in_array($val['CATEGORY_NAME'], $category)) {
					array_push($category, $val['CATEGORY_NAME']);
					$itemnya = array();
					$no = 0;
					$total[$val['CATEGORY_NAME']]['REAL_PROD'] = $total[$val['CATEGORY_NAME']]['TARGET'] = $total[$val['CATEGORY_NAME']]['KECAPAIAN_TARGET'] = 0;
					for ($h=1; $h < $hari+1 ; $h++) { 
						$h2 = sprintf("%02d", $h);
						$total[$val['CATEGORY_NAME']]['TANGGAL'.$h2.''] = 0;
					}
				}
				if (!in_array($val['DESCRIPTION'], $itemnya)) {
					array_push($itemnya, $val['DESCRIPTION']);
					$datanya[$val['CATEGORY_NAME']][$no] = array(
						'ITEM' 		=> $val['ITEM'],
						'DESCRIPTION' 		=> $val['DESCRIPTION'],
						'ID_CATEGORY' 		=> $val['ID_CATEGORY'],
						'CATEGORY_NAME' 	=> $val['CATEGORY_NAME'],
						'ID_SUBCATEGORY' 	=> $val['ID_SUBCATEGORY'],
						'SUBCATEGORY_NAME' 	=> $val['SUBCATEGORY_NAME'],
						'SUBINV' 			=> $val['SUBINV'],
						'TRF_SUBINV'		=> $val['TRF_SUBINV'],
						'BULAN' 			=> $val['BULAN'],
						'REAL_PROD' 		=> $val['REAL_PROD'],
						'TARGET' 			=> $val['TARGET'],
						'KECAPAIAN_TARGET' 	=> round($val['KECAPAIAN_TARGET'],3)
					);
					
					$total[$val['CATEGORY_NAME']]['REAL_PROD'] += $val['REAL_PROD'];
					$total[$val['CATEGORY_NAME']]['TARGET'] += $val['TARGET'];
					$total[$val['CATEGORY_NAME']]['KECAPAIAN_TARGET'] += round($val['KECAPAIAN_TARGET'],3);
					for ($h=1; $h < $hari+1 ; $h++) { 
						$h2 = sprintf("%02d", $h);
						$datanya[$val['CATEGORY_NAME']][$no]['TANGGAL'.$h2.''] = 0;
					}
					$tgl = explode('-', $val['TANGGAL']);
					$datanya[$val['CATEGORY_NAME']][$no]['TANGGAL'.$tgl[0].''] += $val['QTY'];
					$total[$val['CATEGORY_NAME']]['TANGGAL'.$tgl[0].''] += $val['QTY'];
					$no++;
				}else {
					$no2 = $val['SUBCATEGORY_NAME'] = '' ? $no : $no-1;
					$tgl = explode('-', $val['TANGGAL']);
					$datanya[$val['CATEGORY_NAME']][$no2]['REAL_PROD'] += $val['REAL_PROD'];
					$datanya[$val['CATEGORY_NAME']][$no2]['TARGET'] += $val['TARGET'];
					$datanya[$val['CATEGORY_NAME']][$no2]['KECAPAIAN_TARGET'] += round($val['KECAPAIAN_TARGET'],3);
					$datanya[$val['CATEGORY_NAME']][$no2]['TANGGAL'.$tgl[0].''] += $val['QTY'];
					$total[$val['CATEGORY_NAME']]['REAL_PROD'] += $val['REAL_PROD'];
					$total[$val['CATEGORY_NAME']]['TARGET'] += $val['TARGET'];
					$total[$val['CATEGORY_NAME']]['KECAPAIAN_TARGET'] += round($val['KECAPAIAN_TARGET'],3);
					$total[$val['CATEGORY_NAME']]['TANGGAL'.$tgl[0].''] += $val['QTY'];
				}

			}
			
			if (!empty($datanya[$kat['CATEGORY_NAME']])) {
				usort($datanya[$kat['CATEGORY_NAME']], function($y, $z) {
					return strcasecmp($y['DESCRIPTION'], $z['DESCRIPTION']);
				});
			}
		}
		// echo "<pre>";print_r($datanya);exit();
        $data['data'] = $datanya;
        $data['total'] = $total;
		$data['hari'] = $hari;

		$this->load->library('Pdf');
		$pdf 		= $this->pdf->load();
		$pdf		= new mPDF('utf-8','f4-L', 0, '', 5, 5, 10, 10, 7, 4);
		$filename 	= 'Laporan-Produksi-'.$data['kategori'].'-'.$data['bulan'].'.pdf';
		$x = 0;
		
		$html 	= $this->load->view('MonitoringJobProduksi/V_PdfLaporanFull', $data, true);	
			
		ob_end_clean();
		$pdf->WriteHTML($html);	
		// $pdf->debug = true; 
		$pdf->Output($filename, 'I');
	}

	public function laporan_produksi_pdf(){
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
			$real 	= 'AH';
			$target = 'AI';
			$capai 	= 'AJ';
		}elseif ($data['hari'] == 30) {
			$akhir 	= 'AF';
			$real 	= 'AG';
			$target = 'AH';
			$capai 	= 'AI';
		}elseif ($data['hari'] == 29){
			$akhir 	= 'AE';
			$real 	= 'AF';
			$target = 'AG';
			$capai 	= 'AH';
		}else {
			$akhir 	= 'AD';
			$real 	= 'AE';
			$target = 'AF';
			$capai 	= 'AG';
		}

		//TITLE
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN PRODUKSI"); 
		$excel->getActiveSheet()->mergeCells("A1:".$capai."1"); 
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
		
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Kategori"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B2', ": ".$data['kategori']); 
		
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "Bulan"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B3', ": ".$data['bulan']); 
		$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B5', "PRODUK");
		$excel->setActiveSheetIndex(0)->setCellValue('C5', "PRODUKSI");
		$excel->setActiveSheetIndex(0)->setCellValue("".$real."5", "REAL PROD");
		$excel->setActiveSheetIndex(0)->setCellValue("".$target."5", "TARGET");
		$excel->setActiveSheetIndex(0)->setCellValue("".$capai."5", "PENCAPAIAN PRODUKSI(%)");
		$excel->getActiveSheet()->mergeCells("A5:A6"); 
		$excel->getActiveSheet()->mergeCells("B5:B6"); 
		$excel->getActiveSheet()->mergeCells("C5:".$akhir."5");
		$excel->getActiveSheet()->mergeCells("".$real."5:".$real."6");
		$excel->getActiveSheet()->mergeCells("".$target."5:".$target."6");
		$excel->getActiveSheet()->mergeCells("".$capai."5:".$capai."6");
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
		$excel->getActiveSheet()->getStyle("".$real."5:".$real."6")->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("".$target."5:".$target."6")->applyFromArray($style1);
		$excel->getActiveSheet()->getStyle("".$capai."5:".$capai."6")->applyFromArray($style1);
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
			$excel->setActiveSheetIndex(0)->setCellValue($real.$numrow, $val['real_prod']);
			$excel->setActiveSheetIndex(0)->setCellValue($target.$numrow, $val['target']);
			$excel->setActiveSheetIndex(0)->setCellValue($capai.$numrow, $val['kecapaian']);

			$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("B$numrow")->applyFromArray($style2);
			$excel->getActiveSheet()->getStyle("$real$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("$target$numrow")->applyFromArray($style3);
			$excel->getActiveSheet()->getStyle("$capai$numrow")->applyFromArray($style3);
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
		$excel->setActiveSheetIndex(0)->setCellValue($real.$numrow, $data['ttl_real']);
		$excel->setActiveSheetIndex(0)->setCellValue($target.$numrow, $data['ttl_target']);
		$excel->setActiveSheetIndex(0)->setCellValue($capai.$numrow, $data['ttl_kecapaian']);

		$excel->getActiveSheet()->mergeCells("A$numrow:B$numrow"); 
		$excel->getActiveSheet()->getStyle("A$numrow")->applyFromArray($style4);
		$excel->getActiveSheet()->getStyle("B$numrow")->applyFromArray($style4);
		$excel->getActiveSheet()->getStyle("$real$numrow")->applyFromArray($style4);
		$excel->getActiveSheet()->getStyle("$target$numrow")->applyFromArray($style4);
		$excel->getActiveSheet()->getStyle("$capai$numrow")->applyFromArray($style4);

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); 
		for($col = 'C'; $col !== $real; $col++) { // autowidth
			$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
		$excel->getActiveSheet()->getColumnDimension($real)->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension($target)->setWidth(10); 
		$excel->getActiveSheet()->getColumnDimension($capai)->setWidth(15); 
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(1)->setTitle("Comment");
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
		$kecapaian 				= $this->input->post('kecapaian');
		for ($i=0; $i < count($item)/2 ; $i++) { 
			$data['value'][$i]['item'] 		= $item[$i];
			$data['value'][$i]['desc'] 		= $desc[$i];
			$data['value'][$i]['real_prod'] = $real_prod[$i];
			$data['value'][$i]['target'] 	= $target[$i];
			$data['value'][$i]['kecapaian'] = $kecapaian[$i];
			for ($t=1; $t < $data['hari']+1 ; $t++) { 
				$tanggal = $this->input->post('tanggal'.$t.'');
				$data['value'][$i]['tanggal'.$t.''] = $tanggal[$i];
			}
		}
		$ttl_real = $this->input->post('ttl_real');
		$ttl_target = $this->input->post('ttl_target');
		$ttl_kecapaian = $this->input->post('ttl_kecapaian');
		$data['ttl_real'] = $ttl_real[0];
		$data['ttl_target'] = $ttl_target[0];
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