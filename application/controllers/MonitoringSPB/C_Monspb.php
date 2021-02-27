<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monspb extends CI_Controller
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
        $this->load->model('MonitoringSPB/M_monspb');

        $this->checkSession();
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('');
        }
    }

    public function index()
    {

        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring SPB';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $header = $this->M_monspb->ListSpb();

        $data['header'] = $header;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MonitoringSPB/V_List', $data);
        $this->load->view('V_Footer', $data);
    }
    public function DetailSPB()
    {
        $spb = $this->input->post('s');
        $line = $this->M_monspb->DetailSpb($spb);

        // echo "<pre>";
        // print_r($line);
        // exit();

        $data['line'] = $line;

        $this->load->view('MonitoringSPB/V_DetailSPB', $data);
    }
}
