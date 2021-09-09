<?php
	class M_rekapabsensi extends CI_Model
	{
		
		public function __construct()
	    {
	        parent::__construct();
			$this->personalia = $this->load->database('personalia', TRUE );
	    }

		public function ambilDepartemen($term)
		{
			$ambilDepartemen			= "	select distinct 	substring(tseksi.kodesie,1,1) as kode_departemen,
																rtrim(tseksi.dept) as nama_departemen
											from 				hrd_khs.tseksi as tseksi
											where 				rtrim(tseksi.kodesie)!='-'
																and 	rtrim(tseksi.dept)!='-'
																and rtrim(tseksi.dept) like '%$term%'
											union
											select 				'0' as kode_departemen,
																'SEMUA DEPARTEMEN' as nama_departemen
											order by 			kode_departemen;";

			$queryAmbilDepartemen		=	$this->personalia->query($ambilDepartemen);
			return $queryAmbilDepartemen->result_array();
		}

		public function ambilBidang($departemen, $term)
		{
			$ambilBidang 				= "	select distinct		substring(tseksi.kodesie,1,3) as kode_bidang,
																rtrim(tseksi.bidang) as nama_bidang
											from 				hrd_khs.tseksi as tseksi
											where 				rtrim(tseksi.kodesie)!='-'
																and 	rtrim(tseksi.bidang)!='-'
																and 	substring(tseksi.kodesie,1,1)='$departemen'
																and 	rtrim(tseksi.bidang) like '%$term%'
											union
											select 				concat('$departemen', '00') as kode_bidang,
																'SEMUA BIDANG' as nama_bidang
											order by 			kode_bidang;";
			$queryAmbilBidang 			=	$this->personalia->query($ambilBidang);
			return $queryAmbilBidang->result_array();
		}

		public function ambilUnit($bidang, $term)
		{
			$ambilUnit			= "	select distinct 	substring(tseksi.kodesie,1,5) as kode_unit,
														rtrim(tseksi.unit) as nama_unit
									from 				hrd_khs.tseksi as tseksi
									where 				rtrim(tseksi.kodesie)!='-'
														and 	rtrim(tseksi.unit)!='-'
														and 	substring(tseksi.kodesie,1,3)='$bidang'
														and 	rtrim(tseksi.unit) like '%$term%'
									union
									select 				concat('$bidang', '00') as kode_unit,
														'SEMUA UNIT' as nama_bidang					
									order by 			kode_unit;";
			$queryAmbilUnit 	=	$this->personalia->query($ambilUnit);
			return $queryAmbilUnit->result_array();
		}

		public function ambilSeksi($unit, $term)
		{
			$ambilSeksi			= "	select distinct 	substring(tseksi.kodesie,1,7) as kode_seksi,
														rtrim(tseksi.seksi) as nama_seksi
									from 				hrd_khs.tseksi as tseksi
									where 				rtrim(tseksi.kodesie)!='-'
														and 	rtrim(tseksi.seksi)!='-'
														and 	rtrim(tseksi.seksi) like '%$term%'
														and 	substring(tseksi.kodesie,1,5)='$unit'
									union
									select 				concat('$unit', '00') as kode_seksi,
														'SEMUA SEKSI' as nama_bidang					
									order by 			kode_seksi;";
			$queryAmbilSeksi	=	$this->personalia->query($ambilSeksi);
			return $queryAmbilSeksi->result_array();
		}

		public function ambilLokasi($lokasi)
		{
			$ambilLokasi			= "	SELECT id_, lokasi_kerja FROM hrd_khs.tlokasi_kerja WHERE id_ LIKE '%$lokasi%' OR lokasi_kerja LIKE '%$lokasi%' 
										union select '00' as id_, 'SEMUA LOKASI KERJA' as lokasi_kerja ORDER BY id_;";
			$queryAmbilLokasi	=	$this->personalia->query($ambilLokasi);
			return $queryAmbilLokasi->result_array();
		}

		public function rekapPresensiHarian($tanggalHitung, $klausaWhereKodesie, $lokasi)
		{
			$rekapPresensiHarian			= "	SELECT 			tabeltanggal.tanggal as tanggal_presensi,
																tblpkj.noind as nomor_induk,
																tblpkj.nama as nama,
																tblpkj.lokasi_kerja as lokasi_kerja,
																(select lokasi_kerja from hrd_khs.tlokasi_kerja where id_ = RTRIM(tblpkj.lokasi_kerja)) as lokasi,
																sftpkj.kodesie as kode_seksi,
																sftpkj.kd_shift as kode_shift,
																sftpkj.kodesie as kode_seksi,
																sftpkj.kd_shift as kode_shift,
																sftpkj.jam_msk as jam_masuk,
																sftpkj.jam_akhmsk as jam_batas_masuk,
																sftpkj.jam_plg as jam_pulang,
																(
																	select 		tseksi.dept
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=sftpkj.kodesie
																) as nama_departemen,
																(
																	select 		tseksi.bidang
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=sftpkj.kodesie
																) as nama_bidang,
																(
																	select 		tseksi.unit
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=sftpkj.kodesie
																) as nama_unit,
																(
																	select 		tseksi.seksi
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=sftpkj.kodesie
																) as nama_seksi,
																(
																	coalesce
																	(
																		(
																			select 		tshift.shift
																			from 		\"Presensi\".tshift as tshift
																			where 		tshift.kd_shift=sftpkj.kd_shift
																		)
																		,
																		'-'
																	)
																) as shift,
																(
																	case 	when 	concat_ws
																					('; ',
																						(
																							select distinct array_to_string(array_agg(rtrim(pres_ket.keterangan)), '; ')
																							from 			\"Presensi\".tdatapresensi as datapres
																											join 	\"Presensi\".tketerangan as pres_ket
																												on 	pres_ket.kd_ket=datapres.kd_ket
																							where 			datapres.tanggal=tabeltanggal.tanggal
																											and 	datapres.noind=tblpkj.noind
																						),
																						(
																							select 			array_to_string(array_agg(rtrim(pres_ket.keterangan)), '; ')
																							from 			\"Presensi\".tdatatim as tim
																											join 	\"Presensi\".tketerangan as pres_ket
																												on 	pres_ket.kd_ket=tim.kd_ket
																							where 			tim.tanggal=tabeltanggal.tanggal
																											and 	tim.noind=tblpkj.noind
																						)
																					)!=''
																			then 	concat_ws
																					('; ',
																						(
																							select distinct array_to_string(array_agg(rtrim(pres_ket.keterangan)), '; ')
																							from 			\"Presensi\".tdatapresensi as datapres
																											join 	\"Presensi\".tketerangan as pres_ket
																												on 	pres_ket.kd_ket=datapres.kd_ket
																							where 			datapres.tanggal=tabeltanggal.tanggal
																											and 	datapres.noind=tblpkj.noind
																						),
																						(
																							select 			array_to_string(array_agg(rtrim(pres_ket.keterangan)), '; ')
																							from 			\"Presensi\".tdatatim as tim
																											join 	\"Presensi\".tketerangan as pres_ket
																												on 	pres_ket.kd_ket=tim.kd_ket
																							where 			tim.tanggal=tabeltanggal.tanggal
																											and 	tim.noind=tblpkj.noind
																						)
																					)
																			else 	(
																						case 	when	tabeltanggal.tanggal=current_date
																										then 	(
																													case 	when 	current_time < sftpkj.jam_akhmsk::time
																																	then	(
																																				case 	when 	(
																																									select 		count(frontpres.waktu)
																																									from 		\"FrontPresensi\".tpresensi as frontpres
																																									where 		frontpres.tanggal=tabeltanggal.tanggal
																																												and 	frontpres.noind=tblpkj.noind
																																												and 	frontpres.waktu::time<=current_time
																																								)>0
																																								then	'Kerja (hari berjalan)'
																																						else 	'-'
																																				end
																																			)
																															else 	(
																																		case 	when 	(
																																							select 		count(frontpres.waktu)
																																							from 		\"FrontPresensi\".tpresensi as frontpres
																																							where 		frontpres.tanggal=tabeltanggal.tanggal
																																										and 	frontpres.noind=tblpkj.noind
																																										and 	frontpres.waktu::time<=current_time
																																						)>0
																																						then 	'Kerja (hari berjalan)'
																																				else 	'Mangkir'
																																		end
																																	)
																													end
																												)
																						end
																					)
																	end
																) as keterangan,
																(
																	coalesce
																	(
																		(
																			select 		array_to_string(array_agg(frontpres2.waktu::time), '; ')
																			from 		(
																							select 		frontpres3.waktu as waktu
																							from 		\"FrontPresensi\".tpresensi as frontpres3
																							where 		frontpres3.tanggal=tabeltanggal.tanggal
																										and 	frontpres3.noind=tblpkj.noind
																							order by 	waktu
																						) as frontpres2
																		),
																		'-'
																	)
																) as waktu
												from 			\"Presensi\".tshiftpekerja as sftpkj
																join 		(
																				select distinct	frontpres.tanggal::date as tanggal
																				from 			\"FrontPresensi\".tpresensi as frontpres
																				where 			frontpres.tanggal between '$tanggalHitung' and '$tanggalHitung'
																								and 	$klausaWhereKodesie
																				order by 		tanggal
																			) as tabeltanggal
																			on 	tabeltanggal.tanggal=sftpkj.tanggal::date
																left join 	(
																				select 		pri.noind,
																							pri.nama,
																							pri.lokasi_kerja
																				from 		hrd_khs.tpribadi as pri
																				where 		$klausaWhereKodesie
																							and 	(
																										pri.noind=pri.noind
																									)
																				order by 	pri.noind
																			) as tblpkj
																			on tblpkj.noind=sftpkj.noind
												where			sftpkj.tanggal between '$tanggalHitung' and '$tanggalHitung'
																and 	$klausaWhereKodesie and lokasi_kerja like '%$lokasi%'
												group by		tanggal_presensi,
																nomor_induk,
																nama,
																kode_seksi,
																kode_shift,
																jam_masuk,
																jam_batas_masuk,
																jam_pulang,
																lokasi_kerja
												order by 		tanggal_presensi,
																kode_seksi,
																lokasi_kerja,
																nomor_induk;";
		// echo "<pre>"; print_r($rekapPresensiHarian); exit();
			$queryRekapPresensiHarian 		=	$this->personalia->query($rekapPresensiHarian);
			return $queryRekapPresensiHarian->result_array();
		}

		public function statistikPresensiHarian($tanggalHitung, $klausaWhereKodesie)
		{
			// $statistikPresensiHarian			= "	select			tabeltanggal.tanggal,
			// 														(
			// 															case 	when 	tabeltanggal.tanggal=current_date
			// 																			then	(
			// 																						select 		count(distinct frontpres.noind)
			// 																						from 		\"FrontPresensi\".tpresensi as frontpres
			// 																						where 		frontpres.tanggal=tabeltanggal.tanggal
			// 																									and 	frontpres.waktu::time<=current_time
			// 																									and 	$klausaWhereKodesie
			// 																					)
			// 																	else 	(
			// 																					select		count(distinct noind)
			// 																					from 		\"Presensi\".tdatapresensi as datapres
			// 																					where		datapres.tanggal=tabeltanggal.tanggal
			// 																								and 	$klausaWhereKodesie
			// 																								and 	(
			// 																											datapres.kd_ket='PKJ'
			// 																											or 	datapres.kd_ket='PLB'
			// 																											or 	datapres.kd_ket='PID'
			// 																											or 	datapres.kd_ket='PDL'
			// 																											or 	datapres.kd_ket='PDB'
			// 																											or 	datapres.kd_ket='PSP'
			// 																										)
			// 																			)
			// 															end
			// 														) as jumlah_pekerja_hadir,
			// 														(
			// 															(
			// 																select 		count(distinct noind)
			// 																from 		\"Presensi\".tdatapresensi as datapres
			// 																where 		datapres.tanggal=tabeltanggal.tanggal
			// 																			and 	$klausaWhereKodesie
			// 																			and 	(
			// 																						datapres.kd_ket!='PKJ'
			// 																						and 	datapres.kd_ket!='PLB'
			// 																						and 	datapres.kd_ket!='PID'
			// 																						and 	datapres.kd_ket!='PDL'
			// 																						and 	datapres.kd_ket!='PDB'
			// 																						and 	datapres.kd_ket!='PSP'
			// 																					)
			// 															)
			// 															+
			// 															(
			// 																select 		count(distinct noind)
			// 																from 		\"Presensi\".tdatatim as tim
			// 																where 		tim.tanggal=tabeltanggal.tanggal
			// 																			and 	$klausaWhereKodesie
			// 																			and 	tim.kd_ket='TM'
			// 															)
			// 															+
			// 															(
			// 																case 	when 	current_date=tabeltanggal.tanggal
			// 																				then	(
			// 																							select 		count(frontpres.waktu)
			// 																							from 		\"FrontPresensi\".tpresensi as frontpres
			// 																							where 		frontpres.tanggal=tabeltanggal.tanggal
			// 																										and 	frontpres.noind=tblpkj.noind
			// 																										and 	frontpres.waktu::time<=current_time
			// 																						)
			// 																		else 	0
			// 																end
			// 															)
			// 														) as jumlah_pekerja_tidak_hadir
			// 										from 			(
			// 															select distinct	frontpres.tanggal::date as tanggal
			// 															from 			\"FrontPresensi\".tpresensi as frontpres
			// 															where 			frontpres.tanggal between '$tanggalHitung' and '$tanggalHitung'
			// 																			and 	$klausaWhereKodesie
			// 															order by 		tanggal
			// 														) as tabeltanggal;";
			$statistikPresensiHarian			= "	select			tabeltanggal.tanggal,
																	(
																		case 	when 	tabeltanggal.tanggal=current_date
																						then	(
																									select 		count(distinct frontpres.noind)
																									from 		\"FrontPresensi\".tpresensi as frontpres
																									where 		frontpres.tanggal=tabeltanggal.tanggal
																												and 	$klausaWhereKodesie
																								)
																				else 	(
																								select		count(distinct noind)
																								from 		\"Presensi\".tdatapresensi as datapres
																								where		datapres.tanggal=tabeltanggal.tanggal
																											and 	$klausaWhereKodesie
																											and 	(
																														datapres.kd_ket='PKJ'
																														or 	datapres.kd_ket='PLB'
																														or 	datapres.kd_ket='PID'
																														or 	datapres.kd_ket='PDL'
																														or 	datapres.kd_ket='PDB'
																														or 	datapres.kd_ket='PSP'
																													)
																						)
																		end
																	) as jumlah_pekerja_hadir,
																	(
																		(
																			select 		count(distinct noind)
																			from 		\"Presensi\".tdatapresensi as datapres
																			where 		datapres.tanggal=tabeltanggal.tanggal
																						and 	$klausaWhereKodesie
																						and 	(
																									datapres.kd_ket!='PKJ'
																									and 	datapres.kd_ket!='PLB'
																									and 	datapres.kd_ket!='PID'
																									and 	datapres.kd_ket!='PDL'
																									and 	datapres.kd_ket!='PDB'
																									and 	datapres.kd_ket!='PSP'
																								)
																		)
																		+
																		(
																			select 		count(distinct noind)
																			from 		\"Presensi\".tdatatim as tim
																			where 		tim.tanggal=tabeltanggal.tanggal
																						and 	$klausaWhereKodesie
																						and 	tim.kd_ket='TM'
																		)
																	) as jumlah_pekerja_tidak_hadir
													from 			(
																		select distinct	frontpres.tanggal::date as tanggal
																		from 			\"FrontPresensi\".tpresensi as frontpres
																		where 			frontpres.tanggal between '$tanggalHitung' and '$tanggalHitung'
																						and 	$klausaWhereKodesie
																		order by 		tanggal
																	) as tabeltanggal;";																	
			$queryStatistikPresensiHarian		=	$this->personalia->query($statistikPresensiHarian);
			return $queryStatistikPresensiHarian->result_array();
		}
	}
?>