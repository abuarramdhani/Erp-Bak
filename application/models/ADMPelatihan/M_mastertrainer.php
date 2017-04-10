<?php
class M_mastertrainer extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//select Receipt All
		public function GetTrainer(){
			$sql = "select * from pl.pl_master_trainer order by trainer_status DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//select Receipt All
		public function GetTrainerId($id){
			$sql = "select * from pl.pl_master_trainer where trainer_id='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//Create New Master
		public function AddTrainer($noind,$tname,$status){
			$sql = "
			insert INTO pl.pl_master_trainer
			(noind,trainer_name,trainer_status)values
			('$noind','$tname','$status')";
			$query = $this->db->query($sql);
			return;
		}
		
		//Delete Master
		public function DeleteTrainer($id){
			$sql = "delete from pl.pl_master_trainer where trainer_id='$id'";
			$query = $this->db->query($sql);
			return;
		}

		//update
		public function UpdateTrainer($id,$noind,$tname,$status){
			$sql = "
			update pl.pl_master_trainer set 
				noind='$noind',
				trainer_name='$tname',
				trainer_status='$status'
			where trainer_id=$id
			";
			$query = $this->db->query($sql);
			return;
		}

		public function GetNoInduk($term){
			if ($term === FALSE) {
				$sql = "
					SELECT * FROM er.er_employee_all WHERE resign = '0' ORDER BY employee_code ASC
				";
			}
			else{
				$sql = "
					SELECT * FROM er.er_employee_all WHERE resign = '0' AND (employee_code ILIKE '%$term%' OR employee_name ILIKE '%$term%') ORDER BY employee_code ASC
				";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function GetApplicant($term){
			if ($term === FALSE) {
				$sql = "
					SELECT * FROM pl.pl_tberkas ORDER BY KodeLamaran ASC
				";
			}
			else{
				$sql = "
					SELECT * FROM pl.pl_tberkas WHERE (KodeLamaran ILIKE '%$term%' OR nama ILIKE '%$term%') ORDER BY KodeLamaran ASC
				";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}
}
?>