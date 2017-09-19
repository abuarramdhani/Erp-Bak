<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_businessprocess extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getBusinessProcess($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_business_process');
    	} else {
    		$query = $this->db->get_where('ds.ds_business_process', array('bp_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setBusinessProcess($data)
    {
        return $this->db->insert('ds.ds_business_process', $data);
    }

    public function updateBusinessProcess($data, $id)
    {
        $this->db->where('bp_id', $id);
        $this->db->update('ds.ds_business_process', $data);
    }

    public function deleteBusinessProcess($id)
    {
        $this->db->where('bp_id', $id);
        $this->db->delete('ds.ds_business_process');
    }
}

/* End of file M_businessprocess.php */
/* Location: ./application/models/OTHERS/MainMenu/M_businessprocess.php */
/* Generated automatically on 2017-09-14 10:57:11 */