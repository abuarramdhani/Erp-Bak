<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_jobdesk extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getJobdesk($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_jobdesk');
    	} else {
    		$query = $this->db->get_where('ds.ds_jobdesk', array('jd_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setJobdesk($data)
    {
        return $this->db->insert('ds.ds_jobdesk', $data);
    }

    public function updateJobdesk($data, $id)
    {
        $this->db->where('jd_id', $id);
        $this->db->update('ds.ds_jobdesk', $data);
    }

    public function deleteJobdesk($id)
    {
        $this->db->where('jd_id', $id);
        $this->db->delete('ds.ds_jobdesk');
    }
}

/* End of file M_jobdesk.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdesk.php */
/* Generated automatically on 2017-09-14 11:03:22 */