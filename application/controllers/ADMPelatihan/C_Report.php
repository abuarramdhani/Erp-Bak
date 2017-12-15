<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Report extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->
load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
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

		$data['report'] = $this->M_report->GetReport2($year = FALSE,$section = FALSE);
		$data['section'] 	= $this->M_report->GetSeksi($term=FALSE);
		$data['tahunTrain'] 	= $this->M_report->getYearTraining();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/ReportBySection/V_Index',$data);
		$this->load->view('ADMPelatihan/Report/ReportBySection/V_Index2',$data);
		$this->load->view('ADMPelatihan/Report/ReportBySection/V_Index3',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN RECORD BY TRAINING
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
	//HALAMAN RECORD BY QUESTIONNAIRE
	public function reportbyquestionnaire(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report by Questionnaire';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$pelatihan 	= $this->input->POST('pelatihan');
		$date 		= $this->input->POST('date');
		$trainer	= $this->input->POST('trainer');
		
		$data['trainer']= $this->M_report->GetTrainerQue($trainer = FALSE);
		$schedule = $this->M_report->GetSchName_QuesName($pelatihan = FALSE, $date = FALSE);
		$data['GetSchName_QuesName'] = $schedule;
		$segment = $this->M_report->GetSchName_QuesName_segmen();
		$statement= $this->M_report->GetStatement();
		$nilai = $this->M_report->GetSheetAll();

		// HITUNG TOTAL NILAI---------------------------------------------------------------------------
		$t_nilai = array();
		$x = 0;
		foreach ($schedule as $sch) {
			foreach ($segment as $key => $value) {
				if ($sch['scheduling_id']==$value['scheduling_id'] && $sch['questionnaire_id']==$value['questionnaire_id']) {

					$total_nilai=array();
					$id = 0;
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
							
							$total_nilai[$id++] = array(
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
		$data['t_nilai']= $t_nilai;

		// HITUNG ROWSPAN---------------------------------------------------------------------------
		$data['sheet_all'] = '';
		$data['GetSchName_QuesName_segmen'] = $segment;
		$data['index_temp'] 		= array();
		$sgCount	= array();

		foreach ($data['GetSchName_QuesName'] as $i => $val) {
			$rowspan	= 0;
			foreach ($data['GetSchName_QuesName_segmen'] as $key => $sg) {
				if ($sg['scheduling_id'] == $val['scheduling_id'] && $sg['questionnaire_id'] == $val['questionnaire_id']) {
					$rowspan++;
				}
			}
			$sgCount[$i] = array(
				'scheduling_id' => $val['scheduling_id'],
				'questionnaire_id' => $val['questionnaire_id'],
				'rowspan' => $rowspan
				);
		}
		$data['sgCount'] 		= $sgCount;
		// ------------------------------------------------------------------------------------------
		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/ReportByQuestionnaire/V_Index',$data);
		$this->load->view('ADMPelatihan/Report/ReportByQuestionnaire/V_Index2',$data);
		$this->load->view('ADMPelatihan/Report/ReportByQuestionnaire/V_Index3',$data);
		$this->load->view('V_Footer',$data);
	}

	public function reportbyquestionnaire_1($id,$qe){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report by Questionnaire';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['GetSchName_QuesName_detail'] = $this->M_report->GetSchName_QuesName_detail($id,$qe);
		$data['GetQuestParticipant'] = $this->M_report->GetQuestParticipant($id);

		$data['sheet'] = $this->M_report->GetSheet($id,$qe);
		$data['segment'] 		= $this->M_report->GetQuestionnaireSegmentId($id,$qe);
		$data['segmentessay'] 	= $this->M_inputquestionnaire->GetQuestionnaireSegmentEssayId($qe);
		$data['statement'] 		= $this->M_inputquestionnaire->GetQuestionnaireStatementId($qe);

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
		$this->load->view('ADMPelatihan/Report/ReportByQuestionnaire/V_Detail',$data);
		$this->load->view('V_Footer',$data);
	}


	//HALAMAN REKAP 
	public function rekap(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Rekap Pelatihan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN REKAP TRAINING
	public function rekaptraining(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Rekap Training';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date1='1/1/1900';
		$date2='1/1/1900';
		$data['report'] 		= $this->M_report->GetRkpTraining($date1,$date2);
		$data['allpercentage'] 	= $this->M_report->GetRkpTrainingAll($date1,$date2);		
		$data['getsifat'] 		= $this->M_report->GetSifat($date1,$date2);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/RekapTraining/V_index',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/RekapTraining/V_index2',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/RekapTraining/V_index3',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/RekapTraining/V_index4',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN PRESENTASE KEHADIRAN
	public function PresentaseKehadiran(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Presentase Kehadiran';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date1='1/1/1900';
		$date2='1/1/1900';
		$data['prcentpart']		= $this->M_report->GetPercentParticipant($date1,$date2);
		$data['prcentpartall'] 	= $this->M_report->GetPercentParticipantAll($date1,$date2);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/PresentaseKehadiran/V_index',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/PresentaseKehadiran/V_index2',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/PresentaseKehadiran/V_index3',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN EFEKTIVITAS TRAINING
	public function EfektivitasTraining(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Efektivitas Training';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$date1='1/1/1900';
		$date2='1/1/1900';
		$data['efekTrain']		= $this->M_report->GetEfektivitasTraining($date1,$date2);
		$data['efekTrainall'] 	= $this->M_report->GetEfektivitasTrainingAll($date1,$date2);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/EfektivitasTraining/V_index',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/EfektivitasTraining/V_index2',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/EfektivitasTraining/V_index3',$data);
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

	public function GetSeksi(){
		$term = $this->input->get("term");
		$data = $this->M_report->GetSeksi($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{
					"Nama_Seksi":"'.$data['section_name'].'"
				}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	public function GetTrainerFilter(){
		$term = $this->input->get("term");
		$data = $this->M_report->GetTrainerFilter($term);

		echo json_encode($data);
	}

	public function GetTrainingFilter(){
		$term = $this->input->get("term");
		$data = $this->M_report->GetTrainingFilter($term);
		$count = count($data);
		echo "[";
		foreach ($data as $data) {
			$count--;
			echo '{
					"Nama_Training":"'.$data['training_name'].'"
				}';
			if ($count !== 0) {
				echo ",";
			}
		}
		echo "]";
	}

	public function GetTrainingPrtcp($id)
	{	
		$section 	= $this->input->post('section');
		$report 	= $this->M_report->GetTrainingPrtcp($id, $section);
		$no =1;
		foreach ($report as $rc) {
			echo "
				<tr>
				    <td>
				        ".$no++."
				    </td>
				    <td>
				        ".$rc['participant_name']."
				    </td>
				</tr>
			";
		}

	}


	//REPORT 1
	public function GetReport1(){
		
		$name 			= $this->input->POST('name');
		$data['report'] = $this->M_report->GetReport1($name);
		$this->load->view('ADMPelatihan/Report/ReportByName/V_Index2',$data);
	}

	//REPORT 2
	public function GetReport2(){
		
		$section 		= $this->input->POST('section');
		$year 			= $this->input->POST('year');
		$data['report'] = $this->M_report->GetReport2($year,$section);
		$this->load->view('ADMPelatihan/Report/ReportBySection/V_Index2',$data);
	}

	//REPORT 3
	public function GetReport3(){
		
		$date1 				= $this->input->POST('date1');
		$date2 				= $this->input->POST('date2');
		$data['report'] 	= $this->M_report->GetReport3($date1,$date2);
		$data['trainer'] 	= $this->M_report->GetTrainer($date1,$date2);
		$data['sch_package'] 	= $this->M_report->GetSchPackage();

		$this->load->view('ADMPelatihan/Report/ReportByTraining/V_Index2',$data);
	}
	//REPORT 4
	public function GetReport4(){
		
		$pelatihan 			= $this->input->POST('pelatihan');
		$date 				= $this->input->POST('date');
		$trainer			= $this->input->POST('trainer');
		$data['trainer']	= $this->M_report->GetTrainerQue($trainer);
		$schedule = $this->M_report->GetSchName_QuesName($pelatihan, $date, $trainer);

		$data['GetSchName_QuesName'] = $schedule;
		$segment = $this->M_report->GetSchName_QuesName_segmen();
		$statement= $this->M_report->GetStatement();
		$nilai = $this->M_report->GetSheetAll();
		// HITUNG TOTAL NILAI---------------------------------------------------------------------------
		$t_nilai = array();
		$x = 0;
		foreach ($schedule as $sch) {
			foreach ($segment as $key => $value) {
				if ($sch['scheduling_id']==$value['scheduling_id'] && $sch['questionnaire_id']==$value['questionnaire_id']) {

					$total_nilai=array();
					$id = 0;
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
							
							$total_nilai[$id++] = array(
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
		$data['t_nilai']= $t_nilai;

		// HITUNG ROWSPAN---------------------------------------------------------------------------
		$data['sheet_all'] = '';
		$data['GetSchName_QuesName_segmen'] = $segment;
		$data['index_temp'] 		= array();
		$sgCount	= array();

		foreach ($data['GetSchName_QuesName'] as $i => $val) {
			$rowspan	= 0;
			foreach ($data['GetSchName_QuesName_segmen'] as $key => $sg) {
				if ($sg['scheduling_id'] == $val['scheduling_id'] && $sg['questionnaire_id'] == $val['questionnaire_id']) {
					$rowspan++;
				}
			}
			$sgCount[$i] = array(
				'scheduling_id' => $val['scheduling_id'],
				'questionnaire_id' => $val['questionnaire_id'],
				'rowspan' => $rowspan
				);
		}
		$data['sgCount'] 		= $sgCount;
		// ------------------------------------------------------------------------------------------
		$this->load->view('ADMPelatihan/Report/ReportByQuestionnaire/V_Index2',$data);
	}

	//REKAP TRAINING
	public function GetRkpTraining(){
		
		$date1	 				= $this->input->POST('date1');
		$date2 					= $this->input->POST('date2');
		$data['report']		 	= $this->M_report->GetRkpTraining($date1,$date2);
		$data['allpercentage'] 	= $this->M_report->GetRkpTrainingAll($date1,$date2);
		$data['getsifat'] 		= $this->M_report->GetSifat($date1,$date2);
		$this->load->view('ADMPelatihan/Report/Rekap/RekapTraining/V_index2',$data);
		$this->load->view('ADMPelatihan/Report/Rekap/RekapTraining/V_index3',$data);
	}

	//PERSENTASE PESERTA TRAINING
	public function GetPercentParticipant(){
		
		$date1	 				= $this->input->POST('date1');
		$date2 					= $this->input->POST('date2');
		$data['prcentpart']	 	= $this->M_report->GetPercentParticipant($date1,$date2);
		$data['prcentpartall'] 	= $this->M_report->GetPercentParticipantAll($date1,$date2);
		$this->load->view('ADMPelatihan/Report/Rekap/PresentaseKehadiran/V_index2',$data);
	}

	//EFEKTIVITAS TRAINING
	public function GetEfektivitasTraining(){
		
		$date1	 				= $this->input->POST('date1');
		$date2 					= $this->input->POST('date2');
		$data['efekTrain']	 	= $this->M_report->GetEfektivitasTraining($date1,$date2);
		$data['efekTrainall'] 	= $this->M_report->GetEfektivitasTrainingAll($date1,$date2);
		$this->load->view('ADMPelatihan/Report/Rekap/EfektivitasTraining/V_index2',$data);
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
		$data['section'] = $this->M_record->GetSeksi();
		
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
