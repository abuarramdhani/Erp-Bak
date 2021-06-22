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

      $data['shift'] = $this->M_master->getShift();

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('LaporanProduksiHarian/V_Import', $data);
      $this->load->view('V_Footer', $data);
    }

    public function getDataRKH($value='')
    {
      $range_date = $this->input->post('range_date', true);
      $range =  explode(' - ', $range_date);
      $shift = $this->input->post('shift', true);

      $data['get'] = $this->db->query("SELECT * FROM lph.lph_master WHERE shift = '$shift' AND to_date(tanggal, 'dd-mm-yyyy') BETWEEN to_date('$range[0]', 'dd-mm-yyyy') AND to_date('$range[1]', 'dd-mm-yyyy') ORDER BY id")->result_array();
      $this->load->view('LaporanProduksiHarian/ajax/V_mon_lkh', $data);
      // echo "<pre>";
      // print_r($date['get']);
      // die;
    }

    public function delete_lkh($value='')
    {
      if (!empty($this->input->post('id'))) {
        foreach ($this->input->post('id') as $key => $value) {
          $this->db->delete('lph.lph_master', ['id' => $value]);
        }
        if ($this->db->affected_rows()) {
          echo json_encode(1);
        }else {
          echo json_encode(0);
        }
      }
    }

    public function get_pe($value='')
    {
      $code = $this->input->post('kode_komponen');
      $res = $this->M_master->get_target_pe($code);
      // echo "<pre>";
      // print_r($res);
      if (!empty($res[0]['SEGMENT1'])) {
        $tampung[] = '<option value="">Tidak Memilih</option>';
        foreach ($res as $key => $value) {
          $tampung[] = '<option value="'.$value['KODE_PROSES'].' ~ '.$value['ACTIVITY'].' ~ '.$value['TARGETSK'].' ~ '.$value['TARGETJS'].'">'.$value['KODE_PROSES'].' ~ '.$value['ACTIVITY'].'</option>';
        }
        echo json_encode(implode('', $tampung));
      }else {
        echo json_encode(500);
      }
    }

    public function insert($value='')
    {
      $operator_ = $this->input->post('operator');

      foreach ($operator_ as $ket_opr => $operator) {

        // ============= generate group_id =============
        $group_id = $this->db->select('lph_group_id')->get('lph.lph_id_group')->row_array();
        if (!empty($group_id['lph_group_id'])) {
          $groupid = $group_id['lph_group_id']+1;
          $this->db->where('lph_group_id', $group_id['lph_group_id'])->update('lph.lph_id_group', ['lph_group_id' => $groupid]);
        }else {
          $groupid = 1;
        }

        // ============= insert rkom =============
        $kodepart = $this->input->post('kodepart');
        $tanggal = $this->input->post('tanggal');
        foreach ($kodepart as $key => $kode_komponen) {
          $kodeproses = explode(' ~ ', $this->input->post('kodeproses')[$key]);
          $lph = [
            'tanggal' => $tanggal,
            'shift' => $this->input->post('shift'),
            'kelompok' => $this->input->post('kelompok'),
            'standar_waktu_efektif' => $this->input->post('standar_waktu_efektif'),
            'operator' => $operator,
            'pengawas' => $this->input->post('pengawas'),
            'jenis_ott' => $this->input->post('ott_jenis'),
            'keterangan_ott' => $this->input->post('ott_keterangan'),
            'kode_komponen' => $kode_komponen, // ========== dari sini =================
            'nama_komponen' => $this->input->post('namapart')[$key],
            'alat_bantu' => $this->input->post('alatbantu')[$key],
            'kode_mesin' => $this->input->post('kodemesin')[$key],
            'waktu_mesin' => empty($this->input->post('waktumesin')[$key]) ? NULL : $this->input->post('waktumesin')[$key],
            'kode_proses' => $kodeproses[0],
            'nama_proses' => $this->input->post('namaproses')[$key],
            'plan' => $this->input->post('target_ppic')[$key],
            'target_sk' => $this->input->post('target_harian_sk')[$key],
            'target_js' => $this->input->post('target_harian_js')[$key],
            'aktual' => $this->input->post('aktual')[$key],
            'persentase_aktual' => $this->input->post('persentase')[$key],
            'repair_man' => empty($this->input->post('repair_man')[$key]) ? NULL : $this->input->post('repair_man')[$key],
            'repair_mat' => empty($this->input->post('repair_mat')[$key]) ? NULL : $this->input->post('repair_mat')[$key],
            'repair_mach' => empty($this->input->post('repair_mach')[$key]) ? NULL : $this->input->post('repair_mach')[$key],
            'scrap_man' => empty($this->input->post('scrap_man')[$key]) ? NULL : $this->input->post('scrap_man')[$key],
            'scrap_mat' => empty($this->input->post('scrap_mat')[$key]) ? NULL : $this->input->post('scrap_mat')[$key],
            'scrap_mach' => empty($this->input->post('scrap_mach')[$key]) ? NULL : $this->input->post('scrap_mach')[$key],
            'rko_id' => empty($this->input->post('rko_id')[$key]) ? NULL : $this->input->post('rko_id')[$key],
            'hari' => $this->hari_ini(date('D', strtotime(str_replace('/', '-', $tanggal)))),
            'total' => $this->input->post('total'),
            'kurang' => $this->input->post('kurang'),
            'lph_group_id' => $groupid
          ];
          // echo "<pre>";
          // print_r($lph);
          $this->db->insert('lph.lph_master', $lph);
          if (!$this->db->affected_rows()) {
            $lph_master_insert_status = 0;
            echo json_encode(
            [
              'status' => 'gagal insert lph master',
              'type' => 'warning',
              'message' => "Gagal melakukan insert, gagal insert saat dikomponen $kode_komponen"
            ]);
            die;
          }else {
            $lph_master_insert_status = 1;
          }
        }

        if ($lph_master_insert_status) {
          //insert pwe
          $faktor_pwe = $this->input->post('faktor_pwe');
          $menit_pwe = $this->input->post('menit_pwe');
          if (!empty($faktor_pwe) && !empty($menit_pwe)) {
            foreach ($faktor_pwe as $key => $value) {
              $pwe = [
                'faktor' => $value,
                'waktu' => $menit_pwe[$key],
                'total_waktu' => $this->input->post('total_waktu_pwe'),
                'persentase_waktu' => $this->input->post('persentase_waktu_pwe'),
                'id_lphm' => $groupid
              ];
              $this->db->insert('lph.lph_pengurangan_waktu_ef', $pwe);
              if ($this->db->affected_rows()) {
                $sukses_pwe = 1;
              }else {
                $sukses_pwe = 0;
                echo json_encode([
                  'status' => 'gagal insert pwe',
                  'type' => 'warning',
                  'message' => "Gagal melakukan insert di pengurangan_waktu_efektif, gagal saat melakukan insert di $value"
                ]);
                die;
              }
            }
            if ($sukses_pwe) {
              $pwe = 1;
            }
          }else {
            $pwe = 1;
          }
        }
      }

      if ($pwe) {
        echo json_encode([
          'status' => 200,
          'type' => 'success',
          'message' => 'Berhasil melakukan insert data'
        ]);
      }

    }

    public function kodePart()
    {
        $variable = $this->input->GET('variable',TRUE);
        $variable = strtoupper($variable);
        $kode = $this->M_master->kodePart($variable, $this->input->get('type_product'));
        echo json_encode($kode);
    }

    public function AlatBantu()
    {
        $ab = $this->input->post('ab',TRUE);
        $ab = strtoupper($ab);
        $alatBantu = $this->M_master->selectAlatBantu($ab);
        echo json_encode($alatBantu);
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
      if (!empty($this->input->post('shift'))) {
        // code...
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
                  ,'hasil' => !empty($v['S']) ? $v['S'] : ''
                  ,'repair' => !empty($v['T']) ? $v['T'] : ''
                  ,'scrap' => !empty($v['U']) ? $v['U'] : ''
                  ,'hari' => $this->hari_ini(date('D', strtotime(str_replace('/', '-', $sheets[3]['C']))))
                  ,'tanggal' => $date
                  ,'shift' => $this->input->post('shift')
                ];
                $cek_shift_tgl = $this->db->select('tanggal')
                                          ->where('tanggal', $date)
                                          ->where('shift', strval($this->input->post('shift')))
                                          ->where('kode_komponen', $v['G'])
                                          ->where('no_induk', $v['D'])
                                          ->where('urut_job', $v['B'])
                                          ->where('kode_mesin', $v['E'])
                                          ->get('lph.lph_rencana_kerja_operator')->row_array();

                if (empty($cek_shift_tgl['tanggal'])) {
                  $this->db->insert('lph.lph_rencana_kerja_operator', $data);
                }else {
                  $this->db->where('tanggal', $date)
                           ->where('shift', strval($this->input->post('shift')))
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
            echo "Mohon perbaiki format tanggal pada Kolom C3, Ganti format menjadi dd/mm/yyyy ex. 01/01/2021";
          }
        }else {
          echo "File excel tidak ditemukan";
        }
      }

    }

    public function getRKH($value='')
    {
      $res = $this->db->where('tanggal', $this->input->post('tanggal'))
                      ->where('shift', $this->input->post('shift'))
                      ->where('no_induk', $this->input->post('no_induk'))
                      ->get('lph.lph_rencana_kerja_operator')->result_array();
                      // echo $this->db->last_query();die;
      if (!empty($res[0]['nama_operator'])) {
        $detail_shift = $this->M_master->get_detail_shift($this->input->post('shift'));
        foreach ($res as $key => $value) {
          $res[$key]['shift_description'] = $detail_shift['DESCRIPTION'];
        }
        $data['get'] = $res;
        // echo "<pre>";print_r($res);
        $this->load->view('LaporanProduksiHarian/ajax/V_ajax_add', $data);
      }else {
        echo 'gada';
      }
    }

    public function getEmptyRKH($value='')
    {
      $this->load->view('LaporanProduksiHarian/ajax/V_ajax_add_empty');
    }

    public function getmon($v='')
    {
      $range_date = $this->input->post('range_date');
      $range =  explode(' - ', $range_date);
      $shift = $this->input->post('shift');
      // echo "<pre>";print_r($_POST);
      // die;

      $data['get']= $this->M_master->getMon($range, $shift);
      $this->load->view('LaporanProduksiHarian/ajax/V_mon_rko', $data);
    }

    public function getShift($value='')
    {
      // $date = str_replace('-','/',$this->input->post('tanggal'));
      $date  = date("Y/m/d", strtotime($this->input->post('tanggal')));
      $data = $this->M_master->getShift($date);
      $s[] =  '<option selected value=""></option>';
        foreach ($data as $key => $value) {
          if (!empty($value['SHIFT_NUM'])) {
            $s[] = '<option value="'.$value['SHIFT_NUM'].'">'.$value['SHIFT_NUM'].' - '.$value['DESCRIPTION'].'</option>';
          }
        }
        if (!empty($s)) {
          echo json_encode(implode($s, ''));
        }else {
          echo json_encode(0);
        }
    }

    public function lph_pdf_rk($value='')
    {
      $range_date = $this->input->post('range_date');
      $range =  explode(' - ', $range_date);
      $range = $range[0];
      $shift = $this->input->post('shift');
      $data = $this->db->query("SELECT rk.*,
                                      COALESCE ((select product_name
                                                 from lph.list_product lp
                                                 where SUBSTRING(rk.kode_komponen, 1, 3) = lp.product_code), NULL) product_name
                                FROM lph.lph_rencana_kerja_operator rk WHERE rk.shift = '$shift' AND rk.tanggal = '$range'")->result_array();

      foreach ($data as $key => $value) {
        if (!empty($value['kode_komponen'])) {
          $std = $this->M_master->get_sarana($value['kode_komponen']);
          if (!empty($std)) {
            $data[$key]['STD_HANDLING'] = $std['STD_HANDLING'];
            $data[$key]['DESCRIPTION'] = $std['DESCRIPTION'];
          }

          $ambil_no_dies = $this->M_master->get_no_dies($value['kode_komponen'], strtoupper($value['proses']));
          $no_dies = '';
          if (!empty($ambil_no_dies['SEGMENT1'])) {
            for ($i=1; $i <= 7; $i++) {
              if (!empty($ambil_no_dies['AB'.$i])) {
                $no_dies .= explode(' - ', $ambil_no_dies['AB'.$i])[0].', ';
              }
            }
            $data[$key]['NO_DIES'] = $no_dies;
          }
        }
      }
      $pengelompokan = [];
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

          foreach ($one_page_is as $key3 => $value3) {
            if (sizeof($value3) < 10) {
              for ($i=0; $i < 10 - sizeof($value3); $i++) {
                $data = [
                          'urut_job' => ''
                          ,'nama_operator' => ''
                          ,'no_induk' => ''
                          ,'kode_mesin' => ''
                          ,'no_batch' => ''
                          ,'kode_komponen' => ''
                          ,'nama_komponen' => ''
                          ,'plan' => ''
                          ,'foq' => ''
                          ,'target_sk' => ''
                          ,'target_js' => ''
                          ,'persen_target_sk' => ''
                          ,'persen_target_js' => ''
                          ,'persen_jml_target_sk' => ''
                          ,'persen_jml_target_js' => ''
                          ,'proses' => ''
                          ,'resource' => ''
                          ,'hasil' => ''
                          ,'repair' => ''
                          ,'scrap' => ''
                          ,'hari' => ''
                          ,'tanggal' => ''
                          ,'shift' => ''
                        ];
                $one_page_is[$key3][] = $data;
              }
            }
          }

          $pengelompokan[$key] = $one_page_is;
          $one_page_is = [];
        }
      }

      $data['get'] = $pengelompokan;
      $data['date'] = $range;
      $this->load->library('Pdf');

      $pdf 		= $this->pdf->load();
      $pdf 		= new mPDF('utf-8', array(267, 210), 0, 'calibri', 3, 3, 3, 0, 0, 0);
      ob_end_clean() ;

      $doc = 'RENCANA-KERJA-OPERATOR-'.$range;
      $filename 	= $doc.'.pdf';
      if (!empty($data['get'])) {
        $isi 	= $this->load->view('LaporanProduksiHarian/pdf/V_pdf_lkh', $data, true);
      }else {
        $isi 	= 'Data is empty';
      }
      $pdf->WriteHTML($isi);
      $pdf->Output($filename, 'I');
    }

}
