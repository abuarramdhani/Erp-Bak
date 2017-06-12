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
				  //redirect('index');
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

		$data['questionnaire'] = $this->M_masterquestionnaire->GetQuestionnaire();

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

		$data['questionnaire'] 	= $this->M_inputquestionnaire->GetQuestionnaire($id);
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
		foreach ($data['training'] as $tr){$participant_number=$tr['participant_number'];}

		if($sbm<$participant_number){
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ADMPelatihan/InputQuestionnaire/V_Create',$data);
			$this->load->view('V_Footer',$data);
		}else{
			redirect('ADMPelatihan/InputQuestionnaire/ToCreate/'.$id);
		}
	}

	//SUBMIT QUESTIONNAIRE
	public function Add(){
		$IdKuesioner	= $this->input->post('txtQuestionnaireId');
		$IdPenjadwalan	= $this->input->post('txtSchedulingId');
		$IdStatement	= $this->input->post('txtStatementId');
		
		foreach($IdStatement as $loop){
			$statement[] = $loop;
			$input[] = $this->input->post('txtInput'.$loop);
		}
		$join_statement = join('||', $statement);
		$join_input		= join('||', $input);
		
		$this->M_inputquestionnaire->AddQuestionnaireSheet($IdKuesioner,$IdPenjadwalan,$join_statement,$join_input);
		
		redirect('ADMPelatihan/InputQuestionnaire/Create/'.$IdPenjadwalan.'/'.$IdKuesioner);
	}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('');
		}
	}
}
