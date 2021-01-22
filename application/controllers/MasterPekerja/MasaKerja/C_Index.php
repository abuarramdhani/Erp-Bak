<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class C_Index extends CI_Controller
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
    $this->load->model('MasterPekerja/MasaKerja/M_masakerja');

    $this->checkSession();
  }
  public function checkSession()
  {
    if ($this->session->is_logged) { } else {
      redirect('');
    }
  }

  public function masa_kerja()
  {
    $user = $this->session->username;

    $user_id = $this->session->userid;
    $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Masa Kerja', 'Cetak', 'Masa Kerja', '');

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/MasaKerja/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  public function GetFilter()
  {
    $tanggal = $this->input->POST('tgl');
    $kodeind = $this->input->POST('kodeind');
    $data['januck'] = $tanggal;
    $data['MasaKerja'] = $this->M_masakerja->MasaKerja($tanggal, $kodeind);

    $html = $this->load->view('MasterPekerja/MasaKerja/V_Table', $data);
    echo json_encode($html);


    // echo "<pre>";
    // print_r($data);
    // die;
  }
}
