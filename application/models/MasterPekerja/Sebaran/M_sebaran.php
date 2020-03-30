<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_sebaran extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->dinas_luar = $this->load->database('dinas_luar', TRUE);
	}

	public function getSebaran(){
		$sql = "select
					tbl2.dept
					,tbl2.unit
					,tbl2.lokasi_kerja
					,sum(tbl2.bptd) bapil
					,sum(tbl2.bptds) bapilsak
					,sum(tbl2.hs) hansak
					,sum(tbl2.rasa) matira
					,count(tbl2.dept) sudah_isi
					,tbl2.posisix
					,tbl2.posisiy
				FROM (
					SELECT
						qts.dept
						,qts.unit
						,qtlk.lokasi_kerja
						,CASE when (tbl1.question_22 + tbl1.question_23 + tbl1.question_24 + tbl1.question_25)>0 then 1 else 0 end bptd
						,CASE when ((tbl1.question_22 + tbl1.question_23 + tbl1.question_24 + tbl1.question_25)>0 and tbl1.question_26 = 1) then 1 else 0 end bptds
						,tbl1.question_26 hs
						,case when (tbl1.question_27 + tbl1.question_28)>0 then 1 else 0 end rasa
						,coalesce(tp.posisix,'0') as posisix
						,coalesce(tp.posisiy,'0') as posisiy
					FROM (
						SELECT
							gcr.id
							,gcr.creation_by
							,case when gcr.question_1 = 'Y' then 1 else 0 end question_1
							,case when gcr.question_2 = 'Y' then 1 else 0 end  question_2
							,case when gcr.question_3 = 'Y' then 1 else 0 end  question_3
							,case when gcr.question_4 = 'Y' then 1 else 0 end  question_4
							,case when gcr.question_5 = 'Y' then 1 else 0 end  question_5
							,case when gcr.question_6 = 'Y' then 1 else 0 end  question_6
							,case when gcr.question_7 = 'Y' then 1 else 0 end  question_7
							,case when gcr.question_8 = 'Y' then 1 else 0 end  question_8
							,case when gcr.question_9 = 'Y' then 1 else 0 end  question_9
							,case when gcr.question_10 = 'Y' then 1 else 0 end  question_10
							,case when gcr.question_11 = 'Y' then 1 else 0 end  question_11
							,case when gcr.question_12 = 'Y' then 1 else 0 end  question_12
							,case when gcr.question_13 = 'Y' then 1 else 0 end  question_13
							,case when gcr.question_14 = 'Y' then 1 else 0 end  question_14
							,case when gcr.question_15 = 'Y' then 1 else 0 end  question_15
							,case when gcr.question_16 = 'Y' then 1 else 0 end  question_16
							,case when gcr.question_17 = 'Y' then 1 else 0 end  question_17
							,case when gcr.question_18 = 'Y' then 1 else 0 end  question_18
							,case when gcr.question_19 = 'Y' then 1 else 0 end  question_19
							,case when gcr.question_20 = 'Y' then 1 else 0 end  question_20
							,case when gcr.question_21 = 'Y' then 1 else 0 end  question_21
							,case when gcr.question_22 = 'Y' then 1 else 0 end  question_22
							,case when gcr.question_23 = 'Y' then 1 else 0 end  question_23
							,case when gcr.question_24 = 'Y' then 1 else 0 end  question_24
							,case when gcr.question_25 = 'Y' then 1 else 0 end  question_25
							,case when gcr.question_26 = 'Y' then 1 else 0 end  question_26
							,case when gcr.question_27 = 'Y' then 1 else 0 end  question_27
							,case when gcr.question_28 = 'Y' then 1 else 0 end  question_28
							,case when gcr.question_29 = 'Y' then 1 else 0 end  question_29
							,case when gcr.question_30 = 'Y' then 1 else 0 end  question_30
						FROM
						pendataan.ga_covid19_risk gcr
						where gcr.active_flag is null
					) tbl1
					INNER JOIN pendataan.tpribadi tp on tbl1.creation_by = tp.noind
					INNER JOIN quickc01_dinas_luar_online.t_seksi qts on tp.kodesie = qts.kodesie
					INNER JOIN quickc01_dinas_luar_online.t_lokasi_kerja qtlk on tp.lokasi_kerja = qtlk.lokasi_id
				) tbl2
				GROUP BY
				tbl2.dept
				,tbl2.unit
				,tbl2.lokasi_kerja
				,tbl2.posisix
				,tbl2.posisiy
				order by 5 desc,4 desc ,6 desc";
		return $this->dinas_luar->query($sql)->result_array();
	}

}
?>