<?php
class M_penjadwalan extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }
		
		//AMBIL DATA TRAINING
		public function GetTraining(){
			$sql = "select * from pl.pl_master_training where status=0";
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
			// $sql="	SELECT date,start_time,end_time,room,trainer
			// 		from pl.pl_scheduling_training
			// 		WHERE date = to_date('$date','DD-MM-YYYY')
			// 			-- AND start_time BETWEEN to_timestamp('09:00', 'h24:mi')
			// 				--AND to_timestamp('13:15', 'h24:mi')
			// 			--AND end_time BETWEEN '09:00:00' AND'13:15:00'
			// 			AND room = '$room'
			// 		order by room";
			$sql="	SELECT pst.date,pst.start_time,pst.end_time,pst.room,pmt.training_name,pst.trainer
					from pl.pl_scheduling_training pst, pl.pl_master_training pmt
					-- pl.pl_master_trainer mtr 
					WHERE date = to_date('$date','DD-MM-YYYY') 
					AND
					pst.training_id = pmt.training_id
					-- AND
					-- pst.trainer = mtr.trainer_id 
					AND room = '$room'
					order by room;";
			$query=$this->db->query($sql);
			return $query->result_array();
		}

		public function GetEvaluationType()
		{
			$sql = "select * from pl.pl_evaluation_type";
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

		// public function alerttrainer(){
		// 	$sql = "SELECT trainer, trainer_name
		// 			FROM pl.pl_scheduling_training st
		// 			JOIN pl.pl_master_trainer mt on st.trainer = mt.trainer_id";
		// 	$query = $this->db->query($sql);
		// 	return $query->result_array();
		// }

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
				select employee_code, employee_name
				from er.er_employee_all
				where employee_code='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
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


		//Create New Master
		public function AddSchedule($package_scheduling_id,$package_training_id,$training_id,$scheduling_name,$date,$start_time,$end_time,$room,$participant_type,$participant_number,$evaluasi,$trainers){
			$sql = "
			insert INTO pl.pl_scheduling_training
			(package_scheduling_id,package_training_id,training_id,scheduling_name,date,start_time,end_time,room,participant_type,participant_number,evaluation,trainer)values
			('$package_scheduling_id','$package_training_id','$training_id','$scheduling_name',TO_DATE('$date', 'DD/MM/YYYY'),'$start_time','$end_time','$room','$participant_type','$participant_number','$evaluasi','$trainers')";
			$query = $this->db->query($sql);
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}

		//Create New Master
		public function AddSingleSchedule($package_scheduling_id,$package_training_id,$training_id,$scheduling_name,$date,$room,$participant_type,$participant_number,$evaluasi,$trainers){
			$sql = "
			insert INTO pl.pl_scheduling_training
			(package_scheduling_id,package_training_id,training_id,scheduling_name,date,room,participant_type,participant_number,evaluation,trainer)values
			('$package_scheduling_id','$package_training_id','$training_id','$scheduling_name',TO_DATE('$date', 'DD/MM/YYYY'),'$room','$participant_type','$participant_number','$evaluasi','$trainers')";
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