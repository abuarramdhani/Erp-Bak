<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_standartjamtkpw extends CI_Model
{

    public $table = 'pr.pr_standart_jam_tkpw';
    public $table_riwayat = 'pr.pr_riwayat_standart_jam_tkpw';
    public $id = 'kode_standart_jam';
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
    function update($data)
    {
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
    function master_delete()
    {
        $this->db->empty_table($this->table);
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

/* End of file M_standartjamtkpw.php */
/* Location: ./application/models/PayrollManagement/SetStandartJamTKPW/M_standartjamtkpw.php */
/* Generated automatically on 2016-11-26 08:13:40 */