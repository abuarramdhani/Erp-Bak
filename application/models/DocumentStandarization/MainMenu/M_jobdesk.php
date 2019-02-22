<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_jobdesk extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getJobdesk($id = FALSE)
    {
    	if ($id === FALSE) {
            $query  = " select      jd.jd_id as kode_jobdesc,
                                    seksi.department_name as departemen,
                                    seksi.field_name as bidang,
                                    seksi.unit_name as unit,
                                    seksi.section_name as seksi,
                                    jd.jd_name as nama_jobdesc,
                                    jd.jd_detail as detail_jobdesc,
                                    jd.kodesie as kodesie
                        from        ds.ds_jobdesk as jd
                                    join    er.er_section as seksi
                                            on  seksi.section_code=jd.kodesie
                        order by    kodesie, kode_jobdesc;";
            $query  =   $this->db->query($query);

    	} else {
            $query  = " select      jd.jd_id as kode_jobdesc,
                                    seksi.department_name as departemen,
                                    seksi.field_name as bidang,
                                    seksi.unit_name as unit,
                                    seksi.section_name as seksi,
                                    jd.jd_name as nama_jobdesc,
                                    jd.jd_detail as detail_jobdesc,
                                    jd.kodesie as kodesie
                        from        ds.ds_jobdesk as jd
                                    join    er.er_section as seksi
                                            on  seksi.section_code=jd.kodesie
                        where       jd.jd_id=$id;";
            $query  =   $this->db->query($query);
    	}

    	return $query->result_array();
    }

    public function setJobdesk($data)
    {
        return $this->db->insert('ds.ds_jobdesk', $data);
    }

    public function updateJobdesk($data, $id)
    {
        $this->db->where('jd_id', $id);
        $this->db->update('ds.ds_jobdesk', $data);
    }

    public function deleteJobdesk($id)
    {
        $this->db->where('jd_id', $id);
        $this->db->delete('ds.ds_jobdesk');
    }
}

/* End of file M_jobdesk.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdesk.php */
/* Generated automatically on 2017-09-14 11:03:22 */