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

	$border_all = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('black'),)));
	$YellowColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')));
	$OranyeColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ff8000')));
	$GreenColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '206020')));
	$BlueColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '000099')));
	$PinkColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ff0080')));
	$BrownColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '805500')));
	$GreyColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'b7b795')));
	$BlackColor = array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '000000')));
	$fontWhite = array('font' => array(
							'bold' => true,
							'color' => array('rgb' => 'ffffff')
						));

	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A:AZ')->applyFromArray($styleArray);

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

	$objPHPExcel->setActiveSheetIndex(0);

	header('Content-type: application/vnd-ms-excel');
	header('Content-Disposition: attachment; filename="NeracaBulanan-LimbahB3.xls"');
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');

	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

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

	$kolomBulan = array('F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA');

	$jumlahBulan = count($listBulan);

	//merge cell
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:Z1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:A6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:B6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:C6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:D6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E4:E6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:F6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:'.$kolomBulan[$jumlahBulan].'5');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+1].'4:'.$kolomBulan[$jumlahBulan+1].'6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+2].'4:'.$kolomBulan[$jumlahBulan+6].'4');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+2].'5:'.$kolomBulan[$jumlahBulan+2].'6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+3].'5:'.$kolomBulan[$jumlahBulan+3].'6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+4].'5:'.$kolomBulan[$jumlahBulan+4].'6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+5].'5:'.$kolomBulan[$jumlahBulan+5].'6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+6].'5:'.$kolomBulan[$jumlahBulan+6].'6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+7].'4:'.$kolomBulan[$jumlahBulan+7].'6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+8].'4:'.$kolomBulan[$jumlahBulan+8].'6');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+9].'4:'.$kolomBulan[$jumlahBulan+9].'6');

	//set cell value
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'NERACA BULANAN PENGELOLAAN LIMBAH B3 CV KARYA HIDUP SENTOSA')
		->setCellValue('A4', 'NO')
		->setCellValue('B4', 'JENIS LIMBAH B3')
		->setCellValue('C4', 'SUMBER')
		->setCellValue('D4', 'SATUAN')
		->setCellValue('E4', 'PERLAKUAN')
		->setCellValue('F4', 'Periode Sebelumnya (SALDO)')
		->setCellValue('G4', $tanggalawalformatindo.' / '.$tanggalakhirformatindo)
		->setCellValue($kolomBulan[$jumlahBulan+1].'4', 'LIMBAH DIHASILKAN')
		->setCellValue($kolomBulan[$jumlahBulan+2].'4', 'LIMBAH DIKELOLA')
		->setCellValue($kolomBulan[$jumlahBulan+2].'5', 'DISIMPAN DI TPS')
		->setCellValue($kolomBulan[$jumlahBulan+3].'5', 'DIMANFAATKAN SENDIRI')
		->setCellValue($kolomBulan[$jumlahBulan+4].'5', 'DIOLAH SENDIRI')
		->setCellValue($kolomBulan[$jumlahBulan+5].'5', 'DITIMBUN SENDIRI')
		->setCellValue($kolomBulan[$jumlahBulan+6].'5', 'DISERAHKAN PIHAK KETIGA BERIZIN')
		->setCellValue($kolomBulan[$jumlahBulan+7].'4', 'LIMBAH TIDAK DIKELOLA')
		->setCellValue($kolomBulan[$jumlahBulan+8].'4', 'KETERANGAN')
		->setCellValue($kolomBulan[$jumlahBulan+9].'4', 'KODE MANIFEST');

	//pewarnaan
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+1].'4')->applyFromArray($YellowColor);
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+2].'4')->applyFromArray($BlackColor);
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+2].'4')->applyFromArray($fontWhite);
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+2].'5')->applyFromArray($OranyeColor);
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+3].'5')->applyFromArray($GreenColor);
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+4].'5')->applyFromArray($BlueColor);
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+5].'5')->applyFromArray($PinkColor);
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+6].'5')->applyFromArray($BrownColor);
		$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+7].'4')->applyFromArray($GreyColor);
	
	$awal = 7;
	$akhir = 13;
	$countheader = count($header);
	$countperlakuan = count($perlakuan);

	$kolomTotal = ($awal+($countheader*$countperlakuan));

	$objPHPExcel->getActiveSheet()->getStyle('A4:'.$kolomBulan[$jumlahBulan+9].($kolomTotal+2)) ->applyFromArray($border_all);
	$objPHPExcel->getActiveSheet()->getStyle('A4:'.$kolomBulan[$jumlahBulan+9].'6')->getAlignment()->setHorizontal('center');
	$objPHPExcel->getActiveSheet()->getStyle('A4:'.$kolomBulan[$jumlahBulan+9].'6')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$awal.':'.'E'.($kolomTotal-1))->getAlignment()->setHorizontal('center');
	
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$kolomTotal, 'JUMLAH LIMBAH B3')
		->setCellValue('A'.($kolomTotal+1), 'PERSENTASE PENATAAN');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$kolomTotal)->applyFromArray($GreyColor);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$kolomTotal.':'.$kolomBulan[$jumlahBulan].$kolomTotal);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$kolomTotal.':'.$kolomBulan[$jumlahBulan].$kolomTotal)->getAlignment()->setHorizontal('right');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$kolomTotal.':'.$kolomBulan[$jumlahBulan].$kolomTotal)->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($kolomTotal+1).':'.$kolomBulan[$jumlahBulan+1].($kolomTotal+2));
	$objPHPExcel->getActiveSheet()->getStyle('A'.($kolomTotal+1).':'.$kolomBulan[$jumlahBulan+1].($kolomTotal+2))->getAlignment()->setHorizontal('right');
	$objPHPExcel->getActiveSheet()->getStyle('A'.($kolomTotal+1).':'.$kolomBulan[$jumlahBulan+1].($kolomTotal+2))->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomBulan[$jumlahBulan+2].($kolomTotal+2).':'.$kolomBulan[$jumlahBulan+6].($kolomTotal+2));
	$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+2].($kolomTotal+2).':'.$kolomBulan[$jumlahBulan+6].($kolomTotal+2))->getAlignment()->setHorizontal('center');

	$totalJumlahDihasilkan = 0;
	$totalJumlahDiSimpanTPS = 0;
	$totalJumlahDimanfaatkan = 0;
	$totalJumlahDiolah = 0;
	$totalJumlahDitimbun = 0;
	$totalJumlahDiserahkan = 0;
	$totalJumlahTidakDikelola = 0;

	foreach ($header as $key3 => $HE) {
		$totalBulanSebelumnya = 0;
		foreach ($SisaSebelum as $key5 => $sisa) {
			if($HE['id_jenis_limbah'] == $sisa['id_jenis_limbah']) {
				if($sisa['limbah_perlakuan'] == 'DIHASILKAN') {
					$dihasilkan = (float)$sisa['total_limbah'];
				} else {
					$dihasilkan = 0;
				}

				if($sisa['limbah_perlakuan'] == 'DISIMPAN DI TPS') {
					$disimpan = (float)$sisa['total_limbah'];
				} else {
					$disimpan = 0;
				}

				if($sisa['limbah_perlakuan'] == 'DIMANFAATKAN SENDIRI') {
					$dimanfaatkan = (float)$sisa['total_limbah'];
				} else {
					$dimanfaatkan = 0;
				}

				if($sisa['limbah_perlakuan'] == 'DIOLAH SENDIRI') {
					$diolah = (float)$sisa['total_limbah'];
				} else {
					$diolah = 0;
				}

				if($sisa['limbah_perlakuan'] == 'DITIMBUN SENDIRI') {
					$ditimbun = (float)$sisa['total_limbah'];
				} else {
					$ditimbun = 0;
				}

				if($sisa['limbah_perlakuan'] == 'DISERAHKAN KEPIHAK KETIGA BERIZIN') {
					$diserahkan = (float)$sisa['total_limbah'];
				} else {
					$diserahkan = 0;
				}

				$totalBulanSebelum = ($disimpan + $dihasilkan) - ($dimanfaatkan + $diolah + $ditimbun + $diserahkan);

				$totalBulanSebelumnya += $totalBulanSebelum;
			}
		}

		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit('F'.(($awal+($countperlakuan*$key3))+1), number_format($totalBulanSebelumnya,3,'.',''));

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($awal+($countperlakuan*$key3).':A'.($akhir+($countperlakuan*$key3))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($awal+($countperlakuan*$key3).':B'.($akhir+($countperlakuan*$key3))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($awal+($countperlakuan*$key3).':C'.($akhir+($countperlakuan*$key3))));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.($awal+($countperlakuan*$key3).':D'.($akhir+($countperlakuan*$key3))));

		//load ke excel
		$kolomA = 'A'.($awal+($countperlakuan*$key3));
		$kolomB = 'B'.($awal+($countperlakuan*$key3));
		$kolomC = 'C'.($awal+($countperlakuan*$key3));
		$kolomD = 'D'.($awal+($countperlakuan*$key3));

		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit($kolomA, $key3+1, PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit($kolomB, $HE['jenis_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit($kolomC, $HE['sumber'], PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit($kolomD, 'TON', PHPExcel_Cell_DataType::TYPE_STRING);


		$totalPerHeaderDihasilkan = 0;
		$totalPerHeaderDimanfaatkan = 0;
		$totalPerHeaderDiolah = 0;
		$totalPerHeaderDitimbun = 0;
		$totalPerHeaderDiserahkan = 0;
		$totalPerHeaderTidakDikelola = 0;
		foreach ($listBulan as $key2 => $bulan) {
			foreach ($perlakuan as $key1 => $plkn) {
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

					$dataPerlakuan = $LT['limbah_perlakuan'];
					$dataJenisLimbah = $LT['id_jenis_limbah'];

					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValueExplicit('E'.(($awal+($countperlakuan*$key3))+$key1), $plkn['limbah_perlakuan'], PHPExcel_Cell_DataType::TYPE_STRING);
					//pewarnaan
					$objPHPExcel->getActiveSheet()->getStyle('E'.($awal+($countperlakuan*$key3)))->applyFromArray($YellowColor);
					$objPHPExcel->getActiveSheet()->getStyle('E'.($awal+($countperlakuan*$key3)+1))->applyFromArray($OranyeColor);
					$objPHPExcel->getActiveSheet()->getStyle('E'.($awal+($countperlakuan*$key3)+2))->applyFromArray($GreenColor);
					$objPHPExcel->getActiveSheet()->getStyle('E'.($awal+($countperlakuan*$key3)+3))->applyFromArray($BlueColor);
					$objPHPExcel->getActiveSheet()->getStyle('E'.($awal+($countperlakuan*$key3)+4))->applyFromArray($PinkColor);
					$objPHPExcel->getActiveSheet()->getStyle('E'.($awal+($countperlakuan*$key3)+5))->applyFromArray($BrownColor);
					$objPHPExcel->getActiveSheet()->getStyle('E'.($awal+($countperlakuan*$key3)+6))->applyFromArray($GreyColor);

					$objPHPExcel->getActiveSheet()->getStyle('F'.($awal+($countperlakuan*$key3)+1))->applyFromArray($OranyeColor);

					$objPHPExcel->getActiveSheet()->getStyle('G'.($awal+($countperlakuan*$key3)).':'.($kolomBulan[$jumlahBulan+1]).''.($awal+($countperlakuan*$key3)))->applyFromArray($YellowColor);
					$objPHPExcel->getActiveSheet()->getStyle('G'.($awal+($countperlakuan*$key3)+1).':'.($kolomBulan[$jumlahBulan+2]).''.($awal+($countperlakuan*$key3)+1))->applyFromArray($OranyeColor);
					$objPHPExcel->getActiveSheet()->getStyle('G'.($awal+($countperlakuan*$key3)+2).':'.($kolomBulan[$jumlahBulan+3]).''.($awal+($countperlakuan*$key3)+2))->applyFromArray($GreenColor);
					$objPHPExcel->getActiveSheet()->getStyle('G'.($awal+($countperlakuan*$key3)+3).':'.($kolomBulan[$jumlahBulan+4]).''.($awal+($countperlakuan*$key3)+3))->applyFromArray($BlueColor);
					$objPHPExcel->getActiveSheet()->getStyle('G'.($awal+($countperlakuan*$key3)+4).':'.($kolomBulan[$jumlahBulan+5]).''.($awal+($countperlakuan*$key3)+4))->applyFromArray($PinkColor);
					$objPHPExcel->getActiveSheet()->getStyle('G'.($awal+($countperlakuan*$key3)+5).':'.($kolomBulan[$jumlahBulan+6]).''.($awal+($countperlakuan*$key3)+5))->applyFromArray($BrownColor);
					$objPHPExcel->getActiveSheet()->getStyle('G'.($awal+($countperlakuan*$key3)+6).':'.($kolomBulan[$jumlahBulan+7]).''.($awal+($countperlakuan*$key3)+6))->applyFromArray($GreyColor);

					$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+2].($awal+($countperlakuan*$key3)))->applyFromArray($OranyeColor);
					$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+3].($awal+($countperlakuan*$key3)).':'.$kolomBulan[$jumlahBulan+3].($awal+($countperlakuan*$key3)+1))->applyFromArray($GreenColor);
					$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+4].($awal+($countperlakuan*$key3)).':'.$kolomBulan[$jumlahBulan+4].($awal+($countperlakuan*$key3)+2))->applyFromArray($BlueColor);
					$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+5].($awal+($countperlakuan*$key3)).':'.$kolomBulan[$jumlahBulan+5].($awal+($countperlakuan*$key3)+3))->applyFromArray($PinkColor);
					$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+6].($awal+($countperlakuan*$key3)).':'.$kolomBulan[$jumlahBulan+6].($awal+($countperlakuan*$key3)+4))->applyFromArray($BrownColor);
					$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+7].($awal+($countperlakuan*$key3)).':'.$kolomBulan[$jumlahBulan+7].($awal+($countperlakuan*$key3)+5))->applyFromArray($GreyColor);
					
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValueExplicit($kolomBulan[$key2+1]  .'6', $bulan);

					if(($plkn['limbah_perlakuan'] == $dataPerlakuan) && ($bulan == $dataTanggal) && ($HE['id_jenis_limbah'] == $dataJenisLimbah)) {
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValueExplicit($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+$key1), number_format($LT['total_limbah'],3,'.',''));
					}
					else {
						$cols = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+$key1))->getValue();
						if ($cols == NULL || $cols == '') {
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValueExplicit($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+$key1), '0');
						}
					}
				}
			}
			$simpanBulanSebelum = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2].''.(($awal+($countperlakuan*$key3))+1))->getValue();
			if($simpanBulanSebelum == '' || $simpanBulanSebelum == NULL) {
				$simpanBulanSebelum = 0;
			} else {
				$simpanBulanSebelum = (float)$simpanBulanSebelum;
			}

			$simpanBulanIni = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+1))->getValue();
			if($simpanBulanIni == '' || $simpanBulanIni == NULL) {
				$simpanBulanIni = 0;
			} else {
				$simpanBulanIni = (float)$simpanBulanIni;
			}

			$hasilBulanIni = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))))->getValue();
			if($hasilBulanIni == '' || $hasilBulanIni == NULL) {
				$hasilBulanIni = 0;
			} else {
				$hasilBulanIni = (float)$hasilBulanIni;
			}

			$hasilHitungPerBulan = $simpanBulanSebelum+$simpanBulanIni+$hasilBulanIni;

			$totalLimbahPerlakuan = 0;

			for($i = 2; $i < $countperlakuan-1; $i++) {
				$limbahDibuang = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+$i))->getValue();
				if($limbahDibuang == '0' || $limbahDibuang == 0) {
					$limbahDibuang == 0;
				} else {
					$limbahDibuang = (float)$limbahDibuang;
				}
				$totalLimbahPerlakuan += $limbahDibuang;
			}

			$totalPerBulan = $hasilHitungPerBulan - $totalLimbahPerlakuan;

			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+1), number_format($totalPerBulan,3,'.',''));

			$limbahDihasilkan = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))))->getValue();
			if($limbahDihasilkan == '' || $limbahDihasilkan == NULL) {
				$limbahDihasilkan = 0;
			} else {
				$limbahDihasilkan = (float)$limbahDihasilkan;
			}

			$totalPerHeaderDihasilkan += $limbahDihasilkan;

			//Dimanfaatkan Sendiri
			$limbahDimanfaatkan = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+2))->getValue();
			if($limbahDimanfaatkan == '' || $limbahDimanfaatkan == NULL) {
				$limbahDimanfaatkan = 0;
			} else {
				$limbahDimanfaatkan = (float)$limbahDimanfaatkan;
			}

			$totalPerHeaderDimanfaatkan += $limbahDimanfaatkan;

			//Diolah Sendiri
			$limbahDiolah = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+3))->getValue();
			if($limbahDiolah == '' || $limbahDiolah == NULL) {
				$limbahDiolah = 0;
			} else {
				$limbahDiolah = (float)$limbahDiolah;
			}

			$totalPerHeaderDiolah += $limbahDiolah;

			//Ditimbun Sendiri
			$limbahDitimbun = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+4))->getValue();
			if($limbahDitimbun == '' || $limbahDitimbun == NULL) {
				$limbahDitimbun = 0;
			} else {
				$limbahDitimbun = (float)$limbahDitimbun;
			}

			$totalPerHeaderDitimbun += $limbahDitimbun;

			//Diserahkan Pihak Ketiga
			$limbahDiserahkan = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+5))->getValue();
			if($limbahDiserahkan == '' || $limbahDiserahkan == NULL) {
				$limbahDiserahkan = 0;
			} else {
				$limbahDiserahkan = (float)$limbahDiserahkan;
			}

			$totalPerHeaderDiserahkan += $limbahDiserahkan;

			//Tidak Dikelola
			$limbahTidakDikelola = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$key2+1].''.(($awal+($countperlakuan*$key3))+6))->getValue();
			if($limbahTidakDikelola == '' || $limbahTidakDikelola == NULL) {
				$limbahTidakDikelola = 0;
			} else {
				$limbahTidakDikelola = (float)$limbahTidakDikelola;
			}

			$totalPerHeaderTidakDikelola += $limbahTidakDikelola;
		}

		//Dihasilkan
		$sisaBulanLaluDisimpanTPS = $objPHPExcel->getActiveSheet()->getCell('F'.($awal+($countperlakuan*$key3)+1))->getValue();
		if($sisaBulanLaluDisimpanTPS == '' || $sisaBulanLaluDisimpanTPS == NULL) {
			$sisaBulanLaluDisimpanTPS = 0;
		} else {
			$sisaBulanLaluDisimpanTPS = (float)$sisaBulanLaluDisimpanTPS;
		}
		$totalLimbahDihasilkan = $totalPerHeaderDihasilkan + $sisaBulanLaluDisimpanTPS;

		//Dimanfaatkan Sendiri
		$sisaBulanLaluDimanfaatkan = $objPHPExcel->getActiveSheet()->getCell('F'.($awal+($countperlakuan*$key3)+2))->getValue();
		if($sisaBulanLaluDimanfaatkan == '' || $sisaBulanLaluDimanfaatkan == NULL) {
			$sisaBulanLaluDimanfaatkan = 0;
		} else {
			$sisaBulanLaluDimanfaatkan = (float)$sisaBulanLaluDimanfaatkan;
		}
		$totalLimbahDimanfaatkan = $totalPerHeaderDimanfaatkan + $sisaBulanLaluDimanfaatkan;

		//Diolah Sendiri
		$sisaBulanLaluDiolah = $objPHPExcel->getActiveSheet()->getCell('F'.($awal+($countperlakuan*$key3)+3))->getValue();
		if($sisaBulanLaluDiolah == '' || $sisaBulanLaluDiolah == NULL) {
			$sisaBulanLaluDiolah = 0;
		} else {
			$sisaBulanLaluDiolah = (float)$sisaBulanLaluDiolah;
		}
		$totalLimbahDiolah = $totalPerHeaderDiolah + $sisaBulanLaluDiolah;

		//Ditimbun Sendiri
		$sisaBulanLaluDitimbun = $objPHPExcel->getActiveSheet()->getCell('F'.($awal+($countperlakuan*$key3)+4))->getValue();
		if($sisaBulanLaluDitimbun == '' || $sisaBulanLaluDitimbun == NULL) {
			$sisaBulanLaluDitimbun = 0;
		} else {
			$sisaBulanLaluDitimbun = (float)$sisaBulanLaluDitimbun;
		}
		$totalLimbahDitimbun = $totalPerHeaderDitimbun + $sisaBulanLaluDitimbun;

		//Diserahkan Ke Pihak Ketiga
		$sisaBulanLaluDiserahkan = $objPHPExcel->getActiveSheet()->getCell('F'.($awal+($countperlakuan*$key3)+5))->getValue();
		if($sisaBulanLaluDiserahkan == '' || $sisaBulanLaluDiserahkan == NULL) {
			$sisaBulanLaluDiserahkan = 0;
		} else {
			$sisaBulanLaluDiserahkan = (float)$sisaBulanLaluDiserahkan;
		}
		$totalLimbahDiserahkan = $totalPerHeaderDiserahkan + $sisaBulanLaluDiserahkan;

		//Tidak Dikelola
		$sisaBulanLaluTidakDikelola = $objPHPExcel->getActiveSheet()->getCell('F'.($awal+($countperlakuan*$key3)+6))->getValue();
		if($sisaBulanLaluTidakDikelola == '' || $sisaBulanLaluTidakDikelola == NULL) {
			$sisaBulanLaluTidakDikelola = 0;
		} else {
			$sisaBulanLaluTidakDikelola = (float)$sisaBulanLaluTidakDikelola;
		}
		$totalLimbahTidakDikelola = $totalPerHeaderTidakDikelola + $sisaBulanLaluTidakDikelola;
		
		//Disimpan Di TPS
		$nilaiSimpanTPS = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan].($awal+($countperlakuan*$key3)+1))->getValue();
		if($nilaiSimpanTPS == '' || $nilaiSimpanTPS == NULL) {
			$nilaiSimpanTPS = 0;
		} else {
			$nilaiSimpanTPS = (float)$nilaiSimpanTPS;
		}

		//Dihasilkan
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomBulan[$jumlahBulan+1].''.(($awal+($countperlakuan*$key3))), number_format($totalLimbahDihasilkan,3,'.',''));

		//Disimpan Di TPS
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomBulan[$jumlahBulan+2].''.(($awal+($countperlakuan*$key3))+1), number_format($nilaiSimpanTPS,3,'.',''));

		//Dimanfaatkan Sendiri
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomBulan[$jumlahBulan+3].''.(($awal+($countperlakuan*$key3))+2), number_format($totalLimbahDimanfaatkan,3,'.',''));

		//Diolah Sendiri
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomBulan[$jumlahBulan+4].''.(($awal+($countperlakuan*$key3))+3), number_format($totalLimbahDiolah,3,'.',''));

		//Ditimbun Sendiri
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomBulan[$jumlahBulan+5].''.(($awal+($countperlakuan*$key3))+4), number_format($totalLimbahDitimbun,3,'.',''));

		//Diserahkan Ke Pihak Ketiga
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomBulan[$jumlahBulan+6].''.(($awal+($countperlakuan*$key3))+5), number_format($totalLimbahDiserahkan,3,'.',''));

		//Tidak Dikelola
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomBulan[$jumlahBulan+7].''.(($awal+($countperlakuan*$key3))+6), number_format($totalLimbahTidakDikelola,3,'.',''));

		//Jumlah Limbah Dihasilkan
		$JumlahLimbahDihasilkan = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+1].(($awal+($countperlakuan*$key3))))->getValue();
		if($JumlahLimbahDihasilkan == '' || $JumlahLimbahDihasilkan == NULL) {
			$JumlahLimbahDihasilkan = 0;
		} else {
			$JumlahLimbahDihasilkan = (float)$JumlahLimbahDihasilkan;
		}

		$totalJumlahDihasilkan += $JumlahLimbahDihasilkan;

		//Jumlah Limbah Disimpan TPS
		$JumlahLimbahDiSimpanTPS = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+2].(($awal+($countperlakuan*$key3))+1))->getValue();
		if($JumlahLimbahDiSimpanTPS == '' || $JumlahLimbahDiSimpanTPS == NULL) {
			$JumlahLimbahDiSimpanTPS = 0;
		} else {
			$JumlahLimbahDiSimpanTPS = (float)$JumlahLimbahDiSimpanTPS;
		}

		$totalJumlahDiSimpanTPS += $JumlahLimbahDiSimpanTPS;

		//Jumlah Limbah Dimanfaatkan 
		$JumlahLimbahDimanfaatkan = $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+3].(($awal+($countperlakuan*$key3))+2))->getValue();
		if($JumlahLimbahDimanfaatkan == '' || $JumlahLimbahDimanfaatkan == NULL) {
			$JumlahLimbahDimanfaatkan = 0;
		} else {
			$JumlahLimbahDimanfaatkan = (float)$JumlahLimbahDimanfaatkan;
		}

		$totalJumlahDimanfaatkan += $JumlahLimbahDimanfaatkan;

		//Jumlah Limbah Diolah 
		$JumlahLimbahDiolah= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+4].(($awal+($countperlakuan*$key3))+3))->getValue();
		if($JumlahLimbahDiolah == '' || $JumlahLimbahDiolah == NULL) {
			$JumlahLimbahDiolah = 0;
		} else {
			$JumlahLimbahDiolah = (float)$JumlahLimbahDiolah;
		}

		$totalJumlahDiolah += $JumlahLimbahDiolah;

		//Jumlah Limbah Ditimbun 
		$JumlahLimbahDitimbun= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+5].(($awal+($countperlakuan*$key3))+4))->getValue();
		if($JumlahLimbahDitimbun == '' || $JumlahLimbahDitimbun == NULL) {
			$JumlahLimbahDitimbun = 0;
		} else {
			$JumlahLimbahDitimbun = (float)$JumlahLimbahDitimbun;
		}

		$totalJumlahDitimbun += $JumlahLimbahDitimbun;

		//Jumlah Limbah Diserahkan 
		$JumlahLimbahDiserahkan= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+6].(($awal+($countperlakuan*$key3))+5))->getValue();
		if($JumlahLimbahDiserahkan == '' || $JumlahLimbahDiserahkan == NULL) {
			$JumlahLimbahDiserahkan = 0;
		} else {
			$JumlahLimbahDiserahkan = (float)$JumlahLimbahDiserahkan;
		}

		$totalJumlahDiserahkan += $JumlahLimbahDiserahkan;

		//Jumlah Limbah Tidak Dikelola 
		$JumlahLimbahTidakDikelola= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+7].(($awal+($countperlakuan*$key3))+6))->getValue();
		if($JumlahLimbahTidakDikelola == '' || $JumlahLimbahTidakDikelola == NULL) {
			$JumlahLimbahTidakDikelola = 0;
		} else {
			$JumlahLimbahTidakDikelola = (float)$JumlahLimbahTidakDikelola;
		}

		$totalJumlahTidakDikelola += $JumlahLimbahTidakDikelola;
	} 

	
	//Jumlah Limbah Dihasilkan
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+1].''.$kolomTotal, number_format($totalJumlahDihasilkan,3,'.',''));
	$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+1].''.$kolomTotal)->applyFromArray($YellowColor);

	//Jumlah Limbah Disimpan TPS
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+2].''.$kolomTotal, number_format($totalJumlahDiSimpanTPS,3,'.',''));
	$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+2].''.$kolomTotal)->applyFromArray($OranyeColor);

	//Jumlah Limbah Dimanfaatkan
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+3].''.$kolomTotal, number_format($totalJumlahDimanfaatkan,3,'.',''));
	$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+3].''.$kolomTotal)->applyFromArray($GreenColor);

	//Jumlah Limbah Diolah
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+4].''.$kolomTotal, number_format($totalJumlahDiolah,3,'.',''));
	$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+4].''.$kolomTotal)->applyFromArray($BlueColor);

	//Jumlah Limbah Ditimbun
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+5].''.$kolomTotal, number_format($totalJumlahDitimbun,3,'.',''));
	$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+5].''.$kolomTotal)->applyFromArray($PinkColor);

	//Jumlah Limbah Diserahkan
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+6].''.$kolomTotal, number_format($totalJumlahDiserahkan,3,'.',''));
	$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+6].''.$kolomTotal)->applyFromArray($BrownColor);

	//Jumlah Limbah Tidak Dikelola
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+7].''.$kolomTotal, number_format($totalJumlahTidakDikelola,3,'.',''));
	$objPHPExcel->getActiveSheet()->getStyle($kolomBulan[$jumlahBulan+7].''.$kolomTotal)->applyFromArray($GreyColor);

//Persentase Penataan
	$NilaiLimbahDihasilkan=$objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+1].''.$kolomTotal)->getValue();
	if((float)$NilaiLimbahDihasilkan == 0) {
		$pembagiNilaiLimbahDihasilkan = 1;
	} else {
		$pembagiNilaiLimbahDihasilkan = $NilaiLimbahDihasilkan;
	}

	//Disimpan Di TPS
	$PersentaseDisimpan= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+2].''.$kolomTotal)->getValue();

	$TotalPersentaseDisimpan = round((((float)$PersentaseDisimpan/(float)$pembagiNilaiLimbahDihasilkan)*100), 2);

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+2].''.($kolomTotal+1), $TotalPersentaseDisimpan.'%');

	//Dimanfaatkan Sendiri
	$PersentaseDimanfaatkan= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+3].''.$kolomTotal)->getValue();

	$TotalPersentaseDimanfaatkan = round((((float)$PersentaseDimanfaatkan/(float)$pembagiNilaiLimbahDihasilkan)*100), 2);

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+3].''.($kolomTotal+1), $TotalPersentaseDimanfaatkan.'%');
	
	//Diolah Sendiri
	$PersentaseDiolah= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+4].''.$kolomTotal)->getValue();

	$TotalPersentaseDiolah = round((((float)$PersentaseDiolah/(float)$pembagiNilaiLimbahDihasilkan)*100), 2);

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+4].''.($kolomTotal+1), $TotalPersentaseDiolah.'%');

	//Ditimbun Sendiri
	$PersentaseDitimbun= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+5].''.$kolomTotal)->getValue();

	$TotalPersentaseDitimbun = round((((float)$PersentaseDitimbun/(float)$pembagiNilaiLimbahDihasilkan)*100), 2);

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+5].''.($kolomTotal+1), $TotalPersentaseDitimbun.'%');
		
	//Diserahkan Kepihak Ketiga
	$PersentaseDiserahkan= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+6].''.$kolomTotal)->getValue();

	$TotalPersentaseDiserahkan = round((((float)$PersentaseDiserahkan/(float)$pembagiNilaiLimbahDihasilkan)*100), 2);

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+6].''.($kolomTotal+1), $TotalPersentaseDiserahkan.'%');

	//Tidak Dikelola
	$PersentaseTidakDikelola= $objPHPExcel->getActiveSheet()->getCell($kolomBulan[$jumlahBulan+7].''.$kolomTotal)->getValue();

	$TotalPersentaseTidakDikelola = round((((float)$PersentaseTidakDikelola/(float)$pembagiNilaiLimbahDihasilkan)*100), 2);

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+7].''.($kolomTotal+1), $TotalPersentaseTidakDikelola.'%');

	//Total Persentase Perlakuan
	$TotalPersentase = round(((float)$TotalPersentaseDisimpan + (float)$TotalPersentaseDimanfaatkan + (float)$TotalPersentaseDiolah + (float)$TotalPersentaseDitimbun + (float)$TotalPersentaseDiserahkan), 2); 

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+2].''.($kolomTotal+2), $TotalPersentase.'%');

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit($kolomBulan[$jumlahBulan+7].''.($kolomTotal+2), $TotalPersentaseTidakDikelola.'%');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
		
?>