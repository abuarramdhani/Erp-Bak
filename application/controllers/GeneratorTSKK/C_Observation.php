<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Observation extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->library('Excel');
          //load the login model
        $this->load->library('session');
        $this->load->helper(array('url','download'));
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('GeneratorTSKK/M_gentskk');

        date_default_timezone_set('Asia/Jakarta');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }

	public function checkSession()
	{
		if($this->session->is_logged){
		}else{
			redirect();
		}
	}

// ------------------------------------------------- show the dashboard ----------------------------------------- //

public function DisplayLO()
{
    $this->checkSession();
    $user_id = $this->session->userid;

    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
 		$data['product'] = $this->M_gentskk->getTipeProduk('');
		$data['data_element_kerja_manual'] = $this->db->select('elemen_kerja')->where('jenis', 'MANUAL')->get('gtskk.gtskk_standar_elemen_kerja')->result_array();
		$data['data_element_kerja_auto'] = $this->db->select('elemen_kerja')->where('jenis', 'AUTO')->get('gtskk.gtskk_standar_elemen_kerja')->result_array();
		$data['proses'] = $this->M_gentskk->getProses();
    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('GeneratorTSKK/V_LembarObservasi');
    $this->load->view('V_Footer',$data);
}

public function AngkaToChar($sisa){
    if ($sisa == 1){
        $kolom = 'A';
      }elseif ($sisa == 2) {
        $kolom = 'B';
      }elseif ($sisa == 3) {
        $kolom = 'C';
      }elseif ($sisa == 4) {
        $kolom = 'D';
      }elseif ($sisa == 5) {
        $kolom = 'E';
      }elseif ($sisa == 6) {
        $kolom = 'F';
      }elseif ($sisa == 7) {
        $kolom = 'G';
      }elseif ($sisa == 8) {
        $kolom = 'H';
      }elseif ($sisa == 9) {
        $kolom = 'I';
      }elseif ($sisa == 10) {
        $kolom = 'J';
      }elseif ($sisa == 11) {
        $kolom = 'K';
      }elseif ($sisa == 12) {
        $kolom = 'L';
      }elseif ($sisa == 13) {
        $kolom = 'M';
      }elseif ($sisa == 14) {
        $kolom = 'N';
      }elseif ($sisa == 15) {
        $kolom = 'O';
      }elseif ($sisa == 16) {
        $kolom = 'P';
      }elseif ($sisa == 17) {
        $kolom = 'Q';
      }elseif ($sisa == 18) {
        $kolom = 'R';
      }elseif ($sisa == 19) {
        $kolom = 'S';
      }elseif ($sisa == 20) {
        $kolom = 'T';
      }elseif ($sisa == 21) {
        $kolom = 'U';
      }elseif ($sisa == 22) {
        $kolom = 'V';
      }elseif ($sisa == 23) {
        $kolom = 'W';
      }elseif ($sisa == 24) {
        $kolom = 'X';
      }elseif ($sisa == 25) {
        $kolom = 'Y';
      }elseif ($sisa == 26) {
        $kolom = 'Z';
      } else {
          $kolom = NULL;
      }
      return $kolom;
}

public function Kolom($jumlah){
    //KONVERSI ANGKA KE NAMA KOLOM
    $digitpertama = NULL;
    $digitkedua = NULL;
    $digitketiga = NULL;
    $jumlahdigit2 = NULL;
    $huruf1 = NULL;
    $huruf2 = NULL;
    $huruf3 = NULL;
    $jumlahdigit = floor($jumlah / 26);
    $digitketiga = $jumlah % 26;
    if($jumlahdigit > 26 && $jumlah != 702){ //3 DIGIT
       $jumlahdigit2 = $jumlahdigit / 26;
        if ($digitketiga != 0){
            $digitkedua = $jumlahdigit % 26;
            $digitpertama = floor($jumlahdigit2);
        } else {
            $digitkedua = ($jumlahdigit % 26)-1;
            if(floor($jumlahdigit2) == 1){
                $digitpertama = floor($jumlahdigit2);
            } else {
                $digitpertama = floor($jumlahdigit2)-1;
            }
            $digitketiga = 26;
        }
        if($digitkedua == 0){
            $digitkedua = 26;
        }
        $huruf1 = $this->AngkaToChar($digitpertama);
        $huruf2 = $this->AngkaToChar($digitkedua);
        $huruf3 = $this->AngkaToChar($digitketiga);
        return $huruf1.$huruf2.$huruf3;
    } else { //2 DIGIT
        if($digitketiga != 0){
            if ($jumlahdigit != 0){
                $digitpertama = $jumlahdigit;
            } else {
                $digitpertama = NULL;
            }
            $digitkedua = $digitketiga;
        } else {
            $digitpertama = $jumlahdigit-1;
            $digitkedua = 26;
            $digitketiga = 26;
        }
        if($digitkedua == 0){
            $digitkedua = 26;
        }
        $huruf1 = $this->AngkaToChar($digitpertama);
        $huruf2 = $this->AngkaToChar($digitkedua);
        return $huruf1.$huruf2;
    }
}

public function exportObservation($id){

  $this->load->library(array('Excel','Excel/PHPExcel/IOFactory'));
  $newID = $this->M_gentskk->getAllObservation($id);
  // echo "<pre>";print_r($newID);
  //    exit();

  //creator
  $noind = $this->session->user;
  // echo"<pre>";echo $noind;
  $name = $this->M_gentskk->selectNamaPekerja($noind);
  $nama_pekerja = $name[0]['nama'];
  $sang_pembuat = $noind." - ".$nama_pekerja;
  // echo $sang_pembuat;die;

   //HEADER//
   $judul             = $newID[0]['judul_tskk'];
   $seksi 	          = $newID[0]['seksi'];
   $line              = $newID[0]['line_process'];
   $nama_part         = $newID[0]['nama_part'];
   $kode_part         = $newID[0]['kode_part'];
   //kepala seksi
   //dibuat oleh
   $proses	          = $newID[0]['proses'];
   $tanggal           = $newID[0]['tanggal'];
   $operator 	        = $newID[0]['operator'];

   //TABLE//
   $waktu_1           = array_column($newID, 'waktu_1');
   $waktu_2           = array_column($newID, 'waktu_2');
   $waktu_3           = array_column($newID, 'waktu_3');
   $waktu_4           = array_column($newID, 'waktu_4');
   $waktu_5           = array_column($newID, 'waktu_5');
   $waktu_6           = array_column($newID, 'waktu_6');
   $waktu_7           = array_column($newID, 'waktu_7');
   $waktu_8           = array_column($newID, 'waktu_8');
   $waktu_9           = array_column($newID, 'waktu_9');
   $waktu_10          = array_column($newID, 'waktu_10');
   $x_min             = array_column($newID, 'x_min');
   $range             = array_column($newID, 'r');
   $waktu_distribusi  = array_column($newID, 'waktu_distribusi');
   $waktu_kerja       = array_column($newID, 'waktu_kerja');
   $keterangan        = array_column($newID, 'keterangan');
   $takt_time         = array_column($newID, 'takt_time');
   $jenis_proses 	    = array_column($newID, 'jenis_proses');
   $elemen            = array_column($newID, 'elemen');
   $keterangan_elemen = array_column($newID, 'keterangan_elemen');
   $tipe_urutan 	    = array_column($newID, 'tipe_urutan');

//Make "elemen kerja" from combining "elemen & keterangan"//
  $elemen_kerja =  array();
  for ($i=0; $i < count($elemen) ; $i++) {
      $elemen_kerja[$i] = $elemen[$i]." ".$keterangan_elemen[$i];
  }

//COUNT THE TOTAL TIMES : // old version
   $indexArr      = 0;
   $jumlah        = 0;
   $jumlah_1      = 0;
   $jumlah_2      = 0;
   $jumlah_3      = 0;
   $jumlah_4      = 0;
   $jumlah_5      = 0;
   $jumlah_6      = 0;
   $jumlah_7      = 0;
   $jumlah_8      = 0;
   $jumlah_9      = 0;
   $jumlah_10     = 0;
   $jumlah_Xmin   = 0;
   $jumlah_R      = 0;
   $jumlah_wKerja = 0;
   $jml_baris     = 1;
   $elemenWaktu   = $elemen_kerja[0];

   for($i=0; $i < count($elemen); $i++){

      $jumlah_1      = array_sum($waktu_1);
      $jumlah_2      = array_sum($waktu_2);
      $jumlah_3      = array_sum($waktu_3);
      $jumlah_4      = array_sum($waktu_4);
      $jumlah_5      = array_sum($waktu_5);
      $jumlah_6      = array_sum($waktu_6);
      $jumlah_7      = array_sum($waktu_7);
      $jumlah_8      = array_sum($waktu_8);
      $jumlah_9      = array_sum($waktu_9);
      $jumlah_10     = array_sum($waktu_10);
      $jumlah_Xmin   = array_sum($x_min);
      $jumlah_R      = array_sum($range);
      $jumlah_wKerja = array_sum($waktu_kerja);

  }

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("ICT_Production")->setTitle("ICT");

$objset = $objPHPExcel->setActiveSheetIndex(0);
$objget = $objPHPExcel->getActiveSheet();
$objget->setTitle("Lembar Observasi Elemen Kerja");

// ------- SET COLUMN --------- //
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5.38);
for ($i='F'; $i <= 'Y'; $i++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setWidth(5.07);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(9.6);

// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

// MERGING TO SET THE PAGE HEADER//
$objPHPExcel->getActiveSheet()->mergeCells('B1:C6');//LOGO QUICK
// $objPHPExcel->getActiveSheet()->mergeCells('B1:C1');//JUDUL ISIAN
// $objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
// $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
// $objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
// $objPHPExcel->getActiveSheet()->mergeCells('B5:C5');

$objPHPExcel->getActiveSheet()->mergeCells('E1:H1'); //ISIANNYA
$objPHPExcel->getActiveSheet()->mergeCells('E2:H2');
$objPHPExcel->getActiveSheet()->mergeCells('E3:H3');
$objPHPExcel->getActiveSheet()->mergeCells('E4:H4');
$objPHPExcel->getActiveSheet()->mergeCells('E5:H5');
$objPHPExcel->getActiveSheet()->mergeCells('E6:H6');

$objPHPExcel->getActiveSheet()->mergeCells('I1:O6'); //JUDUL LEMBAR OBSERVASI ELEMEN KERJA
$objPHPExcel->getActiveSheet()->mergeCells('P1:Q1'); //DIBUAT
$objPHPExcel->getActiveSheet()->mergeCells('P2:Q5'); //DIBUAT BLANK
$objPHPExcel->getActiveSheet()->mergeCells('P6:Q6'); //DIBUAT TTD
$objPHPExcel->getActiveSheet()->mergeCells('R1:S1'); //Diperiksa
$objPHPExcel->getActiveSheet()->mergeCells('R2:S5'); //Diperiksa BLANK
$objPHPExcel->getActiveSheet()->mergeCells('R6:S6'); //Diperiksa TTD
$objPHPExcel->getActiveSheet()->mergeCells('T1:U1'); //Disetujui
$objPHPExcel->getActiveSheet()->mergeCells('T2:U5'); //Disetujui BLANK
$objPHPExcel->getActiveSheet()->mergeCells('T6:U6'); //Disetujui TTD
$objPHPExcel->getActiveSheet()->mergeCells('V1:W1'); //Diketahui
$objPHPExcel->getActiveSheet()->mergeCells('V2:W5'); //Diketahui BLANK
$objPHPExcel->getActiveSheet()->mergeCells('V6:W6'); //Diketahui TTD

$objPHPExcel->getActiveSheet()->mergeCells('X1:Y2'); //No. Dok.
$objPHPExcel->getActiveSheet()->mergeCells('Z1:AA2'); //isi No. Dok.

$objPHPExcel->getActiveSheet()->mergeCells('X3:Y3'); //No. Rev.
$objPHPExcel->getActiveSheet()->mergeCells('Z3:AA3'); //isi No. Rev.

$objPHPExcel->getActiveSheet()->mergeCells('X4:Y5'); //TGL. Rev.
$objPHPExcel->getActiveSheet()->mergeCells('Z4:AA5'); //isi TGL. Rev.

$objPHPExcel->getActiveSheet()->mergeCells('X6:Y6'); //hal.
$objPHPExcel->getActiveSheet()->mergeCells('Z6:AA6'); //ISI Hal..

$objPHPExcel->getActiveSheet()->mergeCells('B7:B9'); //NO.
$objPHPExcel->getActiveSheet()->mergeCells('C7:E9'); //Elemen Kerja.
$objPHPExcel->getActiveSheet()->mergeCells('F7:Y7'); //Waktu Pengukuran (detik)
//bawah waktu Pengukuran
$ii_ = 1;
for ($i='F'; $i <= 'Y'; $i++) {
	if ($ii_%2 != 0) {
		$objPHPExcel->getActiveSheet()->mergeCells($i.'8:'.(chr(ord($i)+1)).'8');
	}
	$ii_++;
}

$objPHPExcel->getActiveSheet()->mergeCells('Z7:AA9'); //Catatan

// //ADD IMAGE QUICK FOR HEADER//

$gdImage = imagecreatefrompng('assets/img/logo.png');
// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setName('Logo QUICK');$objDrawing->setDescription('Logo QUICK');
$objDrawing->setImageResource($gdImage);
$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
$objDrawing->setCoordinates('B1');
//set width, height
$objDrawing->setWidth(60);
$objDrawing->setHeight(85);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//SET CELL VALUE FOR THE HEADER
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('D1', 'Seksi')
        ->setCellValue('D2', 'Line/Area/Pos')
        ->setCellValue('D3', 'Nama Komponen')
        ->setCellValue('D4', 'Kode Komponen')
				->setCellValue('D5', 'Proses')
				->setCellValue('D6', 'Nama Operator')

        ->setCellValue('E1', ': '.$seksi)
        ->setCellValue('E2', ': '.$line)
        ->setCellValue('E3', ': '.$nama_part)
        ->setCellValue('E4', ': '.$kode_part)
				->setCellValue('E5', ': '.$proses)
				->setCellValue('E6', ': '.$operator)

        ->setCellValue('I1', 'LEMBAR OBSERVASI RINCIAN DAN URUTAN ELEMEN KERJA')

        ->setCellValue('P1', 'Dibuat:')
        ->setCellValue('R1', 'Diperiksa:')
        ->setCellValue('T1', 'Disetujui')
        ->setCellValue('V1', 'Diketahui')

				->setCellValue('X1', 'No. Dok.')
				->setCellValue('X3', 'No. Rev.')
				->setCellValue('X4', 'Tgl. Rev.')
				->setCellValue('X6', 'Hal.')

        ->setCellValue('B7', 'NO')
        ->setCellValue('C7', 'Elemen Kerja')
				->setCellValue('F7', 'Waktu Pengukuran (detik)')
				->setCellValue('Z7', 'Catatan')


        ->setCellValue('U7', 'X min')
        ->setCellValue('V7', 'R')
        ->setCellValue('W7', 'Waktu Kerja')
        ->setCellValue('X7', 'Keterangan')
        ;

	$ii = 1;
	$ke = 1;
	for ($i='F'; $i <= 'Y'; $i++) {
		if ($ii%2 != 0) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($i.'8', $ke)
																					->setCellValue($i.'9', 'Kon.');
			$ke++;
		}else {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($i.'9', 'Sat.');
		}
		$ii++;
	}
//STYLING HEADER//

//GARIS DI GAMBAR
$objget->getStyle('B1:C6')->applyFromArray(
  array(
          'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      )
  );

// $objget->getStyle('B5:D5')->applyFromArray(
//   array(
//           'borders' => array(
//           'outline' => array(
//           'style' => PHPExcel_Style_Border::BORDER_THIN
//               )
//           )
//       )
//   );

  $objget->getStyle('D1:H6')->applyFromArray(
    array(
            'font' => array(
              'color' => array('000000'),
              'bold' => true,
            ),
						'borders' => array(
						'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
								)
						)
        )
    );

$objget->getStyle('I1:O6')->getAlignment()->setWrapText(true);
$objget->getStyle('I1:O6')->applyFromArray(
  array(
          'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          ),
          'font' => array(
            'color' => array('000000'),
            'bold' => true,
          ),
            'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          ),
      )
  );

	$objget->getStyle('P1:W6')->applyFromArray(
	  array(
	          'borders' => array(
	          'allborders' => array(
	          'style' => PHPExcel_Style_Border::BORDER_THIN
	              )
	          ),
	          'font' => array(
	            'color' => array('000000'),
	            'bold' => true,
	          ),
						'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						),
	      )
	  );

		$objget->getStyle('X1:AA6')->applyFromArray(
			array(
							'font' => array(
								'color' => array('000000'),
								'bold' => true,
							),
							'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							),
							'borders' => array(
		          'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
		              )
		          ),
					)
			);

			$objget->getStyle('B7:AA9')->applyFromArray(
				array(
								'font' => array(
									'color' => array('000000'),
									'bold' => true,
								),
								'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								),
								'borders' => array(
								'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
										)
								),
						)
				);

//SET FONT SIZE
$objPHPExcel->getActiveSheet()->getStyle("I1:O6")->getFont()->setSize(18);

//WRAP TEXT ON WAKTU KERJA COLUMN
  $objget->getStyle('W6:W7')->getAlignment()->setWrapText(true);

//SET THE TABLE VALUES//
$baris  = 10;
$no = 1;

if (sizeof($newID) < 45) {
	for ($i=0; $i < (45 - sizeof($newID)); $i++) {
		$isi_kosong[] = [
			'elemen' => ''
			,'waktu_1' => ''
			,'waktu_2' => ''
			,'waktu_3' => ''
			,'waktu_4' => ''
			,'waktu_5' => ''
			,'waktu_6' => ''
			,'waktu_7' => ''
			,'waktu_8' => ''
			,'waktu_9' => ''
			,'waktu_10' => ''
			,'keterangan' => ''
			,'keterangan_elemen' => ''
		];
	}
	foreach ($isi_kosong as $key => $value) {
		$newID[] = $value;
	}
}

foreach ($newID as $isi) {

  $objset->setCellValue("B".$baris, $no);
  $objPHPExcel->getActiveSheet()->mergeCells('C'.$baris.':E'.$baris);
  $objset->setCellValue("C".$baris, $isi['elemen']." ".$isi['keterangan_elemen']);
  // $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':K'.$baris);
  $objget->getStyle('C'.$baris.':E'.$baris)->getAlignment()->setWrapText(true);
  $objset->setCellValue("G".$baris, $isi['waktu_1']);
  $objset->setCellValue("I".$baris, $isi['waktu_2']);
  $objset->setCellValue("K".$baris, $isi['waktu_3']);
  $objset->setCellValue("M".$baris, $isi['waktu_4']);
  $objset->setCellValue("O".$baris, $isi['waktu_5']);
  $objset->setCellValue("Q".$baris, $isi['waktu_6']);
  $objset->setCellValue("S".$baris, $isi['waktu_7']);
  $objset->setCellValue("U".$baris, $isi['waktu_8']);
  $objset->setCellValue("W".$baris, $isi['waktu_9']);
  $objset->setCellValue("Y".$baris, $isi['waktu_10']);
  // $objset->setCellValue("U".$baris, $isi['x_min']);
  // $objset->setCellValue("V".$baris, $isi['r']);
  // $objset->setCellValue("W".$baris, $isi['waktu_kerja']);
  $objPHPExcel->getActiveSheet()->mergeCells('Z'.$baris.':AA'.$baris);
  $objset->setCellValue("Z".$baris, $isi['keterangan']);

  $objget->getStyle('B'.$baris.':AA'.$baris)->applyFromArray(
    array(
            'borders' => array(
            'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    );

  $objget->getStyle('F'.$baris.':Y'.$baris)->applyFromArray(
    array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      )
        )
    );

  $no++;
  $baris++;
}

  //SET TOTAL TIMES//
  $indexJml = $baris;
	$objset->setCellValue("B".$indexJml, "1 Cycle Time (satuan Detik)");
	$objPHPExcel->getActiveSheet()->mergeCells('B'.$indexJml.':E'.($indexJml + 1));
	$objPHPExcel->getActiveSheet()->mergeCells('Z'.$indexJml.':AA'.($indexJml + 1));
	$aa_ = 1;
	for ($i='F'; $i <= 'Y'; $i++) {
		if ($aa_%2 != 0) {
			$objset->setCellValue($i.$indexJml, '=SUM('.(chr(ord($i)+1)).'10:'.(chr(ord($i)+1)).($indexJml-1).')');
			$objPHPExcel->getActiveSheet()->mergeCells($i.$indexJml.':'.(chr(ord($i)+1)).($indexJml+1));
		}
		$aa_++;
	}

	// set font
	for ($i='F'; $i <= 'Y'; $i++) {
		$objPHPExcel->getActiveSheet()->getStyle("D1:E6")->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle("P1:X6")->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle("B7:X".$indexJml+2)->getFont()->setSize(10);
	}


    //STYLING OF TOTAL TIMES//
    $objget->getStyle('B'.$indexJml.':AA'.($indexJml + 1))->applyFromArray(
      array(
							'font' => array(
								'color' => array('000000'),
								'bold' => true,
							),
              'borders' => array(
              'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              ),
              'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
              )
          )
      );
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_WorkSheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.20);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.20);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.20);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.20);

$objPHPExcel->getActiveSheet()->setTitle('Lembar Observasi');
$objPHPExcel->setActiveSheetIndex(0);
$filename = urlencode("Lembar Observasi_".$judul."_".$tanggal.".xlsx"); //FILE NAME//
$filename = str_replace("+", " ", $filename);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

redirect("GeneratorTSKK/ViewEdit");

}

}

?>
