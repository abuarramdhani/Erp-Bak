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
    		// $query = $this->db->get('pr.pr_kondite');
            $query = $this->db->select('*')->from('pr.pr_kondite')->join('er.er_employee_all', 'er.er_employee_all.employee_code=pr.pr_kondite.noind')->join('er.er_section', 'er.er_section.section_code=pr.pr_kondite.kodesie')->get();
    	} else {
    		// $query = $this->db->get_where('pr.pr_kondite', array('kondite_id' => $id));
            $sql = "
                SELECT * FROM pr.pr_kondite pko
                LEFT JOIN er.er_employee_all eea ON eea.employee_code = pko.noind
                LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pko.kodesie
                WHERE
                    pko.kondite_id = '$id'
            ";
            $query = $this->db->query($sql);
    	}

    	return $query->result_array();
    }

    public function getKonditeDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_kondite pko
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pko.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pko.kodesie        
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getKonditeSearch($searchValue)
    {
        $sql = "
            SELECT * FROM pr.pr_kondite pko
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pko.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pko.kodesie
            WHERE
                    pko.noind ILIKE '%$searchValue%'
                OR  pko.kodesie ILIKE '%$searchValue%'
                OR  pko.\"MK\" ILIKE '%$searchValue%'
                OR  pko.\"BKI\" ILIKE '%$searchValue%'
                OR  pko.\"BKP\" ILIKE '%$searchValue%'
                OR  pko.\"TKP\" ILIKE '%$searchValue%'
                OR  pko.\"KB\" ILIKE '%$searchValue%'
                OR  pko.\"KK\" ILIKE '%$searchValue%'
                OR  pko.\"KS\" ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getKonditeOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $condition = "
                WHERE
                    pko.noind ILIKE '%$searchValue%'
                OR  pko.kodesie ILIKE '%$searchValue%'
                OR  pko.\"MK\" ILIKE '%$searchValue%'
                OR  pko.\"BKI\" ILIKE '%$searchValue%'
                OR  pko.\"BKP\" ILIKE '%$searchValue%'
                OR  pko.\"TKP\" ILIKE '%$searchValue%'
                OR  pko.\"KB\" ILIKE '%$searchValue%'
                OR  pko.\"KK\" ILIKE '%$searchValue%'
                OR  pko.\"KS\" ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'
            ";
        }
        $sql="
            SELECT * FROM pr.pr_kondite pko
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pko.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pko.kodesie

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
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
                SELECT * FROM er.er_employee_all WHERE resign = '0' AND substr(section_code, 0, 7) = '$kodesie' ORDER BY employee_code ASC
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