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

//UNTUK CETAK KE XLS--------------------------------------------------------------------------------------------
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
	$objPHPExcel->getActiveSheet()->getStyle('A:AE')->applyFromArray($styleArray);

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
	$style_col = array(
          'font' => array('bold' => false),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
          )
        );

        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
          )
        );

	// Add some data
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'NO');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'NOIND');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'NAMA');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'SEKSI');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'LOKASI');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'NO KES');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', 'TANGGAL');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', 'NAMA&TTD');
		foreach(range('A','H') as $columnID) {
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
	            ->setAutoSize(true);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
	        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight("20");
	        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
	        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("10");
	        $objPHPExcel->getActiveSheet()->getStyle($columnID.'3')->applyFromArray($style_col);
	        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment(false);

	        $ii=4;
	        foreach ($data as $key) {
	        	$objPHPExcel->getActiveSheet()->getStyle($columnID.$ii)->applyFromArray($style_col);
	        	$ii++;	        	
	        }
	    }
				
	$no = 0;
	$i=3;
 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "TANDA TERIMA KARTU BPJS KESEHATAN");
    $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  
    $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	foreach($data as $tc){
																	

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
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomB, $tc['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomC, $tc['nama'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomD, $tc['seksi'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomE, $tc['lokasi'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomF, $tc['no_kes'], PHPExcel_Cell_DataType::TYPE_STRING)
				->setCellValueExplicit($kolomG, date('Y-m-d', strtotime($tc['created_timestamp'])), PHPExcel_Cell_DataType::TYPE_STRING);
	
       }
					
	

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	?>	