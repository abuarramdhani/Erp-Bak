<?php defined('BASEPATH') or exit('No direct script access allowed');

ini_set('display_errors', false);
error_reporting(-1);

class C_Index extends CI_Controller
{
  protected $excel_valid_header = [
    'A' => 'NO',
    'B' => 'NID',
    'C' => 'NAMA',
    'D' => 'SEKSI',
    'E' => 'UNIT',
    'F' => 'BULAN',
    'G' => 'IDE KAIZEN 1',
    'H' => 'IDE KAIZEN 2',
    'I' => 'IDE KAIZEN 3',
    'J' => 'IDE KAIZEN 4',
    'K' => 'IDE KAIZEN 5',
    'L' => 'IDE KAIZEN 6',
    'M' => 'IDE KAIZEN 7',
    'N' => 'IDE KAIZEN 8',
    'O' => 'IDE KAIZEN 9',
    'P' => 'IDE KAIZEN 10',
    'Q' => 'TOTAL',
  ];

  public function __construct()
  {
    parent::__construct();

    $this->load->model('M_index');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('SystemIntegration/KaizenTks/M_kaizentimtks');

    $this->checkSession();
    $this->userid = $this->session->userid;

    $this->upload_file_name = "tempfile";
    $this->upload_file_path = 'assets/upload/temp/';
    $this->upload_file_extension = 'xlsx';
  }

  public function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('index');
    }
  }

  public function index()
  {
    $data['Title']        =  'Kaizen TIM Tuksono';
    $data['Header']       =  'Import Kaizen Pekerja Tuksono';
    $data['Menu']         =  'Import Kaizen';
    $data['SubMenuOne']   =  '';
    $data['SubMenuTwo']   =  '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->userid, $this->session->responsibility_id);

    $data['importHistory'] = $this->M_kaizentimtks->getImportHistory();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/Import/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  public function History($batch_id)
  {
    if (empty($batch_id)) return show_404();

    $data['Title']        =  'Kaizen TIM Tuksono';
    $data['Header']       =  'Import Kaizen Pekerja Tuksono';
    $data['Menu']         =  'Import Kaizen';
    $data['SubMenuOne']   =  '';
    $data['SubMenuTwo']   =  '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->userid, $this->session->responsibility_id);

    $data['batchKaizen'] = $this->M_kaizentimtks->getImportHistoryById($batch_id);
    $data['batch_id'] = $batch_id;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/Import/V_History_Batch', $data);
    $this->load->view('V_Footer', $data);
  }

  public function doImport()
  {
    $this->load->library('upload'); // Load librari upload

    /**
     * Upload to temporary file
     */
    $config['upload_path'] = $this->upload_file_path;
    $config['allowed_types'] = $this->upload_file_extension;
    $config['max_size']  = '1024';
    $config['overwrite'] = true;
    $config['file_name'] = $this->upload_file_name;

    $this->upload->initialize($config); // Load konfigurasi uploadnya
    if (!$this->upload->do_upload('file')) { // Lakukan upload dan Cek jika proses upload berhasil
      // Jika gagal :
      // flash data
      // redirect back
      $error = $this->upload->display_errors();

      $this->session->set_flashdata('failed', $error);

      return redirect('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import');
    }

    try {
      $data['import_result_data'] = $this->parseExcel($this->upload->data('full_path'));
    } catch (Exception $e) {
      $this->session->set_flashdata('failed', "File excel tidak valid, silahkan periksa terlebih dahulu");

      return redirect('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import');
    }

    $data['year'] = $this->input->post('year');

    $data['Title']        =  'Kaizen TIM Tuksono';
    $data['Header']       =  'Export Kaizen Pekerja Tuksono';
    $data['Menu']         =  'Export Kaizen';
    $data['SubMenuOne']   =  'Tahunan';
    $data['SubMenuTwo']   =  '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->userid, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/Import/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }


  /**
   * Parse excel file from path to readable list array
   * 
   * @param String Path file
   * 
   * @return Array Head and body
   */
  protected function parseExcel($filepath)
  {
    $this->load->library('Excel');

    $excelreader = new PHPExcel_Reader_Excel2007();
    $loadexcel = $excelreader->load($filepath); // Load file yang telah diupload ke folder excel
    $loadexcel->setActiveSheetIndex(0);
    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

    $tableHead = array_slice($sheet, 0, 1)[0];

    $valid = $this->verifyValidExcelHeader($tableHead);

    if (!$valid) {
      $this->session->set_flashdata('not_valid', "Format excel tidak valid, silahkan periksa terlebih dahulu");

      return redirect(base_url('/SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import/'));
    }

    $tableBody = array_slice($sheet, 1);

    return [
      'head' => $tableHead,
      'body' => $tableBody
    ];
  }

  /**
   * to verify if excel format document is valid for importing to database
   * 
   * @param Array
   * @return Boolean, valid or not
   */
  protected function verifyValidExcelHeader($header)
  {
    // debug([
    //   $header,
    //   $this->excel_valid_header
    // ]);
    foreach ($this->excel_valid_header as $key => $title) {
      if (isset($header[$key]) && $header[$key] == $title) {
        continue;
      } else {
        return false;
      }
    }

    return true;
  }

  /**
   * Get upload file
   * 
   * @return String path of file
   */
  protected function getUploadFilePath()
  {
    return "{$this->upload_file_path}{$this->upload_file_name}.{$this->upload_file_extension}";
  }

  /**
   * Month in indonesian
   * 
   * @param String nama bulan dalam indonesia
   * @return Int
   */
  protected function monthNameToDate($monthName)
  {
    // strict to uppper
    $monthName = strtoupper($monthName);
    $monthNames = [0, 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];

    return array_search($monthName, $monthNames, 2);
  }

  /**
   * This will import excel file from last upload file 
   * location is on /assets/uploads/temp/
   */
  public function executeImport()
  {
    if (!file_exists($this->getUploadFilePath())) {
      echo "Gagal import File tidak ada !!!";
      die;
    }

    $year = $this->input->post('year');

    if (empty($year)) {
      echo "Year is empty !!";
      die;
    }

    // do import

    try {
      // time when import process
      $time = date('Y-m-d H:i:s');

      // Parse data with formatted data
      $parsedExcel = $this->parseExcel($this->getUploadFilePath());
      $head = $parsedExcel['head'];
      $body = $parsedExcel['body'];

      // Header data validation
      // :TODO

      $last_import_batch_id =  $this->M_kaizentimtks->getLastImportBatch();
      $current_import_batch_id = $last_import_batch_id + 1;

      $param = [
        'kaizenColumn' => range('G', 'P'),
        'year' => $year,
        'current_import_batch_id' => $current_import_batch_id,
        'time' => $time
      ];

      $body = array_map(function ($item) use ($param) {
        $kaizenColumn = $param['kaizenColumn'];
        $year = $param['year'];
        $time = $param['time'];
        $current_import_batch_id = $param['current_import_batch_id'];

        $noind = strtoupper($item['B']);
        $month = strtoupper($item['F']);
        // get detail of noind

        // row data validation
        if (empty($noind)) return null;
        if ($month == null) return null;

        // get employee data
        $employeeData = $this->M_kaizentimtks->getEmployeeSectionByNoind($noind);

        // if employee not found
        if (empty($employeeData)) return null;

        $month = str_pad($this->monthNameToDate($month), 2, "0", STR_PAD_LEFT);
        // import as first date on month
        $date = "$year-$month-01";

        // get all kaizen from column
        $kaizens = array_map(function ($column) use ($item) {
          return $item[$column];
        }, $kaizenColumn);

        $data = [];
        foreach ($kaizens as $kaizen_title) {
          if (empty($kaizen_title)) continue;

          $data[] = [
            'no_ind' => $noind,
            'kaizen_title' => $kaizen_title,
            'kaizen_category' => null,
            'kaizen_file' => null,
            'created_at' => $date,
            'created_by' => $this->session->user,
            'updated_at' => null,
            'updated_by' => null,
            'section' => $employeeData->section_name,
            'unit' => $employeeData->unit_name,
            'name' => $employeeData->name,
            'section_code' => $employeeData->section_code,
            'import_batch_id' => $current_import_batch_id,
            'import_at' => $time,
            'import_by' => $this->session->user
          ];
        }

        return $data;
      }, $body);

      $filter = array_filter($body, function ($item) {
        return !empty($item);
      });

      $flatten = array_merge(...$filter);;
      // $flatten = array_slice($flatten, 0, 1);

      $affectedRow = $this->M_kaizentimtks->insertBatchKaizen($flatten);
      // $this->M_kaizentimtks->deleteBatchKaizen(1);

      // Flash session show amount inserted

      $this->session->set_flashdata('inserted_amount', $affectedRow);

      return redirect(base_url('/SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import/'));
    } catch (Exception $e) {
      $this->session->set_flashdata('failed', "Gagal untuk menimport kaizen, coba ulangi kembali");

      return redirect(base_url('/SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import/'));
    }
  }

  /**
   * Delete batch ID
   * 
   * @method POST
   * @return redirect
   */
  public function deleteBatch()
  {
    if ($this->input->server('REQUEST_METHOD') === 'GET') return $this->load->view('V_404');

    try {
      $batch_id = $this->input->post('batch_id');

      if (empty($batch_id)) throw new Exception("Batch_id param is empty");

      $exec = $this->M_kaizentimtks->deleteBatchKaizen($batch_id);

      if (!$exec) throw new Exception('Error 500');

      $this->session->set_flashdata('delete.success', "Sukses menghapus batch dengan id [$batch_id]");

      return redirect('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import');
    } catch (Exception $e) {
      $this->session->set_flashdata('delete.error', $e->getMessage());
      return redirect('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Import');
    }
  }
}
