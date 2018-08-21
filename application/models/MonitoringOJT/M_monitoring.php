<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_monitoring extends CI_Model
 	{
 		public function __construct()
	    {
	        parent::__construct();
	        $this->personalia 	=	$this->load->database('personalia', TRUE);
	    }

 		public function ambilDaftarPekerjaOJT($keyword, $pekerjaOJTAktif)
 		{
 			$klausaOJTAktif 	=	'';
 			if(!(empty($pekerjaOJTAktif)))
 			{
 				$klausaOJTAktif 	=	'and 	pri.noind not in ('.$pekerjaOJTAktif.')';
 			}
 			$ambilDaftarPekerjaOJT 			= "	select 		pri.noind,
 															pri.nama
												from 		hrd_khs.v_hrd_khs_tpribadi as pri
												where 		pri.keluar=false
															and 	pri.kode_status_kerja in ('D', 'J')
															and 	(
																		pri.nama like '%$keyword%'
																		or 	pri.noind like '%$keyword%'
																	)
															$klausaOJTAktif
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
											order by 	pri.kd_jabatan asc,
														pri.noind;";
			$queryAmbilAtasanPekerja 	=	$this->personalia->query($ambilAtasanPekerja);
			return $queryAmbilAtasanPekerja->result_array();
 		}

 		public function ambilInfoPekerja($nomor_induk_pekerja = FALSE)
 		{
 			$this->personalia->select('*');
 			$this->personalia->from('hrd_khs.v_hrd_khs_tpribadi');

 			if($nomor_induk_pekerja !== FALSE)
 			{
 				$this->personalia->where('noind=', $nomor_induk_pekerja);
 			}

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
																	(
																		case 	when 	bulan is not null
																						then 	bulan || ' month '
																				else 	'0 month '
																		end
																	),
																	(
																		case 	when 	hari is not null
																						or 	minggu is not null
																						then 	((coalesce(minggu, 0)*7)+coalesce(hari, 0)) || ' day '
																				else 	'0 day'
																		end
																	)
																)
															) as interval,
															(
																case 	when 	urutan=true
																				then '+'
																		else 	'-'
																end
															) as operator
												from 		ojt.tb_jadwal as jadwal
												where 		jadwal.id_orientasi=$id_orientasi";
			$queryAmbilIntervalOrientasi	=	$this->db->query($ambilIntervalOrientasi);
			return $queryAmbilIntervalOrientasi->result_array();
 		}

 		public function ambilIntervalAkhirOrientasi($id_orientasi)
 		{
 			$ambilIntervalAkhirOrientasi		= "	select 		concat((orientasi.lama_hari - 1), ' day ') as interval
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
 			$ambilTabelDaftarPekerjaOJT 		= "	select 		pekerja_ojt.*,
 																pekerja_ojt.noind nomor_induk_pekerja_ojt,
 																pekerja_psn.employee_name nama_pekerja_ojt,
 																pekerja_psn.section_code,
 																seksi_psn.section_name seksi_pekerja_ojt,
 																pekerja_ojt.atasan nomor_induk_atasan_pekerja,
 																pekerja_psn_2.employee_name nama_atasan_pekerja,
 																(
 																	select 		max(proses_ojt.tgl_akhir)
 																	from 		ojt.tb_proses proses_ojt
 																	where 		proses_ojt.noind = pekerja_ojt.noind
 																) as tgl_selesai
 													from 		ojt.tb_pekerja pekerja_ojt
 																join 	er.er_employee_all pekerja_psn
 																		on 	pekerja_psn.employee_code = pekerja_ojt.noind
 																join 	er.er_section seksi_psn
 																		on 	seksi_psn.section_code = pekerja_psn.section_code
 																join 	er.er_employee_all pekerja_psn_2
 																		on 	pekerja_psn_2.employee_code = pekerja_ojt.atasan
 																join 	er.er_section seksi_psn_2
 																		on 	seksi_psn_2.section_code = pekerja_psn_2.section_code";

 			if($pekerja_id !== FALSE)
 			{
 				$ambilTabelDaftarPekerjaOJT 	.= "	where 	pekerja_ojt.pekerja_id = '".$pekerja_id."'";
 			}

 			$ambilTabelDaftarPekerjaOJT 	.= "	order by  	pekerja_ojt.tgl_masuk desc,
 																pekerja_ojt.noind desc";

 			return $this->db->query($ambilTabelDaftarPekerjaOJT)->result_array();
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

 		public function ambilPekerjaAktifOJT()
 		{
 			$this->db->distinct('noind');
 			return $this->db->get('ojt.tb_pekerja')->result_array();
 		}

 		public function hitungTanggalPostgre($tanggal, $interval, $operator)
 		{
 			$hitungTanggalPostgre 		= "	select 	'$tanggal'::date $operator interval '$interval' as result";
 			$queryHitungTanggalPostgre	=	$this->db->query($hitungTanggalPostgre);
 			return $queryHitungTanggalPostgre->result_array();
 		}

 		public function ubahPekerjaKeluar($pekerjaKeluar, $pekerja_id)
 		{
 			$this->db->where('pekerja_id=', $pekerja_id);
 			$this->db->update('ojt.tb_pekerja', $pekerjaKeluar);
 		}

 		public function updateEmail($updateEmail, $pekerja_id)
 		{
 			$this->db->where('pekerja_id=', $pekerja_id);
 			$this->db->update('ojt.tb_pekerja', $updateEmail);
 		}

 		public function proses_delete($id_proses)
 		{
 			$this->db->where('id_proses =', $id_proses);
 			$this->db->delete('ojt.tb_proses');
 		}

 		public function notifikasi_harian()
 		{
 			$this->db->select('	proses_pemberitahuan.id_proses_pemberitahuan,
 								proses_pemberitahuan.tanggal tanggal_pemberitahuan,
 								proses.id_proses,
 								pekerja.noind,
 								pekerja_psn.employee_name,
 								proses.tahapan,
 								proses.tgl_awal tanggal_proses_awal,
 								proses.tgl_akhir tanggal_proses_akhir
 								');

 			$this->db->from('ojt.tb_proses_pemberitahuan proses_pemberitahuan');
 			$this->db->join('ojt.tb_proses proses', 'proses.id_proses = proses_pemberitahuan.id_proses', 'left');
 			$this->db->join('ojt.tb_pekerja pekerja', 'pekerja.noind = proses.noind', 'left');
 			$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja.noind', 'left');


 			$this->db->where('proses_pemberitahuan.tujuan =', 1);
 			$this->db->where('proses_pemberitahuan.selesai =', FALSE);
 			$this->db->where('proses_pemberitahuan.tanggal =', date('Y-m-d'));

 			$this->db->order_by('proses_pemberitahuan.tanggal', 'desc');
 			$this->db->order_by('proses.tgl_akhir', 'desc');
 			$this->db->order_by('proses.tgl_awal', 'desc'); 			

 			return $this->db->get()->result_array();
 		}

 		public function rekap_kegiatan_harian($tanggal_rekap)
 		{
 			if ( empty($tanggal_rekap) )
 			{
 				$tanggal_rekap 	=	"current_date";
 			}
 			else
 			{
 				$tanggal_rekap 	=	"'".$tanggal_rekap."'";
 			}

 			$rekap_kegiatan_harian		= "	select 		proses.id_orientasi,
														orientasi.tahapan,
														count(proses.id_proses) as jumlah
											from 		ojt.tb_proses as proses
														join 	ojt.tb_orientasi as orientasi
																on 	orientasi.id_orientasi=proses.id_orientasi
											where 		$tanggal_rekap between proses.tgl_awal and proses.tgl_akhir
											group by 	proses.id_orientasi,
														orientasi.tahapan;";
			$query 						=	$this->db->query($rekap_kegiatan_harian);
			return $query->result_array();
 		}

 		public function proses_selesai($proses_selesai, $id_proses)
 		{
 			$this->db->where('id_proses=', $id_proses);
 			$this->db->update('ojt.tb_proses', $proses_selesai);
 		}

 		public function pekerja_selesai($pekerja_selesai, $pekerja_id)
 		{
 			$this->db->where('pekerja_id=', $pekerja_id);
 			$this->db->update('ojt.tb_pekerja', $pekerja_selesai);
 		}

 		public function pemberitahuan_selesai($pemberitahuan_selesai, $id_proses)
 		{
 			$this->db->where('id_proses=', $id_proses);
 			$this->db->update('ojt.tb_proses_pemberitahuan', $pemberitahuan_selesai);
 		}

 		public function proses_berjalan()
 		{
 			$proses_berjalan		= "	select 		pekerja.pekerja_id,
													pekerja.noind,
													proses.id_proses,
													proses.tahapan,
													proses.tgl_awal,
													proses.tgl_akhir,
													(
														case 	when 	proses.selesai=true
																		then 	1
																else 	0
														end
													) as selesai,
													(
														case 	when 	current_date>proses.tgl_akhir
																		and 	proses.selesai=false
																		then 	1
																else 	0
														end
													) as overdue
										from 		ojt.tb_proses as proses
													join 	ojt.tb_pekerja as pekerja
															on 	pekerja.noind=proses.noind
										where 		pekerja.selesai=false
													and 	pekerja.keluar=false
													and 	(
																current_date between proses.tgl_awal and proses.tgl_akhir
																or 	(
																		proses.selesai=false
																		and 	current_date>=proses.tgl_awal
																	)
															)
										order by 	pekerja.noind,
													proses.tgl_awal;";
			$query_proses_berjalan	=	$this->db->query($proses_berjalan);
			return $query_proses_berjalan->result_array();
 		}

 		public function history($schema_name, $table_name, $history)
 		{
 			$this->db->insert($schema_name.".".$table_name."_history", $history);
 		}

 		public function daftar_pekerja_ojt($keyword, $periode_awal = FALSE, $periode_akhir = FALSE)
 		{
 			$this->db->select('
 								pekerja_ojt.*,
 								rtrim(pekerja_psn.employee_name) nama,

 							');
 			$this->db->from('ojt.tb_pekerja pekerja_ojt');
 			$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja_ojt.noind');
 			$this->db->join('er.er_section seksi_psn', 'seksi_psn.section_code = pekerja_psn.section_code');

 			$this->db->like('pekerja_ojt.noind', $keyword);
	 		$this->db->or_like('pekerja_psn.employee_name', $keyword);

	 		if ( $periode_awal !== FALSE AND $periode_akhir !== FALSE )
	 		{
	 			$this->db->group_start();
		 			$this->db->where('pekerja_ojt.tgl_masuk >=', $periode_awal);
		 			$this->db->where('pekerja_ojt.tgl_masuk <=', $periode_akhir);
	 			$this->db->group_end();
	 		}

 			return $this->db->get()->result_array();
 		}

 		public function tahapan_pekerja_ojt($keyword = FALSE, $id_pekerja = FALSE, $id_proses = FALSE)
 		{
 			$this->db->select('proses_ojt.*');
 			$this->db->from('ojt.tb_proses proses_ojt');
 			$this->db->join('ojt.tb_pekerja pekerja_ojt', 'pekerja_ojt.noind = proses_ojt.noind');

 			if ( $keyword !== FALSE )
 			{
	 			$this->db->like('proses_ojt.tahapan', $keyword);
 			}

 			if ( $id_pekerja !== FALSE )
 			{
 				
 				$this->db->where('pekerja_ojt.pekerja_id =', $id_pekerja);
 			}

 			if ( $id_proses !== FALSE )
 			{
 				$this->db->where('proses_ojt.id_proses =', $id_proses);
 			}

 			return $this->db->get()->result_array();
 		}

 		public function join($id_orientasi,$tanggal_rekap)
 		{
 			// $tahapan = "'".$tahapan."'";
 			// $id_orientasi = "'".$id_orientasi."'";
 			// echo $tahapan.'-'.$id_orientasi; exit();
 			$tanggal_rekap = "'".$tanggal_rekap."'";
 			$query = $this->db->query('select pro.noind, pro.id_orientasi, ori.tahapan, er.employee_name from ojt.tb_proses pro
									left join ojt.tb_orientasi ori on ori.id_orientasi = pro.id_orientasi
									left join er.er_employee_all er on er.employee_code = pro.noind
									where pro.id_orientasi = '.$id_orientasi.' and '.$tanggal_rekap.'
									between pro.tgl_awal and pro.tgl_akhir');
 			// return $query->result_array();

			return $query->result_array();
 		}
 		public function testing($id_orientasi)
 		{
 			echo $id_orientasi;
 			$query = $this->db->query('select pro.noind, pro.id_orientasi, ori.tahapan, er.employee_name from ojt.tb_proses pro
									left join ojt.tb_orientasi ori on ori.id_orientasi = pro.id_orientasi
									left join er.er_employee_all er on er.employee_code = pro.noind
									where pro.id_orientasi = '.$id_orientasi.' and current_date 
									between pro.tgl_awal and pro.tgl_akhir');
 			return $query->result_array();
 		}
 	}