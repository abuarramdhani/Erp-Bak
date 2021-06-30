<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class C_Cetakkategori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('file');

        $this->load->library('Log_Activity');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('upload');
        $this->load->library('general');

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MasterPekerja/CetakKategori/M_cetakkategori');

        $this->checkSession();
    }
    public function checkSession()
    {
        if ($this->session->is_logged) { } else {
            redirect('');
        }
    }

    public function cetak_kategori()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;
        $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Cetak Kategori', 'Cetak', 'Cetak Kategori', '');
        $data['Tariknoind'] = $this->M_cetakkategori->GetNoinduk();
        $data['Tarikpendidikan'] = $this->M_cetakkategori->GetPendidikan();
        $data['Tarikjenkel'] = $this->M_cetakkategori->GetJenkel();
        $data['Tariklokasi'] = $this->M_cetakkategori->GetLokasi();
        $data['Tarikstatus'] = $this->M_cetakkategori->GetStatus();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MasterPekerja/CetakKategori/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function GetKategori()
    {
        $txt = $this->input->get('term');
        $txt = strtoupper($txt);
        $txt2 = $this->input->get('term2');


        $data = $this->M_cetakkategori->GetKategori($txt, $txt2);
        echo json_encode($data);
    }

    public function GetFilter()
    {
        $kodeind = $this->input->POST('noind');
        $pend = $this->input->POST('pend');
        $jenkel = $this->input->POST('jenkel');
        $lokasi = $this->input->POST('lokasi');
        $kategori = $this->input->POST('kategori');
        $select = $this->input->POST('arrselect');
        $data['select'] = explode(';', $select);
        $rangekeluarstart = $this->input->POST('rangekeluarstart');
        $rangekeluarend = $this->input->POST('rangekeluarend');
        $rangemasukstart = $this->input->POST('rangemasukstart');
        $rangemasukend = $this->input->POST('rangemasukend');
        $status = $this->input->POST('status');
        $data['masakerja'] = "," . $this->input->POST('masakerja');
        $masakerja = $this->input->POST('masakerja');
        $this->session->set_userdata('list_filter', [$kodeind, $pend, $jenkel, $lokasi, $kategori, trim($select), $rangekeluarstart, $rangekeluarend, $rangemasukstart, $rangemasukend, $status, $masakerja]);
        $data['FilterAktif'] = $this->M_cetakkategori->GetFilter($kodeind, $pend, $jenkel,  $lokasi, $kategori, $select, $rangekeluarstart, $rangekeluarend,  $rangemasukstart, $rangemasukend, $status, $masakerja);
        $html = $this->load->view('MasterPekerja/CetakKategori/V_Table', $data);
        echo json_encode($html);
    }
    // Utilities Function Don't Call it In The Uri
    private function createColumnsArray($end_column, $first_letters = '')
    {
        $columns = array();
        $length = strlen($end_column);
        $letters = range('A', 'Z');
        foreach ($letters as $letter) {
            $column = $first_letters . $letter;
            $columns[] = $column;
            if ($column == $end_column)
                return $columns;
        }
        foreach ($columns as $column) {
            if (!in_array($end_column, $columns) && strlen($column) < $length) {
                $new_columns = $this->createColumnsArray($end_column, $column);
                $columns = array_merge($columns, $new_columns);
            }
        }
        return $columns;
    }

    private function rangeWL($length = null)
    {
        $end_column = $this->createColumnsArray('ZZ');
        return $this->createColumnsArray($end_column[$length]);
    }
    public function exportExcel()
    {
        $list_filter = $this->session->list_filter;
        set_time_limit(0);
        $kodeind = $list_filter[0];
        $pend = $list_filter[1];
        $jenkel = $list_filter[2];
        $lokasi = $list_filter[3];
        $kategori = $list_filter[4];
        $select = $list_filter[5];
        $rangekeluarstart = $list_filter[6];
        $rangekeluarend = $list_filter[7];
        $rangemasukstart = $list_filter[8];
        $rangemasukend = $list_filter[9];
        $status = $list_filter[10];
        $masakerja = $list_filter[11];
        $dataheader = explode(', ', $this->input->get('dataHeader'));
        $data = $this->M_cetakkategori->GetFilter($kodeind, $pend, $jenkel,  $lokasi, $kategori, $select, $rangekeluarstart, $rangekeluarend,  $rangemasukstart, $rangemasukend, $status, $masakerja);

        $this->load->library('excel');
        $worksheet = $this->excel->getActiveSheet();

        $worksheet->setCellValue('A2', 'DATA PEKERJA');

        if (!empty($data) && !empty($dataheader)) {
            $cell = $this->rangeWL(count($data[0]) - 1);
            foreach ($cell as $cellk => $cellv) {
                if ($cellk > count($dataheader) - 1) break;
                $worksheet->setCellValue($cellv . '5', $dataheader[$cellk]);
            }

            $highestCell = $worksheet->getHighestColumn();

            if (array_key_exists('nama_keluarga', $data[0])) {
                $worksheet->setCellValue($cell[array_search($highestCell, $cell) + 1] . '5', 'Nama Keluarga');
                $worksheet->setCellValue($cell[array_search($highestCell, $cell) + 2] . '5', 'Status Keluarga');
            }

            $rowStart = 6;
            $rowStartnamk = 6;
            $rowStartstatk = 6;

            foreach ($data as $datav) {
                $cellInd = 0;
                foreach ($datav as $datvk => $datvkv) {
                    if ($datvk == 'nama_keluarga' || $datvk == 'status_keluarga') continue;
                    if ($datvk == 'masa_kerja') {
                        $worksheet->setCellValue($cell[$cellInd] . $rowStart, str_replace(['years', 'mons', 'days'], ['Tahun', 'Bulan', 'Hari'], $datvkv));
                    } else {
                        $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                        $worksheet->setCellValue($cell[$cellInd] . $rowStart, $datvkv);
                    }
                    $worksheet->getStyle($cell[$cellInd] . $rowStart)->applyFromArray([
                        'borders' => [
                            'top' => [
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            ]
                        ]
                    ]);
                    $cellInd++;
                }
                if (array_key_exists('nama_keluarga', $datav)) {
                    foreach (explode(';', $datav['nama_keluarga']) as $namk) {
                        $worksheet->setCellValue($cell[array_search($highestCell, $cell) + 1] . $rowStartnamk, $namk);
                        $worksheet->getStyle($cell[array_search($highestCell, $cell) + 1] . $rowStartnamk)->applyFromArray([
                            'borders' => [
                                'top' => [
                                    'style' => PHPExcel_Style_Border::BORDER_THIN
                                ]
                            ]
                        ]);
                        $rowStartnamk++;
                        $rowStart++;
                    }
                } else {
                    $rowStart++;
                }

                if (array_key_exists('nama_keluarga', $datav)) {
                    foreach (explode(';', $datav['status_keluarga']) as $statk) {
                        $worksheet->setCellValue($cell[array_search($highestCell, $cell) + 2] . $rowStartstatk, $statk);
                        $worksheet->getStyle($cell[array_search($highestCell, $cell) + 2] . $rowStartstatk)->applyFromArray([
                            'borders' => [
                                'top' => [
                                    'style' => PHPExcel_Style_Border::BORDER_THIN
                                ]
                            ]
                        ]);
                        $rowStartstatk++;
                    }
                }
            }
        }
        // die;

        $filename = 'cetak kategori.xls';
        header('Content-Type: aplication/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $writer->save('php://output');
    }
}
