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
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
	$objPHPExcel->getActiveSheet()->getStyle('A3:M3')->applyFromArray($borderAll);

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
				->setCellValue('H3', 'JML KEMBALI')
				->setCellValue('I3', 'TGL KEMBALI')
				->setCellValue('J3', 'SHIFT')
				->setCellValue('K3', 'USER')
				->setCellValue('L3', 'TOOLMAN')
				->setCellValue('M3', 'SPESIFIKASI');
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
		$kolomL='L'.$i;
		$kolomM='M'.$i;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomB, $RecordTransaction_item['item_id'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomC, $RecordTransaction_item['item_name'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomD, '-', PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomE, str_replace("  ","",$RecordTransaction_item['item_qty']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomF, str_replace("  ","",$RecordTransaction_item['qty_dipakai']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomG, str_replace("  ","",$RecordTransaction_item['creation_date']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomH, str_replace("  ","",$RecordTransaction_item['item_qty_return']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomI, str_replace("  ","",$RecordTransaction_item['date_return']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomJ, str_replace("  ","",$RecordTransaction_item['shift']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomK, str_replace("  ","",$RecordTransaction_item['name']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomL, str_replace("  ","",$RecordTransaction_item['toolman']), PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomM, $RecordTransaction_item['item_desc'], PHPExcel_Cell_DataType::TYPE_STRING);
					
					$objPHPExcel->getActiveSheet()->getStyle(''.$kolomA.':'.$kolomM.'')->applyFromArray($borderAll);
		$toolman = $RecordTransaction_item['toolman'];
	}	
	$row = (int)$i+2;
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$row.':J'.$row.'');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$row.':L'.$row.'');
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1) 
						->setCellValueExplicit('J'.$row, "Pengawas,", PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('L'.$row, "Toolman,", PHPExcel_Cell_DataType::TYPE_STRING);
	$row2 = (int)$i+5;
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$row2.':J'.$row2.'');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K'.$row2.':L'.$row2.'');
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row2,1) 
						->setCellValueExplicit('J'.$row2, "(                       )", PHPExcel_Cell_DataType::TYPE_STRING)
						->setCellValueExplicit('L'.$row2, str_replace(" ","",$toolman), PHPExcel_Cell_DataType::TYPE_STRING);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	