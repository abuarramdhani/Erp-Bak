<?php defined('BASEPATH')OR exit('No direct script access allowed');
class C_UploadData extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
			$this->load->helper('url');
			$this->load->helper('html');

			$this->load->library('form_validation');
			$this->load->library('session');
			 $this->load->library('Excel');
			$this->load->library('encrypt');
			$this->load->library('upload');
			$this->load->library('General');
			$this->load->model('SystemAdministration/MainMenu/M_user');

			  //$this->load->library('Database');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('EmployeeRecruitment/m_testcorrection');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
					  //redirect('');
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index($resultload=null, $result=null)
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$user_name = $this->session->user;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['jenis_soal'] = $this->m_testcorrection->getJenisSoal();
			$data['resultload'] = $resultload;
			$data['result'] = $result;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('EmployeeRecruitment/Upload/V_Index',$data);
			$this->load->view('V_Footer',$data);
		}

	public function process()
		{
			$jawaban = $this->input->post('value');
			$jenis 	 = $this->input->post('jenis');
			$result = array();


			$getKunci = $this->m_testcorrection->getRule($jenis);
			$i=0;
			foreach ($getKunci as $kunci) {
					  $datakunci[$i]=$kunci['kunci'];
					  $scoreSalah[$i]=$kunci['score_salah'];
					  $scoreBetul[$i]=$kunci['score_betul'];
					  $datarule[$i]=$kunci['type'];
					  $subTest[$i]=$kunci['sub_test'];
					  $i++;
					}
			$sub_test = array_map("unserialize", array_unique(array_map("serialize", $subTest)));

			$getBatch = $this->m_testcorrection->getBatch();
			$batch = str_pad($getBatch[0]['batch']+1, 4,0, STR_PAD_LEFT);

			for ($i=0; $i < count($jawaban); $i++) { 
				$datasave = array();
				$x=8;
				$score = 0;
				$betul = 0;
				$salah = 0;
				$kosong = 0;

				for ($b=0; $b < 8; $b++) { 
					$result[$i]['result'][$b] = $jawaban[$i][$b];
				}

				// $c = 8;
				
					$datasave['no'] = $jawaban[$i][0];
					$datasave['id_key'] = $jawaban[$i][1];
					$datasave['secondary_id'] = $jawaban[$i][2];
					$datasave['image_name'] = $jawaban[$i][3];

				foreach ($sub_test as $sub) {
								$nilaisub[$sub] = 0;
						}

				//mulai koreksi
				for ($a=0; $a < count($datakunci); $a++) { 
					if ($datarule[$a] == 's') {
						if ($jawaban[$i][$x] == "") {
								$hasil = 'kosong';
								$skor  = 0;
								$score = $score + 0;
								$kosong++;
							
						}else{
							if ($jawaban[$i][$x] == $datakunci[$a]) {
								$hasil = 'betul';
								$skor = $scoreBetul[$a];
								$score = $score + $scoreBetul[$a];
								$betul++;
							}else{
								$hasil = 'salah';
								$skor = $scoreSalah[$a];
								$score = $score + $scoreSalah[$a];
								$salah++;
						 	}
						}
					}elseif ($datarule[$a] == 'd') {
						if ($jawaban[$i][$x] == "") {
								$hasil = 'kosong';
								$skor  = 0;
								$score = $score + 0;
								$kosong++;
							
						}else{
							if (str_replace(str_split('()'),"", $jawaban[$i][$x]) == $datakunci[$a] ) {
								$hasil = 'betul';
								$skor = $scoreBetul[$a];
								$score = $score + $scoreBetul[$a];
								$betul++;
							}else{
								$hasil = 'salah';
								$skor = $scoreSalah[$a];
								$score = $score + $scoreSalah[$a];
								$salah++;
							}
						}
					}

					$result[$i]['result'][$x] = array('jawab' => $jawaban[$i][$x] ,
										'kunci' => $datakunci[$a],
										'hasil' => $hasil,
										'score' => $skor);
					$datasave[($a+1).'_'] = $jawaban[$i][$x];

						foreach ($sub_test as $sub) {
							if ($sub == $subTest[$a]) {
								$nilaisub[$sub] = $nilaisub[$sub]+$skor;
							}
						}
					
					$x++;
				}
					$result[$i]['score'] = $score;
					$result[$i]['tot_salah'] = $salah;
					$result[$i]['tot_betul'] = $betul;
					$result[$i]['tot_kosong'] = $kosong;
					$result[$i]['jenis_soal'] = $jenis;
					$result[$i]['batch']	= $batch;

						$datasave['jenis_soal'] = $jenis;
						$datasave['true_'] = $betul;
						$datasave['false_'] = $salah;
						$datasave['score_'] = $score;
						$datasave['empty_'] = $kosong;
						$datasave['tgl_upload'] = 'now()';
						$datasave['batch_upload'] = $batch;

						foreach ($sub_test as $sub) {
							$result[$i]['sub_test'][$sub]	= $nilaisub[$sub];
						}
					$saveAndget = $this->m_testcorrection->saveKoreksi($datasave);
					$dataRest = array('jawaban_id' => $saveAndget ,
										'jumlah_benar' =>$betul,
										'jumlah_salah' =>$salah,
										'total_score' =>$score );
					$this->m_testcorrection->saveResult($dataRest);
			}
			$this->index(null,$result);
		}

	public function inputfile()
		{
			if(isset($_FILES['file_a']['name']) &&  $_FILES['file_a']['name'] != '')
				// $$namecss = "";
				{
				$jenis= $this->input->post('jenis');
					 $valid_extension = array('xml','xls','xlsx');
					 $file_data = explode('.', $_FILES['file_a']['name']);
					 $file_extension = end($file_data);
					 if(in_array($file_extension, $valid_extension))
					 {
					 	if ($file_extension == 'xml') {				 		
						 $data = @simplexml_load_file($_FILES['file_a']['tmp_name']);
						 $getRule = $this->m_testcorrection->getRule($jenis);
						$i=0;

						// echo "<pre>";
						// print_r($data);
						// echo "</pre>";
						// exit();
						foreach ($getRule as $rule) {
						  $datarule[$i]=$rule['type'];
						  $i++;
						}
						$warna = array();
						$error = 0;
						$kosong = 0;
						for($i = 1; $i < count($data); $i++)
						  {
							$x= 0;
							for ($a=0; $a < 8 ; $a++) { 
								$warna[$i][$a] =  "".$data->data[$i]->{"x".$a};
							}
						    for($j = 8; $j <= (count($datarule)+7); $j++)
						     {
						     	// echo $x;
						        if ($datarule[$x]=='s')
						        {
						          if($data->data[$i]->{"x" . $j }== "")
							          {
							          	   $warna[$i][$j] = array('val' => "".$data->data[$i]->{"x" . $j}, 
								          						  'rule'=> $datarule[$x],
								      							 'sign' => 'bg-yellow');
							          	   $kosong++;
							          }else{
								          if (1==strlen($data->data[$i]->{"x" . $j}))
								          {
								          $warna[$i][$j] = array('val' => "".$data->data[$i]->{"x" . $j}, 
								          						  'rule'=> $datarule[$x],
								      							 'sign' => '');
								          }
								          else
								          {
								          $warna[$i][$j] = array('val' => "".$data->data[$i]->{"x" . $j}, 
								          						  'rule'=> $datarule[$x],
								      							 'sign' => 'bg-red'); 
								      	  $error++;     
								          }
							          }

						        } 
						        elseif ($datarule[$x]=='d')
						        {

						        	if($data->data[$i]->{"x" . $j }== "")
							          {
							          	   $warna[$i][$j] = array('val' => "".$data->data[$i]->{"x" . $j}, 
								          						  'rule'=> $datarule[$x],
								      							 'sign' => 'bg-yellow');
							          	   $kosong++;
							          }else{
								          if (4==strlen($data->data[$i]->{"x" . $j}))
								          {
								          $warna[$i][$j] = array('val' => "".$data->data[$i]->{"x" . $j}, 
								          						  'rule'=> $datarule[$x],
								      							 'sign' => '');
								          }
								          else
								          {
								          $warna[$i][$j] = array('val' => "".$data->data[$i]->{"x" . $j}, 
								          						  'rule'=> $datarule[$x],
								      							 'sign' => 'bg-red'); 
								      	   $error++;      
								          }
							          }
						        } 
						        $x++;
						      }

						  }
						  $kolom = count($datarule);
						  $resultload = array('warna' => $warna ,
						  					  'kolom' => $kolom ,
						  					  'jenis' => $jenis ,
						  					  'error' => $error,
						  					  'kosong' => $kosong);
						  $this->index($resultload,null);
					 	}
					 	else{
					 		$getRule = $this->m_testcorrection->getRule($jenis);
								$i=0;
								foreach ($getRule as $rule) {
								  $datarule[$i]=$rule['type'];
								  $i++;
								}


					 		$excelReader = PHPExcel_IOFactory::createReaderForFile($_FILES['file_a']['tmp_name']);
							$excelObj = $excelReader->load($_FILES['file_a']['tmp_name']);
							$worksheet = $excelObj->getSheet(0);
							$lastRow = $worksheet->getHighestRow();
							$lastCol = $worksheet->getHighestColumn();
							$lastIndexCol = PHPExcel_Cell::columnIndexFromString($lastCol);
							
						 	$warna =array(); $b = 0;
						 	$error = 0;
						 	$kosong = 0;
						 	for ($i=2; $i <=$lastRow ; $i++) { 
						 			if ($worksheet->getCell('A'.$i)->getValue() != " ") {
								 		for ($a=0; $a < 8; $a++) { 
								 			$col = PHPExcel_Cell::stringFromColumnIndex($a);
									 			$warna[$b][$a] = $worksheet->getCell($col.$i)->getValue();
								 		}
								 		
								 		$x=0;
								 		for($j = 8; $j <= (count($datarule)+7); $j++) {
								 			$col = PHPExcel_Cell::stringFromColumnIndex($j);
								 				if ($datarule[$x]=='s')
										        {
										          if($worksheet->getCell($col.$i)->getValue()== "")
											          {
											          	   $warna[$b][$j] = array('val' => "".$data->data[$i]->{"x" . $j}, 
												          						  'rule'=> $datarule[$x],
												      							 'sign' => 'bg-yellow');
											          	   $kosong++;
											          }else{
												          if (1==strlen($worksheet->getCell($col.$i)->getValue()))
												          {
												          $warna[$b][$j] = array('val' => "".$worksheet->getCell($col.$i)->getValue(), 
												          						  'rule'=> $datarule[$x],
												      							 'sign' => '');
												          }
												          else
												          {
												          $warna[$b][$j] = array('val' => "".$worksheet->getCell($col.$i)->getValue(), 
												          						  'rule'=> $datarule[$x],
												      							 'sign' => 'bg-red'); 
												      	  $error++;     
												          }
											          }

										        } 
										        elseif ($datarule[$x]=='d')
										        {

										        	if($worksheet->getCell($col.$i)->getValue()== "")
											          {
											          	   $warna[$b][$j] = array('val' => "".$data->data[$i]->{"x" . $j}, 
												          						  'rule'=> $datarule[$x],
												      							 'sign' => 'bg-yellow');
											          	   $kosong++;
											          }else{
												          if (4==strlen($worksheet->getCell($col.$i)->getValue()))
												          {
												          $warna[$b][$j] = array('val' => "".$worksheet->getCell($col.$i)->getValue(), 
												          						  'rule'=> $datarule[$x],
												      							 'sign' => '');
												          }
												          else
												          {
												          $warna[$b][$j] = array('val' => "".$worksheet->getCell($col.$i)->getValue(), 
												          						  'rule'=> $datarule[$x],
												      							 'sign' => 'bg-red'); 
												      	   $error++;      
												          }
											          }
										        } 
										        $x++;
								 			
								 			}$b++;
								 		}
						 			}
					 	$kolom = count($datarule);
					 	$resultload = array('warna' => $warna ,
						  					  'kolom' => $kolom ,
						  					  'jenis' => $jenis ,
						  					  'error' => $error,
						  					  'kosong' => $kosong);
						$this->index($resultload,null);
					 	}


					  }
					  else
					  {
					   $resultload['error_msg'] = 'Invalid File Format!';
						$this->index($resultload,null);
					  } 
				}
		}

	function export(){
		$idbatch = $this->input->post('batchnum');
		$jenis = $this->input->post('jenis');

		$getJawaban = $this->m_testcorrection->getJawaban($idbatch);
		$getRule = $this->m_testcorrection->getRule($jenis);
        $colJwb = count($getRule)*3;
			$i=0;
			foreach ($getRule as $rule) {
					  $subTest[$i]=$rule['sub_test'];
					  $i++;
					}
			$sub_test = array_map("unserialize", array_unique(array_map("serialize", $subTest)));



		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("ICT")->setTitle("LJT_koreksi_batch".$idbatch);

		$objPHPExcel->getActiveSheet()->setTitle('Result LJT');
		$objPHPExcel->setActiveSheetIndex(0);

		//align
            $aligncenter = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));
            $alignleft = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));
            $alignright = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));
        //color
            $color1 = array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'cff0f9')
		        ));
            $color2 = array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'cff9df')
		        ));
            $color3 = array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'f9d7cf')
		        ));

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(9);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(9);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(9);
            // $objPHPExcel->getActiveSheet()->getColumnDimension($colString)->setWidth(1);

        $y=8; foreach ($sub_test as $key => $value) {
	         	$colString = PHPExcel_Cell::stringFromColumnIndex($y);
            	$objPHPExcel->getActiveSheet()->getColumnDimension($colString)->setWidth(12);
            	$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colString.'1','Kategori '.$value);
            	$y++;
            }

        $a= 1;for ($i=$y; $i < ($colJwb+$y); $i++) { 
        $colString = PHPExcel_Cell::stringFromColumnIndex($i);
            $objPHPExcel->getActiveSheet()->getColumnDimension($colString)->setWidth(4);

            if ((($i+1)-$y)%3 == 0 && ($i-$y) != 0) {
            	$b = $a-1;
            	$c = $i+2;
            	$n1 = $i-2;

            	$colString2 = PHPExcel_Cell::stringFromColumnIndex($n1);
            	$objPHPExcel->getActiveSheet()->mergeCells($colString2.'1:'.$colString.'1');
				$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($colString2.'1',$a++);
                $objPHPExcel->getActiveSheet()->getStyle($colString2.'1:'.$colString.'1')->applyFromArray($aligncenter);
            }
        }

        $b=2;for ($i=0; $i < count($getJawaban); $i++) { 
        	foreach ($sub_test as $sub) {
								$nilaisub[$sub] = 0;
						}
        	$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$b,$getJawaban[$i]['no'])
                    ->setCellValue('B'.$b,$getJawaban[$i]['id_key'])
                    ->setCellValue('C'.$b,$getJawaban[$i]['secondary_id'])
                    ->setCellValue('D'.$b,$getJawaban[$i]['image_name'])
                    ->setCellValue('E'.$b,$getJawaban[$i]['true_'])
                    ->setCellValue('F'.$b,$getJawaban[$i]['false_'])
                    ->setCellValue('G'.$b,$getJawaban[$i]['score_'])
                    ->setCellValue('H'.$b,$getJawaban[$i]['empty_']);


	        $a = $y; for ($x=0; $x < count($getRule); $x++) { 
	        	$col = PHPExcel_Cell::stringFromColumnIndex($a);
	        	$col2 = PHPExcel_Cell::stringFromColumnIndex($a+1);
	        	$col3 = PHPExcel_Cell::stringFromColumnIndex($a+2);
	        	$colT = ($x+1)."_";

	        	$ans = $getJawaban[$i][$colT];
	        	$key = $getRule[$x]['kunci'];

	        	if ($getRule[$x]['type'] == 's') {
						if ($ans == "") {
								$scr= '0';
							
						}else{
							if ($ans == $key) {
								$scr = $getRule[$x]['score_betul'];
							}else{
								$scr = $getRule[$x]['score_salah'];
						 	}
						}
					}elseif ($getRule[$x]['type'] == 'd') {
						if ($ans == "") {
								$scr= '0';
						}else{
							if (str_replace(str_split('()'),"", $ans) == $key ) {
								$scr = $getRule[$x]['score_betul'];
							}else{
								$scr = $getRule[$x]['score_salah'];
							}
						}
					}

					foreach ($sub_test as $sub) {
							if ($sub == $getRule[$x]['sub_test']) {
								$nilaisub[$sub] = $nilaisub[$sub]+$scr;
							}
						}

	        	$objPHPExcel->setActiveSheetIndex(0)
		                    ->setCellValue($col.$b, $ans)
		                    ->setCellValue($col2.$b, $key)
		                    ->setCellValue($col3.$b, $scr);
		        $objPHPExcel->getActiveSheet()->getStyle($col.$b)->applyFromArray($color1);
		        $objPHPExcel->getActiveSheet()->getStyle($col2.$b)->applyFromArray($color2);
		        if (strpos($scr, '-') !== false){
			        $objPHPExcel->getActiveSheet()->getStyle($col3.$b)->applyFromArray($color3);
		        }
		         $a +=3;

		         $d=8; foreach ($sub_test as $sub) {
		         	$colString = PHPExcel_Cell::stringFromColumnIndex($d);
			        $objPHPExcel->setActiveSheetIndex(0)
			                    ->setCellValue($colString.$b, $nilaisub[$sub]);
			        $d++;
		         }
	        }
	      $b++;
        }



        


        // $object->getActiveSheet()->mergeCells('A1:B1');


		$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1','No.')
                    ->setCellValue('B1','ID Key')
                    ->setCellValue('C1','Secondary_ID')
                    ->setCellValue('D1','Image_name')
                    ->setCellValue('E1','True')
                    ->setCellValue('F1','False')
                    ->setCellValue('G1','Score')
                    ->setCellValue('H1','Empty');
        $batchnum = str_pad($idbatch,4,0,STR_PAD_LEFT);

		$filename = "LJTResult".$batchnum.".xls";

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename);
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_clean();
            $objWriter->save('php://output');


	}
}
