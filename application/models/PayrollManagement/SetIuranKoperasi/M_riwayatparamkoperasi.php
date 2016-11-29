<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_riwayatparamkoperasi extends CI_Model
{

    public $table = 'pr.pr_riwayat_param_koperasi';
    public $id = 'id_riwayat';
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
    }}

/* End of file M_riwayatparamkoperasi.php */
/* Location: ./application/models/PayrollManagement/SetIuranKoperasi/M_riwayatparamkoperasi.php */
/* Generated automatically on 2016-11-26 13:40:34 */