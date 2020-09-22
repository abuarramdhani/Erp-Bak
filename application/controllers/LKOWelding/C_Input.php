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

        // $data['data_input']  = array();

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

        // $array_import = array();
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
        redirect('LaporanKerjaOperator/Input');
    }
}
