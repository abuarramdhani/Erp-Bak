<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_mastergaji extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMasterGaji($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_master_gaji');
    	} else {
    		//$query = $this->db->get_where('pr.pr_master_gaji', array('master_gaji_id' => $id));
            $query = $this->db->select('*')->from('pr.pr_master_gaji')->join('er.er_employee_all', 'er.er_employee_all.employee_code=pr.pr_master_gaji.noind')->join('er.er_section', 'er.er_section.section_code=pr.pr_master_gaji.kodesie')->where('master_gaji_id', $id)->get();
    	}

    	return $query->result_array();
    }

    public function setMasterGaji($data)
    {
        return $this->db->insert('pr.pr_master_gaji', $data);
    }

    public function updateMasterGaji($data, $id)
    {
        $this->db->where('master_gaji_id', $id);
        $this->db->update('pr.pr_master_gaji', $data);
    }

    public function deleteMasterGaji($id)
    {
        $this->db->where('master_gaji_id', $id);
        $this->db->delete('pr.pr_master_gaji');
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

/* End of file M_mastergaji.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_mastergaji.php */
/* Generated automatically on 2017-03-20 13:42:33 */