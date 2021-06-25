<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_pusat extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->oracle = $this->load->database('oracle', TRUE);
    }

    public function getInfoTarget($month)
    {
        $query = $this->oracle->query("SELECT * FROM KHS_LPB_TARGETS WHERE TO_CHAR(CREATION_DATE, 'mm-yyyy') = '$month'");
        return $query->result_array();
    }

    public function insertTarget($cabang, $target)
    {
        $this->oracle->query("INSERT INTO KHS_LPB_TARGETS klt (klt.BRANCH, klt.TARGET) VALUES ('$cabang',$target)");
    }

    public function editTarget($targetid, $target)
    {
        $this->oracle->query("UPDATE KHS_LPB_TARGETS SET TARGET = $target WHERE TARGET_ID = $targetid");
    }

    public function getInfoTargetCabangAndMonth($cabang, $month)
    {
        $query = $this->oracle->query("SELECT * FROM KHS_LPB_TARGETS WHERE BRANCH = '$cabang' AND TO_CHAR(CREATION_DATE, 'mm-yyyy') = '$month'");
        return $query->row_array();
    }

    public function insertAnalytics($problem, $rootcause, $action, $duedate, $id)
    {
        $this->oracle->query("INSERT INTO KHS_LPB_ANALYS kla (kla.BRANCH, kla.PROBLEM, kla.ROOT_CAUSE, kla.ACTION, kla.DUE_DATE) values ('$id', '$problem', '$rootcause', '$action',TO_DATE('$duedate', 'DD-MM-YYYY'))");
    }

    public function editInfoPasar($info, $cabang)
    {
        $this->oracle->query("UPDATE KHS_LPB_MARKET SET DESCRIPTION = '$info' WHERE MARKET_ID = $cabang");
    }

    public function editFileInfoPasar($reportid, $pathimg)
    {
        $this->oracle->query("UPDATE KHS_LPB_REPORT SET ATTACHMENT = '$pathimg' WHERE REPORT_ID = $reportid");
    }

    public function getAnalysReport($cabang)
    {
        $query = $this->oracle->query("WITH data_hari AS
                                        (SELECT hari.curr_date, TO_CHAR (hari.curr_date, 'FMDAY') hari
                                            FROM (SELECT     LEVEL,
                                                            TO_DATE ('01' || TO_CHAR (SYSDATE, 'mm/yyyy'),
                                                                        'dd/mm/yyyy'
                                                                    )
                                                            + LEVEL
                                                            - 1 curr_date
                                                        FROM DUAL
                                                CONNECT BY LEVEL <=
                                                                TO_DATE (LAST_DAY (SYSDATE))
                                                                - TO_DATE ('01' || TO_CHAR (SYSDATE, 'mm/yyyy'),
                                                                        'dd/mm/yyyy'
                                                                        )
                                                                + 1) hari),
                                        data_hari2 AS
                                        (SELECT ( -- get last saturday before sysdate
                                                SELECT DISTINCT MAX (curr_date)
                                                            FROM data_hari
                                                            WHERE hari = 'SATURDAY'
                                                            AND TRUNC (curr_date) < TRUNC (SYSDATE)) last_sat,
                                                TO_DATE (SYSDATE) curr_date
                                            FROM DUAL),
                                        data_hari3 AS
                                        (SELECT     LEVEL, TRUNC (last_sat + (LEVEL - 1)) days
                                                FROM data_hari2
                                        CONNECT BY LEVEL <=
                                                        curr_date
                                                        - (  last_sat
                                                        - CASE
                                                                WHEN (SELECT COUNT (*)
                                                                        FROM khs_lpb_analys
                                                                    WHERE branch = '$cabang'
                                                                        AND TRUNC (creation_date) =
                                                                                                TRUNC (SYSDATE)) =
                                                                                                                1
                                                                THEN 1
                                                                ELSE 0
                                                            END
                                                        ))
                                    SELECT to_char(d3.days, 'DD-MM-YYYY') days, 
                                            nvl(to_char(klm.analys_id), '-') analys_id,
                                            nvl(klm.branch,'-') branch,
                                            nvl(klm.problem,'-') problem,
                                            nvl(klm.root_cause,'-') root_cause,
                                            nvl(klm.action,'-') action,
                                            nvl(to_char(klm.due_date, 'DD-MM-YYYY'), '-') due_date
                                    FROM (SELECT klm1.*, TRUNC(klm1.creation_date) days
                                            FROM khs_lpb_analys klm1
                                            WHERE klm1.branch = '$cabang') klm
                                        RIGHT JOIN
                                        data_hari3 d3 ON klm.days = d3.days
                                    WHERE TO_CHAR (d3.days, 'FMDAY') != 'SUNDAY'
                                    ORDER BY 1");
        return $query->result_array();
    }

    public function getAnalysToday($today, $cabang)
    {
        $query = $this->oracle->query("SELECT * FROM KHS_LPB_ANALYS WHERE BRANCH = '$cabang' AND TO_CHAR(CREATION_DATE, 'dd-mm-yyyy') = '$today' ");
        return $query->row_array();
    }

    public function getViewAnalys($id)
    {
        $query = $this->oracle->query("SELECT ANALYS_ID, CREATION_DATE, PROBLEM, ROOT_CAUSE, ACTION, TO_CHAR(DUE_DATE, 'dd-mm-yyyy') DUE_DATE FROM KHS_LPB_ANALYS WHERE ANALYS_ID = $id");
        return $query->row_array();
    }

    public function editAnalys($id, $problem, $rootcause, $action, $duedate)
    {
        $this->oracle->query("UPDATE KHS_LPB_ANALYS SET PROBLEM = '$problem', ROOT_CAUSE = '$rootcause', ACTION = '$action', DUE_DATE = TO_DATE('$duedate','DD-MM-YYYY') WHERE ANALYS_ID = $id");
    }

    public function getInfoTargetMonth($cabang)
    {
        $query = $this->oracle->query("WITH data_hari AS
                                        (SELECT hari.curr_date, TO_CHAR (hari.curr_date, 'FMDAY') hari
                                            FROM (SELECT     LEVEL,
                                                            TO_DATE ('01' || TO_CHAR (SYSDATE, 'mm/yyyy'),
                                                                        'dd/mm/yyyy'
                                                                    )
                                                            + LEVEL
                                                            - 1 curr_date
                                                        FROM DUAL
                                                CONNECT BY LEVEL <=
                                                                TO_DATE (LAST_DAY (SYSDATE))
                                                                - TO_DATE ('01' || TO_CHAR (SYSDATE, 'mm/yyyy'),
                                                                        'dd/mm/yyyy'
                                                                        )
                                                                + 1) hari),
                                        data_hari2 AS
                                        (SELECT ( -- get last saturday before sysdate
                                                SELECT DISTINCT MAX (curr_date)
                                                            FROM data_hari
                                                            WHERE hari = 'SATURDAY'
                                                            AND TRUNC (curr_date) < TRUNC (SYSDATE)) last_sat,
                                                TO_DATE (SYSDATE) curr_date
                                            FROM DUAL),
                                        data_hari3 AS
                                        (SELECT     LEVEL, TRUNC (last_sat + (LEVEL - 1)) days
                                                FROM data_hari2
                                        CONNECT BY LEVEL <=
                                                        curr_date
                                                        - (  last_sat
                                                        - CASE
                                                                WHEN (SELECT COUNT (*)
                                                                        FROM khs_lpb_market
                                                                    WHERE branch = '$cabang'
                                                                        AND TRUNC (creation_date) =
                                                                                                TRUNC (SYSDATE)) =
                                                                                                                1
                                                                THEN 1
                                                                ELSE 0
                                                            END
                                                        ))
                                    SELECT TO_CHAR(d3.days, 'DD-MM-YYYY') DAYS, 
                                            nvl(to_char(klm.market_id), '-') market_id,
                                            nvl(klm.branch,'-') branch,
                                            nvl(klm.description,'-') description,
                                            nvl(klm.attachment,'-') attachment
                                    FROM (SELECT klm1.*, TRUNC (klm1.creation_date) days
                                            FROM khs_lpb_market klm1
                                            WHERE klm1.branch = '$cabang') klm
                                        RIGHT JOIN
                                        data_hari3 d3 ON klm.days = d3.days
                                    WHERE TO_CHAR (d3.days, 'FMDAY') != 'SUNDAY'
                                    ORDER BY 1 ");
        return $query->result_array();
    }

    public function getInfoTargetToday($today, $cabang)
    {
        $query = $this->oracle->query("SELECT * FROM KHS_LPB_MARKET WHERE BRANCH = '$cabang' AND TO_CHAR(CREATION_DATE, 'dd-mm-yyyy') = '$today' ");
        return $query->row_array();
    }

    public function insertInfoPasar($info, $cabang, $path)
    {
        $this->oracle->query("INSERT INTO KHS_LPB_MARKET (DESCRIPTION, BRANCH, ATTACHMENT) VALUES ('$info', '$cabang', '$path')");
    }

    public function getViewInfoPasar($id)
    {
        $query = $this->oracle->query("SELECT * FROM KHS_LPB_MARKET WHERE MARKET_ID = $id ");
        return $query->row_array();
    }

    public function getInfoPenjualanCabang($cabang)
    {
        $query = $this->oracle->query("WITH data_tgl AS
                                            (SELECT (SELECT COUNT (*) - (SELECT COUNT (*)
                                                    FROM khs_lpb_skip_date
                                                    WHERE EXTRACT (MONTH FROM skip_date) = EXTRACT
                                                            (MONTH FROM khs_lpb_range_date (NULL,2))) jumlah_hari
                                                    FROM (SELECT TO_DATE ('01/' || TO_CHAR (khs_lpb_range_date (NULL,2),'mm/yyyy'),'dd/mm/yyyy')
                                                    + LEVEL - 1 tanggal,
                                                    TO_CHAR(TO_DATE('01/'|| TO_CHAR (khs_lpb_range_date (NULL, 2 ),'mm/yyyy'),'dd/mm/yyyy')
                                                        + LEVEL - 1, 'fmday' ) hari FROM DUAL
                                                        CONNECT BY LEVEL <= TO_NUMBER (TO_CHAR (khs_lpb_range_date (NULL,2),'DD')))
                                                        WHERE hari != 'sunday'
                                                    GROUP BY 1) berjalan,
                                                    (SELECT COUNT (*) - (SELECT COUNT (*) FROM khs_lpb_skip_date WHERE EXTRACT (MONTH FROM skip_date) =
                                                        EXTRACT (MONTH FROM khs_lpb_range_date (NULL, 2))) jumlah_hari
                                                        FROM (SELECT TO_DATE('01/'||TO_CHAR(khs_lpb_range_date (NULL,2),'mm/yyyy'),'dd/mm/yyyy')
                                                            + LEVEL - 1 tanggal, TO_CHAR (TO_DATE('01/'|| 
                                                            TO_CHAR(khs_lpb_range_date (NULL,2),'mm/yyyy'),'dd/mm/yyyy')+ LEVEL- 1,'fmday') hari
                                                        FROM DUAL CONNECT BY LEVEL <= TO_NUMBER (TO_CHAR (LAST_DAY (khs_lpb_range_date (NULL, 2)),'DD')))
                                                        WHERE hari != 'sunday'
                                                    GROUP BY 1) per_month
                                                FROM DUAL)
                                        SELECT DISTINCT branch, total, target,
                                                        ROUND (total / berjalan) total_per_hari,
                                                        ROUND (target / berjalan) target_per_hari,
                                                        ROUND (total / (target / 100), 2) perbandingan
                                                FROM (SELECT tab.branch,
                                                                (SELECT DISTINCT SUM (klt.quantity) OVER (PARTITION BY cabang)
                                                                                                        total
                                                                            FROM khs_lpb_type klt
                                                                        WHERE klt.request_id =
                                                                                    (SELECT MAX (request_id)
                                                                                        FROM khs_lpb_type)
                                                                            AND klt.status = 'TOTAL'
                                                                            AND klt.cabang = tab.branch) total,
                                                                (select klts.target
                                                                from khs_lpb_targets klts
                                                                where klts.branch = tab.branch
                                                                    and extract(month from klts.creation_date) = extract(month from khs_lpb_range_date(null, 2))
                                                                    and extract(year from klts.creation_date) = extract(year from khs_lpb_range_date(null, 2))         
                                                                ) target
                                                        FROM khs_lpb_targets tab
                                                        WHERE extract(month from tab.creation_date) = extract(month from khs_lpb_range_date(null, 2))
                                                        and extract(year from tab.creation_date) = extract(year from khs_lpb_range_date(null, 2))
                                                        ),
                                                        data_tgl
                                        WHERE BRANCH = '$cabang'");
        return $query->row_array();
    }

    public function editInfoPasarAndFile($cabang, $info, $path)
    {
        $this->oracle->query("UPDATE KHS_LPB_MARKET SET DESCRIPTION = '$info', ATTACHMENT = '$path' WHERE MARKET_ID = $cabang");
    }

    public function getInfoPasarReport($cabang)
    {
        $query = $this->oracle->query("WITH data_hari AS
                                    (SELECT hari.curr_date, TO_CHAR (hari.curr_date, 'FMDAY') hari
                                        FROM (SELECT     LEVEL,
                                                        TO_DATE ('01' || TO_CHAR (SYSDATE, 'mm/yyyy'),
                                                                    'dd/mm/yyyy'
                                                                )
                                                        + LEVEL
                                                        - 1 curr_date
                                                    FROM DUAL
                                            CONNECT BY LEVEL <=
                                                            TO_DATE (LAST_DAY (SYSDATE))
                                                            - TO_DATE ('01' || TO_CHAR (SYSDATE, 'mm/yyyy'),
                                                                    'dd/mm/yyyy'
                                                                    )
                                                            + 1) hari),
                                    data_hari2 AS
                                    (SELECT ( -- get last saturday before sysdate
                                            SELECT DISTINCT MAX (curr_date)
                                                        FROM data_hari
                                                        WHERE hari = 'SATURDAY'
                                                        AND TRUNC (curr_date) < TRUNC (SYSDATE)) last_sat,
                                            TO_DATE (SYSDATE) curr_date
                                        FROM DUAL),
                                    data_hari3 AS
                                    (SELECT     LEVEL, TRUNC (last_sat + (LEVEL - 1)) days
                                            FROM data_hari2
                                    CONNECT BY LEVEL <=
                                                    curr_date
                                                    - (  last_sat
                                                    - CASE
                                                            WHEN (SELECT COUNT (*)
                                                                    FROM khs_lpb_market
                                                                WHERE branch = '$cabang'
                                                                    AND TRUNC (creation_date) =
                                                                                            TRUNC (SYSDATE)) =
                                                                                                            1
                                                            THEN 1
                                                            ELSE 0
                                                        END
                                                    ))
                                SELECT to_char(d3.days,'DD-MM-YYYY') days, 
                                        nvl(to_char(klm.market_id), '-') market_id,
                                        nvl(klm.branch,'-') branch,
                                        nvl(klm.description,'-') description,
                                        nvl(klm.attachment,'-') attachment
                                FROM (SELECT klm1.*, TRUNC (klm1.creation_date) days
                                        FROM khs_lpb_market klm1
                                        WHERE klm1.branch = '$cabang') klm
                                    RIGHT JOIN
                                    data_hari3 d3 ON klm.days = d3.days
                                WHERE TO_CHAR (d3.days, 'FMDAY') != 'SUNDAY'
                                ORDER BY 1");
        return $query->result_array();
    }
}