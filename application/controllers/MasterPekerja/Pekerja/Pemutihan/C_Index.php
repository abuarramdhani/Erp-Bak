<?php

function debug($var)
{
  echo "<pre>";
  print_r($var);
  die;
}

class C_Index extends CI_Controller
{
  const PENDING = 'pending';
  const REVISI = 'revision';
  const REJECT = 'reject';
  const ACCEPT = 'accept';
  const CANCEL = 'cancel';

  protected $attachment_path;

  public function __construct()
  {
    parent::__construct();
    $this->sessionCheck();
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/Pekerja/Pemutihan/M_pemutihan', 'ModelPemutihan');

    # production
    $this->attachment_path = base_url("/assets/upload/pemutihan_data_pekerja/attachment") . '/';

    # dev
    // $this->attachment_path = "http://192.168.168.189/erp/update-pekerja/assets/uploads/attachment/";

    $this->user = $this->session->user;
    $this->user_id = $this->session->userid;
  }

  /**
   * To check session
   */
  private function sessionCheck()
  {
    return $this->session->is_logged or redirect(base_url('/'));
  }

  /**
   * Pages
   * @method GET
   * @url MasterPekerja/Pemutihan/
   */
  public function index()
  {
    $data['Menu'] = 'Pekerja';
    $data['SubMenuOne'] = 'Pemutihan Data Pekerja';
    $data['SubMenuTwo'] = 'Pemutihan Data Pekerja';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

    $data['tablePending'] = $this->ModelPemutihan->getAllRequest(self::PENDING);
    $data['tableRevision'] = $this->ModelPemutihan->getAllRequest(self::REVISI);
    $data['tableApproved'] = $this->ModelPemutihan->getAllRequest(self::ACCEPT);
    $data['tableRejected'] = $this->ModelPemutihan->getAllRequest(self::REJECT);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Pekerja/Pemutihan/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * @page
   * 
   * @method GET
   * @url MasterPekerja/Pemutihan/Request?id
   */
  public function request()
  {
    $id = $this->input->get('id');

    if (!$id) return "data not found";

    $request = $this->ModelPemutihan->getDataById($id);

    // if not found
    if (empty($request)) {
      echo "data with id $id is not found in server, try to back and refresh page";
      return;
    }

    $family = $this->ModelPemutihan->getFamilyByPribadiId($id);
    // debug($family);
    $vaccination = $this->ModelPemutihan->getVaccinationByPribadiId($id);
    $verifier = null;
    if ($request->status_update_by) {
      $verifier = $this->ModelPemutihan->getPribadiByNoind($request->noind);
    }

    $pribadi = $this->ModelPemutihan->getPribadiByNoind($request->noind);

    // set current session
    if (!$request->current_session) {
      $this->ModelPemutihan->setSessionOfPage($request->id_req, $this->user);
    }

    $data['Menu'] = 'Pekerja';
    $data['SubMenuOne'] = 'Pekerja';
    $data['SubMenuTwo'] = 'Pemutihan Data Pekerja';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);
    // debug($request);
    $data['pribadi'] = $pribadi;
    $data['request'] = $request;
    $data['family'] = $family;
    $data['vaccination'] = $vaccination;
    $data['session'] = $request->current_session ?: $this->user;
    $data['user'] = $this->user;
    $data['verifier'] = $verifier ? $request->status_update_by . ' - ' . $verifier->nama : '';
    $data['attachment_path'] = $this->attachment_path;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Pekerja/Pemutihan/V_Detail', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * Verify, is to update
   * 
   * @method @POST
   * @url MasterPekerja/Pemutihan/Verification
   */
  public function verification()
  {
    $allowed_status = [
      'pending',
      'revision',
      'accept',
      'reject',
    ];
    // allowed field from user to update
    $allowed_field = [
      'noind_verify',
      'nama_verify',
      'nik_verify',
      'no_kk_verify',
      'jenkel_verify',
      'goldarah_verify',
      'agama_verify',
      'tempat_lahir_verify',
      'tgllahir_verify',
      'alamat_verify',
      'desa_verify',
      'kec_verify',
      'kab_verify',
      'provinsi_verify',
      'kodepos_verify',
      'almt_kost_verify',
      'telepon_verify',
      'nohp_verify',
      'email_verify',
      'statnikah_verify',
      'tglnikah_verify',
      'npwp_verify',
      'statpajak_verify',
      'no_peserta_bpjsket_verify',
      'no_peserta_bpjskes_verify',
      'feedback'
    ];
    // too long
    $request_id = $this->input->post('id');
    // redirect to after success
    $redirect_to = $this->input->post('redirect');
    // status type
    $status_type = $this->input->post('decide');

    $status_type = in_array($status_type, $allowed_status) ? $status_type : 'pending';
    $request_post = $this->input->post();

    // filter allowed field
    $filtered_field = array_filter($request_post, function ($key) use ($allowed_field) {
      return in_array($key, $allowed_field);
    }, ARRAY_FILTER_USE_KEY);

    $additional_field = [
      'updated_at' => date('c'),
      'status_update_at' => date('c'),
      'status_update_by' => $this->user,
      'status_req' => $status_type // fraud
    ];

    // try to update
    try {
      $data = array_merge($filtered_field, $additional_field);
      $execute = $this->ModelPemutihan->updateVerifyCheck($request_id, $data);

      if (!$execute) throw new Exception("Error Ketika Mengupdate Database");

      if ($status_type === self::REJECT) {
        $request = $this->ModelPemutihan->getDataById($request_id);
        $employee = $this->ModelPemutihan->getPribadiByNoind($request->noind);

        if ($employee && $employee->email) {
          $gmail = $this->_gmail_service($employee->email, $status_type, $data);
          $gmail->send();
        }
      }

      $this->session->set_flashdata('success', "Berhasil Mengupdate Data");
      redirect($redirect_to);
    } catch (Exception $e) {
      // make session with errorvalidati>getMessage());

      redirect($_SERVER['HTTP_REFERED']);
    }
  }

  public function _gmail_service($email, $status_type, $data)
  {
    $html = $this->load->view('MasterPekerja/Pekerja/Pemutihan/email/template_notification_approval', $data, true);

    $this->load->library('PHPMailerAutoload');
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'notification.hrd.khs1@gmail.com';
    $mail->Password = "tes123123123";
    $mail->setFrom('noreply@quick.co.id', 'Pemutihan Data Pekerja');
    $mail->IsHTML(true);
    $mail->AltBody = '';
    $mail->addAddress($email);
    // $mail->addAddress('<your email for debugging>@gmail.com');
    // $mail->AddCC('it.sec1@quick.co.id');

    $status_title = '';
    switch ($status_type) {
      case self::REJECT:
        $status_title = 'Pengajuanmu ditolak';
        break;
      case self::ACCEPT:
        $status_title = 'Pengajuanmu diterima';
        break;
      case self::REVISI:
        $status_title = 'Pengajuanmu perlu direvisi';
        break;
      default:
        $status_title = 'Pengajuan';
    }

    $mail->Subject = "$status_title - Pemutihan Data Pekerja - Quick";
    $mail->msgHTML($html);

    return $mail;
  }
}
