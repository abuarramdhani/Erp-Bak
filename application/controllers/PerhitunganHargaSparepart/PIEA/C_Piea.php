<?php
defined('BASEPATH') or die('No direct script access allowed');

class C_Piea extends CI_Controller
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

    public function ReqApprove()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Selesai';
        $view_data->SubMenuOne = '';

        $view_data->approvepiea_rows = $this->calculate_spt->selectApprove2();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/PIEA/V_Approvepiea', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function ApprovePIEA()
    {
        $id = $_POST['i'];
        $master_item = $_POST['master_item'];
        $bom = $_POST['bom'];
        $routing = $_POST['routing'];
        $induk = $this->session->user;

        $this->calculate_spt->UpdateApprovalPIEA($id, $induk);
        $this->calculate_spt->UpdateApprovalPIEAOrder($id, $master_item, $bom, $routing);
    }
    public function Rejected()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Reject PIEA';
        $view_data->SubMenuOne = '';

        $view_data->rejectpiea_rows = $this->calculate_spt->RejectPIEA();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/PIEA/V_Rejectpiea', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function RejectPIEA()
    {
        $order_id = $_POST['id'];
        $alasan = $_POST['alasan'];

        $induk = $this->session->user;
        $this->calculate_spt->UpdateRejectPIEA($order_id, $induk, $alasan);
        $this->calculate_spt->UpdateRejectOrder($order_id);
    }
    public function Approved()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Approved PIEA';
        $view_data->SubMenuOne = '';

        $view_data->Approvedpiea_rows = $this->calculate_spt->ApprovedPIEA();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/PIEA/V_Approvedpiea', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
}
