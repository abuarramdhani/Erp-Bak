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

        $data['Title'] = 'Dashboard Consumable Seksi V.2.0';
        $data['Menu'] = 'Dashboard Consumable Seksi V.2.0';
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

    public function inputkebutuhan()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Title'] = 'Dashboard Consumable Seksi V.2.0';
        $data['Menu'] = 'Dashboard Consumable Seksi V.2.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['get'] = $this->md->getkebutuhan();
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ConsumableV2/SEKSI/V_Inputkebutuhan', $data);
        $this->load->view('V_Footer', $data);
    }

    public function getitem()
    {
      $term = strtoupper($this->input->post('term'));
      echo json_encode($this->md->getItem($term));
    }

    public function savekebutuhan($value='')
    {
      try {
        if ($this->session->is_logged) {
          $res = $this->md->savekebutuhan($this->input->post());
        }else {
          $res = 0;
        }
        // echo "<pre>";
        // print_r($this->input->post());
        echo json_encode($res);
      } catch (\Exception $e) {
        return $this->output
          ->set_content_type('application/json')
          ->set_status_header(400)
          ->set_output(json_encode(array(
            'message' => $e->getMessage()
          )));
      }
    }

    public function pengajuan()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Title'] = 'Dashboard Consumable Seksi V.2.0';
        $data['Menu'] = 'Dashboard Consumable Seksi V.2.0';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('ConsumableV2/SEKSI/V_Pengajuan', $data);
        $this->load->view('V_Footer', $data);
    }



}
