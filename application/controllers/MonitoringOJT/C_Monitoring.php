<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_masterorientasi');
		$this->load->model('MonitoringOJT/M_monitoring');

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

	public function index()
	{
		$user_id = $this->session->userid;
		
		$data['Header']			=	'Monitoring OJT - Quick ERP';
		$data['Title']			=	'Monitoring OJT';
		$data['Menu'] 			= 	'Monitoring';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['daftarPekerjaOJT']	=	$this->M_monitoring->ambilTabelDaftarPekerjaOJT();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_Monitoring_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambahPekerja()
	{
		$waktuEksekusi 				=	$this->general->ambilWaktuEksekusi();
		$user 						=	$this->session->user;

		$nomor_induk_pekerja 		= 	$this->input->post('cmbDaftarPekerjaOJT');
		$nomor_induk_atasan			=	$this->input->post('cmbDaftarAtasanPekerja');

		$ambilInfoPekerja 			=	$this->M_monitoring->ambilInfoPekerja($nomor_induk_pekerja);
		$nomor_induk_baru_pekerja	=	$ambilInfoPekerja[0]['noind_baru'];
		$tanggal_masuk_pekerja 		=	$ambilInfoPekerja[0]['masukkerja'];

		$inputPekerjaOJT 			=	array
										(
											'noind_baru'		=>	$nomor_induk_baru_pekerja,
											'noind'				=>	$nomor_induk_pekerja,
											'tgl_masuk'			=>	$tanggal_masuk_pekerja,
											'atasan'			=>	$nomor_induk_atasan,
											'create_timestamp'	=>	$waktuEksekusi,
											'create_user'		=>	$user,
										);
		echo '<pre>';
		print_r($inputPekerjaOJT);
		echo '</pre>';

		$pekerja_id 				=	$this->M_monitoring->inputPekerjaOJT($inputPekerjaOJT);

		$inputPekerjaHistory 		=	array
										(
											'pekerja_id'		=>	$pekerja_id,
											'noind_baru'		=>	$nomor_induk_baru_pekerja,
											'noind'				=>	$nomor_induk_pekerja,
											'tgl_masuk'			=>	$tanggal_masuk_pekerja,
											'atasan'			=>	$nomor_induk_atasan,
											'type'				=>	'CREATE',
											'create_timestamp'	=>	$waktuEksekusi,
											'create_user'		=>	$user,
										);
		echo '<pre>';
		print_r($inputPekerjaHistory);
		echo '</pre>';

		$this->M_monitoring->inputPekerjaHistory($inputPekerjaHistory);

		$daftarOrientasi 		= 	$this->M_masterorientasi->ambilDaftarOrientasiTabel();
		$jumlahOrientasi 		=	count($daftarOrientasi);
		$indeksOrientasi 		= 	1;
		foreach ($daftarOrientasi as $orientasi)
		{
			if($indeksOrientasi==1)
			{
				$tanggal_awal_proses 	=	$tanggal_masuk_pekerja;
				$tanggal_akhir_proses	=	$tanggal_masuk_pekerja;
				$inputProsesJadwal 		=	array
											(
												'noind'				=>	$nomor_induk_pekerja,
												'id_orientasi'		=>	$orientasi['id_orientasi'],
												'tahapan'			=>	$orientasi['tahapan'],
												'periode'			=>	$orientasi['periode'],
												'sequence'			=>	$orientasi['sequence'],
												'tgl_awal'			=>	$tanggal_awal_proses,
												'tgl_akhir'			=>	$tanggal_akhir_proses,
												'create_timestamp'	=>	$waktuEksekusi,
												'create_user'		=>	$user,
											);

				$id_proses 				=	$this->M_monitoring->inputProsesJadwal($inputProsesJadwal);

				$inputProsesJadwalHistory	=	array
												(
													'id_proses'			=>	$id_proses,
													'noind'				=>	$nomor_induk_pekerja,
													'id_orientasi'		=>	$orientasi['id_orientasi'],
													'tahapan'			=>	$orientasi['tahapan'],
													'periode'			=>	$orientasi['periode'],
													'sequence'			=>	$orientasi['sequence'],
													'tgl_awal'			=>	$tanggal_awal_proses,
													'tgl_akhir'			=>	$tanggal_akhir_proses,
													'type'				=>	'CREATE',
													'create_timestamp'	=>	$waktuEksekusi,
													'create_user'		=>	$user,
												);
				$this->M_monitoring->inputProsesJadwalHistory($inputProsesJadwalHistory);
			}
			else
			{
				$id_proses 	=	NULL;
				if($orientasi['ck_tgl']=='t')
				{
					$cekAlurOrientasi 		=	$this->M_monitoring->ambilJadwalOrientasi($orientasi['id_orientasi']);
					$rujukanOrientasi 		=	$cekAlurOrientasi[0]['tujuan'];
					$ambilTanggalOrientasiSebelum	=	$this->M_monitoring->ambilTanggalOrientasiSebelum($nomor_induk_pekerja, $rujukanOrientasi);
					$tanggal_proses_sebelum =	$ambilTanggalOrientasiSebelum[0]['tgl_akhir'];
					$intervalOrientasi 		=	$this->M_monitoring->ambilIntervalOrientasi($orientasi['id_orientasi']);
					$intervalTanggalAwal 	=	$intervalOrientasi[0]['interval'];
					$inversKalkulasiTanggal	=	$intervalOrientasi[0]['invert'];

					$tanggal_proses_sebelum	=	new DateTime($tanggal_proses_sebelum);
					$intervalTanggalAwal 	=	new DateInterval($intervalTanggalAwal);
					if($inversKalkulasiTanggal == 1)
					{
						$intervalTanggalAwal->invert 	=	1;
					}
					$tanggal_proses_sebelum->add($intervalTanggalAwal);

					$tanggal_awal_proses 	=	$tanggal_proses_sebelum->format('Y-m-d');

					$intervalAkhirOrientasi	=	$this->M_monitoring->ambilIntervalAkhirOrientasi($orientasi['id_orientasi']);
					$intervalTanggalAkhir	=	$intervalAkhirOrientasi[0]['interval'];

					$tanggal_awal_orientasi	=	new DateTime($tanggal_awal_proses);
					$intervalTanggalAkhir	=	new DateInterval($intervalTanggalAkhir);

					$tanggal_awal_orientasi->add($intervalTanggalAkhir);
					$tanggal_akhir_proses	=	$tanggal_awal_orientasi->format('Y-m-d');

					$inputProsesJadwal 		=	array
												(
													'noind'				=>	$nomor_induk_pekerja,
													'id_orientasi'		=>	$orientasi['id_orientasi'],
													'tahapan'			=>	$orientasi['tahapan'],
													'periode'			=>	$orientasi['periode'],
													'sequence'			=>	$orientasi['sequence'],
													'tgl_awal'			=>	$tanggal_awal_proses,
													'tgl_akhir'			=>	$tanggal_akhir_proses,
													'create_timestamp'	=>	$waktuEksekusi,
													'create_user'		=>	$user,
												);
					$id_proses 		=	$this->M_monitoring->inputProsesJadwal($inputProsesJadwal);

					$inputProsesJadwalHistory	=	array
													(
														'id_proses'			=>	$id_proses,
														'noind'				=>	$nomor_induk_pekerja,
														'id_orientasi'		=>	$orientasi['id_orientasi'],
														'tahapan'			=>	$orientasi['tahapan'],
														'periode'			=>	$orientasi['periode'],
														'sequence'			=>	$orientasi['sequence'],
														'tgl_awal'			=>	$tanggal_awal_proses,
														'tgl_akhir'			=>	$tanggal_akhir_proses,
														'type'				=>	'CREATE',
														'create_timestamp'	=>	$waktuEksekusi,
														'create_user'		=>	$user,
													);
					$this->M_monitoring->inputProsesJadwalHistory($inputProsesJadwalHistory);

					if($orientasi['pemberitahuan']=='t')
					{
						$cekPemberitahuan 		=	$this->M_monitoring->ambilPemberitahuanOrientasi($orientasi['id_orientasi']);
						foreach ($cekPemberitahuan as $pemberitahuan)
						{
							$tujuan 	=	$pemberitahuan['penerima'];

							$intervalPemberitahuan 	=	'P';
							if(!(empty($pemberitahuan['bulan'])))
							{
								$intervalPemberitahuan 	.=	$pemberitahuan['bulan'].'M';
							}
							else
							{
								$intervalPemberitahuan 	.=	'0M';
							}
							if(!(empty($pemberitahuan['minggu'])))
							{
								$intervalPemberitahuan 	.=	$pemberitahuan['minggu'].'W';
							}
							else
							{
								$intervalPemberitahuan 	.=	'0W';
							}
							if(!(empty($pemberitahuan['hari'])))
							{
								$intervalPemberitahuan 	.=	$pemberitahuan['hari'].'D';
							}
							else
							{
								$intervalPemberitahuan 	.=	'0D';
							}

							$tanggal_akhir_pemberitahuan	=	$tanggal_awal_proses;
							$tanggal_awal_proses 			=	new DateTime($tanggal_proses_sebelum->format('Y-m-d'));
							$interval_pemberitahuan 		=	new DateInterval($intervalPemberitahuan);

							if($pemberitahuan['urutan']=='f')
							{
								$interval_pemberitahuan->invert 	=	1;
							}

							$tanggal_awal_proses->add($interval_pemberitahuan);
							$tanggal_awal_pemberitahuan	=	$tanggal_awal_proses->format('Y-m-d');

							if($pemberitahuan['pengulang']=='t')
							{
								$rentangTanggalPemberitahuan	=	new DatePeriod
																	(
																		new DateTime($tanggal_awal_pemberitahuan),
																		new DateInterval('P1D'),
																		new DateTime(date('Y-m-d', strtotime($tanggal_akhir_pemberitahuan.'+1 day')))
																	);
								foreach ($rentangTanggalPemberitahuan as $tanggalPemberitahuan)
								{
									$tanggal_pemberitahuan 	=	$tanggalPemberitahuan->format('Y-m-d');
									$inputProsesPemberitahuan	=	array
																	(
																		'id_proses'			=>	$id_proses,
																		'tujuan'			=>	$tujuan,
																		'tanggal'			=>	$tanggal_pemberitahuan,
																		'create_timestamp'	=>	$waktuEksekusi,
																		'create_user'		=>	$user,
																	);
									$id_proses_pemberitahuan	=	$this->M_monitoring->inputProsesPemberitahuan($inputProsesPemberitahuan);

									$inputProsesPemberitahuanHistory	=	array
																			(
																				'id_proses_pemberitahuan'	=>	$id_proses_pemberitahuan,
																				'id_proses'					=>	$id_proses,
																				'tujuan'					=>	$tujuan,
																				'tanggal'					=>	$tanggal_pemberitahuan,
																				'type'						=>	'CREATE',
																				'create_timestamp'			=>	$waktuEksekusi,
																				'create_user'				=>	$user,
																			);
									$this->M_monitoring->inputProsesPemberitahuanHistory($inputProsesPemberitahuanHistory);
								}
							}
							else
							{
								$inputProsesPemberitahuan	=	array
																(
																	'id_proses'			=>	$id_proses,
																	'tujuan'			=>	$tujuan,
																	'tanggal'			=>	$tanggal_awal_pemberitahuan,
																	'create_timestamp'	=>	$waktuEksekusi,
																	'create_user'		=>	$user,
																);
								$id_proses_pemberitahuan	=	$this->M_monitoring->inputProsesPemberitahuan($inputProsesPemberitahuan);

								$inputProsesPemberitahuanHistory	=	array
																		(
																			'id_proses_pemberitahuan'	=>	$id_proses_pemberitahuan,
																			'id_proses'					=>	$id_proses,
																			'tujuan'					=>	$tujuan,
																			'tanggal'					=>	$tanggal_awal_pemberitahuan,
																			'type'						=>	'CREATE',
																			'create_timestamp'			=>	$waktuEksekusi,
																			'create_user'				=>	$user,
																		);
								$this->M_monitoring->inputProsesPemberitahuanHistory($inputProsesPemberitahuanHistory);
							}
						}
					}
				}
				else
				{
					echo 'Tanggal tidak otomatis';
					$tanggal_awal_proses 	=	NULL;
					$tanggal_akhir_proses	=	NULL;
					$inputProsesJadwal 		=	array
												(
													'noind'				=>	$nomor_induk_pekerja,
													'id_orientasi'		=>	$orientasi['id_orientasi'],
													'tahapan'			=>	$orientasi['tahapan'],
													'periode'			=>	$orientasi['periode'],
													'sequence'			=>	$orientasi['sequence'],
													'tgl_awal'			=>	$tanggal_awal_proses,
													'tgl_akhir'			=>	$tanggal_akhir_proses,
													'create_timestamp'	=>	$waktuEksekusi,
													'create_user'		=>	$user,
												);
					$id_proses 		=	$this->M_monitoring->inputProsesJadwal($inputProsesJadwal);
					$inputProsesJadwalHistory	=	array
													(
														'id_proses'			=>	$id_proses,
														'noind'				=>	$nomor_induk_pekerja,
														'id_orientasi'		=>	$orientasi['id_orientasi'],
														'tahapan'			=>	$orientasi['tahapan'],
														'periode'			=>	$orientasi['periode'],
														'sequence'			=>	$orientasi['sequence'],
														'tgl_awal'			=>	$tanggal_awal_proses,
														'tgl_akhir'			=>	$tanggal_akhir_proses,
														'type'				=>	'CREATE',
														'create_timestamp'	=>	$waktuEksekusi,
														'create_user'		=>	$user,
													);
					$this->M_monitoring->inputProsesJadwalHistory($inputProsesJadwalHistory);
				}
			}
			echo '<br/><br/>';
			$indeksOrientasi++;
		}
		redirect('OnJobTraining/Monitoring');
	}

	public function scheduling($value='')
	{
		# code...
	}

	// 	Untuk server-side Select2
	// 	{
			public function tambahPekerjaOJT()
			{
				$keyword 			=	strtoupper($this->input->get('term'));

				$daftarPekerjaOJT 	=	$this->M_monitoring->ambilDaftarPekerjaOJT($keyword);
				echo json_encode($daftarPekerjaOJT);
			}

			public function tambahAtasanPekerja()
			{
				$pekerjaOJT 		=	$this->input->get('pekerja');
				$keyword 			=	strtoupper($this->input->get('term'));

				$daftarAtasan 		=	$this->M_monitoring->ambilAtasanPekerja($keyword, $pekerjaOJT);
				echo json_encode($daftarAtasan);
			}
	//	}
}
