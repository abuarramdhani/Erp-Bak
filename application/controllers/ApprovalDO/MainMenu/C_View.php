<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_View extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->checkSession();

        $this->load->model('ApprovalDO/M_detail');
        $this->load->model('ApprovalDO/M_list');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('ApprovalDO/M_dpb');
    }

    private function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }

    public function ListDPBVendor()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = 'List DPB Vendor';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBVendorList']  = $this->M_dpb->getDPBVendorList();

        $data['judul'] = 'Pengiriman Barang Vendor';
        // echo '<pre>';
        // print_r($data['DPBVendorList']);exit;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ViewListDPBVendor', $data);
        $this->load->view('V_Footer', $data);
    }

    public function ListDPBKHS()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = 'DPB KHS';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBKHSList']     = $this->M_dpb->getListDPBKHS();
        $data['UserAccess']     = [
            'add_data'  => 'disabled',
            'delete'    => 'disabled'
        ];


		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ViewListDPBKHS', $data);
        $this->load->view('V_Footer', $data);
    }

    public function detailKHS()
    {
        if ( ! $data['NO_PR'] = $this->input->post('data-pr') ) {
            redirect('ApprovalDO/DPBKHS');
        }

        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['Menu']           = 'DPB KHS';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBKHSDetail']   = $this->M_dpb->getDPBKHSDetail($data['NO_PR']);
        $data['UserAccess']     = [
            'add_row'    => 'disabled',
            'edit_field' => 'readonly',
            'delete_row' => 'disabled',
            'save'       => 'disabled'
        ];

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ViewDetailDPBKHS', $data);
        $this->load->view('V_Footer', $data);
    }

    public function detailVendor()
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
            'alamat_bongkar'   => 'readonly',
            'catatan'          => 'readonly',
            'estdate'          => 'readonly',
            'tgl_kirim'          => 'readonly',
            'gudang_pengirim'  => 'readonly'
        ];

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ViewDetailDPBVendor', $data);
        $this->load->view('V_Footer', $data);
    }
}