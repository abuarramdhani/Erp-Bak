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
	    						masterundangan.judul
	    					');
	    	$this->db->from('ojt.tb_proses_undangan prosesundangan');
	    	$this->db->join('ojt.tb_master_undangan masterundangan', 'masterundangan.id_undangan = prosesundangan.id_undangan');
	    	$this->db->join('ojt.tb_pekerja pekerja', 'pekerja.')

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
 	}