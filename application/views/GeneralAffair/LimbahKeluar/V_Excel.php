<?php

$objPHPExcel = new PHPExcel();
$styleArray = array(
    'font'  => array(
        'size'  => 11,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        ),
	);
// $styleBorder = array(
// 	'borders' => array(
//         'allborders' => array(
//         	'style' => PHPExcel_Style_Border::BORDER_THIN
//         	)
//       	)		
// 	);
//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A:G')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal('center'); 
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getAlignment()->setHorizontal('center'); 
	$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFont()->setBold(true);
	// $objPHPExcel->getActiveSheet()->getStyle('A:G')->applyFromArray($styleBorder);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	

	// Redirect output to a client?s web browser (Excel5)

	header('Content-type: application/vnd-ms-excel');
	header('Content-Disposition: attachment; filename="Data_Limbah_Keluar.xlsx"');
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

	$objset = $objPHPExcel->setActiveSheetIndex(0);
	$objget = $objPHPExcel->getActiveSheet();
	$objget->getStyle("A6:G6")->applyFromArray(
		array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '92d050')
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'bold'  => true,
			),	
		)				
	);

	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Logbook Harian Limbah Bahan Berbahaya Dan Beracun')
				->setCellValue('A3', 'Periode :'.$tanggalawal.' - '.$tanggalakhir)
				->setCellValue('A5', 'Keluarnya Limbah B3 dari TPS')
				->setCellValue('A6', 'No')
				->setCellValue('B6', 'Tanggal Keluar Limbah B3')
				->setCellValue('C6', 'Jumlah Limbah B3 Keluar')
				->setCellValue('D6', 'Tujuan Penyerahan')
				->setCellValue('E6', 'Bukti Nomer Dokumen')
				->setCellValue('F6', 'Sisa Limbah B3 Yang Ada Di TPS')
				->setCellValue('G6', 'Jenis Limbah');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:G5');

	$no = 0;
	$i=6;	
	foreach ($filter_data as $FD) {												
	
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

    $tanggalkeluar = date('d M Y', strtotime($FD['tanggal_keluar']));
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $tanggalkeluar, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, $FD['jumlah_keluar'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, $FD['tujuan_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomE, $FD['nomor_dok'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomF, $FD['sisa_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomG, $FD['jenis'], PHPExcel_Cell_DataType::TYPE_STRING);
	}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	