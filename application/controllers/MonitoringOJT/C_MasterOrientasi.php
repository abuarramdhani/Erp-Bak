<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterOrientasi extends CI_Controller 
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
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Header']			=	'Monitoring OJT - Quick ERP';
		$data['Title']			=	'Master Orientasi';
		$data['Menu'] 			= 	'Master Orientasi';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['DaftarOrientasiTabel']					=	$this->M_masterorientasi->ambilDaftarOrientasiTabel();
		$data['DaftarOrientasiTabelKolomPemberitahuan']	=	$this->M_masterorientasi->ambilDaftarPemberitahuanTabelOrientasi();
		$data['DaftarOrientasiTabelKolomJadwal']		=	$this->M_masterorientasi->ambilDaftarPemberitahuanTabelJadwal();

		$data['DaftarOrientasi'] 						=	$this->M_masterorientasi->ambilDaftarOrientasi();
		$data['DaftarFormatCetak']						=	$this->M_masterorientasi->ambilDaftarCetak();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_MasterOrientasi_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	//	Pembuatan Orientasi Baru
	//	{
			public function OrientasiBaru_Save()
			{
				$this->checkSession();
				$user_id 	=	$this->session->userid;
				$user 		=	$this->session->user;

				$waktuEksekusi 	=	$this->general->ambilWaktuEksekusi();
				$actionType 	=	$this->input->post('actionType', TRUE);

				//	Orientasi Baru
				//	{
						$periodeBulan 		=	filter_var($this->input->post('numPeriodeBulan', TRUE), FILTER_SANITIZE_NUMBER_INT);
						$sequence 			=	filter_var($this->input->post('numSequence', TRUE), FILTER_SANITIZE_NUMBER_INT);
						$tahapan 			=	filter_var(strtoupper($this->input->post('txtTahapan', TRUE)), FILTER_SANITIZE_STRING);
						$tanggalOtomatis 	=	$this->input->post('radioTanggalOtomatis', TRUE);
						$lamaPelaksanaan 	=	filter_var($this->input->post('numLamaPelaksanaan', TRUE), FILTER_SANITIZE_NUMBER_INT);
						$cekEvaluasi 		=	$this->input->post('radioCekEvaluasi', TRUE);
						$pemberitahuan 		=	$this->input->post('radioPemberitahuan', TRUE);
						$cetak 				=	$this->input->post('radioCetak', TRUE);
						$formatCetak  		=	$this->input->post('cmbFormatCetak', TRUE);
						$keterangan  		=	$this->input->post('txtKeterangan', TRUE);

						if(empty($tanggalOtomatis))
						{
							$tanggalOtomatis 	=	FALSE;
						}

						if(empty($keterangan))
						{
							$keterangan 	=	NULL;
						}

						if(empty($formatCetak))
						{
							$formatCetak 	=	NULL;
						}

						if(empty($cekEvaluasi))
						{
							$cekEvaluasi 	=	FALSE;
						}

						if(empty($pemberitahuan))
						{
							$pemberitahuan 	=	FALSE;
						}

						if(empty($cetak))
						{
							$cetak 			=	FALSE;
						}

						$inputOrientasi 	=	array(
													'periode'			=>	$periodeBulan,
													'sequence'			=>	$sequence,
													'tahapan'			=>	$tahapan,
													'ck_tgl'			=>	$tanggalOtomatis,
													'lama_hari'			=>	$lamaPelaksanaan,
													'evaluasi'			=> 	$cekEvaluasi,
													'pemberitahuan'		=>	$pemberitahuan,
													'memo'				=>	$cetak,
													'id_memo'			=>	$formatCetak,
													'keterangan'		=>	$keterangan,
													'create_timestamp'	=>	$waktuEksekusi,
													'create_user' 		=>	$user,
												);
						echo '<pre>';
						print_r($inputOrientasi);
						echo '</pre>';

						$idOrientasi 	=	$this->M_masterorientasi->inputOrientasi($inputOrientasi);

						$inputOrientasiHistory 	=	array(
														'id_orientasi'		=>	$idOrientasi,
														'periode'			=>	$periodeBulan,
														'sequence'			=>	$sequence,
														'tahapan'			=>	$tahapan,
														'ck_tgl'			=>	$tanggalOtomatis,
														'lama_hari'			=>	$lamaPelaksanaan,
														'evaluasi'			=> 	$cekEvaluasi,
														'pemberitahuan'		=>	$pemberitahuan,
														'memo'				=>	$cetak,
														'id_memo'			=>	$formatCetak,
														'keterangan'		=>	$keterangan,
														'type'				=>	'CREATE',
														'create_timestamp'	=>	$waktuEksekusi,
														'create_user' 		=>	$user,
													);
						$this->M_masterorientasi->inputOrientasiHistory($inputOrientasiHistory);
				//	}

				// 	Jadwal
				//	{
						$jadwalIntervalHari 	=	filter_var($this->input->post('numJadwalIntervalHari', TRUE), FILTER_SANITIZE_NUMBER_INT);
						$jadwalIntervalMinggu 	=	filter_var($this->input->post('numJadwalIntervalMinggu', TRUE), FILTER_SANITIZE_NUMBER_INT);
						$jadwalIntervalBulan 	=	filter_var($this->input->post('numJadwalIntervalBulan', TRUE), FILTER_SANITIZE_NUMBER_INT);
						$jadwalPelaksanaan 		=	$this->input->post('cmbJadwalPelaksanaan', TRUE);
						$jadwalTahapan 			=	$this->input->post('cmbJadwalTahapan', TRUE);	

						if(strlen($jadwalIntervalHari)>0)
						{
							if($jadwalIntervalHari==0)
							{
								$jadwalIntervalHari				=	0;
							}
							else
							{
								$jadwalIntervalHari 			=	filter_var($jadwalIntervalHari, FILTER_SANITIZE_NUMBER_INT);
							}
						}
						else
						{
								$jadwalIntervalHari 			=	NULL;
						}

						echo $jadwalIntervalHari.'<br/>';

						if(strlen($jadwalIntervalMinggu)>0)
						{
							if($jadwalIntervalMinggu==0)
							{
								$jadwalIntervalMinggu 		=	0;
							}
							else
							{
								$jadwalIntervalMinggu 			=	filter_var($jadwalIntervalMinggu, FILTER_SANITIZE_NUMBER_INT);
							}
						}
						else
						{
							$jadwalIntervalMinggu 			=	NULL;
						}

						if(strlen($jadwalIntervalBulan)>0)
						{
							if($jadwalIntervalBulan==0)
							{
								$jadwalIntervalBulan 		=	0;
							}
							else
							{
								$jadwalIntervalBulan 			=	filter_var($jadwalIntervalBulan, FILTER_SANITIZE_NUMBER_INT);
							}
						}
						else
						{
							$jadwalIntervalBulan 			=	NULL;
						}

						if
							(
								($jadwalIntervalHari>=0 OR $jadwalIntervalMinggu>=0 OR $jadwalIntervalBulan>=0) 
								AND $jadwalPelaksanaan
								AND !(empty($jadwalTahapan))
							)
						{
							$inputJadwal 		=	array(
														'id_orientasi'		=>	$idOrientasi,
														'hari'				=>	$jadwalIntervalHari,
														'minggu'			=>	$jadwalIntervalMinggu,
														'bulan'				=>	$jadwalIntervalBulan,
														'urutan'			=>	$jadwalPelaksanaan,
														'tujuan'			=>	$jadwalTahapan,
														'create_timestamp'	=>	$waktuEksekusi,
														'create_user' 		=>	$user,
													);
							echo '<pre>';
							print_r($inputJadwal);
							echo '</pre>';

							$idJadwal 			=	$this->M_masterorientasi->inputJadwal($inputJadwal);

							$inputJadwalHistory 		=	array(
																'id_jadwal'			=>	$idJadwal,
																'id_orientasi'		=>	$idOrientasi,
																'hari'				=>	$jadwalIntervalHari,
																'minggu'			=>	$jadwalIntervalMinggu,
																'bulan'				=>	$jadwalIntervalBulan,
																'urutan'			=>	$jadwalPelaksanaan,
																'tujuan'			=>	$jadwalTahapan,
																'type'				=>	'CREATE',
																'create_timestamp'	=>	$waktuEksekusi,
																'create_user' 		=>	$user,
															);
							$this->M_masterorientasi->inputJadwalHistory($inputJadwalHistory);
						}
				//	}

				//	Pemberitahuan
				//	{
						$idPemberitahuan 				=	$this->input->post('idPemberitahuan', TRUE);
						$pemberitahuanAllDay 			=	$this->input->post('chkPemberitahuanAllDay', TRUE);
						$pemberitahuanIntervalHari		=	$this->input->post('numPemberitahuanIntervalHari', TRUE);
						$pemberitahuanIntervalMinggu	=	$this->input->post('numPemberitahuanIntervalMinggu', TRUE);
						$pemberitahuanIntervalBulan 	=	$this->input->post('numPemberitahuanIntervalBulan', TRUE);
						$pemberitahuanPelaksanaan		=	$this->input->post('cmbPemberitahuanPelaksanaan', TRUE);
						$pemberitahuanTujuan 			=	$this->input->post('cmbPemberitahuanTujuan', TRUE);

						echo '<pre>';
						print_r($idPemberitahuan);
						echo '</pre>';

						echo '<pre>';
						print_r($pemberitahuanIntervalHari);
						echo '</pre>';

						for ($i = 0; $i < count($idPemberitahuan); $i++) 
						{
							if(strlen($pemberitahuanIntervalHari[$i])>0)
							{
								if($pemberitahuanIntervalHari[$i]==0)
								{
									$pemberitahuanIntervalHari[$i] 		=	0;
								}
								else
								{
									$pemberitahuanIntervalHari[$i] 			=	filter_var($pemberitahuanIntervalHari[$i], FILTER_SANITIZE_NUMBER_INT);
								}
							}
							else
							{
								$pemberitahuanIntervalHari[$i] 			=	NULL;
							}

							echo $pemberitahuanIntervalHari[$i].'<br/>';

							if(strlen($pemberitahuanIntervalMinggu[$i])>0)
							{
								if($pemberitahuanIntervalMinggu[$i]==0)
								{
									$pemberitahuanIntervalMinggu[$i] 		=	0;
								}
								else
								{
									$pemberitahuanIntervalMinggu[$i] 			=	filter_var($pemberitahuanIntervalMinggu[$i], FILTER_SANITIZE_NUMBER_INT);
								}
							}
							else
							{
								$pemberitahuanIntervalMinggu[$i] 			=	NULL;
							}

							if(strlen($pemberitahuanIntervalBulan[$i])>0)
							{
								if($pemberitahuanIntervalBulan[$i]==0)
								{
									$pemberitahuanIntervalBulan[$i] 		=	0;
								}
								else
								{
									$pemberitahuanIntervalBulan[$i] 			=	filter_var($pemberitahuanIntervalBulan[$i], FILTER_SANITIZE_NUMBER_INT);
								}
							}
							else
							{
								$pemberitahuanIntervalBulan[$i] 			=	NULL;
							}

							
							if(!(isset($pemberitahuanAllDay)))
							{
								$pemberitahuanAllDay 		=	0;
							}

							// //	Trial
							// //	{
							// 		echo var_dump($pemberitahuanIntervalHari[$i]).'<br/>';
							// 		echo var_dump($pemberitahuanIntervalMinggu[$i]).'<br/>';
							// 		echo var_dump($pemberitahuanIntervalBulan[$i]).'<br/>';
							// 		echo var_dump($pemberitahuanPelaksanaan[$i]).'<br/>';
							// 		echo var_dump($pemberitahuanTujuan[$i]).'<br/>';
							// 		echo ($pemberitahuanIntervalHari[$i]).'<br/>';
							// 		echo ($pemberitahuanIntervalMinggu[$i]).'<br/>';
							// 		echo ($pemberitahuanIntervalBulan[$i]).'<br/>';
							// 		echo ($pemberitahuanPelaksanaan[$i]).'<br/>';
							// 		echo ($pemberitahuanTujuan[$i]).'<br/>';

							// 		if($pemberitahuanIntervalHari>=0)
							// 		{
							// 			echo '\$pemberitahuanIntervalHari memiliki value<br/>';
							// 		}
							// 		else
							// 		{
							// 			echo '\$pemberitahuanIntervalHari tidak memiliki value<br/>';
							// 		}

							// 		if($pemberitahuanIntervalMinggu>=0)
							// 		{
							// 			echo '\$pemberitahuanIntervalMinggu memiliki value<br/>';
							// 		}
							// 		else
							// 		{
							// 			echo '\$pemberitahuanIntervalMinggu tidak memiliki value<br/>';
							// 		}

							// 		if($pemberitahuanIntervalBulan>=0)
							// 		{
							// 			echo '\$pemberitahuanIntervalBulan memiliki value<br/>';
							// 		}
							// 		else
							// 		{
							// 			echo '\$pemberitahuanIntervalBulan tidak memiliki value<br/>';
							// 		}

							// //	}

							if
							(
								($pemberitahuanIntervalHari[$i]>=0 OR $pemberitahuanIntervalMinggu[$i]>=0 OR $pemberitahuanIntervalBulan[$i]>=0) 
								AND $pemberitahuanPelaksanaan[$i]>=0
								AND !(empty($pemberitahuanTujuan[$i]))
							)
							{
								$inputPemberitahuan 			=	array(
																		'id_orientasi'		=>	$idOrientasi,
																		'pengulang'			=>	$pemberitahuanAllDay[$i],
																		'hari'				=>	$pemberitahuanIntervalHari[$i],
																		'minggu'			=>	$pemberitahuanIntervalMinggu[$i],
																		'bulan'				=>	$pemberitahuanIntervalBulan[$i],
																		'urutan'			=>	$pemberitahuanPelaksanaan[$i],
																		'penerima'			=>	$pemberitahuanTujuan[$i],
																		'create_timestamp'	=>	$waktuEksekusi,
																		'create_user' 		=>	$user,
																	);
								echo '<pre>';
								print_r($inputPemberitahuan);
								echo '</pre>';

								$idPemberitahuan[$i] 				=	$this->M_masterorientasi->inputPemberitahuan($inputPemberitahuan);

								$inputPemberitahuanHistory 			=	array(
																			'id_pemberitahuan'	=>	$idPemberitahuan[$i],
																			'id_orientasi'		=>	$idOrientasi,
																			'pengulang'			=>	$pemberitahuanAllDay[$i],
																			'hari'				=>	$pemberitahuanIntervalHari[$i],
																			'minggu'			=>	$pemberitahuanIntervalMinggu[$i],
																			'bulan'				=>	$pemberitahuanIntervalBulan[$i],
																			'urutan'			=>	$pemberitahuanPelaksanaan[$i],
																			'penerima'			=>	$pemberitahuanTujuan[$i],
																			'type'				=>	'CREATE',
																			'create_timestamp'	=>	$waktuEksekusi,
																			'create_user' 		=>	$user,
																		);
								$this->M_masterorientasi->inputPemberitahuanHistory($inputPemberitahuanHistory);
							}

						}

				//	}

				// 	Undangan
				//	{
						$idUndangan 					=	$this->input->post('idUndangan', TRUE);
						$undanganIntervalHari 			=	$this->input->post('numUndanganIntervalHari', TRUE);
						$undanganIntervalMinggu 		=	$this->input->post('numUndanganIntervalMinggu', TRUE);
						$undanganIntervalBulan 			=	$this->input->post('numUndanganIntervalBulan', TRUE);
						$undanganPelaksanaan 			=	$this->input->post('cmbUndanganPelaksanaan', TRUE);
						$undanganTujuan 				=	$this->input->post('cmbUndanganTujuan', TRUE);

						for ($k = 0; $k < count($idPemberitahuan); $k++)
						{

							if(strlen($undanganIntervalHari[$k])>0)
							{
								if($undanganIntervalHari[$k]==0)
								{
									$undanganIntervalHari[$k] 		=	0;
								}
								else
								{
									$undanganIntervalHari[$k] 			=	filter_var($undanganIntervalHari[$k], FILTER_SANITIZE_NUMBER_INT);
								}
							}
							else
							{
								$undanganIntervalHari[$k] 			=	NULL;
							}

							if(strlen($undanganIntervalMinggu[$k])>0)
							{
								if($undanganIntervalMinggu[$k]==0)
								{
									$undanganIntervalMinggu[$k] 		=	0;
								}
								else
								{
									$undanganIntervalMinggu[$k] 			=	filter_var($undanganIntervalMinggu[$k], FILTER_SANITIZE_NUMBER_INT);
								}
							}
							else
							{
								$undanganIntervalMinggu[$k] 			=	NULL;
							}

							if(strlen($undanganIntervalBulan[$k])>0)
							{
								if($undanganIntervalBulan[$k]==0)
								{
									$undanganIntervalBulan[$k] 		=	0;
								}
								else
								{
									$undanganIntervalBulan[$k] 			=	filter_var($undanganIntervalBulan[$k], FILTER_SANITIZE_NUMBER_INT);
								}
							}
							else
							{
								$undanganIntervalBulan[$k] 			=	NULL;
							}

							if
							(
								($undanganIntervalHari[$k]>=0 OR $undanganIntervalMinggu[$k]>=0 OR $undanganIntervalBulan[$k]>=0)
								AND $undanganPelaksanaan[$k]>=0
								AND !(empty($undanganTujuan[$k])))
							{
								$inputUndangan 					= 	array(
																		'id_orientasi'		=>	$idOrientasi,
																		'hari'				=>	$undanganIntervalHari[$k],
																		'minggu'			=>	$undanganIntervalMinggu[$k],
																		'bulan'				=>	$undanganIntervalBulan[$k],
																		'urutan'			=>	$undanganPelaksanaan[$k],
																		'penerima'			=>	$undanganTujuan[$k],
																		'create_timestamp'	=>	$waktuEksekusi,
																		'create_user' 		=>	$user,
																	);
								echo '<pre>';
								print_r($inputUndangan);
								echo '</pre>';

								$idUndangan[$k]					=	$this->M_masterorientasi->inputUndangan($inputUndangan);

								$inputUndanganHistory 					= 	array(
																				'id_berkas'			=>	$idUndangan[$k],
																				'id_orientasi'		=>	$idOrientasi,
																				'hari'				=>	$undanganIntervalHari[$k],
																				'minggu'			=>	$undanganIntervalMinggu[$k],
																				'bulan'				=>	$undanganIntervalBulan[$k],
																				'urutan'			=>	$undanganPelaksanaan[$k],
																				'penerima'			=>	$undanganTujuan[$k],
																				'type'				=>	'CREATE',
																				'create_timestamp'	=>	$waktuEksekusi,
																				'create_user' 		=>	$user,
																			);

							}
						}

				//	}
				redirect('OnJobTraining/MasterOrientasi');
			}

			public function OrientasiBaru_Delete($id_orientasi)
			{
				
			}
	//	}

}
