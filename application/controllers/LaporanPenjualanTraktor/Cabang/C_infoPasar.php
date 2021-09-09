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

        $data['info_target'] = $this->M_pusat->getInfoTargetCabangAndMonth($cabang, date('m-Y'));
        $data['info_month'] = $this->M_pusat->getInfoTargetMonth($cabang);
        $data['info_today'] = $this->M_pusat->getInfoTargetToday(date('d-m-Y'), $cabang);

        $data['cabang'] = $cabang;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanPenjualanTraktor/Cabang/V_infoPasar', $data);
        $this->load->view('V_Footer', $data);
    }

    public function inputInfoPasar()
    {

        $info = $this->input->post('info');
        $cabang = $this->input->post('cabang');
        $path = $this->input->post('path');

        $info = str_replace("'", "''", $info);

        $this->M_pusat->insertInfoPasar($info, $cabang, $path);
    }

    public function inputFileInfoPasar()
    {
        $config['upload_path'] = './assets/upload/LaporanPenjualanTR2/InfoPasar';
        $config['allowed_types'] = 'xls|xlsx|jpg|jpeg|png';
        $config['max_size']    = '10000';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $path = base_url() . 'assets/upload/LaporanPenjualanTR2/InfoPasar' . '/' . str_replace(' ', '_', $_FILES['file']['name']);
            echo json_encode($path);
        } else {
            echo json_encode('');
        }
    }

    public function editInfoPasar()
    {
        $info = $this->input->post('info');
        $cabang = $this->input->post('cabang');
        $path = $this->input->post('path');
        $status = $this->input->post('status');

        $info = str_replace("'", "''", $info);

        if ($path == '') {
            if ($status == '1') {
                $this->M_pusat->editInfoPasarAndFile($cabang, $info, $path);
            } else {
                $this->M_pusat->editInfoPasar($info, $cabang);
            }
        } else {
            $this->M_pusat->editInfoPasarAndFile($cabang, $info, $path);
        }
    }

    public function viewInfoPasar($cabang, $id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['infoPasar'] = $this->M_pusat->getViewInfoPasar($id);
        $data['cabang'] = $cabang;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanPenjualanTraktor/Cabang/V_viewInfoPasar', $data);
        $this->load->view('V_Footer', $data);
    }

    public function lastWeekHistory($cabang)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['history'] = $this->M_pusat->getHistoryMarketInfo($cabang);
        $data['namaMenu'] = 'infoPasar';

        $data['cabang'] = $cabang;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanPenjualanTraktor/Cabang/V_viewHistory', $data);
        $this->load->view('V_Footer', $data);
    }

    public function viewHistory($cabang, $id)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['data'] = $this->M_pusat->getViewInfoPasar($id);
        $data['namaMenu'] = 'History Info Pasar';
        $data['cabang'] = $cabang;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanPenjualanTraktor/Cabang/V_viewDetailHistory', $data);
        $this->load->view('V_Footer', $data);
    }
}