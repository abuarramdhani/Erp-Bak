<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Report extends CI_Controller
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
        $this->load->model('RekapEkspedisi/M_report');

        $this->checkSession();
    }
    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('index');
        }
    }

    public function index()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Input Rekap Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';



        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);



        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('RekapEkspedisi/V_InputData');
        $this->load->view('V_Footer', $data);
    }
    // public function onChangeJenisNomor()
    // {
    //     $jenis = $_POST['jenis_nomor'];
    //     $opt = "<option></option>";

    //     if ($jenis == 'SPB') {
    //         $number = $this->M_report->GetSPB();
    //         foreach ($number as $key => $num) {
    //             $opt .= '<option =' . $num['REQUEST_NUMBER'] . '>' . $num['REQUEST_NUMBER'] . '</option>';
    //         }
    //     } else {
    //         $number = $this->M_report->GetDOSP();
    //         foreach ($number as $key => $num) {
    //             $opt .= '<option =' . $num['BATCH_ID'] . '>' . $num['BATCH_ID'] . '</option>';
    //         }
    //     }

    //     echo $opt;
    // }
    public function getListNumSPB()
    {
        $term = $this->input->get('term', TRUE);
        if ($term == null) {
            $param = "";
        } else {
            $param = "and REQUEST_NUMBER like '%$term%'";
        }
        $data = $this->M_report->GetSPB($param);

        echo json_encode($data);
    }
    public function getListNumDOSP()
    {
        $term = strtoupper($this->input->get('term', TRUE));
        if ($term == null) {
            $param = "";
        } else {
            $param = "and BATCH_ID like '%$term%'";
        }
        $data = $this->M_report->GetDOSP($param);

        echo json_encode($data);
    }
    public function getNoSPBOSP()
    {
        $term = strtoupper($this->input->get('term', TRUE));
        if ($term == null) {
            $param = "";
        } else {
            $param = "where nomor like '%$term%'";
        }
        $data = $this->M_report->getSPBDOSP($param);

        echo json_encode($data);
    }
    public function GetDatatoAppend()
    {

        // $ekspedisi = $_POST['name_ekspedisi_express'];
        // $jenis = $_POST['jenis_nomor_ekspedisi_express'];
        $nomor = $_POST['nomor_ekspedisi_express'];
        $spbdosp = "";
        for ($f = 0; $f < sizeof($nomor); $f++) {
            if ($f == 0) {
                $spbdosp .= $nomor[$f];
            } else {
                $spbdosp .= ',' . $nomor[$f];
            }
        }

        $jenis = $this->M_report->PembedaNoSPBDOSP($nomor[0]);
        $urutan = rand(1000, 9999);
        if ($jenis[0]['TIPE'] == 'SPB') {
            $dataToAppend = $this->M_report->getDataNumSPB($nomor[0]);
        } else if ($jenis[0]['TIPE'] == 'DOSP') {
            $dataToAppend = $this->M_report->getDataNumDOSP($nomor[0]);
            $dataToAppend[0]['EXP_ID'] = "";
        }
        $dataToAppend[0]['URUTAN_RANDOM'] = $urutan;
        $dataToAppend[0]['TYPE'] = $jenis[0]['TIPE'];
        $dataToAppend[0]['SPB_DOSP'] = $spbdosp;

        // echo "<pre>";
        // print_r($nomor);
        // exit();
        echo json_encode($dataToAppend);
    }
    public function getDataSamaExpress()
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit();
        $relasi_ada = $_POST['relasi_terpasang'];
        $relasi = $_POST['relasi_yg_mau_diappend'];
        $index = $_POST['index_express'];
        $array_tampung = array();
        for ($i = 0; $i < sizeof($relasi_ada); $i++) {
            if ($relasi != $relasi_ada[$i]) {
            } else {
                array_push($array_tampung, $index[$i]);
            }
        }
        if ($array_tampung == null) {
            echo 0;
        } else {
            echo $array_tampung[0];
        }
    }
    public function DataIDExpress()
    {
        $n = 1;
        check:
        $cek = $this->M_report->cekDataIDExpress($n);
        if (!empty($cek)) {
            $n++;
            goto check;
        }
        return $n;
    }
    public function ExpInsert()
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit();
        $name_ekspedisi_express = $_POST['name_ekspedisi_express'];
        $jenis_no_express = $_POST['jenis_no_express'];
        // $jenis_nomor_ekspedisi_express = $_POST['jenis_nomor_ekspedisi_express'];
        $DateKirimExpress = $_POST['DateKirimExpress'];
        $no_resi_express = $_POST['no_resi_express'];
        $cost_center_express = $_POST['cost_center_express'];
        $index_express = $_POST['index_express'];
        $relasi_express = $_POST['relasi_express'];
        $tujuan_express = $_POST['tujuan_express'];
        $no_express = $_POST['no_express'];
        $colly_express = $_POST['colly_express'];
        $berat_express = $_POST['berat_express'];
        $biaya_express = $_POST['biaya_express'];
        $relasi_id_express = $_POST['relasi_id_express'];

        for ($i = 0; $i < sizeof($index_express); $i++) {
            if ($relasi_id_express[$i] == "" || $relasi_id_express[$i] == null) {
                $relasi_id_express[$i] = 'NULL';
            }
            $dataId = $this->DataIDExpress();
            $this->M_report->InsertDataExpress($jenis_no_express[$i], $dataId, $DateKirimExpress[$i], $no_resi_express[$i], $cost_center_express[$i], $relasi_id_express[$i], $tujuan_express[$i], $colly_express[$i], $berat_express[$i], $biaya_express[$i]);
            $value_num = explode(",", $no_express[$i]);
            for ($g = 0; $g < sizeof($value_num); $g++) {
                $this->M_report->InsertDataExpressNum($dataId, $value_num[$g]);
            }
        }
        // Setupp Excel -------------------------------------------------------------------
        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();

        $thin = array();
        $thin['borders'] = array();
        $thin['borders']['allborders'] = array();
        $thin['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $right = array();
        $right['borders'] = array();
        $right['borders']['right'] = array();
        $right['borders']['right']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $left = array();
        $left['borders'] = array();
        $left['borders']['left'] = array();
        $left['borders']['left']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $bottom = array();
        $bottom['borders'] = array();
        $bottom['borders']['bottom'] = array();
        $bottom['borders']['bottom']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $top = array();
        $top['borders'] = array();
        $top['borders']['top'] = array();
        $top['borders']['top']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('test_img');
        $objDrawing->setDescription('test_img');
        $objDrawing->setPath('./assets/img/logo.png');
        $objDrawing->setCoordinates('A1');
        //setOffsetX works properly
        $objDrawing->setOffsetX(15);
        // $objDrawing->setOffsetY(10);
        //set width, height
        $objDrawing->setWidth(80);
        $objDrawing->setHeight(40);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $worksheet->mergeCells('A1:A2');
        $worksheet->mergeCells('B1:I1');
        $worksheet->mergeCells('B2:I2');

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);
        $worksheet->getColumnDimension('I')->setAutoSize(true);



        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'REKAP PENGIRIMAN SPARE PART');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'EKSPEDISI ' . $name_ekspedisi_express . ', ' . date("F Y"));


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Tanggal');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', 'No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', 'Cost Center');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', 'Relasi / Cabang');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', 'Tujuan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', 'No. SPB/DOSP/SP/DPB');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', 'Colly');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', 'Berat (Kg)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', 'Biaya (Rp)');
        $worksheet->getStyle('A4:I4')->applyFromArray($thin);

        $row = 5;
        for ($h = 0; $h < sizeof($index_express); $h++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $DateKirimExpress[$h]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $no_resi_express[$h]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $cost_center_express[$h]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $relasi_express[$h]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $tujuan_express[$h]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, $jenis_no_express[$h] . ' ' . $no_express[$h]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, $colly_express[$h]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, $berat_express[$h]);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, $biaya_express[$h]);
            $worksheet->getStyle('A' . $row . ':I' . $row)->applyFromArray($thin);
            $row++;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $filename = 'assets/upload/RekapEkspedisi/' . $name_ekspedisi_express . '_' . date("dFy") . '_' . rand(1, 9) . '.xlsx';
        $objWriter->save($filename);

        echo $filename;
    }
    public function HistoryReport()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'History Rekap Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['ekspedisi'] = $this->M_report->GetEkspedisiperBulan();

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);



        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('RekapEkspedisi/V_HistoryData', $data);
        $this->load->view('V_Footer', $data);
    }

    public function ViewDataRekap($i)
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'View Rekap Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $bulan = $_POST['eks_bulan' . $i];
        $ekpedisi = $_POST['eks_name' . $i];


        $rekap = $this->M_report->GetrekapEkspedisiperBulan($bulan, $ekpedisi);

        for ($f = 0; $f < sizeof($rekap); $f++) {
            if ($ekpedisi == "SADANA") {
                if ($rekap[$f]['QTY'] < 400 || $rekap[$f]['QTY'] == 400) {
                    $sisa = $rekap[$f]['QTY'] - 10;
                    $biaya = 50000 + $sisa * 850;
                } else {
                    $biaya = $rekap[$f]['QTY'] * 850;
                }
            } else if ($ekpedisi == "JPM") {
                if ($rekap[$f]['QTY'] < 100 || $rekap[$f]['QTY'] == 100) {
                    $sisa = $rekap[$f]['QTY'] - 10;
                    $biaya = 50000 + $sisa * 850;
                } else {
                    $biaya = $rekap[$f]['QTY'] * 850;
                }
            } else if ($ekpedisi == "TAM") {
                $biaya = $rekap[$f]['QTY'] * 850;
            }
            $rekap[$f]['BIAYA'] = $biaya;
        }

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['rekap'] = $rekap;

        // echo "<pre>";
        // print_r($data['rekap']);
        // exit();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('RekapEkspedisi/V_EditData');
        $this->load->view('V_Footer', $data);
    }
    public function DeleteDataExpres()
    {
        $id = $_POST['data_id'];
        $this->M_report->DeleteDataExpress($id);
    }
    public function GetDatatoAppendEdit()
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit();
        $nomor = $_POST['nomor_ekspedisi_express'];
        $spbdosp = "";
        for ($f = 0; $f < sizeof($nomor); $f++) {
            if ($f == 0) {
                $spbdosp .= $nomor[$f];
            } else {
                $spbdosp .= ',' . $nomor[$f];
            }
        }

        $ekpedisi = $_POST['name_ekspedisi_express'];

        // for ($f = 0; $f < sizeof($rekap); $f++) {
        if ($ekpedisi == "SADANA") {
            if ($_POST['beratnya_express'] < 400 || $_POST['beratnya_express'] == 400) {
                $sisa = $_POST['beratnya_express'] - 10;
                $biaya = 50000 + $sisa * 850;
            } else {
                $biaya = $_POST['beratnya_express'] * 850;
            }
        } else if ($ekpedisi == "JPM") {
            if ($_POST['beratnya_express'] < 100 || $_POST['beratnya_express'] == 100) {
                $sisa = $_POST['beratnya_express'] - 10;
                $biaya = 50000 + $sisa * 850;
            } else {
                $biaya = $_POST['beratnya_express'] * 850;
            }
        } else if ($ekpedisi == "TAM") {
            $biaya = $_POST['beratnya_express'] * 850;
        }
        // }

        $jenis = $this->M_report->PembedaNoSPBDOSP($nomor[0]);
        $urutan = rand(1000, 9999);
        if ($jenis[0]['TIPE'] == 'SPB') {
            $dataToAppend = $this->M_report->getDataNumSPB($nomor[0]);
        } else if ($jenis[0]['TIPE'] == 'DOSP') {
            $dataToAppend = $this->M_report->getDataNumDOSP($nomor[0]);
            $dataToAppend[0]['EXP_ID'] = "";
        }
        // $dataToAppend[0]['URUTAN_RANDOM'] = $urutan;
        $dataToAppend[0]['TYPE'] = $jenis[0]['TIPE'];
        $dataToAppend[0]['SPB_DOSP'] = $spbdosp;

        // for ($i = 0; $i < sizeof($index_express); $i++) {
        $relasi_id_express = $dataToAppend[0]['EXP_ID'];
        if ($dataToAppend[0]['EXP_ID'] == "" || $dataToAppend[0]['EXP_ID'] == null) {
            $relasi_id_express = 'NULL';
        }
        $dataId = $this->DataIDExpress();
        $this->M_report->InsertDataExpress($dataToAppend[0]['TYPE'], $dataId, $_POST['tanggal_express'][0], $_POST['resi_express'], $dataToAppend[0]['COST_CENTER'], $relasi_id_express, $dataToAppend[0]['CITY'], $_POST['collynya_express'], $_POST['beratnya_express'], $biaya);
        // $value_num = explode(",", $no_express[$i]);
        for ($g = 0; $g < sizeof($nomor); $g++) {
            $this->M_report->InsertDataExpressNum($dataId, $nomor[$g]);
        }
        // }

        $rekap = $this->M_report->GetrekapEkspedisiperId($dataId);

        for ($f = 0; $f < sizeof($rekap); $f++) {
            if ($ekpedisi == "SADANA") {
                if ($rekap[$f]['QTY'] < 400 || $rekap[$f]['QTY'] == 400) {
                    $sisa = $rekap[$f]['QTY'] - 10;
                    $biaya = 50000 + $sisa * 850;
                } else {
                    $biaya = $rekap[$f]['QTY'] * 850;
                }
            } else if ($ekpedisi == "JPM") {
                if ($rekap[$f]['QTY'] < 100 || $rekap[$f]['QTY'] == 100) {
                    $sisa = $rekap[$f]['QTY'] - 10;
                    $biaya = 50000 + $sisa * 850;
                } else {
                    $biaya = $rekap[$f]['QTY'] * 850;
                }
            } else if ($ekpedisi == "TAM") {
                $biaya = $rekap[$f]['QTY'] * 850;
            }
            $rekap[$f]['BIAYA'] = $biaya;
        }
        // echo "<pre>";
        // print_r($rekap);
        // exit();
        echo json_encode($rekap);
    }
    public function ExpInsert2()
    {
        $ekpedisi = $_POST['name_ekspedisi_express'];
        $dataId = $_POST['DataIDExpress'];
        $rekap = array();
        for ($h = 0; $h < sizeof($dataId); $h++) {
            $rek = $this->M_report->GetrekapEkspedisiperId($dataId[$h]);
            array_push($rekap, $rek[0]);
        }

        for ($f = 0; $f < sizeof($rekap); $f++) {
            if ($ekpedisi == "SADANA") {
                if ($rekap[$f]['QTY'] < 400 || $rekap[$f]['QTY'] == 400) {
                    $sisa = $rekap[$f]['QTY'] - 10;
                    $biaya = 50000 + $sisa * 850;
                } else {
                    $biaya = $rekap[$f]['QTY'] * 850;
                }
            } else if ($ekpedisi == "JPM") {
                if ($rekap[$f]['QTY'] < 100 || $rekap[$f]['QTY'] == 100) {
                    $sisa = $rekap[$f]['QTY'] - 10;
                    $biaya = 50000 + $sisa * 850;
                } else {
                    $biaya = $rekap[$f]['QTY'] * 850;
                }
            } else if ($ekpedisi == "TAM") {
                $biaya = $rekap[$f]['QTY'] * 850;
            }
            $rekap[$f]['BIAYA'] = $biaya;
        }

        // echo "<pre>";
        // print_r($rekap);
        // exit();

        // Setupp Excel -------------------------------------------------------------------
        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();

        $thin = array();
        $thin['borders'] = array();
        $thin['borders']['allborders'] = array();
        $thin['borders']['allborders']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $right = array();
        $right['borders'] = array();
        $right['borders']['right'] = array();
        $right['borders']['right']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $left = array();
        $left['borders'] = array();
        $left['borders']['left'] = array();
        $left['borders']['left']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $bottom = array();
        $bottom['borders'] = array();
        $bottom['borders']['bottom'] = array();
        $bottom['borders']['bottom']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $top = array();
        $top['borders'] = array();
        $top['borders']['top'] = array();
        $top['borders']['top']['style'] = PHPExcel_Style_Border::BORDER_THIN;

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('test_img');
        $objDrawing->setDescription('test_img');
        $objDrawing->setPath('./assets/img/logo.png');
        $objDrawing->setCoordinates('A1');
        //setOffsetX works properly
        $objDrawing->setOffsetX(15);
        // $objDrawing->setOffsetY(10);
        //set width, height
        $objDrawing->setWidth(80);
        $objDrawing->setHeight(40);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $worksheet->mergeCells('A1:A2');
        $worksheet->mergeCells('B1:I1');
        $worksheet->mergeCells('B2:I2');

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);
        $worksheet->getColumnDimension('I')->setAutoSize(true);



        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'REKAP PENGIRIMAN SPARE PART');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'EKSPEDISI ' . $ekpedisi . ', ' . date("F Y"));


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Tanggal');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', 'No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', 'Cost Center');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', 'Relasi / Cabang');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', 'Tujuan');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', 'No. SPB/DOSP/SP/DPB');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', 'Colly');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', 'Berat (Kg)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', 'Biaya (Rp)');
        $worksheet->getStyle('A4:I4')->applyFromArray($thin);

        $row = 5;
        for ($h = 0; $h < sizeof($rekap); $h++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $rekap[$h]['TANGGAL_RESI']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $rekap[$h]['NO_RESI']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $rekap[$h]['COST_CENTER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $rekap[$h]['RELASI']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $rekap[$h]['CITY']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, $rekap[$h]['INDEX_TYPE'] . ' ' . $rekap[$h]['NOMOR']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, $rekap[$h]['COLLY']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, $rekap[$h]['QTY']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, $rekap[$h]['BIAYA']);
            $worksheet->getStyle('A' . $row . ':I' . $row)->applyFromArray($thin);
            $row++;
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $filename = 'assets/upload/RekapEkspedisi/' . $ekpedisi . '_' . date("dFy") . '_' . rand(1, 9) . '.xlsx';
        $objWriter->save($filename);

        echo $filename;
    }
}
