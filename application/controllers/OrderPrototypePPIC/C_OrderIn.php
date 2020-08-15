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

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

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

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

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
      // echo "<pre>";
      // print_r($_FILES['file_gm']);
      // die;
      $kode = $this->input->post('kode_komp');
      // if (!empty($_FILES['file_gm'])) {
      //     if (!is_dir('./assets/upload/')) {
      //         mkdir('./assets/upload/', 0777, true);
      //         chmod('./assets/upload/', 0777);
      //     }
      //
      //     $config['upload_path']      = './assets/upload/';
      //     $config['file_name']        = $kode.'_Gambar_Kerja.jpeg';
      //     $config['remove_spaces']    = true;
      //     $config['allowed_types']    = '*';
      //     $this->upload->initialize($config);
      //     if (! $this->upload->do_upload('file')) {
      //         $error = array('error' => $this->upload->display_errors());
      //         print_r($error);
      //     } else {
      //         $data = array('upload_data' => $this->upload->data());
      //     }
      //     $path = $config['upload_path'].$config['file_name'];
      // }

      $data = [
        'kode_komponen' => $kode,
        'nama_komponen' => $this->input->post('nama_komp'),
        'no_order' => $this->input->post('no_order'),
        'qty' => $this->input->post('qty'),
        'need' => $this->input->post('need'),
        'material' => $this->input->post('material'),
        'dimensi_pot_t' => $this->input->post('dimensi_t'),
        'dimensi_pot_p' => $this->input->post('dimensi_p'),
        'dimensi_pot_l' => $this->input->post('dimensi_l'),
        'gol' => $this->input->post('gol'),
        'jenis' => $this->input->post('jenis'),
        'p_a' => $this->input->post('p_a'),
        'pic_pengorder' => $this->input->post('pic'),
        'seksi_pengorder' => $this->input->post('seksi'),
        'upper_level' => $this->input->post('upper_level'),
        'cek_kode' => $this->input->post('cek_kode'),
        'cek_mon' => $this->input->post('cek_mon'),
        'cek_nama' => $this->input->post('cek_nama'),
        'gambar_kerja' => NULL,
        'project' => $this->input->post('project'),
        'produk' => $this->input->post('produk')
      ];

      $res = $this->M_master->Insert($data);

      if ($res != 0) {
        $p_proses = $this->input->post('p_proses');
        foreach ($p_proses as $key => $value) {
          $data_proses = [
            'id_order' => $res,
            'proses' => $value,
            'seksi'  => $this->input->post('p_seksi')[$key]
          ];
          $this->M_master->InsertprosesID($data_proses);
        }
        redirect('OrderPrototypePPIC/OrderIn');
      }else {
        echo "<h1 style='text-align:center'>Something error when inserting data.</h1>";
        die;
      }

    }

    public function getProsesOPP()
    {
      $data['get'] = $this->M_master->getProsesOPP($this->input->post('id'));
      $this->load->view('OrderPrototypePPIC/ajax/V_DetailProses', $data);
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
