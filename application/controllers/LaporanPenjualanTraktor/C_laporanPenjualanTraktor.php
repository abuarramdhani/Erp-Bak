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
        $this->load->model('M_Index');
        $this->load->model('LaporanPenjualanTraktor/M_laporanPenjualanTraktor');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }

    // function index atau utama (yang dipanggil)
    public function index()
    {
        // mengambil data penjualan
        $data['header'] = $this->M_laporanPenjualanTraktor->getHeader();
        $data['daily'] = $this->M_laporanPenjualanTraktor->getDaily();
        $data['sumDate'] = $this->M_laporanPenjualanTraktor->getCalcDate();
        $data['typeSingle'] = $this->M_laporanPenjualanTraktor->getType('SINGLE');
        $data['typeTotal'] = $this->M_laporanPenjualanTraktor->getType('TOTAL');


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

    // function export file excel Laporan Penjualan Harian
    public function exportDaily()
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
        $objPHPExcel->getActiveSheet()->mergeCells('A1:M2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
        $objPHPExcel->getActiveSheet()->mergeCells('L3:L4');
        $objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
        $objPHPExcel->getActiveSheet()->mergeCells('B17:K17');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:M4')->applyFromArray(array('font' => array(
            'color' => array('rgb' => 'FFFFFF')
        )));
        $objPHPExcel->getActiveSheet()->getStyle('A3:M4')->getFill()->applyFromArray(
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '337AB7'),
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A16:M16')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A16:M16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B17:K17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('B17:K17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B17')->getAlignment()->setIndent(2);


        $header = $this->M_laporanPenjualanTraktor->getHeader();
        
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
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID . '3')->applyFromArray($style_col);
        }
        foreach (range('A', 'M') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        foreach (range('A', 'M') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID . '4')->applyFromArray($style_col);
        }
        foreach (range('A4', 'M4') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $daily = $this->M_laporanPenjualanTraktor->getDaily();
        $sumDate = $this->M_laporanPenjualanTraktor->getCalcDate();

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
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, "=ROUND((M".$numrow."/B17),0)");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['TOTAL']);

            $objPHPExcel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);

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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M17', $sumDate['JUMLAH_HARI'] . " / 25");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A17', "Jumlah Hari Penjualan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B17', $sumDate['JUMLAH_HARI']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L17', "Laju Hari");

        $objPHPExcel->getActiveSheet()->getStyle('A16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('C16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('D16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('F16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('G16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('I16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('J16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('L16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('M16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('A17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B17:K17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('L17:M17')->applyFromArray($style_row);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $today = $this->dateInd(date('Y-m-d'));
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Laporan Penjualan Harian');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Harian ' . $today . '.xlsx"');
        $objWriter->save("php://output");
    }

    // function export file excel Laporan Omset Penjualan Harian Pertipe Perproduk
    public function exportTypeDaily()
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Omset Penjualan Harian Pertipe Perproduk");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2',  $this->dateInd(date('Y-m-d')));
        $objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:P2');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
        $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
        $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
        $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:F4');
        $objPHPExcel->getActiveSheet()->mergeCells('G3:G4');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:H4');
        $objPHPExcel->getActiveSheet()->mergeCells('I3:I4');
        $objPHPExcel->getActiveSheet()->mergeCells('J3:J4');
        $objPHPExcel->getActiveSheet()->mergeCells('K3:K4');
        $objPHPExcel->getActiveSheet()->mergeCells('L3:L4');
        $objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
        $objPHPExcel->getActiveSheet()->mergeCells('N3:N4');
        $objPHPExcel->getActiveSheet()->mergeCells('O3:O4');
        $objPHPExcel->getActiveSheet()->mergeCells('P3:P4');
        $objPHPExcel->getActiveSheet()->mergeCells('P16:P17');
        $objPHPExcel->getActiveSheet()->mergeCells('A17:C17');
        $objPHPExcel->getActiveSheet()->mergeCells('D17:G17');
        $objPHPExcel->getActiveSheet()->mergeCells('H17:O17');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:P4')->applyFromArray(array('font' => array(
            'color' => array('rgb' => 'FFFFFF')
        )));
        $objPHPExcel->getActiveSheet()->getStyle('A3:P4')->getFill()->applyFromArray(
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '337AB7')
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('H17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('A16:P16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A16:P16')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('B3:P3')->getAlignment()->setTextRotation(90);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(100);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

        $date = $this->dateHmin();

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Penjualan Cabang");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $date);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "ZEVA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "G1000");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "BOXER");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "M1000");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "G600");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "ZENA Rotary");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "ZENA Super Power");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "IMPALA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "CAPUNG METAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "CAPUNG RAWA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "CAKAR BAJA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "CAKAR BAJA MINI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "CACAH BUMI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "KASUARI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Total");

        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID . '3')->applyFromArray($style_col);
        }
        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID . '4')->applyFromArray($style_col);
        }
        foreach (range('A4', 'P4') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $typeSingle = $this->M_laporanPenjualanTraktor->getType('SINGLE');
        $sumDate = $this->M_laporanPenjualanTraktor->getCalcDate();

        $numrow = 5;
        foreach ($typeSingle as $data) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['CABANG']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['AAH0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['AAB0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['AAG0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['AAE0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['AAC0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['ACA0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['ACC0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['AAK0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['AAL0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['AAN0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['ADA0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['ADB0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['ADC0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['ADD0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, "=SUM(B".$numrow.":O".$numrow.")");

            $objPHPExcel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);

            $numrow++;
        }

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A16', "TOTAL KOMERSIAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A17', "Laju Penjualan Hari");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B16', "=SUM(B5:B15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C16', "=SUM(C5:C15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D16', "=SUM(D5:D15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D17', "( " . $sumDate['JUMLAH_HARI'] . " / 25 )");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E16', "=SUM(E5:E15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F16', "=SUM(F5:F15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G16', "=SUM(G5:G15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H16', "=SUM(H5:H15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H17', "Total Penjualan =");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I16', "=SUM(I5:I15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J16', "=SUM(J5:J15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K16', "=SUM(K5:K15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L16', "=SUM(L5:L15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M16', "=SUM(M5:M15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N16', "=SUM(N5:N15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O16', "=SUM(O5:O15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P16', "=SUM(P5:P15)");

        $objPHPExcel->getActiveSheet()->getStyle('A16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('C16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('D16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('F16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('G16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('I16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('J16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('L16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('M16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('N16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('O16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('P16:P17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('A17:G17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H17:O17')->applyFromArray($style_row);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
        $today = $this->dateInd(date('Y-m-d'));
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('L Penjualan Tipe Harian');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Per Tipe Harian ' . $today . '.xlsx"');
        $objWriter->save("php://output");
    }

    // function export file excel Total Laporan Omset Penjualan Pertipe Perproduk s/d hari ini
    public function exportTypeTotal()
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Total Laporan Omset Penjualan Pertipe Perproduk s/d hari ini");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $this->dateInd(date('Y-m-d')));
        $objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:P2');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
        $objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
        $objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
        $objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
        $objPHPExcel->getActiveSheet()->mergeCells('F3:F4');
        $objPHPExcel->getActiveSheet()->mergeCells('G3:G4');
        $objPHPExcel->getActiveSheet()->mergeCells('H3:H4');
        $objPHPExcel->getActiveSheet()->mergeCells('I3:I4');
        $objPHPExcel->getActiveSheet()->mergeCells('J3:J4');
        $objPHPExcel->getActiveSheet()->mergeCells('K3:K4');
        $objPHPExcel->getActiveSheet()->mergeCells('L3:L4');
        $objPHPExcel->getActiveSheet()->mergeCells('M3:M4');
        $objPHPExcel->getActiveSheet()->mergeCells('N3:N4');
        $objPHPExcel->getActiveSheet()->mergeCells('O3:O4');
        $objPHPExcel->getActiveSheet()->mergeCells('P3:P4');
        $objPHPExcel->getActiveSheet()->mergeCells('A18:B18');
        $objPHPExcel->getActiveSheet()->mergeCells('D18:E18');
        $objPHPExcel->getActiveSheet()->mergeCells('F18:K18');
        $objPHPExcel->getActiveSheet()->mergeCells('N18:P18');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:P4')->applyFromArray(array('font' => array(
            'color' => array('rgb' => 'FFFFFF')
        )));
        $objPHPExcel->getActiveSheet()->getStyle('A3:P4')->getFill()->applyFromArray(
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array('rgb' => '337AB7')
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('F18:K18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('D18:E18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A16:P16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A16:P16')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('B3:P3')->getAlignment()->setTextRotation(90);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(100);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

        $date = $this->dateHmin();

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Penjualan Cabang");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $date);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "ZEVA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "G1000");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "BOXER");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "M1000");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "G600");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "ZENA Rotary");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "ZENA Super Power");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "IMPALA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "CAPUNG METAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "CAPUNG RAWA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "CAKAR BAJA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "CAKAR BAJA MINI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "CACAH BUMI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "KASUARI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Total");

        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID . '3')->applyFromArray($style_col);
        }
        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        foreach (range('A', 'P') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID . '4')->applyFromArray($style_col);
        }
        foreach (range('A4', 'P4') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $typeTotal = $this->M_laporanPenjualanTraktor->getType('TOTAL');
        $sumDate = $this->M_laporanPenjualanTraktor->getCalcDate();

        $numrow = 5;
        foreach ($typeTotal as $data) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data['CABANG']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['AAH0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['AAB0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['AAG0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['AAE0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['AAC0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['ACA0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['ACC0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['AAK0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['AAL0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['AAN0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['ADA0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['ADB0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['ADC0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['ADD0']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, "=SUM(B" . $numrow . ":O" . $numrow . ")");

            $objPHPExcel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);

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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L16', "=SUM(L5:L15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M16', "=SUM(M5:M15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N16', "=SUM(N5:N15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O16', "=SUM(O5:O15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P16', "=SUM(P5:P15)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A17', "Rata2 Penjualan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B17', "=ROUND((B16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C17', "=ROUND((C16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D17', "=ROUND((D16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E17', "=ROUND((E16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F17', "=ROUND((F16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G17', "=ROUND((G16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H17', "=ROUND((H16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I17', "=ROUND((I16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J17', "=ROUND((J16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K17', "=ROUND((K16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L17', "=ROUND((L16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M17', "=ROUND((M16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N17', "=ROUND((N16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O17', "=ROUND((O16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P17', "=ROUND((P16/D18),0)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A18', "Jumlah hari penjualan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C18', "=");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D18', $sumDate['JUMLAH_HARI']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F18', "Laju Hari");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L18', ":");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M18', "=D18");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N18', "/ 25");

        $objPHPExcel->getActiveSheet()->getStyle('A16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('C16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('D16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('F16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('G16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('I16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('J16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('L16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('M16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('N16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('O16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('P16')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('A17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('B17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('C17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('D17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('E17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('F17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('G17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('H17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('I17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('J17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('K17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('L17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('M17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('N17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('O17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('P17')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('A18:E18')->applyFromArray($style_row);
        $objPHPExcel->getActiveSheet()->getStyle('F18:P18')->applyFromArray($style_row);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
        $today = $this->dateInd(date('Y-m-d'));
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('L Penjualan Tipe Total');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Per Tipe Total ' . $today . '.xlsx"');
        $objWriter->save("php://output");
    }

    // function tanggal = tanggal sekarang dikurangi 1 hari
    function dateHmin()
    {
        $explodeDate = explode('-', date('Y-m-d-D'));
        $year = $explodeDate[0];
        $month = $explodeDate[1];
        $day = $explodeDate[2];
        $nameDay = $explodeDate[3];

        if ($nameDay == 'Mon'){
            $date = date('Y-m-d', strtotime("-2 days"));
        } else {
            $date = date('Y-m-d', strtotime("-1 days"));
        }

        return $this->dateInd($date);
    }

    // function mengubah nama bulan
    function dateInd($date)
    {
         $month = array (
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
 
        return $explode[2] . ' ' . $month[ (int)$explode[1] ] . ' ' . $explode[0];
    }
}