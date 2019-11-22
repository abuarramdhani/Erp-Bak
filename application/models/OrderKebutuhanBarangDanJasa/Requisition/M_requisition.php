<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_requisition extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getItem($string)
    {
        $oracle_dev = $this->load->database("oracle_dev", true);
        $query = $oracle_dev->query(
            "SELECT
            msib.INVENTORY_ITEM_ID -- ini yang disimpan di database
            ,msib.SEGMENT1 
            ,msib.DESCRIPTION 
            ,msib.PRIMARY_UNIT_OF_MEASURE PRIMARY_UOM
            ,muomt.UNIT_OF_MEASURE SECONDARY_UOM
            ,NVL(msib.PREPROCESSING_LEAD_TIME, 0) + NVL(msib.FULL_LEAD_TIME, 0) + NVL(msib.POSTPROCESSING_LEAD_TIME, 0) LEAD_TIME
            FROM
                mtl_system_items_b msib
                ,mtl_units_of_measure_tl muomt
            WHERE
                msib.ORGANIZATION_ID = 81
                AND msib.PURCHASING_ENABLED_FLAG = 'Y'
                AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                AND muomt.UOM_CODE(+) = msib.SECONDARY_UOM_CODE
                AND (msib.SEGMENT1 LIKE '$string%'
                OR msib.DESCRIPTION LIKE '$string%')
            ORDER BY
                msib.SEGMENT1 ASC"
        );
        return $query->result_array();
    }

    public function getPengorder($noind)
    {
        $query = $this->db->query("SELECT sec.section_name, sec.department_name FROM er.er_employee_all as emp, er.er_section as sec where emp.section_code=sec.section_code and emp.employee_code='$noind'");
		return $query->result_array();
    }

    // public function saveHeader($head)
    // {
    //     $oracle_dev = $this->load->database('trial', true);
    //     $oracle_dev->insert('t_head', $head);
    //     $last_insert_id = $oracle_dev->insert_id();

    //     return $last_insert_id;
    // }

    public function saveLine($line, $nbd)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->set('NEED_BY_DATE',"TO_DATE('$nbd','YYYY-MM-DD')",false);
        $oracle_dev->set('ORDER_DATE',"SYSDATE",false);
        $oracle_dev->insert('KHS.KHS_OKBJ_ORDER_HEADER', $line);
        $order_id = $oracle_dev->query("SELECT MAX(ORDER_ID) ORDER_ID FROM KHS.KHS_OKBJ_ORDER_HEADER");

        return $order_id->result_array();
    }

    public function getListDataOrder($noind)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT DISTINCT
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
        ORDER BY ooh.ORDER_ID DESC
        ");

        return $query->result_array();
    }

    public function getPersonId($noind)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT ppf.ATTRIBUTE3,
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
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT
        ppf.PERSON_ID
        ,ppf.FULL_NAME
        ,koah.APPROVER_LEVEL
        ,koal.DESCRIPTION
        ,case when koah.APPROVER_LEVEL = 7 then msib.ATTRIBUTE24 else to_char(koah.APPROVER) end approver
        ,case 
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
        and koah.APPROVER_LEVEL <= msib.ATTRIBUTE25
        and msib.ORGANIZATION_ID = 81
        and msib.PURCHASING_ENABLED_FLAG = 'Y'
        and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
        and msib.INVENTORY_ITEM_ID = '$itemCode'
        -- and msib.SEGMENT1 = '$itemCode' --kode barang
        order by 3");

        return $query->result_array();
    }

    public function setApproverItemUrgent($noind, $itemCode)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT
        ppf.PERSON_ID
        ,ppf.FULL_NAME
        ,koah.APPROVER_LEVEL
        ,koal.DESCRIPTION
        ,case when koah.APPROVER_LEVEL = 7 then msib.ATTRIBUTE24 else to_char(koah.APPROVER) end approver
        ,case 
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
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->insert('KHS.KHS_OKBJ_ORDER_APPROVAL', $approve);
    }

    public function getDestination($itemkode)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT distinct prla.DESTINATION_TYPE_CODE from po_requisition_lines_all prla, mtl_system_items_b msib where prla.ITEM_ID = msib.INVENTORY_ITEM_ID and msib.INVENTORY_ITEM_ID = '$itemkode'");

        return $query->result_array();
    }

    public function getOrganization($itemkode)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT DISTINCT ood.organization_name, ood.organization_code io, ood.organization_id FROM mtl_system_items_b msib, org_organization_definitions ood WHERE msib.inventory_item_id = '$itemkode' AND ood.organization_id = msib.organization_id AND msib.organization_id <> 81
        ORDER BY io");

        return $query->result_array();
    }

    public function getLocation()
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT  hla.location_code loc, hla.description, hla.location_id, br.branch
        FROM hr_locations_all hla, (select SUBSTR(hou.attribute30, 1, 2) branch, hou.location_id from hr_all_organization_units hou where hou.attribute30 is not null) br
           WHERE hla.description IS NULL AND hla.inactive_date IS NULL
         AND hla.location_id = br.location_id (+)
    ORDER BY loc");

        return $query->result_array();
    }

    public function getSubinventory($organization)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT
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
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query  = $oracle_dev->query("SELECT
                                    kooa.*
                                    ,ppf.FULL_NAME
                                    ,ppf.NATIONAL_IDENTIFIER 
                                FROM 
                                    KHS.KHS_OKBJ_ORDER_APPROVAL kooa 
                                    ,PER_PEOPLE_F ppf
                                WHERE ORDER_ID = '$order_id'
                                AND kooa.APPROVER_ID = ppf.PERSON_ID
                                ORDER BY kooa.APPROVER_TYPE ASC
                                ");

        return $query->result_array();
    }

    public function getAtasan($string)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query  = $oracle_dev->query("SELECT ppf.ATTRIBUTE3,
                            ppf.PERSON_ID
                            ,ppf.FULL_NAME
                            from
                            PER_PEOPLE_F ppf 
                            where
                            ppf.NATIONAL_IDENTIFIER LIKE '%$string%' or ppf.FULL_NAME LIKE '%$string%'
                            and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'");

        return $query->result_array();
    }

    public function setAtasan($atasan)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->insert("KHS.KHS_OKBJ_APPROVE_HIR",$atasan);
    }

    public function getRequsterAdmin($noind)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query =  $oracle_dev->query("SELECT
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

    public function uploadFiles($upload)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->set('CREATION_DATE',"SYSDATE",false);
        $oracle_dev->insert("KHS.KHS_OKBJ_ORDER_ATTACHMENTS",$upload);
    }

    public function getApprover($person_id, $level)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT
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
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->where('APPROVER != ', "$approver");
        $oracle_dev->where('APPROVER_LEVEL', "5");
        $oracle_dev->where('PERSON_ID', $person_id);
        $oracle_dev->update('KHS.KHS_OKBJ_APPROVE_HIR', $cond);
    }
    
    public function setActiveApprover($approver,$person_id)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $cond = array('ACTIVE_FLAG' => 'Y');
        $oracle_dev->where('APPROVER = ', "$approver");
        $oracle_dev->where('PERSON_ID', $person_id);
        $oracle_dev->update('KHS.KHS_OKBJ_APPROVE_HIR', $cond);
    }

    public function getRequestor($person_id)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT
                            oah.*, ppf.FULL_NAME
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
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->where('APPROVER_LEVEL', "3");
        $oracle_dev->where('PERSON_ID', "$person_id");
        $oracle_dev->delete('KHS.KHS_OKBJ_APPROVE_HIR');
    }

    public function setRequestor($data)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->insert('KHS.KHS_OKBJ_APPROVE_HIR', $data);
    }
}