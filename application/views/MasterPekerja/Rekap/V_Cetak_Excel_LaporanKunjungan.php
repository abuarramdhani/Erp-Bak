<?php

$objPHPExcel = new PHPExcel();

$head = array(
	'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
	'font'  => array(
			'bold'  => true,
			'size'  => 9
		),
   'alignment' => array(
       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
   ),
   'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ffb41f')
        )
);

$borderleft = array(
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    )
    ,
   'alignment' => array(
       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
   )
);
$borderright = array(
    'borders' => array(
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    )
);
$borderbottom = array(
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    )
);
$bordertop = array(
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    )
);

$tengah = array(
     'alignment' => array(
       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(26);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(26);
$objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
$objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
$objPHPExcel->getActiveSheet()->mergeCells('D2:D3');
$objPHPExcel->getActiveSheet()->mergeCells('E2:E3');
$objPHPExcel->getActiveSheet()->mergeCells('F2:F3');
$objPHPExcel->getActiveSheet()->mergeCells('G2:G3');

$objPHPExcel->getActiveSheet()
    ->getStyle('B2:B3')
    ->applyFromArray($head);
$objPHPExcel->getActiveSheet()
    ->getStyle('B2:B70')
    ->applyFromArray($borderleft);
$objPHPExcel->getActiveSheet()
    ->getStyle('C2:C3')
    ->applyFromArray($head);
$objPHPExcel->getActiveSheet()
    ->getStyle('D2:D3')
    ->applyFromArray($head);
$objPHPExcel->getActiveSheet()
    ->getStyle('E2:E3')
    ->applyFromArray($head);
$objPHPExcel->getActiveSheet()
    ->getStyle('F2:F3')
    ->applyFromArray($head);
$objPHPExcel->getActiveSheet()
    ->getStyle('G2:G3')
    ->applyFromArray($head);
$objPHPExcel->getActiveSheet()
    ->getStyle('G2:G70')
    ->applyFromArray($borderright);
$objPHPExcel->getActiveSheet()
    ->getStyle('B70:G70')
    ->applyFromArray($borderbottom);

$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('B2','Tanggal Pembuatan')
		->setCellValue('C2','Nomor Surat')
		->setCellValue('D2','Nomor Induk')
		->setCellValue('E2','Nama')
		->setCellValue('F2','Seksi')
		->setCellValue('G2','Pembuat / Petugas');

$i=4;

foreach ($rekap as $key => $data) {
    $i++;

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
    $kolomN='N'.$i;

$objPHPExcel->getActiveSheet()
    ->getStyle('C4:'.$kolomC)
    ->applyFromArray($tengah);
$objPHPExcel->getActiveSheet()
    ->getStyle('D4:'.$kolomD)
    ->applyFromArray($tengah);

$tanggal_laporan = date_create($data['tanggal_laporan']);
$tanggal_laporan = date_format($tanggal_laporan,'d-F-Y');

    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueExplicit($kolomB, $tanggal_laporan, PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomC, $data['no_surat'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomD, $data['noinduk_pekerja'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomE, $data['nama_pekerja'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomF, $data['seksi_pekerja'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomG, $data['petugas'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ;
}


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=RekapDataLaporanKunjungan_".$tanggal_awal."_".$tanggal_akhir.".xls");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
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
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>
