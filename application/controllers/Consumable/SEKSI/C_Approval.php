<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Approval extends CI_Controller
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

        $data['Title'] = 'Approval Atasan';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $created_by = $this->session->user;

        $kodeakses = $this->M_consumable->cekjabatan($created_by);

        if ($kodeakses[0]['kd_jabatan'] > 13) {
            $akses = 'Deny';
        } else {
            $akses = 'Continue';
        }

        if ($akses == 'Continue') {
            $carikodesie = $this->M_consumable->carikodesie($created_by);
            $kodesie = $carikodesie[0]['kodesie'];
            $carinamaseksi = $this->M_consumable->dataSeksi($created_by);

            $kebutuhan = $this->M_consumable->selectkebutuhan2($kodesie);

            for ($i = 0; $i < sizeof($kebutuhan); $i++) {
                $desc = $this->M_consumable->getDescItemMaster($kebutuhan[$i]['item_code']);
                $kebutuhan[$i]['item_desc'] = $desc[0]['item_desc'];
                $kebutuhan[$i]['satuan'] = $desc[0]['uom'];
            }

            $data['kebutuhan'] = $kebutuhan;
            $data['carinamaseksi'] = $carinamaseksi;

            $this->load->view('V_Header', $data);
            $this->load->view('V_Sidemenu', $data);
            $this->load->view('Consumable/SEKSI/V_Approval', $data);
            $this->load->view('V_Footer', $data);
        } else {
            $this->load->view('V_Header', $data);
            $this->load->view('V_Sidemenu', $data);
            $this->load->view('Consumable/SEKSI/V_DenyAccess');
            $this->load->view('V_Footer', $data);
        }
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }

    public function UpdateApproveAtasan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $approved_by = $this->session->user;
        $approve_date = date("Y-m-d H:i:s");
        $item = $this->input->post('item');
        $id = $this->input->post('id');

        // echo "<pre>";
        // print_r($id);
        // exit();
        for ($i = 0; $i < sizeof($item); $i++) {
            $this->M_consumable->UpdateApprove($id[$i], $item[$i], $approved_by, $approve_date);
        }

        redirect(base_url('ConsumableSEKSI/Approval'));
    }
    public function UpdateRejectAtasan()
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
            $this->M_consumable->UpdateReject($id[$i], $item[$i], $approved_by, $approve_date);
        }

        redirect(base_url('ConsumableSEKSI/Approval'));
    }
}
