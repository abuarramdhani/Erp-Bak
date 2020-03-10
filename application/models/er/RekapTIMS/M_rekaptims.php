<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_rekaptims extends CI_Model
 	{
 		public function __construct()
	    {
	        parent::__construct();
	        $this->personalia 	=	$this->load->database('personalia', TRUE);
	    }


	    public function rekapBobotTIM($period1,$period2,$noind,$keluar)
	    {
	    	$query = "select pri.noind,pri.nama, ts.dept,ts.bidang,ts.unit,ts.seksi,
	    					(select sum(case
	    									when tdtim.kd_ket='TT'
	    									then tdtim.point
	    									else 0
	    								end)
	    					from \"Presensi\".tdatatim as tdtim inner join hrd_khs.tpribadi tp on tp.noind=tdtim.noind where tdtim.noind = pri.noind and tdtim.tanggal between '$period1' and '$period2') as pointtt,
	    					(select sum(case
	    									when tdtim.kd_ket='TIK'
	    									then tdtim.point
	    									else 0
	    								end)
	    					from \"Presensi\".tdatatim as tdtim inner join hrd_khs.tpribadi tp on tp.noind=tdtim.noind where tdtim.noind = pri.noind and tdtim.tanggal between '$period1' and '$period2') as pointtik,
	    					(select sum(case
	    									when tdtim.kd_ket='TM'
	    									then tdtim.point
	    									else 0
	    								end)
	    					from \"Presensi\".tdatatim as tdtim inner join hrd_khs.tpribadi tp on tp.noind=tdtim.noind where tdtim.noind = pri.noind and tdtim.tanggal between '$period1' and '$period2') as pointtm,
	    					(
							select 	concat(masa_kerja.tahun, ' tahun ', masa_kerja.bulan, ' bulan ', masa_kerja.hari, ' hari')
							from (
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
	    				from hrd_khs.tpribadi pri inner join hrd_khs.tseksi ts on pri.kodesie=ts.kodesie where pri.noind in ($noind)
	    				 and  pri.keluar='$keluar'
	    	";
	    	$data = $this->personalia->query($query);
	    	return $data->result_array();
	    }

	    public function rekapTIMS($tgl1, $tgl2, $year_month = FALSE, $noind = FALSE, $kode_status_kerja = FALSE, $dept = FALSE, $bidang = FALSE, $unit = FALSE, $seksi = FALSE, $lokasi = FALSE)
	    {
	    	// print_r($kode_status_kerja);exit();
	    	// Menentukan rekap periode bulanan atau tidak
	    	if($year_month === FALSE)
	    	{
	    		$year_month 	=	'';
	    	}

	    	$parameter 	=	'';
	    	// Menentukan parameter rekap
	    	// if (strlen($noind) < 1) {
	    	// 	echo strlen(string);
	    	// }
	    	// echo $noind;exit();
	    	$status ="";
	    	if($noind !== FALSE)
	    	{
	    		$parameter 	= '	pri.noind in ('.$noind.')';
	    	}
	    	else
	    	{
	    		if ($kode_status_kerja == 'All')
	    		{
					$kode_status_kerja = "pri.kode_status_kerja";
					// exit();
				}
				else
				{
					$count = count($kode_status_kerja);
					// echo $count;exit();

					foreach ($kode_status_kerja as $noind) {
						$count--;
						if ($count !== 0) {
							$status .= '\''.$noind.'\',';
						}
						else{
							$status .= '\''.$noind.'\'';
						}
					}
					// $kode_status_kerja = "'".$kode_status_kerja."'";
					// print_r($status); exit();
				}

				if ($dept == 'All')
				{
					$dept = "rtrim(tseksi.dept)";
				}
				else
				{
					$dept = "rtrim('".$dept."')";
				}

				if ($bidang == 'All')
				{
					$bidang = "rtrim(tseksi.bidang)";
				}
				else
				{
					$bidang = "rtrim('".$bidang."')";
				}

				if ($unit == 'All')
				{
					$unit = "rtrim(tseksi.unit)";
				}
				else
				{
					$unit = "rtrim('".$unit."')";
				}

				if ($seksi == 'All')
				{
					$seksi = "rtrim(tseksi.seksi)";
				}
				else
				{
					$seksi = "rtrim('".$seksi ."')";
				}

				if ($lokasi !== FALSE and $lokasi !== '00') {
		    		$loker = "and pri.lokasi_kerja = '$lokasi'";
		    	}else{
		    		$loker = "";
		    	}

				if ($kode_status_kerja == 'pri.kode_status_kerja') {
	    			$parameter 	= '	pri.kode_status_kerja='.$kode_status_kerja.'
	    						and 	rtrim(tseksi.dept)='.$dept.'
	    						and 	rtrim(tseksi.bidang)='.$bidang.'
	    						and 	rtrim(tseksi.unit)='.$unit.'
	    						and 	rtrim(tseksi.seksi)='.$seksi.'
	    						and 	pri.keluar=false '.$loker;
				}else{
					$parameter 	= '	pri.kode_status_kerja in'."(".$status.")".'
	    						and 	rtrim(tseksi.dept)='.$dept.'
	    						and 	rtrim(tseksi.bidang)='.$bidang.'
	    						and 	rtrim(tseksi.unit)='.$unit.'
	    						and 	rtrim(tseksi.seksi)='.$seksi.'
	    						and 	pri.keluar=false '.$loker;
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
											) as frekt".$year_month.",
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TT'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as bobott".$year_month.",
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
											) as frekts".$year_month.",
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
											) as bobotts".$year_month.",
											/*Ijin Keluar Pribadi - Status Pekerja Aktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TIK'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as freki".$year_month.",
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TIK'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as boboti".$year_month.",
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
											) as frekis".$year_month.",
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
											) as bobotis".$year_month.",
											/*Mangkir - Status Pekerja Aktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as frekm".$year_month.",
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point>0
															and 	trim(tim.noind)=pri.noind
											) as bobotm".$year_month.",
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
											) as frekms".$year_month.",
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
											) as bobotms".$year_month.",
											/*Mangkir Tidak berpoint- Status Pekerja Aktif*/
											(
												select 		coalesce(count(tim.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point=0
															and 	trim(tim.noind)=pri.noind
											) as frekmnon".$year_month.",
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
												from 		\"Presensi\".tdatatim as tim
												where 		tim.tanggal between param.tgl1 and param.tgl2
															and 	trim(tim.kd_ket)='TM'
															and 	tim.point=0
															and 	trim(tim.noind)=pri.noind
											) as bobotmnon".$year_month.",
											/*Mangkir Tidak berpoint- Status Pekerja Nonaktif*/
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
											) as frekmsnon".$year_month.",
											(
												select 		sum(round(coalesce(tim.point::numeric, 0), 1)) as total_bobot
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
											) as bobotmsnon".$year_month.",
											/*Sakit Keterangan Dokter - Status Pekerja Aktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PSK'
															and 	datapres.noind=pri.noind
											) as freksk".$year_month.",
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
											) as freksks".$year_month.",
											/*Sakit Perusahaan - Status Pekerja Aktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PSP'
															and 	datapres.noind=pri.noind
											) as frekpsp".$year_month.",
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
											) as frekpsps".$year_month.",
											/*Ijin Perusahaan - Status Pekerja Aktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='PIP'
															and 	datapres.noind=pri.noind
											) as frekip".$year_month.",
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
											) as frekips".$year_month.",
											/*Cuti Tahunan - Status Pekerja Aktif*/
											(
												select 		coalesce(count(datapres.tanggal)) as total_frekuensi
												from 		\"Presensi\".tdatapresensi as datapres
												where 		datapres.tanggal between param.tgl1 and param.tgl2
															and 	datapres.kd_ket='CT'
															and 	datapres.noind=pri.noind
											) as frekct".$year_month.",
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
											) as frekcts".$year_month.",
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
															and 	 ((param.tgl1 >= tabelsp.tanggal_awal_berlaku and param.tgl1 < tabelsp.tanggal_akhir_berlaku) or (param.tgl2 >= tabelsp.tanggal_awal_berlaku and param.tgl2 < tabelsp.tanggal_akhir_berlaku))
															and 	tabelsp.lanjutan='STOP'
											) as freksp".$year_month.",
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
												where 		((param.tgl1 >= tabelsp.tanggal_awal_berlaku and param.tgl1 < tabelsp.tanggal_akhir_berlaku) or (param.tgl2 >= tabelsp.tanggal_awal_berlaku and param.tgl2 < tabelsp.tanggal_akhir_berlaku))
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
											) as freksps".$year_month.",
											/*Rekap Surat Peringatan - Status Pekerja Aktif*/
											(
												select	count(*)	from \"Surat\".v_surat_tsp_rekap as tabelsp
												where 		tabelsp.noind=pri.noind
															and 	 (tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2)
											) as total_jmlsp".$year_month.",
											/*Rekap Surat Peringatan - Status Pekerja Nonaktif*/
											(
												select	count(*)	from \"Surat\".v_surat_tsp_rekap as tabelsp
												where 		(tabelsp.tanggal_awal_berlaku between param.tgl1 - interval '6 month' + interval '1 day' and param.tgl2)
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
											) as total_jmlsps".$year_month.",
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
								where 		$parameter
								order by 	tseksi.kodesie,
											pri.kd_jabatan,
											pri.noind";
			// echo $rekapTIMS.'<br/>'; exit();
			// echo $parameter;exit();
			$queryRekapTIMS =	$this->personalia->query($rekapTIMS);
			return $queryRekapTIMS->result_array();
	    }
 	}
