<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Report extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('ADMPelatihan/M_report');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN RECORD BY NAME
	public function reportbyname(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report by Name';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$name='no_valid_name';
		$data['report'] = $this->M_report->GetReport1($name);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/ReportByName/V_Index',$data);
		$this->load->view('ADMPelatihan/Report/ReportByName/V_Index2',$data);
		$this->load->view('ADMPelatihan/Report/ReportByName/V_Index3',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN RECORD BY SECTION
	public function reportbysection(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report by Section';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/ReportBySection/V_Index',$data);
		$this->load->view('ADMPelatihan/ReportBySection/V_Index2',$data);
		$this->load->view('ADMPelatihan/ReportBySection/V_Index3',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN RECORD BY NAME
	public function reportbytraining(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report by Training';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$date1='1/1/1900';
		$date2='1/1/1900';
		$data['report'] = $this->M_report->GetReport3($date1,$date2);
		$data['trainer'] 	= $this->M_report->GetTrainer($date1,$date2);
				
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/ReportByTraining/V_Index',$data);
		$this->load->view('ADMPelatihan/Report/ReportByTraining/V_Index2',$data);
		$this->load->view('ADMPelatihan/Report/ReportByTraining/V_Index3',$data);
		$this->load->view('V_Footer',$data);
	}

//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//

	public function GetNoInduk(){
		$term = $this->input->get("term");
		$data = $this->M_report->GetNoInduk($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{"NoInduk":"'.$data['employee_code'].'","Nama":"'.$data['employee_name'].'"}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	//REPORT 1
	public function GetReport1(){
		
		$name 			= $this->input->POST('name');
		$data['report'] = $this->M_report->GetReport1($name);
		$this->load->view('ADMPelatihan/Report/ReportByName/V_Index2',$data);
	}

	//REPORT 3
	public function GetReport3(){
		
		$date1 				= $this->input->POST('date1');
		$date2 				= $this->input->POST('date2');
		$data['report'] 	= $this->M_report->GetReport3($date1,$date2);
		$data['trainer'] 	= $this->M_report->GetTrainer($date1,$date2);
		$this->load->view('ADMPelatihan/Report/ReportByTraining/V_Index2',$data);
	}

	//HALAMAN FINISHED
	public function finished(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Record';
		$data['SubMenuOne'] = 'Record Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['record'] = $this->M_record->GetRecordFinished();
		$data['trainer'] = $this->M_record->GetTrainer();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Record/V_Indexf',$data);
		$this->load->view('ADMPelatihan/Record/V_Index2',$data);
		$this->load->view('ADMPelatihan/Record/V_Index3',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	//HALAMAN DETAIL
	public function detail($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Record';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['record'] = $this->M_record->GetRecordId($id);
		
		//MENENTUKAN SOURCE OBJECTIVE BERDASARKAN STATUS PELATIHAN (PAKET/NON-PAKET)
		$trainingdt		= $data['record'][0];
		$trainingid 	= $trainingdt['training_id'];
		$trainingst		= $this->M_record->GetTrainingType($trainingid);
		$status 		= $trainingst[0]->status;

		if($status==0){
			$data['objective'] = $this->M_record->GetObjectiveId($id);
		}elseif($status==1){
			$data['objective'] = $this->M_record->GetMasterObjectiveId($trainingid);
		}
		//------------------------------------------------------------------------//

		$data['participant'] = $this->M_record->GetParticipantId($id);
		$data['trainer'] = $this->M_record->GetTrainer();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Record/V_Detail',$data);
		$this->load->view('V_Footer',$data);	
	}

	//HALAMAN EDIT
	public function edit($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Record';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['room'] = $this->M_penjadwalan->GetRoom();
		$data['record'] = $this->M_record->GetRecordId($id);
		$data['objective'] = $this->M_record->GetObjectiveId($id);
		$data['participant'] = $this->M_record->GetParticipantId($id);
		$data['trainer'] = $this->M_record->GetTrainer();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Record/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}


	//HALAMAN KONFIRMASI
	public function confirm($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Record';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		//---GET NOINDUK
		$participant = $this->M_record->GetParticipantId($id);
		foreach($participant as $pr){
			if($pr['noind']===NULL){
			$applicant_number=$pr['noapplicant'];
				if(!empty($pr['noapplicant'])){
					$applicant_data=$this->M_record->GetApplicantDataId($applicant_number);
					foreach ($applicant_data as $ad) {
						$NIK=$ad['NIK'];
						if(!empty($ad['NIK'])){
							$employee_data=$this->M_record->GetEmployeeByNIK($NIK);
							foreach ($employee_data as $ed) {
								$noind=$ed['noind'];
								if(!empty($ed['noind'])){
									$this->M_record->UpdateParticipantNoind($applicant_number,$noind);
								}
							}
						}
					}
				}
			}
		}
		//---GET NOINDUK


		$data['record'] = $this->M_record->GetRecordId($id);
		$data['objective'] = $this->M_record->GetObjectiveId($id);
		$data['participant'] = $this->M_record->GetParticipantId($id);
		$data['trainer'] = $this->M_record->GetTrainer();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Record/V_Confirm',$data);
		$this->load->view('V_Footer',$data);
	}

	//KONFIRMASI PENJADWALAN
	public function DoConfirm(){
		$schedule_number	= $this->input->post('txtSchnum');
		$data_status		= array('status' => 1,);
		
		$this->M_record->DoConfirmSchedule($schedule_number,$data_status);

		$ParticipantId 		= $this->input->post('txtId');
		$ParticipantStatus 	= $this->input->post('slcStatus');
		$ScoreEval2Pre 		= $this->input->post('txtPengetahuanPre');
		$ScoreEval3Pre 		= $this->input->post('txtPerilakuPre');
		$ScoreEval3Post 	= $this->input->post('txtPerilakuPost');
		$ScoreEval3PostR1 	= $this->input->post('txtPerilakuPostRem1');
		$ScoreEval3PostR2 	= $this->input->post('txtPerilakuPostRem2');
		$ScoreEval3PostR3 	= $this->input->post('txtPerilakuPostRem3');
		
			$i=0;
			foreach($ParticipantId as $loop){
				$id = $ParticipantId[$i];
				if(empty($ScoreEval2Pre[$i])){$ScoreEval2Pre[$i] = NULL;}
				if(empty($ScoreEval3Pre[$i])){$ScoreEval3Pre[$i] = NULL;}
				if(empty($ScoreEval3Post[$i])){$ScoreEval3Post[$i] = NULL;}
				if(empty($ScoreEval3PostR1[$i])){$ScoreEval3PostR1[$i] = NULL;}
				if(empty($ScoreEval3PostR2[$i])){$ScoreEval3PostR2[$i] = NULL;}
				if(empty($ScoreEval3PostR3[$i])){$ScoreEval3PostR3[$i] = NULL;}
				
				$data_participant[$i] = array(
					'status' 			=> $ParticipantStatus[$i],
					'score_eval2_pre' 	=> $ScoreEval2Pre[$i],
					'score_eval3_pre' 	=> $ScoreEval3Pre[$i],
					'score_eval3_post1' => $ScoreEval3Post[$i],
					'score_eval3_post2' => $ScoreEval3PostR1[$i],
					'score_eval3_post3' => $ScoreEval3PostR2[$i],
					'score_eval3_post4' => $ScoreEval3PostR3[$i],
				);
				$this->M_record->DoConfirmParticipant($id,$data_participant[$i]);				
				$i++;
			}
		print_r($data_participant);
		redirect('ADMPelatihan/Record');
	}

	//HAPUS RECORD PENJADWALAN
	public function delete($id){
		$this->M_record->DeleteSchedule($id);
		$this->M_record->DeleteScheduleParticipant($id);
		$this->M_record->DeleteScheduleObjective($id);
		redirect('ADMPelatihan/Record');
	}

	//FILTER RECORD
	public function FilterRecord(){
		
		$start 			= $this->input->POST('start');
		$end 			= $this->input->POST('end');
		$status 		= $this->input->POST('status');
		
		$data['record'] = $this->M_record->FilterRecord($start,$end,$status);
		$data['trainer'] = $this->M_record->GetTrainer();
		$this->load->view('ADMPelatihan/Record/V_Index2',$data);
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
