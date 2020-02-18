<?php
defined('BASEPATH') OR exit('No direct script access allowed');
set_time_limit(0);
class C_RekapPerPekerja extends CI_Controller {

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

		$this->load->model('er/RekapTIMS/M_rekap_per_pekerja');
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

		$data['Title'] = 'Rekap TIMS Per Pekerja';
		$data['Menu'] = 'Rekap TIMS Per Pekerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_filter_per_pekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	//------------------------show the filtering menu-----------------------------
	public function GetNoInduk(){
		$term = $this->input->get("term");
		$status = $this->input->get("stat");
		$data = $this->M_rekap_per_pekerja->GetNoInduk($term, $status);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{"NoInduk":"'.$data['noind'].'","Nama":"'.$data['nama'].'"}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	public function show_data_per_pekerja()
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS Per Pekerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$periode1	= $this->input->post('rekapBegin');
		$periode2	= $this->input->post('rekapEnd');
		$noinduk 	= $this->input->post('slcNoInduk');
		// print_r($noinduk);exit();
		$status     = $this->input->post('slcStatus');
		$detail 	= $this->input->post('detail');

		if($detail!=1)
		{
			$detail 	= 	0;
		}

		$count = count($noinduk);
		// echo $count;exit();
		$nomer_induk ="";
		foreach ($noinduk as $noind) {
			$count--;
			if ($count !== 0) {
				$nomer_induk .= '\''.$noind.'\',';
			}
			else{
				$nomer_induk .= '\''.$noind.'\'';
			}
		}
		// echo $nomer_induk[8]; exit();

		if ($detail==0) {
			$data['periode1']	= $periode1;
			$data['periode2']	= $periode2;
			$data['status']	= $status;
			/*$data['rekap_masakerja'] = $this->M_rekap_per_pekerja->data_rekap_masakerja($periode2,$nomer_induk, $status);
			$data['rekap'] = $this->M_rekap_per_pekerja->data_per_pekerja($periode1,$periode2,$nomer_induk, $status);*/

			$data['rekap'] = $this->M_rekaptims->rekapTIMS($periode1, $periode2 , FALSE, $nomer_induk);
			// print_r($data['rekap']);exit();
			$this->load->view('er/RekapTIMS/V_rekap_per_pekerja',$data);
		}
		else {
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

				/*$data['rekap_'.$monthName] = $this->M_rekap_per_pekerja->data_per_pekerja_detail($firstdate,$lastdate,$nomer_induk,$monthName, $status);*/
				$data['rekap_'.$monthName] = $this->M_rekaptims->rekapTIMS($firstdate, $lastdate, $monthName, $nomer_induk);
				// $data['rekap_'.$monthName] = $this->M_rekap_per_pekerja->data_per_pekerja_detail($periode1,$periode2,$nomer_induk,$monthName, $status);

			}

			$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
			$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
			$data['periode1']	= $period1;
			$data['periode2']	= $period2;

			$data['status']	= $status;
			/*$data['rekap'] = $this->M_rekap_per_pekerja->data_per_pekerja($periode1,$period2,$nomer_induk,$status);
			$data['rekap_masakerja'] = $this->M_rekap_per_pekerja->data_rekap_masakerja($period2,$nomer_induk,$status);*/

			$data['rekap'] = $this->M_rekaptims->rekapTIMS($periode1, $periode2, FALSE, $nomer_induk);
			// print_r($data['rekap']);exit();
			$this->load->view('er/RekapTIMS/V_detail_rekap_per_pekerja',$data);
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
		$detail = "Export Excel perpekerja tanggal=".$periode1." - ".$periode2;
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

		$rekap_all = $this->M_rekaptims->rekapTIMS($periode1, $periode2 , FALSE, $NoInduk);

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
				${'rekap_'.$monthName} = $this->M_rekaptims->rekapTIMS($firstdate, $lastdate, $monthName, $NoInduk);
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
				$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
				$PSP = PHPExcel_Cell::stringFromColumnIndex($col+4);
				$IP = PHPExcel_Cell::stringFromColumnIndex($col+5);
				$CT = PHPExcel_Cell::stringFromColumnIndex($col+6);
				$SP = PHPExcel_Cell::stringFromColumnIndex($col+7);
				$worksheet->getColumnDimension($T)->setWidth(3);
				$worksheet->getColumnDimension($I)->setWidth(3);
				$worksheet->getColumnDimension($M)->setWidth(3);
				$worksheet->getColumnDimension($S)->setWidth(3);
				$worksheet->getColumnDimension($PSP)->setWidth(8);
				$worksheet->getColumnDimension($IP)->setWidth(3);
				$worksheet->getColumnDimension($CT)->setWidth(3);
				$worksheet->getColumnDimension($SP)->setWidth(3);
				$head_merge = $col+7;
				$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
				$worksheet->mergeCells($T.'6:'.$headCol.'6');
				$monthName = $d->format('M/Y');
				$worksheet->setCellValue($T.'6', $monthName);
				$worksheet->setCellValue($T.'7', 'T');
				$worksheet->setCellValue($I.'7', 'I');
				$worksheet->setCellValue($M.'7', 'M');
				$worksheet->setCellValue($S.'7', 'S');
				$worksheet->setCellValue($PSP.'7', 'PSP');
				$worksheet->setCellValue($IP.'7', 'IP');
				$worksheet->setCellValue($CT.'7', 'CT');
				$worksheet->setCellValue($SP.'7', 'SP');
				$col=$col+8;
			}
		}

		$T = PHPExcel_Cell::stringFromColumnIndex($col);
		$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
		$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
		$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
		$PSP = PHPExcel_Cell::stringFromColumnIndex($col+4);
		$IP = PHPExcel_Cell::stringFromColumnIndex($col+5);
		$CT = PHPExcel_Cell::stringFromColumnIndex($col+6);
		$SP = PHPExcel_Cell::stringFromColumnIndex($col+7);
		$THK = PHPExcel_Cell::stringFromColumnIndex($col+8);
		$P_T = PHPExcel_Cell::stringFromColumnIndex($col+9);
		$P_I = PHPExcel_Cell::stringFromColumnIndex($col+10);
		$P_M = PHPExcel_Cell::stringFromColumnIndex($col+11);
		$P_S = PHPExcel_Cell::stringFromColumnIndex($col+12);
		$P_PSP = PHPExcel_Cell::stringFromColumnIndex($col+13);
		$P_IP = PHPExcel_Cell::stringFromColumnIndex($col+14);
		$P_CT = PHPExcel_Cell::stringFromColumnIndex($col+15);
		$P_Tot	=	PHPExcel_Cell::stringFromColumnIndex($col+16);
		$worksheet->getColumnDimension($T)->setWidth(3);
		$worksheet->getColumnDimension($I)->setWidth(3);
		$worksheet->getColumnDimension($M)->setWidth(3);
		$worksheet->getColumnDimension($S)->setWidth(3);
		$worksheet->getColumnDimension($PSP)->setWidth(8);
		$worksheet->getColumnDimension($IP)->setWidth(3);
		$worksheet->getColumnDimension($SP)->setWidth(3);
		$worksheet->getColumnDimension($CT)->setWidth(3);
		$worksheet->getColumnDimension($THK)->setWidth(18);
		$worksheet->getColumnDimension($P_T)->setWidth(10);
		$worksheet->getColumnDimension($P_I)->setWidth(10);
		$worksheet->getColumnDimension($P_M)->setWidth(10);
		$worksheet->getColumnDimension($P_S)->setWidth(10);
		$worksheet->getColumnDimension($P_PSP)->setWidth(10);
		$worksheet->getColumnDimension($P_IP)->setWidth(10);
		$worksheet->getColumnDimension($P_CT)->setWidth(10);
		$worksheet->getColumnDimension($P_Tot)->setWidth(10);
		$head_merge = $col+7;
		$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
		$worksheet->mergeCells($T.'6:'.$headCol.'6');
		$head_merge = $col+14;
		$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
		$worksheet->mergeCells($P_T.'6:'.$headCol.'6');
		$worksheet->setCellValue($T.'6', 'REKAP');
		$worksheet->setCellValue($T.'7', 'T');
		$worksheet->setCellValue($I.'7', 'I');
		$worksheet->setCellValue($M.'7', 'M');
		$worksheet->setCellValue($S.'7', 'S');
		$worksheet->setCellValue($PSP.'7', 'PSP');
		$worksheet->setCellValue($IP.'7', 'IP');
		$worksheet->setCellValue($CT.'7', 'CT');
		$worksheet->setCellValue($SP.'7', 'SP');
		$worksheet->mergeCells($THK.'6:'.$THK.'7');
		$worksheet->setCellValue($THK.'6', 'TOTAL HARI KERJA');
		$worksheet->setCellValue($P_T.'6', 'PERSENTASE');
		$worksheet->setCellValue($P_T.'7', 'T');
		$worksheet->setCellValue($P_I.'7', 'I');
		$worksheet->setCellValue($P_M.'7', 'M');
		$worksheet->setCellValue($P_S.'7', 'S');
		$worksheet->setCellValue($P_PSP.'7', 'PSP');
		$worksheet->setCellValue($P_IP.'7', 'IP');
		$worksheet->setCellValue($P_CT.'7', 'CT');
		$worksheet->setCellValue($P_Tot.'7', 'Total');


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
					foreach (${'rekap_'.$monthName} as ${'rek'.$monthName}) {
						if ($rekap_data['noind'] == ${'rek'.$monthName}['noind'] && $rekap_data['nama'] == ${'rek'.$monthName}['nama'] && $rekap_data['nik'] == ${'rek'.$monthName}['nik'] && $rekap_data['tgllahir'] == ${'rek'.$monthName}['tgllahir'])
						{
							$Terlambat = ${'rek'.$monthName}['frekt'.strtolower($monthName)]+${'rek'.$monthName}['frekts'.strtolower($monthName)];
							$IjinPribadi = ${'rek'.$monthName}['freki'.strtolower($monthName)]+${'rek'.$monthName}['frekis'.strtolower($monthName)];
							$Mangkir = ${'rek'.$monthName}['frekm'.strtolower($monthName)]+${'rek'.$monthName}['frekms'.strtolower($monthName)];
							$SuratKeterangan = ${'rek'.$monthName}['freksk'.strtolower($monthName)]+${'rek'.$monthName}['freksks'.strtolower($monthName)];
							$SakitPerusahaan = ${'rek'.$monthName}['frekpsp'.strtolower($monthName)]+${'rek'.$monthName}['frekpsps'.strtolower($monthName)];
							$IjinPerusahaan = ${'rek'.$monthName}['frekip'.strtolower($monthName)]+${'rek'.$monthName}['frekips'.strtolower($monthName)];
							$CutiTahunan = ${'rek'.$monthName}['frekct'.strtolower($monthName)]+${'rek'.$monthName}['frekcts'.strtolower($monthName)];
							$SuratPeringatan = ${'rek'.$monthName}['freksp'.strtolower($monthName)]+${'rek'.$monthName}['freksps'.strtolower($monthName)];
							if ($Terlambat == '0') {
								$Terlambat = '-';
							}
							if ($IjinPribadi == '0') {
								$IjinPribadi = '-';
							}
							if ($Mangkir == '0') {
								$Mangkir = '-';
							}
							if ($SuratKeterangan == '0') {
								$SuratKeterangan = '-';
							}
							if ($SakitPerusahaan == '0') {
								$SakitPerusahaan = '-';
							}
							if ($IjinPerusahaan == '0') {
								$IjinPerusahaan = '-';
							}
							if ($CutiTahunan == '0') {
								$CutiTahunan = '-';
							}
							if ($SuratPeringatan == '0') {
								$SuratPeringatan = '-';
							}
						}
					}
					$T = PHPExcel_Cell::stringFromColumnIndex($col);
					$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
					$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
					$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
					$PSP = PHPExcel_Cell::stringFromColumnIndex($col+4);
					$IP = PHPExcel_Cell::stringFromColumnIndex($col+5);
					$CT = PHPExcel_Cell::stringFromColumnIndex($col+6);
					$SP = PHPExcel_Cell::stringFromColumnIndex($col+7);

					$worksheet->setCellValue($T.$highestRow, $Terlambat, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($I.$highestRow, $IjinPribadi, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($M.$highestRow, $Mangkir, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($S.$highestRow, $SuratKeterangan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($PSP.$highestRow, $SakitPerusahaan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($IP.$highestRow, $IjinPerusahaan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($CT.$highestRow, $CutiTahunan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($SP.$highestRow, $SuratPeringatan, PHPExcel_Cell_DataType::TYPE_STRING);

					$col=$col+8;
				}
			}

			$T = PHPExcel_Cell::stringFromColumnIndex($col);
			$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
			$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
			$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
			$PSP = PHPExcel_Cell::stringFromColumnIndex($col+4);
			$IP = PHPExcel_Cell::stringFromColumnIndex($col+5);
			$CT = PHPExcel_Cell::stringFromColumnIndex($col+6);
			$SP = PHPExcel_Cell::stringFromColumnIndex($col+7);
			$THK = PHPExcel_Cell::stringFromColumnIndex($col+8);
			$P_T = PHPExcel_Cell::stringFromColumnIndex($col+9);
			$P_I = PHPExcel_Cell::stringFromColumnIndex($col+10);
			$P_M = PHPExcel_Cell::stringFromColumnIndex($col+11);
			$P_S = PHPExcel_Cell::stringFromColumnIndex($col+12);
			$P_PSP = PHPExcel_Cell::stringFromColumnIndex($col+13);
			$P_IP = PHPExcel_Cell::stringFromColumnIndex($col+14);
			$P_CT = PHPExcel_Cell::stringFromColumnIndex($col+15);
			$P_Tot 	=	PHPExcel_Cell::stringFromColumnIndex($col+16);

			$worksheet->setCellValue($T.$highestRow, $rekap_data['frekt']+$rekap_data['frekts'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($I.$highestRow, $rekap_data['freki']+$rekap_data['frekis'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($M.$highestRow, $rekap_data['frekm']+$rekap_data['frekms'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($S.$highestRow, $rekap_data['freksk']+$rekap_data['freksks'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($PSP.$highestRow, $rekap_data['frekpsp']+$rekap_data['frekpsps'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($IP.$highestRow, $rekap_data['frekip']+$rekap_data['frekips'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($CT.$highestRow, $rekap_data['frekct']+$rekap_data['frekcts'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($SP.$highestRow, $rekap_data['total_jmlsp']+$rekap_data['total_jmlsps'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($THK.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : ($rekap_data['totalhk']+$rekap_data['totalhks'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($P_T.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekt']+$rekap_data['frekts']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($P_I.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['freki']+$rekap_data['frekis']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($P_M.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekm']+$rekap_data['frekms']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($P_S.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['freksk']+$rekap_data['freksks']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($P_PSP.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekpsp']+$rekap_data['frekpsps']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($P_IP.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekip']+$rekap_data['frekips']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($P_CT.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekct']+$rekap_data['frekcts']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue
						(
							$P_Tot.$highestRow,
							round(
									(
										(
											(
												($rekap_data['totalhk']+$rekap_data['totalhks'])
												-
												(
													($rekap_data['freki']+$rekap_data['frekis'])
													+
													($rekap_data['frekm']+$rekap_data['frekms'])
													+
													($rekap_data['freksk']+$rekap_data['freksks'])
													+
													($rekap_data['frekpsp']+$rekap_data['frekpsps'])
													+
													($rekap_data['frekip']+$rekap_data['frekips'])
													+
													($rekap_data['frekct']+$rekap_data['frekcts'])
													+
													($rekap_data['frekmnon']+$rekap_data['frekmsnon'])
												)
											)
											/
											(($rekap_data['totalhk']+$rekap_data['totalhks']) - ($rekap_data['frekct']+$rekap_data['frekcts']) - ($rekap_data['frekmnon']+$rekap_data['frekmsnon']))
										)
										*100
									),
								2).'%',
							PHPExcel_Cell_DataType::TYPE_STRING
						);

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

	public function ExportRekapDetailPDF()
	{
		$detail = $this->input->post("txtDetail");
		$periode1 = $this->input->post("txtPeriode1_export");
		$periode2 = $this->input->post("txtPeriode2_export");
		$NoInduk = $this->input->post("txtNoInduk_export");
		$status = $this->input->post("txtStatus");

		if ($detail == 1) {
			$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
			$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
		}
		else{
			$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
			$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
		}
		// $rekap_masakerja = $this->M_rekap_per_pekerja->data_rekap_masakerja($period2,$NoInduk,$status);
		// $rekap_all = $this->M_rekap_per_pekerja->ExportRekap($period1,$period2,$NoInduk,$status);

		$data['rekap_all'] = $this->M_rekaptims->rekapTIMS($periode1, $periode2 , FALSE, $NoInduk);
		// echo '<pre>';
		// print_r($data['rekap_all']);
		// echo '</pre>';
		if ($detail == 1) {
			$begin = new DateTime(date('Y-m-01 00:00:00', strtotime($periode1)));
			$end = new DateTime(date('Y-m-t 23:59:59', strtotime($periode2)));

			$interval = new DateInterval('P1M');

			$start_year_month = date('Y-m', strtotime($periode1));
			$start_date = date('d', strtotime($periode1));
			$end_year_month = date('Y-m', strtotime($periode2));
			$end_date = date('d', strtotime($periode2));

			$p = new DatePeriod($begin, $interval ,$end);

			$angka = 0;
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

				// ${'rekap_'.$monthName} = $this->M_rekap_per_pekerja->ExportDetail($firstdate,$lastdate,$NoInduk,$monthName, $status);
				$data['detail']['rekap_'.$monthName] = $this->M_rekaptims->rekapTIMS($firstdate, $lastdate, $monthName, $NoInduk);
				$data['periode'][$angka]['0'] = $d->format('F Y');
				$data['periode'][$angka]['1'] = $d->format('M/Y');
				$data['periode'][$angka]['2'] = $d->format('M_y');
				$angka++;
				// echo '<pre>';
				// print_r(${'rekap_'.$monthName});
				// echo '</pre>';
			}
		}else{
			$begin = new DateTime(date('Y-m-01 00:00:00', strtotime($periode1)));
			$end = new DateTime(date('Y-m-t 23:59:59', strtotime($periode2)));

			$interval = new DateInterval('P1M');

			$p = new DatePeriod($begin, $interval ,$end);

			$angka = 0;
			foreach ($p as $d) {
				$data['periode'][$angka]['0'] = $d->format('F Y');
				$data['periode'][$angka]['1'] = $d->format('M/Y');
				$data['periode'][$angka]['2'] = $d->format('M_y');
				$angka++;
			}
		}
		//insert to sys.log_activity
		$aksi = 'REKAP TIMS';
		$detail = "Export PDF per pekerja noind=$NoInduk tanggal=".$periode1." - ".$periode2;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4-L',0,'',10,10,10,10,10,10);
		$filename = 'rekapTims.pdf';


		$html = $this->load->view('er/RekapTIMS/V_cetak_tims_per_pekerja', $data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function searchMonth()
	{
		$month = $this->input->post("txtPeriode_bulanan");
		$NoInduk = $this->input->post("txtNoInduk_bulanan");

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS Per Pekerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$periode1 = date('Y-m-01 00:00:00', strtotime($month));
		$periode2 = date('Y-m-t 23:59:59', strtotime($month));
		$begin = new DateTime($periode1);
		$end = new DateTime($periode2);

		$interval = new DateInterval('P1D');

		$p = new DatePeriod($begin, $interval ,$end);
		foreach ($p as $d) {
			$perDay = $d->format('Y-m-d');
			$date = $d->format('d_M_y');
			$firstdate = date('Y-m-d 00:00:00', strtotime($perDay));
			$lastdate = date('Y-m-d 23:59:59', strtotime($perDay));
			$data['rekap_'.$date] = $this->M_rekap_per_pekerja->dataRekapMonthDetail($firstdate,$lastdate,$NoInduk,$date);
		}
		$data['rekapPerMonth'] = $this->M_rekap_per_pekerja->dataRekapMonth($periode1,$periode2,$NoInduk);
		$data['rekap_masakerja'] = $this->M_rekap_per_pekerja->data_rekap_masakerja($periode2,$NoInduk);

		$data['periode1'] = $periode1;
		$data['periode2'] = $periode2;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_month_per_pekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	/*public function ExportRekapMonthly(){
		$periode = $this->input->post("txtPeriode_bulanan_export");
		$NoInduk = $this->input->post("txtNoInduk_bulanan_export");

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

		$periode1 = date('Y-m-01 00:00:00', strtotime($periode));
		$periode2 = date('Y-m-t 23:59:59', strtotime($periode));
		$rekap_masakerja = $this->M_rekap_per_pekerja->data_rekap_masakerja($periode2,$NoInduk);

		$begin = new DateTime($periode1);
		$end = new DateTime($periode2);

		$interval = new DateInterval('P1D');

		$p = new DatePeriod($begin, $interval ,$end);
		foreach ($p as $d) {
			$perMonth = $d->format('Y-m-d');
			$date = $d->format('d_M_y');
			$firstdate = date('Y-m-d 00:00:00', strtotime($perMonth));
			$lastdate = date('Y-m-d 23:59:59', strtotime($perMonth));
			${'rekap_'.$date} = $this->M_rekap_per_pekerja->dataRekapMonthDetail($firstdate,$lastdate,$NoInduk,$date);
		}

		$firstdate = date('Y-m-01 00:00:00', strtotime($perMonth));
		$lastdate = date('Y-m-t 23:59:59', strtotime($perMonth));

		$rekap_all = $this->M_rekap_per_pekerja->dataRekapMonth($firstdate,$lastdate,$NoInduk);

		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(17);
		$worksheet->getColumnDimension('C')->setWidth(45);
		$worksheet->getColumnDimension('D')->setWidth(24);

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

		$worksheet->setCellValue('C1', date('F Y', strtotime($periode1)), PHPExcel_Cell_DataType::TYPE_STRING);

		$worksheet->mergeCells('A6:A7');
		$worksheet->mergeCells('B6:B7');
		$worksheet->mergeCells('C6:C7');
		$worksheet->mergeCells('D6:D7');

		$worksheet->setCellValue('A6', 'No');
		$worksheet->setCellValue('B6', 'NIK');
		$worksheet->setCellValue('C6', 'NAMA');
		$worksheet->setCellValue('D6', 'MASA KERJA');

		$col = '4';

			foreach ($p as $d) {
				$T = PHPExcel_Cell::stringFromColumnIndex($col);
				$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
				$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
				$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
				$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
				$CT = PHPExcel_Cell::stringFromColumnIndex($col+5);
				$SP = PHPExcel_Cell::stringFromColumnIndex($col+6);
				$worksheet->getColumnDimension($T)->setWidth(3);
				$worksheet->getColumnDimension($I)->setWidth(3);
				$worksheet->getColumnDimension($M)->setWidth(3);
				$worksheet->getColumnDimension($S)->setWidth(3);
				$worksheet->getColumnDimension($IP)->setWidth(3);
				$worksheet->getColumnDimension($CT)->setWidth(3);
				$worksheet->getColumnDimension($SP)->setWidth(3);
				$head_merge = $col+6;
				$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
				$worksheet->mergeCells($T.'6:'.$headCol.'6');
				$dateName = $d->format('d-m-Y');
				$worksheet->setCellValue($T.'6', $dateName);
				$worksheet->setCellValue($T.'7', 'T');
				$worksheet->setCellValue($I.'7', 'I');
				$worksheet->setCellValue($M.'7', 'M');
				$worksheet->setCellValue($S.'7', 'S');
				$worksheet->setCellValue($IP.'7', 'IP');
				$worksheet->setCellValue($CT.'7', 'CT');
				$worksheet->setCellValue($SP.'7', 'SP');
				$col=$col+7;
			}


		$T = PHPExcel_Cell::stringFromColumnIndex($col);
		$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
		$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
		$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
		$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
		$CT = PHPExcel_Cell::stringFromColumnIndex($col+5);
		$SP = PHPExcel_Cell::stringFromColumnIndex($col+6);
		$worksheet->getColumnDimension($T)->setWidth(3);
		$worksheet->getColumnDimension($I)->setWidth(3);
		$worksheet->getColumnDimension($M)->setWidth(3);
		$worksheet->getColumnDimension($S)->setWidth(3);
		$worksheet->getColumnDimension($IP)->setWidth(3);
		$worksheet->getColumnDimension($CT)->setWidth(3);
		$worksheet->getColumnDimension($SP)->setWidth(3);
		$head_merge = $col+6;
		$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
		$worksheet->mergeCells($T.'6:'.$headCol.'6');
		$worksheet->setCellValue($T.'6', 'REKAP');
		$worksheet->setCellValue($T.'7', 'T');
		$worksheet->setCellValue($I.'7', 'I');
		$worksheet->setCellValue($M.'7', 'M');
		$worksheet->setCellValue($S.'7', 'S');
		$worksheet->setCellValue($IP.'7', 'IP');
		$worksheet->setCellValue($CT.'7', 'CT');
		$worksheet->setCellValue($SP.'7', 'SP');

		$no = 1;
		$highestRow = $worksheet->getHighestRow()+1;
		foreach ($rekap_all as $rekap_data) {

			$masukkerja_s = '';
			${'masa_kerja'.$rekap_data['nama']} = array();
			$index_masakerja = 0;
			foreach ($rekap_masakerja as $row) {
				if ($row['nama'] == $rekap_data['nama'] AND $row['nik'] == $row['nik']) {

					if ($row['masukkerja'] != $masukkerja_s) {
						$masukkerja = new DateTime($row['masukkerja']);
						$tglkeluar = new DateTime($row['tglkeluar']);
						$masa_kerja = $masukkerja->diff($tglkeluar);
						${'masa_kerja'.$rekap_data['nama']}[$index_masakerja] = $masa_kerja;
						$index_masakerja++;
					}

					$masukkerja_s = $row['masukkerja'];
				}
			}

			$e = new DateTime();
			$f = clone $e;
			if (!empty(${'masa_kerja'.$rekap_data['nama']}[0])) {
				$e->add(${'masa_kerja'.$rekap_data['nama']}[0]);
			}
			if (!empty(${'masa_kerja'.$rekap_data['nama']}[1])) {
				$e->add(${'masa_kerja'.$rekap_data['nama']}[1]);
			}
			$total_masa_kerja = $f->diff($e)->format("%Y Tahun %m Bulan %d Hari");

			$worksheet->setCellValue('A'.$highestRow, $no++);
			$worksheet->setCellValue('B'.$highestRow, $rekap_data['noind'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$highestRow, str_replace('  ', '', $rekap_data['nama']));
			$worksheet->setCellValue('D'.$highestRow, $total_masa_kerja);

			$col = 4;

				foreach ($p as $d) {
					$dateName = $d->format('d_M_y');
					foreach (${'rekap_'.$dateName} as ${'rek'.$dateName}) {
						if ($rekap_data['noind'] == ${'rek'.$dateName}['noind'] && $rekap_data['nama'] == ${'rek'.$dateName}['nama'] && $rekap_data['nik'] == ${'rek'.$dateName}['nik'] && $rekap_data['tgllahir'] == ${'rek'.$dateName}['tgllahir'])
						{
							$Terlambat = ${'rek'.$dateName}['frekt'.strtolower($dateName)]+${'rek'.$dateName}['frekts'.strtolower($dateName)];
							$IjinPribadi = ${'rek'.$dateName}['freki'.strtolower($dateName)]+${'rek'.$dateName}['frekis'.strtolower($dateName)];
							$Mangkir = ${'rek'.$dateName}['frekm'.strtolower($dateName)]+${'rek'.$dateName}['frekms'.strtolower($dateName)];
							$SuratKeterangan = ${'rek'.$dateName}['freksk'.strtolower($dateName)]+${'rek'.$dateName}['freksks'.strtolower($dateName)];
							$IjinPerusahaan = ${'rek'.$dateName}['frekip'.strtolower($dateName)]+${'rek'.$dateName}['frekips'.strtolower($dateName)];
							$CutiTahunan = ${'rek'.$dateName}['frekct'.strtolower($dateName)]+${'rek'.$dateName}['frekcts'.strtolower($dateName)];
							$SuratPeringatan = ${'rek'.$dateName}['freksp'.strtolower($dateName)]+${'rek'.$dateName}['freksps'.strtolower($dateName)];
							if ($Terlambat == '0') {
								$Terlambat = '-';
							}
							if ($IjinPribadi == '0') {
								$IjinPribadi = '-';
							}
							if ($Mangkir == '0') {
								$Mangkir = '-';
							}
							if ($SuratKeterangan == '0') {
								$SuratKeterangan = '-';
							}
							if ($IjinPerusahaan == '0') {
								$IjinPerusahaan = '-';
							}
							if ($CutiTahunan == '0') {
								$CutiTahunan = '-';
							}
							if ($SuratPeringatan == '0') {
								$SuratPeringatan = '-';
							}
						}
					}
					$T = PHPExcel_Cell::stringFromColumnIndex($col);
					$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
					$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
					$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
					$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
					$CT = PHPExcel_Cell::stringFromColumnIndex($col+5);
					$SP = PHPExcel_Cell::stringFromColumnIndex($col+6);

					$worksheet->setCellValue($T.$highestRow, $Terlambat, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($I.$highestRow, $IjinPribadi, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($M.$highestRow, $Mangkir, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($S.$highestRow, $SuratKeterangan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($IP.$highestRow, $IjinPerusahaan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($CT.$highestRow, $CutiTahunan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($SP.$highestRow, $SuratPeringatan, PHPExcel_Cell_DataType::TYPE_STRING);

					$col=$col+7;
				}


			$T = PHPExcel_Cell::stringFromColumnIndex($col);
			$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
			$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
			$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
			$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
			$CT = PHPExcel_Cell::stringFromColumnIndex($col+5);
			$SP = PHPExcel_Cell::stringFromColumnIndex($col+6);

			$worksheet->setCellValue($T.$highestRow, $rekap_data['frekt']+$rekap_data['frekts'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($I.$highestRow, $rekap_data['freki']+$rekap_data['frekis'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($M.$highestRow, $rekap_data['frekm']+$rekap_data['frekms'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($S.$highestRow, $rekap_data['freksk']+$rekap_data['freksks'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($IP.$highestRow, $rekap_data['frekip']+$rekap_data['frekips'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($CT.$highestRow, $rekap_data['frekct']+$rekap_data['frekcts'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($SP.$highestRow, $rekap_data['freksp']+$rekap_data['freksps'], PHPExcel_Cell_DataType::TYPE_STRING);

			$highestRow++;
		}

		$highestColumn = $worksheet->getHighestColumn();
		$highestRow = $worksheet->getHighestRow();

			$worksheet->getStyle('A6:'.$highestColumn.'7')->applyFromArray($styleArray);
			$worksheet	->getStyle('A6:'.$highestColumn.'7')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('0099ff');
			$worksheet->getStyle('A6:'.$highestColumn.'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A6:'.$highestColumn.'7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		$worksheet->freezePaneByColumnAndRow(4, 8);

		$worksheet->getStyle('D8:'.$highestColumn.$highestRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			$fileName = 'Rekap_Monthly';


		$worksheet->setTitle('Rekap TIMS');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$fileName.'-'.time().'.xlsx"');
		$objWriter->save("php://output");
	}*/

	public function searchEmployee($periode1,$periode2,$nik)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS Per Pekerja';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periode1'] = date('Y-m-d', strtotime($periode1));
		$data['periode2'] = date('Y-m-d', strtotime($periode2));

		$data['info'] 				= $this->M_rekap_per_pekerja->rekapPersonInfo($nik);
		$data['Terlambat'] 			= $this->M_rekap_per_pekerja->rekapPersonTIM($data['periode1'],$data['periode2'],$nik,$keterangan = 'TT');
		$data['IjinPribadi'] 		= $this->M_rekap_per_pekerja->rekapPersonTIM($data['periode1'],$data['periode2'],$nik,$keterangan = 'TIK');
		$data['Mangkir'] 			= $this->M_rekap_per_pekerja->rekapPersonTIM($data['periode1'],$data['periode2'],$nik,$keterangan = 'TM');
		$data['IjinPerusahaan'] 	= $this->M_rekap_per_pekerja->rekapPersonSIP($data['periode1'],$data['periode2'],$nik,$keterangan = 'PIP');
		$data['CutiTahunan'] 		= $this->M_rekap_per_pekerja->rekapPersonSIP($data['periode1'],$data['periode2'],$nik,$keterangan = 'CT');
		$data['SuratPeringatan'] 	= $this->M_rekap_per_pekerja->rekapPersonSP($data['periode1'],$data['periode2'],$nik);
		$data['Sakit'] 				= $this->M_rekap_per_pekerja->rekapPersonSakit($data['periode1'], $data['periode2'], $nik);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_personal',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportEmployee($periode1,$periode2,$nik){
		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$info 				= 	$this->M_rekap_per_pekerja->rekapPersonInfo($nik);
		$Terlambat 			= 	$this->M_rekap_per_pekerja->rekapPersonTIM($periode1,$periode2,$nik,$keterangan = 'TT');
		$IjinPribadi 		= 	$this->M_rekap_per_pekerja->rekapPersonTIM($periode1,$periode2,$nik,$keterangan = 'TIK');
		$Mangkir 			= 	$this->M_rekap_per_pekerja->rekapPersonTIM($periode1,$periode2,$nik,$keterangan = 'TM');
		$IjinPerusahaan 	= 	$this->M_rekap_per_pekerja->rekapPersonSIP($periode1,$periode2,$nik,$keterangan = 'PIP');
		$CutiTahunan 		= 	$this->M_rekap_per_pekerja->rekapPersonSIP($periode1,$periode2,$nik,$keterangan = 'CT');
		$SuratPeringatan 	= 	$this->M_rekap_per_pekerja->rekapPersonSP($periode1,$periode2,$nik);
		$Sakit 				=	$this->M_rekap_per_pekerja->rekapPersonSakit($periode1,$periode2, $nik);
		$objPHPExcel->setActiveSheetIndex(0);

		$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FFFFFF'),
			)
		);

		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(15);
		$worksheet->getColumnDimension('C')->setWidth(10);
		$worksheet->getColumnDimension('D')->setWidth(10);
		$worksheet->getColumnDimension('E')->setWidth(5);
		$worksheet->getColumnDimension('F')->setWidth(5);
		$worksheet->getColumnDimension('G')->setWidth(15);
		$worksheet->getColumnDimension('H')->setWidth(10);
		$worksheet->getColumnDimension('I')->setWidth(10);

		$worksheet->mergeCells('A1:G1');
		$worksheet->mergeCells('A2:B2');
		$worksheet->mergeCells('A3:B3');
		$worksheet->mergeCells('A4:B4');
		$worksheet->mergeCells('A5:B5');
		$worksheet->mergeCells('A6:B6');

		$worksheet->getStyle('A1')->applyFromArray($styleArray);
		$worksheet	->getStyle('A1')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');
		$worksheet->getStyle('A9:K9')->applyFromArray($styleArray);
		$worksheet	->getStyle('A9')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');
		$worksheet	->getStyle('A10:D10')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('c0c0c0');
		$worksheet	->getStyle('F9')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');
		$worksheet	->getStyle('F10:I10')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('c0c0c0');
		$worksheet->getStyle('A9:F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


		$worksheet->setCellValue('A1', 'INFORMASI PEKERJA');
		$worksheet->setCellValue('A2', 'NIK');
		$worksheet->setCellValue('A3', 'NAMA');
		$worksheet->setCellValue('A4', 'SEKSI');
		$worksheet->setCellValue('A5', 'UNIT');
		$worksheet->setCellValue('A6', 'BIDANG');

		$worksheet->mergeCells('C2:G2');
		$worksheet->mergeCells('C3:G3');
		$worksheet->mergeCells('C4:G4');
		$worksheet->mergeCells('C5:G5');
		$worksheet->mergeCells('C6:G6');

		$worksheet->mergeCells('A9:D9');
		$worksheet->mergeCells('F9:I9');

		foreach ($info as $inf) {}
		$worksheet->setCellValue('C2', $inf['nik'], PHPExcel_Cell_DataType::TYPE_STRING);
		$worksheet->setCellValue('C3', $inf['nama']);
		$worksheet->setCellValue('C4', $inf['seksi']);
		$worksheet->setCellValue('C5', $inf['unit']);
		$worksheet->setCellValue('C6', $inf['bidang']);

		$worksheet->setCellValue('A9', 'TERLAMBAT');
		$worksheet->setCellValue('A10', 'No');
		$worksheet->setCellValue('B10', 'Tanggal');
		$worksheet->setCellValue('C10', 'Masuk');
		$worksheet->setCellValue('D10', 'Keluar');

		$row = 11;
		$no = 1;
		foreach ($Terlambat as $tlt) {
			$worksheet->setCellValue('A'.$row, $no++, PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('B'.$row, date('Y-m-d', strtotime($tlt['tanggal'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$row, $tlt['masuk'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('D'.$row, $tlt['keluar'], PHPExcel_Cell_DataType::TYPE_STRING);
			$row++;
		}

		$worksheet->setCellValue('F9', 'MANGKIR');
		$worksheet->setCellValue('F10', 'No');
		$worksheet->setCellValue('G10', 'Tanggal');
		$worksheet->setCellValue('H10', 'Masuk');
		$worksheet->setCellValue('I10', 'Keluar');

		$row = 11;
		$no = 1;
		foreach ($Mangkir as $mkr) {
			$worksheet->setCellValue('F'.$row, $no++, PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('G'.$row, date('Y-m-d', strtotime($mkr['tanggal'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('H'.$row, $mkr['masuk'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('I'.$row, $mkr['keluar'], PHPExcel_Cell_DataType::TYPE_STRING);
			$row++;
		}

		$highestRow = $worksheet->getHighestRow();

		$worksheet->getStyle('A'.($highestRow+3).':F'.($highestRow+3))->applyFromArray($styleArray);
		$worksheet	->getStyle('A'.($highestRow+3))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');
		$worksheet	->getStyle('F'.($highestRow+3))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');
		$worksheet	->getStyle('A'.($highestRow+4).':D'.($highestRow+4))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('c0c0c0');
		$worksheet	->getStyle('F'.($highestRow+4).':I'.($highestRow+4))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('c0c0c0');

		$worksheet->getStyle('A'.($highestRow+3).':F'.($highestRow+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$worksheet->mergeCells('A'.($highestRow+3).':D'.($highestRow+3));
		$worksheet->mergeCells('F'.($highestRow+3).':I'.($highestRow+3));

		$worksheet->setCellValue('A'.($highestRow+3), 'IJIN PERUSAHAAN');
		$worksheet->setCellValue('A'.($highestRow+4), 'No');
		$worksheet->setCellValue('B'.($highestRow+4), 'Tanggal');
		$worksheet->setCellValue('C'.($highestRow+4), 'Masuk');
		$worksheet->setCellValue('D'.($highestRow+4), 'Keluar');

		$row = $highestRow+5;
		$no = 1;
		foreach ($IjinPerusahaan as $iper) {
			$worksheet->setCellValue('A'.$row, $no++, PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('B'.$row, date('Y-m-d', strtotime($iper['tanggal'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$row, $iper['masuk'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('D'.$row, $iper['keluar'], PHPExcel_Cell_DataType::TYPE_STRING);
			$row++;
		}

		$worksheet->setCellValue('F'.($highestRow+3), 'IJIN PRIBADI');
		$worksheet->setCellValue('F'.($highestRow+4), 'No');
		$worksheet->setCellValue('G'.($highestRow+4), 'Tanggal');
		$worksheet->setCellValue('H'.($highestRow+4), 'Masuk');
		$worksheet->setCellValue('I'.($highestRow+4), 'Keluar');

		$row = $highestRow+5;
		$no = 1;
		foreach ($IjinPribadi as $ipri) {
			$worksheet->setCellValue('F'.$row, $no++, PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('G'.$row, date('Y-m-d', strtotime($ipri['tanggal'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('H'.$row, $ipri['masuk'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('I'.$row, $ipri['keluar'], PHPExcel_Cell_DataType::TYPE_STRING);
			$row++;
		}

		$highestRow = $worksheet->getHighestRow();

		$worksheet->getStyle('A'.($highestRow+3).':F'.($highestRow+3))->applyFromArray($styleArray);
		$worksheet	->getStyle('A'.($highestRow+3))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');
		$worksheet	->getStyle('F'.($highestRow+3))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');
		$worksheet	->getStyle('A'.($highestRow+4).':D'.($highestRow+4))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('c0c0c0');
		$worksheet	->getStyle('F'.($highestRow+4).':I'.($highestRow+4))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('c0c0c0');

		$worksheet->getStyle('A'.($highestRow+3).':F'.($highestRow+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$worksheet->mergeCells('A'.($highestRow+3).':D'.($highestRow+3));
		$worksheet->mergeCells('F'.($highestRow+3).':I'.($highestRow+3));

		$worksheet->setCellValue('A'.($highestRow+3), 'Sakit');
		$worksheet->setCellValue('A'.($highestRow+4), 'No');
		$worksheet->setCellValue('B'.($highestRow+4), 'Nomor Induk');
		$worksheet->setCellValue('C'.($highestRow+4), 'Tanggal');
		$worksheet->setCellValue('D'.($highestRow+4), 'Keterangan');

		$row = $highestRow+5;
		$no = 1;
		foreach ($Sakit as $sakit) {
			$worksheet->setCellValue('A'.$row, $no++, PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('B'.$row, $sakit['noind'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$row, date('Y-m-d', strtotime($sakit['tanggal'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('D'.$row, $sakit['keterangan'], PHPExcel_Cell_DataType::TYPE_STRING);
			$row++;
		}

		$worksheet->setCellValue('F'.($highestRow+3), 'CUTI TAHUNAN');
		$worksheet->setCellValue('F'.($highestRow+4), 'No');
		$worksheet->setCellValue('G'.($highestRow+4), 'Tanggal');
		$worksheet->setCellValue('H'.($highestRow+4), 'Masuk');
		$worksheet->setCellValue('I'.($highestRow+4), 'Keluar');

		$row = $highestRow+5;
		$no = 1;
		foreach ($CutiTahunan as $cutah) {
			$worksheet->setCellValue('F'.$row, $no++, PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('G'.$row, date('Y-m-d', strtotime($cutah['tanggal'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('H'.$row, $cutah['masuk'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('I'.$row, $cutah['keluar'], PHPExcel_Cell_DataType::TYPE_STRING);
			$row++;
		}

		$highestRow = $worksheet->getHighestRow();
		$worksheet->mergeCells('A'.($highestRow+3).':I'.($highestRow+3));
		$worksheet->mergeCells('E'.($highestRow+4).':F'.($highestRow+4));

		$worksheet->getStyle('A'.($highestRow+3).':A'.($highestRow+3))->applyFromArray($styleArray);
		$worksheet	->getStyle('A'.($highestRow+3))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('0099ff');
		$worksheet	->getStyle('A'.($highestRow+4).':I'.($highestRow+4))
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('c0c0c0');
		$worksheet->getStyle('A'.($highestRow+3).':I'.($highestRow+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$worksheet->setCellValue('A'.($highestRow+3), 'SURAT PERINGATAN');
		$worksheet->setCellValue('A'.($highestRow+4), 'No');
		$worksheet->setCellValue('B'.($highestRow+4), 'Tanggal Cetak');
		$worksheet->setCellValue('C'.($highestRow+4), 'Terlambat');
		$worksheet->setCellValue('D'.($highestRow+4), 'Ijin');
		$worksheet->setCellValue('E'.($highestRow+4), 'Mangkir');
		$worksheet->setCellValue('G'.($highestRow+4), 'Bobot');
		$worksheet->setCellValue('H'.($highestRow+4), 'SP ke');
		$worksheet->setCellValue('I'.($highestRow+4), 'Absen/Non');

		$row = $highestRow+5;
		$no = 1;
		foreach ($SuratPeringatan as $SP) {
			$worksheet->mergeCells('E'.$row.':F'.$row);
			$worksheet->setCellValue('A'.$row, $no++, PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('B'.$row, date('Y-m-d', strtotime($SP['tgl_cetak'])), PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$row, $SP['nt'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('D'.$row, $SP['nik'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('E'.$row, $SP['nm'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('G'.$row, $SP['bobot'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('H'.$row, $SP['sp_ke'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('I'.$row, $SP['status'], PHPExcel_Cell_DataType::TYPE_STRING);
			$row++;
		}

		$worksheet->setTitle('Rekap TIMS');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.str_replace(' ', '', $inf['nama']).'-'.time().'.xlsx"');
		$objWriter->save("php://output");
	}

}
