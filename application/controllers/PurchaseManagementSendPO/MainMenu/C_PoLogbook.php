<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_PoLogbook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->is_logged) { } else {
            redirect();
        }

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model("PurchaseManagementSendPO/MainMenu/M_polog");
    }

    public function index()
    {
        $user_id = $this->session->userid;

        $data['Menu'] = 'PO Logbook';
        $data['SubMenuOne'] = '';

        $data['UserMenu']       = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $BuyerNik = $this->session->user;
        $data['PoLogbook'] = $this->M_polog->getDataPObyNik($BuyerNik);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('PurchaseManagementSendPO/MainMenu/V_PoLogbook', $data);
        $this->load->view('V_Footer', $data);
    }
}