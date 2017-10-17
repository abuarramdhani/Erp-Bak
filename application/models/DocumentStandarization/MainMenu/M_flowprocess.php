<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_flowprocess extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getFlowProcess($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_flow_process');
    	} else {
    		$query = $this->db->get_where('ds.ds_flow_process', array('fp_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setFlowProcess($data)
    {
        return $this->db->insert('ds.ds_flow_process', $data);
    }

    public function updateFlowProcess($data, $id)
    {
        $this->db->where('fp_id', $id);
        $this->db->update('ds.ds_flow_process', $data);
    }

    public function deleteFlowProcess($id)
    {
        $this->db->where('fp_id', $id);
        $this->db->delete('ds.ds_flow_process');
    }
}

/* End of file M_flowprocess.php */
/* Location: ./application/models/OTHERS/MainMenu/M_flowprocess.php */
/* Generated automatically on 2017-09-14 11:02:53 */