<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class M_mastermemo extends CI_Model
	{
	    public function __construct()
	    {
	        parent::__construct();
	        $this->load->database();
	    }

	    public function memo($id_memo = FALSE)
	    {
	    	$this->db->select('*');
	    	$this->db->from('ojt.tb_master_memo');

	    	if ( $id_memo !== FALSE )
	    	{
	    		$this->db->where('id_memo =', $id_memo);
	    	}

	    	return $this->db->get()->result_array();
	    }

	    public function create($create_memo)
	    {
	    	$this->db->insert('ojt.tb_master_memo', $create_memo);
	    	return $this->db->insert_id();
	    }

	    public function update($update_memo, $id_memo)
	    {
	    	$this->db->where('id_memo =', $id_memo);
	    	$this->db->update('ojt.tb_master_memo', $update_memo);
	    }

	    public function delete($id_memo)
	    {
	    	$this->db->where('id_memo =', $id_memo);
	    	$this->db->delete('ojt.tb_master_memo');
	    }
 	}