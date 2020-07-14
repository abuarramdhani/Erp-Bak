<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ApprovalDPB extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->library('session');
        $this->checkSession();

        $this->load->model('ApprovalDO/M_dpb');

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('ApprovalDO/M_approval');
    }
    
    public function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }

    public function index()
    {
        # code...
    }

    public function Vendor()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;
        
		$data['Menu']            = 'Approval DPB Vendor';
		$data['SubMenuOne']      = 'List Data';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);

        $data['RequestedDOList'] = $this->M_approval->getRequestedDOListById($this->session->user);

        $this->session->set_userdata('last_menu', $data['Menu']);

        $data['listApproval'] = $this->M_dpb->getListApprovalDPBVendor();

        // print_r($data['listApproval']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ApprovalDPBVendor', $data);
        $this->load->view('V_Footer', $data);
    }

    public function KHS()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;
        
		$data['Menu']            = 'Approval DPB KHS';
		$data['SubMenuOne']      = 'List Data';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);

        $data['RequestedDOList'] = $this->M_approval->getRequestedDOListById($this->session->user);

        $this->session->set_userdata('last_menu', $data['Menu']);

        $data['listApproval'] = $this->M_dpb->getListApprovalDPBKHS();

        // print_r($data['listApproval']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ApprovalDPBKHS', $data);
        $this->load->view('V_Footer', $data);
    }

    public function DetailVendor()
    {
        if ( ! $data['NO_PR'] = $this->input->post('data-pr') ) {
            redirect('ApprovalDO/ListDPBVendor');
        }

        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['Menu']            = 'List DPB Vendor';
		$data['SubMenuOne']      = '';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBVendorDetail'] = $this->M_dpb->getDPBVendorDetail($data['NO_PR']);
        // echo '<pre>';
        // print_r($data['DPBVendorDetail']);exit;
        $data['UserAccess']      = [   
            'jenis_kendaraan'  => 'readonly',
            'no_kendaraan'     => 'readonly',
            'nama_supir'       => 'readonly',
            'kontak_supir'     => 'readonly',
            'vendor_ekspedisi' => 'readonly',
            'estimasi_datang'  => 'readonly',
            'gudang_pengirim'  => 'readonly',
            'alamat_bongkar'   => 'readonly',
            'catatan'          => 'readonly',
            'estdate'          => ''
        ];
        if ($this->session->user === 'B0445') {
            $data['UserAccess'] = [   
                    'jenis_kendaraan'  => '',
                    'no_kendaraan'     => 'readonly',
                    'nama_supir'       => 'readonly',
                    'kontak_supir'     => 'readonly',
                    'vendor_ekspedisi' => 'readonly',
                    'estimasi_datang'  => 'readonly',
                    'gudang_pengirim'  => 'readonly',
                    'alamat_bongkar'   => '',
                    'catatan'          => '',
                    'estdate'          => ''
            ];
        }else {
            $data['UserAccess'] = [   
                    'jenis_kendaraan'  => 'readonly',
                    'no_kendaraan'     => '',
                    'nama_supir'       => '',
                    'kontak_supir'     => '',
                    'vendor_ekspedisi' => '',
                    'estimasi_datang'  => '',
                    'gudang_pengirim'   => 'readonly',
                    'alamat_bongkar'   => 'readonly',
                    'catatan'          => 'readonly',
                    'estdate'          => 'ADOEstDatang'
            ];
        }

        $this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DetailApprovalDPBVendor', $data);
        $this->load->view('V_Footer', $data);
    }

    public function DetailKHS()
    {
        if ( ! $data['NO_PR'] = $this->input->post('data-pr') ) {
            redirect('ApprovalDO/DPBKHS');
        }

        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['Menu']           = 'List DPB KHS';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBKHSDetail']   = $this->M_dpb->getDPBKHSDetail($data['NO_PR']);
        // echo '<pre>';
        // print_r($data['DPBKHSDetail']);exit;
        $data['UserAccess']      = [   
            'jenis_kendaraan'  => 'readonly',
            'no_kendaraan'     => 'readonly',
            'nama_supir'       => 'readonly',
            'kontak_supir'     => 'readonly',
            'vendor_ekspedisi' => 'readonly',
            'estimasi_datang'  => 'readonly',
            'gudang_pengirim'  => 'readonly',
            'alamat_bongkar'   => 'readonly',
            'catatan'          => 'readonly',
            'estdate'          => ''
        ];
        if ($this->session->user === 'B0445') {
            $data['UserAccess'] = [   
                    'jenis_kendaraan'  => '',
                    'no_kendaraan'     => 'readonly',
                    'nama_supir'       => 'readonly',
                    'kontak_supir'     => 'readonly',
                    'vendor_ekspedisi' => 'readonly',
                    'estimasi_datang'  => 'readonly',
                    'gudang_pengirim'  => 'readonly',
                    'alamat_bongkar'   => '',
                    'catatan'          => '',
                    'estdate'          => ''
            ];
        }else {
            $data['UserAccess'] = [   
                    'jenis_kendaraan'  => 'readonly',
                    'no_kendaraan'     => '',
                    'nama_supir'       => '',
                    'kontak_supir'     => '',
                    'vendor_ekspedisi' => '',
                    'estimasi_datang'  => '',
                    'gudang_pengirim'  => 'readonly',
                    'alamat_bongkar'   => 'readonly',
                    'catatan'          => 'readonly',
                    'estdate'          => 'ADOEstDatang'
            ];
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DetailApprovalDPBKHS', $data);
        $this->load->view('V_Footer', $data);
    }

    public function Action()
    {
        if ( ! $this->input->is_ajax_request() ) {
            redirect('ApprovalDO/ApprovalDPB');
        }

        $noind = $this->session->user;

        $data = [
            'APPROVED_FLAG' => $this->input->post('flag'),
            'NO_PR'         => $this->input->post('prNumber'),
            'APPROVED_BY'   => $noind
        ];

        $id = $data['NO_PR'];

        $this->M_dpb->ApproveDPB($id, $data);
        echo json_encode('Success!');
    }

    public function WaitingListApproveVendor()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;
        
		$data['Menu']            = 'Approval';
		$data['SubMenuOne']      = 'List Data';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);

        $data['RequestedDOList'] = $this->M_approval->getRequestedDOListById($this->session->user);

        $this->session->set_userdata('last_menu', $data['Menu']);

        $data['DPBVendorList'] = $this->M_dpb->getWaitingListApprovalDPBVendor();

        // print_r($data['listApproval']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_WaitingDPBVendor', $data);
        $this->load->view('V_Footer', $data);
    }

    public function WaitingListApproveKHS()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;
        
		$data['Menu']            = 'Approval';
		$data['SubMenuOne']      = 'List Data';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);

        $data['RequestedDOList'] = $this->M_approval->getRequestedDOListById($this->session->user);

        $this->session->set_userdata('last_menu', $data['Menu']);

        $data['DPBKHSList'] = $this->M_dpb->getWaitingListApprovalDPBKHS();

        // print_r($data['listApproval']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_WaitingDPBKHS', $data);
        $this->load->view('V_Footer', $data);
    }

}