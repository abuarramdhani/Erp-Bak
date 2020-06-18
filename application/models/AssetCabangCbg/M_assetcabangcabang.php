<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_assetcabangcabang extends CI_Model
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
    public function cariCabang($user)
    {
        $db = $this->load->database();
        $sql = "select kode_cabang from ac.ac_user where no_induk = '$user'";
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


    public function getBranchesCounted($bc)
    {

        $db = $this->load->database();
        $sql = "select apa.kode_cabang, acc.branch_code, acc.kode_cabang  from ac.ac_proposal_asset apa left join ac.ac_cabang acc on acc.kode_cabang = apa.kode_cabang where apa.kode_cabang = '$bc'";
        $runQuery = $this->db->query($sql);
        return $runQuery->num_rows();
    }

    public function cariNamaCabang($no_ind)
    {
        $db = $this->load->database();
        $sql = "select ac.nama_cabang, au.kode_cabang, ac.kode_cabang kc, au.no_induk from ac.ac_user au left join ac.ac_cabang ac on ac.branch_code = au.kode_cabang where au.no_induk = '$no_ind'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
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

    public function getCabang()
    {
        $db = $this->load->database();
        $sql = "select id_cabang, nama_cabang, kode_cabang, branch_code from ac.ac_cabang";
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

    public function saveProposalCabang($kategori_asset,$jenis_asset,$perolehan_asset,$seksi_pemakai,$alasan,$usr)
    {
        $db = $this->load->database();
        $sql = "insert into ac.ac_proposal_asset (id_ka, id_ja, id_pa, seksi_pemakai, alasan, status, creation_date, created_by)
        values ($kategori_asset, NULL, $perolehan_asset, '$seksi_pemakai', '$alasan', 1, now(), '$usr')";
        $runQuery = $this->db->query($sql);
        $sql2 = "select max (id_proposal) id_proposal from ac.ac_proposal_asset";
        $runQuery2 = $this->db->query($sql2);
        return $runQuery2->result_array();
    }

    public function updateProposalCabang($kategori_asset,$jenis_asset,$perolehan_asset,$seksi_pemakai,$alasan,$usr,$id)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_proposal_asset
                set 
                    id_ka = $kategori_asset, 
                    id_ja = NULL, 
                    id_pa = $perolehan_asset, 
                    seksi_pemakai = '$seksi_pemakai',
                    alasan = '$alasan', 
                    status = 1, 
                    creation_date = now(), 
                    created_by = '$usr'
                where id_proposal = '$id'";
        $runQuery = $this->db->query($sql);
    }

    public function resetLine($id)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_rencana_kebutuhan where id_proposal = $id";
        $runQuery = $this->db->query($sql);
    }

    public function logActivity($id_proposal,$usr,$batch_number)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_log_activity where id_proposal = '$id_proposal' and status IN (1,3)";
        $runQuery = $this->db->query($sql);
        $sql = "insert into ac.ac_log_activity (id_proposal, batch_number, log_time, log_by, status) values ($id_proposal, '$batch_number', now(), '$usr', 1)";
        $runQuery = $this->db->query($sql);
    }

    public function getDataMdlReject($id_proposal)
    {
        $db = $this->load->database();
        $sql = "select batch_number, id_proposal from ac.ac_proposal_asset where id_proposal = $id_proposal ";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function updateBatch($id_header, $batch_number, $judul_file, $asal_cabang,$user)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_proposal_asset set 
                batch_number = '$batch_number',
                kode_cabang = '$asal_cabang',
                pdf_title_cbg = '$judul_file' 
                where id_proposal = '$id_header'";
        $runQuery = $this->db->query($sql);
        $sql1 = "insert into ac.ac_log_activity (id_proposal, log_time, log_by, status, batch_number)
                values ('$id_header', now(), '$user', 1, '$batch_number')";
        $runQuery1 = $this->db->query($sql1);
    }

    public function saveLineProposal($kode_barang,$nama_asset, $spesifikasi_asset, $jumlah, $umur_teknis,$id_header)
    {
        $db = $this->load->database();
        $sql = "insert into ac.ac_rencana_kebutuhan (kode_barang, nama_asset, spesifikasi_asset, jumlah_asset, umur_teknis, id_proposal)
                values ('$kode_barang', '$nama_asset', '$spesifikasi_asset', '$jumlah', '$umur_teknis', '$id_header')";
        $runQuery = $this->db->query($sql);
    }

    public function getDraft($code)
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.pdf_title_cbg,
                aps.pict_title_cbg,
                aps.pdf_title_mkt,
                aps.creation_date,
                aps.batch_number,
                aps.created_by,
                ajs.nama_ja,
                apa.nama_pa,
                aks.nama_ka,
                aps.kode_cabang,
                acu.nama_cabang
                from ac.ac_proposal_asset aps
                left join ac.ac_jenis_asset ajs on ajs.id_ja = aps.id_ja
                left join ac.ac_kategori_asset aks on aks.id_ka = aps.id_ka
                left join ac.ac_perolehan_asset apa on apa.id_pa = aps.id_pa
                left join ac.ac_cabang acu on acu.branch_code = aps.kode_cabang
                where status = 1
                and aps.kode_cabang = '$code'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getCheckKacab($code)
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.alasan_reject,
                aps.rejected_date,
                aps.pdf_title_cbg,
                aps.pdf_title_mkt,
                aps.pict_title_cbg,
                aps.creation_date,
                aps.batch_number,
                aps.created_by,
                ajs.nama_ja,
                apa.nama_pa,
                aks.nama_ka,
                aps.kode_cabang,
                acu.nama_cabang
                from ac.ac_proposal_asset aps
                left join ac.ac_jenis_asset ajs on ajs.id_ja = aps.id_ja
                left join ac.ac_kategori_asset aks on aks.id_ka = aps.id_ka
                left join ac.ac_perolehan_asset apa on apa.id_pa = aps.id_pa
                left join ac.ac_cabang acu on acu.branch_code = aps.kode_cabang
                where status in (2,3)
                and aps.kode_cabang = '$code'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getApproved($code)
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.pdf_title_cbg,
                aps.pdf_title_mkt,
                aps.pict_title_cbg,
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
                and aps.status = 4
                and aps.kode_cabang = '$code'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getRejected($code)
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.pdf_title_cbg,
                aps.pdf_title_mkt,
                aps.pict_title_cbg,
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
                and aps.status = 5
                and aps.kode_cabang = '$code'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function getFinished($code)
    {
        $db = $this->load->database();
        $sql = "select aps.id_ka, 
                aps.id_ja,
                aps.id_pa,
                aps.seksi_pemakai, 
                aps.id_proposal,
                aps.alasan,
                aps.status,
                aps.pdf_title_cbg,
                aps.pdf_title_mkt,
                aps.creation_date,
                aps.pict_title_cbg,
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
                and aps.status = 6
                and aps.kode_cabang = '$code'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }



    public function getDataOracle($code)
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
// echo $sql;exit();
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function delete($id)
    {
        $db = $this->load->database();
        $sql = "delete from ac.ac_proposal_asset where id_proposal = '$id'";
        $runQuery = $this->db->query($sql);
        $sql2 = "delete from ac.ac_log_activity where id_proposal = '$id'";
        $runQuery2 = $this->db->query($sql2);
    }

    public function savePictCabang($judul,$id)
    {
        $db = $this->load->database();
        $sql = "update ac.ac_proposal_asset set pict_title_cbg = '$judul' where id_proposal = '$id'";
        $runQuery = $this->db->query($sql);
    }

    public function cariKodeBarang($param)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "select distinct msib.DESCRIPTION
                            from mtl_system_items_b msib
                            where msib.SEGMENT1 like 'N%'
                            and msib.DESCRIPTION like '%$param%'";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function getNamaAsset($param)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "select distinct msib.SEGMENT1
                            from mtl_system_items_b msib
                            where msib.SEGMENT1 like 'N%'
                            AND msib.DESCRIPTION LIKE '%$param%'";
        $run = $oracle->query($sql);
        return $run->result_array();
    }


}

?>