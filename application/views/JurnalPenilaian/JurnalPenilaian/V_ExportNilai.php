<?php

$objPHPExcel = new PHPExcel();
$styleArray = array(
    'font'  => array(
        'size'  => 11,
        'name'  => 'Times New Roman'
    ),
	'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
	);

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Evaluasi Penilaian');
	$objPHPExcel->getActiveSheet()->getStyle('A:Z')->applyFromArray($styleArray);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	

	// Redirect output to a client?s web browser (Excel5)
	//tambahkan paling atas
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$filename."");
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
				->setCellValue('A1', 'Unit Group \ Golongan');
	for($i = 0; $i < count($daftarUnitGroup); $i++)
	{
		$baris 	=	$i+2;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$baris, $daftarUnitGroup[($i)]['unit_group']);
	}


	$kolom  	= 	'B';
	for ($j = 1; $j <= $jumlahGolongan ; $j++) 
	{
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($kolom.'1', $j);
		$kolom++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($kolom.'1', 'Total');

	$kolomGolongan 	=	'B';
	for ($k = 0; $k < count($daftarUnitGroup) ; $k++) 
	{
		for ($m = 0; $m < $jumlahGolongan; $m++) 
		{
			
		}
		$kolomGolongan++;
	}


	// $no = 0;
	// $i=1;
	// foreach($record as $tc){

	// 	foreach($cabang as $cb){
	// 		if($tc['cabang'] == $cb->kd_lokasi){
	// 		$lokasi_kerja = $cb->lokasi_kerja;
	// 		}
	// 		}
																	

	// $i++;
	// $no++;
	// //load ke excel
	// $kolomA='A'.$i;
	// $kolomB='B'.$i;
	// $kolomC='C'.$i;
	// $kolomD='D'.$i;
	// $kolomE='E'.$i;
	// $kolomF='F'.$i;
	// $kolomG='G'.$i;
	// $kolomH='H'.$i;
	// $kolomI='I'.$i;
	// $kolomJ='J'.$i;
	// $kolomK='K'.$i;
	// $kolomL='L'.$i;
	// $kolomM='M'.$i;
	// $kolomN='N'.$i;
	// $kolomO='O'.$i;
	// $kolomP='P'.$i;
	// $kolomQ='Q'.$i;
	// $kolomR='R'.$i;
	// $kolomS='S'.$i;
	// $kolomT='T'.$i;
	// $kolomU='U'.$i;
	// $kolomV='V'.$i;
	// $kolomW='W'.$i;
	// $kolomX='X'.$i;
	// $kolomY='Y'.$i;
	// $kolomZ='Z'.$i;
	// $kolomAA='AA'.$i;
	// $kolomAB='AB'.$i;
	// $kolomAC='AC'.$i;
	// $kolomAD='AD'.$i;
	// $kolomAE='AE'.$i;
	// $objPHPExcel->setActiveSheetIndex(0)
	// 			->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomB, $tc['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomC, $tc['noind_baru'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomD, $tc['kodesie'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomE, $tc['nama'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomF, $tc['cabang'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomG, $tc['gpokok'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomH, $tc['insabc'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomI, $tc['inskedis'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomJ, $tc['inskepatuhan'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomK, $tc['ubt'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomL, $tc['upamk'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomM, $tc['plepas'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomN, $tc['um'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomO, $tc['shift'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomP, $tc['pkj'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomQ, $tc['pdl'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomR, $tc['htm'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomS, $tc['psk'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomT, $tc['lembur'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomU, $tc['ct'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomV, $tc['jml_ikp'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomW, $tc['total_tim'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomX, $tc['jml_tt'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomY, $tc['waktu_tt'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomZ, $tc['jam_kerja'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomAA, $tc['tgl_awal'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomAB, $tc['tgl_akhir'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomAC, $tc['tgl_proses'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomAD, $tc['status'], PHPExcel_Cell_DataType::TYPE_STRING)
	// 			->setCellValueExplicit($kolomAE, $tc['masa_kerja'], PHPExcel_Cell_DataType::TYPE_NUMERIC);		
	// }
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	