<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class C_Namaaktif extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('file');

        $this->load->library('Log_Activity');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('upload');
        $this->load->library('general');

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MasterPekerja/NamaAktif/M_namaaktif');

        $this->checkSession();
    }
    public function checkSession()
    {
        if ($this->session->is_logged) { } else {
            redirect('');
        }
    }

    public function nama_aktif()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;
        $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Nama Aktif', 'Cetak', 'Daftar Nama Aktif', '');

        $data['NamaAktif'] = $this->M_namaaktif->GetNoinduk();
        $data['LokasiKerja'] = $this->M_namaaktif->GetLokasikerja();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MasterPekerja/NamaAktif/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }
    public function GetIsiRadio()
    {
        $txt = $this->input->get('term');
        $txt = strtoupper($txt);
        $txt2 = $this->input->get('term2');


        $data = $this->M_namaaktif->GetIsiRadio($txt, $txt2);
        echo json_encode($data);
    }

    public function viewAll()
    {
        $kodeinduk = $this->input->get('kodeinduk');
        $kodesie = $this->input->get('kategori');
        $lokasi = $this->input->get('lokasi');
        $tanggal = $this->input->get('tanggal');


        $data['FilterAktif'] = $this->M_namaaktif->viewAll($kodeinduk, $kodesie, $lokasi, $tanggal);
        $html = $this->load->view('MasterPekerja/NamaAktif/V_Table', $data);
        echo json_encode($html);
    }
}
