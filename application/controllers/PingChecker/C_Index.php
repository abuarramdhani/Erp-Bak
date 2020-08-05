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
						'ip' => '172.16.100.93',
						'ip2' => '172.16.100.94',
					),
					array(
						'name' => 'IconPlus PUSAT-JAKARTA',
						'ip' => '172.16.100.25',
						'ip2' => '172.16.100.26',
					),
					array(
						'name' => 'IconPlus PUSAT-LANGKAPURA',
						'ip' => '172.16.100.61',
						'ip2' => '172.16.100.62',
					),
					array(
						'name' => 'IconPlus PUSAT-MAKASSAR',
						'ip' => '172.16.100.29',
						'ip2' => '172.16.100.30',
					),
					array(
						'name' => 'IconPlus PUSAT-MEDAN',
						'ip' => '172.16.100.17',
						'ip2' => '172.16.100.18',
					),
					array(
						'name' => 'IconPlus PUSAT-MLATI',
						'ip' => '172.16.100.21',
						'ip2' => '172.16.100.22',
					),
					array(
						'name' => 'IconPlus PUSAT-PALU',
						'ip' => '172.16.100.101',
						'ip2' => '172.16.100.102',
					),
					array(
						'name' => 'IconPlus PUSAT-PEKANBARU',
						'ip' => '172.16.100.89',
						'ip2' => '172.16.100.90',
					),
					array(
						'name' => 'IconPlus PUSAT-PONTIANAK',
						'ip' => '172.16.100.49',
						'ip2' => '172.16.100.50',
					),
					array(
						'name' => 'IconPlus PUSAT-SURABAYA',
						'ip' => '172.16.100.9',
						'ip2' => '172.16.100.10',
					),
					array(
						'name' => 'IconPlus PUSAT-TUKSONO',
						'ip' => '172.16.100.5',
						'ip2' => '172.16.100.6',
					),
					array(
						'name' => 'LDP PUSAT-TUKSONO',
						'ip' => '172.18.22.1',
						'ip2' => '172.18.22.2',
					),
					array(
						'name' => 'TUKSONO PNP',
						'ip' => '192.168.38.25',
						'ip2' => '192.168.38.25',
					),
					array(
						'name' => 'TUKSONO SHEET METAL',
						'ip' => '192.168.38.11',
						'ip2' => '192.168.38.11',
					),
					array(
						'name' => 'TUKSONO MACH TIMUR',
						'ip' => '192.168.38.22',
						'ip2' => '192.168.38.22',
					),
					/*array(
						'name' => 'TUKSONO MACH BARAT',
						'ip' => '192.168.38.203',
						'ip2' => '192.168.38.203',
					),*/
					array(
						'name' => 'TUKSONO FOUNDRY',
						'ip' => '192.168.38.14',
						'ip2' => '192.168.38.14',
					),
					array(
						'name' => 'TUKSONO HTM',
						'ip' => '192.168.38.24',
						'ip2' => '192.168.38.24',
					),
		);
		
		$messagesTemp ='';
		foreach ($ipName as $key => $ip) {
			$domainbase = $ip['ip'];
			$domainbase2 = $ip['ip2'];
            
           
			$status_gateway = $this->pingDomain($domainbase);
			if ($status_gateway != -1) {
				echo "<tr><td>http://$domainbase is ALIVE ($status_gateway ms)</td><tr>";
				$messages = "http://$domainbase is ALIVE ($status_gateway ms)<br>";
				$messagesTemp .= "http://$domainbase is ALIVE ($status_gateway ms)<br>";
				$gateway = 'Alive';
			}else {
				echo "<tr><td>http://$domainbase is DOWN</td><tr>";
				$messages = "http://$domainbase is DOWN ($status_gateway ms)<br>";
				$messagesTemp .= "http://$domainbase is DOWN ($status_gateway ms)<br>";
				$gateway ='Down';
				$name1 = "Gateway";
				echo 'mati';

				$status = $this->M_index->checkStatusAction($domainbase);
				if ($status == null) {
					$statusNow = 0;
					$stat = array(
									'creation_date' => 'now()',
									'ip' => $domainbase,
									'status' => 0,
								 );
					$this->M_index->setStatus($stat);

					$time = date('d-m-Y H:i:s');
					$st = "OPEN";

					$message ="<table>
								<tr>
								 	<th align='left'>STATUS</th>
									<th>:</th>
									<td>$st</td>
								</tr>
								<tr>
								 	<th align='left'>TIME</th>
									<th>:</th>
									<td>$time</td>
								</tr>
								<tr>
								 	<th align='left'>DOWN TIME</th>
									<th>:</th>
									<td>$statusNow Jam</td>
								</tr>
							</table>
							<table style='border-collapse: collapse; border:1px solid black;'>
								<tr style='border-collapse: collapse; border:1px solid black;'>
								 	<th style='border-collapse: collapse; border:1px solid black;'>IP Address</th>
								 	<th style='border-collapse: collapse; border:1px solid black;'>Name</th>
								 	<th style='border-collapse: collapse; border:1px solid black;'>Ping Result</th>
								</tr>
								<tr style='border-collapse: collapse; border:1px solid black;'>
								 	<td style='border-collapse: collapse; border:1px solid black;'>$domainbase</td>
								 	<td style='border-collapse: collapse; border:1px solid black;'>$name1</td>
								 	<td style='border-collapse: collapse; border:1px solid black;'>$gateway</td>
								</tr>
							</table>";
				}else {
					if ($status[0]['action'] == null) {
						$sts = $status[0]['status'];
						$statusNow = 0;
						$statusNows = $sts + 1;
						$downtime = $statusNows * 15 / 60;
						$stat = array(
										'creation_date' => 'now()',
										'ip' => $domainbase,
										'status' => $statusNows,
								);
						$this->M_index->setStatus($stat);

						$time = date('d-m-Y H:i:s');
						$st = "OPEN";
						$message ="<table>
									<tr>
										<th align='left'>STATUS</th>
										<th>:</th>
										<td>$st</td>
									</tr>
									<tr>
										<th align='left'>TIME</th>
										<th>:</th>
										<td>$time</td>
									</tr>
									<tr>
										<th align='left'>DOWN TIME</th>
										<th>:</th>
										<td>$downtime Jam</td>
									</tr>
								</table>
								<table style='border-collapse: collapse; border:1px solid black;'>
									<tr style='border-collapse: collapse; border:1px solid black;'>
										<th style='border-collapse: collapse; border:1px solid black;'>IP Address</th>
										<th style='border-collapse: collapse; border:1px solid black;'>Name</th>
										<th style='border-collapse: collapse; border:1px solid black;'>Ping Result</th>
									</tr>
									<tr style='border-collapse: collapse; border:1px solid black;'>
										<td style='border-collapse: collapse; border:1px solid black;'>$domainbase</td>
										<td style='border-collapse: collapse; border:1px solid black;'>$name1</td>
										<td style='border-collapse: collapse; border:1px solid black;'>$gateway</td>
									</tr>
								</table>";
					}else {
						$action = $status[0]['action'];
						$actBy = $status[0]['action_by'];
						$noticket = $status[0]['no_ticket'];
						$sts = $status[0]['status'];
						$statusNow = $sts +1;
						$downtime = $statusNow * 15 / 60;

						$getNamaCreator = $this->M_index->getNamaCreator($actBy);
						$creator = RTRIM($getNamaCreator[0]['employee_name']);
						
							$stat = array(
								'creation_date' => 'now()',
								'ip' => $domainbase,
								'action' => $action,
								'action_by' => $actBy,
								'no_ticket' => $noticket,
								'status' => $statusNow,
							);
						$this->M_index->setStatus($stat);

						$time = date('d-m-Y H:i:s');
						$st = "WIP";
						$message ="<table>
								 <tr>
								 	<th align='left'>STATUS</th>
									<th>:</th>
									<td>$st</td>
								 </tr>
								 <tr>
								 	<th align='left'>TIME</th>
									<th>:</th>
									<td>$time</td>
								 </tr>
								 <tr>
								 	<th align='left'>NO TICKET</th>
									<th>:</th>
									<td>$noticket</td>
								 </tr>
								 <tr>
								 	<th align='left'>ACTION</th>
									<th>:</th>
									<td>$action</td>
								 </tr>
								 <tr>
								 	<th align='left'>ACTION BY</th>
									<th>:</th>
									<td>$actBy - $creator</td>
								 </tr>
								 <tr>
								 	<th align='left'>DOWN TIME</th>
									<th>:</th>
									<td>$downtime Jam</td>
								 </tr>
								</table>
								<table>
								<table style='border-collapse: collapse; border:1px solid black;'>
									<tr style='border-collapse: collapse; border:1px solid black;'>
										<th style='border-collapse: collapse; border:1px solid black;'>IP Address</th>
										<th style='border-collapse: collapse; border:1px solid black;'>Name</th>
										<th style='border-collapse: collapse; border:1px solid black;'>Ping Result</th>
									</tr>
									<tr style='border-collapse: collapse; border:1px solid black;'>
										<td style='border-collapse: collapse; border:1px solid black;'>$domainbase</td>
										<td style='border-collapse: collapse; border:1px solid black;'>$name1</td>
										<td style='border-collapse: collapse; border:1px solid black;'>$gateway</td>
									</tr>
								</table>";
					}
				}
				$subject = "($st) ".$ip['name']." is Down";

				if ($statusNow%48 == 0) {
					$emailUser = array("quick.tractor@gmail.com", "it.sec1@quick.co.id", "it1.quick@gmail.com", "nugroho.mail1@gmail.com", "ict.hardware.khs@gmail.com", "it.asst.u1@quick.co.id", "khoerulamri.id@gmail.com");
					$emailUserInternal = array("johannes_andri@quick.com","yohanes_budi@quick.com","rheza_egha@quick.com","amelia_ayu@quick.com","khoerul_amri@quick.com","nugroho@quick.com");
				}else {
					$emailUser = array("quick.tractor@gmail.com", "ict.hardware.khs@gmail.com");
					$emailUserInternal = array("yohanes_budi@quick.com","rheza_egha@quick.com","amelia_ayu@quick.com");
				}
				
				

                $this->EmailAlert($subject, $message, $emailUser);
                $this->EmailAlertInternal($subject, $message, $emailUserInternal);
                
			}
			
		
				

			// }
            
		}
// 			$emailTemp = array("nugroho@quick.com","bondan_surya_n@quick.com");
			
// 			 $this->EmailAlertInternal('trial', $messagesTemp, $emailTemp);

	}

	public function checkSide()
	{
		$ipName = array(
			array(
				'name' => 'IconPlus PUSAT-BANJARMASIN',
				'ip' => '172.16.100.93',
			),
			array(
				'name' => 'IconPlus PUSAT-JAKARTA',
				'ip' => '172.16.100.25',
			),
			array(
				'name' => 'IconPlus PUSAT-LAMPUNG',
				'ip' => '172.16.100.13',
			),
			array(
				'name' => 'IconPlus PUSAT-LANGKAPURA',
				'ip' => '172.16.100.61',
			),
			array(
				'name' => 'IconPlus PUSAT-MAKASSAR',
				'ip' => '172.16.100.29',
			),
			array(
				'name' => 'IconPlus PUSAT-MEDAN',
				'ip' => '172.16.100.17',
			),
			array(
				'name' => 'IconPlus PUSAT-MLATI',
				'ip' => '172.16.100.21',
			),
			array(
				'name' => 'IconPlus PUSAT-PALU',
				'ip' => '172.16.100.101',
			),
			array(
				'name' => 'IconPlus PUSAT-PEKANBARU',
				'ip' => '172.16.100.89',
			),
			array(
				'name' => 'IconPlus PUSAT-PONTIANAK',
				'ip' => '172.16.100.49',
			),
			array(
				'name' => 'IconPlus PUSAT-SURABAYA',
				'ip' => '172.16.100.9',
			),
			array(
				'name' => 'IconPlus PUSAT-TUKSONO',
				'ip' => '172.16.100.5',
			),
			array(
				'name' => 'LDP PUSAT-TUKSONO',
				'ip' => '172.18.22.1',
			)
		);

		foreach ($ipName as $key => $ip) {
			$domainbase = $ip['ip'];

			$status = $this->pingDomainSide($domainbase);
	
			if ($status != -1) {
	
				echo "<tr><td>http://$domainbase is ALIVE ($status ms)</td><tr>";
				$messages = "http://$domainbase is ALIVE ($status ms)";
			}else {
	
				echo "<tr><td>http://$domainbase is DOWN</td><tr>";
				$messages = "http://$domainbase is DOWN ($status ms)";

				$status = $this->M_index->checkStatusAction($domainbase);

				if ($status == null) {
					$statusNow = 0;
					$time = date('d-m-Y H:i:s');
					$st = "OPEN";

					$message ="<table>
								<tr>
									<th align='left'>IP</th>
									<th>:</th>
									<td>$domainbase</td>
								</tr>
								<tr>
								 	<th align='left'>STATUS</th>
									<th>:</th>
									<td>$st</td>
								</tr>
								<tr>
								 	<th align='left'>TIME</th>
									<th>:</th>
									<td>$time</td>
								</tr>
								<tr>
								 	<th align='left'>DOWN TIME</th>
									<th>:</th>
									<td>$statusNow Jam</td>
								</tr>
							</table>";
				}else {
					if ($status[0]['action'] == null) {
						$sts = $status[0]['status'];
						$statusNow = 0;
						$statusNows = $sts + 1;
						$downtime = $statusNows * 15 / 60;

						$time = date('d-m-Y H:i:s');
						$st = "OPEN";
						$message ="<table>
								<tr>
									<th align='left'>IP</th>
									<th>:</th>
									<td>$domainbase</td>
								</tr>
								 <tr>
								 	<th align='left'>STATUS</th>
									<th>:</th>
									<td>$st</td>
								 </tr>
								 <tr>
								 	<th align='left'>TIME</th>
									<th>:</th>
									<td>$time</td>
								 </tr>
								 <tr>
								 	<th align='left'>DOWN TIME</th>
									<th>:</th>
									<td>$downtime Jam</td>
								 </tr>
								</table>";
					}else {
						$action = $status[0]['action'];
						$actBy = $status[0]['action_by'];
						$noticket = $status[0]['no_ticket'];
						$sts = $status[0]['status'];
						$statusNow = $sts +1;
						$downtime = $statusNow * 15 / 60;

						$getNamaCreator = $this->M_index->getNamaCreator($actBy);
						$creator = RTRIM($getNamaCreator[0]['employee_name']);
						
						$time = date('d-m-Y H:i:s');
						$st = "WIP";
						$message ="<table>
								<tr>
									<th align='left'>IP</th>
									<th>:</th>
									<td>$domainbase</td>
								</tr>
								 <tr>
								 	<th align='left'>STATUS</th>
									<th>:</th>
									<td>$st</td>
								 </tr>
								 <tr>
								 	<th align='left'>TIME</th>
									<th>:</th>
									<td>$time</td>
								 </tr>
								 <tr>
								 	<th align='left'>NO TICKET</th>
									<th>:</th>
									<td>$noticket</td>
								 </tr>
								 <tr>
								 	<th align='left'>ACTION</th>
									<th>:</th>
									<td>$action</td>
								 </tr>
								 <tr>
								 	<th align='left'>ACTION BY</th>
									<th>:</th>
									<td>$actBy - $creator</td>
								 </tr>
								 <tr>
								 	<th align='left'>DOWN TIME</th>
									<th>:</th>
									<td>$downtime Jam</td>
								 </tr>
								</table>";
					}
				}
				$subject = "ver.Lama($st) ".$ip['name']." is Down";

				$emailUser = array("nugroho.mail1@gmail.com",);
				$emailUserInternal = array("nugroho@quick.com",);

				$this->EmailAlert($subject, $message, $emailUser);
                $this->EmailAlertInternal($subject, $message, $emailUserInternal);
			}
		}
	}

	public function pingDomain($domain)
	{
		$check =  exec('ping -c 3 -w 3 '.$domain);
		if ($check) {
			$status = 0;
		}else {
			$status = -1;
		}
		return $status;
	}

	public function pingDomainSide($domain)
	{
		$starttime = microtime(true);
		$file      = fsockopen ($domain, 53, $errno, $errstr, 10);
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

	public function EmailAlert($subject , $body, $akun)
	{
		//email
        
        // $akun = array("quick.tractor@gmail.com", "it.sec1@quick.co.id", "it1.quick@gmail.com", "nugroho.mail1@gmail.com", "ict.hardware.khs@gmail.com", "it.asst.u1@quick.co.id", "khoerulamri.id@gmail.com");
        
        // $akun = array("suryabondan@gmail.com");
        
		//send Email

		$this->load->library('PHPMailerAutoload');
		$mail = new PHPMailer();
        $mail->SMTPDebug = 0;
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
        $mail->setFrom('quick.tractor@gmail.com', 'ERP Ping-Checker');
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
	
	public function EmailAlertInternal($subject , $body, $akun)
	{
		// $akun = array("johannes_andri@quick.com","yohanes_budi@quick.com","rheza_egha@quick.com","amelia_ayu@quick.com","khoerul_amri@quick.com","nugroho@quick.com");
		
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
				'allow_self_signed' => true)
				);
        $mail->Username = 'no-reply';
        $mail->Password = '123456';
        $mail->WordWrap = 50;
		
        // set email content
        $mail->setFrom('no-reply@quick.com', 'ERP Ping-Checker');
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
