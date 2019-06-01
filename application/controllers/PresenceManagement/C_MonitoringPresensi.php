<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class C_MonitoringPresensi extends CI_Controller 
	{

		function __construct()
		{
			parent::__construct();
			$this->load->library('General');
			$this->load->library('Lib_MonitoringPresensi');

			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('PresenceManagement/M_monitoringpresensi');
			$this->load->model('TarikFingerspot/M_tarikfingerspot');
			
			date_default_timezone_set('Asia/Jakarta');
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
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring Presensi - Quick ERP', 'Monitoring Presensi', 'Monitoring Presensi', 'Monitoring Presensi');

			$device		=	$this->M_monitoringpresensi->device_fingerprint();
			$angka = 0;
			foreach ($device as $dev) {
				$hasil = $this->M_monitoringpresensi->getCateringFrontPresensi($dev['inisial_lokasi']);
				if (!empty($hasil)) {
					$device[$angka]['catering'] = $hasil[0]['catering'];
					$device[$angka]['frontpresensi'] = $hasil[0]['frontpresensi'];
					if ($device[$angka]['catering'] == $device[$angka]['frontpresensi']) {
						$device[$angka]['status'] = "<label class='label label-success'>OK</label>";
					}else{
						$device[$angka]['status'] = "<label class='label label-danger'>NOT OK</label>";
					}
					
				}else{
					$device[$angka]['catering'] = '0';
					$device[$angka]['frontpresensi'] = '0';
					$device[$angka]['status'] = "<label class='label label-danger'>NOT OK</label>";
				}
				$angka++;
			}

			$data['device_fingerprint'] = $device;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PresenceManagement/MonitoringPresensi/V_MonitoringPresensi_Index',$data);
			$this->load->view('V_Footer',$data);
		}

		public function Show($noind){

			$this->checkSession();
			$data 	=	$this->general->loadHeaderandSidemenu('Monitoring Presensi - Quick ERP', 'Monitoring Presensi', 'Monitoring Presensi', 'Monitoring Presensi');

			$noind = sprintf("%07d", $noind);
			$data['pekerja'] = $this->M_monitoringpresensi->ambilNoindBaru($noind);

			$data['finger'] = $this->M_monitoringpresensi->ambilfinger($noind);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PresenceManagement/MonitoringPresensi/V_Finger',$data);
			$this->load->view('V_Footer',$data);
		}
		public function Delete_Finger($id)
		{
			echo $id;
		}
		public function time_sync($id_lokasi = FALSE)
		{
			$id_lokasi_decode;
			$user;

			if ( $id_lokasi !== FALSE )
			{
				$id_lokasi_decode	=	$this->general->dekripsi($id_lokasi);
				$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint($id_lokasi_decode);
			}
			else
			{
				$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint();
			}

			if ( $this->session->is_logged )
			{
				$user 	=	$this->session->user;
			}
			else
			{
				$user 	=	'CRON';
			}

			echo '<h2>SINKRONISASI WAKTU MESIN PRESENSI</h2><br/>';

			foreach ($tb_device as $device)
			{
				$device_sn 			=	"";
				$device_server_ip 	=	"";
				$device_server_port	=	"";
				$parameter 			=	"";
				$device_sn 			=	$device['device_sn'];
				$device_server_ip	=	$device['server_ip'];
				$device_server_port =	$device['server_port'];
				$parameter 			.=	"sn=".$device_sn;
				$url 			=	$device_server_ip."/dev/settime";
				$server_output	=	$this->lib_monitoringpresensi->send_to_sdk_server($device_server_port, $url, $parameter);

				if ( strpos($server_output, "Error") !== FALSE )
				{
					echo 'Sinkronisasi '.$device['device_name'].' - '.$device_server_ip.' GAGAL<br/>';
					echo $server_output;
					exit();
				}

				echo 'Sinkronisasi '.$device['device_name'].' - '.$device_server_ip.' BERHASIL<br/>';
			}
			
			if ( $this->session->is_logged )
			{
				redirect('PresenceManagement/MonitoringPresensi');
			}
		}

		public function get_scanlog($id_lokasi = FALSE)
		{
			if ( $id_lokasi !== FALSE )
			{
				$id_lokasi_decode	=	$this->general->dekripsi($id_lokasi);
				$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint($id_lokasi_decode);
			}
			else
			{
				$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint();
			}

			if ( $this->session->is_logged )
			{
				$user 	=	$this->session->user;
			}
			else
			{
				$user 	=	'CRON';
			}

			echo '<h2>TARIK DATA PRESENSI</h2><br/>';
			foreach ($tb_device as $device)
			{
				$device_sn 			=	"";
				$device_server_ip 	=	"";
				$device_server_port	=	"";
				$parameter 			=	"";
				$device_sn 			=	$device['device_sn'];
				$device_server_ip	=	$device['server_ip'];
				$device_server_port =	$device['server_port'];
				$parameter 			.=	"sn=".$device_sn;
				$url 			=	$device_server_ip."/scanlog/new";
				$server_output	=	$this->lib_monitoringpresensi->send_to_sdk_server($device_server_port, $url, $parameter);

				if ( strpos($server_output, "Error") !== FALSE )
				{
					echo 'Tarik data presensi '.$device['device_name'].' - '.$device_server_ip.' GAGAL<br/>';
					echo $server_output;
					exit();
				}
				else
				{
					echo 'Tarik data presensi '.$device['device_name'].' - '.$device_server_ip.' BERHASIL<br/>';
					$content = json_decode($server_output);
			
					foreach ($content as $key => $value)
					{
						if ( ( ! (is_array($value)) ) AND ( $value == 1 ) )
						{
							foreach ($content->Data as $entry)
							{
								$Jsn 			= 	$entry->SN;
								$Jsd 			= 	$entry->ScanDate;
								$Jnoind_baru 	=	$entry->PIN;
								$Jvm 			=	$entry->VerifyMode;
								$Jim 			=	$entry->IOMode;
								$Jwc 			=	$entry->WorkCode;

								$data_exist 	=	$this->M_monitoringpresensi->scanlog_exist_check($Jsn, $Jsd, $Jnoind_baru);
								if( $data_exist != 0 )
								{
									$scanlog_update 	=	array
															(
																'sn'					=>	$Jsn,
																'scan_date'				=>	$Jsd,
																'noind_baru'			=>	$Jnoind_baru,
																'verifymode' 			=>	$Jvm,
																'iomode'				=>	$Jim,
																'workcode'				=>	$Jwc,
																'last_update_timestamp'	=>	date('Y-m-d H:i:s'),
																'last_update_user'		=>	$user,
															);
									$this->M_monitoringpresensi->scanlog_update($scanlog_update, $Jsn, $Jsd, $Jnoind_baru);
									$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_scanlog', array('sn' => $Jsn, 'scan_date' => $Jsd, 'noind_baru' => $Jnoind_baru), 'UPDATE');
									echo '-------Update scanlog '.$Jnoind_baru.' - '.$Jsd.' BERHASIL<br/>';
								}
								else
								{
									$scanlog_insert 	=	array
															(
																'sn'				=>	$Jsn,
																'scan_date'			=>	$Jsd,
																'noind_baru'		=>	$Jnoind_baru,
																'verifymode' 		=>	$Jvm,
																'iomode'			=>	$Jim,
																'workcode'			=>	$Jwc,
																'create_timestamp'	=>	date('Y-m-d H:i:s'),
																'create_user'		=>	$user,
															);
									$this->M_monitoringpresensi->scanlog_insert($scanlog_insert);
									$this->M_monitoringpresensi->scanlog_insert_backup($scanlog_insert);

									$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_scanlog', array('sn' => $Jsn, 'scan_date' => $Jsd, 'noind_baru' => $Jnoind_baru), 'CREATE');
									echo '-------Insert scanlog '.$Jnoind_baru.' - '.$Jsd.' BERHASIL<br/>';
								}
							}
						}
					}
				}
			}

			// if ( $this->session->is_logged )
			// {
			// 	redirect('PresenceManagement/MonitoringPresensi');
			// }
		}

		public function get_scanlog_all($id_lokasi = FALSE)
		{
			if ( $id_lokasi !== FALSE )
			{
				$id_lokasi_decode	=	$this->general->dekripsi($id_lokasi);
				$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint($id_lokasi_decode);
			}
			else
			{
				$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint();
			}

			if ( $this->session->is_logged )
			{
				$user 	=	$this->session->user;
			}
			else
			{
				$user 	=	'CRON';
			}

			echo '<h2>TARIK DATA PRESENSI</h2><br/>';
			foreach ($tb_device as $device)
			{
				$device_sn 			=	"";
				$device_server_ip 	=	"";
				$device_server_port	=	"";
				$parameter 			=	"";
				$device_sn 			=	$device['device_sn'];
				$device_server_ip	=	$device['server_ip'];
				$device_server_port =	$device['server_port'];
				$parameter 			.=	"sn=".$device_sn;
				$parameter 			.=	"&limit=500";
				$url 			=	$device_server_ip."/scanlog/all/paging";
				$server_output	=	$this->lib_monitoringpresensi->send_to_sdk_server($device_server_port, $url, $parameter);

				if ( strpos($server_output, "Error") !== FALSE )
				{
					echo 'Tarik data presensi '.$device['device_name'].' - '.$device_server_ip.' GAGAL<br/>';
					echo $server_output;
					exit();
				}
				else
				{
					echo 'Tarik data presensi '.$device['device_name'].' - '.$device_server_ip.' BERHASIL<br/>';
					$content = json_decode($server_output);
			
					foreach ($content as $key => $value)
					{
						if ( ( ! (is_array($value)) ) AND ( $value == 1 ) )
						{
							foreach ($content->Data as $entry)
							{
								$Jsn 			= 	$entry->SN;
								$Jsd 			= 	$entry->ScanDate;
								$Jnoind_baru 	=	$entry->PIN;
								$Jvm 			=	$entry->VerifyMode;
								$Jim 			=	$entry->IOMode;
								$Jwc 			=	$entry->WorkCode;

								$data_exist 	=	$this->M_monitoringpresensi->scanlog_exist_check($Jsn, $Jsd, $Jnoind_baru);
								if( $data_exist != 0 )
								{
									$scanlog_update 	=	array
															(
																'sn'					=>	$Jsn,
																'scan_date'				=>	$Jsd,
																'noind_baru'			=>	$Jnoind_baru,
																'verifymode' 			=>	$Jvm,
																'iomode'				=>	$Jim,
																'workcode'				=>	$Jwc,
																'last_update_timestamp'	=>	date('Y-m-d H:i:s'),
																'last_update_user'		=>	$user,
															);
									$this->M_monitoringpresensi->scanlog_update($scanlog_update, $Jsn, $Jsd, $Jnoind_baru);
									$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_scanlog', array('sn' => $Jsn, 'scan_date' => $Jsd, 'noind_baru' => $Jnoind_baru), 'UPDATE');
									echo '-------Update scanlog '.$Jnoind_baru.' - '.$Jsd.' BERHASIL<br/>';
								}
								else
								{
									$scanlog_insert 	=	array
															(
																'sn'				=>	$Jsn,
																'scan_date'			=>	$Jsd,
																'noind_baru'		=>	$Jnoind_baru,
																'verifymode' 		=>	$Jvm,
																'iomode'			=>	$Jim,
																'workcode'			=>	$Jwc,
																'create_timestamp'	=>	date('Y-m-d H:i:s'),
																'create_user'		=>	$user,
															);
									$this->M_monitoringpresensi->scanlog_insert($scanlog_insert);
									$this->M_monitoringpresensi->scanlog_insert_backup($scanlog_insert);

									$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_scanlog', array('sn' => $Jsn, 'scan_date' => $Jsd, 'noind_baru' => $Jnoind_baru), 'CREATE');
									echo '-------Insert scanlog '.$Jnoind_baru.' - '.$Jsd.' BERHASIL<br/>';
								}
							}
						}
					}
				}
			}

			if ( $this->session->is_logged )
			{
				redirect('PresenceManagement/MonitoringPresensi');
			}
		}

		public function delete_device_scanlog($id_lokasi)
		{	
			//semula : public function delete_device_scanlog($id_lokasi = FALSE) diubah agar tidak menghapus di semua device
			if ( $id_lokasi !== FALSE )
			{
				$id_lokasi_decode	=	$this->general->dekripsi($id_lokasi);
				$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint($id_lokasi_decode);
			}
			else
			{
				$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint();
			}

			if ( $this->session->is_logged )
			{
				$user 	=	$this->session->user;
			}
			else
			{
				$user 	=	'CRON';
			}

			echo '<h2>HAPUS SCANLOG MESIN PRESENSI</h2><br/>';
			foreach ($tb_device as $device)
			{
				$device_sn 			=	"";
				$device_server_ip 	=	"";
				$device_server_port	=	"";
				$parameter 			=	"";
				$device_sn 			=	$device['device_sn'];
				$device_server_ip	=	$device['server_ip'];
				$device_server_port =	$device['server_port'];
				$parameter 			.=	"sn=".$device_sn;
				$url 			=	$device_server_ip."/scanlog/del";
				$server_output	=	$this->lib_monitoringpresensi->send_to_sdk_server($device_server_port, $url, $parameter);

				if ( strpos($server_output, "Error") !== FALSE )
				{
					echo 'Hapus Scanlog '.$device['device_name'].' - '.$device_server_ip.' GAGAL<br/>';
					echo $server_output;
					exit();
				}
				echo 'Hapus Scanlog '.$device['device_name'].' - '.$device_server_ip.' BERHASIL<br/>';
				$scanlog_update 	=	array
										(
											'workcode'	=>	'1',
										);
				$where_clause 		= 	array
										(
											'sn' => $device['device_sn']
										);
				$this->M_monitoringpresensi->updateStatusDelete($scanlog_update,$where_clause);
			}

			if ( $this->session->is_logged )
			{
				// redirect('PresenceManagement/MonitoringPresensi');
				redirect('PresenceManagement/MonFingerspot');
			}
		}

		public function transfer_presensi()
		{
			$scanlog 	=	$this->M_monitoringpresensi->scanlog_get($transfer = 0);

			foreach ($scanlog as $datapresensi)
			{
				$id_scanlog 			=	$datapresensi['id_scanlog'];

				$presensi_sn 			=	$datapresensi['sn'];
				$presensi_kodesie 		=	$datapresensi['kodesie'];

				$presensi_tanggal 		=	$datapresensi['tanggal'];
				$presensi_waktu 		=	$datapresensi['waktu'];
				$presensi_noind_baru	=	$datapresensi['noind_baru'];
				$presensi_noind 		=	$datapresensi['noind'];
				/*$presensi_transfer 		=	false;*/
				$presensi_user 			=	$datapresensi['inisial_lokasi'];

				$data_presensi 			=	array
											(
												'tanggal' 		=>	$presensi_tanggal,
												'waktu' 		=>	$presensi_waktu,
												'noind_baru'	=>	$presensi_noind_baru,
												'noind' 		=>	$presensi_noind,
												'kodesie' 		=>	$presensi_kodesie,
												'user_' 		=>	$presensi_user,
											);
				if (substr($presensi_noind, 0,1) == 'L') {
					$cek = $this->M_tarikfingerspot->cekPresensiL($data_presensi);
				}else{
					$cek = $this->M_tarikfingerspot->cekPresensi($data_presensi);
				}

				if ($cek == '0') {

					if (substr($presensi_noind, 0,1) == 'L') {
						//	Kirim ke Presensi.tprs_shift2
						//	{
			 					$data_presensi['transfer']	=	FALSE;
			 					$data_presensi['user_']		=	'CRON';
			 					$this->M_tarikfingerspot->insert_presensi('"Presensi"', 'tprs_shift2', $data_presensi);
						//	}
					}else{
						//	Kirim ke FrontPresensi.tpresensi
						//	{
								$data_presensi['transfer']	=	TRUE;
			 					$this->M_monitoringpresensi->insert_presensi('"FrontPresensi"', 'tpresensi', $data_presensi);
						//	}

						//	Kirim ke Catering.tpresensi
						//	{
			 					$data_presensi['transfer']	=	FALSE;
			 					$this->M_monitoringpresensi->insert_presensi('"Catering"', 'tpresensi', $data_presensi);
						//	}

						//	Kirim ke Presensi.tprs_shift
						//	{
			 					$data_presensi['transfer']	=	FALSE;
			 					$data_presensi['user_']		=	'CRON';
			 					$this->M_monitoringpresensi->insert_presensi('"Presensi"', 'tprs_shift', $data_presensi);
						//	}
			 		}


		 			//	Update transfer
		 			//	{
		 					$scanlog_update 	=	array
		 											(
		 												'transfer'	=>	TRUE,
		 											);
		 					$where_clause 		= 	array
		 											(
		 												'id_scanlog ='	=>	$id_scanlog
		 											);
		 					$this->M_monitoringpresensi->scanlog_update($scanlog_update, $where_clause);
		 			//	}
				}

				
			}
		}

		public function pekerja_keluar_perubahan_noind()
		{
			// 	List tb_user join vi_tpribadi yang keluar = 1
			// 	{

			//	}

			//	Cek pekerja keluar dengan parameter nik dan nama
			//	{
					//	Jika ada yang statusnya aktif
					//	{
							//	Jika noind baru sama
							//	{
									//	Update noind di tb_user dan update nama mesin
							//	}

							//	Jika noind baru tidak sama
							//	{
									//	Insert record baru di tb_user
									//	Gandakan data jari di tb_jari
									//	Masukkan data baru ke mesin
									//	Gandakan data di tb_user_access dengan parameter noind baru yang lama
									//	Gandakan data di tb_user_access_jari_ref dengan parameter id_user_access noind baru yang lama
									//	Hapus data pekerja noind baru yang lama di semua mesin berkaitan, tb_user_access, dan tb_user_access_jari_ref

							//	}
					//	}
					//	Jika statusnya keluar semua
					//	{
							//	Hapus data pekerja di semua mesin berkaitan dan tb_user_access
					//	}
			//	}
		}

		//	Device User List
		//	{
				public function device_user_list($id_lokasi)
				{
					$this->checkSession();
					$id_lokasi_decode 	=	$this->general->dekripsi($id_lokasi);
					$data 	=	$this->general->loadHeaderandSidemenu('Monitoring Presensi - Quick ERP', 'Monitoring Presensi', 'Monitoring Presensi', 'Monitoring Presensi');

					$data['device_fingerprint']		=	$this->M_monitoringpresensi->device_fingerprint($id_lokasi_decode);
					$data['device_user_list']		=	$this->M_monitoringpresensi->device_user_list($id_lokasi_decode);

					$data['id_lokasi_encode'] 		=	$id_lokasi;

					

					$this->load->view('V_Header',$data);
					$this->load->view('V_Sidemenu',$data);
					$this->load->view('PresenceManagement/MonitoringPresensi/V_MonitoringPresensi_DeviceUserList',$data);
					$this->load->view('V_Footer',$data);
				}

				public function user_register()
				{
					$id_lokasi 		=	$this->input->post('txtIDLokasi', TRUE);
					$noind_baru 	=	$this->input->post('cmbUserRegistered', TRUE);
					$jari_ref 		=	$this->input->post('cmbJariRef', TRUE);

					$tb_user 	=	$this->M_monitoringpresensi->user_list($noind_baru);
					$tb_device 	=	$this->M_monitoringpresensi->device_fingerprint($id_lokasi);
					foreach ($tb_user as $user)
					{
						$user_noind_baru 	=	"";
						$user_nama 			=	"";
						$user_pwd 			=	"";
						$user_rfid 			=	"";
						$user_priv 			=	"";
						$device_sn 			=	"";
						$device_server_ip 	=	"";
						$device_server_port	=	"";
						$parameter 			=	"";

						if ( (empty($jari_ref)) )
						{
							$user_template_jari =	$this->lib_monitoringpresensi->get_finger_template_json($user['noind_baru'], 'DEFAULT');
						}
						else
						{
							$user_template_jari =	$this->lib_monitoringpresensi->get_finger_template_json($user['noind_baru'], $jari_ref);
						}

						$user_noind_baru 	=	$user['noind_baru'];
						$user_nama 			=	$user['noind']."-".substr($user['nama'], 0, 14);
						$user_pwd 			=	$user['pwd'];
						$user_rfid 			=	$user['rfid'];
						$user_priv 			=	$user['privilege'];

						foreach ($tb_device as $device)
						{
							$device_sn 			=	$device['device_sn'];
							$device_server_ip	=	$device['server_ip'];
							$device_server_port =	$device['server_port'];
						}

						$parameter 		.=	"sn=".$device_sn;
						$parameter 		.=	"&pin=".$user_noind_baru;
						$parameter 		.=	"&nama=".$user_nama;
						$parameter 		.=	"&pwd=".$user_pwd;
						$parameter 		.=	"&rfid=".$user_rfid;
						$parameter 		.=	"&priv=".$user_priv;
						$parameter 		.=	"&tmp=".$user_template_jari;

						$url 			=	$device_server_ip."/user/set";
						$server_output	=	$this->lib_monitoringpresensi->send_to_sdk_server($device_server_port, $url, $parameter);

						if ( strpos($server_output, "Error") !== FALSE )
						{
							echo $server_output;
							exit();
						}

						$user_access_exist_check	=	$this->M_monitoringpresensi->user_access_exist_check($user['noind_baru'], $id_lokasi);
						if ( $user_access_exist_check == 0 )
						{
							$user_access_insert 	=	array
														(
															'id_lokasi'			=>	$id_lokasi,
															'noind_baru'		=>	$user['noind_baru'],
															'noind'				=>	$user['noind'],
															'privilege'			=>	$user_priv,
															'create_timestamp'	=>	date('Y-m-d H:i:s'),
															'create_user'		=>	$this->session->user,
														);
							$id_user_access 		=	$this->M_monitoringpresensi->user_access_insert($user_access_insert);
							$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user_access', array('id_user_access' => $id_user_access), 'CREATE');
						}
						else
						{
							$user_access_update 	=	array
														(
															'noind'					=>	$user['noind'],
															'privilege'			=>	$user_priv,
															'last_update_timestamp'	=>	date('Y-m-d H:i:s'),
															'last_update_user'		=>	$this->session->user,
														);
							$this->M_monitoringpresensi->user_access_update($user_access_update, array('noind_baru' => $user['noind_baru'], 'id_lokasi' => $id_lokasi));
							$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user_access', array('noind_baru' => $info['noind_baru'], 'id_lokasi' => $id_lokasi), 'UPDATE');
						}

						$user_access 			=	$this->M_monitoringpresensi->user_access_get(FALSE, (array('user_access.noind_baru' => $user['noind_baru'], 'user_access.id_lokasi' => $id_lokasi)));
						$id_user_access 		=	$user_access[0]['id_user_access'];

						if ( empty($jari_ref) )
						{
							$kode_finger 	=	array
														(
															0,
															1,
															2,
															3
														);
						}
						else
						{
							$kode_finger 	=	$jari_ref;
						}

						foreach ($kode_finger as $kode)
						{
							$jari_check_exist 	= 	$this->M_monitoringpresensi->jari_cek($user['noind_baru'], $kode);
							if ( $jari_check_exist == 1 )
							{
								$user_access_jari_ref_check_exist 	=	$this->M_monitoringpresensi->user_access_jari_ref_check_exist($id_user_access, $kode);
								if ( $user_access_jari_ref_check_exist == 0 )
								{
									$user_access_jari_ref_insert 	=	array
																		(
																			'id_user_access'	=>	$id_user_access,
																			'kode_finger' 		=>	$kode,
																			'create_timestamp'	=>	date('Y-m-d H:i:s'),
																			'create_user'		=>	$this->session->user,
																		);

									$id_user_access_jari_ref 	=	$this->M_monitoringpresensi->user_access_jari_ref_insert($user_access_jari_ref_insert);
									$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user_access_jari_ref', array('id_user_access_jari_ref' => $id_user_access_jari_ref), 'CREATE');
								}
							}
						}
					}

					redirect(base_url('PresenceManagement/MonitoringPresensi/device_user_list'.'/'.$this->general->enkripsi($id_lokasi)));
				}

				public function finger_data_get($id_lokasi)
				{
					$id_lokasi_decode	=	$this->general->dekripsi($id_lokasi);
					$tb_device 			=	$this->M_monitoringpresensi->device_fingerprint($id_lokasi_decode);
					$device_sn 			=	"";
					$device_server_ip 	=	"";
					$device_server_port	=	"";
					$parameter 			=	"";

					foreach ($tb_device as $device)
					{
						$device_sn 			=	$device['device_sn'];
						$device_server_ip	=	$device['server_ip'];
						$device_server_port =	$device['server_port'];
					}

					$parameter 			.=	"sn=".$device_sn;

					$url 			=	$device_server_ip."/user/all/paging";
					$server_output	=	$this->lib_monitoringpresensi->send_to_sdk_server($device_server_port, $url, $parameter);

					if ( strpos($server_output, "Error") !== FALSE )
					{
						echo $server_output;
						exit();
					}
					else
					{
						$content =	json_decode($server_output);

						if ( ($content->Data) > 0 )
						{
							foreach ($content->Data as $user)
							{
								$user_noind_baru 	=	$user->PIN;
								$user_rfid 			=	$user->RFID;
								$user_pwd 			=	$user->Password;
								$user_priv 			=	$user->Privilege;

								$user_update 		=	array
														(
															'pwd'					=>	$user_pwd,
															'rfid'					=>	$user_rfid,
															'privilege'				=>	$user_priv,
															'last_update_timestamp'	=>	date('Y-m-d H:i:s'),
															'last_update_user'		=>	$this->session->user,
														);
								$this->M_monitoringpresensi->user_update($user_update, $user_noind_baru);
								$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user', array('noind_baru' => $user_noind_baru), 'UPDATE');

								foreach ($user->Template as $jari)
								{
									$jari_noind_baru	=	$jari->pin;
									$jari_kode_finger	=	$jari->idx;
									$jari_alg_ver 		=	$jari->alg_ver;
									$jari_jari 			=	$jari->template;

									$jari_cek 			=	$this->M_monitoringpresensi->jari_cek($jari_noind_baru, $jari_kode_finger);

									if ( $jari_cek == 0 )
									{
										$jari_create 	=	array
															(
																'noind_baru'		=>	$jari_noind_baru,
																'kode_finger'		=>	$jari_kode_finger,
																'alg_ver'			=>	$jari_alg_ver,
																'jari'				=>	$jari_jari,
																'create_timestamp'	=>	date('Y-m-d H:i:s'),
																'create_user'		=>	$this->session->user,
															);
										$id_jari 		=	$this->M_monitoringpresensi->jari_create($jari_create);
										$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_jari', array('id_jari' => $id_jari), 'CREATE');
									}
									else
									{
										$jari_update 	=	array
															(
																'alg_ver'				=>	$jari_alg_ver,
																'jari'					=>	$jari_jari,
																'last_update_timestamp'	=>	date('Y-m-d H:i:s'),
																'last_update_user'		=>	$this->session->user,
															);
										$this->M_monitoringpresensi->jari_update($jari_update, $jari_noind_baru, $jari_kode_finger);
										$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_jari', array('noind_baru' => $jari_noind_baru, 'kode_finger' => $jari_kode_finger), 'UPDATE');
									}
								}
							}
						}

						redirect(base_url('PresenceManagement/MonitoringPresensi/device_user_list'.'/'.$id_lokasi));
					}
				}

				public function device_user_delete($id_user_access)
				{
					$id_user_access_decode 	=	$this->general->dekripsi($id_user_access);

					$user_access 	=	$this->M_monitoringpresensi->user_access_get($id_user_access_decode);

					$id_lokasi_decode;
					foreach ($user_access as $ua)
					{
						$id_lokasi_decode 		=	$ua['id_lokasi'];
						$parameter 		=	"sn=".$ua['device_sn'];
						$parameter 		.=	"&pin=".$ua['noind_baru'];

						$url 			=	$ua['server_ip'].'/user/del';
						$server_output	=	$this->lib_monitoringpresensi->send_to_sdk_server($ua['server_port'], $url, $parameter);
					}

					$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user_access_jari_ref', array('id_user_access' => $id_user_access_decode), 'DELETE');
					$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user_access', array('id_user_access' => $id_user_access_decode), 'DELETE');

					$this->M_monitoringpresensi->user_access_jari_ref_delete($id_user_access_decode);
					$this->M_monitoringpresensi->user_access_delete($id_user_access_decode);

					redirect(base_url('PresenceManagement/MonitoringPresensi/device_user_list'.'/'.$this->general->enkripsi($id_lokasi_decode)));
				}
		//	}


		//	Javascript Functions
		//	{
				public function registered_user()
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$registered_user 	=	$this->M_monitoringpresensi->registered_user($keyword);
					echo json_encode($registered_user);
				}

				public function finger_reference()
				{
					$keyword 			=	strtoupper($this->input->get('term'));

					$finger_reference 	=	$this->M_monitoringpresensi->finger_reference($keyword);
					echo json_encode($finger_reference);
				}
		//	}

		public function device_user_change_status($id_user_access){
			$id_user_access_decode 	=	$this->general->dekripsi($id_user_access);
			
			$user = $this->M_monitoringpresensi->user_access_get($id_user_access_decode);

			$id_lokasi 		=	"";
			$noind_baru 	=	"";
			foreach ($user as $usr) {
				$id_lokasi 		=	$usr['id_lokasi'];
				$noind_baru 	=	$usr['noind_baru'];
				$privileges		=	$usr['privilege'];
			}

			$tb_user 	=	$this->M_monitoringpresensi->user_list($noind_baru);
			$tb_device 	=	$this->M_monitoringpresensi->device_fingerprint($id_lokasi);
			foreach ($tb_user as $user)
			{
				$user_noind_baru 	=	"";
				$user_nama 			=	"";
				$user_pwd 			=	"";
				$user_rfid 			=	"";
				$user_priv 			=	"";
				$device_sn 			=	"";
				$device_server_ip 	=	"";
				$device_server_port	=	"";
				$parameter 			=	"";

				$user_template_jari =	$this->lib_monitoringpresensi->get_finger_template_json($user['noind_baru'], 'DEFAULT');
				
				$user_noind_baru 	=	$user['noind_baru'];
				$user_nama 			=	$user['noind']."-".substr($user['nama'], 0, 14);
				$user_pwd 			=	$user['pwd'];
				$user_rfid 			=	$user['rfid'];
				$user_priv 			=	$privileges;

				if ($user_priv == '0') {
					$user_priv = '3';
				}else{
					$user_priv = '0';
				}

				

				foreach ($tb_device as $device)
				{
					$device_sn 			=	$device['device_sn'];
					$device_server_ip	=	$device['server_ip'];
					$device_server_port =	$device['server_port'];
				}

				$parameter 		.=	"sn=".$device_sn;
				$parameter 		.=	"&pin=".$user_noind_baru;
				$parameter 		.=	"&nama=".$user_nama;
				$parameter 		.=	"&pwd=".$user_pwd;
				$parameter 		.=	"&rfid=".$user_rfid;
				$parameter 		.=	"&priv=".$user_priv;
				$parameter 		.=	"&tmp=".$user_template_jari;

				$url 			=	$device_server_ip."/user/set";
				$server_output	=	$this->lib_monitoringpresensi->send_to_sdk_server($device_server_port, $url, $parameter);

				if ( strpos($server_output, "Error") !== FALSE )
				{
					echo $server_output;
					exit();
				}

				$user_access_exist_check	=	$this->M_monitoringpresensi->user_access_exist_check($user['noind_baru'], $id_lokasi);
				if ( $user_access_exist_check == 0 )
				{
					$user_access_insert 	=	array
												(
													'id_lokasi'			=>	$id_lokasi,
													'noind_baru'		=>	$user['noind_baru'],
													'noind'				=>	$user['noind'],
													'privilege'			=>	$user_priv,
													'create_timestamp'	=>	date('Y-m-d H:i:s'),
													'create_user'		=>	$this->session->user,
												);
					$id_user_access 		=	$this->M_monitoringpresensi->user_access_insert($user_access_insert);
					$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user_access', array('id_user_access' => $id_user_access), 'CREATE');
				}
				else
				{
					$user_access_update 	=	array
												(
													'noind'					=>	$user['noind'],
													'privilege'				=>	$user_priv,
													'last_update_timestamp'	=>	date('Y-m-d H:i:s'),
													'last_update_user'		=>	$this->session->user,
												);
					$this->M_monitoringpresensi->user_access_update($user_access_update, array('noind_baru' => $user['noind_baru'], 'id_lokasi' => $id_lokasi));
					$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user_access', array('noind_baru' => $user['noind_baru'], 'id_lokasi' => $id_lokasi), 'UPDATE');
				}

				$user_access 			=	$this->M_monitoringpresensi->user_access_get(FALSE, (array('user_access.noind_baru' => $user['noind_baru'], 'user_access.id_lokasi' => $id_lokasi)));
				$id_user_access 		=	$user_access[0]['id_user_access'];

				$kode_finger 	= array(
											0,
											1,
											2,
											3
										);
				

				foreach ($kode_finger as $kode)
				{
					$jari_check_exist 	= 	$this->M_monitoringpresensi->jari_cek($user['noind_baru'], $kode);
					if ( $jari_check_exist == 1 )
					{
						$user_access_jari_ref_check_exist 	=	$this->M_monitoringpresensi->user_access_jari_ref_check_exist($id_user_access, $kode);
						if ( $user_access_jari_ref_check_exist == 0 )
						{
							$user_access_jari_ref_insert 	=	array
																(
																	'id_user_access'	=>	$id_user_access,
																	'kode_finger' 		=>	$kode,
																	'create_timestamp'	=>	date('Y-m-d H:i:s'),
																	'create_user'		=>	$this->session->user,
																);

							$id_user_access_jari_ref 	=	$this->M_monitoringpresensi->user_access_jari_ref_insert($user_access_jari_ref_insert);
							$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user_access_jari_ref', array('id_user_access_jari_ref' => $id_user_access_jari_ref), 'CREATE');
						}
					}
				}
			}

			redirect(base_url('PresenceManagement/MonitoringPresensi/device_user_list'.'/'.$this->general->enkripsi($id_lokasi)));
		}
	}