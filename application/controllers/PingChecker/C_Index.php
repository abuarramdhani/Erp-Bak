<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		// $this->load->model('M_index');
	}

	public function check()
	{
		$ipName = array(
					array(
						'name' => 'ICON PLUS pusat-banjarmasin',
						'ip' => '172.16.100.94',
					),
					array(
						'name' => 'ICON PLUS pusat-jakarta',
						'ip' => '172.16.100.26',
					),
					array(
						'name' => 'ICON PLUS pusat-lampung',
						'ip' => '172.16.100.14',
					),
					array(
						'name' => 'ICON PLUS pusat-langkapura',
						'ip' => '172.16.100.62',
					),
					array(
						'name' => 'ICON PLUS pusat-makassar',
						'ip' => '172.16.100.30',
					),
					array(
						'name' => 'ICON PLUS pusat-medan',
						'ip' => '172.16.100.18',
					),
					array(
						'name' => 'ICON PLUS pusat-mlati',
						'ip' => '172.16.100.22',
					),
					array(
						'name' => 'ICON PLUS pusat-palu',
						'ip' => '172.16.100.102',
					),
					array(
						'name' => 'ICON PLUS pusat-pekanbaru',
						'ip' => '172.16.100.90',
					),
					array(
						'name' => 'ICON PLUS pusat-pontianak',
						'ip' => '172.16.100.50',
					),
					array(
						'name' => 'ICON PLUS pusat-surabaya',
						'ip' => '172.16.100.10',
					),
					array(
						'name' => 'ICON PLUS pusat-tuksono',
						'ip' => '172.16.100.6',
					),
					array(
						'name' => 'LDP pusat-tuksono',
						'ip' => '172.18.22.2',
					),
		);
		
		foreach ($ipName as $key => $ip) {
			$domainbase = $ip['ip'];

			$status = $this->pingDomain($domainbase);
	
			if ($status != -1) {
	
				echo "<tr><td>http://$domainbase is ALIVE ($status ms)</td><tr>";
				$message = "http://$domainbase is ALIVE ($status ms)";
			}else {
	
				echo "<tr><td>http://$domainbase is DOWN</td><tr>";
				$message = "http://$domainbase is DOWN ($status ms)";
	
			}
            $subject = "".strtoupper($ip['name'])." is Down";
    
            $this->EmailAlert($subject, $message);
		}




	}

	public function pingDomain($domain)
	{
		$starttime = microtime(true);
		$file      = fsockopen ($domain, 80, $errno, $errstr, 10);
		$stoptime  = microtime(true);
		$status    = 0;
	
		if (!$file) $status = -1;  // Site is down
		else {
			fclose($file);
			$status = ($stoptime - $starttime) * 1000;
			$status = floor($status);
		}
		return $status;
	}

	public function EmailAlert($subject , $body)
	{
		//email
		// $emailUser = 'suryabondan@gmail.com';
        
        $akun = array("quick.tractor@gmail.com","suryabondan@gmail.com");

		//send Email

		$this->load->library('PHPMailerAutoload');
		$mail = new PHPMailer();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
		
        // set smtp
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPOptions = array(
				'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true)
				);
        $mail->Username = 'quick.tractor@gmail.com';
        $mail->Password = 'quick1953';
        $mail->WordWrap = 50;
		
        // set email content
        $mail->setFrom('quick.tractor@gmail.com', 'ERP PING-CHECKER');
        foreach ($akun as $key => $akn) {
            $mail->addAddress($akn);
        }
        $mail->Subject = $subject;
		$mail->msgHTML($body);

		
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit();
		} else {
			echo "Message sent!";
		}
	}
}
