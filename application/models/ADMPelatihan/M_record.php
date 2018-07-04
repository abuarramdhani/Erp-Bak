<?php
class M_record extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->quickcom_orientasi = $this->load->database('quickcom_orientasi', TRUE);
    }
		
	//Ambil Data Penjadwalan Untuk Index
	public function GetRecordPackage($id){
		$sql = "
			SELECT
			a.scheduling_id,
			a.package_scheduling_id,
			a.scheduling_name,
			a.date,
			a.room,
			a.participant_type,
			a.trainer,
			a.evaluation,
			a.sifat,
			a.participant_number,
			a.status,
			b.package_scheduling_name,
			case when b.start_date
				is NULL then null 	
				else to_char(b.start_date,'DD MONTH YYYY')
				end as start_date_format,
			case when b.end_date
				is NULL then null 	
				else to_char(b.end_date,'DD MONTH YYYY')
				end as end_date_format,
			case when a.date
				is NULL then null 	
				else to_char(a.date,'DD MONTH YYYY')
				end as date_format,
			case when a.date < now()::date
				and a.status is null
				then 1
				end as tidak_terlaksana
			from pl.pl_scheduling_training a
			left join pl.pl_scheduling_package b on a.package_scheduling_id = b.package_scheduling_id
			where (a.date >= now()::date or a.status = null or a.date < now()::date)
			and a.package_scheduling_id=$id
			and a.status is null
			order by a.date asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//ambil untuk index---------------------------------------------------------------------
	public function paket()
	  {
	    $sql = "SELECT
	              *
	            from
	              pl.pl_scheduling_package b ";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	  }

	  public function paketdetail($id)
	  {
	  	$sql = "SELECT
	              *
	            from
	              pl.pl_scheduling_package b 
	            where b.package_scheduling_id=$id";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	  }

	  public function pelatihan()
	  {
	    $sql = "SELECT
	              a.scheduling_id,
	              a.package_scheduling_id,
	              a.scheduling_name,
	              a.date,
	              a.room,
	              a.participant_type,
	              a.trainer,
	              a.evaluation,
	              a.sifat,
	              a.participant_number,
	              a.status,
	              b.package_scheduling_name,
	              case
	                when b.start_date is null then null
	                else to_char(
	                  b.start_date,
	                  'DD MONTH YYYY'
	                )
	              end as start_date_format,
	              case
	                when b.end_date is null then null
	                else to_char(
	                  b.end_date,
	                  'DD MONTH YYYY'
	                )
	              end as end_date_format,
	              case
	                when a.date is null then null
	                else to_char(
	                  a.date,
	                  'DD MONTH YYYY'
	                )
	              end as date_format,
	              case
	                when a.date < now()::date
	                and a.status is null then 1
	              end as tidak_terlaksana
	            from
	              pl.pl_scheduling_training a left join pl.pl_scheduling_package b on
	              a.package_scheduling_id = b.package_scheduling_id
	            where
	            a.status isnull
	            and
	              (
	                a.date >= now()::date
	                or a.status = null
	                or a.date < now()::date
	              )
	            order by
	              a.date asc";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	    // return $sql;
	  }
	//ambil untuk index------------------------------------------------------------------------


	//Ambil Data Penjadwalan Untuk Finished
	//ambil untuk index finished--------------------------------------------------------------------------------
	public function paketdetailfinish($id)
	  {
	  	$sql = "SELECT
	              *
	            from
	              pl.pl_scheduling_package b 
	            where b.package_scheduling_id=$id";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	  }

	public function GetRecordFinished($id){
		$sql = "
			SELECT
			a.scheduling_id,
			a.package_scheduling_id,
			a.scheduling_name,
			a.date,
			a.room,
			a.participant_type,
			a.trainer,
			a.evaluation,
			a.sifat,
			a.participant_number,
			a.status,
			b.package_scheduling_name,
			case when b.start_date
				is NULL then null 	
				else to_char(b.start_date,'DD MONTH YYYY')
				end as start_date_format,
			case when b.end_date
				is NULL then null 	
				else to_char(b.end_date,'DD MONTH YYYY')
				end as end_date_format,
			case when a.date
				is NULL then null 	
				else to_char(a.date,'DD MONTH YYYY')
				end as date_format,
			case when a.date < now()::date
				and a.status is null
				then 1
				end as tidak_terlaksana
			from pl.pl_scheduling_training a
			left join pl.pl_scheduling_package b on a.package_scheduling_id = b.package_scheduling_id
			where a.status = 1
			and a.package_scheduling_id=$id
			order by a.status asc, a.date desc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function GetRecordFinished1(){
		$sql = "
			 SELECT
			  a.scheduling_id,
			  a.package_scheduling_id,
			  a.scheduling_name,
			  a.date,
			  a.room,
			  a.participant_type,
			  a.trainer,
			  a.evaluation,
			  a.sifat,
			  a.participant_number,
			  a.status,
			  b.package_scheduling_name,
			  case
			    when b.start_date is null then null
			    else to_char(
			      b.start_date,
			      'DD MONTH YYYY'
			    )
			  end as start_date_format,
			  case
			    when b.end_date is null then null
			    else to_char(
			      b.end_date,
			      'DD MONTH YYYY'
			    )
			  end as end_date_format,
			  case
			    when a.date is null then null
			    else to_char(
			      a.date,
			      'DD MONTH YYYY'
			    )
			  end as date_format,
			  case
			    when a.date < now()::date
			    and a.status is null then 1
			  end as tidak_terlaksana
			from
			  pl.pl_scheduling_training a left join pl.pl_scheduling_package b on
			  a.package_scheduling_id = b.package_scheduling_id
			where
			  (
			    a.date >= now()::date
			    or a.date < now()::date
			  )
			and a.status = 1
			order by
			  a.date asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	//ambil untuk index finished--------------------------------------------------------------------------------

	public function FilterRecord($start,$end,$status){
		$d_parameter="date >= now()::date";
		$s_parameter="AND status = 0";
		if($status==1){
			$d_parameter="a.date < now()::date";
			$s_parameter="OR a.status = 1";
		}
		$sql = "
			SELECT
			a.scheduling_id,
			a.package_scheduling_id,
			a.scheduling_name,
			a.date,
			a.room,
			a.participant_type,
			a.trainer,
			a.evaluation,
			a.sifat,
			a.participant_number,
			a.status,
			b.package_scheduling_name,
			case when b.start_date
				is NULL then null 	
				else to_char(b.start_date,'DD MONTH YYYY')
				end as start_date_format,
			case when b.end_date
				is NULL then null 	
				else to_char(b.end_date,'DD MONTH YYYY')
				end as end_date_format,
			case when a.date
				is NULL then null 	
				else to_char(a.date,'DD MONTH YYYY')
				end as date_format,
			case when a.date < now()::date
				and a.status is null
				then 1
				end as tidak_terlaksana
			from pl.pl_scheduling_training a
			left join pl.pl_scheduling_package b on a.package_scheduling_id = b.package_scheduling_id
			where a.date between TO_DATE('$start', 'DD/MM/YYYY') and TO_DATE('$end', 'DD/MM/YYYY')
			and ($d_parameter $s_parameter)
			order by a.date asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetTrainingId($id){
			$sql = "SELECT * from pl.pl_master_training	where training_id = $id";
			$query = $this->db->query($sql);
			return $query->result_array();
		} 
	public function GetEvaluationType()
		{
			$sql = "SELECT * from pl.pl_evaluation_type";
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
	public function GetParticipantPid($pid){
		$sql = " select a.* 
				from pl.pl_participant a
				inner join pl.pl_scheduling_training b on a.scheduling_id=b.scheduling_id 
				where b.package_scheduling_id='$pid' order by participant_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function GetParticipantPidName($pid){
		$sql = " select a.participant_name,  a.noind, a.status
				from pl.pl_participant a
				inner join pl.pl_scheduling_training b on a.scheduling_id=b.scheduling_id 
				where b.package_scheduling_id=$pid
				and a.status = 1
				group by a.participant_name,2,3
				order by participant_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Ambil data Peserta dari Record Tertentu
	public function GetApplicantDataId($id){
		$sql = " SELECT * from pl.pl_tberkas where kodelamaran='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Ambil data Peserta dari Record Tertentu
	public function GetEmployeeByNIK($NIK){
		$sql = " SELECT * from pr.pr_master_pekerja where NIK='$NIK'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetEmployeeData($id){
			$sql = "
				SELECT employee_code, employee_name
				from er.er_employee_all
				where employee_code='$id'";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

	//Ambil data Peserta dari Record Tertentu
	public function UpdateParticipantNoind($applicant_number,$noind){
		$sql = " update pl.pl_participant set noind='$noind' where noapplicant='$applicant_number'";
		$query = $this->db->query($sql);
		return;
	}

	public function AddParticipant($data){
			return $this->db->insert('pl.pl_participant', $data);
		}

	//MENGHAPUS DATA PENJADWALAN
	public function DeleteSchedule($id){
		$sql = "delete from pl.pl_scheduling_training where scheduling_id='$id'";
		$query = $this->db->query($sql);
		return;
	}

	//MENGHAPUS DATA PARTISIPAN DARI PENJADWALAN TERTENTU
	public function DeleteScheduleParticipant($id){
		$sql = "delete from pl.pl_participant where scheduling_id='$id'";
		$query = $this->db->query($sql);
		return;
	}

	//MENGHAPUS DATA TUJUAN DARI PELATIHAN TERTENTU
	public function DeleteScheduleObjective($id){
		$sql = "delete from pl.pl_objective where scheduling_id='$id'";
		$query = $this->db->query($sql);
		return;
	}

	public function deleteParticipant($pid,$schID)
	{
		$sql="	delete from pl.pl_participant
				where scheduling_id='$schID' and participant_id='$pid'";
		$query= $this->db->query($sql);
	}

	//Ambil data Trainer Lengkap
	public function GetTrainer(){
		$sql = "SELECT * from pl.pl_master_trainer order by trainer_status DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//Konfirmasi Pelaksanaan
	public function DoConfirmSchedule($number,$data){
		$this->db->where('scheduling_id', $number);
		$this->db->update('pl.pl_scheduling_training', $data);
	}

	public function UpdateSchedule($kirim, $id)
	{
		$this->db->where('scheduling_id', $id);
		$this->db->update('pl.pl_scheduling_training', $kirim);
	}

	//Konfirmasi Kehadiran
	public function DoConfirmParticipant($id,$data){
		$this->db->where('participant_id', $id);
		$this->db->update('pl.pl_participant', $data);
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

	public function GetScoreO($noindPtc,$schName,$tgl)
	{
		$sql 	 = "SELECT 	
					rex.nama,rex.id_num, rex.result, rex.kategori, rex.time_record
					FROM	db_orientasi.result_exam rex
					where rex.id_num='$noindPtc'
					and rex.kategori='$schName'
					and rex.status =''
					and rex.time_record=STR_TO_DATE('$tgl', '%d/%m/%Y')
					";
		$query = $this->quickcom_orientasi->query($sql);
		return $query->result_array();
	}

	public function GetScoreS($pid)
	{
		$sql 	 = "SELECT	pp.scheduling_id,pst.scheduling_name, pp.noind, pp.participant_name, pst.date, pp.score_eval2_post
					from 	pl.pl_participant pp,
							pl.pl_scheduling_training pst
					where	pp.scheduling_id=pst.scheduling_id
					and		pst.package_training_id = '$pid'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function UpdateScore($id_num,$nama,$kategori,$time_record,$result){
		$sql = "	update
						pl.pl_participant
					set
						score_eval2_post = $result
					where
						participant_id =(
							SELECT
								pp.participant_id
							from
								pl.pl_participant pp,
								pl.pl_scheduling_training pst
							where
								pp.scheduling_id = pst.scheduling_id
								and pst.scheduling_name = replace('$kategori','  ','')
								and pp.participant_name like '%$nama%'
								and pp.noind = '$id_num'
								and pst.date = to_timestamp('$time_record', 'YYYY-MM-DD')
						)
				";
		$query = $this->db->query($sql);
		return;
	}

	public function GetQueSheet()
	{
		$sql="	select *
				from	pl.pl_questionnaire_sheet";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function cekNumRowQuestRecord($scheduling_id)
	{
		$sql="	select *
				from		pl.pl_questionnaire_sheet a
				inner join	pl.pl_scheduling_training b on a.scheduling_id=b.scheduling_id
				where a.scheduling_id=$scheduling_id
				order by a.scheduling_id ASC";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function GetParticipant()
	{
		$sql="select *
				from pl.pl_participant pp
				inner join pl.pl_scheduling_training pst on pp.scheduling_id=pst.scheduling_id";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
}
?>