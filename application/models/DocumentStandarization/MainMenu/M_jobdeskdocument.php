<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_jobdeskdocument extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getJobdeskDocument($id = FALSE)
    {
    	if ($id === FALSE) {
    		$query = $this->db->get('ds.ds_jobdesk_detail');
    	} else {
    		$query = $this->db->get_where('ds.ds_jobdesk_detail', array('jd_d_id' => $id));
    	}

    	return $query->result_array();
    }

    public function setJobdeskDocument($data)
    {
        return $this->db->insert('ds.ds_jobdesk_detail', $data);
    }

    public function updateJobdeskDocument($data, $id)
    {
        $this->db->where('jd_d_id', $id);
        $this->db->update('ds.ds_jobdesk_document', $data);
    }

    public function deleteJobdeskDocument($id)
    {
        $this->db->where('jd_d_id', $id);
        $this->db->delete('ds.ds_jobdesk_document');
    }

    public function ambilJobDescription()
    {
        $ambilJobDescription        = " select      jd.jd_id as kode_jobdesc,
                                                    jd.jd_name as nama_jobdesc,
                                                    seksi.department_name as nama_departemen,
                                                    seksi.field_name as nama_bidang,
                                                    seksi.unit_name as nama_unit,
                                                    seksi.section_name as nama_seksi,
                                                    seksi.section_code as kodesie
                                        from        ds.ds_jobdesk as jd
                                                    left join   er.er_section as seksi
                                                                on  seksi.section_code=jd.kodesie
                                        order by    kodesie desc;";
        $queryAmbilJobDescription   =   $this->db->query($ambilJobDescription);
        return $queryAmbilJobDescription->result_array();
    }

    public function ambilDokumenJobDescription()
    {
        $ambilDokumenJobDescription         = " select      jddtl.jd_id as kode_jobdesc,
                                                            jddtl.document_id as kode_dokumen,
                                                            case split_part(jddtl.document_id, '-', 1)  when    'BP'
                                                                                                                then    (
                                                                                                                            select  bp.bp_file
                                                                                                                            from    ds.ds_business_process as bp
                                                                                                                            where   bp.bp_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                                                                        when    'CD'
                                                                                                                then    (
                                                                                                                            select  cd.cd_file
                                                                                                                            from    ds.ds_context_diagram as cd
                                                                                                                            where   cd.cd_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                                                                        when    'SOP'
                                                                                                                then    (
                                                                                                                            select  sop.sop_file
                                                                                                                            from    ds.ds_standard_operating_procedure as sop
                                                                                                                            where   sop.sop_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                                                                        when    'WI'
                                                                                                                then    (
                                                                                                                            select  wi.wi_file
                                                                                                                            from    ds.ds_work_instruction as wi
                                                                                                                            where   wi.wi_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                                                                        when    'COP'
                                                                                                                then    (
                                                                                                                            select  cop.cop_file
                                                                                                                            from    ds.ds_code_of_practice as cop
                                                                                                                            where   cop.cop_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                            end as file,
                                                            case split_part(jddtl.document_id, '-', 1)  when    'BP'
                                                                                                                then    (
                                                                                                                            select  concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name)
                                                                                                                            from    ds.ds_business_process as bp
                                                                                                                            where   bp.bp_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                                                                        when    'CD'
                                                                                                                then    (
                                                                                                                            select  concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name)
                                                                                                                            from    ds.ds_context_diagram as cd
                                                                                                                            where   cd.cd_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                                                                        when    'SOP'
                                                                                                                then    (
                                                                                                                            select  concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name)
                                                                                                                            from    ds.ds_standard_operating_procedure as sop
                                                                                                                            where   sop.sop_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                                                                        when    'WI'
                                                                                                                then    (
                                                                                                                            select  concat_ws(' - ', wi.no_kontrol, wi.no_revisi, wi.wi_name)
                                                                                                                            from    ds.ds_work_instruction as wi
                                                                                                                            where   wi.wi_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                                                                        when    'COP'
                                                                                                                then    (
                                                                                                                            select  concat_ws(' - ', cop.no_kontrol, cop.no_revisi, cop.cop_name)
                                                                                                                            from    ds.ds_code_of_practice as cop
                                                                                                                            where   cop.cop_id=cast((split_part(jddtl.document_id, '-', 2)) as int)
                                                                                                                        )
                                                            end as nama_dokumen         
                                                from        ds.ds_jobdesk_detail as jddtl";
        $queryAmbilDokumenJobDescription        =   $this->db->query($ambilDokumenJobDescription);
        return $queryAmbilDokumenJobDescription->result_array();
    }
}

/* End of file M_jobdeskdocument.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdeskdocument.php */
/* Generated automatically on 2017-09-14 11:03:46 */