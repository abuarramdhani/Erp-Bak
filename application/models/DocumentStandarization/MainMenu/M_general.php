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
                                        where       substring(departemen.section_code,2,2)='00';";
        $queryAmbilDepartemen   =   $this->db->query($ambilDepartemen);
        return $queryAmbilDepartemen->result_array();
    }

    public function ambilBidang($keywordBidang, $departemen)
    {
        $ambilBidang            = " select      bidang.section_code as kode_bidang,
                                                bidang.field_name as nama_bidang
                                    from        er.er_section as bidang
                                    where       substring(bidang.section_code,4,2)='00'
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
                                    where       substring(unit.section_code,6,2)='00'
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
}

/* End of file M_jobdesk.php */
/* Location: ./application/models/OTHERS/MainMenu/M_jobdesk.php */
/* Generated automatically on 2017-09-14 11:03:22 */