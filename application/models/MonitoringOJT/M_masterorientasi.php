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

	    public function ambilDaftarCetak()
	    {
	    	$this->db->select('id_memo, judul');
	    	$this->db->from('ojt.tb_memo');

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

	    public function ambilDaftarOrientasiTabel($id_orientasi = FALSE)
	    {
	    	if($id_orientasi === FALSE)
	    	{
		    	$this->db->select('id_orientasi, tahapan, periode, ck_tgl, lama_hari, keterangan');
		    	$this->db->from('ojt.tb_orientasi');
	    	}
	    	else
	    	{

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
 	}