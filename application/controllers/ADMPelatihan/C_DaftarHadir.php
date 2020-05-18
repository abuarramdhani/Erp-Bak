<?php
Defined('BASEPATH') or exit('No direct script accsess allowed');
/**
 * 
 */
class C_DaftarHadir extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ADMPelatihan/M_daftarhadir');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Cetak Daftar Hadir';
		$data['Menu'] = 'Lain - Lain';
		$data['SubMenuOne'] = 'Cetak daftar hadir';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		$data['Paket'] = $this->M_daftarhadir->getPaketPelatihan();
		$data['Pelatihan'] = $this->M_daftarhadir->getPelatihan();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/DaftarHadir/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function PrintDaftarPaket($id){
		$this->load->library('excel');

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$paket = $this->M_daftarhadir->getPaketPelatihanByID($plaintext_string);
		$peserta = $this->M_daftarhadir->getPesertaPaketPelatihanByID($plaintext_string);
		$trainer = $this->M_daftarhadir->getTrainerPaketPelatihanByID($plaintext_string);

		$a1 = 0;
		$a2 = 0;
		foreach ($peserta as $value) {
			$bagiPeserta[$a1][$a2] = $value;
			$a2++;
			if ($a2%18 == 0) {
			 	$a1++;
			 	$buat = $this->excel->createSheet($a1);
			 	$buat->setTitle("$a1");
			 } 
		}
		$bbb = 0;
		$simpanNomor = 0;
		if (isset($bagiPeserta) and !empty($bagiPeserta)) {
			foreach ($bagiPeserta as $bp1) {
				$angka2 = 9;
				$this->excel->setActiveSheetIndex($bbb);
				foreach ($bp1 as $key) {
						$this->excel->getActiveSheet()->setCellValue('B'.$angka2,$key['noind']);
						$EmployeeNama = preg_replace('/\s\s+/',' ', $key['employee_name']);
						$this->excel->getActiveSheet()->setCellValue('C'.$angka2,ucwords(strtolower($EmployeeNama)));
						$this->excel->getActiveSheet()->setCellValue('D'.$angka2,ucwords(strtolower($key['seksi'])));
						$angka2++;
				}
				$bbb++;

				$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
				$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(15);

				$this->excel->getActiveSheet()->setCellValue('A1','DAFTAR HADIR '.$paket['0']['package_scheduling_name']);
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				$this->excel->getActiveSheet()->setCellValue('A2','Tanggal');
				$this->excel->getActiveSheet()->setCellValue('A3','Waktu');
				$this->excel->getActiveSheet()->setCellValue('C3',':');
				$this->excel->getActiveSheet()->setCellValue('A4','Ruang');
				$this->excel->getActiveSheet()->setCellValue('C4',':');

				$this->excel->getActiveSheet()->mergeCells('A6:A8');
				$this->excel->getActiveSheet()->setCellValue('A6','NO');
				$this->excel->getActiveSheet()->mergeCells('B6:B8');
				$this->excel->getActiveSheet()->setCellValue('B6','NO. INDUK');
				$this->excel->getActiveSheet()->mergeCells('C6:C8');
				$this->excel->getActiveSheet()->setCellValue('C6','NAMA');
				$this->excel->getActiveSheet()->mergeCells('D6:D8');
				$this->excel->getActiveSheet()->setCellValue('D6','UNIT/SEKSI');
				$this->excel->getActiveSheet()->setCellValue('E6','PARAF');

				$angka = 4;
				$angka1 = 0;
				$tanggalSimpan = "";
				$tesSimpan = "";
				$beda1 = 0;
				$beda2 = 0;
				$arrTanggal = array();
				foreach ($paket as $key) {
					if ($tanggalSimpan !== $key['date'] or $beda2 == 1) {
						if ($beda1 == 1) {
							$this->excel->getActiveSheet()->mergeCells($coorCellSimpan1.":".$coorCell7);
						}
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($angka,7,ucwords($key['date']));
						$coorCell1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($angka,7);
						$coorCellSimpan1 = $coorCell1->getCoordinate();
						$beda1 = 0;
					}else{
						$beda1 = 1;
						$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow($angka,7);
						$coorCell7 =$coorCell->getCoordinate();
					}
					
					if ($tesSimpan !== $key['scheduling_name'] or $beda1 == 1) {
						if ($beda2 == 1) {
							$this->excel->getActiveSheet()->mergeCells($coorCellSimpan2.":".$coorCell8);
						}
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($angka,8,$key['scheduling_name']);
						$coorCell2 = $this->excel->getActiveSheet()->getCellByColumnAndRow($angka,8);
						$coorCellSimpan2 = $coorCell2->getCoordinate();
						$beda2 = 0;
					}else{
						$beda2 = 1;
						$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow($angka,8);
						$coorCell8 =$coorCell->getCoordinate();
						
					}
					//start untuk paraf
					$coorCel6 = $this->excel->getActiveSheet()->getCellByColumnAndRow($angka,6);
					$coorCell6 = $coorCel6->getCoordinate();
					//end untuk paraf 
					$tanggalSimpan = $key['date'];
					$tesSimpan = $key['scheduling_name'];

					//simpan tanggal
					$arrTanggal[$angka1] = $key['date'];

					$angka++;
					$angka1++;
				}
				if ($beda1 == 1) {
					$this->excel->getActiveSheet()->mergeCells($coorCellSimpan1.":".$coorCell7);
				}
				if ($beda2 == 1) {
					$this->excel->getActiveSheet()->mergeCells($coorCellSimpan2.":".$coorCell8);
				}
				//merge paraf
				$this->excel->getActiveSheet()->mergeCells('E6:'.$coorCell6);

				$this->excel->getActiveSheet()->setCellValue('C2',ucwords(": ".$arrTanggal[0]." s/d ".$arrTanggal[$angka1-1]));
				$angka2 = 9;

				for ($i=1; $i <= 18; $i++) { 
					$simpanNomor++;

					$this->excel->getActiveSheet()->setCellValue('A'.(8+$i),$simpanNomor);
					for ($j=4; $j < $angka; $j++) { 
						$helptext = new PHPExcel_Helper_HTML;
						$hasiltext =$helptext->toRichTextObject('<sup>'.$simpanNomor.'</sup>');

						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,8+$i,$hasiltext);

						$coorCellPeserta = $this->excel->getActiveSheet()->getCellByColumnAndRow($j,8+$i);
						$coorCellSimpanPeserta = $coorCellPeserta->getCoordinate();
						$coorCellPesertaTotal = $this->excel->getActiveSheet()->getCellByColumnAndRow($j,9+$i);
						$coorCellSimpanPesertaTotal = $coorCellPesertaTotal->getCoordinate();
						$coorCellLogo = $this->excel->getActiveSheet()->getCellByColumnAndRow($j,2);
						$coorCellSimpanLogo = $coorCellLogo->getCoordinate();
					}
				}

				$this->excel->getActiveSheet()->mergeCells('A27:D27');
				$this->excel->getActiveSheet()->setCellValue('A27','TOTAL');

				$this->excel->getActiveSheet()->setCellValue('D29','TRAINER');
				$this->excel->getActiveSheet()->setCellValue('E29','PARAF');
				$CellParafTrainer = $this->excel->getActiveSheet()->getCellByColumnAndRow($angka-1,29);
				$coorCellParafTrainer = $CellParafTrainer->getCoordinate();
				$this->excel->getActiveSheet()->mergeCells('E29:'.$coorCellParafTrainer);
				$angka3 = 30;

				foreach ($trainer as $key) {
					$trainerNama = preg_replace('/\s\s+/',' ', $key['trainer_name']);
					$trainerNama = ucwords(strtolower($trainerNama));
					$this->excel->getActiveSheet()->setCellValue('D'.$angka3,$trainerNama);
					$angka3++;
					$coorCellTrainer = $this->excel->getActiveSheet()->getCellByColumnAndRow($angka-1,$angka3-1);
					$coorCellSimpanTrainer = $coorCellTrainer->getCoordinate();
				}

				$richText = new PHPExcel_RichText();
				$bintang = $richText->createTextRun('*');
				$bintang->getFont()->setSize(25);
				$bintang->getFont()->setBold(true);
				$bintang->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED));
				$richText->createText(':BACA GAMBAR LAS');
				$this->excel->getActiveSheet()->setCellValue('B29',$richText);

				//images
				$imagestr = new PHPExcel_Worksheet_Drawing();
				$imagestr->setName('logo');
				$imagestr->setDescription('logo');
				$imagestr->setPath('./assets/img/admpelatihan_daftarhadir_tr.png');
				$imagestr->setCoordinates($coorCellSimpanLogo);
				$imagestr->setResizeProportional(false);
				$imagestr->setWidth(80);
				$imagestr->setHeight(110);
				$imagestr->setWorksheet($this->excel->getActiveSheet());
				$imagesttd = new PHPExcel_Worksheet_Drawing();
				$imagesttd->setName('logo');
				$imagesttd->setDescription('logo');
				$imagesttd->setPath('./assets/img/admpelatihan_daftarhadir_ttd.png');
				$imagesttd->setCoordinates('B30');
				$imagesttd->setHeight(150);
				$imagesttd->setWorksheet($this->excel->getActiveSheet());

				//style
				$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
				$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
				$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
				$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
				
				$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						),
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_HAIR)
						),
						'fill' =>array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'startcolor' => array(
								'argb' => '00ffff00')
						)
					),'D29:'.$coorCellParafTrainer);
				$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_HAIR)
						),
						'alignment' => array(
							'wrap' => true,
							'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
						)
					),'A6:'.$coorCellSimpanPeserta);
				$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_HAIR)
						),
						'alignment' => array(
							'wrap' => true,
							'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						)
					),'D30:'.$coorCellSimpanTrainer);

				$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						),
						'fill' =>array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'startcolor' => array(
								'argb' => '00ffff00')
						)
					),'A6:'.$coorCellSimpan2);
				$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						),
						'fill' =>array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'startcolor' => array(
								'argb' => '00ffff00')
						),
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_HAIR)
						)
					),'A27:'.$coorCellSimpanPesertaTotal);
				$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						)
					),'A9:B26');
				$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						)
					),'C9:D26');
				for ($i=1; $i <= 100; $i++) { 
					$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
				}
				$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(40);

				//Paper
				$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_WorkSheet_PageSetup::ORIENTATION_LANDSCAPE);
				$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_WorkSheet_PageSetup::PAPERSIZE_A4);
				$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
				$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(1);
				$this->excel->getActiveSheet()->getPageMargins()->setTop(0.2);
				$this->excel->getActiveSheet()->getPageMargins()->setLeft(0.2);
				$this->excel->getActiveSheet()->getPageMargins()->setRight(0.2);
				$this->excel->getActiveSheet()->getPageMargins()->setBottom(0.2);
			}
		}else{
			$this->excel->getActiveSheet()->setCellValue('D6','Data Kosong, Mohon Isi Terlebih dahulu');
		}
			


			

			
			

			
			
			

		$filename ='Daftar Hadir TONS Panjang.ods';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	public function PrintDaftarPelatihan($id){
		$this->load->library('excel');

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$peserta = $this->M_daftarhadir->getPesertaPelatihanByID($plaintext_string);
		$Pelatihan = $this->M_daftarhadir->getPelatihanByID($plaintext_string);
		// echo "<pre>";
		// print_r($Pelatihan);exit();
		$a1 = 0;
		$a2 = 0;
		foreach ($peserta as $value) {
			$bagiPeserta[$a1][$a2] = $value;
			$a2++;
			if ($a2%25 == 0) {
			 	$a1++;
			 	$buat = $this->excel->createSheet($a1);
			 	$buat->setTitle("$a1");
			 } 
		}
		$bbb = 0;
		$simpanNomor = 0;
		foreach ($bagiPeserta as $bp1) {
			$angka2 = 7;
			$this->excel->setActiveSheetIndex($bbb);
			foreach ($bp1 as $key) {
					$this->excel->getActiveSheet()->setCellValue('B'.$angka2,$key['noind']);
					$EmployeeNama = preg_replace('/\s\s+/',' ', $key['employee_name']);
					$this->excel->getActiveSheet()->setCellValue('C'.$angka2,ucwords(strtolower($EmployeeNama)));
					$this->excel->getActiveSheet()->setCellValue('D'.$angka2,ucwords(strtolower($key['seksi'])));
					$angka2++;
			}
			$bbb++;

			$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
			$this->excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(15);
			$this->excel->getActiveSheet()->setCellValue('C1',"DAFTAR HADIR PESERTA\n".$Pelatihan['0']['scheduling_name']);
			$this->excel->getActiveSheet()->mergeCells('A1:B1');
			$this->excel->getActiveSheet()->mergeCells('C1:D1');
			$this->excel->getActiveSheet()->setCellValue('A2','Tanggal');
			$this->excel->getActiveSheet()->setCellValue('C2',ucwords($Pelatihan['0']['date']));
			$this->excel->getActiveSheet()->mergeCells('A2:B2');
			$this->excel->getActiveSheet()->setCellValue('A3','Waktu');
			$this->excel->getActiveSheet()->setCellValue('C3',$Pelatihan['0']['start_time']." WIB - ".$Pelatihan['0']['end_time']." WIB");
			$this->excel->getActiveSheet()->mergeCells('A3:B3');
			$this->excel->getActiveSheet()->setCellValue('A4','Ruang');
			$this->excel->getActiveSheet()->setCellValue('C4',$Pelatihan['0']['room']);
			$this->excel->getActiveSheet()->mergeCells('A4:B4');

			$this->excel->getActiveSheet()->setCellValue('A6','NO');
			$this->excel->getActiveSheet()->setCellValue('B6','NO INDUK');
			$this->excel->getActiveSheet()->setCellValue('C6','NAMA');
			$this->excel->getActiveSheet()->setCellValue('D6','UNIT/SEKSI');
			$this->excel->getActiveSheet()->setCellValue('E6','PARAF');

			for ($i=1; $i <= 25; $i++) { 
				$simpanNomor++;
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+6,$simpanNomor);
				$helptext = new PHPExcel_Helper_HTML;
				$hasiltext =$helptext->toRichTextObject('<sup>'.$simpanNomor.'</sup>');
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$i+6,$hasiltext);

			}

			$this->excel->getActiveSheet()->setCellValue('A32','TOTAL');
			$this->excel->getActiveSheet()->mergeCells('A32:D32');

			$this->excel->getActiveSheet()->setCellValue('D34','TRAINER');
			$this->excel->getActiveSheet()->setCellValue('E34','PARAF');
			$trainerNama = preg_replace('/\s\s+/',' ', $Pelatihan['0']['trainer_name']);
			$trainerNama = ucwords(strtolower($trainerNama));
			$this->excel->getActiveSheet()->setCellValue('D35',$trainerNama);

			
			//Layout
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');

			
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_HAIR)
					),
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'B6:E32');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'bottom' => array(
							'style' => PHPExcel_Style_Border::BORDER_DOUBLE)
					)
				),'A1:E1');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_HAIR)
					),
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'D34:E35');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_HAIR)
					),
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A6:B32');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ffff00')
					)
				),'A32:E32');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ffff00')
					)
				),'D34:E34');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ffff00')
					)
				),'A6:E6');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A2:C4');
			$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);
			for ($i=1; $i <= 25; $i++) { 
				if ($i%2 == 0) {
					$this->excel->getActiveSheet()->getStyle('E'.($i+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle('E'.($i+6))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				}else{
					$this->excel->getActiveSheet()->getStyle('E'.($i+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$this->excel->getActiveSheet()->getStyle('E'.($i+6))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				}
			}

			for ($i=1; $i <= 50; $i++) { 
				$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
			}
			for ($i=2; $i <= 5; $i++) { 
				$this->excel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
			}
			$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(100);
			
			//images
			$imagesQ = new PHPExcel_Worksheet_Drawing();
			$imagesQ->setName('logo');
			$imagesQ->setDescription('logo');
			$imagesQ->setPath('./assets/img/logo.png');
			$imagesQ->setCoordinates('A1');
			$imagesQ->setResizeProportional(false);
			$imagesQ->setWidth(90);
			$imagesQ->setHeight(130);
			$imagesQ->setWorksheet($this->excel->getActiveSheet());
			$imagestr = new PHPExcel_Worksheet_Drawing();
			$imagestr->setName('logo');
			$imagestr->setDescription('logo');
			$imagestr->setPath('./assets/img/admpelatihan_daftarhadir_tr.png');
			$imagestr->setCoordinates('E1');
			$imagestr->setResizeProportional(false);
			$imagestr->setWidth(120);
			$imagestr->setHeight(130);
			$imagestr->setOffsetX(65);
			$imagestr->setWorksheet($this->excel->getActiveSheet());
			$imagesttd = new PHPExcel_Worksheet_Drawing();
			$imagesttd->setName('logo');
			$imagesttd->setDescription('logo');
			$imagesttd->setPath('./assets/img/admpelatihan_daftarhadir_ttd.png');
			$imagesttd->setCoordinates('B34');
			$imagesttd->setHeight(130);
			$imagesttd->setWorksheet($this->excel->getActiveSheet());

			//Paper
			$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_WorkSheet_PageSetup::ORIENTATION_PORTRAIT);
			$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_WorkSheet_PageSetup::PAPERSIZE_A4);
			$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
			$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(1);
			$this->excel->getActiveSheet()->getPageMargins()->setTop(0.2);
			$this->excel->getActiveSheet()->getPageMargins()->setLeft(0.2);
			$this->excel->getActiveSheet()->getPageMargins()->setRight(0.2);
			$this->excel->getActiveSheet()->getPageMargins()->setBottom(0.2);
		}

		

		$filename ='Daftar Hadir Pelatihan.ods';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}
}
?>