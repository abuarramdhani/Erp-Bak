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
                                    kprh.pre_req_id ,
                                    koh.order_id ,
                                    koh.order_date ,
                                    prha.segment1 no_pr ,
                                    prla.line_num pr_line_num,
                                    (
                                    SELECT
                                        COUNT( file_name )
                                    FROM
                                        khs.khs_okbj_order_attachments
                                    WHERE
                                        order_id = koh.order_id ) attachment,
                                    ppf_puller.full_name creation_by ,
                                    kprh.approved_flag,
                                    ppf_purchasing.full_name approved_by ,
                                    kprh.approved_date,
                                    ppf_buyer.national_identifier,
                                    ppf_buyer.full_name buyer
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
                                      koh.pre_req_id = kprh.pre_req_id
                                      AND TO_CHAR( koh.order_id ) = prla.attribute9
                                      AND prla.requisition_header_id = prha.requisition_header_id
                                      AND kprh.approved_flag = 'Y'
                                      AND kprh.created_by = ppf_puller.person_id
                                      AND kprh.approved_by = ppf_purchasing.person_id
                                      AND koh.inventory_item_id = msib.inventory_item_id
                                      AND msib.organization_id = koh.destination_organization_id
                                      AND msib.buyer_id = ppf_buyer.person_id
                                      AND ppf_buyer.national_identifier = '$noind'
                                     ");
        return $query->result_array();
    }
}