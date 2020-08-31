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
        $sql = "SELECT DISTINCT kad.no_do no_do, kad.no_so no_so,
                TO_CHAR (kad.request_date,
                        'DD-MON-YYYY hh24:mi:ss'
                        ) request_date,
                ppf.first_name || ' ' || ppf.last_name request_by,
                (SELECT DISTINCT    ppfs.first_name
                                || ' '
                                || ppfs.last_name
                            FROM per_people_f ppfs
                        WHERE kad.request_to = ppfs.national_identifier)
                                                                request_to,
                (SELECT DISTINCT    ppfs.first_name
                                || ' '
                                || ppfs.last_name
                            FROM per_people_f ppfs
                        WHERE kad.request_to_2 = ppfs.national_identifier)request_to_2,                kad.status status
                        FROM khs_approval_do kad, per_people_f ppf
                        WHERE kad.request_by = ppf.national_identifier
                        AND kad.status IN ('Req Approval', 'Req Approval 2')";

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