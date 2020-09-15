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

        $seksi = $this->M_consumable->dataSeksibykodesie();
        // echo "<pre>";
        // print_r($seksi);
        // exit();

        $data['seksi'] = $seksi;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('Consumable/PPIC/V_Monbon', $data);
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


        if ($periode != null && $seksi != 'Semua Seksi') {
            $where = "where SUBSTR (ib.no_bon, 1, 1) = '8'
            AND ib.keterangan LIKE '%$periode'
            AND ib.seksi_bon = '$seksi'";
        } else if ($periode == null && $seksi == 'Semua Seksi') {
            $where = "where SUBSTR (ib.no_bon, 1, 1) = '8'";
        } else if ($periode == null && $seksi != 'Semua Seksi') {
            $where = "where SUBSTR (ib.no_bon, 1, 1) = '8'
            AND ib.seksi_bon = '$seksi'";
        } else if ($periode != null && $seksi == 'Semua Seksi') {
            $where = "where SUBSTR (ib.no_bon, 1, 1) = '8'
            AND ib.keterangan LIKE '%$periode'";
        }


        $monbon = $this->M_consumable->selectdatabonmonppic($where);

        // echo "<pre>";
        // print_r($monbon);
        // exit();


        for ($i = 0; $i < sizeof($monbon); $i++) {
            $databon = $this->M_consumable->detailbon($monbon[$i]['NO_BON']);
            $monbon[$i]['detail'] = $databon;
        }


        $data['monbon'] = $monbon;

        // echo "<pre>";
        // print_r($monbon);
        // exit();

        $this->load->view('Consumable/PPIC/V_TblMonbon', $data);
    }
}
