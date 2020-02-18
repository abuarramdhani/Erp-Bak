<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Regenerate extends CI_Controller {

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

//CONVERT NUMBER TO CHARACTER
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

public function exportAgain($id){

    $this->load->library(array('Excel','Excel/PHPExcel/IOFactory')); 

    $newID           = $this->M_gentskk->selectAll($id); 
    $getIrregularJob = $this->M_gentskk->selectIrregularJobs($id);
    // echo "<pre>";print_r($getIrregularJob);exit();

    //HEADER//
    // echo "<pre>"; print_r($_POST);exit(); 
    $judul            = $newID[0]['judul_tskk'];
    //PART
    $type 	          = $newID[0]['tipe'];
    $kode_part 	      = $newID[0]['kode_part'];
    $nama_part 	      = $newID[0]['nama_part'];
    //EQUIPMENT
    $no_mesin	      = $newID[0]['no_mesin'];
    $nm = explode("; ", trim($no_mesin));
    $jenis_mesin      = $newID[0]['mesin'];
    $resource         = $newID[0]['resource_mesin'];
    $line             = $newID[0]['line_process'];
    $alat_bantu	      = $newID[0]['alat_bantu'];
    $ab = explode("; ", $alat_bantu);
    // echo "<pre>";print_r($ab);
    $tools            = $newID[0]['tools'];
    $tl = explode("; ", $tools);
    //SDM
    $operator	      = $newID[0]['operator'];
    $a = explode(" - ", $operator);
    $nama_operator = $a[0];
    $no_induk = $a[1];
    // echo "<pre>"; print_r($a); 
    // echo "<pre>"; echo $nama_operator; 
    // echo "<pre>"; echo $no_induk; 
    // exit();
    $jml_operator     = $newID[0]['jumlah_operator'];
    $dr_operator      = $newID[0]['jumlah_operator_dari'];
    $seksi 	          = $newID[0]['seksi'];
    //PROCESS
    $proses 	      = $newID[0]['proses'];
    $kode_proses      = $newID[0]['kode_proses'];
    $proses_ke 	      = $newID[0]['proses_ke'];
    $qty 	          = $newID[0]['qty'];
    $dari 	          = $newID[0]['proses_dari'];
    //ACTIVITY
    $tanggal          = $newID[0]['tanggal'];
    //SEKSI PEMBUAT
    $noind = $this->session->user;
    $data['getSeksiUnit'] = $this->M_gentskk->detectSeksiUnit($noind);
    $split = $data['getSeksiUnit'][0];
    $seksi_pembuat = $split['seksi'];
    $dept_pembuat = $split['dept'];

    // echo $seksi_pembuat;
    //DATA FOR TSKK (elements table)
    $id_tskk          = $newID[0]['id_tskk'];
    $takt_time        = $newID[0]['takt_time'];
    $jenis_proses 	  = array_column($newID, 'jenis_proses');
    $elemen           = array_column($newID, 'elemen');
    $keterangan_elemen= array_column($newID, 'keterangan_elemen');
    $tipe_urutan 	  = array_column($newID, 'tipe_urutan');
    $start 	          = array_column($newID, 'mulai');
    $finish 	      = array_column($newID, 'finish');
    $last_finish      = end($finish);  
    $waktu 	          = array_column($newID, 'waktu');

    //TSKK PRINTER :v
    $noind = $this->session->user;
    $name = $this->M_gentskk->selectNamaPekerja($noind);
    $nama_pekerja = $name[0]['nama'];
    $creationDate = date('d-M-Y');
    $generateDate = str_replace("-", " ", $creationDate);
    
    //PENGHITUNGAN MUDA
    for ($i=0; $i < count($elemen) ; $i++) { 

        if ($i != 0) {
            if ($jenis_proses[$i-1] != 'AUTO') {
                $muda[$i] = $start[$i] - $finish[$i-1]-1;
                $mudaAuto[$i] = false;
            }elseif ($jenis_proses[$i-1] == 'AUTO' && $i > 1) {
                $muda[$i] = $start[$i] - $finish[$i-2]-1;
                $mudaAuto[$i] = true;
            }
        }else{
            $muda[$i] = 1;
            $mudaAuto[$i] = 'tidakMuda';
        }
    }
    // die;
    
    $selectIdElemen = $this->M_gentskk->selectIdElemen($id_tskk);
    if ($selectIdElemen == null) {
        $id = null;
    }else{
        $id = $selectIdElemen[0]['id_tskk'];
    }

    if ($id != null) {
        $deleteElemen = $this->M_gentskk->deleteElemen($id);
        // echo count($elemen);
        for ($i=0; $i < count($elemen); $i++) { 
            if ($i != 0) {
                $data = array(
                    'jenis_proses'  	=> $jenis_proses[$i],
                    'elemen' 	        => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'   	=> $tipe_urutan[$i],
                    'mulai' 	        => $start[$i],
                    'finish' 	        => $finish[$i],
                    'waktu' 	        => $waktu[$i],
                    'muda'              => $start[$i] - $finish[$i-1],
                    'id_tskk'       	=> $id_tskk
                );
            }else {
                $data = array(
                    'jenis_proses'  	=> $jenis_proses[$i],
                    'elemen' 	        => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'   	=> $tipe_urutan[$i],
                    'mulai' 	        => $start[$i],
                    'finish' 	        => $finish[$i],
                    'waktu' 	        => $waktu[$i],
                    'muda'              => 1,
                    'id_tskk'       	=> $id_tskk
                );
            }

            if ($data['jenis_proses'] != null) {
                $insert = $this->M_gentskk->tabelelemen($data); 
            }
        // echo "<pre>";print_r($data);
        }
    }else{
        for ($i=0; $i < count($elemen); $i++) { 
            if ($i != 0) {
                $data = array(
                    'jenis_proses'  	=> $jenis_proses[$i],
                    'elemen' 	        => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'   	=> $tipe_urutan[$i],
                    'mulai' 	        => $start[$i],
                    'finish' 	        => $finish[$i],
                    'waktu' 	        => $waktu[$i],
                    'muda'              => $start[$i] - $finish[$i-1],
                    'id_tskk'       	=> $id_tskk
                );
            }else {
                $data = array(
                    'jenis_proses'  	=> $jenis_proses[$i],
                    'elemen' 	        => $elemen[$i],
                    'keterangan_elemen' => $keterangan_elemen[$i],
                    'tipe_urutan'   	=> $tipe_urutan[$i],
                    'mulai' 	        => $start[$i],
                    'finish' 	        => $finish[$i],
                    'waktu' 	        => $waktu[$i],
                    'muda'              => 1,
                    'id_tskk'       	=> $id_tskk
                );
            }
 
            if ($data['jenis_proses'] != null) {
                $insert = $this->M_gentskk->tabelelemen($data); 
            }
        // echo "<pre>";print_r($data);
        }
    // exit();

    }

    //DATA FOR NOTES AND TAKT TIME CALCULATION
    $dataTakTime        = $this->M_gentskk->selectTaktTimeCalculation($id_tskk);

    $waktu_satu_shift   = $dataTakTime[0]['waktu_satu_shift'];
    $jumlah_shift       = $dataTakTime[0]['jumlah_shift'];
    $forecast           = $dataTakTime[0]['forecast'];
    $qty_unit           = $dataTakTime[0]['qty_unit'];
    $rencana_produksi   = $dataTakTime[0]['rencana_produksi'];
    $jumlah_hari_kerja  = $dataTakTime[0]['jumlah_hari_kerja'];

    //Make "elemen kerja" from combination of "elemen & keterangan"//
    $elemen_kerja =  array();

    for ($i=0; $i < count($elemen) ; $i++) { 
        // $elemen_kerja[$i] = $elemen[$i]." ".$keterangan_elemen[$i];
        $elemen_kerja[$i] = "   ".$elemen[$i]." ".$keterangan_elemen[$i];
        // $elemen_kerja[$i] = $elemen[$i];
    }
    
//COUNT THE TOTAL TIMES :
       $indexArr = 0;
       $jumlah = 0;
       $jumlah_manual = 0;
       $jumlah_auto = 0;
       $jumlah_walk = 0;
       $jml_baris = 1; //BLM TNT
       $elemenWaktu = $elemen_kerja[0];

       for($i=0; $i < count($waktu); $i++){
           if ($elemenWaktu != $elemen_kerja[$i]) {
               $jml_baris++;
           }
            $j = $jenis_proses[$i];
                if ($j == 'MANUAL') {
                    $jumlah_manual=$waktu[$i]+$jumlah_manual;
                }elseif ($j == 'AUTO' || $j == 'AUTO (Inheritance)') {
                    $jumlah_auto=$waktu[$i]+$jumlah_auto;
                }else{
                    $jumlah_walk=$waktu[$i]+$jumlah_walk;
                }
        $jumlah=$waktu[$i]+$jumlah; 
      }
    
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("ICT_Production")->setTitle("ICT");
  
    $objset = $objPHPExcel->setActiveSheetIndex(0);
    $objget = $objPHPExcel->getActiveSheet();
    $objget->setTitle("TSKK_Shackle");
  
    // ------- SET COLUMN ---------
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(7);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(1);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(1);

      $indexSatu=18;
      $indexDua=18;
    
      //set pembulatan dengan mengisi angka
    if ($jumlah < 370) {
        $end = 370;
    } else {
        // echo $jumlah; exit();
        $g = (int)($jumlah / 10);
        $g += 1;
        $end = $g * 10;
        // echo "g = $g <br>jml = $jumlah <br>".$end;
    }
    
    //IRREGULAR JOBS //asw 
    $dataIrregularJob       = $this->M_gentskk->selectIrregularJobs($id_tskk);

    $irregular_jobs         = array_column($dataIrregularJob, 'irregular_job');
    $ratio_irregular        = array_column($dataIrregularJob, 'ratio');
    $waktu_irregular        = array_column($dataIrregularJob, 'waktu');
    $hasil_irregular        = array_column($dataIrregularJob, 'hasil_irregular_job');
    $jumlah_hasil_irregular = array_sum($hasil_irregular);
    // echo $hasil_irregular;die;

    //checking the length based on cycle time too
    if ($hasil_irregular == NULL) {
        $cycle_time = $last_finish + $takt_time;
        $cycleTimeText = $cycle_time + 3;
        // echo"<pre>"; echo "KOSONG";

        // echo"<pre>"; echo $cycle_time;
        // echo"<pre>"; echo $cycleTimeText;
    }else {
        $cycle_time = $last_finish + $jumlah_hasil_irregular + $takt_time;
        $cycleTimeText = $cycle_time + 3;
        // echo"<pre>"; echo $cycle_time;
        // echo"<pre>"; echo "KAGA";
    }

    if ($cycle_time < 370) {
        $end = 370;
    } else {
        // echo $jumlah; exit();
        $g = (int)($cycle_time / 10);
        $g += 1;
        $end = $g * 10;
        // echo "g = $g <br>jml = $jumlah <br>".$end;
    }

    //checking the length in relation with takt time
    // if ($takt_time < 370) {
    //     $end = 370;
    // } else {
    //     // echo $jumlah; exit();
    //     $g = (int)($takt_time / 10);
    //     $g += 1;
    //     $end = $g * 10;
    //     // echo "g = $g <br>jml = $jumlah <br>".$end;
    // }

    //MERGING DETIK//
    $indexAngka = 18;
    $indexStart = 1;
    $kolomA   = $this->Kolom($indexAngka);
    $kolomB   = $this->Kolom($indexAngka + $end);
    $kolomJDL = $this->Kolom($indexStart);

    // $objPHPExcel->getActiveSheet()->mergeCells('A1'.':'.($indexJml + 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomJDL.'1:'.$kolomB.'1');
        $objget->getStyle($kolomJDL.'1:'.$kolomB.'1')->applyFromArray(
            array(
                'font' => array(
                'bold' => true
                )
            )
        );
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomJDL.'1', $judul." | ".$nama_pekerja." (".$noind.") : ".$generateDate);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($kolomA.'15:'.$kolomB.'15');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomA.'15', 'Detik');
    $objPHPExcel->getActiveSheet()->getStyle($kolomJDL.'1')->getFont()->setSize(13);


    $objget->getStyle($kolomA.'15:'.$kolomB.'15')->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
            )
        );  

    $objget->getStyle($kolomJDL.'1:'.$kolomB.'1')->applyFromArray(
        array(
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
            )
        );  

      $val = 0;
      $kolomEnd = $this->Kolom($end + 18);

        //STYLING HORIZONTAL ROWS//
        $objget->getStyle('K8:'.$kolomEnd.(17))->applyFromArray(
            array(
                'borders' => array(
                'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                ),
            )
        );  
        //STYLING HORIZONTAL ROWS//

    for ($i=0; $i < $end + 1 ; $i++) { 
          $col1 = $this->Kolom($indexSatu);
          $col2 = $this->Kolom($indexDua);
          
          if ($i % 10 == 0) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col1.'16',$val);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($col1.'16:'.$col2.'16');
                
                //STYLING THE LINE OF TIME FLOW//PANJANGNYA KE BAWAH//PANJANG UJUNG KE BAWAH
                $objget->getStyle($col1.'16:'.$col2.(($jml_baris * 3) + 20))->applyFromArray(
                    array(
                        'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                    )
                );
                //BELUM TENTU
                $objget->getStyle($col1.'16:'.$col2.'16')->applyFromArray(
                    array(
                        'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );

                $objget->getStyle($col1.'17:'.$col2.'17')->applyFromArray(
                    array(
                        'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );

                //STYLING THE VERTICLE LINE OF TIME FLOW//

                $indexSatu = $indexDua + 1;
                $val += 10;
        }

        //URUTAN ANGKA//
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col2.'17', $i);
        $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setWidth(0.58);

        $objget->getStyle($col2.'17')->applyFromArray(
            array(
                'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ff8b26') //orange
                    )
                )
            );

            $indexDua++;
        $objPHPExcel->getActiveSheet()->getColumnDimension($col2)->setWidth(0.58);
    }

            //KELIPATAN 10//
            $indexAngka = 19;
            $indexKelipatan = 10;
       
            for ($angka=19; $angka < $jumlah+1; $angka++) { 

                $kolomA = $this->Kolom($indexAngka);
                $kolomB = $this->Kolom($indexAngka + 9);

                $indexAngka += 10;
                $indexKelipatan +=10;
              
                    if ($indexAngka + 10 > ($jumlah) + 20) { //set the maximum 
                        break;
                    }
            }    
            
    //GIVE BOLD BORDER FOR TIME FLOW HEADER 

    // $objget->getStyle($col2.'17')->applyFromArray(
    //     array(
    //         'fill' => array(
    //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
    //         'color' => array('rgb' => 'ff8b26') //orange
    //             )
    //         )
    //     );

    $objget->getStyle('R15:'.$kolomEnd.'17')->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 
    
    //ADD IMAGE QUICK FOR HEADER//

    $gdImage = imagecreatefrompng('assets/img/logo.png');
    // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('Logo QUICK');$objDrawing->setDescription('Logo QUICK');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    $objDrawing->setCoordinates('A4');
    //set width, height
    $objDrawing->setWidth(120); //ASW
    $objDrawing->setHeight(135); 
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 
    
// MERGING TO SET THE PAGE HEADER//
$objPHPExcel->getActiveSheet()->mergeCells('A2:C12');   //LOGO 
$objPHPExcel->getActiveSheet()->mergeCells('D2:H3');    //CV KHS
$objPHPExcel->getActiveSheet()->mergeCells('D4:H5');    //YOGYAKARTA
$objPHPExcel->getActiveSheet()->mergeCells('D6:H10');   //KOSONG
$objPHPExcel->getActiveSheet()->mergeCells('D11:H12');  //DEPARTEMEN
$objPHPExcel->getActiveSheet()->mergeCells('I2:P4');    //SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('I5:P12');   //TSKK 

//TABEL HEADER OF ELEMENTS
$objPHPExcel->getActiveSheet()->mergeCells('A15:A17'); //NO
$objPHPExcel->getActiveSheet()->mergeCells('B15:M17'); //ELEMEN KERJA
$objPHPExcel->getActiveSheet()->mergeCells('N15:N17'); //MANUAL
$objPHPExcel->getActiveSheet()->mergeCells('O15:O17'); //AUTO
$objPHPExcel->getActiveSheet()->mergeCells('P15:P17'); //WALK

$objPHPExcel->getActiveSheet()->mergeCells('S2:DF2');  //KETERANGAN
$objPHPExcel->getActiveSheet()->mergeCells('V4:AL4');  //kotak item
$objPHPExcel->getActiveSheet()->mergeCells('AP3:BL5'); //Manual
$objPHPExcel->getActiveSheet()->mergeCells('BP4:CF4'); //kotak kuning
$objPHPExcel->getActiveSheet()->mergeCells('CJ3:DF5'); //cycle time

$objPHPExcel->getActiveSheet()->mergeCells('V7:AL7');  //kotak ijo
$objPHPExcel->getActiveSheet()->mergeCells('AP6:BL8'); //TULISAN Auto (Mesin)
$objPHPExcel->getActiveSheet()->mergeCells('BW6:BY8'); //merah (TAKT TIME)
$objPHPExcel->getActiveSheet()->mergeCells('CJ6:DF8'); //takt time

$objPHPExcel->getActiveSheet()->mergeCells('V10:AL10');  //KOTAK WALK BIRU
$objPHPExcel->getActiveSheet()->mergeCells('AP9:BL11'); //jalan
$objPHPExcel->getActiveSheet()->mergeCells('BP10:CF10'); //panah merah A.K.A muda
$objPHPExcel->getActiveSheet()->mergeCells('CJ9:DF11'); //muda
$objPHPExcel->getActiveSheet()->mergeCells('S12:DF12');  //KETERANGAN KOSONG

//MERGING THE LEFT ROW
$objPHPExcel->getActiveSheet()->mergeCells('S3:AO3'); 
$objPHPExcel->getActiveSheet()->mergeCells('S4:U4'); 
$objPHPExcel->getActiveSheet()->mergeCells('AM4:AO4'); 
$objPHPExcel->getActiveSheet()->mergeCells('S5:AO5'); 
$objPHPExcel->getActiveSheet()->mergeCells('S6:AO6'); 
$objPHPExcel->getActiveSheet()->mergeCells('S7:U7'); 
$objPHPExcel->getActiveSheet()->mergeCells('AM7:AO7'); 
$objPHPExcel->getActiveSheet()->mergeCells('S8:AO8'); 
$objPHPExcel->getActiveSheet()->mergeCells('S9:AO9'); 
$objPHPExcel->getActiveSheet()->mergeCells('S10:U10'); 
$objPHPExcel->getActiveSheet()->mergeCells('AM10:AO10'); 
$objPHPExcel->getActiveSheet()->mergeCells('S11:AO11'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM3:CI3'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM4:BO4'); 
$objPHPExcel->getActiveSheet()->mergeCells('CG4:CI4'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM5:CI5'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM6:CI6'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM7:BV7'); 
$objPHPExcel->getActiveSheet()->mergeCells('BZ7:CI7'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM8:CI8'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM9:CI9'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM10:BO10'); 
$objPHPExcel->getActiveSheet()->mergeCells('CG10:CI10'); 
$objPHPExcel->getActiveSheet()->mergeCells('BM11:CI11'); 

//REVISI
$objPHPExcel->getActiveSheet()->mergeCells('DG2:FJ2'); //revisi 
$objPHPExcel->getActiveSheet()->mergeCells('DG3:DN3'); //no.
$objPHPExcel->getActiveSheet()->mergeCells('DG4:DN4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('DG5:DN5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('DG6:DN6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('DG7:DN7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('DG8:DN8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('DG9:DN9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('DG10:DN10'); //no7.
$objPHPExcel->getActiveSheet()->mergeCells('DG11:DN11'); //no8.
$objPHPExcel->getActiveSheet()->mergeCells('DG12:DN12'); //no9.
$objPHPExcel->getActiveSheet()->mergeCells('DO3:FJ3'); //detail
$objPHPExcel->getActiveSheet()->mergeCells('DO4:FJ4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('DO5:FJ5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('DO6:FJ6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('DO7:FJ7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('DO8:FJ8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('DO9:FJ9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('DO10:FJ10'); //no7.
$objPHPExcel->getActiveSheet()->mergeCells('DO11:FJ11'); //no8.
$objPHPExcel->getActiveSheet()->mergeCells('DO12:FJ12'); //no9.

$objPHPExcel->getActiveSheet()->mergeCells('FK2:GM3'); //tanggal
$objPHPExcel->getActiveSheet()->mergeCells('FK4:GM4'); //no1.
$objPHPExcel->getActiveSheet()->mergeCells('FK5:GM5'); //no2.
$objPHPExcel->getActiveSheet()->mergeCells('FK6:GM6'); //no3.
$objPHPExcel->getActiveSheet()->mergeCells('FK7:GM7'); //no4.
$objPHPExcel->getActiveSheet()->mergeCells('FK8:GM8'); //no5.
$objPHPExcel->getActiveSheet()->mergeCells('FK9:GM9'); //no6.
$objPHPExcel->getActiveSheet()->mergeCells('FK10:GM10'); //no7.
$objPHPExcel->getActiveSheet()->mergeCells('FK11:GM11'); //no8.
$objPHPExcel->getActiveSheet()->mergeCells('FK12:GM12'); //no9.

$objPHPExcel->getActiveSheet()->mergeCells('GN2:IA2'); //PART
$objPHPExcel->getActiveSheet()->mergeCells('GN3:IA3'); //TYPE PRODUK
$objPHPExcel->getActiveSheet()->mergeCells('GN4:IA5'); //ISI TYPE PRODUK
$objPHPExcel->getActiveSheet()->mergeCells('GN6:IA6'); //NAMA PART
$objPHPExcel->getActiveSheet()->mergeCells('GN7:IA8'); //ISI NAMA PART
$objPHPExcel->getActiveSheet()->mergeCells('GN9:IA9'); //KODE PART
$objPHPExcel->getActiveSheet()->mergeCells('GN10:IA10'); //ISI KODE PART
$objPHPExcel->getActiveSheet()->mergeCells('GN11:IA11'); //TANGGAL OBSERVASI
$objPHPExcel->getActiveSheet()->mergeCells('GN12:IA12'); //ISI TANGGAL OBSERVASI

$objPHPExcel->getActiveSheet()->mergeCells('IB2:JL2'); //SDM
$objPHPExcel->getActiveSheet()->mergeCells('IB3:JL3'); //NAMA
$objPHPExcel->getActiveSheet()->mergeCells('IB4:JL4'); //ISI NAMA
$objPHPExcel->getActiveSheet()->mergeCells('IB5:JL5'); //NO INDUK
$objPHPExcel->getActiveSheet()->mergeCells('IB6:JL6'); //ISI NO INDUK
$objPHPExcel->getActiveSheet()->mergeCells('IB7:JL7'); //SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('IB8:JL8'); //ISI SEKSI
$objPHPExcel->getActiveSheet()->mergeCells('IB9:JL9'); //JUMLAH OPERATOR...DARI...
$objPHPExcel->getActiveSheet()->mergeCells('IB10:JL12'); //ISI JUMLAH OPERATOR...DARI...

$objPHPExcel->getActiveSheet()->mergeCells('JM2:KV2'); //EQUIPMENT
$objPHPExcel->getActiveSheet()->mergeCells('JM3:KV3'); //No. mesin
$objPHPExcel->getActiveSheet()->mergeCells('JM4:KD4'); //1.
$objPHPExcel->getActiveSheet()->mergeCells('JM5:KD5'); //2.
$objPHPExcel->getActiveSheet()->mergeCells('JM6:KD6'); //3.
$objPHPExcel->getActiveSheet()->mergeCells('KE4:KV4'); //4.
$objPHPExcel->getActiveSheet()->mergeCells('KE5:KV5'); //5.
$objPHPExcel->getActiveSheet()->mergeCells('KE6:KV6'); //6.
$objPHPExcel->getActiveSheet()->mergeCells('JM7:KV7'); //jenis mesin
$objPHPExcel->getActiveSheet()->mergeCells('JM8:KV8'); //isi jenis mesin
$objPHPExcel->getActiveSheet()->mergeCells('JM9:KV9'); //Resource
$objPHPExcel->getActiveSheet()->mergeCells('JM10:KV10'); //isi Resource
$objPHPExcel->getActiveSheet()->mergeCells('JM11:KV11'); //line
$objPHPExcel->getActiveSheet()->mergeCells('JM12:KV12'); //isi line

$objPHPExcel->getActiveSheet()->mergeCells('KW2:MK2'); //PROCESS
$objPHPExcel->getActiveSheet()->mergeCells('KW3:MK3'); //Proses
$objPHPExcel->getActiveSheet()->mergeCells('KW4:MK4'); //ISI Proses
$objPHPExcel->getActiveSheet()->mergeCells('KW5:MK5'); //Kode Proses
$objPHPExcel->getActiveSheet()->mergeCells('KW6:MK6'); //ISI Kode Proses
$objPHPExcel->getActiveSheet()->mergeCells('KW7:MK7'); //Proses ke ... dari ...
$objPHPExcel->getActiveSheet()->mergeCells('KW8:MK8'); //ISI Proses ke ... dari ...
$objPHPExcel->getActiveSheet()->mergeCells('KW9:MK9'); //Qty/Process
$objPHPExcel->getActiveSheet()->mergeCells('KW10:MK10'); //ISI Qty/Process
$objPHPExcel->getActiveSheet()->mergeCells('KW11:MK11'); //TAKT TIME
$objPHPExcel->getActiveSheet()->mergeCells('KW12:MK12'); //ISI TAKT TIME

$objPHPExcel->getActiveSheet()->mergeCells('ML2:NX2'); //TOOLS
$objPHPExcel->getActiveSheet()->mergeCells('ML3:NX3'); //Tools
$objPHPExcel->getActiveSheet()->mergeCells('ML4:NX4'); //1
$objPHPExcel->getActiveSheet()->mergeCells('ML5:NX5'); //2
$objPHPExcel->getActiveSheet()->mergeCells('ML6:NX6'); //3
$objPHPExcel->getActiveSheet()->mergeCells('ML7:NX7'); //4
$objPHPExcel->getActiveSheet()->mergeCells('ML8:NX8'); //5
$objPHPExcel->getActiveSheet()->mergeCells('ML9:NX9'); //6
$objPHPExcel->getActiveSheet()->mergeCells('ML10:NX10'); //7
$objPHPExcel->getActiveSheet()->mergeCells('ML11:NX11'); //
$objPHPExcel->getActiveSheet()->mergeCells('ML12:NX12'); //

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I2', $seksi_pembuat)
            ->setCellValue('D2', 'CV KARYA HIDUP SENTOSA')
            ->setCellValue('D4', 'YOGYAKARTA')
            ->setCellValue('D11', 'DEPARTEMEN '.$dept_pembuat)
            // ->setCellValue('A7', 'Jl. Magelang No. 144 Yogyakarta 55241')
            ->setCellValue('I5', 'TABEL STANDAR KERJA KOMBINASI')

            ->setCellValue('S2', 'KETERANGAN')
            ->setCellValue('AP3', 'Manual')
            ->setCellValue('AP6', 'Auto (Mesin)')
            ->setCellValue('AP9', 'Jalan')
            ->setCellValue('CJ3', 'Cycle Time')
            ->setCellValue('CJ6', 'Takt Time')
            ->setCellValue('CJ9', 'Muda')

            ->setCellValue('A15', 'NO')
            ->setCellValue('B15', 'ELEMEN KERJA')

            ->setCellValue('N15', 'MANUAL')
            ->setCellValue('O15', 'AUTO')
            ->setCellValue('P15', 'WALK')

            ->setCellValue('DG2', 'Revisi')
            ->setCellValue('DG3', 'No.')
            ->setCellValue('DO3', 'Detail')
            ->setCellValue('FK2', 'Tanggal')

            //PART GROUPING
            ->setCellValue('GN2', 'PART')
            ->setCellValue('GN3', '  Type Produk')
            ->setCellValue('GN4', $type)
            ->setCellValue('GN6', '  Nama Part')
            ->setCellValue('GN7', $nama_part)
            ->setCellValue('GN9', '  Kode Part')
            ->setCellValue('GN10', $kode_part)
            ->setCellValue('GN11', '  Tanggal Observasi')
            ->setCellValue('GN12', $tanggal)

            //PART SDM
            ->setCellValue('IB2', 'SDM')
            ->setCellValue('IB3', '  Nama')
            ->setCellValue('IB4', $nama_operator) //isinya nama doang
            ->setCellValue('IB5', '  No. Induk')
            ->setCellValue('IB6', $no_induk) //isinya noind doang
            ->setCellValue('IB7', '  Seksi')
            ->setCellValue('IB8', $seksi)
            ->setCellValue('IB9', '  Jumlah operator ... dari ...')
            ->setCellValue('IB10', $jml_operator." dari ".$dr_operator)
            
            //PART EQUIPMENT
            ->setCellValue('JM2', 'EQUIPMENT')
            ->setCellValue('JM3', '  No. Mesin')
            ->setCellValue('JM7', '  Jenis Mesin')
            ->setCellValue('JM8', $jenis_mesin)
            ->setCellValue('JM9', '  Resource')
            ->setCellValue('JM10', $resource)
            ->setCellValue('JM11', '  Line')
            ->setCellValue('JM12', $line)

            //PART PROCESS
            ->setCellValue('KW2', 'PROCESS')
            ->setCellValue('KW3', '  Proses')
            ->setCellValue('KW4', $proses) //isinya nama doang
            ->setCellValue('KW5', '  Kode Proses')
            ->setCellValue('KW6', $kode_proses) //isinya noind doang
            ->setCellValue('KW7', '  Proses ke ... dari ...')
            ->setCellValue('KW8', $proses_ke." dari ".$dari)
            ->setCellValue('KW9', '  Qty/Process')
            ->setCellValue('KW10', $qty)
            ->setCellValue('KW11', '  Takt Time')
            ->setCellValue('KW12', $takt_time." Detik")
            
            //PART TOOLS
            ->setCellValue('ML2', 'TOOLS')
            ->setCellValue('ML3', '  Tools')
            ->setCellValue('ML9', '  Alat Bantu')

            ->setCellValue('U1', '');;

//STYLING TABLE HEADER OF THE CONTENT//
            $objPHPExcel->getActiveSheet()->getStyle("D2:H12")->getFont()->setSize(15);

            //PART GROUP
            $objget->getStyle('GN2:IA2')->applyFromArray(
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
            //ALL BORDERS FOR PART GROUPING
            $objget->getStyle('GN3:IA12')->applyFromArray(
                array(
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => false,
                    )
                )
            );
            //SETTING CENTER ALLIGNMENT FOR PART
            //ISI TYPE PRODUK
            $objget->getStyle('GN4:IA5')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('GN4:IA5')->getAlignment()->setWrapText(true);

            //ISI NAMA PART
            $objget->getStyle('GN7:IA8')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('GN7:IA8')->getAlignment()->setWrapText(true);

            //KODE PART
            $objget->getStyle('GN9:IA9')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );
            //ISI KODE PART
            $objget->getStyle('GN10:IA10')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('GN10:IA10')->getAlignment()->setWrapText(true);

            //TANGGAL OBSERVASI
            $objget->getStyle('GN11:IA11')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );
            //ISI TANGGAL OBSERVASI
            $objget->getStyle('GN12:IA12')->applyFromArray(
                array(
                    // 'borders' => array(
                    // 'allborders' => array(
                    //     'style' => PHPExcel_Style_Border::BORDER_THIN
                    //     )
                    // ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                        ),
                    )
                );     
                
            //SDM GROUPING GAN//
            $objget->getStyle('IB2:JL2')->applyFromArray(
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
            //ALL BORDERS FOR PART GROUPING
            // $objget->getStyle('IB3:JL12')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'allborders' => array(
            //                 'style' => PHPExcel_Style_Border::BORDER_THIN
            //             ),
            //             'font' => array(
            //             'color' => array('000000'),
            //             'bold' => true,
            //             ),
            //         )
            //     )
            // );
            //SETTING CENTER ALLIGNMENT FOR PART
            //ISI NAMA
            $objget->getStyle('IB4:JL4')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('IB4:JL4')->getAlignment()->setWrapText(true);

            //ISI NOIND
            $objget->getStyle('IB6:JL6')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('IB6:JL6')->getAlignment()->setWrapText(true);

            //ISI SEKSI
            $objget->getStyle('IB8:JL8')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('IB8:JL8')->getAlignment()->setWrapText(true);
            $objget->getStyle('IB9:JL9')->getAlignment()->setWrapText(true);

            //ISI JUMLAH OPERATOR...DARI...
            $objget->getStyle('IB10:JL12')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                        ),
                    )
                );  
            $objget->getStyle('IB10:JL12')->getAlignment()->setWrapText(true);

            //EQUIPMENT GROUPING
            $objget->getStyle('JM2:KV2')->applyFromArray(
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
            //ALL BORDERS FOR EQUIPMENT GROUPING
            // $objget->getStyle('JM3:KV12')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'allborders' => array(
            //                 'style' => PHPExcel_Style_Border::BORDER_THIN
            //             ),
            //         )
            //     )
            // );
            //SETTING CENTER ALLIGNMENT FOR PART
            //ISI No. mesin
            $objget->getStyle('JM4:KV6')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                    ),
                )
            );
            $objget->getStyle('JM4:KV6')->getAlignment()->setWrapText(true);

            //styling heading resource
            $objget->getStyle('JM7:KV7')->applyFromArray(
                array(
                    'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
            );

            //ISI Resource
            $objget->getStyle('JM8:KV8')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('JM8:KV8')->getAlignment()->setWrapText(true);
            
            $objget->getStyle('JM10:KV10')->applyFromArray(
                array(
                    'borders' => array(
                        'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'font' => array(
                        'color'=> array('000000'),
                        'bold' => true,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
            $objget->getStyle('JM10:KV10')->getAlignment()->setWrapText(true);

            $objget->getStyle('JM11:KV11')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );   
            
            $objget->getStyle('JM12:KV12')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );
            $objget->getStyle('JM11:KV11')->getAlignment()->setWrapText(true);

            $objget->getStyle('JM9:KV9')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );   

            //CREATE LOOPING NO. MESIN //nds

            $no=1;    
            for ($i= 4; $i < 10; $i++) { 
                $nmr_msn = $i-4;
                if ($nmr_msn < count($nm)) {
                    if ($nmr_msn < 3) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('JM'.$i, " ".$no.'.'.$nm[$nmr_msn]);
                    }else{
                        $j = $i-3;
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('KE'.$j, " ".$no.'.'.$nm[$nmr_msn]);
                    }
                }else{
                    if ($nmr_msn < 3) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('JM'.$i, '  -');
                    }else{
                        $j = $i-3;
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('KE'.$i, '  -');                    
                    }
                }
                $no++;
            }
            // die;     

            //CREATE LOOPING ALAT BANTU //nds
            $no=1;    
            for ($i= 10; $i < 13; $i++) { 
                $nmr_msn = $i-10;
                if ($nmr_msn < count($ab)) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ML'.$i, " ".$no.'.'.$ab[$nmr_msn]);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ML'.$i, '  -');
                }
                $no++;
            }

            //CREATE LOOPING TOOLS //nds
            $no=1;    
            for ($i= 4; $i < 9; $i++) { 
                $nmr_msn = $i-4;
                if ($nmr_msn < count($ab)) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ML'.$i, " ".$no.'.'.$tl[$nmr_msn]);
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ML'.$i, '  -');
                }
                $no++;
            }

            //PROCESS GROUPING//
            $objget->getStyle('KW2:MK2')->applyFromArray(
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
            //ALL BORDERS FOR PROCESS GROUPING
            $objget->getStyle('KW3:MK12')->applyFromArray(
                array(
                        // 'borders' => array(
                        // 'allborders' => array(
                        //     'style' => PHPExcel_Style_Border::BORDER_THIN
                        // ),
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => false,
                        ),
                    )
                );
            //SETTING CENTER ALLIGNMENT FOR PART
            //ISI Proses
            $objget->getStyle('KW4:MK4')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('KW4:MK4')->getAlignment()->setWrapText(true);

            //ISI Kode Proses
            $objget->getStyle('KW6:MK6')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('KW6:MK6')->getAlignment()->setWrapText(true);

            //ISI  Proses ke ... dari ...
            $objget->getStyle('KW8:MK8')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                    'color' => array('000000'),
                    'bold' => true,
                    ),
                )
            );
            $objget->getStyle('KW8:MK8')->getAlignment()->setWrapText(true);
            $objget->getStyle('KW7:MK7')->getAlignment()->setWrapText(true);

            //ISI Qty/Process
            $objget->getStyle('KW10:MK10')->applyFromArray(
                array(
                    'borders' => array(
                    'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                        ),
                    )
                );  
            $objget->getStyle('KW10:MK10')->getAlignment()->setWrapText(true);

            $objget->getStyle('KW9:MK9')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );  

            $objget->getStyle('KW11:MK11')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        )
                    )
                );  

            $objget->getStyle('KW12:MK12')->applyFromArray(
                array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                    ),
                )
            );  

            //TOOLS GROUPING 
            //ALL BORDERS FOR TOOLS
            $objget->getStyle('ML2:NX12')->applyFromArray(
                array(
                    // 'borders' => array(
                    //     'allborders' => array(
                    //         'style' => PHPExcel_Style_Border::BORDER_THIN
                    //     )
                    // ),
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

            $objget->getStyle('ML2:NX2')->applyFromArray(
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

            $objget->getStyle('ML9:NX9')->applyFromArray(
                array(
                    'borders' => array(
                        'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => false,
                    )
                )
            );

            $objget->getStyle('ML3:NX3')->applyFromArray(
                array(
                    'font' => array(
                        'color' => array('000000'),
                        'bold' => false,
                    )
                )
            );

            //SPECIAL FOR MEDIUM BORDER THICKNESS THEAD ELEMENTS TABLE
            $objget->getStyle('A15:A17')->applyFromArray(
                array(
                    'font' => array(
                    'color'=> array('000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                    ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                );

            $objget->getStyle('B15:M17')->applyFromArray(
                array(
                    'font' => array(
                    'color'=> array('000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                    ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                );
                    
            $objget->getStyle('N15:N17')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('rgb' => 'ffffff'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '000000')
                    )
                )
            );

            $objget->getStyle('O15:O17')->applyFromArray(
                array(
                    'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '00ff00')
                        )
                    )
                );

                $objget->getStyle('O15:O17')->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                                )   
                            )
                        )
                    );

            $objget->getStyle('P15:P17')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                    ),
                    'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '33ffff')
                        )
                    )
                );

//STYLING TABLE INFORMATIONS//
            $objget->getStyle('A2:P12')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
            );       
                //OVER HERE DUDE
            $objget->getStyle('A2:C12')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                );
                
            $objget->getStyle('I2:P4')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'fcf403')
                        ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                );  

            $objget->getStyle('D2:H12')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                );  
            
            //font sizing tulisan TSKK
            $objPHPExcel->getActiveSheet()->getStyle("I2:P4")->getFont()->setSize(16);
            $objPHPExcel->getActiveSheet()->getStyle("I5:P12")->getFont()->setSize(22);
            $objPHPExcel->getActiveSheet()->getStyle("B15:M17")->getFont()->setSize(17); 

            //KOTAK KETERANGAN
            $objget->getStyle('S2:DF11')->applyFromArray(
                array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => false,
                            ),
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'wraptext' => true
                            )
                        )
                ); 

                $objget->getStyle('S2:DF2')->applyFromArray(
                    array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        ),
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'a69bfa')
                        )
                    )
                ); 

                $objget->getStyle('DG3:FJ3')->applyFromArray( 
                    array(
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'a69bfa')
                        )
                    )
                ); 

                $objget->getStyle('DG2:FN3')->applyFromArray(
                    array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        ),
                        'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );    
                    
                $objget->getStyle('DG2:FJ2')->applyFromArray(
                    array(
                        'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold' => true,
                        ),
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'a69bfa')
                        )
                    )
                ); 
            
            // //TANGGAL REVISI
            $objget->getStyle('FK2:GM3')->applyFromArray(
                array(
                        'font' => array(
                            'color' => array('rgb' => '000000'),
                            'bold' => true,
                        ),
                        'fill' => array( 
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'a69bfa')
                        ),
                        'borders' => array(
                            'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        // 'wraptext' => true
                        )
                )
            ); 

            $objget->getStyle('GN2:NX2')->applyFromArray(
                array(
                    'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                    ),
                    'fill' => array( 
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'a69bfa')
                    )
                )
            );             

            $objget->getStyle('FK4:GM12')->applyFromArray(
                array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                )
            ); 

            // //MANUAL, AUTO, JALAN, CT, TT, MUDA
            $objget->getStyle('S3:BL5')->applyFromArray( 
                array(
                        'borders' => array(
                            'outline' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'font' => array(
                            'color' => array('rgb' => '000000'),
                            'bold' => false,
                        )
                    )
                ); 
            
            //KOTAK ITEM
            $objget->getStyle('V4:AL4')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '000000')
                        )
                    )
                ); 

            // $objget->getStyle('AP3:BL5')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

            $objget->getStyle('BM3:DF5')->applyFromArray( 
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 
             
            //KOTAK KUNING
            $objget->getStyle('BP4:CF4')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'fcf403')
                        )
                    )
                ); 

            //KOTAK IJO
            $objget->getStyle('V7:AL7')->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '00ff00')
                        )
                    )
                ); 
            
            $objget->getStyle('AP6:BL8')->getAlignment()->setWrapText(true);

            
                //KOTAK MUDA (MERAH)
                $objget->getStyle('BP10:CF10')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'fa3eef')
                            )
                        )
                    ); 

                //KOTAK TAKT TIME (MERAH)
                $objget->getStyle('BW6:BY8')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'fc0303')
                            )
                        )
                    ); 

                //KOTAK BIRU WALK
                $objget->getStyle('V10:AL10')->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '33ffff')
                            )
                        )
                    ); 

            // $objget->getStyle('CJ3:DF5')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

            $objget->getStyle('S6:BL8')->applyFromArray( 
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            // $objget->getStyle('AP6:BL8')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

            $objget->getStyle('BM6:DF8')->applyFromArray( 
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                );   
            
            //KOTAK KETERANGAN TAKT TIME
            // $objget->getStyle('CJ6:DF8')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     );  

            //KK 
            $objget->getStyle('S9:BL11')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            // $objget->getStyle('AP9:BL11')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

            $objget->getStyle('BM9:DF11')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 
                
            // $objget->getStyle('CJ9:DF11')->applyFromArray(
            //     array(
            //             'borders' => array(
            //             'outline' => array(
            //             'style' => PHPExcel_Style_Border::BORDER_THIN
            //                 )
            //             )
            //         )
            //     ); 

                $objget->getStyle('S12:DF12')->applyFromArray(
                    array(
                            'borders' => array(
                            'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            )
                        )
                    ); 
            //THE END OF KOTAK KETERANGAN//
            
            //KOTAK REVISI
            $objget->getStyle('DG2:FN2')->applyFromArray(
                array(
                        'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

            $objget->getStyle('DG3:FN12')->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    )
                ); 

        //GIVE BOLD BORDER IN KETERANGAN - TOOLS OUTLINE
        $objget->getStyle('S2:DF12')->applyFromArray( //KETERANGAN
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('DG2:GM12')->applyFromArray( //REVISI - TANGGAL
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('GN2:IA12')->applyFromArray( //PART
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('IB2:JL12')->applyFromArray( //SDM
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('JM2:KV12')->applyFromArray( //EQUIPMENT
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('KW2:MK12')->applyFromArray( //PROCESS
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objget->getStyle('ML2:NX12')->applyFromArray( //PROCESS
            array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )   
                    )
                )
            );

        $objPHPExcel->getActiveSheet()->getStyle("S2:NX12")->getFont()->setSize(12);


    //SET TAKT TIME ROWS//
    $kolomMerah = $this->Kolom($takt_time + 18);
    $tulisanTaktTime = $this->Kolom($takt_time + 21);
    $objget->getStyle($kolomMerah.'18:'.$kolomMerah.(($jml_baris * 3) + 20))->applyFromArray(
                array(
                    'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'eb4034')
                    )
                )
            );
    //tulisan takt time
    $objset->setCellValue($tulisanTaktTime.'31', "Takt Time = ".$takt_time." Detik");
    $objget->getStyle($tulisanTaktTime.'31')->applyFromArray(
        array(
            'font' => array(
                'color' => array('000000'),
                'bold' => true,
            ),
            // 'fill' => array(
            //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //     'color' => array('rgb' => 'eb4034')
            // )
        )
    );
    //SET TAKT TIME ROWS

    //BOLDING ALL THE TIME FLOW TABLE 
    $objget->getStyle('R15:'.$kolomEnd.(($jml_baris * 3) + 20))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 


    //SET THE VALUE OF TABLE CONTENT//
    $no = 1;
    $indexArr = 0;
    $defElementKerja = '';
    $indexElementKerja = 18; //TITIK MULAI HORIZONTAL DARI ROW KE 18
    $indexHitam = 19;  //TITIK VERTIKAL DIMULAI DARI DETIK KE-1
    $indexHijau = 0;
    $nLine = false;

    for ($i=18; $i < (18 + (sizeof($elemen_kerja) * 3)); $i+=3) { 
   
            $j = $jenis_proses[$indexArr];
            $tu = $tipe_urutan[$indexArr];
            $s = $start[$indexArr];
            $indexParalel = $s + 11;

                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                    $kolomEnd = $this->Kolom($end + 18);
                    $objget->getStyle('S'.($indexElementKerja + 2).':'.$kolomEnd.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'bottom' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  
    
            if ($j == 'MANUAL') {
                    if ($elemen_kerja[$indexArr] == $defElementKerja){

                        if ($tu = "PARALEL") { 
                            $objset->setCellValue("N".$indexElementKerja, $waktu[$indexArr]);
                                //TIME FLOW
                                $indexArrWaktu = 1;
                                $indexHitam = $s + 18;
                              
                                for ($angka = 0; $angka < $waktu[$indexArr]; $angka++) { 
                                    $kolom = $this->Kolom($indexHitam);
                                        if ($nLine) {

                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                                array(
                                                    'font' => array(
                                                    'color' => array('ffffff'),
                                                    'bold' => true,
                                                    ),
                                                )
                                            );
                                            //pararel //LET UNCOMMENT//
                                        // if ($angka == 0) {
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             )
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             ),
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        // }
                                        //BLACK STYLING//
                                        $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '000000')
                                                ),
                                                'font' => array(
                                                'color' => array('rgb' => 'ffffff'),
                                                )
                                            )
                                        );

                                        }else{
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                                array(
                                                    'font' => array(
                                                    'color' => array('ffffff'),
                                                    'bold' => true,
                                                    ),
                                                )
                                            );
                                                //pararel //LET UNCOMMENT//
                                            // if ($angka == 0) {
                                            //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                            //         array(
                                            //             'fill' => array(
                                            //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            //             'color' => array('rgb' => 'a6a6a6')
                                            //             )
                                            //         )
                                            //     );
                                            //     //tambahin lagi di sini keknya
                                            //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                            //         array(
                                            //             'fill' => array(
                                            //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            //             'color' => array('rgb' => 'a6a6a6')
                                            //             ),
                                            //         )
                                            //     );
                                            //     //tambahin lagi di sini keknya
                                            // }
                                            //BLACK STYLING//
                                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                                array(
                                                    'fill' => array(
                                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('rgb' => '000000')
                                                    ),
                                                    'font' => array(
                                                    'color' => array('rgb' => 'ffffff'),
                                                    )
                                                )
                                            );
                                        }
                    //LET UNCOMMENT//
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
                    // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                    //     $kolomAbu = $this->Kolom($indexHitam + 1);
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                    //                 array(
                    //                     'fill' => array(
                    //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                     'color' => array('rgb' => 'a6a6a6')
                    //                     )
                    //                 )
                    //             );

                    //     // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich buat paralel
                    //     //     array(
                    //     //         'fill' => array(
                    //     //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //     //         'color' => array('rgb' => 'a6a6a6')
                    //     //         ),
                    //     //     )
                    //     // );
                    // }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
    
                                $indexArrWaktu++;
                                $indexHitam++;
                                
                            //ngatur takt time
                            if ($indexHitam - 19 == $takt_time) {
                                $indexHitam = 19;
                            $nLine = true;
                            }
                            //ngatur takt time

                                } 
                                //over here gan
                                $objset->setCellValue("A".$indexElementKerja, $no++);
                                $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                                $indexArr++;
                                   
                                continue;
                        }

                        $objset->setCellValue("N".$indexElementKerja, $waktu[$indexArr]);
                        
                                //TIME FLOW
                                $indexArrWaktu = 1;
                                for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                    $kolom = $this->Kolom($indexHitam);

                                    if ($nLine) {
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);
                                    }else{
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);
                                    }

                                $indexArrWaktu++;
                                $indexHitam++;

                        //ngatur takt time
                            if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                            $nLine = true;
                            }
                        //ngatur takt time

                                } 
                                $indexArr++;
                                continue;
                    } 

                     if ($i !== 18) {$indexElementKerja += 3;}

                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                     if ($tu == "PARALEL") { 
                        $objset->setCellValue("N".$indexElementKerja, $waktu[$indexArr]);

                            //TIME FLOW
                            $indexArrWaktu = 1;
                            $indexArrMuda = 1;
                            $indexHitam = $s + 18; //imhere
                            $indexhitam2 = $indexHitam;

                            //SET MUDA// ---huehe
                            for ($f=0; $f < $muda[$indexArr]; $f++) { 
                                if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                                    if($muda[$indexArr] > 1){
                                            $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                                            $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                                                        array(
                                                            'fill' => array(
                                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                            'color' => array('rgb' => 'fa3eef')
                                                            ),
                                                            'font' => array(
                                                            'color' => array('ffffff')
                                                            )
                                                        )
                                                    );
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                                            $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                                                array(
                                                    'font' => array(
                                                    'color' => array('000000'),
                                                    'bold' => true,
                                                    ),
                                                )
                                            );
                                            $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                                                array(
                                                    'fill' => array(
                                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('rgb' => 'fa3eef')
                                                    ),
                                                )
                                            );         
                                    }
                                    $indexhitam2++;
                                }
                            }   
                            // die;
                            //SET MUDA//

                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) {                                 
                                $kolom = $this->Kolom($indexHitam);

                                if ($nLine) {
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'font' => array(
                                            'color' => array('ffffff')
                                            )
                                        )
                                    );
                                    //pararel  //LET UNCOMMENT//
                                    // if ($angka == 0) {
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             ),
                                    //         )
                                    //     );
                                    // }
                                    //BLACK STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '000000')
                                            ),
                                            'font' => array(
                                            'color' => array('rgb' => 'ffffff')
                                            )
                                        )
                                    );
                                }else{
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                    $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                        array(
                                            'font' => array(
                                            'color' => array('ffffff')
                                            )
                                        )
                                    );
                                    //pararel //LET UNCOMMENT//
                                    // if ($angka == 0) {
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             ),
                                    //         )
                                    //     );
                                    // }
                                    //BLACK STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '000000')
                                            ),
                                            'font' => array(
                                            'color' => array('rgb' => 'ffffff')
                                            )
                                        )
                                    );
                                }

                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS //LET UNCOMMENT//
                    // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                    //     $kolomAbu = $this->Kolom($indexHitam + 1);
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                    //                 array(
                    //                     'fill' => array(
                    //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                     'color' => array('rgb' => 'a6a6a6')
                    //                     )
                    //                 )
                    //             );
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray(
                    //         array(
                    //             'fill' => array(
                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //             'color' => array('rgb' => 'a6a6a6')
                    //             )
                    //         )
                    //     );
                    // }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                                
                            $indexArrWaktu++;
                            $indexHitam++;

                        //ngatur takt time
                            if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                            $nLine = true;
                            }
                        //ngatur takt time

                            } 
                            //over here gan//KEKNYA DI SINI
                            $nLine = false;

                            $objset->setCellValue("A".$indexElementKerja, $no++);
                            $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                            $indexArr++;
                               
                            continue;
                    }

                    $objset->setCellValue("N".$indexElementKerja, $waktu[$indexArr]);
                    //TIME FLOW MANUAL
                    $indexArrWaktu = 1;
                    $indexArrMuda = 1;
                    $indexHitam = $s + 18; //imhere
                    $indexhitam2 = $indexHitam;

                    //SET MUDA// ---huehe
                    for ($f=0; $f < $muda[$indexArr]; $f++) { 
                        if ($indexArr != 0) {
                            if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                                if($muda[$indexArr] > 1){
                                        $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                                        $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                                                    array(
                                                        'fill' => array(
                                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                        'color' => array('rgb' => 'fa3eef')
                                                        ),
                                                        'font' => array(
                                                        'color' => array('ffffff')
                                                        )
                                                    )
                                                );
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                                        $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                        $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => 'fa3eef')
                                                ),
                                            )
                                        ); 
                                }
                                $indexhitam2++;
                            }
                        }
                    }   
                    // die;
                    //SET MUDA//

                    for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom($indexHitam); 
                            if ($nLine) {
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                //BLACK STYLING//
                                $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '000000')
                                        ),
                                        'font' => array(
                                        'color' => array('rgb' => 'ffffff')
                                        )
                                    )
                                );
                            }else{
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                //BLACK STYLING//
                                $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '000000')
                                        ),
                                        'font' => array(
                                        'color' => array('rgb' => 'ffffff')
                                        )
                                    )
                                );
                            }
                            

                    //LET UNCOMMENT//
                    //  if ($angka == 0) {
                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                    //         array(
                    //             'fill' => array(
                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //             'color' => array('rgb' => 'a6a6a6')
                    //             )
                    //         )
                    //     );
                    // }
                    
                    //LET UNCOMMENT//
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                    // if($angka == $waktu[$indexArr] - 1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3)) ){ 
                    //     $kolomAbu = $this->Kolom($indexHitam + 1);
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                    //                 array(
                    //                     'fill' => array(
                    //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                     'color' => array('rgb' => 'a6a6a6')
                    //                     )
                    //                 )
                    //             );
                    //     $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich 
                    //         array(
                    //             'fill' => array(
                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //             'color' => array('rgb' => 'a6a6a6')
                    //             ),
                    //         )
                    //     );
                    // }elseif ($angka == 0 && $i != 18) {
                    //     $objget->getStyle($kolomAbu.($indexElementKerja ))->applyFromArray(
                    //         array(
                    //             'fill' => array(
                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //             'color' => array('rgb' => 'a6a6a6')
                    //             )
                    //         )
                    //     );
                    // }
                    //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                    $indexArrWaktu++;
                    $indexHitam++;

                        //ngatur takt time
                          if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                            $nLine = true;
                        }
                        //ngatur takt time
                    }
                    $nLine = false;
                    // echo $indexHitam;die(); 

            }elseif ($j == 'AUTO (Inheritance)') {
                    if ($elemen_kerja[$indexArr] == $defElementKerja){

                        $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);

                            //TIME FLOW//
                            $indexHijau = $indexHitam;
                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHijau);

                                if ($nLine) {
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));

                                    //GREEN STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '00ff00')
                                            )
                                        )
                                    );                                 
                                }else{
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), ($angka + 1));

                                    //GREEN STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '00ff00')
                                            )
                                        )
                                    ); 
                                }

                        $indexHijau++;

                            //ngatur takt time auto
                            if ($indexHijau - 19 == $takt_time) {
                                $indexHijau = 19;
                                $nLine = true;
                            } 
                            //ngatur takt time
                        }
                        
                        $indexArr++;
                        continue;
                    } 
                    $nLine = false;

                    if ($i !== 9) {$indexElementKerja += 3;}
                    $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);

                        //TIME FLOW//
                        $indexHijau = $indexHitam;
                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom(($indexParalel));

                        if ($nLine) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
                        
                            //GREEN STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00ff00')
                                    )
                                )
                            );  
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), ($angka + 1));
                        
                            //GREEN STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00ff00')
                                    )
                                )
                            );  
                        }
                      
                        $indexParalel++;
                        } 
                        $nLine = false;
                        $indexArr++;
                        continue;
            
            }else if ($j == "AUTO") {
                //here we go again//
                if ($elemen_kerja[$indexArr] == $defElementKerja){

                    if ($tu = "PARALEL") { 
                        $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);
                            //TIME FLOW
                            $indexArrWaktu = 1;
                            $indexHitam = $s + 18;
                          
                            for ($angka = 0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHitam);
                                    if ($nLine) {

                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                        $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                        //pararel //LET UNCOMMENT//
                                    // if ($angka == 0) {
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             )
                                    //         )
                                    //     );
                                    //     //tambahin lagi di sini keknya
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             ),
                                    //         )
                                    //     );
                                    //     //tambahin lagi di sini keknya
                                    // }
                                    //BLACK STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '00ff00')
                                            ),
                                            'font' => array(
                                            'color' => array('rgb' => '000000'),
                                            )
                                        )
                                    );

                                    }else{
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                        $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                            //pararel //LET UNCOMMENT//
                                        // if ($angka == 0) {
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             )
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             ),
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        // }
                                        //BLACK STYLING//
                                        $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '00ff00')
                                                ),
                                                'font' => array(
                                                'color' => array('rgb' => '000000'),
                                                )
                                            )
                                        );
                                    }
//LET UNCOMMENT//
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
                // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                //     $kolomAbu = $this->Kolom($indexHitam + 1);
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                //                 array(
                //                     'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => 'a6a6a6')
                //                     )
                //                 )
                //             );

                //     // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich buat paralel
                //     //     array(
                //     //         'fill' => array(
                //     //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     //         'color' => array('rgb' => 'a6a6a6')
                //     //         ),
                //     //     )
                //     // );

                // }
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)

                            $indexArrWaktu++;
                            $indexHitam++;
                            
                        //ngatur takt time
                        if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                        $nLine = true;
                        }
                        //ngatur takt time

                            } 

                            $objset->setCellValue("A".$indexElementKerja, $no++);
                            $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                            $indexArr++;
                               
                            continue;
                    }

                    $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);
                        
                            //TIME FLOW
                            $indexArrWaktu = 1;
                            for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHitam);

                                if ($nLine) {
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);
                                }else{
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);
                                }

                            $indexArrWaktu++;
                            $indexHitam++;

                    //ngatur takt time
                        if ($indexHitam - 19 == $takt_time) {
                        $indexHitam = 19;
                        $nLine = true;
                        }
                    //ngatur takt time

                            } 
                            $indexArr++;
                            continue;
                } 

                 if ($i !== 18) {$indexElementKerja += 3;}

            //STYLING
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
            $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
            $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
            $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

            $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
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

                $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
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

                $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            )
                        )
                    );  

                 if ($tu == "PARALEL") { 
                    $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);

                        //TIME FLOW
                        $indexArrWaktu = 1;
                        $indexArrMuda = 1;
                        $indexHitam = $s + 18; //imhere
                        $indexhitam2 = $indexHitam;

                        //SET MUDA// ---huehe
                        // for ($f=0; $f < $muda[$indexArr]; $f++) { 
                        //     if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                        //         if($muda[$indexArr] > 1){
                        //             $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                        //             $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                        //                         array(
                        //                             'fill' => array(
                        //                             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //                             'color' => array('rgb' => 'fa3eef')
                        //                             ),
                        //                             'font' => array(
                        //                             'color' => array('ffffff')
                        //                             )
                        //                         )
                        //                     );
                        //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                        //             $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                        //                 array(
                        //                     'font' => array(
                        //                     'color' => array('000000'),
                        //                     'bold' => true,
                        //                     ),
                        //                 )
                        //             );
                        //             $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                        //                 array(
                        //                     'fill' => array(
                        //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //                     'color' => array('rgb' => 'fa3eef')
                        //                     ),
                        //                 )
                        //             );
                        //         }
                        //         $indexhitam2++;
                        //     }
                        // }   
                        //SET MUDA//

                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom($indexHitam);

                            if ($nLine) {
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'font' => array(
                                        'color' => array('000000')
                                        )
                                    )
                                );
                                //pararel //LET UNCOMMENT//
                                // if ($angka == 0) {
                                //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                //         array(
                                //             'fill' => array(
                                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                //             'color' => array('rgb' => 'a6a6a6')
                                //             ),
                                //         )
                                //     );
                                // }
                                //BLACK STYLING//
                                $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '00ff00')
                                        ),
                                        'font' => array(
                                        'color' => array('rgb' => '000000')
                                        )
                                    )
                                );
                            }else{
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                    array(
                                        'font' => array(
                                        'color' => array('ffffff')
                                        )
                                    )
                                );
                                //pararel //LET UNCOMMENT//
                                // if ($angka == 0) {
                                //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                //         array(
                                //             'fill' => array(
                                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                //             'color' => array('rgb' => 'a6a6a6')
                                //             ),
                                //         )
                                //     );
                                // }
                                //BLACK STYLING//
                                $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                    array(
                                        'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '00ff00')
                                        ),
                                        'font' => array(
                                        'color' => array('rgb' => '000000')
                                        )
                                    )
                                );
                            }

                //LET UNCOMMENT//
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                //     $kolomAbu = $this->Kolom($indexHitam + 1);
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                //                 array(
                //                     'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => 'a6a6a6')
                //                     )
                //                 )
                //             );
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray(
                //         array(
                //             'fill' => array(
                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //             'color' => array('rgb' => 'a6a6a6')
                //             )
                //         )
                //     );
                // }
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                            
                        $indexArrWaktu++;
                        $indexHitam++;

                    //ngatur takt time
                        if ($indexHitam - 19 == $takt_time) {
                        $indexHitam = 19;
                        $nLine = true;
                        }
                    //ngatur takt time

                        } 
                        $nLine = false;

                        $objset->setCellValue("A".$indexElementKerja, $no++);
                        $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                        $indexArr++;
                           
                        continue;
                }

                $objset->setCellValue("O".$indexElementKerja, $waktu[$indexArr]);
                //TIME FLOW MANUAL
                $indexArrWaktu = 1;
                for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                        $kolom = $this->Kolom($indexHitam); 
                        if ($nLine) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                            //BLACK STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00ff00')
                                    ),
                                    'font' => array(
                                    'color' => array('rgb' => '000000')
                                    )
                                )
                            );
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                            //BLACK STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '00ff00')
                                    ),
                                    'font' => array(
                                    'color' => array('rgb' => '000000')
                                    )
                                )
                            );
                        }
                    // }
                
                //LET UNCOMMENT//
                //  if ($angka == 0) {
                //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                //         array(
                //             'fill' => array(
                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //             'color' => array('rgb' => 'a6a6a6')
                //             )
                //         )
                //     );
                // }
                
                //LET UNCOMMENT//
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                // if($angka == $waktu[$indexArr] - 1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3)) ){ 
                //     $kolomAbu = $this->Kolom($indexHitam + 1);
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                //                 array(
                //                     'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => 'a6a6a6')
                //                     )
                //                 )
                //             );
                //     // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich 
                //     //     array(
                //     //         'fill' => array(
                //     //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     //         'color' => array('rgb' => 'a6a6a6')
                //     //         ),
                //     //     )
                //     // );
                // }elseif ($angka == 0 && $i != 18) {
                //     $objget->getStyle($kolomAbu.($indexElementKerja ))->applyFromArray(
                //         array(
                //             'fill' => array(
                //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //             'color' => array('rgb' => 'a6a6a6')
                //             )
                //         )
                //     );
                // }
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                $indexArrWaktu++;
                $indexHitam++;

                    //ngatur takt time
                      if ($indexHitam - 19 == $takt_time) {
                        $indexHitam = 19;
                        $nLine = true;
                    }
                    //ngatur takt time
                }
                $nLine = false;
                // echo $indexHitam;die(); 

                //over here dude
            // }
            // else if ($j == "WALK (Inheritance)"){

            //     if ($elemen_kerja[$indexArr] == $defElementKerja){

            //         //STYLING
            //         $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
            //         $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
            //         $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
            //         $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
            //         $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK
    
            //         $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
            //             array(
            //                     'borders' => array(
            //                     'allborders' => array(
            //                     'style' => PHPExcel_Style_Border::BORDER_THIN
            //                         )
            //                     ),
            //                     'alignment' => array(
            //                         'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            //                         'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            //                     ),
            //                 )
            //             );  
    
            //             $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
            //                 array(
            //                         'borders' => array(
            //                         'allborders' => array(
            //                         'style' => PHPExcel_Style_Border::BORDER_THIN
            //                             )
            //                         ),
            //                         'alignment' => array(
            //                             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            //                             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            //                         )
            //                     )
            //                 );  
    
            //             $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
            //                 array(
            //                         'borders' => array(
            //                         'allborders' => array(
            //                         'style' => PHPExcel_Style_Border::BORDER_THIN
            //                             )
            //                         ),
            //                         'alignment' => array(
            //                             'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            //                         )
            //                     )
            //                 );  
    
            //              if ($tu == "PARALEL") { 
            //                 $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);
            //                     //TIME FLOW
            //                     $indexArrWaktu = 1;
            //                     $indexArrMuda = 1;
            //                     $indexHitam = $s + 18; //imhere
            //                     $indexhitam2 = $indexHitam;
    
            //                     //SET MUDA// ---huehe
            //                     for ($f=0; $f < $muda[$indexArr]; $f++) { 
            //                         if($muda[$indexArr] > 1){
            //                             $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
            //                             // echo $kolomMuda;die;
            //                             $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
            //                                         array(
            //                                             'fill' => array(
            //                                             'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                                             'color' => array('rgb' => 'fc0303')
            //                                             )
            //                                         )
            //                                     );
                
            //                             $objget->getStyle($kolomMuda.($indexElementKerja -1))->applyFromArray( //gua uncomment nich buat paralel
            //                                 array(
            //                                     'fill' => array(
            //                                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                                     'color' => array('rgb' => 'fc0303')
            //                                     ),
            //                                 )
            //                             );
            //                         }
            //                         $indexhitam2++;
            //                     }   
            //                     //SET MUDA//

            //                     for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
            //                         $kolom = $this->Kolom($indexParalel);
            //                         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);
                                    
            //                          //RED STYLING//
            //                          $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
            //                             array(
            //                                 'fill' => array(
            //                                 'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                                 'color' => array('rgb' => 'ff0000')
            //                                 )
            //                             )
            //                         );
    
            //                     $indexArrWaktu++;
            //                     $indexParalel++;
            //                     } 
    
            //                     $objset->setCellValue("A".$indexElementKerja, $no++);
            //                     $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
            //                     $indexArr++;
                                   
            //                     continue;
            //             }
    
            //                 $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);
                            
            //                 //TIME FLOW//
            //                 $indexHijau = $indexHitam;
            //                 for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
            //                     $kolom = $this->Kolom($indexHijau);
            //                     $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
    
            //                 //RED STYLING//
            //                 $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
            //                     array(
            //                         'fill' => array(
            //                         'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                         'color' => array('rgb' => 'ff0000')
            //                         )
            //                     )
            //                 );   
    
            //                 $indexHijau++;
            //                 $indexHitam++;

            //             //ngatur takt time
            //             if ($indexHitam - 19 == $takt_time) {
            //                 $indexHitam = 19;
            //                 $nLine = true;
            //             }
            //             //ngatur takt time   

            //                 } 
            //                 $indexArr++;
            //                 continue;
                       
            //             } 
            //             // if ($i !== 9) {$indexElementKerja += 3;}
            //             $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);
    
            //             //TIME FLOW//
            //             $indexHijau = $indexHitam;
            //             for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
            //                 $kolom = $this->Kolom(($indexParalel - 1));
            //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
                        
            //             //RED STYLING//
            //             $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
            //                 array(
            //                     'fill' => array(
            //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //                     'color' => array('rgb' => 'ff0000')
            //                     )
            //                 )
            //             );   

            //             $indexParalel++;
            //             } 
            //             $indexArr++;
            //             continue;

            //         $nLine = false;
            
            // //over here dude, good luck, muachhh WALK :*
            } else {
                    // if ($elemen_kerja[$indexArr] == $defElementKerja){

                    //     $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);

                    // //TIME FLOW//
                    // for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                    //     $kolom = $this->Kolom($indexHitam);

                    //     if ($nLine) {
                    //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), ($angka + 1));
                
                    //         //GREY STYLING//
                    //         $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                    //             array(
                    //                 'fill' => array(
                    //                 'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                 'color' => array('rgb' => '33ffff')
                    //                 ),
                    //                 'font' => array(
                    //                 'color' => array('rgb' => '000000')
                    //                 )
                    //             )
                    //         ); 
                    //     }else{
                    //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), ($angka + 1));
                
                    //         //GREY STYLING//
                    //         $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                    //             array(
                    //                 'fill' => array(
                    //                 'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    //                 'color' => array('rgb' => '33ffff')
                    //                 ),
                    //                 'font' => array(
                    //                 'color' => array('rgb' => '000000')
                    //                 )
                    //             )
                    //         );   
                    //     }

                    // $indexHitam++;

                    //     //ngatur takt time
                    //     if ($indexHitam - 19 == $takt_time) {
                    //         $indexHitam = 19;
                    //         $nLine = true;
                    //     }
                    //     //ngatur takt time

                    // } 
                    // $indexArr++;
                    // continue;
                    // $nLine = false;

                    // } 
                    if ($i !== 18) {$indexElementKerja += 3;}
                    
                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  

                    //begin dude//
                    if ($tu = "PARALEL") { 
                        $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);
                            //TIME FLOW
                            $indexArrWaktu = 1;
                            $indexArrMuda = 1;
                            $indexHitam = $s + 18; //imhere
                            $indexhitam2 = $indexHitam;

                            //SET MUDA// ---huehe
                            for ($f=0; $f < $muda[$indexArr]; $f++) { 
                                if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                                    if($muda[$indexArr] > 1){
                                        $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                                        // echo $kolomMuda;die;
                                        $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                                                    array(
                                                        'fill' => array(
                                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                        'color' => array('rgb' => 'fa3eef')
                                                        ),
                                                        'font' => array(
                                                        'color' => array('ffffff')
                                                        )
                                                    )
                                                );
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                                        $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                        $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => 'fa3eef')
                                                ),
                                            )
                                        );
                                    }
                                    $indexhitam2++;
                                }
                            }   
                            //SET MUDA//
                          
                            for ($angka = 0; $angka < $waktu[$indexArr]; $angka++) { 
                                $kolom = $this->Kolom($indexHitam);
                                    if ($nLine) {

                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrWaktu);

                                        $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                        //pararel
                                    // if ($angka == 0) {
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             )
                                    //         )
                                    //     );
                                    //     //tambahin lagi di sini keknya
                                    //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                    //         array(
                                    //             'fill' => array(
                                    //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    //             'color' => array('rgb' => 'a6a6a6')
                                    //             ),
                                    //         )
                                    //     );
                                    //     //tambahin lagi di sini keknya
                                    // }
                                    //BLACK STYLING//
                                    $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                        array(
                                            'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '33ffff')
                                            ),
                                            'font' => array(
                                            'color' => array('rgb' => '000000'),
                                            )
                                        )
                                    );

                                    }else{
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrWaktu);

                                        $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                            array(
                                                'font' => array(
                                                'color' => array('000000'),
                                                'bold' => true,
                                                ),
                                            )
                                        );
                                            //pararel
                                        // if ($angka == 0) {
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             )
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        //     $objget->getStyle($kolom.($indexElementKerja))->applyFromArray(
                                        //         array(
                                        //             'fill' => array(
                                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        //             'color' => array('rgb' => 'a6a6a6')
                                        //             ),
                                        //         )
                                        //     );
                                        //     //tambahin lagi di sini keknya
                                        // }
                                        //BLACK STYLING//
                                        $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                            array(
                                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '33ffff')
                                                ),
                                                'font' => array(
                                                'color' => array('rgb' => '000000'),
                                                )
                                            )
                                        );
                                    }

                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)
                // if($angka == $waktu[$indexArr] -1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                //     $kolomAbu = $this->Kolom($indexHitam + 1);
                //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                //                 array(
                //                     'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => 'a6a6a6')
                //                     )
                //                 )
                //             );

                //     // $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray( //gua uncomment nich buat paralel
                //     //     array(
                //     //         'fill' => array(
                //     //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     //         'color' => array('rgb' => 'a6a6a6')
                //     //         ),
                //     //     )
                //     // );

                // }
                //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS (AT THE END)

                            $indexArrWaktu++;
                            $indexHitam++;
                            
                        //ngatur takt time
                        if ($indexHitam - 19 == $takt_time) {
                            $indexHitam = 19;
                        $nLine = true;
                        }
                        //ngatur takt time

                            } 

                            $objset->setCellValue("A".$indexElementKerja, $no++);
                            $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
                            $indexArr++;
                               
                            continue;
                    }
                    $nLine = false;

                //last dude//

                    $objset->setCellValue("P".$indexElementKerja, $waktu[$indexArr]);

                        //TIME FLOW WALK
                        $indexArrAbu = 1;
                        $indexArrMuda = 1;
                        $indexHitam = $s + 18; //imhere
                        $indexhitam2 = $indexHitam;
    
                        //SET MUDA// ---huehe
                        for ($f=0; $f < $muda[$indexArr]; $f++) { 
                            if ($indexArr != 0) {
                                if ($finish[$indexArr-1] >= $start[$indexArr-1]) {
                                    if($muda[$indexArr] > 1){
                                            $kolomMuda = $this->Kolom($indexhitam2-$muda[$indexArr]);
                                            $objget->getStyle($kolomMuda.($indexElementKerja))->applyFromArray(
                                                        array(
                                                            'fill' => array(
                                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                            'color' => array('rgb' => 'fa3eef')
                                                            ),
                                                            'font' => array(
                                                            'color' => array('ffffff')
                                                            )
                                                        )
                                                    );
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolomMuda.($indexElementKerja-1), ' MUDA: '.$muda[$indexArr].' DETIK');
                                            $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray(
                                                array(
                                                    'font' => array(
                                                    'color' => array('000000'),
                                                    'bold' => true,
                                                    ),
                                                )
                                            );
                                            $objget->getStyle($kolomMuda.($indexElementKerja-1))->applyFromArray( 
                                                array(
                                                    'fill' => array(
                                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('rgb' => 'fa3eef')
                                                    ),
                                                )
                                            ); 
                                    }
                                    $indexhitam2++;
                                }
                            }
                        } 
                        //SET MUDA

                        for ($angka =  0; $angka < $waktu[$indexArr]; $angka++) { 
                            $kolom = $this->Kolom($indexHitam);
                        
                        if ($nLine = false) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 2), $indexArrAbu);
                    
                            //GREY STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 2))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '33ffff')
                                    ),
                                    'font' => array(
                                    'color' => array('rgb' => '000000')
                                    )
                                )
                            ); 
                        }else{
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.($indexElementKerja + 1), $indexArrAbu);
                    
                            //GREY STYLING//
                            $objget->getStyle($kolom.($indexElementKerja + 1))->applyFromArray(
                                array(
                                    'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '33ffff')
                                    ),
                                    'font' => array(
                                    'color' => array('rgb' => '000000')
                                    )
                                )
                            ); 
                        }
 
                        //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS
                        // if($angka == $waktu[$indexArr] - 1 && $i != (18 + ((sizeof($elemen_kerja) - 1) * 3))){
                        //     $kolomAbu = $this->Kolom($indexHitam + 1);
                        //     $objget->getStyle($kolomAbu.($indexElementKerja + 2))->applyFromArray(
                        //                 array(
                        //                     'fill' => array(
                        //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //                     'color' => array('rgb' => 'a6a6a6')
                        //                     )
                        //                 )
                        //             );
                        //     $objget->getStyle($kolomAbu.($indexElementKerja + 3))->applyFromArray(
                        //         array(
                        //             'fill' => array(
                        //             'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        //             'color' => array('rgb' => 'a6a6a6')
                        //             )
                        //         )
                        //     );
                        // }
                        //SET THE CONNECTION BETWEEN FINISH AND START ELEMENTS

                        $indexHitam++;
                        $indexArrAbu++;
                        $indexParalel++;

                            //ngatur takt time
                            if ($indexHitam - 19 == $takt_time) {
                                $indexHitam = 19;
                                $nLine = true;
                            }
                            //ngatur takt time
                    }
                $nLine = false;
            }

            if($elemen_kerja[$indexArr] != $defElementKerja){
                //STYLING
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexElementKerja.':A'.($indexElementKerja + 2)); //NOMOR
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexElementKerja.':M'.($indexElementKerja + 2)); //ELEMEN
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexElementKerja.':N'.($indexElementKerja + 2)); //MANUAL    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexElementKerja.':O'.($indexElementKerja + 2)); //AUTO
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexElementKerja.':P'.($indexElementKerja + 2)); //WALK

                $objget->getStyle('N'.$indexElementKerja.':P'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('A'.$indexElementKerja.':A'.($indexElementKerja + 2))->applyFromArray(
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

                    $objget->getStyle('B'.$indexElementKerja.':M'.($indexElementKerja + 2))->applyFromArray(
                        array(
                                'borders' => array(
                                'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                )
                            )
                        );  
                //STYLING
                $objset->setCellValue("A".$indexElementKerja, $no++);
                $objset->setCellValue("B".$indexElementKerja, $elemen_kerja[$indexArr]);
            }
            $defElementKerja = $elemen_kerja[$indexArr];
            $indexArr++;
        };//die();
        // $objPHPExcel->getActiveSheet()->mergeCells('C12:F13'); //ELEMEN KERJA

        //SET TOTAL TIMES//
        $indexJml = $indexElementKerja + 3;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexJml.':M'.($indexJml + 2)); 
        $objset->setCellValue("A".$indexJml, "JUMLAH");
        $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexJml.':N'.($indexJml + 1)); 
        $objset->setCellValue("N".$indexJml, $jumlah_manual);
        $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexJml.':O'.($indexJml + 1)); 
        $objset->setCellValue("O".$indexJml, $jumlah_auto);
        $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexJml.':P'.($indexJml + 1)); 
        $objset->setCellValue("P".$indexJml, $jumlah_walk);
        $objPHPExcel->getActiveSheet()->mergeCells('N'.($indexJml + 2).':P'.($indexJml + 2)); 
        $objset->setCellValue("N".($indexJml + 2), $jumlah);

        // $objPHPExcel->getActiveSheet()->mergeCells('K'.$indexJml.':'.($kolomB + 2)); 
        // $objset->setCellValue("K".$indexJml, "CATATAN:");

        //STYLING OF TOTAL TIMES//
        $objget->getStyle('A'.$indexJml.':M'.($indexJml + 2))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );  

        $objget->getStyle('N'.$indexJml.':N'.($indexJml + 1))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );  


        $objget->getStyle('O'.$indexJml.':O'.($indexJml + 1))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );          

        $objget->getStyle('P'.$indexJml.':P'.($indexJml + 1))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );          

        $objget->getStyle('N'.($indexJml + 2).':P'.($indexJml + 2))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
            ) 
        );

        //BOLDING THE OUTLINE BORDER FOR ELEMENTS TABLE//
        $objget->getStyle('A15'.':P'.($indexJml + 2))->applyFromArray(
            array(
                    'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                        )
                    )
                )
            ); 

        //SELECT DATA IRREGULAR JOBS
        $data['lihat_irregular_jobs'] = $this->M_gentskk->selectIrregularJobs($id_tskk);
        // echo"<pre>";print_r($data['lihat_irregular_jobs']);
        // die;

        //SET IRREGULAR JOB//
        $indexIrregular = $indexJml + 4;
        $indexIsiKiriIrregular  = $indexIrregular + 3;
        $indexIsiKananIrregular = $indexIrregular + 4;
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$indexIrregular.':A'.($indexIrregular + 2)); 
        $objset->setCellValue("A".$indexIrregular, "NO");
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$indexIrregular.':M'.($indexIrregular + 2)); 
        $objset->setCellValue("B".$indexIrregular, "Irregular Job");
        $objPHPExcel->getActiveSheet()->mergeCells('N'.$indexIrregular.':N'.($indexIrregular + 1)); 
        $objset->setCellValue("N".$indexIrregular, "Ratio");
        $objPHPExcel->getActiveSheet()->mergeCells('O'.$indexIrregular.':O'.($indexIrregular + 1)); 
        $objset->setCellValue("O".$indexIrregular, "Waktu");
        $objPHPExcel->getActiveSheet()->mergeCells('P'.$indexIrregular.':P'.($indexIrregular + 1));
        $objset->setCellValue("P".$indexIrregular, "Waktu/    Ratio");
        $objget->getStyle('P'.$indexIrregular.':P'.($indexIrregular + 1))->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->mergeCells('N'.($indexIrregular + 2).':N'.($indexIrregular + 2)); 
        $objset->setCellValue("N".($indexIrregular + 2), "Kali");
        $objPHPExcel->getActiveSheet()->mergeCells('O'.($indexIrregular + 2).':P'.($indexIrregular + 2)); 
        $objset->setCellValue("O".($indexIrregular + 2), "Detik");

        //buat isinye irregular job ye// which is cycle time flow
        if (!empty($data['lihat_irregular_jobs'])) {
            $number = 1;
            $pointKiri   = $indexIrregular + 3;
            $pointKanan  = $indexIrregular + 4;
            $jumlahKiri  = ($indexIrregular + 3) + (count($data['lihat_irregular_jobs']) * 2);
            $jumlahKanan = $jumlahKiri + 1;
            
            //SET IRREGULAR JOB TIME FLOW
            $jumlah_hasil_irregular = array_sum($hasil_irregular);
                // TIME FLOW
                $indexArr = 0;
                $indexArrWaktu = 1;
                $indexIrregularJob = $last_finish + 1;
                $irregularJobPoint = $jumlah_hasil_irregular;
                $indexIJ = $indexIrregularJob + 18;
                $indexCT = $indexIrregularJob - $jumlah_hasil_irregular - 10;

                for ($angka =  0; $angka < $irregularJobPoint; $angka++) { 
                    $kolom = $this->Kolom($indexIJ);

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($kolom.(18), $indexArrWaktu);
                        //BLUE STYLING//
                        $objget->getStyle($kolom.(18))->applyFromArray(
                            array(
                                'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '2a61ad') //dark blue 
                                ),
                                'font' => array(
                                'color' => array('rgb' => 'ffffff'),
                                )
                            )
                        );

                    $indexIJ++;
                    $indexArrWaktu++;
                }
                $indexArr++;

                // $kolomTeksIrregular = $this->Kolom($indexIJ + 1);
                // $objset->setCellValue($kolomTeksIrregular.'18', "Irregular Job = ".$jumlah_hasil_irregular." Detik");
                // $objget->getStyle($kolomTeksIrregular.'18')->applyFromArray(
                //     array(
                //         'font' => array(
                //         'color' => array('000000'),
                //         'bold' => true,
                //         ),
                //     )
                // ); //awokawok

                $kolomTeksCycleTime = $this->Kolom($indexIJ);
                $objset->setCellValue($kolomTeksCycleTime.'18', "Cycle Time = ".$cycle_time." Detik"); //need to be merge
                $objget->getStyle($kolomTeksCycleTime.'18')->applyFromArray(
                    array(
                        'font' => array(
                        'color' => array('000000'),
                        'bold' => true,
                        ),
                    )
                );

                //SET CYCLE TIME ROWS
                $kolomKuning    = $this->Kolom($cycle_time + 18);
                $kolomCycleTime = $this->Kolom($cycleTimeText + 18);
                $objget->getStyle($kolomKuning.'18:'.$kolomKuning.'20')->applyFromArray(
                    array(
                        'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'fcf403')
                        )
                    )
                );
                //SET CYCLE TIME ROWS
            
            //SET IRREGULAR JOB ELEMENTS
            foreach ($data['lihat_irregular_jobs'] as $irr) {
                $objPHPExcel->getActiveSheet()->mergeCells('A'.($pointKiri).':A'.($pointKanan)); 
                $objset->setCellValue("A".($pointKiri), $number);
    
                $objPHPExcel->getActiveSheet()->mergeCells('B'.($pointKiri).':M'.($pointKanan)); 
                $objset->setCellValue("B".($pointKiri), "   ".$irr['irregular_job']);    
                
                $objPHPExcel->getActiveSheet()->mergeCells('N'.($pointKiri).':N'.($pointKanan)); 
                $objset->setCellValue("N".($pointKiri), $irr['ratio']);
    
                $objPHPExcel->getActiveSheet()->mergeCells('O'.($pointKiri).':O'.($pointKanan)); 
                $objset->setCellValue("O".($pointKiri), $irr['waktu']);
    
                $objPHPExcel->getActiveSheet()->mergeCells('P'.($pointKiri).':P'.($pointKanan)); 
                $objset->setCellValue("P".($pointKiri), $irr['hasil_irregular_job']);
    
                //STYLING
                $objget->getStyle('A'.($pointKiri).':A'.($pointKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        )
                    ); 
    
                $objget->getStyle('B'.($pointKiri).':M'.($pointKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        )
                    ); 
    
    
                $objget->getStyle('N'.($pointKiri).':P'.($pointKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        )
                    ); 
            
                //JUMLAH IRREGULAR JOB
                $objPHPExcel->getActiveSheet()->mergeCells('A'.($jumlahKiri).':O'.($jumlahKanan)); 
                $objset->setCellValue("A".($jumlahKiri), "JUMLAH");
    
                $objPHPExcel->getActiveSheet()->mergeCells('P'.($jumlahKiri).':P'.($jumlahKanan)); 
                $objset->setCellValue("P".($jumlahKiri), $jumlah_hasil_irregular);
    
                //STYLING JUMLAH
                $objget->getStyle('A'.($jumlahKiri).':O'.($jumlahKanan))->applyFromArray(
                    array(
                            'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                                )
                            ),
                            'alignment' => array(
                                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                            ),
                        )
                    ); 
    
                $objget->getStyle('P'.($jumlahKiri).':P'.($jumlahKanan))->applyFromArray(
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
    
            $number++;
            $pointKiri+=2;
            $pointKanan+=2;
            }        
        }else{
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($indexIrregular+3).':A'.($indexIrregular+4)); 
            $objset->setCellValue("A".($indexIrregular+3), " ");

            $objPHPExcel->getActiveSheet()->mergeCells('B'.($indexIrregular+3).':M'.($indexIrregular+4)); 
            $objset->setCellValue("B".($indexIrregular+3), " ");    
            
            $objPHPExcel->getActiveSheet()->mergeCells('N'.($indexIrregular+3).':N'.($indexIrregular+4)); 
            $objset->setCellValue("N".($indexIrregular+3), " ");

            $objPHPExcel->getActiveSheet()->mergeCells('O'.($indexIrregular+3).':O'.($indexIrregular+4)); 
            $objset->setCellValue("O".($indexIrregular+3), " ");

            $objPHPExcel->getActiveSheet()->mergeCells('P'.($indexIrregular+3).':P'.($indexIrregular+4)); 
            $objset->setCellValue("P".($indexIrregular+3), " ");

            //STYLING
            $objget->getStyle('A'.($indexIrregular+3).':A'.($indexIrregular+4))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                ); 

            $objget->getStyle('B'.($indexIrregular+3).':M'.($indexIrregular+4))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                ); 


            $objget->getStyle('N'.($indexIrregular+3).':P'.($indexIrregular+4))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                ); 
        
            //JUMLAH IRREGULAR JOB
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($indexIrregular+5).':O'.($indexIrregular+6)); 
            $objset->setCellValue("A".($indexIrregular+5), "JUMLAH");

            $objPHPExcel->getActiveSheet()->mergeCells('P'.($indexIrregular+5).':P'.($indexIrregular+6)); 
            $objset->setCellValue("P".($indexIrregular+5), " ");

            //STYLING JUMLAH
            $objget->getStyle('A'.($indexIrregular+5).':O'.($indexIrregular+6))->applyFromArray(
                array(
                        'borders' => array(
                        'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                        ),
                    )
                ); 

            $objget->getStyle('P'.($indexIrregular+5).':P'.($indexIrregular+6))->applyFromArray(
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
        }


       //STYLING IRREGULAR JOBS//
        $objget->getStyle('A'.$indexIrregular.':M'.($indexIrregular + 2))->applyFromArray(
            array(                        
                    'font' => array(
                        'color' => array('rgb' => 'ffffff'),
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
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '2810e0')
                    )
                )
            ); 

        $objget->getStyle('N'.$indexIrregular.':P'.($indexIrregular + 2))->applyFromArray(
            array(
                    'borders' => array(
                    'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'a69bfa')
                    )
                )
            ); 

    //KETERANGAN// 
    $objPHPExcel->getActiveSheet()->mergeCells('R'.$indexJml.':DX'.($indexJml));   
    $objset->setCellValue("R".$indexJml, "   1. Keterangan");
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 1).':DX'.($indexJml + 1));   

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 2).':BZ'.($indexJml + 2));   //Waktu 1 Shift
    $objset->setCellValue("R".($indexJml + 2), "   - Waktu 1 Shift");
        $objget->getStyle('R'.($indexJml + 2).':DX'.($indexJml + 2))->applyFromArray(
        array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 2).':CC'.($indexJml + 2));   
    $objset->setCellValue("CA".($indexJml + 2), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 2).':DC'.($indexJml + 2));   
    $objset->setCellValue("CD".($indexJml + 2), $waktu_satu_shift); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 2).':DR'.($indexJml + 2));   
    $objset->setCellValue("DD".($indexJml + 2), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 2).':DX'.($indexJml + 2));   

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 3).':BZ'.($indexJml + 3));  //Cycle Time (Tanpa Irregular Job) 
    $objset->setCellValue("R".($indexJml + 3), "   - Cycle Time (Dengan Irregular Job)");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 3).':CC'.($indexJml + 3));   
    $objset->setCellValue("CA".($indexJml + 3), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 3).':DC'.($indexJml + 3));   
    $objset->setCellValue("CD".($indexJml + 3), $cycle_time);
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 3).':DR'.($indexJml + 3));   
    $objset->setCellValue("DD".($indexJml + 3), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 3).':DX'.($indexJml + 3));  

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 4).':BZ'.($indexJml + 4));  //Jumlah Hari Kerja / Bulan 
    $objset->setCellValue("R".($indexJml + 4), "   - Jumlah Hari Kerja / Bulan");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 4).':CC'.($indexJml + 4));   
    $objset->setCellValue("CA".($indexJml + 4), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 4).':DC'.($indexJml + 4));   
    // $objset->setCellValue("CD".($indexJml + 4), number_format($jumlah_hari_kerja)); //idk
    $objset->setCellValue("CD".($indexJml + 4), $jumlah_hari_kerja); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 4).':DR'.($indexJml + 4));   
    $objset->setCellValue("DD".($indexJml + 4), "Hari");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 4).':DX'.($indexJml + 4)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 5).':BZ'.($indexJml + 5));  //Forecast 
    $objset->setCellValue("R".($indexJml + 5), "   - Forecast");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 5).':CC'.($indexJml + 5));   
    $objset->setCellValue("CA".($indexJml + 5), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 5).':DC'.($indexJml + 5));   
    $objset->setCellValue("CD".($indexJml + 5), $forecast);
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 5).':DR'.($indexJml + 5));   
    $objset->setCellValue("DD".($indexJml + 5), "Unit");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 5).':DX'.($indexJml + 5)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 6).':BZ'.($indexJml + 6));  //Qty/Unit 
    $objset->setCellValue("R".($indexJml + 6), "   - Qty / Unit");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml + 6).':CC'.($indexJml + 6));   
    $objset->setCellValue("CA".($indexJml + 6), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml + 6).':DC'.($indexJml + 6));   
    $objset->setCellValue("CD".($indexJml + 6), $qty_unit);
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml + 6).':DR'.($indexJml + 6));   
    $objset->setCellValue("DD".($indexJml + 6), " ");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml + 6).':DX'.($indexJml + 6)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml + 7).':BZ'.($indexJml +7));  //Rencana Produksi / Bulan 
    $objset->setCellValue("R".($indexJml +7), "   - Rencana Produksi / Bulan");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +7).':CC'.($indexJml +7));   
    $objset->setCellValue("CA".($indexJml +7), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +7).':DC'.($indexJml +7));   
    $objset->setCellValue("CD".($indexJml +7), $rencana_produksi);
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +7).':DR'.($indexJml +7));   
    $objset->setCellValue("DD".($indexJml +7), "Pcs");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +7).':DX'.($indexJml +7)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +8).':BZ'.($indexJml +8));  //Takt Time 
    $objset->setCellValue("R".($indexJml +8), "   - Takt Time");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +8).':CC'.($indexJml +8));   
    $objset->setCellValue("CA".($indexJml +8), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +8).':DC'.($indexJml +8));   
    $objset->setCellValue("CD".($indexJml +8), $takt_time); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +8).':DR'.($indexJml +8));   
    $objset->setCellValue("DD".($indexJml +8), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +8).':DX'.($indexJml +8)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +9).':BZ'.($indexJml +9));  //Qty dalam 1 Cycle 
    $objset->setCellValue("R".($indexJml +9), "   - Qty dalam 1 Cycle");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +9).':CC'.($indexJml +9));   
    $objset->setCellValue("CA".($indexJml +9), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +9).':DC'.($indexJml +9));   
    $objset->setCellValue("CD".($indexJml +9), " ");
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +9).':DR'.($indexJml +9));   
    $objset->setCellValue("DD".($indexJml +9), "Pcs");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +9).':DX'.($indexJml +9)); 

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +10).':BZ'.($indexJml +10));  //Handling Time
    $objset->setCellValue("R".($indexJml +10), "   - Handling Time [Σ(Manual + Walk)]");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +10).':CC'.($indexJml +10));   
    $objset->setCellValue("CA".($indexJml +10), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +10).':DC'.($indexJml +10));   
    $objset->setCellValue("CD".($indexJml +10), ($jumlah_manual + $jumlah_walk)); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +10).':DR'.($indexJml +10));   
    $objset->setCellValue("DD".($indexJml +10), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +10).':DX'.($indexJml +10));    

    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +11).':BZ'.($indexJml +11));  //Machining Time
    $objset->setCellValue("R".($indexJml +11), "   - Machining Time [Σ Auto]");
    $objPHPExcel->getActiveSheet()->mergeCells('CA'.($indexJml +11).':CC'.($indexJml +11));   
    $objset->setCellValue("CA".($indexJml +11), "=");
    $objPHPExcel->getActiveSheet()->mergeCells('CD'.($indexJml +11).':DC'.($indexJml +11));   
    $objset->setCellValue("CD".($indexJml +11), $jumlah_auto); //idk
    $objPHPExcel->getActiveSheet()->mergeCells('DD'.($indexJml +11).':DR'.($indexJml +11));   
    $objset->setCellValue("DD".($indexJml +11), "Detik");
    $objPHPExcel->getActiveSheet()->mergeCells('DS'.($indexJml +11).':DX'.($indexJml +11));    

    //SET A BOX FOR NOTES (13 - 21)
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +13).':IN'.($indexJml +13));    
    $objset->setCellValue('R'.($indexJml +13), "   CATATAN :");
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +14).':IN'.($indexJml +14));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +15).':IN'.($indexJml +15));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +16).':IN'.($indexJml +16));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +17).':IN'.($indexJml +17));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +18).':IN'.($indexJml +18));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +19).':IN'.($indexJml +19));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +20).':IN'.($indexJml +20));    
    $objPHPExcel->getActiveSheet()->mergeCells('R'.($indexJml +21).':IN'.($indexJml +21));      

    $objget->getStyle('R'.($indexJml +13).':IN'.($indexJml +21))->applyFromArray(
        array(                
                'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                ),
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    $objget->getStyle('A'.$indexIrregular.':P'.($indexIrregular + 17))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    $objget->getStyle('R'.$indexJml.':DX'.($indexJml + 11))->applyFromArray(
        array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        ); 

    $objget->getStyle('CD'.($indexJml + 2).':DC'.($indexJml + 11))->applyFromArray(
        array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        ); 

    //THE END OF KETERANGAN STYLING 

    //BOLDING SIGNATURE OUTLINE
    $objget->getStyle('IO'.($indexJml +13).':NX'.($indexJml +21))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    //PERHITUNGAN TAKT TIME//
    $objPHPExcel->getActiveSheet()->mergeCells('DY'.$indexJml.':IN'.($indexJml));   
    $objset->setCellValue("DY".$indexJml, "   2. Perhitungan Takt Time");
    $objget->getStyle('DY'.$indexJml.':IN'.($indexJml))->applyFromArray(
        array(
            'borders' => array(
                'top' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )  
        )
    ); 
    $objPHPExcel->getActiveSheet()->mergeCells('DY'.($indexJml + 1).':IN'.($indexJml + 1)); 

    $objPHPExcel->getActiveSheet()->mergeCells('DY'.($indexJml + 2).':FI'.($indexJml + 4)); 
    $objPHPExcel->getActiveSheet()->mergeCells('IM'.($indexJml + 2).':IN'.($indexJml + 4)); 
    $objset->setCellValue("DY".($indexJml + 2), "Takt Time");
    $objget->getStyle('DY'.($indexJml + 2).':FI'.($indexJml + 4))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    ); 

    $objPHPExcel->getActiveSheet()->mergeCells('FJ'.($indexJml + 2).':FN'.($indexJml + 4)); 
    $objset->setCellValue("FJ".($indexJml + 2), "=");
    $objget->getStyle('FJ'.($indexJml + 2).':FN'.($indexJml + 4))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FQ'.($indexJml + 3).':FQ'.($indexJml + 4)); 
    $objset->setCellValue("FQ".($indexJml + 3), "(");
    $objget->getStyle('FQ'.($indexJml + 3).':FQ'.($indexJml + 4))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('IJ'.($indexJml + 3).':IJ'.($indexJml + 4)); 
    $objset->setCellValue("IJ".($indexJml + 3), ")");
    $objget->getStyle('IJ'.($indexJml + 3).':IJ'.($indexJml + 4))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FO'.($indexJml + 2).':IL'.($indexJml + 2));  
    $objset->setCellValue("FO".($indexJml + 2), "Waktu 1 Shift");
        $objget->getStyle('FO'.($indexJml + 2).':IL'.($indexJml + 2))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        );   

    $objPHPExcel->getActiveSheet()->mergeCells('FS'.($indexJml + 3).':IH'.($indexJml + 3));  
    $objset->setCellValue("FS".($indexJml + 3), "Rencana Produksi / Bulan");
        $objget->getStyle('FS'.($indexJml + 3).':IH'.($indexJml + 3))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 
        
    $objPHPExcel->getActiveSheet()->mergeCells('FS'.($indexJml + 4).':IH'.($indexJml + 4));  
    $objset->setCellValue("FS".($indexJml + 4), "Jumlah Hari Kerja / Bulan");
        $objget->getStyle('FS'.($indexJml + 4).':IH'.($indexJml + 4))->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 

//just change the position
    $objPHPExcel->getActiveSheet()->mergeCells('FJ'.($indexJml + 6).':FN'.($indexJml + 8)); 
    $objset->setCellValue("FJ".($indexJml + 6), "=");
    $objget->getStyle('FJ'.($indexJml + 6).':FN'.($indexJml + 8))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FQ'.($indexJml + 7).':FQ'.($indexJml + 8)); 
    $objset->setCellValue("FQ".($indexJml + 7), "(");
    $objget->getStyle('FQ'.($indexJml + 7).':FQ'.($indexJml + 8))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('IJ'.($indexJml + 7).':IJ'.($indexJml + 8)); 
    $objset->setCellValue("IJ".($indexJml + 7), ")");
    $objget->getStyle('IJ'.($indexJml + 7).':IJ'.($indexJml + 8))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FO'.($indexJml + 6).':IL'.($indexJml + 6));  
    $objset->setCellValue("FO".($indexJml + 6), $waktu_satu_shift." detik");
        $objget->getStyle('FO'.($indexJml + 6).':IL'.($indexJml + 6))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        );   

    $objPHPExcel->getActiveSheet()->mergeCells('FS'.($indexJml + 7).':IH'.($indexJml + 7));  
    $objset->setCellValue("FS".($indexJml + 7), $rencana_produksi);
        $objget->getStyle('FS'.($indexJml + 7).':IH'.($indexJml + 7))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 
        
    $objPHPExcel->getActiveSheet()->mergeCells('FS'.($indexJml + 8).':IH'.($indexJml + 8));  
    $objset->setCellValue("FS".($indexJml + 8), $jumlah_hari_kerja);
        $objget->getStyle('FS'.($indexJml + 8).':IH'.($indexJml + 8))->applyFromArray(
            array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 

    $objPHPExcel->getActiveSheet()->mergeCells('FJ'.($indexJml + 9).':FN'.($indexJml + 9)); 
    $objset->setCellValue("FJ".($indexJml + 9), "=");
    $objget->getStyle('FJ'.($indexJml + 9).':FN'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('FO'.($indexJml + 9).':GH'.($indexJml + 9)); 
    $objset->setCellValue("FO".($indexJml + 9), $takt_time);
    $objget->getStyle('FO'.($indexJml + 9).':GH'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('GI'.($indexJml + 9).':GZ'.($indexJml + 9)); 
    $objset->setCellValue("GI".($indexJml + 9), "Detik");
    $objget->getStyle('GI'.($indexJml + 9).':GZ'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objget->getStyle('DY'.$indexJml.':IN'.($indexJml + 11))->applyFromArray(
        array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    //THE END OF PERHITUNGAN TAKT TIME

    //3. TARGET//
    $objPHPExcel->getActiveSheet()->mergeCells('IO'.$indexJml.':NX'.($indexJml));   
    $objset->setCellValue("IO".$indexJml, "   3. Jumlah Pcs yang dihasilkan dalam 1 shift");
    $objget->getStyle('IO'.$indexJml.':NX'.($indexJml))->applyFromArray(
        array(
            'borders' => array(
                'top' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )  
        )
    ); 
    $objPHPExcel->getActiveSheet()->mergeCells('IO'.($indexJml + 1).':NX'.($indexJml + 1)); 

    $objPHPExcel->getActiveSheet()->mergeCells('IO'.($indexJml + 2).':JY'.($indexJml + 3)); 
    $objset->setCellValue("IO".($indexJml + 2), "Pcs / Shift");
    $objget->getStyle('IO'.($indexJml + 2).':JY'.($indexJml + 3))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    ); 

    $objPHPExcel->getActiveSheet()->mergeCells('JZ'.($indexJml + 2).':KD'.($indexJml + 3)); 
    $objset->setCellValue("JZ".($indexJml + 2), "=");
    $objget->getStyle('JZ'.($indexJml + 2).':KD'.($indexJml + 3))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 2).':NM'.($indexJml + 2));  
    $objset->setCellValue("KE".($indexJml + 2), "Waktu 1 Shift x Quantity");
        $objget->getStyle('KE'.($indexJml + 2).':NM'.($indexJml + 2))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        );   

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 3).':NM'.($indexJml + 3));  
    $objset->setCellValue("KE".($indexJml + 3), "Cycle Time (Dengan Irregular Job)");
        $objget->getStyle('KE'.($indexJml + 3).':NM'.($indexJml + 3))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 
        
    $objPHPExcel->getActiveSheet()->mergeCells('JZ'.($indexJml + 6).':KD'.($indexJml +7)); 
    $objset->setCellValue("JZ".($indexJml + 6), "=");
    $objget->getStyle('JZ'.($indexJml + 6).':KD'.($indexJml +7))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 6).':NM'.($indexJml + 6));  
    $objset->setCellValue("KE".($indexJml + 6), $waktu_satu_shift."       x       ".$qty_unit);
        $objget->getStyle('KE'.($indexJml + 6).':NM'.($indexJml + 6))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        );   

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 7).':NM'.($indexJml + 7));  
    $objset->setCellValue("KE".($indexJml + 7), $cycle_time);
        $objget->getStyle('KE'.($indexJml + 7).':NM'.($indexJml + 7))->applyFromArray(
            array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )  
            )
        ); 

    $objPHPExcel->getActiveSheet()->mergeCells('JZ'.($indexJml + 9).':KD'.($indexJml + 9)); 
    $objset->setCellValue("JZ".($indexJml + 9), "=");
    $objget->getStyle('JZ'.($indexJml + 9).':KD'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

        //CALCULATION FOR TARGET
        $atas   = $waktu_satu_shift * $qty_unit;
        $target = $atas / $cycle_time;
        $target_result = floor($target);
        // echo"<pre>"; echo $target;
        // die;

    $objPHPExcel->getActiveSheet()->mergeCells('KE'.($indexJml + 9).':LB'.($indexJml + 9)); 
    $objset->setCellValue("KE".($indexJml + 9), $target_result);
    $objget->getStyle('KE'.($indexJml + 9).':LB'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objPHPExcel->getActiveSheet()->mergeCells('LC'.($indexJml + 9).':LQ'.($indexJml + 9)); 
    $objset->setCellValue("LC".($indexJml + 9), "Pcs");
    $objget->getStyle('LC'.($indexJml + 9).':LQ'.($indexJml + 9))->applyFromArray(
        array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )  
        )
    );

    $objget->getStyle('IO'.$indexJml.':NX'.($indexJml + 11))->applyFromArray(
        array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        ); 

    $objPHPExcel->getActiveSheet()->mergeCells('NN'.($indexJml + 2).':NX'.($indexJml + 2));   
    $objget->getStyle('NN'.($indexJml + 2).':NX'.($indexJml + 2))->applyFromArray(
        array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 
    
    $objget->getStyle('KE'.($indexJml + 3).':NM'.($indexJml + 3))->applyFromArray( 
        array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    $objget->getStyle('KE'.($indexJml + 7).':NM'.($indexJml + 7))->applyFromArray( 
        array(
                'borders' => array(
                    'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    //THE END OF TARGET

            //SIGNATURE
    
    //MENYETUJUI 
    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml + 14).':KM'.($indexJml + 14)); 
    $objset->setCellValue('JK'.($indexJml + 14), "Menyetujui");
    $objget->getStyle('JK'.($indexJml + 14).':KM'.($indexJml + 14))->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'a2a8a8')
                )
            )
        );
    
        $objget->getStyle('JK'.($indexJml + 15).':KM'.($indexJml + 18))->applyFromArray(
            array(
                    'borders' => array(
                        'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml + 15).':KM'.($indexJml + 17));   
    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml + 18).':KM'.($indexJml + 18));   
    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml +19).':KM'.($indexJml +19)); 
    $objset->setCellValue('JK'.($indexJml +19), "Tgl :");
    $objget->getStyle('JK'.($indexJml +19).':KM'.($indexJml +19))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

    //DIPERIKSA 2 
    $objPHPExcel->getActiveSheet()->mergeCells('KN'.($indexJml + 14).':LQ'.($indexJml + 14)); 
    $objset->setCellValue('KN'.($indexJml + 14), "Diperiksa 2");
    $objget->getStyle('KN'.($indexJml + 14).':LQ'.($indexJml + 14))->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'a2a8a8')
                )
            )
        );
    
        $objget->getStyle('KN'.($indexJml + 15).':LQ'.($indexJml + 18))->applyFromArray(
            array(
                    'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

    $objPHPExcel->getActiveSheet()->mergeCells('KN'.($indexJml + 15).':LQ'.($indexJml + 17));   
    $objPHPExcel->getActiveSheet()->mergeCells('KN'.($indexJml + 18).':LQ'.($indexJml + 18));   
    $objPHPExcel->getActiveSheet()->mergeCells('KN'.($indexJml + 19).':LQ'.($indexJml + 19)); 
    $objset->setCellValue('KN'.($indexJml + 19), "Tgl :");
    $objget->getStyle('KN'.($indexJml + 19).':LQ'.($indexJml + 19))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

    //DIPERIKSA 1 
    $objPHPExcel->getActiveSheet()->mergeCells('LR'.($indexJml + 14).':MU'.($indexJml + 14)); 
    $objset->setCellValue('LR'.($indexJml + 14), "Diperiksa 1");
    $objget->getStyle('LR'.($indexJml + 14).':MU'.($indexJml + 14))->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'a2a8a8')
                )
            )
        );
    
        $objget->getStyle('LR'.($indexJml + 15).':MU'.($indexJml + 18))->applyFromArray(
            array(
                    'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

    $objPHPExcel->getActiveSheet()->mergeCells('LR'.($indexJml + 15).':MU'.($indexJml + 17));   
    $objPHPExcel->getActiveSheet()->mergeCells('LR'.($indexJml + 18).':MU'.($indexJml + 18));   
    $objPHPExcel->getActiveSheet()->mergeCells('LR'.($indexJml + 19).':MU'.($indexJml + 19)); 
    $objset->setCellValue('LR'.($indexJml + 19), "Tgl :");
    $objget->getStyle('LR'.($indexJml + 19).':MU'.($indexJml + 19))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

    //DIBUAT
    $objPHPExcel->getActiveSheet()->mergeCells('MV'.($indexJml +14).':NW'.($indexJml +14)); 
    $objset->setCellValue('MV'.($indexJml +14), "Dibuat");
    $objget->getStyle('MV'.($indexJml +14).':NW'.($indexJml +14))->applyFromArray(
        array(
                'borders' => array(
                'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'a2a8a8')
                )
            )
        );
    
        $objget->getStyle('MV'.($indexJml + 15).':NW'.($indexJml + 18))->applyFromArray(
            array(
                    'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    )
                )
            );

    $objPHPExcel->getActiveSheet()->mergeCells('MV'.($indexJml + 15).':NW'.($indexJml + 17));   
    $objPHPExcel->getActiveSheet()->mergeCells('MV'.($indexJml + 18).':NW'.($indexJml + 18));   
    $objPHPExcel->getActiveSheet()->mergeCells('MV'.($indexJml + 19).':NW'.($indexJml + 19)); 
    $objset->setCellValue('MV'.($indexJml + 19), "Tgl :");
    $objget->getStyle('MV'.($indexJml + 19).':NW'.($indexJml + 19))->applyFromArray(
        array(
                'borders' => array(
                'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
            )
        );

    // $objPHPExcel->getActiveSheet()->mergeCells('A'.($indexJml + 11).':NX'.($indexJml + 19));  

    $objget->getStyle('A'.($indexJml + 21).':NX'.($indexJml + 21))->applyFromArray(
        array(
                'borders' => array(
                'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            )
        );
    //SIGNATURE//

    $objPHPExcel->getActiveSheet()->getStyle('A15:NX'.($indexJml + 21))->getFont()->setSize(11); //font size over all
    $objPHPExcel->getActiveSheet()->getStyle('R'.$indexJml.':NX'.($indexJml))->getFont()->setSize(15); //heading keterangan dan perhitungan takt time
    $objPHPExcel->getActiveSheet()->getStyle('B15:M17')->getFont()->setSize(17);

    //no form
    $objPHPExcel->getActiveSheet()->mergeCells('JK'.($indexJml + 21).':NW'.($indexJml + 21));   
    $objset->setCellValue('JK'.($indexJml + 21), "Form No. : FRM-PDE-03-21 (Rev. 00-05/11/2021)");

    $objget->getStyle('JK'.($indexJml + 21).':NW'.($indexJml + 21))->applyFromArray(
        array(
                'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                ),
            )
        );
    
    $objget->getStyle('R'.($indexJml + 2).':BZ'.($indexJml + 2))->applyFromArray( 
        array(
                'borders' => array(
                    'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    $objget->getStyle('CA'.($indexJml + 2).':CC'.($indexJml + 2))->applyFromArray( 
        array(
                'borders' => array(
                    'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                    )
                )
            )
        ); 

    $objPHPExcel->getActiveSheet()->setTitle('TSKK'); 
    $objPHPExcel->setActiveSheetIndex(0);
    $filename = urlencode("TSKK_".$judul."_".$tanggal.".xlsx"); //FILE NAME//
    $filename = str_replace("+", " ", $filename);


    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
  
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    
    }

}

?>