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

		$data['trainer'] = $this->M_record->GetTrainer();

		$paket          = $this->M_record->paket();
		$pelatihan		= $this->M_record->pelatihan();
        $record             = array();
        $checkoutData       = array();
        $iRec               = 0;
        $iCheck             = 0;
        foreach ($pelatihan as $key => $valPL) {
            if ($valPL['package_scheduling_id'] == 0) {
                $record[$iRec] = $valPL;
                $iRec++;
            }else{
                foreach ($paket as $i => $valPK) {
                    if ($valPL['package_scheduling_id'] == $valPK['package_scheduling_id'] && !in_array($valPL['package_scheduling_id'], $checkoutData)) {
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
                            'tidak_terlaksana'          => '' || $valPL['tidak_terlaksana'] 
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
		
		// $data['record'] = $this->M_record->GetRecordFinished();
		$schedule = $this->M_report->GetSchName_QuesName();
		$data['GetSchName_QuesName'] = $schedule;
		$questionnaireID= $schedule[0]['questionnaire_id'];
		$data['qe']=$questionnaireID;
		$data['trainer'] = $this->M_record->GetTrainer();

		$GetRecordFinished2 = $this->M_record->paket();
		$GetRecordFinished1	= $this->M_record->GetRecordFinished1();
        $record             = array();
        $checkoutData       = array();
        $iRec               = 0;
        $iCheck             = 0;
        foreach ($GetRecordFinished1 as $key => $valPL) {
            if ($valPL['package_scheduling_id'] == 0) {
                $record[$iRec] = $valPL;
                $iRec++;
            }else{
                foreach ($GetRecordFinished2 as $i => $valPK) {
                    if ($valPL['package_scheduling_id'] == $valPK['package_scheduling_id'] && !in_array($valPL['package_scheduling_id'], $checkoutData)) {
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
                            'tidak_terlaksana'          => '' || $valPL['tidak_terlaksana'] 
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
		$sifat			= $this->input->post('slcSifat');
		$jmlpeserta		= $this->input->post('txtJumlahPeserta', TRUE);

		$kirim = array(
			'scheduling_name' 	=> $namapelatihan,
			'date'			  	=> $tanggal,
			'start_time'		=> $waktuawal,
			'end_time'			=> $waktuakhir,
			'room' 				=> $ruangan,
			'evaluation'		=> $evaluasi2,
			'sifat'				=> $sifat,
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

		// AMBIL NILAI UNTUK REAKSI
		$schedule = $this->M_report->GetSchName_QuesName();
		$data['GetSchName_QuesName'] = $schedule;
		$segment = $this->M_report->GetSchName_QuesName_segmen();
		$statement= $this->M_report->GetStatement();
		$nilai = $this->M_report->GetSheetAll();

		$t_nilai = array();
		$x = 0;
		foreach ($schedule as $sch) {
			foreach ($segment as $key => $value) {
				if ($sch['scheduling_id']==$value['scheduling_id'] && $sch['questionnaire_id']==$value['questionnaire_id']) {

					$total_nilai=array();
					$tid = 0;
					$tot_p = 0;
					$tot_s = 0;
					$tot_p_checkpoint = 0;

					foreach ($statement as $st) {

						if ($value['segment_id']==$st['segment_id'] && $value['questionnaire_id']==$st['questionnaire_id']) {
							$a_tot = 0;
							foreach ($nilai as $index => $score) {								
								if ($value['scheduling_id']==$score['scheduling_id'] && $st['questionnaire_id']==$score['questionnaire_id'] && $st['segment_id']==$score['segment_id']) {
									$a=explode('||', $score['join_input']);
									$b=explode('||', $score['join_statement_id']);
									foreach ($b as $bi => $bb) {
										if ($bb==$st['statement_id']) {
											$a_tot+=$a[$bi];
											if ($tot_p_checkpoint == 0) {
												$tot_p++;
											}
										}
									}
								}
							}
							
							$total_nilai[$tid++] = array(
								'segment_id' => $st['segment_id'], 
								'statement_id' => $st['statement_id'], 
								'total' => $a_tot, 
							);
							$tot_s++;
							$tot_p_checkpoint = 1;
						}
					}

					$final_total=0;
					foreach ($total_nilai as $n => $tn) {
						$final_total+=$tn['total'];
					}
					$t_rerata=$final_total/($tot_s*$tot_p);

					$t_nilai[$x++]= array(
						'scheduling_id'		=> $value['scheduling_id'], 
						'questionnaire_id'	=> $value['questionnaire_id'], 
						'segment_id'		=> $value['segment_id'], 
						'f_total'			=> $final_total, 
						'f_rata'			=> $t_rerata 
					);
				}
			}

		}

		$data_scd = array();
		foreach ($schedule as $key => $va) {
			$jumlah_segment = 0;
			$jumlah=0;
			foreach ($t_nilai as $k => $value) {
				if ($value['scheduling_id']==$va['scheduling_id'] && $value['questionnaire_id']==$va['questionnaire_id']) {
					$jumlah_segment++;
					$jumlah += $value['f_total'];
				}
			}

			$nilai_reaksi=

			$data_scd [$key]= array(
						'scheduling_id'		=> $va['scheduling_id'],
						'questionnaire_id'		=> $va['questionnaire_id'],
						'segment'		=> $jumlah_segment,
						'total'			=> $jumlah
			);
		}
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

		$ParticipantId 		= $this->input->post('txtId');
		$ParticipantStatus 	= $this->input->post('slcStatus');
		$ScoreEval1Post		= $this->input->post('txtReaksiPost');
		$ScoreEval2Pre 		= $this->input->post('txtPengetahuanPre');
		$ScoreEval2Post		= $this->input->post('txtPengetahuanPost');
		$ScoreEval3Pre 		= $this->input->post('txtPerilakuPre');
		$ScoreEval3Post 	= $this->input->post('txtPerilakuPost');
		$ScoreEval3Eval 	= $this->input->post('txtPerilakuEvalLap');
		$Comment		 	= $this->input->post('txtKeterangan');
		
			$i=0;
			foreach($ParticipantId as $loop){
				$id = $ParticipantId[$i];
				if(empty($ScoreEval1Post[$i])){$ScoreEval1Post[$i] = NULL;}
				if(empty($ScoreEval2Pre[$i])){$ScoreEval2Pre[$i] = NULL;}
				if(empty($ScoreEval3Pre[$i])){$ScoreEval3Pre[$i] = NULL;}
				if(empty($ScoreEval3Post[$i])){$ScoreEval3Post[$i] = NULL;}
				if(empty($ScoreEval2Post[$i])){$ScoreEval2Post[$i] = NULL;}
				if(empty($ScoreEval3Eval[$i])){$ScoreEval3Eval[$i] = NULL;}
				if(empty($Comment[$i])){$Comment[$i] = NULL;}
				
				$data_participant[$i] = array(
					'status' 			=> $ParticipantStatus[$i],
					'score_eval1_post' 	=> $ScoreEval1Post[$i],
					'score_eval2_pre' 	=> $ScoreEval2Pre[$i],
					'score_eval3_pre' 	=> $ScoreEval3Pre[$i],
					'score_eval3_post1' => $ScoreEval3Post[$i],
					'score_eval2_post' 	=> $ScoreEval2Post[$i],
					'score_eval3_post2' => $ScoreEval3Eval[$i],
					'comment' 			=> $Comment[$i],
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
// ----------------------------------------------------------------------JAVASCRIPT---------------------------------------------------------------
	//FILTER RECORD
	public function FilterRecord(){
		
		$start 			= $this->input->POST('start');
		$end 			= $this->input->POST('end');
		$status 		= $this->input->POST('status');
		
		$data['record'] = $this->M_record->FilterRecord($start,$end,$status);
		$data['trainer'] = $this->M_record->GetTrainer();
		$this->load->view('ADMPelatihan/Record/V_Index2',$data);
		$this->load->view('ADMPelatihan/Record/V_Index2_4',$data);
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
		$data['recPackage'] = $this->M_record->GetRecordPackage($id);
		$data['trainer']	= $this->M_record->GetTrainer();
		$data['paketdetail']		= $this->M_record->paketdetail($id);

		$this->load->view('ADMPelatihan/Record/V_Index2_2', $data);
	}

	public function GetPackageIDfinish($id)
	{
		$data['recPackage'] = $this->M_record->GetRecordFinished($id);
		$data['trainer']	= $this->M_record->GetTrainer();
		$data['paketdetailfinish']		= $this->M_record->paketdetailfinish($id);

		$this->load->view('ADMPelatihan/Record/V_Index2_3', $data);
	}
}
