<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * KHUSUS SUPERVISOR & OPERATOR
 */

class M_kaizentimtks extends CI_Model
{
	// kode lokasi kerja tuksono
	public $location_code_tuksono = '02';
	public $operator_kd_jabatan = "'13', '15', '17', '18', '20', '21', '23', '24' , '22'";

	function __construct()
	{
		parent::__construct();
		$this->erp = $this->load->database('erp_db', true);
		$this->personalia = $this->load->database('personalia', true);
	}

	/**
	 * Convert Year month to indonesian format
	 * 
	 * @param String $tanggal YYYY-MM
	 */
	function tgl_indo($tanggal)
	{
		$bulan = array(
			1 => 'Januari',
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
		// Array destructor
		list($tahun, $month) = explode('-', $tanggal);

		return $tahun . ' ' . $bulan[(int)$month];
	}

	/**
	 * TODO: Slow execution time
	 * select Jumlah pekerja yang membuat kaizen per bulan dalam 1 tahun
	 * 
	 * @param String $year
	 * @return Array<Array>
	 */
	public function getDataKaizenTotalPekerjaSatuTahun($year)
	{
		$queryString = "
			SELECT
				n1.*,
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
			FROM (
				select
					distinct left(es.section_code, 7) section_code,
					es.section_name,
					es.unit_name,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-01'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-01'
					) as plan_januari,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-01'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_januari,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-02' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-02'
					)as plan_februari,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-02'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_februari,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-03' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-03'
					)as plan_maret,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-03'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_maret,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-04' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-04'
					)as plan_april,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-04'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_april,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-05' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-05'
					) as plan_mei,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-05'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_mei,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-06' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-06'
					)as plan_juni,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-06'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_juni,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-07' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-07'
					) as plan_juli,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-07'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_juli,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-08' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-08'
					) as plan_agustus,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-08'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_agustus,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-09'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-09'
					) as plan_september,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-09'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_september,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-10' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-10'
					) as plan_oktober,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-10'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_oktober,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-11'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-11'
					) as plan_november,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-11'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_november,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-12' 
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-12'
					)as plan_desember,
					(
						select
							count(distinct skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-12'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_desember
				from
					er.er_section es
				left join si.si_kaizen_tks skt on
					es.section_code = skt.section_code
				where
					left(es.section_code, 7) in (
						select 
							distinct left(section_code, 7) 
						from 
							er.er_employee_all 
						where 
							to_char(resign_date, 'YYYY-MM') >= '$year-01'
							and location_code = '$this->location_code_tuksono' 
							and trim(section_code) <> '-'
					)
					and trim(section_name) not in ('-', '')
					and location_code = '$this->location_code_tuksono'
				group by
					es.section_code,
					es.section_name,
					es.unit_name,
					skt.created_at
				order by
					es.section_name
			) as n1
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
			order by n1.section_name
		";

		$query = $this->erp->query($queryString);
		return $query->result_array();
	}

	/**
	 * select Jumlah pekerja yang membuat kaizen per hari dalam 1 bulan 
	 * 
	 * @param String $yearMonth
	 * @return Array<Array> 
	 */
	public function getDataKaizenTotalPekerjaSatuBulan($yearMonth)
	{
		$query = $this->erp->query("
			SELECT
				distinct left(es.section_code, 7) section_code,
				es.section_name,
				es.unit_name,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-01')as a,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-02')as b,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-03')as c,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-04')as d,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-05')as e,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-06')as f,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-07')as g,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-08')as h,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-09')as i,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-10')as j,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-11')as k,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-12')as l,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-13')as m,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-14')as n,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-15')as o,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-16')as p,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-17')as q,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-18')as r,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-19')as s,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-20')as t,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-21')as u,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-22')as v,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-23')as w,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-24')as x,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-25')as y,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-26')as z,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-27')as ab,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-28')as cd,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-29')as ef,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-30')as gh,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-31')as ij,
				(select count(distinct no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$yearMonth')as total
			FROM
				er.er_section es
			where
				left(es.section_code, 7) in (
					select 
						distinct left(section_code, 7) 
					from 
						er.er_employee_all 
					where 
						to_char(resign_date, 'YYYY-MM') >= '$yearMonth'
						and location_code = '$this->location_code_tuksono' 
						and trim(section_code) <> '-'
				)
				and trim(section_name) not in ('-', '')
				and location_code = '$this->location_code_tuksono'
			group by
				es.section_code,
				es.section_name,
				es.unit_name
			order by
				es.section_name
		");

		return $query->result_array();
	}

	/**
	 * TODO: Slow execution time
	 * Query sama seperti function getDataKaizenTotalPekerjaSatuTahun
	 * tetapi tidak ada distinct di kolom actual
	 * 
	 * select Jumlah pekerja yang membuat kaizen per bulan dalam 1 tahun
	 * 
	 * @param String $year
	 * @return Array<Array>
	 */
	public function getDataKaizenTotalKaizenSatuTahun($year)
	{
		$queryString = "
			SELECT
				n1.*,
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
			FROM (
				select
					distinct left(es.section_code, 7) section_code,
					es.section_name,
					es.unit_name,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-01'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-01'
					) as plan_januari,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-01'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_januari,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-02'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-02'
					)as plan_februari,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-02'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_februari,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-03'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-03'
					)as plan_maret,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-03'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_maret,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-04'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-04'
					)as plan_april,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-04'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_april,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-05'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-05'
					) as plan_mei,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-05'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_mei,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-06'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-06'
					)as plan_juni,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-06'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_juni,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-07'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-07'
					) as plan_juli,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-07'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_juli,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-08'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-08'
					) as plan_agustus,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-08'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_agustus,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-09'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-09'
					) as plan_september,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-09'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_september,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-10'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-10'
					) as plan_oktober,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-10'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_oktober,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-11
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-11'
					) as plan_november,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-11'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_november,
					(
						select
							count(section_code)
						from
							er.er_employee_all
						where
							left(section_code, 7) = left(es.section_code, 7)
							and to_char(resign_date, 'YYYY-MM') >= '$year-12'
							and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-12'
					)as plan_desember,
					(
						select
							count(skt.no_ind)
						from
							si.si_kaizen_tks skt
						where
							to_char(skt.created_at, 'YYYY-MM') = '$year-12'
							and left(es.section_code, 7) = left(skt.section_code, 7)
					) as actual_desember
				from
					er.er_section es
				left join si.si_kaizen_tks skt on
					es.section_code = skt.section_code
				where
					left(es.section_code, 7) in (
						select 
						distinct left(section_code, 7) 
					from 
						er.er_employee_all 
					where 
						to_char(resign_date, 'YYYY-MM') >= '$year-01'
						and location_code = '$this->location_code_tuksono' 
						and trim(section_code) <> '-'	
					)
					and trim(section_name) not in ('-', '')
					and location_code = '$this->location_code_tuksono'
				group by
					es.section_code,
					es.section_name,
					es.unit_name,
					skt.created_at
				order by
					es.section_name
			) as n1
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
			order by n1.section_name
		";

		$query = $this->erp->query($queryString);
		return $query->result_array();
	}

	/**
	 * select Jumlah kaizen per hari dalam 1 bulan  
	 * 
	 * @param String $yearMonth
	 * @return Array<Array>
	 */
	public function getDataKaizenTotalKaizenSatuBulan($yearMonth)
	{
		$query = $this->erp->query("
			select
				distinct left(es.section_code, 7) section_code,
				es.section_name,
				es.unit_name,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-01')as a,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-02')as b,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-03')as c,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-04')as d,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-05')as e,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-06')as f,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-07')as g,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-08')as h,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-09')as i,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-10')as j,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-11')as k,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-12')as l,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-13')as m,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-14')as n,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-15')as o,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-16')as p,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-17')as q,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-18')as r,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-19')as s,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-20')as t,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-21')as u,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-22')as v,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-23')as w,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-24')as x,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-25')as y,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-26')as z,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-27')as ab,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-28')as cd,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-29')as ef,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-30')as gh,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM-DD') = '$yearMonth-31')as ij,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$yearMonth')as total
			from
				er.er_section es
			where
				left(es.section_code, 7) in (
					select 
						distinct left(section_code, 7) 
					from 
						er.er_employee_all 
					where 
						to_char(resign_date, 'YYYY-MM') >= '$yearMonth'
						and location_code = '$this->location_code_tuksono' 
						and trim(section_code) <> '-'	
				)
				and trim(section_name) not in ('-', '')
				and location_code = '$this->location_code_tuksono'
			group by
				es.section_code,
				es.section_name,
				es.unit_name
			order by
				es.section_name
		");

		return $query->result_array();
	}

	/**
	 * Select jumlah kategori kaizen per seksi per dalam 1 tahun
	 * 
	 * @param String $year
	 * @return Array<Array>
	 */
	public function getDataKaizenKategoriKaizenTahunan($year)
	{
		$query = $this->erp->query("
			select
				distinct left(es.section_code, 7) section_code,
				es.section_name,
				es.unit_name,
				(select count(section_code) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Process')as p,
				(select count(section_code) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Quality')as q,
				(select count(section_code) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Handling')as h,
				(select count(section_code) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY') = '$year' and kaizen_category = '5S')as s5,
				(select count(section_code) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Safety')as s,
				(select count(section_code) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY') = '$year' and kaizen_category = 'Yokoten')as y
			from
				er.er_section es
			where
				left(es.section_code, 7) in (
					select 
						distinct left(section_code, 7) 
					from 
						er.er_employee_all 
					where 
						to_char(resign_date, 'YYYY-MM') >= '$year-01'
						and location_code = '$this->location_code_tuksono' 
						and trim(section_code) <> '-'
				)
				and trim(section_name) not in ('-', '')
				and location_code = '$this->location_code_tuksono'
			group by
				es.section_code,
				es.section_name,
				es.unit_name
			order by
				es.section_name
		");
		return $query->result_array();
	}

	/**
	 * Select jumlah kaizen dengan semua kategori per seksi per bulan dalam 1 tahun
	 * 
	 * @param String $year
	 * @return Array<Array>
	 */
	public function getDataKaizenKategoriBulanan($year)
	{
		$query = $this->erp->query("
			select
				distinct left(es.section_code, 7) section_code,
				es.section_name,
				es.unit_name,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Process')as p_jan,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Quality')as q_jan,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Handling')as h_jan,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = '5S')as s5_jan,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Safety')as s_jan,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-01' and kaizen_category = 'Yokoten')as y_jan,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Process')as p_feb,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Quality')as q_feb,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Handling')as h_feb,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = '5S')as s5_feb,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Safety')as s_feb,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-02' and kaizen_category = 'Yokoten')as y_feb,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Process')as p_mar,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Quality')as q_mar,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Handling')as h_mar,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = '5S')as s5_mar,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Safety')as s_mar,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-03' and kaizen_category = 'Yokoten')as y_mar,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Process')as p_apr,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Quality')as q_apr,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Handling')as h_apr,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = '5S')as s5_apr,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Safety')as s_apr,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-04' and kaizen_category = 'Yokoten')as y_apr,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Process')as p_mei,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Quality')as q_mei,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Handling')as h_mei,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = '5S')as s5_mei,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Safety')as s_mei,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-05' and kaizen_category = 'Yokoten')as y_mei,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Process')as p_jun,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Quality')as q_jun,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Handling')as h_jun,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = '5S')as s5_jun,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Safety')as s_jun,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-06' and kaizen_category = 'Yokoten')as y_jun,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Process')as p_jul,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Quality')as q_jul,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Handling')as h_jul,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = '5S')as s5_jul,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Safety')as s_jul,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-07' and kaizen_category = 'Yokoten')as y_jul,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Process')as p_aug,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Quality')as q_aug,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Handling')as h_aug,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = '5S')as s5_aug,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Safety')as s_aug,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-08' and kaizen_category = 'Yokoten')as y_aug,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Process')as p_sep,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Quality')as q_sep,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Handling')as h_sep,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = '5S')as s5_sep,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Safety')as s_sep,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-09' and kaizen_category = 'Yokoten')as y_sep,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Process')as p_okt,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Quality')as q_okt,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Handling')as h_okt,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = '5S')as s5_okt,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Safety')as s_okt,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-10' and kaizen_category = 'Yokoten')as y_okt,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Process')as p_nov,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Quality')as q_nov,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Handling')as h_nov,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = '5S')as s5_nov,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Safety')as s_nov,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-11' and kaizen_category = 'Yokoten')as y_nov,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Process')as p_des,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Quality')as q_des,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Handling')as h_des,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = '5S')as s5_des,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Safety')as s_des,
				(select count(no_ind) from si.si_kaizen_tks where left(section_code, 7) = left(es.section_code, 7) and to_char(created_at, 'YYYY-MM') = '$year-12' and kaizen_category = 'Yokoten')as y_des
			from
				er.er_section es
			where
				left(es.section_code, 7) in (
					select 
						distinct left(section_code, 7) 
					from 
						er.er_employee_all 
					where 
						to_char(resign_date, 'YYYY-MM') >= '$year-01'
						and location_code = '$this->location_code_tuksono' 
						and trim(section_code) <> '-'	
				)
				and trim(section_name) not in ('-', '')
				and location_code = '$this->location_code_tuksono'
				group by
				es.section_code,
				es.section_name,
				es.unit_name
			order by
				es.section_name
		");
		return $query->result_array();
	}

	/**
	 * Get employee and title of kaizen tuksono by parameter
	 * 
	 * @param String $year
	 * @param String $month|Optional
	 * @param String $day|Optional
	 * @param String $section_code|Optional
	 * @param String $category|Optional
	 * @param String $noind|Optional
	 * 
	 * @return Array<Object> of detail
	 */
	public function getKaizenByParameter($year, $month = false, $day = false, $section_code = false, $category = false, $noind = false)
	{
		// validaton format
		if ($month) {
			$month = str_pad($month, 2, "0", STR_PAD_LEFT);
		}

		$query = $this->erp
			->select("
				created_at,
				no_ind,
				name,
				section_code,
				kaizen_category,
				kaizen_title,
			")
			->from('si.si_kaizen_tks');

		if ($year && !$month && !$day) {
			$query->where("TO_CHAR(created_at, 'YYYY') = ", $year);
		}
		if ($year && $month && !$day) {
			$dateMonth = "$year-$month";
			$query->where("TO_CHAR(created_at, 'YYYY-MM') = ", $dateMonth);
		}

		if ($year && $month && $day) {
			$fullDate = "$year-$month-$day";
			$query->where("TO_CHAR(created_at, 'YYYY-MM-DD') = ", $fullDate);
		}

		if ($section_code) {
			$query->like('section_code', $section_code, 'right');
		}

		if ($category) {
			$query->where('kaizen_category', $category);
		}

		if ($noind) {
			$query->where('no_ind', $noind);
		}

		return $query->get()->result_object();
	}

	/**
	 * Select Pekerja yang membuat kaizen dalam 1 bulan
	 * 
	 * @param String $year
	 * @param String $month
	 * @return Array<Object>
	 */
	public function getAllEmployeeKaizenByMonth($year, $month)
	{
		$month = str_pad($month, 2, '0', STR_PAD_LEFT);

		$sql = "
			SELECT
				distinct skt.no_ind,
				skt.name,
				skt.section,
				skt.unit
			FROM
				si.si_kaizen_tks skt
			WHERE
				to_char(skt.created_at, 'YYYY-MM') = '$year-$month'
			ORDER BY
				skt.section ASC,
				skt.name ASC
		";

		return $this->db->query($sql)->result_object();
	}

	/**
	 * Select jumlah kaizen, jumlah pembuat kaizen, jumlah pekerja Per bulan dalam 1 tahun
	 * 
	 * @param  String $year 
	 * @return Array<Array>
	 */
	public function getDetailKaizenSectionByYear($year)
	{
		$queryString = "
			SELECT
				distinct left(es.section_code, 7) section_code,
				es.section_name,
				es.unit_name,
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-01' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-01'
						and location_code = '$this->location_code_tuksono'
				) as plan_januari, -- PEKERJA
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-01'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_januari, -- PEMBUAT
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-01'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_januari, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-02' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-02'
						and location_code = '$this->location_code_tuksono'
				)as plan_februari,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-02'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_februari,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-01'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_februari, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-03' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-03'
						and location_code = '$this->location_code_tuksono'
				)as plan_maret,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-03'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_maret,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-03'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_maret, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-04' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-04'
						and location_code = '$this->location_code_tuksono'
				)as plan_april,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-04'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_april,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-04'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_april, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-05' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-05'
						and location_code = '$this->location_code_tuksono'
				) as plan_mei,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-05'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_mei,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-01'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_mei, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-06' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-06'
						and location_code = '$this->location_code_tuksono'
				)as plan_juni,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-06'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_juni,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-06'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_juni, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-07' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-07'
						and location_code = '$this->location_code_tuksono'
				) as plan_juli,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-07'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_juli,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-07'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_juli, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-08' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-08'
						and location_code = '$this->location_code_tuksono'
				) as plan_agustus,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-08'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_agustus,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-08'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_agustus, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-09'
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-09'
						and location_code = '$this->location_code_tuksono'
				) as plan_september,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-09'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_september,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-09'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_september, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-10' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-10'
						and location_code = '$this->location_code_tuksono'
				) as plan_oktober,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-10'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_oktober,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-10'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_oktober, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-11'
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-11'
						and location_code = '$this->location_code_tuksono'
				) as plan_november,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-11'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_november,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-1'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_november, -- KAIZEN
				(
					select
						count(section_code)
					from
						er.er_employee_all
					where
						left(section_code, 7) = left(es.section_code, 7)
						and to_char(resign_date, 'YYYY-MM') >= '$year-12' 
						and to_char(worker_start_working_date, 'YYYY-MM') <= '$year-12'
						and location_code = '$this->location_code_tuksono'
				)as plan_desember,
				(
					select
						count(distinct skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-12'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as actual_desember,
				(
					select
						count(skt.no_ind)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$year-12'
						and left(es.section_code, 7) = left(skt.section_code, 7)
				) as kaizen_desember -- KAIZEN
			FROM
				er.er_section es 
				left join si.si_kaizen_tks skt on es.section_code = skt.section_code
			WHERE
				left(es.section_code, 7) in (
					select 
						distinct left(section_code, 7) 
					from 
						er.er_employee_all 
					where 
						to_char(resign_date, 'YYYY-MM') >= '$year-01'
						and location_code = '$this->location_code_tuksono' 
						and trim(section_code) <> '-'
				)
				and trim(section_name) not in ('-', '')
			GROUP BY
				es.section_code,
				es.section_name,
				es.unit_name,
				skt.created_at
			ORDER BY
				es.section_name
		";

		$query = $this->erp->query($queryString);
		return $query->result_array();
	}

	/**
	 * Generate array of months
	 * 
	 * @param String $fromMonth  YYYY-MM
	 * @param String $untilMonth YYYY-MM
	 * @return Array of Year-Month
	 */
	protected function generateArrayMonthPeriode($fromMonth, $untilMonth)
	{
		$months = [];

		$month = $fromMonth;
		while ($month < $untilMonth) {
			array_push($months, $month);
			$month = date('Y-m', strtotime($month . '+1 month'));
		}

		return $months;
	}

	/**
	 * 
	 */
	public function getPercentageKaizenPerMonth($fromMonth, $untilMonth)
	{
		$data = [];
		# code...
		$months = $this->generateArrayMonthPeriode($fromMonth, $untilMonth);

		foreach ($months as $yearMonth) {
			$sql = "
				SELECT
				(
					select
						count(eea.section_code)
					from
						er.er_employee_all eea
					where
						to_char(eea.resign_date, 'YYYY-MM') >= '$yearMonth' 
						and to_char(eea.worker_start_working_date, 'YYYY-MM') <= '$yearMonth'
						and left(eea.section_code, 7) in (
							select 
								distinct left(section_code, 7) 
							from 
								er.er_employee_all 
							where 
								to_char(resign_date, 'YYYY-MM') >= '$yearMonth'
								and location_code = '$this->location_code_tuksono' 
								and trim(section_code) <> '-'
						)
				) as total_employee,
				(
					select
						count(*)
					from
						si.si_kaizen_tks skt
					where
						to_char(skt.created_at, 'YYYY-MM') = '$yearMonth'
				) as total_kaizen
			";

			$result = $this->db->query($sql)->row();
		}

		return $data;
	}

	/**
	 * 
	 */
	public function getPercentageEmployeePerMonth($fromMonth, $untilMonth)
	{
		# code...
	}
}
