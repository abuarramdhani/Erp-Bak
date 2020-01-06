<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class C_Lelayu extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->library('Log_Activity');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPresensi/Lelayu/M_lelayu');

    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('index');
    }
  }

  public function index()
  {
    $user = $this->session->username;
    $user_id = $this->session->userid;
    $today = date('d M Y');
    //$bulancutoff = date('Y-m-19');
    $bulancutoff = $this->M_lelayu->getCutoffBulanIni();
    //$bulanlalu = date('Y-m-d', strtotime($bulancutoff. ' -1 month'));
    $bulanlalu = $this->M_lelayu->getCutoffBulanLalu();
    $tanggalcutoff = date('d');

    $data['Title'] = 'Tambah Data Lelayu';
    $data['Menu'] = 'Master Presensi';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['pekerja'] = $this->M_lelayu->getPekerja();
    $data['today'] = $today;
    $data['data'] = $this->M_lelayu->getData()->result_array();
    $data['spsi'] = $this->M_lelayu->getSPSI($bulancutoff, $tanggalcutoff, $bulanlalu);
    $data['nominal'] = $this->M_lelayu->getNominal();
    $data['spsi1'] = $this->M_lelayu->getSPSI1($bulancutoff, $tanggalcutoff, $bulanlalu);
    $data['nominal1'] = $this->M_lelayu->getNominal1();
    $data['spsi2'] = $this->M_lelayu->getSPSI2($bulancutoff, $tanggalcutoff, $bulanlalu);
    $data['nominal2'] = $this->M_lelayu->getNominal2();
    $data['spsi3'] = $this->M_lelayu->getSPSI3($bulancutoff, $tanggalcutoff, $bulanlalu);
    $data['nominal3'] = $this->M_lelayu->getNominal3();

    $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/Lelayu/V_tambahData');
		$this->load->view('V_Footer',$data);
  }

  public function save()
  {
    $pekerja = $_POST['nama_lelayu'];
    $waktu  = $_POST['tanggal_lelayu'];
    $ket  = $_POST['keterangan_Lelayu'];
    $kafan = $_POST['nomKafan'];
    $duka = $_POST['nomDuka'];
    $askanit = $_POST['askanit'].$_POST['nomAskanit'];
    $totAska = $_POST['totalAskanit'];
    $madya  = $_POST['madya'].$_POST['nomMadya'];
    $totMad = $_POST['totMadya'];
    $super  = $_POST['supervisor'].$_POST['nomSuper'];
    $totSup = $_POST['totSuper'];
    $staff  = $_POST['nonStaff'].$_POST['nomNon'];
    $totNon = $_POST['totNon'];

    $array = array(
      'noind' => $pekerja,
      'tgl_lelayu' => $waktu,
      'keterangan' => $ket,
      'kain_kafan_perusahaan' => $kafan,
      'uang_duka_perusahaan' => $duka,
      'spsi_askanit_ket' => $askanit,
      'spsi_askanit_nominal' => $totAska,
      'spsi_kasie_ket	' => $madya,
      'spsi_kasie_nominal' => $totMad,
      'spsi_spv_ket' => $super,
      'spsi_spv_nominal' => $totSup,
      'spsi_nonmanajerial_ket' => $staff,
      'spsi_nonmanajerial_nominal' => $totNon
    );
    $this->M_lelayu->insertAll($array);

    $bulancutoff = $this->M_lelayu->getCutoffBulanIni();
    $tanggalcutoff = date('d');
    $bulanlalu = $this->M_lelayu->getCutoffBulanLalu();

    $id = $this->M_lelayu->getID();
    $noindAll = $this->M_lelayu->getNoindAll($bulancutoff, $tanggalcutoff, $bulanlalu);
    $noindAll1 = $this->M_lelayu->getNoindAll1($bulancutoff, $tanggalcutoff, $bulanlalu);
    $noindAll2 = $this->M_lelayu->getNoindAll2($bulancutoff, $tanggalcutoff, $bulanlalu);
    $noindAll3 = $this->M_lelayu->getNoindAll3($bulancutoff, $tanggalcutoff, $bulanlalu);
    $nominal = $this->M_lelayu->getNominal();
    $nominal1 = $this->M_lelayu->getNominal1();
    $nominal2 = $this->M_lelayu->getNominal2();
    $nominal3 = $this->M_lelayu->getNominal3();

    $arrayData = array();
    $arrayData[0] = array(
      'lelayu_id' => $id,
      'noind' => $noindAll,
      'nominal' => $nominal,
    );
    $arrayData[1]  = array(
      'lelayu_id' => $id,
      'noind' => $noindAll1,
      'nominal' => $nominal1,
    );
    $arrayData[2]  = array(
      'lelayu_id' => $id,
      'noind' => $noindAll2,
      'nominal' => $nominal2,
    );
    $arrayData[3]  = array(
      'lelayu_id' => $id,
      'noind' => $noindAll3,
      'nominal' => $nominal3,
    );

    foreach ($arrayData as $key) {
      foreach ($key['noind'] as $val) {
        $value = array(
          'lelayu_id' => $key['lelayu_id'],
          'noind' => $val['noind'],
          'nominal' => $key['nominal'],
        );
        $this->M_lelayu->insertID($value);
      }
    }
    $id_lelayu = $this->M_lelayu->getID();
    $aksi = 'Lelayu';
    $detail = 'Menambah Data Lelayu dengan id_lelayu '.$id_lelayu;

    $this->log_activity->activity_log($aksi, $detail);
  }
}

 ?>
