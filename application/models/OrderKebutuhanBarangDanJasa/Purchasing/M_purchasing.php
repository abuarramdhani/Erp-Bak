<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_purchasing extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getReleasedOrder()
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $query = $oracle_dev->query("SELECT
                                oprh.*
                                ,ppf.NATIONAL_IDENTIFIER noind
                                ,ppf.full_name creator
                            FROM
                                KHS.KHS_OKBJ_PRE_REQ_HEADER oprh,
                                PER_PEOPLE_F ppf
                            WHERE
                                oprh.CREATED_BY = ppf.person_id
                                AND oprh.APPROVED_FLAG is null
                                AND oprh.APPROVED_BY is null
                                AND oprh.APPROVED_DATE is null");

        return $query->result_array();
    }

    public function updateReleasedOrder($pre_req_id, $order)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->set('APPROVED_DATE',"SYSDATE",false);
        $oracle_dev->where('PRE_REQ_ID', $pre_req_id);
        $oracle_dev->update('KHS.KHS_OKBJ_PRE_REQ_HEADER', $order);
    }

    public function getOrder($pre_req_id)
    {
        $oracle_dev = $this->load->database('oracle_dev', true);
        $oracle_dev->where('PRE_REQ_ID', $pre_req_id);
        $query = $oracle_dev->get('KHS.KHS_OKBJ_ORDER_HEADER');

        return $query->result_array();
    }

    public function getActOrder($person_id,$cond)
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
                    $cond
                    AND oprh.APPROVED_BY = '$person_id'");

        return $query->result_array();
    }
}