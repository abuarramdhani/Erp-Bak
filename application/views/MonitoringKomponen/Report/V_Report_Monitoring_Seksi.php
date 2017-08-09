<?php

$objPHPExcel = new PHPExcel();
$styleHeader = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 11,
        'name'  => 'Arial'
    ),
	'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        )
	);
$styleCenter = array(
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        )
	);
$styleThead = array(
	'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
			'wrap' => true
        ),
	'font' 		=> array(
        'bold'  => true
		)
	);
//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleHeader);
	$objPHPExcel->getActiveSheet()->getStyle('A5:L6')->applyFromArray($styleHeader);
	$objPHPExcel->getActiveSheet()->getStyle('A:B')->applyFromArray($styleCenter);
	$objPHPExcel->getActiveSheet()->getStyle('D:I')->applyFromArray($styleCenter);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:A6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B5:B6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:C6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D5:D6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E5:E6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:F6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G5:G6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:I5');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J5:J6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K5:K6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L5:L6');

	// Redirect output to a clients web browser (Excel5)
	//tambahkan paling atas
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=ReportKirimKomponen_".date("mdY").".xls");
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
				->setCellValue('A1', 'LAPORAN  KAPASITAS SIMPAN  GUDANG')
				->setCellValue('A3', 'Tanggal Cetak')
				->setCellValue('C3', ": ".date("Y-m-d H:i:s"))
				->setCellValue('A4', 'Jenis Laporan')
				->setCellValue('C4', ': 1. Komp. yang boleh kirim gudang')
				->setCellValue('A5', 'NO')
				->setCellValue('B5', 'KODE KOMPONEN')
				->setCellValue('C5', 'NAMA KOMPONEN')
				->setCellValue('D5', 'ON HAND')
				->setCellValue('E5', 'QTY MAX')
				->setCellValue('F5', 'BOLEH KIRIM')
				->setCellValue('G5', 'STATUS KIRIM')
				->setCellValue('H5', 'HANDLING')
				->setCellValue('H6', 'QTY')
				->setCellValue('I6', 'SARANA')
				->setCellValue('J5', 'ASAL KOMP')
				->setCellValue('K5', 'LOKASI')
				->setCellValue('L5', 'GUDANG');
	$i=6;
	$no=0;
	foreach($data as $tc){
	$i++;
	$no++;
	//load ke excel
	$kolomA='A'.$i;
	$kolomB='B'.$i;
	$kolomC='C'.$i;
	$kolomD='D'.$i;
	$kolomE='E'.$i;
	$kolomF='F'.$i;
	$kolomG='G'.$i;
	$kolomH='H'.$i;
	$kolomI='I'.$i;
	$kolomJ='J'.$i;
	$kolomK='K'.$i;
	$kolomL='L'.$i;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $tc['SEGMENT1'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, $tc['DESCRIPTION'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, $tc['ONHAND'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomE, $tc['MAX_MINMAX_QUANTITY'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomF, $tc['BOLEH_KIRIM'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomG, $tc['STATUS'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomH, $tc['UNIT_VOLUME'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomI, $tc['ATTRIBUTE14'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomJ, $tc['ASAL_ITEM'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomK, $tc['LOKASI'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomL, $tc['SUBINVENTORY_CODE'], PHPExcel_Cell_DataType::TYPE_STRING);
	}
																					
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	