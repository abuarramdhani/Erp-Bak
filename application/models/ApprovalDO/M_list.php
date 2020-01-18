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
        $sql = "SELECT DISTINCT
                    wdd.BATCH_ID,
                    wdd.SOURCE_HEADER_NUMBER,
                    kad.status
                FROM
                    wsh_delivery_details wdd,
                    khs_approval_do kad
                WHERE
                    wdd.batch_id = kad.no_do(+)
                    AND wdd.ORG_ID = 82
                    AND wdd.RELEASED_STATUS = 'S'
                    AND kad.status IS NULL
                ORDER BY
                    SOURCE_HEADER_NUMBER";

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

}