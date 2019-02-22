<?php
class M_mastertraining extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//HALAMAN INDEX
		public function GetTraining(){
			$sql = "select pt.training_id , pt.training_name , pt.limit_1, pt.kapasitas_kelas, pt.limit_2 from pl.pl_master_training pt order by status asc";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		

		public function GetObjective($term){
			if ($term === FALSE) {
				$sql = "
					SELECT purpose FROM pl.pl_master_training_purpose GROUP BY purpose
				";
			}else{
				$sql = "
					SELECT purpose FROM pl.pl_master_training_purpose WHERE (purpose LIKE '%$term%') GROUP BY purpose 
				";
			}
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
			$sql = "select * from pl.pl_master_training_purpose where training_id='$id'";
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
		public function AddObjective($data){
			return $this->db->insert('pl.pl_master_training_purpose', $data);
		}

		//ADD DATA
		public function AddMaster($tname,$limit=FALSE,$questionnaires,$kapasitas,$limit2=FALSE){
			if ($limit==FALSE) {
			$sql = "
				insert into pl.pl_master_training
				(training_name,status,questionnaire,kapasitas_kelas,limit_2) values
				('$tname',0,'$questionnaires','$kapasitas','$limit2')";
			}elseif ($limit2==FALSE) {
				$sql = "
				insert into pl.pl_master_training
				(training_name,limit_1,status,questionnaire,kapasitas_kelas) values
				('$tname','$limit',0,'$questionnaires','$kapasitas')";
			}else{
				$sql = "
				insert into pl.pl_master_training
				(training_name,limit_1,status,questionnaire,kapasitas_kelas,limit_2) values
				('$tname','$limit',0,'$questionnaires','$kapasitas','$limit2')";
			}
			$query = $this->db->query($sql);

			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}
		

		//DELETE DATA
		public function DeleteTraining($id){
			$sql = "delete from pl.pl_master_training where training_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//UPDATE DATA
		public function DelObjective($id){
			$sql = "delete from pl.pl_master_training_purpose where training_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//UPDATE DATA
		public function UpdateTraining($id,$tname,$limit=false,$status,$questionnaires,$kapasitas,$limit2=false){
			if ($limit==FALSE) {
				$sql = "
					update pl.pl_master_training set
						training_name='$tname',
						status='$status',
						kapasitas_kelas='$kapasitas',
						questionnaire='$questionnaires',
						limit_2='$limit2',
						limit_1=null
					where training_id=$id
				";	
			} elseif ($limit2==FALSE) {
				$sql = "
					update pl.pl_master_training set
						training_name='$tname',
						status='$status',
						kapasitas_kelas='$kapasitas',
						questionnaire='$questionnaires',
						limit_1='$limit',
						limit_2=null
					where training_id=$id
				";
			}else{
				$sql = "
					update pl.pl_master_training set
						training_name='$tname',
						status='$status',
						kapasitas_kelas='$kapasitas',
						questionnaire='$questionnaires',
						limit_1='$limit',
						limit_2='$limit2'
					where training_id=$id
				";
			}
			$query = $this->db->query($sql);
			return;
		}

		// GET OBJECT
		public function pp($objective)
		{
			$sql = "select count(*) from pl.pl_master_training_purpose WHERE purpose LIKE '%$objective%' GROUP BY purpose; ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}
?>