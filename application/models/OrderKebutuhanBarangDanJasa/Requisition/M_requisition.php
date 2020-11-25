<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_requisition extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
    }

    // public function getItem($string)
    // {
    //     $oracle = $this->load->database("oracle", true);
    //     $query = $oracle->query(
    //         "SELECT
    //         msib.INVENTORY_ITEM_ID -- ini yang disimpan di database
    //         ,msib.ALLOW_ITEM_DESC_UPDATE_FLAG ALLOW_DESC
    //         ,msib.SEGMENT1 
    //         ,msib.DESCRIPTION 
    //         ,msib.PRIMARY_UNIT_OF_MEASURE PRIMARY_UOM
    //         ,muomt.UNIT_OF_MEASURE SECONDARY_UOM
    //         ,NVL(msib.PREPROCESSING_LEAD_TIME, 0) + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) LEAD_TIME
    //         FROM
    //             mtl_system_items_b msib
    //             ,mtl_units_of_measure_tl muomt
    //         WHERE
    //             msib.ORGANIZATION_ID = 81
    //             AND msib.PURCHASING_ENABLED_FLAG = 'Y'
    //             AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
    //             AND muomt.UOM_CODE(+) = msib.SECONDARY_UOM_CODE
    //             AND (msib.SEGMENT1 LIKE '$string%'
    //             OR msib.DESCRIPTION LIKE '$string%')
    //         ORDER BY
    //             msib.SEGMENT1 ASC"
    //     );
    //     return $query->result_array();
    // }

    //temporer

    public function getItem($string)
    {
        $oracle = $this->load->database("oracle", true);
        $query = $oracle->query("SELECT
        msib.INVENTORY_ITEM_ID
        -- ini yang disimpan di database
        ,
        msib.ALLOW_ITEM_DESC_UPDATE_FLAG ALLOW_DESC ,
        msib.SEGMENT1 ,
        msib.DESCRIPTION ,
        msib.PRIMARY_UNIT_OF_MEASURE PRIMARY_UOM ,
        muomt.UNIT_OF_MEASURE SECONDARY_UOM ,
        case 
            when mcb.SEGMENT1 = 'KHS_PUR_ITEM_NON_PRODUKSI_DIRECT' then 'Item Non Produksi Direct'
            when mcb.SEGMENT1 = 'KHS_PUR_ITEM_NON_PRODUKSI_INDIRECT' then 'Item Non Produksi Indirect'
            when mcb.SEGMENT1 = 'KHS_PUR_ITEM_PRODUKSI_DIRECT' then 'Item Produksi Direct'
            when mcb.SEGMENT1 = 'KHS_PUR_ITEM_PRODUKSI_INDIRECT' then 'Item Produksi Indirect'
        end KATEGORI_ITEM,
        msib.PREPROCESSING_LEAD_TIME ,
        msib.FULL_LEAD_TIME ,
        msib.POSTPROCESSING_LEAD_TIME ,
        mcb.CATEGORY_ID,
        NVL(msib.PREPROCESSING_LEAD_TIME, 0) + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) total_lead_time,
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
        CASE
            WHEN msib.ATTRIBUTE24 is null OR msib.ATTRIBUTE25 is null OR msib.ATTRIBUTE27 is null
                THEN 'BELUM DI SET'
            ELSE 'SUDAH DI SET'
            END SETUP_ITEM    
        -- msib.INVENTORY_ITEM_FLAG
        FROM
            mtl_system_items_b msib ,
            mtl_units_of_measure_tl muomt ,
            mtl_categories_b mcb ,
            mtl_item_categories mic
        WHERE
            msib.ORGANIZATION_ID = 81
            AND msib.PURCHASING_ENABLED_FLAG = 'Y'
            AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
            AND muomt.UOM_CODE(+) = msib.SECONDARY_UOM_CODE
            AND (msib.SEGMENT1 LIKE '%$string%' OR msib.DESCRIPTION LIKE '%$string%')
            AND msib.INVENTORY_ITEM_ID = mic.INVENTORY_ITEM_ID
            AND msib.ORGANIZATION_ID = mic.ORGANIZATION_ID
            AND mic.CATEGORY_SET_ID = '1100000244'
            AND mic.category_id = mcb.category_id
            AND msib.ORGANIZATION_ID = 81
            AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
        ORDER BY
            msib.SEGMENT1 ASC");
        return $query->result_array();
    }

    public function getPengorder($noind)
    {
        $query = $this->db->query("SELECT sec.section_name, sec.department_name FROM er.er_employee_all as emp, er.er_section as sec where emp.section_code=sec.section_code and emp.employee_code='$noind'");
		return $query->result_array();
    }

    // public function saveHeader($head)
    // {
    //     $oracle = $this->load->database('trial', true);
    //     $oracle->insert('t_head', $head);
    //     $last_insert_id = $oracle->insert_id();

    //     return $last_insert_id;
    // }

    public function saveLine($line, $nbd)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('NEED_BY_DATE',"TO_DATE('$nbd','YYYY-MM-DD')",false);
        $oracle->set('ORDER_DATE',"SYSDATE",false);
        $oracle->insert('KHS.KHS_OKBJ_ORDER_HEADER', $line);
        $order_id = $oracle->query("SELECT MAX(ORDER_ID) ORDER_ID FROM KHS.KHS_OKBJ_ORDER_HEADER");

        return $order_id->result_array();
    }

    public function getListDataOrder($noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT
        ooh.*,
        msib.SEGMENT1,
        msib.DESCRIPTION,
        ppf.NATIONAL_IDENTIFIER,
        ppf.FULL_NAME,
        ppf.ATTRIBUTE3
        FROM
            KHS.KHS_OKBJ_ORDER_HEADER ooh,
            PER_PEOPLE_F ppf,
            mtl_system_items_b msib
        WHERE
            ooh.CREATE_BY = ppf.PERSON_ID
            AND ooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
            AND ppf.NATIONAL_IDENTIFIER = '$noind'
            ORDER BY ooh.ORDER_ID DESC");

        return $query->result_array();
    }

    //kasie
    public function getListDataOrder2($noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT
        ooh.*,
        msib.SEGMENT1,
        msib.DESCRIPTION,
        ppf.NATIONAL_IDENTIFIER,
        ppf.FULL_NAME,
        ppf.ATTRIBUTE3,
        (SELECT count(FILE_NAME) FROM KHS.KHS_OKBJ_ORDER_ATTACHMENTS 
        WHERE ORDER_ID = ooh.ORDER_ID) attachment
    FROM
        KHS.KHS_OKBJ_ORDER_HEADER ooh,
        PER_PEOPLE_F ppf,
        mtl_system_items_b msib
    WHERE
        ooh.CREATE_BY = ppf.PERSON_ID
        AND ooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        AND ooh.ORDER_STATUS_ID <> 5
        AND ppf.NATIONAL_IDENTIFIER = '$noind'
        ORDER BY ooh.ORDER_ID DESC
        ");

        return $query->result_array();
    }

    public function getListDataOrderAdmin($noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
            ooh.*
            ,msib.segment1, msib.description
            ,ppf.national_identifier, ppf.full_name, ppf.attribute3
            ,(SELECT COUNT (file_name)
            FROM khs.khs_okbj_order_attachments
            WHERE order_id = ooh.order_id
            ) attachment
            from
            khs.khs_okbj_order_header ooh
            ,khs.khs_okbj_approve_hir koah
            ,per_people_f ppf
            ,mtl_system_items_b msib
            ,(select
            koah1.APPROVER
            from
            khs.khs_okbj_approve_hir koah1
            ,per_people_f ppf1
            where
            koah1.PERSON_ID = ppf1.PERSON_ID
            and koah1.APPROVER_LEVEL = 3
            and ppf1.NATIONAL_IDENTIFIER = '$noind'
            ) kasie  
            where
            ooh.CREATE_BY = koah.PERSON_ID
            and koah.APPROVER = kasie.APPROVER
            and ooh.inventory_item_id = msib.inventory_item_id
            and ooh.DESTINATION_ORGANIZATION_ID = msib.ORGANIZATION_ID
            and ooh.order_status_id <> 5
            and ooh.CREATE_BY = ppf.PERSON_ID");

        return $query->result_array();
    }

    public function getPersonId($noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT ppf.ATTRIBUTE3,
        ppf.PERSON_ID  --ini yang disimpan di database order
        ,ppf.FULL_NAME
        from
        PER_PEOPLE_F ppf 
        where
        ppf.NATIONAL_IDENTIFIER = '$noind' --NIK
        and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'");
        return $query->result_array();
    }

    public function setApproverItem($noind, $itemCode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        ppf.PERSON_ID ,
        ppf.FULL_NAME ,
        koah.APPROVER_LEVEL ,
        koal.DESCRIPTION ,
        CASE
            WHEN koah.APPROVER_LEVEL = 7 THEN msib.ATTRIBUTE24
            ELSE TO_CHAR(koah.APPROVER)
        END approver ,
        CASE 
		    WHEN KOAH.APPROVER_LEVEL = 7 THEN (
		    SELECT 
			    PPFPENGELOLA.NATIONAL_IDENTIFIER
		    FROM 
			    PER_PEOPLE_F ppfpengelola
		    WHERE
			    msib.ATTRIBUTE24 = ppfpengelola.PERSON_ID
			    AND ppfpengelola.CURRENT_EMPLOYEE_FLAG = 'Y'
		    )
		    ELSE PPFAPPROVE.NATIONAL_IDENTIFIER
		END approver_noind,
        CASE
            WHEN koah.APPROVER_LEVEL = 7 THEN (
            SELECT
                ppfpengelola.FULL_NAME
            FROM
                PER_PEOPLE_F ppfpengelola
            WHERE
                msib.ATTRIBUTE24 = ppfpengelola.PERSON_ID
                AND ppfpengelola.CURRENT_EMPLOYEE_FLAG = 'Y')
            ELSE ppfapprove.FULL_NAME
        END APPROVER_NAME
    FROM
        khs.khs_okbj_approve_hir koah ,
        PER_PEOPLE_F ppf ,
        PER_PEOPLE_F ppfapprove ,
        khs.khs_okbj_approver_level koal ,
        mtl_system_items_b msib
    WHERE
        ppf.PERSON_ID = koah.PERSON_ID
        AND ppf.PERSON_ID = '$noind'
        --NIK
        AND ppf.CURRENT_EMPLOYEE_FLAG = 'Y'
        AND ppfapprove.PERSON_ID(+) = koah.APPROVER
        AND ppfapprove.CURRENT_EMPLOYEE_FLAG(+) = 'Y'
        AND koah.APPROVER_LEVEL = koal.LEVEL_NUMBER
        --and koah.APPROVER_LEVEL > 7
        AND koah.APPROVER_LEVEL != 9
        AND koah.APPROVER_LEVEL <= msib.ATTRIBUTE25 + 1
        AND msib.ORGANIZATION_ID = 81
        AND msib.PURCHASING_ENABLED_FLAG = 'Y'
        AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
        AND msib.INVENTORY_ITEM_ID = '$itemCode'
        --kode barang
    
        ORDER BY 3");

        return $query->result_array();
    }

    public function setApproverItemUrgent($noind, $itemCode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        ppf.PERSON_ID
        ,ppf.FULL_NAME
        ,koah.APPROVER_LEVEL
        ,koal.DESCRIPTION
        ,case when koah.APPROVER_LEVEL = 7 then msib.ATTRIBUTE24 else to_char(koah.APPROVER) end approver
        ,CASE 
		    WHEN KOAH.APPROVER_LEVEL = 7 THEN (
		    SELECT 
			    PPFPENGELOLA.NATIONAL_IDENTIFIER
		    FROM 
			    PER_PEOPLE_F ppfpengelola
		    WHERE
			    msib.ATTRIBUTE24 = ppfpengelola.PERSON_ID
			    AND ppfpengelola.CURRENT_EMPLOYEE_FLAG = 'Y'
		    )
		    ELSE PPFAPPROVE.NATIONAL_IDENTIFIER
		END approver_noind,
        case 
            when koah.APPROVER_LEVEL = 7 then 
                (select ppfpengelola.FULL_NAME
                from PER_PEOPLE_F ppfpengelola
                where 
                msib.ATTRIBUTE24 = ppfpengelola.PERSON_ID
                and ppfpengelola.CURRENT_EMPLOYEE_FLAG = 'Y')
            else ppfapprove.FULL_NAME
            end APPROVER_NAME
        from
        khs.khs_okbj_approve_hir koah
        ,PER_PEOPLE_F ppf
        ,PER_PEOPLE_F ppfapprove
        ,khs.khs_okbj_approver_level koal
        ,mtl_system_items_b msib
        where
        ppf.PERSON_ID = koah.PERSON_ID
        and ppf.PERSON_ID = '$noind' --NIK
        and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'
        and ppfapprove.PERSON_ID(+) = koah.APPROVER
        and ppfapprove.CURRENT_EMPLOYEE_FLAG(+) = 'Y'
        and koah.APPROVER_LEVEL = koal.LEVEL_NUMBER
        --and koah.APPROVER_LEVEL > 7
        and koah.APPROVER_LEVEL <= msib.ATTRIBUTE25+1
        and msib.ORGANIZATION_ID = 81
        and msib.PURCHASING_ENABLED_FLAG = 'Y'
        and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
        and msib.INVENTORY_ITEM_ID = '$itemCode' --kode barang
        order by 3");

        return $query->result_array();
    }

    public function ApproveOrder($approve)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->insert('KHS.KHS_OKBJ_ORDER_APPROVAL', $approve);
    }

    public function getDestination($itemkode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        case when msib.INVENTORY_ITEM_FLAG = 'Y'
            then 'INVENTORY'
            else 'EXPENSE'
            end destination_type_code
        ,flv.description
        ,case when msib.INVENTORY_ITEM_FLAG = 'Y'
            then 'Y'
            else 'N'
            end subinv   
        from
        mtl_system_items_b msib
        ,fnd_lookup_values flv
        where
        msib.INVENTORY_ITEM_ID = '$itemkode'
        and msib.item_type = flv.lookup_code
        and flv.lookup_type = 'ITEM_TYPE'
        and msib.ORGANIZATION_ID = 81");

        return $query->result_array();
    }

    public function getOrganization($itemkode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT ood.organization_name, ood.organization_code io, ood.organization_id FROM mtl_system_items_b msib, org_organization_definitions ood WHERE msib.inventory_item_id = '$itemkode' AND ood.organization_id = msib.organization_id AND msib.organization_id <> 81
        ORDER BY io");

        return $query->result_array();
    }

    public function getLocation()
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT  hla.location_code loc, hla.description, hla.location_id, br.branch
        FROM hr_locations_all hla, (select SUBSTR(hou.attribute30, 1, 2) branch, hou.location_id from hr_all_organization_units hou where hou.attribute30 is not null) br
           WHERE hla.description IS NULL AND hla.inactive_date IS NULL
         AND hla.location_id = br.location_id (+)
    ORDER BY loc");

        return $query->result_array();
    }

    public function getSubinventory($organization)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                                msi.SECONDARY_INVENTORY_NAME subinv, msi.description
                                from
                                mtl_secondary_inventories msi
                                where
                                msi.ORGANIZATION_ID = '$organization'
                                ORDER BY subinv");

        return $query->result_array();
    }

    public function getHistoryOrder($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query  = $oracle->query("SELECT
                                    kooh.*
                                    ,kooa.*
                                    ,ppf.FULL_NAME
                                    ,ppf.NATIONAL_IDENTIFIER 
                                FROM 
                                    KHS.KHS_OKBJ_ORDER_APPROVAL kooa
                                    ,KHS.KHS_OKBJ_ORDER_HEADER kooh
                                    ,PER_PEOPLE_F ppf
                                WHERE kooa.ORDER_ID = '$order_id'
                                AND kooa.APPROVER_ID = ppf.PERSON_ID
                                AND kooa.ORDER_ID = kooh.ORDER_ID
                                ORDER BY kooa.APPROVER_TYPE ASC
                                ");

        return $query->result_array();
    }

    public function getAtasan($string)
    {
        $oracle = $this->load->database('oracle', true);
        $query  = $oracle->query("SELECT ppf.ATTRIBUTE3,
                            ppf.PERSON_ID
                            ,ppf.FULL_NAME
                            ,ppf.NATIONAL_IDENTIFIER
                            from
                            PER_PEOPLE_F ppf 
                            where
                            ppf.NATIONAL_IDENTIFIER LIKE '%$string%' or ppf.FULL_NAME LIKE '%$string%'
                            and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'");

        return $query->result_array();
    }

    public function setAtasan($atasan)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->insert("KHS.KHS_OKBJ_APPROVE_HIR",$atasan);
    }

    public function getRequsterAdmin($noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query =  $oracle->query("SELECT
        ppf.PERSON_ID
        ,ppf.FULL_NAME
        ,koah.APPROVER_LEVEL
        ,koal.DESCRIPTION
        ,koah.APPROVER
        ,ppfapprove.FULL_NAME
        from
        khs.khs_okbj_approve_hir koah
        ,PER_PEOPLE_F ppf
        ,PER_PEOPLE_F ppfapprove
        ,khs.khs_okbj_approver_level koal
        where
        ppf.PERSON_ID = koah.PERSON_ID
        and ppf.NATIONAL_IDENTIFIER = '$noind' --NIK
        and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'
        and ppfapprove.PERSON_ID = koah.APPROVER
        and ppfapprove.CURRENT_EMPLOYEE_FLAG = 'Y'
        and koah.APPROVER_LEVEL = koal.LEVEL_NUMBER");

        return $query->result_array();
    }

    public function getNoind($cond)
    {
        $oracle = $this->load->database('oracle', true);
        $query =  $oracle->query("SELECT ppf.NATIONAL_IDENTIFIER, ppf.PERSON_ID FROM PER_PEOPLE_F ppf $cond");
        
        return $query->result_array();
    }

    public function uploadFiles($upload)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('CREATION_DATE',"SYSDATE",false);
        $oracle->insert("KHS.KHS_OKBJ_ORDER_ATTACHMENTS",$upload);
    }

    public function getApprover($person_id, $level)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                    oah.*, ppf.FULL_NAME
                FROM
                    KHS.KHS_OKBJ_APPROVE_HIR oah,
                    PER_PEOPLE_F ppf
                WHERE
                    oah.PERSON_ID = '$person_id'
                    $level
                    AND oah.APPROVER = ppf.PERSON_ID");

        return $query->result_array();
    }

    public function setDeactiveApprover($approver,$person_id)
    {
        $cond = array('ACTIVE_FLAG' => 'N');
        $oracle = $this->load->database('oracle', true);
        $oracle->where('APPROVER != ', "$approver");
        $oracle->where('APPROVER_LEVEL', "5");
        $oracle->where('PERSON_ID', $person_id);
        $oracle->update('KHS.KHS_OKBJ_APPROVE_HIR', $cond);
    }
    
    public function setActiveApprover($approver,$person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $cond = array('ACTIVE_FLAG' => 'Y');
        $oracle->where('APPROVER = ', "$approver");
        $oracle->where('PERSON_ID', $person_id);
        $oracle->update('KHS.KHS_OKBJ_APPROVE_HIR', $cond);
    }

    public function getRequestor($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                            oah.*, ppf.FULL_NAME, ppf.NATIONAL_IDENTIFIER
                        FROM
                            KHS.KHS_OKBJ_APPROVE_HIR oah,
                            PER_PEOPLE_F ppf
                        WHERE
                            oah.APPROVER_LEVEL = '3'
                            AND oah.PERSON_ID = '$person_id'
                            AND oah.APPROVER = ppf.PERSON_ID");

        return $query->result_array();
    }

    public function removeRequestor($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('APPROVER_LEVEL', "3");
        $oracle->where('PERSON_ID', "$person_id");
        $oracle->delete('KHS.KHS_OKBJ_APPROVE_HIR');
    }

    public function setRequestor($data)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->insert('KHS.KHS_OKBJ_APPROVE_HIR', $data);
    }

    public function getInfoOrderPR($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                    prha.SEGMENT1 PR_NUM
                    ,prha.CREATION_DATE PR_CREATION_DATE
                    ,prla.LINE_NUM PR_LINE_NUM
                    ,pha.SEGMENT1 PO_NUM
                    ,pha.CREATION_DATE PO_CREATION_DATE
                    ,pla.LINE_NUM PO_LINE_NUM
                    ,plla.PROMISED_DATE PO_PROMISED_DATE
                    ,rsh.RECEIPT_NUM NOMOR_RECEIPT
                    ,sum(rt.QUANTITY) QTY_RECEIPT
                    ,rt.UOM_CODE
                    from
                    po_requisition_lines_all prla
                    ,po_requisition_headers_all prha
                    ,PO_REQ_DISTRIBUTIONS_ALL prda
                    ,PO_DISTRIBUTIONS_ALL pda
                    ,po_headers_all pha
                    ,po_lines_all pla
                    ,PO_LINE_LOCATIONS_ALL plla
                    ,RCV_TRANSACTIONS rt
                    ,RCV_SHIPMENT_HEADERS rsh
                    ,khs.khs_okbj_order_header kooh
                    where
                    prla.REQUISITION_HEADER_ID = prha.REQUISITION_HEADER_ID
                    and prla.REQUISITION_LINE_ID = prda.REQUISITION_LINE_ID(+)
                    and prda.DISTRIBUTION_ID = pda.REQ_DISTRIBUTION_ID(+)
                    and pda.PO_HEADER_ID = pha.PO_HEADER_ID(+)
                    and pda.PO_LINE_ID = pla.PO_LINE_ID(+)
                    and pla.PO_LINE_ID = plla.PO_LINE_ID(+)
                    and plla.LINE_LOCATION_ID = rt.PO_LINE_LOCATION_ID(+)
                    and rt.SHIPMENT_HEADER_ID = rsh.SHIPMENT_HEADER_ID(+)
                    and rt.transaction_type(+) = 'RECEIVE'
                    and prha.INTERFACE_SOURCE_CODE IN ('IMPORT_EXP', 'IMPORT_INV')
                    and prla.ATTRIBUTE9 = to_char(kooh.ORDER_ID) 
                    and prha.ATTRIBUTE4 = nvl(kooh.PRE_REQ_ID, prha.ATTRIBUTE4)
                    and kooh.ORDER_ID = '$order_id' --isi dengan order_id
                    group by
                    prha.SEGMENT1 
                    ,prha.CREATION_DATE 
                    ,prla.LINE_NUM 
                    ,pha.SEGMENT1 
                    ,pha.CREATION_DATE 
                    ,pla.LINE_NUM 
                    ,plla.PROMISED_DATE 
                    ,rsh.RECEIPT_NUM
                    ,rt.UOM_CODE");

        return $query->result_array();
    }

    public function getNamaUser($user)
	{
		$personalia = $this->load->database("personalia", true);
		$query= $personalia->query("select
									*
									from
									hrd_khs.tpribadi
									where
									noind = '$user'
									");
		return $query->result_array();
    }
    
    public function sementara($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT ooh.*,ooa.judgement FROM khs.khs_okbj_order_header ooh, khs.KHS_OKBJ_ORDER_APPROVAL ooa 
        WHERE ooh.ORDER_ID = '$order_id'
        AND	 ooh.ORDER_ID = ooa.ORDER_ID
        and ROWNUM = 1
        -- AND ooa.JUDGEMENT IS NOT NULL
        -- AND ooa.JUDGEMENT_DATE IS NOT NULL
        ORDER BY ooa.JUDGEMENT_DATE DESC");

        return $query->result_array();
    }

    public function CancelOrder($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('ORDER_ID',$order_id);
        $oracle->update('KHS.KHS_OKBJ_ORDER_HEADER',array('ORDER_STATUS_ID' => 5,));
    }
}