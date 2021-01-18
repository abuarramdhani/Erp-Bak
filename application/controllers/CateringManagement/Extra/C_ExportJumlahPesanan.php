<?php
Defined('BASEPATH') or exit('No direct Script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');
/**
 *
 */
class C_ExportJumlahPesanan extends CI_Controller
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
    $this->load->model('CateringManagement/Extra/M_exportjumlahpesanan');
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

    $data['Title'] = 'Export Jumlah Pesanan';
    $data['Header'] = 'Export Jumlah Pesanan';
    $data['Menu'] = 'Extra';
    $data['SubMenuOne'] = 'Export Jumlah Pesanan';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('CateringManagement/Extra/ExportJumlahPesanan/V_index.php', $data);
    $this->load->view('V_Footer', $data);
  }

  public function viewdata()
  {
    $periode = $this->input->post('txtPeriodeJmlPesan');
    $lokasi = $this->input->post('txtLokasiJmlPesan');
    $shift = $this->input->post('txtShiftJmlPesan');

    $explode = explode(' - ', $periode);
    $periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
    $periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));

    $data['Export'] = $periode1 . "_" . $periode2 . "_" . $lokasi . "_" . $shift;
    $data['JumlahPesanan'] = $this->M_exportjumlahpesanan->getJumlahPesanan($periode1, $periode2, $lokasi, $shift);

    $html = $this->load->view('CateringManagement/Extra/ExportJumlahPesanan/V_Table.php', $data);
    echo json_encode($html);
  }

  public function export_excel($exp)
  {
    $explode = explode('_', $exp);
    $periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
    $periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));
    $lokasi = $explode['2'];
    $shift = $explode['3'];

    if ($lokasi == '1') {
      $ketlokasi = "Pusat + Mlati";
    } elseif ($lokasi == '2') {
      $ketlokasi = "Tuksono";
    } else {
      $ketlokasi = 'Semua Lokasi';
    }

    if ($shift == '1') {
      $ketshift = "Shift 1";
    } elseif ($shift == '2') {
      $ketshift = "Shift 2";
    } elseif ($shift == '3') {
      $ketshift = "Shift 3";
    } else {
      $ketshift = 'Semua Shift';
    }

    $res = $this->M_exportjumlahpesanan->getJumlahPesanan($periode1, $periode2, $lokasi, $shift);

    $this->load->library('excel');

    $worksheet = $this->excel->getActiveSheet();

    $worksheet->mergeCells('A1:C1');
    $worksheet->getCell('A1')
      ->setValue('Jumlah Pesanan Catering')->getStyle("A1")->applyFromArray(array("font" => array("bold" => true)));

    $worksheet->mergeCells('A2:B2');
    $worksheet->getCell('A2')
      ->setValue('Periode');

    $worksheet->getCell('C2')
      ->setValue(': ' . $periode1 . " - " . $periode2);

    $worksheet->mergeCells('A3:B3');
    $worksheet->getCell('A3')
      ->setValue('Lokasi');

    $worksheet->getCell('C3')
      ->setValue(': ' . $ketlokasi);

    $worksheet->mergeCells('A4:B4');
    $worksheet->getCell('A4')
      ->setValue('Shift');

    $worksheet->getCell('C4')
      ->setValue(': ' . $ketshift);

    $worksheet->getStyle("A5:E5")->applyFromArray(array("font" => array("bold" => true)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $worksheet->getStyle("A5:E5")->applyFromArray(array(
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

    $worksheet->setCellValue('A5', 'No');
    $worksheet->setCellValue('B5', 'Lokasi');
    $worksheet->setCellValue('C5', 'Tanggal');
    $worksheet->setCellValue('D5', 'Shift');
    $worksheet->setCellValue('E5', 'Jumlah');

    $angka = 1;
    $row = 6;
    foreach ($res as $key) {
      $worksheet->setCellValue('A' . $row, $angka);
      $worksheet->setCellValue('B' . $row, $key['lokasi']);
      $worksheet->setCellValue('C' . $row, $key['fd_tanggal']);
      $worksheet->setCellValue('D' . $row, $key['shift']);
      $worksheet->setCellValue('E' . $row, $key['jumlah']);
      $worksheet->getStyle('A' . $row)->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('B' . $row)->applyFromArray($border);
      $worksheet->getStyle('C' . $row)->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('D' . $row)->applyFromArray($border);
      $worksheet->getStyle('E' . $row)->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $row++;
      $angka++;
    }

    $worksheet->getColumnDimension('A')->setWidth('5');
    foreach (range('B', 'E') as $columnID) {
      $worksheet->getColumnDimension($columnID)
        ->setWidth('15');
    }

    $filename = 'Jumlah_Pesanan_Catering_' . $periode1 . "-" . $periode2 . '.xls';
    header('Content-Type: aplication/vnd.ms-excel');
    header('Content-Disposition:attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    $writer->save('php://output');
  }

  public function export_pdf($exp)
  {
    $explode = explode('_', $exp);
    $periode1 = str_replace('/', '-', date('Y-m-d', strtotime($explode[0])));
    $periode2 = str_replace('/', '-', date('Y-m-d', strtotime($explode[1])));
    $lokasi = $explode['2'];
    $shift = $explode['3'];

    if ($lokasi == '1') {
      $ketlokasi = "Pusat + Mlati";
    } elseif ($lokasi == '2') {
      $ketlokasi = "Tuksono";
    } else {
      $ketlokasi = 'Semua Lokasi';
    }

    if ($shift == '1') {
      $ketshift = "Shift 1";
    } elseif ($shift == '2') {
      $ketshift = "Shift 2";
    } elseif ($shift == '3') {
      $ketshift = "Shift 3";
    } else {
      $ketshift = 'Semua Shift';
    }

    $res['JumlahPesanan'] = $this->M_exportjumlahpesanan->getJumlahPesanan($periode1, $periode2, $lokasi, $shift);
    $res['Filter'] = [
      "periode" => $periode1 . " - " . $periode2,
      "lokasi" => $ketlokasi,
      "shift" => $ketshift,
    ];;

    $this->load->library('pdf');

    $mpdf = $this->pdf->load();
    $mpdf = new mPDF('utf8', 'A4-P');
    $data = $this->load->view('CateringManagement/Extra/ExportJumlahPesanan/V_pdf.php', $res, true);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->setAutoBottomMargin = 'stretch';
    $mpdf->SetHTMLFooter("<table style=\"width: 100%\"><tr><td><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh " . $this->session->user . " - " . $this->session->employee . " </i></td><tr><td style='font-size: 8pt'><i> pada tgl. " . date('Y/M/d H:i:s') . "</i></td></tr><td  rowspan=\"2\" style=\"vertical-align: middle; font-size: 8pt; text-align: right;\">Halaman {PAGENO} dari {nb}</td></tr></table>");
    $filename = 'Jumlah_Pesanan_Catering_' . $periode1 . "-" . $periode2 . '.pdf';
    $mpdf->WriteHTML($data, 2);
    $mpdf->setTitle($filename);
    $mpdf->Output($filename, 'I');
  }
}
