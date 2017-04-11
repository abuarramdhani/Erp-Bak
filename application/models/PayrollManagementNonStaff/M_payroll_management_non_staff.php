<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_payroll_management_non_staff extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
                SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) as unit_name FROM er.er_section WHERE unit_name != '-' ORDER BY section_code ASC
            ";
        }
        else{
            $sql = "
                SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) as unit_name FROM er.er_section WHERE unit_name != '-' AND (section_code ILIKE '%$term%' OR unit_name ILIKE '%$term%') ORDER BY section_code ASC
            ";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}

/* End of file M_kondite.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */