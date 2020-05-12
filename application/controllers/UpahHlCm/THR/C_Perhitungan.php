<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_Perhitungan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_thr');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Perhitungan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_thr->getTHRAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_indexperhitungan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Perhitungan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_prosesperhitungan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function hitung(){
		$tgl_proses = date('Y-m-d H:i:s');

		$this->load->library('upload');
		$this->load->library('excel');
		
		$noind = $this->session->user;
		$user_id = $this->session->userid;
		$user = $this->session->user;

		if (!empty($_FILES['flHLCMBulanTHR']['name'])) {
			$direktori						= $_FILES['flHLCMBulanTHR']['name'];
			$ekstensi						= pathinfo($direktori,PATHINFO_EXTENSION);
			$xls							= "HLCM-THRBulan-".$noind."-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensi;
			$config['upload_path']          = './assets/upload/THRHLCM';
			$config['allowed_types']        = 'xls';
        	$config['file_name']		 	= $xls;
        	$config['overwrite'] 			= TRUE;
        	$this->upload->initialize($config);
    		if ($this->upload->do_upload('flHLCMBulanTHR'))
    		{
        		$this->upload->data();
    		}
    		else
    		{
    			$errorinfo = $this->upload->display_errors();
    			echo $errorinfo;
    		}
    	}else{
    		redirect(base_url('HitungHlcm/THR/Perhitungan/proses'));
    	}

		$tanggal 	= $this->input->post('txtHLCMIdulFitri');
		$awal 		= $this->input->post('txtHLCMPeriodeAwalTHR');
		$akhir 		= $this->input->post('txtHLCMPeriodeAkhirTHR');

		$objPHPExcel = PHPExcel_IOFactory::load("./assets/upload/THRHLCM/".$xls);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$rowData = $sheet->rangeToArray('A2:'.$highestColumn.$highestRow,null,true,false);
		
		$tampung = array();
		if (!empty($rowData)) {

			$index = 0;

			foreach ($rowData as $dt) {
				$noind 	= $dt[1];
				$nama 	= $dt[2];
				$lokasi	= $dt[3];
				$masuk 	= $dt[4];
				$masa 	= $dt[5];
				$bulan 	= $dt[6];

				$tampung[$index] = array(
					'noind'	=> $noind,
					'nama'	=> $nama,
					'lokasi'=> $lokasi,
					'masuk'	=> $masuk,
					'masa'	=> $masa,
					'bulan' => $bulan
				);
				
				if (intval($bulan) == 12) {
					$rata = $this->M_thr->getAverageGPByNoindAwalAkhir($noind,trim($awal),trim($akhir));
					if(!empty($rata)) {
						$thr = $rata[0]['rata'];
					}else{
						$thr = 0;
					}
				}else{
					$rata = $this->M_thr->getAverageGPByNoindAwalAkhir($noind,trim($awal),trim($akhir));
					if(!empty($rata)) {
						$thr = (intval($bulan)/12) * $rata[0]['rata'];
					}else{
						$thr = 0;
					}
				}
				$tampung[$index]['thr'] = $thr;

				$cek_thr = $this->M_thr->getTHRByIdulFitriNoind($tanggal,$tampung[$index]['noind']);
				if(count($cek_thr) > 0){

					$data_thr = array(
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'periode_awal'		=> $awal,
						'periode_akhir'		=> $akhir,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa'],
						'nominal_thr' 		=> $tampung[$index]['thr'],
						'proses_by' 		=> $user
					);

					$this->M_thr->updateTHRByID($cek_thr['0']['id_thr'],$data_thr);

					$data_thr_history = array(
						'id_thr'			=> $cek_thr['0']['id_thr'],
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'periode_awal'		=> $awal,
						'periode_akhir'		=> $akhir,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa'],
						'nominal_thr' 		=> $tampung[$index]['thr'],
						'proses_by' 		=> $user,
						'tgl_input'			=> $cek_thr['0']['tgl_proses'],
						'input_by'			=> $cek_thr['0']['proses_by']
					);

					$this->M_thr->insertTHRHistory($data_thr_history);

				}else{

					$data_thr = array(
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'periode_awal'		=> $awal,
						'periode_akhir'		=> $akhir,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa'],
						'nominal_thr' 		=> $tampung[$index]['thr'],
						'proses_by' 		=> $user
					);

					$id_thr = $this->M_thr->insertTHR($data_thr);

					$data_thr_history = array(
						'id_thr'			=> $id_thr,
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'periode_awal'		=> $awal,
						'periode_akhir'		=> $akhir,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa'],
						'nominal_thr' 		=> $tampung[$index]['thr'],
						'proses_by' 		=> $user,
						'tgl_input'			=> $tgl_proses,
						'input_by'			=> $user
					);

					$this->M_thr->insertTHRHistory($data_thr_history);

				}

				$index++;
			}
		}

		$data['Title']			=	'Perhitungan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $tampung;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_prosesperhitungan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cetak(){
		$tanggal 	= $this->input->post('txtTanggalIdulFitri');
		$lokasi 	= $this->input->post('txtLokasiKerja');
		$mengetahui = $this->input->post('txtMengetahui');
		$dibuat 		= $this->session->user;
		$data['waktu_dibuat'] = $this->input->post('txtTanggalCetak');
		$data['tanggal'] = $tanggal;

		$data['mengetahui'] = $this->M_thr->getPekerjaJabatanByNoind($mengetahui);
		$data['dibuat'] = $this->M_thr->getPekerjaJabatanByNoind($dibuat);
		if (!empty($lokasi) && $lokasi !== 'all') {
			$data['data'] = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data['data'] = $this->M_thr->getTHRByTanggal($tanggal);
		}

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4-L', 8, '', 10, 10, 20, 20, 10, 5);
		$filename = "Perhitungan THR HLCM Idul Fitri ".$tanggal.".pdf";
		$html = $this->load->view('UpahHlCm/THR/V_cetakperhitungan', $data, true);
		// print_r($data['data']);exit();
		// $this->load->view('UpahHlCm/THR/V_cetakperhitunganbulan', $data);exit();

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM oleh ".$this->session->user."-".$this->session->employee." pada tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i> ");
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function delete(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');
		$noind 		= $this->input->get('noind');

		if (!empty($lokasi)) {
			$data['data'] = $this->M_thr->deleteTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			if (!empty($noind)) {
				$data['data'] = $this->M_thr->deleteTHRByTanggalNoind($tanggal,$noind);
			}else{
				$data['data'] = $this->M_thr->deleteTHRByTanggal($tanggal);
			}
		}

		redirect(base_url('HitungHlcm/THR/Perhitungan'));
	}

	public function read(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');

		$data['Title']			=	'Perhitungan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if (!empty($lokasi)) {
			$data['data'] = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data['data'] = $this->M_thr->getTHRByTanggal($tanggal);
		}
		
		$data['tanggal'] = $tanggal;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_readperhitungan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function export(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');

		if (!empty($lokasi)) {
			$data = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data = $this->M_thr->getTHRByTanggal($tanggal);
		}

		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();
		$worksheet->setCellValue('A1','NO');
		$worksheet->setCellValue('B1','NO INDUK');
		$worksheet->setCellValue('C1','NAMA');
		$worksheet->setCellValue('D1','LOKASI KERJA');
		$worksheet->setCellValue('E1','MASUK KERJA');
		$worksheet->setCellValue('F1','MASA KERJA');
		$worksheet->setCellValue('G1','NO REKENING');
		$worksheet->setCellValue('H1','PEMILIK REKENING');
		$worksheet->setCellValue('H1','BANK');
		$worksheet->setCellValue('I1','NOMINAL THR');

		$total = 0;
		$nomor = 1;
		if (!empty($data)) {
			foreach ($data as $dt) {
				$worksheet->setCellValue('A'.($nomor+1),$nomor);
				$worksheet->setCellValue('B'.($nomor+1),$dt['noind']);
				$worksheet->setCellValue('C'.($nomor+1),$dt['employee_name']);
				$worksheet->setCellValue('D'.($nomor+1),$dt['location_name']);
				$worksheet->setCellValue('E'.($nomor+1),$dt['tgl_masuk']);
				$worksheet->setCellValue('F'.($nomor+1),$dt['masa_kerja']);
				$worksheet->setCellValue('G'.($nomor+1),$dt['no_rekening']);
				$worksheet->setCellValue('H'.($nomor+1),$dt['atas_nama']);
				$worksheet->setCellValue('H'.($nomor+1),$dt['nama_bank']);
				$worksheet->setCellValue('I'.($nomor+1),number_format($dt['nominal_thr'],2,',','.'));
				$total += round($dt['nominal_thr'],2);
				$nomor++;
			}
		}
		$nomor++;

		$worksheet->setCellValue('H'.($nomor),"Total");
		$worksheet->setCellValue('I'.($nomor),number_format($total,2,',','.'));


		$worksheet->getColumnDimension('A')->setWidth('5');
		$worksheet->getColumnDimension('B')->setWidth('10');
		$worksheet->getColumnDimension('C')->setWidth('20');
		$worksheet->getColumnDimension('D')->setWidth('20');
		$worksheet->getColumnDimension('E')->setWidth('20');
		$worksheet->getColumnDimension('F')->setWidth('30');
		$worksheet->getColumnDimension('G')->setWidth('30');
		$worksheet->getColumnDimension('H')->setWidth('30');
		$worksheet->getColumnDimension('I')->setWidth('20');



		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				),
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'argb' => '00C0C0C0')
				),
				'font' => array(
					'bold' => true
				)
			),'A1:I1');

		$worksheet->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'A1:I'.($nomor));
		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'I2:I'.($nomor));

		$worksheet->setCellValue('C'.($nomor + 2),"Mengetahui,");
		$worksheet->setCellValue('F'.($nomor + 2),"Menyetujui,");
		$worksheet->setCellValue('I'.($nomor + 2),"Dibuat Oleh,");

		$nomor += 4;
		$worksheet->setCellValue('C'.($nomor + 2),"Novita Sari");
		$worksheet->setCellValue('F'.($nomor + 2),"Yoga Andriawan");
		$worksheet->setCellValue('I'.($nomor + 2),"Subardi");
		$worksheet->setCellValue('C'.($nomor + 3),"Asisten Kepala Unit Akuntansi");
		$worksheet->setCellValue('F'.($nomor + 3),"Kepala Seksi Madya");
		$worksheet->setCellValue('I'.($nomor + 3),"Pekerja Staff Keuangan");

		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
			),'A'.($nomor - 2).':I'.($nomor + 3));

		$filename = "Perhitungan Nominal THR HLCM Idul Fitri ".$tanggal.".xls";
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	public function cariPekerja(){
		$key = $this->input->get('term');
		$data = $this->M_thr->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function slip(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');
		if (!empty($lokasi) && $lokasi !== 'all') {
			$data['data'] = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data['data'] = $this->M_thr->getTHRByTanggal($tanggal);
		}

		$data['tanggal'] = $tanggal;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8' , array(215,140),8,'', 7, 7, 0, 0, 0,0);
		$filename = "Slip THR HLCM Idul Fitri ".$tanggal.".pdf";
		// echo "<pre>";print_r($data['data']);exit();
		// $this->load->view('UpahHlCm/THR/V_slipperhitungan', $data);
		$html = $this->load->view('UpahHlCm/THR/V_slipperhitungan', $data, true);
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function serahTerima(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');
		
		if (!empty($lokasi) && $lokasi !== 'all') {
			$data['data'] = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data['data'] = $this->M_thr->getTHRByTanggal($tanggal);
		}

		$data['pj']  = $this->M_thr->getApproval("Tanda Terima");
		$data['tanggal'] = $tanggal;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'F4', 8, '', 5, 5, 5, 15, 10, 20);
		$filename = "Serah Terima THR HLCM Idul Fitri ".$tanggal.".pdf";
		// echo "<pre>";print_r($data['pj']);exit();
		// $this->load->view('UpahHlCm/THR/V_serahterimaperhitungan', $data);

		$html = $this->load->view('UpahHlCm/THR/V_serahterimaperhitungan', $data, true);
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM oleh ".$this->session->user."-".$this->session->employee." pada tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i> ");
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function memo(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');
		
		if (!empty($lokasi)) {
			$data = $this->M_thr->getTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data = $this->M_thr->getTHRByTanggal($tanggal);
		}

		// echo "<pre>";print_r($data);exit();

		$total_t_ktukang 	= 0;
		$total_t_tukang 	= 0;
		$total_t_serabutan 	= 0;
		$total_t_tenaga 	= 0;
		$total_p_ktukang 	= 0;
		$total_p_tukang 	= 0;
		$total_p_serabutan 	= 0;
		$total_p_tenaga 	= 0;
		$total_tuksono 		= 0;
		$total_pusat 		= 0;
		$totalsemua 		= 0;

		if (!empty($data)) {
			foreach ($data as $dt) {
				if ($dt['location_name'] == "YOGYAKARTA (PUSAT)") {
					if ($dt['pekerjaan'] == "KEPALA TUKANG") {
						$total_p_ktukang += round($dt['nominal_thr'],2);
					}elseif ($dt['pekerjaan'] == "TUKANG") {
						$total_p_tukang += round($dt['nominal_thr'],2);
					}elseif ($dt['pekerjaan'] == "TENAGA") {
						$total_p_tenaga += round($dt['nominal_thr'],2);
					}elseif ($dt['pekerjaan'] == "SERABUTAN") {
						$total_p_serabutan += round($dt['nominal_thr'],2);
					}
				}elseif ($dt['location_name'] == "TUKSONO") {
					if ($dt['pekerjaan'] == "KEPALA TUKANG") {
						$total_t_ktukang += round($dt['nominal_thr'],2);
					}elseif ($dt['pekerjaan'] == "TUKANG") {
						$total_t_tukang += round($dt['nominal_thr'],2);
					}elseif ($dt['pekerjaan'] == "TENAGA") {
						$total_t_tenaga += round($dt['nominal_thr'],2);
					}elseif ($dt['pekerjaan'] == "SERABUTAN") {
						$total_t_serabutan += round($dt['nominal_thr'],2);
					}
				}
			}

			$total_pusat = $total_p_ktukang + $total_p_tukang + $total_p_tenaga + $total_p_serabutan;
			$total_tuksono = $total_t_ktukang + $total_t_tukang + $total_t_tenaga + $total_t_serabutan;

			$totalsemua = $total_pusat + $total_tuksono;
		}

		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();

		$worksheet->setCellValue('B1','MEMO');
		$worksheet->setCellValue('B2','PAYROLL NON STAFF');
		$worksheet->setCellValue('B3','CV. KARYA HIDUP SENTOSA');
		$worksheet->setCellValue('B4','JL. MAGELANG NO. 144 YOGYAKARTA');
		$worksheet->mergeCells('B1:F1');
		$worksheet->mergeCells('B2:F2');
		$worksheet->mergeCells('B3:F3');
		$worksheet->mergeCells('B4:F4');

		$worksheet->setCellValue('A6','No');
		$worksheet->setCellValue('A7','Hal');
		$worksheet->setCellValue('B6',':');//no. memo
		$worksheet->setCellValue('B7',': Transfer THR Pekerja Harian Lepas idul fitri '.strftime('%d %B %Y', strtotime($tanggal)));
		$worksheet->mergeCells('B6:G6');
		$worksheet->mergeCells('B7:G7');

		$worksheet->setCellValue('A9','Kepada Yth:');
		$worksheet->setCellValue('A10','');//tujuan
		$worksheet->setCellValue('A11','Ditempat');
		$worksheet->mergeCells('A9:G9');
		$worksheet->mergeCells('A10:G10');
		$worksheet->mergeCells('A11:G11');

		$worksheet->setCellValue('A13','Dengan hormat,');
		$worksheet->mergeCells('A13:G13');
		
		$worksheet->setCellValue('A14','Dengan ini mohon agar dilakukan transfer uang untuk pembayaran THR pekerja harian lepas KHS Pusat dan Tuksono , idul fitri '.strftime('%d %B %Y', strtotime($tanggal)));
		$worksheet->mergeCells('A14:G14');

		$worksheet->setCellValue('B15','KEPALA TUKANG');
		$worksheet->setCellValue('B16','TUKANG');
		$worksheet->setCellValue('B17','SERABUTAN');
		$worksheet->setCellValue('B18','TENAGA');

		$worksheet->setCellValue('C15',"Rp ".number_format($total_t_ktukang,2,',','.'));
		$worksheet->setCellValue('C16',"Rp ".number_format($total_t_tukang,2,',','.'));
		$worksheet->setCellValue('C17',"Rp ".number_format($total_t_serabutan,2,',','.'));
		$worksheet->setCellValue('C18',"Rp ".number_format($total_t_tenaga,2,',','.'));

		$worksheet->setCellValue('E15','KEPALA TUKANG');
		$worksheet->setCellValue('E16','TUKANG');
		$worksheet->setCellValue('E17','SERABUTAN');
		$worksheet->setCellValue('E18','TENAGA');

		$worksheet->setCellValue('F15',"Rp ".number_format($total_p_ktukang,2,',','.'));
		$worksheet->setCellValue('F16',"Rp ".number_format($total_p_tukang,2,',','.'));
		$worksheet->setCellValue('F17',"Rp ".number_format($total_p_serabutan,2,',','.'));
		$worksheet->setCellValue('F18',"Rp ".number_format($total_p_tenaga,2,',','.'));

		$worksheet->setCellValue('B20','TOTAL TUKSONO');

		$worksheet->setCellValue('C20',"Rp ".number_format($total_tuksono,2,',','.'));

		$worksheet->setCellValue('E20','TOTAL KHS PUSAT');

		$worksheet->setCellValue('F20',"Rp ".number_format($total_pusat,2,',','.'));

		$worksheet->setCellValue('B22','TOTAL SEMUA');

		$worksheet->setCellValue('C22',"Rp ".number_format($totalsemua,2,',','.'));

		$worksheet->setCellValue('A24','Demikian memo ini kami sampaikan. Atas perhatian dan kerja samanya kami sampaikan banyak terimakasih.');
		$worksheet->mergeCells('A24:G24');
		$tgl = date('d');
			$month=date('m');
			if ($month=='01') {
				$tgl .= " Januari ";
			}elseif ($month=='02') {
				$tgl .= " Februari ";
			}elseif ($month=='03') {
				$tgl .= " Maret ";
			}elseif ($month=='04') {
				$tgl .= " April ";
			}elseif ($month=='05') {
				$tgl .= " Mei ";
			}elseif ($month=='06') {
				$tgl .= " Juni ";
			}elseif ($month=='07') {
				$tgl .= " Juli ";
			}elseif ($month=='08') {
				$tgl .= " Agustus ";
			}elseif ($month=='09') {
				$tgl .= " September ";
			}elseif ($month=='10') {
				$tgl .= " Oktober ";
			}elseif ($month=='11') {
				$tgl .= " November ";
			}elseif ($month=='12') {
				$tgl .= " Desember ";
			};
			$tgl .= date('Y');
		$worksheet->setCellValue('E26','Yogyakarta, '.$tgl);
		$worksheet->mergeCells('E26:F26');

		$worksheet->setCellValue('C34','Mengetahui');
		$worksheet->setCellValue('E27','Dibuat Oleh');
		$worksheet->setCellValue('B27','Menyetujui');
		$worksheet->mergeCells('B27:C27');
		$worksheet->mergeCells('E27:F27');
		$worksheet->mergeCells('C34:E34');

		
		$worksheet->setCellValue('C38',"Novita Sari");
		$worksheet->setCellValue('C39',"Asisten Kepala Unit Akuntansi");
		
		$worksheet->mergeCells('B31:C31');
		$worksheet->mergeCells('B32:C32');
		$worksheet->getStyle('B31')->getFont()->setUnderline(true);

		
		$worksheet->setCellValue('B31',"Yoga Andriawan");
		$worksheet->setCellValue('B32',"Kepala Seksi Madya");
		
		$worksheet->mergeCells('E31:F31');
		$worksheet->mergeCells('E32:F32');
		$worksheet->getStyle('E31')->getFont()->setUnderline(true);

		$worksheet->setCellValue('E31',"Subardi");
		$worksheet->setCellValue('E32',"Pekerja Staff Keuangan");
		
		$worksheet->mergeCells('C38:E38');
		$worksheet->mergeCells('C39:E39');
		$worksheet->getStyle('C38')->getFont()->setUnderline(true);

		$imagestr = new PHPExcel_Worksheet_Drawing();
		$imagestr->setName('logo');
		$imagestr->setDescription('logo');
		$imagestr->setPath('./assets/img/logo.png');
		$imagestr->setCoordinates('A1');
		$imagestr->setResizeProportional(false);
		$imagestr->setWidth(80);
		$imagestr->setHeight(85);
		$imagestr->setWorksheet($this->excel->getActiveSheet());


		$worksheet->getRowDimension(14)->setRowHeight(40);
		$worksheet->getRowDimension(24)->setRowHeight(40);

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'alignment' => array(
				'wrap' => true,
				'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'font' => array(
				'bold' =>true,
				'size' => 16
			)
		),'B1:B4');

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'font' => array(
				'bold' =>true
			)
		),'A10:A11');

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'alignment' => array(
				'wrap' => true,
				'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			)
		),'B26:E39');
		
		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'alignment' => array(
				'wrap' => true,
				'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
			)
		),'A14:A24');

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		),'B15:C18');

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK)
			)
		),'A4:G4');

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		),'B20:C20');

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		),'B22:C22');

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		),'E15:F18');

		$this->excel->getActiveSheet()->duplicateStyleArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		),'E20:F20');

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('3');
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('18');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('2');
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('18');
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('3');
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_WorkSheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);

		$filename ='Memo-THR-HLCM-'.$tgl.'.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

}

?>