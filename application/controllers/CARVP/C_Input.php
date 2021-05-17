<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Input extends CI_Controller
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
        $this->load->model('CARVP/M_car');

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

        $data['Title'] = 'Input Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CARVP/V_Input');
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }

    public function ImportFile()
    {

        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Preview Hasil Import';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';

        $datesource = $_POST['date_of_data_source'];

        // load excel
        $file = $_FILES['excel_file']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
        $k = 0;
        foreach ($sheets as $row) {
            if ($k != 0) {
                $supplier[] = $row['A'];
                $po[] = $row['B'];
                $line[] = $row['C'];
                $item_code[] = $row['D'];
                $item_desc[] = $row['E'];
                $uom[] = $row['F'];
                $qty_po[] = $row['G'];
                $received_date_po[] = $row['H'];
                $shipment_date[] = $row['I'];
                $lppb[] = $row['J'];
                $act_receipt_date[] = $row['K'];
                $qty_receipt[] = $row['L'];
                $notes[] = $row['M'];
                $detail_rootcause[] = $row['N'];
                $rootcause_category[] = $row['O'];
                $car_type[] = $row['P'];
                $nc_scope[] = $row['Q'];
            }
            $k++;
        }

        for ($u = 0; $u < sizeof($supplier); $u++) {
            $array_import[$u]['supplier'] = $supplier[$u];
            $array_import[$u]['po'] = $po[$u];
            $array_import[$u]['line'] = $line[$u];
            $array_import[$u]['item_code'] = $item_code[$u];
            $array_import[$u]['item_desc'] = $item_desc[$u];
            $array_import[$u]['uom'] = $uom[$u];
            $array_import[$u]['qty_po'] = $qty_po[$u];
            $array_import[$u]['received_date_po'] = $received_date_po[$u];
            $array_import[$u]['shipment_date'] = $shipment_date[$u];
            $array_import[$u]['lppb'] = $lppb[$u];
            $array_import[$u]['act_receipt_date'] = $act_receipt_date[$u];
            $array_import[$u]['qty_receipt'] = $qty_receipt[$u];
            $array_import[$u]['notes'] = $notes[$u];
            $array_import[$u]['detail_rootcause'] = $detail_rootcause[$u];
            $array_import[$u]['rootcause_category'] = $rootcause_category[$u];
            $array_import[$u]['car_type'] = $car_type[$u];
            $array_import[$u]['nc_scope'] = $nc_scope[$u];
            $array_import[$u]['date_source'] = $datesource;
        }

        // echo "<pre>";
        // print_r($received_date_po);
        // exit();

        $data['array_import'] = $array_import;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CARVP/V_Import', $data);
        $this->load->view('V_Footer', $data);
    }
    public function InsertImport()
    {
        date_default_timezone_set('Asia/Jakarta');
        $supplier = $this->input->post('car_supplier[]');
        $po = $this->input->post('car_po[]');
        $line = $this->input->post('car_line[]');
        $item_code = $this->input->post('car_item_code[]');
        $item_desc = $this->input->post('car_item_desc[]');
        $uom = $this->input->post('car_uom[]');
        $qty_po = $this->input->post('car_qty_po[]');
        $received_date_po = $this->input->post('car_received_date_po[]');
        $shipment_date = $this->input->post('car_shipment_date[]');
        $lppb = $this->input->post('car_lppb[]');
        $act_receipt_date = $this->input->post('car_act_receipt_date[]');
        $qty_receipt = $this->input->post('car_qty_receipt[]');
        $notes = $this->input->post('car_notes[]');
        $detail_rootcause = $this->input->post('car_detail_rootcause[]');
        $rootcause_category = $this->input->post('car_rootcause_category[]');
        $car_type = $this->input->post('car_car_type[]');
        $nc_scope = $this->input->post('car_nc_scope[]');
        $date_source = $this->input->post('date_source[]');

        $created_date = date('Y-m-d H:i:s');
        $created_by = $this->session->user;
        $date_to_input = strtoupper(date('d-M-Y H:i:s'));

        // echo "<pre>";
        // print_r($created_date);
        // exit();

        for ($u = 0; $u < sizeof($supplier); $u++) {
            if ($qty_po[$u] == null || $qty_po[$u] == "") {
                $qty_po[$u] = 0;
            }
            if ($qty_receipt[$u] == null || $qty_receipt[$u] == "") {
                $qty_receipt[$u] = 0;
            }
            $data_supplier = $this->M_car->pembandingToInsert($supplier[$u]);
            if (!empty($data_supplier)) {
                if ($date_to_input == $data_supplier[0]['CREATED_DATE']) {
                    $no_car = $data_supplier[0]['CAR_NUM'];
                } else {
                    $no_car = $this->no_car_generator();
                }
            } else {
                $no_car = $this->no_car_generator();
            }
            $id = $this->M_car->getIdOr();
            $this->M_car->InsertDataCAR($id, $supplier[$u], $po[$u], $line[$u], $item_code[$u], $item_desc[$u], $uom[$u], $qty_po[$u], $received_date_po[$u], $shipment_date[$u], $lppb[$u], $act_receipt_date[$u], $qty_receipt[$u], $notes[$u], $detail_rootcause[$u], $rootcause_category[$u], $car_type[$u], $nc_scope[$u], $created_by, $created_date, $no_car, $date_source[$u]);
        }


        redirect('CARVP/ListData');
    }
    public function no_car_generator()
    {
        $back = 1;
        check:
        $tahun = date('y');
        $bulan = date('m');
        $no_car = 'OT-PUR-' . $tahun . '-' . $bulan . '-' . str_pad($back, 3, "0", STR_PAD_LEFT);
        $check = $this->M_car->nocar($no_car);
        if (!empty($check)) {
            $back++;
            goto check;
        }

        return $no_car;
    }
    public function LayoutExcel()
    {
        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();
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
        $worksheet->getColumnDimension('M')->setAutoSize(true);
        $worksheet->getColumnDimension('N')->setAutoSize(true);
        $worksheet->getColumnDimension('O')->setAutoSize(true);
        $worksheet->getColumnDimension('P')->setAutoSize(true);
        $worksheet->getColumnDimension('Q')->setAutoSize(true);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "SUPPLIER NAME");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "PO NUMBER");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "LINE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "ITEM CODE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "ITEM DESCRIPTION");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "UOM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "QTY PO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "RECEIVED DATE PO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', "(contoh : 05-Oct-20)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "SHIPMENT DATE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "(contoh : 05-Oct-20)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "LPPB NUMBER");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', "ACTUAL RECEIPT DATE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', "(contoh : 05-Oct-20)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', "QTY RECEIPT");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', "NOTES");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', "DETAIL ROOTCAUSE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', "ROOTCAUSE CATEGORI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', "CAR TYPE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', "NC SCOPE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', "");

        $worksheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $worksheet->getStyle('A1')->getFont()->setSize(11);
        $worksheet->getStyle('A2')->getFont()->setSize(9);
        $worksheet->getStyle('B1')->getFont()->setSize(11);
        $worksheet->getStyle('B2')->getFont()->setSize(9);
        $worksheet->getStyle('C1')->getFont()->setSize(11);
        $worksheet->getStyle('C2')->getFont()->setSize(9);
        $worksheet->getStyle('D1')->getFont()->setSize(11);
        $worksheet->getStyle('D2')->getFont()->setSize(9);
        $worksheet->getStyle('E1')->getFont()->setSize(11);
        $worksheet->getStyle('E2')->getFont()->setSize(9);
        $worksheet->getStyle('F1')->getFont()->setSize(11);
        $worksheet->getStyle('F2')->getFont()->setSize(9);
        $worksheet->getStyle('G1')->getFont()->setSize(11);
        $worksheet->getStyle('G2')->getFont()->setSize(9);
        $worksheet->getStyle('H1')->getFont()->setSize(11);
        $worksheet->getStyle('H2')->getFont()->setSize(9);
        $worksheet->getStyle('I1')->getFont()->setSize(11);
        $worksheet->getStyle('I2')->getFont()->setSize(9);
        $worksheet->getStyle('J1')->getFont()->setSize(11);
        $worksheet->getStyle('J2')->getFont()->setSize(9);
        $worksheet->getStyle('K1')->getFont()->setSize(11);
        $worksheet->getStyle('K2')->getFont()->setSize(9);
        $worksheet->getStyle('L1')->getFont()->setSize(11);
        $worksheet->getStyle('L2')->getFont()->setSize(9);
        $worksheet->getStyle('M1')->getFont()->setSize(11);
        $worksheet->getStyle('M2')->getFont()->setSize(9);
        $worksheet->getStyle('N1')->getFont()->setSize(11);
        $worksheet->getStyle('N2')->getFont()->setSize(9);
        $worksheet->getStyle('O1')->getFont()->setSize(11);
        $worksheet->getStyle('O2')->getFont()->setSize(9);
        $worksheet->getStyle('P1')->getFont()->setSize(11);
        $worksheet->getStyle('P2')->getFont()->setSize(9);
        $worksheet->getStyle('Q1')->getFont()->setSize(11);
        $worksheet->getStyle('Q2')->getFont()->setSize(9);

        $worksheet->getStyle('A1')->getFont()->setBold(true);
        $worksheet->getStyle('B1')->getFont()->setBold(true);
        $worksheet->getStyle('C1')->getFont()->setBold(true);
        $worksheet->getStyle('D1')->getFont()->setBold(true);
        $worksheet->getStyle('E1')->getFont()->setBold(true);
        $worksheet->getStyle('F1')->getFont()->setBold(true);
        $worksheet->getStyle('G1')->getFont()->setBold(true);
        $worksheet->getStyle('H1')->getFont()->setBold(true);
        $worksheet->getStyle('I1')->getFont()->setBold(true);
        $worksheet->getStyle('J1')->getFont()->setBold(true);
        $worksheet->getStyle('K1')->getFont()->setBold(true);
        $worksheet->getStyle('L1')->getFont()->setBold(true);
        $worksheet->getStyle('M1')->getFont()->setBold(true);
        $worksheet->getStyle('N1')->getFont()->setBold(true);
        $worksheet->getStyle('O1')->getFont()->setBold(true);
        $worksheet->getStyle('P1')->getFont()->setBold(true);
        $worksheet->getStyle('Q1')->getFont()->setBold(true);



        $worksheet->getDefaultRowDimension()->setRowHeight(-1);
        $worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LayoutDataCAR.xlsx"');
        ob_end_clean();
        $objWriter->save("php://output");
    }
}
