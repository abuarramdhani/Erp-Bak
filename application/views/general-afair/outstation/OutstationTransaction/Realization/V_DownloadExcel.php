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
	$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A8:K8')->getFont()->setBold(true);

	// $objPHPExcel->getActiveSheet()->getStyle('A:G')->applyFromArray($styleBorder);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	

	// Redirect output to a client?s web browser (Excel5)

	header('Content-type: application/vnd-ms-excel');
	header('Content-Disposition: attachment; filename="Outstation-Report.xlsx"');
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

	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'KERTAS KERJA PENGECEKAN LAPORAN DINAS LUAR')
				->setCellValue('A3', 'Nama :')
				->setCellValue('A4', 'No. Induk :')
				->setCellValue('A5', 'Tujuan :')
				->setCellValue('A6', 'Tanggal :')
				->setCellValue('A8', 'No.')
				->setCellValue('B8', 'Tanggal')
				->setCellValue('C8', 'Jam')
				->setCellValue('D8', 'Lokasi')
				->setCellValue('E8', 'Aktivitas')
				->setCellValue('F8', 'Jenis Biaya')
				->setCellValue('G8', 'Nominal')
				->setCellValue('H8', 'No. Urut Nota')
				->setCellValue('I8', 'Kesesuaian Nota dengan Aktivitas')
				->setCellValue('J8', 'Kesesuaian Aktivitas dengan Waktu')
				->setCellValue('K8', 'Konfirmasi pihak ketiga');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:D3');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:D4');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:D5');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:D6');

	$no = 0;
	$i = 8;	
	foreach ($data_realization_detail as $data_realdet) {												
	
	$i++;
	$no++;
	//load ke excel
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

//    $tanggalkeluar = date('d M Y', strtotime($FD['tanggal_keluar']));
		foreach ($Component as $comp) {
			if($data_realdet['component_id'] == $comp['component_id']) {
				
			}
		}
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, '', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, '', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, '', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomE, $data_realdet['info'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomF, $data_realdet['component_id'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomG, $data_realdet['nominal'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomH, $data_realdet['nomor_urut_nota'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomI, 'Sesuai / Tidak Sesuai', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomJ, 'Sesuai / Tidak Sesuai', PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomK, '', PHPExcel_Cell_DataType::TYPE_STRING);
	}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>		 	 	 	 	