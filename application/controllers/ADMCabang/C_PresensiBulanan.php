<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
set_time_limit(0);
/**
 *
 */
class C_PresensiBulanan extends CI_Controller
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
		$this->load->model('ADMCabang/M_presensibulanan');
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
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Presensi Bulanan';
		$data['Menu'] = 'Lihat Presensi Bulanan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['seksi'] = $this->M_presensibulanan->getSeksiByKodesie($kodesie);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/PresensiBulanan/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportExcel(){
		$this->load->library('excel');

		$kodesie = $this->session->kodesie;
		$pekerja = $this->M_presensibulanan->getPekerjaByKodesie($kodesie);
		$seksi = $this->M_presensibulanan->getSeksiByKodesie($kodesie);
		$tanggal = $this->input->post('txtPeriodePresensiHarian');
		$tgl = $this->M_presensibulanan->getTanggal($tanggal);
		$tims = $this->M_presensibulanan->rekapTIMS($tanggal,$kodesie);

		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,1,'Data Pegawai Periode '.$tanggal);


		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,3,'No Induk');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,3,'Nama');
		$this->excel->getActiveSheet()->mergeCells('A3:A4');
		$this->excel->getActiveSheet()->mergeCells('B3:B4');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('35');
		$h = 2;
		$simpanBulan = "";
		foreach ($tgl as $value) {
			if ($simpanBulan !== $value['bulan']) {
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h,3,$value['bulan']);

				if (isset($coorCellBulan2) and isset($coorCellBulan1)) {
					$this->excel->getActiveSheet()->mergeCells($coorCellSimpanBulan2.':'.$coorCellSimpanBulan1);
				}

				$coorCellBulan2 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h,3);
				$coorCellSimpanBulan2 = $coorCellBulan2->getCoordinate();
			}
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h,4,$value['tgl']);
			$simpanBulan = $value['bulan'];
			$coorCellBulan1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h,3);
			$coorCellSimpanBulan1 = $coorCellBulan1->getCoordinate();
			$coorCellTanggal1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h,4);
			$coorCellSimpanTanggal1 = $coorCellTanggal1->getCoordinate();
			$h++;
		}
		if (isset($coorCellBulan2) and isset($coorCellBulan1)) {
					$this->excel->getActiveSheet()->mergeCells($coorCellSimpanBulan2.':'.$coorCellSimpanBulan1);
				}
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h,3,'Hari Kerja');

		$h += 1;
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h,3,'Rekap');
		$coorCellBulan1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h,3);
		$coorCellSimpanBulan1 = $coorCellBulan1->getCoordinate();
		$coorCellBulan2 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h+7,3);
		$coorCellSimpanBulan2 = $coorCellBulan2->getCoordinate();
		$this->excel->getActiveSheet()->mergeCells($coorCellSimpanBulan1.':'.$coorCellSimpanBulan2);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h,4,'T');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+1,4,'I');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+2,4,'M');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+3,4,'S');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+4,4,'PSP');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+5,4,'IP');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+6,4,'CT');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+7,4,'SP');
		$coorCellTanggal1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h+7,4);
		$coorCellSimpanTanggal1 = $coorCellTanggal1->getCoordinate();

		$h += 8;
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h,3,'Persentase');
		$coorCellBulan1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h,3);
		$coorCellSimpanBulan1 = $coorCellBulan1->getCoordinate();
		$coorCellBulan2 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h+7,3);
		$coorCellSimpanBulan2 = $coorCellBulan2->getCoordinate();
		$this->excel->getActiveSheet()->mergeCells($coorCellSimpanBulan1.':'.$coorCellSimpanBulan2);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h,4,'T');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+1,4,'I');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+2,4,'M');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+3,4,'S');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+4,4,'PSP');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+5,4,'IP');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+6,4,'CT');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h+7,4,'SP');
		$coorCellTanggal1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h+7,4);
		$coorCellSimpanTanggal1 = $coorCellTanggal1->getCoordinate();

		$h += 8;
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($h,3,'TOTAL');
		$coorCellTanggal1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($h,4);
		$coorCellSimpanTanggal1 = $coorCellTanggal1->getCoordinate();

		$i = 5;
		foreach ($pekerja as $val) {
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$val['noind']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$val['nama']);
			$j = 2;

			foreach ($tgl as $key) {
				$presensi = $this->M_presensibulanan->getPresensiByNoind($val['noind'],$key['tanggal']);
				if (!empty($presensi)) {
					foreach ($presensi as $prs) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,$prs['kd_ket']);
						if ($prs['kd_ket'] !== '/') {
							$coorCellpart1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($j,$i);
							$coorCellSimpanpart1 = $coorCellpart1->getCoordinate();
						}
					}
				}else{
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,'-');
				}
				$coorCellIsi1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($j,$i);
				$coorCellSimpanIsi1 = $coorCellIsi1->getCoordinate();
				$coorCellPekerja1 = $this->excel->getActiveSheet()->getCellByColumnAndRow(1,$i);
				$coorCellSimpanPekerja1 = $coorCellPekerja1->getCoordinate();
				$j++;
			}

			foreach ($tims as $value) {
				if ($value['noind'] == $val['noind']) {
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,$value['totalhk']+$value['totalhks']);
					$j += 1;
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,intval($value['frekt'])+intval($value['frekts']));
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+1,$i,intval($value['freki'])+intval($value['frekis']));
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+2,$i,intval($value['frekm'])+intval($value['frekms']));
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+3,$i,intval($value['freksk'])+intval($value['freksks']));
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+4,$i,intval($value['frekpsp'])+intval($value['frekpsps']));
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+5,$i,intval($value['frekip'])+intval($value['frekips']));
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+6,$i,intval($value['frekct'])+intval($value['frekcts']));
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+7,$i,intval($value['freksp'])+intval($value['freksps']));
					$coorCellIsi1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($j+7,$i);
					$coorCellSimpanIsi1 = $coorCellIsi1->getCoordinate();
					$j += 8;
					if ($value['totalhk']+$value['totalhks'] !== 0) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,number_format(($value['frekt']+$value['frekts'])/ ($value['totalhk']+$value['totalhks']) * 100,2).' %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+1,$i,number_format(($value['freki']+$value['frekis'])/ ($value['totalhk']+$value['totalhks']) * 100,2).' %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+2,$i,number_format(($value['frekm']+$value['frekms'])/ ($value['totalhk']+$value['totalhks']) * 100,2).' %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+3,$i,number_format(($value['freksk']+$value['freksks'])/ ($value['totalhk']+$value['totalhks']) * 100,2).' %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+4,$i,number_format(($value['frekpsp']+$value['frekpsps'])/ ($value['totalhk']+$value['totalhks']) * 100,2).' %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+5,$i,number_format(($value['frekip']+$value['frekips'])/ ($value['totalhk']+$value['totalhks']) * 100,2).' %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+6,$i,number_format(($value['frekct']+$value['frekcts'])/ ($value['totalhk']+$value['totalhks']) * 100,2).' %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+7,$i,number_format(($value['freksp']+$value['freksps'])/ ($value['totalhk']+$value['totalhks']) * 100,2).' %');
						$total_masuk = (	($value['totalhk']+$value['totalhks']) -
											(
												($value['freki']+$value['frekis']) +
												($value['frekm']+$value['frekms']) +
												($value['freksk']+$value['freksks']) +
												($value['frekpsp']+$value['frekpsps']) +
												($value['frekip']+$value['frekips']) +
												($value['frekct']+$value['frekcts']) +
												($value['frekmnon']+$value['frekmsnon'])
											)
										) /
										(($value['totalhk']+$value['totalhks']) - ($value['frekct']+$value['frekcts']) - ($value['frekmnon']+$value['frekmsnon'])) *
										100;
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+8,$i,number_format(($total_masuk),2).' %');
					}else{
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,'0.00 %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+1,$i,'0.00 %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+2,$i,'0.00 %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+3,$i,'0.00 %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+4,$i,'0.00 %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+5,$i,'0.00 %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+6,$i,'0.00 %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+7,$i,'0.00 %');
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+8,$i,'0.00 %');
					}


					$coorCellIsi1 = $this->excel->getActiveSheet()->getCellByColumnAndRow($j+8,$i);
					$coorCellSimpanIsi1 = $coorCellIsi1->getCoordinate();
				}
			}
			$i++;
		}

		//style

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
					),'A3:'.$coorCellSimpanTanggal1);
		$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						),
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_HAIR)
						)
					),'A5:'.$coorCellSimpanIsi1);
		$this->excel->getActiveSheet()->duplicateStyleArray(
					array(
						'alignment' => array(
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
						),
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_HAIR)
						)
					),'B5:'.$coorCellSimpanPekerja1);

		for ($k=2; $k <= ($j-10); $k++) {
			$clm = PHPExcel_Cell::stringFromColumnIndex($k);
			$this->excel->getActiveSheet()->getColumnDimension($clm)->setAutoSize(false);
			$this->excel->getActiveSheet()->getColumnDimension($clm)->setWidth(5);
		}

		$this->excel->getActiveSheet()->freezePaneByColumnAndRow(2, 5);

		$filename ='Daftar Hadir Bulanan '.$tanggal.'_'.$seksi['0']['seksi'].'.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel2007');
		$writer->save('php://output');
	}
}
?>
