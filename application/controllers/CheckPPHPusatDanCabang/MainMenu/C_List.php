<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_List extends CI_Controller
{
	
	function __construct()
	{		
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('Excel');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CheckPPHPusatDanCabang/M_uploadpph');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}


	function checkSession()
	{
		if($this->session->is_logged){
				
		}else{
			redirect();
		}
	}

	private function Menus()
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Data List';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		return $data;
	}

	function index()
	{
		$this->checkSession();
		$data = $this->Menus();
		$data['list'] = $this->M_uploadpph->getDataUpload(FALSE);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CheckPPhPusatDanCabang/List/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	function action()
	{
		$this->checkSession();
		$batch_num  = $this->input->post('txtBatchNum');
		$action 	= $this->input->post('jenisAct');
		if (!$batch_num) {
			exit('Invalid Batch Number Upload and Action ):');
		}
		$checkBatch = $this->M_uploadpph->checkBatch($batch_num);
		if ($batch_num ==  0) {
			redirect('AccountPayables/CheckPPhPusatDanCabang/List');
		}
		switch ($action) {
			case 'subPPH':
				$this->create_subtotal($batch_num);
				break;
			case 'sumPPH':
				$this->create_summary($batch_num);
				break;
			case 'recPPH':
				$this->create_recap($batch_num);
				break;
			case 'delPPH':
				$this->delete_pph($batch_num);
				break;
			case 'arcPPH':
				$this->archive_pph($batch_num);
				break;
			default:
				redirect('AccountPayables/CheckPPhPusatDanCabang/List');
				break;
		}
	}

	private function create_subtotal($no)
	{
		$this->load->library('Excel');
		$data = $this->M_uploadpph->getDataBatchSubtotal($no);
		// echo'<pre>';
		// print_r($data);exit;
		$arraySpezial = array('CABANG_LAIN','TUKSONO','YOGYAKARTA','SURABAYA','JAKARTA','MEDAN','MAKASSAR','TANJUNG KARANG','PALU','BANJARMASIN','PONTIANAK');
		$arrayJenis = array('PPH21PES','PPH21','PPH23','PPH4KON','PPH4SE','PPH4UN','0','PPHPS26');
		$datagroup = array();
			foreach ($data as $key2 => $value2) {
				$jenispajak = strtoupper(str_replace(' ','', $value2['jenis_pph']));
				if (strpos($jenispajak,'PPH21') !== false) {
					if (strpos($jenispajak,'PPH21PES')  !== false) {
						$code_jenis = 'PPH21PES';
					}else{
						$code_jenis = 'PPH21';
					}
				}elseif(strpos($jenispajak,'PPH23') !== false) {
					$code_jenis = 'PPH23';
				}elseif(strpos($jenispajak,'PPH4KON') !== false) {
					$code_jenis = 'PPH4KON';
				}elseif(strpos($jenispajak,'PPH4SE') !== false) {
					$code_jenis = 'PPH4SE';
				}elseif(strpos($jenispajak,'PPH4UN') !== false) {
					$code_jenis = 'PPH4UN';
				}else{
					$code_jenis = '0';
				}
				$datagroup[$code_jenis][$value2['jenis_pph'].'<>'.$value2['lokasi']][$value2['nama_vendor']][] = $data[$key2];

			}
		
			// echo'<pre>';
			// print_r($datagroup);exit;

			foreach ($arrayJenis as $kJ => $vJ) {
				if (isset($datagroup[$vJ])) {
					foreach ($datagroup[$vJ] as $key => $value) {
						// $datagroup2[$key] = $value;
						$namex = explode('<>', $key);
						$nameindex = $namex[1];
						// echo'<pre>';
						// echo strtoupper($nameindex);
						if (in_array(strtoupper($nameindex), $arraySpezial)) {
							$datagroup2[strtoupper($nameindex)][$vJ][$key] = $value;
						}else{
							$datagroup2['CABANG_LAIN'][$vJ][$key] = $value;
						}
					}
				}
			}
			// echo'<pre>';
			// print_r($datagroup2);exit;

			foreach ($datagroup2 as $key => $value) {
				foreach ($value as $key2 => $value2) {
					foreach ($value2 as $key3 => $value3) {
						foreach ($value3 as $key4 => $value4) {
							foreach ($value4 as $key5 => $value5) {
								$datagroup3[$key][$key2][$key4][] = $value5;
							}
						}
					}
				}
			}


		//mulai
            $object = new PHPExcel();
            $object->getProperties()->setCreator("Quick")
                ->setLastModifiedBy("Quick");

            $object->getActiveSheet()->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $object->getActiveSheet()->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

            //font style
            $FontFam        = array('font'  => array( 'size' => 10,'bold'  => false,'name' => 'Arial'));
            $Font10Reg      = array('font'  => array( 'size' => 10,'bold'  => false,'name' => 'Arial'));
            $Font10Bold     = array('font'  => array( 'size' => 10,'bold'  => true,'name' => 'Arial'));
            $Font10BoldI    = array('font'  => array( 'size' => 10,'bold'  => true,'italic' => true,'name' => 'Arial'));
            $Font10BoldU    = array('font'  => array( 'size' => 10,'bold'  => true,'underline' => true,'name' => 'Arial'));
            $Font10BoldUI   = array('font'  => array( 'size' => 10,'bold'  => true,'underline' => true,'italic' => true,'name' => 'Arial'));

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


            //width
            $object->getActiveSheet()->getColumnDimension('A')->setWidth(21);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(38);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(32);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(18);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(22);
            $object->getActiveSheet()->getColumnDimension('K')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('L')->setWidth(12);

            //height
            $object->getActiveSheet()->getRowDimension('1')->setRowHeight(12);
            $object->getActiveSheet()->getRowDimension('2')->setRowHeight(12);
            $object->getActiveSheet()->getRowDimension('3')->setRowHeight(12);

            $object->getActiveSheet()->setTitle('SUBTOTAL PPH');
            $object->setActiveSheetIndex(0);

            //header
            $object->getActiveSheet()->mergeCells('A1:L1');
            $object->setActiveSheetIndex(0)
                    ->setCellValue('A1','LAPORAN SUBTOTAL PPH')
                    ->setCellValue('A2','PPH');
            $object->getActiveSheet()->getStyle('A1')->applyFromArray($Font10BoldU);
            $object->getActiveSheet()->getStyle('A1')->applyFromArray($aligncenter);
            $object->getActiveSheet()->getStyle('A2')->applyFromArray($Font10Bold);

            //isi
            $row = 4;
            foreach ($arraySpezial as $kSp => $vSp) {
            	if (isset($datagroup3[$vSp])) {
	            	$object->setActiveSheetIndex(0)
		                    ->setCellValue('A'.$row, $vSp);
		            $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font10Bold);
		            $row++;
		            foreach ($datagroup3[$vSp] as $key => $value) {
		            	$gandtotdpp = 0;
						$grandtotpph = 0;
			            $object->setActiveSheetIndex(0)
			                    ->setCellValue('A'.$row,'Jenis Pph')
			                    ->setCellValue('B'.$row,'Tarif Pph')
								->setCellValue('C'.$row,'Nama Vendor')
								->setCellValue('D'.$row,'No NPWP')
			                    ->setCellValue('E'.$row,'No Invoice')
			                    ->setCellValue('F'.$row,'Tgl Transaksi')
			                    ->setCellValue('G'.$row,'Bank')
			                    ->setCellValue('H'.$row,'Currency')
			                    ->setCellValue('I'.$row,'DPP')
			                    ->setCellValue('J'.$row,'PPH')
			                    ->setCellValue('K'.$row,'Jenis Jasa')
			                    ->setCellValue('L'.$row,'Lokasi')
			                    ->setCellValue('M'.$row,'Tgl Invoice');
			            $object->getActiveSheet()->getStyle('A'.$row.':M'.$row)->applyFromArray($Font10Bold);
			            $object->getActiveSheet()->getStyle('A'.$row.':M'.$row)->applyFromArray($aligncenter);
			            $row++;
		            	foreach ($value as $key2 => $value2) {
			            	$totdpp = 0;
							$totpph = 0;
			            	foreach ($value2 as $key3 => $value3) {
			            		$object->setActiveSheetIndex(0)
					                    ->setCellValue('A'.$row,$value3['jenis_pph'])
					                    ->setCellValue('B'.$row,$value3['tarif_pph'])
										->setCellValue('C'.$row,$value3['nama_vendor'])
										->setCellValue('D'.$row,$value3['no_npwp'])
					                    ->setCellValue('E'.$row,$value3['no_invoice'])
					                    ->setCellValue('F'.$row,strtoupper(date('d-M-y', strtotime($value3['tgl_transaksi']))))
					                    ->setCellValue('G'.$row,$value3['bank'])
					                    ->setCellValue('H'.$row,$value3['currency'])
					                    ->setCellValue('I'.$row,$value3['dpp'])
					                    ->setCellValue('J'.$row,$value3['pph'])
					                    ->setCellValue('K'.$row,$value3['jenis_jasa'])
					                    ->setCellValue('L'.$row,$value3['lokasi'])
					                    ->setCellValue('M'.$row,strtoupper(date('d-M-y', strtotime($value3['tgl_invoice']))));
					            $object->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray($FontFam);
					            $object->getActiveSheet()->getStyle('B'.$row)->applyFromArray($aligncenter);
					            $object->getActiveSheet()->getStyle('D'.$row)->applyFromArray($aligncenter);
					            $object->getActiveSheet()->getStyle('E'.$row)->applyFromArray($aligncenter);
								$object->getActiveSheet()->getStyle('G'.$row)->applyFromArray($aligncenter);
								$object->getActiveSheet()->getStyle('H'.$row)->applyFromArray($aligncenter);
					            $object->getActiveSheet()->getStyle('K'.$row.':M'.$row)->applyFromArray($aligncenter);
					            $object->getActiveSheet()->getStyle('I'.$row.':J'.$row)->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');
					            $totdpp += $value3['dpp'];
					            $totpph += $value3['pph'];
					            $vendor = $value3['nama_vendor'];
					            $row++;
			            	}
				            	$object->setActiveSheetIndex(0)
					                    ->setCellValue('C'.$row,$vendor.' Result')
					                    ->setCellValue('I'.$row,$totdpp)
					                    ->setCellValue('J'.$row,$totpph);
					            $object->getActiveSheet()->getStyle('C'.$row.':J'.$row)->applyFromArray($Font10BoldUI);
					            $object->getActiveSheet()->getStyle('I'.$row.':J'.$row)->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');
					            $gandtotdpp += $totdpp;
								$grandtotpph += $totpph;
					            $row++;
		            	}
				            $object->setActiveSheetIndex(0)
				                    ->setCellValue('C'.$row,'Grand Total')
				                    ->setCellValue('I'.$row,$gandtotdpp)
				                    ->setCellValue('J'.$row,$grandtotpph);

				            $object->getActiveSheet()->getStyle('C'.$row.':J'.$row)->applyFromArray($Font10BoldUI);
				            $object->getActiveSheet()->getStyle('I'.$row.':J'.$row)->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');
			            	
			            	$row+=2;
		            }
            	}
	         }


            // wraptext dan set print area
            $object->getActiveSheet()->getStyle('A1:E'.$object->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
            // $object->getActiveSheet()->getPageSetup()->setPrintArea('A1:L'.$object->getActiveSheet()->getHighestRow());

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="SUBTOTAL PPH - '.$no.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            ob_clean();
            $objWriter->save('php://output');
		
	}
	
	private function create_summary($no)
	{
		$this->load->library('Excel');
		$data = $this->M_uploadpph->getDataBatch($no);
		$arrayJenis = array('PPH21PES','PPH21','PPH23','PPH4KON','PPH4SE','PPH4UN','0');
		$datagroup = array();
		$datagroup2 = array();
		// foreach ($data as $key => $value) {
		// 	$datagroup[$value['nama_vendor']][] = $value;
		// }
		$arrayzzz = array();

		foreach ($data as $key2 => $value2) {
				$jenispajak = strtoupper(str_replace(' ','', $value2['jenis_pph']));
				if (strpos($jenispajak,'PPH21') !== false) {
					if (strpos($jenispajak,'PPH21PES')  !== false) {
						$code_jenis = 'PPH21PES';
					}else{
						$code_jenis = 'PPH21';
					}
				}elseif(strpos($jenispajak,'PPH23') !== false) {
					$code_jenis = 'PPH23';
				}elseif(strpos($jenispajak,'PPH4KON') !== false) {
					$code_jenis = 'PPH4KON';
				}elseif(strpos($jenispajak,'PPH4SE') !== false) {
					$code_jenis = 'PPH4SE';
				}elseif(strpos($jenispajak,'PPH4UN') !== false) {
					$code_jenis = 'PPH4UN';
				}else{
					$code_jenis = '0';
				}
				$datagroup[$code_jenis][$value2['jenis_pph'].'<>'.$value2['lokasi']][$value2['nama_vendor']][] = $data[$key2];

			}

		foreach ($arrayJenis as $kJ => $vJ) {
				if (isset($datagroup[$vJ])) {
					foreach ($datagroup[$vJ] as $key => $value) {
						// $datagroup2[$key] = $value;
						$namex = explode('<>', $key);
						$nameindex = $namex[1];
						$datagroup2[strtoupper($nameindex)][$vJ][$key] = $value;
					}
				}
			}

			foreach ($datagroup2 as $key => $value) {
				foreach ($value as $key2 => $value2) {
					foreach ($value2 as $key3 => $value3) {
						foreach ($value3 as $key4 => $value4) {
							$arrayNew = array();
							$arraysudah = array();
							$arrayBaru = array();
							$pph = array();
							$dpp = array();
							foreach ($value4 as $key5 => $value5) {
								$arrayBaru[$value5['jenis_jasa']] = $value5;
								$namadpp = 'dpp'.$value5['jenis_jasa'];
								$namapph = 'pph'.$value5['jenis_jasa'];

								if (in_array($value5['jenis_jasa'], $arraysudah)) {
									$$namadpp += $value5['dpp'];
									$$namapph += $value5['pph'];
								}else{
									array_push($arraysudah, $value5['jenis_jasa']);
									$$namadpp = 0;
									$$namapph = 0;
									$$namadpp += $value5['dpp'];
									$$namapph += $value5['pph'];
								}
							}
							foreach ($arrayBaru as $k => $v) {
								$namadpp = 'dpp'.$k;
								$namapph = 'pph'.$k;
								$v['dpp'] = $$namadpp;
								$v['pph'] = $$namapph;
								$arrayNew[] = $v;
							}
							foreach ($arrayNew as $keyN => $valueN) {
								$datagroup3[$key][$key2][$key4][] = $valueN;
							}

						}
					}
				}
			}




		//mulai
            $object = new PHPExcel();
            $object->getProperties()->setCreator("Quick")
                ->setLastModifiedBy("Quick");

            $object->getActiveSheet()->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $object->getActiveSheet()->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

            //font style
            $FontFam        = array('font'  => array( 'size' => 10,'bold'  => false,'name' => 'Arial'));
            $Font10Reg      = array('font'  => array( 'size' => 10,'bold'  => false,'name' => 'Arial'));
            $Font10Bold     = array('font'  => array( 'size' => 10,'bold'  => true,'name' => 'Arial'));
            $Font10BoldI    = array('font'  => array( 'size' => 10,'bold'  => true,'italic' => true,'name' => 'Arial'));
            $Font10BoldU    = array('font'  => array( 'size' => 10,'bold'  => true,'underline' => true,'name' => 'Arial'));
            $Font10BoldUI   = array('font'  => array( 'size' => 10,'bold'  => true,'underline' => true,'italic' => true,'name' => 'Arial'));

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


            //width
            $object->getActiveSheet()->getColumnDimension('A')->setWidth(21);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(38);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(18);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(22);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(12);
            $object->getActiveSheet()->getColumnDimension('K')->setWidth(12);

            //height
            $object->getActiveSheet()->getRowDimension('1')->setRowHeight(12);
            $object->getActiveSheet()->getRowDimension('2')->setRowHeight(12);
            $object->getActiveSheet()->getRowDimension('3')->setRowHeight(12);

            $object->getActiveSheet()->setTitle('LAPORAN SUMMARY PPH');
            $object->setActiveSheetIndex(0);

            //header
            $object->getActiveSheet()->mergeCells('A1:L1');
            $object->setActiveSheetIndex(0)
                    ->setCellValue('A1','LAPORAN SUMMARY PPH')
                    ->setCellValue('A2','PPH');
            $object->getActiveSheet()->getStyle('A1')->applyFromArray($Font10BoldU);
            $object->getActiveSheet()->getStyle('A1')->applyFromArray($aligncenter);
            $object->getActiveSheet()->getStyle('A2')->applyFromArray($Font10Bold);

            //isi
            $row = 4;
            foreach ($datagroup3 as $key => $lokasi) {
            $object->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row,strtoupper($key));
            $object->getActiveSheet()->getStyle('A'.$row)->applyFromArray($Font10BoldU);
            $row++;
            	foreach ($lokasi as $key2 => $jenispph) {
		            $object->setActiveSheetIndex(0)
		                    ->setCellValue('A'.$row,'Jenis Pph')
		                    ->setCellValue('B'.$row,'Tarif Pph')
		                    ->setCellValue('C'.$row,'Nama Vendor')
		                    ->setCellValue('D'.$row,'Tgl Transaksi')
		                    ->setCellValue('E'.$row,'Bank')
		                    ->setCellValue('F'.$row,'Currency')
		                    ->setCellValue('G'.$row,'DPP')
		                    ->setCellValue('H'.$row,'PPH')
		                    ->setCellValue('I'.$row,'Jenis Jasa')
		                    ->setCellValue('J'.$row,'Lokasi')
		                    ->setCellValue('K'.$row,'Tgl Invoice');
		            $object->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray($Font10Bold);
		            $object->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray($aligncenter);
		            $row++;
	            	$jml = 0;
	            	$totdpp = 0;
					$totpph = 0;
		            foreach ($jenispph as $key3 => $pervendor) {
		            	foreach ($pervendor as $key4 => $datavendor) {
		            	$object->setActiveSheetIndex(0)
			                    ->setCellValue('A'.$row,$datavendor['jenis_pph'])
			                    ->setCellValue('B'.$row,$datavendor['tarif_pph'])
			                    ->setCellValue('C'.$row,$datavendor['nama_vendor'])
			                    ->setCellValue('D'.$row,strtoupper(date('d-M-y', strtotime($datavendor['tgl_transaksi']))))
			                    ->setCellValue('E'.$row,$datavendor['bank'])
			                    ->setCellValue('F'.$row,$datavendor['currency'])
			                    ->setCellValue('G'.$row,$datavendor['dpp'])
			                    ->setCellValue('H'.$row,$datavendor['pph'])
			                    ->setCellValue('I'.$row,$datavendor['jenis_jasa'])
			                    ->setCellValue('J'.$row,$datavendor['lokasi'])
			                    ->setCellValue('K'.$row,( $datavendor['tgl_invoice'] ? strtoupper(date('d-M-y', strtotime($datavendor['tgl_invoice']))) :''));
			            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($FontFam);
			            $object->getActiveSheet()->getStyle('B'.$row)->applyFromArray($aligncenter);
			            $object->getActiveSheet()->getStyle('E'.$row)->applyFromArray($aligncenter);
			            $object->getActiveSheet()->getStyle('F'.$row)->applyFromArray($aligncenter);
			            $object->getActiveSheet()->getStyle('I'.$row.':J'.$row)->applyFromArray($aligncenter);
			            $object->getActiveSheet()->getStyle('G'.$row.':H'.$row)->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');
			            $totdpp += $datavendor['dpp'];
			            $totpph += $datavendor['pph'];
			            $vendor = $datavendor['nama_vendor'];
			            $row++;
			            $jml++;
		            	}
		            }
		            if ($jml > 1) {
			            $object->setActiveSheetIndex(0)
				                    ->setCellValue('C'.$row,' Grand Total')
				                    ->setCellValue('G'.$row,$totdpp)
				                    ->setCellValue('H'.$row,$totpph);
				            $object->getActiveSheet()->getStyle('C'.$row.':I'.$row)->applyFromArray($Font10BoldUI);
				            $object->getActiveSheet()->getStyle('G'.$row.':H'.$row)->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');
				            $gandtotdpp += $totdpp;
							$grandtotpph += $totpph;
		            }
			            $row += 2;

            	}
            	$row++;

            	
            }

            // wraptext dan set print area
            $object->getActiveSheet()->getStyle('A1:E'.$object->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="LAPORAN SUMMARY PPH - '.$no.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            ob_clean();
            $objWriter->save('php://output');
	}

	private function create_recap($no)
	{
		$this->load->library('Excel');
		$arrayJenis = array('213110','213102','213105','213106','213108','213103','213104');
		$arrayUrut = array();
		$arraySpezial = array(
			'YOGYAKARTA',
			'MLATI',
			'TUKSONO',
			'JAKARTA',
			'TANJUNG KARANG',
			'MEDAN',
			'TUGUMULYO',
			'PADANG',
			'PEKANBARU',
			'PONTIANAK',
			'JAMBI',
			'SURABAYA',
			'MAKASSAR',
			'SIDRAP',
			'NGANJUK',
			'BANJARMASIN',
			'PALU'
		);
		$data = $this->M_uploadpph->getDataBatch($no);
		$datagroup = array();
		$datagroup2 = array();
		$arrayzzz = array();
		$periode = '';
		$arrayMonth = array(
              '01' => 'Januari',
              '02' => 'Februari',
              '03' => 'Maret',
              '04' => 'April',
              '05' => 'Mei',
              '06' => 'Juni',
              '07' => 'Juli',
              '08' => 'Agustus',
              '09' => 'September',
              '10' => 'Oktober',
              '11' => 'November',
              '12' => 'Desember',
          );

		foreach ($arrayJenis as $key => $value) {
			foreach ($arraySpezial as $key2 => $value2) {
				$arrayUrut[] = $value.'-'.$value2;
			}
		}

		// foreach ($data as $key => $value) {
		// 	$datagroup[$value['nama_vendor']][] = $value;
		// }
		
		$arrayKodeLokasi = array(
								'YOGYAKARTA' => 'AA',	
								'MLATI' => 'AB',	
								'TUKSONO' => 'AC',	
								'JAKARTA' => 'BA',	
								'TANJUNG KARANG' => 'BB',	
								'MEDAN' => 'BC',	
								'TUGUMULYO' => 'BD',	
								'PADANG' => 'BE',	
								'PEKANBARU' => 'BF',	
								'PONTIANAK' => 'BG',	
								'JAMBI' => 'BH',	
								'SURABAYA' => 'CA',	
								'MAKASSAR' => 'CB',	
								'SIDRAP' => 'CC',	
								'NGANJUK' => 'CD',	
								'BANJARMASIN' => 'CE',	
								'PALU' => 'CF',	
						);
		$arrayCOA = array(
						'213102' => array(
										'JENISPPH' => array(
															'PPH21-50%',
															'PPH21NON-50%',
															'PPH21PGT-NON',
															'PPH21PUNGUTAN'),
										'JENISPPHREKAP' => 'Pph Pasal 21',
										'KODEPAJAK' => '411121 – 100'
									),
						'213103' => array(
										'JENISPPH' => array(
															'PPH23HADIAH',
															'PPH23JASA',
															'PPH23JS-NON'),
										'JENISPPHREKAP' => 'Pph Pasal 23',
										'KODEPAJAK' => '411124 – 100'
									),
						'213104' => array(
										'JENISPPH' => array('PPH26'),
										'JENISPPHREKAP' => 'Pph Pasal 26',
										'KODEPAJAK' => '411127 – 100'
									),
						'213105' => array(
										'JENISPPH' => array(
															'PPH4KONSTR2%',
															'PPH4KONSTR3%',
															'PPH4KONSTR4%'),
										'JENISPPHREKAP' => 'Pph Pasal 4 Konstruksi',
										'KODEPAJAK' => '411128 – 409'
									),
						'213106' => array(
										'JENISPPH' => array('PPH4SEWA'),
										'JENISPPHREKAP' => 'Pph Pasal 4 Sewa',
										'KODEPAJAK' => '411128 – 403'
									),
						'213108' => array(
										'JENISPPH' => array('PPH4UNDIAN'),
										'JENISPPHREKAP' => 'Pph Pasal 4 Undian',
										'KODEPAJAK' => '411128 – 405'
									),
				
						'213109' => array(
										'JENISPPH' => array('PPH15-1.2%'),
										'JENISPPHREKAP' => 'Pph Pasal 15', 
										'KODEPAJAK' => '411128 – 410'
									),
						'213110' => array(
										'JENISPPH' => array('PPH21PESANGON','PPH21-PESANGON'),
										'JENISPPHREKAP' => 'Pph Pasal 21',
										'KODEPAJAK' => '411121 – 401'
									)
					);

		// 
			foreach ($data as $key2 => $value2) {
				$jenispajak = strtoupper(str_replace(' ','', $value2['jenis_pph']));
				if (strpos($jenispajak,'PPH21') !== false) {
					if (strpos($jenispajak,'PPH21PES')  !== false) {
						$code_jenis = '213110';
					}else{
						$code_jenis = '213102';
					}
				}elseif(strpos($jenispajak,'PPH23') !== false) {
					$code_jenis = '213103';
				}elseif(strpos($jenispajak,'PPH4KON') !== false) {
					$code_jenis = '213105';
				}elseif(strpos($jenispajak,'PPH4SE') !== false) {
					$code_jenis = '213106';
				}elseif(strpos($jenispajak,'PPH4UN') !== false) {
					$code_jenis = '213108';
				}elseif(strpos($jenispajak,'PPHPS26') !== false) {
					$code_jenis = '213104';
				}else{
					$code_jenis = '0';
				}
				$datagroup[$code_jenis][$value2['jenis_pph'].'<>'.$value2['lokasi']][$value2['nama_vendor']][] = $data[$key2];

			}

			// echo '<pre>';
			// print_r($datagroup);exit;

		foreach ($arrayJenis as $kJ => $vJ) {
				if (isset($datagroup[$vJ])) {
					
					foreach ($datagroup[$vJ] as $key => $value) {
						// $datagroup2[$key] = $value;
						$namex = explode('<>', $key);
						$nameindex = $namex[1];
						if (in_array(strtoupper($nameindex), $arraySpezial)) {
							$datagroup2[strtoupper($nameindex)][$vJ][$key] = $value;
						}
					}
				}
			}
			// echo '<pre>';
			// print_r($datagroup2);exit;

			foreach ($datagroup2 as $key => $value) {
				foreach ($value as $key2 => $value2) {
					foreach ($value2 as $key3 => $value3) {
						foreach ($value3 as $key4 => $value4) {
							$arrayNew = array();
							$arraysudah = array();
							$arrayBaru = array();
							$pph = array();
							$dpp = array();
							foreach ($value4 as $key5 => $value5) {
								$arrayBaru[$value5['jenis_jasa']] = $value5;
								$namadpp = 'dpp'.$value5['jenis_jasa'];
								$namapph = 'pph'.$value5['jenis_jasa'];
								
								
								if (in_array($value5['jenis_jasa'], $arraysudah)) {
										$$namadpp += $value5['dpp'];
										$$namapph += $value5['pph'];
								}else{
									array_push($arraysudah, $value5['jenis_jasa']);
									$$namadpp = 0;
									$$namapph = 0;
									$$namadpp += $value5['dpp'];
									$$namapph += $value5['pph'];
								}

							}
							foreach ($arrayBaru as $k => $v) {
								$namadpp = 'dpp'.$k;
								$namapph = 'pph'.$k;
								$v['dpp'] = $$namadpp;
								$v['pph'] = $$namapph;
								$tglperiode = $v['tgl_transaksi'];
								$arrayNew[] = $v;
							}
							foreach ($arrayNew as $keyN => $valueN) {
								$datagroup3[$key][$key2][$key4][] = $valueN;
							}

						}
					}
				}
			}

			// echo '<pre>';
			// print_r($datagroup3);
			// exit;

		if ( isset($datagroup3) ) {

			if ($datagroup3) {
					$periode = strtoupper($arrayMonth[date('m',strtotime($tglperiode))]).' '.date('Y',strtotime($tglperiode));
				}
			foreach ($datagroup3 as $key => $value) {
				foreach ($value as $key2 => $value2) {
					foreach ($value2 as $key3 => $value3) {
						foreach ($value3 as $key4 => $value4) {
							$no_urut = $value4['no_urut'];
							$tgl_transaksi = $value4['tgl_transaksi'];
							$nama_vendor = $value4['nama_vendor'];
							$jenis_pph = $value4['jenis_pph'];
							$coa = $key2;
							$batch_num = $value4['batch_num'];
							$lokasi = $value4['lokasi'];
						}
						if (!$no_urut) {
							// $datagroup2[$key][$key2][$key3]['nama_vendor'];
							$newNoUrut = $this->generateNumberBukpot($coa, $jenis_pph,$lokasi,$tgl_transaksi,$nama_vendor,$batch_num);
							foreach ($value3 as $key4 => $value4) {
								$datagroup3[$key][$key2][$key3][$key4]['no_urut'] = $newNoUrut;
							}
							// echo "durunggg";
						}
					}
				}
			}

				// echo '<pre>';
				// print_r($datagroup3);
				// exit();

			$arrayRekap = array();
			foreach ($datagroup3 as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$namepjkexplode = explode('>', $key);
					$jenispph = strtoupper(str_replace(' ','',$namepjkexplode[0]));
					$lokasi = $key;
					$coa 		= $key2;
					$jenis_pph_rekap = $arrayCOA[$key2]['JENISPPHREKAP'];
					$kodepajak  = $arrayCOA[$key2]['KODEPAJAK'];

					$arrayRekap[$coa.'-'.$lokasi]['LOKASI'] = $lokasi;
					$arrayRekap[$coa.'-'.$lokasi]['JENIS_PPH'] = $jenis_pph_rekap;
					$arrayRekap[$coa.'-'.$lokasi]['BRANCH'] = $arrayKodeLokasi[$lokasi];
					$arrayRekap[$coa.'-'.$lokasi]['COA'] = $coa;
					$arrayRekap[$coa.'-'.$lokasi]['KODEPAJAK'] = $kodepajak;
					$arrayRekap[$coa.'-'.$lokasi]['DATA'] = $value2;
				}
				
			}
		}

				// echo '<pre>';
				// print_r($datagroup3);
				// exit();


		//mulai
            $object = new PHPExcel();
            $object->getProperties()->setCreator("Quick")
                ->setLastModifiedBy("Quick");

            $object->getActiveSheet()->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $object->getActiveSheet()->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

            //font style
            $Font14Bold     = array('font'  => array( 'size' => 14,'bold'  => true,'name' => 'Arial'));
            $Font13Reg      = array('font'  => array( 'size' => 13,'bold'  => false,'name' => 'Arial'));
            $Font13Bold     = array('font'  => array( 'size' => 13,'bold'  => true,'name' => 'Arial'));
            $Font13BoldI    = array('font'  => array( 'size' => 13,'bold'  => true,'italic' => true,'name' => 'Arial'));
            $Font13BoldU    = array('font'  => array( 'size' => 13,'bold'  => true,'underline' => true,'name' => 'Arial'));
            $Font13BoldUI   = array('font'  => array( 'size' => 13,'bold'  => true,'underline' => true,'italic' => true,'name' => 'Arial'));

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


             //style border
            $border_all     = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('black'),)));
            $border_top_bot = array('borders' => array( 
                                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN ),
                                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN )));
            $border_bot = array('borders' => array( 
                                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN )));
            $border_horizon = array('borders' => array(
                                    'horizontal' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN)));


            //width
            $object->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(45);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(61);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(95);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(10);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(23);
            $object->getActiveSheet()->getColumnDimension('K')->setWidth(21);

            //height
            $object->getActiveSheet()->getRowDimension('1')->setRowHeight(27);
            $object->getActiveSheet()->getRowDimension('2')->setRowHeight(27);
            $object->getActiveSheet()->getRowDimension('3')->setRowHeight(29);

            $object->getActiveSheet()->setTitle('REKAP LAPORAN PPH');
            $object->setActiveSheetIndex(0);

            //header
            $object->getActiveSheet()->mergeCells('A1:K1');
            $object->getActiveSheet()->mergeCells('A2:K2');
            $object->setActiveSheetIndex(0)
                    ->setCellValue('A1','REKAP LAPORAN PPH CV KARYA HIDUP SENTOSA')
                    ->setCellValue('A2','MASA '.$periode);
            $object->getActiveSheet()->getStyle('A1:A2')->applyFromArray($Font14Bold);
            $object->getActiveSheet()->getStyle('A1:A2')->applyFromArray($aligncenter);

            //isi
            $row = 4;
            $row1 = $row;
            foreach ($arrayUrut as $kUrut => $vUrut) {
        	if(isset($arrayRekap[$vUrut])):
            // foreach ($arrayRekap[$vUrut] as $vUrut => $arrayRekap[$vUrut]) { 
            	$object->setActiveSheetIndex(0)
	                    ->setCellValue('A'.$row,'LOKASI')
	                    ->setCellValue('A'.($row+1),'JENIS PPH')
	                    ->setCellValue('A'.($row+2),'BRANCH – COA')
	                    // ->setCellValue('A'.($row+3),'KODE AKUN PAJAK')
	                    ->setCellValue('C'.$row,': '.$arrayRekap[$vUrut]['LOKASI'])
	                    ->setCellValue('C'.($row+1),': '.$arrayRekap[$vUrut]['JENIS_PPH'])
	                    ->setCellValue('C'.($row+2),': '.$arrayRekap[$vUrut]['BRANCH'].' - '.$arrayRekap[$vUrut]['COA']);
	                    // ->setCellValue('C'.($row+3),': '.$arrayRekap[$vUrut]['KODEPAJAK']);
	            $object->getActiveSheet()->getStyle('A'.$row.':K'.($row+4))->applyFromArray($Font13Bold);
	            $row += 4;
	            $object->setActiveSheetIndex(0)
	                    ->setCellValue('A'.$row,'NO')
	                    ->setCellValue('B'.$row,'TGL BUPOT')
	                    ->setCellValue('C'.$row,'KETERANGAN')
	                    ->setCellValue('D'.$row,'NPWP')
	                    ->setCellValue('E'.$row,'NAMA NPWP')
	                    ->setCellValue('F'.$row,'ALAMAT NPWP')
	                    ->setCellValue('G'.$row,'DPP')
	                    ->setCellValue('H'.$row,'PPh')
	                    ->setCellValue('I'.$row,'TARIF')
	                    ->setCellValue('J'.$row,'NO URUT')
	                    ->setCellValue('K'.$row,'JENIS JASA');
		        $object->getActiveSheet()->getColumnDimension('A')->setWidth(6);
	            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($aligncenter);
	            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($border_all);
	            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray(
	           array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffcccc')))
	           );
	             $object->getActiveSheet()->getRowDimension($row)->setRowHeight(28);
	        $row++; $nom =1;
        	$totdpp[$vUrut] = $totpph[$vUrut]  = 0;
	        if ($arrayRekap[$vUrut]['DATA']) {
		        foreach ($arrayRekap[$vUrut]['DATA'] as $key1 => $value1) {
		        	$a = count($value1);
		        	foreach($value1 as $key2 => $value2){
		        	// 	if (!$value2['no_urut']) {
		        			// $nomor_urut = $this->generateNumberBukpot($value2['jenis_pph'],$value2['tgl_transaksi']);
		        		// }
		        	$object->setActiveSheetIndex(0)
		                    ->setCellValue('A'.$row,$nom)
		                    ->setCellValue('B'.$row,strtoupper(date('d-M-y', strtotime($value2['tgl_transaksi']))))
		                    ->setCellValue('C'.$row,$value2['nama_vendor'])
		                    ->setCellValue('D'.$row,$value2['no_npwp'])
		                    ->setCellValue('E'.$row,$value2['nama_npwp'])
		                    ->setCellValue('F'.$row,$value2['alamat_npwp'])
		                    ->setCellValue('G'.$row,$value2['dpp'])
		                    ->setCellValue('H'.$row,$value2['pph'])
		                    ->setCellValue('I'.$row,$value2['tarif_pph'])
		                    ->setCellValue('J'.$row,$value2['no_urut'])
		                    ->setCellValue('K'.$row,$value2['jenis_jasa']);
			        $object->getActiveSheet()->getColumnDimension('A')->setWidth(6);
		            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($border_all);
		            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($Font13Reg);
		            // $object->getActiveSheet()->getStyle('E'.$row.':F'.$row)->applyFromArray($alignleft);
		            $object->getActiveSheet()->getStyle('A'.$row.':B'.$row)->applyFromArray($aligncenter);
		            $object->getActiveSheet()->getStyle('C'.$row)->applyFromArray($alignleft);
		            $object->getActiveSheet()->getStyle('D'.$row)->applyFromArray($aligncenter);
		            $object->getActiveSheet()->getStyle('E'.$row.':F'.$row)->applyFromArray($alignleft);
		            $object->getActiveSheet()->getStyle('G'.$row.':H'.$row)->applyFromArray($alignright);
		            $object->getActiveSheet()->getStyle('I'.$row.':K'.$row)->applyFromArray($aligncenter);
		            $object->getActiveSheet()->getStyle('G'.$row.':H'.$row)->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');
					$object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->getAlignment()->setWrapText(true);
		            $object->getActiveSheet()->getRowDimension($row)->setRowHeight(28);
			        $row++; $nom++; $totdpp[$vUrut] += $value2['dpp']; $totpph[$vUrut] += $value2['pph'];
			        $jenis_jasa_nya = str_replace(' ','>',$value2['jenis_jasa']);
			        if (!isset($totdppperjasa[$vUrut][strtoupper($jenis_jasa_nya)])) {
			        	$totdppperjasa[$vUrut][strtoupper($jenis_jasa_nya)] = 0;
			        }
			        if (!isset($totpphperjasa[$vUrut][strtoupper($jenis_jasa_nya)])) {
			        	$totpphperjasa[$vUrut][strtoupper($jenis_jasa_nya)] = 0;
			        }
			        $totdppperjasa[$vUrut][strtoupper($jenis_jasa_nya)] += $value2['dpp'];
			        $totpphperjasa[$vUrut][strtoupper($jenis_jasa_nya)] += $value2['pph'];
			       }
			       $object->getActiveSheet()->mergeCells('J'.($row-($a)).':J'.($row-1));
		        } 
	        }else{
		        	for($a = 0; $a < 1; $a++){
		        	$object->setActiveSheetIndex(0)
		                    ->setCellValue('A'.$row,'')
		                    ->setCellValue('B'.$row,'')
		                    ->setCellValue('C'.$row,'')
		                    ->setCellValue('D'.$row,'')
		                    ->setCellValue('E'.$row,'')
		                    ->setCellValue('F'.$row,'')
		                    ->setCellValue('G'.$row,'')
		                    ->setCellValue('H'.$row,'')
		                    ->setCellValue('I'.$row,'')
		                    ->setCellValue('J'.$row,'')
		                    ->setCellValue('K'.$row,'');
			        $object->getActiveSheet()->getColumnDimension('A')->setWidth(6);
		            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($border_all);
		            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($Font13Reg);
		            $object->getActiveSheet()->getRowDimension($row)->setRowHeight(28);
			        $row++; $nom++;
			       }
	        }
	        	$object->getActiveSheet()->mergeCells('A'.$row.':F'.$row);
	        	$kettot = ($arrayRekap[$vUrut]['KODEPAJAK'] == '411124-100') ? $arrayRekap[$vUrut]['JENIS_PPH'].' '.$arrayRekap[$vUrut]['LOKASI'] : $arrayRekap[$vUrut]['JENIS_PPH'];
	        	$object->setActiveSheetIndex(0)
	                    ->setCellValue('A'.$row,'TOTAL '.$kettot)
	                    ->setCellValue('G'.$row, $totdpp[$vUrut])
	                    ->setCellValue('H'.$row, $totpph[$vUrut]);
	            $object->getActiveSheet()->getRowDimension($row)->setRowHeight(28);
	            $object->getActiveSheet()->getRowDimension(($row+1))->setRowHeight(28);
	            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($Font13Bold);
	            $object->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray($aligncenter);
	            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray($border_all);
	            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');
	            $object->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray(
	           array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffcccc')))
	           );

	        $row+=2;
            // }
	        endif;
	        }
            //foooter
            $object->getActiveSheet()->mergeCells('E'.($row+2).':E'.($row+3));
            $object->getActiveSheet()->mergeCells('E'.($row+6).':E'.($row+8));
            $object->setActiveSheetIndex(0)
	                    ->setCellValue('E'.$row,'REKAP PEMBAYARAN PPH 23')
	                    ->setCellValue('E'.($row+1),'KODE AKUN PAJAK')
	                    ->setCellValue('E'.($row+2),'411124 – 100')
	                    ->setCellValue('E'.($row+4),'TOTAL KODE AKUN 411124 – 100')
	                    ->setCellValue('E'.($row+6),'411124 – 104')
	                    ->setCellValue('E'.($row+9),'TOTAL KODE AKUN 411124 – 104')
	                    ->setCellValue('E'.($row+11),'TOTAL PAJAK PPH 23')
	                    ->setCellValue('E'.($row+12),'TOTAL PAJAK PPH 23/26')
	                    ->setCellValue('E'.($row+14),'DETAIL RINCIAN JASA LAIN');
	                    $object->getActiveSheet()->getStyle('E'.$row.':E'.($row+14))->applyFromArray($aligncenter);
	                    $object->getActiveSheet()->getStyle('E'.($row+2).':E'.($row+13))->applyFromArray($Font13Bold);
	                    $object->getActiveSheet()->getStyle('E'.$row.':E'.($row+1))->applyFromArray($Font13BoldU);
	                    $object->getActiveSheet()->getStyle('E'.($row+14))->applyFromArray($Font13BoldU);
	         $object->setActiveSheetIndex(0)
	                    ->setCellValue('F'.($row+2),'Hadiah')
	                    ->setCellValue('F'.($row+3),'Sewa Aktiva')
	                    ->setCellValue('F'.($row+6),'Teknik')
	                    ->setCellValue('F'.($row+7),'Manajemen')
	                    ->setCellValue('F'.($row+8),'Jasa Lain sesuai PMK – 244/PMK.03/2008');
	                    $object->getActiveSheet()->getStyle('F'.$row.':F'.($row+8))->applyFromArray($Font13Reg);

	        $pph23_dpp_pusat_bonus = isset($totdppperjasa['213103-YOGYAKARTA']['HADIAH']) ? $totdppperjasa['213103-YOGYAKARTA']['HADIAH'] : 0;
	        $pph23_pph_pusat_bonus = isset($totpphperjasa['213103-YOGYAKARTA']['HADIAH']) ? $totpphperjasa['213103-YOGYAKARTA']['HADIAH'] : 0;
	        $pph23_dpp_tuksono_bonus = isset($totdppperjasa['213103-TUKSONO']['HADIAH']) ? $totdppperjasa['213103-TUKSONO']['HADIAH'] : 0;
	        $pph23_pph_tuksono_bonus = isset($totpphperjasa['213103-TUKSONO']['HADIAH']) ? $totpphperjasa['213103-TUKSONO']['HADIAH'] : 0;
	        $pph23_dpp_pusat_sewa = isset($totdppperjasa['213103-YOGYAKARTA']['SEWA>AKTIVA']) ? $totdppperjasa['213103-YOGYAKARTA']['SEWA>AKTIVA'] : 0;
	        $pph23_pph_pusat_sewa = isset($totpphperjasa['213103-YOGYAKARTA']['SEWA>AKTIVA']) ? $totpphperjasa['213103-YOGYAKARTA']['SEWA>AKTIVA'] : 0;
	        $pph23_dpp_tuksono_sewa = isset($totdppperjasa['213103-TUKSONO']['SEWA>AKTIVA']) ? $totdppperjasa['213103-TUKSONO']['SEWA>AKTIVA'] : 0;
	        $pph23_pph_tuksono_sewa = isset($totpphperjasa['213103-TUKSONO']['SEWA>AKTIVA']) ? $totpphperjasa['213103-TUKSONO']['SEWA>AKTIVA'] : 0;
	        $tot_pph23_dpp_pusat_sewa_bonus = $pph23_dpp_pusat_bonus+$pph23_dpp_pusat_sewa;
			$tot_pph23_pph_pusat_sewa_bonus = $pph23_pph_pusat_sewa+$pph23_pph_pusat_bonus;
			$tot_pph23_dpp_tuksono_sewa_bonus = $pph23_dpp_tuksono_sewa+$pph23_dpp_tuksono_bonus;
			$tot_pph23_pph_tuksono_sewa_bonus = $pph23_pph_tuksono_bonus+$pph23_pph_tuksono_sewa;

			$pph23_dpp_pusat_teknik = isset($totdppperjasa['213103-YOGYAKARTA']['TEKNIK']) ? $totdppperjasa['213103-YOGYAKARTA']['TEKNIK'] : 0;
	        $pph23_pph_pusat_teknik = isset($totpphperjasa['213103-YOGYAKARTA']['TEKNIK']) ? $totpphperjasa['213103-YOGYAKARTA']['TEKNIK'] : 0;
	        $pph23_dpp_tuksono_teknik = isset($totdppperjasa['213103-TUKSONO']['TEKNIK']) ? $totdppperjasa['213103-TUKSONO']['TEKNIK'] : 0;
	        $pph23_pph_tuksono_teknik = isset($totpphperjasa['213103-TUKSONO']['TEKNIK']) ? $totpphperjasa['213103-TUKSONO']['TEKNIK'] : 0;
	        $pph23_dpp_pusat_mnj = isset($totdppperjasa['213103-YOGYAKARTA']['MANAGEMENT']) ? $totdppperjasa['213103-YOGYAKARTA']['MANAGEMENT'] : 0;
	        $pph23_pph_pusat_mnj = isset($totpphperjasa['213103-YOGYAKARTA']['MANAGEMENT']) ? $totpphperjasa['213103-YOGYAKARTA']['MANAGEMENT'] : 0;
	        $pph23_dpp_tuksono_mnj = isset($totdppperjasa['213103-TUKSONO']['MANAGEMENT']) ? $totdppperjasa['213103-TUKSONO']['MANAGEMENT'] : 0;
	        $pph23_pph_tuksono_mnj = isset($totpphperjasa['213103-TUKSONO']['MANAGEMENT']) ? $totpphperjasa['213103-TUKSONO']['MANAGEMENT'] : 0;
	        $array_kecuali = array('TEKNIK','MANAGEMENT','HADIAH','SEWA>AKTIVA');
			$pph23_dpp_pusat_lain = $pph23_pph_pusat_lain = $pph23_pph_tuksono_lain = $pph23_dpp_tuksono_lain = 0;
			
			if ( isset($totpphperjasa['213103-TUKSONO']) ) {
				foreach ($totpphperjasa['213103-TUKSONO'] as $kj => $vj) {
					if (!in_array($kj, $array_kecuali)) {
						$pph23_pph_tuksono_lain += $vj;
						$pph23_dpp_tuksono_lain += $totdppperjasa['213103-TUKSONO'][$kj];
					}
				}
			}

			if ( isset($totpphperjasa['213103-YOGYAKARTA']) ) {
				foreach ($totpphperjasa['213103-YOGYAKARTA'] as $kj => $vj) {
					if (!in_array($kj, $array_kecuali)) {
						$pph23_pph_pusat_lain += $vj;
						$pph23_dpp_pusat_lain += $totdppperjasa['213103-YOGYAKARTA'][$kj];
					}
				}
			}

	        $tot_pph23_dpp_pusat_104 = $pph23_dpp_pusat_teknik+$pph23_dpp_pusat_mnj+$pph23_dpp_pusat_lain;
			$tot_pph23_pph_pusat_104 = $pph23_pph_pusat_teknik+$pph23_pph_pusat_mnj+$pph23_pph_pusat_lain;
			$tot_pph23_dpp_tuksono_104 = $pph23_dpp_tuksono_teknik+$pph23_dpp_tuksono_mnj+$pph23_dpp_tuksono_lain;
			$tot_pph23_pph_tuksono_104 = $pph23_pph_tuksono_teknik+$pph23_pph_tuksono_mnj+$pph23_pph_tuksono_lain;

			$tot_pph23_dpp_kodeakun_pusat = $tot_pph23_dpp_pusat_104+$tot_pph23_dpp_pusat_sewa_bonus;
			$tot_pph23_pph_kodeakun_pusat = $tot_pph23_pph_pusat_104+$tot_pph23_pph_pusat_sewa_bonus;
			$tot_pph23_dpp_kodeakun_tuksono = $tot_pph23_dpp_tuksono_104+$tot_pph23_dpp_tuksono_sewa_bonus;
			$tot_pph23_pph_kodeakun_tuksono = $tot_pph23_pph_tuksono_104+$tot_pph23_pph_tuksono_sewa_bonus;

	        $object->getActiveSheet()->mergeCells('G'.($row).':H'.($row));
	        $object->getActiveSheet()->mergeCells('J'.($row).':K'.($row));
	        $object->setActiveSheetIndex(0)
	                    ->setCellValue('G'.($row),'PUSAT')
	                    ->setCellValue('J'.($row),'TUKSONO')
	                    ->setCellValue('G'.($row+1),'DPP')
	                    ->setCellValue('H'.($row+1),'PPH')
	                    ->setCellValue('J'.($row+1),'DPP')
	                    ->setCellValue('K'.($row+1),'PPH')
	                    ->setCellValue('G'.($row+2),($pph23_dpp_pusat_bonus ? $pph23_dpp_pusat_bonus : ''))
	                    ->setCellValue('H'.($row+2),($pph23_pph_pusat_bonus ? $pph23_pph_pusat_bonus : ''))
	                    ->setCellValue('J'.($row+2),($pph23_dpp_tuksono_bonus ? $pph23_dpp_tuksono_bonus : ''))
	                    ->setCellValue('K'.($row+2),($pph23_pph_tuksono_bonus ? $pph23_pph_tuksono_bonus : ''))
	                    ->setCellValue('G'.($row+3),($pph23_dpp_pusat_sewa ? $pph23_dpp_pusat_sewa : ''))
	                    ->setCellValue('H'.($row+3),($pph23_pph_pusat_sewa ? $pph23_pph_pusat_sewa : ''))
	                    ->setCellValue('J'.($row+3),($pph23_dpp_tuksono_sewa ? $pph23_dpp_tuksono_sewa : ''))
	                    ->setCellValue('K'.($row+3),($pph23_pph_tuksono_sewa ? $pph23_pph_tuksono_sewa : ''))
	                    ->setCellValue('G'.($row+4),($tot_pph23_dpp_pusat_sewa_bonus ? $tot_pph23_dpp_pusat_sewa_bonus : ''))
	                    ->setCellValue('H'.($row+4),($tot_pph23_pph_pusat_sewa_bonus ? $tot_pph23_pph_pusat_sewa_bonus : ''))
	                    ->setCellValue('J'.($row+4),($tot_pph23_dpp_tuksono_sewa_bonus ? $tot_pph23_dpp_tuksono_sewa_bonus : ''))
	                    ->setCellValue('K'.($row+4),($tot_pph23_pph_tuksono_sewa_bonus ? $tot_pph23_pph_tuksono_sewa_bonus : ''))
	                    ->setCellValue('G'.($row+6),($pph23_dpp_pusat_teknik ? $pph23_dpp_pusat_teknik : ''))
	                    ->setCellValue('H'.($row+6),($pph23_pph_pusat_teknik ? $pph23_pph_pusat_teknik : ''))
	                    ->setCellValue('J'.($row+6),($pph23_dpp_tuksono_teknik ? $pph23_dpp_tuksono_teknik : ''))
	                    ->setCellValue('K'.($row+6),($pph23_pph_tuksono_teknik ? $pph23_pph_tuksono_teknik : ''))
	                    ->setCellValue('G'.($row+7),($pph23_dpp_pusat_mnj ? $pph23_dpp_pusat_mnj : ''))
	                    ->setCellValue('H'.($row+7),($pph23_pph_pusat_mnj ? $pph23_pph_pusat_mnj : ''))
	                    ->setCellValue('J'.($row+7),($pph23_dpp_tuksono_mnj ? $pph23_dpp_tuksono_mnj : ''))
	                    ->setCellValue('K'.($row+7),($pph23_pph_tuksono_mnj ? $pph23_pph_tuksono_mnj : ''))
	                    ->setCellValue('G'.($row+8),($pph23_dpp_pusat_lain ? $pph23_dpp_pusat_lain : ''))
	                    ->setCellValue('H'.($row+8),($pph23_pph_pusat_lain ? $pph23_pph_pusat_lain : ''))
	                    ->setCellValue('J'.($row+8),($pph23_dpp_tuksono_lain ? $pph23_dpp_tuksono_lain : ''))
	                    ->setCellValue('K'.($row+8),($pph23_pph_tuksono_lain ? $pph23_pph_tuksono_lain : ''))
	                    ->setCellValue('G'.($row+9),$tot_pph23_dpp_pusat_104)
	                    ->setCellValue('H'.($row+9),$tot_pph23_pph_pusat_104)
	                    ->setCellValue('J'.($row+9),$tot_pph23_dpp_tuksono_104)
	                    ->setCellValue('K'.($row+9),$tot_pph23_pph_tuksono_104)
	                    ->setCellValue('G'.($row+11),$tot_pph23_dpp_kodeakun_pusat)
	                    ->setCellValue('H'.($row+11),$tot_pph23_pph_kodeakun_pusat)
	                    ->setCellValue('J'.($row+11),$tot_pph23_dpp_kodeakun_tuksono)
	                    ->setCellValue('K'.($row+11),$tot_pph23_pph_kodeakun_tuksono)
	                    ->setCellValue('G'.($row+14),'PUSAT')
	                    ->setCellValue('J'.($row+14),'TUKSONO')
	                    ->setCellValue('G'.($row+15),'DPP')
	                    ->setCellValue('H'.($row+15),'PPH')
	                    ->setCellValue('J'.($row+15),'DPP')
	                    ->setCellValue('K'.($row+15),'PPH');
	                     $object->getActiveSheet()->mergeCells('G'.($row+14).':H'.($row+14));
				         $object->getActiveSheet()->mergeCells('J'.($row+14).':K'.($row+14));
	                     $object->getActiveSheet()->getStyle('G'.($row+14).':K'.($row+15))->applyFromArray($aligncenter);
	                     $object->getActiveSheet()->getStyle('G'.($row+14).':K'.($row+14))->applyFromArray($Font13Bold);
	                     $object->getActiveSheet()->getStyle('G'.($row+15).':K'.($row+15))->applyFromArray($Font13BoldU);
	                     $object->getActiveSheet()->getStyle('G'.($row+2).':K'.($row+14))->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');
	                     $object->getActiveSheet()->getStyle('G'.$row.':H'.$row)->applyFromArray($border_top_bot);
	                     $object->getActiveSheet()->getStyle('G'.($row).':K'.($row+9))->applyFromArray($Font13Reg);
	                     $object->getActiveSheet()->getStyle('G'.($row+4).':K'.($row+4))->applyFromArray($Font13Bold);
	                     $object->getActiveSheet()->getStyle('G'.($row+9).':K'.($row+9))->applyFromArray($Font13Bold);
	                     $object->getActiveSheet()->getStyle('G'.($row+11).':K'.($row+11))->applyFromArray($Font13Bold);
	                     $object->getActiveSheet()->getStyle('G'.($row+3).':H'.($row+3))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('G'.($row+8).':H'.($row+8))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('G'.($row+9).':H'.($row+9))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('G'.($row+10).':H'.($row+10))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('G'.($row+11).':H'.($row+11))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('G'.($row+12).':H'.($row+12))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('G'.$row.':H'.$row)->applyFromArray($aligncenter);
	                     $object->getActiveSheet()->getStyle('G'.$row.':H'.$row)->applyFromArray($Font13Bold);
	                     $object->getActiveSheet()->getStyle('J'.$row.':K'.$row)->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('G'.($row+11).':H'.($row+11))->applyFromArray(
				           array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'e5e5ff')))
				           );
	                    $object->getActiveSheet()->getStyle('G'.($row+12).':H'.($row+12))->applyFromArray(
				           array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'e5e5ff')))
				           );
	                    $object->getActiveSheet()->getStyle('J'.($row+11).':K'.($row+11))->applyFromArray(
				           array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'e5e5ff')))
				           );

	                     $object->getActiveSheet()->getStyle('J'.($row+3).':K'.($row+3))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('J'.($row+8).':K'.($row+8))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('J'.($row+9).':K'.($row+9))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('J'.($row+10).':K'.($row+10))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('J'.($row+11).':K'.($row+11))->applyFromArray($border_bot);
	                     $object->getActiveSheet()->getStyle('J'.($row+14).':K'.($row+14))->applyFromArray($border_top_bot);
	                     $object->getActiveSheet()->getStyle('G'.($row+14).':H'.($row+14))->applyFromArray($border_top_bot);
	                     $object->getActiveSheet()->getStyle('J'.$row.':K'.$row)->applyFromArray($aligncenter);
	                     $object->getActiveSheet()->getStyle('J'.$row.':K'.$row)->applyFromArray($Font13Bold);
	                     $object->getActiveSheet()->getStyle('G'.($row+1).':K'.($row+1))->applyFromArray($aligncenter);
	                     $object->getActiveSheet()->getStyle('G'.($row+1).':K'.($row+1))->applyFromArray($Font13BoldU);

	                     $object->getActiveSheet()->getStyle('J'.$row.':K'.$row)->applyFromArray($border_top_bot);

	                     $row += 16;
	        $row2 = $row;
			$tot_pusat_dpp = $tot_pusat_pph = $tot_tuksono_dpp = $tot_tuksono_pph = 0;
			if (isset($totdppperjasa['213103-YOGYAKARTA'])) {
				foreach ($totdppperjasa['213103-YOGYAKARTA'] as $kj => $vj) {
					if(!in_array($kj, $array_kecuali)){
						$jenis_jasa = ucwords(strtolower(str_replace('>', ' ', $kj)));
						$pph_pusat = isset($totpphperjasa['213103-YOGYAKARTA'][$kj]) ? $totpphperjasa['213103-YOGYAKARTA'][$kj] : 0;
						$dpp_tuksono = isset($totdppperjasa['213103-TUKSONO'][$kj]) ? $totdppperjasa['213103-TUKSONO'][$kj] : 0;
						$pph_tuksono = isset($totpphperjasa['213103-TUKSONO'][$kj]) ? $totpphperjasa['213103-TUKSONO'][$kj] : 0;
						$object->setActiveSheetIndex(0)
								->setCellValue('F'.($row2),$jenis_jasa)
								->setCellValue('G'.($row2),($vj ? $vj : ''))
								->setCellValue('H'.($row2),($pph_pusat ? $pph_pusat : ''))
								->setCellValue('J'.($row2),($dpp_tuksono ? $dpp_tuksono : ''))
								->setCellValue('K'.($row2),($pph_tuksono ? $pph_tuksono : ''));
								$tot_pusat_dpp += $vj;
								$tot_pusat_pph += $pph_pusat;
								$tot_tuksono_dpp += $dpp_tuksono;
								$tot_tuksono_pph += $pph_tuksono;
						$row2++;
					}
				}
			}
	        	$object->setActiveSheetIndex(0)
	                    ->setCellValue('F'.($row2),'TOTAL JASA LAIN')
	                    ->setCellValue('G'.($row2),$tot_pusat_dpp)
	                    ->setCellValue('H'.($row2),$tot_pusat_pph)
	                    ->setCellValue('J'.($row2),$tot_tuksono_dpp)
	                    ->setCellValue('K'.($row2),$tot_tuksono_pph);
	            $object->getActiveSheet()->getStyle('F'.($row2))->applyFromArray($Font13Bold);
	            $object->getActiveSheet()->getStyle('F'.($row).':K'.($row2-1))->applyFromArray($Font13Reg);
	            $object->getActiveSheet()->getStyle('F'.($row2))->applyFromArray($aligncenter);
	            $object->getActiveSheet()->getStyle('G'.($row2).':H'.($row2))->applyFromArray($border_top_bot);
	            $object->getActiveSheet()->getStyle('J'.($row2).':K'.($row2))->applyFromArray($border_top_bot);
	            $object->getActiveSheet()->getStyle('G'.($row2).':K'.($row2))->applyFromArray($Font13Bold);
	            $object->getActiveSheet()->getStyle('G'.($row).':K'.($row2))->getNumberFormat()->setFormatCode('#,##0;[Red]-#,##0');

	            $row3 = $row2-5;
	            $object->setActiveSheetIndex(0)
	                    ->setCellValue('B'.($row3),'Dibuat oleh,')
	                    ->setCellValue('C'.($row3),'Diperiksa oleh,')
	                    ->setCellValue('D'.($row3),'Menyetujui,')
	                    ->setCellValue('B'.($row3+1),'Tgl:    /    /       ')
	                    ->setCellValue('C'.($row3+1),'Tgl:    /    /       ')
	                    ->setCellValue('D'.($row3+1),'Tgl:    /    /       ')
	                    ->setCellValue('B'.($row2),'Bunga')
	                    ->setCellValue('C'.($row2),'Ririn')
	                    ->setCellValue('D'.($row2),'Novita Sari');
	            $object->getActiveSheet()->mergeCells('B'.($row3+2).':B'.($row3+4));
	            $object->getActiveSheet()->mergeCells('C'.($row3+2).':C'.($row3+4));
	            $object->getActiveSheet()->mergeCells('D'.($row3+2).':D'.($row3+4));
	            $object->getActiveSheet()->getStyle('B'.($row3).':D'.($row2))->applyFromArray($Font13Reg);
	            $object->getActiveSheet()->getStyle('B'.($row3).':D'.($row2))->applyFromArray($border_all);
	            $object->getActiveSheet()->getStyle('B'.($row3).':D'.($row2))->applyFromArray($aligncenter);






            // wraptext dan set print area
            // $object->getActiveSheet()->getStyle('A1:E'.$object->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
            $object->getActiveSheet()->getPageSetup()->setPrintArea('A1:L'.$object->getActiveSheet()->getHighestRow());

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REKAP LAPORAN PPH - '.$periode.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            ob_clean();
            $objWriter->save('php://output');
	}


	private function generateNumberBukpot($coa,$jenis,$lokasi,$tgltransaksi,$vendor,$batch_num){
		// $jenispph = strtoupper(str_replace(' ', '', $jenis));
		$period = date('m/Y', strtotime($tgltransaksi));
		$arrayKode = array(
					'213110' => '21Pes/',
					'213102' => '21/',
					'213103' => '23/',
					'213105' => 'Kons/',
					'213106' => 'Sewa/',
					'213108' => 'Undian/',
					'213104' => 'PS26/'
				);
		if ($arrayKode[$coa] == '21/') {
			$period21 = date('m.y', strtotime($tgltransaksi));
			$params = '1.3-'.$period21.'-%';
			$param = '1.3-'.$period21.'-';

			$getMaxNumb = $this->M_uploadpph->getMaxNumb($params,$lokasi);

			if ($getMaxNumb) {
				$maxNumb1 = $getMaxNumb[0]['nomor'];
				$maxNumb2 = substr($maxNumb1, 10 ,17);
				$maxNumb = $maxNumb2+1;
			}else {
				$maxNumb = 1;
			}
			$newNumb = str_pad($maxNumb, 8,0, STR_PAD_LEFT);

			$newNoUrut = $param.$newNumb;

			$this->M_uploadpph->updateNoUrut($jenis,$tgltransaksi,$vendor,$batch_num, $newNoUrut);
			return $newNoUrut;
		}else {
			$params = '%'.$arrayKode[$coa].$period;
			$param = $arrayKode[$coa].$period;
			$getMaxNumb = $this->M_uploadpph->getMaxNumb($params,$lokasi);
			if ($getMaxNumb) {
				$maxNumb1 = $getMaxNumb[0]['nomor'];
				$maxNumb2 = substr($maxNumb1, 0 ,3);
				$maxNumb = $maxNumb2+1;
			}else{
				$maxNumb = 1;
			}
	
			$newNumb = str_pad($maxNumb, 3,0, STR_PAD_LEFT);
			$newNoUrut = $newNumb.'/'.$param;
	
			$this->M_uploadpph->updateNoUrut($jenis,$tgltransaksi,$vendor,$batch_num, $newNoUrut);
			return $newNoUrut;
		}


	}

	private function delete_pph($no)
	{
		// echo "delete";
		$this->M_uploadpph->delete_pph($no);
		redirect('AccountPayables/CheckPPhPusatDanCabang/List');
	}

	private function archive_pph($no)
	{
		$this->M_uploadpph->archive_pph($no);
		redirect('AccountPayables/CheckPPhPusatDanCabang/List');
	}
}