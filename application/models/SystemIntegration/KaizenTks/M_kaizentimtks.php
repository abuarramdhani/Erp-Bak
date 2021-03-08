<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_kaizentimtks extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->erp = $this->load->database('erp_db', true);
		$this->personalia = $this->load->database('personalia', true);
	}

	function tgl_indo($tanggal)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);

		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
		return $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
	}

	function getDataKaizenTotalPekerjaSatuTahun($year)
	{
		$query = $this->erp->query("
    SELECT
	*,
	case
		when n1.plan_januari = '0' then '0'
		else ((100::float / n1.plan_januari) * n1.actual_januari)
	end as persen_januari,
	case
		when n1.plan_februari = '0' then '0'
		else ((100::float / n1.plan_februari) * n1.actual_februari)
	end as persen_februari,
	case
		when n1.plan_maret = '0' then '0'
		else ((100::float / n1.plan_maret) * n1.actual_maret)
	end as persen_maret,
	case
		when n1.plan_april = '0' then '0'
		else ((100::float / n1.plan_april) * n1.actual_april)
	end as persen_april,
	case
		when n1.plan_mei = '0' then '0'
		else ((100::float / n1.plan_mei) * n1.actual_mei)
	end as persen_mei,
	case
		when n1.plan_juni = '0' then '0'
		else ((100::float / n1.plan_juni) * n1.actual_juni)
	end as persen_juni,
	case
		when n1.plan_juli = '0' then '0'
		else ((100::float / n1.plan_juli) * n1.actual_juli)
	end as persen_juli,
	case
		when n1.plan_agustus = '0' then '0'
		else ((100::float / n1.plan_agustus) * n1.actual_agustus)
	end as persen_agustus,
	case
		when n1.plan_september = '0' then '0'
		else ((100::float / n1.plan_september) * n1.actual_september)
	end as persen_september,
	case
		when n1.plan_oktober = '0' then '0'
		else ((100::float / n1.plan_oktober) * n1.actual_oktober)
	end as persen_oktober,
	case
		when n1.plan_november = '0' then '0'
		else ((100::float / n1.plan_november) * n1.actual_november)
	end as persen_november,
		case
		when n1.plan_desember = '0' then '0'
		else ((100::float / n1.plan_desember) * n1.actual_desember)
	end as persen_desember
from
	(
	select
		distinct es.section_code,
		es.section_name,
		es.unit_name,
		(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-01' )as plan_januari,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-01'
			and es.section_code = skt.section_code) as actual_januari,
		(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-02' )as plan_februari,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-02'
			and es.section_code = skt.section_code) as actual_februari,
		(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-03' )as plan_maret,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-03'
			and es.section_code = skt.section_code) as actual_maret,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-04' )as plan_april,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-04'
			and es.section_code = skt.section_code) as actual_april,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-05' )as plan_mei,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-05'
			and es.section_code = skt.section_code) as actual_mei,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-06' )as plan_juni,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-06'
			and es.section_code = skt.section_code) as actual_juni,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-07' )as plan_juli,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-07'
			and es.section_code = skt.section_code) as actual_juli,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-08' )as plan_agustus,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-08'
			and es.section_code = skt.section_code) as actual_agustus,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-09' )as plan_september,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-09'
			and es.section_code = skt.section_code) as actual_september,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-10' )as plan_oktober,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-10'
			and es.section_code = skt.section_code) as actual_oktober,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-11' )as plan_november,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-11'
			and es.section_code = skt.section_code) as actual_november,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-12' )as plan_desember,
		(
		select
			count(distinct skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-12'
			and es.section_code = skt.section_code) as actual_desember
	from
		er.er_section es
	left join si.si_kaizen_tks skt on
		es.section_code = skt.section_code
	where
		es.section_code in ('325020100',
		'320010100',
		'329010103',
		'329030100',
		'330100701',
		'330101103',
		'325010805',
		'322010101',
		'321010300',
		'328010305',
		'323020101',
		'323010100',
		'323030102',
		'331010103',
		'326010100',
		'324010101')
	group by
		es.section_code,
		es.section_name,
		es.unit_name,
		skt.created_at
	order by
		es.section_name) as n1
group by
	n1.section_code,
	n1.section_name,
	n1.unit_name,
	n1.plan_januari,
	n1.actual_januari,
	n1.plan_februari,
	n1.actual_februari,
	n1.plan_maret,
	n1.actual_maret,
	n1.plan_april,
	n1.actual_april,
	n1.plan_mei,
	n1.actual_mei,
	n1.plan_juni,
	n1.actual_juni,
	n1.plan_juli,
	n1.actual_juli,
	n1.plan_agustus,
	n1.actual_agustus,
	n1.plan_september,
	n1.actual_september,
	n1.plan_oktober,
	n1.actual_oktober,
	n1.plan_november,
	n1.actual_november,
	n1.plan_desember,
	n1.actual_desember
order by n1.section_name");

		return $query->result_array();
	}

	function getDataKaizenTotalPekerjaSatuBulan($date)
	{
		$query = $this->erp->query("
	select
	distinct es.section_code,
	es.section_name,
	es.unit_name,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-01')as a,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-02')as b,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-03')as c,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-04')as d,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-05')as e,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-06')as f,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-07')as g,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-08')as h,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-09')as i,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-10')as j,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-11')as k,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-12')as l,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-13')as m,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-14')as n,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-15')as o,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-16')as p,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-17')as q,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-18')as r,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-19')as s,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-20')as t,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-21')as u,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-22')as v,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-23')as w,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-24')as x,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-25')as y,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-26')as z,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-27')as ab,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-28')as cd,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-29')as ef,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-30')as gh,
	(select count(distinct no_ind) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$date')as total
from
	er.er_section es
where
	es.section_code in ('325020100',
	'320010100',
	'329010103',
	'329030100',
	'330100701',
	'330101103',
	'325010805',
	'322010101',
	'321010300',
	'328010305',
	'323020101',
	'323010100',
	'323030102',
	'331010103',
	'326010100',
	'324010101')
group by
	es.section_code,
	es.section_name,
	es.unit_name
order by
	es.section_name
	");

		return $query->result_array();
	}

	function getDataKaizenTotalKaizenSatuTahun($year)
	{
		$query = $this->erp->query("
	select
	*,
	case
		when n1.plan_januari = '0' then '0'
		else ((100::float / n1.plan_januari) * n1.actual_januari)
	end as persen_januari,
	case
		when n1.plan_februari = '0' then '0'
		else ((100::float / n1.plan_februari) * n1.actual_februari)
	end as persen_februari,
	case
		when n1.plan_maret = '0' then '0'
		else ((100::float / n1.plan_maret) * n1.actual_maret)
	end as persen_maret,
	case
		when n1.plan_april = '0' then '0'
		else ((100::float / n1.plan_april) * n1.actual_april)
	end as persen_april,
	case
		when n1.plan_mei = '0' then '0'
		else ((100::float / n1.plan_mei) * n1.actual_mei)
	end as persen_mei,
	case
		when n1.plan_juni = '0' then '0'
		else ((100::float / n1.plan_juni) * n1.actual_juni)
	end as persen_juni,
	case
		when n1.plan_juli = '0' then '0'
		else ((100::float / n1.plan_juli) * n1.actual_juli)
	end as persen_juli,
	case
		when n1.plan_agustus = '0' then '0'
		else ((100::float / n1.plan_agustus) * n1.actual_agustus)
	end as persen_agustus,
	case
		when n1.plan_september = '0' then '0'
		else ((100::float / n1.plan_september) * n1.actual_september)
	end as persen_september,
	case
		when n1.plan_oktober = '0' then '0'
		else ((100::float / n1.plan_oktober) * n1.actual_oktober)
	end as persen_oktober,
	case
		when n1.plan_november = '0' then '0'
		else ((100::float / n1.plan_november) * n1.actual_november)
	end as persen_november,
		case
		when n1.plan_desember = '0' then '0'
		else ((100::float / n1.plan_desember) * n1.actual_desember)
	end as persen_desember
from
	(
	select
		distinct es.section_code,
		es.section_name,
		es.unit_name,
		(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-01' )as plan_januari,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-01'
			and es.section_code = skt.section_code) as actual_januari,
		(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-02' )as plan_februari,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-02'
			and es.section_code = skt.section_code) as actual_februari,
		(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-03' )as plan_maret,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-03'
			and es.section_code = skt.section_code) as actual_maret,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-04' )as plan_april,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-04'
			and es.section_code = skt.section_code) as actual_april,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-05' )as plan_mei,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-05'
			and es.section_code = skt.section_code) as actual_mei,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-06' )as plan_juni,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-06'
			and es.section_code = skt.section_code) as actual_juni,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-07' )as plan_juli,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-07'
			and es.section_code = skt.section_code) as actual_juli,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-08' )as plan_agustus,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-08'
			and es.section_code = skt.section_code) as actual_agustus,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-09' )as plan_september,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-09'
			and es.section_code = skt.section_code) as actual_september,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-10' )as plan_oktober,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-10'
			and es.section_code = skt.section_code) as actual_oktober,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-11' )as plan_november,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-11'
			and es.section_code = skt.section_code) as actual_november,
				(
		select
			count(section_code)
		from
			er.er_employee_all
		where
			section_code = es.section_code
			and to_char(resign_date, 'YYYY-MM') >= '$year-12' )as plan_desember,
		(
		select
			count(skt.no_ind)
		from
			si.si_kaizen_tks skt
		where
			to_char(skt.created_at, 'YYYY-MM') = '$year-12'
			and es.section_code = skt.section_code) as actual_desember
	from
		er.er_section es
	left join si.si_kaizen_tks skt on
		es.section_code = skt.section_code
	where
		es.section_code in ('325020100',
		'320010100',
		'329010103',
		'329030100',
		'330100701',
		'330101103',
		'325010805',
		'322010101',
		'321010300',
		'328010305',
		'323020101',
		'323010100',
		'323030102',
		'331010103',
		'326010100',
		'324010101')
	group by
		es.section_code,
		es.section_name,
		es.unit_name,
		skt.created_at
	order by
		es.section_name) as n1
group by
	n1.section_code,
	n1.section_name,
	n1.unit_name,
	n1.plan_januari,
	n1.actual_januari,
	n1.plan_februari,
	n1.actual_februari,
	n1.plan_maret,
	n1.actual_maret,
	n1.plan_april,
	n1.actual_april,
	n1.plan_mei,
	n1.actual_mei,
	n1.plan_juni,
	n1.actual_juni,
	n1.plan_juli,
	n1.actual_juli,
	n1.plan_agustus,
	n1.actual_agustus,
	n1.plan_september,
	n1.actual_september,
	n1.plan_oktober,
	n1.actual_oktober,
	n1.plan_november,
	n1.actual_november,
	n1.plan_desember,
	n1.actual_desember;
	");

		return $query->result_array();
	}

	function getDataKaizenTotalKaizenSatuBulan($date)
	{
		$query = $this->erp->query("
		select
	distinct es.section_code,
	es.section_name,
	es.unit_name,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-01')as a,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-02')as b,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-03')as c,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-04')as d,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-05')as e,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-06')as f,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-07')as g,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-08')as h,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-09')as i,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-10')as j,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-11')as k,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-12')as l,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-13')as m,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-14')as n,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-15')as o,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-16')as p,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-17')as q,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-18')as r,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-19')as s,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-20')as t,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-21')as u,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-22')as v,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-23')as w,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-24')as x,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-25')as y,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-26')as z,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-27')as ab,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-28')as cd,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-29')as ef,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM-DD') = '$date-30')as gh,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$date')as total
from
	er.er_section es
where
	es.section_code in ('325020100',
	'320010100',
	'329010103',
	'329030100',
	'330100701',
	'330101103',
	'325010805',
	'322010101',
	'321010300',
	'328010305',
	'323020101',
	'323010100',
	'323030102',
	'331010103',
	'326010100',
	'324010101')
group by
	es.section_code,
	es.section_name,
	es.unit_name
order by
	es.section_name
		");

		return $query->result_array();
	}

	function getDataKaizenKategoriKaizenTahunan($year)
	{
		$query = $this->erp->query("
		select
	distinct es.section_code,
	es.section_name,
	es.unit_name,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Process')as p,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Quality')as q,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Handling')as h,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY') = '$year' and kaizen_category = '5S')as s5,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Safety')as s,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Yokoten')as y
from
	er.er_section es
where
	es.section_code in ('325020100',
	'320010100',
	'329010103',
	'329030100',
	'330100701',
	'330101103',
	'325010805',
	'322010101',
	'321010300',
	'328010305',
	'323020101',
	'323010100',
	'323030102',
	'331010103',
	'326010100',
	'324010101')
group by
	es.section_code,
	es.section_name,
	es.unit_name
order by
	es.section_name
		");
		return $query->result_array();
	}

	function getDataKaizenKategoriBulanan($year)
	{
		$query = $this->erp->query("
		select
	distinct es.section_code,
	es.section_name,
	es.unit_name,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Process')as p_jan,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Quality')as q_jan,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Handling')as h_jan,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = '5S')as s5_jan,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Safety')as s_jan,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Yokoten')as y_jan,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Process')as p_feb,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Quality')as q_feb,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Handling')as h_feb,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = '5S')as s5_feb,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Safety')as s_feb,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Yokoten')as y_feb,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Process')as p_mar,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Quality')as q_mar,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Handling')as h_mar,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = '5S')as s5_mar,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Safety')as s_mar,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Yokoten')as y_mar,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Process')as p_ap,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Quality')as q_ap,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Handling')as h_ap,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = '5S')as s5_ap,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Safety')as s_ap,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Yokoten')as y_ap,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Process')as p_mei,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Quality')as q_mei,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Handling')as h_mei,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = '5S')as s5_mei,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Safety')as s_mei,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Yokoten')as y_mei,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Process')as p_jun,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Quality')as q_jun,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Handling')as h_jun,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = '5S')as s5_jun,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Safety')as s_jun,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Yokoten')as y_jun,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Process')as p_jul,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Quality')as q_jul,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Handling')as h_jul,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = '5S')as s5_jul,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Safety')as s_jul,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Yokoten')as y_jul,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Process')as p_ag,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Quality')as q_ag,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Handling')as h_ag,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = '5S')as s5_ag,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Safety')as s_ag,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Yokoten')as y_ag,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Process')as p_sep,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Quality')as q_sep,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Handling')as h_sep,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = '5S')as s5_sep,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Safety')as s_sep,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Yokoten')as y_sep,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Process')as p_ok,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Quality')as q_ok,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Handling')as h_ok,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = '5S')as s5_ok,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Safety')as s_ok,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Yokoten')as y_ok,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Process')as p_nov,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Quality')as q_nov,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Handling')as h_nov,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = '5S')as s5_nov,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Safety')as s_nov,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Yokoten')as y_nov,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Process')as p_des,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Quality')as q_des,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Handling')as h_des,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = '5S')as s5_des,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Safety')as s_des,
	(select count(section_code) from si.si_kaizen_tks where section_code = es.section_code and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Yokoten')as y_des
from
	er.er_section es
where
	es.section_code in ('325020100',
	'320010100',
	'329010103',
	'329030100',
	'330100701',
	'330101103',
	'325010805',
	'322010101',
	'321010300',
	'328010305',
	'323020101',
	'323010100',
	'323030102',
	'331010103',
	'326010100',
	'324010101')
group by
	es.section_code,
	es.section_name,
	es.unit_name
order by
	es.section_name
		");
		return $query->result_array();
	}
}
