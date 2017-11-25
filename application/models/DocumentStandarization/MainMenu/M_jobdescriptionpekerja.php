<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_jobdescriptionpekerja extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getJobdeskEmployee($id = FALSE)
    {
    	if ($id === FALSE) {
            $ambilJobDescriptionPekerja         = " select      jdpkj.jd_e_id as kode_detail_jobdesc_pekerja,
                                                                jdpkj.jd_id as kode_jobdesc,
                                                                jdpkj.employee_code as nomor_induk_pekerja,
                                                                pkj.employee_name as nama_pekerja,
                                                                seksi.department_name as nama_departemen,
                                                                seksi.field_name as nama_bidang,
                                                                seksi.unit_name as nama_unit,
                                                                seksi.section_name as nama_seksi,
                                                                masterjd.jd_detail as job_description
                                                    from        ds.ds_jobdesk_employee as jdpkj
                                                                left join       ds.ds_jobdesk as masterjd
                                                                        on      masterjd.jd_id=jdpkj.jd_id
                                                                left outer join er.er_section as seksi
                                                                        on      seksi.section_code=masterjd.kodesie
                                                                left join       er.er_employee_all as pkj
                                                                        on      pkj.employee_code=jdpkj.employee_code;";

    		$query = $this->db->query($ambilJobDescriptionPekerja);
    	} else {
            $ambilJobDescriptionPekerja         = " select      jdpkj.jd_e_id as kode_detail_jobdesc_pekerja,
                                                                jdpkj.jd_id as kode_jobdesc,
                                                                jdpkj.employee_code as nomor_induk_pekerja,
                                                                pkj.employee_name as nama_pekerja,
                                                                seksi.department_name as nama_departemen,
                                                                seksi.field_name as nama_bidang,
                                                                seksi.unit_name as nama_unit,
                                                                seksi.section_name as nama_seksi,
                                                                masterjd.jd_detail as job_description,
                                                                masterjd.jd_name as nama_job_description
                                                    from        ds.ds_jobdesk_employee as jdpkj
                                                                left join       ds.ds_jobdesk as masterjd
                                                                        on      masterjd.jd_id=jdpkj.jd_id
                                                                left outer join er.er_section as seksi
                                                                        on      seksi.section_code=masterjd.kodesie
                                                                left join       er.er_employee_all as pkj
                                                                        on      pkj.employee_code=jdpkj.employee_code
                                                    where       jdpkj.jd_e_id=".$id.";";
            $query = $this->db->query($ambilJobDescriptionPekerja);                                                    
    	}

    	return $query->result_array();
    }

    public function setJobdeskEmployee($data)
    {
        return $this->db->insert('ds.ds_jobdesk_employee', $data);
    }

    public function updateJobdeskEmployee($data, $id)
    {
        $this->db->where('jd_e_id', $id);
        $this->db->update('ds.ds_jobdesk_employee', $data);
    }

    public function deleteJobdeskEmployee($id)
    {
        $this->db->where('jd_e_id', $id);
        $this->db->delete('ds.ds_jobdesk_employee');
    }

    public function ambilKodeJobDescription($id)
        {
            $ambilKodeJobDescription                = " select      jdpkj.jd_id as kode_jobdesc
                                                        from        ds.ds_jobdesk_employee as jdpkj
                                                        where       jd_e_id=".$id.";";
            $queryAmbilKodeJobDescription           =   $this->db->query($ambilKodeJobDescription);
            $hasilAmbilKodeJobDescription           =   $queryAmbilKodeJobDescription->result_array();
            return $hasilAmbilKodeJobDescription[0]['kode_jobdesc'];
        }    
}

/* End of file M_jobdeskemployee.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdeskemployee.php */
/* Generated automatically on 2017-09-14 11:04:06 */