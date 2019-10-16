<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Cetak extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('General');
		$this->load->library('MonitoringOJT');
		$this->load->library('pdf');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_cetakmemopdca');
		$this->load->model('MonitoringOJT/M_cetakundangan');
		$this->load->model('MonitoringOJT/M_masterundangan');
		$this->load->model('MonitoringOJT/M_mastermemo');
		$this->load->model('MonitoringOJT/M_monitoring');
		$this->load->model('MonitoringOJT/M_email');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function LembarKeputusan()
	{
		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Lembar Keputusan', 'Cetak', 'Lembar Keputusan');
		$data['daftar_cetak_undangan']		=	$this->M_cetakundangan->getListKeputusan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/CetakLembar/V_Keputusan_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function createKeputusan()
	{
		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Lembar Keputusan', 'Cetak', 'Lembar Keputusan');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/CetakLembar/V_Keputusan_create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function isi_keputusan()
	{
		$data['isi_undangan'] 	=	'Pastikan Anda telah mengisi parameter yang diperlukan. ;)';
		$id_pekerja 			=	$this->input->post('cmbPekerjaOJT');
		$periode 				=	$this->input->post('ojt_pr');

		$noind = $this->M_cetakundangan->getNoind($id_pekerja);
		if (!empty($noind)) {
			$detail = $this->M_cetakundangan->getDetailPekerja($noind[0]['noind'], $periode);
			$atasan = $this->M_cetakundangan->getAtasan($noind[0]['noind']);
			foreach ($detail as $key) {
				$nama = strtolower($key['nama']);
				$nama = ucwords($nama);
				$noind = $key['noind'];
				$bithdayDate = substr($key['tgllahir'], 0, 10);
			  	$date = new DateTime($bithdayDate);
				$now = new DateTime();
				$interval = $now->diff($date);
				$age = $interval->y;
				$usia = $age;
				$jenkel = $key['jenkel'];
				$pendidikan = $key['pendidikan'].' / '.ucwords(strtolower($key['jurusan'])).' / '.$key['sekolah'];
				
				$seksi = strtolower($key['seksi']);
				$unit = strtolower($key['unit']);
				$dept = strtolower($key['dept']);
				$seksi  = ucwords($seksi);
				$unit  = ucwords($unit);
				$dept  = ucwords($dept);

				$tgl_masuk = substr($key['masukkerja'], 0, 10);
				$tgl_masuk = date('d F Y', strtotime($tgl_masuk));
				$periode_akhir = $key['akhir'];
				$periode_akhir = date('d F Y', strtotime($periode_akhir));
				$kerja = ucwords($key['status_jabatan']);
			}

			foreach ($atasan as $key) {
				$kadept = strtolower($key['kadept']);
				$wakadept = strtolower($key['wakadept']);
			}

			if (substr($jenkel, 0,1) == 'L') {
				$jenkel = 'Laki-Laki';
			}else{
				$jenkel = 'Perempuan';
			}

			if ($periode == '3') {
				$format_undangan 	=	$this->M_mastermemo->memo('20');
			}else{
				$format_undangan 	=	$this->M_mastermemo->memo('21');
			}

			$bulan_en 		=	array
			(
				'January',
				'February',
				'March',
				'April',
				'May',
				'June',
				'July',
				'August',
				'September',
				'October',
				'November',
				'December',
				);
			$bulan_id 		=	array
			(
				'Januari',
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
				'Desember',
				);
			$tgl_masuk = str_replace($bulan_en, $bulan_id, $tgl_masuk);
			$periode_akhir = str_replace($bulan_en, $bulan_id, $periode_akhir);

			$variabel_format 	=	array
			(
				'[nama]',
				'[No_Induk]',
				'[usia]',
				'[Jenis_Kelamin]',
				'[pendidikan]',
				'[seksi]',
				'[tgl_masuk]',
				'[awal]',
				'[akhir]',
				'[kerja]',
				'[dept]',
				'[kadept]',
				'[wakadept]',
				);

			$variabel_ubah		=	array
			(
				$nama,
				$noind,
				$usia,
				$jenkel,
				$pendidikan,
				$seksi.' / '.$unit,
				$tgl_masuk,
				$tgl_masuk,
				$periode_akhir,
				$kerja,
				$dept,
				ucwords($kadept),
				ucwords($wakadept),
				);

			$format 				=	str_replace($variabel_format, $variabel_ubah, $format_undangan[0]['memo']);
			$data['isi_undangan']	=	$format;

		}else{
			$data['isi_undangan'] 	=	'Pekerja Tidak Di Temukan. ;(';
		}

		echo json_encode($data);
	}

	public function saveKeputusan()
	{
		// echo "<pre>";
		// print_r($_POST);exit();
		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();
		$getId 						=	$this->M_cetakundangan->getId('ojt.tb_lembar_keputusan', 'id_keputusan');

		$id 						=	++$getId;
		$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
		$periode 					=	$this->input->post('ojt_pr');
		$undangan 					=	$this->input->post('txaIsiUndangan');
		$lebar_kertas 				=	$this->input->post('numLebarKertas');
		$tinggi_kertas 				=	$this->input->post('numTinggiKertas');
		$margin_atas 				=	$this->input->post('numBatasTepiAtas');
		$margin_bawah 				=	$this->input->post('numBatasTepiBawah');
		$margin_kiri 				=	$this->input->post('numBatasTepiKiri');
		$margin_kanan 				=	$this->input->post('numBatasTepiKanan');

		$create_undangan 		=	array
									(
										'id_keputusan'			=>	$id,
										'id_pekerja' 			=>	$id_pekerja,
										'periode' 				=>	$periode,
										'memo'				=>	$undangan,
										'lebar_kertas' 			=>	$lebar_kertas,
										'tinggi_kertas' 		=>	$tinggi_kertas,
										'margin_atas' 			=>	$margin_atas,
										'margin_bawah'			=>	$margin_bawah,
										'margin_kiri'			=>	$margin_kiri,
										'margin_kanan' 			=>	$margin_kanan,
										'last_update_date'		=>	$execution_timestamp,
										'last_update_by'		=>	$user,
									);
		$id_proses_undangan 	=	$this->M_cetakundangan->saveKeputusan($create_undangan);
		redirect('OnJobTraining/LembarKeputusan');
	}

	public function export_pdf($id)
	{
		$id 	= $this->general->dekripsi($id);

		$keputusan_pdf		=	$this->M_cetakundangan->keputusan_cetak($id);
		$noind 	=	$keputusan_pdf[0]['noind'];
		$periode 	=	$keputusan_pdf[0]['periode'];

		$pdf 	=	$this->pdf->load();
		$pdf 	=	new 	mPDF
							(
								'utf-8', 
								array
								(
									$keputusan_pdf[0]['lebar_kertas'],
									$keputusan_pdf[0]['tinggi_kertas']
								), 
								10, 
								"", 
								$keputusan_pdf[0]['margin_kiri'], 
								$keputusan_pdf[0]['margin_kanan'], 
								$keputusan_pdf[0]['margin_atas'], 
								$keputusan_pdf[0]['margin_bawah'], 
								0, 
								0, 
								'P');
		$filename	=	'Lembar Keputusan '.$periode.' Bulan - '.$noind.'.pdf';
		$pdf->SetTitle('Lembar Keputusan '.$periode.' Bulan - '.$noind.'.pdf');		
		// $pdf->AddPage();
		if ($keputusan_pdf[0]['periode'] == '3') {
			$rev = 'Rev. 02 : 07 Oktober 2016';
			$frm = 'FRM-HRM-02-24';
		}else{
			$rev = 'Rev. 09 : 22 Maret 2017';
			$frm = 'FRM-HRM-02-03';
		}
		// $mpdf->useFixedNormalLineHeight = false;
		// $mpdf->useFixedTextBaseline = false;
		// $mpdf->adjustFontDescLineheight = 11.14;
		$head = ($keputusan_pdf[0]['margin_atas']-7);
		$pdf->SetHTMLHeader('
		<div style="text-align: center; font-weight: none; height:'.$head.'mm; position: relative; border: 1px solid white;">
		    <p  style="width: 87px; float: right; position:relative; top:10; bottom:0; right: 0; border: 1px solid black; padding: 5px; font-size: 10px; margin-top: '.$head.'mm;">'.$frm.'</p>
		</div>');
		$foot = $keputusan_pdf[0]['margin_bawah'];
		$pdf->defaultfooterline=0;
		$pdf->defaultfooterfontstyle='I';
		$pdf->SetFooter('<div style="text-align: left; float: left; margin-left: 0px; width:200px; bottom:10px; height:'.$foot.'mm; vertical-align:top;">
  		<i style="font-size: 12px;margin-left: 0%">'.$rev.'</i>
  	</div>
  	<div style="float: right; width: 200px; bottom:10px; height:'.$foot.'mm; vertical-align:top;">
  		<i style="padding-left: 0%; font-size: 12px;margin-left: 10%">lembar untuk Seksi Hubker</i>
  	</div>');
		$aw = '';
		// $pdf->WriteHTML($aw);
		$pdf->WriteHTML($keputusan_pdf[0]['memo']);

		$pdf->Output($filename, 'I');
	}

	public function updateKeputusan($id)
	{
		$id 	= $this->general->dekripsi($id);
		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Lembar Keputusan', 'Cetak', 'Lembar Keputusan');

		$data['daftar_cetak_undangan']		=	$this->M_cetakundangan->keputusan_cetak($id);
		$data['id']							=	$id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/CetakLembar/V_Keputusan_update',$data);
		$this->load->view('V_Footer',$data);
	}

	public function submitUndangan($id)
	{
		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

		$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
		$periode 					=	$this->input->post('ojt_pr');
		$undangan 					=	$this->input->post('txaIsiUndangan');
		$lebar_kertas 				=	$this->input->post('numLebarKertas');
		$tinggi_kertas 				=	$this->input->post('numTinggiKertas');
		$margin_atas 				=	$this->input->post('numBatasTepiAtas');
		$margin_bawah 				=	$this->input->post('numBatasTepiBawah');
		$margin_kiri 				=	$this->input->post('numBatasTepiKiri');
		$margin_kanan 				=	$this->input->post('numBatasTepiKanan');

		$create_undangan 		=	array
									(
										'id_pekerja' 			=>	$id_pekerja,
										'periode' 				=>	$periode,
										'memo'					=>	$undangan,
										'lebar_kertas' 			=>	$lebar_kertas,
										'tinggi_kertas' 		=>	$tinggi_kertas,
										'margin_atas' 			=>	$margin_atas,
										'margin_bawah'			=>	$margin_bawah,
										'margin_kiri'			=>	$margin_kiri,
										'margin_kanan' 			=>	$margin_kanan,
										'last_update_date'		=>	$execution_timestamp,
										'last_update_by'		=>	$user,
									);
		$id_proses_undangan 	=	$this->M_cetakundangan->updateKeputusan($create_undangan, $id);
		redirect('OnJobTraining/LembarKeputusan');
	}

	public function deleteKeputusan($id)
	{
		$id = $this->general->dekripsi($id);
		$delUp = $this->M_cetakundangan->delUp($id);

		redirect('OnJobTraining/LembarKeputusan');
	}



	/*------------------------------ lembar Evaluasi -----------------------------------------*/

	public function LembarEvaluasi()
	{
		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Lembar Evaluasi', 'Cetak', 'Lembar Evaluasi');
		$data['daftar_cetak_undangan']		=	$this->M_cetakundangan->getListEvaluasi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/CetakLembar/V_Evaluasi_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function createEvaluasi()
	{
		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Lembar Evaluasi', 'Cetak', 'Lembar Evaluasi');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/CetakLembar/V_Evaluasi_create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function isi_evaluasi()
	{
		$data['isi_undangan'] 	=	'Pastikan Anda telah mengisi parameter yang diperlukan. ;)';
		$id_pekerja 			=	$this->input->post('cmbPekerjaOJT');
		$periode 				=	'36';

		$noind = $this->M_cetakundangan->getNoind($id_pekerja);
		if (!empty($noind)) {
			$detail = $this->M_cetakundangan->getDetailPekerja($noind[0]['noind'], $periode);
			$atasan = $this->M_cetakundangan->getAtasan($noind[0]['noind']);
			foreach ($detail as $key) {
				$nama = strtolower($key['nama']);
				$nama = ucwords($nama);
				$noind = $key['noind'];
				$bithdayDate = substr($key['tgllahir'], 0, 10);
			  	$date = new DateTime($bithdayDate);
				$now = new DateTime();
				$interval = $now->diff($date);
				$age = $interval->y;
				$usia = $age;
				$jenkel = $key['jenkel'];
				$pendidikan = $key['pendidikan'].' / '.ucwords(strtolower($key['jurusan'])).' / '.$key['sekolah'];
				
				$seksi = strtolower($key['seksi']);
				$unit = strtolower($key['unit']);
				$dept = strtolower($key['dept']);
				$seksi  = ucwords($seksi);
				$unit  = ucwords($unit);
				$dept  = ucwords($dept);

				$tgl_masuk = substr($key['masukkerja'], 0, 10);
				$tgl_masuk = date('d F Y', strtotime($tgl_masuk));
				$periode_akhir = $key['akhir1'];
				$periode_akhir = date('d F Y', strtotime($periode_akhir));
				$periode_akhir2 = $key['akhir2'];
				$periode_akhir2 = date('d F Y', strtotime($periode_akhir2));
				$kerja = ucwords($key['status_jabatan']);
			}

			foreach ($atasan as $key) {
				$kadept = strtolower($key['kadept']);
				$wakadept = strtolower($key['wakadept']);
			}
			if (substr($jenkel, 0,1) == 'L') {
				$jenkel = 'Laki-Laki';
			}else{
				$jenkel = 'Perempuan';
			}
			$format_undangan 	=	$this->M_mastermemo->memo('22');

			$bulan_en 		=	array
			(
				'January',
				'February',
				'March',
				'April',
				'May',
				'June',
				'July',
				'August',
				'September',
				'October',
				'November',
				'December',
				);
			$bulan_id 		=	array
			(
				'Januari',
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
				'Desember',
				);
			$tgl_masuk = str_replace($bulan_en, $bulan_id, $tgl_masuk);
			$periode_akhir = str_replace($bulan_en, $bulan_id, $periode_akhir);

			$variabel_format 	=	array
			(
				'[nama]',
				'[No_Induk]',
				'[usia]',
				'[Jenis_Kelamin]',
				'[pendidikan]',
				'[seksi]',
				'[tgl_masuk]',
				'[awal]',
				'[akhir]',
				'[akhir2]',
				'[kerja]',
				'[dept]',
				'[kadept]',
				'[wakadept]',
				);

			$variabel_ubah		=	array
			(
				$nama,
				$noind,
				$usia,
				$jenkel,
				$pendidikan,
				$seksi.' / '.$unit,
				$tgl_masuk,
				$tgl_masuk,
				$periode_akhir,
				$periode_akhir2,
				$kerja,
				$dept,
				ucwords($kadept),
				ucwords($wakadept),
				);

			$format 				=	str_replace($variabel_format, $variabel_ubah, $format_undangan[0]['memo']);
			$data['isi_undangan']	=	$format;

		}else{
			$data['isi_undangan'] 	=	'Pekerja Tidak Di Temukan. ;(';
		}

		echo json_encode($data);
	}

	public function saveEvaluasi()
	{
		// echo "<pre>";
		// print_r($_POST);exit();
		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();
		$getId 						=	$this->M_cetakundangan->getId('ojt.tb_lembar_evaluasi', 'id_evaluasi');

		$id 						=	++$getId;
		$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
		$undangan 					=	$this->input->post('txaIsiUndangan');
		$lebar_kertas 				=	$this->input->post('numLebarKertas');
		$tinggi_kertas 				=	$this->input->post('numTinggiKertas');
		$margin_atas 				=	$this->input->post('numBatasTepiAtas');
		$margin_bawah 				=	$this->input->post('numBatasTepiBawah');
		$margin_kiri 				=	$this->input->post('numBatasTepiKiri');
		$margin_kanan 				=	$this->input->post('numBatasTepiKanan');
		$undangan = str_replace('<ul>', '<ul style="margin-left: 23px;">', $undangan);

		$create_undangan 		=	array
									(
										'id_evaluasi'			=>	$id,
										'id_pekerja' 			=>	$id_pekerja,
										'memo'					=>	$undangan,
										'lebar_kertas' 			=>	$lebar_kertas,
										'tinggi_kertas' 		=>	$tinggi_kertas,
										'margin_atas' 			=>	$margin_atas,
										'margin_bawah'			=>	$margin_bawah,
										'margin_kiri'			=>	$margin_kiri,
										'margin_kanan' 			=>	$margin_kanan,
										'last_update_date'		=>	$execution_timestamp,
										'last_update_by'		=>	$user,
									);
		$id_proses_undangan 	=	$this->M_cetakundangan->saveEvaluasi($create_undangan);
		redirect('OnJobTraining/LembarEvaluasi');
	}

	public function export_pdf_ev($id)
	{
		$id 	= $this->general->dekripsi($id);

		$keputusan_pdf		=	$this->M_cetakundangan->evaluasi_cetak($id);
		$noind 	= $keputusan_pdf[0]['noind'];

		$pdf 	=	$this->pdf->load();
		$pdf 	=	new 	mPDF
							(
								'utf-8', 
								array
								(
									$keputusan_pdf[0]['lebar_kertas'],
									$keputusan_pdf[0]['tinggi_kertas']
								), 
								10.5, 
								"", 
								$keputusan_pdf[0]['margin_kiri'], 
								$keputusan_pdf[0]['margin_kanan'], 
								$keputusan_pdf[0]['margin_atas'], 
								$keputusan_pdf[0]['margin_bawah'], 
								0, 
								0, 
								'P');
		$filename	=	'Lembar Evaluasi - '.$noind.'.pdf';
		$pdf->SetTitle('Lembar Evaluasi - '.$noind.'.pdf');
		$aw = '';
		$foot = $keputusan_pdf[0]['margin_bawah'];
		$head = ($keputusan_pdf[0]['margin_atas']/2);
		$pdf->SetHTMLHeader('
		<div style="text-align: center; font-weight: none; height:'.$head.'mm; position: relative; border: 1px solid white; float: right">
		    <p  style="width: 87px; float: right; position:relative; top:10; bottom:0; right: 0; border: 1px solid black; padding: 5px; font-size: 10px; margin-top: '.$head.'mm;">FRM-HRM-02-02</p>
		</div>', 'O');
		$pdf->defaultfooterline=0;
		$pdf->defaultfooterfontstyle='I';
		$pdf->SetFooter('<div style="max-height:'.$foot.'mm;">
			<div style="float: left; width: 25%; bottom:10px; height:'.$foot.'mm; vertical-align:top;">
		  		<i style="padding-left: 0%; font-size: 12px;margin-left: 10%"> </i>
		  	</div>
  	<div style="vertical-align:top; text-align: center; float: left;  width:49%; height:'.$foot.'mm; bottom:10px;">
  		<i style="font-size: 12px;margin-left: 0%">Hal. {PAGENO} / {nb}</i>
  	</div>
  	<div style="float: right; width: 25%; bottom:10px; height:'.$foot.'mm; vertical-align:top;">
  		<i style="padding-left: 0%; font-size: 12px;margin-left: 10%">Rev. 06 : 14 Januari 2015</i>
  	</div>
  	</div>');
		// $pdf->WriteHTML($aw);
		$pdf->WriteHTML($keputusan_pdf[0]['memo']);

		$pdf->Output($filename, 'I');
	}

	public function deleteEvaluasi($id)
	{
		$id = $this->general->dekripsi($id);
		$delUp = $this->M_cetakundangan->delUp2($id);

		redirect('OnJobTraining/LembarEvaluasi');
	}

	public function updateEvaluasi($id)
	{
		$id 	= $this->general->dekripsi($id);
		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Lembar Evaluasi', 'Cetak', 'Lembar Evaluasi');

		$data['daftar_cetak_undangan']		=	$this->M_cetakundangan->evaluasi_cetak($id);
		$data['id']							=	$id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/CetakLembar/V_Evaluasi_update',$data);
		$this->load->view('V_Footer',$data);
	}

	public function submitUpEvaluasi($id)
	{
		$user 						=	$this->session->user;
		$execution_timestamp 		=	$this->general->ambilWaktuEksekusi();

		$id_pekerja 				=	$this->input->post('cmbPekerjaOJT');
		$periode 					=	$this->input->post('ojt_pr');
		$undangan 					=	$this->input->post('txaIsiUndangan');
		$lebar_kertas 				=	$this->input->post('numLebarKertas');
		$tinggi_kertas 				=	$this->input->post('numTinggiKertas');
		$margin_atas 				=	$this->input->post('numBatasTepiAtas');
		$margin_bawah 				=	$this->input->post('numBatasTepiBawah');
		$margin_kiri 				=	$this->input->post('numBatasTepiKiri');
		$margin_kanan 				=	$this->input->post('numBatasTepiKanan');

		$undangan = str_replace('<ul>', '<ul style="margin-left: 23px;">', $undangan);

		$create_undangan 		=	array
									(
										'id_pekerja' 			=>	$id_pekerja,
										'memo'					=>	$undangan,
										'lebar_kertas' 			=>	$lebar_kertas,
										'tinggi_kertas' 		=>	$tinggi_kertas,
										'margin_atas' 			=>	$margin_atas,
										'margin_bawah'			=>	$margin_bawah,
										'margin_kiri'			=>	$margin_kiri,
										'margin_kanan' 			=>	$margin_kanan,
										'last_update_date'		=>	$execution_timestamp,
										'last_update_by'		=>	$user,
									);
		$id_proses_undangan 	=	$this->M_cetakundangan->updateEvaluasi($create_undangan, $id);
		redirect('OnJobTraining/LembarEvaluasi');
	}
}