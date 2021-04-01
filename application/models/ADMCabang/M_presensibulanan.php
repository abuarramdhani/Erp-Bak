<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
class M_presensibulanan extends Ci_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	public function getSeksiByKodesie($kd)
	{
		$sql = "select kodesie,seksi from hrd_khs.tseksi where kodesie = '$kd'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getPresensiByNoind($noind, $tgl)
	{
		$sql = "select 	case when kd_ket in ('PKJ','PLB') then
							case when 	(
											select count(*)
											from \"Presensi\".tdatapresensi
											where noind = '$noind'
											and tanggal = '$tgl'
											and kd_ket not in ('PKJ','PLB')
										) > 0 then
								(	select kd_ket
									from \"Presensi\".tdatapresensi
									where noind = '$noind'
									and tanggal = '$tgl'
									and kd_ket not in ('PKJ','PLB') limit 1
								)
							else
							'/'
							end
						else
							kd_ket
						end
				from \"Presensi\".tdatapresensi tp
				inner join \"Presensi\".tshiftpekerja ts
				on ts.noind = tp.noind and ts.tanggal = tp.tanggal
				where tp.noind = '$noind'
				and tp.tanggal = '$tgl'
				union
				select (case when tt.kd_ket = 'TIK' and tt.point = '0' then '/' when tt.kd_ket = 'TM' and tt.point = '0' then 'TMT' else tt.kd_ket end) as kd_ket
				from \"Presensi\".tdatatim tt
				inner join \"Presensi\".tshiftpekerja ts
				on ts.noind = tt.noind and ts.tanggal = tt.tanggal
				where tt.noind = '$noind'
				and tt.tanggal = '$tgl'";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	public function getTanggal($tgl)
	{
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$sql = "
			SELECT 
				cast(dates as date) tanggal, 
				to_char(dates,'dd') tgl, 
				to_char(dates,'monthyyyy') bulan
			FROM
				generate_series('$tgl1', '$tgl2', interval '1 days') as dates";
		$result = $this->personalia->query($sql);
		return $result->result_array();
	}
	public function getAksesByUser()
	{
		$user = $this->session->user;
		$sql = "SELECT LEFT(h.kodesie,7) AS kodesie FROM \"Presensi\".t_hak_akses_presensi h WHERE h.noind = '$user'";
		$result = $this->personalia->query($sql)->result_array();

		$akses = [];

		foreach ($result as $key) {
			array_push($akses, $key['kodesie']);
		}
		$akses = implode("','", $akses);

		$ak = "'" . "$akses" . "'";

		return $ak;
	}
	public function getNoindAkses()
	{

		$sql = "SELECT DISTINCT h.noind FROM \"Presensi\".t_hak_akses_presensi h";
		$result = $this->personalia->query($sql)->result_array();

		$noind = [];

		foreach ($result as $key) {
			array_push($noind, $key['noind']);
		}
		return $noind;
	}
	public function rekapTIMS($tgl, $kd)
	{
		$noind_akses = $this->getNoindAkses();
		$akses = 		$akses = $this->getAksesByUser();
		$tanggal = explode(" - ", $tgl);
		$tgl1 = $tanggal[0];
		$tgl2 = $tanggal[1];
		$noind = $this->session->user;

		$param = "";
		// left(pri.kodesie,7) = left('$kodesie',7)
		if (in_array($noind, $noind_akses)) {
			$param = "left(pri.kodesie,7) in (left('$kd',7),$akses)";
		} elseif ($noind == 'B0380') { // ada di ticket
			$param = "(left(pri.kodesie,7) = left('$kd',7) or pri.noind in ('J1171','G1041','L8001'))";
		} elseif ($noind == 'B0370') { //ada di ticket
			$param = "(left(pri.kodesie,7) = left('$kd',7) or pri.noind in ('D1535','P0426'))";
		} elseif ($noind == 'H7726') { //Order #972784 (PENAMBAHAN AKSES BUKA PRESENSI DI PROGRAM ERP)
			$param = "left(pri.kodesie,5) = left('$kd',5)";
		} elseif ($noind == 'B0901') { // Order #524240 (Pembukaan hak akses)
			$param = "left(pri.kodesie,4) = '3070' ";
		} elseif ($noind == 'J1378') { //Order #112817 (Pembuatan Login ERP)
			$param = "left(pri.kodesie,5) in ('10101','10102')";
		} elseif ($noind == 'J1338') { //Order #456799 (Pembuatan Login ERP)
			$param = "left(pri.kodesie,3) in ('302','324','325')";
		} elseif ($noind == 'B0865') { //Order #112817 (Pembuatan Login ERP)
			$param = "left(pri.kodesie,7) in ('3301007','3301008')";
		} else if ($noind == 'B0267') { // Nugroho Budi Utomo | #854719 akses seksi toolware house-tks(3240101) dan seksi assembling gear transmission-tks(3250201)
			$param = "left(pri.kodesie, 7) in (left('$kd', 7), '3240101', '3250201') or pri.kodesie like trim(TRAILING '0' FROM '$kd') || '%'";
		} else if ($noind == 'B0344') { // Enaryono
			$param = "left(pri.kodesie, 4) in ('3060')"; // #741867 akses semua seksi di bidang ENGINEERING
		} else {
			if ('306030' == substr($kd, 0, 6)) //ada diticket
			{
				$param = "left(pri.kodesie,6) = left('$kd',6)";
			} else {
				$param = "left(pri.kodesie,7) = left('$kd',7)";
			}
		}

		$rekapTIMS		= "	select 		pri.noind,
											pri.noind_baru,
											pri.nik,
											pri.tgllahir,
											pri.nama,
											pri.kode_status_kerja,
											tnoind.fs_ket,
											pri.kd_jabatan,
											rtrim(torganisasi.jabatan) as jabatan,
											pri.kodesie,
											tseksi.dept,
											tseksi.bidang,
											tseksi.unit,
											tseksi.seksi,
											param.tgl1 as tanggal_awal_rekap,
											param.tgl2 as tanggal_akhir_rekap,
											/*Terlambat - Status Pekerja Aktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TT'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as frekt,
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TT'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as bobott,
											/*Terlambat - Status Pekerja Nonaktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TT'
															and 	tim.point>0
															and 	trim(tim.noind)
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as frekts,
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TT'
															and 	tim.point>0
															and 	trim(tim.noind)
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as bobotts,
											/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TIK'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as freki,
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TIK'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as boboti,
											/*Ijin Keluar Pribadi - Status Pekerja Nonaktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TIK'
															and 	tim.point>0
															and 	trim(tim.noind)
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as frekis,
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TIK'
															and 	tim.point>0
															and 	trim(tim.noind)
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as bobotis,
											/*Mangkir - Status Pekerja Aktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as frekm,
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as bobotm,
											/*Mangkir - Status Pekerja Nonaktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point>0
															and 	trim(tim.noind)
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as frekms,
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point>0
															and 	trim(tim.noind)
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as bobotms,
											/*Mangkir Tidak Berpoint - Status Pekerja Aktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point=0
															and 	trim(tim.noind)=pri.noind
											) as frekmnon,
											/*Mangkir Tidak Berpoint - Status Pekerja Nonaktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point=0
															and 	trim(tim.noind)
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as frekmsnon,
											/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PSK'
															and 	datapres.noind=pri.noind
											) as freksk,
											/*Sakit Keterangan Dokter - Status Pekerja Nonaktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PSK'
															and 	datapres.noind
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as freksks,
											/*Sakit Perusahaan - Status Pekerja Aktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PSP'
															and 	datapres.noind=pri.noind
											) as frekpsp,
											/*Sakit Perusahaan - Status Pekerja Nonaktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PSP'
															and 	datapres.noind
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as frekpsps,
											/*Ijin Perusahaan - Status Pekerja Aktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PIP'
															and 	datapres.noind=pri.noind
											) as frekip,
											/*Ijin Perusahaan - Status Pekerja Nonaktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PIP'
															and 	datapres.noind
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as frekips,
											/*Cuti Tahunan - Status Pekerja Aktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='CT'
															and 	datapres.noind=pri.noind
											) as frekct,
											/*Cuti Tahunan - Status Pekerja Nonaktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='CT'
															and 	datapres.noind
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.keluar=true
																					and 	pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																	)
											) as frekcts,
											/*Surat Peringatan - Status Pekerja Aktif*/
											(
												select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
												/*select 		tabelsp.**/
												from		(
																select		tabelmaster.*,
																			(
																				case 	when 	(
																									select 		count(*)
																									from 		\"Surat\".v_surat_tsp_rekap as sp
																									where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																												and 	sp.tanggal_awal_berlaku < param.tgl2
																								)>0
																								then 	(
																											case	when 	(
																																select 		count(*)
																																from 		\"Surat\".v_surat_tsp_rekap as sp2
																																where 		sp2.tanggal_awal_berlaku >= tabelmaster.tanggal_awal_berlaku
																																			and 	sp2.tanggal_awal_berlaku < param.tgl2
																																			and 	sp2.sp_ke > tabelmaster.sp_ke
																															)>0
																															then 	'NEXT'
																													else 	'STOP'
																											end
																										)
																						else 	'STOP'
																				end
																			) as lanjutan
																from 		\"Surat\".v_surat_tsp_rekap as tabelmaster
															) as tabelsp
												where 		tabelsp.noind=pri.noind
															and 	tabelsp.tanggal_awal_berlaku between param.tgl1 and param.tgl2
															and 	tabelsp.lanjutan='STOP'
											) as freksp,
											/*Surat Peringatan - Status Pekerja Nonaktif*/
											(
												select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
												/*select 		tabelsp.**/
												from		(
																select		tabelmaster.*,
																			(
																				case 	when 	(
																									select 		count(*)
																									from 		\"Surat\".v_surat_tsp_rekap as sp
																									where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																												and 	sp.tanggal_awal_berlaku < param.tgl2
																								)>0
																								then 	(
																											case	when 	(
																																select 		count(*)
																																from 		\"Surat\".v_surat_tsp_rekap as sp2
																																where 		sp2.tanggal_awal_berlaku >= tabelmaster.tanggal_awal_berlaku
																																			and 	sp2.tanggal_awal_berlaku < param.tgl2
																																			and 	sp2.sp_ke > tabelmaster.sp_ke
																															) > 0
																															then 	'NEXT'
																													else 	'STOP'
																											end
																										)
																						else 	'STOP'
																				end
																			) as lanjutan
																from 		\"Surat\".v_surat_tsp_rekap as tabelmaster
															) as tabelsp
												where 		tabelsp.tanggal_awal_berlaku between param.tgl1 and param.tgl2
															and 	tabelsp.lanjutan='STOP'
															and 	tabelsp.noind
																	in
																	(
																		select 		noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.noind!=pri.noind
																					and 	pri2.keluar=true
																	)
											) as freksps,
											/*Hari Kerja - Aktif*/
											(
												select 		count(*)
												from 		\"Presensi\".tshiftpekerja as sftpkj
												where 		sftpkj.tanggal between param.tgl1 and param.tgl2
															and 	sftpkj.noind=pri.noind
											) as totalhk,
											/*Hari Kerja - Nonaktif*/
											(
												select 		count(*)
												from 		\"Presensi\".tshiftpekerja as sftpkj
												where 		sftpkj.tanggal between param.tgl1 and param.tgl2
															and 	sftpkj.noind
																	in
																	(
																		select 		pri2.noind
																		from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																		where 		pri2.nik=pri.nik
																					and 	pri2.tgllahir=pri.tgllahir
																					and 	pri2.keluar=true
																					and 	pri2.noind!=pri.noind
																	)
											) as totalhks,
											/*Masa Kerja Total*/
											(
												select 	concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
												from 	(
															select 		(
																			masa_kerja.total_tahun
																			+
																			(
																				case 	when 	masa_kerja.total_bulan>11
																								then 	floor(masa_kerja.total_bulan/12)
																						else 	0
																				end
																			)
																			+
																			(
																				case 	when 	masa_kerja.total_hari>364
																								then 	floor(masa_kerja.total_hari/365)
																						else 	0
																				end
																			)
																		) as tahun,
																		(
																			(
																				case 	when 	masa_kerja.total_bulan>11
																								then 	masa_kerja.total_bulan-(floor(masa_kerja.total_bulan/12)*12)
																						else 	masa_kerja.total_bulan
																				end
																			)
																			+
																			(
																				case 	when 	masa_kerja.total_hari>29
																								then 	floor(masa_kerja.total_hari/30)
																						else 	0
																				end
																			)
																		) as bulan,
																		(
																			(
																				case 	when 	masa_kerja.total_hari>29
																								then 	masa_kerja.total_hari-(floor(masa_kerja.total_hari/30)*30)
																						else 	masa_kerja.total_hari
																				end
																			)
																		) as hari
															from 		(
																			select 		sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
																						sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
																						sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
																			from 		(
																							select 		pri3.*,
																										(
																											case 	when 	pri3.keluar=false
																															then 	(
																																		case 	when 	pri3.kode_status_kerja in ('A', 'B')
																																						then 	(
																																									age(current_date, pri3.diangkat)
																																								)
																																				else  	(
																																							age(current_date, pri3.masukkerja)
																																						)
																																		end
																																	)
																													else 	(
																																case 	when 	pri3.kode_status_kerja in ('A', 'B')
																																				then 	(
																																							age(pri3.tglkeluar, pri3.diangkat)
																																						)
																																		else  	(
																																					age(pri3.tglkeluar, pri3.masukkerja)
																																				)
																																end
																															)
																											end
																										) as masa_kerja
																							from 		(
																											select 		pri2.noind,
																														pri2.nik,
																														pri2.tgllahir,
																														pri2.kode_status_kerja,
																														pri2.keluar,
																														pri2.masukkerja,
																														pri2.diangkat,
																														pri2.tglkeluar,
																														pri2.akhkontrak
																											from 		hrd_khs.v_hrd_khs_tpribadi as pri2
																											where 		pri2.nik=pri.nik
																														and 	pri2.tgllahir=pri.tgllahir
																										) as pri3
																						) master_masa_kerja
																		) as masa_kerja
														) as masa_kerja
											) as masa_kerja
								from 		hrd_khs.v_hrd_khs_tpribadi as pri
								 			left join 	hrd_khs.v_hrd_khs_tseksi as tseksi
								 			 			on 	tseksi.kodesie=pri.kodesie
								 			left join 	hrd_khs.tnoind as tnoind
								 						on 	tnoind.fs_noind=pri.kode_status_kerja
								 			left join 	hrd_khs.torganisasi as torganisasi
								 						on 	torganisasi.kd_jabatan=pri.kd_jabatan
								 			left join 	(
								 							select 	'$tgl1'::date as tgl1,
								 									'$tgl2'::date as tgl2
								 						) as param
								 						on 	param.tgl1=param.tgl1
								where 		$param
								order by 	tseksi.kodesie,
											pri.kd_jabatan,
											pri.noind";
		// echo $rekapTIMS.'<br/>'; exit();
		// echo $parameter;exit();
		$queryRekapTIMS =	$this->personalia->query($rekapTIMS);
		return $queryRekapTIMS->result_array();
	}
}
