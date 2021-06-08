<?php
defined('BASEPATH') or exit('No direct script access allowed');
class C_laporanPenjualanTraktor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        $this->load->library('Pdf');
        $this->load->model('M_Index');
        $this->load->model('LaporanPenjualanTraktor/M_laporanpenjualantraktor');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }

    // function index atau utama (yang dipanggil)
    public function index()
    {
        // mengambil data penjualan
        $data['header'] = $this->M_laporanpenjualantraktor->getHeader();
        $data['daily'] = $this->M_laporanpenjualantraktor->getDaily();
        $data['sumDate'] = $this->M_laporanpenjualantraktor->getCalcDate();
        $data['sumDayMonth'] = $this->M_laporanpenjualantraktor->getCountDayWorkMonth();
        $data['typeSingle'] = $this->M_laporanpenjualantraktor->getType('SINGLE');
        $data['typeTotal'] = $this->M_laporanpenjualantraktor->getType('TOTAL');


        // pendeklarasian varaibel untuk mencari nilai total
        $subdata['SATU'] =
            $subdata['DUA'] =
            $subdata['TIGA'] =
            $subdata['EMPAT'] =
            $subdata['LIMA'] =
            $subdata['ENAM'] =
            $subdata['TUJUH'] =
            $subdata['DELAPAN'] =
            $subdata['SEMBILAN'] =
            $subdata['SEPULUH'] =
            $subdata['TOTAL'] =
            $subdata1['AAH0'] =
            $subdata1['AAB0'] =
            $subdata1['AAG0'] =
            $subdata1['AAE0'] =
            $subdata1['AAC0'] =
            $subdata1['ACA0'] =
            $subdata1['ACC0'] =
            $subdata1['AAK0'] =
            $subdata1['AAL0'] =
            $subdata1['AAN0'] =
            $subdata1['ADA0'] =
            $subdata1['ADB0'] =
            $subdata1['ADC0'] =
            $subdata1['ADD0'] =
            $subdata1['TOTAL'] =
            $subdata2['AAH0'] =
            $subdata2['AAB0'] =
            $subdata2['AAG0'] =
            $subdata2['AAE0'] =
            $subdata2['AAC0'] =
            $subdata2['ACA0'] =
            $subdata2['ACC0'] =
            $subdata2['AAK0'] =
            $subdata2['AAL0'] =
            $subdata2['AAN0'] =
            $subdata2['ADA0'] =
            $subdata2['ADB0'] =
            $subdata2['ADC0'] =
            $subdata2['ADD0'] =
            $subdata2['TOTAL'] = 0;

        // mencari nilai total dari Laporan Penjualan Harian
        for ($i = 0; $i < count($data['daily']); $i++) {
            $subdata['TOTAL'] = $subdata['TOTAL'] + $data['daily'][$i]['TOTAL'];
            $subdata['SEPULUH'] = $subdata['SEPULUH'] + $data['daily'][$i]['SEPULUH'];
            $subdata['SEMBILAN'] = $subdata['SEMBILAN'] + $data['daily'][$i]['SEMBILAN'];
            $subdata['DELAPAN'] = $subdata['DELAPAN'] + $data['daily'][$i]['DELAPAN'];
            $subdata['TUJUH'] = $subdata['TUJUH'] + $data['daily'][$i]['TUJUH'];
            $subdata['ENAM'] = $subdata['ENAM'] + $data['daily'][$i]['ENAM'];
            $subdata['LIMA'] = $subdata['LIMA'] + $data['daily'][$i]['LIMA'];
            $subdata['EMPAT'] = $subdata['EMPAT'] + $data['daily'][$i]['EMPAT'];
            $subdata['TIGA'] = $subdata['TIGA'] + $data['daily'][$i]['TIGA'];
            $subdata['DUA'] = $subdata['DUA'] + $data['daily'][$i]['DUA'];
            $subdata['SATU'] = $subdata['SATU'] + $data['daily'][$i]['SATU'];
            $totalDaily = $subdata;
        }

        $data['totalDaily'] = $totalDaily;

        // mencari nilai total dari Laporan Penjualan Per Tipe Harian
        for ($i = 0; $i < count($data['typeSingle']); $i++) {
            $subdata1['AAH0'] = $subdata1['AAH0'] + $data['typeSingle'][$i]['AAH0'];
            $subdata1['AAB0'] = $subdata1['AAB0'] + $data['typeSingle'][$i]['AAB0'];
            $subdata1['AAG0'] = $subdata1['AAG0'] + $data['typeSingle'][$i]['AAG0'];
            $subdata1['AAE0'] = $subdata1['AAE0'] + $data['typeSingle'][$i]['AAE0'];
            $subdata1['AAC0'] = $subdata1['AAC0'] + $data['typeSingle'][$i]['AAC0'];
            $subdata1['ACA0'] = $subdata1['ACA0'] + $data['typeSingle'][$i]['ACA0'];
            $subdata1['ACC0'] = $subdata1['ACC0'] + $data['typeSingle'][$i]['ACC0'];
            $subdata1['AAK0'] = $subdata1['AAK0'] + $data['typeSingle'][$i]['AAK0'];
            $subdata1['AAL0'] = $subdata1['AAL0'] + $data['typeSingle'][$i]['AAL0'];
            $subdata1['AAN0'] = $subdata1['AAN0'] + $data['typeSingle'][$i]['AAN0'];
            $subdata1['ADA0'] = $subdata1['ADA0'] + $data['typeSingle'][$i]['ADA0'];
            $subdata1['ADB0'] = $subdata1['ADB0'] + $data['typeSingle'][$i]['ADB0'];
            $subdata1['ADC0'] = $subdata1['ADC0'] + $data['typeSingle'][$i]['ADC0'];
            $subdata1['ADD0'] = $subdata1['ADD0'] + $data['typeSingle'][$i]['ADD0'];
            $subdata1['TOTAL'] = $subdata1['TOTAL'] + $data['typeSingle'][$i]['TOTAL'];
            $totalTypeSingle = $subdata1;
        }

        $data['totalTypeSingle'] = $totalTypeSingle;

        // mencari nilai total dari Laporan Penjualan Per Tipe Total
        for ($i = 0; $i < count($data['typeTotal']); $i++) {
            $subdata2['AAH0'] = $subdata2['AAH0'] + $data['typeTotal'][$i]['AAH0'];
            $subdata2['AAB0'] = $subdata2['AAB0'] + $data['typeTotal'][$i]['AAB0'];
            $subdata2['AAG0'] = $subdata2['AAG0'] + $data['typeTotal'][$i]['AAG0'];
            $subdata2['AAE0'] = $subdata2['AAE0'] + $data['typeTotal'][$i]['AAE0'];
            $subdata2['AAC0'] = $subdata2['AAC0'] + $data['typeTotal'][$i]['AAC0'];
            $subdata2['ACA0'] = $subdata2['ACA0'] + $data['typeTotal'][$i]['ACA0'];
            $subdata2['ACC0'] = $subdata2['ACC0'] + $data['typeTotal'][$i]['ACC0'];
            $subdata2['AAK0'] = $subdata2['AAK0'] + $data['typeTotal'][$i]['AAK0'];
            $subdata2['AAL0'] = $subdata2['AAL0'] + $data['typeTotal'][$i]['AAL0'];
            $subdata2['AAN0'] = $subdata2['AAN0'] + $data['typeTotal'][$i]['AAN0'];
            $subdata2['ADA0'] = $subdata2['ADA0'] + $data['typeTotal'][$i]['ADA0'];
            $subdata2['ADB0'] = $subdata2['ADB0'] + $data['typeTotal'][$i]['ADB0'];
            $subdata2['ADC0'] = $subdata2['ADC0'] + $data['typeTotal'][$i]['ADC0'];
            $subdata2['ADD0'] = $subdata2['ADD0'] + $data['typeTotal'][$i]['ADD0'];
            $subdata2['TOTAL'] = $subdata2['TOTAL'] + $data['typeTotal'][$i]['TOTAL'];
            $totalTypeTotal = $subdata2;
        }

        $data['totalTypeTotal'] = $totalTypeTotal;

        // mengambil tanggal sekarang dikurangi 1 hari (etc: if today = 15 January => 14 January)
        $data['dateToday'] = $this->dateHmin();

        // memanggil view
        $this->load->view('V_Header', $data);
        $this->load->view('LaporanPenjualanTraktor/V_laporanPenjualanTraktor', $data);
        $this->load->view('V_Footer', $data);
    }

    // function export file excel Laporan Penjualan 
    public function exportExcel()
    {
        $objPHPExcel = new PHPExcel();

        $style_col = array(
            'font' => array('bold' => true),
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Penjualan Harian");
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:M2');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A3:A4');
        $objPHPExcel->getActiveSheet(0)->mergeCells('L3:L4');
        $objPHPExcel->getActiveSheet(0)->mergeCells('M3:M4');
        $objPHPExcel->getActiveSheet(0)->mergeCells('B17:K17');
        $objPHPExcel->getActiveSheet(0)->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet(0)->getStyle('A1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet(0)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet(0)->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet(0)->getStyle('A3:M4')->applyFromArray(array('font' => array(
            'color' => array('rgb' => 'FFFFFF')
        )));
        $objPHPExcel->getActiveSheet(0)->getStyle('A3:M4')->getFill()->applyFromArray(
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '337AB7'),
            )
        );
        $objPHPExcel->getActiveSheet(0)->getStyle('A16:M16')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet(0)->getStyle('A16:M16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet(0)->getStyle('B17:K17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet(0)->getStyle('B17:K17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet(0)->getStyle('B17')->getAlignment()->setIndent(2);


        $header = $this->M_laporanpenjualantraktor->getHeader();

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Penjualan Cabang");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', $header[0]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', $header[1]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', $header[2]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', $header[3]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', $header[4]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', $header[5]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', $header[6]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', $header[7]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', $header[8]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', $header[9]['TANGGAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', rtrim($header[0]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', rtrim($header[1]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', rtrim($header[2]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', rtrim($header[3]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', rtrim($header[4]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', rtrim($header[5]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', rtrim($header[6]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', rtrim($header[7]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', rtrim($header[8]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', rtrim($header[9]['BULAN']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "Rata2");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "AK");

        foreach (range('A', 'M') as $columnID) {
            $objPHPExcel->getActiveSheet(0)->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet(0)->getStyle($columnID . '3')->applyFromArray($style_col);
        }
        foreach (range('A', 'M') as $columnID) {
            $objPHPExcel->getActiveSheet(0)->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        foreach (range('A', 'M') as $columnID) {
            $objPHPExcel->getActiveSheet(0)->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet(0)->getStyle($columnID . '4')->applyFromArray($style_col);
        }
        foreach (range('A4', 'M4') as $columnID) {
            $objPHPExcel->getActiveSheet(0)->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $daily = $this->M_laporanpenjualantraktor->getDaily();
        $sumDate = $this->M_laporanpenjualantraktor->getCalcDate();
        $sumDayMonth = $this->M_laporanpenjualantraktor->getCountDayWorkMonth();

        $numrow = 5;
        foreach ($daily as $data) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['CABANG']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['SATU']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['DUA']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['TIGA']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['EMPAT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['LIMA']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['ENAM']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['TUJUH']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['DELAPAN']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['SEMBILAN']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['SEPULUH']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, "=ROUND((M" . $numrow . "/B17),0)");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['TOTAL']);

            $objPHPExcel->getActiveSheet(0)->getStyle('A' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('B' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('C' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('D' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('E' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('F' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('G' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('H' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('I' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('J' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('K' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('L' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(0)->getStyle('M' . $numrow)->applyFromArray($style_row);

            $numrow++;
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A16', "TOTAL KOMERSIAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B16', "=SUM(B5:B15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C16', "=SUM(C5:C15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D16', "=SUM(D5:D15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E16', "=SUM(E5:E15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F16', "=SUM(F5:F15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G16', "=SUM(G5:G15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H16', "=SUM(H5:H15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I16', "=SUM(I5:I15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J16', "=SUM(J5:J15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K16', "=SUM(K5:K15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L16', "=ROUND((M16/B17),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M16', "=SUM(M5:M15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M17', $sumDate['JUMLAH_HARI'] . " / " . $sumDayMonth['JUMLAH_HARI']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A17', "Jumlah Hari Penjualan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B17', $sumDate['JUMLAH_HARI']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L17', "Laju Hari");

        $objPHPExcel->getActiveSheet(0)->getStyle('A16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('B16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('C16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('D16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('E16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('F16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('G16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('H16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('I16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('J16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('K16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('L16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('M16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('A17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('B17:K17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(0)->getStyle('L17:M17')->applyFromArray($style_row);

        $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('L')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('M')->setAutoSize(false);

        $objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(24);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('M')->setWidth(10);
        $today = $this->dateInd(date('Y-m-d'));
        $objPHPExcel->getActiveSheet(0)->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet(0)->setTitle('PER HARI');

        $objPHPExcel->createSheet(1);

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', "Laporan Omset Penjualan Harian Pertipe Perproduk");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A2',  $this->dateInd(date('Y-m-d')));
        $objPHPExcel->getActiveSheet(1)->mergeCells('A1:P1');
        $objPHPExcel->getActiveSheet(1)->mergeCells('A2:P2');
        $objPHPExcel->getActiveSheet(1)->mergeCells('B3:B4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('C3:C4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('D3:D4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('E3:E4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('F3:F4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('G3:G4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('H3:H4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('I3:I4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('J3:J4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('K3:K4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('L3:L4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('M3:M4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('N3:N4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('O3:O4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('P3:P4');
        $objPHPExcel->getActiveSheet(1)->mergeCells('P16:P17');
        $objPHPExcel->getActiveSheet(1)->mergeCells('A17:C17');
        $objPHPExcel->getActiveSheet(1)->mergeCells('D17:G17');
        $objPHPExcel->getActiveSheet(1)->mergeCells('H17:O17');
        $objPHPExcel->getActiveSheet(1)->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet(1)->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet(1)->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet(1)->getStyle('A3:P4')->applyFromArray(array('font' => array(
            'color' => array('rgb' => 'FFFFFF')
        )));
        $objPHPExcel->getActiveSheet(1)->getStyle('A3:P4')->getFill()->applyFromArray(
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '337AB7')
            )
        );
        $objPHPExcel->getActiveSheet(1)->getStyle('A17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet(1)->getStyle('H17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet(1)->getStyle('A16:P16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet(1)->getStyle('A16:P16')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet(1)->getStyle('B3:P3')->getAlignment()->setTextRotation(90);
        $objPHPExcel->getActiveSheet(1)->getRowDimension('3')->setRowHeight(100);
        $objPHPExcel->getActiveSheet(1)->getRowDimension('4')->setRowHeight(20);

        $date = $this->dateHmin();

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A3', "Penjualan Cabang");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A4', $date);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B3', "ZEVA");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C3', "G1000");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D3', "BOXER");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E3', "M1000");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F3', "G600");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G3', "ZENA Rotary");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H3', "ZENA Super Power");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I3', "IMPALA");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J3', "CAPUNG METAL");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K3', "CAPUNG RAWA");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L3', "CAKAR BAJA");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M3', "CAKAR BAJA MINI");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N3', "CACAH BUMI");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O3', "KASUARI");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P3', "Total");

        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet(1)->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet(1)->getStyle($columnID . '3')->applyFromArray($style_col);
        }
        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet(1)->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet(1)->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet(1)->getStyle($columnID . '4')->applyFromArray($style_col);
        }
        foreach (range('A4', 'P4') as $columnID) {
            $objPHPExcel->getActiveSheet(1)->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $typeSingle = $this->M_laporanpenjualantraktor->getType('SINGLE');

        $numrow = 5;
        foreach ($typeSingle as $data) {
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A' . $numrow, $data['CABANG']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B' . $numrow, $data['AAH0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C' . $numrow, $data['AAB0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $numrow, $data['AAG0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $numrow, $data['AAE0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $numrow, $data['AAC0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $numrow, $data['ACA0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H' . $numrow, $data['ACC0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I' . $numrow, $data['AAK0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J' . $numrow, $data['AAL0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K' . $numrow, $data['AAN0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L' . $numrow, $data['ADA0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M' . $numrow, $data['ADB0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N' . $numrow, $data['ADC0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O' . $numrow, $data['ADD0']);
            $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P' . $numrow, "=SUM(B" . $numrow . ":O" . $numrow . ")");

            $objPHPExcel->getActiveSheet(1)->getStyle('A' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('B' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('C' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('D' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('E' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('F' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('G' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('H' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('I' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('J' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('K' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('L' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('M' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('N' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('O' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(1)->getStyle('P' . $numrow)->applyFromArray($style_row);

            $numrow++;
        }

        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A16', "TOTAL KOMERSIAL");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A17', "Laju Penjualan Hari");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B16', "=SUM(B5:B15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C16', "=SUM(C5:C15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D16', "=SUM(D5:D15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D17', "( " . $sumDate['JUMLAH_HARI'] . " / " . $sumDayMonth['JUMLAH_HARI'] . " )");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E16', "=SUM(E5:E15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F16', "=SUM(F5:F15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G16', "=SUM(G5:G15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H16', "=SUM(H5:H15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H17', "Total Penjualan =");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I16', "=SUM(I5:I15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J16', "=SUM(J5:J15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K16', "=SUM(K5:K15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('L16', "=SUM(L5:L15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('M16', "=SUM(M5:M15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('N16', "=SUM(N5:N15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('O16', "=SUM(O5:O15)");
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('P16', "=SUM(P5:P15)");

        $objPHPExcel->getActiveSheet(1)->getStyle('A16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('B16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('C16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('D16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('E16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('F16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('G16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('H16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('I16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('J16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('K16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('L16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('M16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('N16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('O16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('P16:P17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('A17:G17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(1)->getStyle('H17:O17')->applyFromArray($style_row);

        $objPHPExcel->getActiveSheet(1)->getColumnDimension('B')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('C')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('D')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('E')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('F')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('G')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('H')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('I')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('J')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('K')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('L')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('M')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('N')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('O')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('P')->setAutoSize(false);

        $objPHPExcel->getActiveSheet(1)->getColumnDimension('B')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('C')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('D')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('E')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('F')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('G')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('I')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('J')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('K')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('L')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('M')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('N')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('O')->setWidth(6);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('P')->setWidth(8);
        $today = $this->dateInd(date('Y-m-d'));
        $objPHPExcel->getActiveSheet(1)->setTitle('PER TIPE 1 HARI');

        $objPHPExcel->createSheet(2);

        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', "Total Laporan Omset Penjualan Pertipe Perproduk s/d hari ini");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A2', $this->dateInd(date('Y-m-d')));
        $objPHPExcel->getActiveSheet(2)->mergeCells('A1:P1');
        $objPHPExcel->getActiveSheet(2)->mergeCells('A2:P2');
        $objPHPExcel->getActiveSheet(2)->mergeCells('B3:B4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('C3:C4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('D3:D4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('E3:E4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('F3:F4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('G3:G4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('H3:H4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('I3:I4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('J3:J4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('K3:K4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('L3:L4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('M3:M4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('N3:N4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('O3:O4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('P3:P4');
        $objPHPExcel->getActiveSheet(2)->mergeCells('A18:B18');
        $objPHPExcel->getActiveSheet(2)->mergeCells('D18:E18');
        $objPHPExcel->getActiveSheet(2)->mergeCells('F18:K18');
        $objPHPExcel->getActiveSheet(2)->mergeCells('N18:P18');
        $objPHPExcel->getActiveSheet(2)->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet(2)->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet(2)->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet(2)->getStyle('A3:P4')->applyFromArray(array('font' => array(
            'color' => array('rgb' => 'FFFFFF')
        )));
        $objPHPExcel->getActiveSheet(2)->getStyle('A3:P4')->getFill()->applyFromArray(
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '337AB7')
            )
        );
        $objPHPExcel->getActiveSheet(2)->getStyle('F18:K18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet(2)->getStyle('D18:E18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet(2)->getStyle('C18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet(2)->getStyle('A16:P16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet(2)->getStyle('A16:P16')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet(2)->getStyle('B3:P3')->getAlignment()->setTextRotation(90);
        $objPHPExcel->getActiveSheet(2)->getRowDimension('3')->setRowHeight(100);
        $objPHPExcel->getActiveSheet(2)->getRowDimension('4')->setRowHeight(20);

        $date = $this->dateHmin();

        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A3', "Penjualan Cabang");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A4', $date);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B3', "ZEVA");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C3', "G1000");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D3', "BOXER");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E3', "M1000");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F3', "G600");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G3', "ZENA Rotary");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('H3', "ZENA Super Power");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('I3', "IMPALA");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('J3', "CAPUNG METAL");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('K3', "CAPUNG RAWA");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('L3', "CAKAR BAJA");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M3', "CAKAR BAJA MINI");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('N3', "CACAH BUMI");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('O3', "KASUARI");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('P3', "Total");

        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet(2)->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet(2)->getStyle($columnID . '3')->applyFromArray($style_col);
        }
        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet(2)->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet(2)->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet(2)->getStyle($columnID . '4')->applyFromArray($style_col);
        }
        foreach (range('A4', 'P4') as $columnID) {
            $objPHPExcel->getActiveSheet(2)->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $typeTotal = $this->M_laporanpenjualantraktor->getType('TOTAL');

        $numrow = 5;
        foreach ($typeTotal as $data) {
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A' . $numrow, $data['CABANG']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B' . $numrow, $data['AAH0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C' . $numrow, $data['AAB0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D' . $numrow, $data['AAG0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E' . $numrow, $data['AAE0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F' . $numrow, $data['AAC0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G' . $numrow, $data['ACA0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('H' . $numrow, $data['ACC0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('I' . $numrow, $data['AAK0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('J' . $numrow, $data['AAL0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('K' . $numrow, $data['AAN0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('L' . $numrow, $data['ADA0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M' . $numrow, $data['ADB0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('N' . $numrow, $data['ADC0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('O' . $numrow, $data['ADD0']);
            $objPHPExcel->setActiveSheetIndex(2)->setCellValue('P' . $numrow, "=SUM(B" . $numrow . ":O" . $numrow . ")");

            $objPHPExcel->getActiveSheet(2)->getStyle('A' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('B' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('C' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('D' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('E' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('F' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('G' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('H' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('I' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('J' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('K' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('L' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('M' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('N' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('O' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet(2)->getStyle('P' . $numrow)->applyFromArray($style_row);

            $numrow++;
        }

        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A16', "TOTAL KOMERSIAL");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B16', "=SUM(B5:B15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C16', "=SUM(C5:C15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D16', "=SUM(D5:D15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E16', "=SUM(E5:E15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F16', "=SUM(F5:F15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G16', "=SUM(G5:G15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('H16', "=SUM(H5:H15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('I16', "=SUM(I5:I15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('J16', "=SUM(J5:J15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('K16', "=SUM(K5:K15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('L16', "=SUM(L5:L15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M16', "=SUM(M5:M15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('N16', "=SUM(N5:N15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('O16', "=SUM(O5:O15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('P16', "=SUM(P5:P15)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A17', "Rata2 Penjualan");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B17', "=ROUND((B16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C17', "=ROUND((C16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D17', "=ROUND((D16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E17', "=ROUND((E16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F17', "=ROUND((F16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G17', "=ROUND((G16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('H17', "=ROUND((H16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('I17', "=ROUND((I16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('J17', "=ROUND((J16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('K17', "=ROUND((K16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('L17', "=ROUND((L16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M17', "=ROUND((M16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('N17', "=ROUND((N16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('O17', "=ROUND((O16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('P17', "=ROUND((P16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A18', "Jumlah hari penjualan");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C18', "=");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D18', $sumDate['JUMLAH_HARI']);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F18', "Laju Hari");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('L18', ":");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('M18', "=D18");
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('N18', "/ " . $sumDayMonth['JUMLAH_HARI']);

        $objPHPExcel->getActiveSheet(2)->getStyle('A16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('B16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('C16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('D16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('E16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('F16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('G16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('H16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('I16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('J16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('K16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('L16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('M16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('N16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('O16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('P16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('A17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('B17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('C17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('D17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('E17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('F17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('G17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('H17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('I17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('J17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('K17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('L17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('M17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('N17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('O17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('P17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('A18:E18')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet(2)->getStyle('F18:P18')->applyFromArray($style_row);

        $objPHPExcel->getActiveSheet(2)->getColumnDimension('B')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('C')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('D')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('E')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('F')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('G')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('H')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('I')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('J')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('K')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('L')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('M')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('N')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('O')->setAutoSize(false);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('P')->setAutoSize(false);

        $objPHPExcel->getActiveSheet(2)->getColumnDimension('B')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('C')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('D')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('E')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('F')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('G')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('I')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('J')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('K')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('L')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('M')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('N')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('O')->setWidth(6);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('P')->setWidth(8);
        $today = $this->dateInd(date('Y-m-d'));
        $objPHPExcel->getActiveSheet(2)->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet(2)->setTitle('PER TIPE TOTAL');

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Traktor ' . $today . '.xlsx"');
        $objWriter->save("php://output");
    }

    // function export file PDF Laporan Penjualan
    public function exportPdf()
    {
        // mengambil data penjualan
        $data['header'] = $this->M_laporanpenjualantraktor->getHeader();
        $data['daily'] = $this->M_laporanpenjualantraktor->getDaily();
        $data['sumDate'] = $this->M_laporanpenjualantraktor->getCalcDate();
        $data['sumDayMonth'] = $this->M_laporanpenjualantraktor->getCountDayWorkMonth();
        $data['typeSingle'] = $this->M_laporanpenjualantraktor->getType('SINGLE');
        $data['typeTotal'] = $this->M_laporanpenjualantraktor->getType('TOTAL');


        // pendeklarasian varaibel untuk mencari nilai total
        $subdata['SATU'] =
            $subdata['DUA'] =
            $subdata['TIGA'] =
            $subdata['EMPAT'] =
            $subdata['LIMA'] =
            $subdata['ENAM'] =
            $subdata['TUJUH'] =
            $subdata['DELAPAN'] =
            $subdata['SEMBILAN'] =
            $subdata['SEPULUH'] =
            $subdata['TOTAL'] =
            $subdata1['AAH0'] =
            $subdata1['AAB0'] =
            $subdata1['AAG0'] =
            $subdata1['AAE0'] =
            $subdata1['AAC0'] =
            $subdata1['ACA0'] =
            $subdata1['ACC0'] =
            $subdata1['AAK0'] =
            $subdata1['AAL0'] =
            $subdata1['AAN0'] =
            $subdata1['ADA0'] =
            $subdata1['ADB0'] =
            $subdata1['ADC0'] =
            $subdata1['ADD0'] =
            $subdata1['TOTAL'] =
            $subdata2['AAH0'] =
            $subdata2['AAB0'] =
            $subdata2['AAG0'] =
            $subdata2['AAE0'] =
            $subdata2['AAC0'] =
            $subdata2['ACA0'] =
            $subdata2['ACC0'] =
            $subdata2['AAK0'] =
            $subdata2['AAL0'] =
            $subdata2['AAN0'] =
            $subdata2['ADA0'] =
            $subdata2['ADB0'] =
            $subdata2['ADC0'] =
            $subdata2['ADD0'] =
            $subdata2['TOTAL'] = 0;

        // mencari nilai total dari Laporan Penjualan Harian
        for ($i = 0; $i < count($data['daily']); $i++) {
            $subdata['TOTAL'] = $subdata['TOTAL'] + $data['daily'][$i]['TOTAL'];
            $subdata['SEPULUH'] = $subdata['SEPULUH'] + $data['daily'][$i]['SEPULUH'];
            $subdata['SEMBILAN'] = $subdata['SEMBILAN'] + $data['daily'][$i]['SEMBILAN'];
            $subdata['DELAPAN'] = $subdata['DELAPAN'] + $data['daily'][$i]['DELAPAN'];
            $subdata['TUJUH'] = $subdata['TUJUH'] + $data['daily'][$i]['TUJUH'];
            $subdata['ENAM'] = $subdata['ENAM'] + $data['daily'][$i]['ENAM'];
            $subdata['LIMA'] = $subdata['LIMA'] + $data['daily'][$i]['LIMA'];
            $subdata['EMPAT'] = $subdata['EMPAT'] + $data['daily'][$i]['EMPAT'];
            $subdata['TIGA'] = $subdata['TIGA'] + $data['daily'][$i]['TIGA'];
            $subdata['DUA'] = $subdata['DUA'] + $data['daily'][$i]['DUA'];
            $subdata['SATU'] = $subdata['SATU'] + $data['daily'][$i]['SATU'];
            $totalDaily = $subdata;
        }

        $data['totalDaily'] = $totalDaily;

        // mencari nilai total dari Laporan Penjualan Per Tipe Harian
        for ($i = 0; $i < count($data['typeSingle']); $i++) {
            $subdata1['AAH0'] = $subdata1['AAH0'] + $data['typeSingle'][$i]['AAH0'];
            $subdata1['AAB0'] = $subdata1['AAB0'] + $data['typeSingle'][$i]['AAB0'];
            $subdata1['AAG0'] = $subdata1['AAG0'] + $data['typeSingle'][$i]['AAG0'];
            $subdata1['AAE0'] = $subdata1['AAE0'] + $data['typeSingle'][$i]['AAE0'];
            $subdata1['AAC0'] = $subdata1['AAC0'] + $data['typeSingle'][$i]['AAC0'];
            $subdata1['ACA0'] = $subdata1['ACA0'] + $data['typeSingle'][$i]['ACA0'];
            $subdata1['ACC0'] = $subdata1['ACC0'] + $data['typeSingle'][$i]['ACC0'];
            $subdata1['AAK0'] = $subdata1['AAK0'] + $data['typeSingle'][$i]['AAK0'];
            $subdata1['AAL0'] = $subdata1['AAL0'] + $data['typeSingle'][$i]['AAL0'];
            $subdata1['AAN0'] = $subdata1['AAN0'] + $data['typeSingle'][$i]['AAN0'];
            $subdata1['ADA0'] = $subdata1['ADA0'] + $data['typeSingle'][$i]['ADA0'];
            $subdata1['ADB0'] = $subdata1['ADB0'] + $data['typeSingle'][$i]['ADB0'];
            $subdata1['ADC0'] = $subdata1['ADC0'] + $data['typeSingle'][$i]['ADC0'];
            $subdata1['ADD0'] = $subdata1['ADD0'] + $data['typeSingle'][$i]['ADD0'];
            $subdata1['TOTAL'] = $subdata1['TOTAL'] + $data['typeSingle'][$i]['TOTAL'];
            $totalTypeSingle = $subdata1;
        }

        $data['totalTypeSingle'] = $totalTypeSingle;

        // mencari nilai total dari Laporan Penjualan Per Tipe Total
        for ($i = 0; $i < count($data['typeTotal']); $i++) {
            $subdata2['AAH0'] = $subdata2['AAH0'] + $data['typeTotal'][$i]['AAH0'];
            $subdata2['AAB0'] = $subdata2['AAB0'] + $data['typeTotal'][$i]['AAB0'];
            $subdata2['AAG0'] = $subdata2['AAG0'] + $data['typeTotal'][$i]['AAG0'];
            $subdata2['AAE0'] = $subdata2['AAE0'] + $data['typeTotal'][$i]['AAE0'];
            $subdata2['AAC0'] = $subdata2['AAC0'] + $data['typeTotal'][$i]['AAC0'];
            $subdata2['ACA0'] = $subdata2['ACA0'] + $data['typeTotal'][$i]['ACA0'];
            $subdata2['ACC0'] = $subdata2['ACC0'] + $data['typeTotal'][$i]['ACC0'];
            $subdata2['AAK0'] = $subdata2['AAK0'] + $data['typeTotal'][$i]['AAK0'];
            $subdata2['AAL0'] = $subdata2['AAL0'] + $data['typeTotal'][$i]['AAL0'];
            $subdata2['AAN0'] = $subdata2['AAN0'] + $data['typeTotal'][$i]['AAN0'];
            $subdata2['ADA0'] = $subdata2['ADA0'] + $data['typeTotal'][$i]['ADA0'];
            $subdata2['ADB0'] = $subdata2['ADB0'] + $data['typeTotal'][$i]['ADB0'];
            $subdata2['ADC0'] = $subdata2['ADC0'] + $data['typeTotal'][$i]['ADC0'];
            $subdata2['ADD0'] = $subdata2['ADD0'] + $data['typeTotal'][$i]['ADD0'];
            $subdata2['TOTAL'] = $subdata2['TOTAL'] + $data['typeTotal'][$i]['TOTAL'];
            $totalTypeTotal = $subdata2;
        }

        $data['totalTypeTotal'] = $totalTypeTotal;

        // mengambil tanggal sekarang dikurangi 1 hari (etc: if today = 15 January => 14 January)
        $data['dateToday'] = $this->dateHmin();
        $data['date'] = $this->dateInd(date('Y-m-d'));

        $fill = $this->load->view('LaporanPenjualanTraktor/V_pdf', $data, true);

        $pdf = $this->pdf->load();

        $pdf = new mPDF('utf-8', 'Legal', '', 'Calibri', 10, 10, 10, 10, 6, 3);
        $pdf->WriteHTML($fill);

        $pdf->Output('Laporan Penjualan Traktor ' . $data['date'] . '.pdf', 'D');
    }

    // function tanggal = tanggal sekarang dikurangi 1 hari
    function dateHmin()
    {
        $header = $this->M_laporanpenjualantraktor->getHeader();

        $date = $header[9];
        $date = $date['TAHUN'] . '-' . date('m', strtotime(rtrim($date['BULAN']))) . '-' . $date['TANGGAL'];

        return $this->dateInd($date);
    }

    // function mengubah nama bulan
    function dateInd($date)
    {
        $month = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $explode = explode('-', $date);

        return $explode[2] . ' ' . $month[(int)$explode[1]] . ' ' . $explode[0];
    }
}