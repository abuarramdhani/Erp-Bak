<?php
Defined('BASEPATH') or exit('No DIrect Script Access Allowed');
set_time_limit(0);
ini_set('memory_limit', '-1');
/**
 *
 */
class C_Index extends CI_Controller
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
		$this->load->model('ADMPelatihan/M_tarikdatapekerja');
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

		$data['Title'] = 'Tarik Data Pekerja';
		$data['Menu'] = 'Tarik Data Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['status'] = $this->M_rekapmssql->statusKerja();
		$data['lokasi'] = $this->M_tarikdatapekerja->lokasiKerja();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/TarikDataPekerja/V_tarikdatapekerja',$data);
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
		$lokasi = $this->input->post('lokasi');
		$all = $this->input->post('statusAll');
		$alllok = $this->input->post('lokasiAll');
		$detail = $this->input->post('detail');
        $data['lokasi'] = $this->M_tarikdatapekerja->lokasiKerja();


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

			$lok = "";
			$exlok = "";
			if (isset($alllok) and !empty($alllok) and $alllok == '1') {
				$slok = $this->M_tarikdatapekerja->lokasiKerja();
				foreach ($slok as $key) {
					if ($lok == "") {
							$lok = "'".$key['id_']."'";
							$exlok = $key['id_'];
					}else{
							$lok .= ",'".$key['id_']."'";
							$exlok .= "-".$key['id_'];
					}
				}
			}else{
				foreach ($lokasi as $key) {
					if ($lok == "") {
						$lok = "'".$key."'";
						$exlok = $key;
					}else{
						$lok .= ",'".$key."'";
						$exlok .= "-".$key;
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
			// echo $lok;exit();
			$data['detail'] = $detail;
			$prd = explode(' - ', $periode);
			if ($kdsie == '0') {
				$tarikdatapekerja= $this->M_tarikdatapekerja->getData($hub,$kdsie=false,$lok);
			}else{
				$tarikdatapekerja = $this->M_tarikdatapekerja->getData($hub,$kdsie,$lok);
			}
		 //echo "<pre>111".strtotime("2053-01-01");
		 // print_r($tarikdatapekerja);
		 //exit();
		$user_id = $this->session->userid;

		$data['Title'] = 'Tarik Data Pekerja';
		$data['Menu'] = 'Tarik Data Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['status'] = $this->M_rekapmssql->statusKerja();
		$data['table'] = $tarikdatapekerja;
		$data['export'] = $kdsie.'_'.$exhub.'_'.$exlok;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/TarikDataPekerja/V_tarikdatapekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportExcel($data){
		//echo "<pre>");
		 // print_r($data);
		 //exit();
		$data = str_replace("%20", " ", $data);
				$do = explode("_", $data);
				$export = $do['0'];
				$kdsie = $do['1'];
				$hubker = explode("-", $do['2']);
				$hub = "";
				$lokasi = explode("-", $do['3']);
				$lok = "";
				//insert to sys.log_activity
				$aksi = 'ADM Pelatihan';
				$detail = "Export EXCEL Tarik Data Pekerja kodesie = $kdsie";
				$this->log_activity->activity_log($aksi, $detail);
				//
				foreach ($hubker as $key) {
					if ($hub == "") {
						$hub = "'".$key."'";
					}else{
						$hub .= ",'".$key."'";
					}
				}

				foreach ($lokasi as $key) {
					if ($lok == "") {
						$lok = "'".$key."'";
					}else{
						$lok .= ",'".$key."'";
					}
				}


              if ($kdsie == '0') {
				$tarikdatapekerja = $this->M_tarikdatapekerja->getData($hub,$kdsie=false,$lok);
			}else{
				$tarikdatapekerja = $this->M_tarikdatapekerja->getData($hub,$kdsie,$lok);
			}

			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();
			
			$worksheet->setCellValue('A1','Data Pekerja  dicetak melalui QuickERP - (ADM Pelatihan)'.  date('d-m-Y H:i:s') . " oleh ". $this->session->user ." - ". $this->session->employee);
			$worksheet->setCellValue('A3','No');
			$worksheet->setCellValue('B3','Noind');
			$worksheet->setCellValue('C3','Nama');
			$worksheet->setCellValue('D3','Dept');
			$worksheet->setCellValue('E3','Bidang');
			$worksheet->setCellValue('F3','Unit');
			$worksheet->setCellValue('G3','Seksi');
			$worksheet->setCellValue('H3','Jabatan');
			$worksheet->setCellValue('I3','Lokasi Kerja');
			$worksheet->setCellValue('J3','Tgl.Diangkat');
			$worksheet->setCellValue('K3','Akh.Kontrak');

															


			$angka = 1;
			$row = 4;
			foreach ($tarikdatapekerja as $key ) {
				$worksheet->setCellValue('A'.$row,$angka);
				$worksheet->setCellValue('B'.$row,$key['noind']);
				$worksheet->setCellValue('C'.$row,$key['nama']);
				$worksheet->setCellValue('D'.$row,$key['dept']);
				$worksheet->setCellValue('E'.$row,$key['bidang']);
				$worksheet->setCellValue('F'.$row,$key['unit']);
				$worksheet->setCellValue('G'.$row,$key['seksi']);
				$worksheet->setCellValue('H'.$row,$key['jabatan']);
				$worksheet->setCellValue('I'.$row,$key['lokasi_kerja']);
				$worksheet->setCellValue('J'.$row,$key['diangkat']);
				$worksheet->setCellValue('K'.$row,$key['akhkontrak']);
				


				$row++;
				$angka++;
			}

			$worksheet->getColumnDimension('A')->setWidth('5');
			$worksheet->getColumnDimension('B')->setWidth('10');
			$worksheet->getColumnDimension('C')->setWidth('30');
			$worksheet->getColumnDimension('D')->setWidth('15');
			$worksheet->getColumnDimension('E')->setWidth('30');
			$worksheet->getColumnDimension('F')->setWidth('30');
			$worksheet->getColumnDimension('G')->setWidth('40');
			$worksheet->getColumnDimension('H')->setWidth('40');
			$worksheet->getColumnDimension('I')->setWidth('15');
			$worksheet->getColumnDimension('J')->setWidth('15');
			$worksheet->getColumnDimension('K')->setWidth('15');

					        // merge cell
            $worksheet->mergeCells('A1:H1');
            
			$filename ='Tarik_Data_Pekerja'.$kdsie.'.xls';
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
				$lokasi = explode("-", $do['3']);
				$lok = "";
				//insert to sys.log_activity
				$aksi = 'ADM Pelatihan';
				$detail = "Export PDF Tarik Data Pekerja kodesie = $kdsie";
				$this->log_activity->activity_log($aksi, $detail);
				//
				foreach ($hubker as $key) {
					if ($hub == "") {
						$hub = "'".$key."'";
					}else{
						$hub .= ",'".$key."'";
					}
				}

				foreach ($lokasi as $key) {
					if ($lok == "") {
						$lok = "'".$key."'";
					}else{
						$lok .= ",'".$key."'";
					}
				}

              if ($kdsie == '0') {
				$tarikdatapekerja = $this->M_tarikdatapekerja->getData($hub,$kdsie=false,$lok);
			}else{
				$tarikdatapekerja = $this->M_tarikdatapekerja->getData($hub,$kdsie,$lok);
			}


				$this->load->library('pdf');

				$pdf = $this->pdf->load();
				//$pdf = new mPDF('','A4-L',0,'',10,10,10,10,10,10);
				$pdf = new mPDF('UTF-8', 'A4-L', '8', 'Arial', 5, 5, 5, 5, 0, 0);
				$filename = 'Rekap_Overtime_'.$kdsie.'.pdf';

				$dataa['detail'] = $detail;
				$dataa['periodeM'] = $periodeM;
				$dataa['tarikdatapekerja'] = $tarikdatapekerja;
				$html = $this->load->view('ADMPelatihan/TarikDataPekerja/V_cetak', $dataa, true);
				$pdf->defaultfooterline = false;
        $pdf->setFooter("
        <div style='text-align: left; font-weight: 100;'>
        <small style='font-size: 10px; float: left; font-style: italic;'>Halaman ini dicetak melalui QuickERP - (ADM Pelatihan) - ". date('d-m-Y H:i:s') . " oleh {$this->session->user} - {$this->session->employee}</small>
        </div>
        ");

				$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
				$pdf->WriteHTML($stylesheet1,1);
				$pdf->WriteHTML($html, 2);
				$pdf->Output($filename, 'I');
			}
		}
 ?>
