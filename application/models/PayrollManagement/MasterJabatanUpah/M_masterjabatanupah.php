<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterjabatanupah extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* GET HEADER DATA */
    function get_header()
    {
        return $this->db->get('pr.pr_master_jabatan_upah')->result_array();
    }

    /* GET HEADER DATA BY ID */
    function get_header_by_id($id)
    {
        $this->db->where('kd_jabatan_upah', $id);
        return $this->db->get('pr.pr_master_jabatan_upah')->row();
    }

    /* SAVE HEADER DATA */
    function insert_header($data)
    {
        return $this->db->insert('pr.pr_master_jabatan_upah', $data);
    }

    /* UPDATE HEADER DATA */
    function update_header($id, $data)
    {
        $this->db->where('kd_jabatan_upah', $id);
        $this->db->update('pr.pr_master_jabatan_upah', $data);
    }

    /* DELETE DATA */
    function delete($id)
    {
        $this->db->where('kd_jabatan_upah', $id);
        $this->db->delete('pr.pr_master_jabatan_upah');
    }}

/* End of file M_masterjabatanupah.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_masterjabatanupah.php */
/* Generated automatically on 2016-12-24 08:50:04 */