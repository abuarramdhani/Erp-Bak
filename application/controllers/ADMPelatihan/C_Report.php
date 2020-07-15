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
		$this->load->model('ADMPelatihan/M_record');
		$this->load->model('ADMPelatihan/M_inputquestionnaire');
		$this->load->model('ADMPelatihan/M_mastertrainer');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$date1='1/1/1900';
		$date2='1/1/1900';
		$data['report'] 	= $this->M_report->GetReport3($date1,$date2);
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

		$pelatihan 	= $this->input->POST('pelatihan');
		$date 		= $this->input->POST('date');
		$trainer	= $this->input->POST('trainer');
		$tgl1		= '';
		$tgl2		= '';
		$tgl_now 	= '';

		$data['attendant'] 				= $this->M_report->GetAttendant();
		$data['trainer']				= $this->M_report->GetTrainerQue($trainer = FALSE);
		$schedule 						= $this->M_report->GetSchName_QuesName($pelatihan = FALSE, $date = FALSE, $tgl1 = FALSE, $tgl2=FALSE, $tgl_now=FALSE);
		$data['GetSchName_QuesName'] 	= $schedule;
		$segment						= $this->M_report->GetSchName_QuesName_segmen();
		$statement						= $this->M_report->GetStatement();
		$nilai 							= $this->M_report->GetSheetAll();

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
					//CEK PERHITUNGAN
					// echo "<pre>";
					// print_r($total_nilai);
					
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
					// print_r($t_rerata);
					// echo "</pre>";
					// print_r($t_nilai);
					// exit();
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['GetSchName_QuesName_detail'] = $this->M_report->GetSchName_QuesName_detail($id,$qe);
		$data['GetQuestParticipant'] = $this->M_report->GetQuestParticipant($id);

		$data['sheet'] = $this->M_report->GetSheet($id,$qe);
		$data['segment'] 		= $this->M_report->GetQuestionnaireSegmentId($id,$qe);
		$data['segmentessay'] 	= $this->M_inputquestionnaire->GetQuestionnaireSegmentEssayId($qe);
		$data['statement'] 		= $this->M_inputquestionnaire->GetQuestionnaireStatementId($qe);

		// echo "<pre>";
		// print_r($data['sheet']);
		// echo "</pre>";
		// exit();

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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

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

	//HALAMAN CUSTOM REPORT
	public function reportbycustom(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Custom Report';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/ReportByCustom/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

// HALAMAN PROSES CUSTOM REPORT
	public function prosesCustomReport()
	{
		// PARAMETER---------------------------------------------------------------------------------------------------------
		$judul			= $this->input->post('nama');
		$tgl_now		= date("m/d/Y");
		$tgl 			= $this->input->post('tanggal_custom_report');
			$ambil_tgl	= explode('-', $tgl);
				$tgl1 	= trim($ambil_tgl[0]);
				$tgl2 	= trim($ambil_tgl[1]);
							if ($tgl1==$tgl_now && $tgl2==$tgl_now) {
								$tgl1='';
								$tgl2='';
							}
		$seksi 			= $this->input->post('slcReportSection');
		$unit 			= $this->input->post('slcReportUnit');
		$dept 			= $this->input->post('slcReportDepartemen');
		$trainer_get	= $this->input->post('slcReportTrainer');
		$no_namapkj		= $this->input->post('slcReportEmployee');
			$namapkj	= trim($no_namapkj);


		// DATA YANG DIPILIH (CHECKBOX)------------------------------------------------------------------------------------
		// $data['chk_nama_pekerja']	= $this->input->post('chk_nama_pekerja');
		// $data['chk_nomor_induk']	= $this->input->post('chk_nomor_induk');
		// $data['chk_seksi']		= $this->input->post('chk_seksi');
		// $data['chk_unit'] 			= $this->input->post('chk_unit');
		// $data['chk_departemen'] 	= $this->input->post('chk_departemen');
		// $data['chk_nama_pelatihan'] = $this->input->post('chk_nama_pelatihan');
		// $data['chk_tanggal'] 		= $this->input->post('chk_tanggal');

		// $data['chk_trainer'] 		= $this->input->post('chk_trainer');
		$data['chk_eval_pembelajaran'] 	= $this->input->post('chk_eval_pembelajaran');
		$data['chk_eval_perilaku'] = $this->input->post('chk_eval_perilaku');
		
		$data['chk_eval_reaksi1']	= $this->input->post('chk_eval_reaksi1');
		$data['chk_eval_reaksi2']	= $this->input->post('chk_eval_reaksi2');
		$data['chk_eval_reaksi3']	= $this->input->post('chk_eval_reaksi3');
		$data['chk_eval_reaksi4']	= $this->input->post('chk_eval_reaksi4');

		$data['Nama_Pe_report'] = $this->input->post('txt_Nama_Pe_report');
		$data['Jabatan_Pe_report'] = $this->input->post('txt_Jabatan_Pe_report');

		// SEARCH DATA DAN TRAINER---------------------------------------------------------------------------------------
		$search = $this->M_report->GetReportCustom($judul,$tgl1,$tgl2,$seksi,$unit,$dept,$trainer_get,$namapkj);
		$data['search'] = $search;
		$data['trainer'] = $this->M_mastertrainer->GetTrainer();

		// KHUSUS PELATIHAN-----------------------------------------------------------------------------------------------
			// menyamakan variabel:
			$pelatihan 	= $judul;
			$date 		= '';
			$trainer 	= $trainer_get;
			// ---------------------------------------

			$schedule = $this->M_report->GetSchName_QuesName($pelatihan, $date = FALSE, $trainer, $tgl1 , $tgl2, $tgl_now);
			$data['GetSchName_QuesName'] = $schedule;

			$segment = $this->M_report->GetSchName_QuesName_segmen();
			$statement= $this->M_report->GetStatement();
			$nilai = $this->M_report->GetSheetAll();

			// ATTENDANT
			$data['attendant'] 	= $this->M_report->GetAttendant();

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

		
		// CETAK KE PDF------------------------------------------------------------------------------------------------------
		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'F4-L', 8, '', 5, 5, 55, 15, 10, 20);
		$filename = 'Rekapan_Report.pdf';

		if ($data['chk_eval_reaksi1']==TRUE) {
			$html = $this->load->view('ADMPelatihan/Report/ReportByCustom/V_Custom_Report_Khusus_pdf', $data, true);
		}
		else{
			$html = $this->load->view('ADMPelatihan/Report/ReportByCustom/V_Custom_Report_pdf', $data, true);
		}

		$pdf->SetHTMLHeader('
			<table style="width:100%;border: 1px solid black; padding: 0px">
			    <tr>
			    	<td style="width: 110px;height: 100px;border-right: 1px solid black" rowspan="7">
			    		<img style="height: 100px; width: 110px" src="'.base_url('/assets/img/logo.png').'" />
			        </td>
			        <td rowspan="5" style="text-align: center; width: 700px">
			        	<h3 style="margin-bottom: 0; padding-bottom: 0;font-size: 21px;">
			                FORM <br> LAPORAN HASIL TRAINING 
			            </h3>
			        </td>
			        <td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Document No.</td>
			        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"></td>
			    </tr>
			    <tr>
			    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Rev No.</td>
			        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"></td>
			    </tr>
			    <tr>
			    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Rev Date.</td>
			        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"></td>
			    </tr>
			    <tr>
			    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Page No.</td>
			        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"></td>
			       {PAGENO}/{nb}
			    </tr>
			    <tr>
			    	<td style="width: 100px;border-left: 1px solid black;padding-left: 5px; font-size: 13px;">Rev Note.</td>
			        <td style="width: 150px;border-left: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2">-</td>
			    </tr>
			    <tr>
			    	<td colspan="7" rowspan="2" style="border-top: 1px solid black;text-align: center; margin-bottom: 0; padding: 3;">
			    		<div style=" font-size: 15px;">
			    			CV KARYA HIDUP SENTOSA
			    		</div> 
			    		<div style="font-size: 14px;">
			    			Jl. Magelang No. 144 Yogyakarta
			    		</div>
			    	</td>
			    </tr>
			    <tr>
			    	<td>
			    	</td>
			    </tr>
			</table>
		');
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	//HALAMAN INDEX CREATE REPORT
	public function createReport(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Create Report Index';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}

		$data['trainer'] = $this->M_mastertrainer->GetTrainer();
		$data['report']=$this->M_report->getFilledReport();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/Report/CreateReport/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//HALAMAN CREATE REPORT
	public function createReport_fill(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Create Report';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		
		// $nama  		= 'ICT_TRIAL';
		// $tanggal  	= '04-07-2018';
		// $idNama		= '1';
		// $idTanggal	= '1';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);		
		$this->load->view('ADMPelatihan/Report/CreateReport/V_Create',$data);
		// $this->load->view('ADMPelatihan/Report/CreateReport/V_table1',$data);
		$this->load->view('V_Footer',$data);
	}
	//HALAMAN EDIT CREATE REPORT
	public function editReport($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Edit Report';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
		$data['trainer'] = $this->M_mastertrainer->GetTrainer();
		$data['report']=$this->M_report->getFilledReportEdit($id);
		$data['reg_paket']=$data['report'][0]['reg_paket'];

		$id=$data['report'][0]['scheduling_id'];
		$pid=$data['report'][0]['package_scheduling_id'];

		$segment	= $this->M_report->GetSchName_QuesName_segmen();
		$statement	= $this->M_report->GetStatement();
		$nilai 		= $this->M_report->GetSheetAll();
		
		$data['sheet_all'] = '';
		$data['GetSchName_QuesName_segmen'] = $segment;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		// $this->load->view('ADMPelatihan/Report/CreateReport/V_Edit',$data);
		if ($data['reg_paket']==0) {
			$data['peserta_regular']=$this->M_report->Getpeserta($id);
			$data['participant']=  $this->M_report->GetParticipantPelatihan($id);
			$data['participant_reg'] = $this->M_record->GetParticipantId($id);

			$schedule = $this->M_report->GetSchName_QuesName_RPT($id);
			$data['GetSchName_QuesName_RPT']= $schedule;
			
			$t_nilai = array();
			$x = 0;
			foreach ($schedule as $sch) {
				foreach ($segment as $key => $value) {
					if ($sch['scheduling_id']==$value['scheduling_id'] && $sch['questionnaire_id']==$value['questionnaire_id']) {

						$total_nilai=array();
						$nid = 0;
						$tot_p = 0;
						$tot_s = 0;
						$tot_p_checkpoint = 0;

						foreach ($statement as $st) {

							if ($value['segment_id']==$st['segment_id'] && $value['questionnaire_id']==$st['questionnaire_id']) 
							{
								$a_tot = 0;
								$temp_tkomen_parent = array();
								foreach ($nilai as $index => $score) 
								{								
									if ($value['scheduling_id']==$score['scheduling_id'] && $st['questionnaire_id']==$score['questionnaire_id'] && $st['segment_id']==$score['segment_id']) 
									{
										$a=explode('||', $score['join_input']);
										$b=explode('||', $score['join_statement_id']);
										$c=explode('||', $score['join_segment_type']);
										$ty=0;
										foreach ($b as $bi => $bb) 
										{
											if ($c[$ty++]==1) 
											{
												if ($bb==$st['statement_id']) 
												{
													$a_tot+=$a[$bi];
													if ($tot_p_checkpoint == 0) 
													{
														$tot_p++;
													}
												}
											}
										}
										foreach ($c as $ci => $cc) 
										{
											if ($a[$ci]!='1' && $a[$ci]!='2' && $a[$ci]!='3' && $a[$ci]!='4' && $a[$ci]!=NULL) 
											{
												$nol=$a[$ci];
												array_push($temp_tkomen_parent, $nol);
											}
										}
									}
								}
								$data['komen']= $temp_tkomen_parent;

								$total_nilai[$nid++] = array(
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

						if ($final_total!='0') 
						{
							$t_rerata=$final_total/($tot_s*$tot_p);
						}else
						{
							$t_rerata="-";
						}

						$t_nilai[$x++]= array(
							'scheduling_id'		=> $value['scheduling_id'], 
							'questionnaire_id'	=> $value['questionnaire_id'], 
							'segment_id'		=> $value['segment_id'], 
							'f_total'			=> $final_total, 
							'f_rata'			=> $t_rerata,
							'segment_description'=> $value['segment_description']  
						);
					}
				}
			}
			$data['t_nilai']= $t_nilai;	
			$this->load->view('ADMPelatihan/Report/CreateReport/V_Edit',$data);

		}
		elseif ($data['reg_paket']==1) {
			$data['peserta_paket']=$this->M_report->GetPsrtPaket($pid);
			$data['participant_pck']=  $this->M_report->GetPrtHadir($pid);

			$data['countPel']= $this->M_report->countPelatihan($pid);
			$jmlrowPck= $data['countPel'][0]['jml_pel'];
			$data['jmlrowPck']=$jmlrowPck;

			$schedulepck =$this->M_report->GetSchName_QuesName_RPTPCK($pid);
			$data['GetSchName_QuesName_RPTPCK']= $schedulepck;

			$data['participantName'] = $this->M_record->GetParticipantPidName($pid);
			$data['participant'] = $this->M_record->GetParticipantPid($pid);

			$data['justSegmentPck']	= $this->M_report->justSegmentPck($pid);
			$data['GetQueIdReportPaket']	= $this->M_report->GetQueIdReportPaket($pid);
			$data['countPel']= $this->M_report->countPelatihan($pid);
			$jmlrowPck= $data['countPel'][0]['jml_pel'];
			$data['jmlrowPck']=$jmlrowPck;

			$t_nilai = array();
			$temp_kom =array();
			$x = 0;
			foreach ($schedulepck as $scpck) {
				$cek_komen_parent = 0;
				foreach ($segment as $key => $value) {
					if ($scpck['scheduling_id']==$value['scheduling_id'] && $scpck['questionnaire_id']==$value['questionnaire_id']) {
						$total_nilai=array();
						$nid = 0;
						$tot_p = 0;
						$tot_s = 0;
						$tot_p_checkpoint = 0;
						$cek_komen=0;
						$chk_komen=0;

						foreach ($statement as $st) {

							if ($value['segment_id']==$st['segment_id'] && $value['questionnaire_id']==$st['questionnaire_id']) {
								$a_tot = 0;
								$komentar= 0;
								foreach ($nilai as $index => $score) {								
									if ($value['scheduling_id']==$score['scheduling_id'] && $st['questionnaire_id']==$score['questionnaire_id'] && $st['segment_id']==$score['segment_id']) {
										$a=explode('||', $score['join_input']);
										$b=explode('||', $score['join_statement_id']);
										$c=explode('||', $score['join_segment_type']);
										foreach ($b as $bi => $bb) 
										{
											if ($bb==$st['statement_id']) 
											{
												$a_tot+=$a[$bi];
												if ($tot_p_checkpoint == 0) 
												{
													$tot_p++;
												}
											}
										}
										foreach ($c as $ci => $cc) 
										{
											if ($cc=='0' && $cek_komen==0 && $a[$ci]!=NULL  && $cek_komen_parent==0) 
											{
												$nol=$a[$ci];
												$temp_kom[]	=	$nol;
											}
										}
									}
								}

								if ( count($temp_kom)>0 && $chk_komen==0)
								{
									$chk_komen++;
								}

								$total_nilai[$nid++] = array(
									'segment_id' => $st['segment_id'], 
									'statement_id' => $st['statement_id'], 
									'total' => $a_tot							
								);
								$tot_s++;
								$tot_p_checkpoint = 1;
								$cek_komen = 1;
							}
						}
						$final_total=0;
						foreach ($total_nilai as $n => $tn) {
							$final_total+=$tn['total'];
						}
						if ($final_total>0) {
							$t_rerata=$final_total/($tot_s*$tot_p);
						}

						$t_nilai[$x++]= array(
							'scheduling_id'		=> $value['scheduling_id'], 
							'questionnaire_id'	=> $value['questionnaire_id'], 
							'segment_id'		=> $value['segment_id'], 
							'f_total'			=> $final_total, 
							'f_rata'			=> $t_rerata,
							'segment_description'=> $value['segment_description'],
						);
						
						$cek_komen_parent = 1;
						
					}
				}
			}
			$data['t_nilai']= $t_nilai;
			$data['komen']= $temp_kom;
			$this->load->view('ADMPelatihan/Report/CreateReport/V_Edit_Paket',$data);
		}
		$this->load->view('V_Footer',$data);
	}

	public function AddReport()
	{	
		//ADD REPORT
		$reg_paket		= $this->input->post('txtKategoriPelatihan');
		$nama 			= $this->input->post('nama');
		$tanggal		= $this->input->post('tanggal');
		$package_scheduling_id 	= $this->input->post('txtPckSchId');
		if ($reg_paket == 0) {
			$scheduling_id = $this->input->post('txtSchId'); 
		}elseif ($reg_paket == 1) {
			$txtschid 		= $this->input->post('txtSchId[]');
			$scheduling_id 	= implode(',', $txtschid);
		}
		$jenis	 		= $this->input->post('slcJenisPelatihan');
		$total_psrt		= $this->input->post('txtPesertaPelatihan');
		$hadir_psrt		= $this->input->post('txtPesertaHadir');

		$pelaksana		= $this->input->post('idtrainerOnly');
		$indexm 		= $this->input->post('txtIndexMateri');
		$descr 			= $this->input->post('txtdeskripsi');
		$kendala		= $this->input->post('txtkendala');
		$catatan		= $this->input->post('textcatatan');
		
		$doc_no			= $this->input->post('txtDocNo');
		$rev_no			= $this->input->post('txtRevNo');
		$rev_date		= $this->input->post('txtRevDate');
		$rev_note		= $this->input->post('txtRevNote');
		$tmptdoc		= $this->input->post('txtTempat');
		$tgldoc			= $this->input->post('txtTglDibuat');
		$nama_acc		= $this->input->post('txtNamaACC');
		$jabatan_acc	= $this->input->post('txtJabatanACC');
		// if ($rev_date==NULL) {
		// 	$rev_date='';
		// }
		$this->M_report->AddReport($nama,$tanggal,$package_scheduling_id, $scheduling_id, $jenis, $indexm, $descr, $kendala, $catatan, $doc_no, $rev_no, $rev_date, $rev_note, $tmptdoc, $tgldoc, $nama_acc, $jabatan_acc, $pelaksana, $reg_paket, $total_psrt, $hadir_psrt);

		redirect('ADMPelatihan/Report/CreateReport');
	}

	public function UpdateReport()
	{	
		// AMBIL DATA
		$id 			= $this->input->post('idReport');
		$data['report'] = $this->M_report->getFilledReportEdit($id);
		$nama 			= $this->input->post('txtNamaPelatihan');
		$tanggal		= $this->input->post('txtTanggalPelaksanaan');
		$idNama			= $data['report'][0]['reg_paket'];
		$idTanggal		= $data['report'][0]['reg_paket'];

		//ADD REPORT	
		$jenis	 		= $this->input->post('slcJenisPelatihan');
		$total_psrt		= $this->input->post('txtPesertaPelatihan');
		$hadir_psrt		= $this->input->post('txtPesertaHadir');

		// TRAINER---------------------------------------------------------------------------------------------------------
		$trainer			=$this->input->post('txtPelaksana[]');

		// ambil trainer dari penjadwalan langsung(untuk mengetahui urutan trainer per jadwal)
		$GetDataPelatihan	= $this->M_report->GetDataPelatihan($nama,$tanggal,$idNama,$idTanggal);
		$train_array =array();
			foreach ($GetDataPelatihan as $dp) {
				for ($i=0; $i < count($GetDataPelatihan); $i++) { 
					$idtrainer = explode(',', $dp['trainer']);
				}
				array_push($train_array, $idtrainer[0]);
			}

		// hapus duplicate id
		$train_array_unique= array_unique($train_array);

		//cek apakah ada penggantian nama trainer
		if (isset($trainer) == $train_array_unique && count($trainer) == count($train_array_unique)) {
			$pelaksana = implode(',', $train_array_unique);
		}else{
			$pelaksana = implode(',', $trainer);
		}
		// ----------------------------------------------------------------------------------------------------------

		$indexm 		= $this->input->post('txtIndexMateri');
		$descr 			= $this->input->post('txtdeskripsi');
		$kendala		= $this->input->post('txtkendala');
		$catatan		= $this->input->post('textcatatan');
		
		$doc_no			= $this->input->post('txtDocNo');
		$rev_no			= $this->input->post('txtRevNo');
		$rev_date		= $this->input->post('txtRevDate');
		$rev_note		= $this->input->post('txtRevNote');
		$tmptdoc		= $this->input->post('txtTempat');
		$tgldoc			= $this->input->post('txtTglDibuat');
		$nama_acc		= $this->input->post('txtNamaACC');
		$jabatan_acc	= $this->input->post('txtJabatanACC');

		$this->M_report->UpdateReport($id, $jenis, $total_psrt, $hadir_psrt, $indexm, $descr, $kendala, $catatan, $doc_no, $rev_no, $rev_date, $rev_note, $tmptdoc, $tgldoc, $nama_acc, $jabatan_acc, $pelaksana);

		redirect('ADMPelatihan/Report/CreateReport');
	}

	//MENGHAPUS REPORT DARI DATABASE
	public function deleteReport($id){
		$this->M_report->deleteReport($id);
		redirect('ADMPelatihan/Report/CreateReport');
	}
	// public function delete_reaksi($report_id,$ideval)
	// {		
	// 	$delete = $this->M_report->delete_reaksi($report_id,$ideval);
	// }
	// public function delete_pembelajaran($report_id,$ideval)
	// {		
	// 	$delete = $this->M_report->delete_pembelajaran($report_id,$ideval);
	// }

	//CETAK PDF UNTUK REPORT
	public function cetakPDF($id)
    {	
		$data['id'] = $id;
		$data['report']=$this->M_report->getFilledReportEdit($id);
		$rev_no=$data['report'][0]['rev_no'];
		$no_doc=$data['report'][0]['doc_no'];
		$rev_note=$data['report'][0]['rev_note'];
		$rev_date=$data['report'][0]['rev_date'];

		// newdate
		$date=$rev_date; 
			$newDate=date("d M Y", strtotime($date));
			$nulldate=$rev_date;
			$tanggal_revisi='';
			if ($nulldate=='0001-01-01 BC' || $nulldate=='0001-01-01' || $nulldate=='1970-01-01' || $nulldate=='01 Jan 1970') {
				$rev_date=$tanggal_revisi;
				echo $tanggal_revisi;
			}else{
				echo $tanggal_revisi=$newDate;
			}
		// ------------------------------------------------------------------------------------------------------------------------

		//batasan deskripsi
		$kata_array = explode(' ', $data['report'][0]['description']);
		$jumlahkata = count($kata_array);
		$table1= array();
		$table2= array();
		$table3= array();
		for ($i=0; $i < $jumlahkata; $i++) { 	
			if ($i<440) {
				array_push($table1, $kata_array[$i]);
			}elseif ($i>=440 && $i<900) {
				array_push($table2, $kata_array[$i]);
			}
			elseif($i>=900){
				array_push($table3, $kata_array[$i]);
			}
		}
		
		// satukan kata dalam array 
		$t1 = implode(' ', $table1);
		$t2 = implode(' ', $table2);
		$t3 = implode(' ', $table3);

		$data['panjang_desc'] = $t1;
		$data['panjang_desc2'] = $t2;
		$data['panjang_desc3'] = $t3;
		
		// $data['panjang_desc'] = substr($data['report'][0]['description'], 0, 3307);
		// $data['panjang_desc2'] = substr($data['report'][0]['description'], 3307, 7000);
		// $data['panjang_desc3'] = substr($data['report'][0]['description'], 6000);
		// ------------------------------------------------------------------------------
		$report=$data['report'];
		$data['reg_paket']=$data['report'][0]['reg_paket'];
		$sid=$data['report'][0]['scheduling_id'];
		$pid=$data['report'][0]['package_scheduling_id'];
		
		$data['trainer'] = $this->M_mastertrainer->GetTrainer();
		$data['countTrainer']=$this->M_report->countTrainer($id);
		$jmlrow=$data['countTrainer'][0]['max'];
		$data['jmlrowTrainer']=$jmlrow;

		$segment	= $this->M_report->GetSchName_QuesName_segmen();
		$statement	= $this->M_report->GetStatement();
		$nilai 		= $this->M_report->GetSheetAll();
		
		$data['sheet_all'] = '';
		$data['GetSchName_QuesName_segmen'] = $segment;

    	$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 50, 15, 10, 0, 'P');
		$filename = 'Report-Pelatihan.pdf';
		$pdf->SetHTMLHeader('
			<table style="width:100%;border: 1px solid black; padding: 0px">
			    <tr>
			    	<td style="width: 110px;height: 100px;border-right: 1px solid black" rowspan="7">
			    		<img style="height: 100px; width: 110px" src="'.base_url('/assets/img/logo.png').'" />
			        </td>
			        <td rowspan="5" style="text-align: center; width: 400px">
			        	<h3 style="margin-bottom: 0; padding-bottom: 0;font-size: 21px;">
			                FORM <br> LAPORAN HASIL TRAINING 
			            </h3>
			        </td>
			        <td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Document No.</td>
			        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2">'.$no_doc.'</td>
			    </tr>
			    <tr>
			    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Rev No.</td>
			        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2">'.$rev_no.'</td>
			    </tr>
			    <tr>
			    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Rev Date.</td>
			        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2">'.$tanggal_revisi.'</td>
			    </tr>
			    <tr>
			    	<td style="width: 100px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;">Page No.</td>
			        <td style="width: 150px;border-left: 1px solid black;border-bottom: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2"></td>
			       {PAGENO}/{nb}
			    </tr>
			    <tr>
			    	<td style="width: 100px;border-left: 1px solid black;padding-left: 5px; font-size: 13px;">Rev Note.</td>
			        <td style="width: 150px;border-left: 1px solid black;padding-left: 5px; font-size: 13px;" colspan="2">-</td>
			    </tr>
			    <tr>
			    	<td colspan="7" rowspan="2" style="border-top: 1px solid black;text-align: center; margin-bottom: 0; padding: 3;">
			    		<div style=" font-size: 15px;">
			    			CV KARYA HIDUP SENTOSA
			    		</div> 
			    		<div style="font-size: 14px;">
			    			Jl. Magelang No. 144 Yogyakarta
			    		</div>
			    	</td>
			    </tr>
			    <tr>
			    	<td>
			    	</td>
			    </tr>
			</table>
		');
		if ($data['reg_paket']==0) {
			//hitung segmen untuk baris
			$countSegment=$this->M_report->countSegment($sid);
			$data['countSegment']= count($countSegment);

			$data['participant_reg'] = $this->M_record->GetParticipantId($sid);
			//hitung peserta untuk baris
			$data['countPeserta']= count($data['participant_reg']);
			
			$schedule = $this->M_report->GetSchName_QuesName_RPT($sid);
			$data['GetSchName_QuesName_RPT']= $schedule;

			$t_nilai = array();
			$x = 0;
			foreach ($schedule as $sch) {
				foreach ($segment as $key => $value) {
					if ($sch['scheduling_id']==$value['scheduling_id'] && $sch['questionnaire_id']==$value['questionnaire_id']) {

						$total_nilai=array();
						$nid = 0;
						$tot_p = 0;
						$tot_s = 0;
						$tot_p_checkpoint = 0;

						foreach ($statement as $st) {

							if ($value['segment_id']==$st['segment_id'] && $value['questionnaire_id']==$st['questionnaire_id']) 
							{
								$a_tot = 0;
								$temp_tkomen_parent = array();
								foreach ($nilai as $index => $score) 
								{								
									if ($value['scheduling_id']==$score['scheduling_id'] && $st['questionnaire_id']==$score['questionnaire_id'] && $st['segment_id']==$score['segment_id']) 
									{
										$a=explode('||', $score['join_input']);
										$b=explode('||', $score['join_statement_id']);
										$c=explode('||', $score['join_segment_type']);
										$ty=0;
										foreach ($b as $bi => $bb) 
										{
											if ($c[$ty++]==1) 
											{
												if ($bb==$st['statement_id']) 
												{
													$a_tot+=$a[$bi];
													if ($tot_p_checkpoint == 0) 
													{
														$tot_p++;
													}
												}
											}
										}
										foreach ($c as $ci => $cc) 
										{
											if ($a[$ci]!='1' && $a[$ci]!='2' && $a[$ci]!='3' && $a[$ci]!='4' && $a[$ci]!=NULL) 
											{
												$nol=$a[$ci];
												array_push($temp_tkomen_parent, $nol);
											}
										}
									}
								}
								$data['komen']= $temp_tkomen_parent;

								$total_nilai[$nid++] = array(
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

						if ($final_total!='0') 
						{
							$t_rerata=$final_total/($tot_s*$tot_p);
						}else
						{
							$t_rerata="-";
						}

						$t_nilai[$x++]= array(
							'scheduling_id'		=> $value['scheduling_id'], 
							'questionnaire_id'	=> $value['questionnaire_id'], 
							'segment_id'		=> $value['segment_id'], 
							'f_total'			=> $final_total, 
							'f_rata'			=> $t_rerata,
							'segment_description'=> $value['segment_description']  
						);
					}
				}
			}
			$data['t_nilai']= $t_nilai;		
			$html = $this->load->view('ADMPelatihan/Report/CreateReport/V_Pdf', $data, true);

		}elseif ($data['reg_paket']==1) {
			$data['countPel']= $this->M_report->countPelatihan($pid);
			$jmlrowPck= $data['countPel'][0]['jml_pel'];
			$data['jmlrowPck']=$jmlrowPck;

			$schedulepck =$this->M_report->GetSchName_QuesName_RPTPCK($pid);
			$data['GetSchName_QuesName_RPTPCK']= $schedulepck;

			//hitung segmen untuk baris
			$countSegmentPck=$this->M_report->countSegmentPck($pid);
			$data['countSegmentPck']= count($countSegmentPck);

			$data['participantName'] = $this->M_record->GetParticipantPidName($pid);
			$data['participant'] = $this->M_record->GetParticipantPid($pid);
			$data['countPesertaPkt'] = count($data['participantName']);

			//hitung segmen untuk baris
			$data['justSegmentPck']	= $this->M_report->justSegmentPck($pid);
			$data['GetQueIdReportPaket']	= $this->M_report->GetQueIdReportPaket($pid);
			$data['countPel']= $this->M_report->countPelatihan($pid);
			$jmlrowPck= $data['countPel'][0]['jml_pel'];
			$data['jmlrowPck']=$jmlrowPck;
			
			$t_nilai = array();
			$temp_kom =array();
			$x = 0;
			foreach ($schedulepck as $scpck) {
				$cek_komen_parent = 0;
				foreach ($segment as $key => $value) {
					if ($scpck['scheduling_id']==$value['scheduling_id'] && $scpck['questionnaire_id']==$value['questionnaire_id']) {
						$total_nilai=array();
						$nid = 0;
						$tot_p = 0;
						$tot_s = 0;
						$tot_p_checkpoint = 0;
						$cek_komen=0;
						$chk_komen=0;

						foreach ($statement as $st) {

							if ($value['segment_id']==$st['segment_id'] && $value['questionnaire_id']==$st['questionnaire_id']) {
								$a_tot = 0;
								$komentar= 0;
								foreach ($nilai as $index => $score) {								
									if ($value['scheduling_id']==$score['scheduling_id'] && $st['questionnaire_id']==$score['questionnaire_id'] && $st['segment_id']==$score['segment_id']) {
										$a=explode('||', $score['join_input']);
										$b=explode('||', $score['join_statement_id']);
										$c=explode('||', $score['join_segment_type']);
										foreach ($b as $bi => $bb) 
										{
											if ($bb==$st['statement_id']) 
											{
												$a_tot+=$a[$bi];
												if ($tot_p_checkpoint == 0) 
												{
													$tot_p++;
												}
											}
										}
										foreach ($c as $ci => $cc) 
										{
											if ($cc=='0' && $cek_komen==0 && $a[$ci]!=NULL  && $cek_komen_parent==0) 
											{
												$nol=$a[$ci];
												$temp_kom[]	=	$nol;
											}
										}
									}
								}

								if ( count($temp_kom)>0 && $chk_komen==0)
								{
									$chk_komen++;
								}

								$total_nilai[$nid++] = array(
									'segment_id' => $st['segment_id'], 
									'statement_id' => $st['statement_id'], 
									'total' => $a_tot							
								);
								$tot_s++;
								$tot_p_checkpoint = 1;
								$cek_komen = 1;
							}
						}
						$final_total=0;
						foreach ($total_nilai as $n => $tn) {
							$final_total+=$tn['total'];
						}
						if ($final_total>0) {
							$t_rerata=$final_total/($tot_s*$tot_p);
						}

						$t_nilai[$x++]= array(
							'scheduling_id'		=> $value['scheduling_id'], 
							'questionnaire_id'	=> $value['questionnaire_id'], 
							'segment_id'		=> $value['segment_id'], 
							'f_total'			=> $final_total, 
							'f_rata'			=> $t_rerata,
							'segment_description'=> $value['segment_description'],
						);
						
						$cek_komen_parent = 1;
						
					}
				}
			}
			$data['t_nilai']= $t_nilai;
			$data['komen']= $temp_kom;
			$html = $this->load->view('ADMPelatihan/Report/CreateReport/V_Pdf_Paket', $data, true);
		}
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
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

	public function GetPelatihan()
	{
		$term = $this->input->get("term");
		$data = $this->M_report->GetPelatihan($term);
		echo json_encode($data);
	}
	public function GetPelatihanNama()
	{
		$term = $this->input->get("term");
		$data = $this->M_report->GetPelatihanNama($term);
		echo json_encode($data);
	}
	public function GetPelatihanPaket()
	{
		$term = $this->input->get("term");
		$data = $this->M_report->GetPelatihanPaket($term);
		echo json_encode($data);
	}
	public function GetPelatihanPaketNama()
	{
		$term = $this->input->get("term");
		$data = $this->M_report->GetPelatihanPaketNama($term);
		echo json_encode($data);
	}
	// CREATE REPORT======================================================================================================
	public function GetDataPelatihan()
	{
		$nama  		= $this->input->POST('nama');
		$tanggal  	= $this->input->POST('tanggal');
		$idNama		= $this->input->POST('idNama');
		$idTanggal	= $this->input->POST('idTanggal');			
		if ($idNama==0) {
			$GetDataPelatihan	= $this->M_report->GetDataPelatihan($nama,$tanggal,$idNama,$idTanggal);
			$data['GetDataPelatihan']=$GetDataPelatihan;
			$id=$GetDataPelatihan[0]['scheduling_id'];
			$participant=  $this->M_report->GetParticipantPelatihan($id);
			$data['participant'] = $participant;
			$trainer = $this->M_record->GetTrainer();
			$data['trainer'] = $trainer; 
			
			// AMBIL JUMLAH PARTISIPAN DAN TRAINER -----------------------------------------------------------------------------
			foreach ($GetDataPelatihan as $dp) {
				$data['participant_number']= $dp['participant_number'];
				$idtrainer = explode(',', $dp['trainer']);
				$data['idTrainer']=$idtrainer;
				$data['pel']=array();
				foreach($trainer as $tr){
					if ($tr['trainer_id'] == $idtrainer) {
						array_push($data['pel'], $tr['trainer_name']);
					}
				}
			}
			// JUMLAH HADIR-----------------------------------------------------------------------------------------------------
			foreach ($participant as $prtcp) {
				$data['jumlah']= $prtcp['jumlah'];
			}
		}else {
			$GetDataPelatihan	= $this->M_report->GetDataPelatihan($nama,$tanggal,$idNama,$idTanggal);
			$data['GetDataPelatihan']=$GetDataPelatihan;
			$pid=$GetDataPelatihan[0]['package_scheduling_id'];
			$participant=  $this->M_report->GetPrtHadir($pid);
			$data['participant'] = $participant;

			// AMBIL JUMLAH PARTISIPAN DAN TRAINER -----------------------------------------------------------------------------
			// foreach ($GetDataPelatihan as $dpk) {
			// 	$data['participant_number']= $dpk['participant_number'];
			// }
			$data['participantName'] = $this->M_record->GetParticipantPidName($pid);
			$data['participant_number'] = count($data['participantName']);
			// 1
			$tampung_trainer= array();
			foreach ($GetDataPelatihan as $gpk) {
				array_push($tampung_trainer, $gpk['trainer']);
				$data['trainer_onpkg']=$tampung_trainer;
			}
			$trainer_akhir=$data['trainer_onpkg'];
			
			// 2
			$trainer = $this->M_report->GetTrainer();
			$data['trainer'] = $trainer; 

			// 3
			$trainer_fix=array();
			foreach ($trainer as $tr) {
				if (in_array($tr['trainer_id'], $trainer_akhir)) {
					array_push($trainer_fix, trim($tr['trainer_name'],"  "));
					$data['trainer_fix']=$trainer_fix;
				}
			}
			// JUMLAH HADIR-----------------------------------------------------------------------------------------------------
			foreach ($participant as $prtcp) {
				$data['jumlah']= $prtcp['jumlah'];
			}
		}
		echo json_encode($data);
	}

	public function GetTabelReaksi()
	{
		$nama  		= $this->input->POST('nama');
		$tanggal  	= $this->input->POST('tanggal');
		$idNama		= $this->input->POST('idNama');
		$idTanggal	= $this->input->POST('idTanggal');
		// -----------------------------------------------------------------------------------------------------------------ambil id pelatihan
		$GetDataPelatihan	= $this->M_report->GetDataPelatihan($nama,$tanggal,$idNama,$idTanggal);
		$data['GetDataPelatihan']=$GetDataPelatihan;
		$id=$GetDataPelatihan[0]['scheduling_id'];
		$pid=$GetDataPelatihan[0]['package_scheduling_id'];

		// ------------------------------------------------------------------------------------------------------------------
		if ($idNama==1) {
			$schedulepck =$this->M_report->GetSchName_QuesName_RPTPCK($pid);
			$data['GetSchName_QuesName_RPTPCK']= $schedulepck;
		}elseif ($idNama==0) {
			$schedule = $this->M_report->GetSchName_QuesName_RPT($id);
			$data['GetSchName_QuesName_RPT']= $schedule;
		}
		$segment						= $this->M_report->GetSchName_QuesName_segmen();
		$statement						= $this->M_report->GetStatement();
		$nilai 							= $this->M_report->GetSheetAll();

		// HITUNG TOTAL NILAI-----------------------------------------------------------------------------------------------
		if ($idNama==0) {
			$t_nilai = array();
			$x = 0;
			foreach ($schedule as $sch) {
				foreach ($segment as $key => $value) {
					if ($sch['scheduling_id']==$value['scheduling_id'] && $sch['questionnaire_id']==$value['questionnaire_id']) {

						$total_nilai=array();
						$nid = 0;
						$tot_p = 0;
						$tot_s = 0;
						$tot_p_checkpoint = 0;

						foreach ($statement as $st) {

							if ($value['segment_id']==$st['segment_id'] && $value['questionnaire_id']==$st['questionnaire_id']) 
							{
								$a_tot = 0;
								$temp_tkomen_parent = array();
								foreach ($nilai as $index => $score) 
								{								
									if ($value['scheduling_id']==$score['scheduling_id'] && $st['questionnaire_id']==$score['questionnaire_id'] && $st['segment_id']==$score['segment_id']) 
									{
										$a=explode('||', $score['join_input']);
										$b=explode('||', $score['join_statement_id']);
										$c=explode('||', $score['join_segment_type']);
										$ty=0;
										foreach ($b as $bi => $bb) 
										{
											if ($c[$ty++]==1) 
											{
												if ($bb==$st['statement_id']) 
												{
													$a_tot+=$a[$bi];
													if ($tot_p_checkpoint == 0) 
													{
														$tot_p++;
													}
												}
											}
										}
										foreach ($c as $ci => $cc) 
										{
											if ($a[$ci]!='1' && $a[$ci]!='2' && $a[$ci]!='3' && $a[$ci]!='4' && $a[$ci]!=NULL) 
											{
												$nol=$a[$ci];
												array_push($temp_tkomen_parent, $nol);
											}
										}
									}
								}
								$data['komen']= $temp_tkomen_parent;

								$total_nilai[$nid++] = array(
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

						if ($final_total!='0') 
						{
							$t_rerata=$final_total/($tot_s*$tot_p);
						}else
						{
							$t_rerata="-";
						}

						$t_nilai[$x++]= array(
							'scheduling_id'		=> $value['scheduling_id'], 
							'questionnaire_id'	=> $value['questionnaire_id'], 
							'segment_id'		=> $value['segment_id'], 
							'f_total'			=> $final_total, 
							'f_rata'			=> $t_rerata,
							'segment_description'=> $value['segment_description']  
						);
					}
				}
			}
			$data['t_nilai']= $t_nilai;		
		}
		// ----------------------------------------------------------------------------------------------------------------------
		if ($idNama==1) {
			$data['justSegmentPck']	= $this->M_report->justSegmentPck($pid);
			$data['GetQueIdReportPaket']	= $this->M_report->GetQueIdReportPaket($pid);
			$data['countPel']= $this->M_report->countPelatihan($pid);
			$jmlrowPck= $data['countPel'][0]['jml_pel'];
			$data['jmlrowPck']=$jmlrowPck;

			$t_nilai = array();
			$temp_kom =array();
			$x = 0;
			foreach ($schedulepck as $scpck) {
				$cek_komen_parent = 0;
				foreach ($segment as $key => $value) {
					if ($scpck['scheduling_id']==$value['scheduling_id'] && $scpck['questionnaire_id']==$value['questionnaire_id']) {
						$total_nilai=array();
						$nid = 0;
						$tot_p = 0;
						$tot_s = 0;
						$tot_p_checkpoint = 0;
						$cek_komen=0;
						$chk_komen=0;

						foreach ($statement as $st) {

							if ($value['segment_id']==$st['segment_id'] && $value['questionnaire_id']==$st['questionnaire_id']) {
								$a_tot = 0;
								$komentar= 0;
								foreach ($nilai as $index => $score) {								
									if ($value['scheduling_id']==$score['scheduling_id'] && $st['questionnaire_id']==$score['questionnaire_id'] && $st['segment_id']==$score['segment_id']) {
										$a=explode('||', $score['join_input']);
										$b=explode('||', $score['join_statement_id']);
										$c=explode('||', $score['join_segment_type']);
										foreach ($b as $bi => $bb) 
										{
											if ($bb==$st['statement_id']) 
											{
												$a_tot+=$a[$bi];
												if ($tot_p_checkpoint == 0) 
												{
													$tot_p++;
												}
											}
										}
										foreach ($c as $ci => $cc) 
										{
											if ($cc=='0' && $cek_komen==0 && $a[$ci]!=NULL  && $cek_komen_parent==0) 
											{
												$nol=$a[$ci];
												$temp_kom[]	=	$nol;
											}
										}
									}
								}

								if ( count($temp_kom)>0 && $chk_komen==0)
								{
									$chk_komen++;
								}

								$total_nilai[$nid++] = array(
									'segment_id' => $st['segment_id'], 
									'statement_id' => $st['statement_id'], 
									'total' => $a_tot							
								);
								$tot_s++;
								$tot_p_checkpoint = 1;
								$cek_komen = 1;
							}
						}
						$final_total=0;
						foreach ($total_nilai as $n => $tn) {
							$final_total+=$tn['total'];
						}
						if ($final_total>0) {
							$t_rerata=$final_total/($tot_s*$tot_p);
						}

						$t_nilai[$x++]= array(
							'scheduling_id'		=> $value['scheduling_id'], 
							'questionnaire_id'	=> $value['questionnaire_id'], 
							'segment_id'		=> $value['segment_id'], 
							'f_total'			=> $final_total, 
							'f_rata'			=> $t_rerata,
							'segment_description'=> $value['segment_description'],
						);
						
						$cek_komen_parent = 1;
						
					}
				}
			}
			$data['t_nilai']= $t_nilai;
			$data['komen']= $temp_kom;
		}
		// -----------------------------------------------------------------------------------------------------------------
		$data['sheet_all'] = '';
		$data['GetSchName_QuesName_segmen'] = $segment;

		// MENAMPILKAN TABEL REAKSI + KOMENTAR
		if ($idNama==0) 
		{
			$this->load->view('ADMPelatihan/Report/CreateReport/V_table',$data);
		}
		elseif ($idNama==1) 
		{
			$this->load->view('ADMPelatihan/Report/CreateReport/V_table1',$data);
		}
	}

	public function GetTabelPembelajaran()
	{
		$nama  		= $this->input->POST('nama');
		$tanggal  	= $this->input->POST('tanggal');
		$idNama		= $this->input->POST('idNama');
		$idTanggal	= $this->input->POST('idTanggal');
		$GetDataPelatihan	= $this->M_report->GetDataPelatihan($nama,$tanggal,$idNama,$idTanggal);
			$data['GetDataPelatihan']=$GetDataPelatihan;
				$id=$GetDataPelatihan[0]['scheduling_id'];
				$pid=$GetDataPelatihan[0]['package_scheduling_id'];

		if ($idNama==1) 
		{
			$data['countPel']= $this->M_report->countPelatihan($pid);
				$jmlrowPck= $data['countPel'][0]['jml_pel'];
					$data['jmlrowPck']=$jmlrowPck;

			$schedulepck =$this->M_report->GetSchName_QuesName_RPTPCK($pid);
				$data['GetSchName_QuesName_RPTPCK']= $schedulepck;
			

			$data['participantName'] = $this->M_record->GetParticipantPidName($pid);
			$data['participant'] = $this->M_record->GetParticipantPid($pid);
			$table = $this->load->view('ADMPelatihan/Report/CreateReport/V_table3',$data);
		}
		elseif ($idNama==0) 
		{
			$data['participant'] 		= $this->M_record->GetParticipantId($id);
			$ambil_standar_kelulusan 	= explode(',', $GetDataPelatihan[0]['standar_kelulusan']);
				$data['standar_kelulusan']	= $ambil_standar_kelulusan[1];
			$table = $this->load->view('ADMPelatihan/Report/CreateReport/V_table2',$data);
		}
	
		// $data['participant'] = $this->M_record->GetParticipantId($id);
		// if ($idNama==0) {
		// 	$table = $this->load->view('ADMPelatihan/Report/CreateReport/V_table2',$data);
		// }elseif ($idNama==1) {
		// 	$table = $this->load->view('ADMPelatihan/Report/CreateReport/V_table3',$data);
		// }
		return $table;
	}
	// ================================================================================================
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
	public function GetUnitFilter(){
		$term = $this->input->get("term");
		$data = $this->M_report->GetUnitFilter($term);

		echo json_encode($data);
	}
	public function GetDeptFilter(){
		$term = $this->input->get("term");
		$data = $this->M_report->GetDeptFilter($term);

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

		// ATTENDANT
		$data['attendant'] 	= $this->M_report->GetAttendant();

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

	public function GetDetailParticipant()
	{
		$schid 					= $this->input->POST('schid');
		$data['modal_part'] 	= $this->M_report->GetDetailParticipant($schid);
		$this->load->view('ADMPelatihan/Report/Rekap/PresentaseKehadiran/V_index_modal',$data);
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
		}
		
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
		foreach ($data['UserSubMenuOne'] as $key => $value) { // looping, $key ini index, $value isinya
			if ($value['menu_title'] == 'Jadwal Pelatihan' || $value['menu_title'] == 'Custom Report') { // jika menu_title = x atau y
				unset($data['UserSubMenuOne'][$key]); // unset berdasarkan index
			}
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
