<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_puller extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
    }

    public function getOrderToPulled($cond)
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
                    AND ooh.ORDER_STATUS_ID = '3'
                    $cond
                    AND ooh.PRE_REQ_ID is null
        ");

        return $query->result_array();
    }

    public function releaseOrder($pre_req)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->set('CREATION_DATE',"SYSDATE",false);
        $oracle_dev->insert('KHS.KHS_OKBJ_PRE_REQ_HEADER', $pre_req);
        $pre_req_id = $oracle_dev->query("SELECT MAX(PRE_REQ_ID) PRE_REQ_ID FROM KHS.KHS_OKBJ_PRE_REQ_HEADER");

        return $pre_req_id->result_array();
    }

    public function updateOrder($orderid, $order)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->where('ORDER_ID', $orderid);
        $oracle_dev->update('KHS.KHS_OKBJ_ORDER_HEADER', $order);
    }

    public function getReleasedOrder($person_id)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT
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
                    AND oprh.CREATED_BY = '$person_id'");

        return $query->result_array();
    }

    public function getDetailReleasedOrder($pre_req_id)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT
                                    DISTINCT ooh.*,
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
                                    AND ooh.PRE_REQ_ID = '$pre_req_id'");
        return $query->result_array();
    }

}