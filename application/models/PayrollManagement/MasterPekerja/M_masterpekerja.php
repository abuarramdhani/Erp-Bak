<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterpekerja extends CI_Model
{

    public $table = 'pr.pr_master_pekerja';
    public $id = 'noind';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all($statusKerja)
    {
		$sql = "select * from pr.pr_master_pekerja where left(noind,1) in ($statusKerja) order by noind";
		$query	= $this->db->query($sql);
		return $query->result();
    }
	
	// get hubker
    function get_hubker()
    {
    	return $this->db->order_by('kd_status_kerja', 'ASC')->get('pr.pr_master_status_kerja')->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
	// check
    function check($id)
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
            function get_pr_master_status_kerja_data()
            {
                return $this->db->get('pr.pr_master_status_kerja')->result();
            }



// association
            function get_pr_kantor_asal_data()
            {
                return $this->db->get('pr.pr_kantor_asal')->result();
            }



// association
            function get_pr_lokasi_kerja_data()
            {
                return $this->db->get('pr.pr_lokasi_kerja')->result();
            }



// association
            function get_pr_master_jabatan_data()
            {
                return $this->db->get('pr.pr_master_jabatan')->result();
            }

}

/* End of file M_masterpekerja.php */
/* Location: ./application/models/PayrollManagement/MasterPekerja/M_masterpekerja.php */
/* Generated automatically on 2016-11-26 11:32:52 */