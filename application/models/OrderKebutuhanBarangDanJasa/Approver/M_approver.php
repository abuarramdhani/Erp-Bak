<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_approver extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
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

    public function ApproveOrder($orderid, $person_id, $approve)
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
        $query =$oracle->query("SELECT APPROVER_TYPE from KHS.KHS_OKBJ_ORDER_APPROVAL where ORDER_ID='$orderid' and APPROVER_ID='$person_id'");
        
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
                                    WHERE APPROVER_TYPE = (select MAX(APPROVER_TYPE) from KHS.KHS_OKBJ_ORDER_APPROVAL where ORDER_ID = '$orderid')");
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

    public function insertPo_Requisitions_Interface_all($order)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->insert('PO_REQUISITIONS_INTERFACE_ALL', $order);
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
                AND ooh.IS_SUSULAN = 'N'");
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
        $query = $oracle->query("SELECT distinct
                            msib.SEGMENT1 item
                        ,msib.DESCRIPTION
                        ,sum(moqd.PRIMARY_TRANSACTION_QUANTITY) over (partition by moqd.INVENTORY_ITEM_ID
                                                                                    ,moqd.ORGANIZATION_ID
                                                                                    ,moqd.SUBINVENTORY_CODE) onhand
                        ,khs_inv_qty_att(moqd.ORGANIZATION_ID,moqd.INVENTORY_ITEM_ID,moqd.SUBINVENTORY_CODE,'','') att
                        ,khs_inv_qty_atr(moqd.ORGANIZATION_ID,moqd.INVENTORY_ITEM_ID,moqd.SUBINVENTORY_CODE,'','') atr
                        ,moqd.SUBINVENTORY_CODE
                        ,mp.ORGANIZATION_CODE
                    from mtl_onhand_quantities_detail moqd
                        ,mtl_system_items_b msib
                        ,mtl_parameters mp
                    where msib.ORGANIZATION_ID = moqd.ORGANIZATION_ID
                    and msib.INVENTORY_ITEM_ID = moqd.INVENTORY_ITEM_ID
                    and mp.ORGANIZATION_ID = moqd.ORGANIZATION_ID
                    and msib.SEGMENT1 = nvl('$itemkode',msib.SEGMENT1)
                    order by item
                    ,moqd.SUBINVENTORY_CODE");

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

}