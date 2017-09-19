<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_workinstruction extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getWorkInstruction($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_work_instruction');
    	} else {
    		$query = $this->db->get_where('ds.ds_work_instruction', array('wi_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setWorkInstruction($data)
    {
        return $this->db->insert('ds.ds_work_instruction', $data);
    }

    public function updateWorkInstruction($data, $id)
    {
        $this->db->where('wi_id', $id);
        $this->db->update('ds.ds_work_instruction', $data);
    }

    public function deleteWorkInstruction($id)
    {
        $this->db->where('wi_id', $id);
        $this->db->delete('ds.ds_work_instruction');
    }
}

/* End of file M_workinstruction.php */
/* Location: ./application/models/OTHERS/MainMenu/M_workinstruction.php */
/* Generated automatically on 2017-09-14 11:01:40 */