<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_jobdeskemployee extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getJobdeskEmployee($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_jobdesk_employee');
    	} else {
    		$query = $this->db->get_where('ds.ds_jobdesk_employee', array('jd_e_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setJobdeskEmployee($data)
    {
        return $this->db->insert('ds.ds_jobdesk_employee', $data);
    }

    public function updateJobdeskEmployee($data, $id)
    {
        $this->db->where('jd_e_id', $id);
        $this->db->update('ds.ds_jobdesk_employee', $data);
    }

    public function deleteJobdeskEmployee($id)
    {
        $this->db->where('jd_e_id', $id);
        $this->db->delete('ds.ds_jobdesk_employee');
    }
}

/* End of file M_jobdeskemployee.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdeskemployee.php */
/* Generated automatically on 2017-09-14 11:04:06 */