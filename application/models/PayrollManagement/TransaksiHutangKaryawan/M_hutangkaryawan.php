<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_hutangkaryawan extends CI_Model
{

    public $table = 'pr.pr_hutang_karyawan';
    public $table_gaji = 'pr.pr_riwayat_gaji';
    public $table_transaksi = 'pr.pr_transaksi_hutang';
    public $id = 'no_hutang';
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
	
	function insert_transaksi($data_transaksi){
		$this->db->insert($this->table_transaksi, $data_transaksi);
	}

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function getMaxHutang($data_where)
    {
        $this->db->where($data_where);
        return $this->db->get($this->table_gaji)->row()->gaji_pokok;
    }
	
	function getNoind($term){
			$sql		= "select noind,nama from pr.pr_master_pekerja where nama like '%$term%' or noind like '%$term%'";
			$query		= $this->db->query($sql);
			return $query->result_array();
	}
}

/* End of file M_hutangkaryawan.php */
/* Location: ./application/models/PayrollManagement/TransaksiHutangKaryawan/M_hutangkaryawan.php */
/* Generated automatically on 2016-12-01 11:08:18 */