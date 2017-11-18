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

	public function GetSeksi($term){
		if ($term === FALSE) {
			$iftermtrue = "";
		}else{
			$iftermtrue = "WHERE (section_name ILIKE '%$term%')";}
		
		$sql = "
				select section_name 
				from er.er_section $iftermtrue
				group by section_name
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetTrainingPrtcp($id,$section)
	{
		$sql = "with seksi as(
				select e.employee_code, e.employee_name, d.section_name
				from er.er_employee_all e
				left join er.er_section d
				on e.section_code = d. section_code
				)
				select
					section_name,
					a.participant_number,
					a.scheduling_name,
					a.scheduling_id,
					to_char(a.date, 'YYYY') as tahun,
					b.participant_name
				from pl.pl_scheduling_training a
								left join  pl.pl_participant b on a.scheduling_id = b.scheduling_id
								join seksi on b.noind = seksi.employee_code
				where a.scheduling_id = '$id' and section_name like '%$section%'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetReport1($name){
		$sql = "
			with seksi as(
				select e.employee_code, e.employee_name, d.section_name
				from er.er_employee_all e
				left join er.er_section d
				on e.section_code = d. section_code
				)
			select case when a.score_eval2_post>=
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
									(case when substring(b.standar_kelulusan,0,3) is null or
								 	substring(b.standar_kelulusan,0,3) = '' then '0' else substring(b.standar_kelulusan,0,3) end)	
								as int)
								else cast(
									(case when substring(b.standar_kelulusan,4,3) is null or 
									substring(b.standar_kelulusan,4,3) = '' then '0' else substring(b.standar_kelulusan,4,3) end)
								as int)end) 
							then 1
							else 0 
						end as lulus,
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
				,seksi.section_name
				,b.scheduling_name
			from pl.pl_participant a
				left join pl.pl_scheduling_training b on a.scheduling_id = b.scheduling_id
				join seksi on a.noind = seksi.employee_code
			where a.participant_name like '%$name%'
			order by b.date desc";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetReport2($year = FALSE,$section = FALSE)
	{
		if ($year==FALSE) {
			$p='';
		}else{
			$p="and to_char(pst.date,'YYYY')='$year'";
		}
		if ($section==FALSE) {
			$s='';
		}else{
			$s="and es.section_name like '%$section%'";
		}
		$sql="	select	section_name, jumlah.jml, jumlah.nama, jumlah.tahun,jumlah.scheduling_id
				from	
				er.er_section es,
				(select 
							pea.section_code,
							pst.scheduling_name as nama,
							to_char(pst.date,'YYYY')as tahun,
							pst.scheduling_id,
							count(pp.participant_name)as jml
							from	pl.pl_participant pp,
									er.er_employee_all pea,
									pl.pl_scheduling_training pst
							where
							pp.noind = pea.employee_code
							and
							pp.scheduling_id=pst.scheduling_id
							$p
							group by pea.section_code, pst.scheduling_name, 3,4) as jumlah
				where jumlah.jml is not null
				and jumlah.section_code = es.section_code
				$s
				group by section_name,es.section_code,2,3,4,5";
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
	
	// REKAP TRAINING
	public function GetRkpTraining($date1,$date2)
	{	
		$sql=" with status
				 as
					(
					select a.scheduling_id
							,case when a.status = 1 then 1 else 0 end as terlaksana
							,case when a.status is null then 1 else 0 end as belum
					from 	pl.pl_scheduling_training a
					)
					SELECT	a.scheduling_id,
							scheduling_name,
							case when a.date
							is null then null
							else extract(year from date) end as yyyy,
							to_char(a.date,'DD MONTH YYYY') as training_date,
							(to_char(a.date, 'MONTH')) as bulan,
							(case when st.terlaksana = '1' then 1 else 0 end) persentase_terlaksana,
							(case when st.belum = '1' then 1 else 0 end) persentase_belum,
							a.sifat
					FROM status st
					inner join pl.pl_scheduling_training a
					on a.scheduling_id = st.scheduling_id
					where a.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY')
					group by 1,2,3,4,5,6,7,8
					order by 3,5 DESC";
			$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function GetRkpTrainingAll($date1,$date2)
	{	
		$sql="with status
				 as
					(
					select a.scheduling_id
							,case when a.status = 1 then 1 else 0 end as terlaksana
							,case when a.status is null then 1 else 0 end as belum
					from 	pl.pl_scheduling_training a
					)
				select
					sum(st.terlaksana)terlaksana,
					sum(st.belum)belum_terlaksana,
					(ROUND((cast((sum(st.terlaksana)) as decimal) / cast((count(st.terlaksana)) as decimal) * 100), 0) || ' %') persentase_terlaksana,
					(ROUND((cast((sum(st.belum)) as decimal) / cast((count(st.belum)) as decimal) * 100), 0) || ' %') persentase_belum
				from status st
					inner join pl.pl_scheduling_training pst
						on pst.scheduling_id = st.scheduling_id
				where 	pst.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY')";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	public function GetSifat($date1,$date2)
	{	
		$sql="	with sifat
				 as
					(
					select a.scheduling_id,
							case when (a.sifat=1 and status = '1') then 1 else 0 end as order_terlaksana,
							case when (a.sifat=1 and status is null) then 1 else 0 end as order_bl_terlaksana,
							case when (a.sifat=2 and status = '1') then 1 else 0 end as tahunan_terlaksana,
							case when (a.sifat=2 and status is null) then 1 else 0 end as tahunan_bl_terlaksana
					from 	pl.pl_scheduling_training a
					)
				select
					(to_char(pst.date, 'MONTH')) as bulan,
					extract(year from date) as yyyy,
					(to_char(pst.date, 'YYYY')) as tahun,
					to_char(to_date('$date1', 'DD/MM/YYYY'), 'DD MONTH YYYY') as tanggal1,
					to_char(to_date('$date2', 'DD/MM/YYYY'), 'DD MONTH YYYY') as tanggal2,
					sum(st.order_terlaksana)order_terlaksana,
					sum(st.order_bl_terlaksana)order_bl_terlaksana,
					sum(st.tahunan_terlaksana)tahunan_terlaksana,
					sum(st.tahunan_bl_terlaksana)tahunan_bl_terlaksana,
					ROUND(
						   (
							cast((sum(st.order_terlaksana)) as decimal) 
							/ cast(sum(st.order_terlaksana) + sum(st.order_bl_terlaksana) as decimal)
						* 100), 0) || ' %' 
					as persentase_order_terlaksana,
					ROUND(
						   (
							cast((sum(st.order_bl_terlaksana)) as decimal) 
							/ cast(sum(st.order_terlaksana) + sum(st.order_bl_terlaksana) as decimal)
						* 100), 0) || ' %' 
					as persentase_order_bl_terlaksana,
					ROUND(
						   (
							cast((sum(st.tahunan_terlaksana)) as decimal) 
							/ cast(sum(st.tahunan_terlaksana) + sum(st.tahunan_bl_terlaksana) as decimal)
						* 100), 0) || ' %' 
					as persentase_tahunan_terlaksana,
					ROUND(
						   (
							cast((sum(st.tahunan_bl_terlaksana)) as decimal) 
							/ cast(sum(st.tahunan_terlaksana) + sum(st.tahunan_bl_terlaksana) as decimal)
						* 100), 0) || ' %' 
					as persentase_tahunan_bl_terlaksana
				from sifat st
					inner join pl.pl_scheduling_training pst
						on pst.scheduling_id = st.scheduling_id
				where 	pst.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY')
				group by 1,2,3
				order by yyyy,bulan DESC
				";

		$sql2 = "with sifat
				 as
					(
					select a.scheduling_id,
							case when (a.sifat=1 and status = '1') then 1 else 0 end as order_terlaksana,
							case when (a.sifat=1 and status is null) then 1 else 0 end as order_bl_terlaksana,
							case when (a.sifat=2 and status = '1') then 1 else 0 end as tahunan_terlaksana,
							case when (a.sifat=2 and status is null) then 1 else 0 end as tahunan_bl_terlaksana
					from 	pl.pl_scheduling_training a
					)
				select
					(to_char(pst.date, 'MONTH')) as bulan,
					extract(year from date) as yyyy,
					(to_char(pst.date, 'YYYY')) as tahun,
					to_char(to_date('$date1', 'DD/MM/YYYY'), 'DD MONTH YYYY') as tanggal1,
					to_char(to_date('$date2', 'DD/MM/YYYY'), 'DD MONTH YYYY') as tanggal2,
					sum(st.order_terlaksana)order_terlaksana,
					sum(st.order_bl_terlaksana)order_bl_terlaksana,
					sum(st.tahunan_terlaksana)tahunan_terlaksana,
					sum(st.tahunan_bl_terlaksana)tahunan_bl_terlaksana,
					(case when sum(st.order_terlaksana) = 0 then 0 else
						(
							ROUND(
						   (
							cast((sum(st.order_terlaksana)) as decimal) 
							/ cast(sum(st.order_terlaksana) + sum(st.order_bl_terlaksana) as decimal)
						* 100), 0)
						)
					end) || ' %' 
					as persentase_order_terlaksana,
					(case when sum(st.order_bl_terlaksana) = 0 then 0 else
						(
							ROUND(
						   (
							cast((sum(st.order_bl_terlaksana)) as decimal) 
							/ cast(sum(st.order_terlaksana) + sum(st.order_bl_terlaksana) as decimal)
						* 100), 0)
						)
					end) || ' %' 
					as persentase_order_bl_terlaksana,
					(case when sum(st.tahunan_terlaksana) = 0 then 0 else
						(
							ROUND(
						   (
							cast((sum(st.tahunan_terlaksana)) as decimal) 
							/ cast(sum(st.tahunan_terlaksana) + sum(st.tahunan_bl_terlaksana) as decimal)
						* 100), 0)
						)
					end) || ' %' 
					as persentase_tahunan_terlaksana,
					(case when sum(st.tahunan_bl_terlaksana) = 0 then 0 else
						(
							ROUND(
						   (
							cast((sum(st.tahunan_bl_terlaksana)) as decimal) 
							/ cast(sum(st.tahunan_terlaksana) + sum(st.tahunan_bl_terlaksana) as decimal)
						* 100), 0)
						)
					end) || ' %' 
					as persentase_tahunan_bl_terlaksana
				from sifat st
					inner join pl.pl_scheduling_training pst
						on pst.scheduling_id = st.scheduling_id
				where 	pst.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY')
				group by 1,2,3
				order by yyyy,bulan DESC";
		$query=$this->db->query($sql2);
		return $query->result_array();
				// return $sql;
	}

	// PERSENTASE KEHADIRAN PESERTA
	public function GetPercentParticipant($date1,$date2)
	{	
		$sql="	with
					kehadiran
						as
						( 	
							select  pc.scheduling_id,
									pc.participant_name,
									case when pc.status='1' then 1 else null end as hadir,
									case when pc.status='2' then 1 else null end as tdkhadir,
									case when pc.status='0' then 1 else null end as belumtraining
							from	pl.pl_participant pc
						)
				select	(to_char(pst.date, 'MONTH'))as bulan,
						(to_char(pst.date, 'YYYY'))as tahun,
						extract(year from date) as yyyy,
						pst.scheduling_id,
						pst.participant_number,
						count(hdr.hadir)as hadir,
						count(hdr.tdkhadir)as tdkhadir,
						count(hdr.belumtraining)as belumtraining,
						(ROUND((cast((sum(hdr.hadir)) as decimal) / cast((count(pst.participant_number)) as decimal) * 100), 0) || ' %') persentase_kehadiran,
						pst.scheduling_name
				from	pl.pl_scheduling_training pst
				join	kehadiran hdr on pst.scheduling_id=hdr.scheduling_id
				where pst.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY')
				group by 1,2,3,4,5,10
				order by yyyy,bulan DESC";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function GetPercentParticipantAll($date1,$date2)
	{	
		$sql="with
					kehadiran
						as
						( 	
							select  pc.scheduling_id,
									pc.participant_name,
									case when pc.status='1' then 1 else null end as hadir,
									case when pc.status='2' then 1 else null end as tdkhadir,
									case when pc.status='0' then 1 else null end as belumtraining
							from	pl.pl_participant pc
						)				
				select	
						count(pst.participant_number)jumlah,
						count(hdr.hadir)as hadir,
						(ROUND((cast((sum(hdr.hadir)) as decimal) / cast(count(pst.participant_number) as decimal) * 100),0) || '%')persentase_hadir_total
				from	pl.pl_scheduling_training pst
						join	kehadiran hdr on pst.scheduling_id=hdr.scheduling_id
				where 	pst.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY')";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	// EFEKTIFITAS TRAINING
	public function GetEfektivitasTraining($date1,$date2)
	{
		$sql="WITH Training_Stat
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
					a.training_type
					,a.scheduling_id
					,a.scheduling_name
					,a.participant_number
					,case when a.date
  					 is null then null
 					 else to_char(a.date,'DD MONTH YYYY')
					 end as training_date
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
						where c.scheduling_id=a.scheduling_id) as kelulusan,
					(select 
						sum(case when c.score_eval2_post<=
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
						where c.scheduling_id=a.scheduling_id) as ketidak_kelulusan
				from pl.pl_scheduling_training a
				left join Training_Stat b on a.scheduling_id=b.scheduling_id
				where a.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY')
				order by a.date asc";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function GetEfektivitasTrainingAll($date1,$date2)
	{
		$sql="with Training_Stat as(
					select
						scheduling_id,
						case
							when max( score_eval2_post ) is null then '0'
							else max( score_eval2_post )
						end as Nilai_Maximum,
						case
							when min( score_eval2_post ) is null then '0'
							else min( score_eval2_post )
						end as Nilai_Minimum,
						case
							when avg( score_eval2_post ) is null then '0'
							else round( avg( score_eval2_post ), 2 )
						end as Nilai_Rerata
					from
						pl.pl_participant
					group by
						scheduling_id
				) select
					tabel.*,
					round(( cast(( tabel.kelulusan ) as decimal )/ cast(( tabel.participant_number ) as decimal ))* 100, 0 )|| ' %' as persentase
				from
					(
						select
							a.training_type,
							b.scheduling_id,
							a.participant_number,
							case
								when a.date is null then null
								else to_char(
									a.date,
									'DD MONTH YYYY'
								)
							end as training_date,
							(to_char(a.date, 'MONTH'))as bulan,
							extract(year from date) as yyyy,
							(
								select
									sum( case when c.score_eval2_post >=( case when substring( noind, 0, 2 ) like 'B' or substring( noind, 0, 2 ) like 'D' or substring( noind, 0, 2 ) like 'J' or substring( noind, 0, 2 ) like 'G' or substring( noind, 0, 2 ) like 'L' or substring( noind, 0, 2 ) like 'Q' or substring( noind, 0, 2 ) like 'Z' then cast(( case when substring( d.standar_kelulusan, 0, 3 ) is null or substring( d.standar_kelulusan, 0, 3 )= '' then '0' else substring( d.standar_kelulusan, 0, 3 ) end ) as int ) else cast(( case when substring( d.standar_kelulusan, 4, 3 ) is null or substring( d.standar_kelulusan, 4, 3 )= '' then '0' else substring( d.standar_kelulusan, 4, 3 ) end ) as int ) end ) then 1 else 0 end ) as lulus
								from
									pl.pl_participant c left join pl.pl_scheduling_training d on
									c.scheduling_id = d.scheduling_id
								where
									c.scheduling_id = a.scheduling_id
							) as kelulusan
						from
							pl.pl_scheduling_training a left join Training_Stat b on
							a.scheduling_id = b.scheduling_id
						where
							a.date between TO_DATE(
								'$date1',
								'DD/MM/YYYY'
							) and TO_DATE(
								'$date2',
								'DD/MM/YYYY'
							)
						order by 6,5 DESC
					) as tabel";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	// AMBIL NAMA PELATIHAN
	public function GetSchName($year,$month)
	{
		$sql="	select	pst.scheduling_id,
						pst.scheduling_name
				from	pl.pl_scheduling_training pst
				where	REPLACE((to_char(pst.date, 'MONTH')), ' ', '') = '$month' and (to_char(pst.date, 'YYYY')) = '$year'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	//Ambil data Trainer Lengkap
	public function GetTrainer(){
		$sql = "select * from pl.pl_master_trainer order by trainer_status DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getYearTraining()
	{
		$sql 	 = "SELECT
						(to_char(pst.date, 'YYYY')) as tahun
					FROM pl.pl_scheduling_training pst
					group by tahun";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getMonthTraining()
	{
		$sql 	 = "SELECT REPLACE((to_char(pst.date, 'MONTH')), ' ', '') as bulan
					FROM pl.pl_scheduling_training pst
					group by bulan";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>