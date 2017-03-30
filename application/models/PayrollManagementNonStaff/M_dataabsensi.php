<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dataabsensi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAbsensi($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_absensi');
    	} else {
    		$query = $this->db->get_where('pr.pr_absensi', array('absensi_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setAbsensi($data)
    {
        return $this->db->insert('pr.pr_absensi', $data);
    }

    public function clearAbsensi($data)
    {
        $this->db->where($data);
        $this->db->delete('pr.pr_absensi');
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