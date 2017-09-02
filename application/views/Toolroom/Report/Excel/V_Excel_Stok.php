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
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($header);
	$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($thead);
	$objPHPExcel->getActiveSheet()->getStyle('A:B')->applyFromArray($ttd);
	$objPHPExcel->getActiveSheet()->getStyle('D:J')->applyFromArray($ttd);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(55);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
	$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($borderAll);

	// Redirect output to a clients web browser (Excel5)
	//tambahkan paling atas
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=STOKBARANG-".$shift."".$periode.".xls");
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
				->setCellValue('A1', 'LAPORAN STOK SHIFT '.$shift.', TANGGAL '.$periode.'')
				->setCellValue('A3', 'No.')
				->setCellValue('B3', 'KODE BRG')
				->setCellValue('C3', 'BARANG')
				->setCellValue('D3', 'MERK')
				->setCellValue('E3', 'STOK AWAL')
				->setCellValue('F3', 'STOK AKH')
				->setCellValue('G3', 'SPESIFIKASI');
	$i=3;
	$no = 0;
	foreach($RecordStok as $RecordStok_item){
	$i++;
	$no++;	
		$kolomA='A'.$i;
		$kolomB='B'.$i;
		$kolomC='C'.$i;
		$kolomD='D'.$i;
		$kolomE='E'.$i;
		$kolomF='F'.$i;
		$kolomG='G'.$i;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomB, $RecordStok_item['item_id'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomC, $RecordStok_item['item_name'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomD, '-', PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomE, $RecordStok_item['item_qty'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomF, $RecordStok_item['stok_akh'], PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit($kolomG, $RecordStok_item['item_desc'], PHPExcel_Cell_DataType::TYPE_STRING);
					
					$objPHPExcel->getActiveSheet()->getStyle(''.$kolomA.':'.$kolomG.'')->applyFromArray($borderAll);
	}	
					
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	