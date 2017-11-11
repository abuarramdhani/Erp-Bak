<?php

$objPHPExcel = new PHPExcel();
$styleArray = array(
    'font'  => array(
        'size'  => 12,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
	);

//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A:AZ')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('G3:AK3')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('G4:AK4')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('AL3:AQ4')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('AL3:AQ4')->getFont()->setBold(true);


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	

	// Redirect output to a client?s web browser (Excel5)

	header('Content-type: application/vnd-ms-excel');
	header('Content-Disposition: attachment; filename="Report_Limbah_Transaksi_Harian.xlsx"');
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
	$objget->getStyle("A1:Z1")->applyFromArray(
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

	// $tglawal = date('d M Y', strtotime());
	// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Neraca Harian Pengelolaan Limbah B3 CV KARYA HIDUP SENTOSA')
					->setCellValue('A3', 'No')
					->setCellValue('B3', 'Jenis Limbah B3')
					->setCellValue('C3', 'Sumber')
					->setCellValue('D3', 'Satuan')
					->setCellValue('E3', 'Perlakuan')
					->setCellValue('F3', 'Sisa Bulan Lalu (kg)')
					->setCellValue('G3', 'Jumlah Limbah per hari (kg)')
					->setCellValue('G4', $tanggalawalformatindo.' / '.$tanggalakhirformatindo);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Z1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:A5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:B5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:C5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:D5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E3:E5');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F3:F6');
	
		if($jumlahHari == 29) {
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G3:AJ3');
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:AJ4');
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AK3:AQ4');
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AR3:AR6');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK3', 'LIMBAH DIKELOLA (TON)');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR3', 'Keterangan');
		} else {
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G3:AK3');
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:AK4');
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AL3:AS4');
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AS3:AS6');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL3', 'LIMBAH DIKELOLA (TON)');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS3', 'Keterangan');
		}

	$kolomHari = ['G', 'H', 'I', 'J', 'K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS'];
	$awal = 7;	
	$akhir = 13;
	$countperlakuan = count($perlakuan);
	foreach ($filter_data as $key => $LT) {

		$dataTanggal = explode('-', $LT['tanggal_transaksi']);
		$dataTanggal = (int)$dataTanggal[2];

		$dataPerlakuan = $LT['limbah_perlakuan'];

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($awal+($countperlakuan*$key).':A'.($akhir+($countperlakuan*$key))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($awal+($countperlakuan*$key).':B'.($akhir+($countperlakuan*$key))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($awal+($countperlakuan*$key).':C'.($akhir+($countperlakuan*$key))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.($awal+($countperlakuan*$key).':D'.($akhir+($countperlakuan*$key))));

	//load ke excel
	$kolomA = 'A'.($awal+($countperlakuan*$key));
	$kolomB = 'B'.($awal+($countperlakuan*$key));
	$kolomC = 'C'.($awal+($countperlakuan*$key));
	$kolomD = 'D'.($awal+($countperlakuan*$key));
	$kolomF = 'F'.($awal+($countperlakuan*$key));
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $key+1, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $LT['jenis'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, $LT['sumber'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, 'TON', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomF, '', PHPExcel_Cell_DataType::TYPE_STRING);

		// for perlakuan
		foreach ($perlakuan as $key1 => $plkn) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit('E'.(($awal+($countperlakuan*$key))+$key1), $plkn['limbah_perlakuan'], PHPExcel_Cell_DataType::TYPE_STRING);

			// total
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomHari[$jumlahHari+($key1+1)].'5', $plkn['limbah_perlakuan'], PHPExcel_Cell_DataType::TYPE_STRING);

			// for jumlah hari
			for($i = 0; $i <= $jumlahHari; $i++) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit($kolomHari[$i].'5', $i+1);

				if($plkn['limbah_perlakuan'] == $dataPerlakuan && (($i+1) == $dataTanggal)) {
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValueExplicit($kolomHari[$i].''.(($awal+($countperlakuan*$key))+$key1), $LT['jumlah']);					
				}
			}
		}
	}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	