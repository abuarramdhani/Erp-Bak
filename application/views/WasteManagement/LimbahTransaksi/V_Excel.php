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
	$objPHPExcel->getActiveSheet()->getStyle('G4:R5')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('G6:R6')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('T4:X4')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('T3:X4')->getFont()->setBold(true);


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	

	// Redirect output to a client?s web browser (Excel5)

	header('Content-type: application/vnd-ms-excel');
	header('Content-Disposition: attachment; filename="NeracaBulanan-LimbahB3.xlsx"');
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
					->setCellValue('A1', 'NERACA BULANAN PENGELOLAAN LIMBAH B3 CV KARYA HIDUP SENTOSA')
					->setCellValue('A4', 'NO')
					->setCellValue('B4', 'JENIS LIMBAH B3')
					->setCellValue('C4', 'SUMBER')
					->setCellValue('D4', 'SATUAN')
					->setCellValue('E4', 'PERLAKUAN')
					->setCellValue('F4', 'Periode Sebelumnya (SALDO)')
					->setCellValue('G4', $tglindo1.' / '.$tglindo2)
					->setCellValue('S4', 'LIMBAH DIHASILKAN')
					->setCellValue('T4', 'LIMBAH DIKELOLA')
					->setCellValue('T5', 'DISIMPAN DI TPS')
					->setCellValue('U5', 'DIMANFAATKAN SENDIRI')
					->setCellValue('V5', 'DIOLAH SENDIRI')
					->setCellValue('W5', 'LANDFILL SENDIRI')
					->setCellValue('X5', 'DISERAHKAN PIHAK KETIGA BERIZIN')
					->setCellValue('Y4', 'LIMBAH TIDAK DIKELOLA')
					->setCellValue('Z4', 'KETERANGAN')
					->setCellValue('AA4', 'KODE MANIFEST');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Z1');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:A6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:B6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:C6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:D6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E4:E6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:F6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('S4:S6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('T4:X4');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('T5:T6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('U5:U6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('V5:V6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('W5:W6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('X5:X6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Y4:Y6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Z4:Z6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA4:AA6');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:R5');
	
	$kolomBulan = ['G', 'H', 'I', 'J', 'K','L','M','N','O','P','Q','R'];
	$awal = 7;	
	$akhir = 13;
	$countperlakuan = count($perlakuan);
	foreach ($header as $key3 => $HE) {
	// foreach ($jumlahlimbah as $key => $LT) {
	// 	if($LT['bulan'] == '1') {
	// 		$dataTanggal = 'Januari';
	// 	}elseif($LT['bulan'] == '2') {
	// 		$dataTanggal = 'Februari';
	// 	}elseif($LT['bulan'] == '3') {
	// 		$dataTanggal = 'Maret';
	// 	}elseif($LT['bulan'] == '4') {
	// 		$dataTanggal = 'April';
	// 	}elseif($LT['bulan'] == '5') {
	// 		$dataTanggal = 'Mei';
	// 	}elseif($LT['bulan'] == '6') {
	// 		$dataTanggal = 'Juni';
	// 	}elseif($LT['bulan'] == '7') {
	// 		$dataTanggal = 'Juli';
	// 	}elseif($LT['bulan'] == '8') {
	// 		$dataTanggal = 'Agustus';
	// 	}elseif($LT['bulan'] == '9') {
	// 		$dataTanggal = 'September';
	// 	}elseif($LT['bulan'] == '10') {
	// 		$dataTanggal = 'Oktober';
	// 	}elseif($LT['bulan'] == '11') {
	// 		$dataTanggal = 'November';
	// 	}elseif($LT['bulan'] == '12') {
	// 		$dataTanggal = 'Desember';
	// 	}
	// 	// $dataTanggal = (int)$dataTanggal[1];

	// 	$dataPerlakuan = $LT['limbah_perlakuan'];
	// 	$dataJenisLimbah = $LT['jenis_limbah'];

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($awal+($countperlakuan*$key3).':A'.($akhir+($countperlakuan*$key3))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($awal+($countperlakuan*$key3).':B'.($akhir+($countperlakuan*$key3))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($awal+($countperlakuan*$key3).':C'.($akhir+($countperlakuan*$key3))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.($awal+($countperlakuan*$key3).':D'.($akhir+($countperlakuan*$key3))));

	//load ke excel
	$kolomA = 'A'.($awal+($countperlakuan*$key3));
	$kolomB = 'B'.($awal+($countperlakuan*$key3));
	$kolomC = 'C'.($awal+($countperlakuan*$key3));
	$kolomD = 'D'.($awal+($countperlakuan*$key3));
	$kolomF = 'F'.($awal+($countperlakuan*$key3));

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $key3+1, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $HE['jenis_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, $HE['sumber'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, 'TON', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomF, '', PHPExcel_Cell_DataType::TYPE_STRING);

		foreach ($jumlahlimbah as $key => $LT) {
		if($LT['bulan'] == '1') {
			$dataTanggal = 'Januari';
		}elseif($LT['bulan'] == '2') {
			$dataTanggal = 'Februari';
		}elseif($LT['bulan'] == '3') {
			$dataTanggal = 'Maret';
		}elseif($LT['bulan'] == '4') {
			$dataTanggal = 'April';
		}elseif($LT['bulan'] == '5') {
			$dataTanggal = 'Mei';
		}elseif($LT['bulan'] == '6') {
			$dataTanggal = 'Juni';
		}elseif($LT['bulan'] == '7') {
			$dataTanggal = 'Juli';
		}elseif($LT['bulan'] == '8') {
			$dataTanggal = 'Agustus';
		}elseif($LT['bulan'] == '9') {
			$dataTanggal = 'September';
		}elseif($LT['bulan'] == '10') {
			$dataTanggal = 'Oktober';
		}elseif($LT['bulan'] == '11') {
			$dataTanggal = 'November';
		}elseif($LT['bulan'] == '12') {
			$dataTanggal = 'Desember';
		}
		// $dataTanggal = (int)$dataTanggal[1];

		$dataPerlakuan = $LT['limbah_perlakuan'];
		$dataJenisLimbah = $LT['id_jenis_limbah'];

	
		//for perlakuan
		foreach ($perlakuan as $key1 => $plkn) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit('E'.(($awal+($countperlakuan*$key3))+$key1), $plkn['limbah_perlakuan'], PHPExcel_Cell_DataType::TYPE_STRING);

			// for jumlah bulan
			foreach ($listBulan as $key2 => $bulan) {
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueExplicit($kolomBulan[$key2].'6', $bulan);

				if(($plkn['limbah_perlakuan'] == $dataPerlakuan) && ($bulan == $dataTanggal) && ($HE['id_jenis_limbah'] == $dataJenisLimbah)) {
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValueExplicit($kolomBulan[$key2].''.(($awal+($countperlakuan*$key3))+$key1), $LT['total_limbah']);
				} 
			}
		}
	  }	
	}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
?>		 	 	 	 	