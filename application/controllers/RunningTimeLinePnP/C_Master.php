<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
        //load the login model
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->model('M_Index');
        $this->load->library('upload');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        //local
        $this->load->model('RunningTimeLinePnP/M_rtlp');

        date_default_timezone_set('Asia/Jakarta');

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
            redirect();
        }
    }

    public function Lane5()
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      // $date = '2020-05-29'; //for trial
      $date = date('Y-m-d');
      $line5 = $this->M_rtlp->getline5($date);
      if (!empty($line5)) {
        foreach ($line5 as $key => $value) {
          $getNamaKomponen = $this->M_rtlp->getNamaKomponen($value['kode_item']);
          $line5[$key]['nama_komponen'] = $getNamaKomponen->nama_item;
        }
      }

      $data['line5'] = $line5;

      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('RunningTimeLinePnP/V_Lane5');
      $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    //------------------------show the dashboard-----------------------------
    public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('RunningTimeLinePnP/V_Index');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    public function setting()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // $date = '2020-05-29'; //for trial
        $date = date('Y-m-d');

        $line1 = $this->M_rtlp->getline1($date);
        if (!empty($line1)) {
          foreach ($line1 as $key => $value) {
            $getNamaKomponen = $this->M_rtlp->getNamaKomponen($value['kode_item']);
            $line1[$key]['nama_komponen'] = $getNamaKomponen->nama_item;
          }
        }
        $line2 = $this->M_rtlp->getline2($date);
        if (!empty($line2)) {
          foreach ($line2 as $key => $value) {
            $getNamaKomponen = $this->M_rtlp->getNamaKomponen($value['kode_item']);
            $line2[$key]['nama_komponen'] = $getNamaKomponen->nama_item;
          }
        }
        // $line5 = $this->M_rtlp->getline5($date);

        $data['line_1'] = $line1;
        $data['line_2'] = $line2;

        // $data['line_5'] = $line5;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('RunningTimeLinePnP/V_Setting');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    public function insertTimePause()
    {
      $data = [
        'No_Job' => $this->input->post('no_job'),
        'Kode_Item' => $this->input->post('code'),
        'Line' => $this->input->post('line'),
        'No' => $this->input->post('no'),
        'Pause_Start' => $this->input->post('waktu_mulai')
      ];

      $result = $this->M_rtlp->insertTimePause($data);
      echo json_encode($result);
    }

    public function detail()
    {
     if (!$this->input->is_ajax_request()) {
       echo "Akses terlarang!";
     }else {
       $data['get'] =  $this->M_rtlp->getDetailBom($this->input->post('kode_item'));
       $this->load->view('RunningTimeLinePnP/ajax/V_Detail', $data);
     }
    }

    public function setting34()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // $date = '2020-05-29'; //for trial
        $date = date('Y-m-d');

        $line3 = $this->M_rtlp->getline3($date);
        if (!empty($line3)) {
          foreach ($line3 as $key => $value) {
            $getNamaKomponen = $this->M_rtlp->getNamaKomponen($value['kode_item']);
            $line3[$key]['nama_komponen'] = $getNamaKomponen->nama_item;
          }
        }

        $line4 = $this->M_rtlp->getline4($date);
        if (!empty($line4)) {
          foreach ($line4 as $key => $value) {
            $getNamaKomponen = $this->M_rtlp->getNamaKomponen($value['kode_item']);
            $line4[$key]['nama_komponen'] = $getNamaKomponen->nama_item;
          }
        }
        // $line5 = $this->M_rtlp->getline5($date);

        $data['line_3'] = $line3;
        $data['line_4'] = $line4;
        // $data['line_5'] = $line5;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('RunningTimeLinePnP/V_Setting34');
        $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }

    public function SetStart()
    {
      $data = $this->M_rtlp->SetStart([
        'Line'     => $this->input->post('line'),
        'Komponen' => $this->input->post('code'),
        'Start'    => $this->input->post('waktu_mulai'),
        'No_Job'   => $this->input->post('no_job'),
        'Tanggal'  => date('Y-m-d')
      ]);
      echo json_encode($data);
    }

    public function SetFinish()
    {
      $data = $this->M_rtlp->SetFinish([
        'Finish'   => $this->input->post('waktu_selesai'),
        'Line'     => $this->input->post('line'),
        'Komponen' => $this->input->post('code'),
        'No_Job'   => $this->input->post('no_job'),
        'Time'     => $this->input->post('lama_waktu')
      ]);
      echo json_encode($data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2]."-".$ss[1]."-".$ss[0];
    }

    public function history()
    {
      $this->checkSession();
      $user_id = $this->session->userid;

      $data['Menu'] = 'Dashboard';
      $data['SubMenuOne'] = '';

      $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
      $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
      $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

      $data['get'] = $this->M_rtlp->getHistory();
      if (!empty($data['get'])) {
        foreach ($data['get'] as $key => $value) {
          $getNamaKomponen = $this->M_rtlp->getNamaKomponen($value['Komponen']);
          $data['get'][$key]['Nama_Komponen']  = '-';
          if (!empty($getNamaKomponen->nama_item)) {
              $data['get'][$key]['Nama_Komponen'] = $getNamaKomponen->nama_item;
          }
        }
      }
      $this->load->view('V_Header', $data);
      $this->load->view('V_Sidemenu', $data);
      $this->load->view('RunningTimeLinePnP/V_History');
      $this->load->view('WorkInProcessPackaging/V_Footer_Custom', $data);
    }


    // ============================ CHECK AREA =====================================

    public function cekapi()
    {
      $data_a = $this->M_rtlp->getDetailBom('AAG2EA0001AY-1');
      // $data_a = $this->M_rtlp->getItem();
      echo "<pre>";
      print_r($data_a);
      echo sizeof($data_a);
      die;
    }
}
