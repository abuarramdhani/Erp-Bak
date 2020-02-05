<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DPB extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->checkSession();
        $this->load->model('ApprovalDO/M_dpb');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }
    
    private function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }

    public function index()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = 'DPB';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBList']        = $this->M_dpb->getDPBList();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DPB', $data);
        $this->load->view('V_Footer', $data);
    }

    public function detail()
    {
        if ( ! $data['NO_PR'] = $this->input->post('data-pr') ) {
            redirect('ApprovalDO/DPB');
        }

        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['Menu']           = 'DPB';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBDetail']      = $this->M_dpb->getDPBDetail($data['NO_PR']);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DetailDPB', $data);
        $this->load->view('V_Footer', $data);
    }

    public function saveDetail()
    {        
        if ( ! $this->input->is_ajax_request() ) {
            redirect('ApprovalDO/DPB');
        }

        $data = [
            'NO_PR'           => $this->input->post('prNumber'),
            'JENIS_KENDARAAN' => $this->input->post('vehicleCategory'),
            'NO_KENDARAAN'    => $this->input->post('vehicleId'),
            'NAMA_SUPIR'      => $this->input->post('driverName'),
            'NO_HP'           => $this->input->post('driverPhone') === '' ?  NULL : $this->input->post('driverPhone'),
            'LAIN'            => $this->input->post('additionalInformation')
        ];

        if ( count($this->M_dpb->checkIsExist($data['NO_PR'])) === 0 ) {
            $this->M_dpb->insertNewDetail($data);
        } else {
            $id = $data['NO_PR'];
            unset($data['NO_PR']);
            $this->M_dpb->updateDetail($id, $data);
        }

        echo json_encode('Success!');
    }

}