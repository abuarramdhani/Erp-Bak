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
			$passwd = $this->M_erpmobile->getPwdErpLog($noind);
			if (empty($passwd)) {
				$data['password'] = '';
			}else{
				$data['password'] = $passwd['ket'];
			}
			$this->kirimEmailEx(trim($data['external_mail']), $data['password']);
			$data['external_mail'] = preg_replace('/(?:^|@).\K|\.[^@]*$(*SKIP)(*F)|.(?=.*?\.)/', '*', trim($data['external_mail']));
		}

		echo json_encode($data);
	}

	public function saveEmail()
	{
		$noind = $this->input->post('noind');
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
		$data['code'] = 2;
		$passwd = $this->M_erpmobile->getPwdErpLog($noind);
		if (empty($passwd)) {
			$data['password'] = '';
		}else{
			$data['password'] = $passwd['ket'];
		}
		$this->kirimEmailEx(trim($data['external_mail']), $data['password']);
		$data['external_mail'] = preg_replace('/(?:^|@).\K|\.[^@]*$(*SKIP)(*F)|.(?=.*?\.)/', '*', trim($data['external_mail']));

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
		$mail->Host = 'mail.quick.co.id';
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
		$mail->Username = 'noreply@quick.co.id';
		$mail->Password = 'FH6vzD9vq';
		$mail->WordWrap = 50;
		$mail->setFrom('noreply@quick.co.id', 'Quick ERP Mobile');
		$mail->addAddress($email);
		// $mail->addAddress('enggalaldian@gmail.com');
		$mail->Subject = 'Password ERP Anda';
		$mail->msgHTML($message);
		$mail->AltBody = 'Password ERP Anda';

		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			// echo "string";
		}
	}
}