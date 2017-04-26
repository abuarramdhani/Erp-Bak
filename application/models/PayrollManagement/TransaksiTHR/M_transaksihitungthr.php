<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_transaksihitungthr extends CI_Model
{

    public $table = 'pr.pr_transaksi_hitung_thr';
    public $table_data = 'pr.pr_data_thr';
    public $id = 'id_transaksi_thr';
    public $id_data = 'id_data_thr';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all($dt)
    {
		$this->db->where('periode=',$dt);
    	return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

	 // check id
    function check($id)
    {
        $this->db->where($this->id_data, $id);
        return $this->db->get($this->table_data)->row();
    }
	
	 // check id transaksi
    function check_transaksi($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
	
	function insert_data($data)
    {
        $this->db->insert($this->table_data, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
	
	 function update_data($id, $data)
    {
        $this->db->where($this->id_data, $id);
        $this->db->update($this->table_data, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // association
    function get_pr_master_status_kerja_data()
    {
        return $this->db->get('pr.pr_master_status_kerja')->result();
    }

    function get_hitung_data($periode){
        $sql="
            SELECT ht.id_transaksi_thr, ht.periode, ht.noind, ht.kd_status_kerja, ht.lama_thn, ht.lama_bln, ga.gaji_pokok, st.persentase_thr, st.persentase_ubthr FROM pr.pr_transaksi_hitung_thr ht
            LEFT JOIN pr.pr_riwayat_gaji ga ON ga.noind = ht.noind AND ga.tgl_tberlaku = '9999-12-31'
            LEFT JOIN pr.pr_set_penerima_thr_ubthr st ON st.kd_status_kerja = ht.kd_status_kerja AND st.tgl_tberlaku = '9999-12-31'
            WHERE ht.periode = '$periode'
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function update_hitung($ht_where, $ht_data){
        $this->db->where($ht_where);
        $this->db->update($this->table, $ht_data);
    }
	
	function getTransaksiTHR($dt){
		$this->db->where('periode=',$dt);
		$this->db->join('pr.pr_master_pekerja', 'pr.pr_master_pekerja.noind = pr.pr_transaksi_hitung_thr.noind', 'left');
		$this->db->join('pr.pr_master_seksi', 'pr.pr_master_pekerja.kodesie = pr.pr_transaksi_hitung_thr.kodesie', 'left');
    	return $this->db->get($this->table)->result();
	}

}

/* End of file M_transaksihitungthr.php */
/* Location: ./application/models/PayrollManagement/TransaksiTHR/M_transaksihitungthr.php */
/* Generated automatically on 2016-11-28 15:07:51 */