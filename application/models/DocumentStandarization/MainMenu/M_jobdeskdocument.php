<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_jobdeskdocument extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getJobdeskDocument($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_jobdesk_document');
    	} else {
    		$query = $this->db->get_where('ds.ds_jobdesk_document', array('jd_d_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setJobdeskDocument($data)
    {
        return $this->db->insert('ds.ds_jobdesk_document', $data);
    }

    public function updateJobdeskDocument($data, $id)
    {
        $this->db->where('jd_d_id', $id);
        $this->db->update('ds.ds_jobdesk_document', $data);
    }

    public function deleteJobdeskDocument($id)
    {
        $this->db->where('jd_d_id', $id);
        $this->db->delete('ds.ds_jobdesk_document');
    }
}

/* End of file M_jobdeskdocument.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdeskdocument.php */
/* Generated automatically on 2017-09-14 11:03:46 */