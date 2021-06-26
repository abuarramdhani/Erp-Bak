<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Handling extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->library('form_validation');
    $this->load->library('encrypt');
    //load the login model
    $this->load->library('session');
    $this->load->library('ciqrcode');
    $this->load->model('M_Index');
    $this->load->library('upload');
    $this->load->model('SystemAdministration/MainMenu/M_user');

    $this->load->model('MenjawabTemuanAudite/MainMenu/M_handling');

    date_default_timezone_set('Asia/Jakarta');

    if ($this->session->userdata('logged_in') != true) {
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


  //------------------------show the index-----------------------------
  public function index()
  {
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['title'] = 'Handling';
    $data['Menu'] = 'Menjawab Temuan Audite';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
    $no_induk = $this->session->user;
    $data['area'] = $this->M_handling->getSeksiLogged($no_induk);
    // echo "<pre>";print_r($data['area']['seksi']);die;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MenjawabTemuanAudite/Handling/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  public function getAjax()
  {
    $area_handling = $this->input->post('area_handling');
    $data['get_audit_handling'] = $this->M_handling->getAuditOpen($area_handling);
    // echo "<pre>";print_r($data['get_audit_handling']);die;
    if (!empty($data['get_audit_handling'])) {
      // array_unshift($data['get_audit_handling'],['tanggal_audit' => 'AVENGERS']);
      $this->load->view('MenjawabTemuanAudite/Handling/V_ajax', $data);
    }else {
      echo 0;
    }
    // echo "<pre>";print_r($data['get_audit_handling']);die;
  }

  public function getGambarBefore()
  {
    $id_before = $this->input->post('id');
    $data['getGambarBefore'] = $this->M_handling->getGambarBefore($id_before);
    // echo "<pre>";print_r($id);die;
    $this->load->view('MenjawabTemuanAudite/Handling/V_GambarBefore', $data);
  }

  public function getGambarAfter()
  {
    $id_after = $this->input->post('id');
    $data['getGambarAfter'] = $this->M_handling->getGambarAfter($id_after);
    // echo "<pre>";print_r($id);die;
    $this->load->view('MenjawabTemuanAudite/Handling/V_GambarAfter', $data);
  }

  //------------------------Edit View-----------------------------
  public function edit($encrypted)
  {
    $user_id = $this->session->userid;
    $encrypted = explode("%20", $encrypted);
    $encrypted_string2 = $encrypted[0];
    $encrypted_string = $encrypted[1];
    $id_audit = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted[0]);
    $id_audit = $this->encrypt->decode($id_audit);
    $id_temuan = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted[1]);
    $id_temuan = $this->encrypt->decode($id_temuan);

    $data['title'] = 'Handling';
    $data['Menu'] = 'Menjawab Temuan Audite';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $data['id'] = $encrypted_string;
    $data['getAudit'] = $this->M_handling->getAudit($id_temuan);
    $data['getAuditY'] = $this->M_handling->getAuditY($id_audit);
    $data['getAuditAlasan'] = $this->M_handling->getAuditAlasan($id_audit);

    // echo "<pre>";print_r($data['getAuditAlasan']);die;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MenjawabTemuanAudite/Handling/V_Edit', $data);
    $this->load->view('V_Footer', $data);
  }

  //------------------------Update Insert Function-----------------------------
  public function insert($id)
  {
    $this->checkSession();
    $user_id = $this->session->userid;

    $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

    // echo $plaintext_string;die;

    $jumlah = count($_FILES['foto_after']['name']);
    for ($i=0; $i < $jumlah; $i++) {
      $config['upload_path']    = './assets/upload/MenjawabTemuanAudite/Handling/';
      $config['file_name']      = 'pa_'.date('YmdHis').$i.'.jpeg';
      $config['remove_spaces']  = true;
      $config['allowed_types']  = 'jpg|jpeg|png';
      // $config['quality']        = 60;
      // $config['max_size']       = 5000;
      $this->upload->initialize($config);
      if (!is_dir('./assets/upload/MenjawabTemuanAudite/Handling/')) {
          mkdir('./assets/upload/MenjawabTemuanAudite/Handling/', 0777, true);
          chmod('./assets/upload/MenjawabTemuanAudite/Handling', 0777);
      }

      if (!empty($_FILES['foto_after']['name'][$i])) {
        $_FILES['file']['name'] = $_FILES['foto_after']['name'][$i];
        $_FILES['file']['type'] = $_FILES['foto_after']['type'][$i];
        $_FILES['file']['tmp_name'] = $_FILES['foto_after']['tmp_name'][$i];
        $_FILES['file']['error'] = $_FILES['foto_after']['error'][$i];
        $_FILES['file']['size'] = $_FILES['foto_after']['size'][$i];
        if (! $this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            echo "Error... File is Unidentified";
            die;
        }else {
          $data = array('upload_data' => $this->upload->data());
        }
          $path_after[$i] = /*$config['upload_path'].*/$config['file_name'];
        // echo "<pre>";print_r($path_after);die;
      }else {
        echo "Error... what the error ?";
        die;
      }
    }
    // $i = 0;
    // foreach ($path_after as $fa) {
      $after = implode(', ', $path_after);
      if ($this->input->post('tanggal_verif') != NULL) {
        $tanggal_verif = $this->input->post('tanggal_verif');
      }else {
        $tanggal_verif = NULL;
      }
      // $d = strtotime($this->input->post('tanggal_verif'));
      // $date = date('Y/m/d', $d);
      $data = [
        'id_audit' => $this->input->post('id_audit'),
        'id_temuan' => $this->input->post('id_temuan'),
        'action_plan' => $this->input->post('action_plan'),
        'foto_after' => $after,
        'last_update_date' => date('Y-m-d H:i:s'),
        'last_update_by' => $this->session->user,
      ];
      // echo "<pre>";print_r($data);die;
      // echo "<pre>";print_r($id_jawaban);echo " & ";print_r($id_temuan);die;

      $insert = $this->M_handling->insMenjawabHandling($data);
      echo json_encode($insert);

      // $id_audit = $this->input->post('id_audit');
      $data['id_jawaban'] = $this->M_handling->getAudit($plaintext_string);
      $id_temuan = $data['id_jawaban'][0]['id_temuan'];
      $id_jawaban = $data['id_jawaban'][0]['id_jawaban'];
      $update = $this->M_handling->updMenjawabHandling($id_temuan, $id_jawaban);
      echo json_encode($update);
      // $i ++;
    // }
      redirect(site_url('MenjawabTemuanAudite/Handling'));
  }

  public function getSeksi()
  {
    $param = $this->input->post('term');
    $param = strtoupper($param);
    $data = $this->M_handling->getSeksi($param);
    echo json_encode($data);
  }

  public function pdfHandling($encrypted)
  {
    $encrypted = explode("%20", $encrypted);
    $encrypted_string2 = $encrypted[0];
    $encrypted_string = $encrypted[1];
    $id_audit = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted[0]);
    $id_audit = $this->encrypt->decode($id_audit);
    $id_temuan = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted[1]);
    $id_temuan = $this->encrypt->decode($id_temuan);
    // echo "<pre>";echo $id_audit.' '.$id_temuan;die;
    $this->load->library('pdf');

    $data['handlingPdf'] = $this->M_handling->handlingPDF($id_audit);
    $data['gambarHandlingPdf'] = $this->M_handling->gambarHandlingPDF($id_temuan);
    $data['getSaranaHandling'] = $this->M_handling->getSaranaHandling();
    // echo "<pre>";print_r($data['getSaranaHandling']);die;
    $pdf = $this->pdf->load();
    $pdf = new mPDF('utf-8', array(210,297), 0, 'calibri', 3, 3, 5, 0, 0, 0);
    ob_end_clean();

    $doc = 'Temuan-Audit-Handling-'.$data['handlingPdf'][0]['area'].'-'.date('dmYHis');
    $filename = $doc.'.pdf';
    $fill = $this->load->view('MenjawabTemuanAudite/Handling/V_pdf', $data, true);
    $pdf->WriteHTML($fill);
    $pdf->Output($filename, 'I');
  }

  public function viewPoinPenyimpangan()
  {
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['title'] = 'Handling';
    $data['Menu'] = 'Menjawab Temuan Audite';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MenjawabTemuanAudite/Handling/V_PoinPenyimpangan', $data);
    $this->load->view('V_Footer', $data);
  }

  public function insertPoinPenyimpangan()
  {
    $data = [
      'poin' => $this->input->post('poin_penyimpangan'),
      'last_update_date' => date('Y-m-d H:i:s'),
      'last_update_by' => $this->session->user,
    ];
    // echo "<pre>";print_r($data);die;
    $insert = $this->M_handling->insPoinPenyimpangan($data);
    echo json_encode($insert);

  }

  public function getPoinPenyimpangan()
  {
    $data['getPoinPenyimpangan'] = $this->M_handling->getPoinPenyimpangan();
    // echo "<pre>";print_r($data['getPoinPenyimpangan']);die;
    if (!empty($data['getPoinPenyimpangan'])) {
      $this->load->view('MenjawabTemuanAudite/Handling/V_TablePoinPenyimpangan', $data);
    }else {
      echo 0;
    }
  }

  public function deletePoinPenyimpangan()
  {
    $id = $this->input->post('id');
    $this->M_handling->deletePoinPenyimpangan($id);
  }

  public function getPP()
  {
    $id = $this->input->post('id');
    $data['getPP'] = $this->M_handling->getPP($id);
    // echo "<pre>";print_r($data['getPP']);die;
    $this->load->view('MenjawabTemuanAudite/Handling/V_DetailPP', $data);
  }

  public function updatePP()
  {
    $id = $this->input->post('id');
    $poin = $this->input->post('poin_penyimpangan');
    $last_update_date = date('Y-m-d H:i:s');
    $last_update_by = $this->session->user;

    // echo $id, "<br>";
    // echo $poin, "<br>";
    // echo $last_update_date, "<br>";
    // echo $last_update_by, "<br>";
    // die;
    $this->M_handling->updatePP($id,$poin,$last_update_date,$last_update_by);
  }

  public function insertSaranaHandling()
  {
    $data = [
      'sarana_handling' => $this->input->post('sarana_handling'),
      'last_update_date' => date('Y-m-d H:i:s'),
      'last_update_by' => $this->session->user,
    ];
    $insert = $this->M_handling->insSaranaHandling($data);
    echo json_encode($insert);
  }

  public function getSaranaHandling()
  {
    $data['getSaranaHandling'] = $this->M_handling->getSaranaHandling();
    // echo "<pre>";print_r($data['getSaranaHandling']);die;
    if (!empty($data['getSaranaHandling'])) {
      $this->load->view('MenjawabTemuanAudite/Handling/V_TableSaranaHandling', $data);
    }else {
      echo 0;
    }
  }

  public function deleteSaranaHandling()
  {
    $id = $this->input->post('id');
    // echo $id;die;
    $this->M_handling->deleteSaranaHandling($id);
  }

  public function getSH()
  {
    $id = $this->input->post('id');
    $data['getSH'] = $this->M_handling->getSH($id);
    // echo "<pre>";print_r($data['getSH']);die;
    $this->load->view('MenjawabTemuanAudite/Handling/V_DetailSH', $data);
  }

  public function updateSH()
  {
    $id = $this->input->post('id');
    $sarana_handling = $this->input->post('sarana_handling');
    $last_update_date = date('Y-m-d H:i:s');
    $last_update_by = $this->session->user;

    $this->M_handling->updateSH($id, $sarana_handling, $last_update_date, $last_update_by);
  }
}
