<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Email extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('PHPMailerAutoload');

		$this->load->library('General');

		$this->load->library('MonitoringOJT');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringOJT/M_masterorientasi');
		$this->load->model('MonitoringOJT/M_monitoring');
		$this->load->model('MonitoringOJT/M_email');

		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		//	Inisialisasi pengaturan email
		//	{
				$mail 	= new PHPMailer(); 
		        $mail->SMTPDebug 		= 	0;
		        $mail->Debugoutput 		= 	'html';
		        $mail->isSMTP();
		        $mail->Host 			= 	'mail.quick.com';
		        $mail->Port 			= 	465;
		        $mail->SMTPAuth 		= 	true;
				$mail->SMTPSecure 		= 	'ssl';
				$mail->SMTPOptions 		= 	array
											(
												'ssl' => array(
												'verify_peer' => false,
												'verify_peer_name' => false,
												'allow_self_signed' => true)
											);
		        $mail->Username = 'no-reply';
		        $mail->Password = '123456';
		//	}

		//	Ambil tanggal hari ini
		//	{
				$hari_ini	=	date('Y-m-d');

				echo '<b><u>Notifikasi OJT hari ini : '.$hari_ini.'</u></b><br/>';
		//	}

		//	Ambil pemberitahuan hari ini (tb_proses, tb_pekerja, tb_proses_pemberitahuan_format_email)
		//	{
				$ambil_pemberitahuan 	=	$this->M_email->pemberitahuan_email($hari_ini);
		//	}

		//	Proses kirim email
		//	{
				foreach ($ambil_pemberitahuan as $email)
				{
					if ( ! ((empty($email['email_pekerja'])) AND (empty($email['email_atasan']))) )
					{
						$jabatan_atasan 			=	'';
						$jabatan_atasan_pekerja 	=	$this->M_email->jabatan_atasan_pekerja($email['atasan']);

						for ($i=0; $i < count($jabatan_atasan_pekerja); $i++)
						{ 
							$jabatan_atasan 		.=	$jabatan_atasan_pekerja[$i]['jabatan'];
							if ( count($jabatan_atasan_pekerja) > 1 AND $i < (count($jabatan_atasan_pekerja)-1) )
							{
								$jabatan_atasan 	.=	'<br/>';
							}
						}

						$isi_pesan 	=	$email['format'];

						$tanggal_proses_tahapan 	=	'';

						$tanggal_awal_bahasa 	=	date('d F Y', strtotime($email['tgl_awal']));
						$tanggal_akhir_bahasa 	=	date('d F Y', strtotime($email['tgl_akhir']));

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
												'November',
												'Desember',
											);

						$tanggal_awal_bahasa 	=	str_replace($bulan_en, $bulan_id, $tanggal_awal_bahasa);
						$tanggal_akhir_bahasa 	=	str_replace($bulan_en, $bulan_id, $tanggal_akhir_bahasa);

						if ( strtotime($email['tgl_akhir']) > strtotime($email['tgl_awal']) )
						{
							$tanggal_proses_tahapan 	=	$tanggal_awal_bahasa.' s.d. '.$tanggal_akhir_bahasa;
						}
						else
						{
							$tanggal_proses_tahapan 	=	$tanggal_awal_bahasa;
						}

						$variabel_format 	=	array
												(
													'[nama_atasan_pekerja]',
													'[jabatan_atasan_pekerja]',
													'[nomor_induk_pekerja_ojt]',
													'[nama_pekerja_ojt]',
													'[seksi_pekerja_ojt]',
													'[nama_tahapan_ojt]',
													'[tanggal_proses]',
												);

						$variabel_ubah		=	array
												(
													$email['nama_atasan_pekerja'],
													$jabatan_atasan,
													$email['noind'],
													$email['nama_pekerja_ojt'],
													$email['seksi_pekerja_ojt'],
													$email['tahapan'],
													$tanggal_proses_tahapan,
												);

						$format_hasil_ubah 	=	str_replace($variabel_format, $variabel_ubah, $isi_pesan);

						if( $email['id_tujuan']=='2' )
						{
							$mail->addAddress($email['email_pekerja'], $email['nama_pekerja_ojt']);
						}
						elseif( $email['id_tujuan']=='3' )
						{
							$mail->addAddress($email['email_atasan'], $email['nama_atasan_pekerja']);
						}

						$mail->setFrom('noreply@quick.com', 'Sistem Monitoring OJT D3-S1 Quick ERP');
				        $mail->Subject 	= 'Notifikasi Tahapan OJT - '.$email['noind'].' - '.$email['nama_pekerja_ojt'];

				        $mail->msgHTML($format_hasil_ubah);
		
						if( ! $mail->send() )
						{
							echo 'Notifikasi Tahapan OJT - '.$email['noind'].' - '.$email['nama_pekerja_ojt'].' gagal terkirim!<br/>';
							echo "Mailer Error: " . $mail->ErrorInfo;
							show_error($this->email->print_debugger());
							echo '<br/>';
						}
						else
						{
							echo 'Notifikasi Tahapan OJT - '.$email['noind'].' - '.$email['nama_pekerja_ojt'].' terkirim!<br/>';
						}
					}
				}
		//	}
	}
}