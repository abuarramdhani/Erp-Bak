<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Monfinish extends CI_Controller
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
        $this->load->model('AutoInvoice/M_autoinvoice');

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

        $data['Title'] = 'DO Finish Invoice';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['path'] = explode('/', $_SERVER['PATH_INFO']);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('AutoInvoice/V_Finish', $data);
        $this->load->view('V_Footer', $data);
    }
    public function ListFinish()
    {

        $DoFinish = $this->M_autoinvoice->DoFinish();

        for ($i = 0; $i < sizeof($DoFinish); $i++) {
            $InvoiceToCetak = $this->M_autoinvoice->InvoiceToCetak($DoFinish[$i]['CETAK_INVOICE_REQ_ID']);
            $RDOToCetak = $this->M_autoinvoice->RDOToCetak($DoFinish[$i]['CETAK_RDO_REQ_ID']);
            if ($InvoiceToCetak != null) {
                $DoFinish[$i]['AMMOUNT_INVOICE'] = $InvoiceToCetak[0]['CS_TOTAL'];
            } else {
                $DoFinish[$i]['AMMOUNT_INVOICE'] = 0;
            }
            if ($RDOToCetak != null) {
                $DoFinish[$i]['AMMOUNT_RDO'] = $RDOToCetak[0]['NETTO'];
            } else {
                $DoFinish[$i]['AMMOUNT_RDO'] = 0;
            }
        }


        $path = explode('/', $_SERVER['PATH_INFO']);

        // echo "<pre>";
        // print_r($DoFinish);
        // exit();

        $data['DoFinish'] = $DoFinish;

        $data['path'] = $path;

        $this->load->view('AutoInvoice/V_MonFinish', $data);
    }
}
