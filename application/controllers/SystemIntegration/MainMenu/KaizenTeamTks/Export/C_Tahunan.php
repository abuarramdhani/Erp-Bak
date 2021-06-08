<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Tahunan extends CI_Controller
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
   *  @url SystemIntegration/KaizenPekerjaTks/TeamKaizen/Export/Tahunan
   */
  public function index()
  {
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
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/Export/V_Tahunan', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * Generate excel function
   * 
   * @url SystemIntegration/KaizenPekerjaTks/TeamKaizen/Export/Tahunan/doExport
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

    $maxKaizen = 10;

    // Table header
    $sheet->setCellValue('A1', "NO");
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->setCellValue('B1', "NO INDUK");
    $sheet->getColumnDimension('B')->setWidth(10);
    $sheet->setCellValue('C1', "NAMA");
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->setCellValue('D1', "SEKSI");
    $sheet->getColumnDimension('D')->setWidth(20);
    $sheet->setCellValue('E1', "UNIT");
    $sheet->getColumnDimension('E')->setWidth(10);
    $sheet->setCellValue('F1', "BULAN");
    $sheet->getColumnDimension('F')->setWidth(10);

    $nextColumn = "G";
    foreach (range(1, $maxKaizen) as $i) {
      $currentColumn = "{$nextColumn}1";
      $sheet->setCellValue($currentColumn, "IDE KAIZEN " . $i);
      $sheet->getColumnDimension($nextColumn)->setWidth(30);

      // set next column
      $nextColumn++;
    }

    // total
    $sheet->setCellValue("{$nextColumn}1", "TOTAL");
    $sheet->getColumnDimension($nextColumn)->setWidth(8);

    $lastColumn = $nextColumn;

    // center text A1 - end column on row 1
    $sheet->getStyle("A1:{$nextColumn}1")->applyFromArray($STYLE['ALIGN']['CENTER']);
    $sheet->getStyle("A")->applyFromArray($STYLE['ALIGN']['CENTER']);
    $sheet->getStyle($lastColumn)->applyFromArray($STYLE['ALIGN']['CENTER']);

    // Table body

    // 1 year
    $monthNumbers = range(1, 12);
    $monthNames = [0, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    $nextRow = 2;
    $number = 1;
    foreach ($monthNumbers as $monthNumber) {
      // select distinct noind on year-month
      $kaizenPerMonth = $this->M_kaizentimtks->getAllEmployeeKaizenByMonth($year, $monthNumber);

      foreach ($kaizenPerMonth as $kaizen) {
        // select all employee kaizen on year-month
        $employeeKaizens = $this->M_kaizentimtks->getKaizenByParameter(
          $year,
          $monthNumber,
          $day = false,
          $section_code = false,
          $category = false,
          $kaizen->no_ind
        );

        $sheet->setCellValue("A$nextRow", $number++);
        $sheet->setCellValue("B$nextRow", $kaizen->no_ind);
        $sheet->setCellValue("C$nextRow", $kaizen->name);
        $sheet->setCellValue("D$nextRow", $kaizen->section);
        $sheet->setCellValue("E$nextRow", $kaizen->unit);
        $sheet->setCellValue("F$nextRow", $monthNames[$monthNumber]);

        // ide kaizen
        $nextColumn = "G";
        foreach ($employeeKaizens as $subKaizen) {
          $currentColumn = "{$nextColumn}{$nextRow}";
          $sheet->setCellValue($currentColumn, $subKaizen->kaizen_title);
          $nextColumn++;
        }

        // total
        $sheet->setCellValue("{$lastColumn}{$nextRow}", count($employeeKaizens));

        $nextRow++;
      }
    }

    // add border from A1 to lastRow and lastColumn
    $lastColumn = $sheet->getHighestColumn();
    $lastRow = $sheet->getHighestDataRow();

    $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray($STYLE['BORDER']['ALL']);

    // Freeze pane left of "Bulan"
    // Why this is buggy, see on result of excel :(
    // $sheet->freezePane("G" . ($lastRow + 1));

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
