<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Rekap extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('er/RekapTIMS/M_rekapmssql');
		  
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
		$this->load->view('er/RekapTIMS/V_index',$data);
		$this->load->view('V_Footer',$data);
		
	}

	//------------------------show the filtering menu-----------------------------
	public function rekapMenu()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS Per Area Kerja';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['status'] = $this->M_rekapmssql->statusKerja();
		$data['dept'] = $this->M_rekapmssql->dept();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_filter',$data);
		$this->load->view('V_Footer',$data);		
	}

	//------------------------automatically post value to select section-----------------------------
	public function select_section()
	{
		$id = $this->input->post('data_name');
		$modul = $this->input->post('modul');

		echo '
			<option value=""></option>
			<option value="All">ALL</option>
		';
		if ($modul == 'bidang') {
			$data = $this->M_rekapmssql->bidang($id);
			foreach ($data as $data) {
				echo '<option value="'.$data['bidang'].'">'.$data['bidang'].'</option>';
			}
		}
		elseif ($modul == 'unit') {
			$data = $this->M_rekapmssql->unit($id);
			foreach ($data as $data) {
				echo '<option value="'.$data['unit'].'">'.$data['unit'].'</option>';
			}
		}
		elseif ($modul == 'seksi') {
			$data = $this->M_rekapmssql->seksi($id);
			foreach ($data as $data) {
				echo '<option value="'.$data['seksi'].'">'.$data['seksi'].'</option>';
			}
		}
	}

	//------------------------show the data REKAP TIMS-----------------------------
	public function showData()
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
		$status 	= $this->input->post('statushubker');
		$departemen	= $this->input->post('departemen');
		$bidang 	= $this->input->post('bidang');
		$unit 		= $this->input->post('unit');
		$section 	= $this->input->post('section');
		$data['section'] = $section;
		$detail 	= $this->input->post('detail');

		
		//$this->load->view('V_Header',$data);
		//$this->load->view('V_Sidemenu',$data);
		$data['periode1']	= $this->input->post('rekapBegin');
		$data['periode2']	= $this->input->post('rekapEnd');
		if ($detail==NULL) {
			$data['rekap'] = $this->M_rekapmssql->dataRekap($periode1,$periode2,$status,$departemen,$bidang,$unit,$section);
			$this->load->view('er/RekapTIMS/V_rekap_table',$data);
		}
		else {
			$begin = new DateTime($periode1);
			$end = new DateTime($periode2);
			$interval = new DateInterval('P1M');

			$p = new DatePeriod($begin, $interval ,$end);
			foreach ($p as $d) {
				$perMonth = $d->format('Y-m');
				$monthName = $d->format('M_y');
				$firstdate = date('Y-m-01 00:00:00', strtotime($perMonth));
				$lastdate = date('Y-m-t 23:59:59', strtotime($perMonth));
				$data['rekap_'.$monthName] = $this->M_rekapmssql->dataRekapDetail($firstdate,$lastdate,$status,$departemen,$bidang,$unit,$section,$monthName);
			}
			$period1 = date('Y-m-01 00:00:00', strtotime($periode1));
			$period2 = date('Y-m-t 23:59:59', strtotime($periode2));
			$data['rekap'] = $this->M_rekapmssql->dataRekap($period1,$period2,$status,$departemen,$bidang,$unit,$section);
			$this->load->view('er/RekapTIMS/V_detail_rekap_table',$data);
		}
		//$this->load->view('V_Footer',$data);
	}

	public function ExportRekapDetail($periode1,$periode2,$status,$section,$detail){
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

		$section = str_replace('-', ' ', $section);
		if ($detail == 1) {
			$period1 = date('Y-m-01 00:00:00', strtotime($periode1));
			$period2 = date('Y-m-t 23:59:59', strtotime($periode2));
		}
		else{
			$period1 = date('Y-m-d 00:00:00', strtotime($periode1));
			$period2 = date('Y-m-d 23:59:59', strtotime($periode2));
		}
		$periode_masa_kerja = $period2;
		$rekap_all = $this->M_rekapmssql->ExportRekap($period1,$period2,$status,$section);

		if ($detail == 1) {

			$begin = new DateTime($periode1);
			$end = new DateTime($periode2);

			$interval = new DateInterval('P1M');

			$p = new DatePeriod($begin, $interval ,$end);

			foreach ($p as $d) {
				$perMonth = $d->format('Y-m');
				$monthName = $d->format('M_y');
				$firstdate = date('Y-m-01 00:00:00', strtotime($perMonth));
				$lastdate = date('Y-m-t 23:59:59', strtotime($perMonth));
				${'rekap_'.$monthName} = $this->M_rekapmssql->ExportDetail($firstdate,$lastdate,$status,$section,$monthName);
			}
		}


		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(17);
		$worksheet->getColumnDimension('C')->setWidth(45);
		$worksheet->getColumnDimension('D')->setWidth(17);

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
		$worksheet->setCellValue('A2', 'Status Hubungan Kerja');
		$worksheet->setCellValue('A3', 'Seksi');

		if ($detail == 1) {
			$periodeDate = date('F Y', strtotime($periode1)).' - '.date('F Y', strtotime($periode2));
		}
		else{
			$periodeDate = date('d-m-Y', strtotime($periode1)).' - '.date('d-m-Y', strtotime($periode2));
		}
		$worksheet->setCellValue('C1', $periodeDate, PHPExcel_Cell_DataType::TYPE_STRING);
		
		foreach ($rekap_all as $rekap_info) {}

		$worksheet->setCellValue('C2', $rekap_info['kode_status_kerja'].' - '.$rekap_info['fs_ket']);
		$worksheet->setCellValue('C3', $rekap_info['seksi']);

		$worksheet->mergeCells('A6:A7');
		$worksheet->mergeCells('B6:B7');
		$worksheet->mergeCells('C6:C7');
		$worksheet->mergeCells('D6:D7');

		$worksheet->setCellValue('A6', 'No');
		$worksheet->setCellValue('B6', 'NIK');
		$worksheet->setCellValue('C6', 'NAMA');
		$worksheet->setCellValue('D6', 'MASA KERJA');

		$col = '4';
		if ($detail == 1) {
			foreach ($p as $d) {
				$T = PHPExcel_Cell::stringFromColumnIndex($col);
				$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
				$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
				$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
				$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
				$SP = PHPExcel_Cell::stringFromColumnIndex($col+5);
				$worksheet->getColumnDimension($T)->setWidth(3);
				$worksheet->getColumnDimension($I)->setWidth(3);
				$worksheet->getColumnDimension($M)->setWidth(3);
				$worksheet->getColumnDimension($S)->setWidth(3);
				$worksheet->getColumnDimension($IP)->setWidth(3);
				$worksheet->getColumnDimension($SP)->setWidth(3);
				$head_merge = $col+5;
				$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
				$worksheet->mergeCells($T.'6:'.$headCol.'6');
				$monthName = $d->format('M/Y');
				$worksheet->setCellValue($T.'6', $monthName);
				$worksheet->setCellValue($T.'7', 'T');
				$worksheet->setCellValue($I.'7', 'I');
				$worksheet->setCellValue($M.'7', 'M');
				$worksheet->setCellValue($S.'7', 'S');
				$worksheet->setCellValue($IP.'7', 'IP');
				$worksheet->setCellValue($SP.'7', 'SP');
				$col=$col+6;
			}
		}

		$T = PHPExcel_Cell::stringFromColumnIndex($col);
		$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
		$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
		$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
		$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
		$SP = PHPExcel_Cell::stringFromColumnIndex($col+5);
		$worksheet->getColumnDimension($T)->setWidth(3);
		$worksheet->getColumnDimension($I)->setWidth(3);
		$worksheet->getColumnDimension($M)->setWidth(3);
		$worksheet->getColumnDimension($S)->setWidth(3);
		$worksheet->getColumnDimension($IP)->setWidth(3);
		$worksheet->getColumnDimension($SP)->setWidth(3);
		$head_merge = $col+5;
		$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
		$worksheet->mergeCells($T.'6:'.$headCol.'6');
		$worksheet->setCellValue($T.'6', 'REKAP');
		$worksheet->setCellValue($T.'7', 'T');
		$worksheet->setCellValue($I.'7', 'I');
		$worksheet->setCellValue($M.'7', 'M');
		$worksheet->setCellValue($S.'7', 'S');
		$worksheet->setCellValue($IP.'7', 'IP');
		$worksheet->setCellValue($SP.'7', 'SP');


		$no = 1;
		$highestRow = $worksheet->getHighestRow()+1;
		foreach ($rekap_all as $rekap_data) {
			$masukkerja = $rekap_data['masuk_kerja_sebelum'];
			if($rekap_data['masuk_kerja_sebelum'] == NULL || $rekap_data['masuk_kerja_sebelum'] == ''){
				$masukkerja = $rekap_data['masukkerja'];
			}
			$masa1 = strtotime($masukkerja);
			$masa2 = strtotime($periode_masa_kerja);

			$year1 = date('Y', $masa1);
			$year2 = date('Y', $masa2);

			$month1 = date('m', $masa1);
			$month2 = date('m', $masa2);

			$total_masa_kerja = (($year2 - $year1) * 12) + ($month2 - $month1);
			$worksheet->setCellValue('A'.$highestRow, $no++);
			$worksheet->setCellValue('B'.$highestRow, $rekap_data['noind'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$highestRow, str_replace('  ', '', $rekap_data['nama']));
			$worksheet->setCellValue('D'.$highestRow, $total_masa_kerja);

			$col = 4;
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
							$IjinPerusahaan = ${'rek'.$monthName}['frekip'.strtolower($monthName)]+${'rek'.$monthName}['frekips'.strtolower($monthName)];
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
							if ($IjinPerusahaan == '0') {
								$IjinPerusahaan = '-';
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
					$SP = PHPExcel_Cell::stringFromColumnIndex($col+5);

					$worksheet->setCellValue($T.$highestRow, $Terlambat, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($I.$highestRow, $IjinPribadi, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($M.$highestRow, $Mangkir, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($S.$highestRow, $SuratKeterangan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($IP.$highestRow, $IjinPerusahaan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($SP.$highestRow, $SuratPeringatan, PHPExcel_Cell_DataType::TYPE_STRING);

					$col=$col+6;
				}
			}

			$T = PHPExcel_Cell::stringFromColumnIndex($col);
			$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
			$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
			$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
			$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
			$SP = PHPExcel_Cell::stringFromColumnIndex($col+5);

			$worksheet->setCellValue($T.$highestRow, $rekap_data['frekt']+$rekap_data['frekts'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($I.$highestRow, $rekap_data['freki']+$rekap_data['frekis'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($M.$highestRow, $rekap_data['frekm']+$rekap_data['frekms'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($S.$highestRow, $rekap_data['freksk']+$rekap_data['freksks'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($IP.$highestRow, $rekap_data['frekip']+$rekap_data['frekips'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($SP.$highestRow, $rekap_data['freksp']+$rekap_data['freksps'], PHPExcel_Cell_DataType::TYPE_STRING);

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
			$worksheet->getStyle('A6:J7')->applyFromArray($styleArray);
			$worksheet	->getStyle('A6:J7')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('0099ff');
			$worksheet->getStyle('A6:J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A6:J7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
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

	public function searchMonth($month,$status,$seksi)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS Per Area Kerja';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$seksi = str_replace('-', ' ', $seksi);
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
			$data['rekap_'.$date] = $this->M_rekapmssql->dataRekapMonthDetail($firstdate,$lastdate,$status,$seksi,$date);
		}
		$data['rekapPerMonth'] = $this->M_rekapmssql->dataRekapMonth($periode1,$periode2,$status,$seksi);
		foreach ($data['rekapPerMonth'] as $rk) {
		}

		$data['statusJabatan'] = $rk['fs_ket'];
		$data['kode_status'] = $rk['kode_status_kerja'];
		$data['seksi'] = $seksi;
		$data['periode1'] = $periode1;
		$data['periode2'] = $periode2;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_month',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportRekapMonthly($periode,$status,$section){
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

		$section = str_replace('-', ' ', $section);
		
		$periode1 = date('Y-m-01 00:00:00', strtotime($periode));
		$periode2 = date('Y-m-t 23:59:59', strtotime($periode));
		$periode_masa_kerja = $periode2;

		$begin = new DateTime($periode1);
		$end = new DateTime($periode2);

		$interval = new DateInterval('P1D');

		$p = new DatePeriod($begin, $interval ,$end);
		foreach ($p as $d) {
			$perMonth = $d->format('Y-m-d');
			$date = $d->format('d_M_y');
			$firstdate = date('Y-m-d 00:00:00', strtotime($perMonth));
			$lastdate = date('Y-m-d 23:59:59', strtotime($perMonth));
			${'rekap_'.$date} = $this->M_rekapmssql->dataRekapMonthDetail($firstdate,$lastdate,$status,$section,$date);
		}

		$firstdate = date('Y-m-01 00:00:00', strtotime($perMonth));
		$lastdate = date('Y-m-t 23:59:59', strtotime($perMonth));

		$rekap_all = $this->M_rekapmssql->dataRekapMonth($firstdate,$lastdate,$status,$section,$date);

		$worksheet->getColumnDimension('A')->setWidth(5);
		$worksheet->getColumnDimension('B')->setWidth(17);
		$worksheet->getColumnDimension('C')->setWidth(45);
		$worksheet->getColumnDimension('D')->setWidth(17);

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
		$worksheet->setCellValue('A2', 'Status Hubungan Kerja');
		$worksheet->setCellValue('A3', 'Seksi');

		$worksheet->setCellValue('C1', date('F Y', strtotime($periode1)), PHPExcel_Cell_DataType::TYPE_STRING);
		
		foreach ($rekap_all as $rekap_info) {}

		$worksheet->setCellValue('C2', $rekap_info['kode_status_kerja'].' - '.$rekap_info['fs_ket']);
		$worksheet->setCellValue('C3', $rekap_info['seksi']);

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
				$SP = PHPExcel_Cell::stringFromColumnIndex($col+5);
				$worksheet->getColumnDimension($T)->setWidth(3);
				$worksheet->getColumnDimension($I)->setWidth(3);
				$worksheet->getColumnDimension($M)->setWidth(3);
				$worksheet->getColumnDimension($S)->setWidth(3);
				$worksheet->getColumnDimension($IP)->setWidth(3);
				$worksheet->getColumnDimension($SP)->setWidth(3);
				$head_merge = $col+5;
				$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
				$worksheet->mergeCells($T.'6:'.$headCol.'6');
				$dateName = $d->format('d-m-Y');
				$worksheet->setCellValue($T.'6', $dateName);
				$worksheet->setCellValue($T.'7', 'T');
				$worksheet->setCellValue($I.'7', 'I');
				$worksheet->setCellValue($M.'7', 'M');
				$worksheet->setCellValue($S.'7', 'S');
				$worksheet->setCellValue($IP.'7', 'IP');
				$worksheet->setCellValue($SP.'7', 'SP');
				$col=$col+6;
			}
		

		$T = PHPExcel_Cell::stringFromColumnIndex($col);
		$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
		$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
		$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
		$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
		$SP = PHPExcel_Cell::stringFromColumnIndex($col+5);
		$worksheet->getColumnDimension($T)->setWidth(3);
		$worksheet->getColumnDimension($I)->setWidth(3);
		$worksheet->getColumnDimension($M)->setWidth(3);
		$worksheet->getColumnDimension($S)->setWidth(3);
		$worksheet->getColumnDimension($IP)->setWidth(3);
		$worksheet->getColumnDimension($SP)->setWidth(3);
		$head_merge = $col+5;
		$headCol = PHPExcel_Cell::stringFromColumnIndex($head_merge);
		$worksheet->mergeCells($T.'6:'.$headCol.'6');
		$worksheet->setCellValue($T.'6', 'REKAP');
		$worksheet->setCellValue($T.'7', 'T');
		$worksheet->setCellValue($I.'7', 'I');
		$worksheet->setCellValue($M.'7', 'M');
		$worksheet->setCellValue($S.'7', 'S');
		$worksheet->setCellValue($IP.'7', 'IP');
		$worksheet->setCellValue($SP.'7', 'SP');

		$no = 1;
		$highestRow = $worksheet->getHighestRow()+1;
		foreach ($rekap_all as $rekap_data) {
			$masukkerja = $rekap_data['masuk_kerja_sebelum'];
			if($rekap_data['masuk_kerja_sebelum'] == NULL || $rekap_data['masuk_kerja_sebelum'] == ''){
				$masukkerja = $rekap_data['masukkerja'];
			}
			$masa1 = strtotime($masukkerja);
			$masa2 = strtotime($periode_masa_kerja);

			$year1 = date('Y', $masa1);
			$year2 = date('Y', $masa2);

			$month1 = date('m', $masa1);
			$month2 = date('m', $masa2);

			$total_masa_kerja = (($year2 - $year1) * 12) + ($month2 - $month1);

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
					$SP = PHPExcel_Cell::stringFromColumnIndex($col+5);

					$worksheet->setCellValue($T.$highestRow, $Terlambat, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($I.$highestRow, $IjinPribadi, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($M.$highestRow, $Mangkir, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($S.$highestRow, $SuratKeterangan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($IP.$highestRow, $IjinPerusahaan, PHPExcel_Cell_DataType::TYPE_STRING);
					$worksheet->setCellValue($SP.$highestRow, $SuratPeringatan, PHPExcel_Cell_DataType::TYPE_STRING);

					$col=$col+6;
				}
			

			$T = PHPExcel_Cell::stringFromColumnIndex($col);
			$I = PHPExcel_Cell::stringFromColumnIndex($col+1);
			$M = PHPExcel_Cell::stringFromColumnIndex($col+2);
			$S = PHPExcel_Cell::stringFromColumnIndex($col+3);
			$IP = PHPExcel_Cell::stringFromColumnIndex($col+4);
			$SP = PHPExcel_Cell::stringFromColumnIndex($col+5);

			$worksheet->setCellValue($T.$highestRow, $rekap_data['frekt']+$rekap_data['frekts'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($I.$highestRow, $rekap_data['freki']+$rekap_data['frekis'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($M.$highestRow, $rekap_data['frekm']+$rekap_data['frekms'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($S.$highestRow, $rekap_data['freksk']+$rekap_data['freksks'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($IP.$highestRow, $rekap_data['frekip']+$rekap_data['frekips'], PHPExcel_Cell_DataType::TYPE_STRING);
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
	}

}
