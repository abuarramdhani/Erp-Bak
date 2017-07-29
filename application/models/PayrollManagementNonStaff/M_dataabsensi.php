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
                OR  CAST(pab.\"bln_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"thn_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"jam_lembur\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HMP\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HMU\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HMS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HMM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"UBT\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HUPAMK\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IK\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKSKP\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKSKU\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKSKS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKSKM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKJSP\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKJSU\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKJSS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKJSM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"ABS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"T\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"SKD\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"cuti\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HL\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"PT\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"PI\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"PM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"DL\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"tambahan\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"duka\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"potongan\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HC\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"jml_UM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"cicil\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"potongan_koperasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"UBS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"UM_puasa\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"SK_CT\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"POT_2\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"TAMB_2\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"jml_izin\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"jml_mangkir\" AS TEXT) ILIKE '%$searchValue%'

        ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAbsensiOrderLimit($searchValue, $order_col, $order_dir, $limit, $offset){
        if ($searchValue == NULL || $searchValue == "") {
            $condition = "";
        }
        else{
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
                OR  CAST(pab.\"bln_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"thn_gaji\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"jam_lembur\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HMP\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HMU\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HMS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HMM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"UBT\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HUPAMK\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IK\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKSKP\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKSKU\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKSKS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKSKM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKJSP\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKJSU\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKJSS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"IKJSM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"ABS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"T\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"SKD\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"cuti\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HL\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"PT\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"PI\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"PM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"DL\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"tambahan\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"duka\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"potongan\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"HC\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"jml_UM\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"cicil\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"potongan_koperasi\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"UBS\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"UM_puasa\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"SK_CT\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"POT_2\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"TAMB_2\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"jml_izin\" AS TEXT) ILIKE '%$searchValue%'
                OR  CAST(pab.\"jml_mangkir\" AS TEXT) ILIKE '%$searchValue%'

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