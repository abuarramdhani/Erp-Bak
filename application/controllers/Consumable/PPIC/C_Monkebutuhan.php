<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monkebutuhan extends CI_Controller
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

        $data['Title'] = 'Monitoring Kebutuhan';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $seksi = $this->M_consumable->dataSeksibykodesie();

        $data['seksi'] = $seksi;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Consumable/PPIC/V_Monneed', $data);
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }
    public function loadtblmonitor()
    {
        $seksinya = $this->input->post('seksi');

        if ($seksinya == 'Semua Seksi') {
            $seksi = null;
        } else {
            $seksi = "where kodesie = '$seksinya'";
        }

        $monneed = $this->M_consumable->getDataNeedbyseksi($seksi);

        if ($seksinya == 'Semua Seksi') {
            $nama_seksi = 'Semua Seksi';
        } else {
            $carinamaseksi = $this->M_consumable->dataSeksi($monneed[0]['created_by']);
            $nama_seksi = $carinamaseksi[0]['seksi'];
        }

        for ($i = 0; $i < sizeof($monneed); $i++) {
            $descuom = $this->M_consumable->getDescUom($monneed[$i]['item_code']);
            $monneed[$i]['desc'] = $descuom[0]['DESKRIPSI'];
            $monneed[$i]['uom'] = $descuom[0]['SATUAN'];

            if ($monneed[$i]['approve_status'] == 0) {
                $monneed[$i]['status'] = 'Belum Approved';
            } else if ($monneed[$i]['approve_status'] == 1) {
                $monneed[$i]['status'] = 'Approved By Atasan';
            } else if ($monneed[$i]['approve_status'] == 2) {
                $monneed[$i]['status'] = 'Rejected By Atasan';
            } else if ($monneed[$i]['approve_status'] == 3) {
                $monneed[$i]['status'] = 'Approved By PPIC';
            } else if ($monneed[$i]['approve_status'] == 4) {
                $monneed[$i]['status'] = 'Rejected By PPIC';
            }
        }

        $data['monneed'] = $monneed;
        $data['nama_seksi'] = $nama_seksi;

        // echo "<pre>";
        // print_r($data['monneed']);
        // exit();

        $this->load->view('Consumable/PPIC/V_TblMonneed', $data);
    }
}
