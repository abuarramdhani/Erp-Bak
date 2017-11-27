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
	$objPHPExcel->getActiveSheet()->getStyle('A:K')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal('center'); 
	$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getAlignment()->setHorizontal('center'); 
	$objPHPExcel->getActiveSheet()->getStyle('A5:K6')->getFont()->setBold(true);
	
	// $objPHPExcel->getActiveSheet()->getStyle('A:G')->applyFromArray($styleBorder);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	

	// Redirect output to a client?s web browser (Excel5)

	header('Content-type: application/vnd-ms-excel');
	header('Content-Disposition: attachment; filename="LogbookHarian-LimbahB3.xlsx"');
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
	// $objget->getStyle("")->applyFromArray(
	// 	array(
	// 		'fill' => array(
	// 			'type' => PHPExcel_Style_Fill::FILL_SOLID,
	// 			'color' => array('rgb' => '92d050')
	// 		),
	// 		'font' => array(
	// 			'color' => array('rgb' => '000000'),
	// 			'bold'  => true,
	// 		),	
	// 	)				
	// );

	// Add some data
	foreach(range('A','K') as $columnID)
	{
    	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Logbook Harian Limbah Bahan Berbahaya Dan Beracun')
				->setCellValue('A3', 'Bulan : '.$allBulan)
				->setCellValue('A5', 'Masuknya Limbah B3 Ke TPS')
				->setCellValue('G5', 'Keluarnya Limbah B3 dari TPS')
				->setCellValue('A6', 'No')
				->setCellValue('B6', 'Jenis Limbah B3 Masuk')
				->setCellValue('C6', 'Tanggal Limbah B3 Masuk')
				->setCellValue('D6', 'Sumber Limbah B3')
				->setCellValue('E6', 'Jumlah Limbah B3')
				->setCellValue('F6', 'Maksimal Penyimpanan s/d Tanggal')
				->setCellValue('G6', 'Tanggal Keluar Limbah B3')
				->setCellValue('H6', 'Jumlah Limbah B3 Keluar')
				->setCellValue('I6', 'Tujuan Penyerahan')
				->setCellValue('J6', 'Bukti Nomer Dokumen')
				->setCellValue('K6', 'Sisa Limbah B3 Yang Ada Di TPS');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:K3');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:F5');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G5:K5');

	$no = 0;
	$i=6;	
	foreach ($filterMasuk as $FM) {												
	
	$i++;
	$no++;
	//load ke excel
	$kolomA='A'.$i;
	$kolomB='B'.$i;
	$kolomC='C'.$i;
	$kolomD='D'.$i;
	$kolomE='E'.$i;
	$kolomF='F'.$i;

    $tanggalMasuk = date('d/m/Y', strtotime($FM['tanggal_transaksi']));
    $maksPenyimpanan = date('d/m/Y', strtotime($FM['maks_penyimpanan']));
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $FM['jenis_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, $tanggalMasuk, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, $FM['nama_seksi'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomE, $FM['jumlah'].' '.$FM['satuan'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomF, $maksPenyimpanan, PHPExcel_Cell_DataType::TYPE_STRING);
	}


	$o=6;
	foreach ($filterKeluar as $FK) {

	$o++;

	//load ke excel
	$kolomG='G'.$o;
	$kolomH='H'.$o;
	$kolomI='I'.$o;
	$kolomJ='J'.$o;
	$kolomK='K'.$o;

    $tanggalKeluar = date('d/m/Y', strtotime($FK['tanggal_keluar']));
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomG, $tanggalKeluar, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomH, $FK['jumlah_keluar'].' '.$FK['satuan'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomI, $FK['tujuan_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomJ, $FK['nomor_dok'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomK, $FK['sisa_limbah'].' '.$FK['satuan'], PHPExcel_Cell_DataType::TYPE_STRING);
	}				

	if ($i > $o) {
		$hitung = $i;
	}else{
		$hitung = $o;
	}

	$objPHPExcel->getActiveSheet()->getStyle('H'.($hitung+2).':K'.($hitung+2))->getAlignment()->setHorizontal('center'); 
	$objPHPExcel->getActiveSheet()->getStyle('H'.($hitung+2).':K'.($hitung+2))->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('H'.($hitung+5).':K'.($hitung+5))->getAlignment()->setHorizontal('center');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.($hitung+2).':K'.($hitung+2));
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.($hitung+5).':K'.($hitung+5));

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('H'.($hitung+2), 'Kepala Seksi Waste Management')
				->setCellValue('H'.($hitung+5), $user);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	