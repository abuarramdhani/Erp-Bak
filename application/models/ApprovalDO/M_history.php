<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_history extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        
		$this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getRequestedDOList()
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
                and kad.STATUS = 'Req Approval'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getApprovedDOList()
    {
        $sql = "SELECT distinct kad.NO_DO      no_do,
                        kad.NO_SO      no_so,
                        to_char(kad.REQUEST_DATE,'DD-MON-YYYY hh24:mi:ss') request_date,
                        (select distinct ppfs.FIRST_NAME ||' '|| ppfs.LAST_NAME
                            from per_people_f   ppfs
                            where kad.REQUEST_BY = ppfs.NATIONAL_IDENTIFIER) request_by,
                        to_char(kad.APPROVED_DATE,'DD-MON-YYYY hh24:mi:ss') approved_date,
                        ppf.FIRST_NAME ||' '|| ppf.LAST_NAME approved_by,
                        kad.STATUS     status
                from khs_approval_do kad
                ,per_people_f   ppf
                where kad.APPROVED_BY = ppf.NATIONAL_IDENTIFIER
                and kad.STATUS = 'Approved'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
    public function getRejectedDOList()
    {
        $sql = "SELECT distinct kad.NO_DO      no_do,
                        kad.NO_SO      no_so,
                        to_char(kad.REQUEST_DATE,'DD-MON-YYYY hh24:mi:ss') request_date,
                        (select distinct ppfs.FIRST_NAME ||' '|| ppfs.LAST_NAME
                            from per_people_f   ppfs
                            where kad.REQUEST_BY = ppfs.NATIONAL_IDENTIFIER) request_by,
                        to_char(kad.APPROVED_DATE,'DD-MON-YYYY hh24:mi:ss') reject_date,
                        ppf.FIRST_NAME ||' '|| ppf.LAST_NAME approved_by,
                        kad.STATUS     status
                from khs_approval_do kad
                ,per_people_f   ppf
                where kad.APPROVED_BY = ppf.NATIONAL_IDENTIFIER
                and kad.STATUS = 'Reject'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getPendingDOList()
    {
        $sql = "SELECT distinct kad.NO_DO      no_do,
                        kad.NO_SO      no_so,
                        to_char(kad.REQUEST_DATE,'DD-MON-YYYY hh24:mi:ss') request_date,
                        (select distinct ppfs.FIRST_NAME ||' '|| ppfs.LAST_NAME
                            from per_people_f   ppfs
                            where kad.REQUEST_BY = ppfs.NATIONAL_IDENTIFIER) request_by,
                        to_char(kad.APPROVED_DATE,'DD-MON-YYYY hh24:mi:ss') pending_date,
                        ppf.FIRST_NAME ||' '|| ppf.LAST_NAME pending_by,
                        kad.STATUS     status
                from khs_approval_do kad
                ,per_people_f   ppf
                where kad.APPROVED_BY = ppf.NATIONAL_IDENTIFIER
                and kad.STATUS = 'Pending'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

}