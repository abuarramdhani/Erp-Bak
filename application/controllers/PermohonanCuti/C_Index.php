<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class C_Index extends CI_Controller
{

	function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->helper('file');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');

    $this->load->model('SystemAdministration/MainMenu/M_user');
		//------cek hak akses halaman-------//
		$this->load->library('access');
		$this->access->page();
		//---------------^_^----------------//
    $this->checkSession();
  }

  public function checkSession()
  {
    if(!$this->session->is_logged){
      redirect('');
    }
  }

  public function index(){
    $user_id = $this->session->userid;

    $data['Title'] = 'Permohonan Cuti';
    $data['Menu'] = 'Permohonan Cuti';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('PermohonanCuti/V_Index',$data);
    $this->load->view('V_Footer',$data);

  }
}
