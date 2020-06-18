<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
date_default_timezone_set('Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PerhitunganBulan extends CI_Controller
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

		$data['Title']			=	'Perhitungan Bulan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan Bulan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_thr->getBulanTHRAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_indexperhitunganbulan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Perhitungan Bulan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan Bulan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_prosesperhitunganbulan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function hitung(){
		$tgl_proses = date('Y-m-d H:i:s');
		$user = $this->session->user;

		$lokasi 	= $this->input->post('lokasi');
		$tanggal 	= $this->input->post('tanggal');
		$awal 		= $this->input->post('awal');
		$akhir 		= $this->input->post('akhir');

		if(!empty($lokasi)){
			$data = $this->M_thr->getPekerjaByLokasi($lokasi);
		}else{
			$data = $this->M_thr->getPekerja($tanggal);
		}

		$tampung = array();
		if (!empty($data)) {
			$bulan_spesial = array(5,7,10,12);

			$index = 0;

			foreach ($data as $dt) {
				$tampung[$index] = $dt;

				$hari 	= 0;
				$bulan 	= 0;
				$bulan1 = 0;
				$tahun 	= 0;
				$tahun1 = 0;

				$bulan_thr = 0;

				$day_a 		= intval(date('d',strtotime($dt['masuk'])));
				$month_a 	= intval(date('m',strtotime($dt['masuk'])));
				$year_a 	= intval(date('Y',strtotime($dt['masuk'])));
				$day_b 		= intval(date('d',strtotime($tanggal)));
				$month_b 	= intval(date('m',strtotime($tanggal)));
				$year_b 	= intval(date('Y',strtotime($tanggal)));

				if (($day_b - $day_a) < 0) {
					if ($month_b == 3) {
						if (($bulan_b%4) == 0) {
							$hari = $day_b + 29 - $day_a;
						}else{
							$hari = $day_b + 28 - $day_a;
						}
					}else{
						if (in_array($month_b, $bulan_spesial)) {
							$hari = $day_b + 30 - $day_a;
						}else{
							$hari = $day_b + 31 - $day_a;
						}
					}
					$bulan1 = $month_b - 1;
				}else{
					$hari 	= $day_b - $day_a;
					$bulan1 = $month_b;
				}

				if (($bulan1 - $month_a) < 0) {
					$bulan = $bulan1 + 12 - $month_a;
					$tahun1 = $year_b - 1;
				}else{
					$bulan = $bulan1 - $month_a;
					$tahun1 = $year_b;
				}

				if ($tahun1 - $year_a < 0) {
					$tahun = 0;
				}else{
					$tahun = $tahun1 - $year_a;
				}

				$tampung[$index]['masa_kerja'] = $tahun." Tahun ".$bulan." Bulan ".$hari." hari";

				if ($tahun >= 1) {
					$bulan_thr = 12;
				}elseif ($bulan >= 1) {
					$bulan_thr = $bulan;
				}else{
					$bulan_thr = 0;
				}

				$tampung[$index]['bulan_thr'] = $bulan_thr;

				// echo "<pre>";print_r($tampung);exit();

				$cek_thr_bulan = $this->M_thr->getBulanTHRByIdulFitriNoind($tanggal,$tampung[$index]['noind']);
				if(count($cek_thr_bulan) > 0){

					$data_thr_bulan = array(
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa_kerja'],
						'bulan_thr' 		=> $tampung[$index]['bulan_thr'],
						'proses_by' 		=> $user
					);

					$this->M_thr->updateBulanTHRByID($cek_thr_bulan['0']['id_bulan_thr'],$data_thr_bulan);

					$data_thr_bulan_history = array(
						'id_bulan_thr'		=> $cek_thr_bulan['0']['id_bulan_thr'],
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa_kerja'],
						'bulan_thr' 		=> $tampung[$index]['bulan_thr'],
						'proses_by' 		=> $user,
						'tgl_input'			=> $cek_thr_bulan['0']['tgl_proses'],
						'input_by'			=> $cek_thr_bulan['0']['proses_by']
					);

					$this->M_thr->insertBulanTHRHistory($data_thr_bulan_history);

				}else{

					$data_thr_bulan = array(
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa_kerja'],
						'bulan_thr' 		=> $tampung[$index]['bulan_thr'],
						'proses_by' 		=> $user
					);

					$id_bulan_thr = $this->M_thr->insertBulanTHR($data_thr_bulan);

					$data_thr_bulan_history = array(
						'id_bulan_thr'		=> $id_bulan_thr,
						'tgl_proses' 		=> $tgl_proses,
						'tgl_idul_fitri' 	=> $tanggal,
						'noind' 			=> $tampung[$index]['noind'],
						'tgl_masuk' 		=> $tampung[$index]['masuk'],
						'masa_kerja' 		=> $tampung[$index]['masa_kerja'],
						'bulan_thr' 		=> $tampung[$index]['bulan_thr'],
						'proses_by' 		=> $user,
						'tgl_input'			=> $tgl_proses,
						'input_by'			=> $user
					);

					$this->M_thr->insertBulanTHRHistory($data_thr_bulan_history);

				}
				$index++;
			}
		}

		// echo "<pre>";print_r($tampung);exit();

		echo json_encode($tampung);
	}

	public function export(){
		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');

		if (!empty($lokasi)) {
			$data = $this->M_thr->getBulanTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data = $this->M_thr->getBulanTHRByTanggal($tanggal);
		}

		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();
		$worksheet->setCellValue('A1','NO');
		$worksheet->setCellValue('B1','NO INDUK');
		$worksheet->setCellValue('C1','NAMA');
		$worksheet->setCellValue('D1','LOKASI KERJA');
		$worksheet->setCellValue('E1','MASUK KERJA');
		$worksheet->setCellValue('F1','MASA KERJA');
		$worksheet->setCellValue('G1','BULAN THR');

		$nomor = 1;
		if (!empty($data)) {
			foreach ($data as $dt) {
				$worksheet->setCellValue('A'.($nomor+1),$nomor);
				$worksheet->setCellValue('B'.($nomor+1),$dt['noind']);
				$worksheet->setCellValue('C'.($nomor+1),$dt['employee_name']);
				$worksheet->setCellValue('D'.($nomor+1),$dt['location_name']);
				$worksheet->setCellValue('E'.($nomor+1),$dt['tgl_masuk']);
				$worksheet->setCellValue('F'.($nomor+1),$dt['masa_kerja']);
				$worksheet->setCellValue('G'.($nomor+1),$dt['bulan_thr']);
				$nomor++;
			}
		}

		$worksheet->getColumnDimension('A')->setWidth('5');
		$worksheet->getColumnDimension('B')->setWidth('10');
		$worksheet->getColumnDimension('C')->setWidth('20');
		$worksheet->getColumnDimension('D')->setWidth('20');
		$worksheet->getColumnDimension('E')->setWidth('20');
		$worksheet->getColumnDimension('F')->setWidth('30');
		$worksheet->getColumnDimension('G')->setWidth('10');

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
			),'A1:G1');

		$worksheet->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'A1:G'.($nomor));

		$filename = "Perhitungan Bulan THR HLCM Idul Fitri ".$tanggal.".xls";
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
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
			$data['data'] = $this->M_thr->getBulanTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data['data'] = $this->M_thr->getBulanTHRByTanggal($tanggal);
		}

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4', 8, '', 10, 10, 10, 10, 10, 5);
		$filename = "Perhitungan Bulan THR HLCM Idul Fitri ".$tanggal.".pdf";
		$html = $this->load->view('UpahHlCm/THR/V_cetakperhitunganbulan', $data, true);
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
			$data['data'] = $this->M_thr->deleteBulanTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			if (!empty($noind)) {
				$data['data'] = $this->M_thr->deleteBulanTHRByTanggalNoind($tanggal,$noind);
			}else{
				$data['data'] = $this->M_thr->deleteBulanTHRByTanggal($tanggal);
			}
		}

		redirect(base_url('HitungHlcm/THR/PerhitunganBulan'));
	}

	public function read(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$tanggal 	= $this->input->get('tanggal');
		$lokasi 	= $this->input->get('lokasi');

		$data['Title']			=	'Perhitungan Bulan THR';
		$data['Menu'] 			= 	'Proses Gaji';
		$data['SubMenuOne'] 	= 	'Perhitungan Bulan THR';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if (!empty($lokasi)) {
			$data['data'] = $this->M_thr->getBulanTHRByTanggalLokasi($tanggal,$lokasi);
		}else{
			$data['data'] = $this->M_thr->getBulanTHRByTanggal($tanggal);
		}
		
		$data['tanggal'] = $tanggal;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/THR/V_readperhitunganbulan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cariPekerja(){
		$key = $this->input->get('term');
		$data = $this->M_thr->getPekerjaByKey($key);
		echo json_encode($data);
	}

}

?>