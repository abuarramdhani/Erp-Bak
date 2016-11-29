<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_mastertarifjkk extends CI_Model
{

    public $table = 'pr.pr_master_tarif_jkk';
    public $id = 'id_tarif_jkk';
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

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
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

}

/* End of file M_mastertarifjkk.php */
/* Location: ./application/models/PayrollManagement/SetTarifJKKBerdasarkanLokasiKerja/M_mastertarifjkk.php */
/* Generated automatically on 2016-11-26 13:01:11 */