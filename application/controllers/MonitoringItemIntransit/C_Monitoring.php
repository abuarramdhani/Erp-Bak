<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monitoring extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');

        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('encrypt');



        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MonitoringItemIntransit/M_monitoring');

        $this->checkSession();
    }
    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('index');
        }
    }

    public function index()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MonitoringItemIntransit/V_Monitoring');
        $this->load->view('V_Footer', $data);
    }
    public function getIo()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        if ($term == null) {
            $param = '';
        } else {
            $param = "AND mp.organization_id like '%$term%' OR mp.organization_code like '%$term%'";
        }
        $data = $this->M_monitoring->getIo($param);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function getSubinv()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        $data = $this->M_monitoring->getSubinv($term);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function getDataItemItransit()
    {

        $io_from = $_POST['io_from'];
        $io_to = $_POST['io_to'];
        $subinv_from =  $_POST['subinv_from'];
        $subinv_to = $_POST['subinv_to'];
        $date_from =  $_POST['date_from'];
        $date_to = $_POST['date_to'];

        $io_dari = null;
        $io_ke = null;
        $subdari = null;
        $subke = null;
        $date_nya = null;

        if ($io_from != null || $io_from != "") {
            $io_dari = "AND msib.organization_id = NVL ($io_from, msib.organization_id)
             AND ms.from_organization_id = NVL ($io_from, rsh.organization_id)";
        }
        if ($subinv_from != null || $subinv_from != "") {
            $subdari = "AND NVL (ms.from_subinventory, 0) = NVL (NVL ('$subinv_from', ms.from_subinventory), 0)";
        }
        if ($io_to != null || $io_to != "") {
            $io_ke = "AND ms.to_organization_id = NVL ($io_to, rsh.ship_to_org_id)";
        }
        if ($subinv_to != null || $subinv_to != "") {
            $subke = "AND NVL (ms.to_subinventory, 0) =
            NVL (NVL ('$subinv_to', ms.to_subinventory), 0)";
        }
        $date_nya = "AND TRUNC (rsh.creation_date)
       BETWEEN NVL (to_date('$date_from','DD/MM/YYYY'),
                    (SELECT MIN (TRUNC (sh.creation_date))
                       FROM rcv_shipment_headers sh)
                   )
           AND NVL (to_date('$date_to','DD/MM/YYYY'), rsh.creation_date)";

        $item_intransit1 = $this->M_monitoring->getDataItemItransit1($io_dari, $io_ke, $subdari, $subke, $date_nya);
        $item_intransit2 = $this->M_monitoring->getDataItemItransit2($io_dari, $io_ke, $subdari, $subke, $date_nya);

        // echo "<pre>";
        // print_r($item_intransit2);
        // exit();

        $data['intransit1'] = $item_intransit1;
        $data['intransit2'] = $item_intransit2;

        $this->load->view('MonitoringItemIntransit/V_TblMonitoring', $data);
    }
    public function ReportItemIntransit()
    {
        $io_from = $_POST['io_from'];
        $io_to = $_POST['io_to'];
        $subinv_from =  $_POST['subinv_from'];
        $subinv_to = $_POST['subinv_to'];
        $date_from =  $_POST['date_from'];
        $date_to = $_POST['date_to'];

        $io_dari = null;
        $io_ke = null;
        $subdari = null;
        $subke = null;
        $date_nya = null;

        if ($io_from != null || $io_from != "") {
            $io_dari = "AND msib.organization_id = NVL ($io_from, msib.organization_id)
             AND ms.from_organization_id = NVL ($io_from, rsh.organization_id)";
        }
        if ($subinv_from != null || $subinv_from != "") {
            $subdari = "AND NVL (ms.from_subinventory, 0) = NVL (NVL ('$subinv_from', ms.from_subinventory), 0)";
        }
        if ($io_to != null || $io_to != "") {
            $io_ke = "AND ms.to_organization_id = NVL ($io_to, rsh.ship_to_org_id)";
        }
        if ($subinv_to != null || $subinv_to != "") {
            $subke = "AND NVL (ms.to_subinventory, 0) =
            NVL (NVL ('$subinv_to', ms.to_subinventory), 0)";
        }
        $date_nya = "AND TRUNC (rsh.creation_date)
       BETWEEN NVL (to_date('$date_from','DD/MM/YYYY'),
                    (SELECT MIN (TRUNC (sh.creation_date))
                       FROM rcv_shipment_headers sh)
                   )
           AND NVL (to_date('$date_to','DD/MM/YYYY'), rsh.creation_date)";

        $item_intransit1 = $this->M_monitoring->getDataItemItransit1($io_dari, $io_ke, $subdari, $subke, $date_nya);
        $item_intransit2 = $this->M_monitoring->getDataItemItransit2($io_dari, $io_ke, $subdari, $subke, $date_nya);


        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $worksheet = $objPHPExcel->getActiveSheet(0);

        $worksheet->getColumnDimension('A')->setWidth(7);
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
        $worksheet->getColumnDimension('M')->setAutoSize(true);
        $worksheet->getColumnDimension('N')->setAutoSize(true);
        $worksheet->getColumnDimension('O')->setAutoSize(true);
        $worksheet->getColumnDimension('P')->setAutoSize(true);
        $worksheet->getColumnDimension('Q')->setAutoSize(true);
        $worksheet->getColumnDimension('R')->setAutoSize(true);

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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Monitoring Item Intransit");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "Date From");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Date To");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "Tanggal Cetak");

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->mergeCells('A4:B4');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', $date_from);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', $date_to);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', $item_intransit1[0]['CREATION_DATE']);
        $objPHPExcel->getActiveSheet()->getStyle('A1:A4')->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', "No Shipment");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6', "No Receipt");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D6', "Kode Barang");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6', "Nama Barang");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F6', "Tgl Transaksi");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G6', "Jumlah Hari");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H6', "From IO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I6', "From Subinv");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J6', "From Locator");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K6', "To IO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L6', "To Subinv");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M6', "To Locator");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N6', "Qty Kirim");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O6', "Qty Terima");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P6', "Qty Intransit");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q6', "Comment");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R6', "Serial Number");

        $objPHPExcel->getActiveSheet()->getStyle('A6:R6')->getFont()->setBold(true);


        $worksheet->getStyle('A6:R6')->applyFromArray($thin);

        $row = 7;

        foreach ($item_intransit1 as $key => $item) {
            $worksheet->getStyle('A' . $row . ':R' . $row)->applyFromArray($thin);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $key + 1);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $item['SHIPMENT_NUM']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $item['RECEIPT_NUM']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $item['SEGMENT1']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $item['DESCRIPTION']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, $item['CREATION_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, $item['DAYS_COUNT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, $item['FROM_IO']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, $item['FROM_SUBINVENTORY']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row, $item['FROM_LOC']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row, $item['TO_IO']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $row, $item['TO_SUBINVENTORY']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $row, $item['TO_LOC']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $row, $item['QUANTITY_SHIPPED']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $row, $item['QUANTITY_RECEIVED']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $row, $item['QUANTITY_INTRANSIT']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $row, str_replace('#', "\n",  $item['COMMENTS']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $row, str_replace('#', " ",  $item['COMMENTS']));

            $objPHPExcel->getActiveSheet()->getStyle('Q' . $row)->getAlignment()->setWrapText(true);

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $row, $item['SERIAL_NUMBER']);

            $row++;
        }
        $row2 = $row + 1;
        $worksheet->getStyle('A' . $row2 . ':K' . $row2)->applyFromArray($thin);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row2, "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row2, "No Shipment");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row2, "Jumlah Hari");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row2, "From IO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row2, "From Subinv");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row2, "From Locator");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row2, "To IO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row2, "To Subinv");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row2, "To Locator");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row2, "Qty Intransit");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row2, "Comment");

        $objPHPExcel->getActiveSheet()->getStyle('A' . $row2 . ':R' . $row2)->getFont()->setBold(true);
        $row2++;
        foreach ($item_intransit2 as $key => $item) {
            $worksheet->getStyle('A' . $row2 . ':K' . $row2)->applyFromArray($thin);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row2, $key + 1);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row2, $item['SHIPMENT_NUM']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row2, $item['DAYS_COUNT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row2, $item['FROM_IO']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row2, $item['FROM_SUBINVENTORY']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row2, $item['FROM_LOC']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row2, $item['TO_IO']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row2, $item['TO_SUBINVENTORY']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row2, $item['TO_LOC']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row2, $item['QUANTITY_INTRANSIT']);
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row2, str_replace('#', "\n", $item['COMMENTS']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row2, str_replace('#', " ", $item['COMMENTS']));

            $row2++;
        }



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="MonitoringItemIntransit.xlsx"');
        ob_end_clean();
        $objWriter->save("php://output");
    }
}
