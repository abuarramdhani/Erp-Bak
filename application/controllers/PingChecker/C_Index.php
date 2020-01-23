<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PingChecker/M_index');

		date_default_timezone_set("Asia/Bangkok");
	}

	public function checkSession()
	{
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Dashboard';

		$user = $this->session->user;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['ip'] = $this->M_index->getDataIPDown();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PingChecker/V_Dashboard',$data);
		$this->load->view('V_Footer',$data);
	}

	public function check()
	{
		// echo date('d-m-Y H:i:s');exit;
		$ipName = array(
					array(
						'name' => 'IconPlus PUSAT-BANJARMASIN',
						'ip' => '172.16.100.94',
					),
					array(
						'name' => 'IconPlus PUSAT-JAKARTA',
						'ip' => '172.16.100.26',
					),
					array(
						'name' => 'IconPlus PUSAT-LAMPUNG',
						'ip' => '172.16.100.14',
					),
					array(
						'name' => 'IconPlus PUSAT-LANGKAPURA',
						'ip' => '172.16.100.62',
					),
					array(
						'name' => 'IconPlus PUSAT-MAKASSAR',
						'ip' => '172.16.100.30',
					),
					array(
						'name' => 'IconPlus PUSAT-MEDAN',
						'ip' => '172.16.100.18',
					),
					array(
						'name' => 'IconPlus PUSAT-MLATI',
						'ip' => '172.16.100.22',
					),
					array(
						'name' => 'IconPlus PUSAT-PALU',
						'ip' => '172.16.100.102',
					),
					array(
						'name' => 'IconPlus PUSAT-PEKANBARU',
						'ip' => '172.16.100.90',
					),
					array(
						'name' => 'IconPlus PUSAT-PONTIANAK',
						'ip' => '172.16.100.50',
					),
					array(
						'name' => 'IconPlus PUSAT-SURABAYA',
						'ip' => '172.16.100.10',
					),
					array(
						'name' => 'IconPlus PUSAT-TUKSONO',
						'ip' => '172.16.100.6',
					),
					array(
						'name' => 'LDP PUSAT-TUKSONO',
						'ip' => '172.18.22.2',
					)
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
				
				$status = $this->M_index->checkStatusAction($domainbase);

				if ($status == null) {
					$stat = array(
									'creation_date' => 'now()',
									'ip' => $domainbase,
								 );
					$this->M_index->setStatus($stat);
					$time = date('d-m-Y H:i:s');
					$st = "OPEN";

					$message .="<br> STATUS : $st";
					$message .="<br> TIME : $time";
				}else {
					if ($status[0]['action'] == null) {
						$stat = array(
										'creation_date' => 'now()',
										'ip' => $domainbase,
								);
						$this->M_index->setStatus($stat);
						$time = date('d-m-Y H:i:s');
						$st = "OPEN";
						$message .="<br> STATUS : $st";
						$message .="<br> TIME : $time";
					}else {
						$action = $status[0]['action'];
						$actBy = $status[0]['action_by'];
						$noticket = $status[0]['no_ticket'];
								$stat = array(
									'creation_date' => 'now()',
									'ip' => $domainbase,
									'action' => $action,
									'action_by' => $actBy,
									'no_ticket' => $noticket,
							);
						$this->M_index->setStatus($stat);

						$time = date('d-m-Y H:i:s');
						$st = "WIP";
						$message .="<br> STATUS : $st";
						$message .="<br> TIME : $time";
						$message .="<br> Action : <b>$action</b>";
						$message .="<br> Action By : $actBy";
					}
				}
				
				$subject = "($st) ".$ip['name']." is Down";
                $this->EmailAlert($subject, $message);
	            
			}
            
		}

	}

	public function pingDomain($domain)
	{
		$starttime = microtime(true);
		$file      = fsockopen ($domain, 82, $errno, $errstr, 10);
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
        
        $akun = array("quick.tractor@gmail.com", "it.sec1@quick.co.id", "it1.quick@gmail.com", "nugroho.mail1@gmail.com", "ict.hardware.khs@gmail.com", "it.asst.u1@quick.co.id", "khoerulamri.id@gmail.com");
        
        // $akun = array("suryabondan@gmail.com");
        
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
