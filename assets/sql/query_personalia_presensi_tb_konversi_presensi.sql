/*Query "Personalia"."Presensi".tb_konversi_presensi - F2225 - 20180706*/
set 		parallel.agg_workers = 16;
select		tshiftpekerja.*,
			(
				case	when 	tshiftpekerja.masuk=true
								and		tshiftpekerja.kerja_selesai>=tshiftpekerja.jam_plg
								and 	tshiftpekerja.kd_ket='PKJ'
								then 	(
											extract
											(
												epoch
												from
												(
													(
														tshiftpekerja.kerja_selesai
														-
														tshiftpekerja.jam_plg
													)
												)
											)::numeric
										)
						else 	0
				end
			) as overtime_pulang_bruto,
			(
				case	when 	tshiftpekerja.masuk=true
								and 	tshiftpekerja.kerja_selesai>tshiftpekerja.jam_plg
								and 	mod
										(
											(
												select 		case 	when	count(*)<1
																			then	null
																	else 	count(*)
															end
												from		"FrontPresensi".tpresensi as frontpres
												where 		frontpres.tanggal between tshiftpekerja.jam_msk::date and tshiftpekerja.jam_plg::date
															and		to_timestamp(concat_ws(' ', frontpres.tanggal::date, frontpres.waktu::time), 'YYYY-MM-DD HH24:MI:SS')
																	>
																	tshiftpekerja.jam_plg
															and 	to_timestamp(concat_ws(' ', frontpres.tanggal::date, frontpres.waktu::time), 'YYYY-MM-DD HH24:MI:SS')
																	<
																	tshiftpekerja.kerja_selesai
															and 	frontpres.noind=tshiftpekerja.noind
											),
											2
										)
										=
										0
								then 	(
											select 		sum(p.selisih)
											from 		(
															select		a.*,
																		extract
																		(
																			epoch
																			from
																			(				
																				a.jam2
																				-
																				a.jam1
																			)
																		)::numeric as selisih
															from 		(
																			select		to_timestamp(concat_ws(' ', x.tanggal::date, x.waktu::time), 'YYYY-MM-DD HH24:MI:SS') as jam1,
																						(
																							select		to_timestamp(concat_ws(' ', y.tanggal::date, y.waktu::time), 'YYYY-MM-DD HH24:MI:SS')
																							from 		(
																											select 		frontpres.tanggal,
																														frontpres.noind,
																														frontpres.waktu,
																														row_number() over (order by waktu) as urutan
																											from 		"FrontPresensi".tpresensi as frontpres
																											where 		frontpres.noind=tshiftpekerja.noind
																														and 	frontpres.tanggal between tshiftpekerja.jam_msk::date and tshiftpekerja.jam_plg::date
																														and 	to_timestamp(concat_ws(' ', frontpres.tanggal::date, frontpres.waktu::time), 'YYYY-MM-DD HH24:MI:SS')
																																>
																																tshiftpekerja.jam_plg
																														and 	to_timestamp(concat_ws(' ', frontpres.tanggal::date, frontpres.waktu::time), 'YYYY-MM-DD HH24:MI:SS')
																																<
																																tshiftpekerja.kerja_selesai
																										) as y
																							where 		mod(y.urutan, 2)=0
																										and 	y.urutan>x.urutan
																							limit 		1
																						) as jam2
																			from 		(
																							select 		frontpres.tanggal,
																										frontpres.noind,
																										frontpres.waktu,
																										row_number() over (order by waktu) as urutan
																							from 		"FrontPresensi".tpresensi as frontpres
																							where 		frontpres.noind=tshiftpekerja.noind
																										and 	frontpres.tanggal between tshiftpekerja.jam_msk::date and tshiftpekerja.jam_plg::date
																										and 	to_timestamp(concat_ws(' ', frontpres.tanggal::date, frontpres.waktu::time), 'YYYY-MM-DD HH24:MI:SS')
																												>
																												tshiftpekerja.jam_plg
																										and 	to_timestamp(concat_ws(' ', frontpres.tanggal::date, frontpres.waktu::time), 'YYYY-MM-DD HH24:MI:SS')
																												<
																												tshiftpekerja.kerja_selesai
																						) as x
																			where 		mod(urutan, 2)=1
																		) as a
														) p
										)
						else 	0
				end	
			) as pengurang_ikp_sesudah_shift
from 		(
				select		tshiftpekerja.*,
							(
								case 	when 	tshiftpekerja.masuk=true
												then 	(
															coalesce
															(
																(
																	select 		(datapres.kd_ket)
																	from 		"Presensi".tdatapresensi as datapres
																	where 		datapres.noind=tshiftpekerja.noind
																				and 	datapres.tanggal=tshiftpekerja.tanggal
																				and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																				and 	(
																							case 	when 	datapres.masuk=''
																											or 	datapres.masuk='0'
																											or 	datapres.masuk='__:__:__'
																											then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																									else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																							end
																						)
																						>
																						tshiftpekerja.jam_plg_shift_sebelum
																				and 	(
																							case	when 	datapres.keluar=''
																											or 	datapres.keluar='0'
																											or 	datapres.keluar='__:__:__'
																											then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																									else 	(
																												case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																<
																																(
																																	case 	when 	datapres.masuk=''
																																					or 	datapres.masuk='0'
																																					or 	datapres.masuk='__:__:__'
																																					then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																			else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																	end
																																)
																																then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																														else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																												end			
																											)
																							end
																						)
																						<
																						tshiftpekerja.jam_msk_shift_sesudah
																),
																(
																	select 		(datapres.kd_ket)
																	from 		"Presensi".tdatapresensi as datapres
																	where 		datapres.noind=tshiftpekerja.noind
																				and 	datapres.tanggal=tshiftpekerja.tanggal
																				and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																)
															)
														)
										else 	(
													select 		(datapres.kd_ket) as kd_ket
													from 		"Presensi".tdatapresensi as datapres
													where 		datapres.tanggal=tshiftpekerja.tanggal
																and 	datapres.noind=tshiftpekerja.noind
																and 	(
																			datapres.kd_ket in ('PIP', 'PKK', 'PSK', 'PRM', 'PCZ')
																			or 	datapres.kd_ket like 'C%'
																		)
													union
													select 		(tim.kd_ket) as kd_ket
													from 		"Presensi".tdatatim as tim
													where 		tim.tanggal=tshiftpekerja.tanggal
																and 	tim.noind=tshiftpekerja.noind
																and 	(tim.kd_ket)='TM'
												)
								end
							) as kd_ket,
							(
								case	when 	tshiftpekerja.masuk=true
												then 	(
															case 	when 	(
																				select 		count(*)
																				from 		"Presensi".tdatapresensi as datapres
																				where 		datapres.noind=tshiftpekerja.noind
																							and 	datapres.tanggal=tshiftpekerja.tanggal
																							and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																							and 	(
																										case 	when 	datapres.masuk=''
																														or 	datapres.masuk='0'
																														or 	datapres.masuk='__:__:__'
																														then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																										end
																									)
																									>
																									tshiftpekerja.jam_plg_shift_sebelum
																							and 	(
																										case	when 	datapres.keluar=''
																														or 	datapres.keluar='0'
																														or 	datapres.keluar='__:__:__'
																														then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																												else 	(
																															case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																			<
																																			(
																																				case 	when 	datapres.masuk=''
																																								or 	datapres.masuk='0'
																																								or 	datapres.masuk='__:__:__'
																																								then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																						else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																				end
																																			)
																																			then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																															end			
																														)
																										end
																									)
																									<
																									tshiftpekerja.jam_msk_shift_sesudah
																			)
																			>
																			0
																			then 	(
																						select 	(
																									case 	when 	datapres.masuk=''
																													or 	datapres.masuk='0'
																													or 	datapres.masuk='__:__:__'
																													then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																											else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																									end
																								)
																						from 		"Presensi".tdatapresensi as datapres
																						where 		datapres.noind=tshiftpekerja.noind
																									and 	datapres.tanggal=tshiftpekerja.tanggal
																									and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																									and 	(
																												case 	when 	datapres.masuk=''
																																or 	datapres.masuk='0'
																																or 	datapres.masuk='__:__:__'
																																then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																														else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																												end
																											)
																											>
																											tshiftpekerja.jam_plg_shift_sebelum
																									and 	(
																												case	when 	datapres.keluar=''
																																or 	datapres.keluar='0'
																																or 	datapres.keluar='__:__:__'
																																then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																														else 	(
																																	case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																					<
																																					(
																																						case 	when 	datapres.masuk=''
																																										or 	datapres.masuk='0'
																																										or 	datapres.masuk='__:__:__'
																																										then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																								else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																						end
																																					)
																																					then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																			else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																	end			
																																)
																												end
																											)
																											<
																											tshiftpekerja.jam_msk_shift_sesudah
																					)
																	else 	(
																				case 	when 	(
																									tshiftpekerja.tanggal
																									=
																									(
																										select		max(shiftpkj.tanggal)
																										from 		"Presensi".tshiftpekerja as shiftpkj
																										where	 	shiftpkj.noind=tshiftpekerja.noind
																									)
																									or 	tshiftpekerja.tanggal
																										=
																										(
																											select		min(shiftpkj.tanggal)
																											from 		"Presensi".tshiftpekerja as shiftpkj
																											where	 	shiftpkj.noind=tshiftpekerja.noind
																										)
																								)
																								and		(
																											select		count(datapres.noind)
																											from 		"Presensi".tdatapresensi as datapres
																											where 		datapres.tanggal=tshiftpekerja.tanggal
																														and		datapres.noind=tshiftpekerja.noind
																														and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																										)
																										>
																										0
																								then 	(
																											select 	(
																														case 	when 	datapres.masuk=''
																																		or 	datapres.masuk='0'
																																		or 	datapres.masuk='__:__:__'
																																		then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																														end
																													)
																											from 		"Presensi".tdatapresensi as datapres
																											where 		datapres.noind=tshiftpekerja.noind
																														and 	datapres.tanggal=tshiftpekerja.tanggal
																														and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																										)
																				end
																			)
															end
														)
								end
							) as kerja_mulai,
							(
								case	when 	tshiftpekerja.masuk=true
												then 	(
															case 	when 	(
																				select 		count(*)
																				from 		"Presensi".tdatapresensi as datapres
																				where 		datapres.noind=tshiftpekerja.noind
																							and 	datapres.tanggal=tshiftpekerja.tanggal
																							and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																							and 	(
																										case 	when 	datapres.masuk=''
																														or 	datapres.masuk='0'
																														or 	datapres.masuk='__:__:__'
																														then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																												else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																										end
																									)
																									>
																									tshiftpekerja.jam_plg_shift_sebelum
																							and 	(
																										case	when 	datapres.keluar=''
																														or 	datapres.keluar='0'
																														or 	datapres.keluar='__:__:__'
																														then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																												else 	(
																															case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																			<
																																			(
																																				case 	when 	datapres.masuk=''
																																								or 	datapres.masuk='0'
																																								or 	datapres.masuk='__:__:__'
																																								then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																						else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																				end
																																			)
																																			then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																															end			
																														)
																										end
																									)
																									<
																									tshiftpekerja.jam_msk_shift_sesudah
																			)
																			>
																			0
																			then 	(
																						select 		(
																										case	when 	datapres.keluar=''
																														or 	datapres.keluar='0'
																														or 	datapres.keluar='__:__:__'
																														then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																												else 	(
																															case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																			<
																																			(
																																				case 	when 	datapres.masuk=''
																																								or 	datapres.masuk='0'
																																								or 	datapres.masuk='__:__:__'
																																								then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																						else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																				end
																																			)
																																			then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																	else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																															end			
																														)
																										end
																									)
																						from 		"Presensi".tdatapresensi as datapres
																						where 		datapres.noind=tshiftpekerja.noind
																									and 	datapres.tanggal=tshiftpekerja.tanggal
																									and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																									and 	(
																												case 	when 	datapres.masuk=''
																																or 	datapres.masuk='0'
																																or 	datapres.masuk='__:__:__'
																																then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																														else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																												end
																											)
																											>
																											tshiftpekerja.jam_plg_shift_sebelum
																									and 	(
																												case	when 	datapres.keluar=''
																																or 	datapres.keluar='0'
																																or 	datapres.keluar='__:__:__'
																																then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																														else 	(
																																	case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																					<
																																					(
																																						case 	when 	datapres.masuk=''
																																										or 	datapres.masuk='0'
																																										or 	datapres.masuk='__:__:__'
																																										then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																								else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																						end
																																					)
																																					then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																			else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																	end			
																																)
																												end
																											)
																											<
																											tshiftpekerja.jam_msk_shift_sesudah
																					)
																	else 	(
																				case 	when 	(
																									tshiftpekerja.tanggal
																									=
																									(
																										select		max(shiftpkj.tanggal)
																										from 		"Presensi".tshiftpekerja as shiftpkj
																										where	 	shiftpkj.noind=tshiftpekerja.noind
																									)
																									or 	tshiftpekerja.tanggal
																										=
																										(
																											select		min(shiftpkj.tanggal)
																											from 		"Presensi".tshiftpekerja as shiftpkj
																											where	 	shiftpkj.noind=tshiftpekerja.noind
																										)
																								)
																								and		(
																											select		count(datapres.noind)
																											from 		"Presensi".tdatapresensi as datapres
																											where 		datapres.tanggal=tshiftpekerja.tanggal
																														and		datapres.noind=tshiftpekerja.noind
																														and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																										)
																										>
																										0
																								then 	(
																											select 	(
																														case	when 	datapres.keluar=''
																																		or 	datapres.keluar='0'
																																		or 	datapres.keluar='__:__:__'
																																		then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																																else 	(
																																			case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																							<
																																							(
																																								case 	when 	datapres.masuk=''
																																												or 	datapres.masuk='0'
																																												or 	datapres.masuk='__:__:__'
																																												then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																										else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																								end
																																							)
																																							then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																					else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																			end			
																																		)
																														end
																													)
																											from 		"Presensi".tdatapresensi as datapres
																											where 		datapres.noind=tshiftpekerja.noind
																														and 	datapres.tanggal=tshiftpekerja.tanggal
																														and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																										)
																				end
																			)
															end
														)
								end
							) as kerja_selesai,
							(
								case  	when 	(
													select 		count(*)
													from 		"Presensi".tdatatim as tim
													where 		tim.tanggal=tshiftpekerja.tanggal
																and 	tim.noind=tshiftpekerja.noind
																and 	tim.kd_ket='TIK'
																and 	(
																			case 	when 	tim.kd_ket='TIK'
																							then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																					when 	tim.kd_ket='TM'
																							then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																					when 	tim.kd_ket='TT'
																							then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																			end
																		) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
												)>0
												then 	(
															select		coalesce(sum(ikp.waktu_ikp), 0)
															from 		(
																			select		abs
																						(
																							case 	when 	tshiftpekerja.ist_mulai>tshiftpekerja.break_mulai
																											then 	(
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
																													)
																									else 	(
																												case 	when 	tim.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.ist_mulai - interval '1 second')
																																then	(
																																					--	1:2
																																			case	when 	tim.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.ist_mulai - interval '1 second')
																																							then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																					-- 	1:3
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
																																					-- 	1:4
																																					when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and (tshiftpekerja.break_mulai - interval '1 second')
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
																																					-- 	1:5
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
																																											-
																																											(
																																												tshiftpekerja.ist_selesai
																																												-
																																												tshiftpekerja.ist_mulai
																																											)
																																										)
																																									)
																																					-- 	1:6
																																					when	tim.masuk 	between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
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
																														when 	tim.keluar 	between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																then	(
																																					--	2:3
																																			case 	when	tim.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																							then 	0
																																					--	2:4
																																					when 	tim.masuk between 	tshiftpekerja.ist_selesai and (tshiftpekerja.break_mulai - interval '1 second')
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
																																					-- 	2:5
																																					when 	tim.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
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
																																											-
																																											(
																																												tshiftpekerja.ist_selesai
																																												-
																																												tim.keluar
																																											)
																																										)
																																									)
																																					--	2:6
																																					when 	tim.masuk between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
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
																														when 	tim.keluar 	between 	tshiftpekerja.ist_selesai and (tshiftpekerja.break_mulai - interval '1 second')
																																then	(
																																					-- 	3:4
																																			case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and (tshiftpekerja.break_mulai - interval '1 second')
																																							then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																					--	3:5
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
																																					-- 	3:6
																																					when 	tim.masuk 	between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
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
																																			end
																																		)
																														when 	tim.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																then 	(
																																					--	4:5
																																			case 	when 	tim.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																							then 	0
																																					--	4:6
																																					when 	tim.masuk 	between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
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
																																			end
																																		)
																														when 	tim.keluar 	between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
																																then 	(
																																					-- 	5:6
																																			case 	when 	tim.masuk 	between 	tshiftpekerja.ist_selesai and tshiftpekerja.jam_plg
																																							then 	extract(epoch from (tim.masuk-tim.keluar))::numeric
																																			end
																																		)
																														else 	0
																												end
																											)
																							end			
																						) as waktu_ikp
																			from 		(
																							select 		tim.tanggal::date as tanggal,
																										(tim.noind) as noind,
																										(tim.kodesie) as kodesie,
																										(tim.kd_ket) as kd_ket,
																										tim.point,
																										(
																											case 	when 	tim.kd_ket='TIK'
																															then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																													when 	tim.kd_ket='TM'
																															then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
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
																															then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																													when 	tim.kd_ket='TT'
																															then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																											end
																										) as masuk
																							from 		"Presensi".tdatatim as tim
																							where 		tim.tanggal=tshiftpekerja.tanggal
																										and 	tim.noind=tshiftpekerja.noind
																										and 	tim.kd_ket='TIK'
																						) tim
																			where 		tim.keluar between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																		) as ikp
														)
										else 	0
								end			
							) as pengurang_ikp_dalam_shift,
							(
								case 	when 	(
													select 		count(*)
													from 		"Presensi".tdatapresensi as datapres
													where		datapres.kd_ket='PSP'
																and 	datapres.tanggal=tshiftpekerja.tanggal
																and 	datapres.noind=tshiftpekerja.noind
																and 	(
																			case 	when 	datapres.keluar=''
																							or 	datapres.keluar='0'
																							or 	datapres.keluar='__:__:__'
																							then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																					else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																			end
																		) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
												)>0
												then 	(
															select 		coalesce(sum(psp.waktu_psp), 0)
															from 		(
																			select 		abs
																						(
																							case 	when 	tshiftpekerja.ist_mulai>tshiftpekerja.break_mulai
																											then 	(
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
																													)
																									else 	(
																												case 	when 	datapres.keluar 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.ist_mulai - interval '1 second')
																																then	(
																																					--	1:2
																																			case	when 	datapres.masuk 	between 	tshiftpekerja.jam_msk and (tshiftpekerja.ist_mulai - interval '1 second')
																																							then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																					-- 	1:3
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
																																					-- 	1:4
																																					when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and (tshiftpekerja.break_mulai - interval '1 second')
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
																																					-- 	1:5
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
																																												tshiftpekerja.break_selesai
																																											)
																																											-
																																											(
																																												tshiftpekerja.ist_selesai
																																												-
																																												tshiftpekerja.ist_mulai
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
																																												tshiftpekerja.break_selesai
																																												-
																																												tshiftpekerja.break_mulai
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
																																then	(
																																					--	2:3
																																			case 	when	datapres.masuk between 	tshiftpekerja.ist_mulai and (tshiftpekerja.ist_selesai - interval '1 second')
																																							then 	0
																																					--	2:4
																																					when 	datapres.masuk between 	tshiftpekerja.ist_selesai and (tshiftpekerja.break_mulai - interval '1 second')
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
																																					-- 	2:5
																																					when 	datapres.masuk between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
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
																																											-
																																											(
																																												tshiftpekerja.ist_selesai
																																												-
																																												datapres.keluar
																																											)
																																										)
																																									)
																																					--	2:6
																																					when 	datapres.masuk between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
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
																														when 	datapres.keluar 	between 	tshiftpekerja.ist_selesai and (tshiftpekerja.break_mulai - interval '1 second')
																																then	(
																																					-- 	3:4
																																			case 	when 	datapres.masuk 	between 	tshiftpekerja.ist_selesai and (tshiftpekerja.break_mulai - interval '1 second')
																																							then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																					--	3:5
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
																																												tshiftpekerja.break_selesai
																																												-
																																												tshiftpekerja.break_mulai
																																											)
																																										)
																																									)
																																			end
																																		)
																														when 	datapres.keluar 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																then 	(
																																					--	4:5
																																			case 	when 	datapres.masuk 	between 	tshiftpekerja.break_mulai and (tshiftpekerja.break_selesai - interval '1 second')
																																							then 	0
																																					--	4:6
																																					when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
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
																																			end
																																		)
																														when 	datapres.keluar 	between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
																																then 	(
																																					-- 	5:6
																																			case 	when 	datapres.masuk 	between 	tshiftpekerja.break_selesai and tshiftpekerja.jam_plg
																																							then 	extract(epoch from (datapres.masuk-datapres.keluar))::numeric
																																			end
																																		)
																														else 	0
																												end
																											)
																							end	
																						) as waktu_psp
																			from 		(
																							select 		datapres.tanggal::date as tanggal,
																										(datapres.noind) as noind,
																										(datapres.kodesie) as kodesie,
																										(datapres.kd_ket) as kd_ket,
																										(
																											case 	when 	datapres.keluar=''
																															or 	datapres.keluar='0'
																															or 	datapres.keluar='__:__:__'
																															then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																													else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																											end
																										) as keluar,
																										(
																											case	when 	datapres.masuk=''
																															or 	datapres.masuk='0'
																															or 	datapres.masuk='__:__:__'
																															then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																													else 	(
																																case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																				<
																																				(
																																					case 	when 	datapres.keluar=''
																																									or 	datapres.keluar='0'
																																									or 	datapres.keluar='__:__:__'
																																									then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
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
																										(datapres.ket) as ket
																							from 		"Presensi".tdatapresensi as datapres
																							where 		datapres.kd_ket='PSP'
																										and 	datapres.tanggal::date=tshiftpekerja.tanggal
																										and 	datapres.noind=tshiftpekerja.noind
																						) as datapres
																			where 		datapres.keluar between 	tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																		) as psp
														)
										else 	0
								end
							) as pengurang_psp,
							(
								case 	when 	tshiftpekerja.masuk=true
												then 	(
															case  	when 	(
																				select 		count(*)
																				from 		"Presensi".tdatatim as tim
																				where 		tim.tanggal=tshiftpekerja.tanggal
																							and 	tim.noind=tshiftpekerja.noind
																							and 	tim.kd_ket='TT'
																							and 	(
																										case 	when 	tim.kd_ket='TIK'
																														then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																												when 	tim.kd_ket='TM'
																														then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																												when 	tim.kd_ket='TT'
																														then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																										end
																									) between tshiftpekerja.jam_msk and tshiftpekerja.jam_plg
																			)
																			>
																			0
																			then 	(
																						select		coalesce(sum(tim.waktu_tt), 0)
																						from 		(
																										select 		abs
																													(
																														extract
																														(
																															epoch
																															from
																															(
																																tim.masuk
																																-
																																tim.keluar
																															)
																														)::numeric
																													) as waktu_tt
																										from 		(
																														select 		tim.tanggal::date as tanggal,
																																	(tim.noind) as noind,
																																	(tim.kodesie) as kodesie,
																																	(tim.kd_ket) as kd_ket,
																																	tim.point,
																																	(
																																		case 	when 	tim.kd_ket='TIK'
																																						then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																				when 	tim.kd_ket='TM'
																																						then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
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
																																						then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																				when 	tim.kd_ket='TT'
																																						then 	to_timestamp(concat_ws(' ', tim.tanggal::date, tim.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																		end
																																	) as masuk
																														from 		"Presensi".tdatatim as tim
																														where 		tim.tanggal=tshiftpekerja.tanggal
																																	and 	tim.noind=tshiftpekerja.noind
																																	and 	tim.kd_ket='TT'
																													) tim
																									) as tim
																					)
																	else 	0
															end
														)
										else 	0
								end
							) as terlambat,
							(
								case 	when 	tshiftpekerja.masuk=true
												then 	(
															select 	coalesce(sum(datapres.total_lembur), 0)
															from 	"Presensi".tdatapresensi as datapres
															where 	datapres.noind=tshiftpekerja.noind
																	and 	datapres.tanggal=tshiftpekerja.tanggal
																	and 	(datapres.kd_ket)='PLB'
																	and 	(
																				case 	when 	datapres.masuk=''
																								or 	datapres.masuk='0'
																								or 	datapres.masuk='__:__:__'
																								then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																						else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																				end
																			)
																			>
																			tshiftpekerja.jam_plg_shift_sebelum
																	and 	(
																				case	when 	datapres.keluar=''
																								or 	datapres.keluar='0'
																								or 	datapres.keluar='__:__:__'
																								then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																						else 	(
																									case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																													<
																													(
																														case 	when 	datapres.masuk=''
																																		or 	datapres.masuk='0'
																																		or 	datapres.masuk='__:__:__'
																																		then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																														end
																													)
																													then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																											else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																									end			
																								)
																				end
																			)
																			<
																			tshiftpekerja.jam_msk_shift_sesudah
														)
										else 	0
								end
							) as total_lembur
				from 		(
								select 		tshiftpekerja.*,
											(
												case 	when 	(
																	select 		count(*)
																	from 		"Presensi".tdatapresensi as datapres
																	where 		datapres.noind=tshiftpekerja.noind
																				and 	datapres.tanggal=tshiftpekerja.tanggal
																				and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																				and 	(
																							case 	when 	datapres.masuk=''
																											or 	datapres.masuk='0'
																											or 	datapres.masuk='__:__:__'
																											then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																									else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																							end
																						)
																						>
																						tshiftpekerja.jam_plg_shift_sebelum
																				and 	(
																							case	when 	datapres.keluar=''
																											or 	datapres.keluar='0'
																											or 	datapres.keluar='__:__:__'
																											then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																									else 	(
																												case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																																<
																																(
																																	case 	when 	datapres.masuk=''
																																					or 	datapres.masuk='0'
																																					or 	datapres.masuk='__:__:__'
																																					then 	to_timestamp(concat_ws(' ', datapres.tanggal::date, tshiftpekerja.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																																			else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																																	end
																																)
																																then 	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																														else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																												end			
																											)
																							end
																						)
																						<
																						tshiftpekerja.jam_msk_shift_sesudah
																)
																>
																0
																then 	true
														else 	(
																	case 	when 	(
																						tshiftpekerja.tanggal
																						=
																						(
																							select		max(shiftpkj.tanggal)
																							from 		"Presensi".tshiftpekerja as shiftpkj
																							where	 	shiftpkj.noind=tshiftpekerja.noind
																						)
																						or 	tshiftpekerja.tanggal
																							=
																							(
																								select		min(shiftpkj.tanggal)
																								from 		"Presensi".tshiftpekerja as shiftpkj
																								where	 	shiftpkj.noind=tshiftpekerja.noind
																							)
																					)
																					and		(
																								select		count(datapres.noind)
																								from 		"Presensi".tdatapresensi as datapres
																								where 		datapres.tanggal=tshiftpekerja.tanggal
																											and		datapres.noind=tshiftpekerja.noind
																											and 	(datapres.kd_ket) in ('PKJ', 'PLB', 'PDB', 'PDL', 'PID', 'HL')
																							)
																							>
																							0
																					then 	true
																			else 	false
																	end
																)
												end
											) as masuk
								from 		(
												select 		tshiftpekerja.*,
															(
																coalesce
																(
																	(
																		select 		to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																		from 		"Presensi".tshiftpekerja as sftpkj
																		where  		(sftpkj.noind)=tshiftpekerja.noind
																		 			and  	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																		 					<
																		 					tshiftpekerja.jam_msk
																		 			and 	sftpkj.tanggal between (tshiftpekerja.tanggal - interval '2 week') and (tshiftpekerja.tanggal) 
																		 order by 	sftpkj.tanggal desc
																		 limit  	1
																	),
																	(tshiftpekerja.jam_msk)
																)
															) as jam_plg_shift_sebelum,
															(
																select 		to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																from 		"Presensi".tshiftpekerja as sftpkj
																where  		(sftpkj.noind)=tshiftpekerja.noind
																		 	and  	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																		 			>
																		 			tshiftpekerja.jam_plg
																			and 	sftpkj.tanggal between (tshiftpekerja.tanggal) and (tshiftpekerja.tanggal + interval '2 week')				 			
																order by 	sftpkj.tanggal asc
																limit  	1
															) as jam_msk_shift_sesudah
												from 		(
																select 		sftpkj.tanggal::date as tanggal,
																			(sftpkj.noind) as noind,
																			(pri.noind_baru) as noind_baru,
																			(sftpkj.kd_shift) as kd_shift,
																			(
																				case 	when 	(
																									select 		count(*)
																									from 		hrd_khs.tmutasi as tmutasi
																									where 		tmutasi.noind=pri.noind
																								)
																								>
																								0
																								then 	(
																											case 	when 	sftpkj.tanggal
																															<
																															(
																																select 		tglberlaku 
																											           			from 		hrd_khs.tmutasi 
																											           			where  		noind=pri.noind
																											           			order by 	tglberlaku asc 
																											           			limit 		1
																															)
																															then	(
																																		select 		kodesielm 
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku asc 
																											             				limit 		1
																																	)
																													when 	sftpkj.tanggal
																															<
																															(
																																select 		tglberlaku 
																											             		from 		hrd_khs.tmutasi 
																											             		where  		noind=pri.noind
																											             		order by 	tglberlaku desc 
																											             		limit 		1
																															)
																															then	(
																																		select 		kodesielm
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku desc 
																											             				limit 		1
																																	)
																													else 	sftpkj.kodesie
																											end
																										)
																						else 	sftpkj.kodesie
																				end
																			) as kodesie,
																			(
																				case 	when 	(
																									select 		count(*)
																									from 		hrd_khs.tmutasi as tmutasi
																									where 		tmutasi.noind=pri.noind
																								)
																								>
																								0
																								then 	(
																											case 	when 	sftpkj.tanggal
																															<
																															(
																																select 		tglberlaku 
																											           			from 		hrd_khs.tmutasi 
																											           			where  		noind=pri.noind
																											           						and 	(
																											           									lokasilm is not null
																											           									and 	lokasibr is not null
																											           								)
																											           			order by 	tglberlaku asc 
																											           			limit 		1
																															)
																															then	(
																																		select 		lokasilm 
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku asc 
																											             				limit 		1
																																	)
																													when 	sftpkj.tanggal
																															<
																															(
																																select 		tglberlaku 
																											             		from 		hrd_khs.tmutasi 
																											             		where  		noind=pri.noind
																											             					and 	(
																											           									lokasilm is not null
																											           									and 	lokasibr is not null
																											           								)
																											             		order by 	tglberlaku desc 
																											             		limit 		1
																															)
																															then	(
																																		select 		lokasilm
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku desc 
																											             				limit 		1
																																	)
																													else 	(
																																select 		lokasi_kerja
																																from 		hrd_khs.tpribadi
																																where 		noind=pri.noind
																															)
																											end
																										)
																						else 	(
																									select 		lokasi_kerja
																									from 		hrd_khs.tpribadi
																									where 		noind=pri.noind
																								)
																				end					
																			) as lokasi_kerja,
																			(
																				case 	when 	(
																									select 		count(*)
																									from 		hrd_khs.tmutasi as tmutasi
																									where 		tmutasi.noind=pri.noind
																								)
																								>
																								0
																								then 	(
																											case 	when 	sftpkj.tanggal
																															<
																															(
																																select 		tglberlaku 
																											           			from 		hrd_khs.tmutasi 
																											           			where  		noind=pri.noind
																											           			order by 	tglberlaku asc 
																											           			limit 		1
																															)
																															then	(
																																		select 		kd_jabatanlm 
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku asc 
																											             				limit 		1
																																	)
																													when 	sftpkj.tanggal
																															<
																															(
																																select 		tglberlaku 
																											             		from 		hrd_khs.tmutasi 
																											             		where  		noind=pri.noind
																											             		order by 	tglberlaku desc 
																											             		limit 		1
																															)
																															then	(
																																		select 		kd_jabatanlm
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku desc 
																											             				limit 		1
																																	)
																													else 	(pri.kd_jabatan)
																											end
																										)
																						else 	(pri.kd_jabatan)
																				end
																			) as kd_jabatan,
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
																									then	to_timestamp(concat_ws(' ', (sftpkj.tanggal + interval '1 day')::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																							else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_plg::time), 'YYYY-MM-DD HH24:MI:SS')
																					end
																				)
																			) as jam_plg,
																			(
																				case 	when 	pri.kode_status_kerja='M'
																								then 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																						else	(
																									case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																													<
																													to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																													then	to_timestamp(concat_ws(' ', (sftpkj.tanggal + interval '1 day')::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																											else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_mulai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																									end
																								)
																				end
																			) as break_mulai,
																			(
																				case 	when 	pri.kode_status_kerja='M'
																								then 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																						else 	(
																									case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																													<
																													to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																													then	to_timestamp(concat_ws(' ', (sftpkj.tanggal + interval '1 day')::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																											else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, replace(sftpkj.break_selesai, '_', '0')::time), 'YYYY-MM-DD HH24:MI:SS')
																									end
																								)
																				end
																			) as break_selesai,
																			(
																				case 	when 	pri.kode_status_kerja='M'
																								then 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																						else 	(
																									case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																													<
																													to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																													then	to_timestamp(concat_ws(' ', (sftpkj.tanggal + interval '1 day')::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																											else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_mulai::time), 'YYYY-MM-DD HH24:MI:SS')
																									end
																								)
																				end
																			) as ist_mulai,
																			(
																				case 	when 	pri.kode_status_kerja='M'
																								then 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																						else 	(
																									case 	when 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																													<
																													to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.jam_msk::time), 'YYYY-MM-DD HH24:MI:SS')
																													then	to_timestamp(concat_ws(' ', (sftpkj.tanggal + interval '1 day')::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																											else 	to_timestamp(concat_ws(' ', sftpkj.tanggal::date, sftpkj.ist_selesai::time), 'YYYY-MM-DD HH24:MI:SS')
																									end
																								)
																				end
																			) as ist_selesai
																from 		"Presensi".tshiftpekerja as sftpkj
																			join 	hrd_khs.v_hrd_khs_tpribadi as pri
																					on 	pri.noind=sftpkj.noind
																union
																select 		datapres.tanggal::date as tanggal,
																			datapres.noind as noind,
																			datapres.noind_baru as noind_baru,
																			(
																				select 		sftpkj.kd_shift
																				from 		"Presensi".tshiftpekerja as sftpkj
																				where 		sftpkj.noind=datapres.noind
																							and 	sftpkj.tanggal between (datapres.tanggal::date - interval '2 week') and (datapres.tanggal::date)
																				order by 	sftpkj.tanggal desc
																				limit 		1
																			) as kd_shift,
																			(
																				case 	when 	(
																									select 		count(*)
																									from 		hrd_khs.tmutasi as tmutasi
																									where 		tmutasi.noind=pri.noind
																								)
																								>
																								0
																								then 	(
																											case 	when 	datapres.tanggal
																															<
																															(
																																select 		tglberlaku 
																											           			from 		hrd_khs.tmutasi 
																											           			where  		noind=pri.noind
																											           			order by 	tglberlaku asc 
																											           			limit 		1
																															)
																															then	(
																																		select 		kodesielm 
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku asc 
																											             				limit 		1
																																	)
																													when 	datapres.tanggal
																															<
																															(
																																select 		tglberlaku 
																											             		from 		hrd_khs.tmutasi 
																											             		where  		noind=pri.noind
																											             		order by 	tglberlaku desc 
																											             		limit 		1
																															)
																															then	(
																																		select 		kodesielm
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku desc 
																											             				limit 		1
																																	)
																													else 	datapres.kodesie
																											end
																										)
																						else 	datapres.kodesie
																				end
																			) as kodesie,
																			(
																				case 	when 	(
																									select 		count(*)
																									from 		hrd_khs.tmutasi as tmutasi
																									where 		tmutasi.noind=pri.noind
																								)
																								>
																								0
																								then 	(
																											case 	when 	datapres.tanggal
																															<
																															(
																																select 		tglberlaku 
																											           			from 		hrd_khs.tmutasi 
																											           			where  		noind=pri.noind
																											           						and 	(
																											           									lokasilm is not null
																											           									and 	lokasibr is not null
																											           								)
																											           			order by 	tglberlaku asc 
																											           			limit 		1
																															)
																															then	(
																																		select 		lokasilm 
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku asc 
																											             				limit 		1
																																	)
																													when 	datapres.tanggal
																															<
																															(
																																select 		tglberlaku 
																											             		from 		hrd_khs.tmutasi 
																											             		where  		noind=pri.noind
																											             					and 	(
																											           									lokasilm is not null
																											           									and 	lokasibr is not null
																											           								)
																											             		order by 	tglberlaku desc 
																											             		limit 		1
																															)
																															then	(
																																		select 		lokasilm
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku desc 
																											             				limit 		1
																																	)
																													else 	(
																																select 		lokasi_kerja
																																from 		hrd_khs.tpribadi
																																where 		noind=pri.noind
																															)
																											end
																										)
																						else 	(
																									select 		lokasi_kerja
																									from 		hrd_khs.tpribadi
																									where 		noind=pri.noind
																								)
																				end					
																			) as lokasi_kerja,
																			(
																				case 	when 	(
																									select 		count(*)
																									from 		hrd_khs.tmutasi as tmutasi
																									where 		tmutasi.noind=pri.noind
																								)
																								>
																								0
																								then 	(
																											case 	when 	datapres.tanggal
																															<
																															(
																																select 		tglberlaku 
																											           			from 		hrd_khs.tmutasi 
																											           			where  		noind=pri.noind
																											           			order by 	tglberlaku asc 
																											           			limit 		1
																															)
																															then	(
																																		select 		kd_jabatanlm 
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku asc 
																											             				limit 		1
																																	)
																													when 	datapres.tanggal
																															<
																															(
																																select 		tglberlaku 
																											             		from 		hrd_khs.tmutasi 
																											             		where  		noind=pri.noind
																											             		order by 	tglberlaku desc 
																											             		limit 		1
																															)
																															then	(
																																		select 		kd_jabatanlm
																											             				from 		hrd_khs.tmutasi 
																											             				where  		noind=pri.noind 
																											             				order by 	tglberlaku desc 
																											             				limit 		1
																																	)
																													else 	(pri.kd_jabatan)
																											end
																										)
																						else 	(pri.kd_jabatan)
																				end
																			) as kd_jabatan,
																			'0'::numeric as tukar,
																			(
																				to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																			) as jam_msk,
																			(
																				to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																			) as jam_akhmsk,
																			(
																				(
																					case 	when 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																									<
																									to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																									then	to_timestamp(concat_ws(' ', (datapres.tanggal + interval '1 day')::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																							else 	to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.keluar::time), 'YYYY-MM-DD HH24:MI:SS')
																					end
																				)
																			) as jam_plg,
																			(
																				to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																			) as break_mulai,
																			(
																				to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																			) as break_selesai,
																			(
																				to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																			) as ist_mulai,
																			(
																				to_timestamp(concat_ws(' ', datapres.tanggal::date, datapres.masuk::time), 'YYYY-MM-DD HH24:MI:SS')
																			) as ist_selesai
																from 		"Presensi".tdatapresensi as datapres
																			join 	hrd_khs.v_hrd_khs_tpribadi as pri
																					on 	pri.noind=datapres.noind
																where 		datapres.kd_ket='HL'
																order by 	tanggal,
																			lokasi_kerja,
																			kodesie,
																			kd_jabatan,
																			noind,
																			kd_shift

															) as tshiftpekerja
												where 		tshiftpekerja.tanggal between :tgl1 and :tgl2
															:kode_status_kerja
															:noind
															:kode_shift
															:kodesie
															:lokasi_kerja
															:kode_jabatan
											) as tshiftpekerja
							) as tshiftpekerja
			) as tshiftpekerja