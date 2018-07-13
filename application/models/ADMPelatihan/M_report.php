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
	//ON CREATE////////////////////////////////////////////////////////////////////////////////////
	public function GetPelatihan($term){
		if ($term === FALSE) { $iftermtrue = "";
		}else{$iftermtrue = "where to_char(date, 'DD MM YYYY') ILIKE '%$term%'";}

		$sql = "select * from pl.pl_scheduling_training $iftermtrue";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetPelatihanNama($term){
		if ($term === FALSE) { $iftermtrue = "";
		}else{$iftermtrue = "where scheduling_name ILIKE '%$term%'";}

		$sql = "select scheduling_name from pl.pl_scheduling_training $iftermtrue group by scheduling_name";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetPelatihanPaket($term){
		if ($term === FALSE) { $iftermtrue = "";
		}else{$iftermtrue = "where to_char(b.start_date, 'DD MM YYYY') ILIKE '%$term%'";}

		$sql="	select a.* , b.*, b.start_date as tanggal
				from pl.pl_scheduling_training a
				join pl.pl_scheduling_package b 
					on a.package_scheduling_id=b.package_scheduling_id
				$iftermtrue";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function GetQueIdReportPaket($pid)
	{
		$sql="	select a.questionnaire_id, a.scheduling_id, b.date, b.scheduling_name
				from pl.pl_questionnaire_sheet a
				inner join pl.pl_scheduling_training b
				on a.scheduling_id=b.scheduling_id
				where b.package_scheduling_id=$pid
				group by questionnaire_id,2,3,4
				order by (b.date, a.scheduling_id) asc";
		$query=$this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}
	public function GetPelatihanPaketNama($term){
		if ($term === FALSE) { $iftermtrue = "";
		}else{$iftermtrue = "where package_scheduling_name ILIKE '%$term%'";}

		$sql="	select b.package_scheduling_name
				from pl.pl_scheduling_training a
				join pl.pl_scheduling_package b 
					on a.package_scheduling_id=b.package_scheduling_id
				$iftermtrue
				group by b.package_scheduling_name";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function GetDataPelatihan($nama,$tanggal,$idNama,$idTanggal){
		if ($idNama==1) {
			$ifP="and b.package_scheduling_name='$nama' and b.start_date = TO_DATE('$tanggal','DD/MM/YYYY')";
			$ifR="";
		}elseif($idNama==0){
			$ifR="and a.scheduling_name='$nama' and a.date = TO_DATE('$tanggal','DD/MM/YYYY')"; 
			$ifP="";
		}
		$sql = "
			select
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
			a.standar_kelulusan,
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
				end as date_format
			from pl.pl_scheduling_training a
			left join pl.pl_scheduling_package b on a.package_scheduling_id = b.package_scheduling_id
			where a.status = 1
			$ifP $ifR
			order by a.scheduling_id asc, a.date desc";
		$query = $this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}

	public function GetParticipantPelatihan($id)
	{
		$sql="SELECT count(participant_name) as jumlah from pl.pl_participant where scheduling_id='$id' and status=1 order by jumlah";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetPrtHadir($pid)
	{
		$sql="	SELECT 
				a.scheduling_id,
				count(a.participant_name) as jumlah
				from pl.pl_participant a
				inner join pl.pl_scheduling_training b on a.scheduling_id=b.scheduling_id 
				where
				a.status=1
				and
				b.package_scheduling_id='$pid'
				group by a.scheduling_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// public function GetpesertaPaket($package_scheduling_id)
	// {
	// 	$sql="select max(participant_number) from pl.pl_scheduling_training a where a.package_scheduling_id='$package_scheduling_id'";
	// 	$query = $this->db->query($sql);
	// 	return $query->result_array();
	// }
	//////////////////////////////////////////////////////////////////////////////////////////////

	public function GetTrainingFilter($term){
		if ($term === FALSE) { $iftermtrue = "";
		}else{$iftermtrue = "where training_name ILIKE '%$term%'";}
		
		$sql = "
				SELECT * FROM pl.pl_master_training $iftermtrue
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetTrainerFilter($term){
		if ($term === FALSE) { $iftermtrue = "";
		}else{$iftermtrue = "where trainer_name ILIKE '%$term%'";}
		
		$sql = "
				SELECT * from pl.pl_master_trainer $iftermtrue order by trainer_status DESC
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
			with 	seksi 	as	(
						select		e.employee_code,
									e.employee_name, 
									d.section_name
						from 		er.er_employee_all e
									left join	er.er_section d
												on e.section_code = d. section_code
					)
			select 		case 	when 	a.score_eval2_post
										>=
										(
											case 	when 	substring(noind,0, 2) in ('B', 'D', 'J', 'G', 'L', 'Q', 'Z')
															then 	(
																		(
																			case 	when 	substring(b.standar_kelulusan,0,3) is null 
																							or 	split_part(b.standar_kelulusan,',',1) = '' 
																							then '0' 
																					else 	split_part(b.standar_kelulusan,',',1) 
																			end
																		)::int	
																	)
													else 	(
																(
																	case 	when 	substring(b.standar_kelulusan,4,3) is null 
																					or 	split_part(b.standar_kelulusan,',',2) = ''
																					then '0' 
																			else 	split_part(b.standar_kelulusan,',',2) 
																	end
																)::int
															)
											end
										)
										then 	1
								when 	a.score_eval2_r1
										>=
										(
											case 	when 	substring(noind,0, 2) in ('B', 'D', 'J', 'G', 'L', 'Q', 'Z')
															then 	(
																		(
																			case 	when 	substring(b.standar_kelulusan,0,3) is null 
																							or 	split_part(b.standar_kelulusan,',',1) = '' 
																							then '0' 
																					else 	split_part(b.standar_kelulusan,',',1) 
																			end
																		)::int	
																	)
													else 	(
																(
																	case 	when 	substring(b.standar_kelulusan,4,3) is null 
																					or 	split_part(b.standar_kelulusan,',',2) = ''
																					then '0' 
																			else 	split_part(b.standar_kelulusan,',',2) 
																	end
																)::int
															)
											end
										)
										then 	1
								when 	a.score_eval2_r2
										>=
										(
											case 	when 	substring(noind,0, 2) in ('B', 'D', 'J', 'G', 'L', 'Q', 'Z')
															then 	(
																		(
																			case 	when 	substring(b.standar_kelulusan,0,3) is null 
																							or 	split_part(b.standar_kelulusan,',',1) = '' 
																							then '0' 
																					else 	split_part(b.standar_kelulusan,',',1) 
																			end
																		)::int	
																	)
													else 	(
																(
																	case 	when 	substring(b.standar_kelulusan,4,3) is null 
																					or 	split_part(b.standar_kelulusan,',',2) = ''
																					then '0' 
																			else 	split_part(b.standar_kelulusan,',',2) 
																	end
																)::int
															)
											end
										)
										then 	1
								when 	a.score_eval2_r3
										>=
										(
											case 	when 	substring(noind,0, 2) in ('B', 'D', 'J', 'G', 'L', 'Q', 'Z')
															then 	(
																		(
																			case 	when 	substring(b.standar_kelulusan,0,3) is null 
																							or 	split_part(b.standar_kelulusan,',',1) = '' 
																							then '0' 
																					else 	split_part(b.standar_kelulusan,',',1) 
																			end
																		)::int	
																	)
													else 	(
																(
																	case 	when 	substring(b.standar_kelulusan,4,3) is null 
																					or 	split_part(b.standar_kelulusan,',',2) = ''
																					then '0' 
																			else 	split_part(b.standar_kelulusan,',',2) 
																	end
																)::int
															)
											end
										)
										then 	1
								else 	0 
						end as lulus,
						to_char(b.date,'DD MONTH YYYY') as date_format, 
						a.score_eval2_post,
						a.score_eval2_r1,
						a.score_eval2_r2,
						a.score_eval2_r3,
						(
							case 	when 	substring(noind,0, 2) in ('B', 'D', 'J', 'G', 'L', 'Q', 'Z')
											then 	split_part(b.standar_kelulusan,',',1)
									else 	split_part(b.standar_kelulusan,',',2)
							end
						) standar_kelulusan,
						a.*,
						seksi.section_name,
						b.scheduling_name
			from 		pl.pl_participant a
						left join 	pl.pl_scheduling_training b 
									on a.scheduling_id = b.scheduling_id
						join 		seksi 
									on a.noind = seksi.employee_code
			where 		a.participant_name like '%$name%'
			order by 	b.date desc";
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
		$sql="	select	es.section_name, jumlah.jml, jumlah.nama, jumlah.tahun,jumlah.scheduling_id
				from	
				er.er_section es,
				(
					select 
							ees.section_name,
							pst.scheduling_name as nama,
							to_char(pst.date,'YYYY')as tahun,
							pst.scheduling_id,
							count(pp.participant_name)as jml
							from	pl.pl_participant pp,
									er.er_employee_all pea,
									er.er_section ees,
									pl.pl_scheduling_training pst
							where
								pp.noind = pea.employee_code
								and ees.section_code = pea.section_code
								and pp.scheduling_id=pst.scheduling_id
							$p
							group by
								ees.section_name,
								pst.scheduling_name,
								3,
								4
							) as jumlah
				where jumlah.jml is not null
				and jumlah.section_name = es.section_name
				$s
				group by es.section_name,2,3,4,5;";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetReport3($date1,$date2){
		$sql = "
				with Training_Stat as(
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
				a.scheduling_id,
				a.scheduling_name,
				case
					when a.date is null then null
					else to_char(
						a.date,
						'DD MONTH YYYY'
					)
				end as training_date,
				a.trainer,
				a.participant_number,
				(
					select
						sum( case when c.score_eval2_post >=( case when substring( noind, 1, 1 ) in( 'B', 'D', 'J', 'G', 'L', 'Q', 'Z' ) then cast(( case when split_part( d.standar_kelulusan, ',', 1 ) is null or split_part( d.standar_kelulusan, ',', 1 )= '' then '0' else split_part( d.standar_kelulusan, ',', 1 ) end ) as int ) else cast(( case when split_part( d.standar_kelulusan, ',', 2 ) is null or split_part( d.standar_kelulusan, ',', 2 )= '' then '0' else split_part( d.standar_kelulusan, ',', 2 ) end ) as int ) end ) then 1 else 0 end ) as lulus
					from
						pl.pl_participant c left join pl.pl_scheduling_training d on
						c.scheduling_id = d.scheduling_id
					where
						c.scheduling_id = a.scheduling_id
				) as kelulusan,
				b.Nilai_Maximum,
				b.Nilai_Minimum,
				b.Nilai_Rerata,
				a.package_scheduling_id
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
			order by
				a.date asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// AMBIL DATA CUSTOM REPORT
	public function GetReportCustom($judul=FALSE , $tgl1=FALSE , $tgl2 ,$seksi=FALSE ,$namapkj=FALSE )
	{	
		// KONDISI-------------------------------------------------------------------------------------------
		if ($judul==FALSE) {
			$j='';
		}else{
			$j="and jumlah.nama_pelatihan like '$judul%'";
		}
		// --------------------------------------------------
		if ($tgl1==TRUE) {
			$t="and jumlah.tanggal between TO_DATE('$tgl1','MM/DD/YYYY') and TO_DATE('$tgl2','MM/DD/YYYY')";
		}else{
			$t='';
		}
		// ---------------------------------------------------
		if ($seksi==FALSE) {
			$s='';
		}else{
			$s="and es.section_name like '%$seksi%'";
		}
		// ---------------------------------------------------
		if ($namapkj==FALSE) {
			$n='';
		}else{
			$n="and jumlah.participant_name like '$namapkj%'";
		}
		// --------------------------------------------------------------------------------------------------
		$sql=
		"
			SELECT	es.section_name, es.unit_name, es.department_name, jumlah.nama_pelatihan, jumlah.tanggal,jumlah.scheduling_id, 
					jumlah.trainer , jumlah.standar_kelulusan ,jumlah.participant_name, jumlah.noind, jumlah.score_eval2_pre, jumlah.score_eval2_post, jumlah.score_eval2_r1,
					jumlah.score_eval2_r2, jumlah.score_eval2_r3, jumlah.score_eval3_hardskill, jumlah.keterangan_hardskill, jumlah.score_eval3_softskill ,
					jumlah.keterangan_softskill
			from	
			er.er_section es,
			(
				select 
						ees.section_name,
						pst.scheduling_name as nama_pelatihan,
						pst.date as tanggal,
						pst.scheduling_id,
						pst.trainer,
						pp.participant_name,
						pp.noind,
						pp.score_eval2_pre,
						pp.score_eval2_post,
						pp.score_eval2_r1,
						pp.score_eval2_r2,
						pp.score_eval2_r3,
						pp.score_eval3_hardskill,
						pp.score_eval3_softskill,
						pp.keterangan_hardskill,
						pp.keterangan_softskill,
						pst.standar_kelulusan,
						count(pp.participant_name)as jml
						from	pl.pl_participant pp,
								er.er_employee_all pea,
								er.er_section ees,
								pl.pl_scheduling_training pst
						where
							pp.noind = pea.employee_code
							and ees.section_code = pea.section_code
							and pp.scheduling_id=pst.scheduling_id
						group by
							ees.section_name,
							pst.scheduling_name,
							3,4,5,6,7,8,9,10,11,12,13,14,15,16,17
			) as jumlah
			where 
			jumlah.jml is not null
			and jumlah.section_name = es.section_name
			$j $t $s $n
			group by es.section_name,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19
			order by jumlah.tanggal asc;
		";
		$query=$this->db->query($sql);
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
		// return $sql;
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
	// public function GetPercentParticipantAll($date1,$date2)
	// {	
	// 	$sql="select	es.section_name, training.partisipan, training.noind, training.nama, training.tahun,training.scheduling_id, training.status, training.ket
	// 			from	
	// 			er.er_section es,
	// 			(
	// 				select 
	// 						ees.section_name,
	// 						pst.scheduling_name as nama,
	// 						to_char(pst.date,'YYYY')as tahun,
	// 						pst.scheduling_id,
	// 						pp.participant_name as partisipan,
	// 						pp.noind,
	// 						pp.status,
	// 						pp.keterangan_kehadiran as ket
	// 						from	pl.pl_participant pp,
	// 								er.er_employee_all pea,
	// 								er.er_section ees,
	// 								pl.pl_scheduling_training pst
	// 						where
	// 							pp.noind = pea.employee_code
	// 							and ees.section_code = pea.section_code
	// 							and pp.scheduling_id=pst.scheduling_id
	// 						group by
	// 							ees.section_name,
	// 							pst.scheduling_name,
	// 							3,4,5,6,7,8
	// 						) as training
	// 			where training.partisipan is not null
	// 			and training.scheduling_id = ''
	// 			and training.section_name = es.section_name
	// 			and pst.date between TO_DATE('$date1', 'DD/MM/YYYY') and TO_DATE('$date2', 'DD/MM/YYYY'
	// 			group by es.section_name,2,3,4,5,6,7,8
	// 			)";
	// 	$query=$this->db->query($sql);
	// 	return $query->result_array();
	// }

	// EFEKTIFITAS TRAINING
	public function GetEfektivitasTraining($date1,$date2)
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
				a.training_type,
				a.scheduling_id,
				a.scheduling_name,
				a.participant_number,
				case
					when a.date is null then null
					else to_char(
						a.date,
						'DD MONTH YYYY'
					)
				end as training_date,
				(
					select
						sum( case when c.score_eval2_post >=( case when substring( noind, 1, 1 ) in( 'B', 'D', 'J', 'G', 'L', 'Q', 'Z' ) then cast(( case when split_part( d.standar_kelulusan, ',', 1 ) is null or split_part( d.standar_kelulusan, ',', 1 )= '' then '0' else split_part( d.standar_kelulusan, ',', 1 ) end ) as int ) else cast(( case when split_part( d.standar_kelulusan, ',', 2 ) is null or split_part( d.standar_kelulusan, ',', 2 )= '' then '0' else split_part( d.standar_kelulusan, ',', 2 ) end ) as int ) end ) then 1 else 0 end ) as lulus
					from
						pl.pl_participant c left join pl.pl_scheduling_training d on
						c.scheduling_id = d.scheduling_id
					where
						c.scheduling_id = a.scheduling_id
				) as kelulusan,
				(
					select
						sum( case when c.score_eval2_post <=( case when substring( noind, 1, 1 ) in( 'B', 'D', 'J', 'G', 'L', 'Q', 'Z' ) then cast(( case when split_part( d.standar_kelulusan, ',', 1 ) is null or split_part( d.standar_kelulusan, ',', 1 )= '' then '0' else split_part( d.standar_kelulusan, ',', 1 ) end ) as int ) else cast(( case when split_part( d.standar_kelulusan, ',', 2 ) is null or split_part( d.standar_kelulusan, ',', 2 )= '' then '0' else split_part( d.standar_kelulusan, ',', 2 ) end ) as int ) end ) then 1 else 0 end ) as lulus
					from
						pl.pl_participant c left join pl.pl_scheduling_training d on
						c.scheduling_id = d.scheduling_id
					where
						c.scheduling_id = a.scheduling_id
				) as ketidak_kelulusan
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
			order by
				a.date ASC";
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
						(
							to_char(
								a.date,
								'MONTH'
							)
						) as bulan,
						extract(
							year
						from
							date
						) as yyyy,
						(
							select
								sum( case when c.score_eval2_post >=( case when substring( noind, 1, 1 ) in( 'B', 'D', 'J', 'G', 'L', 'Q', 'Z' ) then cast(( case when split_part( d.standar_kelulusan, ',', 1 ) is null or split_part( d.standar_kelulusan, ',', 1 )= '' then '0' else split_part( d.standar_kelulusan, ',', 1 ) end ) as int ) else cast(( case when split_part( d.standar_kelulusan, ',', 2 ) is null or split_part( d.standar_kelulusan, ',', 2 )= '' then '0' else split_part( d.standar_kelulusan, ',', 2 ) end ) as int ) end ) then 1 else 0 end ) as lulus
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
					order by
						6,
						5 desc
				) as tabel";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function GetDetailParticipant($schid)
	{
		$sql = "select	es.section_name, training.partisipan, training.noind, training.nama, training.date,training.scheduling_id, training.status, training.ket
				from	
				er.er_section es,
				(
					select 
							ees.section_name,
							pst.scheduling_name as nama,
							to_char(pst.date,'DD/MM/YYYY')as date,
							pst.scheduling_id,
							pp.participant_name as partisipan,
							pp.noind,
							pp.status,
							pp.keterangan_kehadiran as ket
							from	pl.pl_participant pp,
									er.er_employee_all pea,
									er.er_section ees,
									pl.pl_scheduling_training pst
							where
								pp.noind = pea.employee_code
								and ees.section_code = pea.section_code
								and pp.scheduling_id=pst.scheduling_id
							group by
								ees.section_name,
								pst.scheduling_name,
								3,4,5,6,7,8
							) as training
				where training.partisipan is not null
				and training.scheduling_id = '$schid'
				and training.section_name = es.section_name
				group by es.section_name,2,3,4,5,6,7,8";
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

	public function GetStatement()
	{
		$sql="	select	st.*
				from	pl.pl_master_questionnaire_statement st";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	//Ambil data Trainer untuk view kedua
	public function GetTrainer(){
		$sql = "select * from pl.pl_master_trainer order by trainer_status DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function GetTrainerPaket(){
		$sql = "select 		*
				from 		pl.pl_master_trainer a
							join 	pl.pl_scheduling_training as b
									on 	b.trainer=a.trainer_id::varchar
				where		 b.package_scheduling_id=36
				order by 	b.scheduling_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	//Ambil data Trainer untuk view kedua
	public function GetTrainerQue($trainer=FALSE){
		if ($trainer==FALSE) {
			$p='';
		}else{
			$p="where trainer_id = '$trainer'";
		}
		$sql = "select * from pl.pl_master_trainer $p order by trainer_status DESC";
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

	public function GetSchName_QuesName_segmen()
	{
		$sql="	SELECT	a.scheduling_id,sg.questionnaire_id, sg.segment_id,a.scheduling_name , sg.segment_description, sg.segment_type
				from	pl.pl_scheduling_training a
						inner join	pl.pl_questionnaire_sheet b 
						on a.scheduling_id=b.scheduling_id
						inner join pl.pl_master_questionnaire c 
						on b.questionnaire_id=c.questionnaire_id,
						(
							select	sg.questionnaire_id,sg.segment_id,sg.segment_description, sg.segment_type
							from	pl.pl_master_questionnaire_segment sg
						)sg
				where sg.questionnaire_id=b.questionnaire_id
				group by 1,2,3,4,5,6
				order by sg.segment_id asc";
		$query=$this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}

	// REPORT KUESIONER DAN CUSTOM REPORT
	public function GetSchName_QuesName($pelatihan = FALSE, $date = FALSE, $trainer = FALSE, $tgl1 = FALSE, $tgl2=FALSE, $tgl_now=FALSE)
	{
		if ($pelatihan == FALSE && $date == FALSE && $trainer == FALSE && $tgl1==FALSE && $tgl2==FALSE) {
			$p='';
			$s='';
			$t='';
		}elseif ($pelatihan == FALSE && $date == TRUE && $trainer == FALSE && $tgl1==FALSE && $tgl2==FALSE) {
			$p='';
			$s=" WHERE a.date=TO_DATE('$date', 'YYYY/MM/DD')";
			$t='';
		}elseif ($pelatihan == TRUE && $date == FALSE && $trainer == FALSE && $tgl1==FALSE && $tgl2==FALSE) {
			$p=" WHERE a.scheduling_name='$pelatihan'";
			$s='';
			$t='';
		}elseif ($pelatihan == TRUE && $date == TRUE && $trainer == FALSE && $tgl1==FALSE && $tgl2==FALSE) {
			$p=" WHERE a.scheduling_name='$pelatihan'";
			$s=" AND a.date=TO_DATE('$date', 'YYYY/MM/DD')";
			$t='';
		}elseif ($pelatihan == TRUE && $date == TRUE && $trainer == TRUE && $tgl1==FALSE && $tgl2==FALSE) {
			$p=" WHERE a.scheduling_name='$pelatihan'";
			$s=" AND a.date=TO_DATE('$date', 'YYYY/MM/DD')";
			$t=" AND a.trainer like '%$trainer%'";
		}elseif ($pelatihan == TRUE && $date == FALSE && $trainer == TRUE && $tgl1==FALSE && $tgl2==FALSE) {
			$p=" WHERE a.scheduling_name='$pelatihan'";
			$s='';
			$t=" AND a.trainer like '%$trainer%'";
		}elseif ($pelatihan == FALSE && $date == FALSE && $trainer == TRUE && $tgl1==FALSE && $tgl2==FALSE) {
			$p='';
			$s='';
			$t=" WHERE a.trainer like '%$trainer%'";
		}elseif ($pelatihan == FALSE && $date == TRUE && $trainer == TRUE && $tgl1==FALSE && $tgl2==FALSE) {
			$p='';
			$s=" WHERE a.date=TO_DATE('$date', 'YYYY/MM/DD')";
			$t= "AND a.trainer like '%$trainer%'";
		}elseif ($pelatihan == TRUE && $date == FALSE && $trainer == FALSE && $tgl1==TRUE && $tgl2==TRUE && $tgl1!=$tgl2) {
			$p="WHERE a.scheduling_name='$pelatihan'";
			$s="and a.date between TO_DATE('$tgl1', 'MM/DD/YYYY') and TO_DATE('$tgl2', 'MM/DD/YYYY')";
			$t='';
		}
		elseif ($pelatihan == TRUE && $tgl1==$tgl2 && $tgl1==$tgl_now && $tgl2==$tgl_now) {
			$p="WHERE a.scheduling_name='$pelatihan'";
			$s='';
			$t='';
		}elseif ($pelatihan==FALSE && $tgl1==TRUE && $tgl2==TRUE && $tgl1!=$tgl2 && $tgl1!=$tgl_now && $tgl2!=$tgl_now) {
			$p="";
			$s="and a.date between TO_DATE('$tgl1', 'MM/DD/YYYY') and TO_DATE('$tgl2', 'MM/DD/YYYY')";
			$t='';
		}elseif ($tgl1==$tgl_now && $tgl2==$tgl_now && $tgl1==$tgl2) {
			$p="";
			$s="and a.date between TO_DATE('$tgl1', 'MM/DD/YYYY') and TO_DATE('$tgl2', 'MM/DD/YYYY')";
			$t='';
		}
		$sql="	SELECT	a.scheduling_id, a.scheduling_name , c.questionnaire_title,c.questionnaire_id, a.date, a.trainer
				from	pl.pl_scheduling_training a
						inner join	pl.pl_questionnaire_sheet b 
						on a.scheduling_id=b.scheduling_id
						inner join pl.pl_master_questionnaire c 
						on b.questionnaire_id=c.questionnaire_id
				$p $s $t
				group by 1,2,3,4,5,6";
		$query=$this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}

	public function GetSchName_QuesName_RPT($id)
	{
		$sql="	SELECT	a.scheduling_id, a.scheduling_name , c.questionnaire_title,c.questionnaire_id, a.date, a.trainer
				from	pl.pl_scheduling_training a
						inner join	pl.pl_questionnaire_sheet b 
						on a.scheduling_id=b.scheduling_id
						inner join pl.pl_master_questionnaire c 
						on b.questionnaire_id=c.questionnaire_id
				where a.scheduling_id='$id'
				group by 1,2,3,4,5,6";
		$query=$this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}
	public function GetSchName_QuesName_RPTPCK($pid)
	{
		$sql="	SELECT	a.scheduling_id, a.scheduling_name , c.questionnaire_title,c.questionnaire_id, a.date, a.trainer, a.package_scheduling_id, a.standar_kelulusan
				from	pl.pl_scheduling_training a
						inner join	pl.pl_questionnaire_sheet b 
						on a.scheduling_id=b.scheduling_id
						inner join pl.pl_master_questionnaire c 
						on b.questionnaire_id=c.questionnaire_id
				where a.package_scheduling_id='$pid'
				group by 1,2,3,4,5,6,7,8
				order by (a.date, a.scheduling_id) asc";
		$query=$this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}
	public function justSegmentPck($pid)
	{
		$sql="SELECT	d.segment_description
				from	pl.pl_scheduling_training a
						inner join	pl.pl_questionnaire_sheet b 
						on a.scheduling_id=b.scheduling_id
						inner join pl.pl_master_questionnaire c 
						on b.questionnaire_id=c.questionnaire_id
						inner join pl.pl_master_questionnaire_segment d
						on c.questionnaire_id=d.questionnaire_id
				where a.package_scheduling_id='$pid'
				and d.segment_type = 1
				group by d.segment_description";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function GetSchName_QuesName_detail($id,$qe)
	{
		$sql="	SELECT	a.scheduling_id, a.scheduling_name , c.questionnaire_title,c.questionnaire_id
				from	pl.pl_scheduling_training a
						inner join	pl.pl_questionnaire_sheet b 
						on a.scheduling_id=b.scheduling_id
						inner join pl.pl_master_questionnaire c 
						on b.questionnaire_id=c.questionnaire_id
						where	a.scheduling_id=$id
				and		c.questionnaire_id=$qe
				group by 1,2,3,4";
		$query=$this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}


	public function GetSheet($id,$qe)
	{
		$sql="	SELECT *
				from pl.pl_questionnaire_sheet qs
				WHERE (qs.scheduling_id =$id
				AND qs.questionnaire_id =$qe)";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function GetSheetAll()
	{
		$sql="	SELECT *
				from pl.pl_questionnaire_sheet qs
				inner join pl.pl_master_questionnaire_segment mq
				on qs.questionnaire_id=mq.questionnaire_id
				order by mq.segment_id";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function GetQuestParticipant($id)
	{
		$sql="	SELECT count(scheduling_id)as peserta_kuesioner
				from	pl.pl_participant
				where	scheduling_id=$id
				and 	status=1";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function GetQuestionnaireSegmentId($id,$qe){
		$sql = "
			select *
			from pl.pl_master_questionnaire_segment sg,
			(	select pst.scheduling_id
				from	pl.pl_scheduling_training pst
				where	pst.scheduling_id=$id
			)pst
			where questionnaire_id=$qe
			order by segment_order";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetSchPackage()
	{
		$sql="select * from pl.pl_scheduling_package";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetAttendant(){
		$sql = " SELECT
					a.scheduling_id, 
					count(participant_id) as attendant
				from pl.pl_participant a
				where status=1
				group by 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/////CREATE REPORT-------------------------------------------------------------------------------------------------------------------------------------- 
	public function AddReport($nama,$tanggal,$package_scheduling_id, $scheduling_id, $jenis, $indexm, $descr, $kendala, $catatan, $doc_no, $rev_no, $rev_date, $rev_note, $tmptdoc, $tgldoc, $nama_acc, $jabatan_acc, $pelaksana, $reg_paket, $total_psrt, $hadir_psrt)
	{
		$sql = " insert into pl.pl_create_report (jenis,index_materi,description,kendala,catatan, doc_no, rev_no, rev_date, rev_note, tmptdoc, tgldoc, nama_acc, jabatan_acc, scheduling_id, package_scheduling_id,scheduling_or_package_name, pelaksana, tanggal, reg_paket, peserta_total, peserta_hadir)
				values ($jenis,'$indexm','$descr','$kendala','$catatan', '$doc_no', '$rev_no', TO_DATE('$rev_date', 'DD/MM/YYYY'), '$rev_note', '$tmptdoc', TO_DATE('$tgldoc', 'DD/MM/YYYY'), '$nama_acc', '$jabatan_acc','$scheduling_id','$package_scheduling_id','$nama', '$pelaksana', TO_DATE('$tanggal', 'DD/MM/YYYY'),'$reg_paket', '$total_psrt', '$hadir_psrt')";
		$query = $this->db->query($sql);
		// $id=$this->db->insert_id();
		// return $sql;
	}

	//UPDATE REPORT
	public function UpdateReport($id, $jenis, $total_psrt, $hadir_psrt, $indexm, $descr, $kendala, $catatan, $doc_no, $rev_no, $rev_date, $rev_note, $tmptdoc, $tgldoc, $nama_acc, $jabatan_acc, $pelaksana)
	{
		$sql = " update pl.pl_create_report 
				set jenis=$jenis,peserta_total=$total_psrt,peserta_hadir=$hadir_psrt, pelaksana='$pelaksana', index_materi='$indexm',description='$descr', kendala='$kendala',catatan='$catatan', doc_no='$doc_no', rev_no='$rev_no', rev_date=TO_DATE('$rev_date', 'DD/MM/YYYY'),rev_note='$rev_note',tmptdoc='$tmptdoc',tgldoc=TO_DATE('$tgldoc', 'DD/MM/YYYY'), nama_acc='$nama_acc', jabatan_acc='$jabatan_acc' where id_report='$id'";
		$query = $this->db->query($sql);
		// return $sql;
	}
	public function updatePublic($table, $kolom, $data, $id)
	{
		$this->db->where($kolom, $id);
		$this->db->update($table, $data);
	}

	//GET FILLED REPORT
	public function getFilledReport()
	{
		$sql="	SELECT *
				from pl.pl_create_report";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function getFilledReportEdit($id)
	{
		$sql="	SELECT a.*, length(a.description)
				from pl.pl_create_report a
				where id_report=$id";
		$query=$this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}
	public function Getpeserta($id)
	{
		$sql="SELECT * from pl.pl_scheduling_training a where a.scheduling_id='$id'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function GetPsrtPaket($pid)
	{
		$sql="SELECT max(participant_number)as jumlah from pl.pl_scheduling_training a where a.package_scheduling_id='$pid'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	//DELETE REPORT
	public function deleteReport($id)
	{
		$sql1 = "delete from pl.pl_create_report where id_report='$id'";
		$sql2 = "delete from pl.pl_eval_reaksi where id_report='$id'";
		$sql3 = "delete from pl.pl_eval_pembelajaran where id_report='$id'";

		$query = $this->db->query($sql1);
		$query = $this->db->query($sql2);
		$query = $this->db->query($sql3);
		return;
	}
	public function countPelatihan($pid)
	{
		$sql="	SELECT	count (a.scheduling_name) as jml_pel 
				from	pl.pl_scheduling_training a
				where a.package_scheduling_id='$pid'
				and a.status=1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function countTrainer($id)
	{
		$sql="	SELECT max(array_length(regexp_split_to_array(a.pelaksana,','),1))
				from pl.pl_create_report a
				where id_report='$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function countSegment($sid)
	{
		$sql="SELECT d.segment_description
				from	pl.pl_scheduling_training a
						inner join	pl.pl_questionnaire_sheet b 
						on a.scheduling_id=b.scheduling_id
						inner join pl.pl_master_questionnaire_segment d 
						on b.questionnaire_id=d.questionnaire_id
				where 
				a.scheduling_id='$sid'
				and 
				d.segment_type=1
				group by 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function countSegmentPck($pid)
	{
		$sql="SELECT d.segment_description
				from	pl.pl_scheduling_training a
						inner join	pl.pl_questionnaire_sheet b 
						on a.scheduling_id=b.scheduling_id
						inner join pl.pl_master_questionnaire_segment d 
						on b.questionnaire_id=d.questionnaire_id
				where 
				a.package_scheduling_id='$pid'
				and 
				d.segment_type=1
				group by 1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	// public function countTrainerPck($pid)
	// 	$sql="	SELECT max(array_length(regexp_split_to_array(a.pelaksana,','),1))
	// 			from pl.pl_create_report a
	// 			where id_report='$id'";
	// 	$query = $this->db->query($sql);
	// 	return $query->result_array();
	// }
}
?>