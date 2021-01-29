<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_buyer extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function DetailApprovedOrder($noind){
        $oracle = $this->load->database('oracle', true);
        $query  = $oracle->query("SELECT
                                     kprh.PRE_REQ_ID ,
                                     koh.ORDER_ID ,
                                     koh.ORDER_DATE ,
                                     prha.SEGMENT1 no_pr ,
                                     prla.LINE_NUM pr_line_num,
                                     (SELECT count(FILE_NAME) FROM KHS.KHS_OKBJ_ORDER_ATTACHMENTS 
                                     WHERE ORDER_ID = koh.ORDER_ID) attachment
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
                                     AND msib.BUYER_ID = ppf_buyer.PERSON_ID
                                     ");
        return $query->result_array();
    }
}