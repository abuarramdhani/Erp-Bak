<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_chart extends CI_Model
{
    function __construct()
    {
				parent::__construct();
				$this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
    }

		public function GetSectionList()
		{
			$sql = "SELECT
							gcc.segment4 seksi
							,gcc.segment4||' - '||ffvt.DESCRIPTION DESCRIPTION
							FROM 
							gl_je_lines gjl
							,gl_code_combinations gcc
							,gl_je_headers gjh
							,fnd_flex_values ffv
							,fnd_flex_values_tl ffvt
							WHERE gjh.je_header_id = gjl.je_header_id
							and gcc.code_combination_id = gjl.code_combination_id
							and gcc.SEGMENT4 = ffv.FLEX_VALUE
							and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
							and gjl.EFFECTIVE_DATE between '01-JAN-2018' AND '31-DEC-2019'
							and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
										AND gcc.segment4 = '0000'))
										AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																						,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																						,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																						,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																						,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																						,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																						,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
										AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																						,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																						,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																						,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																						,'521115','521201')
										OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																				,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																				,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																				,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																				,'521115','521201')
										and gcc.segment4 between '1000' and '1ZZZ'
										and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA'))) 
							AND gcc.segment3 like '5_____'    
							and (gjl.ACCOUNTED_dr > 0 or  gjl.ACCOUNTED_cr > 0)                                               
							group by gcc.segment4,ffvt.DESCRIPTION
							order by 1";

			$query = $this->oracle->query($sql);
			return $query->result_array();
		}

		public function GetAccountList($id ='')
		{
				if ( $id == 'All' ){
					$id = '';
				}

				$sql = "SELECT
								gcc.segment3 ACCOUNT
								,gcc.segment3||' - '||ffvt.DESCRIPTION DESCRIPTION
								FROM 
								gl_je_lines gjl
								,gl_code_combinations gcc
								,gl_je_headers gjh
								,fnd_flex_values ffv
								,fnd_flex_values_tl ffvt
								WHERE gjh.je_header_id = gjl.je_header_id
								and gcc.code_combination_id = gjl.code_combination_id
								and gcc.SEGMENT3 = ffv.FLEX_VALUE
								and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
								and gjl.EFFECTIVE_DATE between '01-JAN-2018' AND '31-DEC-2019'
								and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
											AND gcc.segment4 = '0000'))
											AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																							,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																							,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																							,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																							,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																							,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																							,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
											AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																							,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																							,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																							,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																							,'521115','521201')
											OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																					,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																					,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																					,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																					,'521115','521201')
											and gcc.segment4 between '1000' and '1ZZZ'
											and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA'))) 
								AND gcc.segment3 like '5_____'    
								and (gjl.ACCOUNTED_dr > 0 or  gjl.ACCOUNTED_cr > 0)
								and gcc.segment4 = nvl('$id', gcc.segment4)                                                
								group by gcc.segment3,ffvt.DESCRIPTION
								order by 1";

				$query = $this->oracle->query($sql);
				return $query->result_array();
		}

		public function GetFinanceCostDashboardBySectionName($id)
		{
				if ( $id == 'All' ){
						$id = '';
				}

				$sql = "SELECT
								ffv.FLEX_VALUE
								,ffvt.DESCRIPTION
								,nvl(tbl1.total,0) tahun_1
								,nvl(tbl2.total,0) tahun_2
								from
								(SELECT
								gcc.segment3 ACCOUNT
								,sum(
								NVL(gjl.ACCOUNTED_dr,0) -
								NVL(gjl.ACCOUNTED_cr,0) 
								) total
								FROM 
								gl_je_lines gjl
								,gl_code_combinations gcc
								,gl_je_headers gjh
								WHERE gjh.je_header_id = gjl.je_header_id
								and gcc.code_combination_id = gjl.code_combination_id
								and gjl.EFFECTIVE_DATE between '01-JAN-2018' AND add_months(last_day(sysdate),-12)
								and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
											AND gcc.segment4 = '0000'))
											AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																							,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																							,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																							,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																							,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																							,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																							,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
											AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																							,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																							,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																							,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																							,'521115','521201')
											OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																					,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																					,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																					,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																					,'521115','521201')
											and gcc.segment4 between '1000' and '1ZZZ'
											and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA')))
								and gcc.segment4 = NVL('$id', gcc.segment4)                                                                    
								group by gcc.segment3) tbl1
								,
								(SELECT
								gcc.segment3 ACCOUNT
								,sum(
								NVL(gjl.ACCOUNTED_dr,0) -
								NVL(gjl.ACCOUNTED_cr,0) 
								) total
								FROM 
								gl_je_lines gjl
								,gl_code_combinations gcc
								,gl_je_headers gjh
								WHERE gjh.je_header_id = gjl.je_header_id
								and gcc.code_combination_id = gjl.code_combination_id
								and gjl.EFFECTIVE_DATE between '01-JAN-2019' AND last_day(sysdate)
								and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
											AND gcc.segment4 = '0000'))
											AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																							,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																							,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																							,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																							,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																							,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																							,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
											AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																							,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																							,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																							,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																							,'521115','521201')
											OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																					,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																					,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																					,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																					,'521115','521201')
											and gcc.segment4 between '1000' and '1ZZZ'
											and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA')))
								and gcc.segment4 = NVL('$id', gcc.segment4)                                                                    
								group by gcc.segment3) tbl2
								,fnd_flex_values ffv
								,fnd_flex_values_tl ffvt
								where 
								ffv.FLEX_VALUE = tbl1.account(+)
								and ffv.FLEX_VALUE = tbl2.account(+)
								and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
								and ffv.FLEX_VALUE like '5_____' 
								and (tbl1.total is not null or tbl2.total is not null) 
								order by tbl2.total desc NULLS LAST";

				$query = $this->oracle->query($sql);
				return $query->result_array();
		}

		public function GetFinanceCostByAccountNameAndSectionName($section,$account)
		{
				if ( $section == 'All' ){
						$section = '';
				}

				$sql = "SELECT
								tbl3.bulan
								,nvl(tbl1.total,0) tahun1
								,nvl(tbl2.total,0) tahun2
								from
								(SELECT
								gcc.segment3 ACCOUNT
								,gjl.PERIOD_NAME
								,EXTRACT(month FROM gjl.EFFECTIVE_DATE) bulan
								,sum(
								NVL(gjl.ACCOUNTED_dr,0) -
								NVL(gjl.ACCOUNTED_cr,0) 
								) total
								FROM 
								gl_je_lines gjl
								,gl_code_combinations gcc
								,gl_je_headers gjh
								WHERE gjh.je_header_id = gjl.je_header_id
								and gcc.code_combination_id(+) = gjl.code_combination_id
								and gjl.EFFECTIVE_DATE between '01-JAN-2018' AND add_months(last_day(sysdate),-12)
								and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
											AND gcc.segment4 = '0000'))
											AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																							,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																							,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																							,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																							,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																							,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																							,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
											AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																							,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																							,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																							,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																							,'521115','521201')
											OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																					,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																					,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																					,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																					,'521115','521201')
											and gcc.segment4 between '1000' and '1ZZZ'
											and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA')))
								and gcc.segment3 = $account
								and gcc.segment4 = NVL('$section', gcc.segment4)                                                          
								group by gcc.segment3,gjl.PERIOD_NAME,gjl.EFFECTIVE_DATE) tbl1
								,
								(SELECT
								gcc.segment3 ACCOUNT
								,gjl.PERIOD_NAME
								,EXTRACT(month FROM gjl.EFFECTIVE_DATE) bulan
								,sum(
								NVL(gjl.ACCOUNTED_dr,0) -
								NVL(gjl.ACCOUNTED_cr,0) 
								) total
								FROM 
								gl_je_lines gjl
								,gl_code_combinations gcc
								,gl_je_headers gjh
								WHERE gjh.je_header_id = gjl.je_header_id
								and gcc.code_combination_id(+) = gjl.code_combination_id
								and gjl.EFFECTIVE_DATE between '01-JAN-2019' AND last_day(sysdate)
								and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
											AND gcc.segment4 = '0000'))
											AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																							,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																							,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																							,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																							,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																							,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																							,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
											AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																							,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																							,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																							,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																							,'521115','521201')
											OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																					,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																					,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																					,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																					,'521115','521201')
											and gcc.segment4 between '1000' and '1ZZZ'
											and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA')))
								and gcc.segment3 = $account
								and gcc.segment4 = NVL('$section', gcc.segment4)                                                          
								group by gcc.segment3,gjl.PERIOD_NAME,gjl.EFFECTIVE_DATE) tbl2
								,
								(select
								EXTRACT(month FROM gjl2.EFFECTIVE_DATE) bulan
								FROM 
								gl_je_lines gjl2
								,gl_code_combinations gcc2
								,gl_je_headers gjh2
								WHERE gjh2.je_header_id = gjl2.je_header_id
								and gcc2.code_combination_id = gjl2.code_combination_id
								and gjl2.EFFECTIVE_DATE between '01-JAN-2018' AND add_months(last_day(sysdate),-12)
								and gcc2.segment3 = '521101'
								group by gjl2.EFFECTIVE_DATE) tbl3
								where
								tbl3.bulan = tbl1.bulan(+)
								and tbl3.bulan = tbl2.bulan(+)
								order by 1";

				$query = $this->oracle->query($sql);
				return $query->result_array();
		}

		public function GetFinanceCostDetailReportByAccountNameAndSectionName($section,$account)
		{
				if ( $section == 'All' ){
					$section = '';
				}

				$sql = "SELECT
								gjl.CREATION_DATE
								,gir.REFERENCE_9 total
								,xal.DESCRIPTION
								FROM 
								gl_je_lines gjl
								,gl_code_combinations gcc
								,gl_je_headers gjh
								,gl_import_references gir
								,xla_ae_lines xal
								WHERE gjh.je_header_id = gjl.je_header_id
								and gcc.code_combination_id(+) = gjl.code_combination_id
								AND gjl.je_header_id = gir.je_header_id
								AND gjl.je_line_num = gir.je_line_num
								and gir.gl_sl_link_id = xal.gl_sl_link_id
								and gjl.EFFECTIVE_DATE between '01-JAN-2019' AND last_day(sysdate)
								and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
											AND gcc.segment4 = '0000'))
											AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																							,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																							,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																							,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																							,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																							,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																							,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
											AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																							,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																							,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																							,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																							,'521115','521201')
											OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																					,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																					,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																					,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																					,'521115','521201')
											and gcc.segment4 between '1000' and '1ZZZ'
											and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA')))
								and gcc.segment3 = $account
								and gcc.segment4 = nvl('$section', gcc.segment4) 
								order by 1";

				$query = $this->oracle->query($sql);
				return $query->result_array();
		}

		public function GetSortedFinanceCostTotal()
		{
				$sql = "SELECT
								ffv.FLEX_VALUE
								,ffvt.DESCRIPTION
								,nvl(tbl1.total,0) tahun_1
								,nvl(tbl2.total,0) tahun_2
								from
								(SELECT
								gcc.segment4 cost_center
								,sum(
								NVL(gjl.ACCOUNTED_dr,0) -
								NVL(gjl.ACCOUNTED_cr,0) 
								) total
								FROM 
								gl_je_lines gjl
								,gl_code_combinations gcc
								,gl_je_headers gjh
								WHERE gjh.je_header_id = gjl.je_header_id
								and gcc.code_combination_id = gjl.code_combination_id
								and gjl.EFFECTIVE_DATE between '01-JAN-2018' AND add_months(last_day(sysdate),-12)
								and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
											AND gcc.segment4 = '0000'))
											AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																							,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																							,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																							,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																							,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																							,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																							,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
											AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																							,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																							,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																							,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																							,'521115','521201')
											OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																					,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																					,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																					,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																					,'521115','521201')
											and gcc.segment4 between '1000' and '1ZZZ'
											and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA'))) 
								and gcc.segment3 like '5_____'                                                                   
								group by gcc.segment4) tbl1
								,
								(SELECT
								gcc.segment4 cost_center
								,sum(
								NVL(gjl.ACCOUNTED_dr,0) -
								NVL(gjl.ACCOUNTED_cr,0) 
								) total
								FROM 
								gl_je_lines gjl
								,gl_code_combinations gcc
								,gl_je_headers gjh
								WHERE gjh.je_header_id = gjl.je_header_id
								and gcc.code_combination_id = gjl.code_combination_id
								and gjl.EFFECTIVE_DATE between '01-JAN-2019' AND last_day(sysdate)
								and((gcc.segment4 BETWEEN '1000' AND '1ZZZ' OR (gcc.segment3 IN ('522201', '522527', '522528', '522529', '522530')
											AND gcc.segment4 = '0000'))
											AND gcc.segment3 NOT IN ('515523','515524','515525','515520','522523','515535','515538','515301','515302','515303'
																							,'515304','515305','515306','515307','515308','515521','513101','513102','511102','511101'
																							,'515526','515536','515537','515599','515522','515604','515608','523202','523204','523203'
																							,'523206','523102','523199','523207','523205','523101','523299','523104','523106','523107'
																							,'523201','515528','522522','522525','522526','524201','524205','524204','524206','524202'
																							,'523105','524104','523108','523103','522509','522505','515504','522101','515101','515103'
																							,'515104','522104','522105','522103','515102','524101','524102','524103','524105','524199')
											AND gcc.segment3 not IN ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																							,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																							,'514108','514109','514110','514111','514112','514113','514201','521101','521102','521103'
																							,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																							,'521115','521201')
											OR (gcc.segment3 IN  ('512101','512102','512103','512104','512105','512106','512108','512109','512110','512111'
																					,'512112','512113','512114','512201','514101','514102','514103','514104','514105','514106'
																					,'514108','514109','514110','514111','514112','514201','514113','521101','521102','521103'
																					,'521104','521105','521106','521108','521109','521110','521111','521112','521113','521114'
																					,'521115','521201')
											and gcc.segment4 between '1000' and '1ZZZ'      
											and (gcc.segment2 = 'AC' OR gcc.segment2 between '00' and 'AA')))
								and gcc.segment3 like '5_____'                                                                    
								group by gcc.segment4) tbl2
								,fnd_flex_values ffv
								,fnd_flex_values_tl ffvt
								where 
								ffv.FLEX_VALUE = tbl1.cost_center(+)
								and ffv.FLEX_VALUE = tbl2.cost_center(+)
								and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
								and (tbl1.total is not null or tbl2.total is not null) 
								order by tbl2.total desc NULLS LAST";

				$query = $this->oracle->query($sql);
				return $query->result_array();
		}
}
?>