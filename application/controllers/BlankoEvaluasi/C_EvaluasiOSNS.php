<?php
/* 
    about controller name
    > Evaluasi Outsourcing and Non-Staff
*/

defined('BASEPATH') or exit('you cannot enter here');

//helper
function month($num)
{
    if ($num > 12) return 'unknown';
    $indoMonth = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return $indoMonth[$num - 1];
}

class C_EvaluasiOSNS extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_Index');
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

    function index()
    {
        $user_id = $this->session->userid;

        $data['Menu'] = 'Non-Staff & OS';
        $data['SubMenuOne'] = '';
        $data['Title'] = 'Non-Staff & OS';
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $dataBlanko = $this->getBlanko();
        $data['blanko'] = $dataBlanko;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BlankoEvaluasi/NonStaff/V_NonStaffOS');
        $this->load->view('BlankoEvaluasi/V_Footer', $data);
    }

    function create()
    {
        $user_id = $this->session->userid;

        $data['Menu'] = 'Non-Staff & OS';
        $data['SubMenuOne'] = '';
        $data['Title'] = 'Non-Staff & OS';
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('BlankoEvaluasi/NonStaff/V_NonStaffOS_Create');
        $this->load->view('BlankoEvaluasi/V_Footer', $data);
    }

    function blanko()
    {
        $encryptId = $this->input->get('id');

        if (!$encryptId) {
            redirect(base_url(('BlankoEvaluasi/NonStaff')));
        }
        $decryptId = base64_decode($encryptId);
        $data = $this->getBlankoById($decryptId);

        if (!$data) {
            return $this->load->view('BlankoEvaluasi/V_Blanko_404');
        }

        $staff = ['J', 'G'];
        $nonstaff = ['H', 'T'];
        $os = ['K', 'P'];

        $position = null;
        if (in_array(substr($data->noind, 0, 1), $staff)) {
            $position = 'staff';
        } else if (in_array(substr($data->noind, 0, 1), $nonstaff)) {
            $position = 'nonstaff';
        } else {
            $position = 'os';
        }

        $TIMS = $this->M_blankoevaluasi->getTIMS($data->noind, $data->tanggal_awal, $data->tanggal_akhir);
        $TIMS['presensi_ok'] = $this->M_blankoevaluasi->calculationTIMS($data->noind, $data->tanggal_awal, $data->tanggal_akhir, $position);
        $sp = $this->getSP($data->noind, $data->tanggal_awal, $data->tanggal_akhir);

        // rewrite index
        $data = array(
            'worker' => [
                'noind' => $data->noind,
                'nama' => $data->nama,
                'seksi' => $data->seksi,
                'kd_jabatan' => $data->kd_jabatan,
                'pekerjaan' => $data->pekerjaan,
                'masa_kerja' => $data->masa_kerja,
                'akhir_kontrak' => $data->akhir_kontrak,
                'periode_awal' => $data->tanggal_awal,
                'periode_akhir' => $data->tanggal_akhir,
                'jabatan' => $position
            ],
            'sp' => $sp,
            'tims' => $TIMS,
            'two' => json_decode($data->nilai, true),
            'three' => json_decode($data->program, true),
            'four' => [
                'penilai' => '',
                'supervisor' => $data->supervisor,
                'kasie' => $data->kasie,
                'usulan' => $data->usulan,
                'unit' => $data->unit,
                'dept' => $data->departemen
            ]
        );

        $this->printPDF($data);
    }

    function deleteBlanko()
    {
        $logged_user = $this->session->user;
        $id = $this->input->post('id');
        $id = (int)base64_decode($id);
        if ($id <= 0) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->M_blankoevaluasi->deleteNonStaffBlanko($id, $logged_user);
        redirect($_SERVER['HTTP_REFERER']);
    }

    function store()
    {
        $data = $this->input->get();

        $this->insertBlanko($data);
        redirect(base_url('BlankoEvaluasi/NonStaff'));
    }

    function handlePrintPreview()
    {
        $data = $this->input->get();

        $staff = ['14', '16'];
        $nonstaff = ['15', '17'];
        $os = ['18'];

        $position = null;
        if (in_array($data['worker']['kd_jabatan'], $staff)) {
            $position = 'staff';
        } else if (in_array($data['worker']['kd_jabatan'], $nonstaff)) {
            $position = 'nonstaff';
        } else {
            $position = 'os';
        }

        $TIMS = $this->M_blankoevaluasi->getTIMS(
            $data['worker']['noind'],
            $data['worker']['periode_awal'],
            $data['worker']['periode_akhir']
        );

        $TIMS['presensi_ok'] = $this->M_blankoevaluasi->calculationTIMS(
            $data['worker']['noind'],
            $data['worker']['periode_awal'],
            $data['worker']['periode_akhir'],
            $position
        );
        $sp = $this->getSP($data['worker']['noind'], $data['worker']['periode_awal'], $data['worker']['periode_akhir']);

        // calc
        function sum($now, $next)
        {
            return (int)$now + (int)$next;
        }

        $nilaiAspek = array_map(function ($val) {
            return $val['skor'];
        }, $data['two']['nilai']);

        $totalAspek = array_reduce($nilaiAspek, 'sum');
        $avg = $totalAspek / 5;
        // calc

        // assign to $data
        $data['tims'] = $TIMS;
        $data['worker']['jabatan'] = $position;
        $data['worker']['akhir_kontrak'] = date('d-m-Y', strtotime($data['worker']['akhir_kontrak']));
        $data['sp'] = $sp;
        $data['two']['total'] = $totalAspek;
        $data['two']['avg'] = $avg;

        $this->printPDF($data);
    }

    function insertBlanko($params)
    {
        if (!$params) return false;

        // calc
        function sumx($now, $next)
        {
            return (int)$now + (int)$next;
        }

        $nilaiAspek = array_map(function ($val) {
            return $val['skor'];
        }, $params['two']['nilai']);

        $totalAspek = array_reduce($nilaiAspek, 'sumx');
        $avg = $totalAspek / 5;
        // calc

        // assign to $data
        $params['two']['total'] = $totalAspek;
        $params['two']['avg'] = $avg;

        $worker = $params['worker'];
        $nilai = json_encode($params['two']);
        $program = json_encode($params['three']);
        $atasan = $params['four'];

        $parsedArray = array(
            'noind' => $worker['noind'],
            'tanggal_awal' => date('Y-m-d', strtotime($worker['periode_awal'])),
            'tanggal_akhir' => date('Y-m-d', strtotime($worker['periode_akhir'])),
            'nama' => $worker['nama'],
            'pekerjaan' => $worker['pekerjaan'],
            'masa_kerja' => $worker['masa_kerja'],
            'akhir_kontrak' => date('Y-m-d', strtotime($worker['akhir_kontrak'])),
            'presensi_ok' => true,
            'nilai' => $nilai,
            'program' => $program,
            'supervisor' => $atasan['supervisor'],
            'kasie' => $atasan['kasie'],
            'unit' => $atasan['unit'],
            'departemen' => $atasan['dept'],
            'created_by' => $this->session->user,
            // 'created_time' =>
            'seksi' => $worker['seksi'],
            'usulan' => $atasan['usulan']
        );

        $this->M_blankoevaluasi->insertBlanko($parsedArray);
    }

    private function dateToIndo($date)
    {
        if (!$date) return null;

        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));

        return month($month) . " " . $year;
    }

    private function getSP($noind, $from, $to)
    {
        $sp = $this->M_blankoevaluasi->getSP($noind, $from, $to);

        $roman_number = [
            '1' => 'I',
            '2' => 'II',
            '3' => 'III',
            '4' => 'IV'
        ];

        $sp = array_map(function ($item) use ($roman_number) {
            return array(
                'ke'    => $item['sp_ke'],
                'bulan' => $this->dateToIndo($item['awal']),
                'jenis' => $item['jenis'],
                'ket'   => $item['ket']
            );
        }, $sp);

        return $sp;
    }

    private function getBlanko()
    {
        $data = $this->M_blankoevaluasi->getBlanko()->result_array();
        return $data;
    }


    private function getBlankoById($id)
    {
        $id = intval($id);
        if (!$id) return [];
        $data = $this->M_blankoevaluasi->getBlanko($id)->row();
        return $data;
    }

    private function getTIMS($noind, $awal, $akhir)
    {
        if (!$noind || !$awal || $akhir) throw "Error params failed";
        $data = $this->M_blankoevaluasi->getBlanko()->result_array();
    }

    private function printPDF($data)
    {
        $this->load->library('pdf');

        $pdf =    $this->pdf->load();
        // params => $mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P'
        $pdf = new mPDF('UTF-8', 'A4', '8', 'Arial', 5, 5, 5, 5, 0, 0, 'L');

        $title = 'Evaluasi';
        $filename = 'Evalasi kontrak';
        $content = $this->load->view('BlankoEvaluasi/NonStaff/V_Template_Pdf', $data, true);

        $pdf->defaultfooterline = false;
        $pdf->setFooter("
        <div style='text-align: left; font-weight: 100;'>
        <small style='font-size: 10px; float: left; font-style: italic;'>Halaman ini dicetak melalui QuickERP - (Blanko Evaluasi) - " . date('d-m-Y H:i:s') . " oleh {$this->session->user} - {$this->session->employee}</small>
        </div>
        ");
        $pdf->AddPage('L');
        $pdf->SetTitle($title);
        $pdf->WriteHTML($content);
        // $pdf->SetDisplayPreferences('/FullScreen');
        $pdf->Output($filename, 'I');
    }
}
