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
  $objPHPExcel->getActiveSheet()->setTitle('Tambahan');
  $objPHPExcel->getActiveSheet()->getStyle('A:F')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
  $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A4:F4')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A4:F4')->getAlignment();
  $objPHPExcel->getActiveSheet()->getStyle('A4:F4')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getAlignment();

  // Redirect output to a client's web browser (Excel 5)

  header('Content-type: application/vnd-ms-excel');
  header('Content-Disposition: attachment; filename="Rekap Tambahan Makan Dinas.xlsx"');
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
  $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(60);

//add header
  $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A2', 'REKAP TAMBAHAN MAKAN PEKERJA DINAS')
      ->setCellValue('A4', 'No')
      ->setCellValue('B4', 'Tanggal')
      ->setCellValue('C4', 'No. Induk')
      ->setCellValue('D4', 'Nama')
      ->setCellValue('E4', 'Tujuan')
      ->setCellValue('F4', 'Keperluan');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');


  $no = 0;
  $i=4;
  foreach ($tambahan as $key) {
  $i++;
  $no++;
  //load ke excel
  $kolomA='A'.$i;
  $kolomB='B'.$i;
  $kolomC='C'.$i;
  $kolomD='D'.$i;
  $kolomE='E'.$i;
  $kolomF='F'.$i;


  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomB, date('d/m/Y', strtotime($key['fd_tanggal'])), PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomC, $key['fs_noind'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomD, $key['fs_nama'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomE, $key['fs_tempat_makan'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomF, ucwords(mb_strtolower($key['fs_ket'])), PHPExcel_Cell_DataType::TYPE_STRING);
      // }
    }

    $objPHPExcel->getActiveSheet()->getStyle('A4:F'.$i) ->applyFromArray($border_all);


    //Create sheet 2

    $objWorkSheet = $objPHPExcel->createSheet(2);
    $objWorkSheet
    ->setCellValue('A2', 'REKAP PENGURANGAN MAKAN PEKERJA DINAS')
    ->setCellValue('A4', 'No')
    ->setCellValue('B4', 'Tanggal')
    ->setCellValue('C4', 'No. Induk')
    ->setCellValue('D4', 'Nama')
    ->setCellValue('E4', 'Tempat Makan')
    ->setCellValue('F4', 'Keperluan');

    $objWorkSheet->mergeCells('A2:F2');
    $objWorkSheet->setTitle('Pengurangan');
    $objWorkSheet->getStyle('A:F')->applyFromArray($styleArray);
    $objWorkSheet->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
    $objWorkSheet->getStyle('A2:F2')->getFont()->setBold(true);
    $objWorkSheet->getStyle('A4:F4')->getFont()->setBold(true);
    $objWorkSheet->getStyle('A4:F4')->getAlignment();
    $objWorkSheet->getStyle('A4:F4')->getFont()->setBold(true);
    $objWorkSheet->getStyle('A5:F5')->getAlignment();

    $objWorkSheet->getColumnDimension('A')->setWidth(5);
    $objWorkSheet->getColumnDimension('B')->setWidth(10);
    $objWorkSheet->getColumnDimension('C')->setWidth(10);
    $objWorkSheet->getColumnDimension('D')->setWidth(30);
    $objWorkSheet->getColumnDimension('E')->setWidth(20);
    $objWorkSheet->getColumnDimension('F')->setWidth(60);

$a = 0;
$b = 4;
  foreach ($kurang as $key) {
  $b++;
  $a++;
  //load ke excel
  $kolomA='A'.$b;
  $kolomB='B'.$b;
  $kolomC='C'.$b;
  $kolomD='D'.$b;
  $kolomE='E'.$b;
  $kolomF='F'.$b;


    $objWorkSheet
              ->setCellValueExplicit($kolomA, $a, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomB, date('d/m/Y', strtotime($key['fd_tanggal'])), PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomC, $key['fs_noind'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomD, $key['fs_nama'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomE, $key['fs_tempat_makan'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomF, ucwords(mb_strtolower($key['fs_ket'])), PHPExcel_Cell_DataType::TYPE_STRING);
    }

    $objWorkSheet->getStyle('A4:F'.$b) ->applyFromArray($border_all);


  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save('php://output');

 ?>
