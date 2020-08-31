<?php
$objWriter = new PHPExcel();
if ($jenis == '1') {
    $warna = '20ab2e';
    $judul = 'Rekap Perizinan Pribadi';
} else {
    $warna = 'f29e1f';
    $judul = 'Rekap Perizinan Seksi';
}
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename="' . $judul . '.xls"');
header('Cache-Control: max-age=0');
$objWriter->getActiveSheet()
    ->getPageSetup()
    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE)
    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$style1 = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);
$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);
$objWriter->getActiveSheet()->getStyle('A4:H4')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => $warna)
        )
    )
);
$objWriter->setActiveSheetIndex(0);
$objWriter->getDefaultStyle()->applyFromArray($styleArray);

$objWriter->getActiveSheet()->setTitle('Rekap Seksi');
for ($i = 'A'; $i <=  $objWriter->getActiveSheet()->getHighestColumn(); $i++) {
    $objWriter->getActiveSheet()->getStyle($i)->getAlignment()->setWrapText(TRUE);
    $objWriter->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
}

$objWriter->getActiveSheet()->getStyle('A1:H4')->getFont()->setBold(true);
$objWriter->getActiveSheet()->getStyle('A2')->applyFromArray($style1);
$objWriter->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objWriter->getActiveSheet()->getColumnDimension('B')->setWidth(5);
$objWriter->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objWriter->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$objWriter->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objWriter->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objWriter->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objWriter->getActiveSheet()->getColumnDimension('H')->setWidth(30);

//add header
$objWriter->setActiveSheetIndex(0)
    ->setCellValue('A2', 'DATA REKAP PERIZINAN SEKSI')
    ->setCellValue('A4', 'No')
    ->setCellValue('B4', 'ID Izin')
    ->setCellValue('C4', 'Tgl Pengajuan')
    ->setCellValue('D4', 'Pekerja')
    ->setCellValue('E4', 'Jenis izin')
    ->setCellValue('F4', 'Atasan')
    ->setCellValue('G4', 'Keterangan')
    ->setCellValue('H4', 'Status');

$objWriter->setActiveSheetIndex(0)->mergeCells('A2:H2');

$no = 0;
$i = 4;
foreach ($IzinApprove as $key) {
    $i++;
    $no++;
    $nama = '';
    foreach (explode(',', $key['nama_pkj']) as $a) {
        $nama .= "$a\n";
    }

    $objWriter->getActiveSheet()
        ->setCellValue('A' . $i, $no)
        ->setCellValue('B' . $i, $key['id'])
        ->setCellValue('C' . $i, date('d M Y', strtotime($key['created_date'])))
        ->setCellValue('D' . $i, $nama)
        ->setCellValue('E' . $i, $key['jenis_ijin'])
        ->setCellValue('F' . $i, $key['atasan'] . ' - ' . $key['nama_atasan'])
        ->setCellValue('G' . $i, $key['ket_pekerja'])
        ->setCellValue('H' . $i, $key['status']);
}

$objWriter->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objWriter->getActiveSheet()->getPageSetup()->setFitToHeight(1);

$objWriter = PHPExcel_IOFactory::createWriter($objWriter, 'Excel5');
$objWriter->save('php://output');
exit;
