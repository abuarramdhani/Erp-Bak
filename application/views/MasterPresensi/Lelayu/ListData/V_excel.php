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
  $objPHPExcel->getActiveSheet()->getStyle('A:G')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setHorizontal('center');
  $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getAlignment()->setHorizontal('center');
  $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(true);

  //Set active sheet index to the first sheet, soExcel opens this as the first Sheet1
  $objPHPExcel->setActiveSheetIndex(0);

  // Redirect output to a client's web browser (Excel 5)

  header('Content-type: application/vnd-ms-excel');
  header('Content-Disposition: attachment; filename="RekapLelayu-'.$date.'.xlsx"');
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
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
  $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
  foreach (range('C','E') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(10);
  }

//add header
  $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A2', 'DATA LELAYU')
      ->setCellValue('A4', 'No')
      ->setCellValue('B4', 'Tanggal Lelayu')
      ->setCellValue('C4', 'Noind')
      ->setCellValue('D4', 'Nama')
      ->setCellValue('E4', 'Keterangan')
      ->setCellValue('F4', 'Uang Duka Perusahaan')
      ->setCellValue('G4', 'Uang Duka SPSI');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');

  $no = 0;
  $i=4;
  foreach ($exportExcel as $Lelayu) {

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

  $tanggalLelayu = date('d-m-Y', strtotime($Lelayu['tgl_lelayu']));
  $spsi = number_format($Lelayu['spsi'],2,',','.');
  $perusahaan = number_format($Lelayu['perusahaan'],2,',','.');
  $namaLelayu = ucwords(mb_strtolower($Lelayu['nama']));

  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValueExplicit($kolomA, $no, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomB, $tanggalLelayu, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomC, $Lelayu['noind'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomD, $namaLelayu, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomE, $Lelayu['keterangan'], PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomF, 'Rp '.$perusahaan, PHPExcel_Cell_DataType::TYPE_STRING)
              ->setCellValueExplicit($kolomG, 'Rp '.$spsi, PHPExcel_Cell_DataType::TYPE_STRING);
  }

    $hitung = $i;

  $objPHPExcel->getActiveSheet()->getStyle('F'.($hitung+2).':G'.($hitung+2))->getAlignment();
  $objPHPExcel->getActiveSheet()->getStyle('F'.($hitung+2).':G'.($hitung+2))->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('F'.($hitung+7).':G'.($hitung+7))->getAlignment();
  $objPHPExcel->getActiveSheet()->getStyle('F'.($hitung+7).':G'.($hitung+7))->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('F'.($hitung+8).':G'.($hitung+8))->getAlignment();

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.($hitung+2).':G'.($hitung+2));
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.($hitung+7).':G'.($hitung+7));
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.($hitung+8).':G'.($hitung+8));

$name = ucwords(mb_strtolower($atasan[0]['nama']));
$jabatan = ucwords(mb_strtolower($atasan[0]['jabatan']));

  $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('F'.($hitung+2), 'Departemen Personalia')
        ->setCellValue('F'.($hitung+7), $name)
        ->setCellValue('F'.($hitung+8), $jabatan);

  $objPHPExcel->getActiveSheet()->getStyle('A4:G'.$hitung) ->applyFromArray($border_all);

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save('php://output');
  exit;

 ?>
