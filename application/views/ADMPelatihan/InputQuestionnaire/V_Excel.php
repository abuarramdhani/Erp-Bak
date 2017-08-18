<?php
$objPHPExcel = new PHPExcel(); // inisialisasi EXCEL
$styleTitle = array(
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => '000000'),
		'size'	=> 24,
	),
	'alignment' => array(
    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, //ini jalan di controller
	)
);

$styleThead = array(
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => 'FFFFFF'),
		'size'	=> 14,
	),
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$styleBorder = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

$styleNumber = array(
	'font'  => array(
		'size'	=> 12,
	),
	'alignment' => array(
    	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, //ini jalan di controller
	)
);

//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Rename worksheet
	$worksheet = $objPHPExcel->getActiveSheet();
	$worksheet->setTitle('Sheet1');

	// set lebar kolom
	$worksheet->getColumnDimension('A')->setWidth(12);
	$worksheet->getColumnDimension('B')->setWidth(40);
	$worksheet->getColumnDimension('C')->setWidth(40);
	$worksheet->getColumnDimension('D')->setWidth(40);

	// title
	$worksheet->mergeCells('A1:D1');
	$worksheet->getStyle('A1:D1')->applyFromArray($styleTitle);
	foreach ($questionnaire as $qe) {
		$worksheet->setCellValue('A1', $qe['questionnaire_title']);
	}
	
	// data
	$worksheet->setCellValue('A3', 'NAMA TRAINER');
	$i = 3;
	foreach($training as $tr) {
		$strainer = explode(',', $tr['trainer']);
		foreach($strainer as $st){
			foreach($trainer as $tn){
				if($st==$tn['trainer_id']){
					$worksheet->setCellValue('B'.$i++, $tn['trainer_name']);
				}
			}
		}
	}

	$rowTb = $worksheet->getHighestRow()+2;
	$worksheet->setCellValue('A'.$rowTb, 'RUANG');
	foreach ($training as $tr) {
		$worksheet->setCellValue('B'.$rowTb, $tr['room']);
		$worksheet->setCellValue('C'.$rowTb, 'TANGGAL PELAKSANAAN');
		$worksheet->setCellValue('D'.$rowTb, $tr['date_format']);
	}

	$worksheet->setCellValue('C3', 'PROGRAM PELATIHAN');
	foreach ($training as $tr) {
		$worksheet->setCellValue('D3', $tr['scheduling_name']);
	}

	//tabel
	$rowTb = $worksheet->getHighestRow()+2;
	$worksheet->setCellValue('A'.$rowTb, 'No');
	$cellAwal = 'A'.$rowTb;

	$colTb = $worksheet->getHighestColumn($rowTb);
	$colTb++;
	foreach($segment as $sg){
		foreach($statement as $st){
			if ($sg['segment_id'] == $st['segment_id']) {
				$worksheet->getColumnDimension($colTb)->setWidth(40);
				$worksheet->setCellValue($colTb++.$rowTb, $sg['segment_description'].' - '.$st['statement_description']);
			}
		}
	}
	
	$number = 1;
	foreach($sheet as $se){
		$rowTb++;
		$colTb = $worksheet->getHighestColumn($rowTb);
		$worksheet->setCellValue($colTb++.$rowTb,$number++);
		$stj = explode('||', $se['join_input']);
	
		$hasil = array();
		$j = 0;
		$k = 0;
		for ($i = 0; $i < count($stj); $i++) {
			if($stj[$i] == 1 || $stj[$i] == 2 || $stj[$i] == 3 || $stj[$i] == 4){
				$hasil[$j]['nilai'] = $stj[$i];
			} else {
				$hasil[$j]['essay'][$k] = $stj[$i];
				$k++;
			}
			if(($i+1) == count($stj)) {

			} else {
				if($stj[($i+1)] == 3) $j++;
			}				
			if($stj[$i] == 1){
				$worksheet->setCellValue($colTb++.$rowTb, 'Sangat Tidak Setuju');
			}else if($stj[$i] == 2){
				$worksheet->setCellValue($colTb++.$rowTb, 'Tidak Setuju');
			}else if($stj[$i] == 3){
				$worksheet->setCellValue($colTb++.$rowTb, 'Setuju');
			}else if($stj[$i] == 4){
				$worksheet->setCellValue($colTb++.$rowTb, 'Sangat Setuju');
			}else{
				$worksheet->setCellValue($colTb++.$rowTb, $stj[$i]);
			}
		}
	}
	
		$rowBorder = $worksheet->getHighestRow();
		$colBorder = $worksheet->getHighestColumn($rowTb);
		$cellAkhir = $colBorder.$rowBorder;

	$worksheet->getStyle($cellAwal.':'.$cellAkhir)->applyFromArray($styleBorder);


// Redirect output to a client?s web browser (Excel5)
//tambahkan paling atas
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename="Hasil Kuesioner.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
// Set document properties -- ga wajib
$objPHPExcel->getProperties()->setCreator("Sistem")
							 ->setLastModifiedBy("Sistem")
							 ->setTitle("Sistem")
							 ->setSubject("Sistem")
							 ->setDescription("Sistem")
							 ->setKeywords("Sistem")
							 ->setCategory("Sistem");
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	