<?php

use Goat1000\SVGGraph\DisplayAxisRotated;

defined('BASEPATH') or exit('No direct script access allowed');

class C_Buletin extends CI_Controller
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
   * SystemIntegration/KaizenPekerjaTks/TeamKaizen/Export/Buletin
   */
  public function index()
  {
    $data['Title']        =  'Kaizen Pekerja Tuksono';
    $data['Header']       =  'Input Kaizen Pekerja Tuksono';
    $data['Menu']         =  'Export Kaizen';
    $data['SubMenuOne']   =  'Buletin';
    $data['SubMenuTwo']   =  '';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->userid, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->userid, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('SystemIntegration/MainMenu/KaizenTeamTks/Export/V_Buletin', $data);
    $this->load->view('V_Footer', $data);
  }

  /**
   * Export PDF buletin
   * 
   * SystemIntegration/KaizenPekerjaTks/TeamKaizen/Export/Resume/doExport
   */
  public function doExport()
  {
    $this->load->library('Excel');

    // Request
    $monthStart = $this->input->get('month_start');
    $monthEnd = $this->input->get('month_end');

    // format month to database formatlly
    $monthStart = date('Y-m', strtotime($monthStart));
    $monthEnd = date('Y-m', strtotime($monthEnd));

    // Do Validate check if actual month
    // :TODO


    // fetch all data needed from database

    # total kaizen tiap bulan
    $kaizenPerMonth = $this->M_kaizentimtks->getPercentageKaizenPerMonth($monthStart, $monthEnd);
    # total pekerja yang membuat kaiznen tiap bulan
    $employeeKaizenPerMonth = $this->M_kaizentimtks->getPercentageKaizenPerMonth($monthStart, $monthEnd, true);

    # total kaizen seksi(yang bikin kaizen) tiap bulan
    $kaizenSectionPerMonth = $this->M_kaizentimtks->getPercentageSeksiKaizenPerMonth($monthStart, $monthEnd);
    # total pekerja seksi(yang bikin kaizen) tiap bulan
    $employeeKaizenSectionPerMonth  = $this->M_kaizentimtks->getPercentageSeksiKaizenPerMonth($monthStart, $monthEnd, true);

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
        ],
        'LEFT' => [
          'borders' => [
            'left' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN
            ]
          ]
        ],
        'RIGHT' => [
          'borders' => [
            'right' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN
            ]
          ]
        ],
        'BOTTOM' => [
          'borders' => [
            'bottom' => [
              'style' => PHPExcel_Style_Border::BORDER_THIN
            ]
          ]
        ]
      ]
    ];

    $sheetName = "chart";

    $objPHPExcel = new PHPExcel();
    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->setTitle($sheetName);

    /**
     * Dedault Styling
     */
    $sheet
      ->getDefaultStyle()
      ->getAlignment()
      ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet
      ->getDefaultStyle()
      ->getFont()
      ->setBold(true);

    // Set default column & row witdth
    $sheet->getDefaultColumnDimension()->setWidth(3.6);
    // $sheet->getDefaultRowDimension()->setRowHeight(5);

    $startRow = 2;
    $startColumn = "B";
    $row = 2;
    $column = "B";

    // SET HEADER COP
    $sheet
      ->mergeCells("B2:D4") // logo
      ->mergeCells("E2:AK3") // big title
      ->setCellValue("E2", "LAPORAN PENCAPAIAN KAIZEN SUGGESTION SYSTEM (SS) \n Level Operator - Supervisor")
      ->mergeCells("E4:AK4") // sub title
      ->setCellValue("E4", "PERIODE FEBRUARI 2021")

      ->mergeCells('AL2:AN2') // approved
      ->setCellValue('AL2', "Approved") // approved
      ->mergeCells('AL3:AN3') // space
      ->mergeCells('AL4:AN4') // employee / Y DARU ADI
      ->setCellValue('AL4', "Y. Daru Adi") // employee / Y DARU ADI

      ->mergeCells("AO2:AQ2") // checked
      ->setCellValue("AO2", "Checked")
      ->mergeCells("AO3:AQ3") // space
      ->mergeCells("AO4:AQ4") // employee / M. Bahtiyar
      ->setCellValue("AO4", "M. Bahtiyar") // employee / M. Bahtiyar

      ->mergeCells("AR2:AT2") // prepared
      ->setCellValue("AR2", "Prepared")
      ->mergeCells("AR3:AT3") // space
      ->mergeCells("AR4:AT4") // employee / Wiharsono
      ->setCellValue("AR4", "Wiharsono") // employee / Wiharsono
    ;

    // add logo
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Quick Logo');
    $objDrawing->setDescription('Quick Tracktor Logo');
    $objDrawing->setPath(APPPATH . "../assets/img/logo/logo.png");
    $objDrawing->setCoordinates('B2');
    //setOffsetX works properly
    $objDrawing->setOffsetX(10);
    $objDrawing->setOffsetY(5);
    //set width, height
    $objDrawing->setWidth(150);
    $objDrawing->setHeight(70);
    $objDrawing->setWorksheet($sheet);

    // set font
    $sheet->getStyle('E2')->getFont()->setSize(18);

    // Set row height
    $sheet->getRowDimension(3)->setRowHeight(30);
    // Font styling
    $sheet->getStyle('B2:AT4')->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
      ->setWrapText(true);
    // Set border
    $sheet->getStyle('B2:AT4')->applyFromArray($STYLE['BORDER']['ALL']);
    // set bold
    $sheet->getStyle('B2:AT4')->getFont()->setBold(true);

    // END SET HEADER COP

    // SET BODY
    $sheet
      ->mergeCells('B6:Q8') // NUMBER 1
      ->mergeCells('R6:AT8') // NUMBER 2
      ->mergeCells('B24:Q26') // NUMBER 3
      ->mergeCells('R24:AT26') // NUMBER 4
    ;

    // Set Chart group Title
    $sheet
      ->setCellValue('B6', "INDEX KAIZEN ACHIEVMENT KHS TUKSONO \n  DESEMBER 2020 - FEBRUARI 2021")
      ->setCellValue('R6', "INDEX KAIZEN ACHIEVEMENT PER SEKSI KHS TUKSONO \n DESEMBER 2021 - FEBRUARI 2021")
      ->setCellValue('B24', "KAIZEN INVOLVEMENT KHS TUKSONO \n DESEMBER 2020 - FEBRUARI 2021")
      ->setCellValue('R24', "KAIZEN INVOLVEMENT PER SEKSI KHS TUKSONO \n DESEMBER 2020 - FEBRUARI 2021") // .
    ;

    // Center title
    foreach (['B6:Q8', 'R6:AT8', 'B24:Q26', 'R24:AT26'] as $cell) {
      $sheet->getStyle($cell)->applyFromArray($STYLE['BORDER']['ALL']);
      $sheet->getStyle($cell)->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        ->setWrapText(true);
    }

    /**
     * NOTE COLUMN
     */

    $TARGET_KAIZEN = 1;

    /**
     * GENERATE DATA TABLE
     * 
     * 
     */
    # CHART 1
    $sheet->setCellValue('AV2', "CHART 1");
    $sheet->setCellValue('AV3', "Bulan");
    $sheet->setCellValue('AW3', "Index");
    $sheet->setCellValue('AX3', "Target");

    $sheet->getColumnDimension('AV')->setWidth(7);
    $sheet->getColumnDimension('AW')->setWidth(5);
    $sheet->getColumnDimension('AX')->setWidth(7);

    $chart_1_row_start = 4;
    $row = 5;
    foreach ($kaizenPerMonth as $item) {
      $sheet->setCellValue('AV' . ($row), $item->short_month);
      $sheet->setCellValue('AW' . ($row), number_format(($item->total_kaizen / $item->total_employee), 2));
      $sheet->setCellValue('AX' . ($row), $TARGET_KAIZEN);
      $row++;
    }
    $chart_1_row_end = $row;
    $sheet->getStyle('AV2:AX' . ($row - 1))->applyFromArray($STYLE['BORDER']['ALL']);
    #END CHART 1

    #CHART 2
    $sheet->setCellValue('AZ2', "CHART 1");
    $sheet->setCellValue('AZ3', "Bulan");
    $sheet->setCellValue('BA3', "Index");
    $sheet->setCellValue('BB3', "Target");

    $sheet->getColumnDimension('AZ')->setWidth(7);
    $sheet->getColumnDimension('BA')->setWidth(5);
    $sheet->getColumnDimension('BB')->setWidth(7);

    $chart_2_row_start = 4;
    $row = 5;
    foreach ($employeeKaizenPerMonth as $item) {
      $sheet->setCellValue('AZ' . ($row), $item->short_month);
      $sheet->setCellValue('BA' . ($row), number_format(($item->total_kaizen / $item->total_employee), 2));
      $sheet->setCellValue('BB' . ($row), $TARGET_KAIZEN);
      $row++;
    }
    $chart_2_row_end = $row;
    $sheet->getStyle('AZ2:BB' . ($row - 1))->applyFromArray($STYLE['BORDER']['ALL']);
    #END CHART 2

    #CHART 1 DETAIL
    $sheet->setCellValue('BD2', "Chart 1 Detail");
    $sheet->setCellValue('BD3', "Seksi");
    $sheet->getColumnDimension("BD")->setWidth(30);

    $column = "BE";
    foreach ($kaizenSectionPerMonth as $item) {
      $sheet->getColumnDimension($column)->setWidth(5);
      $sheet->setCellValue(($column++) . '3', $item['0']['short_month']);
    }

    $sheet->setCellValue($column . '3', "Target");
    $sheet->getColumnDimension($column++)->setWidth(7); // target
    $sheet->getColumnDimension($column)->setWidth(10); // GAP

    $chart_1_detail_row_start = 4;
    $row = 5;
    foreach ($kaizenSectionPerMonth[0] as $i => $detail) {
      $sheet->setCellValue('BD' . ($row), $detail['section_name']);

      $column = "BD";
      foreach ($kaizenSectionPerMonth as $x => $item) {
        $column++;
        $sheet->setCellValue(($column) . ($row), number_format(($kaizenSectionPerMonth[$x][$i]['total'] / $kaizenSectionPerMonth[$x][$i]['employee_count']), 2));
      }
      // target
      $sheet->setCellValue((++$column) . ($row), $TARGET_KAIZEN);

      $row++;
    }
    $chart_1_detail_row_end = $row;
    $sheet->getStyle('BD2:' . $column . ($row - 1))->applyFromArray($STYLE['BORDER']['ALL']);
    #END CHART 1 DETAIL

    #CHART 2 DETAIL
    $sheet->setCellValue('BJ2', "Chart 2 Detail");
    $sheet->setCellValue('BJ3', "Seksi");
    $sheet->getColumnDimension("BJ")->setWidth(30);

    $column = "BK";
    foreach ($kaizenSectionPerMonth as $item) {
      $sheet->getColumnDimension($column)->setWidth(5);
      $sheet->setCellValue(($column++) . '3', $item['0']['short_month']);
    }

    $sheet->setCellValue($column . '3', "Target");
    $sheet->getColumnDimension($column++)->setWidth(7); // target
    $sheet->getColumnDimension($column)->setWidth(10); // GAP

    $chart_2_detail_row_start = 4;
    $row = 5;

    foreach ($employeeKaizenSectionPerMonth[0] as $i => $detail) {
      $sheet->setCellValue('BJ' . ($row), $detail['section_name']);

      $column = "BJ";
      foreach ($employeeKaizenSectionPerMonth as $x => $item) {
        $column++;
        $sheet->setCellValue(($column) . ($row), number_format(($employeeKaizenSectionPerMonth[$x][$i]['total'] / $kaizenSectionPerMonth[$x][$i]['employee_count']), 2));
      }
      // target
      $sheet->setCellValue((++$column) . ($row), $TARGET_KAIZEN);

      $row++;
    }
    $chart_2_detail_row_end = $row;

    $sheet->getStyle('BJ2:' . $column . ($row - 1))->applyFromArray($STYLE['BORDER']['ALL']);
    #END CHART 2 DETAIL

    // Draw a line

    // left
    $sheet->getStyle('B9:B40')->applyFromArray($STYLE['BORDER']['LEFT']);
    // right
    $sheet->getStyle('AT9:AT40')->applyFromArray($STYLE['BORDER']['RIGHT']);
    //bottom
    $sheet->getStyle('B40:AT40')->applyFromArray($STYLE['BORDER']['BOTTOM']);
    // mid line border
    $sheet->getStyle('Q9:Q40')->applyFromArray($STYLE['BORDER']['RIGHT']);

    /**
     * ---------
     * CHART
     * ---------
     */

    # Chart 1
    $chart_1 = $this->generateChart_1($sheetName, $chart_1_row_start, $chart_1_row_end);
    $chart_1->setTopLeftPosition('C10');
    $chart_1->setBottomRightPosition('P22');

    # Chart 2
    $chart_2 = $this->generateChart_2($sheetName, $chart_2_row_start, $chart_2_row_end);
    $chart_2->setTopLeftPosition('C28');
    $chart_2->setBottomRightPosition('P39');

    # Chart 1 Detail
    $chart_1_detail = $this->generateChartDetail_1($sheetName, $chart_1_detail_row_start, $chart_1_detail_row_end, count($kaizenSectionPerMonth));
    $chart_1_detail->setTopLeftPosition('S10');
    $chart_1_detail->setBottomRightPosition('AS22');

    # Chart 2 Detail
    $chart_2_detail = $this->generateChartDetail_2($sheetName, $chart_2_detail_row_start, $chart_2_detail_row_end, count($employeeKaizenSectionPerMonth));
    $chart_2_detail->setTopLeftPosition('S28');
    $chart_2_detail->setBottomRightPosition('AS39');

    //  Add the chart to the worksheet
    $sheet->addChart($chart_1);
    $sheet->addChart($chart_2);
    $sheet->addChart($chart_1_detail);
    $sheet->addChart($chart_2_detail);
    //

    /**
     * ---------
     * END CHART
     * ---------
     */


    // chart must use Excel2007
    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->setOffice2003Compatibility(true);
    $objWriter->setIncludeCharts(true);

    // $objWriter->save("php://output");
    // die;

    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"Report_Buletin.xlsx\"");
    $objWriter->save("php://output");
  }

  protected function generateChart_1($sheetName, $rowStart, $rowEnd)
  {
    $this->load->library('Excel');

    // $objPHPExcel = new PHPExcel();

    //	Set the Labels for each data series we want to plot
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $dataSeriesLabels = array(
      new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$AW$3', NULL, 1),  //	'Budget'
    );

    $dataLineSeriesLabels = array(
      new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$AX$3', NULL, 1),  //	'Forecast'
    );

    //	Set the X-Axis Labels
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $xAxisTickValues = array(
      new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$AV$' . $rowStart . ':$AV$' . $rowEnd, NULL, 12),
    );

    //	Set the X-Axis Labels
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $xAxisTickLinesValues = array(
      new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$AX$' . $rowStart . ':$AX$' . $rowEnd, NULL, 12),  //	Q1 to Q4 for 2010 to 2012
    );

    //	Set the Data values for each data series we want to plot
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $dataSeriesValues = array(
      new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!$AW$' . $rowStart . ':$AW$' . $rowEnd, NULL),
    );

    $dataLineSeriesValues = array(
      new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!$AX$' . $rowStart . ':$AX$' . $rowEnd, NULL),
    );

    //	Build the dataseries
    $series = new PHPExcel_Chart_DataSeries(
      PHPExcel_Chart_DataSeries::TYPE_BARCHART,    // plotType
      PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
      range(0, count($dataSeriesValues) - 1),      // plotOrder
      $dataSeriesLabels,                // plotLabel
      $xAxisTickValues,                // plotCategory
      $dataSeriesValues            // plotValues
    );

    $lineSeries =  new PHPExcel_Chart_DataSeries(
      PHPExcel_Chart_DataSeries::TYPE_LINECHART,    // plotType
      PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
      range(0, count($dataSeriesValues) - 1),      // plotOrder
      $dataLineSeriesLabels,                // plotLabel
      $xAxisTickLinesValues,             // plotCategory
      $dataLineSeriesValues        // plotValues
    );

    //	Set additional dataseries parameters
    //		Make it a vertical column rather than a horizontal bar graph
    $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
    $lineSeries->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

    // Set layout
    $layout = new PHPExcel_Chart_Layout();
    $layout->setShowVal(true);

    //	Set the series in the plot area
    $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series, $lineSeries));
    //	Set the chart legend
    $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

    $title = new PHPExcel_Chart_Title('Test Grouped Column Chart');
    $title = null;
    $xAxisLabel = new PHPExcel_Chart_Title('Financial Period');
    $xAxisLabel = null;
    $yAxisLabel = new PHPExcel_Chart_Title('Persen');
    $xAxisLabel = null;

    $yAxis = new PHPExcel_Chart_Axis;
    $yAxis->setAxisOptionsProperties(
      PHPExcel_Chart_Axis::AXIS_LABELS_LOW
    );

    //	Create the chart
    $chart = new PHPExcel_Chart(
      'chart1',    // name
      $title,      // title
      $legend,    // legend
      $plotArea,    // plotArea
      true,      // plotVisibleOnly
      0,        // displayBlanksAs
      $xAxisLabel,  // xAxisLabel
      $yAxisLabel,    // yAxisLabel,
      $yAxis, // xAxis
      $yAxis // yAxis
    );

    return $chart;
  }

  protected function generateChartDetail_1($sheetName, $rowStart, $rowEnd, $monthCount)
  {
    $this->load->library('Excel');

    $plotLabel = [];

    $startColumn = "BE";
    for ($i = 0; $i < $monthCount; $i++) {
      $plotLabel[] =  new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$' . $startColumn . '$3', NULL, 1);
      $startColumn++;
    }

    $plotValues = [];

    $startColumn = "BE";
    for ($i = 0; $i < $monthCount; $i++) {
      $plotValues[] = new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!$' . $startColumn . '$' . $rowStart . ':$' . $startColumn . '$' . $rowEnd, NULL, 1);
      $startColumn++;
    }

    //	Build the dataseries
    $series = new PHPExcel_Chart_DataSeries(
      PHPExcel_Chart_DataSeries::TYPE_BARCHART,    // plotType
      PHPExcel_Chart_DataSeries::GROUPING_STANDARD,  // plotGrouping
      range(0, $monthCount - 1),      // plotOrder
      $plotLabel,  // plotLabel
      array(
        new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$BD$' . $rowStart . ':$BD$' . $rowEnd, NULL),  //	Q1 to Q4 for 2010 to 2012
      ), // plotCategory
      $plotValues // plotValues
    );

    $lineSeries =  new PHPExcel_Chart_DataSeries(
      PHPExcel_Chart_DataSeries::TYPE_LINECHART,    // plotType
      PHPExcel_Chart_DataSeries::GROUPING_STANDARD,  // plotGrouping
      range(0, $monthCount - 1), // plotOrder
      array(
        new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$' . $startColumn . '$3', NULL, 1)
      ), // 'Forecast'
      null,
      array(
        new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!$' . $startColumn . '$' . $rowStart . ':$' . $startColumn . '$' . $rowEnd, NULL)
      ) // plotValues
    );

    //	Set additional dataseries parameters
    //		Make it a vertical column rather than a horizontal bar graph
    $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

    // Set layout
    $layout = new PHPExcel_Chart_Layout();
    $layout->setShowVal(true);

    //	Set the series in the plot area
    $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series, $lineSeries));
    //	Set the chart legend
    $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

    $title = new PHPExcel_Chart_Title('Test Grouped Column Chart');
    $title = null;
    $xAxisLabel = new PHPExcel_Chart_Title('Financial Period');
    $xAxisLabel = null;
    $yAxisLabel = new PHPExcel_Chart_Title('Value');
    $yAxisLabel = null;

    $xAxis = new PHPExcel_Chart_Axis;
    $xAxis->setAxisOptionsProperties(
      PHPExcel_Chart_Axis::AXIS_LABELS_LOW
    );

    $yAxis = new PHPExcel_Chart_Axis;
    $yAxis->setAxisOptionsProperties(
      PHPExcel_Chart_Axis::AXIS_LABELS_LOW,
      null,
      null,
      '90'
    );

    //	Create the chart
    $chart = new PHPExcel_Chart(
      'Chart 1 detail',    // name
      $title,      // title
      $legend,    // legend
      $plotArea,    // plotArea
      true,      // plotVisibleOnly
      0,        // displayBlanksAs
      $xAxisLabel,  // xAxisLabel
      $yAxisLabel,    // yAxisLabel,
      $xAxis, // xAxis
      $yAxis, // yAxis
      null
    );

    return $chart;
  }

  protected function generateChart_2($sheetName, $rowStart, $rowEnd)
  {
    $this->load->library('Excel');

    // $objPHPExcel = new PHPExcel();

    //	Set the Labels for each data series we want to plot
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $dataSeriesLabels = array(
      new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$AZ$3', NULL, 1),  //	'Budget'
    );

    $dataLineSeriesLabels = array(
      new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$BB$3', NULL, 1),  //	'Forecast'
    );

    //	Set the X-Axis Labels
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $xAxisTickValues = array(
      new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$AZ$' . $rowStart . ':$AZ$' . $rowEnd, NULL, 12),
    );

    //	Set the X-Axis Labels
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $xAxisTickLinesValues = array(
      new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$BB$' . $rowStart . ':$BB$' . $rowEnd, NULL, 12),  //	Q1 to Q4 for 2010 to 2012
    );

    //	Set the Data values for each data series we want to plot
    //		Datatype
    //		Cell reference for data
    //		Format Code
    //		Number of datapoints in series
    //		Data values
    //		Data Marker
    $dataSeriesValues = array(
      new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!$BA$' . $rowStart . ':$BA$' . $rowEnd, NULL),
    );

    $dataLineSeriesValues = array(
      new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!$BB$' . $rowStart . ':$BB$' . $rowEnd, NULL),
    );

    //	Build the dataseries
    $series = new PHPExcel_Chart_DataSeries(
      PHPExcel_Chart_DataSeries::TYPE_BARCHART,    // plotType
      PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
      range(0, count($dataSeriesValues) - 1),      // plotOrder
      $dataSeriesLabels,                // plotLabel
      $xAxisTickValues,                // plotCategory
      $dataSeriesValues            // plotValues
    );

    $lineSeries =  new PHPExcel_Chart_DataSeries(
      PHPExcel_Chart_DataSeries::TYPE_LINECHART,    // plotType
      PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
      range(0, count($dataSeriesValues) - 1),      // plotOrder
      $dataLineSeriesLabels,                // plotLabel
      $xAxisTickLinesValues,             // plotCategory
      $dataLineSeriesValues        // plotValues
    );

    //	Set additional dataseries parameters
    //		Make it a vertical column rather than a horizontal bar graph
    $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
    $lineSeries->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

    // Set layout
    $layout = new PHPExcel_Chart_Layout();
    $layout->setShowVal(true);

    //	Set the series in the plot area
    $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series, $lineSeries));
    //	Set the chart legend
    $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

    $title = new PHPExcel_Chart_Title('Test Grouped Column Chart');
    $title = null;
    $xAxisLabel = new PHPExcel_Chart_Title('Financial Period');
    $xAxisLabel = null;
    $yAxisLabel = new PHPExcel_Chart_Title('Persen');
    $xAxisLabel = null;

    $yAxis = new PHPExcel_Chart_Axis;
    $yAxis->setAxisOptionsProperties(
      PHPExcel_Chart_Axis::AXIS_LABELS_LOW
    );

    //	Create the chart
    $chart = new PHPExcel_Chart(
      'chart1',    // name
      $title,      // title
      $legend,    // legend
      $plotArea,    // plotArea
      true,      // plotVisibleOnly
      0,        // displayBlanksAs
      $xAxisLabel,  // xAxisLabel
      $yAxisLabel,    // yAxisLabel,
      $yAxis, // xAxis
      $yAxis // yAxis
    );

    return $chart;
  }

  protected function generateChartDetail_2($sheetName, $rowStart, $rowEnd, $monthCount)
  {
    $this->load->library('Excel');

    $plotLabel = [];

    $startColumn = "BJ";
    for ($i = 0; $i < $monthCount; $i++) {
      $plotLabel[] =  new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$' . $startColumn . '$3', NULL, 1);
      $startColumn++;
    }

    $plotValues = [];

    $startColumn = "BK";
    for ($i = 0; $i < $monthCount; $i++) {
      $plotValues[] = new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!$' . $startColumn . '$' . $rowStart . ':$' . $startColumn . '$' . $rowEnd, NULL, 1);
      $startColumn++;
    }

    //	Build the dataseries
    $series = new PHPExcel_Chart_DataSeries(
      PHPExcel_Chart_DataSeries::TYPE_BARCHART,    // plotType
      PHPExcel_Chart_DataSeries::GROUPING_STANDARD,  // plotGrouping
      range(0, $monthCount - 1),      // plotOrder
      $plotLabel,  // plotLabel
      array(
        new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$BJ$' . $rowStart . ':$BJ$' . $rowEnd, NULL),  //	Q1 to Q4 for 2010 to 2012
      ), // plotCategory
      $plotValues // plotValues
    );

    $lineSeries =  new PHPExcel_Chart_DataSeries(
      PHPExcel_Chart_DataSeries::TYPE_LINECHART,    // plotType
      PHPExcel_Chart_DataSeries::GROUPING_STANDARD,  // plotGrouping
      range(0, $monthCount - 1), // plotOrder
      array(
        new PHPExcel_Chart_DataSeriesValues('String', $sheetName . '!$' . $startColumn . '$3', NULL, 1)
      ), // 'Forecast'
      null,
      array(
        new PHPExcel_Chart_DataSeriesValues('Number', $sheetName . '!$' . $startColumn . '$' . $rowStart . ':$' . $startColumn . '$' . $rowEnd, NULL)
      ) // plotValues
    );

    //	Set additional dataseries parameters
    //		Make it a vertical column rather than a horizontal bar graph
    $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

    // Set layout
    $layout = new PHPExcel_Chart_Layout();
    $layout->setShowVal(true);

    //	Set the series in the plot area
    $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series, $lineSeries));
    //	Set the chart legend
    $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

    $title = new PHPExcel_Chart_Title('Test Grouped Column Chart');
    $title = null;
    $xAxisLabel = new PHPExcel_Chart_Title('Financial Period');
    $xAxisLabel = null;
    $yAxisLabel = new PHPExcel_Chart_Title('Value');
    $yAxisLabel = null;

    $xAxis = new PHPExcel_Chart_Axis;
    $xAxis->setAxisOptionsProperties(
      PHPExcel_Chart_Axis::AXIS_LABELS_LOW
    );

    $yAxis = new PHPExcel_Chart_Axis;
    $yAxis->setAxisOptionsProperties(
      PHPExcel_Chart_Axis::AXIS_LABELS_LOW,
      null,
      null,
      '90'
    );

    //	Create the chart
    $chart = new PHPExcel_Chart(
      'Chart 1 detail',    // name
      $title,      // title
      $legend,    // legend
      $plotArea,    // plotArea
      true,      // plotVisibleOnly
      0,        // displayBlanksAs
      $xAxisLabel,  // xAxisLabel
      $yAxisLabel,    // yAxisLabel,
      $xAxis, // xAxis
      $yAxis, // yAxis
      null
    );

    return $chart;
  }
}
