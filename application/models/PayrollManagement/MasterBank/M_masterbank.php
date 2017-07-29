<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterbank extends CI_Model
{

    public $table = 'pr.pr_master_bank';
    public $table_riwayat = 'pr.pr_riwayat_bank';
    public $id = 'kd_bank';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all()
    {
    	return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

	// association
    function get_pr_master_bank_induk_data()
    {
        return $this->db->get('pr.pr_master_bank_induk')->result();
    }

//------------------------- RIWAYAT RELATION -------------------------	
	
	//GET LATEST IDRB
	function get_idrb($rs_where)
    {
		$this->db->where($rs_where);
    	return $this->db->get($this->table_riwayat)->row()->id_riwayat_bank;
    }
	
	//MASTER DELETE CURRENT
    function master_delete($md_where)
    {
        $this->db->where($md_where);
        $this->db->delete($this->table);
    }
	
	//RIWAYAT CHANGE CURRENT
    function riwayat_update($ru_where, $ru_data)
    {
        $this->db->where($ru_where);
        $this->db->update($this->table_riwayat, $ru_data);
    }
	
	//RIWAYAT INSERT NEW
    function riwayat_insert($ri_data)
    {
        $this->db->insert($this->table_riwayat, $ri_data);
    }

}

/* End of file M_masterbank.php */
/* Location: ./application/models/PayrollManagement/MasterBank/M_masterbank.php */
/* Generated automatically on 2016-11-24 09:57:43 */