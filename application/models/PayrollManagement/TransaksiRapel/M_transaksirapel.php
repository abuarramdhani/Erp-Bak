<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_transaksirapel extends CI_Model
{

    public $table = 'pr.pr_transaksi_hutang';
    public $id = 'id_transaksi_hutang';
    public $no = 'no_hutang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all($id)
    {
		$this->db->where($this->no,$id);
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
            function get_pr_jns_transaksi_data()
            {
                return $this->db->get('pr.pr_jns_transaksi')->result();
            }

}

/* End of file M_transaksihutang.php */
/* Location: ./application/models/PayrollManagement/TransaksiHutang/M_transaksihutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */