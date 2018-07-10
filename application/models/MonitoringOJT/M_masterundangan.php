<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_masterundangan extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	    }


	    // --------------

	    public function undangan($id_undangan = FALSE)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_master_undangan');

	    	if ( $id_undangan !== FALSE )
	    	{
	    		$this->db->where('id_undangan =', $id_undangan);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function create($create_undangan)
	    {
	    	$this->db->insert('ojt.tb_master_undangan', $create_undangan);
	    	return $this->db->insert_id();
	    }

	    public function update($update_undangan, $id_undangan)
	    {
	    	$this->db->where('id_undangan =', $id_undangan);
	    	$this->db->update('ojt.tb_master_undangan', $update_undangan);
	    }

	    public function delete($id_undangan)
	    {
	    	$this->db->where('id_undangan =', $id_undangan);
	    	$this->db->delete('ojt.tb_master_undangan');
	    }
 	}