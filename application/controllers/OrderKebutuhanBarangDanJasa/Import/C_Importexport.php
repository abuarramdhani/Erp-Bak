<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Importexport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('encrypt');
        $this->load->library('Excel');
        //load the login model
        $this->load->library('session');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
        $this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
        $this->load->model('OrderKebutuhanBarangDanJasa/Import/M_import');


        if ($this->session->userdata('logged_in') != TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }

        if ($this->session->is_logged == FALSE) {
            redirect();
        }

        date_default_timezone_set("Asia/Bangkok");
    }
    public function ExportApproval()
    {

        $user_id = $this->session->userid;

        $data['Menu'] = '';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Import/V_ExportApproval', $data);
        $this->load->view('V_Footer', $data);
    }
    public function searchApproval()
    {
        $number = $_GET['q'];
        if ($number == 3 || $number == 5) {
            $data = $this->M_import->getApproverSeksi($number);
        } else if ($number == 7) {
            $data = $this->M_import->getApproverPengelola($number);
        } else if ($number == 8) {
            $data = $this->M_import->getApproverDepartement($number);
        }

        echo json_encode($data);
    }
    public function ExportFileApproval()
    {
        $created_by = $this->session->user;
        $headexportdata = $this->M_import->getExportHeadDataApproval($created_by, $_POST['okbj_name_approver'], $_POST['okbj_lvl_approval']);
        $exportdata = $this->M_import->getExportDataApproval($created_by, $_POST['okbj_name_approver'], $_POST['okbj_lvl_approval']);

        if ($headexportdata == null || $exportdata == null) {

            $user_id = $this->session->userid;

            $data['Menu'] = '';
            $data['SubMenuOne'] = '';

            $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
            $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
            $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

            $this->load->view('V_Header', $data);
            $this->load->view('OrderKebutuhanBarangDanJasa/Import/V_ErrorExport');
            $this->load->view('V_Sidemenu', $data);
            $this->load->view('V_Footer', $data);
        } else {
            // echo "<pre>";
            // print_r($headexportdata);
            // print_r($exportdata);
            // exit();

            require_once APPPATH . 'third_party/Excel/PHPExcel.php';
            require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';
            $objPHPExcel = new PHPExcel();
            $worksheet = $objPHPExcel->getActiveSheet();

            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
            $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);

            $objPHPExcel->getActiveSheet()->getProtection()->setPassword($headexportdata[0]['NIK_APPROVER'] . '121212');

            $worksheet->getColumnDimension('A')->setAutoSize(true);
            $worksheet->getColumnDimension('B')->setAutoSize(true);
            $worksheet->getColumnDimension('C')->setAutoSize(true);
            $worksheet->getColumnDimension('D')->setAutoSize(true);
            $worksheet->getColumnDimension('E')->setAutoSize(true);
            $worksheet->getColumnDimension('F')->setAutoSize(true);
            $worksheet->getColumnDimension('G')->setAutoSize(true);
            $worksheet->getColumnDimension('H')->setAutoSize(true);
            $worksheet->getColumnDimension('I')->setAutoSize(true);
            $worksheet->getColumnDimension('J')->setAutoSize(true);
            $worksheet->getColumnDimension('K')->setAutoSize(true);
            $worksheet->getColumnDimension('L')->setAutoSize(true);


            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Creator");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $headexportdata[0]['NIK_PEMBUAT'] . ' - ' . $headexportdata[0]['NAMA_PEMBUAT']);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "Requestor");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', $headexportdata[0]['NIK_REQUESTER'] . ' - ' . $headexportdata[0]['NAMA_REQUESTER']);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Approver");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', $headexportdata[0]['NIK_APPROVER'] . ' - ' . $headexportdata[0]['NAMA_APPROVER']);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "Approver Level");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', $headexportdata[0]['LEVEL_APPROVED']);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'OKEBAJAQUICKYOSYOSYOS');

            $worksheet->getStyle("C1")->getFont()->getColor()->setRGB('FFFFFF');


            $thin = array();
            $thin['borders'] = array();
            $thin['borders']['allborders'] = array();
            $thin['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_THIN;

            $right = array();
            $right['borders'] = array();
            $right['borders']['right'] = array();
            $right['borders']['right']['style'] = PHPExcel_Style_Border::BORDER_THIN;

            $left = array();
            $left['borders'] = array();
            $left['borders']['left'] = array();
            $left['borders']['left']['style'] = PHPExcel_Style_Border::BORDER_THIN;

            $bottom = array();
            $bottom['borders'] = array();
            $bottom['borders']['bottom'] = array();
            $bottom['borders']['bottom']['style'] = PHPExcel_Style_Border::BORDER_THIN;

            $top = array();
            $top['borders'] = array();
            $top['borders']['top'] = array();
            $top['borders']['top']['style'] = PHPExcel_Style_Border::BORDER_THIN;

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "Order Id");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5', "Item Code");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', "Item Description");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', "Quantity");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5', "UoM");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F5', "Need By Date");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5', "Order Purpose");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', "Note To Pengelola");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I5', "Urgent Reason");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J5', "Note to Buyer");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K5', "Status");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L5', "Judgement");

            $worksheet->getStyle('A5:L5')->applyFromArray($thin);
            $worksheet->getStyle('A5:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $row = 6;
            foreach ($exportdata as $key => $export) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $export['ORDER_ID']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $export['ITEM_CODE']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $export['ITEM_DESCRIPTION']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $export['QUANTITY']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $export['UOM']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, $export['NEED_BY_DATE']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, $export['ORDER_PURPOSE']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, $export['NOTE_TO_PENGELOLA']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, $export['URGENT_REASON']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row, $export['NOTE_TO_BUYER']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row, $export['STATUS']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $row, "");

                $worksheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($thin);

                $row++;
            }

            $worksheet->getDefaultRowDimension()->setRowHeight(-1);
            $worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $objPHPExcel->setActiveSheetIndex(0);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DocumentApprovalOkebaja.xlsx"');
            ob_end_clean();
            $objWriter->save("php://output");
        }
    }
    public function ImportApproval()
    {
        $user_id = $this->session->userid;

        $data['Menu'] = '';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Import/V_ImportApproval', $data);
        $this->load->view('V_Footer', $data);
    }
    public function ImportFileApproval()
    {
        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';

        // load excel
        $file = $_FILES['FileApprovalOkebaja']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->setActiveSheetIndex(0)->toArray(null, true, true, true);
        $k = 0;
        $array_line_order = array();
        foreach ($sheets as $row) {
            if ($k < 4) {
                $data_header[] = $row['B'];
                $katakunci[] = $row['C'];
            }

            if ($k > 4) {
                $a = array(
                    'order_id' => $row['A'],
                    'item_code' => $row['B'],
                    'item_desc' => $row['C'],
                    'quantity' => $row['D'],
                    'uom' => $row['E'],
                    'nbd' => $row['F'],
                    'order_purpose' => $row['G'],
                    'note_to_pengelola' => $row['H'],
                    'urgent_reason' => $row['I'],
                    'note_to_buyer' => $row['J'],
                    'status' => $row['K'],
                    'judgement' => $row['L']
                );

                array_push($array_line_order, $a);
            }
            $k++;
        }
        // echo "<pre>";
        // print_r($tmpData);
        // print_r($array_line_order);
        // exit();
        $datacreator = explode(' - ', $data_header[0]);
        $datarequester = explode(' - ', $data_header[1]);
        $dataapprover = explode(' - ', $data_header[2]);
        $tbody = "";
        foreach ($array_line_order as $key => $ord) {
            $cek_status_approval = $this->M_import->getStatusOrder($ord['order_id'], $dataapprover[0], $data_header[3]);
            if ($cek_status_approval[0]['JUDGEMENT'] == 'A' || $cek_status_approval[0]['JUDGEMENT'] == 'R') {
            } else {
                $tbody .= '
                <tr>
                    <td class="text-center">' . $ord['order_id'] . '</td>
                    <input type="hidden" value="' . $ord['order_id'] . '" name="ord_id_okbj">
                    <td class="text-center">' . $ord['item_code'] . '</td>
                    <td class="text-center">' . $ord['item_desc'] . '</td>
                    <td class="text-center">' . $ord['quantity'] . '</td>
                    <td class="text-center">' . $ord['uom'] . '</td>
                    <td class="text-center">' . $ord['nbd'] . '</td>
                    <td class="text-center">' . $ord['order_purpose'] . '</td>
                    <td class="text-center">' . $ord['note_to_pengelola'] . '</td>
                    <td class="text-center">' . $ord['urgent_reason'] . '</td>
                    <td class="text-center">' . $ord['note_to_buyer'] . '</td>
                    <td class="text-center">' . $ord['status'] . '</td>
                    <td class="text-center">' . $ord['judgement'] . '</td>
                    <input type="hidden" value="' . $ord['judgement'] . '" name="judgement_okbj">

                </tr>
                ';
            }
        }

        $table = '
        <div class="col-md-1"><b>Creator</b></div>
        <div class=" col-md-11"><b>:</b> ' . $datacreator[1] . '</div>
        <input type="hidden" value="' . $datacreator[0] . '" id="IndukCreatorOkbj">

        <div class="col-md-1"><b>Requester</b></div>
        <div class=" col-md-11"><b>:</b> ' . $datarequester[1] . '</div>
        <input type="hidden" value="' . $datarequester[0] . '" id="IndukRequesterOkbj">

        <div class="col-md-1"><b>Approver</b></div>
        <div class=" col-md-11"><b>:</b> ' . $dataapprover[1] . '</div>
        <input type="hidden" value="' . $dataapprover[0] . '" id="IndukApproverOkbj">

        <input type="hidden" value="' . $data_header[3] . '" id="LvlApproverOkbj">

        <div class="col-md-12" style="margin-top:10px">
            <table class="table table-bordered">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center">Order Id</th>
                        <th class="text-center">Item Code</th>
                        <th class="text-center">Item Description</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">UoM</th>
                        <th class="text-center">Need By Date</th>
                        <th class="text-center">Order Purpose</th>
                        <th class="text-center">Note To Pengelola</th>
                        <th class="text-center">Urgent Reason</th>
                        <th class="text-center">Note to Buyer</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Judgement</th>
                    </tr>
                </thead>
                <tbody>
                ' . $tbody . '
                </tbody>
            </table>
        </div>
        <div class="col-md-12" style="margin-top:10px;text-align:right">
            <div class="col-md-10" id="LoadingOkbj" style="text-align:right"></div>
            <div class="col-md-1"><a class="btn btn-success" onclick ="UpdateApprExcelOKBJ()">Update Approval</a></div>
        </div>
        ';
        if ($katakunci[0] != 'OKEBAJAQUICKYOSYOSYOS' || $tbody == "") {
            if ($tbody == "") {
                $error = '
                <div class="col=md-12" style="text-align:center"><b>Data sudah di Update</b></div>
                ';
            } else {
                $error = '
                <div class="col=md-12" style="text-align:center"><b>File Tidak dapat di Proses</b></div>
                ';
            }
            echo $error;
        } else {
            echo $table;
        }
    }
    public function UpdateApproval()
    {

        $orderid = $_POST['order_id'];
        $creator = $_POST['creator'];
        $requester = $_POST['requester'];
        $approver = $_POST['approver'];
        $lvl_approver = $_POST['level'];
        $judgement = $_POST['judgement'];
        $note = "";
        $person = $this->M_import->getDataperson($approver);
        $person_id = $person[0]['PERSON_ID'];
        $emailBatch = array();
        $emailBackRequester = array();
        $emailBackRequesterR = array();

        for ($i = 0; $i < sizeof($orderid); $i++) {
            $orderStatus = $this->M_approver->checkFinishOrder($orderid[$i]);
            $this->M_import->UpdateApproval($judgement[$i], $orderid[$i], $lvl_approver);

            if ($judgement[$i] == 'A') {
                $order = $this->M_approver->getOrderToApprove1($orderid[$i]);
                $getNextApproval = $this->M_approver->getNextApproval($orderid[$i]);
                if ($person_id == $orderStatus[0]['APPROVER_ID']) {
                    $stat = 1;
                } else {
                    if (!isset($emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']])) {
                        $emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']] = array();
                    }
                    array_push($emailBatch[$getNextApproval[0]['NATIONAL_IDENTIFIER']], $order[0]);
                    $stat = 0;
                }
                if (!isset($emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']])) {
                    $emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']] = array();
                }

                array_push($emailBackRequester[$order[0]['NATIONAL_IDENTIFIER']], $order[0]);
            } else {
                $order = $this->M_approver->getOrderToApprove1($orderid[$i]);

                if (!isset($emailBackRequesterR[$order[0]['NATIONAL_IDENTIFIER']])) {
                    $emailBackRequesterR[$order[0]['NATIONAL_IDENTIFIER']] = array();
                }

                array_push($emailBackRequesterR[$order[0]['NATIONAL_IDENTIFIER']], $order[0]);
            }
        }

        // echo "<pre>";
        // print_r($emailBackRequester);
        // exit();
        if ($stat == 0) {
            foreach ($emailBatch as $key => $pesan) {
                $noindemail = $key;
                $normal = array();
                $urgent = array();
                $susulan = array();

                $nApprover = $this->M_requisition->getNamaUser($key);
                $namaApprover = $nApprover[0]['nama'];

                $encrypt = $this->encrypt->encode($key);
                $encrypt = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypt);

                $link = "<a href='" . base_url("OrderKebutuhanBarangDanJasa/directEmail/$encrypt/") . "'>Disini</a>";

                if ($nApprover[0]['jenkel'][0] == 'L') {
                    $jklApprover = 'Bapak ';
                } else {
                    $jklApprover = 'Ibu ';
                };

                $cond = "WHERE ppf.NATIONAL_IDENTIFIER = '$key'";

                $getNoindFromOracle = $this->M_requisition->getNoind($cond);

                $allOrder = $this->M_approver->getListDataOrder();

                foreach ($allOrder as $key => $order) {
                    $checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
                    if (isset($checkOrder[0])) {
                        if ($checkOrder[0]['APPROVER_ID'] == $getNoindFromOracle[0]['PERSON_ID']) {
                            $orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
                            if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
                                if ($orderSiapTampil[0]['URGENT_FLAG'] == 'N' && $orderSiapTampil[0]['IS_SUSULAN'] == 'N') {
                                    array_push($normal, $orderSiapTampil[0]);
                                } elseif ($orderSiapTampil[0]['URGENT_FLAG'] == 'Y' && $orderSiapTampil[0]['IS_SUSULAN'] == 'N') {
                                    array_push($urgent, $orderSiapTampil[0]);
                                } elseif ($orderSiapTampil[0]['IS_SUSULAN'] == 'Y') {
                                    array_push($susulan, $orderSiapTampil[0]);
                                }
                            }
                        }
                    }
                }

                $create = $pesan[0]['NATIONAL_IDENTIFIER'];
                // $getNoindFromOracle = $this->M_requisition->getNoind($create);
                $nCreator = $this->M_requisition->getNamaUser($create);
                $namaCreator = $nCreator[0]['nama'];

                if ($nCreator[0]['jenkel'][0] == 'L') {
                    $jklCreator = 'Bapak ';
                } else {
                    $jklCreator = 'Ibu ';
                };

                $subject = '[PRE-LAUNCH]Persetujuan Order Kebutuhan Barang Dan jasa';
                $body = "<b>Yth. $jklApprover $namaApprover</b>,<br><br>";
                $body .= "$jklCreator $namaCreator meminta approval Anda terkait order barang-barang berikut : <br><br>";
                $body .= "	<table border='1' style=' border-collapse: collapse;'>
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Deskripsi Barang</th>
                                    <th>Quantity</th>
                                    <th>UOM</th>
                                    <th>Status Order</th>
                                    <th>Alasan Pengadaan</th>
                                    <th>Alasan Urgensi</th>
                                </tr>
                            </thead>
                            <tbody>";
                for ($i = 0; $i < count($pesan); $i++) {
                    if ($pesan[$i]['URGENT_FLAG'] == 'Y' && $pesan[$i]['IS_SUSULAN'] == 'N') {
                        $statusOrder = 'Urgent';
                        $bgColor = '#d73925';
                    } else if ($pesan[$i]['URGENT_FLAG'] == 'N' && $pesan[$i]['IS_SUSULAN'] == 'N') {
                        $statusOrder = 'Reguler';
                        $bgColor = '#009551';
                    } elseif ($pesan[$i]['IS_SUSULAN'] == 'Y') {
                        $statusOrder = 'Emergency';
                        $bgColor = '#da8c10';
                    }

                    if ($pesan[$i]['URGENT_REASON'] == '') {
                        $urgentReason = '-';
                    } else {
                        $urgentReason = $pesan[$i]['URGENT_REASON'];
                    }

                    $emailSendDate = date("d-M-Y");
                    $pukul = date("h:i:sa");

                    $itemDanDeskripsi = $pesan[$i]['SEGMENT1'] . ' - ' . $pesan[$i]['DESCRIPTION'];
                    $kodeBarang = $itemDanDeskripsi;
                    $deskripsi = $pesan[$i]['ITEM_DESCRIPTION'];
                    $qty = $pesan[$i]['QUANTITY'];
                    $uom = $pesan[$i]['UOM'];
                    $alasanPengadaan = $pesan[$i]['ORDER_PURPOSE'];

                    $body .= "<tr>
                                        <td>$kodeBarang</td>
                                        <td>$deskripsi</td>
                                        <td>$qty</td>
                                        <td>$uom</td>
                                        <td style='background-color:$bgColor;'>$statusOrder</td>
                                        <td>$alasanPengadaan</td>
                                        <td>$urgentReason</td>
                                    </tr>";
                }
                $body .= "</body>";
                $body .= "</table> <br><br>";
                $body .= "<b>INFO :</b><br>";
                $body .= "Terdapat <b>" . count($normal) . " order reguler, " . count($susulan) . " order susulan, dan " . count($urgent) . " order urgent</b> menunggu keputusan Anda!<br>";
                $body .= "Apabila Anda ingin mengambil tindakan terhadap Order tersebut, Anda dapat klik link <b>$link</b> <br><br>";
                $body .= "Demikian yang dapat kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih. <br><br>";
                $body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
                $body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";


                $this->EmailAlert($noindemail, $subject, $body);
            }
        }

        foreach ($emailBackRequester as $key => $pesanRequester) {
            $noindemail = $key;
            $nRequester = $this->M_requisition->getNamaUser($key);
            $namaRequester = $nRequester[0]['nama'];

            if ($nRequester[0]['jenkel'][0] == 'L') {
                $jklRequester = 'Bapak ';
            } else {
                $jklRequester = 'Ibu ';
            };

            $nApprover = $this->M_requisition->getNamaUser($approver);
            $namaApprover = $nApprover[0]['nama'];

            if ($nApprover[0]['jenkel'][0] == 'L') {
                $jklApprover = 'Bapak ';
            } else {
                $jklApprover = 'Ibu ';
            };

            $subject = '[PRE-LAUNCH] Order Disetujui';
            $body = "<b>Yth. $jklRequester $namaRequester</b>,<br><br>";
            $body .= "Order anda terkait barang - barang berikut :<br><br>";
            $body .= "<table border='1' style=' border-collapse: collapse;'>
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Kode Barang</th>
                                    <th>Deskripsi Barang</th>
                                    <th>Quantity</th>
                                    <th>UOM</th>
                                    <th>Status Order</th>
                                    <th>Alasan Pengadaan</th>
                                    <th>Alasan Urgensi</th>
                                </tr>
                            </thead>
                            <tbody>";
            for ($i = 0; $i < count($pesanRequester); $i++) {
                if ($pesanRequester[$i]['URGENT_FLAG'] == 'Y' && $pesanRequester[$i]['IS_SUSULAN'] == 'N') {
                    $statusOrder = 'Urgent';
                    $bgColor = '#d73925';
                } else if ($pesanRequester[$i]['URGENT_FLAG'] == 'N' && $pesanRequester[$i]['IS_SUSULAN'] == 'N') {
                    $statusOrder = 'Reguler';
                    $bgColor = '#009551';
                } elseif ($pesanRequester[$i]['IS_SUSULAN'] == 'Y') {
                    $statusOrder = 'Emergency';
                    $bgColor = '#da8c10';
                }

                if ($pesanRequester[$i]['URGENT_REASON'] == '') {
                    $urgentReason = '-';
                } else {
                    $urgentReason = $pesanRequester[$i]['URGENT_REASON'];
                }

                $emailSendDate = date("d-M-Y");
                $pukul = date("h:i:sa");

                $orderId = $pesanRequester[$i]['ORDER_ID'];
                $itemDanDeskripsi = $pesanRequester[$i]['SEGMENT1'] . ' - ' . $pesanRequester[$i]['DESCRIPTION'];
                $kodeBarang = $itemDanDeskripsi;
                $deskripsi = $pesanRequester[$i]['ITEM_DESCRIPTION'];
                $qty = $pesanRequester[$i]['QUANTITY'];
                $uom = $pesanRequester[$i]['UOM'];
                $alasanPengadaan = $pesanRequester[$i]['ORDER_PURPOSE'];

                $body .= "<tr>
                                                <td>$orderId</td>
                                                <td>$kodeBarang</td>
                                                <td>$deskripsi</td>
                                                <td>$qty</td>
                                                <td>$uom</td>
                                                <td style='background-color:$bgColor;'>$statusOrder</td>
                                                <td>$alasanPengadaan</td>
                                                <td>$urgentReason</td>
                                            </tr>";
            }
            $body .= "</body>";
            $body .= "</table> <br><br>";
            $body .= "Telah Disetujui oleh $jklApprover $namaApprover <br><br>";

            $body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
            $body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";

            if ($namaApprover != $namaRequester) {
                $this->EmailAlert($noindemail, $subject, $body);
            }
        }
        foreach ($emailBackRequesterR as $key => $pesanRequester) {
            $noindemail = $key;
            $nRequester = $this->M_requisition->getNamaUser($key);
            $namaRequester = $nRequester[0]['nama'];

            if ($nRequester[0]['jenkel'][0] == 'L') {
                $jklRequester = 'Bapak ';
            } else {
                $jklRequester = 'Ibu ';
            };

            $nApprover = $this->M_requisition->getNamaUser($approver);
            $namaApprover = $nApprover[0]['nama'];

            if ($nApprover[0]['jenkel'][0] == 'L') {
                $jklApprover = 'Bapak ';
            } else {
                $jklApprover = 'Ibu ';
            };

            $subject = '[PRE-LAUNCH] Order Ditolak';
            $body = "<b>Yth. $jklRequester $namaRequester</b>,<br><br>";
            $body .= "Order anda terkait barang - barang berikut :<br><br>";
            $body .= "<table border='1' style=' border-collapse: collapse;'>
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Deskripsi Barang</th>
                                    <th>Quantity</th>
                                    <th>UOM</th>
                                    <th>Status Order</th>
                                    <th>Alasan Pengadaan</th>
                                    <th>Alasan Urgensi</th>
                                </tr>
                            </thead>
                            <tbody>";
            for ($i = 0; $i < count($pesanRequester); $i++) {
                if ($pesanRequester[$i]['URGENT_FLAG'] == 'Y' && $pesanRequester[$i]['IS_SUSULAN'] == 'N') {
                    $statusOrder = 'Urgent';
                    $bgColor = '#d73925';
                } else if ($pesanRequester[$i]['URGENT_FLAG'] == 'N' && $pesanRequester[$i]['IS_SUSULAN'] == 'N') {
                    $statusOrder = 'Reguler';
                    $bgColor = '#009551';
                } elseif ($pesanRequester[$i]['IS_SUSULAN'] == 'Y') {
                    $statusOrder = 'Emergency';
                    $bgColor = '#da8c10';
                }

                if ($pesanRequester[$i]['URGENT_REASON'] == '') {
                    $urgentReason = '-';
                } else {
                    $urgentReason = $pesanRequester[$i]['URGENT_REASON'];
                }

                $emailSendDate = date("d-M-Y");
                $pukul = date("h:i:sa");

                $itemDanDeskripsi = $pesanRequester[$i]['SEGMENT1'] . ' - ' . $pesanRequester[$i]['DESCRIPTION'];
                $kodeBarang = $itemDanDeskripsi;
                $deskripsi = $pesanRequester[$i]['ITEM_DESCRIPTION'];
                $qty = $pesanRequester[$i]['QUANTITY'];
                $uom = $pesanRequester[$i]['UOM'];
                $alasanPengadaan = $pesanRequester[$i]['ORDER_PURPOSE'];

                $body .= "<tr>
                                                <td>$kodeBarang</td>
                                                <td>$deskripsi</td>
                                                <td>$qty</td>
                                                <td>$uom</td>
                                                <td style='background-color:$bgColor;'>$statusOrder</td>
                                                <td>$alasanPengadaan</td>
                                                <td>$urgentReason</td>
                                            </tr>";
            }
            $body .= "</body>";
            $body .= "</table> <br><br>";
            $body .= "Tidak Disetujui oleh $jklApprover $namaApprover dengan alasan : <b>$note</b><br><br>";

            $body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
            $body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";


            $this->EmailAlert($noindemail, $subject, $body);
        }
    }
    public function EmailAlert($noind, $subject, $body)
    {
        //email
        $getEmail = $this->M_approver->getEmail($noind);
        // echo 
        // $emailUser = 'rizki_violin_radhiyan@quick.com';

        //send Email

        if ($getEmail) {
            $emailUser = $getEmail[0]['EMAIL_INTERNAL'];
            $this->load->library('PHPMailerAutoload');
            $mail = new PHPMailer();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';

            // set smtp
            $mail->isSMTP();
            $mail->Host = 'm.quick.com';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Username = 'no-reply';
            $mail->Password = '123456';
            $mail->WordWrap = 50;

            // set email content
            $mail->setFrom('no-reply@quick.com', 'ERP OKEBAJA');
            $mail->addAddress($emailUser);
            $mail->Subject = $subject;
            $mail->msgHTML($body);


            if (!$mail->send()) {
                // echo "Mailer Error: " . $mail->ErrorInfo;
                exit();
            } else {
                // echo "Message sent!";
            }
        }
    }
}
