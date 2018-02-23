<?php
	class M_rekapjamkerja extends CI_Model
	{
		
		public function __construct()
	    {
	        parent::__construct();
			$this->personalia = $this->load->database('personalia', TRUE );
	    }

	    public function ambilLokasiKerja($keyword)
	    {
	    	$ambilLokasiKerja 		= "	select 		trim(lokker.id_) as kode_lokasi_kerja, 
													rtrim(lokker.lokasi_kerja) as nama_lokasi_kerja
										from 		hrd_khs.tlokasi_kerja as lokker
										where 		(
														lokker.id_ like '$keyword%'
														or 	lokker.lokasi_kerja like '$keyword%'
													)
										order by 	id_::numeric";
			$queryAmbilLokasiKerja 	= 	$this->personalia->query($ambilLokasiKerja);
			return $queryAmbilLokasiKerja->result_array();
	    }

	    public function prosesRekapJamKerja($tanggalAwalRekap, $tanggalAkhirRekap, $lokasiKerja, $tambahLembur)
	    {
	    	$prosesRekapJamKerja 		= "	--explain 	analyze
											select 		tseksi.kodesie as kode_seksi,
														tseksi.dept as nama_departemen,
														tseksi.bidang as nama_bidang,
														tseksi.unit as nama_unit,
														tseksi.seksi as nama_seksi,
														coalesce(round((a.jam_kerja_seksi/3600)::numeric, 3), 0) as \"A\",
														coalesce(round((b.jam_kerja_seksi/3600)::numeric, 3), 0) as \"B\",
														coalesce(round((c.jam_kerja_seksi/3600)::numeric, 3), 0) as \"C\",
														coalesce(round((d.jam_kerja_seksi/3600)::numeric, 3), 0) as \"D\",
														coalesce(round((e.jam_kerja_seksi/3600)::numeric, 3), 0) as \"E\",
														coalesce(round((f.jam_kerja_seksi/3600)::numeric, 3), 0) as \"F\",
														coalesce(round((g.jam_kerja_seksi/3600)::numeric, 3), 0) as \"G\",
														coalesce(round((h.jam_kerja_seksi/3600)::numeric, 3), 0) as \"H\",
														coalesce(round((j.jam_kerja_seksi/3600)::numeric, 3), 0) as \"J\",
														coalesce(round((kp.jam_kerja_seksi/3600)::numeric, 3), 0) as \"K-P\",
														coalesce(round((q.jam_kerja_seksi/3600)::numeric, 3), 0) as \"Q\"
											from 		(
															select 		substring(tseksi.kodesie, 1, 7) as kodesie,
																		rtrim(tseksi.dept) as dept,
																		rtrim(tseksi.bidang) as bidang,
																		rtrim(tseksi.unit) as unit,
																		rtrim(tseksi.seksi) as seksi
															from 		hrd_khs.tseksi as tseksi
															where 		trim(tseksi.kodesie)!='-'
																		and 	right(trim(tseksi.kodesie), 2)='00'
														) as tseksi
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='A'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as a
																	on	a.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='B'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as b
																	on	b.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='C'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as c
																	on	c.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='D'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as d
																	on	d.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='E'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as e
																	on	e.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='F'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as f
																	on	f.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='G'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as g
																	on	g.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='H'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as h
																	on	h.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='J'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as j
																	on	j.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	(
																																								pri.kode_status_kerja='K'
																																								or 	pri.kode_status_kerja='P'
																																							)
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as kp
																	on	kp.kode_seksi=tseksi.kodesie
														left join 	(
																		select		substring(hasilpernoind.kodesie, 1, 7) as kode_seksi,
																					sum
																					(
																						hasilpernoind.jam_kerja_hasil
																					) as jam_kerja_seksi
																		from 		(
																						select		hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie,
																									sum
																									(
																										hasilpertanggalshift.jam_kerja_pokok*3600
																										-
																										(hasilpertanggalshift.pengurang_cuti*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_tidak_hadir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_mangkir*hasilpertanggalshift.jam_kerja_pokok*3600)
																										-
																										(hasilpertanggalshift.pengurang_ikp)
																										-
																										(hasilpertanggalshift.pengurang_psp)
																										+
																										(hasilpertanggalshift.lembur)
																									) as jam_kerja_hasil
																						from 		(
																										select		tshiftpekerja.tanggal,
																													tshiftpekerja.noind,
																													tshiftpekerja.noind_baru,
																													(
																														case 	when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku asc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm 
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku asc 
																										                 							limit 		1
																																				)
																																when 	tshiftpekerja.tanggal
																																		<
																																		(
																																			select 		tglberlaku 
																										                 					from 		hrd_khs.tmutasi 
																										                 					where  		noind=tshiftpekerja.noind 
																										                 					order by 	tglberlaku desc 
																										                 					limit 		1
																																		)
																																		then	(
																																					select 		kodesielm
																										                 							from 		hrd_khs.tmutasi 
																										                 							where  		noind=tshiftpekerja.noind 
																										                 							order by 	tglberlaku desc 
																										                 							limit 		1
																																				)
																																else 	tshiftpekerja.kodesie
																														end
																													) as kodesie,
																													sum
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																(
																																	tshiftpekerja.jam_plg
																																	-
																																	tshiftpekerja.jam_msk
																																)
																																-
																																(
																																	tshiftpekerja.ist_selesai
																																	-
																																	tshiftpekerja.ist_mulai
																																)
																																-
																																(
																																	tshiftpekerja.break_selesai
																																	-
																																	tshiftpekerja.break_mulai
																																)
																															)
																														)
																														/3600
																													)::numeric as jam_kerja_pokok,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									substring(kd_ket, 1, 1)='C'
																																									or 	kd_ket='PCZ'
																																								)
																																		) as datapres
																														)
																													) as pengurang_cuti,
																													(
																														(
																															select 		count(datapres.*)
																															from 		(
																																			select 		tanggal::date as tanggal,
																																						trim(noind) as noind,
																																						trim(noind_baru) as noind_baru,
																																						trim(kodesie) as kodesie,
																																						to_timestamp
																																						(
																																							concat_ws
																																							(
																																								' ',
																																								tanggal::date,
																																								(
																																									case 	when 	(
																																														masuk='0'
																																														or 	masuk=''
																																														or 	masuk='__:__:__'
																																													)
																																													then 	'00:00:00'::time
																																											else 	masuk::time
																																									end
																																								)
																																							),
																																							'YYYY-MM-DD HH24:MI:SS'
																																						) as masuk,
																																						(
																																							case 	when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											<
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															(tanggal + interval '1 day')::date, 
																																															(
																																																case 	when 	keluar='0'
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																									when 	(
																																												case 	when 	(
																																																	keluar='0'
																																																	or 	keluar=''
																																																	or 	keluar='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	keluar::time
																																												end
																																											)
																																											>
																																											(
																																												case 	when 	(
																																																	masuk='0'
																																																	or 	masuk=''
																																																	or 	masuk='__:__:__'
																																																)
																																																then 	'00:00:00'::time
																																														else 	masuk::time
																																												end
																																											)
																																											then 	to_timestamp
																																													(
																																														concat_ws
																																														(
																																															' ', 
																																															tanggal::date, 
																																															(
																																																case 	when 	(
																																																					keluar='0'
																																																					or 	keluar=''
																																																					or 	keluar='__:__:__'
																																																				)
																																																				then 	'00:00:00'::time
																																																		else 	keluar::time
																																																end
																																															)
																																														),
																																														'YYYY-MM-DD HH24:MI:SS'
																																													)
																																							end
																																						) as keluar,
																																						trim(kd_ket) as kd_ket
																																			from 		\"Presensi\".tdatapresensi
																																			where 		tanggal=tshiftpekerja.tanggal
																																						and 	noind=tshiftpekerja.noind
																																						and 	(
																																									kd_ket='PIP'
																																									or 	kd_ket='PKK'
																																									or 	kd_ket='PRM'
																																									or 	kd_ket='PSK'
																																								)
																																		) as datapres
																														)
																													) as pengurang_tidak_hadir,
																													(
																														select	count(*)
																														from 	\"Presensi\".tdatatim as tim
																														where 	tim.tanggal=tshiftpekerja.tanggal
																																and 	tim.noind=tshiftpekerja.noind
																																and 	tim.kd_ket='TM'
																																and 	tim.point!=0
																													) as pengurang_mangkir,
																													sum
																													(
																														tshiftpekerja.pengurang_ikp
																													) as pengurang_ikp,
																													sum
																													(
																														tshiftpekerja.pengurang_psp
																													) as pengurang_psp,
																													(
																														case 	when 	'$tambahLembur'='1'
																																		then 	(
																																					select	coalesce(sum(tlembur.jml_lembur), 0) * 60
																																					from	\"Presensi\".tlembur as tlembur
																																					where 	tlembur.tanggal=tshiftpekerja.tanggal
																																							and 	tlembur.noind=tshiftpekerja.noind
																																				)
																																else 	0
																														end
																													) as lembur
																										from 		(
																														select		tshiftpekerja.*,
																																	(
																																		case  	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatatim as tim
																																							where 		tim.tanggal=tshiftpekerja.tanggal
																																										and 	tim.noind=tshiftpekerja.noind
																																										and 	tim.kd_ket='TIK'
																																										and 	(
																																													case 	when 	tim.kd_ket='TIK'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TM'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															when 	tim.kd_ket='TT'
																																																	then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select		coalesce(sum(ikp.waktu_ikp), 0)
																																									from 		(
																																													select		(
																																																	case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										-- 	1:3
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	tim.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	tim.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																										--	3:5
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	tim.masuk
																																																																	-
																																																																	tim.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tim.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_ikp
																																													from 		(
																																																	select 		tim.tanggal::date as tanggal,
																																																				trim(tim.noind) as noind,
																																																				trim(tim.kodesie) as kodesie,
																																																				trim(tim.kd_ket) as kd_ket,
																																																				tim.point,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case 	when 	tim.kd_ket='TIK'
																																																									then 	(
																																																												case 	when 	tim.masuk::time<tim.keluar::time
																																																																then 	to_timestamp(concat_ws(' ', (tim.tanggal + interval '1 day')::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														else 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												end
																																																											)
																																																							when 	tim.kd_ket='TM'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							when 	tim.kd_ket='TT'
																																																									then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as masuk
																																																	from 		\"Presensi\".tdatatim as tim
																																																	where 		tim.tanggal=tshiftpekerja.tanggal
																																																				and 	tim.noind=tshiftpekerja.noind
																																																				and 	tim.kd_ket='TIK'
																																																) tim
																																													where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as ikp
																																								)
																																				else 	0
																																		end			
																																	) as pengurang_ikp,
																																	(
																																		case 	when 	(
																																							select 		count(*)
																																							from 		\"Presensi\".tdatapresensi as datapres
																																							where		datapres.kd_ket='PSP'
																																										and 	datapres.tanggal=tshiftpekerja.tanggal
																																										and 	datapres.noind=tshiftpekerja.noind
																																										and 	(
																																													case 	when 	datapres.keluar=''
																																																	or 	datapres.keluar='0'
																																																	or 	datapres.masuk='__:__:__'
																																																	then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																															else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																													end
																																												) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																						)>0
																																						then 	(
																																									select 		coalesce(sum(psp.waktu_psp), 0)
																																									from 		(
																																													select 		(
																																																	case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																					then	(
																																																										--	1:2
																																																								case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.break_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										-- 	1:3
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:4
																																																										when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	1:6
																																																										when	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	tshiftpekerja.break_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																					then	(
																																																										--	2:3
																																																								case 	when	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																																												then 	0
																																																										--	2:4
																																																										when 	datapres.masuk between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										-- 	2:5
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																										--	2:6
																																																										when 	datapres.masuk between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.break_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																					then	(
																																																										-- 	3:4
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and (tshiftpekerja.ist_mulai - interval '1 second')
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																										--	3:5
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																										-- 	3:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	tshiftpekerja.ist_mulai
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																					then 	(
																																																										--	4:5
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																																												then 	0
																																																										--	4:6
																																																										when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract
																																																														(
																																																															epoch
																																																															from
																																																															(
																																																																(
																																																																	datapres.masuk
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																																-
																																																																(
																																																																	tshiftpekerja.ist_selesai
																																																																	-
																																																																	datapres.keluar
																																																																)
																																																															)
																																																														)
																																																								end
																																																							)
																																																			when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																					then 	(
																																																										-- 	5:6
																																																								case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																																												then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																																								end
																																																							)
																																																			else 	0
																																																	end
																																																) as waktu_psp
																																													from 		(
																																																	select 		datapres.tanggal::date as tanggal,
																																																				trim(datapres.noind) as noind,
																																																				trim(datapres.kodesie) as kodesie,
																																																				trim(datapres.kd_ket) as kd_ket,
																																																				(
																																																					case 	when 	datapres.keluar=''
																																																									or 	datapres.keluar='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																					end
																																																				) as keluar,
																																																				(
																																																					case	when 	datapres.masuk=''
																																																									or 	datapres.masuk='0'
																																																									or 	datapres.masuk='__:__:__'
																																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																							else 	(
																																																										case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																														<
																																																														(
																																																															case 	when 	datapres.keluar=''
																																																																			or 	datapres.keluar='0'
																																																																			or 	datapres.masuk='__:__:__'
																																																																			then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, '00:00:00'::time), 'YYYY-MM-DD HH24:MI:SS')
																																																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																																															end
																																																														)
																																																														then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																																										end			
																																																									)
																																																					end
																																																				) as masuk,
																																																				datapres.total_lembur,
																																																				trim(datapres.ket) as ket
																																																	from 		\"Presensi\".tdatapresensi as datapres
																																																	where 		datapres.kd_ket='PSP'
																																																				and 	datapres.tanggal::date=tshiftpekerja.tanggal
																																																				and 	datapres.noind=tshiftpekerja.noind
																																																) as datapres
																																													where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																																												) as psp
																																								)
																																				else 	0
																																		end
																																	) as pengurang_psp
																														from		(
																																		select 		sftpkj.tanggal::date as tanggal,
																																					trim(sftpkj.noind) as noind,
																																					trim(sftpkj.noind_baru) as noind_baru,
																																					trim(sftpkj.kd_shift) as kd_shift,
																																					trim(sftpkj.kodesie) as kodesie,
																																					sftpkj.tukar,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_msk,
																																					(
																																						to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_akhmsk::time), 'YYYY-MM-DD HH24:MI:SS')
																																					) as jam_akhmsk,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as jam_plg,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as break_selesai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_mulai,
																																					(
																																						(
																																							case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																											<
																																											to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																											then	to_timestamp(concat_ws(' ', (sftpkj.tanggal::timestamp + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																									else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																																							end
																																						)
																																					) as ist_selesai
																																		from 		\"Presensi\".tshiftpekerja as sftpkj
																																					join 	hrd_khs.tpribadi as pri
																																							on 	pri.noind=sftpkj.noind
																																		where 		sftpkj.tanggal between '$tanggalAwalRekap' and '$tanggalAkhirRekap'
																																					and 	pri.kode_status_kerja='Q'
																																					and 	pri.lokasi_kerja='$lokasiKerja'
																																		order by 	kodesie,
																																					noind,
																																					tanggal,
																																					kd_shift
																																	) as tshiftpekerja
																														order by 	tshiftpekerja.kodesie,
																																	tshiftpekerja.noind,
																																	tshiftpekerja.tanggal
																													) as tshiftpekerja
																										group by 	tanggal,
																													noind,
																													noind_baru,
																													kodesie
																										order by 	kodesie,
																													noind,
																													tanggal
																									) as hasilpertanggalshift
																						group by 	hasilpertanggalshift.noind,
																									hasilpertanggalshift.kodesie
																					) as hasilpernoind
																		group by 	substring(hasilpernoind.kodesie, 1, 7)
																	) as q
																	on	q.kode_seksi=tseksi.kodesie
											group by 	tseksi.kodesie,
														tseksi.dept,
														tseksi.bidang,
														tseksi.unit,
														tseksi.seksi,
														\"A\",
														\"B\",
														\"C\",
														\"D\",
														\"E\",
														\"F\",
														\"G\",
														\"H\",
														\"J\",
														\"K-P\",
														\"Q\"
											order by 	kode_seksi";
			$queryProsesRekapJamKerja 	=	$this->personalia->query($prosesRekapJamKerja);
			return $queryProsesRekapJamKerja->result_array();
	    }

	}
?>