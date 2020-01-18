<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_approval extENDs CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        
		$this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getRequestedDOListById($id)
    {
        $sql = "SELECT distinct kad.NO_DO      no_do,
                                kad.NO_SO      no_so,
                                to_char(kad.REQUEST_DATE,'DD-MON-YYYY hh24:mi:ss') request_date,
                                ppf.FIRST_NAME ||' '|| ppf.LAST_NAME request_by,
                                (select distinct ppfs.FIRST_NAME ||' '|| ppfs.LAST_NAME
                                    from per_people_f   ppfs
                                    where kad.REQUEST_TO = ppfs.NATIONAL_IDENTIFIER) request_to,
                                kad.STATUS     status
                from khs_approval_do kad
                    ,per_people_f   ppf
                where kad.REQUEST_BY = ppf.NATIONAL_IDENTIFIER
                and kad.STATUS = 'Req Approval'
                and kad.REQUEST_TO = '$id'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function updateStatusDOApprove($do_number, $approved_by)
    {
        $sql = "UPDATE
                    KHS_APPROVAL_DO
                SET
                    STATUS = 'Approved',
                    APPROVED_BY = '$approved_by',
                    APPROVED_DATE = SYSDATE
                WHERE
                    no_do = nvl($do_number, no_do)";
        $query = $this->oracle->query($sql);
    }

    public function updateStatusDOReject($do_number, $approved_by)
    {
        $sql = "UPDATE
                    KHS_APPROVAL_DO
                SET
                    STATUS = 'Reject',
                    APPROVED_BY = '$approved_by',
                    APPROVED_DATE = SYSDATE
                WHERE
                    no_do = nvl($do_number, no_do)";
        $query = $this->oracle->query($sql);
    }

    public function updateStatusDOPending($do_number, $approved_by)
    {
        $sql = "UPDATE
                    KHS_APPROVAL_DO
                SET
                    STATUS = 'Pending',
                    APPROVED_BY = '$approved_by',
                    APPROVED_DATE = SYSDATE
                WHERE
                    no_do = nvl($do_number, no_do)";
        $query = $this->oracle->query($sql);
    }

}