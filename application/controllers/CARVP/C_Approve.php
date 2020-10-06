<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Approve extends CI_Controller
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
        $this->load->model('CARVP/M_car');

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

        $data['Title'] = 'Approval';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $noind = $this->session->user;

        $list_supplier = $this->M_car->ListtoApprove($noind);
        $w = 0;
        foreach ($list_supplier as $supplier) {
            $list_supplier[$w]['DETAIL'] = $this->M_car->ListbyCAR($supplier['CAR_NUM']);
            $list_supplier[$w]['NO_CAR'] = $list_supplier[$w]['DETAIL'][0]['CAR_NUM'];
            $w++;
        }

        $data['car'] = $list_supplier;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CARVP/V_Approve');
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }

    public function updateApprove()
    {
        $no_car = $this->input->post('no_car');
        date_default_timezone_set('Asia/Jakarta');
        $approve_date = date('d-m-Y');
        $this->M_car->UpdateApprove($no_car, $approve_date);
    }
    public function DetailCAR()
    {
        $no_car = $this->input->post('no_car');

        $datatoView = $this->M_car->dataToEdit($no_car);

        $data['datatoview'] = $datatoView;

        // echo "<pre>";
        // print_r($datatoView);
        // exit();
        $this->load->view('CARVP/V_mdl_Detail', $data);
    }
}
