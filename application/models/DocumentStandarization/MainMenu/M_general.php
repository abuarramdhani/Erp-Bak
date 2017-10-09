<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_general extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function ambilSemuaPekerja()
    {
        $ambilSemuaPekerja  =   "   select      /*pkj.**/
                                                pkj.employee_code as kode_pekerja,
                                                pkj.employee_name as nama_pekerja,
                                                concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar_pekerja,
                                                pkj.employee_id as id_pekerja
                                    from        er.er_employee_all as pkj
                                    where       /*pkj.resign='0'
                                                and    */pkj.employee_code!='Z0000'
                                    order by    pkj.employee_code;";
        $queryAmbilSemuaPekerja     =   $this->db->query($ambilSemuaPekerja);
        return $queryAmbilSemuaPekerja->result_array();
    }

    public function ambilPekerjaMinKasie()
    {
        $ambilPekerjaMinKasie  = "  select      /*pkj.**/
                                                pkj.employee_code as kode_pekerja,
                                                pkj.employee_name as nama_pekerja,
                                                concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar_pekerja,
                                                pkj.employee_id as id_pekerja
                                    from        er.er_employee_all as pkj
                                    where       SUBSTR(pkj.section_code,8,2)='00'
                                                and     pkj.employee_code!='Z0000'
                                    order by    pkj.employee_code;";
        $queryAmbilPekerjaMinKasie     =   $this->db->query($ambilPekerjaMinKasie);
        return $queryAmbilPekerjaMinKasie->result_array();
    }

    public function ambilPekerjaPembuat($keyword)
    {
        $ambilPekerjaPembuat  =   "   select      /*pkj.**/
                                                pkj.employee_code as kode_pekerja,
                                                pkj.employee_name as nama_pekerja,
                                                concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar_pekerja,
                                                pkj.employee_id as id_pekerja
                                    from        er.er_employee_all as pkj
                                    where       /*pkj.resign='0'
                                                and    */pkj.employee_code!='Z0000'
                                                and     (
                                                            pkj.employee_code LIKE '%$keyword%'
                                                            OR  pkj.employee_name LIKE '%$keyword%'
                                                        )
                                    order by    pkj.employee_code;";
        $queryAmbilPekerjaPembuat     =   $this->db->query($ambilPekerjaPembuat);
        return $queryAmbilPekerjaPembuat->result_array();
    }

    public function ambilPekerjaPemeriksa1($keyword)
    {
        $ambilPekerjaMinKasie  = "  select      /*pkj.**/
                                                pkj.employee_code as kode_pekerja,
                                                pkj.employee_name as nama_pekerja,
                                                concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar_pekerja,
                                                pkj.employee_id as id_pekerja
                                    from        er.er_employee_all as pkj
                                    where       SUBSTR(pkj.section_code,8,2)='00'
                                                and     pkj.employee_code!='Z0000'
                                                and     (
                                                            pkj.employee_code LIKE '%$keyword%'
                                                            OR  pkj.employee_name LIKE '%$keyword%'
                                                        )                                                
                                    order by    pkj.employee_code;";
        $queryAmbilPekerjaMinKasie     =   $this->db->query($ambilPekerjaMinKasie);
        return $queryAmbilPekerjaMinKasie->result_array();
    }    

    public function ambilPekerjaPemeriksa2($keyword)
    {
        $ambilPekerjaMinKasie  = "  select      /*pkj.**/
                                                pkj.employee_code as kode_pekerja,
                                                pkj.employee_name as nama_pekerja,
                                                concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar_pekerja,
                                                pkj.employee_id as id_pekerja
                                    from        er.er_employee_all as pkj
                                    where       SUBSTR(pkj.section_code,8,2)='00'
                                                and     pkj.employee_code!='Z0000'
                                                and     (
                                                            pkj.employee_code LIKE '%$keyword%'
                                                            OR  pkj.employee_name LIKE '%$keyword%'
                                                        )                                                
                                    order by    pkj.employee_code;";
        $queryAmbilPekerjaMinKasie     =   $this->db->query($ambilPekerjaMinKasie);
        return $queryAmbilPekerjaMinKasie->result_array();
    }    

    public function ambilPekerjaPemberiKeputusan($keyword)
    {
        $ambilPekerjaMinKaUnit  = "  select      /*pkj.**/
                                                pkj.employee_code as kode_pekerja,
                                                pkj.employee_name as nama_pekerja,
                                                concat_ws(' - ', pkj.employee_code, pkj.employee_name) as daftar_pekerja,
                                                pkj.employee_id as id_pekerja
                                    from        er.er_employee_all as pkj
                                    where       SUBSTR(pkj.section_code,6,4)='0000'
                                                and     pkj.employee_code!='Z0000'
                                                and     (
                                                            pkj.employee_code LIKE '%$keyword%'
                                                            OR  pkj.employee_name LIKE '%$keyword%'
                                                        )                                                
                                    order by    pkj.employee_code;";
        $queryAmbilPekerjaMinKaUnit     =   $this->db->query($ambilPekerjaMinKaUnit);
        return $queryAmbilPekerjaMinKaUnit->result_array();
    }    

    public function ambilDaftarBusinessProcess()
    {
        $ambilDaftarBusinessProcess     = " select      bp.bp_id as id_business_process,
                                                        bp.bp_name as nama_business_process,
                                                        concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name) as daftar_business_process
                                            from        ds.ds_business_process as bp
                                            order by    bp.bp_id asc, bp.tanggal desc;";
        $queryDaftarBusinessProcess     =   $this->db->query($ambilDaftarBusinessProcess);
        return $queryDaftarBusinessProcess->result_array();
    }

    public function ambilDaftarContextDiagram()
    {
        $ambilDaftarContextDiagram      = " select      cd.cd_id as id_context_diagram,
                                                        cd.cd_name as nama_context_diagram,
                                                        concat_ws(' - ', concat_ws('-Rev. ',cd.no_kontrol, cd.no_revisi), cd.cd_name) as daftar_context_diagram
                                            from        ds.ds_context_diagram as cd
                                            order by    cd.cd_id asc, cd.tanggal desc;";
        $queryDaftarContextDiagram      =   $this->db->query($ambilDaftarContextDiagram);
        return $queryDaftarContextDiagram->result_array();
    }

    public function ambilDaftarStandardOperatingProcedure()
    {
        $ambilDaftarSOP                 = " select      sop.sop_id as id_standard_operating_procedure,
                                                        sop.sop_name as nama_standard_operating_procedure,
                                                        concat_ws(' - ', concat_ws('-Rev. ',sop.no_kontrol, sop.no_revisi), sop.sop_name) as daftar_standard_operating_procedure
                                            from        ds.ds_standard_operating_procedure as sop
                                            order by    sop.sop_id asc, sop.tanggal desc;";
        $queryDaftarSOP                 =   $this->db->query($ambilDaftarSOP);
        return $queryDaftarSOP->result_array();
    }

    public function cekBusinessProcess($id)
    {
        $cekBusinessProcess     = " select      bp.bp_id as kode_business_process
                                    from        ds.ds_context_diagram as cd
                                                join    ds.ds_business_process as bp
                                                    on  bp.bp_id=cd.bp_id
                                    where       cd.cd_id=$id;";
        $queryCekBusinessProcess    =   $this->db->query($cekBusinessProcess);
        return $queryCekBusinessProcess->result();
    }

    public function cekContextDiagram($id)
    {
        $cekContextDiagram      = " select      cd.cd_id as kode_context_diagram
                                    from        ds.ds_standard_operating_procedure as sop
                                                join    ds.ds_context_diagram as cd
                                                    on  cd.cd_id=sop.cd_id
                                    where       sop.sop_id=$id;";
        $queryCekContextDiagram =   $this->db->query($cekContextDiagram);
        return $queryCekContextDiagram->result();
    }

    public function ambilSemuaDokumen()
    {
        $ambilSemuaDokumen  = " select      'Business Process' as jenis_dokumen,
                                            'BP' as inisial_jenis_dokumen,
                                            bp.bp_id as kode_dokumen,
                                            bp.bp_name as nama_dokumen,
                                            bp.no_kontrol as nomor_dokumen,
                                            bp.no_revisi as nomor_revisi,
                                            bp.tanggal as tanggal_revisi,
                                            to_char(bp.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                            to_char(bp.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file
                                from        ds.ds_business_process as bp
                                union
                                select      'Context Diagram' as jenis_dokumen,
                                            'CD' as inisial_jenis_dokumen,
                                            cd.cd_id as kode_dokumen,
                                            cd.cd_name as nama_dokumen,
                                            cd.no_kontrol as nomor_dokumen,
                                            cd.no_revisi as nomor_revisi,
                                            cd.tanggal as tanggal_revisi,
                                            to_char(cd.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                            to_char(cd.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file
                                from        ds.ds_context_diagram as cd
                                union
                                select      'Standard Operating Procedure' as jenis_dokumen,
                                            'SOP' as inisial_jenis_dokumen,
                                            sop.sop_id as kode_dokumen,
                                            sop.sop_name as nama_dokumen,
                                            sop.no_kontrol as nomor_dokumen,
                                            sop.no_revisi as nomor_revisi,
                                            sop.tanggal as tanggal_revisi,
                                            to_char(sop.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                            to_char(sop.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file
                                from        ds.ds_standard_operating_procedure as sop
                                union
                                select      'Work Instruction' as jenis_dokumen,
                                            'WI' as inisial_jenis_dokumen,
                                            wi.wi_id as kode_dokumen,
                                            wi.wi_name as nama_dokumen,
                                            wi.no_kontrol as nomor_dokumen,
                                            wi.no_revisi as nomor_revisi,
                                            wi.tanggal as tanggal_revisi,
                                            to_char(wi.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                            to_char(wi.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file
                                from        ds.ds_work_instruction as wi
                                union
                                select      'Code of Practice' as jenis_dokumen,
                                            'COP' as inisial_jenis_dokumen,
                                            cop.cop_id as kode_dokumen,
                                            cop.cop_name as nama_dokumen,
                                            cop.no_kontrol as nomor_dokumen,
                                            cop.no_revisi as nomor_revisi,
                                            cop.tanggal as tanggal_revisi,
                                            to_char(cop.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                            to_char(cop.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file
                                from        ds.ds_code_of_practice as cop
                                order by    nomor_dokumen;";
        $queryAmbilSemuaDokumen     =   $this->db->query($ambilSemuaDokumen);
        return $queryAmbilSemuaDokumen->result_array();
    }

}

/* End of file M_jobdesk.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdesk.php */
/* Generated automatically on 2017-09-14 11:03:22 */