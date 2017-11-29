<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dokumenpekerja extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function ambilLinkDokumenCOP()
    {
    	$ambilLinkDokumenCOP 		= "	select 		cop.cop_file as link_dokumen,
													concat_ws(' - ', cop.no_kontrol, cop.no_revisi, cop.cop_name) as nama_dokumen
										from 		ds.ds_code_of_practice as cop;";
		$queryAmbilLinkDokumenCOP 	= 	$this->db->query($ambilLinkDokumenCOP);
		return $queryAmbilLinkDokumenCOP->result_array();
    }

    public function ambilDaftarDokumen($kategoriPencarian = FALSE, $katakunciPencarian = FALSE)
    {
        if($kategoriPencarian === FALSE)
        {
            $kp='';       
        }
        else
        {
            $kp='';
        }
            $ambilDaftarDokumen         = " select      coalesce(nullif(concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name), ''), '-') as business_process,
                                                        1 as relasi_bp,
                                                        coalesce(bp.bp_file, '#') as link_bp,
                                                        coalesce(nullif(concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name), ''), '-') as context_diagram,
                                                        1 as relasi_cd,
                                                        coalesce(cd.cd_file, '#') as link_cd,
                                                        coalesce(nullif(concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name), ''), '-') as standard_operating_procedure,
                                                        1 as relasi_sop,
                                                        coalesce(sop.sop_file, '#') as link_sop,
                                                        coalesce(nullif(concat_ws(' - ', wi.no_kontrol, wi.no_revisi, wi.wi_name), ''), '-') as work_instruction,
                                                        (
                                                            case    coalesce(nullif(concat_ws(' - ', wi.no_kontrol, wi.no_revisi, wi.wi_name), ''), '-')    when    '-'
                                                                                                                                                                    then    0
                                                                                                                                                            else    1
                                                            end
                                                        ) as relasi_wi,
                                                        coalesce(wi.wi_file, '#') as link_wi,
                                                        coalesce(nullif(concat_ws(' - ', cop.no_kontrol, cop.no_revisi, cop.cop_name), ''), '-') as code_of_practice,
                                                        (
                                                            case    coalesce(nullif(concat_ws(' - ', cop.no_kontrol, cop.no_revisi, cop.cop_name), ''), '-')    when    '-'
                                                                                                                                                                        then    0
                                                                                                                                                                else    1
                                                            end
                                                        ) as relasi_cop,
                                                        coalesce(cop.cop_file, '#') as link_cop
                                            from        ds.ds_business_process as bp
                                                        left join       ds.ds_context_diagram as cd
                                                                        on  cd.bp_id=bp.bp_id
                                                        left outer join ds.ds_standard_operating_procedure as sop
                                                                        on  sop.bp_id=bp.bp_id
                                                                            and     sop.cd_id=cd.cd_id
                                                        left outer join ds.ds_work_instruction as wi
                                                                        on  wi.bp_id=bp.bp_id
                                                                            and     wi.cd_id=cd.cd_id
                                                                            and     wi.sop_id=sop.sop_id
                                                        left outer join ds.ds_code_of_practice as cop
                                                                        on  cop.bp_id=bp.bp_id
                                                                            and     cop.cd_id=cd.cd_id
                                                                            and     cop.sop_id=sop.sop_id
                                            union
                                            select      '-' as business_process,
                                                        0 as relasi_bp,
                                                        '#' as link_bp,
                                                        '-' as context_diagram,
                                                        0 as relasi_cd,
                                                        '#' as link_cd,
                                                        '-' as standard_operating_procedure,
                                                        0 as relasi_sop,
                                                        '#' as link_sop,
                                                        concat_ws(' - ', wi.no_kontrol, wi.no_revisi, wi.wi_name) as work_instruction,
                                                        1 as relasi_wi,
                                                        coalesce(wi.wi_file, '#') as link_wi,
                                                        '-' as code_of_practice,
                                                        0 as relasi_cop,
                                                        '#' as link_wi
                                            from        ds.ds_work_instruction as wi
                                            where       wi.sop_id is null
                                                        and     wi.cd_id is null
                                                        and     wi.bp_id is null
                                            union
                                            select      '-' as business_process,
                                                        0 as relasi_bp,
                                                        '#' as link_bp,
                                                        '-' as context_diagram,
                                                        0 as relasi_cd,
                                                        '#' as link_cd,
                                                        '-' as standard_operating_procedure,
                                                        0 as relasi_sop,
                                                        '#' as link_sop,
                                                        '-' as work_instruction,
                                                        0 as relasi_wi,
                                                        '#' as link_wi,
                                                        concat_ws(' - ', cop.no_kontrol, cop.no_revisi, cop.cop_name) as code_of_practice,
                                                        1 as relasi_cop,
                                                        coalesce(cop.cop_file, '#') as link_cop
                                            from        ds.ds_code_of_practice as cop
                                            where       cop.sop_id is null
                                                        and     cop.cd_id is null
                                                        and     cop.bp_id is null
                                            order by    relasi_bp desc,
                                                        relasi_cd desc,
                                                        relasi_sop desc,
                                                        relasi_wi desc,
                                                        relasi_cop desc,
                                                        business_process,
                                                        context_diagram,
                                                        standard_operating_procedure,
                                                        work_instruction,
                                                        code_of_practice;";
            $queryAmbilDaftarDokumen    =   $this->db->query($ambilDaftarDokumen);                                                        

        return $queryAmbilDaftarDokumen->result_array();
    }
}