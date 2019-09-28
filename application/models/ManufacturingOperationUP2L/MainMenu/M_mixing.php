<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_mixing extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMixing()
    {
        $sql = "SELECT mm.*, ma.kode kode
                FROM mo.mo_mixing mm, mo.mo_absensi ma
                WHERE ma.id_produksi = mm.mixing_id AND ma.category_produksi = 'Mixing'
                GROUP BY mm.mixing_id, ma.kode
                ORDER  BY mm.production_date, ma.kode";
        return $this->db->query($sql)->result_array();
    }
    
    public function getMixingById($id)
    {
        $query = $this->db->get_where('mo.mo_mixing', array('mixing_id' => $id));
        return $query->result_array();
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('mo.mo_absensi', $data);
    }


    public function setMixing($data)
    {
        return $this->db->insert('mo.mo_mixing', $data);
    }

    public function updateMixing($data, $id)
    {
        $this->db->where('mixing_id', $id);
        $this->db->update('mo.mo_mixing', $data);
    }

    public function deleteMixing($id)
    {
        $sql = "DELETE FROM mo.mo_mixing WHERE mixing_id = '$id'; DELETE FROM mo.mo_absensi WHERE id_produksi = '$id'";
        $this->db->query($sql);
    }

}

/* End of file M_mixing.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_mixing.php */
/* Generated automatically on 2017-12-20 14:47:57 */
