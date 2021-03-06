<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_ErpMobile extends CI_Controller {
   function __construct() {
        parent::__construct();
		$this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
	    $this->load->model('Api/ErpMobile/M_erpmobile');

	}

	public function cekNoind()
	{
		$noind = $this->input->get('noind');
		$noind = strtoupper($noind);
		if (strlen($noind) > 7) {
			$data['result'] = 'Username Tidak di Temukan';
			$data['code'] = 0;
			echo json_encode($data);
			return;
			exit();
		}

		$data = $this->M_erpmobile->getNoindErp($noind);

		if (empty($data)) {
			$data['result'] = 'Username Tidak di Temukan';
			$data['code'] = 0;
		}elseif (empty(trim($data['external_mail']))) {
			$data['result'] = 'Email Kosong';
			$data['code'] = 1;
		}else{
			$data['result'] = 'Email di Temukan';
			$data['code'] = 2;
			$rand_pass = $this->randomPassword(6, false, 'lud');
			$data['password'] = $rand_pass;
			$pass = md5($rand_pass);
			$this->M_erpmobile->changePassword($noind, $pass);
			$data['change'] = true;
			$this->kirimEmailEx(trim($data['external_mail']), $data['password']);
			$data['external_mail'] = preg_replace('/(?:^|@).\K|\.[^@]*$(*SKIP)(*F)|.(?=.*?\.)/', '*', trim($data['external_mail']));
		}

		$pkj = $this->M_erpmobile->getinfoPKJ($noind);
		if(!empty($pkj) && !empty(trim($pkj['telkomsel_mygroup'])))
			$data['sms'] = $this->kirimSMSpass($pkj['telkomsel_mygroup'], $pkj['nama'], $rand_pass);

		echo json_encode($data);
	}

	public function saveEmail()
	{
		$noind = $this->input->post('noind');
		$noind = strtoupper($noind);
		$email = $this->input->post('email');

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		$data['code'] = 0;
    		$data['result'] = 'Invalid Email';

    		echo json_encode($data);
    		return;exit();
		}

		$arr = array(
			'external_mail' => $email
			);
		$save = $this->M_erpmobile->saveEmail($arr, $noind);

		$data = $this->M_erpmobile->getNoindErp($noind);
		$data['result'] = 'Email di Temukan';
		$rand_pass = $this->randomPassword(6, false, 'lud');
		$data['password'] = $rand_pass;
		$pass = md5($rand_pass);
		$this->M_erpmobile->changePassword($noind, $pass);
		$data['change'] = true;
		$this->kirimEmailEx(trim($data['external_mail']), $data['password']);
		$data['external_mail'] = preg_replace('/(?:^|@).\K|\.[^@]*$(*SKIP)(*F)|.(?=.*?\.)/', '*', trim($data['external_mail']));

		$pkj = $this->M_erpmobile->getinfoPKJ($noind);
		if(!empty($pkj) && !empty(($pkj['telkomsel_mygroup'])))
			$data['sms'] = $this->kirimSMSpass($pkj['telkomsel_mygroup'], $pkj['nama'], $rand_pass);

		echo json_encode($data);
	}

	public function kirimEmailEx($email, $pwd = '')
	{
		// return true;
		// echo $email;exit();
		$this->load->library('PHPMailerAutoload');

		$message = '<p>Password ERP Anda Adalah <b>'.$pwd.'</b></p>';

		$mail = new PHPMailer();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';

		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		// $mail->SMTPOptions = array(
		// 	'ssl' => array(
		// 		'verify_peer' => false,
		// 		'verify_peer_name' => false,
		// 		'allow_self_signed' => true
		// 	)
		// );
		$mail->Username = 'notification.hrd.khs1@gmail.com';
		$mail->Password = 'tes123123123';
		$mail->WordWrap = 50;
		$mail->setFrom('noreply@quick.co.id', 'Quick ERP Mobile');
		$mail->addAddress($email);
		// $mail->addAddress('enggalaldian@gmail.com');
		$mail->Subject = 'Password ERP Anda '.$pwd;
		$mail->msgHTML($message);
		$mail->AltBody = 'Password ERP Anda';

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			// echo "string";
		}
	}

	function randomPassword($length = 6, $add_dashes = false, $available_sets = 'luds')
	{
		$sets = array();
		if(strpos($available_sets, 'l') !== false)
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		if(strpos($available_sets, 'u') !== false)
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		if(strpos($available_sets, 'd') !== false)
			$sets[] = '23456789';
		if(strpos($available_sets, 's') !== false)
			$sets[] = '!@#$%&*?';
		$all = '';
		$password = '';
		foreach($sets as $set)
		{
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);
		for($i = 0; $i < $length - count($sets); $i++)
			$password .= $all[array_rand($all)];
		$password = str_shuffle($password);
		if(!$add_dashes)
			return $password;
		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while(strlen($password) > $dash_len)
		{
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		$dash_str .= $password;
		return $dash_str;
	}

	function insert_log_sms($res)
	{
		$sms_message = isset($res->message) ? $res->message:'';
		$sms_phone_number = isset($res->report[0]->{'1'}[0]->phonenumber) ? $res->report[0]->{'1'}[0]->phonenumber:'';
		$sms_port = isset($res->report[0]->{'1'}[0]->port) ? $res->report[0]->{'1'}[0]->port:'';
		$sent_time = isset($res->report[0]->{'1'}[0]->time) ? $res->report[0]->{'1'}[0]->time:'';
		$sms_result = isset($res->report[0]->{'1'}[0]->result) ? $res->report[0]->{'1'}[0]->result:'';
		$queryInsertLog = "insert into si.si_sent_sms
		(message,phone_number,port,sent_time,result,version)
		values($1,$2,$3,$4,$5,$6)";
		$arr = [
		'message'=> $sms_message,
		'phone_number'=> $sms_phone_number,
		'port'=> $sms_port,
		'sent_time'=> $sent_time,
		'result'=> $sms_result,
		'version'=> 1,
		];

		return $this->M_erpmobile->save_smslog($arr);
	}

	function kirimSMSpass($nomor, $nama, $rand_pass)
	{
		$nomor = trim($nomor);
		$nama = trim($nama);
		$rand_pass = trim($rand_pass);
		if (substr($nomor, 0,2) == "62") {
    		$nomor = '+'.$nomor;
		}
		$nomor = urlencode($nomor);
		if ($nomor%2 == 0) {
			$port = "gsm-1.2";
		}else{
			$port = "gsm-1.2";
		}

		$isi_sms = urlencode("Password Akun ERP Anda (".$nama.") hari ini adalah ".$rand_pass);
		// echo 'http://192.168.168.122/sendsms?username=ict&password=quick1953&phonenumber='.$nomor.'&message='.$isi_sms.'&[port='.$port.'&][report=1&][timeout=20]';exit();
		$http_result = file_get_contents( 'http://192.168.168.122/sendsms?username=ict&password=quick1953&phonenumber='.$nomor.'&message='.$isi_sms.'&[port='.$port.']&[report=1]&[timeout=20]' );
		$res = json_decode($http_result);


		return $this->insert_log_sms($res);
	}
}