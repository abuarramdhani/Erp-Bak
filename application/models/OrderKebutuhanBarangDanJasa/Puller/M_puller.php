<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_puller extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
    }

    // public function getOrderToPulled($cond)
    // {
    //     $oracle = $this->load->database('oracle', true);
    //     $query = $oracle->query("SELECT
    //         ooh.*,
    //         msib.SEGMENT1,
    //         msib.DESCRIPTION,
    //         ppf.NATIONAL_IDENTIFIER,
    //         ppf.FULL_NAME,
    //         ppf.ATTRIBUTE3,
    //         (SELECT count(FILE_NAME) FROM KHS.KHS_OKBJ_ORDER_ATTACHMENTS 
    //     WHERE ORDER_ID = ooh.ORDER_ID) attachment
    //     FROM
    //         KHS.KHS_OKBJ_ORDER_HEADER ooh,
    //         PER_PEOPLE_F ppf,
    //         mtl_system_items_b msib
    //     WHERE
    //         ooh.CREATE_BY = ppf.PERSON_ID
    //         AND ooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
    //         AND msib.ORGANIZATION_ID = 81
    //         AND ooh.ORDER_STATUS_ID = '3'
    //         $cond
    //         AND ooh.PRE_REQ_ID is null 
    //     ");

    //     return $query->result_array();
    // }

    public function getOrderToPulled($cond, $noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT ooh.*, msib.segment1, msib.description, ppf.national_identifier,
                    ppf.full_name, ppf.attribute3,
                    (SELECT COUNT (file_name)
                    FROM khs.khs_okbj_order_attachments
                    WHERE order_id = ooh.order_id) attachment
            FROM khs.khs_okbj_order_header ooh,
                    per_people_f ppf,
                    mtl_system_items_b msib,
                    per_people_f ppfpuller
            WHERE ooh.requester = ppf.person_id
                AND ooh.inventory_item_id = msib.inventory_item_id
                AND msib.organization_id = 81
                AND ooh.order_status_id = '3'
                $cond
                AND msib.ATTRIBUTE27 = ppfpuller.PERSON_ID
                AND ppfpuller.NATIONAL_IDENTIFIER = '$noind'  -- parameter 
                AND ooh.pre_req_id IS NULL");

        return $query->result_array();
    }

    public function getOrderToReleased($noind)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT              
            sum(ooh.QUANTITY),
            msib.INVENTORY_ITEM_ID,
            msib.SEGMENT1,
            msib.DESCRIPTION
        FROM
            KHS.KHS_OKBJ_ORDER_HEADER ooh,
            mtl_system_items_b msib,
            per_people_f ppfpuller
        WHERE
            ooh.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
            AND msib.ORGANIZATION_ID = 81
            AND msib.ATTRIBUTE27 = ppfpuller.PERSON_ID
            AND ppfpuller.NATIONAL_IDENTIFIER = '$noind'  -- parameter 
            AND ooh.ORDER_STATUS_ID = '3'
            AND ooh.URGENT_FLAG ='N' AND ooh.IS_SUSULAN ='N'
            AND ooh.PRE_REQ_ID is null
        GROUP BY
            msib.INVENTORY_ITEM_ID,
            msib.SEGMENT1,
            msib.DESCRIPTION,
            msib.MINIMUM_ORDER_QUANTITY,
            msib.FIXED_LOT_MULTIPLIER
        HAVING 
            sum(ooh.QUANTITY) >= nvl(msib.MINIMUM_ORDER_QUANTITY,0)
            and MOD(sum(ooh.QUANTITY), nvl(msib.FIXED_LOT_MULTIPLIER,1)) = 0");

        return $query->result_array();
    }

    public function releaseOrder($pre_req)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->set('CREATION_DATE',"SYSDATE",false);
        $oracle->insert('KHS.KHS_OKBJ_PRE_REQ_HEADER', $pre_req);
        $pre_req_id = $oracle->query("SELECT MAX(PRE_REQ_ID) PRE_REQ_ID FROM KHS.KHS_OKBJ_PRE_REQ_HEADER");

        return $pre_req_id->result_array();
    }

    public function updateOrder($orderid, $order)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('ORDER_ID', $orderid);
        $oracle->update('KHS.KHS_OKBJ_ORDER_HEADER', $order);
    }

    public function updateOrderBatch($itemcode, $order)
    {
        $oracle = $this->load->database('oracle', true);
        $oracle->where('IS_SUSULAN', 'N');
        $oracle->where('URGENT_FLAG', 'N');
        $oracle->where('PRE_REQ_ID', null);
        $oracle->where('ORDER_STATUS_ID', '3');
        $oracle->where('INVENTORY_ITEM_ID', $itemcode);
        $oracle->update('KHS.KHS_OKBJ_ORDER_HEADER', $order);
    }

    public function getReleasedOrder($person_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT
                    oprh.* ,
                    ppf.NATIONAL_IDENTIFIER noind ,
                    ppf.full_name creator ,
                    ppf2.FULL_NAME approver
                FROM
                    KHS.KHS_OKBJ_PRE_REQ_HEADER oprh,
                    PER_PEOPLE_F ppf,
                    PER_PEOPLE_F ppf2
                WHERE
                    oprh.CREATED_BY = ppf.person_id
                    AND oprh.APPROVED_BY = ppf2.PERSON_ID(+)
                    AND oprh.CREATED_BY = '$person_id'
                    order by oprh.PRE_REQ_ID DESC");

        return $query->result_array();
    }

    public function getDetailReleasedOrder($pre_req_id)
    {
        $oracle = $this->load->database('oracle', true);
        $query = $oracle->query("SELECT 
            DISTINCT ooh.*, 
            msib.segment1, 
            msib.description,
            ppf.national_identifier, 
            ppf.full_name, 
            ppf.attribute3,
            ppfbuyer.FULL_NAME buyer_name,
            (SELECT COUNT (file_name)
            FROM khs.khs_okbj_order_attachments
            WHERE order_id = ooh.order_id) attachment
        FROM khs.khs_okbj_order_header ooh,
            per_people_f ppf,
            mtl_system_items_b msib,
            per_people_f ppfbuyer
        WHERE ooh.requester = ppf.person_id
        AND ooh.inventory_item_id = msib.inventory_item_id
        AND ooh.DESTINATION_ORGANIZATION_ID = msib.ORGANIZATION_ID
        AND msib.BUYER_ID = ppfbuyer.PERSON_ID
        AND ooh.pre_req_id = '$pre_req_id'");
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
                    APPS.KHS_OUTSTAND_OKBJ_PULLER_TOT (?, ?) AS \"count\"
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
                    APPS.KHS_JUDGED_OKBJ_PULLER_TOT (?, ?) AS \"count\"
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