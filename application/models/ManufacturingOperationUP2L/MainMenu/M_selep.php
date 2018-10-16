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
}

/* End of file M_selep.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_selep.php */
/* Generated automatically on 2017-12-20 14:52:40 */