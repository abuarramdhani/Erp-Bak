<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_transaksihutang extends CI_Model
{

    public $table_data = 'pr.pr_hutang_karyawan';
    public $table = 'pr.pr_transaksi_hutang';
    public $id = 'id_transaksi_hutang';
    public $id_data = 'no_hutang';
    public $no = 'no_hutang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all()
    {
    	return $this->db->get($this->table_data)->result();
    }
	
	function get_transaction_by_id($id)
    {
    	return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where("no_hutang", $id);
        return $this->db->get($this->table_data)->row();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
	
	// insert data
    function insert_data($data)
    {
        $this->db->insert($this->table_data, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id_data, $id);
        $this->db->update($this->table_data, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id_data, $id);
        $this->db->delete($this->table);
    }
	
	function delete_transaction($id)
    {
        $this->db->where($this->id_data, $id);
        $this->db->delete($this->table_data);
    }

// association
            function get_pr_jns_transaksi_data()
            {
                return $this->db->get('pr.pr_jns_transaksi')->result();
            }

}

/* End of file M_transaksihutang.php */
/* Location: ./application/models/PayrollManagement/TransaksiHutang/M_transaksihutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */