<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class C_Overtime extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_overtime');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Overtime HL CM';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Overtime PHL';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_overtime',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Show(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Overtime HL CM';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Overtime PHL';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$periode = $this->input->post('periode');
		$prd = explode(" - ", $periode);

		$pekerja = $this->M_overtime->getPekerja();
		$tanggal = $this->M_overtime->getTanggal($prd['0'],$prd['1']);
		$angka = 0;
		foreach ($pekerja as $pkj) {
			$array[$angka] = array(
				'noind' 		=> $pkj['noind'],
				'nama' 			=> $pkj['nama'],
				'lokasi_kerja' 	=> $pkj['lokasi_kerja']
			);
			$angka2 = 0;
			foreach ($tanggal as $tgl) {
				$ovrtime = $this->M_overtime->getOvertime($tgl['tanggal'],$pkj['noind']);
				if (isset($ovrtime) and !empty($ovrtime)) {
					foreach ($ovrtime as $ovr) {
						$array[$angka]['data'][$angka2]['overtime'] 	= $ovr['overtime'];
						$array[$angka]['data'][$angka2]['tanggal']	= $ovr['tanggal'];
					}
				}else{
					$array[$angka]['data'][$angka2]['overtime'] 	= '0';
					$array[$angka]['data'][$angka2]['tanggal']	= $tgl['tanggal'];
				}
				$angka2++;
			}
			$angka++;
		}

		$data['data'] = $array;
		$data['tanggal'] = $tanggal;
		$data['linkExport'] = base_url('HitungHlcm/DataOvertimePHL/Excel/'.$periode);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_overtime',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Excel($periode){
		set_time_limit(0);
		$this->load->library('excel');
		$objPHPExcel = $this->excel->getActiveSheet();
		$periode = str_replace("%20", ' ', $periode);
		$prd = explode(" - ", $periode);
		$pekerja = $this->M_overtime->getPekerja();
		$tanggal = $this->M_overtime->getTanggal($prd['0'],$prd['1']);

		$objPHPExcel->setCellValue('A4','No');
		$objPHPExcel->setCellValue('B4','No Induk');
		$objPHPExcel->setCellValue('C4','Nama');
		$objPHPExcel->setCellValue('D4','lokasi_kerja');

		$objPHPExcel->mergeCells('A4:A5');
		$objPHPExcel->mergeCells('B4:B5');
		$objPHPExcel->mergeCells('C4:C5');
		$objPHPExcel->mergeCells('D4:D5');

		$num = 4;
		$simpanTanggal = "";
		$simpanKolom = "";
		foreach ($tanggal as $tgl) {
			$kolom = PHPExcel_Cell::stringFromColumnIndex($num);
			$objPHPExcel->setCellValue($kolom.'5',$tgl['tgl']);
			if ($simpanTanggal != $tgl['bulan']) {
				$objPHPExcel->setCellValue($kolom.'4',$tgl['bulan']);
				if ($simpanKolom !== "") {
					$kolom_kelompok = PHPExcel_Cell::stringFromColumnIndex($num-1);
					$objPHPExcel->mergeCells($simpanKolom."4:".$kolom_kelompok."4");
				}
				$simpanKolom = $kolom;
			}
			$simpanTanggal = $tgl['bulan'];
			$num++;
		}

		$kolom1 = PHPExcel_Cell::stringFromColumnIndex($num-1);
		$objPHPExcel->mergeCells($simpanKolom."4:".$kolom1."4");

		$kolom_total = PHPExcel_Cell::stringFromColumnIndex($num);
		$objPHPExcel->setCellValue($kolom_total.'4','Total');
		$objPHPExcel->mergeCells($kolom_total."4".":".$kolom_total."5");

		$angka = 1;
		foreach ($pekerja as $pkj) {
			$array[$angka] = array(
				'noind' 		=> $pkj['noind'],
				'nama' 			=> $pkj['nama'],
				'lokasi_kerja' 	=> $pkj['lokasi_kerja']
			);
			$objPHPExcel->setCellValue('A'.($angka+5),$angka);
			$objPHPExcel->setCellValue('B'.($angka+5),$pkj['noind']);
			$objPHPExcel->setCellValue('C'.($angka+5),$pkj['nama']);
			$objPHPExcel->setCellValue('D'.($angka+5),$pkj['lokasi_kerja']);
			$angka2 = 4;
			$total = 0;
			foreach ($tanggal as $tgl) {
				$ovrtime = $this->M_overtime->getOvertime($tgl['tanggal'],$pkj['noind']);
				$kolom2 = PHPExcel_Cell::stringFromColumnIndex($angka2);
				if (isset($ovrtime) and !empty($ovrtime)) {
					foreach ($ovrtime as $ovr) {
						$objPHPExcel->setCellValue($kolom2.($angka+5),number_format($ovr['overtime'],2));
						$total += $ovr['overtime'];
					}
				}else{
					$objPHPExcel->setCellValue($kolom2.($angka+5),'0');
				}
				$angka2++;
			}
			$kolom2 = PHPExcel_Cell::stringFromColumnIndex($angka2);
			$objPHPExcel->setCellValue($kolom2.($angka+5),number_format($total,2));
			$angka++;
		}

		//style

		$objPHPExcel->getColumnDimension('A')->setWidth('5');
		$objPHPExcel->getColumnDimension('B')->setWidth('15');
		$objPHPExcel->getColumnDimension('C')->setWidth('25');
		$objPHPExcel->getColumnDimension('D')->setWidth('15');
		$objPHPExcel->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					),
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
				),'A4:'.$kolom2.'5');
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
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'B6:D'.($angka+5));
		$objPHPExcel->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'E6:'.$kolom2.($angka+5));
		//style

		$filename ='OvertimePHLCM.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}
}
?>
