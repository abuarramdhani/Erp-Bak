<?php defined('BASEPATH')OR die('No direct script access allowed');
class C_ApprovalKaizen extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	          //load the login model
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

	public function checkSession()
		{
				if ($this->session->is_logged) {
				}else{
					redirect();
				}
		}

	public function index()
		{
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

		public function view($id)
		{
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
			// $atasan3 = $this->M_submit->getAtasan($employee_code, 3);
			$data['option_atasan'] = $this->M_submit->getAtasan($employee_code, 3);
			$data['option_atasan2'] = $this->M_submit->getAtasan($employee_code, 4);
			$data['kaizen'][0]['employee_code'] = '';

			if ($data['kaizen'][0]['komponen']) {
				$arrayKomponen = explode(',', $data['kaizen'][0]['komponen']);
				foreach ($arrayKomponen as $key => $value) {
					$dataItem = $this->M_submit->getMasterItem(FALSE,$value);
					$kodeItem = $dataItem[0]['SEGMENT1'];
					$namaItem = $dataItem[0]['ITEM_NAME'];
					$komponen[] = $aa = array('id' => $value, 'code' => $kodeItem, 'name' => $namaItem);
				}

				$data['kaizen'][0]['komponen'] = $komponen;
			}

			$reason_app = array();
			$reason_rev = array();
			$reason_rej = array();

			$getAllApprover = $this->M_approvalkaizen->getApprover($data['kaizen'][0]['kaizen_id'],FALSE);
			$jmlMaxApp =  count($getAllApprover);
			$data['levelku'] = '';
			$data['statusku'] = '';

			$a = 0; for ($i=1; $i <= $jmlMaxApp; $i++) { 
				$getApprovalLvl = $this->M_approvalkaizen->getApprover($data['kaizen'][0]['kaizen_id'], $i);
				$data['kaizen'][0]['status_app'][$a]['level'.$i] = $getApprovalLvl ? $getApprovalLvl[0]['level'] : 0;
				$data['kaizen'][0]['status_app'][$a]['staff'.$i] = $getApprovalLvl ? $getApprovalLvl[0]['employee_name'] : '';
				$data['kaizen'][0]['status_app'][$a]['staff_code'.$i] = $getApprovalLvl ? $getApprovalLvl[0]['employee_code'] :'' ;
				$data['kaizen'][0]['status_app'][$a]['reason'.$i] = $getApprovalLvl ? $getApprovalLvl[0]['reason'] :'';
					if (($getApprovalLvl) && ($employee_code == $getApprovalLvl[0]['employee_code'])) {
						$data['levelku'] = $getApprovalLvl[0]['level'];
						$data['statusku'] = $getApprovalLvl[0]['status'];
					}

					if ($getApprovalLvl) {
						if ($getApprovalLvl[0]['employee_code'] == $employee_code ) {
							$data['kaizen'][0]['employee_code'] = $getApprovalLvl[0]['employee_code'];
							if ($getApprovalLvl[0]['status'] == 4 ) {
								array_push($reason_rev, $data['kaizen'][0]['status_app'][$a]['reason'.$i]);
							}elseif ($data['kaizen'][0]['status'] == 5) {
								array_push($reason_rej, $data['kaizen'][0]['status_app'][$a]['reason'.$i]);
							}elseif ($data['kaizen'][0]['status'] == 3) {
								array_push($reason_app, $data['kaizen'][0]['status_app'][$a]['reason'.$i]);
							}
						}
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
			// echo "<pre>";
			// print_r($data);
			// exit();
			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('SystemIntegration/MainMenu/Submit/V_ViewKaizen', $data);
			$this->load->view('V_Footer');
		}

		public function result($id){
			$kaizen_id = $id;
			$employee_code = $this->session->user;
			$status = $this->input->post('hdnStatus');
			$reason = $this->input->post('txtReason');
			$level = $this->input->post('levelApproval');
			$update = $this->M_approvalkaizen->updateStatusApprove($kaizen_id,$employee_code,$status,$reason,$level);
			// $level = $update[0]['level'];
			$getApprover = $this->M_approvalkaizen->getApprover($kaizen_id,FALSE);
			$yangApprove = array();
			$yangRevisi = array();
			$yangReject = array();
			$yangBelum = array();
			foreach ($getApprover as $key => $value) {
				$allApp[] = $value['status'];
				if($value['status'] == 3 ){
					array_push($yangApprove, $value['status']);
				}elseif ($value['status'] == 4) {
					array_push($yangRevisi, $value['status']);
		 		}elseif ($value['status'] == 5) {
					array_push($yangReject, $value['status']);
				}else{
					array_push($yangBelum, $value['status']);
				}	

				$NoindApprover[$value['level']] = $value['approver'];			
			}

			$needNextApproval = 0; // set Approval to next level ,(From Approver 2 to level Department & Dirut)
			$yesIneedit = $this->input->post('checkNextApprover');
			if (isset($yesIneedit)) {
				$needNextApproval = 1;
			}			

			if ($needNextApproval == 0) {
			if ($yangApprove && !$yangReject && !$yangRevisi && !$yangBelum) {
				$status_date =  date('Y-m-d h:i:s', strtotime('+5 hours'));
				$this->M_approvalkaizen->UpdateStatus($kaizen_id, 3, $status_date);
				//nomor kaizen
				$getrequester_code = $this->M_approvalkaizen->getRequester($kaizen_id);
				$requester_code = $getrequester_code[0]['noinduk'];
				$getSection = $this->M_approvalkaizen->getSectCode($requester_code);
				$sectCode = $getSection[0]['code'];
				$tempNumb = 'KZ/'.$sectCode.'/'.date('m/Y');
			 	$getNumb = $this->M_approvalkaizen->getNumb($tempNumb);
			 	if ($getNumb) {
			 		$new = substr($getNumb[0]['no_kaizen'], 15);
			 		$newA =  $new+1;
			 		$newB = str_pad($newA,3,'0', STR_PAD_LEFT);

			 		$newNumb = 'KZ/'.$sectCode.'/'.date('m/Y').'/'.$newB;
			 	}
				$data = array('no_kaizen' => $newNumb, );
				//$this->M_submit->saveUpdate($kaizen_id,$data);
				$detail = "(Approval Complete) - ";
				$detail .= "Ide Kaizen ini sudah selesai proses Approval, segera laksanakan kaizen";

				$datalog =array(
					'kaizen_id' => $kaizen_id,
					'status' => 3,
					'detail' => $detail,
					'waktu' => date('Y-m-d h:i:s', strtotime('+5 hours')),
					 );
				$this->M_log->save_log($datalog);
				}elseif($yangRevisi && !$yangReject) {
					$status_date =  date('Y-m-d h:i:s', strtotime('+5 hours'));
					$this->M_approvalkaizen->UpdateStatus($kaizen_id, 4, $status_date);
				}elseif ($yangReject) {
					$status_date =  date('Y-m-d h:i:s', strtotime('+5 hours'));
					$this->M_approvalkaizen->UpdateStatus($kaizen_id, 5, $status_date);
				}
			}else{
				$nextlevel = $this->input->post('levelnext');
				$approver = $this->input->post('slcApprover');

				$data = array('approver' => $approver ,
							  'level' => $nextlevel,
							  'kaizen_id' => $kaizen_id,
							  'ready' => '1');
				$checkExist = $this->M_submit->checkExist($data);
				if ($checkExist == 0) {
					$this->M_submit->SaveApprover($data);
				}
				$getname = $this->M_approvalkaizen->getName($approver);
				$name= $getname[0]['employee_name'];
				$this->EmailAlert($approver,$kaizen_id);
				$username = $this->session->userdata('employee');
				$detail = "(Approval Add Set) - ";
				$detail .= "Kaizen ini telah dimintakan approve kepada ".$name." oleh".$username;

				$datalog =array(
					'kaizen_id' => $kaizen_id,
					'status' => $status,
					'detail' => $detail,
					'waktu' => date('Y-m-d h:i:s', strtotime('+5 hours')),
					 );
				$this->M_log->save_log($datalog);
			}

			if ($status == 3) {
				if ($level == 1) {
					$this->EmailAlert($NoindApprover[2], $kaizen_id);
					$updateReady = $this->M_approvalkaizen->updateReady(2, $kaizen_id, 1);
				}elseif ($level == 2) {
					$this->EmailAlert($NoindApprover[3], $kaizen_id);
					$updateReady = $this->M_approvalkaizen->updateReady(3, $kaizen_id, 1);
				}elseif ($level == 3) {
					$this->EmailAlert($NoindApprover[3], $kaizen_id);
					$updateReady = $this->M_approvalkaizen->updateReady(4, $kaizen_id, 1);
				}
			}

			$status_name = ($status == '3') ? 'Approved' : (($status == '4') ? 'Revision' : 'Rejected'); 
			$name_user = $this->session->employee;

			$detail = "(Approval $status_name) - ";
			$detail .= $name_user." telah memberi keputusan ".$status_name." pada kaizen ini";

			$datalog =array(
					'kaizen_id' => $kaizen_id,
					'status' => $status,
					'detail' => $detail,
					'waktu' => date('Y-m-d h:i:s', strtotime('+5 hours')),
				 );
			$this->M_log->save_log($datalog);

			redirect(base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/index'));
		}


		public function resultRealisasi($id){
			$kaizen_id = $id;
			$employee_code = $this->session->user;
			$reason = $this->input->post('txtReason');
			$level = 6;
			$status = 3;
			$update = $this->M_approvalkaizen->updateStatusApprove($kaizen_id,$employee_code,$status,$reason,$level);
			$status_date =  date('Y-m-d h:i:s', strtotime('+5 hours'));
			$this->M_approvalkaizen->UpdateStatus($kaizen_id, 7, $status_date);
			//log and mail
			$status_name = 'Approved'; 
			$name_user = $this->session->employee;

			$detail = "(Approval Realisasi $status_name) - ";
			$detail .= $name_user." telah memberi keputusan ".$status_name." pada kaizen ini";

			$datalog =array(
					'kaizen_id' => $kaizen_id,
					'status' => 7,
					'detail' => $detail,
					'waktu' => date('Y-m-d h:i:s', strtotime('+5 hours')),
				 );
			$this->M_log->save_log($datalog);
			redirect(base_url('SystemIntegration/KaizenGenerator/ApprovalKaizen/index'));

		}

		public function EmailAlert($user, $kaizen_id)
		{
			//email
			$getEmail = $this->M_submit->getEmail($user);
			// $emailUser = $getEmail[0]['internal_mail'];
			$emailUser = 'kuswandaru@quick.com';
			//get Rincian Kaizen
			$getKaizen = $this->M_submit->getKaizen($kaizen_id,FALSE);

			//get template
			$link = base_url("SystemIntegration/KaizenGenerator/View/$kaizen_id");
			$getEmailTemplate = $this->M_submit->getEmailTemplate(1);
			$subject = $getEmailTemplate[0]['subject'];
			$body = sprintf($getEmailTemplate[0]['body'], $getKaizen[0]['pencetus'],$getKaizen[0]['judul'],$link);

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

			
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
				exit();
			} else {
				echo "Message sent!";
			}
		}
}