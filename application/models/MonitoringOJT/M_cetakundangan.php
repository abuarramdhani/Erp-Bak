<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_cetakundangan extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	        $this->personalia = $this->load->database('personalia', true);
	    }

	    public function undangan_cetak($id_proses_undangan = FALSE)
	    {
	    	$this->db->select('
	    						prosesundangan.*,
	    						masterundangan.judul,
	    						pekerja.noind,
	    						rtrim(pekerja_psn.employee_name) nama,
	    						proses.id_proses,
	    						proses.tahapan
	    					');
	    	$this->db->from('ojt.tb_proses_undangan prosesundangan');
	    	$this->db->join('ojt.tb_proses proses', 'proses.id_proses = prosesundangan.id_proses');
	    	$this->db->join('ojt.tb_master_undangan masterundangan', 'masterundangan.id_undangan = prosesundangan.id_undangan
	    		');
	    	$this->db->join('ojt.tb_pekerja pekerja', 'pekerja.pekerja_id = prosesundangan.id_pekerja');
	    	$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja.noind');

	    	if ( $id_proses_undangan !== FALSE )
	    	{
	    		$this->db->where('id_proses_undangan =', $id_proses_undangan);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function create($create_undangan)
	    {
	    	$this->db->insert('ojt.tb_proses_undangan', $create_undangan);
	    	return $this->db->insert_id();
	    }

	    public function update($update_undangan, $id_proses_undangan)
	    {
	    	$this->db->where('id_proses_undangan =', $id_proses_undangan);
	    	$this->db->update('ojt.tb_proses_undangan', $update_undangan);
	    }

	    public function delete($id_proses_undangan)
	    {
	    	$this->db->where('id_proses_undangan =', $id_proses_undangan);
	    	$this->db->delete('ojt.tb_proses_undangan');
	    }

	    public function daftar_format_undangan($keyword)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_master_undangan');
	    	$this->db->like('judul', $keyword);

	    	return $this->db->get()->result_array();
	    }

	    public function export_pdf($id_proses_undangan)
	    {
	    	$this->db->select('
	    						prosesundangan.*,
	    						masterundangan.judul,
	    						proses_ojt.tgl_awal,
	    						proses_ojt.tgl_akhir,
	    						pekerja_ojt.noind,
	    						rtrim(pekerja_psn.employee_name) nama_pekerja_ojt
	    					');
	    	$this->db->from('ojt.tb_proses_undangan prosesundangan');
	    	$this->db->join('ojt.tb_master_undangan masterundangan', 'prosesundangan.id_undangan = masterundangan.id_undangan');
	    	$this->db->join('ojt.tb_pekerja pekerja_ojt', 'pekerja_ojt.pekerja_id = prosesundangan.id_pekerja');
	    	$this->db->join('ojt.tb_proses proses_ojt', 'proses_ojt.id_proses = prosesundangan.id_proses');
	    	$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja_ojt.noind');
	    	$this->db->where('id_proses_undangan =', $id_proses_undangan);

	    	return $this->db->get()->result_array();
	    }

	    public function getListKeputusan()
	    {
	    	$sql = "select tk.*, tp.noind, ea.employee_name from ojt.tb_lembar_keputusan tk
					left join ojt.tb_pekerja tp on tp.pekerja_id = tk.id_pekerja
					left join er.er_employee_all ea on ea.employee_code = tp.noind
					where tk.status_hapus = '0'";

	    	$query = $this->db->query($sql);
	    	return $query->result_array();
	    }

	    public function getNoind($id)
	    {
	    	$this->db->select('noind');
	    	$this->db->from('ojt.tb_pekerja');
	    	$this->db->where('pekerja_id =', $id);
	    	return $this->db->get()->result_array();
	    }

	    public function getDetailPekerja($noind, $pr)
	    {
	    	if ($pr == '3') {
	    		$akhir = "(tp.masukkerja + interval '3 month' - interval '1 day') akhir";
	    	}elseif ($pr == '36') {
	    		$akhir = "(tp.masukkerja + interval '3 month' - interval '1 day') akhir1, (tp.masukkerja + interval '6 month' - interval '1 day') akhir2";
	    	}else{
	    		$akhir = "(tp.masukkerja + interval '6 month' - interval '1 day') akhir";
	    	}
	    	$sql = "select tp.*, ts.unit, ts.seksi, ts.dept, $akhir, tr.jabatan status_jabatan
	    			from hrd_khs.tpribadi tp
					left join hrd_khs.tseksi ts on ts.kodesie = tp.kodesie
					left join hrd_khs.torganisasi tr on tr.kd_jabatan = tp.kd_jabatan
					where noind = '$noind';";
			// echo $sql;exit();
	    	$query = $this->personalia->query($sql);
	    	return $query->result_array();
	    }

	    public function saveKeputusan($data)
	    {
	    	$this->db->insert('ojt.tb_lembar_keputusan', $data);
	    }
	    public function saveEvaluasi($data)
	    {
	    	$this->db->insert('ojt.tb_lembar_evaluasi', $data);
	    }

	    public function getId($tb, $column)
	    {
	    	$sql = "SELECT max($column) FROM $tb";

	    	$query = $this->db->query($sql);
	    	return $query->row()->max;
	    }

	    public function keputusan_cetak($id)
	    {
	    	$sql = "select
						tk.*,
						tp.noind,
						ea.employee_name
					from
						ojt.tb_lembar_keputusan tk
					left join ojt.tb_pekerja tp on
						tp.pekerja_id = tk.id_pekerja
					left join er.er_employee_all ea on
						ea.employee_code = tp.noind
					where tk.id_keputusan = '$id';";

			$query = $this->db->query($sql);
	    	return $query->result_array();
	    }

	    public function evaluasi_cetak($id)
	    {
	    	$sql = "select
						tk.*,
						tp.noind,
						ea.employee_name
					from
						ojt.tb_lembar_evaluasi tk
					left join ojt.tb_pekerja tp on
						tp.pekerja_id = tk.id_pekerja
					left join er.er_employee_all ea on
						ea.employee_code = tp.noind
					where tk.id_evaluasi = '$id';";

			$query = $this->db->query($sql);
	    	return $query->result_array();
	    }

	    public function updateKeputusan($create_undangan, $id)
	    {
	    	$this->db->where('id_keputusan =', $id);
	    	$this->db->update('ojt.tb_lembar_keputusan', $create_undangan);
	    }

	    public function updateEvaluasi($create_undangan, $id)
	    {
	    	$this->db->where('id_evaluasi =', $id);
	    	$this->db->update('ojt.tb_lembar_evaluasi', $create_undangan);
	    }

	    public function delUp($id)
	    {
	    	$sql = "update ojt.tb_lembar_keputusan set status_hapus = '1' where id_keputusan = '$id'";

	    	$query = $this->db->query($sql);
	    }

	    public function delUp2($id)
	    {
	    	$sql = "update ojt.tb_lembar_evaluasi set status_hapus = '1' where id_evaluasi = '$id'";

	    	$query = $this->db->query($sql);
	    }

	    public function getAtasan($noind)
	    {
	    	$sql = "select
						tp.noind,
						tp.nama,
						tp.kodesie,
						tp.jabatan,
						coalesce((select rtrim(nama) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan = '02' and substring(kodesie, 1, 1) = substring(tp.kodesie, 1, 1)), '....................................') kadept,
						coalesce((select rtrim(nama) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('03', '04') and substring(kodesie, 1, 1) = substring(tp.kodesie, 1, 1)), '....................................') wakadept
					from
						hrd_khs.tpribadi tp
					where
						tp.noind = '$noind';";
			$query = $this->personalia->query($sql);
	    	return $query->result_array();
	    }

	    public function getListEvaluasi()
	    {
	    	$sql = "select tk.*, tp.noind, ea.employee_name from ojt.tb_lembar_evaluasi tk
					left join ojt.tb_pekerja tp on tp.pekerja_id = tk.id_pekerja
					left join er.er_employee_all ea on ea.employee_code = tp.noind
					where tk.status_hapus = '0'";

	    	$query = $this->db->query($sql);
	    	return $query->result_array();
	    }
 	}