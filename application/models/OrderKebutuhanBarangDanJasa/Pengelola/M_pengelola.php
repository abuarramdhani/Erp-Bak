<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_pengelola extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function checkOrder($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('APPROVER_ID', $person_id);
        $oracle->where('APPROVER_TYPE', 7);
        $query = $oracle->get('KHS.KHS_OKBJ_ORDER_APPROVAL');

        return $query->result_array();
    }

    public function checkOrderSiapDikelola($orderid)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT APPROVER_TYPE,JUDGEMENT FROM KHS.KHS_OKBJ_ORDER_APPROVAL
                                where ORDER_ID = '$orderid'
                                AND JUDGEMENT = 'A'
                                AND APPROVER_TYPE = (select MAX(APPROVER_TYPE) FROM KHS.KHS_OKBJ_ORDER_APPROVAL
                                WHERE ORDER_ID = '$orderid')");

        return $query->result_array();
    }

    public function TindakanPengelola($orderid, $orderClass)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('ORDER_CLASS', $orderClass);
        $oracle->where('ORDER_ID', $orderid);
        $oracle->update('KHS.KHS_OKBJ_ORDER_HEADER');
    }

    public function orderBeli($orderid)
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
                                AND ooh.ORDER_ID = '$orderid'
                                AND ooh.ORDER_CLASS = '1'
                                AND ooh.PRE_REQ_ID is null");

        return $query->result_array();
    }

    public function getOrderOpenedList($orderid)
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
                                AND ooh.ORDER_ID = '$orderid'
                                AND ooh.ORDER_CLASS is null");

        return $query->result_array();
    }

    public function PengelolaCreatePR($order, $nbd)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('NEED_BY_DATE',"TO_DATE('$nbd','YYYY-MM-DD')",false);
        $oracle->set('PRE_REQ_DATE',"SYSDATE",false);
        $oracle->insert('KHS.KHS_OKBJ_PRE_REQ_HEADER', $order);
        $pre_req_id = $oracle->query("SELECT MAX(PRE_REQ_ID) PRE_REQ_ID FROM KHS.KHS_OKBJ_PRE_REQ_HEADER");

        return $pre_req_id->result_array();
    }

    public function updateOrderClass($orderid, $order)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('ORDER_ID', $orderid);
        $oracle->update('KHS.KHS_OKBJ_ORDER_HEADER', $order);
    }

    public function ApproverPR($noind,$itemKode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("select
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
            ,mtl_system_items_b msib
            where
            ppf.PERSON_ID = koah.PERSON_ID
            and ppf.NATIONAL_IDENTIFIER = '$noind'
            and ppf.CURRENT_EMPLOYEE_FLAG = 'Y'
            and ppfapprove.PERSON_ID = koah.APPROVER
            and ppfapprove.CURRENT_EMPLOYEE_FLAG = 'Y'
            and koah.APPROVER_LEVEL = koal.LEVEL_NUMBER
            and koah.APPROVER_LEVEL <= msib.ATTRIBUTE25
            and msib.ORGANIZATION_ID = 81
            and msib.PURCHASING_ENABLED_FLAG = 'Y'
            and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
            and msib.INVENTORY_ITEM_ID = '$itemKode'
            ORDER BY APPROVER_LEVEL ASC");

            return $query->result_array();
    }

    public function setApproverPR($appPR)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->insert('KHS.KHS_OKBJ_PRE_REQ_APPROVAL', $appPR);
    }

    public function getInterfaceSourceCode($itemKode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        case when msib.INVENTORY_ITEM_FLAG = 'N' then 'IMPORT_EXP' else 'IMPORT_INV' end INTERFACE_SOURCE_CODE
        from
        mtl_system_items_b msib
        where
        msib.INVENTORY_ITEM_ID = $itemKode --isi dengan inventory item id
        and msib.ORGANIZATION_ID = 81");

        return $query->result_array();
    }

    public function getCategoryId($itemKode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
            mic.CATEGORY_ID
            from
            mtl_item_categories mic
            ,mtl_category_sets_tl mcst
            where
            mic.CATEGORY_SET_ID = mcst.CATEGORY_SET_ID
            and mic.ORGANIZATION_ID = 81
            and mcst.CATEGORY_SET_NAME = 'KHS PERSEDIAAN INVENTORY'
            and mic.INVENTORY_ITEM_ID = $itemKode  --isi dengan inventory item id");

        return $query->result_array();
    }

    public function getChargeAccountId($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT distinct
        case when msib.ITEM_TYPE in ('3086', '3085') then
            msib.EXPENSE_ACCOUNT
        when msib.INVENTORY_ITEM_FLAG = 'Y' then 
            (select
            msi.MATERIAL_ACCOUNT
            from
            mtl_secondary_inventories msi
            where
            msi.SECONDARY_INVENTORY_NAME = kooh.DESTINATION_SUBINVENTORY)
        else
            nvl((SELECT 
            gcc2.CODE_COMBINATION_ID
            FROM 
            GL_CODE_COMBINATIONS gcc
            ,per_people_f ppf
            ,KHS_HRD_TPRIBADI tp
            ,KHS_HRD_TSEKSI ts
            ,KHS_HRD_TLOKASI_KERJA tk
            ,GL_CODE_COMBINATIONS gcc2
            WHERE 
            msib.EXPENSE_ACCOUNT = gcc.CODE_COMBINATION_ID
            and kooh.CREATE_BY = ppf.PERSON_ID
            and ppf.NATIONAL_IDENTIFIER = tp.NOIND
            and tp.KODESIE = ts.KODESIE
            and tp.LOKASI_KERJA = tk.ID_
            and gcc.SEGMENT1 = gcc2.SEGMENT1
            and tk.BRANCH = gcc2.SEGMENT2
            and gcc.SEGMENT3 = gcc2.SEGMENT3
            and to_char(ts.COST_CENTER) = gcc2.SEGMENT4
            and gcc.SEGMENT5 = gcc2.SEGMENT5
            and gcc.SEGMENT6 = gcc2.SEGMENT6
            and gcc.SEGMENT7 = gcc2.SEGMENT7), msib.EXPENSE_ACCOUNT)   
        end CHARGE_ACCOUNT_ID
        from
        khs.khs_okbj_order_header kooh
        ,mtl_system_items_b msib
        where
        kooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        and msib.ORGANIZATION_ID = kooh.DESTINATION_ORGANIZATION_ID
        and kooh.ORDER_ID = $order_id");

        return $query->result_array();
    }

    public function listRequisition($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT
        oprh.*,
        msib.SEGMENT1,
        msib.DESCRIPTION,
        ppf.NATIONAL_IDENTIFIER,
        ppf.FULL_NAME,
        ppf.ATTRIBUTE3
    FROM
        KHS.KHS_OKBJ_PRE_REQ_HEADER oprh,
        PER_PEOPLE_F ppf,
        mtl_system_items_b msib
    WHERE
        oprh.REQUESTOR_ID = ppf.PERSON_ID
        AND oprh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        AND ppf.PERSON_ID = '$person_id'
        ORDER BY oprh.PRE_REQ_ID DESC");

        return $query->result_array();
    }

    public function getHistoryRequisition($pre_req_id)
    {

        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                                    opra.*
                                    ,ppf.FULL_NAME
                                    ,ppf.NATIONAL_IDENTIFIER 
                                FROM 
                                    KHS.KHS_OKBJ_PRE_REQ_APPROVAL opra 
                                    ,PER_PEOPLE_F ppf
                                WHERE PRE_REQ_ID = '$pre_req_id'
                                AND opra.APPROVER_ID = ppf.PERSON_ID
                                ORDER BY opra.APPROVER_TYPE ASC");

        return $query->result_array();
    }

    public function PO_Interdace_all($order)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->insert('PO_REQUISITIONS_INTERFACE_ALL',$order);
    }

    /**
     * @param   string  ENUM $status 'SUSULAN', 'URGENT', 'NORMAL' or 'ALL'
     * @return  int     Outstand order count
     */
    public function getUnapprovedOrderCount($no_induk, $status)
    {
        return (int) $this->oracle
            ->query(
                "SELECT
                    APPS.KHS_OUTSTAND_OKBJ_PENGELOL_TOT (?, ?) AS \"count\"
                FROM
                    DUAL",
                [
                    $no_induk,
                    $status,
                ]
            )
            ->row()
            ->count;
    }

    /**
     * @param   string  ENUM $status 'SUSULAN', 'URGENT', 'NORMAL' or 'ALL'
     * @return  int     Judged order count
     */
    public function getJudgedOrderCount($no_induk, $status)
    {
        return (int) $this->oracle
            ->query(
                "SELECT
                    APPS.KHS_JUDGED_OKBJ_PENGELOL_TOT (?, ?) AS \"count\"
                FROM
                    DUAL",
                [
                    $no_induk,
                    $status,
                ]
            )
            ->row()
            ->count;
    }
}