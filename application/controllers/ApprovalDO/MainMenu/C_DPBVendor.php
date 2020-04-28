<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DPBVendor extends CI_Controller {

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
        $this->load->view('ApprovalDO/MainMenu/V_DPBVendor', $data);
        $this->load->view('V_Footer', $data);
    }

    public function detail()
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
            'lain_lain'        => 'readonly',
            'estdate'          => ''
        ];
        if ($this->session->responsibility_id == '2724') {
            $data['UserAccess'] = [   
                    'jenis_kendaraan'  => 'readonly',
                    'no_kendaraan'     => '',
                    'nama_supir'       => '',
                    'kontak_supir'     => '',
                    'vendor_ekspedisi' => '',
                    'estimasi_datang'  => '',
                    'lain_lain'        => '',
                    'estdate'          => 'ADOEstDatang'
            ];
        }else if ($this->session->responsibility_id == '2709') {
            $data['UserAccess'] = [   
                    'jenis_kendaraan'  => '',
                    'no_kendaraan'     => 'readonly',
                    'nama_supir'       => 'readonly',
                    'kontak_supir'     => 'readonly',
                    'vendor_ekspedisi' => 'readonly',
                    'estimasi_datang'  => 'readonly',
                    'lain_lain'        => '',
                    'estdate'          => ''
            ];
        }

        // if ( $this->session->user === 'B0747' ) {
        //     $data['UserAccess'] = [   
        //         'jenis_kendaraan'  => 'readonly',
        //         'no_kendaraan'     => '',
        //         'nama_supir'       => '',
        //         'vendor_ekspedisi' => '',
        //         'lain_lain'        => ''
        //     ];
        // } else if ( $this->session->user === 'B0445' ) {
        //     $data['UserAccess'] = [   
        //         'jenis_kendaraan'  => '',
        //         'no_kendaraan'     => 'readonly',
        //         'nama_supir'       => 'readonly',
        //         'vendor_ekspedisi' => 'readonly',
        //         'lain_lain'        => ''
        //     ];
        // } else if ( $this->session->user === 'F2326' ) {
        //     $data['UserAccess'] = [   
        //         'jenis_kendaraan'  => '',
        //         'no_kendaraan'     => '',
        //         'nama_supir'       => '',
        //         'vendor_ekspedisi' => '',
        //         'lain_lain'        => ''
        //     ];
        // } else if ( $this->session->user === 'J1396' ) {
        //     $data['UserAccess'] = [   
        //         'jenis_kendaraan'  => '',
        //         'no_kendaraan'     => '',
        //         'nama_supir'       => '',
        //         'vendor_ekspedisi' => '',
        //         'lain_lain'        => ''
        //     ];
        // }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DetailDPBVendor', $data);
        $this->load->view('V_Footer', $data);
    }

    public function saveDetail()
    {        
        if ( ! $this->input->is_ajax_request() ) {
            redirect('ApprovalDO/ListDPBVendor');
        }

        $estDatang = date("Y-m-d H:i:s",strtotime($this->input->post('estDatang')));
  /*       $estDatang = "TO_DATE('$estDatang1','yyyy-mm-dd HH24:MI:SS')"; */

        $nopr = $this->input->post('prNumber');
        $jnsKend = $this->input->post('vehicleCategory');
        $nokend = $this->input->post('vehicleId');
        $namasupir = $this->input->post('driverName');
        $kontaksupir = $this->input->post('driverPhone');
        $vendorekspedisi = $this->input->post('expVendor');
        $lain = $this->input->post('additionalInformation');

        $data = [
            'NO_PR'            => $nopr,
            'JENIS_KENDARAAN'  => $jnsKend,
            'NO_KENDARAAN'     => $nokend,
            'NAMA_SUPIR'       => $namasupir,
            'KONTAK_SOPIR'     => $kontaksupir,
            'VENDOR_EKSPEDISI' => $vendorekspedisi,
            // 'ESTIMASI_DATANG'  => ,
            'LAIN'             => $lain,
        ];

        if ( count($this->M_dpb->checkIsExist($data['NO_PR'])) === 0 ) {
            $this->M_dpb->insertNewDetail($data,$estDatang);
        } else {
            $id = $data['NO_PR'];
            unset($data['NO_PR']);
            $this->M_dpb->updateDetail($id, $data,$estDatang);
        }

        echo json_encode('Success!');
    }

}