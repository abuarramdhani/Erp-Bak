<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Import extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->library('encrypt');
        $this->load->library('Excel');
        date_default_timezone_set('Asia/Jakarta');
        // $this->load->model('CetakKIBMotorBensin/M_master');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        if ($this->session->userdata('logged_in')!=true) {
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

    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard Laporan Produksi Harian V.0.1';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('LaporanProduksiHarian/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function import($v='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard Laporan Produksi Harian V.0.1';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('LaporanProduksiHarian/V_Import', $data);
      $this->load->view('V_Footer', $data);
    }

    function hari_ini($hari){
      switch($hari){
        case 'Sun':
          $hari_ini = "Minggu";
        break;

        case 'Mon':
          $hari_ini = "Senin";
        break;

        case 'Tue':
          $hari_ini = "Selasa";
        break;

        case 'Wed':
          $hari_ini = "Rabu";
        break;

        case 'Thu':
          $hari_ini = "Kamis";
        break;

        case 'Fri':
          $hari_ini = "Jumat";
        break;

        case 'Sat':
          $hari_ini = "Sabtu";
        break;

        default:
          $hari_ini = "Tidak di ketahui";
        break;
      }

      return $hari_ini;

    }

    public function submit_import()
    {
      if (!empty($_FILES)) {

        $file_data = $_FILES['excel_file']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file_data);
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
        foreach ($sheets as $key => $v) {
          if ($key >= 9) {
            $load->getActiveSheet()->getStyle('M'.$key)->getNumberFormat()->applyFromArray(['code'=> PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00]);
            $load->getActiveSheet()->getStyle('N'.$key)->getNumberFormat()->applyFromArray(['code'=> PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00]);
          }
        }
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
        if (strlen($sheets[3]['C']) == 10) {
          $date = date('d-m-Y', strtotime(str_replace('/', '-', $sheets[3]['C'])));
          foreach ($sheets as $key => $v) {
            if ($key >= 9 && !empty($v['C']) && !empty($v['D']) && !empty($v['E']) && !empty($v['H'])) {
              $data = [
                'urut_job' => $v['B']
                ,'nama_operator' => $v['C']
                ,'no_induk' => $v['D']
                ,'kode_mesin' => $v['E']
                ,'no_batch' => $v['F']
                ,'kode_komponen' => $v['G']
                ,'nama_komponen' => $v['H']
                ,'plan' => $v['I']
                ,'foq' => $v['J']
                ,'target_sk' => $v['K']
                ,'target_js' => $v['L']
                ,'persen_target_sk' => $v['M']
                ,'persen_target_js' => $v['N']
                ,'persen_jml_target_sk' => $v['O']
                ,'persen_jml_target_js' => $v['P']
                ,'proses' => $v['Q']
                ,'resource' => $v['R']
                ,'hasil' => $v['S']
                ,'repair' => $v['T']
                ,'scrap' => $v['U']
                ,'hari' => $this->hari_ini(date('D', strtotime(str_replace('/', '-', $sheets[3]['C']))))
                ,'tanggal' => $date
                ,'shift' => $sheets[4]['C']
              ];
              $cek_shift_tgl = $this->db->select('tanggal')
                                        ->where('tanggal', $date)
                                        ->where('shift', strval($sheets[4]['C']))
                                        ->where('kode_komponen', $v['G'])
                                        ->where('no_induk', $v['D'])
                                        ->where('urut_job', $v['B'])
                                        ->where('kode_mesin', $v['E'])
                                        ->get('lph.lph_rencana_kerja_operator')->row_array();

              if (empty($cek_shift_tgl['tanggal'])) {
                $this->db->insert('lph.lph_rencana_kerja_operator', $data);
              }else {
                $this->db->where('tanggal', $date)
                         ->where('shift', strval($sheets[4]['C']))
                         ->where('kode_komponen', $v['G'])
                         ->where('no_induk', $v['D'])
                         ->where('urut_job', $v['B'])
                         ->where('kode_mesin', $v['E'])
                         ->update('lph.lph_rencana_kerja_operator', $data);
              }
            }
          }
            $this->session->set_flashdata('message_lph', '<br><div class="alert bg-success alert-dismissible" role="alert">
                                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">
                                                          <i class="fa fa-close"></i>
                                                        </span>
                                                      </button>
                                                      <strong>Data berhasil diimport !</strong>
                                                    </div>');
          redirect('LaporanProduksiHarian/import');
        }else {
          echo "Format tanggal pada Kolom C3 Salah, Ganti format menjadi dd/mm/yyyy ex. 01/01/2021 <br> Pastikan juga jenis shift berada di kolom C4";
        }
      }else {
        echo "File excel tidak ditemukan";
      }

    }

    public function getmon($v='')
    {
      $range_date = $this->input->post('range_date');
      $range =  explode(' - ', $range_date);
      $shift = $this->input->post('shift');
      $data['get'] = $this->db->query("SELECT * FROM lph.lph_rencana_kerja_operator WHERE shift = '$shift' AND tanggal BETWEEN '$range[0]' AND '$range[1]'")->result_array();
      $this->load->view('LaporanProduksiHarian/ajax/V_mon_rko', $data);
    }

    public function lph_pdf_rk($value='')
    {
      $range_date = $this->input->post('range_date');
      $range =  explode(' - ', $range_date);
      $range = $range[0];
      $shift = $this->input->post('shift');
      $data = $this->db->query("SELECT * FROM lph.lph_rencana_kerja_operator WHERE shift = '$shift' AND tanggal = '$range'")->result_array();
      foreach ($data as $key => $value) {
        $pengelompokan[$value['no_induk']][] = $value;
      }

      if (!empty($pengelompokan)) {
        $tampung = [];
        $one_page_is = [];
        foreach ($pengelompokan as $key => $value) {
          foreach ($value as $key2 => $v) {
            $tampung[] = $v;
            if (sizeof($tampung) == 10) {
              $one_page_is[] = $tampung;
              $tampung = [];
            }elseif (sizeof($tampung) < 10 && empty($value[$key2+1])) {
              $one_page_is[] = $tampung;
              $tampung = [];
            }
          }
          $pengelompokan[$key] = $one_page_is;
          $one_page_is = [];
        }
      }
      echo "<pre>";
      print_r($pengelompokan);
      die;
    }

}
