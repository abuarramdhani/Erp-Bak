<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_klaimgajiindividual extends CI_Model
{

    public $table = 'pr.pr_data_gajian_pekerja_keluar_tmp';
    public $id = 'id_gajian_pkj_klr';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all($year,$month)
    {
		$this->db->where('extract(year from tanggal)=',$year);
		$this->db->where('extract(month from tanggal)=',$month);
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
    }
	
	function check($id){
		 $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
	}
}

/* End of file M_datagajianpersonalia.php */
/* Location: ./application/models/PayrollManagement/DataHariMasuk/M_datagajianpersonalia.php */
/* Generated automatically on 2016-11-29 11:21:18 */