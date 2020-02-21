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
      //  echo "<pre>";print_r($newID);
      //  exit();

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

  //  echo "<pre>";print_r($waktu_1);
  //  echo "<pre>";print_r($waktu_2);
  //  echo "<pre>";print_r($waktu_3);
  //  echo "<pre>";print_r($waktu_4);
  //  echo "<pre>";print_r($waktu_5);
  //  echo "<pre>";print_r($waktu_6);
  //  echo "<pre>";print_r($waktu_7);
  //  echo "<pre>";print_r($waktu_8);
  //  echo "<pre>";print_r($waktu_9);
  //  echo "<pre>";print_r($waktu_10);
  //  echo "<pre>";print_r($x_min);
  //  echo "<pre>";print_r($range);
  //  echo "<pre>";print_r($waktu_distribusi);
  //  echo "<pre>";print_r($waktu_kerja);
  //  echo "<pre>";print_r($keterangan);
  //  echo "<pre>";print_r($takt_time);
  //  echo "<pre>";print_r($jenis_proses);
  //  echo "<pre>";print_r($elemen);
  //  echo "<pre>";print_r($keterangan_elemen);
  //  echo "<pre>";print_r($tipe_urutan);
  //  exit();

//Make "elemen kerja" from combining "elemen & keterangan"//
  $elemen_kerja =  array();
  for ($i=0; $i < count($elemen) ; $i++) { 
      $elemen_kerja[$i] = $elemen[$i]." ".$keterangan_elemen[$i];
  }
  
//COUNT THE TOTAL TIMES :
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
       
      // echo "<pre>"; echo "JUMLAH WAKTU 1: ";echo $jumlah_1;
      // echo "<pre>"; echo "JUMLAH WAKTU 2: ";echo $jumlah_2;
      // echo "<pre>"; echo "JUMLAH WAKTU 3: ";echo $jumlah_3;
      // echo "<pre>"; echo "JUMLAH WAKTU 4: ";echo $jumlah_4;
      // echo "<pre>"; echo "JUMLAH WAKTU 5: ";echo $jumlah_5;
      // echo "<pre>"; echo "JUMLAH WAKTU 6: ";echo $jumlah_6;
      // echo "<pre>"; echo "JUMLAH WAKTU 7: ";echo $jumlah_7;
      // echo "<pre>"; echo "JUMLAH WAKTU 8: ";echo $jumlah_8;
      // echo "<pre>"; echo "JUMLAH WAKTU 9: ";echo $jumlah_9;
      // echo "<pre>"; echo "JUMLAH WAKTU 10: ";echo $jumlah_10;
      // echo "<pre>"; echo "XMIN: ";echo $jumlah_Xmin;
      // echo "<pre>"; echo "RANGE: ";echo $jumlah_R;
      // echo "<pre>"; echo "WAKTU KERJA: ";echo $jumlah_wKerja;
      // exit();
  }
  
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("ICT_Production")->setTitle("ICT");

$objset = $objPHPExcel->setActiveSheetIndex(0);
$objget = $objPHPExcel->getActiveSheet();
$objget->setTitle("Lembar Observasi Elemen Kerja");

// ------- SET COLUMN --------- //
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(1);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

// MERGING TO SET THE PAGE HEADER//
$objPHPExcel->getActiveSheet()->mergeCells('A1:A5');//LOGO QUICK
$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');//JUDUL ISIAN
$objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
$objPHPExcel->getActiveSheet()->mergeCells('B4:C4');
$objPHPExcel->getActiveSheet()->mergeCells('B5:C5');

$objPHPExcel->getActiveSheet()->mergeCells('E1:J1'); //ISIANNYA
$objPHPExcel->getActiveSheet()->mergeCells('E2:J2'); 
$objPHPExcel->getActiveSheet()->mergeCells('E3:J3'); 
$objPHPExcel->getActiveSheet()->mergeCells('E4:J4'); 
$objPHPExcel->getActiveSheet()->mergeCells('E5:J5'); 

$objPHPExcel->getActiveSheet()->mergeCells('K1:T5'); //JUDUL LEMBAR OBSERVASI ELEMEN KERJA
$objPHPExcel->getActiveSheet()->mergeCells('U1:W1'); //KEPALA SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('U2:W3'); //ISI KASIE
$objPHPExcel->getActiveSheet()->mergeCells('U4:W4'); //OPERATOR
$objPHPExcel->getActiveSheet()->mergeCells('U5:W5'); //ISI OPERATOR
$objPHPExcel->getActiveSheet()->mergeCells('X1:Y1'); //DIBUAT OLEH
$objPHPExcel->getActiveSheet()->mergeCells('X2:Y3'); //ISI DIBUAT OLEH
$objPHPExcel->getActiveSheet()->mergeCells('X4:Y4'); //TANGGAL
$objPHPExcel->getActiveSheet()->mergeCells('X5:Y5'); //ISI TANGGAL
 
$objPHPExcel->getActiveSheet()->mergeCells('A6:A7'); //TABLE HEADER : NO
$objPHPExcel->getActiveSheet()->mergeCells('B6:J7'); //TABLE HEADER : ELEMEN KERJA
$objPHPExcel->getActiveSheet()->mergeCells('K6:K7'); //TABLE HEADER : 1
$objPHPExcel->getActiveSheet()->mergeCells('L6:L7'); //TABLE HEADER : 2
$objPHPExcel->getActiveSheet()->mergeCells('M6:M7'); //TABLE HEADER : 3
$objPHPExcel->getActiveSheet()->mergeCells('N6:N7'); //TABLE HEADER : 4
$objPHPExcel->getActiveSheet()->mergeCells('O6:O7'); //TABLE HEADER : 5
$objPHPExcel->getActiveSheet()->mergeCells('P6:P7'); //TABLE HEADER : 6
$objPHPExcel->getActiveSheet()->mergeCells('Q6:Q7'); //TABLE HEADER : 7
$objPHPExcel->getActiveSheet()->mergeCells('R6:R7'); //TABLE HEADER : 8
$objPHPExcel->getActiveSheet()->mergeCells('S6:S7'); //TABLE HEADER : 9
$objPHPExcel->getActiveSheet()->mergeCells('T6:T7'); //TABLE HEADER : 10
$objPHPExcel->getActiveSheet()->mergeCells('U6:U7'); //TABLE HEADER : X min
$objPHPExcel->getActiveSheet()->mergeCells('V6:V7'); //TABLE HEADER : R
$objPHPExcel->getActiveSheet()->mergeCells('W6:W7'); //TABLE HEADER : Waktu Kerja
$objPHPExcel->getActiveSheet()->mergeCells('X6:Y7'); //TABLE HEADER : Keterangan


// //ADD IMAGE QUICK FOR HEADER//

$gdImage = imagecreatefrompng('assets/img/logo.png');
// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setName('Logo QUICK');$objDrawing->setDescription('Logo QUICK');
$objDrawing->setImageResource($gdImage);
$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
$objDrawing->setCoordinates('A2');
//set width, height
$objDrawing->setWidth(50); 
$objDrawing->setHeight(75); 
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 

//SET CELL VALUE FOR THE HEADER
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B1', 'Seksi')
        ->setCellValue('B2', 'Line')
        ->setCellValue('B3', 'Part/Komponen')
        // ->setCellValue('B3', 'Part/Komponen')
        ->setCellValue('B4', 'Kode Part/Komp.')
        ->setCellValue('B5', 'Proses')

        ->setCellValue('D1', ':')
        ->setCellValue('D2', ':')
        ->setCellValue('D3', ':')
        ->setCellValue('D4', ':')
        ->setCellValue('D5', ':')

        ->setCellValue('E1', $seksi)
        ->setCellValue('E2', $line) //line blm tau dari mane
        ->setCellValue('E3', $nama_part) //gua juga blm tau
        ->setCellValue('E4', $kode_part)
        ->setCellValue('E5', $proses)

        ->setCellValue('K1', 'Lembar Observasi Elemen Kerja')

        ->setCellValue('U1', 'Kepala Seksi:')
        ->setCellValue('U4', 'Operator:')
        ->setCellValue('U5', $operator)
        ->setCellValue('X1', 'Dibuat Oleh:')
        ->setCellValue('X4', 'Tanggal:')
        ->setCellValue('X5', $tanggal)

        ->setCellValue('A6', 'NO')
        ->setCellValue('B6', 'Elemen Kerja')
        ->setCellValue('K6', '1')
        ->setCellValue('L6', '2')
        ->setCellValue('M6', '3')
        ->setCellValue('N6', '4')
        ->setCellValue('O6', '5')
        ->setCellValue('P6', '6')
        ->setCellValue('Q6', '7')
        ->setCellValue('R6', '8')
        ->setCellValue('S6', '9')
        ->setCellValue('T6', '10')

        ->setCellValue('U6', 'X min')
        ->setCellValue('V6', 'R')
        ->setCellValue('W6', 'Waktu Kerja')
        ->setCellValue('X6', 'Keterangan')
        
        ;;

//STYLING HEADER//

//GARIS DI GAMBAR
$objget->getStyle('A1:A5')->applyFromArray(
  array(
          'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      )
  ); 

//GARIS DI BAGIAN SEKSI - PROSES
$objget->getStyle('B1:D1')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      )
  );

$objget->getStyle('B2:D2')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      )
  );

$objget->getStyle('B3:D3')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      )
  );

$objget->getStyle('B4:D4')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      )
  );

$objget->getStyle('B5:D5')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      )
  ); 
  
  $objget->getStyle('B1:J5')->applyFromArray(
    array(
            'font' => array(
              'color' => array('000000'),
              'bold' => true,
            ),
        )
    );

$objget->getStyle('E1:J5')->applyFromArray(
  array(
          'borders' => array(
          'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      )
  );  

$objget->getStyle('I1:R5')->applyFromArray(
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

//SET FONT SIZE LOEL
$objPHPExcel->getActiveSheet()->getStyle("I1:R5")->getFont()->setSize(22);

$objget->getStyle('U1:W3')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          ),
          'font' => array(
          'color' => array('000000'),
          'bold' => true,
          ),
      )
  );

$objget->getStyle('U2:W3')->applyFromArray(
  array(
        'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      )
  );

$objget->getStyle('U4:W5')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          ),
          'font' => array(
            'color' => array('000000'),
            'bold' => true,
          ),
      )
  );

$objget->getStyle('U5:W5')->applyFromArray(
  array(
        'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      )
  );

$objget->getStyle('X1:Y3')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          ),
          'font' => array(
            'color' => array('000000'),
            'bold' => true,
          ),
      )
  );

$objget->getStyle('X2:Y3')->applyFromArray(
  array(
        'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      )
  );

$objget->getStyle('X4:Y5')->applyFromArray(
  array(
          'borders' => array(
          'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          ),
          'font' => array(
            'color' => array('000000'),
            'bold' => true,
          ),
      )
  );

$objget->getStyle('X5:Y5')->applyFromArray(
  array(
        'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
      )
  );

//TABLE HEADER STYLING//
        $objget->getStyle('A6:Y7')->applyFromArray(
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

//WRAP TEXT ON WAKTU KERJA COLUMN    
  $objget->getStyle('W6:W7')->getAlignment()->setWrapText(true);

//SET THE TABLE VALUES//
$baris  = 8;
$no = 1;

foreach ($newID as $isi) {

  $objset->setCellValue("A".$baris, $no);
  $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':J'.$baris); 
  $objset->setCellValue("B".$baris, $isi['elemen']." ".$isi['keterangan_elemen']);
  $objPHPExcel->getActiveSheet()->mergeCells('K'.$baris.':K'.$baris); 
  $objget->getStyle('B'.$baris.':J'.$baris)->getAlignment()->setWrapText(true);
  $objset->setCellValue("K".$baris, $isi['waktu_1']);
  $objset->setCellValue("L".$baris, $isi['waktu_2']);
  $objset->setCellValue("M".$baris, $isi['waktu_3']);
  $objset->setCellValue("N".$baris, $isi['waktu_4']);
  $objset->setCellValue("O".$baris, $isi['waktu_5']);
  $objset->setCellValue("P".$baris, $isi['waktu_6']);
  $objset->setCellValue("Q".$baris, $isi['waktu_7']);
  $objset->setCellValue("R".$baris, $isi['waktu_8']);
  $objset->setCellValue("S".$baris, $isi['waktu_9']);
  $objset->setCellValue("T".$baris, $isi['waktu_10']);
  $objset->setCellValue("U".$baris, $isi['x_min']);
  $objset->setCellValue("V".$baris, $isi['r']);
  $objset->setCellValue("W".$baris, $isi['waktu_kerja']);
  $objPHPExcel->getActiveSheet()->mergeCells('X'.$baris.':Y'.$baris); 
  $objset->setCellValue("X".$baris, $isi['keterangan']);

  $objget->getStyle('A'.$baris.':Y'.$baris)->applyFromArray(
    array(
            'borders' => array(
            'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    ); 

  $objget->getStyle('A'.$baris.':A'.$baris)->applyFromArray(
    array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      )
        )
    ); 

  $objget->getStyle('K'.$baris.':W'.$baris)->applyFromArray(
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
  $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexJml.':J'.($indexJml + 1)); 
  $objset->setCellValue("A".$indexJml, "1 Cycle Time (satuan Detik)");
  $objPHPExcel->getActiveSheet()->mergeCells('K'.$indexJml.':K'.($indexJml + 1)); 
  $objset->setCellValue("K".$indexJml, $jumlah_1);
  $objPHPExcel->getActiveSheet()->mergeCells('L'.$indexJml.':L'.($indexJml + 1)); 
  $objset->setCellValue("L".$indexJml, $jumlah_2);
  $objPHPExcel->getActiveSheet()->mergeCells('M'.$indexJml.':M'.($indexJml + 1)); 
  $objset->setCellValue("M".$indexJml, $jumlah_3);
  $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexJml.':N'.($indexJml + 1)); 
  $objset->setCellValue("N".$indexJml, $jumlah_4);
  $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexJml.':O'.($indexJml + 1)); 
  $objset->setCellValue("O".$indexJml, $jumlah_5);
  $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexJml.':P'.($indexJml + 1)); 
  $objset->setCellValue("P".$indexJml, $jumlah_6);
  $objPHPExcel->getActiveSheet()->mergeCells('Q'.$indexJml.':Q'.($indexJml + 1)); 
  $objset->setCellValue("Q".$indexJml, $jumlah_7);
  $objPHPExcel->getActiveSheet()->mergeCells('R'.$indexJml.':R'.($indexJml + 1)); 
  $objset->setCellValue("R".$indexJml, $jumlah_8);
  $objPHPExcel->getActiveSheet()->mergeCells('S'.$indexJml.':S'.($indexJml + 1)); 
  $objset->setCellValue("S".$indexJml, $jumlah_9);
  $objPHPExcel->getActiveSheet()->mergeCells('T'.$indexJml.':T'.($indexJml + 1)); 
  $objset->setCellValue("T".$indexJml, $jumlah_10);
  $objPHPExcel->getActiveSheet()->mergeCells('U'.$indexJml.':U'.($indexJml + 1)); 
  $objset->setCellValue("U".$indexJml, $jumlah_Xmin);
  $objPHPExcel->getActiveSheet()->mergeCells('V'.$indexJml.':V'.($indexJml + 1)); 
  $objset->setCellValue("V".$indexJml, $jumlah_R);
  $objPHPExcel->getActiveSheet()->mergeCells('W'.$indexJml.':W'.($indexJml + 1)); 
  $objset->setCellValue("W".$indexJml, $jumlah_wKerja);
  $objPHPExcel->getActiveSheet()->mergeCells('X'.$indexJml.':Y'.($indexJml + 1)); 

    //STYLING OF TOTAL TIMES//
    $objget->getStyle('A'.$indexJml.':Y'.($indexJml + 1))->applyFromArray(
      array(
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