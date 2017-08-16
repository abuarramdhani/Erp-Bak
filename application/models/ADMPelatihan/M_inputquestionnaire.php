<?php
class M_inputquestionnaire extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
		
	//DATA UNTUK HALAMAN CREATE
	public function GetTrainingId($id){
		$sql = "
			select *,
				case when date
  				is NULL then null 	
  				else to_char(date, 'DD Month YYYY')
  				end as date_format
			from pl.pl_scheduling_training
			where scheduling_id=$id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//DATA UNTUK HALAMAN CREATE
	public function GetTrainer(){
		$sql = "select * from pl.pl_master_trainer order by trainer_status DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		
	//DATA UNTUK HALAMAN CREATE
	public function GetQuestionnaireId($qe){
		$sql = "select * from pl.pl_master_questionnaire where questionnaire_id='$qe'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//DATA UNTUK HALAMAN CREATE
	public function GetQuestionnaireSegmentId($qe){
		$sql = "
			select *
			from pl.pl_master_questionnaire_segment
			where questionnaire_id='$qe' 
			order by segment_order";
		$query = $this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}

	//DATA UNTUK HALAMAN CREATE
	public function GetQuestionnaireSegmentEssayId($qe){
		$sql = "
			select *
			from pl.pl_master_questionnaire_segment
			where questionnaire_id='$qe' and segment_type=0
			order by segment_order";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//DATA UNTUK HALAMAN CREATE
	public function GetQuestionnaireStatementId($qe){
		$sql = "
			select *
			from pl.pl_master_questionnaire_statement
			where questionnaire_id='$qe'
			order by statement_order";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//DATA UNTUK HALAMAN CREATE
	public function GetSubmittedSheet($id,$qe){
		$sql = "
			select count(questionnaire_sheet_id) as submitted
			from pl.pl_questionnaire_sheet
			where Scheduling_id='$id' and questionnaire_id='$qe'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	//DATA UNTUK HALAMAN CREATE
		public function GetQuestionnaireSheet($id, $qe){
			$sql = "
				SELECT *
				from pl.pl_questionnaire_sheet
				WHERE scheduling_id ='$id'
				AND questionnaire_id ='$qe'
				";
				// AND questionnaire_sheet_id ='$qsi'
			$query = $this->db->query($sql);
			return $query->result_array();
		}


	//DATA UNTUK HALAMAN CREATE
	public function GetAttendant($id){
		$sql = "
			select count(participant_id) as attendant
			from pl.pl_participant
			where scheduling_id='$id' and status=1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//DATA UNTUK HALAMAN TOCREATE
	public function GetQuestionnaire($aidi,$id){
		$sql = "SELECT *,(select count(questionnaire_sheet_id) as submitted
	 			from pl.pl_questionnaire_sheet
	 			where scheduling_id='$aidi' AND questionnaire_id = '$id'
	 			group by questionnaire_id) as jmlinput
				FROM pl.pl_master_questionnaire
				where questionnaire_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetSchedule($id)
	{
		$sql = "SELECT	training_id
				 from	pl.pl_scheduling_training
				 where scheduling_id='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetSheet()
	{
		$sql="SELECT *
	 			from pl.pl_questionnaire_sheet";
	 	$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetTrain($id)
	{
		$sql = "SELECT	*
				 from	pl.pl_master_training
				 where training_id = $id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//DATA UNTUK HALAMAN TOCREATE
	public function GetTraining($id){
		$sql = "select * from pl.pl_scheduling_training where scheduling_id = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//ADD QUESTIONNAIRE SHEET
	public function AddQuestionnaireSheet($IdKuesioner,$IdPenjadwalan,$join_statement,$join_input){
		$sql = "
			insert into pl.pl_questionnaire_sheet
			(questionnaire_id,scheduling_id,join_statement_id,join_input)values
			('$IdKuesioner','$IdPenjadwalan','$join_statement','$join_input')";
		$query = $this->db->query($sql);
		return;
	}

	//DATA UNTUK HALAMAN EDIT
		public function GetQuestionnaireSheetEdit($id, $qe, $qsi){
			$sql = "
				SELECT *
				from pl.pl_questionnaire_sheet
				WHERE scheduling_id ='$id'
				AND questionnaire_id ='$qe'
				AND questionnaire_sheet_id ='$qsi'
				";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	public function UpdateQuestionnaireSheet($IdKuesioner,$IdPenjadwalan,$IdQSheet,$join_input){
		$sql = "UPDATE 	pl.pl_questionnaire_sheet
			 	SET 	join_input='$join_input'
			 	WHERE 	questionnaire_id='$IdKuesioner'
			 	AND 	scheduling_id='$IdPenjadwalan'
			 	AND 	questionnaire_sheet_id='$IdQSheet'";
		$query = $this->db->query($sql);
		return;
	}

	// DELETE 
	public function DeleteQuestionnaireSheet($qsid)
	{
		$sql="delete from pl.pl_questionnaire_sheet where questionnaire_sheet_id='$qsid'";
		$query = $this->db->query($sql);
		return;
	}
}
?>