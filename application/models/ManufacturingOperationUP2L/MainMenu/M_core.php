<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_core extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getCore()
    {
        $sql = "SELECT mm.*, ma.kode kode
                FROM mo.mo_core mm, mo.mo_absensi ma
                WHERE ma.id_produksi = mm.core_id AND ma.category_produksi = 'Core'
                GROUP BY mm.core_id, ma.kode
                ORDER BY extract(month from mm.production_date) desc, extract(year from mm.production_date) desc, extract(day from mm.production_date), ma.kode";
        return $this->db->query($sql)->result_array();
    }
    
    public function getCoreById($id)
    {
        $sql = "SELECT mm.*, ma.kode kode
                FROM mo.mo_core mm, mo.mo_absensi ma
                WHERE ma.id_produksi = mm.core_id AND ma.category_produksi = 'Core' AND mm.core_id = '$id'
                GROUP BY mm.core_id, ma.kode";
        return $this->db->query($sql)->result_array();
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('mo.mo_absensi', $data);
    }

    public function setCore($data)
    {
        return $this->db->insert('mo.mo_core', $data);
    }

    public function updateCore($id, $data)
    {
        $this->db->where('core_id', $id);
        $this->db->update('mo.mo_core', $data);
    }

    public function deleteCore($id)
    {
        $sql = "DELETE FROM mo.mo_core WHERE core_id = '$id'; DELETE FROM mo.mo_absensi WHERE id_produksi = '$id'";
        $this->db->query($sql);
    }
}
