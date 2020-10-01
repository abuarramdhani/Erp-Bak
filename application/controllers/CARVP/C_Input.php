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


        $file_data  = array();
        // load excel
        $file = $_FILES['excel_file']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
        $k = 0;
        foreach ($sheets as $row) {
            if ($k != 0 && $k != 1) {
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
        }

        // echo "<pre>";
        // print_r($array_import);
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
        $created_date = date('Y-m-d H:i:s');
        $created_by = $this->session->user;

        $date_to_input = strtoupper(date('d-M-Y H:i:s'));

        // echo "<pre>";
        // print_r($created_date);
        // exit();

        for ($u = 0; $u < sizeof($supplier); $u++) {

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
            $this->M_car->InsertDataCAR($id, $supplier[$u], $po[$u], $line[$u], $item_code[$u], $item_desc[$u], $uom[$u], $qty_po[$u], $received_date_po[$u], $shipment_date[$u], $lppb[$u], $act_receipt_date[$u], $qty_receipt[$u], $notes[$u], $detail_rootcause[$u], $rootcause_category[$u], $car_type[$u], $nc_scope[$u], $created_by, $created_date, $no_car);
        }


        redirect('CARVP/Input');
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
}
