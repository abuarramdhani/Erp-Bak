<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_OrderIn extends CI_Controller
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
        $data['Menu'] = 'Order In';
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

        $data['get'] = $this->M_master->getOrderIn();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderPrototypePPIC/V_OrderIn');
        $this->load->view('V_Footer', $data);
    }

    public function Create()
    {
        // echo "<pre>";
        // print_r($this->session->kodesie);
        // die;
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Create';
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

        $data['jenis_proses'] = $this->db->order_by('nama_proses', 'asc')->get('opp.jenis_proses')->result_array();
        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('OrderPrototypePPIC/V_Create');
        $this->load->view('V_Footer', $data);
    }

    public function getSeksiBy()
    {
      echo json_encode($this->M_master->getSeksiBy($this->input->post('kodesie')));
    }

    public function getSeksi()
    {
        $term = strtoupper($this->input->post('term'));
        echo json_encode($this->M_master->getSeksi($term));
    }

    public function Insert($value='')
    {
      unset($_POST['button']);

      // upload file => menunggu keputusan.

      $kode = $this->input->post('kode_komp');
      if (!empty($kode)) {
        foreach ($kode as $key => $value) {
          $data = [
            'no_order' => $this->input->post('no_order'),
            'pic_pengorder' => $this->input->post('pic'),
            'seksi_pengorder' => $this->input->post('seksi'),
            'kode_komponen' => $value,
            'nama_komponen' => $this->input->post('nama_komp')[$key],
            'qty' => $this->input->post('qty')[$key],
            'need' => $this->input->post('need')[$key],
            'material' => $this->input->post('material')[$key],
            'dimensi_pot_t' => $this->input->post('dimensi_t')[$key],
            'dimensi_pot_p' => $this->input->post('dimensi_p')[$key],
            'dimensi_pot_l' => $this->input->post('dimensi_l')[$key],
            'gol' => $this->input->post('gol')[$key],
            'jenis' => $this->input->post('jenis')[$key],
            'p_a' => $this->input->post('p_a')[$key],
            'upper_level' => $this->input->post('upper_level')[$key],
            'cek_kode' => $this->input->post('cek_kode')[$key],
            'cek_mon' => $this->input->post('cek_mon')[$key],
            'cek_nama' => $this->input->post('cek_nama')[$key],
            'gambar_kerja' => NULL,
            'project' => $this->input->post('project')[$key],
            'produk' => $this->input->post('produk')[$key]
          ];

          $res = $this->M_master->Insert($data);
          if ($res != 0) {
            $p_proses = $this->input->post('p_proses')[$key+1];
            foreach ($p_proses as $key2 => $value) {
              $data_proses = [
                'id_order' => $res,
                'proses' => $value,
                'seksi'  => $this->input->post('p_seksi')[$key+1][$key2]
              ];
                // echo "<pre>";print_r($data_proses);
              $this->M_master->InsertprosesID($data_proses);
            }
          // }
        }
      }

      if ($res != 0) {
        redirect('OrderPrototypePPIC/OrderIn');
      }else {
        echo "<h1 style='text-align:center'>Something error when inserting data.</h1>";
        die;
      }
     }
     echo "<h1 style='text-align:center'>Data Is Empty</h1>";
     die;
    }

    public function getProsesOPP()
    {
      $data['get'] = $this->M_master->getProsesOPP($this->input->post('id'));
      $data['no_urut'] = $this->input->post('nomer_urut');
      $this->load->view('OrderPrototypePPIC/ajax/V_DetailProses', $data);
    }

    public function getProsesMonOPP()
    {
      $data['get'] = $this->M_master->getProsesMon($this->input->post('id'));
      $data['no_urut'] = $this->input->post('nomer_urut');
      $this->load->view('OrderPrototypePPIC/ajax/V_Detail_Mon', $data);
    }

    public function getEditProsesOPP()
    {
      $data['get'] = $this->M_master->getProsesOPP($this->input->post('id'));
      $data['id'] = $this->input->post('id');
      $data['no_urut'] = $this->input->post('nomer_urut');
      $data['nama_proses'] = $this->db->order_by('nama_proses', 'asc')->get('opp.jenis_proses')->result_array();
      $data['seksi'] = $this->M_master->getSeksi('');
      $this->load->view('OrderPrototypePPIC/ajax/V_EditProses', $data);
    }

    public function edit_proses_opp($value='')
    {
      if ($this->input->is_ajax_request()) {
        $data = $this->input->post('data');
        $this->db->delete('opp.proses', ['id_order' => $data[0]['id_order']]);
        foreach ($data as $key => $value) {
          // echo "<pre>";print_r($value);
          if ($value['id'] == 'n') {
            unset($value['id']);
            $this->db->insert('opp.proses', $value);
          }else {
            $this->db->insert('opp.proses', $value);
          }
        }
        echo json_encode(1);
      }else {
        echo json_encode(0);
      }
    }

    // ============================ CHECK AREA =====================================

    public function cekapi()
    {
      $data_a = $this->M_master->getProsesOPP(2);
      echo "<pre>";
      print_r($data_a);
      echo sizeof($data_a);
      die;
    }
}
