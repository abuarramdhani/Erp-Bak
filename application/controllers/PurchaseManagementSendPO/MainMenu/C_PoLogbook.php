<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_PoLogbook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_logged) { } else {
            redirect();
        }

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model("PurchaseManagementSendPO/MainMenu/M_polog");
        $this->load->model('PurchaseManagementSendPO/MainMenu/M_pologbook');
    }

    public function index()
    {
        $user_id = $this->session->userid;

        $data['Menu'] = 'PO Logbook';
        $data['SubMenuOne'] = '';

        $data['UserMenu']       = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $BuyerNik = $this->session->user;
        $data['PoLogbook'] = $this->M_pologbook->getDataPObyNik($BuyerNik);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PurchaseManagementSendPO/MainMenu/V_PoLogbook', $data);
        $this->load->view('V_Footer', $data);
    }

    public function edit()
    {
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Edit PO Not Confirmed';
        $data['SubMenuOne'] = '';

        $data['UserMenu']       = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        if (!isset($_GET['po_number'])) {
            redirect('PurchaseManagementSendPO/POLogbook');
        }
        $data['po_number'] = $_GET['po_number'];
        $data['edit_Po'] = $this->M_pologbook->get_data_byid($data['po_number']);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PurchaseManagementSendPO/MainMenu/V_EditPoLogbook', $data);
        $this->load->view('V_Footer', $data);
    }

    public function save()
    {
        $po_number = $this->input->post('po_number');
        $vendor_confirm_date = $this->input->post('vendor_confirm_date');
        $distribution_method = $this->input->post('distribution_method');
        $vendor_confirm_method = $this->input->post('vendor_confirm_method');
        $vendor_confirm_pic = htmlspecialchars($this->input->post('vendor_confirm_pic'));
        $attachment_flag = $this->input->post('attachment_flag');

        $edit_Po = $this->M_pologbook->get_data_byid($po_number);
        if ($edit_Po['SELISIH_WAKTU_2'] > 24 && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL) {
            $name = $_FILES["lampiran_po"]["name"];
            $ext = end((explode(".", $name)));
    
            if ($ext != 'pdf') {
                $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json')
                    ->set_output(json_encode("File yang anda masukkan bukan PDF"));
            }
            
            $config['upload_path']          = './assets/upload/PurchaseManagementSendPO/LampiranPO';
            $config['allowed_types']        = 'pdf|jpeg|jpg|png|xls|xlsx|ods|odt|txt|doc|docx';
            $config['overwrite']            = TRUE;
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('lampiran_po')) {
                $error = array('error' => $this->upload->display_errors());
    
                print_r($error);
            } else {
                $file = array('upload_data' => $this->upload->data());
                $nama_lampiran = $file['upload_data']['raw_name'];
            }
            $this->M_pologbook->updateVendorData($po_number, $vendor_confirm_date, $distribution_method, $vendor_confirm_method, $vendor_confirm_pic, $attachment_flag, $nama_lampiran);
            $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode("File benar pdf"));
        } else {
            $this->M_pologbook->updateVendorData2($po_number, $distribution_method, $attachment_flag);
            $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode("Data berhasil diupdate"));
        }
    }
}