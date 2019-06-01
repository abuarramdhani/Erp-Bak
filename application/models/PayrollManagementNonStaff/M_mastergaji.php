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
            $sql = "
                SELECT * FROM pr.pr_master_gaji pmg
                LEFT JOIN er.er_employee_all eea ON eea.employee_code = pmg.noind
                LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pmg.kodesie
                WHERE
                    pmg.master_gaji_id = '$id'
            ";
            $query = $this->db->query($sql);
    	}

    	return $query->result_array();
    }

    public function getMasterGajiDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_master_gaji pmg
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pmg.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pmg.kodesie        
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getMasterGajiSearch($searchValue)
    {
        $sql = "
            SELECT * FROM pr.pr_master_gaji pmg
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pmg.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pmg.kodesie
            WHERE
                    pmg.\"noind\" ILIKE '%$searchValue%'
                OR  eea.\"employee_name\" ILIKE '%$searchValue%'
                OR  pmg.\"kodesie\" ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'
                OR  CAST(pmg.\"kelas\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"gaji_pokok\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"insentif_prestasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"insentif_masuk_sore\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"insentif_masuk_malam\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"ubt\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"upamk\" AS TEXT) ILIKE '%$searchValue%'
                OR  pmg.\"bank_code\" ILIKE '%$searchValue%'
                OR  pmg.\"status_pajak\" ILIKE '%$searchValue%'
                OR  CAST(pmg.\"tanggungan_pajak\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"ptkp\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"bulan_kerja\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"potongan_dplk\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"potongan_spsi\" AS TEXT) ILIKE '%$searchValue%'
                OR  pmg.\"kpph\" ILIKE '%$searchValue%'
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getMasterGajiOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $condition = "
                WHERE
                    pmg.\"noind\" ILIKE '%$searchValue%'
                OR  eea.\"employee_name\" ILIKE '%$searchValue%'
                OR  pmg.\"kodesie\" ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'
                OR  CAST(pmg.\"kelas\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"gaji_pokok\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"insentif_prestasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"insentif_masuk_sore\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"insentif_masuk_malam\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"ubt\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"upamk\" AS TEXT) ILIKE '%$searchValue%'
                OR  pmg.\"bank_code\" ILIKE '%$searchValue%'
                OR  pmg.\"status_pajak\" ILIKE '%$searchValue%'
                OR  CAST(pmg.\"tanggungan_pajak\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"ptkp\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"bulan_kerja\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"potongan_dplk\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pmg.\"potongan_spsi\" AS TEXT) ILIKE '%$searchValue%'
                OR  pmg.\"kpph\" ILIKE '%$searchValue%'
            ";
        }
        $sql="
            SELECT * FROM pr.pr_master_gaji pmg
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pmg.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pmg.kodesie

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
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

    public function clearData()
    {
        $this->db->empty_table('pr.pr_master_gaji');
    }

}

/* End of file M_mastergaji.php */
/* Location: ./application/models/PayrollManagement/MainMenu/M_mastergaji.php */
/* Generated automatically on 2017-03-20 13:42:33 */