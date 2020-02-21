<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {

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
    
    public function Penanganan()
    {
        $this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Input Penanganan';

		$user = $this->session->user;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['ip'] = $this->M_index->getDataIPDown();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PingChecker/V_Penanganan',$data);
		$this->load->view('V_Footer',$data);
    }

    public function saveData()
    {
		$ip = $this->input->post('slcIPIPM');
		$ipName = $this->input->post('ipNameIPM');
        $action = $this->input->post('actionIPM');
        $ticket = $this->input->post('ticketIPM');
        $noind = $this->session->user;
        
        if($ip == '172.16.100.93') {
            $link = 'IconPlus PUSAT-BANJARMASIN';
        }else if($ip == '172.16.100.25') {
            $link = 'IconPlus PUSAT-JAKARTA';
        }else if($ip == '172.16.100.13') {
            $link = 'IconPlus PUSAT-LAMPUNG';
        }else if($ip == '172.16.100.61') {
            $link = 'IconPlus PUSAT-LANGKAPURA';
        }else if($ip == '172.16.100.29') {
            $link = 'IconPlus PUSAT-MAKASSAR';
        }else if($ip == '172.16.100.17') {
            $link = 'IconPlus PUSAT-MEDAN';
        }else if($ip == '172.16.100.21') {
            $link = 'IconPlus PUSAT-MLATI';
        }else if($ip == '172.16.100.101') {
            $link = 'IconPlus PUSAT-PALU';
        }else if($ip == '172.16.100.89') {
            $link = 'IconPlus PUSAT-PEKANBARU';
        }else if($ip == '172.16.100.49') {
            $link = 'IconPlus PUSAT-PONTIANAK';
        }else if($ip == '172.16.100.9') {
            $link = 'IconPlus PUSAT-SURABAYA';
        }else if($ip == '172.16.100.5') {
            $link = 'IconPlus PUSAT-TUKSONO';
        }else if($ip == '172.18.22.1') {
            $link = 'LDP PUSAT-TUKSONO';
		}
		
		$status = $this->M_index->checkStatusAction($ip);
		$sts = $status[0]['status'];
		$statusNow = $sts * 15 / 60;

        $data = array(
                        'creation_date' => 'now()',
                        'ip' => $ip,
                        'action' => $action,
                        'no_ticket' => $ticket,
						'action_by' => $noind,
						'status' => $sts,
                     );
        
		$this->M_index->setStatus($data);
		
		$getNamaCreator = $this->M_index->getNamaCreator($noind);
		$creator = RTRIM($getNamaCreator[0]['employee_name']);
		
		$messages = "http://$ip is DOWN (-1 ms)";
		$time = date('d-m-Y H:i:s');
		$st = "WIP";
		$message ="<table>
		                <tr>
							<th align='left'>IP</th>
							<th>:</th>
							<td>$ip</td>
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
							<td>$ticket</td>
						</tr>
						<tr>
							<th align='left'>ACTION</th>
							<th>:</th>
							<td>$action</td>
						</tr>
						<tr>
							<th align='left'>ACTION BY</th>
							<th>:</th>
							<td>$noind - $creator</td>
						</tr>
						<tr>
							<th align='left'>DOWN TIME</th>
							<th>:</th>
							<td>$statusNow Jam</td>
						</tr>
					</table>";
		
		$subject = "($st) ".$link." is Down";

		$this->EmailAlert($subject, $message);
		$this->EmailAlertInternal($subject, $message);

		redirect('PingChecker/Monitoring/Penanganan', 'refresh');

	}
	
	public function EmailAlert($subject , $body)
	{
		//email
        
        $akun = array("quick.tractor@gmail.com", "it.sec1@quick.co.id", "it1.quick@gmail.com", "nugroho.mail1@gmail.com", "ict.hardware.khs@gmail.com", "it.asst.u1@quick.co.id", "khoerulamri.id@gmail.com");
        
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
	
	public function EmailAlertInternal($subject , $body)
	{
		$akun = array("johannes_andri@quick.com","yohanes_budi@quick.com","rheza_egha@quick.com","amelia_ayu@quick.com","khoerul_amri@quick.com","nugroho@quick.com");
		
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

	public function update()
	{
		$this->load->view('PingChecker/V_updateData');
	}

	public function UpdateData()
	{
		$id = $this->input->post('idIPM');
		$status = $this->input->post('statusIPM');

		$up = array(
					'status' => $status, );

		$this->M_index->UpdateData($id,$up);
		redirect('PingChecker/Monitoring/update', 'refresh');
	}
} ?>