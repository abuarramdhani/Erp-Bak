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
    public function Printlaporan()
    {
        $tanggal = $this->input->post('tgl_lko');
        $laporan = $this->M_input->LKObyTgl($tanggal);



        $timestamp = strtotime($tanggal);

        $day = date('l', $timestamp);

        // echo "<pre>";
        // print_r($day);
        // exit();

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

        $data['laporan'] = $laporan;
        $data['hari'] = $hari;

        ob_start();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 297), 0, '', 3, 3, 15, 3, 3, 3); //----- A5-L
        $filename = 'LKO_Welding(' . $tanggal . ').pdf';
        $html = $this->load->view('LKOWelding/V_PDFBody', $data, true);        //-----> Fungsi Cetak PDF
        $head = $this->load->view('LKOWelding/V_PDFHeader', $data, true);

        ob_end_clean();

        $pdf->SetHTMLHeader($head);
        $pdf->SetHTMLFooter($footer);                                                //-----> Pakai Library MPDF
        $pdf->WriteHTML($html);
        $pdf->SetHTMLFooter($foot);                                               //-----> Pakai Library MPDF
        $pdf->Output($filename, 'I');
    }
}
