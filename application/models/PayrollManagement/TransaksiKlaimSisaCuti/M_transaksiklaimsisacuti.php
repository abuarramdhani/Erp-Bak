<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_transaksiklaimsisacuti extends CI_Model
{

    public $table = 'pr.pr_transaksi_klaim_sisa_cuti';
    public $id = 'id_cuti';
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
            function get_pr_jns_transaksi_data()
            {
                return $this->db->get('pr.pr_jns_transaksi')->result();
            }

}

/* End of file M_transaksiklaimsisacuti.php */
/* Location: ./application/models/PayrollManagement/TransaksiKlaimSisaCuti/M_transaksiklaimsisacuti.php */
/* Generated automatically on 2016-11-28 14:06:59 */