<?php
class M_mastertrainer extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
       		$this->quickcom_hrd_khs = $this->load->database('quickcom_hrd_khs', TRUE);
       		$this->personalia = $this->load->database('personalia', TRUE);
        }
		
        //Get data
        public function GetAllInfo($nama)
        {
        	$sql = "SELECT *
					FROM	hrd_khs.tpribadi a
					INNER JOIN	hrd_khs.tseksi b on a.Kodesie=b.kodesie
					WHERE	nama = '$nama'
					order by a.Tglkeluar";
			$query = $this->personalia->query($sql);
			return $query->result_array();
			// return $sql;
        }
        public function GetAllInfoFiltered($cektanggal)
        {
        	$sql = "SELECT *
					FROM	hrd_khs.tpribadi a
					INNER JOIN	hrd_khs.tseksi b on a.Kodesie=b.kodesie
					WHERE	a.noind in ('$cektanggal')
					order by a.Tglkeluar";
			$query = $this->personalia->query($sql);
			return $query->result_array();
			// return $sql;
        }
        public function GetTanggalLahirTrainer($noind)
        {
        	$sql = "SELECT tgllahir
					FROM	hrd_khs.tpribadi a
					INNER JOIN	hrd_khs.tseksi b on a.Kodesie=b.kodesie
					WHERE	noind = '$noind'";
			$query = $this->personalia->query($sql);
			return $query->result_array();
			// return $sql;
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
			$id=$this->db->insert_id();
			return $id;
		}
		
		//Delete Master
		public function DeleteTrainer($id){
			$sql1 = "delete from pl.pl_master_trainer where trainer_id='$id'";
			$sql2 = "delete from pl.pl_experience where trainer_id='$id'";
			$sql3 = "delete from pl.pl_certificated_training where trainer_id='$id'";
			$sql4 = "delete from pl.pl_trainer_team where trainer_id='$id'";

			$query = $this->db->query($sql1);
			$query = $this->db->query($sql2);
			$query = $this->db->query($sql3);
			$query = $this->db->query($sql4);
			return;
		}

		//update
		public function UpdateTrainer($id,$noind,$tname){
			$sql = "
			update pl.pl_master_trainer set 
				noind='$noind',
				trainer_name='$tname'
			where trainer_id=$id
			";
			$query = $this->db->query($sql);
			return;
		}

		// public function GetNoInduk($term){
		// 	if ($term === FALSE) {
		// 		$sql = "
		// 			SELECT TRIM(TRAILING ' ' from a.employee_name) as name, a.* FROM er.er_employee_all a WHERE resign = '0' ORDER BY a.employee_code ASC
		// 		";
		// 	}
		// 	else{
		// 		$sql = "
		// 			SELECT TRIM(TRAILING ' ' from a.employee_name) as name, a.* FROM er.er_employee_all a WHERE resign = '0' AND (a.employee_code ILIKE '%$term%' OR a.employee_name ILIKE '%$term%') ORDER BY a.employee_code ASC
		// 		";
		// 	}
		// 	$query = $this->db->query($sql);
		// 	// return $query->result_array();
		// 	return $sql;
		// }
		public function GetNoInduk($term){
			if ($term === FALSE) {
				$sql = "
					SELECT TRIM(TRAILING ' ' from a.nama) as name, a.* FROM hrd_khs.tpribadi a WHERE a.keluar = '0' ORDER BY a.noind ASC
				";
			}
			else{
				$sql = "
					SELECT TRIM(TRAILING ' ' from a.nama) as name, a.* FROM hrd_khs.tpribadi a WHERE a.keluar = '0' AND (a.noind ILIKE '%$term%' OR a.nama ILIKE '%$term%') ORDER BY a.noind ASC
				";
			}
			$query = $this->personalia->query($sql);
			return $query->result_array();
			// return $sql;
		}

		public function GetNoIndukTraining($term,$training){
			if ($term === FALSE) {
				$sql = "
					SELECT TRIM(TRAILING ' ' from a.employee_name) as name, a.* 
					FROM er.er_employee_all a 
					WHERE a.resign = '0' 
					and a.employee_code not in(
					select noind
					from pl.pl_participant a
					inner join pl.pl_scheduling_training b on a.scheduling_id=b.scheduling_id
					inner join pl.pl_master_training c on b.training_id=c.training_id
					where 
					training_name = '$training'
					)  ORDER BY a.employee_code ASC 
				";
			}
			else{
				$sql = "
					SELECT TRIM(TRAILING ' ' from a.employee_name )as name, a.* 
					FROM er.er_employee_all a 
					WHERE a.resign = '0' 
					AND (a.employee_code ILIKE '%$term%' OR a.employee_name LIKE '%$term%') 
					and a.employee_code not in (
					select noind
					from pl.pl_participant a
					inner join pl.pl_scheduling_training b on a.scheduling_id=b.scheduling_id
					inner join pl.pl_master_training c on b.training_id=c.training_id
					where 
					training_name = '$training'
					) 
					ORDER BY a.employee_code ASC
				";
			}
			$query = $this->db->query($sql);//diganti ke erp, pl di erp kan ?
			//ya
			return $query->result_array();
			// return $sql;
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

		//ADD MASTER TRAINER INTERNAL EXPERIENCE, CERTIFICATE, TEAM 
		public function AddExperience($data)
		{
			$this->db->insert('pl.pl_experience', $data);
		}

		public function AddCertificated($data)
		{
			$this->db->insert('pl.pl_certificated_training', $data);
		}
		public function AddTrainerTeam($data)
		{
			$this->db->insert('pl.pl_trainer_team', $data);
		}

		//GET MASTER TRAINER INTERNAL EXPERIENCE, CERTIFICATE, TEAM 
		public function GetExperience($noind)
		{
			$sql="	select a.*
					from  pl.pl_experience a
					where a.noind='$noind'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		public function GetCertificate($noind)
		{
			$sql="	select b.*
					from pl.pl_certificated_training b
					where b.noind='$noind'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		public function GetTeam($noind)
		{
			$sql="	select c.*
					from pl.pl_trainer_team c 
					where c.noind='$noind'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		//DELETE ROW MASTER TRAINER INTERNAL EXPERIENCE, CERTIFICATE, TEAM 
		public function delete_exp($trainer_id, $idex)
		{
			$sql="	DELETE FROM pl.pl_experience
					WHERE id_exp='$idex' 
					AND trainer_id='$trainer_id'";
			$query = $this->db->query($sql);
		}
		public function delete_sertifikat($trainer_id,$idser)
		{
			$sql="	DELETE FROM pl.pl_certificated_training
					WHERE id_cert='$idser' 
					AND trainer_id='$trainer_id'";
			$query = $this->db->query($sql);
		}
		public function delete_team($trainer_id,$idteam)
		{
			$sql="	DELETE FROM pl.pl_trainer_team
					WHERE id_team='$idteam' 
					AND trainer_id='$trainer_id'";
			$query = $this->db->query($sql);
		}
		public function InsertEx($id, $experience, $experience_date, $noind)
		{
			$sql="	INSERT into pl.pl_experience
					(training_name, training_date, trainer_id, noind)
					values (' $experience', TO_DATE('$experience_date', 'DD/MM/YYYY'), $id, '$noind')";
			$query = $this->db->query($sql);
			// return $sql;
		}
		public function updatePublic($table, $kolom, $data, $id)
		{
			$this->db->where($kolom, $id);
			$this->db->update($table, $data);
		}
}
?>