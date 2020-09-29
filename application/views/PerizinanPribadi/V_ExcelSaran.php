<?php

/**
 * helper
 */
function debug($data)
{
    echo "<pre>";
    print_r($data);
    die;
}

$objWriter = new PHPExcel();
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

$objWriter->getActiveSheet()->setTitle('Rekap Kritik dan Saran');
$objWriter->getActiveSheet()->getStyle('A2')->applyFromArray($style1);

//add header
$array_judul = array(
    '0' => array(
        'nama' => 'No',
        'lebar' => 5
    ),
    '1' => array(
        'nama' => 'Tanggal',
        'lebar' => 10
    ),
    '2' => array(
        'nama' => 'Pekerja',
        'lebar' => 40
    ),
    '3' => array(
        'nama' => 'Saran',
        'lebar' => 40
    ),
);
$bariske = '4';
$nom = 0;
$alphabet = range('A', 'Z');
$higestColumn = $alphabet[count($array_judul) - 1];

$a = $objWriter->setActiveSheetIndex(0);
for ($i = 'A'; $i <= $higestColumn; $i++) {
    $a->setCellValue($i . $bariske, $array_judul[$nom]['nama']);
    $objWriter->getActiveSheet()->getColumnDimension($i)->setWidth($array_judul[$nom]['lebar']);
    $nom++;
}

$objWriter->getActiveSheet()->getStyle('A1:' . $higestColumn . '4')->getFont()->setBold(true);
$objWriter->getActiveSheet()->getStyle('A4:' . $higestColumn . '4')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '#329ba8')
        )
    )
);
$objWriter->getDefaultStyle()->applyFromArray($styleArray);
$objWriter->setActiveSheetIndex(0)->mergeCells('A2:' . $higestColumn . '2');
for ($i = 'A'; $i <= $objWriter->getActiveSheet()->getHighestColumn(); $i++) {
    $objWriter->getActiveSheet()->getStyle($i)->getAlignment()->setWrapText(TRUE);
    $objWriter->getActiveSheet()->getStyle($i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
}

$i = 5;
$no = 1;

foreach ($data as $key) {
    $pekerja = '';
    foreach (explode('<br>', $key['noind']) as $a) {
        $pekerja .= "$a\n";
    }


    $array_value = array(
        $no,
        date('d M Y', strtotime($key['created_date'])),
        $pekerja,
        $key['saran']
    );

    $nam = 0;
    $objWriter->setActiveSheetIndex(0)
        ->setCellValue('A2', 'DATA REKAP KRITIK DAN SARAN');
    for ($forVal = 'A'; $forVal <= $higestColumn; $forVal++) {
        $objWriter->getActiveSheet()->setCellValue($forVal . $i, $array_value[$nam], PHPExcel_Cell_DataType::TYPE_STRING);
        $nam++;
    }

    $i++;
    $no++;
}

$objWriter->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objWriter->getActiveSheet()->getPageSetup()->setFitToHeight(1);

header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename="Rekap Kritik dan Saran Perizinan.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objWriter, 'Excel5');
$objWriter->save('php://output');
exit;
