<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_approver extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function getListDataOrder()
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->get('KHS.KHS_OKBJ_ORDER_HEADER');

        return $query->result_array();
    }

    public function getListDataOrderCondition($and)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * From KHS.KHS_OKBJ_ORDER_HEADER where $and");

        return $query->result_array();
    }

    public function ApproveOrder($orderid, $person_id, $approve, $type)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('JUDGEMENT_DATE',"SYSDATE",false);
        $oracle->where('APPROVER_ID', $person_id);
        $oracle->where('APPROVER_TYPE', $type);
        $oracle->where('ORDER_ID', $orderid);
        $oracle->update('KHS.KHS_OKBJ_ORDER_APPROVAL', $approve);
    }

    public function ApproveOrderKaDep($orderid, $person_id, $approve)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('JUDGEMENT_DATE',"SYSDATE",false);
        $oracle->where('APPROVER_ID', $person_id);
        $oracle->where('ORDER_ID', $orderid);
        $oracle->update('KHS.KHS_OKBJ_ORDER_APPROVAL', $approve);
    }

    public function ApproveOrderPR($pre_req_id, $person_id, $approve)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('JUDGEMENT_DATE',"SYSDATE",false);
        $oracle->where('APPROVER_ID', $person_id);
        $oracle->where('PRE_REQ_ID', $pre_req_id);
        $oracle->update('KHS.KHS_OKBJ_PRE_REQ_APPROVAL', $approve);
    }

    public function checkOrder($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        APPROVER_TYPE
        ,APPROVER_ID
        FROM
        (SELECT 
           ooa.APPROVER_TYPE
           ,ooa.APPROVER_ID
           FROM
           khs.KHS_OKBJ_ORDER_HEADER ooh
           ,khs.KHS_OKBJ_ORDER_APPROVAL ooa
           WHERE
           ooh.ORDER_ID = '$order_id'
           AND ooh.ORDER_ID = ooa.ORDER_ID
           AND ooa.JUDGEMENT is null
           AND
           (      
              (
               SELECT
               ooa1.JUDGEMENT
               FROM
               khs.KHS_OKBJ_ORDER_HEADER ooh1
               ,khs.KHS_OKBJ_ORDER_APPROVAL ooa1
               WHERE
               ooh1.ORDER_ID = ooa1.ORDER_ID
               and ooh1.APPROVE_LEVEL_POS = ooa1.APPROVER_TYPE
               and ooh1.ORDER_ID = '$order_id'
               ) = 'A'
               OR
               (
               SELECT
               ooa1.JUDGEMENT
               FROM
               khs.KHS_OKBJ_ORDER_HEADER ooh1
               ,khs.KHS_OKBJ_ORDER_APPROVAL ooa1
               WHERE
               ooh1.ORDER_ID = ooa1.ORDER_ID
               and ooh1.APPROVE_LEVEL_POS = ooa1.APPROVER_TYPE
               and ooh1.ORDER_ID = '$order_id'
               ) is null
           ) 
           ORDER BY ooa.APPROVER_TYPE ASC)   
        WHERE
        ROWNUM=1");

        return $query->result_array();
    }

    public function checkOrderPR($approver_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM 
                                    KHS.KHS_OKBJ_PRE_REQ_APPROVAL
                                WHERE APPROVER_ID ='$approver_id' 
                                AND JUDGEMENT IS NULL");

        return $query->result_array();
    }

    public function getOrderToApprove($orderid)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT
        ooh.*,
        msib.SEGMENT1,
        msib.DESCRIPTION,
        msib.ALLOW_ITEM_DESC_UPDATE_FLAG ALLOW_DESC,
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
        ooh.REQUESTER = ppf.PERSON_ID
        AND ooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        AND ooh.ORDER_ID = '$orderid'");

        return $query->result_array();
    }

    public function getOrderToApprove1($orderid)
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
        ooh.REQUESTER = ppf.PERSON_ID
        AND ooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        AND ooh.ORDER_ID = '$orderid'");

        return $query->result_array();
    }

    public function checkApproval($orderid, $approverType)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('APPROVER_TYPE',$approverType);
        $oracle->where('ORDER_ID',$orderid);
        $query = $oracle->get('KHS.KHS_OKBJ_ORDER_APPROVAL');

        return $query->result_array();
    }

    public function checkApprovalPR($orderid, $approverType)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('APPROVER_TYPE',$approverType);
        $oracle->where('PRE_REQ_ID',$orderid);
        $query = $oracle->get('KHS.KHS_OKBJ_PRE_REQ_APPROVAL');

        return $query->result_array();
    }

    public function checkPositionApprover($orderid,$person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query =$oracle->query("SELECT APPROVER_TYPE from KHS.KHS_OKBJ_ORDER_APPROVAL where ORDER_ID='$orderid' and APPROVER_ID='$person_id' AND JUDGEMENT IS NULL");
        
        return $query->result_array();
    }

    public function checkPositionApproverPR($pre_req_id,$person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query =$oracle->query("SELECT APPROVER_TYPE from KHS.KHS_OKBJ_PRE_REQ_APPROVAL where PRE_REQ_ID='$pre_req_id' and APPROVER_ID='$person_id'");
        
        return $query->result_array();
    }

    public function updatePosOrder($orderid,$orderPos)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('ORDER_ID',$orderid);
        $oracle->update('KHS.KHS_OKBJ_ORDER_HEADER', $orderPos);
    }

    public function updatePosOrderPR($pre_req_id,$orderPos)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('PRE_REQ_ID',$pre_req_id);
        $oracle->update('KHS.KHS_OKBJ_PRE_REQ_HEADER', $orderPos);
    }

    public function checkFinishOrder($orderid)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT APPROVER_ID from KHS.KHS_OKBJ_ORDER_APPROVAL
                                    WHERE APPROVER_TYPE = (select MAX(APPROVER_TYPE) from KHS.KHS_OKBJ_ORDER_APPROVAL where ORDER_ID = '$orderid') AND ORDER_ID = '$orderid'");
        return $query->result_array();
    }

    public function checkFinishOrderPR($pre_req_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT APPROVER_ID from KHS.KHS_OKBJ_PRE_REQ_APPROVAL
                                    WHERE APPROVER_TYPE = (select MAX(APPROVER_TYPE) from KHS.KHS_OKBJ_PRE_REQ_APPROVAL where PRE_REQ_ID = '$pre_req_id')");
        return $query->result_array();
    }

    public function getOrderToApprovePR($orderid)
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
        oprh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
        AND oprh.PRE_REQ_ID = '$orderid'
        AND ppf.PERSON_ID = oprh.REQUESTOR_ID");

        return $query->result_array();
    }

    public function getPreReqOrdertoInterface($pre_req_id)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('PRE_REQ_ID',$pre_req_id);
        $query = $oracle->get('KHS.KHS_OKBJ_PRE_REQ_HEADER');

        return $query->result_array();
    }

    public function insertPo_Requisitions_Interface_all($orderPR, $headerAtribut1, $headerAtribut2)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('HEADER_ATTRIBUTE1',"to_char(to_date('$headerAtribut1', 'YYYY/MM/DD hh24:mi:ss'), 'YYYY/MM/DD hh:mm:ss')",false);
        $oracle->set('HEADER_ATTRIBUTE2',"to_char(to_date('$headerAtribut2', 'YYYY/MM/DD hh24:mi:ss'), 'YYYY/MM/DD hh:mm:ss')",false);
        $oracle->insert('PO_REQUISITIONS_INTERFACE_ALL', $orderPR);
        // print_r($oracle->last_query());
    }

    public function getKeterangan($pre_req_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                                    kooh.ORDER_PURPOSE,
                                    ppf.ATTRIBUTE3
                                FROM
                                    KHS.KHS_OKBJ_ORDER_HEADER kooh,
                                    PER_PEOPLE_F ppf
                                WHERE
                                    PRE_REQ_ID = '$pre_req_id'
                                    AND ppf.PERSON_ID = kooh.CREATE_BY");
        return $query->result_array();
    }

    public function getAllApprover($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                            *
                        FROM
                            KHS.KHS_OKBJ_ORDER_APPROVAL
                        WHERE
                            ORDER_ID = '$order_id'
                        ORDER BY
                            APPROVER_TYPE ASC
                ");
        return $query->result_array();
    }

    public function getDetailOrderNormalTotal($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                DISTINCT ooa.ORDER_ID,
                ooa.APPROVER_ID,
                ooa.JUDGEMENT
            FROM
                KHS.KHS_OKBJ_ORDER_APPROVAL ooa,
                KHS.KHS_OKBJ_ORDER_HEADER ooh
            WHERE
                ooa.APPROVER_ID = '$person_id'
                AND ooa.ORDER_ID = ooh.ORDER_ID
                AND ooh.URGENT_FLAG = 'N'
                AND ooh.IS_SUSULAN = 'N'
                AND ooh.ORDER_STATUS_ID <> 4");
        return $query->result_array();
        
    }
    public function getDetailOrderUrgentTotal($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                DISTINCT ooa.ORDER_ID,
                ooa.APPROVER_ID,
                ooa.JUDGEMENT
            FROM
                KHS.KHS_OKBJ_ORDER_APPROVAL ooa,
                KHS.KHS_OKBJ_ORDER_HEADER ooh
            WHERE
                ooa.APPROVER_ID = '$person_id'
                AND ooa.ORDER_ID = ooh.ORDER_ID
                AND ooh.URGENT_FLAG = 'Y'
                AND ooh.IS_SUSULAN = 'N'");
        return $query->result_array();
        
    }

    public function getDetailOrderSusulanTotal($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                DISTINCT ooa.ORDER_ID,
                ooa.APPROVER_ID,
                ooa.JUDGEMENT
            FROM
                KHS.KHS_OKBJ_ORDER_APPROVAL ooa,
                KHS.KHS_OKBJ_ORDER_HEADER ooh
            WHERE
                ooa.APPROVER_ID = '$person_id'
                AND ooa.ORDER_ID = ooh.ORDER_ID
                AND ooh.IS_SUSULAN = 'Y'");
        return $query->result_array();
        
    }

    public function GetActionOrder($person_id, $judgement)
    {

        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                    DISTINCT ooa.ORDER_ID,
                    ooa.APPROVER_ID,
                    ooa.JUDGEMENT
                FROM
                    KHS.KHS_OKBJ_ORDER_APPROVAL ooa,
                    KHS.KHS_OKBJ_ORDER_HEADER ooh
                WHERE
                    ooa.APPROVER_ID = '$person_id'
                    AND ooa.ORDER_ID = ooh.ORDER_ID
                    $judgement");
        return $query->result_array();

    }

    function getStock($itemkode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
            DISTINCT msib.SEGMENT1 item ,
            msib.DESCRIPTION ,
            msib.MINIMUM_ORDER_QUANTITY moq,
            msib.FIXED_LOT_MULTIPLIER flm,
            SUM(moqd.PRIMARY_TRANSACTION_QUANTITY) OVER (PARTITION BY moqd.INVENTORY_ITEM_ID ,
            moqd.ORGANIZATION_ID ,
            moqd.SUBINVENTORY_CODE) onhand ,
            khs_inv_qty_att(moqd.ORGANIZATION_ID,
            moqd.INVENTORY_ITEM_ID,
            moqd.SUBINVENTORY_CODE,
            '',
            '') att ,
            khs_inv_qty_atr(moqd.ORGANIZATION_ID,
            moqd.INVENTORY_ITEM_ID,
            moqd.SUBINVENTORY_CODE,
            '',
            '') atr ,
            moqd.SUBINVENTORY_CODE ,
            mp.ORGANIZATION_CODE
        FROM
            mtl_onhand_quantities_detail moqd ,
            mtl_system_items_b msib ,
            mtl_parameters mp
        WHERE
            msib.ORGANIZATION_ID = moqd.ORGANIZATION_ID(+)
            AND msib.INVENTORY_ITEM_ID = moqd.INVENTORY_ITEM_ID(+)
            AND mp.ORGANIZATION_ID(+) = moqd.ORGANIZATION_ID
            AND msib.SEGMENT1 = NVL('$itemkode', msib.SEGMENT1)
        ORDER BY
            item ,
            moqd.SUBINVENTORY_CODE");

        return $query->result_array();
    }

    public function getStandingPO($itemcode)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT DISTINCT
                PHA.SEGMENT1 PO_NUMBER
                ,PLA.LINE_NUM
                ,plla.PROMISED_DATE
                ,MSIB.DESCRIPTION NAMA_BARANG
                ,SUM(prla.QUANTITY - nvl(PLLA.QUANTITY_RECEIVED,0)) QTY
                ,prha.segment1 pr_number
                ,papf.full_name requestor
            FROM
                po_requisition_headers_all prha
                ,po_requisition_lines_all prla
                ,po_req_distributions_all prda
                ,po_distributions_all pda
                ,po_headers_all pha
                ,po_lines_all pla
                ,po_line_locations_all plla
                ,mtl_system_items_b msib
                ,per_all_people_f papf
            where
                prha.REQUISITION_HEADER_ID = prla.REQUISITION_HEADER_ID
                and prla.ITEM_ID = msib.INVENTORY_ITEM_ID
                and prla.DESTINATION_ORGANIZATION_ID = msib.ORGANIZATION_ID
                and prla.REQUISITION_LINE_ID = prda.REQUISITION_LINE_ID
                and prda.DISTRIBUTION_ID = pda.REQ_DISTRIBUTION_ID(+)
                and pda.PO_LINE_ID = pla.PO_LINE_ID(+)
                and pda.PO_HEADER_ID = pha.PO_HEADER_ID(+)
                and pda.PO_LINE_ID = plla.PO_LINE_ID(+)
                and (plla.CLOSED_CODE <> 'CLOSED' or plla.CLOSED_CODE is null)
                and prla.MODIFIED_BY_AGENT_FLAG is null
                and prla.TO_PERSON_ID = papf.PERSON_ID
                and msib.segment1 = '$itemcode'
        group by
                PHA.SEGMENT1
                ,PLA.LINE_NUM
                ,plla.PROMISED_DATE
                ,MSIB.DESCRIPTION
                ,prha.segment1
                ,papf.full_name            
        ORDER BY PO_NUMBER");

        return $query->result_array();
    }

    public function getAttachment($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->get_where('KHS.KHS_OKBJ_ORDER_ATTACHMENTS',array('ORDER_ID' => $order_id, ));

        return $query->result_array();
    }

    public function getNextApproval($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
        APPROVER_TYPE
        ,APPROVER_ID
        ,NATIONAL_IDENTIFIER
        FROM
        (SELECT 
           ooa.APPROVER_TYPE
           ,ooa.APPROVER_ID
           ,ppf.NATIONAL_IDENTIFIER
           FROM
           khs.KHS_OKBJ_ORDER_HEADER ooh
           ,khs.KHS_OKBJ_ORDER_APPROVAL ooa
           ,PER_PEOPLE_F ppf
           WHERE
           ooh.ORDER_ID = '$order_id'
           AND ooa.APPROVER_ID = ppf.PERSON_ID
           AND ooh.ORDER_ID = ooa.ORDER_ID
           AND ooa.JUDGEMENT is null
           AND
           (      
              (
               SELECT
               ooa1.JUDGEMENT
               FROM
               khs.KHS_OKBJ_ORDER_HEADER ooh1
               ,khs.KHS_OKBJ_ORDER_APPROVAL ooa1
               WHERE
               ooh1.ORDER_ID = ooa1.ORDER_ID
               and ooh1.APPROVE_LEVEL_POS = ooa1.APPROVER_TYPE
               and ooh1.ORDER_ID = '$order_id'
               ) = 'A'
               OR
               (
               SELECT
               ooa1.JUDGEMENT
               FROM
               khs.KHS_OKBJ_ORDER_HEADER ooh1
               ,khs.KHS_OKBJ_ORDER_APPROVAL ooa1
               WHERE
               ooh1.ORDER_ID = ooa1.ORDER_ID
               and ooh1.APPROVE_LEVEL_POS = ooa1.APPROVER_TYPE
               and ooh1.ORDER_ID = '$order_id'
               ) is null
           ) 
           ORDER BY ooa.APPROVER_TYPE ASC)   
        WHERE
        ROWNUM=1");

        return $query->result_array();
    }

    public function checkPositionApproverIni($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query(" SELECT * from KHS.KHS_OKBJ_APPROVE_HIR 
        WHERE APPROVER = '$person_id'");

        return $query->result_array();
    }

    public function UbahApproverOrder($person_id,$order_id,$ubah)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('APPROVER_ID', $person_id);
        $oracle->where('ORDER_ID', $order_id);
        $oracle->update('KHS.KHS_OKBJ_ORDER_APPROVAL', $ubah);
    }

    public function UbahOrderHeader($order_id,$data)
    {
        
        $oracle = $this->load->database('oracle', true);
        $oracle->where('ORDER_ID', $order_id);
        $oracle->update('KHS.KHS_OKBJ_ORDER_HEADER',$data);
    }

    public function getHistoryEditOrder($order_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                        ppf.FULL_NAME ,
                        ooa.APPROVER_ID ,
                        ooa.ITEM_DESCRIPTION_BEFORE ,
                        ooa.ITEM_DESCRIPTION_AFTER ,
                        ooa.QUANTITY_BEFORE ,
                        ooa.QUANTITY_AFTER ,
                        ooh.UOM,
                        ooa.ORDER_PURPOSE_BEFORE ,
                        ooa.ORDER_PURPOSE_AFTER
                    FROM
                        KHS.KHS_OKBJ_ORDER_APPROVAL ooa,
                        KHS.KHS_OKBJ_ORDER_HEADER ooh,
                        PER_PEOPLE_F ppf
                    WHERE
                        ppf.PERSON_ID = ooa.APPROVER_ID
                        AND ooa.ORDER_ID = ooh.ORDER_ID
                        AND ooa.ORDER_ID = '$order_id'");

        return $query->result_array();
    }

    public function getEmail($noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT * FROM KHS.KHS_EMAIL_PEKERJA where NATIONAL_IDENTIFIER='$noind'");

        return $query->result_array();
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
                    APPS.KHS_OUTSTAND_OKBJ_APPROVER_TOT (?, ?) AS \"count\"
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
                    APPS.KHS_JUDGED_OKBJ_APPROVER_TOT (?, ?) AS \"count\"
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

    public function rejectOrderAfterApproved($note, $order_id, $approver_id)
    {
        $query = $this->oracle->query(
            "UPDATE KHS.KHS_OKBJ_ORDER_APPROVAL SET NOTE = '$note', JUDGEMENT = 'R', JUDGEMENT_DATE = SYSDATE WHERE ORDER_ID = $order_id AND APPROVER_ID = $approver_id"
        );
        return $this->oracle->affected_rows();
    }

    public function updateOrderStatusID($order_id)
    {
        $query = $this->oracle->query(
            "UPDATE KHS.KHS_OKBJ_ORDER_HEADER SET ORDER_STATUS_ID = 4 WHERE ORDER_ID = $order_id"
        );
        return $this->oracle->affected_rows();
    }

    
}