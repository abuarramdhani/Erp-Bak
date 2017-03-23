<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterstatuskerja extends CI_Model
{

    public $table = 'pr.pr_master_status_kerja';
    public $id = 'kd_status_kerja';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all()
    {
		$this->db->order_by('kd_status_kerja','asc');
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

/* End of file M_masterstatuskerja.php */
/* Location: ./application/models/PayrollManagement/MasterStatusKerja/M_masterstatuskerja.php */
/* Generated automatically on 2016-11-24 09:46:53 */