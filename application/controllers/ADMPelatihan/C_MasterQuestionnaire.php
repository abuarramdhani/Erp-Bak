<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterQuestionnaire extends CI_Controller {

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
		$this->load->model('ADMPelatihan/M_masterquestionnaire');
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

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Kuesioner';
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

		$data['questionnaire'] = $this->M_masterquestionnaire->GetQuestionnaire();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterQuestionnaire/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//HALAMAN CREATE TRAINER INTERNAL
	public function Create(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Kuesioner';
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

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterQuestionnaire/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}

	//SUBMIT QUESTIONNAIRE
	public function Add(){
		$Questionnaire	= $this->input->post('txtKuesioner');
		$SubSegment		= $this->input->post('slcSubBagian');

		$this->M_masterquestionnaire->AddQuestionnaire($Questionnaire,$SubSegment);
		$maxid				= $this->M_masterquestionnaire->GetMaxIdQuestionnaire();
		$QuestionnaireId 	= $maxid[0]->questionnaire_id;

		if($SubSegment==2){
			redirect('ADMPelatihan/MasterQuestionnaire/CreateSegment/'.$QuestionnaireId);
		}elseif($SubSegment==1){
			
			$data_segment = array(
				'questionnaire_id' 		=> $QuestionnaireId,
				'segment_description' 	=> $Questionnaire,
				'segment_order' 		=> 0,
			);
			$this->M_masterquestionnaire->AddQuestionnaireSegment($data_segment);

			redirect('ADMPelatihan/MasterQuestionnaire/CreateStatement/'.$QuestionnaireId);
		}
	}

	//HALAMAN CREATE QUESTIONNAIRE SEGMENT
	public function CreateSegment($id){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Kuesioner';
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

		$data['questionnaire'] = $this->M_masterquestionnaire->GetQuestionnaireId($id);
		$data['segment'] 		= $this->M_masterquestionnaire->GetQuestionnaireSegmentId($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterQuestionnaire/V_CreateSegment',$data);
		$this->load->view('V_Footer',$data);	
	}

	//SUBMIT QUESTIONNAIRE SEGMENT
	public function AddSegment(){
		$QuestionnaireId= $this->input->post('txtQuestionnaireId');
		$Segment		= $this->input->post('txtSegment');
		$SegmentEssay	= $this->input->post('txtSegmentEssay');

			$i=0;
			foreach($Segment as $loop){
				$data_segment[$i] = array(
					'questionnaire_id' 		=> $QuestionnaireId,
					'segment_description' 	=> $Segment[$i],
					'segment_order' 		=> $i,
					'segment_type' 			=> 1,
				);
				if( !empty($Segment[$i]) ){
					$this->M_masterquestionnaire->AddQuestionnaireSegment($data_segment[$i]);
				}
				$i++;
			}

			$j=0;
			foreach($SegmentEssay as $loop){
				$data_segmentEssay[$j] = array(
					'questionnaire_id' 		=> $QuestionnaireId,
					'segment_description' 	=> $SegmentEssay[$j],
					'segment_order' 		=> $j+$i,
					'segment_type' 			=> 0,
				);
				if( !empty($SegmentEssay[$j]) ){
					$this->M_masterquestionnaire->AddQuestionnaireSegment($data_segmentEssay[$j]);
				}
				$j++;
			}

		redirect('ADMPelatihan/MasterQuestionnaire/CreateStatement/'.$QuestionnaireId);
	}

	//HALAMAN CREATE QUESTIONNAIRE STATEMENT
	public function CreateStatement($id){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Kuesioner';
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

		$data['questionnaire'] = $this->M_masterquestionnaire->GetQuestionnaireId($id);
		$data['segment'] = $this->M_masterquestionnaire->GetQuestionnaireSegmentId($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterQuestionnaire/V_CreateStatement',$data);
		$this->load->view('V_Footer',$data);	
	}


	//SUBMIT QUESTIONNAIRE STATEMENT
	public function AddStatement(){
		$QuestionnaireId= $this->input->post('txtQuestionnaireId');
		$SegmentId		= $this->input->post('txtSegmentId');
		foreach ($SegmentId as $sid) {
			$Statement[]	= $this->input->post('txtStatement'.$sid);
		}

		for ($i=0; $i < count($SegmentId) ; $i++) {
			$order = 0;
			foreach ($Statement[$i] as $st) {
				$data_statement[$order] = array(
					'questionnaire_id' 		=> $QuestionnaireId,
					'segment_id' 			=> $SegmentId[$i],
					'statement_description' => $st,
					'statement_order' 		=> $order
				);
				if( !empty($data_statement[$order]) ){
					$this->M_masterquestionnaire->AddQuestionnaireStatement($data_statement[$order++]);
				}
			}
		}
		
		redirect('ADMPelatihan/MasterQuestionnaire/');
	}

	public function EditStatement($Qs_id, $Sg_id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Kuesioner';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		if ($data['UserSubMenuOne'][0]['menu'] == 'Jadwal Pelatihan') {
			unset($data['UserSubMenuOne'][0]);
		}

		if ($data['UserSubMenuOne'][5]['menu'] == 'Custom Report') {
			unset($data['UserSubMenuOne'][5]);
		}
		
		$data['title']			= $this->M_masterquestionnaire->GetTitle($Qs_id);
		$data['segment_title']	= $this->M_masterquestionnaire->GetSegmentTitle($Sg_id);
		$data['statement']		= $this->M_masterquestionnaire->GetStatement($Qs_id,$Sg_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterQuestionnaire/V_Edit_Statement', $data);
		$this->load->view('V_Footer',$data);
		
	}

	//MENGHAPUS QUESIONER
	public function delete($id){
		$this->M_masterquestionnaire->DeleteQuestionnaire($id);
		$this->M_masterquestionnaire->DeleteQuestionnaireSegment($id);
		$this->M_masterquestionnaire->DeleteQuestionnaireStatement($id);
		redirect('ADMPelatihan/MasterQuestionnaire');
	}

	//HALAMAN VIEW
	public function view($id){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Kuesioner';
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

		$data['questionnaire'] 	= $this->M_masterquestionnaire->GetQuestionnaireId($id);
		$data['segment'] 		= $this->M_masterquestionnaire->GetQuestionnaireSegmentId($id);
		$data['statement'] 		= $this->M_masterquestionnaire->GetQuestionnaireStatementId($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterQuestionnaire/V_View',$data);
		$this->load->view('V_Footer',$data);
	}

	//HALAMAN VIEW
	public function edit($id){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Master Kuesioner';
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

		$data['questionnaire'] 	= $this->M_masterquestionnaire->GetQuestionnaireId($id);
		$data['segment'] 		= $this->M_masterquestionnaire->GetQuestionnaireSegmentId($id);
		$data['statement'] 		= $this->M_masterquestionnaire->GetQuestionnaireStatementId($id);
		$data['id']				= $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMPelatihan/MasterQuestionnaire/V_Edit',$data);

		$this->load->view('V_Footer',$data);
	}


	public function editSave($id)
	{
		$Q_id 		=	$this->input->post('txtQuestionnaireId');
		$Q_name		=	$this->input->post('txtQuestionnaireName');
		$StDes 		=	$this->input->post('txtStatement');
		$SgDes 		=	$this->input->post('txtSegment');
		$idSegment 	=	$this->input->post('idSegment');
		$idStatement=	$this->input->post('idStatement');
		$SgID 		= 	$this->input->post('segment_id');
		$StID 		= 	$this->input->post('statement_id');
		
		// pakai ajax
		$accessType =	$this->input->post('accessType');
		$lineId		=   $this->input->post('lineId');
		$quesName	=   $this->input->post('txtQuestionnaireName');

		$data['questionnaire'] = $this->M_masterquestionnaire->GetQuestionnaireId($id);
		if ($data['questionnaire'] == TRUE) {
			if ($Q_name != $data['questionnaire'][0]['questionnaire_title']) {
				$update = $this->M_masterquestionnaire->updateTitle($Q_id, $Q_name);
			}
		}


		if ($accessType == 'ajax') {
			if($lineId == null) {
				$save = $this->M_masterquestionnaire->insertDesAjax($Q_id,$SgDes,$quesName);
			} 
			// else {
			// 	$update = $this->M_masterquestionnaire->updateDesAjax($Q_id,$SgDes, $lineId);
			// }
		}else{
			$n = 0;
			foreach ($SgDes as $Des) {
				// if ($idSegment[$n] == '0') {
				// 	$save = $this->M_masterquestionnaire->insertDes($Q_id,$Des,$SgID);
				// }else{
				    $update = $this->M_masterquestionnaire->updateDes($Q_id,$Des, $idSegment[$n]);
				// }
				$n++;
			}
			foreach ($StDes as $TDes) {
				if ($idStatement[$n] == '0') {
					$save = $this->M_masterquestionnaire->insertStDes($Q_id,$SgID,$TDes,$StID);
				}
				else {
					$update = $this->M_masterquestionnaire->updateStDes($Q_id,$SgID,$TDes,$idStatement[$n]);
				}
				$n++;
			}
			redirect(base_url('ADMPelatihan/MasterQuestionnaire'));
		}
	}
	

	public function EditSaveStatement($questionnaire_id,$segment_id)
	{
		$StDes 		=	$this->input->post('txtStatement');
		$idStatement=	$this->input->post('idStatement');
		$n = 0;
		foreach ($StDes as $TDes) {
			if ($idStatement[$n] == '0') {
				$save = $this->M_masterquestionnaire->insertStDes($questionnaire_id,$segment_id,$TDes);
			}
			else {
				$update = $this->M_masterquestionnaire->updateStDes($questionnaire_id,$segment_id,$TDes,$idStatement[$n]);
			}
			$n++;
		}
		redirect(base_url('ADMPelatihan/MasterQuestionnaire/Edit/'.$questionnaire_id));
	}

	
	public function delSeg($SgID)
	{		
			
			$delete = $this->M_masterquestionnaire->deleteSeg($SgID);
	}
	public function delSt($StID)
		{		
			
			$delete = $this->M_masterquestionnaire->deleteSt($StID);
		}

	public function checkSession(){
		if($this->session->is_logged){
		}else{
			redirect('');
		}
	}
}
