<?php
	class M_rekapriwayatmutasi extends CI_Model
	{
		public function __construct()
	    {
	        parent::__construct();
			$this->personalia = $this->load->database('personalia', TRUE);
	    }

	    public function ambilDaftarPekerja($keyword)
	    {
	    	$ambilDaftarPekerja			= "	select 		tabelpkjaktif.*
											from 		(
															select 		tabelpkj.*,
																		(
																			case 	when 	tabelpkj.keluar=true
																							then 	(
																										case 	when 	(
																															select 		count(*)
																															from 		hrd_khs.v_hrd_khs_tpribadi as pri
																															where 		(
																																			pri.nik=tabelpkj.nik
																																			or 	pri.noind_baru=tabelpkj.noind_baru
																																			or 	(
																																					pri.nama=tabelpkj.nama
																																					and 	pri.templahir=tabelpkj.templahir
																																					and 	pri.tgllahir=tabelpkj.tgllahir
																																				)
																																		)
																																		and 	pri.keluar=false
																														)
																														>
																														0
																														then 	1
																												else  	0
																										end
																									)
																					else 	2
																			end
																			/*
																			 * 	Kode status aktif
																			 * 	2	=>	Noind pekerja masih aktif.
																			 * 	1	=>	Noind pekerja sudah keluar, berubah menjadi noind lain yang aktif.
																			 * 	0	=>	Noind pekerja sudah keluar, sudah benar-benar tidak bekerja lagi.
																			 */
																		) as status_pekerja
															from 		(
																			select 		pri.nik,
																						pri.noind_baru,
																						pri.noind,
																						pri.nama,
																						pri.templahir,
																						pri.tgllahir,
																						pri.keluar
																			from 		hrd_khs.v_hrd_khs_tpribadi as pri
																			where 		(
																							pri.noind like '$keyword%'
																						)
																		) as tabelpkj
														) as tabelpkjaktif
											where 		tabelpkjaktif.status_pekerja in (2, 0)
											order by 	tabelpkjaktif.status_pekerja desc,
														tabelpkjaktif.noind";
			$queryAmbilDaftarPekerja	=	$this->personalia->query($ambilDaftarPekerja);
			return $queryAmbilDaftarPekerja->result_array();
	    }

	    public function ambilDaftarLokasiKerja($keyword)
	    {
	    	$this->personalia->select('*');
	    	$this->personalia->from('hrd_khs.tlokasi_kerja');
	    	$this->personalia->like('lokasi_kerja', $keyword, 'right');
	    	$this->personalia->or_like('id_', $keyword, 'right');
	    	$this->personalia->order_by('id_');
	    	return $this->personalia->get()->result_array();
	    }

		public function ambilDepartemen()
		{
			$ambilDepartemen			= "	select distinct 	substring(tseksi.kodesie,1,1) as kode_departemen,
																rtrim(tseksi.dept) as nama_departemen
											from 				hrd_khs.tseksi as tseksi
											where 				rtrim(tseksi.kodesie)!='-'
																and 	rtrim(tseksi.dept)!='-'
											union
											select 				'0' as kode_departemen,
																'-' as nama_departemen
											order by 			kode_departemen;";
			$queryAmbilDepartemen		=	$this->personalia->query($ambilDepartemen);
			return $queryAmbilDepartemen->result_array();
		}

		public function ambilBidang($departemen)
		{
			$ambilBidang 				= "	select distinct		substring(tseksi.kodesie,1,3) as kode_bidang,
																rtrim(tseksi.bidang) as nama_bidang
											from 				hrd_khs.tseksi as tseksi
											where 				rtrim(tseksi.kodesie)!='-'
																and 	rtrim(tseksi.bidang)!='-'
																and 	substring(tseksi.kodesie,1,1)='$departemen'
											union
											select 				concat('$departemen', '00') as kode_bidang,
																'-' as nama_bidang
											order by 			kode_bidang;";
			$queryAmbilBidang 			=	$this->personalia->query($ambilBidang);
			return $queryAmbilBidang->result_array();
		}

		public function ambilUnit($bidang)
		{
			$ambilUnit			= "	select distinct 	substring(tseksi.kodesie,1,5) as kode_unit,
														rtrim(tseksi.unit) as nama_unit
									from 				hrd_khs.tseksi as tseksi
									where 				rtrim(tseksi.kodesie)!='-'
														and 	rtrim(tseksi.unit)!='-'
														and 	substring(tseksi.kodesie,1,3)='$bidang'
									union
									select 				concat('$bidang', '00') as kode_unit,
														'-' as nama_bidang
									order by 			kode_unit;";
			$queryAmbilUnit 	=	$this->personalia->query($ambilUnit);
			return $queryAmbilUnit->result_array();
		}

		public function ambilSeksi($unit)
		{
			$ambilSeksi			= "	select distinct 	substring(tseksi.kodesie,1,7) as kode_seksi,
														rtrim(tseksi.seksi) as nama_seksi
									from 				hrd_khs.tseksi as tseksi
									where 				rtrim(tseksi.kodesie)!='-'
														and 	rtrim(tseksi.seksi)!='-'
														and 	substring(tseksi.kodesie,1,5)='$unit'
									union
									select 				concat('$unit', '00') as kode_seksi,
														'-' as nama_bidang
									order by 			kode_seksi;";
			$queryAmbilSeksi	=	$this->personalia->query($ambilSeksi);
			return $queryAmbilSeksi->result_array();
		}

		public function ambilRiwayatMutasi($parameterCari)
		{
			$ambilRiwayatMutasi			= "	SELECT distinct	pri.noind as noind,
														pri.nama as nama,
														pri.nik as nik,
														pri.tgllahir as lahir,
														(
															select kes.no_peserta
															from hrd_khs.tbpjskes kes
															where kes.noind = pri.noind
														limit 1) as bpjskes,
														(
															select no_peserta
															from hrd_khs.tbpjstk tk
															where tk.noind = pri.noind
														limit 1) as bpjstk,
														tmutasi.tglberlaku::date,
														(
															select		(
																			case 	when 	rtrim(tseksi.seksi)='-'
																							then 	(
																										case 	when	rtrim(tseksi.unit)='-'
																														then	(
																																	case 	when	rtrim(tseksi.bidang)='-'
																																					then 	concat('Departemen ', tseksi.dept)
																																			else 	concat('Bidang ', tseksi.bidang)
																																	end
																																)
																												else 	concat('Unit ', tseksi.unit)
																										end
																									)
																					else 	concat('Seksi ', tseksi.seksi)
																			end
																		)
															from 		hrd_khs.tseksi as tseksi
															where 		tseksi.kodesie=tmutasi.kodesielm
														limit 1) as seksi_asal,
														(
															select 		tlokasikerja.lokasi_kerja
															from 		hrd_khs.tlokasi_kerja as tlokasikerja
															where 		tlokasikerja.id_=trim(tmutasi.lokasilm)
														limit 1) as lokasi_kerja_asal,
														(
															select		(
																			case 	when 	rtrim(tseksi.seksi)='-'
																							then 	(
																										case 	when	rtrim(tseksi.unit)='-'
																														then	(
																																	case 	when	rtrim(tseksi.bidang)='-'
																																					then 	concat('Departemen ', tseksi.dept)
																																			else 	concat('Bidang ', tseksi.bidang)
																																	end
																																)
																												else 	concat('Unit ', tseksi.unit)
																										end
																									)
																					else 	concat('Seksi ', tseksi.seksi)
																			end
																		)
															from 		hrd_khs.tseksi as tseksi
															where 		tseksi.kodesie=tmutasi.kodesiebr
														limit 1) as seksi_baru,
														(
															select 		tlokasikerja.lokasi_kerja
															from 		hrd_khs.tlokasi_kerja as tlokasikerja
															where 		tlokasikerja.id_=trim(tmutasi.lokasibr)
														limit 1) as lokasi_kerja_baru
											from 		hrd_khs.tmutasi as tmutasi
														join 	hrd_khs.v_hrd_khs_tpribadi as pri
																on 	pri.noind=tmutasi.noind
											$parameterCari
											order by 	tmutasi.tglberlaku::date desc";
			$queryAmbilRiwayatMutasi 	=	$this->personalia->query($ambilRiwayatMutasi);
			return $queryAmbilRiwayatMutasi->result_array();
		}

		public function ambilRiwayatPekerja($nomorInduk)
		{
		 	$ambilRiwayatPekerja		= "	select 		pri.nik,
														pri.noind_baru,
														pri.noind,
														pri.nama,
														pri.templahir,
														pri.tgllahir,
														pri.keluar
											from 		(
															select 		pri.nik,
																		pri.noind_baru,
																		pri.noind as noind_riwayat,
																		pri.nama,
																		pri.templahir,
																		pri.tgllahir,
																		pri.keluar
															from 		hrd_khs.v_hrd_khs_tpribadi as pri
															where 		pri.noind='$nomorInduk'
														) as tabelmaster
														join 	hrd_khs.v_hrd_khs_tpribadi as pri
																	on 	(
																			tabelmaster.nik=pri.nik
																			or 	tabelmaster.noind_baru=pri.noind_baru
																			or 	(
																					tabelmaster.nama=pri.nama
																					and 	tabelmaster.templahir=pri.templahir
																					and 	tabelmaster.tgllahir=pri.tgllahir
																				)
																		)";
			$queryAmbilRiwayatPekerja	=	$this->personalia->query($ambilRiwayatPekerja);
			return $queryAmbilRiwayatPekerja->result_array();
		}
	}
?>
