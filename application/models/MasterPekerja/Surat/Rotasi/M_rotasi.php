<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_rotasi extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
	}

	public function getAmbilPekerjaAktif()
	{
		$getAmbilPekerjaAktif = "select trim(noind) as noind, concat_ws(' - ', noind, nama) as pekerja from hrd_khs.tpribadi where keluar=false
			order by noind ";
		$query 	=	$this->personalia->query($getAmbilPekerjaAktif);
		return $query->result_array();
	}
	public function getSeksi()
	{
		$getSeksi = "select 		trim(kodesie) as kodesie,
									concat_ws
									(
										' - ',
										trim(kodesie),
										(
											case 	when 	rtrim(seksi)!='-'
															then 	'Seksi ' || rtrim(seksi)
													else	(
																case 	when 	rtrim(unit)!='-'
																				then 	'Unit ' || rtrim(unit)
																		else 	(
																					case 	when 	rtrim(bidang)!='-'
																									then 	'Bidang ' || rtrim(bidang)
																							else 	'Departemen ' || rtrim(dept)
																					end
																				)
																end
															)
											end
										),
										(
											case 	when 	rtrim(pekerjaan)!='-'
															then 	rtrim(pekerjaan)
											end
										)
									)as namaseksi
						from 		hrd_khs.tseksi
						where 		trim(kodesie)!='-'
						order by kodesie";
		$query 	=	$this->personalia->query($getSeksi);
		return $query->result_array();
	}
	// public function cariKodesie($noind)
	// {
	// 	$query = "select * from hrd_khs.tpribadi where noind='$noind'";
	// 	$sql = $this->personalia->query($query);
	// 	return $sql->result_array();
	// }
	public function getDetailPekerja($noind)
	{
		$getDetailPekerja 		= "	select 		trim(pri.noind) as noind,
													rtrim(pri.nama) as nama,
													concat_ws
													(
														' - ',
														trim(pri.kodesie),
														(
															case 	when 	rtrim(tseksi.seksi)!='-'
																			then 	'Seksi ' || rtrim(tseksi.seksi)
																	else	(
																				case 	when 	rtrim(tseksi.unit)!='-'
																								then 	'Unit ' || rtrim(tseksi.unit)
																						else 	(
																									case 	when 	rtrim(tseksi.bidang)!='-'
																													then 	'Bidang ' || rtrim(tseksi.bidang)
																											else 	'Departemen ' || rtrim(tseksi.dept)
																									end
																								)
																				end
																			)
															end
														),
														(
															case 	when 	rtrim(tseksi.pekerjaan)!='-'
																			then 	rtrim(tseksi.pekerjaan)
															end
														)
													) as nama_seksi,
													(
														case 	when 	pri.kd_pkj is not null
																		then 	pri.kd_pkj || ' - ' || rtrim(tpekerjaan.pekerjaan)
														end
													) as pekerjaan,
													trim(pri.golkerja) as golongan_pekerjaan,
													trim(pri.kd_jabatan)as kd_jabatan,
													rtrim(pri.jabatan)as jabatan,
													rtrim(pri.tempat_makan1)as tempat_makan1,
													rtrim(pri.tempat_makan2)as tempat_makan2,
													(
														case 	when 	pri.kd_jabatan::numeric<17
																		then 	'STAF'
																else 	'NONSTAF'
														end
													) as status_staf,
													trim(pri.lokasi_kerja) || ' - ' || rtrim(lokker.lokasi_kerja) as lokasi_kerja
										from 		hrd_khs.tpribadi as pri
													join 	hrd_khs.tseksi as tseksi
															on 	tseksi.kodesie=pri.kodesie
													left join 	hrd_khs.tpekerjaan as tpekerjaan
																on 	tpekerjaan.kdpekerjaan=pri.kd_pkj
													join 	hrd_khs.tlokasi_kerja as lokker
															on 	lokker.id_=pri.lokasi_kerja
										where 		pri.noind='$noind'";
		$query 	=	$this->personalia->query($getDetailPekerja);
		return $query->result_array();
		// return $DetailPekerjaan;
	}
	public function DetailPekerjaan()
	{
		$DetailPekerjaan = "select  kdpekerjaan as kd,concat_ws(' - ', kdpekerjaan, pekerjaan) as pekerjaan  from hrd_khs.tpekerjaan where kdpekerjaan like '%'";
		// $DetailPekerjaan= "select  kdpekerjaan as kd,concat_ws(' - ', kdpekerjaan, pekerjaan) as pekerjaan  from hrd_khs.tpekerjaan";
		$query 	=	$this->personalia->query($DetailPekerjaan);
		return $query->result_array();
		// return $DetailPekerjaan;
	}

	public function DetailGolongan()
	{
		$DetailGolongan = "select DISTINCT golkerja from hrd_khs.tpribadi where keluar='0'order by golkerja";

		$query 	=	$this->personalia->query($DetailGolongan);
		return $query->result_array();
	}

	public function DetailLokasiKerja()
	{
		$DetailLokasiKerja = "select id_ as kode_lokasi, lokasi_kerja as nama_lokasi,concat_ws(' - ', id_, lokasi_kerja) as lokasi  from hrd_khs.tlokasi_kerja order by id_";

		$query 	=	$this->personalia->query($DetailLokasiKerja);
		return $query->result_array();
		//return $DetailLokasiKerja;
	}

	public function DetailKdJabatan()
	{
		$DetailKdJabatan = "select kd_jabatan as kd_jabatan , jabatan as jabatan from hrd_khs.torganisasi";
		$query 	=	$this->personalia->query($DetailKdJabatan);
		return $query->result_array();
		// return $DetailKdJabatan;
	}

	public function DetailTempatMakan1()
	{
		$DetailTempatMakan1 = "select distinct tempat_makan1 as tempat_makan1 from hrd_khs.tpribadi where keluar='false'";
		$query 	=	$this->personalia->query($DetailTempatMakan1);
		return $query->result_array();
		// return $DetailKdJabatan;
	}

	public function DetailTempatMakan2()
	{
		$DetailTempatMakan2 = "select distinct tempat_makan2 as tempat_makan2 from hrd_khs.tpribadi where keluar='false'";
		$query 	=	$this->personalia->query($DetailTempatMakan2);
		return $query->result_array();
		// return $DetailKdJabatan;
	}

	public function cariPekerja($keywordPencarianPekerja)
	{
		$cariPekerja 	=	"	select 		rtrim(nama) as nama,
												trim(noind) as noind
									from 		hrd_khs.tpribadi
									where 		keluar=false
												and 	(
															nama like '%$keywordPencarianPekerja%'
															or 	noind 	like '%$keywordPencarianPekerja%'
														)
									order by 	noind;";
		$query 			=	$this->personalia->query($cariPekerja);
		return $query->result_array();
	}
	public function cariseksi($keywordPencarianSeksi)
	{
		$pencarianseksi = " select 		trim(kodesie) as kodesie,
											concat_ws
											(
												' - ',
												(
													case 	when 	rtrim(seksi)!='-'
																	then 	'Seksi ' || rtrim(seksi)
															else	(
																		case 	when 	rtrim(unit)!='-'
																						then 	'Unit ' || rtrim(unit)
																				else 	(
																							case 	when 	rtrim(bidang)!='-'
																											then 	'Bidang ' || rtrim(bidang)
																									else 	'Departemen ' || rtrim(dept)
																							end
																						)
																		end
																	)
													end
												),
												(
													case 	when 	rtrim(pekerjaan)!='-'
																	then 	rtrim(pekerjaan)
													end
												)
											)as seksi
								from 		hrd_khs.tseksi
								where 		(
												kodesie like'$keywordPencarianSeksi%'
												or 	dept like'%$keywordPencarianSeksi%'
												or 	bidang like'%$keywordPencarianSeksi%'
												or 	unit like'%$keywordPencarianSeksi%'
												or 	seksi like'%$keywordPencarianSeksi%'
											)
								order by 	kodesie";
		$query 	=	$this->personalia->query($pencarianseksi);
		return $query->result_array();
		// return $pencarianseksi;
	}

	public function cariPekerjaan($keywordPencarianPekerjaan = FALSE, $kodeSeksi)
	{
		$cariPekerjaan 	= "	select 		trim(kdpekerjaan) as kdpekerjaan,
											rtrim(pekerjaan) as pekerjaan
								from 		hrd_khs.tpekerjaan
								where 		kdpekerjaan like '$kodeSeksi%'
											and 	(
														pekerjaan like '%$keywordPencarianPekerjaan%'
														or 	kdpekerjaan like '$keywordPencarianPekerjaan%'
													)";
		$query 			=	$this->personalia->query($cariPekerjaan);
		return $query->result_array();
	}

	public function cariGolonganPekerjaan($keywordPencarianGolKerja, $kodeStatusKerja)
	{
		$cariGolonganPekerjaan 		= "	select distinct trim(golkerja) as golkerja
											from 			hrd_khs.tpribadi
											where 			kode_status_kerja='$kodeStatusKerja'
															and 	golkerja like '$keywordPencarianGolKerja%'
											order by 		golkerja";
		$query 						=	$this->personalia->query($cariGolonganPekerjaan);
		return $query->result_array();
	}

	public function ambilLayoutSuratRotasi($stafff)
	{
		$this->personalia->select('isi_surat');
		$this->personalia->from('"Surat".tisi_surat"');
		$this->personalia->where('jenis_surat=', 'ROTASI');
		$this->personalia->where('staf=', $stafff);

		return $this->personalia->get()->result_array();
	}

	public function ambilNomorSuratTerakhir($tahun, $bulan, $kodeSurat)
	{
		$ambilNomorSuratTerakhir 		= "select max(nomor_surat) jumlah from \"Surat\".t_arsip_nomor_surat where kode_surat = '$kodeSurat'
and tahun_surat = '$tahun' and bulan_surat = '$bulan'";
		$query 		= 	$this->personalia->query($ambilNomorSuratTerakhir);
		return $query->result_array();
	}

	public function cariTSeksi($seksi_lama)
	{
		$cariTSeksi 		= "	select 		rtrim(tseksi.dept) as dept,
												rtrim(tseksi.bidang) as bidang,
												rtrim(tseksi.unit) as unit,
												rtrim(tseksi.seksi) as seksi
									from 		hrd_khs.tseksi as tseksi
									where 		kodesie='$seksi_lama'";
		$query 				=	$this->personalia->query($cariTSeksi);
		return $query->result_array();
	}

	public function getNamaNoindBaru($nomor_induk)
	{
		$getNamaNoindBaru 		= "	select 		trim(noind_baru) as noind_baru,
	 												rtrim(nama) as nama
	 									from 		hrd_khs.tpribadi as pri
	 									where 		pri.noind='$nomor_induk'";
		$query 					=	$this->personalia->query($getNamaNoindBaru);
		return $query->result_array();
	}

	public function inputSuratRotasi($inputSuratRotasi)
	{
		$this->personalia->insert('"Surat".tsurat_rotasi', $inputSuratRotasi);
	}

	public function inputNomorSurat($inputNomorSurat)
	{
		$this->personalia->insert('"Surat".t_arsip_nomor_surat', $inputNomorSurat);
	}

	public function ambilDaftarSuratRotasi()
	{
		$ambilDaftarSuratRotasi 		= "	select 		concat
															(
																rotasi.no_surat, 
																'/'||rotasi.kode||'/', 
																to_char(rotasi.tanggal_cetak, 'MM'), 
																'/', 
																to_char(rotasi.tanggal_cetak, 'YY')
															) as no_surat,
															rotasi.tanggal_berlaku::date as tanggal_berlaku,
															rotasi.noind,
															rotasi.nama,
															concat_ws
															(
																' - ',
																rotasi.kodesie_lama,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=rotasi.kodesie_lama
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=rotasi.kodesie_lama
																)
															) as seksi_lama,
															concat_ws
															(
																' - ',
																rotasi.kodesie_baru,
																(			
																	select 		case 	when 	rtrim(seksi)!='-'
																								then 	'Seksi ' || rtrim(seksi)
																						else	(
																									case 	when 	rtrim(unit)!='-'
																													then 	'Unit ' || rtrim(unit)
																											else 	(
																														case 	when 	rtrim(bidang)!='-'
																																		then 	'Bidang ' || rtrim(bidang)
																																else 	'Departemen ' || rtrim(dept)
																														end
																													)
																									end
																								)
																				end
																	from	 	hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=rotasi.kodesie_baru
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=rotasi.kodesie_baru
																)
															) as seksi_baru,
															concat_ws
															(
																' - ',
																rotasi.lokasi_kerja_lama,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=rotasi.lokasi_kerja_lama
																)
															) as lokasi_kerja_lama,
															concat_ws
															(
																' - ',
																rotasi.lokasi_kerja_baru,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=rotasi.lokasi_kerja_baru
																)
															) as lokasi_kerja_baru,
															rotasi.tanggal_cetak::date,
															rotasi.cetak
												from 		\"Surat\".tsurat_rotasi as rotasi
												where deleted_date is null";
		$query 					=	$this->personalia->query($ambilDaftarSuratRotasi);
		return $query->result_array();
	}

	public function ambilIsiSuratRotasi($no_surat_decode)
	{
		$ambilIsiSuratRotasi 		= "	select 		rotasi.isi_surat
											from 		\"Surat\".tsurat_rotasi as rotasi
											where 	 	concat
														(
															rotasi.no_surat, 
															'/'||rotasi.kode||'/', 
															to_char(rotasi.tanggal_cetak, 'MM'), 
															'/', 
															to_char(rotasi.tanggal_cetak, 'YY')
														)
														=
														'$no_surat_decode'";
		$query 						=	$this->personalia->query($ambilIsiSuratRotasi);
		return $query->result_array();
	}

	public function deleteSuratRotasi($no_surat_decode)
	{
		// $deleteSuratRotasi 		= "	delete from \"Surat\".tsurat_rotasi
		// 							where 		concat
		// 										(
		// 											no_surat, 
		// 											'/'||kode||'/',
		// 											to_char(tanggal_cetak, 'MM'), 
		// 											'/', 
		// 											to_char(tanggal_cetak, 'YY')
		// 										)
		// 										=
		// 										'$no_surat_decode'";
		$logged_user = $this->session->user;
		$sql = "UPDATE \"Surat\".tsurat_rotasi
							SET deleted_by = '$logged_user', deleted_date = now()
							WHERE concat
													(
														no_surat, 
														'/'||kode||'/',
														to_char(tanggal_cetak, 'MM'), 
														'/', 
														to_char(tanggal_cetak, 'YY')
													)
													=
													'$no_surat_decode'";
		$query 					=	$this->personalia->query($sql);
	}

	public function editSuratRotasi($no_surat_decode)
	{
		$editSuratRotasi 		= "	select 		promosi.kode,
													promosi.no_surat,
													promosi.hal_surat,
													promosi.nama,
													promosi.noind,
													promosi.kodesie_lama,
													promosi.kodesie_baru,
													promosi.nama_status_lama,
 													promosi.nama_status_baru,
 													promosi.kd_status_lama,
 													promosi.kd_status_baru,
 													promosi.nama_jabatan_upah_lama, 
 													promosi.nama_jabatan_upah_baru,   
															concat_ws
																									(
																										' - ',
																										promosi.kodesie_lama,
																										(			
																											select 		case 	when 	rtrim(seksi)!='-'
																																		then 	'Seksi ' || rtrim(seksi)
																																else	(
																																			case 	when 	rtrim(unit)!='-'
																																							then 	'Unit ' || rtrim(unit)
																																					else 	(
																																								case 	when 	rtrim(bidang)!='-'
																																												then 	'Bidang ' || rtrim(bidang)
																																										else 	'Departemen ' || rtrim(dept)
																																								end
																																							)
																																			end
																																		)
																														end
																											from	 	hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=promosi.kodesie_lama
																										),
																										(
																											select		case 	when 	rtrim(pekerjaan)!='-'
																																		then 	rtrim(pekerjaan)
																														end
																											from 		hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=promosi.kodesie_lama
																										)
																									) as seksi_lama,
															concat_ws
																									(
																										' - ',
																										promosi.kodesie_baru,
																										(			
																											select 		case 	when 	rtrim(seksi)!='-'
																																		then 	'Seksi ' || rtrim(seksi)
																																else	(
																																			case 	when 	rtrim(unit)!='-'
																																							then 	'Unit ' || rtrim(unit)
																																					else 	(
																																								case 	when 	rtrim(bidang)!='-'
																																												then 	'Bidang ' || rtrim(bidang)
																																										else 	'Departemen ' || rtrim(dept)
																																								end
																																							)
																																			end
																																		)
																														end
																											from	 	hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=promosi.kodesie_baru
																										),
																										(
																											select		case 	when 	rtrim(pekerjaan)!='-'
																																		then 	rtrim(pekerjaan)
																														end
																											from 		hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=promosi.kodesie_baru
																										)
																									) as seksi_baru,
													promosi.tempat_makan_1_lama,
													promosi.tempat_makan_1_baru,
													promosi.lokasi_kerja_lama,
													promosi.lokasi_kerja_baru,
													concat_ws
																									(
																										' - ',
																										promosi.lokasi_kerja_lama,
																										(
																											select 		lokker.lokasi_kerja
																											from 		hrd_khs.tlokasi_kerja as lokker
																											where 		lokker.id_=promosi.lokasi_kerja_lama
																										)
																									) as lokasi_lama,
																									concat_ws
																									(
																										' - ',
																										promosi.lokasi_kerja_baru,
																										(
																											select 		lokker.lokasi_kerja
																											from 		hrd_khs.tlokasi_kerja as lokker
																											where 		lokker.id_=promosi.lokasi_kerja_baru
																										)
																									) as lokasi_baru,
													promosi.golkerja_lama,
													promosi.golkerja_baru,
													promosi.kd_jabatan_lama,
													promosi.kd_jabatan_baru,
													promosi.tanggal_berlaku,
													promosi.isi_surat,
													promosi.cetak,
													promosi.tanggal_cetak,
													promosi.noind_baru,
													promosi.jabatan_lama,
													promosi.jabatan_baru,
													(select jabatan
													from hrd_khs.torganisasi as torg
													where torg.kd_jabatan=promosi.kd_jabatan_baru
													)as jabatann,
													promosi.tempat_makan_2_lama,
													promosi.tempat_makan_2_baru,
													promosi.kd_pkj_lama,
													promosi.kd_pkj_baru,
										            (select pekerjaan
													from hrd_khs.tpekerjaan as pek
													where pek.kdpekerjaan=promosi.kd_pkj_lama
													)as pekerjaan_lama,
													(select pekerjaan
													from hrd_khs.tpekerjaan as pek
													where pek.kdpekerjaan=promosi.kd_pkj_baru
													)as pekerjaan_baru,
													(
														case 	when 	promosi.kd_jabatan_lama::numeric<17
																		then 	'STAF'
																else 	'NONSTAF'
														end
													) as status_staf
										from 		\"Surat\".tsurat_rotasi as promosi
										where 		concat
													(
														promosi.no_surat,
														'/' || promosi.kode || '/',
														to_char(promosi.tanggal_cetak, 'MM'),
														'/',
														to_char(promosi.tanggal_cetak, 'yy')
													)
													=
													'$no_surat_decode';";
		// echo $editSuratRotasi;exit();
		$query 			=	$this->personalia->query($editSuratRotasi);
		return $query->result_array();
	}

	public function updateSuratRotasi($updateSuratRotasi, $nomor_surat, $kodeSurat, $tanggal_cetak)
	{
		$this->personalia->where('tanggal_cetak=', $tanggal_cetak);
		$this->personalia->where('no_surat=', $nomor_surat);
		$this->personalia->where('kode=', $kodeSurat);
		$this->personalia->update('"Surat".tsurat_rotasi', $updateSuratRotasi);
	}

	public function ambilPosisi($nomor_induk)
	{
		$ambilPosisi 	= "	select 		master.nama,
													master.noind,
													(
														case 	when 	(
																			master.kd_jabatan::int between 1 and 14
																			or 	master.kd_jabatan::int in (16, 19, 25)
																		)
																		then 	concat_ws(' ', master.jabatan, master.lingkup)
																else 	concat
																		(
																			master.pekerjaan,
																			' / ',
																			'Golongan ',
																			master.golkerja,
																			' / ',
																			'Seksi ',
																			master.seksi,
																			' / ',
																			'Unit ',
																			master.unit,
																			' / ',
																			'Departemen ',
																			master.dept
																		)
														end
													) as posisi
										from 		(
										 				select		pri.nama,
																	pri.noind,
																	pri.kode_status_kerja,
																	pri.golkerja,
																	pri.kd_jabatan,
																	rtrim(torganisasi.jabatan) as jabatan,
																	tseksi.dept,
																	tseksi.bidang,
																	tseksi.unit,
																	tseksi.seksi,
																	tseksi.pekerjaan,
																	(
																		case 	when 	tseksi.seksi='-'
																						then 	(
																									case 	when 	tseksi.unit='-'
																													then 	(
																																case 	when 	tseksi.bidang='-'
																																				then 	tseksi.dept
																																		else 	tseksi.bidang
																																end
																															)
																											else 	tseksi.unit
																									end
																								)
																				else 	tseksi.seksi
																		end
																	) as lingkup,
																	pri.kd_pkj,
																	tpekerjaan.kdpekerjaan as kode_pekerjaan,
																	pri.lokasi_kerja as kode_lokasi_kerja,
																	tlokasi_kerja.lokasi_kerja as nama_lokasi_kerja
														from 		hrd_khs.v_hrd_khs_tpribadi as pri
																	join 		hrd_khs.v_hrd_khs_tseksi as tseksi
																				on 	tseksi.kodesie=pri.kodesie
																	left join 	hrd_khs.tpekerjaan as tpekerjaan
																				on 	tpekerjaan.kdpekerjaan=pri.kd_pkj
																	join 		hrd_khs.torganisasi as torganisasi
																				on 	torganisasi.kd_jabatan=pri.kd_jabatan
																	join 		hrd_khs.tlokasi_kerja as tlokasi_kerja
																				on 	tlokasi_kerja.id_=pri.lokasi_kerja
														where 		pri.noind='$nomor_induk'
													) as master;";
		$query 			=	$this->personalia->query($ambilPosisi);
		return $query->result_array();
	}
	public function cekStaf($nomor_induk)
	{
		$cekStaf 		= "	select 		(
														case 	when 	(
																			pri.kd_jabatan::int between 1 and 14
																			or 	pri.kd_jabatan::int in (16, 19, 25)
																		)
																		then 	'STAF'
																else 	'NONSTAF'
														end
													) as status
										from 		hrd_khs.v_hrd_khs_tpribadi as pri
										where 		pri.noind='$nomor_induk'";
		$query 			=	$this->personalia->query($cekStaf);
		return $query->result_array();
	}

	public function inputFingerRotasi($inputFingerRotasi)
	{
		$this->personalia->insert('"Surat".tpindah_finger', $inputFingerRotasi);
		return $this->personalia->affected_rows();
	}

	public function editFinger($no_surat_decode)
	{
		$sql = "SELECT * from \"Surat\".tpindah_finger
			where concat(no_surat,'/' || kode || '/',to_char(created_date, 'MM'),'/',to_char(created_date, 'yy')) = '$no_surat_decode'";
		// echo "<pre>"; print_r($sql) ;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function updateFingerSuratRotasi($updateFingerSuratRotasi, $nomor_surat, $kodeSurat, $tanggal_cetak)
	{
		$this->personalia->where('created_date', $tanggal_cetak);
		$this->personalia->where('no_surat', $nomor_surat);
		$this->personalia->where('kode', $kodeSurat);
		$this->personalia->update('"Surat".tpindah_finger', $updateFingerSuratRotasi);
		return $this->personalia->affected_rows();
	}

	public function deleteArsipSuratRotasi($bulan_surat, $tahun, $kode_surat, $no_surat)
	{
		$this->personalia->where('bulan_surat=', $bulan_surat);
		$this->personalia->where('tahun_surat=', $tahun);
		$this->personalia->where('kode_surat=', $kode_surat);
		$this->personalia->where('nomor_surat=', $no_surat);
		$this->personalia->delete('"Surat".t_arsip_nomor_surat');
	}

	public function deleteFingerSuratRotasi($no_surat_decode)
	{
		// $deleteFingerSuratRotasi 		= "	delete from \"Surat\".tpindah_finger
		// 							where 		concat
		// 										(
		// 											no_surat, 
		// 											'/'||kode||'/',
		// 											to_char(created_date, 'MM'), 
		// 											'/', 
		// 											to_char(created_date, 'YY')
		// 										)
		// 							=
		// 								'$no_surat_decode'";
		$sql = "UPDATE \"Surat\".tpindah_finger
							SET finger_pindah = 't'
							WHERE concat
													(
														no_surat, 
														'/'||kode||'/',
														to_char(created_date, 'MM'), 
														'/', 
														to_char(created_date, 'YY')
													)
													=
													'$no_surat_decode'";
		$query 					=	$this->personalia->query($sql);
	}
}
