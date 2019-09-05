<?php

$objPHPExcel = new PHPExcel();
$styleArray = array(
            'font' => array(
              'size' => 12 ,
              'name' => 'Times New Roman'
            ),
            'alignment' => array(
              'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
          );
$border_all = array ('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('black'),)));

//UNTUK CETAK KE XLS
  //orientation page
  $objPHPExcel->getActiveSheet()
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
  $objPHPExcel->getActiveSheet()
    ->getPageSetup()
    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
  //Print set fit one page
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
  //Rename Worksite
  $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
  $objPHPExcel->getActiveSheet()->getStyle('A:D')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal('center');
  $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getAlignment();
  $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getAlignment();
  $objPHPExcel->getActiveSheet()->getStyle('C5:D'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText();
  $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getAlignment();
  $objPHPExcel->getActiveSheet()->getStyle('A6:D6')->getFont()->setBold(true);


  // $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getAlignment()->setWrapText(true);
  // $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getAlignment()->setHorizontal('center');

  //Set active sheet index to the first sheet, soExcel opens this as the first Sheet1
  $objPHPExcel->setActiveSheetIndex(0);

  // Redirect output to a client's web browser (Excel 5)

  header('Content-type: application/vnd-ms-excel');
  header('Content-Disposition: attachment; filename="Rekap Pekerja Terpotong SPSI-'.$date.'.xlsx"');
  header('Cache-Control: max-age=0');
  // If you're serving to IE 9, then the following may be needed
  header('Cache-Control: max-age=1');

  // If you're serving to IE over SSL, then the following may be needed
  header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
  header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
  header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
  header ('Pragma: public'); // HTTP/1.0

//set document properties
  $objPHPExcel->getProperties()->setCreator("Sistem")
              ->setLastModifiedBy("Sistem")
              ->setTitle("Sistem")
              ->setSubject("Sistem")
              ->setDescription("Sistem")
              ->setKeywords("Sistem")
              ->setCategory("Sistem");

//set width
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
  // foreach (range('C','E') as $columnID) {
  //   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(10);
  // }
//add header
  $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A2', 'DATA PEKERJA YANG TERKENA POTONGAN SPSI')
      ->setCellValue('A4', 'Lelayu dari')
      ->setCellValue('A5', 'Seksi')
      ->setCellValue('A6', 'Tanggal Lelayu')
      ->setCellValue('A8', 'No')
      ->setCellValue('B8', 'No. Induk')
      ->setCellValue('C8', 'Nama')
      ->setCellValue('D8', 'Nominal');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:D4');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:B5');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:D5');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:B6');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C6:D6');


  $no = 0;
  $i=8;
  foreach ($exportExcelSPSI as $Lelayu) {

  $i++;
  $no++;
  //load ke excel
  $kolomA='A'.$i;
  $kolomB='B'.$i;
  $kolomC='C'.$i;
  $kolomD='D'.$i;

  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomB, $Lelayu['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomC, $Lelayu['nama'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomD, $Lelayu['nominal'], PHPExcel_Cell_DataType::TYPE_STRING);
  }

  $tanggalLelayu = date('d-m-Y', strtotime($LelayuSPSI[0]['tgl_lelayu']));
  $namaLelayu = ucwords(mb_strtolower($LelayuSPSI[0]['nama']));
  $seksiLelayu = ucwords(mb_strtolower($LelayuSPSI[0]['seksi']));
  $objPHPExcel->setActiveSheetIndex(0)
  ->setCellValueExplicit('C4', $namaLelayu, PHPExcel_Cell_DataType::TYPE_STRING)
  ->setCellValueExplicit('C5', $seksiLelayu, PHPExcel_Cell_DataType::TYPE_STRING)
  ->setCellValueExplicit('C6', $tanggalLelayu, PHPExcel_Cell_DataType::TYPE_STRING);

    $hitung = $i;

  $objPHPExcel->getActiveSheet()->getStyle('C'.($hitung+2).':D'.($hitung+2))->getAlignment();
  $objPHPExcel->getActiveSheet()->getStyle('C'.($hitung+2).':D'.($hitung+2))->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('C'.($hitung+7).':D'.($hitung+7))->getAlignment();
  $objPHPExcel->getActiveSheet()->getStyle('C'.($hitung+7).':D'.($hitung+7))->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('C'.($hitung+8).':D'.($hitung+8))->getAlignment();

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($hitung+2).':D'.($hitung+2));
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($hitung+7).':D'.($hitung+7));
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($hitung+8).':D'.($hitung+8));

$name = ucwords(mb_strtolower($atasan[0]['nama']));
$jabatan = ucwords(mb_strtolower($atasan[0]['jabatan']));

  $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C'.($hitung+2), 'Departemen Personalia')
        ->setCellValue('C'.($hitung+7), $name)
        ->setCellValue('C'.($hitung+8), $jabatan);

  $objPHPExcel->getActiveSheet()->getStyle('A8:D'.$hitung) ->applyFromArray($border_all);

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save('php://output');
  exit;

 ?>
