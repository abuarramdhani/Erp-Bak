<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Input extends CI_Controller
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
        $this->load->model('LKOWelding/M_input');

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

        $data['Title'] = 'Input Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LKOWelding/V_Input');
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function LoadView()
    {
        $data['lko'] = $this->M_input->selectLKO();

        $this->load->view('LKOWelding/V_TblLKO', $data);
    }
    public function Addlist()
    {
        $this->load->view('LKOWelding/V_ModalAdd');
    }
    public function listEmployee()
    {
        $term = $this->input->get('term', TRUE);
        $term = strtoupper($term);
        $data = $this->M_input->listEmployee($term);
        echo json_encode($data);
    }
    public function getName()
    {
        $ind = $this->input->post('v');
        $name = $this->M_input->getName($ind);
        echo json_encode($name[0]['nama']);
    }
    public function InsertDataa()
    {
        $tgl = $this->input->post('tgl');
        $ind = $this->input->post('ind');
        $nama = $this->input->post('nama');
        $work = $this->input->post('work');
        $tgt = $this->input->post('tgt');
        $act = $this->input->post('act');
        $percent = $this->input->post('percent');
        $shift = $this->input->post('shift');
        $ket = $this->input->post('ket');
        $mk = $this->input->post('mk');
        $i = $this->input->post('i');
        $bk = $this->input->post('bk');
        $tkp = $this->input->post('tkp');
        $kp = $this->input->post('kp');
        $ks = $this->input->post('ks');
        $kk = $this->input->post('kk');
        $pk = $this->input->post('pk');
        $created_by = $this->session->user;
        $creation_date = date("d-m-Y");
        $seksi = $this->M_input->dataSeksi($ind);

        // echo "<pre>";
        // print_r($seksi);
        // exit();

        $seksii = $seksi[0]['seksi'];

        $idOr = $this->M_input->getIdOr();
        $this->M_input->insertLKO($idOr, $seksii, $ind, $nama, $work, $created_by, $creation_date, $tgl, $tgt, $act, $percent, $shift, $ket, $mk, $i, $bk, $tkp, $kp, $ks, $kk, $pk);
    }
    public function ModalPrint()
    {
        $this->load->view('LKOWelding/V_ModalFilterTanggal');
    }
    public function ModalEdit()
    {
        $id = $this->input->post('id');
        $dataToEdit = $this->M_input->EditData($id);

        // echo "<pre>";
        // print_r($dataToEdit);
        // exit();

        $data['datatoedit'] = $dataToEdit;

        $this->load->view('LKOWelding/V_ModalEdit', $data);
    }
    public function Editdata()
    {
        // $tgl = $this->input->post('tgl');
        // $ind = $this->input->post('ind');
        // $nama = $this->input->post('nama');
        $id = $this->input->post('id');
        $work = $this->input->post('work');
        $tgt = $this->input->post('tgt');
        $act = $this->input->post('act');
        $percent = $this->input->post('percent');
        $shift = $this->input->post('shift');
        $ket = $this->input->post('ket');
        $mk = $this->input->post('mk');
        $i = $this->input->post('i');
        $bk = $this->input->post('bk');
        $tkp = $this->input->post('tkp');
        $kp = $this->input->post('kp');
        $ks = $this->input->post('ks');
        $kk = $this->input->post('kk');
        $pk = $this->input->post('pk');
        // $seksi = $this->M_input->dataSeksi($ind);

        $this->M_input->updateLKO($id, $work, $tgt, $act, $percent, $shift, $ket, $mk, $i, $bk, $tkp, $kp, $ks, $kk, $pk);
    }
    public function HapusData()
    {
        $id = $this->input->post('id');
        $this->M_input->DeleteData($id);
    }
    public function Printlaporan()
    {
        $tanggal = $this->input->post('tgl_lko');
        $laporan = $this->M_input->LKObyTgl($tanggal);
        $timestamp = strtotime($tanggal);
        $day = date('l', $timestamp);
        if ($day == 'Monday') {
            $hari = 'SENIN';
        } else  if ($day == 'Tuesday') {
            $hari = 'SELASA';
        } else  if ($day == 'Wednesday') {
            $hari = 'RABU';
        } else  if ($day == 'Thursday') {
            $hari = 'KAMIS';
        } else  if ($day == 'Friday') {
            $hari = 'JUMAT';
        } else  if ($day == 'Saturday') {
            $hari = 'SABTU';
        }

        $lko = array();
        $tampung = array();
        for ($d = 0; $d < sizeof($laporan); $d++) {
            if (!in_array($laporan[$d]['SHIFT'], $tampung)) {
                $a = array(
                    'SHIFT' => $laporan[$d]['SHIFT'],
                    'TANGGAL' => $laporan[$d]['TANGGAL'],
                    'HARI' => $hari,
                );
                array_push($lko, $a);
                array_push($tampung, $laporan[$d]['SHIFT']);
            }
        }
        for ($j = 0; $j < sizeof($lko); $j++) {
            for ($g = 0; $g < sizeof($laporan); $g++) {
                if ($laporan[$g]['SHIFT'] == $lko[$j]['SHIFT']) {
                    // array_push($lko[$j]['LAPORAN'], $laporan[$g]);
                    $lko[$j]['LAPORAN'][] = $laporan[$g];
                }
            }
        }


        $data['lko'] = $lko;

        ob_start();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 297), 0, '', 3, 3, 15, 3, 3, 3); //----- A5-L
        $filename = 'LKO_Welding(' . $tanggal . ').pdf';
        $html = $this->load->view('LKOWelding/V_PDFBody', $data, true);        //-----> Fungsi Cetak PDF
        $head = $this->load->view('LKOWelding/V_PDFHeader', $data, true);

        ob_end_clean();

        $pdf->SetHTMLHeader($head);
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'I');
    }
    public function ImportFile()
    {

        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Preview Hasil Import';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';


        $file_data  = array();
        // load excel
        $file = $_FILES['excel_file']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
        $k = 0;
        foreach ($sheets as $row) {
            if ($k != 0 && $k != 1) {
                $noind[] = $row['B'];
                $nama[] = $row['C'];
                $work[] = $row['D'];
                $tgt[] = $row['E'];
                $act[] = $row['F'];
                $persen[] = $row['G'];
                $shift[] = $row['H'];
                $ket[] = $row['I'];
                $mk[] = $row['J'];
                $i[] = $row['K'];
                $bk[] = $row['L'];
                $tkp[] = $row['M'];
                $kp[] = $row['N'];
                $ks[] = $row['O'];
                $kk[] = $row['P'];
                $pk[] = $row['Q'];
            }
            $k++;
        }

        for ($u = 0; $u < sizeof($noind); $u++) {
            $array_import[$u]['noind'] = $noind[$u];
            $array_import[$u]['nama'] = $nama[$u];
            $array_import[$u]['work'] = $work[$u];
            $array_import[$u]['tgt'] = $tgt[$u];
            $array_import[$u]['act'] = $act[$u];
            $array_import[$u]['persen'] = number_format($persen[$u], 2);
            $array_import[$u]['shift'] = $shift[$u];
            $array_import[$u]['ket'] = $ket[$u];
            $array_import[$u]['mk'] = $mk[$u];
            $array_import[$u]['i'] = $i[$u];
            $array_import[$u]['bk'] = $bk[$u];
            $array_import[$u]['tkp'] = $tkp[$u];
            $array_import[$u]['kp'] = $kp[$u];
            $array_import[$u]['ks'] = $ks[$u];
            $array_import[$u]['kk'] = $kk[$u];
            $array_import[$u]['pk'] = $pk[$u];
        }

        // echo "<pre>";
        // print_r($array_import);
        // exit();

        $data['array_import'] = $array_import;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LKOWelding/V_Import');
        $this->load->view('V_Footer', $data);
    }
    public function InsertImport()
    {
        $tgl = $this->input->post('tgl_import');
        $ind = $this->input->post('import_noind[]');
        $nama = $this->input->post('import_nama[]');
        $work = $this->input->post('import_work[]');
        $tgt = $this->input->post('import_tgt[]');
        $act = $this->input->post('import_act[]');
        $percent = $this->input->post('import_persen[]');
        $shift = $this->input->post('import_shift[]');
        $ket = $this->input->post('import_ket[]');
        $mk = $this->input->post('import_mk[]');
        $i = $this->input->post('import_lk[]');
        $bk = $this->input->post('import_bk[]');
        $tkp = $this->input->post('import_tkp[]');
        $kp = $this->input->post('import_kp[]');
        $ks = $this->input->post('import_ks[]');
        $kk = $this->input->post('import_kk[]');
        $pk = $this->input->post('import_pk[]');
        $created_by = $this->session->user;
        $creation_date = date("d-m-Y");


        for ($i = 0; $i < sizeof($ind); $i++) {
            $seksi = $this->M_input->dataSeksi($ind[$i]);
            $seksii = $seksi[0]['seksi'];

            if ($tgt[$i] == null) {
                $tgt[$i] = 0;
            }
            if ($act[$i] == null) {
                $act[$i] = 0;
            }
            if ($percent[$i] == null) {
                $percent[$i] = 0;
            }
            $idOr = $this->M_input->getIdOr();
            $this->M_input->insertLKO($idOr, $seksii, $ind[$i], $nama[$i], $work[$i], $created_by, $creation_date, $tgl, $tgt[$i], $act[$i], $percent[$i], $shift[$i], $ket[$i], $mk[$i], $i[$i], $bk[$i], $tkp[$i], $kp[$i], $ks[$i], $kk[$i], $pk[$i]);
        }

        redirect('LaporanKerjaOperator/Input');
    }
    public function DownLoadLayout()
    {
        require_once APPPATH . 'third_party/Excel/PHPExcel.php';
        require_once APPPATH . 'third_party/Excel/PHPExcel/IOFactory.php';
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->getColumnDimension('A')->setWidth(5);
        $worksheet->getColumnDimension('B')->setWidth(10);
        $worksheet->getColumnDimension('C')->setWidth(20);
        $worksheet->getColumnDimension('D')->setWidth(25);
        $worksheet->getColumnDimension('E')->setWidth(7);
        $worksheet->getColumnDimension('F')->setWidth(7);
        $worksheet->getColumnDimension('G')->setWidth(7);
        $worksheet->getColumnDimension('H')->setWidth(15);
        $worksheet->getColumnDimension('I')->setWidth(20);
        $worksheet->getColumnDimension('J')->setWidth(4);
        $worksheet->getColumnDimension('K')->setWidth(4);
        $worksheet->getColumnDimension('L')->setWidth(4);
        $worksheet->getColumnDimension('M')->setWidth(4);
        $worksheet->getColumnDimension('N')->setWidth(4);
        $worksheet->getColumnDimension('O')->setWidth(4);
        $worksheet->getColumnDimension('P')->setWidth(4);
        $worksheet->getColumnDimension('Q')->setWidth(4);


        $worksheet->mergeCells('A1:A2');
        $worksheet->mergeCells('B1:B2');
        $worksheet->mergeCells('C1:C2');
        $worksheet->mergeCells('D1:D2');
        $worksheet->mergeCells('E1:G1');
        $worksheet->mergeCells('H1:H2');
        $worksheet->mergeCells('I1:I2');
        $worksheet->mergeCells('J1:Q1');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "NO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "1");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "NO INDUK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "(KAPITAL)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "NAMA PEKERJA");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "(KAPITAL)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "URAIAN PEKERJAAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "(KAPITAL)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "PENCAPAIAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "TGT");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "ACT");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', "%");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "(ANGKA)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', "(ANGKA)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', "=(F3/E3)*100");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "SHIFT");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', "HURUF(KAPITAL)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', "KETERANGAN");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', "(KAPITAL)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "KONDITE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', "MK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', "I");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', "BK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "TKP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "KP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "KS");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "KK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', "PK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "");



        $worksheet->getStyle('A1')->getFont()->setSize(11);
        $worksheet->getStyle('A3')->getFont()->setSize(11);
        $worksheet->getStyle('B1')->getFont()->setSize(11);
        $worksheet->getStyle('B3')->getFont()->setSize(11);
        $worksheet->getStyle('C1')->getFont()->setSize(11);
        $worksheet->getStyle('C3')->getFont()->setSize(11);
        $worksheet->getStyle('D1')->getFont()->setSize(11);
        $worksheet->getStyle('D3')->getFont()->setSize(11);
        $worksheet->getStyle('E1')->getFont()->setSize(11);
        $worksheet->getStyle('E2')->getFont()->setSize(11);
        $worksheet->getStyle('E3')->getFont()->setSize(11);
        $worksheet->getStyle('F1')->getFont()->setSize(11);
        $worksheet->getStyle('F2')->getFont()->setSize(11);
        $worksheet->getStyle('F3')->getFont()->setSize(11);
        $worksheet->getStyle('G1')->getFont()->setSize(11);
        $worksheet->getStyle('G2')->getFont()->setSize(11);
        $worksheet->getStyle('I1')->getFont()->setSize(11);
        $worksheet->getStyle('I2')->getFont()->setSize(11);
        $worksheet->getStyle('J1')->getFont()->setSize(11);
        $worksheet->getStyle('J2')->getFont()->setSize(11);
        $worksheet->getStyle('K1')->getFont()->setSize(11);
        $worksheet->getStyle('K2')->getFont()->setSize(11);
        $worksheet->getStyle('L1')->getFont()->setSize(11);
        $worksheet->getStyle('L2')->getFont()->setSize(11);
        $worksheet->getStyle('M1')->getFont()->setSize(11);
        $worksheet->getStyle('M2')->getFont()->setSize(11);
        $worksheet->getStyle('N1')->getFont()->setSize(11);
        $worksheet->getStyle('N2')->getFont()->setSize(11);
        $worksheet->getStyle('O1')->getFont()->setSize(11);
        $worksheet->getStyle('O2')->getFont()->setSize(11);
        $worksheet->getStyle('P1')->getFont()->setSize(11);
        $worksheet->getStyle('P2')->getFont()->setSize(11);
        $worksheet->getStyle('Q1')->getFont()->setSize(11);
        $worksheet->getStyle('Q2')->getFont()->setSize(11);


        $worksheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('P2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('Q2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



        $worksheet->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('C3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('D1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $worksheet->getStyle('J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);

        $worksheet->getDefaultRowDimension()->setRowHeight(-1);
        $worksheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LaporanKerjaOperatorWelding.xlsx"');
        ob_end_clean();
        $objWriter->save("php://output");
    }
}
