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
	$worksheet->getColumnDimension('A')->setWidth(20);
	$worksheet->getColumnDimension('B')->setWidth(20);
	$worksheet->getColumnDimension('C')->setWidth(10);
	$worksheet->getColumnDimension('D')->setWidth(10);

	// INFO-------------------------------------------------------------------------------------------------------------------------------------------
		// judul kuesioner
		$worksheet->mergeCells('A1:D1');
		$worksheet->getStyle('A1:D1')->applyFromArray($styleTitle);
		foreach ($questionnaire as $qe) {
			$worksheet->setCellValue('A1', $qe['questionnaire_title']);
		}
		
		// nama trainer 
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

		// ruangan dan tanggal
		$rowTb = $worksheet->getHighestRow()+2;
		$worksheet->setCellValue('A'.$rowTb, 'RUANG');
		foreach ($training as $tr) {
			$worksheet->setCellValue('B'.$rowTb, $tr['room']);
			$worksheet->setCellValue('C'.$rowTb, 'TANGGAL PELAKSANAAN');
			$worksheet->setCellValue('D'.$rowTb, $tr['date_format']);
		}

		// nama pelatihan
		$worksheet->setCellValue('C3', 'PROGRAM PELATIHAN');
		foreach ($training as $tr) {
			$worksheet->setCellValue('D3', $tr['scheduling_name']);
		}
	// --INFO-----------------------------------------------------------------------------------------------------------------------------------------

	//TABEL-------------------------------------------------------------------------------------------------------------------------------------------
		// ambil highest row untuk segment & statement
		$rowSt = $worksheet->getHighestRow('A')+2;
		$rowSt2 = $worksheet->getHighestRow('B')+2;
		$rowSt++;
		$rowSt2++;
		// awal border dan nomor border
		$cellAwal = 'A'.$rowSt;
		$rowNumb1 = $worksheet->getHighestRow('A')+2;
		$worksheet->mergeCells('A'.$rowNumb1.':B'.$rowNumb1);
		// $worksheet->setCellValue('A'.$rowNumb1.':B'.$rowNumb1,'Komponen Evaluasi');
		$cellNumb = 'A'.$rowNumb1;
		$cellNumb2 = 'B'.$rowNumb1;
		$cellNumb3 = 'C'.$rowNumb1;
		$worksheet->setCellValue('A'.$rowNumb1,'Komponen Evaluasi');

		// ambil highest row untuk nomor & isian kuesioner
		$rowTb = $worksheet->getHighestRow('C')+2;
		$number = 1;
		$colTb2 = $worksheet->getHighestColumn($rowTb);
		$colTb2++;

		$colTb  = $worksheet->getHighestColumn($rowTb+1);
		$colTb++;
		$colTb++;
		$rowHeader = $rowTb;
		
		// looping segment dan statement
		foreach($segment as $sg){
			foreach($statement as $st){
				if ($sg['segment_id'] == $st['segment_id']) {
					$worksheet->setCellValue('A'.$rowSt++, $sg['segment_description']);
					$worksheet->setCellValue('B'.$rowSt2++, $st['statement_description']);
				}
			}
		}

		// looping isian kuesioner
		foreach($sheet as $se){
			$rowAwal = $rowTb+1;
			$rowAwal2 = $rowTb;
			$worksheet->setCellValue($colTb2++.$rowAwal2,'Subjek - '.$number++);
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

				// isian kuesioner
				if($stj[$i] == 1){
					$worksheet->setCellValue($colTb.$rowAwal++, '1');
				}else if($stj[$i] == 2){
					$worksheet->setCellValue($colTb.$rowAwal++, '2');
				}else if($stj[$i] == 3){
					$worksheet->setCellValue($colTb.$rowAwal++, '3');
				}else if($stj[$i] == 4){
					$worksheet->setCellValue($colTb.$rowAwal++, '4');
				}else if(empty($stj[$i])){
					$worksheet->setCellValue($colTb.$rowAwal++, '0');
				}else{
					$worksheet->setCellValue($colTb.$rowAwal++, $stj[$i]);
				}
			}
			$colTb++;
		}
		
		// untuk inputan dinamis(mendapat nomor baris dan kolom tertinggi)
			$rowBorder = $worksheet->getHighestRow();
			$colBorder = $worksheet->getHighestColumn($rowTb);
			$cellAkhir = $colBorder.$rowBorder;

		$worksheet->getStyle($cellAwal.':'.$cellAkhir)->applyFromArray($styleBorder);
		$worksheet->getStyle($cellNumb.':'.$cellAkhir)->applyFromArray($styleBorder);

	// --TABEL-----------------------------------------------------------------------------------------------------------------------------------------
	//middle layout
	$objPHPExcel->getActiveSheet()->getStyle($cellNumb3.':'.$cellAkhir)->getAlignment()->setHorizontal('center');
	//border table
	$objset = $objPHPExcel->setActiveSheetIndex(0);
	$objget = $objPHPExcel->getActiveSheet();
	$colHeaderLast = $worksheet->getHighestColumn($rowHeader);

	$objget->getStyle('A'.$rowHeader.':'.$colHeaderLast.$rowHeader)->applyFromArray(
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