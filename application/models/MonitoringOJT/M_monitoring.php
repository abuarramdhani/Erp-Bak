<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_monitoring extends CI_Model
 	{
 		public function __construct()
	    {
	        parent::__construct();
	        $this->personalia 	=	$this->load->database('personalia', TRUE);
	    }

 		public function ambilDaftarPekerjaOJT($keyword)
 		{
 			$ambilDaftarPekerjaOJT 			= "	select 		pri.noind,
 															pri.nama
												from 		hrd_khs.v_hrd_khs_tpribadi as pri
												where 		pri.keluar=false
															and 	pri.kode_status_kerja='D'
															and 	(
																		pri.nama like '%$keyword%'
																		or 	pri.noind like '%$keyword%'
																	)
												order by 	pri.noind";
			$queryAmbilDaftarPekerjaOJT 	=	$this->personalia->query($ambilDaftarPekerjaOJT);
			return $queryAmbilDaftarPekerjaOJT->result_array();
 		}

 		public function ambilAtasanPekerja($keyword, $pekerjaOJT)
 		{
 			$ambilAtasanPekerja			= "	select 		pri.noind,
														pri.nama,
														rtrim(torg.jabatan) as jabatan,
														(
															case 	when 	rtrim(tseksi.seksi)='-'
																			then 	(
																						case 	when 	rtrim(tseksi.unit)='-'
																										then 	(
																													case 	when 	rtrim(tseksi.bidang)='-'
																																	then 	rtrim(tseksi.dept)
																															else 	rtrim(tseksi.bidang)
																													end
																												)
																								else 	rtrim(tseksi.unit)
																						end
																					)
																	else 	rtrim(tseksi.seksi)
															end
														) as lingkup
											from 		hrd_khs.v_hrd_khs_tpribadi as pri
														join 	hrd_khs.torganisasi as torg
																on 	torg.kd_jabatan=pri.kd_jabatan
														join 	hrd_khs.tseksi as tseksi
																on 	tseksi.kodesie=pri.kodesie
											where 		pri.keluar=false
														and 	pri.noind not in ('Z0000', 'Z1111')
														and 	(
																	pri.noind like '%$keyword%'
																	or 	pri.nama like '%$keyword%'
																)
														and 	(
																	(
																		pri.kodesie
																		=	
																		(
																			select 		concat(substring(pri.kodesie, 1, 1), '00000000')
																			from 		hrd_khs.v_hrd_khs_tpribadi as pri
																			where 	 	pri.noind='$pekerjaOJT'
																		)
																		and 	pri.kd_jabatan
																				<	
																				(
																					select 		pri.kd_jabatan
																					from 		hrd_khs.v_hrd_khs_tpribadi as pri
																					where 	 	pri.noind='$pekerjaOJT'
																				)
																	)
																	or 	(
																			pri.kodesie
																			=
																			(
																				select 		concat(substring(pri.kodesie, 1, 3), '000000')
																				from 		hrd_khs.v_hrd_khs_tpribadi as pri
																				where 	 	pri.noind='$pekerjaOJT'
																			)
																			and 	pri.kd_jabatan
																					<
																					(
																						select 		pri.kd_jabatan
																						from 		hrd_khs.v_hrd_khs_tpribadi as pri
																						where 	 	pri.noind='$pekerjaOJT'
																					)
																		)
																	or 	(
																			pri.kodesie
																			=
																			(
																				select 		concat(substring(pri.kodesie, 1, 5), '0000')
																				from 		hrd_khs.v_hrd_khs_tpribadi as pri
																				where 	 	pri.noind='$pekerjaOJT'
																			)
																			and 	pri.kd_jabatan
																					<
																					(
																						select 		pri.kd_jabatan
																						from 		hrd_khs.v_hrd_khs_tpribadi as pri
																						where 	 	pri.noind='$pekerjaOJT'
																					)
																		)
																	or 	(
																			pri.kodesie
																			=
																			(
																				select 		concat(substring(pri.kodesie, 1, 7), '00')
																				from 		hrd_khs.v_hrd_khs_tpribadi as pri
																				where 	 	pri.noind='$pekerjaOJT'
																			)
																			and 	pri.kd_jabatan
																					<
																					(
																						select 		pri.kd_jabatan
																						from 		hrd_khs.v_hrd_khs_tpribadi as pri
																						where 	 	pri.noind='$pekerjaOJT'
																					)
																		)
																)
											order by 	pri.kd_jabatan asc,
														pri.noind;";
			$queryAmbilAtasanPekerja 	=	$this->personalia->query($ambilAtasanPekerja);
			return $queryAmbilAtasanPekerja->result_array();
 		}

 		public function ambilInfoPekerja($nomor_induk_pekerja)
 		{
 			$this->personalia->select('*');
 			$this->personalia->from('hrd_khs.v_hrd_khs_tpribadi');
 			$this->personalia->where('noind=', $nomor_induk_pekerja);

 			return $this->personalia->get()->result_array();
 		}

 		public function inputPekerjaOJT($inputPekerjaOJT)
 		{
 			$this->db->insert('ojt.tb_pekerja', $inputPekerjaOJT);
 			return $this->db->insert_id();
 		}

 		public function inputPekerjaHistory($inputPekerjaHistory)
 		{
 			$this->db->insert('ojt.tb_pekerja_history', $inputPekerjaHistory);
 		}

 		public function ambilJadwalOrientasi($id_orientasi = FALSE)
 		{
 			$this->db->select('*');
 			$this->db->from('ojt.tb_jadwal');
 			if($id_orientasi != FALSE)
 			{
 				$this->db->where('id_orientasi=', $id_orientasi);
 			}

 			return $this->db->get()->result_array();
 		}

 		public function ambilTanggalOrientasiSebelum($nomor_induk_pekerja, $rujukanOrientasi)
 		{
 			$this->db->select('tgl_akhir');
 			$this->db->from('ojt.tb_proses');
 			$this->db->where('noind=', $nomor_induk_pekerja);
 			$this->db->where('id_orientasi=', $rujukanOrientasi);

 			return $this->db->get()->result_array();
 		}

 		public function ambilIntervalOrientasi($id_orientasi)
 		{
 			$ambilIntervalOrientasi			= "	select 		(
																concat
																(
																	'P',
																	(
																		case 	when 	bulan is not null
																						then 	bulan || 'M'
																				else 	'0M'
																		end
																	),
																	(
																		case 	when 	minggu is not null
																						then 	minggu || 'W'
																				else 	'0W'
																		end
																	),
																	(
																		case 	when 	hari is not null
																						then 	hari || 'D'
																				else 	'0D'
																		end
																	)
																)
															) as interval,
															(
																case 	when 	urutan=true
																				then 0
																		else 	1
																end
															) as invert
												from 		ojt.tb_jadwal as jadwal
												where 		jadwal.id_orientasi=$id_orientasi";
			$queryAmbilIntervalOrientasi	=	$this->db->query($ambilIntervalOrientasi);
			return $queryAmbilIntervalOrientasi->result_array();
 		}

 		public function ambilIntervalAkhirOrientasi($id_orientasi)
 		{
 			$ambilIntervalAkhirOrientasi		= "	select 		concat('P', (orientasi.lama_hari - 1), 'D') as interval
													from 		ojt.tb_orientasi as orientasi
													where 		orientasi.id_orientasi=$id_orientasi";
			$queryIntervalAkhirOrientasi 		=	$this->db->query($ambilIntervalAkhirOrientasi);
			return $queryIntervalAkhirOrientasi->result_array();
 		}

 		public function inputProsesJadwal($inputProsesJadwal)
 		{
 			$this->db->insert('ojt.tb_proses', $inputProsesJadwal);
 			return $this->db->insert_id();
 		}

 		public function inputProsesJadwalHistory($inputProsesJadwalHistory)
 		{
 			$this->db->insert('ojt.tb_proses_history', $inputProsesJadwalHistory);
 		}

 		public function ambilPemberitahuanOrientasi($id_orientasi = FALSE)
 		{
 			$this->db->select('*');
 			$this->db->from('ojt.tb_pemberitahuan');

 			if($id_orientasi !== FALSE)
 			{
 				$this->db->where('id_orientasi=', $id_orientasi);
 			}
 			return $this->db->get()->result_array();
 		}

 		public function inputProsesPemberitahuan($inputProsesPemberitahuan)
 		{
 			$this->db->insert('ojt.tb_proses_pemberitahuan', $inputProsesPemberitahuan);
 			return $this->db->insert_id();
 		}

 		public function inputProsesPemberitahuanHistory($inputProsesPemberitahuanHistory)
 		{
 			$this->db->insert('ojt.tb_proses_pemberitahuan_history', $inputProsesPemberitahuanHistory);
 		}

 		public function ambilTabelDaftarPekerjaOJT()
 		{
 			$this->db->select('*');
 			$this->db->from('ojt.tb_pekerja');

 			return $this->db->get()->result_array();
 		}
 	}