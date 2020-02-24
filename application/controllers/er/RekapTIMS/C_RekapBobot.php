<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_RekapBobot extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('session');
          //load the login model
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('er/RekapTIMS/M_rekapmssql');
		$this->load->model('er/RekapTIMS/M_rekaptims');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect();
		}
	}

	//------------------------show the dashboard-----------------------------
	public function index()
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
		$this->load->view('er/RekapTIMS/RekapBobot/V_filter_rekap_bobot',$data);
		$this->load->view('V_Footer',$data);

	}

	public function tampilkanData()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS Per Area Kerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$periode1	= $this->input->post('rekapBegin');
		$periode2	= $this->input->post('rekapEnd');
		$l 			= $this->input->post('slcNoInduk[]');
		$noind 		= "";
		$jml = count($l);

		for($k=0;$k<$jml;$k++){
			$split_id = $l[$k];

			if ($noind=="") {
				$noind = "'".$split_id."'";
			}else{
				$noind = $noind.",'".$split_id."'";
			}

		}
		$keluar 	= $this->input->post('slcStatus');

		$detail 	= $this->input->post('detail');

		if($detail!=1)
		{
			$detail 	= 	0;
		}

		if ($detail==0) {
			$data['periode1']	= $periode1;
			$data['periode2']	= $periode2;
			$data['status']	= $keluar;

			$data['rekap'] = $this->M_rekaptims->rekapBobotTIM($periode1,$periode2,$noind,$keluar);
			$this->load->view('er/RekapTIMS/RekapBobot/V_data_bobot',$data);
		}else {

		$begin = new DateTime(date('Y-m-01 00:00:00', strtotime($periode1)));
		$end = new DateTime(date('Y-m-t 23:59:59', strtotime($periode2)));
		$start_year_month = date('Y-m', strtotime($periode1));
		$start_date = date('d', strtotime($periode1));
		$end_year_month = date('Y-m', strtotime($periode2));
		$end_date = date('d', strtotime($periode2));
		$interval = new DateInterval('P1M');

		$p = new DatePeriod($begin, $interval ,$end);
			foreach ($p as $d) {
				$perMonth = $d->format('Y-m');
				$monthName = $d->format('M_y');

				if ($perMonth == $start_year_month) {
					$firstdate = date('Y-m-'.$start_date.' 00:00:00', strtotime($perMonth));
				} else {
					$firstdate = date('Y-m-01 00:00:00', strtotime($perMonth));
				}

				if ($perMonth == $end_year_month) {
					$lastdate = date('Y-m-'.$end_date.' 23:59:59', strtotime($perMonth));
				} else {
					$lastdate = date('Y-m-t 23:59:59', strtotime($perMonth));
				}
				/*$data['rekap_'.$monthName] = $this->M_rekapmssql->dataRekapDetail($firstdate,$lastdate,$status,$departemen,$bidang,$unit,$section,$monthName);*/
				$data['rekap_'.$monthName] = $this->M_rekaptims->rekapBobotTIM($firstdate, $lastdate,$noind,$keluar);
			}
		$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
		$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
		$data['bobot'] = $this->M_rekaptims->rekapBobotTIM($period1,$period2,$noind,$keluar);
		// echo "<pre>";
		// print_r($data['bobot']);
		// exit();
		$data['periode1'] = $periode1;
		$data['periode2'] = $periode2;
		$data['status'] = $keluar;
		$this->load->view('er/RekapTIMS/RekapBobot/V_rekap_data_bobot',$data);
		}

	}
	public function ExportRekapDetail(){
		$detail = $this->input->post("txtDetail");
		$periode1 = $this->input->post("txtPeriode1_export");
		$periode2 = $this->input->post("txtPeriode2_export");
		$NoInduk = $this->input->post("txtNoInduk_export");
		$status = $this->input->post("txtStatus");

		//insert to sys.log_activity
		$aksi = 'REKAP TIMS';
		$detail = "Export Rekap Bobot noind= $NoInduk periode=$periode1 - $periode2";
		$this->log_activity->activity_log($aksi, $detail);
		//

		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
			)
		);
		$styleArray2 = array(
			'font'  => array(
				'bold'  => false,
				'color' => array('rgb' => 'FFFFFF'),
			)
		);

		// if ($detail == 1) {
		// 	$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
		// 	$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
		// }
		// else{
		// 	$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
		// 	$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
		// }
		/*$rekap_masakerja = $this->M_rekap_per_pekerja->data_rekap_masakerja($period2,$NoInduk,$status);
		$rekap_all = $this->M_rekap_per_pekerja->ExportRekap($period1,$period2,$NoInduk,$status);*/

		$rekap_all = $this->M_rekaptims->rekapBobotTIM($periode1, $periode2 , $NoInduk,$status);
		// echo "<pre>";
		// print_r($rekap_all);
		// exit();
		// if ($detail == 1) {
		// 	$begin = new DateTime(date('Y-m-01 00:00:00', strtotime($periode1)));
		// 	$end = new DateTime(date('Y-m-t 23:59:59', strtotime($periode2)));

		// 	$interval = new DateInterval('P1M');

		// 	$start_year_month = date('Y-m', strtotime($periode1));
		// 	$start_date = date('d', strtotime($periode1));
		// 	$end_year_month = date('Y-m', strtotime($periode2));
		// 	$end_date = date('d', strtotime($periode2));

		// 	$p = new DatePeriod($begin, $interval ,$end);

		// 	foreach ($p as $d) {
		// 		$perMonth = $d->format('Y-m');
		// 		$monthName = $d->format('M_y');

		// 		if ($perMonth == $start_year_month) {
		// 			$firstdate = date('Y-m-'.$start_date.' 00:00:00', strtotime($perMonth));
		// 		} else {
		// 			$firstdate = date('Y-m-01 00:00:00', strtotime($perMonth));
		// 		}

		// 		if ($perMonth == $end_year_month) {
		// 			$lastdate = date('Y-m-'.$end_date.' 23:59:59', strtotime($perMonth));
		// 		} else {
		// 			$lastdate = date('Y-m-t 23:59:59', strtotime($perMonth));
		// 		}

		// 		/*${'rekap_'.$monthName} = $this->M_rekap_per_pekerja->ExportDetail($firstdate,$lastdate,$NoInduk,$monthName, $status);*/
		// 		${'rekap_'.$monthName} = $this->M_rekaptims->rekapBobotTIM($firstdate, $lastdate, $NoInduk,$status);
		// 	}
		// }


		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(17);
		$worksheet->getColumnDimension('C')->setAutoSize(true);
		$worksheet->getColumnDimension('D')->setWidth(24);
		$worksheet->getColumnDimension('E')->setAutoSize(true);
		$worksheet->getColumnDimension('F')->setAutoSize(true);
		$worksheet->getColumnDimension('G')->setAutoSize(true);
		$worksheet->getColumnDimension('H')->setAutoSize(true);

		$worksheet->mergeCells('A1:B1');
		$worksheet->mergeCells('A2:B2');
		$worksheet->mergeCells('A3:B3');

		$worksheet->getStyle('A1:A3')->applyFromArray($styleArray);
		$worksheet->getStyle('C1:C3')->applyFromArray($styleArray2);
		$worksheet	->getStyle('A1:C3')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');

		$worksheet->setCellValue('A1', 'Periode');

		if ($detail == 1) {
			$periodeDate = date('F Y', strtotime($periode1)).' - '.date('F Y', strtotime($periode2));
		}
		else{
			$periodeDate = date('d-m-Y', strtotime($periode1)).' - '.date('d-m-Y', strtotime($periode2));
		}
		$worksheet->setCellValue('C1', $periodeDate, PHPExcel_Cell_DataType::TYPE_STRING);

		$worksheet->mergeCells('A6:A7');
		$worksheet->mergeCells('B6:B7');
		$worksheet->mergeCells('C6:C7');
		$worksheet->mergeCells('D6:D7');
		$worksheet->mergeCells('E6:E7');
		$worksheet->mergeCells('F6:F7');
		$worksheet->mergeCells('G6:G7');
		$worksheet->mergeCells('H6:H7');

		$worksheet->setCellValue('A6', 'No');
		$worksheet->setCellValue('B6', 'NIK');
		$worksheet->setCellValue('C6', 'NAMA');
		$worksheet->setCellValue('D6', 'MASA KERJA');
		$worksheet->setCellValue('E6', 'DEPARTEMEN');
		$worksheet->setCellValue('F6', 'BIDANG');
		$worksheet->setCellValue('G6', 'UNIT');
		$worksheet->setCellValue('H6', 'SEKSI');

		$col = '8';
		// if ($detail == 1) {
		// 	foreach ($p as $d) {
		// 		$T = PHPExcel_Cell::stringFromColumnIndex($col);
		// 		$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
		// 		$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
		// 		$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
		// 		$PSP = PHPExcel_Cell::stringFromColumnIndex($col+4);
		// 		$IP = PHPExcel_Cell::stringFromColumnIndex($col+5);
		// 		$CT = PHPExcel_Cell::stringFromColumnIndex($col+6);
		// 		$SP = PHPExcel_Cell::stringFromColumnIndex($col+7);
		// 		$worksheet->getColumnDimension($T)->setWidth(5);
		// 		$worksheet->getColumnDimension($I)->setWidth(5);
		// 		$worksheet->getColumnDimension($M)->setWidth(5);
		// 		$head_merge = $col+7;
		// 		$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
		// 		$worksheet->mergeCells($T.'6:'.$headCol.'6');
		// 		$monthName = $d->format('M/Y');
		// 		$worksheet->setCellValue($T.'6', $monthName);
		// 		$worksheet->setCellValue($T.'7', 'T');
		// 		$worksheet->setCellValue($I.'7', 'I');
		// 		$worksheet->setCellValue($M.'7', 'M');
		// 		$col=$col+3;
		// 	}
		// }

		$T = PHPExcel_Cell::stringFromColumnIndex($col);
		$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
		$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
		$worksheet->getColumnDimension($T)->setWidth(5);
		$worksheet->getColumnDimension($I)->setWidth(5);
		$worksheet->getColumnDimension($M)->setWidth(5);
		$head_merge = $col+2;
		$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
		$worksheet->mergeCells($T.'6:'.$headCol.'6');
		$worksheet->setCellValue($T.'6', 'REKAP');
		$worksheet->setCellValue($T.'7', 'T');
		$worksheet->setCellValue($I.'7', 'I');
		$worksheet->setCellValue($M.'7', 'M');



		$no = 1;
		$highestRow = $worksheet->getHighestRow()+1;
		foreach ($rekap_all as $rekap_data) {

			$worksheet->setCellValue('A'.$highestRow, $no++);
			$worksheet->setCellValue('B'.$highestRow, $rekap_data['noind'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$highestRow, str_replace('  ', '', $rekap_data['nama']));
			$worksheet->setCellValue('D'.$highestRow, $rekap_data['masa_kerja']);
			$worksheet->setCellValue('E'.$highestRow, $rekap_data['dept']);
			$worksheet->setCellValue('F'.$highestRow, $rekap_data['bidang']);
			$worksheet->setCellValue('G'.$highestRow, $rekap_data['unit']);
			$worksheet->setCellValue('H'.$highestRow, $rekap_data['seksi']);


			$col = 8;
			// if ($detail == 1) {
			// 	foreach ($p as $d) {
			// 		$monthName = $d->format('M_y');
			// 		foreach (${'rekap_'.$monthName} as $row) {
			// 			if ($rekap_data['noind'] == $row['noind'])
			// 			{
			// 				$Terlambat = $row['pointtt'];
			// 				$IjinPribadi = $row['pointtik'];
			// 				$Mangkir = $row['pointtm'];
			// 				$SuratKeterangan= "-";
			// 				$SakitPerusahaan= "-";
			// 				$IjinPerusahaan="-";
			// 				$CutiTahunan="-";
			// 				$SuratPeringatan="-";
			// 				if ($Terlambat == '0' or $Terlambat == '') {
			// 					$Terlambat = '-';
			// 				}
			// 				if ($IjinPribadi == '0' or $IjinPribadi == '') {
			// 					$IjinPribadi = '-';
			// 				}
			// 				if ($Mangkir == '0' or $Mangkir == '') {
			// 					$Mangkir = '-';
			// 				}


			// 			}
			// 		}
			// 		$T = PHPExcel_Cell::stringFromColumnIndex($col);
			// 		$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
			// 		$M = PHPExcel_Cell::stringFromColumnIndex($col+2);


			// 		$worksheet->setCellValue($T.$highestRow, $Terlambat, PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$worksheet->setCellValue($I.$highestRow, $IjinPribadi, PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$worksheet->setCellValue($M.$highestRow, $Mangkir, PHPExcel_Cell_DataType::TYPE_STRING);

			// 		$col=$col+3;
			// 	}
			// }

			$T = PHPExcel_Cell::stringFromColumnIndex($col);
			$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
			$M = PHPExcel_Cell::stringFromColumnIndex($col+2);

			$worksheet->setCellValue($T.$highestRow, $rekap_data['pointtt'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($I.$highestRow, $rekap_data['pointtik'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($M.$highestRow, $rekap_data['pointtm'], PHPExcel_Cell_DataType::TYPE_STRING);

			$highestRow++;
		}

		$highestColumn = $worksheet->getHighestColumn();
		$highestRow = $worksheet->getHighestRow();
		if ($detail == 1) {
			$worksheet->getStyle('A6:'.$highestColumn.'7')->applyFromArray($styleArray);
			$worksheet	->getStyle('A6:'.$highestColumn.'7')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('0099ff');
			$worksheet->getStyle('A6:'.$highestColumn.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A6:'.$highestColumn.'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}
		else{
			$worksheet->getStyle('A6:K7')->applyFromArray($styleArray);
			$worksheet	->getStyle('A6:K7')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('0099ff');
			$worksheet->getStyle('A6:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A6:K7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}
		$worksheet->freezePaneByColumnAndRow(4, 8);

		$worksheet->getStyle('D8:'.$highestColumn.$highestRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		if ($detail == 1) {
			$fileName = 'Rekap_With_Detail';
		}
		else{
			$fileName = 'Rekap_Without_Detail';
		}

		$worksheet->setTitle('Rekap TIMS');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$fileName.'-'.time().'.xlsx"');
		$objWriter->save("php://output");
	}

	public function ExportRekapDetailExcel()
	{
		$detail = $this->input->post("txtDetail");
		$periode1 = $this->input->post("txtPeriode1_export");
		$periode2 = $this->input->post("txtPeriode2_export");
		$NoInduk = $this->input->post("txtNoInduk_export");
		$status = $this->input->post("txtStatus");

		//insert to sys.log_activity
		$aksi = 'REKAP TIMS';
		$detail = "Export rekap detail Excel noind=$NoInduk periode=$periode1 - $periode2";
		$this->log_activity->activity_log($aksi, $detail);
		//

		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
			)
		);
		$styleArray2 = array(
			'font'  => array(
				'bold'  => false,
				'color' => array('rgb' => 'FFFFFF'),
			)
		);

		if ($detail == 1) {
			$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
			$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
		}
		else{
			$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
			$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
		}
		/*$rekap_masakerja = $this->M_rekap_per_pekerja->data_rekap_masakerja($period2,$NoInduk,$status);
		$rekap_all = $this->M_rekap_per_pekerja->ExportRekap($period1,$period2,$NoInduk,$status);*/

		$rekap_all = $this->M_rekaptims->rekapBobotTIM($period1, $period2 , $NoInduk, $status);


		if ($detail == 1) {
			$begin = new DateTime(date('Y-m-01 00:00:00', strtotime($periode1)));
			$end = new DateTime(date('Y-m-t 23:59:59', strtotime($periode2)));

			$interval = new DateInterval('P1M');

			$start_year_month = date('Y-m', strtotime($periode1));
			$start_date = date('d', strtotime($periode1));
			$end_year_month = date('Y-m', strtotime($periode2));
			$end_date = date('d', strtotime($periode2));

			$p = new DatePeriod($begin, $interval ,$end);

			foreach ($p as $d) {
				$perMonth = $d->format('Y-m');
				$monthName = $d->format('M_y');

				if ($perMonth == $start_year_month) {
					$firstdate = date('Y-m-'.$start_date.' 00:00:00', strtotime($perMonth));
				} else {
					$firstdate = date('Y-m-01 00:00:00', strtotime($perMonth));
				}

				if ($perMonth == $end_year_month) {
					$lastdate = date('Y-m-'.$end_date.' 23:59:59', strtotime($perMonth));
				} else {
					$lastdate = date('Y-m-t 23:59:59', strtotime($perMonth));
				}

				/*${'rekap_'.$monthName} = $this->M_rekap_per_pekerja->ExportDetail($firstdate,$lastdate,$NoInduk,$monthName, $status);*/
				${'rekap_'.$monthName} = $this->M_rekaptims->rekapBobotTIM($firstdate, $lastdate, $NoInduk, $status);
			}
		}


		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(17);
		$worksheet->getColumnDimension('C')->setAutoSize(true);
		$worksheet->getColumnDimension('D')->setWidth(24);
		$worksheet->getColumnDimension('E')->setAutoSize(true);
		$worksheet->getColumnDimension('F')->setAutoSize(true);
		$worksheet->getColumnDimension('G')->setAutoSize(true);
		$worksheet->getColumnDimension('H')->setAutoSize(true);

		$worksheet->mergeCells('A1:B1');
		$worksheet->mergeCells('A2:B2');
		$worksheet->mergeCells('A3:B3');

		$worksheet->getStyle('A1:A3')->applyFromArray($styleArray);
		$worksheet->getStyle('C1:C3')->applyFromArray($styleArray2);
		$worksheet	->getStyle('A1:C3')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');

		$worksheet->setCellValue('A1', 'Periode');

		if ($detail == 1) {
			$periodeDate = date('F Y', strtotime($periode1)).' - '.date('F Y', strtotime($periode2));
		}
		else{
			$periodeDate = date('d-m-Y', strtotime($periode1)).' - '.date('d-m-Y', strtotime($periode2));
		}
		$worksheet->setCellValue('C1', $periodeDate, PHPExcel_Cell_DataType::TYPE_STRING);

		$worksheet->mergeCells('A6:A7');
		$worksheet->mergeCells('B6:B7');
		$worksheet->mergeCells('C6:C7');
		$worksheet->mergeCells('D6:D7');
		$worksheet->mergeCells('E6:E7');
		$worksheet->mergeCells('F6:F7');
		$worksheet->mergeCells('G6:G7');
		$worksheet->mergeCells('H6:H7');

		$worksheet->setCellValue('A6', 'No');
		$worksheet->setCellValue('B6', 'NIK');
		$worksheet->setCellValue('C6', 'NAMA');
		$worksheet->setCellValue('D6', 'MASA KERJA');
		$worksheet->setCellValue('E6', 'DEPARTEMEN');
		$worksheet->setCellValue('F6', 'BIDANG');
		$worksheet->setCellValue('G6', 'UNIT');
		$worksheet->setCellValue('H6', 'SEKSI');

		$col = '8';
		if ($detail == 1) {
			foreach ($p as $d) {
				$T = PHPExcel_Cell::stringFromColumnIndex($col);
				$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
				$M = PHPExcel_Cell::stringFromColumnIndex($col+2);

				$worksheet->getColumnDimension($T)->setWidth(5);
				$worksheet->getColumnDimension($I)->setWidth(5);
				$worksheet->getColumnDimension($M)->setWidth(5);

				$head_merge = $col+2;
				$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
				$worksheet->mergeCells($T.'6:'.$headCol.'6');
				$monthName = $d->format('M/Y');
				$worksheet->setCellValue($T.'6', $monthName);
				$worksheet->setCellValue($T.'7', 'T');
				$worksheet->setCellValue($I.'7', 'I');
				$worksheet->setCellValue($M.'7', 'M');

				$col=$col+3;
			}
		}

		$T = PHPExcel_Cell::stringFromColumnIndex($col);
		$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
		$M = PHPExcel_Cell::stringFromColumnIndex($col+2);


		$worksheet->getColumnDimension($T)->setWidth(5);
		$worksheet->getColumnDimension($I)->setWidth(5);
		$worksheet->getColumnDimension($M)->setWidth(5);



		$head_merge = $col+2;
		$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
		$worksheet->mergeCells($T.'6:'.$headCol.'6');
		$worksheet->setCellValue($T.'6', 'REKAP');
		$worksheet->setCellValue($T.'7', 'T');
		$worksheet->setCellValue($I.'7', 'I');
		$worksheet->setCellValue($M.'7', 'M');




		$no = 1;
		$highestRow = $worksheet->getHighestRow()+1;
		foreach ($rekap_all as $rekap_data) {

			$worksheet->setCellValue('A'.$highestRow, $no++);
			$worksheet->setCellValue('B'.$highestRow, $rekap_data['noind'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$highestRow, str_replace('  ', '', $rekap_data['nama']));
			$worksheet->setCellValue('D'.$highestRow, $rekap_data['masa_kerja']);
			$worksheet->setCellValue('E'.$highestRow, $rekap_data['dept']);
			$worksheet->setCellValue('F'.$highestRow, $rekap_data['bidang']);
			$worksheet->setCellValue('G'.$highestRow, $rekap_data['unit']);
			$worksheet->setCellValue('H'.$highestRow, $rekap_data['seksi']);


			$col = 8;
			if ($detail == 1) {
				foreach ($p as $d) {
					$monthName = $d->format('M_y');
					foreach (${'rekap_'.$monthName} as $row) {
						if ($rekap_data['noind'] == $row['noind'])
						{
							$Terlambat = $row['pointtt'];
							$IjinPribadi = $row['pointtik'];
							$Mangkir = $row['pointtm'];
							$SuratKeterangan= "-";
							$SakitPerusahaan= "-";
							$IjinPerusahaan="-";
							$CutiTahunan="-";
							$SuratPeringatan="-";
							if ($Terlambat == '0' or $Terlambat == '') {
								$Terlambat = '-';
							}
							if ($IjinPribadi == '0' or $IjinPribadi == '') {
								$IjinPribadi = '-';
							}
							if ($Mangkir == '0' or $Mangkir == '') {
								$Mangkir = '-';
							}


						}
					}
					$T = PHPExcel_Cell::stringFromColumnIndex($col);
					$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
					$M = PHPExcel_Cell::stringFromColumnIndex($col+2);


					$worksheet->setCellValue($T.$highestRow, $Terlambat, PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$worksheet->setCellValue($I.$highestRow, $IjinPribadi, PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$worksheet->setCellValue($M.$highestRow, $Mangkir, PHPExcel_Cell_DataType::TYPE_NUMERIC);

					$col=$col+3;
				}
			}

			$T = PHPExcel_Cell::stringFromColumnIndex($col);
			$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
			$M = PHPExcel_Cell::stringFromColumnIndex($col+2);



			$worksheet->setCellValue($T.$highestRow, $rekap_data['pointtt'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($I.$highestRow, $rekap_data['pointtik'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($M.$highestRow, $rekap_data['pointtm'], PHPExcel_Cell_DataType::TYPE_STRING);




			$highestRow++;
		}

		$highestColumn = $worksheet->getHighestColumn();
		$highestRow = $worksheet->getHighestRow();
		if ($detail == 1) {
			$worksheet->getStyle('A6:'.$highestColumn.'7')->applyFromArray($styleArray);
			$worksheet	->getStyle('A6:'.$highestColumn.'7')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('0099ff');
			$worksheet->getStyle('A6:'.$highestColumn.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A6:'.$highestColumn.'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}
		else{
			$worksheet->getStyle('A6:R7')->applyFromArray($styleArray);
			$worksheet	->getStyle('A6:R7')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('0099ff');
			$worksheet->getStyle('A6:R7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A6:R7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}
		$worksheet->freezePaneByColumnAndRow(4, 8);

		$worksheet->getStyle('D8:'.$highestColumn.$highestRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$fileName = 'Rekap_bobot_TIM';


		$worksheet->setTitle('Rekap TIMS');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$fileName.'-'.time().'.xlsx"');
		$objWriter->save("php://output");
	}



}
