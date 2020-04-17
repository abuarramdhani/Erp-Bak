<?php
Defined('BASEPATH') or exit('No DIrect Script Access Allowed');
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
		$this->load->model('er/RekapTIMS/M_overtime');
		$this->load->model('er/RekapTIMS/M_rekapmssql');
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

		$data['Title'] = 'Data Overtime Pekerja';
		$data['Menu'] = 'Data Overtime Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['status'] = $this->M_rekapmssql->statusKerja();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_overtime',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Cari(){
		// print_r($_POST);exit();
		$periode = $this->input->post('txtTanggalRekap');
		$dept = $this->input->post('cmbDepartemen');
		$bid = $this->input->post('cmbBidang');
		$unit = $this->input->post('cmbUnit');
		$seksi = $this->input->post('cmbSeksi');
		$hubker = $this->input->post('statushubker');
		$all = $this->input->post('statusAll');
		$detail = $this->input->post('detail');

		$date = explode(' - ', $periode);
		$tgl1 = date('M',strtotime($date[0]));
		$tgl2 = date('M Y',strtotime($date[1]));
		$data['periodeM'] = $tgl1." - ".$tgl2;

			$hub = "";
			$exhub = "";
			if (isset($all) and !empty($all) and $all == '1') {
				$shk = $this->M_rekapmssql->statusKerja();
				foreach ($shk as $key) {
					if ($hub == "") {
							$hub = "'".$key['fs_noind']."'";
							$exhub = $key['fs_noind'];
					}else{
							$hub .= ",'".$key['fs_noind']."'";
							$exhub .= "-".$key['fs_noind'];
					}
				}
			}else{
				foreach ($hubker as $key) {
					if ($hub == "") {
						$hub = "'".$key."'";
						$exhub = $key;
					}else{
						$hub .= ",'".$key."'";
						$exhub .= "-".$key;
					}
				}
			}

			$kdsie = $dept;
			if (isset($bid) and !empty($bid) and substr($bid, -2) !== '00') {
				$kdsie = $bid;
			}

			if (isset($unit) and !empty($unit) and substr($unit, -2) !== '00') {
				$kdsie = $unit;
			}

			if (isset($seksi) and !empty($seksi) and substr($seksi, -2) !== '00') {
				$kdsie = $seksi;
			}
			// echo $kdsie;exit();
			$data['detail'] = $detail;
			$prd = explode(' - ', $periode);
			if ($kdsie == '0') {
				$dataOvertime = $this->M_overtime->getData($prd[0],$prd[1],$hub,$kdsie=false,$detail);
			}else{
				$dataOvertime = $this->M_overtime->getData($prd[0],$prd[1],$hub,$kdsie,$detail);
			}
		// echo "<pre>";
		// print_r($dataOvertime);
		$user_id = $this->session->userid;

		$data['Title'] = 'Data Overtime Pekerja';
		$data['Menu'] = 'Data Overtime Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['status'] = $this->M_rekapmssql->statusKerja();
		$data['table'] = $dataOvertime;
		$data['export'] = $kdsie.'_'.$exhub.'_'.$periode.'_'.$detail;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('er/RekapTIMS/V_overtime',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportExcel($data){
		// print_r($data);
		// exit();
		$data = str_replace("%20", " ", $data);
		$do = explode("_", $data);
		$export = $do['0'];
		$kdsie = $do['1'];
		$hubker = explode("-", $do['2']);
		$hub = "";
		//insert to sys.log_activity
		$aksi = 'REKAP TIMS';
		$detail = "Export Excel Overtime Pekerja kodesie = $kdsie";
		$this->log_activity->activity_log($aksi, $detail);
		//
		foreach ($hubker as $key) {
			if ($hub == "") {
				$hub = "'".$key."'";
			}else{
				$hub .= ",'".$key."'";
			}
		}
		$prd = explode(' - ', $do['3']);
		$detail = $do['4'];
		if ($kdsie !== '0') {
			$dataOvertime = $this->M_overtime->getData($prd[0],$prd[1],$hub,$kdsie,$detail);
		}else{
			$dataOvertime = $this->M_overtime->getData($prd[0],$prd[1],$hub,$detail);
		}

		$tgl1 = date('M',strtotime($prd[0]));
		$tgl2 = date('M Y',strtotime($prd[1]));
		$periodeM = $tgl1." - ".$tgl2;

			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();
			$worksheet->setCellValue('A1','No');
			$worksheet->setCellValue('B1','Periode');
			$worksheet->setCellValue('C1','Nama');
			$worksheet->setCellValue('D1','Seksi');
			$worksheet->setCellValue('E1','Total Jam Kerja');
			$worksheet->setCellValue('F1','Total Hari Kerja');
			$worksheet->setCellValue('G1','Overtime');
			$worksheet->setCellValue('H1','Net');
			$worksheet->setCellValue('I1','rerata Net/hari');

			$angka = 1;
			$row = 2;
			foreach ($dataOvertime as $key ) {
				$worksheet->setCellValue('A'.$row,$angka);
				if ($detail == 1){
					$worksheet->setCellValue('B'.$row,$key['periode']);
				}
				else {
					$worksheet->setCellValue('B'.$row,$periodeM);
				}
				$worksheet->setCellValue('C'.$row,$key['noind']." - ".$key['nama']);
				$worksheet->setCellValue('D'.$row,$key['seksi']);
				$worksheet->getStyle('E'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$worksheet->setCellValueExplicit('E'.$row,$key['jam_kerja'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$worksheet->getStyle('F'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$worksheet->setCellValueExplicit('F'.$row,$key['hari_kerja'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$worksheet->getStyle('G'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$worksheet->setCellValueExplicit('G'.$row,$key['overtime'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$worksheet->getStyle('H'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$worksheet->setCellValueExplicit('H'.$row,$key['net'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$worksheet->getStyle('I'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$worksheet->setCellValueExplicit('I'.$row,$key['rerata_net'],PHPExcel_Cell_DataType::TYPE_NUMERIC);
				$row++;
				$angka++;
			}

			$worksheet->getColumnDimension('A')->setWidth('5');
			$worksheet->getColumnDimension('B')->setWidth('15');
			$worksheet->getColumnDimension('C')->setWidth('30');
			$worksheet->getColumnDimension('D')->setWidth('30');

			$filename ='Rekap_Overtime_'.$kdsie.'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');

			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}

			public function ExportPdf($data){

				set_time_limit(0);
				
				$data = str_replace("%20", " ", $data);
				$do = explode("_", $data);
				$export = $do['0'];
				$kdsie = $do['1'];
				$hubker = explode("-", $do['2']);
				$hub = "";
				//insert to sys.log_activity
				$aksi = 'REKAP TIMS';
				$detail = "Export PDF Overtime Pekerja kodesie = $kdsie";
				$this->log_activity->activity_log($aksi, $detail);
				//
				foreach ($hubker as $key) {
					if ($hub == "") {
						$hub = "'".$key."'";
					}else{
						$hub .= ",'".$key."'";
					}
				}
				$prd = explode(' - ', $do['3']);
				$detail = $do['4'];
				if ($kdsie !== '0') {
					$dataOvertime = $this->M_overtime->getData($prd[0],$prd[1],$hub,$kdsie,$detail);
				}else{
					$dataOvertime = $this->M_overtime->getData($prd[0],$prd[1],$hub,$detail);
				}

				$tgl1 = date('M',strtotime($prd[0]));
				$tgl2 = date('M Y',strtotime($prd[1]));
				$periodeM = $tgl1." - ".$tgl2;

				$this->load->library('pdf');

				$pdf = $this->pdf->load();
				$pdf = new mPDF('','A4-L',0,'',10,10,10,10,10,10);
				$filename = 'Rekap_Overtime_'.$kdsie.'.pdf';

				$dataa['detail'] = $detail;
				$dataa['periodeM'] = $periodeM;
				$dataa['dataovertime'] = $dataOvertime;
				$html = $this->load->view('er/RekapTIMS/V_cetak_overtime', $dataa, true);

				$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
				$pdf->WriteHTML($stylesheet1,1);
				$pdf->WriteHTML($html, 2);
				$pdf->Output($filename, 'I');
			}
		}
 ?>
