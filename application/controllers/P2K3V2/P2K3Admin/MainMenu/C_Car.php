<?php

if (!function_exists('nullWhenEmpty')) {
  // return null when empty
  function nullWhenEmpty($var)
  {
    return empty($var) ? null : $var;
  }
}

// Just an helper class
class HelperClass
{
  const indonesianWeeks =  ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
  static function dateToIndonesianWeeks($date)
  {
    return static::indonesianWeeks[date('w', strtotime($date))];
  }
}

/**
 * @class CAR_STATUS
 * Status kode CAR
 */
class CAR_STATUS
{
  const PROCESS = 'process'; // baru saja di buat
  const VERIFIED = 'verified'; // jika di approve oleh unit
  const OPEN = 'open'; // TIM klik open
  const REVISI = 'revisi'; // jika mengajukan revisi pertama
  const CLOSED = 'closed'; // di approve oleh TIM P2K3

  static public function getStatus($status)
  {
    switch ($status) {
      case static::PROCESS:
        return "Proses";
      case static::VERIFIED:
        return "Terverifikasi";
      case static::OPEN:
        return "Open";
      case static::REVISI:
        return "Revisi";
      case static::CLOSED:
        return "Closed";
      default:
        return "Unknown State";
    }
  }

  static public function getAllStatus()
  {
    return [
      'pending', 'verified', 'open', 'revisi', 'close'
    ];
  }
}

/**
 * TODO LIST
 * 
 * dibagian seksi, jika sudah closed semua, tidak ada fitur tambah (Ok)
 * dibagian unit, warna CAR dibuat beda antara yg sudah di verifikasi sama belum (-)
 * dibagian tim, warna car dibuat beda antara yang sudah di closed, (-)
 */

/**
 * @class C_Car
 * 
 * notes: 
 * CAR (Corrective Action Report)
 */
class C_Car extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('general');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('P2K3V2/P2K3Admin/M_dtmasuk');
    $this->load->model('P2K3V2/P2K3Admin/M_car');
    $this->load->model('MasterPekerja/Pekerja/PekerjaKeluar/M_pekerjakeluar');

    $this->user_id = $this->session->userid;
    $this->kodesie = $this->session->kodesie;
  }

  /**
   * To see page of CAR form
   * 
   * @page
   * @domain SEKSI
   */
  public function CreateCarView($id_kecelakaan)
  {
    $data['Title'] = 'Kebutuhan APD';
    $data['Menu'] = 'Kebutuhan APD';
    $data['SubMenuOne'] = 'Standar';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

    $data['kecelakaanDetail'] = $this->M_dtmasuk->getKecelakaan($id_kecelakaan);

    // TODO: make into page
    if (empty($data['kecelakaanDetail'])) return debug("Data tidak ditemukan");

    $data['pekerjaDetail'] = $this->M_dtmasuk->getdetail_pkj_mkk($data['kecelakaanDetail']['noind']);

    $data['kecelakaanDetail']['hari'] = HelperClass::dateToIndonesianWeeks($data['kecelakaanDetail']['waktu_kecelakaan']);

    // Param
    $data['id_kecelakaan'] = $id_kecelakaan;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/V_Create', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * To Store CAR
   * 
   * @POST
   * Create CAR
   * @domain SEKSI
   * 
   * update k3.k3k_kecelakaan
   * Insert k3.k3k_kecelakaan_car
   * Insert k3.k3k_kecelakaan_car_approval_history
   */
  public function CreateCar()
  {
    $id_kecelakaan = $this->input->post('id_kecelakaan');
    $factor = $this->input->post('factor');
    $root_cause = $this->input->post('root_cause');
    $corrective_action = $this->input->post('corrective_action');
    $noind_pic = $this->input->post('noind_pic');
    $due_date = $this->input->post('due_date');

    $data = [];
    foreach ($factor as $i => $_) {
      $data[] = [
        'factor' => $factor[$i],
        'root_cause' => $root_cause[$i],
        'corrective_action' => $corrective_action[$i],
        'noind_pic' => $noind_pic[$i],
        'due_date' => date('Y-m-d', strtotime($due_date[$i])),
        'approval_status' => CAR_STATUS::PROCESS,
        'created_by' => $this->session->user,
        'id_kecelakaan' => $id_kecelakaan,
      ];
    }

    try {
      // Insert to k3k_kecelakaan_car
      $this->M_car->insertBatchCar($data);

      // select car id where have id_kecelakaan = $id_kecelakaan
      $cars = $this->M_car->getCarByIdKecelakaan($id_kecelakaan);

      // insert approval history
      foreach ($cars as $car) {
        // use named parameter
        $this->M_car->insertCarApprovalHistory(
          $car_id = $car->kecelakaan_car_id,
          $approval_status = CAR_STATUS::PROCESS,
          $approval_by = $this->session->user,
          $notes = null
        );
      }

      // update to kecelakaan if car is has been created
      $this->M_car->updateCarIfHasBeenCreated($id_kecelakaan);

      $this->session->set_flashdata("success", "Berhasil menambahkan lampiran CAR");

      return redirect('p2k3adm_V2/Admin/Car/View/' . $id_kecelakaan);
    } catch (Exception $e) {
      debug("Something is error");
    }
  }

  /**
   * Check is all car is closed ?
   * 
   * @param Array $cars
   * 
   * @return Boolean
   */
  private function isAllCarIsClosed($cars)
  {
    // map array with false is not yet closed
    $cars = array_map(function ($car) {
      if ($car->approval_status == CAR_STATUS::REVISI) {
        $endRevisi = end($car->revisi);
        if ($endRevisi->approval_status === CAR_STATUS::CLOSED) return true;
      }

      if ($car->approval_status === CAR_STATUS::CLOSED) return true;

      return false;
    }, $cars);


    // find has false value
    // will return a int if found
    $isHasUnclosed = array_search(false, $cars);

    if (is_int($isHasUnclosed)) return false;
    return true;
  }

  /**
   * To see page of CAR
   * 
   * @page
   * @domain SEKSI
   */
  public function ViewCar($id_kecelakaan)
  {
    $data['Title'] = 'Kebutuhan APD';
    $data['Menu'] = 'Kebutuhan APD';
    $data['SubMenuOne'] = 'Standar';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

    $data['kecelakaanDetail'] = $this->M_dtmasuk->getKecelakaan($id_kecelakaan);

    // TODO: make into page
    if (empty($data['kecelakaanDetail'])) return debug("Data tidak ditemukan");

    $data['pekerjaDetail'] = $this->M_dtmasuk->getdetail_pkj_mkk($data['kecelakaanDetail']['noind']);
    $cars = $this->M_car->getCarByIdKecelakaan($id_kecelakaan);

    $data['cars'] = $cars;

    // check if all is closed
    $data['isAllClosed'] = $this->isAllCarIsClosed($cars);

    $data['kecelakaanDetail']['hari'] = HelperClass::dateToIndonesianWeeks($data['kecelakaanDetail']['waktu_kecelakaan']);

    // Param
    $data['id_kecelakaan'] = $id_kecelakaan;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/V_View', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * To Update/Revisi CAR
   * 
   * @method POST
   * @domain SEKSI
   */
  public function UpdateCar($id_kecelakaan)
  {
    $car_id = $this->input->post('car_id');
    $factor = $this->input->post('factor');
    $root_cause = $this->input->post('root_cause');
    $corrective_action = $this->input->post('corrective_action');
    $noind_pic = $this->input->post('noind_pic');
    $due_date = $this->input->post('due_date');
    $sub_car_revision_id = $this->input->post('sub_car_revision_id');

    // restructure array of input
    $data = [];
    foreach ($factor as $i => $_) {
      $data[] = [
        'kecelakaan_car_id' => $car_id[$i],
        'factor' => $factor[$i],
        'root_cause' => $root_cause[$i],
        'corrective_action' => $corrective_action[$i],
        'noind_pic' => $noind_pic[$i],
        'due_date' => date('Y-m-d', strtotime($due_date[$i])),
        'approval_status' => CAR_STATUS::PROCESS, // only process can update data
        'created_by' => $this->session->user,
        'id_kecelakaan' => $id_kecelakaan,
        'sub_revisi_kecelakaan_car_id' => nullWhenEmpty((int)$sub_car_revision_id[$i])
      ];
    }

    $this->M_car->updateCarIfHasBeenCreated($id_kecelakaan);
    // debug($data);

    try {
      $this->M_car->updateOrInsertBatchCar($data);
      $this->session->set_flashdata('success', "Sukses mengupdate dan mengajukan revisi");
    } catch (Exception $e) {
      $this->session->set_flashdata('error', "Gagal mengupdate dan mengajukan revisi");
    }

    // redirect back
    return redirect($_SERVER['HTTP_REFERER']);
  }


  /**
   * To see page of list kecelakaan kerja where CAR is created
   * 
   * @page
   * @domain UNIT
   */
  public function ApprovalUnitListView()
  {
    $kodesie = $this->session->kodesie;

    $data  = $this->general->loadHeaderandSidemenu('P2K2 - Monitoring Kecelakaan Kerja', 'Monitoring Kecelakaan Kerja', 'Monitoring Kecelakaan Kerja', 'Approval CAR', '');

    $data['year'] = $this->input->get('year');

    if (empty($data['year'])) redirect(current_url() . '?year=' . date('Y'));

    // unit bisa mempunyai lebih dr 1 jabatan, ambil di trefjabatan
    $refJabatan = $this->M_dtmasuk->getRefJabatan($this->session->user, $trim = 5);
    $refJabatan = array_column($refJabatan, 'kodesie');

    $data['list'] = $this->M_dtmasuk->getKecelakaanKerjaByUnit($data['year'], $refJabatan);

    $data['lokasi'] = array_column($this->M_pekerjakeluar->getLokasiKerja(), 'lokasi_kerja', 'id_');
    $data['lokasi'][999] = 'LAKA';

    $employee = $this->M_dtmasuk->getEmployeeByNoind($this->session->user);

    $kd_jabatan_unit = ['08', '09'];

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);

    if (in_array($employee->kd_jabatan, $kd_jabatan_unit)) {
      $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/V_ApprovalUnitList', $data);
    } else {
      $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/Page/V_NotAllowed', [
        'text' => 'Hanya Kepala / asisten unit yang dapat mengapprove CAR'
      ]);
    }
    $this->load->view('V_Footer', $data);
  }

  /**
   * To see CAR on Unit level
   * @page
   * @domain UNIT
   * 
   * Halaman approval unit
   */
  public function approvalUnitView($id_kecelakaan)
  {
    $data['Title'] = 'Kebutuhan APD';
    $data['Menu'] = 'Kebutuhan APD';
    $data['SubMenuOne'] = 'Standar';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

    $data['kecelakaanDetail'] = $this->M_dtmasuk->getKecelakaan($id_kecelakaan);

    // TODO: make into page
    if (empty($data['kecelakaanDetail'])) return debug("Data tidak ditemukan");

    $data['pekerjaDetail'] = $this->M_dtmasuk->getdetail_pkj_mkk($data['kecelakaanDetail']['noind']);
    $cars = $this->M_car->getCarByIdKecelakaan($id_kecelakaan);

    $data['cars'] = $cars;

    // is have any PROCESS status ?
    $data['show_approve'] = count(array_filter($data['cars'], function ($car) {
      if ($car->approval_status == CAR_STATUS::PROCESS) return true;

      // find on revisi
      foreach ($car->revisi as $revisi) {
        if ($revisi->approval_status == CAR_STATUS::PROCESS) return true;
      }

      return false;
    })) > 0;

    $data['kecelakaanDetail']['hari'] = HelperClass::dateToIndonesianWeeks($data['kecelakaanDetail']['waktu_kecelakaan']);

    // Param
    $data['id_kecelakaan'] = $id_kecelakaan;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);

    $kd_jabatan_unit = ['08', '09'];
    // for development
    // $kd_jabatan_unit = 99;
    $employee = $this->M_dtmasuk->getEmployeeByNoind($this->session->user);

    // Hanya jabatan UNIT ke atas yang dapat Mengapprove
    if (in_array($employee->kd_jabatan, $kd_jabatan_unit)) {
      $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/V_ApprovalUnit', $data);
    } else {
      $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/Page/V_NotAllowed', [
        'text' => 'Hanya Kepala / asisten unit yang dapat mengapprove CAR'
      ]);
    }

    $this->load->view('V_Footer', $data);
  }

  /**
   * To update approval status by Unit level
   * Approval unit hanya bisa meng approve
   * 
   * @REST API
   * @domain UNIT
   */
  public function approvalUnitAction()
  {
    $user = $this->session->user;
    $id_kecelakaan = $this->input->post('id_kecelakaan');

    try {
      // update table
      $this->M_car->approvalUnitCar($id_kecelakaan, CAR_STATUS::VERIFIED, $user);

      $this->session->set_flashdata('success', "Sukses mengapprove CAR");
    } catch (Exception $e) {
      $this->session->set_flashdata('error', "Terjadi kesalahan saat mengapprove, silahkan coba kembali atau menghubungi seksi ICT - HRD");
    }

    return redirect($_SERVER['HTTP_REFERER']);
  }

  /**
   * To see page of CAR on Tim P2k3 level
   * 
   * @page
   * @domain TIM P2K3
   */
  public function aprpovalTimView($id_kecelakaan)
  {
    $data['Title'] = 'Kebutuhan APD';
    $data['Menu'] = 'Kebutuhan APD';
    $data['SubMenuOne'] = 'Standar';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

    $data['kecelakaanDetail'] = $this->M_dtmasuk->getKecelakaan($id_kecelakaan);

    // TODO: make into page
    if (empty($data['kecelakaanDetail'])) return debug("Data tidak ditemukan");

    $data['pekerjaDetail'] = $this->M_dtmasuk->getdetail_pkj_mkk($data['kecelakaanDetail']['noind']);
    $cars = $this->M_car->getCarByIdKecelakaan($id_kecelakaan);

    $data['cars'] = $cars;

    $data['kecelakaanDetail']['hari'] = HelperClass::dateToIndonesianWeeks($data['kecelakaanDetail']['waktu_kecelakaan']);

    // Param
    $data['id_kecelakaan'] = $id_kecelakaan;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/V_ApprovalTim', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * To update approval CAR status by Tim P2K3
   * 
   * @domain TIM P2K3
   * 
   * Approval TIM -> open, revisi, closed
   */
  public function approvalTimAction()
  {
    $id = $this->input->post('id');
    $approval_status = $this->input->post('approval_status');
    $approval_by = $this->session->user;

    try {
      // TODO:
      // form validation
      if (empty($id) || empty($approval_status)) throw new Exception("Body cannot be empty");

      // TODO:
      // approval type validation
      // TIM just can set approval within REVISI, OPEN, CLOSED
      if (!in_array($approval_status, [CAR_STATUS::OPEN, CAR_STATUS::REVISI, CAR_STATUS::CLOSED])) throw new Exception("Approval type is not valid type");

      $this->M_car->approvalTimCar($id, $approval_by, $approval_status);

      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'code' => 200,
          'message' => "Successfully",
          'approval_status' => [
            'open' => [
              'count' => $this->M_car->getAmountOfStatusHistory($id, CAR_STATUS::OPEN)
            ]
          ]
        ]));
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode([
          'code' => 400,
          'message' => "$e",
        ]));
    }
  }

  /**
   * To Store notes on CAR
   * 
   * REST API
   * @method POST
   */
  public function approvalTimNotes()
  {
    $id = $this->input->post('id');
    $notes = $this->input->post('notes');

    try {
      if (empty($notes) || empty($id)) throw new Exception("Notes body is empty");

      $this->M_car->updateNotes($id, $notes);

      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'code' => 200,
          'message' => "Successfully"
        ]));
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode([
          'code' => 400,
          'message' => $e,
        ]));
    }
  }

  /**
   * To get approval history of CAR
   * 
   * REST API
   * @method GET
   */
  public function ApprovalHistory()
  {
    $id_car = $this->input->get('car_id');

    try {
      // get car history
      $approvalHistories = $this->M_car->getApprovalHistoryById($id_car);

      $data = [
        'success' => true,
        'html' => $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/V_ApprovalHistory', [
          'data' => $approvalHistories
        ], true)
      ];

      return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode($data));
    } catch (Exception $e) {
      return $this->output
        ->set_status_header(400)
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'success' => false
        ]));
    }
  }

  /**
   * To get employee who be PIC
   * 
   * REST API
   * @domain Seksi
   * @method GET
   * 
   */
  public function getEmployeePIC()
  {
    $q = $this->input->get('q');

    $employees['data'] = $this->M_car->getEmployeePIC($q);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($employees));
  }

  /**
   * To Export CAR to PDF file
   * 
   * TODO: 
   * Ubah format tanggal menjadi DD MMMM YYYY, ex: 31 Januari 2021
   * // 
   * 
   * Suggestion (Hanya usulan):
   * - Ketika melakukan approval, kirim notifikasi ke pekerja terkait ()
   * 
   * 
   * Print CAR handler
   * @method POST
   */
  public function ExportPDF($id_kecelakaan)
  {
    $this->load->library('pdf');

    $data['kecelakaanDetail'] = $this->M_dtmasuk->getKecelakaan($id_kecelakaan);
    $data['pekerjaDetail'] = $this->M_dtmasuk->getdetail_pkj_mkk($data['kecelakaanDetail']['noind']);
    $cars = $this->M_car->getCarByIdKecelakaan($id_kecelakaan);

    $data['cars'] = $cars;

    // get last Head Section approval (Process)
    $data['kasieApproval'] = $this->M_car->getLastApproval($id_kecelakaan, CAR_STATUS::PROCESS);
    // get last Unit approval (Verified)
    $data['unitApproval'] = $this->M_car->getLastApproval($id_kecelakaan, CAR_STATUS::VERIFIED);
    // get last Tim approval (Closed)
    $data['timApproval'] = $this->M_car->getLastApproval($id_kecelakaan, CAR_STATUS::CLOSED);

    $data['kecelakaanDetail']['hari'] = HelperClass::dateToIndonesianWeeks($data['kecelakaanDetail']['waktu_kecelakaan']);

    $pdf = $this->pdf->load();
    $pdf = new mPDF('', 'F6', 10, '', 4, 4, 4, 4, 10, 3);
    $filename = 'P2K3Seksi.pdf';
    $html = $this->load->view('P2K3V2/P2K3Admin/KecelakaanKerja/CAR/Export/V_Pdf', $data, true);
    $footer = "
			Dicetak melalui Quick ERP - P2K3 Kecelakaan Kerja pada " . date('Y-m-d H:i:s') . " oleh " . $this->session->user . " - " . $this->session->employee . "
		";
    $pdf->SetFooter($footer);
    $pdf->WriteHTML($html, 0);
    $pdf->Output($filename, 'I');
  }
}
