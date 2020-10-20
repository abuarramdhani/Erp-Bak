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
        $vendor_confirm_note = htmlspecialchars($this->input->post('vendor_confirm_note'));
        $attachment_flag = $this->input->post('attachment_flag');

        $edit_Po = $this->M_pologbook->get_data_byid($po_number);
        if ($edit_Po['SELISIH_WAKTU_1'] > 48 && $edit_Po['SEND_DATE_2'] == NULL && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL OR $edit_Po['SELISIH_WAKTU_2'] > 24 && $edit_Po['VENDOR_CONFIRM_DATE'] == NULL) {
            $name = $_FILES["lampiran_po"]["name"];
            $ext = end((explode(".", $name)));
            
            if (!($ext == 'pdf' OR $ext == 'jpeg' OR $ext == 'jpg' OR $ext == 'png' OR $ext == 'xls' OR $ext == 'xlsx' OR $ext == 'ods' OR $ext == 'odt' OR $ext == 'txt' OR $ext == 'doc' OR $ext == 'docx')) {
                $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json')
                    ->set_output(json_encode("File yang anda masukkan salah"));
            } else {
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
                $this->M_pologbook->updateVendorData($po_number, $vendor_confirm_date, $distribution_method, $vendor_confirm_method, $vendor_confirm_pic, $vendor_confirm_note, $attachment_flag, $nama_lampiran);
                $this->output
                        ->set_status_header(200)
                        ->set_content_type('application/json')
                        ->set_output(json_encode("Data berhasil diupdate"));
            }
        } else {
            $this->M_pologbook->updateVendorData2($po_number, $distribution_method, $attachment_flag);
            $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode("Data berhasil diupdate"));
        }
    }
    
    public function exportExcel()
    {
        $this->load->library('Excel');

        $BuyerNik = $this->session->user;
        $BuyerName = $this->session->employee;
        $data = $this->M_pologbook->getDataPObyNik($BuyerNik);

        $php_excel = new PHPExcel();

        $php_excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $php_excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $php_excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
        $php_excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $php_excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(13.5);
        $php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(16);
        $php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(13.5);
        $php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(21.5);
        $php_excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $php_excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $php_excel->getActiveSheet()->getColumnDimension('N')->setWidth(13.5);
        $php_excel->getActiveSheet()->getColumnDimension('O')->setWidth(17);
        $php_excel->getActiveSheet()->getColumnDimension('P')->setWidth(13.5);
        $php_excel->getActiveSheet()->getColumnDimension('Q')->setWidth(17);
        $php_excel->getActiveSheet()->getColumnDimension('R')->setWidth(22);
        $php_excel->getActiveSheet()->getColumnDimension('S')->setWidth(24);
        $php_excel->getActiveSheet()->getColumnDimension('T')->setWidth(22);
        $php_excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $php_excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);

        $active_sheet = $php_excel->getActiveSheet();
        $active_sheet->getStyle('A1')->getFont()->setSize(14);
        $active_sheet->getStyle('A1:V3')->getFont()->setBold(true);
        $active_sheet->getStyle('L4:M4')->getFont()->setBold(true);
        $active_sheet->getStyle('A1:V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $active_sheet->getStyle('L4:M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $active_sheet->getStyle('A1:V3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $active_sheet->getStyle('L4:M4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $active_sheet
            ->mergeCells('A1:V1')
            ->mergeCells('A3:A4')
            ->mergeCells('B3:B4')
            ->mergeCells('C3:C4')
            ->mergeCells('D3:D4')
            ->mergeCells('E3:E4')
            ->mergeCells('F3:F4')
            ->mergeCells('G3:G4')
            ->mergeCells('H3:H4')
            ->mergeCells('I3:I4')
            ->mergeCells('J3:J4')
            ->mergeCells('K3:K4')
            ->mergeCells('L3:M3')
            ->mergeCells('N3:N4')
            ->mergeCells('O3:O4')
            ->mergeCells('P3:P4')
            ->mergeCells('Q3:Q4')
            ->mergeCells('R3:R4')
            ->mergeCells('S3:S4')
            ->mergeCells('T3:T4')
            ->mergeCells('U3:U4')
            ->mergeCells('V3:V4');

        $active_sheet
            ->setCellValue('A1', 'DATA PO LOGBOOK'.' - '.ucwords($BuyerName))
            ->setCellValue('A3', 'No')
            ->setCellValue('B3', 'Input Date')
            ->setCellValue('C3', 'Employee')
            ->setCellValue('D3', 'PO Number')
            ->setCellValue('E3', 'Vendor Name')
            ->setCellValue('F3', 'Buyer Name')
            ->setCellValue('G3', 'Buyer NIK')
            ->setCellValue('H3', 'PO Revision')
            ->setCellValue('I3', 'Attachment Flag')
            ->setCellValue('J3', 'PO Print Date')
            ->setCellValue('K3', 'Distribution Method')
            ->setCellValue('L3', 'Approve Date')
            ->setCellValue('L4', 'Purchasing Approve Date')
            ->setCellValue('M4', 'Management Approve Date')
            ->setCellValue('N3', 'Send Date 1')
            ->setCellValue('O3', 'Delivery Status 1')
            ->setCellValue('P3', 'Send Date 2')
            ->setCellValue('Q3', 'Delivery Status 2')
            ->setCellValue('R3', 'Vendor Confirm Date')
            ->setCellValue('S3', 'Vendor Confirm Method')
            ->setCellValue('T3', 'Vendor Confirm PIC')
            ->setCellValue('U3', 'Vendor Confirm Note')
            ->setCellValue('V3', 'Attachment');

        foreach ($data as $key => $val) {
            $row = $key+5;
            $active_sheet
                ->setCellValue("A{$row}", $key+1)
                ->setCellValue("B{$row}", $val['INPUT_DATE'])
                ->setCellValue("C{$row}", $val['EMPLOYEE'])
                ->setCellValue("D{$row}", $val['PO_NUMBER'])
                ->setCellValue("E{$row}", $val['VENDOR_NAME'])
                ->setCellValue("F{$row}", $val['BUYER_NAME'])
                ->setCellValue("G{$row}", $val['BUYER_NIK'])
                ->setCellValue("H{$row}", $val['PO_REVISION'])
                ->setCellValue("I{$row}", $val['ATTACHMENT_FLAG'])
                ->setCellValue("J{$row}", $val['PO_PRINT_DATE'])
                ->setCellValue("K{$row}", $val['DISTRIBUTION_METHOD'])
                ->setCellValue("L{$row}", $val['PURCHASING_APPROVE_DATE'])
                ->setCellValue("M{$row}", $val['MANAGEMENT_APPROVE_DATE'])
                ->setCellValue("N{$row}", $val['SEND_DATE_1'])
                ->setCellValue("O{$row}", $val['DELIVERY_STATUS_1'])
                ->setCellValue("P{$row}", $val['SEND_DATE_2'])
                ->setCellValue("Q{$row}", $val['DELIVERY_STATUS_2'])
                ->setCellValue("R{$row}", $val['VENDOR_CONFIRM_DATE'])
                ->setCellValue("S{$row}", $val['VENDOR_CONFIRM_METHOD'])
                ->setCellValue("T{$row}", $val['VENDOR_CONFIRM_PIC'])
                ->setCellValue("U{$row}", $val['VENDOR_CONFIRM_NOTE'])
                ->setCellValue("V{$row}", $val['ATTACHMENT']);
        }

            $excel_writer = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Cache-Control: post-check=0, pre-check=0', false);
            header('Pragma: no-cache');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Data PO Logbook.xlsx"');
            $excel_writer->save('php://output');
    }
}