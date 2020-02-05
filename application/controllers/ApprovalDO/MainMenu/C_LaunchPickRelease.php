<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_LaunchPickRelease extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->library('session');
        $this->checkSession();

        $this->load->model('ApprovalDO/M_launchpickrelease');
        $this->load->model('ApprovalDO/M_detail');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }

    public function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }

    public function index()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;
        
		$data['Menu']            = 'Launch Pick Release';
		$data['SubMenuOne']      = '';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['SOList']          = $this->M_launchpickrelease->getSOList();

        $this->session->set_userdata('last_menu', $data['Menu']);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_LaunchPickRelease', $data);
        $this->load->view('V_Footer', $data);
    }

    public function releaseDO()
    {
        $delivery_id = $this->input->post('deliveryId');
        foreach ($delivery_id as $key => $val) {
            $this->M_launchpickrelease->launchReleaseDO($val);
        }
        
        echo json_encode('Success');
    }

}