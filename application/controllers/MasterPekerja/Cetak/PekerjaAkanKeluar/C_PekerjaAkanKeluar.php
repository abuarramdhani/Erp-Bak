<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * helper
 */
function debug($arr)
{
    echo "<pre>";
    print_r($arr);
    die;
}

class C_PekerjaAkanKeluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MasterPekerja/Cetak/DataPekerjaAkanKeluar/M_DataPekerjaAkanKeluar');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        if (!$this->session->is_logged) {
            return redirect(base_url('/'));
        }
    }

    public function index()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['dataPersonal'] = $this->M_DataPekerjaAkanKeluar->getPekerjaAkanKeluar();
        $data['dataDimutasi'] = $this->M_DataPekerjaAkanKeluar->getPekerjaDimutasi();
        $data['dataDiperbantukan'] = $this->M_DataPekerjaAkanKeluar->getPekerjaDiperbantukan();

        $data['outSourcing'] = $this->M_DataPekerjaAkanKeluar->getOS();

        $data['Title'] = 'Cetak Daftar Pekerja Akan Keluar';
        $data['Menu'] = 'Cetak';
        $data['SubMenuOne'] = 'Cetak Daftar Pekerja akan Keluar';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MasterPekerja/Cetak/PekerjaAkanKeluar/V_PekerjaAkanKeluar', $data);
        $this->load->view('V_Footer', $data);
    }

    /**
     * REST API
     * @method GET
     * @return JSON 
     */
    public function get_pekerja_keluar()
    {
        $with_os = $this->input->get('with_os') == 'true';
        $os_name = $this->input->get('os_name');
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');

        $data  = $this->M_DataPekerjaAkanKeluar->getPekerjaKeluarWithParam($with_os, $os_name, $datepicker, $rangeDate);

        echo json_encode(array(
            'success' => true,
            'data' => $data
        ));
    }

    /**
     * REST API
     * @method GET
     * @return JSON
     */

    public function get_pekerja_dimutasi()
    {
        $with_os = $this->input->get('with_os') == 'true';
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');

        $data = $this->M_DataPekerjaAkanKeluar->getPekertaDimutasiWithParam($with_os, $datepicker, $rangeDate);

        echo json_encode(array(
            'success' => true,
            'data' => $data
        ));
    }

    /**
     * REST API
     * @method GET
     * @return JSON
     */

    public function get_pekerja_diperbantukan()
    {
        $with_os = $this->input->get('with_os') == 'true';
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');

        $data = $this->M_DataPekerjaAkanKeluar->getPekerjaDiperbantukanWithParam($with_os, $datepicker, $rangeDate);

        echo json_encode(array(
            'success' => true,
            'data' => $data
        ));
    }


    public function export_excel()
    {
        $this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
        $excel = new PHPExcel();
        $with_os = $this->input->get('with_os') == 'true';
        $os_name = $this->input->get('os_name');
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');
        $data  = $this->M_DataPekerjaAkanKeluar->getPekerjaKeluarWithParam($with_os, $os_name, $datepicker, $rangeDate);


        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_row = array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )

        );

        $this->load->library('KonversiBulan');
        $KonversiBulan = new KonversiBulan();

        if ($rangeDate) {
            $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Pekerja Akan Keluar Periode " . $rangeDate);
        } else {
            $exp = explode("/", $datepicker);

            $format = $KonversiBulan->KonversiAngkaKeBulan((string)$exp[0]);
            $gabung = $format . " " . (string)$exp[1];
            $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Pekerja Akan Keluar Periode Bulan " . $gabung);
        }

        $excel->getActiveSheet()->mergeCells('A1:O1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "No Ind");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Seksi");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Unit");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Bidang");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "Dept");
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "Masuk Kerja");
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "Diangkat");
        $excel->setActiveSheetIndex(0)->setCellValue('J3', "Tgl Keluar");
        $excel->setActiveSheetIndex(0)->setCellValue('K3', "Akh Kontrak");
        $excel->setActiveSheetIndex(0)->setCellValue('L3', "Lm Kontrak");
        $excel->setActiveSheetIndex(0)->setCellValue('M3', "Ket");
        $excel->setActiveSheetIndex(0)->setCellValue('N3', "Asal OS");
        $excel->setActiveSheetIndex(0)->setCellValue('O3', "Lokasi Kerja");

        $excel->getActiveSheet()->getStyle('A3:O3')->applyFromArray($style_col);

        $no = 1;
        $numrow = 4;
        foreach ($data as $data) {
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['noind']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['nama']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['seksi']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['unit']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['bidang']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['dept']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['masukkerja']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['diangkat']);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['tglkeluar']);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['akhkontrak']);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data['lmkontrak']);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data['ket']);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['asal_outsourcing']);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['lokasi_kerja']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_center);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);

            $color1 = array(
                'font' => array(
                    'color' => array('rgb' => 'fc0303')
                )
            );
            $color2 = array(
                'font' => array(
                    'color' => array('rgb' => '000')
                )
            );
            $color3 = array(
                'font' => array(
                    'color' => array('rgb' => '3059fc')
                )
            );

            if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                $excel->getActiveSheet()->getStyle("A$numrow:P$numrow")->applyFromArray($color1);
            } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                $excel->getActiveSheet()->getStyle("A$numrow:P$numrow")->applyFromArray($color2);
            } else {
                $excel->getActiveSheet()->getStyle("A$numrow:P$numrow")->applyFromArray($color3);
            }
            $no++;
            $numrow++;
        }

        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $highestColumn = $excel->getActiveSheet()->getHighestDataColumn();
        $from = 'A';
        while ($from !== $highestColumn) {
            $from++;
            $excel->getActiveSheet()->getColumnDimension($from)->setAutoSize(true);
        }

        $excel->getActiveSheet(0)->setTitle("HALLO");
        $excel->setActiveSheetIndex(0);
        $fileformat = ".xlsx";
        if ($rangeDate) {
            $filename = urldecode("DataPekerjaAkanKeluarPeriode-" . $rangeDate . "$fileformat");
        } else {
            $filename = urldecode("DataPekerjaAkanKeluarPeriode-" . $datepicker . "$fileformat");
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $write->save('php://output');
    }

    public function export_pdf()
    {
        $with_os = $this->input->get('with_os') == 'true';
        $os_name = $this->input->get('os_name');
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');
        $data  = $this->M_DataPekerjaAkanKeluar->getPekerjaKeluarWithParam($with_os, $os_name, $datepicker, $rangeDate);

        $this->load->library('pdf');

        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf8', "A4-L", 11, '', 10, 10, 10, 10, 0, 0);
        $filename = 'DataPekerjaAkanKeluar.pdf';

        $format = $this->M_DataPekerjaAkanKeluar->tgl_indo1($datepicker);

        $html = $this->load->view('MasterPekerja/Cetak/PekerjaAkanKeluar/V_cetakPDFpekerjakeluar', [
            'listOfdata' => $data,
            'date1' => $format,
            'date2' => $rangeDate
        ], true);
        $pdf->WriteHTML($html, 2);
        $fileformat = ".pdf";
        if ($rangeDate) {
            $filename = urldecode("DataPekerjaAkanKeluarPeriode-" . $rangeDate . "$fileformat");
        } else {
            $filename = urldecode("DataPekerjaAkanKeluarPeriode-" . $datepicker . "$fileformat");
        }
        $pdf->text_input_as_HTML = true;
        $pdf->SetHTMLHeader($filename);
        $pdf->setTitle($filename);
        $pdf->Output($filename, 'D');
    }

    public function export_pdf_diperbantukan()
    {
        $with_os = $this->input->get('with_os') == 'true';
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');

        $data = $this->M_DataPekerjaAkanKeluar->getPekerjaDiperbantukanWithParam($with_os, $datepicker, $rangeDate);

        $this->load->library('pdf');

        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf8', "A4", 11, '', 10, 10, 10, 10, 0, 0, 'P');
        $filename = 'DataPekerjaDiperbantuakan.pdf';
        $format = $this->M_DataPekerjaAkanKeluar->tgl_indo1($datepicker);
        $html = $this->load->view(
            'MasterPekerja/Cetak/PekerjaAkanKeluar/V_cetakPDFpekerjadiperbantukan',
            [
                'dataDiperbantukan' => $data,
                'date1' => $format,
                'date2' => $rangeDate
            ],
            true
        );
        $pdf->WriteHTML($html, 2);
        $fileformat = ".pdf";
        if ($rangeDate) {
            $filename = urldecode("DataPekerjaDiperbantukanPeriode-" . $rangeDate . "$fileformat");
        } else {
            $filename = urldecode("DataPekerjaDiperbantukanPeriode-" . $datepicker . "$fileformat");
        }
        $pdf->setTitle($filename);
        $pdf->Output($filename, 'D');
    }

    public function export_excel_diperbantukan()
    {
        $this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
        $excel = new PHPExcel();

        $with_os = $this->input->get('with_os') == 'true';
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');

        $data = $this->M_DataPekerjaAkanKeluar->getPekerjaDiperbantukanWithParam($with_os, $datepicker, $rangeDate);

        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_row = array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        if ($rangeDate) {
            $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Pekerja Diperbantukan Periode " . $rangeDate);
        } else {
            $format = $this->M_DataPekerjaAkanKeluar->tgl_indo1($datepicker);
            $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Pekerja Diperbantukan Periode " . $format);
        }
        $excel->getActiveSheet()->mergeCells('A1:I1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "No Induk");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Seksi/Unit Asal");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Diperbantukan Ke");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Gol Kerja");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "Pekerjaan");
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "Periode");
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "Keterangan");

        $excel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($style_col);

        $no = 1;
        $numrow = 4;
        foreach ($data as $data) {
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['noind']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['nama']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['seksi_awal']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['seksi_perbantuan']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['golkerja']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['pekerjaan']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['lama']);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['ket']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_center);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_center);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);

            $color1 = array(
                'font' => array(
                    'color' => array('rgb' => 'fc0303')
                )
            );
            $color2 = array(
                'font' => array(
                    'color' => array('rgb' => '000')
                )
            );
            $color3 = array(
                'font' => array(
                    'color' => array('rgb' => '3059fc')
                )
            );

            if ($data['fd_tgl_selesai'] < date("Y-m-d") && $data['berlaku'] == '1') {
                $excel->getActiveSheet()->getStyle("A$numrow:I$numrow")->applyFromArray($color1);
            } else if ($data['fd_tgl_selesai'] < date("Y-m-d") && $data['berlaku'] == '0') {
                $excel->getActiveSheet()->getStyle("A$numrow:I$numrow")->applyFromArray($color3);
            } else {
                $excel->getActiveSheet()->getStyle("A$numrow:I$numrow")->applyFromArray($color2);
            }

            $no++;
            $numrow++;
        }
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $highestColumn = $excel->getActiveSheet()->getHighestDataColumn();
        $from = 'A';
        while ($from !== $highestColumn) {
            $from++;
            $excel->getActiveSheet()->getColumnDimension($from)->setAutoSize(true);
        }

        $excel->getActiveSheet(0)->setTitle("Sheet1");
        $excel->setActiveSheetIndex(0);
        $fileformat = ".xlsx";
        if ($rangeDate) {
            $filename = urldecode("DataPekerjaDiperbantukanPeriode-" . $rangeDate . "$fileformat");
        } else {
            $filename = urldecode("DataPekerjaDiperbantukanPeriode-" . $datepicker . "$fileformat");
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $write->save('php://output');
    }

    public function export_excel_mutasi()
    {
        $this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
        $excel = new PHPExcel();

        $with_os = $this->input->get('with_os') == 'true';
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');

        $data = $this->M_DataPekerjaAkanKeluar->getPekertaDimutasiWithParam($with_os, $datepicker, $rangeDate);

        $style_col = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_row = array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        if ($rangeDate) {
            $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Pekerja Dimutasi Periode " . $rangeDate);
        } else {
            $format = $this->M_DataPekerjaAkanKeluar->tgl_indo1($datepicker);
            $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Pekerja Dimutasi Periode " . $format);
        }

        $excel->getActiveSheet()->mergeCells('A1:H1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "No Induk");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama");
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Seksi/Unit Asal");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Dimutasi Ke");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Gol Kerja");
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "Pekerjaan");
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "Mulai Belaku");

        $excel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($style_col);

        $no = 1;
        $numrow = 4;
        foreach ($data as $data) {
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['noind']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['nama']);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['seksi_lama']);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['seksi_baru']);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['golkerjabr']);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['pekerjaan']);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['tglberlaku']);

            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_center);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_center);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        $highestColumn = $excel->getActiveSheet()->getHighestDataColumn();
        $from = 'A';
        while ($from !== $highestColumn) {
            $from++;
            $excel->getActiveSheet()->getColumnDimension($from)->setAutoSize(true);
        }

        $excel->getActiveSheet(0)->setTitle("Sheet1");
        $excel->setActiveSheetIndex(0);
        $fileformat = ".xlsx";
        if ($rangeDate) {
            $filename = urldecode("DataPekerjaDimutasiPeriode-" . $rangeDate . "$fileformat");
        } else {
            $filename = urldecode("DataPekerjaDimutasiPeriode-" . $datepicker . "$fileformat");
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $write->save('php://output');
    }

    public function export_pdf_mutasi()
    {
        $with_os = $this->input->get('with_os') == 'true';
        $datepicker = $this->input->get('datepicker');
        $rangeDate = $this->input->get('rangeDate');

        $data = $this->M_DataPekerjaAkanKeluar->getPekertaDimutasiWithParam($with_os, $datepicker, $rangeDate);

        $this->load->library('pdf');

        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf8', "A4", 11, '', 10, 10, 10, 10, 0, 0);
        $filename = 'DataPekerjaDimutasi.pdf';
        $format = $this->M_DataPekerjaAkanKeluar->tgl_indo1($datepicker);
        $html = $this->load->view(
            'MasterPekerja/Cetak/PekerjaAkanKeluar/V_cetakPDFpekerjadimutasi',
            [
                'dataDimutasi' => $data,
                'date1' => $format,
                'date2' => $rangeDate
            ],
            true
        );
        $pdf->WriteHTML($html, 2);
        $fileformat = ".pdf";
        if ($rangeDate) {
            $filename = urldecode("DataPekerjaDimutasiPeriode-" . $rangeDate . "$fileformat");
        } else {
            $filename = urldecode("DataPekerjaDimutasiPeriode-" . $datepicker . "$fileformat");
        }
        $pdf->setTitle($filename);
        $pdf->Output($filename, 'D');
    }
}
