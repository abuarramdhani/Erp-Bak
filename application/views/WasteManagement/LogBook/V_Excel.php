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
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  $objPHPExcel->getActiveSheet()
    ->getPageSetup()
    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
  //Print set fit one page
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
  //Rename Worksite
  $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
  $objPHPExcel->getActiveSheet()->getStyle('A:K')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal('center');
  $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getAlignment()->setHorizontal('center');
  $objPHPExcel->getActiveSheet()->getStyle('A5:K5')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getAlignment()->setWrapText(true);
  $objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getAlignment()->setHorizontal('center');

  //Set active sheet index to the first sheet, soExcel opens this as the first Sheet1
  $objPHPExcel->setActiveSheetIndex(0);

  // Redirect output to a client's web browser (Excel 5)

  header('Content-type: application/vnd-ms-excel');
  header('Content-Disposition: attachment; filename="LogbookHarian-LimbahB3.xlsx"');
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
  foreach (range('B','K') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(15);
  }

//add header
  $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A1', 'Logbook Harian Limbah Bahan Berbahaya Dan Beracun')
      ->setCellValue('A2', 'Lokasi Kerja : '.$lokasi)
      ->setCellValue('A3', 'Bulan : '.$allBulanIn)
      ->setCellValue('G3', 'Bulan : '.$allBulanOut)
      ->setCellValue('A5', 'Masuknya Limbah B3 Ke TPS')
      ->setCellValue('G5', 'Keluarnya Limbah B3 dari TPS')
      ->setCellValue('A6', 'No')
      ->setCellValue('B6', 'Jenis Limbah B3 Masuk')
      ->setCellValue('C6', 'Tanggal Limbah B3 Masuk')
      ->setCellValue('D6', 'Sumber Limbah B3')
      ->setCellValue('E6', 'Jumlah Limbah B3')
      ->setCellValue('F6', 'Maksimal Penyimpanan s/d Tanggal')
      ->setCellValue('G6', 'Tanggal Keluar Limbah B3')
      ->setCellValue('H6', 'Jumlah Limbah Keluar B3')
      ->setCellValue('I6', 'Tujuan Penyerahan')
      ->setCellValue('J6', 'Bukti Nomer Dokumen')
      ->setCellValue('K6', 'Sisa Limbah Yang Ada Di TPS');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G3:K3');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:F5');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G5:K5');

  $no = 0;
  $i=6;
  foreach ($filterMasuk as $FM) {

  $i++;
  $no++;
  //load ke excel
  $kolomA='A'.$i;
  $kolomB='B'.$i;
  $kolomC='C'.$i;
  $kolomD='D'.$i;
  $kolomE='E'.$i;
  $kolomF='F'.$i;

  $tanggalMasuk = date('d/m/Y', strtotime($FM['tanggal']));
  $maksPenyimpanan = date('d/m/Y', strtotime($FM['tanggalmax']));

  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomB, $FM['jenis_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomC, $tanggalMasuk, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomD, $FM['sumber'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomE, $FM['jumlah'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomF, $maksPenyimpanan, PHPExcel_Cell_DataType::TYPE_STRING);
  }

  $o=6;
  foreach ($filterKeluar as $FK) {

  $o++;

  //load ke excel
  $kolomG='G'.$o;
  $kolomH='H'.$o;
  $kolomI='I'.$o;
  $kolomJ='J'.$o;
  $kolomK='K'.$o;

    $tanggalKeluar = date('d/m/Y', strtotime($FK['tanggal']));

  $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueExplicit($kolomG, $tanggalKeluar, PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit($kolomH, $FK['jumlah'], PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit($kolomI, '', PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit($kolomJ, '', PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit($kolomK, '0', PHPExcel_Cell_DataType::TYPE_STRING);
  }

  if ($i > $o){
    $hitung = $i;
  }else {
    $hitung = $o;
  }

  $objPHPExcel->getActiveSheet()->getStyle('H'.($hitung+2).':K'.($hitung+2))->getAlignment()->setHorizontal('center');
  $objPHPExcel->getActiveSheet()->getStyle('H'.($hitung+2).':K'.($hitung+2))->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('H'.($hitung+7).':K'.($hitung+7))->getAlignment()->setHorizontal('center');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.($hitung+2).':K'.($hitung+2));
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.($hitung+7).':K'.($hitung+7));

  $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('H'.($hitung+2), 'Kepala Seksi Waste Management')
        ->setCellValue('H'.($hitung+7), $user_name);

  $objPHPExcel->getActiveSheet()->getStyle('A5:K'.$hitung) ->applyFromArray($border_all);

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save('php://output');
  exit;

 ?>
