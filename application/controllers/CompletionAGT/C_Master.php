<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Master extends CI_Controller
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
        $this->load->model('CompletionAGT/M_master');
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

        $data['Menu'] = 'Dashboard Completion Assembly Gear Transmission V.1.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CompletionAGT/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function ScanKartuBody()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard Completion Assembly Gear Transmission V.1.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CompletionAGT/V_ScanKB', $data);
        $this->load->view('V_Footer', $data);
    }

    public function jobold($value='')
    {
      $item_id = explode(',', $this->input->post('item_id'));
      $data['item_id'] = $item_id[0];
      if ($item_id[0] != '-') {
        $data['old_job'] = $this->M_master->getOldJob($item_id[0]);
      }
      // 11190
      if (!empty($data['old_job']) && $item_id[0] != '-') {
        $this->load->view('CompletionAGT/ajax/V_Item', $data);
      }elseif ($item_id[0] == '-') {
        $data['old_job'] = [
          'ITEM_ID' => '0',
          'CREATION_DATE' => '-',
          'NO_JOB' => 'DATAEMPTY',
          'KODE_ITEM' => 'DATAEMPTY',
          'DESCRIPTION' => 'DATAEMPTY',
          'QTY_JOB' => 'DATAEMPTY',
          'REMAINING_QTY' => 'DATAEMPTY',
          'REMAINING_WIP' => 'DATAEMPTY'
        ];
        $this->load->view('CompletionAGT/ajax/V_Item', $data);
      }else {
        echo 0;
      }
    }

    public function cekjobdipos1()
    {
      echo json_encode($this->M_master->cekjobdipos1($this->input->post('item_id')));
    }

    public function insertpos1()
    {
      echo json_encode($this->M_master->insertpos1($this->input->post('no_job'), $this->input->post('item_code'), $this->input->post('description'), $this->input->post('item_id')));
    }

    public function Completion()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard Completion Assembly Gear Transmission V.1.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CompletionAGT/V_Completion', $data);
        $this->load->view('V_Footer', $data);
    }

    public function Monitoring($value='')
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard Completion Assembly Gear Transmission V.1.0';
      $data['SubMenuOne'] = '';
      $data['SubMenuTwo'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('CompletionAGT/V_Monitoring', $data);
      $this->load->view('V_Footer', $data);
    }

    public function updatepos($value='')
    {
      $data = [
        'ITEM_ID' => $this->input->post('item_id'),
        'STATUS_JOB' => $this->input->post('status_job')
      ];
      echo json_encode($this->M_master->updatepos($data));
    }

    public function delpos($value='')
    {
      echo json_encode($this->M_master->delpos($this->input->post('item_id')));
    }

    public function jobrelease($value='')
    {
      $data['get'] = [];
      $this->load->view('CompletionAGT/monitoring/V_Job_Release', $data);
    }

    public function runningandon($value='')
    {
      $data['get'] = $this->M_master->runningandon();
      $this->load->view('CompletionAGT/monitoring/V_Running_Andon', $data);
    }

    public function historyandon($value='')
    {
      $data['get'] = $this->M_master->historyandon();
      $this->load->view('CompletionAGT/monitoring/V_History_Andon', $data);
    }

    public function filter_history_agt()
    {
      $data['get'] = $this->M_master->filter_history_agt($this->input->post('range_date'));
      $this->load->view('CompletionAGT/monitoring/V_History_Filtered', $data);
    }

    public function filter_job_agt()
    {
      $data['get'] = $this->M_master->filter_job_agt($this->input->post('range_date'));
      $this->load->view('CompletionAGT/monitoring/V_Job_Filtered', $data);
    }

    public function timerAndon($value='')
    {
      $data['get'] = $this->M_master->dataTimer();
      $this->load->view('CompletionAGT/monitoring/V_Timer_Andon', $data);
    }

    public function save_timer($value='')
    {
      $res = $this->M_master->andon_timer($this->input->post('data_timer'));
      echo json_encode($res);
    }


}
