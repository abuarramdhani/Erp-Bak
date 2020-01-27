<?php defined('BASEPATH')OR die('No direct script access allowed');

class C_MyKaizen extends CI_Controller {

	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		// load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SystemIntegration/M_submit');
		$this->load->model('SystemIntegration/M_mykaizen');
		// $this->load->model('SystemIntegration/M_mykaizen','Mine');
		$this->load->model('SystemIntegration/M_log');

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
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['kaizen'] = $this->M_mykaizen->getMyKaizen($user_id, FALSE, FALSE);
		$data['kaizen_unchecked'] = $this->M_mykaizen->getMyKaizen($user_id, FALSE, 2);
		$data['kaizen_approved_ide'] = $this->M_mykaizen->getMyKaizen($user_id, FALSE, 3);
		$data['kaizen_approved'] = $this->M_mykaizen->getMyKaizen($user_id, FALSE, 9);
		$data['kaizen_revised'] = $this->M_mykaizen->getMyKaizen($user_id, FALSE, 4);
		$data['kaizen_rejected'] = $this->M_mykaizen->getMyKaizen($user_id, FALSE, 5);

		//all
		$i = 0;
		foreach ($data['kaizen'] as $key => $value) {
			$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			$a = 0; foreach ($getAllApprover as $key => $value) {
				if ($value['level'] != 6):
				$data['kaizen'][$i]['status_app'][$a]['level']=$value['level'];
				$data['kaizen'][$i]['status_app'][$a]['status']=$value['status'];
				$data['kaizen'][$i]['status_app'][$a]['staff']=$value['employee_name'];
				$data['kaizen'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
				$data['kaizen'][$i]['status_app'][$a]['reason']=$value['reason'];
				endif;
				$a++;
			}
			$i++;
		}
		// unchecked
		$i = 0;
		foreach ($data['kaizen_unchecked'] as $key => $value) {
			$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			$a = 0; foreach ($getAllApprover as $key => $value) {
				if ($value['level'] != 6):
				$data['kaizen_unchecked'][$i]['status_app'][$a]['level']=$value['level'];
				$data['kaizen_unchecked'][$i]['status_app'][$a]['status']=$value['status'];
				$data['kaizen_unchecked'][$i]['status_app'][$a]['staff']=$value['employee_name'];
				$data['kaizen_unchecked'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
				$data['kaizen_unchecked'][$i]['status_app'][$a]['reason']=$value['reason'];
				endif;
				$a++;
			}
			$i++;
		}

		//approved_ide
		$i = 0;
		foreach ($data['kaizen_approved_ide'] as $key => $value) {
			$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			$a = 0; foreach ($getAllApprover as $key => $value) {
				if ($value['level'] != 6):
				$data['kaizen_approved_ide'][$i]['status_app'][$a]['level']=$value['level'];
				$data['kaizen_approved_ide'][$i]['status_app'][$a]['status']=$value['status'];
				$data['kaizen_approved_ide'][$i]['status_app'][$a]['staff']=$value['employee_name'];
				$data['kaizen_approved_ide'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
				$data['kaizen_approved_ide'][$i]['status_app'][$a]['reason']=$value['reason'];
				endif;
				$a++;
			}
			$i++;
		}
		//approved
		$i = 0;
		foreach ($data['kaizen_approved'] as $key => $value) {
			$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			$a = 0; foreach ($getAllApprover as $key => $value) {
				if ($value['level'] != 6):
				$data['kaizen_approved'][$i]['status_app'][$a]['level']=$value['level'];
				$data['kaizen_approved'][$i]['status_app'][$a]['status']=$value['status'];
				$data['kaizen_approved'][$i]['status_app'][$a]['staff']=$value['employee_name'];
				$data['kaizen_approved'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
				$data['kaizen_approved'][$i]['status_app'][$a]['reason']=$value['reason'];
				endif;
				$a++;
			}
			$i++;
		}

		//revised
		$i = 0;
		foreach ($data['kaizen_revised'] as $key => $value) {
			$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			$a = 0; foreach ($getAllApprover as $key => $value) {
				if ($value['level'] != 6):
				$data['kaizen_revised'][$i]['status_app'][$a]['level']=$value['level'];
				$data['kaizen_revised'][$i]['status_app'][$a]['status']=$value['status'];
				$data['kaizen_revised'][$i]['status_app'][$a]['staff']=$value['employee_name'];
				$data['kaizen_revised'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
				$data['kaizen_revised'][$i]['status_app'][$a]['reason']=$value['reason'];
				endif;
				$a++;
			}
			$i++;
		}

		//rejected
		$i = 0;
		foreach ($data['kaizen_rejected'] as $key => $value) {
			$getAllApprover = $this->M_mykaizen->getApprover($value['kaizen_id'],FALSE);
			$a = 0; foreach ($getAllApprover as $key => $value) {
				if ($value['level'] != 6):
				$data['kaizen_rejected'][$i]['status_app'][$a]['level']=$value['level'];
				$data['kaizen_rejected'][$i]['status_app'][$a]['status']=$value['status'];
				$data['kaizen_rejected'][$i]['status_app'][$a]['staff']=$value['employee_name'];
				$data['kaizen_rejected'][$i]['status_app'][$a]['staff_code']=$value['employee_code'];
				$data['kaizen_rejected'][$i]['status_app'][$a]['reason']=$value['reason'];
				endif;
				$a++;
			}
			$i++;
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemIntegration/MainMenu/MyKaizen/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SaveApprover() {
		$kaizen_id = $this->input->post('kaizen_id');
		$level1 = $this->input->post('SlcAtasanLangsung');
		$level2 = $this->input->post('SlcAtasanAtasanLangsung');
		$level3 = $this->input->post('SlcAtasanDepartment');
		$approval_level = $this->input->post('approval_level');
		$typeApproval = $this->input->post('typeApp');
		$approverPertama = "";
		//insert to t_log
			$aksi = 'KAIZEN GENERATOR';
			$detail = 'Save Kaizen id='.$kaizen_id;
			$this->log_activity->activity_log($aksi, $detail);
		//
		if ($typeApproval == 1) {
			foreach ($approval_level as $key => $value) {
				$approvernya = ($value == '1') ? $level1 : $level2;
				$data = array(
							'approver' => $approvernya,
							'level' => $value,
							'kaizen_id' => $kaizen_id
						);
				$checkExist = $this->M_submit->checkExist($data);
				if ($checkExist == 0) {
					$this->M_submit->SaveApprover($data);
				}
				$jml_app = count($approval_level);
				if (($jml_app == 1) || ($jml_app == 2 && $value == 1)) {
					$this->EmailAlert($approvernya,$kaizen_id);
					$this->sendPidgin($approvernya,$kaizen_id);
					$this->M_mykaizen->updateReady($value, $kaizen_id, 1);
					$approverPertama = $value;
				}
				$approverExist[] = $approvernya;
			}
			if(!$level1 && !$level2 && !$level3) {
				$this->M_submit->DeleteApprover($kaizen_id);
			} else {
				$status_date =  date('Y-m-d h:i:s');
				$this->M_submit->UpdateStatus($kaizen_id, 2 ,$status_date);
				//log
				foreach ($approverExist as $key => $value) {
					$getname = $this->M_mykaizen->getName($value);
					$name[] = $getname[0]['employee_name'];
				}
				$ApproverName = implode(' , ', $name);

				//log thread
				$getTemplateLog = $this->M_log->getTemplateLog(2);
				$title = $getTemplateLog[0]['title'];
				$body = $getTemplateLog[0]['body'];
				$detail =  "($title) - ";
				$detail .= sprintf($body, $ApproverName);
				$datalog =array(
					'kaizen_id' => $kaizen_id,
					'status' => 2,
					'detail' => $detail,
					'waktu' => date('Y-m-d h:i:s'),
				);
				$this->M_log->save_log($datalog);
			}
			if($approverExist) {
				$approverId = implode("','", $approverExist);
				$this->M_submit->DeleteApproverByApprover($kaizen_id,$approverId);
				$this->M_submit->ResetApprover($kaizen_id,$approverId,$approverPertama);
			}
		} else if($typeApproval == 2){
			$data = array(
						'approver' => $level1,
						'level' => 6,
						'kaizen_id' => $kaizen_id
					);
			$checkExist = $this->M_submit->checkExist($data);
			if ($checkExist == 0) {
				$this->M_submit->SaveApprover($data);
			}
			$this->EmailAlert($level1,$kaizen_id);
			$this->sendPidgin($level1,$kaizen_id);
			$updateReady = $this->M_mykaizen->updateReady(6, $kaizen_id, 1);
			$data2 = array('approval_realisasi' => '1');
			$this->M_submit->saveUpdate($kaizen_id,$data2);

			//log
			$getname = $this->M_mykaizen->getName($level1);
			$name = $getname[0]['employee_name'];

			//log thread
			$getTemplateLog = $this->M_log->getTemplateLog(16);
			$title = $getTemplateLog[0]['title'];
			$body = $getTemplateLog[0]['body'];
			$detail =  "($title) - ";
			$detail .= sprintf($body, $name);

			$datalog = array(
					'kaizen_id' => $kaizen_id,
					'status' 	=> 6,
					'detail' 	=> $detail,
					'waktu' 	=> date('Y-m-d h:i:s'),
				);
			$this->M_log->save_log($datalog);
		}
		redirect(base_url('SystemIntegration/KaizenGenerator/MyKaizen/index'));
	}

	public function EmailAlert($user, $kaizen_id) {
		//email
		$getEmail = $this->M_submit->getEmail($user);
		$emailUser = $getEmail[0]['internal_mail'];
		if ($emailUser) {
			//get Rincian Kaizen
			$getKaizen = $this->M_submit->getKaizen($kaizen_id, FALSE);

			//get template
			$link = base_url("SystemIntegration/KaizenGenerator/View/$kaizen_id");
			$getEmailTemplate = $this->M_submit->getEmailTemplate(1);
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
					'allow_self_signed' => true)
				);
			$mail->Username = 'no-reply';
			$mail->Password = '123456';
			$mail->WordWrap = 50;

			// set email content
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

	private function sendPidgin($user, $kaizen_id) {
		$getEmail = $this->M_submit->getEmail($user);
		$userAccount = $getEmail[0]['pidgin_account'];
		if($userAccount) {
			$this->load->library('Sendmessage');

			//get Rincian Kaizen
			$getKaizen = $this->M_submit->getKaizen($kaizen_id,FALSE);

			//get template
			$link = base_url("SystemIntegration/KaizenGenerator/ApprovalKaizen/View/$kaizen_id");
			$getEmailTemplate = $this->M_submit->getPidginTemplate(2);
			$subject = $getEmailTemplate[0]['subject'];
			$body = sprintf($getEmailTemplate[0]['body'], trim($getKaizen[0]['pencetus']), trim($getKaizen[0]['judul']), trim($link));
			$body = str_replace('<br/>', "\n", $body);
			$pidgin = new Sendmessage;
			@($pidgin->send($userAccount," \n ".$subject." \n ".$body));
		}
	}

	public function report() {
		$user_id = $this->session->userid;
		$this->load->model('SystemIntegration/M_approvalkaizen');

		$kaizen_id = $this->input->post('id');
		$status_date =  date('Y-m-d h:i:s');
		$this->M_submit->UpdateStatus($kaizen_id, 9, $status_date);
		$detail = "(Kaizen Reported) - ";
		$detail .= "Kaizen ini telah dilaporkan dan siap dicetak";

		//nomor kaizen
		$getrequester_code = $this->M_approvalkaizen->getRequester($kaizen_id);
		$requester_code = $getrequester_code[0]['noinduk'];
		$getSection = $this->M_approvalkaizen->getSectCode($requester_code);
		$sectCode = $getSection[0]['code'];
		$tempNumb = 'KZ/'.$sectCode.'/'.date('m/Y');
	 	$getNumb = $this->M_approvalkaizen->getNumb($tempNumb);
	 	if ($getNumb) {
	 		$new = substr($getNumb[0]['no_kaizen'], 15);
	 		$newA = $new+1;
	 		$newB = str_pad($newA,3,'0', STR_PAD_LEFT);

	 		$newNumb = 'KZ/'.$sectCode.'/'.date('m/Y').'/'.$newB;
	 	}
		$data = array('no_kaizen' => $newNumb, );
		$this->M_submit->saveUpdate($kaizen_id,$data);

		$datalog =array(
				'kaizen_id' => $kaizen_id,
				'status' 	=> 9,
				'detail'	=> $detail,
				'waktu' 	=> date('Y-m-d h:i:s'),
			 );
		echo date('d M Y');
	}
}
