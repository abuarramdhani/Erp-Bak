<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
class MonitoringOJT
{

	function __construct()
	{
		$this->CI = &get_instance();

		date_default_timezone_set('Asia/Jakarta');

		$this->CI->load->model('SystemAdministration/MainMenu/M_user');

		$this->CI->load->model('MonitoringOJT/M_monitoring');
		
		$execution_timestamp 	=	date('Y-m-d H:i:s');
		$session_user 			=	$this->CI->session->user;
	}

	public function tb_pekerja_history($pekerja_id, $action)
	{
		$pekerja 		=	$this->CI->M_monitoring->ambilTabelDaftarPekerjaOJT($pekerja_id);

		foreach ($pekerja as $pkj)
		{
			$history 	=	array
							(
								'pekerja_id'					=>	$pkj['pekerja_id'],
								'noind_baru'					=>	$pkj['noind_baru'],
								'noind'							=>	$pkj['tgl_masuk'],
								'atasan'						=>	$pkj['atasan'],
								'selesai'						=>	$pkj['selesai'],
								'keluar'						=>	$pkj['keluar'],
								'jenjang_pendidikan_terakhir'	=>	$pkj['jenjang_pendidikan_terakhir'],
								'jurusan'						=>	$pkj['jurusan'],
								'institusi_pendidikan'			=>	$pkj['institusi_pendidikan'],
								'tanggal_lahir'					=>	$pkj['tanggal_lahir'],
								'keluar_tanggal'				=>	$pkj['keluar_tanggal'],

							);
		}
	}
}