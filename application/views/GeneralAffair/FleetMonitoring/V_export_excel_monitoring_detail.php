<?php

$objPHPExcel = new PHPExcel();
$styleArray = array(
    'font'  => array(
        'size'  => 14,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
	);

	$border_all = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('black'),)));
	$GreyColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'A9A9A9')));

//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A:E')->applyFromArray($styleArray);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client?s web browser (Excel5)
	//tambahkan paling atas
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename='Export_Maintenance_Kendaraan_Detail.xls'");
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
// Set document properties
	$objPHPExcel->getProperties()->setCreator("Sistem")
								 ->setLastModifiedBy("Sistem")
								 ->setTitle("Sistem")
								 ->setSubject("Sistem")
								 ->setDescription("Sistem")
								 ->setKeywords("Sistem")
								 ->setCategory("Sistem");

	$hitungdata = count($ExcelMonitoringDetail);
	$objPHPExcel->getActiveSheet()->getStyle('A5:E'.($hitungdata+5))->applyFromArray($border_all);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
	$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A5:E5')->applyFromArray($GreyColor);

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Maintenance Kendaraan CV Karya Hidup Sentosa')
				->setCellValue('A3', 'Periode :')
				->setCellValue('B3', $PeriodeExcel)
				->setCellValue('A5', 'No')
				->setCellValue('B5', 'Nomor Polisi')
				->setCellValue('C5', 'Jenis Maintenance')
				->setCellValue('D5', 'Tanggal Maintenance')
				->setCellValue('E5', 'Biaya Maintenance');

	$i=5;
	$no=1;
	foreach($ExcelMonitoringDetail as $emd){
	$i++;

	//load ke excel
	$kolomA='A'.$i;
	$kolomB='B'.$i;
	$kolomC='C'.$i;
	$kolomD='D'.$i;
	$kolomE='E'.$i;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $no++, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $emd['nomor_polisi'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, $emd['jenis_maintenance'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, date("d-m-Y H:i:s", strtotime($emd['tanggal_asli'])), PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomE, 'Rp '.number_format($emd['biaya'],0,",","."), PHPExcel_Cell_DataType::TYPE_STRING);			
	}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	