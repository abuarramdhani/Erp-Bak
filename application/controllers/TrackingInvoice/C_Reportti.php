<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Reportti extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        //load the login model
        $this->load->library('session');
        $this->load->model('M_Index');
        $this->load->model('TrackingInvoice/M_trackingInvoice');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        if ($this->session->userdata('logged_in') != TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect();
        }
    }

    // public function index()
    // {
    //     $this->checkSession();
    //     $user_id = $this->session->userid;

    //     $data['Menu'] = 'Dashboard';
    //     $data['SubMenuOne'] = '';

    //     $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    //     $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    //     $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    //     $this->load->view('V_Header', $data);
    //     $this->load->view('V_Sidemenu', $data);
    //     // $this->load->view('V_index',$data);
    //     $this->load->view('V_Footer', $data);
    // }

    public function index()
    {

        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $noinduk = $this->session->userdata['user'];
        $cek_login = $this->M_trackingInvoice->checkSourceLogin($noinduk);

        $getVendors = '';

        if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' or $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN' or $cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR') {
            $getVendors .= "WHERE source = 'PEMBELIAN SUPPLIER' OR source = 'PENGEMBANGAN PEMBELIAN' OR source = 'PEMBELIAN SUBKONTRAKTOR'";
            $nama_vendor = $this->M_trackingInvoice->getVendorName($getVendors);
        } elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
            $getVendors .= "WHERE source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
            $nama_vendor = $this->M_trackingInvoice->getVendorName($getVendors);
        } else {
            $nama_vendor = $this->M_trackingInvoice->getVendorName($getVendors);
        }

        $data['getVendorName'] = $nama_vendor;


        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('TrackingInvoice/V_searchdataInvoice', $data);
        $this->load->view('V_Footer', $data);
    }

    public function btn_search()
    {

        $nama_vendor = $this->input->post('nama_vendor');
        $invoice_date_to = $this->input->post('invoice_date_to');
        $invoice_date_from = $this->input->post('invoice_date_from');


        $param_inv = '';

        if ($nama_vendor != '' or $nama_vendor != NULL) {
            if ($param_inv == '') {
                $param_inv .= 'AND (';
            } else {
                $param_inv .= ' AND ';
            }
            $param_inv .= "ami.vendor_name LIKE '%$nama_vendor%'";
        }
        // (fitur search tanggal) awal-tanggal akhir
        if (($invoice_date_from != '' or $invoice_date_from != NULL) && ($invoice_date_to != '' or $invoice_date_to != NULL)) {
            if ($param_inv == '') {
                $param_inv .= 'AND (';
            } else {
                $param_inv .= ' AND ';
            }
            $param_inv .= "trunc(ami.invoice_date) BETWEEN to_date('$invoice_date_from','dd/mm/yyyy') and to_date('$invoice_date_to', 'dd/mm/yyyy')";
        }


        if ($param_inv != '') {
            $param_inv .= ') ';
        }

        $tabel = $this->M_trackingInvoice->searchMonitoringInvoice($param_inv);

        $status = array();
        foreach ($tabel as $tb => $value) {

            $po_detail = $value['PO_DETAIL'];

            if ($po_detail) {
                $explode_po_detail = explode('<br>', $po_detail);
                if (!$explode_po_detail) {
                    $po_detail = $value['PO_DETAIL'];
                } else {
                    $n = 0;
                    $po_detail2 = array();
                    foreach ($explode_po_detail as $po => $value2) {
                        $explode_lagi = explode('-', $value2);

                        $po_num = $explode_lagi[0];
                        $line_num = $explode_lagi[1];
                        $lppb_num = $explode_lagi[2];

                        if ($line_num == '') {
                            $match = $this->M_trackingInvoice->checkStatusLPPB2($po_num);
                        } else if ($line_num !== '') {
                            $match = $this->M_trackingInvoice->checkStatusLPPB($po_num, $line_num);
                        }

                        foreach ($match as $key => $value) {
                            if ($value == '' || $value == NULL) {
                                $statusLppb = 'No Status';
                            } else {
                                $statusLppb = $match[0]['STATUS'];
                            }
                        }

                        $po_detail2[$po] = $value2 . ' - ' . $statusLppb;
                    }
                    if (array_key_exists('INVOICE_ID', $value) == TRUE) {
                        $status[$value['INVOICE_ID']] = $po_detail2;
                    } else {
                        $status = $po_detail2;
                    }
                    $n++;
                }
            }
        }

        $data['invoice'] = $tabel;
        $data['status'] = $status;
        // $return = $data;
        $return = $this->load->view('TrackingInvoice/V_tableReport', $data, TRUE);
        echo ($return);
    }
    public function exportExcelTrackingInvoice()
    {

        $this->load->library('Excel');
        $nama_vendor = $this->input->post('nama_vendor');
        $po_number = $this->input->post('po_number');
        $any_keyword = $this->input->post('any_keyword');
        $invoice_number = $this->input->post('invoice_number');
        $invoice_date_to = $this->input->post('invoice_date_to');
        $invoice_date_from = $this->input->post('invoice_date_from');
        $action_date = $this->input->post('action_date');

        $param_inv = '';

        if ($nama_vendor != '' or $nama_vendor != NULL) {
            if ($param_inv == '') {
                $param_inv .= 'AND (';
            } else {
                $param_inv .= ' AND ';
            }
            $param_inv .= "ami.vendor_name LIKE '%$nama_vendor%'";
        }

        if ($po_number != '' or $po_number != NULL) {
            if ($param_inv == '') {
                $param_inv .= 'AND (';
            } else {
                $param_inv .= ' AND ';
            }
            $param_inv .= "aaipo.po_detail LIKE '$po_number'";
        }

        if ($invoice_number != '' or $invoice_number != NULL) {
            if ($param_inv == '') {
                $param_inv .= 'AND (';
            } else {
                $param_inv .= ' AND ';
            }
            $param_inv .= "ami.invoice_number LIKE '%$invoice_number%'";
        }
        // (fitur search tanggal) awal-tanggal akhir
        if (($invoice_date_from != '' or $invoice_date_from != NULL) && ($invoice_date_to != '' or $invoice_date_to != NULL)) {
            if ($param_inv == '') {
                $param_inv .= 'AND (';
            } else {
                $param_inv .= ' AND ';
            }
            $param_inv .= "trunc(ami.invoice_date) BETWEEN to_date('$invoice_date_from','dd/mm/yyyy') and to_date('$invoice_date_to', 'dd/mm/yyyy')";
        }

        if ($action_date != '' or $action_date != NULL) {
            if ($param_inv == '') {
                $param_inv .= 'AND (';
            } else {
                $param_inv .= ' AND ';
            }
            $param_inv .= "khs.action_date LIKE '%$action_date%'";
        }

        if ($any_keyword != '' or $any_keyword != NULL) {
            if ($param_inv == '') {
                $param_inv .= 'AND (';
            } else {
                $param_inv .= ' AND ';
            }
            $param_inv .= "(ami.invoice_amount LIKE '$any_keyword' OR ami.tax_invoice_number LIKE '$any_keyword' OR ami.batch_number LIKE '$any_keyword' OR ami.reason LIKE '$any_keyword' OR ami.source LIKE '$any_keyword' OR ami.nominal_dpp LIKE '$any_keyword' OR ami.invoice_category LIKE '$any_keyword')";
        }

        if ($param_inv != '') {
            $param_inv .= ') ';
        }

        $noinduk = $this->session->userdata['user'];
        $cek_login = $this->M_trackingInvoice->checkSourceLogin($noinduk);

        $param_akses = '';

        if ($cek_login[0]['unit_name'] == 'PEMBELIAN SUPPLIER' or $cek_login[0]['unit_name'] == 'PENGEMBANGAN PEMBELIAN' or $cek_login[0]['unit_name'] == 'PEMBELIAN SUBKONTRAKTOR') {
            $param_akses .= "AND (ami.source = 'PEMBELIAN SUPPLIER' OR ami.source = 'PENGEMBANGAN PEMBELIAN' OR ami.source = 'PEMBELIAN SUBKONTRAKTOR')";
            $tabel = $this->M_trackingInvoice->searchMonitoringInvoice($param_inv, $param_akses);
        } elseif ($cek_login[0]['unit_name'] == 'INFORMATION & COMMUNICATION TECHNOLOGY') {
            $param_akses .= "AND ami.source = 'INFORMATION & COMMUNICATION TECHNOLOGY'";
            $tabel = $this->M_trackingInvoice->searchMonitoringInvoice($param_inv, $param_akses);
        } else {
            $tabel = $this->M_trackingInvoice->searchMonitoringInvoice($param_inv, $param_akses);
        }

        $status = array();
        foreach ($tabel as $tb => $value) {
            $po_detail = $value['PO_DETAIL'];

            if ($po_detail) {
                $explode_po_detail = explode('<br>', $po_detail);
                if (!$explode_po_detail) {
                    $po_detail = $value['PO_DETAIL'];
                } else {
                    $n = 0;
                    $po_detail2 = array();
                    foreach ($explode_po_detail as $po => $value2) {
                        $explode_lagi = explode('-', $value2);

                        $po_num = $explode_lagi[0];
                        $line_num = $explode_lagi[1];
                        $lppb_num = $explode_lagi[2];

                        $match = $this->M_trackingInvoice->checkStatusLPPB($po_num, $line_num);

                        if ($match[0]['STATUS'] == '' || $match[0]['STATUS'] == NULL) {
                            $statusLppb = 'No Status';
                        } else {
                            $statusLppb = $match[0]['STATUS'];
                        }

                        $po_detail2[$po] = $value2 . ' - ' . $statusLppb;
                    }
                    $status[$value['INVOICE_ID']] = $po_detail2;
                    $n++;
                }
            }
        }
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT TRACKING INVOICE");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Date : ".$dateTarikFrom.' s/d '.$dateTarikTo);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Vendor Name");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Invoice Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Invoice Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Action Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Action Status");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Tax Invoice Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Invoice Amount");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "PO Detail");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Status");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "PIC");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);

        foreach (range('B', 'K') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID . '4')->applyFromArray($style_col);
        }

        foreach (range('A', 'I') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $fetch = $this->M_trackingInvoice->searchMonitoringInvoice($param_inv, $param_akses);

        $no = 1;
        $numrow = 5;
        foreach ($fetch as $data) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['VENDOR_NAME']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['INVOICE_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['INVOICE_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['ACTION_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['STATUS']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['TAX_INVOICE_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['INVOICE_AMOUNT']);
            foreach ($status[$data["INVOICE_ID"]] as $i) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $i);
            }

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['STATUS_PAYMENT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data['SOURCE']);

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

            $no++;
            $numrow++;
        }

        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Report Tracking Invoice');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Report_Tracking_Invoice ' . $nama_vendor . ' - ' . $po_number . '- ' . $invoice_date_from . ' - ' . $invoice_date_to . '.xlsx"');
        $objWriter->save("php://output");
    }
}
