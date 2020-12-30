<?php
Defined('BASEPATH') or exit('No direct Script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');
/**
 *
 */
class C_ExportRencanaLembur extends CI_Controller
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
    $this->load->model('CateringManagement/Extra/M_exportrencanalembur');
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

    $data['Title'] = 'Export Rencana Lembur';
    $data['Header'] = 'Export Rencana Lembur';
    $data['Menu'] = 'Extra';
    $data['SubMenuOne'] = 'Export Rencana Lembur';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);


    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('CateringManagement/Extra/ExportRencanaLembur/V_index.php', $data);
    $this->load->view('V_Footer', $data);
  }

  public function viewdata()
  {
    $tgllembur = $this->input->post('txtTanggalLembur');
    $tmpmakan = $this->input->post('txtTempatMakan');
    $statmakan = $this->input->post('txtStatusMakan');
    $statapprov = $this->input->post('txtStatusApprov');

    $data['PekerjaLembur'] = $this->M_exportrencanalembur->getDataLembur($tgllembur, $tmpmakan, $statmakan, $statapprov);

    $html = $this->load->view('CateringManagement/Extra/ExportRencanaLembur/V_Table.php', $data);
    echo json_encode($html);
  }

  public function export_excel()
  {
    $tgllembur = $this->input->post('txtTanggalLembur');
    $tmpmakan = $this->input->post('txtTempatMakan');
    $statmakan = $this->input->post('txtStatusMakan');
    $statapprov = $this->input->post('txtStatusApprov');

    if ($tmpmakan == '1') {
      $lokasi = "Yogyakarta";
    } elseif ($tmpmakan == "2") {
      $lokasi = "Tuksono";
    } else {
      $lokasi =  'Semua Lokasi';
    }

    if ($statmakan == "1") {
      $makan = "Makan";
    } elseif ($statmakan == "0") {
      $makan = "Tidak Makan";
    } else {
      $makan =  'Semua Status';
    }

    if ($statapprov == "1") {
      $approval = "Disetujui";
    } elseif ($statapprov == "2") {
      $approval = "Tidak Disetujui";
    } elseif ($statapprov == "0") {
      $approval = "Belum Diproses Atasan";
    } else {
      $approval =  'Semua Status';
    }

    $result = $this->M_exportrencanalembur->getDataLembur($tgllembur, $tmpmakan, $statmakan, $statapprov);

    $this->load->library('excel');

    $worksheet = $this->excel->getActiveSheet();

    $worksheet->mergeCells('A1:C1');
    $worksheet->getCell('A1')
      ->setValue('Rencana Lembur')->getStyle("A1")->applyFromArray(array("font" => array("bold" => true)));

    $worksheet->mergeCells('A2:B2');
    $worksheet->getCell('A2')
      ->setValue('Tanggal');

    $worksheet->getCell('C2')
      ->setValue(': ' . $tgllembur);

    $worksheet->mergeCells('A3:B3');
    $worksheet->getCell('A3')
      ->setValue('Status Makan');

    $worksheet->getCell('C3')
      ->setValue(': ' . $makan);


    $worksheet->getCell('D2')
      ->setValue('Lokasi');

    $worksheet->getCell('E2')
      ->setValue(': ' . $lokasi);

    $worksheet->getCell('D3')
      ->setValue('Status Approve');


    $worksheet->getCell('E3')
      ->setValue(': ' . $approval);



    $worksheet->getStyle("A5:K5")->applyFromArray(array("font" => array("bold" => true)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $worksheet->getStyle("A5:K5")->applyFromArray(array(
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
    $worksheet->setCellValue('B5', 'Pekerja');
    $worksheet->setCellValue('C5', 'Mulai Lembur');
    $worksheet->setCellValue('D5', 'Selesai Lembur');
    $worksheet->setCellValue('E5', 'Nama Lembur');
    $worksheet->setCellValue('F5', 'Pekerjaan');
    $worksheet->setCellValue('G5', 'Makan');
    $worksheet->setCellValue('H5', 'Tempat Makan');
    $worksheet->setCellValue('I5', 'Shift');
    $worksheet->setCellValue('J5', 'Atasan');
    $worksheet->setCellValue('K5', 'Status');

    $angka = 1;
    $row = 6;
    foreach ($result as $key) {
      $worksheet->setCellValue('A' . $row, $angka);
      $worksheet->setCellValue('B' . $row, $key['pekerja_noind'] . " - " . $key['pekerja_nama']);
      $worksheet->setCellValue('C' . $row, $key['mulai']);
      $worksheet->setCellValue('D' . $row, $key['selesai']);
      $worksheet->setCellValue('E' . $row, $key['nama_lembur']);
      $worksheet->setCellValue('F' . $row, $key['pekerjaan']);
      $worksheet->setCellValue('G' . $row, $key['makan']);
      $worksheet->setCellValue('H' . $row, $key['tempat_makan']);
      $worksheet->setCellValue('I' . $row, $key['shift']);
      $worksheet->setCellValue('J' . $row, $key['atasan_noind'] . " - " . $key['atasan_nama']);
      $worksheet->setCellValue('K' . $row, $key['status']);
      $worksheet->getStyle('A' . $row)->applyFromArray($border);
      $worksheet->getStyle('B' . $row)->applyFromArray($border);
      $worksheet->getStyle('C' . $row)->applyFromArray($border);
      $worksheet->getStyle('D' . $row)->applyFromArray($border);
      $worksheet->getStyle('E' . $row)->applyFromArray($border);
      $worksheet->getStyle('F' . $row)->applyFromArray($border);
      $worksheet->getStyle('G' . $row)->applyFromArray($border);
      $worksheet->getStyle('H' . $row)->applyFromArray($border);
      $worksheet->getStyle('I' . $row)->applyFromArray($border);
      $worksheet->getStyle('J' . $row)->applyFromArray($border);
      $worksheet->getStyle('K' . $row)->applyFromArray($border);
      $row++;
      $angka++;
    }

    $worksheet->getColumnDimension('A')->setWidth('5');
    foreach (range('B', 'K') as $columnID) {
      $worksheet->getColumnDimension($columnID)
        ->setWidth('15');
    }

    $filename = 'Rencana_Lembur_' . $tgllembur . '.xls';
    header('Content-Type: aplication/vnd.ms-excel');
    header('Content-Disposition:attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    $writer->save('php://output');
  }

  public function export_pdf()
  {
    $tgllembur = $this->input->get('tgllembur');
    $tmpmakan = $this->input->get('tmpmakan');
    $statmakan = $this->input->get('statmakan');
    $statapprov = $this->input->get('statapprov');

    if ($tmpmakan == "1") {
      $lokasi = "Yogyakarta";
    } elseif ($tmpmakan == "2") {
      $lokasi = "Tuksono";
    } else {
      $lokasi =  'Semua Lokasi';
    }

    if ($statmakan == "1") {
      $makan = "Makan";
    } elseif ($statmakan == "0") {
      $makan = "Tidak Makan";
    } else {
      $makan =  'Semua Status';
    }

    if ($statapprov == "1") {
      $approval = "Disetujui";
    } elseif ($statapprov == "2") {
      $approval = "Tidak Disetujui";
    } elseif ($statapprov == "0") {
      $approval = "Belum Diproses Atasan";
    } else {
      $approval =  'Semua Status';
    }

    $result['PekerjaLembur'] = $this->M_exportrencanalembur->getDataLembur($tgllembur, $tmpmakan, $statmakan, $statapprov);
    $result['Filter'] = [
      "tgllembur" => $tgllembur,
      "tmpmakan" => $lokasi,
      "statmakan" => $makan,
      "statapprov" => $approval,
    ];;

    $this->load->library('pdf');

    $mpdf = $this->pdf->load();
    $mpdf = new mPDF('utf8', 'A4-L');
    $data = $this->load->view('CateringManagement/Extra/ExportRencanaLembur/V_pdf.php', $result, true);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->setAutoBottomMargin = 'stretch';
    $mpdf->SetHTMLFooter("<table style=\"width: 100%\"><tr><td><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh " . $this->session->user . " - " . $this->session->employee . " pada tgl. " . date('Y/M/d H:i:s') . "</i></td><td  rowspan=\"2\" style=\"vertical-align: middle; font-size: 8pt; text-align: right;\">Halaman {PAGENO} dari {nb}</td></tr></table>");
    $filename = 'Rencana_Lembur_' . $tgllembur . '.pdf';
    $mpdf->WriteHTML($data, 2);
    $mpdf->setTitle($filename);
    $mpdf->Output($filename, 'I');
  }
}
