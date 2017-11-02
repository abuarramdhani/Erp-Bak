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
                                                and     pkj.employee_code!='Z0001'
                                                and     (
                                                            pkj.employee_code LIKE '%$keyword%'
                                                            OR  pkj.employee_name LIKE '%$keyword%'
                                                        )
                                    order by    pkj.employee_code;";
        $ambilPekerjaPembuat  =   " select      pkj.employee_name as nama_pekerja,
                                                pkj.date_of_birth,
                                                (
                                                    case    when    (
                                                                        (
                                                                            select      count(*)
                                                                            from        er.er_employee_all as pkj2
                                                                            where       pkj2.employee_name=pkj.employee_name
                                                                                        and     pkj2.date_of_birth=pkj.date_of_birth
                                                                                        and     pkj2.employee_code!='Z0000'
                                                                                        and     pkj2.employee_code!='Z0001'
                                                                        )
                                                                        !=1
                                                                    )
                                                                    then    (
                                                                                select      pkj3.employee_code
                                                                                from        er.er_employee_all as pkj3
                                                                                where       pkj3.employee_name=pkj.employee_name
                                                                                            and     pkj3.date_of_birth=pkj.date_of_birth
                                                                                            and     pkj3.employee_code!='Z0000'
                                                                                            and     pkj3.employee_code!='Z0001'
                                                                                            and     pkj3.resign_date=(
                                                                                                                    select              MAX(pkj4.resign_date)
                                                                                                                    from                er.er_employee_all as pkj4
                                                                                                                    where               pkj4.employee_name=pkj.employee_name
                                                                                                                                        and     pkj4.date_of_birth=pkj.date_of_birth
                                                                                                                                        and     pkj4.employee_code!='Z0000'
                                                                                                                                        and     pkj4.employee_code!='Z0001'
                                                                                                    )
                                                                            )
                                                            else    (
                                                                        select      pkj5.employee_code
                                                                        from        er.er_employee_all as pkj5
                                                                        where       pkj5.employee_name=pkj.employee_name
                                                                                    and     pkj5.date_of_birth=pkj.date_of_birth
                                                                                    and     pkj5.employee_code!='Z0000'
                                                                                    and     pkj5.employee_code!='Z0001'
                                                                    )
                                                    END
                                                ) AS nomor_induk,
                                                (
                                                    case    when    (
                                                                        (
                                                                            select      count(*)
                                                                            from        er.er_employee_all as pkj2
                                                                            where       pkj2.employee_name=pkj.employee_name
                                                                                        and     pkj2.date_of_birth=pkj.date_of_birth
                                                                                        and     pkj2.employee_code!='Z0000'
                                                                                        and     pkj2.employee_code!='Z0001'
                                                                        )
                                                                        !=1
                                                                    )
                                                                    then    (
                                                                                select      pkj3.employee_id
                                                                                from        er.er_employee_all as pkj3
                                                                                where       pkj3.employee_name=pkj.employee_name
                                                                                            and     pkj3.date_of_birth=pkj.date_of_birth
                                                                                            and     pkj3.employee_code!='Z0000'
                                                                                            and     pkj3.employee_code!='Z0001'
                                                                                            and     pkj3.resign_date=(
                                                                                                                    select              MAX(pkj4.resign_date)
                                                                                                                    from                er.er_employee_all as pkj4
                                                                                                                    where               pkj4.employee_name=pkj.employee_name
                                                                                                                                        and     pkj4.date_of_birth=pkj.date_of_birth
                                                                                                                                        and     pkj4.employee_code!='Z0000'
                                                                                                                                        and     pkj4.employee_code!='Z0001'
                                                                                                    )
                                                                            )
                                                            else    (
                                                                        select      pkj5.employee_id
                                                                        from        er.er_employee_all as pkj5
                                                                        where       pkj5.employee_name=pkj.employee_name
                                                                                    and     pkj5.date_of_birth=pkj.date_of_birth
                                                                                    and     pkj5.employee_code!='Z0000'
                                                                                    and     pkj5.employee_code!='Z0001'
                                                                    )
                                                    END
                                                ) AS id_pekerja 
                                    from        er.er_employee_all as pkj
                                    where       pkj.employee_code is not null
                                                and     pkj.employee_name like '%$keyword%'
                                                and     pkj.employee_code!='Z0000'
                                                and     pkj.employee_code!='Z0001'
                                    group by    pkj.employee_name, pkj.date_of_birth
                                    order by    nomor_induk;";

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
                                                and     pkj.employee_code!='Z0001'
                                                and     (
                                                            pkj.employee_code LIKE '%$keyword%'
                                                            OR  pkj.employee_name LIKE '%$keyword%'
                                                        )                                                
                                    order by    pkj.employee_code;";
        $ambilPekerjaMinKasie  = "  select      pkj.employee_name as nama_pekerja,
                                                pkj.date_of_birth,
                                                (
                                                    case    when    (
                                                                        (
                                                                            select      count(*)
                                                                            from        er.er_employee_all as pkj2
                                                                            where       pkj2.employee_name=pkj.employee_name
                                                                                        and     pkj2.date_of_birth=pkj.date_of_birth
                                                                                        and     pkj2.employee_code!='Z0000'
                                                                                        and     pkj2.employee_code!='Z0001'
                                                                        )
                                                                        !=1
                                                                    )
                                                                    then    (
                                                                                select      pkj3.employee_code
                                                                                from        er.er_employee_all as pkj3
                                                                                where       pkj3.employee_name=pkj.employee_name
                                                                                            and     pkj3.date_of_birth=pkj.date_of_birth
                                                                                            and     pkj3.employee_code!='Z0000'
                                                                                            and     pkj3.employee_code!='Z0001'
                                                                                            and     pkj3.resign_date=(
                                                                                                                    select              MAX(pkj4.resign_date)
                                                                                                                    from                er.er_employee_all as pkj4
                                                                                                                    where               pkj4.employee_name=pkj.employee_name
                                                                                                                                        and     pkj4.date_of_birth=pkj.date_of_birth
                                                                                                                                        and     pkj4.employee_code!='Z0000'
                                                                                                                                        and     pkj4.employee_code!='Z0001'
                                                                                                    )
                                                                            )
                                                            else    (
                                                                        select      pkj5.employee_code
                                                                        from        er.er_employee_all as pkj5
                                                                        where       pkj5.employee_name=pkj.employee_name
                                                                                    and     pkj5.date_of_birth=pkj.date_of_birth
                                                                                    and     pkj5.employee_code!='Z0000'
                                                                                    and     pkj5.employee_code!='Z0001'
                                                                    )
                                                    END
                                                ) AS nomor_induk,
                                                (
                                                    case    when    (
                                                                        (
                                                                            select      count(*)
                                                                            from        er.er_employee_all as pkj2
                                                                            where       pkj2.employee_name=pkj.employee_name
                                                                                        and     pkj2.date_of_birth=pkj.date_of_birth
                                                                                        and     pkj2.employee_code!='Z0000'
                                                                                        and     pkj2.employee_code!='Z0001'
                                                                        )
                                                                        !=1
                                                                    )
                                                                    then    (
                                                                                select      pkj3.employee_id
                                                                                from        er.er_employee_all as pkj3
                                                                                where       pkj3.employee_name=pkj.employee_name
                                                                                            and     pkj3.date_of_birth=pkj.date_of_birth
                                                                                            and     pkj3.employee_code!='Z0000'
                                                                                            and     pkj3.employee_code!='Z0001'
                                                                                            and     pkj3.resign_date=(
                                                                                                                    select              MAX(pkj4.resign_date)
                                                                                                                    from                er.er_employee_all as pkj4
                                                                                                                    where               pkj4.employee_name=pkj.employee_name
                                                                                                                                        and     pkj4.date_of_birth=pkj.date_of_birth
                                                                                                                                        and     pkj4.employee_code!='Z0000'
                                                                                                                                        and     pkj4.employee_code!='Z0001'
                                                                                                    )
                                                                            )
                                                            else    (
                                                                        select      pkj5.employee_id
                                                                        from        er.er_employee_all as pkj5
                                                                        where       pkj5.employee_name=pkj.employee_name
                                                                                    and     pkj5.date_of_birth=pkj.date_of_birth
                                                                                    and     pkj5.employee_code!='Z0000'
                                                                                    and     pkj5.employee_code!='Z0001'
                                                                    )
                                                    END
                                                ) AS id_pekerja 
                                    from        er.er_employee_all as pkj
                                    where       pkj.employee_code is not null
                                                and     pkj.employee_name like '%$keyword%'
                                                and     substr(pkj.section_code,8,2)='00'
                                                and     pkj.employee_code!='Z0000'
                                                and     pkj.employee_code!='Z0001'
                                    group by    pkj.employee_name, pkj.date_of_birth
                                    order by    nomor_induk;";

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
                                                and     pkj.employee_code!='Z0001'
                                                and     (
                                                            pkj.employee_code LIKE '%$keyword%'
                                                            OR  pkj.employee_name LIKE '%$keyword%'
                                                        )                                                
                                    order by    pkj.employee_code;";
        $ambilPekerjaMinKasie  = "  select      pkj.employee_name as nama_pekerja,
                                                pkj.date_of_birth,
                                                (
                                                    case    when    (
                                                                        (
                                                                            select      count(*)
                                                                            from        er.er_employee_all as pkj2
                                                                            where       pkj2.employee_name=pkj.employee_name
                                                                                        and     pkj2.date_of_birth=pkj.date_of_birth
                                                                                        and     pkj2.employee_code!='Z0000'
                                                                                        and     pkj2.employee_code!='Z0001'
                                                                        )
                                                                        !=1
                                                                    )
                                                                    then    (
                                                                                select      pkj3.employee_code
                                                                                from        er.er_employee_all as pkj3
                                                                                where       pkj3.employee_name=pkj.employee_name
                                                                                            and     pkj3.date_of_birth=pkj.date_of_birth
                                                                                            and     pkj3.employee_code!='Z0000'
                                                                                            and     pkj3.employee_code!='Z0001'
                                                                                            and     pkj3.resign_date=(
                                                                                                                    select              MAX(pkj4.resign_date)
                                                                                                                    from                er.er_employee_all as pkj4
                                                                                                                    where               pkj4.employee_name=pkj.employee_name
                                                                                                                                        and     pkj4.date_of_birth=pkj.date_of_birth
                                                                                                                                        and     pkj4.employee_code!='Z0000'
                                                                                                                                        and     pkj4.employee_code!='Z0001'
                                                                                                    )
                                                                            )
                                                            else    (
                                                                        select      pkj5.employee_code
                                                                        from        er.er_employee_all as pkj5
                                                                        where       pkj5.employee_name=pkj.employee_name
                                                                                    and     pkj5.date_of_birth=pkj.date_of_birth
                                                                                    and     pkj5.employee_code!='Z0000'
                                                                                    and     pkj5.employee_code!='Z0001'
                                                                    )
                                                    END
                                                ) AS nomor_induk,
                                                (
                                                    case    when    (
                                                                        (
                                                                            select      count(*)
                                                                            from        er.er_employee_all as pkj2
                                                                            where       pkj2.employee_name=pkj.employee_name
                                                                                        and     pkj2.date_of_birth=pkj.date_of_birth
                                                                                        and     pkj2.employee_code!='Z0000'
                                                                                        and     pkj2.employee_code!='Z0001'
                                                                        )
                                                                        !=1
                                                                    )
                                                                    then    (
                                                                                select      pkj3.employee_id
                                                                                from        er.er_employee_all as pkj3
                                                                                where       pkj3.employee_name=pkj.employee_name
                                                                                            and     pkj3.date_of_birth=pkj.date_of_birth
                                                                                            and     pkj3.employee_code!='Z0000'
                                                                                            and     pkj3.employee_code!='Z0001'
                                                                                            and     pkj3.resign_date=(
                                                                                                                    select              MAX(pkj4.resign_date)
                                                                                                                    from                er.er_employee_all as pkj4
                                                                                                                    where               pkj4.employee_name=pkj.employee_name
                                                                                                                                        and     pkj4.date_of_birth=pkj.date_of_birth
                                                                                                                                        and     pkj4.employee_code!='Z0000'
                                                                                                                                        and     pkj4.employee_code!='Z0001'
                                                                                                    )
                                                                            )
                                                            else    (
                                                                        select      pkj5.employee_id
                                                                        from        er.er_employee_all as pkj5
                                                                        where       pkj5.employee_name=pkj.employee_name
                                                                                    and     pkj5.date_of_birth=pkj.date_of_birth
                                                                                    and     pkj5.employee_code!='Z0000'
                                                                                    and     pkj5.employee_code!='Z0001'
                                                                    )
                                                    END
                                                ) AS id_pekerja 
                                    from        er.er_employee_all as pkj
                                    where       pkj.employee_code is not null
                                                and     pkj.employee_name like '%$keyword%'
                                                and     substr(pkj.section_code,8,2)='00'
                                                and     pkj.employee_code!='Z0000'
                                                and     pkj.employee_code!='Z0001'
                                    group by    pkj.employee_name, pkj.date_of_birth
                                    order by    nomor_induk;";

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
                                                and     pkj.employee_code!='Z0001'
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
                                                        concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name) as daftar_context_diagram
                                            from        ds.ds_context_diagram as cd
                                            order by    cd.cd_id asc, cd.tanggal desc;";
        $queryDaftarContextDiagram      =   $this->db->query($ambilDaftarContextDiagram);
        return $queryDaftarContextDiagram->result_array();
    }

    public function ambilDaftarStandardOperatingProcedure()
    {
        $ambilDaftarSOP                 = " select      sop.sop_id as id_standard_operating_procedure,
                                                        sop.sop_name as nama_standard_operating_procedure,
                                                        concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name) as daftar_standard_operating_procedure
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
                                            to_char(bp.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
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
                                            to_char(cd.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
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
                                            to_char(sop.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
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
                                            to_char(wi.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
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
                                            to_char(cop.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                            to_char(cop.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                            to_char(cop.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file
                                from        ds.ds_code_of_practice as cop
                                order by    nomor_dokumen;";
        $queryAmbilSemuaDokumen     =   $this->db->query($ambilSemuaDokumen);
        return $queryAmbilSemuaDokumen->result_array();
    }

    public function ambilDepartemen()
    {
        $ambilDepartemen        =   "   select      departemen.section_code as kode_departemen,
                                                    departemen.department_name as nama_departemen
                                        from        er.er_section as departemen
                                        where       substring(departemen.section_code,2,8)='00000000';";
        $queryAmbilDepartemen   =   $this->db->query($ambilDepartemen);
        return $queryAmbilDepartemen->result_array();
    }

    public function ambilBidang($keywordBidang, $departemen)
    {
        $ambilBidang            = " select      bidang.section_code as kode_bidang,
                                                bidang.field_name as nama_bidang
                                    from        er.er_section as bidang
                                    where       substring(bidang.section_code,4,6)='000000'
                                                and     bidang.field_name!='-'
                                                and     substring(bidang.section_code,1,2)='".$departemen."'
                                                and     bidang.field_name like '%$keywordBidang%';";
        $queryAmbilBidang       =   $this->db->query($ambilBidang);
        return $queryAmbilBidang->result_array();
    }

    public function ambilUnit($keywordBidang, $departemen, $bidang)
    {
        $ambilUnit              = " select      unit.section_code as kode_unit,
                                                unit.unit_name as nama_unit
                                    from        er.er_section as unit
                                    where       substring(unit.section_code,6,4)='0000'
                                                and     unit.unit_name!='-'
                                                and     substring(unit.section_code, 3, 2)='$bidang'
                                                and     substring(unit.section_code, 1, 2)='$departemen'";
        $queryAmbilUnit         =   $this->db->query($ambilUnit);
        return $queryAmbilUnit->result_array();
    }

    public function ambilSeksi($keywordUnit, $departemen, $bidang, $unit)
    {
        $ambilSeksi             = " select      seksi.section_code as kode_seksi,
                                                seksi.section_name as nama_seksi
                                    from        er.er_section as seksi
                                    where       substring(seksi.section_code,8,2)='00'
                                                and     seksi.section_name!='-'
                                                and     substring(seksi.section_code, 5, 2)='$unit'
                                                and     substring(seksi.section_code, 3, 2)='$bidang'
                                                and     substring(seksi.section_code, 1, 2)='$departemen';";
        $queryAmbilSeksi        =   $this->db->query($ambilSeksi);
        return $queryAmbilSeksi->result_array();
    }

    public function ambilRiwayatDokumen()
    {
        $ambilRiwayatDokumen        = " select      dochistory.id as kode_dokumen,
                                                    dochistory.jenis_doc as jenis_dokumen,
                                                    dochistory.no_kontrol as nomor_dokumen,
                                                    dochistory.no_revisi as nomor_revisi,
                                                    dochistory.tanggal as tanggal_revisi,
                                                    dochistory.name as nama_dokumen,
                                                    dochistory.file as file
                                        from        ds.ds_history as dochistory
                                        order by    dochistory.tgl_update desc;";
        $queryAmbilRiwayatDokumen   =   $this->db->query($ambilRiwayatDokumen);
        return $queryAmbilRiwayatDokumen->result_array();
    }

    public function ambilRiwayatDokumenDetail($id)
    {
        $ambilRiwayatDokumenDetail      = " select      dochistory.jenis_doc as inisial_jenis_dokumen,
                                                        case dochistory.jenis_doc   when 'BP'   then 'Business Process'
                                                                                    when 'CD'   then 'Context Diagram'
                                                                                    when 'SOP'  then 'Standard Operating Procedure'
                                                                                    when 'WI'   then 'Work Instruction'
                                                                                    when 'COP'  then 'Code of Practice'
                                                                                    else '(Not Defined)'
                                                        end as jenis_dokumen,
                                                        dochistory.no_kontrol as nomor_kontrol,
                                                        dochistory.no_revisi as nomor_revisi,
                                                        to_char(dochistory.tanggal, 'DD-Mon-YYYY') as tanggal_revisi,
                                                        dochistory.name as nama_dokumen,
                                                        dochistory.jml_halaman as jumlah_halaman,
                                                        coalesce(dochistory.info, '(Tidak ada catatan.)') as catatan_revisi,
                                                        dochistory.dibuat as kode_pekerja_pembuat,
                                                        (
                                                            select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                            from    er.er_employee_all as pkj
                                                            where   pkj.employee_id=dochistory.dibuat
                                                        ) as pekerja_pembuat,
                                                        dochistory.diperiksa_1 as kode_pekerja_pemeriksa_1,
                                                        (
                                                            select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                            from    er.er_employee_all as pkj
                                                            where   pkj.employee_id=dochistory.diperiksa_1
                                                        ) as pekerja_pemeriksa_1,
                                                        dochistory.diperiksa_2 as kode_pekerja_pemeriksa_2,
                                                        (
                                                            select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                            from    er.er_employee_all as pkj
                                                            where   pkj.employee_id=dochistory.diperiksa_2
                                                        ) as pekerja_pemeriksa_2,
                                                        dochistory.diputuskan as kode_pekerja_pemberi_keputusan,
                                                        (
                                                            select  concat_ws(' - ', pkj.employee_code, pkj.employee_name)
                                                            from    er.er_employee_all as pkj
                                                            where   pkj.employee_id=dochistory.diputuskan
                                                        ) as pekerja_pemberi_keputusan,
                                                        to_char(dochistory.tgl_insert, 'DD-MM-YYYY HH24:MI:SS') as waktu_input,
                                                        to_char(dochistory.tgl_upload, 'DD-MM-YYYY HH24:MI:SS') as waktu_upload_file,
                                                        to_char(dochistory.tgl_update, 'DD-MM-YYYY HH24:MI:SS') as waktu_input_revisi_baru,
                                                        dochistory.file as file
                                            from        ds.ds_history as dochistory
                                            where       dochistory.id=$id;";
        $queryAmbilRiwayatDokumenDetail =   $this->db->query($ambilRiwayatDokumenDetail);
        return $queryAmbilRiwayatDokumenDetail->result_array();
    }

    public function cekJumlahNotif($jenisDokumen, $jenisnotif)
    {
        $tabel;
        if($jenisDokumen=='BP')
        {  
            $tabel      =   'ds.ds_business_process';
        }
        elseif ($jenisDokumen=='CD') 
        {
            $tabel      =   'ds.ds_context_diagram';
        }
        elseif ($jenisDokumen=='SOP') 
        {
            $tabel      =   'ds.ds_standard_operating_procedure';
        }
        elseif ($jenisDokumen=='WI') 
        {
            $tabel      =   'ds.ds_work_instruction';
        }
        elseif ($jenisDokumen=='COP') 
        {
            $tabel      =   'ds.ds_code_of_practice';
        }

        $klausaWhere;
        if($jenisnotif=='revisi')
        {
            $klausaWhere    =    "to_char(update_Revisi, 'YYYY-MM-DD')='".date('Y-m-d')."'";
        }
        elseif($jenisnotif=='dokumenBaru')
        {
            $klausaWhere    =    "to_char(tgl_insert, 'YYYY-MM-DD')='".date('Y-m-d')."'";
        }
        else 
        {
            echo '  <center>
                        <h1><b>Terima Kasih</b></h1>
                        <br/>
                        <h3>Anda telah menemukan bug di program kami.</h3>
                        <h4><i>Simpan informasi di bawah untuk dapat dilaporkan ke ICT Human Resource (VoIP: 12300)</i></h4>
                        <hr/>
                    </center>
                    <p>
                        Info : ERP->Document Controller->"Dokumen" Group Menu-->Fungsi cekJumlahNotif model M_general argumen kedua berisi selain "revisi" dan "dokumenBaru".
                    </p>';
            exit();
        }

        $cekJumlahNotif     = " select      *
                                from        ds.ds_business_process
                                where       ".$klausaWhere.";";
        $jumlahBaris    =   $this->db->query($cekJumlahNotif);
        return $jumlahBaris->num_rows();
    }

    public function ambilNotifikasi($jenisDokumen, $jenisnotif)
    {
        $tabel;
        if($jenisDokumen=='BP')
        {  
            $tabel      =   'ds.ds_business_process';
        }
        elseif ($jenisDokumen=='CD') 
        {
            $tabel      =   'ds.ds_context_diagram';
        }
        elseif ($jenisDokumen=='SOP') 
        {
            $tabel      =   'ds.ds_standard_operating_procedure';
        }
        elseif ($jenisDokumen=='WI') 
        {
            $tabel      =   'ds.ds_work_instruction';
        }
        elseif ($jenisDokumen=='COP') 
        {
            $tabel      =   'ds.ds_code_of_practice';
        }

        $klausaWhere = '';
        if($jenisnotif=='revisi')
        {
            $klausaWhere    =   "to_char(update_Revisi, 'YYYY-MM-DD')='".date('Y-m-d')."'";
        }
        elseif ($jenisnotif=='dokumenBaru') 
        {
            $klausaWhere    =   "to_char(tgl_insert, 'YYYY-MM-DD')='".date('Y-m-d')."'";
        }
        else
        {
            echo '  <center>
                        <h1><b>Terima Kasih</b></h1>
                        <br/>
                        <h3>Anda telah menemukan bug di program kami.</h3>
                        <h4><i>Simpan informasi di bawah untuk dapat dilaporkan ke ICT Human Resource (VoIP: 12300)</i></h4>
                        <hr/>
                    </center>
                    <p>
                        Info : ERP->Document Controller->"Dokumen" Group Menu-->Fungsi ambilNotifikasi model M_general argumen kedua berisi selain "revisi" dan "dokumenBaru".
                    </p>';
            exit();            
        }

        $ambilNotifikasiRevisi          = " select      concat_ws(' - ', no_kontrol, no_revisi, bp_name) as daftar
                                            from        ".$tabel."
                                            where       ".$klausaWhere.";";
        $queryAmbilNotifikasiRevisi     =   $this->db->query($ambilNotifikasiRevisi);
        return $queryAmbilNotifikasiRevisi->result_array();
    }

    public function ambilJumlahNotifikasiBaru($user_now)
    {
        $ambilJumlahNotifikasiBaru   = "    select         count(*) as jumlah_notifikasi
                                            from        ds.ds_notifications as notif
                                            where       notif.read_status=0
                                                    and     notif.user_notified='".$user_now."';";
        $queryAmbilJumlahNotifikasiBaru     =   $this->db->query($ambilJumlahNotifikasiBaru);
        return $queryAmbilJumlahNotifikasiBaru->result_array();
    }

    public function ambilSemuaNotifikasiBaru($user_now, $document_type = FALSE)
    {
        $klausaWhere = '';
        if($document_type=='BP' || $document_type=='CD' || $document_type=='SOP' || $document_type=='WI' || $document_type=='COP')
        {
            $klausaWhere    =   "and    notif.document_type=";
        }
        elseif ($document_type==FALSE) 
        {
            $document_type  =   '';
        }

        $ambilSemuaNotifikasiBaru   = " select      notif.notification_id as kode_notifikasi,
                                                    notif.document_type as jenis_dokumen,
                                                    notif.document as dokumen,
                                                    case    notif.\"action\"  when 'CREATE'   then 'dibuat oleh'
                                                                            when 'REVISE'   then 'direvisi oleh'
                                                                            when 'EDIT'     then 'diubah oleh'
                                                                            else 'modifikasi oleh'
                                                    end as tindakan,
                                                    notif.\"user\" as pengelola,
                                                    to_char(notif.creation_date, 'DD-Mon-YYYY HH24:MI:SS') as waktu_notifikasi,
                                                    notif.read_status as status_baca,
                                                    notif.document_id as id_dokumen
                                        from        ds.ds_notifications as notif
                                        where       notif.read_status=0
                                                    and     notif.user_notified='".$user_now."'
                                                    ".$klausaWhere.$document_type."
                                        order by    notif.creation_date desc;";
        $queryAmbilSemuaNotifikasiBaru  =   $this->db->query($ambilSemuaNotifikasiBaru);
        return $queryAmbilSemuaNotifikasiBaru->result_array();
    }

    public function inputNotifications($document_type, $header_id, $user_now, $data, $action)
    {
        $tabel;
        if($document_type=='BP')
        {
            $tabel  =   "ds.ds_business_process";
        }
        elseif($document_type=='CD')
        {
            $tabel  =   "ds.ds_context_diagram";
        }
        elseif ($document_type=='SOP') 
        {
            $tabel  =   "ds.ds_standard_operating_procedure";
        }
        elseif ($document_type=='WI') 
        {
            $tabel  =   "ds.ds_work_instruction";
        }
        elseif ($document_type=='COP') 
        {
            $tabel  =   "ds.ds_code_of_practice";
        }

        if(!(strtoupper($action)=='CREATE' || strtoupper($action)=='REVISE' || strtoupper($action)=='EDIT'))
        {
            $action     =   NULL;
        }

        $getUserforNotifications    = " select      sysua.user_group_menu_id,
                                                    sysua.user_id,
                                                    (
                                                        select      sysu.user_name
                                                        from        sys.sys_user as sysu
                                                        where       sysu.user_id=sysua.user_id
                                                    ) as user_notified
                                        from        sys.sys_user_application as sysua
                                        where       sysua.user_group_menu_id=2525
                                        order by    sysua.user_id;";
        $queryGetUserForNotifications   =   $this->db->query($getUserforNotifications);
        $userPenerima      =   $queryGetUserForNotifications->result_array();

        foreach ($userPenerima as $user_notified) 
        {

            $sendNotifications      = " insert into     ds.ds_notifications (user_notified, document_type, document_id, document, action, \"user\", creation_date)
                                            values      (
                                                            '".$user_notified['user_notified']."',
                                                            '".$document_type."',
                                                            '".$header_id."',
                                                            '".$data['no_kontrol']." - ".$data['no_revisi']."',
                                                            '".$action."',
                                                            '".$user_now."',
                                                            '".$this->general->ambilWaktuEksekusi()."'
                                                        )";
            $this->db->query($sendNotifications);
        }        
    }

    public function ambilJobDescription($keywordJobDescription)
    {
        $ambilJobDescription        = " select      jd.jd_id as id_job_description,
                                                    jd.jd_name as nama_job_description
                                        from        ds.ds_jobdesk as jd
                                        where       jd.jd_name like '%".$keywordJobDescription."%'
                                        order by    id_job_description;";
        $queryAmbilJobDescription   =   $this->db->query($ambilJobDescription);
        return $queryAmbilJobDescription->result_array();
    }

    // All Document -------start---

    public function ambilDaftarBP()
    {
        $ambilDaftarBP      = " select      bp.bp_id as id_business_process,
                                            bp.bp_name as nama_business_process,
                                            bp.no_kontrol as nomor_kontrol,
                                            bp.no_revisi as nomor_revisi,
                                            bp.tanggal as tanggal_revisi,
                                            bp.bp_file as file
                                from        ds.ds_business_process as bp
                                order by    nomor_kontrol;";
        $queryAmbilDaftarBP =   $this->db->query($ambilDaftarBP);
        return $queryAmbilDaftarBP->result_array();
    }

    public function ambilJumlahBP()
    {
        $ambilJumlahBP      = " select      count(bp.no_kontrol) as jumlah_business_process
                                from        ds.ds_business_process as bp";
        $queryAmbilJumlahBP = $this->db->query($ambilJumlahBP);
        return $queryAmbilJumlahBP->result_array();
    }

    public function ambilLinkBP($BP)
    {
        $ambilLinkBP        = " select      bp.bp_id as id_business_process,
                                            bp.bp_name as nama_business_process,
                                            bp.no_kontrol as nomor_kontrol,
                                            bp.no_revisi as nomor_revisi
                                from        ds.ds_business_process as bp
                                where       bp.bp_id=".$BP.";";
        $queryAmbilJumlahBP =   $this->db->query($ambilLinkBP);
        return $queryAmbilJumlahBP->result_array();
    }

    public function ambilDaftarCD($BP)
    {
        $ambilDaftarBP      = " select      cd.cd_id as id_context_diagram,
                                            cd.cd_name as nama_context_diagram,
                                            cd.no_kontrol as nomor_kontrol,
                                            cd.no_revisi as nomor_revisi,
                                            cd.tanggal as tanggal_revisi,
                                            cd.cd_file as file
                                from        ds.ds_context_diagram as cd
                                where       cd.bp_id=".$BP."
                                order by    nomor_kontrol;";
        $queryAmbilDaftarBP =   $this->db->query($ambilDaftarBP);
        return $queryAmbilDaftarBP->result_array();
    }

    public function ambilJumlahCD($BP)
    {
        $ambilJumlahBP      = " select      count(cd.no_kontrol) as jumlah_context_diagram
                                from        ds.ds_context_diagram as cd
                                where       cd.bp_id=".$BP.";";
        $queryAmbilJumlahBP = $this->db->query($ambilJumlahBP);
        return $queryAmbilJumlahBP->result_array();
    }

    public function ambilLinkCD($CD)
    {
        $ambilLinkCD        = " select      cd.cd_id as id_context_diagram,
                                            cd.cd_name as nama_context_diagram,
                                            cd.no_kontrol as nomor_kontrol,
                                            cd.no_revisi as nomor_revisi
                                from        ds.ds_context_diagram as cd
                                where       cd.cd_id=".$CD.";";
        $queryAmbilLinkCD   =   $this->db->query($ambilLinkCD);
        return $queryAmbilLinkCD->result_array();
    }

    public function ambilDaftarSOP($CD, $BP)
    {
        $ambilDaftarSOP     = " select      sop.sop_id as id_standard_operating_procedure,
                                            sop.sop_name as nama_standard_operating_procedure,
                                            sop.no_kontrol as nomor_kontrol,
                                            sop.no_revisi as nomor_revisi,
                                            sop.tanggal as tanggal_revisi,
                                            sop.sop_file as file
                                from        ds.ds_standard_operating_procedure as sop
                                where       sop.bp_id=".$BP."
                                            and     sop.cd_id=".$CD."
                                order by    nomor_kontrol;";
        $queryAmbilDaftarSOP=   $this->db->query($ambilDaftarSOP);
        return $queryAmbilDaftarSOP->result_array();
    }

    public function ambilJumlahSOP($CD, $BP)
    {
        $ambilJumlahSOP     = " select      count(sop.no_kontrol) as jumlah_standard_operating_procedure
                                from        ds.ds_standard_operating_procedure as sop
                                where       sop.cd_id=".$CD."
                                            and     sop.bp_id=".$BP.";";
        $queryAmbilJumlahSOP=   $this->db->query($ambilJumlahSOP);
        return $queryAmbilJumlahSOP->result_array();
    }

    public function ambilLinkSOP($SOP)
    {
        $ambilLinkSOP       = " select      sop.sop_id as id_standard_operating_procedure,
                                            sop.sop_name as nama_standard_operating_procedure,
                                            sop.no_kontrol as nomor_kontrol,
                                            sop.no_revisi as nomor_revisi
                                from        ds.ds_standard_operating_procedure as sop
                                where       sop.sop_id=".$SOP.";";
        $queryAmbilLinkSOP  =   $this->db->query($ambilLinkSOP);
        return $queryAmbilLinkSOP->result_array();
    }

    public function ambilDaftarWIRooted($SOP, $CD, $BP)
    {
        $ambilDaftarWIRooted        = " select      wi.wi_id as id_work_instruction,
                                                    wi.wi_name as nama_work_instruction,
                                                    wi.no_kontrol as nomor_kontrol,
                                                    wi.no_revisi as nomor_revisi,
                                                    wi.tanggal as tanggal_revisi,
                                                    wi.wi_file as file
                                        from        ds.ds_work_instruction as wi
                                        where       cast(split_part(wi.no_kontrol,'-',3) as integer)>0
                                                    and     wi.sop_id=".$SOP."
                                                    and     wi.cd_id=".$CD."
                                                    and     wi.bp_id=".$BP."
                                        order by    nomor_kontrol;";
        $queryAmbilDaftarWIRooted   =   $this->db->query($ambilDaftarWIRooted);
        return $queryAmbilDaftarWIRooted->result_array();
    }

    public function ambilJumlahWIRooted($SOP, $CD, $BP)
    {
        $ambilJumlahWIRooted     = "    select      count(wi.no_kontrol) as jumlah_work_instruction_berinduk
                                        from        ds.ds_work_instruction as wi
                                        where       wi.sop_id=".$SOP."
                                                    and     wi.cd_id=".$CD."
                                                    and     wi.bp_id=".$BP."
                                                    and     cast(split_part(wi.no_kontrol,'-',3) as integer)>0;";
        $queryAmbilJumlahWIRooted=   $this->db->query($ambilJumlahWIRooted);
        return $queryAmbilJumlahWIRooted->result_array();
   }

   public function ambilDaftarCOPRooted($SOP, $CD, $BP)
   {
       $ambilDaftarCOPRooted    = " select      cop.cop_id as id_code_of_practice,
                                                cop.cop_name as nama_code_of_practice,
                                                cop.no_kontrol as nomor_kontrol,
                                                cop.no_revisi as nomor_revisi,
                                                cop.tanggal as tanggal_revisi,
                                                cop.cop_file as file
                                    from        ds.ds_code_of_practice as cop
                                    where       cast(split_part(cop.no_kontrol,'-',3) as integer)>0
                                                and     cop.sop_id=".$SOP."
                                                and     cop.cd_id=".$CD."
                                                and     cop.bp_id=".$BP."
                                    order by    nomor_kontrol;";
        $queryAmbilDaftarCOPRooted  =   $this->db->query($ambilDaftarCOPRooted);
        return $queryAmbilDaftarCOPRooted->result_array();
   }

   public function ambilJumlahCOPRooted($SOP, $CD, $BP)
   {
       $ambilJumlahCOPRooted        = " select      count(cop.no_kontrol) as jumlah_code_of_practice_berinduk
                                        from        ds.ds_code_of_practice as cop
                                        where       cop.sop_id=".$SOP."
                                                    and     cop.cd_id=".$CD."
                                                    and     cop.bp_id=".$BP."
                                                    and     cast(split_part(cop.no_kontrol,'-',3) as integer)>0;";
        $queryAmbilJumlahCOPRooted  =   $this->db->query($ambilJumlahCOPRooted);
        return $queryAmbilJumlahCOPRooted->result_array();
   }

   public function ambilDaftarWIUnrooted($fungsi)
   {
        $ambilDaftarWIUnrooted      = " select      wi.wi_id as id_work_instruction,
                                                    wi.wi_name as nama_work_instruction,
                                                    wi.no_kontrol as nomor_kontrol,
                                                    wi.no_revisi as nomor_revisi,
                                                    wi.tanggal as tanggal_revisi,
                                                    wi.wi_file as file
                                        from        ds.ds_work_instruction as wi
                                        where       cast(split_part(wi.no_kontrol,'-',3) as integer)=0
                                                    and     split_part(wi.no_kontrol,'-',2)='".$fungsi."'
                                        order by    nomor_kontrol;";
        $queryAmbilDaftarWIUnrooted =   $this->db->query($ambilDaftarWIUnrooted);
        return $queryAmbilDaftarWIUnrooted->result_array();
   }

   public function ambilDaftarCOPUnrooted($fungsi)
   {
       $ambilDaftarCOPUnrooted      = " select      cop.cop_id as id_code_of_practice,
                                                    cop.cop_name as nama_code_of_practice,
                                                    cop.no_kontrol as nomor_kontrol,
                                                    cop.no_revisi as nomor_revisi,
                                                    cop.tanggal as tanggal_revisi,
                                                    cop.cop_file as file
                                        from        ds.ds_code_of_practice as cop
                                        where       cast(split_part(cop.no_kontrol,'-',3) as integer)=0
                                                    and     split_part(cop.no_kontrol,'-',2)='".$fungsi."'
                                        order by    nomor_kontrol;";
        $queryAmbilDaftarCOPUnrooted=   $this->db->query($ambilDaftarCOPUnrooted);
        return $queryAmbilDaftarCOPUnrooted->result_array();
   }

   public function ambilJumlahWIUnrooted($fungsi)
   {

        $ambilJumlahWIUnrooted   = "    select      count(wi.no_kontrol) as jumlah_work_instruction_tidak_berinduk
                                        from        ds.ds_work_instruction as wi
                                        where       cast(split_part(wi.no_kontrol,'-',3) as integer)=0
                                                    and     split_part(wi.no_kontrol,'-',2)='".$fungsi."';   ";
        $queryAmbilJumlahWIUnrooted =   $this->db->query($ambilJumlahWIUnrooted);
        return $queryAmbilJumlahWIUnrooted->result_array();
   }

   public function ambilJumlahCOPUnrooted($fungsi)
   {

        $ambilJumlahCOPUnrooted  = "    select      count(cop.no_kontrol) as jumlah_code_of_practice_tidak_berinduk
                                        from        ds.ds_code_of_practice as cop
                                        where       cast(split_part(cop.no_kontrol,'-',3) as integer)=0
                                                    and     split_part(cop.no_kontrol,'-',2)='".$fungsi."';";
        $queryAmbilJumlahCOPUnrooted    =   $this->db->query($ambilJumlahCOPUnrooted);
        return $queryAmbilJumlahCOPUnrooted->result_array();
   }

   public function ambilFungsi($CD)
   {
        $ambilFungsi        = " select      split_part(cd.no_kontrol,'-',2) as fungsi
                                from        ds.ds_context_diagram as cd
                                where       cd.cd_id=".$CD.";";
        $queryAmbilFungsi   =   $this->db->query($ambilFungsi)       ;
        $hasilAmbilFungsi   =   $queryAmbilFungsi->result_array();
        return $hasilAmbilFungsi[0]['fungsi'];
   }
    // All Document ---------end---

   public function ambilKodesieJobDescription($jobDescription)
   {
       $ambilKodesieJobDescription      = " select      jd.kodesie
                                            from        ds.ds_jobdesk as jd
                                            where       jd.jd_id=".$jobDescription.";";
        $queryAmbilKodesieJobDescription=   $this->db->query($ambilKodesieJobDescription);
        $hasilAmbilKodesieJobDescription=   $queryAmbilKodesieJobDescription->result_array();
        return $hasilAmbilKodesieJobDescription[0]['kodesie'];
   }

   public function ambilHirarki($kodesieJobDescription)
   {
       $ambilHirarki        = " select      seksi.section_code as kodesie,
                                            seksi.department_name as nama_departemen,
                                            seksi.field_name as nama_bidang,
                                            seksi.unit_name as nama_unit,
                                            seksi.section_name as nama_seksi
                                from        er.er_section as seksi
                                where       seksi.section_code='".$kodesieJobDescription."';";
        $queryAmbilHirarki  =   $this->db->query($ambilHirarki);
        return $queryAmbilHirarki->result_array();
   }

   public function ambilJobDescriptionBerdasarKodesie($kodesie)
   {
       $ambilJobDescriptionBerdasarKodesie      = " select      jd.jd_id as id_job_description,
                                                                jd.jd_name as nama_job_description
                                                    from        ds.ds_jobdesk as jd
                                                    where       substring(jd.kodesie,1,7)='".$kodesie."'";
        $queryAmbilJobDescriptionBerdasarKodesie=   $this->db->query($ambilJobDescriptionBerdasarKodesie);
        return $queryAmbilJobDescriptionBerdasarKodesie->result_array();
   }

   public function ambilDokumenJobDescription($keywordDokumenJobDescription)
   {
       $ambilDokumenJobDescription      = " select      concat_ws('-', 'BP',bp.bp_id) as kode_dokumen,
                                                        concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name) as daftar_nama_dokumen,
                                                        1 as level
                                            from        ds.ds_business_process as bp
                                            where       concat_ws(' - ', bp.no_kontrol, bp.no_revisi, bp.bp_name) like '%".$keywordDokumenJobDescription."%'
                                            union
                                            select      concat_ws('-', 'CD', cd.cd_id) as kode_dokumen,
                                                        concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name) as daftar_nama_dokumen,
                                                        2 as level
                                            from        ds.ds_context_diagram as cd
                                            where       concat_ws(' - ', cd.no_kontrol, cd.no_revisi, cd.cd_name) like '%".$keywordDokumenJobDescription."%'
                                            union
                                            select      concat_ws('-', 'SOP', sop.sop_id) as kode_dokumen,
                                                        concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name) as daftar_nama_dokumen,
                                                        3 as level
                                            from        ds.ds_standard_operating_procedure as sop
                                            where       concat_ws(' - ', sop.no_kontrol, sop.no_revisi, sop.sop_name) like '%".$keywordDokumenJobDescription."%'
                                            union
                                            select      concat_ws('-', 'WI', wi.wi_id) as kode_dokumen,
                                                        concat_ws(' - ', wi.no_kontrol, wi.no_revisi, wi.wi_name) as daftar_nama_dokumen,
                                                        4 as level
                                            from        ds.ds_work_instruction as wi
                                            where       concat_ws(' - ', wi.no_kontrol, wi.no_revisi, wi.wi_name) like '%".$keywordDokumenJobDescription."%'
                                            union
                                            select      concat_ws('-', 'COP', cop.cop_id) as kode_dokumen,
                                                        concat_ws(' - ', cop.no_kontrol, cop.no_revisi, cop.cop_name) as daftar_nama_dokumen,
                                                        5 as level
                                            from        ds.ds_code_of_practice as cop
                                            where       concat_ws(' - ', cop.no_kontrol, cop.no_revisi, cop.cop_name) like '%".$keywordDokumenJobDescription."%'
                                            order by    level, daftar_nama_dokumen;";
        $queryAmbilDokumenJobDescription=   $this->db->query($ambilDokumenJobDescription);
        return $queryAmbilDokumenJobDescription->result_array();
   }
}

/* End of file M_jobdesk.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdesk.php */
/* Generated automatically on 2017-09-14 11:03:22 */