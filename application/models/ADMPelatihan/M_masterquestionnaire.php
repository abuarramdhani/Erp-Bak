<?php
class M_masterquestionnaire extends CI_Model {

		public function __construct(){
			parent::__construct();
		}
		
		//AMBIL DATA MASTER KUESIONER
		public function GetQuestionnaire(){
			$sql = "select * from pl.pl_master_questionnaire order by questionnaire_id ASC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//ADD QUESTIONNAIRE STEP 1
		public function AddQuestionnaire($Questionnaire,$SubSegment){
			$sql = "
				insert INTO pl.pl_master_questionnaire
				(questionnaire_title,sub_segment)values
				('$Questionnaire','$SubSegment')";
			$query = $this->db->query($sql);
			return;
		}

		//ADD QUESTIONNAIRE STEP 2
		public function GetMaxIdQuestionnaire(){
			$sql = "
				select questionnaire_id
				from pl.pl_master_questionnaire
				order by questionnaire_id desc
				limit 1";
			$query = $this->db->query($sql);
			return $query->result();
		}

		//GET DATA FOR CREATE SEGMENT
		public function GetQuestionnaireId($id){
			$sql = "select * from pl.pl_master_questionnaire where questionnaire_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//ADD QUESTIONNAIRE SEGMENT STEP 1
		public function AddQuestionnaireSegment($data){
			return $this->db->insert('pl.pl_master_questionnaire_segment', $data);
		}

		//GET DATA FOR CREATE STATEMENT
		public function GetQuestionnaireSegmentId($id){
			$sql = "
				select *
				from pl.pl_master_questionnaire_segment
				where questionnaire_id='$id'
				order by segment_order";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//ADD QUESTIONNAIRE STATEMENT STEP 1
		public function AddQuestionnaireStatement($data){
			return $this->db->insert('pl.pl_master_questionnaire_statement', $data);
		}

		//DELETE QUESTIONNAIRE STEP 1
		public function DeleteQuestionnaire($id){
			$sql = "delete from pl.pl_master_questionnaire where questionnaire_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//DELETE QUESTIONNAIRE STEP 2
		public function DeleteQuestionnairesegment($id){
			$sql = "delete from pl.pl_master_questionnaire_segment where questionnaire_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//DELETE QUESTIONNAIRE STEP 3
		public function DeleteQuestionnairestatement($id){
			$sql = "delete from pl.pl_master_questionnaire_statement where questionnaire_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//GET DATA STATEMENT
		public function GetQuestionnaireStatementId($id){
			$sql = "
				select *
				from pl.pl_master_questionnaire_statement
				where questionnaire_id='$id'
				order by statement_order";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		// UPDATE DATA
		// public function UpdateData($data, $id)
		public function UpdateData($Q_id, $Q_name, $StDes, $SgDes, $id)
		{

			$queryUpdateData1	= "	UPDATE 	pl.pl_master_questionnaire
									SET 	questionnaire_title='".$Q_name."'
									WHERE 	questionnaire_id=".$Q_id.";";
			$queryUpdateData3 	= " UPDATE 	pl.pl_master_questionnaire_statement
			 						SET 	statement_description='".$StDes."'
			 						WHERE 	questionnaire_id=".$Q_id.";";
			$sqlUpdateData1 	=	$this->db->query($queryUpdateData1);
			$sqlUpdateData3		=	$this->db->query($queryUpdateData3);
		}

		public function insertDes($Q_id,$Des)
		{
			$sql="
				INSERT into pl.pl_master_questionnaire_segment
					(questionnaire_id,segment_description)
				values
					('$Q_id','$Des')
			";
			$this->db->query($sql);

			$last_insert_id = $this->db->insert_id();
			return $last_insert_id;
		}
		
		public function insertStDes($Q_id,$SgID,$TDes)
		{
			$sql="
				INSERT into pl.pl_master_questionnaire_statement
					(questionnaire_id,segment_id,statement_description)
				values
					('$Q_id','$SgID','$TDes')
			";
			$this->db->query($sql);

		}

		public function updateDes($Q_id,$Des, $SgID)
		{
			$sql 	= " UPDATE 	pl.pl_master_questionnaire_segment
			 						SET 	segment_description='".$Des."'
			 						WHERE 	questionnaire_id=".$Q_id."
			 						AND 	segment_id=".$SgID."";
			$this->db->query($sql);
		}

		public function updateStDes($Q_id,$SgID,$TDes,$idStatement)
				{
					$sql 	= " UPDATE 	pl.pl_master_questionnaire_statement
					 						SET 	statement_description='".$TDes."'
					 						WHERE statement_id	= $idStatement
					 							AND questionnaire_id=".$Q_id."
					 							AND 	segment_id=".$SgID."";
					$this->db->query($sql);
				}


		public function deleteSeg($SgID)
		{
			$sql="DELETE 
				from pl.pl_master_questionnaire_segment
				where segment_id = ".$SgID."";
			$this->db->query($sql);
		}

		public function deleteSt($StID)
				{
					$sql="DELETE 
						from pl.pl_master_questionnaire_statement
						where statement_id = ".$StID."";
					$this->db->query($sql);
				}


		//AMBIL DATA RUANGAN YANG DIPILIH
		public function GetRoomId($id){
			$sql = "select * from pl.pl_room where room_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//UPDATE DATA RUANGAN
		public function UpdateRoom($id,$RoomName,$RoomCapacity){
			$sql = "
			update pl.pl_room set 
				room_name='$RoomName',
				description='$RoomName',
				capacity='$RoomCapacity'
			where room_id=$id
			";
			$query = $this->db->query($sql);
			return;
		}

		public function GetTitle($Qs_id)
		{
			$sql="
					select 	q.questionnaire_title,
							q.questionnaire_id
					from	pl.pl_master_questionnaire q
					where	q.questionnaire_id=".$Qs_id.";";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function GetSegmentTitle($Sg_id)
		{
			$sql="
					select 	sg.segment_description,
							sg.segment_id
					from pl.pl_master_questionnaire_segment sg
					where sg.segment_id=".$Sg_id.";";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function GetStatement($Qs_id,$Sg_id)
		{
			$sql="
					select	st.statement_id,
							st.statement_description
					from 	pl.pl_master_questionnaire_statement st
					where	st.segment_id=".$Sg_id." and st.questionnaire_id=".$Qs_id.";";
			$query = $this->db->query($sql);
			return $query->result_array();
		}


}
?>