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

//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A:F')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	

	// Redirect output to a client?s web browser (Excel5)
	//tambahkan paling atas
	header('Content-type: application/vnd-ms-excel');
	header('Content-Disposition: attachment; filename="Data_Limbah_Transaksi.xlsx"');
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
				->setCellValue('A1', 'Logbook Harian Limbah Bahan Berbahaya Dan Beracun')
				->setCellValue('A3', 'Periode')
				->setCellValue('A6', 'No')
				->setCellValue('B6', 'Jenis Limbah B3 Masuk')
				->setCellValue('C6', 'Tanggal Limbah B3 Masuk')
				->setCellValue('D6', 'Sumber Limbah B3')
				->setCellValue('E6', 'Jumlah Limbah B3')
				->setCellValue('F6', 'Maks.Penyimpanan s/d Tanggal');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');

	$no = 0;
	$i=6;	
	foreach ($filter_data as $LT) {												
	
	$i++;
	$no++;
	//load ke excel
	$kolomA='A'.$i;
	$kolomB='B'.$i;
	$kolomC='C'.$i;
	$kolomD='D'.$i;
	$kolomE='E'.$i;
	$kolomF='F'.$i;

    $transaksi_tgl = date('d M Y', strtotime($LT['tanggal_transaksi']));
    $maks_penyimpanan = date(' d M Y', strtotime($LT['maks_penyimpanan']));
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $LT['jenis'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, $transaksi_tgl, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, $LT['sumber'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomE, $LT['jumlah'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomF, $maks_penyimpanan, PHPExcel_Cell_DataType::TYPE_STRING);
	}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	