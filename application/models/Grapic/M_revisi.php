<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_Revisi extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	function getDataTimeStamp() {
		return $this->personalia->select('tanggal')->limit(1)->get('hrd_khs.hr_update_data')->row()->tanggal;
	}
	
	function getData($department, $month, $currentYear) {
		switch(strtolower($department)) {
			case 'keuangan': $kodeDepartment = 1; break;
			case 'pemasaran': $kodeDepartment = 2; break;
			case 'produksi': $kodeDepartment = 3; break;
			default: $kodeDepartment = 4; break;
		}
		return $this->personalia->query("
			select kelompok, target, sum(aktual) as aktual
			from (
				select kelompok_id as kelompok, target as target, sum(aktual) as aktual
				from (
					select data_kelompok.kelompok_id as kelompok_id,
						coalesce(data_target.target, '0') as target,
						count(tabel.*) as aktual
					from (
						select distinct nik, nama, kd_jabatan, jabatan, dept, bidang, unit
						from (
							select a.noind, nik, nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar, b.*
							from hrd_khs.tpribadi a
							left join hrd_khs.tseksi b on
								a.kodesie = b.kodesie
							left join hrd_khs.torganisasi c on
								a.kd_jabatan = c.kd_jabatan
							where ((keluar = '0' and masukkerja <= cast('$currentYear-$month-30' as date)))
								and a.kode_status_kerja <> 'C'
								and left(noind, 1) not in('L', 'Z', 'M')
							union
							select a.noind, nik, nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar, b.*
							from hrd_khs.tpribadi a
							left join hrd_khs.tseksi b on a.kodesie = b.kodesie
							left join hrd_khs.torganisasi c on a.kd_jabatan = c.kd_jabatan
							where ((masukkerja <= cast('$currentYear-$month-30' as date))
								and (tglkeluar >= cast('$currentYear-$month-30' as date)
								and keluar = '1'))
								and (masukkerja >= '1945-01-01')
								and a.kode_status_kerja <> 'C'
								and left(noind, 1) not in('L', 'Z', 'M')
							order by 5
						) as tabel 
					) as tabel
					left join hrd_khs.hr_kelompok_jabatan as data_kelompok on
						cast(data_kelompok.kd_jabatan as varchar) = cast(cast(tabel.kd_jabatan as integer) as varchar)
					left join hrd_khs.hr_target_efisiensi as data_target on
						data_target.departemen = '$kodeDepartment'
						and data_target.bulan = cast('$month' as integer)
						and data_target.kelompok_id = data_kelompok.kelompok_id
					where lower(rtrim(tabel.dept)) = lower('$department')
						and tabel.jabatan is not null
						and tabel.kd_jabatan is not null
						and data_kelompok.kelompok_id is not null
					group by rtrim(tabel.dept),
						rtrim(tabel.jabatan),
						rtrim(tabel.kd_jabatan),
						data_kelompok.kelompok_id,
						data_target.target
					order by 1, 3 ) as tabel
				group by tabel.kelompok_id, tabel.target
				union
				select kelompok_id as kelompok, target as target, sum(aktual) as aktual
				from (
					select data_kelompok.kelompok_id as kelompok_id,
						coalesce(data_target.target, '0') as target,
						count(tabel.*) as aktual
					from (
						select distinct nik, nama, kode_status_kerja, jabatan, dept, bidang, unit
						from (
							select a.noind, nik, nama, kode_status_kerja, c.jabatan, masukkerja, tglkeluar, keluar, b.*
							from hrd_khs.tpribadi a
							left join hrd_khs.tseksi b on a.kodesie = b.kodesie
							left join hrd_khs.torganisasi c on a.kd_jabatan = c.kd_jabatan
							where ((keluar = '0' and masukkerja <= cast('$currentYear-$month-30' as date)))
								and a.kode_status_kerja = 'C'
								and left(noind, 1) not in('L', 'Z', 'M')
							union
							select a.noind, nik, nama, kode_status_kerja, c.jabatan, masukkerja, tglkeluar, keluar, b.*
							from hrd_khs.tpribadi a
							left join hrd_khs.tseksi b on a.kodesie = b.kodesie
							left join hrd_khs.torganisasi c on a.kd_jabatan = c.kd_jabatan
							where ((masukkerja <= cast('$currentYear-$month-30' as date))
								and (tglkeluar >= cast('$currentYear-$month-30' as date)
								and keluar = '1'))
								and (masukkerja >= '1945-01-01')
								and a.kode_status_kerja = 'C'
								and left(noind, 1) not in('L', 'Z', 'M')
							order by 5
						) as tabel
					) as tabel
					left join hrd_khs.hr_kelompok_jabatan as data_kelompok on
						cast(data_kelompok.kd_jabatan as varchar) = cast(tabel.kode_status_kerja as varchar)
					left join hrd_khs.hr_target_efisiensi as data_target on
						data_target.departemen = '$kodeDepartment'
						and data_target.bulan = cast('$month' as integer)
						and data_target.kelompok_id = data_kelompok.kelompok_id
					where lower(rtrim(tabel.dept)) = lower('$department')
						and tabel.jabatan is not null
						and tabel.kode_status_kerja is not null
						and data_kelompok.kelompok_id is not null
					group by rtrim(tabel.dept),
						rtrim(tabel.jabatan),
						rtrim(tabel.kode_status_kerja),
						data_kelompok.kelompok_id,
						data_target.target
					order by 1, 3
				) as tabel
				group by tabel.kelompok_id, tabel.target
				".($kodeDepartment == 3 || $kodeDepartment == 4 ? "
				union
				select kelompok_id as kelompok, target as target, sum(aktual) as aktual
				from (
					select data_kelompok.kelompok_id as kelompok_id, coalesce(data_target.target, '0') as target,
						count(tabel.*) ".($kodeDepartment == 3 ? "" : "* -1")." as aktual
					from (
						select distinct nik, nama, kd_jabatan, jabatan, dept, bidang, unit
						from (
							select a.noind, nik, nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar, b.*
							from hrd_khs.tpribadi a
							left join hrd_khs.tseksi b on a.kodesie = b.kodesie
							left join hrd_khs.torganisasi c on a.kd_jabatan = c.kd_jabatan
							where ((keluar = '0' and masukkerja <= cast('$currentYear-$month-30' as date)))
								and a.kode_status_kerja = 'D'
								and rtrim(upper(pendidikan)) not in ('S1', 'S2', 'S3', 'D1', 'D2', 'D3', 'D4')
								and left(a.kodesie, 1)= '4'
								and left(noind, 1) not in('L', 'Z', 'M')
							union
							select a.noind, nik, nama, c.kd_jabatan, c.jabatan, masukkerja, tglkeluar, keluar, b.*
							from hrd_khs.tpribadi a
							left join hrd_khs.tseksi b on a.kodesie = b.kodesie
							left join hrd_khs.torganisasi c on a.kd_jabatan = c.kd_jabatan
							where ((masukkerja <= cast('$currentYear-$month-30' as date)) and (tglkeluar >= cast('$currentYear-$month-30' as date) and keluar = '1'))
								and (masukkerja >= '1945-01-01')
								and a.kode_status_kerja = 'D'
								and rtrim(upper(pendidikan)) not in ('S1', 'S2', 'S3', 'D1', 'D2', 'D3', 'D4')
								and left(a.kodesie, 1)= '4'
								and left(noind, 1) not in('L', 'Z', 'M')
							order by 5
						) as tabel
					) as tabel
					left join hrd_khs.hr_kelompok_jabatan as data_kelompok on
						cast(data_kelompok.kd_jabatan as varchar) = cast(cast(tabel.kd_jabatan as integer) as varchar)
					left join hrd_khs.hr_target_efisiensi as data_target on
						data_target.departemen = '4'
						and data_target.bulan = cast('$month' as integer)
						and data_target.kelompok_id = data_kelompok.kelompok_id
					where lower(rtrim(tabel.dept)) = lower('personalia')
						and tabel.jabatan is not null
						and tabel.kd_jabatan is not null
						and data_kelompok.kelompok_id is not null
					group by rtrim(tabel.dept),
						rtrim(tabel.jabatan),
						rtrim(tabel.kd_jabatan),
						dept,
						data_kelompok.kelompok_id,
						data_target.target
					order by 1, 3
				) as tabel
				group by tabel.kelompok_id, tabel.target
				" : "")."
			) as tabel
			group by kelompok, tabel.target
			order by 1;
		")->result_array();
	}
}