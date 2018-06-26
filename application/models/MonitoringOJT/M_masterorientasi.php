<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_masterorientasi extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	    }

	    public function ambilDaftarOrientasi()
	    {
	    	$this->db->select('id_orientasi, tahapan');
	    	$this->db->from('ojt.tb_orientasi');

	    	return $this->db->get()->result_array();
	    }

	    public function inputOrientasi($inputOrientasi)
	    {
	    	$this->db->insert('ojt.tb_orientasi', $inputOrientasi);
	    	return $this->db->insert_id();
	    }

	    public function inputOrientasiHistory($inputOrientasiHistory)
	    {
	    	$this->db->insert('ojt.tb_orientasi_history', $inputOrientasiHistory);
	    }

	    public function inputJadwal($inputJadwal)
	    {
	    	$this->db->insert('ojt.tb_jadwal', $inputJadwal);
	    	return $this->db->insert_id();
	    }

	    public function inputJadwalHistory($inputJadwalHistory)
	    {
	    	$this->db->insert('ojt.tb_jadwal_history', $inputJadwalHistory);
	    }

	    public function inputPemberitahuan($inputPemberitahuan)
	    {
	    	$this->db->insert('ojt.tb_pemberitahuan', $inputPemberitahuan);
	    	return $this->db->insert_id();
	    }

	    public function inputPemberitahuanHistory($inputPemberitahuanHistory)
	    {
	    	$this->db->insert('ojt.tb_pemberitahuan_history', $inputPemberitahuanHistory);
	    }

	    public function inputUndangan($inputUndangan)
	    {
	    	$this->db->insert('ojt.tb_berkas', $inputUndangan);
	    	return $this->db->insert_id();
	    }

	    public function inputUndanganHistory($inputUndanganHistory)
	    {
	    	$this->db->insert('ojt.tb_berkas_history', $inputUndanganHistory);
	    }

	    public function ambilDaftarOrientasiTabel($id_orientasi = FALSE, $input_order = FALSE, $id_orientasi_in_array = FALSE)
	    {
	    	$this->db->select('*');
		    $this->db->from('ojt.tb_orientasi');
		    if($id_orientasi !== FALSE) 
		    {
		    	$this->db->where('id_orientasi=', $id_orientasi);
		    }
		    elseif($id_orientasi_in_array !== FALSE)
		    {
		    	$this->db->where_in('id_orientasi', $id_orientasi_in_array);
		    }

		    if($input_order !== FALSE)
		    {
		    	$this->db->order_by('id_orientasi');
		    }
		    else
		    {
		    	$this->db->order_by('periode, sequence');
		    }
	    	return $this->db->get()->result_array();
	    }

	    public function ambilDaftarPemberitahuanTabelOrientasi()
	    {
	    	$ambilDaftarPemberitahuanTabelOrientasi 		= "	select 		pemberitahuan.id_orientasi,
																			(
																				case 	when 	pemberitahuan.penerima='1'
																								then 	'People Development'
																						when 	pemberitahuan.penerima='2'
																								then 	'Pekerja'
																						when 	pemberitahuan.penerima='3'
																								then 	'Atasan Pekerja'
																				end
																			) as penerima,
																			concat
																			(
																			 	(
																			 		case 	when 	pemberitahuan.hari is not null
																			 						then 	'Hari H'
																			 				when 	pemberitahuan.minggu is not null
																			 						then 	'Minggu M'
																			 				when 	pemberitahuan.bulan is not null
																			 						then 	'Bulan B'
																			 		end
																			 	),
																			 	(
																			 		case 	when 	(
																			 							(
																			 								pemberitahuan.hari is not null
																			 								and 	pemberitahuan.hari!=0
																			 							) 
																			 							or 	(
																			 									pemberitahuan.minggu is not null
																			 									and 	pemberitahuan.minggu!=0
																			 								) 
																			 							or 	(
																			 									pemberitahuan.bulan is not null
																			 									and 	pemberitahuan.bulan!=0
																			 								)
																			 						)
																					 				then 	(
																					 							case 	when 	pemberitahuan.urutan=false
																					 											then 	concat
																					 													(
																					 														'-',
																					 														(
																					 															case 	when 	pemberitahuan.hari is not null
																					 																			then 	pemberitahuan.hari
																					 																	when 	pemberitahuan.minggu is not null
																					 																			then 	pemberitahuan.minggu
																					 																	when 	pemberitahuan.bulan is not null
																					 																			then 	pemberitahuan.bulan
																					 															end
																					 														)
																					 													)
																					 									else 	concat
																					 											(
																					 												'+',
																					 												(
																					 													case 	when 	pemberitahuan.hari is not null
																					 																	then 	pemberitahuan.hari
																					 															when 	pemberitahuan.minggu is not null
																					 																	then 	pemberitahuan.minggu
																					 															when 	pemberitahuan.bulan is not null
																					 																	then 	pemberitahuan.bulan
																					 													end
																					 												)
																					 											)
																					 							end
																					 						)
																					 		when 	(
																					 					pemberitahuan.hari=0
																					 					or 	pemberitahuan.minggu=0
																					 					or 	pemberitahuan.bulan=0
																					 				)
																					 		then 	''
																					 end
																			 	)
																			) as waktu
																from 		ojt.tb_pemberitahuan as pemberitahuan";
			$queryAmbilDaftarPemberitahuanTabelOrientasi	=	$this->db->query($ambilDaftarPemberitahuanTabelOrientasi);
			return $queryAmbilDaftarPemberitahuanTabelOrientasi->result_array();
	    }

	    public function ambilDaftarPemberitahuanTabelJadwal()
	    {
	    	$ambilDaftarPemberitahuanTabelJadwal 		= "	select 		jadwal.id_orientasi,
																		(
																			select 		orientasi.tahapan
																			from 		ojt.tb_orientasi as orientasi
																			where 		orientasi.id_orientasi=jadwal.tujuan
																		) as penerima,
																		concat
																		(
																		 	(
																		 		case 	when 	jadwal.hari is not null
																		 						then 	'Hari H'
																		 				when 	jadwal.minggu is not null
																		 						then 	'Minggu M'
																		 				when 	jadwal.bulan is not null
																		 						then 	'Bulan B'
																		 		end
																		 	),
																		 	(
																		 		case 	when 	(
																		 							(
																		 								jadwal.hari is not null
																		 								and 	jadwal.hari!=0
																		 							) 
																		 							or 	(
																		 									jadwal.minggu is not null
																		 									and 	jadwal.minggu!=0
																		 								) 
																		 							or 	(
																		 									jadwal.bulan is not null
																		 									and 	jadwal.bulan!=0
																		 								)
																		 						)
																				 				then 	(
																				 							case 	when 	jadwal.urutan=false
																				 											then 	concat
																				 													(
																				 														'-',
																				 														(
																				 															case 	when 	jadwal.hari is not null
																																				 			then 	jadwal.hari
																																				 	when 	jadwal.minggu is not null
																																				 			then 	jadwal.minggu
																																				 	when 	jadwal.bulan is not null
																																				 			then 	jadwal.bulan
																				 															end
																				 														)
																				 													)
																				 									else 	concat
																				 											(
																				 												'+',
																				 												(
																				 													case 	when 	jadwal.hari is not null
																				 																	then 	jadwal.hari
																				 															when 	jadwal.minggu is not null
																				 																	then 	jadwal.minggu
																				 															when 	jadwal.bulan is not null
																				 																	then 	jadwal.bulan
																				 													end
																				 												)
																				 											)
																				 							end
																				 						)
																				 		when 	(
																				 					jadwal.hari=0
																				 					or 	jadwal.minggu=0
																				 					or 	jadwal.bulan=0
																				 				)
																				 		then 	''
																				 end
																		 	)
																		) as waktu
															from 		ojt.tb_jadwal as jadwal";
			$queryAmbilDaftarPemberitahuanTabelJadwal 	=	$this->db->query($ambilDaftarPemberitahuanTabelJadwal);
			return $queryAmbilDaftarPemberitahuanTabelJadwal->result_array();
	    }

	    public function editOrientasi($id_orientasi_decode)
	    {
	    	$editOrientasi			= "	select 		orientasi.periode,
													orientasi.\"sequence\",
													orientasi.tahapan,
													orientasi.lama_hari,
													(
														case 	when 	orientasi.evaluasi=true
																		then 	1
																else	0
														end
													) as evaluasi,
													orientasi.keterangan,
													(
														case 	when 	orientasi.ck_tgl=true
																		then 	1
																else 	0
														end
													) as ck_tgl,
													(
														case 	when 	orientasi.pemberitahuan=true
																		then 	1
																else 	0
														end
													) as pemberitahuan,
													(
														case 	when 	orientasi.memo=true
																		then 	1
																else 	0
														end
													) as memo,
													orientasi.id_memo,
													(
														case 	when 	orientasi.memo=true
																		then 	memo.judul
														end
													) as memo_judul,
													jadwal.hari,
													jadwal.minggu,
													jadwal.bulan,
													(
														case 	when 	jadwal.urutan=true
																		then 	1
																else 	0
														end
													) as urutan,
													(
														case 	when 	jadwal.urutan=true
																		then 	'Sesudah'
																else 	'Sebelum'
														end
													) as status_pelaksanaan,
													jadwal.tujuan,
													(
														select		orientasi.tahapan
														from 		ojt.tb_orientasi as orientasi
														where 		orientasi.id_orientasi=jadwal.tujuan
													) as nama_tujuan
										from 		ojt.tb_orientasi as orientasi
													left join 	ojt.tb_memo as memo
																on 	memo.id_memo=orientasi.id_memo
													left join 	ojt.tb_jadwal as jadwal
																on 	jadwal.id_orientasi=orientasi.id_orientasi
										where 		orientasi.id_orientasi=$id_orientasi_decode";
	    	$queryEditOrientasi 	=	$this->db->query($editOrientasi);
	    	return $queryEditOrientasi->result_array($queryEditOrientasi);
	    }

	    public function editPemberitahuanOrientasi($id_orientasi_decode)
	    {
	    	$editPemberitahuanOrientasi 		= "	select 		pemberitahuan.id_pemberitahuan,
																(
																	case 	when 	pemberitahuan.pengulang=true
																					then 	1
																			else 	0
																	end
																) as pengulang,
																pemberitahuan.hari,
																pemberitahuan.minggu,
																pemberitahuan.bulan,
																(
																	case 	when 	pemberitahuan.urutan=true
																					then 	1
																			else 	0
																	end
																) as urutan,
																(
																	case 	when 	pemberitahuan.urutan=true
																					then 	'Sesudah'
																			else 	'Sebelum'
																	end
																) as status_urutan,
																pemberitahuan.penerima,
																(
																	case 	when 	pemberitahuan.penerima='1'
																					then 	'People Development'
																			when 	pemberitahuan.penerima='2'
																					then 	'Pekerja'
																			when 	pemberitahuan.penerima='3'
																					then	'Atasan Pekerja'
																	end
																) as nama_tujuan
													from 		ojt.tb_pemberitahuan as pemberitahuan
													where 		pemberitahuan.id_orientasi=$id_orientasi_decode";
			$queryEditPemberitahuanOrientasi	=	$this->db->query($editPemberitahuanOrientasi);
			return $queryEditPemberitahuanOrientasi->result_array();
	    }

	    public function editUndanganOrientasi($id_orientasi_decode)
	    {
	    	$editUndanganOrientasi			= "	select 		berkas.id_berkas,
															berkas.hari,
															berkas.minggu,
															berkas.bulan,
															(
																case 	when 	berkas.urutan=true
																				then 	1
																		else 	0
																end
															) as urutan,
															(
																case 	when 	berkas.urutan=true
																				then 	'Sesudah'
																		else 	'Sebelum'
																end
															) as status_urutan,
															berkas.penerima,
															(
																case 	when 	berkas.penerima='1'
																				then 	'People Development'
																		when 	berkas.penerima='2'
																				then 	'Pekerja'
																		when 	berkas.penerima='3'
																				then	'Atasan Pekerja'
																end
															) as nama_tujuan
												from 		ojt.tb_berkas as berkas
												where 		berkas.id_orientasi=$id_orientasi_decode";
			$queryEditUndanganOrientasi		=	$this->db->query($editUndanganOrientasi);
			return $queryEditUndanganOrientasi->result_array();
	    }

	    public function updateOrientasi($updateOrientasi, $id_orientasi_decode)
	    {
	    	$this->db->where('id_orientasi=', $id_orientasi_decode);
	    	$this->db->update('ojt.tb_orientasi', $updateOrientasi);
	    }

	   	public function updateJadwal($updateJadwal, $id_orientasi_decode)
	    {
	    	$this->db->where('id_orientasi', $id_orientasi_decode);
	    	$this->db->update('ojt.tb_jadwal', $updateJadwal);
	    }

	    public function cekIDJadwal($id_orientasi_decode)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_jadwal');
	    	$this->db->where('id_orientasi=', $id_orientasi_decode);

	    	return $this->db->get()->result_array();
	    }

	    public function ambilPemberitahuanDeleted($id_orientasi_decode, $idPemberitahuanUsed)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_pemberitahuan');
	    	$this->db->where('id_orientasi=', $id_orientasi_decode);
	    	if($idPemberitahuanUsed === NULL)
	    	{
	    		$this->db->where_not_in('id_pemberitahuan', $idPemberitahuanUsed);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function deleteUnusedPemberitahuan($id_orientasi_decode, $idPemberitahuanUsed)
	    {
	    	$this->db->where('id_orientasi=', $id_orientasi_decode);
	    	$this->db->where_not_in('id_pemberitahuan', $idPemberitahuanUsed);
	    	$this->db->delete('ojt.tb_pemberitahuan');
	    }

	    public function updatePemberitahuan($updatePemberitahuan, $idPemberitahuan)
	    {
	    	$this->db->where('id_pemberitahuan=', $idPemberitahuan);
	    	$this->db->update('ojt.tb_pemberitahuan', $updatePemberitahuan);
	    }

	    public function ambilUndanganDeleted($id_orientasi_decode, $idUndanganUsed)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_berkas');
	    	$this->db->where('id_orientasi=', $id_orientasi_decode);
	    	$this->db->where_not_in('id_berkas', $idUndanganUsed);

	    	return $this->db->get()->result_array();
	    }

	    public function deleteUnusedUndangan($id_orientasi_decode, $idUndanganUsed)
	    {
	    	$this->db->where('id_orientasi=', $id_orientasi_decode);
	    	$this->db->where_not_in('id_berkas', $idUndanganUsed);
	    	$this->db->delete('ojt.tb_berkas_history');
	    }

	    public function updateUndangan($updateUndangan, $idUndangan)
	    {
	    	$this->db->where('id_berkas=', $idUndangan);
	    	$this->db->update('ojt.tb_berkas', $updateUndangan);
	    }

	    public function ambil_proses_delete($nomor_induk_pekerja, $pilih_orientasi)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_proses');
	    	$this->db->where('noind =', $nomor_induk_pekerja);
	    	$this->db->where_not_in('id_orientasi', $pilih_orientasi);

	    	return $this->db->get()->result_array();
	    }

	    public function ambil_proses_pemberitahuan_delete($id_proses)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_proses_pemberitahuan');
	    	$this->db->where('id_proses =', $id_proses);

	    	return $this->db->get()->result_array();
	    }

	    public function proses_pemberitahuan_history($history)
	    {
	    	$this->db->insert('ojt.tb_proses_pemberitahuan_history', $history);
	    }

	    public function proses_pemberitahuan_delete($id_proses_pemberitahuan)
	    {
	    	$this->db->where('id_proses_pemberitahuan =', $id_proses_pemberitahuan);
	    	$this->db->delete('ojt.tb_proses_pemberitahuan');
	    }
 	}