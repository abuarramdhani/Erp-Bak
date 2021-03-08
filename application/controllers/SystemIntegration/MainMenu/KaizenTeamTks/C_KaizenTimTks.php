<?php defined('BASEPATH') or exit('No direct script access allowed');

class C_KaizenTimTks extends CI_Controller
{ //ealah :v

  function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');

    $this->load->model('M_index');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('SystemIntegration/KaizenTks/M_kaizentimtks');
    $this->load->model('SystemIntegration/KaizenTks/M_kaizentks');

    if ($this->session->userdata('logged_in') != TRUE) {
      $this->load->helper('url');
      $this->session->set_userdata('last_page', current_url());
      $this->session->set_userdata('Responsbility', 'some_value');
    }
  }

  public function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('index');
    }
  }

  function index()
  {
    // die;
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Menu']       =   'Dasboard';
    $data['SubMenuOne']   =   '';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/V_Dasboard', $data);
    $this->load->view('V_Footer', $data);
  }

  function RekapTotalPekerjaPeriodeSatuTahun()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Rekap Data Kaizen - Total Pekerja';
    $data['Header']      =  'Rekap Data Kaizen - Total Pekerja';
    $data['Menu']       =   'Rekap Data Kaizen - Total Pekerja';
    $data['SubMenuOne']   =   'Periode 1 Tahun';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/RekapDataTotalPekerja/V_periode_satu_tahun', $data);
    $this->load->view('V_Footer', $data);
  }

  function RekapTotalPekerjaPeriodeSatuBulan()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Rekap Data Kaizen - Total Pekerja';
    $data['Header']      =  'Rekap Data Kaizen - Total Pekerja';
    $data['Menu']       =   'Rekap Data Kaizen - Total Pekerja';
    $data['SubMenuOne']   =   'Periode 1 Bulan';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/RekapDataTotalPekerja/V_periode_satu_bulan', $data);
    $this->load->view('V_Footer', $data);
  }

  function RekapTotalKaizenPeriodeSatuTahun()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Rekap Data Kaizen - Total Kaizen';
    $data['Header']      =  'Rekap Data Kaizen - Total Kaizen';
    $data['Menu']       =   'Rekap Data Kaizen - Total Kaizen';
    $data['SubMenuOne']   =   'Periode 1 Tahun';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/RekapDataTotalKaizen/V_periode_satu_tahun', $data);
    $this->load->view('V_Footer', $data);
  }

  function RekapTotalKaizenPeriodeSatuBulan()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Rekap Data Kaizen - Total Kaizen';
    $data['Header']      =  'Rekap Data Kaizen - Total Kaizen';
    $data['Menu']       =   'Rekap Data Kaizen - Total Kaizen';
    $data['SubMenuOne']   =   'Periode 1 Bulan';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/RekapDataTotalKaizen/V_periode_satu_bulan', $data);
    $this->load->view('V_Footer', $data);
  }

  function RekapDataKategoriKaizenBulanan()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Rekap Data Kaizen - Kategori Kaizen';
    $data['Header']      =  'Rekap Data Kaizen - Kategori Kaizen';
    $data['Menu']       =   'Rekap Data Kaizen - Kategori Kaizen';
    $data['SubMenuOne']   =   'Bulanan';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/RekapDataKategoriKaizen/V_Bulanan', $data);
    $this->load->view('V_Footer', $data);
  }

  function RekapDataKategoriKaizenTahunan()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Rekap Data Kaizen - Kategori Kaizen';
    $data['Header']      =  'Rekap Data Kaizen - Kategori Kaizen';
    $data['Menu']       =   'Rekap Data Kaizen - Kategori Kaizen';
    $data['SubMenuOne']   =   'Tahunan';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/RekapDataKategoriKaizen/V_Tahunan', $data);
    $this->load->view('V_Footer', $data);
  }

  function get_data_kaizen_total_pekerja_satu_tahun()
  {
    $get = $this->input->get();
    (!empty($get['year'])) ? $year = $get['year'] : $year = date('Y');

    $data = $this->M_kaizentimtks->getDataKaizenTotalPekerjaSatuTahun($year);

    $newArr = array();
    $i = 0;
    foreach ($data as $v) {
      $i++;
      $v['no'] = $i;
      $v['persen_januari'] = bcdiv($v['persen_januari'], 1, 2) . '%';
      $v['persen_februari'] = bcdiv($v['persen_februari'], 1, 2) . '%';
      $v['persen_maret'] = bcdiv($v['persen_maret'], 1, 2) . '%';
      $v['persen_april'] = bcdiv($v['persen_april'], 1, 2) . '%';
      $v['persen_mei'] = bcdiv($v['persen_mei'], 1, 2) . '%';
      $v['persen_juni'] = bcdiv($v['persen_juni'], 1, 2) . '%';
      $v['persen_juli'] = bcdiv($v['persen_juli'], 1, 2) . '%';
      $v['persen_agustus'] = bcdiv($v['persen_agustus'], 1, 2) . '%';
      $v['persen_september'] = bcdiv($v['persen_september'], 1, 2) . '%';
      $v['persen_oktober'] = bcdiv($v['persen_oktober'], 1, 2) . '%';
      $v['persen_november'] = bcdiv($v['persen_november'], 1, 2) . '%';
      $v['persen_desember'] = bcdiv($v['persen_desember'], 1, 2) . '%';
      $newArr[] = $v;
    }

    echo json_encode(array(
      'success' => true,
      'data' => $newArr,
    ));
  }

  function get_data_kaizen_total_pekerja_satu_bulan()
  {
    $get = $this->input->get();
    (!empty($get['date'])) ? $date = $get['date'] : $date = date('Y-m');

    $bulan = $this->M_kaizentimtks->tgl_indo($date);
    $data = $this->M_kaizentimtks->getDataKaizenTotalPekerjaSatuBulan($date);

    echo json_encode(array(
      'success' => true,
      'data' => $data,
      'bulan' => $bulan
    ));
  }

  function get_data_kaizen_total_kaizen_satu_tahun()
  {
    $get = $this->input->get();
    (!empty($get['year'])) ? $year = $get['year'] : $year = date('Y');

    $data = $this->M_kaizentimtks->getDataKaizenTotalKaizenSatuTahun($year);

    $newArr = array();
    $i = 0;
    foreach ($data as $v) {
      $i++;
      $v['no'] = $i;
      $v['persen_januari'] = bcdiv($v['persen_januari'], 1, 2) . '%';
      $v['persen_februari'] = bcdiv($v['persen_februari'], 1, 2) . '%';
      $v['persen_maret'] = bcdiv($v['persen_maret'], 1, 2) . '%';
      $v['persen_april'] = bcdiv($v['persen_april'], 1, 2) . '%';
      $v['persen_mei'] = bcdiv($v['persen_mei'], 1, 2) . '%';
      $v['persen_juni'] = bcdiv($v['persen_juni'], 1, 2) . '%';
      $v['persen_juli'] = bcdiv($v['persen_juli'], 1, 2) . '%';
      $v['persen_agustus'] = bcdiv($v['persen_agustus'], 1, 2) . '%';
      $v['persen_september'] = bcdiv($v['persen_september'], 1, 2) . '%';
      $v['persen_oktober'] = bcdiv($v['persen_oktober'], 1, 2) . '%';
      $v['persen_november'] = bcdiv($v['persen_november'], 1, 2) . '%';
      $v['persen_desember'] = bcdiv($v['persen_desember'], 1, 2) . '%';
      $newArr[] = $v;
    }

    echo json_encode(array(
      'success' => true,
      'data' => $newArr,
    ));
  }


  function get_data_kaizen_total_kaizen_satu_bulan()
  {
    $get = $this->input->get();
    (!empty($get['date'])) ? $date = $get['date'] : $date = date('Y-m');

    $bulan = $this->M_kaizentimtks->tgl_indo($date);
    $data = $this->M_kaizentimtks->getDataKaizenTotalKaizenSatuBulan($date);

    echo json_encode(array(
      'success' => true,
      'data' => $data,
      'bulan' => $bulan
    ));
  }

  function get_data_kaizen_kategori_kaizen_satu_tahun()
  {
    $get = $this->input->get();
    (!empty($get['year'])) ? $year = $get['year'] : $year = date('Y');

    $data = $this->M_kaizentimtks->getDataKaizenKategoriKaizenTahunan($year);

    echo json_encode(array(
      'success' => true,
      'data' => $data,
      'year' => $year
    ));
  }

  function get_data_kaizen_kategori_kaizen_bulanan()
  {
    $get = $this->input->get();
    (!empty($get['year'])) ? $year = $get['year'] : $year = date('Y');

    $data = $this->M_kaizentimtks->getDataKaizenKategoriBulanan($year);

    echo json_encode(array(
      'success' => true,
      'data' => $data,
      'year' => $year
    ));
  }
}
