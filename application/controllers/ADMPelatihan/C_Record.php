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
		$this->load->model('ADMPelatihan/M_report');
		$this->load->model('ADMPelatihan/M_inputquestionnaire');
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
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}

		$data['trainer'] = $this->M_record->GetTrainer();
		$data['participant_confirm'] = $this->M_record->GetParticipant();

		$paket          = $this->M_record->paket();
		$pelatihan		= $this->M_record->pelatihan();
        $record             = array();
        $checkoutData       = array();
        $iRec               = 0;
        $iCheck             = 0;
        foreach ($pelatihan as $key => $valPL) {
            if ($valPL['package_scheduling_id'] == 0) {
            	$cekNumRow = $this->M_record->cekNumRowQuestRecord($valPL['scheduling_id']);
            	if ($cekNumRow == 0) {
            		$questStatus = '';
            	}else{
            		$questStatus = 'font-weight:bold';
            	}

            	$dataPaket   = array(
                            'scheduling_id'             => $valPL['scheduling_id'],
                            'package_scheduling_id'     => $valPL['package_scheduling_id'],
                            'scheduling_name'           => $valPL['scheduling_name'],
                            'date'                      => $valPL['date'],
                            'room'                      => $valPL['room'],
                            'participant_type'          => $valPL['participant_type'],
                            'trainer'                   => $valPL['trainer'],
                            'evaluation'                => $valPL['evaluation'],
                            'sifat'                     => $valPL['sifat'],
                            'participant_number'        => $valPL['participant_number'],
                            'status'                    => $valPL['status'],
                            'package_scheduling_name'   => $valPL['package_scheduling_name'],
                            'start_date_format'         => $valPL['start_date_format'],
                            'end_date_format'           => $valPL['end_date_format'],
                            'date_format'               => $valPL['date_format'],
                            'tidak_terlaksana'          => $valPL['tidak_terlaksana'],
                            'quest_status'		        => $questStatus
                        );
                $record[$iRec] = $dataPaket;
                // $record[$iRec] = $valPL;
                $iRec++;
           }else{
                foreach ($paket as $i => $valPK) {
                    if ($valPL['package_scheduling_id'] == $valPK['package_scheduling_id'] && !in_array($valPL['package_scheduling_id'], $checkoutData)) {
		            	$cekNumRow = $this->M_record->cekNumRowQuestRecord($valPL['scheduling_id']);
		            	if ($cekNumRow == 0) {
		            		$questStatus = '';
		            	}else{
		            		$questStatus = 'font-weight:bold';
		            	}
                        $dataPaket   = array(
                            'scheduling_id'             => '-',
                            'package_scheduling_id'     => $valPK['package_scheduling_id'],
                            'scheduling_name'           => '-',
                            'date'                      => '-',
                            'room'                      => $valPL['room'],
                            'participant_type'          => $valPL['participant_type'],
                            'trainer'                   => '-',
                            'evaluation'                => '-',
                            'sifat'                     => $valPL['sifat'],
                            'participant_number'        => $valPL['participant_number'],
                            'status'                    => $valPL['status'],
                            'package_scheduling_name'   => $valPL['package_scheduling_name'],
                            'start_date_format'         => $valPL['start_date_format'],
                            'end_date_format'           => $valPL['end_date_format'],
                            'date_format'               => '-',
                            'tidak_terlaksana'          => '' || $valPL['tidak_terlaksana'],
                            'quest_status'		        => $questStatus 
                        );
                        $record[$iRec] = $dataPaket;
                        $checkoutData[$iCheck] = $valPL['package_scheduling_id'];
                        $iRec++;
                        $iCheck++;
                    }
                }
            }
        }
        $data['record'] = $record;

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
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
		// $data['record'] = $this->M_record->GetRecordFinished();
		$schedule 						= $this->M_report->GetSchName_QuesName();
		$data['GetSchName_QuesName'] 	= $schedule;
		$questionnaireID 				= $schedule[0]['questionnaire_id'];
		$data['qe'] 					=$questionnaireID;
		$data['trainer'] 				= $this->M_record->GetTrainer();
		$data['participant_confirm'] = $this->M_record->GetParticipant();

		$GetRecordFinished2 = $this->M_record->paket();
		$GetRecordFinished1	= $this->M_record->GetRecordFinished1();
        $record             = array();
        $checkoutData       = array();
        $iRec               = 0;
        $iCheck             = 0;
        foreach ($GetRecordFinished1 as $key => $valPL) {
            if ($valPL['package_scheduling_id'] == 0) {

            	$cekNumRow = $this->M_record->cekNumRowQuestRecord($valPL['scheduling_id']);
            	if ($cekNumRow == 0) {
            		$questStatus = '';
            	}else{
            		$questStatus = 'font-weight:bold';
            	}

            	$dataPaket   = array(
                            'scheduling_id'             => $valPL['scheduling_id'],
                            'package_scheduling_id'     => $valPL['package_scheduling_id'],
                            'scheduling_name'           => $valPL['scheduling_name'],
                            'date'                      => $valPL['date'],
                            'room'                      => $valPL['room'],
                            'participant_type'          => $valPL['participant_type'],
                            'trainer'                   => $valPL['trainer'],
                            'evaluation'                => $valPL['evaluation'],
                            'sifat'                     => $valPL['sifat'],
                            'participant_number'        => $valPL['participant_number'],
                            'status'                    => $valPL['status'],
                            'package_scheduling_name'   => $valPL['package_scheduling_name'],
                            'start_date_format'         => $valPL['start_date_format'],
                            'end_date_format'           => $valPL['end_date_format'],
                            'date_format'               => $valPL['date_format'],
                            'tidak_terlaksana'          => $valPL['tidak_terlaksana'],
                            'quest_status'		        => $questStatus
                        );
                $record[$iRec] = $dataPaket;
                // $record[$iRec] = $valPL;
                $iRec++;
            }else{
                foreach ($GetRecordFinished2 as $i => $valPK) {
                    if ($valPL['package_scheduling_id'] == $valPK['package_scheduling_id'] && !in_array($valPL['package_scheduling_id'], $checkoutData)) {
                    	
                    	$cekNumRow = $this->M_record->cekNumRowQuestRecord($valPL['scheduling_id']);
                    	if ($cekNumRow == 0) {
                    		$questStatus = '';
                    	}else{
                    		$questStatus = 'font-weight:bold';
                    	}

                        $dataPaket   = array(
                            'scheduling_id'             => '-',
                            'package_scheduling_id'     => $valPK['package_scheduling_id'],
                            'scheduling_name'           => '-',
                            'date'                      => '-',
                            'room'                      => $valPL['room'],
                            'participant_type'          => $valPL['participant_type'],
                            'trainer'                   => '-',
                            'evaluation'                => '-',
                            'sifat'                     => $valPL['sifat'],
                            'participant_number'        => $valPL['participant_number'],
                            'status'                    => $valPL['status'],
                            'package_scheduling_name'   => $valPL['package_scheduling_name'],
                            'start_date_format'         => $valPL['start_date_format'],
                            'end_date_format'           => $valPL['end_date_format'],
                            'date_format'               => '-',
                            'tidak_terlaksana'          => '' || $valPL['tidak_terlaksana'],
                            'quest_status'		        => $questStatus
                        );
                        $record[$iRec] = $dataPaket;
                        $checkoutData[$iCheck] = $valPL['package_scheduling_id'];
                        $iRec++;
                        $iCheck++;
                    }
                }
            }
        }

        $data['record'] = $record;

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
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
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
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
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
		$sifat			= $this->input->post('slcSifat');
		$jmlpeserta		= $this->input->post('txtJumlahPeserta', TRUE);
		$trainer		= $this->input->post('slcTrainer');
		$trainers 		= implode(',', $trainer);

		$kirim = array(
			'scheduling_name' 	=> $namapelatihan,
			'date'			  	=> $tanggal,
			'start_time'		=> $waktuawal,
			'end_time'			=> $waktuakhir,
			'room' 				=> $ruangan,
			'evaluation'		=> $evaluasi2,
			'sifat'				=> $sifat,
			'participant_number'=> $jmlpeserta,
			'trainer'			=> $trainers 
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
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
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

		//AMBIL NILAI DARI TOS 
		$prt = $this->M_record->GetParticipantId($id);
		if (!empty($prt) && $data['record'][0]['package_training_id']!=0) {
			$noindPtc = $prt[0]['noind'];
			$schName = $data['record'][0]['scheduling_name'];
			$tgl 	= $data['record'][0]['date_foredit'];
			$pid 	= $data['record'][0]['package_training_id'];
			$mysql	= $this->M_record->GetScoreO($noindPtc,$schName,$tgl);
			$psg	= $this->M_record->GetScoreS($pid);
			
			if (!empty($mysql)) {
				$a = $this->M_record->UpdateScore($mysql[0]['id_num'],strtoupper($mysql[0]['nama']),strtoupper($mysql[0]['kategori']),$mysql[0]['time_record'],$mysql[0]['result']);
			}
		}
		//--AMBIL NILAI DARI TOS 
		$data['participant'] = $this->M_record->GetParticipantId($id);
		$data['trainer'] = $this->M_record->GetTrainer();
		$data['purpose'] = $this->M_record->GetObjectiveId($data['record'][0]['training_id']);

		// // AMBIL NILAI UNTUK REAKSI
		$schedule = $this->M_report->GetSchName_QuesName();
		$data['GetSchName_QuesName'] = $schedule;
		$segment = $this->M_report->GetSchName_QuesName_segmen();
		$statement= $this->M_report->GetStatement();
		$nilai = $this->M_report->GetSheetAll();

		// AMBIL NILAI DARI REPORT BY QUESTIONNAIRE
		$qe= $schedule[0]['questionnaire_id'];
		$data['qe']=$qe;
		$data['sheet'] = $this->M_report->GetSheet($id,$qe);
		$data['segment'] 		= $this->M_report->GetQuestionnaireSegmentId($id,$qe);
		$data['segmentessay'] 	= $this->M_inputquestionnaire->GetQuestionnaireSegmentEssayId($qe);
		$data['statement'] 		= $this->M_inputquestionnaire->GetQuestionnaireStatementId($qe);
		$data['GetSchName_QuesName_detail'] = $this->M_report->GetSchName_QuesName_detail($id,$qe);
		$data['GetQuestParticipant'] = $this->M_report->GetQuestParticipant($id);

		// HITUNG ROWSPAN---------------------------------------------------------------------------
		$data['stj_temp'] 		= array();
		$sgstCount	= array();
		foreach ($data['segment'] as $key => $sg) {
			$rowspan	= 0;
			foreach ($data['statement'] as $i => $val) {
				if ($sg['segment_id'] == $val['segment_id']) {
					$rowspan++;
				}
			}
			$sgstCount[$key] = array(
				'segment_id' => $sg['segment_id'],
				'rowspan' => $rowspan
				);
		}
		$data['sgstCount'] 		= $sgstCount;
		// HITUNG ROWSPAN---------------------------------------------------------------------------

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

		$ParticipantId 			= $this->input->post('txtId');
		$ParticipantStatus 		= $this->input->post('slcStatus');
		$ScoreEval2Pre 			= $this->input->post('txtPengetahuanPre');
		$ScoreEval2Post			= $this->input->post('txtPengetahuanPost');
		$ScoreEval2R1			= $this->input->post('txtPengetahuanR1');
		$ScoreEval2R2			= $this->input->post('txtPengetahuanR2');
		$ScoreEval2R3			= $this->input->post('txtPengetahuanR3');
		$ScoreEval3_hardskill	= $this->input->post('txtPerilakuHardskill');
		$ScoreEval3_softskill	= $this->input->post('txtPerilakuSoftskill');
		$Keterangan_hardskill	= $this->input->post('txtPerilaku_ket_1');
		$Keterangan_softskill	= $this->input->post('txtPerilaku_ket_2');
		$Comment		 		= $this->input->post('txtKeterangan');
		$Others			 		= $this->input->post('txtOthers');
		
			$i=0;
			foreach($ParticipantId as $loop){
				$id = $ParticipantId[$i];
				if(empty($ScoreEval2Pre[$i])){$ScoreEval2Pre[$i] = NULL;}
				if(empty($ScoreEval2Post[$i])){$ScoreEval2Post[$i] = NULL;}
				if(empty($ScoreEval2R1[$i])){$ScoreEval2R1[$i] = NULL;}
				if(empty($ScoreEval2R2[$i])){$ScoreEval2R2[$i] = NULL;}
				if(empty($ScoreEval2R3[$i])){$ScoreEval2R3[$i] = NULL;}
				if(empty($ScoreEval3_hardskill[$i])){$ScoreEval3_hardskill[$i] = NULL;}
				if(empty($ScoreEval3_softskill[$i])){$ScoreEval3_softskill[$i] = NULL;}
				if(empty($Keterangan_hardskill[$i])){$Keterangan_hardskill[$i] = NULL;}
				if(empty($Keterangan_softskill[$i])){$Keterangan_softskill[$i] = NULL;}
				if(empty($Comment[$i])){$Comment[$i] = NULL;}
				if(empty($Others[$i])){$Others[$i] = NULL;}
				
				$data_participant[$i] = array(
					'status' 					=> $ParticipantStatus[$i],
					'score_eval2_pre' 			=> $ScoreEval2Pre[$i],
					'score_eval2_post' 			=> $ScoreEval2Post[$i],
					'score_eval2_r1' 			=> $ScoreEval2R1[$i],
					'score_eval2_r2' 			=> $ScoreEval2R2[$i],
					'score_eval2_r3' 			=> $ScoreEval2R3[$i],
					'score_eval3_hardskill' 	=> $ScoreEval3_hardskill[$i],
					'score_eval3_softskill' 	=> $ScoreEval3_softskill[$i],
					'keterangan_hardskill' 		=> $Keterangan_hardskill[$i],
					'keterangan_softskill' 		=> $Keterangan_softskill[$i],
					'comment' 					=> $Comment[$i],
					'keterangan_kehadiran'		=> $Others[$i],
				);
				$this->M_record->DoConfirmParticipant($id,$data_participant[$i]);				
				$i++;
			}
		// print_r($data_participant);
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


	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	 public function CetakSertifikat($id)
		{
		//$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		//$plaintext_string = $this->encrypt->decode($plaintext_string);
		//$data ['peserta']= $this->M_daftarhadir->getPesertaPelatihanByID($plaintext_string);
		//$data['Pelatihan'] = $this->M_daftarhadir->getPelatihanByID($plaintext_string);
         //Ini kalau mau ditampilkan datanya di view yang dituju harus ditulis seperti ini, karena yang dibawa $data
         // echo "<pre>";
		  //print_r($data);exit();

		
		$data['record'] = $this->M_record->GetRecordId($id);
		   //echo "<pre>";
		  //print_r($data['record']);exit();
		$data['GetEvaluationType'] = $this->M_penjadwalan->GetEvaluationType();
		$data['purpose'] = $this->M_record->GetObjectiveId($data['record'][0]['training_id']);

		//MENENTUKAN SOURCE OBJECTIVE BERDASARKAN STATUS PELATIHAN (PAKET/NON-PAKET)
		$trainingdt		= $data['record'][0];
		$trainingid 	= $trainingdt['training_id'];
		$trainingst		= $this->M_record->GetTrainingType($trainingid);
		$status 		= $trainingst[0]->status;
		
		$data['participant'] = $this->M_record->GetParticipantId($id);
		$data['trainer'] = $this->M_record->GetTrainer();

			$this->load->library('pdf');

			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', array(210,297), 0, '',9, 9, 9, 0, 0, 0, 'L');
			$filename = 'sertifikat.pdf';


			$html = $this->load->view('ADMPelatihan/Record/V_CetakSertifikat', $data, true);

			$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
			$pdf->WriteHTML($stylesheet1,1);
			$pdf->WriteHTML($html, 2);
		    $pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
		}
// ----------------------------------------------------------------------JAVASCRIPT---------------------------------------------------------------
	//FILTER RECORD
	public function FilterRecord(){
		
		$start 			= $this->input->POST('start');
		$end 			= $this->input->POST('end');
		$status 		= $this->input->POST('status');
		$data['participant_confirm'] = $this->M_record->GetParticipant();
		
		// $data['record'] = $this->M_record->FilterRecord($start,$end,$status);
		$data['trainer'] = $this->M_record->GetTrainer();
		$data['sheet'] = $this->M_record->GetQueSheet();
		$filter				= $this->M_record->FilterRecord($start,$end,$status);
        $record             = array();
        $checkoutData       = array();
        $iRec               = 0;
        $iCheck             = 0;
        foreach ($filter as $key => $valPL) {
            if ($valPL['package_scheduling_id'] == 0) {

            	$cekNumRow = $this->M_record->cekNumRowQuestRecord($valPL['scheduling_id']);
            	if ($cekNumRow == 0) {
            		$questStatus = '';
            	}else{
            		$questStatus = 'font-weight:bold';
            	}

            	$dataPaket   = array(
                            'scheduling_id'             => $valPL['scheduling_id'],
                            'package_scheduling_id'     => $valPL['package_scheduling_id'],
                            'scheduling_name'           => $valPL['scheduling_name'],
                            'date'                      => $valPL['date'],
                            'room'                      => $valPL['room'],
                            'participant_type'          => $valPL['participant_type'],
                            'trainer'                   => $valPL['trainer'],
                            'evaluation'                => $valPL['evaluation'],
                            'sifat'                     => $valPL['sifat'],
                            'participant_number'        => $valPL['participant_number'],
                            'status'                    => $valPL['status'],
                            'package_scheduling_name'   => $valPL['package_scheduling_name'],
                            'start_date_format'         => $valPL['start_date_format'],
                            'end_date_format'           => $valPL['end_date_format'],
                            'date_format'               => $valPL['date_format'],
                            'tidak_terlaksana'          => $valPL['tidak_terlaksana'],
                            'quest_status'		        => $questStatus
                        );
                $record[$iRec] = $dataPaket;
                // $record[$iRec] = $valPL;
                $iRec++;
            }else{
                foreach ($filter as $i => $valPK) {
                    if ($valPL['package_scheduling_id'] == $valPK['package_scheduling_id'] && !in_array($valPL['package_scheduling_id'], $checkoutData)) {
                    	
                    	$cekNumRow = $this->M_record->cekNumRowQuestRecord($valPL['scheduling_id']);
                    	if ($cekNumRow == 0) {
                    		$questStatus = '';
                    	}else{
                    		$questStatus = 'font-weight:bold';
                    	}

                        $dataPaket   = array(
                            'scheduling_id'             => '-',
                            'package_scheduling_id'     => $valPK['package_scheduling_id'],
                            'scheduling_name'           => '-',
                            'date'                      => '-',
                            'room'                      => $valPL['room'],
                            'participant_type'          => $valPL['participant_type'],
                            'trainer'                   => '-',
                            'evaluation'                => '-',
                            'sifat'                     => $valPL['sifat'],
                            'participant_number'        => $valPL['participant_number'],
                            'status'                    => $valPL['status'],
                            'package_scheduling_name'   => $valPL['package_scheduling_name'],
                            'start_date_format'         => $valPL['start_date_format'],
                            'end_date_format'           => $valPL['end_date_format'],
                            'date_format'               => '-',
                            'tidak_terlaksana'          => '' || $valPL['tidak_terlaksana'],
                            'quest_status'		        => $questStatus
                        );
                        $record[$iRec] = $dataPaket;
                        $checkoutData[$iCheck] = $valPL['package_scheduling_id'];
                        $iRec++;
                        $iCheck++;
                    }
                }
            }
        }
        $data['record'] = $record;

		$this->load->view('ADMPelatihan/Record/V_Index2',$data);
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

	public function GetPackageID($id)
	{
		$data['recPackage'] 		= $this->M_record->GetRecordPackage($id);
		$data['participant_confirm'] = $this->M_record->GetParticipant();
		$data['trainer']			= $this->M_record->GetTrainer();
		$data['paketdetail']		= $this->M_record->paketdetail($id);
		$data['sheet'] 				= $this->M_record->GetQueSheet();

		$this->load->view('ADMPelatihan/Record/V_Index2_2', $data);
	}

	public function GetPackageIDfinish($id)
	{
		// $data['recPackage'] 		= $this->M_record->GetRecordFinished($id);
		$data['participant_confirm'] = $this->M_record->GetParticipant();
		$data['trainer']			= $this->M_record->GetTrainer();
		$data['paketdetailfinish']	= $this->M_record->paketdetailfinish($id);
		$data['sheet']				 = $this->M_record->GetQueSheet();
		
		$paket_value		= $this->M_record->GetRecordFinished($id);
        $record             = array();
        $checkoutData       = array();
        $iRec               = 0;
        $iCheck             = 0;
        foreach ($paket_value as $key => $valPL) {
            if ($valPL['package_scheduling_id'] != 0) {
            	$cekNumRow = $this->M_record->cekNumRowQuestRecord($valPL['scheduling_id']);
            	if ($cekNumRow == 0) {
            		$questStatus = '';
            	}else{
            		$questStatus = 'font-weight:bold';
            	}
            	$dataPaket   = array(
                            'scheduling_id'             => $valPL['scheduling_id'],
                            'package_scheduling_id'     => $valPL['package_scheduling_id'],
                            'scheduling_name'           => $valPL['scheduling_name'],
                            'date'                      => $valPL['date'],
                            'room'                      => $valPL['room'],
                            'participant_type'          => $valPL['participant_type'],
                            'trainer'                   => $valPL['trainer'],
                            'evaluation'                => $valPL['evaluation'],
                            'sifat'                     => $valPL['sifat'],
                            'participant_number'        => $valPL['participant_number'],
                            'status'                    => $valPL['status'],
                            'package_scheduling_name'   => $valPL['package_scheduling_name'],
                            'start_date_format'         => $valPL['start_date_format'],
                            'end_date_format'           => $valPL['end_date_format'],
                            'date_format'               => $valPL['date_format'],
                            'tidak_terlaksana'          => $valPL['tidak_terlaksana'],
                            'quest_status'		        => $questStatus
                        );
                $record[$iRec] = $dataPaket;
                // $record[$iRec] = $valPL;
                $iRec++;
            }
         }
         $data['recPackage'] = $record;

		$this->load->view('ADMPelatihan/Record/V_Index2_3', $data);
	}
}
