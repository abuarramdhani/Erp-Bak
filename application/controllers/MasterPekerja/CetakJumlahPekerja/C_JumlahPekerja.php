<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class C_JumlahPekerja extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->helper('file');

    $this->load->library('Log_Activity');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->library('upload');
    $this->load->library('general');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/CetakJumlahPekerja/M_jumlahpekerja');


    $this->checkSession();
  }
  public function checkSession()
  {
    if ($this->session->is_logged) { } else {
      redirect('');
    }
  }


  public function jumlah_pekerja()
  {
    $user = $this->session->username;

    $user_id = $this->session->userid;
    $data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Jumlah Pekerja', 'Cetak', 'Cetak Jumlah Pekerja', '');

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/CetakJumlahPekerja/V_Index', $data);
    $this->load->view('V_Footer', $data);
  }

  public function Getrbtck()
  {

    $txt = $this->input->get('term');
    $txt = strtoupper($txt);
    $rbtckvalue = $this->input->get('rbtckvalue');


    $data = $this->M_jumlahpekerja->Getrbtck($txt, $rbtckvalue);
    echo json_encode($data);
  }

  public function GetJumlah()
  {
    $id = $this->input->post('id');
    $rbtfilterval = $this->input->post('rbtfilterval');

    if ($rbtfilterval == "lok") {
      $opt = "tp.lokasi_kerja";
    } else {
      $opt = "tp.kodesie";
    }

    $data['JumlahAll'] = $this->M_jumlahpekerja->GetJumlah($id, $opt);
    $data['export'] = $id . '_' . $opt;
    $html = $this->load->view('MasterPekerja/CetakJumlahPekerja/V_Table', $data);
    echo json_encode($html);
  }

  public function GetJumlahPend()
  {
    $id = $this->input->post('id');
    $rbtfilterval = $this->input->post('rbtfilterval');

    if ($rbtfilterval == "lok") {
      $opt = "tp.lokasi_kerja";
    } else {
      $opt = "tp.kodesie";
    }

    $data['JumlahAllPend'] = $this->M_jumlahpekerja->GetJumlahPend($id, $opt);
    $data['export'] = $id . '_' . $opt;
    $html = $this->load->view('MasterPekerja/CetakJumlahPekerja/V_Tablepend', $data);

    echo json_encode($html);
  }

  public function export_excel($data)
  {
    $do = explode("_", $data);
    $id = $do['0'];
    $opt = $do['1'];

    $res = $this->M_jumlahpekerja->GetJumlahPend($id, $opt);

    $this->load->library('excel');


    $worksheet = $this->excel->getActiveSheet();
    $worksheet->getStyle("A1:T1")->applyFromArray(array("font" => array("bold" => true)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $worksheet->getStyle("A2:T2")->applyFromArray(array("font" => array("bold" => true)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $worksheet->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $worksheet->mergeCells('A1:B1')->setCellValue('A2', 'No')->setCellValue('B2', 'Pendidikan');
    $worksheet->mergeCells('C1:D1')->setCellValue('C1', 'STAFF (B)')->setCellValue('C2', 'L')->setCellValue('D2', 'P');
    $worksheet->mergeCells('E1:F1')->setCellValue('E1', 'NON STAFF (A)')->setCellValue('E2', 'L')->setCellValue('F2', 'P');
    $worksheet->mergeCells('G1:H1')->setCellValue('G1', 'KONTRAK (H,J,T)')->setCellValue('G2', 'L')->setCellValue('H2', 'P');
    $worksheet->mergeCells('I1:J1')->setCellValue('I1', 'TRAINEE (D,E)')->setCellValue('I2', 'L')->setCellValue('J2', 'P');
    $worksheet->mergeCells('K1:L1')->setCellValue('K1', 'OUTSORC (K,P)')->setCellValue('K2', 'L')->setCellValue('L2', 'P');
    $worksheet->mergeCells('M1:N1')->setCellValue('M1', 'PKL (F)')->setCellValue('M2', 'L')->setCellValue('N2', 'P');
    $worksheet->mergeCells('O1:P1')->setCellValue('O1', 'MAGANG (Q)')->setCellValue('O2', 'L')->setCellValue('P2', 'P');
    $worksheet->mergeCells('Q1:R1')->setCellValue('Q1', 'TKPW (G)')->setCellValue('Q2', 'L')->setCellValue('R2', 'P');
    $worksheet->mergeCells('S1:T1')->setCellValue('S1', 'JUMLAH')->setCellValue('S2', 'L')->setCellValue('T2', 'P');

    foreach (range('C', 'R') as $columnID) {
      $worksheet->getColumnDimension($columnID)
        ->setWidth('10');
    }

    $angka = 1;
    $row = 3;
    foreach ($res as $key) {
      $worksheet->setCellValue('A' . $row, $angka);
      $worksheet->setCellValue('B' . $row, $key['pd']);
      $worksheet->setCellValue('C' . $row, $key['staffl']);
      $worksheet->setCellValue('D' . $row, $key['staffp']);
      $worksheet->setCellValue('E' . $row, $key['nonstaffl']);
      $worksheet->setCellValue('F' . $row, $key['nonstaffp']);
      $worksheet->setCellValue('G' . $row, $key['kontrakl']);
      $worksheet->setCellValue('H' . $row, $key['kontrakp']);
      $worksheet->setCellValue('I' . $row, $key['trainl']);
      $worksheet->setCellValue('J' . $row, $key['trainp']);
      $worksheet->setCellValue('K' . $row, $key['outsorcl']);
      $worksheet->setCellValue('L' . $row, $key['outsorcp']);
      $worksheet->setCellValue('M' . $row, $key['pkll']);
      $worksheet->setCellValue('N' . $row, $key['pklp']);
      $worksheet->setCellValue('O' . $row, $key['magangl']);
      $worksheet->setCellValue('P' . $row, $key['magangp']);
      $worksheet->setCellValue('Q' . $row, $key['tkpwl']);
      $worksheet->setCellValue('R' . $row, $key['tkpwp']);
      $worksheet->setCellValue('S' . $row, $key['jmll']);
      $worksheet->setCellValue('T' . $row, $key['jmlp']);
      $row++;
      $angka++;
      $worksheet->setCellValue('B' . $row, 'TOTAL :');
      $worksheet->setCellValue('C' . $row, array_sum(array_column($res, 'staffl')));
      $worksheet->setCellValue('D' . $row, array_sum(array_column($res, 'staffp')));
      $worksheet->setCellValue('E' . $row, array_sum(array_column($res, 'nonstaffl')));
      $worksheet->setCellValue('F' . $row, array_sum(array_column($res, 'nonstaffp')));
      $worksheet->setCellValue('G' . $row, array_sum(array_column($res, 'kontrakl')));
      $worksheet->setCellValue('H' . $row, array_sum(array_column($res, 'kontrakp')));
      $worksheet->setCellValue('I' . $row, array_sum(array_column($res, 'trainl')));
      $worksheet->setCellValue('J' . $row, array_sum(array_column($res, 'trainp')));
      $worksheet->setCellValue('K' . $row, array_sum(array_column($res, 'outsorcl')));
      $worksheet->setCellValue('L' . $row, array_sum(array_column($res, 'outsorcp')));
      $worksheet->setCellValue('M' . $row, array_sum(array_column($res, 'pkll')));
      $worksheet->setCellValue('N' . $row, array_sum(array_column($res, 'pklp')));
      $worksheet->setCellValue('O' . $row, array_sum(array_column($res, 'magangl')));
      $worksheet->setCellValue('P' . $row, array_sum(array_column($res, 'magangp')));
      $worksheet->setCellValue('Q' . $row, array_sum(array_column($res, 'tkpwl')));
      $worksheet->setCellValue('R' . $row, array_sum(array_column($res, 'tkpwp')));
      $worksheet->setCellValue('S' . $row, array_sum(array_column($res, 'jmll')));
      $worksheet->setCellValue('T' . $row, array_sum(array_column($res, 'jmlp')));
    }

    $worksheet->getColumnDimension('A')->setWidth('5');
    $worksheet->getColumnDimension('B')->setWidth('15');


    $filename = 'Jumlah_Pekerja' . $id . '.xls';
    header('Content-Type: aplication/vnd.ms-excel');
    header('Content-Disposition:attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    $writer->save('php://output');
  }

  public function excel_pendidikan($data)
  {
    $do = explode("_", $data);
    $id = $do['0'];
    $opt = $do['1'];

    $res = $this->M_jumlahpekerja->GetJumlah($id, $opt);
    $this->load->library('excel');

    $worksheet = $this->excel->getActiveSheet();
    $worksheet->getStyle("E1:I1")->applyFromArray(array("font" => array("bold" => true)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $worksheet->getStyle("A2:O2")->applyFromArray(array("font" => array("bold" => true)))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $worksheet->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $worksheet->setCellValue('A2', 'No')->setCellValue('B2', 'Dept')->setCellValue('C2', 'Unit')->setCellValue('D2', 'Seksi');
    $worksheet->mergeCells('E1:H1')->mergeCells('I1:M1')->setCellValue('E1', 'NON STAFF')->setCellValue('I1', 'STAFF');
    $worksheet->setCellValue('E2', 'Tetap (A)')->setCellValue('F2', 'Train (E)')->setCellValue('G2', 'PKL (F)')->setCellValue('H2', 'Kontrak (H,T)');
    $worksheet->setCellValue('I2', 'Tetap (B)')->setCellValue('J2', 'Train (D)')->setCellValue('K2', 'TKPW (G)')->setCellValue('L2', 'Magang (Q)')->setCellValue('M2', 'Kontrak (J)');
    $worksheet->setCellValue('N2', 'OS (K,P)')->setCellValue('O2', 'jml');

    foreach (range('E', 'O') as $columnID) {
      $worksheet->getColumnDimension($columnID)
        ->setAutoSize(true);
    }

    $angka = 1;
    $row = 3;
    foreach ($res as $key) {
      $worksheet->setCellValue('A' . $row, $angka);
      $worksheet->setCellValue('B' . $row, $key['d']);
      $worksheet->setCellValue('C' . $row, $key['u']);
      $worksheet->setCellValue('D' . $row, $key['s']);
      $worksheet->setCellValue('E' . $row, $key['tetap']);
      $worksheet->setCellValue('F' . $row, $key['train']);
      $worksheet->setCellValue('G' . $row, $key['pkl']);
      $worksheet->setCellValue('H' . $row, $key['kontrak']);
      $worksheet->setCellValue('I' . $row, $key['stetap']);
      $worksheet->setCellValue('J' . $row, $key['strain']);
      $worksheet->setCellValue('K' . $row, $key['stkpw']);
      $worksheet->setCellValue('L' . $row, $key['skp']);
      $worksheet->setCellValue('M' . $row, $key['skontrak']);
      $worksheet->setCellValue('N' . $row, $key['os']);
      $worksheet->setCellValue('O' . $row, $key['jml']);
      $row++;
      $angka++;
      $worksheet->setCellValue('D' . $row, 'TOTAL :');
      $worksheet->setCellValue('E' . $row, array_sum(array_column($res, 'tetap')));
      $worksheet->setCellValue('F' . $row, array_sum(array_column($res, 'train')));
      $worksheet->setCellValue('G' . $row, array_sum(array_column($res, 'pkl')));
      $worksheet->setCellValue('H' . $row, array_sum(array_column($res, 'kontrak')));
      $worksheet->setCellValue('I' . $row, array_sum(array_column($res, 'stetap')));
      $worksheet->setCellValue('J' . $row, array_sum(array_column($res, 'strain')));
      $worksheet->setCellValue('K' . $row, array_sum(array_column($res, 'stkpw')));
      $worksheet->setCellValue('L' . $row, array_sum(array_column($res, 'skp')));
      $worksheet->setCellValue('M' . $row, array_sum(array_column($res, 'skontrak')));
      $worksheet->setCellValue('N' . $row, array_sum(array_column($res, 'os')));
      $worksheet->setCellValue('O' . $row, array_sum(array_column($res, 'jml')));
    }

    $worksheet->getColumnDimension('A')->setWidth('5');
    $worksheet->getColumnDimension('B')->setWidth('20');
    $worksheet->getColumnDimension('C')->setWidth('50');
    $worksheet->getColumnDimension('D')->setWidth('50');

    $filename = 'Jumlah_Pekerja.xls';
    header('Content-Type: aplication/vnd.ms-excel');
    header('Content-Disposition:attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    $writer->save('php://output');
  }
}
