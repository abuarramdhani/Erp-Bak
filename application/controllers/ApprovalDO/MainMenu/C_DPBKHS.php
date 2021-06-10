<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_DPBKHS extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->checkSession();
        $this->load->model('ApprovalDO/M_dpb');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }

    private function checkSession()
    {
        if (!$this->session->is_logged) {
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

        if ($this->session->user === 'B0445' || $this->session->user === 'H7611' || $this->session->user === 'H6843' || $this->session->user === 'H6968' || $this->session->user === 'K1778' || $this->session->user === 'A2146') {
            $data['UserAccess'] = [
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ($this->session->user === 'F2326') {
            $data['UserAccess'] = [
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ($this->session->user === 'J1396') {
            $data['UserAccess'] = [
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ($this->session->user === 'B0661') {
            $data['UserAccess'] = [
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ($this->session->user === 'T0017') {
            $data['UserAccess'] = [
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ($this->session->user === 'B0854') {
            $data['UserAccess'] = [
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ($this->session->user === 'B0860') {
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

        if ($this->session->user === 'B0445' || $this->session->user === 'H7611' || $this->session->user === 'H6843' || $this->session->user === 'H6968' || $this->session->user === 'K1778') {
            $data['UserAccess'] = [
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ($this->session->user === 'F2326') {
            $data['UserAccess'] = [
                'add_data' => '',
                'delete'   => ''
            ];
        } else if ($this->session->user === 'J1396') {
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
        if (!$data['NO_PR'] = $this->input->post('data-pr')) {
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

        if ($this->session->user === 'B0445' || $this->session->user === 'H7611' || $this->session->user === 'H6843' || $this->session->user === 'H6968' || $this->session->user === 'K1778') {
            $data['UserAccess'] = [
                'add_row'    => '',
                'edit_field' => '',
                'delete_row' => '',
                'save'       => ''
            ];
        } else if ($this->session->user === 'F2326') {
            $data['UserAccess'] = [
                'add_row'    => '',
                'edit_field' => '',
                'delete_row' => '',
                'save'       => ''
            ];
        } else if ($this->session->user === 'J1396') {
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
        if (!$this->input->is_ajax_request())
            redirect('ApprovalDO/DPBKHS');

        $pr_number = 'KHS' . date('Ymd');

        if ($last_pr_number = $this->M_dpb->checkPRNumber($pr_number)) {
            $array_pr_number = explode('-', $last_pr_number['NO_PR']);
            $pr_number_now   = $array_pr_number[1] + 1;
            $new_pr_number   = "{$array_pr_number[0]}-{$pr_number_now}";
        } else {
            $new_pr_number = "{$pr_number}-1";
        }

        $noind = $this->session->user;

        $data = $this->input->post();

        // echo "<pre>";
        // print_r($data);
        // exit();

        //cek onhand

        $gudang = $data['header']['gudangPengirim'];

        $tgl_kirim = $data['header']['tgl_kirim'];

        $estDatang = $data['header']['estDatang'];

        // echo "<pre>";
        // print_r($tgl_kirim);
        // print_r($estDatang);
        // exit();

        if ($gudang == 'MLATI') {
            $kode_gudang = 'MLATI-DM';
            $org_id = 102;
        } elseif ($gudang == 'TUKSONO') {
            $org_id = 102;
            $kode_gudang = 'FG-TKS';
        } elseif ($gudang == 'PUSAT') {
            $org_id = 102;
            $kode_gudang = 'FG-DM';
        } elseif ($gudang == 'JAKARTA') {
            $org_id = 207;
            $kode_gudang = 'FG-JFG';
        }

        $line = $data['line'];

        $nomor_do = '';

        for ($i = 0; $i < count($line); $i++) {
            if ($nomor_do == '') {
                $nomor_do .= $line[$i]['doNumber'];
            } else {
                $nomor_do .= ',' . $line[$i]['doNumber'];
            }
        }

        // $org_id = $data['header']['org_id'];


        $returnOnhand = $this->M_dpb->checkOnhand($nomor_do, $kode_gudang, $org_id);

        //end

        if ($returnOnhand[0]['STOCKONHAND'] == 0) {

            $returnLineStatus = $this->M_dpb->checkLineStatus($nomor_do, $kode_gudang, $org_id);

            if ($returnLineStatus[0]['LINESTATUS'] == 0) {
                foreach ($data['line'] as $key => $val) {

                    $this->M_dpb->procedureLockStock($val['doNumber'], $kode_gudang, $noind, $org_id);

                    $this->M_dpb->insertNewDetailKHS($tgl_kirim, $estDatang, [
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
            } else if ($returnLineStatus[0]['LINESTATUS'] == 77777) {
                echo json_encode('error ada do/spb bukan ODM');
            } else if ($returnLineStatus[0]['LINESTATUS'] == 99999) {
                echo json_encode('error alamat belum lengkap');
            } else {
                echo json_encode('error ada do/spb yang transact');
            }
        } else {
            echo json_encode('error stok gudang tidak mencukupi');
        }
    }

    public function saveUpdate()
    {
        if (!$this->input->is_ajax_request())
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
        if (!$this->input->is_ajax_request())
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
    public function cekOrgID()
    {
        $reqNum = $_POST['value'];
        $data = $this->M_dpb->cekOrgID($reqNum);

        echo json_encode($data[0]['ORGANIZATION_ID']);
    }
}
