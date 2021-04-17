<?php
defined('BASEPATH') or die('No direct script access allowed');

class C_Approve extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Index', 'index');
        $this->load->model('SystemAdministration/MainMenu/M_user', 'user');
        $this->load->library('../controllers/PerhitunganHargaSparepart/_modules/C_UserData', null, 'user_data');
        $this->load->model('PerhitunganHargaSparepart/M_calculate_spt', 'calculate_spt');
        $this->user_data->checkLoginSession();
    }

    public function index()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Approve';
        $view_data->SubMenuOne = '';

        $view_data->approvemkt_rows = $this->calculate_spt->selectApprove1();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/Marketing/V_ApproveMkt', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function ShowModalAprop()
    {
        $id = $_POST['i'];

        $piea = $this->calculate_spt->select_piea_user();

        // echo "<pre>";
        // print_r($piea);
        // exit();

        $opt = '';
        for ($i = 0; $i < sizeof($piea); $i++) {
            $opt .= '<option value="' . $piea[$i]['user_name'] . '">' . $piea[$i]['user_name'] . ' - ' . $piea[$i]['employee_name'] . '</option>';
        }

        $input = '
        <div class="panel-body">
            <input type="hidden" id="or_id" value="' . $id . '"/>
            <div class="col-md-4" style="text-align:right"><label>Approver</label></div>
            <div class="col-md-4">
                <select style="width:100%" class="form-control piea_user" id="piea_user" data-placeholder="Select PIEA Approver">
                    <option></option>
                    ' . $opt . '
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-success" onclick="ApprMktToPIEA()">Approve</button>
            </div>
        </div>
        ';
        echo $input;
    }
    public function ApprMktToPIEA()
    {
        $order_id = $_POST['i'];
        // $piea_approver = $_POST['piea_approver'];
        $induk = $this->session->user;

        for ($i = 0; $i < sizeof($order_id); $i++) {
            $this->calculate_spt->UpdateApprovalMkt($order_id[$i], $induk);
            $this->calculate_spt->UpdateApprovalMktOrder($order_id[$i]);
        }

        // $this->calculate_spt->UpdateApprovaltoPIEA($order_id, $piea_approver);
    }
    public function RejectMkt()
    {
        $order_id = $_POST['id'];
        $alasan = $_POST['alasan'];

        $induk = $this->session->user;

        for ($i = 0; $i < sizeof($order_id); $i++) {
            $this->calculate_spt->UpdateRejectMkt($order_id[$i], $induk, $alasan);
            $this->calculate_spt->UpdateRejectOrder($order_id[$i]);
        }
    }
    public function ApprovedListMkt()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Approved';
        $view_data->SubMenuOne = '';

        $view_data->approvedmkt_rows = $this->calculate_spt->selectApprovedMkt();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/Marketing/V_ListApprovedMkt', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function RejectedListMkt()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Approved';
        $view_data->SubMenuOne = '';

        $view_data->Rejectedmkt_rows = $this->calculate_spt->selectRejectedMkt();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/Marketing/V_ListRejectedMkt', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function PendingPIEA()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Approved';
        $view_data->SubMenuOne = '';

        $view_data->PendingPIEA_rows = $this->calculate_spt->PendingPIEA();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/Marketing/V_ListpendingPIEA', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function PendingAccountancy()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Approved';
        $view_data->SubMenuOne = '';

        $view_data->PendingAccountancy_rows = $this->calculate_spt->PendingAccountancy();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/Marketing/V_ListPendingAccountancy', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
}
