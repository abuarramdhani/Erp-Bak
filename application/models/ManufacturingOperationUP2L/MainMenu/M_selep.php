<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_selep extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getSelep($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('mo.mo_selep');
    	} else {
    		$query = $this->db->get_where('mo.mo_selep', array('selep_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setSelep($data)
    {
        return $this->db->insert('mo.mo_selep', $data);
    }

        public function setAbsensi($data)
    {
        return $this->db->insert('mo.mo_absensi', $data);
    }

    public function updateSelep($data, $id)
    {
        $this->db->where('selep_id', $id);
        $this->db->update('mo.mo_selep', $data);
    }

    public function deleteSelep($id)
    {
        $this->db->where('selep_id', $id);
        $this->db->delete('mo.mo_selep');
    }

    public function getSelepDate($txtStartDate,$txtEndDate)
    {
        $query = $this->db->query("
        SELECT * FROM mo.mo_selep WHERE (selep_date BETWEEN '$txtStartDate' AND '$txtEndDate')
        ");
        return $query->result_array();
    }
    
    public function getKodeProses($kode_barang)
    {
        $query = $this->db->query("
        SELECT kode_proses FROM mo.mo_master_item WHERE (kode_barang = '$kode_barang')
        order by kode_proses
        ");
        return $query->result_array();
    }

}

/* End of file M_selep.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_selep.php */
/* Generated automatically on 2017-12-20 14:52:40 */