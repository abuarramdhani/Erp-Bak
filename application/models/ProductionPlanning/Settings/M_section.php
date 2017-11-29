<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_section extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getSection($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pp.pp_section');
    	} else {
    		$query = $this->db->get_where('pp.pp_section', array('section_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setSection($data)
    {
        return $this->db->insert('pp.pp_section', $data);
    }

    public function updateSection($data, $id)
    {
        $this->db->where('section_id', $id);
        $this->db->update('pp.pp_section', $data);
    }

    public function deleteSection($id)
    {
        $this->db->where('section_id', $id);
        $this->db->delete('pp.pp_section');
    }
}

/* End of file M_section.php */
/* Location: ./application/models/ProductionPlanning/MainMenu/M_section.php */
/* Generated automatically on 2017-10-23 10:54:54 */