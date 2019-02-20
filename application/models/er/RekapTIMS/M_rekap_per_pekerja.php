<?php
clASs M_rekap_per_pekerja extends CI_Model {

	var $personalia;
    public function __construct()
    {
        parent::__construct();
		$this->personalia = $this->load->database ( 'personalia', TRUE );
    }
	
	public function data_per_pekerja($periode1,$periode2,$noinduk,$status){

		if ($status == '0') {
			$sql = "
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs,

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind = a.noind
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point <> '0' 
								AND 	tanggal BETWEEN '$periode1' AND '$periode2'
					) AS FrekM,

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind IN 	(
												SELECT 	noind 
												FROM 	hrd_khs.tpribadi 
												WHERE 	noind IN 	(
																		SELECT 	noind 
																		FROM 	hrd_khs.tpribadi 
																		WHERE 	keluar = '1' 
																				AND tanggal BETWEEN '$periode1' AND '$periode2'
																	)
														AND 	nama = a.nama 
														AND 	tgllahir = a.tgllahir 
														AND 	nik = a.nik
											)
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point<>'0'
					) AS FrekMs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekPSP,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekPSPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCT,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'CT') AS FrekCTs,

					/*(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
					) AS FrekSP,*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSP,

					/*(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
					WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2'))
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					) AS FrekSPs,*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind
									in 		(
												select 		noind
												from 		hrd_khs.v_hrd_khs_tpribadi as pri
												where 		pri.nik
															=
															(
																select 		nik
																from 		hrd_khs.v_hrd_khs_tpribadi
																where 		noind=a.noind
															)
															and 	pri.tgllahir
																	=
																	(
																		select 		tgllahir
																		from 		hrd_khs.v_hrd_khs_tpribadi
																		where 		noind=a.noind
																	)
															and 	pri.keluar=true
											)
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSPs,

					(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind = a.noind AND tanggal BETWEEN '$periode1' AND '$periode2') AS TotalHK,
					(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind IN
								(SELECT noind FROM hrd_khs.tpribadi 
									WHERE 
										keluar = '1' 
										AND nama = a.nama 
										AND tgllahir = a.tgllahir 
										AND nik = a.nik
								)  AND tanggal BETWEEN '$periode1' AND '$periode2'
							) AS TotalHKs

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '0'
					AND a.noind IN
						(
							$noinduk
						)

				ORDER BY noind
				";
		} else {
			$sql = "
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

					'0' AS FrekTs,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

					'0' AS FrekIs,

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind = a.noind
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point <> '0' 
								AND 	tanggal BETWEEN '$periode1' AND '$periode2'
					) AS FrekM,

					'0' AS FrekMs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

					'0' AS FrekSKs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekPSP,

					'0' AS FrekPSPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

					'0' AS FrekIPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCT,

					'0' AS FrekCTs,

					/*(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
					) AS FrekSP,*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) AS FrekSP,

					'0' AS FrekSPs,

					(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind = a.noind AND tanggal BETWEEN '$periode1' AND '$periode2')
					 AS TotalHK,

					'0' AS TotalHKs

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '1'
					AND a.noind IN
						(
							$noinduk
						)

				ORDER BY noind
				";
		}

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function data_per_pekerja_detail($firstdate,$lastdate,$noinduk,$monthName,$status){
		if ($status == '0') {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$monthName.",

					(	
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind = a.noind
								AND 	(
											point = '1'
										) 
								-- AND 	kd_ket = 'TM' 
								-- AND 	point <> '0' 
								AND 	tanggal BETWEEN '$firstdate' AND '$lastdate'
					) AS FrekM".$monthName.",

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind IN 	(
												SELECT 	noind 
												FROM 	hrd_khs.tpribadi 
												WHERE 	noind IN 	(
																		SELECT 	noind 
																		FROM 	hrd_khs.tpribadi 
																		WHERE 	keluar = '1' 
																		AND  	tanggal BETWEEN '$firstdate' AND '$lastdate'
																	)
												AND 	nama = a.nama 
												AND 	tgllahir = a.tgllahir 
												AND 	nik = a.nik
											)
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point<>'0'
					) AS FrekMs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekPSP".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekPSPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'CT') AS FrekCTs".$monthName.",

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$lastdate'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$lastdate'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$firstdate' and '$lastdate'
									and 	tabelsp.lanjutan='STOP'
					) AS FrekSP".$monthName.",

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$lastdate'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$lastdate'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind
									in 		(
												select 		noind
												from 		hrd_khs.v_hrd_khs_tpribadi as pri
												where 		pri.nik
															=
															(
																select 		nik
																from 		hrd_khs.v_hrd_khs_tpribadi
																where 		noind=a.noind
															)
															and 	pri.tgllahir
																	=
																	(
																		select 		tgllahir
																		from 		hrd_khs.v_hrd_khs_tpribadi
																		where 		noind=a.noind
																	)
															and 	pri.keluar=true
											)
									and 	tabelsp.tanggal_awal_berlaku between '$firstdate' and '$lastdate'
									and 	tabelsp.lanjutan='STOP'
					) AS FrekSPs".$monthName."

					FROM hrd_khs.tpribadi a

					inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
					inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

					WHERE keluar = '0'
						AND a.noind IN
						(
							$noinduk
						)

					ORDER BY noind
				";
		} else {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

					'0' AS FrekTs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

					'0' AS FrekIs".$monthName.",

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind = a.noind
								AND 	(
											point = '1'
										) 
								-- AND 	kd_ket = 'TM' 
								-- AND 	point <> '0' 
								AND 	tanggal BETWEEN '$firstdate' AND '$lastdate'
					) AS FrekM".$monthName.",

					'0' AS FrekMs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

					'0' AS FrekSKs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekPSP".$monthName.",

					'0' AS FrekPSPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$monthName.",

					'0' AS FrekIPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$monthName.",

					'0' AS FrekCTs".$monthName.",

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$lastdate'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$lastdate'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$firstdate' and '$lastdate'
									and 	tabelsp.lanjutan='STOP'
					) AS FrekSP".$monthName.",

					'0' AS FrekSPs".$monthName."

					FROM hrd_khs.tpribadi a

					inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
					inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

					WHERE keluar = '1'
						AND a.noind IN
						(
							$noinduk
						)

					ORDER BY noind
				";
			}
			$query = $this->personalia->query($sql);
			return $query->result_array();
	}

	public function ExportRekap($periode1,$periode2,$NoInduk,$status)
	{
		if ($status == '0') {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs,

					(	
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind = a.noind
								AND 	(
											point = '1'
										) 
								-- AND 	kd_ket = 'TM' 
								-- AND 	point <> '0' 
								AND 	tanggal BETWEEN '$periode1' AND '$periode2'
					) AS FrekM,

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind IN 	(
												SELECT 	noind 
												FROM 	hrd_khs.tpribadi 
												WHERE 	noind IN 	(
																		SELECT 	noind 
																		FROM 	hrd_khs.tpribadi 
																		WHERE 	keluar = '1' 
																		AND 	tanggal BETWEEN '$periode1' AND '$periode2'
																	)
														AND 	nama = a.nama 
														AND 	tgllahir = a.tgllahir 
														AND 	nik = a.nik
											)
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point<>'0'
					) AS FrekMs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekPSP,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekPSPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCT,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'CT') AS FrekCTs,

					/*(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
					) AS FrekSP,*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSP,

					/*(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
					WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2'))
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					) AS FrekSPs,*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind
									in 		(
												select 		noind
												from 		hrd_khs.v_hrd_khs_tpribadi as pri
												where 		pri.nik
															=
															(
																select 		nik
																from 		hrd_khs.v_hrd_khs_tpribadi
																where 		noind=a.noind
															)
															and 	pri.tgllahir
																	=
																	(
																		select 		tgllahir
																		from 		hrd_khs.v_hrd_khs_tpribadi
																		where 		noind=a.noind
																	)
															and 	pri.keluar=true
											)
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSPs,

					(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind = a.noind AND tanggal BETWEEN '$periode1' AND '$periode2')
					AS TotalHK, 
							(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind IN
								(SELECT noind FROM hrd_khs.tpribadi 
									WHERE 
										keluar = '1' 
										AND nama = a.nama 
										AND tgllahir = a.tgllahir 
										AND nik = a.nik
								)  AND tanggal BETWEEN '$periode1' AND '$periode2') 
								 AS TotalHKs

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '0'
						AND a.noind IN
						(
							$NoInduk
						)

				ORDER BY noind
			";
		} else {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

					'0' AS FrekTs,

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

					'0' AS FrekIs,

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind = a.noind 
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point <> '0' 
								AND 	tanggal BETWEEN '$periode1' AND '$periode2'
					) AS FrekM,

					'0' AS FrekMs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

					'0' AS FrekSKs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekPSP,

					'0' AS FrekPSPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

					'0' AS FrekIPs,

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCT,

					'0' AS FrekCTs,

					/*(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
					) AS FrekSP,*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSP,

					'0' AS FrekSPs,
					(SELECT count(*) FROM \"Presensi\".tshiftpekerja WHERE noind = a.noind AND tanggal BETWEEN '$periode1' AND '$periode2') AS TotalHK,

					'0' AS TotalHKs

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '1'
						AND a.noind IN
						(
							$NoInduk
						)

				ORDER BY noind
			";
		}
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function ExportDetail($firstdate,$lastdate,$NoInduk,$monthName, $status)
	{
		if ($status == '0') {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$monthName.",

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind = a.noind 
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point <> '0' 
								AND 	tanggal BETWEEN '$firstdate' AND '$lastdate'
					) AS FrekM".$monthName.",

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind IN 	(
												SELECT 	noind 
												FROM 	hrd_khs.tpribadi 
												WHERE 	noind IN 	(
																		SELECT 	noind 
																		FROM 	hrd_khs.tpribadi 
																		WHERE 	keluar = '1' 
																				AND 	tanggal BETWEEN '$firstdate' AND '$lastdate'
																	)
														AND 	nama = a.nama 
														AND 	tgllahir = a.tgllahir 
														AND 	nik = a.nik
											)
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point<>'0'
					) AS FrekMs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSK') AS FrekSKs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekPSP".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PSP') AS FrekPSPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'PIP') AS FrekIPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					AND kd_ket = 'CT') AS FrekCTs".$monthName.",

					/*(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate')
					) AS FrekSP".$monthName.",*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$lastdate'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$lastdate'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$firstdate' and '$lastdate'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSP".$monthName.",

					/*(SELECT count(*) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
							) AS SP
					WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
							(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak + interval '5 month') >= '$firstdate' OR(tgl_cetak + interval '5 month') >= '$lastdate'))
						AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
					) AS FrekSPs".$monthName."*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$lastdate'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$lastdate'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind
									in 		(
												select 		noind
												from 		hrd_khs.v_hrd_khs_tpribadi as pri
												where 		pri.nik
															=
															(
																select 		nik
																from 		hrd_khs.v_hrd_khs_tpribadi
																where 		noind=a.noind
															)
															and 	pri.tgllahir
																	=
																	(
																		select 		tgllahir
																		from 		hrd_khs.v_hrd_khs_tpribadi
																		where 		noind=a.noind
																	)
															and 	pri.keluar=true
											)
									and 	tabelsp.tanggal_awal_berlaku between '$firstdate' and '$lastdate'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSPs".$monthName."

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '0'
						AND a.noind IN
						(
							$NoInduk
						)

				ORDER BY noind
			";
		} else {
			$sql="
				SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$monthName.",

					'0' AS FrekTs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$monthName.",

					'0' AS FrekIs".$monthName.",

					(
						SELECT 	count(*) 
						FROM 	\"Presensi\".tdatatim 
						WHERE 	noind = a.noind 
								AND 	(
											point = '1'
										)
								-- AND 	kd_ket = 'TM' 
								-- AND 	point <> '0' 
								AND 	tanggal BETWEEN '$firstdate' AND '$lastdate'
					) AS FrekM".$monthName.",

					'0' AS FrekMs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$monthName.",

					'0' AS FrekSKs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekPSP".$monthName.",

					'0' AS FrekPSPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$monthName.",

					'0' AS FrekIPs".$monthName.",

					(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$monthName.",

					'0' AS FrekCTs".$monthName.",

					/*(SELECT max(sp_ke) FROM
						(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
						UNION ALL
						SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
						) AS SP
						WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak) >= '$firstdate' OR (tgl_cetak) >= '$lastdate')
					) AS FrekSP".$monthName.",*/

					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$lastdate'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$lastdate'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$firstdate' and '$lastdate'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSP".$monthName.",

					'0' AS FrekSPs".$monthName."

				FROM hrd_khs.tpribadi a

				inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
				inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

				WHERE keluar = '1'
						AND a.noind IN
						(
							$NoInduk
						)

				ORDER BY noind
			";
		}
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function dataRekapMonth($periode1,$periode2,$NoInduk)
	{
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekT,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0') AS FrekTs,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekI,

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0') AS FrekIs,

				(
					SELECT 	count(*) 
					FROM 	\"Presensi\".tdatatim 
					WHERE 	noind = a.noind 
							AND 	(
										point = '1'
									)
							-- AND 	kd_ket = 'TM' 
							-- AND 	point <> '0' 
							AND 	tanggal BETWEEN '$periode1' AND '$periode2'
				) AS FrekM,

				(
					SELECT 	count(*) 
					FROM 	\"Presensi\".tdatatim 
					WHERE 	noind IN 	(
											SELECT 	noind 
											FROM 	hrd_khs.tpribadi 
											WHERE 	noind IN 	(
																	SELECT 	noind 
																	FROM 	hrd_khs.tpribadi 
																	WHERE 	keluar = '1' 
																			AND 	tanggal BETWEEN '$periode1' AND '$periode2'
																)
													AND 	nama = a.nama 
													AND 	tgllahir = a.tgllahir 
													AND 	nik = a.nik
										)
							AND 	(
										point = '1'
									)
							-- AND 	kd_ket = 'TM' 
							-- AND 	point<>'0'
				) AS FrekMs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekSK,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK') AS FrekSKs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekIP,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP') AS FrekIPs,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$periode1' AND '$periode2') AS FrekCT,

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$periode1' AND '$periode2')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT') AS FrekCTs,

				/*(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2')
				) AS FrekSP,

				(SELECT count(*) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$periode1' OR tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR(tgl_cetak + interval '5 month') >= '$periode2'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs*/

				(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSP,
					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind
									in 		(
												select 		noind
												from 		hrd_khs.v_hrd_khs_tpribadi as pri
												where 		pri.nik
															=
															(
																select 		nik
																from 		hrd_khs.v_hrd_khs_tpribadi
																where 		noind=a.noind
															)
															and 	pri.tgllahir
																	=
																	(
																		select 		tgllahir
																		from 		hrd_khs.v_hrd_khs_tpribadi
																		where 		noind=a.noind
																	)
															and 	pri.keluar=true
											)
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSPs

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
					AND a.noind IN
					(
						$NoInduk
					)

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function dataRekapMonthDetail($firstdate,$lastdate,$NoInduk,$date)
	{
		$sql="
			SELECT a.noind,a.nama,a.tgllahir,a.nik,b.dept,b.bidang,b.unit,b.seksi,a.masukkerja,a.kode_status_kerja,c.fs_ket,
				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TT' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekT".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TT' AND point<>'0') AS FrekTs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind = a.noind AND kd_ket = 'TIK' AND point <> '0' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekI".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatatim WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'TIK' AND point<>'0') AS FrekIs".$date.",

				(
					SELECT 	count(*) 
					FROM 	\"Presensi\".tdatatim 
					WHERE 	noind = a.noind 
							AND 	(
										point = '1'
									)
							-- AND 	kd_ket = 'TM' 
							-- AND 	point <> '0' 
							AND 	tanggal BETWEEN '$firstdate' AND '$lastdate'
				) AS FrekM".$date.",

				(
					SELECT 	count(*) 
					FROM 	\"Presensi\".tdatatim 
					WHERE 	noind IN 	(
											SELECT 	noind 
											FROM 	hrd_khs.tpribadi 
											WHERE 	noind IN 	(
																	SELECT 	noind 
																	FROM 	hrd_khs.tpribadi 
																	WHERE 	keluar = '1' 
																			AND tanggal BETWEEN '$firstdate' AND '$lastdate'
																)
													AND  	nama = a.nama 
													AND 	tgllahir = a.tgllahir 
													AND 	nik = a.nik
										)
							AND 	(
										point = '1'
									)
							-- AND 	kd_ket = 'TM' 
							-- AND 	point<>'0'
				) AS FrekMs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PSK' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekSK".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PSK') AS FrekSKs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'PIP' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekIP".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'PIP') AS FrekIPs".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind = a.noind AND kd_ket = 'CT' AND tanggal BETWEEN '$firstdate' AND '$lastdate') AS FrekCT".$date.",

				(SELECT count(*) FROM \"Presensi\".tdatapresensi WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND tanggal BETWEEN '$firstdate' AND '$lastdate')
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				AND kd_ket = 'CT') AS FrekCTs".$date.",

				/*(SELECT max(sp_ke) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SP
					WHERE noind = a.noind AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak) >= '$firstdate' OR (tgl_cetak) >= '$lastdate')
				) AS FrekSP".$date.",

				(SELECT max(sp_ke) FROM
					(SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, nT, nIK, nM, bobot, 'Absensi' as Status FROM \"Surat\".tsp 
					UNION ALL
					SELECT noind, no_surat, bulan, tgl_cetak,(tgl_cetak + interval '5 month') as tgl_kadaluarsa, berlaku, sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen
					) AS SPs
				WHERE noind IN
					(SELECT noind FROM hrd_khs.tpribadi WHERE noind IN
						(SELECT noind FROM hrd_khs.tpribadi WHERE keluar = '1' AND (tgl_cetak <= '$firstdate' OR tgl_cetak <= '$lastdate') AND ((tgl_cetak) >= '$firstdate' OR (tgl_cetak) >= '$lastdate'))
					AND nama = a.nama AND tgllahir = a.tgllahir AND nik = a.nik)
				) AS FrekSPs".$date."*/

								(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind=a.noind
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSP".$date.",
					(
						select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
						--select 		tabelsp.*
						from		(
										select		tabelmaster.*,
													(
														case 	when 	(
																			select 		count(*)
																			from 		\"Surat\".v_surat_tsp_rekap as sp
																			where 		rtrim(sp.sp_sebelum)=tabelmaster.no_surat_lengkap
																						and 	sp.tanggal_awal_berlaku<'$periode2'
																		)>0	
																		then 	(
																					case	when 	(
																										select 		count(*)
																										from 		\"Surat\".v_surat_tsp_rekap as sp2
																										where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																													and 	sp2.tanggal_awal_berlaku<'$periode2'
																													and 	sp2.sp_ke>tabelmaster.sp_ke
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
						where 		tabelsp.noind
									in 		(
												select 		noind
												from 		hrd_khs.v_hrd_khs_tpribadi as pri
												where 		pri.nik
															=
															(
																select 		nik
																from 		hrd_khs.v_hrd_khs_tpribadi
																where 		noind=a.noind
															)
															and 	pri.tgllahir
																	=
																	(
																		select 		tgllahir
																		from 		hrd_khs.v_hrd_khs_tpribadi
																		where 		noind=a.noind
																	)
															and 	pri.keluar=true
											)
									and 	tabelsp.tanggal_awal_berlaku between '$periode1' and '$periode2'
									and 	tabelsp.lanjutan='STOP'
					) as FrekSPs".$date."

			FROM hrd_khs.tpribadi a

			inner join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind

			WHERE keluar = '0'
					AND a.noind IN
					(
						$NoInduk
					)

			ORDER BY noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function GetNoInduk($term, $status){
		if ($status == '0'){			
			if ($term === FALSE) {
				$sql = "
					SELECT * FROM hrd_khs.tpribadi WHERE keluar = '0' ORDER BY noind ASC
				";
			}
			else{
				$sql = "
					SELECT * FROM hrd_khs.tpribadi WHERE keluar = '0' AND (noind ILIKE '%$term%' OR nama ILIKE '%$term%') ORDER BY noind ASC
				";
			}
		} else {
			if ($term === FALSE) {
				$sql = "
					SELECT *
					FROM hrd_khs.tpribadi 
					WHERE keluar = '1'
					AND nik NOT IN 
						(
							SELECT nik
							FROM hrd_khs.tpribadi
							WHERE keluar = '0'
							and nik not in ('', '-')
						)
					ORDER BY noind ASC
				";
			}
			else{
				$sql = "
					SELECT *
					FROM hrd_khs.tpribadi 
					WHERE keluar = '1'
					AND (noind ILIKE '%$term%' OR nama ILIKE '%$term%' )
					AND nik NOT IN 
						(
							SELECT nik
							FROM hrd_khs.tpribadi
							WHERE keluar = '0'
							and nik not in ('', '-')
						)
					ORDER BY noind ASC
				";
			}
		}
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

		public function rekapPersonInfo($nik)
	{
		$sql = "
			SELECT a.noind,a.nik,a.nama,b.seksi,b.unit,b.bidang,b.dept,a.kode_status_kerja,c.fs_ket
			FROM hrd_khs.tpribadi a
			INNER join hrd_khs.tseksi b on a.kodesie=b.kodesie
			inner join hrd_khs.tnoind c on a.kode_status_kerja = c.fs_noind
			WHERE
				 a.nik = '$nik'
			ORDER BY a.noind
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function rekapPersonTIM($periode1,$periode2,$nik,$keterangan)
	{
		$sql = "
			SELECT a.noind,a.nama, b.tanggal, b.masuk, b.keluar, b.kd_ket
				FROM \"Presensi\".TDataTIM b
				LEFT JOIN hrd_khs.TPribadi a on b.noind = a.noind
				WHERE a.nik = '$nik'
					AND b.tanggal BETWEEN '$periode1 00:00:00' AND '$periode2 23:59:59'
					AND b.kd_ket = '$keterangan'
					AND b.point <> '0'
				ORDER BY b.tanggal DESC
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function rekapPersonSIP($periode1,$periode2,$nik,$keterangan)
	{
		$sql = "
			SELECT a.noind,a.nama, b.tanggal, b.masuk, b.keluar, b.kd_ket
				FROM \"Presensi\".TDataPresensi b
				LEFT JOIN hrd_khs.TPribadi a on b.noind = a.noind
				WHERE a.nik = '$nik'
					AND b.tanggal BETWEEN '$periode1 00:00:00' AND '$periode2 00:00:00'
					AND b.kd_ket = '$keterangan'
				ORDER BY b.tanggal DESC
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function rekapPersonSakit($periode1, $periode2, $nik)
	{
		$sql 	= "	select 		pri.noind,
								pri.nama,
								datapre.tanggal,
								datapre.masuk,
								datapre.keluar,
								datapre.kd_ket,
								case datapre.kd_ket 	when 	'PSK'
																then 	'Sakit Keterangan Dokter'
														when 	'PSP'
																then 	'Sakit Perusahaan'
								end as keterangan
					from 		\"Presensi\".tdatapresensi as datapre
								left join 	hrd_khs.tpribadi as pri
										on 	pri.noind=datapre.noind
					where 		pri.nik='$nik'
								and 	datapre.tanggal between '$periode1' and '$periode2'
								and 	(
											datapre.kd_ket='PSP'
											or 	datapre.kd_ket='PSK'
										)
					order by 	datapre.tanggal desc;";
		$query 	=	$this->personalia->query($sql);
		return $query->result_array();
	}

	public function rekapPersonSP($periode1,$periode2,$nik)
	{
		$sql = "
			SELECT a.noind, a.no_surat, a.tgl_cetak, a.sp_ke, a.nT, a.nIK, a.nM, a.bobot, 'Absensi' as Status FROM \"Surat\".tsp a
			left join hrd_khs.TPribadi b on a.noind = b.noind
			where b.nik = '$nik'
			AND (a.tgl_cetak <= '$periode1' OR a.tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2')
			union all
			SELECT a.noind, a.no_surat, a.tgl_cetak, a.sp_ke, NULL as nT, NULL as nIK, NULL as nM, NULL as bobot, 'Non Absensi' as Status FROM \"Surat\".tsp_nonabsen a
			left join hrd_khs.TPribadi b on a.noind = b.noind
			where b.nik = '$nik'
			AND (a.tgl_cetak <= '$periode1' OR a.tgl_cetak <= '$periode2') AND ((tgl_cetak + interval '5 month') >= '$periode1' OR (tgl_cetak + interval '5 month') >= '$periode2')
			order by tgl_cetak DESC
		";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function data_rekap_masakerja($periode2, $noinduk, $status){
		/*if ($status == '0') {
			$sql = "
				(
				SELECT noind, nik, nama, masukkerja, '$periode2' tglkeluar, keluar
					FROM hrd_khs.tpribadi a
					WHERE
						noind IN ($noinduk)
						AND keluar = '0'
				)

				UNION ALL

				(
				SELECT noind, nik, nama, masukkerja, tglkeluar, keluar
					FROM hrd_khs.tpribadi a
					WHERE
						(
							nama IN (
								SELECT nama
									FROM hrd_khs.tpribadi a
									WHERE
										noind IN ($noinduk)
										AND keluar = '0'
							)
						AND
							nik IN (
								SELECT nik
									FROM hrd_khs.tpribadi a
									WHERE
										noind IN ($noinduk)
										AND keluar = '0'
								)
						)

						AND keluar = '1'
				)
				ORDER BY nik, nama, tglkeluar DESC
				
			";
		} else {
			$sql = 
				"SELECT noind, nik, nama, masukkerja, tglkeluar, keluar
					FROM hrd_khs.tpribadi a
					WHERE
						noind IN ($noinduk)
				ORDER BY nik, nama, masukkerja DESC, tglkeluar DESC";

		}*/
		$sql 	= "	select 		masa_kerja.nik,
								masa_kerja.tgllahir,
								(
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
														then 	masa_kerja.total_bulan-11
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
														then 	masa_kerja.total_hari-29
												else 	masa_kerja.total_hari
										end
									)
								) as hari
					from 		(
									select		master_masa_kerja.nik,
												master_masa_kerja.tgllahir,
									 			sum(extract(year from master_masa_kerja.masa_kerja)) as total_tahun,
												sum(extract(month from master_masa_kerja.masa_kerja)) as total_bulan,
												sum(extract(day from master_masa_kerja.masa_kerja)) as total_hari
									from 		(
													select 		pri.*,
																(
																	case 	when 	pri.keluar=false
																					then 	(
																								case 	when 	pri.kode_status_kerja in ('A', 'B')
																												then 	(
																															age(current_date, pri.diangkat)
																														)
																										else  	(
																													age(current_date, pri.masukkerja)
																												)
																								end
																							)
																			else 	(
																						case 	when 	pri.kode_status_kerja in ('A', 'B')
																										then 	(
																													age(pri.tglkeluar, pri.diangkat)
																												)
																								else  	(
																											age(pri.tglkeluar, pri.masukkerja)
																										)
																						end
																					)
																	end
																) as masa_kerja
													from 		(
																	select 		pri.noind,
																				pri.nik,
																				pri.tgllahir,
																				pri.kode_status_kerja,
																				pri.keluar,
																				pri.masukkerja,
																				pri.diangkat,
																				pri.tglkeluar,
																				pri.akhkontrak
																	from 		hrd_khs.v_hrd_khs_tpribadi as pri
																	where 		pri.nik
																				=
																				(
																					select 		nik
																					from 		hrd_khs.v_hrd_khs_tpribadi
																					where 		noind in($noinduk)
																				)
																				and 	pri.tgllahir
																						=
																						(
																							select 		tgllahir
																							from 		hrd_khs.v_hrd_khs_tpribadi
																							where 		noind in($noinduk)
																						)
																) as pri
												) master_masa_kerja
									group by 	master_masa_kerja.nik,
												master_masa_kerja.tgllahir
								) as masa_kerja";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

}
?>