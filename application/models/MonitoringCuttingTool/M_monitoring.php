<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function carimin($item) {
        $sql ="SELECT * FROM mct.mct_setting_minmax where item = '$item'";
        $query = $this->db->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getdataResharp($item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT TRIM (SUBSTR (item, 1, INSTR (item, '-') - 1)) baru
                        ,item,description
                        ,khs_inv_qty_oh (102, inventory_item_id, 'TR-TKS', 1131, NULL) onhand_TR_TKS
                FROM 
                (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        ,NVL (SUM (moqd.primary_transaction_quantity), 0) qty_onhand
                FROM mtl_system_items_b msib,
                        mtl_onhand_quantities_detail moqd,
                        mtl_item_locations mil
                WHERE msib.organization_id = 102
                    AND msib.inventory_item_id = moqd.inventory_item_id
                    AND msib.organization_id = moqd.organization_id
                    AND moqd.subinventory_code = 'TR-TKS'
                    AND moqd.locator_id = mil.inventory_location_id
                    AND mil.inventory_location_id = 1131
                    AND msib.SEGMENT1 like '%-R'
                    AND msib.SEGMENT1 like '%$item%'
                GROUP BY msib.inventory_item_id, msib.segment1, msib.description, msib.PREPROCESSING_LEAD_TIME ,msib.MINIMUM_ORDER_QUANTITY,msib.FULL_LEAD_TIME ,msib.POSTPROCESSING_LEAD_TIME )
                ORDER BY item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getdataTumpul($item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT TRIM (SUBSTR (item, 1, INSTR (item, '-') - 1)) baru
                        ,item,description
                        ,khs_inv_qty_oh (102, inventory_item_id, 'TR-TKS', 1131, NULL) onhand_TR_TKS
                FROM 
                (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        ,NVL (SUM (moqd.primary_transaction_quantity), 0) qty_onhand
                FROM mtl_system_items_b msib,
                        mtl_onhand_quantities_detail moqd,
                        mtl_item_locations mil
                WHERE msib.organization_id = 102
                    AND msib.inventory_item_id = moqd.inventory_item_id
                    AND msib.organization_id = moqd.organization_id
                    AND moqd.subinventory_code = 'TR-TKS'
                    AND moqd.locator_id = mil.inventory_location_id
                    AND mil.inventory_location_id = 1131
                    AND msib.SEGMENT1 like '%-T'
                    AND msib.SEGMENT1 like '%$item%'
                GROUP BY msib.inventory_item_id, msib.segment1, msib.description, msib.PREPROCESSING_LEAD_TIME ,msib.MINIMUM_ORDER_QUANTITY,msib.FULL_LEAD_TIME ,msib.POSTPROCESSING_LEAD_TIME )
                ORDER BY item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getdataBaru() {
        $oracle = $this->load->database('oracle', true);
        $sql ="SELECT item
                        ,description
                        ,khs_inv_qty_oh (102, inventory_item_id, 'TR-TKS', 1131, NULL) onhand_TR_TKS
                        ,moq
                        ,pre_proc+full+post_proc total_leadtime
                FROM 
                (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        ,msib.MINIMUM_ORDER_QUANTITY moq , msib.PREPROCESSING_LEAD_TIME pre_proc,msib.FULL_LEAD_TIME full,msib.POSTPROCESSING_LEAD_TIME post_proc
                        ,NVL (SUM (moqd.primary_transaction_quantity), 0) qty_onhand
                FROM mtl_system_items_b msib,
                        mtl_onhand_quantities_detail moqd,
                        mtl_item_locations mil
                WHERE msib.organization_id = 102
                    AND msib.inventory_item_id = moqd.inventory_item_id
                    AND msib.organization_id = moqd.organization_id
                    AND moqd.subinventory_code = 'TR-TKS'
                    AND moqd.locator_id = mil.inventory_location_id
                    AND mil.inventory_location_id = 1131
                    AND msib.segment1 not like '%-T'
                    AND msib.SEGMENT1 not like '%-R'
                GROUP BY msib.inventory_item_id, msib.segment1, msib.description, msib.PREPROCESSING_LEAD_TIME ,msib.MINIMUM_ORDER_QUANTITY,msib.FULL_LEAD_TIME ,msib.POSTPROCESSING_LEAD_TIME )
                ORDER BY item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getrataIN($item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="
                SELECT it.item, nvl(sum(tot.in_total),0) total_in
                FROM 
                --- subquery item yang akan dimunculkan
                (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                        FROM mtl_system_items_b msib,
                            mtl_onhand_quantities_detail moqd,
                            mtl_item_locations mil
                        WHERE msib.organization_id = 102
                        AND msib.inventory_item_id = moqd.inventory_item_id
                        AND msib.organization_id = moqd.organization_id
                        AND moqd.subinventory_code = 'TR-TKS'
                        AND moqd.locator_id = mil.inventory_location_id
                        AND mil.inventory_location_id = 1131
                          AND msib.SEGMENT1 LIKE '%$item%'
                --        AND msib.SEGMENT1 like '%-R'  -----item resharpening
                --           AND msib.SEGMENT1 like '%-T'  -----item Tumpul
                --           AND msib.SEGMENT1 not like '%-R'  -----item baru
                --           AND msib.SEGMENT1 not like '%-T'  -----item baru
                        GROUP BY msib.inventory_item_id, msib.segment1, msib.description) it
                    ,(select kode, bulan, NVL(SUM(total),0) in_total
                            FROM
                            (SELECT msib.segment1 kode, TO_CHAR(mmt.transaction_date, 'Mon-YYYY') bulan , NVL(SUM(mmt.TRANSACTION_QUANTITY),0) total
                            FROM mtl_system_items_b msib, mtl_material_transactions mmt
                            WHERE msib.inventory_item_id = mmt.inventory_item_id
                            AND msib.organization_id = mmt.organization_id
                            AND mmt.TRANSACTION_QUANTITY > 0 --------- < keluar, > masuk
                            AND mmt.subinventory_code = 'TR-TKS'
                            AND TO_CHAR(mmt.transaction_date, 'YYYY') = to_char(sysdate, 'YYYY')
                            group by msib.SEGMENT1, mmt.TRANSACTION_DATE)
                    group by kode, bulan
                    order by kode, bulan) tot
                WHERE it.item = tot.kode(+)
                group by it.item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }

    public function getrataOUT($item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="
        SELECT it.item, nvl(sum(tot.in_total),0) total_out
        FROM 
        --- subquery item yang akan dimunculkan
        (SELECT msib.inventory_item_id, msib.segment1 item, msib.description
                  FROM mtl_system_items_b msib,
                       mtl_onhand_quantities_detail moqd,
                       mtl_item_locations mil
                 WHERE msib.organization_id = 102
                   AND msib.inventory_item_id = moqd.inventory_item_id
                   AND msib.organization_id = moqd.organization_id
                   AND moqd.subinventory_code = 'TR-TKS'
                   AND moqd.locator_id = mil.inventory_location_id
                   AND mil.inventory_location_id = 1131
                   AND msib.SEGMENT1 LIKE '%$item%'
        --           AND msib.SEGMENT1 like '%-R'  -----item resharpening
        --           AND msib.SEGMENT1 like '%-T'  -----item Tumpul
        --           AND msib.SEGMENT1 not like '%-R'  -----item baru
        --           AND msib.SEGMENT1 not like '%-T'  -----item baru
                GROUP BY msib.inventory_item_id, msib.segment1, msib.description) it
            ,(select kode, bulan, NVL(SUM(total),0) in_total
                    FROM
                       (SELECT msib.segment1 kode, TO_CHAR(mmt.transaction_date, 'Mon-YYYY') bulan , NVL(SUM(mmt.TRANSACTION_QUANTITY),0) total
                      FROM mtl_system_items_b msib, mtl_material_transactions mmt
                     WHERE msib.inventory_item_id = mmt.inventory_item_id
                       AND msib.organization_id = mmt.organization_id
                       AND mmt.TRANSACTION_QUANTITY < 0 --------- < keluar, > masuk
                       AND mmt.subinventory_code = 'TR-TKS'
                       AND TO_CHAR(mmt.transaction_date, 'YYYY') = to_char(sysdate, 'YYYY')
                      group by msib.SEGMENT1, mmt.TRANSACTION_DATE)
              group by kode, bulan
              order by kode, bulan) tot
        WHERE it.item = tot.kode(+)
        group by it.item";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    
    public function getOutstanding($item) {
        $oracle = $this->load->database('oracle', true);
        $sql ="select distinct
                        prla.destination_subinventory                 subinv 
                    ,msib.segment1                                               item
                    ,nvl(pla.item_description,prla.item_description)     item_description
                    ,sum(nvl(plla.quantity -
                                decode(pla.order_type_lookup_code,
                                        'RATE', TO_NUMBER (NULL),
                                        'FIXED PRICE', TO_NUMBER (NULL),
                                        plla.quantity_received
                                        ),prla.quantity)) over (partition by plla.SHIP_TO_ORGANIZATION_ID
                                                                            ,msib.INVENTORY_ITEM_ID
                                                                            )              due_quantity
                from (select ph.*,papf_buyer.full_name 
                        from po_headers_all ph
                            ,per_all_people_f papf_buyer
                        where papf_buyer.person_id = ph.agent_id
                        ) pha
                    ,po_lines_all pla
                    ,po_distributions_all pda
                    ,po_req_distributions_all prda
                    ,po_requisition_lines_all prla
                    ,po_requisition_headers_all prha
                    ,(select distinct 
                            b.inventory_item_id
                            ,b.segment1
                            ,tl.description 
                            ,b.primary_uom_code
                            ,b.primary_unit_of_measure
                            ,b.organization_id
                            ,papf.full_name
                            ,b.BUYER_ID
                        from mtl_system_items_b  b
                            ,mtl_system_items_tl tl
                            ,mtl_item_categories mic
                            ,mtl_category_sets_tl mcst
                            ,per_all_people_f papf
                        where b.inventory_item_id = tl.inventory_item_id
                        and b.organization_id = tl.organization_id
                        and b.inventory_item_id = mic.inventory_item_id
                        and mic.category_set_id = mcst.category_set_id
                        and b.BUYER_ID = papf.person_id(+)
                        and nvl(b.end_date_active,sysdate+1) > sysdate
                        and b.enabled_flag = 'Y'
                        and ((mcst.category_set_name like ('KHS REPORT_PPC%')) 
                            or (mcst.category_set_name not like ('KHS REPORT_PPC%')))
                        --      order by full_name
                            ) msib 
                    ,po_line_locations_all plla
                    ,hr_all_organization_units haou
                where pha.po_header_id(+) = pla.po_header_id
                and pla.po_header_id(+) = pda.po_header_id 
                and pla.po_line_id(+) = pda.po_line_id
                and pda.req_distribution_id(+) = prda.distribution_id
                and prda.requisition_line_id(+) = prla.requisition_line_id
                and prla.requisition_header_id = prha.requisition_header_id(+)
                and msib.inventory_item_id = prla.item_id
                and NVL(prla.CANCEL_FLAG,'N') <> 'Y'
                and NVL(prla.MODIFIED_BY_AGENT_FLAG,'N') <> 'Y'  --line yang di split
                and prla.CLOSED_CODE IS NULL 
                and msib.organization_id = 81
                and prha.org_id = 82
                and plla.po_line_id(+) = pla.po_line_id
                and haou.organization_id(+) = plla.ship_to_organization_id
                and coalesce(plla.closed_code,'NULL')  = decode(plla.closed_code,null,'NULL','OPEN')     
                and msib.segment1 = CASE WHEN SUBSTR(UPPER(msib.segment1), 1 ,3) = 'JAC'
                                            THEN CASE WHEN UPPER(SUBSTR(msib.segment1, LENGTH(msib.segment1))) = 'A'
                                                    THEN SUBSTR(msib.segment1, 4, LENGTH(msib.segment1) - 4)
                                                    ELSE SUBSTR(msib.segment1, 4, LENGTH(msib.segment1) - 3)
                                                            END
                                            ELSE msib.segment1
                                    END           
                -- parameter
                and plla.SHIP_TO_ORGANIZATION_ID = 102
                and prla.DESTINATION_SUBINVENTORY = 'TR-TKS'
                and msib.SEGMENT1 = '$item'
                and decode(nvl(plla.closed_code,'NULL'),'NULL',
                                        decode(prha.AUTHORIZATION_STATUS,
                                                'APPROVED','TRUE','FALSE'),'OPEN',
                                        decode(1,sign(plla.quantity - decode(pla.order_type_lookup_code,
                                                                            'RATE', TO_NUMBER (NULL),
                                                                            'FIXED PRICE', TO_NUMBER (NULL),
                                                                            plla.quantity_received)),'TRUE',
                                                sign(decode(pla.order_type_lookup_code,
                                                            'RATE', TO_NUMBER (NULL),
                                                            'FIXED PRICE', TO_NUMBER (NULL),
                                                            plla.quantity_rejected)),'TRUE','FALSE'),
                                        'TRUE','FALSE'                       
                                    ) = 'TRUE'";
        $query = $oracle->query($sql);
        return $query->result_array();
        // echo $sql;
    }
    


}

