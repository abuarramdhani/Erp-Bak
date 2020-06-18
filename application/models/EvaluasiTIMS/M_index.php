<?php defined('BASEPATH') OR die('No direct script access allowed');
/**
* 
*/
class M_Index extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->erp 	= 	$this->load->database('default', TRUE);
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
	}

	public function inputjp($data)
	{
		$query = $this->erp->insert('et.et_jenis_penilaian', $data);
		return true;
	}

	public function listJp()
	{
		$sql = "SELECT * from et.et_jenis_penilaian";
		$query = $this->erp->query($sql);

		return $query->result_array();
	}

	public function listJp2($term)
	{
		$sql = "SELECT * from et.et_jenis_penilaian where jenis_penilaian like '%$term%'";
		$query = $this->erp->query($sql);

		return $query->result_array();
	}

	public function listJp3($term)
	{
		$sql = "SELECT * from et.et_jenis_penilaian where id_jenis = '$term'";
		$query = $this->erp->query($sql);

		return $query->result_array();
	}

	public function updateJp($id,$data)
    {
       $this->erp->where('id_jenis', $id);
       $this->erp->update('et.et_jenis_penilaian',$data);
       return true;
    } 

    public function listHarian($t, $tim, $tims, $val)
    {
    	if ($val == '1') {
    		$sql1 = "when (a.masukkerja + interval '6 month' + interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '6 month')::date
					when (a.masukkerja + interval '6 month' + interval '5 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '5 month')::date
					when (a.masukkerja + interval '6 month' + interval '4 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '4 month')::date
					when (a.masukkerja + interval '6 month' + interval '3 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '3 month')::date
					when (a.masukkerja + interval '6 month' + interval '2 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '2 month')::date
					when (a.masukkerja + interval '6 month' + interval '1 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '1 month')::date";
			$sql2 = "when (a.masukkerja + interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month')::date
					when (a.masukkerja + interval '5 month')::date = now()::date
					then (a.masukkerja + interval '5 month')::date
					when (a.masukkerja + interval '4 month')::date = now()::date
					then (a.masukkerja + interval '4 month')::date
					when (a.masukkerja + interval '3 month')::date = now()::date
					then (a.masukkerja + interval '3 month')::date
					when (a.masukkerja + interval '2 month')::date = now()::date
					then (a.masukkerja + interval '2 month')::date
					when (a.masukkerja + interval '1 month')::date = now()::date
					then (a.masukkerja + interval '1 month')::date";
    	}elseif ($val == '2') {
    		$sql1 = "when (a.masukkerja + interval '6 month'+ interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '6 month')::date
					when (a.masukkerja + interval '6 month'+ interval '4 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '4 month')::date
					when (a.masukkerja + interval '6 month'+ interval '2 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '2 month')::date";
    		$sql2 = "when (a.masukkerja + interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month')::date
					when (a.masukkerja + interval '4 month')::date = now()::date
					then (a.masukkerja + interval '4 month')::date
					when (a.masukkerja + interval '2 month')::date = now()::date
					then (a.masukkerja + interval '2 month')::date";
    	}else{
    		$sql1 = "when (a.masukkerja + interval '6 month'+ interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '6 month')::date
					when (a.masukkerja + interval '6 month'+ interval '3 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '3 month')::date";
    		$sql2 = "when (a.masukkerja + interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month')::date
					when (a.masukkerja + interval '3 month')::date = now()::date
					then (a.masukkerja + interval '3 month')::date";
    	}
    	$sql = "select hmm.dept, count(hmm.dept), pred_lolos from (select
				et.*,
				et.telat + et.ijin + et.mangkir tim,
				et.telat + et.ijin + et.mangkir + et.sk + et.psp tims,
				et.mangkir*(cast (180 as float))/ et.jml_hari_rekap pred_m,
				(et.telat + et.ijin + et.mangkir)*(cast (180 as float))/ et.jml_hari_rekap pred_tim,
				(et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (180 as float))/ et.jml_hari_rekap pred_tims,
				case
					when (et.mangkir*(cast (180 as float))/ et.jml_hari_rekap) > $t
					or ((et.telat + et.ijin + et.mangkir)*(cast (180 as float))/ et.jml_hari_rekap) > $tim
					or ((et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (180 as float))/ et.jml_hari_rekap) > $tims
					or et.SP > 0 then 'TIDAK LOLOS'
					else 'LOLOS'
				end pred_lolos,
				case
						when (et.tgl_masuk + interval '6 month')::date < et.tgl_diangkat::date and now()::date < et.tgl_diangkat::date
						then 'PERPANJANGAN'
						when et.tgl_diangkat::date < now()::date
						then 'BELUM UPDATE'
						else 'OJT'
					end ket
			from
				(
				select
					pri.noind,
					pri.nama,
					pri.masukkerja::date tgl_masuk,
					pri.diangkat::date tgl_diangkat,
					pri.kodesie,
					tseksi.dept,
					tseksi.bidang,
					tseksi.unit,
					tseksi.seksi,
					param.tgl1 as tanggal_awal_rekap,
					param.tgl2 as tanggal_akhir_rekap,
					param.tgl2-param.tgl1 jml_hari_rekap,
					/*Terlambat - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TT'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as telat,
					/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TIK'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as ijin,
					/*Mangkir - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TM'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as mangkir,
					/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PSK'
						and datapres.noind = pri.noind ) as SK,
					/*Sakit Perusahaan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PSP'
						and datapres.noind = pri.noind ) as PSP,
					/*Ijin Perusahaan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PIP'
						and datapres.noind = pri.noind ) as IP,
					/*Cuti Tahunan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'CT'
						and datapres.noind = pri.noind ) as CT,
					/*Surat Peringatan - Status Pekerja Aktif*/
					(
					select
						count(*)
					from
						\"Surat\".v_surat_tsp_rekap as tabelsp
					where
						tabelsp.noind = pri.noind
						and (tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2) ) as SP,
					/*Hari Kerja - Aktif*/
					(
					select
						count(*)
					from
						\"Presensi\".tshiftpekerja as sftpkj
					where
						sftpkj.tanggal between param.tgl1 and param.tgl2
						and sftpkj.noind = pri.noind ) as totalhk,
					/*Masa Kerja Total*/
					(
					select
						concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
					from
						(
						select
							( masa_kerja.total_tahun + (
							case
								when masa_kerja.total_bulan>11 then floor(masa_kerja.total_bulan / 12)
								else 0
							end ) + (
							case
								when masa_kerja.total_hari>364 then floor(masa_kerja.total_hari / 365)
								else 0
							end ) ) as tahun,
							( (
							case
								when masa_kerja.total_bulan>11 then masa_kerja.total_bulan-(floor(masa_kerja.total_bulan / 12)* 12)
								else masa_kerja.total_bulan
							end ) + (
							case
								when masa_kerja.total_hari>29 then floor(masa_kerja.total_hari / 30)
								else 0
							end ) ) as bulan,
							( (
							case
								when masa_kerja.total_hari>29 then masa_kerja.total_hari-(floor(masa_kerja.total_hari / 30)* 30)
								else masa_kerja.total_hari
							end ) ) as hari
						from
							(
							select
								sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
								sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
								sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
							from
								(
								select
									pri3.*,
									(
									case
										when pri3.keluar = false then (
										case
											when pri3.kode_status_kerja in ('A',
											'B') then ( age(current_date, pri3.diangkat) )
											else ( age(current_date, pri3.masukkerja) )
										end )
										else (
										case
											when pri3.kode_status_kerja in ('A',
											'B') then ( age(pri3.tglkeluar, pri3.diangkat) )
											else ( age(pri3.tglkeluar, pri3.masukkerja) )
										end )
									end ) as masa_kerja
								from
									(
									select
										pri2.noind,
										pri2.nik,
										pri2.tgllahir,
										pri2.kode_status_kerja,
										pri2.keluar,
										pri2.masukkerja,
										pri2.diangkat,
										pri2.tglkeluar,
										pri2.akhkontrak
									from
										hrd_khs.v_hrd_khs_tpribadi as pri2
									where
										pri2.nik = pri.nik
										and pri2.tgllahir = pri.tgllahir ) as pri3 ) master_masa_kerja ) as masa_kerja ) as masa_kerja ) as masa_kerja
				from
					hrd_khs.v_hrd_khs_tpribadi as pri
				left join hrd_khs.v_hrd_khs_tseksi as tseksi on
					tseksi.kodesie = pri.kodesie
				left join hrd_khs.tnoind as tnoind on
					tnoind.fs_noind = pri.kode_status_kerja
				left join hrd_khs.torganisasi as torganisasi on
					torganisasi.kd_jabatan = pri.kd_jabatan
				left join (
					select
						case
							when a.masukkerja + interval '6 month' < a.diangkat::date then (a.masukkerja + interval '6 month')::date
							else a.masukkerja::date
						end as tgl1,
						case
							when (a.masukkerja + interval '6 month') < a.diangkat::date then
							case
								$sql1
								else null
								--a.diangkat::date
							end
							else
							case
								$sql2
								else null
							end
						end as tgl2,
						a.noind
					from
						hrd_khs.tpribadi a
					where
						a.keluar = '0') as param on
					param.noind = pri.noind
				where
					pri.noind in (
					select
						noind
					from
						hrd_khs.tpribadi
					where
						keluar = '0'
						and ((substring(noind, 1, 1) = 'D' and upper(pendidikan) in ('S1','S2','S3','D3','D4'))
						or (substring(noind, 1, 1) = 'J' and status_diangkat = '0'))
						and kd_jabatan not in ('13','14','15','17','24') )
					and param.tgl2 = now()::date
				order by
					pri.nama,
					pri.noind) et) hmm
					 group by hmm.dept, pred_lolos;";
					// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function listHarian2($t, $tim, $tims, $val)
    {
    	if ($val == '1') {
    		$sql1 = "when (a.diangkat + interval '2 years' + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '2 years' + interval '23 month')::date = now()::date
					then (a.diangkat + interval '23 month')::date
					when (a.diangkat + interval '2 years' + interval '22 month')::date = now()::date
					then (a.diangkat + interval '22 month')::date
					when (a.diangkat + interval '2 years' + interval '21 month')::date = now()::date
					then (a.diangkat + interval '21 month')::date
					when (a.diangkat + interval '2 years' + interval '20 month')::date = now()::date
					then (a.diangkat + interval '20 month')::date
					when (a.diangkat + interval '2 years' + interval '19 month')::date = now()::date
					then (a.diangkat + interval '19 month')::date
					when (a.diangkat + interval '2 years' + interval '18 month')::date = now()::date
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '2 years' + interval '17 month')::date = now()::date
					then (a.diangkat + interval '17 month')::date
					when (a.diangkat + interval '2 years' + interval '16 month')::date = now()::date
					then (a.diangkat + interval '16 month')::date
					when (a.diangkat + interval '2 years' + interval '15 month')::date = now()::date
					then (a.diangkat + interval '15 month')::date
					when (a.diangkat + interval '2 years' + interval '14 month')::date = now()::date
					then (a.diangkat + interval '14 month')::date
					when (a.diangkat + interval '2 years' + interval '13 month')::date = now()::date
					then (a.diangkat + interval '13 month')::date
					when (a.diangkat + interval '2 years' + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '2 years' + interval '11 month')::date = now()::date
					then (a.diangkat + interval '11 month')::date
					when (a.diangkat + interval '2 years' + interval '10 month')::date = now()::date
					then (a.diangkat + interval '10 month')::date
					when (a.diangkat + interval '2 years' + interval '9 month')::date = now()::date
					then (a.diangkat + interval '9 month')::date
					when (a.diangkat + interval '2 years' + interval '8 month')::date = now()::date
					then (a.diangkat + interval '8 month')::date
					when (a.diangkat + interval '2 years' + interval '7 month')::date = now()::date
					then (a.diangkat + interval '7 month')::date
					when (a.diangkat + interval '2 years' + interval '6 month')::date = now()::date
					then (a.diangkat + interval '6 month')::date
					when (a.diangkat + interval '2 years' + interval '5 month')::date = now()::date
					then (a.diangkat + interval '5 month')::date
					when (a.diangkat + interval '2 years' + interval '4 month')::date = now()::date
					then (a.diangkat + interval '4 month')::date
					when (a.diangkat + interval '2 years' + interval '3 month')::date = now()::date
					then (a.diangkat + interval '3 month')::date
					when (a.diangkat + interval '2 years' + interval '2 month')::date = now()::date
					then (a.diangkat + interval '2 month')::date
					when (a.diangkat + interval '2 years' + interval '1 month')::date = now()::date
					then (a.diangkat + interval '1 month')::date";
    	}
    	elseif ($val == '2') {
    		$sql1 = "when (a.diangkat + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '22 month')::date = now()::date
					then (a.diangkat + interval '22 month')::date
					when (a.diangkat + interval '20 month')::date = now()::date
					then (a.diangkat + interval '20 month')::date
					when (a.diangkat + interval '18 month')::date = now()::date
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '16 month')::date = now()::date
					then (a.diangkat + interval '16 month')::date
					when (a.diangkat + interval '14 month')::date = now()::date
					then (a.diangkat + interval '14 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '10 month')::date = now()::date
					then (a.diangkat + interval '10 month')::date
					when (a.diangkat + interval '8 month')::date = now()::date
					then (a.diangkat + interval '8 month')::date
					when (a.diangkat + interval '6 month')::date = now()::date
					then (a.diangkat + interval '6 month')::date
					when (a.diangkat + interval '4 month')::date = now()::date
					then (a.diangkat + interval '4 month')::date
					when (a.diangkat + interval '2 month')::date = now()::date
					then (a.diangkat + interval '2 month')::date";
    	}elseif ($val == '3') {
    		$sql1 = "when (a.diangkat + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '21 month')::date = now()::date
					then (a.diangkat + interval '21 month')::date
					when (a.diangkat + interval '18 month')::date = now()::date
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '15 month')::date = now()::date
					then (a.diangkat + interval '15 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '9 month')::date = now()::date
					then (a.diangkat + interval '9 month')::date
					when (a.diangkat + interval '6 month')::date = now()::date
					then (a.diangkat + interval '6 month')::date
					when (a.diangkat + interval '3 month')::date = now()::date
					then (a.diangkat + interval '3 month')::date";
    	}elseif ($val == '4') {
    		$sql1 = "when (a.diangkat + interval '24 month')::date now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '20 month')::date = now()::date
					then (a.diangkat + interval '20 month')::date
					when (a.diangkat + interval '16 month')::date = now()::date
					then (a.diangkat + interval '16 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '8 month')::date = now()::date
					then (a.diangkat + interval '8 month')::date
					when (a.diangkat + interval '4 month')::date = now()::date
					then (a.diangkat + interval '4 month')::date";
    	}elseif ($val == '6') {
    		$sql1 = "when (a.diangkat + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '18 month')::date = now()::date
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '6 month')::date = now()::date
					then (a.diangkat + interval '6 month')::date";
    	}else{
    		$sql1 = "when (a.diangkat + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date";
    	}
    	$sql = "select hmm.dept, count(hmm.dept), pred_lolos from (select
					et.*,
					et.mangkir m,
					et.telat + et.ijin + et.mangkir tim,
					et.telat + et.ijin + et.mangkir + et.sk + et.psp tims,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= now()::date
						then et.mangkir
						else et.mangkir*(cast (720 as float))/ et.jml_hari_rekap
					end pred_m,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= now()::date
						then et.telat + et.ijin + et.mangkir
						else (et.telat + et.ijin + et.mangkir)*(cast (720 as float))/ et.jml_hari_rekap
					end pred_tim,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= now()::date
						then et.telat + et.ijin + et.mangkir + et.sk + et.psp
						else (et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (720 as float))/ et.jml_hari_rekap
					end pred_tims,
					case	
						when (et.mangkir*(cast (720 as float))/ et.jml_hari_rekap) > 4
						or ((et.telat + et.ijin + et.mangkir)*(cast (720 as float))/ et.jml_hari_rekap) > 10
						or ((et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (720 as float))/ et.jml_hari_rekap) > 14
						or et.SP > 0 then 'TIDAK LOLOS'
						else 'LOLOS'
					end pred_lolos,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= now()::date
						then 'LEBIH DARI 2 TAHUN'
						else 'KURANG DARI 2 TAHUN'
					end ket
				from
					(
					select
						pri.noind,
						pri.nama,
						pri.masukkerja::date tgl_masuk,
						pri.diangkat::date tgl_diangkat,
						pri.kodesie,
						tseksi.dept,
						tseksi.bidang,
						tseksi.unit,
						tseksi.seksi,
						param.tgl1 as tanggal_awal_rekap,
						param.tgl2 as tanggal_akhir_rekap,
						param.tgl2-param.tgl1 jml_hari_rekap,
						/*Terlambat - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TT'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as telat,
						/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TIK'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as ijin,
						/*Mangkir - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TM'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as mangkir,
						/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PSK'
							and datapres.noind = pri.noind ) as SK,
						/*Sakit Perusahaan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PSP'
							and datapres.noind = pri.noind ) as PSP,
						/*Ijin Perusahaan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PIP'
							and datapres.noind = pri.noind ) as IP,
						/*Cuti Tahunan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'CT'
							and datapres.noind = pri.noind ) as CT,
						/*Surat Peringatan - Status Pekerja Aktif*/
						(
						select
							count(*)
						from
							\"Surat\".v_surat_tsp_rekap as tabelsp
						where
							tabelsp.noind = pri.noind
							and (tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2) ) as SP,
						/*Hari Kerja - Aktif*/
						(
						select
							count(*)
						from
							\"Presensi\".tshiftpekerja as sftpkj
						where
							sftpkj.tanggal between param.tgl1 and param.tgl2
							and sftpkj.noind = pri.noind ) as totalhk,
						/*Masa Kerja Total*/
						(
						select
							concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
						from
							(
							select
								( masa_kerja.total_tahun + (
								case
									when masa_kerja.total_bulan>11 then floor(masa_kerja.total_bulan / 12)
									else 0
								end ) + (
								case
									when masa_kerja.total_hari>364 then floor(masa_kerja.total_hari / 365)
									else 0
								end ) ) as tahun,
								( (
								case
									when masa_kerja.total_bulan>11 then masa_kerja.total_bulan-(floor(masa_kerja.total_bulan / 12)* 12)
									else masa_kerja.total_bulan
								end ) + (
								case
									when masa_kerja.total_hari>29 then floor(masa_kerja.total_hari / 30)
									else 0
								end ) ) as bulan,
								( (
								case
									when masa_kerja.total_hari>29 then masa_kerja.total_hari-(floor(masa_kerja.total_hari / 30)* 30)
									else masa_kerja.total_hari
								end ) ) as hari
							from
								(
								select
									sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
									sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
									sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
								from
									(
									select
										pri3.*,
										(
										case
											when pri3.keluar = false then (
											case
												when pri3.kode_status_kerja in ('A',
												'B') then ( age(current_date, pri3.diangkat) )
												else ( age(current_date, pri3.masukkerja) )
											end )
											else (
											case
												when pri3.kode_status_kerja in ('A',
												'B') then ( age(pri3.tglkeluar, pri3.diangkat) )
												else ( age(pri3.tglkeluar, pri3.masukkerja) )
											end )
										end ) as masa_kerja
									from
										(
										select
											pri2.noind,
											pri2.nik,
											pri2.tgllahir,
											pri2.kode_status_kerja,
											pri2.keluar,
											pri2.masukkerja,
											pri2.diangkat,
											pri2.tglkeluar,
											pri2.akhkontrak
										from
											hrd_khs.v_hrd_khs_tpribadi as pri2
										where
											pri2.nik = pri.nik
											and pri2.tgllahir = pri.tgllahir ) as pri3 ) master_masa_kerja ) as masa_kerja ) as masa_kerja ) as masa_kerja
					from
						hrd_khs.v_hrd_khs_tpribadi as pri
					left join hrd_khs.v_hrd_khs_tseksi as tseksi on
						tseksi.kodesie = pri.kodesie
					left join hrd_khs.tnoind as tnoind on
						tnoind.fs_noind = pri.kode_status_kerja
					left join hrd_khs.torganisasi as torganisasi on
						torganisasi.kd_jabatan = pri.kd_jabatan
					left join (
						select
							case
								when a.diangkat::date <> '1900-01-01' and (a.diangkat + interval '2 years')::date <= now()::date
								then (now() - interval '2 year')::date
								else a.diangkat::date
							end as tgl1,
							case
								when a.diangkat::date <> '1900-01-01' and (a.diangkat + interval '2 years')::date <= now()::date
								then now()::date
								else
									case
									$sql1									
									else null
								end
							end as tgl2,
							a.noind
						from
							hrd_khs.tpribadi a
						where
							a.keluar = '0') as param on
						param.noind = pri.noind
					where
						pri.noind in (
						select
							noind
						from
							hrd_khs.tpribadi
						where
							keluar = '0'
							and (substring(noind, 1, 1) = 'B'
							or (substring(noind, 1, 1) = 'J' and status_diangkat = '1'))
							and kd_jabatan not in ('13','14','15','17','24'))
						and param.tgl2 = now()::date
					order by
						pri.nama,
						pri.noind) et) hmm
									 group by hmm.dept, pred_lolos;";
					// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function listLt($b, $t, $tim, $tims, $val)
    {
    	if ($val == '1') {
    		$sql1 = "when (a.masukkerja + interval '6 month' + interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '6 month')::date
					when (a.masukkerja + interval '6 month' + interval '5 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '5 month')::date
					when (a.masukkerja + interval '6 month' + interval '4 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '4 month')::date
					when (a.masukkerja + interval '6 month' + interval '3 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '3 month')::date
					when (a.masukkerja + interval '6 month' + interval '2 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '2 month')::date
					when (a.masukkerja + interval '6 month' + interval '1 month')::date = now()::date
					then (a.masukkerja + interval '6 month' + interval '1 month')::date";
			$sql2 = "when (a.masukkerja + interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month')::date
					when (a.masukkerja + interval '5 month')::date = now()::date
					then (a.masukkerja + interval '5 month')::date
					when (a.masukkerja + interval '4 month')::date = now()::date
					then (a.masukkerja + interval '4 month')::date
					when (a.masukkerja + interval '3 month')::date = now()::date
					then (a.masukkerja + interval '3 month')::date
					when (a.masukkerja + interval '2 month')::date = now()::date
					then (a.masukkerja + interval '2 month')::date
					when (a.masukkerja + interval '1 month')::date = now()::date
					then (a.masukkerja + interval '1 month')::date";
    	}elseif ($val == '2') {
    		$sql1 = "when (a.masukkerja + interval '6 month'+ interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '6 month')::date
					when (a.masukkerja + interval '6 month'+ interval '4 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '4 month')::date
					when (a.masukkerja + interval '6 month'+ interval '2 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '2 month')::date";
    		$sql2 = "when (a.masukkerja + interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month')::date
					when (a.masukkerja + interval '4 month')::date = now()::date
					then (a.masukkerja + interval '4 month')::date
					when (a.masukkerja + interval '2 month')::date = now()::date
					then (a.masukkerja + interval '2 month')::date";
    	}else{
    		$sql1 = "when (a.masukkerja + interval '6 month'+ interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '6 month')::date
					when (a.masukkerja + interval '6 month'+ interval '3 month')::date = now()::date
					then (a.masukkerja + interval '6 month'+ interval '3 month')::date";
    		$sql2 = "when (a.masukkerja + interval '6 month')::date = now()::date
					then (a.masukkerja + interval '6 month')::date
					when (a.masukkerja + interval '3 month')::date = now()::date
					then (a.masukkerja + interval '3 month')::date";
    	}
    	$sql = "select
				et.*,
				et.telat + et.ijin + et.mangkir tim,
				et.telat + et.ijin + et.mangkir + et.sk + et.psp tims,
				et.mangkir*(cast (180 as float))/ et.jml_hari_rekap pred_m,
				(et.telat + et.ijin + et.mangkir)*(cast (180 as float))/ et.jml_hari_rekap pred_tim,
				(et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (180 as float))/ et.jml_hari_rekap pred_tims,
				case
					when (et.mangkir*(cast (180 as float))/ et.jml_hari_rekap) > $t
					or ((et.telat + et.ijin + et.mangkir)*(cast (180 as float))/ et.jml_hari_rekap) > $tim
					or ((et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (180 as float))/ et.jml_hari_rekap) > $tims
					or et.SP > 0 then 'TIDAK LOLOS'
					else 'LOLOS'
				end pred_lolos,
				case
						when (et.tgl_masuk + interval '6 month')::date < et.tgl_diangkat::date and now()::date < et.tgl_diangkat::date
						then 'PERPANJANGAN'
						when et.tgl_diangkat::date < now()::date
						then 'BELUM UPDATE'
						else 'OJT'
					end ket
			from
				(
				select
					pri.noind,
					pri.nama,
					pri.masukkerja::date tgl_masuk,
					pri.diangkat::date tgl_diangkat,
					pri.kodesie,
					pri.nik,
					tseksi.dept,
					tseksi.bidang,
					tseksi.unit,
					tseksi.seksi,
					param.tgl1 as tanggal_awal_rekap,
					param.tgl2 as tanggal_akhir_rekap,
					param.tgl2-param.tgl1 jml_hari_rekap,
					/*Terlambat - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TT'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as telat,
					/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TIK'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as ijin,
					/*Mangkir - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TM'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as mangkir,
					/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PSK'
						and datapres.noind = pri.noind ) as SK,
					/*Sakit Perusahaan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PSP'
						and datapres.noind = pri.noind ) as PSP,
					/*Ijin Perusahaan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PIP'
						and datapres.noind = pri.noind ) as IP,
					/*Cuti Tahunan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'CT'
						and datapres.noind = pri.noind ) as CT,
					/*Surat Peringatan - Status Pekerja Aktif*/
					(
					select
						count(*)
					from
						\"Surat\".v_surat_tsp_rekap as tabelsp
					where
						tabelsp.noind = pri.noind
						and (tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2) ) as SP,
					/*Hari Kerja - Aktif*/
					(
					select
						count(*)
					from
						\"Presensi\".tshiftpekerja as sftpkj
					where
						sftpkj.tanggal between param.tgl1 and param.tgl2
						and sftpkj.noind = pri.noind ) as totalhk,
					/*Masa Kerja Total*/
					(
					select
						concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
					from
						(
						select
							( masa_kerja.total_tahun + (
							case
								when masa_kerja.total_bulan>11 then floor(masa_kerja.total_bulan / 12)
								else 0
							end ) + (
							case
								when masa_kerja.total_hari>364 then floor(masa_kerja.total_hari / 365)
								else 0
							end ) ) as tahun,
							( (
							case
								when masa_kerja.total_bulan>11 then masa_kerja.total_bulan-(floor(masa_kerja.total_bulan / 12)* 12)
								else masa_kerja.total_bulan
							end ) + (
							case
								when masa_kerja.total_hari>29 then floor(masa_kerja.total_hari / 30)
								else 0
							end ) ) as bulan,
							( (
							case
								when masa_kerja.total_hari>29 then masa_kerja.total_hari-(floor(masa_kerja.total_hari / 30)* 30)
								else masa_kerja.total_hari
							end ) ) as hari
						from
							(
							select
								sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
								sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
								sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
							from
								(
								select
									pri3.*,
									(
									case
										when pri3.keluar = false then (
										case
											when pri3.kode_status_kerja in ('A',
											'B') then ( age(current_date, pri3.diangkat) )
											else ( age(current_date, pri3.masukkerja) )
										end )
										else (
										case
											when pri3.kode_status_kerja in ('A',
											'B') then ( age(pri3.tglkeluar, pri3.diangkat) )
											else ( age(pri3.tglkeluar, pri3.masukkerja) )
										end )
									end ) as masa_kerja
								from
									(
									select
										pri2.noind,
										pri2.nik,
										pri2.tgllahir,
										pri2.kode_status_kerja,
										pri2.keluar,
										pri2.masukkerja,
										pri2.diangkat,
										pri2.tglkeluar,
										pri2.akhkontrak
									from
										hrd_khs.v_hrd_khs_tpribadi as pri2
									where
										pri2.nik = pri.nik
										and pri2.tgllahir = pri.tgllahir ) as pri3 ) master_masa_kerja ) as masa_kerja ) as masa_kerja ) as masa_kerja
				from
					hrd_khs.v_hrd_khs_tpribadi as pri
				left join hrd_khs.v_hrd_khs_tseksi as tseksi on
					tseksi.kodesie = pri.kodesie
				left join hrd_khs.tnoind as tnoind on
					tnoind.fs_noind = pri.kode_status_kerja
				left join hrd_khs.torganisasi as torganisasi on
					torganisasi.kd_jabatan = pri.kd_jabatan
				left join (
					select
						case
							when a.masukkerja + interval '6 month' < a.diangkat::date then (a.masukkerja + interval '6 month')::date
							else a.masukkerja::date
						end as tgl1,
						case
							when (a.masukkerja + interval '6 month') < a.diangkat::date then
							case
								$sql1
								else null
								--a.diangkat::date
							end
							else
							case
								$sql2
								else null
							end
						end as tgl2,
						a.noind
					from
						hrd_khs.tpribadi a
					where
						a.keluar = '0') as param on
					param.noind = pri.noind
				where
					pri.noind in (
					select
						noind
					from
						hrd_khs.tpribadi
					where
						keluar = '0'
						and ((substring(noind, 1, 1) = 'D' and upper(pendidikan) in ('S1','S2','S3','D3','D4'))
						or (substring(noind, 1, 1) = 'J' and status_diangkat = '0'))
						and kd_jabatan not in ('13','14','15','17','24') )
					and param.tgl2 = now()::date
					and tseksi.dept = '$b'
				order by
					pri.nama,
					pri.noind) et;";
					// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function listLt2($b, $t, $tim, $tims, $val)
    {
    	if ($val == '1') {
    		$sql1 = "when (a.diangkat + interval '2 years' + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '2 years' + interval '23 month')::date = now()::date
					then (a.diangkat + interval '23 month')::date
					when (a.diangkat + interval '2 years' + interval '22 month')::date = now()::date
					then (a.diangkat + interval '22 month')::date
					when (a.diangkat + interval '2 years' + interval '21 month')::date = now()::date
					then (a.diangkat + interval '21 month')::date
					when (a.diangkat + interval '2 years' + interval '20 month')::date = now()::date
					then (a.diangkat + interval '20 month')::date
					when (a.diangkat + interval '2 years' + interval '19 month')::date = now()::date
					then (a.diangkat + interval '19 month')::date
					when (a.diangkat + interval '2 years' + interval '18 month')::date = now()::date
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '2 years' + interval '17 month')::date = now()::date
					then (a.diangkat + interval '17 month')::date
					when (a.diangkat + interval '2 years' + interval '16 month')::date = now()::date
					then (a.diangkat + interval '16 month')::date
					when (a.diangkat + interval '2 years' + interval '15 month')::date = now()::date
					then (a.diangkat + interval '15 month')::date
					when (a.diangkat + interval '2 years' + interval '14 month')::date = now()::date
					then (a.diangkat + interval '14 month')::date
					when (a.diangkat + interval '2 years' + interval '13 month')::date = now()::date
					then (a.diangkat + interval '13 month')::date
					when (a.diangkat + interval '2 years' + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '2 years' + interval '11 month')::date = now()::date
					then (a.diangkat + interval '11 month')::date
					when (a.diangkat + interval '2 years' + interval '10 month')::date = now()::date
					then (a.diangkat + interval '10 month')::date
					when (a.diangkat + interval '2 years' + interval '9 month')::date = now()::date
					then (a.diangkat + interval '9 month')::date
					when (a.diangkat + interval '2 years' + interval '8 month')::date = now()::date
					then (a.diangkat + interval '8 month')::date
					when (a.diangkat + interval '2 years' + interval '7 month')::date = now()::date
					then (a.diangkat + interval '7 month')::date
					when (a.diangkat + interval '2 years' + interval '6 month')::date = now()::date
					then (a.diangkat + interval '6 month')::date
					when (a.diangkat + interval '2 years' + interval '5 month')::date = now()::date
					then (a.diangkat + interval '5 month')::date
					when (a.diangkat + interval '2 years' + interval '4 month')::date = now()::date
					then (a.diangkat + interval '4 month')::date
					when (a.diangkat + interval '2 years' + interval '3 month')::date = now()::date
					then (a.diangkat + interval '3 month')::date
					when (a.diangkat + interval '2 years' + interval '2 month')::date = now()::date
					then (a.diangkat + interval '2 month')::date
					when (a.diangkat + interval '2 years' + interval '1 month')::date = now()::date
					then (a.diangkat + interval '1 month')::date";
    	}
    	elseif ($val == '2') {
    		$sql1 = "when (a.diangkat + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '22 month')::date = now()::date
					then (a.diangkat + interval '22 month')::date
					when (a.diangkat + interval '20 month')::date = now()::date
					then (a.diangkat + interval '20 month')::date
					when (a.diangkat + interval '18 month')::date = now()::date
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '16 month')::date = now()::date
					then (a.diangkat + interval '16 month')::date
					when (a.diangkat + interval '14 month')::date = now()::date
					then (a.diangkat + interval '14 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '10 month')::date = now()::date
					then (a.diangkat + interval '10 month')::date
					when (a.diangkat + interval '8 month')::date = now()::date
					then (a.diangkat + interval '8 month')::date
					when (a.diangkat + interval '6 month')::date = now()::date
					then (a.diangkat + interval '6 month')::date
					when (a.diangkat + interval '4 month')::date = now()::date
					then (a.diangkat + interval '4 month')::date
					when (a.diangkat + interval '2 month')::date = now()::date
					then (a.diangkat + interval '2 month')::date";
    	}elseif ($val == '3') {
    		$sql1 = "when (a.diangkat + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '21 month')::date = now()::date
					then (a.diangkat + interval '21 month')::date
					when (a.diangkat + interval '18 month')::date = now()::date
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '15 month')::date = now()::date
					then (a.diangkat + interval '15 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '9 month')::date = now()::date
					then (a.diangkat + interval '9 month')::date
					when (a.diangkat + interval '6 month')::date = now()::date
					then (a.diangkat + interval '6 month')::date
					when (a.diangkat + interval '3 month')::date = now()::date
					then (a.diangkat + interval '3 month')::date";
    	}elseif ($val == '4') {
    		$sql1 = "when (a.diangkat + interval '24 month')::date now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '20 month')::date = now()::date
					then (a.diangkat + interval '20 month')::date
					when (a.diangkat + interval '16 month')::date = now()::date
					then (a.diangkat + interval '16 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '8 month')::date = now()::date
					then (a.diangkat + interval '8 month')::date
					when (a.diangkat + interval '4 month')::date = now()::date
					then (a.diangkat + interval '4 month')::date";
    	}elseif ($val == '6') {
    		$sql1 = "when (a.diangkat + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '18 month')::date = now()::date
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '6 month')::date = now()::date
					then (a.diangkat + interval '6 month')::date";
    	}else{
    		$sql1 = "when (a.diangkat + interval '24 month')::date = now()::date
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '12 month')::date = now()::date
					then (a.diangkat + interval '12 month')::date";
    	}
    	$sql = "select
					et.*,
					et.mangkir m,
					et.telat + et.ijin + et.mangkir tim,
					et.telat + et.ijin + et.mangkir + et.sk + et.psp tims,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= now()::date
						then et.mangkir
						else et.mangkir*(cast (720 as float))/ et.jml_hari_rekap
					end pred_m,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= now()::date
						then et.telat + et.ijin + et.mangkir
						else (et.telat + et.ijin + et.mangkir)*(cast (720 as float))/ et.jml_hari_rekap
					end pred_tim,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= now()::date
						then et.telat + et.ijin + et.mangkir + et.sk + et.psp
						else (et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (720 as float))/ et.jml_hari_rekap
					end pred_tims,
					case	
						when (et.mangkir*(cast (720 as float))/ et.jml_hari_rekap) > 4
						or ((et.telat + et.ijin + et.mangkir)*(cast (720 as float))/ et.jml_hari_rekap) > 10
						or ((et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (720 as float))/ et.jml_hari_rekap) > 14
						or et.SP > 0 then 'TIDAK LOLOS'
						else 'LOLOS'
					end pred_lolos,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= now()::date
						then 'LEBIH DARI 2 TAHUN'
						else 'KURANG DARI 2 TAHUN'
					end ket
				from
					(
					select
						pri.noind,
						pri.nama,
						pri.masukkerja::date tgl_masuk,
						pri.diangkat::date tgl_diangkat,
						pri.kodesie,
						pri.nik,
						tseksi.dept,
						tseksi.bidang,
						tseksi.unit,
						tseksi.seksi,
						param.tgl1 as tanggal_awal_rekap,
						param.tgl2 as tanggal_akhir_rekap,
						param.tgl2-param.tgl1 jml_hari_rekap,
						/*Terlambat - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TT'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as telat,
						/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TIK'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as ijin,
						/*Mangkir - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TM'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as mangkir,
						/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PSK'
							and datapres.noind = pri.noind ) as SK,
						/*Sakit Perusahaan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PSP'
							and datapres.noind = pri.noind ) as PSP,
						/*Ijin Perusahaan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PIP'
							and datapres.noind = pri.noind ) as IP,
						/*Cuti Tahunan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'CT'
							and datapres.noind = pri.noind ) as CT,
						/*Surat Peringatan - Status Pekerja Aktif*/
						(
						select
							count(*)
						from
							\"Surat\".v_surat_tsp_rekap as tabelsp
						where
							tabelsp.noind = pri.noind
							and (tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2) ) as SP,
						/*Hari Kerja - Aktif*/
						(
						select
							count(*)
						from
							\"Presensi\".tshiftpekerja as sftpkj
						where
							sftpkj.tanggal between param.tgl1 and param.tgl2
							and sftpkj.noind = pri.noind ) as totalhk,
						/*Masa Kerja Total*/
						(
						select
							concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
						from
							(
							select
								( masa_kerja.total_tahun + (
								case
									when masa_kerja.total_bulan>11 then floor(masa_kerja.total_bulan / 12)
									else 0
								end ) + (
								case
									when masa_kerja.total_hari>364 then floor(masa_kerja.total_hari / 365)
									else 0
								end ) ) as tahun,
								( (
								case
									when masa_kerja.total_bulan>11 then masa_kerja.total_bulan-(floor(masa_kerja.total_bulan / 12)* 12)
									else masa_kerja.total_bulan
								end ) + (
								case
									when masa_kerja.total_hari>29 then floor(masa_kerja.total_hari / 30)
									else 0
								end ) ) as bulan,
								( (
								case
									when masa_kerja.total_hari>29 then masa_kerja.total_hari-(floor(masa_kerja.total_hari / 30)* 30)
									else masa_kerja.total_hari
								end ) ) as hari
							from
								(
								select
									sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
									sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
									sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
								from
									(
									select
										pri3.*,
										(
										case
											when pri3.keluar = false then (
											case
												when pri3.kode_status_kerja in ('A',
												'B') then ( age(current_date, pri3.diangkat) )
												else ( age(current_date, pri3.masukkerja) )
											end )
											else (
											case
												when pri3.kode_status_kerja in ('A',
												'B') then ( age(pri3.tglkeluar, pri3.diangkat) )
												else ( age(pri3.tglkeluar, pri3.masukkerja) )
											end )
										end ) as masa_kerja
									from
										(
										select
											pri2.noind,
											pri2.nik,
											pri2.tgllahir,
											pri2.kode_status_kerja,
											pri2.keluar,
											pri2.masukkerja,
											pri2.diangkat,
											pri2.tglkeluar,
											pri2.akhkontrak
										from
											hrd_khs.v_hrd_khs_tpribadi as pri2
										where
											pri2.nik = pri.nik
											and pri2.tgllahir = pri.tgllahir ) as pri3 ) master_masa_kerja ) as masa_kerja ) as masa_kerja ) as masa_kerja
					from
						hrd_khs.v_hrd_khs_tpribadi as pri
					left join hrd_khs.v_hrd_khs_tseksi as tseksi on
						tseksi.kodesie = pri.kodesie
					left join hrd_khs.tnoind as tnoind on
						tnoind.fs_noind = pri.kode_status_kerja
					left join hrd_khs.torganisasi as torganisasi on
						torganisasi.kd_jabatan = pri.kd_jabatan
					left join (
						select
							case
								when a.diangkat::date <> '1900-01-01' and (a.diangkat + interval '2 years')::date <= now()::date
								then (now() - interval '2 year')::date
								else a.diangkat::date
							end as tgl1,
							case
								when a.diangkat::date <> '1900-01-01' and (a.diangkat + interval '2 years')::date <= now()::date
								then now()::date
								else
									case									
									$sql1
									else null
								end
							end as tgl2,
							a.noind
						from
							hrd_khs.tpribadi a
						where
							a.keluar = '0') as param on
						param.noind = pri.noind
					where
						pri.noind in (
						select
							noind
						from
							hrd_khs.tpribadi
						where
							keluar = '0'
							and (substring(noind, 1, 1) = 'B'
							or (substring(noind, 1, 1) = 'J' and status_diangkat = '1'))
							and kd_jabatan not in ('13','14','15','17','24'))
						and param.tgl2 = now()::date
						and tseksi.dept = '$b'
					order by
						pri.nama,
						pri.noind) et;";
					// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function listBl($tgl1, $tgl2, $t, $tim, $tims, $vali, $s)
    {
    	// echo $s;exit();
    	if ($vali == '1') {
    		$sqlnya1 = "when (a.masukkerja + interval '6 month' + interval '6 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month' + interval '6 month')::date
						when (a.masukkerja + interval '6 month' + interval '5 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month' + interval '5 month')::date
						when (a.masukkerja + interval '6 month' + interval '4 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month' + interval '4 month')::date
						when (a.masukkerja + interval '6 month' + interval '3 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month' + interval '3 month')::date
						when (a.masukkerja + interval '6 month' + interval '2 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month' + interval '2 month')::date
						when (a.masukkerja + interval '6 month' + interval '1 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month' + interval '1 month')::date";
			$sqlnya2 = "when (a.masukkerja + interval '6 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month')::date
						when (a.masukkerja + interval '5 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '5 month')::date
						when (a.masukkerja + interval '4 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '4 month')::date
						when (a.masukkerja + interval '3 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '3 month')::date
						when (a.masukkerja + interval '2 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '2 month')::date
						when (a.masukkerja + interval '1 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '1 month')::date";
    	}elseif ($vali == '3') {
    		$sqlnya1 = "when (a.masukkerja + interval '6 month'+ interval '6 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month'+ interval '6 month')::date
						when (a.masukkerja + interval '6 month'+ interval '3 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month'+ interval '3 month')::date";
    		$sqlnya2 = "when (a.masukkerja + interval '6 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month')::date
						when (a.masukkerja + interval '3 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '3 month')::date";
    	}else{
    		$sqlnya1 = "when (a.masukkerja + interval '6 month'+ interval '6 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month'+ interval '6 month')::date
						when (a.masukkerja + interval '6 month'+ interval '4 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month'+ interval '4 month')::date
						when (a.masukkerja + interval '6 month'+ interval '2 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month'+ interval '2 month')::date";
			$sqlnya2 = "when (a.masukkerja + interval '6 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '6 month')::date
						when (a.masukkerja + interval '4 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '4 month')::date
						when (a.masukkerja + interval '2 month')::date between '$tgl1' and '$tgl2'
						then (a.masukkerja + interval '2 month')::date";
    	}
    	$sql = "select
				et.*,
				et.telat + et.ijin + et.mangkir tim,
				et.telat + et.ijin + et.mangkir + et.sk + et.psp tims,
				et.mangkir*(cast (180 as float))/ et.jml_hari_rekap pred_m,
				(et.telat + et.ijin + et.mangkir)*(cast (180 as float))/ et.jml_hari_rekap pred_tim,
				(et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (180 as float))/ et.jml_hari_rekap pred_tims,
				case
					when (et.mangkir*(cast (180 as float))/ et.jml_hari_rekap) > $t
					or ((et.telat + et.ijin + et.mangkir)*(cast (180 as float))/ et.jml_hari_rekap) > $tim
					or ((et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (180 as float))/ et.jml_hari_rekap) > $tims
					or et.SP > 0 then 'TIDAK LOLOS'
					else 'LOLOS'
				end pred_lolos,
				case
					when (et.tgl_masuk + interval '6 month')::date < et.tgl_diangkat::date and now()::date < et.tgl_diangkat::date
					then 'PERPANJANGAN'
					when et.tgl_diangkat::date < now()::date
					then 'BELUM UPDATE'
					else 'OJT'
				end ket
			from
				(
				select
					pri.noind,
					pri.nama,
					pri.masukkerja::date tgl_masuk,
					pri.diangkat::date tgl_diangkat,
					pri.kodesie,
					pri.nik,
					tseksi.dept,
					tseksi.bidang,
					tseksi.unit,
					tseksi.seksi,
					param.tgl1 as tanggal_awal_rekap,
					param.tgl2 as tanggal_akhir_rekap,
					param.tgl2-param.tgl1 jml_hari_rekap,
					/*Terlambat - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TT'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as telat,
					/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TIK'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as ijin,
					/*Mangkir - Status Pekerja Aktif*/
					(
					select
						coalesce(count(tim.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatatim as tim
					where
						tim.tanggal between param.tgl1 and param.tgl2
						and trim(tim.kd_ket)= 'TM'
						and tim.point>0
						and trim(tim.noind)= pri.noind ) as mangkir,
					/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PSK'
						and datapres.noind = pri.noind ) as SK,
					/*Sakit Perusahaan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PSP'
						and datapres.noind = pri.noind ) as PSP,
					/*Ijin Perusahaan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'PIP'
						and datapres.noind = pri.noind ) as IP,
					/*Cuti Tahunan - Status Pekerja Aktif*/
					(
					select
						coalesce(count(datapres.tanggal)) as total_frekuensi
					from
						\"Presensi\".tdatapresensi as datapres
					where
						datapres.tanggal between param.tgl1 and param.tgl2
						and datapres.kd_ket = 'CT'
						and datapres.noind = pri.noind ) as CT,
					/*Surat Peringatan - Status Pekerja Aktif*/
					(
					select
						count(*)
					from
						\"Surat\".v_surat_tsp_rekap as tabelsp
					where
						tabelsp.noind = pri.noind
						and (tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2) ) as SP,
					/*Hari Kerja - Aktif*/
					(
					select
						count(*)
					from
						\"Presensi\".tshiftpekerja as sftpkj
					where
						sftpkj.tanggal between param.tgl1 and param.tgl2
						and sftpkj.noind = pri.noind ) as totalhk,
					/*Masa Kerja Total*/
					(
					select
						concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
					from
						(
						select
							( masa_kerja.total_tahun + (
							case
								when masa_kerja.total_bulan>11 then floor(masa_kerja.total_bulan / 12)
								else 0
							end ) + (
							case
								when masa_kerja.total_hari>364 then floor(masa_kerja.total_hari / 365)
								else 0
							end ) ) as tahun,
							( (
							case
								when masa_kerja.total_bulan>11 then masa_kerja.total_bulan-(floor(masa_kerja.total_bulan / 12)* 12)
								else masa_kerja.total_bulan
							end ) + (
							case
								when masa_kerja.total_hari>29 then floor(masa_kerja.total_hari / 30)
								else 0
							end ) ) as bulan,
							( (
							case
								when masa_kerja.total_hari>29 then masa_kerja.total_hari-(floor(masa_kerja.total_hari / 30)* 30)
								else masa_kerja.total_hari
							end ) ) as hari
						from
							(
							select
								sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
								sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
								sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
							from
								(
								select
									pri3.*,
									(
									case
										when pri3.keluar = false then (
										case
											when pri3.kode_status_kerja in ('A',
											'B') then ( age(current_date, pri3.diangkat) )
											else ( age(current_date, pri3.masukkerja) )
										end )
										else (
										case
											when pri3.kode_status_kerja in ('A',
											'B') then ( age(pri3.tglkeluar, pri3.diangkat) )
											else ( age(pri3.tglkeluar, pri3.masukkerja) )
										end )
									end ) as masa_kerja
								from
									(
									select
										pri2.noind,
										pri2.nik,
										pri2.tgllahir,
										pri2.kode_status_kerja,
										pri2.keluar,
										pri2.masukkerja,
										pri2.diangkat,
										pri2.tglkeluar,
										pri2.akhkontrak
									from
										hrd_khs.v_hrd_khs_tpribadi as pri2
									where
										pri2.nik = pri.nik
										and pri2.tgllahir = pri.tgllahir ) as pri3 ) master_masa_kerja ) as masa_kerja ) as masa_kerja ) as masa_kerja
				from
					hrd_khs.v_hrd_khs_tpribadi as pri
				left join hrd_khs.v_hrd_khs_tseksi as tseksi on
					tseksi.kodesie = pri.kodesie
				left join hrd_khs.tnoind as tnoind on
					tnoind.fs_noind = pri.kode_status_kerja
				left join hrd_khs.torganisasi as torganisasi on
					torganisasi.kd_jabatan = pri.kd_jabatan
				left join (
					select
						case
							when a.masukkerja + interval '6 month' < a.diangkat::date then (a.masukkerja + interval '6 month')::date
							else a.masukkerja::date
						end as tgl1,
						case
							when (a.masukkerja + interval '6 month') < a.diangkat::date then
							case
								$sqlnya1								
								else null
							end
							else
							case
								$sqlnya2								
								else null
							end
						end as tgl2,
						a.noind
					from
						hrd_khs.tpribadi a
					where
						a.keluar = '0') as param on
					param.noind = pri.noind
				where
					pri.noind in (
					select
						noind
					from
						hrd_khs.tpribadi
					where
						keluar = '0'
						and ((substring(noind, 1, 1) = 'D' and upper(pendidikan) in ('S1','S2','S3','D3','D4'))
						or (substring(noind, 1, 1) = 'J' and status_diangkat = '0'))
						and kd_jabatan not in ('13','14','15','17','24') )
					and param.tgl2 between '$tgl1' and '$tgl2'
				order by
					pri.nama,
					pri.noind) et
					where $s";
					// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function listBl2($tgl1, $tgl2, $t, $tim, $tims, $vali, $s)
    {
    	if ($vali == '1') {
	    		$case1 = "when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '23 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '23 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '22 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '22 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '21 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '21 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '19 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '19 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '17 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '17 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '15 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '15 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '14 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '14 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '13 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '13 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '11 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '11 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '10 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '10 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '9 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '9 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '7 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '7 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '5 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '5 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '3 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '3 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '2 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '2 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '1 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '1 month' - interval '2 years')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) - interval '2 years')::date";
			$case2 = "when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '23 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '23 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '22 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '22 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '21 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '21 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '19 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '19 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '17 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '17 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '15 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '15 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '14 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '14 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '13 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '13 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '11 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '11 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '10 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '10 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '9 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '9 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '7 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '7 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '5 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '5 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '3 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '3 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '2 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '2 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '1 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '1 month')::date
					when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date";
			$sqltambahan = "when (a.diangkat + interval '24 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '24 month')::date
					when (a.diangkat + interval '23 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '23 month')::date
					when (a.diangkat + interval '22 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '22 month')::date
					when (a.diangkat + interval '21 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '21 month')::date
					when (a.diangkat + interval '20 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '20 month')::date
					when (a.diangkat + interval '19 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '19 month')::date
					when (a.diangkat + interval '18 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '18 month')::date
					when (a.diangkat + interval '17 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '17 month')::date
					when (a.diangkat + interval '16 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '16 month')::date
					when (a.diangkat + interval '15 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '15 month')::date
					when (a.diangkat + interval '14 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '14 month')::date
					when (a.diangkat + interval '13 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '13 month')::date
					when (a.diangkat + interval '12 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '12 month')::date
					when (a.diangkat + interval '11 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '11 month')::date
					when (a.diangkat + interval '10 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '10 month')::date
					when (a.diangkat + interval '9 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '9 month')::date
					when (a.diangkat + interval '8 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '8 month')::date
					when (a.diangkat + interval '7 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '7 month')::date
					when (a.diangkat + interval '6 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '6 month')::date
					when (a.diangkat + interval '5 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '5 month')::date
					when (a.diangkat + interval '4 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '4 month')::date
					when (a.diangkat + interval '3 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '3 month')::date
					when (a.diangkat + interval '2 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '2 month')::date
					when (a.diangkat + interval '1 month')::date between '$tgl1' and '$tgl2'
					then (a.diangkat + interval '1 month')::date";
    	}
    	elseif ($vali == '2') {
    		$sqltambahan = "when (a.diangkat + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '24 month')::date
							when (a.diangkat + interval '22 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '22 month')::date
							when (a.diangkat + interval '20 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '20 month')::date
							when (a.diangkat + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '18 month')::date
							when (a.diangkat + interval '16 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '16 month')::date
							when (a.diangkat + interval '14 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '14 month')::date
							when (a.diangkat + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '12 month')::date
							when (a.diangkat + interval '10 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '10 month')::date
							when (a.diangkat + interval '8 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '8 month')::date
							when (a.diangkat + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '6 month')::date
							when (a.diangkat + interval '4 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '4 month')::date
							when (a.diangkat + interval '2 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '2 month')::date";
			$case1		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '22 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '22 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '14 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '14 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '10 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '10 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '2 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '2 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) - interval '2 years')::date";
			$case2		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '22 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '22 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '14 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '14 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '10 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '10 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '2 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '2 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date";
    	}elseif ($vali == '3') {
    		$sqltambahan = "when (a.diangkat + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '24 month')::date
							when (a.diangkat + interval '21 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '21 month')::date
							when (a.diangkat + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '18 month')::date
							when (a.diangkat + interval '15 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '15 month')::date
							when (a.diangkat + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '12 month')::date
							when (a.diangkat + interval '9 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '9 month')::date
							when (a.diangkat + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '6 month')::date
							when (a.diangkat + interval '3 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '3 month')::date";
			$case1		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '21 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '21 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '15 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '15 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '9 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '9 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '3 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '3 month' - interval '2 years')::
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) - interval '2 years')::date";
			$case2		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '21 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '21 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '15 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '15 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '9 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '9 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '3 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '3 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date";
    	}elseif ($vali == '4') {
    		$sqltambahan = "when (a.diangkat + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '24 month')::date
							when (a.diangkat + interval '20 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '20 month')::date
							when (a.diangkat + interval '16 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '16 month')::date
							when (a.diangkat + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '12 month')::date
							when (a.diangkat + interval '8 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '8 month')::date
							when (a.diangkat + interval '4 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '4 month')::date";
			$case1		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) - interval '2 years')::date";
			$case2		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '20 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '16 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '8 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '4 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date";
    	}elseif ($vali == '6') {
    		$sqltambahan = "when (a.diangkat + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '24 month')::date
							when (a.diangkat + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '18 month')::date
							when (a.diangkat + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '12 month')::date
							when (a.diangkat + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '6 month')::date";
			$case1		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) - interval '2 years')::date";
			$case2		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '18 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '6 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date";
    	}else{
    		$sqltambahan = "when (a.diangkat + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '24 month')::date
							when (a.diangkat + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '12 month')::date";
			$case1		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month' - interval '2 years')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) - interval '2 years')::date";
			$case2		=	"when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '24 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)) + interval '12 month')::date
							when (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date between '$tgl1' and '$tgl2'
							then (a.diangkat + interval '1 year' * (date_part('year','$tgl2'::date)-date_part('year',a.diangkat)))::date";
    	}

    	$case1 = str_replace(')) + interval ', ")) - interval '1 year' + interval ", $case1);
    	$case2 = str_replace(')) + interval ', ")) - interval '1 year' + interval ", $case2);
    	$sql = "select
					et.*,
					et.mangkir m,
					et.telat + et.ijin + et.mangkir tim,
					et.telat + et.ijin + et.mangkir + et.sk + et.psp tims,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= '$tgl2' then et.mangkir
						else et.mangkir*(cast (720 as float))/ et.jml_hari_rekap
					end pred_m,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= '$tgl2' then et.telat + et.ijin + et.mangkir
						else (et.telat + et.ijin + et.mangkir)*(cast (720 as float))/ et.jml_hari_rekap
					end pred_tim,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= '$tgl2' then et.telat + et.ijin + et.mangkir + et.sk + et.psp
						else (et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (720 as float))/ et.jml_hari_rekap
					end pred_tims,
					case	
						when (et.mangkir*(cast (720 as float))/ et.jml_hari_rekap) > 4
						or ((et.telat + et.ijin + et.mangkir)*(cast (720 as float))/ et.jml_hari_rekap) > 10
						or ((et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (720 as float))/ et.jml_hari_rekap) > 14
						or et.SP > 0 then 'TIDAK LOLOS'
						else 'LOLOS'
					end pred_lolos,
					case
						when et.tgl_diangkat::date <> '1900-01-01' and (et.tgl_diangkat + interval '2 years')::date <= '$tgl2'
						then 'LEBIH DARI 2 TAHUN'
						else 'KURANG DARI 2 TAHUN'
					end ket
				from
					(
					select
						pri.noind,
						pri.nama,
						pri.masukkerja::date tgl_masuk,
						pri.diangkat::date tgl_diangkat,
						pri.kodesie,
						pri.nik,
						tseksi.dept,
						tseksi.bidang,
						tseksi.unit,
						tseksi.seksi,
						param.tgl1 as tanggal_awal_rekap,
						param.tgl2 as tanggal_akhir_rekap,
						param.tgl2-param.tgl1 jml_hari_rekap,
						/*Terlambat - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TT'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as telat,
						/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TIK'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as ijin,
						/*Mangkir - Status Pekerja Aktif*/
						(
						select
							coalesce(count(tim.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatatim as tim
						where
							tim.tanggal between param.tgl1 and param.tgl2
							and trim(tim.kd_ket)= 'TM'
							and tim.point>0
							and trim(tim.noind)= pri.noind ) as mangkir,
						/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PSK'
							and datapres.noind = pri.noind ) as SK,
						/*Sakit Perusahaan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PSP'
							and datapres.noind = pri.noind ) as PSP,
						/*Ijin Perusahaan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'PIP'
							and datapres.noind = pri.noind ) as IP,
						/*Cuti Tahunan - Status Pekerja Aktif*/
						(
						select
							coalesce(count(datapres.tanggal)) as total_frekuensi
						from
							\"Presensi\".tdatapresensi as datapres
						where
							datapres.tanggal between param.tgl1 and param.tgl2
							and datapres.kd_ket = 'CT'
							and datapres.noind = pri.noind ) as CT,
						/*Surat Peringatan - Status Pekerja Aktif*/
						(
						select
							count(*)
						from
							\"Surat\".v_surat_tsp_rekap as tabelsp
						where
							tabelsp.noind = pri.noind
							and (tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2) ) as SP,
						/*Hari Kerja - Aktif*/
						(
						select
							count(*)
						from
							\"Presensi\".tshiftpekerja as sftpkj
						where
							sftpkj.tanggal between param.tgl1 and param.tgl2
							and sftpkj.noind = pri.noind ) as totalhk,
						/*Masa Kerja Total*/
						(
						select
							concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
						from
							(
							select
								( masa_kerja.total_tahun + (
								case
									when masa_kerja.total_bulan>11 then floor(masa_kerja.total_bulan / 12)
									else 0
								end ) + (
								case
									when masa_kerja.total_hari>364 then floor(masa_kerja.total_hari / 365)
									else 0
								end ) ) as tahun,
								( (
								case
									when masa_kerja.total_bulan>11 then masa_kerja.total_bulan-(floor(masa_kerja.total_bulan / 12)* 12)
									else masa_kerja.total_bulan
								end ) + (
								case
									when masa_kerja.total_hari>29 then floor(masa_kerja.total_hari / 30)
									else 0
								end ) ) as bulan,
								( (
								case
									when masa_kerja.total_hari>29 then masa_kerja.total_hari-(floor(masa_kerja.total_hari / 30)* 30)
									else masa_kerja.total_hari
								end ) ) as hari
							from
								(
								select
									sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
									sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
									sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
								from
									(
									select
										pri3.*,
										(
										case
											when pri3.keluar = false then (
											case
												when pri3.kode_status_kerja in ('A',
												'B') then ( age(current_date, pri3.diangkat) )
												else ( age(current_date, pri3.masukkerja) )
											end )
											else (
											case
												when pri3.kode_status_kerja in ('A',
												'B') then ( age(pri3.tglkeluar, pri3.diangkat) )
												else ( age(pri3.tglkeluar, pri3.masukkerja) )
											end )
										end ) as masa_kerja
									from
										(
										select
											pri2.noind,
											pri2.nik,
											pri2.tgllahir,
											pri2.kode_status_kerja,
											pri2.keluar,
											pri2.masukkerja,
											pri2.diangkat,
											pri2.tglkeluar,
											pri2.akhkontrak
										from
											hrd_khs.v_hrd_khs_tpribadi as pri2
										where
											pri2.nik = pri.nik
											and pri2.tgllahir = pri.tgllahir ) as pri3 ) master_masa_kerja ) as masa_kerja ) as masa_kerja ) as masa_kerja
					from
						hrd_khs.v_hrd_khs_tpribadi as pri
					left join hrd_khs.v_hrd_khs_tseksi as tseksi on
						tseksi.kodesie = pri.kodesie
					left join hrd_khs.tnoind as tnoind on
						tnoind.fs_noind = pri.kode_status_kerja
					left join hrd_khs.torganisasi as torganisasi on
						torganisasi.kd_jabatan = pri.kd_jabatan
					left join (
						select
							case
								when a.diangkat::date <> '1900-01-01' and (a.diangkat + interval '2 years')::date <= '$tgl2'
								then 
									case
									$case1
									else null
								end
								else a.diangkat::date
							end as tgl1,
							case
								when a.diangkat::date <> '1900-01-01' and (a.diangkat + interval '2 years')::date <= '$tgl2'
								then
									case
									$case2
									else null
								end
								else
									case
									$sqltambahan
									else null
								end
							end as tgl2,
							a.noind
						from
							hrd_khs.tpribadi a
						where
							a.keluar = '0') as param on
						param.noind = pri.noind
					where
						pri.noind in (
						select
							noind
						from
							hrd_khs.tpribadi
						where
							keluar = '0'
							and (substring(noind, 1, 1) = 'B'
							or (substring(noind, 1, 1) = 'J' and status_diangkat = '1'))
							and kd_jabatan not in ('13','14','15','17','24')
							)
						and param.tgl2 between '$tgl1' and '$tgl2'
					order by
						pri.nama,
						pri.noind) et
						where $s;";
						// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function saveLama($id,$val)
    {
    	$sql = "UPDATE et.et_lama_penilaian set lama_penilaian = '$val' where id = '$id'";
    	$query = $this->erp->query($sql);

    	return true;
    }

    public function getVal()
    {
    	$sql = "select * from et.et_lama_penilaian order by id asc";
    	$query = $this->erp->query($sql);

    	return $query->result_array();
    }

    public function getVal2($id)
    {
    	$sql = "select * from et.et_lama_penilaian where id = '$id' order by id asc";
    	$query = $this->erp->query($sql);

    	return $query->row()->lama_penilaian;
    }

    public function getVal3($id)
    {
    	$sql = "SELECT el.*, ep.jenis_penilaian FROM et.et_lama_penilaian el
				left join et.et_jenis_penilaian ep on el.id = ep.id_jenis 
				where id = '$id' order by id asc";
    	$query = $this->erp->query($sql);

    	return $query->result_array();
    }

    public function getListMemo()
    {
    	$sql = "SELECT em.*, initcap(ee.employee_name) nama from et.et_memo em
				left join er.er_employee_all ee on ee.employee_code = em.kasie_pdev
				where id != '1' order by em.create_date desc;";
    	$query = $this->erp->query($sql);

    	return $query->result_array();
    }

    public function getKadept($s, $id)
    {
    	if ($id == '1') {
    		$sel = "ts.dept";
    		$and = "and ts.bidang like '-%'";
    		$sqla = "select
						rtrim(ts.dept) pilih,
						ts.kodesie
					from
						hrd_khs.tpribadi tp,
						hrd_khs.tseksi ts
					where
						tp.kodesie = ts.kodesie
						and tp.keluar = '0'
						and (tp.kd_jabatan between '02' and '09'
						or noind like 'G1041')
						and ts.bidang like '-%'
						and ts.dept like '%$s%'
					order by
						ts.dept;";
			$sql = "select distinct trim(dept) pilih, substring(kodesie,1,1) kodesie FROM hrd_khs.tseksi
					where trim(dept) <> '-'
					order by 1";
    	}elseif ($id == '2') {
    		$sel = "ts.bidang";
    		$and = "and ts.bidang not like '-%' and ts.unit like '-%'";
    		$sql = "select distinct trim(bidang) pilih, substring(kodesie,1,1) kodesie FROM hrd_khs.tseksi
					where trim(bidang) <> '-' and bidang like '%$s%'
					order by 1";
    	}elseif ($id == '3') {
    		$sel = "ts.unit";
    		$and = "and ts.unit not like '-%'";
    		$sql = "select distinct trim(unit) pilih, substring(kodesie,1,1) kodesie FROM hrd_khs.tseksi
					where trim(unit) <> '-' and unit like '%$s%'
					order by 1";
    	}else{
    		$sel = "ts.seksi";
    		$and = "and ts.unit not like '-%'";
    		$sql = "select distinct trim(seksi) pilih, substring(kodesie,1,1) kodesie FROM hrd_khs.tseksi
					where trim(seksi) <> '-' and seksi like '%$s%'
					order by 1";
    	}
				// echo $sql;exit();
		$query = $this->personalia->query($sql);

		return $query->result_array();
    }

    public function getNamaKadept($id, $text, $ks)
    {
    	if ($id == '1') {
    		$add = "and (noind = 'G1041' or kd_jabatan between '02' and '04')";
    	}elseif ($id == '2') {
    		$add = "and (noind = 'G1041' or kd_jabatan between '02' and '07')";
    	}elseif ($id == '3') {
    		$add = "and (noind = 'G1041' or kd_jabatan between '02' and '09')";
    	}else{
    		$add = "and (noind = 'G1041' or kd_jabatan between '02' and '10')";
    	}
    	$sql = "SELECT noind, case when jenkel = 'L' then 'Bapak ' else 'Ibu ' end || initcap(trim(nama)) nama FROM hrd_khs.tpribadi
				where keluar = '0' $add
				and substring(kodesie,1,1) = '$ks'
				order by 2";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);

		return $query->result_array();
    }

    public function getNamaKadept2($id, $ks, $nama)
    {
    	$pos = strpos($nama, ' ');
    	$nama = strtoupper(substr($nama, ($pos+1)));
    	// echo $nama;
    	if ($id == '1') {
    		$add = "and (noind = 'G1041' or kd_jabatan between '02' and '04')";
    	}elseif ($id == '2') {
    		$add = "and (noind = 'G1041' or kd_jabatan between '02' and '07')";
    	}elseif ($id == '3') {
    		$add = "and (noind = 'G1041' or kd_jabatan between '02' and '09')";
    	}else{
    		$add = "and (noind = 'G1041' or kd_jabatan between '02' and '10')";
    	}
    	$sql = "SELECT substring(kodesie,1,1) kodesie,noind, case when jenkel = 'L' then 'Bapak ' else 'Ibu ' end || initcap(trim(nama)) nama FROM hrd_khs.tpribadi
				where keluar = '0' $add
				and substring(kodesie,1,1) = '$ks' and rtrim(nama) not like '%$nama%'
				order by 2";
				// echo $sql;exit();
		$query = $this->personalia->query($sql);

		return $query->result_array();
    }

    public function getPdev($s)
    {
    	$sql = "select
					noind,
					initcap(nama) nama
				from
					hrd_khs.tpribadi
				where
					keluar = '0'
					and kodesie like '408010%' 
					and (kd_jabatan in ('11','19') or noind = 'G1036')
				order by
					2;";

		$query = $this->personalia->query($sql);

		return $query->result_array();
    }
    public function getMemo($id = '1')
    {
    	$sql = "select memo from et.et_memo where id = '$id'";
		$query = $this->erp->query($sql);

		return $query->row()->memo;
    }

    public function getMemo2($id)
    {
    	$sql = "select * from et.et_memo where id = '$id'";
		$query = $this->erp->query($sql);

		return $query->result_array();
    }

    public function getRowMemo($id)
    {
    	$sql = "select em.*, initcap(ee.employee_name) nama from et.et_memo em
				left join er.er_employee_all ee on ee.employee_code = em.kasie_pdev
				where em.id = '$id';";
		$query = $this->erp->query($sql);

		return $query->result_array();
    }

    public function getNama($noind)
    {
    	$sql = "select
					noind,
					initcap(nama) nama
				from
					hrd_khs.tpribadi
				where
					keluar = '0'
					and noind = '$noind'
					and kodesie like '408010%'
					and (kd_jabatan in ('11','19') or noind = 'G1036')
				order by
					2;";
		$query = $this->personalia->query($sql);

		return $query->row()->nama;
    }

    public function saveMemo($data)
    {
    	$this->erp->insert('et.et_memo', $data);

    	return true;
    }

    public function saveEditMemo($data, $id)
    {
    	$this->erp->where('id=', $id);
	 	$this->erp->update('et.et_memo', $data);

    	return true;
    }

    public function getKDU()
    {
    	$sql = "select * from et.et_kdu";
    	$query = $this->db->query($sql);

    	return $query;
    }

    public function saveKdu($data)
    {
    	$this->erp->where('id=', '1');
	 	$this->erp->update('et.et_kdu', $data);

    	return true;
    }

    public function getPerpanjangan($noind, $t, $tim, $tims)
    {
    	$sql = "select
		    	et.*,
		    	et.telat + et.ijin + et.mangkir tim,
		    	et.telat + et.ijin + et.mangkir + et.sk + et.psp tims,
		    	et.mangkir*(cast (180 as float))/ et.jml_hari_rekap pred_m,
		    	(et.telat + et.ijin + et.mangkir)*(cast (180 as float))/ et.jml_hari_rekap pred_tim,
		    	(et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (180 as float))/ et.jml_hari_rekap pred_tims,
		    	case
		    	when (et.mangkir*(cast (180 as float))/ et.jml_hari_rekap) > $t
		    	or ((et.telat + et.ijin + et.mangkir)*(cast (180 as float))/ et.jml_hari_rekap) > $tim
		    	or ((et.telat + et.ijin + et.mangkir + et.sk + et.psp)*(cast (180 as float))/ et.jml_hari_rekap) > $tims
		    	or et.SP > 0 then 'TIDAK LOLOS'
		    	else 'LOLOS'
		    		end pred_lolos
		    	from
		    	(
		    	select
		    	pri.noind,
		    	pri.nama,
		    	pri.masukkerja::date tgl_masuk,
		    	pri.diangkat::date tgl_diangkat,
		    	pri.kodesie,
		    	tseksi.dept,
		    	tseksi.bidang,
		    	tseksi.unit,
		    	tseksi.seksi,
		    	param.tgl1 as tanggal_awal_rekap,
		    	param.tgl2 as tanggal_akhir_rekap,
		    	param.tgl2-param.tgl1 jml_hari_rekap,
		    	/*Terlambat - Status Pekerja Aktif*/
		    	(
		    	select
		    	coalesce(count(tim.tanggal)) as total_frekuensi
		    	from
		    	\"Presensi\".tdatatim as tim
		    	where
		    	tim.tanggal between param.tgl1 and param.tgl2
		    	and trim(tim.kd_ket)= 'TT'
		    	and tim.point>0
		    	and trim(tim.noind)= pri.noind ) as telat,
		    	/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
		    	(
		    	select
		    	coalesce(count(tim.tanggal)) as total_frekuensi
		    	from
		    	\"Presensi\".tdatatim as tim
		    	where
		    	tim.tanggal between param.tgl1 and param.tgl2
		    	and trim(tim.kd_ket)= 'TIK'
		    	and tim.point>0
		    	and trim(tim.noind)= pri.noind ) as ijin,
		    	/*Mangkir - Status Pekerja Aktif*/
		    	(
		    	select
		    	coalesce(count(tim.tanggal)) as total_frekuensi
		    	from
		    	\"Presensi\".tdatatim as tim
		    	where
		    	tim.tanggal between param.tgl1 and param.tgl2
		    	and trim(tim.kd_ket)= 'TM'
		    	and tim.point>0
		    	and trim(tim.noind)= pri.noind ) as mangkir,
		    	/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
		    	(
		    	select
		    	coalesce(count(datapres.tanggal)) as total_frekuensi
		    	from
		    	\"Presensi\".tdatapresensi as datapres
		    	where
		    	datapres.tanggal between param.tgl1 and param.tgl2
		    	and datapres.kd_ket = 'PSK'
		    	and datapres.noind = pri.noind ) as SK,
		    	/*Sakit Perusahaan - Status Pekerja Aktif*/
		    	(
		    	select
		    	coalesce(count(datapres.tanggal)) as total_frekuensi
		    	from
		    	\"Presensi\".tdatapresensi as datapres
		    	where
		    	datapres.tanggal between param.tgl1 and param.tgl2
		    	and datapres.kd_ket = 'PSP'
		    	and datapres.noind = pri.noind ) as PSP,
		    	/*Ijin Perusahaan - Status Pekerja Aktif*/
		    	(
		    	select
		    	coalesce(count(datapres.tanggal)) as total_frekuensi
		    	from
		    	\"Presensi\".tdatapresensi as datapres
		    	where
		    	datapres.tanggal between param.tgl1 and param.tgl2
		    	and datapres.kd_ket = 'PIP'
		    	and datapres.noind = pri.noind ) as IP,
		    	/*Cuti Tahunan - Status Pekerja Aktif*/
		    	(
		    	select
		    	coalesce(count(datapres.tanggal)) as total_frekuensi
		    	from
		    	\"Presensi\".tdatapresensi as datapres
		    	where
		    	datapres.tanggal between param.tgl1 and param.tgl2
		    	and datapres.kd_ket = 'CT'
		    	and datapres.noind = pri.noind ) as CT,
		    	/*Surat Peringatan - Status Pekerja Aktif*/
		    	(
		    	select
		    	count(*)
		    	from
		    	\"Surat\".v_surat_tsp_rekap as tabelsp
		    	where
		    	tabelsp.noind = pri.noind
		    	and (tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2) ) as SP,
		    	/*Hari Kerja - Aktif*/
		    	(
		    	select
		    	count(*)
		    	from
		    	\"Presensi\".tshiftpekerja as sftpkj
		    	where
		    	sftpkj.tanggal between param.tgl1 and param.tgl2
		    	and sftpkj.noind = pri.noind ) as totalhk,
		    	/*Masa Kerja Total*/
		    	(
		    	select
		    	concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
		    	from
		    	(
		    	select
		    	( masa_kerja.total_tahun + (
		    	case
		    	when masa_kerja.total_bulan>11 then floor(masa_kerja.total_bulan / 12)
		    	else 0
		    		end ) + (
		    	case
		    	when masa_kerja.total_hari>364 then floor(masa_kerja.total_hari / 365)
		    	else 0
		    		end ) ) as tahun,
		    	( (
		    	case
		    	when masa_kerja.total_bulan>11 then masa_kerja.total_bulan-(floor(masa_kerja.total_bulan / 12)* 12)
		    	else masa_kerja.total_bulan
		    		end ) + (
		    	case
		    	when masa_kerja.total_hari>29 then floor(masa_kerja.total_hari / 30)
		    	else 0
		    		end ) ) as bulan,
		    	( (
		    	case
		    	when masa_kerja.total_hari>29 then masa_kerja.total_hari-(floor(masa_kerja.total_hari / 30)* 30)
		    	else masa_kerja.total_hari
		    		end ) ) as hari
		    	from
		    	(
		    	select
		    	sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
		    	sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
		    	sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
		    	from
		    	(
		    	select
		    	pri3.*,
		    	(
		    	case
		    	when pri3.keluar = false then (
		    	case
		    	when pri3.kode_status_kerja in ('A',
		    	'B') then ( age(current_date, pri3.diangkat) )
		    	else ( age(current_date, pri3.masukkerja) )
		    		end )
		    	else (
		    		case
		    	when pri3.kode_status_kerja in ('A',
		    	'B') then ( age(pri3.tglkeluar, pri3.diangkat) )
		    	else ( age(pri3.tglkeluar, pri3.masukkerja) )
		    		end )
		    	end ) as masa_kerja
		    	from
		    	(
		    	select
		    	pri2.noind,
		    	pri2.nik,
		    	pri2.tgllahir,
		    	pri2.kode_status_kerja,
		    	pri2.keluar,
		    	pri2.masukkerja,
		    	pri2.diangkat,
		    	pri2.tglkeluar,
		    	pri2.akhkontrak
		    	from
		    	hrd_khs.v_hrd_khs_tpribadi as pri2
		    	where
		    	pri2.nik = pri.nik
		    	and pri2.tgllahir = pri.tgllahir ) as pri3 ) master_masa_kerja ) as masa_kerja ) as masa_kerja ) as masa_kerja
		    	from
		    	hrd_khs.v_hrd_khs_tpribadi as pri
		    	left join hrd_khs.v_hrd_khs_tseksi as tseksi on
		    	tseksi.kodesie = pri.kodesie
		    	left join hrd_khs.tnoind as tnoind on
		    	tnoind.fs_noind = pri.kode_status_kerja
		    	left join hrd_khs.torganisasi as torganisasi on
		    	torganisasi.kd_jabatan = pri.kd_jabatan
		    	left join (
		    	select
		    	a.masukkerja::date as tgl1, 
		    	(a.masukkerja + interval '6 month')::date as tgl2,
		    	a.noind
		    	from
		    	hrd_khs.tpribadi a
		    	where
		    	a.keluar = '0') as param on
		    	param.noind = pri.noind
		    	where
		    	pri.noind in ('$noind')
		    	order by
		    	pri.nama,
		    	pri.noind) et";
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }
}