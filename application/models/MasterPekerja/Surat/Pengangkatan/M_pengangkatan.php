<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pengangkatan extends CI_Model
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
		// echo $cariPekerja;exit();
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

	public function ambilLayoutSuratPengangkatan($kode)
	{
		$this->personalia->select('isi_surat');
		$this->personalia->from('"Surat".tisi_surat"');
		$this->personalia->where('jenis_surat=', 'PENGANGKATAN');
		$this->personalia->where('staf=', $kode);

		return $this->personalia->get()->result_array();
	}

	public function ambilNomorSuratTerakhir($tahun, $bulan, $kodeSurat)
	{
		$ambilNomorSuratRotasiTerakhir 		= "	select max(nomor_surat) jumlah from \"Surat\".t_arsip_nomor_surat where kode_surat = '$kodeSurat' and tahun_surat = '$tahun' and bulan_surat = '$bulan'";
		// echo $ambilNomorSuratRotasiTerakhir;
		$query 		= 	$this->personalia->query($ambilNomorSuratRotasiTerakhir);
		return $query->result_array();
		return $$ambilNomorSuratRotasiTerakhir;
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

	public function inputSuratPengangkatan($inputSuratPengangkatan)
	{
		$this->personalia->insert('"Surat".tsurat_pengangkatan', $inputSuratPengangkatan);
	}

	public function ambilDaftarSuratPengangkatan($kode)
	{
		$ambilDaftarSuratPengangkatan 		= "	select 		concat
															(
																pengangkatan.no_surat, 
																'/'||pengangkatan.kode||'/', 
																to_char(pengangkatan.tanggal_cetak, 'MM'), 
																'/', 
																to_char(pengangkatan.tanggal_cetak, 'YY')
															) as no_surat,
															pengangkatan.tanggal_berlaku::date as tanggal_berlaku,
															pengangkatan.noind,
															pengangkatan.nama,
															concat_ws
															(
																' - ',
																pengangkatan.kodesie_lama,
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
																	where 		tseksi.kodesie=pengangkatan.kodesie_lama
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=pengangkatan.kodesie_lama
																)
															) as seksi_lama,
															concat_ws
															(
																' - ',
																pengangkatan.kodesie_baru,
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
																	where 		tseksi.kodesie=pengangkatan.kodesie_baru
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=pengangkatan.kodesie_baru
																)
															) as seksi_baru,
															concat_ws
															(
																' - ',
																pengangkatan.lokasi_kerja_lama,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=pengangkatan.lokasi_kerja_lama
																)
															) as lokasi_kerja_lama,
															concat_ws
															(
																' - ',
																pengangkatan.lokasi_kerja_baru,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=pengangkatan.lokasi_kerja_baru
																)
															) as lokasi_kerja_baru,
															pengangkatan.tanggal_cetak::date,
															pengangkatan.cetak
												from 		\"Surat\".tsurat_pengangkatan as pengangkatan
												where pengangkatan.kode like '$kode%' and deleted_date is null";
		$query 					=	$this->personalia->query($ambilDaftarSuratPengangkatan);
		return $query->result_array();
	}

	public function ambilIsiSuratPengangkatan($no_surat_decode)
	{
		$ambilIsiSuratPengangkatan 		= "	select 		pengangkatan.isi_surat
											from 		\"Surat\".tsurat_pengangkatan as pengangkatan
											where 	 	concat
														(
															pengangkatan.no_surat, 
															'/'||pengangkatan.kode||'/', 
															to_char(pengangkatan.tanggal_cetak, 'MM'), 
															'/', 
															to_char(pengangkatan.tanggal_cetak, 'YY')
														)
														=
														'$no_surat_decode'";
		$query 						=	$this->personalia->query($ambilIsiSuratPengangkatan);
		return $query->result_array();
	}

	public function deleteSuratPengangkatan($no_surat_decode)
	{
		// $deleteSuratPengangkatan 		= "	delete from \"Surat\".tsurat_pengangkatan
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
		$sql = "UPDATE \"Surat\".tsurat_pengangkatan
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

	public function deleteArsipSuratPengangkatan($bulan_surat, $tahun, $kode_surat, $no_surat)
	{
		$this->personalia->where('bulan_surat=', $bulan_surat);
		$this->personalia->where('tahun_surat=', $tahun);
		$this->personalia->where('kode_surat=', $kode_surat);
		$this->personalia->where('nomor_surat=', $no_surat);
		$this->personalia->delete('"Surat".t_arsip_nomor_surat');
	}

	public function editSuratPengangkatan($no_surat_decode)
	{
		$editSuratPengangkatan 		= "	select 		pengangkatan.kode,
													pengangkatan.no_surat,
													pengangkatan.hal_surat,
													pengangkatan.nama,
													pengangkatan.noind,
													pengangkatan.kodesie_lama,
													pengangkatan.kodesie_baru,
													pengangkatan.jbt_dl_baru,
													pengangkatan.jbt_dl_lama,
													pengangkatan.nama_status_lama,
 													pengangkatan.nama_status_baru,
 													pengangkatan.kd_status_lama,
 													pengangkatan.kd_status_baru,
 													pengangkatan.nama_jabatan_upah_lama,
 													pengangkatan.nama_jabatan_upah_baru,
															concat_ws
																									(
																										' - ',
																										pengangkatan.kodesie_lama,
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
																											where 		tseksi.kodesie=pengangkatan.kodesie_lama
																										),
																										(
																											select		case 	when 	rtrim(pekerjaan)!='-'
																																		then 	rtrim(pekerjaan)
																														end
																											from 		hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=pengangkatan.kodesie_lama
																										)
																									) as seksi_lama,
															concat_ws
																									(
																										' - ',
																										pengangkatan.kodesie_baru,
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
																											where 		tseksi.kodesie=pengangkatan.kodesie_baru
																										),
																										(
																											select		case 	when 	rtrim(pekerjaan)!='-'
																																		then 	rtrim(pekerjaan)
																														end
																											from 		hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=pengangkatan.kodesie_baru
																										)
																									) as seksi_baru,
													pengangkatan.tempat_makan_1_lama,
													pengangkatan.tempat_makan_1_baru,
													pengangkatan.lokasi_kerja_lama,
													pengangkatan.lokasi_kerja_baru,
													concat_ws
																									(
																										' - ',
																										pengangkatan.lokasi_kerja_lama,
																										(
																											select 		lokker.lokasi_kerja
																											from 		hrd_khs.tlokasi_kerja as lokker
																											where 		lokker.id_=pengangkatan.lokasi_kerja_lama
																										)
																									) as lokasi_lama,
																									concat_ws
																									(
																										' - ',
																										pengangkatan.lokasi_kerja_baru,
																										(
																											select 		lokker.lokasi_kerja
																											from 		hrd_khs.tlokasi_kerja as lokker
																											where 		lokker.id_=pengangkatan.lokasi_kerja_baru
																										)
																									) as lokasi_baru,
													pengangkatan.golkerja_lama,
													pengangkatan.golkerja_baru,
													pengangkatan.kd_jabatan_lama,
													pengangkatan.kd_jabatan_baru,
													pengangkatan.tanggal_berlaku,
													pengangkatan.isi_surat,
													pengangkatan.cetak,
													pengangkatan.tanggal_cetak,
													pengangkatan.noind_baru,
													pengangkatan.jabatan_lama,
													pengangkatan.jabatan_baru,
													pengangkatan.nomor_induk_baru,
													(select jabatan
													from hrd_khs.torganisasi as torg
													where torg.kd_jabatan=pengangkatan.kd_jabatan_baru
													)as jabatann,
													(select jabatan
													from hrd_khs.torganisasi as torg
													where torg.kd_jabatan=pengangkatan.kd_jabatan_lama
													)as jabatan,
													pengangkatan.tempat_makan_2_lama,
													pengangkatan.tempat_makan_2_baru,
													pengangkatan.kd_pkj_lama,
													pengangkatan.kd_pkj_baru,
										            (select pekerjaan
													from hrd_khs.tpekerjaan as pek
													where pek.kdpekerjaan=pengangkatan.kd_pkj_lama
													)as pekerjaan_lama,
													(select pekerjaan
													from hrd_khs.tpekerjaan as pek
													where pek.kdpekerjaan=pengangkatan.kd_pkj_baru
													)as pekerjaan_baru,
													(
														case 	when 	pengangkatan.kd_jabatan_lama::numeric<17
																		then 	'STAF'
																else 	'NONSTAF'
														end
													) as status_staf
										from 		\"Surat\".tsurat_pengangkatan as pengangkatan
										where 		concat
													(
														pengangkatan.no_surat,
														'/' || pengangkatan.kode || '/',
														to_char(pengangkatan.tanggal_cetak, 'MM'),
														'/',
														to_char(pengangkatan.tanggal_cetak, 'yy')
													)
													=
													'$no_surat_decode';";
		$query 			=	$this->personalia->query($editSuratPengangkatan);
		return $query->result_array();
	}

	public function updateSuratPengangkatan($updateSuratPengangkatan, $nomor_surat, $kodeSurat, $tanggal_cetak)
	{
		$this->personalia->where('tanggal_cetak=', $tanggal_cetak);
		$this->personalia->where('no_surat=', $nomor_surat);
		$this->personalia->where('kode=', $kodeSurat);
		$this->personalia->update('"Surat".tsurat_pengangkatan', $updateSuratPengangkatan);
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
	public function inputNomorSurat($inputNomorSurat)
	{
		$this->personalia->insert('"Surat".t_arsip_nomor_surat', $inputNomorSurat);
	}

	public function inserttlogbaru($nomor_induk, $nomor_induk_baru)
	{
		$tanggal = date("Y-m-d H:i:s");
		$inserttlogbaru 	= "	INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program, noind_baru) VALUES ('$tanggal', 'SURAT PENGANGKATAN', 'PEMBUATAN SURAT PENGANGKATAN $nomor_induk', '$nomor_induk' , 'CREATE -> SURAT PENGANGKATAN', 'SURAT', '$nomor_induk_baru')";

		$query = $this->personalia->query($inserttlogbaru);
	}

	public function inserttlogupdate($nomor_induk, $nomor_induk_baru)
	{
		$tanggal = date("Y-m-d H:i:s");
		$inserttlogbaru 	= "	INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program, noind_baru) VALUES ('$tanggal', 'SURAT PENGANGKATAN', 'EDIT SURAT PENGANGKATAN $nomor_induk', '$nomor_induk' , 'UPDATE -> SURAT PENGANGKATAN', 'SURAT', '$nomor_induk_baru');";

		$query = $this->personalia->query($inserttlogbaru);
	}

	public function inputFingerPengangkatan($inputFingerPengangkatan)
	{
		$this->personalia->insert('"Surat".tpindah_finger', $inputFingerPengangkatan);
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

	public function updateFingerSuratPengangkatan($updateFingerSuratPengangkatan, $nomor_surat, $kodeSurat, $tanggal_cetak)
	{
		$this->personalia->where('created_date', $tanggal_cetak);
		$this->personalia->where('no_surat', $nomor_surat);
		$this->personalia->where('kode', $kodeSurat);
		$this->personalia->update('"Surat".tpindah_finger', $updateFingerSuratPengangkatan);
		return $this->personalia->affected_rows();
	}

	public function deleteFingerSuratPengangkatan($no_surat_decode)
	{
		// $deleteFingerSuratPengangkatan 		= "	delete from \"Surat\".tpindah_finger
		// 								where 		concat
		// 											(
		// 												no_surat, 
		// 												'/'||kode||'/',
		// 												to_char(created_date, 'MM'), 
		// 												'/', 
		// 												to_char(created_date, 'YY')
		// 											)
		// 								=
		// 									'$no_surat_decode'";
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
