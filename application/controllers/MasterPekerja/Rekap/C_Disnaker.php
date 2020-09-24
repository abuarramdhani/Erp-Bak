<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_Disnaker extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');

        $this->load->library('Log_Activity');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('upload');
        $this->load->library('General');
        $this->load->library('pdf');
        $this->load->library('KonversiBulan');

        $this->load->model('MasterPekerja/Rekap/M_disnaker');

        $pdf    =   $this->pdf->load();
        date_default_timezone_set('Asia/Jakarta');

        $this->checkSession();
    }

    public function checkSession()
    {
        if(!($this->session->is_logged))
        {
            redirect('');
        }
    }

    public function index()
    {
        $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Disnaker', 'Rekap', 'Disnaker', '');
        $data['loker'] = $this->M_disnaker->getLokasiKerja('');
        // print_r($loker);exit();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPekerja/Rekap/Disnaker/V_Index_Aktif',$data);
        $this->load->view('V_Footer',$data);
    }

    public function export_pkjaktif()
    {   
         //print_r($_GET);exit();

        $tgl = $this->input->get('tanggal');

        // $tgl = date('Y-m-d');
        $lokasi = $this->input->get('lokasi');
            $loker = $this->M_disnaker->getLokasiKerjabyID($lokasi);
            $loker = $loker['lokasi_kerja'];
            if ($lokasi == '00') {
            $lokasi = '';
            $loker = 'SEMUA LOKASI KERJA';
            }
            
        $data = $this->M_disnaker->getPkjDisAktif($tgl,$lokasi);
        
        //print_r($loker);exit();

        for ($i=0; $i < count($data); $i++) { 
             if(empty(trim($data[$i]['nohp']))) $data[$i]['nohp'] = '-';
             if(empty(trim($data[$i]['bpjs_kesehatan']))) $data[$i]['bpjs_kesehatan'] = '-';
             if(empty(trim($data[$i]['bpjs_ketenagakerjaan']))) $data[$i]['bpjs_ketenagakerjaan'] = '-';
             if(empty(trim($data[$i]['email']))) $data[$i]['email'] = '-';
        }
        // print_r($data);

        $this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator('KHS ERP')
            ->setTitle("DATA TENAGA KERJA ".'Tanggal '.date('d-M-Y', strtotime($tgl)))
            ->setSubject("DATA TENAGA KERJA")
            ->setDescription("DATA TENAGA KERJA ".'Tanggal '.date('d-M-Y', strtotime($tgl)))
            ->setKeywords("DATA TENAGA KERJA");
        $style_header = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'bababa')
            )
        );
        $style_col = array(
            'font' => array('bold' => false),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $style_col2 = array(
            'font' => array('bold' => false),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $style_col3 = array(
            'font' => array('bold' => false),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $style_title = array(
            'font' => array('bold' => false),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );

        $right = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                )
            );


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', "LAMPIRAN 1");
        $objPHPExcel->getActiveSheet()->getStyle("P1")->applyFromArray($right);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:P2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "DATA TENAGA KERJA");
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($style_title);

        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:F5');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:F6');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Nama Perusahaan : CV KARYA HIDUP SENTOSA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "Alamat Perusahaan : Jl. Magelang No.144, Karangwaru,\nKec. Tegalrejo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55242");
        // $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "No Telp : (0274) 512095");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', "No  Wajib Lapor Perusahan :");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Tanggal : ".date('d F Y', strtotime($tgl)));
        $objPHPExcel->getActiveSheet()->getStyle("P3")->applyFromArray($right);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', "Nama Lengkap Tenaga Kerja");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', "NIK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8', "Alamat Sesuai KTP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8', "ALAMAT TEMPAT TINGGAL SEKARANG (diisi jika beda dgn KTP)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "NO HP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "NO KARTU BPJS KESEHATAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', "NO KPJ BPJS KETENAGAKERJAAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I8', "TINGKAT PENDIDIKAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J8', "STATUS PROFESI / JOB DESK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K8', "UPAH (centang jika sudah UMK)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L8', "UPAH YANG DIBERLAKUKAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M8', "STATUS PEGAWAI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N8', "WARGA NEGARA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O8', "ALAMAT EMAIL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P8', "KETERANGAN");

        for ($i=0; $i < 16; $i++) { 
            $kolom_new = PHPExcel_Cell::stringFromColumnIndex($i);
            $objPHPExcel->getActiveSheet()->getStyle($kolom_new.'8')->applyFromArray($style_header);
            $objPHPExcel->getActiveSheet()->getStyle($kolom_new.'8')->getAlignment()->setWrapText(true);
        }

        $start = 9;
        $no = 1;
        foreach ($data as $key) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$start, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$start, trim($key['nama']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$start,  trim($key['nik']), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$start, trim($key['alamat']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$start, trim($key['almt_kost']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$start, trim($key['nohp']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$start, trim($key['bpjs_kesehatan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$start, trim($key['bpjs_ketenagakerjaan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$start, trim($key['pendidikan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$start, trim($key['jabatan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$start, trim($key['upah']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$start, trim($key['upah_berlaku']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$start, trim($key['status_pegawai']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$start, trim($key['kewarganegaraan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$start, trim($key['email']));
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$start, trim($key['nik']));

            $objPHPExcel->getActiveSheet()->getStyle('A'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$start)->applyFromArray($style_col3);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$start)->applyFromArray($style_col3);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$start)->applyFromArray($style_col3);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$start)->applyFromArray($style_col3);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$start)->applyFromArray($style_col);

            // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
            $start++; $no++;
        }

        $objPHPExcel->setActiveSheetIndex(0);
        $filename = rawurlencode("Data Tenaga Kerja (".date('d-F-Y', strtotime($tgl)).").xlsx");

        header('Content-Type: application/vnd.ms-excel'); // mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); // tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function export_pkjresign()
    {
        // $tgl = date('Y-m-d');
        $tgl = $this->input->get('tanggal');
        $lokasi = $this->input->get('lokasi');
            $loker = $this->M_disnaker->getLokasiKerjabyID($lokasi);
            $loker = $loker['lokasi_kerja'];
            if ($lokasi == '00') {
            $lokasi = '';
            $loker = 'SEMUA LOKASI KERJA';
            }
        $data = $this->M_disnaker->getPkjDisResign($tgl,$lokasi);

        for ($i=0; $i < count($data); $i++) { 
             if(empty(trim($data[$i]['nohp']))) $data[$i]['nohp'] = '-';
             if(empty(trim($data[$i]['bpjs_kesehatan']))) $data[$i]['bpjs_kesehatan'] = '-';
             if(empty(trim($data[$i]['bpjs_ketenagakerjaan']))) $data[$i]['bpjs_ketenagakerjaan'] = '-';
             if(empty(trim($data[$i]['email']))) $data[$i]['email'] = '-';
        }
        // print_r($data);

        $this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator('KHS ERP')
            ->setTitle("DATA TENAGA KERJA RESIGN ".'Periode '.date('M-Y', strtotime($tgl)))
            ->setSubject("DATA TENAGA KERJA RESIGN")
            ->setDescription("DATA TENAGA KERJA RESIGN ".'Periode '.date('M-Y', strtotime($tgl)))
            ->setKeywords("DATA TENAGA KERJA RESIGN");
        $style_header = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'bababa')
            )
        );
        $style_col = array(
            'font' => array('bold' => false),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $style_col2 = array(
            'font' => array('bold' => false),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $style_col3 = array(
            'font' => array('bold' => false),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $style_title = array(
            'font' => array('bold' => true),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            );

        $right = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                )
            );


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', "LAMPIRAN 1");
        $objPHPExcel->getActiveSheet()->getStyle("P1")->applyFromArray($right);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:P2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "DATA TENAGA KERJA RESIGN");
        $objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($style_title);

        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:F5');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:F6');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Nama Perusahaan : CV KARYA HIDUP SENTOSA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "Alamat Perusahaan : Jl. Magelang No.144, Karangwaru,\nKec. Tegalrejo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55242");
        // $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "No Telp : (0274) 512095");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', "No  Wajib Lapor Perusahan :");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "Periode : ".date('F Y', strtotime($tgl)));
        $objPHPExcel->getActiveSheet()->getStyle("P3")->applyFromArray($right);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8', "Nama Lengkap Tenaga Kerja");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', "NIK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8', "Alamat Sesuai KTP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8', "ALAMAT TEMPAT TINGGAL SEKARANG (diisi jika beda dgn KTP)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "NO HP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8', "NO KARTU BPJS KESEHATAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', "NO KPJ BPJS KETENAGAKERJAAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I8', "TINGKAT PENDIDIKAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J8', "STATUS PROFESI / JOB DESK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K8', "UPAH (centang jika sudah UMK)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L8', "UPAH YANG DIBERLAKUKAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M8', "STATUS PEGAWAI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N8', "WARGA NEGARA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O8', "ALAMAT EMAIL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P8', "KETERANGAN");

        for ($i=0; $i < 16; $i++) { 
            $kolom_new = PHPExcel_Cell::stringFromColumnIndex($i);
            $objPHPExcel->getActiveSheet()->getStyle($kolom_new.'8')->applyFromArray($style_header);
            $objPHPExcel->getActiveSheet()->getStyle($kolom_new.'8')->getAlignment()->setWrapText(true);
        }

        $start = 9;
        $no = 1;
        foreach ($data as $key) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$start, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$start, trim($key['nama']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$start,  trim($key['nik']), PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$start, trim($key['alamat']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$start, trim($key['almt_kost']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$start, trim($key['nohp']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$start, trim($key['bpjs_kesehatan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$start, trim($key['bpjs_ketenagakerjaan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$start, trim($key['pendidikan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$start, trim($key['jabatan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$start, trim($key['upah']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$start, trim($key['upah_berlaku']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$start, trim($key['status_pegawai']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$start, trim($key['kewarganegaraan']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$start, trim($key['email']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$start, trim($key['sebabklr']).' (Per tgl '.date('d-m-Y', strtotime($key['tglkeluar'])).')');

            $objPHPExcel->getActiveSheet()->getStyle('A'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$start)->applyFromArray($style_col3);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$start)->applyFromArray($style_col3);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$start)->applyFromArray($style_col3);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$start)->applyFromArray($style_col);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$start)->applyFromArray($style_col3);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$start)->applyFromArray($style_col3);

            // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
            $start++; $no++;
        }

        $objPHPExcel->setActiveSheetIndex(0);
        $filename = rawurlencode("Data Tenaga Kerja Resign (".date('F Y', strtotime($tgl)).").xlsx");

        header('Content-Type: application/vnd.ms-excel'); // mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); // tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function ajx_tbldisnaker()
    {
        // print_r($_GET);exit();
        $type = $this->input->get('type');
        if ($type == 'aktif') {
            $tgl = $this->input->get('tanggal');
            $lokasi = $this->input->get('lokasi');
            $loker = $this->M_disnaker->getLokasiKerjabyID($lokasi);
            $loker = $loker['lokasi_kerja'];
            if ($lokasi == '00') {
            $lokasi = '';
            $loker = 'SEMUA LOKASI KERJA';
            }
            $d = $this->M_disnaker->getPkjDisAktif($tgl,$lokasi);
        }elseif ($type == 'resign') {
            $tgl = $this->input->get('periode');
            $tgl = date('Y-m-t', strtotime($tgl.'-01'));
            $lokasi = $this->input->get('lokasi');
            $loker = $this->M_disnaker->getLokasiKerjabyID($lokasi);
            $loker = $loker['lokasi_kerja'];
            if ($lokasi == '00') {
            $lokasi = '';
            $loker = 'SEMUA LOKASI KERJA';
            }
            // echo $tgl;exit();
            $d = $this->M_disnaker->getPkjDisResign($tgl,$lokasi);
        }else{
            echo "type not found";
            exit();
        }
        $data['date'] = $tgl;
        $data['lokasi'] = $lokasi;
        // print_r($lokasi);exit();
        $data['type'] = $type;
        $data['list'] = $d;
        $html = $this->load->view('MasterPekerja/Rekap/Disnaker/V_Table',$data, true);
        echo $html;
    }

    public function pkj_aktif()
    {
        $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Disnaker Pekerja Aktif', 'Rekap', 'Disnaker', 'Pekerja Aktif');
        $data['loker'] = $this->M_disnaker->getLokasiKerja('');
         //print_r($loker);exit();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPekerja/Rekap/Disnaker/V_Index_Aktif',$data);
        $this->load->view('V_Footer',$data);
    }

    public function pkj_resign()
    {
        $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Disnaker Pekerja Resign', 'Rekap', 'Disnaker', 'Pekerja Resign');
        $data['loker'] = $this->M_disnaker->getLokasiKerja('');
        // print_r($loker);exit();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPekerja/Rekap/Disnaker/V_Index_Resign',$data);
        $this->load->view('V_Footer',$data);
    }
}