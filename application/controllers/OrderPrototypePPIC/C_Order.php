<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Order extends CI_Controller
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
        $this->load->model('SystemAdministration/MainMenu/M_user');

        //local
        $this->load->model('OrderPrototypePPIC/M_master');

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

        $data['Menu'] = 'Order PPIC';
        $data['SubMenuOne'] = '';

        $menu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        // $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        // $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        if ($this->session->user === 'T0012' || $this->session->user === 'B0681') {
          redirect('OrderPrototypePPIC');
        }else {
          unset($menu[1]);
          unset($menu[2]);
          unset($menu[3]);
        }

        $data['UserMenu'] = $menu;

        $data['get'] = $this->M_master->getOrderOutAcc();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderPrototypePPIC/V_Order');
        $this->load->view('V_Footer', $data);
    }

    public function terima($value='')
    {
      if ($this->input->is_ajax_request()) {
        $penerima = $this->session->user.' - '.$this->session->employee;
        $this->db->where('id', $this->input->post('id_proses'))->update('opp.proses', ['status' => 'Y', 'penerima' => $penerima]);
        if ($this->db->affected_rows() == 1) {
          echo json_encode(1);
        }else {
          echo json_encode(0);
        }
      }else {
        echo "hello..";
      }
    }

    public function konfirmasi($value='')
    {
      if ($this->input->is_ajax_request()) {
        $this->db->where('id', $this->input->post('id_proses'))->update('opp.proses', ['status' => 'D']);
        if ($this->db->affected_rows() == 1) {
          echo json_encode(1);
        }else {
          echo json_encode(0);
        }
      }else {
        echo "hello..";
      }
    }

}
