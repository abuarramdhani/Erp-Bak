<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_progress extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function searchItem($q)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT distinct 
            msib.SEGMENT1 KODE_ITEM
            ,msib.DESCRIPTION DESKRIPSI_ITEM
            ,msib.INVENTORY_ITEM_ID ITEM_ID
        from 
            mtl_system_items_b msib 
        where 
            msib.INVENTORY_ITEM_STATUS_CODE <> 'Inactive'
        AND msib.SEGMENT1 LIKE '$q%' OR msib.DESCRIPTION LIKE '$q%'");

        return $query->result_array();
    }

    public function searchRequester($r)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT ppf.person_id, ppf.full_name, ppf.national_identifier
        FROM per_all_people_f ppf,
             per_all_assignments_f paaf,
             per_business_groups_perf pbg
        WHERE ppf.business_group_id IN (SELECT fsp.business_group_id
            FROM financials_system_params_all fsp)
             AND ppf.business_group_id = pbg.business_group_id
             AND paaf.person_id = ppf.person_id
             AND paaf.primary_flag = 'Y'
             AND TRUNC (SYSDATE) BETWEEN ppf.effective_start_date
                                     AND ppf.effective_end_date
             AND TRUNC (SYSDATE) BETWEEN paaf.effective_start_date
                                     AND paaf.effective_end_date
             AND (   NVL (ppf.current_employee_flag, 'N') = 'Y'
                  OR NVL (ppf.current_npw_flag, 'N') = 'Y'
                 )
             AND paaf.assignment_type IN
                    ('E',
                     DECODE (NVL (fnd_profile.VALUE ('HR_TREAT_CWK_AS_EMP'), 'N'),
                             'Y', 'C',
                             'E'
                            )
                    )
             AND (ppf.full_name LIKE '$r%' OR ppf.national_identifier LIKE '$r%')");

        return $query->result_array();
    }

    public function getReport($person_id, $item_id, $no_pr, $no_po, $tanggal1, $tanggal2)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT distinct
            trunc(to_date(substr(prha.attribute1,1,10),'YYYY/MM/DD')) tanggal_pp_dibuat
                ,prla.reference_num nomor_pp
                ,pha.segment1 no_po
                ,trunc(pha.creation_date) tanggal_po
                ,prha.segment1 no_pr
                ,trunc(prha.creation_date) tanggal_pr
                ,trunc(to_date(substr(prha.attribute2,1,10),'YYYY/MM/DD')) tanggal_pp_diterima
                ,(select
                trunc(max(pah1.ACTION_DATE))
                from
                po_action_history pah1
                where
                prha.REQUISITION_HEADER_ID = pah1.OBJECT_ID
                and pah1.OBJECT_TYPE_CODE = 'REQUISITION'
                and pah1.ACTION_CODE = 'APPROVE') pp_approve
                ,trunc(prla.need_by_date) nbd_seksi
                ,trunc(pnbd.need_by_date) nbd_pembelian
                ,trunc(pnbd.promised_date) promised_date
                ,msib.segment1 kode_item
                ,prla.item_description item_description_pr
                ,msib.description item_description
                ,prla.QUANTITY
                ,prla.UNIT_MEAS_LOOKUP_CODE satuan
                ,prla.note_to_agent keterangan
                ,ppf.national_identifier no_induk
                ,ppf.full_name requestor
                ,prha.DESCRIPTION seksi
                ,pha.CLOSED_CODE PO_STATUS
                ,(SELECT MIN(rt1.transaction_date) 
                    FROM rcv_transactions rt1
                    WHERE rt1.PO_LINE_ID = pda.PO_LINE_ID ) receipt_date
        from po_req_distributions_all prda
            ,po_requisition_lines_all prla
            ,po_requisition_headers_all prha
            ,po_distributions_all pda
            ,per_people_f ppf
            ,mtl_system_items_b msib
            ,po_headers_all pha
            ,po_line_locations_all PNBD
        where prda.requisition_line_id = prla.requisition_line_id
            and prla.requisition_header_id = prha.requisition_header_id
            and pda.req_distribution_id(+) = prda.distribution_id
            and pda.po_header_id = pha.po_header_id(+)
            and prla.item_id = msib.inventory_item_id
            and msib.organization_id = 81
            and prla.to_person_id = ppf.person_id
            and ppf.current_employee_flag = 'Y'
            and pnbd.PO_LINE_ID(+) = pda.PO_LINE_ID
            --PARAMETER
            and ppf.PERSON_ID = NVL($person_id, PPF.PERSON_ID)
            and PRLA.ITEM_ID = NVL($item_id, PRLA.ITEM_ID)
            and prha.SEGMENT1 = NVL($no_pr, prha.SEGMENT1)
            and trunc(to_date(substr(prha.attribute1,1,10),'YYYY/MM/DD')) between 
                nvl(to_date('$tanggal1','YYYY/MM/DD'),trunc(to_date(substr(prha.attribute1,1,10),'YYYY/MM/DD'))) 
                and
                nvl(to_date('$tanggal2','YYYY/MM/DD'),trunc(to_date(substr(prha.attribute1,1,10),'YYYY/MM/DD')))
            and nvl(pha.SEGMENT1,1) = nvl($no_po, NVL(pha.SEGMENT1,1))
            and prla.CANCEL_FLAG is null
            and prla.MODIFIED_BY_AGENT_FLAG is null
        order by 1,3");

        return $query->result_array();
    }
}
