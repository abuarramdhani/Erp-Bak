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
}
?>