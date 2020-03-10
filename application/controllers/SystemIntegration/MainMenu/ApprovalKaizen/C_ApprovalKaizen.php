<?php defined('BASEPATH')OR die('No direct script access allowed');
ini_set('memory_limit', '1024M');
set_time_limit(0);
class C_ApprovalKaizen extends CI_Controller {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SystemIntegration/M_submit');
		$this->load->model('SystemIntegration/M_log');
		$this->load->model('SystemIntegration/M_approvalkaizen');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession() {
		if (!$this->session->is_logged) {
			redirect();
		}
	}

	public function index() {
		$this->checkSession();
		$user_id = $this->session->userid;
		$employee_code = $this->session->user;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['kaizen'] = $this->M_approvalkaizen->getMyApproval($employee_code, FALSE);
		$data['kaizen_unchecked'] = $this->M_approvalkaizen->getMyApproval($employee_code, 2);
		$data['kaizen_approved'] = $this->M_approvalkaizen->getMyApproval($employee_code, 3);
		$data['kaizen_revised'] = $this->M_approvalkaizen->getMyApproval($employee_code, 4);
		$data['kaizen_rejected'] = $this->M_approvalkaizen->getMyApproval($employee_code, 5);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/ApprovalKaizen/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function view($id) {
		$this->checkSession();
		$user_id = $this->session->userid;
		$employee_code = $this->session->user;
		$data['Menu'] = 'View Kaizen';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['user'] = $this->session->userdata('logged_in');
		$data['kaizen'] = $this->M_submit->getKaizen($id, FALSE);
		$data['thread'] = $this->M_log->ShowLog($id);
		$atasan1 = $this->M_submit->getAtasan($employee_code, 2);
		$atasan2 = $this->M_submit->getAtasan($employee_code, 2);
		$data['option_atasan'] = $this->M_submit->getAtasan($employee_code, 3);
		// print_r($data['option_atasan']);exit();
		$data['option_atasan2'] = $this->M_submit->getAtasan($employee_code, 4);
		$data['kaizen'][0]['employee_code'] = '';
		if($data['kaizen'][0]['komponen']) {
			$arrayKomponen = explode(',', $data['kaizen'][0]['komponen']);
			foreach($arrayKomponen as $key => $value) {
				$dataItem = $this->M_submit->getMasterItem(FALSE,$value);
				$kodeItem = $dataItem[0]['SEGMENT1'];
				$namaItem = $dataItem[0]['ITEM_NAME'];
				$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
			}
			$data['kaizen'][0]['komponen'] = $komponen;
		}
		$data['levelku'] = '';
		$data['statusku'] = '';
		$reason_app = array();
		$reason_rev = array();
		$reason_rej = array();

		$getAllApprover = $this->M_approvalkaizen->getApprover($data['kaizen'][0]['kaizen_id'],FALSE);
		$a = 0;
		foreach ($getAllApprover as $key => $value) {
			$data['kaizen'][0]['status_app'][$value['level']]['level'] = $value['level'];
			$data['kaizen'][0]['status_app'][$value['level']]['staff'] = $value['employee_name'];
			$data['kaizen'][0]['status_app'][$value['level']]['staff_code'] = $value['employee_code'];
			$data['kaizen'][0]['status_app'][$value['level']]['reason'] = $value['reason'];
			if ($employee_code == $value['employee_code']) {
				$data['kaizen'][0]['employee_code'] = $value['employee_code'];
				$data['levelku'] = $value['level'];
				$data['statusku'] = $value['status'];

			}
			if($value['status'] == 4 ) {
				array_push($reason_rev, $value['reason']);
			} else if ($value['status'] == 5) {
				array_push($reason_rej, $value['reason']);
			} else if ($value['status'] == 3) {
				array_push($reason_app, $value['reason']);
			}
			$a++;
		}
		$data['kaizen'][0]['reason_app'] = implode(',', $reason_app);
		$data['kaizen'][0]['reason_rev'] = implode(',', $reason_rev);
		$data['kaizen'][0]['reason_rej'] = implode(',', $reason_rej);
		if ($data['kaizen'][0]['approval_realisasi'] == 1) {
			$getApprovalLvl = $this->M_approvalkaizen->getApprover($data['kaizen'][0]['kaizen_id'], 6);
			$data['kaizen'][0]['employee_code_realisasi'] = $getApprovalLvl[0]['employee_code'];
		}
		$data['section_user'] = $this->M_approvalkaizen->getSectAll($data['kaizen'][0]['noinduk']);
		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('SystemIntegration/MainMenu/Submit/V_ViewKaizen', $data);
		$this->load->view('V_Footer');
	}

	public function result($id) {
		//init data
		$kaizen_id = $id;
		$employee_code = $this->session->user;
		$status = $this->input->post('hdnStatus');
		$reason = $this->input->post('txtReason');
		$level = $this->input->post('levelApproval');
		$update = $this->M_approvalkaizen->updateStatusApprove($kaizen_id,$employee_code,$status,$reason,$level);
		$status_name = ($status == '3') ? 'Approved' : (($status == '4') ? 'Revision' : 'Rejected');
		$name_user = $this->session->employee;
		//log thread
		$getTemplateLog = $this->M_log->getTemplateLog(13);
		$title = $getTemplateLog[0]['title'];
		$body = $getTemplateLog[0]['body'];
		$detail = "(";
		$detail .=  sprintf($title, $status_name);
		$detail .= ") - ";
		$detail .= sprintf($body, $name_user, $status_name);
		if($reason) {
			$detail .= " dengan alasan : ".$reason;
		}
		//save log
		$datalog = array(
			'kaizen_id' => $kaizen_id,
			'status' => $status,
			'detail' => $detail,
			'waktu' => date('Y-m-d h:i:s'),
		);
		$this->M_log->save_log($datalog);
		//insert to t_log
		$aksi = 'GENERATOR KAIZEN ATASAN';
		$detail = 'UPDATE STATUS ID='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		//init approver
		$getApprover = $this->M_approvalkaizen->getApprover($kaizen_id,FALSE);
		$yangApprove = array();
		$yangRevisi = array();
		$yangReject = array();
		$yangBelum = array();
		foreach ($getApprover as $key => $value) {
			$allApp[] = $value['status'];
			if($value['status'] == 3 ) {
				array_push($yangApprove, $value['status']);
			} else if($value['status'] == 4) {
				array_push($yangRevisi, $value['status']);
			} else if($value['status'] == 5) {
				array_push($yangReject, $value['status']);
			} else {
				array_push($yangBelum, $value['status']);
			}
			$NoindApprover[$value['level']] = $value['approver'];
		}
		// set Approval to next level ,(From Approver 2 to level Department & Dirut)
		$needNextApproval = '0';
		$checkNextApprover = $this->input->post('checkNextApprover');
		if (isset($checkNextApprover)) {
			$needNextApproval = '1';
		}
		// need next approval
		if($needNextApproval == '0') {
			if($yangApprove && !$yangReject && !$yangRevisi && !$yangBelum) {
				$status_date =  date('Y-m-d h:i:s');
				$this->M_approvalkaizen->UpdateStatus($kaizen_id, 3, $status_date);
				//log thread
				$getTemplateLog = $this->M_log->getTemplateLog(3);
				$title = $getTemplateLog[0]['title'];
				$body = $getTemplateLog[0]['body'];
				$detail = "($title) - ";
				$detail .= $body;
				//save log
				$datalog = array(
					'kaizen_id' => $kaizen_id,
					'status' => 3,
					'detail' => $detail,
					'waktu' => date('Y-m-d h:i:s'),
				);
				$this->M_log->save_log($datalog);
			} else if ($yangRevisi && !$yangReject) {
				$status_date =  date('Y-m-d h:i:s');
				$this->M_approvalkaizen->UpdateStatus($kaizen_id, 4, $status_date);
			} else if ($yangReject) {
				$status_date =  date('Y-m-d h:i:s');
				$this->M_approvalkaizen->UpdateStatus($kaizen_id, 5, $status_date);
			}
		} else {
			$nextlevel = $this->input->post('levelnext');
			$approver = $this->input->post('slcApprover');
			$data = array(
				'approver' => $approver,
				'level' => $nextlevel,
				'kaizen_id' => $kaizen_id,
				'ready' => '1'
			);
			$checkExist = $this->M_submit->checkExist($data);
			if ($checkExist == 0) {
				$this->M_submit->SaveApprover($data);
			}
			$getname = $this->M_approvalkaizen->getName($approver);
			$name= $getname[0]['employee_name'];
			$this->section_user($approver,$kaizen_id);
			//log thread
			$username = $this->session->userdata('employee');
			$getTemplateLog = $this->M_log->getTemplateLog(12);
			$title = $getTemplateLog[0]['title'];
			$body = $getTemplateLog[0]['body'];
			$detail = "($title) - ";
			$detail .= sprintf($body, $name, $username);
			$datalog = array(
				'kaizen_id' => $kaizen_id,
				'status' => $status,
				'detail' => $detail,
				'waktu' => date('Y-m-d h:i:s'),
			);
			$this->M_log->save_log($datalog);
		}
		$status = trim($status);
		if($status) {
			if($level == 1 && (array_key_exists(2, $NoindApprover) === true)) {
				$updateReady = $this->M_approvalkaizen->updateReady(2, $kaizen_id, 1);
			} else if($level == 2 && (array_key_exists(3, $NoindApprover) === true)) {
				$updateReady = $this->M_approvalkaizen->updateReady(3, $kaizen_id, 1);
			} else if($level == 3 && (array_key_exists(4, $NoindApprover) === true)) {
				$updateReady = $this->M_approvalkaizen->updateReady(4, $kaizen_id, 1);
			}

			$this->EmailAlert($kaizen_id, $status);
			$this->sendPidgin($kaizen_id, $status);

			if ($status == '3') {
			$this->EmailAlertAproval($kaizen_id, $status);
			$this->sendPidginAprover($kaizen_id, $status);
			}
		}
		redirect(base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/index'));
	}

	public function resultRealisasi($id) {

		$kaizen_id = $id;
		$employee_code = $this->session->user;
		$reason = $this->input->post('txtReason');
		$level = 6;
		$status = 3;
		$update = $this->M_approvalkaizen->updateStatusApprove($kaizen_id,$employee_code,$status,$reason,$level);
		$status_date =  date('Y-m-d h:i:s');
		$this->M_approvalkaizen->UpdateStatus($kaizen_id, 7, $status_date);
		//log and mail
		$status_name = 'Approved';
		$name_user = $this->session->employee;
		//log thread
		$getTemplateLog = $this->M_log->getTemplateLog(7);
		$title = $getTemplateLog[0]['title'];
		$body = $getTemplateLog[0]['body'];
		$detail  = "(";
		$detail .=  sprintf($title, $status_name);
		$detail .= ") - ";
		$detail .= sprintf($body, $name_user, $status_name);
		if ($reason) {
			$detail .=" dengan alasan : ".$reason;
		}
		$datalog = array(
			'kaizen_id' => $kaizen_id,
			'status' => 7,
			'detail' => $detail,
			'waktu' => date('Y-m-d h:i:s'),
		);
		$this->M_log->save_log($datalog);
		//insert to t_log
		$aksi = 'GENERATOR KAIZEN ATASAN';
		$detail = 'UPDATE Result Realisasi kaizen_id='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$this->EmailBroadcastKaizen($kaizen_id);
		redirect(base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/index'));
	}

	private function EmailAlert($kaizen_id, $mailStatus) {
		//get Rincian Kaizen
		$getKaizen = $this->M_submit->getKaizen($kaizen_id, FALSE);
		if($getKaizen) {
			//get pencetus email
			$getEmail = $this->M_submit->getEmail($getKaizen[0]['noinduk']);
			$emailUser = $getEmail[0]['internal_mail'];
		}
		if($emailUser) {
			//get approver name
			$approverName = trim($this->M_submit->getEmployeeName($this->session->user));
			//get template
			$link = base_url("SystemIntegration/KaizenGenerator/View/$kaizen_id");
			switch($mailStatus) {
				case 3:
					$mailStatus = 5;
					break;
				case 4:
					$mailStatus = 9;
					break;
				case 5:
					$mailStatus = 7;
					break;
				default:
					$mailStatus = 7;
					break;
			}
			$getEmailTemplate = $this->M_submit->getEmailTemplate($mailStatus);
			$subject = $getEmailTemplate[0]['subject'];
			$body = sprintf($getEmailTemplate[0]['body'], trim($getKaizen[0]['pencetus']), trim($approverName), trim($getKaizen[0]['judul']), trim($link));
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
			//set email content
			$mail->setFrom('no-reply@quick.com', 'Email Sistem');
			$mail->addAddress($emailUser);
			$mail->Subject = $subject;
			$mail->msgHTML($body);
			// check error
			if (!$mail->send()) {
				echo "Mailer Error: ".$mail->ErrorInfo;
				exit();
			}
		}
	}

	private function EmailAlertAproval($kaizen_id, $mailStatus) {
		//get Rincian Aprover Kaizen
		$getApprover = $this->M_approvalkaizen->getApprover($kaizen_id,FALSE);
		if($getApprover) {
			//get aprover email
			$getEmail = $this->M_submit->getEmail($getApprover[1]['approver']);
			$emailUser = $getEmail[0]['internal_mail'];
		}
		if($emailUser) {
			//get approver name
			$getKaizen = $this->M_submit->getKaizen($kaizen_id, FALSE);
			$approverName = trim($this->M_submit->getEmployeeName($this->session->user));
			//get template
			$link = base_url("SystemIntegration/KaizenGenerator/View/$kaizen_id");
			switch($mailStatus) {
				case 3:
					$mailStatus = 1;
					break;
				case 4:
					$mailStatus = 9;
					break;
				case 5:
					$mailStatus = 7;
					break;
				default:
					$mailStatus = 7;
					break;
			}
			$getEmailTemplate = $this->M_submit->getEmailTemplate($mailStatus);
			$subject = $getEmailTemplate[0]['subject'];
			$body = sprintf($getEmailTemplate[0]['body'], trim($getKaizen[0]['pencetus']), trim($getKaizen[0]['judul']), trim($link));
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
			//set email content
			$mail->setFrom('no-reply@quick.com', 'Email Sistem');
			$mail->addAddress($emailUser);
			$mail->Subject = $subject;
			$mail->msgHTML($body);
			// check error
			if (!$mail->send()) {
				echo "Mailer Error: ".$mail->ErrorInfo;
				exit();
			}
		}
	}

	private function EmailBroadcastKaizen($kaizen_id) {
		//get Rincian Kaizen
		$getKaizen = $this->M_submit->getKaizen($kaizen_id, FALSE);
		if	($getKaizen) {
			//get kaizen approver
			$getApprover = $this->M_submit->getKaizenAprrover($kaizen_id, 3);
			$approver = '';
			for($i = 0; $i < sizeof($getApprover); $i++) {
				if($i < (sizeof($getApprover) - 1)) {
					$approver .= trim($this->M_submit->getEmployeeName($getApprover[$i]['approver'])) . ', ';
				} else {
					$approver .= trim($this->M_submit->getEmployeeName($getApprover[$i]['approver'])) . '.';
				}
			}//get template
			$getEmailTemplate = $this->M_submit->getEmailTemplate(11);
			$subject = $getEmailTemplate[0]['subject'];
			$body = sprintf(
				$getEmailTemplate[0]['body'],
				$getKaizen[0]['pencetus'],
				$getKaizen[0]['judul'],
				$getKaizen[0]['kondisi_awal'],
				$getKaizen[0]['usulan_kaizen'],
				$getKaizen[0]['pertimbangan'],
				$getKaizen[0]['kondisi_akhir'],
				$getKaizen[0]['standarisasi_kaizen'],
				$approver,
				$getKaizen[0]['pencetus']
			);
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

			//set email content
			$mail->setFrom('no-reply@quick.com', 'Email Sistem');
			$mail->addAddress('semua_ict@quick.com');
			$mail->Subject = $subject;
			$mail->msgHTML($body);

			if (!$mail->send()) {
				echo "Mailer Error: ".$mail->ErrorInfo;
				exit();
			}
		}
	}

	private function sendPidgin($kaizen_id, $mailStatus) {
		//get Rincian Kaizen
		$getKaizen = $this->M_submit->getKaizen($kaizen_id, FALSE);
		if($getKaizen) {
			//get pencetus email
			$getEmail = $this->M_submit->getEmail($getKaizen[0]['noinduk']);
		}
		if ($getEmail) {
			$this->load->library('Sendmessage');
			$userAccount = $getEmail[0]['pidgin_account'];

			//get approver name
			$approverName = trim($this->M_submit->getEmployeeName($this->session->user));

			//get template
			$link = base_url("SystemIntegration/KaizenGenerator/ApprovalKaizen/View/$kaizen_id");
			switch($mailStatus) {
				case 3:
					$mailStatus = 6;
					break;
				case 4:
					$mailStatus = 10;
					break;
				case 5:
					$mailStatus = 8;
					break;
				default:
					$mailStatus = 8;
					break;
			}
			$getEmailTemplate = $this->M_submit->getPidginTemplate($mailStatus);
			$subject = $getEmailTemplate[0]['subject'];
			$body = sprintf($getEmailTemplate[0]['body'], trim($getKaizen[0]['pencetus']), trim($approverName), trim($getKaizen[0]['judul']), trim($link));
			$body = str_replace('<br/>', "\n", $body);
			$pidgin = new Sendmessage;
			@($pidgin->send($userAccount," \n ".$subject." \n ".$body));
		}
	}

	private function sendPidginAprover($kaizen_id, $mailStatus) {
		// echo "a :".$kaizen_id."<br>b :".$mailStatus;
		//get Rincian Aprover Kaizen
		$getApprover = $this->M_approvalkaizen->getApprover($kaizen_id,FALSE);
		// print_r('<pre>'); print_r($getApprover); exit();
		if($getApprover) {
			//get aprover email
			$getEmail = $this->M_submit->getEmail($getApprover[1]['approver']);
			$emailUser = $getEmail[0]['internal_mail'];
		}
		if($emailUser) {
			$this->load->library('Sendmessage');
			$userAccount = $getEmail[0]['pidgin_account'];
			$getKaizen = $this->M_submit->getKaizen($kaizen_id, FALSE);

			//get approver name
			$approverName = trim($this->M_submit->getEmployeeName($this->session->user));

			//get template
			$link = base_url("SystemIntegration/KaizenGenerator/ApprovalKaizen/View/$kaizen_id");
			switch($mailStatus) {
				case 3:
					$mailStatus = 2;
					break;
				case 4:
					$mailStatus = 10;
					break;
				case 5:
					$mailStatus = 8;
					break;
				default:
					$mailStatus = 8;
					break;
			}
			$getEmailTemplate = $this->M_submit->getPidginTemplate($mailStatus);
			$subject = $getEmailTemplate[0]['subject'];
			$body = sprintf($getEmailTemplate[0]['body'], trim($getKaizen[0]['pencetus']), trim($getKaizen[0]['judul']), trim($link));
			$body = str_replace('<br/>', "\n", $body);
			// echo "<h1 style='color: red'>sampai sini</h1>".$userAccount."<h1 style='color: red'>awas</h1>".$subject."<h1 style='color: red'>awas</h1>".$body;exit();

			$pidgin = new Sendmessage;
			@($pidgin->send($userAccount," \n ".$subject." \n ".$body));
		}
	}

	public function upload() {
	   $config = array('upload_path' => './assets/upload_kaizen/',
	                'upload_url' => base_url()  . './assets/upload_kaizen/',
	                'allowed_types' => 'jpg|gif|png',
	                'overwrite' => false,
	    );
	    $this->load->library('upload', $config);
	    if ($this->upload->do_upload('file')) {
	        $data = $this->upload->data();
	        $array = array(
	            'filelink' => $config['upload_url'] . $data['file_name']
	        );
	        echo stripslashes(json_encode($array));
	    } else {
	        echo json_encode(array('error' => $this->upload->display_errors('', '')));
	    }
	}
}
