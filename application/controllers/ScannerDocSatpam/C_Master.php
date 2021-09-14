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
        $this->load->library('form_validation');
        $this->load->library('upload');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        // if ($this->session->userdata('logged_in')!=true) {
        //     $this->load->helper('url');
        //     $this->session->set_userdata('last_page', current_url());
        //     $this->session->set_userdata('Responsbility', 'some_value');
        // }
    }

    // public function checkSession()
    // {
    //     if ($this->session->is_logged) {
    //     } else {
    //         redirect('');
    //     }
    // }

    public function time()
    {
      echo '<h2>'.date('d/m/Y h:i:s').' WIB</h2>';
    }

    public function uploadDocSatpam()
    {
      // $in = file_get_contents('php://input');
      // $decoded = json_decode($in, true);
      // $jumlah = count($_FILES['foto_doc_satpam']['name']);
      // for ($i=0; $i < $jumlah; $i++) {
        if (!empty($_FILES['foto_doc_satpam']['name'])) {
          $name_path = $this->input->post('nama_file');
          if (empty($name_path)) {
            $name_path = 'doc_satpam_'.date('YmdHis');
          }
          $_FILES['file']['name'] = $_FILES['foto_doc_satpam']['name'];
          $_FILES['file']['type'] = $_FILES['foto_doc_satpam']['type'];
          $_FILES['file']['tmp_name'] = $_FILES['foto_doc_satpam']['tmp_name'];
          $_FILES['file']['error'] = $_FILES['foto_doc_satpam']['error'];
          $_FILES['file']['size'] = $_FILES['foto_doc_satpam']['size'];

          $config['upload_path']      = './assets/assets/docsatpam/';
          $config['file_name']        = $name_path.'.jpeg';
          $config['remove_spaces']    = true;
          $config['overwrite']        = true;
          $config['allowed_types']    = 'jpg|png|jpeg';
          $this->upload->initialize($config);
          if (!is_dir('./assets/assets/docsatpam/')) {
              mkdir('./assets/assets/docsatpam/', 0777, true);
              chmod('./assets/assets/docsatpam/', 0777);
          }
          if (! $this->upload->do_upload('file')) {
              $error = array('error' => $this->upload->display_errors());
              print_r($error);
              die;
          } else {
              $data = array('upload_data' => $this->upload->data());
              $this->api->print_json(array(
              'success' => true,
              'message' => 'Photo Data Has Been Uploaded.'
            ));
          }
          $path_doc_satpam = $config['file_name'];
      } else {
          $path_doc_satpam = null;
          $this->api->print_json(array(
          'success' => false,
          'message' => 'Photo Data Not Detected.'
        ));
        die;
      }
      // }
      // $doc_satpam = implode(', ', $path_doc_satpam);
      // $data = [
      //   'foto_doc_satpam' => $path_doc_satpam,
      // ];
      // $insert = $this->M_Web->uploadDocSatpam($data);
      // $response = ['result' => array_values($insert)];
      // $this->api->print_json($insert);
    }

    public function scanfile()
    {
      $this->load->view('ScannerDocSatpam/V_DocSatpam');
    }

}
