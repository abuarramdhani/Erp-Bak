<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class C_SinkronisasiKonversiPresensi extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();

	        $this->load->library('General');
			$this->load->library('Log_Activity');
	        $this->load->library('Lib_SinkronisasiKonversiPresensi');

			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('er/M_sinkronisasikonversipresensi');

			if($this->session->userdata('logged_in')!=TRUE)
			{
				$this->session->set_userdata('last_page', current_url());
			}
			set_time_limit(0);
	    }

		public function checkSession()
		{
			if(!($this->session->is_logged))
			{
				redirect();
			}
		}

		public function index()
		{
			$this->checkSession();

			$data 	=	$this->general->loadHeaderandSidemenu('Sinkronisasi Konversi Presensi - Quick ERP', 'Sinkronisasi Konversi Presensi', 'Sinkronisasi Konversi Presensi');

			$this->form_validation->set_rules('txtTanggalSinkronisasi', 'Tanggal Sinkronisasi', 'required');

			if($this->form_validation->run() === FALSE)
			{
				$this->load->view('V_Header', $data);
				$this->load->view('V_Sidemenu', $data);
				$this->load->view('er/SinkronisasiKonversiPresensi/V_index', $data);
				$this->load->view('V_Footer', $data);
			}
			else
			{
				$tanggal_sinkronisasi 				=	$this->input->post('txtTanggalSinkronisasi', TRUE);
				$kode_status_kerja 					=	$this->input->post('cmbKodeStatusKerja', TRUE);
				$noind 								=	$this->input->post('cmbNoind', TRUE);
				$kode_shift 						=	$this->input->post('cmbKodeShift', TRUE);
				$kodesie 							=	$this->input->post('cmbKodesie', TRUE);
				$lokasi_kerja 						=	$this->input->post('cmbLokasiKerja', TRUE);
				$kode_jabatan						=	$this->input->post('cmbJabatan', TRUE);

				$tanggal_sinkronisasi 			=	explode(' - ', $tanggal_sinkronisasi);
				$tanggal_awal 					=	$tanggal_sinkronisasi[0];
				$tanggal_akhir					=	$tanggal_sinkronisasi[1];

				$parameter_kode_status_kerja	=	'';
				$parameter_noind 				=	'';
				$parameter_kode_shift 			=	'';
				$parameter_kodesie 				=	'';
				$parameter_lokasi_kerja 		=	'';
				$parameter_kode_jabatan 		=	'';

				$indeks_kode_status_kerja 	=	0;
				$jumlah_kode_status_kerja	=	count($kode_status_kerja);
				$value_kode_status_kerja	=	'';
				if ( ! (empty($kode_status_kerja)) )
				{
					foreach ($kode_status_kerja as $kode_status)
					{
						$value_kode_status_kerja 	.=	"'".$kode_status."'";
						if ( $indeks_kode_status_kerja < ($jumlah_kode_status_kerja - 1) )
						{
							$value_kode_status_kerja 	.=	", ";
						}
						$indeks_kode_status_kerja++;
					}
					$parameter_kode_status_kerja 	=	"and substring(tshiftpekerja.noind, 1, 1) in (".$value_kode_status_kerja.")";
				}

				$indeks_noind 	=	0;
				$jumlah_noind	=	count($noind);
				$value_noind	=	'';
				if ( ! (empty($noind)) )
				{
					foreach ($noind as $nomor_induk)
					{
						$value_noind 	.=	"'".$nomor_induk."'";
						if ( $indeks_noind < ($jumlah_noind - 1) )
						{
							$value_noind 	.=	", ";
						}
						$indeks_noind++;
					}
					$parameter_noind 	=	"and tshiftpekerja.noind in (".$value_noind.")";
				}

				$indeks_kode_shift 	=	0;
				$jumlah_kode_shift	=	count($kode_shift);
				$value_kode_shift	=	'';
				if ( ! (empty($kode_shift)) )
				{
					foreach ($kode_shift as $kd_shift)
					{
						$value_kode_shift 	.=	"'".$kd_shift."'";
						if ( $indeks_kode_shift < ($jumlah_kode_shift - 1) )
						{
							$value_kode_shift 	.=	", ";
						}
						$indeks_kode_shift++;
					}
					$parameter_kode_shift 	=	"and tshiftpekerja.kd_shift in (".$value_kode_shift.")";
				}

				$indeks_kodesie 	=	0;
				$jumlah_kodesie	=	count($kodesie);
				$value_kodesie	=	'';
				if ( ! (empty($kodesie)) )
				{
					foreach ($kodesie as $kdsie)
					{
						$value_kodesie 	.=	"'".$kdsie."'";
						if ( $indeks_kodesie < ($jumlah_kodesie - 1) )
						{
							$value_kodesie 	.=	"|";
						}
						$indeks_kodesie++;
					}
					$parameter_kodesie 	=	"and tshiftpekerja.kodesie similar to '(".$value_kodesie.")%'";
				}

				$indeks_lokasi_kerja 	=	0;
				$jumlah_lokasi_kerja	=	count($lokasi_kerja);
				$value_lokasi_kerja	=	'';
				if ( ! (empty($lokasi_kerja)) )
				{
					foreach ($lokasi_kerja as $lokasikerja)
					{
						$value_lokasi_kerja 	.=	"'".$lokasikerja."'";
						if ( $indeks_lokasi_kerja < ($jumlah_lokasi_kerja - 1) )
						{
							$value_lokasi_kerja 	.=	", ";
						}
						$indeks_lokasi_kerja++;
					}
					$parameter_lokasi_kerja 	=	"and tshiftpekerja.lokasi_kerja in (".$value_lokasi_kerja.")";
				}

				$indeks_kode_jabatan 	=	0;
				$jumlah_kode_jabatan	=	count($kode_jabatan);
				$value_kode_jabatan	=	'';
				if ( ! (empty($kode_jabatan)) )
				{
					foreach ($kode_jabatan as $kd_jabatan)
					{
						$value_kode_jabatan 	.=	"'".$kd_jabatan."'";
						if ( $indeks_kode_jabatan < ($jumlah_kode_jabatan - 1) )
						{
							$value_kode_jabatan 	.=	", ";
						}
						$indeks_kode_jabatan++;
					}
					$parameter_kode_jabatan 	=	"and tshiftpekerja.kd_jabatan in (".$value_kode_jabatan.")";
				}

				$url_query 							=	base_url('assets/sql/query_personalia_presensi_tb_konversi_presensi.sql');
				$query_tb_konversi_presensi 		=	file_get_contents($url_query);

				$query_tb_konversi_presensi 	=	str_replace
													(
														array
														(
															':tgl1',
															':tgl2',
															':kode_status_kerja',
															':noind',
															':kode_shift',
															':kodesie',
															':lokasi_kerja',
															':kode_jabatan',
														),
														array
														(
															"'".$tanggal_awal."'",
															"'".$tanggal_akhir."'",
															$parameter_kode_status_kerja,
															$parameter_noind,
															$parameter_kode_shift,
															$parameter_kodesie,
															$parameter_lokasi_kerja,
															$parameter_kode_jabatan
														),
														$query_tb_konversi_presensi
													);
				$hasil_konversi_presensi		=	$this->M_sinkronisasikonversipresensi->tb_konversi_presensi($query_tb_konversi_presensi);
				$table_columns					=	$this->M_sinkronisasikonversipresensi->tb_konversi_presensi_columns();

				$id_konversi_presensi_array 	=	array();
				$indeks_id_konversi_presensi 	=	0;

				foreach ($hasil_konversi_presensi as $hasil)
				{
					$check_exist 	=	$this->M_sinkronisasikonversipresensi->check_exist
										(
											$hasil['tanggal'],
											$hasil['noind'],
											$hasil['kd_shift'],
											$hasil['kodesie'],
											$hasil['lokasi_kerja'],
											$hasil['kd_jabatan']
										);

					if ( $check_exist == 0 ) // insert
					{
						$insert 	=	array();
						foreach ($table_columns as $columns)
						{
							if ( array_key_exists($columns['column_name'], $hasil) )
							{
								if ( ! (empty($hasil[$columns['column_name']]) AND $hasil[$columns['column_name']] == '') )
								{
									if ( $columns['data_type'] == 'boolean' )
									{
										if ( $hasil[$columns['column_name']] == 't')
										{
											$hasil[$columns['column_name']]	= 	1;
										}
										else
										{
											$hasil[$columns['column_name']]	= 	0;
										}
									}

									$insert[$columns['column_name']] 	=	rtrim($hasil[$columns['column_name']]);
								}
							}
						}
						$insert['create_timestamp']	=	date('Y-m-d H:i:s');
						$insert['create_user']		=	$this->session->user;

						$id_konversi_presensi	=	$this->M_sinkronisasikonversipresensi->insert($insert);

						if ( $id_konversi_presensi )
						{
							$this->lib_sinkronisasikonversipresensi->history('"Presensi"', 'tb_konversi_presensi', array('id_konversi_presensi' => $id_konversi_presensi), 'CREATE');
						}
					}
					elseif ( $check_exist > 0 ) // update
					{
						$tabel_konversi_presensi 	=	$this->M_sinkronisasikonversipresensi->data_konversi_presensi
														(
															$hasil['tanggal'],
															$hasil['noind'],
															$hasil['kd_shift'],
															$hasil['kodesie'],
															$hasil['lokasi_kerja'],
															$hasil['kd_jabatan']
														);
						$id_konversi_presensi 	=	$tabel_konversi_presensi[0]['id_konversi_presensi'];

						$update 	=	array();
						foreach ($table_columns as $columns)
						{
							if ( array_key_exists($columns['column_name'], $hasil) )
							{
								if ( ! (empty($hasil[$columns['column_name']]) AND $hasil[$columns['column_name']] == '') )
								{
									if ( $columns['data_type'] == 'boolean' )
									{
										if ( $hasil[$columns['column_name']] == 't')
										{
											$hasil[$columns['column_name']]	= 	1;
										}
										else
										{
											$hasil[$columns['column_name']]	= 	0;
										}
									}

									$update[$columns['column_name']] 	=	rtrim($hasil[$columns['column_name']]);
								}
							}
						}
						$update['last_update_timestamp']	=	date('Y-m-d H:i:s');
						$update['last_update_user']			=	$this->session->user;

						$this->M_sinkronisasikonversipresensi->update($update, $id_konversi_presensi);
						//insert to sys.log_activity
						$aksi = 'REKAP TIMS';
						$detail = "Update Konversi presensi id=$id_konversi_presensi";
						$this->log_activity->activity_log($aksi, $detail);
						//
						$this->lib_sinkronisasikonversipresensi->history('"Presensi"', 'tb_konversi_presensi', array('id_konversi_presensi' => $id_konversi_presensi), 'UPDATE');
					}
					$id_konversi_presensi_array[$indeks_id_konversi_presensi]	=	$id_konversi_presensi;
					$indeks_id_konversi_presensi++;
				}

				$data['tabel_konversi_presensi'] 	=	$this->M_sinkronisasikonversipresensi->hasil_konversi_presensi($id_konversi_presensi_array);
				$data['table_columns']				=	$table_columns;

				$this->load->view('V_Header', $data);
				$this->load->view('V_Sidemenu', $data);
				$this->load->view('er/SinkronisasiKonversiPresensi/V_index', $data);
				$this->load->view('V_Footer', $data);
			}
		}

		public function schedule()
		{
			$tanggal_awal 					=	date('Y-m-d', strtotime('-4 day'));
			$tanggal_akhir					=	date('Y-m-d', strtotime('-3 day'));

			$parameter_kode_status_kerja	=	'';
			$parameter_noind 				=	'';
			$parameter_kode_shift 			=	'';
			$parameter_kodesie 				=	'';
			$parameter_lokasi_kerja 		=	'';
			$parameter_kode_jabatan 		=	'';

			$url_query 							=	base_url('assets/sql/query_personalia_presensi_tb_konversi_presensi.sql');
			$query_tb_konversi_presensi 		=	file_get_contents($url_query);

			$query_tb_konversi_presensi 	=	str_replace
												(
													array
													(
														':tgl1',
														':tgl2',
														':kode_status_kerja',
														':noind',
														':kode_shift',
														':kodesie',
														':lokasi_kerja',
														':kode_jabatan',
													),
													array
													(
														"'".$tanggal_awal."'",
														"'".$tanggal_akhir."'",
														$parameter_kode_status_kerja,
														$parameter_noind,
														$parameter_kode_shift,
														$parameter_kodesie,
														$parameter_lokasi_kerja,
														$parameter_kode_jabatan
													),
													$query_tb_konversi_presensi
												);
			$hasil_konversi_presensi		=	$this->M_sinkronisasikonversipresensi->tb_konversi_presensi($query_tb_konversi_presensi);
			$table_columns					=	$this->M_sinkronisasikonversipresensi->tb_konversi_presensi_columns();

			foreach ($hasil_konversi_presensi as $hasil)
			{
				$check_exist 	=	$this->M_sinkronisasikonversipresensi->check_exist
									(
										$hasil['tanggal'],
										$hasil['noind'],
										$hasil['kd_shift'],
										$hasil['kodesie'],
										$hasil['lokasi_kerja'],
										$hasil['kd_jabatan']
									);

				if ( $check_exist == 0 ) // insert
				{
					$insert 	=	array();
					foreach ($table_columns as $columns)
					{
						if ( array_key_exists($columns['column_name'], $hasil) )
						{
							if ( ! (empty($hasil[$columns['column_name']]) AND $hasil[$columns['column_name']] == '') )
							{
								if ( $columns['data_type'] == 'boolean' )
								{
									if ( $hasil[$columns['column_name']] == 't')
									{
										$hasil[$columns['column_name']]	= 	1;
									}
									else
									{
										$hasil[$columns['column_name']]	= 	0;
									}
								}

								$insert[$columns['column_name']] 	=	rtrim($hasil[$columns['column_name']]);
							}
						}
					}
					$insert['create_timestamp']	=	date('Y-m-d H:i:s');
					$insert['create_user']		=	'CRON';

					$id_konversi_presensi	=	$this->M_sinkronisasikonversipresensi->insert($insert);

					if ( $id_konversi_presensi )
					{
						$this->lib_sinkronisasikonversipresensi->history('"Presensi"', 'tb_konversi_presensi', array('id_konversi_presensi' => $id_konversi_presensi), 'CREATE');
					}
				}
				elseif ( $check_exist > 0 ) // update
				{
					$tabel_konversi_presensi 	=	$this->M_sinkronisasikonversipresensi->data_konversi_presensi
													(
														$hasil['tanggal'],
														$hasil['noind'],
														$hasil['kd_shift'],
														$hasil['kodesie'],
														$hasil['lokasi_kerja'],
														$hasil['kd_jabatan']
													);
					$id_konversi_presensi 	=	$tabel_konversi_presensi[0]['id_konversi_presensi'];

					$update 	=	array();
					foreach ($table_columns as $columns)
					{
						if ( array_key_exists($columns['column_name'], $hasil) )
						{
							if ( ! (empty($hasil[$columns['column_name']]) AND $hasil[$columns['column_name']] == '') )
							{
								if ( $columns['data_type'] == 'boolean' )
								{
									if ( $hasil[$columns['column_name']] == 't')
									{
										$hasil[$columns['column_name']]	= 	1;
									}
									else
									{
										$hasil[$columns['column_name']]	= 	0;
									}
								}

								$update[$columns['column_name']] 	=	rtrim($hasil[$columns['column_name']]);
							}
						}
					}
					$update['last_update_timestamp']	=	date('Y-m-d H:i:s');
					$update['last_update_user']			=	'CRON';

					$this->M_sinkronisasikonversipresensi->update($update, $id_konversi_presensi);
					//insert to sys.log_activity
					$aksi = 'REKAP TIMS';
					$detail = "Update Konversi presensi id=$id_konversi_presensi";
					$this->log_activity->activity_log($aksi, $detail);
					//
					$this->lib_sinkronisasikonversipresensi->history('"Presensi"', 'tb_konversi_presensi', array('id_konversi_presensi' => $id_konversi_presensi), 'UPDATE');

				}
			}
		}

		//	Javascript Function
		//	{
				public function kode_status_kerja($value='')
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$kode_status_kerja 	=	$this->M_sinkronisasikonversipresensi->kode_status_kerja($keyword);
					echo json_encode($kode_status_kerja);
				}

				public function pekerja()
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$pekerja 			=	$this->M_sinkronisasikonversipresensi->pekerja($keyword);
					echo json_encode($pekerja);
				}

				public function kode_shift()
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$kode_shift 		=	$this->M_sinkronisasikonversipresensi->kode_shift($keyword);
					echo json_encode($kode_shift);
				}

				public function kodesie()
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$kodesie 		=	$this->M_sinkronisasikonversipresensi->kodesie($keyword);
					echo json_encode($kodesie);
				}

				public function lokasi_kerja()
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$lokasi_kerja 		=	$this->M_sinkronisasikonversipresensi->lokasi_kerja($keyword);
					echo json_encode($lokasi_kerja);
				}

				public function jabatan()
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$jabatan 			=	$this->M_sinkronisasikonversipresensi->jabatan($keyword);
					echo json_encode($jabatan);
				}
		//	}
	}
