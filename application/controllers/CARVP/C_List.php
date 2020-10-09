<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_List extends CI_Controller
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

        $data['Title'] = 'List Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $carr = $this->M_car->Listcar();

        $w = 0;
        foreach ($carr as $supplier) {
            $detail = $this->M_car->ListbyCAR($supplier['CAR_NUM']);
            $carr[$w]['NO_CAR'] = $detail[0]['CAR_NUM'];
            $carr[$w]['SUPPLIER_NAME'] = $detail[0]['SUPPLIER_NAME'];
            $carr[$w]['APPROVE_DATE'] = $detail[0]['APPROVE_DATE'];
            if ($detail[0]['ACTIVE_FLAG'] == 'A') {
                $carr[$w]['DELIVERY_STATUS'] = 'Success';
            } else if ($detail[0]['ACTIVE_FLAG'] == 'F') {
                $carr[$w]['DELIVERY_STATUS'] = 'Failed';
            } else {
                $carr[$w]['DELIVERY_STATUS'] = '-';
            }
            $carr[$w]['ACTIVE_FLAG'] = $detail[0]['ACTIVE_FLAG'];
            $carr[$w]['APPROVE_TO'] = $detail[0]['APPROVE_TO'];
            if ($carr[$w]['ACTIVE_FLAG'] == 'A') {
                $carr[$w]['APPROVAL_STATUS'] = 'Approved';
                $carr[$w]['REJECT_REASON'] = '-';
            } else if ($carr[$w]['ACTIVE_FLAG'] == 'F') {
                $carr[$w]['APPROVAL_STATUS'] = 'Approved';
                $carr[$w]['REJECT_REASON'] = '-';
            } else if ($carr[$w]['ACTIVE_FLAG'] == 'R') {
                $carr[$w]['APPROVAL_STATUS'] = 'Rejected';
                $carr[$w]['REJECT_REASON'] = $detail[0]['REJECT_REASON'];
            } else {
                $carr[$w]['APPROVAL_STATUS'] = 'Pending';
                $carr[$w]['REJECT_REASON'] = '-';
            }


            $w++;
        }

        // echo "<pre>";
        // print_r($carr);
        // exit();

        $data['car'] = $carr;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CARVP/V_List');
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function ReqApprove()
    {
        $no_car = $this->input->post('n');
        $data['no_car'] = $no_car;
        $this->load->view('CARVP/V_GetApprover', $data);
    }
    public function getApprover()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        $data = $this->M_car->GetApprover($term);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function sendRequestAppr()
    {
        $no_car = $this->input->post('no_car');
        $approver_car = $this->input->post('approver_car');
        $this->M_car->SendReqAppr($no_car, $approver_car);

        redirect('CARVP/ListData');
    }
    public function EditCAR($car)
    {

        $user_id = $this->session->userid;

        $data['Title'] = 'Edit Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $dataToEdit = $this->M_car->dataToEdit($car);

        // echo "<pre>";
        // print_r($dataToEdit);
        // exit();

        $data['dataToEdit'] = $dataToEdit;


        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CARVP/V_EditCAR', $data);
        $this->load->view('V_Footer', $data);
    }
    function getItem()
    {

        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        $data = $this->M_car->getItem($term);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function getDescription()
    {
        $item = $this->input->post('item');
        $data = $this->M_car->getDescandUom($item);
        // echo "<pre>";print_r($data);exit();
        echo json_encode($data);
    }
    public function SaveChangesCAR()
    {
        $post = $this->input->post();

        for ($n = 0; $n < sizeof($post['car_item_code']); $n++) {
            $this->M_car->UpdateCAR($post['car_po_num'][$n], $post['car_line'][$n], $post['car_item_code'][$n], $post['car_item_desc'][$n], $post['car_uom'][$n], $post['car_qty_po'][$n], $post['car_receive_date'][$n], $post['car_ship_date'][$n], $post['car_lppb'][$n], $post['car_act_receive_date'][$n], $post['car_qty_receipt'][$n], $post['car_notes'][$n], $post['car_detail_rootcause'][$n], $post['car_rootcause_category'][$n], $post['car_id'][$n]);
        }

        redirect('CARVP/ListData');

        // echo "<pre>";
        // print_r($post);
        // exit();
    }
    public function Hapusdata()
    {
        $no_car = $this->input->post('no_car');
        $this->M_car->deleteCAR($no_car);
    }
    public function HapusItem()
    {
        $id = $this->input->post('id');
        $this->M_car->deleteItem($id);
    }
    public function createPDFCar($no_car)
    {
        ob_start();

        $list_supplier = $this->M_car->ListsupplierbyNoCAR($no_car);
        $w = 0;
        foreach ($list_supplier as $supplier) {
            $list_supplier[$w]['DETAIL'] = $this->M_car->ListbyCAR($supplier['CAR_NUM']);
            $periode = $this->M_car->getPeriode($supplier['CAR_NUM']);
            $list_supplier[$w]['PERIODE'] = $periode[0]['CREATED_DATE'];
            $po_num = $this->M_car->getPO($supplier['CAR_NUM']);
            $attendance = $this->M_car->getAttendance($po_num[0]['PO_NUMBER']);
            $list_supplier[$w]['ATTENDANCE'] = $attendance[0]['VENDOR_CONTACT'];
            $list_supplier[$w]['PO'] = $po_num;
            $list_supplier[$w]['CAR_TYPE'] = $list_supplier[$w]['DETAIL'][0]['CAR_TYPE'];
            $list_supplier[$w]['NC_SCOPE'] = $list_supplier[$w]['DETAIL'][0]['NC_SCOPE'];
            if ($list_supplier[$w]['DETAIL'][0]['APPROVE_DATE'] == null) {
                $list_supplier[$w]['APPROVER'] = null;
                $list_supplier[$w]['KET'] = null;
            } else {
                $nama = $this->M_car->getNamaApprover($list_supplier[$w]['DETAIL'][0]['APPROVE_TO']);
                $list_supplier[$w]['APPROVER'] = $nama[0]['nama'];
                $list_supplier[$w]['KET'] = 'Form ini sudah melalui Approval by sistem.';
            }

            $w++;
        }
        // echo "<pre>";
        // print_r($list_supplier);
        // exit();

        $data['car'] = $list_supplier;

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 297), 0, '', 3, 3, 30, 3, 3, 3); //----- A5-L
        $filename = 'CARVP.pdf';
        $html = $this->load->view('CARVP/V_PdfCar', $data, true);        //-----> Fungsi Cetak PDF
        $head1 = $this->load->view('CARVP/V_PdfCarHeader1', $data, true);        //-----> Fungsi Cetak PDF
        $head2 = $this->load->view('CARVP/V_PdfCarHeader2', $data, true);        //-----> Fungsi Cetak PDF
        $html2 = $this->load->view('CARVP/V_PdfCar2', $data, true);        //-----> Fungsi Cetak PDF

        ob_end_clean();
        $pdf->setHTMlHeader($head1);
        $pdf->WriteHTML($html);
        $pdf->setHTMlHeader($head2);
        $pdf->WriteHTML($html2);
        $pdf->Output($filename, 'I');
    }
    public function HapusAll()
    {
        $this->M_car->HapusAll();
    }
}
