<?php defined('BASEPATH') or exit('No direct script access allowed');

class C_Index extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('M_index');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('SystemIntegration/KaizenTks/M_kaizentks');

    $this->checkSession();
    $this->userid = $this->session->userid;
  }

  public function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('index');
    }
  }

  public function index()
  {
    $data['Title']        =  'Kaizen Pekerja Tuksono';
    $data['Header']       =  'Input Kaizen Pekerja Tuksono';
    $data['Menu']         =  'Export Kaizen';
    $data['SubMenuOne']   =  'Tahunan';
    $data['SubMenuTwo']   =  '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->userid, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/Export/V_Tahunan', $data);
    $this->load->view('V_Footer', $data);
  }
}
