<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_purchasing extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getReleasedOrder()
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                                oprh.*
                                ,ppf.NATIONAL_IDENTIFIER noind
                                ,ppf.full_name creator
                            FROM
                                KHS.KHS_OKBJ_PRE_REQ_HEADER oprh,
                                PER_PEOPLE_F ppf
                            WHERE
                                oprh.CREATED_BY = ppf.person_id
                                AND oprh.APPROVED_FLAG is null
                                AND oprh.APPROVED_BY is null
                                AND oprh.APPROVED_DATE is null");

        return $query->result_array();
    }

    public function updateReleasedOrder($pre_req_id, $order)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('APPROVED_DATE',"SYSDATE",false);
        $oracle->where('PRE_REQ_ID', $pre_req_id);
        $oracle->update('KHS.KHS_OKBJ_PRE_REQ_HEADER', $order);
    }

    public function getOrder($pre_req_id)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('PRE_REQ_ID', $pre_req_id);
        $query = $oracle->get('KHS.KHS_OKBJ_ORDER_HEADER');

        return $query->result_array();
    }

    public function getActOrder($person_id,$cond)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                    oprh.* ,
                    ppf.NATIONAL_IDENTIFIER noind ,
                    ppf.full_name creator ,
                    ppf2.FULL_NAME approver
                FROM
                    KHS.KHS_OKBJ_PRE_REQ_HEADER oprh,
                    PER_PEOPLE_F ppf,
                    PER_PEOPLE_F ppf2
                WHERE
                    oprh.CREATED_BY = ppf.person_id
                    AND oprh.APPROVED_BY = ppf2.PERSON_ID(+)
                    $cond
                    AND oprh.APPROVED_BY = '$person_id'
                    ORDER BY oprh.PRE_REQ_ID DESC");

        return $query->result_array();
    }

    public function getActOrderForBuyer($cond)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                    oprh.* ,
                    ppf.NATIONAL_IDENTIFIER noind ,
                    ppf.full_name creator ,
                    ppf2.FULL_NAME approver
                FROM
                    KHS.KHS_OKBJ_PRE_REQ_HEADER oprh,
                    PER_PEOPLE_F ppf,
                    PER_PEOPLE_F ppf2
                WHERE
                    oprh.CREATED_BY = ppf.person_id
                    AND oprh.APPROVED_BY = ppf2.PERSON_ID(+)
                    $cond
                    ORDER BY oprh.PRE_REQ_ID DESC");

        return $query->result_array();
    }

    public function DetailApprovedOrder()
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        kprh.PRE_REQ_ID ,
        koh.ORDER_ID ,
        koh.ORDER_DATE ,
        prha.SEGMENT1 no_pr ,
        prla.LINE_NUM pr_line_num
        --,kprh.CREATED_BY
    ,
        ppf_puller.FULL_NAME creation_by ,
        kprh.APPROVED_FLAG
        --,kprh.APPROVED_BY
    ,
        ppf_purchasing.FULL_NAME approved_by ,
        kprh.APPROVED_DATE,
        ppf_buyer.FULL_NAME buyer
    FROM
        khs.khs_okbj_order_header koh ,
        khs.khs_okbj_pre_req_header kprh ,
        po_requisition_lines_all prla ,
        po_requisition_headers_all prha ,
        per_people_f ppf_puller ,
        per_people_f ppf_purchasing,
        per_people_f ppf_buyer,
        mtl_system_items_b msib
    WHERE
        koh.PRE_REQ_ID = kprh.PRE_REQ_ID
        AND TO_CHAR(koh.ORDER_ID) = prla.ATTRIBUTE9
        AND prla.REQUISITION_HEADER_ID = prha.REQUISITION_HEADER_ID
        AND kprh.APPROVED_FLAG = 'Y'
        AND kprh.CREATED_BY = ppf_puller.PERSON_ID
        AND kprh.APPROVED_BY = ppf_purchasing.PERSON_ID
        AND koh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        AND msib.ORGANIZATION_ID = koh.DESTINATION_ORGANIZATION_ID
        AND msib.BUYER_ID = ppf_buyer.PERSON_ID");

        return $query->result_array();
    }

    public function getDetailApprovedOrder($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                                    DISTINCT ooh.*,
                                    msib.SEGMENT1,
                                    msib.DESCRIPTION,
                                    ppf.NATIONAL_IDENTIFIER,
                                    ppf.FULL_NAME,
                                    ppf.ATTRIBUTE3,
                                    ppfbuyer.FULL_NAME buyer_name,
                                    (SELECT count(FILE_NAME) FROM KHS.KHS_OKBJ_ORDER_ATTACHMENTS 
                                    WHERE ORDER_ID = ooh.ORDER_ID) attachment
                                FROM
                                    KHS.KHS_OKBJ_ORDER_HEADER ooh,
                                    PER_PEOPLE_F ppf,
                                    mtl_system_items_b msib,
                                    PER_PEOPLE_F ppfbuyer
                                WHERE
                                    ooh.CREATE_BY = ppf.PERSON_ID
                                    AND ooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                                    AND msib.BUYER_ID = ppfbuyer.PERSON_ID
                                    AND ooh.ORDER_ID = '$order_id'");
        return $query->result_array();
    }

    public function getPuller($pre_req_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * from KHS.KHS_OKBJ_PRE_REQ_HEADER WHERE PRE_REQ_ID = '$pre_req_id'");
        return $query->result_array();
    }

    public function getDescItem($inv_item_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT msib.SEGMENT1,
        msib.DESCRIPTION,msib.ALLOW_ITEM_DESC_UPDATE_FLAG from mtl_system_items_b msib where msib.INVENTORY_ITEM_ID = '$inv_item_id'");
        return $query->result_array();
    }

    public function UpdateOrder($pre_req_id,$orderHead)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('PRE_REQ_ID',$pre_req_id);
        $oracle->update('KHS.KHS_OKBJ_ORDER_HEADER',$orderHead);
    }

    public function cetakHeader($pre_req_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                    oprh.* ,
                    ppf.NATIONAL_IDENTIFIER noind ,
                    ppf.full_name creator ,
                    ppf2.FULL_NAME approver
                FROM
                    KHS.KHS_OKBJ_PRE_REQ_HEADER oprh,
                    PER_PEOPLE_F ppf,
                    PER_PEOPLE_F ppf2
                WHERE
                    oprh.CREATED_BY = ppf.person_id
                    AND oprh.APPROVED_BY = ppf2.PERSON_ID(+)
                    AND oprh.APPROVED_FLAG = 'Y'
                    AND oprh.PRE_REQ_ID = '$pre_req_id'");

        return $query->result_array();
    }

    public function cetakOrder($pre_req_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("select
        koprh.PRE_REQ_ID
        ,kooh.ORDER_ID
        ,kooh.ORDER_DATE
        ,pr.SEGMENT1 as PR
        ,pr.LINE_NUM
        ,ppfo.NATIONAL_IDENTIFIER
        ,ppfo.FULL_NAME
        ,ppfo.ATTRIBUTE3
        ,msib.SEGMENT1
        ,msib.DESCRIPTION
        ,kooh.ITEM_DESCRIPTION
        ,kooh.QUANTITY
        ,kooh.UOM
        ,kooh.NEED_BY_DATE
        ,kooh.URGENT_FLAG
        ,kooh.IS_SUSULAN
        ,mp.ORGANIZATION_CODE
        ,kooh.DESTINATION_SUBINVENTORY
        ,hla.LOCATION_CODE
        ,kooh.ORDER_PURPOSE
        ,kooh.URGENT_REASON
        ,case
            when kooh.IS_SUSULAN = 'Y' then 'SUSULAN - '||kooh.NOTE_TO_BUYER
            else kooh.NOTE_TO_BUYER
        end NOTE_TO_BUYER
        from
        khs.khs_okbj_pre_req_header koprh
        ,khs.khs_okbj_order_header kooh
        ,mtl_system_items_b msib
        ,per_people_f ppfo
        ,mtl_parameters mp
        ,HR_LOCATIONS_ALL hla
        ,(select
        prha.SEGMENT1
        ,prla.LINE_NUM
        ,prla.ATTRIBUTE9
        from
        po_requisition_lines_all prla
        ,po_requisition_headers_all prha
        where
        prla.REQUISITION_HEADER_ID = prha.REQUISITION_HEADER_ID
        and REGEXP_LIKE(prla.ATTRIBUTE9, '^[[:digit:]]+$')
        ) pr
        where 1=1
        and koprh.PRE_REQ_ID = kooh.PRE_REQ_ID
        and kooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        and kooh.DESTINATION_ORGANIZATION_ID = msib.ORGANIZATION_ID
        and kooh.CREATE_BY = ppfo.PERSON_ID
        and kooh.DESTINATION_ORGANIZATION_ID = mp.ORGANIZATION_ID
        and kooh.DELIVER_TO_LOCATION_ID = hla.LOCATION_ID(+)
        and kooh.ORDER_ID = pr.ATTRIBUTE9(+)
        and koprh.PRE_REQ_ID = $pre_req_id -- parameter
        order by
        kooh.ORDER_ID");

        return $query->result_array();
    }

    public function cetakApprover($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        kooa.APPROVER_TYPE
        ,koal.DESCRIPTION
        ,kooa.JUDGEMENT_DATE
        ,ppf.FULL_NAME
        from
        khs.khs_okbj_order_approval kooa
        ,khs.khs_okbj_approver_level koal
        ,per_people_f ppf
        where
        kooa.APPROVER_TYPE = koal.LEVEL_NUMBER
        and kooa.APPROVER_ID = ppf.PERSON_ID
        and kooa.ORDER_ID = $order_id -- parameter
        order by kooa.APPROVER_TYPE");

        return $query->result_array();
    }
}