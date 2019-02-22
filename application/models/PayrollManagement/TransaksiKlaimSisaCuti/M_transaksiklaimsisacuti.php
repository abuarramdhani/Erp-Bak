<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_transaksiklaimsisacuti extends CI_Model
{

    public $table = 'pr.pr_transaksi_klaim_sisa_cuti';
	public $table_gaji = 'pr.pr_riwayat_gaji';
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
	
	function getGajiPokok($data_where)
    {
		$this->db->where($data_where);
        return $this->db->get($this->table_gaji)->row();
    }

	function check($id,$periode){
		 $this->db->where('noind', $id);
		 $this->db->where('periode', $periode);
        return $this->db->get($this->table)->row();
	}
	
	function update_import($noind,$periode,$data_update){
		$this->db->where('noind', $noind);
		$this->db->where('periode', $periode);
        return $this->db->update($this->table,$data_update);
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

    // get data hitung
    function get_hitung_data($periode){
        $sql="
            SELECT cu.periode, ga.noind, ga.gaji_pokok, cu.sisa_cuti FROM pr.pr_riwayat_gaji ga
            LEFT JOIN pr.pr_transaksi_klaim_sisa_cuti cu ON ga.noind = cu.noind
            WHERE tgl_tberlaku = '9999-12-31'
            AND cu.periode = '$periode'
        ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function update_hitung($ht_where, $ht_data){
        $this->db->where($ht_where);
        $this->db->update($this->table, $ht_data);
    }

}

/* End of file M_transaksiklaimsisacuti.php */
/* Location: ./application/models/PayrollManagement/TransaksiKlaimSisaCuti/M_transaksiklaimsisacuti.php */
/* Generated automatically on 2016-11-28 14:06:59 */