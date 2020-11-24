<?php
defined('BASEPATH') or exit('I am not a monster, i am demon');

class C_Monitoring extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('WasteManagementSeksi/MainMenu/M_kirim');
        $this->load->model('WasteManagement/MainMenu/M_limbahkelola');
        $this->load->model('WasteManagement/MainMenu/M_limbahrekap');

        if (!$this->session->is_logged) {
            return redirect(base_url('/'));
        }
    }

    function index()
    {
        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring Limbah';
        $data['Menu'] = 'Monitoring Limbah';
        $data['SubMenuOne'] = 'Kelola Limbah';
        $data['SubMenuTwo'] = 'Monitoring Limbah';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // get all jenis limbah
        $data['jenisLimbah'] = $this->M_kirim->getLimJenis($this->session->kodesie);
        $data['loc'] = $this->M_limbahrekap->getLokasi();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('WasteManagement/LimbahMonitoring/V_Index');
        $this->load->view('V_Footer', $data);
    }

    function apiGetDataLimbah()
    {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $limbah = isset($_GET['jenis']) ? $_GET['jenis'] : [];
        $lokasi = isset($_GET['lokasi']) ? $_GET['lokasi'] : [];
        $detailed = $_GET['detailed'];

        $data = $this->M_limbahkelola->getDataLimbah($start, $end, $limbah, $lokasi, $detailed);

        $result = array(
            'success' => $data ? true : false,
            'data' => $data
        );
        echo json_encode($result);
    }

    function cetakExcel()
    {
        $this->load->library('Excel');

        $start = $_GET['start'];
        $end = $_GET['end'];
        $limbah = (isset($_GET['jenis']) && !empty($_GET['jenis'])) ? $_GET['jenis'] : [];
        $lokasi = (isset($_GET['lokasi']) && !empty($_GET['lokasi'])) ? $_GET['lokasi'] : [];
        $detailed = $_GET['detailed'];

        $data = $this->M_limbahkelola->getDataLimbah($start, $end, $limbah, $lokasi, $_GET['detailed'] ? 'true' : 'false');

        // print("<pre>");
        // print_r($data);
        // die;

        $objPHPExcel     = new PHPExcel();
        $worksheet         = $objPHPExcel->getActiveSheet();
        $sheet             = $objPHPExcel->setActiveSheetIndex(0);

        //Style
        $border = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $borderleft = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );
        $borderright = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );
        $borderbottom = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );
        $bordertop = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            )
        );

        $bold = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 10
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $thead = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 9
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'c4c4c4')
            )
        );

        $alignmentCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $alignmentRight = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $tdata = array(
            'font'  => array(
                'size'  => 8
            )
        );

        $totalBerat = 0;

        if ($detailed) {
            $worksheet->getStyle('A1:H1')->applyFromArray($bold);

            //Width
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);

            //Value
            $sheet->setTitle('Sheet1');
            $sheet->setCellValue('A1', 'Monitoring Limbah');
            $worksheet->mergeCells('A1:H1');

            $sheet->setCellValue('A2', 'Periode : ' . $start . " s/d " . $end);
            $worksheet->mergeCells('A2:H2');
            // HERE IS HELL
            $worksheet->getStyle('A1:H1')->applyFromArray($alignmentCenter);
            $worksheet->getStyle('A2:H2')->applyFromArray($alignmentCenter);
            $worksheet->getStyle('A3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('B3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('C3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('D3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('E3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('F3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('G3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('H3')->applyFromArray($border)->applyFromArray($thead);
            $sheet->setCellValue('A3', 'No ');
            $sheet->setCellValue('B3', 'Jenis Limbah');
            $sheet->setCellValue('C3', 'Pekerja Pengirim');
            $sheet->setCellValue('D3', 'Tanggal Masuk');
            $sheet->setCellValue('E3', 'Waktu');
            $sheet->setCellValue('F3', 'Seksi Pengirim');
            $sheet->setCellValue('G3', 'Jumlah Limbah');
            $sheet->setCellValue('H3', 'Berat(Kg)');

            $i = 3;
            $nomor = 0;
            foreach ($data as $key) {
                $i++;
                $nomor++;

                $kolomA = 'A' . $i;
                $kolomB = 'B' . $i;
                $kolomC = 'C' . $i;
                $kolomD = 'D' . $i;
                $kolomE = 'E' . $i;
                $kolomF = 'F' . $i;
                $kolomG = 'G' . $i;
                $kolomH = 'H' . $i;

                $sheet->setCellValueExplicit($kolomA, $nomor, PHPExcel_Cell_DataType::TYPE_NUMERIC)
                    ->setCellValueExplicit($kolomB, $key['jenis_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomC, $key['pekerja'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomD, $key['tanggal_kirim'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomE, $key['waktu'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomF, $key['section_name'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomG, $key['jumlahall'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomH, floatval($key['berat_kirim']), PHPExcel_Cell_DataType::TYPE_STRING);

                $worksheet->getStyle($kolomA)->applyFromArray($alignmentCenter);
                $worksheet->getStyle($kolomD)->applyFromArray($alignmentCenter);
                $worksheet->getStyle($kolomE)->applyFromArray($alignmentCenter);
                $worksheet->getStyle($kolomH)->applyFromArray($alignmentRight);

                $worksheet->getStyle($kolomA)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomB)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomC)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomD)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomE)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomF)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomG)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomH)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);

                $totalBerat = $totalBerat + floatval($key['berat_kirim']);
            }

            $i++;
            // print("<pre>");
            // print_r($i);
            // die;

            $worksheet->mergeCells("A{$i}:G{$i}");
            $worksheet->getStyle("A{$i}:G{$i}")->applyFromArray($alignmentCenter);
            $worksheet->getStyle("A{$i}:H{$i}")->applyFromArray($border);

            $worksheet->setCellValue("A{$i}", "Total Berat Limbah");
            $worksheet->setCellValue("H{$i}", number_format((float)$totalBerat, 3, '.', ''));
            $worksheet->getStyle("G{$i}")->applyFromArray($border);
        } else {
            $worksheet->getStyle('A1:C1')->applyFromArray($bold);

            //Width
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);

            //Value
            $sheet->setTitle('Sheet1');
            $sheet->setCellValue('A1', 'Monitoring Limbah');
            $worksheet->mergeCells('A1:C1');

            $sheet->setCellValue('A2', 'Periode : ' . $start . " s/d " . $end);
            $worksheet->mergeCells('A2:C2');
            $worksheet->getStyle('A2:C2')->applyFromArray($alignmentCenter);

            $worksheet->getStyle('A3:C1')->applyFromArray($alignmentCenter);
            $worksheet->getStyle('A3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('B3')->applyFromArray($border)->applyFromArray($thead);
            $worksheet->getStyle('C3')->applyFromArray($border)->applyFromArray($thead);

            $sheet->setCellValue('A3', 'No');
            $sheet->setCellValue('B3', 'Jenis Limbah');
            $sheet->setCellValue('C3', 'Berat(Kg)');

            $i = 3;
            $nomor = 0;
            foreach ($data as $key) {
                $i++;
                $nomor++;

                $kolomA = 'A' . $i;
                $kolomB = 'B' . $i;
                $kolomC = 'C' . $i;

                $sheet->setCellValueExplicit($kolomA, $nomor, PHPExcel_Cell_DataType::TYPE_NUMERIC)
                    ->setCellValueExplicit($kolomB, $key['jenis_limbah'], PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValueExplicit($kolomC, floatval($key['berat_kirim']), PHPExcel_Cell_DataType::TYPE_STRING);
                $worksheet->getStyle($kolomA)->applyFromArray($alignmentCenter);
                $worksheet->getStyle($kolomB)->applyFromArray($alignmentCenter);

                $worksheet->getStyle($kolomA)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomB)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);
                $worksheet->getStyle($kolomC)->applyFromArray($borderleft)
                    ->applyFromArray($borderright)
                    ->applyFromArray($borderbottom)
                    ->applyFromArray($bordertop);

                $totalBerat = $totalBerat + floatval($key['berat_kirim']);
            }

            $i++;

            $worksheet->mergeCells("A{$i}:B{$i}");
            $worksheet->getStyle("A{$i}:B{$i}")->applyFromArray($alignmentCenter);
            $worksheet->getStyle("A{$i}:B{$i}")->applyFromArray($border);

            $worksheet->setCellValue("A{$i}", "Total Berat Limbah");
            $worksheet->setCellValue("C{$i}", number_format((float)$totalBerat, 3, '.', ''));
            $worksheet->getStyle("C{$i}")->applyFromArray($border);
        }

        $title_detailed = $detailed ? "_detailed" : '';
        $title = date('d-m-Y', strtotime($start)) . " - " . date('d-m-Y', strtotime($end)) . $detailed;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=MonitoringLimbah_{$title}.xls");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objPHPExcel->getProperties()->setCreator("Sistem")
            ->setLastModifiedBy("Sistem")
            ->setTitle("Sistem")
            ->setSubject("Sistem")
            ->setDescription("Sistem")
            ->setKeywords("Sistem")
            ->setCategory("Sistem");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    function cetakPdf()
    {
        $this->load->library('pdf');
        $start = $_GET['start'];
        $end = $_GET['end'];
        $limbah = (isset($_GET['jenis']) && !empty($_GET['jenis'])) ? $_GET['jenis'] : [];
        $lokasi = (isset($_GET['lokasi']) && !empty($_GET['lokasi'])) ? $_GET['lokasi'] : [];
        $detailed = $_GET['detailed'];

        $data = $this->M_limbahkelola->getDataLimbah($start, $end, $limbah, $lokasi,  $_GET['detailed'] ? 'true' : 'false');

        // print("<pre>");
        // print_r($data);
        // die;
        $pdf = $this->pdf->load();

        if ($detailed) {
            $html = $this->load->view('WasteManagement/LimbahMonitoring/V_exp_pdf_detail', [
                'data' => $data,
                'start' => $start,
                'end' => $end
            ], true);
        } else {
            $html = $this->load->view('WasteManagement/LimbahMonitoring/V_exp_pdf',  [
                'data' => $data,
                'start' => $start,
                'end' => $end
            ], true);
        }

        $pdf = new mPDF('utf8', "A4", 11, '', 10, 10, 10, 10, 0, 0);
        $title = date('d-m-Y', strtotime($start)) . " - " . date('d-m-Y', strtotime($end)) . '-' . $detailed;
        $filename = 'CetakMonitoringLimbah' . $title . '.pdf';

        $pdf->WriteHTML($html);
        $pdf->text_input_as_HTML = true;
        $pdf->SetHTMLHeader($filename);
        $pdf->setTitle($filename);
        $pdf->Output($filename, 'D');
    }
}
