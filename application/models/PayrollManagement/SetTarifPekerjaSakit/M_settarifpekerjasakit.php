<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_settarifpekerjasakit extends CI_Model
{

    public $table = 'pr.pr_master_tarif_pekerja_sakit';
    public $table_riwayat = 'pr.pr_riwayat_tarif_pekerja_sakit';
    public $id = 'kd_tarif';
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
        $this->db->where('tingkatan', $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
	
	//------------------------- RIWAYAT RELATION -------------------------	
	
	//MASTER DELETE CURRENT
    function master_delete($md_where)
    {
        $this->db->where($md_where);
        $this->db->delete($this->table);
    }
	
	//RIWAYAT CHANGE CURRENT
    function riwayat_update($ru_where, $ru_data)
    {
        $this->db->where($ru_where);
        $this->db->update($this->table_riwayat, $ru_data);
    }
	
	//RIWAYAT INSERT NEW
    function riwayat_insert($ri_data)
    {
        $this->db->insert($this->table_riwayat, $ri_data);
    }
	
}

/* End of file M_masterstatuskerja.php */
/* Location: ./application/models/PayrollManagement/MasterStatusKerja/M_masterstatuskerja.php */
/* Generated automatically on 2016-11-24 09:46:53 */