<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_absen extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index_data()
    {
        $sql = "SELECT * FROM mo.mo_absensi WHERE presensi != 'HDR'";
        return $this->db->query($sql)->result_array();
    }

    public function save_create($data)
    {
        $this->db->insert('mo.mo_absensi', $data);
    }

    public function byId($id)
    {
        $this->db->select('*');
        $query = $this->db->get_where('mo.mo_absensi', array('id_absensi' => $id));
        return $query->result_array();
    }

    public function save_update($data, $id)
    {
        $this->db->where('id_absensi', $id);
        $this->db->update('mo.mo_absensi', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_absensi', $id);
        $this->db->delete('mo.mo_absensi');
    }

    public function pekerja()
    {
        $this->db->select('no_induk, nama');
        $query = $this->db->get('mo.mo_master_personal');
        return $query->result_array();
    }
    public function pekerjaAjax($term)
    {
        $sql = "SELECT DISTINCT no_induk, nama FROM mo.mo_master_personal WHERE LOWER(nama) LIKE '%$term%' OR LOWER(no_induk) LIKE '%$term%'";
        return $this->db->query($sql)->result_array();
    }

}