<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_masterpekerja extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMasterPekerja($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('pr.pr_target_benda');
    	} else {
    		//$query = $this->db->get_where('pr.pr_target_benda', array('target_benda_id' => $id));
            $query = $this->db->select('*')->from('pr.pr_target_benda')->join('er.er_section', 'er.er_section.section_code=pr.pr_target_benda.kodesie')->where('target_benda_id', $id)->get();
            $sql = "
                SELECT * FROM pr.pr_target_benda ptb
                LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = ptb.kodesie
                WHERE
                    ptb.target_benda_id = '$id'
            ";
            $query = $this->db->query($sql);
    	}

    	return $query->result_array();
    }

    public function getMasterPekerjaDatatables()
    {
        $sql = "
            SELECT * FROM er.er_employee_all eea
            LEFT JOIN er.er_section ese ON ese.section_code = eea.section_code
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getMasterPekerjaSearch($searchValue)
    {
        $sql = "
            SELECT * FROM er.er_employee_all eea
            LEFT JOIN er.er_section ese ON ese.section_code = eea.section_code
            WHERE
                    eea.\"employee_code\" ILIKE '%$searchValue%'
                OR  eea.\"employee_name\" ILIKE '%$searchValue%'
                OR  eea.\"sex\" ILIKE '%$searchValue%'
                OR  eea.\"address\" ILIKE '%$searchValue%'
                OR  eea.\"telephone\" ILIKE '%$searchValue%'
                OR  eea.\"handphone\" ILIKE '%$searchValue%'
                OR  eea.\"section_code\" ILIKE '%$searchValue%'
                OR  ese.\"section_name\" ILIKE '%$searchValue%'
                OR  eea.\"new_employee_code\" ILIKE '%$searchValue%'
                OR  eea.\"worker_status_code\" ILIKE '%$searchValue%'
                OR  eea.\"location_code\" ILIKE '%$searchValue%'
                OR  eea.\"worker_code\" ILIKE '%$searchValue%'

                OR  CAST(eea.\"worker_recruited_date\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(eea.\"worker_start_working_date\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(eea.\"resign\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(eea.\"resign_date\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(eea.\"outstation_position\" AS TEXT) ILIKE '%$searchValue%'


                
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getMasterPekerjaOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $condition = "
                WHERE
                    eea.\"employee_code\" ILIKE '%$searchValue%'
                OR  eea.\"employee_name\" ILIKE '%$searchValue%'
                OR  eea.\"sex\" ILIKE '%$searchValue%'
                OR  eea.\"address\" ILIKE '%$searchValue%'
                OR  eea.\"telephone\" ILIKE '%$searchValue%'
                OR  eea.\"handphone\" ILIKE '%$searchValue%'
                OR  eea.\"section_code\" ILIKE '%$searchValue%'
                OR  ese.\"section_name\" ILIKE '%$searchValue%'
                OR  eea.\"new_employee_code\" ILIKE '%$searchValue%'
                OR  eea.\"worker_status_code\" ILIKE '%$searchValue%'
                OR  eea.\"location_code\" ILIKE '%$searchValue%'
                OR  eea.\"worker_code\" ILIKE '%$searchValue%'

                OR  CAST(eea.\"worker_recruited_date\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(eea.\"worker_start_working_date\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(eea.\"resign\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(eea.\"resign_date\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(eea.\"outstation_position\" AS TEXT) ILIKE '%$searchValue%'


            ";
        }
        $sql="
            SELECT * FROM er.er_employee_all eea
            LEFT JOIN er.er_section ese ON ese.section_code = eea.section_code

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function setMasterPekerja($data)
    {
        return $this->db->insert('er.er_employee_all', $data);
    }

    public function updateMasterPekerja($data, $id)
    {
        $this->db->where('employee_id', $id);
        $this->db->update('er.er_employee_all', $data);
    }

    public function cekUpdate($dataCekUpdate){
        $query = $this->db->get_where('er.er_employee_all', $dataCekUpdate);
        return $query;
    }
}

/* End of file M_targetbenda.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_targetbenda.php */
/* Generated automatically on 2017-03-23 13:51:52 */