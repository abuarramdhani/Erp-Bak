<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_datalkhseksi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getLKHSeksi($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_lkh_seksi');
    	} else {
    		$query = $this->db->get_where('pr.pr_lkh_seksi', array('lkh_seksi_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setLKHSeksi($data)
    {
        return $this->db->insert('pr.pr_lkh_seksi', $data);
    }

    public function updateKondite($data, $id)
    {
        $this->db->where('kondite_id', $id);
        $this->db->update('pr.pr_kondite', $data);
    }

    public function deleteKondite($id)
    {
        $this->db->where('kondite_id', $id);
        $this->db->delete('pr.pr_kondite');
    }

	public function getEmployeeAll()
	{
		$query = $this->db->get('er.er_employee_all');

		return $query->result_array();
	}


	public function getSection()
	{
		$query = $this->db->get('er.er_section');

		return $query->result_array();
	}

}

/* End of file M_kondite.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */