<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterOrientasi extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('General');
		$this->load->library('MonitoringOJT');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_masterorientasi');
		$this->load->model('MonitoringOJT/M_masterundangan');


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
		$data['Title']			=	'Master Orientasi';
		$data['Menu'] 			= 	'Master Orientasi';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['DaftarOrientasiTabel']					=	$this->M_masterorientasi->ambilDaftarOrientasiTabel();
		// echo "<pre>"; print_r($data['DaftarOrientasiTabel']); exit();
		$data['DaftarOrientasiTabelKolomPemberitahuan']	=	$this->M_masterorientasi->ambilDaftarPemberitahuanTabelOrientasi();
		$data['DaftarOrientasiTabelKolomJadwal']		=	$this->M_masterorientasi->ambilDaftarPemberitahuanTabelJadwal();

		$data['DaftarOrientasi'] 						=	$this->M_masterorientasi->ambilDaftarOrientasi();

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
						$pemberitahuan 		=	$this->input->post('radioPemberitahuan', TRUE);
						/*$cetak 				=	$this->input->post('radioCetak', TRUE);*/
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

						/*if(empty($cetak))
						{
							$cetak 			=	FALSE;
						}*/

						$inputOrientasi 	=	array(
													'periode'			=>	$periodeBulan,
													'sequence'			=>	$sequence,
													'tahapan'			=>	$tahapan,
													'ck_tgl'			=>	$tanggalOtomatis,
													'lama_hari'			=>	$lamaPelaksanaan,
													'pemberitahuan'		=>	$pemberitahuan,
													/*'memo'				=>	$cetak,
													'id_memo'			=>	$formatCetak,*/
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
														'pemberitahuan'		=>	$pemberitahuan,
														/*'memo'				=>	$cetak,
														'id_memo'			=>	$formatCetak,*/
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
								AND $jadwalPelaksanaan>=0
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

							
							if(empty($pemberitahuanAllDay[$i]))
							{
								$pemberitahuanAllDay[$i] 		=	FALSE;	
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

				/*// 	Undangan
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
								$this->M_masterorientasi->inputUndanganHistory($inputUndanganHistory);
							}
						}

				//	}*/
				redirect('OnJobTraining/MasterOrientasi');
			}

			public function OrientasiBaru_Delete($id_orientasi)
			{
				// $id_orientasi_decode 	=	$this->general->dekripsi($id_orientasi);
				$id_orientasi_decode = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_orientasi);
				$id_orientasi_decode = $this->encrypt->decode($id_orientasi_decode);
				// echo $id_orientasi_decode; exit();

				$this->monitoringojt->ojt_history('ojt', 'tb_orientasi', array('id_orientasi' => $id_orientasi_decode), 'DELETE');
				$this->monitoringojt->ojt_history('ojt', 'tb_jadwal', array('id_orientasi' => $id_orientasi_decode), 'DELETE');
				$this->monitoringojt->ojt_history('ojt', 'tb_pemberitahuan', array('id_orientasi' => $id_orientasi_decode), 'DELETE');

				$this->M_masterorientasi->tb_orientasi_delete(array('id_orientasi' => $id_orientasi_decode));
				$this->M_masterorientasi->tb_jadwal_delete(array('id_orientasi' => $id_orientasi_decode));
				$this->M_masterorientasi->tb_pemberitahuan_delete(array('id_orientasi' => $id_orientasi_decode));

				redirect('OnJobTraining/MasterOrientasi/');
			}

			public function OrientasiBaru_Update($id_orientasi)
			{
				$id_orientasi_decode = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_orientasi);
				$id_orientasi_decode = $this->encrypt->decode($id_orientasi_decode);
				echo $id_orientasi_decode; exit();

				$this->form_validation->set_rules('numPeriodeBulan', 'Periode Bulan Orientasi', 'required');
				$this->form_validation->set_rules('numSequence', 'Sequence Orientasi', 'required');
				$this->form_validation->set_rules('txtTahapan', 'Nama Tahapan Orientasi', 'required');

				if($this->form_validation->run() === FALSE)
				{
					$user_id = $this->session->userid;

					$data['Header']			=	'Monitoring OJT - Quick ERP';
					$data['Title']			=	'Master Orientasi';
					$data['Menu'] 			= 	'Master Orientasi';
					$data['SubMenuOne'] 	= 	'';
					$data['SubMenuTwo'] 	= 	'';
					
					$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
					$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
					$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
					$data['id']				=	$id_orientasi;

					$data['DaftarOrientasi'] 				=	$this->M_masterorientasi->ambilDaftarOrientasi();
					$data['editOrientasi']					=	$this->M_masterorientasi->editOrientasi($id_orientasi_decode);
					$data['editPemberitahuanOrientasi']		=	$this->M_masterorientasi->editPemberitahuanOrientasi($id_orientasi_decode);
					/*$data['editUndanganOrientasi']			=	$this->M_masterorientasi->editUndanganOrientasi($id_orientasi_decode);*/

					// echo '<pre>';
					// print_r($data['editUndanganOrientasi']);
					// echo '</pre>';
					// exit();

					$this->load->view('V_Header',$data);
					$this->load->view('V_Sidemenu',$data);
					$this->load->view('MonitoringOJT/V_MasterOrientasi_Update',$data);
					$this->load->view('V_Footer',$data);
				}
				else
				{
					$user_id 		=	$this->session->userid;
					$user 			=	$this->session->user;

					$waktuEksekusi 	=	$this->general->ambilWaktuEksekusi();

					//	Orientasi Baru
					//	{
							$periodeBulan 		=	filter_var($this->input->post('numPeriodeBulan', TRUE), FILTER_SANITIZE_NUMBER_INT);
							$sequence 			=	filter_var($this->input->post('numSequence', TRUE), FILTER_SANITIZE_NUMBER_INT);
							$tahapan 			=	filter_var(strtoupper($this->input->post('txtTahapan', TRUE)), FILTER_SANITIZE_STRING);
							$tanggalOtomatis 	=	$this->input->post('radioTanggalOtomatis', TRUE);
							$lamaPelaksanaan 	=	filter_var($this->input->post('numLamaPelaksanaan', TRUE), FILTER_SANITIZE_NUMBER_INT);
							$pemberitahuan 		=	$this->input->post('radioPemberitahuan', TRUE);
							/*$cetak 				=	$this->input->post('radioCetak', TRUE);*/
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

							/*if(empty($cetak))
							{
								$cetak 			=	FALSE;
							}*/

							$updateOrientasi 	=	array
													(
														'periode'				=>	$periodeBulan,
														'sequence'				=>	$sequence,
														'tahapan'				=>	$tahapan,
														'ck_tgl'				=>	$tanggalOtomatis,
														'lama_hari'				=>	$lamaPelaksanaan,
														'pemberitahuan'			=>	$pemberitahuan,
														/*'memo'					=>	$cetak,
														'id_memo'				=>	$formatCetak,*/
														'keterangan'			=>	$keterangan,
														'last_update_timestamp'	=>	$waktuEksekusi,
														'last_update_user' 		=>	$user,
													);
							$this->M_masterorientasi->updateOrientasi($updateOrientasi, $id_orientasi_decode);

							echo '<pre>';
							print_r($updateOrientasi);
							echo '</pre>';

							$updateOrientasiHistory	=	array
														(
															'id_orientasi'		=>	$id_orientasi_decode,
															'periode'			=>	$periodeBulan,
															'sequence'			=>	$sequence,
															'tahapan'			=>	$tahapan,
															'ck_tgl'			=>	$tanggalOtomatis,
															'lama_hari'			=>	$lamaPelaksanaan,
															'pemberitahuan'		=>	$pemberitahuan,
															/*'memo'				=>	$cetak,
															'id_memo'			=>	$formatCetak,*/
															'keterangan'		=>	$keterangan,
															'type'				=>	'UPDATE',
															'update_timestamp'	=>	$waktuEksekusi,
															'update_user' 		=>	$user,
														);
							$this->M_masterorientasi->inputOrientasiHistory($updateOrientasiHistory);
							echo '<pre>';
							print_r($updateOrientasiHistory);
							echo '</pre>';
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
									AND $jadwalPelaksanaan>=0
									AND !(empty($jadwalTahapan))
								)
							{
								$updateJadwal 		=	array(
															'id_orientasi'			=>	$id_orientasi_decode,
															'hari'					=>	$jadwalIntervalHari,
															'minggu'				=>	$jadwalIntervalMinggu,
															'bulan'					=>	$jadwalIntervalBulan,
															'urutan'				=>	$jadwalPelaksanaan,
															'tujuan'				=>	$jadwalTahapan,
															'last_update_timestamp'	=>	$waktuEksekusi,
															'last_update_user' 		=>	$user,
														);
								echo '<pre>';
								print_r($updateJadwal);
								echo '</pre>';

								$this->M_masterorientasi->updateJadwal($updateJadwal, $id_orientasi_decode);

								$jadwal 	=	$this->M_masterorientasi->cekIDJadwal($id_orientasi_decode);
								$idJadwal 	=	$jadwal[0]['id_jadwal'];

								$updateJadwalHistory 		=	array(
																	'id_jadwal'			=>	$idJadwal,
																	'id_orientasi'		=>	$id_orientasi_decode,
																	'hari'				=>	$jadwalIntervalHari,
																	'minggu'			=>	$jadwalIntervalMinggu,
																	'bulan'				=>	$jadwalIntervalBulan,
																	'urutan'			=>	$jadwalPelaksanaan,
																	'tujuan'			=>	$jadwalTahapan,
																	'type'				=>	'UPDATE',
																	'update_timestamp'	=>	$waktuEksekusi,
																	'update_user' 		=>	$user,
																);
								echo '<pre>';
								print_r($updateJadwalHistory);
								echo '</pre>';

								$this->M_masterorientasi->inputJadwalHistory($updateJadwalHistory);
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

							$indeksIDPemberitahuan 				=	array();
							if(!(empty($idPemberitahuan)))
							{
								$indeksIDPemberitahuan 			=	array_keys($idPemberitahuan);
							}

							if(count($indeksIDPemberitahuan)>0)
							{
								$idPemberitahuanUsed 		=	array();
								for ($k = 0; $k < count($indeksIDPemberitahuan); $k++)
								{
									if($idPemberitahuan[$indeksIDPemberitahuan[$k]]!='')
									{
										$idPemberitahuanUsed[$k] 	=	$this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $idPemberitahuan[$indeksIDPemberitahuan[$k]]));
									}
								}
								if(empty($idPemberitahuanUsed))
								{
									$idPemberitahuanUsed 	=	NULL;
								}

								$pemberitahuanDeleted 		=	$this->M_masterorientasi->ambilPemberitahuanDeleted($id_orientasi_decode, $idPemberitahuanUsed);

								foreach ($pemberitahuanDeleted as $deleted) 
								{
									$penerima 	=	FALSE;

									if($deleted['pengulang']=='t')
									{
										$penerima 	=	TRUE;
									}

									if($deleted['hari']=='')
									{
										$deleted['hari'] 	=	NULL;
									}

									if($deleted['minggu']=='')
									{
										$deleted['minggu'] 	=	NULL;
									}

									if($deleted['bulan']=='')
									{
										$deleted['bulan'] 	=	NULL;
									}

									$inputDeletedPemberitahuanHistory 		=	array
																				(
																					'id_pemberitahuan' 	=>	$deleted['id_pemberitahuan'],
																					'id_orientasi'		=>	$deleted['id_orientasi'],
																					'pengulang' 		=>	$penerima,
																					'hari'				=>	$deleted['hari'],
																					'minggu'			=>	$deleted['minggu'],
																					'bulan'				=>	$deleted['bulan'],
																					'urutan' 			=>	$deleted['urutan'],
																					'penerima' 			=>	$deleted['penerima'],
																					'type'				=>	'DELETE',
																					'delete_timestamp'	=>	$waktuEksekusi,
																					'delete_user' 		=>	$user
																				);

									echo '<pre>';
									print_r($inputDeletedPemberitahuanHistory);
									echo '</pre>';

									$this->M_masterorientasi->inputPemberitahuanHistory($inputDeletedPemberitahuanHistory);
									$this->M_masterorientasi->deleteUnusedPemberitahuan($id_orientasi_decode, $idPemberitahuanUsed);
								}

								for ($k = 0; $k < count($indeksIDPemberitahuan); $k++)
								{
									if($idPemberitahuan[$indeksIDPemberitahuan[$k]]!='')
									{
										$idPemberitahuan[$k] 	=	$this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $idPemberitahuan[$indeksIDPemberitahuan[$k]]));
									}
								}

								for ($i = 0; $i < count($indeksIDPemberitahuan); $i++) 
								{
									if(strlen($pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]])>0)
									{
										if($pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]]==0)
										{
											$pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]] 		=	0;
										}
										else
										{
											$pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]] 			=	filter_var($pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]], FILTER_SANITIZE_NUMBER_INT);
										}
									}
									else
									{
										$pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]] 			=	NULL;
									}

									echo $pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]].'<br/>';

									if(strlen($pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]])>0)
									{
										if($pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]]==0)
										{
											$pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]] 		=	0;
										}
										else
										{
											$pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]] 			=	filter_var($pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]], FILTER_SANITIZE_NUMBER_INT);
										}
									}
									else
									{
										$pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]] 			=	NULL;
									}

									if(strlen($pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]])>0)
									{
										if($pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]]==0)
										{
											$pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]] 		=	0;
										}
										else
										{
											$pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]] 			=	filter_var($pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]], FILTER_SANITIZE_NUMBER_INT);
										}
									}
									else
									{
										$pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]] 			=	NULL;
									}

									
									if(empty($pemberitahuanAllDay[$indeksIDPemberitahuan[$i]]))
									{
										$pemberitahuanAllDay[$indeksIDPemberitahuan[$i]] 		=	FALSE;	
									}

									// //	Trial
									// //	{
									// 		echo var_dump($pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo var_dump($pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo var_dump($pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo var_dump($pemberitahuanPelaksanaan[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo var_dump($pemberitahuanTujuan[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo ($pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo ($pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo ($pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo ($pemberitahuanPelaksanaan[$indeksIDPemberitahuan[$i]]).'<br/>';
									// 		echo ($pemberitahuanTujuan[$indeksIDPemberitahuan[$i]]).'<br/>';

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
										($pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]]>=0 OR $pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]]>=0 OR $pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]]>=0) 
										AND $pemberitahuanPelaksanaan[$indeksIDPemberitahuan[$i]]>=0
										AND !(empty($pemberitahuanTujuan[$indeksIDPemberitahuan[$i]]))
									)
									{
										if(!(empty($idPemberitahuan[$indeksIDPemberitahuan[$i]])))
										{
											$updatePemberitahuan 			=	array(
																					'id_orientasi'			=>	$id_orientasi_decode,
																					'pengulang'				=>	$pemberitahuanAllDay[$indeksIDPemberitahuan[$i]],
																					'hari'					=>	$pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]],
																					'minggu'				=>	$pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]],
																					'bulan'					=>	$pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]],
																					'urutan'				=>	$pemberitahuanPelaksanaan[$indeksIDPemberitahuan[$i]],
																					'penerima'				=>	$pemberitahuanTujuan[$indeksIDPemberitahuan[$i]],
																					'last_update_timestamp'	=>	$waktuEksekusi,
																					'last_update_user' 		=>	$user,
																				);
											echo '<pre>';
											print_r($updatePemberitahuan);
											echo '</pre>';

											$this->M_masterorientasi->updatePemberitahuan($updatePemberitahuan, $idPemberitahuanUsed[$indeksIDPemberitahuan[$i]]);

											$inputPemberitahuanHistory 			=	array(
																						'id_pemberitahuan'	=>	$idPemberitahuan[$indeksIDPemberitahuan[$i]],
																						'id_orientasi'		=>	$id_orientasi_decode,
																						'pengulang'			=>	$pemberitahuanAllDay[$indeksIDPemberitahuan[$i]],
																						'hari'				=>	$pemberitahuanIntervalHari[$indeksIDPemberitahuan[$i]],
																						'minggu'			=>	$pemberitahuanIntervalMinggu[$indeksIDPemberitahuan[$i]],
																						'bulan'				=>	$pemberitahuanIntervalBulan[$indeksIDPemberitahuan[$i]],
																						'urutan'			=>	$pemberitahuanPelaksanaan[$indeksIDPemberitahuan[$i]],
																						'penerima'			=>	$pemberitahuanTujuan[$indeksIDPemberitahuan[$i]],
																						'type'				=>	'UPDATE',
																						'update_timestamp'	=>	$waktuEksekusi,
																						'update_user' 		=>	$user,
																					);
											$this->M_masterorientasi->inputPemberitahuanHistory($inputPemberitahuanHistory);
										}
										else
										{
											$inputPemberitahuan 			=	array(
																					'id_orientasi'		=>	$id_orientasi_decode,
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

											$idPemberitahuan  				=	$this->M_masterorientasi->inputPemberitahuan($inputPemberitahuan);

											$inputPemberitahuanHistory 			=	array(
																						'id_pemberitahuan'	=>	$idPemberitahuan,
																						'id_orientasi'		=>	$id_orientasi_decode,
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

								}
							}
					//	}

					redirect('OnJobTraining/MasterOrientasi/');
				}
			}
	//	}

	//	Untuk Server-side Select2
	//	{
			public function daftarFormatCetak()
			{
				$keyword 	=	strtoupper($this->input->get('term'));

				$daftarFormatCetak 	=	$this->M_masterundangan->ambilDaftarFormatUndangan(FALSE, $keyword);
				echo json_encode($daftarFormatCetak);
			}
	//	}
}
