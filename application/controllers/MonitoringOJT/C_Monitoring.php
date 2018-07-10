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

		$this->load->library('MonitoringOJT');

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

		$data['daftarPekerjaOJT']		=	$this->M_monitoring->ambilTabelDaftarPekerjaOJT();
		$data['proses_berjalan']		=	$this->M_monitoring->proses_berjalan();
		$data['daftarOrientasi'] 		=	$this->M_masterorientasi->ambilDaftarOrientasiTabel();

		$tanggal_rekap 					=	$this->input->post('txtTanggalRekapHarian', TRUE);

		$data['notifikasi_harian'] 		=	$this->M_monitoring->notifikasi_harian();
		$data['rekap_kegiatan_harian']	=	$this->M_monitoring->rekap_kegiatan_harian($tanggal_rekap);
		$data['tanggal_rekap']			=	$tanggal_rekap;
		
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
		$email_pekerja 				=	$this->input->post('txtEmailPekerja', TRUE);
		$email_atasan_pekerja 		=	$this->input->post('txtEmailAtasanPekerja', TRUE);

		if ( empty($email_pekerja) )
		{
			$email_pekerja 			=	NULL;
		}
	
		if ( empty($email_atasan_pekerja) )
		{
			$email_atasan_pekerja 			=	NULL;
		}		

		$pilih_orientasi 			=	$this->input->post('chkOrientasi', TRUE);
		for ($i=0; $i < count($pilih_orientasi); $i++)
		{ 
			$pilih_orientasi[$i] 	=	$this->general->dekripsi($pilih_orientasi[$i]); 
		}

		$ambilInfoPekerja 			=	$this->M_monitoring->ambilInfoPekerja($nomor_induk_pekerja);
		
		$nomor_induk_baru_pekerja		=	$ambilInfoPekerja[0]['noind_baru'];
		$tanggal_masuk_pekerja 			=	$ambilInfoPekerja[0]['masukkerja'];
		$tanggal_lahir_pekerja 			=	$ambilInfoPekerja[0]['tgllahir'];
		$kodesie_pekerja 				=	$ambilInfoPekerja[0]['kodesie'];
		$jenjang_pendidikan_terakhir	=	$ambilInfoPekerja[0]['pendidikan'];
		$jurusan 						=	$ambilInfoPekerja[0]['jurusan'];
		$institusi_pendidikan 			=	$ambilInfoPekerja[0]['sekolah'];

		$inputPekerjaOJT 			=	array
										(
											'noind_baru'					=>	$nomor_induk_baru_pekerja,
											'noind'							=>	$nomor_induk_pekerja,
											'tgl_masuk'						=>	$tanggal_masuk_pekerja,
											'atasan'						=>	$nomor_induk_atasan,
											'jenjang_pendidikan_terakhir'	=>	$jenjang_pendidikan_terakhir,
											'jurusan'						=>	$jurusan,
											'institusi_pendidikan'			=>	$institusi_pendidikan,
											'tanggal_lahir'					=>	$tanggal_lahir_pekerja,
											'email_pekerja' 				=>	$email_pekerja,
											'email_atasan' 					=>	$email_atasan_pekerja,
											'create_timestamp'				=>	$waktuEksekusi,
											'create_user'					=>	$user,
										);
		echo '<pre>';
		print_r($inputPekerjaOJT);
		echo '</pre>';

		$pekerja_id 				=	$this->M_monitoring->inputPekerjaOJT($inputPekerjaOJT);

		$inputPekerjaHistory 		=	array
										(
											'pekerja_id'					=>	$pekerja_id,
											'noind_baru'					=>	$nomor_induk_baru_pekerja,
											'noind'							=>	$nomor_induk_pekerja,
											'tgl_masuk'						=>	$tanggal_masuk_pekerja,
											'atasan'						=>	$nomor_induk_atasan,
											'jenjang_pendidikan_terakhir'	=>	$jenjang_pendidikan_terakhir,
											'jurusan'						=>	$jurusan,
											'institusi_pendidikan'			=>	$institusi_pendidikan,
											'tanggal_lahir'					=>	$tanggal_lahir_pekerja,
											'email_pekerja' 				=>	$email_pekerja,
											'email_atasan' 					=>	$email_atasan_pekerja,
											'type'							=>	'CREATE',
											'create_timestamp'				=>	$waktuEksekusi,
											'create_user'					=>	$user,
										);
		echo '<pre>';
		print_r($inputPekerjaHistory);
		echo '</pre>';

		$this->M_monitoring->inputPekerjaHistory($inputPekerjaHistory);

		$daftarOrientasi 		= 	$this->M_masterorientasi->ambilDaftarOrientasiTabel(FALSE, 'input_order');
		$jumlahOrientasi 		=	count($daftarOrientasi);
		$indeksOrientasi 		= 	1;
		foreach ($daftarOrientasi as $orientasi)
		{
			echo 'Kegiatan <b>'.$orientasi['tahapan'].'</b><br/>';
			if($indeksOrientasi==1)
			{
				$tanggal_awal_proses 	=	$tanggal_masuk_pekerja;
				$tanggal_akhir_proses	=	$tanggal_masuk_pekerja;

				echo $tanggal_awal_proses.' - '.$tanggal_akhir_proses;
				$inputProsesJadwal 		=	array
											(
												'noind'				=>	$nomor_induk_pekerja,
												'id_orientasi'		=>	$orientasi['id_orientasi'],
												'tahapan'			=>	$orientasi['tahapan'],
												'periode'			=>	$orientasi['periode'],
												'sequence'			=>	$orientasi['sequence'],
												'tgl_awal'			=>	$tanggal_awal_proses,
												'tgl_akhir'			=>	$tanggal_akhir_proses,
												'selesai'			=>	TRUE,
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
													'selesai'			=>	TRUE,
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

					echo 'Tanggal Kegiatan Sebelum - '.$tanggal_proses_sebelum.'<br/>';

					$intervalOrientasi 		=	$this->M_monitoring->ambilIntervalOrientasi($orientasi['id_orientasi']);
					$intervalTanggalAwal 	=	$intervalOrientasi[0]['interval'];
					$operatorHitungTanggalAwal	=	$intervalOrientasi[0]['operator'];

					echo $intervalTanggalAwal.'<br/>';

					$hitungTanggalAwal 		=	$this->M_monitoring->hitungTanggalPostgre($tanggal_proses_sebelum, $intervalTanggalAwal, $operatorHitungTanggalAwal);
					$tanggal_awal_proses 	=	$hitungTanggalAwal[0]['result'];

					$intervalAkhirOrientasi	=	$this->M_monitoring->ambilIntervalAkhirOrientasi($orientasi['id_orientasi']);
					$intervalTanggalAkhir	=	$intervalAkhirOrientasi[0]['interval'];
					$operatorHitungTanggalAkhir	=	'+';

					$hitungTanggalAkhir 	=	$this->M_monitoring->hitungTanggalPostgre($tanggal_awal_proses, $intervalTanggalAkhir, $operatorHitungTanggalAkhir);

					$tanggal_akhir_proses	=	$hitungTanggalAkhir[0]['result'];

					echo 'Pelaksanaan - '.$tanggal_awal_proses.' - '.$tanggal_akhir_proses;

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
							$id_pemberitahuan 	=	$pemberitahuan['id_pemberitahuan'];
							$tujuan 			=	$pemberitahuan['penerima'];

							$intervalPemberitahuanBulan 	=	0;
							$intervalPemberitahuanHari		=	0;

							$operatorHitungPemberitahuan	=	'';

							if(!(empty($pemberitahuan['bulan'])))
							{
								$intervalPemberitahuanBulan +=	$pemberitahuan['bulan'];
							}

							if(!(empty($pemberitahuan['minggu']))) 
							{
								$intervalPemberitahuanHari	+=	($pemberitahuan['minggu']*7);
							}

							if(!(empty($pemberitahuan['hari']))) 
							{
								$intervalPemberitahuanHari	+=	($pemberitahuan['hari']);
							}

							$intervalPemberitahuan 			=	$intervalPemberitahuanBulan.' month '.$intervalPemberitahuanHari.' day ';

							$tanggal_akhir_pemberitahuan	=	$tanggal_awal_proses;

							if($pemberitahuan['urutan']=='f')
							{
								$operatorHitungPemberitahuan 	=	'-';
							}
							else
							{
								$operatorHitungPemberitahuan 	=	'+';
							}

							$hitung_awal_pemberitahuan		=	$this->M_monitoring->hitungTanggalPostgre($tanggal_awal_proses, $intervalPemberitahuan, $operatorHitungPemberitahuan);
							$tanggal_awal_pemberitahuan 	=	$hitung_awal_pemberitahuan[0]['result'];

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
																		'id_pemberitahuan'	=>	$id_pemberitahuan,
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
																				'id_pemberitahuan'			=>	$id_pemberitahuan,
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
																	'id_pemberitahuan'	=>	$id_pemberitahuan,
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
																			'id_pemberitahuan'			=>	$id_pemberitahuan,
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

		$ambil_proses_delete	=	$this->M_masterorientasi->ambil_proses_delete($nomor_induk_pekerja, $pilih_orientasi);
		foreach ($ambil_proses_delete as $proses_delete)
		{
			$ambil_proses_pemberitahuan_delete 	=	$this->M_masterorientasi->ambil_proses_pemberitahuan_delete($proses_delete['id_proses']);
			foreach ($ambil_proses_pemberitahuan_delete as $proses_pemberitahuan_delete)
			{
				if( $proses_pemberitahuan_delete['selesai']=='t' )
				{
					$proses_pemberitahuan_delete['selesai']	=	TRUE;
				}
				else
				{
					$proses_pemberitahuan_delete['selesai']	=	FALSE;
				}

				$proses_pemberitahuan_history 	= 	array
													(
														'id_proses_pemberitahuan'	=>	$proses_pemberitahuan_delete['id_proses_pemberitahuan'],
														'id_proses'					=>	$proses_pemberitahuan_delete['id_proses'],
														'tujuan'					=>	$proses_pemberitahuan_delete['tujuan'],
														'tanggal'					=>	$proses_pemberitahuan_delete['tanggal'],
														'id_pemberitahuan'			=>	$proses_pemberitahuan_delete['id_pemberitahuan'],
														'selesai'						=>	$proses_pemberitahuan_delete['selesai'],
														'type'						=>	'DELETE',
														'delete_timestamp'			=>	$waktuEksekusi,
														'delete_user'				=>	$user,
													);
				$this->M_masterorientasi->proses_pemberitahuan_history($proses_pemberitahuan_history);

				$this->M_masterorientasi->proses_pemberitahuan_delete($proses_pemberitahuan_delete['id_proses_pemberitahuan']);
			}

			if ( $proses_delete['selesai']=='t' )
			{
				$proses_delete['selesai'] 	=	TRUE;
			}
			else
			{
				$proses_delete['selesai']	=	FALSE;
			}

			$proses_history 	=	array
									(
										'id_proses'			=>	$proses_delete['id_proses'],
										'noind'				=>	$proses_delete['noind'],
										'id_orientasi'		=>	$proses_delete['id_orientasi'],
										'tahapan'			=>	$proses_delete['tahapan'],
										'periode'			=>	$proses_delete['periode'],
										'sequence'			=>	$proses_delete['sequence'],
										'tgl_awal'			=>	$proses_delete['tgl_awal'],
										'tgl_akhir'			=>	$proses_delete['tgl_akhir'],
										'type'				=>	'DELETE',
										'delete_timestamp'	=>	$waktuEksekusi,
										'delete_user'		=>	$user,
									);
			$this->M_monitoring->inputProsesJadwalHistory($proses_history);

			$this->M_monitoring->proses_delete($proses_delete['id_proses']);
		}
		redirect('OnJobTraining/Monitoring');
	}

	public function scheduling($pekerja_id)
	{
		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring OJT - Quick ERP', 'Penjadwalan Manual', 'Monitoring');

		$data['getTraineeInfo']	=	$this->M_monitoring->ambilTabelDaftarPekerjaOJT($this->general->dekripsi($pekerja_id));
		$data['getSchedule'] 	=	$this->M_monitoring->ambilPenjadwalanManual($this->general->dekripsi($pekerja_id));

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_Monitoring_Schedule',$data);
		$this->load->view('V_Footer',$data);
	}

	public function scheduling_save()
	{
		$executionTimestamp 	=	date('Y-m-d H:i:s');

		$id_proses 		=	$this->input->post('txtIDProsesPenjadwalan');
		$id_orientasi	=	$this->input->post('txtIDOrientasi');
		$jadwal_manual 	=	$this->input->post('txtPenjadwalanManual');
		$selesai 		=	$this->input->post('chkProsesSelesai');

		for ($p = 0; $p < count($id_proses); $p++)
		{ 
			$id_proses[$p] 	=	$this->general->dekripsi($id_proses[$p]);
		}

		for ($q = 0; $q < count($id_orientasi); $q++)
		{ 
			$id_orientasi[$q] 	=	$this->general->dekripsi($id_orientasi[$q]);
		}

		echo '<pre>';
		print_r($jadwal_manual);
		echo '</pre>';

		for ($i = 0; $i < count($id_proses); $i++)
		{ 
			$jadwal_manual[$i] 		=	explode(' - ', $jadwal_manual[$i]);
			$tanggal_awal_proses 	=	$jadwal_manual[$i][0];
			$tanggal_akhir_proses 	=	$jadwal_manual[$i][1];

			$updateProses 			=	array
										(
											'tgl_awal' 				=>	$tanggal_awal_proses,
											'tgl_akhir'				=>	$tanggal_akhir_proses,
											'last_update_timestamp'	=>	$executionTimestamp,
											'last_update_user' 		=>	$this->session->user,
										);
			$this->M_monitoring->updateProses($updateProses, $id_proses[$i]);

			$ambilProses 			=	$this->M_monitoring->ambilProses($id_proses[$i]);

			foreach ($ambilProses as $orientasi)
			{
				$inputProsesJadwalHistory		=	array
													(
														'id_proses'			=>	$orientasi['id_proses'],
														'noind'				=>	$orientasi['noind'],
														'id_orientasi'		=>	$orientasi['id_orientasi'],
														'tahapan'			=>	$orientasi['tahapan'],
														'periode'			=>	$orientasi['periode'],
														'sequence'			=>	$orientasi['sequence'],
														'tgl_awal'			=>	$orientasi['tgl_awal'],
														'tgl_akhir'			=>	$orientasi['tgl_akhir'],
														'type'				=>	'UPDATE',
														'create_timestamp'	=>	$executionTimestamp,
														'create_user'		=>	$this->session->user,
													);
				$this->M_monitoring->inputProsesJadwalHistory($inputProsesJadwalHistory);
			}

			$cekPemberitahuan 			=	$this->M_monitoring->ambilPemberitahuanOrientasi($id_orientasi[$i]);
			$cekProsesPemberitahuan 	=	$this->M_monitoring->cekProsesPemberitahuan($id_proses[$i]);

			if(!(empty($cekPemberitahuan)))
			{
				if(!(empty($cekProsesPemberitahuan)))
				{
					// delete yang sudah ada
					foreach ($cekProsesPemberitahuan as $proses_pemberitahuan)
					{
						$inputProsesPemberitahuanHistory	=	array
																(
																	'id_proses_pemberitahuan'	=>	$proses_pemberitahuan['id_proses_pemberitahuan'],
																	'id_proses'					=>	$proses_pemberitahuan['id_proses'],
																	'id_pemberitahuan'			=>	$proses_pemberitahuan['id_pemberitahuan'],
																	'tujuan'					=>	$proses_pemberitahuan['tujuan'],
																	'tanggal'					=>	$proses_pemberitahuan['tanggal'],
																	'type'						=>	'DELETE',
																	'create_timestamp'			=>	$proses_pemberitahuan['create_timestamp'],
																	'create_user'				=>	$proses_pemberitahuan['create_user'],
																);
						$this->M_monitoring->inputProsesPemberitahuanHistory($inputProsesPemberitahuanHistory);
						$this->M_monitoring->deleteProsesPemberitahuan($proses_pemberitahuan['id_proses_pemberitahuan']);
					}

					foreach ($cekPemberitahuan as $pemberitahuan)
					{
						$id_pemberitahuan 	=	$pemberitahuan['id_pemberitahuan'];
						$tujuan 			=	$pemberitahuan['penerima'];

						$intervalPemberitahuan 	=	'P';

						$intervalPemberitahuanBulan 	=	0;
						$intervalPemberitahuanHari		=	0;

						if(!(empty($pemberitahuan['bulan'])))
						{
							$intervalPemberitahuanBulan +=	$pemberitahuan['bulan'];
						}

						if(!(empty($pemberitahuan['minggu']))) 
						{
							$intervalPemberitahuanHari	+=	($pemberitahuan['minggu']*7);
						}

						if(!(empty($pemberitahuan['hari']))) 
						{
							$intervalPemberitahuanHari	+=	($pemberitahuan['hari']);
						}

						$intervalPemberitahuan 			.=	$intervalPemberitahuanBulan.'M'.$intervalPemberitahuanHari.'D';

						$tanggal_akhir_pemberitahuan	=	$tanggal_awal_proses;
						$tanggal_awal_proses 			=	new DateTime($tanggal_awal_proses);
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
																	'id_proses'			=>	$id_proses[$i],
																	'id_pemberitahuan'	=>	$id_pemberitahuan,
																	'tujuan'			=>	$tujuan,
																	'tanggal'			=>	$tanggal_pemberitahuan,
																	'create_timestamp'	=>	$executionTimestamp,
																	'create_user'		=>	$this->session->user,
																);
								$id_proses_pemberitahuan	=	$this->M_monitoring->inputProsesPemberitahuan($inputProsesPemberitahuan);

								$inputProsesPemberitahuanHistory	=	array
																		(
																			'id_proses_pemberitahuan'	=>	$id_proses_pemberitahuan,
																			'id_proses'					=>	$id_proses[$i],
																			'id_pemberitahuan'			=>	$id_pemberitahuan,
																			'tujuan'					=>	$tujuan,
																			'tanggal'					=>	$tanggal_pemberitahuan,
																			'type'						=>	'CREATE',
																			'create_timestamp'			=>	$executionTimestamp,
																			'create_user'				=>	$this->session->user,
																		);
								$this->M_monitoring->inputProsesPemberitahuanHistory($inputProsesPemberitahuanHistory);
							}
						}
						else
						{
							$inputProsesPemberitahuan	=	array
															(
																'id_proses'			=>	$id_proses[$i],
																'id_pemberitahuan'	=>	$id_pemberitahuan,
																'tujuan'			=>	$tujuan,
																'tanggal'			=>	$tanggal_awal_pemberitahuan,
																'create_timestamp'	=>	$executionTimestamp,
																'create_user'		=>	$this->session->user,
															);
							$id_proses_pemberitahuan	=	$this->M_monitoring->inputProsesPemberitahuan($inputProsesPemberitahuan);

							$inputProsesPemberitahuanHistory	=	array
																	(
																		'id_proses_pemberitahuan'	=>	$id_proses_pemberitahuan,
																		'id_proses'					=>	$id_proses[$i],
																		'id_pemberitahuan'			=>	$id_pemberitahuan,
																		'tujuan'					=>	$tujuan,
																		'tanggal'					=>	$tanggal_awal_pemberitahuan,
																		'type'						=>	'CREATE',
																		'create_timestamp'			=>	$executionTimestamp,
																		'create_user'				=>	$this->session->user,
																	);
							$this->M_monitoring->inputProsesPemberitahuanHistory($inputProsesPemberitahuanHistory);
						}
					}
				}
			}

			if ( ! isset($selesai[$i]) )
			{
				$selesai[$i]	=	0;
			}

			if( $selesai[$i] == 1 )
			{
				$proses_selesai 	= 	array
										(
											'selesai'	=>	TRUE,
										);
				$this->M_monitoring->proses_selesai($proses_selesai, $id_proses[$i]);

				$pemberitahuan_selesai 	=	array
											(
												'selesai' 	=>	TRUE,
											);
				$this->M_monitoring->pemberitahuan_selesai($pemberitahuan_selesai, $id_proses[$i]);
			}
			else
			{
				$proses_selesai 	= 	array
										(
											'selesai'	=>	FALSE,
										);
				$this->M_monitoring->proses_selesai($proses_selesai, $id_proses[$i]);

				$pemberitahuan_selesai 	=	array
											(
												'selesai' 	=>	FALSE,
											);
				$this->M_monitoring->pemberitahuan_selesai($pemberitahuan_selesai, $id_proses[$i]);
			}
		}

		redirect('OnJobTraining/Monitoring');
	}

	public function pekerja_tunda()
	{
		$waktuEksekusi 			=	$this->general->ambilWaktuEksekusi();
		$user 					=	$this->session->user;

		$pekerja_id 		=	$this->general->dekripsi($this->input->post('txtPekerjaID', TRUE));
		$status_pdca 		=	$this->input->post('chkSelesaiPDCA', TRUE);

		$pekerjaKeluar 		=	array
								(
									'tunda' 				=>	TRUE,
									'tunda_selesai_pdca' 	=>	$status_pdca,
									'last_update_timestamp'	=>	$waktuEksekusi,
									'last_update_user'		=>	$user,
								);

		$this->M_monitoring->ubahPekerjaKeluar($pekerjaKeluar, $pekerja_id);
		redirect('OnJobTraining/Monitoring');
	}

	public function pekerja_keluar()
	{
		$waktuEksekusi 			=	$this->general->ambilWaktuEksekusi();
		$user 					=	$this->session->user;

		$pekerja_id 		=	$this->general->dekripsi($this->input->post('txtPekerjaID', TRUE));
		$keluar_tanggal		=	$this->input->post('txtTanggalKeluarPekerja', TRUE);
		$keluar_alasan 		=	strtoupper($this->input->post('txtAlasanKeluar', TRUE));

		$pekerjaKeluar 		=	array
								(
									'keluar' 				=>	TRUE,
									'keluar_tanggal' 		=>	$keluar_tanggal,
									'keluar_alasan' 		=>	$keluar_alasan,
									'last_update_timestamp'	=>	$waktuEksekusi,
									'last_update_user'		=>	$user,
								);

		$this->M_monitoring->ubahPekerjaKeluar($pekerjaKeluar, $pekerja_id);
		redirect('OnJobTraining/Monitoring');
	}

	public function pekerja_selesai()
	{
		$waktuEksekusi 			=	$this->general->ambilWaktuEksekusi();
		$user 					=	$this->session->user;

		$pekerja_id 		=	$this->general->dekripsi($this->input->post('txtPekerjaID', TRUE));

		$pekerja_selesai 		=	array
									(
										'selesai' 				=>	TRUE,
										'last_update_timestamp'	=>	$waktuEksekusi,
										'last_update_user'		=>	$user,
									);

		$this->M_monitoring->pekerja_selesai($pekerja_selesai, $pekerja_id);
		redirect('OnJobTraining/Monitoring');
	}

	public function ubah_email()
	{
		$waktuEksekusi 			=	$this->general->ambilWaktuEksekusi();
		$user 					=	$this->session->user;

		$pekerja_id 			=	$this->general->dekripsi($this->input->post('txtPekerjaID', TRUE));
		$email_pekerja 			=	$this->input->post('txtEmailPekerja', TRUE);
		$email_atasan	=	$this->input->post('txtEmailAtasan', TRUE);

		if ( empty($email_pekerja) )
		{
			$email_pekerja 		=	NULL;
		}

		if ( empty($email_atasan) )
		{
			$email_atasan 		=	NULL;
		}

		$updateEmail 	=	array
							(
								'email_pekerja' 	=>	$email_pekerja,
								'email_atasan'		=>	$email_atasan,
							);
		$this->M_monitoring->updateEmail($updateEmail, $pekerja_id);
		redirect('OnJobTraining/Monitoring');
	}

	// 	Untuk server-side Select2
	// 	{
			public function tambahPekerjaOJT()
			{
				$listPekerjaAktifOJT	=	$this->M_monitoring->ambilPekerjaAktifOJT();

				$pekerjaOJTAktif 		=	'';

				$indeks 				=	0;
				foreach ($listPekerjaAktifOJT as $listOJTAktif)
				{
					$pekerjaOJTAktif	.=	"'".$listOJTAktif['noind']."'";
					if($indeks<(count($listPekerjaAktifOJT)-1))
					{
						$pekerjaOJTAktif.=	", ";
					}
					$indeks++;
				}

				$keyword 			=	strtoupper($this->input->get('term'));

				$daftarPekerja 		=	$this->M_monitoring->ambilDaftarPekerjaOJT($keyword, $pekerjaOJTAktif);
				echo json_encode($daftarPekerja);
			}

			public function tambahAtasanPekerja()
			{
				$pekerjaOJT 		=	$this->input->get('pekerja');
				$keyword 			=	strtoupper($this->input->get('term'));

				$daftarAtasan 		=	$this->M_monitoring->ambilAtasanPekerja($keyword, $pekerjaOJT);
				echo json_encode($daftarAtasan);
			}

			public function daftar_pekerja_ojt()
			{
				$keyword 					=	strtoupper($this->input->get('term'));

				$daftar_pekerja_ojt 		=	$this->M_monitoring->daftar_pekerja_ojt($keyword);
				echo json_encode($daftar_pekerja_ojt);
			}

			public function tahapan_pekerja_ojt()
			{
				$keyword 		=	strtoupper($this->input->get('term'));
				$id_pekerja 	=	$this->input->get('id_pekerja');

				$tahapan_pekerja_ojt 	=	$this->M_monitoring->tahapan_pekerja_ojt($keyword, $id_pekerja);
				echo json_encode($tahapan_pekerja_ojt);
			}
	//	}
}
