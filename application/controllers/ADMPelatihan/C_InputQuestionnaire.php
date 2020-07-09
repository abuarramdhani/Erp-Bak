<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_InputQuestionnaire extends CI_Controller {

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
		$this->load->model('ADMPelatihan/M_inputquestionnaire');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = '';
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

		$data['questionnaire'] = $this->M_masterquestionnaire->GetQuestionnaire($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterQuestionnaire/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//HALAMAN CREATE TRAINER INTERNAL
	public function ToCreate($id){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = '';
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

		$data['schedule'] = $this->M_inputquestionnaire->GetSchedule($id);
		$data['GetSheet'] = $this->M_inputquestionnaire->GetSheet($id);

		$train_id = explode(',', $data['schedule'][0]['training_id']);
		$trainData = array();
		foreach ($train_id as $ti) {
			$trainData[] = $this->M_inputquestionnaire->GetTrain($ti);
		}
		
		$quesData = array();
		foreach ($trainData as $td => $value) {
			$qid = explode(',', $value[$td]['questionnaire']);
			foreach ($qid as $qd) {
				$quesData[]	= $this->M_inputquestionnaire->GetQuestionnaire($id,$qd);
			}
		}
		$data['questionnaire']	= $quesData;
		$data['training'] 		= $this->M_inputquestionnaire->GetTraining($id);
		$data['trainingid'] 	= $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/InputQuestionnaire/V_ToCreate',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN CREATE TRAINER INTERNAL
	public function Create($id,$qe){
		$this->checkSession();
		$user_id = $this->session->userid;
 
		$data['Menu'] = '';
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

		$data['SchedulingId'] 	= $id;
		$data['QuestionnaireId']= $qe;
		$data['submitted'] 		= $this->M_inputquestionnaire->GetSubmittedSheet($id,$qe);
		$data['attendant'] 		= $this->M_inputquestionnaire->GetAttendant($id);

		$data['training'] 		= $this->M_inputquestionnaire->GetTrainingId($id);
		$data['questionnaire'] 	= $this->M_inputquestionnaire->GetQuestionnaireId($qe);
		$data['segment'] 		= $this->M_inputquestionnaire->GetQuestionnaireSegmentId($qe);
		$data['segmentessay'] 	= $this->M_inputquestionnaire->GetQuestionnaireSegmentEssayId($qe);
		$data['statement'] 		= $this->M_inputquestionnaire->GetQuestionnaireStatementId($qe);
		$data['trainer'] 		= $this->M_inputquestionnaire->GetTrainer();

		foreach ($data['submitted'] as $sb){$sbm=$sb['submitted'];}
		foreach ($data['attendant'] as $tr){$participant_number=$tr['attendant'];}

		if($sbm<$participant_number){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ADMPelatihan/InputQuestionnaire/V_Create',$data);
			$this->load->view('V_Footer',$data);
		}else{
			redirect('ADMPelatihan/InputQuestionnaire/ToCreate/'.$id);
		}
	}

	public function view($id,$qe)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = '';
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

		$data['SchedulingId'] 	= $id;
		$data['QuestionnaireId']= $qe;
		$data['submitted'] 		= $this->M_inputquestionnaire->GetSubmittedSheet($id,$qe);
		$data['attendant'] 		= $this->M_inputquestionnaire->GetAttendant($id);

		$data['training'] 		= $this->M_inputquestionnaire->GetTrainingId($id);
		$data['questionnaire'] 	= $this->M_inputquestionnaire->GetQuestionnaireId($qe);
		$data['sheet']		 	= $this->M_inputquestionnaire->GetQuestionnaireSheet($id, $qe);
		$data['segment'] 		= $this->M_inputquestionnaire->GetQuestionnaireSegmentId($qe);
		$data['segmentessay'] 	= $this->M_inputquestionnaire->GetQuestionnaireSegmentEssayId($qe);
		$data['statement'] 		= $this->M_inputquestionnaire->GetQuestionnaireStatementId($qe);
		$data['trainer'] 		= $this->M_inputquestionnaire->GetTrainer();

		foreach ($data['submitted'] as $sb){$sbm=$sb['submitted'];}
		foreach ($data['attendant'] as $tr){$participant_number=$tr['attendant'];}
		
		if($sbm<$participant_number){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ADMPelatihan/InputQuestionnaire/V_View',$data);
			$this->load->view('V_Footer',$data);
		}
		elseif($sbm==$participant_number){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ADMPelatihan/InputQuestionnaire/V_View',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	//SUBMIT QUESTIONNAIRE
	public function Add(){
		$IdKuesioner	= $this->input->post('txtQuestionnaireId');
		$IdPenjadwalan	= $this->input->post('txtSchedulingId');
		$IdStatement	= $this->input->post('txtStatementId');
		$Stype			= $this->input->post('txtSegmentType');
		// $QSheetId 		= $qsi;

		foreach($IdStatement as $loop){
			$statement[] = $loop;
			$input[] = $this->input->post('txtInput'.$loop);
		}
		$join_statement 	= join('||', $statement);
		$join_input			= join('||', $input);
		$join_segment_type	= join('||', $Stype);
		
		$this->M_inputquestionnaire->AddQuestionnaireSheet($IdKuesioner,$IdPenjadwalan,$join_statement,$join_input,$join_segment_type);
		
		redirect('ADMPelatihan/InputQuestionnaire/Create/'.$IdPenjadwalan.'/'.$IdKuesioner);
	}

	public function edit($id,$qe,$qsi)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = '';
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

		$data['SchedulingId'] 	= $id;
		$data['QuestionnaireId']= $qe;
		$data['QuestionnaireSheetId']= $qsi;
		$data['submitted'] 		= $this->M_inputquestionnaire->GetSubmittedSheet($id,$qe);
		$data['attendant'] 		= $this->M_inputquestionnaire->GetAttendant($id);
		$data['training'] 		= $this->M_inputquestionnaire->GetTrainingId($id);
		$data['questionnaire'] 	= $this->M_inputquestionnaire->GetQuestionnaireId($qe);
		$data['sheetEdit']		= $this->M_inputquestionnaire->GetQuestionnaireSheetEdit($id, $qe, $qsi);
		$data['segment'] 		= $this->M_inputquestionnaire->GetQuestionnaireSegmentId($qe);
		$data['segmentessay'] 	= $this->M_inputquestionnaire->GetQuestionnaireSegmentEssayId($qe);
		$data['statement'] 		= $this->M_inputquestionnaire->GetQuestionnaireStatementId($qe);
		$data['trainer'] 		= $this->M_inputquestionnaire->GetTrainer();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/InputQuestionnaire/V_Edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update(){
		// echo "<pre>";
		// var_dump($_POST);
		// echo "</pre>";
		$IdKuesioner	= $this->input->post('txtQuestionnaireId');
		$IdPenjadwalan	= $this->input->post('txtSchedulingId');
		$IdStatement	= $this->input->post('txtStatementId');
		$IdQSheet		= $this->input->post('txtQuestionnaireSheetId');
		$Stype			= $this->input->post('txtSegmentType');
				
		foreach($IdStatement as $loop){
			$statement[] 	= $loop;
			$input[] 		= $this->input->post('txtInput'.$loop);
			$input_id[] 	= $this->input->post('txtID_st'.$loop);
		}
		$join_statement 	= join('||', $statement);
		$join_input			= join('||', $input);
		$join_input_id		= join('||', $input_id);
		$join_segment_type	= join('||', $Stype);

		$this->M_inputquestionnaire->UpdateQuestionnaireSheet($IdKuesioner,$IdPenjadwalan,$IdQSheet,$join_input,$join_input_id, $join_segment_type);
		
		redirect('ADMPelatihan/InputQuestionnaire/ToCreate/'.$IdPenjadwalan.'/'.$IdKuesioner);
	}


	public function delete($id1,$id2,$id3)
	{
		$id=$id1;
		$qe=$id2;
		$this->M_inputquestionnaire->DeleteQuestionnaireSheet($id3);
		redirect('ADMPelatihan/InputQuestionnaire/view/'.$id.'/'.$qe);
	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('');
		}
	}

	public function cetakExcel($sid,$qid)
    {
    	$this->load->library("Excel");
    	$data['questionnaire'] 	= $this->M_inputquestionnaire->GetQuestionnaireId($qid);
		$data['segment'] 		= $this->M_inputquestionnaire->GetQuestionnaireSegmentId($qid);
		$data['statement'] 		= $this->M_inputquestionnaire->GetQuestionnaireStatementId($qid);
		$data['sheet']		 	= $this->M_inputquestionnaire->GetQuestionnaireSheet($sid, $qid);
		$data['training'] 		= $this->M_inputquestionnaire->GetTrainingId($sid);
		$data['trainer'] 		= $this->M_inputquestionnaire->GetTrainer();

		$this->load->view('ADMPelatihan/InputQuestionnaire/V_Excel', $data);
    }
}
