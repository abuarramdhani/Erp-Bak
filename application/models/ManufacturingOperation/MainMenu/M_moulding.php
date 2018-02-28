<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_moulding extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getMoulding($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('mo.mo_moulding');
    	} else {
    		$query = $this->db->get_where('mo.mo_moulding', array('moulding_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setMoulding($data)
    {
        return $this->db->insert('mo.mo_moulding', $data);
    }

    public function updateMoulding($data, $id)
    {
        $this->db->where('moulding_id', $id);
        $this->db->update('mo.mo_moulding', $data);
    }

    public function deleteMoulding($id)
    {
        $this->db->where('moulding_id', $id);
        $this->db->delete('mo.mo_moulding');
    }
}

/* End of file M_moulding.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_moulding.php */
/* Generated automatically on 2017-12-20 14:49:32 */