<?php defined('BASEPATH') or exit('No direct script access allowed');

class C_CetakMemoHasilOrientasi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Log_Activity');
        $this->load->library('General');
        $this->load->library('pdf');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('Personalia');

        $this->dabes = $this->load->database('personalia', TRUE);
        $this->load->model('ADMSeleksi/M_cetakmemohasilorientasi');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('ADMSeleksi/M_penyerahan');

        date_default_timezone_set('Asia/Jakarta');
        $this->checkSession();
    }

    public function checkSession()
    {
        if (!($this->session->is_logged)) {
            redirect('');
        }
    }

    public function index()
    {
        $user_id = $this->session->userid;

        $data['Title'] = 'Cetak Memo Hasil Orientasi';
        $data['Menu'] = 'Cetak Memo Hasil Orientasi';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['getDaftarMemo'] = $this->M_cetakmemohasilorientasi->getDaftarMemo();
        $data['getDaftarNilai'] = $this->M_cetakmemohasilorientasi->getDaftarNilai();
        $data['getMateri'] = $this->M_cetakmemohasilorientasi->getMateri();

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ADMSeleksi/Cetak/V_Cetak_Memo_Hasil_Orientasi', $data);
        $this->load->view('V_Footer', $data);
    }

    public function get_refresh_data_memo()
    {
        $data = $this->M_cetakmemohasilorientasi->getDaftarMemo();

        $this->load->view('ADMSeleksi/Cetak/V_Cetak_Memo_Refresh_Table', ['getDaftarMemo' => $data]);
    }

    public function get_daftar_memo()
    {
        $kdmemo = $this->input->get('kdmemo');
        $data = $this->M_cetakmemohasilorientasi->getDaftarMemoWithParam($kdmemo);

        echo json_encode(array(
            'success' => true,
            'data' => $data
        ));
    }

    public function search_daftar_memo()
    {
        $year = $this->input->get('year');
        $data = $this->M_cetakmemohasilorientasi->searchDaftarMemoWithParam($year);

        // html
        $this->load->view('ADMSeleksi/Cetak/V_Table_Cetak_Memo_Hasil_Orientasi', [
            'getDaftarMemo' => $data
        ]);

        // json
        // echo json_encode(array(
        //     'success' => true,
        //     'data' => $data
        // ));
    }

    public function get_daftar_nilai()
    {
        $kdmemo = $this->input->get('kdmemo');
        $data = $this->M_cetakmemohasilorientasi->getDaftarNilaiWithParam($kdmemo);

        echo json_encode(array(
            'success' => true,
            'data' => $data
        ));
    }

    public function export_pdf()
    {
        $kdmemo = $this->input->get('kdmemo');
        $nilai = $this->M_cetakmemohasilorientasi->getDaftarNilaiWithParam($kdmemo);
        $memo = $this->M_cetakmemohasilorientasi->getDaftarMemoWithParam($kdmemo);
        $materi = $this->M_cetakmemohasilorientasi->getMateri();

        if ($memo[0]['cetak'] == 'f') {
            $this->M_cetakmemohasilorientasi->updateCetak($kdmemo);
        }
        // print "<pre>";
        // print_r($memo);
        // die;

        $this->load->library('pdf');

        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf8', "A4", 10, '', 12, 12, 28, 10, 0, 0);

        $date = $this->M_cetakmemohasilorientasi->tgl_indo1($memo[0]['tanggal']);
        // print "<pre>";
        // print_r('disini : ' . $date);
        // die;
        $html = $this->load->view(
            'ADMSeleksi/Cetak/V_Cetak_Nilai_Memo_PDF',
            [
                'dataMemo' => $memo,
                'dataNilai' => $nilai,
                'dataMateri' => $materi,
                'dateSurat' => $date
            ],
            true
        );

        $pdf->WriteHTML($html);
        $fileformat = ".pdf";
        $filename = 'RptNilaiMemoOrientasi.pdf';

        $pdf->text_input_as_HTML = true;
        $pdf->setTitle($filename);
        $pdf->Output($filename, 'I');
    }
}
