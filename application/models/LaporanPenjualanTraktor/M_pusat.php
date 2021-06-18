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
        $query = $this->oracle->query("SELECT *
                                        FROM KHS_LPB_REPORT 
                                        WHERE TO_CHAR(TARGET_CREATION_DATE, 'mm') = '$month'");
        return $query->result_array();
    }

    public function insertTarget($cabang, $target)
    {
        $this->oracle->query("INSERT INTO KHS_LPB_REPORT klr (klr.BRANCH, klr.TARGET) VALUES ('$cabang',$target)");
    }

    public function editTarget($reportid, $target)
    {
        $this->oracle->query("UPDATE KHS_LPB_REPORT SET TARGET = $target WHERE REPORT_ID = $reportid");
    }

    public function getReportCabangAndMonth($cabang, $month)
    {
        $query = $this->oracle->query("WITH data_tgl AS
                                        (SELECT (SELECT     COUNT (*)
                                                        - (SELECT COUNT (*)
                                                                FROM khs_lpb_skip_date
                                                            WHERE EXTRACT (MONTH FROM skip_date) =
                                                                        EXTRACT
                                                                            (MONTH FROM khs_lpb_range_date (NULL,
                                                                                                            2
                                                                                                            )
                                                                            )) jumlah_hari
                                                    FROM (SELECT       TO_DATE
                                                                            (   '01/'
                                                                            || TO_CHAR
                                                                                    (khs_lpb_range_date (NULL,
                                                                                                            2
                                                                                                        ),
                                                                                        'mm/yyyy'
                                                                                    ),
                                                                            'dd/mm/yyyy'
                                                                            )
                                                                    + LEVEL
                                                                    - 1 tanggal,
                                                                    TO_CHAR
                                                                        (  TO_DATE
                                                                                (   '01/'
                                                                                || TO_CHAR
                                                                                    (khs_lpb_range_date (NULL,
                                                                                                            2
                                                                                                        ),
                                                                                        'mm/yyyy'
                                                                                    ),
                                                                                'dd/mm/yyyy'
                                                                                )
                                                                        + LEVEL
                                                                        - 1,
                                                                        'fmday'
                                                                        ) hari
                                                                FROM DUAL
                                                            CONNECT BY LEVEL <=
                                                                        TO_NUMBER
                                                                            (TO_CHAR (khs_lpb_range_date (NULL,
                                                                                                            2
                                                                                                        ),
                                                                                        'DD'
                                                                                    )
                                                                            ))
                                                    WHERE hari != 'sunday'
                                                GROUP BY 1) berjalan,
                                                (SELECT     COUNT (*)
                                                        - (SELECT COUNT (*)
                                                                FROM khs_lpb_skip_date
                                                            WHERE EXTRACT (MONTH FROM skip_date) =
                                                                        EXTRACT
                                                                            (MONTH FROM khs_lpb_range_date (NULL,
                                                                                                            2
                                                                                                            )
                                                                            )) jumlah_hari
                                                    FROM (SELECT       TO_DATE
                                                                            (   '01/'
                                                                            || TO_CHAR
                                                                                    (khs_lpb_range_date (NULL,
                                                                                                            2
                                                                                                        ),
                                                                                        'mm/yyyy'
                                                                                    ),
                                                                            'dd/mm/yyyy'
                                                                            )
                                                                    + LEVEL
                                                                    - 1 tanggal,
                                                                    TO_CHAR
                                                                        (  TO_DATE
                                                                                (   '01/'
                                                                                || TO_CHAR
                                                                                    (khs_lpb_range_date (NULL,
                                                                                                            2
                                                                                                        ),
                                                                                        'mm/yyyy'
                                                                                    ),
                                                                                'dd/mm/yyyy'
                                                                                )
                                                                        + LEVEL
                                                                        - 1,
                                                                        'fmday'
                                                                        ) hari
                                                                FROM DUAL
                                                            CONNECT BY LEVEL <=
                                                                        TO_NUMBER
                                                                            (TO_CHAR
                                                                                (LAST_DAY
                                                                                        (khs_lpb_range_date (NULL,
                                                                                                            2
                                                                                                            )
                                                                                        ),
                                                                                'DD'
                                                                                )
                                                                            ))
                                                    WHERE hari != 'sunday'
                                                GROUP BY 1) per_month
                                            FROM DUAL)
                                    SELECT DISTINCT report_id,to_char(target_creation_date, 'DD-MM-YYYY') as target_creation_date,branch, total, target,
                                                    ROUND (total / berjalan) total_per_hari,
                                                    ROUND (target / berjalan) target_per_hari,
                                                    ROUND (total / (target / 100), 2) perbandingan,
                                                    problem, root_cause, action, to_char(due_date, 'DD-MM-YYYY') as due_date,
                                                    market_desc, attachment
                                            FROM (SELECT tab.report_id,tab.target_creation_date,tab.branch, tab.market_desc, tab.attachment,
                                                            (SELECT DISTINCT SUM (klt.quantity) OVER (PARTITION BY cabang)
                                                                                                    total
                                                                        FROM khs_lpb_type klt
                                                                    WHERE klt.request_id =
                                                                                (SELECT MAX (request_id)
                                                                                    FROM khs_lpb_type)
                                                                        AND klt.status = 'TOTAL'
                                                                        AND klt.cabang = tab.branch) total,
                                                            tab.target, problem, root_cause, action, due_date
                                                    FROM khs_lpb_report tab),
                                                    data_tgl
                                    WHERE branch = '$cabang'
                                    AND TO_CHAR(target_creation_date, 'mm') = $month");
        return $query->row_array();
    }

    public function insertAnalytics($problem, $rootcause, $action, $duedate, $id)
    {
        $this->oracle->query("UPDATE KHS_LPB_REPORT klr SET klr.PROBLEM = '$problem', klr.ROOT_CAUSE = '$rootcause', klr.ACTION = '$action', klr.DUE_DATE = TO_DATE('$duedate', 'DD-MM-YYYY') WHERE klr.REPORT_ID = $id");
    }

    public function insertInfoPasar($reportid, $info, $pathimg)
    {
        $this->oracle->query("UPDATE KHS_LPB_REPORT SET MARKET_DESC = '$info', ATTACHMENT = '$pathimg' WHERE REPORT_ID = $reportid");
    }

    public function editInfoPasar($info, $reportid)
    {
        $this->oracle->query("UPDATE KHS_LPB_REPORT SET MARKET_DESC = '$info' WHERE REPORT_ID = $reportid");
    }

    public function editFileInfoPasar($reportid, $pathimg)
    {
        $this->oracle->query("UPDATE KHS_LPB_REPORT SET ATTACHMENT = '$pathimg' WHERE REPORT_ID = $reportid");
    }

    public function getReportMonth($month)
    {
        $query = $this->oracle->query("WITH data_tgl AS
     (SELECT (SELECT     COUNT (*)
                       - (SELECT COUNT (*)
                            FROM khs_lpb_skip_date
                           WHERE EXTRACT (MONTH FROM skip_date) =
                                    EXTRACT
                                         (MONTH FROM khs_lpb_range_date (NULL,
                                                                         2
                                                                        )
                                         )) jumlah_hari
                  FROM (SELECT       TO_DATE
                                        (   '01/'
                                         || TO_CHAR
                                                   (khs_lpb_range_date (NULL,
                                                                        2
                                                                       ),
                                                    'mm/yyyy'
                                                   ),
                                         'dd/mm/yyyy'
                                        )
                                   + LEVEL
                                   - 1 tanggal,
                                   TO_CHAR
                                      (  TO_DATE
                                            (   '01/'
                                             || TO_CHAR
                                                   (khs_lpb_range_date (NULL,
                                                                        2
                                                                       ),
                                                    'mm/yyyy'
                                                   ),
                                             'dd/mm/yyyy'
                                            )
                                       + LEVEL
                                       - 1,
                                       'fmday'
                                      ) hari
                              FROM DUAL
                        CONNECT BY LEVEL <=
                                      TO_NUMBER
                                          (TO_CHAR (khs_lpb_range_date (NULL,
                                                                        2
                                                                       ),
                                                    'DD'
                                                   )
                                          ))
                 WHERE hari != 'sunday'
              GROUP BY 1) berjalan,
             (SELECT     COUNT (*)
                       - (SELECT COUNT (*)
                            FROM khs_lpb_skip_date
                           WHERE EXTRACT (MONTH FROM skip_date) =
                                    EXTRACT
                                         (MONTH FROM khs_lpb_range_date (NULL,
                                                                         2
                                                                        )
                                         )) jumlah_hari
                  FROM (SELECT       TO_DATE
                                        (   '01/'
                                         || TO_CHAR
                                                   (khs_lpb_range_date (NULL,
                                                                        2
                                                                       ),
                                                    'mm/yyyy'
                                                   ),
                                         'dd/mm/yyyy'
                                        )
                                   + LEVEL
                                   - 1 tanggal,
                                   TO_CHAR
                                      (  TO_DATE
                                            (   '01/'
                                             || TO_CHAR
                                                   (khs_lpb_range_date (NULL,
                                                                        2
                                                                       ),
                                                    'mm/yyyy'
                                                   ),
                                             'dd/mm/yyyy'
                                            )
                                       + LEVEL
                                       - 1,
                                       'fmday'
                                      ) hari
                              FROM DUAL
                        CONNECT BY LEVEL <=
                                      TO_NUMBER
                                         (TO_CHAR
                                             (LAST_DAY
                                                    (khs_lpb_range_date (NULL,
                                                                         2
                                                                        )
                                                    ),
                                              'DD'
                                             )
                                         ))
                 WHERE hari != 'sunday'
              GROUP BY 1) per_month
        FROM DUAL)
SELECT DISTINCT report_id,target_creation_date,branch, total, target, TO_CHAR(market_creation_date, 'DD Month YYYY') market_creation_date, market_desc, attachment,
                ROUND (total / berjalan) total_per_hari,
                ROUND (target / berjalan) target_per_hari,
                ROUND (total / (target / 100), 2) perbandingan,
                problem, root_cause, action, TO_CHAR(due_date, 'DD Month YYYY') due_date
           FROM (SELECT tab.report_id,tab.target_creation_date,tab.branch,
                        (SELECT DISTINCT SUM (klt.quantity) OVER (PARTITION BY cabang)
                                                                 total
                                    FROM khs_lpb_type klt
                                   WHERE klt.request_id =
                                             (SELECT MAX (request_id)
                                                FROM khs_lpb_type)
                                     AND klt.status = 'TOTAL'
                                     AND klt.cabang = tab.branch) total,
                        tab.target, problem, root_cause, action, due_date, market_creation_date, market_desc, attachment
                   FROM khs_lpb_report tab),
                data_tgl
WHERE TO_CHAR(target_creation_date, 'mm') = $month
ORDER BY REPORT_ID");
        return $query->result_array();
    }
}