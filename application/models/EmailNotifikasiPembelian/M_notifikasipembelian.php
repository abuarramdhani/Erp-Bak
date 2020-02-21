<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_notifikasipembelian extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
    }

    public function getListReceiver()
    {
        $sql    =  "select
                    prla.REFERENCE_NUM NO_PP
                    ,prla.TO_PERSON_ID
                    ,ppf.NATIONAL_IDENTIFIER
                    ,ppf.FULL_NAME
                    ,kep.EMAIL_INTERNAL
                    ,prha.SEGMENT1 NO_PR
                    ,prha.REQUISITION_HEADER_ID 
                    ,pah.ACTION_DATE
                    from
                    PO_ACTION_HISTORY pah
                    ,PO_REQUISITION_HEADERS_ALL prha
                    ,PO_REQUISITION_LINES_ALL prla
                    ,per_people_f ppf
                    ,khs.khs_email_pekerja kep
                    where
                    pah.OBJECT_ID = prha.REQUISITION_HEADER_ID
                    and prha.REQUISITION_HEADER_ID = prla.REQUISITION_HEADER_ID
                    and prla.TO_PERSON_ID = ppf.PERSON_ID
                    and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'
                    and ppf.NATIONAL_IDENTIFIER = kep.NATIONAL_IDENTIFIER
                    and pah.ACTION_CODE = 'APPROVE'
                    and pah.OBJECT_TYPE_CODE = 'REQUISITION'
                    and prla.REFERENCE_NUM is not null
                    and TRUNC(pah.ACTION_DATE) = TRUNC(SYSDATE)-1
                    group by
                    prla.REFERENCE_NUM
                    ,prla.TO_PERSON_ID
                    ,ppf.NATIONAL_IDENTIFIER
                    ,ppf.FULL_NAME
                    ,kep.EMAIL_INTERNAL
                    ,prha.SEGMENT1
                    ,prha.REQUISITION_HEADER_ID
                    ,pah.ACTION_DATE";
        
        $query  = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getDataItem($req,$tpi)
    {
        $sql = "select
                prla.LINE_NUM
                ,msib.SEGMENT1 KODE_ITEM
                ,prla.ITEM_DESCRIPTION
                ,prla.QUANTITY QTY
                ,prla.UNIT_MEAS_LOOKUP_CODE
                ,prla.NEED_BY_DATE
                ,prla.NOTE_TO_AGENT
                from
                PO_REQUISITION_LINES_ALL prla
                ,mtl_system_items_b msib
                where
                prla.ITEM_ID = msib.INVENTORY_ITEM_ID
                and msib.ORGANIZATION_ID = 81
                and prla.REQUISITION_HEADER_ID = $req
                and prla.TO_PERSON_ID = $tpi";
        $query  = $this->oracle->query($sql);
        return $query->result_array();
    }
}