<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
set_time_limit(0);
/**
 *
 */
class C_Tims2tahun extends CI_Controller
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
		$this->load->model('er/RekapTIMS/M_tims2tahun');

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

		$data['Title'] = 'Rekap TIMS 2 Tahun';
		$data['Menu'] = 'TIMS 2 Tahun';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('required');
		if($this->form_validation->run() === FALSE){
			$data['periode'] = $this->M_tims2tahun->getperiode();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('er/RekapTIMS/V_rekap2tahun',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$periode = $this->input->post('txtPeriodeRekap');
			$prd = explode(" - ", $periode);
			$detail = $this->input->post('txtDetailDataTIMS');
			//insert to sys.log_activity
			$aksi = 'REKAP TIMS';
			$detail = "Export Excel tims 2tahun periode=$periode";
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

			$rekap_all = $this->M_tims2tahun->getData($prd[0],$prd[1]);
			$dataBln = $this->M_tims2tahun->getBulan($prd[0],$prd[1]);

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
			$worksheet->setCellValue('A2', 'Status Hubungan Kerja');
			$worksheet->setCellValue('A3', 'Seksi');


			// $periodeDate = date('d-m-Y', strtotime($periode1)).' - '.date('d-m-Y', strtotime($periode2));



			foreach ($rekap_all as $rekap_info) {}
			$worksheet->setCellValue('C1', $rekap_info['tanggal_awal_rekap'].' - '.$rekap_info['tanggal_akhir_rekap'], PHPExcel_Cell_DataType::TYPE_STRING);
			$worksheet->setCellValue('C2', "All (selain 'F','R','Q','L','Z','M')");
			$worksheet->setCellValue('C3', "All");

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

			if (isset($detail) and !empty($detail) and $detail == 'withDetail') {

				foreach ($dataBln as $key) {
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

					$worksheet->setCellValue($T.'6', ucwords($key['tanggal']));
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

				if (isset($detail) and !empty($detail) and $detail == 'withDetail') {
					$rekapDetail = $this->M_tims2tahun->getRekapDetail($rekap_data['noind'],$prd[0],$prd[1]);
					foreach ($rekapDetail as $detailBulan) {
							$Terlambat = $detailBulan['frekt']+$detailBulan['frekts'];
							$IjinPribadi = $detailBulan['freki']+$detailBulan['frekis'];
							$Mangkir = $detailBulan['frekm']+$detailBulan['frekms'];
							$SuratKeterangan = $detailBulan['freksk']+$detailBulan['freksks'];
							$SakitPerusahaan = $detailBulan['frekpsp']+$detailBulan['frekpsps'];
							$IjinPerusahaan = $detailBulan['frekip']+$detailBulan['frekips'];
							$CutiTahunan = $detailBulan['frekct']+$detailBulan['frekcts'];
							$SuratPeringatan = $detailBulan['freksp']+$detailBulan['freksps'];
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

				$worksheet->setCellValue($T.$highestRow, $rekap_data['frekt']+$rekap_data['frekts'], PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($I.$highestRow, $rekap_data['freki']+$rekap_data['frekis'], PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($M.$highestRow, $rekap_data['frekm']+$rekap_data['frekms'], PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($S.$highestRow, $rekap_data['freksk']+$rekap_data['freksks'], PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($PSP.$highestRow, $rekap_data['frekpsp']+$rekap_data['frekpsps'], PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($IP.$highestRow, $rekap_data['frekip']+$rekap_data['frekips'], PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($CT.$highestRow, $rekap_data['frekct']+$rekap_data['frekcts'], PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($SP.$highestRow, $rekap_data['freksp']+$rekap_data['freksps'], PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($THK.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : ($rekap_data['totalhk']+$rekap_data['totalhks'])), PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($P_T.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekt']+$rekap_data['frekts']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($P_I.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['freki']+$rekap_data['frekis']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($P_M.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekm']+$rekap_data['frekms']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($P_S.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['freksk']+$rekap_data['freksks']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($P_PSP.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekpsp']+$rekap_data['frekpsps']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($P_IP.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekip']+$rekap_data['frekips']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
				$worksheet->setCellValue($P_CT.$highestRow, ((($rekap_data['totalhk']+$rekap_data['totalhks']) == 0 ) ? "-" : sprintf("%.2f%%", (($rekap_data['frekct']+$rekap_data['frekcts']) / ($rekap_data['totalhk']+$rekap_data['totalhks']) * 100))), PHPExcel_Cell_DataType::TYPE_STRING);
				if(($rekap_data['totalhk']+$rekap_data['totalhks']) == 0)
				{
					$worksheet->setCellValue
							(
								$P_Tot.$highestRow,
								(
									0
								),
								PHPExcel_Cell_DataType::TYPE_STRING
							);
				}
				else
				{
					$worksheet->setCellValue
							(
								$P_Tot.$highestRow,
								(
									substr(
										round(
												(
													(float)
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
															)
														)
														/
														(($rekap_data['totalhk']+$rekap_data['totalhks']) - ($rekap_data['frekct']+$rekap_data['frekcts']))
													)
													*100
												),
											2),
									0,
									5)
									.'%'
								),
								PHPExcel_Cell_DataType::TYPE_STRING
							);
				}
				$highestRow++;
			}

			$highestColumn = $worksheet->getHighestColumn();
			$highestRow = $worksheet->getHighestRow();
			if (isset($detail) and !empty($detail) and $detail == 'withDetail') {
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
				$worksheet->getStyle('A6:Y7')->applyFromArray($styleArray);
				$worksheet	->getStyle('A6:Y7')
							->getFill()
							->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
							->getStartColor()
							->setARGB('0099ff');
				$worksheet->getStyle('A6:Y7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$worksheet->getStyle('A6:Y7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			}
			$worksheet->freezePaneByColumnAndRow(4, 8);

			$worksheet->getStyle('D8:'.$highestColumn.$highestRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


			if (isset($detail) and !empty($detail) and $detail == 'withDetail') {
				$fileName = 'Rekap_With_Detail';
			}
			else{
				$fileName = 'Rekap_Without_Detail';
			}


			$worksheet->setTitle('Rekap TIMS');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			// ob_end_clean();
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$fileName.'-'.time().'.xls"');
			$objWriter->save("php://output");
		}
	}
}
?>
