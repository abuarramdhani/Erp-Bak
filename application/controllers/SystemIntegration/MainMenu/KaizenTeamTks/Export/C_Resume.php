<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta'); // set timezone
set_time_limit(0); // disable time limit
ignore_user_abort(false); // ignore user aborting request

class C_Resume extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('M_index');
    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('SystemIntegration/KaizenTks/M_kaizentimtks');

    $this->checkSession();
    $this->userid = $this->session->userid;
  }

  public function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('index');
    }
  }

  /**
   * Page
   * 
   * @url SystemIntegration/KaizenPekerjaTks/TeamKaizen/Export/Resume
   */
  public function index()
  {
    $data['Title']        =  'Kaizen Pekerja Tuksono';
    $data['Header']       =  'Input Kaizen Pekerja Tuksono';
    $data['Menu']         =  'Export Kaizen';
    $data['SubMenuOne']   =  'Resume';
    $data['SubMenuTwo']   =  '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->userid, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/Export/V_Resume', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * Export Excel
   * 
   * @url SystemIntegration/KaizenPekerjaTks/TeamKaizen/Export/Resume/doExport
   */
  public function doExport()
  {
    $year = $this->input->get('year');

    if (!$year) {
      echo "Date i s invalid";
      die;
    }

    $this->load->library('Excel');

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $sheet = $objPHPExcel->getActiveSheet();

    // get data of kaizen on year $year
    $dataKaizen = $this->M_kaizentimtks->getDetailKaizenSectionByYear($year);

    // PHP excel styling
    $STYLE = [
      'ALIGN' => [
        'CENTER' => [
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
          ),
        ]
      ],
      'BORDER' => [
        'ALL' => [
          'borders' => [
            'allborders' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN
            ]
          ]
        ]
      ]
    ];

    // Month of year
    $monthNumbers = range(1, 12);
    $monthNames = [0, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    // Table header
    $sheet->setCellValue('A1', "NO");
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->setCellValue('B1', "SEKSI");
    $sheet->getColumnDimension('B')->setWidth(30);
    $sheet->mergeCells('A1:A2');
    $sheet->mergeCells('B1:B2');

    $nextColumn = "B";

    foreach ($monthNumbers as $monthNumber) {
      $nextColumn++;

      $monthName = $monthNames[$monthNumber];

      $columnWidth = 11;

      $startColumn = $nextColumn;
      $sheet->setCellValue(($nextColumn) . "1", $monthName);
      $sheet->setCellValue(($nextColumn) . "2", "KAIZEN");
      $sheet->getColumnDimension($nextColumn)->setWidth($columnWidth);
      $sheet->setCellValue((++$nextColumn) . "2", "PEMBUAT");
      $sheet->getColumnDimension($nextColumn)->setWidth($columnWidth);
      $sheet->setCellValue((++$nextColumn) . "2", "PEKERJA");
      $sheet->getColumnDimension($nextColumn)->setWidth($columnWidth);
      $sheet->setCellValue((++$nextColumn) . "2", "% KAIZEN");
      $sheet->getColumnDimension($nextColumn)->setWidth($columnWidth);
      $sheet->setCellValue((++$nextColumn) . "2", "% PEMBUAT");
      $sheet->getColumnDimension($nextColumn)->setWidth($columnWidth);

      $sheet->mergeCells("{$startColumn}1:{$nextColumn}1");
    }

    $lastColumn = $nextColumn;

    // center text A1 - end column on row 1
    $sheet->getStyle("A1:{$lastColumn}2")->applyFromArray($STYLE['ALIGN']['CENTER']);
    $sheet->getStyle("A1:{$lastColumn}2")->getFont()->setBold(true);
    $sheet->getStyle("A")->applyFromArray($STYLE['ALIGN']['CENTER']);
    $sheet->getStyle($lastColumn)->applyFromArray($STYLE['ALIGN']['CENTER']);

    // Table body
    $nextRow = 3;
    foreach ($dataKaizen as $i => $kaizen) {
      $column = "A";
      $sheet->setCellValue(($column++) . "$nextRow", $i + 1);
      $sheet->setCellValue(($column++) . "$nextRow", $kaizen['section_name']);

      // januari - desember
      // the column will increase from A - ...
      foreach ($monthNumbers as $monthNumber) {
        // if month is high than current month. then skip to write data on that month
        if (date('Y-m') < ("$year-" . str_pad($monthNumber, 2, "0", STR_PAD_LEFT))) continue;

        $monthName = strtolower($monthNames[$monthNumber]);
        $kaizenColumn = $column . $nextRow;
        $sheet->setCellValue(($column++) . "$nextRow", $kaizen['kaizen_' . $monthName]);

        $actualColumn = $column . $nextRow;
        $sheet->setCellValue(($column++) . "$nextRow", $kaizen['actual_' . $monthName]);

        $planColumn = $column . $nextRow;
        $sheet->setCellValue(($column++) . "$nextRow", $kaizen['plan_' . $monthName]);

        $sheet->getStyle("{$column}{$nextRow}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
        $sheet->setCellValue(($column++) . "$nextRow", "=SUM($kaizenColumn/$planColumn)");

        $sheet->getStyle("{$column}{$nextRow}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
        $sheet->setCellValue(($column++) . "$nextRow", "=SUM($actualColumn/$planColumn)");
      }

      $nextRow++;
    }

    # Total Data
    $sheet->mergeCells("A$nextRow:B$nextRow");
    $sheet->getStyle("A$nextRow")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $sheet->setCellValue("A$nextRow", 'TOTAL');

    // use formula
    $column = "C";
    foreach ($monthNumbers as $monthNumber) {
      $rowBefore = $nextRow - 1;
      // if month is high than current month. then skip to write data on that month
      if (date('Y-m') < ("$year-" . str_pad($monthNumber, 2, "0", STR_PAD_LEFT))) continue;

      $totalKaizenColumn = $column . $nextRow;
      $sheet->setCellValue("{$column}{$nextRow}", "=SUM({$column}3:{$column}{$rowBefore})"); // kaizen
      $column++;

      $totalPembuatColumn = $column . $nextRow;
      $sheet->setCellValue("{$column}{$nextRow}", "=SUM({$column}3:{$column}{$rowBefore})"); // pembuat
      $column++;

      $totalPekerjaColumn = $column . $nextRow;
      $sheet->setCellValue("{$column}{$nextRow}", "=SUM({$column}3:{$column}{$rowBefore})"); // pekerja
      $column++;

      $sheet->getStyle("{$column}{$nextRow}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
      $sheet->setCellValue("{$column}{$nextRow}", "=SUM($totalKaizenColumn/$totalPekerjaColumn)"); // percent kaizen
      $column++;

      $sheet->getStyle("{$column}{$nextRow}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
      $sheet->setCellValue("{$column}{$nextRow}", "=SUM($totalPembuatColumn/$totalPekerjaColumn)"); // percent pembuat
      $column++;
    }

    $nextRow++;

    // add border from A1 to lastRow and lastColumn
    $lastColumn = $sheet->getHighestColumn();
    $lastRow = $sheet->getHighestDataRow();

    // bordered
    $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray($STYLE['BORDER']['ALL']);
    // center
    $sheet->getStyle("C3:{$lastColumn}{$lastRow}")->applyFromArray($STYLE['ALIGN']['CENTER']);

    // Freeze pane left of "Bulan"
    // $sheet->freezePane("C" . ($lastRow + 1));
    $sheet->setTitle($year);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"Report_Rekap_Kaizen_$year.xlsx\"");

    $objWriter->save("php://output");
  }
}
