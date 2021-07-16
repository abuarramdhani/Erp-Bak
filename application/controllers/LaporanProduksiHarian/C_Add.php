<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('max_input_vars','10000');
ini_set('max_execution_time', '1000');
ini_set('max_input_time', '-1');
ini_set('memory_limit', '4000M');

class C_Add extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->library('encrypt');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('LaporanProduksiHarian/M_master');
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
      $data['shift'] = $this->M_master->getShift();

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('LaporanProduksiHarian/V_Add', $data);
      $this->load->view('V_Footer', $data);
    }

    public function employee()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->M_master->employee($term));
    }

    public function mesin($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard Laporan Produksi Harian V.0.1';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
      $data['mesin'] = $this->db->get('lph.lph_mesin')->result_array();
      $data['shift'] = $this->M_master->getShift();

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('LaporanProduksiHarian/V_Mesin', $data);
      $this->load->view('V_Footer', $data);
    }

    public function getdatamesin($value='')
    {
      $post = $this->input->post();

      foreach ($post['columns'] as $val) {
        $post['search'][$val['data']]['value'] = $val['search']['value'];
      }

      $countall = $this->M_master->countAllMS()['count'];
      $countfilter = $this->M_master->countFilteredMS($post)['count'];

      $post['pagination']['from'] = $post['start'] + 1;
      $post['pagination']['to'] = $post['start'] + $post['length'];

      $msdata = $this->M_master->selectMS($post);

      $data = [];
      foreach ($msdata as $row) {
        $sub_array = [];
        $sub_array[] = '<center>'.$row['pagination'].'</center>';
        $sub_array[] = '<center>
                        <button style="margin-right:4px" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" onclick="del_lph_mesin('.$row['id_num'].')" title="Hapus Data"><span class="fa fa-trash"></span></button>
                        <button style="margin-right:4px" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></button>
                       </center>';
        $sub_array[] = '<center>'.$row['fs_no_mesin'].'</center>';
        $sub_array[] = '<center>'.$row['fs_nama_mesin'].'</center>';
        $sub_array[] = '<center>'.$row['fn_tonase'].'</center>';

        $data[] = $sub_array;
      }

      $output = [
        'draw' => $post['draw'],
        'recordsTotal' => $countall,
        'recordsFiltered' => $countfilter,
        'data' => $data,
      ];

      die($this->output
              ->set_status_header(200)
              ->set_content_type('application/json')
              ->set_output(json_encode($output))
              ->_display());
    }

    public function getMesin($value='')
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->db->query("SELECT fs_no_mesin, fs_nama_mesin from lph.lph_mesin where (
         fs_no_mesin like '%$term%'
         or fs_nama_mesin like '%$term%'
      )")->result_array());
    }

    public function save_mesin($value='')
    {
      $data = [
        'fs_no_mesin' => $this->input->post('no_mesin'),
        'fs_nama_mesin' => $this->input->post('nama_mesin'),
        'fn_tonase' => $this->input->post('tonase'),
      ];
      $this->db->insert('lph.lph_mesin', $data);
      if ($this->db->affected_rows()) {
        echo json_encode('done');
      }else {
        echo json_encode(500);
      }
    }

    public function del_mesin($value='')
    {
      $this->db->delete('lph.lph_mesin', ['id_num' => $this->input->post('id')]);
      if ($this->db->affected_rows()) {
        echo json_encode('done');
      }else {
        echo json_encode(500);
      }
    }

    public function monPemakaianJamMesin($value='')
    {
      $range_date = $this->input->post('tanggal');
      $range =  explode(' - ', $range_date);
      $shift = $this->input->post('shift');
      // echo "<pre>";print_r($range);
      // die;
      $data['get'] = $this->db->query("SELECT lm.*, COALESCE ((select lme.fn_tonase
                         from lph.lph_mesin lme
                         where lm.kode_mesin = lme.fs_no_mesin), NULL) tonase FROM lph.lph_master lm WHERE lm.shift = '$shift' AND to_date(lm.tanggal, 'dd-mm-yyyy') BETWEEN to_date('$range[0]', 'dd-mm-yyyy') AND to_date('$range[1]', 'dd-mm-yyyy') ORDER BY lm.id")->result_array();
      $this->load->view('LaporanProduksiHarian/ajax/V_mon_mesin', $data);
    }

    public function alatbantu($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard Laporan Produksi Harian V.0.1';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
      $data['shift'] = $this->M_master->getShift();

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('LaporanProduksiHarian/V_Alatbantu', $data);
      $this->load->view('V_Footer', $data);
    }

    public function getalatbantu($value='')
    {
      $post = $this->input->post();

      foreach ($post['columns'] as $val) {
        $post['search'][$val['data']]['value'] = $val['search']['value'];
      }

      $countall = $this->M_master->countAllAB()['count'];
      $countfilter = $this->M_master->countFilteredAB($post)['count'];

      $post['pagination']['from'] = $post['start'] + 1;
      $post['pagination']['to'] = $post['start'] + $post['length'];

      $abdata = $this->M_master->selectAB($post);

      $data = [];
      foreach ($abdata as $row) {
        $sub_array = [];
        $sub_array[] = '<center>'.$row['pagination'].'</center>';
        $sub_array[] = '<center>
                        <button style="margin-right:4px" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" onclick="del_alat_bantu('.$row['id'].')" title="Hapus Data"><span class="fa fa-trash"></span></button>
                        <button style="margin-right:4px" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o"></span></button>
                       </center>';
        $sub_array[] = '<center>'.$row['fs_no_ab'].'</center>';
        $sub_array[] = '<center>'.$row['fs_umur_pakai'].'</center>';
        $sub_array[] = '<center>'.$row['fs_toleransi'].'</center>';
        $sub_array[] = '<center>'.$row['fs_proses'].'</center>';
        $sub_array[] = '<center>'.$row['fs_umur_pakai_lama'].'</center>';

        $data[] = $sub_array;
      }

      $output = [
        'draw' => $post['draw'],
        'recordsTotal' => $countall,
        'recordsFiltered' => $countfilter,
        'data' => $data,
      ];

      die($this->output
              ->set_status_header(200)
              ->set_content_type('application/json')
              ->set_output(json_encode($output))
              ->_display());
    }

    public function save_alat_bantu($value='')
    {
      $data = [
        'fs_no_ab' => $this->input->post('kode_alat_bantu'),
        'fs_umur_pakai' => $this->input->post('umur_pakai'),
        'fs_toleransi' => $this->input->post('toleransi'),
        'fs_proses' => $this->input->post('proses')
      ];
      $this->db->insert('lph.lph_alat_bantu', $data);
      if ($this->db->affected_rows()) {
        echo json_encode('done');
      }else {
        echo json_encode(500);
      }
    }

    public function del_alat_bantu($value='')
    {
      $this->db->delete('lph.lph_alat_bantu', ['id' => $this->input->post('id')]);
      if ($this->db->affected_rows()) {
        echo json_encode('done');
      }else {
        echo json_encode(500);
      }
    }

    public function alatbantu_slc($value='')
    {
      $ab = strtoupper($this->input->post('term'));
      $res = $this->db->query("SELECT fs_no_ab, fs_proses from lph.lph_alat_bantu where (
        fs_no_ab like '%$ab%' or fs_proses like '%$ab%'
      )")->result_array();
      echo json_encode($res);
    }

    private function sum_same_ab($get, $val)
    {
      $keys = array_keys(array_column($get, 'fs_no_ab'), $val);
      $total = 0;
      foreach ($keys as $k) {
        $total += $get[$k]['aktual'];
      }
      return $total;
    }

    public function pemkaian_alat_bantu($value='')
    {
      $range_date = $this->input->post('range_date');
      $range =  explode(' - ', $range_date);
      $alatbantu = $this->input->post('alat_bantu');

      $get = $this->db->query("SELECT lab.fs_no_ab,
                               lab.fs_proses,
                               lab.fs_umur_pakai,
                               lab.fs_toleransi,
                               (null) ke,
                               rk.aktual,
                               rk.kode_komponen,
                               rk.kode_proses,
                               rk.nama_komponen,
                               rk.tanggal
                              FROM lph.lph_alat_bantu lab,
                                   lph.lph_master rk
                              WHERE lab.fs_no_ab like '%$alatbantu%'
                              AND lab.fs_no_ab = split_part(rk.alat_bantu, ' - ', 2)
                              AND to_date(rk.tanggal, 'dd-mm-yyyy')
                                    BETWEEN to_date('$range[0]', 'dd-mm-yyyy')
                                    AND to_date('$range[1]', 'dd-mm-yyyy')
                              ORDER BY lab.fs_no_ab ASC")->result_array();

      $result = [];
      $semua_sama = [];
      $no_pakai = 0;
      if (!empty($get[0]['fs_no_ab'])) {
        $semua_sama = array_keys(array_column($get, 'fs_no_ab'), $get[0]['fs_no_ab']);
      }
      foreach ($get as $key => $value) {
        $no_pakai+=1;
        $value['ke'] = $no_pakai;
        $result[] = $value;

        $c = [
          'fs_no_ab' => '',
          'fs_proses' => 'TGL.KIRIM :',
          'fs_umur_pakai' => '',
          'fs_toleransi' => '',
          'ke' => 'TOTAL :',
          'aktual' => '',
          'kode_komponen' => '',
          'kode_proses' => '',
          'nama_komponen' => '',
          'tanggal' => ''
        ];

        if (sizeof($get) > 1 && $key != sizeof($get)-1 && $value['fs_no_ab'] != $get[$key+1]['fs_no_ab']) {
          $c['aktual'] = $this->sum_same_ab($get, $value['fs_no_ab']);
          $no_pakai = 0;
          $result[] = $c;
        }elseif (sizeof($get) > 1 && $key == sizeof($get)-1 && $value['fs_no_ab'] != $get[$key-1]['fs_no_ab']) {
          $c['aktual'] = $this->sum_same_ab($get, $value['fs_no_ab']);
          $no_pakai = 0;
          $result[] = $c;
        }elseif (sizeof($get) == 1) {
          $c['aktual'] = $this->sum_same_ab($get, $value['fs_no_ab']);
          $no_pakai = 0;
          $result[] = $c;
        }elseif (sizeof($semua_sama) == sizeof($get) && $key == sizeof($get)-1) {
          $c['aktual'] = $this->sum_same_ab($get, $value['fs_no_ab']);
          $no_pakai = 0;
          $result[] = $c;
        }

      }
      // echo "<pre>";
      // print_r($get);
      // die;
      $data['get'] = $result;
      $this->load->view('LaporanProduksiHarian/ajax/V_mon_alat_bantu', $data);
    }

}
