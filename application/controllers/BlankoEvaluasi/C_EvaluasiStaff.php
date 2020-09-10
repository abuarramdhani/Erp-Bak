<?php

defined('BASEPATH') or die("This is cannot be opened");

class C_EvaluasiStaff extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('BlankoEvaluasi/M_blankoevaluasi');

        $this->checkSession();
    }

    private function checkSession()
    {
        if ($this->session->userdata('is_logged') != true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
            redirect();
        }
    }

    private function getStaffBlanko()
    {
        return $this->M_blankoevaluasi->getStaffBlanko()->result_array();
    }

    function index()
    {
        $user_id = $this->session->userid;

        $data['Menu'] = 'Staff';
        $data['SubMenuOne'] = '';
        $data['Title'] = 'Staff';
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $dataBlanko = $this->getStaffBlanko();
        $data['blanko'] = $dataBlanko;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BlankoEvaluasi/Staff/V_Staff');
        $this->load->view('BlankoEvaluasi/V_Footer', $data);
    }

    function create()
    {
        $user_id = $this->session->userid;

        $data['Menu'] = 'Staff';
        $data['SubMenuOne'] = '';
        $data['Title'] = 'Staff';
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $staff = $this->M_blankoevaluasi->getStaffWorker(true); // true = with filter kodesie

        $data['workers'] = $staff;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BlankoEvaluasi/Staff/V_Staff_Create', $data);
        $this->load->view('BlankoEvaluasi/V_Footer', $data);
    }

    function blanko()
    {
        $id = $this->input->get('id');
        if (!$id) redirect(base_url('BlankoEvaluasi/Staff'));

        // decrypt base64
        $decryptId = base64_decode($id);
        $staffBlanko = $this->M_blankoevaluasi->getStaffBlanko($decryptId)->row();

        if (!$staffBlanko) {
            return $this->load->view('BlankoEvaluasi/V_Blanko_404');
        }

        $data = [
            'worker' => [
                'noind' =>  $staffBlanko->noind,
                'nama' =>  $staffBlanko->nama,
                'seksi' =>  $staffBlanko->seksi,
                // 'kodesie' =>  $staffBlanko->kodesie,
                'kd_jabatan' =>  $staffBlanko->kd_jabatan,
                'jabatan' =>  $staffBlanko->jabatan,
                'akhir_kontrak' =>  $staffBlanko->akhir_kontrak,
                'status_jabatan' =>  $staffBlanko->status,
            ],
            'atasan' => $staffBlanko->penilaian_atasan,
            'usulan' => $staffBlanko->usulan,
            'approval0' => $staffBlanko->approval_0 ?: '',
            'approval1' => $staffBlanko->approval_1,
            'approval2' => $staffBlanko->approval_2,
            'approval3' => $staffBlanko->approval_3,

        ];

        $this->printPDF($data);
    }

    function store()
    {
        $get = $this->input->get();

        if (!$get) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $parsedGet = [
            'noind' => $get['worker']['noind'],
            'nama' => $get['worker']['nama'],
            'kodesie' => $get['worker']['kodesie'],
            'seksi' => $get['worker']['seksi'],
            'status' => $get['worker']['status_jabatan'],
            'jabatan' => $get['worker']['jabatan'],
            'akhir_kontrak' => $get['worker']['akhir_kontrak'],
            'penilaian_atasan' => $get['atasan'],
            'approval_0' => $get['approval0'],
            'approval_1' => $get['approval1'],
            'approval_2' => $get['approval2'],
            'approval_3' => $get['approval3'],
            'created_by' => $this->session->user,
            'usulan' => intval($get['usulan']),
        ];

        $this->insertBlanko($parsedGet);
        redirect(base_url('BlankoEvaluasi/Staff'));
    }

    function deleteBlanko()
    {
        $logged_user = $this->session->user;
        $id = $this->input->post('id');
        $id = (int)base64_decode($id);
        if ($id <= 0) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->M_blankoevaluasi->deleteStaffBlanko($id, $logged_user);
        redirect($_SERVER['HTTP_REFERER']);
    }

    private function insertBlanko($data = [])
    {
        if (!$data) return [];

        $this->M_blankoevaluasi->insertStaffBlanko($data);
    }

    function handlePrintPeview()
    {
        $get = $this->input->get();

        $this->printPDF($get);
    }

    private function printPDF($data)
    {
        $this->load->library('pdf');

        $pdf =    $this->pdf->load();
        // params => $mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P'
        $pdf = new mPDF('UTF-8', 'A4', '11', 'comic', 10, 10, 10, 10, 0, 0);

        $title = 'Evaluasi Staff';
        $filename = 'Evalasi kontrak Staff';
        $tkpw_kode = 20;
        // if not TKPW
        if ($data['worker']['kd_jabatan'] != $tkpw_kode) {
            $content = $this->load->view('BlankoEvaluasi/Staff/V_Template_Pdf_Staff', $data, true);
        } else {
            // if TKPW load other content
            $content = $this->load->view('BlankoEvaluasi/Staff/V_Template_Pdf_TKPW', $data, true);
        }

        $pdf->AddPage('P');
        $pdf->SetTitle($title);
        $pdf->WriteHTML($content);
        $pdf->Output($filename, 'I');
    }
}
