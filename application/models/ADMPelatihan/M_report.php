<?php
class M_report extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
		
	
//--------------------------------JAVASCRIPT RELATED--------------------------//	
	public function GetNoInduk($term){
		if ($term === FALSE) { $iftermtrue = "";
		}else{$iftermtrue = "and (employee_code ILIKE '%$term%' OR employee_name ILIKE '%$term%')";}
		
		$sql = "
				select *
				from er.er_employee_all
				where resign = '0' $iftermtrue
				order by employee_code ASC
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetReport1($name){
		$sql = "
			SELECT
				b.scheduling_name,
				case when b.date
					is NULL then null 	
					else to_char(b.date,'DD MONTH YYYY')
					end as date_format
				, a.score_eval2_post
				, (case when 
					substring(a.noind,1,1) like 'B' or 
					substring(a.noind,1,1) like 'D' or 
					substring(a.noind,1,1) like 'J' or 
					substring(a.noind,1,1) like 'G' or 
					substring(a.noind,1,1) like 'L' or 
					substring(a.noind,1,1) like 'Q' or 
					substring(a.noind,1,1) like 'Z'
				then substring(b.standar_kelulusan,0,3)
				else substring(b.standar_kelulusan,4,3)
				end) standar_kelulusan,
				a.*
			from pl.pl_participant a
				left join pl.pl_scheduling_training b on a.scheduling_id = b.scheduling_id
			where a.participant_name like '%$name%'
			order by b.date desc";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetReport3($date1,$date2){
		$sql = "
				WITH Training_Stat
					AS(
 						SELECT
  							 scheduling_id
  							,CASE WHEN MAX(score_eval2_post) IS NULL THEN '0' ELSE MAX(score_eval2_post) END as Nilai_Maximum
  							,CASE WHEN MIN(score_eval2_post) IS NULL THEN '0' ELSE MIN(score_eval2_post) END as Nilai_Minimum
  							,CASE WHEN AVG(score_eval2_post) IS NULL THEN '0' ELSE ROUND(AVG(score_eval2_post),2) END as Nilai_Rerata
 						from pl.pl_participant
						group by scheduling_id
					)
				SELECT
					 a.scheduling_id
					,a.scheduling_name
					,case when a.date
  					 is null then null
 					 else to_char(a.date,'DD MONTH YYYY')
					 end as training_date
					,a.trainer
					,a.participant_number
					,(select 
						sum(case when c.score_eval2_post>=
						(case when 
							substring(noind,0, 2) like 'B' or 
							substring(noind,0, 2) like 'D' or 
							substring(noind,0, 2) like 'J' or 
							substring(noind,0, 2) like 'G' or 
							substring(noind,0, 2) like 'L' or 
							substring(noind,0, 2) like 'Q' or 
							substring(noind,0, 2) like 'Z' 
							then 
								cast(
									(case when substring(d.standar_kelulusan,0,3) is null or
								 	substring(d.standar_kelulusan,0,3) = '' then '0' else substring(d.standar_kelulusan,0,3) end)	
								as int)
								else cast(
									(case when substring(d.standar_kelulusan,4,3) is null or 
									substring(d.standar_kelulusan,4,3) = '' then '0' else substring(d.standar_kelulusan,4,3) end)
								as int)end) 
							then 1
							else 0 
						end) as lulus
						from pl.pl_participant c
							left join pl.pl_scheduling_training d on c.scheduling_id=d.scheduling_id 
						where c.scheduling_id=a.scheduling_id) as kelulusan
					,b.Nilai_Maximum
					,b.Nilai_Minimum
					,b.Nilai_Rerata
				from pl.pl_scheduling_training a
				left join Training_Stat b on a.scheduling_id=b.scheduling_id
				where a.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY')
				order by a.date asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	//Ambil data Trainer Lengkap
	public function GetTrainer(){
		$sql = "select * from pl.pl_master_trainer order by trainer_status DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>