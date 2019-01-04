<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MonitoringPresensiPengaturan extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('General');
		$this->load->library('Lib_MonitoringPresensi');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PresenceManagement/M_monitoringpresensi');

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

		$data 	=	$this->general->loadHeaderandSidemenu('Monitoring Presensi - Quick ERP', 'Monitoring Presensi', 'Monitoring Presensi', 'Pengaturan');

		$data['device_fingerprint']		=	$this->M_monitoringpresensi->device_fingerprint();
		// $data['user_list'] 				=	$this->M_monitoringpresensi->user_list();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PresenceManagement/MonitoringPresensi/V_Pengaturan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function UserListTable(){
		$list = $this->M_monitoringpresensi->user_table();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->noind_baru;
			$row[] = $key->noind;
			$row[] = $key->nama;

			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'], 
			'recordsTotal' =>$this->M_monitoringpresensi->count_all(),
			'recordsFiltered' => $this->M_monitoringpresensi->count_filtered(),
			'data' => $data
		);

		echo json_encode($output);
	}

	//	Device Management
	//	{
			public function device_create()
			{
				$server_ip 		=	$this->input->post('txtIPServerSDK', TRUE);
				$server_port 	=	$this->input->post('txtPortServerSDK', TRUE);
				$device_sn 		=	$this->input->post('txtDeviceSN', TRUE);
				$device_ip 		=	$this->input->post('txtIPDevice', TRUE);
				$device_port 	=	$this->input->post('txtPortDevice', TRUE);
				$device_name 	=	$this->input->post('txtNameDevice', TRUE);
				$inisial_lokasi =	$this->input->post('txtInisialLokasi', TRUE);
				$office 		=	$this->input->post('cmbLokasiKerja');

				$id_lokasi_baru		=	'';
				$id_lokasi_terakhir	=	$this->M_monitoringpresensi->id_lokasi_terakhir();

				if ( empty($id_lokasi_terakhir) )
				{
					$id_lokasi_baru 	=	1;
				}
				else
				{
					$id_lokasi_baru		=	$id_lokasi_terakhir[0]['id_lokasi']+1;
				}

				$device_create 	=	array
									(
										'server_ip'				=>	$server_ip,
										'server_port'			=>	$server_port,
										'device_sn'				=>	$device_sn,
										'device_ip'				=>	$device_ip,
										'device_port'			=>	$device_port,
										'device_name'			=>	$device_name,
										'inisial_lokasi'		=>	$inisial_lokasi,
										'id_lokasi'				=>	'fp'.$id_lokasi_baru,
										'office'				=>	$office,
										'create_timestamp'		=>	$this->general->ambilWaktuEksekusi(),
										'create_user'			=>	$this->session->user,
									);
				$id_device	=	$this->M_monitoringpresensi->device_create($device_create);
				$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_device', array('id_device' => $id_device), 'CREATE');
				redirect('PresenceManagement/MonitoringPresensiPengaturan');
			}

			public function device_update()
			{
				$id_lokasi 		=	$this->input->post('txtIDLokasi', TRUE);
				$server_ip 		=	$this->input->post('txtIPServerSDK', TRUE);
				$server_port 	=	$this->input->post('txtPortServerSDK', TRUE);
				$device_sn 		=	$this->input->post('txtDeviceSN', TRUE);
				$device_ip 		=	$this->input->post('txtIPDevice', TRUE);
				$device_port 	=	$this->input->post('txtPortDevice', TRUE);
				$inisial_lokasi =	$this->input->post('txtInisialLokasi', TRUE);
				$office 		=	$this->input->post('cmbLokasiKerja');

				$device_update 	=	array
									(
										'server_ip'				=>	$server_ip,
										'server_port'			=>	$server_port,
										'device_sn'				=>	$device_sn,
										'device_ip'				=>	$device_ip,
										'device_port'			=>	$device_port,
										'inisial_lokasi'		=>	$inisial_lokasi,
										'office'				=>	$office,
										'last_update_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
										'last_update_user'		=>	$this->session->user,
									);
				$this->M_monitoringpresensi->device_update($device_update, $id_lokasi);
				$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_device', array('id_lokasi' => $id_lokasi), 'UPDATE');
				redirect('PresenceManagement/MonitoringPresensiPengaturan');
			}
	//	}

	//	User Management
	//	{
			public function user_create()
			{
				$noind_baru 	=	$this->input->post('cmbPekerja', TRUE);
				
				$info_pekerja 	=	$this->M_monitoringpresensi->pekerja($noind_baru);

				foreach ($info_pekerja as $info)
				{
					if ( $this->M_monitoringpresensi->user_cek((int) $info['noind_baru']) == 0 )
					{
						$user_create	=	array
											(
												'noind_baru'		=>	(int) $info['noind_baru'],
												'noind'				=>	$info['noind'],
												'nama'				=>	$info['nama'],
												'pwd'				=>	'0',
												'rfid'				=>	'0',
												'privilege'			=>	'0',
												'create_timestamp'	=>	$this->general->ambilWaktuEksekusi(),
												'create_user'		=>	$this->session->user,
											);
						$id_user		=	$this->M_monitoringpresensi->user_create($user_create);
						$this->lib_monitoringpresensi->history('db_datapresensi', 'tb_user', array('id_user' => $id_user), 'CREATE');
					}
				}
				redirect('PresenceManagement/MonitoringPresensiPengaturan');
			}

			public function user_cek()
			{
				$noind_baru 	=	strtoupper($this->input->post('noind_baru'));

				$user_cek 		=	$this->M_monitoringpresensi->user_cek($noind_baru);

				$data['kode_cek'] 	=	0;

				if ( $user_cek > 0 )
				{
					$data['kode_cek']	=	1;
				}
				else
				{
					$data['kode_cek']	=	0;
				}

				echo json_encode($data);
			}
	//	}

	//	Javascript Functions
	//	{
			public function lokasi_kerja()
			{
				$keyword 			=	strtoupper($this->input->get('term'));

				$lokasi_kerja 		=	$this->M_monitoringpresensi->lokasi_kerja($keyword);
				echo json_encode($lokasi_kerja);
			}

			public function pekerja()
			{
				$keyword 			=	strtoupper($this->input->get('term'));

				$pekerja 			=	$this->M_monitoringpresensi->pekerja($keyword);
				echo json_encode($pekerja);
			}
	//	}

		public function CronUser(){
			redirect('http://personalia.quick.com/cronjob/mysql/cronjob.user_finger.php','refresh');
		}
}