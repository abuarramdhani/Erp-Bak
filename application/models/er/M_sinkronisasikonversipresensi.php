<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_sinkronisasikonversipresensi extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	        $this->personalia 	=	$this->load->database('personalia', TRUE);
	    }

	    public function data_konversi_presensi($tanggal, $noind, $kd_shift, $kodesie, $lokasi_kerja, $kd_jabatan)
	    {
	    	$this->personalia->select('*');
	    	$this->personalia->from('"Presensi".tb_konversi_presensi');
	    	$this->personalia->where('tanggal =', rtrim($tanggal));
	    	$this->personalia->where('noind =', rtrim($noind));
	    	$this->personalia->where('kd_shift =', rtrim($kd_shift));
	    	$this->personalia->where('kodesie =', rtrim($kodesie));
	    	$this->personalia->where('lokasi_kerja =', rtrim($lokasi_kerja));
	    	$this->personalia->where('kd_jabatan =', rtrim($kd_jabatan));

	    	return $this->personalia->get()->result_array();
	    }

	    public function hasil_konversi_presensi($id_konversi_presensi_array)
	    {
	    	$this->personalia->select('*');
	    	$this->personalia->from('"Presensi".tb_konversi_presensi');
	    	$this->personalia->where_in('id_konversi_presensi', $id_konversi_presensi_array);

	    	return $this->personalia->get()->result_array();
	    }

	    public function tb_konversi_presensi($query_tb_konversi_presensi)
	    {
	    	$execute_query_tb_konversi_presensi	=	$this->personalia->query($query_tb_konversi_presensi);
	    	return $execute_query_tb_konversi_presensi->result_array();
	    }

	    public function check_exist($tanggal, $noind, $kd_shift, $kodesie, $lokasi_kerja, $kd_jabatan)
	    {
	    	$this->personalia->where('tanggal =', rtrim($tanggal));
	    	$this->personalia->where('noind =', rtrim($noind));
	    	$this->personalia->where('kd_shift =', rtrim($kd_shift));
	    	$this->personalia->where('kodesie =', rtrim($kodesie));
	    	$this->personalia->where('lokasi_kerja =', rtrim($lokasi_kerja));
	    	$this->personalia->where('kd_jabatan =', rtrim($kd_jabatan));
	    	$this->personalia->from('"Presensi".tb_konversi_presensi');
	    	return $this->personalia->count_all_results();
	    }

	    public function insert($insert)
	    {
	    	$this->personalia->insert('"Presensi".tb_konversi_presensi', $insert);
	    	return $this->personalia->insert_id();
	    }

	    public function update($update, $id_konversi_presensi)
	    {
	    	$this->personalia->where('id_konversi_presensi', $id_konversi_presensi);
	    	$this->personalia->update('"Presensi".tb_konversi_presensi', $update);
	    }

	    public function tb_konversi_presensi_columns()
	    {
	    	$exclude_columns 	=	array
	    							(
	    								'last_update_timestamp',
	    								'last_update_user',
	    								'create_timestamp',
	    								'create_user',
	    							);

	    	$this->personalia->select('
	    								column_name,
	    								data_type
	    							');
	    	$this->personalia->from('information_schema.columns');
	    	$this->personalia->where('table_schema =', 'Presensi');
	    	$this->personalia->where('table_name = ', 'tb_konversi_presensi');
	    	$this->personalia->where('ordinal_position !=', 1);
	    	$this->personalia->where_not_in('column_name', $exclude_columns);


	    	return $this->personalia->get()->result_array();
	    }

	    public function history($schema_name, $table_name, $history)
 		{
 			$this->personalia->insert($schema_name.".".$table_name."_history", $history);
 		}

 		public function kode_status_kerja($keyword)
	    {
	    	$this->personalia->select('
	    								fs_noind,
	    								rtrim(fs_ket) fs_ket
	    							');
	    	$this->personalia->from('hrd_khs.tnoind');
	    	$this->personalia->group_start();
		    	$this->personalia->where('fs_noind', $keyword);
		    	$this->personalia->or_like('fs_ket', $keyword);
	    	$this->personalia->group_end();

	    	$this->personalia->order_by('fs_noind');

	    	return $this->personalia->get()->result_array();
	    }

	    public function pekerja($keyword)
	    {
	    	$this->personalia->select('
	    								noind_baru,
	    								noind,
	    								nama,
	    								nik,
	    								tgllahir
	    							');
	    	$this->personalia->from('hrd_khs.v_hrd_khs_tpribadi');
	    	$this->personalia->where('keluar =', FALSE);
	    	$this->personalia->group_start();
		    	$this->personalia->like('noind_baru', $keyword);
		    	$this->personalia->or_like('noind', $keyword, 'after');
		    	$this->personalia->or_like('nama', $keyword);
	    	$this->personalia->group_end();

	    	return $this->personalia->get()->result_array();
	    }

	    public function kode_shift($keyword)
	    {
	    	$this->personalia->select('
	    								trim(kd_shift) kd_shift,
	    								rtrim(shift) shift
	    							');
	    	$this->personalia->from('"Presensi".tshift');
	    	$this->personalia->group_start();
		    	$this->personalia->like('kd_shift', $keyword);
		    	$this->personalia->or_like('shift', $keyword);
	    	$this->personalia->group_end();

	    	$this->personalia->order_by('cast(kd_shift as int)');

	    	return $this->personalia->get()->result_array();
	    }

	    public function kodesie($keyword)
	    {
	    	$kodesie 		= "	select 		(
												case 	when 	tseksi.seksi!='-'
																then 	substring(tseksi.kodesie, 1, 7)
														else 	(
																	case 	when 	tseksi.unit!='-'
																					then 	substring(tseksi.kodesie, 1, 5)
																			else 	(
																						case 	when 	tseksi.bidang!='-'
																										then 	substring(tseksi.kodesie, 1, 3)
																								else 	substring(tseksi.kodesie, 1, 1)
																						end
																					)
																	end
																)
												end
											) kodesie,
											(
												case 	when 	tseksi.seksi!='-'
																then 	'Seksi ' || tseksi.seksi
														else 	(
																	case 	when 	tseksi.unit!='-'
																					then 	'Unit ' || tseksi.unit
																			else 	(
																						case 	when 	tseksi.bidang!='-'
																										then 	'Bidang ' || tseksi.bidang
																								else 	'Departemen ' || tseksi.dept
																						end
																					)
																	end
																)
												end
											) as nama_kodesie
								from 		hrd_khs.v_hrd_khs_tseksi as tseksi
								where 		substring(tseksi.kodesie, 8, 2)='00'
											and 	(
														tseksi.kodesie like '$keyword%'
														or 	(
																	tseksi.dept like '%$keyword%'
																	or 	tseksi.bidang like '%$keyword%'
																	or 	tseksi.unit like '%$keyword%'
																	or 	tseksi.seksi like '%$keyword%'
																)
													);";
			$query_kodesie	=	$this->personalia->query($kodesie);
			return $query_kodesie->result_array();
	    }

	    public function lokasi_kerja($keyword)
	    {
	    	$this->personalia->select('
	    								trim(id_) id_,
	    								rtrim(lokasi_kerja) lokasi_kerja
	    							');
	    	$this->personalia->from('hrd_khs.tlokasi_kerja');
	    	$this->personalia->group_start();
		    	$this->personalia->like('id_', $keyword);
		    	$this->personalia->or_like('lokasi_kerja', $keyword);
	    	$this->personalia->group_end();

	    	$this->personalia->order_by('cast(id_ as int)');

	    	return $this->personalia->get()->result_array();
	    }

	    public function jabatan($keyword)
	    {
	    	$this->personalia->select('
	    								trim(kd_jabatan) kd_jabatan,
	    								rtrim(jabatan) jabatan
	    							');
	    	$this->personalia->from('"Presensi".tshift');
	    	$this->personalia->group_start();
		    	$this->personalia->like('kd_jabatan', $keyword);
		    	$this->personalia->or_like('jabatan', $keyword);
	    	$this->personalia->group_end();

	    	$this->personalia->order_by('cast(kd_jabatan as int)');

	    	return $this->personalia->get()->result_array();
	    }
 	}