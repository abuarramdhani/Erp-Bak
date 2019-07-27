<?php
set_time_limit(0);
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class C_TarikFingerspot extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('TarikFingerspot/M_tarikfingerspot');

		//$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Tarik FingerSpot';
		$data['Menu'] = 'tarik Fingerspot';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TarikFingerspot/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function TarikData($tanggal=FALSE){
		$user_id = $this->session->userid;

		$data['Title'] = 'Tarik FingerSpot';
		$data['Menu'] = 'tarik Fingerspot';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('required');
		if($this->form_validation->run() === TRUE){

			$tanggal = $this->input->post('txtTanggalTarikFinger');
			$data['table'] = $this->M_tarikfingerspot->getAttLog($tanggal,'');
			$encrypted_string = $this->encrypt->encode($tanggal);
            $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			$data['tanggal'] = $encrypted_string;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('TarikFingerspot/V_tarikdata',$data);
			$this->load->view('V_Footer',$data);
		}else{
			if (isset($tanggal) and !empty($tanggal)) {

				$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $tanggal);
				$plaintext_string = $this->encrypt->decode($plaintext_string);

				$log = $this->M_tarikfingerspot->getAttLog($plaintext_string,'');
				$no = 0;
				$insert = array();
				foreach ($log as $key) {

					$data_presensi = array(
						'tanggal' => $key['tanggal'],
						'waktu' => $key['waktu'],
						'noind' => $key['noind'],
						'kodesie' => $key['kodesie'],
						'noind_baru' => $key['noind_baru'],
						'user_' => $key['user_']
					);

					if (substr($key['noind'], 0,1) == 'L') {
						$cek = $this->M_tarikfingerspot->cekPresensiL($data_presensi);
					}else{
						$cek = $this->M_tarikfingerspot->cekPresensi($data_presensi);
					}


					if ($cek == '0') {

						if (substr($key['noind'], 0,1) == 'L') {
							//	Kirim ke Presensi.tprs_shift2
							//	{
				 					$data_presensi['transfer']	=	FALSE;
				 					// $data_presensi['user_']		=	'CRON';
				 					$this->M_tarikfingerspot->insert_presensi('"Presensi"', 'tprs_shift2', $data_presensi);
							//	}
						}else{
							//	Kirim ke FrontPresensi.tpresensi
							//	{
									$data_presensi['transfer']	=	TRUE;
				 					$this->M_tarikfingerspot->insert_presensi('"FrontPresensi"', 'tpresensi', $data_presensi);
							//	}

							//	Kirim ke Catering.tpresensi
							//	{
				 					$data_presensi['transfer']	=	FALSE;
				 					$this->M_tarikfingerspot->insert_presensi('"Catering"', 'tpresensi', $data_presensi);
							//	}

							//	Kirim ke Presensi.tprs_shift
							//	{
				 					$data_presensi['transfer']	=	FALSE;
				 					// $data_presensi['user_']		=	'CRON';
				 					$this->M_tarikfingerspot->insert_presensi('"Presensi"', 'tprs_shift', $data_presensi);
							//	}

							//	Kirim ke Presensi.tpresensi_riil
							//	{
				 					$data_presensi['transfer']	=	FALSE;
									$data_presensi['nomor_sn']  = $key['nomor_sn'];
				 					$this->M_tarikfingerspot->insert_presensi('"Presensi"', 'tpresensi_riil', $data_presensi);
							//	}
						}


			 			$insert[$no] = $key;
			 			$no++;
					}
				}
				echo "Data Diinsert : ".$no."<br><br>";
				foreach ($insert as $key) {
					print_r($key);echo "<br>";
				}
			}else{

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('TarikFingerspot/V_tarikdata',$data);
				$this->load->view('V_Footer',$data);
			}
		}

	}

	public function TransferPresensi($server){
		$waktuAwal = date('Y-m-d H:i:s');
		date_default_timezone_set('Asia/Jakarta');
		$plaintext_string = Date('Y-m-d',strtotime("-1 days"));
		if (!isset($server)) {
			$server='';
		}
		if('192.168.168.50'==$server)
		{
		$log = $this->M_tarikfingerspot->getAttLog($plaintext_string,'Transfer');
		$device = $this->M_tarikfingerspot->getDevice();
		}
		else
		if('192.168.168.178'==$server)
		{
		$log = $this->M_tarikfingerspot->getAttLog($plaintext_string,'Transfer178');
		$device = $this->M_tarikfingerspot->getDevice();
		}
		else
		if('192.168.168.179'==$server)
		{
		$log = $this->M_tarikfingerspot->getAttLog($plaintext_string,'Transfer179');
		$device = $this->M_tarikfingerspot->getDevice();
		}
		else
		if('192.168.168.207'==$server)
		{
		$log = $this->M_tarikfingerspot->getAttLog($plaintext_string,'Transfer207');
		$device = $this->M_tarikfingerspot->getDevice();
		}
		else
		{
		$log = $this->M_tarikfingerspot->getAttLog($plaintext_string,'');
		$device = $this->M_tarikfingerspot->getDevice();
		}


		$no = 0;
		$num = 0;
		$insert = array();
		$lokasi = array();
		foreach ($log as $key) {

			$data_presensi = array(
				'tanggal' => $key['tanggal'],
				'waktu' => $key['waktu'],
				'noind' => $key['noind'],
				'kodesie' => $key['kodesie'],
				'noind_baru' => $key['noind_baru'],
				'user_' => $key['user_']
			);

			if (substr($key['noind'], 0,1) == 'L') {
				$cek = $this->M_tarikfingerspot->cekPresensiL($data_presensi);
			}else{
				$cek = $this->M_tarikfingerspot->cekPresensi($data_presensi);
			}


			if ($cek == '0') {

				if (substr($key['noind'], 0,1) == 'L') {
					//	Kirim ke Presensi.tprs_shift2
					//	{
		 					$data_presensi['transfer']	=	FALSE;
		 					// $data_presensi['user_']		=	'CRON';
		 					$this->M_tarikfingerspot->insert_presensi('"Presensi"', 'tprs_shift2', $data_presensi);
					//	}
				}else{
					//	Kirim ke FrontPresensi.tpresensi
					//	{
							$data_presensi['transfer']	=	TRUE;
		 					$this->M_tarikfingerspot->insert_presensi('"FrontPresensi"', 'tpresensi', $data_presensi);
					//	}

					//	Kirim ke Catering.tpresensi
					//	{
		 					$lokasikerja=$this->M_tarikfingerspot->cekLokasiKerja($data_presensi);

		 					foreach ($lokasikerja as $lk) {
		 						# untuk yang dihitung catering saat ini hanya yang pusat mlati
		 						if('01'==$lk || '03'==$lk)
		 						{
		 							$data_presensi['transfer']	=	FALSE;
		 							$this->M_tarikfingerspot->insert_presensi('"Catering"', 'tpresensi', $data_presensi);
		 						}
		 					}
		 					
					//	}

					//	Kirim ke Presensi.tprs_shift
					//	{
		 					$data_presensi['transfer']	=	FALSE;
		 					// $data_presensi['user_']		=	'CRON';
		 					$this->M_tarikfingerspot->insert_presensi('"Presensi"', 'tprs_shift', $data_presensi);
					//	}

					//	Kirim ke Presensi.tpresensi_riil
					//	{
		 					$data_presensi['transfer']	=	FALSE;
							$data_presensi['nomor_sn']  = $key['nomor_sn'];
		 					$this->M_tarikfingerspot->insert_presensi('"Presensi"', 'tpresensi_riil', $data_presensi);
					//	}
				}


	 			$insert[$no] = $key;
	 			$idx = 0;
	 			foreach ($device as $dev) {
	 				if ($dev['inisial_lokasi'] == $data_presensi['user_']) {
	 					$device[$idx]['jumlah'] = intval($device[$idx]['jumlah']) + 1;
	 				}
	 				$idx++;
	 			}
	 			$no++;
			}
			$num++;
		}
		echo "Data Diinsert : ".$no."<br><br>";
		foreach ($insert as $key) {
			print_r($key);echo "<br>";
		}

		$this->load->library('PHPMailerAutoload');

		$table = "";
		foreach ($device as $dvc) {
			if($dvc['lokasi_server_tarik_data']==$server or '' == $server)
			{
			$table .= "	<tr>
							<td style='width:400px;text-align:left;'>
								".$dvc['device_name']."
							</td>
							<td style='width:100px;text-align:left;'>
								".$dvc['inisial_lokasi']."
							</td>
							<td style='width:100px;'>
								".$dvc['jumlah']."
							</td>
						</tr>";
			}

		}
		$text = "jumlah data yang telah proses hari ini dan kemarin : ".($num - 1).".<br>
				Apabila Ada hari kemarin yang baru masuk, maka harus menjalankan distribusi ulang (Sehingga Point dan sebaran pekerja Benar).";

		$waktuAkhir = date('Y-m-d H:i:s');
		if(''==$server){
			$namaserver='Semua Server';
		}
		else
		{
			$namaserver=$server;
		}

		$message = '	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://wwwhtml4/loose.dtd">
				<html>
				<head>
			 	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
			  	<title>Mail Generated By System</title>
			  	<style>
				#main 	{
   	 						border: 1px solid black;
   	 						text-align: center;
   	 						border-collapse: collapse;
   	 						width: 500px;
						}
			  	</style>
				</head>
				<body>
						<h3 style="text-decoration: underline;">Report Proses Transfer</h3>
						<p>Dari : '.$namaserver.' ke database.quick.com (Frontpresensi & Presensi)</p>
					<hr/>
					<p>Telah Selesai Dijalankannya Cronjob TransferPresensi ('.$waktuAwal.' s/d '.$waktuAkhir.'), Dengan detail data per Lokasi sebagai berikut :
					</p>
						<table id="main">
						'.$table.'
						</table>
					<br>
					<b>
						'.$text.'
					</b>
					<p>
					Segera check apakah semua data tertarik.
					</p>

				</body>
				</html>';

		$mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

        $mail->isSMTP();
        $mail->Host = 'mail.quick.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true)
				);
        $mail->Username = 'no-reply';
        $mail->Password = '123456';
        $mail->WordWrap = 50;
        $mail->setFrom('noreply@quick.com', 'Email Sistem');

        $email['0'] = array(
        	'email_kirim' => 'kasie_ict_hrd@quick.com',
        	'nama_kirim' => 'Kasie ICT HRD'
        );
        $email['1'] = array(
        	'email_kirim' => 'edp@quick.com',
        	'nama_kirim' => 'EDP'
        );
        $email['2'] = array(
        	'email_kirim' => 'hbk@quick.com',
        	'nama_kirim' => 'Hubungan Kerja'
        );
        foreach ($email as $key) {
        	$mail->addAddress($key['email_kirim'],$key['nama_kirim']);
        }

        if('192.168.168.50'==$server)
        {
        	$mail->Subject = 'Laporan Tarik Absensi Server 168.50';
        } else if('192.168.168.178'==$server)
        {
        	$mail->Subject = 'Laporan Tarik Absensi Server 168.178';
        } else if('192.168.168.179'==$server)
        {
        	$mail->Subject = 'Laporan Tarik Absensi Server 168.179';
        } else if('192.168.168.207'==$server)
        {
        	$mail->Subject = 'Laporan Tarik Absensi Server 168.207';
        }
        else
        {
       		$mail->Subject = 'Laporan Tarik Absensi Pekerja Semua Titik';
        }



		$mail->msgHTML($message);

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			show_error($this->email->print_debugger());
		}
	}
}
?>
