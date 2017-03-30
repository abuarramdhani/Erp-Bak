<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_targetbenda extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getTargetBenda($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_target_benda');
    	} else {
    		//$query = $this->db->get_where('pr.pr_target_benda', array('target_benda_id' => $id));
            $query = $this->db->select('*')->from('pr.pr_target_benda')->join('er.er_section', 'er.er_section.section_code=pr.pr_target_benda.kodesie')->where('target_benda_id', $id)->get();
    	}

    	return $query->result_array();
    }

    public function setTargetBenda($data)
    {
        return $this->db->insert('pr.pr_target_benda', $data);
    }

    public function updateTargetBenda($data, $id)
    {
        $this->db->where('target_benda_id', $id);
        $this->db->update('pr.pr_target_benda', $data);
    }

    public function deleteTargetBenda($id)
    {
        $this->db->where('target_benda_id', $id);
        $this->db->delete('pr.pr_target_benda');
    }
}

/* End of file M_targetbenda.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_targetbenda.php */
/* Generated automatically on 2017-03-23 13:51:52 */