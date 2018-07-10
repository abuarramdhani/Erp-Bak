<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_cetakmemopdca extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	    }

	   	public function cetak_memo_pdca($id_proses_memo_pdca = FALSE)
	    {
	    	$this->db->select('
	    						memopdca.*,
	    						pekerja_ojt.noind nomor_induk_pekerja_ojt,
	    						pekerja_psn.employee_name nama_pekerja_ojt,
	    					');
	    	$this->db->from('ojt.tb_proses_memo_pdca memopdca');
	    	$this->db->join('ojt.tb_pekerja pekerja_ojt', 'pekerja_ojt.pekerja_id = memopdca.id_pekerja');
	    	$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja_ojt.noind');

	    	if ( $id_proses_memo_pdca !== FALSE )
	    	{
	    		$this->db->where('id_proses_memo_pdca =', $id_proses_memo_pdca);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function cetak_memo_pdca_ref($id_proses_memo_pdca)
	    {
	    	$this->db->select('
	    						memopdcaref.*,
	    						proses_ojt.tahapan,
	    						proses_ojt.tgl_awal,
	    						proses_ojt.tgl_akhir,
	    						proses_ojt.id_proses
	    					');
	    	$this->db->from('ojt.tb_proses_memo_pdca_ref memopdcaref');
	    	$this->db->join('ojt.tb_proses proses_ojt', 'proses_ojt.id_proses = memopdcaref.id_proses');

	    	if ( $id_proses_memo_pdca !== FALSE )
	    	{
	    		$this->db->where('id_proses_memo_pdca =', $id_proses_memo_pdca);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function create_memo_pdca($create_memo_pdca)
	    {
	    	$this->db->insert('ojt.tb_proses_memo_pdca', $create_memo_pdca);
	    	return $this->db->insert_id();
	    }

	    public function create_memo_pdca_ref($create_memo_pdca_ref)
	    {
	    	$this->db->insert('ojt.tb_proses_memo_pdca_ref', $create_memo_pdca_ref);
	    	return $this->db->insert_id();
	    }


	    public function update_memo_pdca($update_memo_pdca, $id_proses_memo_pdca)
	    {
	    	$this->db->where('id_proses_memo_pdca =', $id_proses_memo_pdca);
	    	$this->db->update('ojt.tb_proses_memo_pdca', $update_memo_pdca);
	    }

	    public function delete_memo_pdca_ref($id_proses_memo_pdca)
	    {
	    	$this->db->where('id_proses_memo_pdca =', $id_proses_memo_pdca);
	    	$this->db->delete('ojt.tb_proses_memo_pdca_ref');
	    }

	    public function delete_memo_pdca($id_proses_memo_pdca)
	    {
	    	$this->db->where('id_proses_memo_pdca =', $id_proses_memo_pdca);
	    	$this->db->delete('ojt.tb_proses_memo_pdca');
	    }

	    public function format($judul)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_master_memo');

	    	$this->db->like('judul', $judul);
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

	    public function proses_ojt_pekerja($id_pekerja, $keyword = FALSE, $id_proses_array = FALSE)
	    {
	    	$this->db->select('
	    						proses_ojt.id_proses,
	    						proses_ojt.tahapan,
	    						proses_ojt.tgl_awal,
	    						proses_ojt.tgl_akhir
	    					');
	    	$this->db->from('ojt.tb_proses proses_ojt');
	    	$this->db->join('ojt.tb_pekerja pekerja_ojt', 'pekerja_ojt.noind = proses_ojt.noind');
	    	$this->db->where('pekerja_ojt.pekerja_id =', $id_pekerja);
	    	$this->db->like('proses_ojt.tahapan', 'PDCA');


	    	if ( $keyword !== FALSE )
	    	{
	    		$this->db->group_start();
		    		$this->db->like('tahapan', $keyword);
		    	$this->db->group_end();
	    	}

	    	if ( $id_proses_array !== FALSE )
	    	{
	    		$this->db->group_start();
		    		$this->db->where_in('id_proses', $id_proses_array);
		    	$this->db->group_end();
	    	}

	    	$this->db->order_by('proses_ojt.tgl_awal');
	    	return $this->db->get()->result_array();
	    }

	    public function detail_pekerja_ojt($id_pekerja)
	    {
	    	$this->db->select('
	    						pekerja_ojt.noind nomor_induk_pekerja_ojt,
	    						rtrim(pekerja_psn.employee_name) nama_pekerja_ojt,
	    						rtrim(seksi_psn.section_name) seksi_pekerja_ojt
	    					');
	    	$this->db->select_min('proses_ojt.tgl_awal', 'tgl_awal');
	    	$this->db->select_max('proses_ojt.tgl_akhir', 'tgl_akhir');
	    	$this->db->from('ojt.tb_pekerja pekerja_ojt');
	    	$this->db->join('ojt.tb_proses proses_ojt', 'proses_ojt.noind = pekerja_ojt.noind');
	    	$this->db->join('er.er_employee_all pekerja_psn', 'pekerja_psn.employee_code = pekerja_ojt.noind');
	    	$this->db->join('er.er_section seksi_psn', 'seksi_psn.section_code = pekerja_psn.section_code');

	    	$this->db->where('pekerja_ojt.pekerja_id =', $id_pekerja);
	    	$this->db->group_by('
	    							pekerja_ojt.noind,
	    							rtrim(pekerja_psn.employee_name),
	    							rtrim(seksi_psn.section_name)
	    						');
	    	return $this->db->get()->result_array();
	    }
 	}