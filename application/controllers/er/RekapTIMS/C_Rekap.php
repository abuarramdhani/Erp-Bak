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
		$data['Menu'] = 'Rekap TIMS';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['status'] = $this->M_rekapmssql->statusKerja();
		$data['dept'] = $this->M_rekapmssql->dept();

		$data['bidang'] = $this->M_rekapmssql->bidang($this->session->userdata('departemenFilter'));
		$data['unit'] = $this->M_rekapmssql->unit($this->session->userdata('bidangFilter'));
		$data['seksi'] = $this->M_rekapmssql->seksi($this->session->userdata('unitFilter'));
		
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
				echo '<option value="'.$data['Bidang'].'">'.$data['Bidang'].'</option>';
			}
		}
		elseif ($modul == 'unit') {
			$data = $this->M_rekapmssql->unit($id);
			foreach ($data as $data) {
				echo '<option value="'.$data['Unit'].'">'.$data['Unit'].'</option>';
			}
		}
		elseif ($modul == 'seksi') {
			$data = $this->M_rekapmssql->seksi($id);
			foreach ($data as $data) {
				echo '<option value="'.$data['Seksi'].'">'.$data['Seksi'].'</option>';
			}
		}
	}

	//------------------------show the data REKAP TIMS-----------------------------
	public function showData()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS';
		
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

		
		$this->session->set_userdata('statusFilter', $status);
		$this->session->set_userdata('departemenFilter', $departemen);
		$this->session->set_userdata('bidangFilter', $bidang);
		$this->session->set_userdata('unitFilter', $unit);
		$this->session->set_userdata('seksiFilter', $section);
		$this->session->set_userdata('detailFilter', $detail);

		
		//$this->load->view('V_Header',$data);
		//$this->load->view('V_Sidemenu',$data);
		$data['periode1']	= $this->input->post('rekapBegin');
		$data['periode2']	= $this->input->post('rekapEnd');
		if ($detail==NULL) {
			$this->session->set_userdata('periode1Filter', $periode1);
			$this->session->set_userdata('periode2Filter', $periode2);
			$data['rekap'] = $this->M_rekapmssql->dataRekap($periode1,$periode2,$status,$departemen,$bidang,$unit,$section);
			$this->load->view('er/RekapTIMS/V_rekap_table',$data);
		}
		else {
			$this->session->set_userdata('periode1Filter', date('Y-m-01 00:00:00', strtotime($periode1)));
			$this->session->set_userdata('periode2Filter', date('Y-m-t 00:00:00', strtotime($periode2)));
			$begin = new DateTime($periode1);
			$end = new DateTime($periode2);
			$end = $end->modify('+1 month');
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
		$this->config->set_item('sess_expiration',60);
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
		$rekap_all = $this->M_rekapmssql->ExportRekap($period1,$period2,$status,$section);

		if ($detail == 1) {
			$ex_period2 = explode('-', $periode2);
			$bln_new = $ex_period2[1]-1;
			$periode2 = $ex_period2[0].'-'.$bln_new.'-'.$ex_period2[2];

			$begin = new DateTime($periode1);
			$end = new DateTime($periode2);
			$end = $end->modify('+1 month');

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

		$worksheet->setCellValue('A6', 'No');
		$worksheet->setCellValue('B6', 'NIK');
		$worksheet->setCellValue('C6', 'NAMA');

		$col = '3';
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
			$worksheet->setCellValue('A'.$highestRow, $no++);
			$worksheet->setCellValue('B'.$highestRow, $rekap_data['noind'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$highestRow, str_replace('  ', '', $rekap_data['nama']));

			$col = 3;
			if ($detail == 1) {
				foreach ($p as $d) {
					$monthName = $d->format('M_y');
					foreach (${'rekap_'.$monthName} as ${'rek'.$monthName}) {
						if ($rekap_data['noind'] == ${'rek'.$monthName}['noind'] && $rekap_data['nama'] == ${'rek'.$monthName}['nama'] && $rekap_data['nik'] == ${'rek'.$monthName}['nik'] && $rekap_data['tgllahir'] == ${'rek'.$monthName}['tgllahir'])
						{
							$Terlambat = ${'rek'.$monthName}['FrekT'.$monthName]+${'rek'.$monthName}['FrekTs'.$monthName];
							$IjinPribadi = ${'rek'.$monthName}['FrekI'.$monthName]+${'rek'.$monthName}['FrekIs'.$monthName];
							$Mangkir = ${'rek'.$monthName}['FrekM'.$monthName]+${'rek'.$monthName}['FrekMs'.$monthName];
							$SuratKeterangan = ${'rek'.$monthName}['FrekSK'.$monthName]+${'rek'.$monthName}['FrekSKs'.$monthName];
							$IjinPerusahaan = ${'rek'.$monthName}['FrekIP'.$monthName]+${'rek'.$monthName}['FrekIPs'.$monthName];
							$SuratPeringatan = ${'rek'.$monthName}['FrekSP'.$monthName]+${'rek'.$monthName}['FrekSPs'.$monthName];
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

			$worksheet->setCellValue($T.$highestRow, $rekap_data['FrekT']+$rekap_data['FrekTs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($I.$highestRow, $rekap_data['FrekI']+$rekap_data['FrekIs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($M.$highestRow, $rekap_data['FrekM']+$rekap_data['FrekMs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($S.$highestRow, $rekap_data['FrekSK']+$rekap_data['FrekSKs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($IP.$highestRow, $rekap_data['FrekIP']+$rekap_data['FrekIPs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($SP.$highestRow, $rekap_data['FrekSP']+$rekap_data['FrekSPs'], PHPExcel_Cell_DataType::TYPE_STRING);

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
			$worksheet->getStyle('A6:I7')->applyFromArray($styleArray);
			$worksheet	->getStyle('A6:I7')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('0099ff');
			$worksheet->getStyle('A6:I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$worksheet->getStyle('A6:I7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}
		$worksheet->freezePaneByColumnAndRow(3, 8);

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

	public function searchEmployee($periode1,$periode2,$nik)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periode1'] = date('Y-m-d', strtotime($periode1));
		$data['periode2'] = date('Y-m-d', strtotime($periode2));

		$data['info'] = $this->M_rekapmssql->rekapPersonInfo($nik);
		$data['Terlambat'] = $this->M_rekapmssql->rekapPersonTIM($data['periode1'],$data['periode2'],$nik,$keterangan = 'TT');
		$data['IjinPribadi'] = $this->M_rekapmssql->rekapPersonTIM($data['periode1'],$data['periode2'],$nik,$keterangan = 'TIK');
		$data['Mangkir'] = $this->M_rekapmssql->rekapPersonTIM($data['periode1'],$data['periode2'],$nik,$keterangan = 'TM');
		$data['IjinPerusahaan'] = $this->M_rekapmssql->rekapPersonSIP($data['periode1'],$data['periode2'],$nik,$keterangan = 'PIP');
		$data['SuratPeringatan'] = $this->M_rekapmssql->rekapPersonSP($data['periode1'],$data['periode2'],$nik);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_personal',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportEmployee($periode1,$periode2,$nik){
		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();

		$info = $this->M_rekapmssql->rekapPersonInfo($nik);
		$Terlambat = $this->M_rekapmssql->rekapPersonTIM($periode1,$periode2,$nik,$keterangan = 'TT');
		$IjinPribadi = $this->M_rekapmssql->rekapPersonTIM($periode1,$periode2,$nik,$keterangan = 'TIK');
		$Mangkir = $this->M_rekapmssql->rekapPersonTIM($periode1,$periode2,$nik,$keterangan = 'TM');
		$IjinPerusahaan = $this->M_rekapmssql->rekapPersonSIP($periode1,$periode2,$nik,$keterangan = 'PIP');
		$SuratPeringatan = $this->M_rekapmssql->rekapPersonSP($periode1,$periode2,$nik);
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
		$worksheet->setCellValue('A6', 'UNIT');

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
			$worksheet->setCellValue('C'.$row, $SP['nT'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('D'.$row, $SP['nIK'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('E'.$row, $SP['nM'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('G'.$row, $SP['bobot'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('H'.$row, $SP['sp_ke'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('I'.$row, $SP['Status'], PHPExcel_Cell_DataType::TYPE_STRING);
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

	public function searchMonth($month,$status,$seksi)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Filter TIMS';
		$data['Menu'] = 'Rekap TIMS';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$seksi = str_replace('-', ' ', $seksi);
		$periode1 = date('Y-m-01 00:00:00', strtotime($month));
		$periode2 = date('Y-m-t 23:59:59', strtotime($month));

		$begin = new DateTime($periode1);
		$end = new DateTime($periode2);
		$end = $end->modify('+1 day');

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

		$ex_period2 = explode('-', $periode2);
		$tgl_new = $ex_period2[2]-1;
		$periode2 = $ex_period2[0].'-'.$ex_period2[1].'-'.$tgl_new;

		$begin = new DateTime($periode1);
		$end = new DateTime($periode2);
		$end = $end->modify('+1 day');

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

		$worksheet->setCellValue('A6', 'No');
		$worksheet->setCellValue('B6', 'NIK');
		$worksheet->setCellValue('C6', 'NAMA');

		$col = '3';
		
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
			$worksheet->setCellValue('A'.$highestRow, $no++);
			$worksheet->setCellValue('B'.$highestRow, $rekap_data['noind'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C'.$highestRow, str_replace('  ', '', $rekap_data['nama']));

			$col = 3;
			
				foreach ($p as $d) {
					$dateName = $d->format('d_M_y');
					foreach (${'rekap_'.$dateName} as ${'rek'.$dateName}) {
						if ($rekap_data['noind'] == ${'rek'.$dateName}['noind'] && $rekap_data['nama'] == ${'rek'.$dateName}['nama'] && $rekap_data['nik'] == ${'rek'.$dateName}['nik'] && $rekap_data['tgllahir'] == ${'rek'.$dateName}['tgllahir'])
						{
							$Terlambat = ${'rek'.$dateName}['FrekT'.$dateName]+${'rek'.$dateName}['FrekTs'.$dateName];
							$IjinPribadi = ${'rek'.$dateName}['FrekI'.$dateName]+${'rek'.$dateName}['FrekIs'.$dateName];
							$Mangkir = ${'rek'.$dateName}['FrekM'.$dateName]+${'rek'.$dateName}['FrekMs'.$dateName];
							$SuratKeterangan = ${'rek'.$dateName}['FrekSK'.$dateName]+${'rek'.$dateName}['FrekSKs'.$dateName];
							$IjinPerusahaan = ${'rek'.$dateName}['FrekIP'.$dateName]+${'rek'.$dateName}['FrekIPs'.$dateName];
							$SuratPeringatan = ${'rek'.$dateName}['FrekSP'.$dateName]+${'rek'.$dateName}['FrekSPs'.$dateName];
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

			$worksheet->setCellValue($T.$highestRow, $rekap_data['FrekT']+$rekap_data['FrekTs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($I.$highestRow, $rekap_data['FrekI']+$rekap_data['FrekIs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($M.$highestRow, $rekap_data['FrekM']+$rekap_data['FrekMs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($S.$highestRow, $rekap_data['FrekSK']+$rekap_data['FrekSKs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($IP.$highestRow, $rekap_data['FrekIP']+$rekap_data['FrekIPs'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue($SP.$highestRow, $rekap_data['FrekSP']+$rekap_data['FrekSPs'], PHPExcel_Cell_DataType::TYPE_STRING);

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
		
		$worksheet->freezePaneByColumnAndRow(3, 8);

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
