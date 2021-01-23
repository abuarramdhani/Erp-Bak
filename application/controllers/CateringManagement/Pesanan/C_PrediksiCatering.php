<?php
Defined('BASEPATH') or exit('No direct Script access allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PrediksiCatering extends CI_Controller
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
    $this->load->model('CateringManagement/Pesanan/M_prediksicatering');

    $this->checkSession();
  }

  public function checkSession()
  {
    if (!$this->session->is_logged) {
      redirect('');
    }
  }

  public function index()
  {
    $user = $this->session->username;

    $user_id = $this->session->userid;

    $data['Title'] = 'Prediksi Catering';
    $data['Header'] = 'Prediksi Catering';
    $data['Menu'] = 'Pesanan';
    $data['SubMenuOne'] = 'Prediksi Catering';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('CateringManagement/Pesanan/PrediksiCatering/V_Index');
    $this->load->view('V_Footer', $data);
  }
  public function viewdata()
  {
    $tanggal = $this->input->post('txtTglPredCat');
    $lokasi = $this->input->post('txtLokasiPredCat');
    $shift = $this->input->post('txtShiftPredCat');

    $data['Export'] = $tanggal . "_" . $lokasi . "_" . $shift;
    $data['PrediksiCatering'] = $prediksi = $this->M_prediksicatering->getPrediksiCatering($tanggal, $lokasi, $shift);

    if (!empty($prediksi)) {
      foreach ($prediksi as $key => $value) {
        $noind_array = $this->M_prediksicatering->getNoindByTempatMakanShiftTanggal($value['tempat_makan'], $shift, $tanggal);
        if (!empty($noind_array)) {
          foreach ($noind_array as $key2 => $value2) {
            $dinas_luar = $this->M_prediksicatering->getDinasLuarByNoind($value2['noind']);
            if (!empty($dinas_luar)) {
              foreach ($dinas_luar as $key3 => $value3) {
                $absen = $this->M_prediksicatering->getAbsenSetelahPulangByTimestampNoind($value3['tgl_pulang'], $value3['noind']);
                if (empty($absen)) {
                  $prediksi[$key]['dinas_luar'] += 1;
                }
              }
            }
          }
        }
        $prediksi[$key]['total'] = $prediksi[$key]['jumlah_shift'] - ($prediksi[$key]['dirumahkan_nonwfh'] + $prediksi[$key]['wfh'] + $prediksi[$key]['cuti'] + $prediksi[$key]['sakit'] + $prediksi[$key]['dinas_luar']);
        $data['PrediksiCatering'] = $prediksi;
      }
    } else {
      echo "Data Shift kosong";
    }

    $html = $this->load->view('CateringManagement/Pesanan/PrediksiCatering/V_Table.php', $data);
    echo json_encode($html);
  }

  public function export_pdf($exp)
  {
    $explode = explode('_', $exp);
    $tanggal = $explode[0];
    $lokasi = $explode[1];
    $shift = $explode[2];

    $data['PrediksiCatering'] = $prediksi = $this->M_prediksicatering->getPrediksiCatering($tanggal, $lokasi, $shift);

    if (!empty($prediksi)) {
      foreach ($prediksi as $key => $value) {
        $noind_array = $this->M_prediksicatering->getNoindByTempatMakanShiftTanggal($value['tempat_makan'], $shift, $tanggal);
        if (!empty($noind_array)) {
          foreach ($noind_array as $key2 => $value2) {
            $dinas_luar = $this->M_prediksicatering->getDinasLuarByNoind($value2['noind']);
            if (!empty($dinas_luar)) {
              foreach ($dinas_luar as $key3 => $value3) {
                $absen = $this->M_prediksicatering->getAbsenSetelahPulangByTimestampNoind($value3['tgl_pulang'], $value3['noind']);
                if (empty($absen)) {
                  $prediksi[$key]['dinas_luar'] += 1;
                }
              }
            }
          }
        }
        $prediksi[$key]['total'] = $prediksi[$key]['jumlah_shift'] - ($prediksi[$key]['dirumahkan_nonwfh'] + $prediksi[$key]['wfh'] + $prediksi[$key]['cuti'] + $prediksi[$key]['sakit'] + $prediksi[$key]['dinas_luar']);
        $data['PrediksiCatering'] = $prediksi;
      }
    } else {
      echo "Data Shift kosong";
    }


    if ($lokasi == '1') {
      $ketlokasi = "Pusat + Mlati";
    } elseif ($lokasi == '2') {
      $ketlokasi = "Tuksono";
    } else {
      $ketlokasi = 'Semua Lokasi';
    }

    if ($shift == '1') {
      $ketshift = "Shift 1 Umum Tanggung";
    } elseif ($shift == '2') {
      $ketshift = "Shift 2";
    } elseif ($shift == '3') {
      $ketshift = "Shift 3";
    } else {
      $ketshift = 'Semua Shift';
    }

    $data['Filter'] = [
      "tanggal" => $tanggal,
      "lokasi" => $ketlokasi,
      "shift" => $ketshift,
    ];;

    $this->load->library('pdf');

    $mpdf = $this->pdf->load();
    $mpdf = new mPDF('utf8', 'A4-L');
    $data = $this->load->view('CateringManagement/Pesanan/PrediksiCatering/V_Pdf.php', $data, true);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->setAutoBottomMargin = 'stretch';
    $mpdf->SetHTMLFooter("<table style=\"width: 100%\"><tr><td><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-CateringManagement oleh " . $this->session->user . " - " . $this->session->employee . " pada tgl. " . date('Y/M/d H:i:s') . "</i></td><td  rowspan=\"2\" style=\"vertical-align: middle; font-size: 8pt; text-align: right;\">Halaman {PAGENO} dari {nb}</td></tr></table>");
    $filename = 'Prediksi_Catering_' . $tanggal . '.pdf';
    $mpdf->WriteHTML($data, 2);
    $mpdf->setTitle($filename);
    $mpdf->Output($filename, 'I');
  }

  public function export_excel($exp)
  {
    $explode = explode('_', $exp);
    $tanggal = $explode[0];
    $lokasi = $explode[1];
    $shift = $explode[2];

    if ($lokasi == '1') {
      $ketlokasi = "Pusat + Mlati";
    } elseif ($lokasi == '2') {
      $ketlokasi = "Tuksono";
    } else {
      $ketlokasi = 'Semua Lokasi';
    }

    if ($shift == '1') {
      $ketshift = "Shift 1 Umum Tanggung";
    } elseif ($shift == '2') {
      $ketshift = "Shift 2";
    } elseif ($shift == '3') {
      $ketshift = "Shift 3";
    } else {
      $ketshift = 'Semua Shift';
    }

    $prediksi = $this->M_prediksicatering->getPrediksiCatering($tanggal, $lokasi, $shift);

    if (!empty($prediksi)) {
      foreach ($prediksi as $key => $value) {
        $noind_array = $this->M_prediksicatering->getNoindByTempatMakanShiftTanggal($value['tempat_makan'], $shift, $tanggal);
        if (!empty($noind_array)) {
          foreach ($noind_array as $key2 => $value2) {
            $dinas_luar = $this->M_prediksicatering->getDinasLuarByNoind($value2['noind']);
            if (!empty($dinas_luar)) {
              foreach ($dinas_luar as $key3 => $value3) {
                $absen = $this->M_prediksicatering->getAbsenSetelahPulangByTimestampNoind($value3['tgl_pulang'], $value3['noind']);
                if (empty($absen)) {
                  $prediksi[$key]['dinas_luar'] += 1;
                }
              }
            }
          }
        }
        $prediksi[$key]['total'] = $prediksi[$key]['jumlah_shift'] - ($prediksi[$key]['dirumahkan_nonwfh'] + $prediksi[$key]['wfh'] + $prediksi[$key]['cuti'] + $prediksi[$key]['sakit'] + $prediksi[$key]['dinas_luar']);
      }
    } else {
      echo "Data Shift kosong";
    }
    $this->load->library('excel');

    $worksheet = $this->excel->getActiveSheet();

    $worksheet->mergeCells('A1:C1');
    $worksheet->getCell('A1')
      ->setValue('Export Prediksi Catering')->getStyle("A1")->applyFromArray(array("font" => array("bold" => true)));

    $worksheet->getStyle("A5:J5")->applyFromArray(array("font" => array("bold" => true)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $worksheet->getStyle("A5:J5")->applyFromArray(array(
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

    $worksheet->mergeCells('A2:B2');
    $worksheet->getCell('A2')
      ->setValue('Tanggal');

    $worksheet->mergeCells('C2:D2');
    $worksheet->getCell('C2')
      ->setValue(': ' . $tanggal);

    $worksheet->mergeCells('A3:B3');
    $worksheet->getCell('A3')
      ->setValue('Lokasi');

    $worksheet->mergeCells('C3:D3');
    $worksheet->getCell('C3')
      ->setValue(': ' . $ketlokasi);

    $worksheet->mergeCells('A4:B4');
    $worksheet->getCell('A4')
      ->setValue('Shift');

    $worksheet->mergeCells('C4:D4');
    $worksheet->getCell('C4')
      ->setValue(': ' . $ketshift);

    $worksheet->setCellValue('A5', 'No');
    $worksheet->setCellValue('B5', 'Tempat Makan');
    $worksheet->setCellValue('C5', 'Tanggal');
    $worksheet->setCellValue('D5', 'Jumlah Shift');
    $worksheet->setCellValue('E5', 'Dirumahkan (NON WFH)');
    $worksheet->setCellValue('F5', 'Dirumahkan (WFH)');
    $worksheet->setCellValue('G5', 'Cuti');
    $worksheet->setCellValue('H5', 'Sakit');
    $worksheet->setCellValue('I5', 'Dinas Luar');
    $worksheet->setCellValue('J5', 'Total');

    $angka = 1;
    $row = 6;
    foreach ($prediksi as $key) {
      $worksheet->setCellValue('A' . $row, $angka);
      $worksheet->setCellValue('B' . $row, $key['tempat_makan']);
      $worksheet->setCellValue('C' . $row, $key['tanggal']);
      $worksheet->setCellValue('D' . $row, $key['jumlah_shift']);
      $worksheet->setCellValue('E' . $row, $key['dirumahkan_nonwfh']);
      $worksheet->setCellValue('F' . $row, $key['wfh']);
      $worksheet->setCellValue('G' . $row, $key['cuti']);
      $worksheet->setCellValue('H' . $row, $key['sakit']);
      $worksheet->setCellValue('I' . $row, $key['dinas_luar']);
      $worksheet->setCellValue('J' . $row, $key['total']);
      $worksheet->getStyle('A' . $row)->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $worksheet->getStyle('B' . $row)->applyFromArray($border);
      foreach (range('C', 'J') as $columnID) {
        $worksheet->getStyle($columnID . $row)
          ->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }
      $row++;
      $angka++;
      $worksheet->setCellValue('C' . $row, 'JUMLAH :');
      $worksheet->setCellValue('D' . $row, array_sum(array_column($prediksi, 'jumlah_shift')));
      $worksheet->setCellValue('E' . $row, array_sum(array_column($prediksi, 'dirumahkan_nonwfh')));
      $worksheet->setCellValue('F' . $row, array_sum(array_column($prediksi, 'wfh')));
      $worksheet->setCellValue('G' . $row, array_sum(array_column($prediksi, 'cuti')));
      $worksheet->setCellValue('H' . $row, array_sum(array_column($prediksi, 'sakit')));
      $worksheet->setCellValue('I' . $row, array_sum(array_column($prediksi, 'dinas_luar')));
      $worksheet->setCellValue('J' . $row, array_sum(array_column($prediksi, 'total')));
      foreach (range('C', 'J') as $columnID) {
        $worksheet->getStyle($columnID . $row)
          ->applyFromArray($border)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      }
    }

    $worksheet->getColumnDimension('A')->setWidth('5');
    $worksheet->getColumnDimension('B')->setWidth('25');
    foreach (range('C', 'J') as $columnID) {
      $worksheet->getColumnDimension($columnID)
        ->setWidth('15');
    }

    $filename = 'Prediksi_Catering_' . $tanggal . '.xls';
    header('Content-Type: aplication/vnd.ms-excel');
    header('Content-Disposition:attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    $writer->save('php://output');
  }
}
