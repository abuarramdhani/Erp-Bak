<?php
		// set_time_limit(0);
		// ini_set("memory_limit", "2048M");
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
* \
*/
class C_CetakHasil extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');

		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('Excel');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('JurnalPenilaian/M_cetakhasil');

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

		$data['Title'] = 'Cetak Hasil Penilaian';
		$data['Menu'] = 'Report Personalia';
		$data['SubMenuOne'] = 'Cetak Hasil Penilaian';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periode'] = $this->M_cetakhasil->getperiodeAssessment();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/CetakHasil/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Proses(){

		$nomor = $this->input->post('txtNoSKDU');
		$tanggal = $this->input->post('txtTanggalSKDU');
		$periode = $this->input->post('txtPeriodeSKDU');

		$pr = $this->M_cetakhasil->getPr($periode)->row_array();
		$peny = $this->M_cetakhasil->get_penyesuaian();

		$arrData = $this->M_cetakhasil->getAssessment($periode);

		$lnoind = implode("', '", array_column($arrData, 'noind'));
		$arrMutasi = $this->M_cetakhasil->getlmutasi($lnoind, $pr['periode_awal'], $pr['periode_akhir'], $periode);

		$diffPr = date_diff(date_create($pr['periode_awal']),date_create($pr['periode_akhir']))->format("%a")+1;
		for ($i=0; $i < count($arrMutasi); $i++) { 
			$tglarr = explode(',', $arrMutasi[$i]['tglberlaku']);
			$lmarr = explode(',', $arrMutasi[$i]['lokasilm']);
			$lbarr = explode(',', $arrMutasi[$i]['lokasibr']);

			$indexmin = $pr['periode_awal'];
			$indexlast = $pr['periode_akhir'];
			$uang = $arrMutasi[$i]['kenaikan'];
			for ($x=0; $x < count($tglarr); $x++) {
				if ($lbarr[$x] == '02') {
					$minbr = $peny['tuksono'];
				}elseif ($lbarr[$x] == '03') {
					$minbr = $peny['mlati'];
				}else{
					$minbr = 0;
				}

				if ($lmarr[$x] == '02') {
					$minlm = $peny['tuksono'];
				}elseif ($lmarr[$x] == '03') {
					$minlm = $peny['mlati'];
				}else{
					$minlm = 0;
				}

				if ($x == 0) {
					//jika di 0 gunakan min lokasi lama
					$uang += date_diff(date_create($pr['periode_awal']),date_create($tglarr[$x]))->format("%a")+1/$diffPr*($uang-$minlm);
				}elseif($x != count($tglarr)-1){
					$uang += date_diff(date_create($tglarr[$x]),date_create($tglarr[$x+1]))->format("%a")/$diffPr*($uang-$minlm);
				}
				//memang menggunakan 2 if jangan else if
				if ($x == count($tglarr)-1) {
					$uang += date_diff(date_create($pr['periode_akhir']),date_create($tglarr[$x]))->format("%a")/$diffPr*($uang-$minbr);
				}
			}

			$arrMutasi[$i]['kenaikan'] = $uang;
		}
		$arrmutnoind = array_column($arrMutasi, 'noind');
		$arrHasil = array();
		$no = 0;
		foreach ($arrData as $key) {
			$arrHasil[$no] = $key;
			$arrHasil[$no]['no_skdu'] = $nomor;
			$arrHasil[$no]['tgl_skdu'] = $tanggal;
			$arrHasil[$no]['periode'] = $periode;
			$arrHasil[$no]['nominal_kenaikan'] = $arrMutasi[array_search($key['noind'], $arrmutnoind)]['kenaikan'];
			$arrHasil[$no]['gp_baru'] = $arrHasil[$no]['nominal_kenaikan']+$arrHasil[$no]['gp_lama'];

			$pkj = $this->M_cetakhasil->getPekerjaan($key['noind']);
			if (isset($pkj) and !empty($pkj)) {
				$arrHasil[$no]['pekerjaan'] = $pkj['0']['pekerjaan'];
			}
			$cek = $this->M_cetakhasil->checkHasil($periode,$key['noind']);
			if (intval($cek) !== 0) {
				$where = array(
					'noind' => $key['noind'],
					'periode' => $periode
					);
				$this->M_cetakhasil->updateHasil($arrHasil[$no],$where);
			}else{
				$this->M_cetakhasil->insertHasil($arrHasil[$no]);
			}

			
			$no++;
		}
		

		$encrypted_string = $this->encrypt->encode($nomor."tgl".$tanggal);
		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

		// echo $encrypted_string;exit();

		$user_id = $this->session->userid;

		$data['Title'] = 'Cetak Hasil Penilaian';
		$data['Menu'] = 'Report Personalia';
		$data['SubMenuOne'] = 'Cetak Hasil Penilaian';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periode'] = $this->M_cetakhasil->getperiodeAssessment();
		$data['table'] = $arrHasil;
		$data['encrypted_link'] = $encrypted_string;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/CetakHasil/V_index',$data);
		$this->load->view('V_Footer',$data);		
	}

	public function Cetak($identifier){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $identifier);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$text = explode('tgl', $plaintext_string);
		$datapekerja = $this->M_cetakhasil->getHasil($text['0'],$text['1']);
		$data['tahun'] = $this->M_cetakhasil->getTahun($text['0'],$text['1']);
		// echo "<pre>";
		// print_r($data);
		if (isset($datapekerja) and !empty($datapekerja)) {
		// $index = 0;
		// $no = 0;
		// $arrUnit = array();
		// $unit = '';
		// foreach ($datapekerja as $key) {
		// 		if ($unit !== $key['unit']) {
		// 			$index++;
		// 			$no = 0;
		// 			$arrUnit[$index][$no] = $key;
		// 			$unit = $key['unit'];
		// 		}else{
		// 			$arrUnit[$index][$no] = $key;
		// 			$unit = $key['unit'];
		// 			$no++;
					
		// 		}
		// 	}
		// }
			$cek = 0;
		$index = 0;
		$no = 0;
		$arrUnit = array();
		$unit = '';
		$jml = 0;
		$seksi = '';
		$pekerjaan = '';
		foreach ($datapekerja as $key) {
				if ($unit !== $key['unit'] or $jml == 40) {
					if ($jml < 40) {
						$no = 0;
					}
					$jml = 3;					
					$index++;
					$arrUnit[$index][$no] = $key;
					$arrUnit[$index][$no]['number'] = $no+1;
					$arrUnit[$index][$no]['jumlah'] = $jml;
					$unit = $key['unit'];
					$seksi = $key['seksi'];
					$pekerjaan = $key['pekerjaan'];
					$jml++;
					$no++;
					$cek++;
				}else{
					if ($seksi !== $key['seksi']) {
						$jml++;
					}
					if ($pekerjaan !== $key['pekerjaan']) {
						$jml++;
					}

					$arrUnit[$index][$no] = $key;
					$arrUnit[$index][$no]['number'] = $no+1;
					$arrUnit[$index][$no]['jumlah'] = $jml;
					$unit = $key['unit'];
					$seksi = $key['seksi'];
					$pekerjaan = $key['pekerjaan'];
					$no++;
					$jml++;
					$cek++;
				}
			}
		}
		// echo "<pre>".$cek;print_r($arrUnit);exit();
		$data['table'] = $arrUnit;
		$data['nomor'] = $text['0'];

		// $this->load->view('JurnalPenilaian/CetakHasil/V_cetak',$data);

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4',0,'',10,10,10,30,10,10);
		$filename = 'Lampiran.pdf';
		
		$html = $this->load->view('JurnalPenilaian/CetakHasil/V_cetak', $data, true);

		// $stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		// $pdf->WriteHTML($stylesheet1,1);
		$footer = "Halaman : {PAGENO}			 Tanggal : ".$data['tahun']['0']['tgl_skdu'];
		$pdf->setFooter($footer);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');


	}

	public function Excel($identifier){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $identifier);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$text = explode('tgl', $plaintext_string);
		$datapekerja = $this->M_cetakhasil->getHasil($text['0'],$text['1']);
		$tahun = $this->M_cetakhasil->getTahun($text['0'],$text['1']);

		if (isset($datapekerja) and !empty($datapekerja)) {
			$index = 0;
			$no = 0;
			$arrUnit = array();
			$unit = '';
			$jml = 0;
			$seksi = '';
			$pekerjaan = '';
			foreach ($datapekerja as $key) {
				if ($unit !== $key['unit']) {
					$no = 0;
					$jml = 3;					
					$index++;
					$arrUnit[$index][$no] = $key;
					$arrUnit[$index][$no]['number'] = $no+1;
					$arrUnit[$index][$no]['jumlah'] = $jml;
					$unit = $key['unit'];
					$seksi = $key['seksi'];
					$pekerjaan = $key['pekerjaan'];
					$jml++;
					$no++;
				}else{
					if ($seksi !== $key['seksi']) {
						$jml++;
					}
					if ($pekerjaan !== $key['pekerjaan']) {
						$jml++;
					}

					$arrUnit[$index][$no] = $key;
					$arrUnit[$index][$no]['number'] = $no+1;
					$arrUnit[$index][$no]['jumlah'] = $jml;
					$unit = $key['unit'];
					$seksi = $key['seksi'];
					$pekerjaan = $key['pekerjaan'];
					$no++;
					$jml++;
				}
			}
		}
		// echo "<pre>";print_r($arrUnit);exit();
			$row = 1;
		if (isset($arrUnit) and !empty($arrUnit)) {
				foreach ($arrUnit as $value ) {
					$row++;
					$this->excel->getActiveSheet()->setCellValue('A'.$row,'Lampiran Surat Keputusan Direktur Utama No. '.$text['0']);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
					$row++;
					$this->excel->getActiveSheet()->setCellValue('A'.$row,'BESAR KENAIKAN UPAH (GAJI POKOK) PEKERJA NON STAF TAHUN '.$tahun['0']['tahun']);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
					$row++;
					$this->excel->getActiveSheet()->setCellValue('A'.$row,'Per 1 Januari '.$tahun['0']['tahun']);
					$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
					$row++;
					$this->excel->getActiveSheet()->setCellValue('A'.$row,'No');
					$this->excel->getActiveSheet()->setCellValue('B'.$row,'Noind');
					$this->excel->getActiveSheet()->setCellValue('C'.$row,'Nama Operator');
					$this->excel->getActiveSheet()->setCellValue('D'.$row,'Skor');
					$this->excel->getActiveSheet()->setCellValue('E'.$row,'Gol. Nilai');
					$this->excel->getActiveSheet()->setCellValue('F'.$row,'Naik/Bulan');
					$this->excel->getActiveSheet()->setCellValue('G'.$row,'GP Lama');
					$this->excel->getActiveSheet()->setCellValue('H'.$row,'GP Baru');
					$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'borders' => array(
							'bottom' => array(
								'style' => PHPExcel_Style_Border::BORDER_THICK),
							'top' => array(
								'style' => PHPExcel_Style_Border::BORDER_THICK)
						),
					),'A'.$row.':H'.$row);
					$row++;
					if (isset($value) and !empty($value)) {
						$unit = '';
						$seksi = '';
						$pekerjaan = '';
						foreach ($value as $key) {
							if ($seksi !== $key['seksi'] or $pekerjaan !== $key['pekerjaan']) {
								if ($unit !== $key['unit']){
									$this->excel->getActiveSheet()->setCellValue('A'.$row,'*> Unit : '.$key['unit']);
									$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
									$row++;
								}
								if ($seksi !== $key['seksi']){
									$this->excel->getActiveSheet()->setCellValue('A'.$row,'**> Seksi : '.$key['seksi']);
									$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
									$row++;
								}
								$this->excel->getActiveSheet()->setCellValue('A'.$row,'Nama Pekerjaan'.$key['pekerjaan']);
								$this->excel->getActiveSheet()->setCellValue('E'.$row,'GOl Pekerjaan : '.$key['gol_kerja']);
								$this->excel->getActiveSheet()->mergeCells('A'.$row.':D'.$row);
								$this->excel->getActiveSheet()->mergeCells('E'.$row.':H'.$row);
								$row++;
								$this->excel->getActiveSheet()->setCellValue('A'.$row,$key['number']);
								$this->excel->getActiveSheet()->setCellValue('B'.$row,$key['noind']);
								$this->excel->getActiveSheet()->setCellValue('C'.$row,$key['nama']);
								$this->excel->getActiveSheet()->setCellValue('D'.$row,$key['skor']);
								$this->excel->getActiveSheet()->setCellValue('E'.$row,$key['gol_nilai']);
								$this->excel->getActiveSheet()->setCellValue('F'.$row,$key['nominal_kenaikan']);
								$this->excel->getActiveSheet()->setCellValue('G'.$row,$key['gp_lama']);
								$this->excel->getActiveSheet()->setCellValue('H'.$row,$key['gp_baru']);
								$row++;
							}else{
								$this->excel->getActiveSheet()->setCellValue('A'.$row,$key['number']);
								$this->excel->getActiveSheet()->setCellValue('B'.$row,$key['noind']);
								$this->excel->getActiveSheet()->setCellValue('C'.$row,$key['nama']);
								$this->excel->getActiveSheet()->setCellValue('D'.$row,$key['skor']);
								$this->excel->getActiveSheet()->setCellValue('E'.$row,$key['gol_nilai']);
								$this->excel->getActiveSheet()->setCellValue('F'.$row,$key['nominal_kenaikan']);
								$this->excel->getActiveSheet()->setCellValue('G'.$row,$key['gp_lama']);
								$this->excel->getActiveSheet()->setCellValue('H'.$row,$key['gp_baru']);
								$row++;
							}

							$unit = $key['unit'];
							$seksi = $key['seksi'];
							$pekerjaan = $key['pekerjaan'];
						}
					}
				}
			}	

		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('35');

		$filename = 'Hasil.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}
}
?>