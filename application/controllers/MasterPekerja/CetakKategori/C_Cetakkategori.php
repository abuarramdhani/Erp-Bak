<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class C_Cetakkategori extends CI_Controller
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
        $this->load->model('MasterPekerja/CetakKategori/M_cetakkategori');

        $this->checkSession();
    }
    public function checkSession()
    {
        if ($this->session->is_logged) { } else {
            redirect('');
        }
    }

    public function cetak_kategori()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;
        $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Cetak Kategori', 'Cetak', 'Cetak Kategori', '');
        $data['Tariknoind'] = $this->M_cetakkategori->GetNoinduk();
        $data['Tarikpendidikan'] = $this->M_cetakkategori->GetPendidikan();
        $data['Tarikjenkel'] = $this->M_cetakkategori->GetJenkel();
        $data['Tariklokasi'] = $this->M_cetakkategori->GetLokasi();
        $data['Tarikstatus'] = $this->M_cetakkategori->GetStatus();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('MasterPekerja/CetakKategori/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function GetKategori()
    {
        $txt = $this->input->get('term');
        $txt = strtoupper($txt);
        $txt2 = $this->input->get('term2');


        $data = $this->M_cetakkategori->GetKategori($txt, $txt2);
        echo json_encode($data);
    }

    public function GetFilter()
    {
        $kodeind = $this->input->POST('noind');
        $pend = $this->input->POST('pend');
        $jenkel = $this->input->POST('jenkel');
        $lokasi = $this->input->POST('lokasi');
        $kategori = $this->input->POST('kategori');

        $select = $this->input->POST('arrselect');
        $data['select'] = explode(', ', $select);
        $rangekeluarstart = $this->input->POST('rangekeluarstart');
        $rangekeluarend = $this->input->POST('rangekeluarend');
        $rangemasukstart = $this->input->POST('rangemasukstart');
        $rangemasukend = $this->input->POST('rangemasukend');
        $status = $this->input->POST('status');
        $data['masakerja'] = "," . $this->input->POST('masakerja');
        $masakerja = $this->input->POST('masakerja');

        $data['FilterAktif'] = $this->M_cetakkategori->GetFilter($kodeind, $pend, $jenkel,  $lokasi, $kategori, $select, $rangekeluarstart, $rangekeluarend,  $rangemasukstart, $rangemasukend, $status, $masakerja);
        $html = $this->load->view('MasterPekerja/CetakKategori/V_Table', $data);
        echo json_encode($html);
    }
}
