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
		$this->load->model('MasterPresensi/ShiftPekerja/M_tarikshiftpekerja');
		$this->load->model('er/RekapTIMS/M_rekapabsensi');
	
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

		$data['Title'] = 'Tarik Data Shift Pekerja';
		$data['Menu'] = 'Shift Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['status'] = $this->M_tarikshiftpekerja->statusKerja();
		$data['lokasi'] = $this->M_tarikshiftpekerja->lokasiKerja();
		// print_r($data['status']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/TarikShiftPekerja/V_tarikshiftpekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Cari(){
		$periode = $this->input->post('txtTanggalRekap');
		$dept = $this->input->post('cmbDepartemen');
		$bid = $this->input->post('cmbBidang');
		$unit = $this->input->post('cmbUnit');
		$seksi = $this->input->post('cmbSeksi');
		$hubker = $this->input->post('statushubker');
		$all = $this->input->post('statusAll');
		$detail = $this->input->post('detail');
		$all = $this->input->post('statusAll');
		$lokasi = $this->input->post('lokasi');
		$alllok = $this->input->post('lokasiAll');
		$data['status'] = $this->M_tarikshiftpekerja->statusKerja();
		$data['lokasi'] = $this->M_tarikshiftpekerja->lokasiKerja();

		$date = explode(' - ', $periode);
		$tgl1 = $date[0];
		$tgl2 = $date[1];
		$data['periodeM'] = $tgl1." - ".$tgl2;

		$hub = "";
		$exhub = "";
		if (isset($all) and !empty($all) and $all == '1') {
			$shk = $this->M_tarikshiftpekerja->statusKerja();
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
			$slok = $this->M_tarikshiftpekerja->lokasiKerja();
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
		 //echo $exlok;exit();
		$data['detail'] = $detail;
		$prd = explode(' - ', $periode);
		if ($kdsie == '0') {
			$shift = $this->M_tarikshiftpekerja->getData($prd[0],$prd[1],$hub,$kdsie=false,$lok);
		}else{
			$shift = $this->M_tarikshiftpekerja->getData($prd[0],$prd[1],$hub,$kdsie,$lok);
		}
		// langkah langkah mengisi data yang kolomnya dinamis :
		// 1 buat looping yang kebawah (vertical) disini ada noind & nama, pastikan noind & nama tidak ada duplikat
		//foreach ($shift as $shift_key => $shift_value) {
			// 2 didalam looping nomor 1 dibuat looping untuk ke kanan (horizontal) 
			//$shift[$shift_key]['data']; // ini untuk menampung datadari tanggal awal sampai dengan tanggal akhir;
			//foreach ($variable as $variable_key => $variable_value) { //$variable ini diganti nama variable tanggal yang digunakan untuk looping header tabel. ini letaknya diatas header? kalau looping ini ada di atas variabel yang dimaksud, ini dipindah ke bawahnya supaya tidak error.
				

			//}
		//}

		$data_tanggal = $this->M_tarikshiftpekerja->getTanggalByParams($tgl1,$tgl2);
		$data['tanggal'] = $this->M_tarikshiftpekerja->getTanggalByParams($tgl1,$tgl2);

		//header awal
		$header_bulan = '<th rowspan="2" style="text-align: center;vertical-align: middle;">No. Induk</th>
						<th rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>';
		$header_tanggal = "";
		$simpan_bulan_tahun = "";
		$simpan_bulan = "";
		$simpan_tahun = "";
		$hitung_colspan = 1;
		$tanggal_pertama = "";
		$tanggal_terakhir = "";
		$bulan = array (
			1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
		);
		foreach ($data_tanggal as $dt_bulan) {
			$header_tanggal .= "<th style='text-align: center'>".$dt_bulan['hari']."</th>";
			if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
				$hitung_colspan++;
			}else{
				if ($simpan_bulan !== "") {
					$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
					$hitung_colspan = 1;
				}else{
					$tanggal_pertama = $dt_bulan['tanggal'];
				}
			}
			$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
			$simpan_bulan = $dt_bulan['bulan'];
			$simpan_tahun = $dt_bulan['tahun'];
		}
		$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
		$tanggal_terakhir = $dt_bulan['tanggal'];
		$data['header'] = "<tr>$header_bulan</tr><tr>$header_tanggal</tr>";

		$aggr = array();
		foreach ($shift as $shift_key => $shift_value) {
			$shift[$shift_key]['data'] = array();
			foreach ($data_tanggal as $data_tanggal_key => $data_tanggal_value ) { 

				$shift_pekerja = $this->M_tarikshiftpekerja->getDataDetail($shift_value['noind'],$data_tanggal_value['tanggal']);
				if (!empty($shift_pekerja)) {
					$shift_pekerja_ = $shift_pekerja[0]['inisial'];
				}else{
					$shift_pekerja_ = "-";
				}
				if ($shift_pekerja_ != "-") {
					if (isset($aggr[$shift_pekerja_])) {
						if (isset($aggr[$shift_pekerja_][str_replace("-", "", $data_tanggal_value['tanggal'])])) {
							$aggr[$shift_pekerja_][str_replace("-", "", $data_tanggal_value['tanggal'])] += 1;
						}else{
							$aggr[$shift_pekerja_][str_replace("-", "", $data_tanggal_value['tanggal'])] = 1;
						}
					}else{
						$aggr[$shift_pekerja_] = array();
						$aggr[$shift_pekerja_][str_replace("-", "", $data_tanggal_value['tanggal'])] = 1;
					}
				}else{
					if (isset($aggr['libur'])) {
						if (isset($aggr['libur'][str_replace("-", "", $data_tanggal_value['tanggal'])])) {
							$aggr['libur'][str_replace("-", "", $data_tanggal_value['tanggal'])] += 1;
						}else{
							$aggr['libur'][str_replace("-", "", $data_tanggal_value['tanggal'])] = 1;
						}
					}else{
						$aggr['libur'] = array();
						$aggr['libur'][str_replace("-", "", $data_tanggal_value['tanggal'])] = 1;
					}
				}

				$shift[$shift_key]['data'][str_replace("-", "", $data_tanggal_value['tanggal'])] = $shift_pekerja_;
			}
			
		}

		$data['aggr'] = $aggr;
		// echo "<pre>";print_r($data['aggr']);exit();

		$user_id = $this->session->userid;
		$data['Title'] = 'Tarik Data Shift Pekerja';
		$data['Menu'] = 'Shift Pekerja';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['table'] = $shift;
		$data['export'] = $kdsie.'_'.$exhub.'_'.$periode.'_'.$exlok;
		 

		$data['dept'] 	= $this->M_rekapabsensi->ambilDepartemen('');
		$data['bidang'] = $this->M_rekapabsensi->ambilBidang($dept,'');
		$data['unit'] 	= $this->M_rekapabsensi->ambilUnit($bid,'');
		$data['seksi']	= $this->M_rekapabsensi->ambilSeksi($unit,'');

		$data['kdept'] 		= $dept;
		$data['kbidang'] 	= $bid;
		$data['kunit'] 		= $unit;
		$data['kseksi'] 	= $seksi;

		// echo "<pre>";print_r($dataa);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/TarikShiftPekerja/V_tarikshiftpekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportExcel($data){
		
		$data = str_replace("%20", " ", $data);
		$do = explode("_", $data);
		$export = $do['0'];
		$kdsie = $do['1'];
		$hubker = explode("-", $do['2']);
		$hub = "";
		//insert to sys.log_activity
		$aksi = 'MasterPresensi';
		$detail = "Export PDF Data Shift Pekerja kodesie = $kdsie";
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
		$lokasi = explode("-", $do['4']);
		$lok = "";

		foreach ($lokasi as $key) {
			if ($lok == "") {
				$lok = "'".$key."'";
			}else{
				$lok .= ",'".$key."'";
			}
		}

		if ($kdsie !== '0') {
			$shift = $this->M_tarikshiftpekerja->getData($prd[0],$prd[1],$hub,$kdsie,$lok);
		}else{
			$shift = $this->M_tarikshiftpekerja->getData($prd[0],$prd[1],$hub,$lok);
		}

		$tgl1 = $prd[0];
		$tgl2 = $prd[1];
		$periodeM = $tgl1." - ".$tgl2;

		$data_tanggal = $this->M_tarikshiftpekerja->getTanggalByParams($tgl1,$tgl2);

		//header awal
		$header_bulan = '<th rowspan="2" style="text-align: center;vertical-align: middle;">No. Induk</th>
						<th rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>
						<th rowspan="2" style="text-align: center;vertical-align: middle;">Seksi</th>';
		$header_tanggal = "";
		$simpan_bulan_tahun = "";
		$simpan_bulan = "";
		$simpan_tahun = "";
		$hitung_colspan = 1;
		$tanggal_pertama = "";
		$tanggal_terakhir = "";
		$bulan = array (
			1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
		);
		foreach ($data_tanggal as $dt_bulan) {
			$header_tanggal .= "<th style='text-align: center'>".$dt_bulan['hari']."</th>";
			if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
				$hitung_colspan++;
			}else{
				if ($simpan_bulan !== "") {
					$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
					$hitung_colspan = 1;
				}else{
					$tanggal_pertama = $dt_bulan['tanggal'];
				}
			}
			$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
			$simpan_bulan = $dt_bulan['bulan'];
			$simpan_tahun = $dt_bulan['tahun'];
		}
		$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
		$tanggal_terakhir = $dt_bulan['tanggal'];
		
		$dataa['header'] = "<tr>$header_bulan</tr><tr>$header_tanggal</tr>";

		foreach ($shift as $shift_key => $shift_value) {
			$shift[$shift_key]['data'] = array();
			foreach ($data_tanggal as $data_tanggal_key => $data_tanggal_value ) { 
				$shift_pekerja = $this->M_tarikshiftpekerja->getDataDetail($shift_value['noind'],$data_tanggal_value['tanggal']);
				if (!empty($shift_pekerja)) {
					$shift_pekerja_ = $shift_pekerja[0]['inisial'];
				}else{
					$shift_pekerja_ = "-";
				}
				$shift[$shift_key]['data'][str_replace("-", "", $data_tanggal_value['tanggal'])] = $shift_pekerja_;
			}
			
		}

		$this->load->library('excel');
		
		$worksheet = $this->excel->getActiveSheet();
        $worksheet->setCellValue('A1','Shift Pekerja Periode '.date('d F Y',strtotime($tgl1))." - ".date('d F Y',strtotime($tgl2))." dicetak melalui QuickERP - (MasterPresensi)".  date('d-m-Y H:i:s') . " oleh ". $this->session->user ." - ". $this->session->employee);
		$worksheet->setCellValue('A3','No');
		$worksheet->setCellValue('B3','Noind');
		$worksheet->setCellValue('C3','Nama');
		$worksheet->setCellValue('D3','Seksi');
		$worksheet->setCellValue('E3','Jabatan');
		$worksheet->setCellValue('F3','Tempat Makan');
		$worksheet->setCellValue('G3','Lokasi Kerja');

        // merge cell
		$worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A3:A4');
        $worksheet->mergeCells('B3:B4');
        $worksheet->mergeCells('C3:C4');	
        $worksheet->mergeCells('D3:D4');
        $worksheet->mergeCells('E3:E4');
        $worksheet->mergeCells('F3:F4');
        $worksheet->mergeCells('G3:G4');
		
        $d=7;
        $e=4;
        $simpan_bulan_tahun = "";
        foreach ($data_tanggal as $dt_tanggal) {
			if ($simpan_bulan_tahun != $dt_tanggal['bulan'].$dt_tanggal['tahun']) {
				$kolom_akhir = $d -1;	
				if ($simpan_bulan_tahun != "") {
					$kolom_1 = PHPExcel_Cell::stringFromColumnIndex($kolom_awal);
					$kolom_2 = PHPExcel_Cell::stringFromColumnIndex($kolom_akhir);
					$worksheet->mergeCells($kolom_1.($e-1).':'.$kolom_2.($e-1));
				}
				$worksheet->setCellValueByColumnAndRow($d,($e-1),$bulan[$dt_tanggal['bulan']]." ".$dt_tanggal['tahun']);
				$kolom_awal = $d;
			}
			$worksheet->setCellValueByColumnAndRow($d,$e,$dt_tanggal['hari']);	

			
            $d++;
			$simpan_bulan_tahun = $dt_tanggal['bulan'].$dt_tanggal['tahun'];
			$simpan_bulan = $dt_tanggal['bulan'];
			$simpan_tahun = $dt_tanggal['tahun'];						
		}

		$kolom_akhir = $d -1;	
		if ($simpan_bulan_tahun != "") {
			$kolom_1 = PHPExcel_Cell::stringFromColumnIndex($kolom_awal);
			$kolom_2 = PHPExcel_Cell::stringFromColumnIndex($kolom_akhir);
			$worksheet->mergeCells($kolom_1.($e-1).':'.$kolom_2.($e-1));
		}
		
        $angka = 1;
		$row = 5;
		$a=7;
        $b=5;

		foreach ($shift as $key ) {
			$worksheet->setCellValue('A'.$row,$angka);
			$worksheet->setCellValue('B'.$row,$key['noind']);
			$worksheet->setCellValue('C'.$row,$key['nama']);
			$worksheet->setCellValue('D'.$row,$key['seksi']);
			$worksheet->setCellValue('E'.$row,$key['jabatan']);
			$worksheet->setCellValue('F'.$row,$key['tempat_makan']);
			$worksheet->setCellValue('G'.$row,$key['lokasi_kerja']);

			foreach ($data_tanggal as $dt_tanggal) {
				$worksheet->setCellValueByColumnAndRow($a,$b,$key['data'][str_replace("-", "", $dt_tanggal['tanggal'])]);	
                $a++;				
			}
					
			$a=7;
            $b++;
			$row++;
			$angka++;
		}

        $worksheet->getColumnDimension('A')->setWidth('5');
		$worksheet->getColumnDimension('B')->setWidth('10');
		$worksheet->getColumnDimension('C')->setWidth('30');
		$worksheet->getColumnDimension('D')->setWidth('50');
		$worksheet->getColumnDimension('E')->setWidth('50');
		$worksheet->getColumnDimension('F')->setWidth('30');

		$d_index = PHPExcel_Cell::stringFromColumnIndex($d - 1);
		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap' => true
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
			),
			'A3:'.$d_index.'4'
		);
		$worksheet->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_HAIR)
				)
			),
			'A5:'.$d_index.($b - 1)
		);
		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),
			'A5:B'.($b - 1)
		);
		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),
			'H5:'.$d_index.($b - 1)
		);

		$worksheet->freezePane("D5");

		$filename ='Tarik_Shift_Pekerja'.$kdsie.'.xls';
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
		$aksi = 'MasterPresensi';
		$detail = "Export PDF Data Shift Pekerja kodesie = $kdsie";
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
		$lokasi = explode("-", $do['4']);
		$lok = "";

		foreach ($lokasi as $key) {
			if ($lok == "") {
				$lok = "'".$key."'";
			}else{
				$lok .= ",'".$key."'";
			}
		}

		if ($kdsie !== '0') {
			$shift = $this->M_tarikshiftpekerja->getData($prd[0],$prd[1],$hub,$kdsie,$lok);
		}else{
			$shift = $this->M_tarikshiftpekerja->getData($prd[0],$prd[1],$hub,$lok);
		}
        	

		$tgl1 = $prd[0];
		$tgl2 = $prd[1];

		$periodeM = $tgl1." - ".$tgl2;

		$data_tanggal = $this->M_tarikshiftpekerja->getTanggalByParams($tgl1,$tgl2);

		//header awal
		$header_bulan = '<th rowspan="2" style="text-align: center;vertical-align: middle;">No. Induk</th>
						<th rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>
						<th rowspan="2" style="text-align: center;vertical-align: middle;">Seksi</th>';
		$header_tanggal = "";
		$simpan_bulan_tahun = "";
		$simpan_bulan = "";
		$simpan_tahun = "";
		$hitung_colspan = 1;
		$tanggal_pertama = "";
		$tanggal_terakhir = "";
		$bulan = array (
						1 =>   'Januari',
							'Februari',
							'Maret',
							'April',
							'Mei',
							'Juni',
							'Juli',
							'Agustus',
							'September',
							'Oktober',
							'November',
							'Desember'
						);
		foreach ($data_tanggal as $dt_bulan) {
			$header_tanggal .= "<th style='text-align: center'>".$dt_bulan['hari']."</th>";
			if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
				$hitung_colspan++;
			}else{
				if ($simpan_bulan !== "") {
					$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
					$hitung_colspan = 1;
				}else{
					$tanggal_pertama = $dt_bulan['tanggal'];
				}
			}
			$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
			$simpan_bulan = $dt_bulan['bulan'];
			$simpan_tahun = $dt_bulan['tahun'];
		}
		$header_bulan .= "<th colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
		$tanggal_terakhir = $dt_bulan['tanggal'];
		
		$dataa['header'] = "<tr>$header_bulan</tr><tr>$header_tanggal</tr>";

		foreach ($shift as $shift_key => $shift_value) {
			$shift[$shift_key]['data'] = array();
			foreach ($data_tanggal as $data_tanggal_key => $data_tanggal_value ) { 

				$shift_pekerja = $this->M_tarikshiftpekerja->getDataDetail($shift_value['noind'],$data_tanggal_value['tanggal']);
				if (!empty($shift_pekerja)) {
					$shift_pekerja_ = $shift_pekerja[0]['inisial'];
				}else{
					$shift_pekerja_ = "-";
				}
				$shift[$shift_key]['data'][str_replace("-", "", $data_tanggal_value['tanggal'])] = $shift_pekerja_;
			}
			
		}

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('UTF-8', 'A4-L', '8', 'Arial', 5, 5, 5, 5, 0, 0);
		$filename = 'Data_Shift_Pekerja'.$kdsie.'.pdf';
		
		$dataa['table'] = $shift;
		$dataa['tanggal'] = $this->M_tarikshiftpekerja->getTanggalByParams($tgl1,$tgl2);
		     
		
		// echo "<pre>";print_r($dataa)  ;exit();
		$html = $this->load->view('MasterPresensi/TarikShiftPekerja/V_cetak', $dataa, true);
        $pdf->defaultfooterline = false;
        $pdf->setFooter("
        <div style='text-align: left; font-weight: 100;'>
        <small style='font-size: 10px; float: left; font-style: italic;'>Halaman ini dicetak melalui QuickERP - (MasterPresensi) - ". date('d-m-Y H:i:s') . " oleh {$this->session->user} - {$this->session->employee}</small>
        </div>
        ");
				

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}
}
 ?>
