<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DPBKHS extends CI_Controller {

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

		$data['Menu']           = 'DPB KHS';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DPBKHSList']     = $this->M_dpb->getDPBKHSList();
        $data['UserAccess']     = [   
            'add_data'  => 'disabled',
            'delete'    => 'disabled'
        ];

        if ( $this->session->user === 'B0445' ) {
            $data['UserAccess'] = [   
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ( $this->session->user === 'F2326' ) {
            $data['UserAccess'] = [   
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ( $this->session->user === 'J1396' ) {
            $data['UserAccess'] = [ 
                'add_data' => '',
                'delete'   => ''
            ];
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DPBKHS', $data);
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

        if ( $this->session->user === 'B0445' ) {
            $data['UserAccess'] = [   
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ( $this->session->user === 'F2326' ) {
            $data['UserAccess'] = [   
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ( $this->session->user === 'J1396' ) {
            $data['UserAccess'] = [ 
                'add_data' => '',
                'delete'   => ''
            ];
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_ListDPBKHS', $data);
        $this->load->view('V_Footer', $data);
    }

    public function detail()
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

        if ( $this->session->user === 'B0445' ) {
            $data['UserAccess'] = [   
                'add_row'    => '',
                'edit_field' => '',
                'delete_row' => '',
                'save'       => ''
            ];
        } else if ( $this->session->user === 'F2326' ) {
            $data['UserAccess'] = [   
                'add_row'    => '',
                'edit_field' => '',
                'delete_row' => '',
                'save'       => ''
            ];
        } else if ( $this->session->user === 'J1396' ) {
            $data['UserAccess'] = [   
                'add_row'    => '',
                'edit_field' => '',
                'delete_row' => '',
                'save'       => ''
            ];
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DetailDPBKHS', $data);
        $this->load->view('V_Footer', $data);
    }

    public function add()
    {
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

        $data['Menu']           = 'DPB KHS';
		$data['SubMenuOne']     = '';
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DPBKHSNew', $data);
        $this->load->view('V_Footer', $data);
    }

    public function saveNew()
    {
        if ( ! $this->input->is_ajax_request())
            redirect('ApprovalDO/DPBKHS');

        $pr_number = 'KHS'.date('Ymd');

        if ($last_pr_number = $this->M_dpb->checkPRNumber($pr_number)) {
            $array_pr_number = explode('-', $last_pr_number['NO_PR']);
            $pr_number_now   = $array_pr_number[1] + 1;
            $new_pr_number   = "{$array_pr_number[0]}-{$pr_number_now}";
        } else {
            $new_pr_number = "{$pr_number}-1";
        }

        $noind = $this->session->user;

        $data = $this->input->post();

        //cek onhand 

        $gudang = $data['header']['gudangPengirim'];

        if ($gudang == 'MLATI') {
            $kode_gudang = 'MLATI-DM';
        }elseif ($gudang == 'TUKSONO') {
            $kode_gudang = 'FG-TKS';
        }

        $line = $data['line'];

        $nomor_do = '';
        
        for ($i=0; $i < count($line); $i++) { 
            if ($nomor_do == '') {
                $nomor_do .= $line[$i]['doNumber'];
            }else {
                $nomor_do .= ','.$line[$i]['doNumber'];
            }
        }

        $returnOnhand = $this->M_dpb->checkOnhand($nomor_do,$kode_gudang);

        //end

        if ($returnOnhand[0]['STOCKONHAND'] == 0) {
            
            foreach ($data['line'] as $key => $val) {
                
                $this->M_dpb->procedureLockStock($val['doNumber'], $kode_gudang, $noind);
    
                $this->M_dpb->insertNewDetailKHS([
                    'NO_PR'            => $new_pr_number,
                    'JENIS_KENDARAAN'  => $data['header']['vehicleCategory'],
                    'NO_KENDARAAN'     => $data['header']['vehicleId'],
                    'NAMA_SUPIR'       => $data['header']['driverName'],
                    'VENDOR_EKSPEDISI' => $data['header']['driverPhone'],
                    'GUDANG_PENGIRIM'  => $data['header']['gudangPengirim'],
                    'ALAMAT_BONGKAR'   => $data['header']['alamatBongkar'],
                    'CATATAN'          => $data['header']['catatan'],
                    'LINE_NUM'         => $val['line'],
                    'DO_NUM'           => $val['doNumber'],
                    'ITEM_NAME'        => $val['itemName'],
                    'UOM'              => $val['uom'],
                    'QTY'              => $val['qty'],
                    'NAMA_TOKO'        => $val['shopName'],
                    'KOTA'             => $val['city'],
                    'APPROVED_FLAG'    => 'P'
                ]);
            }
            echo json_encode($new_pr_number);
        }else{
            echo json_encode('error stok gudang tidak mencukupi');
        }
        

    }

    public function saveUpdate()
    {
        if ( ! $this->input->is_ajax_request())
            redirect('ApprovalDO/DPBKHS');
        
        $data = $this->input->post();

        if (array_key_exists('deleteLine', $data)) {
            foreach ($data['deleteLine'] as $val) {
                $this->M_dpb->deleteDetail($data['header']['prNumber'], $val['lineNumber']);
            }
        }

        if (array_key_exists('newLine', $data)) {
            foreach ($data['newLine'] as $val) {
                $this->M_dpb->insertNewDetailKHS([
                    'NO_PR'            => $data['header']['prNumber'],
                    'JENIS_KENDARAAN'  => $data['header']['vehicleCategory'],
                    'NO_KENDARAAN'     => $data['header']['vehicleId'],
                    'NAMA_SUPIR'       => $data['header']['driverName'],
                    'VENDOR_EKSPEDISI' => $data['header']['driverPhone'],
                    'ALAMAT_BONGKAR'   => $data['header']['alamatBongkar'],
                    'CATATAN'          => $data['header']['catatan'],
                    'LINE_NUM'         => $val['lineNumber'],
                    'DO_NUM'           => $val['doNumber'],
                    'ITEM_NAME'        => $val['itemName'],
                    'UOM'              => $val['uom'],
                    'QTY'              => $val['qty'],
                    'NAMA_TOKO'        => $val['shopName'],
                    'KOTA'             => $val['city'],
                    'APPROVED_FLAG'    => 'P'
                ]);
            }
        }

        if (array_key_exists('updateLine', $data)) {
            foreach ($data['updateLine'] as $val) {
                $this->M_dpb->updateDetailKHS($data['header']['prNumber'], $val['lineNumber'], [
                    'NO_PR'            => $data['header']['prNumber'],
                    'JENIS_KENDARAAN'  => $data['header']['vehicleCategory'],
                    'NO_KENDARAAN'     => $data['header']['vehicleId'],
                    'NAMA_SUPIR'       => $data['header']['driverName'],
                    'VENDOR_EKSPEDISI' => $data['header']['driverPhone'],
                    'ALAMAT_BONGKAR'   => $data['header']['alamatBongkar'],
                    'CATATAN'          => $data['header']['catatan'],
                    'DO_NUM'           => $val['doNumber'],
                    'ITEM_NAME'        => $val['itemName'],
                    'UOM'              => $val['uom'],
                    'QTY'              => $val['qty'],
                    'NAMA_TOKO'        => $val['shopName'],
                    'KOTA'             => $val['city'],
                    'APPROVED_FLAG'    => 'P'
                ]);
            }
        }
        
        echo json_encode('Success');
    }

    public function delete()
    {
        if ( ! $this->input->is_ajax_request())
            redirect('ApprovalDO/DPBKHS');
        
        $this->M_dpb->deleteDPBKHS($this->input->post('prNumber'));

        echo json_encode('Success');
    }
    
    public function AddDetailInformationList()
    {
        $kode_do = $_GET['q'];
        $data = $this->M_dpb->AddDetailInformationList($kode_do);

        echo json_encode($data);
    }

}