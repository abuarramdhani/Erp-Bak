<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_kondite extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getKondite($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_kondite');
    	} else {
    		$query = $this->db->get_where('pr.pr_kondite', array('kondite_id' => $id));
    	}

    	return $query->result_array();
    }

    public function getNoind($term = FALSE)
    {
        if ($term === FALSE) {
            $sql = "
                SELECT * FROM er.er_employee_all ORDER BY employee_code ASC
            ";
        }
        else{
            $sql = "
                SELECT * FROM er.er_employee_all WHERE employee_code ILIKE '%$term%' OR employee_name ILIKE '%$term%' ORDER BY employee_code ASC
            ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getKodesie($term = FALSE)
    {
        if ($term === FALSE) {
            $sql = "
                SELECT * FROM er.er_section ORDER BY section_code ASC
            ";
        }
        else{
            $sql = "
                SELECT * FROM er.er_section WHERE section_code ILIKE '%$term%' OR section_name ILIKE '%$term%' ORDER BY section_code ASC
            ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPekerja($kodesie)
    {
        $sql = "
                SELECT * FROM er.er_employee_all WHERE resign = '0' AND section_code = '$kodesie' ORDER BY employee_code ASC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function setKondite($data)
    {
        return $this->db->insert('pr.pr_kondite', $data);
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