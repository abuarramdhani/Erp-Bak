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
    $this->load->model('MasterPekerja/PekerjaPuasa/M_pekerjapuasa');

    $this->checkSession();
  }
  public function checkSession()
  {
    if ($this->session->is_logged) { } else {
      redirect('');
    }
  }

  public function pekerja_puasa()
  {
    $user = $this->session->username;

    $user_id = $this->session->userid;
    $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Pekerja Puasa', 'Cetak', 'Pekerja Puasa', '');

    $data['Pekerja'] = $this->M_pekerjapuasa->getPekerjaAll();
    $data['Pekerjanonshift'] = $this->M_pekerjapuasa->getPekerjaNonShift();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/PekerjaPuasa/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }
}
