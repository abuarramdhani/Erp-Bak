<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Datamasuk extends CI_Controller
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

        $data['Title'] = 'Data Masuk';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data_kebutuhan = $this->M_consumable->selectkebutuhanapproved();

        // echo "<pre>";
        // print_r($data_kebutuhan);
        // exit();

        $kebutuhan_seksi = array();
        $tampungan_seksi = array();
        for ($n = 0; $n < sizeof($data_kebutuhan); $n++) {
            $nama_seksi = $this->M_consumable->dataSeksi($data_kebutuhan[$n]['created_by']);
            $array_need = array(
                'nama_seksi' => $nama_seksi[0]['seksi'],
                'kodesie' => $nama_seksi[0]['kodesie'],

            );
            if ($kebutuhan_seksi == null) {
                array_push($kebutuhan_seksi, $array_need);
                array_push($tampungan_seksi, $nama_seksi[0]['seksi']);
            } else if (!in_array($nama_seksi[0]['seksi'], $tampungan_seksi)) {
                array_push($kebutuhan_seksi, $array_need);
                array_push($tampungan_seksi, $nama_seksi[0]['seksi']);
            }
        }

        // echo "<pre>";
        // print_r($kebutuhan_seksi);
        // exit();

        for ($d = 0; $d < sizeof($kebutuhan_seksi); $d++) {
            $data_need_perseksi = $this->M_consumable->selectkebutuhan3($kebutuhan_seksi[$d]['kodesie']);
            $rekap_need_perseksi = $this->M_consumable->selectkebutuhann($kebutuhan_seksi[$d]['kodesie']);
            $array_rekap = array();
            $tampung = array();
            for ($i = 0; $i < sizeof($rekap_need_perseksi); $i++) {
                $array = $this->M_consumable->getkebutuhanbyItem($rekap_need_perseksi[$i]['item_code']);
                if (!in_array($array[0]['item_code'], $tampung)) {
                    array_push($array_rekap, $array[0]);
                    array_push($tampung, $array[0]['item_code']);
                }
            }

            for ($c = 0; $c < sizeof($data_need_perseksi); $c++) {
                $desc = $this->M_consumable->getDescItemMaster($data_need_perseksi[$c]['item_code']);
                $data_need_perseksi[$c]['item_desc'] = $desc[0]['item_desc'];
                $data_need_perseksi[$c]['uom'] = $desc[0]['uom'];
            }
            for ($v = 0; $v < sizeof($array_rekap); $v++) {
                $desc = $this->M_consumable->getDescItemMaster($array_rekap[$v]['item_code']);
                $array_rekap[$v]['item_desc'] = $desc[0]['item_desc'];
                $array_rekap[$v]['uom'] = $desc[0]['uom'];
            }
            $kebutuhan_seksi[$d]['tgl_input'] = $data_need_perseksi[0]['creation_date'];
            $kebutuhan_seksi[$d]['tgl_approve_atasan'] = $data_need_perseksi[0]['approve_date'];
            $kebutuhan_seksi[$d]['lihat'] = $data_need_perseksi;
            $kebutuhan_seksi[$d]['rekap'] = $array_rekap;
        }

        // echo "<pre>";
        // print_r($kebutuhan_seksi);
        // exit();

        $data['kebutuhan_seksi'] = $kebutuhan_seksi;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Consumable/PPIC/V_DataMasuk', $data);
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }

    public function UpdateApprovePPIC()
    {
        $item = $this->input->post('item');
        $id = $this->input->post('id');
        date_default_timezone_set('Asia/Jakarta');
        $approved_by = $this->session->user;
        $approve_date = date("Y-m-d H:i:s");

        // echo "<pre>";
        // print_r($id);
        // print_r($item);
        // print_r($approved_by);
        // print_r($approve_date);
        // exit();
        for ($i = 0; $i < sizeof($item); $i++) {
            $this->M_consumable->UpdateApprovePPIC($id[$i], $item[$i], $approved_by, $approve_date);
        }

        redirect(base_url('ConsumablePPIC/Datamasuk'));
    }
    public function UpdateRejectPPIC()
    {
        $item = $this->input->post('item');
        $id = $this->input->post('id');
        date_default_timezone_set('Asia/Jakarta');
        $approved_by = $this->session->user;
        $approve_date = date("Y-m-d H:i:s");

        // echo "<pre>";
        // print_r($id);
        // exit();
        for ($i = 0; $i < sizeof($item); $i++) {
            $this->M_consumable->UpdateRejectPPIC($id[$i], $item[$i], $approved_by, $approve_date);
        }

        redirect(base_url('ConsumablePPIC/Datamasuk'));
    }
}
