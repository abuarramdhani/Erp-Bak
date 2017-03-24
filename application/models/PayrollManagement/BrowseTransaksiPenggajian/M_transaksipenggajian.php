<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_transaksipenggajian extends CI_Model
{

    public $table = 'pr.pr_transaksi_pembayaran_penggajian';
    public $id = 'id_pembayaran_gaji';
    public $order = 'DESC';
	
	// komponen table penggajian
	public $tb_master_pekerja = 'pr.pr_master_pekerja';
	public $tb_data_gajian_personalia = 'pr.pr_data_gajian_personalia';
	//-----------------------------------------
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
	
	// get data periode
    function checkPeriode($varYear,$varMonth)
    {
        $this->db->where('extract(year from tanggal)=', $varYear);
        $this->db->where('extract(month from tanggal)=', $varMonth);
        return $this->db->get($this->table)->row();
    }
	
	// get data periode
    function getDataPenggajian($varYear,$varMonth)
    {
        $this->db->where('extract(year from tanggal)=', $varYear);
        $this->db->where('extract(month from tanggal)=', $varMonth);
        return $this->db->get($this->table)->result();
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
	
	// ++++++++++++++++++++++++++++++++ Function Penggajian ++++++++++++++++++++++++++++++++++++
	function getMasterPekerja(){
		$this->db->where('keluar','0');
		return $this->db->get($this->tb_master_pekerja)->result();
	}

}

/* End of file M_transaksihutang.php */
/* Location: ./application/models/PayrollManagement/TransaksiHutang/M_transaksihutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */