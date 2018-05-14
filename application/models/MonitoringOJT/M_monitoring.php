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
															and 	pri.kode_status_kerja in ('D', 'J')
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
														join 	hrd_khs.trefjabatan as trefjabatan
																on 	trefjabatan.noind=pri.noind
														join 	hrd_khs.tseksi as tseksi
																on 	tseksi.kodesie=trefjabatan.kodesie
											where 		pri.keluar=false
														and 	pri.noind not in ('Z0000', 'Z1111')
														and 	(
																	pri.noind like '%$keyword%'
																	or 	pri.nama like '%$keyword%'
																)
														and 	trim(trefjabatan.kd_jabatan) not in ('', '-')
														and 	trefjabatan.kd_jabatan::int < 14
														/*and 	(
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
																)*/
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
																		case 	when 	hari is not null
																						or 	minggu is not null
																						then 	((coalesce(minggu, 0)*7)+coalesce(hari, 0)) || 'D'
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

 		public function ambilTabelDaftarPekerjaOJT($pekerja_id = FALSE)
 		{
 			$this->db->select('
 								ojt.tb_pekerja.*,
 								er.er_employee_all.employee_name
 							');
 			$this->db->from('ojt.tb_pekerja');
 			$this->db->join('er.er_employee_all', 'er.er_employee_all.employee_code = ojt.tb_pekerja.noind');

 			if($pekerja_id !== FALSE)
 			{
 				$this->db->where('ojt.tb_pekerja.pekerja_id=', $pekerja_id);
 			}

 			return $this->db->get()->result_array();
 		}

 		public function ambilPenjadwalanManual($pekerja_id)
 		{
 			$ambilPenjadwalanManual 		= "	select 		jadwal.*
												from 		ojt.tb_proses as jadwal
															join 	ojt.tb_pekerja as pekerja
																	on 	pekerja.noind=jadwal.noind
															join 	ojt.tb_orientasi as orientasi
																	on 	orientasi.id_orientasi=jadwal.id_orientasi
												where 		pekerja.pekerja_id=$pekerja_id
															/*and 	orientasi.ck_tgl=false*/
															/*and 	(
																		orientasi.periode!=1
																		and 	orientasi.sequence!=1
																	)*/
												order by 	jadwal.periode,
															jadwal.sequence;";
			$queryAmbilPenjadwalanManual 	=	$this->db->query($ambilPenjadwalanManual);
			return $queryAmbilPenjadwalanManual->result_array();
 		}

 		public function updateProses($updateProses, $id_proses)
 		{
 			$this->db->where('id_proses=', $id_proses);
 			$this->db->update('ojt.tb_proses', $updateProses);
 		}

 		public function ambilProses($id_proses)
 		{
 			$this->db->select('*');
 			$this->db->from('ojt.tb_proses');
 			$this->db->where('id_proses=', $id_proses);
 			return $this->db->get()->result_array();
 		}

 		public function cekProsesPemberitahuan($id_proses)
 		{
 			$this->db->select('*');
 			$this->db->from('ojt.tb_proses_pemberitahuan');
 			$this->db->where('id_proses=', $id_proses);
 			return $this->db->get()->result_array();
 		}

 		public function deleteProsesPemberitahuan($id_proses_pemberitahuan)
 		{
 			$this->db->where('id_proses_pemberitahuan=', $id_proses_pemberitahuan);
 			$this->db->delete('ojt.tb_proses_pemberitahuan');
 		}
 	}