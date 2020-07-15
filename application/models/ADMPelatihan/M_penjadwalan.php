<?php
class M_penjadwalan extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            $this->load->database();
			$this->personalia = $this->load->database('personalia', TRUE);
        }
		
		//AMBIL DATA TRAINING
		public function GetTraining(){
			$sql = "select * from pl.pl_master_training ";
			$sql2 = "select * from pl.pl_master_training_purpose";
			$sql3 = "SELECT
						SUM(tr.kapasitas_kelas) jumlah, 
						pc.package_id,
						pc.package_name
					FROM
						pl.pl_master_training tr,
						pl.pl_master_package pc,
						pl.pl_master_package_training pt
					WHERE tr.training_id = pt.training_id 
						and pt.package_id = pc.package_id
					group by pc.package_id, pc.package_name;";
			$query = $this->db->query($sql);
			$query2 = $this->db->query($sql2);
			$query3 = $this->db->query($sql3);
			return $query->result_array();
		}

		public function GetAlert($date,$start_time,$end_time,$room,$training_id)
		{
			$sql =" SELECT pst.date,pst.start_time,pst.end_time,pst.room,pst.trainer, pmt.training_name
					from pl.pl_scheduling_training pst, pl.pl_master_training pmt
					where pst.training_id = pmt.training_id 
						AND pst.date = to_date('$date','MM-DD-YYYY')
						and (pst.start_time::time without time zone BETWEEN to_timestamp('$start_time', 'HH24:MI')::time without time zone
							AND to_timestamp('$end_time', 'HH24:MI')::time without time zone
						OR end_time::time without time zone BETWEEN to_timestamp('$start_time', 'HH24:MI')::time without time zone
							and to_timestamp('$end_time', 'HH24:MI')::time without time zone)
						AND pst.room = '$room'
					order by pst.room";
			$query=$this->db->query($sql);
			return $query->result_array();
		}

		public function GetAlertPackage($date,$room,$training_id)
		{
			$sql =" SELECT pst.date,pst.start_time,pst.end_time,pst.room,pst.trainer, pmt.training_name
					from pl.pl_scheduling_training pst, pl.pl_master_training pmt
					where pst.training_id = pmt.training_id 
						AND pst.date = to_date('$date','MM-DD-YYYY')
						AND pst.room = '$room'
					order by pst.room";
			$query=$this->db->query($sql);
			return $query->result_array();
		}

		public function GetEvaluationType()
		{
			$sql = "select * from pl.pl_evaluation_type where (evaluation_type_id=2 or evaluation_type_id=3)";
			$query=$this->db->query($sql);
			return $query->result_array();
		}

		public function GetParticipantType()
		{
			$sql = "
					SELECT * FROM pl.pl_participant_type ORDER BY participant_type_id ASC 
				";
			$query=$this->db->query($sql);
			return $query->result_array();
		}

		//select Receipt All
		public function GetTrainingId($id){
			$sql = "select * from pl.pl_master_training	where training_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//select Receipt All
		public function GetPackageSchedulingId($pse){
			$sql = "select * from pl.pl_scheduling_package where package_scheduling_id = $pse";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//select Receipt All
		public function GetTrainingIdMPE($ptr){
			$sql = "select *
					from pl.pl_master_package_training a
					left join pl.pl_master_training b on a.training_id = b.training_id
					where a.package_training_id = $ptr";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//Get Trainer
		public function GetTrainer(){
			$sql = "select * from pl.pl_master_trainer order by noind";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function GetTrainerPackage(){
			$sql = "select * from pl.pl_master_trainer
					order by noind";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function GetTrainerDirect($term){
			if ($term === FALSE) {
				$sql = "
					SELECT * FROM pl.pl_master_trainer ORDER BY noind ASC
				";
			}else{
				$sql = "
					SELECT * FROM pl.pl_master_trainer WHERE (noind ILIKE '%$term%' OR trainer_name ILIKE '%$term%') ORDER BY noind ASC
				";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function GetObjectiveId($id){
		$sql = " select * from pl.pl_master_training_purpose where training_id='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		//Get Trainer
		public function GetObjective($term){
			if ($term === FALSE) {
				$sql = "
					SELECT purpose FROM pl.pl_master_training_purpose GROUP BY purpose ORDER BY purpose ASC
				";
			}else{
				$sql = "
					SELECT purpose FROM pl.pl_master_training_purpose WHERE (purpose LIKE '%$term%') GROUP BY purpose ORDER BY purpose ASC 
				";
			}
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		public function GetMaxIdScheduling(){
			$sql = "
				select scheduling_id
				from pl.pl_scheduling_training
				order by scheduling_id desc
				limit 1";
			$query = $this->db->query($sql);
			return $query->result();
		}

		//MENGAMBIL TANGGAL TERKECIL DAN TERBESAR PELATIHAN
		public function GetPackageStartDate($package_scheduling_id){
			$sql = " select date from pl.pl_scheduling_training where package_scheduling_id=$package_scheduling_id order by date asc limit 1";
			$query = $this->db->query($sql);
			return $query->result();
		}
		public function GetPackageEndDate($package_scheduling_id){
			$sql = " select date from pl.pl_scheduling_training where package_scheduling_id=$package_scheduling_id order by date desc limit 1";
			$query = $this->db->query($sql);
			return $query->result();
		}

		//AMBIL DATA EMPLOYEE BERDASARKAN ID
		public function GetEmployeeData($id){
			$sql = "
				select noind, nama
				from hrd_khs.tpribadi
				where noind='$id'";
			$query = $this->personalia->query($sql);
			return $query->result_array();
			// return $sql;
		}

		//AMBIL DATA APPLICANT BERDASARKAN ID
		public function GetApplicantData($id){
			$sql = "
				select kodelamaran, nama
				from pl.pl_tberkas
				where kodelamaran='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//select Room
		public function GetRoom(){
			$sql = "select * from pl.pl_room order by room_name";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		// ambil start date untuk paket
		public function GetStartDate($pse)
		{
			$sql="	select *
					from pl.pl_scheduling_package a
					inner join pl.pl_master_package_training b on a.package_id=b.package_id
					where a.package_scheduling_id='$pse'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//Create New Master
		public function AddSchedule($package_scheduling_id,$package_training_id,$training_id,$scheduling_name,$date,$start_time,$end_time,$room,$participant_type,$participant_number,$evaluasi2,$sifat,$trainers,$jenis,$standar_nilai,$status){
			$sql = "
			insert INTO pl.pl_scheduling_training
			(package_scheduling_id,package_training_id,training_id,scheduling_name,date,start_time,end_time,room,participant_type,participant_number,evaluation,trainer,sifat,training_type,standar_kelulusan,status)values
			('$package_scheduling_id','$package_training_id','$training_id','$scheduling_name',TO_DATE('$date', 'DD/MM/YYYY'),'$start_time','$end_time','$room','$participant_type','$participant_number','$evaluasi2','$trainers','$sifat',$jenis,'$standar_nilai','$status')";
			$query = $this->db->query($sql);
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}

		//Create New Master
		public function AddSingleSchedule($package_scheduling_id,$package_training_id,$training_id,$scheduling_name,$date,$room,$participant_type,$participant_number,$evaluasi2,$trainers,$sifat,$jenis,$standar_kelulusan){
			$sql = "
			insert INTO pl.pl_scheduling_training
			(package_scheduling_id,package_training_id,training_id,scheduling_name,date,room,participant_type,participant_number,evaluation,trainer,sifat,training_type,standar_kelulusan)values
			('$package_scheduling_id','$package_training_id','$training_id','$scheduling_name',TO_DATE('$date', 'DD/MM/YYYY'),'$room','$participant_type','$participant_number','$evaluasi2','$trainers',$sifat,$jenis,'$standar_kelulusan')";
			$query = $this->db->query($sql);
			return;
		}

		public function UpdateStartDate($date,$package_scheduling_id)
		{
			$sql="
				update pl.pl_scheduling_package 
				set start_date=TO_DATE('$date','DD/MM/YYYY')
				where package_scheduling_id='$package_scheduling_id'";
			$query = $this->db->query($sql);
			return;
		}

		//Insert Master Objective
		public function AddMultiSchedule($data){
			return $this->db->insert('pl.pl_scheduling_training', $data);
		}

		//Insert Objective -> Training Purpose
		public function AddObjective($data){
			return $this->db->insert('pl.pl_master_training_purpose', $data);
		}

		//Insert Master Objective
		public function AddParticipant($data){
			return $this->db->insert('pl.pl_participant', $data);
		}

		//HALAMAN CREATE PENJADWALAN PACKAGE
		public function GetPackageTrainingId($id){
			$sql = "
				select *
				from pl.pl_master_package_training a
				left join pl.pl_master_training b on a.training_id = b.training_id
				where a.package_id='$id'
				order by a.training_order";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

//-------------------------------------------------------------------------------------//
		//HALAMAN CREATE PENJADWALAN PACKAGE	
		public function GetTrainingList($package_id){
			$sql = "
				select *
				from pl.pl_master_package_training a
				left join pl.pl_master_training b on a.training_id = b.training_id
				where a.package_id=$package_id
				order by a.training_order";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		//HALAMAN CREATE PENJADWALAN PACKAGE	
		public function GetDayNumber($package_id){
			$sql = "
				select *
				from pl.pl_master_package_training
				where package_id=$package_id
				order by day desc
				limit 1";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		//UPDATE DATA RUANGAN
		public function UpdatePackageScheduling($participant_number,$startdate,$enddate,$package_scheduling_id){
			$sql = "
			update pl.pl_scheduling_package set 
				participant_number='$participant_number',
				start_date='$startdate',
				end_date='$enddate'
			where package_scheduling_id=$package_scheduling_id
			";
			$query = $this->db->query($sql);
			return;
		}

		public function pp($objective)
		{
			$sql = "select count(*) from pl.pl_master_training_purpose WHERE purpose LIKE '%$objective%'; ";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

}
?>