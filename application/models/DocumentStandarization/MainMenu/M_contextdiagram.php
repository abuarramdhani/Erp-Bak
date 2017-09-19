<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_contextdiagram extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getContextDiagram($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_context_diagram');
    	} else {
    		$query = $this->db->get_where('ds.ds_context_diagram', array('cd_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setContextDiagram($data)
    {
        return $this->db->insert('ds.ds_context_diagram', $data);
    }

    public function updateContextDiagram($data, $id)
    {
        $this->db->where('cd_id', $id);
        $this->db->update('ds.ds_context_diagram', $data);
    }

    public function deleteContextDiagram($id)
    {
        $this->db->where('cd_id', $id);
        $this->db->delete('ds.ds_context_diagram');
    }
}

/* End of file M_contextdiagram.php */
/* Location: ./application/models/OTHERS/MainMenu/M_contextdiagram.php */
/* Generated automatically on 2017-09-14 11:00:26 */