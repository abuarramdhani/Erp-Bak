<?php
class M_penilaiankinerja extends CI_Model 
{

	public $master = 'pk.pk_unit_group';
	public $table = 'pk.pk_unit_group_list';
	public $assesment = 'pk.pk_assessment';
	public $hrd = 'hrd_khs.tpribadi';
	    public function __construct()
	    {
	        parent::__construct();
	    }
			
	// ADD MASTER PENILAIAN KINERJA
	public function load_unit_group()
	{
		return $this->db->get($this->table)->result_array();	
	}

	public function get_worker($st,$end)
	{
		$personalia = $this->load->database("personalia",true);
		$query 		= "	select 	trim(a.noind) as noind,
								rtrim(a.nama) as nama,
								trim(a.kodesie) as kodesie,
								trim(a.golkerja) as golkerja,
								trim(a.lokasi_kerja) as lokerja,
								rtrim(seksi.dept) as dept,
								rtrim(seksi.bidang) as bidang,
								rtrim(seksi.unit) as unit,
								rtrim(seksi.seksi) as seksi,
								coalesce
								(
									(
										(
											select 	coalesce(sum(round(b.point::numeric, 1)), 0)
											from 	\"Presensi\".tdatatim b 
											where 	b.noind=a.noind
													and 	b.tanggal between '$st' and '$end'
										)
										-
										(
											select 	coalesce(sum(round(spabsen.bobot::numeric, 1)), 0)
											from 	\"Surat\".tsp as spabsen 
											where 	spabsen.noind=a.noind
													and 	(to_date(concat_ws('-', substring(spabsen.bulan,1,4), substring(spabsen.bulan,5,2)), 'YYYY-MM') - interval '1 month') between '$st' and ('$st'::date + interval '11 month' - interval '1 day')::date
										)
									)
								,0) point,
								/*
								(
									select 	coalesce(sum(tabelsp.sp_ke), 0)
									from 	(
												select 		sum(spabsen.sp_ke::int) as sp_ke
												from 		\"Surat\".tsp as spabsen
												where 		(to_date(concat_ws('-', substring(spabsen.bulan,1,4), substring(spabsen.bulan,5,2)), 'YYYY-MM')) between '$st' and '$end'
															and 	spabsen.noind=a.noind
												union
												select 		sum(spnonabsen.sp_ke::int) as sp_ke
												from 		\"Surat\".tsp_nonabsen as spnonabsen
												where  		(to_date(concat_ws('-', substring(spnonabsen.bulan,1,4), substring(spnonabsen.bulan,5,2)), 'YYYY-MM')) between '$st' and '$end'
															and 	spnonabsen.noind=a.noind
												union
												select 		sum(sppres.sp_ke::int) as sp_ke
												from 		\"Surat\".tsp_prestasi as sppres
												where 		(to_date(concat_ws('-', substring(sppres.bulan,1,4), substring(sppres.bulan,5,2)), 'YYYY-MM')) between '$st' and '$end'
																and 	sppres.noind=a.noind
											) as tabelsp
								) sp,
								*/
								(
									select		coalesce(sum(tabelsp.sp_ke::int), 0) as jumlah_sp
									--select 		tabelsp.*
									from		(
													select		tabelmaster.*,
																(
																	case 	when 	(
																						select 		count(*)
																						from 		(
																										select 		spabsen.no_surat,
																													spabsen.noind,
																													spabsen.bulan,
																													spabsen.berlaku,
																													spabsen.sp_ke,
																													'Absensi' as jenis,
																													spabsen.tanggal_awal_berlaku as tanggal_awal_berlaku,
																													spabsen.tanggal_akhir_berlaku as tanggal_akhir_berlaku,
																													spabsen.sp_sebelum
																										from 		(
																														select 		*,
																																	to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																																	(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																														from 		\"Surat\".tsp
																													) as spabsen
																										union
																										select 		spnonabsen.no_surat,
																													spnonabsen.noind,
																													spnonabsen.bulan,
																													spnonabsen.berlaku,
																													spnonabsen.sp_ke,
																													'Non Absensi' as jenis,
																													spnonabsen.tanggal_awal_berlaku as tanggal_awal_berlaku,
																													spnonabsen.tanggal_akhir_berlaku as tanggal_akhir_berlaku,
																													spnonabsen.sp_sebelum
																										from 		(
																														select 		*,
																																	to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																																	(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																														from		\"Surat\".tsp_nonabsen
																													) as spnonabsen
																										union
																										select 		sppres.no_surat,
																													sppres.noind,
																													sppres.bulan,
																													sppres.berlaku,
																													sppres.sp_ke,
																													'Bawah Prestasi' as jenis,
																													sppres.tanggal_awal_berlaku as tanggal_awal_berlaku,
																													sppres.tanggal_akhir_berlaku as tanggal_akhir_berlaku,
																													sppres.sp_sebelum
																										from 		(
																														select		*,
																																	to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																																	(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																														from		\"Surat\".tsp_prestasi as sppres
																													) as sppres
																										order by 	noind,
																													sp_ke,
																													tanggal_awal_berlaku
																									) as sp
																						where 		rtrim(sp.sp_sebelum)=concat_ws('/', rtrim(tabelmaster.no_surat), substring(tabelmaster.bulan, 5, 2), substring(tabelmaster.bulan, 1, 4), rtrim(tabelmaster.sp_ke))
																									and 	sp.tanggal_awal_berlaku<'$end'
																					)>0	
																					then 	(
																								case	when 	(
																													select 		count(*)
																													from 		(
																																	select 		spabsen.no_surat,
																																				spabsen.noind,
																																				spabsen.bulan,
																																				spabsen.berlaku,
																																				spabsen.sp_ke,
																																				'Absensi' as jenis,
																																				spabsen.tanggal_awal_berlaku as tanggal_awal_berlaku,
																																				spabsen.tanggal_akhir_berlaku as tanggal_akhir_berlaku,
																																				spabsen.sp_sebelum
																																	from 		(
																																					select 		*,
																																								to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																																								(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																																					from 		\"Surat\".tsp
																																				) as spabsen
																																	union
																																	select 		spnonabsen.no_surat,
																																				spnonabsen.noind,
																																				spnonabsen.bulan,
																																				spnonabsen.berlaku,
																																				spnonabsen.sp_ke,
																																				'Non Absensi' as jenis,
																																				spnonabsen.tanggal_awal_berlaku as tanggal_awal_berlaku,
																																				spnonabsen.tanggal_akhir_berlaku as tanggal_akhir_berlaku,
																																				spnonabsen.sp_sebelum
																																	from 		(
																																					select 		*,
																																								to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																																								(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																																					from		\"Surat\".tsp_nonabsen
																																				) as spnonabsen
																																	union
																																	select 		sppres.no_surat,
																																				sppres.noind,
																																				sppres.bulan,
																																				sppres.berlaku,
																																				sppres.sp_ke,
																																				'Bawah Prestasi' as jenis,
																																				sppres.tanggal_awal_berlaku as tanggal_awal_berlaku,
																																				sppres.tanggal_akhir_berlaku as tanggal_akhir_berlaku,
																																				sppres.sp_sebelum
																																	from 		(
																																					select		*,
																																								to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																																								(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																																					from		\"Surat\".tsp_prestasi as sppres
																																				) as sppres
																																	order by 	noind,
																																				sp_ke,
																																				tanggal_awal_berlaku
																																) as sp2
																													where 		sp2.tanggal_awal_berlaku>=tabelmaster.tanggal_awal_berlaku
																																and 	sp2.tanggal_awal_berlaku<'$end'
																																and 	sp2.sp_ke>tabelmaster.sp_ke
																												)>0
																												then 	'NEXT'
																										else 	'STOP'
																								end
																							)
																			else 	'STOP'
																	end
																) as lanjutan
													from 		(
																	select 		spabsen.no_surat,
																				spabsen.noind,
																				spabsen.bulan,
																				spabsen.berlaku,
																				spabsen.sp_ke,
																				'Absensi' as jenis,
																				spabsen.tanggal_awal_berlaku as tanggal_awal_berlaku,
																				spabsen.tanggal_akhir_berlaku as tanggal_akhir_berlaku
																	from 		(
																					select 		*,
																								to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																								(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																					from 		\"Surat\".tsp
																				) as spabsen
																	union
																	select 		spnonabsen.no_surat,
																				spnonabsen.noind,
																				spnonabsen.bulan,
																				spnonabsen.berlaku,
																				spnonabsen.sp_ke,
																				'Non Absensi' as jenis,
																				spnonabsen.tanggal_awal_berlaku as tanggal_awal_berlaku,
																				spnonabsen.tanggal_akhir_berlaku as tanggal_akhir_berlaku
																	from 		(
																					select 		*,
																								to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																								(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																					from		\"Surat\".tsp_nonabsen
																				) as spnonabsen
																	union
																	select 		sppres.no_surat,
																				sppres.noind,
																				sppres.bulan,
																				sppres.berlaku,
																				sppres.sp_ke,
																				'Bawah Prestasi' as jenis,
																				sppres.tanggal_awal_berlaku as tanggal_awal_berlaku,
																				sppres.tanggal_akhir_berlaku as tanggal_akhir_berlaku
																	from 		(
																					select		*,
																								to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM') as tanggal_awal_berlaku,
																								(to_date(concat(substring(berlaku, 1, 4), substring(berlaku, 5, 2)), 'YYYYMM')+ interval '6 month' - interval '1 day')::date as tanggal_akhir_berlaku
																					from		\"Surat\".tsp_prestasi as sppres
																				) as sppres
																	order by 	noind,
																				sp_ke,
																				tanggal_awal_berlaku
																) as tabelmaster
												) as tabelsp
									where 		tabelsp.noind=a.noind
												and 	tabelsp.tanggal_awal_berlaku between '$st' and '$end'
												and 	tabelsp.lanjutan='STOP'
								) sp,
								coalesce
								(
									(
										select 	count(datapre.*)
										from 	\"Presensi\".tdatapresensi as datapre
										where 	datapre.tanggal between '$st' and '$end'
												and 	datapre.noind=a.noind
												and 	datapre.kd_ket='PSK'
									)
									,0
								) as total_hari_sk,
								(
									select 	sum(sk.status_bulan_sk)
									from 	(
												select		tbltgl.tanggal_awal,
															tbltgl.tanggal_akhir,
															(
																case	when 	(
																					select 	count(*)
																					from 	\"Presensi\".tdatapresensi as datapre
																					where 	datapre.tanggal between tbltgl.tanggal_awal and tbltgl.tanggal_akhir
																							and 	datapre.noind=a.noind
																							and 	datapre.kd_ket='PSK'
																				)>0
																		then 	1
																		else 	0
																end
															) as status_bulan_sk
												from 		(
																select 		to_date
																			(
																				concat_ws
																				(
																					'-', 
																					extract(year from datapre.tanggal), 
																					extract(month from datapre.tanggal)
																				)
																				,
																				'YYYY-MM'
																			)
																			as tanggal_awal,
																			(
																				to_date
																				(
																					concat_ws
																					(
																						'-', 
																						extract(year from datapre.tanggal), 
																						extract(month from datapre.tanggal)
																					)
																					,
																					'YYYY-MM'
																				)
																				+
																				interval '1 month'
																				-
																				interval '1 day'
																			)::date as tanggal_akhir
																from 		\"Presensi\".tdatapresensi as datapre
																where 		datapre.tanggal between '$st' and '$end'
																group by 	extract(year from datapre.tanggal),
																			extract(month from datapre.tanggal)
																order by 	tanggal_awal
															) as tbltgl
											) as sk
								)  as total_bulan_sk
						from 	hrd_khs.tpribadi a
								join 	hrd_khs.tseksi as seksi
										on 	seksi.kodesie=a.kodesie
						where 	a.keluar='0' 
								and 	(trim(a.kode_status_kerja)='A'
								or (trim(a.kode_status_kerja)= 'B' and a.kd_jabatan not like '%-%' and a.kd_jabatan::integer >= 14)
								or a.noind = 'J1364')
								and 	a.diangkat<=(('$end')::date - interval '1 year' + interval '1 days');";
								//and 	a.diangkat<=(('$st')::date);";
								// echo $query;exit();
		$sql = $personalia->query($query);
		return $sql->result_array();
	}

	public function insert_worker($insert){
		$this->db->insert($this->assesment,$insert);
	}

	public function list_periode(){
		// $this->db->select("periode");
		// $this->db->group_by('periode');
		// return $this->db->get($this->assesment)->result_array();

		$list_periode 		= "	select 		pkas.periode_awal,
											pkas.periode_akhir,
											pkas.periode,
											pkas.status_konfirmasi
								from		pk.pk_assessment as pkas
								group by 	pkas.periode_awal,
											pkas.periode_akhir,
											pkas.periode,
											pkas.status_konfirmasi;";
		$querylist_periode	=	$this->db->query($list_periode);
		return $querylist_periode->result_array();
	}

	public function check($st, $end, $noind)
	{
		$this->db->where("periode_awal>=", $st);
		$this->db->where("periode_akhir<=", $end);
		$this->db->where("noind=", $noind);
		return $this->db->get($this->assesment)->num_rows();
	}

	public function update_worker($where,$update){
		$this->db->where($where);
		$this->db->update($this->assesment,$update);
	}

	public function load_unit_group_details(){
		return $this->db->get($this->master)->result_array();
	}
		
	public function load_assessment_by_periode($periode){
		$this->db->where('periode=',$periode);
		return $this->db->get($this->assesment)->result_array();
	}

	public function deletejurnalpenilaian($periode){
		$this->db->where('periode=',$periode);
		$this->db->delete($this->assesment);
	}

	public function ambilDaftarUnitGroup()
	{
		$ambilDaftarUnitGroup 		= "	select 		pkug.id_unit_group,
													pkug.unit_group
										from 		pk.pk_unit_group as pkug
										order by	pkug.id_unit_group;";
		$queryAmbilDaftarUnitGroup 	=	$this->db->query($ambilDaftarUnitGroup);
		return $queryAmbilDaftarUnitGroup->result_array();
	}

	public function ambilDaftarEvaluasiSeksi($periode = FALSE)
	{
		$kon = "";
		if (isset($periode) and !empty($periode)) {
			$kon = "where  		pkas.periode='".$periode."'";
		}
		$ambilDaftarEvaluasiSeksi 		= "	select 		pkas.*
											from 		pk.pk_assessment as pkas $kon
											order by 	pkas.kodesie,
														pkas.gol_kerja,
														pkas.noind;";
		$queryAmbilDaftarEvaluasiSeksi 	=	$this->db->query($ambilDaftarEvaluasiSeksi);
		return $queryAmbilDaftarEvaluasiSeksi->result_array();
	}

	public function ambilPeriode($periode)
	{
		$ambilPeriode 		= "	select 		pkas.periode_awal,
											pkas.periode_akhir
								from		pk.pk_assessment as pkas
								where  		pkas.periode='".$periode."'
								group by 	pkas.periode_awal,
											pkas.periode_akhir;";
		$queryAmbilPeriode 	=	$this->db->query($ambilPeriode);
		return $queryAmbilPeriode->result_array();
	}

	public function ambilTotalPekerjaGolonganHasil($idUnitGroup, $golongan, $periode)
	{
		// $ambilTotalPekerjaGolonganHasil			= "	select 		count(pkas.id_assessment) as jumlah_pekerja
		// 											from  		pk.pk_assessment as pkas
		// 											where 		pkas.id_unit_group=".$idUnitGroup."
		// 														and 	pkas.gol_nilai=".$golongan."
		// 														and 	pkas.periode='".$periode."';";
		// $queryAmbilTotalPekerjaGolonganHasil	=	$this->db->query($ambilTotalPekerjaGolonganHasil);
		// $hasilAmbilTotalPekerjaGolonganHasil 	=	$queryAmbilTotalPekerjaGolonganHasil->result_array();
		// return $hasilAmbilTotalPekerjaGolonganHasil[0]['jumlah_pekerja'];

		$ambilTotalPekerjaGolonganHasil			= "	select 		count(pkas.id_assessment) as jumlah_pekerja
													from  		pk.pk_assessment as pkas
													where 		pkas.gol_kerja='".$idUnitGroup."'
																and 	pkas.gol_nilai=".$golongan."
																and 	pkas.periode='".$periode."';";
		$queryAmbilTotalPekerjaGolonganHasil	=	$this->db->query($ambilTotalPekerjaGolonganHasil);
		$hasilAmbilTotalPekerjaGolonganHasil 	=	$queryAmbilTotalPekerjaGolonganHasil->result_array();
		return $hasilAmbilTotalPekerjaGolonganHasil[0]['jumlah_pekerja'];


	}

	public function ambilTotalPekerjaGolonganRencana($idUnitGroup, $golongan)
	{
		// $ambilTotalPekerjaGolonganRencana			= "	select 		pkdist.worker_count as jumlah_pekerja
		// 												from 		pk.pk_unit_distribution as pkdist
		// 												where 		pkdist.id_unit_group=".$idUnitGroup."
		// 															and 	pkdist.gol_num=".$golongan.";";
		// $queryAmbilTotalPekerjaGolonganRencana 		=	$this->db->query($ambilTotalPekerjaGolonganRencana);
		// $hasilAmbilTotalPekerjaGolonganRencana 		=	$queryAmbilTotalPekerjaGolonganRencana->result_array();
		// return $hasilAmbilTotalPekerjaGolonganRencana[0]['jumlah_pekerja'];

		$ambilTotalPekerjaGolonganRencana			= "	select 		pkdist.worker_count as jumlah_pekerja
														from 		pk.pk_unit_distribution as pkdist
														where 		pkdist.gol_kerja='".$idUnitGroup."'
																	and 	pkdist.gol_num=".$golongan.";";
		$queryAmbilTotalPekerjaGolonganRencana 		=	$this->db->query($ambilTotalPekerjaGolonganRencana);
		$hasilAmbilTotalPekerjaGolonganRencana 		=	$queryAmbilTotalPekerjaGolonganRencana->result_array();
		return $hasilAmbilTotalPekerjaGolonganRencana[0]['jumlah_pekerja'];


	}

	public function ambilDataExportExcel($periode = FALSE)
	{	
		$kon = "";
		if (isset($periode) and !empty($periode)) {
			$kon = "where pkas.periode = '$periode'";
		}
		$ambilDataExportExcel 			= "	select 		pkas.kodesie as kodesie,
														seksi.department_name as dept,
														seksi.field_name as bid,
														seksi.unit_name as unit,
														seksi.section_name as seksi,
														seksi.job_name as pekerjaan,
														pkas.noind as noind,
														rtrim(pkas.nama) as namaopr,
														trim(pkas.gol_kerja) as golkerja,
														pkas.n_pwk as nwaktu,
														pkas.n_kk as nkemauan,
														pkas.n_pk as nprestasi,
														pkas.n_p as nperilaku,
														pkas.n_sp,
														pkas.n_tim,
														pkas.total_nilai,
														pkas.gol_nilai,
														pkas.n_sp_asli,
														pkas.n_tim_asli,
														case when pkas.lokasi_kerja = '03' then
															(
																select 		nominal_kenaikan - (select mlati::int from pk.pk_penyesuaian)
																from 		pk.pk_kenaikan as pknaik
																where 		pknaik.id_kenaikan=pkas.id_kenaikan
															)
														when pkas.lokasi_kerja = '02' then
															(
																select 		nominal_kenaikan - (select tuksono::int from pk.pk_penyesuaian)
																from 		pk.pk_kenaikan as pknaik
																where 		pknaik.id_kenaikan=pkas.id_kenaikan
															)
														else
															(
																select 		nominal_kenaikan
																from 		pk.pk_kenaikan as pknaik
																where 		pknaik.id_kenaikan=pkas.id_kenaikan
															)
														end as naik,
														hasil.gp_lama as gpnaik,
														hasil.gp_baru as gpbaru,
														null as selisih,
														null as cetak,
														null as rangebwh,
														pkas.t_kk as nkk_a,
														pkas.t_pk as npk_a,
														pkas.t_kk_pengurang as kk_m,
														pkas.t_pk_pengurang as pk_m,
														pkas.n_kk_pengurang as nkk_m,
														pkas.n_pk_pengurang as npk_m,
														pkas.total_hari_sk,
														pkas.total_bulan_sk
											from 		pk.pk_assessment as pkas
											left join 	er.er_section as seksi
														on 	seksi.section_code=pkas.kodesie
											left join 	pk.pk_hasil hasil
														on 	hasil.noind = pkas.noind and hasil.periode = pkas.periode
														 $kon
											order by 	pkas.gol_kerja,
														pkas.gol_nilai,
														pkas.total_nilai desc,
														pkas.kodesie,
														pkas.noind";
		$queryAmbilDataExportExcel 		=	$this->db->query($ambilDataExportExcel);
		return $queryAmbilDataExportExcel->result_array();
	}

	public function ambilDaftarSeksiPenilaian()
	{
		// $this->db->select('*');
		// $this->db->from('pk.pk_unit_group_list');
		// $this->db->order_by('kodesie');

		// return $this->db->get()->result_array();

		$ambilDaftarSeksiPenilaian			= "	select 		substring(pkas.kodesie,1,7) as kodesie,
															pkugl.seksi
												from 		pk.pk_assessment as pkas
															join 	pk.pk_unit_group_list as pkugl
															 			on	pkugl.id_unit_group=pkas.id_unit_group 
															 				and 	pkugl.kodesie=substring(pkas.kodesie,1,7)
												group by 	substring(pkas.kodesie,1,7),
															pkugl.seksi
												order by 	substring(pkas.kodesie,1,7);";
		$queryAmbilDaftarSeksiPenilaian 	=	$this->db->query($ambilDaftarSeksiPenilaian);
		return $queryAmbilDaftarSeksiPenilaian->result_array();
	}

	public function ambilNamaUnit($kodesie)
	{
		$personalia 	=	$this->load->database("personalia", true);
		$ambilNamaUnit			= "	select 		seksi.*
									from 		hrd_khs.tseksi as seksi
									where 		substring(seksi.kodesie,1,7)='".$kodesie."'
												and 	seksi.dept!='-'
												and 	seksi.bidang!='-'
												and 	seksi.unit!='-'
												and 	seksi.seksi not like '%-%'
									limit 		1;";
		$queryAmbilNamaUnit 	=	$personalia->query($ambilNamaUnit);
		$hasilAmbilNamaUnit 	=	$queryAmbilNamaUnit->result_array();
		return $hasilAmbilNamaUnit[0]['unit'];
	}

	public function ambilDaftarUnitPenilaian($periodeAkhir)
	{
		$personalia 	=	$this->load->database("personalia", true);
		$ambilDaftarUnitPenilaian			= "	select distinct	substring(pri.kodesie,1,5) as kode_unit,
																(
																	select 		seksi.unit
																	from 		hrd_khs.tseksi as seksi
																	where 		substring(seksi.kodesie,1,5)=substring(pri.kodesie,1,5)
																	limit 		1
																) as nama_unit
												from 			hrd_khs.tpribadi as pri
												where 		 	pri.keluar=false
																and 	substring(pri.noind,1,1)='A'
																and 	pri.diangkat<=(('$periodeAkhir')::date - interval '1 year')
												order by 		kode_unit asc;";
		$queryAmbilDaftarUnitPenilaian		=	$personalia->query($ambilDaftarUnitPenilaian);
		return $queryAmbilDaftarUnitPenilaian->result_array();
	}

	public function ambilGolonganKerjaPerUnit($kode_unit, $periode_akhir)
	{
		$personalia 	=	$this->load->database("personalia", true);
		$ambilGolonganKerjaPerUnit			= "	select distinct	left(pri.golkerja,1) golkerja
												from 			hrd_khs.tpribadi as pri
												where 			substring(pri.noind,1,1)='A'
																and 	pri.keluar=false
																and 	substring(pri.kodesie,1,5)='$kode_unit'
																and 	pri.diangkat<=(('$periode_akhir')::date - interval '1 year')
												order by 		left(pri.golkerja,1);";
		$queryAmbilGolonganKerjaPerUnit		=	$personalia->query($ambilGolonganKerjaPerUnit);
		return $queryAmbilGolonganKerjaPerUnit->result_array();
	}
}