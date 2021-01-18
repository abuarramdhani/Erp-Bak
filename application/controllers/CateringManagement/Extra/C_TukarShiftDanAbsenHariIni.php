<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_TukarShiftDanAbsenHariIni extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->library('form_validation');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('CateringManagement/Extra/M_tukarshiftdanabsenhariini');
    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) { } else {
      redirect('');
    }
  }

  public function index()
  {
    $user_id = $this->session->userid;
    $user = $this->session->user;

    $data['Title'] = 'Tukar Shift Dan Absen Hari Ini';
    $data['Header'] = 'Tukar Shift Dan Absen Hari Ini';
    $data['Menu'] = 'Extra';
    $data['SubMenuOne'] = 'Tukar Shift Dan Absen Hari Ini';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $data['DataShiftAbsen'] = $this->M_tukarshiftdanabsenhariini->GetDataShiftAbsen();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('CateringManagement/Extra/TukarShiftDanAbsenHariIni/V_index.php', $data);
    $this->load->view('V_Footer', $data);
  }

  public function export_excel()
  {
    $data = $this->M_tukarshiftdanabsenhariini->GetDataShiftAbsen();

    $this->load->library('excel');

    $worksheet = $this->excel->getActiveSheet();

    $worksheet->getStyle("A3:I3")->applyFromArray(array("font" => array("bold" => true)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $worksheet->getStyle("A3:I3")->applyFromArray(array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    ));

    $border = array(
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
      )
    );

    $worksheet->mergeCells('A1:C1');
    $worksheet->getCell('A1')
      ->setValue('Tukar Shift dan Absen Manual')->getStyle("A1")->applyFromArray(array("font" => array("bold" => true)));

    $worksheet->mergeCells('A2:C2');
    $worksheet->getCell('A2')
      ->setValue('Tanggal : ' . date("d - m - Y"));

    $worksheet->setCellValue('A3', 'No');
    $worksheet->setCellValue('B3', 'No. Induk');
    $worksheet->setCellValue('C3', 'Nama');
    $worksheet->setCellValue('D3', 'Seksi');
    $worksheet->setCellValue('E3', 'Tempat Makan');
    $worksheet->setCellValue('F3', 'Jenis');
    $worksheet->setCellValue('G3', 'Alasan');
    $worksheet->setCellValue('H3', 'Approver');
    $worksheet->setCellValue('I3', 'Waktu Aprrove');


    $angka = 1;
    $row = 4;
    foreach ($data as $key) {
      $worksheet->setCellValue('A' . $row, $angka);
      $worksheet->setCellValue('B' . $row, $key['noind']);
      $worksheet->setCellValue('C' . $row, $key['nama']);
      $worksheet->setCellValue('D' . $row, $key['seksi']);
      $worksheet->setCellValue('E' . $row, $key['tempat_makan']);
      $worksheet->setCellValue('F' . $row, $key['jenis']);
      $worksheet->setCellValue('G' . $row, $key['alasan']);
      $worksheet->setCellValue('H' . $row, $key['appr_']);
      $worksheet->setCellValue('I' . $row, $key['approve_timestamp']);

      $worksheet->getStyle('A' . $row)->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('B' . $row)->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('C' . $row)->applyFromArray($border);
      $worksheet->getStyle('D' . $row)->applyFromArray($border);
      $worksheet->getStyle('E' . $row)->applyFromArray($border);
      $worksheet->getStyle('F' . $row)->applyFromArray($border);
      $worksheet->getStyle('G' . $row)->applyFromArray($border);
      $worksheet->getStyle('H' . $row)->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('I' . $row)->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $row++;
      $angka++;
    }

    $worksheet->getColumnDimension('G')->setWidth('25');
    $worksheet->getColumnDimension('I')->setWidth('25');
    foreach (range('C', 'F') as $columnID) {
      $worksheet->getColumnDimension($columnID)
        ->setWidth('15');
    }

    $filename = 'Tukar Shift Dan Absen.xls';
    header('Content-Type: aplication/vnd.ms-excel');
    header('Content-Disposition:attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    $writer->save('php://output');
  }

  public function export_pdf()
  {

    $data['data'] = $this->M_tukarshiftdanabsenhariini->GetDataShiftAbsen();

    $this->load->library('pdf');

    $mpdf = $this->pdf->load();
    $mpdf = new mPDF('utf8', 'A4-L');
    $data = $this->load->view('CateringManagement/Extra/TukarShiftDanAbsenHariIni/V_pdf.php', $data, true);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->setAutoBottomMargin = 'stretch';
    $mpdf->SetHTMLFooter("<table style=\"width: 100%\"><tr><td><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh " . $this->session->user . " - " . $this->session->employee . " </i></td><tr><td style='font-size: 8pt'><i> pada tgl. " . date('Y/M/d H:i:s') . "</i></td></tr><td  rowspan=\"2\" style=\"vertical-align: middle; font-size: 8pt; text-align: right;\">Halaman {PAGENO} dari {nb}</td></tr></table>");
    $filename = 'Tukar Shift Dan Absen.pdf';
    $mpdf->WriteHTML($data, 2);
    $mpdf->setTitle($filename);
    $mpdf->Output($filename, 'I');
  }
}
