<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_tambahan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getTambahan($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_tambahan');
    	} else {
    		//$query = $this->db->get_where('pr.pr_tambahan', array('tambahan_id' => $id));
            $query = $this->db->select('*')->from('pr.pr_tambahan')->join('er.er_employee_all', 'er.er_employee_all.employee_code=pr.pr_tambahan.noind')->where('tambahan_id', $id)->get();
    	}

    	return $query->result_array();
    }

    public function setTambahan($data)
    {
        return $this->db->insert('pr.pr_tambahan', $data);
    }

    public function updateTambahan($data, $id)
    {
        $this->db->where('tambahan_id', $id);
        $this->db->update('pr.pr_tambahan', $data);
    }

    public function deleteTambahan($id)
    {
        $this->db->where('tambahan_id', $id);
        $this->db->delete('pr.pr_tambahan');
    }

	public function getEmployeeAll()
	{
		$query = $this->db->get('er.er_employee_all');

		return $query->result_array();
	}

}

/* End of file M_tambahan.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_tambahan.php */
/* Generated automatically on 2017-03-20 13:43:45 */