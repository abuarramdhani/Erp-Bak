<?php

$objPHPExcel = new PHPExcel();
$styleArray = array(
    'font'  => array(
        'size'  => 11,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
	);

$border_all = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('black'),)));

//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A:E')->applyFromArray($styleArray);

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	

	// Redirect output to a client?s web browser (Excel5)
	//tambahkan paling atas
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=ExportDataPresensi-".$lokasi['lokasi'].".xls");
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


	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Noind')
				->setCellValue('B1', 'Nama')
				->setCellValue('C1', 'JenKel')
				->setCellValue('D1', 'Kodesie')
				->setCellValue('E1', 'Seksi');

	//style cell
	$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal('center');

	$hitungData = count($cetakData);
	$objPHPExcel->getActiveSheet()->getStyle('A1:E'.($hitungData+1))->applyFromArray($border_all);

	$no = 0;
	$i=1;

	foreach ($cetakData as $cp) {

		$i++;
		//load ke excel
		$kolomA='A'.$i;
		$kolomB='B'.$i;
		$kolomC='C'.$i;
		$kolomD='D'.$i;
		$kolomE='E'.$i;

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit($kolomA, $cp['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomB, $cp['nama'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomC, $cp['jenkel'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomD, $cp['kodesie'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomE, $cp['seksi'], PHPExcel_Cell_DataType::TYPE_STRING);	
	}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	