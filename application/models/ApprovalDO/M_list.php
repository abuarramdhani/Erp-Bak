<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_list extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        
		$this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getDOList()
    {
        $sql = "SELECT DISTINCT wdd.BATCH_ID, wdd.SOURCE_HEADER_NUMBER, kad.status 
                FROM wsh_delivery_details wdd, khs_approval_do kad 
                WHERE to_char(wdd.batch_id) = kad.no_do(+) 
                AND wdd.ORG_ID = 82 
                    AND wdd.ORG_ID = 82
                AND wdd.ORG_ID = 82 
                AND wdd.RELEASED_STATUS = 'S' 
                    AND wdd.RELEASED_STATUS = 'S'
                AND wdd.RELEASED_STATUS = 'S' 
                AND kad.status IS NULL 
                    AND kad.status IS NULL
                AND kad.status IS NULL 
                ORDER BY SOURCE_HEADER_NUMBER";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function createApprovalDO($do_number, $so_number)
    {
        $sql = "INSERT INTO
                    KHS_APPROVAL_DO (no_do, no_so, creation_date)
                VALUES
                    ($do_number, $so_number, SYSDATE)";
        $query = $this->oracle->query($sql);
    }

    public function updateStatusDO($do_number, $requested_by, $approver)
    {
        $sql = "UPDATE
                    KHS_APPROVAL_DO
                SET
                    STATUS = 'Req Approval',
                    REQUEST_BY = '$requested_by',
                    REQUEST_TO = '$approver',
                    REQUEST_DATE = SYSDATE
                WHERE
                    no_do = nvl($do_number, no_do)";
        $query = $this->oracle->query($sql);
    }

    public function getSPBList()
    {
        $sql = "SELECT mtrh.REQUEST_NUMBER           no_spb
                        ,mtrh.FROM_SUBINVENTORY_CODE   from_subinv
                        ,mtrh.TO_SUBINVENTORY_CODE     to_subinv
                from mtl_txn_request_headers mtrh
                    ,mtl_txn_request_lines mtrl
                where mtrh.HEADER_ID = mtrl.HEADER_ID
                    and mtrl.TRANSACTION_TYPE_ID = 327     
                    and mtrl.LINE_STATUS in (3,7)
                    and mtrh.HEADER_STATUS in (3,7)
                    and nvl(mtrl.QUANTITY_DETAILED,0) = 0
                    and nvl(mtrl.QUANTITY_DELIVERED,0) = 0
                    and mtrh.FROM_SUBINVENTORY_CODE = 'FG-TKS'
                group by
                    mtrh.REQUEST_NUMBER
                    ,mtrh.FROM_SUBINVENTORY_CODE
                    ,mtrh.TO_SUBINVENTORY_CODE";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function createApprovalSPB($spb_number)
    {
        $sql = "INSERT INTO
                    KHS_APPROVAL_DO (no_do, creation_date)
                VALUES
                    ($spb_number, SYSDATE)";
        $query = $this->oracle->query($sql);
    }

    public function updateStatusSPB($spb_number, $requested_by, $approver)
    {
        $sql = "UPDATE
                    KHS_APPROVAL_DO
                SET
                    STATUS = 'Req Approval',
                    REQUEST_BY = '$requested_by',
                    REQUEST_TO = '$approver',
                    REQUEST_DATE = SYSDATE
                WHERE
                    no_do = nvl($spb_number, no_do)";
        $query = $this->oracle->query($sql);
    }


}