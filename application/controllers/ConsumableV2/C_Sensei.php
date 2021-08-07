<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Sensei extends CI_Controller
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
        $this->load->model('ConsumableV2/M_master', 'md');
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

        $data['Title'] = 'Dashboard Consumable Tim V.2.0';
        $data['Menu'] = 'Dashboard Consumable Tim V.2.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ConsumableV2/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function permintaanmasuk()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Title'] = 'Dashboard Consumable Tim V.2.0';
        $data['Menu'] = 'Dashboard Consumable Tim V.2.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ConsumableV2/TIM/V_PermintaanMasuk', $data);
        $this->load->view('V_Footer', $data);
    }

    public function viewapprovalkeb($value='')
    {
      $data['approvalkebutuhan'] = $this->md->ambillistapprove();
      $this->load->view('ConsumableV2/TIM/AJAX/V_ViewApprovalKeb', $data);
    }

    public function detailitemapproval($value='')
    {
      $data['get'] = $this->md->itemkebutuhanbykodesie($this->input->post('kodesie'));
      $data['kodesie'] = $this->input->post('kodesie');
      $this->load->view('ConsumableV2/TIM/AJAX/V_ItemKebutuhanApproval', $data);
    }

    public function viewapprovalitem($value='')
    {
      $data['approvalkebutuhan'] = $this->md->ambillistapproveitem();
      $this->load->view('ConsumableV2/TIM/AJAX/V_ViewApprovalItem', $data);
    }

    public function seksiygblmmengajukan($value='')
    {
      $data['get'] = $this->md->seksiygblmmengajuakan();
      $this->load->view('ConsumableV2/TIM/AJAX/V_SeksiBlmMengajukan', $data);
    }

    public function detailitemapproval2($value='')
    {
      $data['get'] = $this->md->itembykodesie($this->input->post('kodesie'));
      $data['kodesie'] = $this->input->post('kodesie');
      $this->load->view('ConsumableV2/TIM/AJAX/V_ItemApproval2', $data);
    }

    public function getmasteritem($value='')
    {
      $post = $this->input->post();

      foreach ($post['columns'] as $val) {
        $post['search'][$val['data']]['value'] = $val['search']['value'];
      }

      $countall = $this->md->countAllMasterItem()['count'];
      $countfilter = $this->md->countFilteredMasterItem($post)['count'];

      $post['pagination']['from'] = $post['start'] + 1;
      $post['pagination']['to'] = $post['start'] + $post['length'];

      $msdata = $this->md->selectMasterItem($post);

      $data = [];
      foreach ($msdata as $row) {
        $sub_array = [];
        $sub_array[] = '<center>'.$row['PAGINATION'].'</center>';
        $sub_array[] = '<center>'.$row['SEGMENT1'].'</center>';
        $sub_array[] = '<center>'.$row['DESCRIPTION'].'</center>';
        $sub_array[] = '<center>'.$row['PRIMARY_UOM_CODE'].'</center>';
        $sub_array[] = '<center>'.$row['LEADTIME'].'</center>';
        $sub_array[] = '<center>'.$row['MOQ'].'</center>';
        $sub_array[] = '<center>'.$row['MIN_STOCK'].'</center>';
        $sub_array[] = '<center>'.$row['MAX_STOCK'].'</center>';
        $sub_array[] = '<center>
                         <button type="button" class="btn " name="button" style="border: 1px solid #a8a8a8;" title="edit?" onclick="edit('.$row['INVENTORY_ITEM_ID'].')"> <i class="fa fa-pencil"></i> Edit</button>
                       </center>';

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

    public function updatestatusitemkebutuhan($value='')
    {
      if ($this->session->is_logged) {
        echo json_encode($this->md->updatestatusitemkebutuhan($this->input->post('item_id'), $this->input->post('status'), $this->input->post('reason')));
      }
    }

    public function updatestatusitem($value='')
    {
      if ($this->session->is_logged) {
        echo json_encode($this->md->updatestatusitem($this->input->post('item_id'), $this->input->post('status')));
      }
    }

    public function getitem()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->md->getItem($term));
    }

    public function getseksi($value='')
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->md->getseksi($term));
    }

    public function employee($value='')
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->md->employee($term, $this->input->post('kodesie')));
    }

    public function savemasteritem($value='')
    {
      if ($this->session->is_logged) {
        $cek = [];
        foreach ($this->input->post('item_id') as $key => $item_id) {
          $cek = $this->md->cekmasteritem($item_id);
          if (sizeof($cek)) {
              echo json_encode([
              'status' => 'wesono',
              'message' => 'Item '.$this->input->post('kodeitem')[$key].' telah ada di database, hapus item tersebut lalu save lagi.'
            ]); die;
          }
        }
        $res = $this->md->savemasteritem($this->input->post());
      }else {
        $res = 0;
      }
      echo json_encode(['status' => $res]);
    }

    public function savecsmseksi($value='')
    {
      if ($this->session->is_logged) {
        $cek = [];
          $cek = $this->md->cekseksi($this->input->post('pic'));
          if ($cek == 'wesono') {
              echo json_encode([
              'status' => 'wesono',
              'message' => 'Seksi '.$this->input->post('seksi').' telah ada di database,'
            ]); die;
          }
        $data = [
          'KODESIE' => $cek,
          'PIC' => explode(' - ', $this->input->post('pic'))[1],
          'SEKSI' => $this->input->post('seksi'),
          'VOIP' => $this->input->post('voip')
        ];
        $res = $this->md->saveseksi($data);
      }else {
        $res = 0;
      }
      echo json_encode(['status' => $res]);
    }

    public function datacsmseksi($value='')
    {
      $data['get'] = $this->md->getdataseksi();
      $this->load->view('ConsumableV2/TIM/AJAX/V_Dataseksi', $data);
    }

    public function delseksi($value='')
    {
      if ($this->session->is_logged) {
        echo json_encode($this->md->delseksi($this->input->post('id')));
      }
    }

    public function pengajuan()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Title'] = 'Dashboard Consumable Tim V.2.0';
        $data['Menu'] = 'Dashboard Consumable Tim V.2.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ConsumableV2/TIM/V_Pengajuan', $data);
        $this->load->view('V_Footer', $data);
    }

    public function trackrecord($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Title'] = 'Dashboard Consumable Tim V.2.0';
      $data['Menu'] = 'Dashboard Consumable Tim V.2.0';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('ConsumableV2/TIM/V_TrackRecord', $data);
      $this->load->view('V_Footer', $data);
    }

    public function settingdatamaster($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Title'] = 'Dashboard Consumable Tim V.2.0';
      $data['Menu'] = 'Dashboard Consumable Tim V.2.0';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('ConsumableV2/TIM/V_SettingDataMaster', $data);
      $this->load->view('V_Footer', $data);
    }

}
