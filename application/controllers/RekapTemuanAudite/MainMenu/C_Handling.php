<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Handling extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->library('form_validation');
    $this->load->library('encrypt');
    //load the login model
    $this->load->library('session');
    $this->load->model('M_Index');
    $this->load->model('SystemAdministration/MainMenu/M_user');

    $this->load->model('RekapTemuanAudite/MainMenu/M_handling');

    date_default_timezone_set('Asia/Jakarta');

    if ($this->session->userdata('logged_in') != true) {
      $this->load->helper('url');
      $this->session->set_userdata('last_page', current_url());
      $this->session->set_userdata('Responsbility', 'some_value');
    }
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
    } else {
      redirect('');
    }
  }


  //------------------------show the index-----------------------------
  public function index()
  {
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['title'] = 'Handling';
    $data['Menu'] = 'Rekap Temuan Audite';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('RekapTemuanAudite/Handling/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  public function getDataAudite()
  {
    $seksi_handling = $this->input->post('seksi_handling');
    $data['getDataAudite'] = $this->M_handling->getDataAudite($seksi_handling);
    // echo "<pre>";print_r($data['getDataAudite']);die;
    if (!empty($data['getDataAudite'])) {
      $this->load->view('RekapTemuanAudite/Handling/V_DaftarTemuanAudite',$data);
    }else {
      echo 0;
    }
    // echo "<pre>";print_r($data['getDataAudite']);die;
  }

  public function getGambarBefore()
  {
    $id_before = $this->input->post('id');
    $data['getGambarBefore'] = $this->M_handling->getGambarBefore($id_before);
    // echo "<pre>";print_r($data['getGambarBefore']);die;
    $this->load->view('RekapTemuanAudite/Handling/V_GambarBefore', $data);
  }

  public function getGambarAfter()
  {
    $id_after = $this->input->post('id');
    $data['getGambarAfter'] = $this->M_handling->getGambarAfter($id_after);
    // echo "<pre>";print_r($data['getGambarAfter']);die;
    $this->load->view('RekapTemuanAudite/Handling/V_GambarAfter', $data);
  }

  public function getSeksi()
  {
    $param = $this->input->post('term');
    $param = strtoupper($param);
    $data = $this->M_handling->getSeksi($param);
    echo json_encode($data);
  }

  public function pdfHandling($encrypted)
  {
    $encrypted = explode("%20", $encrypted);
    $encrypted_string2 = $encrypted[0];
    $encrypted_string = $encrypted[1];
    $id_audit = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted[0]);
    $id_audit = $this->encrypt->decode($id_audit);
    $id_temuan = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted[1]);
    $id_temuan = $this->encrypt->decode($id_temuan);
    // echo "<pre>";echo $id_audit.' '.$id_temuan;die;
    $this->load->library('pdf');

    $data['handlingPdf'] = $this->M_handling->handlingPDF($id_audit);
    $data['gambarHandlingPdf'] = $this->M_handling->gambarHandlingPDF($id_temuan);
    // echo "<pre>";print_r($data['handlingPdf']);die;
    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8', array(210,297), 0, 'calibri', 3, 3, 5, 0, 0, 0);
    ob_end_clean();

    $doc = 'Temuan-Audit-Handling-'.$data['handlingPdf'][0]['area'].'-'.date('dmYHis');
    $filename = $doc.'.pdf';
    $fill = $this->load->view('RekapTemuanAudite/Handling/V_Pdf', $data, true);
    $pdf->WriteHTML($fill);
    $pdf->Output($filename, 'I');
  }
}
