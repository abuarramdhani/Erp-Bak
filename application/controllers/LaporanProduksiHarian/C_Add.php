<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

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

    public function getMesin($value='')
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->db->query("SELECT fs_no_mesin, fs_nama_mesin from lph.lph_mesin where (
         fs_no_mesin like '%$term%'
         or fs_nama_mesin like '%$term%'
      )")->result_array());
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


}
