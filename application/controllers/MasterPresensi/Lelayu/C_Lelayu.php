<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class C_Lelayu extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');
    $this->load->library('General');
    $this->load->library('Log_Activity');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPresensi/Lelayu/M_lelayu');

    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('index');
    }
  }

  public function index()
  {
    $user = $this->session->username;
    $user_id = $this->session->userid;
    $today = date('d M Y');
    //$bulancutoff = date('Y-m-19');
    $bulancutoff = $this->M_lelayu->getCutoffBulanIni();
    //$bulanlalu = date('Y-m-d', strtotime($bulancutoff. ' -1 month'));
    $bulanlalu = $this->M_lelayu->getCutoffBulanLalu();
    $tanggalcutoff = date('d');

    $data['Title'] = 'Tambah Data Lelayu';
    $data['Menu'] = 'Master Presensi';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['pekerja'] = $this->M_lelayu->getPekerja();
    $data['today'] = $today;
    $data['data'] = $this->M_lelayu->getData()->result_array();
    $data['spsi'] = $this->M_lelayu->getSPSI($bulancutoff, $tanggalcutoff, $bulanlalu);
    $data['nominal'] = $this->M_lelayu->getNominal();
    $data['spsi1'] = $this->M_lelayu->getSPSI1($bulancutoff, $tanggalcutoff, $bulanlalu);
    $data['nominal1'] = $this->M_lelayu->getNominal1();
    $data['spsi2'] = $this->M_lelayu->getSPSI2($bulancutoff, $tanggalcutoff, $bulanlalu);
    $data['nominal2'] = $this->M_lelayu->getNominal2();
    $data['spsi3'] = $this->M_lelayu->getSPSI3($bulancutoff, $tanggalcutoff, $bulanlalu);
    $data['nominal3'] = $this->M_lelayu->getNominal3();
    $data['pekerjaResign'] = $this->M_lelayu->getPekerjaMengajukanResign($bulancutoff);

    $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/Lelayu/V_tambahData');
		$this->load->view('V_Footer',$data);
  }

  public function save()
  {
    $pekerja = $_POST['nama_lelayu'];
    $waktu  = $_POST['tanggal_lelayu'];
    $ket  = $_POST['keterangan_Lelayu'];
    $kafan = $_POST['nomKafan'];
    $duka = $_POST['nomDuka'];
    $askanit = $_POST['askanit'].$_POST['nomAskanit'];
    $totAska = $_POST['totalAskanit'];
    $madya  = $_POST['madya'].$_POST['nomMadya'];
    $totMad = $_POST['totMadya'];
    $super  = $_POST['supervisor'].$_POST['nomSuper'];
    $totSup = $_POST['totSuper'];
    $staff  = $_POST['nonStaff'].$_POST['nomNon'];
    $totNon = $_POST['totNon'];

    $array = array(
      'noind' => $pekerja,
      'tgl_lelayu' => $waktu,
      'keterangan' => $ket,
      'kain_kafan_perusahaan' => $kafan,
      'uang_duka_perusahaan' => $duka,
      'spsi_askanit_ket' => $askanit,
      'spsi_askanit_nominal' => $totAska,
      'spsi_kasie_ket	' => $madya,
      'spsi_kasie_nominal' => $totMad,
      'spsi_spv_ket' => $super,
      'spsi_spv_nominal' => $totSup,
      'spsi_nonmanajerial_ket' => $staff,
      'spsi_nonmanajerial_nominal' => $totNon
    );
    $this->M_lelayu->insertAll($array);

    $bulancutoff = $this->M_lelayu->getCutoffBulanIni();
    $tanggalcutoff = date('d');
    $bulanlalu = $this->M_lelayu->getCutoffBulanLalu();

    $id = $this->M_lelayu->getID();
    $noindAll = $this->M_lelayu->getNoindAll($bulancutoff, $tanggalcutoff, $bulanlalu);
    $noindAll1 = $this->M_lelayu->getNoindAll1($bulancutoff, $tanggalcutoff, $bulanlalu);
    $noindAll2 = $this->M_lelayu->getNoindAll2($bulancutoff, $tanggalcutoff, $bulanlalu);
    $noindAll3 = $this->M_lelayu->getNoindAll3($bulancutoff, $tanggalcutoff, $bulanlalu);
    $nominal = $this->M_lelayu->getNominal();
    $nominal1 = $this->M_lelayu->getNominal1();
    $nominal2 = $this->M_lelayu->getNominal2();
    $nominal3 = $this->M_lelayu->getNominal3();

    $arrayData = array();
    $arrayData[0] = array(
      'lelayu_id' => $id,
      'noind' => $noindAll,
      'nominal' => $nominal,
    );
    $arrayData[1]  = array(
      'lelayu_id' => $id,
      'noind' => $noindAll1,
      'nominal' => $nominal1,
    );
    $arrayData[2]  = array(
      'lelayu_id' => $id,
      'noind' => $noindAll2,
      'nominal' => $nominal2,
    );
    $arrayData[3]  = array(
      'lelayu_id' => $id,
      'noind' => $noindAll3,
      'nominal' => $nominal3,
    );

    foreach ($arrayData as $key) {
      foreach ($key['noind'] as $val) {
        $value = array(
          'lelayu_id' => $key['lelayu_id'],
          'noind' => $val['noind'],
          'nominal' => $key['nominal'],
        );
        $this->M_lelayu->insertID($value);
      }
    }
    $id_lelayu = $this->M_lelayu->getID();
    $aksi = 'Lelayu';
    $detail = 'Menambah Data Lelayu dengan id_lelayu '.$id_lelayu;

    $this->log_activity->activity_log($aksi, $detail);
  }

  public function RekapLelayu()
  {
    $data  = $this->general->loadHeaderandSidemenu('Master Presensi', 'Rekap Lelayu', 'Lelayu / Uang Duka', 'Rekap Data', '');
    $data['namaPekerja'] = $this->M_lelayu->getPekerja();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('MasterPresensi/Lelayu/Rekap/V_Rekap_Data');
    $this->load->view('V_Footer',$data);
  }

  public function getRekap()
  {
    $awal = $this->input->post('awal');
    $akhir = $this->input->post('akhir');

    $data['list'] = $this->M_lelayu->getRekapData($awal, $akhir);
    $data['awal'] = date('d-M-Y', strtotime($awal));
    $data['akhir'] = date('d-M-Y', strtotime($akhir));
    $html = $this->load->view('MasterPresensi/Lelayu/Rekap/V_Rekap_Table', $data);
    echo json_encode($html);
  }

  public function getRekapAngelVer()
  {
    $awal = $this->input->post('awal');
    $akhir = $this->input->post('akhir');

    $IdLelayu = $this->M_lelayu->getIdLelayuRange($awal, $akhir);
    if (empty($IdLelayu)) {
      $data['sukses'] = 0;
      $data['list'] = array();
      $html = $this->load->view('MasterPresensi/Lelayu/Rekap/V_Rekap_Table_2', $data);
      return json_encode($html);

    }else{
      $data['sukses'] = 1;
    }

    $data['AA'] = $this->M_lelayu->getRekapDataVer2($IdLelayu, 'AC');
    $data['AB'] = $this->M_lelayu->getRekapDataVer2($IdLelayu, 'AB');
    $data['AC'] = $this->M_lelayu->getRekapDataVer2($IdLelayu, 'AC');

    $data['awal'] = date('d-M-Y', strtotime($awal));
    $data['akhir'] = date('d-M-Y', strtotime($akhir));
    $html = $this->load->view('MasterPresensi/Lelayu/Rekap/V_Rekap_Table_2', $data);
    echo json_encode($html);
  }

  public function RekapLelayuExcel()
  {
    $awal = $this->input->get('awal');
    $akhir = $this->input->get('akhir');
    $tertanda = $this->input->get('ttd');

    $namaTTD = $this->M_lelayu->getPkjPribadi($tertanda)->row()->nama;

    if (empty($awal) || empty($akhir))
      die('Error !! Harap Hubungi ICT atau Admin terkait');
    

    $IdLelayu = $this->M_lelayu->getIdLelayuRange($awal, $akhir);
    if(empty($IdLelayu))
      die('Data Lelayu pada periode tersebut Kosong!!');

    $AA = $this->M_lelayu->getRekapDataVer2($IdLelayu, 'AA');
    $AB = $this->M_lelayu->getRekapDataVer2($IdLelayu, 'AB');
    $AC = $this->M_lelayu->getRekapDataVer2($IdLelayu, 'AC');

    $arr[0] = $AA[0];
    $arr[1] = $AB[0];
    $arr[2] = $AC[0];

    $this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator('KHS ERP')
    ->setTitle("Rekap Potongan Duka")
    ->setSubject("Rekap Potongan Duka")
    ->setDescription("Rekap Potongan Duka")
    ->setKeywords("Rekap Potongan Duka");

    $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
          );
    $style_col1 = array(
          'font' => array('bold' => false), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
          );
    $style_col2 = array(
          'font' => array('bold' => false, 'underline' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
          );

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "POTONGAN DUKA")->getStyle('A1')->getFont()->setBold(TRUE);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "PERIODE : ".$awal.' sd '. $akhir)->getStyle('A2')->getFont()->setBold(TRUE);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:A5')->setCellValue('A4', "No")->getStyle('A4:A5')->applyFromArray($style_col);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:B5')->setCellValue('B4', "Lokasi")->getStyle('B4:B5')->applyFromArray($style_col);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:C5')->setCellValue('C4', "Branch")->getStyle('C4:C5')->applyFromArray($style_col);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D4:E4')->setCellValue('D4', "Total Potongan Duka")->getStyle('D4:E4')->applyFromArray($style_col);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', "Staf")->getStyle('D5')->applyFromArray($style_col);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5', "Non Staf")->getStyle('E5')->applyFromArray($style_col);

    $x = 6;
    $no = 1;
    $stafTotal = 0;
    $nonStafTotal = 0;
    foreach ($arr as $key) {
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$x, $no)->getStyle('A'.$x)->applyFromArray($style_col1);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$x, $key['lokasi'])->getStyle('B'.$x)->applyFromArray($style_col1);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$x, $key['branch'])->getStyle('C'.$x)->applyFromArray($style_col1);
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$x, $key['staff'])->getStyle('D'.$x)->applyFromArray($style_col1)->getNumberFormat()->setFormatCode('#,#0.##;[Red]-#,#0.##');
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$x, $key['non_staff'])->getStyle('E'.$x)->applyFromArray($style_col1)->getNumberFormat()->setFormatCode('#,#0.##;[Red]-#,#0.##');

      $stafTotal += $key['staff'];
      $nonStafTotal += $key['non_staff'];
      $x++;
      $no++;
    }
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$x)->applyFromArray($style_col1);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$x, 'Total')->getStyle('B'.$x)->applyFromArray($style_col);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$x)->applyFromArray($style_col1);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$x, $stafTotal)->getStyle('D'.$x)->applyFromArray($style_col)->getNumberFormat()->setFormatCode('#,#0.##;[Red]-#,#0.##');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$x, $nonStafTotal)->getStyle('E'.$x)->applyFromArray($style_col)->getNumberFormat()->setFormatCode('#,#0.##;[Red]-#,#0.##');

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($x+2), 'Yogyakarta, ___________')->getStyle('B'.$x)->applyFromArray($style_col1);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($x+6), ucwords(rtrim(strtolower($namaTTD))))->getStyle('B'.$x)->applyFromArray($style_col2);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($x+7), 'Hubker')->getStyle('B'.$x)->applyFromArray($style_col2);

    $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

    $objPHPExcel->getActiveSheet()->setTitle('DAFTAR KEBUTUHAN P2K3');

    $objPHPExcel->setActiveSheetIndex(0);  
    $filename = urlencode("Rekap Potongan Duka.xlsx");

              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache

              $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');                
              $objWriter->save('php://output');
  }
}

 ?>
