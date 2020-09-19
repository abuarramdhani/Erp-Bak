<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monbon extends CI_Controller
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
        $this->load->model('Consumable/M_consumable');

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

        $data['Title'] = 'Monitoring Bon';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $created_by = $this->session->user;
        $carinamaseksi = $this->M_consumable->dataSeksi($created_by);

        $data['seksi'] = $carinamaseksi[0]['seksi'];

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Consumable/SEKSI/V_Monbon', $data);
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function loadtblmonitor()
    {
        $periode = $this->input->post('tanggal');
        $seksi = $this->input->post('seksi');

        if ($periode != null) {
            $andperiode = "AND ib.keterangan LIKE '%$periode'";
        } else {
            $andperiode = null;
        }
        $monbon = $this->M_consumable->selectdatabonmonseksi($seksi, $andperiode);

        for ($i = 0; $i < sizeof($monbon); $i++) {
            $databon = $this->M_consumable->detailbon($monbon[$i]['NO_BON']);
            $monbon[$i]['detail'] = $databon;
        }

        $data['monbon'] = $monbon;

        // echo "<pre>";
        // print_r($data['monbon']);
        // exit();

        $this->load->view('Consumable/SEKSI/V_TblMonbon', $data);
    }
    public function printpdf()
    {
        $no_bon = $this->input->post('no');


        $dataBon = $this->M_consumable->getDataBonbyNobon($no_bon);

        $getDataPeriodeBon = $this->M_consumable->selectdatabon($no_bon);

        $array_pdf = array();
        for ($i = 0; $i < sizeof($dataBon); $i++) {
            $array = array(
                'item' => $dataBon[$i]['KODE_BARANG'],
                'qty_bon' => $dataBon[$i]['PERMINTAAN'],
                'nama_barang' => $dataBon[$i]['NAMA_BARANG'],
                'satuan' => $dataBon[$i]['SATUAN'],
                'no_bon' => $dataBon[$i]['NO_BON'],
                'seksi_pemakai' => $dataBon[$i]['COST_CENTER'],
                'seksi_pengebon' => $dataBon[$i]['SEKSI_BON'],
                'branch' => $dataBon[$i]['KODE_CABANG'],
                'bonkegudang' => $dataBon[$i]['TUJUAN_GUDANG'],
                'untuk' => $dataBon[$i]['PENGGUNAAN'],
                'periodebon' => $getDataPeriodeBon[$i]['periode'],
                'account' => $dataBon[$i]['ACCOUNT'],
            );

            array_push($array_pdf, $array);
        }

        // echo "<pre>";
        // print_r($array_pdf);
        // die;


        ob_start();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 148), 0, '', 3, 3, 3, 30, 3, 3);

        $this->load->library('ciqrcode');

        if (!is_dir('./img')) {
            mkdir('./img', 0777, true);
            chmod('./img', 0777);
        }

        $params['data']     = $array_pdf[0]['no_bon'];
        $params['level']    = 'H';
        $params['size']     = 10;
        $params['black']    = array(255, 255, 255);
        $params['white']    = array(0, 0, 0);
        $params['savename'] = './assets/upload/Consumable/' . ($array_pdf[0]['no_bon']) . '.png';
        $this->ciqrcode->generate($params);

        $data['array_pdf'] = $array_pdf;

        $pdf_dir = './assets/upload/Consumable/';
        $filename = $dataBon[0]['NO_BON'] . '.pdf';
        $html = $this->load->view('Consumable/SEKSI/V_KartuBon', $data, true);        //-----> Fungsi Cetak PDF
        $header = $this->load->view('Consumable/SEKSI/V_KartuBonHeader', $data, true);        //-----> Fungsi Cetak PDF
        $footer = $this->load->view('Consumable/SEKSI/V_KartuBonFooter', $data, true);        //-----> Fungsi Cetak PDF

        ob_end_clean();
        $pdf->SetHTMLFooter($footer);                                                //-----> Pakai Library MPDF                                           //-----> Pakai Library MPDF
        $pdf->WriteHTML($html);
        $pdf->Output($pdf_dir . $filename, 'F');

        echo base_url() . $pdf_dir . $filename;
    }
}
