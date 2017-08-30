<?php

$objPHPExcel = new PHPExcel();
$header = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 11
		),
		'alignment' => array(
			 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        )
	);
$thead = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 11
		),
		'alignment' => array(
			 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        )
	);
$ttd = array(
		'alignment' => array(
			 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        )
);
$bold = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 11
		)
);
$borderAll = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );
//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($header);
	$objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($thead);
	$objPHPExcel->getActiveSheet()->getStyle('A:B')->applyFromArray($ttd);
	$objPHPExcel->getActiveSheet()->getStyle('D:J')->applyFromArray($ttd);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(55);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
	$objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($borderAll);

	// Redirect output to a clients web browser (Excel5)
	//tambahkan paling atas
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=PEMAKAIANBARANG-".$shift."".$periode.".xls");
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
				->setCellValue('A1', 'LAPORAN PEMAKAIAN BARANG SHIFT '.$shift.', TANGGAL '.$periode.'')
				->setCellValue('A3', 'No.')
				->setCellValue('B3', 'KODE BRG')
				->setCellValue('C3', 'BARANG')
				->setCellValue('D3', 'MERK')
				->setCellValue('E3', 'STOK')
				->setCellValue('F3', 'JML PAKAI')
				->setCellValue('G3', 'TGL PAKAI')
				->setCellValue('H3', 'SHIFT')
				->setCellValue('I3', 'USER')
				->setCellValue('J3', 'TOOLMAN')
				->setCellValue('K3', 'SPESIFIKASI');
	$i=3;
	$no = 0;
	foreach($RecordTransaction as $RecordTransaction_item){
	$i++;
	$no++;	
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
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomB, $RecordTransaction_item['item_id'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomC, $RecordTransaction_item['item_name'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomD, '-', PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomE, $RecordTransaction_item['item_qty'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomF, $RecordTransaction_item['qty_dipakai'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomG, $RecordTransaction_item['creation_date'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomH, $RecordTransaction_item['shift'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomI, $RecordTransaction_item['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomJ, $RecordTransaction_item['created_by'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomK, $RecordTransaction_item['item_desc'], PHPExcel_Cell_DataType::TYPE_STRING);
					
					$objPHPExcel->getActiveSheet()->getStyle(''.$kolomA.':'.$kolomK.'')->applyFromArray($borderAll);
	}	
					
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	