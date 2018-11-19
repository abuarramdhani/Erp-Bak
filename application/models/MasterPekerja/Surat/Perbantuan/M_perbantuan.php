<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_perbantuan extends CI_Model
	{
    	public function __construct()
	    {
	       parent::__construct();
	       $this->personalia 	= 	$this->load->database('personalia', TRUE);
	    }

		public function getAmbilPekerjaAktif()
		{
			$getAmbilPekerjaAktif= "select trim(noind) as noind, concat_ws(' - ', noind, nama) as pekerja from hrd_khs.tpribadi where keluar=false
			order by noind ";
			$query 	=	$this->personalia->query($getAmbilPekerjaAktif);
			return $query->result_array();
		}
		public function getSeksi()
		{
			$getSeksi="select 		trim(kodesie) as kodesie,
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
	 		$DetailPekerjaan= "select  kdpekerjaan as kd,concat_ws(' - ', kdpekerjaan, pekerjaan) as pekerjaan  from hrd_khs.tpekerjaan where kdpekerjaan like '%'";
	 		 // $DetailPekerjaan= "select  kdpekerjaan as kd,concat_ws(' - ', kdpekerjaan, pekerjaan) as pekerjaan  from hrd_khs.tpekerjaan";
   			$query 	=	$this->personalia->query($DetailPekerjaan);
			return $query->result_array();	
			 // return $DetailPekerjaan;
	 	}

	 	public function DetailGolongan()
	 	{
	 		$DetailGolongan= "select DISTINCT golkerja from hrd_khs.tpribadi where keluar='0'order by golkerja";

			$query 	=	$this->personalia->query($DetailGolongan);
			return $query->result_array();	
	 	}

	 	public function DetailLokasiKerja()
	 	{
	 		$DetailLokasiKerja= "select id_ as kode_lokasi, lokasi_kerja as nama_lokasi,concat_ws(' - ', id_, lokasi_kerja) as lokasi  from hrd_khs.tlokasi_kerja order by id_";

			$query 	=	$this->personalia->query($DetailLokasiKerja);
			return $query->result_array();	
			 //return $DetailLokasiKerja;
	 	}

	 	public function DetailKdJabatan()
	 	{
	 		$DetailKdJabatan= "select kd_jabatan as kd_jabatan , jabatan as jabatan from hrd_khs.torganisasi";
			$query 	=	$this->personalia->query($DetailKdJabatan);
			return $query->result_array();	
			// return $DetailKdJabatan;
	 	}

	 	public function DetailTempatMakan1()
	 	{
	 		$DetailTempatMakan1= "select distinct tempat_makan1 as tempat_makan1 from hrd_khs.tpribadi where keluar='false'";
			$query 	=	$this->personalia->query($DetailTempatMakan1);
			return $query->result_array();	
			// return $DetailKdJabatan;
	 	}

	 	public function DetailTempatMakan2()
	 	{
	 		$DetailTempatMakan2= "select distinct tempat_makan2 as tempat_makan2 from hrd_khs.tpribadi where keluar='false'";
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
	 		$pencarianseksi =" select 		trim(kodesie) as kodesie,
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

	 	public function ambilLayoutSuratPerbantuan()
	 	{
	 		$this->personalia->select('isi_surat');
	 		$this->personalia->from('"Surat".tisi_surat"');
	 		$this->personalia->where('jenis_surat=', 'PERBANTUAN');

	 		return $this->personalia->get()->result_array();
	 	}

	 	public function ambilNomorSuratPerbantuanTerakhir($parameterTahunBulanPerbantuan, $kodeSurat)
	 	{
	 		$ambilNomorSuratPerbantuanTerakhir 		= "	select 		max(arsipsurat.nomor_surat) as jumlah
													from 		\"Surat\".t_arsip_kode_surat as arsipsurat
													where 		arsipsurat.bulan_surat='$parameterTahunBulanPerbantuan'
																and 	arsipsurat.kode_surat='$kodeSurat'";
			$query 		= 	$this->personalia->query($ambilNomorSuratPerbantuanTerakhir);
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

	 	public function inputSuratPerbantuan($inputSuratPerbantuan)
	 	{
	 		$this->personalia->insert('"Surat".tsurat_perbantuan', $inputSuratPerbantuan);
	 	}

	 	public function ambilDaftarSuratPerbantuan()
	 	{
	 		$ambilDaftarSuratPerbantuan 		= "	select 		concat
															(
																perbantuan.no_surat, 
																'/'||perbantuan.kode||'/', 
																to_char(perbantuan.tanggal_cetak, 'MM'), 
																'/', 
																to_char(perbantuan.tanggal_cetak, 'YY')
															) as no_surat,
															perbantuan.tanggal_mulai_perbantuan::date as tanggal_mulai_perbantuan,
															perbantuan.tanggal_selesai_perbantuan::date as tanggal_selesai_perbantuan,
															perbantuan.noind,
															perbantuan.nama,
															concat_ws
															(
																' - ',
																perbantuan.kodesie_lama,
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
																	where 		tseksi.kodesie=perbantuan.kodesie_lama
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=perbantuan.kodesie_lama
																)
															) as seksi_lama,
															concat_ws
															(
																' - ',
																perbantuan.kodesie_baru,
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
																	where 		tseksi.kodesie=perbantuan.kodesie_baru
																),
																(
																	select		case 	when 	rtrim(pekerjaan)!='-'
																								then 	rtrim(pekerjaan)
																				end
																	from 		hrd_khs.tseksi as tseksi
																	where 		tseksi.kodesie=perbantuan.kodesie_baru
																)
															) as seksi_baru,
															concat_ws
															(
																' - ',
																perbantuan.lokasi_kerja_lama,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=perbantuan.lokasi_kerja_lama
																)
															) as lokasi_kerja_lama,
															concat_ws
															(
																' - ',
																perbantuan.lokasi_kerja_baru,
																(
																	select 		lokker.lokasi_kerja
																	from 		hrd_khs.tlokasi_kerja as lokker
																	where 		lokker.id_=perbantuan.lokasi_kerja_baru
																)
															) as lokasi_kerja_baru,
															perbantuan.tanggal_cetak::date,
															perbantuan.cetak
												from 		\"Surat\".tsurat_perbantuan as perbantuan";
			$query 					=	$this->personalia->query($ambilDaftarSuratPerbantuan);
			return $query->result_array();
	 	}

	 	public function ambilIsiSuratPerbantuan($no_surat_decode)
	 	{
	 		$ambilIsiSuratPerbantuan 		= "	select 		perbantuan.isi_surat
											from 		\"Surat\".tsurat_perbantuan as perbantuan
											where 	 	concat
														(
															perbantuan.no_surat, 
															'/'||perbantuan.kode||'/', 
															to_char(perbantuan.tanggal_cetak, 'MM'), 
															'/', 
															to_char(perbantuan.tanggal_cetak, 'YY')
														)
														=
														'$no_surat_decode'";
			$query 						=	$this->personalia->query($ambilIsiSuratPerbantuan);
			return $query->result_array();
	 	}

	 	public function deleteSuratPerbantuan($no_surat_decode)
	 	{
	 		$deleteSuratPerbantuan 		= "	delete from \"Surat\".tsurat_perbantuan
	 									where 		concat
													(
														no_surat, 
														'/'||kode||'/',
														to_char(tanggal_cetak, 'MM'), 
														'/', 
														to_char(tanggal_cetak, 'YY')
													)
										=
											'$no_surat_decode'";
			$query 					=	$this->personalia->query($deleteSuratPerbantuan);
	 	}
	 		 	public function deleteArsipSuratPerbantuan($bulan_surat, $kode_surat, $no_surat)
	 	{
	 		$this->personalia->where('bulan_surat=', $bulan_surat);
	 		$this->personalia->where('kode_surat=', $kode_surat);
	 		$this->personalia->where('nomor_surat=', $no_surat);
	 		$this->personalia->delete('"Surat".t_arsip_kode_surat');
	 	}

	 	public function editSuratPerbantuan($no_surat_decode)
	 	{
	 		$editSuratPerbantuan 		= "	select 		perbantuan.kode,
													perbantuan.no_surat,
													perbantuan.hal_surat,
													perbantuan.nama,
													perbantuan.noind,
													perbantuan.kodesie_lama,
													perbantuan.kodesie_baru,
															concat_ws
																									(
																										' - ',
																										perbantuan.kodesie_lama,
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
																											where 		tseksi.kodesie=perbantuan.kodesie_lama
																										),
																										(
																											select		case 	when 	rtrim(pekerjaan)!='-'
																																		then 	rtrim(pekerjaan)
																														end
																											from 		hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=perbantuan.kodesie_lama
																										)
																									) as seksi_lama,
															concat_ws
																									(
																										' - ',
																										perbantuan.kodesie_baru,
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
																											where 		tseksi.kodesie=perbantuan.kodesie_baru
																										),
																										(
																											select		case 	when 	rtrim(pekerjaan)!='-'
																																		then 	rtrim(pekerjaan)
																														end
																											from 		hrd_khs.tseksi as tseksi
																											where 		tseksi.kodesie=perbantuan.kodesie_baru
																										)
																									) as seksi_baru,
													perbantuan.tempat_makan_1_lama,
													perbantuan.tempat_makan_1_baru,
													perbantuan.lokasi_kerja_lama,
													perbantuan.lokasi_kerja_baru,
													concat_ws
																									(
																										' - ',
																										perbantuan.lokasi_kerja_lama,
																										(
																											select 		lokker.lokasi_kerja
																											from 		hrd_khs.tlokasi_kerja as lokker
																											where 		lokker.id_=perbantuan.lokasi_kerja_lama
																										)
																									) as lokasi_lama,
																									concat_ws
																									(
																										' - ',
																										perbantuan.lokasi_kerja_baru,
																										(
																											select 		lokker.lokasi_kerja
																											from 		hrd_khs.tlokasi_kerja as lokker
																											where 		lokker.id_=perbantuan.lokasi_kerja_baru
																										)
																									) as lokasi_baru,
													perbantuan.golkerja_lama,
													perbantuan.golkerja_baru,
													perbantuan.kd_jabatan_lama,
													perbantuan.kd_jabatan_baru,
													perbantuan.tanggal_mulai_perbantuan,
													perbantuan.tanggal_selesai_perbantuan,
													perbantuan.isi_surat,
													perbantuan.cetak,
													perbantuan.tanggal_cetak,
													perbantuan.noind_baru,
													perbantuan.jabatan_lama,
													perbantuan.jabatan_baru,
													(select jabatan
													from hrd_khs.torganisasi as torg
													where torg.kd_jabatan=perbantuan.kd_jabatan_baru
													)as jabatann,
													perbantuan.tempat_makan_2_lama,
													perbantuan.tempat_makan_2_baru,
													perbantuan.kd_pkj_lama,
													perbantuan.kd_pkj_baru,
										            (select pekerjaan
													from hrd_khs.tpekerjaan as pek
													where pek.kdpekerjaan=perbantuan.kd_pkj_lama
													)as pekerjaan_lama,
													(select pekerjaan
													from hrd_khs.tpekerjaan as pek
													where pek.kdpekerjaan=perbantuan.kd_pkj_baru
													)as pekerjaan_baru,
													(
														case 	when 	perbantuan.kd_jabatan_lama::numeric<17
																		then 	'STAF'
																else 	'NONSTAF'
														end
													) as status_staf
										from 		\"Surat\".tsurat_perbantuan as perbantuan
										where 		concat
													(
														perbantuan.no_surat,
														'/' || perbantuan.kode || '/',
														to_char(perbantuan.tanggal_cetak, 'MM'),
														'/',
														to_char(perbantuan.tanggal_cetak, 'yy')
													)
													=
													'$no_surat_decode';";
			$query 			=	$this->personalia->query($editSuratPerbantuan);
			return $query->result_array();
	 	}

	 	public function updateSuratPerbantuan($updateSuratPerbantuan, $nomor_surat, $kodeSurat)
	 	{
	 		$this->personalia->where('no_surat=', $nomor_surat);
	 		$this->personalia->where('kode=', $kodeSurat);
	 		$this->personalia->update('"Surat".tsurat_perbantuan', $updateSuratPerbantuan);
	 	}
	 	public function inputNomorSurat($inputNomorSurat)
	 	{
	 		$this->personalia->insert('"Surat".t_arsip_kode_surat', $inputNomorSurat);
	 	}
 	}

