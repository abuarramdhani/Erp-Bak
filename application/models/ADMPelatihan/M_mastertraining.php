<?php
class M_mastertraining extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//HALAMAN INDEX
		public function GetTraining(){
			$sql = "select * from pl.pl_master_training order by status asc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//HALAMAN CREATE
		public function GetQuestionnaire(){
			$sql = "select * from pl.pl_master_questionnaire";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//HALAMAN EDIT
		public function GetTrainingId($id){
			$sql = "select * from pl.pl_master_training where training_id=$id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//HALAMAN EDIT
		public function GetObjectiveId($id){
			$sql = "select * from pl.pl_objective_master where training_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//ADD DATA
		public function GetMaxIdTraining(){
			$sql = "
				select training_id
				from pl.pl_master_training
				order by training_id desc
				limit 1";
			$query = $this->db->query($sql);
			return $query->result();
		}

		//ADD DATA
		public function AddMaster($tname,$limit,$status,$questionnaires){
			$sql = "
				insert into pl.pl_master_training
				(training_name,\"limit\",status,questionnaire) values
				('$tname','$limit','$status','$questionnaires')";
			$query = $this->db->query($sql);
			return;
		}

		//ADD DATA
		public function AddObjective($data){
			return $this->db->insert('pl.pl_objective_master', $data);
		}

		
		//DELETE DATA
		public function DeleteTraining($id){
			$sql = "delete from pl.pl_master_training where training_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//UPDATE DATA
		public function DelObjective($id){
			$sql = "delete from pl.pl_objective_master where training_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//UPDATE DATA
		public function UpdateTraining($id,$tname,$limit,$status,$questionnaires){
			$sql = "
				update pl.pl_master_training set
					training_name='$tname',
					status='$status',
					questionnaire='$questionnaires',
					\"limit\"='$limit'
				where training_id=$id
			";
			$query = $this->db->query($sql);
			return;
		}
		
}
?>