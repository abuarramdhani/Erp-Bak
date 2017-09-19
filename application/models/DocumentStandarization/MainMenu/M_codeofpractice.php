<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_codeofpractice extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getCodeOfPractice($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_code_of_practice');
    	} else {
    		$query = $this->db->get_where('ds.ds_code_of_practice', array('cop_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setCodeOfPractice($data)
    {
        return $this->db->insert('ds.ds_code_of_practice', $data);
    }

    public function updateCodeOfPractice($data, $id)
    {
        $this->db->where('cop_id', $id);
        $this->db->update('ds.ds_code_of_practice', $data);
    }

    public function deleteCodeOfPractice($id)
    {
        $this->db->where('cop_id', $id);
        $this->db->delete('ds.ds_code_of_practice');
    }
}

/* End of file M_codeofpractice.php */
/* Location: ./application/models/OTHERS/MainMenu/M_codeofpractice.php */
/* Generated automatically on 2017-09-14 11:02:21 */