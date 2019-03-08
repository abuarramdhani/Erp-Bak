<?php 

Defined('BASEPATH') or exit('No direct script access allowed');

class C_Report extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PNBPAdministrator/M_report');
		$this->load->model('PNBPAdministrator/M_questioner');

		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Report Data';
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['suku'] = $this->M_questioner->getSuku();
		$data['pendidikan'] = $this->M_questioner->getPendidikan();
		$data['dept'] = $this->M_questioner->getDept();
		$data['periode'] = $this->M_report->getPeriode();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/Report/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja(){
		$noind = $this->input->get('term');
		$prd = $this->input->get('periode');
		$data = $this->M_report->getPekerjaHasHasil($noind,$prd);
		echo json_encode($data);
	}

	public function getData(){
		$periode = $this->input->post('periode');
		$dept = $this->input->post('dept');
		$sec = $this->input->post('sec');
		$masa = $this->input->post('masa');
		$jk = $this->input->post('jk');
		$usia = $this->input->post('usia');
		$suku = $this->input->post('suku');
		$status = $this->input->post('status');
		$pendidikan = $this->input->post('pendidikan');

		if (!empty($periode)) {
			$periode = "and pdem.id_periode = '$periode'";
		}
		if (!empty($dept)) {
			$dept = "and left(pdem.kodesie,1) = '$dept'";
		}
		if (!empty($sec)) {
			$sec = "and left(pdem.kodesie,7) = left('$sec',7)";
		}
		if (!empty($masa)) {
			$masa = "and pdem.masa_kerja = '$masa'";
		}
		if (!empty($jk)) {
			$jk = "and pdem.jk = '$jk'";
		}
		if (!empty($usia)) {
			$usia = "and pdem.usia = '$usia'";
		}
		if (!empty($suku)) {
			$suku = "and pdem.suku = '$suku'";
		}
		if (!empty($status)) {
			$status = "and pdem.status_kerja = '$status'";
		}
		if (!empty($pendidikan)) {
			$pendidikan = "and pdem.pendidikan_terakhir = '$pendidikan'";
		}


		$data = $this->M_report->getData($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan);
		$label = $this->M_report->getLabel();
		$array = array();
		$i = 0;
		$j = 0;
		$kelompok = "";

		$warna = array('rgba(255,23,68,1)','rgba(3,163,244,1)','rgba(118,255,3,1)','rgba(255,235,3,1)','rgba(255,235,59,1)','rgba(121,85,72,1)','rgba(124,77,255,1)');
		$warna2 = array('rgba(255,23,68,0.1)','rgba(3,163,244,0.1)','rgba(118,255,3,0.1)','rgba(255,235,3,0.1)','rgba(255,235,59,0.1)','rgba(121,85,72,0.1)','rgba(124,77,255,0.1)');

		foreach ($data as $key) {
			if ($key['kelompok'] !== $kelompok) {
				if ($kelompok == "") {
					$i = 0;
				}else{
					$i++;
				}

				$kelompok = explode(" - ", $key['kelompok']);
				
				$array[$i]['label'] = $kelompok['1'];
				$array[$i]['borderColor'] = $warna[$i];
				$array[$i]['backgroundColor'] = $warna2[$i];
				$array[$i]['pointBackgroundColor'] = $warna[$i] ;
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
				
			}else{
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
			}
			$kelompok = $key['kelompok'];
		}

		echo json_encode($array);
	}

	public function getNama(){
		$noind = $this->input->post('noind');
		$periode = $this->input->post('periode');

		$data = $this->M_report->getDemografi($noind,$periode);
		echo json_encode($data);
	}

	public function getKepuasan(){
		$periode = $this->input->post('periode');
		$dept = $this->input->post('dept');
		$sec = $this->input->post('sec');
		$masa = $this->input->post('masa');
		$jk = $this->input->post('jk');
		$usia = $this->input->post('usia');
		$suku = $this->input->post('suku');
		$status = $this->input->post('status');
		$pendidikan = $this->input->post('pendidikan');

		if (!empty($periode)) {
			$periode = "and pdem.id_periode = '$periode'";
		}
		if (!empty($dept)) {
			$dept = "and left(pdem.kodesie,1) = '$dept'";
		}
		if (!empty($sec)) {
			$sec = "and left(pdem.kodesie,7) = left('$sec',7)";
		}
		if (!empty($masa)) {
			$masa = "and pdem.masa_kerja = '$masa'";
		}
		if (!empty($jk)) {
			$jk = "and pdem.jk = '$jk'";
		}
		if (!empty($usia)) {
			$usia = "and pdem.usia = '$usia'";
		}
		if (!empty($suku)) {
			$suku = "and pdem.suku = '$suku'";
		}
		if (!empty($status)) {
			$status = "and pdem.status_kerja = '$status'";
		}
		if (!empty($pendidikan)) {
			$pendidikan = "and pdem.pendidikan_terakhir = '$pendidikan'";
		}

		$data = $this->M_report->getKepuasan($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan);
		echo json_encode($data);
	}

	public function Pdf(){
		// print_r($_POST);exit();
		
		$periode = $this->input->post('txtPeriodeHiddenPNBP');
		$dept = $this->input->post('txtDeptHiddenPNBP');
		$sec = $this->input->post('txtSeksiHiddenPNBP');
		$masa = $this->input->post('txtMasaKerjaHiddenPNBP');
		$jk = $this->input->post('txtJenkelHiddenPNBP');
		$usia = $this->input->post('txtUsiaHiddenPNBP');
		$suku = $this->input->post('txtSukuHiddenPNBP');
		$status = $this->input->post('txtStatusHiddenPNBP');
		$pendidikan = $this->input->post('txtPendidikanHiddenPNBP');

		$a = 0;
		if (!empty($periode)) {
			$data['sort'][$a] = $this->M_report->getPeriodeR($periode);
			$periode = "and pdem.id_periode = '$periode'";
			
			$a++;
		}
		if (!empty($dept)) {
			$data['sort'][$a] = $this->M_report->getDeptR($dept);
			$dept = "and left(pdem.kodesie,1) = '$dept'";
			$a++;
		}
		if (!empty($sec)) {
			$data['sort'][$a] = $this->M_report->getSecR($sec);
			$sec = "and left(pdem.kodesie,7) = left('$sec',7)";
			$a++;
		}
		if (!empty($masa)) {
			$data['sort'][$a] = $this->M_report->getMasaR($masa);
			$masa = "and pdem.masa_kerja = '$masa'";
			$a++;
		}
		if (!empty($jk)) {
			$data['sort'][$a] = $this->M_report->getJkR($jk);
			$jk = "and pdem.jk = '$jk'";
			$a++;
		}
		if (!empty($usia)) {
			$data['sort'][$a] = $this->M_report->getUsiaR($usia);
			$usia = "and pdem.usia = '$usia'";
			$a++;
		}
		if (!empty($suku)) {
			$data['sort'][$a] = $this->M_report->getSukuR($suku);
			$suku = "and pdem.suku = '$suku'";
			$a++;
		}
		if (!empty($status)) {
			$data['sort'][$a] = $this->M_report->getStatusR($status);
			$status = "and pdem.status_kerja = '$status'";
			$a++;
		}
		if (!empty($pendidikan)) {
			$data['sort'][$a] = $this->M_report->getPendidikanR($pendidikan);
			$pendidikan = "and pdem.pendidikan_terakhir = '$pendidikan'";
			$a++;
		}

		$data['puas'] = $this->M_report->getKepuasan($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan);
		
		$data['img'] = $this->input->post('imgChartPNBP');

		// $this->load->view('PNBPAdministrator/Report/V_cetak', $data);
		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4',0,'',20,20,10,10,0,0);
		$filename = 'PnbpReport.pdf';
		

		$html = $this->load->view('PNBPAdministrator/Report/V_cetak', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function Excel(){
		$periode = $this->input->post('txtPeriodeHiddenPNBP');
		$dept = $this->input->post('txtDeptHiddenPNBP');
		$sec = $this->input->post('txtSeksiHiddenPNBP');
		$masa = $this->input->post('txtMasaKerjaHiddenPNBP');
		$jk = $this->input->post('txtJenkelHiddenPNBP');
		$usia = $this->input->post('txtUsiaHiddenPNBP');
		$suku = $this->input->post('txtSukuHiddenPNBP');
		$status = $this->input->post('txtStatusHiddenPNBP');
		$pendidikan = $this->input->post('txtPendidikanHiddenPNBP');

		$pernyataan = $this->M_report->getPernyataan($periode);
		$nm_aspek = $this->M_report->getAspek($periode);

		$a = 0;
		if (!empty($periode)) {
			$data['sort'][$a] = $this->M_report->getPeriodeR($periode);
			$periode = "and pdem.id_periode = '$periode'";
			
			$a++;
		}
		if (!empty($dept)) {
			$data['sort'][$a] = $this->M_report->getDeptR($dept);
			$dept = "and left(pdem.kodesie,1) = '$dept'";
			$a++;
		}
		if (!empty($sec)) {
			$data['sort'][$a] = $this->M_report->getSecR($sec);
			$sec = "and left(pdem.kodesie,7) = left('$sec',7)";
			$a++;
		}
		if (!empty($masa)) {
			$data['sort'][$a] = $this->M_report->getMasaR($masa);
			$masa = "and pdem.masa_kerja = '$masa'";
			$a++;
		}
		if (!empty($jk)) {
			$data['sort'][$a] = $this->M_report->getJkR($jk);
			$jk = "and pdem.jk = '$jk'";
			$a++;
		}
		if (!empty($usia)) {
			$data['sort'][$a] = $this->M_report->getUsiaR($usia);
			$usia = "and pdem.usia = '$usia'";
			$a++;
		}
		if (!empty($suku)) {
			$data['sort'][$a] = $this->M_report->getSukuR($suku);
			$suku = "and pdem.suku = '$suku'";
			$a++;
		}
		if (!empty($status)) {
			$data['sort'][$a] = $this->M_report->getStatusR($status);
			$status = "and pdem.status_kerja = '$status'";
			$a++;
		}
		if (!empty($pendidikan)) {
			$data['sort'][$a] = $this->M_report->getPendidikanR($pendidikan);
			$pendidikan = "and pdem.pendidikan_terakhir = '$pendidikan'";
			$a++;
		}

		$data_summary = $this->M_report->getData($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan);
		$label = $this->M_report->getLabel();

		$i = 0;
		$j = 0;
		$kelompok = "";

		foreach ($data_summary as $key) {
			if ($key['kelompok'] !== $kelompok) {
				if ($kelompok == "") {
					$i = 0;
				}else{
					$i++;
				}

				$kelompok = explode(" - ", $key['kelompok']);
				
				$array[$i]['label'] = $kelompok['1'];
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
				
			}else{
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
			}
			$kelompok = $key['kelompok'];
		}

		$data = $this->M_report->getPeserta($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan);
		$kepuasan = $this->M_report->getKepuasan($periode,$dept,$sec,$masa,$jk,$usia,$suku,$status,$pendidikan);

		// echo "<pre>";print_r($array);exit();

		$this->load->library('excel');

		$objPHPExcel = $this->excel->getActiveSheet();

		$objPHPExcel->setCellValue('A4','No');
		$objPHPExcel->mergeCells('A4:A6');
		$objPHPExcel->setCellValue('B4','Demografi');
		$objPHPExcel->mergeCells('B4:K4');
		$objPHPExcel->setCellValue('B5','Departemen');
		$objPHPExcel->setCellValue('C5','Unit');
		$objPHPExcel->setCellValue('D5','Seksi');
		$objPHPExcel->setCellValue('E5','Masa Kerja');
		$objPHPExcel->setCellValue('F5','Status Kerja');
		$objPHPExcel->setCellValue('G5','Pendidikan Terakhir');
		$objPHPExcel->setCellValue('H5','Usia');
		$objPHPExcel->setCellValue('I5','Jenis Kelamin');
		$objPHPExcel->setCellValue('J5','Suku');
		$objPHPExcel->setCellValue('K5','Pengisian');

		$objPHPExcel->mergeCells('B5:B6');
		$objPHPExcel->mergeCells('C5:C6');
		$objPHPExcel->mergeCells('D5:D6');
		$objPHPExcel->mergeCells('E5:E6');
		$objPHPExcel->mergeCells('F5:F6');
		$objPHPExcel->mergeCells('G5:G6');
		$objPHPExcel->mergeCells('H5:H6');
		$objPHPExcel->mergeCells('I5:I6');
		$objPHPExcel->mergeCells('J5:J6');
		$objPHPExcel->mergeCells('K5:K6');

		$num = 11;
		$simpanKelompok = "";
		$simpanColumn = "";
		$kolom_kelompok = "";
		$simpan_number = 0;
		foreach ($pernyataan as $pnyt) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($num);
			if ($simpanKelompok !== $pnyt['kelompok']) {
				$objPHPExcel->setCellValue($kolom.'4',$pnyt['kelompok']);
				if ($simpanColumn !== "") {
					$kolom_kelompok = PHPExcel_Cell::stringFromColumnIndex($num-1);
					$objPHPExcel->mergeCells($simpanColumn."4:".$kolom_kelompok."4");
				}
				$simpanColumn = $kolom;
					
			}
			$objPHPExcel->setCellValue($kolom.'5',$pnyt['no_urut']);
			$objPHPExcel->setCellValue($kolom.'6',substr($pnyt['nama_aspek'], 0,3));
			$simpanKelompok = $pnyt['kelompok'];
			$objPHPExcel->getColumnDimension($kolom)->setWidth('5');
			$num++;	
		}
		$simpan_number = $num;
		$kolom_kelompok = PHPExcel_Cell::stringFromColumnIndex($num-1);
		$objPHPExcel->mergeCells($simpanColumn."4:".$kolom_kelompok."4");

		$simpanKelompok = "";
		$simpanColumn = "";
		$kolom_kelompok = "";
		foreach ($nm_aspek as $nm_pa) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($num);
			if ($simpanKelompok !== $nm_pa['kelompok']) {
				$objPHPExcel->setCellValue($kolom.'5',$nm_pa['kelompok']);
				if ($simpanColumn !== "") {
					$kolom_kelompok = PHPExcel_Cell::stringFromColumnIndex($num-1);
					$objPHPExcel->mergeCells($simpanColumn."5:".$kolom_kelompok."5");
				}
				$simpanColumn = $kolom;
					
			}
			$objPHPExcel->setCellValue($kolom.'6',substr($nm_pa['nama_aspek'], 0,3));
			$simpanKelompok = $nm_pa['kelompok'];
			$objPHPExcel->getColumnDimension($kolom)->setWidth('5');
			$num++;
		}
		$kolom_kelompok = PHPExcel_Cell::stringFromColumnIndex($num-1);
		$objPHPExcel->mergeCells($simpanColumn."5:".$kolom_kelompok."5");

		$kolom_total = PHPExcel_Cell::stringFromColumnIndex($simpan_number);
		$objPHPExcel->setCellValue($kolom_total.'4','Total');
		$objPHPExcel->mergeCells($kolom_total."4:".$kolom_kelompok."4");
		

		$angka = 1;
		foreach ($data as $dt) {
			$objPHPExcel->setCellValue('A'.($angka+6),$angka);
			$objPHPExcel->setCellValue('B'.($angka+6),$dt['department_name']);
			$objPHPExcel->setCellValue('C'.($angka+6),$dt['unit']);
			$objPHPExcel->setCellValue('D'.($angka+6),$dt['seksi']);
			$objPHPExcel->setCellValue('E'.($angka+6),$dt['masa_kerja']);
			$objPHPExcel->setCellValue('F'.($angka+6),$dt['status_kerja']);
			$objPHPExcel->setCellValue('G'.($angka+6),$dt['pendidikan']);
			$objPHPExcel->setCellValue('H'.($angka+6),$dt['usia']);
			$objPHPExcel->setCellValue('I'.($angka+6),$dt['jk']);
			$objPHPExcel->setCellValue('J'.($angka+6),$dt['suku']);
			$objPHPExcel->setCellValue('K'.($angka+6),$dt['created_date']);

			$nilai = $this->M_report->getNilaiPeserta($dt['noind'],$dt['id_periode']);
			$no = 11;
			foreach ($nilai as $nil) {
				$kolom = PHPExcel_Cell::stringFromColumnIndex($no);
				$objPHPExcel->setCellValue($kolom.($angka+6),$nil['nilai']);
				$no++;
			}
			
			$total = $this->M_report->getAkumulasiPeserta($dt['noind'],$dt['id_periode']);
			foreach ($total as $ttl) {
				$kolom = PHPExcel_Cell::stringFromColumnIndex($no);
				$objPHPExcel->setCellValue($kolom.($angka+6),$ttl['nilai']);
				$no++;
			}

			$angka++;
		}

		$angka2 = $angka + 10;
		$objPHPExcel->setCellValue('B'.$angka2,'Aspek');
		$angka2++;
		foreach ($label as $lbl) {
			$objPHPExcel->setCellValue('B'.$angka2,$lbl['nama_aspek']);
			$angka2++;
		}
		
		$col = 2;
		foreach ($array as $arr) {
			$angka2 = $angka + 10;
			$clm = PHPExcel_Cell::stringFromColumnIndex($col);
			$objPHPExcel->setCellValue($clm.$angka2,$arr['label']);
			$angka2++;
			foreach ($arr['data'] as $val) {
				$objPHPExcel->setCellValue($clm.$angka2,$val);

				$angka2++;
			}
			$col++;
		}

		//style

		$objPHPExcel->getColumnDimension('A')->setWidth('5');
		$objPHPExcel->getColumnDimension('B')->setWidth('20');
		$objPHPExcel->getColumnDimension('C')->setWidth('20');
		$objPHPExcel->getColumnDimension('D')->setWidth('20');
		$objPHPExcel->getColumnDimension('E')->setWidth('20');
		$objPHPExcel->getColumnDimension('F')->setWidth('20');
		$objPHPExcel->getColumnDimension('G')->setWidth('20');
		$objPHPExcel->getColumnDimension('H')->setWidth('20');
		$objPHPExcel->getColumnDimension('I')->setWidth('20');
		$objPHPExcel->getColumnDimension('J')->setWidth('20');
		$objPHPExcel->getColumnDimension('K')->setWidth('20');

		$objPHPExcel->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					),
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A4:'.$kolom.($angka+5));
		$objPHPExcel->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					),
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'B'.($angka+10).':'.$clm.($angka2-1));
		$objPHPExcel->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'B6:K'.($angka+5));
		$objPHPExcel->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A6:A'.($angka+5));
		$objPHPExcel->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ffff00')
					)
				),'A4:'.$kolom.'6');
		$objPHPExcel->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ffff00')
					)
				),'B'.($angka+10).':'.$clm.($angka+10));
		$objPHPExcel->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'L6:'.$kolom.($angka+5));
		$objPHPExcel->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'C'.($angka+11).':'.$clm.($angka2-1));
		//style

		$filename ='Report_PNBP.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
		
	}
}

?>