<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_mixing extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getMixing($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('mo.mo_mixing');
    	} else {
    		$query = $this->db->get_where('mo.mo_mixing', array('mixing_id' => $id));
    	}

    	return $query->result_array();
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
        $this->db->where('mixing_id', $id);
        $this->db->delete('mo.mo_mixing');
    }
}

/* End of file M_mixing.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_mixing.php */
/* Generated automatically on 2017-12-20 14:47:57 */