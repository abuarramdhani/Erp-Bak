<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_request extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
        $this->load->helper('url');
        
        $this->oracle = $this->load->database('oracle', true);
        $this->oracle_dev = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }
    
    
    public function getseksiunit($user){
        $sql = "select ts.seksi, ts.unit, tp.nama
                from hrd_khs.tseksi ts, hrd_khs.tpribadi tp
                where tp.kodesie = ts.kodesie
                and tp.noind = '$user'";
        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

    public function getNamaBarang($term) {
        $sql = "select distinct msib.inventory_item_id, msib.segment1, msib.description
                from mtl_system_items_b msib
                where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and msib.organization_id = 81
                $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }
    
    public function getDesc($term) {
        $sql = "select distinct msib.inventory_item_id, msib.segment1, msib.description, msib.PRIMARY_UOM_CODE
                from mtl_system_items_b msib
                where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and msib.organization_id = 81
                AND msib.segment1 = '$term'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
        // return $sql;
    }
    
    public function getOrgAssign($term){
        $sql = "SELECT mp.organization_id, mp.organization_code, hou.NAME                
                FROM hr_organization_units_v hou,                        
                    hr_organization_information_v hoi,                        
                    hr_lookups hl1,                        
                    hr_lookups hl2,                        
                    hr_lookups hl3,                        
                    hz_geographies geo,                        
                    mtl_parameters mp                
                WHERE hou.organization_id = hoi.organization_id                    
                AND hoi.organization_id = mp.organization_id                    
                AND hoi.org_information_context = 'CLASS'                    
                AND geo.geography_code(+) = hou.region_1                    
                AND geo.geography_type(+) = 'PROVINCE'                    
                AND hl1.lookup_code(+) = hou.style                    
                AND hl1.lookup_type(+) = 'GHR_US_CNTRY_WRLD_CTZN'                    
                AND hl2.lookup_code(+) = hou.country                    
                AND hl2.lookup_type(+) = 'PER_US_COUNTRY_CODE'                    
                AND hl3.lookup_code(+) = hou.postal_code                    
                AND hl3.lookup_type(+) = 'GHR_US_POSTAL_COUNTRY_CODE'                    --pembatasan untuk io aktif                    
                AND hoi.org_information1_meaning = 'Inventory Organization'                    
                AND hou.date_to IS NULL
                AND mp.organization_code like '%$term%'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getOrgGroup($term){
        $sql = "select * 
                from khs_pmi_org_group 
                where group_name like '%$term%' 
                order by group_name asc";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getseksi($seksi){
        $sql = "select * 
                from khs_pmi_seksi where 
                $seksi";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getUOM($term){
        $sql = "select * 
                from khs_pmi_uom 
                $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function cekheader($term){
        $sql = "select * 
                from khs_pmi_header 
                $term";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function dataItem($term){
        $sql = "select * 
                from khs_pmi_request 
                $term ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getdatafull($term){
        $sql = "SELECT kpr.*, 
                        kpu.KODE_UOM,
                        pl.ODM, 
                        pl.OPM,
                        pl.JUAL,
                        kptk.REVISI_KODE_ITEM rev_kode, 
                        kptk.REVISI_DESC_ITEM rev_desc,
                        case when kptk.REVISI_KODE_ITEM is not null and kptk.REVISI_KODE_ITEM != '-'
                                then kptk.REVISI_KODE_ITEM
                             else kpr.KODE_ITEM
                             end item_fix,
                        case when kptk.REVISI_DESC_ITEM is not null and kptk.REVISI_DESC_ITEM != '-'
                                then kptk.REVISI_DESC_ITEM
                             else kpr.DESKRIPSI
                             end desc_fix,
                        kpa.INV_VALUE,
                        kpa.EXP_ACC,
                        kpa.komen komen_akt,
                        kpp.BUYER,
                        kpp.PRE_PROCESSING,
                        kpp.PREPARATION_PO,
                        kpp.DELIVERY,
                        kpp.TOTAL_PROSES,
                        kpp.POST_PROCESSING,
                        kpp.TOTAL_LEAD_TIME,
                        kpp.MOQ,
                        kpp.FLM,
                        kpp.APPROVER_PO,
                        kpp.KETERANGAN ket_pembelian,
                        kpp.RECEIVE_CLOSE_TOLERANCE,
                        kpp.TOLERANCE,
                        kpp.komen komen_pembelian,
                        kppi.TEMPLATE,
                        kppi.ACTION finish
                FROM khs_pmi_request kpr, 
                        khs_pmi_tim_kode kptk,
                        khs_pmi_uom kpu,
                        khs_pmi_proses_lanjutan pl,
                        khs_pmi_akuntansi kpa,
                        khs_pmi_pembelian kpp,
                        khs_pmi_piea kppi
                WHERE kpr.ID_ITEM = pl.ID_ITEM
                and kpr.ID_UOM = kpu.ID_UOM
                and kpr.id_item = kptk.id_item(+)
                and kpr.id_item = kpa.id_item(+)
                and kpr.id_item = kpp.id_item(+)
                and kpr.id_item = kppi.id_item(+)
                $term ";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function dataOrgAssign($no){
        $sql = "select * 
                from khs_pmi_org_assign
                where id_item = '$no'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function dataProsesLanjut($no){
        $sql = "select * 
                from khs_pmi_proses_lanjutan 
                where id_item = '$no'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function dataAkuntansi($no){
        $sql = "select * 
                from khs_pmi_akuntansi
                where id_item = '$no'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function dataTimKode($id_item){
        $sql = "select * 
                from khs_pmi_tim_kode 
                where id_item = '$id_item'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function dataTimKode2($item){
        $sql = "select * 
                from khs_pmi_tim_kode 
                where revisi_kode_item = '$item'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function dataPembelian($id_item){
        $sql = "select * 
                from khs_pmi_pembelian 
                where id_item = '$id_item'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function dataPIEA($id_item){
        $sql = "select * 
                from khs_pmi_piea 
                where id_item = '$id_item'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getExpAcc($term){
        $sql = "select ffv.FLEX_VALUE
                ,ffvt.DESCRIPTION
                from fnd_flex_values ffv
                ,fnd_flex_values_tl ffvt
                where ffv.FLEX_VALUE_SET_ID = 1013708
                and ffv.ENABLED_FLAG = 'Y'
                and ffv.END_DATE_ACTIVE is null
                and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
                and ffv.FLEX_VALUE like '%$term%'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function saveheader($idreq, $nodoc, $id_seksi, $tanggal, $pic, $status){
        $sql = "insert into khs_pmi_header (id_request, no_dokumen, id_seksi, tgl_request, pic, status)
                values($idreq, '$nodoc', $id_seksi, to_timestamp('$tanggal', 'DD/MM/YYYY HH24:MI:SS'), '$pic', 'Pengecekan $status')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function saverequest($idreq, $id_item, $status, $item_id, $item, $desc, $uom, $dual_uom, $makebuy, $stock, $no_serial, $inspect, $latar, $keterangan, $isi_dual){
        $sql = "insert into khs_pmi_request (id_request, id_item, status_request, inv_item_id, kode_item, deskripsi, id_uom, dual_uom, 
                make_buy, stok, no_serial, inspect_at_receipt, latar_belakang, keterangan, secondary_uom)
                values($idreq, $id_item, '$status','$item_id', '$item', '$desc', $uom, '$dual_uom', '$makebuy', '$stock', '$no_serial', '$inspect',
                '$latar', '$keterangan', '$isi_dual')";
                // print_r($sql);
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function saveOrgAssign($id_item, $org){
        $sql = "insert into khs_pmi_org_assign (id_item, org_assign)
                values($id_item, '$org')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function saveProsesLanjutan($id_item, $odm, $opm, $jual){
        $sql = "insert into khs_pmi_proses_lanjutan (id_item, odm, opm, jual)
                values($id_item, '$odm', '$opm','$jual')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function saveTimkode($id_item, $revisi, $desc, $tgl, $pic){
        $sql = "insert into khs_pmi_tim_kode (id_item, revisi_kode_item, revisi_desc_item, tanggal_input, pic)
                values($id_item, '$revisi', '$desc', to_timestamp('$tgl', 'DD/MM/YYYY HH24:MI:SS'),'$pic')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function saveAkuntansi($id_item, $inv, $exp, $tgl, $pic, $comment){
        $sql = "insert into khs_pmi_akuntansi (id_item, inv_value, exp_acc, tanggal_input, pic, komen)
                values($id_item, '$inv', '$exp', to_timestamp('$tgl', 'DD/MM/YYYY HH24:MI:SS'),'$pic', '$comment')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function savePembelian($id_item, $buyer, $pre_proses, $preparation, $delivery, $total_proses, $post_proses, 
    $total_lead, $moq, $flm, $approver, $keterangan, $receive, $tolerance, $tgl, $pic, $comment){
        $sql = "insert into khs_pmi_pembelian (id_item, buyer, pre_processing, preparation_po, delivery, total_proses, 
                post_processing, total_lead_time, moq, flm, approver_po, keterangan, receive_close_tolerance, tolerance, tanggal_input, pic, komen)
                values($id_item, '$buyer', '$pre_proses', '$preparation', '$delivery', '$total_proses', '$post_proses', 
                '$total_lead', '$moq', '$flm', '$approver', '$keterangan', '$receive', '$tolerance', to_timestamp('$tgl', 'DD/MM/YYYY HH24:MI:SS'),'$pic', '$comment')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function savePIEA($id_item, $template, $action, $tgl, $pic){
        $sql = "insert into khs_pmi_piea (id_item, template, action, tanggal_input, pic)
                values($id_item, '$template', '$action', to_timestamp('$tgl', 'DD/MM/YYYY HH24:MI:SS'),'$pic')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    
    public function updateHeader($no_dokumen, $status){
        $sql = "update khs_pmi_header set status = '$status'
                where no_dokumen = '$no_dokumen'";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }
    

    public function template($mb, $stok, $serial, $inspect, $odm, $opm, $jual, $inv, $org){
        // echo "<pre>";print_r($);exit();
        $odm = empty($odm) ? 'N' : 'Y';
        $opm = empty($opm) ? 'N' : 'Y';
        $jual = empty($jual) ? 'N' : 'Y';
        $sql = "select * from khs_pmi_template
                where make_buy = '$mb'
                and stok = '$stok'
                and serial = '$serial'
                and inspect = '$inspect'
                and odm = '$odm'
                and opm = '$opm'
                and jual = '$jual'
                and inv = '$inv'
                and org_assign like '%$org%'";
        // echo "<pre>";print_r($sql);exit();
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getBuyer($term){
        $sql = "select ppf.NATIONAL_IDENTIFIER, ppf.FULL_NAME from per_people_f ppf
                where ppf.EFFECTIVE_END_DATE > sysdate
                and ppf.PERSON_TYPE_ID = 6
                and ppf.ATTRIBUTE3 like '%PEMBELIAN%'
                and ppf.FULL_NAME like '%$term%'";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
	public function getApprover($term){
        $sql = "select * 
                from fnd_flex_values ffv 
                where ffv.FLEX_VALUE_SET_ID = '1018344' 
                and ffv.flex_value like '%$term%' 
                order by flex_value";
		// $sql = "select distinct ppf.FIRST_NAME ||' '|| ppf.LAST_NAME name from khs_approver_po kap, per_people_f ppf where kap.APPROVER_PERSON_ID = ppf.PERSON_ID";
		$query = $this->oracle->query($sql);
		return $query->result_array();
    }
    
    public function saveuom($id, $kode, $uom){
        $sql = "insert into khs_pmi_uom (id_uom, kode_uom, uom)
                values($id, '$kode', '$uom')";
        $query = $this->oracle->query($sql);
        $query = $this->oracle->query('commit');
    }

    public function getApprovePembelian($item){
        $sql = "select msib.segment1 
                ,msib.description
                ,msib.PRIMARY_UOM_CODE
                ,msib.SECONDARY_UOM_CODE
                ,msib.buyer_id
                ,ppf.FULL_NAME
                ,msib.PREPROCESSING_LEAD_TIME
                ,msib.attribute6
                ,msib.attribute8
                ,msib.FULL_LEAD_TIME
                ,msib.POSTPROCESSING_LEAD_TIME
                ,msib.PREPROCESSING_LEAD_TIME+msib.FULL_LEAD_TIME+msib.POSTPROCESSING_LEAD_TIME total_leadtime
                ,msib.MINIMUM_ORDER_QUANTITY
                ,msib.FIXED_LOT_MULTIPLIER
                ,msib.RECEIVE_CLOSE_TOLERANCE
                ,msib.QTY_RCV_TOLERANCE
                ,msib.attribute18
                from mtl_system_items_b msib
                ,per_people_f ppf
                where msib.BUYER_ID = ppf.PERSON_ID
                and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and msib.PLANNING_MAKE_BUY_CODE = 2
                and msib.organization_id = 81
                AND msib.SEGMENT1 = '$item'";
        $query = $this->oracle->query($sql);
		return $query->result_array();
    }
     

}