<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DPBListPR extends CI_Controller {

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

		$data['Menu']           = 'List PR';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBVendorList']  = $this->M_dpb->getPRList();
        // echo '<pre>';
        // print_r($data['DPBVendorList']);exit;
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DPBPR', $data);
        $this->load->view('V_Footer', $data);
    }

    public function detail()
    {
        if ( ! $data['NO_PR'] = $this->input->post('data-pr') ) {
            redirect('ApprovalDO/ListPR');
        }

        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['Menu']            = 'List PR';
		$data['SubMenuOne']      = '';
		$data['UserMenu']        = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne']  = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo']  = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBVendorDetail'] = $this->M_dpb->getDPBVendorDetail($data['NO_PR']);
        $data['UserAccess']      = [   
            'jenis_kendaraan'  => 'readonly',
            'no_kendaraan'     => 'readonly',
            'nama_supir'       => 'readonly',
            'kontak_supir'     => 'readonly',
            'vendor_ekspedisi' => 'readonly',
            'estimasi_datang'  => 'readonly',
            'lain_lain'        => 'readonly',
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
                    'alamat_bongkar'   => 'readonly',
                    'catatan'          => 'readonly',
                    'estdate'          => 'ADOEstDatang'
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
        $this->load->view('ApprovalDO/MainMenu/V_DetailDPBPR', $data);
        $this->load->view('V_Footer', $data);
    }

    public function saveDetail()
    {        
        if ( ! $this->input->is_ajax_request() ) {
            redirect('ApprovalDO/ListPR');
        }

        $noind = $this->session->user;

        $tglKirim = $this->input->post('tglKirim');

        $tgl_kirim = date("Y-m-d", strtotime($tglKirim));

        $data = [
            'NO_PR'            => $this->input->post('prNumber'),
            'JENIS_KENDARAAN'  => $this->input->post('vehicleCategory'),
            'NO_KENDARAAN'     => $this->input->post('vehicleId'),
            'NAMA_SUPIR'       => $this->input->post('driverName'),
            'VENDOR_EKSPEDISI' => $this->input->post('driverPhone'),
            'GUDANG_PENGIRIM'  => $this->input->post('gudangPengirim'),
            'ALAMAT_BONGKAR'   => $this->input->post('alamatBongkar'),
            'CATATAN'          => $this->input->post('catatan'),
            'CREATED_BY'       => $noind,
        ];

        if ( count($this->M_dpb->checkIsExist($data['NO_PR'])) === 0 ) {
            $this->M_dpb->insertNewDetailListPR1($data,$tgl_kirim);
        } else {
            $id = $data['NO_PR'];
            unset($data['NO_PR']);
            $this->M_dpb->updateDetailListPR1($id, $data, $tgl_kirim);
        }

        echo json_encode('Success!');
    }

}