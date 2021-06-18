<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set("memory_limit", "-1");

class C_infoPasar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('M_Index');
        $this->load->model('LaporanPenjualanTraktor/M_pusat');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        if ($this->session->userdata('logged_in') != TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect();
        }
    }

    public function index($cabang)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['data'] = $this->M_pusat->getReportCabangAndMonth($cabang, date('m'));

        if ($data['data']['MARKET_DESC'] != '' && $data['data']['ATTACHMENT'] != '') {
            $pathimg = explode(',', $data['data']['ATTACHMENT']);

            $filename = array();
            foreach ($pathimg as $value) {
                $explodepath = explode('/', $value);
                $filename[] = end($explodepath);
            }

            $data['filename'] = $filename;
        }

        $data['cabang'] = $cabang;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanPenjualanTraktor/Cabang/V_infoPasar', $data);
        $this->load->view('V_Footer', $data);
    }

    public function inputInfoPasar()
    {
        $info = $this->input->post('value-info-pasar-lpt');
        $cabang = $this->input->post('cabang-input-lpt');
        $reportid = $this->input->post('reportid-input-lpt');
        $attachment = $_FILES['input-attachment-market-info-lpt'];
        $jumlahfile = count($attachment['name']);

        $array = array();

        for ($i = 0; $i < $jumlahfile; $i++) {
            $_FILES['file']['name'] = $attachment['name'][$i];
            $_FILES['file']['type'] = $attachment['type'][$i];
            $_FILES['file']['tmp_name'] = $attachment['tmp_name'][$i];
            $_FILES['file']['error'] = $attachment['error'][$i];
            $_FILES['file']['size'] = $attachment['size'][$i];

            if ($attachment['name'][$i] != NULL) {
                $config['upload_path'] = './assets/upload/LaporanPenjualanTR2/InfoPasar';
                $config['allowed_types'] = 'xls|xlsx|jpg|jpeg|png';
                $config['max_size']    = '10000';

                $this->load->library('upload', $config);

                if (!is_dir('./assets/upload/LaporanPenjualanTR2/InfoPasar/')) {
                    mkdir('./assets/upload/LaporanPenjualanTR2/InfoPasar/', 0777, true);
                    chmod('./assets/upload/LaporanPenjualanTR2/InfoPasar/', 0777);
                }

                if ($this->upload->do_upload('file')) {
                    $dataarray = $this->upload->data();

                    $array[] = $dataarray;
                }
            }
        }

        $this->insertInfoPasar($reportid, $info, $array);
        redirect(base_url('laporanPenjualanTR2/Cabang/' . $cabang . '/inputInfoPasar'));
    }

    public function insertInfoPasar($reportid, $info, $filename)
    {
        $pathimg = '';
        foreach ($filename as $value) {
            $pathimg = $pathimg . $value['upload_path'] . ',';
        };

        $pathimg = rtrim($pathimg, ",");

        $this->M_pusat->insertInfoPasar((int)$reportid, $info, $pathimg);
    }

    public function editInfoPasar()
    {
        $info = $this->input->post('value-info-pasar-lpt');
        $cabang = $this->input->post('cabang-input-lpt');
        $reportid = $this->input->post('reportid-input-lpt');

        $this->M_pusat->editInfoPasar($info, $reportid);

        redirect(base_url('laporanPenjualanTR2/Cabang/' . $cabang . '/inputInfoPasar'));
    }

    public function editFileInfoPasar()
    {
        $cabang = $this->input->post('cabang-input-lpt');
        $reportid = $this->input->post('reportid-input-lpt');
        $attachment = $_FILES['input-attachment-market-info-lpt'];
        $jumlahfile = count($attachment['name']);

        $array = array();

        for ($i = 0; $i < $jumlahfile; $i++) {
            $_FILES['file']['name'] = $attachment['name'][$i];
            $_FILES['file']['type'] = $attachment['type'][$i];
            $_FILES['file']['tmp_name'] = $attachment['tmp_name'][$i];
            $_FILES['file']['error'] = $attachment['error'][$i];
            $_FILES['file']['size'] = $attachment['size'][$i];

            if ($attachment['name'][$i] != NULL) {
                $config['upload_path'] = './assets/upload/LaporanPenjualanTR2/InfoPasar';
                $config['allowed_types'] = 'xls|xlsx|jpg|jpeg|png';
                $config['max_size']    = '10000';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $dataarray = $this->upload->data();

                    $array[] = $dataarray;
                } else {
                    $error = array('error' => $this->upload->display_errors());
                    echo '<pre>';
                    print_r($error);
                    die;
                }
            }
        }

        $pathimg = '';
        foreach ($array as $value) {
            $pathimg = $pathimg . $value['upload_path'] . ',';
        };

        $pathimg = rtrim($pathimg, ",");

        $this->M_pusat->editFileInfoPasar((int)$reportid, $pathimg);

        redirect(base_url('laporanPenjualanTR2/Cabang/' . $cabang . '/inputInfoPasar'));
    }
}