<?php
defined('BASEPATH') or exit('die');

class C_Recycle extends CI_Controller
{
  private $mailList;

  public function __construct()
  {
    parent::__construct();

    $this->load->library('general');
    $this->load->library('encrypt');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/Surat/Recycle/M_Recycle');
    $this->list_surat = array();
    $this->checkSession();
    // list surat
    $this->mailList = array(
      'bapsp3' => 'BAP SP3',
      'demosi' => 'Demosi',
      'isolasi' => 'Isolasi Mandiri',
      'mutasi' => 'Mutasi',
      'cutoff' => 'Memo Pekerja Cutoff',
      'resign' => 'Pengunduran Diri',
      'pengangkatan' => 'Pengangkatan',
      'perbantuan' => 'Perbantuan',
      'usiaLanjut' => 'Pemb. Usia Lanjut',
      'promosi' => 'Promosi',
      'rotasi' => 'Rotasi',
      'tugas' => 'Tugas',
      'workexp' => 'Pengalaman Kerja'
    );
  }

  /**
   * @checksesion
   * @return redirect
   */
  private function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('/');
    }
  }

  /**
   * @param ($surat String, $period String)
   * @example ('mutasi', '2020-02')
   * @return Array
   */
  private function getMail($surat, $period)
  {
    // jika nama surat tidak ada dalam daftar
    if (!array_key_exists($surat, $this->mailList)) return [];

    return $this->M_Recycle->getDeletedMail($surat, $period);
  }

  /**
   * @view
   * url: /MasterPekerja/Surat/Recycle
   * get type:
   * surat: demosi|mutasi|perbantuan|promosi|rotasi|pengangkatan|babsp3|usialanjut|cutoff|resign|tugas|isolasi|workexp
   * month: string
   */
  public function index()
  {
    $user_id = $this->session->userid;

    $data['Header'] =  'Master Pekerja - Quick ERP';
    $data['Title'] =  'Recycle Surat';
    $data['Menu'] =   'Surat';
    $data['SubMenuOne'] = 'Recycle';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    // get tanggal
    // get surat
    // this is elvis ?: var1 or var2
    $month = $this->input->get('month') ?: null;
    $surat = $this->input->get('surat') ?: null;

    $data['mailList'] = $this->mailList;
    $data['selected'] = $surat;
    $data['mail'] = $this->getMail($surat, $month);
    $data['title'] = isset($this->mailList[$surat]) ? $this->mailList[$surat] : '';

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Surat/Recycle/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * Method PUT
   * url: /MasterPekerja/Surat/Recycle/Restore
   */
  public function restore()
  {
    $id = $this->input->post('id');
    $surat = $this->input->post('surat');

    switch ($surat) {
      case 'bapsp3':
        $id = $this->general->dekripsi($id);
        return $this->M_Recycle->restoreBapSp3($id);
      case 'demosi':
        $no_surat_decode = $this->general->dekripsi($id);
        return $this->M_Recycle->restoreDemosi($no_surat_decode);
      case 'isolasi':
        $id = $this->general->dekripsi($id);
        return $this->M_Recycle->restoreIsolasi($id);
      case 'mutasi':
        $explode = explode('/', $id);
        $strtotime = $explode[0];
        $kode_surat = $this->general->dekripsi($explode[1]);
        $nomor_surat = $this->general->dekripsi($explode[2]);
        return $this->M_Recycle->restoreMutasi($strtotime, $kode_surat, $nomor_surat);
      case 'cutoff':
        return $this->M_Recycle->restoreCutoff($id);
      case 'resign':
        $id = $this->general->dekripsi($id);
        return $this->M_Recycle->restoreResign($id);
      case 'pengangkatan':
        $id = $this->general->dekripsi($id);
        return $this->M_Recycle->restorePengangkatan($id);
      case 'perbantuan':
        $id = $this->general->dekripsi($id);
        return $this->M_Recycle->restorePerbantuan($id);
      case 'usiaLanjut':
        return $this->M_Recycle->restoreUsiaLanjut($id);
      case 'promosi':
        $id = $this->general->dekripsi($id);
        return $this->M_Recycle->restorePromosi($id);
      case 'rotasi':
        $id = $this->general->dekripsi($id);
        return $this->M_Recycle->restoreRotasi($id);
      case 'tugas':
        $id = $this->general->dekripsi($id);
        return $this->M_Recycle->restoreTugas($id);
      case 'workexp':
        // SOON
        return $this->M_Recycle->restoreWorkExp();
      default;
        return [];
    }
  }

  /**
   * Method POST
   * url: /MasterPekerja/Surat/Recycle/Permanent
   */
  public function deletePermanent()
  {
    $id = $this->input->post('id');
    $surat = $this->input->post('surat');
  }
}
