<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_standardoperatingprocedure extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getStandardOperatingProcedure($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_standard_operating_procedure');
    	} else {
    		$query = $this->db->get_where('ds.ds_standard_operating_procedure', array('sop_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setStandardOperatingProcedure($data)
    {
        return $this->db->insert('ds.ds_standard_operating_procedure', $data);
    }

    public function updateStandardOperatingProcedure($data, $id)
    {
        $this->db->where('sop_id', $id);
        $this->db->update('ds.ds_standard_operating_procedure', $data);
    }

    public function deleteStandardOperatingProcedure($id)
    {
        $this->db->where('sop_id', $id);
        $this->db->delete('ds.ds_standard_operating_procedure');
    }
}

/* End of file M_standardoperatingprocedure.php */
/* Location: ./application/models/OTHERS/MainMenu/M_standardoperatingprocedure.php */
/* Generated automatically on 2017-09-14 11:01:16 */