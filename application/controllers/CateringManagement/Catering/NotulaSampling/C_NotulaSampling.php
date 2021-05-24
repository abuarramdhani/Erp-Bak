<?php
defined('BASEPATH') or exit('No direct script access allowed');
setlocale(LC_TIME, 'id_ID');
ini_set('max_execution_time', 0);

class C_NotulaSampling extends CI_Controller
{
  const SHIFT_1 = 1;
  const SHIFT_2 = 2;
  const SHIFT_3 = 3;

  const DEFAULT_DENDA = '5%';

  // Standar berat nasi di CV. Karya Hidup Sentosa
  // 2021
  const STANDARD_WEIGHT_OF_RICE = 425; // gram

  public function __construct()
  {
    parent::__construct();

    $this->load->library('form_validation');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('CateringManagement/M_notulasampling');

    $this->checkSession();
  }

  /* CHECK SESSION */
  public function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('/');
    }
  }

  public function index()
  {
    $user_id = $this->session->userid;

    // request
    $kd_katering = $this->input->get('kd_katering');
    $year_month = $this->input->get('year_month') ?: date('Y-m');

    // bind to view
    $data['Title'] = 'Notula Sampling';
    $data['Menu'] = 'Catering';
    $data['SubMenuOne'] = 'Notula Sampling';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $data['notulaSamplings'] = $this->M_notulasampling->getSampling($year_month, $kd_katering);

    $data['menuMakanan'] = $this->M_notulasampling->getMenuMakanan();
    $data['cateringProvider'] = $this->M_notulasampling->getCateringProvider();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('CateringManagement/Catering/NotulaSampling/V_NotulaSampling', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * @REST API
   * This logic need be refactoring using full css
   * 
   * @route 
   * @method POST
   */
  public function GenerateSamplingTemplate()
  {
    $yearMonth = $this->input->post('year_month');
    $kd_catering = $this->input->post('kd_catering');

    // Form validation
    $this->form_validation
      ->set_data($this->input->post())
      ->set_rules('year_month', 'Year month', 'required')
      ->set_rules('kd_catering', 'Catering code', 'required');

    // run validation
    if ($this->form_validation->run() === false) return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'code' => 400,
        'status' => 'Bad Request',
        'message' => $this->form_validation->error_string(),
      ]))
      ->set_status_header(400);

    // check if that month and catering is exist on table
    $samplingExist = $this->M_notulasampling->checkSamplingIsExist($yearMonth, $kd_catering);

    if ($samplingExist) return $this
      ->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'code' => 200,
        'status' => 'exist',
        'message' => "Sampling telah digenerate",
      ]))
      ->set_status_header(200);

    // find tjadwal on that month and catering
    $catering_jadwal = $this->M_notulasampling->getJadwalCatering($yearMonth, $kd_catering);

    if (!($catering_jadwal && count($catering_jadwal) > 0)) throw new Exception("Menu from catering is empty");

    $data = [];
    foreach ($catering_jadwal as $jadwal) {
      $tahun = date('Y', strtotime($jadwal->fd_tanggal));
      // convert to int because data on table format is just 1 digit
      $bulan = (int)date('m', strtotime($jadwal->fd_tanggal));
      $hari = date('d', strtotime($jadwal->fd_tanggal));

      $lokasi = $jadwal->lokasi;
      $kd_catering = $jadwal->fs_kd_katering;

      $shift1 = $jadwal->fs_tujuan_shift1 == 't';
      $shift2 = $jadwal->fs_tujuan_shift2 == 't';
      $shift3 = $jadwal->fs_tujuan_shift3 == 't';

      if ($shift1) {
        $shift1Menu = $this->M_notulasampling->getMenuCatering($tahun, $bulan, $hari, $lokasi, static::SHIFT_1);
        $shift1Menu->tanggal = $jadwal->fd_tanggal;
        array_push($data, $shift1Menu);
      }

      if ($shift2) {
        $shift2Menu = $this->M_notulasampling->getMenuCatering($tahun, $bulan, $hari, $lokasi, static::SHIFT_2);
        $shift2Menu->tanggal = $jadwal->fd_tanggal;
        array_push($data, $shift2Menu);
      }

      if ($shift3) {
        $shift3Menu = $this->M_notulasampling->getMenuCatering($tahun, $bulan, $hari, $lokasi, static::SHIFT_3);
        $shift3Menu->tanggal = $jadwal->fd_tanggal;
        array_push($data, $shift3Menu);
      }
    }

    $allMenu = [];
    // reformat array
    foreach ($data as $dt) {
      $base = [
        'tanggal' => date('Y-m-d', strtotime($dt->tanggal)),
        'menu' => null,
        'standard' => null,
        'berat' => null,
        'rasa' => null,
        'keterangan' => null,
        'created_by' => $this->session->user,
        'kd_katering' => $kd_catering,
        'lokasi' => $lokasi,
        'shift' => $dt->shift,
        'pic' => null
      ];

      $exceptionChar = [null, '-', ''];

      // Nasi
      $allMenu[] = array_merge($base, [
        'menu' => 'Nasi',
        'standard' => static::STANDARD_WEIGHT_OF_RICE
      ]);

      // Sayur
      if (!in_array($dt->sayur, $exceptionChar)) {
        $allMenu[] = array_merge($base, [
          'menu' => $dt->sayur
        ]);
      }

      // Lauk Utama
      if (!in_array($dt->lauk_utama, $exceptionChar)) {
        $allMenu[] = array_merge($base, [
          'menu' => $dt->lauk_utama
        ]);
      }

      // Lauk Pendamping
      if (!in_array($dt->lauk_pendamping, $exceptionChar)) {
        $allMenu[] = array_merge($base, [
          'menu' => $dt->lauk_pendamping
        ]);
      }

      // Buah
      if (!in_array($dt->buah, $exceptionChar)) {
        $allMenu[] = array_merge($base, [
          'menu' => $dt->buah
        ]);
      }
    }

    try {

      if (empty($allMenu)) throw new Exception("Menu is empty");
      $this->M_notulasampling->insertBatchSampling($allMenu);

      return $this
        ->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'code' => 200,
          'status' => 'ok',
          'message' => "Successfully insert sampling template",
        ]))
        ->set_status_header(200);
    } catch (Exception $e) {
      return $this
        ->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'code' => 200,
          'status' => 'empty',
          'message' => $e->getMessage(),
        ]))
        ->set_status_header(500);
    }
  }

  /**
   * Check if catering on month XX is already generated
   * @REST API
   * 
   * @method GET
   */
  public function CheckCateringGenerated()
  {
    // request
    try {
      $kd_catering = $this->input->get('kd_catering');
      $year_month = $this->input->get('year_month') ?: date('Y-m');

      if (empty($kd_catering) || empty($year_month)) throw new Exception("Bad request");

      $exist = $this->M_notulasampling->checkSamplingIsExist($year_month, $kd_catering);

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode([
          'code' => 200,
          'exist' => $exist,
          'message' => "Katering $kd_catering is " . ($exist ? 'exist' : 'not exist') . " on $year_month"
        ]));
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(500)
        ->set_output(json_encode([
          'code' => 500,
          'message' => "Something is wrong on this server",
        ]));
    }
  }

  /**
   * Add sampling
   * @deprecated
   * @method POST
   */
  public function insert_sampling()
  {
    $tanggal = $this->input->post('tanggal');
    $catering_provider = $this->input->post('catering_provider');

    // array[]
    $menus = $this->input->post('menu');
    $standards = $this->input->post('standard');
    $weights = $this->input->post('berat');
    $flavours = $this->input->post('rasa');
    $keterangan = $this->input->post('keterangan');

    // form validation

    $data = [];
    // make an array
    foreach ($menus as $i => $menu) {
      $data[] = [
        'tanggal' => $tanggal,
        'menu' => $menus[$i],
        'standard' => $standards[$i],
        'berat' => $weights[$i],
        'rasa' => $flavours[$i],
        'keterangan' => $keterangan[$i],
        'created_by' => $this->session->user,
        'catering_provider' => $catering_provider,
      ];
    }

    // do insert
    $this->M_notulasampling->insertBatchSampling($data);

    return redirect('CateringManagement/NotulaSampling');
  }

  /**
   * @REST API
   * @method POST
   * 
   * 
   */
  public function updateSampling()
  {
    $data = $this->input->post('data');

    // add updated at and updated by
    $data = array_map(function ($item) {
      $item['standard'] = $item['standard'] ? $item['standard'] : null;
      $item['berat'] = $item['berat'] ? $item['berat'] : null;
      $item['rasa'] = $item['rasa'] ? $item['rasa'] : null;
      $item['keterangan'] = $item['keterangan'] ? $item['keterangan'] : null;
      $item['pic'] = $item['pic'] ? $item['pic'] : null;

      $item['updated_by'] = $this->session->user;
      $item['updated_at'] = date('Y-m-d H:i:s');

      return $item;
    }, $data);

    // then update to database
    try {
      $this->M_notulasampling->updateBatchSampling($data);

      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'code' => 200,
          'message' => "Successfully update menu",
        ]))
        ->set_status_header(200);
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'code' => 500,
          'message' => "Internal Server Error",
        ]))
        ->set_status_header(500);
    }
  }

  /**
   * Export router
   */
  public function export()
  {
    $export_type = $this->input->get('export_type');

    // request
    $kd_katering = $this->input->get('kd_katering');
    $year_month = $this->input->get('year_month') ?: date('Y-m');

    $notulaSamplings = $this->M_notulasampling->getSampling($year_month, $kd_katering);

    // grouping by date
    $groupedNatulaSamplings = [];
    foreach ($notulaSamplings as $sampling) {
      $groupedNatulaSamplings[$sampling->tanggal . "_" . $sampling->fs_kd_katering . "_SHIFT-" . $sampling->shift][] = $sampling;
    }

    // perhitungan denda
    $groupedNatulaSamplings = array_map(function ($item) {
      $denda = array_filter($item, function ($arr) {
        // here denda
        if (empty($arr->berat) || empty($arr->standard)) return false;
        return $arr->berat < $arr->standard;
      });

      $hasDenda = count($denda) > 0;

      return [
        'denda' => $hasDenda,
        'data' => $item
      ];
    }, $groupedNatulaSamplings);

    if ($export_type == 'pdf') {
      $this->export_pdf($groupedNatulaSamplings);
    } else if ($export_type == 'excel') {
      $this->export_excel($groupedNatulaSamplings);
    } else {
      echo "Invalid export type, supported only [pdf, excel]";
    }
  }

  private function export_pdf($groupedNatulaSamplings)
  {
    $this->load->library('pdf');

    $data['groupedNotulaSamplings'] = $groupedNatulaSamplings;

    $mpdf = $this->pdf->load();
    $mpdf = new mPDF('utf8', 'A4-L', null, null, $mgl = 5, $mgr = 5, $mgt = 15, $mgb = 15, $mgh = 4, $mgf = 5);
    $data = $this->load->view('CateringManagement/Catering/NotulaSampling/Export/V_SamplingPdf', $data, true);
    // $mpdf->setAutoTopMargin = 'stretch';
    // $mpdf->setAutoBottomMargin = 'stretch';
    $mpdf->SetHTMLHeader('
      <div style="text-align: center; margin-bottom: 0; padding-bottom: 0;">
        <h1>Notula Sampling Catering</h1>
      </div>
    ');
    $mpdf->SetHTMLFooter("
      <table style=\"width: 100%\">
        <tr>
          <td>
            <i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh " . $this->session->user . " - " . $this->session->employee . " pada tgl. " . date('Y/M/d H:i:s') . "</i>
          </td>
        </tr>
        <tr>
          <td  rowspan=\"2\" style=\"vertical-align: middle; font-size: 8pt; text-align: right;\">
            Halaman {PAGENO} dari {nb}
          </td>
        </tr>
      </table>");
    $filename = 'Notula Sampling Catering - ' . date('Ymd_His') . '.pdf';
    $mpdf->WriteHTML($data, 0);
    $mpdf->setTitle($filename);
    $mpdf->Output($filename, 'I');
  }

  private function export_excel($groupedNatulaSamplings)
  {
    $this->load->library('excel');

    $border = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
        )
      )
    );

    $objExcel = new PHPExcel();
    $worksheet = $objExcel->getActiveSheet();

    // Header
    $worksheet->setCellValue('A1', 'Tanggal');
    $worksheet->setCellValue('B1', 'Hari');
    $worksheet->setCellValue('C1', 'Catering');
    $worksheet->setCellValue('D1', 'Shift');
    $worksheet->setCellValue('E1', 'Denda');
    $worksheet->setCellValue('F1', 'Menu');
    $worksheet->setCellValue('G1', 'Std');
    $worksheet->setCellValue('H1', 'Berat');
    $worksheet->setCellValue('I1', 'Rasa');
    $worksheet->setCellValue('J1', 'Ket');
    $worksheet->setCellValue('K1', 'PIC');

    $row = 2;

    $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    // Body
    foreach ($groupedNatulaSamplings as $NatulaSamplings) {
      foreach ($NatulaSamplings['data'] as $i => $sampling) {

        if ($i == 0) {
          $menuAmount = count($NatulaSamplings['data']);

          $worksheet->setCellValue('A' . $row, $sampling->tanggal);
          $worksheet->setCellValue('B' . $row, $dayNames[strftime('%w', strtotime($sampling->tanggal))]);
          $worksheet->setCellValue('C' . $row, $sampling->fs_nama_katering);
          $worksheet->setCellValue('D' . $row, $sampling->shift);
          $worksheet->setCellValue('E' . $row, $NatulaSamplings['denda'] == 1 ? static::DEFAULT_DENDA : '');

          $worksheet->mergeCells("A$row:A" . ($row + $menuAmount - 1));
          $worksheet->mergeCells("B$row:B" . ($row + $menuAmount - 1));
          $worksheet->mergeCells("C$row:C" . ($row + $menuAmount - 1));
          $worksheet->mergeCells("D$row:D" . ($row + $menuAmount - 1));
          $worksheet->mergeCells("E$row:E" . ($row + $menuAmount - 1));
        }

        $worksheet->setCellValue('F' . $row, $sampling->menu);
        $worksheet->setCellValue('G' . $row, $sampling->standard);
        $worksheet->setCellValue('H' . $row, $sampling->berat);
        $worksheet->setCellValue('I' . $row, $sampling->rasa);
        $worksheet->setCellValue('J' . $row, $sampling->keterangan);
        $worksheet->setCellValue('K' . $row, $sampling->pic);

        $row++;
      }
    }

    // set border
    $worksheet->getStyle('A1:K' . $worksheet->getHighestRow())->applyFromArray($border);
    $worksheet->getStyle('A1:K' . $worksheet->getHighestRow())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

    $columnNWidth = [['A', 12], ['B', 8], ['C', 15], ['D', 7], ['E', 7], ['F', 40], ['G', 15], ['H', 15], ['I', 15], ['J', 15], ['K', 15]];
    foreach ($columnNWidth as $column) {
      $worksheet->getColumnDimension($column[0])
        ->setWidth($column[1]);
    }

    $filename = 'Notula Sampling Catering - ' . date('Y_m_d-H:i:s') . '.xls';
    header('Content-Type: aplication/vnd.ms-excel');
    header('Content-Disposition:attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
    $writer->save('php://output');
  }

  /**
   * HTTP Response
   */
  private function badRequest($field = "")
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'code' => '400',
        'message' => $field ?: "Bad Request",
      ]))
      ->set_status_header(400);
  }

  /**
   * HTTP Response
   */
  private function internalServerError()
  {
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'code' => '500',
        'message' => "Internal server error",
      ]))
      ->set_status_header(500);
  }
}
