<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_mutasi extends CI_Model
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

	public function ambilLayoutSuratMutasi()
	{
		$this->personalia->select('isi_surat');
		$this->personalia->from('"Surat".tisi_surat"');
		$this->personalia->where('jenis_surat=', 'MUTASI');

		return $this->personalia->get()->result_array();
	}

	public function ambilNomorSuratMutasiTerakhir($parameterTahunBulanMutasi, $kodeSurat)
	{
		$ambilNomorSuratMutasiTerakhir 		= "	select 		max(arsipsurat.nomor_surat) as jumlah
													from 		\"Surat\".t_arsip_kode_surat as arsipsurat
													where 		arsipsurat.bulan_surat='$parameterTahunBulanMutasi'
																and 	arsipsurat.kode_surat='$kodeSurat'";
		$query 		= 	$this->personalia->query($ambilNomorSuratMutasiTerakhir);
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

	public function inputSuratMutasi($inputSuratMutasi)
	{
		$this->personalia->insert('"Surat".tsurat_mutasi', $inputSuratMutasi);
	}

	public function ambilDaftarSuratMutasi()
	{
		$ambilDaftarSuratMutasi 		= "	select 		concat
															(
																mutasi.no_surat, 
																'/'||mutasi.kode||'/', 
																to_char(mutasi.tanggal_cetak, 'MM'), 
																'/', 
																to_char(mutasi.tanggal_cetak, 'YY')
															) as no_surat,
															mutasi.tanggal_berlaku::date as tanggal_berlaku,
															mutasi.noind,
															mutasi.nama,
															concat_ws
															(
																' - ',
																mutasi.kodesie_lama,
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
																	where 		tseksi.kodesie=mutasi.kodesie_lama
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=mutasi.kodesie_lama
																)
															) as seksi_lama,
															concat_ws
															(
																' - ',
																mutasi.kodesie_baru,
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
																	where 		tseksi.kodesie=mutasi.kodesie_baru
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=mutasi.kodesie_baru
																)
															) as seksi_baru,
															concat_ws
															(
																' - ',
																mutasi.lokasi_kerja_lama,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=mutasi.lokasi_kerja_lama
																)
															) as lokasi_kerja_lama,
															concat_ws
															(
																' - ',
																mutasi.lokasi_kerja_baru,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=mutasi.lokasi_kerja_baru
																)
															) as lokasi_kerja_baru,
															mutasi.tanggal_cetak::date,
															mutasi.cetak
												from 		\"Surat\".tsurat_mutasi as mutasi";
		$query 					=	$this->personalia->query($ambilDaftarSuratMutasi);
		return $query->result_array();
	}

	public function ambilIsiSuratMutasi($no_surat_decode)
	{
		$ambilIsiSuratMutasi 		= "	select 		mutasi.isi_surat
											from 		\"Surat\".tsurat_mutasi as mutasi
											where 	 	concat
														(
															mutasi.no_surat, 
															'/'||mutasi.kode||'/', 
															to_char(mutasi.tanggal_cetak, 'MM'), 
															'/', 
															to_char(mutasi.tanggal_cetak, 'YY')
														)
														=
														'$no_surat_decode'";
		$query 						=	$this->personalia->query($ambilIsiSuratMutasi);
		return $query->result_array();
	}

	public function deleteSuratMutasi($no_surat_decode)
	{
		// $deleteSuratMutasi 		= "	delete from \"Surat\".tsurat_mutasi
		// 								where 		concat
		// 											(
		// 												no_surat, 
		// 												'/'||kode||'/',
		// 												to_char(tanggal_cetak, 'MM'), 
		// 												'/', 
		// 												to_char(tanggal_cetak, 'YY')
		// 											)
		// 											=
		// 											'$no_surat_decode'";
		$logged_user = $this->session->user;
		$queryDeleteUpdate = "UPDATE \"Surat\".tsurat_mutasi 
													SET deleted_by = '$logged_user', deleted_time = now() 
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
		$query 					=	$this->personalia->query($deleteSuratMutasi);
	}

	public function deleteArsipSuratMutasi($bulan_surat, $kode_surat, $no_surat)
	{
		$this->personalia->where('bulan_surat=', $bulan_surat);
		$this->personalia->where('kode_surat=', $kode_surat);
		$this->personalia->where('nomor_surat=', $no_surat);
		// THIS TABLE NOT FOUND
		$this->personalia->delete('"Surat".t_arsip_kode_surat');
	}

	public function editSuratMutasi($no_surat_decode)
	{
		$editSuratMutasi 		= "	select 		mutasi.kode,
													mutasi.no_surat,
													mutasi.hal_surat,
													mutasi.nama,
													mutasi.noind,
													mutasi.kodesie_lama,
													mutasi.kodesie_baru,
													mutasi.nama_status_lama,
 													mutasi.nama_status_baru,
 													mutasi.nama_jabatan_upah_lama, 
 													mutasi.nama_jabatan_upah_baru,   
															concat_ws
																									(
																										' - ',
																										mutasi.kodesie_lama,
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
																											where 		tseksi.kodesie=mutasi.kodesie_lama
																										),
																										(
																											select		case 	when 	rtrim(pekerjaan)!='-'
																																		then 	rtrim(pekerjaan)
																														end
																											from 		hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=mutasi.kodesie_lama
																										)
																									) as seksi_lama,
															concat_ws
																									(
																										' - ',
																										mutasi.kodesie_baru,
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
																											where 		tseksi.kodesie=mutasi.kodesie_baru
																										),
																										(
																											select		case 	when 	rtrim(pekerjaan)!='-'
																																		then 	rtrim(pekerjaan)
																														end
																											from 		hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=mutasi.kodesie_baru
																										)
																									) as seksi_baru,
													mutasi.tempat_makan_1_lama,
													mutasi.tempat_makan_1_baru,
													mutasi.lokasi_kerja_lama,
													mutasi.lokasi_kerja_baru,
													concat_ws
																									(
																										' - ',
																										mutasi.lokasi_kerja_lama,
																										(
																											select 		lokker.lokasi_kerja
																											from 		hrd_khs.tlokasi_kerja as lokker
																											where 		lokker.id_=mutasi.lokasi_kerja_lama
																										)
																									) as lokasi_lama,
																									concat_ws
																									(
																										' - ',
																										mutasi.lokasi_kerja_baru,
																										(
																											select 		lokker.lokasi_kerja
																											from 		hrd_khs.tlokasi_kerja as lokker
																											where 		lokker.id_=mutasi.lokasi_kerja_baru
																										)
																									) as lokasi_baru,
													mutasi.golkerja_lama,
													mutasi.golkerja_baru,
													mutasi.kd_jabatan_lama,
													mutasi.kd_jabatan_baru,
													mutasi.tanggal_berlaku,
													mutasi.isi_surat,
													mutasi.cetak,
													mutasi.tanggal_cetak,
													mutasi.noind_baru,
													mutasi.jabatan_lama,
													mutasi.jabatan_baru,
													(select jabatan
													from hrd_khs.torganisasi as torg
													where torg.kd_jabatan=mutasi.kd_jabatan_baru
													)as jabatan,
													mutasi.tempat_makan_2_lama,
													mutasi.tempat_makan_2_baru,
													mutasi.kd_pkj_lama,
													mutasi.kd_pkj_baru,
										            (select pekerjaan
													from hrd_khs.tpekerjaan as pek
													where pek.kdpekerjaan=mutasi.kd_pkj_lama
													)as pekerjaan_lama,
													(select pekerjaan
													from hrd_khs.tpekerjaan as pek
													where pek.kdpekerjaan=mutasi.kd_pkj_baru
													)as pekerjaan_baru,
													(
														case 	when 	mutasi.kd_jabatan_lama::numeric<17
																		then 	'STAF'
																else 	'NONSTAF'
														end
													) as status_staf
										from 		\"Surat\".tsurat_mutasi as mutasi
										where 		concat
													(
														mutasi.no_surat,
														'/' || mutasi.kode || '/',
														to_char(mutasi.tanggal_cetak, 'MM'),
														'/',
														to_char(mutasi.tanggal_cetak, 'yy')
													)
													=
													'$no_surat_decode';";
		$query 			=	$this->personalia->query($editSuratMutasi);
		return $query->result_array();
	}

	public function updateSuratMutasi($updateSuratMutasi, $nomor_surat, $kodeSurat, $tanggal_cetak)
	{
		$this->personalia->where('tanggal_cetak=', $tanggal_cetak);
		$this->personalia->where('no_surat=', $nomor_surat);
		$this->personalia->where('kode=', $kodeSurat);
		$this->personalia->update('"Surat".tsurat_mutasi', $updateSuratMutasi);
	}

	public function inputNomorSurat($inputNomorSurat)
	{
		$this->personalia->insert('"Surat".t_arsip_kode_surat', $inputNomorSurat);
	}
}
