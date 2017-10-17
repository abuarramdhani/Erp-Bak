<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Record extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
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
		$this->load->model('ADMPelatihan/M_record');
		$this->load->model('ADMPelatihan/M_penjadwalan');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Record';
		$data['SubMenuOne'] = 'Jadwal Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['record'] = $this->M_record->GetRecord();
		$data['trainer'] = $this->M_record->GetTrainer();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Record/V_Index',$data);
		$this->load->view('ADMPelatihan/Record/V_Index2',$data);
		$this->load->view('ADMPelatihan/Record/V_Index3',$data);
		$this->load->view('V_Footer',$data);
		
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
		$data['GetEvaluationType'] = $this->M_penjadwalan->GetEvaluationType();
		$data['purpose'] = $this->M_record->GetObjectiveId($data['record'][0]['training_id']);

		//MENENTUKAN SOURCE OBJECTIVE BERDASARKAN STATUS PELATIHAN (PAKET/NON-PAKET)
		$trainingdt		= $data['record'][0];
		$trainingid 	= $trainingdt['training_id'];
		$trainingst		= $this->M_record->GetTrainingType($trainingid);
		$status 		= $trainingst[0]->status;
		
		$data['participant'] = $this->M_record->GetParticipantId($id);
		$data['trainer'] = $this->M_record->GetTrainer();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Record/V_Detail',$data);
		$this->load->view('V_Footer',$data);	
	}

	//HALAMAN EDIT
	public function Edit($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Record';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['details'] = $this->M_penjadwalan->GetTrainingId($id);
		$data['GetEvaluationType'] = $this->M_penjadwalan->GetEvaluationType();
		$data['ptctype'] = $this->M_penjadwalan->GetParticipantType();
		$data['room'] = $this->M_penjadwalan->GetRoom();
		$data['record'] = $this->M_record->GetRecordId($id);
		$data['purpose'] = $this->M_record->GetObjectiveId($data['record'][0]['training_id']);
		$data['participant'] = $this->M_record->GetParticipantId($id);
		$data['trainer'] = $this->M_record->GetTrainer();
		$data['id'] 	= $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Record/V_Edit',$data);
		$this->load->view('V_Footer',$data);

	}

	public function EditSave($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$namapelatihan 	= $this->input->post('txtNamaPelatihan', TRUE);
		$tanggal 		= str_replace('/', '-', $this->input->post('txtTanggalPelaksanaan', TRUE));
		$tanggal 		= date('Y-m-d', strtotime($tanggal));
		$waktuawal 		= $this->input->post('txtWaktuMulai', TRUE);
		$waktuakhir 	= $this->input->post('txtWaktuSelesai', TRUE);
		$ruangan 		= $this->input->post('slcRuang', TRUE);
		$evaluasi		= $this->input->post('slcEvaluasi', TRUE);
		$evaluasi2 		= implode(',', $evaluasi);
		$jmlpeserta		= $this->input->post('txtJumlahPeserta', TRUE);

		$kirim = array(
			'scheduling_name' 	=> $namapelatihan,
			'date'			  	=> $tanggal,
			'start_time'		=> $waktuawal,
			'end_time'			=> $waktuakhir,
			'room' 				=> $ruangan,
			'evaluation'		=> $evaluasi2,
			'participant_number'=> $jmlpeserta 
			);

		$participant	= $this->input->post('slcEmployee', TRUE);
		$j=0;
			foreach($participant as $loop){
				$dataemployee	= $this->M_record->GetEmployeeData($loop);
					foreach ($dataemployee as $de) {
						$noind		= $de['employee_code'];
						$name		= $de['employee_name'];
					}
				$data_participant[$j] = array(
					'scheduling_id' 	=> $id,
					'participant_name' 	=> $name,
					'noind' 			=> $noind,
					'status'			=> '0',
				);
				if( !empty($participant[$j]) ){
					$this->M_record->AddParticipant($data_participant[$j]);
				}
				$j++;
			}
		$this->M_record->UpdateSchedule($kirim, $id);
		redirect('ADMPelatihan/Record/Detail/'.$id);
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

		$staf = array();
		$nonstaf = array();
		$data['record'] = $this->M_record->GetRecordId($id);
		$data['purpose'] = $this->M_record->GetObjectiveId($data['record'][0]['training_id']);
		$data['participant'] = $this->M_record->GetParticipantId($id);
		$data['trainer'] = $this->M_record->GetTrainer();
		$data['purpose'] = $this->M_record->GetObjectiveId($data['record'][0]['training_id']);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Record/V_Confirm',$data,$staf,$nonstaf);
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
		$ScoreEval2Post		= $this->input->post('txtPengetahuanPost');
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
				if(empty($ScoreEval2Post[$i])){$ScoreEval2Post[$i] = NULL;}
				
				$data_participant[$i] = array(
					'status' 			=> $ParticipantStatus[$i],
					'score_eval2_pre' 	=> $ScoreEval2Pre[$i],
					'score_eval3_pre' 	=> $ScoreEval3Pre[$i],
					'score_eval3_post1' => $ScoreEval3Post[$i],
					'score_eval3_post2' => $ScoreEval3PostR1[$i],
					'score_eval3_post3' => $ScoreEval3PostR2[$i],
					'score_eval3_post4' => $ScoreEval3PostR3[$i],
					'score_eval2_post' 	=> $ScoreEval2Post[$i],
				);
				// echo "<pre>";
				// print_r($data_participant[$i]);
				// echo "</pre>";
				// exit();
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

	public function deleteParticipant($pid,$schID)
	{
		$this->M_record->deleteParticipant($pid, $schID);
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

	public function GetNoInduk(){
		$term = $this->input->get("term");
		$data = $this->M_record->GetNoInduk($term);
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
}
