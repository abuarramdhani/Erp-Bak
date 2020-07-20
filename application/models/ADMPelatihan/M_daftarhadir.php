<?php 
Defined('BASEPATH') or exit('No Direct Sekrip Access Allowed');
/**
 * 
 */
class M_daftarhadir extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getPaketPelatihan(){
		$sql = "select 	sp.package_scheduling_id,
						sp.package_scheduling_name,
						tt.training_type_description , 
						pt.participant_type_description, 
						coalesce(
							(
								select count(distinct ppt.participant_name) 
								from pl.pl_participant ppt
								where ppt.scheduling_id in (
															select st.scheduling_id 
															from pl.pl_scheduling_training st 
															where st.package_scheduling_id = sp.package_scheduling_id
															)
							) 
						,0) participant_number,
						(select min(st.\"date\") from pl.pl_scheduling_training st where st.package_scheduling_id = sp.package_scheduling_id) start_date,
						(select max(st.\"date\") from pl.pl_scheduling_training st where st.package_scheduling_id = sp.package_scheduling_id) end_date
				from pl.pl_scheduling_package sp
				inner join pl.pl_training_type tt 
					on tt.training_type_id = sp.training_type
				inner join pl.pl_participant_type pt 
					on pt.participant_type_id = sp.participant_type
					where sp.daftar_hadir='false'
				order by start_date desc, end_date desc";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPaketPelatihanByID($id){
		$sql = "select 	sp.package_scheduling_name, 
						case when st.scheduling_name like '%-%' then
							case when split_part(st.scheduling_name,'-',1) like '%(%' then
								split_part(st.scheduling_name,'(',1)
							else
								split_part(st.scheduling_name,'-',1)
							end
						else
							st.scheduling_name
						end 
						scheduling_name,
						to_char(st.\"date\",'mon dd, yyyy') \"date\",
						st.room,
						mt.trainer_name
				from pl.pl_scheduling_package sp 
				inner join pl.pl_scheduling_training st 
					on sp.package_scheduling_id = st.package_scheduling_id
				inner join pl.pl_master_trainer mt 
					on mt.trainer_id = cast(st.trainer as int)
				where sp.package_scheduling_id = $id 
				order by 	st.\"date\",
							st.training_id;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPesertaPaketPelatihanByID($id){
		$sql = "select  distinct spc.noind, 
						emall.employee_name, 
						case when sec.section_name = '-' then
							sec.unit_name
						else
							sec.section_name
						end as seksi
				from pl.pl_scheduling_package sp 
				inner join pl.pl_scheduling_training st 
					on sp.package_scheduling_id = st.package_scheduling_id
				inner join pl.pl_participant spc 
					on spc.scheduling_id = st.scheduling_id
				inner join pl.pl_master_trainer mt 
					on mt.trainer_id = cast(st.trainer as int)
				inner join er.er_employee_all emall 
					on emall.employee_code = spc.noind
				inner join er.er_section sec 
					on emall.section_code = sec.section_code
				where sp.package_scheduling_id = $id
				order by spc.noind;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getTrainerPaketPelatihanByID($id){
		$sql = "select distinct mt.trainer_name
				from pl.pl_scheduling_package sp 
				inner join pl.pl_scheduling_training st 
					on sp.package_scheduling_id = st.package_scheduling_id
				inner join pl.pl_master_trainer mt 
					on mt.trainer_id = cast(st.trainer as int)
				where sp.package_scheduling_id = $id
				order by mt.trainer_name;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}



	public function getPelatihan(){
		$sql = "select  st.scheduling_name, 
						st.scheduling_id, 
						pt.participant_type_description,
						st.room,
						mt.trainer_name, 
						st.\"date\", 
						st.start_time, 
						st.end_time,
						st.participant_number
				from pl.pl_scheduling_training st
				inner join pl.pl_participant_type pt 
					on pt.participant_type_id = st.participant_type
				inner join pl.pl_master_trainer mt
					on mt.trainer_id = cast(st.trainer as int)
				where package_scheduling_id = '0' and daftar_hadir ='false'
				order by st.\"date\" desc, st.start_time desc, st.end_time desc";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function hilang($id){
		$sql = "update pl.pl_scheduling_training 
                set daftar_hadir='true'
                where scheduling_id = '$id'";

		$result = $this->db->query($sql);
	}

	public function hilangpaket($id){
		$sql = "update pl.pl_scheduling_package 
                set daftar_hadir='true'
                where package_scheduling_id = '$id'";

		$result = $this->db->query($sql);
	}


	public function getPelatihanByID($id){
		$sql = "select  st.scheduling_name, 
						st.scheduling_id, 
						pt.participant_type_description,
						st.room,
						mt.trainer_name, 
						to_char(st.\"date\",'mon dd, yyyy') \"date\", 
						to_char(cast(start_time as time),'HH24.MI') start_time,
						to_char(cast(end_time as time),'HH24.MI') end_time,
						st.participant_number
				from pl.pl_scheduling_training st
				inner join pl.pl_participant_type pt 
					on pt.participant_type_id = st.participant_type
				inner join pl.pl_master_trainer mt
					on mt.trainer_id = cast(st.trainer as int)
				where st.scheduling_id = '$id'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getPesertaPelatihanByID($id){
		$sql = "select ea.employee_code noind,
				ea.employee_name,
				case when es.section_name = '-' then
					case when es.unit_name = '-' then
						es.department_name
					else
						es.unit_name
					end
				else
					es.section_name 
				end seksi
				from pl.pl_participant pp
				inner join er.er_employee_all	ea	
					on ea.employee_code = pp.noind
				inner join er.er_section es
					on es.section_code = ea.section_code
				where pp.scheduling_id = $id
				order by ea.employee_code;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	//Ambil Data Penjadwalan dari Record Tertentu
	public function GetRecordId($id){
		$sql = "
			SELECT 
 				a.scheduling_id,
 				a.package_scheduling_id,
 				a.package_training_id,
 				a.training_id,
 				c.training_name,
 					case when a.date
  					is NULL then null 	
  					else to_char(a.date, 'DD/MM/YYYY')
  					end as date_foredit,
 				a.scheduling_name,
  					case when a.date
  					is NULL then null 	
  					else to_char(a.date, 'DD Month YYYY')
  					end as date_format,
 				a.start_time,
 				a.end_time,
 				a.room,
 				d.participant_type_description,
 				a.evaluation,
 				a.sifat,
 				a.trainer,
 				a.participant_number,
 				a.status,
 				c.limit_1,
 				c.limit_2
	
				from pl.pl_scheduling_training a
				left join pl.pl_master_training c on a.training_id = c.training_id
				left join pl.pl_participant_type d on a.participant_type = d.participant_type_id
				where a.scheduling_id='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function GetEvaluationType()
		{
			$sql = "select * from pl.pl_evaluation_type where (evaluation_type_id=2 or evaluation_type_id=3)";
			$query=$this->db->query($sql);
			return $query->result_array();
		}
	//Ambil data Objective tujuan pelatihan dari Record Tertentu
	public function GetObjectiveId($id){
		$sql = " SELECT * from pl.pl_master_training_purpose where training_id='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

		//Ambil tipe Training
	public function GetTrainingType($id){
		$sql = " SELECT status from pl.pl_master_training where training_id='$id'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	//Ambil data Peserta dari Record Tertentu
	public function GetParticipantId($id){
		$sql = " SELECT * from pl.pl_participant where scheduling_id='$id' order by participant_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Ambil data Trainer Lengkap
	public function GetTrainer(){
		$sql = "SELECT * from pl.pl_master_trainer order by trainer_status DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//AMBIL DATA DAFTAR PELATIHAN YANG ADA DALAM SUATU PAKET
	public function GetPackageIdNumber($id){
			$sql = "
				select package_id
				from pl.pl_scheduling_package
				where package_scheduling_id=$id";
			$query = $this->db->query($sql);
			return $query->result();
	}

	//AMBIL DAFTAR PELATIHAN UNTUK PAKET PELATIHAN DENGAN NOMOR SPESIFIK
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

		//AMBIL DATA PENJADWALAN PELATIHAN YANG SESUAI DENGAN PENJADWALAN PAKET
		public function GetScheduledTraining($id){
			$sql = " select * from pl.pl_scheduling_training where package_scheduling_id=$id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

}
?>