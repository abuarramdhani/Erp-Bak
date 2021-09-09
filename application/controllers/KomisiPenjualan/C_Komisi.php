<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Komisi extends CI_Controller
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
        $this->load->model('KomisiPenjualan/M_komisi');

        $this->checkSession();
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('');
        }
    }

    public function CreateMemo()
    {

        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Create Memo';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('KomisiPenjualan/V_CreateMemo', $data);
        $this->load->view('V_Footer', $data);
    }
    public function getLineId()
    {
        $n = 1;
        check:
        $cek = $this->M_komisi->getLineId($n);
        if (!empty($cek)) {
            $n++;
            goto check;
        }
        return $n;
    }
    public function ImportFileMemo()
    {
        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';

        // load excel
        $file = $_FILES['FileMemo']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);

        // echo "<pre>";
        // print_r($sheets);
        // exit();
        $k = 0;
        $dataSheet = array();
        foreach ($sheets as $row) {
            if ($k != 0 && $row['A'] != null) {
                $line = $this->getLineId();
                $a = array(
                    // 'line' => $line,
                    'cabang' => $row['A'],
                    'program' => $row['B'],
                    'tanggal_memo' => $row['AI'],
                    'target_bayar' => $row['AJ'],
                    'nomor_memo' => $row['C'],
                    'nomor_urut' => $row['D'],
                    'relasi' => $row['E'],
                    'kota' => $row['F'],
                    'kode_relasi' => $row['G'],
                    'total_komisi' => $row['AC'],
                    'no_rekening' => $row['H'],
                    'nama_rekening' => $row['I'],
                    'nama_bank' => $row['J'],
                    'kc_bank' => $row['K'],
                    'no_npwp' => $row['L'],
                    'nama_npwp' => $row['M'],
                    'keterangan' => $row['AH'],
                    'jenis_pph' => $row['AD'],
                    'pajak' => $row['AE'],
                    'potongan_pajak' => $row['AF'],
                    'nett_ammount' => $row['AG'],
                    // 'checklist' => $row['V'],
                    // 'tanggal_traksaksi_komisi' => $row['W'],
                    // 'invoice_piutang' => $row['X'],
                    // 'surat_relasi' => $row['Y'],
                    // 'nama_toko' => $row['Z'],
                    // 'nama_pemilik' => $row['AA'],
                    'aab' => $row['O'],
                    'aac' => $row['R'],
                    'aae' => $row['Q'],
                    'aag' => $row['P'],
                    'aah' => $row['N'],
                    'aak' => $row['T'],
                    'aal' => $row['U'],
                    'aan' => $row['V'],
                    'aca' => $row['S'],
                    'ada' => $row['W'],
                    'adb' => $row['X'],
                    'adc' => $row['Y'],
                    'add' => $row['Z'],
                    'gaa' => $row['AA']
                );
                array_push($dataSheet, $a);
                $line = $this->getLineId();
                $validasi = $this->M_komisi->ValidasiMemo($a['nomor_memo']);
                $memo_date = $row['C'];
                $due_date = $row['D'];
                if ($validasi[0]['HASIL'] == 0) {
                    $header = array(
                        'PROGRAM_ID' => $line,
                        'PROGRAM_NAME' => $row['B'],
                        'MEMO_DATE' => $row['AI'],
                        'DUE_DATE' => $row['AJ'],
                        'MEMO_NUM' => $row['C'],
                        'MEMO_LINE' => $row['D'],
                        'METHODE' => $row['AH'],
                        'PPH' => $row['AD'],
                        'ACCOUNT_NUMBER' => $row['G'],
                        'BANK_ACCOUNT_NUM' => $row['H'],
                        'BANK_ACCOUNT_NAME' => $row['I'],
                        'BANK_NAME' => $row['J'],
                        'KC_BANK' => $row['K'],
                        'NPWP_NUM' => $row['L'],
                        'NPWP_NAME' => $row['M'],
                        'TOTAL_AMOUNT' => $row['AC'],
                    );
                    $this->M_komisi->InsertHeaderKomisi($header);

                    $line5 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'AAH',
                        'AMOUNT' => $row['N'],
                    );
                    $this->M_komisi->InsertLineKomisi($line5);
                    $line1 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'AAB',
                        'AMOUNT' => $row['O'],
                    );
                    $this->M_komisi->InsertLineKomisi($line1);
                    $line4 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'AAG',
                        'AMOUNT' => $row['P'],
                    );
                    $this->M_komisi->InsertLineKomisi($line4);
                    $line3 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'AAE',
                        'AMOUNT' => $row['Q'],
                    );
                    $this->M_komisi->InsertLineKomisi($line3);
                    $line2 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'AAC',
                        'AMOUNT' => $row['R'],
                    );
                    $this->M_komisi->InsertLineKomisi($line2);

                    $line9 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'ACA',
                        'AMOUNT' => $row['S'],
                    );
                    $this->M_komisi->InsertLineKomisi($line9);
                    $line6 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'AAK',
                        'AMOUNT' => $row['T'],
                    );
                    $this->M_komisi->InsertLineKomisi($line6);

                    $line7 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'AAL',
                        'AMOUNT' => $row['U'],
                    );
                    $this->M_komisi->InsertLineKomisi($line7);
                    $line8 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'AAN',
                        'AMOUNT' => $row['V'],
                    );
                    $this->M_komisi->InsertLineKomisi($line8);

                    $line10 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'ADA',
                        'AMOUNT' => $row['W'],
                    );
                    $this->M_komisi->InsertLineKomisi($line10);
                    $line11 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'ADB',
                        'AMOUNT' => $row['X'],
                    );
                    $this->M_komisi->InsertLineKomisi($line11);
                    $line12 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'ADC',
                        'AMOUNT' => $row['Y'],
                    );
                    $this->M_komisi->InsertLineKomisi($line12);
                    $line13 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'ADD',
                        'AMOUNT' => $row['Z'],
                    );
                    $this->M_komisi->InsertLineKomisi($line13);
                    $line14 = array(
                        'PROGRAM_ID' => $line,
                        'ITEM' => 'GAA',
                        'AMOUNT' => $row['AA'],
                    );
                    $this->M_komisi->InsertLineKomisi($line14);
                }
            }
            $k++;
        }

        // echo "<pre>";
        // print_r($dataSheet);
        // exit();

        ob_start();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 148), 0, '', 3, 3, 3, 3, 3, 3);

        $this->load->library('ciqrcode');

        if (!is_dir('./img')) {
            mkdir('./img', 0777, true);
            chmod('./img', 0777);
        }
        for ($i = 0; $i < sizeof($dataSheet); $i++) {

            $params['data']     = $dataSheet[$i]['nomor_memo'];
            $params['level']    = 'H';
            $params['size']     = 10;
            $params['black']    = array(255, 255, 255);
            $params['white']    = array(0, 0, 0);
            $params['savename'] = './assets/upload/KomisiPenjualan/Memo' . $dataSheet[$i]['nomor_urut'] . '.png';
            $this->ciqrcode->generate($params);
        }

        $data['dataSheet'] = $dataSheet;

        $pdf_dir = 'assets/upload/KomisiPenjualan/';
        $filename = 'Memo-Komisi-Penjualan' . date("d-m-Y") . '.pdf';
        $html = $this->load->view('KomisiPenjualan/V_Memo', $data, true);
        $footer = $this->load->view('KomisiPenjualan/V_MemoFooter', $data, true);

        ob_end_clean();
        $pdf->SetHTMLFooter($footer);
        $pdf->WriteHTML($html);
        $pdf->Output($pdf_dir . $filename, 'F');

        echo base_url() . $pdf_dir . $filename;
    }

    public function ExportFileExcel()
    {
        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);
        $worksheet->getColumnDimension('I')->setAutoSize(true);
        $worksheet->getColumnDimension('J')->setAutoSize(true);
        $worksheet->getColumnDimension('K')->setAutoSize(true);
        $worksheet->getColumnDimension('L')->setAutoSize(true);
        $worksheet->getColumnDimension('M')->setAutoSize(true);
        $worksheet->getColumnDimension('N')->setAutoSize(true);
        $worksheet->getColumnDimension('O')->setAutoSize(true);
        $worksheet->getColumnDimension('P')->setAutoSize(true);
        $worksheet->getColumnDimension('Q')->setAutoSize(true);
        $worksheet->getColumnDimension('R')->setAutoSize(true);
        $worksheet->getColumnDimension('S')->setAutoSize(true);
        $worksheet->getColumnDimension('T')->setAutoSize(true);
        $worksheet->getColumnDimension('U')->setAutoSize(true);
        $worksheet->getColumnDimension('V')->setAutoSize(true);
        $worksheet->getColumnDimension('W')->setAutoSize(true);
        $worksheet->getColumnDimension('X')->setAutoSize(true);
        $worksheet->getColumnDimension('Y')->setAutoSize(true);
        $worksheet->getColumnDimension('Z')->setAutoSize(true);
        $worksheet->getColumnDimension('AA')->setAutoSize(true);
        $worksheet->getColumnDimension('AB')->setAutoSize(true);
        $worksheet->getColumnDimension('AC')->setAutoSize(true);
        $worksheet->getColumnDimension('AD')->setAutoSize(true);
        $worksheet->getColumnDimension('AE')->setAutoSize(true);
        $worksheet->getColumnDimension('AF')->setAutoSize(true);
        $worksheet->getColumnDimension('AG')->setAutoSize(true);
        $worksheet->getColumnDimension('AH')->setAutoSize(true);
        $worksheet->getColumnDimension('AI')->setAutoSize(true);
        $worksheet->getColumnDimension('AJ')->setAutoSize(true);
        $worksheet->getColumnDimension('AK')->setAutoSize(true);
        $worksheet->getColumnDimension('AL')->setAutoSize(true);
        $worksheet->getColumnDimension('AM')->setAutoSize(true);
        $worksheet->getColumnDimension('AN')->setAutoSize(true);
        $worksheet->getColumnDimension('AO')->setAutoSize(true);

        // $objPHPExcel->getActiveSheet()->getStyle('C2:C500')->getNumberFormat()->setFormatCode(
        //     PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY
        // );
        // $objPHPExcel->getActiveSheet()->getStyle('D2:D500')->getNumberFormat()->setFormatCode(
        //     PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY
        // );
        // $objPHPExcel->getActiveSheet()->getStyle('W2:W500')->getNumberFormat()->setFormatCode(
        //     PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY
        // );

        $worksheet->getStyle('C2:C500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('D2:D500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('W2:W500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Cabang");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Nama Program");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Nomor Memo");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "Nama Toko / Relasi");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "Kota");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "Kode. Cust");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "No. Rekening");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "Nama Rekening");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "Nama Bank");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', "KC Bank");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', "NPWP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', "Nama NPWP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', "ZEVA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', "G1000");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', "BOXER");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', "M1000");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', "G600");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', "ZENA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', "IMPALA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', "CAPUNG");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', "CAPUNG RAWA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', "CAKAR BAJA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', "CAKAR BAJA MINI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', "CACAH BUMI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', "KASUARI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', "DIESEL ONLY");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1', "Qty Dapat Komisi");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1', "Komisi Total" . "\n" . "(exc. Pph)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1', "Jenis Pph");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1', "Besar Pajak");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF1', "Potongan" . "\n" . "pajak");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG1', "Nett Amount");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH1', "Keterangan" . "\n" . "(Transfer /" . "\n" . "Potong Piutang)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI1', "Tanggal " . "\n" . "Memo Dibuat");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ1', "Target " . "\n" . "Pembayaran");




        $objPHPExcel->getActiveSheet()->getStyle('A1:A500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1:B500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1:C500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1:D500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1:E500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1:F500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1:G500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1:H500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1:I500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1:J500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('K1:K500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1:L500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('M1:M500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('N1:N500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('O1:O500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('P1:P500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('Q1:Q500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('R1:R500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('S1:S500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('T1:T500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('U1:U500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('V1:V500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('W1:W500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('X1:X500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('Y1:Y500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('Z1:Z500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AA1:AA500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AB1:AB500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AC1:AC500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AD1:AD500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AE1:AE500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AF1:AF500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AG1:AG500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AH1:AH500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AI1:AI500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AJ1:AJ500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AK1:AK500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AL1:AL500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AM1:AM500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AN1:AN500')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AO1:AO500')->getAlignment()->setWrapText(true);



        $worksheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('T1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('U1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('V1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('W1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('X1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('Y1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('Z1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AA1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AB1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AC1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AD1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AE1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AF1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AG1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AH1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AI1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AJ1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AK1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AL1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AM1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AN1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('AO1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $worksheet->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('F1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('L1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('M1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('N1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('O1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('P1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('Q1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('R1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('S1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('T1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('U1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('V1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('W1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('X1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('Y1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('Z1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AA1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AB1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AC1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AD1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AE1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AF1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AG1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AH1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AI1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AJ1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AK1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AL1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AM1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AN1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('AO1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $worksheet->getStyle('A1')->getFont()->setSize(11);
        $worksheet->getStyle('B1')->getFont()->setSize(11);
        $worksheet->getStyle('C1')->getFont()->setSize(11);
        $worksheet->getStyle('C2')->getFont()->setSize(11);
        $worksheet->getStyle('D1')->getFont()->setSize(11);
        $worksheet->getStyle('D2')->getFont()->setSize(11);
        $worksheet->getStyle('E1')->getFont()->setSize(11);
        $worksheet->getStyle('F1')->getFont()->setSize(11);
        $worksheet->getStyle('G1')->getFont()->setSize(11);
        $worksheet->getStyle('H1')->getFont()->setSize(11);
        $worksheet->getStyle('I1')->getFont()->setSize(11);
        $worksheet->getStyle('J1')->getFont()->setSize(11);
        $worksheet->getStyle('K1')->getFont()->setSize(11);
        $worksheet->getStyle('L1')->getFont()->setSize(11);
        $worksheet->getStyle('M1')->getFont()->setSize(11);
        $worksheet->getStyle('N1')->getFont()->setSize(11);
        $worksheet->getStyle('O1')->getFont()->setSize(11);
        $worksheet->getStyle('P1')->getFont()->setSize(11);
        $worksheet->getStyle('Q1')->getFont()->setSize(11);
        $worksheet->getStyle('R1')->getFont()->setSize(11);
        $worksheet->getStyle('S1')->getFont()->setSize(11);
        $worksheet->getStyle('T1')->getFont()->setSize(11);
        $worksheet->getStyle('U1')->getFont()->setSize(11);
        $worksheet->getStyle('V1')->getFont()->setSize(11);
        $worksheet->getStyle('W1')->getFont()->setSize(11);
        $worksheet->getStyle('W2')->getFont()->setSize(11);
        $worksheet->getStyle('X1')->getFont()->setSize(11);
        $worksheet->getStyle('Y1')->getFont()->setSize(11);
        $worksheet->getStyle('Z1')->getFont()->setSize(11);
        $worksheet->getStyle('AA1')->getFont()->setSize(11);
        $worksheet->getStyle('AB1')->getFont()->setSize(11);
        $worksheet->getStyle('AC1')->getFont()->setSize(11);
        $worksheet->getStyle('AD1')->getFont()->setSize(11);
        $worksheet->getStyle('AE1')->getFont()->setSize(11);
        $worksheet->getStyle('AF1')->getFont()->setSize(11);
        $worksheet->getStyle('AG1')->getFont()->setSize(11);
        $worksheet->getStyle('AH1')->getFont()->setSize(11);
        $worksheet->getStyle('AI1')->getFont()->setSize(11);
        $worksheet->getStyle('AJ1')->getFont()->setSize(11);
        $worksheet->getStyle('AK1')->getFont()->setSize(11);
        $worksheet->getStyle('AL1')->getFont()->setSize(11);
        $worksheet->getStyle('AM1')->getFont()->setSize(11);
        $worksheet->getStyle('AN1')->getFont()->setSize(11);
        $worksheet->getStyle('AO1')->getFont()->setSize(11);


        $worksheet->getStyle('A1')->getFont()->setBold(true);
        $worksheet->getStyle('B1')->getFont()->setBold(true);
        $worksheet->getStyle('C1')->getFont()->setBold(true);
        $worksheet->getStyle('D1')->getFont()->setBold(true);
        $worksheet->getStyle('E1')->getFont()->setBold(true);
        $worksheet->getStyle('F1')->getFont()->setBold(true);
        $worksheet->getStyle('G1')->getFont()->setBold(true);
        $worksheet->getStyle('H1')->getFont()->setBold(true);
        $worksheet->getStyle('I1')->getFont()->setBold(true);
        $worksheet->getStyle('J1')->getFont()->setBold(true);
        $worksheet->getStyle('K1')->getFont()->setBold(true);
        $worksheet->getStyle('L1')->getFont()->setBold(true);
        $worksheet->getStyle('M1')->getFont()->setBold(true);
        $worksheet->getStyle('N1')->getFont()->setBold(true);
        $worksheet->getStyle('O1')->getFont()->setBold(true);
        $worksheet->getStyle('P1')->getFont()->setBold(true);
        $worksheet->getStyle('Q1')->getFont()->setBold(true);
        $worksheet->getStyle('R1')->getFont()->setBold(true);
        $worksheet->getStyle('S1')->getFont()->setBold(true);
        $worksheet->getStyle('T1')->getFont()->setBold(true);
        $worksheet->getStyle('U1')->getFont()->setBold(true);
        $worksheet->getStyle('V1')->getFont()->setBold(true);
        $worksheet->getStyle('W1')->getFont()->setBold(true);
        $worksheet->getStyle('X1')->getFont()->setBold(true);
        $worksheet->getStyle('Y1')->getFont()->setBold(true);
        $worksheet->getStyle('Z1')->getFont()->setBold(true);
        $worksheet->getStyle('AA1')->getFont()->setBold(true);
        $worksheet->getStyle('AB1')->getFont()->setBold(true);
        $worksheet->getStyle('AC1')->getFont()->setBold(true);
        $worksheet->getStyle('AD1')->getFont()->setBold(true);
        $worksheet->getStyle('AE1')->getFont()->setBold(true);
        $worksheet->getStyle('AF1')->getFont()->setBold(true);
        $worksheet->getStyle('AG1')->getFont()->setBold(true);
        $worksheet->getStyle('AH1')->getFont()->setBold(true);
        $worksheet->getStyle('AI1')->getFont()->setBold(true);
        $worksheet->getStyle('AJ1')->getFont()->setBold(true);
        $worksheet->getStyle('AK1')->getFont()->setBold(true);
        $worksheet->getStyle('AL1')->getFont()->setBold(true);
        $worksheet->getStyle('AM1')->getFont()->setBold(true);
        $worksheet->getStyle('AN1')->getFont()->setBold(true);
        $worksheet->getStyle('AO1')->getFont()->setBold(true);


        $worksheet->getDefaultRowDimension()->setRowHeight(-1);
        $worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="ListMemoKomisi' . date('d_m_Y') . '.xlsx"');
        ob_end_clean();
        $objWriter->save("php://output");
    }
    public function CreateInvoice()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $memo_num = $this->M_komisi->SelectNoMemo();

        $data['memo_num'] = $memo_num;

        $data['Title'] = 'Create Invoice';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('KomisiPenjualan/V_CreateInvoice', $data);
        $this->load->view('V_Footer', $data);
    }
    public function ApiCreateInvoice()
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit();
        $id = $_POST['value'];
        $user = $this->session->user;

        $this->M_komisi->UpdateInvoiced($id);
        $respon = $this->M_komisi->CreateInvoice($id, $user);


        if ($respon == 'VALID') {
            echo json_encode('success');
        } else {
            echo json_encode('fail');
        }
    }
}
