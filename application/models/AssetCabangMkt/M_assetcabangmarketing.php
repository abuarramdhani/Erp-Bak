<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_assetcabangmarketing extends CI_Model
{
  var $oracle;
  function __construct()
  {
    parent::__construct();
    $this->load->database();
      $this->load->library('encrypt');
      // $this->oracle = $this->load->database('oracle', true);
   }
    public function checkSourceLogin($employee_code)
    {
        $db = $this->load->database();
        $sql = "select eea.employee_code, es.section_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

     public function cariNamaCabang($nama_cabang)
    {
        $db = $this->load->database();
        $sql = "select ac.nama_cabang, au.kode_cabang, ac.kode_cabang kc, au.no_induk from ac.ac_user au left join ac.ac_cabang ac on ac.branch_code = au.kode_cabang where ac.nama_cabang = '$nama_cabang'";
        echo "<pre>";echo $sql;
        // $runQuery = $this->db->query($sql);
        // return $runQuery->result_array();
    }

    public function getDataJenisAsset()
    {
        $db = $this->load->database();
        $sql = "select id_ja, nama_ja from ac.ac_jenis_asset";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getKategoriAsset()
    {
        $db = $this->load->database();
        $sql = "select id_ka, nama_ka from ac.ac_kategori_asset";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }


    public function getPerolehanAsset()
    {
        $db = $this->load->database();
        $sql = "select id_pa, nama_pa from ac.ac_perolehan_asset";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getSeksiPemakai()
    {
        $db = $this->load->database();
        $sql = "select id_sp, nama_sp from ac.ac_seksi_pemakai";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getDataOracle()
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT DISTINCT fb.book_type_code
                , ffv.description branch
                , ad.attribute_category_code
                , ad.asset_number
                , fat.description
                , ad.tag_number
                , fb.date_placed_in_service
                , fai.invoice_number
           FROM fa_additions_b ad,
                fa_books fb,
                fa_additions_tl fat,
                fnd_flex_values_vl ffv,
                fa_deprn_periods dp,
                fa_deprn_detail fdd,
                fa_locations fl,
                fa_distribution_history fh,
                gl_code_combinations glc,
                fa_asset_invoices fai,
                ap_suppliers pav
          WHERE fb.asset_id = ad.asset_id
            AND fat.asset_id = ad.asset_id
            AND ffv.flex_value = SUBSTR (ad.attribute_category_code, -7, 2)
            AND ffv.flex_value_set_id = 1013707
            AND ffv.enabled_flag = 'Y'
            --
            AND dp.period_counter = fdd.period_counter
            AND fdd.asset_id = fb.asset_id
            AND fdd.book_type_code = fb.book_type_code
            AND fl.location_id = fh.location_id
            AND fh.asset_id = fb.asset_id
            AND glc.code_combination_id = fh.code_combination_id(+)
            AND fai.invoice_transaction_id_in IN (
                                        SELECT   MIN
                                                    (invoice_transaction_id_in)
                                            FROM fa_asset_invoices
                                           WHERE po_number IS NOT NULL
                                        GROUP BY asset_id)
            AND fai.asset_id(+) = ad.asset_id
            AND fb.date_placed_in_service between ('31-DEC-2019') and sysdate
--            and fb.BOOK_TYPE_CODE = 'KHS CORP BOOK' --atau'KHS TAX BOOK'
            AND pav.vendor_id(+) = fai.po_vendor_id
ORDER BY        fb.book_type_code,
                ffv.description,
                ad.attribute_category_code,
                ad.asset_number";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function getDataOracleFilter($code)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "select *
                from
                (SELECT DISTINCT fl.segment1 || '-' || fl.segment3 BRANCH
                                ,(SELECT SUBSTR (fvt.description , 1, 3) || '-' || SUBSTR (fvt.description , 7,500)
                                      FROM apps.fnd_flex_value_sets fvs,
                                           apps.fnd_flex_values fv,
                                           apps.fnd_flex_values_tl fvt
                                     WHERE fvs.flex_value_set_name LIKE 'KHS_FA_LOC_KOTA%GDG'
                                       AND fvs.flex_value_set_id = fv.flex_value_set_id
                                       AND fv.flex_value_id = fvt.flex_value_id
                                       AND fv.flex_value = fl.segment1
                                       AND fvt.LANGUAGE = 'US') location_description2
                --                , ffv.description branch
                --                , SUBSTR (ad.attribute_category_code, -7, 2) kode_branch
                , ad.attribute_category_code
                , fat.description
                , ad.tag_number
                , fb.date_placed_in_service
                , fai.invoice_number
           FROM fa_additions_b ad,
                fa_books fb,
                fa_additions_tl fat,
                fnd_flex_values_vl ffv,
                fa_deprn_periods dp,
                fa_deprn_detail fdd,
                fa_locations fl,
                fa_distribution_history fh,
                gl_code_combinations glc,
                fa_asset_invoices fai,
                ap_suppliers pav
          WHERE fb.asset_id = ad.asset_id
            AND fat.asset_id = ad.asset_id
            AND ffv.flex_value = SUBSTR (ad.attribute_category_code, -7, 2)
            AND ffv.flex_value_set_id = 1013707
            AND ffv.enabled_flag = 'Y'
            --
            AND dp.period_counter = fdd.period_counter
            AND fdd.asset_id = fb.asset_id
            AND fdd.book_type_code = fb.book_type_code
            AND fl.location_id = fh.location_id
            AND fh.asset_id = fb.asset_id
            AND glc.code_combination_id = fh.code_combination_id(+)
            AND fai.invoice_transaction_id_in IN (
                                        SELECT   MIN
                                                    (invoice_transaction_id_in)
                                            FROM fa_asset_invoices
                                           WHERE po_number IS NOT NULL
                                        GROUP BY asset_id)
                        AND fai.asset_id(+) = ad.asset_id
                        AND fb.date_placed_in_service between ('31-DEC-2018') and sysdate
            --            and fb.BOOK_TYPE_CODE = 'KHS CORP BOOK' --atau'KHS TAX BOOK'
                        AND pav.vendor_id(+) = fai.po_vendor_id
            ORDER BY        branch,
                            ad.attribute_category_code)aa
            where aa.location_description2 like '$code-%'";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function getDraft()
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.pict_title_cbg,
                aps.pdf_title_cbg,
                aps.pdf_title_mkt,
                aps.creation_date,
                aps.batch_number,
                aps.created_by,
                ajs.nama_ja,
                apa.nama_pa,
                aks.nama_ka,
                aps.kode_cabang,
                acu.nama_cabang,
                ala.log_time
                from ac.ac_proposal_asset aps
                left join ac.ac_jenis_asset ajs on ajs.id_ja = aps.id_ja
                left join ac.ac_kategori_asset aks on aks.id_ka = aps.id_ka
                left join ac.ac_perolehan_asset apa on apa.id_pa = aps.id_pa
                left join ac.ac_log_activity ala on aps.id_proposal = ala.id_proposal
                left join ac.ac_cabang acu on acu.branch_code = aps.kode_cabang
                where aps.status = ala.status 
                and aps.status = 2";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

     public function getApproved()
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.pict_title_cbg,
                aps.pdf_title_cbg,
                aps.pdf_title_mkt,
                aps.creation_date,
                aps.batch_number,
                aps.created_by,
                ajs.nama_ja,
                apa.nama_pa,
                aks.nama_ka,
                aps.kode_cabang,
                acu.nama_cabang,
                ala.log_time
                from ac.ac_proposal_asset aps
                left join ac.ac_jenis_asset ajs on ajs.id_ja = aps.id_ja
                left join ac.ac_kategori_asset aks on aks.id_ka = aps.id_ka
                left join ac.ac_perolehan_asset apa on apa.id_pa = aps.id_pa
                left join ac.ac_log_activity ala on aps.id_proposal = ala.id_proposal
                left join ac.ac_cabang acu on acu.branch_code = aps.kode_cabang
                where aps.status = ala.status 
                and aps.status = 4";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getRejected()
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.pict_title_cbg,
                aps.pdf_title_cbg,
                aps.pdf_title_mkt,
                aps.creation_date,
                aps.batch_number,
                aps.created_by,
                ajs.nama_ja,
                apa.nama_pa,
                aks.nama_ka,
                aps.kode_cabang,
                acu.nama_cabang,
                ala.log_time
                from ac.ac_proposal_asset aps
                left join ac.ac_jenis_asset ajs on ajs.id_ja = aps.id_ja
                left join ac.ac_kategori_asset aks on aks.id_ka = aps.id_ka
                left join ac.ac_perolehan_asset apa on apa.id_pa = aps.id_pa
                left join ac.ac_log_activity ala on aps.id_proposal = ala.id_proposal
                left join ac.ac_cabang acu on acu.branch_code = aps.kode_cabang
                where aps.status = ala.status 
                and aps.status = 5";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getFinished()
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.pict_title_cbg,
                aps.pdf_title_cbg,
                aps.pdf_title_mkt,
                aps.creation_date,
                aps.batch_number,
                aps.created_by,
                ajs.nama_ja,
                apa.nama_pa,
                aks.nama_ka,
                aps.kode_cabang,
                acu.nama_cabang,
                ala.log_time
                from ac.ac_proposal_asset aps
                left join ac.ac_jenis_asset ajs on ajs.id_ja = aps.id_ja
                left join ac.ac_kategori_asset aks on aks.id_ka = aps.id_ka
                left join ac.ac_perolehan_asset apa on apa.id_pa = aps.id_pa
                left join ac.ac_log_activity ala on aps.id_proposal = ala.id_proposal
                left join ac.ac_cabang acu on acu.branch_code = aps.kode_cabang
                where aps.status = ala.status 
                and aps.status = 6";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getHasilDraft($id)
    {
        $db = $this->load->database();
        $sql = "select 
                apa.id_ja,
                apa.id_ka,
                apa.id_pa,
                apa.seksi_pemakai,
                apa.id_proposal,
                apa.alasan, 
                apa.status,
                apa.kode_cabang,
                apa.batch_number,
                asp.id_sp,
                aja.nama_ja,
                aka.nama_ka,
                apas.nama_pa
                from ac.ac_proposal_asset apa
                left join ac.ac_jenis_asset aja on aja.id_ja = apa.id_ja
                left join ac.ac_kategori_asset aka on aka.id_ka = apa.id_ka
                left join ac.ac_perolehan_asset apas on apas.id_pa = apa.id_pa
                left join ac.ac_seksi_pemakai asp on asp.nama_sp = apa.seksi_pemakai
                where id_proposal = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

     public function getKodeCabang()
    {
        $db = $this->load->database();
        $sql = "select id_cabang, nama_cabang, kode_cabang, branch_code from ac.ac_cabang";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getRencanaKebutuhan($id)
    {
        $db = $this->load->database();
        $sql = "select 
                kode_barang, 
                nama_asset, 
                spesifikasi_asset, 
                jumlah_asset, 
                umur_teknis, 
                id_proposal, 
                rk_id from ac.ac_rencana_kebutuhan
                where id_proposal = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function UpdateApprove($id,$batch_number,$status,$judulFile,$user)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_proposal_asset set status = '$status', pdf_title_mkt = '$judulFile' where id_proposal = '$id'";
        $runQuery = $this->db->query($sql);
        $sql2 = "insert into ac.ac_log_activity (id_proposal, log_time, log_by, status, batch_number) values ('$id', now(), '$user', '$status', '$batch_number') ";
        $runQuery2 = $this->db->query($sql2);
    }

    public function UpdateReject($id,$batch_number,$status,$user)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_proposal_asset set status = '$status', pdf_title_mkt = '(rejected)' where id_proposal = '$id'";
        $runQuery = $this->db->query($sql);
        $sql2 = "insert into ac.ac_log_activity (id_proposal, log_time, log_by, status, batch_number) values ('$id', now(), '$user', '$status', '$batch_number') ";
        $runQuery2 = $this->db->query($sql2);
    }


    public function saveJA($cc)
    {
        $db = $this->load->database();
        $sql = "insert into ac.ac_jenis_asset (nama_ja) values ('$cc')";
        $runQuery = $this->db->query($sql);
    }

    public function saveKA($cc)
    {
        $db = $this->load->database();
        $sql = "insert into ac.ac_kategori_asset (nama_ka) values ('$cc')";
        $runQuery = $this->db->query($sql);
    }

    public function savePA($cc)
    {
        $db = $this->load->database();
        $sql = "insert into ac.ac_perolehan_asset (nama_pa) values ('$cc')";
        $runQuery = $this->db->query($sql);
    }

    public function saveSP($cc)
    {
        $db = $this->load->database();
        $sql = "insert into ac.ac_seksi_pemakai (nama_sp) values ('$cc')";
        $runQuery = $this->db->query($sql);
    }

    public function deleteJA($id)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_jenis_asset where id_ja = $id";
        $runQuery = $this->db->query($sql);
    }

    public function deleteKA($id)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_kategori_asset where id_ka = $id";
        $runQuery = $this->db->query($sql);
    }

    public function deletePA($id)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_perolehan_asset where id_pa = $id";
        $runQuery = $this->db->query($sql);
    }

    public function deleteSP($id)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_seksi_pemakai where id_sp = $id";
        $runQuery = $this->db->query($sql);
    }

    public function getDataJA($id)
    {
        $db = $this->load->database();
        $sql = "select nama_ja, id_ja from ac.ac_jenis_asset where id_ja = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getDataKA($id)
    {
        $db = $this->load->database();
        $sql = "select nama_ka, id_ka from ac.ac_kategori_asset where id_ka = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getDataPA($id)
    {
        $db = $this->load->database();
        $sql = "select nama_pa, id_pa from ac.ac_perolehan_asset where id_pa = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getDataSP($id)
    {
        $db = $this->load->database();
        $sql = "select nama_sp, id_sp from ac.ac_seksi_pemakai where id_sp = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

     public function getCabang()
    {
        $db = $this->load->database();
        $sql = "select id_cabang, nama_cabang, kode_cabang, branch_code from ac.ac_cabang";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function cekSource($nomor_ind)
    {
        $db = $this->load->database();
        $sql = "select 
                eea.employee_code, 
                eea.employee_name, 
                es.section_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$nomor_ind'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function updateJA($id,$input)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_jenis_asset set nama_ja = '$input' where id_ja = $id";
        $runQuery = $this->db->query($sql);
    }

    public function updateKA($id,$input)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_kategori_asset set nama_ka = '$input' where id_ka = $id";
        $runQuery = $this->db->query($sql);
    }

    public function updatePA($id,$input)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_perolehan_asset set nama_pa = '$input' where id_pa = $id";
        $runQuery = $this->db->query($sql);
    }

    public function updateSP($id,$input)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_seksi_pemakai set nama_sp = '$input' where id_sp = $id";
        $runQuery = $this->db->query($sql);
    }

    public function saveUser($nomor_induk,$nama_pekerja,$section_name,$kode_cabang)
    {
        $db = $this->load->database();
        $sql = "insert into ac.ac_user (no_induk, nama_user, kode_cabang, section_name) values ('$nomor_induk', '$nama_pekerja', '$kode_cabang', '$section_name')";
        $runQuery = $this->db->query($sql);
    }

    public function filterUser($nomor_induk)
    {
        $db = $this->load->database();
        $sql = "select no_induk from ac.ac_user where no_induk = '$nomor_induk'";
        $runQuery = $this->db->query($sql);
        return $runQuery->num_rows();
    }

    public function filterUserKacab($nomor_induk)
    {
        $db = $this->load->database();
        $sql = "select no_induk from ac.ac_kacab where no_induk = '$nomor_induk'";
        $runQuery = $this->db->query($sql);
        return $runQuery->num_rows();
    }

    public function getDataUser($nomor_induk)
    {
        $db = $this->load->database();
        $sql = "select id_user, no_induk, nama_user, kode_cabang, section_name from ac.ac_user where no_induk = '$nomor_induk'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getDataAllSU()
    {
        $db = $this->load->database();
        $sql = "select id_user, no_induk, nama_user, kode_cabang, section_name from ac.ac_user";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function deleteSU($id)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_user where id_user = $id";
        $runQuery = $this->db->query($sql);
    }

    public function deleteKcb($id)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_kacab where id_kacab = $id";
        $runQuery = $this->db->query($sql);
    }

    public function ambilDataSU($id)
    {
        $db = $this->load->database();
        $sql = "select id_user, no_induk, nama_user, kode_cabang, section_name from ac.ac_user where id_user = '$id'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function ambilDataKcb($id)
    {
        $db = $this->load->database();
        $sql = "select id_kacab, no_induk, nama_kacab, kode_cabang, section_name, status from ac.ac_kacab where id_kacab = '$id'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function updateCabang($id,$ganti)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_user set kode_cabang = '$ganti' where id_user = $id";
        $runQuery = $this->db->query($sql);
    }

    public function updateKacab($id,$ganti)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_kacab set kode_cabang = '$ganti' where id_kacab = $id";
        $runQuery = $this->db->query($sql);
    }

       public function getDataKacab()
    {
        $db = $this->load->database();
        $sql = "select id_kacab, no_induk, nama_kacab, kode_cabang, section_name, status from ac.ac_kacab";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function saveKacab($nomor_induk,$nama_pekerja,$section_name,$kode_cabang,$status)
    {
        $db = $this->load->database();
        $sql = "insert into ac.ac_kacab (no_induk, nama_kacab, section_name, kode_cabang, status) values ('$nomor_induk', '$nama_pekerja', '$section_name', '$kode_cabang', '$status')";
        $runQuery = $this->db->query($sql);
    }


}

?>