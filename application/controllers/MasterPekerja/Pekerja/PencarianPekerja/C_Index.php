<?php
defined("BASEPATH") or die("This script cannot access directly");

/**
 * Ez debugging
 */
if (!function_exists('debug')) {
  function debug($arr)
  {
    echo "<pre>";
    print_r($arr);
    die;
  }
}

class C_Index extends CI_Controller
{
  /**
   * user logged, created by session
   */
  protected $user_logged;
  /**
   * Select param item and type of param
   */
  protected $param;

  public function __construct()
  {
    parent::__construct();

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/Pekerja/PencarianPekerja/M_pencarianpekerja', 'modelPencarian');

    // load another class
    $this->load->library('../controllers/MasterPekerja/Pekerja/PencarianPekerja/Data_Pencarian');

    $this->table_head_default = $this->data_pencarian->table_head_default; // array
    $this->table_head_jabatan = $this->data_pencarian->table_head_jabatan; // array
    $this->param = $this->data_pencarian->param; // array

    $this->user_logged = @$this->session->user ?: null;
    $this->user_id = $this->session->userid ?: null;

    $this->sessionCheck();
  }

  private function sessionCheck()
  {
    return $this->user_logged or redirect(base_url('MasterPekerja'));
  }

  /**
   * Pages
   * @url MasterPekerja/PencarianPekerja
   * 
   */
  public function index()
  {
    $data['Menu'] = 'Pekerja';
    $data['SubMenuOne'] = 'Pencarian Pekerja';
    $data['SubMenuTwo'] = 'Pencarian Pekerja';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

    $data['param_option'] = $this->param;

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Pekerja/PencarianPekerja/V_Index', $data);
    $this->load->view('MasterPekerja/Pekerja/PencarianPekerja/V_Footer', $data);
    // $this->load->view('V_Footer', $data);
  }

  /**
   * Export to Excel
   * Using request from json to url
   * This render Excel file / download
   * 
   * @param String $param
   * @param String $keyword
   * @param String $out
   * 
   * @return Void
   */
  public function export_excel()
  {
    $this->load->library(array('Excel', 'Excel/PHPExcel/IOFactory'));
    $objPHPExcel = new PHPExcel();

    /**
     * GET DATA
     */

    $data = [];
    try {
      /**
       * This is stolen from C_APi->find()
       */
      $get = $this->input->get();
      $keyword = $this->input->get('keyword');
      $param = $this->input->get('param');
      $is_out = $this->input->get('out'); // pekerja aktif (t/f)
      $limit = $this->input->get('limit');

      $validation = $this->form_validation
        ->set_data($get)
        ->set_rules('keyword', 'keyword', 'required')
        ->set_rules('param', 'Param', 'required')
        // ->set_rules('limit', 'limit', 'optional')
        ->set_message('required', 'Error: Field {field} Bad request')
        ->run();

      // check valid param
      if (!$validation) throw new Exception(validation_errors());
      // check valid param on interface
      if (!$this->param[$param]) throw new Exception("Param is not valid");

      $param_type = $this->param[$param]['type'];

      if ($param == 'jabatan') {
        $getData = $this->modelPencarian->findWorkerPosition($keyword, $is_out, $limit);
        $data = array(
          'table_head' => $this->table_head_jabatan,
          'table_body' => $getData,
          'table_keys' => count($getData) ? array_keys($getData[0]) : []
        );
      } else {
        $getData = $this->modelPencarian->findWorker($param, $param_type, $keyword, $is_out, $limit);
        $data = array(
          'table_head' => $this->table_head_default,
          'table_body' => $getData,
          'table_keys' => count($getData) ? array_keys($getData[0]) : []
        );
      }
      // end stolen
      // debug($data);
      // set property
      $objPHPExcel
        ->getProperties()
        ->setCreator('KHS ERP')
        ->setTitle("Rekap Potongan Duka")
        ->setSubject("Rekap Potongan Duka")
        ->setDescription("Rekap Potongan Duka")
        ->setKeywords("Rekap Potongan Duka");

      // CORE VAROABLE
      // maybe later
      $alphabet = range('A', 'Z');
      // debug($alphabet);
      // set orientation
      $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      // set title
      $objPHPExcel->getActiveSheet()->setTitle('DAFTAR KEBUTUHAN P2K3');
      $objPHPExcel->setActiveSheetIndex(0);

      // Styling in PHP Excel
      $EXCEL_STYLE = array(
        'bordered'  => [
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
          )
        ],
        'bold' => [
          'font' => array('bold' => true),
        ],
        'underline' => [
          'font' => array('underline' => true)
        ],
        'align-center' => [
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
          ),
        ]
      );

      // Documentation
      // bold -> apply from array -> getStyle()->getFont()->setBold(bool)
      // setStyle -> getStyle('cell')->applyFromArray(Array)
      // setValue -> setCellValue('cell', 'value')

      // SET STYLING

      // SET TABLE HEAD
      // debug($data['table_head']);
      $cellA = 'A';
      foreach ($data['table_head'] as $i => $title) {
        $cell = $cellA++ . 1;
        $objPHPExcel->getActiveSheet()->setCellValue($cell, $title)->getStyle($cell)
          ->applyFromArray($EXCEL_STYLE['bold'])
          ->applyFromArray($EXCEL_STYLE['bordered'])
          ->applyFromArray($EXCEL_STYLE['align-center']);
      }

      // SET TABLE CONTENT
      $startRow = 2;
      $no = 1;
      foreach ($data['table_body'] as $item) {
        $cell = 'A' . $startRow;
        $objPHPExcel->getActiveSheet()->setCellValue($cell, $no++)->getStyle($cell)
          ->applyFromArray($EXCEL_STYLE['align-center'])
          ->applyFromArray($EXCEL_STYLE['bordered']);
        $cellB = 'B';
        foreach ($item as $index => $value) {
          $cell = $cellB++ . $startRow;
          $objPHPExcel->getActiveSheet()->setCellValue($cell, $value)->getStyle($cell)->applyFromArray($EXCEL_STYLE['bordered']);
          // with long number example
          // $objPHPExcel->getActiveSheet()->setCellValue($cell, $value)->getStyle('E' . $x)->applyFromArray($style_col1)->getNumberFormat()->setFormatCode('#,#0.##;[Red]-#,#0.##');
        }
        $startRow++;
      }

      // SET column to autosize
      $highestColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
      $from = 'A';
      while ($from !== $highestColumn) {
        $from++;
        $objPHPExcel->getActiveSheet()->getColumnDimension($from)->setAutoSize(true);
      }

      // Send response header in Excel format
      $filename = urlencode("PencarianPekerja-" . date('YmdHis') . ".xlsx");
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache

      $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
      $objWriter->save('php://output');
    } catch (Exception $error) {
      echo "erorr data not valid, system error :(";
    }
  }
}
