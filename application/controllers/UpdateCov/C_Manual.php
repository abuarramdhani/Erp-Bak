<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Manual extends CI_Controller
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
        $this->load->model('UpdateCov/M_update');

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

        $data['Title'] = 'Upload Data';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);



        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('UpdateCov/V_Help');
        $this->load->view('V_Footer', $data);

        echo '<script type="text/javascript">
        window.open("' . base_url('application/views/UpdateCov/KHS_SLIDE_SHOW_MANUAL.pdf') . '", "_blank"); 
        </script>';
    }
}
