<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterparamkompumum extends CI_Model
{

    public $table = 'pr.pr_master_param_komp_umum';
    public $table_riwayat = 'pr.pr_riwayat_param_komp_umum';
    public $id = 'um';
    public $id_riwayat = 'id_riwayat';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all($dt)
    {
		$this->db->select('a.um,a.ubt,b.tgl_berlaku');    
		$this->db->from('pr.pr_master_param_komp_umum as a ');
		$this->db->join('pr.pr_riwayat_param_komp_umum as b', 'a.um=b.um and a.ubt=b.ubt');
		$this->db->where('b.tgl_berlaku <=',$dt);
		$this->db->where('b.tgl_tberlaku >',$dt);
		return $this->db->get()->result();
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
	
	 // insert data riwayat
    function insert_riwayat($data_riwayat)
    {
        $this->db->insert($this->table_riwayat, $data_riwayat);
    }
	
	function check_riwayat()
	{
		$this->db->select('id_riwayat');
		$this->db->order_by("id_riwayat", "desc"); 
		return $this->db->get($this->table_riwayat,1)->result();
	}
	
    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
	
	// update data riwayat
    function update_riwayat($id, $data)
    {
        $this->db->where($this->id_riwayat,$id);
        $this->db->update($this->table_riwayat, $data);
    }

	
    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }}

/* End of file M_masterparamkompumum.php */
/* Location: ./application/models/PayrollManagement/SetKomponenGajiUmum/M_masterparamkompumum.php */
/* Generated automatically on 2016-11-26 13:39:51 */