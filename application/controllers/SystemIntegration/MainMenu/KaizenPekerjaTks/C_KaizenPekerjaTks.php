<?php defined('BASEPATH') or exit('No direct script access allowed');

class C_KaizenPekerjaTks extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');

    $this->load->model('M_index');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('SystemIntegration/KaizenTks/M_kaizentks');

    if ($this->session->userdata('logged_in') != TRUE) {
      $this->load->helper('url');
      $this->session->set_userdata('last_page', current_url());
      $this->session->set_userdata('Responsbility', 'some_value');
    }
  }

  public function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('index');
    }
  }

  function index()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Kaizen Pekerja Tuksono';
    $data['Header']      =  'Input Kaizen Pekerja Tuksono';
    $data['Menu']       =   'Input Data Kaizen';
    $data['SubMenuOne']   =   '';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $data["kaizenCategory"] = $this->M_kaizentks->kaizenCategory();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenPekerjaTks/V_Input_data_kaizen', $data);
    $this->load->view('V_Footer', $data);
  }

  function getEmployees()
  {
    $search = $this->input->get('searchTerm');
    $respose = $this->M_kaizentks->getEmployees($search);

    echo json_encode($respose);
  }

  function addKaizen()
  {
    $user = $this->session->user;
    $kaizenTks = $this->M_kaizentks;
    $validation = $this->form_validation;
    $validation->set_rules($kaizenTks->rules());

    if ($validation->run()) {
      if ($kaizenTks->saveKaizen($user) == "gagal") {
        $this->session->set_flashdata('failed', 'Kaizen gagal diinput, File salah atau terlalu besar');
        $this->index();
      } else {
        $kaizenTks->saveTlog($user);
        $this->session->set_flashdata('success', 'Kaizen berhasil diinput');
        $this->index();
      }
    } else {
      $this->session->set_flashdata('failed', 'Kaizen gagal diinput, pastikan data terisi semua');
      $this->index();
    }
  }

  function rekapDataKaizen()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Kaizen Pekerja Tuksono';
    $data['Header']      =  'Rekap Kaizen Pekerja Tuksono';
    $data['Menu']       =   'Rekap Data Kaizen';
    $data['SubMenuOne']   =   '';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenPekerjaTks/V_Rekap_data_kaizen', $data);
    $this->load->view('V_Footer', $data);
  }

  function editKaizen($id = null)
  {
    if (!isset($id));
    $kaizenTks = $this->M_kaizentks;
    $validation = $this->from_validation;
    $validation->set_rules($kaizenTks->rules());

    if ($validation->run()) {
      $kaizenTks->updateKaizen();
      $this->session->set_flashdata('success', 'Kaizen berhasil diupdate');
    }

    $data["employee"] = $kaizenTks->getEmployee($id);
    if (!$data["employee"]) {
      $this->session->set_flashdata('failed', 'Edit gagal ID tidak ditemukan');
      $this->editDataKaizen();
    } else {
      $this->session->set_flashdata('success', 'Edit Berhasil disimpan');
      $this->editDataKaizen();
    }
  }

  function editDataKaizen($id = null)
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title']      =  'Kaizen Pekerja Tuksono';
    $data['Header']      =  'Edit Kaizen Pekerja Tuksono';
    $data['Menu']       =   'Edit Data Kaizen';
    $data['SubMenuOne']   =   '';
    $data['SubMenuTwo']   =   '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $kaizenTks = $this->M_kaizentks;
    $data["employee"] = $kaizenTks->getEmployee($id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenPekerjaTks/V_edit_data_kaizen', $data);
    $this->load->view('V_Footer', $data);
  }

  function updateKaizenKu()
  {
    $user = $this->session->user;
    $get = $this->input->get();
    $id = $get['id'];
    $data = array(
      'updated_at' => date('Y-m-d H:i:s'),
      'updated_by' => $user,
      'kaizen_title' => $get['judul'],
      'kaizen_category' => $get['kategori'],
    );
    // if (!empty($_FILES["inputFile"]["name"])) {
    //   $this->image = $this->_uploadImage();
    // } else {
    //   $this->image = $post["old_image"];
    // }
    // print("<pre>");
    // print_r($id);
    // die;
    $this->M_kaizentks->updateKaizen($data, $id);
  }

  /**
   * REST API
   * @method GET
   * @return JSON
   */

  public function getAllKaizen()
  {

    $data = $this->M_kaizentks->getCountKaizen();

    $array = [];
    foreach ($data as $key => $value) {
      $no = $key + 1;
      $sub_data = [];
      $sub_data['no'] = $no;
      $sub_data['no_ind'] = $value['no_ind'];
      $sub_data['name'] = $value['name'];
      $sub_data['section'] = $value['section'];
      $sub_data['total'] = $value['total'];
      $array[] = $sub_data;
    }

    echo json_encode(array(
      'success' => true,
      'data' => $array,
    ));
  }

  public function getKaizenByNoind()
  {
    $noind = $this->input->get('noind');
    $data = $this->M_kaizentks->getKaizenByNoind($noind);

    echo json_encode(array(
      'success' => true,
      'data' => $data
    ));
  }

  public function deleteKaizenKu()
  {
    $get = $this->input->get();
    $id = $get['id'];
    $file = $get['kaizen_file'];
    // $url = base_url('assets/upload/uploadKaizenTks/');
    // print("<pre>");
    // print_r($url);
    // die;
    $this->M_kaizentks->deleteKaizen($id, $file);
  }
}
