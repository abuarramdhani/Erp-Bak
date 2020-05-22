<?php
$filename = 'Cetak_kesepakatan_kerja_'.date('d_m_Y');

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
$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
$objPHPExcel->getActiveSheet()->getStyle('A:G')->applyFromArray($styleArray);

$objPHPExcel->setActiveSheetIndex(0);

// Set document properties
$objPHPExcel->getProperties()
                ->setCreator("Sistem")
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

$style_h1 = array(
  'font'  => array(
    'size'  => 15,
    'name'  => 'Times New Roman'
  )
);

$style_text_left = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
  )
);

$style_title = array(
  'font' => array('bold' => true),
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
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

// tanggal indo
$monthIndo = "Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember";
$arrMonthIndo = explode(' ', $monthIndo);
$month = $arrMonthIndo[(int)date('m')-1];
$tanggal = date('d')." ".$month." ".date('Y');
// document title
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'TANDA TERIMA KESEPAKATAN KERJA');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'TGL : '. $tanggal);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray($style_title)->applyFromArray($style_h1);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Dicetak oleh: '.$print_by);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Dicetak tanggal: '. $print_time);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:G4');

$i = 6;
// table header
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i", 'NO');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$i", 'NOIND');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$i", 'NAMA');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$i", 'SEKSI');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$i", 'TGL MASUK');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$i", 'LOKASI');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$i", 'NAMA&TTD');
foreach(range('A', 'G') as $column) {
  $objPHPExcel->getActiveSheet()->getStyle($column.$i)->applyFromArray($style_col)->applyFromArray($style_title);
}

// set column style
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("4");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("8");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("50");
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("15");

// start row
$i++;
$start_row = $i;
$no = 0;
// write table content
foreach($data as $item){
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
      ->setCellValueExplicit($kolomB, $item['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
      ->setCellValueExplicit($kolomC, $item['nama'], PHPExcel_Cell_DataType::TYPE_STRING)
      ->setCellValueExplicit($kolomD, $item['seksi'], PHPExcel_Cell_DataType::TYPE_STRING)
      ->setCellValueExplicit($kolomE, $item['tgl_masuk'], PHPExcel_Cell_DataType::TYPE_STRING)
      ->setCellValueExplicit($kolomF, $item['lokasi'], PHPExcel_Cell_DataType::TYPE_STRING);

  foreach(range('A', 'G') as $column) {
    $objPHPExcel->getActiveSheet()->getStyle($column.$i)->applyFromArray($style_col);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($style_text_left);
  }
}


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$filename.".xls");
// header("Content-Disposition: attachment; filename=adadad.xls");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');