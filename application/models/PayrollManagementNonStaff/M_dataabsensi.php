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

    public function getAbsensiDatatables()
    {
        $sql = "
            SELECT * FROM pr.pr_absensi pab
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pab.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pab.kodesie        
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAbsensiSearch($searchValue)
    {
        $numericValue = "";
        if (is_numeric($searchValue)) {
            $numericValue = "
                OR  pab.\"bln_gaji\" = '$searchValue'
                OR  pab.\"thn_gaji\" = '$searchValue'
                OR  pab.\"jam_lembur\" = '$searchValue'
                OR  pab.\"HMP\" = '$searchValue'
                OR  pab.\"HMU\" = '$searchValue'
                OR  pab.\"HMS\" = '$searchValue'
                OR  pab.\"HMM\" = '$searchValue'
                OR  pab.\"HM\" = '$searchValue'
                OR  pab.\"UBT\" = '$searchValue'
                OR  pab.\"HUPAMK\" = '$searchValue'
                OR  pab.\"IK\" = '$searchValue'
                OR  pab.\"IKSKP\" = '$searchValue'
                OR  pab.\"IKSKU\" = '$searchValue'
                OR  pab.\"IKSKS\" = '$searchValue'
                OR  pab.\"IKSKM\" = '$searchValue'
                OR  pab.\"IKJSP\" = '$searchValue'
                OR  pab.\"IKJSU\" = '$searchValue'
                OR  pab.\"IKJSS\" = '$searchValue'
                OR  pab.\"IKJSM\" = '$searchValue'
                OR  pab.\"ABS\" = '$searchValue'
                OR  pab.\"T\" = '$searchValue'
                OR  pab.\"SKD\" = '$searchValue'
                OR  pab.\"cuti\" = '$searchValue'
                OR  pab.\"HL\" = '$searchValue'
                OR  pab.\"PT\" = '$searchValue'
                OR  pab.\"PI\" = '$searchValue'
                OR  pab.\"PM\" = '$searchValue'
                OR  pab.\"DL\" = '$searchValue'
                OR  pab.\"tambahan\" = '$searchValue'
                OR  pab.\"duka\" = '$searchValue'
                OR  pab.\"potongan\" = '$searchValue'
                OR  pab.\"HC\" = '$searchValue'
                OR  pab.\"jml_UM\" = '$searchValue'
                OR  pab.\"cicil\" = '$searchValue'
                OR  pab.\"potongan_koperasi\" = '$searchValue'
                OR  pab.\"UBS\" = '$searchValue'
                OR  pab.\"UM_puasa\" = '$searchValue'
                OR  pab.\"SK_CT\" = '$searchValue'
                OR  pab.\"POT_2\" = '$searchValue'
                OR  pab.\"TAMB_2\" = '$searchValue'
                OR  pab.\"jml_izin\" = '$searchValue'
                OR  pab.\"jml_mangkir\" = '$searchValue'
            ";
        }
        $sql = "
            SELECT * FROM pr.pr_absensi pab
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pab.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pab.kodesie
            WHERE
                    pab.noind ILIKE '%$searchValue%'
                OR  pab.kodesie ILIKE '%$searchValue%'
                OR  pab.\"HM01\" ILIKE '%$searchValue%'
                OR  pab.\"HM02\" ILIKE '%$searchValue%'
                OR  pab.\"HM03\" ILIKE '%$searchValue%'
                OR  pab.\"HM04\" ILIKE '%$searchValue%'
                OR  pab.\"HM05\" ILIKE '%$searchValue%'
                OR  pab.\"HM06\" ILIKE '%$searchValue%'
                OR  pab.\"HM07\" ILIKE '%$searchValue%'
                OR  pab.\"HM08\" ILIKE '%$searchValue%'
                OR  pab.\"HM09\" ILIKE '%$searchValue%'
                OR  pab.\"HM10\" ILIKE '%$searchValue%'
                OR  pab.\"HM11\" ILIKE '%$searchValue%'
                OR  pab.\"HM12\" ILIKE '%$searchValue%'
                OR  pab.\"HM13\" ILIKE '%$searchValue%'
                OR  pab.\"HM14\" ILIKE '%$searchValue%'
                OR  pab.\"HM15\" ILIKE '%$searchValue%'
                OR  pab.\"HM16\" ILIKE '%$searchValue%'
                OR  pab.\"HM17\" ILIKE '%$searchValue%'
                OR  pab.\"HM18\" ILIKE '%$searchValue%'
                OR  pab.\"HM19\" ILIKE '%$searchValue%'
                OR  pab.\"HM20\" ILIKE '%$searchValue%'
                OR  pab.\"HM21\" ILIKE '%$searchValue%'
                OR  pab.\"HM22\" ILIKE '%$searchValue%'
                OR  pab.\"HM23\" ILIKE '%$searchValue%'
                OR  pab.\"HM24\" ILIKE '%$searchValue%'
                OR  pab.\"HM25\" ILIKE '%$searchValue%'
                OR  pab.\"HM26\" ILIKE '%$searchValue%'
                OR  pab.\"HM27\" ILIKE '%$searchValue%'
                OR  pab.\"HM28\" ILIKE '%$searchValue%'
                OR  pab.\"HM29\" ILIKE '%$searchValue%'
                OR  pab.\"HM30\" ILIKE '%$searchValue%'
                OR  pab.\"HM31\" ILIKE '%$searchValue%'
                OR  pab.\"kode_lokasi\" ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'

                $numericValue
        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAbsensiOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
            $numericValue = "";
            if (is_numeric($searchValue)) {
                $numericValue = "
                    OR  pab.\"bln_gaji\" = '$searchValue'
                    OR  pab.\"thn_gaji\" = '$searchValue'
                    OR  pab.\"jam_lembur\" = '$searchValue'
                    OR  pab.\"HMP\" = '$searchValue'
                    OR  pab.\"HMU\" = '$searchValue'
                    OR  pab.\"HMS\" = '$searchValue'
                    OR  pab.\"HMM\" = '$searchValue'
                    OR  pab.\"HM\" = '$searchValue'
                    OR  pab.\"UBT\" = '$searchValue'
                    OR  pab.\"HUPAMK\" = '$searchValue'
                    OR  pab.\"IK\" = '$searchValue'
                    OR  pab.\"IKSKP\" = '$searchValue'
                    OR  pab.\"IKSKU\" = '$searchValue'
                    OR  pab.\"IKSKS\" = '$searchValue'
                    OR  pab.\"IKSKM\" = '$searchValue'
                    OR  pab.\"IKJSP\" = '$searchValue'
                    OR  pab.\"IKJSU\" = '$searchValue'
                    OR  pab.\"IKJSS\" = '$searchValue'
                    OR  pab.\"IKJSM\" = '$searchValue'
                    OR  pab.\"ABS\" = '$searchValue'
                    OR  pab.\"T\" = '$searchValue'
                    OR  pab.\"SKD\" = '$searchValue'
                    OR  pab.\"cuti\" = '$searchValue'
                    OR  pab.\"HL\" = '$searchValue'
                    OR  pab.\"PT\" = '$searchValue'
                    OR  pab.\"PI\" = '$searchValue'
                    OR  pab.\"PM\" = '$searchValue'
                    OR  pab.\"DL\" = '$searchValue'
                    OR  pab.\"tambahan\" = '$searchValue'
                    OR  pab.\"duka\" = '$searchValue'
                    OR  pab.\"potongan\" = '$searchValue'
                    OR  pab.\"HC\" = '$searchValue'
                    OR  pab.\"jml_UM\" = '$searchValue'
                    OR  pab.\"cicil\" = '$searchValue'
                    OR  pab.\"potongan_koperasi\" = '$searchValue'
                    OR  pab.\"UBS\" = '$searchValue'
                    OR  pab.\"UM_puasa\" = '$searchValue'
                    OR  pab.\"SK_CT\" = '$searchValue'
                    OR  pab.\"POT_2\" = '$searchValue'
                    OR  pab.\"TAMB_2\" = '$searchValue'
                    OR  pab.\"jml_izin\" = '$searchValue'
                    OR  pab.\"jml_mangkir\" = '$searchValue'
                ";
            }
            $condition = "
                WHERE
                    pab.noind ILIKE '%$searchValue%'
                OR  pab.kodesie ILIKE '%$searchValue%'
                OR  pab.\"HM01\" ILIKE '%$searchValue%'
                OR  pab.\"HM02\" ILIKE '%$searchValue%'
                OR  pab.\"HM03\" ILIKE '%$searchValue%'
                OR  pab.\"HM04\" ILIKE '%$searchValue%'
                OR  pab.\"HM05\" ILIKE '%$searchValue%'
                OR  pab.\"HM06\" ILIKE '%$searchValue%'
                OR  pab.\"HM07\" ILIKE '%$searchValue%'
                OR  pab.\"HM08\" ILIKE '%$searchValue%'
                OR  pab.\"HM09\" ILIKE '%$searchValue%'
                OR  pab.\"HM10\" ILIKE '%$searchValue%'
                OR  pab.\"HM11\" ILIKE '%$searchValue%'
                OR  pab.\"HM12\" ILIKE '%$searchValue%'
                OR  pab.\"HM13\" ILIKE '%$searchValue%'
                OR  pab.\"HM14\" ILIKE '%$searchValue%'
                OR  pab.\"HM15\" ILIKE '%$searchValue%'
                OR  pab.\"HM16\" ILIKE '%$searchValue%'
                OR  pab.\"HM17\" ILIKE '%$searchValue%'
                OR  pab.\"HM18\" ILIKE '%$searchValue%'
                OR  pab.\"HM19\" ILIKE '%$searchValue%'
                OR  pab.\"HM20\" ILIKE '%$searchValue%'
                OR  pab.\"HM21\" ILIKE '%$searchValue%'
                OR  pab.\"HM22\" ILIKE '%$searchValue%'
                OR  pab.\"HM23\" ILIKE '%$searchValue%'
                OR  pab.\"HM24\" ILIKE '%$searchValue%'
                OR  pab.\"HM25\" ILIKE '%$searchValue%'
                OR  pab.\"HM26\" ILIKE '%$searchValue%'
                OR  pab.\"HM27\" ILIKE '%$searchValue%'
                OR  pab.\"HM28\" ILIKE '%$searchValue%'
                OR  pab.\"HM29\" ILIKE '%$searchValue%'
                OR  pab.\"HM30\" ILIKE '%$searchValue%'
                OR  pab.\"HM31\" ILIKE '%$searchValue%'
                OR  pab.\"kode_lokasi\" ILIKE '%$searchValue%'
                OR  eea.employee_name ILIKE '%$searchValue%'
                OR  unit_name ILIKE '%$searchValue%'
            ";
        }
        $sql="
            SELECT * FROM pr.pr_absensi pab
            LEFT JOIN er.er_employee_all eea ON eea.employee_code = pab.noind
            LEFT JOIN (SELECT distinct substring(section_code, 0, 7) as section_code, rtrim(unit_name) FROM er.er_section WHERE unit_name != '-') as t(section_code_substr, unit_name) ON section_code_substr = pab.kodesie

            $condition

            ORDER BY \"$order_col\" $order_dir LIMIT $limit OFFSET $offset
            ";
        $query = $this->db->query($sql);
        return $query;
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