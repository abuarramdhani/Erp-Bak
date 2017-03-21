<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_riwayatinsentifkemahalan extends CI_Model
{

    public $table = 'pr.pr_riwayat_insentif_kemahalan';
    public $id = 'id_insentif_kemahalan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all($date)
    {
		$this->db->where('tgl_berlaku<=',$date);
		$this->db->where('tgl_tberlaku>',$date);
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
	
	function check($id)
    {
        $this->db->where('noind', $id);
        return $this->db->get($this->table)->row();
    }
	
	// update data riwayat
    function update_riwayat($id,$date,$data_riwayat)
    {
        $this->db->where('noind', $id);
        $this->db->where('tgl_tberlaku', $date);
        $this->db->update($this->table, $data_riwayat);
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

/* End of file M_riwayatinsentifkemahalan.php */
/* Location: ./application/models/PayrollManagement/MasterInsKemahalan/M_riwayatinsentifkemahalan.php */
/* Generated automatically on 2016-11-26 10:46:12 */