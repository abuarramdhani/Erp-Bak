<?php
defined('BASEPATH') or die('No direct script access allowed');

class C_Accountancy extends CI_Controller
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

    public function Rejected()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Reject Akuntansi';
        $view_data->SubMenuOne = '';

        $view_data->rejectakuntansi_rows = $this->calculate_spt->RejectAKt();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/Akuntansi/V_Rejectakuntansi', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function ReqCalculation()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Approve Akuntansi';
        $view_data->SubMenuOne = '';

        $view_data->approveakuntansi_rows = $this->calculate_spt->SelectApprove3();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/Akuntansi/V_Approveakuntansi', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function ApproveAkt()
    {
        // echo "<pre>";
        // print_r($_FILES);
        // exit();
        $path = $_FILES['ref_harga']['name'];

        $filename = 'assets/upload/PerhitunganHargaSparePart/' . $path;
        $temp_name = $_FILES['ref_harga']['tmp_name'];
        if (file_exists($filename)) {
            move_uploaded_file($temp_name, $filename);
        } else {
            move_uploaded_file($temp_name, $filename);
        }
        echo json_encode($filename);
    }
    public function ApproveAkttbl()
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit();

        $path = $_POST['result'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $id = $_POST['order_id'];
        $imagePath = $path;
        $newPath = "assets/upload/PerhitunganHargaSparePart/";

        for ($g = 0; $g < sizeof($id); $g++) {
            $newName  = $newPath . 'File_Order' . $id[$g] . '.' . $ext;
            copy($imagePath, $newName);
            $induk = $this->session->user;
            $this->calculate_spt->UpdateApprAkt($id[$g], $induk);
            $this->calculate_spt->UpdateApprovalAktOrder($id[$g], $newName);
        }
        unlink($path);
    }
    public function Calculated()
    {
        $view_data = $this->user_data->getUserMenu();
        $view_data->Menu = 'Daftar Approved Akuntansi';
        $view_data->SubMenuOne = '';

        $view_data->approvedakuntansi_rows = $this->calculate_spt->SelectApprovedAkt();

        // echo "<pre>";
        // print_r($view_data);
        // exit();

        $this->load->view('V_Header', $view_data);
        $this->load->view('V_Sidemenu', $view_data);
        $this->load->view('PerhitunganHargaSparepart/Akuntansi/V_Approvedakuntansi', $view_data);
        $this->load->view('V_Footer', $view_data);
    }
    public function RejectAkt()
    {
        $order_id = $_POST['id'];
        $alasan = $_POST['alasan'];

        $induk = $this->session->user;

        $this->calculate_spt->UpdateRejectAkt($order_id, $induk, $alasan);
        $this->calculate_spt->UpdateRejectOrder($order_id);
    }
}
