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
	header("Content-Disposition: attachment; filename='Export_Maintenance_Kendaraan.xls'");
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

	$hitungdata = count($ExcelMonitoring);
	$objPHPExcel->getActiveSheet()->getStyle('A5:D'.($hitungdata+5))->applyFromArray($border_all);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
	$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($GreyColor);

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Maintenance Kendaraan CV Karya Hidup Sentosa')
				->setCellValue('A3', 'Periode :')
				->setCellValue('B3', $PeriodeExcel)
				->setCellValue('A5', 'No')
				->setCellValue('B5', 'Nomor Polisi')
				->setCellValue('C5', 'Tanggal Maintenance')
				->setCellValue('D5', 'Biaya Maintenance');

	$i=5;
	$no=1;
	foreach($ExcelMonitoring as $em){
	$i++;

	//load ke excel
	$kolomA='A'.$i;
	$kolomB='B'.$i;
	$kolomC='C'.$i;
	$kolomD='D'.$i;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $no++, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $em['nomor_polisi'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, date("d-m-Y H:i:s", strtotime($em['tanggal_asli'])), PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, 'Rp '.number_format($em['biaya'],0,",","."), PHPExcel_Cell_DataType::TYPE_STRING);			
	}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	