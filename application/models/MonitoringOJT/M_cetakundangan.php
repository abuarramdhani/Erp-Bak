<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_cetakundangan extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
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
 	}