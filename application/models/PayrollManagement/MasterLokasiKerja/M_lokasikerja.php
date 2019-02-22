<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_lokasikerja extends CI_Model
{

    public $table = 'pr.pr_lokasi_kerja';
    public $id = 'id_lokasi_kerja';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all()
    {
		$this->db->order_by('id_lokasi_kerja','asc');
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

/* End of file M_lokasikerja.php */
/* Location: ./application/models/PayrollManagement/MasterLokasiKerja/M_lokasikerja.php */
/* Generated automatically on 2016-11-24 09:53:38 */