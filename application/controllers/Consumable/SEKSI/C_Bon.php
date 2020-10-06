<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Bon extends CI_Controller
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

        $data['Title'] = 'Input Bon';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $created_by = $this->session->user;

        $pkj_lok = $this->M_consumable->getDetailPekerja($created_by)->row()->lokasi_kerja;
        if (intval($pkj_lok) == 2) {
            $data['lokk'] = 'Tuksono';
            $data['lokk_id'] = '16103';
            $data['sub'] = '[PNL-TKS] GUDANG PENOLONG TRAKTOR DI TUKSONO';
            $data['sub_id'] = 'PNL-TKS';
        } else {
            $data['lokk'] = 'Yogyakarta';
            $data['lokk_id'] = '142';
            $data['sub'] = '[PNL-DM] GUDANG BAHAN PENOLONG PRODUKSI (PUSAT)';
            $data['sub_id'] = 'PNL-DM';
        }

        $created_by = $this->session->user;
        $carinamaseksi = $this->M_consumable->dataSeksi($created_by);

        $data['carinamaseksi'] = $carinamaseksi;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Consumable/SEKSI/V_Inputbon', $data);
        $this->load->view('V_Footer', $data);
    }

    public function loadtbodybon()
    {
        $created_by = $this->session->user;
        $carikodesie = $this->M_consumable->carikodesie($created_by);
        $kodesie = $carikodesie[0]['kodesie'];

        $tanggalbon = $this->input->post('tanggal');
        $datatobon = $this->M_consumable->selectkebutuhan4($kodesie, $tanggalbon);


        // echo "<pre>";
        // print_r($datatobon);
        // exit();

        $data['datatobon'] = $datatobon;
        $this->load->view('Consumable/SEKSI/V_InputbonTbl', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function nobon()
    {
        $back = 1;

        check:
        $tahun = date('y');
        $bulan = date('m');
        $hari = date('d');

        $no_bon = '8' . $tahun . $bulan . $hari . str_pad($back, 2, "0", STR_PAD_LEFT);
        $check = $this->M_consumable->selectdatabon($no_bon);

        if (!empty($check)) {
            $back++;
            goto check;
        }

        return $no_bon;
    }
    public function searchseksi()
    {
        $term = strtoupper($this->input->get('term'));

        $data = $this->M_consumable->getDataSeksi($term);

        echo json_encode($data);
    }
    public function getBranch()
    {
        $cost = $this->input->post('cost');
        $databranch = $this->M_consumable->getBranch($cost);

        echo json_encode($databranch[0]['KODE_CABANG']);
    }
    public function getPemakai()
    {
        $cost = $this->input->post('cost');
        $databranch = $this->M_consumable->getBranch($cost);

        echo json_encode($databranch[0]['PEMAKAI']);
    }
    public function penggunaan()
    {

        $cc = $this->input->post('cc');
        $c = substr($cc, 0, 1);
        $data = $this->M_consumable->listPenggunaan($c);
        echo '<option></option>';
        foreach ($data as $penggunaan) {
            echo '<option value="' . $penggunaan['USING_CATEGORY_CODE'] . '">' . $penggunaan['USING_CATEGORY'] . '</option>';
        }
    }

    public function Insertbon()
    {
        $item_code = $this->input->post('item');
        $qty_kebutuhan = $this->input->post('kebutuhan');
        $qty_bon = $this->input->post('qtybon');
        $qty_saldo = $this->input->post('saldo');
        date_default_timezone_set('Asia/Jakarta');
        $input_by = $this->session->user;
        $bon_date = date("Y-m-d H:i:s");
        $carikodesie = $this->M_consumable->carikodesie($input_by);
        $kodesie = $carikodesie[0]['kodesie'];
        $no_bon = $this->nobon();
        $seksi_pemakai = $this->input->post('seksi_pakai');
        $pemakai = $this->input->post('pemakai');
        $seksi_pengebon = $this->input->post('seksi_bon');
        $branch = $this->input->post('branch');
        $bonkegudang = $this->input->post('bon_ke');
        $penggunaan = $this->input->post('untuk');
        $c = substr($seksi_pemakai, 0, 1);
        $untukk = $this->M_consumable->getdescPenggunaan($penggunaan, $c);
        $untuk = $untukk[0]['USING_CATEGORY'];
        $periodebon = $this->input->post('periodebon');
        $lokasi_bon = $this->input->post('lokasi_bon');

        $account = $this->M_consumable->account($penggunaan, $seksi_pemakai);

        $array_pdf = array();
        for ($i = 0; $i < sizeof($item_code); $i++) {
            $this->M_consumable->Insertbon($item_code[$i], $qty_kebutuhan[$i], $qty_bon[$i], $qty_saldo[$i], $input_by, $bon_date, $kodesie, $no_bon, $periodebon);
            $descuom = $this->M_consumable->getDescItemMaster($item_code[$i]);
            $array_pdf[$i]['item'] = $item_code[$i];
            $array_pdf[$i]['qty_bon'] = $qty_bon[$i];
            $array_pdf[$i]['nama_barang'] = $descuom[0]['item_desc'];
            $array_pdf[$i]['satuan'] = $descuom[0]['uom'];
            $array_pdf[$i]['no_bon'] = $no_bon;
            $array_pdf[$i]['seksi_pemakai'] = $seksi_pemakai;
            $array_pdf[$i]['seksi_pengebon'] = $seksi_pengebon;
            $array_pdf[$i]['branch'] = $branch;
            $array_pdf[$i]['bonkegudang'] = $bonkegudang;
            $array_pdf[$i]['untuk'] = $untuk;
            $array_pdf[$i]['periodebon'] = $periodebon;
            $array_pdf[$i]['account'] = $account;


            $idOr = $this->M_consumable->getIdOr();

            $array_im = array(
                'NO_ID'          =>    $idOr,
                'KODE_BARANG'    =>    $item_code[$i],
                'NAMA_BARANG'    =>    $descuom[0]['item_desc'],
                'SATUAN'         =>    $descuom[0]['uom'],
                'PERMINTAAN'     =>    $qty_bon[$i],
                'KETERANGAN'     =>    'UNTUK KEBUTUHAN ITEM PERIODE ' . $periodebon,
                'COST_CENTER'    =>    $seksi_pemakai,
                'PENGGUNAAN'     =>    $untuk,
                'SEKSI_BON'      =>    $seksi_pengebon,
                'TUJUAN_GUDANG'  =>    $bonkegudang,
                'TANGGAL'        =>    date('d M Y'),
                'NO_BON'         =>    $no_bon,
                'PEMAKAI'        =>    $seksi_pemakai,
                'JENIS_PEMAKAI'  =>    'Seksi',
                'LOKASI'         =>    $lokasi_bon,
                'LOKATOR'        =>    '',
                'ACCOUNT'        =>    $account,
                'KODE_CABANG'    =>    $branch,
                'EXP'            =>    'N',
            );

            $this->M_consumable->insertBonIm($array_im);

            // echo "<pre>";
            // print_r($array_im);
        }
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
        $filename = $no_bon . '.pdf';
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
