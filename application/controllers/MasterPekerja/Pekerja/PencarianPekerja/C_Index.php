<?php
defined("BASEPATH") or die("This script cannot access directly");

/**
 * Ez debugging
 */
if (!function_exists('debug')) {
  function debug($arr)
  {
    echo "<pre>";
    print_r($arr);
    die;
  }
}

class C_Index extends CI_Controller
{
  /**
   * user logged, created by session
   */
  protected $user_logged;
  /**
   * Select param item
   */
  protected $param = [
    'noind' => 'No. Induk',
    'nama' => 'Nama',
    'tglmasuk' => 'Tgl. Masuk',
    'tglkeluar' => 'Tgl. Keluar',
    'alamat' => 'Alamat',
    'jabatan' => 'Jabatan',
    'desa' => 'Desa',
    'kec' => 'Kecamatan',
    'kab' => 'Kabupaten',
    'prop' => 'Provinsi',
    'kodesie' => 'Kodesie'
  ];

  protected $tableHeader = [];

  public function __construct()
  {
    parent::__construct();

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/Pekerja/PencarianPekerja/M_pencarianpekerja', 'modelPencarianPekerja');

    $this->user_logged = @$this->session->user ?: null;
    $this->user_id = $this->session->userid ?: null;

    $this->sessionCheck();
  }

  private function sessionCheck()
  {
    return $this->user_logged or redirect(base_url('MasterPekerja'));
  }

  public function index()
  {
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = 'Pekerja';
    $data['SubMenuTwo'] = 'Pencarian Pekerja';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

    $data['param_option'] = $this->param;
    $data['table_header'] = $this->tableHeader;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Pekerja/PencarianPekerja/V_Index', $data);
    $this->load->view('MasterPekerja/Pekerja/PencarianPekerja/V_Footer', $data);
    // $this->load->view('V_Footer', $data);
  }
}
