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
if ($perseksi == 'Ya') {
    $warna = 'f29e1f';
    $judul = 'Rekap Perizinan Seksi';
} else {
    $warna = '20ab2e';
    $judul = 'Rekap Perizinan Pribadi';
}

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

$objWriter->getActiveSheet()->setTitle('Rekap Perizinan Pribadi');
$objWriter->getActiveSheet()->getStyle('A2')->applyFromArray($style1);

//add header
$array_judul = array(
    '0' => array(
        'nama' => 'No',
        'lebar' => 5
    ),
    '1' => array(
        'nama' => 'Form Manual',
        'lebar' => 5
    ),
    '2' => array(
        'nama' => 'Sistem',
        'lebar' => 5
    ),
    '3' => array(
        'nama' => 'ID Izin',
        'lebar' => 5
    ),
    '4' => array(
        'nama' => 'Tgl Pengajuan',
        'lebar' => 15
    ),
    '5' => array(
        'nama' => 'Pekerja',
        'lebar' => 40
    ),
    '6' => array(
        'nama' => 'Seksi',
        'lebar' => 40
    ),
    '7' => array(
        'nama' => 'Lokasi Kerja',
        'lebar' => 15
    ),
    '8' => array(
        'nama' => 'Jenis Izin',
        'lebar' => 15
    ),
    '9' => array(
        'nama' => 'Waktu Keluar',
        'lebar' => 10
    ),
    '10' => array(
        'nama' => 'Atasan',
        'lebar' => 30
    ),
    '11' => array(
        'nama' => 'Keterangan',
        'lebar' => 30
    ),
    '12' => array(
        'nama' => 'Status',
        'lebar' => 30
    ),
    '13' => array(
        'nama' => 'Poin',
        'lebar' => 15
    ),
);
$bariske = '4';
$nom = 0;
if ($perseksi == 'Ya') {
    unset($array_judul[1]);
    unset($array_judul[2]);
}
if ($jenis == '1') {
    unset($array_judul[12]);
}

$array_judul = array_values($array_judul);

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
            'color' => array('rgb' => $warna)
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

foreach ($dataReal as $key) {
    $nama = '';
    $kodesie = '';
    $poin = '';
    $lokasi = '';
    foreach (explode(',', $key['nama_pkj']) as $a) {
        $nama .= "$a\n";
    }
    if ($jenis == '2') {
        $kodesie = $key['seksi'];
        $lokasi = $key['lokasi_kerja'];

        if ($key['jumlah'] > 1 && $key['point'] > 0) {
            if ($key['jenis_ijin'] == 'IZIN KELUAR PRIBADI') {
                if (date("Y-m-d", strtotime($key['created_date'])) == date("Y-m-d") && empty($key['point'])) {
                    $poin =  '-';
                } elseif (date("Y-m-d", strtotime($key['created_date'])) <= date("Y-m-d") && empty($key['point'])) {
                    $poin = '0';
                } else {
                    $poin = $key['point'];
                }
            } else {
                $poin = '0';
            }
        } else {
            if (date("Y-m-d", strtotime($key['created_date'])) == date("Y-m-d") && empty($key['point'])) {
                $poin = '-';
            } elseif (date("Y-m-d", strtotime($key['created_date'])) <= date("Y-m-d") && empty($key['point'])) {
                $poin = '0';
            } else {
                $poin = $key['point'];
            };
        }
    } else {
        foreach (explode(',', $key['kodesie']) as $b) {
            foreach ($seksi as $value) {
                if ($b == $value['kodesie']) {
                    $kodesie .= $value['seksi'] . "\n";
                }
            }
        }
        foreach (explode(',', $key['lokasi_kerja']) as $t) {
            $lokasi .= $t . "\n";
        }
    }



    $array_value = array(
        $no,
        ($key['manual'] == null) ? '' : ($key['manual'] == 't' ? 'Ya' : 'Tidak'),
        ($key['manual'] == null ? '' : 'Ya'),
        $key['id'],
        date('d M Y', strtotime($key['created_date'])),
        $nama,
        $kodesie,
        $lokasi,
        $key['jenis_ijin'],
        $key['keluar'],
        $key['atasan'],
        $key['keperluan'],
        $key['status'],
        $poin
    );

    if ($perseksi == 'Ya') {
        unset($array_value[1]);
        unset($array_value[2]);
    }

    if ($jenis == '1') {
        unset($array_value[12]);
    }

    $array_value = array_values($array_value);
    $nam = 0;
    $objWriter->setActiveSheetIndex(0)
        ->setCellValue('A2', 'DATA REKAP PERIZINAN PRIBADI');
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
header('Content-Disposition: attachment; filename="' . $judul . '.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objWriter, 'Excel5');
$objWriter->save('php://output');
exit;
