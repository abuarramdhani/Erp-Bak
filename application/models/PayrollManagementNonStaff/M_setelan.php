<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_setelan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getSetelan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_setelan');
    	} else {
    		$query = $this->db->get_where('pr.pr_setelan', array('setelan_id' => $id));
    	}

    	return $query->result_array();
    }

    public function getSetelanName($id = FALSE)
    {
        if ($id === FALSE) {
            $query = $this->db->get('pr.pr_setelan');
        } else {
            //$query = $this->db->get_where('pr.pr_setelan', array('setelan_name' => $id));
            $query = $this->db->where('setelan_id', $id);
            $query = $this->db->get('pr.pr_setelan');
        }

        return $query->result_array();
    }

    public function updateSetelan($data, $id)
    {
        $this->db->where('setelan_id', $id);
        $this->db->update('pr.pr_setelan', $data);
    }
}

/* End of file M_setelan.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_setelan.php */
/* Generated automatically on 2017-04-10 13:41:11 */