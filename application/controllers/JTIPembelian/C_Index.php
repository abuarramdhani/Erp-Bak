<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Index extends CI_Controller
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
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        //local
        $this->load->model('JTIPembelian/M_jtipembelian');

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
        $this->load->view('JTIPembelian/V_Index');
        $this->load->view('V_Footer', $data);
    }

    public function Input()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Input';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['jenis_dokumen'] = $this->M_jtipembelian->getTypes();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('JTIPembelian/V_Input', $data);
        $this->load->view('V_Footer', $data);
    }


    public function print_json($value)
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode($value);
    }

    public function addDriver()
    {
        $this->print_json($this->M_jtipembelian->addDriver(array(
            'name' => strtoupper(trim($this->security->xss_clean($this->input->post('name')))),
            'document_number' => strtoupper(trim($this->security->xss_clean($this->input->post('document_number')))),
            'id_card' => strtoupper(trim($this->security->xss_clean($this->input->post('id_card')))),
            'estimation' => strtoupper(trim($this->security->xss_clean($this->input->post('estimation')))),
            'document_type' => $this->input->post('jenis_dokumen'),
            'type' => $this->input->post('type'),
            'created_by' => strtoupper(trim($this->security->xss_clean($this->input->post('created_by'))))
        )));
    }

    public function History()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'History';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['get'] = $this->M_jtipembelian->History($this->session->user);
        // echo "<pre>";
        // print_r($data['get']);
        // die;
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('JTIPembelian/V_History', $data);
        $this->load->view('V_Footer', $data);
    }

    public function updateNamaDriver()
    {
      if (!$this->input->is_ajax_request()) {
        echo "Hai..";
      }else {
        $res = $this->M_jtipembelian->updateNamaDriver(['name' => $this->input->post('nama_driver')], $this->input->post('id'));
        echo json_encode($res);
      }
    }

    public function getHistoryJTI()
    {
      $data['get'] = $this->M_jtipembelian->History($this->session->user);
      $this->load->view('JTIPembelian/AjaxJTI/V_Ajax', $data);
    }

    public function updateResponseJTI()
    {
      $data = [
        'id' => $this->input->post('id'),
        'response' => $this->input->post('response')
      ];
      $this->M_jtipembelian->updateResponseJTI($data);
      echo json_encode('200 Joss');
    }

    public function getNotfication()
    {
      $id = $this->input->post('id');
      echo json_encode($this->M_jtipembelian->getNotfication($id));
    }

    public function updateResponseJTIDone()
    {
      $data = [
        'id' => $this->input->post('id'),
        'done' => 't'
      ];
      $this->M_jtipembelian->updateResponseJTIDone($data);
      echo json_encode('200 Joss');
    }

    public function cek()
    {
      $data['get'] = $this->M_jtipembelian->History($this->session->user);
      echo "<pre>";
      print_r($data['get']);
      die;
    }


}

// aak300a021ay cek bro, hapus aak2aaa001by, aak2000001ay hendle bar group, hendle aakaaa061ay, aak2aaa001by subassy
