<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_setgajiump extends CI_Model
{

    public $table = 'pr.pr_gaji_ump';
    public $table_riwayat = 'pr.pr_riwayat_gaji_ump';
    public $id = 'kode_ump';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all()
    {
		$this->db->select('*');
		$this->db->from('pr.pr_gaji_ump as a');
		$this->db->join('pr.pr_lokasi_kerja as b','a.id_lokasi_kerja=b.id_lokasi_kerja');
    	return $this->db->get()->result();
    }
	
	function get_lokasi_kerja()
    {
    	return $this->db->get('pr.pr_lokasi_kerja')->result();
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

	// insert data
    function insert_riwayat($data_riwayat)
    {
        $this->db->insert($this->table_riwayat, $data_riwayat);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
	
	//RIWAYAT CHANGE CURRENT
    function riwayat_update($ru_where, $ru_data)
    {
        $this->db->where($ru_where);
        $this->db->update($this->table_riwayat, $ru_data);
    }
	
	//DELETE MASTER
    function master_delete($dl_where)
    {
        $this->db->where($dl_where);
        $this->db->delete($this->table);
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