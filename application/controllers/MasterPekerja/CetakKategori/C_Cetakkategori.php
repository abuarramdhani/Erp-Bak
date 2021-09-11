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
        ini_set('precision', '17');
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
        $select = explode(';', $select);

        $this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
        $worksheet = new PHPExcel();
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
                // foreach ($datav as $datvk => $datvkv) {
                //     if ($datvk == 'nama_keluarga' || $datvk == 'status_keluarga') continue;
                //     if ($datvk == 'masa_kerja') {
                //         $worksheet->setCellValue($cell[$cellInd] . $rowStart, str_replace(['years', 'mons', 'days'], ['Tahun', 'Bulan', 'Hari'], $datvkv));
                //     } else {
                //         $worksheet
                //         ->getStyle($cell[$cellInd] . $rowStart)
                //         ->getNumberFormat()
                //         ->setFormatCode(
                //             PHPExcel_Style_NumberFormat::FORMAT_TEXT
                //             );
                //         $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datvkv, PHPExcel_Cell_DataType::TYPE_STRING);
                //     }
                //     $worksheet->getStyle($cell[$cellInd] . $rowStart)->applyFromArray([
                //         'borders' => [
                //             'top' => [
                //                 'style' => PHPExcel_Style_Border::BORDER_THIN
                //             ]
                //         ]
                //     ]);
                //     $cellInd++;
                // }
                // if (array_key_exists('nama_keluarga', $datav)) {
                //     foreach (explode(';', $datav['nama_keluarga']) as $namk) {
                //         $worksheet->setCellValue($cell[array_search($highestCell, $cell) + 1] . $rowStartnamk, $namk);
                //         $worksheet->getStyle($cell[array_search($highestCell, $cell) + 1] . $rowStartnamk)->applyFromArray([
                //             'borders' => [
                //                 'top' => [
                //                     'style' => PHPExcel_Style_Border::BORDER_THIN
                //                 ]
                //             ]
                //         ]);
                //         $rowStartnamk++;
                //         $rowStart++;
                //     }
                // } else {
                //     $rowStart++;
                // }

                // if (array_key_exists('nama_keluarga', $datav)) {
                //     foreach (explode(';', $datav['status_keluarga']) as $statk) {
                //         $worksheet->setCellValue($cell[array_search($highestCell, $cell) + 2] . $rowStartstatk, $statk);
                //         $worksheet->getStyle($cell[array_search($highestCell, $cell) + 2] . $rowStartstatk)->applyFromArray([
                //             'borders' => [
                //                 'top' => [
                //                     'style' => PHPExcel_Style_Border::BORDER_THIN
                //                 ]
                //             ]
                //         ]);
                //         $rowStartstatk++;
                //     }
                // }
                if (in_array("tp.noind", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['noind'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.nama", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.jenkel", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jenkel'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.agama", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['agama'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.templahir", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['templahir'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(tgllahir, 'DD-MM-YYYY') AS tgllahir", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tgllahir'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.goldarah", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['goldarah'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.nik", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nik'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.no_kk", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['no_kk'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.nohp", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nohp'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.telepon", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['telepon'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if(in_array("tk.nama_keluarga,tk.status_keluarga", $select)){
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
                        }
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
                if (in_array("tp.alamat", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['alamat'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.prop", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['prop'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.kab", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['kab'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.kec", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['kec'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.desa", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['desa'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.kodepos", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['kodepos'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.statrumah", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['statrumah'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.almt_kost", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['almt_kost'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.gelard", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['gelard'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.gelarb", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['gelarb'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.pendidikan", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['pendidikan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.jurusan", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jurusan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.sekolah", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['sekolah'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("(select tk.nama from hrd_khs.tkeluarga tk where nokel = '01A' and tk.noind = tp.noind limit 1) ayah", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['ayah'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("(select tk.nama from hrd_khs.tkeluarga tk where nokel = '02A' and tk.noind = tp.noind limit 1) ibu", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['ibu'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.statnikah", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['statnikah'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(tglnikah, 'DD-MM-YYYY') AS tglnikah", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tglnikah'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.jumanak", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jumanak'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.jumsdr", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jumsdr'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.jtanak", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jtanak'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.jtbknanak", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jtbknanak'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.email_internal", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['email_internal'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.email", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['email'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.telkomsel_mygroup", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['telkomsel_mygroup'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.pidgin_account", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['pidgin_account'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.uk_baju", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['uk_baju'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.jenis_baju", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jenis_baju'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.uk_celana", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['uk_celana'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.uk_sepatu", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['uk_sepatu'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.kodesie", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['kodesie'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.kd_jabatan", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['kd_jabatan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.jabatan", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jabatan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("ts.dept", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['dept'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("ts.unit", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['unit'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("ts.seksi", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['seksi'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("ts.bidang", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['bidang'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("case when tp.kd_pkj is null then null else (select pekerjaan from hrd_khs.tpekerjaan tpe where tp.kd_pkj = tpe.kdpekerjaan) end pekerjaan", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['pekerjaan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.kantor_asal", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['kantor_asal'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.lokasi_kerja", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['lokasi_kerja'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.ruang", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['ruang'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.asal_outsourcing", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['asal_outsourcing'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.golkerja", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['golkerja'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(masukkerja, 'DD-MM-YYYY') AS masukkerja", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['masukkerja'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(diangkat, 'DD-MM-YYYY') AS diangkat", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['diangkat'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.lmkontrak", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['lmkontrak'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(akhkontrak, 'DD-MM-YYYY') AS akhkontrak", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['akhkontrak'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array('pkwt.mulai_perpanjangan', $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['mulai_perpanjangan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array('pkwt.lama_perpanjangan', $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['lama_perpanjangan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(tglkeluar, 'DD-MM-YYYY') AS tglkeluar", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tglkeluar'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.sebabklr", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['sebabklr'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.status_diangkat", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $val['status_diangkat'] == 't' ? "sudah diangkat" : "belum diangkat", PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }

                if (in_array("case when substring(tp.noind, 1,1) = 'K' then age(date(now()),date(tp.masukkerja)) when substring(tp.noind, 1,1) = 'P' then age(date(now()),date(tp.masukkerja)) when substring(tp.noind, 1,1) = 'R' then age(date(now()),date(tp.masukkerja)) else age(date(now()),date(tp.diangkat)) end as masa_kerja", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, 
                        str_replace(
                                ['years', 'mons', 'days', 'year', 'mon', 'day'], 
                                ['Tahun', 'Bulan', 'Hari', 'Tahun', 'Bulan', 'Hari'], $val['masa_kerja']
                        ) , PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tmj.nama_jabatan", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nama_jabatan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tj.nama_status", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nama_status'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.statpajak", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['statpajak'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.npwp", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['npwp'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.tempat_makan", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tempat_makan'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.tempat_makan1", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tempat_makan1'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.tempat_makan2", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tempat_makan2'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(tglspsi, 'DD-MM-YYYY') AS tglspsi", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tglspsi'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.nospsi", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nospsi'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(tglkop, 'DD-MM-YYYY') AS tglkop", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tglkop'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.nokoperasi", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nokoperasi'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.nokeb", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nokeb'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tp.ang_upamk", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['ang_upamk'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tb.no_peserta as no_bpjskes", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['no_bpjskes'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(tb.tglmulai, 'DD-MM-YYYY') AS tglmulaik", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tglmulaik'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(tb.tglakhir, 'DD-MM-YYYY') AS tglakhirk", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tglakhirk'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tb.bpu", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['bpu'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tb.bpg", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['bpg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tb.rsb", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['rsb'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tb.dokterjpk", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['dokterjpk'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("ttk.no_peserta as no_bpjstk", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['no_bpjstk'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(ttk.tglmulai, 'DD-MM-YYYY') AS tglmulai", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tglmulai'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("to_char(ttk.tglakhir, 'DD-MM-YYYY') AS tglakhir", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tglakhir'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("ttk.kartu_jaminan_pensiun", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['kartu_jaminan_pensiun'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.nik as nik_vaksinasi", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nik_vaksinasi'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.nama as nama_vaksinasi", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['nama_vaksinasi'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.status_vaksin", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['status_vaksin'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.jenis_vaksin", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['jenis_vaksin'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.tgl_vaksin_1", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tgl_vaksin_1'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.tgl_vaksin_2", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['tgl_vaksin_2'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.lokasi_vaksin", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['lokasi_vaksin'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.kelompok_vaksin", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['kelompok_vaksin'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if (in_array("tv.anggota_serumah", $select)) {
                    $worksheet
                        ->getStyle($cell[$cellInd] . $rowStart)
                        ->getNumberFormat()
                        ->setFormatCode(
                            PHPExcel_Style_NumberFormat::FORMAT_TEXT
                            );
                    $worksheet->setCellValueExplicit($cell[$cellInd] . $rowStart, $datav['anggota_serumah'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $cellInd++;
                }
                if ($rowStart < $rowStartnamk) {
                    $rowStart = $rowStartnamk;
                }else{
                    $rowStart++;
                }
            }
        }
        // die;

        $filename = 'cetak kategori.xls';
        header('Content-Type: aplication/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $writer->save('php://output');
    }
}
