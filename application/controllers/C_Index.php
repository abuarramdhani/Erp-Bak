<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Index extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('user_agent');
		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		//load the login model
		$this->load->library('session');
		$this->load->library('General');
		//$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('Api/ErpMobile/M_erpmobile');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		if ($this->session->userdata('logged_in') != TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			//redirect('');
		}
		setlocale (LC_TIME, "id_ID.utf8");
		//$this->load->model('CustomerRelationship/M_Index');
	}

	public function index()
	{
		if ($this->session->is_logged) {
			$this->session->set_userdata('responsibility', 'Dashboard');

			//$usr = "D1178";
			$user_id = $this->session->userid;
			//$data['user'] = $usr;
			$data['Menu'] = 'dashboard';

			if (base_url('') == 'http://182.23.18.195/') {
				$data['UserResponsibility'] = $this->M_user->getUserResponsibilityInternet($user_id);
			} else {
				$data['UserResponsibility'] = $this->M_user->getUserResponsibility($user_id);
			}

			$tema = $this->M_Index->getTheme();

			$this->session->set_userdata('tema', $tema[0]->theme);

			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('V_Index', $data);
			$this->load->view('V_Footer', $data);
		} else {
			$this->session->set_userdata('responsibility', 'Login');
			if ($this->session->gagal) {
				$data['error'] = "Login error, please enter correct username and password";
				$aksi = 'Login';
				$detail = 'Gagal Login';
				$this->log_activity->activity_log($aksi, $detail);
			} else {
				$data['error'] = "";
			}
			$this->load->view('V_Login', $data);
			$this->session->unset_userdata('gagal');
		}

		$this->session->unset_userdata('email');
		$this->session->unset_userdata('mygroup');
		$this->session->unset_userdata('error');
	}

	public function Responsibility($responsibility_id)
	{
		if ($this->session->is_logged) {
			//$usr = "D1178";
			$user_id = $this->session->userid;
			//$data['user'] = $usr;
			//$data['Menu'] = 'dashboard';

			$UserResponsibility = $this->M_user->getUserResponsibility($user_id, $responsibility_id);

			foreach ($UserResponsibility as $UserResponsibility_item) {
				$aksi = 'Akses Responsibility';
				$detail = $UserResponsibility_item['user_group_menu_name'];

				$this->log_activity->activity_log($aksi, $detail);

				$this->session->set_userdata('responsibility', $UserResponsibility_item['user_group_menu_name']);
				// if(empty($UserResponsibility_item['user_group_menu_id'])){
				// $UserResponsibility_item['user_group_menu_id'] = 0;
				// }
				$this->session->set_userdata('responsibility_id', $UserResponsibility_item['user_group_menu_id']);
				$this->session->set_userdata('module_link', $UserResponsibility_item['module_link']);
				$this->session->set_userdata('org_id', $UserResponsibility_item['org_id']);
				$this->session->set_userdata('javascript', $UserResponsibility_item['required_javascript']);
			}
			//$this->session->set_userdata('responsbility', 'a');
			//print_r($UserResponsibility);
			redirect($this->session->module_link);
			// $this->load->view('V_Header',$data);
			// $this->load->view('V_Sidemenu',$data);
			// $this->load->view('V_Index',$data);
			// $this->load->view('V_Footer',$data);
		} else {
			if ($this->session->gagal) {
				$data['error'] = "Login error, please enter correct username and password";
			} else {
				$data['error'] = "";
			}

			$this->session->set_userdata('responsibility', 'Login');
			$this->load->view('V_Login', $data);
			$this->session->unset_userdata('gagal');
		}
	}

	public function BackToLogin()
	{
		$this->load->view('V_Login');
	}

	public function home()
	{
		$this->checkSession();
		//$usr = "D1178";
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'dashboard';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('CustomerRelationship/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		} else {
			redirect('');
		}
	}

	public function login()
	{

		//$this->load->model('M_index');
		$username = $this->input->post('username');
		$username = strtoupper($username);
		$password = $this->input->post('password');

		$password_md5 = md5($password);

		$getAksesKDJabatan = $this->M_Index->getAksesKDJabatan($username);
		$ipaddresslast = $this->M_Index->getIpAddress($username);

		$ip = $this->input->ip_address();

		$log = $this->M_Index->login($username, $password_md5);
		if ($log) {
			// if ($getAksesKDJabatan[0]['kd_jabatan'] <= '13' || $getAksesKDJabatan[0]['kd_jabatan'] == '16' || $getAksesKDJabatan[0]['kd_jabatan'] == '19') {
			// 	// if ($username == 'B0661' || $username == 'B0898' || $username == 'B0773') {

			// 	if ($ip != $ipaddresslast[0]['ip_address']) {
			// 		$this->getAkses($username, $password_md5);
			// 	} else {
			// 		$user = $this->M_Index->getDetail($username);
			// 		$path = $this->M_Index->path_photo($username);

			// 		foreach ($user as $user_item) {
			// 			$iduser 			= $user_item->user_id;
			// 			$password_default 	= $user_item->password_default;
			// 			$kodesie			= $user_item->section_code;
			// 			$employee_name 		= $user_item->employee_name;
			// 			$kode_lokasi_kerja 	= $user_item->location_code;
			// 		}
			// 		$path_photo 		= trim($path);
			// 		$ses = array(
			// 			'is_logged' 		=> 1,
			// 			'userid' 			=> $iduser,
			// 			'user' 				=> strtoupper($username),
			// 			'employee'  		=> $employee_name,
			// 			'kodesie' 			=> $kodesie,
			// 			'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
			// 			'path_photo'		=> $path_photo,
			// 		);

			// 		$isDefaultPass = $this->M_Index->getPassword($username);
			// 		$ses['pass_is_default'] = $isDefaultPass;

			// 		$this->session->set_userdata($ses);

			// 		$aksi = 'Login';
			// 		$detail = 'Login';
			// 		$this->log_activity->activity_log2($aksi, $detail, $ip);

			// 		redirect(base_url());
			// 	}
			// } else {
			$user = $this->M_Index->getDetail($username);
			$path = $this->M_Index->path_photo($username);

			foreach ($user as $user_item) {
				$iduser 			= $user_item->user_id;
				$password_default 	= $user_item->password_default;
				$kodesie			= $user_item->section_code;
				$employee_name 		= $user_item->employee_name;
				$kode_lokasi_kerja 	= $user_item->location_code;
			}
			$path_photo 		= trim($path);
			$ses = array(
				'is_logged' 		=> 1,
				'userid' 			=> $iduser,
				'user' 				=> strtoupper($username),
				'employee'  		=> $employee_name,
				'kodesie' 			=> $kodesie,
				'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
				'path_photo'		=> $path_photo,
			);

			$isDefaultPass = $this->M_Index->getPassword($username);
			$ses['pass_is_default'] = $isDefaultPass;

			$this->session->set_userdata($ses);

			$aksi = 'Login';
			$detail = 'Login';
			$this->log_activity->activity_log2($aksi, $detail, $ip);

			redirect(base_url());
			// }
		} else {
			$ses = array(
				'gagal' => 1,
			);
			$this->session->set_userdata($ses);
			if (isset($this->session->last_page)) {
				redirect($this->session->last_page);
			} else {
				redirect('');
			}
		}
	}

	public function ChangePassword()
	{
		$this->checkSession();
		//$usr = "D1178";
		$user_id = $this->session->userid;
		$noind = $this->session->user;

		$data['UserData'] = $this->M_user->getUser($user_id);
		$data['id'] = $user_id;

		foreach ($data['UserData'] as $user) {
			$password = $user['user_password'];
		}

		$data['password'] = $password;

		$this->form_validation->set_rules('txtPasswordNow', 'username', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['error'] = '';
			$this->load->view('V_ChangePassword', $data);
		} else {
			if ($password == $this->input->post('txtPasswordNow')) {
				if ($this->input->post('txtPassword') != '' and $this->input->post('txtPasswordCheck') != '') {
					if (md5($this->input->post('txtPassword')) == $password) {
						$data['error'] = "Password Masih Sama";
						$this->load->view('V_ChangePassword', $data);
					} else {
						$aksi = 'Change Password';
						$detail = 'Change Password';
						$this->log_activity->activity_log($aksi, $detail);

						$data = array(
							'user_password'	=> md5($this->input->post('txtPassword')),
							'creation_date' =>  $this->input->post('hdnDate'),
							'created_by' =>  $this->input->post('hdnUser')
						);
						$this->M_user->updateUser($data, $user_id);
						$this->EmailAlert($noind, date('Y-m-d H:i:s'));
						redirect(base_url('logout'));
					}
				} else {
					$data['error'] = 'New Password Empty';
					$this->load->view('V_ChangePassword', $data);
				}
			} else {
				$aksi = 'Error Change Password';
				$detail = 'Error Change Password';
				$this->log_activity->activity_log($aksi, $detail);

				$data['error'] = 'Password Wrong';
				$this->load->view('V_ChangePassword', $data);
			}
		}
	}

	public function logout()
	{
		$aksi = 'Log Out';
		$detail = 'Log Out ERP';

		$this->log_activity->activity_log($aksi, $detail);


		$this->session->unset_userdata('is_logged');
		if ($this->session->gagal) {
			$this->session->unset_userdata('gagal');
		}

		//variabel session spl (surat perintah lembur) HR awal
		if ($this->session->spl_validasi_asska) {
			$this->session->unset_userdata('spl_validasi_asska');
		}
		if ($this->session->spl_validasi_kasie) {
			$this->session->unset_userdata('spl_validasi_kasie');
		}
		//variabel session spl (surat perintah lembur) HR akhir

		redirect('/');
	}

    /**
     * Render 404 page 
     * 
     */
	public function page_404()
	{
	    $this->output->set_status_header(404);
		return $this->load->view('V_404');
	}

	public function getLog()
	{
		$menu = $_POST['menu1'];

		$aksi = 'Akses Menu';
		$detail = 'Mengakses Menu ' . $menu;

		$this->log_activity->activity_log($aksi, $detail);
	}

	public function EmailAlert($noind, $waktu)
	{
		//email
		$getnama = $this->M_user->getDataUpdatePassword($noind);
		$emailUser = 'kasie_ict_hrd@quick.com';

		$subject = "Reset Password ERP";
		$body = "Pemberitahuan,
					<br>Pekerja dengan data sebagai berikut telah mengganti password erp:
					<br>
					<br><b>Noind&emsp;&emsp;:</b> $noind
					<br>
					<br><b>Nama&emsp;&emsp;:</b> " . $getnama[0]['nama'] . "
					<br>
					<br><b>Seksi &emsp;&emsp;:</b> " . $getnama[0]['seksi'] . "
					<br>
					<br><b>Tanggal &nbsp;&nbsp;:</b> " . date('d-m-Y H:i:s', strtotime($waktu)) . "
					<br><br>
					<hr>
					<br>Demikian yang dapat kami informasikan. Terimakasih";

		//send Email
		$this->load->library('PHPMailerAutoload');
		$mail = new PHPMailer();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';

		// set smtp
		$mail->isSMTP();
		$mail->Host = 'm.quick.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;

		// set email content
		$mail->setFrom('no-reply@quick.com', 'Email Sistem');
		$mail->addAddress($getnama[0]['email']);
		$mail->addAddress('kasie_ict_hrd@quick.com');
		$mail->Subject = $subject;
		$mail->msgHTML($body);

		// check error
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		}
	}
	public function getAkses($u, $p)
	{
		$otp = rand(1000, 9999);
		// echo $u;
		$data['otp'] = $otp;
		$data['user'] = $u;
		$data['pass'] = $p;


		$getnama = $this->M_Index->getEmail($u);

		$subject = "(Kode Akses ERP), Jangan Bagikan Ke Orang Lain !";
		$body = 'Kode Akses Login ERP anda adalah ' . $otp;

		//send Email
		$this->load->library('PHPMailerAutoload');
		$mail = new PHPMailer();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';

		// set smtp
		$mail->isSMTP();
		$mail->Host = 'm.quick.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;

		// set email content
		$mail->setFrom('no-reply@quick.com', 'Sistem ERP');
		$mail->addAddress($getnama[0]['email_internal']);
		$mail->Subject = $subject;
		$mail->msgHTML($body);

		// check error
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		}
		if ($getnama[0]['nomor'] == "-" || $getnama[0]['nomor'] == null || $getnama[0]['nomor'] == "") {
			$data['mygroup'] = '-';
		} else {
			$nomor1 = '+' . $getnama[0]['nomor'];
			$mygroup = str_replace("+62", "0", $nomor1);
			$pesan = nl2br("(Kode Akses ERP), Jangan Bagikan Ke Orang Lain ! \n Kode Akses Login ERP anda adalah $otp", false);
			$message = rawurlencode($pesan);
			$url = 'http://192.168.168.122:80/sendsms?username=ict&password=quick1953&phonenumber=' . $mygroup . '&message=' . $message . '&[port=gsm-1.2&][report=1&][timeout=20]';
			$cui = curl_init();
			curl_setopt($cui, CURLOPT_URL, $url);
			curl_setopt($cui, CURLOPT_HEADER, 0);
			curl_setopt($cui, CURLOPT_RETURNTRANSFER, true);
			curl_exec($cui);
			curl_close($cui);
			$data['mygroup'] = $mygroup;
		}
		// $data['mygroup'] = $mygroup;
		$data['email'] = $getnama;

		return $this->load->view('V_Otp', $data);
	}
	public function ReqOtp()
	{
		$u = $_POST['user_name'];
		$p = $_POST['password_u'];
		$this->getAkses($u, $p);
	}
	public function LoginAtasan()
	{
		$ip = $this->input->ip_address();
		// $ip = '192.168.168.133';
		$username = $this->input->post('username');
		$password_md5 = $this->input->post('password');
		$log = $this->M_Index->login($username, $password_md5);
		if ($log) {
			$user = $this->M_Index->getDetail($username);
			$path = $this->M_Index->path_photo($username);
			foreach ($user as $user_item) {
				$iduser 			= $user_item->user_id;
				$password_default 	= $user_item->password_default;
				$kodesie			= $user_item->section_code;
				$employee_name 		= $user_item->employee_name;
				$kode_lokasi_kerja 	= $user_item->location_code;
			}
			$path_photo 		= trim($path);
			$ses = array(
				'is_logged' 		=> 1,
				'userid' 			=> $iduser,
				'user' 				=> strtoupper($username),
				'employee'  		=> $employee_name,
				'kodesie' 			=> $kodesie,
				'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
				'path_photo'		=> $path_photo,
			);
			$isDefaultPass = $this->M_Index->getPassword($username);
			$ses['pass_is_default'] = $isDefaultPass;
			$this->session->set_userdata($ses);
			$aksi = 'Login';
			$detail = 'Login';
			$this->log_activity->activity_log2($aksi, $detail, $ip);
			redirect(base_url());
		}
	}

	public function lupa_password()
	{
		// print_r($_POST);
		$username = $this->input->post('username');
		$username = strtoupper(trim($username));
		$data = $this->M_Index->cekUsername($username);
		if (strlen($username) > 7 || empty($data)) {
			$this->session->set_userdata('error',"Error, username ".$username." tidak di temukan!");
			$this->session->set_userdata('gagal', 1);

			redirect('');
		}

		$tpribadi = $this->M_Index->getTpribadiIndex($data['employee_code']);
		$email_internal = trim($tpribadi->email_internal);
		$telkomsel_mygroup = trim($tpribadi->telkomsel_mygroup);
		$rand_pass = $this->M_Index->randomPassword();
		echo $rand_pass.'1<br>';
		$ubah_pswd = false;
		if ($email_internal != '-' && $email_internal != '') {
			echo $rand_pass.'2<br>';
			$this->kirimEmailIn($email_internal, $rand_pass);
			$this->session->set_userdata('email', $email_internal);
			$ubah_pswd = true;
		}
		if ($telkomsel_mygroup != '-' && $telkomsel_mygroup != '') {
			echo $rand_pass.'3<br>';
			$this->kirimSMS($telkomsel_mygroup, $rand_pass, $tpribadi->nama);
			$this->session->set_userdata('mygroup', $telkomsel_mygroup);
			$ubah_pswd = true;
		}

		if ($ubah_pswd) {
			echo $rand_pass.'4<br>';
			$md5 = md5($rand_pass);
			$this->M_erpmobile->changePassword($data['employee_code'], $md5);
			redirect('SuksesGantiPassword');
		}else{
			$this->session->set_userdata('error',"Error, username ".$username." tidak di memiliki Email ataupun Mygroup!");
			$this->session->set_userdata('gagal', 1);

			redirect('');
		}
	}

	public function kirimEmailIn($email, $pwd = '')
	{
		$this->load->library('PHPMailerAutoload');

		$message = "Pasword Akun ERP Anda hari ini adalah <b>".htmlspecialchars($pwd)."</b>
			<br>Pesan ini juga otomatis terkirim melalui SMS ke Nomor MyGroup apabila Bapak / Ibu mendapatkan alokasi HP MyGroup.
			<br>
			<br>
			<br>
			<br>
			<i style='font-size: 9pt'>Email ini digenerate secara otomatis melalui Sistem Generate Password pada tanggal : ".date('d-M-Y')." pukul : ".date('H:i:s')."</i>";
		$mail = new PHPMailer();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->isSMTP();
		$mail->Host = 'm.quick.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Username = 'no-reply';
		$mail->Password = '123456';
		$mail->WordWrap = 50;
		$mail->setFrom('no-reply@quick.com', 'Quick ERP Mobile');
		$mail->addAddress($email);
		// $mail->addAddress('enggal_aldiansyah@quick.com');
		$mail->Subject = "Password Akun ERP Anda Hari ini ".strftime('%A, %d %B %Y');
		$mail->msgHTML($message);
		$mail->AltBody = 'Password ERP Anda';

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			// echo "string";
		}
	}

	function kirimSMS($nomor, $rand_pass, $nama)
	{
		if (substr($nomor, 0,2) == "62") {
    		$nomor = '+'.$nomor;
		}
		$nomor = urlencode($nomor);
		if ($nomor%2 == 0) {
			$port = "gsm-1.2";
		}else{
			$port = "gsm-1.2";
		}

		$isi_sms = urlencode("Password Akun ERP Anda (".trim($nama).") hari ini ".strftime('%A, %d %B %Y')." adalah ".$rand_pass);
		// echo 'http://192.168.168.122/sendsms?username=ict&password=quick1953&phonenumber='.$nomor.'&message='.$isi_sms.'&[port='.$port.'&][report=1&][timeout=20]';
		$http_result = file_get_contents( 'http://192.168.168.122/sendsms?username=ict&password=quick1953&phonenumber='.$nomor.'&message='.$isi_sms.'&[port='.$port.'&][report=1&][timeout=20]' );
		$res = json_decode($http_result);
		$this->insert_log_sms($res);
	}

	function insert_log_sms($res)
	{
		$sms_message = isset($res->message) ? $res->message:'';
		$sms_phone_number = isset($res->report[0]->{'1'}[0]->phonenumber) ? $res->report[0]->{'1'}[0]->phonenumber:'';
		$sms_port = isset($res->report[0]->{'1'}[0]->port) ? $res->report[0]->{'1'}[0]->port:'';
		$sms_sent_time = isset($res->report[0]->{'1'}[0]->time) ? $res->report[0]->{'1'}[0]->time:'';
		$sms_result = isset($res->report[0]->{'1'}[0]->result) ? $res->report[0]->{'1'}[0]->result:'';

		$arr = array(
			'message'		=> $sms_message,
			'phone_number'	=> $sms_phone_number,
			'port'			=> $sms_port,
			'sent_time'		=> $sms_sent_time,
			'result'		=> $sms_result,
			'version'		=> 1,
			);
		return $this->M_Index->insertLogSMS($arr);
	}

	public function SuksesGantiPassword()
	{
		// print_r($this->session->userdata());
		$minFill = 4;
		$email = $this->session->email;
		$mygroup = $this->session->mygroup;

		if (strlen($email) < 2 && empty($mygroup)) {
			redirect('');
		}

		if (strlen($email) < 2) {
			$email = '-';
		}else{
			$email = preg_replace_callback(
				'/^(.)(.*?)([^@]?)(?=@[^@]+$)/u',
				function ($m) use ($minFill) {
					return $m[1]
					. str_repeat("*", max($minFill, mb_strlen($m[2], 'UTF-8')))
					. ($m[3] ?: $m[1]);
				},
				$email
				);
		}
		if(!empty($mygroup))
			$mygroup = substr($mygroup, 0, 10).'****';
		else
			$mygroup = '-';

		$data['email'] = $email;
		$data['mygroup'] = $mygroup;

		$this->load->view('V_SuksesGantiPassword', $data);
	}
}
