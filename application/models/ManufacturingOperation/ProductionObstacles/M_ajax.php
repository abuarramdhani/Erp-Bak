<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_ajax extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->oracle = $this->load->database('oracle',true);     
    }

    function delete($id)
    {
    	$this->db->where('id', $id);
      	$this->db->delete('mo.mo_master_induk');
    }

    function deleteCabang($id)
    {
    	$this->db->where('id', $id);
      	$this->db->delete('mo.mo_master_cabang');
    }

    function UpdateInduk($id,$val)
    {
        $sql = "update mo.mo_master_induk set induk = '$val' where id = $id";
        $query= $this->db->query($sql);
        return;
    }

    function UpdateCabang($id,$val)
    {
        $sql = "update mo.mo_master_cabang set cabang = '$val' where id = $id";
        $query= $this->db->query($sql);
        return;
    }

    function selectInduk($type)
    {
        $query = $this->db->get_where('mo.mo_master_induk', array('cetak' => $type));
        return $query->result_array();
    }
}