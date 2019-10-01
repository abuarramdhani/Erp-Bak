<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_cetakmemojadwaltraining extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
					$this->personalia 	= 	$this->load->database('personalia', TRUE);
	    }

	   	public function cetak_memo_jadwal_training($id_proses_memo_jadwal_training = FALSE)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_proses_memo_jadwal_training prosesmemotraining');

	    	if ( $id_proses_memo_jadwal_training !== FALSE )
	    	{
	    		$this->db->where('prosesmemotraining.id_proses_memo_jadwal_training =', $id_proses_memo_jadwal_training);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function cetak_memo_jadwal_training_ref($id_proses_memo_jadwal_training)
	    {
	    	$this->db->select('
	    						pekerja_ojt_ref_memo.*,
	    						pekerja_ojt.noind,
	    						rtrim(pekerja_psn.employee_name) nama_pekerja_ojt
	    					');
	    	$this->db->from('ojt.tb_proses_memo_jadwal_training_ref pekerja_ojt_ref_memo');
	    	$this->db->join('ojt.tb_pekerja pekerja_ojt', 'pekerja_ojt.pekerja_id = pekerja_ojt_ref_memo.id_pekerja');
	    	$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja_ojt.noind');

	    	if ( $id_proses_memo_jadwal_training !== FALSE )
	    	{
	    		$this->db->where('id_proses_memo_jadwal_training =', $id_proses_memo_jadwal_training);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function create_memo_jadwal_training($create_memo_jadwal_training)
	    {
	    	$this->db->insert('ojt.tb_proses_memo_jadwal_training', $create_memo_jadwal_training);
	    	return $this->db->insert_id();
	    }

	    public function create_memo_jadwal_training_ref($create_memo_jadwal_training_ref)
	    {
	    	$this->db->insert('ojt.tb_proses_memo_jadwal_training_ref', $create_memo_jadwal_training_ref);
	    	return $this->db->insert_id();
	    }


	    public function update_memo_jadwal_training($update_memo_jadwal_training, $id_proses_memo_jadwal_training)
	    {
	    	$this->db->where('id_proses_memo_jadwal_training =', $id_proses_memo_jadwal_training);
	    	$this->db->update('ojt.tb_proses_memo_jadwal_training', $update_memo_jadwal_training);
	    }

	    public function delete_memo_jadwal_training_ref($id_proses_memo_jadwal_training)
	    {
	    	$this->db->where('id_proses_memo_jadwal_training =', $id_proses_memo_jadwal_training);
	    	$this->db->delete('ojt.tb_proses_memo_jadwal_training_ref');
	    }

	    public function delete_memo_jadwal_training($id_proses_memo_jadwal_training)
	    {
	    	$this->db->where('id_proses_memo_jadwal_training =', $id_proses_memo_jadwal_training);
	    	$this->db->delete('ojt.tb_proses_memo_jadwal_training');
	    }

	    public function format($judul)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_master_memo');

	    	$this->db->like('judul', $judul);
	    	return $this->db->get()->result_array();
	    }

	    public function atasan($id_pekerja)
	    {
	    	$param_pekerja 	= 	"";
	    	$total 			=	count($id_pekerja);
	    	$i 				=	1;
	    	foreach ($id_pekerja as $pekerja)
	    	{
	    		$param_pekerja 	.=	"'".$pekerja."'";

	    		if ( $i < $total )
	    		{
	    			$param_pekerja	.=	", ";
	    		}
	    		$i++;
	    	}

	    	$atasan 	= "	select distinct 		pekerja_ojt.atasan,
													rtrim(pekerja_psn.employee_name) as nama_atasan_pekerja,
													char_length(replace(pekerja_psn.section_code,'0', ''))
							from 					ojt.tb_pekerja as pekerja_ojt
													join 	er.er_employee_all as pekerja_psn
															on 	pekerja_psn.employee_code=pekerja_ojt.atasan
							where 					pekerja_ojt.pekerja_id in (".$param_pekerja.")
							order by 				char_length(replace(pekerja_psn.section_code,'0', ''))";
			$query 		=	$this->db->query($atasan);
			return $query->result_array();

	    }

	    public function jadwal_pekerja_ojt($id_pekerja, $nama_tahapan)
	    {
	    	$this->db->select('
	    						proses.noind,
	    						proses.tahapan,
	    						proses.tgl_awal,
	    						proses.tgl_akhir
	    					');
	    	$this->db->from('ojt.tb_proses proses');
	    	$this->db->join('ojt.tb_pekerja pekerja', 'pekerja.noind = proses.noind');

	    	$this->db->where_in('pekerja.pekerja_id', $id_pekerja);
	    	$this->db->where_in('proses.tahapan', $nama_tahapan);

	    	$this->db->order_by('pekerja.pekerja_id', 'ASC');
	    	$this->db->order_by('proses.noind', 'ASC');
	    	$this->db->order_by('proses.id_orientasi');

	    	return $this->db->get()->result_array();
	    }
	    public function tahapan_jadwal($nama_tahapan)
	    {
	    	$this->db->distinct();
	    	$this->db->select('
	    						tahapan,
	    						id_orientasi
	    					');
	    	$this->db->from('ojt.tb_proses');
	    	$this->db->where_in('tahapan', $nama_tahapan);

	    	$this->db->order_by('id_orientasi');

	    	return $this->db->get()->result_array();
	    }

	    public function pekerja_ojt($id_pekerja)
	    {
	    	$this->db->select('
	    						pekerja_ojt.noind,
	    						rtrim(pekerja_psn.employee_name) nama_pekerja_ojt,
	    						rtrim(seksi_psn.section_name) seksi_pekerja_ojt
	    					');
	    	$this->db->from('ojt.tb_pekerja pekerja_ojt');
	    	$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja_ojt.noind');
	    	$this->db->join('er.er_section seksi_psn', 'seksi_psn.section_code = pekerja_psn.section_code');
	    	$this->db->where_in('pekerja_ojt.pekerja_id', $id_pekerja);

	    	$this->db->order_by('pekerja_ojt.tgl_masuk');

	    	return $this->db->get()->result_array();
	    }

			//---------Model Utama untuk Memo pindah makan----------//
			public function tampilData()
			{
				$sql = "SELECT * FROM ojt.tb_proses_memo_pindah_lokasi_makan";
				return $this->db->query($sql)->result_array();
			}

			public function getDataMemo($id)
			{
				$sql = "SELECT * FROM ojt.tb_proses_memo_pindah_lokasi_makan WHERE id_pindah='$id'";
				return $this->db->query($sql)->result_array();
			}

			public function deleteMemo($id)
			{
				$sql = "DELETE from ojt.tb_proses_memo_pindah_lokasi_makan WHERE id_pindah='$id'";
				$this->db->query($sql);
			}

			public function getPdev()
	    {
				$sql = "select
						noind,
						initcap(nama) nama
					from
						hrd_khs.tpribadi
					where
						keluar = '0'
						and kodesie like '408010%'
						and (kd_jabatan in ('11','19') or noind = 'G1036')
					order by
						2;";

			return $this->personalia->query($sql)->result_array();
	    }

			public function getPekerjaTraining($jenis_training, $tanggal_awal, $tanggal_akhir)
			{
				$sql = "SELECT tp.*, a.employee_name, a.section_code, b.section_name
								FROM ojt.tb_pekerja tp
								LEFT JOIN er.er_employee_all a ON tp.noind = a.employee_code
								LEFT JOIN er.er_section b ON a.section_code = b.section_code
								LEFT JOIN ojt.tb_proses c ON tp.noind = c.noind
								WHERE c.tahapan = '$jenis_training' and c.tgl_awal = '$tanggal_awal' and c.tgl_akhir = '$tanggal_akhir' and c.selesai = '0' order by tp.noind";

	 			return $this->db->query($sql)->result_array();
			}

			public function getTemplate()
			{
				$sql = "SELECT memo from ojt.tb_master_memo where judul='MEMO PINDAH LOKASI MAKAN'";
				return $this->db->query($sql)->result_array();
			}

			public function saveMemo($saveMemo)
			{
				$this->db->insert("ojt.tb_proses_memo_pindah_lokasi_makan", $saveMemo);
				return;
			}

			public function getmaxid()
			{
				$sql = "SELECT max(id_pindah) id from ojt.tb_proses_memo_pindah_lokasi_makan";
				return $this->db->query($sql)->row()->id;
			}

			public function saveMemoHistory($saveHistory)
			{
				$this->db->insert("ojt.tb_proses_memo_pindah_lokasi_makan_history", $saveHistory);
				return;
			}

			public function getTertanda($id)
			{
				$sql = "SELECT upper(a.tertanda) tertanda FROM ojt.tb_proses_memo_pindah_lokasi_makan a WHERE a.id_pindah='$id'";
				return $this->db->query($sql)->row()->tertanda;
			}

			public function getTertandaNew($new)
			{
				$sql = "select
						noind,
						initcap(nama) nama
					from
						hrd_khs.tpribadi
					where
						keluar = '0'
						and kodesie like '408010%'
						and (kd_jabatan in ('11','19') or noind = 'G1036')
						and nama='$new'
					order by
						2;";

			return $this->personalia->query($sql)->result_array();
			}

			public function updateMemo($id,$saveMemo)
			{
				$this->db->where('id_pindah =', $id);
				$this->db->update('ojt.tb_proses_memo_pindah_lokasi_makan', $saveMemo);
			}
 	}
