<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_OrderOut extends CI_Controller
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

        $data['Menu'] = 'Order Out';
        $data['SubMenuOne'] = '';

        $menu = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        // $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        // $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        if ($this->session->user === 'T0012' || $this->session->user === 'B0681') {
          unset($menu[0]);
          foreach ($menu as $key => $value) {
            $menu_baru[] = $value;
          }
          $menu = $menu_baru;
          $data['UserMenu'] = $menu;
        }else {
          redirect('OrderPrototypePPIC');
        }

        $data['get'] = $this->M_master->getOrderOut();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderPrototypePPIC/V_OrderOut');
        $this->load->view('V_Footer', $data);
    }

    public function generateOrderOut($value='')
    {
       $max_id = $this->db->select_max('id')->get('opp.order_out')->row_array();
       $data = $this->db->select('no_order_out')->where('id', $max_id['id'])->get('opp.order_out')->row_array();
       $lastMemoNumber = $data['no_order_out'];

      if (empty($lastMemoNumber)) {
          $newMemoNumber = '000001';
      } else {
          $newNumber = $lastMemoNumber+1;
          if (strlen($newNumber) < 6) {
              $newNumber = str_pad($newNumber, 6, "0", STR_PAD_LEFT);
          }
          $newMemoNumber = $newNumber;
      }
      echo json_encode($newMemoNumber);
    }

    public function addOrderOut($value='')
    {
      if ($this->input->is_ajax_request()) {
        if (!empty($this->input->post('data'))) {
          foreach ($this->input->post('data') as $key => $value) {
            $this->db->insert('opp.order_out', $value);
            // echo "<pre>";print_r($value);
          }
          // die;
          if ($this->db->affected_rows() == 1) {
            echo json_encode(1);
          }else {
            echo json_encode(0);
          }
        }else {
          echo json_encode(0);
        }
      }else {
        echo json_encode(0);
      }
    }

    public function getOrder()
    {
      if ($this->input->is_ajax_request()) {
        echo json_encode($this->db->where('id', $this->input->post('id'))->get('opp.order')->row_array());
      }else {
        echo "hello..";
      }
    }

    public function getUnitDepartemen($value='')
    {
      if ($this->input->is_ajax_request()) {
        echo json_encode($this->M_master->getDept($this->input->post('seksi')));
      }else {
        echo "hello..";
      }
    }

    // ============================ CHECK AREA =====================================

    public function cekapi()
    {
      $data_a = $this->M_master->cek();
      echo "<pre>";
      print_r($data_a);
      die;
    }
}
