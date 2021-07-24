<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_import extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function validasiItem($itemcode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
            msib.INVENTORY_ITEM_ID ,
            msib.SEGMENT1 kode_item ,
            msib.DESCRIPTION ,
            msib.PRIMARY_UNIT_OF_MEASURE primary_uom ,
            muomt.UNIT_OF_MEASURE secondary_uom ,
            NVL(msib.PREPROCESSING_LEAD_TIME, 0) + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) total_lead_time,
            TO_CHAR((CASE WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)<10) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)>= 10 AND EXTRACT(DAY FROM SYSDATE)<25) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 25 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)>= 25) THEN LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) WHEN (mcb.CATEGORY_ID IN (67007, 67008) AND EXTRACT(DAY FROM SYSDATE)<10) THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) WHEN (mcb.CATEGORY_ID IN (67007, 67008) AND EXTRACT(DAY FROM SYSDATE)>= 10) THEN LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) ELSE LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) END), 'DD-Mon-YYYY') default_nbd
        FROM
            mtl_system_items_b msib ,
            mtl_units_of_measure_tl muomt ,
            mtl_item_categories mic ,
            mtl_categories_b mcb
        WHERE
            msib.ORGANIZATION_ID IN (101,
            102)
            AND msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
            AND msib.ORGANIZATION_ID = mic.ORGANIZATION_ID
            AND mic.CATEGORY_SET_ID = '1100000244'
            AND mic.category_id = mcb.category_id
            AND msib.SECONDARY_UOM_CODE = muomt.UOM_CODE(+)
            AND msib.SEGMENT1 = '$itemcode'
            -- parameter
            AND msib.INVOICEABLE_ITEM_FLAG = 'Y'");

        return $query->result_array();
    }

    public function validasiSubinventory($organization, $subinventory)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        msi.SECONDARY_INVENTORY_NAME
        ,msi.STATUS_ID
        from
        mtl_secondary_inventories msi
        ,mtl_parameters mp
        where
        msi.STATUS_ID <> 60
        and msi.ORGANIZATION_ID = mp.ORGANIZATION_ID
        and mp.ORGANIZATION_CODE = '$organization'
        and msi.SECONDARY_INVENTORY_NAME = '$subinventory'");

        return $query->result_array();
    }

    public function validasiLengkap($itemcode, $organization, $subinventory)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        msib.INVENTORY_ITEM_ID ,
        msib.SEGMENT1 kode_item ,
        msib.DESCRIPTION,
        msib.PRIMARY_UNIT_OF_MEASURE primary_uom ,
        muomt.UNIT_OF_MEASURE secondary_uom ,
        mp.ORGANIZATION_CODE ,
        msi.SECONDARY_INVENTORY_NAME ,
        TO_CHAR(
            (CASE 
                WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)<10) 
                    THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) 
                WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)>= 10 AND EXTRACT(DAY FROM SYSDATE)<25) 
                    THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 25 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) 
                WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)>= 25) 
                    THEN LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) 
                WHEN (mcb.CATEGORY_ID IN (67007, 67008) AND EXTRACT(DAY FROM SYSDATE)<10) 
                    THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) 
                WHEN (mcb.CATEGORY_ID IN (67007, 67008) AND EXTRACT(DAY FROM SYSDATE)>= 10) 
                    THEN LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) 
                ELSE LAST_DAY(SYSDATE)+ 10 + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) 
            END)
        , 'DD-Mon-YYYY') default_nbd,
        TO_CHAR(
            (CASE 
                WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)<10) 
                    THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 
                WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)>= 10 AND EXTRACT(DAY FROM SYSDATE)<25) 
                    THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 25
                WHEN (mcb.CATEGORY_ID IN (67009, 67010) AND EXTRACT(DAY FROM SYSDATE)>= 25) 
                    THEN LAST_DAY(SYSDATE)+ 10
                WHEN (mcb.CATEGORY_ID IN (67007, 67008) AND EXTRACT(DAY FROM SYSDATE)<10) 
                    THEN ADD_MONTHS(LAST_DAY(SYSDATE),-1)+ 10 
                WHEN (mcb.CATEGORY_ID IN (67007, 67008) AND EXTRACT(DAY FROM SYSDATE)>= 10) 
                    THEN LAST_DAY(SYSDATE)+ 10
            END)
        , 'DD-Mon-YYYY') CUTOFF_TERDEKAT,
        msibp.ATTRIBUTE27 puller
    FROM
        mtl_system_items_b msib ,
        mtl_units_of_measure_tl muomt ,
        mtl_secondary_inventories msi ,
        mtl_parameters mp ,
        mtl_item_categories mic ,
        mtl_categories_b mcb,
        mtl_system_items_b msibp
    WHERE
        msib.SECONDARY_UOM_CODE = muomt.UOM_CODE(+)
        AND msib.ORGANIZATION_ID = mp.ORGANIZATION_ID
        AND msib.ORGANIZATION_ID = msi.ORGANIZATION_ID
        AND msib.ORGANIZATION_ID IN (101, 102, 122, 286)
        AND msib.INVENTORY_ITEM_ID = msibp.INVENTORY_ITEM_ID
        AND msibp.ORGANIZATION_ID = 81
        AND msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
        AND msib.ORGANIZATION_ID = mic.ORGANIZATION_ID
        AND mic.CATEGORY_SET_ID = '1100000244'
        AND mic.category_id = mcb.category_id
        AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
        AND msi.STATUS_ID IN (1,20)
        AND mp.ORGANIZATION_CODE = '$organization'
        -- parameter ORG
        AND msi.SECONDARY_INVENTORY_NAME = '$subinventory'
        -- parameter subinventory
        AND msib.SEGMENT1 = '$itemcode'
        -- parameter masukan kode item
              ");

        return $query->result_array();
    }
    public function validasi_lokasi($lokasi)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("select
        hla.LOCATION_ID
        ,hla.LOCATION_CODE
        from
        HR_LOCATIONS_ALL hla
        where
        hla.INACTIVE_DATE is null
        and hla.LOCATION_CODE = '$lokasi' -- parameter");

        return $query->result_array();
    }
    public function getApproverSeksi($number)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT pf.person_id, pf.full_name nama,
        pf.national_identifier no_induk
   FROM khs.khs_okbj_approve_hir kh, per_all_people_f pf
  WHERE kh.approver = pf.person_id
    AND approver_level = $number
    AND pf.effective_end_date >= sysdate
ORDER BY 1");

        return $query->result_array();
    }
    public function getApproverPengelola($number)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT pf.person_id, pf.full_name nama,
        pf.national_identifier no_induk
   FROM khs.khs_okbj_approve_hir kh, per_all_people_f pf
  WHERE kh.person_id = pf.person_id
    AND approver_level = $number
    AND pf.effective_end_date >= sysdate
ORDER BY 1");

        return $query->result_array();
    }
    public function getApproverDepartement($number)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT pf.full_name nama,
        pf.person_id,
        pf.national_identifier no_induk
   FROM khs.khs_okbj_approve_hir kh, per_all_people_f pf
  WHERE kh.approver = pf.person_id
    AND approver_level = $number
    AND pf.effective_end_date >= sysdate
    AND pf.full_name not like '%WAHADA,%'
ORDER BY 1");

        return $query->result_array();
    }
    public function getExportHeadDataApproval($created_by, $okbj_name_approver, $okbj_lvl_approval)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("select distinct
        ppf_create.national_identifier nik_pembuat,
        ppf_create.full_name nama_pembuat,
        ppf_req.national_identifier nik_requester,
        ppf_req.full_name nama_requester,
        ppf_appr.national_identifier nik_approver,
        ppf_appr.full_name nama_approver,
        tbl1.a_level level_approved
    FROM khs.khs_okbj_order_header kooh,
           per_people_f ppfa,
           khs.khs_okbj_order_approval kkooa,
           (SELECT   kooa.order_id, MIN (kooa.approver_type) a_level
                FROM khs.khs_okbj_order_approval kooa
               WHERE kooa.judgement IS NULL
            GROUP BY kooa.order_id) tbl1,
           per_all_people_f ppf_create,
           per_all_people_f ppf_req,
           per_all_people_f ppf_appr
     WHERE kooh.order_id = tbl1.order_id
       AND kooh.order_id = kkooa.order_id
       AND kkooa.approver_type = tbl1.a_level
       AND kkooa.approver_id = ppfa.person_id
       AND kooh.order_status_id <> 4
       AND ppf_create.person_id = kooh.create_by
       AND ppf_req.person_id = kooh.requester
       AND ppf_appr.person_id = kkooa.approver_id
       AND ppf_create.national_identifier = '$created_by' -- parameter no induk pembuat
       AND ppf_appr.national_identifier = '$okbj_name_approver'  -- parameter no induk approver
       AND tbl1.a_level = $okbj_lvl_approval                     -- parameter tipe approval
    ");

        return $query->result_array();
    }
    public function getExportDataApproval($created_by, $okbj_name_approver, $okbj_lvl_approval)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT kooh.order_id, msib.segment1 item_code, kooh.item_description, kooh.quantity, kooh.uom,
        kooh.need_by_date, kooh.order_purpose, kooh.note_to_pengelola, kooh.urgent_reason,
        kooh.note_to_buyer,
        CASE
           WHEN kooh.is_susulan = 'Y'
              THEN 'Susulan'
           WHEN kooh.urgent_flag = 'Y'
           AND (kooh.is_susulan = 'N' OR kooh.is_susulan IS NULL)
              THEN 'Urgent'
           WHEN (kooh.urgent_flag <> 'Y' OR kooh.urgent_flag IS NULL)
           AND (kooh.is_susulan <> 'Y' OR kooh.is_susulan IS NULL)
              THEN 'Normal'
           ELSE 'Undefined'
        END status
   FROM khs.khs_okbj_order_header kooh,
        per_people_f ppfa,
        khs.khs_okbj_order_approval kkooa,
        (SELECT   kooa.order_id, MIN (kooa.approver_type) a_level
             FROM khs.khs_okbj_order_approval kooa
            WHERE kooa.judgement IS NULL
         GROUP BY kooa.order_id) tbl1,
        mtl_system_items_b msib,
        per_all_people_f ppf_create,
        per_all_people_f ppf_req,
        per_all_people_f ppf_appr
  WHERE kooh.order_id = tbl1.order_id
    AND kooh.order_id = kkooa.order_id
    AND kkooa.approver_type = tbl1.a_level
    AND kkooa.approver_id = ppfa.person_id
    AND kooh.order_status_id <> 4
    AND msib.inventory_item_id = kooh.inventory_item_id
    AND msib.organization_id = 81
    AND ppf_create.person_id = kooh.create_by
    AND ppf_req.person_id = kooh.requester
    AND ppf_appr.person_id = kkooa.approver_id
    AND (ppf_create.national_identifier = '$created_by' -- parameter no induk pembuat / login
        OR
        ppf_req.national_identifier = '$created_by' -- parameter no induk pembuat / login
        )
    AND ppf_appr.national_identifier = '$okbj_name_approver'  -- parameter no induk approver
    AND tbl1.a_level = $okbj_lvl_approval");

        return $query->result_array();
    }
    public function UpdateApproval($j, $o, $l)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->query("UPDATE khs.khs_okbj_order_approval kooa
        SET kooa.judgement = '$j',              -- 'A' atau 'R' 
            kooa.judgement_date = SYSDATE
      WHERE kooa.order_id = $o     -- kooh.order_id
        AND kooa.approver_type = $l   -- approveer level");

        $oracle->query("UPDATE khs.khs_okbj_order_header kooh
        SET kooh.approve_level_pos = $l -- approver level
      WHERE kooh.order_id = $o");
    }
    public function getDataperson($approver)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT PERSON_ID, FULL_NAME FROM PER_ALL_PEOPLE_F WHERE NATIONAL_IDENTIFIER = '$approver'");

        return $query->result_array();
    }
    public function getStatusOrder($order_id, $dataapprover, $level)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("select
        kooa.ORDER_ID,
        kooa.JUDGEMENT
    from
        khs.khs_okbj_order_approval kooa,
        per_all_people_f ppf
    where 1=1
        and ppf.person_id = kooa.approver_id
        and kooa.APPROVER_TYPE = $level
        and ppf.national_identifier = '$dataapprover'
        and kooa.ORDER_ID = $order_id");

        return $query->result_array();
    }
}
