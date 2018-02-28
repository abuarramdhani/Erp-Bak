<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_core extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getCore($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('mo.mo_core');
    	} else {
    		$query = $this->db->get_where('mo.mo_core', array('core_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setCore($data)
    {
        return $this->db->insert('mo.mo_core', $data);
    }

    public function updateCore($data, $id)
    {
        $this->db->where('core_id', $id);
        $this->db->update('mo.mo_core', $data);
    }

    public function deleteCore($id)
    {
        $this->db->where('core_id', $id);
        $this->db->delete('mo.mo_core');
    }
}
