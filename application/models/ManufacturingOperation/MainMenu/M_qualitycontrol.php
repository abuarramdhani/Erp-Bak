<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_qualitycontrol extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getQualityControl($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('mo.mo_quality_control');
    	} else {
    		$query = $this->db->get_where('mo.mo_quality_control', array('quality_control_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setQualityControl($data)
    {
        return $this->db->insert('mo.mo_quality_control', $data);
    }

    public function updateQualityControl($data, $id)
    {
        $this->db->where('quality_control_id', $id);
        $this->db->update('mo.mo_quality_control', $data);
    }

    public function deleteQualityControl($id)
    {
        $this->db->where('quality_control_id', $id);
        $this->db->delete('mo.mo_quality_control');
    }
}

/* End of file M_qualitycontrol.php */
/* Location: ./application/models/ManufacturingOperation/MainMenu/M_qualitycontrol.php */
/* Generated automatically on 2017-12-20 14:51:22 */