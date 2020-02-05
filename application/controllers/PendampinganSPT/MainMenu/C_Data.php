<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Data extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->checkSession();
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PendampinganSPT/M_data');
    }

    private function checkSession()
    {
        if ( ! $this->session->is_logged )
            redirect();
    }

    public function index()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['BaseURL']           = base_url();
        $data['Menu']              = 'Data';
        $data['SubMenuOne']        = '';
        $data['UserMenu']          = $this->M_user->getUserMenu($user_id, $resp_id);
        $data['UserSubMenuOne']    = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']    = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['RegisteredSPTList'] = $this->M_data->selectAllRegisteredUser();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PendampinganSPT/MainMenu/V_Data', $data);
        $this->load->view('V_Footer', $data);
    }

    public function edit()
    {
        if ( ! $id = $this->input->post('data-id') ) 
            redirect('PendampinganSPT/Data');

        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['BaseURL']             = base_url();
        $data['Menu']                = 'Data';
        $data['SubMenuOne']          = '';
        $data['UserMenu']            = $this->M_user->getUserMenu($user_id, $resp_id);
        $data['UserSubMenuOne']      = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']      = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['RegisteredSPTDetail'] = array_values($this->M_data->selectRegisteredUser($id))[0];

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PendampinganSPT/MainMenu/V_Edit', $data);
        $this->load->view('V_Footer', $data);
    }

    public function saveEdit()
    {
        if ( ! $this->input->is_ajax_request() ) 
            redirect('PendampinganSPT/Data');

        $id   = $this->input->post('data-id');
        $data = array_diff_key($this->input->post(), ['data-id' => '']);

        if ( $data['jadwal'] === '' )
            $data['jadwal'] = NULL;

        if ( $data['tanggal_lapor'] === '' )
            $data['tanggal_lapor'] = NULL;

        $this->M_data->updateRegisteredUser($id, $data);

        echo json_encode('Success');
    }
    
    public function delete()
    {
        if ( ! $this->input->is_ajax_request() ) 
            redirect('PendampinganSPT/Data');

        $id = $this->input->post('data-id');

        $this->M_data->deleteRegisteredUser($id);

        echo json_encode('Success');
    }

    public function exportExcel()
    {
        $data       = $this->M_data->selectAllRegisteredUser();
        $array_key  = array_keys($data);
        $last_array = array_pop($array_key);
        $last_cell  = $last_array+4;

        $this->load->library('Excel');

        $php_excel = new PHPExcel();

        $style = [
            'border_all' => [
                'borders' => [
                    'allborders' => [ 'style' => PHPExcel_Style_Border::BORDER_THIN ] 
                ]
            ],
            'border_right' => [
                'borders' => [
                    'right' => [ 'style' => PHPExcel_Style_Border::BORDER_THIN ]
                ]
            ],
            'border_bottom' => [
                'borders' => [
                    'bottom' => [ 'style' => PHPExcel_Style_Border::BORDER_THIN ] 
                ]
            ],
            'bg_cornflower_blue' => [
                'fill' => [
                    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => [ 'rgb' => 'DDEBF7' ]
                ]
            ],
            'text_small' => [
                'font' => [
                    'bold'  => true,
                    'size'  => 1
                ]
            ]
        ];

        foreach (range('A', 'N') as $key => $val) {
            $php_excel->getActiveSheet()->getColumnDimension($val)->setAutoSize(true);
        }

        $active_sheet = $php_excel->getActiveSheet();
        $active_sheet->getStyle('A1')->getFont()->setSize(14);
        $active_sheet->getStyle('A1:N3')->getFont()->setBold(true);
        $active_sheet->getStyle('A1:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $active_sheet->getStyle('A3:N3')->applyFromArray($style['border_all']);
        $active_sheet->getStyle('J3:N3')->applyFromArray($style['bg_cornflower_blue']);
        $active_sheet->getStyle('O2')->applyFromArray($style['text_small']);
        $active_sheet->mergeCells('A1:N1');

        $active_sheet->getProtection()->setPassword('1CT_KH5');
        $active_sheet->getProtection()->setSheet(true);
        $active_sheet->getStyle("J4:N{$last_cell}")->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

        $active_sheet
            ->setCellValue('A1', 'DATA PENDAFTAR PENDAMPINGAN SURAT PAJAK TAHUNAN')
            ->setCellValue('A3', 'No')
            ->setCellValue('B3', 'Data Id')
            ->setCellValue('C3', 'Nomor Pendaftaran')
            ->setCellValue('D3', 'Lokasi Kerja')
            ->setCellValue('E3', 'Status Pekerja')
            ->setCellValue('F3', 'Nomor NPWP')
            ->setCellValue('G3', 'Nomor Induk')
            ->setCellValue('H3', 'Nama')
            ->setCellValue('I3', 'Seksi')
            ->setCellValue('J3', 'Jadwal')
            ->setCellValue('K3', 'Ruangan')
            ->setCellValue('L3', 'EFIN')
            ->setCellValue('M3', 'Email')
            ->setCellValue('N3', 'Tanggal Lapor')
            ->setCellValue('O2', '*');

        foreach ($data as $key => $val) {
            $row = $key+4;

            $active_sheet
                ->setCellValue("A{$row}", $key+1)
                ->setCellValue("B{$row}", $val['id'])
                ->setCellValue("C{$row}", $val['nomor_pendaftaran'])
                ->setCellValue("D{$row}", $val['lokasi_kerja'])
                ->setCellValue("E{$row}", $val['status_pekerja'])
                ->setCellValue("F{$row}", $val['nomor_npwp'])
                ->setCellValue("G{$row}", $val['nomor_induk'])
                ->setCellValue("H{$row}", $val['nama'])
                ->setCellValue("I{$row}", $val['seksi'])
                ->setCellValue("J{$row}", $val['jadwal'])
                ->setCellValue("K{$row}", $val['lokasi'])
                ->setCellValue("L{$row}", $val['efin'])
                ->setCellValue("M{$row}", $val['email'])
                ->setCellValue("N{$row}", $val['tanggal_lapor']);

            $active_sheet->getStyle("I{$row}")->applyFromArray($style['border_right']);
            $active_sheet->getStyle("N{$row}")->applyFromArray($style['border_right']);

            if ( $key === $last_array )
                $active_sheet->getStyle("A{$row}:N{$row}")->applyFromArray($style['border_bottom']);
        }

        $excel_writer = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data Pendaftar Pendampingan Pelaporan SPT.xlsx"');
        $excel_writer->save('php://output');
    }

    public function importExcel()
    {
        if ( ! $this->input->is_ajax_request() )
            redirect('PendampinganSPT/Data');

        $this->load->library('Excel');

        try {
            $file_data    = $_FILES['file']['tmp_name'];
            $file_name    = $_FILES['file']['name'];
            $valid_format = ['xls','xlsx','ods'];

            if ( ! in_array(pathinfo($file_name, PATHINFO_EXTENSION), $valid_format) )
                throw new Exception('wrong file format');

            $excel_reader     = PHPExcel_IOFactory::createReaderForFile($file_data);
            $php_excel        = $excel_reader->load($file_data);
            $worksheet        = $php_excel->getSheet(0);    
            $last_row         = $worksheet->getHighestRow();
            $excel_amount     = $last_row-3;
            $sheet_validation = $worksheet->getCell('O2')->getValue();

            if ( $sheet_validation !== '*' )
                throw new Exception('wrong data');

            if ( $excel_amount !== $this->M_data->countAllRegisteredUser() )
                throw new Exception('data not equal');

            for ( $i = 4; $i <= $last_row; $i++) {
                $id   = $worksheet->getCell("B{$i}")->getValue();
                $data = [
                    'jadwal'         => PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCell("J{$i}")->getValue(), 'YYYY/MM/DD'),
                    'lokasi'         => $worksheet->getCell("K{$i}")->getValue(),
                    'efin'           => $worksheet->getCell("L{$i}")->getValue(),
                    'email'          => $worksheet->getCell("M{$i}")->getValue(),
                    'tanggal_lapor'  => PHPExcel_Style_NumberFormat::toFormattedString($worksheet->getCell("N{$i}")->getValue(), 'YYYY/MM/DD')
                ];
                $this->M_data->updateRegisteredUser($id, $data);
            }
            echo json_encode('Success');
        } catch (Exception $e) {
            header('HTTP/1.1 428');            
            die(json_encode([
                'status' => 'error',
                'detail' => $e->getMessage()
            ]));
        }
    }

}